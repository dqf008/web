<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$native = array(
    "parter" => $pay_mid,
    "type" => $payChannel,
    "value" => $amount,
    "orderid" => $_payId,
    "callbackurl" => $notice_url
);
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
$md5str = rtrim($md5str, '&');
$md5str = $md5str . $pay_mkey;
$sign = md5($md5str);
$native["sign"] = $sign;
$str = "";
foreach ($native as $k => $v) {
    $str .= "<input Type='hidden' name='{$k}' value='{$v}'>";
}
?>
<!-- 以post方式提交所有接口参数到 onLoad="document.dinpayForm.submit();"-->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>	

	<body onLoad="document.dinpayForm.submit();">
	    <h3>正在跳转中，请等待!</h3>
		<form name="dinpayForm" method="post" action="<?=$merchant_url;?>">
		<?=$str;?>
        </form>
	</body>
	
</html>