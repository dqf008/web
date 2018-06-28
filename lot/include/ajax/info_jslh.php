<?php
!defined('IN_LOT')&&die('Access Denied');
$LOT['output']['Success'] = 0;
$LOT['output']['Msg'] = 'Access Denied';

if($LOT['input']['type']=='lines'){
    /* 加载赔率信息 */
    if(isset($LOT['input']['lotteryPan'])&&isset($LOT['input']['panType'])){
        $_pan = isset($LOT['input']['panType'])?intval($LOT['input']['panType']):0;
        if($_pan>0&&isset($LOT['odds'][$_pan])){
            $LOT['output']['Success'] = 1;
            $LOT['output']['Msg'] = '';
            $LOT['output']['Obj']['Lines'] = array(); //赔率
            $LOT['output']['Obj']['OpenCountdown'] = $LOT['six']['opentime'];
            $LOT['output']['Obj']['CloseCountdown'] = $LOT['six']['opentime']-5;

            /* 加载赔率信息 */
            if(isset($LOT['odds'][$_pan][0][2])&&isset($LOT['odds'][$_pan][0][3])){
                $sql = 'SELECT `class`, `value` FROM `c_odds_data` WHERE `type`=:type AND `class` BETWEEN CONVERT(:class1, SIGNED) AND CONVERT(:class2, SIGNED) ORDER BY `id` ASC';
                $params = [
                    ':type' => 'JSLH',
                    ':class1' => $LOT['odds'][$_pan][0][2],
                    ':class2' => $LOT['odds'][$_pan][0][3]
                ];
                $_pan = $LOT['odds'][$_pan][0][2];
                $_end = $LOT['odds'][$_pan][0][3];
            }else{
                $sql = 'SELECT `class`, `value` FROM `c_odds_data` WHERE `type`=:type AND `class`=:class';
                $params = [':type' => 'JSLH', ':class' => $_pan];
                $_end = $_pan;
            }
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $_lines = array();
            while($rows = $stmt->fetch()){
                $rows['value'] = unserialize($rows['value']);
                $rows['class'] = intval($rows['class']);
                !isset($_lines[$rows['class']])&&$_lines[$rows['class']] = [];
                foreach($rows['value'] as $key=>$val){
                    if($val['class']=='生肖年'){
                        $_lines[$rows['class']][$LOT['lunar']] = floatval($val['odds']);
                    }else{
                        $_lines[$rows['class']][$val['class']] = floatval($val['odds']);
                    }
                }
            }
            switch ($LOT['odds'][$_pan][0][0]) {
                case '三全中':
                case '三中二':
                case '二全中':
                case '二中特':
                case '特串':
                case '四中一':
                    $key = 'j'.show_id($_pan, 0);
                    $LOT['output']['Obj']['Lines'][$key] = implode('/', $_lines[$_pan]);
                    $LOT['output']['Obj']['Lines']['tips'] = implode('/', array_keys($_lines[$_pan]));
                    break;
                
                default:
                    for(;$_pan<=$_end;$_pan++){
                        foreach($LOT['odds'][$_pan][1] as $key=>$val){
                            !isset($_lines[$_pan])&&$_lines[$_pan] = [];
                            !isset($_lines[$_pan][$val])&&$_lines[$_pan][$val] = 0;
                            $key = 'j'.show_id($_pan, $key);
                            $LOT['output']['Obj']['Lines'][$key] = $_lines[$_pan][$val];
                        }
                    }
                    break;
            }
        }
    }
}else{
    $LOT['output']['Success'] = 1;
    $LOT['output']['Msg'] = '';
    $LOT['output']['Obj']['OpenCount'] = $LOT['six']['opentime'];
    $LOT['output']['Obj']['CloseCount'] = $LOT['six']['opentime']-5;
    $LOT['output']['Obj']['WinLoss'] = '0.00';
    $LOT['output']['Obj']['NotCountSum'] = '0.00';
    $LOT['output']['Obj']['LotterNo'] = 0; //上期开奖期数
    $LOT['output']['Obj']['PreResult'] = array(); //上期开奖结果
    $LOT['output']['Obj']['CurrentPeriod'] = $LOT['six']['qishu'];
    /* 加载用户下注信息 */
    if($LOT['user']['login']){
        $params = array(':time' => $LOT['mdtime']-fmod($LOT['mdtime']-14400, 86400)-43200, ':type' => 'JSLH', ':uid' => $LOT['user']['uid']);
        $sql = 'SELECT SUM(IF(`status`=0, `money`, 0)) AS `bet_money`, SUM(IF(`status`=0, 0, CASE WHEN `win`>0 THEN `win`-`money` ELSE `win` END)) AS `win_money` FROM `c_bet_data` WHERE `addtime`>=:time AND `type`=:type AND `uid`=:uid AND `status` BETWEEN 0 AND 1';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetch();
        $LOT['output']['Obj']['WinLoss'] = sprintf('%.2f', $rows['win_money']/100);
        $LOT['output']['Obj']['NotCountSum'] = sprintf('%.2f', $rows['bet_money']/100);
    }
    $query = $mydata1_db->prepare('SELECT `value` FROM `c_auto_data` WHERE `type`=:type AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT 1');
    $query->execute([':type' => 'JSLH']);
    if($query->rowCount()>0){
        $rows = $query->fetch();
        $rows = unserialize($rows['value']);
        $LOT['output']['Obj']['LotterNo'] = $rows['qishu'];
        foreach($rows['opencode'] as $key=>$val){
            $LOT['output']['Obj']['PreResult'][] = [
                'color' => $rows['color'][$key],
                'number' => substr('0'.$val, -2),
                'sx' => $rows['animal'][$key],
            ];
        }
    }
}