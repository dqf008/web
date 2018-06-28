<?php 
header('Content-type: text/json;charset=utf-8');
session_start();
include_once __DIR__ . '/../include/config.php';
include_once __DIR__ . '/../database/mysql.config.php';
include_once __DIR__ . '/common/login_check.php';

$callback = $_GET['callback'];
$tknum = $ssnum = $hknum = $tsjynum = $dlsqnum = $cgnum = 0;
$quanxian = $_SESSION['quanxian'];
$sql = 'update k_money set `status`=0,update_time=now(),about=\'该订单系统操作失败\',balance=assets where type=1 and `status`=2 and m_value>0 and m_make_time<=DATE_SUB(now(),INTERVAL 30 MINUTE)';
$mydata1_db->query($sql);
$params = array(':updatetime' => time(), ':uid' => intval($_SESSION['adminid']));
$sql = 'update mydata3_db.sys_admin set updatetime=:updatetime where is_login=1 and uid=:uid';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$time = time() - 300;
$params = array(':updatetime' => $time);
$sql = 'update mydata3_db.sys_admin set is_login=0 where is_login=1 and updatetime<:updatetime';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
if (strpos($quanxian, 'cwgl')){
	$sql = 'select count(*) as s from k_money where m_value<0 and type=2 and status=2';
	$query = $mydata1_db->query($sql);
	$tknum = $query->fetchColumn();
	$sql = 'select count(*) as s from huikuan where status=0';
	$query = $mydata1_db->query($sql);
	$hknum = $query->fetchColumn();
}

if (strpos($quanxian, 'xxgl')){
	$sql = 'select count(*) as s from ban_ip where message is not null and is_jz=1';
	$query = $mydata1_db->query($sql);
	$ssnum = $query->fetchColumn();
	$sql = 'select count(*) as s from message where islook=0';
	$query = $mydata1_db->query($sql);
	$tsjynum = $query->fetchColumn();
	$sql = 'select count(1) as s from k_notice where is_class = 9';
	$query = $mydata1_db->query($sql);
	$xtggnum = $query->fetchColumn();
}

if (strpos($quanxian, 'dlgl')){
	$sql = 'select count(*) as s from k_user_daili where `status`=0';
	$query = $mydata1_db->query($sql);
	$dlsqnum = $query->fetchColumn();
}

if (strpos($quanxian, 'hygl')){
	$sql = 'select count(*) as s from k_user where money<0 and is_delete=0 and is_stop=0';
	$query = $mydata1_db->query($sql);
	$ychynum = $query->fetchColumn();
}

if (strpos($quanxian, 'zdgl')){
	$sql = 'SELECT count(*) as s FROM k_bet_cg_group cg where cg.`status` in (0,2) and cg.cg_count=(select count(*) from k_bet_cg c where c.gid=cg.gid and c.`status` not in(0,3))';
	$query = $mydata1_db->query($sql);
	$cgnum = $query->fetchColumn();
}
$json['sum'] = $tknum + $ssnum + $hknum + $tsjynum + $dlsqnum + $ychynum + $cgnum + $xtggnum;
$json['tknum'] = $tknum;
$json['ssnum'] = $ssnum;
$json['hknum'] = $hknum;
$json['tsjynum'] = $tsjynum;
$json['dlsqnum'] = $dlsqnum;
$json['ychynum'] = $ychynum;
$json['cgnum'] = $cgnum;
$json['xtggnum'] = $xtggnum;
echo $callback."(".json_encode($json).");";
exit;
?>