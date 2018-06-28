<?php 
header('Content-type: text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
$val = explode('|||', $_POST['value']);
$mid = $val[3];
$table = $val[4];
$arr_table = array('baseball_match', 'bet_match', 'lq_match', 't_guanjun_team', 'tennis_match', 'volleyball_match');
if (!in_array($table, $arr_table)){
	echo 3;
	exit();
}

if ($mid){
	$MB_Inball = $val[0];
	$TG_Inball = $val[1];
	$params = array(':Match_ID' => $mid);
	$sql = 'select Match_Master,match_name,Match_Guest from mydata4_db.' . $table . ' where Match_ID=:Match_ID limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rows = $stmt->fetch();
	$match_name = $rows['match_name'];
	$Match_Master = $rows['Match_Master'];
	$Match_Guest = $rows['Match_Guest'];
	$Match_Date = $val[2];
	$params = array(':match_name' => $match_name, ':Match_Master' => $Match_Master, ':Match_Guest' => $Match_Guest, ':Match_Date' => $Match_Date);
	$sql = 'select Match_ID from mydata4_db.' . $table . ' where match_name=:match_name and Match_Master=:Match_Master and Match_Guest=:Match_Guest and Match_Date=:Match_Date';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$mid = '';
	while ($rows = $stmt->fetch())
	{
		$mid .= floatval($rows['Match_ID']) . ',';
	}
	$mid = rtrim($mid, ',');
	$value = '';
	if (($MB_Inball != '') && ($TG_Inball != ''))
	{
		$params = array(':MB_Inball' => $MB_Inball, ':TG_Inball' => $TG_Inball);
		$sql = 'update mydata4_db.' . $table . ' set mb_inball=:MB_Inball,tg_inball=:TG_Inball where match_id in(' . $mid . ')';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$sql = 'select bid from k_bet where lose_ok=1 and status=0 and match_id in(' . $mid . ') order by bid desc ';
		$result = $mydata1_db->query($sql);
		$bid = '';
		while ($rows = $result->fetch())
		{
			$bid .= intval($rows['bid']) . ',';
		}
		if ($bid != '')
		{
			$bid = rtrim($bid, ',');
			$params = array(':MB_Inball' => $MB_Inball, ':TG_Inball' => $TG_Inball);
			$sql = 'update k_bet set MB_Inball=:MB_Inball,TG_Inball=:TG_Inball where bid in(' . $bid . ')';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
		echo 1;
		exit();
	}
}else{
	echo 3;
 	exit();
}
?>