<?php 
header('Content-type: text/json;charset=utf-8');
include_once '../include/pd_user_json.php';
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/function.php';

$this_page = 0;
if (0 < intval($_GET['CurrPage'])){
	$this_page = intval($_GET['CurrPage']);
}
$this_page++;
$bk = 40;
$sqlwhere = '';
$id = '';
$i = 1;
$start = (($this_page - 1) * $bk) + 1;
$end = $this_page * $bk;
$params = array();
if (@($_GET['leaguename']) != ''){
	$leaguename = explode('$', urldecode($_GET['leaguename']));
	$v = (1 < count($leaguename) ? 'and (' : 'and');
	$params[':match_name'] = $leaguename[0];
	$sqlwhere .= ' ' . $v . ' match_name=:match_name';
	$is = 1;
	for (;$is < (count($leaguename) - 1);
	$is++)
	{
		$params[':match_name_' . $is] = $leaguename[$is];
		$sqlwhere .= ' or match_name=:match_name_' . $is;
	}
	$sqlwhere .= (1 < count($leaguename) ? ')' : '');
}
$params[':Match_Date'] = date('m-d');
$sql = 'select id from mydata4_db.bet_match where Match_Type=1 and match_date=:Match_Date AND Match_CoverDate>now() and (Match_BHo+Match_BAo<>0 or Match_Bdpl+Match_Bxpl<>0) and Match_IsShowb=1 ' . $sqlwhere . ' order by Match_CoverDate,iPage,match_name,Match_Master,Match_ID,iSn';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
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
	$sql = 'select match_name from mydata4_db.bet_match where Match_Type=1 and match_date=:Match_Date AND Match_CoverDate>now() and (Match_BHo+Match_BAo<>0 or Match_Bdpl+Match_Bxpl<>0) and Match_IsShowb=1 group by match_name';
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
	$sql = 'SELECT Match_ID, Match_Date, Match_Time, Match_Master, Match_Guest, Match_Name, Match_IsLose, Match_Bmdy, Match_BHo,  Match_Bdpl, Match_Bgdy, Match_BAo, Match_Bxpl, Match_Bhdy, Match_BRpk, Match_Hr_ShowType, Match_Bdxpk FROM mydata4_db.Bet_Match where id in(' . $id . ') order by Match_CoverDate,iPage,match_name,Match_Master,Match_ID,iSn';
	$query = $mydata1_db->query($sql);
	$i = 0;
	while ($rows = $query->fetch()){
		$json['db'][$i]['Match_ID'] = $rows['Match_ID'];
		$json['db'][$i]['Match_Master'] = $rows['Match_Master'];
		$json['db'][$i]['Match_Guest'] = $rows['Match_Guest'];
		$json['db'][$i]['Match_Name'] = $rows['Match_Name'];
		$mdate = $rows['Match_Date'] . '<br>' . $rows['Match_Time'];
		if ($rows['Match_IsLose'] == 1)
		{
			$mdate .= '<br><font color=red>滾球</font>';
		}
		$json['db'][$i]['Match_Date'] = $mdate;
		$json['db'][$i]['Match_Bmdy'] = $rows['Match_Bmdy'];
		$json['db'][$i]['Match_BHo'] = $rows['Match_BHo'];
		$json['db'][$i]['Match_Bdpl'] = $rows['Match_Bdpl'];
		$json['db'][$i]['Match_Bgdy1'] = $rows['Match_Bgdy'];
		$json['db'][$i]['Match_Bgdy2'] = $rows['Match_Bgdy'];
		$json['db'][$i]['Match_BAo'] = $rows['Match_BAo'];
		$json['db'][$i]['Match_Bxpl'] = $rows['Match_Bxpl'];
		$json['db'][$i]['Match_Bhdy1'] = $rows['Match_Bhdy'];
		$json['db'][$i]['Match_Bhdy2'] = $rows['Match_Bhdy'];
		$json['db'][$i]['Match_BRpk'] = $rows['Match_BRpk'];
		$json['db'][$i]['Match_Bdxpk1'] = 'O' . $rows['Match_Bdxpk'];
		$json['db'][$i]['Match_Hr_ShowType'] = $rows['Match_Hr_ShowType'];
		$json['db'][$i]['Match_Bdxpk2'] = 'U' . $rows['Match_Bdxpk'];
		$i++;
	}
}

echo $callback."(".json_encode($json).");";