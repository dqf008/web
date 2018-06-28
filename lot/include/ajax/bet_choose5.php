<?php
!defined('IN_LOT')&&die('Access Denied');
switch(false){
    case $LOT['user']['login']:
        result('请先登录网站');
        break;

    case $web_site['klsf']==0:
        result('系统维护，暂停下注');
        break;

    case isset($LOT['input']['betParameters'])&&!empty($LOT['input']['betParameters']):
        result('请选择一个玩法');
        break;

    case check_order():
        break;

    default:
        $lotteryType = $LOT['lottery_type'];
        $lotteryNames = array('gdchoose5'=>'广东11选5','sdchoose5'=>'山东11选5','fjchoose5'=>'福建11选5','bjchoose5'=>'北京11选5','ahchoose5'=>'安徽11选5','yfchoose5'=>'一分11选5','sfchoose5'=>'三分11选5');
        $gameType =array('gdchoose5'=>'GDSYXW','sdchoose5'=>'SDSYXW','fjchoose5'=>'FJSYXW','bjchoose5'=>'BJSYXW','ahchoose5'=>'AHSYXW','yfchoose5'=>'YFSYXW','sfchoose5'=>'SFSYXW');
        $params = array(':kaipan' => date('H:i:s', $LOT['bjtime']), ':fengpan' => date('H:i:s', $LOT['bjtime']));
        $sql = "SELECT `qishu` FROM `c_opentime_choose5` WHERE `kaipan`<=:kaipan AND `fengpan`>=:fengpan and `name`='$lotteryType' ORDER BY `fengpan` ASC";
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        if($stmt->rowCount()>0){
            $rows = $stmt->fetch();
            if($lotteryType=='yfchoose5'){
                $start = 4;
            }else if($lotteryType=='sfchoose5'){
                $start = 3;
            }else{
                $start = 2;
            }
            $bet_qishu = date('Ymd', $LOT['bjtime']).substr('00'.$rows['qishu'], -$start);
            $sql = "SELECT * FROM `c_odds_choose5` where `name`='$lotteryType' ORDER BY `id` ASC";
            $query = $mydata1_db->query($sql);
            $odds = array();
            while($rows = $query->fetch()){
                $id1 = substr($rows['type'], 5);
                if(isset($LOT['odds'][$id1])){
                    foreach($rows as $key=>$val){
                        if(substr($key, 0, 1)=='h'){
                            $id2 = substr($key, 1);
                            $key = show_id($id1, $id2);
                            isset($LOT['odds'][$id1][1][$id2])&&$odds[$key] = floatval($val);
                        }
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
                            ':did' => date('YmdHis', $LOT['mdtime']).rand(1000, 9999),
                            ':uid' => $LOT['user']['uid'],
                            ':username' => $LOT['user']['username'],
                            ':addtime' => date('Y-m-d H:i:s'),
                            ':type' => $gameType[$lotteryType],
                            ':qishu' => $bet_qishu,
                            ':mingxi_1' => $LOT['odds'][$id1][0],
                            ':mingxi_2' => $LOT['odds'][$id1][1][$id2],
                            ':odds' => $odds[$val['Id']],
                            ':money' => $val['Money'],
                            ':win' => $val['Money']*$odds[$val['Id']],
                            ':bet_date' => date('Y-m-d')
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
                        $stmt = $mydata1_db->prepare('INSERT INTO `c_bet_choose5` (`did`, `uid`, `username`, `addtime`, `type`, `qishu`, `mingxi_1`, `mingxi_2`, `odds`, `money`, `win`, `bet_date`) VALUES (:did, :uid, :username, :addtime, :type, :qishu, :mingxi_1, :mingxi_2, :odds, :money, :win, :bet_date)');
                        $stmt->execute($params);
                        $last_id = $mydata1_db->lastInsertId();
                        $stmt = $mydata1_db->prepare('INSERT INTO `k_money_log` (`uid`, `userName`, `gameType`, `transferType`, `transferOrder`, `transferAmount`, `previousAmount`, `currentAmount`, `creationTime`) VALUES (:uid, :userName, :gameType, :transferType, :transferOrder, :transferAmount, :previousAmount, :currentAmount, :creationTime)');
                        $stmt->execute(array(
                            ':uid' => $LOT['user']['uid'],
                            ':userName' => $LOT['user']['username'],
                            ':gameType' => $gameType[$lotteryType],
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