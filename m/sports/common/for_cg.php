<?php 
session_start();
include_once '../../../include/config.php';
website_close();
website_deny();
include_once '../../../database/mysql.config.php';
include_once '../../../common/logintu.php';
include_once '../../../common/function.php';
include_once '../../../common/login_check.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$sum = count($_POST['match_id']);
$cg_for_message = array();

for ($i = 0;$i < $sum;$i++){
	$cg_for_message[$i]['ball_sort'] = $_POST['ball_sort'][$i];
	$cg_for_message[$i]['point_column'] = $_POST['point_column'][$i];
	$cg_for_message[$i]['match_name'] = $_POST['match_name'][$i];
	$cg_for_message[$i]['master_guest'] = $_POST['master_guest'][$i];
	$cg_for_message[$i]['match_id'] = $_POST['match_id'][$i];
	$cg_for_message[$i]['tid'] = $_POST['tid'][$i];
	$cg_for_message[$i]['bet_info'] = $_POST['bet_info'][$i];
	$cg_for_message[$i]['touzhuxiang'] = $_POST['touzhuxiang'][$i];
	$cg_for_message[$i]['match_showtype'] = $_POST['match_showtype'][$i];
	$cg_for_message[$i]['match_rgg'] = $_POST['match_rgg'][$i];
	$cg_for_message[$i]['match_dxgg'] = $_POST['match_dxgg'][$i];
	$cg_for_message[$i]['match_nowscore'] = $_POST['match_nowscore'][$i];
	$cg_for_message[$i]['bet_point'] = $_POST['bet_point'][$i];
	$cg_for_message[$i]['match_type'] = $_POST['match_type'][$i];
	$cg_for_message[$i]['ben_add'] = $_POST['ben_add'][$i];
	$cg_for_message[$i]['match_time'] = $_POST['match_time'][$i];
	$cg_for_message[$i]['match_endtime'] = $_POST['match_endtime'][$i];
	$cg_for_message[$i]['Match_HRedCard'] = $_POST['Match_HRedCard'][$i];
	$cg_for_message[$i]['Match_GRedCard'] = $_POST['Match_GRedCard'][$i];
	$cg_for_message[$i]['orderkey'] = $_POST['orderkey'][$i];
	$cg_for_message[$i]['is_lose'] = $_POST['is_lose'][$i];
}
$_SESSION['cg_for_message'] = $cg_for_message;
echo 'ok';
?>