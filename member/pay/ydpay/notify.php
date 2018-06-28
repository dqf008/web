<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
//返回数据
file_put_contents("success.txt", json_encode($_REQUEST) . "\n", FILE_APPEND);
require_once('yidao.php');
$pay_mid = $arr_online_config['易到微信']['pay_mid'];
$pay_mkey = $arr_online_config['易到微信']['pay_mkey'];
$pay_mkey = explode('|', $pay_mkey);
$ydpay = new yidao($pay_mid, $pay_mkey[0], $pay_mkey[1]);
//验证签名
$str = json_decode(stripslashes($_REQUEST['reqJson']));
if ($data = $ydpay->VerifySign($str->transData)) {
    if ($data['isClearOrCancel'] == "0") {
        $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $data["reqMsgId"]);
        if ($query->rowCount() > 0) {
            $order = $query->fetch();
        }
        $res = insert_online_money($order['username'], $data["reqMsgId"], $order['amount'], $order['pay_online']);
        if ($res == 1) {
            die("SUCCESS");
            return true;
        }
    }
}
die("ERROR");