<?php 
header('content-Type: text/html;charset=utf-8');
$Current_Kithe_Num = 1;
$Current_KitheTable = $mydata2_db->query('Select id,nn,nd,na,n1,n2,n3,n4,n5,n6,lx,kitm,kitm1,kizt,kizt1,kizm,kizm1,kizm6,kizm61,kigg,kigg1,kilm,kilm1,kisx,kisx1,kibb,kibb1,kiws,kiws1,zfb,zfbdate,zfbdate1,best From ka_kithe where na=0 Order By id Desc LIMIT 1')->fetch();
$nodata = 0;
if ($Current_KitheTable['id'] == '')
{
	$nodata = 1;
}
if (($Current_KitheTable['na'] == 0) || ($Current_KitheTable['n1'] == 0) || ($Current_KitheTable['n2'] == 0) || ($Current_KitheTable['n3'] == 0) || ($Current_KitheTable['n4'] == 0) || ($Current_KitheTable['n5'] == 0) || ($Current_KitheTable['n6'] == 0))
{
	$Current_Kithe_Num = $Current_KitheTable['nn'];
}
else
{
	$Current_Kithe_Num = $Current_KitheTable['nn'] + 1;
}
$kitheId = intval($Current_KitheTable['id']);
if ($nodata == 0)
{
	if (strtotime($Current_KitheTable['zfbdate']) - time()-43200 <= 0)
	{
		$mydata2_db->exec('Update ka_kithe Set kitm=0,kizt=0,kizm=0,kizm6=0,kigg=0,kiws=0,kilm=0,kisx=0,kibb=0,zfb=0 where id=\'' . $kitheId . '\'');
	}
	if (strtotime($Current_KitheTable['zfbdate1']) - time()-43200 <= 0)
	{
		if ($Current_KitheTable['best'] == 1)
		{
			$mydata2_db->exec('Update ka_kithe Set kitm=1,kizt=1,kizm=1,kizm6=1,kigg=1,kiws=1,kilm=1,kisx=1,kibb=1,zfb=1,best=0 where id=\'' . $kitheId . '\'');
		}
	}
	if ($Current_KitheTable['zfb'] == 1)
	{
		if (strtotime($Current_KitheTable['kitm1']) - time()-43200 <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kitm=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable['kizt1']) - time()-43200 <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kizt=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable['kizm1']) - time()-43200 <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kizm=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable['kizm61']) - time()-43200 <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kizm6=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable['kigg1']) - time()-43200 <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kigg=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable['kilm1']) - time()-43200 <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kilm=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable['kisx1']) - time()-43200 <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kisx=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable['kibb1']) - time()-43200 <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kibb=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable['kiws1']) - time()-43200 <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kiws=0 where id=\'' . $kitheId . '\'');
		}
	}
}
$Lastest_KitheTable = $mydata2_db->query('SELECT nn,nd,na,n1,n2,n3,n4,n5,n6,sx,x1,x2,x3,x4,x5,x6 FROM ka_kithe WHERE na>0 ORDER BY nn DESC LIMIT 1');
if($Lastest_KitheTable->rowCount()>0){
	$Lastest_KitheTable = $Lastest_KitheTable->fetch();
	$Lastest_KitheTable['na'] = substr('0'.$Lastest_KitheTable['na'], -2);
	$Lastest_KitheTable['n1'] = substr('0'.$Lastest_KitheTable['n1'], -2);
	$Lastest_KitheTable['n2'] = substr('0'.$Lastest_KitheTable['n2'], -2);
	$Lastest_KitheTable['n3'] = substr('0'.$Lastest_KitheTable['n3'], -2);
	$Lastest_KitheTable['n4'] = substr('0'.$Lastest_KitheTable['n4'], -2);
	$Lastest_KitheTable['n5'] = substr('0'.$Lastest_KitheTable['n5'], -2);
	$Lastest_KitheTable['n6'] = substr('0'.$Lastest_KitheTable['n6'], -2);
}else{
	$Lastest_KitheTable = array(
		'nn' => '0000000',
		'na' => '--',
		'n1' => '--',
		'n2' => '--',
		'n3' => '--',
		'n4' => '--',
		'n5' => '--',
		'n6' => '--',
		'sx' => '--',
		'x1' => '--',
		'x2' => '--',
		'x3' => '--',
		'x4' => '--',
		'x5' => '--',
		'x6' => '--',
	);
}
include_once '../../cache/group_' . @($_SESSION['gid']) . '.php';
$cp_zd = @($pk_db['彩票最低']);
$cp_zg = @($pk_db['彩票最高']);
if (0 < $cp_zd){
	$cp_zd = $cp_zd;
}else{
	$cp_zd = 10;
}

if (0 < $cp_zg){
	$cp_zg = $cp_zg;
}else{
	$cp_zg = 1000000;
}

function randStr($len = 12){
	$chars = '0123456789';
	mt_srand((double) microtime() * 1000000 * getmypid());
	$password = '';
	while (strlen($password) < $len)
	{
		$password .= substr($chars, mt_rand() % strlen($chars), 1);
	}
	return $password;
}