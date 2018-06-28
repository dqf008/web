<?php
include(dirname(__FILE__) . '/include/common.php');
$LOT['title']        = '彩票游戏';
$LOT['action']       = isset($_GET['i']) ? $_GET['i'] : key($LOT['game']);
$action              = isset($_GET['i']) ? $_GET['i'] : key($LOT['game']);
$LOT['lottery_type'] = isset($_GET['lottery_type']) ? $_GET['lottery_type'] : '';
if(empty($LOT['lottery_type'])){
    switch ($action){
        case 'k3':
            $LOT['lottery_type']='jsk3';
        break;
        case 'choose5':
            $LOT['lottery_type']='gdchoose5';
            break;
        default:
            break;
    }
}
if (!empty($LOT['lottery_type'])) {
    if ($LOT['action'] == 'k3') {
        $lotteryName         = [
            'jsk3'  => '江苏快3',
            'fjk3'  => '福建快3',
            'gxk3'  => '广西快3',
            'shk3'  => '上海快3',
            'hebk3' => '河北快3',
            'jxk3'  => '江西快3',
            'hbk3'  => '湖北快3',
            'ffk3'  => '分分快3',
            'sfk3'  => '超级快3',
            'wfk3'  => '好运快3',
            'ahk3'  => '安徽快3',
            'jlk3'  => '吉林快3',
            'hnk3'  => '河南快3',
            'gzk3'  => '贵州快3',
            'bjk3'  => '北京快3',
            'qhk3'  => '青海快3',
            'gsk3'  => '甘肃快3',
            'nmgk3' => '内蒙古快3'
        ];
        $LOT['lottery_name'] = $lotteryName[$LOT['lottery_type']];
    } elseif ($LOT['action'] == 'kl10') {
        $LOT['action'] = $LOT['lottery_type'];
    } elseif ($LOT['action'] == 'choose5') {
        $lotteryName         = [
            'gdchoose5' => '广东11选5',
            'sdchoose5' => '山东11选5',
            'fjchoose5' => '福建11选5',
            'bjchoose5' => '北京11选5',
            'ahchoose5' => '安徽11选5',
            'yfchoose5' => '一分11选5',
            'sfchoose5' => '三分11选5',

        ];
        $LOT['lottery_name'] = $lotteryName[$LOT['lottery_type']];
    }elseif ($LOT['action']=='pcdd'){
        $lotteryName         = [
            'pcdd' => 'PC蛋蛋',
            'ffpcdd' => '分分PC蛋蛋',
        ];
        $LOT['lottery_name'] = $lotteryName[$LOT['lottery_type']];
    }
}
if (in_array($action, array_keys($LOT['game']))) {
    $LOT['title'] = $LOT['game'][$LOT['action']] . ' - ' . $LOT['title'];
    $LOT['odds']  = include(IN_LOT . 'include/odds/' . $action . '.php');
    $action = $LOT['action'];
    if($LOT['action']=='k3'||$LOT['action']=='choose5'){
        $LOT['action'] =$LOT['lottery_type'];
    }
    include(IN_LOT . 'include/template/head.php');
    include(IN_LOT . 'include/template/body_' . $action . '.php');
    include(IN_LOT . 'include/template/footer.php');
} else {
    echo 'Access Denied';
}