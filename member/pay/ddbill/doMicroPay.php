<?php
header("Content-type: text/html; charset=utf-8");
$merchant_code = $pay_mid; //商户号，1111110166是测试商户号，调试时要更换商家自己的商户号
$service_type = $payChannel;
$notify_url = $notice_url;
$interface_version = "V3.0";
$sign_type = "RSA-S";
$input_charset = "UTF-8";
$client_ip = "192.168.1.1";
$order_no = $_payId;
$order_time = date('Y-m-d H:i:s');
$order_amount = $amount;
$product_name = "shoes";
$auth_code = $auth_code;
//以下参数为可选参数，如有需要，可参考文档设定参数值
$return_url = "";
$redo_flag = "";
$product_code = "";
$product_num = "2";
$product_desc = "";
$extra_return_param = "";
$extend_param = "";
$show_url = "";
$device_info = "";
$limit_pay = "no_credit";
/////////////////////////////   参数组装  /////////////////////////////////

/**
除了sign_type参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母	
*/
$signStr = "";
$signStr = $signStr . "auth_code=" . $auth_code . "&";
$signStr = $signStr . "client_ip=" . $client_ip . "&";
if ($device_info != "") {
    $signStr = $signStr . "device_info=" . $device_info . "&";
}
if ($extend_param != "") {
    $signStr = $signStr . "extend_param=" . $extend_param . "&";
}
if ($extra_return_param != "") {
    $signStr = $signStr . "extra_return_param=" . $extra_return_param . "&";
}
$signStr = $signStr . "input_charset=" . $input_charset . "&";
$signStr = $signStr . "interface_version=" . $interface_version . "&";
if ($limit_pay != "") {
    $signStr = $signStr . "limit_pay=" . $limit_pay . "&";
}
$signStr = $signStr . "merchant_code=" . $merchant_code . "&";
$signStr = $signStr . "notify_url=" . $notify_url . "&";
$signStr = $signStr . "order_amount=" . $order_amount . "&";
$signStr = $signStr . "order_no=" . $order_no . "&";
$signStr = $signStr . "order_time=" . $order_time . "&";
if ($product_code != "") {
    $signStr = $signStr . "product_code=" . $product_code . "&";
}
if ($product_desc != "") {
    $signStr = $signStr . "product_desc=" . $product_desc . "&";
}
$signStr = $signStr . "product_name=" . $product_name . "&";
if ($product_num != "") {
    $signStr = $signStr . "product_num=" . $product_num . "&";
}
if ($redo_flag != "") {
    $signStr = $signStr . "redo_flag=" . $redo_flag . "&";
}
if ($return_url != "") {
    $signStr = $signStr . "return_url=" . $return_url . "&";
}
$signStr = $signStr . "service_type=" . $service_type;
if ($show_url != "") {
    $signStr = $signStr . "&show_url=" . $show_url;
}
//echo $signStr."<br>";  
/////////////////////////////   获取sign值（RSA-S加密）  /////////////////////////////////
$merchant_private_key = chunk_split($pay_mkey, 64, "\n");
$merchant_private_key = "-----BEGIN PRIVATE KEY-----\n" . $merchant_private_key . "-----END PRIVATE KEY-----\n";
$merchant_private_key = openssl_get_privatekey($merchant_private_key);
openssl_sign($signStr, $sign_info, $merchant_private_key, OPENSSL_ALGO_MD5);
$sign = base64_encode($sign_info);
// echo $sign;
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>	
	<body onLoad="document.dinpayForm.submit();">
		<form name="dinpayForm" method="post" action="<?php echo $merchant_url?>">
			<input type="hidden" name="merchant_code" value="<?php echo $merchant_code?>" />
			<input type="hidden" name="service_type"  value="<?php echo $service_type?>"/>
			<input type="hidden" name="notify_url"    value="<?php echo $notify_url?>">
			<input type="hidden" name="interface_version" value="<?php echo $interface_version?>"/>
			<input type="hidden" name="input_charset" value="<?php echo $input_charset?>"/>
			<input type="hidden" name="sign_type"     value="<?php echo $sign_type?>"/>
			<input type="hidden" name="sign"		  value="<?php echo $sign?>" />
			<input Type="hidden" Name="return_url"    value="<?php echo $return_url?>"/>
			<input Type="hidden" Name="client_ip"     value="<?php echo $client_ip?>"/>
			<input type="hidden" name="order_no"      value="<?php echo $order_no?>"/>
			<input type="hidden" name="order_amount"  value="<?php echo $order_amount?>"/>
			<input type="hidden" name="order_time"    value="<?php echo $order_time?>"/>
			<input type="hidden" name="redo_flag"		  value="<?php echo $redo_flag?>" />
			<input type="hidden" name="product_name"  value="<?php echo $product_name?>"/>
			<input Type="hidden" Name="product_code"  value="<?php echo $product_code?>"/>
			<input Type="hidden" Name="product_desc"  value="<?php echo $product_desc?>"/>
			<input Type="hidden" Name="product_num"   value="<?php echo $product_num?>"/>
			<input Type="hidden" Name="extend_param"  value="<?php echo $extend_param?>"/>
			<input Type="hidden" Name="extra_return_param" value="<?php echo $extra_return_param?>"/>	
			<input Type="hidden" Name="show_url"      value="<?php echo $show_url?>"/>
			<input type="hidden" name="auth_code"     value="<?php echo $auth_code?>"/>
			<input type="hidden" name="device_info"     value="<?php echo $device_info?>"/>
			<input type="hidden" name="limit_pay"     value="<?php echo $limit_pay?>"/>
		</form>
	</body>
</html>