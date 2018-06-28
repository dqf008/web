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

	$sql = 'select match_name from mydata4_db.baseball_match WHERE id in(' . $id . ')  and Match_Date=\''.date('m-d').'\' and  Match_Type=1 AND Match_CoverDate>now() '.$sqlwhere.' group by match_name';
	$stmt = $mydata1_db->query($sql);
	$i = 0;
	$lsm = '';
	while ($row = $stmt->fetch()){
		$lsm .= urlencode($row['match_name']) . '|';
		$i++;
	}

	$json['lsm'] = rtrim($lsm, '|');
	$json['dh'] = ceil($i / 3) * 30;

	$sql = 'SELECT ID, Match_ID, Match_Date, Match_Time, Match_Master, Match_Guest, Match_RGG,Match_BzM,Match_BzG,Match_BzH, Match_Name, Match_IsLose, Match_DxDpl, Match_DxXpl, Match_DxGG, Match_Ho, Match_Ao, Match_Type, Match_DsDpl, Match_DsSpl,Match_MasterID,Match_GuestID, Match_ShowType,Match_Bmdy,Match_Bgdy,Match_Bhdy,Match_BHo,Match_BAo,Match_BRpk,Match_Hr_ShowType,Match_Bdpl,Match_Bxpl,Match_Bdxpk,Match_isMaster FROM mydata4_db.baseball_match where id in(' . $id . ') and Match_Date=\''.date('m-d').'\' and  Match_Type=1 AND Match_CoverDate>now() order by '.$esc;
	$query = $mydata1_db->query($sql);
	$i = 0;
	$ids = "";
	while ($rows = $query->fetch()){
		$json['db'][$i]['ID'] = $rows['ID'];
		$ids .= $rows['ID'].',';
		$json['db'][$i]['Match_ID'] = $rows['Match_ID'];
			
		$json['db'][$i]['Match_Date'] = $rows['Match_Date'];
		$json['db'][$i]['Match_Time'] = $rows['Match_Time'];

		$json['db'][$i]['Match_Type'] = $rows['Match_Type'];

		$json['db'][$i]['Match_IsLose'] = $rows['Match_IsLose'];
		$json['db'][$i]['Match_isMaster'] = $rows['Match_isMaster'];

		$json['db'][$i]['Match_Name'] = $rows['Match_Name'];
		$json['db'][$i]['Match_Master'] = $rows['Match_Master'];
		$json['db'][$i]['Match_Guest'] = $rows['Match_Guest'];
		$json['db'][$i]['Match_MasterID'] = $rows['Match_MasterID'];
		$json['db'][$i]['Match_GuestID'] = $rows['Match_GuestID'];

		//独赢
		$json['db'][$i]['Match_BzM'] = $rows['Match_BzM'];
		$json['db'][$i]['Match_BzG'] = $rows['Match_BzG'];
		$json['db'][$i]['Match_BzH'] = $rows['Match_BzH'];

		//让球
		$json['db'][$i]['Match_RGG'] = $rows['Match_RGG'];
		$json['db'][$i]['Match_ShowType'] = $rows['Match_ShowType'];
		$json['db'][$i]['Match_Ho'] = $rows['Match_Ho'];
		$json['db'][$i]['Match_Ao'] = $rows['Match_Ao'];

		//大小
		$json['db'][$i]['Match_DxXpl'] = $rows['Match_DxXpl'];
		$json['db'][$i]['Match_DxDpl'] = $rows['Match_DxDpl'];
		$json['db'][$i]['Match_DxGG'] = $rows['Match_DxGG'];
		$rows['Match_DxGG'] != '' ? $m = 'O' . $rows['Match_DxGG'] : $m = 0;
		$json['db'][$i]['Match_DxGG1'] = $m;
		$rows['Match_DxGG'] != '' ? $n = 'U' . $rows['Match_DxGG'] : $n = 0;
		$json['db'][$i]['Match_DxGG2'] = $n;
		
		//单双
		$json['db'][$i]['Match_DsDpl'] = $rows['Match_DsDpl'];
		$json['db'][$i]['Match_DsSpl'] = $rows['Match_DsSpl'];
		
		//-----------------首五局--------------
		//独赢
		$json['db'][$i]['Match_Bmdy'] = $rows['Match_Bmdy'];
		$json['db'][$i]['Match_Bgdy'] = $rows['Match_Bgdy'];
		$json['db'][$i]['Match_Bhdy'] = $rows['Match_Bhdy'];

		//让球
		$json['db'][$i]['Match_BHo'] = $rows['Match_BHo'];
		$json['db'][$i]['Match_BAo'] = $rows['Match_BAo'];
		$json['db'][$i]['Match_BRpk'] = $rows['Match_BRpk'];
		$json['db'][$i]['Match_Hr_ShowType'] = $rows['Match_Hr_ShowType'];

		//大小
		$json['db'][$i]['Match_Bdpl'] = $rows['Match_Bdpl'];
		$json['db'][$i]['Match_Bxpl'] = $rows['Match_Bxpl'];
		$json['db'][$i]['Match_Bdxpk1'] = 'O' . $rows['Match_Bdxpk'];
		$json['db'][$i]['Match_Bdxpk2'] = 'U' . $rows['Match_Bdxpk'];

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
	
	$sql = 'select id from mydata4_db.baseball_match WHERE Match_Type=1 and Match_CoverDate>now() and Match_Date=\''.date('m-d').'\' ' . $sqlwhere . ' order by '.$esc;
	$stmt = $mydata1_db->query($sql);
	while ($row = $stmt->fetch()){
		$ids.=$row['id'].',';
		if (($start <= $i) && ($i <= $end)){
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
		$sql = 'select match_name from mydata4_db.baseball_match WHERE Match_Type=1 and Match_CoverDate>now() and Match_Date=:Match_Date group by match_name';
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
		$sql = 'SELECT ID, Match_ID, Match_Date, Match_Time, Match_Master, Match_Guest, Match_RGG,Match_BzM,Match_BzG,Match_BzH, Match_Name, Match_IsLose, Match_DxDpl, Match_DxXpl, Match_DxGG, Match_Ho, Match_Ao, Match_Type, Match_DsDpl, Match_DsSpl,Match_MasterID,Match_GuestID,Match_ShowType,Match_Bmdy,Match_Bgdy,Match_Bhdy,Match_BHo,Match_BAo,Match_BRpk,Match_Hr_ShowType,Match_Bdpl,Match_Bxpl,Match_Bdxpk,Match_isMaster FROM mydata4_db.baseball_match where id in(' . $id . ') order by '.$esc;
		$query = $mydata1_db->query($sql);
		$i = 0;
		while ($rows = $query->fetch()){
			$json['db'][$i]['ID'] = $rows['ID'];
			$json['db'][$i]['Match_ID'] = $rows['Match_ID'];
			
			$json['db'][$i]['Match_Date'] = $rows['Match_Date'];
			$json['db'][$i]['Match_Time'] = $rows['Match_Time'];

			$json['db'][$i]['Match_Type'] = $rows['Match_Type'];

			$json['db'][$i]['Match_IsLose'] = $rows['Match_IsLose'];
			$json['db'][$i]['Match_isMaster'] = $rows['Match_isMaster'];

			$json['db'][$i]['Match_Name'] = $rows['Match_Name'];
			$json['db'][$i]['Match_Master'] = $rows['Match_Master'];
			$json['db'][$i]['Match_Guest'] = $rows['Match_Guest'];
			$json['db'][$i]['Match_MasterID'] = $rows['Match_MasterID'];
			$json['db'][$i]['Match_GuestID'] = $rows['Match_GuestID'];

			//独赢
			$json['db'][$i]['Match_BzM'] = $rows['Match_BzM'];
			$json['db'][$i]['Match_BzG'] = $rows['Match_BzG'];
			$json['db'][$i]['Match_BzH'] = $rows['Match_BzH'];

			//让球
			$json['db'][$i]['Match_RGG'] = $rows['Match_RGG'];
			$json['db'][$i]['Match_ShowType'] = $rows['Match_ShowType'];
			$json['db'][$i]['Match_Ho'] = $rows['Match_Ho'];
			$json['db'][$i]['Match_Ao'] = $rows['Match_Ao'];

			//大小
			$json['db'][$i]['Match_DxXpl'] = $rows['Match_DxXpl'];
			$json['db'][$i]['Match_DxDpl'] = $rows['Match_DxDpl'];
			$json['db'][$i]['Match_DxGG'] = $rows['Match_DxGG'];
			$rows['Match_DxGG'] != '' ? $m = 'O' . $rows['Match_DxGG'] : $m = 0;
			$json['db'][$i]['Match_DxGG1'] = $m;
			$rows['Match_DxGG'] != '' ? $n = 'U' . $rows['Match_DxGG'] : $n = 0;
			$json['db'][$i]['Match_DxGG2'] = $n;
			
			//单双
			$json['db'][$i]['Match_DsDpl'] = $rows['Match_DsDpl'];
			$json['db'][$i]['Match_DsSpl'] = $rows['Match_DsSpl'];
			
			//-----------------首五局--------------
			//独赢
			$json['db'][$i]['Match_Bmdy'] = $rows['Match_Bmdy'];
			$json['db'][$i]['Match_Bgdy'] = $rows['Match_Bgdy'];
			$json['db'][$i]['Match_Bhdy'] = $rows['Match_Bhdy'];

			//让球
			$json['db'][$i]['Match_BHo'] = $rows['Match_BHo'];
			$json['db'][$i]['Match_BAo'] = $rows['Match_BAo'];
			$json['db'][$i]['Match_BRpk'] = $rows['Match_BRpk'];
			$json['db'][$i]['Match_Hr_ShowType'] = $rows['Match_Hr_ShowType'];

			//大小
			$json['db'][$i]['Match_Bdpl'] = $rows['Match_Bdpl'];
			$json['db'][$i]['Match_Bxpl'] = $rows['Match_Bxpl'];
			$json['db'][$i]['Match_Bdxpk1'] = 'O' . $rows['Match_Bdxpk'];
			$json['db'][$i]['Match_Bdxpk2'] = 'U' . $rows['Match_Bdxpk'];
			
			
			
			$i++;
		}
	}
}

echo $callback."(".json_encode($json).");";