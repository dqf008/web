<?php
file_put_contents('data.txt', json_encode($_POST));
$pay_online = '快付支付宝';
header("Content-type: text/html; charset=utf-8");
include_once '../../../database/mysql.config.php';
include_once '../moneyfunc.php';
include_once '../moneyconfig.php';

$sign = $_POST['sign'];
unset($_POST['sign'], $_POST['attach']);
$data = $_POST;
ksort($data);
$sign_str = urldecode(http_build_query($data)).'&key='.$pay_mkey;
if($sign == strtoupper(md5($sign_str)) && $data['returncode'] == '00'){
	$query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $data['orderid']);
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
        $res = insert_online_money($order['username'], $data['orderid'], $order['amount'], $order['pay_online']);
    }
	exit("ok");
}