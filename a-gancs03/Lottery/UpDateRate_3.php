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
$lotteryType = $_REQUEST['lottery_type'];
if ($type < 9){
	if ($num < 21){
		$xodds = 1;
	}else if ((21 <= $num) && ($num < 29)){
		$xodds = 0.01;
	}else{
		$xodds = 0.10000000000000001;
	}
}else{
	$xodds = 0.001;
}

if ($i == 0)
{
	$xodds = -$xodds;
}
$num = 'h' . $num;
if($lotteryType =='gdkl10'){
    $up_odds = 'update c_odds_3 set ' . $num . '=' . $num . '+' . $xodds . ' where type=\'ball_' . $type . '\'';
}else {
    $up_odds = 'update c_odds_klsf set ' . $num . '=' . $num . '+' . $xodds . ' where type=\'ball_' . $type . '\' and name=\''.$lotteryType.'\'';
}
$mydata1_db->query($up_odds);
$newType ='ball_'.$type;
if($lotteryType=='gdkl10'){
    $sql = "select * from c_odds_3 where type='$newType'";
}else {
    $sql = "select * from c_odds_klsf where type='$newType' and `name`='$lotteryType' order by id asc";
}
$query = $mydata1_db->query($sql);
$list = array();
while ($odds = $query->fetch())
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