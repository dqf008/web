<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
// $apiurl = $merchant_url;
// /*接口提交地址*/
// $version = '3.0';
// /*接口版本号,目前固定值为3.0*/
// $method = 'Rx.online.pay';
// /*接口名称: Rx.online.pay*/
// $partner = $pay_mid; //商户id,由API分配
// $banktype = $payChannel; //银行类型 default为跳转到接口进行选择支付
// $paymoney = $amount; //单位元（人民币）,两位小数点
// $ordernumber = $_payId; //商户系统订单号，该订单号将作为接口的返回数据。该值需在商户系统内唯一
// $callbackurl = $notice_url; //下行异步通知的地址，需要以http://开头且没有任何参数
// $hrefbackurl = ''; //下行同步通知过程的返回地址(在支付完成后接口将会跳转到的商户系统连接地址)。注：若提交值无该参数，或者该参数值为空，则在支付完成后，接口将不会跳转到商户系统，用户将停留在接口系统提示支付成功的页面。
// $goodsname = ''; //商品名称。若该值包含中文，请注意编码
// $attach = ''; //备注信息，下行中会原样返回。若该值包含中文，请注意编码
// $isshow = 1; //该参数为支付宝扫码、微信、QQ钱包专用，默认为1，跳转到网关页面进行扫码，如设为0，则网关只返回二维码图片地址供用户自行调用
// $key = $pay_mkey; //商户Key,由API分配
// $signSource = sprintf("version=%s&method=%s&partner=%s&banktype=%s&paymoney=%s&ordernumber=%s&callbackurl=%s%s", $version, $method, $partner, $banktype, $paymoney, $ordernumber, $callbackurl, $key);
// $sign = md5($signSource); //32位小写MD5签名值，UTF-8编码
// $postUrl = $apiurl . "?version=" . $version;
// $postUrl .= "&method=" . $method;
// $postUrl .= "&partner=" . $partner;
// $postUrl .= "&banktype=" . $banktype;
// $postUrl .= "&paymoney=" . $paymoney;
// $postUrl .= "&ordernumber=" . $ordernumber;
// $postUrl .= "&callbackurl=" . $callbackurl;
// $postUrl .= "&hrefbackurl=" . $hrefbackurl;
// $postUrl .= "&goodsname=" . $goodsname;
// $postUrl .= "&attach=" . $attach;
// $postUrl .= "&isshow=" . $isshow;
// $postUrl .= "&sign=" . $sign;
// //header("location:$postUrl");
// $opt = array(
//     'http' => array(
//         'header' => "Referer: http://pay.shimingj.top/"
//     )
// );
// $context = stream_context_create($opt);
// $response = file_get_contents($postUrl, false, $context);
// //file_put_contents("success.txt", $response . "\n", FILE_APPEND);
// $response = str_replace("/online/QrPage", "http://dpos.rxpay88.com/online/QrPage", $response);
// echo $response;

$url = 'http://www.fpay.info:55110/index/api/custom_money';
$data = [];
$data['money'] = $amount;
$data['uid'] = $pay_mid;
$data['time'] = time();
$data['pay_type'] = $payChannel;
$data['nickname'] = $rows['username'];
$data['custom'] = $_payId;
$str = $pay_mkey;
foreach($data as $v) $str.=$v;
$data['sign'] = md5($str);
$url.='?'.http_build_query($data);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_TIMEOUT,30);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$res = curl_exec($ch);
curl_close($ch);
$arr = json_decode($res, true);
if(empty($arr['data'])){
	echo $arr['message'];
}else{
	header('Location: '.$arr['data']['url']);
}