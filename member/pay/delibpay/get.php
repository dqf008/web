<?php
$submiturl = $merchant_url;
$key = $pay_mkey; //用户key
$parter = $pay_mid; //用户ID
$orderid = $_payId; //用户订单号（必须唯一）
$value = $amount; //订单金额
$type = $payChannel; //银行ID（见文档）
$callbackurl = $notice_url; //同步接收返回URL连接
$hrefbackurl = $notice_url; //异步接收返回URL连接
$payerIp = $_SERVER['REMOTE_ADDR']; //客户IP
$attach = $ext; //备注
$sign = "parter=" . $parter . "&type=" . $type . "&value=" . $value . "&orderid=" . $orderid . "&callbackurl=" . $callbackurl;
$sign = md5($sign . $key); //签名数据 32位小写的组合加密验证串
$url = $submiturl . "?parter=" . $parter . "&type=" . $type . "&value=" . $value . "&orderid=" . $orderid . "&callbackurl=" . $callbackurl . "&attach=" . $attach . "&hrefbackurl=" . $hrefbackurl . "&payerIp=" . $payerIp . "&sign=" . $sign;
header('Location:' . $url);