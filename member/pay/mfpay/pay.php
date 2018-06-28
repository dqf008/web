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
$device = $isMobile?'2':'1';
switch ($type) {
	case 'WECHAT':
		$code = 'WECHAT';
		break;
	case 'ALIPAY':
		$code = 'ALIPAY';
		break;
	case 'QQPAY':
		$code = 'QQ';
		break;
	case 'WAP_WECHAT':
		$code = 'WAP_WECHAT';
		break;
}
$url = 'https://api.chinacardpayment.com/api/pay';
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
$param = array();
$param['merchant'] = $pay_mid;
$param['billno'] = $_payId;
$param['amount'] = $money;
$param['sign_type'] = 'MD5';
$param['bank'] = $code;
$param['pay_time'] = date('YmdHis');
ksort($param);
$str = http_build_query($param) . '&key='.$pay_mkey;
//echo '请求参数：';
//print_r($param);
$param['sign'] = md5($str);
//echo 'MD5加密前：'.$str."\n";
$param['notify_url'] = $notice_url;
//echo 'MD5加密后：'.$param['sign']."\n";
//
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.chinacardpayment.com/api/pay");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);

$rows = json_decode($res, true);
$data = array();
if ($rows['code'] == '1000') {
    $data['status'] = 1;
    $data['message'] = $rows['qrCode'];
} else {
    $data['status'] = 'error';
    $data['message'] = $rows['msg'];;
}
if ($isMobile) {
    $qrcode = $res['response']['qrcode'] ? $res['response']['qrcode'] : $res['response']['payURL'];
    $qrcode = base64_encode($qrcode);
    $url = "/member/pay/qrcodex.php?s={$qrcode}&k=2";
    echo "<div align='center'><img  src='{$url}' width='320'/></div>";
} else {
    $jsonCallback = htmlspecialchars($_REQUEST['callback']);
    echo $jsonCallback . '(' . json_encode($data) . ')';
}