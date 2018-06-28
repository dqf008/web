<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");

foreach($_REQUEST as $key=>$val) {//将参数遍历获取
           
            $str .="$key=$val&";
        }
file_put_contents('log.txt',$str,FILE_APPEND);
exit;
/**
 * 
 * 扫码支付-异步通知
 * 
 */
$mid = $_REQUEST['tradeSn'];
$query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`='.$mid);
if($query->rowCount()>0){
    $order = $query->fetch();
}

$get_pay = $arr_online_config[$order['pay_online']];
$md5Key = $get_pay['pay_mkey'];
$sign=$_POST["sign"];
$amount = intval($_POST["orderAmount"]) * 0.01;
$str ="";
$data = $_REQUEST;
ksort ($data);
unset($data['sign']);
foreach($data as $k=>$v){
    $str.=" $k=$v&";
}

$str = $str."sign=".$md5Key;
$str = md5($str);
// 将小写字母转成大写字母
$sign1 = strtoupper($str);
//验签
if($_POST['sign'] === $sign1) {
		
		file_put_contents('a.txt',$str,FILE_APPEND);
        $query = $mydata1_db->query('SELECT * FROM `k_money_order` WHERE `mid`=' . $order['mid']);
		if($query->rowCount()>0){
		    $order = $query->fetch();
		}
		//$status = $_POST['status'];
		 $res =insert_online_money($order['username'],$order['mid'], $amount, $order['pay_online']);
		    if($res==1){
		       // echo "SUCCESS";
		        echo "{'code':'00'}";
		    }
		
}else {
		echo "{'code':'01'}";
	}












/* 构建签名原文 */
function sign_src($sign_fields, $map, $md5_key)
{
    // 排序-字段顺序
    sort($sign_fields);
    $sign_src = "";
    foreach ($sign_fields as $field) {
        $sign_src .= $field . "=" . $map[$field] . "&";
    }
    $sign_src .= "KEY=" . $md5_key;

    return $sign_src;
}

/**
 * 计算md5签名  返回的是小写的，后面需转大写
 */
function sign_mac($sign_fields, $map, $md5_key)
{
    $sign_src = sign_src($sign_fields, $map, $md5_key);
    return md5($sign_src);
}

?>
