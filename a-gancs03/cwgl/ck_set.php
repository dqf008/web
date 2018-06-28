<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cwgl');
$ok = $_GET['ok'];
$m_id = intval($_GET['id']);
$msg = '操作失败';
if ($ok == 1){
	$sql = 'update k_money,k_user set k_money.status=1,k_money.update_time=now(),k_user.money=k_user.money+k_money.m_value,k_money.about=\'该订单手工操作成功\',k_money.sxf=k_money.m_value/100,k_money.balance=k_user.money+k_money.m_value where k_money.uid=k_user.uid and k_money.m_id=' . $m_id . ' and k_money.`status`=2';
	$result = $mydata1_db->query($sql);
	$q1 = $result->rowCount();
	if ($q1 == 2){
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':creationTime' => $creationTime, ':m_id' => $m_id);
		$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) 
		SELECT k_user.uid,k_user.username,\'ADMINACCOUNT\',\'IN\',k_money.m_order,k_money.m_value,k_user.money-k_money.m_value,k_user.money,:creationTime FROM k_user,k_money  WHERE k_user.uid=k_money.uid  AND k_money.status=1 AND k_money.m_id=:m_id';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$msg = '操作成功';
		include_once '../../class/admin.php';
		admin::insert_log($_SESSION['adminid'], '审核了编号为' . $m_id . '充值成功');
	}
}else{
	$sql = 'update k_money set status=0,about=\'该订单手工操作失败\',balance=assets where k_money.m_id='.$m_id.' and k_money.`status`=2';
	$result = $mydata1_db->query($sql);
	$q1 = $result->rowCount();
	if ($q1 == 1){
		$msg = '操作成功';
		include_once '../../class/admin.php';
		admin::insert_log($_SESSION['adminid'], '审核了编号为' . $m_id . '充值失败');
	}
}
message($msg, $_SERVER['HTTP_REFERER']);
?>