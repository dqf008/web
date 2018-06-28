<?php
include(dirname(dirname(__FILE__)).'/cj/include/config.php');
$_egame = array();
$_egame['web_id'] = $site_id;
$_egame['pid'] = 'P06';
$_egame['lang'] = 'zh';
//$_egame['url'] = 'https://egame-ssl.ub-66.com/';
$_egame['url'] = 'http://egame.ub-66.com/';
$_egame['cur'] = 'CNY';
$_egame['des'] = 'CXH827hb'; //调用框架 DES 加密密钥
$_egame['md5'] = 'MdzmmgGzHvgd'; //调用框架 MD5 加密密钥
$_egame['token'] = '959923777'; //自定义信息加密key