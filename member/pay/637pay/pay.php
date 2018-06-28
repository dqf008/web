<?php 
ini_set('display_errors', '1');
include('util.php');
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
switch ($type) {
	case 'WECHAT':
		if($isMobile){
			$url = 'http://wxwap.637pay.com/api/pay';
			$netway = 'WX_WAP';
		}else{
			$url = 'http://wx.637pay.com/api/pay';
			$netway = 'WX';
		}
		break;
	case 'WECHAT_H5':
		$url = 'http://wx.637pay.com/api/pay';
		$netway = 'WX_H5';
		break;
	case 'ALIPAY':
		if($isMobile){
			$url = 'http://zfbwap.637pay.com/api/pay';
			$netway = 'ZFB_WAP';
		}else{
			$url = 'http://zfb.637pay.com/api/pay';
			$netway = 'ZFB';
		}
		break;
	case 'QQPAY':
		if($isMobile){
			$url = 'http://qqwap.637pay.com/api/pay';
			$netway = 'QQ_WAP';
		}else{
			$url = 'http://qq.637pay.com/api/pay';
			$netway = 'QQ';
		}
		break;
	case 'JDPAY':
		$url = 'http://jd.637pay.com/api/pay';
		$netway = 'JD';
		break;
	case 'BDPAY':
		$url = 'http://baidu.637pay.com/api/pay';
		$netway = 'BAIDU';
		break;
	case 'UNIONPAY':
		$url = 'http://unionpay.637pay.com/api/pay';
		$netway = 'UNION_WALLET';
		break;
}
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

$Rsa = new Rsa();
$data = array();
$data['orderNum'] = $_payId;
$data['version'] = 'V3.1.0.0';
$data['charset'] = 'UTF-8';
$data['random'] = (string) rand(1000,9999);
$data['merNo'] = $pay_mid;
$data['netway'] = 'WX';//WX:微信支付,ZFB:支付宝支付
$data['amount'] = (string)($money * 100);	// 单位:分
$data['goodsName'] = '笔';
$data['callBackUrl'] = $notice_url;
$data['callBackViewUrl'] = '';
$data['sign'] = create_sign($data,$pay_mkey);
$json = json_encode_ex($data);
$dataStr = $Rsa->encode_pay($json);
$param = 'data=' . urlencode($dataStr) . '&merchNo=' . $pay_mid . '&version=V3.1.0.0';
$result = post($url, $param);
//print_r($data);

$rows = json_to_array($result, $pay_mkey);

if ($rows['stateCode'] == '00') {
    $data = array();
    $data['status'] = 1;
    $data['message'] = $rows['qrcodeUrl'];
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