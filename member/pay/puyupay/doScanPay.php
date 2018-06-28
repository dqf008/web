<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$merchantId = $pay_mid; //渠道号
$key = $pay_mkey; //key
$orderId = $_payId; //订单号
$orderAmount = $amount >= 100 ? ($amount * 100 + mt_rand(1, 9)) : $amount * 100; //订单金额 单位分
$payType = $payChannel; //付款类型 支付宝扫码
$notifyUrl = ""; //通知Url
$selfParam = ""; //扩展
$remark = ""; //备注
$timestamp = time();
$random = mt_rand(100000, 999999);
$signContent = "";
$signContent = $signContent . "merchantId=" . $merchantId;
$signContent = $signContent . "&appKey=" . $key;
$signContent = $signContent . "&payType=" . $payType;
$signContent = $signContent . "&orderAmount=" . $orderAmount;
$signContent = $signContent . "&orderId=" . $orderId;
$signContent = $signContent . "&timestamp=" . $timestamp;
$signContent = $signContent . "&random=" . $random;
$signature = strtoupper(sha1($signContent));
$data = array(
    "orderId" => $orderId,
    "merchantId" => $merchantId,
    "orderAmount" => $orderAmount,
    "payType" => $payType,
    "random" => $random,
    "selfParam" => $selfParam,
    "remark" => $remark,
    "signature" => $signature,
    "timestamp" => $timestamp
);
$postData = json_encode($data);
$result = sendPost($merchant_url, $postData);
$dataObj = json_decode($result["responseText"]);
if ($dataObj->state == 1 && isset($dataObj->data)) {
    if (isset($dataObj->data->codeurl)) {
        $data = array();
        $data['status'] = 1;
        $data['message'] = $dataObj->data->codeurl;
    }
} else {
    $data = array();
    $data['status'] = 'error';
    $data['message'] = $result["responseText"];
}
if (strpos($_SERVER['HTTP_REFERER'], 'mobilePay.php?')) {
    $qrcode = $dataObj->data->codeurl;
    $qrcode = base64_encode($qrcode);
    $url = "/member/pay/qrcodex.php?s={$qrcode}&k=2";
    echo "<div align='center'><img  src='{$url}' width='320'/></div>";
} else {
    $jsonCallback = htmlspecialchars($_REQUEST['callback']);
    echo $jsonCallback . '(' . json_encode($data) . ')';
}
function sendPost($url, $postData) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Content-Length: ' . strlen($postData)
    ));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return array(
        "statusCode" => $httpCode,
        "responseText" => $response
    );
}