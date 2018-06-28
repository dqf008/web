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
$type = $_REQUEST['type'];
$str = typeName($type);
$typeName = $str['title'];
$istype = $str['istype'];
$zzusername = $str['zzusername'];
$zzpassword = $str['zzpassword'];
$zzmoney = $str['zzmoney'];
$zztime  = $str['zztime'];
$data = array();

if(!check_game($type)){
    die($callback.'('.json_encode(['info'=>'no','msg'=>'<font color=red>维护中</font>']).')');
}

if(!empty($uid)){
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
        $stmt = $mydata1_db->prepare($sql);
        $stmt -> execute($params);
      }else{
        $data['info'] = 'no';
        $data['msg']  = '<font color=red>&nbsp;---&nbsp;</font>';
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
  $params = [];
  $userinfo = user::getinfo($uid);
  // echo '|';
  $arrUrl = $client->livebalance($site_id,$userinfo[$zzusername],$userinfo[$zzpassword],$type);
  //print_r($arrUrl);
 // echo '|';
  if(is_array($arrUrl) and $arrUrl){
    if($arrUrl['result'] == 'ok'){
      $data['info'] = 'ok';
      $data['msg']  = sprintf("%.2f",$arrUrl['msg']);
      $data['name']  = $userinfo[$zzusername];
      $params[':uid']=$userinfo['uid'];
      $params[':zrmoney'] = $data['msg'];
      $sql = 'update  mydata1_db.k_user set '.$zzmoney.'=:zrmoney,'.$zztime.'=now() where uid=:uid';
      $stmt = $mydata1_db->prepare($sql);
      $stmt -> execute($params);
      //$data['info'] = 'no';
      //$data['msg'] = $sql;
      echo $callback.'('.json_encode($data).')';
      exit;
    }else{
      $data['info'] = 'no';
      $data['msg']  = '<font color=red>&nbsp;--&nbsp;</font>';
      echo $callback.'('.json_encode($data).')';
      exit;
    }

  }else{
    $data['info'] = 'no';
    $data['msg']  = '<font color=red>&nbsp;--&nbsp;</font>';
    echo $callback.'('.json_encode($data).')';
    exit;
  }

}else{
  $data['info'] = 'no';
  $data['msg']  = '<font color=red>&nbsp;--&nbsp;</font>';
  echo $callback.'('.json_encode($data).')';
  exit;
}

function zrmoneyName($type){
  switch ($type) {
    case 'AGIN':
      $zrmoney = 'agmoney';
      break;
    case 'AG':
      $zrmoney = 'agqmoney';
      break;
    case 'BBIN':
      $zrmoney = 'bbmoney';
      break;
    case 'XTD':
      $zrmoney = 'xtdmoney';
      break;
    case 'OG':
      $zrmoney = 'ogmoney';
      break;
    case 'MG':
      $zrmoney = 'mgmoney';
      break;
    case 'SHABA':
      $zrmoney = 'shabamoney';
      break;
    case 'PT':
      $zrmoney = 'ptmoney';
      break;
    case 'HG':
      $zrmoney = 'hgmoney';
      break;
    default:
      $zrmoney = '';
      break;
  }

  return $zrmoney;
}

?>