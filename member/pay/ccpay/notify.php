<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
//处理数据
$myfile = fopen("payBack.log", "a") or die("Unable to open file!");
$Md5 = $arr_online_config['长城付微信']['pay_mkey'];
$remark = urldecode($_POST['remark']);
$post_data = array(
    "transDate" => $_POST['transDate'],
    "transTime" => urldecode($_POST['transTime']),
    "merchno" => $_POST['merchno'],
    "merchName" => $_POST['merchName'],
    //"customerno" =>$_POST['customerno'],
    "openId" => urldecode($_POST['openId']),
    "amount" => $_POST['amount'],
    "traceno" => $_POST['traceno'],
    "payType" => $_POST['payType'],
    "orderno" => $_POST['orderno'],
    "channelOrderno" => $_POST['channelOrderno'],
    "channelTraceno" => $_POST['channelTraceno'],
    "status" => $_POST['status'],
    "remark" => $remark
);
//签名操作
ksort($post_data);
$a = '';
foreach ($post_data as $x => $x_value) {
    if ($x_value) {
        $a = $a . $x . "=" . $x_value . "&";
    }
}
fwrite($myfile, "--------------------------------start--------------------------------\n");
fwrite($myfile, date('y-m-d H:i:s', time()) . "接收到的数据:" . file_get_contents("php://input"));
fwrite($myfile, "\n");
$b = md5($a . $Md5);
$c = $_POST['signature'];
$d = strtoupper($b);
fwrite($myfile, date('y-m-d H:i:s', time()) . "加密完成的字段:" . $d . "\n");
if ($d == $c) {
    //处理数据
    $query = $mydata1_db->query("SELECT * FROM `k_money_order` WHERE `mid`='" . $_POST['traceno'] . "'");
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
    }
    $res = insert_online_money($order['username'], $_POST['traceno'], $order['amount'], $order['pay_online']);
    if ($res == 1) {
        echo "success";
        fwrite($myfile, date('y-m-d H:i:s', time()) . "返回的数据:" . "success\n");
    }
} else {
    echo "fail";
    fwrite($myfile, date('y-m-d H:i:s', time()) . "返回的数据:" . "fail\n");
}
fwrite($myfile, "----------------------------------end--------------------------------\n");
fclose($myfile);