<?php
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cpgl');
check_quanxian('cppl');
$type = intval($_REQUEST['type']);
$num = intval($_REQUEST['num']);
$i = intval($_REQUEST['i']);
if (($type < 6) && ($num < 10)){
	$xodds = 0.10000000000000001;
}else{
	$xodds = 0.01;
}

if ($i == 0){
	$xodds = -$xodds;
}
$num = 'h' . $num;
$up_odds = 'update c_odds_2 set ' . $num . '=' . $num . '+' . $xodds . ' where type=\'ball_' . $type . '\'';
$mydata1_db->query($up_odds);
$sql = 'select * from c_odds_2 where type=\'ball_' . $type . '\' order by id asc';
$query = $mydata1_db->query($sql);
$list = array();
while ($odds = $query->fetch())
{
	$i = 1;
	for (;$i < 15;$i++)
	{
		$list[$i] = $odds['h' . $i];
	}
}
$arr = array('oddslist' => $list);
$json_string = json_encode($arr);
echo $json_string;
?>  