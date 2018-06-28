<?php session_start();
header('Content-Type:text/html;charset=utf-8');
include_once '../../cache/group_' . @($_SESSION['gid']) . '.php';
$cp_zd = @($pk_db['彩票最低']);
$cp_zg = @($pk_db['彩票最高']);
if (0 < $cp_zd)
{
	$cp_zd = $cp_zd;
}
else
{
	$cp_zd = 10;
}
if (0 < $cp_zg)
{
	$cp_zg = $cp_zg;
}
else
{
	$cp_zg = 1000000;
}
$arr = array('cp_zd' => $cp_zd, 'cp_zg' => $cp_zg);
$json_string = json_encode($arr);
 echo $json_string;?>