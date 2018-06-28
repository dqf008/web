<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
//返回数据
file_put_contents("success.txt", json_encode($_POST) . "\n", FILE_APPEND);
//$_POST = '{"success":"1","error":"0","message":"\u652f\u4ed8\u6210\u529f","appid":"800300","billno":"18020722365251161800300657101281","order_id":"151801420971012","remark":"","amount":"100","payment":"1","type":"pay","state":"1","time":"2018-02-07 22:37:14","sign":"8A7FAA6E6B30D46BF3A0929656FE011F"}';
//$_POST = json_decode($_POST, true);
$pay_mkey = $arr_online_config['黄金微信']['pay_mkey'];
$native = $_POST;
unset($native['sign']);
ksort($native);
$md5str = "";
foreach ($native as $key => $val) {
    if ($val != '')
        $md5str = $md5str . $key . "=" . $val . "&";
}
$md5str = $md5str . "key=" . $pay_mkey;
$sign = strtoupper(md5($md5str));
if ($sign != $_POST['sign']) {
    echo "failure";
} else {
    //校验key成功，是自己人。执行自己的业务逻辑：加余额，订单付款成功，装备购买成功等等。
    $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $_POST['order_id']);
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
    }
    $res = insert_online_money($order['username'], $_POST['order_id'], $_POST['payment'] / 100, $order['pay_online']);
    if ($res == 1) {
        exit("success");
    }    
}