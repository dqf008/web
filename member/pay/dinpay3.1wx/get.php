<?php
/* 获取二维码文件 */
$pay_online = $_GET['pay_online'];
include("../moneyconfig.php");
include("../../../cache/website.php");
include("../../../database/mysql.config.php");
include("../moneyfunc.php");

$_DINPAY = array();
$_DINPAY['return'] = array();

$_DINPAY['uid'] = intval(isset($_GET['uid'])&&!empty($_GET['uid'])?$_GET['uid']:0);

//验证是否存在用户
$query = $mydata1_db->query('SELECT `uid`, `money`, `username` FROM `k_user` WHERE `uid`='.$_DINPAY['uid'].' LIMIT 1');
if($query->rowCount()>0){
    $user = $query->fetch();
    $_DINPAY['username'] = $user['username'];
}else{
    $_DINPAY['return']['status'] = 'error';
    $_DINPAY['return']['message'] = '请登陆后继续充值。';
}

(!isset($_GET['amount'])||!preg_match('/^\d+(\.\d+)?$/', $_GET['amount']))&&$_GET['amount'] = $web_site['ck_limit'];
$_GET['amount'] = number_format($_GET['amount']<$web_site['ck_limit']?$web_site['ck_limit']:$_GET['amount'], 2, '.', '');

if(empty($_DINPAY['return'])){
    $_DINPAY['data'] = array();
    $_DINPAY['data']['extra_return_param'] = $_DINPAY['uid'].','.base64_encode($pay_online);
    $_DINPAY['data']['interface_version'] = 'V3.0';
    $_DINPAY['data']['merchant_code'] = $pay_mid;
    $_DINPAY['data']['notify_url'] = $notice_url;
    $_DINPAY['data']['order_amount'] = $_GET['amount']; //交易金额，单元：元
    $_DINPAY['data']['order_no'] = generate_id('ZFWX', $_DINPAY['uid']); //商户流水号
    $_DINPAY['data']['order_time'] = date('Y-m-d H:i:s', time()+43200); //订单时间
    $_DINPAY['data']['product_name'] = $_DINPAY['username'];
    $_DINPAY['data']['service_type'] = 'wxpay';

    $sign_str = '';
    foreach($_DINPAY['data'] as $key=>$val){
        !empty($sign_str)&&$sign_str.= '&';
        $sign_str.= $key.'='.$val;
    }
    $private_key = openssl_get_privatekey($pay_mkey);
    openssl_sign($sign_str, $sign_info, $private_key, OPENSSL_ALGO_MD5);
    $_DINPAY['data']['sign_type'] = 'RSA-S'; //交易签名
    $_DINPAY['data']['sign'] = base64_encode($sign_info); //交易签名

    $_DINPAY['data'] = http_build_query($_DINPAY['data']);
    $_DINPAY['opts'] = array(
        'http' => array(
        'method' => 'POST',
        'header' => "Content-type: application/x-www-form-urlencoded\r\n".
                    "Cache-Control: no-cache\r\n".
                    "Pragma: no-cache\r\n".
                    "Content-Length: ".strlen($_DINPAY['data'])."\r\n".
                    "Cookie: Google=God or dog?\r\n".
                    "Referer: https://api.dinpay.com/gateway/api/weixin\r\n".
                    "\r\n",
        'content' => $_DINPAY['data'],
        )
    );
    $_DINPAY['context'] = stream_context_create($_DINPAY['opts']);

    if($_DINPAY['HTML'] = file_get_contents('https://api.dinpay.com/gateway/api/weixin', false, $_DINPAY['context'])){
        if(preg_match('/<resp_code>(.*?)<\/resp_code>/', $_DINPAY['HTML'], $matches)){
            if($matches[1]=='SUCCESS'&&preg_match('/<qrcode>(.*?)<\/qrcode>/', $_DINPAY['HTML'], $matches)){
                $_DINPAY['return']['status'] = 'success';
                $_DINPAY['return']['message'] = dz_authcode($matches[1], 'ENCODE');
            }
        }
        if(isset($_GET['debug'])){
            echo '/*';
            var_dump($_DINPAY['HTML']);
            echo '*/';
        }
    }
}

if(empty($_DINPAY['return'])){
    $_DINPAY['return']['status'] = 'error';
    $_DINPAY['return']['message'] = '获取二维码失败，请重试。';
}

echo isset($_GET['callback'])&&!empty($_GET['callback'])?$_GET['callback']:'callback';
echo '('.json_encode($_DINPAY['return']).')';