<?php 
header('content-Type: text/html;charset=utf-8');
define('PHPYOU_VER', 'v1.1');
define('PHPYOU', __FILE__ ? getdirname(__FILE__) . '/' : './');
include_once '../../include/config.php';
require_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
if (function_exists('date_default_timezone_set')){
	date_default_timezone_set('Etc/GMT-8');
}
$timestamp = time();
unset($_ENV);
unset($HTTP_ENV_VARS);
unset($_REQUEST);
unset($HTTP_POST_VARS);
unset($HTTP_GET_VARS);
unset($HTTP_POST_FILES);
unset($HTTP_COOKIE_VARS);
if (!ini_get('register_globals'))
{
	extract($_GET, EXTR_SKIP);
	extract($_POST, EXTR_SKIP);
}
$rewrite_enable = $_FCACHE['settings']['ifrewrite'];
if ($rewrite_enable)
{
	if (function_exists('apache_get_modules'))
	{
		$apache_mod = apache_get_modules();
		if (!in_array('mod_rewrite', $apache_mod))
		{
			$rewrite_enable = 0;
		}
	}
}
session_start();
$admin_info = 0;
if ($_SESSION['superadmin'] && $_SESSION['flag'])
{
	$admin_info = 1;
}
$admin_info1 = 0;
if ($_SESSION['kauser'] && $_SESSION['lx'])
{
	$admin_info1 = 1;
}
$admin_info2 = 0;
if ($_SESSION['username'])
{
	$admin_info2 = 1;
}
$ip = get_client_ip();
$usernamess = '游客';
$lxtj = 0;
if ($_SESSION['superadmin'] != '')
{
	$usernamess = $_SESSION['superadmin'];
	$lxtj = 3;
}
if ($_SESSION['kauser'] != '')
{
	$usernamess = $_SESSION['kauser'];
	$lxtj = 2;
}
if ($_SESSION['username'] != '')
{
	$usernamess = $_SESSION['username'];
	$lxtj = 1;
}
$text = date('Y-m-d H:i:s');
$ddf = date('Y-m-d H:i:s', time() - 200);
$params = array(':adddate' => $ddf);
$stmt = $mydata2_db->prepare('delete from tj where adddate<:adddate');
$stmt->execute($params);
$params = array(':ip' => $ip, ':username' => $usernamess);
$stmt = $mydata2_db->prepare('select count(*) from tj where ip=:ip and username=:username order by id desc');
$stmt->execute($params);
$num = $stmt->fetchColumn();
if ($num != 0)
{
	$params = array(':adddate' => $text, ':zt' => $lxtj, ':username' => $usernamess, ':username2' => $usernamess, ':ip' => $ip);
	$stmt = $mydata2_db->prepare('update tj set adddate=:adddate,zt=:zt,username=:username where username=:username2 and ip=:ip');
	$stmt->execute($params);
}
else
{
	$params = array(':adddate' => $text, ':adddate2' => $text, ':username' => $usernamess, ':zt' => $lxtj, ':ip' => $ip);
	$stmt = $mydata2_db->prepare('INSERT INTO tj set addate=:adddate,adddate=:adddate2,username=:username,zt=:zt,ip=:ip');
	$stmt->execute($params);
}
$q = 1117;
if ($usernamess != '游客')
{
	$params = array(':ip' => $ip);
	$stmt = $mydata2_db->prepare('delete from tj where ip=:ip and zt=0');
	$stmt->execute($params);
}

function pr($a)
{
	echo "<pre style='text-align:left'>".print_r($a)."</pre>";
}

function getdirname($path)
{
	if (strpos($path, '\\') !== false)
	{
		return substr($path, 0, strrpos($path, '\\'));
	}
	else if (strpos($path, '/') !== false)
	{
		return substr($path, 0, strrpos($path, '/'));
	}
	else
	{
		return '/';
	}
}
function SubmitCheck($var = '')
{
	if (empty($_POST))
	{
		return false;
	}
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && (empty($_SERVER['HTTP_REFERER']) || (preg_replace('/https?:\\/\\/([^\\:\\/]+).*/i', '\\1', $_SERVER['HTTP_REFERER']) == preg_replace('/([^\\:]+).*/', '\\1', $_SERVER['HTTP_HOST']))))
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>