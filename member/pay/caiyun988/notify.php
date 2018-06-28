<?php
header("Content-type: text/html; charset=utf-8");
include_once '../../../database/mysql.config.php';
include_once '../moneyfunc.php';
include_once("./merchant.php");
file_put_contents("success.txt", json_encode($_POST) . "\n", FILE_APPEND);
//$_POST = '{"trade_no":"1000008320","extra_return_param":"163","sign_type":"RSA-S","notify_type":"offline_notify","merchant_code":"988000000015","order_no":"151598299714691","trade_status":"SUCCESS","sign":"KUREv\/NLBu8mS8aJGTDDwiNGDuXU6VjpamHtJ7pVMQZ\/HoTjDJYNDR63Pc8RQSHLDRa3FNLFKmefooBqxSaSQTF5mofeZxg1yeRcI\/SPz69jq7N19BnokqxQCoNODegIOxwMu0uyoykeQ5EeS\/ICm1Kcks1a6CcYPlZCF5WnlFA=","order_amount":"0.01","interface_version":"V3.0","bank_seq_no":"1006586056","order_time":"2018-01-14 22:23:17","notify_id":"4543ad3751024c2eb98133e47cb0e8b8","trade_time":"2018-01-15 10:22:36"}';
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
$debaozhifu_public_key = openssl_get_publickey($debaozhifu_public_key);
$flag = openssl_verify($signStr, $dinpaySign, $debaozhifu_public_key, OPENSSL_ALGO_MD5);
file_put_contents("success.txt", $flag . "\n", FILE_APPEND);
if ($flag) {
    //处理数据
    $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $_POST["order_no"]);
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
    }
    $res = insert_online_money($order['username'], $_POST["order_no"], $order['amount'], $order['pay_online']);
    if ($res == 1) {
        exit("SUCCESS");
    }
}