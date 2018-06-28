<?php
header("Content-type: text/html; charset=utf-8");
$client_ip = $_SERVER['REMOTE_ADDR'];
$extra_return_param = $ext;
$interface_version = 'V3.1';
$merchant_code = $pay_mid;
$notify_url = $notice_url;
$order_amount = $amount;
$order_no = $_payId;
$order_time = date("Y-m-d H:i:s");
$product_name = 'abc';
$service_type = $payChannel;
$sign_type = 'RSA-S';
$signStr = "";
$signStr = $signStr . "client_ip=" . $client_ip . "&";
if ($extend_param != "") {
    $signStr = $signStr . "extend_param=" . $extend_param . "&";
}
if ($extra_return_param != "") {
    $signStr = $signStr . "extra_return_param=" . $extra_return_param . "&";
}
$signStr = $signStr . "interface_version=" . $interface_version . "&";
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
$signStr = $signStr . "service_type=" . $service_type;
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
$xmlString = post_data($postdata, $merchant_url);
//file_put_contents("success.txt", $xmlString . "\n", FILE_APPEND);
$res = json_decode(json_encode(simplexml_load_string($xmlString)), true);
if ($res['response']['resp_code'] == 'SUCCESS') {
    header("location:" . urldecode($res['response']['payURL']));
}
function post_data($post_data, $url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
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