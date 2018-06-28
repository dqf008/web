<?php 
session_start();
include_once '../include/config.php';
include_once '../database/mysql.config.php';
$params = array(':uid' => intval($_SESSION['adminid']));
$sql = 'update mydata3_db.sys_admin set is_login=0 where is_login=1 and uid=:uid';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$_SESSION = array();
if (isset($_COOKIE[session_name()]))
{
	setcookie(session_name(), '', time() - 42000, '/');
}
session_destroy();
header('location:index.html');
?>