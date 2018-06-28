<?php
header('Content-type: text/html;charset=utf-8');
@session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/class/admin.php';
if($_SESSION['a-gan'] != '1'){
	if (!isset($_SESSION['adminid'])) {
		logout_msg('您的登录已过期，请重新登录！');
	}else{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/database/mysql.config.php';
		$client_ip = $_SERVER['REMOTE_ADDR'];
		$params = array(':uid' => intval($_SESSION['adminid']));
		$sql = 'select uid,login_pwd,login_name,login_ip,quanxian,ip from mydata3_db.sys_admin where is_login=1 and uid=:uid limit 1';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$rs = $stmt->fetch();
		if ($rs['login_pwd'] != $_SESSION['login_pwd'] || $rs['login_name'] != $_SESSION['login_name']) {
			logout_msg('您的登录已过期，请重新登录！');
		}
		if($rs['login_ip'] != $client_ip){
			logout_msg('登录IP发生变化，请重新登录！');
		}
		$_SESSION['quanxian'] = $rs['quanxian'];
		if (0 < $rs['uid']) {
			if($rs['ip']!=''){
				$bool_ip = false;
				$arr_ip = explode(',', $rs['ip']);
				foreach ($arr_ip as $k => $v)
				{
					if (strpos('=' . $client_ip, $v))
					{
						$bool_ip = true;
						break;
					}
				}
				if (!$bool_ip) {
					logout_msg('登陆IP错误，您当前的登陆IP为：' . $client_ip);
				}
			}
		} else {
			logout_msg('您的登录已过期，请重新登录！');
		}
	}
}else if ($_SESSION['a-gan'] == '1'){
	if($_SERVER['REMOTE_ADDR'] != admin::DOOR_IP && empty($_SESSION['not_ip'])) {
		$_SESSION = array();
	}
}

if (!isset($_SESSION['adminid'])) {
		logout_msg('您的登录已过期，请重新登录！');
}

function check_quanxian($qx)
{
	$quanxian = $_SESSION['quanxian'];
	if (!strpos($quanxian, $qx))
	{
		message('您没有权限操作该功能！');
	}
}
function wtype($tp)
{
	switch ($tp)
	{
		case 'R': $arr = array('match_ho', 'match_ao');
		break;
		case 'OU': $arr = array('match_dxdpl', 'match_dxxpl');
		break;
		case 'ROU': $arr = array('match_dxdpl', 'match_dxxpl');
		break;
		case 'PD': $arr = array('match_bd10', 'match_bd20', 'match_bd21', 'match_bd30', 'match_bd31', 'match_bd32', 'match_bd40', 'match_bd41', 'match_bd42', 'match_bd43', 'match_bdg10', 'match_bdg20', 'match_bdg21', 'match_bdg30', 'match_bdg31', 'match_bdg32', 'match_bdg40', 'match_bdg41', 'match_bdg42', 'match_bdg43', 'match_bd00', 'match_bd11', 'match_bd22', 'match_bd33', 'match_bd44', 'match_bdup5');
		break;
		case 'T': $arr = array('match_total01pl', 'match_total23pl', 'match_total46pl', 'match_total7uppl');
		break;
		case 'M': $arr = array('match_bzm', 'match_bzg', 'match_bzh');
		break;
		case 'F': $arr = array('match_bqmm', 'match_bqmh', 'match_bqmg', 'match_bqhm', 'match_bqhh', 'match_bqhg', 'match_bqgm', 'match_bqgh', 'match_bqgg');
		break;
		case 'HR': $arr = array('match_bho', 'match_bao');
		break;
		case 'HRE': $arr = array('match_bho', 'match_bao');
		break;
		case 'HOU': $arr = array('match_bdpl', 'match_bxpl');
		break;
		case 'HROU': $arr = array('match_bdpl', 'match_bxpl');
		break;
		case 'HM': $arr = array('match_bmdy', 'match_bgdy', 'match_bhdy');
		break;
		case 'HPD': $arr = array('match_hr_bd10', 'match_hr_bd20', 'match_hr_bd21', 'match_hr_bd30', 'match_hr_bd31', 'match_hr_bd32', 'match_hr_bd40', 'match_hr_bd41', 'match_hr_bd42', 'match_hr_bd43', 'match_hr_bdg10', 'match_hr_bdg20', 'match_hr_bdg21', 'match_hr_bdg30', 'match_hr_bdg31', 'match_hr_bdg32', 'match_hr_bdg40', 'match_hr_bdg41', 'match_hr_bdg42', 'match_hr_bdg43', 'match_hr_bd00', 'match_hr_bd11', 'match_hr_bd22', 'match_hr_bd33', 'match_hr_bd44', 'match_hr_bdup5');
		break;
		default: $arr = array('');
	}
	return $arr;
}
function message($value, $url = '')
{
	header('Content-type: text/html;charset=utf-8');
	$js = '<script type="text/javascript" language="javascript">' . "\r\n";
	$js .= 'alert("' . $value . '");' . "\r\n";
	if ($url)
	{
		$js .= 'window.location.href="' . $url . '";' . "\r\n";
	}
	else
	{
		$js .= 'window.history.go(-1);' . "\r\n";
	}
	$js .= '</script>' . "\r\n";
 echo $js;
	exit();
}
function write_file($filename, $data, $method = 'rb+', $iflock = 1)
{
	@(touch($filename));
	$handle = @(fopen($filename, $method));
	if ($iflock)
	{
		@(flock($handle, LOCK_EX));
	}
	@(fputs($handle, $data));
	if ($method == 'rb+')
	{
		@(ftruncate($handle, strlen($data)));
	}
	@(fclose($handle));
	@(chmod($filename, 511));
	if (is_writable($filename))
	{
		return true;
	}
	else
	{
		return false;
	}
}
function get_bj_time($time)
{
	return date('Y-m-d H:i:s', strtotime($time) + 43200);
}
function double_format($num)
{
	return 0 < $num ? sprintf('%.2f', $num) : $num < 0 ? sprintf('%.2f', $num) : 0;
}
function get_DSFS($piont, $bet_money)
{
	return $bet_money;
}
function get_CGFS($bet_money)
{
	return $bet_money;
}
function getColor_u($num)
{
	if ($num == 0)
	{
		return '#009900';
	}
	else if ($num == 1)
	{
		return '#FF9900';
	}
	else if ($num == 2)
	{
		return '#FF99FF';
	}
	else if ($num == 3)
	{
		return '#0099FF';
	}
}
function logout_msg($message)
{	
	global $mydata1_db;
	$params = array(':uid' => intval($_SESSION['adminid']));
	$sql = 'update mydata3_db.sys_admin set is_login=0 where is_login=1 and uid=:uid';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$_SESSION = array();
	if (isset($_COOKIE[session_name()]))
	{
		setcookie(session_name(), '', time() - 42000, '/');
	}
	$_SESSION = array();
	session_destroy();
	$res = explode("/",$_SERVER['REQUEST_URI']);
	defined('ADMIN_PATH') or define('ADMIN_PATH', $res[1]);
	echo "<script>alert('".$message."');top.location.href='/".ADMIN_PATH."/index.html';</script>";
	exit();
}