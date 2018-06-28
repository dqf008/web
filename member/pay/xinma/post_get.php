<?php
require_once "utils.php";
$appKey = $pay_mkey;
$url = $merchant_url;
if ($payChannel == 4) {
    $reqData = array(
        'messageid' => '200002',
        'out_trade_no' => $_payId,
        'back_notify_url' => $notice_url,
        'front_notify_url' => $notice_url,
        'branch_id' => $pay_mid,
        'prod_name' => '测试支付',
        'prod_desc' => '测试支付描述',
        'pay_type' => '30',
        'bank_code' => $bank_code,
        'bank_flag' => $bank_flag,
        'total_fee' => $amount,
        'nonce_str' => createNoncestr(32)
    );
    $reqData = sign($reqData, $appKey);
    $result = httpPost($url, $reqData);
    //$resultJson=json_decode($result);
    echo $result;    
} else {
    $reqData = array(
        'messageid' => '200004',
        'out_trade_no' => $_payId,
        'back_notify_url' => $notice_url,
        'front_notify_url' => $notice_url,
        'branch_id' => $pay_mid,
        'prod_name' => '测试支付',
        'prod_desc' => '测试支付描述',
        'pay_type' => $payChannel,
        'total_fee' => $amount,
        'nonce_str' => createNoncestr(32)
    );
    $reqData = sign($reqData, $appKey);
    $result = httpPost($url, $reqData);
    $resultJson = json_decode($result);
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
            echo '签名验证失败';
        } else {
            header("Location:" . $resultJson->payUrl);
        }
    } else {
        echo $resultJson->resDesc;
    }
}