<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('bfgl');
$mid = @($_GET['mid']);
if ($mid){
	$MB_Inball_HR = $_GET['MB_Inball_HR'];
	$TG_Inball_HR = $_GET['TG_Inball_HR'];
	$MB_Inball = $_GET['MB_Inball'];
	$TG_Inball = $_GET['TG_Inball'];
	if (($MB_Inball_HR == '') || ($TG_Inball_HR == ''))
	{
		message('请输入正确的上半场比分！');
	}
	$match_name = $_GET['hf_match_name'];
	$Match_Master = $_GET['hf_Match_Master'];
	$Match_Guest = $_GET['hf_Match_Guest'];
	$Match_Date = $_GET['hf_Match_Date'];
	$params = array(':match_name' => $match_name, ':Match_Master' => $Match_Master, ':Match_Guest' => $Match_Guest, ':Match_Date' => '%' . $Match_Date . '%');
	$sql = 'select Match_ID from mydata4_db.bet_match where match_name=:match_name and Match_Master=:Match_Master and Match_Guest=:Match_Guest and Match_Date like (:Match_Date)';
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
		$params = array(':mb_inball' => $MB_Inball, ':tg_inball' => $TG_Inball, ':mb_inball_hr' => $MB_Inball_HR, ':tg_inball_hr' => $TG_Inball_HR);
		$sql = 'update mydata4_db.bet_match set mb_inball=:mb_inball,tg_inball=:tg_inball,mb_inball_hr=:mb_inball_hr,tg_inball_hr=:tg_inball_hr where match_id in(' . $mid . ')';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$sql = 'select bid,point_column from k_bet where lose_ok=1 and status=0 and match_id in(' . $mid . ') order by bid desc ';
		$result = $mydata1_db->query($sql);
		$bid = '';
		$bid_sb = '';
		$arr_sb = array('match_bmdy', 'match_bgdy', 'match_bhdy', 'match_bho', 'match_bao', 'match_bdpl', 'match_bxpl');
		while ($rows = $result->fetch())
		{
			if (in_array(strtolower($rows['point_column']), $arr_sb) || strpos(strtolower($rows['point_column']), 'match_hr_bd'))
			{
				$bid_sb .= intval($rows['bid']) . ',';
			}
			else
			{
				$bid .= intval($rows['bid']) . ',';
			}
		}
		if ($bid != '')
		{
			$bid = rtrim($bid, ',');
			$params = array(':MB_Inball' => $MB_Inball, ':TG_Inball' => $TG_Inball);
			$sql = 'update k_bet set MB_Inball=:MB_Inball,TG_Inball=:TG_Inball where bid in(' . $bid . ')';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
		if ($bid_sb != '')
		{
			$bid_sb = rtrim($bid_sb, ',');
			$params = array(':MB_Inball' => $MB_Inball_HR, ':TG_Inball' => $TG_Inball_HR);
			$sql = 'update k_bet set MB_Inball=:MB_Inball,TG_Inball=:TG_Inball where bid in(' . $bid_sb . ')';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
		$sql = 'select bid,ball_sort,bet_info from k_bet_cg where status=0 and match_id in(' . $mid . ') order by bid desc';
		$result_cg = $mydata1_db->query($sql);
		$bid = '';
		$bid_sb = rtrim($bid, ',');
		while ($rows = $result_cg->fetch())
		{
			if (strpos($rows['ball_sort'], '上半场') || strpos($rows['bet_info'], '上半场'))
			{
				$bid_sb .= intval($rows['bid']) . ',';
			}
			else
			{
				$bid .= intval($rows['bid']) . ',';
			}
		}
		if ($bid_sb != '')
		{
			$bid_sb = rtrim($bid_sb, ',');
			$params = array(':MB_Inball' => $MB_Inball_HR, ':TG_Inball' => $TG_Inball_HR);
			$sql = 'update k_bet_cg set mb_inball=:MB_Inball,tg_inball=:TG_Inball where bid in(' . $bid_sb . ')';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
		if ($bid != '')
		{
			$bid = rtrim($bid, ',');
			$params = array(':MB_Inball' => $MB_Inball, ':TG_Inball' => $TG_Inball);
			$sql = 'update k_bet_cg set mb_inball=:MB_Inball,tg_inball=:TG_Inball where bid in(' . $bid . ')';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
		$value = '保存全场';
	}else{
		$params = array(':mb_inball_hr' => $MB_Inball_HR, ':tg_inball_hr' => $TG_Inball_HR);
		$sql = 'update mydata4_db.bet_match set mb_inball_hr=:mb_inball_hr,tg_inball_hr=:tg_inball_hr where match_id in(' . $mid . ')';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$bid = '';
		$sql = 'select bid from k_bet where lose_ok=1 and (point_column in (\'match_bmdy\',\'match_bgdy\',\'match_bhdy\',\'match_bho\',\'match_bao\',\'match_bdpl\',\'match_bxpl\') or point_column like \'match_hr_bd%\') and status=0 and match_id in(' . $mid . ') order by bid desc';
		$result = $mydata1_db->query($sql);
		while ($rows = $result->fetch()){
			$bid .= intval($rows['bid']) . ',';
		}
		$bid = rtrim($bid, ',');
		if ($bid != ''){
			$params = array(':MB_Inball' => $MB_Inball_HR, ':TG_Inball' => $TG_Inball_HR);
			$sql = 'update k_bet set MB_Inball=:MB_Inball,TG_Inball=:TG_Inball where bid in(' . $bid . ')';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
		$sql = 'select bid from k_bet_cg where status=0 and match_id in(' . $mid . ') and (ball_sort like(\'%上半场%\') or bet_info like(\'%上半场%\')) order by bid desc';
		$result_cg = $mydata1_db->query($sql);
		$bid = '';
		while ($rows = $result_cg->fetch()){
			$bid .= intval($rows['bid']) . ',';
		}
		
		if ($bid != ''){
			$bid = rtrim($bid, ',');
			$params = array(':MB_Inball' => $MB_Inball_HR, ':TG_Inball' => $TG_Inball_HR);
			$sql = 'update k_bet_cg set mb_inball=:MB_Inball,tg_inball=:TG_Inball where bid in(' . $bid . ')';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
		$value = '保存上半场';
	}
	message($value . '成功！', 'zqbf_yjs.php');
}else{
	message('系统没有查找到您要结算的赛事！');
}
?>