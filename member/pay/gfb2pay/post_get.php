<?php
require_once("HttpClient.class.php");
$http = $merchant_url;
$version = '2.1';
$charset = '2';
$language = '1';
$signType = "1";
$tranCode = '8888'; //银行编码 
$pay_mid = explode('|', $pay_mid);
$merchantID = $pay_mid[0]; //商户号  0000001502 0000011811
//注意调试生产环境时需要修改这个值为生产参数 //0000011811
$merOrderNum = $_payId;
$tranAmt = $amount; //金额          
$feeAmt = "0"; //商户提取佣金金额:           
$currencyType = "156"; //币种:
$frontMerUrl = $notice_url; //商户前台通知地址     
$backgroundMerUrl = $notice_url; //商户后台通知地址
$tranDateTime = date('Ymdhis'); //时间    //0000000002000004384
$virCardNoIn = $pay_mid[1];
//注意调试生产环境时需要修改这个值为生产参数
$tranIP = $_SERVER['REMOTE_ADDR'];
$isRepeatSubmit = $_POST["isRepeatSubmit"];
$goodsName = $_POST["goodsName"];
$goodsDetail = $_POST["goodsDetail"];
$buyerName = $_POST["buyerName"];
$buyerContact = $_POST["buyerContact"];
$merRemark1 = $_POST["merRemark1"];
$merRemark2 = $_POST["merRemark2"];
$bankCode = $_POST["bankCode"];
$userType = $_POST["userType"];
$gopayServerTime = HttpClient::getGopayServerTime();
$signStr = 'version=[' . $version . ']tranCode=[' . $tranCode . ']merchantID=[' . $merchantID . ']merOrderNum=[' . $merOrderNum . ']tranAmt=[' . $tranAmt . ']feeAmt=[' . $feeAmt . ']tranDateTime=[' . $tranDateTime . ']frontMerUrl=[' . $frontMerUrl . ']backgroundMerUrl=[' . $backgroundMerUrl . ']orderId=[]gopayOutOrderId=[]tranIP=[' . $tranIP . ']respCode=[]gopayServerTime=[' . $gopayServerTime . ']VerficationCode=[' . $pay_mkey . ']';
//VerficationCode是商户识别码为用户重要信息请妥善保存
//注意调试生产环境时需要修改这个值为生产参数
$signValue = md5($signStr);
//echo 'md5明文串;'; 
// "$signStr"; 		
?>
<html>
<head>    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body  onLoad="document.dinpayForm.submit();">
<h3>正在跳转</h3>
<form action="<?echo "$http"; ?>" name="dinpayForm" id= "returnfunc" method="POST">
<input type="hidden" id="version" name="version" value="<?echo "$version"; ?>" size="50"/>
<input type="hidden" id="charset" name="charset" value="<?echo "$charset"; ?>" size="50"/>
<input type="hidden" id="language" name="language" value="<?echo "$language"; ?>" size="50"/>
<input type="hidden" id="signType" name="signType" value="<?echo "$signType"; ?>" size="50"/>
<input type="hidden" id="tranCode" name="tranCode" value="<?echo "$tranCode"; ?>" size="50"/>
<input type="hidden" id="merchantID" name="merchantID" value="<?echo "$merchantID"; ?>" size="50"/>
<input type="hidden" id="merOrderNum" name="merOrderNum" value="<?echo "$merOrderNum"; ?>" size="50" />
<input type="hidden" id="tranAmt" name="tranAmt" value="<?echo "$tranAmt"; ?>" size="50"/>
<input type="hidden" id="feeAmt" name="feeAmt" value="<?echo "$feeAmt"; ?>" size="50"/>
<input type="hidden" id="currencyType" name="currencyType" value="<?echo "$currencyType"; ?>" size="50"/>
<input type="hidden" id="frontMerUrl" name="frontMerUrl" value="<?echo "$frontMerUrl"; ?>" size="50"/>
<input type="hidden" id="backgroundMerUrl" name="backgroundMerUrl" value="<?echo "$backgroundMerUrl"; ?>" size="50"/>
<input type="hidden" id="tranDateTime" name="tranDateTime" value="<?echo "$tranDateTime"; ?>" size="50"/>
<input type="hidden" id="virCardNoIn" name="virCardNoIn" value="<?echo "$virCardNoIn"; ?>" size="50"/>
<input type="hidden" id="tranIP" name="tranIP" value="<?echo "$tranIP"; ?>" size="50"/>
<input type="hidden" id="isRepeatSubmit" name="isRepeatSubmit" value="<?echo "$isRepeatSubmit"; ?>" size="50"/>
<input type="hidden" id="goodsName" name="goodsName" value="<?echo "$goodsName"; ?>" size="50"/>
<input type="hidden" id="goodsDetail" name="goodsDetail" value="<?echo "$goodsDetail"; ?>" size="50"/>
<input type="hidden" id="buyerName" name="buyerName" value="<?echo "$buyerName"; ?>" size="50"/>
<input type="hidden" id="buyerContact" name="buyerContact" value="<?echo "$buyerContact"; ?>" size="50"/>
<input type="hidden" id="merRemark1" name="merRemark1" value="<?echo "$merRemark1"; ?>" size="50"/>
<input type="hidden" id="merRemark2" name="merRemark2" value="<?echo "$merRemark2"; ?>" size="50"/>
<input type="hidden" id="signValue" name="signValue" value="<?echo "$signValue"; ?>" size="50"/>
<input type="hidden" id="bankCode" name="bankCode" value="<?echo "$bankCode"; ?>" size="50"/>
<input type="hidden" id="userType" name="userType" value="<?echo "$userType"; ?>" size="50"/>
<input type="hidden" id="gopayServerTime" name="gopayServerTime" value="<?echo "$gopayServerTime"; ?>" size="50"/>
</body>	
</form>
<html>