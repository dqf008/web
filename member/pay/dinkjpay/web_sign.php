<?php
	
	
	require_once('merchant.php');
	
	$merchant_private_key= openssl_get_privatekey($merchant_private_key);
	
	$encryption_key = openssl_get_publickey($encryption_key);
	
	
	
	$service_type = "express_web_sign_pay";

	$merchant_code = $pay_mid;//"1111110166";//商户号

	$interface_version = "V3.0";

	$input_charset = "UTF-8";

	$sign_type ="RSA-S";
	
	
	$notify_url = $notice_url;//"http://www.dinpay.com/pay";//通知URL
	
	$order_no = $_payId;//订单号
	
	
	$order_amount = $amount;//钱
	
	$order_time = date('Y-m-d h:i:s');// "2015-11-11 12:12:12";	订单时间
	
	$mobile = trim($_REQUEST['mobile']);//"15989882747";//手机号码

	
	$bank_code = trim($_REQUEST['Bankco']);//"ICBC";

	$card_type = "0";

	$card_no = trim($_REQUEST['card_no']);//"";//银行卡
	
	$card_name = trim($_REQUEST['card_name']);//"路海";//;//用户名
	
	$id_no = trim($_REQUEST['id_no']);//"110105196812272168";//身份证号码
	
	$encrypt = $card_no."|".$card_name."|".$id_no;
	
	openssl_public_encrypt($encrypt,$info,$encryption_key);
	
	$encrypt_info = base64_encode($info);//encrypt_info参数参与签名
	
	$product_name ="check";
	
	$product_code ="";
	
	$product_num ="";
	
	$product_desc ="";
	
	
	
	$signStr = "";
	
	$signStr = $signStr."bank_code=".$bank_code."&";	
	
	$signStr = $signStr."card_type=".$card_type."&";	

	$signStr = $signStr."encrypt_info=".$encrypt_info."&";		
	
	$signStr = $signStr."input_charset=".$input_charset."&";		
	
	$signStr = $signStr."interface_version=".$interface_version."&";		
	
	
	$signStr = $signStr."merchant_code=".$merchant_code."&";

	$signStr = $signStr."mobile=".$mobile."&";
	
	$signStr = $signStr."notify_url=".$notify_url."&";
	
	
	$signStr = $signStr."order_amount=".$order_amount."&";
	
	
	$signStr = $signStr."order_no=".$order_no."&";
	
	$signStr = $signStr."order_time=".$order_time."&";
	
	
	
	
	if($product_code != ""){
		$signStr = $signStr."product_code=".$product_code."&";
	}	
	
	$signStr = $signStr."product_name=".$product_name."&";
	
	if($product_desc != ""){
		$signStr = $signStr."product_code=".$product_code."&";
	}	
	
	
	$signStr = $signStr."service_type=".$service_type;
	
	//echo $signStr;

	openssl_sign($signStr,$sign_info,$merchant_private_key,OPENSSL_ALGO_MD5);
	
	$sign = base64_encode($sign_info);
	
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>	
	<body onLoad="document.dinpayForm.submit();">
		<form name="dinpayForm" method="post" action="https://api.dinpay.com/gateway/api/express" >
			<input type="hidden" name="sign"		  value="<?php echo $sign?>" />
			<input type="hidden" name="merchant_code" value="<?php echo $merchant_code?>" />
			<input type="hidden" name="bank_code"     value="<?php echo $bank_code?>"/>
			<input type="hidden" name="notify_url"      value="<?php echo $notify_url?>"/>
			<input type="hidden" name="card_type"  value="<?php echo $card_type?>"/>
			<input type="hidden" name="service_type"  value="<?php echo $service_type?>"/>
			<input type="hidden" name="input_charset" value="<?php echo $input_charset?>"/>
			<input type="hidden" name="mobile"    value="<?php echo $mobile?>">
			<input type="hidden" name="interface_version" value="<?php echo $interface_version?>"/>
			<input type="hidden" name="order_no"     value="<?php echo $order_no?>"/>
			<input type="hidden" name="order_amount"     value="<?php echo $order_amount?>"/>
			<input type="hidden" name="order_time"     value="<?php echo $order_time?>"/>
			<input type="hidden" name="product_name"     value="<?php echo $product_name?>"/>
			<input type="hidden" name="product_code"     value="<?php echo $product_code?>"/>
			<input type="hidden" name="product_desc"     value="<?php echo $product_desc?>"/>
			<input type="hidden" name="product_num"     value="<?php echo $product_num?>"/>
			<input type="hidden" name="sign_type"     value="<?php echo $sign_type?>"/>
			<input type="hidden" name="encrypt_info"     value="<?php echo $encrypt_info?>"/>
		</form>
	</body>
</html>