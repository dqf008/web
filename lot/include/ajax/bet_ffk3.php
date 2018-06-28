<?php
!defined('IN_LOT')&&die('Access Denied');
if (isMobile()) $LOT = convertOdd($LOT);
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
        $bet_qishu = fmod($LOT['bjtime']-14400, 60);
        if(($bet_qishu >=55 && $bet_qishu <=60) || ($bet_qishu >=0 && $bet_qishu <=6)){
            result('已经封盘，禁止下注');
            break;
        }
        if($bet_qishu<=60){
            $bet_qishu = $LOT['bjtime']-$bet_qishu;
            $sql = 'SELECT `class`, `value` FROM `c_odds_data` WHERE `type`=\'FFK3\'';
            $query = $mydata1_db->query($sql);
            $odds = array();
            $class1    = [];
            $rows = $query->fetch();
            if(!empty($rows)){
                $rows['value'] = unserialize($rows['value']);
                foreach($rows['value'] as $id2=>$val){
                    !isset($class1[$val['class2']]) && $class1[$val['class2']] = [];
                    $class1[$val['class2']][$val['class3']] = floatval($val['odds']);
                }
            }
            foreach ($LOT['odds'] as $id1 => $val) {
                $k1 = $val[0];
                foreach ($val[1] as $id2 => $key) {
                    !isset($class1[$k1][$key]) && $class1[$k1][$key] = 0;
                    $id2        = intval($id1 . substr('00' . $id2, -2));
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
                        if($id1==1){
                            $type =$LOT['odds'][$id1][0];
                        }else{
                            $type=isset($LOT['odds'][$id1][1][$id2]) ? $LOT['odds'][$id1][1][$id2] : $LOT['odds'][$id1][$id2];
                        }
                        $order[] = array(
                            ':uid' => $LOT['user']['uid'],
                            ':type' => 'FFK3',
                            ':qishu' => $bet_qishu,
                            ':addtime' => $LOT['mdtime'],
                            ':money' => floor($val['Money']*100),
                            ':win' => floor($val['Money']*$odds[$val['Id']]*100),
                            ':value' => serialize(array(
                                'username' => $LOT['user']['username'],
                                'odds' => $odds[$val['Id']],
                                'qishu' => date('Ymd', $bet_qishu).substr('0000'.(floor(fmod($bet_qishu-14400, 86400)/60)+1), -4),
                                'class' => array($type, $val['BetContext']),
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
                            ':gameType' => 'FFK3',
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
empty($LOT['output'])&&result('系统错误，请刷新页面重试');