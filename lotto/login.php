<?php 
require_once 'conjunction.php';
require_once 'config.php';
if (ka_memuser('stat') == 1){
	echo "<script>alert('对不起,该用户已被禁止!');top.location.href='index.php?action=logout';</script>";
	exit();
}

if ($_SESSION['username']){
	$guanguan1 = $_SESSION['username'];
	$params = array(':kauser' => $guanguan1);
	$stmt = $mydata2_db->prepare('select count(*) from ka_mem where kauser=:kauser order by id desc');
	$stmt->execute($params);
	$num = $stmt->fetchColumn();
	if ($num == 0){
		echo "<script>alert('账号未开通六合彩游戏，请联系管理员!');top.location.href='index.php?action=logout';</script>";
		exit();
	}
	$guanguan1 = ka_memuser('guan');
	$params = array(':kauser' => $guanguan1);
	$stmt = $mydata2_db->prepare('select * from ka_guan where kauser=:kauser order by id');
	$stmt->execute($params);
	$row = $stmt->fetch();
	if ($row['stat'] == 1){
		echo "<script>alert('对不起,该上级用户已被禁止,有问题请联系你上级!');top.location.href='index.php?action=logout';</script>";
		exit();
	}
	$zongzong1 = ka_memuser('zong');
	$params = array(':kauser' => $zongzong1);
	$stmt = $mydata2_db->prepare('select * from ka_guan where kauser=:kauser order by id');
	$stmt->execute($params);
	$row = $stmt->fetch();
	if ($row['stat'] == 1){
		echo "<script>alert('对不起,该上级用户已被禁止,有问题请联系你上级!');top.location.href='index.php?action=logout';</script>";
		exit();
	}
	$dandan1 = ka_memuser('dan');
	$params = array(':kauser' => $dandan1);
	$stmt = $mydata2_db->prepare('select * from ka_guan where kauser=:kauser order by id');
	$stmt->execute($params);
	$row = $stmt->fetch();
	if ($row['stat'] == 1){
		echo "<script>alert('对不起,该上级用户已被禁止,有问题请联系你上级!');top.location.href='index.php?action=logout';</script>";
		exit();
	}
	$params = array(':username' => $_SESSION['username'], ':ip' => $ip);
	$stmt = $mydata2_db->prepare('update tj set tr=1 where username=:username and ip<>:ip');
	$stmt->execute($params);
}
?>