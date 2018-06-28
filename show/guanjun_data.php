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
$bk = 1000;
$sqlwhere = '';
$id = '';
$i = 1;
$start = (($this_page - 1) * $bk) + 1;
$end = $this_page * $bk;
$params = array();
if (@($_GET['leaguename']) != ''){
	$leaguename = explode('$', urldecode($_GET['leaguename']));
	$v = (1 < count($leaguename) ? 'and (' : 'and');
	$params[':x_title'] = $leaguename[0];
	$sqlwhere .= ' ' . $v . ' x_title=:x_title';
	
	for ($is = 1;$is < (count($leaguename) - 1);$is++){
		$params[':x_title_' . $is] = $leaguename[$is];
		$sqlwhere .= ' or x_title=:x_title_' . $is;
	}
	$sqlwhere .= (1 < count($leaguename) ? ')' : '');
}
$sql = 'select x_id from mydata4_db.t_guanjun where match_type=1 and match_coverdate>now() and x_result is null '. $sqlwhere . ' order by  match_coverdate,match_name,x_id';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
while ($row = $stmt->fetch()){
	if (($start <= $i) && ($i <= $end)){
		$id = intval($row['x_id']) . ',' . $id;
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
	$sql = 'select x_title from mydata4_db.t_guanjun where match_type=1 and match_coverdate>now() and x_result is null group by x_title';
	$query = $mydata1_db->query($sql);
	$i = 0;
	$lsm = '';
	while ($row = $query->fetch()){
		$lsm .= urlencode($row['x_title']) . '|';
		$i++;
	}

	$json['lsm'] = rtrim($lsm, '|');
	$json['dh'] = ceil($i / 3) * 30;
	$sql = 'SELECT match_id, x_title, x_id, match_name, match_date, match_time FROM mydata4_db.t_guanjun where x_id in(' . $id . ') order by match_coverdate,match_name,x_id';
	$query = $mydata1_db->query($sql);
	$i = 0;
	while ($rows = $query->fetch()){
		$tid = '';
		$team_name = '';
		$point = '';
		$match_id = '';
		$x_id = intval($rows['x_id']);
		$sql = 'select tid, team_name, point, match_id from mydata4_db.t_guanjun_team where xid=\'' . $x_id . '\' order by tid desc';
		$query1 = $mydata1_db->query($sql);
		while ($ttrs = $query1->fetch()){
			$tid .= $ttrs['tid'] . ',';
			$team_name .= $ttrs['team_name'] . ',';
			$point .= $ttrs['point'] . ',';
			$match_id .= $ttrs['match_id'] . ',';
		}
		$json['db'][$i]['Match_ID'] = $rows['match_id'];
		$json['db'][$i]['x_title'] = $rows['x_title'];
		$json['db'][$i]['x_id'] = $rows['x_id'];
		$json['db'][$i]['Match_Name'] = $rows['match_name'];
		$json['db'][$i]['Match_Date'] = $rows['match_date'] . ' ' . $rows['match_time'];
		$json['db'][$i]['team_name'] = $team_name;
		$json['db'][$i]['point'] = $point;
		$json['db'][$i]['tid'] = $tid;
		$i++;
	}
}

echo $callback."(".json_encode($json).");";