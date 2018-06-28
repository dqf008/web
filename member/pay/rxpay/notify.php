<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
//返回数据
file_put_contents("success.txt", json_encode($_REQUEST) . "\n", FILE_APPEND);
//$_REQUEST = '{"partner":"20449","ordernumber":"151556776585036","orderstatus":"1","paymoney":"10.000","sysnumber":"RX180110150209376621","attach":"","sign":"9162ad137e88e161b6a124f94e611130"}';
//$_REQUEST = json_decode($_REQUEST, true);
$partner = $arr_online_config['仁信微信']['pay_mid']; //商户ID
$key = $arr_online_config['仁信微信']['pay_mkey']; //商户KEY
$orderstatus = $_REQUEST["orderstatus"];
$ordernumber = $_REQUEST["ordernumber"];
$paymoney = $_REQUEST["paymoney"];
$sign = $_REQUEST["sign"];
$attach = $_REQUEST["attach"];
$signSource = sprintf("partner=%s&ordernumber=%s&orderstatus=%s&paymoney=%s%s", $partner, $ordernumber, $orderstatus, $paymoney, $key);
if ($sign == md5($signSource)) {
    //处理数据
    $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $ordernumber);
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
    }
    $res = insert_online_money($order['username'], $ordernumber, $order['amount'], $order['pay_online']);
    if ($res == 1) {
        exit("ok");
    }
}