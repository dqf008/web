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
// 商户APINMAE，WEB渠道一般支付
$data['service'] = 'TRADE.H5PAY';
// 商户API版本
$data['version'] = '1.0.0.0';
// 商户在支付平台的的平台号
$data['merId'] = $pay_mid;
//商户订单号
$data['tradeNo'] = $_payId;
//支付类型
$data['typeId'] = $payChannel;
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
//var_dump($data);
// return;
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
//var_dump($signMsg);
//return;
//$signMsg='4F0D7B1A8DF615DABE147B1CC112B79C';
$data['sign'] = $signMsg;
// 生成表单数据
echo $pPay->buildForm($data, $merchant_url);