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
$params = array(':kaipan' => date('2010-06-01 H:i:s', $LOT['bjtime']), ':fengpan' => date('2010-06-01 H:i:s', $LOT['bjtime']-5));
$sql = 'SELECT `qihao`, `kaipan`, `fengpan` FROM `lottery_t_ssl` WHERE `kaipan`<=:kaipan AND `fengpan`>=:fengpan AND `ok`=0 ORDER BY `fengpan` ASC LIMIT 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
if($stmt->rowCount()>0){
    $rows = $stmt->fetch();
    $rows['fengpan'] = explode(' ', $rows['fengpan']);
    $rows['fengpan'] = strtotime(date('Y-m-d ', $LOT['bjtime']).$rows['fengpan'][1]);
    // $rows['fengpan']+= floor(($LOT['bjtime']-1275350400)/86400)*86400;
    $LOT['output']['Obj']['CurrentPeriod'] = date('Ymd', $LOT['bjtime']).substr('00'.$rows['qihao'], -2);
    $LOT['output']['Obj']['CloseCount'] = $rows['fengpan']-$LOT['bjtime'];
    $LOT['output']['Obj']['OpenCount'] = $rows['fengpan']-$LOT['bjtime']+5;
    $web_site['ssl']!=0&&$LOT['output']['Obj']['CloseCount'] = 0;
    /* 加载赔率信息 */
    $sql = 'SELECT * FROM `lottery_odds` WHERE `class1`=\'ssl\' ORDER BY `id` ASC';
    $query = $mydata1_db->query($sql);
    $odds = array();
    while($rows = $query->fetch()){
        !isset($odds[$rows['class2']])&&$odds[$rows['class2']] = array();
        $odds[$rows['class2']][$rows['class3']] = $rows['odds'];
    }
    foreach($LOT['odds'] as $id1=>$val){
        $k1 = $val[0][0];
        $k2 = $val[0][1];
        !isset($odds[$k1])&&$odds[$k1] = array();
        foreach($val[1] as $id2=>$key){
            !isset($odds[$k1][$key])&&$odds[$k1][$key] = 0;
            $id2 = 'j'.$id1.substr('00'.$id2, -2);
            isset($val[0][2])&&$key = $k2;
            $LOT['output']['Obj']['Lines'][$id2] = $odds[$k1][$key];
        }
    }
}else{
    $sql = 'SELECT `qihao` FROM `lottery_k_ssl` ORDER BY `addtime` DESC LIMIT 1';
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
$cache_ssl = IN_LOT.'../cache/lot_shssl.php';
if($LOT['more']&&file_exists($cache_ssl)){
    $cache_ssl = include($cache_ssl);
    if(isset($cache_ssl['output'])){
        if(isset($LOT['input']['numberPostion'])&&intval($LOT['input']['numberPostion'])==0){
            $LOT['output']['Obj']['LuZhu'] = $cache_ssl['output']['LuZhu'];
        }
        $LOT['output']['Obj']['ChangLong'] = $cache_ssl['output']['ChangLong'];
    }
}
/* 查询开奖信息 */
$sql = 'SELECT * FROM `lottery_k_ssl` WHERE `ok`=1 ORDER BY `addtime` DESC LIMIT 1';
$query = $mydata1_db->query($sql);
$LOT['output']['Obj']['PrePeriodNumber'] = '--';
$LOT['output']['Obj']['PreResult'] = '-,-,-';
$LOT['output']['Obj']['PreResultData'] = '-,-,-';
if($query->rowCount()>0){
    $rows = $query->fetch();
    $rows['data'] = array();
    $rows['data'][] = $rows['hm1']+$rows['hm2']+$rows['hm3'];
    $rows['data'][] = $rows['data'][0]>14?'大':'小';
    $rows['data'][] = fmod($rows['data'][0], 2)==0?'双':'单';
    $LOT['output']['Obj']['PrePeriodNumber'] = $rows['qihao'];
    $LOT['output']['Obj']['PreResult'] = $rows['hm1'].','.$rows['hm2'].','.$rows['hm3'];
    $LOT['output']['Obj']['PreResultData'] = implode(',', $rows['data']);
}
/* 查询用户数据 */
if($LOT['user']['login']){
    $params = array(':time' => date('Y-m-d 12:00:00', $LOT['mdtime']-43200), ':username' => $LOT['user']['username'], ':atype' => 'ssl');
    $sql = 'SELECT SUM(IF(`bet_ok`=0, `money`, 0)) AS `bet_money`, SUM(IF(`bet_ok`=0, 0, `win`)) AS `win_money` FROM `lottery_data` WHERE `bet_time`>:time AND `username`=:username AND `atype`=:atype';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $LOT['output']['Obj']['WinLoss'] = sprintf('%.2f', $rows['win_money']);
    $LOT['output']['Obj']['NotCountSum'] = sprintf('%.2f', $rows['bet_money']);
}