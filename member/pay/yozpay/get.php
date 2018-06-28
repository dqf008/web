<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$pay_memberid = $pay_mid;
$pay_orderid = $_payId;
$pay_amount = $amount; //交易金额
$pay_applydate = date("Y-m-d H:i:s"); //订单时间
$pay_notifyurl = $notice_url; //服务端返回地址
$pay_callbackurl = $notice_url; //页面跳转返回地址
$Md5key = $pay_mkey;
$tjurl = $merchant_url;
$pay_bankcode = $payChannel;
//跳转
$native = array(
    "pay_memberid" => $pay_memberid,
    "pay_orderid" => $pay_orderid,
    "pay_amount" => $pay_amount,
    "pay_applydate" => $pay_applydate,
    "pay_bankcode" => $pay_bankcode,
    "pay_notifyurl" => $pay_notifyurl,
    "pay_callbackurl" => $pay_callbackurl
);
ksort($native);
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
$sign = strtoupper(md5($md5str . "key=" . $Md5key));
$native["pay_md5sign"] = $sign;
$native['pay_attach'] = $ext; //
$native['pay_productname'] = 'VIP基础服务';
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
		<form name="dinpayForm" method="post" action="<?= $tjurl;?>">
		<?= $str;?>
        </form>
	</body>
	
</html>