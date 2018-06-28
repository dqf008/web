<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$merchantId = $pay_mid; //渠道号
$key = $pay_mkey; //key
$orderId = $_payId; //订单号
$orderAmount = $amount * 100; //订单金额 单位分
$payType = $payChannel; //付款类型 支付宝扫码
$notifyUrl = ""; //通知Url
$selfParam = ""; //扩展
$remark = ""; //备注
$timestamp = time();
$random = mt_rand(100000, 999999);
$signContent = "";
$signContent = $signContent . "merchantId=" . $merchantId;
$signContent = $signContent . "&appKey=" . $key;
$signContent = $signContent . "&payType=" . $payType;
$signContent = $signContent . "&orderAmount=" . $orderAmount;
$signContent = $signContent . "&orderId=" . $orderId;
$signContent = $signContent . "&timestamp=" . $timestamp;
$signContent = $signContent . "&random=" . $random;
$signature = strtoupper(sha1($signContent));
$data = array(
    "orderId" => $orderId,
    "merchantId" => $merchantId,
    "orderAmount" => $orderAmount,
    "payType" => $payType,
    "random" => $random,
    "signature" => $signature,
    "timestamp" => $timestamp
);
$result = post_data($data, $merchant_url);
$result = json_decode($result, true);
if ($result['ErrorCode'] == '0') {
    header("Location: " . $result['CodeUrl']);
    exit;
} else
    echo $result['Message'];
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