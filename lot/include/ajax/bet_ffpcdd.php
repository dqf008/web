<?php
!defined('IN_LOT')&&die('Access Denied');
switch(false){
    case $LOT['user']['login']:
        result('请先登录网站');
        break;

    case $web_site['pcdd']==0:
        result('系统维护，暂停下注');
        break;

    case isset($LOT['input']['betParameters'])&&!empty($LOT['input']['betParameters']):
        result('请选择一个玩法');
        break;

    case check_order():
        break;

    default:
        $lotteryType = isset($_REQUEST['lottery_type'])?$_REQUEST['lottery_type']:'ffpcdd';
        $params = array(':kaipan' => date('H:i:s', $LOT['bjtime']), ':fengpan' => date('H:i:s', $LOT['bjtime']),':name'=>$lotteryType);
        $sql = "SELECT `qihao` FROM `c_opentime_ffpcdd` WHERE `kaipan`<=:kaipan AND `fengpan`>=:fengpan and `name`=:name ORDER BY `fengpan` ASC";
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        if($stmt->rowCount()>0){
            $rows = $stmt->fetch();
            $bet_qishu = getQiHao($lotteryType,$rows['qihao']);
            /* 加载赔率信息 */
            $sql = "SELECT * FROM `lottery_odds` WHERE `class1`='$lotteryType' ORDER BY `id` ASC";
            $query = $mydata1_db->query($sql);
            $class1 = array();
            while($rows = $query->fetch()){
                !isset($class1[$rows['class2']])&&$class1[$rows['class2']] = array();
                $class1[$rows['class2']][$rows['class3']] = floatval($rows['odds']);
            }
            foreach($LOT['odds'] as $id1=>$val){
                $k1 = $val[0];
                foreach($val[1] as $id2=>$key){
                    !isset($class1[$k1][$key])&&$class1[$k1][$key] = 0;
                    $id2 = intval($id1.substr('00'.$id2, -2));
                    $odds[$id2] = $class1[$k1][$key];
                }
            }
            $order = array();
            $bet_money = 0;
            foreach($LOT['input']['betParameters'] as $val){
                if(isset($odds[$val['Id']])&&$odds[$val['Id']]==floatval($val['Lines'])){
                    $key = substr('0000'.$val['Id'], -4);
                    $id1 = intval(substr($key, 0, 2));
                    $id2 = intval(substr($key, 2));
                    if(check_odds($id1, $id2)){
                        $val['Money'] = abs($val['Money']);
                        $bet_money+= $val['Money'];
                        $order[] = array(
                            ':mid' => $bet_qishu,
                            ':uid' => $LOT['user']['uid'],
                            ':atype' => $lotteryType,
                            ':btype' => $LOT['odds'][$id1][0],
                            ':ctype' => isset($LOT['odds'][$id1][1][$id2])?$LOT['odds'][$id1][1][$id2]:$LOT['odds'][$id1][$id2],
                            ':dtype' => '',
                            ':content' => $LOT['odds'][$id1][1][$id2],
                            ':money' => $val['Money'],
                            ':odds' => $odds[$val['Id']],
                            ':win' => $val['Money']*$odds[$val['Id']],
                            ':username' => $LOT['user']['username'],
                            ':agent' => $LOT['user']['agents'],
                            ':bet_date' => date('Y-m-d', $LOT['mdtime']),
                            ':bet_time' => date('Y-m-d H:i:s', $LOT['mdtime'])
                        );
                    }else{
                        $bet_money = 0;
                        result('内容有误，请刷新页面重试');
                        break;
                    }
                }else{
                    $bet_money = 0;
                    result('您下注的<span style="color:red">{0}</span>赔率发生变化，请您重新投注', 9, $val['Id']);
                    break;
                }
            }
            if($bet_money>0){
                $last_money = update_money($LOT['user']['uid'], $bet_money);
                if($last_money>0){
                    foreach($order as $params){
                        $stmt = $mydata1_db->prepare('INSERT INTO `lottery_data` (`mid`, `uid`, `atype`, `btype`, `ctype`, `dtype`, `content`, `money`, `odds`, `win`, `username`, `agent`, `bet_date`, `bet_time`) VALUES (:mid, :uid, :atype, :btype, :ctype, :dtype, :content, :money, :odds, :win, :username, :agent, :bet_date, :bet_time)');
                        $stmt->execute($params);
                        $last_id = $mydata1_db->lastInsertId();
                        $stmt = $mydata1_db->prepare('INSERT INTO `k_money_log` (`uid`, `userName`, `gameType`, `transferType`, `transferOrder`, `transferAmount`, `previousAmount`, `currentAmount`, `creationTime`) VALUES (:uid, :userName, :gameType, :transferType, :transferOrder, :transferAmount, :previousAmount, :currentAmount, :creationTime)');
                        $stmt->execute(array(
                            ':uid' => $LOT['user']['uid'],
                            ':userName' => $LOT['user']['username'],
                            ':gameType' => strtoupper($lotteryType),
                            ':transferType' => 'BET',
                            ':transferOrder' => 'LOT_'.$last_id,
                            ':transferAmount' => -1*$params[':money'],
                            ':previousAmount' => $last_money,
                            ':currentAmount' => $last_money-$params[':money'],
                            ':creationTime' => date('Y-m-d H:i:s'),
                        ));
                        $last_money-= $params[':money'];
                    }
                    result('投注成功', 1);
                }else{
                    result('投注金额超过余额');
                }
            }
        }else{
            result('已经封盘，禁止下注');
        }
        break;
}

empty($LOT['output'])&&result('系统错误，请刷新页面重试');