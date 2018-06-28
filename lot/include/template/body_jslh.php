<?php
!defined('IN_LOT')&&die('Access Denied');
$LOT['six']['i'] = 'jslh';
$LOT['six']['menu'] = array(
    'tema' => array(1),
    'zhengma' => array(2),
    'zhengte' => range(3, 8),
    'zhengma6' => array(11),
    'guoguan' => array(15),
    'banbo' => array(21),
    'yixiao' => array(22),
    'weishu' => array(23),
    'texiao' => array(24),
    'shengxiaolian' => array(25),
    'weishulian' => array(34),
    'hexiao' => range(38, 47),
    'quanbuzhong' => range(48, 55),
    'lianma' => range(56, 61),
);
$LOT['six']['type'] = isset($_GET['t'])&&isset($LOT['six']['menu'][$_GET['t']])?$_GET['t']:'tema';
$LOT['six']['pan'] = isset($_GET['p'])&&in_array($_GET['p'], $LOT['six']['menu'][$LOT['six']['type']])?$_GET['p']:$LOT['six']['menu'][$LOT['six']['type']][0];
include(IN_LOT.'include/template/six/'.$LOT['six']['type'].'.php');