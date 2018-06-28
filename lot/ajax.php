<?php
include(dirname(__FILE__) . '/include/common.php');
header('Content-Type: application/json; charset=utf-8');
$LOT['output'] = $LOT['input'] = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_input = file_get_contents('php://input');
    if (!empty($_input)) {
        $LOT['input'] = json_decode($_input, true);
        isset($LOT['input']['action']) && $_GET['action'] = $LOT['input']['action'];
        isset($LOT['input']['lotteryId']) && $_GET['lotteryType'] = $LOT['input']['lotteryId'];
        $k3LotteryName = ['jsk3', 'ynk3', 'fjk3', 'gxk3','jxk3', 'shk3', 'hebk3', 'hbk3', 'ahk3','jlk3','hnk3','gzk3','bjk3','qhk3','gsk3','nmgk3'];
        if (in_array($LOT['input']['lotteryId'], $k3LotteryName)) {
            $LOT['input']['lotteryId'] = 'k3';
        }
        $klLotteryName =['tjkl10','ynkl10','sxkl10','hnkl10','cqkl10','ffkl10','sfkl10'];
        if (in_array($LOT['input']['lotteryId'], $klLotteryName)) {
            $LOT['input']['lotteryId'] = 'kl10';
        }
        $choose5LotteryName =['gdchoose5','sdchoose5','fjchoose5','bjchoose5','ahchoose5','yfchoose5','sfchoose5'];
        if (in_array($LOT['input']['lotteryId'], $choose5LotteryName)) {
            $LOT['input']['lotteryId'] = 'choose5';
        }
    }
}
$LOT['a']            = isset($_GET['action']) ? $_GET['action'] : 'default';
$LOT['a']            = isset($_POST['action']) ? $_POST['action'] : $LOT['a'];
$LOT['lottery_type'] = isset($_GET['lotteryType']) ? $_GET['lotteryType'] : '';
$LOT['action']       = ['info', 'bet', 'syspars', 'notice'];
if (in_array($LOT['a'], $LOT['action'])) {
    include(IN_LOT . 'include/ajax/' . $LOT['a'] . '.php');
}
empty($LOT['output']) && result('Access Denied');
echo json_encode($LOT['output']);