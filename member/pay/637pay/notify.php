<?php
$pay_online = '闪亿付微信';
//file_put_contents('data.txt', json_encode($_POST));
$_POST = json_decode('{"data":"AggDbYdRmGxBwqlO4QPnBLctoSPcp8eTl9mfIywVJ\/9VjgULYna0YLWq1xwnQgKr3LahCHTWhszSTfjasg3kY\/rQ0D+GqfPlQy2iE6tR1cqbNIXMkNjSOMTcMVXLsXmQRjgU4KUqmw9QhCtOAPGYIv64HktzCIEevWNac7G8fSJVhn+zWP94JO8wnz\/h9FRndEhB7XW\/KygIM7xJBNllsdS6UL7vIk+4zCwDvzg+UMrDxeflWovaJwH4qoNix1jpnqB3Bd2tpcVz1uCe1\/9PNIPIx3VfmIi+Uawo94EJnc1Ui3uzqXGHZqrbM\/Bhlau1N2TSt5KgX9YgaJoc0m9k\/g==","merchNo":"SYF201803150136","orderNum":"2018032404184919269"}', true);
header("Content-type: text/html; charset=utf-8");
include_once '../../../database/mysql.config.php';
include_once '../moneyfunc.php';
include_once '../moneyconfig.php';
include_once('util.php');
$Rsa = new Rsa();
$data = isset($_POST['data']) ? $_POST['data'] : '';
if (!empty($data)){
	$data = urldecode($data);
	$data = $Rsa->decode($data);
	$rows = callback_to_array($data, $pay_mkey);
	log_write("收到支付回调通知");
	log_write(PS($rows));
}
echo "0";

// $para_temp['MerchantId']=$_REQUEST['MerchantId'];
// $para_temp['Code']=$_REQUEST['Code'];
// $para_temp['PaymentNo']=$_REQUEST['PaymentNo'];
// $para_temp['OutPaymentNo']=$_REQUEST['OutPaymentNo'];
// $para_temp['PaymentAmount']=$_REQUEST['PaymentAmount'];
// $para_temp['PaymentFee']=$_REQUEST['PaymentFee'];
// $para_temp['PaymentState']=$_REQUEST['PaymentState'];
// $para_temp['PassbackParams']=$_REQUEST['PassbackParams'];
// $Sign=$_REQUEST['Sign'];
// if($para_temp['Code']=="200"){
//    $submit = new Submit($config);
//    $html_text = $submit->buildRequestPara($para_temp);
// 	if($html_text['Sign']==strtolower($Sign)){
// 	    $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $_REQUEST["OutPaymentNo"]);
// 	    if ($query->rowCount() > 0) {
// 	        $order = $query->fetch();
// 	        $res = insert_online_money($order['username'], $_REQUEST["order_no"], $order['amount'], $order['pay_online']);
// 			if ($res == 1) exit("SUCCESS");
// 	    }
//     }
// }
// exit('ERROR');