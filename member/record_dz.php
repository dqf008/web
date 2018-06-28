<?php
$_LIVE = include(dirname(dirname(__FILE__)).'/cj/include/live.php');
$liveList = array();
foreach($_LIVE as $key=>$val){
	$val[2]=='dz_rate'&&$key!=6&&$liveList[$key] = array($val[1], $val[0]);
}
$liveTitle = '电子游艺';
include_once './record_zr.php';