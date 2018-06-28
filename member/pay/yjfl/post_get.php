<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$Md5key = $pay_mkey;
$tjurl = $merchant_url; //提交地址
$native = array(
    "p1_MerchantNo" => $pay_mid,
    "p2_OrderNo" => $_payId,
    "p3_Amount" => $amount * 100,
    "p4_Cur" => '1',
    "p5_ProductName" => $ext,
    "p6_NotifyUrl" => $notice_url,
    "p7_pageUrl" => $notice_url,
    "bizType" => $payChannel
);
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $val;
}
$md5str = $md5str . $pay_mkey;
$sign = md5($md5str);
$native["sign"] = $sign;
$json = post_data($native, $tjurl);
//$res = json_decode($json, true);
var_dump($json);
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