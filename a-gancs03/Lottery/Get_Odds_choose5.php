<?php
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
$type = intval($_REQUEST['type']);
$params = array(':type' => 'ball_' . $type);
$sql = 'select * from c_odds_choose5 where type=:type order by id asc';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$list = array();
while ($odds = $stmt->fetch())
{
	for ($i = 1;$i < 16;$i++)
	{
		$list[$i] = $odds['h' . $i];
	}
}
$arr = array('oddslist' => $list);
$json_string = json_encode($arr);
echo $json_string;
?>