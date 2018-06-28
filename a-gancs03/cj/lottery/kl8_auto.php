<?php include_once '../../../include/config.php';
include_once '../../../database/mysql.config.php';
$qi = intval($_REQUEST['qi']);
$uid = intval($_REQUEST['uid']);?><html> 
  <head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title></title> 
  <link href="/style/agents/control_down.css" rel="stylesheet" type="text/css"> 
  </head> 
  <body><?php $params = array(':qihao' => $qi);
$mysql = 'select * from lottery_k_kl8 where qihao=:qihao';
$stmt = $mydata1_db->prepare($mysql);
$stmt->execute($params);
$mycou = $stmt->rowCount();
$myrow = $stmt->fetch();
if ($mycou == 0)
{?> 当前期数开奖号码未录入！<?php exit();
}
if (1 < $mycou)
{?> 当前期数开奖号码记录出现多条记录！<?php exit();
}
$plsql = 'select id,class1,class2,class3,odds,modds,locked from lottery_odds where class1=\'kl8\' order by ID asc';
$plresult = $mydata1_db->query($plsql);
while ($plrow = $plresult->fetch())
{
	$pl = $pl . '|' . $plrow['odds'];
}
$plrr = explode('|', $pl);
$hm1 = $myrow['hm1'];
$hm2 = $myrow['hm2'];
$hm3 = $myrow['hm3'];
$hm4 = $myrow['hm4'];
$hm5 = $myrow['hm5'];
$hm6 = $myrow['hm6'];
$hm7 = $myrow['hm7'];
$hm8 = $myrow['hm8'];
$hm9 = $myrow['hm9'];
$hm10 = $myrow['hm10'];
$hm11 = $myrow['hm11'];
$hm12 = $myrow['hm12'];
$hm13 = $myrow['hm13'];
$hm14 = $myrow['hm14'];
$hm15 = $myrow['hm15'];
$hm16 = $myrow['hm16'];
$hm17 = $myrow['hm17'];
$hm18 = $myrow['hm18'];
$hm19 = $myrow['hm19'];
$hm20 = $myrow['hm20'];
$zhnum = $hm1 + $hm2 + $hm3 + $hm4 + $hm5 + $hm6 + $hm7 + $hm8 + $hm9 + $hm10 + $hm11 + $hm12 + $hm13 + $hm14 + $hm15 + $hm16 + $hm17 + $hm18 + $hm19 + $hm20;
if ($zhnum < 1)
{?> 当前期数未开奖！<?php exit();
}
$paramsMain = array(':mid' => $qi);
$sqlMain = 'select * from lottery_data where atype=\'kl8\' and mid=:mid and bet_ok=0 order by ID asc';
$stmtMain = $mydata1_db->prepare($sqlMain);
$stmtMain->execute($paramsMain);
while ($row = $stmtMain->fetch())
{
	$wins = ($row['money'] * $row['odds']) - $row['money'];
	if ($row['btype'] == '选一')
	{
		$x1rr = explode(',', $row['content']);
		if (($hm1 == $x1rr[0]) || ($hm2 == $x1rr[0]) || ($hm3 == $x1rr[0]) || ($hm4 == $x1rr[0]) || ($hm5 == $x1rr[0]) || ($hm6 == $x1rr[0]) || ($hm7 == $x1rr[0]) || ($hm8 == $x1rr[0]) || ($hm9 == $x1rr[0]) || ($hm10 == $x1rr[0]) || ($hm11 == $x1rr[0]) || ($hm12 == $x1rr[0]) || ($hm13 == $x1rr[0]) || ($hm14 == $x1rr[0]) || ($hm15 == $x1rr[0]) || ($hm16 == $x1rr[0]) || ($hm17 == $x1rr[0]) || ($hm18 == $x1rr[0]) || ($hm19 == $x1rr[0]) || ($hm20 == $x1rr[0]))
		{
			win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
		}
		else
		{
			no_win_update($row['money'], $row['id']);
		}
	}
	if ($row['btype'] == '选二')
	{
		$x1rr = explode(',', $row['content']);
		if ((($hm1 == $x1rr[0]) || ($hm2 == $x1rr[0]) || ($hm3 == $x1rr[0]) || ($hm4 == $x1rr[0]) || ($hm5 == $x1rr[0]) || ($hm6 == $x1rr[0]) || ($hm7 == $x1rr[0]) || ($hm8 == $x1rr[0]) || ($hm9 == $x1rr[0]) || ($hm10 == $x1rr[0]) || ($hm11 == $x1rr[0]) || ($hm12 == $x1rr[0]) || ($hm13 == $x1rr[0]) || ($hm14 == $x1rr[0]) || ($hm15 == $x1rr[0]) || ($hm16 == $x1rr[0]) || ($hm17 == $x1rr[0]) || ($hm18 == $x1rr[0]) || ($hm19 == $x1rr[0]) || ($hm20 == $x1rr[0])) && (($hm1 == $x1rr[1]) || ($hm2 == $x1rr[1]) || ($hm3 == $x1rr[1]) || ($hm4 == $x1rr[1]) || ($hm5 == $x1rr[1]) || ($hm6 == $x1rr[1]) || ($hm7 == $x1rr[1]) || ($hm8 == $x1rr[1]) || ($hm9 == $x1rr[1]) || ($hm10 == $x1rr[1]) || ($hm11 == $x1rr[1]) || ($hm12 == $x1rr[1]) || ($hm13 == $x1rr[1]) || ($hm14 == $x1rr[1]) || ($hm15 == $x1rr[1]) || ($hm16 == $x1rr[1]) || ($hm17 == $x1rr[1]) || ($hm18 == $x1rr[1]) || ($hm19 == $x1rr[1]) || ($hm20 == $x1rr[1])))
		{
			win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
		}
		else
		{
			no_win_update($row['money'], $row['id']);
		}
	}
	if ($row['btype'] == '选三')
	{
		$x1rr = explode(',', $row['content']);
		if ((($hm1 == $x1rr[0]) || ($hm2 == $x1rr[0]) || ($hm3 == $x1rr[0]) || ($hm4 == $x1rr[0]) || ($hm5 == $x1rr[0]) || ($hm6 == $x1rr[0]) || ($hm7 == $x1rr[0]) || ($hm8 == $x1rr[0]) || ($hm9 == $x1rr[0]) || ($hm10 == $x1rr[0]) || ($hm11 == $x1rr[0]) || ($hm12 == $x1rr[0]) || ($hm13 == $x1rr[0]) || ($hm14 == $x1rr[0]) || ($hm15 == $x1rr[0]) || ($hm16 == $x1rr[0]) || ($hm17 == $x1rr[0]) || ($hm18 == $x1rr[0]) || ($hm19 == $x1rr[0]) || ($hm20 == $x1rr[0])) && (($hm1 == $x1rr[1]) || ($hm2 == $x1rr[1]) || ($hm3 == $x1rr[1]) || ($hm4 == $x1rr[1]) || ($hm5 == $x1rr[1]) || ($hm6 == $x1rr[1]) || ($hm7 == $x1rr[1]) || ($hm8 == $x1rr[1]) || ($hm9 == $x1rr[1]) || ($hm10 == $x1rr[1]) || ($hm11 == $x1rr[1]) || ($hm12 == $x1rr[1]) || ($hm13 == $x1rr[1]) || ($hm14 == $x1rr[1]) || ($hm15 == $x1rr[1]) || ($hm16 == $x1rr[1]) || ($hm17 == $x1rr[1]) || ($hm18 == $x1rr[1]) || ($hm19 == $x1rr[1]) || ($hm20 == $x1rr[1])) && (($hm1 == $x1rr[2]) || ($hm2 == $x1rr[2]) || ($hm3 == $x1rr[2]) || ($hm4 == $x1rr[2]) || ($hm5 == $x1rr[2]) || ($hm6 == $x1rr[2]) || ($hm7 == $x1rr[2]) || ($hm8 == $x1rr[2]) || ($hm9 == $x1rr[2]) || ($hm10 == $x1rr[2]) || ($hm11 == $x1rr[2]) || ($hm12 == $x1rr[2]) || ($hm13 == $x1rr[2]) || ($hm14 == $x1rr[2]) || ($hm15 == $x1rr[2]) || ($hm16 == $x1rr[2]) || ($hm17 == $x1rr[2]) || ($hm18 == $x1rr[2]) || ($hm19 == $x1rr[2]) || ($hm20 == $x1rr[2])))
		{
			win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
		}
		else if (((($hm1 == $x1rr[0]) || ($hm2 == $x1rr[0]) || ($hm3 == $x1rr[0]) || ($hm4 == $x1rr[0]) || ($hm5 == $x1rr[0]) || ($hm6 == $x1rr[0]) || ($hm7 == $x1rr[0]) || ($hm8 == $x1rr[0]) || ($hm9 == $x1rr[0]) || ($hm10 == $x1rr[0]) || ($hm11 == $x1rr[0]) || ($hm12 == $x1rr[0]) || ($hm13 == $x1rr[0]) || ($hm14 == $x1rr[0]) || ($hm15 == $x1rr[0]) || ($hm16 == $x1rr[0]) || ($hm17 == $x1rr[0]) || ($hm18 == $x1rr[0]) || ($hm19 == $x1rr[0]) || ($hm20 == $x1rr[0])) && (($hm1 == $x1rr[1]) || ($hm2 == $x1rr[1]) || ($hm3 == $x1rr[1]) || ($hm4 == $x1rr[1]) || ($hm5 == $x1rr[1]) || ($hm6 == $x1rr[1]) || ($hm7 == $x1rr[1]) || ($hm8 == $x1rr[1]) || ($hm9 == $x1rr[1]) || ($hm10 == $x1rr[1]) || ($hm11 == $x1rr[1]) || ($hm12 == $x1rr[1]) || ($hm13 == $x1rr[1]) || ($hm14 == $x1rr[1]) || ($hm15 == $x1rr[1]) || ($hm16 == $x1rr[1]) || ($hm17 == $x1rr[1]) || ($hm18 == $x1rr[1]) || ($hm19 == $x1rr[1]) || ($hm20 == $x1rr[1]))) || ((($hm1 == $x1rr[0]) || ($hm2 == $x1rr[0]) || ($hm3 == $x1rr[0]) || ($hm4 == $x1rr[0]) || ($hm5 == $x1rr[0]) || ($hm6 == $x1rr[0]) || ($hm7 == $x1rr[0]) || ($hm8 == $x1rr[0]) || ($hm9 == $x1rr[0]) || ($hm10 == $x1rr[0]) || ($hm11 == $x1rr[0]) || ($hm12 == $x1rr[0]) || ($hm13 == $x1rr[0]) || ($hm14 == $x1rr[0]) || ($hm15 == $x1rr[0]) || ($hm16 == $x1rr[0]) || ($hm17 == $x1rr[0]) || ($hm18 == $x1rr[0]) || ($hm19 == $x1rr[0]) || ($hm20 == $x1rr[0])) && (($hm1 == $x1rr[2]) || ($hm2 == $x1rr[2]) || ($hm3 == $x1rr[2]) || ($hm4 == $x1rr[2]) || ($hm5 == $x1rr[2]) || ($hm6 == $x1rr[2]) || ($hm7 == $x1rr[2]) || ($hm8 == $x1rr[2]) || ($hm9 == $x1rr[2]) || ($hm10 == $x1rr[2]) || ($hm11 == $x1rr[2]) || ($hm12 == $x1rr[2]) || ($hm13 == $x1rr[2]) || ($hm14 == $x1rr[2]) || ($hm15 == $x1rr[2]) || ($hm16 == $x1rr[2]) || ($hm17 == $x1rr[2]) || ($hm18 == $x1rr[2]) || ($hm19 == $x1rr[2]) || ($hm20 == $x1rr[2]))) || ((($hm1 == $x1rr[1]) || ($hm2 == $x1rr[1]) || ($hm3 == $x1rr[1]) || ($hm4 == $x1rr[1]) || ($hm5 == $x1rr[1]) || ($hm6 == $x1rr[1]) || ($hm7 == $x1rr[1]) || ($hm8 == $x1rr[1]) || ($hm9 == $x1rr[1]) || ($hm10 == $x1rr[1]) || ($hm11 == $x1rr[1]) || ($hm12 == $x1rr[1]) || ($hm13 == $x1rr[1]) || ($hm14 == $x1rr[1]) || ($hm15 == $x1rr[1]) || ($hm16 == $x1rr[1]) || ($hm17 == $x1rr[1]) || ($hm18 == $x1rr[1]) || ($hm19 == $x1rr[1]) || ($hm20 == $x1rr[1])) && (($hm1 == $x1rr[2]) || ($hm2 == $x1rr[2]) || ($hm3 == $x1rr[2]) || ($hm4 == $x1rr[2]) || ($hm5 == $x1rr[2]) || ($hm6 == $x1rr[2]) || ($hm7 == $x1rr[2]) || ($hm8 == $x1rr[2]) || ($hm9 == $x1rr[2]) || ($hm10 == $x1rr[2]) || ($hm11 == $x1rr[2]) || ($hm12 == $x1rr[2]) || ($hm13 == $x1rr[2]) || ($hm14 == $x1rr[2]) || ($hm15 == $x1rr[2]) || ($hm16 == $x1rr[2]) || ($hm17 == $x1rr[2]) || ($hm18 == $x1rr[2]) || ($hm19 == $x1rr[2]) || ($hm20 == $x1rr[2]))))
		{
			$odds = $plrr[3];
			$xwins = ($row['money'] * $odds) - $row['money'];
			win_update($xwins, $row['id'], $row['money'] * $odds, $row['username']);
		}
		else
		{
			no_win_update($row['money'], $row['id']);
		}
	}
	if ($row['btype'] == '选四')
	{
		$x1rr = explode(',', $row['content']);
		$h41 = 0;
		$h42 = 0;
		$h43 = 0;
		$h44 = 0;
		$i = 1;
		for (;$i < 21;$i++)
		{
			if ($x1rr[0] == $myrow['hm' . $i . ''])
			{
				$h41 = 1;
			}
			if ($x1rr[1] == $myrow['hm' . $i . ''])
			{
				$h42 = 1;
			}
			if ($x1rr[2] == $myrow['hm' . $i . ''])
			{
				$h43 = 1;
			}
			if ($x1rr[3] == $myrow['hm' . $i . ''])
			{
				$h44 = 1;
			}
		}
		$h4nus = $h41 + $h42 + $h43 + $h44;
		if ($h4nus == 4)
		{
			win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
		}
		else if ($h4nus == 3)
		{
			$odds = $plrr[6];
			$xwins = ($row['money'] * $odds) - $row['money'];
			win_update($xwins, $row['id'], $row['money'] * $odds, $row['username']);
		}
		else if ($h4nus == 2)
		{
			$odds = $plrr[5];
			$xwins = ($row['money'] * $odds) - $row['money'];
			win_update($xwins, $row['id'], $row['money'] * $odds, $row['username']);
		}
		else
		{
			no_win_update($row['money'], $row['id']);
		}
	}
	if ($row['btype'] == '选五')
	{
		$x1rr = explode(',', $row['content']);
		$h51 = 0;
		$h52 = 0;
		$h53 = 0;
		$h54 = 0;
		$h55 = 0;
		$i = 1;
		for (;$i < 21;$i++)
		{
			if ($x1rr[0] == $myrow['hm' . $i . ''])
			{
				$h51 = 1;
			}
			if ($x1rr[1] == $myrow['hm' . $i . ''])
			{
				$h52 = 1;
			}
			if ($x1rr[2] == $myrow['hm' . $i . ''])
			{
				$h53 = 1;
			}
			if ($x1rr[3] == $myrow['hm' . $i . ''])
			{
				$h54 = 1;
			}
			if ($x1rr[4] == $myrow['hm' . $i . ''])
			{
				$h55 = 1;
			}
		}
		$h5nus = $h51 + $h52 + $h53 + $h54 + $h55;
		if ($h5nus == 5)
		{
			win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
		}
		else if ($h5nus == 4)
		{
			$odds = $plrr[9];
			$xwins = ($row['money'] * $odds) - $row['money'];
			win_update($xwins, $row['id'], $row['money'] * $odds, $row['username']);
		}
		else if ($h5nus == 3)
		{
			$odds = $plrr[8];
			$xwins = ($row['money'] * $odds) - $row['money'];
			win_update($xwins, $row['id'], $row['money'] * $odds, $row['username']);
		}
		else
		{
			no_win_update($row['money'], $row['id']);
		}
	}
	if ($row['btype'] == '和值')
	{
		if (($row['ctype'] == '大') || ($row['ctype'] == '小') || ($row['ctype'] == '810'))
		{
			if (zhdx($zhnum) == $row['content'])
			{
				win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
			}
			else if (zhdx($zhnum) == '810')
			{
				he_update($row['id'], $row['money'], $row['username']);
			}
			else
			{
				no_win_update($row['money'], $row['id']);
			}
		}
		if (($row['ctype'] == '单') || ($row['ctype'] == '双'))
		{
			if (zhds($zhnum) == $row['content'])
			{
				win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
			}
			else
			{
				no_win_update($row['money'], $row['id']);
			}
		}
	}
	if ($row['btype'] == '上中下')
	{
		$shang = 0;
		$xia = 0;
		$i = 1;
		for (;$i < 21;$i++)
		{
			if ($myrow['hm' . $i . ''] < 41)
			{
				$shang = $shang + 1;
			}
			else
			{
				$xia = $xia + 1;
			}
		}
		if ($xia < $shang)
		{
			$shangxia = '上';
		}
		else if ($shang < $xia)
		{
			$shangxia = '下';
		}
		else if ($shang == $xia)
		{
			$shangxia = '中';
		}
		if ($shangxia == $row['content'])
		{
			win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
		}
		else
		{
			no_win_update($row['money'], $row['id']);
		}
	}
	if ($row['btype'] == '奇和偶')
	{
		$ji = 0;
		$ou = 0;
		$i = 1;
		for (;$i < 21;$i++)
		{
			if ($myrow['hm' . $i . ''] % 2 == 0)
			{
				$ou = $ou + 1;
			}
			else
			{
				$ji = $ji + 1;
			}
		}
		if ($ji < $ou)
		{
			$jiou = '偶';
		}
		else if ($ou < $ji)
		{
			$jiou = '奇';
		}
		else if ($ou == $ji)
		{
			$jiou = '和';
		}
		if ($jiou == $row['content'])
		{
			win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
		}
		else
		{
			no_win_update($row['money'], $row['id']);
		}
	}
	$creationTime = date('Y-m-d H:i:s');
	$id = $row['id'];
	$params = array(':creationTime' => $creationTime, ':id' => $id);
	$sql = "\r\n\t\t" . 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'BJKL8\',\'RECKON\',lottery_data.uid,lottery_data.win+lottery_data.money,k_user.money-(lottery_data.win+lottery_data.money),k_user.money,:creationTime FROM k_user,lottery_data  WHERE k_user.username=lottery_data.username  AND lottery_data.bet_ok=1 AND lottery_data.id=:id';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
}
$params = array(':qihao' => $qi);
$msql = 'update lottery_k_kl8 set ok=1 where qihao=:qihao';
$stmt = $mydata1_db->prepare($msql);
$stmt->execute($params) || exit('修改期數狀態失敗');
if ($_GET['t'] == 1)
{?> <script>window.location.href='../../cpgl/lottery_auto_kl8.php';</script><?php }?> </body> 
  </html><?php function buling($num)
{
	if ($num < 10)
	{
		$nums = '0' . $num;
	}
	else
	{
		$nums = $num;
	}
	return $nums;
}
function dx($dx)
{
	if (25 <= $dx)
	{
		$dxs = '大';
	}
	else if ($dx <= 24)
	{
		$dxs = '小';
	}
	else if ($dx == 49)
	{
		$dxs = $dx;
	}
	return $dxs;
}
function ds($ds)
{
	if ($ds % 2 == 0)
	{
		$dss = '双';
	}
	else
	{
		$dss = '单';
	}
	return $dss;
}
function bs($bs)
{
	if (($bs == 1) || ($bs == 2) || ($bs == 7) || ($bs == 8) || ($bs == 12) || ($bs == 13) || ($bs == 18) || ($bs == 19) || ($bs == 23) || ($bs == 24) || ($bs == 29) || ($bs == 30) || ($bs == 34) || ($bs == 35) || ($bs == 40) || ($bs == 45) || ($bs == 46))
	{
		$bss = '红波';
	}
	else if (($bs == 3) || ($bs == 4) || ($bs == 9) || ($bs == 10) || ($bs == 14) || ($bs == 15) || ($bs == 20) || ($bs == 25) || ($bs == 26) || ($bs == 31) || ($bs == 36) || ($bs == 37) || ($bs == 41) || ($bs == 42) || ($bs == 47) || ($bs == 48))
	{
		$bss = '蓝波';
	}
	else
	{
		$bss = '绿波';
	}
	return $bss;
}
function zhdx($zhdx)
{
	if (810 < $zhdx)
	{
		$zhdxs = '大';
	}
	else if ($zhdx < 810)
	{
		$zhdxs = '小';
	}
	else if ($zhdx == 810)
	{
		$zhdxs = '810';
	}
	return $zhdxs;
}
function zhds($zhds)
{
	if ($zhds % 2 == 0)
	{
		$zhdss = '双';
	}
	else
	{
		$zhdss = '单';
	}
	return $zhdss;
}
function win_update($win, $id, $money, $username)
{
	global $mydata1_db;
	$params = array(':win' => $win, ':id' => $id);
	$msql = 'update lottery_data set win=:win,bet_ok=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('中奖修改失败' . $id);
	$params = array(':money' => $money, ':username' => $username);
	$msql = 'update k_user set money=money+:money where username=:username';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('会员加奖失败' . $id);
}
function he_update($id, $money, $username)
{
	global $mydata1_db;
	$params = array(':id' => $id);
	$msql = 'update lottery_data set win=0,bet_ok=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('中奖修改失败' . $id);
	$params = array(':money' => $money, ':username' => $username);
	$msql = 'update k_user set money=money+:money where username=:username';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('会员加奖失败' . $id);
}
function no_win_update($win, $id)
{
	global $mydata1_db;
	$params = array(':win' => $win, ':id' => $id);
	$msql = 'update lottery_data set win=-:win,bet_ok=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('注单未中奖修改失败' . $id);
}?>