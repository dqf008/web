<?php
	session_start();
	$_SESSION['uid'] = 2;
	isset($_SESSION['uid']) or die('Access Denied');
	define('PAY', true);
	include '../cache/website.php';
	include '../class/Db.class.php';
	include '../class/Pay.class.php';
	include 'list.conf.php';
	$least_money = sprintf("%.2f",$web_site['ck_limit']);
	$money = $_POST['money'];
	$money = '2500.111';
	$money = sprintf("%.2f",$money);
	if($money < $least_money && $money <= 0){
		die('最小金额为：'.$least_money);
	}
	$pay = $_GET['pay'];
	array_key_exists($pay, $pay_list) or die('Access Denied');
	$payinfo = $pay_list[$pay];
	include $payinfo['path'] . '/index.php';