<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
file_put_contents("success.txt", json_encode($_GET) . "\n", FILE_APPEND);
//$_GET = '{"partner":"22225","ordernumber":"151331769461793","orderstatus":"1","paymoney":"2.0000","sysnumber":"20171215140124256110962","attach":"","sign":"fbb318c213374f1982954d97c4f1b27b"}';
//$_GET = json_decode($_GET, true);
$key = $arr_online_config['金阳微信']['pay_mkey'];
$partner = trim($_GET['partner']);
$ordernumber = trim($_GET['ordernumber']);
$orderstatus = trim($_GET['orderstatus']);
$paymoney = trim($_GET['paymoney']);
$sysnumber = trim($_GET['sysnumber']);
$attach = trim($_GET['attach']);
$sign = trim($_GET['sign']);
$sign_text = "partner=" . $partner . "&ordernumber=" . $ordernumber . "&orderstatus=" . $orderstatus . "&paymoney=" . $paymoney;
$sign_md5 = md5($sign_text . $key);
if ($sign == $sign_md5) {
    if ($orderstatus == "1") {
        //成功逻辑处理，现阶段只发送成功的单据
        $sql = "SELECT * FROM k_money_order WHERE `mid`='{$ordernumber}'";
        $query = $mydata1_db->query($sql);
        if ($query->rowCount() > 0) {
            $order = $query->fetch();
            if ($order) {
                $res = insert_online_money($order['username'], $ordernumber, $order['amount'], $order['pay_online']);
                if ($res) {
                    exit("ok");
                }
            }
        }
    }
} else {
    //加密错误
    exit("error");
}