<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('glygl');
$action = $_GET['action'];
$uid = intval($_GET['id']);
if ($action == 'del')
{
	$sql = 'select count(*) from mydata3_db.sys_admin';
	$result = $mydata1_db->query($sql);
	$row_num = $result->fetchColumn();
	if ($row_num <= 1){
		message('没有多余的管理员账号，不能删除', 'user.php');
	}
	$params = array(':uid' => $uid);
	$sql = 'delete from mydata3_db.sys_admin where uid=:uid';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	message('删除成功', 'user.php');
}else{
	$params = array(':uid' => $uid);
	$sql = 'update mydata3_db.sys_admin set is_login=0 where uid=:uid';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	message('踢线成功', 'user.php');
}
?>