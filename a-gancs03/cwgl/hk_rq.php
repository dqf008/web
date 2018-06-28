<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cwgl');
$id = intval($_GET['id']);
$status = $_GET['status'];
$sql = '';
$num = 0;
if ($status == '1'){
	$sql = 'update k_user,huikuan set k_user.money=k_user.money-huikuan.money-huikuan.zsjr,huikuan.status=0,huikuan.balance=k_user.money-huikuan.money-huikuan.zsjr where k_user.uid=huikuan.uid and huikuan.id=' . $id . ' and huikuan.status=1';
	$num = 2;
}else{
	$sql = 'update huikuan set status=0,balance=assets where id=' . $id . ' and status=2';
	$num = 1;
}
$result = $mydata1_db->query($sql);
$q1 = $result->rowCount();
if ($q1 == $num){
	if ($status == '1'){
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':creationTime' => $creationTime, ':id' => $id);
		$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)
		SELECT k_user.uid,k_user.username,\'HUIKUAN\',\'ROLLBACK\',huikuan.lsh,-huikuan.money-huikuan.zsjr,k_user.money+(huikuan.money+huikuan.zsjr),k_user.money,:creationTime FROM k_user,huikuan WHERE k_user.uid=huikuan.uid AND huikuan.status=0 AND huikuan.id=:id';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
	}
	include_once '../../class/admin.php';
	admin::insert_log($_SESSION['adminid'], '重新审核了编号为' . $id . '的汇款单');
	message('操作成功', 'huikuan.php?status=0');
}else{
	message('操作失败');
}
?>