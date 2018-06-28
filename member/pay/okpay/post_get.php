<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
function ip() {
    if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $res = preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches[0] : '';
    return $res;
}
$pay_memberid = $pay_mid;
$pay_orderid = $_payId;
$pay_amount = $amount * 0.01; //交易金额
$pay_applydate = date("Y-m-d H:i:s"); //订单时间
$pay_notifyurl = $notice_url; //服务端返回地址
$pay_callbackurl = $notice_url; //页面跳转返回地址
$Md5key = $pay_mkey;
$tjurl = $merchant_url; //提交地址
if ($payChannel == 1) {
    $type = 'WECHAT';
} elseif ($payChannel == 2) {
    $type = 'ALIPAY';
} elseif ($payChannel == 3) {
    $type = 'QQPAY';
} elseif ($payChannel == 4) {
    $type = 'JDPAY';
} elseif ($payChannel == 5) {
    $type = 'TENPAY';
} elseif ($payChannel == 6) {
    $type = $bankId;
}
$native = array(
    "version" => '1.0',
    "partner" => $pay_memberid,
    "orderid" => $pay_orderid,
    "payamount" => $pay_amount,
    "payip" => ip(),
    "notifyurl" => $pay_notifyurl,
    "returnurl" => $pay_notifyurl,
    "paytype" => $type,
    "remark" => $ext
);
//ksort($native);
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
//$md5str = rtrim($md5str, '&');
$md5str = $md5str . 'key=' . $Md5key;
$sign = strtolower(md5($md5str));
$native["sign"] = $sign;
$str = "";
foreach ($native as $k => $v) {
    $str .= "<input Type='hidden' name='{$k}'     value='{$v}'>";
}
?>
<!-- 以post方式提交所有接口参数到 onLoad="document.dinpayForm.submit();"-->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>	

	<body onLoad="document.dinpayForm.submit();">
	<h3>正在跳转中，请等待!</h3>
		<form name="dinpayForm" method="post" action="<?=$tjurl;?>">
		<?=$str;?>
        </form>
	</body>
</html>