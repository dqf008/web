<?php
defined('API') or die('Access Denied');
function autoload($class){
    $path = __DIR__ . '/../class/live/' . $class . '.class.php';
    if (file_exists($path)) require_once $path;
    else die('{}');
}
spl_autoload_register('autoload');
$act = $params[2];
switch ($act) {
	case 'refresh':
		refresh($params[3]);
		break;
	case 'open':
		open($params[3], $params[4]);
		break;
	default:
		
		break;
}

function refresh($class){
	$uid = (int)$_SESSION["uid"];
	if($uid<1) die();
	$class = strtoupper($class);
	$class == 'BGLIVE' && $class = 'BG';
	if(in_array($class, ['AGIN', 'AG', 'PT', 'SHABA', 'IPM', 'OG', 'BBIN'])) $c = new AG($class);
	else $c = new $class();
	$res = $c->money($uid);
	if(empty($res['err'])){
		$data['code'] = '00';
		$data['money'] = $res;
	}else{
		$data['code'] = '01';
		$data['msg'] = $res['err'];
	}
	die(json_encode($data));
}

function open($type, $gameId, $isMobile){

}
