<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once ("../include/function.php");
include_once $C_Patch."/class/user.php";

$callback = $_GET['callback'];
$uid=$_SESSION["uid"];
$type = $_GET['type'];
$type || $type = 'game';
$typeName = '新BB波音厅';
$code = $_GET['gameId'];
//echo $code;die();
$data = array();
if(!empty($uid) && !empty($_SESSION["username"])){
  $userinfo = user::getinfo($uid);
  $client = new rpcclient($cj_url);
  if($userinfo['isbbin2'] != 1){//如果没有注册
    $arr = $client->liveregbbin($site_id,$userinfo['username']);
    if(is_array($arr) and $arr){
      if($arr['info']=='ok'){
        $params = array(':username'=>$userinfo['username'],':bbin2UserName'=>$arr['username'],':bbin2PassWord'=>$arr['password'],':uid'=>$uid);
        $sql = 'update  mydata1_db.k_user set bbin2UserName=:bbin2UserName,bbin2Addtime=now(),isbbin2=1,bbin2PassWord=:bbin2PassWord where isbbin2=0 and username = :username and uid=:uid';
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
  $arrUrl = $client->liveloginbbin($site_id,$userinfo['bbin2UserName'],$type,$code);
  if(is_array($arrUrl) and $arrUrl){
    if($arrUrl['info'] == 'ok'){
      $data['info'] = 'ok';
      if($type == 'game'){
        $data['msg']  = $arrUrl['loginurl'];
      }else{
        $str = $arrUrl['loginurl'];
        preg_match('/action=\'(?<action>.+?)\'/', $str, $matches);
        $data['url'] = $matches['action'];
        preg_match('/<form.+?>(?<input>.+?)<\/form>/', $str, $matches);
        $data['form'] = $matches['input'];
      }
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