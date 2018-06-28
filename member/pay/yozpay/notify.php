<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
file_put_contents("success.txt", json_encode($_REQUEST) . "\n", FILE_APPEND);
//处理数据
$ReturnArray = array(
    "memberid" => $_REQUEST["memberid"], // 商户ID
    "orderid" => $_REQUEST["orderid"], // 订单号
    "amount" => $_REQUEST["amount"], // 交易金额
    "datetime" => $_REQUEST["datetime"], // 交易时间
    "transaction_id" => $_REQUEST["transaction_id"], // 支付流水号
    "returncode" => $_REQUEST["returncode"]
);
$Md5key = $arr_online_config['优付微信']['pay_mkey'];
ksort($ReturnArray);
reset($ReturnArray);
$md5str = "";
foreach ($ReturnArray as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
    $sting = $md5str;
}
$sign = strtoupper(md5($md5str . "key=" . $Md5key));
if ($sign == $_REQUEST["sign"]) {
    if ($_REQUEST["returncode"] == "00") {
        $mid = $_REQUEST["orderid"]; 
        $sql = "SELECT * FROM k_money_order WHERE `mid`='{$mid}'";
        $query = $mydata1_db->query($sql);
        if ($query->rowCount() > 0) {
            $order = $query->fetch();
            if ($order) {
                $res = insert_online_money($order['username'], $_REQUEST["orderid"], $order['amount'], $order['pay_online']);
                if ($res) {
                    exit("ok");
                } else {
                    exit("error");
                }
            }
        }
    }
}