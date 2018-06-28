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

//赛事收藏
if (trim($_GET['ids']) != ''){
	$id = $_GET['ids'];
	$json['fy']['p_page'] = 0;
	$json['fy']['page'] = 0;

	$sql = 'select match_name from mydata4_db.bet_match WHERE id in(' . $id . ')  and   Match_Type=0 AND Match_CoverDate>now()  '.$sqlwhere.' group by match_name';
	$stmt = $mydata1_db->query($sql);
	$i = 0;
	$lsm = '';
	while ($row = $stmt->fetch()){
		$lsm .= urlencode($row['match_name']) . '|';
		$i++;
	}

	$json['lsm'] = rtrim($lsm, '|');
	$json['dh'] = ceil($i / 3) * 30;

	$sql = 'SELECT id,Match_ID, Match_HalfId, Match_Date, Match_Time, Match_Master, Match_Guest, Match_RGG, Match_Name, Match_IsLose, Match_BzM, Match_BzG, Match_BzH, Match_DxDpl, Match_DxXpl, Match_DxGG, Match_Ho, Match_Ao, Match_MasterID, Match_GuestID,Match_CoverDate, Match_ShowType, Match_Type, Match_DsDpl, Match_DsSpl,Match_Bmdy, Match_BHo,  Match_Bdpl, Match_Bgdy, Match_BAo, Match_Bxpl, Match_Bhdy, Match_BRpk, Match_Hr_ShowType, Match_Bdxpk FROM mydata4_db.Bet_Match where id in(' . $id . ')  and  Match_Type=0 AND Match_CoverDate>now() and Match_HalfId is not null order by '.$esc;
	$query = $mydata1_db->query($sql);
	$i = 0;
	$ids = "";
	while ($rows = $query->fetch()){
		$json['db'][$i]['ID'] = $rows['id'];
		$ids .= $rows['id'].',';
		$json['db'][$i]['Match_ID'] = $rows['Match_ID'];
		$json['db'][$i]['Match_Master'] = strip_tags($rows['Match_Master']);
		$json['db'][$i]['Match_Guest'] = strip_tags($rows['Match_Guest']);
		$json['db'][$i]['Match_MasterID'] = $rows['Match_MasterID'];
		$json['db'][$i]['Match_GuestID'] = $rows['Match_GuestID'];
		$json['db'][$i]['Match_Name'] = $rows['Match_Name'];
		$json['db'][$i]['Match_CoverDate'] = $rows['Match_CoverDate'];
		$json['db'][$i]['Match_IsLose'] = $rows['Match_IsLose'];
		$json['db'][$i]['Match_Date'] = $rows['Match_Date'];
		$json['db'][$i]['Match_Time'] = $rows['Match_Time'];
		$rows['Match_BzM'] != '' ? $a = $rows['Match_BzM'] : $a = 0;
		$json['db'][$i]['Match_BzM'] = $a;
		double_format($rows['Match_Ho']) != '' ? $b = double_format($rows['Match_Ho']) : $b = 0;
		$json['db'][$i]['Match_Ho'] = $b;
		$rows['Match_DxDpl'] != '' ? $c = $rows['Match_DxDpl'] : $c = 0;
		$json['db'][$i]['Match_DxDpl'] = $c;
		$rows['Match_DsDpl'] != '' ? $d = $rows['Match_DsDpl'] : $d = 0;
		$json['db'][$i]['Match_DsDpl'] = $d;
		$rows['Match_BzG'] != '' ? $e = $rows['Match_BzG'] : $e = 0;
		$json['db'][$i]['Match_BzG'] = $e;
		$rows['Match_Ao'] != '' ? $f = $rows['Match_Ao'] : $f = 0;
		$json['db'][$i]['Match_Ao'] = $f;
		$rows['Match_DxXpl'] != '' ? $g = $rows['Match_DxXpl'] : $g = 0;
		$json['db'][$i]['Match_DxXpl'] = $g;
		$rows['Match_DsSpl'] != '' ? $h = $rows['Match_DsSpl'] : $h = 0;
		$json['db'][$i]['Match_DsSpl'] = $h;
		$rows['Match_BzH'] != '' ? $k = $rows['Match_BzH'] : $k = 0;
		$json['db'][$i]['Match_BzH'] = $k;
		$rows['Match_RGG'] != '' ? $j = $rows['Match_RGG'] : $j = 0;
		$json['db'][$i]['Match_RGG'] = $j;
		$rows['Match_DxGG'] != '' ? $m = 'O' . $rows['Match_DxGG'] : $m = 0;
		$json['db'][$i]['Match_DxGG1'] = $m;
		$json['db'][$i]['Match_ShowType'] = $rows['Match_ShowType'];
		$rows['Match_DxGG'] != '' ? $n = 'U' . $rows['Match_DxGG'] : $n = 0;
		$json['db'][$i]['Match_DxGG2'] = $n;

		//上半场
		$json['db'][$i]['Match_Bmdy'] = $rows['Match_Bmdy'];
		$json['db'][$i]['Match_BHo'] = $rows['Match_BHo'];
		$json['db'][$i]['Match_Bdpl'] = $rows['Match_Bdpl'];
		$json['db'][$i]['Match_Bgdy'] = $rows['Match_Bgdy'];
		$json['db'][$i]['Match_BAo'] = $rows['Match_BAo'];
		$json['db'][$i]['Match_Bxpl'] = $rows['Match_Bxpl'];
		$json['db'][$i]['Match_Bhdy'] = $rows['Match_Bhdy'];
		$json['db'][$i]['Match_BRpk'] = $rows['Match_BRpk'];
		$json['db'][$i]['Match_Bdxpk1'] = 'O' . $rows['Match_Bdxpk'];
		$json['db'][$i]['Match_Hr_ShowType'] = $rows['Match_Hr_ShowType'];
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
	$sql = 'select id from mydata4_db.bet_match WHERE Match_Type=0 and Match_HalfId is not null AND Match_CoverDate>now()  ' . $sqlwhere . ' order by '.$esc;
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
		
		$sql = 'select match_name from mydata4_db.bet_match WHERE Match_Type=0 AND Match_CoverDate>now() '.$sqlwhere.'  group by match_name';
		$stmt = $mydata1_db->query($sql);
		$i = 0;
		$lsm = '';
		while ($row = $stmt->fetch()){
			$lsm .= urlencode($row['match_name']) . '|';
			$i++;
		}

		$json['lsm'] = rtrim($lsm, '|');
		$json['dh'] = ceil($i / 3) * 30;
		$sql = 'SELECT id,Match_ID, Match_HalfId, Match_Date, Match_Time, Match_Master, Match_Guest, Match_RGG, Match_Name, Match_IsLose, Match_BzM, Match_BzG, Match_BzH, Match_DxDpl, Match_DxXpl, Match_DxGG, Match_Ho, Match_Ao, Match_MasterID, Match_GuestID,Match_CoverDate, Match_ShowType, Match_Type, Match_DsDpl, Match_DsSpl,Match_Bmdy, Match_BHo,  Match_Bdpl, Match_Bgdy, Match_BAo, Match_Bxpl, Match_Bhdy, Match_BRpk, Match_Hr_ShowType, Match_Bdxpk FROM mydata4_db.Bet_Match where id in(' . $id . ') order by '.$esc;
		$query = $mydata1_db->query($sql);
		$i = 0;

		while ($rows = $query->fetch()){
			$json['db'][$i]['ID'] = $rows['id'];
			$json['db'][$i]['Match_ID'] = $rows['Match_ID'];
			$json['db'][$i]['Match_Master'] = strip_tags($rows['Match_Master']);
			$json['db'][$i]['Match_Guest'] = strip_tags($rows['Match_Guest']);
			$json['db'][$i]['Match_MasterID'] = $rows['Match_MasterID'];
			$json['db'][$i]['Match_GuestID'] = $rows['Match_GuestID'];
			$json['db'][$i]['Match_Name'] = $rows['Match_Name'];
			$json['db'][$i]['Match_CoverDate'] = $rows['Match_CoverDate'];
			$json['db'][$i]['Match_IsLose'] = $rows['Match_IsLose'];
			$json['db'][$i]['Match_Date'] = $rows['Match_Date'];
			$json['db'][$i]['Match_Time'] = $rows['Match_Time'];
			$rows['Match_BzM'] != '' ? $a = $rows['Match_BzM'] : $a = 0;
			$json['db'][$i]['Match_BzM'] = $a;
			double_format($rows['Match_Ho']) != '' ? $b = double_format($rows['Match_Ho']) : $b = 0;
			$json['db'][$i]['Match_Ho'] = $b;
			$rows['Match_DxDpl'] != '' ? $c = $rows['Match_DxDpl'] : $c = 0;
			$json['db'][$i]['Match_DxDpl'] = $c;
			$rows['Match_DsDpl'] != '' ? $d = $rows['Match_DsDpl'] : $d = 0;
			$json['db'][$i]['Match_DsDpl'] = $d;
			$rows['Match_BzG'] != '' ? $e = $rows['Match_BzG'] : $e = 0;
			$json['db'][$i]['Match_BzG'] = $e;
			$rows['Match_Ao'] != '' ? $f = $rows['Match_Ao'] : $f = 0;
			$json['db'][$i]['Match_Ao'] = $f;
			$rows['Match_DxXpl'] != '' ? $g = $rows['Match_DxXpl'] : $g = 0;
			$json['db'][$i]['Match_DxXpl'] = $g;
			$rows['Match_DsSpl'] != '' ? $h = $rows['Match_DsSpl'] : $h = 0;
			$json['db'][$i]['Match_DsSpl'] = $h;
			$rows['Match_BzH'] != '' ? $k = $rows['Match_BzH'] : $k = 0;
			$json['db'][$i]['Match_BzH'] = $k;
			$rows['Match_RGG'] != '' ? $j = $rows['Match_RGG'] : $j = 0;
			$json['db'][$i]['Match_RGG'] = $j;
			$rows['Match_DxGG'] != '' ? $m = 'O' . $rows['Match_DxGG'] : $m = 0;
			$json['db'][$i]['Match_DxGG1'] = $m;
			$json['db'][$i]['Match_ShowType'] = $rows['Match_ShowType'];
			$rows['Match_DxGG'] != '' ? $n = 'U' . $rows['Match_DxGG'] : $n = 0;
			$json['db'][$i]['Match_DxGG2'] = $n;

			//上半场
			$json['db'][$i]['Match_Bmdy'] = $rows['Match_Bmdy'];
			$json['db'][$i]['Match_BHo'] = $rows['Match_BHo'];
			$json['db'][$i]['Match_Bdpl'] = $rows['Match_Bdpl'];
			$json['db'][$i]['Match_Bgdy'] = $rows['Match_Bgdy'];
			$json['db'][$i]['Match_BAo'] = $rows['Match_BAo'];
			$json['db'][$i]['Match_Bxpl'] = $rows['Match_Bxpl'];
			$json['db'][$i]['Match_Bhdy'] = $rows['Match_Bhdy'];
			$json['db'][$i]['Match_BRpk'] = $rows['Match_BRpk'];
			$json['db'][$i]['Match_Bdxpk1'] = 'O' . $rows['Match_Bdxpk'];
			$json['db'][$i]['Match_Hr_ShowType'] = $rows['Match_Hr_ShowType'];
			$json['db'][$i]['Match_Bdxpk2'] = 'U' . $rows['Match_Bdxpk'];

			$i++;
		}

		
	}
}
echo $callback."(".json_encode($json).");";