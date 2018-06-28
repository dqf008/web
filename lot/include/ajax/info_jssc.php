<?php
!defined('IN_LOT')&&die('Access Denied');
$LOT['output']['Success'] = 1;
$LOT['output']['Msg'] = '';
$LOT['output']['Obj']['CurrentPeriod'] = date('Ymd', $LOT['bjtime']); //当前期号
$LOT['output']['Obj']['CloseCount'] = 0; //剩余封盘时间，单位：秒
$LOT['output']['Obj']['OpenCount'] = 0; //剩余开奖时间，单位：秒
$LOT['output']['Obj']['PrePeriodNumber'] = 0; //最近开奖期号
$LOT['output']['Obj']['PreResult'] = ''; //最近开奖结果
$LOT['output']['Obj']['PreResultData'] = ''; //最近开奖结果对应中文
$LOT['output']['Obj']['WinLoss'] = '0.00'; //会员盈亏
$LOT['output']['Obj']['NotCountSum'] = '0.00'; //未结算金额
$LOT['output']['Obj']['ChangLong'] = array(); //两面长龙
$LOT['output']['Obj']['Lines'] = array(); //赔率
$LOT['output']['Obj']['LuZhu'] = array();
// $LOT['output']['Obj']['LuZhu'][] = array('c' => '', 'n' => '冠亚和', 'p' => 0);
// $LOT['output']['Obj']['LuZhu'][] = array('c' => '', 'n' => '冠亚和大小', 'p' => 0);
// $LOT['output']['Obj']['LuZhu'][] = array('c' => '', 'n' => '冠亚和单双', 'p' => 0);
/* 查询盘口信息 */
$LOT['output']['Obj']['ZongchuYilou'] = array('miss' => array(), 'hit' => array());
$LOT['output']['Obj']['OpenCount'] = fmod($LOT['bjtime']-14400, 86400);
$LOT['output']['Obj']['CurrentPeriod'].= substr('0000'.(floor($LOT['output']['Obj']['OpenCount']/75)+1), -4);
$LOT['output']['Obj']['OpenCount'] = 75-fmod($LOT['output']['Obj']['OpenCount'], 75);
$LOT['output']['Obj']['CloseCount'] = $LOT['output']['Obj']['OpenCount']-5;
//$LOT['output']['Obj']['CloseCount'] = 0;
/* 加载赔率信息 */
$sql = 'SELECT `class`, `value` FROM `c_odds_data` WHERE `type`=\'JSSC\' ORDER BY `class` ASC';
$query = $mydata1_db->query($sql);
while($rows = $query->fetch()){
    $id1 = $rows['class'];
    if(isset($LOT['odds'][$id1])){
        $rows['value'] = unserialize($rows['value']);
        foreach($rows['value'] as $id2=>$val){
            $key = 'j'.show_id($id1, $id2);
            isset($LOT['odds'][$id1][1][$id2])&&$LOT['output']['Obj']['Lines'][$key] = floatval($val['odds']);
        }
    }
}

/* 加载长龙信息 */
$cache_jsc = IN_LOT.'../cache/lot_jssc.php';
if($LOT['more']&&file_exists($cache_jsc)){
    $cache_jsc = include($cache_jsc);
    if(isset($cache_jsc['output'])){
        if(isset($LOT['input']['numberPostion'])&&intval($LOT['input']['numberPostion'])==0){
            $LOT['output']['Obj']['LuZhu'] = $cache_jsc['output']['LuZhu'];
        }
        $LOT['output']['Obj']['ChangLong'] = $cache_jsc['output']['ChangLong'];
    }
}
/* 查询开奖信息 */
$query = $mydata1_db->prepare('SELECT `value` FROM `c_auto_data` WHERE `type`=:type AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT 1');
$query->execute([':type' => 'JSSC']);
if($query->rowCount()>0){
    $rows = $query->fetch();
    $rows = unserialize($rows['value']);
    $LOT['output']['Obj']['PrePeriodNumber'] = $rows['qishu'];
    $LOT['output']['Obj']['PreResult'] = implode(',', $rows['opencode']);
    $LOT['output']['Obj']['PreResultData'] = implode(',', $rows['info']);
}
/* 查询用户数据 */
if($LOT['user']['login']){
    $params = array(':time' => $LOT['mdtime']-fmod($LOT['mdtime']-14400, 86400)-43200, ':type' => 'JSSC', ':uid' => $LOT['user']['uid']);
    $sql = 'SELECT SUM(IF(`status`=0, `money`, 0)) AS `bet_money`, SUM(IF(`status`=0, 0, CASE WHEN `win`>0 THEN `win`-`money` ELSE `win` END)) AS `win_money` FROM `c_bet_data` WHERE `addtime`>=:time AND `type`=:type AND `uid`=:uid AND `status` BETWEEN 0 AND 1';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $LOT['output']['Obj']['WinLoss'] = sprintf('%.2f', $rows['win_money']/100);
    $LOT['output']['Obj']['NotCountSum'] = sprintf('%.2f', $rows['bet_money']/100);
}