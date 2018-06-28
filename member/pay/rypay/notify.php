<?php
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
header("Content-type: text/html; charset=utf-8");
$SalfStr = $arr_online_config['如意微信']['pay_mkey'];
$UserId = $_REQUEST['P_UserId'];
$OrderId = $_REQUEST["P_OrderId"];
$CardId = $_REQUEST["P_CardId"];
$CardPass = $_REQUEST["P_CardPass"];
$FaceValue = $_REQUEST["P_FaceValue"];
$ChannelId = $_REQUEST["P_ChannelId"];
$subject = $_REQUEST["P_Subject"];
$description = $_REQUEST["P_Description"];
$price = $_REQUEST["P_Price"];
$quantity = $_REQUEST["P_Quantity"];
$notic = $_REQUEST["P_Notic"];
$ErrCode = $_REQUEST["P_ErrCode"];
$PostKey = $_REQUEST["P_PostKey"];
$payMoney = $_REQUEST["P_PayMoney"];
$ErrMsg = $_REQUEST["P_ErrMsg"]; //错误描述
$preEncodeStr = $UserId . "|" . $OrderId . "|" . $CardId . "|" . $CardPass . "|" . $FaceValue . "|" . $ChannelId . "|" . $payMoney . "|" . $ErrCode . "|" . $SalfStr;
//file_put_contents("success.txt", $preEncodeStr . "\n", FILE_APPEND);
$encodeStr = md5($preEncodeStr);
//file_put_contents("success.txt", $encodeStr . "\n", FILE_APPEND);
//file_put_contents("success.txt", $PostKey . "\n", FILE_APPEND);
if ($PostKey == $encodeStr) {
    if ($ErrCode == "0") {
        //处理数据
        $sql = "SELECT * FROM k_money_order WHERE `mid`='{$OrderId}'";
        $query = $mydata1_db->query($sql);
        if ($query->rowCount() > 0) {
            $order = $query->fetch();
            $res = insert_online_money($order['username'], $OrderId, $order['amount'], $order['pay_online']);
            if ($res == 1) {
                exit("SUCCESS");
            }
        }
	}
}