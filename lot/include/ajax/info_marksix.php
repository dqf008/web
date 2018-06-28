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
            $LOT['output']['Obj']['CloseCountdown'] = 0;
            /* 开奖倒计时 */
            !empty($LOT['marksix'])&&strtotime($LOT['marksix']['zfbdate'])>=$LOT['bjtime']&&intval($LOT['marksix']['zfb'])>0&&$LOT['output']['Obj']['CloseCountdown'] = strtotime($LOT['marksix']['zfbdate'])-$LOT['bjtime'];
            if(isset($LOT['odds'][$_pan][0][2])&&isset($LOT['odds'][$_pan][0][3])){
                $sql = 'SELECT `class3`, `rate` FROM `ka_bl` WHERE `class1`=:class1 ORDER BY `id` ASC';
                $params = array(':class1' => $LOT['odds'][$_pan][0][0]);
                $_pan = $LOT['odds'][$_pan][0][2];
                $_end = $LOT['odds'][$_pan][0][3];
            }else{
                $sql = 'SELECT `class3`, `rate` FROM `ka_bl` WHERE `class1`=:class1 AND `class2`=:class2 ORDER BY `id` ASC';
                $params = array(
                    ':class1' => $LOT['odds'][$_pan][0][0],
                    ':class2' => $LOT['odds'][$_pan][0][1],
                );
                $_end = $_pan;
            }
            $stmt = $mydata2_db->prepare($sql);
            $stmt->execute($params);
            $_lines = array();
            while($rows = $stmt->fetch()){
                $_lines[$rows['class3']] = floatval($rows['rate']);
            }
            if($LOT['odds'][$_pan][0][0]=='连码'){
                $key = 'j'.show_id($_pan, 0);
                $LOT['output']['Obj']['Lines'][$key] = implode('/', $_lines);
                $LOT['output']['Obj']['Lines']['tips'] = implode('/', array_keys($_lines));
            }else{
                for(;$_pan<=$_end;$_pan++){
                    foreach($LOT['odds'][$_pan][1] as $key=>$val){
                        !isset($_lines[$val])&&$_lines[$val] = 0;
                        $key = 'j'.show_id($_pan, $key);
                        $LOT['output']['Obj']['Lines'][$key] = strval($_lines[$val]);
                    }
                }
            }
        }
    }
}else{
    $LOT['output']['Success'] = 1;
    $LOT['output']['Msg'] = '';
    $LOT['output']['Obj']['OpenCount'] = 0;
    $LOT['output']['Obj']['CloseCount'] = 0;
    $LOT['output']['Obj']['WinLoss'] = '0.00'; //会员输赢，无显示
    $LOT['output']['Obj']['NotCountSum'] = '0.00'; //已经下注金额
    $LOT['output']['Obj']['LotterNo'] = 0; //上期开奖期数
    $LOT['output']['Obj']['PreResult'] = array(); //上期开奖结果
    if(!empty($LOT['marksix'])&&strtotime($LOT['marksix']['zfbdate'])>=$LOT['bjtime']&&intval($LOT['marksix']['zfb'])>0){
        $LOT['output']['Obj']['OpenCount'] = strtotime($LOT['marksix']['zfbdate'])-$LOT['bjtime'];
        $LOT['output']['Obj']['CloseCount'] = $LOT['output']['Obj']['OpenCount']-5;
    }
    /* 加载未开期号以及用户下注信息 */
    if(!empty($LOT['marksix'])){
        $LOT['output']['Obj']['CurrentPeriod'] = $LOT['marksix']['nn'];
        if($LOT['user']['login']){
            $params = array(':username' => $LOT['user']['username'], ':kithe' => $LOT['marksix']['nn']);
            $sql = 'SELECT SUM(IF(`checked`=0, `sum_m`, 0)) AS `bet_money`, SUM(IF(`checked`=0, 0, CASE WHEN `bm`=1 THEN `sum_m`*`rate`-`sum_m` WHEN `bm`=2 THEN `sum_m` ELSE -1*`sum_m` END)) AS `win_money` FROM `ka_tan` WHERE `username`=:username AND `kithe`=:kithe';
            $stmt = $mydata2_db->prepare($sql);
            $stmt->execute($params);
            $rows = $stmt->fetch();
            $LOT['output']['Obj']['WinLoss'] = sprintf('%.2f', $rows['win_money']);
            $LOT['output']['Obj']['NotCountSum'] = sprintf('%.2f', $rows['bet_money']);
        }
    }
    $query = $mydata2_db->query('SELECT `nn`, `nd`, `na`, `n1`, `n2`, `n3`, `n4`, `n5`, `n6`, `sx`, `x1`, `x2`, `x3`, `x4`, `x5`, `x6` FROM `ka_kithe` WHERE `na`>0 ORDER BY `nn` DESC LIMIT 1');
    if($query->rowCount()>0){
        $rows = $query->fetch();
        $LOT['output']['Obj']['LotterNo'] = $rows['nn'];
        for($i=1;$i<=7;$i++){
            $key = array('n'.$i, 'x'.$i);
            $i>=7&&$key = array('na', 'sx');
            $LOT['output']['Obj']['PreResult'][] = array(
                'color' => $LOT['color'][$rows[$key[0]]],
                'number' => substr('0'.$rows[$key[0]], -2),
                'sx' => $rows[$key[1]],
            );
        }
    }
}