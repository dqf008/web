<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$tjurl = $merchant_url . $payChannel;
$native = array(
    "merchant" => $pay_mid,
    "m_orderNo" => $_payId,
    "tranAmt" => $amount,
    "pname" => '测试商品',
    "notifyUrl" => $notice_url
);
ksort($native);
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
$md5str = $md5str . "key=" . $pay_mkey;
$sign = md5($md5str);
$native["sign"] = $sign;
$res = post_data($native, $tjurl);
$res = json_decode($res, true);
if ($res['retCode'] == '000000') {
    header('location:' . $res['retMsg']['paymentInfo']);
} else
    echo $res['retMsg'];
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