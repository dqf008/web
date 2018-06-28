<?php
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
header("Content-type: text/html; charset=utf-8");
file_put_contents("success.txt", json_encode($_POST) . "\n", FILE_APPEND);
$Md5key = $arr_online_config['艾米森微信']['pay_mkey'];
$native = $_POST;
ksort($native);
unset($native['sign']);
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
$md5str = $md5str . 'key=' . $Md5key;
$sign = strtoupper(md5($md5str));
if ($sign == $_POST["sign"]) {
    //处理数据
    $mid = $_POST["out_trade_no"]; //订单号
    $sql = "SELECT * FROM k_money_order WHERE `mid`='{$mid}'";
    $query = $mydata1_db->query($sql);
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
        $res = insert_online_money($order['username'], $_POST["out_trade_no"], $order['amount'], $order['pay_online']);
        if ($res == 1) {
            exit("SUCCESS");
        }
    }
}