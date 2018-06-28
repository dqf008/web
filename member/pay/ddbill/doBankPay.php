<?php
header("Content-type: text/html; charset=utf-8");
$merchant_code = $pay_mid;
$service_type = "direct_pay";
$interface_version = "V3.0";
$sign_type = "RSA-S";
$input_charset = "UTF-8";
$notify_url = $notice_url;
$order_no = $_payId;
$order_time = date('Y-m-d H:i:s');
$order_amount = $amount;
$product_name = "testpay";
//以下参数为可选参数，如有需要，可参考文档设定参数值
$return_url = "";
$pay_type = "";
$redo_flag = "";
$product_code = "";
$product_desc = "";
$product_num = "";
$show_url = "";
$client_ip = "";
$bank_code = "";
$extend_param = "";
$extra_return_param = "";
/////////////////////////////   参数组装  /////////////////////////////////

/**
除了sign_type参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母	
*/
$signStr = "";
if ($bank_code != "") {
    $signStr = $signStr . "bank_code=" . $bank_code . "&";
}
if ($client_ip != "") {
    $signStr = $signStr . "client_ip=" . $client_ip . "&";
}
if ($extend_param != "") {
    $signStr = $signStr . "extend_param=" . $extend_param . "&";
}
if ($extra_return_param != "") {
    $signStr = $signStr . "extra_return_param=" . $extra_return_param . "&";
}
$signStr = $signStr . "input_charset=" . $input_charset . "&";
$signStr = $signStr . "interface_version=" . $interface_version . "&";
$signStr = $signStr . "merchant_code=" . $merchant_code . "&";
$signStr = $signStr . "notify_url=" . $notify_url . "&";
$signStr = $signStr . "order_amount=" . $order_amount . "&";
$signStr = $signStr . "order_no=" . $order_no . "&";
$signStr = $signStr . "order_time=" . $order_time . "&";
if ($pay_type != "") {
    $signStr = $signStr . "pay_type=" . $pay_type . "&";
}
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
$postdata = array(
    'extend_param' => $extend_param,
    'extra_return_param' => $extra_return_param,
    'product_code' => $product_code,
    'product_desc' => $product_desc,
    'product_num' => $product_num,
    'merchant_code' => $merchant_code,
    'service_type' => $service_type,
    'notify_url' => $notify_url,
    'interface_version' => $interface_version,
    'sign_type' => $sign_type,
    'order_no' => $order_no,
    'client_ip' => $client_ip,
    'sign' => $sign,
    'order_time' => $order_time,
    'order_amount' => $order_amount,
    'product_name' => $product_name
);
$response = post_data($postdata, $merchant_url);
//$response = preg_replace('/\/css\//i', 'https://cdnpay.ddbill.com/css/', $response);
//$response = preg_replace('/\/js\//i', 'https://cdnpay.ddbill.com/js/', $response);
//$response = preg_replace('/\/images\//i', 'https://cdnpay.ddbill.com/images/', $response);
//$response = preg_replace('/action=\"Pay\"/i', 'action="https://cdnpay.ddbill.com/Pay"', $response);
echo $response;
function post_data($post_data, $url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_REFERER, "http://pay.zhfdcw.cn/");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $return = curl_exec($ch);
    curl_close($ch);
    return $return;
}