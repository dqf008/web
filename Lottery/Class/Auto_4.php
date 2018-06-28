<?php header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include '../include/auto_class4.php';
include '../include/lottery_time.php';
$ball = $_REQUEST['ball'];
$sql = 'select * from c_auto_4 order by qishu desc limit 0,1';
$query = $mydata1_db->query($sql);
$hm = $hms = $hmlist = array();
$is = 1;
$qishu = '';
while ($rs = $query->fetch())
{
	if ($is == 1)
	{
		$qishu = $rs['qishu'];
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
		$hms[] = Ssc_Auto($hm, 1);
		$hms[] = Ssc_Auto($hm, 2);
		$hms[] = Ssc_Auto($hm, 3);
		$hms[] = Ssc_Auto($hm, 4);
		$hms[] = Ssc_Auto($hm, 5);
		$hms[] = Ssc_Auto($hm, 6);
		$hms[] = Ssc_Auto($hm, 7);
		$hms[] = Ssc_Auto($hm, 8);
	}
	$hmlist[$rs['qishu']][] = BuLing($rs['ball_1']) . ',' . BuLing($rs['ball_2']) . ',' . BuLing($rs['ball_3']) . ',' . BuLing($rs['ball_4']) . ',' . BuLing($rs['ball_5']) . ',' . BuLing($rs['ball_6']) . ',' . BuLing($rs['ball_7']) . ',' . BuLing($rs['ball_8']) . ',' . BuLing($rs['ball_9']) . ',' . BuLing($rs['ball_10']);
	$is++;
}
$arr = array('numbers' => $qishu, 'hm' => $hm, 'hms' => $hms, 'hmlist' => $hmlist);
$json_string = json_encode($arr);
 echo $json_string;
function BuLing($num)
{
	if ($num < 10)
	{
		$num = '0' . $num;
	}
	return $num;
}?>