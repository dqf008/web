<?php
$pay_online = '密付微信';
file_put_contents('data.txt', json_encode($_REQUEST));
header("Content-type: text/html; charset=utf-8");
include_once '../../../database/mysql.config.php';
include_once '../moneyfunc.php';
include_once '../moneyconfig.php';
$param = $_POST;
if($param['code'] == '1000'){
	$sign = $param['sign'];
	unset($param['sign']);
	ksort($param);
	$str = http_build_query($param) . '&key='.$pay_mkey;
	if($sign == md5($str)){
		$query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $param["billno"]);
	    if ($query->rowCount() > 0) {
	        $order = $query->fetch();
	        $res = insert_online_money($order['username'], $param["billno"], $order['amount'], $order['pay_online']);
			if ($res == 1) exit("SUCCESS");
	    }
	}
}
exit("ERROR");