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
        $bet_qishu = fmod($LOT['bjtime']-14400, 90);
        if($bet_qishu<=85){
            $bet_qishu = $LOT['bjtime']-$bet_qishu;
            $sql = 'SELECT `class`, `value` FROM `c_odds_data` WHERE `type`=\'JSLH\'';
            $query = $mydata1_db->query($sql);
            $odds = $rate = array();
            while($rows = $query->fetch()){
                $id1 = $rows['class'];
                if(isset($LOT['odds'][$id1])){
                    $rows['value'] = unserialize($rows['value']);
                    if($LOT['odds'][$id1][0][1]=='连码'){
                        foreach($LOT['odds'][$id1][1] as $id2=>$val){
                            $key = show_id($id1, $id2);
                            if(isset($rows['value'][1])){
                                $odds[$key] = floatval($rows['value'][1]['odds']);
                                $rate[$key] = floatval($rows['value'][0]['odds']);
                            }else{
                                $odds[$key] = floatval($rows['value'][0]['odds']);
                            }
                        }
                    }else{
                        $rows['lunar'] = -1;
                        foreach($rows['value'] as $id2=>$val){
                            $key = show_id($id1, $id2);
                            if($val['class']=='生肖年'&&$rows['lunar']!=-1){
                                $odds[$rows['lunar']] = floatval($val['odds']);
                            }else if(isset($LOT['odds'][$id1][1][$id2])){
                                $odds[$key] = floatval($val['odds']);
                                $val['class']==$LOT['lunar']&&$rows['lunar'] = $key;
                            }
                        }
                    }
                }
            }
            $order = array();
            $bet_money = 0;
            foreach($LOT['input']['betParameters'] as $val){
                if(isset($odds[$val['Id']])){
                    $lines2 = 0;
                    $key = substr('0000'.$val['Id'], -4);
                    $id1 = intval(substr($key, 0, 2));
                    $id2 = intval(substr($key, 2));
                    $valid = false;
                    if(isset($val['BetContext'])&&is_array($val['BetContext'])){
                        switch ($LOT['odds'][$id1][0][0]) {
                            // 过关
                            case '过关':
                                if(count($val['BetContext'])>1&&count($val['BetContext'])<=8){
                                    $class = [];
                                    $lines = 1;
                                    $min = $LOT['odds'][$id1][0][2];
                                    $max = $LOT['odds'][$id1][0][3];
                                    foreach($val['BetContext'] as $bet){
                                        $key = substr('0000'.$bet['Id'], -4);
                                        $id1 = intval(substr($key, 0, 2));
                                        $id2 = intval(substr($key, 2));
                                        if(check_odds($id1, $id2, $min, $max)){
                                            if($odds[$bet['Id']]==floatval($bet['Lines'])){
                                                $class[] = $LOT['odds'][$id1][0][1].'-'.$LOT['odds'][$id1][1][$id2].'@'.$odds[$bet['Id']];
                                                $lines*= $odds[$bet['Id']];
                                            }else{
                                                $bet_money = 0;
                                                result('<span style="color:red">{0}</span><br />请您重新确认投注', 9, $bet['Id']);
                                                break 3;
                                            }
                                        }else{
                                            $bet_money = 0;
                                            result('内容有误，请刷新页面重试');
                                            break 3;
                                        }
                                    }
                                    $lines = round($lines, 2);
                                    $valid = true;
                                    $class = implode(',', $class);
                                }else{
                                    $bet_money = 0;
                                    result('只能选择2-8个号码');
                                    break 2;
                                }
                                break;
                            // 生肖连中连不中
                            case '二肖连中':
                            case '三肖连中':
                            case '四肖连中':
                            case '五肖连中':
                            case '二肖连不中':
                            case '三肖连不中':
                            case '四肖连不中':
                            // 尾数连中连不中
                            case '二尾连中':
                            case '三尾连中':
                            case '四尾连中':
                            case '二尾连不中':
                            case '三尾连不中':
                            case '四尾连不中':
                            // 合肖
                            case '二肖':
                            case '三肖':
                            case '四肖':
                            case '五肖':
                            case '六肖':
                            case '七肖':
                            case '八肖':
                            case '九肖':
                            case '十肖':
                            case '十一肖':
                            // 全不中
                            case '五不中':
                            case '六不中':
                            case '七不中':
                            case '八不中':
                            case '九不中':
                            case '十不中':
                            case '十一不中':
                            case '十二不中':
                            // 连码
                            case '三全中':
                            case '三中二':
                            case '二全中':
                            case '二中特':
                            case '特串':
                            case '四中一':
                                if(count($val['BetContext'])==$LOT['odds'][$id1][0][4]){
                                    $max = $min = $id1;
                                    $lines = $class = [];
                                    $lines2 = [];
                                    foreach($val['BetContext'] as $bet){
                                        $key = substr('0000'.$bet['Id'], -4);
                                        $id1 = intval(substr($key, 0, 2));
                                        $id2 = intval(substr($key, 2));
                                        if(check_odds($id1, $id2, $min, $max)){
                                            $class[] = $LOT['odds'][$id1][1][$id2];
                                            $lines[] = $odds[$bet['Id']];
                                            isset($rate[$bet['Id']])&&$lines2[] = $rate[$bet['Id']];
                                        }
                                    }
                                    $lines = min($lines);
                                    $lines2 = empty($lines2)?0:min($lines2);
                                    $class = array_unique($class);
                                    if(count($class)!=$LOT['odds'][$min][0][4]){
                                        $bet_money = 0;
                                        result('内容有误，请刷新页面重试');
                                        break 2;
                                    }else if($lines==floatval($val['Lines'])){
                                        $valid = true;
                                        $class = implode(',', $class);
                                    }else{
                                        $bet_money = 0;
                                        result('<span style="color:red">{0}</span><br />请您重新确认投注', 9, $val['Id']);
                                        break 2;
                                    }
                                }else{
                                    $bet_money = 0;
                                    result('内容有误，请刷新页面重试');
                                    break 2;
                                }
                                break;
                            default:
                                $bet_money = 0;
                                result('内容有误，请刷新页面重试');
                                break 2;
                        }
                    }else if($odds[$val['Id']]==floatval($val['Lines'])){
                        // 常规
                        if(check_odds($id1, $id2)){
                            $lines = $odds[$val['Id']];
                            $class = $LOT['odds'][$id1][1][$id2];
                            isset($LOT['odds'][$id1][0][1])&&$class = $LOT['odds'][$id1][0][1].'-'.$class;
                            $valid = true;
                        }
                    }else{
                        $bet_money = 0;
                        result('<span style="color:red">{0}</span><br />请您重新确认投注', 9, $val['Id']);
                        break;
                    }
                    if($valid){
                        $val['Money'] = abs($val['Money']);
                        $bet_money+= $val['Money'];
                        $order[] = array(
                            ':uid' => $LOT['user']['uid'],
                            ':type' => 'JSLH',
                            ':qishu' => $bet_qishu,
                            ':addtime' => $LOT['mdtime'],
                            ':money' => floor($val['Money']*100),
                            ':win' => floor($val['Money']*$lines*100),
                            ':value' => serialize(array(
                                'username' => $LOT['user']['username'],
                                'odds' => $lines,
                                'rate' => [$lines, $lines2],
                                'qishu' => date('Ymd', $bet_qishu).substr('000'.(floor(fmod($bet_qishu-14400, 86400)/90)+1), -3),
                                'class' => [$LOT['odds'][$id1][0][0], $class],
                            )),
                        );
                    }
                }else{
                    $bet_money = 0;
                    result('内容有误，请刷新页面重试');
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
                            ':gameType' => 'JSLH',
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