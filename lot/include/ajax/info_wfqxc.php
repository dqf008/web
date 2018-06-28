<?php
!defined('IN_LOT')&&die('Access Denied');
$LOT['output']['Success'] = 1;
$LOT['output']['Msg'] = '';
$LOT['output']['Obj']['CurrentPeriod'] = 0; //当前期号
$LOT['output']['Obj']['CloseCount'] = 0; //剩余封盘时间，单位：秒
$LOT['output']['Obj']['OpenCount'] = 0; //剩余开奖时间，单位：秒
$LOT['output']['Obj']['PrePeriodNumber'] = 0; //最近开奖期号
$LOT['output']['Obj']['PreResult'] = ''; //最近开奖结果
$LOT['output']['Obj']['PreResultData'] = ''; //最近开奖结果对应中文
$LOT['output']['Obj']['WinLoss'] = '0.00'; //会员盈亏
$LOT['output']['Obj']['NotCountSum'] = '0.00'; //未结算金额
$LOT['output']['Obj']['ChangLong'] = array(); //两面长龙
$LOT['output']['Obj']['Lines'] = array(); //赔率
$LOT['output']['Obj']['LuZhu'] = array(); //遗漏
$LOT['output']['Obj']['ZongchuYilou'] = array();
$lotteryType = isset($LOT['lottery_type'])?$LOT['lottery_type']:'wfxqc';
/* 查询盘口信息 */
$params = array(':kaipan' => date('H:i:s', $LOT['bjtime']), ':fengpan' => date('H:i:s', $LOT['bjtime']));
$sql = "SELECT `qishu`, `kaipan`, `fengpan` FROM `c_opentime_new_qxc` WHERE `kaipan`<=:kaipan AND `fengpan`>=:fengpan AND `ok`=0 and `name`='$lotteryType' ORDER BY `fengpan` ASC LIMIT 1";
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
if($stmt->rowCount()>0){
    $rows = $stmt->fetch();
    $date = date('Y-m-d',time());
    $rows['fengpan'] = strtotime($date.' '.$rows['fengpan']);
    $qihao = getQiHao($lotteryType,$rows['qishu']);
    $rows['kaipan'] = strtotime($date.' '.$rows['kaipan']);
    $LOT['output']['Obj']['CurrentPeriod'] = $qihao;
    $LOT['output']['Obj']['CloseCount'] = $rows['fengpan']-$LOT['bjtime'];
    $LOT['output']['Obj']['OpenCount'] = $rows['fengpan']-$LOT['bjtime'];
    $web_site[$lotteryType]!=0&&$LOT['output']['Obj']['CloseCount'] = 0;
    /* 加载赔率信息 */
    $sql = "SELECT * FROM `lottery_odds` WHERE `class1`='$lotteryType' ORDER BY `id` ASC";
    $query = $mydata1_db->query($sql);
    $odds = array();
    while($rows = $query->fetch()){
        !isset($odds[$rows['class2']])&&$odds[$rows['class2']] = array();
        $odds[$rows['class2']][$rows['class3']] = $rows['odds'];
    }
    foreach($LOT['odds'] as $id1=>$val){
        !isset($odds[$val[0]])&&$odds[$val[0]] = array();
        foreach($val[1] as $id2=>$key){
            !isset($odds[$val[0]][$key])&&$odds[$val[0]][$key] = 0;
            $id2 = 'j'.$id1.substr('00'.$id2, -2);
            $LOT['output']['Obj']['Lines'][$id2] = $odds[$val[0]][$key];
        }
    }
}else{
    $sql = "SELECT `qishu` FROM `lottery_k_new_qxc` where `name`='$lotteryType' ORDER BY `kaijiang` DESC LIMIT 1";
    $query = $mydata1_db->query($sql);
    if($query->rowCount()>0){
        $rows = $query->fetch();
        $LOT['output']['Obj']['CurrentPeriod'] = $rows['qishu'];
    }else{
        $LOT['output']['Success'] = 0;
        $LOT['output']['Msg'] = '已封盘，请稍后尝试';
    }
}
/* 查询开奖信息 */
$sql = "SELECT * FROM `lottery_k_new_qxc` WHERE `status`=1 and `name`='$lotteryType' ORDER BY `kaijiang` DESC LIMIT 1";
$query = $mydata1_db->query($sql);
$LOT['output']['Obj']['PrePeriodNumber'] = '--';
$LOT['output']['Obj']['PreResult'] = '-,-,-,-';
if($query->rowCount()>0){
    $rows = $query->fetch();
    $rows['value'] = unserialize($rows['value']);
    if(is_array($rows['value'])){
        array_splice($rows['value'], 4); //只输出4个，后面三个为预留数据
        $LOT['output']['Obj']['PrePeriodNumber'] = $rows['qishu'];
        $LOT['output']['Obj']['PreResult'] = implode(',', $rows['value']);
    }
}
/* 查询用户数据 */
if($LOT['user']['login']){
    $params = array(':mid1' => $LOT['output']['Obj']['PrePeriodNumber'], ':mid2' => $LOT['output']['Obj']['CurrentPeriod'], ':username' => $LOT['user']['username'], ':atype' => 'wfqxc');
    $sql = 'SELECT SUM(IF(`bet_ok`=0, `money`, 0)) AS `bet_money`, SUM(IF(`bet_ok`=0, 0, `win`)) AS `win_money` FROM `lottery_data` WHERE `mid` IN (:mid1, :mid2) AND `username`=:username AND `atype`=:atype';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $LOT['output']['Obj']['WinLoss'] = sprintf('%.2f', $rows['win_money']);
    $LOT['output']['Obj']['NotCountSum'] = sprintf('%.2f', $rows['bet_money']);
}