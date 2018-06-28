<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
//处理数据
$returnArray = array( // 返回字段
    "memberid" => $_REQUEST["memberid"], // 商户ID
    "orderid" => $_REQUEST['orderid'], // 订单号
    'transaction_id' => $_REQUEST["transaction_id"], //支付流水号
    "amount" => $_REQUEST["amount"], // 交易金额
    "datetime" => $_REQUEST["datetime"], // 交易时间
    "returncode" => $_REQUEST["returncode"] // 交易状态
);

$Md5key = $arr_online_config['神付宝微信']['pay_mkey'];

ksort($returnArray);
$md5str = "";
foreach ($returnArray as $key => $val) {
    if(!empty($val)){
        $md5str = $md5str . $key . "=" . $val . "&";
    }
}
$sign = strtoupper(md5($md5str . "key=" . $Md5key));
if ($sign == $_REQUEST["sign"]) {
    if ($_REQUEST["returncode"] == "00") {
        $str = "交易成功！订单号：" . $_REQUEST["orderid"];
        //file_put_contents("success.txt",$str."\n", FILE_APPEND);
        //
        foreach ($_POST as $key => $val) {
            $md5str .= "{$key}={$val}&";            
        }
        
        //file_put_contents("success.txt", $md5str."\n", FILE_APPEND);
        $ext = $_REQUEST['attach'];
        $uid = $ext;
        //处理数据
        $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $_REQUEST["orderid"]);
        if ($query->rowCount() > 0) {
            $order = $query->fetch();
        }
        $res = insert_online_money($order['username'], $_REQUEST["orderid"], $_REQUEST['amount'], $order['pay_online']);
        if ($res == 1) {
            exit("ok");
        }  
    }
}