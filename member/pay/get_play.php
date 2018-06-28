<?php
//取出配置信息
//$ROOT = $_SERVER['DOCUMENT_ROOT'];
include_once $_SERVER['DOCUMENT_ROOT'].'/database/mysql.config.php';

$sql ='SELECT a.*,b.play_title FROM set_play AS a LEFT JOIN set_play_list AS b ON  b.id=a.play_id where a.status=1 ';
$query = $mydata1_db->query($sql);
while($rows = $query->fetch()){
    $get_play[] = $rows;
    
}
//All()
//服务器私KEY
$zhifu_pay_mkey = '-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAKdi4DRr952cbLX+
QB51daVNPofrED1bD9OhU9EMddsuDGH4F2JXB5yqQ06VyytAazVuSrKjDwyYGlPd
aeIH7qCtfY0ggqfZjIRTyqpHvkD4565ZdY99/RYy7G5HE32DeJr+i1E8bi2/KkpG
tvSaugzZzhYX1JqG6KGL4qACdrupAgMBAAECgYAbYImpKUuLpM0HCzmzgaSnT7X9
hw3V6zHwfD94PqB8I9D0qR4yAGgHULXHgaqEPXoLeCmRhCfu+GW998XcqU13CJIv
kk88lJ4k176M96kfI+XfQDg7AWjZXksm31Uhfl9poOrxQ0YV3ELLB/iFf3HWo656
YwPspd0BcS0/0ImAgQJBAM8ezhE24gJL/a/sxp9c47YCtEVwejZPlfPUYtIzyNyJ
0pTLdT7TuGJCq/SC16KbUEdEoKfhVg5mDmyOk4gLEFkCQQDO44gLt9hgm9fF0Zi1
WLk1r9ugGuH8/+bqUkRhsiQyXOgS5dpEEsDGzzojZ2b7n3Br6mXCJcOITgyP61i9
vRvRAkA6g5ZuEJZLVdKm5/q5PRHr8tmhIIS2YUeY6jC89/pQK/O9K7nE9SWLRRC1
dF2dR8mnSMEmjKe2S6jZjHIrpgyJAkAlV5I1s0A958MhdHxgtxvu4cf9dPy3QqU2
RBUNoS7BXF2TE6O6x7u95qdyvnYrEpMjF1K4oUJStuuzimIhFSIRAkEAuCzz/fBa
+9/NFwlcLSBO1Rbc6VeiiV/89kR17lyXhaxmmlL05YJlbTa21NEj5sWqOS9cQVTs
mMyyKQ7b/B20Og==
-----END PRIVATE KEY-----';

if($get_play){

foreach ($get_play as $key => $play_v) {
        if($play_v['id'] >13){
            $kid= trim($play_v['play_title']).'_'.$play_v['id'];
        }else{
            $kid= trim($play_v['play_title']);
        }
    
	//取智付
	 if($play_v['play_id']==3 or  $play_v['play_id']==2 ){
	     
	 	$arr_online_config[$kid]['online_name'] = '在线支付';
	 	$arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	 	$arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';
	 	$keys = trim($play_v['play_key']);
		$keys = "-----BEGIN PUBLIC KEY-----
{$keys}
-----END PUBLIC KEY-----";
	 	$arr_online_config[$kid]['pay_pubKey'] = $keys;
	 	$arr_online_config[$kid]['pay_mkey'] = $zhifu_pay_mkey;//服务器私KEY
	 	$arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/dinpay3.1.php';
	 	$arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/dinpay3.1/MerToDinpay.php';
	 	$arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/dinpay3.1/DinpayToMer.php';
	 	$arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/dinpay3.1/DinpayToMer.php';
	 	//微信
	 	if($play_v['play_id']==2){
	 	    $arr_online_config[$kid] = $arr_online_config[$kid];
	 	    $arr_online_config[$kid]['online_name'] = '微信扫码';
	 	    $arr_online_config[$kid]['input_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/member/pay/dinpay3.1wx.php';
	 	    $arr_online_config[$kid]['post_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/member/pay/dinpay3.1wx/post.php';
	 	    $arr_online_config[$kid]['advice_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/member/pay/dinpay3.1wx/get.php';
	 	    $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/dinpay3.1wx/notify.php';
	 	}
	 	
	 }

	 //艾米森微信
	 if($play_v['play_id']==4 or $play_v['play_id']==5 or $play_v['play_id']==6 ){
	   
	 	$arr_online_config[$kid]['online_name'] = '微信扫码';
	 	$pay_mid = explode(',', $play_v['play_account']);
	 	$arr_online_config[$kid]['pay_mid'] = $pay_mid;
	 	$arr_online_config[$kid]['pay_mkey'] = $play_v['play_key'];
	 	$arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';
	 	$arr_online_config[$kid]['merchant_url'] = $play_v['merchant_url'];
	 	
	 	//
	 	//$arr_online_config['艾米森微信']['pay_mid'] = array('AMf8Ta149689617667oUq', '135555');
	 	//$arr_online_config['艾米森微信']['pay_mkey'] = '62viz9E8vI1496896176CwcnGjfYwYX';
	 	$arr_online_config[$kid]['pay_name'] = '微信';
	 	$arr_online_config[$kid]['pay_type'] = 'WECHAT';
	 	$arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/amspay.php';
	 	$arr_online_config[$kid]['advice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/amspay/get.php';
	 	$arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/amspay/post.php';
	 	$arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] .'pay/amspay/success.html';
	 	//艾米森支付宝
	 	if($play_v['play_id']==5){
	 	    $arr_online_config[$kid] = $arr_online_config[$kid];
	 	    $arr_online_config[$kid]['online_name'] = '支付宝扫码';
	 	    $arr_online_config[$kid]['pay_name'] = '支付宝';
	 	    $arr_online_config[$kid]['pay_type'] = 'ALIPAY';
	 	}
	 	//艾米森网银
	 	if($play_v['play_id']==6){
	 	    $arr_online_config[$kid] = $arr_online_config[$kid];
	 	    $arr_online_config[$kid]['online_name'] = '网银充值';
	 	    $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/redirect.php';
	 	    $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/amspay/redirect.php?S_Type=ONLINE';
	 	}
	 	
	 }

	 //仁信
	 if($play_v['play_id']==7 or $play_v['play_id']==8 or $play_v['play_id']==9 or $play_v['play_id']==10){
	 	//$kid
	 	$arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
		$arr_online_config[$kid]['pay_mkey'] = $play_v['play_key'];
		$arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';
		$arr_online_config[$kid]['notice_url'] = $play_v['site'].'member/pay/rxpay/notify.php';
		$arr_online_config[$kid]['return_url'] = $play_v['site'].'member/pay/rxpay/success.html';
		$arr_online_config[$kid]['merchant_url'] = $play_v['merchant_url'];
		//
		$arr_online_config[$kid]['online_name'] = '微信扫码';
		//$arr_online_config['仁信微信']['pay_mid'] = '20494';
		//$arr_online_config['仁信微信']['pay_mkey'] = '20708b523009a8c6f9d2a3bff3aa3efa';
		//$arr_online_config['仁信微信']['pay_url'] = 'http://pay.yikmf.top/member/';
		$arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/rxpay.php';
		$arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/rxpay/redirect.php?S_Type=WECHAT';
		//仁信QQ
		if($play_v['play_id']==8){
		    $arr_online_config[$kid] = $arr_online_config[$kid];
		    $arr_online_config[$kid]['online_name'] = 'QQ扫码';
		    $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/rxpay/redirect.php?S_Type=QQ';
		    
		}
		//仁信支付宝
		if($play_v['play_id']==9){
		    $arr_online_config[$kid] = $arr_online_config['仁信微信'];
		    $arr_online_config[$kid]['online_name'] = '支付宝扫码';
		    $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/rxpay/redirect.php?S_Type=ALIPAY';
		}
		//仁信网银
		if($play_v['play_id']==10){
		    $arr_online_config[$kid] = $arr_online_config[$kid];
		    $arr_online_config[$kid]['online_name'] = '网银充值';
		    $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/rxpay/online.php';
		    
		}
		
	 }
	 
	 //迅捷通
	     
	     if($play_v['play_id']==12){
	         $arr_online_config[$kid]['online_name'] = '微信扫码';
	         $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	         $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	         $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	         $arr_online_config[$kid]['type'] = 2;//微信
	         $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay.php';
	         $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay/get.php';
	         $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay/backpay.php';
	         $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay/backpay.php';
	     }
	     if($play_v['play_id']==13){
	         $arr_online_config[$kid]['online_name'] = '支付宝扫码';
	         $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	         $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	         $arr_online_config[$kid]['pay_mkey'] = $play_v['play_key'];//服务器私KEY
	         $arr_online_config[$kid]['type'] = 1;//微信
	         $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay.php';
	         $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay/get.php';
	         $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay/backpay.php';
	         $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay/backpay.php';
	     }
	       //迅捷通
	     if($play_v['play_id']==26){
	         $arr_online_config[$kid]['online_name'] = '支付宝wap';
	         $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	         $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	         $arr_online_config[$kid]['pay_mkey'] = $play_v['play_key'];//服务器私KEY
	         $arr_online_config[$kid]['type'] = 1;//微信
	         $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay.php';
	         $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay/wapplay.php';
	         $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay/backpay.php';
	         $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay/backpay.php';
	     }
	     if($play_v['play_id']==14){
	         $arr_online_config[$kid]['online_name'] = 'QQ扫码';
	         $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	         $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	         $arr_online_config[$kid]['pay_mkey'] = $play_v['play_key'];//服务器私KEY
	         $arr_online_config[$kid]['type'] = 4;//
	         $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay.php';
	         $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay/get.php';
	         $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay/backpay.php';
	         $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/xjtpay/backpay.php';
	     }
	     
	 //W付微信
	 if($play_v['play_id']==15 or $play_v['play_id']==16 or $play_v['play_id']==17 or $play_v['play_id']==18 ){
	     $merchant_private_key='-----BEGIN PRIVATE KEY-----
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALkQxT8gMTsWqv1G
xzSNXZrXYAhEcJBMDU0xId8dxHToIa7VQLewIsYUXtQOJ/vZ27i6iZwiwwXQd0hg
4sGMzzM/T2Zo4hkNCKcq7Wdx32Nzm0ADJe8rvZFXilCe4eEUxg/MwGWL/GMHGYgh
lWdEn8BbFbCRzu0W9gq4zTpLG2jBAgMBAAECgYEAsLw2UrmwqkhUlTqRpTtX6DbE
zEBn6zXmAhDo0wW/hxHkkO2xN3rrSpVLlmHKh3cfoYPrRQPhkVzrfWChTMvnVt5d
VlqWHd1xBq38VdOsbYlXDb06wHDBx773LG1LDuTXurjRZUWZF4V3LkAwon6ZTNTH
ftgwI113nMvoSB0Auy0CQQDk48dcGy9qG1pYaNVGo9pV18/QfCxhJpWeCflikVlh
41h08YeU7HyQ9DrouEhuuUN5ALxbZXbNhtUQNGmSKqhXAkEAzvwvppZCvMUbtcE3
/WdarQYkhaD/KYZe2aKWWNzom1GdRfMGZdWUha+d1AnFgq8UKrhjRQ4qBlMpSp0X
/JYopwJAZGgbUydFxGkdV70dGfDU3WVfb1iZa0Cuz3YWpQuXxx4g9qPhUw3ukvPg
R6hXdeLlW1ZcSkeXNw+XtZUYXptB3wJADMtT2rVBDNAWRWbbIiPIXBecHFJ2U0fG
ByfgqT+GdUtXMGK0S4knNBhF5jxwZAKUeYuKP1N/z4JGdCE/wVI60wJBALZU9GMX
Xk/cYgti1wYpqjFSCgYfQFrydiV8hZ7WQFaYXJwnZJD8/kJPZvbCUrbLXQAyEjdg
8UQT+Cj9iCYKfSE=
-----END PRIVATE KEY-----';//服务器私KEY
	     
	 }
	     
	 if($play_v['play_id']==15){
$keys = trim($play_v['play_key']);
$keys = "-----BEGIN PUBLIC KEY-----
{$keys}
-----END PUBLIC KEY-----";
	     $arr_online_config[$kid]['pay_pubKey'] = $keys;
	 	 $arr_online_config[$kid]['pay_mkey'] = $merchant_private_key;//服务器私KEY
	     $arr_online_config[$kid]['online_name'] = '微信扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['type'] = 2;//
	     $arr_online_config[$kid]['service_type'] = 'weixin_scan';
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay/scan_pay.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay/offline_notify.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay/offline_notify.php';
	 }
	 //W付支付宝
	 if($play_v['play_id']==16){
$keys = trim($play_v['play_key']);
$keys = "-----BEGIN PUBLIC KEY-----
{$keys}
-----END PUBLIC KEY-----";
	     $arr_online_config[$kid]['pay_pubKey'] = $keys;
	 	 $arr_online_config[$kid]['pay_mkey'] = $merchant_private_key;//服务器私KEY
	     $arr_online_config[$kid]['online_name'] = '支付宝扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['type'] = 1;//
	     $arr_online_config[$kid]['service_type'] = 'alipay_scan';
	 
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay/scan_pay.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay/offline_notify.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay/offline_notify.php';
	 }
	 //W付网银
	 if($play_v['play_id']==17){
$keys = trim($play_v['play_key']);
$keys = "-----BEGIN PUBLIC KEY-----
{$keys}
-----END PUBLIC KEY-----";
	     $arr_online_config[$kid]['pay_pubKey'] = $keys;
	 	 $arr_online_config[$kid]['pay_mkey'] = $merchant_private_key;//服务器私KEY
	     $arr_online_config[$kid]['online_name'] = '网银';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['type'] = 1;//
	     //service_type  weixin_scan
	     $arr_online_config[$kid]['service_type'] = 'alipay_scan';
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupankpay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay/bank_pay.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay/bank_notify.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay/bank_notify.php';
	 }
	 //W付QQ扫码
	 if($play_v['play_id']==18){
$keys = trim($play_v['play_key']);
$keys = "-----BEGIN PUBLIC KEY-----
{$keys}
-----END PUBLIC KEY-----";
	     $arr_online_config[$kid]['pay_pubKey'] = $keys;
	     $arr_online_config[$kid]['pay_mkey'] = $merchant_private_key;//服务器私KEY
	     $arr_online_config[$kid]['online_name'] = 'QQ钱包扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['type'] = 4;//
	     $arr_online_config[$kid]['service_type'] = 'tenpay_scan';
	 
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay/scan_pay.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay/offline_notify.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/wfupay/offline_notify.php';
	 }
	 
    //轻易付微信
	 if($play_v['play_id']==19){
	     $arr_online_config[$kid]['online_name'] = '微信扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 2;//微信
	      $arr_online_config[$kid]['netway'] = 'WX';//#WX 或者 ZFB
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/qyfpay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/qyfpay/get.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/qyfpay/wxnotify.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/qyfpay/wxnotify.php';
	     $arr_online_config[$kid]['payUrl'] =  'http://wx.qyfpay.com:90/api/pay.action';
	 }
	 //轻易付支付宝
	 if($play_v['play_id']==20){
	     $arr_online_config[$kid]['online_name'] = '轻_微信扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 1;//微信
	     $arr_online_config[$kid]['netway'] = 'ZFB';//#WX 或者 ZFB
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/qyfpay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/qyfpay/get.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/qyfpay/zfbnotify.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/qyfpay/zfbnotify.php';
	     $arr_online_config[$kid]['payUrl'] =  'http://zfb.qyfpay.com:90/api/pay.action';
	 }

	 //轻易付QQ钱包
	 if($play_v['play_id']==25){
	     $arr_online_config[$kid]['online_name'] = 'QQ钱包扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 4;//微信
	     $arr_online_config[$kid]['netway'] = 'QQ';//#WX 或者 ZFB
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/qyfpay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/qyfpay/get.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/qyfpay/qqnotify.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/qyfpay/qqnotify.php';
	     $arr_online_config[$kid]['payUrl'] =  'http://zfb.qyfpay.com:90/api/pay.action';
	 }
	 //元宝网银
	 if($play_v['play_id']==21){
	     $arr_online_config[$kid]['online_name'] = '网银';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 1;//微信
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yumbaopanpay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbao/post.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbao/notice_url.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbao/notice_url.php';
	 }
	 
	 //元宝微信
	 if($play_v['play_id']==22){
	     $arr_online_config[$kid]['online_name'] = '微信扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 2;//微信
	     //banktype
	     $arr_online_config[$kid]['banktype'] = 'WEIXIN';//微信
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbaopay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbao/get_url.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbao/notice_url.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbao/notice_url.php';
	 }
	 
	 //元宝支付宝23
	 if($play_v['play_id']==23){
	     $arr_online_config[$kid]['online_name'] = '支付宝扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 1;//支付宝
	     $arr_online_config[$kid]['banktype'] = 'ALIPAY';//支付宝
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbaopay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbao/get_url.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbao/notice_url.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbao/notice_url.php';
	 }

	 //元宝QQ钱包24
	 if($play_v['play_id']==24){
	     $arr_online_config[$kid]['online_name'] = 'QQ钱包扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 4;//微信
	     $arr_online_config[$kid]['banktype'] = 'QQ';//支付宝
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbaopay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbao/get_url.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbao/notice_url.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/yunbao/notice_url.php';
	 }
//佰付通网银
	 if($play_v['play_id']==28){
	     $arr_online_config[$kid]['online_name'] = '网银支付';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 4;//微信
	     $arr_online_config[$kid]['banktype'] = 'QQ';//支付宝
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftwypay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay/baipost.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay/bainotice_url.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay/bainotice_url.php';
	 }
	 //佰付通微信
	 if($play_v['play_id']==29){
	     $arr_online_config[$kid]['online_name'] = '微信扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 2;//微信
	     $arr_online_config[$kid]['banktype'] = '2';// 微信 2 支付宝 4
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay/get_wx.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay/bainotice_url.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay/bainotice_url.php';
	 }
	 //佰付通支付宝
	 if($play_v['play_id']==30){
	     $arr_online_config[$kid]['online_name'] = '支付宝扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 1;//微信
	     $arr_online_config[$kid]['banktype'] = '4';// 微信 2 支付宝 4
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay/get_zfb.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay/bainotice_url.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay/bainotice_url.php';
	 }
	 //佰付通qq钱包
	 if($play_v['play_id']==31){
	     $arr_online_config[$kid]['online_name'] = 'QQ钱包扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/';//
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 4;//支付宝1 微信2 QQ 4
	     $arr_online_config[$kid]['banktype'] = '29';// 微信 2 支付宝 4
	     $arr_online_config[$kid]['input_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay/get_zfb.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay/bainotice_url.php';
	     $arr_online_config[$kid]['return_url'] = $arr_online_config[$kid]['pay_url'] . 'pay/baiftpay/bainotice_url.php';
	 }
	 //新码网银
	 if($play_v['play_id']==32){
	     $arr_online_config[$kid]['online_name'] = '新码网银';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 2;//支付宝1 微信2 QQ 4
	     $arr_online_config[$kid]['pay_name'] = '微信';
	     $arr_online_config[$kid]['pay_type'] = 'WECHAT';
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/pay/xmpay/';//
	     $arr_online_config[$kid]['advice_url'] = '/member/pay/xmpay/get.php';
	     $arr_online_config[$kid]['input_url'] ='/member/pay/quick.php';
	     $arr_online_config[$kid]['post_url'] ='/member/pay/quick_wap.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'notify.php';
	     $arr_online_config[$kid]['return_url'] =$arr_online_config[$kid]['pay_url'] . 'success.php';
	     $arr_online_config[$kid]['merchant_url'] = 'https://www.xinmapay.com:7301/jhpayment';
	     $arr_online_config[$kid]['online_name'] = '网银充值';
	     $arr_online_config[$kid]['input_url'] = '/member/pay/redirect.php';
	     $arr_online_config[$kid]['post_url'] = $arr_online_config[$kid]['pay_url'] . 'online.php';
	 }
	 
	 //新码微信
	 if($play_v['play_id']==33){
	     $arr_online_config[$kid]['online_name'] = '微信扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 2;//支付宝1 微信2 QQ 4
	     $arr_online_config[$kid]['pay_name'] = '微信';
	     $arr_online_config[$kid]['pay_type'] = 'WECHAT';
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/pay/xmpay/';//
	     $arr_online_config[$kid]['advice_url'] = '/member/pay/xmpay/get.php';
	     $arr_online_config[$kid]['input_url'] ='/member/pay/quick.php';
	     $arr_online_config[$kid]['post_url'] ='/member/pay/quick_wap.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'notify.php';
	     $arr_online_config[$kid]['return_url'] =$arr_online_config[$kid]['pay_url'] . 'success.php';
	     $arr_online_config[$kid]['merchant_url'] = 'https://www.xinmapay.com:7301/jhpayment';
	 
	 }
	 //新码支付宝
	 if($play_v['play_id']==34){
	     
	     $arr_online_config[$kid]['online_name'] = '支付宝扫码';
	     $arr_online_config[$kid]['pay_mid'] = $play_v['play_account'];
	     $arr_online_config[$kid]['pay_mkey'] = trim($play_v['play_key']);//
	     $arr_online_config[$kid]['type'] = 2;//支付宝1 微信2 QQ 4
	     $arr_online_config[$kid]['pay_name'] = '支付宝';
	     $arr_online_config[$kid]['pay_type'] = 'ALIPAY';
	     $arr_online_config[$kid]['pay_url'] = $play_v['site'].'member/pay/xmpay/';//
	     $arr_online_config[$kid]['advice_url'] = '/member/pay/xmpay/get.php';
	     $arr_online_config[$kid]['input_url'] ='/member/pay/quick.php';
	     $arr_online_config[$kid]['post_url'] ='/member/pay/quick_wap.php';
	     $arr_online_config[$kid]['notice_url'] = $arr_online_config[$kid]['pay_url'] . 'notify.php';
	     $arr_online_config[$kid]['return_url'] =$arr_online_config[$kid]['pay_url'] . 'success.php';
	     $arr_online_config[$kid]['merchant_url'] = 'https://www.xinmapay.com:7301/jhpayment';
	    
	 }
}
}

?>