<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$pay_mid = explode('|', $pay_mid);
$pay_memberid = $pay_mid[0];
$pay_orderid = $_payId;
$pay_amount = $amount * 100; //交易金额
$pay_applydate = date("YmdHis"); //订单时间
$pay_notifyurl = $notice_url; //服务端返回地址
$pay_callbackurl = $notice_url; //页面跳转返回地址
$Md5key = $pay_mkey;
$tjurl = $merchant_url; //提交地址
$type = $payChannel;
$native = array(
    "src_code" => $pay_mid[1],
    "out_trade_no" => $pay_orderid,
    "total_fee" => $pay_amount,
    "time_start" => $pay_applydate,
    "goods_name" => $ext,
    "trade_type" => $type,
    "finish_url" => $pay_notifyurl,
    "mchid" => $pay_memberid
);
ksort($native);
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
//$md5str = rtrim($md5str, '&');
$md5str = $md5str . 'key=' . $Md5key;
$sign = strtoupper(md5($md5str));
$native["sign"] = $sign;
$json = post_data($native, $tjurl);
$res = json_decode($json, true);
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