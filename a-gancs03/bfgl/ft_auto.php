<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('bfgl');
include_once '../../class/bet.php';
$mid = $_POST['match_id'];
$arr_mid = explode(',', $mid);

for ($i = 0;$i < count($arr_mid);$i++){
	$arr_mid[$i] = floatval($arr_mid[$i]);
}

$mid = implode(',', $arr_mid);
$bool = true;
if (0 < count($_POST['bid'])){
	foreach ($_POST['bid'] as $i => $bid){
		$status = intval($_POST['status'][$i]);
		$mb_inball = $_POST['mb_inball'][$i];
		$tg_inball = $_POST['tg_inball'][$i];
		$bool = bet::set($bid, $status, $mb_inball, $tg_inball);
		if (!$bool){
			break;
		}
	}
}

if ($bool){
	if (0 < count($_POST['bid_cg'])){
		foreach ($_POST['bid_cg'] as $i => $bid){
			$status = intval($_POST['status_cg'][$i]);
			$mb_inball = $_POST['mb_inball_cg'][$i];
			$tg_inball = $_POST['tg_inball_cg'][$i];
			$bool = bet::set_cg($bid, $status, $mb_inball, $tg_inball);
			if (!$bool){
				break;
			}
		}
	}
}

$php = ($_GET['php'] ? $_GET['php'] : 'zqbf');
if ($bool){
	$table = ($_GET['type'] ? $_GET['type'] : 'bet_match');
	$set = ($table == 'bet_match' ? ',match_sbjs=1' : '');
	$arr_table = array('baseball_match', 'bet_match', 'lq_match', 't_guanjun_team', 'tennis_match', 'volleyball_match');
	if (!in_array($table, $arr_table))
	{
		message('数据[表]查询失败，交易失败', $php . '.php');
	}
	$mydata1_db->query('update mydata4_db.' . $table . ' set match_js=\'1\'' . $set . ' where match_id in(' . $mid . ')');
	include_once '../../class/admin.php';
	admin::insert_log($_SESSION['adminid'], '批量审核了足球赛事' . $mid . '注单');
}
message('本次结算完成', $php . '.php');
?>
