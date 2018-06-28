<?php return;?>
{{s_main}}
$arr_online_config['sfb_pay']['pay_mid'] = '{{pay_mid}}';
$arr_online_config['sfb_pay']['pay_mkey'] = '{{pay_mkey}}';
$arr_online_config['sfb_pay']['pay_url'] = 'http://{{pay_url}}/member/';
$arr_online_config['sfb_pay']['notice_url'] = $arr_online_config['sfb_pay']['pay_url'] . 'pay/sfbpay/notify.php';
$arr_online_config['sfb_pay']['merchant_url'] = 'http://www.597kf.com/Pay_Index.html';
{{e_main}}
{{s_wechat}}
$arr_online_config['快付微信'] = $arr_online_config['sfb_pay'];
$arr_online_config['快付微信']['online_name'] = '微信扫码';
$arr_online_config['快付微信']['input_url'] = $arr_online_config['快付微信']['pay_url'] . 'pay/zspay.php';
$arr_online_config['快付微信']['post_url'] = $arr_online_config['快付微信']['pay_url'] . 'pay/sfbpay/pay.php?S_Type=WECHAT';
{{e_wechat}}
{{s_wechat_wap}}
$arr_online_config['快付手机微信'] = $arr_online_config['sfb_pay'];
$arr_online_config['快付手机微信']['online_name'] = '手机微信扫码';
$arr_online_config['快付手机微信']['input_url'] = $arr_online_config['快付手机微信']['pay_url'] . 'pay/zspay.php';
$arr_online_config['快付手机微信']['post_url'] = $arr_online_config['快付手机微信']['pay_url'] . 'pay/sfbpay/pay.php?S_Type=WXWAP';
{{e_wechat_wap}}
{{s_alipay}}
$arr_online_config['快付支付宝'] = $arr_online_config['sfb_pay'];
$arr_online_config['快付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['快付支付宝']['input_url'] = $arr_online_config['快付支付宝']['pay_url'] . 'pay/zspay.php';
$arr_online_config['快付支付宝']['post_url'] = $arr_online_config['快付支付宝']['pay_url'] . 'pay/sfbpay/pay.php?S_Type=ALIPAY';
{{e_alipay}}
{{s_alipay_wap}}
$arr_online_config['快付支付宝手机'] = $arr_online_config['sfb_pay'];
$arr_online_config['快付支付宝手机']['online_name'] = '支付宝手机扫码';
$arr_online_config['快付支付宝手机']['input_url'] = $arr_online_config['快付支付宝手机']['pay_url'] . 'pay/zspay.php';
$arr_online_config['快付支付宝手机']['post_url'] = $arr_online_config['快付支付宝手机']['pay_url'] . 'pay/sfbpay/pay.php?S_Type=ALIWAP';
{{e_alipay_wap}}
{{s_qqpay}}
$arr_online_config['快付QQ钱包'] = $arr_online_config['sfb_pay'];
$arr_online_config['快付QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['快付QQ钱包']['input_url'] = $arr_online_config['快付QQ钱包']['pay_url'] . 'pay/zspay.php';
$arr_online_config['快付QQ钱包']['post_url'] = $arr_online_config['快付QQ钱包']['pay_url'] . 'pay/sfbpay/pay.php?S_Type=QQPAY';
{{e_qqpay}}
{{s_bank_wap}}
$arr_online_config['快付手机网银'] = $arr_online_config['sfb_pay'];
$arr_online_config['快付手机网银']['online_name'] = '网银扫码';
$arr_online_config['快付手机网银']['input_url'] = $arr_online_config['快付手机网银']['pay_url'] . 'pay/zspay.php';
$arr_online_config['快付手机网银']['post_url'] = $arr_online_config['快付手机网银']['pay_url'] . 'pay/sfbpay/pay.php?S_Type=UNIONPAY';
{{e_bank_wap}}
{{s_jdpay}}
$arr_online_config['快付京东钱包'] = $arr_online_config['sfb_pay'];
$arr_online_config['快付京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['快付京东钱包']['input_url'] = $arr_online_config['快付京东钱包']['pay_url'] . 'pay/zspay.php';
$arr_online_config['快付京东钱包']['post_url'] = $arr_online_config['快付京东钱包']['pay_url'] . 'pay/sfbpay/pay.php?S_Type=JDPAY';
{{e_jdpay}}
{{s_bank}}
$arr_online_config['快付网银'] = $arr_online_config['sfb_pay'];
$arr_online_config['快付网银']['online_name'] = '网银支付';
$arr_online_config['快付网银']['input_url'] = $arr_online_config['快付网银']['pay_url'] . 'pay/dinpay3.1.php';
$arr_online_config['快付网银']['post_url'] = $arr_online_config['快付网银']['pay_url'] . 'pay/sfbpay/pany.php';
{{e_bank}}
{{s_wechat_h5}}
$arr_online_config['快付微信H5'] = $arr_online_config['sfb_pay'];
$arr_online_config['快付微信H5']['online_name'] = '微信H5';
$arr_online_config['快付微信H5']['input_url'] = $arr_online_config['快付微信H5']['pay_url'] . 'pay/dinpay3.1.php';
$arr_online_config['快付微信H5']['post_url'] = $arr_online_config['快付微信H5']['pay_url'] . 'pay/sfbpay/pany.php?S_Type=WECHAT';
{{e_wechat_h5}}
{{s_alipay_h5}}
$arr_online_config['快付支付宝H5'] = $arr_online_config['sfb_pay'];
$arr_online_config['快付支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['快付支付宝H5']['input_url'] = $arr_online_config['快付支付宝H5']['pay_url'] . 'pay/dinpay3.1.php';
$arr_online_config['快付支付宝H5']['post_url'] = $arr_online_config['快付支付宝H5']['pay_url'] . 'pay/sfbpay/pany.php?S_Type=ALIPAY';
{{e_alipay_h5}}