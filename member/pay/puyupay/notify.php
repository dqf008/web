<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
file_put_contents("success.txt", json_encode($_REQUEST) . "\n", FILE_APPEND);
//$_REQUEST = '{"payType":"1009","orderId":"151808106524765","retCode":"000000","retMsg":"","amount":"100","timestamp":"1829162731","signature":"5C01E3E0DD210BE199C56BA8DCA5A69C575AF5C5","outOrderNo":"151808106524765","?payType":"1009"}';
//$_REQUEST = json_decode($_REQUEST, true);
//处理数据
$pay_mid = $arr_online_config['秒付宝微信']['pay_mid'];
$pay_mkey = $arr_online_config['秒付宝微信']['pay_mkey'];
$ReturnArray = array(
    "payType" => $_REQUEST["payType"],
    "orderId" => $_REQUEST["orderId"],
    "retCode" => $_REQUEST["retCode"],
    "merchantId" => $pay_mid,
    "amount" => $_REQUEST["amount"],
    "timestamp" => $_REQUEST["timestamp"]
);
$md5str = http_build_query($ReturnArray);
$md5str = urldecode($md5str);
$signature = strtoupper(sha1($md5str));
if ($signature == $_REQUEST["signature"]) {
    if ($_REQUEST["retCode"] == "000000") {
        //处理数据
        $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $_REQUEST["orderId"]);
        if ($query->rowCount() > 0) {
            $order = $query->fetch();
        }
        $res = insert_online_money($order['username'], $_REQUEST["orderId"], $order['amount'], $order['pay_online']);
        if ($res == 1) {
            exit("ok");
        }
    }
}