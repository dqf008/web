<?php 
session_start();
include_once 'include/config.php';
include_once 'database/mysql.config.php';
include_once 'class/user.php';
include_once 'common/function.php';
header('Content-type: text/html;charset=utf-8');

if(!empty($_SESSION['adminid']) && !empty($_GET['uid'])){
		$uid = (int)$_GET['uid'];
		$info = user::getinfo($uid);
		$_POST['action'] = 'login';
		$_POST['vlcodes'] = '8888';
		$_SESSION['randcode'] = '8888';
		$_POST['username'] = $info['username'];
		$_POST['password'] = $info['sex'];
	}
if ($_POST['action'] == 'login'){
	

	if (strtolower($_POST['vlcodes']) != $_SESSION['randcode']) die('1');
	
	$uid = user::login(htmlEncode($_POST['username']), htmlEncode($_POST['password']));
	
	if (!$uid) die('2');
	
	if(!empty($_SESSION['adminid']) && !empty($_GET['uid'])) {
		header('Location:/');die();
	}
	die('4');
}
die('1');