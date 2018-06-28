<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once 'reload_config.php';
$services = array();
$services[0] = 'ty1.jieshuiwt.com';
$services[1] = 'ty2.jieshuiwt.com';
$services[2] = 'ty3.jieshuiwt.com';
$services[3] = 'ty4.jieshuiwt.com';
$services[4] = 'ty1.agvlive.com';
$services[5] = 'ty2.agvlive.com';
$services[6] = 'ty3.agvlive.com';
$services[7] = 'ty4.agvlive.com';
$randarr = $services;
$arrcur = array();
$arrcur = get_service();
try{
	$soapUrl = 'http://' . $arrcur[0] . '/SportsJSON.asmx?WSDL';
	$objSoapClient = new SoapClient($soapUrl);
	$out = $objSoapClient->HelloWorld();
	$data = $out->HelloWorldResult;
}catch (Exception $ex){
	$data = 'error';
}

while (($i < count($services)) && ($data == 'error')){
	try{
		$soapUrl = 'http://' . $arrcur[0] . '/SportsJSON.asmx?WSDL';
		$objSoapClient = new SoapClient($soapUrl);
		$out = $objSoapClient->HelloWorld();
		$data = $out->HelloWorldResult;
	}catch (Exception $ex){
		$data = 'error';
		$i++;
		$arrcur = fetch_nextservice();
	}
}
$arryparam = array();
$arryparam['siteNo'] = $siteno;

function get_service(){
	global $mydata1_db;
	$sql = 'select cpservice,cpsid,COOKIE from mydata3_db.sys_admin limit 0,1';
	$query = $mydata1_db->query($sql);
	$row = array();
	$row = $query->fetch();
	global $randarr;
	$arrcur = array();
	if ($row[0] == ''){
		$randno = array_rand($randarr, 1);
		$arrcur[0] = $randarr[$randno];
		$arrcur[1] = $randno;
		$arrcur[2] = '';
		update_service($arrcur[0], $arrcur[1]);
		unset($randarr[$randno]);
	}else{
		$arrcur[0] = $row[0];
		$arrcur[1] = $row[1];
		$arrcur[2] = $row[2];
		unset($randarr[$row[1]]);
	}
	return $arrcur;
}

function update_service($cuservice, $curid){
	global $mydata1_db;
	$params = array(':cpservice' => $cuservice, ':cpsid' => $curid);
	$sql = 'update mydata3_db.sys_admin set cpservice=:cpservice,cpsid=:cpsid,COOKIE=\'\'';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
}

function fetch_nextservice(){
	global $randarr;
	$randno = array_rand($randarr, 1);
	update_service($randarr[$randno], $randno);
	$arrcur = array();
	$arrcur[0] = $randarr[$randno];
	$arrcur[1] = $randno;
	$arrcur[2] = '';
	unset($randarr[$randno]);
	return $arrcur;
}

?>