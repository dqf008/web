<?php
header("Content-type: text/html; charset=utf-8");
require_once("yidao.php");
$pay_mkey = explode('|', $pay_mkey);
$ydpay = new yidao($pay_mid, $pay_mkey[0], $pay_mkey[1]);
$ydpay->setNotifyUrl($notice_url);
$ydpay->setReturnUrl($notice_url);
$data = $ydpay->pay($_payId, "测试商品", $amount, $payChannel);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $merchant_url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// post数据
curl_setopt($ch, CURLOPT_POST, 1);
// post的变量
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output = curl_exec($ch);
curl_close($ch);
$response = json_decode($output, true);