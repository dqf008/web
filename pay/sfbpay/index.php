<?php
	defined('PAY') or die('Access Denied');

	include 'conf.php';
	$pay_memberid = $conf['id'];
	$md5Key = $conf['key'];
	$noticeUrl = $conf['notice_url'];
	//$ext = $rows['uid']."||".$_REQUEST['pay_online'];

	//echo $ext;
	if($_REQUEST['S_Type']=='WECHAT'){
	$payChannel='902';
	}
	if($_REQUEST['S_Type']=='WXWAP'){
	$payChannel='913';
	}  
	if($_REQUEST['S_Type']=='ALIPAY'){
	$payChannel='903';
	}
	if($_REQUEST['S_Type']=='ALIWAP'){
	$payChannel='904';
	}  
	if($_REQUEST['S_Type']=='QQPAY'){
	$payChannel='908';
	}
	if($_REQUEST['S_Type']=='UNIONPAY'){
	$payChannel='914';
	}
	if($_REQUEST['S_Type']=='JDPAY'){
	$payChannel='910';
	}

	$payChannel='902';

	$Pay = new Pay();
	$orderId = $Pay->generate_id('SFB');
	$pay_orderid = $orderId;

	$pay_amount = $money;    //交易金额
	$pay_applydate = date("Y-m-d H:i:s");  //订单时间
	$pay_notifyurl = $conf['notice_url'];//服务端返回地址
	$pay_callbackurl = $conf['notice_url'];  //页面跳转返回地址

	$Md5key = $conf['key'];
	//$tjurl = "https://pay.17588.com/Pay_Index.html";   
	$url ="http://dp.sf532.com/Pay_Index.html";//提交地址

	$pay_bankcode = $payChannel;   //编码  902:微信扫码;903:支付宝扫码 908:QQ扫码
	//扫码
	$native = array(
	    "pay_memberid" => $pay_memberid,
	    "pay_orderid" => $pay_orderid,
	    "pay_amount" => $pay_amount,
	    "pay_applydate" => $pay_applydate,
	    "pay_bankcode" => $pay_bankcode,
	    "pay_notifyurl" => $pay_notifyurl,
	    "pay_callbackurl" => $pay_callbackurl,
	);
	ksort($native);
	$md5str = "";
	foreach ($native as $key => $val) {
	    $md5str = $md5str . $key . "=" . $val . "&";
	}
	$sign = strtoupper(md5($md5str . "key=" . $Md5key));
	$native["pay_md5sign"] = $sign;
	//$native['pay_attach'] =   $ext;//
	$native['pay_productname'] ='VIP基础服务';
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL,$url );
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_HEADER, 0 );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $native );
	$return = curl_exec ( $ch );
	curl_close ( $ch );
	$res = json_decode($return,true);
	if($res['returncode']=='00'){
		$Pay->add_order($_SESSION['uid'], $orderId, $money, '神付宝');
	    $data = array();
	    $data['status'] = 1;
	    $data['message'] = $res['url'];
	    echo '<img src="/pay/qrcodex.php?s='.$res['url'].'">';
	    exit;
	}else{
	    $data['status'] ='error';
	    $data['message'] = $res;
	    print_r($res);
	    echo $money;
	}
	echo json_encode($data);
	//$Pay->add_order($_SESSION['uid'], $orderId, $money, '神付宝');