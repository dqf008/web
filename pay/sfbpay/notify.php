<?php
header("Content-type: text/html; charset=utf-8");
include_once '../config.php';
include_once '../../../database/mysql.config.php';
include_once '../tools.php';
include_once '../moneyfunc.php';
include("../moneyconfig.php");
//处理数据
   $ReturnArray = array( // 返回字段
            "memberid" => $_REQUEST["memberid"], // 商户ID
            "orderid" =>  $_REQUEST["orderid"], // 订单号
            "amount" =>  $_REQUEST["amount"], // 交易金额
            "datetime" =>  $_REQUEST["datetime"], // 交易时间
            "transaction_id" =>  $_REQUEST["transaction_id"], // 支付流水号
            "returncode" => $_REQUEST["returncode"],
        );
      
        $Md5key = 't4ig5acnpx4fet4zapshjacjd9o4bhbi';
   
		ksort($ReturnArray);
        reset($ReturnArray);
        $md5str = "";
        foreach ($ReturnArray as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
            $sting = $md5str;
        }
        $sign = strtoupper(md5($md5str . "key=" . $Md5key));
        if ($sign == $_REQUEST["sign"]) {
			
            if ($_REQUEST["returncode"] == "00") {
				   $str = "交易成功！订单号：".$_REQUEST["orderid"];
                   file_put_contents("success.txt",$str."\n", FILE_APPEND);
                   //
                   foreach ($_POST as $key => $val) {
                       $md5str  .="{$key}={$val}&";
                       
                   }
                   
                   file_put_contents("success.txt", $md5str."\n", FILE_APPEND);
                   $ext = $_REQUEST['attach'];
                   $play_array = explode("||",$ext);
                   $uid = $play_array[0];
                   $pay_online = $play_array[1];
                   //$get_pay = $arr_online_config[$pay_online];
                   //处理数据
                   $query = $mydata1_db->query('SELECT `username` FROM `k_user` WHERE `uid`='.$uid);
                   if($query->rowCount()>0){
                       $order = $query->fetch();
                   }
                   $res =insert_online_money($order['username'],$_POST["orderid"], $_POST['amount'], $pay_online);
                   if($res==1){
                        exit("ok");
                   }else{
                       exit("error");
                   }
                   
				  
            }
        }

?>