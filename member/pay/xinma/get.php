<?php
require_once "utils.php";
$appKey = $pay_mkey;
$url = $merchant_url;
$reqData = array(
    'messageid' => '200001',
    'out_trade_no' => $_payId,
    'back_notify_url' => $notice_url,
    'branch_id' => $pay_mid,
    'prod_name' => '测试支付',
    'prod_desc' => '测试支付描述',
    'pay_type' => $payChannel,
    'total_fee' => $amount * 100,
    'nonce_str' => createNoncestr(32)
);
//$reqData = sign($reqData, $SignKey);
$reqData = sign($reqData, $appKey);
$result = httpPost($url, $reqData);
$resultJson = json_decode($result);
$res = array();
if ($resultJson->resultCode == '00' && $resultJson->resCode == '00') {
    $resultToSign = array();
    foreach ($resultJson as $key => $value) {
        if ($key != 'sign') {
            $resultToSign[$key] = $value;
        }
    }
    $str = formatBizQueryParaMap($resultToSign);
    $resultSign = strtoupper(md5($str . "&key=" . $appKey));
    if ($resultSign != $resultJson->sign) {
        $res['returncode'] = '01';
        $res['msg'] = '签名验证失败';
    } else {
        $res['returncode'] = '00';
        $res['url'] = $resultJson->payUrl;
    }
} else {
    $res['returncode'] = '01';
    $res['msg'] = $resultJson->resDesc;
}