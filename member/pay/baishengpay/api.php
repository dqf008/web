<?php
$pay_online = $_POST['pay_online'];
require_once("config.php");
include_once("../moneyconfig.php");
//require_once("lib/submit.class.php");
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
$code = '';
$isMobile = strpos($_SERVER['HTTP_REFERER'], 'mobilePay.php?');
switch ($type) {
	case 'WECHAT':
		$code = $isMobile?'WECHAT_WAP_PAY':'WECHAT_QRCODE_PAY';
		//$code = 'WECHAT_WAP_PAY';
		break;
	case 'QQPAY':
		$code = $isMobile?'QQ_WAP_PAY':'QQ_QRCODE_PAY';
		//$code = 'QQ_WAP_PAY';
		break;
	case 'ALIPAY':
		$code = $isMobile?'ALIPAY_WAP_PAY':'ALIPAY_QRCODE_PAY';
		//$code = 'ALIPAY_WAP_PAY';
		break;
	case 'JDPAY':
		$code = $isMobile?'JD_WAP_PAY':'JD_QRCODE_PAY';
		//$code = 'JD_WAP_PAY';
		break;
	case 'UNIONPAY':
		$code = $isMobile?'UNIONPAY_WAP_PAY':'UNIONPAY_QRCODE_PAY';
		//$code = 'UNIONPAY_WAP_PAY';
		break;
	default: exit;
}
$_payId = time() . rand(10000, 99999);
$stmt = $mydata1_db->prepare('INSERT INTO `k_money_order` (`uid`, `username`, `mid`, `did`, `pay_online`, `amount`, `status`) VALUES (:uid, :username, :mid, :did, :pay_online, :amount, 0)');
$stmt->execute(array(
    ':uid' => $rows['uid'],
    ':username' => $rows['username'],
    ':mid' => $_payId,
    ':did' => '',
    ':pay_online' => $pay_online,
    ':amount' => $money
));
$parameter = array(
	"MerchantId" =>  $config["MerchantId"],
	"Timestamp"	=> date("Y-m-d H:i:s"),
	"PaymentTypeCode"	=> $code,
	"OutPaymentNo"	=> $_payId,
	"PaymentAmount"	=> $money * 100,
	"PassbackParams" => "xxx",
	"NotifyUrl"	=> $notice_url
);

$waitLink = "MerchantId=".$parameter["MerchantId"]
			."&NotifyUrl=".$parameter["NotifyUrl"]
			."&OutPaymentNo=".$parameter["OutPaymentNo"]
			."&PassbackParams=".$parameter["PassbackParams"]
			."&PaymentAmount=".$parameter["PaymentAmount"]
			."&PaymentTypeCode=".$parameter["PaymentTypeCode"]
			."&Timestamp=".$parameter["Timestamp"];
		   
$parameter["Sign"] = md5($waitLink . $config["SecretKey"]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ebank.baishengpay.com/Payment/Gateway");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameter));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res=curl_exec($ch);
$res = json_decode($res, true);
if ($res['Code'] == '200') {
    $data = array();
    $data['status'] = 1;
    $data['message'] = $res['QrCodeUrl'];
} else {
    $data['status'] = 'error';
    $data['message'] = $res['Message'];
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