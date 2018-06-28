<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
require_once("lib/Pay.class.php");
file_put_contents("success.txt", json_encode($_REQUEST) . "\n", FILE_APPEND);
$pay_mkey = $arr_online_config['天机付微信']['pay_mkey'];
$merchant_url = $arr_online_config['天机付微信']['merchant_url'];
// 请求数据赋值
$data = "";
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
// 初始化
$pPay = new Pay($pay_mkey, $merchant_url);
// 准备准备验签数据
$str_to_sign = $pPay->prepareSign($data);
// 验证签名
$resultVerify = $pPay->verify($str_to_sign, $data['sign']);
//var_dump($data);
if ($resultVerify) {
    //处理数据
    $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $_REQUEST["tradeNo"]);
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
    }
    $res = insert_online_money($order['username'], $_REQUEST["tradeNo"], $order['amount'], $order['pay_online']);
    if ($res == 1) {
        exit("SUCCESS");
    }
}