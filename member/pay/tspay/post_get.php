<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$Md5key = $pay_mkey;
$tjurl = $merchant_url; //提交地址
$post_data = array(
    'merchno' => $pay_mid,
    'amount' => $amount,
    'traceno' => $_payId,
    'payType' => $payChannel,
    'notifyUrl' => $notice_url,
    'goodsName' => 'wapPay',
    'remark' => $ext
);
ksort($post_data);
$a = '';
foreach ($post_data as $x => $x_value) {
    $a = $a . $x . "=" . iconv('UTF-8', 'GB2312', $x_value) . "&";
}
$b = md5($a . $Md5key);
$c = $a . 'signature' . '=' . $b;
$con = curl_init((string) $tjurl);
curl_setopt($con, CURLOPT_HEADER, false);
curl_setopt($con, CURLOPT_POSTFIELDS, $c);
curl_setopt($con, CURLOPT_POST, true);
curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
curl_setopt($con, CURLOPT_TIMEOUT, 5);
$result = curl_exec($con);
$result = iconv('GB2312', 'UTF-8', $result);
$result = json_decode($result, true);
if ($result['respCode'] == '00') {
    $qrcode = $result['barCode'];
    header("location:" . $qrcode);
} else {
    echo "错误代码：" . $result['respCode'] . ' 错误描述:' . $result['message'];
}