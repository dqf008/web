<?php
session_start();
include_once 'include/config.php';
website_close();
website_deny();
include_once 'database/mysql.config.php';
include_once 'common/logintu.php';
include_once 'common/function.php';
include_once 'common/login_check.php';

if($web_site['hg']==1){
	go('皇冠体育维护中，如有疑问请联系在线客服。');
	exit;
}

$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
include_once 'ajaxleft/postkey.php';
$sum = count($_POST['match_id']);
$is_lose = $_POST['is_lose'];

for ($i = 0;$i < $sum;$i++){
	$ball_sort = $_POST['ball_sort'][$i];
	$column = $_POST['point_column'][$i];
	$match_name = $_POST['match_name'][$i];
	$master_guest = $_POST['master_guest'][$i];
	$match_id = $_POST['match_id'][$i];
	$tid = $_POST['tid'][$i];
	$bet_info = $_POST['bet_info'][$i];
	$touzhuxiang = $_POST['touzhuxiang'][$i];
	$match_showtype = $_POST['match_showtype'][$i];
	$match_rgg = $_POST['match_rgg'][$i];
	$match_dxgg = $_POST['match_dxgg'][$i];
	$match_nowscore = $_POST['match_nowscore'][$i];
	$bet_point = $_POST['bet_point'][$i];
	$match_type = $_POST['match_type'][$i];
	$ben_add = $_POST['ben_add'][$i];
	$match_time = $_POST['match_time'][$i];
	$match_endtime = $_POST['match_endtime'][$i];
	$Match_HRedCard = $_POST['Match_HRedCard'][$i];
	$Match_GRedCard = $_POST['Match_GRedCard'][$i];
	$orderinfo = $ball_sort . $column . $match_name . $master_guest . $match_id . $tid . $bet_info . $touzhuxiang;
	$orderinfo .= $match_showtype . $match_rgg . $match_dxgg . $match_nowscore . $bet_point . $match_type;
	$orderinfo .= $ben_add . $match_time . $match_endtime . $Match_HRedCard . $Match_GRedCard . $is_lose;
	$orderkey = StrToHex($orderinfo, $postkey);
	$postorderkey = $_POST['orderkey'][$i];
	if ($orderkey != $postorderkey){
		//go($orderinfo);
		go('信息被篡改或者水位已变，投注失败，请返回重新投注！');
		exit();
	}
	if($web_site['lqgq4']==1&&$ball_sort=='篮球滚球'&&substr_count($master_guest, '第4节')>=1){
		go('篮球滚球第4节禁止下注！');
		exit();
	}
}

$servername = strtolower($_SERVER['HTTP_HOST']);
$checkfrom = parse_url(array_key_exists('HTTP_REFERER', $_SERVER)?$_SERVER['HTTP_REFERER']:'');
if (!array_key_exists('host', $checkfrom)||strtolower($checkfrom['host']) != $servername){
	$params = array(':uid' => $uid);
	$sql = 'update k_user_login set `is_login`=0 where uid=:uid';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$why = '(1)会员ID：' . $_SESSION['uid'] . '，账户名：' . $_SESSION['username'] . '在 ' . date('Y-m-d H:i:s') . ' 非法访问注单下注页（bet.php）。投注信息：' . $_POST['ball_sort'][0] . ' ' . $_POST['touzhuxiang'][0] . '，投注金额：' . $_POST['bet_money'][0];
	$params = array(':why' => $why, ':uid' => $uid);
	$sql = 'UPDATE k_user set is_stop=1,why=concat_ws(\'，\',why,:why) where uid=:uid';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	unset($_SESSION['uid']);
	unset($_SESSION['gid']);
	unset($_SESSION['username']);
	session_destroy();
	go('非法操作，账号已被停用！');
}

if ($_SESSION['check_action'] !== 'true'){
	$params = array(':uid' => $uid);
	$sql = 'update k_user_login set `is_login`=0 where uid=:uid';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$why = '(2)会员ID：' . $_SESSION['uid'] . '，账户名：' . $_SESSION['username'] . '在 ' . date('Y-m-d H:i:s') . ' 非法访问注单下注页（bet.php）。投注信息：' . $_POST['ball_sort'][0] . ' ' . $_POST['touzhuxiang'][0] . '，投注金额：' . $_POST['bet_money'][0];
	$params = array(':why' => $why, ':uid' => $uid);
	$sql = 'UPDATE k_user set why=concat_ws(\'，\',why,:why) where uid=:uid';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	unset($_SESSION['uid']);
	unset($_SESSION['gid']);
	unset($_SESSION['username']);
	session_destroy();
	go('错误操作，已被系统自动踢线！');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">                                                  
<html xmlns="http://www.w3.org/1999/xhtml">                                                  
<head>                                                  
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />                                                  
<title>投注状态</title>                                                  
<style>
 body{ background-color:#002346;}
</style>                                                 
</head>                                                  
<body leftmargin="4px" rightmargin="0" topmargin="0">
<?php 
$uid = $_SESSION['uid'];
$touzhutype = trim($_POST['touzhutype']);

$bet_point = $_POST['bet_point'][0] * 1;
$bet_money = trim($_POST['bet_money']);
$point_column = $_POST['point_column'][0];
$arr_add = array('Match_Ho', 'Match_Ao', 'Match_DxDpl', 'Match_DxXpl', 'Match_BHo', 'Match_BAo', 'Match_Bdpl', 'Match_Bxpl');
$bet_win = $bet_money * $bet_point;


echo '<font style="display:none">'.investSZ($uid).'</font>';
if (is_numeric($bet_money) && is_int($bet_money * 1)){
	include_once 'cache/group_' . @($_SESSION['gid']) . '.php';
	$bet_money = $bet_money * 1;
	$balance = 0;
	$assets = 0;
	$params = array(':uid' => $uid);
	$sql = 'SELECT money FROM k_user where uid=:uid limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rs = $stmt->fetch();
	if ($rs['money'])	{
		$assets = round($rs['money'], 2);
		$balance = $assets - $bet_money;
	}

	if ($balance < 0){
		go('账户余额不足<br>交易失败');
	}

	$ty_zd = @($pk_db['体育最低']);
	if (0 < $ty_zd){
		$ty_zd = $ty_zd;
	}else{
		$ty_zd = 10;
	}

	if ($bet_money < $ty_zd){
		go('交易金额不能少于 ' . $ty_zd . ' RMB!');
	}

	if ($touzhutype == 0){
		$ball_sort = $_POST['ball_sort'][0];
		$column = $_POST['point_column'][0];
		$match_name = $_POST['match_name'][0];
		$master_guest = $_POST['master_guest'][0];
		$match_id = $_POST['match_id'][0];
		$tid = $_POST['tid'][0];
		$bet_info = $_POST['bet_info'][0];
		$touzhuxiang = $_POST['touzhuxiang'][0];
		$match_showtype = $_POST['match_showtype'][0];
		$match_rgg = $_POST['match_rgg'][0];
		$match_dxgg = $_POST['match_dxgg'][0];
		$match_nowscore = $_POST['match_nowscore'][0];
		$bet_point = $_POST['bet_point'][0];
		$match_type = $_POST['match_type'][0];
		$ben_add = $_POST['ben_add'][0];
		$match_time = $_POST['match_time'][0];
		$match_endtime = $_POST['match_endtime'][0];
		$Match_HRedCard = $Match_GRedCard = 0;

		if ($ben_add == 1){//加本金
			$bet_win += $bet_money;
		}

		if (($ball_sort == '冠军') || ($ball_sort == '金融')){
			$dz = @($dz_db[$ball_sort]);
			$dc = @($dc_db[$ball_sort]);
		}else{
			$dz = @($dz_db[$ball_sort][$touzhuxiang]);
			$dc = @($dc_db[$ball_sort][$touzhuxiang]);
		}

		if (!$dz || ($dz == '')){
			$dz = $dz_db['未定义'];
		}

		if (!$dc || ($dc == '')){
			$dc = $dc_db['未定义'];
		}

		if ($dz < $bet_money){
			go('交易金额多于系统限额');
		}

		$s_t = strftime('%Y-%m-%d', time()) . ' 00:00:00';
		$e_t = strftime('%Y-%m-%d', time()) . ' 23:59:59';
		$params = array(':match_id' => $match_id, ':uid' => $uid, ':s_t' => $s_t, ':e_t' => $e_t);
		$sql = 'select sum(bet_money) as s from `k_bet` where match_id=:match_id and uid=:uid and bet_time>=:s_t and bet_time<=:e_t and `status` not in(3,8) limit 1';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$rs_money = $stmt->fetchColumn();
		if ($dc < ($rs_money + $bet_money)){
			go('交易金额多于系统限额');
		}

		if ((strtotime($match_endtime) < time()) && !strpos($ball_sort, '滚球')){
			go('赛事已结束<br>交易失败');
		}else if (strpos($master_guest, '先开球') && (strtotime($match_endtime) < (time() + 300))){
			go('盘口已关闭<br>交易失败');
		}
		check_point($ball_sort, $column, $match_id, $bet_point, $match_rgg, $match_dxgg, $tid);

		if (($db_table != 'zqgq_match') && ($db_table != 'lqgq_match')){
			if ($db_table != 't_guanjun_team'){
				$params = array(':match_id' => $match_id);
				$chk_sql = 'select match_name,match_type,match_time,Match_CoverDate from mydata4_db.' . $db_table . ' where match_id=:match_id limit 1';
				$stmt = $mydata1_db->prepare($chk_sql);
				$stmt->execute($params);
				$chk_rs = $stmt->fetch();
				if (($chk_rs['match_name'] != $match_name) || ($chk_rs['match_type'] != $match_type) || ($chk_rs['match_time'] != $match_time) || ($chk_rs['Match_CoverDate'] != $match_endtime)){
					$params = array(':uid' => $uid);
					$sql = 'update k_user_login set `is_login`=0 where uid=:uid';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$why = '(3)会员ID：' . $_SESSION['uid'] . '，账户名：' . $_SESSION['username'] . '在 ' . date('Y-m-d H:i:s') . ' 非法访问注单下注页（bet.php）。投注信息：' . $_POST['ball_sort'][0] . ' ' . $_POST['touzhuxiang'][0] . '，投注金额：' . $_POST['bet_money'][0];
					$params = array(':why' => $why, ':uid' => $uid);
					$sql = 'UPDATE k_user set is_stop=1,why=concat_ws(\'，\',why,:why) where uid=:uid';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					unset($_SESSION['uid']);
					unset($_SESSION['gid']);
					unset($_SESSION['username']);
					session_destroy();
					go('非法打水，账号已被停用（1）！');
				}
			}else{
				$params = array(':match_id' => $match_id);
				$chk_sql = 'select Match_CoverDate from mydata4_db.t_guanjun where match_id=:match_id limit 1';
				$stmt = $mydata1_db->prepare($chk_sql);
				$stmt->execute($params);
				$chk_rs = $stmt->fetch();
				if ($chk_rs['Match_CoverDate'] != $match_endtime){
					$params = array(':uid' => $uid);
					$sql = 'update k_user_login set `is_login`=0 where uid=:uid';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$why = '(4)会员ID：' . $_SESSION['uid'] . '，账户名：' . $_SESSION['username'] . '在 ' . date('Y-m-d H:i:s') . ' 非法访问注单下注页（bet.php）。投注信息：' . $_POST['ball_sort'][0] . ' ' . $_POST['touzhuxiang'][0] . '，投注金额：' . $_POST['bet_money'][0];
					$params = array(':why' => $why, ':uid' => $uid);
					$sql = 'UPDATE k_user set is_stop=1,why=concat_ws(\'，\',why,:why) where uid=:uid';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					unset($_SESSION['uid']);
					unset($_SESSION['gid']);
					unset($_SESSION['username']);
					session_destroy();
					go('非法打水，账号已被停用（2）！');
				}
			}
		}

		$ksTime = $_POST['match_endtime'][0];
		if ($_POST['is_lose'] == 1){
			$lose_ok = 0;
			if ($ball_sort == '足球滚球'||$ball_sort == '足球上半场滚球'){
				$Match_HRedCard = $_POST['Match_HRedCard'][0];
				$Match_GRedCard = $_POST['Match_GRedCard'][0];
			}
		}else{
			$lose_ok = 1;
		}

		if (!$match_type || ($match_type == '')){
			$match_type = '1';
		}

		$bet_info = write_bet_info($ball_sort, $column, $master_guest, $bet_point, $match_showtype, $match_rgg, $match_dxgg, $match_nowscore, $tid);

		include_once 'class/bet_ds.php';

		if (bet_ds::dx_add($uid, $ball_sort, strtolower($column), $match_name, $master_guest, $match_id, $bet_info, $bet_money, $bet_point, $ben_add, $bet_win, $match_time, $match_endtime, $lose_ok, $match_showtype, $match_rgg, $match_dxgg, $match_nowscore, $match_type, $balance, $assets, $Match_HRedCard, $Match_GRedCard, $ksTime)){
			if ($_POST['is_lose'] == 1)	{
				go('交易确认中');
			}else{
				go('交易成功');
			}
		}else{
			go('交易失败1');
		}
	}else{
		$dz = $dz_db['串关'];
		$dc = $dc_db['串关'];
		if (!$dz || ($dz == '')){
			$dz = $dz_db['未定义'];
		}

		if (!$dc || ($dc == '')){
			$dc = $dc_db['未定义'];
		}

		if ($dz < $bet_money){
			go('交易金额多于系统限额');
		}

		$s_t = strftime('%Y-%m-%d', time()) . ' 00:00:00';
		$e_t = strftime('%Y-%m-%d', time()) . ' 23:59:59';
		$params = array(':uid' => $_SESSION['uid'], ':s_t' => $s_t, ':e_t' => $e_t);
		$sql = 'select sum(bet_money) as s from `k_bet_cg_group` where uid=:uid and bet_time>=:s_t and bet_time<=:e_t and `status`!=3';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$rs_money = $stmt->fetchColumn();
		if ($dc < ($rs_money + $bet_money)){
			go('交易金额多于系统限额');
		}
		$width = 0;
		$name1 = '';
		$guest1 = '';
		$info1 = '';
		$bet_win = 0;
		$point = 1;
		$ksTime = $_POST['match_endtime'][0];
		
		for ($i = 0;$i < count($_POST['match_id']);$i++){
			check_point($_POST['ball_sort'][$i], $_POST['point_column'][$i], $_POST['match_id'][$i], $_POST['bet_point'][$i], $_POST['match_rgg'][$i], $_POST['match_dxgg'][$i], 0, $i);
			$bet_point = $_POST['bet_point'][$i] * 1;
			$point_column = $_POST['point_column'][$i];
			if (in_array($point_column, $arr_add)){
				$bet_point += 1;
			}

			if (str_leng($name1) < str_leng($_POST['match_name'][$i])){
				$name1 = $_POST['match_name'][$i];
			}

			if (str_leng($guest1) < str_leng($_POST['master_guest'][$i])){
				$guest1 = $_POST['master_guest'][$i];
			}

			if (str_leng($info1) < str_leng($_POST['bet_info'][$i])){
				$info1 = $_POST['bet_info'][$i];
			}

			if (strtotime($ksTime) < strtotime($_POST['match_endtime'][$i])){
				$ksTime = $_POST['match_endtime'][$i];
			}

			$point *= $bet_point;
			if (($db_table != 'zqgq_match') && ($db_table != 'lqgq_match')){
				$chk_match_id = $_POST['match_id'][$i];
				$chk_match_name = $_POST['match_name'][$i];
				$chk_match_endtime = $_POST['match_endtime'][$i];
				if ($db_table != 't_guanjun_team'){
					$params = array(':match_id' => $chk_match_id);
					$chk_sql = 'select match_name,match_time,Match_CoverDate from mydata4_db.' . $db_table . ' where match_id=:match_id limit 1';
					$stmt = $mydata1_db->prepare($chk_sql);
					$stmt->execute($params);
					$chk_rs = $stmt->fetch();
					if (($chk_rs['match_name'] != $chk_match_name) || ($chk_rs['Match_CoverDate'] != $chk_match_endtime)){
						$params = array(':uid' => $uid);
						$sql = 'update k_user_login set `is_login`=0 where uid=:uid';
						$stmt = $mydata1_db->prepare($sql);
						$stmt->execute($params);
						$why = '(5)会员ID：' . $_SESSION['uid'] . '，账户名：' . $_SESSION['username'] . '在 ' . date('Y-m-d H:i:s') . ' 非法访问注单下注页（bet.php）。投注信息：' . $_POST['ball_sort'][0] . ' ' . $_POST['touzhuxiang'][0] . '，投注金额：' . $_POST['bet_money'][0];
						$params = array(':why' => $why, ':uid' => $uid);
						$sql = 'UPDATE k_user set is_stop=1,why=concat_ws(\'，\',why,:why) where uid=:uid';
						$stmt = $mydata1_db->prepare($sql);
						$stmt->execute($params);
						unset($_SESSION['uid']);
						unset($_SESSION['gid']);
						unset($_SESSION['username']);
						session_destroy();
						go('非法打水，账号已被停用（3）！');
					}
				}else{
					$params = array(':match_id' => $chk_match_id);
					$chk_sql = 'select Match_CoverDate from mydata4_db.t_guanjun where match_id=:match_id limit 1';
					$stmt = $mydata1_db->prepare($chk_sql);
					$stmt->execute($params);
					$chk_rs = $stmt->fetch();
					if ($chk_rs['Match_CoverDate'] != $chk_match_endtime){
						$params = array(':uid' => $uid);
						$sql = 'update k_user_login set `is_login`=0 where uid=:uid';
						$stmt = $mydata1_db->prepare($sql);
						$stmt->execute($params);
						$why = '(6)会员ID：' . $_SESSION['uid'] . '，账户名：' . $_SESSION['username'] . '在 ' . date('Y-m-d H:i:s') . ' 非法访问注单下注页（bet.php）。投注信息：' . $_POST['ball_sort'][0] . ' ' . $_POST['touzhuxiang'][0] . '，投注金额：' . $_POST['bet_money'][0];
						$params = array(':why' => $why, ':uid' => $uid);
						$sql = 'UPDATE k_user set is_stop=1,why=concat_ws(\'，\',why,:why) where uid=:uid';
						$stmt = $mydata1_db->prepare($sql);
						$stmt->execute($params);
						unset($_SESSION['uid']);
						unset($_SESSION['gid']);
						unset($_SESSION['username']);
						session_destroy();
						go('非法打水，账号已被停用（4）！');
					}
				}
			}
		}
		$width = str_leng('=====' . $name1 . '=' . $guest1 . '=' . $info1 . $bet_money);
		$height = 20 * $i;
		$im = imagecreate($width, $height);
		$bkg = imagecolorallocate($im, 255, 255, 255);
		$font = imagecolorallocate($im, 150, 182, 151);
		$sort_c = imagecolorallocate($im, 0, 0, 0);
		$name_c = imagecolorallocate($im, 243, 118, 5);
		$guest_c = imagecolorallocate($im, 34, 93, 156);
		$info_c = imagecolorallocate($im, 51, 102, 0);
		$money_c = imagecolorallocate($im, 255, 0, 0);
		$fnt = 'ttf/simhei.ttf';
		$cg_count = count($_POST['match_name']);
		$bet_win = $point * $bet_money;
		if ($cg_count < 3){
			go('串关最少允许3场赛事');
		}else if (8 < $cg_count){
			go('串关最多允许8场赛事');
		}
		$params = array(':bet_money' => $bet_money, ':uid' => $uid, ':bet_money2' => $bet_money, ':balance' => $balance);
		$sql = 'update k_user set money=money-:bet_money where uid=:uid and money>=:bet_money2 and :balance>=0';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q3 = $stmt->rowCount();
		if ($q3 < 1){
			go('扣款失败<br>交易失败');
		}
		include 'cache/conf.php';
		$params = array(':uid' => $uid, ':cg_count' => $cg_count, ':bet_money' => $bet_money, ':bet_win' => $bet_win, ':balance' => $balance, ':assets' => $assets, ':www' => $conf_www, ':match_coverdate' => $ksTime);
		$sql = "insert into k_bet_cg_group(uid,cg_count,bet_money,bet_win,balance,assets,www,match_coverdate) values(:uid,:cg_count,:bet_money,:bet_win,:balance,:assets,:www,:match_coverdate)";
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q1 = $stmt->rowCount();
		$gid = $mydata1_db->lastInsertId();
		$params = array();
		$sql = "insert into k_bet_cg(uid,gid,ball_sort,point_column,match_name,master_guest,match_id,bet_info,bet_money,bet_point,ben_add,match_endtime,match_showtype,match_rgg,match_dxgg,match_nowscore) values";
		
		for ($i = 0;$i < $cg_count;$i++){
			$ball_sort = $_POST['ball_sort'][$i];
			$column = $_POST['point_column'][$i];
			$match_name = $_POST['match_name'][$i];
			$master_guest = $_POST['master_guest'][$i];
			$match_id = $_POST['match_id'][$i];
			$bet_info = $_POST['bet_info'][$i];
			$bet_money = $_POST['bet_money'];
			$bet_point = $_POST['bet_point'][$i];
			$ben_add = $_POST['ben_add'][$i];
			$match_showtype = $_POST['match_showtype'][$i];
			$match_rgg = $_POST['match_rgg'][$i];
			$match_dxgg = $_POST['match_dxgg'][$i];
			$match_nowscore = $_POST['match_nowscore'][$i];
			$match_endtime = $_POST['match_endtime'][$i];
			$bet_info = write_bet_info($ball_sort, $column, $master_guest, $bet_point, $match_showtype, $match_rgg, $match_dxgg, $match_nowscore, $tid);
			$params[':uid' . $i] = $uid;
			$params[':gid' . $i] = $gid;
			$params[':ball_sort_' . $i] = $ball_sort;
			$params[':point_column_' . $i] = strtolower($column);
			$params[':match_name_' . $i] = $match_name;
			$params[':master_guest_' . $i] = $master_guest;
			$params[':match_id_' . $i] = $match_id;
			$params[':bet_info_' . $i] = $bet_info;
			$params[':bet_money_' . $i] = $bet_money;
			$params[':bet_point_' . $i] = $bet_point;
			$params[':ben_add_' . $i] = $ben_add;
			$params[':match_endtime_' . $i] = $match_endtime;
			$params[':match_showtype_' . $i] = $match_showtype;
			$params[':match_rgg_' . $i] = $match_rgg;
			$params[':match_dxgg_' . $i] = $match_dxgg;
			$params[':match_nowscore_' . $i] = $match_nowscore;
			$sql .= "(:uid" . $i . ",:gid" . $i . ",:ball_sort_" . $i . ",:point_column_" . $i . ",:match_name_" . $i . ",:master_guest_" . $i . ",:match_id_" . $i . ",:bet_info_" . $i . ",:bet_money_" . $i . ",:bet_point_" . $i . ",:ben_add_" . $i . ",:match_endtime_" . $i . ",:match_showtype_" . $i . ",:match_rgg_" . $i . ",:match_dxgg_" . $i . ",:match_nowscore_" . $i . "),";
			imagettftext($im, 10, 0, 7, 18 * ($i + 1), $sort_c, $fnt, $ball_sort);
			imagettftext($im, 10, 0, str_leng('======'), 18 * ($i + 1), $name_c, $fnt, $match_name);
			imagettftext($im, 10, 0, str_leng('=======' . $name1), 18 * ($i + 1), $guest_c, $fnt, $master_guest);
			imagettftext($im, 10, 0, str_leng('========' . $name1 . $guest1), 18 * ($i + 1), $info_c, $fnt, $bet_info);
			imagettftext($im, 10, 0, str_leng('=======' . $name1 . $guest1 . $info1), 18 * ($i + 1), $money_c, $fnt, $bet_money);
		}
		$sql = rtrim($sql, ',');
		
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q2 = $stmt->rowCount();
		$userName = $_SESSION['username'];
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':uid' => $uid, ':userName' => $userName, ':gid' => $gid, ':bet_money' => $bet_money, ':assets' => $assets, ':balance' => $balance, ':creationTime' => $creationTime);
		$sql = "INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE(:uid,:userName,'SportsCG','BET',:gid,-:bet_money,:assets,:balance,:creationTime)";
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		imagerectangle($im, 0, 0, $width - 1, $height - 1, $font);
		$datereg = date('Ymd');
		if (!is_dir('other/' . $datereg)){
			mkdir('other/' . $datereg);
		}
		$q4 = imagejpeg($im, 'other/' . $datereg . '/' . $gid . '.jpg');
		imagedestroy($im);
		if (($q1 == 1) && ($q2 == $i) && ($q3 == 1) && $q4){
			go('交易成功');
		}else{
			go('交易失败'.$sqlss);
		}
	}
}else{
	go('交易金额有误<br>交易失败');
}

function str_leng($str){
	mb_internal_encoding('UTF-8');
	return mb_strlen($str) * 12;
}

function check_point($ballsort, $column, $match_id, $point, $rgg, $dxgg, $tid = 0, $index = 0){
	global $db_table;
	$pk = array('Match_Ho', 'Match_Ao', 'Match_DxDpl', 'Match_DxXpl', 'Match_BHo', 'Match_BAo', 'Match_Bdpl', 'Match_Bxpl');
	$t = array( 
			array('cn' => '足球波胆', 'db_table' => 'bet_match'),
			array('cn' => '足球上半场波胆', 'db_table' => 'bet_match'), 
			array('cn' => '足球单式', 'db_table' => 'bet_match'), 
			array('cn' => '足球上半场', 'db_table' => 'bet_match'), 
			array('cn' => '足球早盘', 'db_table' => 'bet_match'), 
			array('cn' => '足球上半场早盘', 'db_table' => 'bet_match'), 
			array('cn' => '足球滚球', 'db_table' => 'zqgq_match'), 
			array('cn' => '足球上半场滚球', 'db_table' => 'zqgq_match'), 
			//篮球
			array('cn' => '篮球单式', 'db_table' => 'lq_match'), 
			array('cn' => '篮球单节', 'db_table' => 'lq_match'),
			array('cn' => '篮球滚球', 'db_table' => 'lqgq_match'), 
			array('cn' => '篮球早盘', 'db_table' => 'lq_match'), 
			//排球
			array('cn' => '排球单式', 'db_table' => 'volleyball_match'), 
			//网球
			array('cn' => '网球单式', 'db_table' => 'tennis_match'),
			//羽毛球
			array('cn' => '羽毛球单式', 'db_table' => 'badminton_match'), 
			//斯诺克
			array('cn' => '斯诺克单式', 'db_table' => 'snooker_match'),  
			//棒球
			array('cn' => '棒球单式', 'db_table' => 'baseball_match'), 
			//其他
			array('cn' => '其他单式', 'db_table' => 'other_match'),
			//冠军
			array('cn' => '冠军', 'db_table' => 't_guanjun_team'), 
			//金融
			array('cn' => '金融', 'db_table' => 't_guanjun_team') 
		);
	foreach ($t as $m){
		if ($m['cn'] == $ballsort){
			$db_table = $m['db_table'];
		}
	}
	$rgg = '' . $rgg;
	$dxgg = '' . $dxgg;
	$point = '' . $point;
	if (($db_table == 'zqgq_match') || ($db_table == 'lqgq_match')){
		if ($db_table == 'zqgq_match'){
			//include_once 'include/function_cj1.php';
			//if (zqgq_cj()){
				include 'cache/zqgq.php';
			//}else{
			//	go('网络异常,交易失败');
			//}
			$existmatch = false;
			
			for ($i = 0;$i < count($zqgq);$i++){
				if (@($zqgq[$i]['Match_ID']) == $match_id){
					$existmatch = true;
					break;
				}
			}

			if (!$existmatch){
				go('盘口已关闭,交易失败');
			}

			if ($zqgq[$i][$column] < 0.01){
				go('盘口已关闭,交易失败');
			}

			if ($zqgq[$i][$column] === $point){
				if (in_array($column, $pk)){
					if ((($column == 'Match_Ho') || ($column == 'Match_Ao')) && ($zqgq[$i]['Match_RGG'] !== $rgg)){
						if ($zqgq[$i]['Match_RGG'] == ''){
							go('盘口已关闭,交易失败');
						}else{
							confirm('盘口', $zqgq[$i]['Match_RGG'], $point, $zqgq[$i]['Match_RGG'], $zqgq[$i]['Match_DxGG']);
						}
					}else if ((($column == 'Match_BHo') || ($column == 'Match_BAo')) && ($zqgq[$i]['Match_BRpk'] !== $rgg)){
						if ($zqgq[$i]['Match_BRpk'] == ''){
							go('盘口已关闭,交易失败');
						}else{
							confirm('盘口', $zqgq[$i]['Match_BRpk'], $point, $zqgq[$i]['Match_BRpk'], $zqgq[$i]['Match_Bdxpk']);
						}
					}else if ((($column == 'Match_DxDpl') || ($column == 'Match_DxXpl')) && ($zqgq[$i]['Match_DxGG'] !== $dxgg)){
						if ($zqgq[$i]['Match_DxGG'] == ''){
							go('盘口已关闭,交易失败');
						}else{
							confirm('盘口', $zqgq[$i]['Match_DxGG'], $point, $zqgq[$i]['Match_RGG'], $zqgq[$i]['Match_DxGG']);
						}
					}else if ((($column == 'Match_Bdpl') || ($column == 'Match_Bxpl')) && ($zqgq[$i]['Match_Bdxpk'] !== $dxgg)){
						if ($zqgq[$i]['Match_Bdxpk'] == ''){
							go('盘口已关闭,交易失败');
						}else{
							confirm('盘口', $zqgq[$i]['Match_Bdxpk'], $point, $zqgq[$i]['Match_BRpk'], $zqgq[$i]['Match_Bdxpk']);
						}
					}
				}
				return true;
			}else{
				confirm('水位', $zqgq[$i][$column], $zqgq[$i][$column], $rgg, $dxgg);
			}
		}else{
			//include_once 'include/function_cj1.php';
			//if (lqgq_cj()){
				include 'cache/lqgq.php';
			//}else{
			//	go('网络异常,交易失败');
			//}
			$existmatch = false;
			
			for ($i = 0;$i < count($lqgq);$i++){
				if (@($lqgq[$i]['Match_ID']) == $match_id){
					$existmatch = true;
					break;
				}
			}

			if (!$existmatch){
				go('盘口已关闭,交易失败');
			}

			if ($lqgq[$i][$column] < 0.01){
				go('盘口已关闭,交易失败');
			}

			if ($lqgq[$i][$column] === $point){
				if (in_array($column, $pk)){
					if ((($column == 'Match_Ho') || ($column == 'Match_Ao')) && ($lqgq[$i]['Match_RGG'] !== $rgg)){
						if (($lqgq[$i]['Match_RGG'] == '') || ($lqgq[$i]['Match_RGG'] == 0)){
							go('盘口已关闭,交易失败');
						}else{
							confirm('盘口', $lqgq[$i]['Match_RGG'], $point, $lqgq[$i]['Match_RGG'], $lqgq[$i]['Match_DxGG']);
						}
					}else if ((($column == 'Match_DxDpl') || ($column == 'Match_DxXpl')) && ($lqgq[$i]['Match_DxGG'] !== $dxgg)){
						if (($lqgq[$i]['Match_DxGG'] == '') || ($lqgq[$i]['Match_DxGG'] == 0)){
							go('盘口已关闭,交易失败');
						}else{
							confirm('盘口', $lqgq[$i]['Match_DxGG'], $point, $lqgq[$i]['Match_RGG'], $lqgq[$i]['Match_DxGG']);
						}
					}
				}
				return true;
			}else{
				confirm('水位', $lqgq[$i][$column], $lqgq[$i][$column], $rgg, $dxgg);
			}
		}
	}else{
		global $mydata1_db;
		if ($db_table == 't_guanjun_team'){
			if ($tid){
				$params = array(':tid' => $tid);
				$sql = 'select t.point from mydata4_db.t_guanjun_team t,mydata4_db.t_guanjun g where t.tid=:tid and t.xid=g.x_id and g.Match_CoverDate>now() limit 1';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				$rs = $stmt->fetch();
				$newpoint = '' . sprintf('%.2f', $rs['point']);
				if ($newpoint === $point){
					return true;
				}else if ($newpoint == 0){
					go('盘口已关闭,交易失败');
				}else{
					confirm('水位', $newpoint, $newpoint);
				}
			}
		}else{
			global $touzhutype;
			$other = '';
			if ($db_table == 'bet_match'){
				$other = ',Match_BRpk,Match_Bdxpk';
			}
			$arr_db_table = array('baseball_match', 'bet_match', 'lq_match', 't_guanjun_team', 'tennis_match', 'volleyball_match', 'other_match','snooker_match','badminton_match');
			if (!in_array($db_table, $arr_db_table)){
				go('数据[表]查询失败，交易失败');
			}
			$sql_col = 'show columns from mydata4_db.' . $db_table;
			$query_col = $mydata1_db->query($sql_col);
			$ok_col = false;
			while ($rs_col = $query_col->fetch()){
				if (strtolower($rs_col['Field']) == strtolower($column)){
					$ok_col = true;
					break;
				}
			}
			if (!$ok_col){
				go('数据[字段]查询失败，交易失败');
			}
			$params = array(':match_id' => $match_id);
			$sql = 'select Match_RGG,Match_DxGG,' . $column . ' ' . $other . ' from mydata4_db.' . $db_table . ' where match_id=:match_id and Match_CoverDate>now() limit 1';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$rs = $stmt->fetch();
			$newpoint = '' . sprintf('%.2f', $rs[$column]);
			if ($newpoint === $point){
				if (in_array($column, $pk)){
					if ((($column == 'Match_Ho') || ($column == 'Match_Ao')) && ($rs['Match_RGG'] !== $rgg)){
						if ($touzhutype == 1){
							confirm_cg('盘口', $rs['Match_RGG'], $point, $rs['Match_RGG'], $rs['Match_DxGG'], $index);
						}else{
							confirm('盘口', $rs['Match_RGG'], $point, $rs['Match_RGG'], $rs['Match_DxGG']);
						}
					}else if ((($column == 'Match_DxDpl') || ($column == 'Match_DxXpl')) && ($rs['Match_DxGG'] !== $dxgg)){
						if ($touzhutype == 1){
							confirm_cg('盘口', $rs['Match_DxGG'], $point, $rs['Match_RGG'], $rs['Match_DxGG'], $index);
						}else{
							confirm('盘口', $rs['Match_DxGG'], $point, $rs['Match_RGG'], $rs['Match_DxGG']);
						}
					}else if ((($column == 'Match_BHo') || ($column == 'Match_BAo')) && ($rs['Match_BRpk'] !== $rgg)){
						if ($touzhutype == 1){
							confirm_cg('盘口', $rs['Match_BRpk'], $point, $rs['Match_BRpk'], $rs['Match_Bdxpk'], $index);
						}else{
							confirm('盘口', $rs['Match_BRpk'], $point, $rs['Match_BRpk'], $rs['Match_Bdxpk']);
						}
					}else if ((($column == 'Match_Bdpl') || ($column == 'Match_Bxpl')) && ($rs['Match_Bdxpk'] !== $dxgg)){
						if ($touzhutype == 1){
							confirm_cg('盘口', $rs['Match_Bdxpk'], $point, $rs['Match_BRpk'], $rs['Match_Bdxpk'], $index);
						}else{
							confirm('盘口', $rs['Match_Bdxpk'], $point, $rs['Match_BRpk'], $rs['Match_Bdxpk']);
						}
					}
				}
				return true;
			}else if ($newpoint == 0){
				go('盘口已关闭,交易失败');
			}else if ($touzhutype == 1){
				confirm_cg('水位', $newpoint, $newpoint, $rgg, $dxgg, $index);
			}else{
				confirm('水位', $newpoint, $newpoint, $rgg, $dxgg);
			}
		}
	}
}

function go($msg){
	$_SESSION["check_action"]=''; //检测用户是否用软件打水标识
    echo "<script>alert('".$msg."');location.href='left.php?shuaxin=Y';</script>"; 
?>
<table width="100%" style="margin:0px;" cellspacing="0" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="color:#FFFFFF; height:30px;" align="center"><font style="color:#FFFFFF; font-weight:bold"><?=$msg?></font></td>
  </tr>
  <tr>
    <td height="24" align="center"><a style="text-decoration:none; color:#fff; font-size:14px;" href="left.php">2秒后自动返回交易页</a></td>
  </tr>
  
</table>
<meta content="2;url=left.php?<?=rand()?>" http-equiv="refresh" />
<script language="javascript">
<!--
if(self==top){
	top.location='/index.php';
}
-->
</script>
<script type="text/javascript" language="javascript" src="/js/left_mouse.js"></script>
</body>
</html>

<?php
	exit();
}

function confirm($msg, $type, $pl, $rgg = 0, $dxgg = 0){
	$ball_sort = $_POST['ball_sort'][0];
	$column = $_POST['point_column'][0];
	$match_name = $_POST['match_name'][0];
	$master_guest = $_POST['master_guest'][0];
	$match_id = $_POST['match_id'][0];
	$tid = $_POST['tid'][0];
	$bet_info = $_POST['bet_info'][0];
	$touzhuxiang = $_POST['touzhuxiang'][0];
	$match_showtype = $_POST['match_showtype'][0];
	$match_rgg = $rgg;
	$match_dxgg = $dxgg;
	$match_nowscore = $_POST['match_nowscore'][0];
	$bet_point = $pl;
	$match_type = $_POST['match_type'][0];
	$ben_add = $_POST['ben_add'][0];
	$match_time = $_POST['match_time'][0];
	$match_endtime = $_POST['match_endtime'][0];
	$Match_HRedCard = $_POST['Match_HRedCard'][0];
	$Match_GRedCard = $_POST['Match_GRedCard'][0];
	$is_lose = $_POST['is_lose'][0];
	$orderinfo = $ball_sort . $column . $match_name . $master_guest . $match_id . $tid . $bet_info . $touzhuxiang;
	$orderinfo .= $match_showtype . $match_rgg . $match_dxgg . $match_nowscore . $bet_point . $match_type;
	$orderinfo .= $ben_add . $match_time . $match_endtime . $Match_HRedCard . $Match_GRedCard . $is_lose;
	global $postkey;
	$orderkey = StrToHex($orderinfo, $postkey);
?>
<div style="border:2px solid #FFDF42; width:155px; height:113px; background-image:url(images/leftbg01.gif); position:absolute; left: 6px; top: 5px; color:#fffff">
	<form id="form1" name="form1" method="post" action="bet.php" style="margin:0 0 0 0;" onsubmit="javascript:document.getElementById('submit').disabled=true;"><table width="155" border="0" align="center" cellspacing="0">
		  <tr>
			<td colspan="2" align="left" valign="middle" style="color:#000;padding-left:10px; padding-top:10px; font-size:13px;">当前<?=$msg?>已改变</td>
		  </tr>
		  <tr>
			<td colspan="2" align="left" valign="middle" style="color:red;padding-left:10px; font-size:13px">最新<?=$msg?>：<span style="color:#FF0000; font-size:14px;"><?=$type?></span></td>
		  </tr>
		  <tr>
			<td colspan="2" align="left" valign="middle" style="color:#ffffff;padding-left:10px; font-size:13px">是否继续交易？</td>
		  </tr>
		  <tr>
			<td height="47" align="center" valign="middle">
			  <input type="button" name="Submit2" style="background-image:url(images/button001.gif); color:#FFFFFF; border:0px; width:73px; height:23px; cursor:pointer;" value="取消交易" onclick="goleft();" /></td>
			<td height="47" align="center" valign="middle"><input type="submit" name="submit" id="submit" style="background-image:url(images/button001.gif);  color:#FFFFFF; border:0px; width:73px; height:23px; cursor:pointer;" value="继续交易" /></td>
		  </tr>
		</table>
		<input type="hidden" name="orderkey[]" value="<?=$orderkey?>"/>
		<input type="hidden" name="bet_money" value="<?=$_POST["bet_money"]?>" />
		<input type="hidden" name="touzhutype" value="0" />
		<input type="hidden" name="ball_sort[]" value="<?=$_POST["ball_sort"][0]?>" />
		<input type="hidden" name="point_column[]" value="<?=$_POST["point_column"][0]?>" />
		<input type="hidden" name="match_id[]" value="<?=$_POST["match_id"][0]?>" />
		<input type="hidden" name="match_name[]" value="<?=$_POST["match_name"][0]?>"  />
		<input type="hidden" name="match_showtype[]" value="<?=$_POST["match_showtype"][0]?>"  />
		<input type="hidden" name="match_rgg[]" value="<?=$rgg?>" />
		<input type="hidden" name="match_dxgg[]" value="<?=$dxgg?>" />
		<input type="hidden" name="match_nowscore[]"  value="<?=$_POST["match_nowscore"][0]?>"  />
		<input type="hidden" name="match_type[]"  value="<?=$_POST["match_type"][0]?>"  />
		<input type="hidden" name="touzhuxiang[]" value="<?=$_POST["touzhuxiang"][0]?>" />
		<input type="hidden" name="master_guest[]"  value="<?=$_POST["master_guest"][0]?>"/>
		<input type="hidden" name="bet_info[]" value="<?=$_POST["bet_info"][0]?>"/> 
		<input type="hidden" name="bet_point[]" value="<?=$pl?>"/>
		<input type="hidden" name="match_time[]"  value="<?=$_POST["match_time"][0]?>"/>
		<input type="hidden" name="ben_add[]" value="<?=$_POST["ben_add"][0]?>"/>
		<input type="hidden" name="match_endtime[]"  value="<?=$_POST["match_endtime"][0]?>"/>
		<input type="hidden" name="Match_HRedCard[]"  value="<?=$_POST["Match_HRedCard"][0]?>"/>
		<input type="hidden" name="Match_GRedCard[]"  value="<?=$_POST["Match_GRedCard"][0]?>"/>
		<input type="hidden" name="is_lose"  value="<?=$_POST["is_lose"][0]?>"/>
		<input type="hidden" name="tid"  value="<?=$_POST["tid"][0]?>"/>
	</form>
</div>
	<script language="javascript">
	<!--
	if(self==top){
		top.location='/index.php';
	}
	
	function goleft(){
		window.location.href="left.php";
	}
	
	window.setInterval("goleft()",5000); //5秒未点击，自动退到left.php页面
	-->
	</script>
<script type="text/javascript" language="javascript" src="/js/left_mouse.js"></script>
</body>
	</html>
<?php
	exit();
}

function confirm_cg($msg,$type,$pl,$rgg=0,$dxgg=0,$index){
$_SESSION["token"]=$_POST["token"];
	$g_arr	=	explode('VS.',$_POST["master_guest"][$index]);
?>
	<div style="border:2px solid #FFDF42; width:155px; background-image:url(images/leftbg01.gif); position:absolute; left: 6px; top: 5px; color:#ffffff">
	<form id="form1" name="form1" method="post" action="bet.php" style="margin:0 0 0 0;" onsubmit="javascript:document.getElementById('submit').disabled=true;"><table width="155" border="0" align="center" cellspacing="0"  style="color:#ffffff">
		  <tr>
			<td colspan="2" align="center" valign="middle" style=" color:#000;padding-left:5px; padding-top:10px; font-size:13px; color:#005481; font-weight:bold;"><?=$_POST["match_name"][$index]?></td>
		  </tr>
		  <tr>
			<td colspan="2" align="center" valign="middle" style="color:#000;padding-left:5px; padding-top:10px; font-size:13px; color:#007126;"><?=$g_arr[0]?> <span style="color:#FF0000;">VS.</span> <span style="color:#890209;"><?=$g_arr[1]?></span></td>
		  </tr>
		  <tr>
			<td colspan="2" align="left" valign="middle" style="color:#000;padding-left:10px; padding-top:10px; font-size:13px;">当前<?=$msg?>已改变</td>
		  </tr>
		  <tr>
			<td colspan="2" align="left" valign="middle" style="color:red;padding-left:10px; font-size:13px">最新<?=$msg?>：<span style="color:#FF0000; font-size:14px;"><?=$type?></span></td>
		  </tr>
		  <tr>
			<td colspan="2" align="left" valign="middle" style="color:#000;padding-left:10px; font-size:13px">是否继续交易？</td>
		  </tr>
		  <tr>
			<td height="47" align="center" valign="middle">
			  <input type="button" name="Submit2" style="background-image:url(images/button001.gif); color:#FFFFFF; border:0px; width:73px; height:23px; cursor:pointer;" value="取消交易" onclick="goleft();" /></td>
			<td height="47" align="center" valign="middle"><input type="submit" name="submit" id="submit" style="background-image:url(images/button001.gif);  color:#FFFFFF; border:0px; width:73px; height:23px; cursor:pointer;" value="继续交易" /></td>
		  </tr>
		</table>
		<input type="hidden" name="bet_money" value="<?=$_POST["bet_money"]?>" />
		<input type="hidden" name="touzhutype" value="1" />
<?php
$sum	=	count($_POST["match_id"]);
for($i=0;$i<$sum;$i++){
	if($i == $index){
		$_POST["match_rgg"][$i]		=	$rgg;
		$_POST["match_dxgg"][$i]	=	$dxgg;
		$_POST["bet_point"][$i]		=	$pl;
	}
	/* 加密数据防止作弊 2014.03.12 BEGIN */
	$ball_sort		=	$_POST["ball_sort"][$i];
	$column			=	$_POST["point_column"][$i];
	$match_name		=	$_POST["match_name"][$i];
	$master_guest	=	$_POST["master_guest"][$i];
	$match_id		=	$_POST["match_id"][$i];
	$tid			=	$_POST["tid"][$i];
	$bet_info		=	$_POST["bet_info"][$i];
	$touzhuxiang	=	$_POST["touzhuxiang"][$i];
	$match_showtype	=	$_POST["match_showtype"][$i];
	$match_rgg		=	$_POST["match_rgg"][$i];
	$match_dxgg		=	$_POST["match_dxgg"][$i];
	$match_nowscore	=	$_POST["match_nowscore"][$i];
	$bet_point		=	$_POST["bet_point"][$i];
	$match_type		=	$_POST["match_type"][$i];
	$ben_add		=	$_POST["ben_add"][$i];
	$match_time		=	$_POST["match_time"][$i];
	$match_endtime	=	$_POST["match_endtime"][$i];
	$Match_HRedCard	=	$_POST["Match_HRedCard"][$i];
	$Match_GRedCard	=	$_POST["Match_GRedCard"][$i];
	$is_lose		=	$_POST["is_lose"][$i];
	$orderinfo		=	$ball_sort.$column.$match_name.$master_guest.$match_id.$tid.$bet_info.$touzhuxiang;
	$orderinfo		.=	$match_showtype.$match_rgg.$match_dxgg.$match_nowscore.$bet_point.$match_type;
	$orderinfo		.=	$ben_add.$match_time.$match_endtime.$Match_HRedCard.$Match_GRedCard.$is_lose;
	global $postkey;
	$orderkey		=	StrToHex($orderinfo,$postkey);
	/* 加密数据防止作弊 2014.03.12 END */
?>
		<input type="hidden" name="orderkey[]" value="<?=$orderkey?>"/>
		<input type="hidden" name="ball_sort[]" value="<?=$_POST["ball_sort"][$i]?>" />
		<input type="hidden" name="point_column[]" value="<?=$_POST["point_column"][$i]?>" />
		<input type="hidden" name="match_id[]" value="<?=$_POST["match_id"][$i]?>" />
		<input type="hidden" name="match_name[]" value="<?=$_POST["match_name"][$i]?>"  />
		<input type="hidden" name="match_showtype[]" value="<?=$_POST["match_showtype"][$i]?>"  />
		<input type="hidden" name="match_rgg[]" value="<?=$_POST["match_rgg"][$i]?>" />
		<input type="hidden" name="match_dxgg[]" value="<?=$_POST["match_dxgg"][$i]?>" />
		<input type="hidden" name="match_nowscore[]"  value="<?=$_POST["match_nowscore"][$i]?>"  />
		<input type="hidden" name="match_type[]"  value="<?=$_POST["match_type"][$i]?>"  />
		<input type="hidden" name="master_guest[]"  value="<?=$_POST["master_guest"][$i]?>"/>
		<input type="hidden" name="bet_info[]" value="<?=$_POST["bet_info"][$i]?>"/> 
		<input type="hidden" name="bet_point[]" value="<?=$_POST["bet_point"][$i]?>"/>
		<input type="hidden" name="match_time[]"  value="<?=$_POST["match_time"][$i]?>"/>
		<input type="hidden" name="ben_add[]" value="<?=$_POST["ben_add"][$i]?>"/>
		<input type="hidden" name="match_endtime[]"  value="<?=$_POST["match_endtime"][$i]?>"/>
		<input type="hidden" name="is_lose"  value="<?=$_POST["is_lose"][$i]?>"/>
<?php
}
?>
	</form>
</div>
	<script language="javascript">
	<!--
	if(self==top){
		top.location='/index.php';
	}
	
	function goleft(){
		window.location.href="left.php";
	}
	
	window.setInterval("goleft()",5000); //5秒未点击，自动退到left.php页面
	-->
	</script>
<script type="text/javascript" language="javascript" src="/js/left_mouse.js"></script>
</body>
	</html>
<?php
	exit();
}
?>