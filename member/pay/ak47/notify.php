<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");

require("./easypay-api-sdk-php.php");
$data = process_callback4trade("callback4trade");//调用
if($data['merchantNo']!='MAMC11004HUQV'){
    exit;
}
if($data['outTradeNo']){
    //处理
    $mid = strip_tags($data['outTradeNo']);
    $query = $mydata1_db->query('SELECT * FROM k_money_order WHERE `mid`='.$mid);
    if($query->rowCount()>0){
        $order = $query->fetch();
    }
    if($order){
        insert_online_money($order['username'],$order['mid'], $order['amount'],$order['pay_online']);
        echo 'SUCCEED';
    }
    
}

?>