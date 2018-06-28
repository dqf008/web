<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once __DIR__ . "/../include/function.php";
include_once $C_Patch."/class/user.php";

$callback = $_GET['callback'];
if(!empty($_SESSION['adminid']) && !empty($_REQUEST["uid"])){
  $uid = (int)$_REQUEST["uid"];
}else{
  $uid = $_SESSION["uid"];
}
$typeName = '新MG电子';
$data = array();
if(!check_game('MG2')){
    die($callback.'('.json_encode(['info'=>'no','msg'=>'<font color=red>维护中</font>']).')');
}
if(!empty($uid)){
  $userinfo = user::getinfo($uid);
  $client = new rpcclient($cj_url);

  $session = '';
  $account = '';
  if($userinfo['ismg2'] != 1){//如果没有注册
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
  

  $arrUrl = $client->livebalancemg2($site_id,$userinfo['mg2UserName'],$userinfo['mg2PassWord']);
  if(is_array($arrUrl) and $arrUrl){

    if($arrUrl['info'] == 'ok'){
      $data['info'] = 'ok';
      $data['msg']  = sprintf("%.2f",$arrUrl['money']);
      $data['name'] = $userinfo['mg2UserName'];
      $params = array();
      $params[':uid']=$userinfo['uid'];
      $params[':mg2money'] = $data['msg'];
      $sql = 'update  mydata1_db.k_user set mg2money=:mg2money,mg2Addtime=now() where ismg2=1 and uid=:uid';
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