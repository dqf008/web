<?php 
header('Content-type: text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
$val = explode('|||', $_POST['value']);
$mid = $val[3];
if ($mid){
	$MB = $val[0];
	$TG = $val[1];
	$params = array(':Match_ID' => $mid);
	$sql = 'select Match_Master,match_name,Match_Guest from mydata4_db.lq_match where Match_ID=:Match_ID limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rows = $stmt->fetch();
	$match_name = $rows['match_name'];
	$Match_Master = $rows['Match_Master'];
	$Match_Guest = $rows['Match_Guest'];
	$Match_Date = $val[2];
	
	$params = array(':match_name' => $match_name, ':Match_Master' => $Match_Master, ':Match_Guest' => $Match_Guest, ':Match_Date' => $Match_Date);
	$sql = 'select Match_ID from mydata4_db.lq_match where match_name=:match_name and Match_Master=:Match_Master and Match_Guest=:Match_Guest and Match_Date=:Match_Date';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$mid = '';
	while ($rows = $stmt->fetch())
	{
		$mid .= floatval($rows['Match_ID']) . ',';
	}
	$mid = rtrim($mid, ',');
	$value = '';
	if (($MB != '') && ($TG != '')){
		$mb_inball = 'MB_Inball';
		$tg_inball = 'TG_Inball';
		$preg1 = '/第[1-4]节/';
		if (strpos($Match_Master, '上半') && strpos($Match_Guest, '上半'))
		{
			$mb_inball = 'MB_Inball_HR';
			$tg_inball = 'TG_Inball_HR';
		}else if (preg_match($preg1, $Match_Master, $num) && preg_match($preg1, $Match_Guest, $num)){
			if (strpos($num[0], '1'))
			{
				$mb_inball = 'MB_Inball_1st';
				$tg_inball = 'TG_Inball_1st';
			}
			else if (strpos($num[0], '2'))
			{
				$mb_inball = 'MB_Inball_2st';
				$tg_inball = 'TG_Inball_2st';
			}
			else if (strpos($num[0], '3'))
			{
				$mb_inball = 'MB_Inball_3st';
				$tg_inball = 'TG_Inball_3st';
			}
			else if (strpos($num[0], '4'))
			{
				$mb_inball = 'MB_Inball_4st';
				$tg_inball = 'TG_Inball_4st';
			}
		}else if (strpos($Match_Master, '下半') && strpos($Match_Guest, '下半')){
			$mb_inball = 'MB_Inball_ER';
			$tg_inball = 'TG_Inball_ER';
		}else if (strpos($Match_Master, '加时') && strpos($Match_Guest, '加时')){
			$mb_inball = 'MB_Inball_ADD';
			$tg_inball = 'TG_Inball_ADD';
		}
		
		$params = array(':MB' => $MB, ':MBOK' => $MB, ':TG' => $TG, ':TGOK' => $TG);
		$sql = 'update mydata4_db.lq_match set ' . $mb_inball . '=:MB,' . $tg_inball . '=:TG,MB_Inball_OK=:MBOK,TG_Inball_OK=:TGOK where match_id in('.$mid.')';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$sql = 'select bid from k_bet where lose_ok=1 and status=0 and match_id in(' . $mid . ') order by bid desc ';
		$result = $mydata1_db->query($sql);
		$bid = '';
		while ($rows = $result->fetch()){
			$bid .= intval($rows['bid']) . ',';
		}
		
		if ($bid != ''){
			$bid = rtrim($bid, ',');
			$params = array(':MB' => $MB, ':TG' => $TG);
			$sql = 'update k_bet set MB_Inball=:MB,TG_Inball=:TG where bid in(' . $bid . ')';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
		
		$sql = 'select bid from k_bet_cg where status=0 and match_id in(' . $mid . ') order by bid desc';
		$result_cg = $mydata1_db->query($sql);
		$bid = '';
		while ($rows = $result_cg->fetch()){
			$bid .= intval($rows['bid']) . ',';
		}
		
		if ($bid != ''){
			$bid = rtrim($bid, ',');
			$params = array(':MB' => $MB, ':TG' => $TG);
			$sql = 'update k_bet_cg set mb_inball=:MB,tg_inball=:TG where bid in(' . $bid . ')';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
		
		echo "1,".$mb_inball.",".$tg_inball;
		exit;
	}
}else{
	echo 3;
	exit;
}
?>