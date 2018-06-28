 ﻿<?php include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../class/user.php';
include_once '../common/function.php';
$msg_id = intval($_GET['id']);
if ($msg_id < 0)
{
	$params = array(':uid' => intval($_SESSION['uid']));
	$sql = 'delete from k_user_msg where uid=:uid';
}
else
{
	$params = array(':msg_id' => $msg_id, ':uid' => intval($_SESSION['uid']));
	$sql = 'delete from k_user_msg where msg_id=:msg_id and uid=:uid';
}
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);?><script type='text/javascript' src='images/member.js'></script> <script>Go('sys_msg.php');</script><?php unset($db);?>