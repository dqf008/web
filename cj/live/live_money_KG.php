<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once ("../include/function.php");
include_once $C_Patch."/class/user.php";

$callback = $_GET['callback'];
if(!empty($_SESSION['adminid']) && !empty($_REQUEST["uid"])){
  $uid = (int)$_REQUEST["uid"];
}else{
  $uid = $_SESSION["uid"];
}
$typeName = '女优电子';
$data = array();
if(!check_game('KG')){
    die($callback.'('.json_encode(['info'=>'no','msg'=>'<font color=red>维护中</font>']).')');
}
if(!empty($uid)){
  $userinfo = user::getinfo($uid);
  $client = new rpcclient($cj_url);

  $session = '';
  $account = '';
  if($userinfo['iskg'] != 1){//如果没有注册
    $arr = $client->liveregkg($site_id,$userinfo['username']);
    if(is_array($arr) and $arr){
      if($arr['info']=='ok'){
        $params = array(':username'=>$userinfo['username'],':kgUserName'=>$arr['username'],':kgPassWord'=>$arr['password'],':uid'=>$uid);
        $sql = 'update  mydata1_db.k_user set kgUserName=:kgUserName,kgAddtime=now(),iskg=1,kgPassWord=:kgPassWord where iskg=0 and username = :username and uid=:uid';
        $stmt = $mydata1_db->prepare($sql);
        $stmt -> execute($params);

        $userinfo = user::getinfo($uid);
      }else{
        $data['info'] = 'no';
        $data['msg']  = '<font color=red>&nbsp;--&nbsp;</font>';

        echo $callback.'('.json_encode($data).')';
        exit;
      }
    }else{
      $data['info'] = 'no';
      $data['msg']  = '<font color=red>&nbsp;---&nbsp;</font>';
      echo $callback.'('.json_encode($data).')';
      exit;
    }
  }
  

  $arrUrl = $client->livebalancekg($site_id,$userinfo['kgUserName'],$userinfo['kgPassWord']);
  if(is_array($arrUrl) and $arrUrl){

    if($arrUrl['info'] == 'ok'){
      $data['info'] = 'ok';
      $data['name'] = $userinfo['kgUserName'];
      $data['msg']  = sprintf("%.2f",$arrUrl['money']);
      $params = array();
      $params[':uid']=$userinfo['uid'];
      $params[':kgmoney'] = $data['msg'];
      $sql = 'update  mydata1_db.k_user set kgmoney=:kgmoney,kgAddtime=now() where iskg=1 and uid=:uid';
      $stmt = $mydata1_db->prepare($sql);
      $stmt -> execute($params);
      echo $callback.'('.json_encode($data).')';
      exit;
    }else{
      $data['info'] = 'no';
      $data['msg']  = $arrUrl['msg'];//'<font color=red>&nbsp;-a&nbsp;</font>';
      echo $callback.'('.json_encode($data).')';
      exit;
    }

  }else{
    $data['info'] = 'no';
    $data['msg']  = '<font color=red>&nbsp;-b&nbsp;</font>';
    echo $callback.'('.json_encode($data).')';
    exit;
  }

}else{
  $data['info'] = 'no';
  $data['msg'] = '<font color=red>&nbsp;-c&nbsp;</font>';

  echo $callback.'('.json_encode($data).')';
  exit;
}


?>