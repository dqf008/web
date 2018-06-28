<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
//处理数据

 $Md5key = $arr_online_config['皇冠微信']['pay_mkey'];;
 $query_param = $_SERVER['QUERY_STRING'];
 
 $pay = array();
 $pay = $_REQUEST;//取数据
 $server_sign_value = $pay['sign'];//回调签名结果
 unset($pay['sign']);
 $pay['succTime']=urldecode($pay['succTime']);
 ksort($pay);
 $msg = signMsg($pay, $Md5key);
 $pay['sign'] = strtoupper(md5($msg));
 //echo 'Sign MD5 finaly:'.$pay['sign'];
 //查看签名
 file_put_contents('log.txt', $query_param);
 if($server_sign_value!=$pay['sign']){
     exit("not null");
 }
 
   
 $merOrderNum = $_REQUEST['merOrderId'];
if ($_REQUEST["sign"] == $pay['sign'] && $merOrderNum) {
       //处理数据
    $query = $mydata1_db->query('SELECT * FROM k_money_order WHERE `mid`='.$merOrderNum);
    if($query->rowCount()>0){
        $order = $query->fetch();
    }
    $pay_online = $order['pay_online'];
    $res =insert_online_money($order['username'],$order['mid'], $order['amount'],$order['pay_online']);
       if($res==1){
            exit("0000");
       }else{
           exit("error");
       }
	  
}
 



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