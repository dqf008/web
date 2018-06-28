<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
//返回数据
$UserId = $_REQUEST['P_UserId'];
$OrderId = $_REQUEST["P_OrderId"];
$CardId = $_REQUEST["P_CardId"];
$CardPass = $_REQUEST["P_CardPass"];
$FaceValue = $_REQUEST["P_FaceValue"];
$ChannelId = $_REQUEST["P_ChannelId"];
$subject = iconv("GB2312", "UTF-8//IGNORE", $_REQUEST['P_Subject']);
$description = $_REQUEST["P_Description"];
$price = $_REQUEST["P_Price"];
$quantity = $_REQUEST["P_Quantity"];
$notic = $_REQUEST["P_Notic"];
$ErrCode = $_REQUEST["P_ErrCode"];
$PostKey = $_REQUEST["P_PostKey"];
$payMoney = $_REQUEST["P_PayMoney"];

$SalfStr = $arr_online_config['32微信']['pay_mkey'];

$preEncodeStr = $UserId . "|" . $OrderId . "|" . $CardId . "|" . $CardPass . "|" . $FaceValue . "|" . $ChannelId . "|" . $payMoney . "|" . $ErrCode . "|" . $SalfStr;

$encodeStr = md5($preEncodeStr);

if ($PostKey == $encodeStr) {
    if ($ErrCode == "0") {
        //处理数据
        $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $OrderId);
        if ($query->rowCount() > 0) {
            $order = $query->fetch();
        }
        $res = insert_online_money($order['username'], $OrderId, $payMoney, $order['pay_online']);
        if ($res == 1) {
            exit("支付成功");
        }
    }
}