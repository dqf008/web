<?php
require_once "utils.php";
$reqData = array(
    'p1_mchtid' => $pay_mid,
    'p2_paytype' => $payChannel ? $payChannel : $bank_code,
    'p3_paymoney' => $amount,
    'p4_orderno' => $_payId,
    'p5_callbackurl' => $notice_url,
    'p6_notifyurl' => $notice_url,
    'p7_version' => 'v2.8',
    'p8_signtype' => '1',
    'p9_attach' => '',
    'p10_appname' => '',
    'p11_isshow' => '1',
    'p12_orderip' => $_SERVER['REMOTE_ADDR']
);
if ($payChannel == 'FASTPAY')
    $reqData['p13_memberid'] = 'memberid' . $ext;
$skey = $pay_mkey;
$sign = pay::sign($reqData, $skey);
$payUrl = $merchant_url;
$reqData['sign'] = $sign;
$str = "";
foreach ($reqData as $k => $v) {
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
		<form name="dinpayForm" method="post" action="<?=$payUrl;?>">
		<?=$str;?>
        </form>
	</body>
</html>