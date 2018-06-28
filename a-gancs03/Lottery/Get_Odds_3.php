<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
$type = intval($_REQUEST['type']);
$lotteryType = $_REQUEST['lottery_type'];
$params = array(':type' => 'ball_' . $type);
if($lotteryType =='gdkl10'){
    $sql    = 'select * from c_odds_3 where type=:type order by id asc';
}else {
    $params[':name'] = $lotteryType;
    $sql    = 'select * from c_odds_klsf where type=:type and `name`=:name order by id asc';
}
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$list = array();
while ($odds = $stmt->fetch())
{
	$i = 1;
	for (;$i < 36;$i++)
	{
		$list[$i] = $odds['h' . $i];
	}
}
$arr = array('oddslist' => $list);
$json_string = json_encode($arr);
echo $json_string;
?>  