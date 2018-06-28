<?php
require_once "fun.php";
$payUrl = $merchant_url;
$merKey = $pay_mkey;
$reqData = array(
    'merId' => $pay_mid,
    'merKey' => $merKey,
    'svcName' => $payChannel == 4 ? 'gatewayPay' : 'UniThirdPay',
    'tranType' => $payChannel == 4 ? $bank_code : $payChannel,
    'merchOrderId' => $_payId,
    'pName' => 'test',
    'amt' => $amount * 100,
    'showCashier' => 1,
    'notifyUrl' => $notice_url
);
$parms = array();
foreach ($reqData as $key => $value) {
    if ($key == "payUrl" || $key == "submit" || $key == "merKey") {
        continue;
    } else if (empty($value)) {
        continue;
    } else {
        $parms[$key] = $value;
    }
}
$md5value = makeSign($parms, $merKey);
$parms["md5value"] = $md5value;
?>
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>send</title>
</head>
<body onload="document.getElementById('myform').submit();" >
<form id="myform" action="<?php echo $payUrl ?>" method="POST" target="_self" enctype="application/x-www-form-urlencoded" >
<?php 
	
	foreach ($parms as $key => $value) 
	{
		?>
			<input type="hidden" name="<?php echo $key ?>" value="<?php echo $value ?>" />
		<?php
	}
	
?>
</form>
</body>
</html>