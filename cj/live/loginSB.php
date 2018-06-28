<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once ("../include/function.php");
include_once $C_Patch."/class/user.php";

$callback = $_GET['callback'];
$uid=$_SESSION["uid"];
$zzusername = $str['zzusername'];
$zzpassword = $str['zzpassword'];
$mobile = (int)$_GET['mobile'];
$code = $_GET['gameId'];
$type = $_GET['type'];
$data = array();
$typeName = '申博视讯';
if(!empty($uid) && !empty($_SESSION["username"])){
  $userinfo = user::getinfo($uid);
  $client = new rpcclient($cj_url);
  if($userinfo['issb'] != 1){
    $arr = $client->liveregsb($site_id,$userinfo['username']);
    if(is_array($arr) and $arr){
      if($arr['info']=='ok'){
        $params = array(':username'=>$userinfo['username'],':sbUserName'=>$arr['username'],':uid'=>$uid);
        $sql = 'update  mydata1_db.k_user set sbUserName=:sbUserName,sbAddtime=now(),issb=1,sbPassWord="" where issb=0 and username = :username and uid=:uid';
        $stmt = $mydata1_db->prepare($sql);
        $stmt -> execute($params);

        $userinfo = user::getinfo($uid);
      }else{
        $data['info'] = 'no';
        $data['msg']  = '注册申博失败!!<br><br>'.$arr['msg'];
        echo $callback.'('.json_encode($data).')';
        exit;
      }
    }else{
      $data['info'] = 'no';
      $data['msg']  = '注册申博失败!!<br><br>请检查线路!!';
      echo $callback.'('.json_encode($data).')';
      exit;
    } 
  }

	$typeName = '申博视讯';
	$arrUrl = $client->liveloginsb($site_id,$userinfo['sbUserName'],'SB','Sunbet_Lobby',$mobile);
  //print_r($arrUrl);exit;
  if(is_array($arrUrl) and $arrUrl){

    if($arrUrl['info'] == 'ok'){
      $data['info'] = 'ok';
      $data['msg']  = $arrUrl['loginurl'];
      echo $callback.'('.json_encode($data).')';
      exit;
    }else{
      $data['info'] = 'no';
      $data['msg']  = '进入'.$typeName.'失败!!<br><br>'.$arrUrl['msg'].'!!';
      echo $callback.'('.json_encode($data).')';
      exit;
    }

  }else{
    $data['info'] = 'no';
    $data['msg']  = '进入'.$typeName.'失败!!<br><br>请检查线路!!';
    echo $callback.'('.json_encode($data).')';
    exit;
  }
}else{
  $data['info'] = 'no';
  $data['msg'] = '请您先登陆!!';

  echo $callback.'('.json_encode($data).')';
  exit;
}


?>