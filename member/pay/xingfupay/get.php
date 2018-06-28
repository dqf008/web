<?php
//header("Content-type: text/html; charset=utf-8");
//echo "<pre/>";
$key = $pay_mkey;
$data = array();
$data['service'] = 'TRADE.SCANPAY';
$data['version'] = '1.0.0.0';
$data['merId'] = $pay_mid; //商户号
$data['typeId'] = $payChannel; //1；支付宝 2；微信 3；QQ钱包
$data['tradeNo'] = $_payId; //订单号
$data['tradeDate'] = date('Ymd');
$data['amount'] = $amount; //钱
$data['notifyUrl'] = $notice_url; //回调地址
$data['summary'] = '在线冲值';
$data['clientIp'] = $_SERVER['REMOTE_ADDR'];
$url = $merchant_url;
$str = "";
foreach ($data as $k => $v) {
    $str .= "{$k}={$v}&";
}
$str = substr($str, 0, -1) . $key;
$sign = md5($str);
$data['sign'] = $sign;
//print_r($data);
$header = array();
$xml = curl_https($url, $data, $header, 5);
$response = json_decode(json_encode((array) simplexml_load_string($xml)), true);
$res = array();
if ($response['detail']['code'] == '00') {
    $res['returncode'] = '00';
    $res['url'] = base64_decode($response['detail']['qrCode']);
} else {
    $res['returncode'] = '01';
    $res['msg'] = '取二维码失败，请联系第三方';
}
//print_r($response);
function curl_https($url, $data = array(), $header = array(), $timeout = 30) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true); // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $response = curl_exec($ch);
    if ($error = curl_error($ch)) {
        die($error);
    }
    curl_close($ch);
    return $response;
}