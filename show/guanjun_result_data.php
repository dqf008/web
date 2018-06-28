<?php 
header('Content-type: text/json;charset=utf-8');
include_once '../include/pd_user_json.php';
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/function.php';
$bk = 500;
$p_page = '';
$sqlwhere = '';
$dstart = date('Y-m-d') . ' 00:00:00';
$dend = date('Y-m-d') . ' 23:59:59';
$sql = 'select x_id,x_title from mydata4_db.t_guanjun where match_type=1 and x_result is null ';
if (@($_GET['leaguename']) != '')
{
	$dstart = $_GET['leaguename'] . ' 00:00:00';
	$dend = $_GET['leaguename'] . ' 23:59:59';
	$json['timename'] = $_GET['leaguename'];
	if ($_GET['leaguename'] < date('Y-m-d'))
	{
		$json['tday'][0] = date('Y-m-d', strtotime($_GET['leaguename']) - 86400);
		$json['tday'][1] = date('Y-m-d', strtotime($_GET['leaguename']) + 86400);
	}
	else
	{
		$json['leaguename'] = date('Y-m-d', time() - 86400);
		$json['tday'][0] = 'no';
	}
}
$params = array(':dstart' => $dstart, ':dend' => $dend);
$sqlwhere = ' and (match_coverdate >=:dstart and match_coverdate <=:dend)';
$group = ' group by match_name';
$stmt = $mydata1_db->prepare($sql . $sqlwhere);
$stmt->execute($params);
$count_num = $stmt->rowCount();
$stmt = $mydata1_db->prepare($sql . $group);
$stmt->execute($params);
$i = 1;
while ($i <= $count_num){
	$p_page++;
	$i += $bk;
}

if ($count_num == '0'){
	$json['fy']['p_page'] = 0;
}else{
	$json['fy']['p_page'] = $p_page;
	while ($t = $stmt->fetch()){
		$x .= $t['x_title'] . '$' . urlencode($t['x_title']) . '|';
	}
	$json['dh'] = $x;
	$sql = 'SELECT tg.*,GROUP_CONCAT(tt.tid order by tid) as tid,GROUP_CONCAT(tt.team_name order by tid) as team_name,GROUP_CONCAT(tt.point order by tid) as point,GROUP_CONCAT(tt.match_id order by tid) as mid FROM mydata4_db.t_guanjun tg,mydata4_db.t_guanjun_team tt';
	$sqlwhere = ' where tg.match_type=1 and tg.x_id=tt.xid and x_result is null ';
	$sqlorder = ' group by tg.match_name order by tg.match_coverdate,tg.match_name,tg.x_id';
	if ($_GET['leaguename'] != ''){
		$dstart = $_GET['leaguename'] . ' 00:00:00';
		$dend = $_GET['leaguename'] . ' 23:59:59';
	}
	$params = array(':dstart' => @($dstart), ':dend' => @($dend));
	$sqlwhere .= ' and (tg.match_coverdate >=:dstart and tg.match_coverdate <=:dend)';
	$sql = $sql . $sqlwhere . $sqlorder;
	$pre_count = $bk;
	0 < intval(@($_GET['CurrPage'])) ? $this_page = @($_GET['CurrPage']) : $this_page = 0;
	0 < intval(@($_GET['CurrPage'])) ? $json['fy']['page'] = @($_GET['CurrPage']) : $json['fy']['page'] = 0;
	$this_page = intval($this_page);
	$pre_count = intval($pre_count);
	$sql .= ' limit ' . ($this_page * $pre_count) . ',' . $pre_count . '';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$i = 0;
	while ($rows = $stmt->fetch())	{
		$json['db'][$i]['Match_ID'] = $rows['match_id'];
		$json['db'][$i]['x_title'] = $rows['x_title'];
		$json['db'][$i]['x_id'] = $rows['x_id'];
		$json['db'][$i]['Match_Name'] = $rows['match_name'];
		$json['db'][$i]['Match_Date'] = $rows['match_date'] . ' ' . $rows['match_time'];
		$json['db'][$i]['x_result'] = $rows['x_result'];
		$json['db'][$i]['team_name'] = $rows['team_name'];
		$json['db'][$i]['tid'] = $rows['tid'];
		$i++;
	}
}
 echo $callback.'('.json_encode($json).')';