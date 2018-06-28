<?php header('Content-Type:text/html;charset=utf-8');
include_once '../../../include/config.php';
include_once '../../../database/mysql.config.php';
include 'Auto_Class8.php';
$qi = floatval($_REQUEST['qi']);
$lotteryType =isset($_REQUEST['lottery_type'])?$_REQUEST['lottery_type']:'xyft';
$params = array(':qishu' => $qi);
$lotteryNames =array('xyft'=>'幸运飞艇','jsft'=>'极速飞艇');
$betNames =array('xyft'=>'XYFT','jsft'=>'JSFT');
$sql = 'select * from c_auto_8 where qishu=:qishu order by id desc limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rs = $stmt->fetch();
$hm = array();
$hm[] = $rs['ball_1'];
$hm[] = $rs['ball_2'];
$hm[] = $rs['ball_3'];
$hm[] = $rs['ball_4'];
$hm[] = $rs['ball_5'];
$hm[] = $rs['ball_6'];
$hm[] = $rs['ball_7'];
$hm[] = $rs['ball_8'];
$hm[] = $rs['ball_9'];
$hm[] = $rs['ball_10'];
if (($rs['ball_1'] === '') || ($rs['ball_2'] === '') || ($rs['ball_3'] === '') || ($rs['ball_4'] === '') || ($rs['ball_5'] === '') || ($rs['ball_6'] === '') || ($rs['ball_7'] === '') || ($rs['ball_8'] === '') || ($rs['ball_9'] === '') || ($rs['ball_10'] === ''))
{
	exit('获取开奖结果失败，停止结算！');
}
$paramsMain = array(':qishu' => $qi,'type'=>$lotteryNames[$lotteryType]);
$sqlMain = 'select * from c_bet_3 where type=:type and js=0 and qishu=:qishu order by addtime asc';
$stmtMain = $mydata1_db->prepare($sqlMain);
$stmtMain->execute($paramsMain);
while ($rows = $stmtMain->fetch())
{
	if ($rows['mingxi_1'] == '冠军')
	{
		$ds = Xyft_Ds($rs['ball_1']);
		$dx = Xyft_Dx($rs['ball_1']);
		if (($rows['mingxi_2'] == $rs['ball_1']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '亚军')
	{
		$ds = Xyft_Ds($rs['ball_2']);
		$dx = Xyft_Dx($rs['ball_2']);
		if (($rows['mingxi_2'] == $rs['ball_2']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第三名')
	{
		$ds = Xyft_Ds($rs['ball_3']);
		$dx = Xyft_Dx($rs['ball_3']);
		if (($rows['mingxi_2'] == $rs['ball_3']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第四名')
	{
		$ds = Xyft_Ds($rs['ball_4']);
		$dx = Xyft_Dx($rs['ball_4']);
		if (($rows['mingxi_2'] == $rs['ball_4']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第五名')
	{
		$ds = Xyft_Ds($rs['ball_5']);
		$dx = Xyft_Dx($rs['ball_5']);
		if (($rows['mingxi_2'] == $rs['ball_5']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第六名')
	{
		$ds = Xyft_Ds($rs['ball_6']);
		$dx = Xyft_Dx($rs['ball_6']);
		if (($rows['mingxi_2'] == $rs['ball_6']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第七名')
	{
		$ds = Xyft_Ds($rs['ball_7']);
		$dx = Xyft_Dx($rs['ball_7']);
		if (($rows['mingxi_2'] == $rs['ball_7']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第八名')
	{
		$ds = Xyft_Ds($rs['ball_8']);
		$dx = Xyft_Dx($rs['ball_8']);
		if (($rows['mingxi_2'] == $rs['ball_8']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第九名')
	{
		$ds = Xyft_Ds($rs['ball_9']);
		$dx = Xyft_Dx($rs['ball_9']);
		if (($rows['mingxi_2'] == $rs['ball_9']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第十名')
	{
		$ds = Xyft_Ds($rs['ball_10']);
		$dx = Xyft_Dx($rs['ball_10']);
		if (($rows['mingxi_2'] == $rs['ball_10']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if (($rows['mingxi_1'] == '冠、亚军和') && (3 <= $rows['mingxi_2']) && ($rows['mingxi_2'] <= 19))
	{
		$zonghe = Xyft_Auto($hm, 1);
		if ($rows['mingxi_2'] == $zonghe)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if (($rows['mingxi_2'] == '冠亚大') || ($rows['mingxi_2'] == '冠亚小'))
	{
		$zonghe = Xyft_Auto($hm, 2);
		if ($rows['mingxi_2'] == $zonghe)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if (($rows['mingxi_2'] == '冠亚双') || ($rows['mingxi_2'] == '冠亚单'))
	{
		$zonghe = Xyft_Auto($hm, 3);
		if ($rows['mingxi_2'] == $zonghe)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '1V10 龙虎')
	{
		$longhu = Xyft_Auto($hm, 4);
		if ($rows['mingxi_2'] == $longhu)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '2V9 龙虎')
	{
		$longhu = Xyft_Auto($hm, 5);
		if ($rows['mingxi_2'] == $longhu)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '3V8 龙虎')
	{
		$longhu = Xyft_Auto($hm, 6);
		if ($rows['mingxi_2'] == $longhu)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '4V7 龙虎')
	{
		$longhu = Xyft_Auto($hm, 7);
		if ($rows['mingxi_2'] == $longhu)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '5V6 龙虎')
	{
		$longhu = Xyft_Auto($hm, 8);
		if ($rows['mingxi_2'] == $longhu)
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
	$sql = "\r\n\t\t" . "INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,$betNames[$lotteryType],'RECKON',c_bet_3.id,(case when c_bet_3.win<0 then 0 when c_bet_3.win=0 then c_bet_3.money else c_bet_3.win end),k_user.money-(case when c_bet_3.win<0 then 0 when c_bet_3.win=0 then c_bet_3.money else c_bet_3.win end),k_user.money,:creationTime FROM k_user,c_bet_3  WHERE k_user.uid=c_bet_3.uid  AND c_bet_3.js=1 AND c_bet_3.id=:id";
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$params = array(':jieguo' => $rs['ball_1'] . ',' . $rs['ball_2'] . ',' . $rs['ball_3'] . ',' . $rs['ball_4'] . ',' . $rs['ball_5'] . ',' . $rs['ball_6'] . ',' . $rs['ball_7'] . ',' . $rs['ball_8'] . ',' . $rs['ball_9'] . ',' . $rs['ball_10'], ':id' => $rows['id']);
	$msql = 'update c_bet_3 set jieguo=:jieguo where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('注单修改失败!!!' . $rows['id']);
}
$params = array(':qishu' => $qi);
$msql = 'update c_auto_8 set ok=1 where qishu=:qishu';
$stmt = $mydata1_db->prepare($msql);
$stmt->execute($params) || exit('期数修改失败!!!');
if ($_GET['t'] == 1)
{?> <script>window.location.href='../../Lottery/auto_8.php?lottery_type=<?php echo $lotteryType?>';</script><?php }
function win_update($id, $money, $uid)
{
	global $mydata1_db;
	$params = array(':id' => $id);
	$msql = 'update c_bet_3 set js=1 where id=:id';
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
	$msql = 'update c_bet_3 set win=-money,js=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('注单修改失败!!!' . $id);
}?>