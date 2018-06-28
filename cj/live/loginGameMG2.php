<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once ("../include/function.php");
include_once $C_Patch."/class/user.php";

$callback = $_GET['callback'];
$uid=$_SESSION["uid"];
$typeName = '新MG电子游戏';
$str = typeName('MG2');
$typeName = $str['title'];
$istype = $str['istype'];
$zzusername = $str['zzusername'];
$zzpassword = $str['zzpassword'];
$gameId = $_GET['gameId'];
$data = array();
$appId = 1001;
if(isset($_GET['mobile']) && $_GET['mobile']==1){
  $appId = 1002;
}
if($gameId == '1054'){
    $data['info'] = 'no';
    $data['msg']  = '进入'.$typeName.'失败!!<br>该游戏已关闭';
    echo $callback.'('.json_encode($data).')';
    exit;
}
/* 2016/11/20 增加AG试玩 */
if(isset($_REQUEST['try'])){

  $client = new rpcclient($cj_url);
  $arrUrl = $client->livetrymg2($site_id,$gameId,$appId);
  if(is_array($arrUrl) and $arrUrl){

    if($arrUrl['info'] == 'ok'){
      $data['info'] = 'ok';
      $data['msg']  = $arrUrl['loginurl'];
    }else{
      $data['info'] = 'no';
      $data['msg']  = $arrUrl['msg']['message'];
    }
  }
  echo $callback.'('.json_encode($data).')';
  exit;
}

if(!empty($uid) && !empty($_SESSION["username"])){
  $userinfo = user::getinfo($uid);
  $client = new rpcclient($cj_url);

  if($userinfo[$istype] != 1){//如果没有注册
    $arr = $client->liveregmg2($site_id,$userinfo['username']);
    if(is_array($arr) and $arr){
      if($arr['info']=='ok'){
        $params = array(':username'=>$userinfo['username'],':mg2UserName'=>$arr['username'],':mg2PassWord'=>$arr['password'],':uid'=>$uid);
        $sql = 'update  mydata1_db.k_user set mg2UserName=:mg2UserName,mg2Addtime=now(),ismg2=1,mg2PassWord=:mg2PassWord where ismg2=0 and username = :username and uid=:uid';
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
  $arrUrl = $client->liveloginmg2($site_id,$userinfo[$zzusername],$gameId,$appId);

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