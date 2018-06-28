<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once ("../include/function.php");
include_once $C_Patch."/class/user.php";

$callback = $_GET['callback'];
$uid=$_SESSION["uid"];
$typeName = '开元棋牌';
$code = $_GET['gameId'];
$data = array();
if(!empty($uid) && !empty($_SESSION["username"])){
  $userinfo = user::getinfo($uid);
  $client = new rpcclient($cj_url);
  if($userinfo['isky'] != 1){//如果没有注册
    $arr = $client->liveregky($site_id,$userinfo['username']);
    if(is_array($arr) and $arr){
      if($arr['info']=='ok'){
        $params = array(':username'=>$userinfo['username'],':kyUserName'=>$arr['username'],':kyPassWord'=>$arr['password'],':uid'=>$uid);
        $sql = 'update  mydata1_db.k_user set kyUserName=:kyUserName,kyAddtime=now(),isky=1,kyPassWord=:kyPassWord where isky=0 and username = :username and uid=:uid';
        $stmt = $mydata1_db->prepare($sql);
        $stmt -> execute($params);

        $userinfo = user::getinfo($uid);
      }else{
        $data['info'] = 'no';
        $data['msg']  = '注册'.$typeName.'失败!!<br><br>'.$arr['msg'];
        echo $callback.'('.json_encode($data).')';
        exit;
      }
    }else{
      $data['info'] = 'no';
      $data['msg']  = '注册'.$typeName.'失败!!<br><br>请检查线路!!';
      echo $callback.'('.json_encode($data).')';
      exit;
    } 
  }

  //进入游戏
  $arrUrl = $client->liveloginky($site_id,$userinfo['kyUserName'],$code);
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