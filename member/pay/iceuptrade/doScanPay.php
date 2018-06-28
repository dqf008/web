<?php
/* *
 * 功能：一般支付处理文件
 * 版本：1.0
 * 日期：2012-03-26
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码。
 */
require_once("lib/Pay.class.php");
// 请求数据赋值
$data = "";
// 商户APINMAE，扫码支付
$data['service'] = 'TRADE.SCANPAY';
// 商户API版本
$data['version'] = '1.0.0.0';
// 商户在支付平台的的平台号
$data['merId'] = $pay_mid;
//商户订单号
$data['tradeNo'] = $_payId;
// 商户订单日期
$data['tradeDate'] = date("Ymd");
// 商户交易金额
$data['amount'] = $amount;
// 商户通知地址
$data['notifyUrl'] = $notice_url;
// 商户扩展字段
$data['extra'] = '';
// 商户交易摘要
$data['summary'] = 'summary';
//超时时间
$data['expireTime'] = '';
//客户端ip
$data['clientIp'] = $_SERVER['REMOTE_ADDR'];
$data['typeId'] = $payChannel;
// 对含有中文的参数进行UTF-8编码
// 将中文转换为UTF-8
if (!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['notifyUrl'])) {
    $data['notifyUrl'] = iconv("GBK", "UTF-8", $data['notifyUrl']);
}
if (!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['extra'])) {
    $data['extra'] = iconv("GBK", "UTF-8", $data['extra']);
}
if (!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['summary'])) {
    $data['summary'] = iconv("GBK", "UTF-8", $data['summary']);
}
// 初始化
$pPay = new Pay($pay_mkey, $merchant_url);
// 准备待签名数据
$str_to_sign = $pPay->prepareSign($data);
// 数据签名
$signMsg = $pPay->sign($str_to_sign);
$data['sign'] = $signMsg;
// 初始化
$pPay = new Pay($pay_mkey, $merchant_url);
// 准备请求数据
$to_requset = $pPay->prepareRequest($str_to_sign, $signMsg);
//请求数据
$resultData = $pPay->request($to_requset);
// 响应吗
preg_match('{<code>(.*?)</code>}', $resultData, $match);
$respCode = $match[1];
// 响应信息
preg_match('{<desc>(.*?)</desc>}', $resultData, $match);
$respDesc = $match[1];
preg_match('{<qrCode>(.*?)</qrCode>}', $resultData, $match);
$respqrCode = $match[1];
$base64 = $respqrCode;
if ($respCode == '00') {
?>
<!DOCTYPE html>
<html>
<head>
    <title>扫码支付</title>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/base64.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.qrcode.js"></script>
    <script type="text/javascript">
        function generateQrcode(base64) {
            var options = {
                render: 'image',
                text: Base64.decode(base64),
                size: 180,
                ecLevel: 'M',
                color: '#222222',
                minVersion: 1,
                quiet: 1,
                mode: 0
            };
            $("#qrcode").empty().qrcode(options);
        }

        $(function () {
            var base64 = $('#base64').text();
            generateQrcode(base64);
        });
    </script>
</head>
<body>
    <a id="base64" style="display: none;"><?php echo $base64;?></a>
    <div id="qrcode"></div>
</body>
</html>
<?php
} else
    echo $respDesc;
?>