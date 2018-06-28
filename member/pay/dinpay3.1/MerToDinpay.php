<?php
header('content-Type: text/html;charset=UTF-8');
$pay_online = $_POST['pay_online'];
include_once '../moneyconfig.php';
include_once '../tools.php';
$priKey = openssl_get_privatekey($pay_mkey);
$merchant_code = $pay_mid;
$service_type = 'direct_pay';
$interface_version = 'V3.0';
$input_charset = 'UTF-8';
$sign_type = 'RSA-S';
$pay_type = '';
$order_amount = $_POST['MOAmount'];
$product_code = $_POST['S_Name'];
$order_no = $product_code . '_' . getorderid();
$order_time = date('Y-m-d H:i:s', time());
$product_name = $_POST['S_Name'];
$notify_url = $notice_url;
$extra_return_param = base64Encode($pay_online) . '-' . $_POST['S_Name'];
$signStr = '';
if ($bank_code != '')
{
	$signStr = $signStr . 'bank_code=' . $bank_code . '&';
}
if ($client_ip != '')
{
	$signStr = $signStr . 'client_ip=' . $client_ip . '&';
}
if ($extend_param != '')
{
	$signStr = $signStr . 'extend_param=' . $extend_param . '&';
}
if ($extra_return_param != '')
{
	$signStr = $signStr . 'extra_return_param=' . $extra_return_param . '&';
}
$signStr = $signStr . 'input_charset=' . $input_charset . '&';
$signStr = $signStr . 'interface_version=' . $interface_version . '&';
$signStr = $signStr . 'merchant_code=' . $merchant_code . '&';
$signStr = $signStr . 'notify_url=' . $notify_url . '&';
$signStr = $signStr . 'order_amount=' . $order_amount . '&';
$signStr = $signStr . 'order_no=' . $order_no . '&';
$signStr = $signStr . 'order_time=' . $order_time . '&';
if ($pay_type != '')
{
	$signStr = $signStr . 'pay_type=' . $pay_type . '&';
}
if ($product_code != '')
{
	$signStr = $signStr . 'product_code=' . $product_code . '&';
}
if ($product_desc != '')
{
	$signStr = $signStr . 'product_desc=' . $product_desc . '&';
}
$signStr = $signStr . 'product_name=' . $product_name . '&';
if ($product_num != '')
{
	$signStr = $signStr . 'product_num=' . $product_num . '&';
}
if ($redo_flag != '')
{
	$signStr = $signStr . 'redo_flag=' . $redo_flag . '&';
}
if ($return_url != '')
{
	$signStr = $signStr . 'return_url=' . $return_url . '&';
}
if ($show_url != '')
{
	$signStr = $signStr . 'service_type=' . $service_type . '&';
	$signStr = $signStr . 'show_url=' . $show_url;
}
else
{
	$signStr = $signStr . 'service_type=' . $service_type;
}
openssl_sign($signStr, $sign_info, $priKey, OPENSSL_ALGO_MD5);
$sign = base64_encode($sign_info);?><html> 
	  <head> 
		  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"> 
	  </head>  	
	  <body onLoad="document.dinpayForm.submit();"> 
		  <form name="dinpayForm" method="post" action="https://pay.dinpay.com/gateway?input_charset=UTF-8" target="_self"> 
			  <input type="hidden" name="sign"  		    value="<?=$sign;?>" /> 
			  <input type="hidden" name="merchant_code" value="<?=$merchant_code;?>" /> 
			  <input type="hidden" name="bank_code"     value="<?=$bank_code;?>"/> 
			  <input type="hidden" name="order_no"      value="<?=$order_no;?>"/> 
			  <input type="hidden" name="order_amount"  value="<?=$order_amount;?>"/> 
			  <input type="hidden" name="service_type"  value="<?=$service_type;?>"/> 
			  <input type="hidden" name="input_charset" value="<?=$input_charset;?>"/> 
			  <input type="hidden" name="notify_url"    value="<?=$notify_url;?>"> 
			  <input type="hidden" name="interface_version" value="<?=$interface_version;?>"/> 
			  <input type="hidden" name="sign_type"     value="<?=$sign_type;?>"/> 
			  <input type="hidden" name="order_time"    value="<?=$order_time;?>"/> 
			  <input type="hidden" name="product_name"  value="<?=$product_name;?>"/> 
			  <input Type="hidden" Name="client_ip"     value="<?=$client_ip;?>"/> 
			  <input Type="hidden" Name="extend_param"  value="<?=$extend_param;?>"/> 
			  <input Type="hidden" Name="extra_return_param" value="<?=$extra_return_param;?>"/> 
			  <input Type="hidden" Name="pay_type"  value="<?=$pay_type;?>"/> 
			  <input Type="hidden" Name="product_code"  value="<?=$product_code;?>"/> 
			  <input Type="hidden" Name="product_desc"  value="<?=$product_desc;?>"/> 
			  <input Type="hidden" Name="product_num"   value="<?=$product_num;?>"/> 
			  <input Type="hidden" Name="return_url"    value="<?=$return_url;?>"/> 
			  <input Type="hidden" Name="show_url"      value="<?=$show_url;?>"/> 
			  <input Type="hidden" Name="redo_flag"     value="<?=$redo_flag;?>"/> 
		  </form> 
	  </body> 
  </html><?php function getOrderId()
{
	return rand(100000, 999999) . '' . date('YmdHis');
}?>