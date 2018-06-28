<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once ("../include/function.php");
include_once $C_Patch."/class/user.php";

$callback = $_GET['callback'];
$uid=$_SESSION["uid"];
$typeName = '玛雅娱乐厅';
$str = typeName('MAYA');
$typeName = $str['title'];
$istype = $str['istype'];
$zzusername = $str['zzusername'];
$GameMemberID = $str['zzpassword'];
$data = array();

if(!empty($uid) && !empty($_SESSION["username"])){
  $userinfo = user::getinfo($uid);
  $client = new rpcclient($cj_url);

  if($userinfo[$istype] != 1){//如果没有注册
    $arr = $client->liveloginmaya($site_id,$userinfo['username']);
    if(is_array($arr) and $arr){
      if($arr['info']=='ok'){
        $params = array(':username'=>$userinfo['username'],':mayaUserName'=>$arr['username'],':mayaGameMemberID'=>$arr['GameMemberID'],':mayaVenderMemberID'=>$arr['VenderMemberID'],':uid'=>$uid);
        $sql = 'update  mydata1_db.k_user set mayaUserName=:mayaUserName,mayaGameMemberID=:mayaGameMemberID,mayaVenderMemberID=:mayaVenderMemberID,mayaAddtime=now(),ismaya=1 where ismaya=0 and username = :username and uid=:uid';
        $stmt = $mydata1_db->prepare($sql);
        $stmt -> execute($params);

        $userinfo = user::getinfo($uid);
      }else{
        $data['info'] = 'no';
        $data['msg']  = '注册'.$typeName.'失败!!<br><br>'.$arr['ErrorCode'];

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
  $arrUrl = $client->liveurlmaya2($site_id,$userinfo[$GameMemberID]);

  if(is_array($arrUrl) and $arrUrl){

    if($arrUrl['result'] == 'ok'){
      $data['info'] = 'ok';
      $url = $arrUrl['url'];
      preg_match('/VenderNo\=(.+?)\&/',$url,$res);
      $data['form'] = '<input name="VenderNo" type="hidden" value="'.$res[1].'">';
      preg_match('/DESDATA\=(.*?)$/', $url, $res);
      $data['form'] .= '<input name="DESDATA" type="hidden" value="'.$res[1].'">';
      $data['form'] .= '<input name="EntryType" type="hidden" value="1">';
      $data['url'] = $url;

      
      echo $callback.'('.json_encode($data).')';
      exit;
    }else{
      $data['info'] = 'no';
      $data['msg']  = '进入'.$typeName.'失败!!<br><br>请检查线路!!';
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