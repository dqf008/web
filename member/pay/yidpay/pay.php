<?php 
ini_set('display_errors', '1');

$pay_online = $_POST['pay_online'];
include_once("../moneyconfig.php");
include("../../../cache/website.php");
include("../../../database/mysql.config.php");
include_once '../moneyfunc.php';
$query = $mydata1_db->prepare('SELECT uid,username FROM `k_user` WHERE `username`=:username');
$query->execute(array(
    ':username' => $_POST['S_Name']
));
if ($query->rowCount() > 0) {
    $rows = $query->fetch();
} else {
    exit('Access Denied');
}
(!isset($_POST['MOAmount']) || !preg_match('/^\d+(\.\d+)?$/', $_POST['MOAmount'])) && $_POST['MOAmount'] = $web_site['ck_limit'];
$money = number_format($_POST['MOAmount'] < $web_site['ck_limit'] ? $web_site['ck_limit'] : $_POST['MOAmount'], 2, '.', '');
$type = $_GET['S_Type'];
$isMobile = strpos($_SERVER['HTTP_REFERER'], 'mobilePay.php?');
$_payId = date('YmdHis') .rand(10000,99999);
$stmt = $mydata1_db->prepare('INSERT INTO `k_money_order` (`uid`, `username`, `mid`, `did`, `pay_online`, `amount`, `status`) VALUES (:uid, :username, :mid, :did, :pay_online, :amount, 0)');
$stmt->execute(array(
    ':uid' => $rows['uid'],
    ':username' => $rows['username'],
    ':mid' => $_payId,
    ':did' => '',
    ':pay_online' => $pay_online,
    ':amount' => $money
));
$data = [];
$data['merId'] = $pay_mid;//'201804241422490';
$data['ordId'] = $_payId;
$data['amount'] = $money*100;//分
$data['orderSource'] = $isMobile?'1002':'1001';//PC:1001 MOBILE:1002
$data['payChannelCode'] = $_POST['bankcode'];
$data['payChannelType'] = '1001';//1002信用卡
$data['payType'] = '1011';
$data['synUrl'] = $notice_url;//回调
$data['atUrl'] = 'http://'.$_SERVER['HTTP_HOST'];
$data['body'] = 'none';
$data['sign'] = md5($data['merId'].$data['ordId'].$data['amount'].$data['payType'].$pay_mkey);

$ch = curl_init();
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_URL, 'http://pos.toooj.com:8888/m/pay/createBankPay');
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$data = curl_exec($ch);
//print_r($data);
curl_close($ch);
$arr = json_decode($data, true);

if($arr['responseCode'] == '0'){
    echo $arr['data']['codeurl'];
}else{
	echo $arr['responseMsg'];
}