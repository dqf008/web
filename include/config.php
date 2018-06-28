<?php 
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
//$C_Patch = dirname(dirname(__FILE__));
include_once $C_Patch . '/cache/website.php';
include_once __DIR__ . '/../cache/conf.php';
require_once __DIR__ . '/../common/commonfun.php';
//require_once __DIR__ . '/../360safe/360webscan.php';

if(isset($_SESSION['site']) && $_SESSION['site']!=""){
	$res = strstr($_SESSION['site'], '柬埔寨'); 
	if($res!=""){
		//display_error_exit('对不起，您所在的地区或IP暂时无法访问，请稍后重试');
	}
}

function website_close()
{
	global $web_site;
	if ($web_site['close'] == 1)
	{
		echo "<script>top.location.href='/close.php';</script>";
		exit();
	}
}
function website_deny()
{
	/*global $C_Patch;
	include_once $C_Patch . '/ip.php';
	include_once $C_Patch . '/cache/dqxz.php';
	include_once $C_Patch . '/common/commonfun.php';
	$client_ip = get_client_ip();
	$address = '=' . iconv('GB2312', 'UTF-8', convertip($client_ip, $C_Patch . '/'));
	foreach ($dqxz as $k => $v)
	{
		if (strpos($address, $v) || strpos('=' . $client_ip, $v))
		{
			display_error_exit('对不起，您所在的地区或IP暂时无法访问，请稍后重试');
		}
	}*/
}
/*
if(strtolower($_SERVER['SCRIPT_NAME'])=='/index.php'&&file_exists($C_Patch.'/cache/packets.php')){
	$packets = array();
	$packets['return'] = false;
	$packets['host'] = strtolower($_SERVER['HTTP_HOST']);
	$packets['domain'] = include($C_Patch.'/cache/packets.php');
	foreach($packets['domain'] as $domain){
		$domain = explode('*', $domain);
		if(count($domain)>1){
			$packets['last'] = 0;
			foreach($domain as $key=>$val){
				if($val!=''){
					$key = stripos($packets['host'], $val, $packets['last']);
					if($key===false){
						$packets['return'] = false;
						break;
					}else{
						$packets['return'] = true;
						$packets['last']+= $key+strlen($val);
					}
				}
			}
		}else{
			$packets['return'] = strtolower($domain[0])==$packets['host'];
		}
		if($packets['return']){
			break;
		}
	}
	if($packets['return']){
		session_start();
		website_close();
		website_deny();
		define('IN_PACKETS', './packets/');
		include_once $C_Patch.'/database/mysql.config.php';
		include($C_Patch.'/packets/packets.php');
		exit;
	}
	unset($packets, $domain, $key, $val);
}
*/