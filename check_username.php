<?php header('Content-Type:text/html;charset=utf-8');

include_once 'include/config.php';
website_close();
website_deny();
include_once 'database/mysql.config.php';
include_once 'common/function.php';
$username = htmlEncode($_GET['username']);
$params = array(':username' => $username);
$sql = 'select uid from k_user where username=:username limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rs_uid = $stmt->fetchColumn();

if ($rs_uid){ 
	echo 'n';
}else{ 
	echo 'y';
}
exit();
?>