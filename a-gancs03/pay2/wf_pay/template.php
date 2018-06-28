<?php return;?>
{{s_main}}
$arr_online_config['wf_pay']['pay_mid'] = '{{pay_mid}}';
$arr_online_config['wf_pay']['pay_mkey'] = '{{pay_mkey}}';
$arr_online_config['wf_pay']['pay_url'] = 'http://{{pay_url}}/member/';
$arr_online_config['wf_pay']['input_url'] = '/member/pay/zspay.php';
$arr_online_config['wf_pay']['notice_url'] = $arr_online_config['wf_pay']['pay_url'] . 'pay/wepay/notify.php';
$arr_online_config['wf_pay']['return_url'] = $arr_online_config['wf_pay']['pay_url'] . 'pay/wepay/success.html';
$arr_online_config['wf_pay']['merchant_url'] = 'https://api.wefupay.com/gateway/api/scanpay';
$arr_online_config['wf_pay']['merchant_url2'] = 'https://api.wefupay.com/gateway/api/h5apipay';
{{e_main}}
{{s_wechat}}
$arr_online_config['微付微信'] = $arr_online_config['wf_pay'];
$arr_online_config['微付微信']['online_name'] = '微信扫码';
$arr_online_config['微付微信']['post_url'] = '/member/pay/wepay/pay.php?S_Type=WECHAT';
{{e_wechat}}
{{s_wechat_h5}}
$arr_online_config['微付微信H5'] = $arr_online_config['wf_pay'];
$arr_online_config['微付微信H5']['online_name'] = '微信H5';
$arr_online_config['微付微信h5']['post_url'] = '/member/pay/wepay/pay.php?S_Type=WECHATH5';
$arr_online_config['微付微信H5']['merchant_url'] = $arr_online_config['微付微信H5']['merchant_url2'];
{{e_wechat_h5}}
{{s_alipay}}
$arr_online_config['微付支付宝'] = $arr_online_config['wf_pay'];
$arr_online_config['微付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['微付支付宝']['post_url'] = '/member/pay/wepay/pay.php?S_Type=ALIPAY';
{{e_alipay}}
{{s_alipay_h5}}
$arr_online_config['微付支付宝H5'] = $arr_online_config['wf_pay'];
$arr_online_config['微付支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['微付支付宝H5']['post_url'] = '/member/pay/wepay/pay.php?S_Type=ALIPAYH5';
$arr_online_config['微付支付宝H5']['merchant_url'] = $arr_online_config['微付支付宝H5']['merchant_url2'];
{{e_alipay_h5}}
{{s_qqpay}}
$arr_online_config['微付QQ钱包'] = $arr_online_config['wf_pay'];
$arr_online_config['微付QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['微付QQ钱包']['post_url'] = '/member/pay/wepay/pay.php?S_Type=QQPAY';
{{e_qqpay}}
{{s_qqpay_h5}}
$arr_online_config['微付QQ钱包H5'] = $arr_online_config['wf_pay'];
$arr_online_config['微付QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['微付QQ钱包H5']['post_url'] = '/member/pay/wepay/pay.php?S_Type=QQPAYH5';
$arr_online_config['微付QQ钱包H5']['merchant_url'] = $arr_online_config['微付QQ钱包H5']['merchant_url2'];
{{e_qqpay_h5}}
{{s_jdpay}}
$arr_online_config['微付京东钱包'] = $arr_online_config['wf_pay'];
$arr_online_config['微付京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['微付京东钱包']['post_url'] = '/member/pay/wepay/pay.php?S_Type=JDPAY';
{{e_jdpay}}