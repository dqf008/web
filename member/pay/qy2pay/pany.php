<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST' || (!isset($_POST['S_Name']) || empty($_POST['S_Name']))) {
    exit('Access Denied1');
}

$pay_online = $_POST['pay_online'];
//include('./config.php'); 
include("../moneyconfig.php");
include("../../../cache/website.php");
include("../../../database/mysql.config.php");
include_once '../moneyfunc.php';
$query = $mydata1_db->prepare('SELECT uid,username FROM `k_user` WHERE `username`=:username');
$query->execute(array(
    ':username' => $_POST['S_Name']
));
if ($query->rowCount() > 0) {
    $rows = $query->fetch();
} else {
    exit('Access Denied');
}

(!isset($_POST['MOAmount']) || !preg_match('/^\d+(\.\d+)?$/', $_POST['MOAmount'])) && $_POST['MOAmount'] = $web_site['ck_limit'];
$_POST['MOAmount'] = number_format($_POST['MOAmount'] < $web_site['ck_limit'] ? $web_site['ck_limit'] : $_POST['MOAmount'], 2, '.', '');

//$_payId = generate_id('TL', $rows['uid']); //商户流水号
// print_r($merchant_url);exit;
//print_r($pay_mid);

//定义
$merchantCode = $pay_mid;
$md5Key = $pay_mkey;
$noticeUrl = $notice_url;
$amount = $_POST['MOAmount'] * 100;
$ext = $rows['uid'];

//echo $ext;
if ($_REQUEST['S_Type'] == 'WECHAT') {
    $payChannel = '1';
} elseif ($_REQUEST['S_Type'] == 'JDPAY') {
    $payChannel = '2';
} elseif ($_REQUEST['S_Type'] == 'BDPAY') {
    $payChannel = '3';
} else {
    $payChannel = '4';
}
//增加 订单
$_payId = time() . rand(10000, 99999);
$stmt = $mydata1_db->prepare('INSERT INTO `k_money_order` (`uid`, `username`, `mid`, `did`, `pay_online`, `amount`, `status`) VALUES (:uid, :username, :mid, :did, :pay_online, :amount, 0)');
$stmt->execute(array(
    ':uid' => $rows['uid'],
    ':username' => $rows['username'],
    ':mid' => $_payId,
    ':did' => '',
    ':pay_online' => $pay_online,
    ':amount' => $_POST['MOAmount'] / 100
));

require 'post_get.php';