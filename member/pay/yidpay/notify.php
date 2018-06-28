<?php
$pay_online = '移动支付';
file_put_contents('data.txt', json_encode($_POST));
header("Content-type: text/html; charset=utf-8");
include_once '../../../database/mysql.config.php';
include_once '../moneyfunc.php';
include_once '../moneyconfig.php';

die();

if($html_text['Sign']==strtolower($Sign)){
    $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $_REQUEST["OutPaymentNo"]);
    if ($query->rowCount() > 0) {
        $order = $query->fetch();
        $res = insert_online_money($order['username'], $_REQUEST["order_no"], $order['amount'], $order['pay_online']);
		if ($res == 1) exit("SUCCESS");
    }
}
exit('ERROR');