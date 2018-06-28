<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('bfgl');

$params = array(':x_id' => $_GET['xid']);
$sql = 'select x_result from mydata4_db.t_guanjun where x_id=:x_id limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetch();
$result = $rows['x_result'];

$params = array(':tid' => $_GET['tid']);
$sql = 'select team_name from mydata4_db.t_guanjun_team where tid=:tid limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetch();
if ($result){
	$result .= '<br>' . $rows['team_name'];
}else{
	$result = $rows['team_name'];
}
$p
arams = array(':x_result' => $result, ':x_id' => $_GET['xid']);
$sql = 'update mydata4_db.t_guanjun set x_result=:x_result where x_id=:x_id';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
if ($stmt->rowCount() == 1)
{
	include_once '../../class/admin.php';
	admin::insert_log($_SESSION['adminid'], '设置了金融冠军赛事结果，金融冠军项目ID,' . $_GET['xid']);
}
header('location:' . $_SERVER['HTTP_REFERER']);
?>