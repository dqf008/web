<?php 
header('Content-type: text/json;charset=utf-8');
include_once '../include/pd_user_json.php';
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/function.php';

$wap = $_GET['wap'];
$sqlwhere = '';
//选择联盟
if($wap == 'wap' and !empty($_GET['leaguename'])){ //手机端选择
	$sqlwhere .= ' and Match_Name = \''.$_GET['leaguename'].'\'';
}else{
	$leaguename = rtrim($_GET['leaguename'],',');
	$leaguenames = "";
	if ( $leaguename != ''){
		$sql = 'select Match_Name from mydata4_db.bet_match WHERE Match_ID in ('.$leaguename.')';
		$stmt = $mydata1_db->query($sql);
		while ($row = $stmt->fetch()){
			$leaguenames .= '"'.$row['Match_Name'] . '",';
		}
	}


	$leaguenames = rtrim($leaguenames,',');
	if ($leaguenames != ''){
		
		$sqlwhere .= ' and Match_Name in ('.$leaguenames.')';
	}

}



//联盟排序
if($_GET['sort'] == "C"){
	$esc = " Match_Name,Match_CoverDate";
}else{
	$esc = " Match_CoverDate,Match_Name";
}


$this_page = 0;
if (0 < intval($_GET['CurrPage'])){
	$this_page = intval($_GET['CurrPage']);
}
$this_page++;
$bk = 40;
$id = '';
$i = 1;
$start = (($this_page - 1) * $bk) + 1;
$end = $this_page * $bk;


$sql = 'select id from mydata4_db.volleyball_match where match_date=\''.date('m-d').'\' and Match_Type=1 and Match_IsShowbd=1 and Match_CoverDate>now() and Match_Bd21>0 ' . $sqlwhere . ' order by '.$esc;

$stmt = $mydata1_db->query($sql);
while ($row = $stmt->fetch()){
	if (($start <= $i) && ($i <= $end)){
		$id = intval($row['id']) . ',' . $id;
	}
	$i++;
}

if ($i == 1){
	$json['dh'] = 0;
	$json['fy']['p_page'] = 0;
}else{
	$id = rtrim($id, ',');
	$json['fy']['p_page'] = ceil($i / $bk);
	$json['fy']['page'] = $this_page - 1;
	$sql = 'select match_name from mydata4_db.volleyball_match where match_date=\''.date('m-d').'\' and Match_Type=1 and Match_IsShowbd=1 and Match_CoverDate>now() and Match_Bd21>0 group by match_name';
	$query = $mydata1_db->query($sql);
	$i = 0;
	$lsm = '';
	while ($row = $query->fetch()){
		$lsm .= urlencode($row['match_name']) . '|';
		$i++;
	}

	$json['lsm'] = rtrim($lsm, '|');
	$json['dh'] = ceil($i / 3) * 30;
	$sql = 'SELECT Match_ID, Match_Date, Match_Time, Match_MasterID, Match_GuestID, Match_Master, Match_Guest, Match_Name, Match_IsLose, Match_Bd20, Match_Bd21, Match_Bd30, Match_Bd31, Match_Bd32, Match_Bdg20, Match_Bdg21, Match_Bdg30, Match_Bdg31, Match_Bdg32,Match_best FROM mydata4_db.volleyball_match where id in(' . $id . ') order by '.$esc;
	$query = $mydata1_db->query($sql);
	$i = 0;
	while ($rows = $query->fetch()){
		$json['db'][$i]['Match_ID'] = $rows['Match_ID'];
		$json['db'][$i]['Match_Master'] = $rows['Match_Master'];
		$json['db'][$i]['Match_Guest'] = $rows['Match_Guest'];
		$json['db'][$i]['Match_MasterID'] = $rows['Match_MasterID'];
		$json['db'][$i]['Match_GuestID'] = $rows['Match_GuestID'];
		$json['db'][$i]['Match_Name'] = $rows['Match_Name'];
		$json['db'][$i]['Match_Date'] = $rows['Match_Date'];
		$json['db'][$i]['Match_Time'] = $rows['Match_Time'];
		$json['db'][$i]['Match_IsLose'] = $rows['Match_IsLose'];
		
		$json['db'][$i]['Match_Bd20'] = $rows['Match_Bd20'];
		$json['db'][$i]['Match_Bd21'] = $rows['Match_Bd21'];
		$json['db'][$i]['Match_Bd30'] = $rows['Match_Bd30'];
		$json['db'][$i]['Match_Bd31'] = $rows['Match_Bd31'];
		$json['db'][$i]['Match_Bd32'] = $rows['Match_Bd32'];

		$json['db'][$i]['Match_Bdg20'] = $rows['Match_Bdg20'];
		$json['db'][$i]['Match_Bdg21'] = $rows['Match_Bdg21'];
		$json['db'][$i]['Match_Bdg30'] = $rows['Match_Bdg30'];
		$json['db'][$i]['Match_Bdg31'] = $rows['Match_Bdg31'];
		$json['db'][$i]['Match_Bdg32'] = $rows['Match_Bdg32'];

		$json['db'][$i]['Match_best'] = $rows['Match_best'];
		$i++;
	}
}
 
echo $callback."(".json_encode($json).");";