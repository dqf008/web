<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
//返回数据
file_put_contents("success.txt", json_encode($_POST) . "\n", FILE_APPEND);
//$_POST = '{"buyer_email":"","money":"0.05","orderUid":"","out_trade_no":"151660566983410","payMoney":"0.01","payTime":"2018-01-22 15:20:45","return_code":"success","shopname":"","token":"4bc6975b77ac6bc7c09a8e13d7084604","trade_no":"261516605643955"}';
//$_POST = json_decode($_POST, true);
$orderid = $_POST["out_trade_no"];
$money = $_POST["money"];
$payMoney = $_POST["payMoney"];
$token = $_POST["token"];
$returncode = $_POST["return_code"];
//校验传入的参数是否格式正确，略
$shopId = $arr_online_config['小熊微信']['pay_mid'];
$key = $arr_online_config['小熊微信']['pay_mkey'];
$temps = md5($shopId . $orderid . $money . $key . $returncode);
if ($temps != $token) {
    echo "failure";
} else {
    //校验key成功，是自己人。执行自己的业务逻辑：加余额，订单付款成功，装备购买成功等等。
    $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $orderid);
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
    }
    $res = insert_online_money($order['username'], $orderid, $payMoney, $order['pay_online']);
    if ($res == 1) {
        exit("success");
    }    
}