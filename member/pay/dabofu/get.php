<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$payApi = $merchant_url . '/v1/order';
$params = array(
    "amount" => $amount,
    "pay_channel" => $payChannel,
    "merchant_no" => $pay_mid,
    "request_no" => $_payId,
    "request_time" => time(),
    "nonce_str" => mt_rand(100000, 999999),
    "notify_url" => $notice_url,
    "account_type" => '1'
);
ksort($native);
$sign = strtoupper(md5(urldecode(http_build_query($native)) . "&key=" . $pay_mkey));
$params["sign"] = $sign;
$json = json_encode($params);
$result = curlPost($payApi, $json);
var_dump($result);
exit;
function curlPost($payApi, $json) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $payApi);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json)
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ', curl_error($ch), "\n";
    }
    curl_close($ch);
    return $result;
}