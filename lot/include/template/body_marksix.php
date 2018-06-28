<?php
!defined('IN_LOT')&&die('Access Denied');
$LOT['marksix']['menu'] = array(
    'tema' => array(1, 2),
    'zhengma' => array(3, 4),
    'zhengte' => array(5, 6, 7, 8, 9, 10),
    'zhengma6' => array(11),
    'guoguan' => array(17),
    'banbo' => array(23),
    'yixiao' => array(24),
    'weishu' => array(25),
    'texiao' => array(26),
    'shengxiaolian' => array(27),
    'weishulian' => array(34),
    'hexiao' => array(40, 41, 42, 43, 44, 45, 46, 47, 48, 49),
    'quanbuzhong' => array(50, 51, 52, 53, 54, 55, 56, 57),
    'lianma' => array(58, 59, 60, 61, 62, 63),
);
$LOT['marksix']['type'] = isset($_GET['t'])&&isset($LOT['marksix']['menu'][$_GET['t']])?$_GET['t']:'tema';
$LOT['marksix']['pan'] = isset($_GET['p'])&&in_array($_GET['p'], $LOT['marksix']['menu'][$LOT['marksix']['type']])?$_GET['p']:$LOT['marksix']['menu'][$LOT['marksix']['type']][0];
include(IN_LOT.'include/template/marksix/'.$LOT['marksix']['type'].'.php');