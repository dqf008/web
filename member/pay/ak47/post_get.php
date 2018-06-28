<?php
require("easypay-api-sdk-php.php");
$parameters = array(
    "merchantNo" => "MAMC11004HUQV", //商号
    "outTradeNo" => $_payId, //订单k
    "currency" => "CNY",
    "amount" => $amount, //分
    //WECHAT_QRCODE_PAY  ALIPAY_QRCODE_PAY支付宝 QQ_QRCODE_PAY //qq钱包
    "payType" => $payChannel, //"ALIPAY_QRCODE_PAY",
    "content" => "PHP SDK",
    "callbackURL" => $notice_url //"http://bbs.com/member/pay/ak47/notify.php"
);
$response = request("com.opentech.cloud.easypay.trade.create", "0.0.1", $parameters);
if ($response['errorCode'] == 'SUCCEED') {
    $url = json_decode($response['data'], true);
    $url = $url['paymentInfo'];
    header("location:$url");
} else {
    header("Content-type: text/html; charset=utf-8");
    echo "<pre/>";
    print_r($response);
    exit;
}