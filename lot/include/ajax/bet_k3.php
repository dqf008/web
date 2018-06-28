<?php
!defined('IN_LOT') && die('Access Denied');
$tzclosetime =60;
if($lotteryType=='jxk3'){
    $tzclosetime =180;
}
if (isMobile()) $LOT = convertOdd($LOT);
switch (false) {
    case $LOT['user']['login']:
        result('请先登录网站');
        break;

    case $web_site['klsf'] == 0:
        result('系统维护，暂停下注');
        break;
    case $LOT['input']['qiHao']:
        result('投注期数不能为空');
        break;
    case isset($LOT['input']['betParameters']) && !empty($LOT['input']['betParameters']):
        result('请选择一个玩法');
        break;

    case check_order():
        break;
    default:
        $lotteryType = $LOT['lottery_type'];
        $qihao = $LOT['input']['qiHao'];
        $params = array(':name'=>$lotteryType,':qihao'=>$qihao);

        $sql = 'select * from `lottery_k3` where `name`=:name and `next_qihao`=:qihao order by qihao desc limit 1';
        $stmt =$mydata1_db->prepare($sql);
        $stmt->execute($params);
        if ($stmt->rowCount() >0) {  //如果最近一期不存在返回退出
            $cpkjinfo = $stmt->fetch();
            $leftTime   = $cpkjinfo['next_draw'] - $LOT['mdtime'] - $tzclosetime;
            if ($leftTime <= 0) {
                result('当前期号已过投注期！');
                break;
            }
        } else {//否则
            // 查找当前期号最新一期没有开奖的采种
            $lastestSql ="select * from `lottery_k3` where `name`='$lotteryType' and `ok`=0 order by qihao desc limit 1";
            $st = $mydata1_db->query($lastestSql);
            if($st->rowCount()) {
               $lastInfo = $st->fetch();
               if ($qihao < $lastInfo['qihao']) {
                   result('已经封盘，禁止下注');
                   break;
               }
           }
        }
        $bet_qishu = $qihao;
        $sql       = "SELECT * FROM `lottery_odds` where `class1`='$lotteryType' ORDER BY `id` ASC";
        $query     = $mydata1_db->query($sql);
        $class1    = [];
        while ($rows = $query->fetch()) {
            !isset($class1[$rows['class2']]) && $class1[$rows['class2']] = [];
            $class1[$rows['class2']][$rows['class3']] = floatval($rows['odds']);
        }
        foreach ($LOT['odds'] as $id1 => $val) {
            $k1 = $val[0];
            foreach ($val[1] as $id2 => $key) {
                !isset($class1[$k1][$key]) && $class1[$k1][$key] = 0;
                $id2        = intval($id1 . substr('00' . $id2, -2));
                $odds[$id2] = $class1[$k1][$key];
            }
        }
        $order     = [];
        $bet_money = 0;
        $agent     = 0;
        if ($LOT['user']['agents'] > 0) {
            $agent = $LOT['user']['agents'];
        }
        foreach ($LOT['input']['betParameters'] as $val) {
            if (isset($odds[$val['Id']]) && $odds[$val['Id']] == floatval($val['Lines'])) {
                $key = substr('0000' . $val['Id'], -4);
                $id1 = intval(substr($key, 0, 2));
                $id2 = intval(substr($key, 2));
                if (check_odds($id1, $id2)) {
                    $val['Money'] = abs($val['Money']);
                    $bet_money    += $val['Money'];
                    $order[]      = [
                        ':mid'      => $bet_qishu,
                        ':uid'      => $LOT['user']['uid'],
                        ':atype'    => $lotteryType,
                        ':btype'    => $LOT['odds'][$id1][0],
                        ':ctype'    => isset($LOT['odds'][$id1][1][$id2]) ? $LOT['odds'][$id1][1][$id2] : $LOT['odds'][$id1][$id2],
                        ':dtype'    => '',
                        ':content'  => $val['BetContext'],
                        ':money'    => $val['Money'],
                        ':odds'     => $odds[$val['Id']],
                        ':win'      => $val['Money'] * $odds[$val['Id']],
                        ':username' => $LOT['user']['username'],
                        ':agent'    => $agent,
                        ':bet_date' => date('Y-m-d', $LOT['mdtime']),
                        ':bet_time' => date('Y-m-d H:i:s', $LOT['mdtime'])
                    ];
                } else {
                    $bet_money = 0;
                    result('内容有误，请刷新页面重试');
                    break;
                }
            } else {
                $bet_money = 0;
                result('<span style="color:red">{0}</span><br />请您重新确认投注', 9, $val['Id']);
                break;
            }
        }
        if ($bet_money > 0) {
            $last_money = update_money($LOT['user']['uid'], $bet_money);
            if ($last_money > 0) {
                foreach ($order as $params) {
                    if ($lotteryType == 'ffk3' || $lotteryType == 'sfk3') {
                        $stmt = $mydata1_db->prepare('INSERT INTO `c_bet_data` (`uid`, `type`, `qishu`, `addtime`, `money`, `win`, `value`, `status`) VALUES (:uid, :type, :qishu, :addtime, :money, :win, :value, 0)');
                        $stmt->execute($params);
                        $last_id          = $mydata1_db->lastInsertId();
                        $params[':money'] /= 100;
                    } else {
                        $stmt = $mydata1_db->prepare('INSERT INTO `lottery_data` (`mid`, `uid`, `atype`, `btype`, `ctype`, `dtype`, `content`, `money`, `odds`, `win`, `username`, `agent`, `bet_date`, `bet_time`) VALUES (:mid, :uid, :atype, :btype, :ctype, :dtype, :content, :money, :odds, :win, :username, :agent, :bet_date, :bet_time)');
                        $stmt->execute($params);
                        $last_id = $mydata1_db->lastInsertId();
                    }

                    $stmt = $mydata1_db->prepare('INSERT INTO `k_money_log` (`uid`, `userName`, `gameType`, `transferType`, `transferOrder`, `transferAmount`, `previousAmount`, `currentAmount`, `creationTime`) VALUES (:uid, :userName, :gameType, :transferType, :transferOrder, :transferAmount, :previousAmount, :currentAmount, :creationTime)');
                    $stmt->execute([
                        ':uid'            => $LOT['user']['uid'],
                        ':userName'       => $LOT['user']['username'],
                        ':gameType'       => strtoupper($lotteryType),
                        ':transferType'   => 'BET',
                        ':transferOrder'  => 'LOT_' . $last_id,
                        ':transferAmount' => -1 * $params[':money'],
                        ':previousAmount' => $last_money,
                        ':currentAmount'  => $last_money - $params[':money'],
                        ':creationTime'   => date('Y-m-d H:i:s'),
                    ]);
                    $last_money -= $params[':money'];
                    $last_money -= $params[':money'];
                }
                result('投注成功', 1);
            } else {
                result('投注金额超过余额');
            }
        }

}


function convertOdd($LOT)
{
    if (!empty($LOT['input']['betParameters'])) {
        foreach ($LOT['input']['betParameters'] as $key => &$value) {
            $value['BetContext'] = preg_replace("/\s/", "", $value['BetContext']);
            if (in_array($value['Id'], ['5021', '5022', '5023', '5024', '5025', '5026'])) {
                $value['Id'] = '502';
            }
            if (in_array($value['Id'], ['4021', '4022', '4023', '4024'])) {
                $value['Id'] = '402';
            }
            if (in_array($value['Id'], ['3011', '3012', '3013', '3014', '3015', '3016'])) {
                $value['Id'] = '301';
            }
            if ($value['Id'] >= '3021' && $value['Id'] <= '3050') {
                $value['Id'] = '302';
            }
            if ($value['BetContext'] == '三连号通选') {
                $value['BetContext'] = '3LHTX';
            }
            if ($value['BetContext'] == '三同号通选') {
                $value['BetContext'] = '3THTX';
            }
        }
    } else {
        result('<span style="color:red">{0}</span><br />请您重新确认投注', 9, 1);
    }

    return $LOT;
}

empty($LOT['output']) && result('系统错误，请刷新页面重试');