<?php
file_put_contents('data.txt', json_encode($_REQUEST));
header("Content-type: text/html; charset=utf-8");
include_once '../../../database/mysql.config.php';
include_once '../moneyfunc.php';
include_once("./merchant.php");
require_once("config.php");
require_once("lib/submit.class.php");
$para_temp['MerchantId']=$_REQUEST['MerchantId'];
$para_temp['Code']=$_REQUEST['Code'];
$para_temp['PaymentNo']=$_REQUEST['PaymentNo'];
$para_temp['OutPaymentNo']=$_REQUEST['OutPaymentNo'];
$para_temp['PaymentAmount']=$_REQUEST['PaymentAmount'];
$para_temp['PaymentFee']=$_REQUEST['PaymentFee'];
$para_temp['PaymentState']=$_REQUEST['PaymentState'];
$para_temp['PassbackParams']=$_REQUEST['PassbackParams'];
$Sign=$_REQUEST['Sign'];
if($para_temp['Code']=="200"){
   $submit = new Submit($config);
   $html_text = $submit->buildRequestPara($para_temp);
	if($html_text['Sign']==strtolower($Sign)){
	    $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $_REQUEST["OutPaymentNo"]);
	    if ($query->rowCount() > 0) {
	        $order = $query->fetch();
	        $res = insert_online_money($order['username'], $_REQUEST["order_no"], $order['amount'], $order['pay_online']);
			if ($res == 1) exit("SUCCESS");
	    }
    }
}
exit('ERROR');