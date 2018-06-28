<?php
    file_put_contents('111.txt',date('Y-m-d H:i:s',time()));
	require_once 'AppConfig.php';
	require_once 'AppUtil.php';
    include_once './config.php';
    include_once '../config.php';
    include_once '../../../database/mysql.config.php';
    include_once '../tools.php';
    include_once '../moneyfunc.php';
    include_once '../moneyconfig.php';
    
	$params = array();
	foreach($_POST as $key=>$val) {//将参数遍历获取
		$params[$key] = $val;
	}
	if(count($params)<1){//如果参数为空,则不进行处理
		echo "error";
		exit();
	}
	if(AppUtil::ValidSign($params, APPKEY)){//验签成功
		//file_put_contents('params.txt',json_encode($params));
		$_payId = $params['bizseq'];
		$userinfo = array();
        if(verify_id('TL', $_payId)){
          $param = array(':mid' => $_payId);
          $stmt = $mydata1_db->prepare('SELECT * FROM `k_money_order` WHERE `mid`=:mid');
          $stmt->execute($param);
          if($stmt->rowCount()>0){
             $userinfo = $stmt->fetch();
             $pay_online = $userinfo['pay_online'];
             $stmt = $mydata1_db->prepare('UPDATE `k_money_order` SET `status`=1 WHERE `mid`=:mid');
             $stmt->execute($param);
           }
         }
     empty($userinfo)&&exit('Access Denied1');

     if(isset($params['trxstatus'])&&$params['trxstatus']=='0000'){
             $amount = $params['amount'] / 100;
             //file_put_contents('amount.txt',$amount);
            insert_online_money($userinfo['username'], $_payId, $amount, $arr_online_config[$pay_online]['online_name'].'充值');
      
      }
  
		echo "success";
	}
	else{
		echo "error";
	}








 
