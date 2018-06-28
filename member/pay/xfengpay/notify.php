<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
file_put_contents("success.txt", file_get_contents("php://input") . "\n", FILE_APPEND);
//$_REQUEST = '{"merchant":"XF30302198","amount":"0.01","currency":"CNY","orderNo":"201802051151165253521025","m_orderNo":"151780267284759","payType":"ONLINE_BANK_PAY","status":2,"sign":"cd8f1c6115a4a0b3b51b4b53a1ffb471"}';
$_REQUEST = file_get_contents("php://input");
$_REQUEST = json_decode($_REQUEST, true);
$pay_mkey = $arr_online_config['先疯微信']['pay_mkey'];
$native = $_REQUEST;
unset($native['sign']);
ksort($native);
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
$md5str = $md5str . "key=" . $pay_mkey;
$sign = md5($md5str);
$mid = $_REQUEST["m_orderNo"];
if ($sign != $_REQUEST["sign"]) {
    echo "签名错误";
} else {
    //校验key成功，是自己人。执行自己的业务逻辑：加余额，订单付款成功，装备购买成功等等。
    $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $mid);
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
    }
    $res = insert_online_money($order['username'], $mid, $order['amount'], $order['pay_online']);
    if ($res == 1) {
        exit("SUCCEED");
    }
}