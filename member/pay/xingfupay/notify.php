<?php
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
require_once("Pay.class.php");
//file_put_contents("success.txt",json_encode($_REQUEST)."\n", FILE_APPEND);
//$_REQUEST = '{"service":"TRADE.NOTIFY","merId":"2017090544010402","tradeNo":"151288192242911","tradeDate":"20171210","opeNo":"247261","opeDate":"20171210","amount":"1.00","status":"1","extra":"163","payTime":"20171210125851","sign":"60BC5C802AA54FBDAA2067EB08C7D6B9","notifyType":"1"}';
//$_REQUEST = json_decode($_REQUEST, true);
//接受数据
// 请求数据赋值
$data = array();
$data['service'] = $_REQUEST["service"];
// 通知时间
$data['merId'] = $_REQUEST["merId"];
// 支付金额(单位元，显示用)
$data['tradeNo'] = $_REQUEST["tradeNo"];
// 商户号
$data['tradeDate'] = $_REQUEST["tradeDate"];
// 商户参数，支付平台返回商户上传的参数，可以为空
$data['opeNo'] = $_REQUEST["opeNo"];
// 订单号
$data['opeDate'] = $_REQUEST["opeDate"];
// 订单日期
$data['amount'] = $_REQUEST["amount"];
// 支付订单号
$data['status'] = $_REQUEST["status"];
// 支付账务日期
$data['extra'] = $_REQUEST["extra"];
// 订单状态，0-未支付，1-支付成功，2-失败，4-部分退款，5-退款，9-退款处理中
$data['payTime'] = $_REQUEST["payTime"];
// 签名数据
$data['sign'] = $_REQUEST["sign"];
$data['notifyType'] = $_REQUEST["notifyType"];
//处理数据
$mid = $data['tradeNo']; //订单号
$sql = "SELECT * FROM k_money_order WHERE `mid`='{$mid}'";
$query = $mydata1_db->query($sql);
if ($query->rowCount() > 0) {
    $order = $query->fetch();
}
if ($order) {
    $pay_online = $order['pay_online']; 
    $conf = $arr_online_config[$pay_online]; 
    $pay_mid = $conf['pay_mid'];
    $conf['pay_mkey']; //取出KEY
    $KEY = $conf['pay_mkey'];
    $GATEWAY_URL = $conf['merchant_url'];
}
// 初始化
$pPay = new Pay($KEY, $GATEWAY_URL);
// 准备准备验签数据
$str_to_sign = $pPay->prepareSign($data);
// 验证签名
$resultVerify = $pPay->verify($str_to_sign, $data['sign']);
if ($resultVerify) {
    if ($order) {
        $res = insert_online_money($order['username'], $_REQUEST["tradeNo"], $_REQUEST['amount'], $order['pay_online']);
        if ($res) {
            echo "SUCCESS";
        }
    }
} else {
    echo "error";
}