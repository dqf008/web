<?php
$MemberID = $pay_mid; //商户号
$TransID = $_payId; //流水号
$PayID = $payChannel; //支付方式
$TradeDate = date('Ymdhis'); //交易时间
$OrderMoney = $amount * 100; //订单金额，以分为单位
$ProductName = ''; //产品名称
$Amount = ''; //商品数量
$Username = ''; //支付用户名
$AdditionalInfo = ''; //订单附加消息
$PageUrl = $notice_url; //通知商户页面端地址
$ReturnUrl = $notice_url; //服务器底层通知地址
$NoticeType = '1'; //通知类型	
$Md5key = $pay_mkey; //md5密钥（KEY）
$MARK = "|";
//MD5签名格式
$Signature = md5($MemberID . $MARK . $PayID . $MARK . $TradeDate . $MARK . $TransID . $MARK . $OrderMoney . $MARK . $PageUrl . $MARK . $ReturnUrl . $MARK . $NoticeType . $MARK . $Md5key);
$payUrl = $merchant_url; //网关地址
$TerminalID = $pay_TerminalID;
$InterfaceVersion = "4.0";
$KeyType = "1";
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>	
	<body onLoad="document.dinpayForm.submit();">
	    <h3>正在跳转中，请等待!</h3>
		<form name="dinpayForm" method="post" action="<?=$payUrl;?>">
            <input type='hidden' name='MemberID' value="<?php echo $MemberID; ?>" />
    		<input type='hidden' name='TerminalID' value="<?php echo $TerminalID; ?>"/>
    		<input type='hidden' name='InterfaceVersion' value="<?php echo $InterfaceVersion; ?>"/>
    		<input type='hidden' name='KeyType' value="<?php echo $KeyType; ?>"/>
            <input type='hidden' name='PayID' value="<?php echo $PayID; ?>" />
            <input type='hidden' name='TradeDate' value="<?php echo $TradeDate; ?>" />
            <input type='hidden' name='TransID' value="<?php echo $TransID; ?>" />
            <input type='hidden' name='OrderMoney' value="<?php echo $OrderMoney; ?>" />
            <input type='hidden' name='ProductName' value="<?php echo $ProductName; ?>" />
            <input type='hidden' name='Amount' value="<?php echo $Amount; ?>" />
            <input type='hidden' name='Username' value="<?php echo $Username; ?>" />
            <input type='hidden' name='AdditionalInfo' value="<?php echo $AdditionalInfo; ?>" />
            <input type='hidden' name='PageUrl' value="<?php echo $PageUrl; ?>" />
            <input type='hidden' name='ReturnUrl' value="<?php echo $ReturnUrl; ?>" />
            <input type='hidden' name='Signature' value="<?php echo $Signature; ?>" />
    		<input type='hidden' name='NoticeType' value="<?php echo $NoticeType; ?>" />
        </form>
	</body>
</html>