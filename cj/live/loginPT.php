<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
include_once ("../include/function.php");
include_once $C_Patch."/class/user.php";
function authcode($string, $operation = 'DECODE', $key = '8935974d126c4f63dad4e11d22b8df6c', $expiry = 0) { 
    $ckey_length = 4;   
    $key = md5($key);  
    $keya = md5(substr($key, 0, 16));   
    $keyb = md5(substr($key, 16, 16));   
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length):substr(md5(microtime()), -$ckey_length)) : '';   
    $cryptkey = $keya.md5($keya.$keyc);   
    $key_length = strlen($cryptkey);     
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)):sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;   
    $string_length = strlen($string);   
    $result = '';   
    $box = range(0, 255);   
    $rndkey = array();   
    for($i = 0; $i <= 255; $i++) {   
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);   
    }
    for($j = $i = 0; $i < 256; $i++) {   
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;   
        $tmp = $box[$i];   
        $box[$i] = $box[$j];   
        $box[$j] = $tmp;   
    }  
    for($a = $j = $i = 0; $i < $string_length; $i++) {   
        $a = ($a + 1) % 256;   
        $j = ($j + $box[$a]) % 256;   
        $tmp = $box[$a];   
        $box[$a] = $box[$j];   
        $box[$j] = $tmp;   
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));   
    }   
    if($operation == 'DECODE') { 
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {   
            return substr($result, 26);   
        } else {   
            return '';   
        }   
    } else {   
        return $keyc.str_replace('=', '', base64_encode($result));   
    }   
}
$callback = $_GET['callback'];
$uid=$_SESSION["uid"];
$zzusername = $str['zzusername'];
$zzpassword = $str['zzpassword'];
$mobile = (int)$_GET['mobile'];
$code = $_GET['gameId'];
$type = $_GET['type'];
$data = array();
$typeName = '新PT电子';
if(!empty($uid) && !empty($_SESSION["username"])){
  $userinfo = user::getinfo($uid);
  $client = new rpcclient($cj_url);
  if($userinfo['ispt2'] != 1){
    $arr = $client->liveregpt($site_id,$userinfo['username']);
    if(is_array($arr) and $arr){
      if($arr['info']=='ok'){
        $params = array(':username'=>$userinfo['username'],':pt2UserName'=>$arr['username'],':pt2PassWord'=>$arr['password'],':uid'=>$uid);
        $sql = 'update  mydata1_db.k_user set pt2UserName=:pt2UserName,pt2Addtime=now(),ispt2=1,pt2PassWord=:pt2PassWord where ispt2=0 and username = :username and uid=:uid';
        $stmt = $mydata1_db->prepare($sql);
        $stmt -> execute($params);

        $userinfo = user::getinfo($uid);
      }else{
        $data['info'] = 'no';
        $data['msg']  = '注册新PT电子失败!!<br><br>'.$arr['msg'];
        echo $callback.'('.json_encode($data).')';
        exit;
      }
    }else{
      $data['info'] = 'no';
      $data['msg']  = '注册新PT电子失败!!<br><br>请检查线路!!';
      echo $callback.'('.json_encode($data).')';
      exit;
    } 
  }

    $typeName = '新PT电子';
    

    $des = authcode(json_encode(['u'=>$userinfo['pt2UserName'], 'p'=>$userinfo['pt2PassWord'],'c'=>$code]),'ENCODE');
    if($mobile == '0'){
      $url = 'http://pt.ub-66.com/jump.php?token='. urlencode($des);
    }else{
      $url = 'http://pt.ub-66.com/ptm/jump.php?token='. urlencode($des);
    }
    $data['info'] = 'ok';
    $data['msg']  = $url;
    echo $callback.'('.json_encode($data).')';
    exit;
}else{
  $data['info'] = 'no';
  $data['msg'] = '请您先登陆!!';
  echo $callback.'('.json_encode($data).')';
  exit;
}