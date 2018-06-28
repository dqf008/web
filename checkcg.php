<?php session_start();
header('Content-type: text/json;charset=utf-8');
include_once 'cache/group_' . $_SESSION['gid'] . '.php';
include_once 'include/config.php';
website_close();
website_deny();
include_once 'database/mysql.config.php';
$bet_money = $_REQUEST['bet_money'];
$dz = $dz_db['串关'];
$dc = $dc_db['串关'];
if (!$dz || ($dz == ''))
{
	$dz = $dz_db['未定义'];
}
if (!$dc || ($dc == ''))
{
	$dc = $dc_db['未定义'];
}
if ($bet_money <= $dz)
{
	$s_t = strftime('%Y-%m-%d', time()) . ' 00:00:00';
	$e_t = strftime('%Y-%m-%d', time()) . ' 23:59:59';
	$params = array(':uid' => $_SESSION['uid'], ':s_t' => $s_t, ':e_t' => $e_t);
	$sql = 'select sum(bet_money) as s from `k_bet_cg_group` where uid=:uid and bet_time>=:s_t and bet_time<=:e_t and `status`!=3';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rs_money = $stmt->fetchColumn();
	if ($rs_money + $bet_money <= $dc)
	{
		$json['result'] = 'ok';
		$_SESSION['check_action'] = 'true';
	}
	else
	{
		$json['result'] = '您本次交易：' . $bet_money . "\n" . '串关当天限额：' . $dc . "\n" . '您今天已交易：' . $t['s'] . "\n" . '本次允许交易：' . ($dc - $t['s']);
	}
}
else if ($_SESSION['gid'])
{
	$json['result'] = '您本次交易：' . $bet_money . "\n" . '串关单注限额：' . $dz;
}
else
{
	$json['result'] = 'wdl';
}
 echo json_encode($json);
exit();?>