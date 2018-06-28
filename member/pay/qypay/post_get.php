<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$pay_memberid = $pay_mid;
$pay_orderid = $_payId;
$pay_amount = $amount; //交易金额
$pay_applydate = date("Y-m-d H:i:s"); //订单时间
$pay_notifyurl = $notice_url; //服务端返回地址
$pay_callbackurl = $notice_url; //页面跳转返回地址
$Md5key = $pay_mkey;

$tjurl = $merchant_url; //提交地址

if ($payChannel == 1) {
    $type = 'WX';
} elseif ($payChannel == 2) {
    $type = 'ZFB';
} elseif ($payChannel == 3) {
    $type = 'QQ';
} elseif ($payChannel == 4) {
    $type = 'JD';
} else {
    $type = 'UNION_WALLET';
}

include('util.php');

$Rsa = new Rsa();
$data['orderNum'] = $pay_orderid;
$data['version'] = 'V3.1.0.0';
$data['charset'] = 'UTF-8';
$data['random'] = (string) rand(1000,9999);
$data['merNo'] = $pay_memberid;
$data['netway'] = $type;   	
$data['amount'] = (string) $pay_amount;	// 单位:分
$data['goodsName'] = $ext;
$data['callBackUrl'] = $notice_url;
$data['callBackViewUrl'] = $notice_url;
$data['sign'] = create_sign($data, $Md5key);

$json = json_encode_ex($data);
$dataStr = $Rsa->encode_pay($json);
$param = 'data=' . urlencode($dataStr) . '&merchNo=' . $pay_memberid . '&version=V3.1.0.0';

$result = wx_post($tjurl, $param);
$rows = json_to_array($result, $Md5key);

if ($rows['stateCode'] == '00') {
    $qrcode = $rows['qrcodeUrl'];
    $qrcode = base64_encode($qrcode);
    $url = "/member/pay/qrcodex.php?s={$qrcode}&k=2";    
 	echo "<div align='center'><img  src='{$url}' width='320'/></div>";		
} else {
    echo "错误代码：" . $rows['stateCode'] . ' 错误描述:' . $rows['msg'];
}