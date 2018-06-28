<?php
!defined('IN_LOT') && die('Access Denied');
$LOT['output']['Success']                = 1;
$LOT['output']['Msg']                    = '';
$LOT['output']['Obj']['CurrentPeriod']   = 0; //当前期号
$LOT['output']['Obj']['CloseCount']      = 0; //剩余封盘时间，单位：秒
$LOT['output']['Obj']['OpenCount']       = 0; //剩余开奖时间，单位：秒
$LOT['output']['Obj']['PrePeriodNumber'] = 0; //最近开奖期号
$LOT['output']['Obj']['PreResult']       = ''; //最近开奖结果
$LOT['output']['Obj']['PreResultData']   = ''; //最近开奖结果对应中文
$LOT['output']['Obj']['WinLoss']         = '0.00'; //会员盈亏
$LOT['output']['Obj']['NotCountSum']     = '0.00'; //未结算金额
$LOT['output']['Obj']['ChangLong']       = []; //两面长龙
$LOT['output']['Obj']['Lines']           = []; //赔率
$LOT['output']['Obj']['LuZhu']           = []; //遗漏
$LOT['output']['Obj']['ZongchuYilou']    = [];
$lotteryType                             = $LOT['lottery_type'];
//var_dump(time());die();
//$lotteryCount = ['jsk3' => 82, 'ahk3' => 80, 'fjk3' => 78, 'gxk3' => 78, 'shk3' => 80, 'hbk3' => 78, 'hebk3' => 81, 'nmgk3' => 73, 'bjk3' => 89, 'gsk3' => 72, 'gzk3' => 78, 'hnk3' => 84, 'jlk3' => 82, 'jxk3' => 84, 'qhk3' => 78];
$lotteryInfo = [
    'jsk3'  => ['total' => 82, 'first_open_time' => '08:40'],
    'fjk3'  => ['total' => 78, 'first_open_time' => '08:50'],
    'gxk3'  => ['total' => 78, 'first_open_time' => '09:28'],
    'ahk3'  => ['total' => 80, 'first_open_time' => '08:40'],
    'shk3'  => ['total' => 80, 'first_open_time' => '08:50'],
    'hbk3'  => ['total' => 78, 'first_open_time' => '09:00'],
    'hebk3' => ['total' => 81, 'first_open_time' => '08:30'],
    'jlk3'  => ['total' => 82, 'first_open_time' => '08:19'],
    'gsk3'  => ['total' => 72, 'first_open_time' => '10:00'],
    'bjk3'  => ['total' => 89, 'first_open_time' => '09:02'],
    'gzk3'  => ['total' => 78, 'first_open_time' => '09:00'],
    'nmgk3' => ['total' => 73, 'first_open_time' => '09:40'],
    'jxk3'  => ['total' => 84, 'first_open_time' => '08:30'],
];
/* 查询盘口信息 */
$params = [':end_sale' => $LOT['mdtime']];
$sql    = "SELECT * FROM `lottery_k3` WHERE `name`='$lotteryType' and end_sale <=:end_sale ORDER BY `qihao` DESC LIMIT 1";
$stmt   = $mydata1_db->prepare($sql);
$stmt->execute($params);
$isContinue = true;
$tqTime = 60;
if($lotteryType=='jxk3'){
    $tqTime = 180;
}
if ($stmt->rowCount() > 0) {
    $rows              = $stmt->fetch();
    $rows['left_time'] = $rows['next_draw']- $tqTime - $LOT['mdtime'];
    $nextInfo          = getKjTime($rows, $lotteryType, $lotteryInfo[$lotteryType]['total'], $LOT['mdtime'], $lotteryInfo[$lotteryType]['first_open_time'],$tqTime);
    if ($rows['left_time'] <= 0) {
        if ($nextInfo['left_time'] > 600) {
            $LOT['output']['Obj']['CurrentPeriod'] = $rows['qihao'];
            $isContinue                            = false;
        } else {
            $LOT['output']['Obj']['CurrentPeriod'] = $nextInfo['qihao'];
            $LOT['output']['Obj']['CloseCount'] = $nextInfo['left_time'];
            $LOT['output']['Obj']['OpenCount']  = $nextInfo['left_time'];
        }
    }
    if ($rows['left_time'] > 0) {
        $LOT['output']['Obj']['CurrentPeriod'] = $rows['next_qihao'];
        $LOT['output']['Obj']['CloseCount']    = $rows['left_time'];
        $LOT['output']['Obj']['OpenCount']     = $rows['left_time'];
    }
    if ($isContinue) {
        /* 加载赔率信息 */
        $sql   = "select * from lottery_odds where `class1`='$lotteryType' order by id desc ";
        $query = $mydata1_db->query($sql);
        $odds  = [];
        while ($rows = $query->fetch()) {
            !isset($odds[$rows['class2']]) && $odds[$rows['class2']] = [];
            $odds[$rows['class2']][$rows['class3']] = $rows['odds'];
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
} else {
    $sql   = "SELECT `qihao` FROM `lottery_k3` where `name`='$lotteryType' ORDER BY `addtime` DESC LIMIT 1";
    $query = $mydata1_db->query($sql);
    if ($query->rowCount() > 0) {
        $rows                                  = $query->fetch();
        $LOT['output']['Obj']['CurrentPeriod'] = $rows['qihao'];
    } else {
        $LOT['output']['Success'] = 0;
        $LOT['output']['Msg']     = '已封盘，请稍后尝试';
    }
}

/* 查询开奖信息 */
$sql                                     = "SELECT * FROM `lottery_k3` WHERE `ok`=1 and `name`='$lotteryType'  ORDER BY `qihao` DESC LIMIT 1";
$query                                   = $mydata1_db->query($sql);
$LOT['output']['Obj']['PrePeriodNumber'] = '--';
$LOT['output']['Obj']['PreResult']       = '-,-,-';
$LOT['output']['Obj']['PreResultData']   = '-,-,-';
if ($query->rowCount() > 0) {
    $rows           = $query->fetch();
    $balls          = explode(',', $rows['balls']);
    $sum            = array_sum($balls);
    $rows['data'][] = $sum;
    $rows['data'][] = $sum > 10 ? '大' : '小';
    $rows['data'][] = fmod($sum, 2) == 0 ? '双' : '单';

    $LOT['output']['Obj']['PreResult']     = $rows['balls'];
    $LOT['output']['Obj']['PreResultData'] = implode(',', $rows['data']);

    $LOT['output']['Obj']['PrePeriodNumber'] = $rows['qihao'];
}
/**获取最近20期开奖结果
 *
 */
/* 查询用户数据 */
if ($LOT['user']['login']) {
    $params = [':time' => date('Y-m-d 12:00:00', $LOT['mdtime'] - 43200), ':username' => $LOT['user']['username'], ':atype' => $lotteryType];
    $sql    = 'SELECT SUM(IF(`bet_ok`=0, `money`, 0)) AS `bet_money`, SUM(IF(`bet_ok`=0, 0, `win`)) AS `win_money` FROM `lottery_data` WHERE `bet_time`>:time AND `username`=:username AND `atype`=:atype';
    $stmt   = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $rows                                = $stmt->fetch();
    $LOT['output']['Obj']['WinLoss']     = sprintf('%.2f', $rows['win_money']);
    $LOT['output']['Obj']['NotCountSum'] = sprintf('%.2f', $rows['bet_money']);
}