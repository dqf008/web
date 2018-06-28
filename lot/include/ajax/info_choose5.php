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
// $LOT['output']['Obj']['LuZhu'][] = array('c' => '', 'n' => '冠亚和', 'p' => 0);
// $LOT['output']['Obj']['LuZhu'][] = array('c' => '', 'n' => '冠亚和大小', 'p' => 0);
// $LOT['output']['Obj']['LuZhu'][] = array('c' => '', 'n' => '冠亚和单双', 'p' => 0);
/* 查询盘口信息 */
$lotteryType = $LOT['lottery_type'];
$lotteryNames = array('gdchoose5'=>'广东11选5','sdchoose5','fjchoose5'=>'福建11选5','bjchoose5'=>'北京11选5','ahchoose5'=>'安徽11选5','ffchoose5'=>'分分11选5','sfchoose5'=>'三分11选5');
$LOT['output']['Obj']['ZongchuYilou'] = array('miss' => array(), 'hit' => array());
$params = array(':kaipan' => date('H:i:s', $LOT['bjtime']), ':kaijiang' => date('H:i:s', $LOT['bjtime']));
$sql = "SELECT `qishu`, `kaipan`, `fengpan`, `kaijiang` FROM `c_opentime_choose5` WHERE `kaipan`<=:kaipan AND `kaijiang`>=:kaijiang and `name`='$lotteryType' ORDER BY `kaijiang` ASC";
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
    $LOT['output']['Obj']['CurrentPeriod'] = date('Ymd', $LOT['bjtime']).substr('00'.$rows['qishu'], -$start);
    $LOT['output']['Obj']['CloseCount'] = strtotime(date('Y-m-d', $LOT['bjtime']).' '.$rows['fengpan']);
    $LOT['output']['Obj']['OpenCount'] = strtotime(date('Y-m-d', $LOT['bjtime']).' '.$rows['kaijiang']);

    // if(strtotime(date('Y-m-d', $LOT['bjtime']).' '.$rows['kaipan'])>$LOT['output']['Obj']['OpenCount']){
    //     /* 隔日开奖，加一天 */
    //     $LOT['output']['Obj']['CloseCount']+= 86400;
    //     $LOT['output']['Obj']['OpenCount']+= 86400;
    // }
    $LOT['output']['Obj']['CloseCount']-= $LOT['bjtime'];
    $LOT['output']['Obj']['OpenCount']-= $LOT['bjtime'];
    $web_site['klsf']!=0&&$LOT['output']['Obj']['CloseCount'] = 0;
    /* 加载赔率信息 */
    $sql = "SELECT * FROM `c_odds_choose5` where `name`='$lotteryType' ORDER BY `id` ASC";
    $query = $mydata1_db->query($sql);
    while($rows = $query->fetch()){
        $id1 = substr($rows['type'], 5);
        if(isset($LOT['odds'][$id1])){
            foreach($rows as $key=>$val){
                if(substr($key, 0, 1)=='h'){
                    $id2 = substr($key, 1);
                    $key = 'j'.show_id($id1, $id2);
                    // isset($LOT['odds'][$id1][1][$id2])&&$LOT['output']['Obj']['Lines'][$key] = sprintf('%.2f', $val);
                    isset($LOT['odds'][$id1][1][$id2])&&$LOT['output']['Obj']['Lines'][$key] = floatval($val);
                }
            }
        }
    }
}else{
    $sql = "SELECT `qishu`, `kaijiang` FROM `c_opentime_choose5` where `name`='$lotteryType' ORDER BY `kaijiang` ASC LIMIT 1";
    $query = $mydata1_db->query($sql);
    if($query->rowCount()>0){
        $rows = $query->fetch();
        $LOT['output']['Obj']['CurrentPeriod'] = date('Ymd', $LOT['bjtime']+86400).substr('00'.$rows['qishu'], -2);
        $LOT['output']['Obj']['OpenCount'] = strtotime(date('Y-m-d', $LOT['bjtime']+86400).' '.$rows['kaijiang']);
        $LOT['output']['Obj']['OpenCount']-= $LOT['bjtime'];
    }else{
        $LOT['output']['Success'] = 0;
        $LOT['output']['Msg'] = '已封盘，请稍后尝试';
    }
}
/* 加载长龙信息 */
$lot_cache = IN_LOT.'../cache/lot_'.$lotteryType.'.php';
if($LOT['more']&&file_exists($lot_cache)){
    $lot_cache = include($lot_cache);
    if(isset($lot_cache['output'])){
        $LOT['output']['Obj']['ChangLong'] = $lot_cache['output']['ChangLong'];
        $LOT['output']['Obj']['ZongchuYilou'] = $lot_cache['output']['ZongchuYilou'];
        $LOT['output']['Obj']['LuZhu'] = $lot_cache['output']['LuZhu'];
    }
}
/* 查询开奖信息 */
$query = $mydata1_db->query("SELECT `qishu`, `ball_1`, `ball_2`, `ball_3`, `ball_4`, `ball_5` FROM `c_auto_choose5` where `name`='$lotteryType' ORDER BY `qishu` DESC LIMIT 1");
if($query->rowCount()>0){
    $rows = $query->fetch();
    $LOT['output']['Obj']['PrePeriodNumber'] = $rows['qishu'];
    $rows['data'] = $rows['list'] = array();
    $rows['data'][] = 0;
    foreach($rows as $key=>$val){
        if(substr($key, 0, 4)=='ball'){
            $rows['list'][] = $val;
            $rows['data'][0]+= $val;
        }
    }
    $rows['data'][] = fmod($rows['data'][0], 2)==0?'双':'单';
    $rows['data'][] = ($rows['data'][0]==30 || $rows['data'][0]==31)?'和':($rows['data'][0]>31?'大':'小');
//    $rows['data'][] = substr($rows['data'][0], -1)>=5?'尾大':'尾小';
    //$rows['data'][] = $rows['list'][0]==$rows['list'][4]?'和':($rows['list'][0]>$rows['list'][4]?'龙':'虎');
    $LOT['output']['Obj']['PreResult'] = implode(',', $rows['list']);
    $LOT['output']['Obj']['PreResultData'] = implode(',', $rows['data']);

}
/* 查询用户数据 */
if($LOT['user']['login']){
    $params = array(':time' => date('Y-m-d 12:00:00', $LOT['mdtime']-43200), ':type' => $lotteryNames[$lotteryType], ':uid' => $LOT['user']['uid']);
    $sql = 'SELECT SUM(IF(`js`=0, `money`, 0)) AS `bet_money`, SUM(IF(`js`=0, 0, CASE WHEN `win`>0 THEN `win`-`money` ELSE `win` END)) AS `win_money` FROM `c_bet_3` WHERE `addtime`>=:time AND `type`=:type AND `uid`=:uid';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $LOT['output']['Obj']['WinLoss'] = sprintf('%.2f', $rows['win_money']);
    $LOT['output']['Obj']['NotCountSum'] = sprintf('%.2f', $rows['bet_money']);
}