<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
//返回数据
$ReturnArray = array(
    "partner" => $_REQUEST["partner"],
    "ordernumber" => $_REQUEST["ordernumber"],
    "orderstatus" => $_REQUEST["orderstatus"],
    "paymoney" => $_REQUEST["paymoney"]
);
$_REQUEST['attach'] = iconv("GB2312", "UTF-8//IGNORE", $_REQUEST['attach']);
$Md5key = $arr_online_config['高通微信']['pay_mkey'];
$md5str = "";
foreach ($ReturnArray as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
$md5str = rtrim($md5str, '&');
$md5str = $md5str . $Md5key;
$sign = strtolower(md5($md5str));
if ($sign == $_REQUEST["sign"]) {
    if ($_REQUEST["orderstatus"] == "1") {
        $str = "交易成功！订单号：" . $_REQUEST["ordernumber"];
        //file_put_contents("success.txt",$str."\n", FILE_APPEND);
        foreach ($_REQUEST as $key => $val) {
            $str .= "{$key}={$val}&";
        }
        //file_put_contents("success.txt", $str."\n", FILE_APPEND);
        $ext = $_REQUEST['remark'];
        $uid = $ext;
        //处理数据
        $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $_REQUEST["ordernumber"]);
        if ($query->rowCount() > 0) {
            $order = $query->fetch();
        }
        $res = insert_online_money($order['username'], $_REQUEST["ordernumber"], $_REQUEST['paymoney'], $order['pay_online']);
        if ($res == 1) {
            exit("success");
        }
    }
}