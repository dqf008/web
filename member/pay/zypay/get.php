<?php
header("Content-type: text/html; charset=utf-8");
$url = $merchant_url;
//处理数据
$data['Amount'] = $amount * 0.01; 
$data['Body'] = '';
$data['MerchantNo'] = $pay_mid;
$data['OutTradeNo'] = $_payId;
$data['PayWay'] = $payChannel;
$data['Key'] = $pay_mkey;
$str = "";
foreach ($data as $k => $v) {
    $str .= $v;
}
$str = strtoupper(md5($str));
$data['Sign'] = $str;
$data['Attach'] = '';
$data['Remark'] = '';
$data['NotifyUrl'] = $notice_url;
$post_str = "";
foreach ($data as $k => $v) {
    $post_str .= $k . '=' . $v . '&';
}
$post_str = rtrim($post_str, '&');
$json = post_data($post_str, $url);
print_r($json);
function post_data($post_data, $url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $return = curl_exec($ch);
    curl_close($ch);
    return $return;
}