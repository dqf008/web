<?php header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include '../include/lottery_time.php';
$sql = 'select * from c_odds_4 order by id asc';
$query = $mydata1_db->query($sql);
$list = array();
$s = 1;
while ($odds = $query->fetch())
{
	$i = 1;
	for (;$i < 22;$i++)
	{
		$list['ball'][$s][$i] = $odds['h' . $i];
	}
	$s++;
}
$params = array(':kaipan' => date('H:i:s', $lottery_time), ':kaijiang' => date('H:i:s', $lottery_time));
$sql = 'select * from c_opentime_4 where kaipan<=:kaipan and kaijiang>=:kaijiang order by id asc';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$qs = $stmt->fetch();
$fixno = $web_site['pk10_knum'];
$daynum = floor(($lottery_time - strtotime($web_site['pk10_ktime'] . ' 00:00:00')) / 3600 / 24);
$lastno = (($daynum - 1) * 179) + $fixno;
if ($qs)
{
	$qishu = $lastno + $qs['qishu'];
	$fengpan = strtotime(date('Y-m-d', $lottery_time) . ' ' . $qs['fengpan']) - $lottery_time;
	$kaijiang = strtotime(date('Y-m-d', $lottery_time) . ' ' . $qs['kaijiang']) - $lottery_time;
}
else
{
	$qishu = -1;
	$fengpan = -1;
	$kaijiang = -1;
}
$arr = array('number' => $qishu, 'endtime' => $fengpan, 'opentime' => $kaijiang, 'oddslist' => $list);
$json_string = json_encode($arr);
 echo $json_string;
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