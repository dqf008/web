<?php
define('PAY_PATH', dirname(__FILE__) . '/');
include_once __DIR__ . '/../../class/Db.class.php';
$NAME_ENUM = array(
    'bank' => '网银',
    'bank_wap' => '手机网银',
    'wechat' => '微信',
    'wechat_wap' => '手机微信',
    'wechat_h5' => '微信H5',
    'alipay' => '支付宝',
    'alipay_wap' => '手机支付宝',
    'alipay_h5' => '支付宝H5',
    'qqpay' => 'QQ钱包',
    'qqpay_wap' => '手机QQ钱包',
    'qqpay_h5' => 'QQ钱包h5',
    'jdpay' => '京东钱包',
    'jdpay_wap' => '手机京东钱包',

);