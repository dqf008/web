<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once ("../include/function.php");
include_once $C_Patch."/class/user.php";

$callback = $_GET['callback'];
$uid=$_SESSION["uid"];
$fo= $_REQUEST['fo'];
$gameTypes = $_REQUEST['gameType'];
$type = $_REQUEST['type'];
$str = typeName($type);
$typeName = $str['title'];
$istype = $str['istype'];
$zzusername = $str['zzusername'];
$zzpassword = $str['zzpassword'];
$data = array();


if($gameTypes == 'SBTA') $gameTypes = 'TASSPTA'; //AG体育

/* 2016/11/20 增加AG试玩 */
if($type=='AGIN'&&isset($_REQUEST['try'])){
  if(isset($_SERVER['HTTP_CLIENT_IP'])){
    $client_ip = $_SERVER['HTTP_CLIENT_IP'];
  }elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
    $client_ip = $_SERVER['REMOTE_ADDR'];
  }

  $client = new rpcclient($cj_url);
  $arrUrl = $client->agintry($site_id,$client_ip,$_SERVER['HTTP_HOST'],$gameTypes);
  
  //'暂时不能进行试玩，请稍候重试';
  if(is_array($arrUrl) and $arrUrl){

    if($arrUrl['result'] == 'ok'){
      $data['info'] = 'ok';
      $data['msg']  = $arrUrl['url'];
    }
  }
  echo $callback.'('.json_encode($data).')';
  exit;
}

if(!empty($uid) && !empty($_SESSION["username"])){
  $userinfo = user::getinfo($uid);
  $client = new rpcclient($cj_url);

  if($userinfo[$istype] != 1){//如果没有注册
    $arr = $client->livereg($site_id,$userinfo['username'],$type);

    if(is_array($arr) and $arr){
      if($arr['info']=='ok'){
        $zzType = $arr['msg'][2];
        $zz_username = $arr['msg'][0];
        $zz_password = $arr['msg'][1];

        $par = zzType($zzType,$zz_username,$zz_password);
        $params = $par['params'];
        $params[':uid']=$userinfo['uid'];
        $sql = 'update  mydata1_db.k_user set '.$par['strsql'].' where '.$par['where'].' and uid=:uid';
        //print_r($sql);exit;
        $stmt = $mydata1_db->prepare($sql);
        $stmt -> execute($params);
  

        $userinfo = user::getinfo($uid);
      }else{
        $data['info'] = 'no';
        $data['msg']  = '注册'.$typeName.'失败!!<br><br>'.$arr['info'][0].' => '.$arr['msg'][0];

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


  $arrUrl = $client->liveurl($site_id,$userinfo[$zzusername],$userinfo[$zzpassword],$type,$gameTypes,$_SERVER['HTTP_HOST'],isset($_REQUEST['mobile'])?'mobile':'');

  if(is_array($arrUrl) and $arrUrl){

    if($arrUrl['result'] == 'ok'){
      $data['info'] = 'ok';
      $data['msg']  = $arrUrl['url'];
      echo $callback.'('.json_encode($data).')';
      exit;
    }else{
      $data['info'] = 'no';
      $data['msg']  = '进入'.$typeName.'失败!!<br><br>请检查线路!!!';
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