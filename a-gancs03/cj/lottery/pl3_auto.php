<?php include_once '../../../include/config.php';
include_once '../../../database/mysql.config.php';
$qi = intval($_REQUEST['qihao']);
$uid = intval($_REQUEST['uid']);?><html> 
  <head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title></title> 
  <link href="/style/agents/control_down.css" rel="stylesheet" type="text/css"> 
  </head> 
  <body><?php $params = array(':qihao' => $qi);
$mysql = 'select * from lottery_k_pl3 where qihao=:qihao';
$stmt = $mydata1_db->prepare($mysql);
$stmt->execute($params);
$mycou = $stmt->rowCount();
$myrow = $stmt->fetch();
if ($mycou == 0)
{?> 当前期数开奖号码未录入！<?php exit();
}
$bw = $myrow['hm1'];
$sw = $myrow['hm2'];
$gw = $myrow['hm3'];
$dxbsg = $bw . $sw . $gw;
$dxbs = $bw . $sw;
$dxbg = $bw . $gw;
$dxsg = $sw . $gw;
if (($bw == $sw) || ($bw == $gw) || ($sw == $gw))
{
	$z3z6 = '组三';
}
else
{
	$z3z6 = '组六';
}
$hmhz = $bw + $sw + $gw;
$paramsMain = array(':qihao' => $qi);
$sqlMain = 'select * from lottery_data where atype=\'pl3\' and mid=:qihao and bet_ok=0 order by ID asc';
$stmtMain = $mydata1_db->prepare($sqlMain);
$stmtMain->execute($paramsMain);
while ($row = $stmtMain->fetch())
{
	$wins = ($row['money'] * $row['odds']) - $row['money'];
	if ($row['btype'] == '单选')
	{
		if ($row['ctype'] == '三位')
		{
			if ($row['content'] == $dxbsg)
			{
				win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '单选三位注单中奖修改失败' . $row['id'], '单选三位会员加奖失败' . $row['username']);
			}
			else
			{
				no_win_update($row['money'], $row['id'], '单选三位注单未中奖修改失败' . $row['id']);
			}
		}
		if ($row['ctype'] == '二位')
		{
			if ($row['dtype'] == '百十')
			{
				if ($row['content'] == $dxbs)
				{
					win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '单选二位百十注单中奖修改失败' . $row['id'], '单选二位百十会员加奖失败' . $row['username']);
				}
				else
				{
					no_win_update($row['money'], $row['id'], '单选二位百十注单未中奖修改失败' . $row['id']);
				}
			}
			if ($row['dtype'] == '百个')
			{
				if ($row['content'] == $dxbg)
				{
					win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '单选二位百个注单中奖修改失败' . $row['id'], '单选二位百个会员加奖失败' . $row['username']);
				}
				else
				{
					no_win_update($row['money'], $row['id'], '单选二位百个注单未中奖修改失败' . $row['id']);
				}
			}
			if ($row['dtype'] == '十个')
			{
				if ($row['content'] == $dxsg)
				{
					win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '单选二位十个注单中奖修改失败' . $row['id'], '单选二位十个会员加奖失败' . $row['username']);
				}
				else
				{
					no_win_update($row['money'], $row['id'], '单选二位十个注单未中奖修改失败' . $row['id']);
				}
			}
		}
		if ($row['ctype'] == '一位')
		{
			if ($row['dtype'] == '百')
			{
				if ($row['content'] == $bw)
				{
					win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '单选一位百注单中奖修改失败' . $row['id'], '单选一位百会员加奖失败' . $row['username']);
				}
				else
				{
					no_win_update($row['money'], $row['id'], '单选一位百注单未中奖修改失败' . $row['id']);
				}
			}
			if ($row['dtype'] == '十')
			{
				if ($row['content'] == $sw)
				{
					win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '单选一位十注单中奖修改失败' . $row['id'], '单选一位十会员加奖失败' . $row['username']);
				}
				else
				{
					no_win_update($row['money'], $row['id'], '单选一位十注单未中奖修改失败' . $row['id']);
				}
			}
			if ($row['dtype'] == '个')
			{
				if ($row['content'] == $gw)
				{
					win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '单选一位个注单中奖修改失败' . $row['id'], '单选一位个会员加奖失败' . $row['username']);
				}
				else
				{
					no_win_update($row['money'], $row['id'], '单选一位个注单未中奖修改失败' . $row['id']);
				}
			}
		}
	}
	if ($row['btype'] == '组一')
	{
		if (($row['content'] == $bw) || ($row['content'] == $sw) || ($row['content'] == $gw))
		{
			win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '组一注单中奖修改失败' . $row['id'], '组一会员加奖失败' . $row['username']);
		}
		else
		{
			no_win_update($row['money'], $row['id'], '组一注单未中奖修改失败' . $row['id']);
		}
	}
	if ($row['btype'] == '组二')
	{
		$z2hm1 = substr($row['content'], 0, 1);
		$z2hm2 = substr($row['content'], 1, 1);
		if (($row['content'] == $bw . $sw) || ($row['content'] == $bw . $gw) || ($row['content'] == $sw . $gw) || ($row['content'] == $sw . $bw) || ($row['content'] == $bw . $gw) || ($row['content'] == $gw . $sw) || ($row['content'] == $gw . $bw))
		{
			win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '组二注单中奖修改失败' . $row['id'], '组二会员加奖失败' . $row['username']);
		}
		else
		{
			no_win_update($row['money'], $row['id'], '组二注单未中奖修改失败' . $row['id']);
		}
	}
	if ($row['btype'] == '组三')
	{
		$z3hm1 = substr($row['content'], 0, 1);
		$z3hm2 = substr($row['content'], 1, 1);
		$z3hm3 = substr($row['content'], 2, 1);
		if ($z3z6 == '组三')
		{
			if ((($z3hm1 == $bw) || ($z3hm1 == $sw) || ($z3hm1 == $gw)) && (($z3hm2 == $bw) || ($z3hm2 == $sw) || ($z3hm2 == $gw)) && (($z3hm3 == $bw) || ($z3hm3 == $sw) || ($z3hm3 == $gw)))
			{
				win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '组三注单中奖修改失败' . $row['id'], '组三会员加奖失败' . $row['username']);
			}
			else
			{
				no_win_update($row['money'], $row['id'], '组三注单未中奖修改失败' . $row['id']);
			}
		}
		else
		{
			no_win_update($row['money'], $row['id'], '组三注单未中奖修改失败' . $row['id']);
		}
	}
	if ($row['btype'] == '组六')
	{
		$z6hm1 = substr($row['content'], 0, 1);
		$z6hm2 = substr($row['content'], 1, 1);
		$z6hm3 = substr($row['content'], 2, 1);
		if ($z3z6 == '组六')
		{
			if ((($z6hm1 == $bw) || ($z6hm1 == $sw) || ($z6hm1 == $gw)) && (($z6hm2 == $bw) || ($z6hm2 == $sw) || ($z6hm2 == $gw)) && (($z6hm3 == $bw) || ($z6hm3 == $sw) || ($z6hm3 == $gw)))
			{
				win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '组六注单中奖修改失败' . $row['id'], '组六会员加奖失败' . $row['username']);
			}
			else
			{
				no_win_update($row['money'], $row['id'], '组六注单未中奖修改失败' . $row['id']);
			}
		}
		else
		{
			no_win_update($row['money'], $row['id'], '组六注单未中奖修改失败' . $row['id']);
		}
	}
	if ($row['btype'] == '跨度')
	{
		$zuida = 0;
		$zuixiao = 10;
		$i = 1;
		for (;$i <= 3;$i++)
		{
			if ($zuida < $myrow['hm' . $i . ''])
			{
				$zuida = $myrow['hm' . $i . ''];
			}
			if ($myrow['hm' . $i . ''] < $zuixiao)
			{
				$zuixiao = $myrow['hm' . $i . ''];
			}
		}
		$kd = $zuida - $zuixiao;
		if ($row['content'] == $kd)
		{
			win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '跨度注单中奖修改失败' . $row['id'], '跨度会员加奖失败' . $row['username']);
		}
		else
		{
			no_win_update($row['money'], $row['id'], '跨度注单未中奖修改失败' . $row['id']);
		}
	}
	if ($row['btype'] == '和值')
	{
		if (($row['ctype'] < 28) && ($row['dtype'] == '单选'))
		{
			if ($row['content'] == $hmhz)
			{
				win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '和值单选注单中奖修改失败' . $row['id'], '和值单选会员加奖失败' . $row['username']);
			}
			else
			{
				no_win_update($row['money'], $row['id'], '和值单选注单未中奖修改失败' . $row['id']);
			}
		}
		if ($row['dtype'] == '区域')
		{
			$hzrr = explode(',', $row['content']);
			if (($hzrr[0] == $hmhz) || ($hzrr[1] == $hmhz) || ($hzrr[2] == $hmhz) || ($hzrr[3] == $hmhz))
			{
				win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '和值区域注单中奖修改失败' . $row['id'], '和值区域会员加奖失败' . $row['username']);
			}
			else
			{
				no_win_update($row['money'], $row['id'], '和值区域注单未中奖修改失败' . $row['id']);
			}
		}
		if (($row['ctype'] == '单') || ($row['ctype'] == '双'))
		{
			if ($hmhz % 2 == 0)
			{
				$hzds = '双';
			}
			else
			{
				$hzds = '单';
			}
			if ($row['content'] == $hzds)
			{
				win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '和值单双注单中奖修改失败' . $row['id'], '和值单双会员加奖失败' . $row['username']);
			}
			else
			{
				no_win_update($row['money'], $row['id'], '和值单双注单未中奖修改失败' . $row['id']);
			}
		}
		if (($row['ctype'] == '大') || ($row['ctype'] == '小'))
		{
			if (13 < $hmhz)
			{
				$hzdx = '大';
			}
			else
			{
				$hzdx = '小';
			}
			if ($row['content'] == $hzdx)
			{
				win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '和值大小注单中奖修改失败' . $row['id'], '和值大小会员加奖失败' . $row['username']);
			}
			else
			{
				no_win_update($row['money'], $row['id'], '和值大小注单未中奖修改失败' . $row['id']);
			}
		}
	}
	if ($row['btype'] == '单双大小')
	{
		if ($row['dtype'] == '百位')
		{
			if (($row['content'] == '单') || ($row['content'] == '双'))
			{
				if ($bw % 2 == 0)
				{
					$bwds = '双';
				}
				else
				{
					$bwds = '单';
				}
				if ($row['content'] == $bwds)
				{
					win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '百位单双注单中奖修改失败' . $row['id'], '百位单双会员加奖失败' . $row['username']);
				}
				else
				{
					no_win_update($row['money'], $row['id'], '百位单双注单未中奖修改失败' . $row['id']);
				}
			}
			if (($row['content'] == '大') || ($row['content'] == '小'))
			{
				if (4 < $bw)
				{
					$bwdx = '大';
				}
				else
				{
					$bwdx = '小';
				}
				if ($row['content'] == $bwdx)
				{
					win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '百位大小注单中奖修改失败' . $row['id'], '百位大小会员加奖失败' . $row['username']);
				}
				else
				{
					no_win_update($row['money'], $row['id'], '百位大小注单未中奖修改失败' . $row['id']);
				}
			}
		}
		if ($row['dtype'] == '十位')
		{
			if (($row['content'] == '单') || ($row['content'] == '双'))
			{
				if ($sw % 2 == 0)
				{
					$swds = '双';
				}
				else
				{
					$swds = '单';
				}
				if ($row['content'] == $swds)
				{
					win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '十位单双注单中奖修改失败' . $row['id'], '十位单双会员加奖失败' . $row['username']);
				}
				else
				{
					no_win_update($row['money'], $row['id'], '十位单双注单未中奖修改失败' . $row['id']);
				}
			}
			if (($row['content'] == '大') || ($row['content'] == '小'))
			{
				if (4 < $sw)
				{
					$swdx = '大';
				}
				else
				{
					$swdx = '小';
				}
				if ($row['content'] == $swdx)
				{
					win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '十位大小注单中奖修改失败' . $row['id'], '十位大小会员加奖失败' . $row['username']);
				}
				else
				{
					no_win_update($row['money'], $row['id'], '十位大小注单未中奖修改失败' . $row['id']);
				}
			}
		}
		if ($row['dtype'] == '个位')
		{
			if (($row['content'] == '单') || ($row['content'] == '双'))
			{
				if ($gw % 2 == 0)
				{
					$gwds = '双';
				}
				else
				{
					$gwds = '单';
				}
				if ($row['content'] == $gwds)
				{
					win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '个位单双注单中奖修改失败' . $row['id'], '个位单双会员加奖失败' . $row['username']);
				}
				else
				{
					no_win_update($row['money'], $row['id'], '个位单双注单未中奖修改失败' . $row['id']);
				}
			}
			if (($row['content'] == '大') || ($row['content'] == '小'))
			{
				if (4 < $gw)
				{
					$gwdx = '大';
				}
				else
				{
					$gwdx = '小';
				}
				if ($row['content'] == $gwdx)
				{
					win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'], '个位大小注单中奖修改失败' . $row['id'], '个位大小会员加奖失败' . $row['username']);
				}
				else
				{
					no_win_update($row['money'], $row['id'], '个位大小注单未中奖修改失败' . $row['id']);
				}
			}
		}
	}
	$creationTime = date('Y-m-d H:i:s');
	$id = $row['id'];
	$params = array(':creationTime' => $creationTime, ':id' => $id);
	$sql = "\r\n\t\t" . 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'TCPL3\',\'RECKON\',lottery_data.uid,lottery_data.win+lottery_data.money,k_user.money-(lottery_data.win+lottery_data.money),k_user.money,:creationTime FROM k_user,lottery_data  WHERE k_user.username=lottery_data.username  AND lottery_data.bet_ok=1 AND lottery_data.id=:id';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
}
$params = array(':qihao' => $qi);
$msql = 'update lottery_k_pl3 set ok=1 where qihao=:qihao';
$stmt = $mydata1_db->prepare($msql);
$stmt->execute($params) || exit('修改期數狀態失敗');
if ($_GET['t'] == 1)
{?> <script>window.location.href='../../cpgl/lottery_auto_pl3.php';</script><?php }?> </body> 
  </html><?php function win_update($win, $id, $money, $username, $msg_data, $msg_user)
{
	global $mydata1_db;
	$params = array(':win' => $win, ':id' => $id);
	$msql = 'update lottery_data set win=:win,bet_ok=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit($msg_data);
	$params = array(':money' => $money, ':username' => $username);
	$msql = 'update k_user set money=money+:money where username=:username';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit($msg_user);
}
function no_win_update($win, $id, $msg_data)
{
	global $mydata1_db;
	$params = array(':win' => $win, ':id' => $id);
	$msql = 'update lottery_data set win=-:win,bet_ok=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit($msg_data);
}?>