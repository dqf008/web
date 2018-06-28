<?php
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
file_put_contents("success.txt", json_encode($_GET) . "\n", FILE_APPEND);
//$_GET = '{"orderid":"151331174315365","opstate":"0","ovalue":"0.02","systime":"2017\/12\/15 12:22:30","sysorderid":"1712151222158890708","completiontime":"2017\/12\/15 12:22:30","attach":"163","msg":"","sign":"ad36dca3d8ffea89ce7716dd90436720"}';
//$_GET = json_decode($_GET, true);
$key = $arr_online_config['得利通微信']['pay_mkey'];
$orderid = trim($_GET['orderid']);
$opstate = trim($_GET['opstate']);
$ovalue = trim($_GET['ovalue']);
$attach = trim($_GET['attach']);
$sign = trim($_GET['sign']);
$sign_text = "orderid=" . $orderid . "&opstate=" . $opstate . "&ovalue=" . $ovalue;
$sign_md5 = md5($sign_text . $key);
if ($sign == $sign_md5) {
    if ($opstate == "0") {
        //成功逻辑处理，现阶段只发送成功的单据
        $sql = "SELECT * FROM k_money_order WHERE `mid`='{$orderid}'";
        $query = $mydata1_db->query($sql);
        if ($query->rowCount() > 0) {
            $order = $query->fetch();
            if ($order) {
                $res = insert_online_money($order['username'], $orderid, $ovalue, $order['pay_online']);
                if ($res) {
                    echo 'SUCCESS';
                }
            }
        }        
    }
} else {
    //加密错误
}