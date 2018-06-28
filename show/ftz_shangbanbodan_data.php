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
if($wap == 'wap'){ //手机端选择
	if(!empty($_GET['leaguename'])){
		$sqlwhere .= ' and Match_Name = \''.$_GET['leaguename'].'\'';
	}
	$sqlwhere .= ' and Match_Date>\''.date('m-d').'\' ';
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

	//日期选择
	$sel_gd = $_GET['sel_gd'];
	$Dates =  explode('|',$sel_gd);

	if(sizeof($Dates)>1){//未来 按钮
		$str = '';
		foreach ($Dates as $v) {
			$str .= "'".date('m-d',strtotime($v))."',";
		}

		$sqlwhere .= ' and Match_Date in ('.rtrim($str,',').')';
	}else{
		if($sel_gd == 'ALL'){//所有日期
			$sqlwhere .= ' and Match_Date>\''.date('m-d').'\' ';
		}else{//单独日期选择
			$sqlwhere .= ' and Match_Date=\''.date('m-d',strtotime($sel_gd)).'\' ';
		}
	}

}

//联盟排序
if($_GET['sort'] == "C"){
	$esc = " match_name,Match_CoverDate,iPage,Match_Master,Match_ID,iSn";
}else{
	$esc = " Match_CoverDate,iPage,match_name,Match_Master,Match_ID,iSn";
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


$sql = 'select id from mydata4_db.bet_match where  Match_CoverDate>now() and Match_Hr_Bd10>0 ' . $sqlwhere . ' order by '.$esc;

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
	$params = array(':Match_Date' => date('m-d'));
	$sql = 'select match_name from mydata4_db.bet_match where  Match_CoverDate>now() and Match_Hr_Bd10>0 ' . $sqlwhere . ' group by match_name';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$i = 0;
	$lsm = '';
	while ($row = $stmt->fetch()){
		$lsm .= urlencode($row['match_name']) . '|';
		$i++;
	}

	$json['lsm'] = rtrim($lsm, '|');
	$json['dh'] = ceil($i / 3) * 30;
	$sql = 'SELECT Match_ID, Match_Date, Match_Time, Match_Master, Match_Guest, Match_MasterID, Match_GuestID, Match_Name, Match_IsLose, Match_Hr_Bd10, Match_Hr_Bd20, Match_Hr_Bd21, Match_Hr_Bd30, Match_Hr_Bd31, Match_Hr_Bd32, Match_Hr_Bd40, Match_Hr_Bd41, Match_Hr_Bd42, Match_Hr_Bd43, Match_Hr_Bd00, Match_Hr_Bd11, Match_Hr_Bd22, Match_Hr_Bd33, Match_Hr_Bd44, Match_Hr_Bdup5, Match_Hr_Bdg10, Match_Hr_Bdg20, Match_Hr_Bdg21, Match_Hr_Bdg30, Match_Hr_Bdg31, Match_Hr_Bdg32, Match_Hr_Bdg40, Match_Hr_Bdg41, Match_Hr_Bdg42, Match_Hr_Bdg43 FROM mydata4_db.Bet_Match where id in(' . $id . ') order by '.$esc;

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
		$json['db'][$i]['Match_Bd10'] = $rows['Match_Hr_Bd10'];
		$json['db'][$i]['Match_Bd20'] = $rows['Match_Hr_Bd20'];
		$json['db'][$i]['Match_Bd21'] = $rows['Match_Hr_Bd21'];
		$json['db'][$i]['Match_Bd30'] = $rows['Match_Hr_Bd30'];
		$json['db'][$i]['Match_Bd31'] = $rows['Match_Hr_Bd31'];
		$json['db'][$i]['Match_Bd32'] = $rows['Match_Hr_Bd32'];
		$json['db'][$i]['Match_Bd00'] = $rows['Match_Hr_Bd00'];
		$json['db'][$i]['Match_Bd11'] = $rows['Match_Hr_Bd11'];
		$json['db'][$i]['Match_Bd22'] = $rows['Match_Hr_Bd22'];
		$json['db'][$i]['Match_Bd33'] = $rows['Match_Hr_Bd33'];
		$json['db'][$i]['Match_Bdup5'] = $rows['Match_Hr_Bdup5'];
		$json['db'][$i]['Match_Bdg10'] = $rows['Match_Hr_Bdg10'];
		$json['db'][$i]['Match_Bdg20'] = $rows['Match_Hr_Bdg20'];
		$json['db'][$i]['Match_Bdg21'] = $rows['Match_Hr_Bdg21'];
		$json['db'][$i]['Match_Bdg30'] = $rows['Match_Hr_Bdg30'];
		$json['db'][$i]['Match_Bdg31'] = $rows['Match_Hr_Bdg31'];
		$json['db'][$i]['Match_Bdg32'] = $rows['Match_Hr_Bdg32'];
		$i++;
	}
}

echo $callback."(".json_encode($json).");";