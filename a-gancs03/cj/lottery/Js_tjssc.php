<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../../include/config.php';
include_once '../../../database/mysql.config.php';
include 'auto_class.php';
$qi = floatval($_REQUEST['qi']);
$params = array(':qishu' => $qi);
$sql = 'select * from c_auto_tjssc where qishu=:qishu order by id desc limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rs = $stmt->fetch();
$hm = array();
$hm[] = $rs['ball_1'];
$hm[] = $rs['ball_2'];
$hm[] = $rs['ball_3'];
$hm[] = $rs['ball_4'];
$hm[] = $rs['ball_5'];
if (($rs['ball_1'] === '') || ($rs['ball_2'] === '') || ($rs['ball_3'] === '') || ($rs['ball_4'] === '') || ($rs['ball_5'] === ''))
{
	exit('获取开奖结果失败，停止结算！');
}
$paramsMain = array(':qishu' => $qi);
$sqlMain = 'select * from c_bet where type=\'天津时时彩\' and js=0 and qishu=:qishu order by addtime asc';
$stmtMain = $mydata1_db->prepare($sqlMain);
$stmtMain->execute($paramsMain);
while ($rows = $stmtMain->fetch())
{
	if ($rows['mingxi_1'] == '第一球')
	{
		$ds = Ssc_Ds($rs['ball_1']);
		$dx = Ssc_Dx($rs['ball_1']);
		if (('ABC' . $rows['mingxi_2'] == 'ABC' . $rs['ball_1']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第二球')
	{
		$ds = Ssc_Ds($rs['ball_2']);
		$dx = Ssc_Dx($rs['ball_2']);
		if (('ABC' . $rows['mingxi_2'] == 'ABC' . $rs['ball_2']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第三球')
	{
		$ds = Ssc_Ds($rs['ball_3']);
		$dx = Ssc_Dx($rs['ball_3']);
		if (('ABC' . $rows['mingxi_2'] == 'ABC' . $rs['ball_3']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第四球')
	{
		$ds = Ssc_Ds($rs['ball_4']);
		$dx = Ssc_Dx($rs['ball_4']);
		if (('ABC' . $rows['mingxi_2'] == 'ABC' . $rs['ball_4']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第五球')
	{
		$ds = Ssc_Ds($rs['ball_5']);
		$dx = Ssc_Dx($rs['ball_5']);
		if (('ABC' . $rows['mingxi_2'] == 'ABC' . $rs['ball_5']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if (($rows['mingxi_2'] == '总和大') || ($rows['mingxi_2'] == '总和小'))
	{
		$zonghe = Ssc_Auto($hm, 2);
		if ($rows['mingxi_2'] == $zonghe)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if (($rows['mingxi_2'] == '总和单') || ($rows['mingxi_2'] == '总和双'))
	{
		$zonghe = Ssc_Auto($hm, 3);
		if ($rows['mingxi_2'] == $zonghe)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if (($rows['mingxi_2'] == '龙') || ($rows['mingxi_2'] == '虎') || ($rows['mingxi_2'] == '和'))
	{
		$longhu = Ssc_Auto($hm, 4);
		if ($rows['mingxi_2'] == $longhu)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '前三')
	{
		$qiansan = Ssc_Auto($hm, 5);
		if ($rows['mingxi_2'] == $qiansan)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '中三')
	{
		$zhongsan = Ssc_Auto($hm, 6);
		if ($rows['mingxi_2'] == $zhongsan)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '后三')
	{
		$housan = Ssc_Auto($hm, 7);
		if ($rows['mingxi_2'] == $housan)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	$creationTime = date('Y-m-d H:i:s');
	$id = $rows['id'];
	$params = array(':creationTime' => $creationTime, ':id' => $id);
	$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'TJSSC\',\'RECKON\',c_bet.id,(case when c_bet.win<0 then 0 when c_bet.win=0 then c_bet.money else c_bet.win end),k_user.money-(case when c_bet.win<0 then 0 when c_bet.win=0 then c_bet.money else c_bet.win end),k_user.money,:creationTime FROM k_user,c_bet  WHERE k_user.uid=c_bet.uid  AND c_bet.js=1 AND c_bet.id=:id';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$params = array(':jieguo' => $rs['ball_1'] . ',' . $rs['ball_2'] . ',' . $rs['ball_3'] . ',' . $rs['ball_4'] . ',' . $rs['ball_5'], ':id' => $rows['id']);
	$msql = 'update c_bet set jieguo=:jieguo where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('注单修改失败!!!' . $rows['id']);
}
$params = array(':qishu' => $qi);
$msql = 'update c_auto_tjssc set ok=1 where qishu=:qishu';
$stmt = $mydata1_db->prepare($msql);
$stmt->execute($params) || exit('期数修改失败!!!');
if ($_GET['t'] == 1)
{?> <script>window.location.href='../../Lottery/auto_tjssc.php';</script><?php }
function win_update($id, $money, $uid)
{
	global $mydata1_db;
	$params = array(':id' => $id);
	$msql = 'update c_bet set js=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('注单修改失败!!!' . $id);
	$q1 = $stmt->rowCount();
	if ($q1 == 1)
	{
		$params = array(':money' => $money, ':uid' => $uid);
		$msql = 'update k_user set money=money+:money where uid=:uid';
		$stmt = $mydata1_db->prepare($msql);
		$stmt->execute($params) || exit('会员修改失败!!!' . $id);
	}
}
function no_win_update($id)
{
	global $mydata1_db;
	$params = array(':id' => $id);
	$msql = 'update c_bet set win=-money,js=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('注单修改失败!!!' . $id);
}?>