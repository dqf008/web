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
$typeName = '玛雅娱乐厅';
$data = array();
if(!check_game('MAYA')){
    die($callback.'('.json_encode(['info'=>'no','msg'=>'<font color=red>维护中</font>']).')');
}
if(!empty($uid)){
  $userinfo = user::getinfo($uid);
  $client = new rpcclient($cj_url);
  $session = '';
  $account = '';
  if($userinfo['ismaya'] != 1){//如果没有注册
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
        $data['msg']  = '<font color=red>--</font>';

        echo $callback.'('.json_encode($data).')';
        exit;
      }
    }else{
      $data['info'] = 'no';
      $data['msg']  = '<font color=red>--</font>';
      echo $callback.'('.json_encode($data).')';
      exit;
    }
  }
  

  $arrUrl = $client->livebalancemaya($site_id,$userinfo['mayaGameMemberID']);

  if(is_array($arrUrl) and $arrUrl){

    if($arrUrl['info'] == 'ok'){
      $data['info'] = 'ok';
      $data['msg']  = sprintf("%.2f",$arrUrl['balance']);
      $data['name'] = $userinfo['mayaUserName'];
      $params = array();
      $params[':uid']=$userinfo['uid'];
      $params[':mayamoney'] = $data['msg'];
      $sql = 'update  mydata1_db.k_user set mayamoney=:mayamoney,mayaAddtime=now() where ismaya=1 and uid=:uid';
      $stmt = $mydata1_db->prepare($sql);
      $stmt -> execute($params);
      echo $callback.'('.json_encode($data).')';
      exit;
    }else{
      $data['info'] = 'no';
      $data['msg']  = '<font color=red>--</font>';
      echo $callback.'('.json_encode($data).')';
      exit;
    }

  }else{
    $data['info'] = 'no';
    $data['msg']  = '<font color=red>--</font>';
    echo $callback.'('.json_encode($data).')';
    exit;
  }

}else{
  $data['info'] = 'no';
  $data['msg'] = '<font color=red>--</font>';

  echo $callback.'('.json_encode($data).')';
  exit;
}


?>