<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('ssgl');
$sql = '';
if ($_GET['type'] == 2){
	$params = array(':tid' => intval($_GET['tid']));
	$sql = 'delete from mydata4_db.t_guanjun_team where tid=:tid';
}
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
if ($stmt->rowCount() == 1){
	include_once '../../class/admin.php';
	if ($_GET['type'] == 1){
		admin::insert_log($_SESSION['adminid'], '清除了金融冠军赛事结果：' . $_GET['xid']);
	}
}
$xid = intval($_GET['xid']);
header('location:x_show.php?id=' . $xid);
?>