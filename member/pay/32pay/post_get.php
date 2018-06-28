<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$pay_memberid = $pay_mid;
$pay_orderid = $_payId;
$pay_amount = $amount * 0.01; //交易金额
$pay_applydate = date("Y-m-d H:i:s"); //订单时间
$pay_notifyurl = $notice_url; //服务端返回地址
$pay_callbackurl = $notice_url; //页面跳转返回地址
$Md5key = $pay_mkey;

$tjurl = $merchant_url; //提交地址

if ($payChannel == 1) {
    $type = '21';
} elseif ($payChannel == 2) {
    $type = '33';
} elseif ($payChannel == 3) {
    $type = '89';
} elseif ($payChannel == 4) {
    $type = '92';
} else {
    $type = '1';
}
$native = array(
    "P_UserId" => $pay_memberid,
    "P_OrderId" => $pay_orderid,
    "P_CardId" => 0,
    "P_CardPass" => 0,
    "P_FaceValue" => $pay_amount,
    "P_ChannelId" => $type,
    "SafeStr" => $pay_mkey
);
//ksort($native);
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $val . "|";
}
$md5str = rtrim($md5str, '|');
//$md5str = $md5str . 'key=' . $Md5key;
$sign = strtolower(md5($md5str));
unset($native['SafeStr']);
$native["P_Subject"] = $ext;
$native["P_Price"] = $pay_amount;
$native["P_Quantity"] = 1;
$native["P_Description"] = '10001';
$native["P_PostKey"] = $sign;
$native["P_Result_URL"] = $notice_url;
$native["P_Notify_URL"] = $notice_url;
$str = "";
foreach ($native as $k => $v) {
    $str .= $k . "=" . $v . "&";
}
$str = rtrim($str, '&');
$tjurl = $tjurl . "?" . $str;
//echo $tjurl;exit;
header("location:$tjurl");