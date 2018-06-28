<?php
header("content-Type: text/html; charset=UTF-8");

$query_param = $_SERVER['QUERY_STRING'];

echo '回调参数串:'.$query_param;
echo '</br>';
$date = date('YmdHis');
$md5key = "706912a3b5a12755fb0a43de41XXXX";//商户配置密钥
$pay = array();
$pay = strToArr($query_param);
$server_sign_value = $pay['sign'];
echo '回调签名结果:'.$server_sign_value;
echo '</br>';
unset($pay['sign']);
$pay['succTime']=urldecode($pay['succTime']);
ksort($pay);
echo '回调参数串:'.$query_param;
print_r($pay);
echo "</br>";
$msg = signMsg($pay, $md5key);
echo 'Sign Before MD5:'.$msg;
echo "</br>";
$pay['sign'] = strtoupper(md5($msg));
echo 'Sign MD5 finaly:'.$pay['sign'];

  
/**
 * 设置加签数据
 * 
 * @param unknown $array
 * @param unknown $md5Key
 * @return string
 */
function signMsg($array,$md5Key){
    $msg = "";
    $i = 1;
    // 转换为字符串 key=value&key.... 加签
    foreach ($array as $key => $val) {
        // 不参与签名
        if($key != "signMethod" && $key != "signature"){
            if($i == 0 ){
                $msg = $msg."$key=$val";
            }else {
                $msg = $msg."&$key=$val";
            }
            $i++;
        }
    }
    $msg = $msg.$md5Key;
    return  $msg;
}
function strToArr ($str){
    $arr = explode("&",$str);
    $r = array();
    foreach ($arr as $val )
    {
        $t = explode("=",$val);
        
        $r[$t[0]]= substr($val,strlen($t[0])+1);
       // $r[$t[0]]= $t[1];
    }
    return $r;
}



?>