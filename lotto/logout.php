<?php 
if (!defined('PHPYOU'))
{
	exit('Access Denied');
}
$params = array(':username' => $_SESSION['username']);
$stmt = $mydata2_db->prepare('delete from tj where username=:username');
$stmt->execute($params);
echo "<script>top.location.href='/';</script>";
exit();
?>