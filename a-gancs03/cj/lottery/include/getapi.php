<?php session_start();
$services = array();
$services[0] = 'api1.jieshuiwt.com';
$services[1] = 'api2.jieshuiwt.com';
$services[2] = 'api1.agvlive.com';
$services[3] = 'api2.agvlive.com';
$randarr = $services;
$arrcur = array();
$arrcur = get_service();
$curl = new Curl_HTTP_Client();
$url = 'http://' . $arrcur[1] . '/ok.php?_t=' . time();
$data = @($curl->fetch_url($url));
if ($data != '1')
{
	$data = 'error';
}
$i = 1;
while (($i < count($services)) && ($data == 'error'))
{
	$url = 'http://' . $arrcur[1] . '/ok.php?_t=' . time();
	$data = @($curl->fetch_url($url));
	if ($data != '1')
	{
		$data = 'error';
		$i++;
		$arrcur = fetch_nextservice();
	}
}
function get_service()
{
	global $randarr;
	$arrcur = array();
	$arrcur[0] = $_SESSION['apiid'];
	$lineurl = $randarr[$arrcur[0]];
	if ($lineurl)
	{
		$arrcur[1] = $randarr[$arrcur[0]];
		unset($randarr[$arrcur[0]]);
	}
	else
	{
		$randno = array_rand($randarr, 1);
		$arrcur[0] = $randno;
		$arrcur[1] = $randarr[$randno];
		$_SESSION['apiid'] = $randno;
		unset($randarr[$randno]);
	}
	return $arrcur;
}
function fetch_nextservice()
{
	global $randarr;
	$randno = array_rand($randarr, 1);
	$arrcur = array();
	$arrcur[0] = $randno;
	$arrcur[1] = $randarr[$randno];
	$_SESSION['apiid'] = $randno;
	unset($randarr[$randno]);
	return $arrcur;
}?>