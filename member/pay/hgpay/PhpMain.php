<?php
header("content-Type: text/html; charset=UTF-8");
$date = date('YmdHis');

$money = $amount;
$order = $_payId;
$merId = '929000053991024';
$md5key = "01ff5e3377750dac62ef00721f597037";//商户配置密钥
$merId = $pay_mid;
$md5key = $pay_mkey;
$txnType = $payChannel;   ////微信--41,支付宝—42,QQ钱包--43,网关支付--44
$backUrl = $notice_url;
$pay = array();
$pay['merId'] = $merId;//测试商户号
$pay['merOrderId'] =  $order;
$pay['subject'] = '商品';
$pay['body'] = '商品';
$pay['bizType'] = '01';
$pay['txnType'] = $txnType;//微信--41,支付宝—42,QQ钱包--43,网关支付--44
$pay['txnSubType'] = '00';
$pay['payType'] = '0701';
$pay['transAmt'] = $money * 100;
$pay['currency'] = 'CNY';
$pay['backUrl'] = $backUrl;
$pay['sendIp'] = $_SERVER['REMOTE_ADDR'];
//$pay['txnTime'] = '20170928233303';
//$pay['merResv'] = '客户保留信息';

ksort($pay);
$msg = signMsg($pay, $md5key);
$pay['signature'] = strtoupper(md5($msg));
$url = 'http://payment.aikuli.com/guanjun/pay/BgTrans';//访问地址
//print_r($pay);
$res = http_post_json($url, $pay);
//$res = json_decode($res,true);


/* if($res['code']=='0000' && $res['imgUrl'] ){
    $url = $res['imgUrl'];
}
echo $url;
 */
/**
 * 设置加签数据
 *
 * @param unknown $array
 * @param unknown $md5Key
 * @return string
 */
function signMsg($array,$md5Key){
    $msg = "";
    $i = 1;
    // 转换为字符串 key=value&key.... 加签
    foreach ($array as $key => $val) {
        // 不参与签名
        if($key != "signMethod" && $key != "signature"){
            if($i == 0 ){
                $msg = $msg."$key=$val";
            }else {
                $msg = $msg."&$key=$val";
            }
            $i++;
        }
    }
    $msg = $msg.$md5Key;
    return  $msg;
}



function http_post_json($url, $jsonStr)
{
    //启动一个CURL会话
    $ch = curl_init();
    // 设置curl允许执行的最长秒数
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    // 获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    //发送一个常规的POST请求。
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    //要传送的所有数据
    curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonStr);
    // 执行操作
    $res = curl_exec($ch);
    return $res;
}
 

?>