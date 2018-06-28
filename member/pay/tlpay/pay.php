<?php 
  
  if(
    $_SERVER['REQUEST_METHOD']!='POST'||
    (!isset($_POST['S_Name'])||empty($_POST['S_Name']))
){
    exit('Access Denied1');
}

$pay_online = $_POST['pay_online'];
include('./config.php'); 
include("../moneyconfig.php");
include("../../../cache/website.php");
include("../../../database/mysql.config.php");
include_once '../moneyfunc.php';
$query = $mydata1_db->prepare('SELECT uid,username FROM `k_user` WHERE `username`=:username');
$query->execute(array(':username' => $_POST['S_Name']));
if($query->rowCount()>0){
    $rows = $query->fetch();
}else{
    exit('Access Denied');
}

(!isset($_POST['MOAmount'])||!preg_match('/^\d+(\.\d+)?$/', $_POST['MOAmount']))&&$_POST['MOAmount'] = $web_site['ck_limit'];
$_POST['MOAmount'] = number_format($_POST['MOAmount']<$web_site['ck_limit']?$web_site['ck_limit']:$_POST['MOAmount'], 2, '.', '');

  $_payId = generate_id('TL', $rows['uid']); //商户流水号
  include('AppUtil.php');
  include('AppConfig.php');
  $params['appid'] = $pay_mid;
  $params['c']     = 'XODlLM';// XODlLM
  $params['oid']   = $_payId;
  $AppUtil = new AppUtil();
  $params['amt']   = $_POST['MOAmount'] * 100; 
  $params['sign']  =$AppUtil->SignArray($params,$pay_mkey);
  $merchant_url  = $merchant_url;

  $stmt = $mydata1_db->prepare('INSERT INTO `k_money_order` (`uid`, `username`, `mid`, `did`, `pay_online`, `amount`, `status`) VALUES (:uid, :username, :mid, :did, :pay_online, :amount, 0)');
$stmt->execute(array(
	':uid' => $rows['uid'],
	':username' => $rows['username'],
	':mid' => $_payId,
	':did' => '',
	':pay_online' => $pay_online,
	':amount' => $_POST['MOAmount'] / 100,
));

if($AppUtil->isMobile()){
      $qrcode =  $merchant_url."?".$AppUtil->ToUrlParams($params).""."&sign=".$params['sign'];
      $qrcode = base64_encode($qrcode);
      $url = "/member/pay/qrcodex.php?s={$qrcode}&k=2";
      echo "<div align='center'><img  src='{$url}' width='320'/></div>";
}else{
   $data['status'] ='success';
   $data['message'] = $merchant_url."?".$AppUtil->ToUrlParams($params).""."&sign=".$params['sign'];
   echo isset($_GET['callback'])&&!empty($_GET['callback'])?$_GET['callback']:'callback';
   echo '('.json_encode($data).')';
   
}

?>