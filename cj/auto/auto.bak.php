<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
$sql = 'select match_nowscore,match_id,bid,uid,master_guest,bet_info,Match_GRedCard,Match_HRedCard,bet_money from k_bet where lose_ok=0 and bet_time<=DATE_SUB(now(),INTERVAL 60 SECOND) and bet_time>=DATE_SUB(now(),INTERVAL 120 SECOND)  order by bid  desc ';
$query = $mydata1_db->query($sql);
$rows = $query->fetch();
$msg = date('Y-m-d H:i:s') . '<p />';
if (!$rows){
	$msg .= '本次无滚球注单判断';
}else{
	include_once '../../cache/zqgq.php';
	$bet = array();
	$arr = array();
	$match_id = '';
	$num = 0;
	do
	{
		$bet[$rows['bid']]['uid'] = $rows['uid'];
		$bet[$rows['bid']]['match_id'] = $rows['match_id'];
		$bet[$rows['bid']]['bet_info'] = $rows['bet_info'];
		$bet[$rows['bid']]['master_guest'] = $rows['master_guest'];
		$bet[$rows['bid']]['Match_HRedCard'] = $rows['Match_HRedCard'];
		$bet[$rows['bid']]['Match_GRedCard'] = $rows['Match_GRedCard'];
		$bet[$rows['bid']]['match_nowscore'] = $rows['match_nowscore'];
		$bet[$rows['bid']]['bet_money'] = $rows['bet_money'];
		$bool = true;
		$i = 0;
		for (;$i < $count;$i++)
		{
			if ($zqgq[$i]['Match_ID'] == $rows['match_id'])
			{
				$arr[$num]['i'] = $i;
				$arr[$num]['bid'] = $rows['bid'];
				$bool = false;
				$num++;
				break;
			}
		}
		if ($bool)
		{
			$match_id .= floatval($rows['match_id']) . ',';
			continue;
		}
	}
	while ($rows = $query->fetch());
	$i = 0;
	for (;$i < $num;$i++)
	{
		$bool = $msg_t = '';

		//print_r(($bet[$arr[$i]['bid']]['match_nowscore']) == ($zqgq[$arr[$i]['i']]['Match_score_h'].':'.$zqgq[$arr[$i]['i']]['Match_score_c']));exit;

		if (($bet[$arr[$i]['bid']]['match_nowscore']) == ($zqgq[$arr[$i]['i']]['Match_score_h'].':'.$zqgq[$arr[$i]['i']]['Match_score_c']))
		{
			if (($bet[$arr[$i]['bid']]['Match_HRedCard'] != $zqgq[$arr[$i]['i']]['Match_HRedCard']) || ($bet[$arr[$i]['bid']]['Match_GRedCard'] != $zqgq[$arr[$i]['i']]['Match_GRedCard']))
			{
				$msg_t = '滚球注单红卡无效';
				$bool = cancelbet(7, $arr[$i]['bid'], $bet[$arr[$i]['bid']]['uid'], $bet[$arr[$i]['bid']]['master_guest'] . '_注单已取消', $bet[$arr[$i]['bid']]['master_guest'] . '<br/>' . $bet[$arr[$i]['bid']]['bet_info'] . '<br /><font style="color:#F00"/>因红卡无效，该注单取消,已返还本金。</font>', '红卡无效');
			}
			else
			{
				$msg_t = '滚球注单有效';
				$bool = setok($arr[$i]['bid']);
			}
		}
		else
		{
			$msg_t = '滚球注单进球无效';
			$bool = cancelbet(6, $arr[$i]['bid'], $bet[$arr[$i]['bid']]['uid'], $bet[$arr[$i]['bid']]['master_guest'] . '_注单已取消', $bet[$arr[$i]['bid']]['master_guest'] . '<br/>' . $bet[$arr[$i]['bid']]['bet_info'] . '<br /><font style="color:#F00"/>因进球无效，该注单取消,已返还本金。</font>', '进球无效');
		}
		if ($bool)
		{
			$d = date('Y-m-d');
			$filename = '../../cache/logList/' . $d . '.txt';
			$somecontent = '[' . date('Y-m-d H:i:s') . ']   管理员' . $_SESSION['login_name'] . '审核了编号为' . $arr[$i]['bid'] . '的' . $msg_t . '  投注金额[' . $bet[$arr[$i]['bid']]['bet_money'] . ']' . "\r\n";
			$handle = fopen($filename, 'a');
			if (fwrite($handle, $somecontent) === false)
			{
				exit();
			}
			fclose($handle);
			$msg .= '<font color=\'#0000FF\'>审核了编号为' . $arr[$i]['bid'] . '的' . $msg_t . '</font><br />';
		}
	}
	if ($match_id)
	{
		$match_id = rtrim($match_id, ',');
		$sql = 'select Match_HRedCard,Match_GRedCard,Match_NowScore,Match_ID,Match_LstTime from mydata4_db.bet_match where Match_Type=2 and Match_ID in(' . $match_id . ')';
		$query = $mydata1_db->query($sql);
		while ($rows = $query->fetch())
		{
			foreach ($bet as $k => $v)
			{
				$money = $v['bet_money'];
				if ($v['match_id'] == $rows['Match_ID'])
				{
					$bool = $msg_t = '';
					if ($v['match_nowscore'] == $rows['Match_NowScore'])
					{
						if (($rows['Match_HRedCard'] != $v['Match_HRedCard']) || ($rows['Match_GRedCard'] != $v['Match_GRedCard']))
						{
							$msg_t = '滚球注单红卡无效';
							$bool = cancelbet(7, $k, $v['uid'], $v['master_guest'] . '_注单已取消', $v['master_guest'] . '<br/>' . $v['bet_info'] . '<br /><font style="color:#F00"/>因红卡无效，该注单取消,已返还本金。</font>', '红卡无效');
						}
						else
						{
							$msg_t = '滚球注单有效';
							$bool = setok($k);
						}
					}
					else
					{
						$msg_t = '滚球注单进球无效';
						$bool = cancelbet(6, $k, $v['uid'], $v['master_guest'] . '_注单已取消', $v['master_guest'] . '<br/>' . $v['bet_info'] . '<br /><font style="color:#F00"/>因进球无效，该注单取消,已返还本金。</font>', '进球无效');
					}
					if ($bool)
					{
						$d = date('Y-m-d');
						$filename = '../../cache/logList/' . $d . '.txt';
						$somecontent = '[' . date('Y-m-d H:i:s') . ']   管理员' . $_SESSION['login_name'] . '审核了编号为' . $k . '的' . $msg_t . '  投注金额[' . $money . ']' . "\r\n";
						$handle = fopen($filename, 'a');
						if (fwrite($handle, $somecontent) === false)
						{
							exit();
						}
						fclose($handle);
						$msg .= '<font color=\'#0000FF\'>审核了编号为' . $k . '的' . $msg_t . '</font><br />';
						unset($bet[$k]);
					}
				}
			}
		}
	}
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="refresh" content="3"> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>滚于注单自动审核</title> 
</head> 
<style type="text/css"> 
body,div{ margin:0;padding:0} 
</style> 
<script> 
window.parent.is_open = 1;
</script> 
<body > 
<div align="center"> 
<div align="center" style="width:500px;height:200px;border:1px solid #CCC;font-size:13px;"> 
<div align="left" style="padding:5px;background-color:#CCC">滚球自动审核</div> 
<div style="padding-top:50px;"><?=$msg;?></div> 

</div></div> 
</body> 
</html>
<?php 
  function cancelBet($status, $bid, $uid, $msg_title, $msg_info, $why = ''){
	global $mydata1_db;
	global $web_site;
	$params = array(':status' => $status, ':sys_about' => $why, ':bid' => $bid);
	$sql = 'update k_bet,k_user set k_bet.lose_ok=1,k_bet.status=:status,k_user.money=k_user.money+k_bet.bet_money,k_bet.win=k_bet.bet_money,k_bet.update_time=now(),k_bet.match_endtime=now(),k_bet.sys_about=:sys_about where k_user.uid=k_bet.uid and k_bet.bid=:bid and k_bet.status=0';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1 == 2)
	{
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':creationTime' => $creationTime, ':bid' => $bid);
		$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) 
		SELECT k_user.uid,k_user.username,\'SportsDS\',\'CANCEL_BET\',k_bet.number,k_bet.win,k_user.money-k_bet.win,k_user.money,:creationTime FROM k_user,k_bet WHERE k_user.uid=k_bet.uid AND k_bet.bid=:bid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		include_once '../../class/user.php';
		user::msg_add($uid, $web_site['reg_msg_from'], $msg_title, $msg_info);
		return true;
	}
}
function setOK($bid)
{
	global $mydata1_db;
	$params = array(':bid' => $bid);
	$sql = 'update k_bet set lose_ok=1,match_endtime=now() where bid=:bid and lose_ok=0';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1 == 1)
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>