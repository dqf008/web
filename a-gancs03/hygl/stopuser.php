<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('hygl');
$page = $_GET['page'];
$go = $_GET['go'];
$arr = $_POST['uid'];
$uid = '';
$i = 0;
foreach ($arr as $k => $v){
	$uid .= intval($v) . ',';
	$i++;
}

$uid = rtrim($uid, ',');
$log_message = '';
$params = array();
if ($go == 1){
	$log_message = '停用会员';
	$params[':why'] = '管理员：' . $_SESSION['login_name'] . ' 停用此账户';
	$sql = 'UPDATE k_user set is_stop=1,why=concat_ws(\'，\',why,:why) where uid in (' . $uid . ') and is_stop=0';
}else if ($go == 0){
	$log_message = '启用会员';
	$sql = 'UPDATE k_user set is_stop=0 where uid in (' . $uid . ') and is_stop=1';
}else if ($go == 3){
	$log_message = '踢线会员';
	$sql = 'update k_user_login set `is_login`=0 where uid in (' . $uid . ') and `is_login`>0';
}else if ($go == 4){
	$log_message = '取消代理';
	$sql = 'update k_user set is_daili=0 where uid in (' . $uid . ') and is_daili=1';
}else if ($go == 6){
	$log_message = '删除会员';
	check_quanxian('hysc');
	$sql = 'delete from k_user where uid in (' . $uid . ')';
}else if ($go == 7){
	$daili = $_GET['daili'];
	$log_message = '转移代理(' . $daili . ')';
	check_quanxian('zydl');
	$params_u[':daili'] = $daili;
	$sql_daili = 'select uid from k_user where username=:daili and is_daili=1 limit 1';
	$stmt_u = $mydata1_db->prepare($sql_daili);
	$stmt_u->execute($params_u);
	$kuid = $stmt_u->fetchColumn();
	if (($kuid == NULL) || ($kuid == 0) || ($kuid == '')){
		$msg = '代理不存在！';
		message($msg, 'list.php?page=' . $page);
	}
	$params[':daili'] = $kuid;
	$sql = 'update k_user set top_uid = :daili where uid in (' . $uid . ')';
}else if ($go == 8){
	$log_message = '允许额度转换';
	$sql = 'update k_user set iszhuan=1 where uid in (' . $uid . ') and iszhuan=0';
}else if ($go == 9){
	$log_message = '不允许额度转换';
	$sql = 'update k_user set iszhuan=0 where uid in (' . $uid . ') and iszhuan=1';
}
include_once '../../class/admin.php';
$message = $log_message . ':' . $uid;
admin::insert_log($_SESSION['adminid'], $message);
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$msg = '操作成功！';
message($msg, 'list.php?page=' . $page);
?>