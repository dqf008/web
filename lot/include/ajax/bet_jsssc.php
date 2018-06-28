<?php
!defined('IN_LOT')&&die('Access Denied');
switch(false){
    case $LOT['user']['login']:
        result('请先登录网站');
        break;

    case isset($LOT['input']['betParameters'])&&!empty($LOT['input']['betParameters']):
        result('请选择一个玩法');
        break;

    case check_order():
        break;

    default:
        $bet_qishu = fmod($LOT['bjtime']-14400, 75);
        if($bet_qishu<=70){
            $bet_qishu = $LOT['bjtime']-$bet_qishu;
            $sql = 'SELECT `class`, `value` FROM `c_odds_data` WHERE `type`=\'JSSSC\'';
            $query = $mydata1_db->query($sql);
            $odds = array();
            while($rows = $query->fetch()){
                $id1 = $rows['class'];
                if(isset($LOT['odds'][$id1])){
                    $rows['value'] = unserialize($rows['value']);
                    foreach($rows['value'] as $id2=>$val){
                        $key = show_id($id1, $id2);
                        isset($LOT['odds'][$id1][1][$id2])&&$odds[$key] = floatval($val['odds']);
                    }
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
                            ':uid' => $LOT['user']['uid'],
                            ':type' => 'JSSSC',
                            ':qishu' => $bet_qishu,
                            ':addtime' => $LOT['mdtime'],
                            ':money' => floor($val['Money']*100),
                            ':win' => floor($val['Money']*$odds[$val['Id']]*100),
                            ':value' => serialize(array(
                                'username' => $LOT['user']['username'],
                                'odds' => $odds[$val['Id']],
                                'qishu' => date('Ymd', $bet_qishu).substr('0000'.(floor(fmod($bet_qishu-14400, 86400)/75)+1), -4),
                                'class' => array($LOT['odds'][$id1][0], $LOT['odds'][$id1][1][$id2]),
                            )),
                        );
                    }else{
                        $bet_money = 0;
                        result('内容有误，请刷新页面重试');
                        break;
                    }
                }else{
                    $bet_money = 0;
                    result('<span style="color:red">{0}</span><br />请您重新确认投注', 9, $val['Id']);
                    break;
                }
            }
            if($bet_money>0){
                $last_money = update_money($LOT['user']['uid'], $bet_money);
                if($last_money>0){
                    foreach($order as $params){
                        $stmt = $mydata1_db->prepare('INSERT INTO `c_bet_data` (`uid`, `type`, `qishu`, `addtime`, `money`, `win`, `value`, `status`) VALUES (:uid, :type, :qishu, :addtime, :money, :win, :value, 0)');
                        $stmt->execute($params);
                        $last_id = $mydata1_db->lastInsertId();
                        $params[':money']/= 100;
                        $stmt = $mydata1_db->prepare('INSERT INTO `k_money_log` (`uid`, `userName`, `gameType`, `transferType`, `transferOrder`, `transferAmount`, `previousAmount`, `currentAmount`, `creationTime`) VALUES (:uid, :userName, :gameType, :transferType, :transferOrder, :transferAmount, :previousAmount, :currentAmount, :creationTime)');
                        $stmt->execute(array(
                            ':uid' => $LOT['user']['uid'],
                            ':userName' => $LOT['user']['username'],
                            ':gameType' => 'JSSSC',
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