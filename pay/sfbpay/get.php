<?php 
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
//$pay_memberid = "10002";   //商户ID
$pay_memberid = $pay_mid;

$pay_orderid = 'w'.date("YmdHis").rand(100000,999999);    //订单号
$pay_orderid = $_payId;
$pay_amount = $amount * 0.01;    //交易金额
$pay_applydate = date("Y-m-d H:i:s");  //订单时间
$pay_notifyurl = "https://pay.17588.com/demo/server.php";   //服务端返回地址
$pay_notifyurl = $notice_url;//服务端返回地址
$pay_callbackurl = $notice_url;  //页面跳转返回地址
//$Md5key = "t4ig5acnpx4fet4zapshjacjd9o4bhbi";   //密钥

$Md5key = $pay_mkey;
//$tjurl = "https://pay.17588.com/Pay_Index.html";   //提交地址
$tjurl ="http://dp.sf532.com/Pay_Index.html";

$pay_bankcode = $payChannel;   //编码  902:微信扫码;903:支付宝扫码 908:QQ扫码
//扫码
$native = array(
    "pay_memberid" => $pay_memberid,
    "pay_orderid" => $pay_orderid,
    "pay_amount" => $pay_amount,
    "pay_applydate" => $pay_applydate,
    "pay_bankcode" => $pay_bankcode,
    "pay_notifyurl" => $pay_notifyurl,
    "pay_callbackurl" => $pay_callbackurl,
);
ksort($native);
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
//echo($md5str . "key=" . $Md5key);
$sign = strtoupper(md5($md5str . "key=" . $Md5key));
$native["pay_md5sign"] = $sign;
$native['pay_attach'] =   $ext;//
$native['pay_productname'] ='VIP基础服务';
$res_json =  get_url($native,$tjurl);

function get_url($post_data,$url){
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

?>