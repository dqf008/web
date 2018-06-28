<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
file_put_contents("success.txt", json_encode($_REQUEST) . "\n", FILE_APPEND);
//$_REQUEST = '{"orderid":"151740871525389","opstate":"0","ovalue":"0.05","sysorderid":"B5076663343591895525","systime":"2018\/01\/31 22:24:51","attach":"","msg":"","sign":"4a7142878b772a1df6380c3ecf006312"}';
//$_REQUEST = json_decode($_REQUEST, true);
$native = array(
    "orderid" => $_REQUEST["orderid"],
    "opstate" => $_REQUEST["opstate"], 
    "ovalue" => $_REQUEST["ovalue"], 
    "time" => $_REQUEST["systime"], 
    "sysorderid" => $_REQUEST["sysorderid"]
);
$pay_mkey = $arr_online_config['讯宝微信']['pay_mkey'];
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
$md5str = rtrim($md5str, '&');
$md5str = $md5str . $pay_mkey;
$sign = md5($md5str);
if ($sign == $_REQUEST["sign"]) {
    if ($_REQUEST["opstate"] == "0") {
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