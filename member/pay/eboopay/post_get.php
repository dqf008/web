<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$pay_memberid = $pay_mid; //商户ID
$pay_orderid = $_payId; //订单号+商户ID
$pay_amount = $amount; //交易金额
$pay_applydate = date("Y-m-d H:i:s"); //订单时间
$pay_bankcode = $payChannel; //银行编码
$pay_notifyurl = $notice_url; //服务端返回地址
$Md5key = $pay_mkey; //密钥（跳转过程中，请注意检查密钥是否有泄露）
$tjurl = $merchant_url; //提交地址
//支付宝支付
$jsapi = array(
    "pay_memberid" => $pay_memberid,
    "pay_orderid" => $pay_orderid,
    "pay_amount" => $pay_amount,
    "pay_applydate" => $pay_applydate,
    "pay_bankcode" => $pay_bankcode,
    "pay_notifyurl" => $pay_notifyurl
);
ksort($jsapi);
$md5str = "";
foreach ($jsapi as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
//echo($md5str . "key=" . $Md5key."<br>");
$sign = strtoupper(md5($md5str . "key=" . $Md5key));
$jsapi["pay_md5sign"] = $sign;
?>
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>send</title>
</head>
<body onload="document.getElementById('myform').submit();" >
<form id="myform" action="<?php echo $tjurl;?>" method="POST" target="_self">
<?php
foreach ($jsapi as $key => $val) {
    echo '<input type="hidden" name="' . $key . '" value="' . $val . '">';
}
?>
</form>
</body>
</html>