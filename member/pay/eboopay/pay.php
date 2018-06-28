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
$amount = $_POST['MOAmount'];
$ext = $rows['uid'];
//echo $ext;
if ($_REQUEST['S_Type'] == 'WECHAT') {
    $payChannel = 'WXZF';
}
if ($_REQUEST['S_Type'] == 'ALIPAY') {
    $payChannel = 'ALIPAY';
}
if ($_REQUEST['S_Type'] == 'QQPAY') {
    $payChannel = 'TENPAY';
}
if ($_REQUEST['S_Type'] == 'JDPAY') {
    $payChannel = 'JDPAY';
}
if ($_REQUEST['S_Type'] == 'UNIONPAY') {
    $payChannel = 'UNIONQRPAY';
}
//增加 订单
$_payId = date("YmdHis") . rand(100000, 999999) . $pay_mid;
$stmt = $mydata1_db->prepare('INSERT INTO `k_money_order` (`uid`, `username`, `mid`, `did`, `pay_online`, `amount`, `status`) VALUES (:uid, :username, :mid, :did, :pay_online, :amount, 0)');
$stmt->execute(array(
    ':uid' => $rows['uid'],
    ':username' => $rows['username'],
    ':mid' => $_payId,
    ':did' => '',
    ':pay_online' => $pay_online,
    ':amount' => $_POST['MOAmount']
));

require 'get.php';