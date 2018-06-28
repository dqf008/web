<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
file_put_contents("success.txt", json_encode($_POST) . "\n", FILE_APPEND);
//$_POST = '{"trade_no":"1067733656","extra_return_param":"163","sign_type":"RSA-S","notify_type":"offline_notify","merchant_code":"100100004078","order_no":"151660360689455","trade_status":"SUCCESS","sign":"bqFc0ggKGIYwHDMXlnGsGV0n7OHmed2QQJnNxn3dbJAsb7vrqyqsNl436tU9sBD+VES3xNMgBtshHqXHjyFblkSmJy2qKTRiaWZGbyeoztGrzDTIggo6Gmw3WH37aOLWzYWirUfCVXxlBSI+jtlVad\/CJZF4HSY3BmhEWYGqiFA=","order_amount":"1","interface_version":"V3.0","bank_seq_no":"2018012214455830729055384231","order_time":"2018-01-22 02:46:46","notify_id":"cab9222e839445329835414103861385","trade_time":"2018-01-22 14:45:58"}';
//$_POST = json_decode($_POST, true);
$merchant_code = $_POST["merchant_code"];
$interface_version = $_POST["interface_version"];
$sign_type = $_POST["sign_type"];
$dinpaySign = base64_decode($_POST["sign"]);
//$dinpaySign = $_POST["sign"];
$notify_type = $_POST["notify_type"];
$notify_id = $_POST["notify_id"];
$order_no = $_POST["order_no"];
$order_time = $_POST["order_time"];
$order_amount = $_POST["order_amount"];
$trade_status = $_POST["trade_status"];
$trade_time = $_POST["trade_time"];
$trade_no = $_POST["trade_no"];
$bank_seq_no = $_POST["bank_seq_no"];
$extra_return_param = $_POST["extra_return_param"];
$orginal_money = $_POST["orginal_money"]; //原始订单金额
$signStr = "";
if ($bank_seq_no != "") {
    $signStr = $signStr . "bank_seq_no=" . $bank_seq_no . "&";
}
if ($extra_return_param != "") {
    $signStr = $signStr . "extra_return_param=" . $extra_return_param . "&";
}
$signStr = $signStr . "interface_version=" . $interface_version . "&";
$signStr = $signStr . "merchant_code=" . $merchant_code . "&";
$signStr = $signStr . "notify_id=" . $notify_id . "&";
$signStr = $signStr . "notify_type=" . $notify_type . "&";
$signStr = $signStr . "order_amount=" . $order_amount . "&";
$signStr = $signStr . "order_no=" . $order_no . "&";
$signStr = $signStr . "order_time=" . $order_time . "&";
if ($orginal_money != "") {
    $signStr = $signStr . "orginal_money=" . $orginal_money . "&"; //原始订单金额
}
$signStr = $signStr . "trade_no=" . $trade_no . "&";
$signStr = $signStr . "trade_status=" . $trade_status . "&";
$signStr = $signStr . "trade_time=" . $trade_time;
$pay_pubKey = $arr_online_config['智通宝微信']['pay_pubKey'];
$dinpay_public_key = chunk_split($pay_pubKey, 64, "\n");
$dinpay_public_key = "-----BEGIN PUBLIC KEY-----\n" . $dinpay_public_key . "-----END PUBLIC KEY-----\n";
$dinpay_public_key = openssl_get_publickey($dinpay_public_key);
$flag = openssl_verify($signStr, $dinpaySign, $dinpay_public_key, OPENSSL_ALGO_MD5);
file_put_contents("success.txt", $flag . "\n", FILE_APPEND);
if ($flag) {
    //处理数据
    $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $order_no);
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
    }
    $res = insert_online_money($order['username'], $order_no, $order['amount'], $order['pay_online']);
    if ($res == 1) {
        exit("SUCCESS");
    } 
}