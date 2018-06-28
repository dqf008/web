<?php 
session_start();
header('Content-type: text/html;charset=utf-8');
if (!isset($_SESSION['uid']) || !isset($_SESSION['username']) || !isset($_SESSION['password'])){
	echo "<script>alert('您的登录可能已过期，请重新登录！');window.open('/logout.php','_top');</script>";
	exit();
}else{
	$params = array(':uid' => $_SESSION['uid']);
	$stmt = $mydata1_db->prepare('select username,password from k_user where uid=:uid and is_stop=0 limit 1');
	$stmt->execute($params);
	$check_user_obj = $stmt->fetch();
	if (($check_user_obj['username'] != $_SESSION['username']) || ($check_user_obj['password'] != md5($_SESSION['password']))){
		echo "<script>alert('您的登录可能已过期，请重新登录！');window.open('/logout.php','_top');</script>";
		exit();
	}
}
?>
