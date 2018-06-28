<?php
include_once 'cache/pay_conf.php';
unset($arr_online_config);

//
$arr_online_config['快付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['快付支付宝']['pay_mid'] = '10003';
$arr_online_config['快付支付宝']['pay_mkey'] = '4hkqz051ers41ywadqicfk42tyoqmfrp';
$arr_online_config['快付支付宝']['pay_url'] = 'http://182.16.12.114/member/';
$arr_online_config['快付支付宝']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['快付支付宝']['post_url'] = '/member/pay/kfpay/pay.php?S_Type=ALIPAY';
$arr_online_config['快付支付宝']['notice_url'] = $arr_online_config['快付支付宝']['pay_url'] . 'pay/kfpay/notify.php';

$arr_online_config['快付银联'] = $arr_online_config['快付支付宝'];
$arr_online_config['快付银联']['online_name'] = '银联支付';
$arr_online_config['快付银联']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['快付银联']['post_url'] = '/member/pay/kfpay/pay.php?S_Type=UNIONPAY';

$arr_online_config['快付网银'] = $arr_online_config['快付支付宝'];
$arr_online_config['快付网银']['online_name'] = '网银支付';
$arr_online_config['快付网银']['input_url'] = '/member/pay/kfpay.php';
$arr_online_config['快付网银']['post_url'] = '/member/pay/kfpay/pay.php?S_Type=ONLINE';

/*
$arr_online_config['移动支付']['online_name'] = '网银支付';
$arr_online_config['移动支付']['pay_mid'] = '201804241422490';
$arr_online_config['移动支付']['pay_mkey'] = 'OTlhZjVmOTM1Yjc5NDkxMTg0NWQ0ZGY4NmEwZDY5YmVBSEhC';
$arr_online_config['移动支付']['pay_url'] = '/member/pay/yidpay'; 
$arr_online_config['移动支付']['input_url'] = '/member/pay/yidpay.php';
$arr_online_config['移动支付']['post_url'] = '/member/pay/yidpay/pay.php';
$arr_online_config['移动支付']['notice_url'] = 'http://pay.8828776.com/pay/yidpay/notify.php';


$arr_online_config['逆天微信']['online_name'] = '微信扫码';
$arr_online_config['逆天微信']['pay_mid'] = '4';
$arr_online_config['逆天微信']['pay_mkey'] = 'trga&$$mf89K';
$arr_online_config['逆天微信']['pay_url'] = '/member/pay/fpay'; 
$arr_online_config['逆天微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['逆天微信']['post_url'] = '/member/pay/fpay/pay.php?S_Type=WECHAT';
$arr_online_config['逆天支付宝'] = $arr_online_config['逆天微信'];
$arr_online_config['逆天支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['逆天支付宝']['post_url'] = '/member/pay/fpay/pay.php?S_Type=ALIPAY';


$arr_online_config['易到微信']['online_name'] = '微信扫码';
$arr_online_config['易到微信']['pay_mid'] = 'MERCOONT8967371352925827638';
$arr_online_config['易到微信']['pay_mkey'] = 'iUs75zqVJXj8TxNW|hBnaNxtxGC9Xy9MH';
$arr_online_config['易到微信']['pay_url'] = 'http://182.16.12.114/member/';
$arr_online_config['易到微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['易到微信']['post_url'] = '/member/pay/ydpay/pay.php?S_Type=WECHAT';
$arr_online_config['易到微信']['notice_url'] = $arr_online_config['易到微信']['pay_url'] . 'pay/ydpay/notify.php';
$arr_online_config['易到微信']['merchant_url'] = 'http://api.easypay168.cn/externalSendPay/rechargepay.do';
$arr_online_config['易到支付宝'] = $arr_online_config['易到微信'];
$arr_online_config['易到支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['易到支付宝']['post_url'] = '/member/pay/ydpay/pay.php?S_Type=ALIPAY';
$arr_online_config['易到QQ钱包'] = $arr_online_config['易到微信'];
$arr_online_config['易到QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['易到QQ钱包']['post_url'] = '/member/pay/ydpay/pay.php?S_Type=QQPAY';
$arr_online_config['易到微信H5'] = $arr_online_config['易到微信'];
$arr_online_config['易到微信H5']['online_name'] = '微信H5';
$arr_online_config['易到微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['易到微信H5']['post_url'] = '/member/pay/ydpay/pany.php?S_Type=WECHAT';
$arr_online_config['易到支付宝H5'] = $arr_online_config['易到微信H5'];
$arr_online_config['易到支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['易到支付宝H5']['post_url'] = '/member/pay/ydpay/pany.php?S_Type=ALIPAY';
$arr_online_config['易到网银'] = $arr_online_config['易到微信H5'];
$arr_online_config['易到网银']['online_name'] = '网银支付';
$arr_online_config['易到网银']['post_url'] = '/member/pay/ydpay/pany.php';
$arr_online_config['易到网银']['merchant_url'] = 'http://api.easypay168.cn/externalSendPay/gateWayPay.do';


$arr_online_config['闪付微信']['online_name'] = '微信扫码';
$arr_online_config['闪付微信']['pay_mid'] = '611913';
$arr_online_config['闪付微信']['pay_mkey'] = '416517a1028c40a8';
$arr_online_config['闪付微信']['pay_TerminalID'] = '11913';
$arr_online_config['闪付微信']['pay_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/member/';
$arr_online_config['闪付微信']['input_url'] = $arr_online_config['闪付微信']['pay_url'] . 'pay/dinpay3.1.php';
$arr_online_config['闪付微信']['post_url'] = $arr_online_config['闪付微信']['pay_url'] . 'pay/sslsf/pay.php?S_Type=WECHAT';
$arr_online_config['闪付微信']['notice_url'] = $arr_online_config['闪付微信']['pay_url'] . 'pay/sslsf/notify.php';
$arr_online_config['闪付微信']['return_url'] = $arr_online_config['闪付微信']['pay_url'] . 'pay/sslsf/success.html';
$arr_online_config['闪付微信']['merchant_url'] = 'https://gw.sslsf.com/v4.aspx';
$arr_online_config['闪付支付宝'] = $arr_online_config['闪付微信'];
$arr_online_config['闪付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['闪付支付宝']['post_url'] = $arr_online_config['闪付微信']['pay_url'] . 'pay/sslsf/pay.php?S_Type=ALIPAY';
$arr_online_config['闪付QQ钱包'] = $arr_online_config['闪付微信'];
$arr_online_config['闪付QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['闪付QQ钱包']['post_url'] = $arr_online_config['闪付微信']['pay_url'] . 'pay/sslsf/pay.php?S_Type=QQPAY';
$arr_online_config['闪付网银'] = $arr_online_config['闪付微信'];
$arr_online_config['闪付网银']['online_name'] = '网银支付';
$arr_online_config['闪付网银']['post_url'] = $arr_online_config['闪付微信']['pay_url'] . 'pay/sslsf/pany.php';


$arr_online_config['泽圣微信']['online_name'] = '微信扫码';
$arr_online_config['泽圣微信']['pay_mid'] = '1000000679';
$arr_online_config['泽圣微信']['pay_mkey'] = '8615c518-72e5-4ee4-b95b-bd7fa1e5b746';
//$arr_online_config['泽圣微信']['pay_url'] = 'http://pay2.xxxyyd.top/member/';
$arr_online_config['泽圣微信']['pay_url'] = 'http://pay.gylight.com/member/';
$arr_online_config['泽圣微信']['input_url'] = $arr_online_config['泽圣微信']['pay_url'] . 'pay/zspay.php';
$arr_online_config['泽圣微信']['post_url'] = $arr_online_config['泽圣微信']['pay_url'] . 'pay/zspay/pay.php?S_Type=WECHAT';
$arr_online_config['泽圣微信']['notice_url'] = $arr_online_config['泽圣微信']['pay_url'] . 'pay/zspay/notify.php';
$arr_online_config['泽圣微信']['return_url'] = $arr_online_config['泽圣微信']['pay_url'] . 'pay/zspay/success.html';
$arr_online_config['泽圣微信']['merchant_url'] = 'http://payment.zsagepay.com/scan/entrance.do';
$arr_online_config['泽圣支付宝'] = $arr_online_config['泽圣微信'];
$arr_online_config['泽圣支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['泽圣支付宝']['post_url'] = $arr_online_config['泽圣微信']['pay_url'] . 'pay/zspay/pay.php?S_Type=ALIPAY';
$arr_online_config['泽圣QQ钱包'] = $arr_online_config['泽圣微信'];
$arr_online_config['泽圣QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['泽圣QQ钱包']['post_url'] = $arr_online_config['泽圣QQ钱包']['pay_url'] . 'pay/zspay/pay.php?S_Type=QQPAY';


$arr_online_config['银丰微信']['online_name'] = '微信扫码';
$arr_online_config['银丰微信']['pay_mid'] = 'xjqc000010';
$arr_online_config['银丰微信']['pay_mkey'] = '1154c7c7e19c4caeb0207bb09291abd8';
$arr_online_config['银丰微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['银丰微信']['input_url'] = $arr_online_config['银丰微信']['pay_url'] . 'pay/zspay.php';
$arr_online_config['银丰微信']['post_url'] = $arr_online_config['银丰微信']['pay_url'] . 'pay/yfpay/pay.php?S_Type=WECHAT';
$arr_online_config['银丰微信']['notice_url'] = $arr_online_config['银丰微信']['pay_url'] . 'pay/yfpay/notify.php';
$arr_online_config['银丰微信']['return_url'] = $arr_online_config['银丰微信']['pay_url'] . 'pay/yfpay/success.html';
$arr_online_config['银丰微信']['merchant_url'] = 'http://113.106.95.37:7777/gyprovider/getNativeUrl.do';
$arr_online_config['银丰支付宝'] = $arr_online_config['银丰微信'];
$arr_online_config['银丰支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['银丰支付宝']['post_url'] = $arr_online_config['银丰微信']['pay_url'] . 'pay/yfpay/pay.php?S_Type=ALIPAY';
$arr_online_config['银丰QQ钱包'] = $arr_online_config['银丰微信'];
$arr_online_config['银丰QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['银丰QQ钱包']['post_url'] = $arr_online_config['银丰QQ钱包']['pay_url'] . 'pay/yfpay/pay.php?S_Type=QQPAY';


//快付
$arr_online_config['快付微信']['online_name'] = '微信扫码';
$arr_online_config['快付微信']['pay_mid'] = '10002';
$arr_online_config['快付微信']['pay_mkey'] = 't4ig5acnpx4fet4zapshjacjd9o4bhbi';
$arr_online_config['快付微信']['pay_url'] = 'http://182.16.12.114/member/';
$arr_online_config['快付微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['快付微信']['post_url'] = '/member/pay/sfbpay/pay.php?S_Type=WECHAT';
$arr_online_config['快付微信']['notice_url'] = $arr_online_config['快付微信']['pay_url'] . 'pay/sfbpay/notify.php';
$arr_online_config['快付微信']['return_url'] = $arr_online_config['快付微信']['pay_url'] . 'pay/sfbpay/success.html';
$arr_online_config['快付微信']['merchant_url'] = 'http://www.597kf.com/Pay_Index.html';
$arr_online_config['快付支付宝'] = $arr_online_config['快付微信'];
$arr_online_config['快付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['快付支付宝']['post_url'] = '/member/pay/sfbpay/pay.php?S_Type=ALIPAY';
$arr_online_config['快付QQ钱包'] = $arr_online_config['快付微信'];
$arr_online_config['快付QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['快付QQ钱包']['post_url'] = '/member/pay/sfbpay/pay.php?S_Type=QQPAY';
$arr_online_config['快付京东钱包'] = $arr_online_config['快付微信'];
$arr_online_config['快付京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['快付京东钱包']['post_url'] = '/member/pay/sfbpay/pay.php?S_Type=JDPAY';
$arr_online_config['快付微信H5'] = $arr_online_config['快付微信'];
$arr_online_config['快付微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['快付微信H5']['online_name'] = '微信H5';
$arr_online_config['快付微信H5']['post_url'] = '/member/pay/sfbpay/pany.php?S_Type=WECHAT';
$arr_online_config['快付支付宝H5'] = $arr_online_config['快付微信H5'];
$arr_online_config['快付支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['快付支付宝H5']['post_url'] = '/member/pay/sfbpay/pany.php?S_Type=ALIPAY';
$arr_online_config['快付网银'] = $arr_online_config['快付微信H5'];
$arr_online_config['快付网银']['online_name'] = '网银支付';
$arr_online_config['快付网银']['post_url'] = '/member/pay/sfbpay/pany.php';

/*
//国付宝
$arr_online_config['国付宝网银']['online_name'] = '网银支付';
$arr_online_config['国付宝网银']['pay_mid'] = '0000001502|0000000002000000257';
$arr_online_config['国付宝网银']['pay_mkey'] = '11111aaaaa';
$arr_online_config['国付宝网银']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['国付宝网银']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['国付宝网银']['post_url'] = '/member/pay/gfbpay/pany.php';
$arr_online_config['国付宝网银']['notice_url'] = $arr_online_config['国付宝网银']['pay_url'] . 'pay/gfbpay/notify.php';
$arr_online_config['国付宝网银']['return_url'] = $arr_online_config['国付宝网银']['pay_url'] . 'pay/gfbpay/success.html';
$arr_online_config['国付宝网银']['merchant_url'] = 'https://gatewaymer.gopay.com.cn/Trans/WebClientAction.do';
*

//国付宝2
$arr_online_config['国付宝2网银']['online_name'] = '网银支付';
$arr_online_config['国付宝2网银']['pay_mid'] = '0000009421|0000000002000003367';
$arr_online_config['国付宝2网银']['pay_mkey'] = 'EjFSXJaCLJ0EelpxXuG8';
$arr_online_config['国付宝2网银']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['国付宝2网银']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['国付宝2网银']['post_url'] = '/member/pay/gfb2pay/pany.php';
$arr_online_config['国付宝2网银']['notice_url'] = $arr_online_config['国付宝2网银']['pay_url'] . 'pay/gfb2pay/notify.php';
$arr_online_config['国付宝2网银']['return_url'] = $arr_online_config['国付宝2网银']['pay_url'] . 'pay/gfb2pay/success.html';
$arr_online_config['国付宝2网银']['merchant_url'] = 'https://gateway.gopay.com.cn/Trans/WebClientAction.do';


/*
//ak47
$arr_online_config['ak47微信']['online_name'] = '微信扫码';
$arr_online_config['ak47微信']['pay_mid'] = '10002';
$arr_online_config['ak47微信']['pay_mkey'] = 't4ig5acnpx4fet4zapshjacjd9o4bhbi';
$arr_online_config['ak47微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['ak47微信']['input_url'] = $arr_online_config['ak47微信']['pay_url'] . 'pay/zspay.php';
$arr_online_config['ak47微信']['post_url'] = $arr_online_config['ak47微信']['pay_url'] . 'pay/ak47/pay.php?S_Type=WECHAT';
$arr_online_config['ak47微信']['notice_url'] = $arr_online_config['ak47微信']['pay_url'] . 'pay/ak47/notify.php';
$arr_online_config['ak47微信']['return_url'] = $arr_online_config['ak47微信']['pay_url'] . 'pay/ak47/success.html';
$arr_online_config['ak47微信']['merchant_url'] = 'https://gw.ak47pay.com/native';
$arr_online_config['ak47支付宝'] = $arr_online_config['ak47微信'];
$arr_online_config['ak47支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['ak47支付宝']['post_url'] = $arr_online_config['ak47微信']['pay_url'] . 'pay/ak47/pay.php?S_Type=ALIPAY';
$arr_online_config['ak47QQ钱包'] = $arr_online_config['ak47微信'];
$arr_online_config['ak47QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['ak47QQ钱包']['post_url'] = $arr_online_config['ak47QQ钱包']['pay_url'] . 'pay/ak47/pay.php?S_Type=QQPAY';
$arr_online_config['ak47微信H5'] = $arr_online_config['ak47微信'];
$arr_online_config['ak47微信H5']['online_name'] = '微信H5';
$arr_online_config['ak47微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['ak47微信H5']['post_url'] = '/member/pay/ak47/pany.php?S_Type=WECHAT';
*/

/*
//智付网银
$arr_online_config['智付快捷支付网银']['online_name'] = '网银支付';
$arr_online_config['智付快捷支付网银']['pay_mid'] = '1111110166';
$arr_online_config['智付快捷支付网银']['pay_mkey'] = '';
$arr_online_config['智付快捷支付网银']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['智付快捷支付网银']['input_url'] = $arr_online_config['智付快捷支付网银']['pay_url'] . 'pay/dinkjpay.php';
$arr_online_config['智付快捷支付网银']['post_url'] = $arr_online_config['智付快捷支付网银']['pay_url'] . 'pay/dinkjpay/pay.php';
$arr_online_config['智付快捷支付网银']['notice_url'] = $arr_online_config['智付快捷支付网银']['pay_url'] . 'pay/dinkjpay/notify.php';
$arr_online_config['智付快捷支付网银']['return_url'] = $arr_online_config['智付快捷支付网银']['pay_url'] . 'pay/dinkjpay/success.html';
*/

/*
//星付支付 xingfupay
$arr_online_config['星付微信']['online_name'] = '微信扫码';
$arr_online_config['星付微信']['pay_mid'] = '2017090544010402';
$arr_online_config['星付微信']['pay_mkey'] = '4c07e5d957e4a6cd432c918459f373c6';
$arr_online_config['星付微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['星付微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['星付微信']['post_url'] = '/member/pay/xingfupay/pay.php?S_Type=WECHAT';
$arr_online_config['星付微信']['notice_url'] = $arr_online_config['星付微信']['pay_url'] . 'pay/xingfupay/notify.php';
$arr_online_config['星付微信']['return_url'] = $arr_online_config['星付微信']['pay_url'] . 'pay/xingfupay/success.html';
$arr_online_config['星付微信']['merchant_url'] = 'https://gate.lfbpay.com/cooperate/gateway.cgi';
$arr_online_config['星付支付宝'] = $arr_online_config['星付微信'];
$arr_online_config['星付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['星付支付宝']['post_url'] = '/member/pay/xingfupay/pay.php?S_Type=ALIPAY';
$arr_online_config['星付QQ钱包'] = $arr_online_config['星付微信'];
$arr_online_config['星付QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['星付QQ钱包']['post_url'] = '/member/pay/xingfupay/pay.php?S_Type=QQPAY';
$arr_online_config['星付网银'] = $arr_online_config['星付微信'];
$arr_online_config['星付网银']['online_name'] = '星付网银';
$arr_online_config['星付网银']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['星付网银']['post_url'] = '/member/pay/xingfupay/pany2.php';
$arr_online_config['星付微信H5'] = $arr_online_config['星付微信'];
$arr_online_config['星付微信H5']['online_name'] = '微信H5';
$arr_online_config['星付微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['星付微信H5']['post_url'] = '/member/pay/xingfupay/pany.php?S_Type=WECHAT';
*/

/*
//新码支付 
$arr_online_config['新码微信']['online_name'] = '微信扫码';
$arr_online_config['新码微信']['pay_mid'] = '171200273152';
$arr_online_config['新码微信']['pay_mkey'] = '6e595abbd461467e966efd59d33579dd';
$arr_online_config['新码微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['新码微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['新码微信']['post_url'] = '/member/pay/xinma/pay.php?S_Type=WECHAT';
$arr_online_config['新码微信']['notice_url'] = $arr_online_config['新码微信']['pay_url'] . 'pay/xinma/notify.php';
$arr_online_config['新码微信']['return_url'] = $arr_online_config['新码微信']['pay_url'] . 'pay/xinma/success.html';
$arr_online_config['新码微信']['merchant_url'] = 'https://www.xinmapay.com:7301/jhpayment';
$arr_online_config['新码支付宝'] = $arr_online_config['新码微信'];
$arr_online_config['新码支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['新码支付宝']['post_url'] = '/member/pay/xinma/pay.php?S_Type=ALIPAY';
$arr_online_config['新码QQ钱包'] = $arr_online_config['新码微信'];
$arr_online_config['新码QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['新码QQ钱包']['post_url'] = '/member/pay/xinma/pay.php?S_Type=QQPAY';
$arr_online_config['新码京东钱包'] = $arr_online_config['新码微信'];
$arr_online_config['新码京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['新码京东钱包']['post_url'] = '/member/pay/xinma/pay.php?S_Type=JDPAY';
$arr_online_config['新码银联扫码'] = $arr_online_config['新码微信'];
$arr_online_config['新码银联扫码']['online_name'] = '银联扫码';
$arr_online_config['新码银联扫码']['post_url'] = '/member/pay/xinma/pay.php?S_Type=UNIONPAY';
$arr_online_config['新码网银'] = $arr_online_config['新码微信'];
$arr_online_config['新码网银']['online_name'] = '网银支付';
$arr_online_config['新码网银']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['新码网银']['post_url'] = '/member/pay/xinma/pany2.php';
$arr_online_config['新码微信H5'] = $arr_online_config['新码微信'];
$arr_online_config['新码微信H5']['online_name'] = '微信H5';
$arr_online_config['新码微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['新码微信H5']['post_url'] = '/member/pay/xinma/pany.php?S_Type=WECHAT';
$arr_online_config['新码支付宝H5'] = $arr_online_config['新码微信'];
$arr_online_config['新码支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['新码支付宝H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['新码支付宝H5']['post_url'] = '/member/pay/xinma/pany.php?S_Type=ALIPAY';
$arr_online_config['新码QQ钱包H5'] = $arr_online_config['新码微信'];
$arr_online_config['新码QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['新码QQ钱包H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['新码QQ钱包H5']['post_url'] = '/member/pay/xinma/pany.php?S_Type=QQPAY';
$arr_online_config['新码京东钱包H5'] = $arr_online_config['新码微信'];
$arr_online_config['新码京东钱包H5']['online_name'] = '京东钱包H5';
$arr_online_config['新码京东钱包H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['新码京东钱包H5']['post_url'] = '/member/pay/xinma/pany.php?S_Type=JDPAY';
*/

/*
//五福支付 
$arr_online_config['五福微信']['online_name'] = '微信扫码';
$arr_online_config['五福微信']['pay_mid'] = 'WF69159';
$arr_online_config['五福微信']['pay_mkey'] = 'QSHGHDDSHEVTVFAMIV1XJNVDO27EFOEN';
$arr_online_config['五福微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['五福微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['五福微信']['post_url'] = '/member/pay/wufu/pay.php?S_Type=WECHAT';
$arr_online_config['五福微信']['notice_url'] = $arr_online_config['五福微信']['pay_url'] . 'pay/wufu/notify.php';
$arr_online_config['五福微信']['return_url'] = $arr_online_config['五福微信']['pay_url'] . 'pay/wufu/success.html';
$arr_online_config['五福微信']['merchant_url'] = 'https://pay.llsyqm.com/uniThirdPay';
$arr_online_config['五福支付宝'] = $arr_online_config['五福微信'];
$arr_online_config['五福支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['五福支付宝']['post_url'] = '/member/pay/wufu/pay.php?S_Type=ALIPAY';
$arr_online_config['五福QQ钱包'] = $arr_online_config['五福微信'];
$arr_online_config['五福QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['五福QQ钱包']['post_url'] = '/member/pay/wufu/pay.php?S_Type=QQPAY';
$arr_online_config['五福京东钱包'] = $arr_online_config['五福微信'];
$arr_online_config['五福京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['五福京东钱包']['post_url'] = '/member/pay/wufu/pay.php?S_Type=JDPAY';
$arr_online_config['五福银联扫码'] = $arr_online_config['五福微信'];
$arr_online_config['五福银联扫码']['online_name'] = '银联扫码';
$arr_online_config['五福银联扫码']['post_url'] = '/member/pay/wufu/pay.php?S_Type=UNIONPAY';
$arr_online_config['五福网银'] = $arr_online_config['五福微信'];
$arr_online_config['五福网银']['online_name'] = '网银支付';
$arr_online_config['五福网银']['post_url'] = '/member/pay/wufu/pany2.php';
$arr_online_config['五福微信H5'] = $arr_online_config['五福微信'];
$arr_online_config['五福微信H5']['online_name'] = '微信H5';
$arr_online_config['五福微信H5']['post_url'] = '/member/pay/wufu/pany.php?S_Type=WECHAT';
$arr_online_config['五福支付宝H5'] = $arr_online_config['五福微信'];
$arr_online_config['五福支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['五福支付宝H5']['post_url'] = '/member/pay/wufu/pany.php?S_Type=ALIPAY';
$arr_online_config['五福QQ钱包H5'] = $arr_online_config['五福微信'];
$arr_online_config['五福QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['五福QQ钱包H5']['post_url'] = '/member/pay/wufu/pany.php?S_Type=QQPAY';
$arr_online_config['五福京东钱包H5'] = $arr_online_config['五福微信'];
$arr_online_config['五福京东钱包H5']['online_name'] = '京东钱包H5';
$arr_online_config['五福京东钱包H5']['post_url'] = '/member/pay/wufu/pany.php?S_Type=JDPAY';
*/

/*
//E宝支付 
$arr_online_config['E宝微信']['online_name'] = '微信扫码';
$arr_online_config['E宝微信']['pay_mid'] = '33728';
$arr_online_config['E宝微信']['pay_mkey'] = 'c2y1ZEg33yku8ViL7vMzLVsrKQUO1V';
$arr_online_config['E宝微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['E宝微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['E宝微信']['post_url'] = '/member/pay/eboopay/pay.php?S_Type=WECHAT';
$arr_online_config['E宝微信']['notice_url'] = $arr_online_config['五福微信']['pay_url'] . 'pay/eboopay/notify.php';
$arr_online_config['E宝微信']['return_url'] = $arr_online_config['五福微信']['pay_url'] . 'pay/eboopay/success.html';
$arr_online_config['E宝微信']['merchant_url'] = 'http://sapi.eboopay.com/Pay_Index.html';
$arr_online_config['E宝支付宝'] = $arr_online_config['E宝微信'];
$arr_online_config['E宝支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['E宝支付宝']['post_url'] = '/member/pay/eboopay/pay.php?S_Type=ALIPAY';
$arr_online_config['E宝QQ钱包'] = $arr_online_config['E宝微信'];
$arr_online_config['E宝QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['E宝QQ钱包']['post_url'] = '/member/pay/eboopay/pay.php?S_Type=QQPAY';
$arr_online_config['E宝京东钱包'] = $arr_online_config['E宝微信'];
$arr_online_config['E宝京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['E宝京东钱包']['post_url'] = '/member/pay/eboopay/pay.php?S_Type=JDPAY';
$arr_online_config['E宝银联扫码'] = $arr_online_config['E宝微信'];
$arr_online_config['E宝银联扫码']['online_name'] = '银联扫码';
$arr_online_config['E宝银联扫码']['post_url'] = '/member/pay/eboopay/pay.php?S_Type=UNIONPAY';
$arr_online_config['E宝网银'] = $arr_online_config['E宝微信'];
$arr_online_config['E宝网银']['online_name'] = '网银支付';
$arr_online_config['E宝网银']['post_url'] = '/member/pay/eboopay/pany2.php';
$arr_online_config['E宝微信H5'] = $arr_online_config['E宝微信'];
$arr_online_config['E宝微信H5']['online_name'] = '微信H5';
$arr_online_config['E宝微信H5']['post_url'] = '/member/pay/eboopay/pany.php?S_Type=WECHAT';
$arr_online_config['E宝支付宝H5'] = $arr_online_config['E宝微信'];
$arr_online_config['E宝支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['E宝支付宝H5']['post_url'] = '/member/pay/eboopay/pany.php?S_Type=ALIPAY';
$arr_online_config['E宝QQ钱包H5'] = $arr_online_config['E宝微信'];
$arr_online_config['E宝QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['E宝QQ钱包H5']['post_url'] = '/member/pay/eboopay/pany.php?S_Type=QQPAY';
*/

/*
//得利通支付 
$arr_online_config['得利通微信']['online_name'] = '微信扫码';
$arr_online_config['得利通微信']['pay_mid'] = '2438';
$arr_online_config['得利通微信']['pay_mkey'] = '0bffbc11ebec464fbbc39f6bf48cd85c';
$arr_online_config['得利通微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['得利通微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['得利通微信']['post_url'] = '/member/pay/delibpay/pay.php?S_Type=WECHAT';
$arr_online_config['得利通微信']['notice_url'] = $arr_online_config['得利通微信']['pay_url'] . 'pay/delibpay/notify.php';
$arr_online_config['得利通微信']['return_url'] = $arr_online_config['得利通微信']['pay_url'] . 'pay/delibpay/success.html';
$arr_online_config['得利通微信']['merchant_url'] = 'http://pay.delibpay.com/bank/index.aspx';
$arr_online_config['得利通微信H5'] = $arr_online_config['得利通微信'];
$arr_online_config['得利通微信H5']['online_name'] = '微信H5';
$arr_online_config['得利通微信H5']['post_url'] = '/member/pay/delibpay/pany.php?S_Type=WECHAT';
* /


//金阳支付 
$arr_online_config['金阳微信']['online_name'] = '微信扫码';
$arr_online_config['金阳微信']['pay_mid'] = '22225';
$arr_online_config['金阳微信']['pay_mkey'] = '7eb1bed4217fe23c814b159fb6d66755';
$arr_online_config['金阳微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['金阳微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['金阳微信']['post_url'] = '/member/pay/095pay/pay.php?S_Type=WECHAT';
$arr_online_config['金阳微信']['notice_url'] = $arr_online_config['金阳微信']['pay_url'] . 'pay/095pay/notify.php';
$arr_online_config['金阳微信']['return_url'] = $arr_online_config['金阳微信']['pay_url'] . 'pay/095pay/success.html';
$arr_online_config['金阳微信']['merchant_url'] = 'http://pay.095pay.com/zfapi/order/pay';
$arr_online_config['金阳QQ钱包'] = $arr_online_config['金阳微信'];
$arr_online_config['金阳QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['金阳QQ钱包']['post_url'] = '/member/pay/095pay/pay.php?S_Type=QQPAY';
$arr_online_config['金阳微信H5'] = $arr_online_config['金阳微信'];
$arr_online_config['金阳微信H5']['online_name'] = '微信H5';
$arr_online_config['金阳微信H5']['post_url'] = '/member/pay/095pay/pany.php?S_Type=WECHAT';
$arr_online_config['金阳支付宝H5'] = $arr_online_config['金阳微信'];
$arr_online_config['金阳支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['金阳支付宝H5']['post_url'] = '/member/pay/095pay/pany.php?S_Type=ALIPAY';
$arr_online_config['金阳QQ钱包H5'] = $arr_online_config['金阳微信'];
$arr_online_config['金阳QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['金阳QQ钱包H5']['post_url'] = '/member/pay/095pay/pany.php?S_Type=QQPAY';
$arr_online_config['金阳快捷'] = $arr_online_config['金阳微信'];
$arr_online_config['金阳快捷']['online_name'] = '快捷支付';
$arr_online_config['金阳快捷']['post_url'] = '/member/pay/095pay/pany.php?S_Type=FASTPAY';
$arr_online_config['金阳网银'] = $arr_online_config['金阳微信'];
$arr_online_config['金阳网银']['online_name'] = '网银支付';
$arr_online_config['金阳网银']['post_url'] = '/member/pay/095pay/pany2.php';


/*
//鼎易支付 dingyipay
$arr_online_config['鼎易微信']['online_name'] = '微信扫码';
$arr_online_config['鼎易微信']['pay_mid'] = '10668';
$arr_online_config['鼎易微信']['pay_mkey'] = 'a08546f1ddef45ea8cdf6038c4a8b83c';
$arr_online_config['鼎易微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['鼎易微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['鼎易微信']['post_url'] = '/member/pay/dingyipay/pany.php?S_Type=WECHAT';
$arr_online_config['鼎易微信']['notice_url'] = $arr_online_config['鼎易微信']['pay_url'] . 'pay/dingyipay/notify.php';
$arr_online_config['鼎易微信']['return_url'] = $arr_online_config['鼎易微信']['pay_url'] . 'pay/dingyipay/success.html';
$arr_online_config['鼎易微信']['merchant_url'] = 'http://pay.dingyipay.com/ChargeBank.aspx';
$arr_online_config['鼎易支付宝'] = $arr_online_config['鼎易微信'];
$arr_online_config['鼎易支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['鼎易支付宝']['post_url'] = '/member/pay/dingyipay/pany.php?S_Type=ALIPAY';
$arr_online_config['鼎易QQ钱包'] = $arr_online_config['鼎易微信'];
$arr_online_config['鼎易QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['鼎易QQ钱包']['post_url'] = '/member/pay/dingyipay/pany.php?S_Type=QQPAY';
$arr_online_config['鼎易网银'] = $arr_online_config['鼎易微信'];
$arr_online_config['鼎易网银']['online_name'] = '网银支付';
$arr_online_config['鼎易网银']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['鼎易网银']['post_url'] = '/member/pay/dingyipay/pany.php';
*/

/*
//OK付
$arr_online_config['OK微信']['online_name'] = '微信扫码';
$arr_online_config['OK微信']['pay_mid'] = '5772';
$arr_online_config['OK微信']['pay_mkey'] = '934cdbc9ecf24403ae07bd4d254e5cab';
$arr_online_config['OK微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['OK微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['OK微信']['post_url'] = '/member/pay/okpay/pany.php?S_Type=WECHAT';
$arr_online_config['OK微信']['notice_url'] = $arr_online_config['OK微信']['pay_url'] . 'pay/okpay/notify.php';
$arr_online_config['OK微信']['return_url'] = $arr_online_config['OK微信']['pay_url'] . 'pay/okpay/success.html';
$arr_online_config['OK微信']['merchant_url'] = 'https://gateway.okfpay.com/Gate/payindex.aspx';
$arr_online_config['OK支付宝'] = $arr_online_config['OK微信'];
$arr_online_config['OK支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['OK支付宝']['post_url'] = '/member/pay/okpay/pany.php?S_Type=ALIPAY';
$arr_online_config['OKQQ钱包'] = $arr_online_config['OK微信'];
$arr_online_config['OKQQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['OKQQ钱包']['post_url'] = '/member/pay/okpay/pany.php?S_Type=QQPAY';
$arr_online_config['OK京东钱包'] = $arr_online_config['OK微信'];
$arr_online_config['OK京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['OK京东钱包']['post_url'] = '/member/pay/okpay/pany.php?S_Type=JDPAY';
$arr_online_config['OK财付通'] = $arr_online_config['OK微信'];
$arr_online_config['OK财付通']['online_name'] = '财付通扫码';
$arr_online_config['OK财付通']['post_url'] = '/member/pay/okpay/pany.php?S_Type=TENPAY';
$arr_online_config['OK网银支付'] = $arr_online_config['OK微信'];
$arr_online_config['OK网银支付']['online_name'] = '网银支付';
$arr_online_config['OK网银支付']['post_url'] = '/member/pay/okpay/pany2.php?S_Type=UNIONPAY';
*/

/*
//月宝支付
$arr_online_config['月宝微信']['online_name'] = '微信扫码';
$arr_online_config['月宝微信']['pay_mid'] = '881697';
$arr_online_config['月宝微信']['pay_mkey'] = 'd418551b7f5cfc9927a1dd20312f5207';
$arr_online_config['月宝微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['月宝微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['月宝微信']['post_url'] = '/member/pay/yuebao/pany.php?S_Type=WECHAT';
$arr_online_config['月宝微信']['notice_url'] = $arr_online_config['月宝微信']['pay_url'] . 'pay/yuebao/notify.php';
$arr_online_config['月宝微信']['return_url'] = $arr_online_config['月宝微信']['pay_url'] . 'pay/yuebao/success.html';
$arr_online_config['月宝微信']['merchant_url'] = 'http://gateway.yuebaopay.cn/online/gateway';
$arr_online_config['月宝QQ钱包'] = $arr_online_config['月宝微信'];
$arr_online_config['月宝QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['月宝QQ钱包']['post_url'] = '/member/pay/yuebao/pany.php?S_Type=QQPAY';
* /


//W付
$arr_online_config['W付微信']['online_name'] = '微信扫码';
$arr_online_config['W付微信']['pay_mid'] = '500500500011';
$arr_online_config['W付微信']['pay_mkey'] = 'MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAOxH+RvCAyx7zlGPmaxXEdVKVMYrniQtsiO56077izo4u2lqK87Z3QzCWoszVt4RzKzCQGt2A8gPRDmuus99pvs33TyopFQpbKw6CGxZWT5m6gagILcql/U9n+e0HWsmEm2QfTDiy9nICVtHAu+YK1G9YBCeZxAIRAQq/fSsDbwRAgMBAAECgYBxqTW2GqA4N95J8dA0zTWw6q7ZHYZXVPwKn5cISYzyFvRgg0hLmxXw21V+/NVewiU5PcCLcRvkkyN4tAr9YS5/Ydp+7DHdHtvAe9X9pUW435l1K92FYydF7B/QXf7dPb1Cwf5Fm1WwYKXlexY4lJW0Nkdjs/r6jOoTXig4JJyvgQJBAP8gfvY0ntVwHMzPXkOwwitN3RdDQlUyvf48wl8g/7/QPxYasqWO24x8lwevflpfJ15taywQxd8SPQSdvR0P5RkCQQDtFvefGoxhNy2EASjB8XP0pv0KfdqwXI0E15pYxrwDQIE2q2JPAtqt5b9iKhSQ8mfTSEAcUk5zBNqvdz5jmzW5AkEA3/bq/b/b34r3/WPdYJb/HXzRJebJiHlvCIzWJSSW3xA1EXaGdYgffAiznO+WgEcgDGkJuDlROy6Lmk3PAoA9oQJAUtre6IxHmMXGs0YQb06pPkuJTLxUy6NcaN/MAdBZ7i0BuxBDx+bwcytCKdUY4NrF6/Fo7jzZS5rbrcxXUknwiQJAS2znMHDFehfDlus4EE5mKiE7Y5htgO7MDQDS5cf/SlngnkTEK9mpj0g0Y7lhEj5+rcZf1EBld4/jQ/zsDf3NtQ==';
$arr_online_config['W付微信']['pay_pubKey'] = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCSWd5JTMlGWgzD59Vi3FTKVsKtrS+/y3iY9VqF46o9/6mZBQJxC+na8iktlge/upmfevrk77hyP9tx60HU781zMKLTfSGMviwSLQwQrVXtr3r8Plqegg1wMawqSGfwxQCM/XArr/aciksFUoFkMqqcrzWNRfHfSk5OfvxGOHl/lQIDAQAB';
$arr_online_config['W付微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['W付微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['W付微信']['post_url'] = '/member/pay/5wpay/pay.php?S_Type=WECHAT';
$arr_online_config['W付微信']['notice_url'] = $arr_online_config['W付微信']['pay_url'] . 'pay/5wpay/notify.php';
$arr_online_config['W付微信']['return_url'] = $arr_online_config['W付微信']['pay_url'] . 'pay/5wpay/success.html';
$arr_online_config['W付微信']['merchant_url'] = 'https://api.5wpay.net/gateway/api/scanpay';
$arr_online_config['W付支付宝'] = $arr_online_config['W付微信'];
$arr_online_config['W付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['W付支付宝']['post_url'] = '/member/pay/5wpay/pay.php?S_Type=ALIPAY';
$arr_online_config['W付QQ钱包'] = $arr_online_config['W付微信'];
$arr_online_config['W付QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['W付QQ钱包']['post_url'] = '/member/pay/5wpay/pay.php?S_Type=QQPAY';
$arr_online_config['W付微信H5'] = $arr_online_config['W付微信'];
$arr_online_config['W付微信H5']['online_name'] = '微信H5';
$arr_online_config['W付微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['W付微信H5']['post_url'] = '/member/pay/5wpay/pany.php?S_Type=WECHAT';
$arr_online_config['W付微信H5']['merchant_url'] = 'https://api.5wpay.net/gateway/api/h5apipay';
$arr_online_config['W付支付宝H5'] = $arr_online_config['W付微信H5'];
$arr_online_config['W付支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['W付支付宝H5']['post_url'] = '/member/pay/5wpay/pany.php?S_Type=ALIPAY';
$arr_online_config['W付QQ钱包H5'] = $arr_online_config['W付微信H5'];
$arr_online_config['W付QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['W付QQ钱包H5']['post_url'] = '/member/pay/5wpay/pany.php?S_Type=QQPAY';
$arr_online_config['W付网银'] = $arr_online_config['W付微信H5'];
$arr_online_config['W付网银']['online_name'] = '网银支付';
$arr_online_config['W付网银']['merchant_url'] = 'https://pay.5wpay.net/gateway?input_charset=UTF-8';
$arr_online_config['W付网银']['post_url'] = '/member/pay/5wpay/pany.php';


/*
//高通支付
$arr_online_config['高通微信']['online_name'] = '微信扫码';
$arr_online_config['高通微信']['pay_mid'] = '10080';
$arr_online_config['高通微信']['pay_mkey'] = '4abc80f7596b15f43f1224389b64912d';
$arr_online_config['高通微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['高通微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['高通微信']['post_url'] = '/member/pay/gtpay/pay.php?S_Type=WECHAT';
$arr_online_config['高通微信']['notice_url'] = $arr_online_config['高通微信']['pay_url'] . 'pay/gtpay/notify.php';
$arr_online_config['高通微信']['return_url'] = $arr_online_config['高通微信']['pay_url'] . 'pay/gtpay/success.html';
$arr_online_config['高通微信']['merchant_url'] = 'https://wgtj.gaotongpay.com/PayBank.aspx';
$arr_online_config['高通支付宝'] = $arr_online_config['高通微信'];
$arr_online_config['高通支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['高通支付宝']['post_url'] = '/member/pay/gtpay/pay.php?S_Type=ALIPAY';
$arr_online_config['高通QQ钱包'] = $arr_online_config['高通微信'];
$arr_online_config['高通QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['高通QQ钱包']['post_url'] = '/member/pay/gtpay/pay.php?S_Type=QQPAY';
$arr_online_config['高通京东钱包'] = $arr_online_config['高通微信'];
$arr_online_config['高通京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['高通京东钱包']['post_url'] = '/member/pay/gtpay/pay.php?S_Type=JDPAY';
$arr_online_config['高通银联扫码'] = $arr_online_config['高通微信'];
$arr_online_config['高通银联扫码']['online_name'] = '银联扫码';
$arr_online_config['高通银联扫码']['post_url'] = '/member/pay/gtpay/pay.php?S_Type=UNIONPAY';
$arr_online_config['高通网银'] = $arr_online_config['高通微信'];
$arr_online_config['高通网银']['online_name'] = '网银支付';
$arr_online_config['高通网银']['post_url'] = '/member/pay/gtpay/pany2.php';
$arr_online_config['高通微信H5'] = $arr_online_config['高通微信'];
$arr_online_config['高通微信H5']['online_name'] = '微信H5';
$arr_online_config['高通微信H5']['post_url'] = '/member/pay/gtpay/pany.php?S_Type=WECHAT';
$arr_online_config['高通支付宝H5'] = $arr_online_config['高通微信'];
$arr_online_config['高通支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['高通支付宝H5']['post_url'] = '/member/pay/gtpay/pany.php?S_Type=ALIPAY';
$arr_online_config['高通QQ钱包H5'] = $arr_online_config['高通微信'];
$arr_online_config['高通QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['高通QQ钱包H5']['post_url'] = '/member/pay/gtpay/pany.php?S_Type=QQPAY';
$arr_online_config['高通京东钱包H5'] = $arr_online_config['高通微信'];
$arr_online_config['高通京东钱包H5']['online_name'] = '京东钱包H5';
$arr_online_config['高通京东钱包H5']['post_url'] = '/member/pay/gtpay/pany.php?S_Type=JDPAY';
*/

/*
//艾米森
$arr_online_config['艾米森微信']['online_name'] = '微信扫码';
$arr_online_config['艾米森微信']['pay_mid'] = '200070|AM0V121510470417SgqNR';
$arr_online_config['艾米森微信']['pay_mkey'] = '5wkWqC5xon1510470417pc3HbEqSCR6';
$arr_online_config['艾米森微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['艾米森微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['艾米森微信']['post_url'] = '/member/pay/amspay/pay.php?S_Type=WECHAT';
$arr_online_config['艾米森微信']['notice_url'] = $arr_online_config['艾米森微信']['pay_url'] . 'pay/amspay/notify.php';
$arr_online_config['艾米森微信']['return_url'] = $arr_online_config['艾米森微信']['pay_url'] . 'pay/amspay/success.html';
$arr_online_config['艾米森微信']['merchant_url'] = 'http://api.52hrt.com/trade/pay_v2';
$arr_online_config['艾米森支付宝'] = $arr_online_config['艾米森微信'];
$arr_online_config['艾米森支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['艾米森支付宝']['post_url'] = '/member/pay/amspay/pay.php?S_Type=ALIPAY';
$arr_online_config['艾米森QQ钱包'] = $arr_online_config['艾米森微信'];
$arr_online_config['艾米森QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['艾米森QQ钱包']['post_url'] = '/member/pay/amspay/pay.php?S_Type=QQPAY';
$arr_online_config['艾米森微信H5'] = $arr_online_config['艾米森微信'];
$arr_online_config['艾米森微信H5']['online_name'] = '微信H5';
$arr_online_config['艾米森微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['艾米森微信H5']['post_url'] = '/member/pay/amspay/pany.php?S_Type=WECHAT';
$arr_online_config['艾米森支付宝H5'] = $arr_online_config['艾米森微信H5'];
$arr_online_config['艾米森支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['艾米森支付宝H5']['post_url'] = '/member/pay/amspay/pany.php?S_Type=ALIPAY';
$arr_online_config['艾米森网银'] = $arr_online_config['艾米森微信H5'];
$arr_online_config['艾米森网银']['online_name'] = '网银支付';
$arr_online_config['艾米森网银']['post_url'] = '/member/pay/amspay/pany2.php';
* /

//u9pay
$arr_online_config['U9微信']['online_name'] = '微信扫码';
$arr_online_config['U9微信']['pay_mid'] = '10002';
$arr_online_config['U9微信']['pay_mkey'] = 't4ig5acnpx4fet4zapshjacjd9o4bhbi';
$arr_online_config['U9微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['U9微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['U9微信']['post_url'] = '/member/pay/u9pay/pay.php?S_Type=WECHAT';
$arr_online_config['U9微信']['notice_url'] = $arr_online_config['U9微信']['pay_url'] . 'pay/u9pay/notify.php';
$arr_online_config['U9微信']['return_url'] = $arr_online_config['U9微信']['pay_url'] . 'pay/u9pay/success.html';
$arr_online_config['U9微信']['merchant_url'] = 'http://www.u9pay.com/Pay_Index.html';
$arr_online_config['U9支付宝'] = $arr_online_config['U9微信'];
$arr_online_config['U9支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['U9支付宝']['post_url'] = '/member/pay/u9pay/pay.php?S_Type=ALIPAY';
$arr_online_config['U9QQ钱包'] = $arr_online_config['U9微信'];
$arr_online_config['U9QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['U9QQ钱包']['post_url'] = '/member/pay/u9pay/pay.php?S_Type=QQPAY';
$arr_online_config['U9微信H5'] = $arr_online_config['U9微信'];
$arr_online_config['U9微信H5']['online_name'] = '微信H5';
$arr_online_config['U9微信H5']['post_url'] = '/member/pay/u9pay/pany.php?S_Type=WECHAT';
$arr_online_config['U9支付宝H5'] = $arr_online_config['U9微信H5'];
$arr_online_config['U9支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['U9支付宝H5']['post_url'] = '/member/pay/u9pay/pany.php?S_Type=ALIPAY';
$arr_online_config['U9网银'] = $arr_online_config['U9微信H5'];
$arr_online_config['U9网银']['online_name'] = '网银支付';
$arr_online_config['U9网银']['post_url'] = '/member/pay/u9pay/pany.php';

/*
//32pay
$arr_online_config['32微信']['online_name'] = '微信支付';
$arr_online_config['32微信']['pay_mid'] = '1002099';
$arr_online_config['32微信']['pay_mkey'] = '8305b5c0c3654ee7b590dabec4e18378';
$arr_online_config['32微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['32微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['32微信']['post_url'] = '/member/pay/32pay/pany.php?S_Type=WECHAT';
$arr_online_config['32微信']['notice_url'] = $arr_online_config['32微信']['pay_url'] . 'pay/32pay/notify.php';
$arr_online_config['32微信']['return_url'] = $arr_online_config['32微信']['pay_url'] . 'pay/32pay/success.html';
$arr_online_config['32微信']['merchant_url'] = 'https://API.32PAY.COM/pay/KDBank.aspx';
$arr_online_config['32WAP微信'] = $arr_online_config['32微信'];
$arr_online_config['32WAP微信']['online_name'] = 'WAP微信';
$arr_online_config['32WAP微信']['post_url'] = '/member/pay/32pay/pany.php?S_Type=WECHAT2';
$arr_online_config['32QQ'] = $arr_online_config['32微信'];
$arr_online_config['32QQ']['online_name'] = 'QQ扫码支付';
$arr_online_config['32QQ']['post_url'] = '/member/pay/32pay/pany.php?S_Type=QQPAY';
$arr_online_config['32QQ钱包'] = $arr_online_config['32微信'];
$arr_online_config['32QQ钱包']['online_name'] = 'QQ钱包WAP版';
$arr_online_config['32QQ钱包']['post_url'] = '/member/pay/32pay/pany.php?S_Type=QQPAY2';
$arr_online_config['32网银'] = $arr_online_config['32微信'];
$arr_online_config['32网银']['online_name'] = '网银支付';
$arr_online_config['32网银']['post_url'] = '/member/pay/32pay/pany.php';
*/

/*
//轻易付
$arr_online_config['轻易微信']['online_name'] = '微信扫码';
$arr_online_config['轻易微信']['pay_mid'] = 'QYF201710261612';
$arr_online_config['轻易微信']['pay_mkey'] = '82CA291172F15C9723FE29841F583C20';
$arr_online_config['轻易微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['轻易微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['轻易微信']['post_url'] = '/member/pay/qypay/pany.php?S_Type=WECHAT';
$arr_online_config['轻易微信']['notice_url'] = $arr_online_config['轻易微信']['pay_url'] . 'pay/qypay/notify.php';
$arr_online_config['轻易微信']['return_url'] = $arr_online_config['轻易微信']['pay_url'] . 'pay/qypay/success.html';
$arr_online_config['轻易微信']['merchant_url'] = 'http://unionpay.qyfpay.com:90/api/pay.action';
$arr_online_config['轻易网银'] = $arr_online_config['轻易微信'];
$arr_online_config['轻易网银']['online_name'] = '网银支付';
$arr_online_config['轻易网银']['post_url'] = '/member/pay/qypay/pany.php';


//轻易付2
$arr_online_config['轻易2微信']['online_name'] = '微信扫码';
$arr_online_config['轻易2微信']['pay_mid'] = 'QYF201706210300';
$arr_online_config['轻易2微信']['pay_mkey'] = 'DDEB5CE8A37ADDB0AF8BBC7FB02C4A08';
$arr_online_config['轻易2微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['轻易2微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['轻易2微信']['post_url'] = '/member/pay/qy2pay/pany.php?S_Type=WECHAT';
$arr_online_config['轻易2微信']['notice_url'] = $arr_online_config['轻易2微信']['pay_url'] . 'pay/qy2pay/notify.php';
$arr_online_config['轻易2微信']['return_url'] = $arr_online_config['轻易2微信']['pay_url'] . 'pay/qy2pay/success.html';
$arr_online_config['轻易2微信']['merchant_url'] = 'http://wx.qyfpay.com:90/api/pay.action';
$arr_online_config['轻易2京东'] = $arr_online_config['轻易2微信'];
$arr_online_config['轻易2京东']['online_name'] = '京东钱包';
$arr_online_config['轻易2京东']['post_url'] = '/member/pay/qy2pay/pany.php?S_Type=JDPAY';
$arr_online_config['轻易2京东']['merchant_url'] = 'http://jd.qyfpay.com:90/api/pay.action';
$arr_online_config['轻易2百度'] = $arr_online_config['轻易2微信'];
$arr_online_config['轻易2百度']['online_name'] = '百度钱包';
$arr_online_config['轻易2百度']['post_url'] = '/member/pay/qy2pay/pany.php?S_Type=BDPAY';
$arr_online_config['轻易2百度']['merchant_url'] = 'http://baidu.qyfpay.com:90/api/pay.action';
$arr_online_config['轻易2网银'] = $arr_online_config['轻易2微信'];
$arr_online_config['轻易2网银']['online_name'] = '银联钱包';
$arr_online_config['轻易2网银']['post_url'] = '/member/pay/qy2pay/pany.php';
$arr_online_config['轻易2网银']['merchant_url'] = 'http://unionpay.qyfpay.com:90/api/pay.action';
*/

/*
//长城付
$arr_online_config['长城付微信']['online_name'] = '微信扫码';
$arr_online_config['长城付微信']['pay_mid'] = '211530354110068';
$arr_online_config['长城付微信']['pay_mkey'] = '8410B2C66C9D6E3E50C2B3A65FD3CCEB';
$arr_online_config['长城付微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['长城付微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['长城付微信']['post_url'] = '/member/pay/ccpay/pay.php?S_Type=WECHAT';
$arr_online_config['长城付微信']['notice_url'] = $arr_online_config['长城付微信']['pay_url'] . 'pay/ccpay/notify.php';
$arr_online_config['长城付微信']['return_url'] = $arr_online_config['长城付微信']['pay_url'] . 'pay/ccpay/success.html';
$arr_online_config['长城付微信']['merchant_url'] = 'http://a.cc8pay.com/api/passivePay';
$arr_online_config['长城付支付宝'] = $arr_online_config['长城付微信'];
$arr_online_config['长城付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['长城付支付宝']['post_url'] = '/member/pay/ccpay/pay.php?S_Type=ALIPAY';
$arr_online_config['长城付QQ钱包'] = $arr_online_config['长城付微信'];
$arr_online_config['长城付QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['长城付QQ钱包']['post_url'] = '/member/pay/ccpay/pay.php?S_Type=QQPAY';
$arr_online_config['长城付京东钱包'] = $arr_online_config['长城付微信'];
$arr_online_config['长城付京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['长城付京东钱包']['post_url'] = '/member/pay/ccpay/pay.php?S_Type=JDPAY';
$arr_online_config['长城付微信H5'] = $arr_online_config['长城付微信'];
$arr_online_config['长城付微信H5']['online_name'] = '微信H5';
$arr_online_config['长城付微信H5']['post_url'] = '/member/pay/ccpay/pany.php?S_Type=WECHAT';
$arr_online_config['长城付微信H5']['merchant_url'] = 'http://a.cc8pay.com/api/wapPay';
$arr_online_config['长城付支付宝H5'] = $arr_online_config['长城付微信H5'];
$arr_online_config['长城付支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['长城付支付宝H5']['post_url'] = '/member/pay/ccpay/pany.php?S_Type=ALIPAY';
$arr_online_config['长城付QQ钱包H5'] = $arr_online_config['长城付微信H5'];
$arr_online_config['长城付QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['长城付QQ钱包H5']['post_url'] = '/member/pay/ccpay/pany.php?S_Type=QQPAY';


//通扫
$arr_online_config['通扫微信']['online_name'] = '微信扫码';
$arr_online_config['通扫微信']['pay_mid'] = '325120107630001';
$arr_online_config['通扫微信']['pay_mkey'] = 'DB0822D574B8E6B3366D4A3814EF9E2C';
$arr_online_config['通扫微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['通扫微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['通扫微信']['post_url'] = '/member/pay/tspay/pay.php?S_Type=WECHAT';
$arr_online_config['通扫微信']['notice_url'] = $arr_online_config['通扫微信']['pay_url'] . 'pay/tspay/notify.php';
$arr_online_config['通扫微信']['return_url'] = $arr_online_config['通扫微信']['pay_url'] . 'pay/tspay/success.html';
$arr_online_config['通扫微信']['merchant_url'] = 'http://i.kldgz.com/18/passivePay';
$arr_online_config['通扫支付宝'] = $arr_online_config['通扫微信'];
$arr_online_config['通扫支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['通扫支付宝']['post_url'] = '/member/pay/tspay/pay.php?S_Type=ALIPAY';
$arr_online_config['通扫QQ钱包'] = $arr_online_config['通扫微信'];
$arr_online_config['通扫QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['通扫QQ钱包']['post_url'] = '/member/pay/tspay/pay.php?S_Type=QQPAY';
$arr_online_config['通扫京东钱包'] = $arr_online_config['通扫微信'];
$arr_online_config['通扫京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['通扫京东钱包']['post_url'] = '/member/pay/tspay/pay.php?S_Type=JDPAY';
$arr_online_config['通扫微信H5'] = $arr_online_config['通扫微信'];
$arr_online_config['通扫微信H5']['online_name'] = '微信H5';
$arr_online_config['通扫微信H5']['post_url'] = '/member/pay/tspay/pany.php?S_Type=WECHAT';
$arr_online_config['通扫微信H5']['merchant_url'] = 'http://i.kldgz.com/18/wapPay';
$arr_online_config['通扫支付宝H5'] = $arr_online_config['通扫微信H5'];
$arr_online_config['通扫支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['通扫支付宝H5']['post_url'] = '/member/pay/tspay/pany.php?S_Type=ALIPAY';
$arr_online_config['通扫QQ钱包H5'] = $arr_online_config['通扫微信H5'];
$arr_online_config['通扫QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['通扫QQ钱包H5']['post_url'] = '/member/pay/tspay/pany.php?S_Type=QQPAY';
$arr_online_config['通扫京东钱包H5'] = $arr_online_config['通扫微信H5'];
$arr_online_config['通扫京东钱包H5']['online_name'] = '京东钱包H5';
$arr_online_config['通扫京东钱包H5']['post_url'] = '/member/pay/tspay/pany.php?S_Type=JDPAY';


//自由付
$arr_online_config['自由付微信']['online_name'] = '微信扫码';
$arr_online_config['自由付微信']['pay_mid'] = '8000000000010';
$arr_online_config['自由付微信']['pay_mkey'] = '8c22171e03b6884';
$arr_online_config['自由付微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['自由付微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['自由付微信']['post_url'] = '/member/pay/zypay/pay.php?S_Type=WECHAT';
$arr_online_config['自由付微信']['notice_url'] = $arr_online_config['自由付微信']['pay_url'] . 'pay/zypay/notify.php';
$arr_online_config['自由付微信']['return_url'] = $arr_online_config['自由付微信']['pay_url'] . 'pay/zypay/success.html';
$arr_online_config['自由付微信']['merchant_url'] = 'http://m.zypay.net/api/pay/GetQRCode';


//财猫
$arr_online_config['财猫微信']['online_name'] = '微信扫码';
$arr_online_config['财猫微信']['pay_mid'] = '588003002005';
$arr_online_config['财猫微信']['pay_mkey'] = '';
$arr_online_config['财猫微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['财猫微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['财猫微信']['post_url'] = '/member/pay/caimao9/pay.php?S_Type=WECHAT';
$arr_online_config['财猫微信']['notice_url'] = $arr_online_config['财猫微信']['pay_url'] . 'pay/caimao9/notify.php';
$arr_online_config['财猫微信']['return_url'] = $arr_online_config['财猫微信']['pay_url'] . 'pay/caimao9/success.html';
$arr_online_config['财猫微信']['merchant_url'] = 'https://api.caimao9.com/gateway/api/scanpay';
$arr_online_config['财猫支付宝'] = $arr_online_config['财猫微信'];
$arr_online_config['财猫支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['财猫支付宝']['post_url'] = '/member/pay/caimao9/pay.php?S_Type=ALIPAY';
$arr_online_config['财猫QQ钱包'] = $arr_online_config['财猫微信'];
$arr_online_config['财猫QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['财猫QQ钱包']['post_url'] = '/member/pay/caimao9/pay.php?S_Type=QQPAY';
$arr_online_config['财猫京东钱包'] = $arr_online_config['财猫微信'];
$arr_online_config['财猫京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['财猫京东钱包']['post_url'] = '/member/pay/caimao9/pay.php?S_Type=JDPAY';
$arr_online_config['财猫微信H5'] = $arr_online_config['财猫微信'];
$arr_online_config['财猫微信H5']['online_name'] = '微信H5';
$arr_online_config['财猫微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['财猫微信H5']['post_url'] = '/member/pay/caimao9/pany.php?S_Type=WECHAT';
$arr_online_config['财猫微信H5']['merchant_url'] = 'https://api.caimao9.com/gateway/api/h5apipay';
$arr_online_config['财猫支付宝H5'] = $arr_online_config['财猫微信H5'];
$arr_online_config['财猫支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['财猫支付宝H5']['post_url'] = '/member/pay/caimao9/pany.php?S_Type=ALIPAY';
$arr_online_config['财猫QQ钱包H5'] = $arr_online_config['财猫微信H5'];
$arr_online_config['财猫QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['财猫QQ钱包H5']['post_url'] = '/member/pay/caimao9/pany.php?S_Type=QQPAY';
$arr_online_config['财猫网银'] = $arr_online_config['财猫微信H5'];
$arr_online_config['财猫网银']['online_name'] = '网银支付';
$arr_online_config['财猫网银']['post_url'] = '/member/pay/caimao9/pany.php';
$arr_online_config['财猫网银']['merchant_url'] = 'https://pay.caimao9.com/gateway?input_charset=UTF-8';


//皇冠支付
$arr_online_config['皇冠微信']['online_name'] = '微信扫码';
$arr_online_config['皇冠微信']['pay_mid'] = '929000053991024';
$arr_online_config['皇冠微信']['pay_mkey'] = '01ff5e3377750dac62ef00721f597037';
$arr_online_config['皇冠微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['皇冠微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['皇冠微信']['post_url'] = '/member/pay/hgpay/pay.php?S_Type=WECHAT';
$arr_online_config['皇冠微信']['notice_url'] = $arr_online_config['皇冠微信']['pay_url'] . 'pay/hgpay/notify.php';
$arr_online_config['皇冠微信']['return_url'] = $arr_online_config['皇冠微信']['pay_url'] . 'pay/sfbpay/success.html';
$arr_online_config['皇冠微信']['merchant_url'] = 'http://dp.sf532.com/Pay_Index.html';
$arr_online_config['皇冠支付宝'] = $arr_online_config['皇冠微信'];
$arr_online_config['皇冠支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['皇冠支付宝']['post_url'] = '/member/pay/hgpay/pay.php?S_Type=ALIPAY';
$arr_online_config['皇冠QQ钱包'] = $arr_online_config['皇冠微信'];
$arr_online_config['皇冠QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['皇冠QQ钱包']['post_url'] = '/member/pay/hgpay/pay.php?S_Type=QQPAY';
* /

//智通宝
$arr_online_config['智通宝微信']['online_name'] = '微信扫码';
$arr_online_config['智通宝微信']['pay_mid'] = '100100000167';
$arr_online_config['智通宝微信']['pay_mkey'] = 'MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAJiKkqj8PQKsp9D3NU2G496t/5hBDvLZ0F+Gdon8RMyGOEwnlFLbEbMhEwi4EZlGMvjJxDGUNkk2Gp6miCOgs3zJSEJtWAlOUBEGhQVfgoccUq3qvvn2dCsKOgNs+3LZ1CM1eGyyGjQIJJsyv5Jq5UAxSs9zBjrpGlTHysIQB23RAgMBAAECgYB9hLEvmfb+B2JDgdd7hr5kkpqaBxas4Gwk3nkWC930yZDzoTHch+TlmBaYexYIIIp6y1PEVCfjUEDRQUkOwAJQK/wSssukj5AK5FG1JEaWJynd8ZT6nyCcrBNHjUifE8XYtWfa6UOmIeRcf5Ju4n1bg/WTnfcBM7ixDBwdP0yiPQJBAMbC0wkaZUgJLabX9FqhD9tTTL//cNkXtkJe1mQaXHoHLe35eEkssfR9k0Z2LPi6xgV5b4OQ2/yc38SmwE9B/rcCQQDEeE+MWkdUncwHvdhyf6dCIwVNdurYC/qCdmGbVnbDbfmFpJ3/LWrO8crGcVPDXqJdJSjLaQ0WvYL3EV9f32+3AkAm2OM4T0FmX+zdRC4NHJelzVUd3YYn2BuWQ0Tx0bkrXIXckjqxSpwJZhXH2scVYiPb5A0okMJ+UAboP5MsqoBnAkEAj2rDptDAASSvK3eJ6QsGLWEjHckQ5WTZGSMRXTNgvogo/UWNkBi3PxmBzBot6w/JtfTKMrIcu9zbHT+xP2r7QQJAei1aSbT451/gLQ2F9QuZrJeGHKcel7bKUbUSVlDCu3nf3Aolz2eScQ7uvf6qreWGWZb9payRpSa+W6V07c52Dw==';
$arr_online_config['智通宝微信']['pay_pubKey'] = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCUB+p5oWc/zv4/wA5TesV0b1UTrDnjaIKvACctzXneI2jH05qfiKkUfomQwtVH9wlDc2TS/5JPVpLrn/WIE26sbSoeQV5wu9kMDtsT7u3VlVpcqRBdpINZ3bZX65yxH1MUH6Yf++WqM2BX32gyhxFT5tifTxEWvOwXuw4bxnctLwIDAQAB';
$arr_online_config['智通宝微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['智通宝微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['智通宝微信']['post_url'] = '/member/pay/ztbpay/pay.php?S_Type=WECHAT';
$arr_online_config['智通宝微信']['notice_url'] = $arr_online_config['智通宝微信']['pay_url'] . 'pay/ztbpay/notify.php';
$arr_online_config['智通宝微信']['return_url'] = $arr_online_config['智通宝微信']['pay_url'] . 'pay/ztbpay/success.html';
$arr_online_config['智通宝微信']['merchant_url'] = 'https://api.ztbaopay.com/gateway/api/scanpay';
$arr_online_config['智通宝支付宝'] = $arr_online_config['智通宝微信'];
$arr_online_config['智通宝支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['智通宝支付宝']['post_url'] = '/member/pay/ztbpay/pay.php?S_Type=ALIPAY';
$arr_online_config['智通宝QQ钱包'] = $arr_online_config['智通宝微信'];
$arr_online_config['智通宝QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['智通宝QQ钱包']['post_url'] = '/member/pay/ztbpay/pay.php?S_Type=QQPAY';
$arr_online_config['智通宝京东钱包'] = $arr_online_config['智通宝微信'];
$arr_online_config['智通宝京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['智通宝京东钱包']['post_url'] = '/member/pay/ztbpay/pay.php?S_Type=JDPAY';
$arr_online_config['智通宝微信H5'] = $arr_online_config['智通宝微信'];
$arr_online_config['智通宝微信H5']['online_name'] = '微信H5';
$arr_online_config['智通宝微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['智通宝微信H5']['post_url'] = '/member/pay/ztbpay/pany.php?S_Type=WECHAT';
$arr_online_config['智通宝微信H5']['merchant_url'] = 'https://api.ztbaopay.com/gateway/api/h5apipay';
$arr_online_config['智通宝支付宝H5'] = $arr_online_config['智通宝微信H5'];
$arr_online_config['智通宝支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['智通宝支付宝H5']['post_url'] = '/member/pay/ztbpay/pany.php?S_Type=ALIPAY';
$arr_online_config['智通宝QQ钱包H5'] = $arr_online_config['智通宝微信H5'];
$arr_online_config['智通宝QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['智通宝QQ钱包H5']['post_url'] = '/member/pay/ztbpay/pany.php?S_Type=QQPAY';
$arr_online_config['智通宝京东钱包H5'] = $arr_online_config['智通宝微信H5'];
$arr_online_config['智通宝京东钱包H5']['online_name'] = '京东钱包H5';
$arr_online_config['智通宝京东钱包H5']['post_url'] = '/member/pay/ztbpay/pany.php?S_Type=JDPAY';
$arr_online_config['智通宝网银'] = $arr_online_config['智通宝微信H5'];
$arr_online_config['智通宝网银']['online_name'] = '网银支付';
$arr_online_config['智通宝网银']['merchant_url'] = 'https://pay.ztbaopay.com/gateway?input_charset=UTF-8';
$arr_online_config['智通宝网银']['post_url'] = '/member/pay/ztbpay/pany.php';


//仙芸妮
$arr_online_config['仙芸妮微信']['online_name'] = '微信扫码';
$arr_online_config['仙芸妮微信']['pay_mid'] = '710278863703040000';
$arr_online_config['仙芸妮微信']['pay_mkey'] = '5b17a48fbfff49228823d7f39e3b121c';
$arr_online_config['仙芸妮微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['仙芸妮微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['仙芸妮微信']['post_url'] = '/member/pay/xyn/pay.php?S_Type=ALIPAY';
$arr_online_config['仙芸妮微信']['notice_url'] = $arr_online_config['仙芸妮微信']['pay_url'] . 'pay/xyn/notify.php';
$arr_online_config['仙芸妮微信']['return_url'] = $arr_online_config['仙芸妮微信']['pay_url'] . 'pay/xyn/success.html';
$arr_online_config['仙芸妮微信']['merchant_url'] = 'http://payment.shopping98.com/scan/pay/gateway';


//仁信支付
$arr_online_config['仁信微信']['online_name'] = '微信扫码';
$arr_online_config['仁信微信']['pay_mid'] = '20126';
$arr_online_config['仁信微信']['pay_mkey'] = '425a6c9fd1f136de1a3caf14ccd4de7f';
$arr_online_config['仁信微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['仁信微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['仁信微信']['post_url'] = '/member/pay/rxpay/pay.php?S_Type=WECHAT';
$arr_online_config['仁信微信']['notice_url'] = $arr_online_config['仁信微信']['pay_url'] . 'pay/rxpay/notify.php';
$arr_online_config['仁信微信']['return_url'] = $arr_online_config['仁信微信']['pay_url'] . 'pay/rxpay/success.html';
$arr_online_config['仁信微信']['merchant_url'] = 'http://dpos.rxpay88.com/online/gateway';
$arr_online_config['仁信支付宝'] = $arr_online_config['仁信微信'];
$arr_online_config['仁信支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['仁信支付宝']['post_url'] = '/member/pay/rxpay/pay.php?S_Type=ALIPAY';
$arr_online_config['仁信QQ钱包'] = $arr_online_config['仁信微信'];
$arr_online_config['仁信QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['仁信QQ钱包']['post_url'] = '/member/pay/rxpay/pay.php?S_Type=QQPAY';
$arr_online_config['仁信京东钱包'] = $arr_online_config['仁信微信'];
$arr_online_config['仁信京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['仁信京东钱包']['post_url'] = '/member/pay/rxpay/pay.php?S_Type=JDPAY';
$arr_online_config['仁信微信H5'] = $arr_online_config['仁信微信'];
$arr_online_config['仁信微信H5']['online_name'] = '微信H5';
$arr_online_config['仁信微信H5']['post_url'] = '/member/pay/rxpay/pany.php?S_Type=WECHAT';
$arr_online_config['仁信支付宝H5'] = $arr_online_config['仁信微信H5'];
$arr_online_config['仁信支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['仁信支付宝H5']['post_url'] = '/member/pay/rxpay/pany.php?S_Type=ALIPAY';
$arr_online_config['仁信QQ钱包H5'] = $arr_online_config['仁信微信H5'];
$arr_online_config['仁信QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['仁信QQ钱包H5']['post_url'] = '/member/pay/rxpay/pany.php?S_Type=QQPAY';
$arr_online_config['仁信网银'] = $arr_online_config['仁信微信H5'];
$arr_online_config['仁信网银']['online_name'] = '网银支付';
$arr_online_config['仁信网银']['post_url'] = '/member/pay/rxpay/pany.php';


//如意
$arr_online_config['如意微信']['online_name'] = '微信扫码';
$arr_online_config['如意微信']['pay_mid'] = '1002615';
$arr_online_config['如意微信']['pay_mkey'] = 'ccd03550787c42fcb1e170739db4687a';
$arr_online_config['如意微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['如意微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['如意微信']['post_url'] = '/member/pay/rypay/pay.php?S_Type=WECHAT';
$arr_online_config['如意微信']['notice_url'] = $arr_online_config['如意微信']['pay_url'] . 'pay/rypay/notify.php';
$arr_online_config['如意微信']['return_url'] = $arr_online_config['如意微信']['pay_url'] . 'pay/rypay/success.html';
$arr_online_config['如意微信']['merchant_url'] = 'https://gateway.ruyipay.com/Pay/KDBank.aspx';
$arr_online_config['如意支付宝'] = $arr_online_config['如意微信'];
$arr_online_config['如意支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['如意支付宝']['post_url'] = '/member/pay/rypay/pay.php?S_Type=ALIPAY';
$arr_online_config['如意QQ钱包'] = $arr_online_config['如意微信'];
$arr_online_config['如意QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['如意QQ钱包']['post_url'] = '/member/pay/rypay/pay.php?S_Type=QQPAY';
$arr_online_config['如意京东钱包'] = $arr_online_config['如意微信'];
$arr_online_config['如意京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['如意京东钱包']['post_url'] = '/member/pay/rypay/pay.php?S_Type=JDPAY';
$arr_online_config['如意银联扫码'] = $arr_online_config['如意微信'];
$arr_online_config['如意银联扫码']['online_name'] = '银联扫码';
$arr_online_config['如意银联扫码']['post_url'] = '/member/pay/rypay/pay.php?S_Type=UNIONPAY';
$arr_online_config['如意微信H5'] = $arr_online_config['如意微信'];
$arr_online_config['如意微信H5']['online_name'] = '微信H5';
$arr_online_config['如意微信H5']['post_url'] = '/member/pay/rypay/pany.php?S_Type=WECHAT';
$arr_online_config['如意支付宝H5'] = $arr_online_config['如意微信'];
$arr_online_config['如意支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['如意支付宝H5']['post_url'] = '/member/pay/rypay/pany.php?S_Type=ALIPAY';
$arr_online_config['如意QQ钱包H5'] = $arr_online_config['如意微信'];
$arr_online_config['如意QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['如意QQ钱包H5']['post_url'] = '/member/pay/rypay/pany.php?S_Type=QQPAY';
$arr_online_config['如意网银'] = $arr_online_config['如意微信'];
$arr_online_config['如意网银']['online_name'] = '网银支付';
$arr_online_config['如意网银']['post_url'] = '/member/pay/rypay/pany2.php';


//财运
$arr_online_config['财运微信']['online_name'] = '微信扫码';
$arr_online_config['财运微信']['pay_mid'] = '988000000015';
$arr_online_config['财运微信']['pay_mkey'] = '';
$arr_online_config['财运微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['财运微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['财运微信']['post_url'] = '/member/pay/caiyun988/pay.php?S_Type=WECHAT';
$arr_online_config['财运微信']['notice_url'] = $arr_online_config['财运微信']['pay_url'] . 'pay/caiyun988/notify.php';
$arr_online_config['财运微信']['return_url'] = $arr_online_config['财运微信']['pay_url'] . 'pay/caiyun988/success.html';
$arr_online_config['财运微信']['merchant_url'] = 'https://api.caiyun988.com/gateway/api/scanpay';
$arr_online_config['财运支付宝'] = $arr_online_config['财运微信'];
$arr_online_config['财运支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['财运支付宝']['post_url'] = '/member/pay/caiyun988/pay.php?S_Type=ALIPAY';
$arr_online_config['财运QQ钱包'] = $arr_online_config['财运微信'];
$arr_online_config['财运QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['财运QQ钱包']['post_url'] = '/member/pay/caiyun988/pay.php?S_Type=QQPAY';
$arr_online_config['财运京东钱包'] = $arr_online_config['财运微信'];
$arr_online_config['财运京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['财运京东钱包']['post_url'] = '/member/pay/caiyun988/pay.php?S_Type=JDPAY';
$arr_online_config['财运微信H5'] = $arr_online_config['财运微信'];
$arr_online_config['财运微信H5']['online_name'] = '微信H5';
$arr_online_config['财运微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['财运微信H5']['post_url'] = '/member/pay/caiyun988/pany.php?S_Type=WECHAT';
$arr_online_config['财运微信H5']['merchant_url'] = 'https://api.caiyun988.com/gateway/api/h5apipay';
$arr_online_config['财运支付宝H5'] = $arr_online_config['财运微信H5'];
$arr_online_config['财运支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['财运支付宝H5']['post_url'] = '/member/pay/caiyun988/pany.php?S_Type=ALIPAY';
$arr_online_config['财运QQ钱包H5'] = $arr_online_config['财运微信H5'];
$arr_online_config['财运QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['财运QQ钱包H5']['post_url'] = '/member/pay/caiyun988/pany.php?S_Type=QQPAY';
$arr_online_config['财运网银'] = $arr_online_config['财运微信H5'];
$arr_online_config['财运网银']['online_name'] = '网银支付';
$arr_online_config['财运网银']['post_url'] = '/member/pay/caiyun988/pany.php';
$arr_online_config['财运网银']['merchant_url'] = 'https://pay.caiyun988.com/gateway?input_charset=UTF-8';


//智得宝
$arr_online_config['智得宝微信']['online_name'] = '微信扫码';
$arr_online_config['智得宝微信']['pay_mid'] = '9000800171';
$arr_online_config['智得宝微信']['pay_mkey'] = '';
$arr_online_config['智得宝微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['智得宝微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['智得宝微信']['post_url'] = '/member/pay/zdbbill/pay.php?S_Type=WECHAT';
$arr_online_config['智得宝微信']['notice_url'] = $arr_online_config['智得宝微信']['pay_url'] . 'pay/zdbbill/notify.php';
$arr_online_config['智得宝微信']['return_url'] = $arr_online_config['智得宝微信']['pay_url'] . 'pay/zdbbill/success.html';
$arr_online_config['智得宝微信']['merchant_url'] = 'https://api.zdbbill.com/gateway/api/scanpay';
$arr_online_config['智得宝支付宝'] = $arr_online_config['智得宝微信'];
$arr_online_config['智得宝支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['智得宝支付宝']['post_url'] = '/member/pay/zdbbill/pay.php?S_Type=ALIPAY';
$arr_online_config['智得宝QQ钱包'] = $arr_online_config['智得宝微信'];
$arr_online_config['智得宝QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['智得宝QQ钱包']['post_url'] = '/member/pay/zdbbill/pay.php?S_Type=QQPAY';
$arr_online_config['智得宝京东钱包'] = $arr_online_config['智得宝微信'];
$arr_online_config['智得宝京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['智得宝京东钱包']['post_url'] = '/member/pay/zdbbill/pay.php?S_Type=JDPAY';
$arr_online_config['智得宝微信H5'] = $arr_online_config['智得宝微信'];
$arr_online_config['智得宝微信H5']['online_name'] = '微信H5';
$arr_online_config['智得宝微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['智得宝微信H5']['post_url'] = '/member/pay/zdbbill/pany.php?S_Type=WECHAT';
$arr_online_config['智得宝微信H5']['merchant_url'] = 'https://api.zdbbill.com/gateway/api/h5apipay';
$arr_online_config['智得宝支付宝H5'] = $arr_online_config['智得宝微信H5'];
$arr_online_config['智得宝支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['智得宝支付宝H5']['post_url'] = '/member/pay/zdbbill/pany.php?S_Type=ALIPAY';
$arr_online_config['智得宝QQ钱包H5'] = $arr_online_config['智得宝微信H5'];
$arr_online_config['智得宝QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['智得宝QQ钱包H5']['post_url'] = '/member/pay/zdbbill/pany.php?S_Type=QQPAY';
$arr_online_config['智得宝网银'] = $arr_online_config['智得宝微信H5'];
$arr_online_config['智得宝网银']['online_name'] = '网银支付';
$arr_online_config['智得宝网银']['post_url'] = '/member/pay/zdbbill/pany.php';
$arr_online_config['智得宝网银']['merchant_url'] = 'https://pay.zdbbill.com/gateway?input_charset=UTF-8';


//小熊支付
$arr_online_config['小熊微信']['online_name'] = '微信扫码';
$arr_online_config['小熊微信']['pay_mid'] = '2';
$arr_online_config['小熊微信']['pay_mkey'] = '66987BFECB7B42FD3E98FB1CE91D2299';
$arr_online_config['小熊微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['小熊微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['小熊微信']['post_url'] = '/member/pay/bearpay/pay.php?S_Type=WECHAT';
$arr_online_config['小熊微信']['notice_url'] = $arr_online_config['小熊微信']['pay_url'] . 'pay/bearpay/notify.php';
$arr_online_config['小熊微信']['return_url'] = $arr_online_config['小熊微信']['pay_url'] . 'pay/bearpay/success.html';
$arr_online_config['小熊微信']['merchant_url'] = 'http://pay.crossex.cn/bear-pay/pay';
$arr_online_config['小熊支付宝'] = $arr_online_config['小熊微信'];
$arr_online_config['小熊支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['小熊支付宝']['post_url'] = '/member/pay/bearpay/pay.php?S_Type=ALIPAY';


//黄金支付
$arr_online_config['黄金微信']['online_name'] = '微信扫码';
$arr_online_config['黄金微信']['pay_mid'] = '800300';
$arr_online_config['黄金微信']['pay_mkey'] = 'zyXDdrpFCE2n4xkAvNtul56W73wTYfZM';
$arr_online_config['黄金微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['黄金微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['黄金微信']['post_url'] = '/member/pay/goldpayment/pay.php?S_Type=WECHAT';
$arr_online_config['黄金微信']['notice_url'] = $arr_online_config['黄金微信']['pay_url'] . 'pay/goldpayment/notify.php';
$arr_online_config['黄金微信']['return_url'] = $arr_online_config['黄金微信']['pay_url'] . 'pay/goldpayment/success.html';
$arr_online_config['黄金微信']['merchant_url'] = 'https://api.goldpayment.net/pay/';
$arr_online_config['黄金支付宝'] = $arr_online_config['黄金微信'];
$arr_online_config['黄金支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['黄金支付宝']['post_url'] = '/member/pay/goldpayment/pay.php?S_Type=ALIPAY';
$arr_online_config['黄金QQ钱包'] = $arr_online_config['黄金微信'];
$arr_online_config['黄金QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['黄金QQ钱包']['post_url'] = '/member/pay/goldpayment/pay.php?S_Type=QQPAY';
$arr_online_config['黄金微信H5'] = $arr_online_config['黄金微信'];
$arr_online_config['黄金微信H5']['online_name'] = '微信H5';
$arr_online_config['黄金微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['黄金微信H5']['post_url'] = '/member/pay/goldpayment/pany.php?S_Type=WECHAT';
$arr_online_config['黄金支付宝H5'] = $arr_online_config['黄金微信H5'];
$arr_online_config['黄金支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['黄金支付宝H5']['post_url'] = '/member/pay/goldpayment/pany.php?S_Type=ALIPAY';
$arr_online_config['黄金QQ钱包H5'] = $arr_online_config['黄金微信H5'];
$arr_online_config['黄金QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['黄金QQ钱包H5']['post_url'] = '/member/pay/goldpayment/pany.php?S_Type=QQPAY';
$arr_online_config['黄金网银'] = $arr_online_config['黄金微信H5'];
$arr_online_config['黄金网银']['online_name'] = '网银支付';
$arr_online_config['黄金网银']['post_url'] = '/member/pay/goldpayment/pany.php';


//微付
$arr_online_config['微付微信']['online_name'] = '微信扫码';
$arr_online_config['微付微信']['pay_mid'] = '108010777129';
$arr_online_config['微付微信']['pay_mkey'] = 'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALp5Bi2T2CGQI9cCy2AnP4YArVsy+XRQXVRJazpnt/hKPxE5u9qJKHNsV/I31FGiuD3OE9JTkIB/VYJHRzxxUD8SWi1RdBfx3TNkiQ9A4D8x4iZehJbV1ExZgBrtPBPIpGAYS0m89lLW8buA7yS8HMY5sgvNCgUmnoFo9aPOUxFfAgMBAAECgYEAqNrIhmMXVqUgXyWvph1EP4LDeA77pqDTMmzdRWEATTxmSaHfArAqygI0zShTAa14arb+afmzozgq5TLIRepR/468PFMo5CUGs7zSwupITKvWLYV4fdwrKArEeXX2yCHMrGIIignIgZ7bk8xTb3rPvAP5qVkP/YWqGCF/N3/iHMkCQQDnF1GV/CAdA/BvrK9JT8bpKwkljkRSnCK8mAXGpr08Vfx1tnZxnlfd1EwOF9mCD/vtD5wENSH9XvJcZFukcBYTAkEAzpKEFE8+saP0APndZv8VXVpbsQo4YrcTpK2ANBATuJv+MI93pamtSPmIjhpaITXd2KOR3Uga9gl4LecZjZMxBQJAbfusKbz4L7cLPKssNbERUzHXRZeDLun+olGcFiKPV+L4p7Fyh7q7yOjcVazGKV+gIABY2avMBIGmyZA+CXILHwJABlaynNjtqI/KXflM1OtA4ZNzOtSAdG7/uE7mnzJbGJAY1a6hUkEJozKdARdH6rr3ar1iLXMX+LLDsEzmGNUKbQJBAJrlBueTk6xNFA/+ToO4Xcj0E3Bx1ampmJNI5QRqnJS/YGJWvCXLJ0d98/oiCKJ34Dsnq00cj/5JUbUCb0woW1I=';
$arr_online_config['微付微信']['pay_pubKey'] = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCfeI59KHJYEwgKfQ2CuoRMtp3Hjyi/HExKAfD6tKNAEAN0cIIY3Fc/ZKnV10JavOUibkHi5BDGH0L5/oWZf925Iwl/ixVVzcUFJEvGtNMVltuszFx4v8DAXtp/7qP91wcXDkYNSzZt0TytXQNwvI8kb85IJcIOyp6aoek6iveVDwIDAQAB';
$arr_online_config['微付微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['微付微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['微付微信']['post_url'] = '/member/pay/wepay/pay.php?S_Type=WECHAT';
$arr_online_config['微付微信']['notice_url'] = $arr_online_config['微付微信']['pay_url'] . 'pay/wepay/notify.php';
$arr_online_config['微付微信']['return_url'] = $arr_online_config['微付微信']['pay_url'] . 'pay/wepay/success.html';
$arr_online_config['微付微信']['merchant_url'] = 'https://api.wefupay.com/gateway/api/scanpay';
$arr_online_config['微付支付宝'] = $arr_online_config['微付微信'];
$arr_online_config['微付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['微付支付宝']['post_url'] = '/member/pay/wepay/pay.php?S_Type=ALIPAY';
$arr_online_config['微付QQ钱包'] = $arr_online_config['微付微信'];
$arr_online_config['微付QQ钱包']['online_name'] = 'QQ钱包';
$arr_online_config['微付QQ钱包']['post_url'] = '/member/pay/wepay/pay.php?S_Type=QQPAY';
$arr_online_config['微付京东钱包'] = $arr_online_config['微付微信'];
$arr_online_config['微付京东钱包']['online_name'] = '京东钱包';
$arr_online_config['微付京东钱包']['post_url'] = '/member/pay/wepay/pay.php?S_Type=JDPAY';
$arr_online_config['微付微信H5'] = $arr_online_config['微付微信'];
$arr_online_config['微付微信H5']['online_name'] = '微信H5';
$arr_online_config['微付微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['微付微信H5']['post_url'] = '/member/pay/wepay/pany.php?S_Type=WECHAT';
$arr_online_config['微付微信H5']['merchant_url'] = 'https://api.wefupay.com/gateway/api/h5apipay';
$arr_online_config['微付支付宝H5'] = $arr_online_config['微付微信H5'];
$arr_online_config['微付支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['微付支付宝H5']['post_url'] = '/member/pay/wepay/pany.php?S_Type=ALIPAY';
$arr_online_config['微付QQ钱包H5'] = $arr_online_config['微付微信H5'];
$arr_online_config['微付QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['微付QQ钱包H5']['post_url'] = '/member/pay/wepay/pany.php?S_Type=QQPAY';
$arr_online_config['微付京东钱包H5'] = $arr_online_config['微付微信H5'];
$arr_online_config['微付京东钱包H5']['online_name'] = '京东钱包H5';
$arr_online_config['微付京东钱包H5']['post_url'] = '/member/pay/wepay/pany.php?S_Type=JDPAY';
$arr_online_config['微付网银'] = $arr_online_config['微付微信H5'];
$arr_online_config['微付网银']['online_name'] = '网银支付';
$arr_online_config['微付网银']['post_url'] = '/member/pay/wepay/pany.php';
$arr_online_config['微付网银']['merchant_url'] = 'https://pay.wefupay.com/gateway?input_charset=UTF-8';


//优付
$arr_online_config['优付微信']['online_name'] = '微信扫码';
$arr_online_config['优付微信']['pay_mid'] = '10170';
$arr_online_config['优付微信']['pay_mkey'] = 'l081mq5t0jvanmf2zi6pv43he1wc3m5b';
$arr_online_config['优付微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['优付微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['优付微信']['post_url'] = '/member/pay/yozpay/pay.php?S_Type=WECHAT';
$arr_online_config['优付微信']['notice_url'] = $arr_online_config['优付微信']['pay_url'] . 'pay/yozpay/notify.php';
$arr_online_config['优付微信']['return_url'] = $arr_online_config['优付微信']['pay_url'] . 'pay/yozpay/success.html';
$arr_online_config['优付微信']['merchant_url'] = 'http://www.yozpay.com/Pay_Index.html';
$arr_online_config['优付支付宝'] = $arr_online_config['优付微信'];
$arr_online_config['优付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['优付支付宝']['post_url'] = '/member/pay/yozpay/pay.php?S_Type=ALIPAY';
$arr_online_config['优付QQ钱包'] = $arr_online_config['优付微信'];
$arr_online_config['优付QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['优付QQ钱包']['post_url'] = '/member/pay/yozpay/pay.php?S_Type=QQPAY';
$arr_online_config['优付京东钱包'] = $arr_online_config['优付微信'];
$arr_online_config['优付京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['优付京东钱包']['post_url'] = '/member/pay/yozpay/pay.php?S_Type=JDPAY';
$arr_online_config['优付微信H5'] = $arr_online_config['优付微信'];
$arr_online_config['优付微信H5']['online_name'] = '微信H5';
$arr_online_config['优付微信H5']['post_url'] = '/member/pay/yozpay/pany.php?S_Type=WECHAT';
$arr_online_config['优付支付宝H5'] = $arr_online_config['优付微信H5'];
$arr_online_config['优付支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['优付支付宝H5']['post_url'] = '/member/pay/yozpay/pany.php?S_Type=ALIPAY';
$arr_online_config['优付QQ钱包H5'] = $arr_online_config['优付微信H5'];
$arr_online_config['优付QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['优付QQ钱包H5']['post_url'] = '/member/pay/yozpay/pany.php?S_Type=QQPAY';
$arr_online_config['优付京东钱包H5'] = $arr_online_config['优付微信H5'];
$arr_online_config['优付京东钱包H5']['online_name'] = '京东钱包H5';
$arr_online_config['优付京东钱包H5']['post_url'] = '/member/pay/yozpay/pany.php?S_Type=JDPAY';
$arr_online_config['优付网银'] = $arr_online_config['优付微信H5'];
$arr_online_config['优付网银']['online_name'] = '网银支付';
$arr_online_config['优付网银']['post_url'] = '/member/pay/yozpay/pany.php';


//讯宝
$arr_online_config['讯宝微信']['online_name'] = '微信扫码';
$arr_online_config['讯宝微信']['pay_mid'] = '2126';
$arr_online_config['讯宝微信']['pay_mkey'] = 'cc2739033eaa4a58a121b84bacbfd10c';
$arr_online_config['讯宝微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['讯宝微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['讯宝微信']['post_url'] = '/member/pay/xunbaopay9/pay.php?S_Type=WECHAT';
$arr_online_config['讯宝微信']['notice_url'] = $arr_online_config['讯宝微信']['pay_url'] . 'pay/xunbaopay9/notify.php';
$arr_online_config['讯宝微信']['return_url'] = $arr_online_config['讯宝微信']['pay_url'] . 'pay/xunbaopay9/success.html';
$arr_online_config['讯宝微信']['merchant_url'] = 'http://gateway.xunbaopay9.com/chargebank.aspx';
$arr_online_config['讯宝支付宝'] = $arr_online_config['讯宝微信'];
$arr_online_config['讯宝支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['讯宝支付宝']['post_url'] = '/member/pay/xunbaopay9/pay.php?S_Type=ALIPAY';
$arr_online_config['讯宝QQ钱包'] = $arr_online_config['讯宝微信'];
$arr_online_config['讯宝QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['讯宝QQ钱包']['post_url'] = '/member/pay/xunbaopay9/pay.php?S_Type=QQPAY';
$arr_online_config['讯宝微信H5'] = $arr_online_config['讯宝微信'];
$arr_online_config['讯宝微信H5']['online_name'] = '微信H5';
$arr_online_config['讯宝微信H5']['post_url'] = '/member/pay/xunbaopay9/pany.php?S_Type=WECHAT';
$arr_online_config['讯宝支付宝H5'] = $arr_online_config['讯宝微信H5'];
$arr_online_config['讯宝支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['讯宝支付宝H5']['post_url'] = '/member/pay/xunbaopay9/pany.php?S_Type=ALIPAY';
$arr_online_config['讯宝QQ钱包H5'] = $arr_online_config['讯宝微信H5'];
$arr_online_config['讯宝QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['讯宝QQ钱包H5']['post_url'] = '/member/pay/xunbaopay9/pany.php?S_Type=QQPAY';
$arr_online_config['讯宝网银'] = $arr_online_config['讯宝微信H5'];
$arr_online_config['讯宝网银']['online_name'] = '网银支付';
$arr_online_config['讯宝网银']['post_url'] = '/member/pay/xunbaopay9/pany2.php';


//大伯付
$arr_online_config['大伯付微信']['online_name'] = '微信扫码';
$arr_online_config['大伯付微信']['pay_mid'] = 'MER1708898';
$arr_online_config['大伯付微信']['pay_mkey'] = 'E6XGehWDrdg3DEoYnHcFGatNm6ggIX9C';
$arr_online_config['大伯付微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['大伯付微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['大伯付微信']['post_url'] = '/member/pay/dabofu/pay.php?S_Type=WECHAT';
$arr_online_config['大伯付微信']['notice_url'] = $arr_online_config['大伯付微信']['pay_url'] . 'pay/dabofu/notify.php';
$arr_online_config['大伯付微信']['return_url'] = $arr_online_config['大伯付微信']['pay_url'] . 'pay/dabofu/success.html';
$arr_online_config['大伯付微信']['merchant_url'] = 'https://api.dabofu.ml';


//先疯
$arr_online_config['先疯微信']['online_name'] = '微信扫码';
$arr_online_config['先疯微信']['pay_mid'] = 'XF30302198';
$arr_online_config['先疯微信']['pay_mkey'] = '33a154eb2ff70f478b94561d9847f83dcbcf20af';
$arr_online_config['先疯微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['先疯微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['先疯微信']['post_url'] = '/member/pay/xfengpay/pay.php?S_Type=WECHAT';
$arr_online_config['先疯微信']['notice_url'] = $arr_online_config['先疯微信']['pay_url'] . 'pay/xfengpay/notify.php';
$arr_online_config['先疯微信']['return_url'] = $arr_online_config['先疯微信']['pay_url'] . 'pay/xfengpay/success.html';
$arr_online_config['先疯微信']['merchant_url'] = 'http://pay.xfengpay.com/Business/pay?method=';
$arr_online_config['先疯支付宝'] = $arr_online_config['先疯微信'];
$arr_online_config['先疯支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['先疯支付宝']['post_url'] = '/member/pay/xfengpay/pay.php?S_Type=ALIPAY';
$arr_online_config['先疯QQ钱包'] = $arr_online_config['先疯微信'];
$arr_online_config['先疯QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['先疯QQ钱包']['post_url'] = '/member/pay/xfengpay/pay.php?S_Type=QQPAY';
$arr_online_config['先疯微信H5'] = $arr_online_config['先疯微信'];
$arr_online_config['先疯微信H5']['online_name'] = '微信H5';
$arr_online_config['先疯微信H5']['post_url'] = '/member/pay/xfengpay/pany.php?S_Type=WECHAT';
$arr_online_config['先疯支付宝H5'] = $arr_online_config['先疯微信'];
$arr_online_config['先疯支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['先疯支付宝H5']['post_url'] = '/member/pay/xfengpay/pany.php?S_Type=ALIPAY';
$arr_online_config['先疯网银'] = $arr_online_config['先疯微信'];
$arr_online_config['先疯网银']['online_name'] = '网银支付';
$arr_online_config['先疯网银']['post_url'] = '/member/pay/xfengpay/pany.php';


//多得宝
$arr_online_config['多得宝微信']['online_name'] = '微信扫码';
$arr_online_config['多得宝微信']['pay_mid'] = '1000600939';
$arr_online_config['多得宝微信']['pay_mkey'] = 'MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAO/bYaQH/Szmx1+EkSO904rydl3t2PS3j3DOM23ZJoR8GYJxNZuBQN+hDwhTkUzmwuEqHHQJegHPF2OxHbMb8u1PivzSgktMM991FEdtfW/NQ14IU0EOgUmn/SsQbJGMDE0NS73HDL/PrO9TVhz7ixrFypqEPOQiYTDRB0LRTRGTAgMBAAECgYEAiivNlomHnesfpPWgCn/ases0pq1SUr6/YdNXKwtxtdYrd8oxgHA359tG5pwFUtCIKN9yXqHq58ndhm9MVZZfHJo0VgX92cHUD0ScUMDeGCkpEdyvVkRah7dGfrVGvfxMPR4OmO4Kdq2GKy8dZcOp0y5LBnGAsz2/7xfd7N6ydUECQQD7dtsHilIX2NahKScwjSzli06l8umsS9e5sbQdv5Rn/PUdQS7tPC+ewh9KeAwY08WyaCnmwBl+UxJLXqeQwMChAkEA9C7tu8e+E7vdhvABdwnYdp5VSJ1BMRiQjEnrMCDOHWt+TVXFpKLVqx+9W6pQl4g4NWOyN4yIJOQzXjUFTS3BswJBAOqELkEZ/vW+hGxItQPSpcxt3ytlIAhPsyC7Wf9kbEOO5goigGE/gCnPYN9SlfWRiw6XlnxdK2lkj+s6m4ukOAECQQDxVyi0/hiJ3JZ49eIcy2hc5OUZ3gM/CS5k2fJQITxWq5WrzeiIbkCM39QCM3VwL7yOWDke2hD9lWaH6BOTUnQtAkAHGNptSkKejlkk9CVmiPDP4YvqGiOHQFF8Wf+atuvM/nhr5t6SsabU/yY7D99LVURjWMKRqsd6HCSGwLczklb3';
$arr_online_config['多得宝微信']['pay_pubKey'] = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC2vCA+llZgikMowrnT2q5QuCHuYEw6qL4QN151cIOclTtdTDqDtp/HcM0rLxh1HvwIilUetoutTco4oUE6cm33UUqwVpFETEIhK0ugsdlvp6gCKLM5Vjj8tjE+Me8zVEzxkOrZ6u66fE+QkYXFEq/FFygIo0YrQNe6FtFGs+1FtwIDAQAB';
$arr_online_config['多得宝微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['多得宝微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['多得宝微信']['post_url'] = '/member/pay/ddbill/scanPay.php?S_Type=WECHAT';
$arr_online_config['多得宝微信']['notice_url'] = $arr_online_config['多得宝微信']['pay_url'] . 'pay/ddbill/notify.php';
$arr_online_config['多得宝微信']['return_url'] = $arr_online_config['多得宝微信']['pay_url'] . 'pay/ddbill/success.html';
$arr_online_config['多得宝微信']['merchant_url'] = 'https://api.ddbill.com/gateway/api/scanpay';
$arr_online_config['多得宝支付宝'] = $arr_online_config['多得宝微信'];
$arr_online_config['多得宝支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['多得宝支付宝']['post_url'] = '/member/pay/ddbill/scanPay.php?S_Type=ALIPAY';
$arr_online_config['多得宝QQ钱包'] = $arr_online_config['多得宝微信'];
$arr_online_config['多得宝QQ钱包']['online_name'] = 'QQ钱包';
$arr_online_config['多得宝QQ钱包']['post_url'] = '/member/pay/ddbill/scanPay.php?S_Type=QQPAY';
$arr_online_config['多得宝微信H5'] = $arr_online_config['多得宝微信'];
$arr_online_config['多得宝微信H5']['online_name'] = '微信H5';
$arr_online_config['多得宝微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['多得宝微信H5']['post_url'] = '/member/pay/ddbill/h5Pay.php?S_Type=WECHAT';
$arr_online_config['多得宝微信H5']['merchant_url'] = 'https://api.ddbill.com/gateway/api/h5apipay';
$arr_online_config['多得宝支付宝H5'] = $arr_online_config['多得宝微信H5'];
$arr_online_config['多得宝支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['多得宝支付宝H5']['post_url'] = '/member/pay/ddbill/h5Pay.php?S_Type=ALIPAY';
$arr_online_config['多得宝QQ钱包H5'] = $arr_online_config['多得宝微信H5'];
$arr_online_config['多得宝QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['多得宝QQ钱包H5']['post_url'] = '/member/pay/ddbill/h5Pay.php?S_Type=QQPAY';
$arr_online_config['多得宝微信条码'] = $arr_online_config['多得宝微信H5'];
$arr_online_config['多得宝微信条码']['online_name'] = '微信条码';
$arr_online_config['多得宝微信条码']['input_url'] = '/member/pay/micropay.php';
$arr_online_config['多得宝微信条码']['post_url'] = '/member/pay/ddbill/microPay.php?S_Type=WECHAT';
$arr_online_config['多得宝微信条码']['merchant_url'] = 'https://api.ddbill.com/gateway/api/micropay';
$arr_online_config['多得宝网银'] = $arr_online_config['多得宝微信H5'];
$arr_online_config['多得宝网银']['online_name'] = '网银支付';
$arr_online_config['多得宝网银']['post_url'] = '/member/pay/ddbill/bankPay.php';
$arr_online_config['多得宝网银']['merchant_url'] = 'https://pay.ddbill.com/gateway?input_charset=UTF-8';


//天机付
$arr_online_config['天机付微信']['online_name'] = '微信扫码';
$arr_online_config['天机付微信']['pay_mid'] = '2018011111010045';
$arr_online_config['天机付微信']['pay_mkey'] = '0582131e6e4a94a976dcbbab8b218836';
$arr_online_config['天机付微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['天机付微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['天机付微信']['post_url'] = '/member/pay/iceuptrade/scanPay.php?S_Type=WECHAT';
$arr_online_config['天机付微信']['notice_url'] = $arr_online_config['天机付微信']['pay_url'] . 'pay/iceuptrade/notify.php';
$arr_online_config['天机付微信']['return_url'] = $arr_online_config['天机付微信']['pay_url'] . 'pay/iceuptrade/success.html';
$arr_online_config['天机付微信']['merchant_url'] = 'http://gate.iceuptrade.com/cooperate/gateway.cgi';
$arr_online_config['天机付支付宝'] = $arr_online_config['天机付微信'];
$arr_online_config['天机付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['天机付支付宝']['post_url'] = '/member/pay/iceuptrade/scanPay.php?S_Type=ALIPAY';
$arr_online_config['天机付QQ钱包'] = $arr_online_config['天机付微信'];
$arr_online_config['天机付QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['天机付QQ钱包']['post_url'] = '/member/pay/iceuptrade/scanPay.php?S_Type=QQPAY';
$arr_online_config['天机付微信H5'] = $arr_online_config['天机付微信'];
$arr_online_config['天机付微信H5']['online_name'] = '微信H5';
$arr_online_config['天机付微信H5']['post_url'] = '/member/pay/iceuptrade/h5Pay.php?S_Type=WECHAT';
$arr_online_config['天机付支付宝H5'] = $arr_online_config['天机付微信'];
$arr_online_config['天机付支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['天机付支付宝H5']['post_url'] = '/member/pay/iceuptrade/h5Pay.php?S_Type=ALIPAY';
$arr_online_config['天机付QQ钱包H5'] = $arr_online_config['天机付微信'];
$arr_online_config['天机付QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['天机付QQ钱包H5']['post_url'] = '/member/pay/iceuptrade/h5Pay.php?S_Type=QQPAY';
$arr_online_config['天机付网银'] = $arr_online_config['天机付微信'];
$arr_online_config['天机付网银']['online_name'] = '网银支付';
$arr_online_config['天机付网银']['post_url'] = '/member/pay/iceuptrade/bankPay.php';


//秒付宝
$arr_online_config['秒付宝微信']['online_name'] = '微信扫码';
$arr_online_config['秒付宝微信']['pay_mid'] = '';
$arr_online_config['秒付宝微信']['pay_mkey'] = '';
$arr_online_config['秒付宝微信']['pay_url'] = 'http://182.16.12.114/member/'; 
$arr_online_config['秒付宝微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['秒付宝微信']['post_url'] = '/member/pay/puyupay/scanPay.php?S_Type=WECHAT';
$arr_online_config['秒付宝微信']['notice_url'] = $arr_online_config['秒付宝微信']['pay_url'] . 'pay/puyupay/notify.php';
$arr_online_config['秒付宝微信']['return_url'] = $arr_online_config['秒付宝微信']['pay_url'] . 'pay/puyupay/success.html';
$arr_online_config['秒付宝微信']['merchant_url'] = 'https://webapi.puyupay.com/api/scanpay';
$arr_online_config['秒付宝QQ钱包'] = $arr_online_config['秒付宝微信'];
$arr_online_config['秒付宝QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['秒付宝QQ钱包']['post_url'] = '/member/pay/puyupay/scanPay.php?S_Type=QQPAY';
$arr_online_config['秒付宝微信H5'] = $arr_online_config['秒付宝微信'];
$arr_online_config['秒付宝微信H5']['online_name'] = '微信H5';
$arr_online_config['秒付宝微信H5']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['秒付宝微信H5']['post_url'] = '/member/pay/puyupay/h5Pay.php?S_Type=WECHAT';
$arr_online_config['秒付宝微信H5']['merchant_url'] = 'https://puyupay.com/CustomerManage/CustRate/H5Pay';
$arr_online_config['秒付宝QQ钱包H5'] = $arr_online_config['秒付宝微信H5'];
$arr_online_config['秒付宝QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['秒付宝QQ钱包H5']['post_url'] = '/member/pay/puyupay/h5Pay.php?S_Type=QQPAY';
$arr_online_config['秒付宝QQ钱包H5']['merchant_url'] = 'https://webapi.puyupay.com/api/scanpay';


$arr_online_config['百盛微信']['online_name'] = '微信扫码';
$arr_online_config['百盛微信']['pay_url'] = '/member/pay/baishengpay/';
$arr_online_config['百盛微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['百盛微信']['post_url'] = $arr_online_config['百盛微信']['pay_url'] . '/api.php?S_Type=WECHAT';
$arr_online_config['百盛微信']['notice_url'] = 'http://182.16.12.114/member/pay/baishengpay/notify.php';

$arr_online_config['百盛QQ钱包'] = $arr_online_config['百盛微信'];
$arr_online_config['百盛QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['百盛QQ钱包']['post_url'] = $arr_online_config['百盛QQ钱包']['pay_url'] . '/api.php?S_Type=QQPAY';

$arr_online_config['百盛支付宝'] = $arr_online_config['百盛微信'];
$arr_online_config['百盛支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['百盛支付宝']['post_url'] = $arr_online_config['百盛支付宝']['pay_url'] . '/api.php?S_Type=ALIPAY';

$arr_online_config['百盛京东钱包'] = $arr_online_config['百盛微信'];
$arr_online_config['百盛京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['百盛京东钱包']['post_url'] = $arr_online_config['百盛京东钱包']['pay_url'] . '/api.php?S_Type=JDPAY';

$arr_online_config['百盛银联'] = $arr_online_config['百盛微信'];
$arr_online_config['百盛银联']['online_name'] = '银联扫码';
$arr_online_config['百盛银联']['post_url'] = $arr_online_config['百盛银联']['pay_url'] . '/api.php?S_Type=UNIONPAY';

$arr_online_config['闪亿付微信']['online_name'] = '微信扫码';
$arr_online_config['闪亿付微信']['pay_mid'] = 'SYF201803150136';
$arr_online_config['闪亿付微信']['pay_mkey'] = '0C0097FC4423C4B38096FC86343F5018';
$arr_online_config['闪亿付微信']['pay_url'] = '/member/pay/637pay/';
$arr_online_config['闪亿付微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['闪亿付微信']['post_url'] = $arr_online_config['闪亿付微信']['pay_url'] . 'pay.php?S_Type=WECHAT';
$arr_online_config['闪亿付微信']['notice_url'] = 'http://pay.sdju2ss.top/member/pay/637pay/notify.php';

$arr_online_config['闪亿付微信H5'] = $arr_online_config['闪亿付微信'];
$arr_online_config['闪亿付微信H5']['online_name'] = '微信H5扫码';
$arr_online_config['闪亿付微信H5']['post_url'] = $arr_online_config['闪亿付微信H5']['pay_url'] . 'pay.php?S_Type=WECHAT_H5';

$arr_online_config['闪亿付QQ钱包'] = $arr_online_config['闪亿付微信'];
$arr_online_config['闪亿付QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['闪亿付QQ钱包']['post_url'] = $arr_online_config['闪亿付QQ钱包']['pay_url'] . 'pay.php?S_Type=QQPAY';

$arr_online_config['闪亿付支付宝'] = $arr_online_config['闪亿付微信'];
$arr_online_config['闪亿付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['闪亿付支付宝']['post_url'] = $arr_online_config['闪亿付支付宝']['pay_url'] . 'pay.php?S_Type=ALIPAY';

$arr_online_config['闪亿付京东钱包'] = $arr_online_config['闪亿付微信'];
$arr_online_config['闪亿付京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['闪亿付京东钱包']['post_url'] = $arr_online_config['闪亿付京东钱包']['pay_url'] . 'pay.php?S_Type=JDPAY';

$arr_online_config['闪亿付百度钱包'] = $arr_online_config['闪亿付微信'];
$arr_online_config['闪亿付百度钱包']['online_name'] = '百度钱包扫码';
$arr_online_config['闪亿付百度钱包']['post_url'] = $arr_online_config['闪亿付百度钱包']['pay_url'] . 'pay.php?S_Type=BDPAY';

$arr_online_config['闪亿付银联钱包'] = $arr_online_config['闪亿付微信'];
$arr_online_config['闪亿付银联钱包']['online_name'] = '银联扫码';
$arr_online_config['闪亿付银联钱包']['post_url'] = $arr_online_config['闪亿付银联钱包']['pay_url'] . 'pay.php?S_Type=JDPAY';

$arr_online_config['密付微信']['online_name'] = '微信扫码';
$arr_online_config['密付微信']['pay_mid'] = 'U5ABA00ED7301A';
$arr_online_config['密付微信']['pay_mkey'] = 'GV7Qdem1pIzDiLXVP7gNcDrPaRBMV3As';
$arr_online_config['密付微信']['pay_url'] = '/member/pay/mfpay/';
$arr_online_config['密付微信']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['密付微信']['post_url'] = $arr_online_config['密付微信']['pay_url'] . 'pay.php?S_Type=WECHAT';
$arr_online_config['密付微信']['notice_url'] = 'http://pay4.xinl11.top/member/pay/mfpay/notify.php';

$arr_online_config['密付支付宝'] = $arr_online_config['密付微信'];
$arr_online_config['密付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['密付支付宝']['post_url'] = $arr_online_config['密付支付宝']['pay_url'] . 'pay.php?S_Type=ALIPAY';

$arr_online_config['密付QQ钱包'] = $arr_online_config['密付微信'];
$arr_online_config['密付QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['密付QQ钱包']['post_url'] = $arr_online_config['密付QQ钱包']['pay_url'] . 'pay.php?S_Type=QQ';

$arr_online_config['密付WAP微信'] = $arr_online_config['密付微信'];
$arr_online_config['密付WAP微信']['online_name'] = '微信扫码';
$arr_online_config['密付WAP微信']['post_url'] = $arr_online_config['密付WAP微信']['pay_url'] . 'pay.php?S_Type=WAP_WECHAT';
*/

$pay_mid = $arr_online_config[$pay_online]['pay_mid'];
$pay_mkey = $arr_online_config[$pay_online]['pay_mkey'];
$pay_pubKey = $arr_online_config[$pay_online]['pay_pubKey'];
$pay_TerminalID = $arr_online_config[$pay_online]['pay_TerminalID'];
$pay_url = $arr_online_config[$pay_online]['pay_url'];
$input_url = $arr_online_config[$pay_online]['input_url'];
$post_url = $arr_online_config[$pay_online]['post_url'];
$return_url = $arr_online_config[$pay_online]['return_url'];
$advice_url = $arr_online_config[$pay_online]['advice_url'];
$merchant_url = $arr_online_config[$pay_online]['merchant_url'];
$notice_url = $arr_online_config[$pay_online]['notice_url'];