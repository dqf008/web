<?php header('Content-Type:text/html;charset=utf-8');
include_once '../../../include/config.php';
include_once '../../../database/mysql.config.php';
include 'Auto_Class3.php';
$lotteryType = isset($_GET['lottery_type'])?$_GET['lottery_type']:'gdkl10';
$lotteryNames = array('gdkl10'=>'广东快乐10分','cqkl10'=>'重庆快乐10分','tjkl10'=>'天津快乐10分','hnkl10'=>'湖南快乐10分','sxkl10'=>'山西快乐10分','ynkl10'=>'云南快乐10分');
$betNames =array('gdkl10'=>'GDKLSF','cqkl10'=>'CQKLSF','tjkl10'=>'TJKLSF','hnkl10'=>'HNKLSF','sxkl10'=>'SXKLSF','ynkl10'=>'YNKLSF');
$qi = floatval($_REQUEST['qi']);
$params = array(':qishu' => $qi);
if($lotteryType =='gdkl10') {
    $sql = 'select * from c_auto_3 where qishu=:qishu order by id desc limit 1';
}else{
    $params['name'] = $lotteryType;
    $sql = 'select * from c_auto_klsf where qishu=:qishu and name=:name order by id desc limit 1';
}
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
if (($rs['ball_1'] === '') || ($rs['ball_2'] === '') || ($rs['ball_3'] === '') || ($rs['ball_4'] === '') || ($rs['ball_5'] === '') || ($rs['ball_6'] === '') || ($rs['ball_7'] === '') || ($rs['ball_8'] === ''))
{
	exit('获取开奖结果失败，停止结算！');
}
$paramsMain = array(':qishu' => $qi);
$sqlMain = "select * from c_bet_3 where type='$lotteryNames[$lotteryType]' and js=0 and qishu=:qishu order by addtime asc";
$stmtMain = $mydata1_db->prepare($sqlMain);
$stmtMain->execute($paramsMain);
while ($rows = $stmtMain->fetch())
{
	if ($rows['mingxi_1'] == '第一球')
	{
		$ds = Klsf_Ds($rs['ball_1']);
		$dx = Klsf_Dx($rs['ball_1']);
		$wdx = Klsf_Wdx($rs['ball_1']);
		$hds = Klsf_Hdx($rs['ball_1']);
		$zfb = Klsf_Zfb($rs['ball_1']);
		$dnxb = Klsf_Dnxb($rs['ball_1']);
		if (($rows['mingxi_2'] == $rs['ball_1']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx) || ($rows['mingxi_2'] == $wdx) || ($rows['mingxi_2'] == $hds) || ($rows['mingxi_2'] == $zfb) || ($rows['mingxi_2'] == $dnxb))
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
		$ds = Klsf_Ds($rs['ball_2']);
		$dx = Klsf_Dx($rs['ball_2']);
		$wdx = Klsf_Wdx($rs['ball_2']);
		$hds = Klsf_Hdx($rs['ball_2']);
		$zfb = Klsf_Zfb($rs['ball_2']);
		$dnxb = Klsf_Dnxb($rs['ball_2']);
		if (($rows['mingxi_2'] == $rs['ball_2']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx) || ($rows['mingxi_2'] == $wdx) || ($rows['mingxi_2'] == $hds) || ($rows['mingxi_2'] == $zfb) || ($rows['mingxi_2'] == $dnxb))
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
		$ds = Klsf_Ds($rs['ball_3']);
		$dx = Klsf_Dx($rs['ball_3']);
		$wdx = Klsf_Wdx($rs['ball_3']);
		$hds = Klsf_Hdx($rs['ball_3']);
		$zfb = Klsf_Zfb($rs['ball_3']);
		$dnxb = Klsf_Dnxb($rs['ball_3']);
		if (($rows['mingxi_2'] == $rs['ball_3']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx) || ($rows['mingxi_2'] == $wdx) || ($rows['mingxi_2'] == $hds) || ($rows['mingxi_2'] == $zfb) || ($rows['mingxi_2'] == $dnxb))
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
		$ds = Klsf_Ds($rs['ball_4']);
		$dx = Klsf_Dx($rs['ball_4']);
		$wdx = Klsf_Wdx($rs['ball_4']);
		$hds = Klsf_Hdx($rs['ball_4']);
		$zfb = Klsf_Zfb($rs['ball_4']);
		$dnxb = Klsf_Dnxb($rs['ball_4']);
		if (($rows['mingxi_2'] == $rs['ball_4']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx) || ($rows['mingxi_2'] == $wdx) || ($rows['mingxi_2'] == $hds) || ($rows['mingxi_2'] == $zfb) || ($rows['mingxi_2'] == $dnxb))
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
		$ds = Klsf_Ds($rs['ball_5']);
		$dx = Klsf_Dx($rs['ball_5']);
		$wdx = Klsf_Wdx($rs['ball_5']);
		$hds = Klsf_Hdx($rs['ball_5']);
		$zfb = Klsf_Zfb($rs['ball_5']);
		$dnxb = Klsf_Dnxb($rs['ball_5']);
		if (($rows['mingxi_2'] == $rs['ball_5']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx) || ($rows['mingxi_2'] == $wdx) || ($rows['mingxi_2'] == $hds) || ($rows['mingxi_2'] == $zfb) || ($rows['mingxi_2'] == $dnxb))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第六球')
	{
		$ds = Klsf_Ds($rs['ball_6']);
		$dx = Klsf_Dx($rs['ball_6']);
		$wdx = Klsf_Wdx($rs['ball_6']);
		$hds = Klsf_Hdx($rs['ball_6']);
		$zfb = Klsf_Zfb($rs['ball_6']);
		$dnxb = Klsf_Dnxb($rs['ball_6']);
		if (($rows['mingxi_2'] == $rs['ball_6']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx) || ($rows['mingxi_2'] == $wdx) || ($rows['mingxi_2'] == $hds) || ($rows['mingxi_2'] == $zfb) || ($rows['mingxi_2'] == $dnxb))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第七球')
	{
		$ds = Klsf_Ds($rs['ball_7']);
		$dx = Klsf_Dx($rs['ball_7']);
		$wdx = Klsf_Wdx($rs['ball_7']);
		$hds = Klsf_Hdx($rs['ball_7']);
		$zfb = Klsf_Zfb($rs['ball_7']);
		$dnxb = Klsf_Dnxb($rs['ball_7']);
		if (($rows['mingxi_2'] == $rs['ball_7']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx) || ($rows['mingxi_2'] == $wdx) || ($rows['mingxi_2'] == $hds) || ($rows['mingxi_2'] == $zfb) || ($rows['mingxi_2'] == $dnxb))
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if ($rows['mingxi_1'] == '第八球')
	{
		$ds = Klsf_Ds($rs['ball_8']);
		$dx = Klsf_Dx($rs['ball_8']);
		$wdx = Klsf_Wdx($rs['ball_8']);
		$hds = Klsf_Hdx($rs['ball_8']);
		$zfb = Klsf_Zfb($rs['ball_8']);
		$dnxb = Klsf_Dnxb($rs['ball_8']);
		if (($rows['mingxi_2'] == $rs['ball_8']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx) || ($rows['mingxi_2'] == $wdx) || ($rows['mingxi_2'] == $hds) || ($rows['mingxi_2'] == $zfb) || ($rows['mingxi_2'] == $dnxb))
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
		$zonghe = Klsf_Auto($hm, 2);
		if ($rows['mingxi_2'] == $zonghe)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else if ($zonghe == '总和和')
		{
			he_update($rows['id'], $rows['money'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if (($rows['mingxi_2'] == '总和单') || ($rows['mingxi_2'] == '总和双'))
	{
		$zonghe = Klsf_Auto($hm, 3);
		if ($rows['mingxi_2'] == $zonghe)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if (($rows['mingxi_2'] == '总和尾大') || ($rows['mingxi_2'] == '总和尾小'))
	{
		$zonghe = Klsf_Auto($hm, 4);
		if ($rows['mingxi_2'] == $zonghe)
		{
			win_update($rows['id'], $rows['win'], $rows['uid']);
		}
		else
		{
			no_win_update($rows['id']);
		}
	}
	if (($rows['mingxi_2'] == '龙') || ($rows['mingxi_2'] == '虎'))
	{
		$longhu = Klsf_Auto($hm, 5);
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
	$sql = "\r\n\t\t" . "INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,'$betNames[$lotteryType]','RECKON',c_bet_3.id,(case when c_bet_3.win<0 then 0 when c_bet_3.win=0 then c_bet_3.money else c_bet_3.win end),k_user.money-(case when c_bet_3.win<0 then 0 when c_bet_3.win=0 then c_bet_3.money else c_bet_3.win end),k_user.money,:creationTime FROM k_user,c_bet_3  WHERE k_user.uid=c_bet_3.uid  AND c_bet_3.js=1 AND c_bet_3.id=:id";
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$params = array(':jieguo' => $rs['ball_1'] . ',' . $rs['ball_2'] . ',' . $rs['ball_3'] . ',' . $rs['ball_4'] . ',' . $rs['ball_5'] . ',' . $rs['ball_6'] . ',' . $rs['ball_7'] . ',' . $rs['ball_8'], ':id' => $rows['id']);
	$msql = 'update c_bet_3 set jieguo=:jieguo where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('注单修改失败!!!' . $rows['id']);
}
$params = array(':qishu' => $qi);
if($lotteryType=='gdkl10') {
    $msql = 'update c_auto_3 set ok=1 where qishu=:qishu';
}else{
    $params[':name'] = $lotteryType;
    $msql = 'update c_auto_klsf set ok=1 where qishu=:qishu and name=:name';
}
$stmt = $mydata1_db->prepare($msql);
$stmt->execute($params) || exit('期数修改失败!!!');
if ($_GET['t'] == 1)
{?> <script>window.location.href='../../Lottery/auto_3.php?lottery_type=<?php echo $lotteryType?>';</script><?php }
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
function he_update($id, $money, $uid)
{
	global $mydata1_db;
	$params = array(':id' => $id);
	$msql = 'update c_bet_3 set win=0,js=1 where id=:id';
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