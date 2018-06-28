<?php
require_once "utils.php";
$reqData = array(
    'p1_mchtid' => $pay_mid,
    'p2_paytype' => $payChannel,
    'p3_paymoney' => $amount,
    'p4_orderno' => $_payId,
    'p5_callbackurl' => $notice_url,
    'p6_notifyurl' => $notice_url,
    'p7_version' => 'v2.8',
    'p8_signtype' => '1',
    'p9_attach' => '',
    'p10_appname' => '',
    'p11_isshow' => '1',
    'p12_orderip' => $_SERVER['REMOTE_ADDR']
);
$skey = $pay_mkey;
$sign = pay::sign($reqData, $skey);
$payUrl = $merchant_url;
$reqData['sign'] = $sign;
$respon = pay::curlPost($reqData, $payUrl, 2, 60);
$res = array();
if (!isset($respon['data']['r6_qrcode'])) {
    $res['returncode'] = '01';
    $res['msg'] = '签名验证失败';    
} else {
    $responData = $respon['data'];
    unset($responData['sign']);
    if ($respon['data']['sign'] != pay::sign($responData, $skey)) {
        $res['returncode'] = '01';
        $res['msg'] = '签名验证失败';    
    } else {
        $res['returncode'] = '00';
        $res['url'] = $responData['r6_qrcode'];
    }
}