<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$pay_memberid = $pay_mid;
$pay_orderid = $_payId;
$pay_amount = $amount * 0.01; //交易金额
$pay_applydate = date("Y-m-d H:i:s"); //订单时间
$pay_notifyurl = $notice_url; //服务端返回地址
$pay_callbackurl = $notice_url; //页面跳转返回地址
$Md5key = $pay_mkey;

$tjurl = $merchant_url; //提交地址

if ($payChannel == 1) {
    $type = 'h5_wx';
} else {
    $type = 'jdpay_scan';
}

include_once("merchant.php");

$native = array(
    "merchant_code" => $pay_memberid,
    "service_type" => $type,
    "interface_version" => 'V3.0',
    "input_charset" => 'UTF-8',
    "notify_url" => $pay_notifyurl,
    "order_no" => $pay_orderid,
    "order_time" => $pay_applydate,
    "order_amount" => $pay_amount,
    "product_name" => 'testpay',
    "extra_return_param" => $ext
);

ksort($native);
$signStr = "";
foreach ($native as $key => $val) {
    $signStr = $signStr . $key . "=" . $val . "&";
}
$signStr = rtrim($signStr, '&');
$merchant_private_key= openssl_get_privatekey($merchant_private_key);
openssl_sign($signStr, $sign_info, $merchant_private_key, OPENSSL_ALGO_MD5);
$sign = base64_encode($sign_info);
$native["sign_type"] = 'RSA-S';	
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