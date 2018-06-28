<?php
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
require_once "fun.php";
file_put_contents("success.txt", json_encode($_POST) . "\n", FILE_APPEND);
//$_REQUEST = '{"tranTime":"20171218 00:36:19","orderStatusMsg":"\u4ea4\u6613\u6210\u529f","merchOrderId":"151352833359778","orderId":"I201712180000625334","amt":"2","status":"0","md5value":"7691104635F90E58D35F1A600A81C669"}';
//$data = json_decode($_POST);
$merKey = $arr_online_config['五福微信']['pay_mkey']; //注意，Key是根据商户密钥去做调整, 跟DEMO下单页面填写的是一样的
$parms = array();
foreach ($_POST as $key => $value) {
    if ($key == "md5value") {
        continue;
    } else if ($value === "") {
        continue;
    } else {
        $parms[$key] = $value;
    }
}
$md5value = $_POST["md5value"];
$md5Str = makeSign($parms, $merKey);
if ($md5value == $md5Str) {
    //do your business
    $status = $parms["status"];
    $orderStatusMsg = $parms["orderStatusMsg"];
    $merchOrderId = $parms["merchOrderId"];
    $amt = $parms["amt"];
    $status = $parms["status"];
    //这个参数判断一下是否为空
    //$merData = $parms["merData"];
    $mid = $merchOrderId; //订单号
    $sql = "SELECT * FROM k_money_order WHERE `mid`='{$mid}'";
    $query = $mydata1_db->query($sql);
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
        if ($order) {
            $res = insert_online_money($order['username'], $merchOrderId, $order['amount'], $order['pay_online']);
            if ($res) {
                echo "SUCCESS";
            }
        }
    }
} else {
    echo "FAIL";
}