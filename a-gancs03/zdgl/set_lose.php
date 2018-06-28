<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';

$bid = intval($_GET['bid']);
$isok = intval($_GET['lose_ok']);
$status = intval($_GET['status']);
$num = 0;

if ($bid < 1){
	message('操作失败', 'bet_lose.php');
}

if ($isok == 1){
	$params = array(':bid' => $bid);
	$sql = 'update k_bet set lose_ok=1,update_time=now() where bid=:bid and lose_ok=0';
	$msg = '滚球注单有效';
	$num = 1;
}

if ($isok == 0){
	$params = array(':bid' => $bid);
	$sql = 'select bet_info,master_guest from k_bet where bid=:bid limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$t = $stmt->fetch();
	$match_info = $t['bet_info'];
	$msg_title = $t['master_guest'] . '_注单已取消';
	$why = '';
	if ($status == 7){
		$why = '红卡无效';
		$msg = '滚球注单红卡无效';
		$msg_info = $t['master_guest'] . '<br/>' . $t['bet_info'] . '<br /><font style="color:#F00"/>因红卡无效，该注单取消，已返还本金。</font>';
	}
	
	if ($status == 6){
		$why = '进球无效';
		$msg = '滚球注单进球无效';
		$msg_info = $t['master_guest'] . '<br/>' . $t['bet_info'] . '<br /><font style="color:#F00"/>因进球无效，该注单取消，已返还本金。</font>';
	}
	
	if ($status == 3){
		$why = '手工无效';
		$msg = '注单无效';
		$msg_info = $t['master_guest'] . '<br/>' . $t['bet_info'] . '<br /><font style="color:#F00"/>该注单取消，已返还本金。</font>';
	}
	
	$params = array(':status' => $status, ':sys_about' => $why, ':bid' => $bid);
	$sql = 'update k_bet,k_user set k_bet.lose_ok=1,k_bet.status=:status,k_user.money=k_user.money+k_bet.bet_money,k_bet.win=k_bet.bet_money,k_bet.update_time=now(),k_bet.sys_about=:sys_about where k_user.uid=k_bet.uid and k_bet.bid=:bid';
	$num = 2;
}

$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$q1 = $stmt->rowCount();
if ($q1 == $num){
	if ($isok == 0){
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':creationTime' => $creationTime, ':bid' => $bid);
		$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) 
		SELECT k_user.uid,k_user.username,\'SportsDS\',\'CANCEL_BET\',k_bet.number,k_bet.win,k_user.money-k_bet.win,k_user.money,:creationTime FROM k_user,k_bet WHERE k_user.uid=k_bet.uid AND k_bet.bid=:bid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
	}
	
	include_once '../../class/admin.php';
	include_once '../../class/user.php';
	if ($isok == 0){
		$uid = intval($_GET['uid']);
		user::msg_add($uid, $web_site['reg_msg_from'], $msg_title, $msg_info);
	}
	admin::insert_log($_SESSION['adminid'], '审核了编号为' . $bid . '的' . $msg);
	message($msg . ' 操作成功', 'bet_lose.php');
}else{
	message($msg . ' 操作失败', 'bet_lose.php');
}
?>