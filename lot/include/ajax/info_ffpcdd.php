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
/* 查询盘口信息 */
$lotteryType = isset($LOT['lottery_type']) ?$LOT['lottery_type']:'ffpcdd';
$params = array(':kaipan' => date('H:i:s', $LOT['bjtime']), ':fengpan' => date('H:i:s', $LOT['bjtime']),':name'=>$lotteryType);
$sql = "SELECT `qihao`, `kaipan`, `fengpan` FROM `c_opentime_ffpcdd` WHERE `kaipan`<=:kaipan AND `fengpan`>=:fengpan AND `ok`=0 and `name`=:name ORDER BY `fengpan` ASC LIMIT 1";
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$isAdd = false;
$lotteryId =0;
if($stmt->rowCount()>0){
    $rows = $stmt->fetch();
    $date = date('Y-m-d',time());
    $rows['fengpan'] = strtotime($date.' '.$rows['fengpan']);
    $qihao = getQiHao($lotteryType,$rows['qihao']);
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
        $k1 = $val[0];
        !isset($odds[$k1])&&$odds[$k1] = array();
        foreach($val[1] as $id2=>$key){
            !isset($odds[$k1][$key])&&$odds[$k1][$key] = 0;
            $id2 = 'j'.$id1.substr('00'.$id2, -2);
            $LOT['output']['Obj']['Lines'][$id2] = $odds[$k1][$key];
        }
    }
}else{
    $sql = "SELECT `qihao` FROM `lottery_k_pcdd` where `name`='$lotteryType' ORDER BY `addtime` DESC LIMIT 1";
    $query = $mydata1_db->query($sql);
    if($query->rowCount()>0){
        $rows = $query->fetch();
        $LOT['output']['Obj']['CurrentPeriod'] = $rows['qihao'];
    }else{
        $LOT['output']['Success'] = 0;
        $LOT['output']['Msg'] = '已封盘，请稍后尝试';
    }
}
/* 加载长龙信息 */
$cache_ffpcdd = IN_LOT.'../cache/lot_ffpcdd.php';
if($LOT['more']&&file_exists($cache_ffpcdd)){
    $cache_ffpcdd = include($cache_ffpcdd);
    if(isset($cache_pcdd['output'])){
        if(isset($LOT['input']['numberPostion'])&&intval($LOT['input']['numberPostion'])==0){
            $LOT['output']['Obj']['LuZhu'] = $cache_ffpcdd['output']['LuZhu'];
        }
        $LOT['output']['Obj']['ChangLong'] = $cache_ffpcdd['output']['ChangLong'];
    }
}
/* 查询开奖信息 */
$sql = "SELECT * FROM `lottery_k_pcdd` WHERE `ok`=1 and `name`='$lotteryType'  ORDER BY `addtime` DESC LIMIT 1";
$query = $mydata1_db->query($sql);
$LOT['output']['Obj']['PrePeriodNumber'] = '--';
$LOT['output']['Obj']['PreResult'] = '-,-,-';
$LOT['output']['Obj']['PreResultData'] = '-,-,-';
if($query->rowCount()>0){
    $rows = $query->fetch();
    $LOT['output']['Obj']['PreResult'] = $rows['data'] = array();
    // $rows['data'][] = 0;
    for($i=1;$i<=3;$i++){
        // $rows['data'][0]+= $rows['hm'.$i];
        $i<=10&&$LOT['output']['Obj']['PreResult'][] = $rows['hm'.$i];
        $i>10&&$rows['data'][] = $rows['hm'.$i];
    }
    // $rows['data'][] = $rows['data'][0]>14?'大':'小';
    // $rows['data'][] = fmod($rows['data'][0], 2)==0?'双':'单';
    $LOT['output']['Obj']['PrePeriodNumber'] = $rows['qihao'];
    $LOT['output']['Obj']['PreResult'] = implode(',', $LOT['output']['Obj']['PreResult']);
    $LOT['output']['Obj']['PreResultData'] = implode(',', $rows['data']);
}
/* 查询用户数据 */
if($LOT['user']['login']){
    $params = array(':time' => date('Y-m-d 12:00:00', $LOT['mdtime']-43200), ':username' => $LOT['user']['username'], ':atype' => 'kl8');
    $sql = 'SELECT SUM(IF(`bet_ok`=0, `money`, 0)) AS `bet_money`, SUM(IF(`bet_ok`=0, 0, `win`)) AS `win_money` FROM `lottery_data` WHERE `bet_time`>:time AND `username`=:username AND `atype`=:atype';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $LOT['output']['Obj']['WinLoss'] = sprintf('%.2f', $rows['win_money']);
    $LOT['output']['Obj']['NotCountSum'] = sprintf('%.2f', $rows['bet_money']);
}