<?php
/**
 * Created by PhpStorm.
 * 支付demo
 * Date: 2017/9/9
 * Time: 14:40
 */
require_once("yidao.php");
$ydpay = new yidao();
//$data = $ydpay->pay("order_".time(),"测试商品","10","ZFBZF");
$data = $ydpay->pay("order_".time(),"测试商品","10","WXZF");
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://api.easypay168.cn/externalSendPay/rechargepay.do");

curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
curl_setopt($ch, CURLOPT_HEADER,false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
// post数据
curl_setopt($ch, CURLOPT_POST,1);
// post的变量
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output = curl_exec($ch);
curl_close($ch);
$response = json_decode($output,true);
$txnTime = $response['responseObj']['txnTime'];//存储交易时间，查询订单接口必要参数。
$orgOrderNo = $response['responseObj']['orgOrderNo'];//订单号，查询订单接口必要参数。
$qrCode =$response['responseObj']['qrCode'];
if (!$response['responseObj']['qrCode']){
    return "支付错误";
}
echo json_encode($response)."1";

?>
<img src="http://qr.liantu.com/api.php?text=<?php echo $qrCode?>"/>
<script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>