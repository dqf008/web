<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
//返回数据
$data = $_REQUEST['data'];

$Md5key = $arr_online_config['轻易2微信']['pay_mkey'];

include('util.php');

if (!empty($data)){
	$data = urldecode($data);
	$data = $Rsa->decode($data);
	$rows = callback_to_array($data, $Md5key);
	$_REQUEST["sign"] = $rows['sign'];
	unset($rows['sign']);
	$sign = create_sign($rows, $Md5key);
    if ($sign == $_REQUEST["sign"]) {
        if ($rows["payResult"] == "00") {
            $ext = $rows['goodsName'];
            $uid = $ext;
            //处理数据
            $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $rows["orderNum"]);
            if ($query->rowCount() > 0) {
                $order = $query->fetch();
            }
            $res = insert_online_money($order['username'], $rows["orderNum"], $rows['amount'], $order['pay_online']);
            if ($res == 1) {
                exit(0);
            }
        }
    }
}