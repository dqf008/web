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

//赛事收藏
if (trim($_GET['ids']) != ''){
	$id = $_GET['ids'];
	$json['fy']['p_page'] = 0;
	$json['fy']['page'] = 0;

	$sql = 'select match_name from mydata4_db.tennis_Match WHERE id in(' . $id . ')  and Match_Date=\''.date('m-d').'\' and  Match_Type=1 AND Match_CoverDate>now() '.$sqlwhere.' group by match_name';
	$stmt = $mydata1_db->query($sql);
	$i = 0;
	$lsm = '';
	while ($row = $stmt->fetch()){
		$lsm .= urlencode($row['match_name']) . '|';
		$i++;
	}

	$json['lsm'] = rtrim($lsm, '|');
	$json['dh'] = ceil($i / 3) * 30;

	$sql = 'select id,Match_ID, Match_Date, Match_Time, Match_Master, Match_Guest, Match_RGG, Match_Name, Match_IsLose, Match_BzM, Match_BzG,  Match_DxDpl, Match_DxXpl, Match_DxGG, Match_Ho, Match_Ao, Match_MasterID, Match_GuestID, Match_Type, Match_DsDpl, Match_DsSpl,Match_ShowType,Match_isMaster,Match_best,Match_DFzDX,Match_DFzDpl,Match_DFzXpl,Match_DFkDX,Match_DFkDpl,Match_DFkXpl from mydata4_db.tennis_Match where id in(' . $id . ') order by '.$esc;
	$query = $mydata1_db->query($sql);
	$i = 0;
	while ($rows = $query->fetch()){
		$json['db'][$i]['ID'] = $rows['id'];
		$ids .= $rows['id'].',';
		$json['db'][$i]['Match_ID'] = $rows['Match_ID'];

		$json['db'][$i]['Match_Name'] = $rows['Match_Name'];

		$json['db'][$i]['Match_Master'] = $rows['Match_Master'];
		$json['db'][$i]['Match_Guest'] = $rows['Match_Guest'];
		$json['db'][$i]['Match_MasterID'] = $rows['Match_MasterID'];
		$json['db'][$i]['Match_GuestID'] = $rows['Match_GuestID'];
		

		$json['db'][$i]['Match_IsLose'] = $rows['Match_IsLose'];
		$json['db'][$i]['Match_Date'] = $rows['Match_Date'];
		$json['db'][$i]['Match_Time'] = $rows['Match_Time'];

		$json['db'][$i]['Match_isMaster'] = $rows['Match_isMaster'];
		$json['db'][$i]['Match_best'] = $rows['Match_best'];

		//独赢
		$json['db'][$i]['Match_BzM'] = $rows['Match_BzM'];
		$json['db'][$i]['Match_BzG'] = $rows['Match_BzG'];

		//让盘
		$json['db'][$i]['Match_ShowType'] = $rows['Match_ShowType'];
		$json['db'][$i]['Match_RGG'] = $rows['Match_RGG'];
		$json['db'][$i]['Match_Ho'] = $rows['Match_Ho'];
		$json['db'][$i]['Match_Ao'] = $rows['Match_Ao'];

		//大小
		$json['db'][$i]['Match_DxDpl'] = $rows['Match_DxDpl'];
		$json['db'][$i]['Match_DxXpl'] = $rows['Match_DxXpl'];
		$json['db'][$i]['Match_DxGG1'] = 'O' . $rows['Match_DxGG'];
		$json['db'][$i]['Match_DxGG2'] = 'U' . $rows['Match_DxGG'];

		//单双
		$json['db'][$i]['Match_DsDpl'] = $rows['Match_DsDpl'];			
		$json['db'][$i]['Match_DsSpl'] = $rows['Match_DsSpl'];
		
		//球员局数大小
		$json['db'][$i]['Match_DFzDX'] = 'O' . $rows['Match_DFzDX'];
		$json['db'][$i]['Match_DFzDpl'] = $rows['Match_DFzDpl'];
		$json['db'][$i]['Match_DFzDX2'] = 'U' . $rows['Match_DFzDX'];
		$json['db'][$i]['Match_DFzXpl'] = $rows['Match_DFzXpl'];
		
		$json['db'][$i]['Match_DFkDX'] = 'O' . $rows['Match_DFkDX'];
		$json['db'][$i]['Match_DFkDpl'] = $rows['Match_DFkDpl'];
		$json['db'][$i]['Match_DFkDX2'] = 'U' . $rows['Match_DFkDX'];
		$json['db'][$i]['Match_DFkXpl'] = $rows['Match_DFkXpl'];
		$i++;
	}
	$json['ids'] = rtrim($ids,',');
}else{
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
	$ids = "";
	$sql = 'select id from mydata4_db.tennis_Match WHERE Match_Type=1 and Match_CoverDate>now() AND Match_Date=\''.date('m-d').'\' ' . $sqlwhere . ' order by '.$esc;
	$stmt = $mydata1_db->query($sql);
	while ($row = $stmt->fetch()){
		$ids.=$row['id'].',';
		if (($start <= $i) && ($i <= $end))	{
			$id = intval($row['id']) . ',' . $id;
		}
		$i++;
	}

	if ($i == 1){
		$json['dh'] = 0;
		$json['fy']['p_page'] = 0;
		$json['ids'] = "";
	}else{
		$id = rtrim($id, ',');
		$json['ids'] = rtrim($ids, ',');
		$json['fy']['p_page'] = ceil($i / $bk);
		$json['fy']['page'] = $this_page - 1;
		$params = array(':Match_Date' => date('m-d'));

		$sql = 'select match_name from mydata4_db.tennis_Match WHERE Match_Type=1 and Match_CoverDate>now() AND Match_Date=:Match_Date group by match_name';
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
		$sql = 'select id,Match_ID, Match_Date, Match_Time, Match_Master, Match_Guest, Match_RGG, Match_Name, Match_IsLose, Match_BzM, Match_BzG,  Match_DxDpl, Match_DxXpl, Match_DxGG, Match_Ho, Match_Ao, Match_MasterID, Match_GuestID, Match_Type, Match_DsDpl, Match_DsSpl,Match_ShowType,Match_isMaster,Match_best,Match_DFzDX,Match_DFzDpl,Match_DFzXpl,Match_DFkDX,Match_DFkDpl,Match_DFkXpl from mydata4_db.tennis_Match where id in(' . $id . ') order by '.$esc;
		$query = $mydata1_db->query($sql);
		$i = 0;
		while ($rows = $query->fetch()){
			$json['db'][$i]['ID'] = $rows['id'];
			$json['db'][$i]['Match_ID'] = $rows['Match_ID'];

			$json['db'][$i]['Match_Name'] = $rows['Match_Name'];

			$json['db'][$i]['Match_Master'] = $rows['Match_Master'];
			$json['db'][$i]['Match_Guest'] = $rows['Match_Guest'];
			$json['db'][$i]['Match_MasterID'] = $rows['Match_MasterID'];
			$json['db'][$i]['Match_GuestID'] = $rows['Match_GuestID'];
			

			$json['db'][$i]['Match_IsLose'] = $rows['Match_IsLose'];
			$json['db'][$i]['Match_Date'] = $rows['Match_Date'];
			$json['db'][$i]['Match_Time'] = $rows['Match_Time'];

			$json['db'][$i]['Match_isMaster'] = $rows['Match_isMaster'];
			$json['db'][$i]['Match_best'] = $rows['Match_best'];

			//独赢
			$json['db'][$i]['Match_BzM'] = $rows['Match_BzM'];
			$json['db'][$i]['Match_BzG'] = $rows['Match_BzG'];

			//让盘
			$json['db'][$i]['Match_ShowType'] = $rows['Match_ShowType'];
			$json['db'][$i]['Match_RGG'] = $rows['Match_RGG'];
			$json['db'][$i]['Match_Ho'] = $rows['Match_Ho'];
			$json['db'][$i]['Match_Ao'] = $rows['Match_Ao'];

			//大小
			$json['db'][$i]['Match_DxDpl'] = $rows['Match_DxDpl'];
			$json['db'][$i]['Match_DxXpl'] = $rows['Match_DxXpl'];
			$json['db'][$i]['Match_DxGG1'] = 'O' . $rows['Match_DxGG'];
			$json['db'][$i]['Match_DxGG2'] = 'U' . $rows['Match_DxGG'];

			//单双
			$json['db'][$i]['Match_DsDpl'] = $rows['Match_DsDpl'];			
			$json['db'][$i]['Match_DsSpl'] = $rows['Match_DsSpl'];
			
			//球员局数大小
			$json['db'][$i]['Match_DFzDX'] = 'O' . $rows['Match_DFzDX'];
			$json['db'][$i]['Match_DFzDpl'] = $rows['Match_DFzDpl'];
			$json['db'][$i]['Match_DFzDX2'] = 'U' . $rows['Match_DFzDX'];
			$json['db'][$i]['Match_DFzXpl'] = $rows['Match_DFzXpl'];
			
			$json['db'][$i]['Match_DFkDX'] = 'O' . $rows['Match_DFkDX'];
			$json['db'][$i]['Match_DFkDpl'] = $rows['Match_DFkDpl'];
			$json['db'][$i]['Match_DFkDX2'] = 'U' . $rows['Match_DFkDX'];
			$json['db'][$i]['Match_DFkXpl'] = $rows['Match_DFkXpl'];
			$i++;
		}
	}
}
echo $callback."(".json_encode($json).");";