<?php 
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
$money += floatval('0.1'.rand(1,9));
$type = $_GET['S_Type'];
$isMobile = strpos($_SERVER['HTTP_REFERER'], 'mobile');
$isNew = strpos($_SERVER['HTTP_REFERER'], 'online');
$bank = '';
switch ($type) {
	case 'WECHAT':
		break;
	case 'WECHAT_H5':
		break;
	case 'ALIPAY': $netway = '904';break;
	case 'QQPAY':
		break;
	case 'JDPAY':
		break;
	case 'BDPAY':
		break;
	case 'ONLINE': $netway = '907';
	$bank = $_POST['bank'];
	break;
	case 'UNIONPAY':$netway = '911';break;
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

$url = 'http://api.597kf.com/Pay_Index.html';
$data = array();
$data['pay_memberid'] = $pay_mid;
$data['pay_orderid'] = $_payId;
$data['pay_applydate'] = date('Y-m-d H:i:s');
$data['pay_bankcode'] = $netway;
$data['pay_notifyurl'] = $notice_url;
$data['pay_callbackurl'] = $notice_url;
$data['pay_amount'] = $money;
ksort($data);
$sign_str = urldecode(http_build_query($data)).'&key='.$pay_mkey;
$data['pay_md5sign'] = strtoupper(md5($sign_str));
$data['pay_productname'] = 'money';
$bank && $data['pay_bank'] = $bank;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER,0 );
curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$ret = curl_exec($ch);
curl_close($ch);
$rows = json_decode($ret, true);
$data = array();
if ($rows['status'] == 'success') {
    $data['status'] = 1;
    $data['message'] = $rows['data']['url'];
} else {
    $data['status'] = 'error';
    $data['message'] = $rows['msg'];;
}
if($type == 'UNIONPAY' || $type == 'ONLINE'){
	if($data['status'] == 1) header('Location: '.$data['message']);
	else echo $data['message'];
	die();
}
$qrcode = $rows['data']['url'];
if ($isMobile) {    
    header('Location: '.$qrcode);
}else if($isNew){
	$qrcode = urlencode($qrcode);
    $url = "/member/pay/qrcodex.php?s={$qrcode}";
    echo "<div align='center'><img  src='{$url}' width='320'/></div>";
}else {
    $jsonCallback = htmlspecialchars($_REQUEST['callback']);
    echo $jsonCallback . '(' . json_encode($data) . ')';
}