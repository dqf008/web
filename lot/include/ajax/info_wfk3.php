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
/* 查询盘口信息 */
$LOT['output']['Obj']['ZongchuYilou'] = array('miss' => array(), 'hit' => array());
$LOT['output']['Obj']['OpenCount'] = fmod($LOT['bjtime']-14400, 86400);
//$LOT['output']['Obj']['OpenCount'] = fmod($LOT['bjtime'], 86400);
$LOT['output']['Obj']['CurrentPeriod'].= substr('000'.(floor($LOT['output']['Obj']['OpenCount']/300)+1), -3);
$LOT['output']['Obj']['OpenCount'] = 300-fmod($LOT['output']['Obj']['OpenCount'], 300);
$LOT['output']['Obj']['CloseCount'] = $LOT['output']['Obj']['OpenCount']-5;
//$LOT['output']['Obj']['CloseCount'] = 0;
/* 加载赔率信息 */
$sql = 'SELECT `class`, `value` FROM `c_odds_data` WHERE `type`=\'WFK3\' ORDER BY `class` ASC';
$query = $mydata1_db->query($sql);
$rows = $query->fetch();
if(!empty($rows)) {
    $odds  = [];
    $rows['value'] = unserialize($rows['value']);
    foreach ($rows['value'] as $rowValue){
        $odds[$rowValue['class2']][$rowValue['class3']] = $rowValue['odds'];
    }
    foreach ($LOT['odds'] as $id1 => $val) {
        !isset($odds[$val[0]]) && $odds[$val[0]] = [];
        foreach ($val[1] as $id2 => $key) {
            !isset($odds[$val[0]][$key]) && $odds[$val[0]][$key] = 0;
            $id2Index = $id1 . substr('00' . $id2, -2);
            if (isMobile()) {
                if ($id2Index == '502') {
                    $LOT['output']['Obj']['Lines']['j5021'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j5022'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j5023'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j5024'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j5025'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j5026'] = $odds[$val[0]][$key];
                } else if ($id2Index == '402') {
                    $LOT['output']['Obj']['Lines']['j4021'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j4022'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j4023'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j4024'] = $odds[$val[0]][$key];
                } else if ($id2Index == '301') {
                    $LOT['output']['Obj']['Lines']['j3011'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j3012'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j3013'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j3014'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j3015'] = $odds[$val[0]][$key];
                    $LOT['output']['Obj']['Lines']['j3016'] = $odds[$val[0]][$key];
                } else if ($id2Index == '302') {
                    $id2Index = $id2Index * 10;
                    for ($i = 1; $i <= 30; $i++) {
                        $newIndex                                       = $id2Index + $i;
                        $LOT['output']['Obj']['Lines']['j' . $newIndex] = $odds[$val[0]][$key];
                    }
                } else {
                    $id2                                 = 'j' . $id2Index;
                    $LOT['output']['Obj']['Lines'][$id2] = $odds[$val[0]][$key];
                }
            } else {
                $id2                                 = 'j' . $id2Index;
                $LOT['output']['Obj']['Lines'][$id2] = $odds[$val[0]][$key];
            }
        }
    }
}
/* 查询开奖信息 */
$query = $mydata1_db->prepare('SELECT `value` FROM `c_auto_data` WHERE `type`=:type AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT 1');
$query->execute([':type' => 'WFK3']);
if($query->rowCount()>0){
    $rows = $query->fetch();
    $rows = unserialize($rows['value']);
    array_splice($rows['info'], 4);
    $LOT['output']['Obj']['PrePeriodNumber'] = $rows['qishu'];
    $LOT['output']['Obj']['PreResult'] = implode(',', $rows['opencode']);
    $LOT['output']['Obj']['PreResultData'] = implode(',', $rows['info']);
}
/* 查询用户数据 */
if($LOT['user']['login']){
    $params = array(':time' => $LOT['mdtime']-fmod($LOT['mdtime']-14400, 86400)-43200, ':type' => 'FFK3', ':uid' => $LOT['user']['uid']);
    $sql = 'SELECT SUM(IF(`status`=0, `money`, 0)) AS `bet_money`, SUM(IF(`status`=0, 0, CASE WHEN `win`>0 THEN `win`-`money` ELSE `win` END)) AS `win_money` FROM `c_bet_data` WHERE `addtime`>=:time AND `type`=:type AND `uid`=:uid AND `status` BETWEEN 0 AND 1';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $LOT['output']['Obj']['WinLoss'] = sprintf('%.2f', $rows['win_money']/100);
    $LOT['output']['Obj']['NotCountSum'] = sprintf('%.2f', $rows['bet_money']/100);
}