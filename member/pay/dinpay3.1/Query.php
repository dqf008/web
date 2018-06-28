<?php include_once 'curl_http.php';
include_once '../moneyconfig.php';
$flag = queryorder('testaa_91540520160513022550', 1);
 echo $flag;
function queryOrder($order_no, $amount)
{
	global $pay_mid;
	global $pay_mkey;
	$priKey = openssl_get_privatekey($pay_mkey);
	$uri = 'https://query.dinpay.com/query';
	$interface_version = 'V3.0';
	$merchant_code = $pay_mid;
	$service_type = 'single_trade_query';
	$sign_type = 'RSA-S';
	$signStr = '';
	$signStr = 'interface_version=' . $interface_version . '&merchant_code=' . $merchant_code . '&order_no=' . $order_no . '&service_type=' . $service_type;
	openssl_sign($signStr, $sign_info, $priKey, OPENSSL_ALGO_MD5);
	$sign = base64_encode($sign_info);
	$post_data = array('interface_version' => $interface_version, 'merchant_code' => $merchant_code, 'service_type' => $service_type, 'order_no' => $order_no, 'sign_type' => $sign_type, 'sign' => $sign);
	$curl = new Curl_HTTP_Client();
	$i = 0;
	for (;$i < 5;$i++)
	{
		$html_data = $curl->send_post_data($uri, $post_data);
		$xml = simplexml_load_string($html_data);
		if (('T' == $xml->response->is_success) && (bccomp(floatval($xml->response->trade->order_amount), floatval($amount), 2) == 0))
		{
			return true;
		}
	}
	return false;
}?>