<?php
header("Content-type: text/html; charset=utf-8");
require_once("yidao2.php");
$pay_mkey = explode('|', $pay_mkey);
$ydpay = new yidao($pay_mid, $pay_mkey[0], $pay_mkey[1]);
$ydpay->setNotifyUrl($notice_url);
$ydpay->setReturnUrl($notice_url);
$data = $ydpay->pay($_payId, "测试商品", $amount, $payChannel);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>	

	<body onLoad="document.dinpayForm.submit();">
	    <h3>正在跳转中，请等待!</h3>
		<form name="dinpayForm" method="post" action="<?=$merchant_url;?>">
            <input type="hidden" name="transData" value="<?php echo $data['transData'];?>"/>
            <input type="hidden" name="merchantCode" value="<?php echo $data['merchantCode'];?>"/>
            <input type="hidden" name="extra_para" value="<?php echo $data['extra_para'];?>"/>
        </form>
	</body>
	
</html>