<?php
/* 支付回调文件 */

if($_SERVER['REQUEST_METHOD']=='POST'&&!empty($_POST)&&isset($_POST['sign'])){
    include("../../../cache/website.php");
    include("../../../database/mysql.config.php");
    include("../moneyfunc.php");
    @file_put_contents('data.txt', json_encode($_POST));
    if(isset($_POST['trade_status'])&&$_POST['trade_status']=='SUCCESS'&&verify_id('ZFWX', $_POST['order_no'])){
        if(preg_match('/^(\d+)\,(.+)$/', $_POST['extra_return_param'], $matches)){
            $query = $mydata1_db->query('SELECT `username` FROM `k_user` WHERE `uid`='.$matches[1]);
            if($query->rowCount()>0){
                $order = $query->fetch();
                $pay_online = base64_decode($matches[2]);
            }
        }
        include("../moneyconfig.php");
        $signStr = "";
    
        if($_POST['bank_seq_no'] != ""){
            $signStr = $signStr."bank_seq_no=".$_POST['bank_seq_no']."&";
        }

        if($_POST['extra_return_param'] != ""){
            $signStr = $signStr."extra_return_param=".$_POST['extra_return_param']."&";
        }   

        $signStr = $signStr."interface_version=".$_POST['interface_version']."&";    

        $signStr = $signStr."merchant_code=".$_POST['merchant_code']."&";

        $signStr = $signStr."notify_id=".$_POST['notify_id']."&";

        $signStr = $signStr."notify_type=".$_POST['notify_type']."&";

        $signStr = $signStr."order_amount=".$_POST['order_amount']."&";  

        $signStr = $signStr."order_no=".$_POST['order_no']."&";  

        $signStr = $signStr."order_time=".$_POST['order_time']."&";  

        $signStr = $signStr."trade_no=".$_POST['trade_no']."&";  

        $signStr = $signStr."trade_status=".$_POST['trade_status']."&";
            
        $signStr = $signStr."trade_time=".$_POST['trade_time'];
        // $_SIGN = array();
        // $_SIGN[] = 'bank_seq_no';
        // $_SIGN[] = 'extra_return_param';
        // $_SIGN[] = 'interface_version';
        // $_SIGN[] = 'merchant_code';
        // $_SIGN[] = 'notify_id';
        // $_SIGN[] = 'notify_type';
        // $_SIGN[] = 'order_amount';
        // $_SIGN[] = 'order_no';
        // $_SIGN[] = 'order_time';
        // $_SIGN[] = 'trade_no';
        // $_SIGN[] = 'trade_status';
        // $_SIGN[] = 'trade_time';
        //$sign_str = '';
        // foreach($_SIGN as $key){
        //     if(in_array($key,['bank_seq_no','extra_return_param'])&&!empty($_POST[$key])){
        //         !empty($sign_str)&&$sign_str.= '&';
        //         $sign_str.= $key.'='.$_POST[$key];
        //     }else{
        //         !empty($sign_str)&&$sign_str.= '&';
        //         $sign_str.= $key.'='.$_POST[$key];
        //     }
        // }
        $dinpay_public_key ='MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDVvOjJsCCYMVQT215flkvlCsYIY31fUCkEdE+jMG+gOzBM5g43uRm61AiIULz1nCjWYRHDLBGsFK/6wFm8u6A5YAUrYPCkud3wIjT/D1glSzDNwIJ9oT5Td9g0Tb0c3z84iETi6PiPo4mypFc2Prtk+tEKS4hxq/8tx4G1lnkcZwIDAQAB'; 
        $dinpay_public_key = "-----BEGIN PUBLIC KEY-----"."\r\n".wordwrap(trim($dinpay_public_key),62,"\r\n",true)."\r\n"."-----END PUBLIC KEY-----";
        $dinpay_sign = isset($_POST['sign'])&&!empty($_POST['sign'])?base64_decode($_POST['sign']):'';
        $public_key = openssl_get_publickey($dinpay_public_key);
        if(openssl_verify($signStr, $dinpay_sign, $public_key, OPENSSL_ALGO_MD5)){
            insert_online_money($order['username'], $_POST['order_no'], $_POST['order_amount'], '智付微信扫码充值');
            echo 'SUCCESS';
        }else{
            echo 'Signature failed';
        }
    }else{
        echo 'Payment failed';
    }
}else{
    echo 'Request Method must in POST';
}