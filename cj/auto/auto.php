<?php
// select a.bet_info, a.match_time, b.Match_Time, a.match_nowscore, b.Match_NowScore, a.lose_ok, a.bet_time, now() from mydata1_db.k_bet a left join mydata4_db.bet_match b on a.match_id=b.Match_ID where `bet_time`>=DATE_SUB(now(), INTERVAL 180 SECOND) order by a.bid desc

include_once '../../include/config.php';
include_once '../../database/mysql.config.php';

$now_time = time();
/* 调出下注时间为180秒内的下注记录 */
$stmt = $mydata1_db->query('SELECT `ball_sort`, `match_nowscore`, `match_time`, `match_id`, `bid`, `uid`, `master_guest`, `bet_time`, `bet_info`, `Match_GRedCard`, `Match_HRedCard`, `bet_money` FROM `mydata1_db`.`k_bet` WHERE `lose_ok`=0 AND `bet_time`>=DATE_SUB(now(), INTERVAL 180 SECOND)');
$match = array();
while ($rows = $stmt->fetch()) {
	if($rows['ball_sort']!='篮球滚球'){
		array_key_exists($rows['match_id'], $match)||$match[$rows['match_id']] = array();
		$bet_info = explode('-', $rows['bet_info']);
		$rows['num'] = $bet_info[0]=='大小'&&isset($bet_info[1])&&substr($bet_info[1], 0, 1)=='U'?1:2; // 小球1分钟，其它2分钟
		$rows['time'] = strtotime($rows['bet_time']);
		$rows['bet_time'] = $now_time-$rows['time']>=$rows['num']*60;
		$match[$rows['match_id']][] = $rows;
	}
}

$msg = date('Y-m-d H:i:s') . '<p />';
if(empty($match)){
	$msg .= '本次无足球滚球注单判断';
}else{
	/* 使用速度较快的有效缓存数据进行危险球判断 */
	include_once '../../cache/zqgq.php';
	if($lasttime>=$now_time){
		foreach($zqgq as $val){
			if(array_key_exists($val['Match_ID'], $match)){
				$val['Match_CoverDate'] = strtotime($val['Match_CoverDate']);
				foreach($match[$val['Match_ID']] as $key=>$rows){
					$num = $val['Match_Time']-$rows['match_time'];
					if($num-1<=$rows['num']){
						$bool = false;
						$msg_t = '';
						if($rows['match_nowscore']==$val['Match_score_h'].':'.$val['Match_score_c']){
							if(($rows['Match_HRedCard']!=$val['Match_redcard_h'])||($rows['Match_GRedCard']!=$val['Match_redcard_c'])){
								$msg_t = '足球滚球注单红卡无效';
								$bool = cancelbet(7, $rows['bid'], $rows['uid'], $rows['master_guest'].'_注单已取消', $rows['master_guest'].'<br />'.$rows['bet_info'].'<br /><font style="color:#F00"/>因红卡无效，该注单取消，已返还本金。</font>', '红卡无效');
							}else if($rows['bet_time']&&($num>=$rows['num']?true:$val['Match_CoverDate']-$rows['time']>=$rows['num']*60)){
								$msg_t = '足球滚球注单有效';
								$bool = setok($rows['bid']);
							}
						}else{
							$msg_t = '足球滚球注单进球无效';
							$bool = cancelbet(6, $rows['bid'], $rows['uid'], $rows['master_guest'].'_注单已取消', $rows['master_guest'].'<br />'.$rows['bet_info'].'<br /><font style="color:#F00"/>因进球无效，该注单取消，已返还本金。</font>', '进球无效');
						}
						if($bool){
							$filename = '../../cache/logList/'.date('Y-m-d', $now_time).'.txt';
							$somecontent = '['.date('Y-m-d H:i:s', $now_time).']	系统C审核了编号为'.$rows['bid'].'的'.$msg_t.'	投注金额['.$rows['bet_money'].']'.PHP_EOL;
							$handle = fopen($filename, 'a');
							if(fwrite($handle, $somecontent)===false){
								exit();
							}
							fclose($handle);
							$msg.= '<font color="#0000FF">审核了编号为'.$rows['bid'].'的'.$msg_t.'</font><br />';
						}
						unset($match[$val['Match_ID']][$key]);
					}
				}
				if(empty($match[$val['Match_ID']])){
					unset($match[$val['Match_ID']]);
				}
			}
		}
	}

	/* 缓存可能存在无数据情况，使用数据库数据进行判断 */
	if(!empty($match)){
		$params = array_keys($match);
		$stmt = $mydata1_db->prepare('SELECT `Match_HRedCard`, `Match_GRedCard`, `Match_NowScore`, `Match_ID`, `Match_Time`, `Match_LstTime` FROM `mydata4_db`.`bet_match` WHERE `Match_Type`=2 AND `Match_ID` IN (?'.str_repeat(', ?', count($params)-1).')');
		$stmt->execute($params);
		while ($val = $stmt->fetch()) {
			$val['Match_LstTime'] = strtotime($val['Match_LstTime']);
			foreach($match[$val['Match_ID']] as $rows){
				$num = $val['Match_Time']-$rows['match_time'];
				if($num-1<=$rows['num']){
					$bool = false;
					$msg_t = '';
					if($rows['match_nowscore']==$val['Match_NowScore']){
						if(($rows['Match_HRedCard']!=$val['Match_HRedCard'])||($rows['Match_GRedCard']!=$val['Match_GRedCard'])){
							$msg_t = '足球滚球注单红卡无效';
							$bool = cancelbet(7, $rows['bid'], $rows['uid'], $rows['master_guest'].'_注单已取消', $rows['master_guest'].'<br />'.$rows['bet_info'].'<br /><font style="color:#F00"/>因红卡无效，该注单取消，已返还本金。</font>', '红卡无效');
						}else if($rows['bet_time']&&($num>=$rows['num']?true:$val['Match_LstTime']-$rows['time']>=$rows['num']*60)){
							$msg_t = '足球滚球注单有效';
							$bool = setok($rows['bid']);
						}
					}else{
						$msg_t = '足球滚球注单进球无效';
						$bool = cancelbet(6, $rows['bid'], $rows['uid'], $rows['master_guest'].'_注单已取消', $rows['master_guest'].'<br />'.$rows['bet_info'].'<br /><font style="color:#F00"/>因进球无效，该注单取消，已返还本金。</font>', '进球无效');
					}
					if($bool){
						$filename = '../../cache/logList/'.date('Y-m-d', $now_time).'.txt';
						$somecontent = '['.date('Y-m-d H:i:s', $now_time).']	系统M审核了编号为'.$rows['bid'].'的'.$msg_t.'	投注金额['.$rows['bet_money'].']'.PHP_EOL;
						$handle = fopen($filename, 'a');
						if(fwrite($handle, $somecontent)===false){
							exit();
						}
						fclose($handle);
						$msg.= '<font color="#0000FF">审核了编号为'.$rows['bid'].'的'.$msg_t.'</font><br />';
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
<title>足球滚球自动审核 v2</title> 
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
<div align="left" style="padding:5px;background-color:#CCC">足球滚球自动审核 v2</div> 
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