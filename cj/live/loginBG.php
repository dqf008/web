<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once ("../include/function.php");
include_once $C_Patch."/class/user.php";

$callback = $_GET['callback'];
$uid=$_SESSION["uid"];
$typeName = 'BG视讯';
$zzusername = $str['zzusername'];
$zzpassword = $str['zzpassword'];
$mobile = (int)$_GET['mobile'];
$type = $_GET['type'];
$data = array();
if(!empty($uid) && !empty($_SESSION["username"])){
  $userinfo = user::getinfo($uid);
  $client = new rpcclient($cj_url);
  if($userinfo['isbg'] != 1){//如果没有注册
  	//echo $site_id,$userinfo['username'];
    $arr = $client->liveregbg($site_id,$userinfo['username']);
    if(is_array($arr) and $arr){
      if($arr['info']=='ok'){
        $params = array(':username'=>$userinfo['username'],':bgUserName'=>$arr['username'],':uid'=>$uid);
        $sql = 'update  mydata1_db.k_user set bgUserName=:bgUserName,bgAddtime=now(),isbg=1,bgPassWord="" where isbg=0 and username = :username and uid=:uid';
        $stmt = $mydata1_db->prepare($sql);
        $stmt -> execute($params);

        $userinfo = user::getinfo($uid);
      }else{
        $data['info'] = 'no';
        $data['msg']  = '注册BG视讯失败!!<br><br>'.$arr['msg'];
        echo $callback.'('.json_encode($data).')';
        exit;
      }
    }else{
      $data['info'] = 'no';
      $data['msg']  = '注册BG视讯失败!!<br><br>请检查线路!!';
      echo $callback.'('.json_encode($data).')';
      exit;
    } 
  }

  //进入游戏
  if($type == 'fish') $arrUrl = $client->liveloginbg($site_id,$userinfo['bgUserName'],'fish',$mobile);
  else $arrUrl = $client->liveloginbg($site_id,$userinfo['bgUserName'],'live',$mobile);
  //echo $type;print_r($arrUrl);exit;
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