<?php
define('PAY_PATH', dirname(__FILE__) . '/');
include_once $_SERVER['DOCUMENT_ROOT'] . '/database/mysql.config.php';

$NAME_ENUM = array(
    'bank' => '网银',
    'wechat' => '微信',
    'alipay' => '支付宝',
    'qq' => 'QQ钱包'
);

function getUserConf($pay)
{
    $path = PAY_PATH . $pay . '/user_conf.json';
    if (file_exists($path)) {
        return json_decode(file_get_contents($path), true);
    }
    return null;
}

function saveUserConf($pay, $data)
{
    $path = PAY_PATH . $pay . '/user_conf.json';
    if (empty($data['status'])) {
        $data['status'] = 0;
    }
    file_put_contents($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

function getDefaultConf($pay)
{
    $path = PAY_PATH . $pay . '/conf.json';
    return json_decode(file_get_contents($path), true);
}

function saveDefaultConf($pay, $data)
{
    $path = PAY_PATH . $pay . '/conf.json';
    file_put_contents($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}
