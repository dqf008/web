<?php
!defined('IN_LOT')&&die('Access Denied');
switch(false){
    case $LOT['user']['login']:
        result('请先登录网站');
        break;

    case $web_site['qxc']==0:
        result('系统维护，暂停下注');
        break;

    case isset($LOT['input']['betParameters'])&&!empty($LOT['input']['betParameters']):
        result('请选择一个玩法');
        break;

    case check_order():
        break;

    default:
        $lotteryType = isset($LOT['lottery_type'])? $LOT['lottery_type']:'wfqxc';
        $params = array(':kaipan' => date('H:i:s', $LOT['bjtime']), ':fengpan' => date('H:i:s', $LOT['bjtime']));
        $sql = "SELECT `qishu` FROM `c_opentime_new_qxc` WHERE `kaipan`<=:kaipan AND `fengpan`>=:fengpan and `name`='$lotteryType' ORDER BY `fengpan` ASC";
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        if($stmt->rowCount()>0){
            $rows = $stmt->fetch();
            $bet_qishu = getQiHao($lotteryType,$rows['qishu']);
            /* 加载赔率信息 */
            $sql = "SELECT * FROM `lottery_odds` WHERE `class1`='$lotteryType' ORDER BY `id` ASC";
            $query = $mydata1_db->query($sql);
            $class1 = array();
            while($rows = $query->fetch()){
                !isset($class1[$rows['class2']])&&$class1[$rows['class2']] = array();
                $class1[$rows['class2']][$rows['class3']] = floatval($rows['odds']);
            }
            $odds = array();
            foreach($LOT['odds'] as $id1=>$val){
                !isset($class1[$val[0]])&&$class1[$val[0]] = array();
                foreach($val[1] as $id2=>$key){
                    !isset($class1[$val[0]][$key])&&$class1[$val[0]][$key] = 0;
                    $id2 = intval($id1.substr('00'.$id2, -2));
                    $odds[$id2] = $class1[$val[0]][$key];
                }
            }
            $order = array();
            $bet_money = 0;
            foreach($LOT['input']['betParameters'] as $val){
                if(isset($odds[$val['Id']])&&$odds[$val['Id']]==floatval($val['Lines'])){
                    $key = substr('0000'.$val['Id'], -4);
                    $id1 = intval(substr($key, 0, 2));
                    $id2 = intval(substr($key, 2));
                    if(check_odds($id1, $id2)&&$bet_num = checkBet($val['BetContext'], $LOT['odds'][$id1][1][$id2])){
                        $val['Money'] = abs($val['Money']);
                        $val['AllMoney'] = $val['Money']*$bet_num;
                        $bet_money+= $val['AllMoney'];
                        $order[] = array(
                            ':mid' => $bet_qishu,
                            ':uid' =>  $LOT['user']['uid'],
                            ':atype' => $lotteryType,
                            ':btype' => $LOT['odds'][$id1][0],
                            ':ctype' => $bet_num.'/'.$val['Money'],
                            ':dtype' => $LOT['odds'][$id1][1][$id2],
                            ':content' => $val['BetContext'],
                            ':money' => $val['AllMoney'],
                            ':odds' => $odds[$val['Id']],
                            ':win' => ($val['AllMoney']*$odds[$val['Id']])-$val['AllMoney'],
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

function checkBet($content, $type){
    $return = 0;
    switch($type){
        case '一定位':
        case '二定位':
        case '三定位':
        case '四定位':
            if(preg_match('/^(\d+|\*)\,(\d+|\*)\,(\d+|\*)\,(\d+|\*)$/', $content, $matches)){
                /* 判断是否存在重复数字 */
                foreach($matches as $key=>$val){
                    if($key==0||$val=='*'){
                        unset($matches[$key]);
                        continue;
                    }else{
                        $t = array_count_values(str_split($val));
                        if(max($t)>1){
                            $return = 0;
                            break 2;
                        }else{
                            $matches[$key] = strlen($val);
                        }
                    }
                }
                if($type=='一定位'){
                    $return = array_sum($matches);
                }else{
                    if(count($matches)==str_replace(array('二定位', '三定位', '四定位'), array(2, 3, 4), $type)){
                        $return = 1;
                        foreach($matches as $val){
                            $return*= $val;
                        }
                    }
                }
            }
            break;
        case '二字现':
        case '三字现':
            if(preg_match('/^\d+$/', $content)&&strlen($content)==str_replace(array('二字现', '三字现'), array(2, 3), $type)){
                $t = array_count_values(str_split($content));
                max($t)==1&&$return = 1;
            }
            break;
    }
    return $return;
}

empty($LOT['output'])&&result('系统错误，请刷新页面重试');