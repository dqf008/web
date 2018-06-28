<?php return;?>
{{s_main}}
$arr_online_config['ccf_pay']['pay_mid'] = '{{pay_mid}}';
$arr_online_config['ccf_pay']['pay_mkey'] = '{{pay_mkey}}';
$arr_online_config['ccf_pay']['pay_url'] = 'http://{{pay_url}}/member/';
$arr_online_config['ccf_pay']['notice_url'] = $arr_online_config['ccf_pay']['pay_url'] . 'pay/ccpay/notify.php';
$arr_online_config['ccf_pay']['return_url'] = $arr_online_config['ccf_pay']['pay_url'] . 'pay/ccpay/success.html';
$arr_online_config['ccf_pay']['merchant_url'] = 'http://a.cc8pay.com/api/passivePay';
$arr_online_config['ccf_pay']['merchant_url2'] = 'http://a.cc8pay.com/api/wapPay';
{{e_main}}
{{s_wechat}}
$arr_online_config['长城付微信'] = $arr_online_config['ccf_pay'];
$arr_online_config['长城付微信']['online_name'] = '微信扫码';
$arr_online_config['长城付微信']['input_url'] = '/member/pay/dinpay3.1.php';
$arr_online_config['长城付微信']['post_url'] = '/member/pay/ccpay/pay.php?S_Type=WECHAT';
{{e_wechat}}
{{s_wechat_h5}}
$arr_online_config['长城付微信H5'] = $arr_online_config['ccf_pay'];
$arr_online_config['长城付微信H5']['online_name'] = '微信H5';
$arr_online_config['长城付微信H5']['post_url'] = '/member/pay/ccpay/pany.php?S_Type=WECHAT';
$arr_online_config['长城付微信H5']['merchant_url'] = $arr_online_config['长城付微信H5']['merchant_url2'];
{{e_wechat_h5}}
{{s_alipay}}
$arr_online_config['长城付支付宝'] = $arr_online_config['ccf_pay'];
$arr_online_config['长城付支付宝']['online_name'] = '支付宝扫码';
$arr_online_config['长城付支付宝']['post_url'] = '/member/pay/ccpay/pay.php?S_Type=ALIPAY';
{{e_alipay}}
{{s_alipay_h5}}
$arr_online_config['长城付支付宝H5'] = $arr_online_config['ccf_pay'];
$arr_online_config['长城付支付宝H5']['online_name'] = '支付宝H5';
$arr_online_config['长城付支付宝H5']['post_url'] = '/member/pay/ccpay/pany.php?S_Type=ALIPAY';
$arr_online_config['长城付支付宝H5']['merchant_url'] = $arr_online_config['长城付支付宝H5']['merchant_url2'];
{{e_alipay_h5}}
{{s_qqpay}}
$arr_online_config['长城付QQ钱包'] = $arr_online_config['ccf_pay'];
$arr_online_config['长城付QQ钱包']['online_name'] = 'QQ钱包扫码';
$arr_online_config['长城付QQ钱包']['post_url'] = '/member/pay/ccpay/pay.php?S_Type=QQPAY';
{{e_qqpay}}
{{s_qqpay_h5}}
$arr_online_config['长城付QQ钱包H5'] = $arr_online_config['ccf_pay'];
$arr_online_config['长城付QQ钱包H5']['online_name'] = 'QQ钱包H5';
$arr_online_config['长城付QQ钱包H5']['post_url'] = '/member/pay/ccpay/pany.php?S_Type=QQPAY';
$arr_online_config['长城付QQ钱包H5']['merchant_url'] = $arr_online_config['长城付QQ钱包H5']['merchant_url2'];
{{e_qqpay_h5}}
{{s_jdpay}}
$arr_online_config['长城付京东钱包'] = $arr_online_config['ccf_pay'];
$arr_online_config['长城付京东钱包']['online_name'] = '京东钱包扫码';
$arr_online_config['长城付京东钱包']['post_url'] = '/member/pay/ccpay/pay.php?S_Type=JDPAY';
{{e_jdpay}}