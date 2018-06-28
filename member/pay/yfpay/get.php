<?php
header("Content-type: text/html; charset=utf-8");
/*
 * 商户号:xjqc000010
    交易密钥:1154c7c7e19c4caeb0207bb09291abd8
 */
$site = 'http://pay.highflytech.com';
$url = "http://113.106.95.37:7777/gyprovider/getNativeUrl.do";
$url = $merchant_url;
$money = $amount ;
$key = $pay_mkey;
$data['gymchtId'] = $pay_mid;
//处理数据

//$data['gymchtId'] ='xjqc000010';
//$key ='1154c7c7e19c4caeb0207bb09291abd8';
$data['tradeSn'] = $_payId;
$data['orderAmount'] = $money;//分
$data['goodsName'] ='在线';

$data['tradeSource'] = $payChannel;//1支付宝，2微信,4,qq支付
$data['notifyUrl'] = $notice_url;//通知地址
ksort ($data);
foreach($data as $k=>$v){
    $str.="$k=$v&";
}
$str=$str."key=".$key;
$str = strtoupper(md5($str));
$data['sign'] = $str;
$json = post_data($data,$url);
$json = json_decode($json,true);
echo "<pre/>";
print_r($data);

function post_data($post_data,$url){
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL,$url );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
    $return = curl_exec ( $ch );
    curl_close ( $ch );
    return $return;
}


