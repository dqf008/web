<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('zdgl');

$gid = intval($_GET['gid']);
$count = 0;
$params = array(':gid' => $gid);
$sql = 'select `status`,cg_count from k_bet_cg_group where `status` in(1,3) and gid=:gid limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetch();
$count = $rows['cg_count'];
$params = array(':gid' => $gid);
if ($rows['status'] == 1){
	$sql = 'update k_user,k_bet_cg_group set k_user.money=k_user.money-k_bet_cg_group.win,k_bet_cg_group.status=0,k_bet_cg_group.win=0,k_bet_cg_group.update_time=null,k_bet_cg_group.cg_count=(select count(*) from k_bet_cg where gid=k_bet_cg_group.gid) where k_user.uid=k_bet_cg_group.uid and k_bet_cg_group.gid=:gid';
}else if ($rows['status'] == 3){
	$sql = 'update k_user,k_bet_cg_group set k_user.money=k_user.money-k_bet_cg_group.win,k_bet_cg_group.status=0,k_bet_cg_group.win=0,k_bet_cg_group.update_time=null,k_bet_cg_group.cg_count=(select count(*) from k_bet_cg where gid=k_bet_cg_group.gid) where k_user.uid=k_bet_cg_group.uid and k_bet_cg_group.gid=:gid';
}

$creationTime = date('Y-m-d H:i:s');
$paramsSub = array(':creationTime' => $creationTime, ':gid' => $gid);
$sqlSub = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) 
SELECT k_user.uid,k_user.username,\'SportsCG\',\'RECALC\',k_bet_cg_group.gid,-k_bet_cg_group.win,k_user.money,k_user.money-k_bet_cg_group.win,:creationTime FROM k_user,k_bet_cg_group WHERE k_user.uid=k_bet_cg_group.uid AND k_bet_cg_group.gid=:gid';
$stmtSub = $mydata1_db->prepare($sqlSub);
$stmtSub->execute($paramsSub);
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$q1 = $stmt->rowCount();

$params = array(':gid' => $gid);
$sql = 'update k_bet_cg set status=0 where gid=:gid';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$q2 = $stmt->rowCount();
if ($q1 && ($q2 == $count)){
	$msg = '操作成功';
}else{
	$msg = '操作失败' . 'q1:' . $q1 . 'q2:' . $q2;
}
message($msg, $_SERVER['HTTP_REFERER']);
?>