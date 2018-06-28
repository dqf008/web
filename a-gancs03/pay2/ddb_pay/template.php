<?php return;?>
{{s_main}}
$arr_online_config['ddb_pay']['pay_mid'] = '{{pay_mid}}';
$arr_online_config['ddb_pay']['pay_mkey'] = '{{pay_mkey}}';
$arr_online_config['ddb_pay']['pay_pubKey'] = '{{pay_pubKey}}';
$arr_online_config['ddb_pay']['pay_url'] = 'http://{{pay_url}}/member/';
{{e_main}}
{{s_bank}}
$arr_online_config['多得宝网银'] = $arr_online_config['ddb_pay'];
$arr_online_config['多得宝网银']['online_name'] = '网银支付';
$arr_online_config['多得宝网银']['input_url'] = '/member/pay/ddbpay.php';
$arr_online_config['多得宝网银']['post_url'] = $arr_online_config['多得宝网银']['pay_url'] . 'pay/ddbpay/MerToDinpay.php';
$arr_online_config['多得宝网银']['notice_url'] = $arr_online_config['多得宝网银']['pay_url'] . 'pay/ddbpay/DinpayToMer.php';
{{e_bank}}
{{s_wechat}}
$arr_online_config['多得宝微信'] = $arr_online_config['ddb_pay'];
$arr_online_config['多得宝微信']['online_name'] = '微信扫码';
$arr_online_config['多得宝微信']['input_url'] = '/member/pay/ddbpaywx.php?type=2';
$arr_online_config['多得宝微信']['post_url'] = '/member/pay/ddbpaywx/post.php?type=2';
$arr_online_config['多得宝微信']['advice_url'] = '/member/pay/ddbpaywx/get.php';
$arr_online_config['多得宝微信']['notice_url'] = $arr_online_config['多得宝微信']['pay_url'] . 'pay/ddbpaywx/notify.php';
{{e_wechat}}
{{s_alipay}}
$arr_online_config['多得宝支付宝'] = $arr_online_config['ddb_pay'];
$arr_online_config['多得宝支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['多得宝支付宝']['input_url'] = '/member/pay/ddbpaywx.php?type=1';
$arr_online_config['多得宝支付宝']['post_url'] = '/member/pay/ddbpaywx/post.php?type=1';
$arr_online_config['多得宝支付宝']['advice_url'] = '/member/pay/ddbpaywx/get.php';
$arr_online_config['多得宝支付宝']['notice_url'] = $arr_online_config['多得宝支付宝']['pay_url'] . 'pay/ddbpaywx/notify.php';
{{e_alipay}}
{{s_qqpay}}
$arr_online_config['多得宝QQ钱包'] = $arr_online_config['ddb_pay'];
$arr_online_config['多得宝QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['多得宝QQ钱包']['input_url'] = '/member/pay/ddbpaywx.php?type=3';
$arr_online_config['多得宝QQ钱包']['post_url'] = '/member/pay/ddbpaywx/post.php?type=3';
$arr_online_config['多得宝QQ钱包']['advice_url'] = '/member/pay/ddbpaywx/get.php';
$arr_online_config['多得宝QQ钱包']['notice_url'] = $arr_online_config['多得宝QQ钱包']['pay_url'] . 'pay/ddbpaywx/notify.php';
{{e_qqpay}}
