<?php function lottery_odds($type, $ball, $h)
{
	global $mydata1_db;
	$type = intval($type);
	$h = intval($h);
	$params = array(':type' => $ball);
	$sql = 'select * from c_odds_' . $type . ' where type=:type limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$t = $stmt->fetch();
	return $t['h' . $h . ''];
}
function lottery_qishu($type)
{
	$type = intval($type);
	$lottery_time = time() + (1 * 12 * 3600);
	global $mydata1_db;
	$params = array(':kaipan' => date('H:i:s', $lottery_time), ':fengpan' => date('H:i:s', $lottery_time));
	$sql = 'select qishu from c_opentime_' . $type . ' where kaipan<=:kaipan and fengpan>=:fengpan limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$qs = $stmt->fetch();
	if ($qs)
	{
		return date('Ymd', $lottery_time) . BuLings($qs['qishu']);
	}
	else
	{
		return -1;
	}
}
function lottery_qishu_3($type)
{
	$type = intval($type);
	$lottery_time = time() + (1 * 12 * 3600);
	global $mydata1_db;
	$params = array(':kaipan' => date('H:i:s', $lottery_time), ':fengpan' => date('H:i:s', $lottery_time));
	$sql = 'select qishu from c_opentime_' . $type . ' where kaipan<=:kaipan and fengpan>=:fengpan limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$qs = $stmt->fetch();
	if ($qs)
	{
		return date('Ymd', $lottery_time) . BuLing($qs['qishu']);
	}
	else if ((strtotime(date('Y-m-d', $lottery_time) . ' 23:00:00') <= strtotime(date('Y-m-d H:i:s', $lottery_time))) && (strtotime(date('Y-m-d H:i:s', $lottery_time)) <= strtotime(date('Y-m-d', $lottery_time) . ' 23:59:59')))
	{
		$sql = 'select * from c_opentime_' . $type . ' order by id asc limit 0,1';
		$query = $mydata1_db->query($sql);
		$qs = $query->fetch();
		$next_daytime = strtotime(date('Y-m-d', $lottery_time) . ' 00:00:00') + (1 * 24 * 3600);
		return date('Ymd', $next_daytime) . BuLing($qs['qishu']);
	}
	else
	{
		return -1;
	}
}
function lottery_qishu_4($type)
{
	$type = intval($type);
	include '../../cache/website.php';
	$lottery_time = time() + (1 * 12 * 3600);
	$fixno = $web_site['pk10_knum'];
	$daynum = floor(($lottery_time - strtotime($web_site['pk10_ktime'] . ' 00:00:00')) / 3600 / 24);
	$lastno = (($daynum - 1) * 179) + $fixno;
	global $mydata1_db;
	$params = array(':kaipan' => date('H:i:s', $lottery_time), ':fengpan' => date('H:i:s', $lottery_time));
	$sql = 'select qishu from c_opentime_' . $type . ' where kaipan<=:kaipan and fengpan>=:fengpan limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$qs = $stmt->fetch();
	if ($qs)
	{
		return $lastno + $qs['qishu'];
	}
	else if ((strtotime(date('Y-m-d', $lottery_time) . ' 23:55:00') <= strtotime(date('Y-m-d H:i:s', $lottery_time))) && (strtotime(date('Y-m-d H:i:s', $lottery_time)) <= strtotime(date('Y-m-d', $lottery_time) . ' 23:59:59')))
	{
		$sql = 'select * from c_opentime_' . $type . ' order by id asc limit 0,1';
		$query = $mydata1_db->query($sql);
		$qs = $query->fetch();
		$next_daytime = strtotime(date('Y-m-d', $lottery_time) . ' 00:00:00') + (1 * 24 * 3600);
		return $lastno + 179 + 1;
	}
	else
	{
		return -1;
	}
}

function lottery_qishu_8()
{
	$lottery_time = time() + (1 * 12 * 3600);
	global $mydata1_db;
	$params = array(':kaipan' => date('H:i:s', $lottery_time), ':fengpan' => date('H:i:s', $lottery_time));
	$sql = 'select qishu from c_opentime_8 where kaipan<=:kaipan and fengpan>=:fengpan limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$qs = $stmt->fetch();
	if ($qs){
		$qishu = date('Ymd', $lottery_time).substr('00'.$qs['qishu'], -3);
	    if(strtotime(date('Y-m-d 04:04:00',$lottery_time))>$lottery_time){
	        $qishu = date('Ymd', $lottery_time-24*60*60).substr('00'.$qs['qishu'], -3);
	    }
		return $qishu;
	}else{
		return -1;
	}
}

function user_money($username, $money)
{
	global $mydata1_db;
	$params = array(':username' => $username);
	$sql = 'select money from k_user where username=:username limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$user = $stmt->fetch();
	if (0 <= $user['money'] - $money)
	{
		$params = array(':money' => $money, ':username' => $username);
		$sql = 'update k_user set money=money-:money where username=:username limit 1';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		return $user['money'] - $money;
	}
	else
	{
		return -1;
	}
}
function BuLing($num)
{
	if ($num < 10)
	{
		$num = '0' . $num;
	}
	return $num;
}
function BuLings($num)
{
	if ($num < 10)
	{
		$num = '00' . $num;
	}
	if ((10 <= $num) && ($num < 100))
	{
		$num = '0' . $num;
	}
	return $num;
}?>