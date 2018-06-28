<?php 
$ftime = 178000;
$row = $mydata2_db->query('select * from config')->fetch();
$btm = $row['btm'];
$ctm = $row['ctm'];
$dtm = $row['dtm'];
$btmdx = $row['btmdx'];
$ctmdx = $row['ctmdx'];
$dtmdx = $row['dtmdx'];
$bzt = $row['bzt'];
$czt = $row['czt'];
$dzt = $row['dzt'];
$bztdx = $row['bztdx'];
$cztdx = $row['cztdx'];
$dztdx = $row['dztdx'];
$bzm = $row['bzm'];
$czm = $row['czm'];
$dzm = $row['dzm'];
$bzmdx = $row['bzmdx'];
$czmdx = $row['czmdx'];
$dzmdx = $row['dzmdx'];
$bth = $row['bth'];
$cth = $row['cth'];
$dth = $row['dth'];
$bthdx = $row['bthdx'];
$cthdx = $row['cthdx'];
$dthdx = $row['dthdx'];
$bzm6 = $row['bzm6'];
$czm6 = $row['czm6'];
$dzm6 = $row['dzm6'];
$bsx = $row['bsx'];
$csx = $row['csx'];
$dsx = $row['dsx'];
$bsx6 = $row['bsx6'];
$csx6 = $row['csx6'];
$dsx6 = $row['dsx6'];
$bsxp = $row['bsxp'];
$csxp = $row['csxp'];
$dsxp = $row['dsxp'];
$bbb = $row['bbb'];
$cbb = $row['cbb'];
$dbb = $row['dbb'];
$bzx = $row['bzx'];
$czx = $row['czx'];
$dzx = $row['dzx'];
$blx = $row['blx'];
$clx = $row['clx'];
$dlx = $row['dlx'];
$jifei = $row['jifei'];
$iszhudan = $row['iszhudan'];
$keykey = gethostbyaddr('127.0.0.1');
$keyon = 'ka-' . $keykey;
$keym = md5($keyon);
$Current_Kithe_Num = 1;
$Current_KitheTable = $mydata2_db->query('Select id,nn,nd,na,n1,n2,n3,n4,n5,n6,lx,kitm,kitm1,kizt,kizt1,kizm,kizm1,kizm6,kizm61,kigg,kigg1,kilm,kilm1,kisx,kisx1,kibb,kibb1,kiws,kiws1,zfb,zfbdate,zfbdate1,best From ka_kithe where na=0 Order By id Desc LIMIT 1')->fetch();
$nodata = 0;
if ($Current_KitheTable[0] == '')
{
	$nodata = 1;
}
if (($Current_KitheTable[3] == 0) || ($Current_KitheTable[4] == 0) || ($Current_KitheTable[5] == 0) || ($Current_KitheTable[6] == 0) || ($Current_KitheTable[7] == 0) || ($Current_KitheTable[8] == 0) || ($Current_KitheTable[9] == 0))
{
	$Current_Kithe_Num = $Current_KitheTable[1];
}
else
{
	$Current_Kithe_Num = $Current_KitheTable[1] + 1;
}
$kitheId = intval($Current_KitheTable[0]);
if ($nodata == 0)
{
	if (strtotime($Current_KitheTable[30]) - strtotime(date('Y-m-d H:i:s')) <= 0)
	{
		$mydata2_db->exec('Update ka_kithe Set kitm=0,kizt=0,kizm=0,kizm6=0,kigg=0,kiws=0,kilm=0,kisx=0,kibb=0,zfb=0 where id=\'' . $kitheId . '\'');
	}
	if (strtotime($Current_KitheTable[31]) - strtotime(date('Y-m-d H:i:s')) <= 0)
	{
		if ($Current_KitheTable[32] == 1)
		{
			$mydata2_db->exec('Update ka_kithe Set kitm=1,kizt=1,kizm=1,kizm6=1,kigg=1,kiws=1,kilm=1,kisx=1,kibb=1,zfb=1,best=0 where id=\'' . $kitheId . '\'');
		}
	}
	if ($Current_KitheTable[29] == 1)
	{
		if (strtotime($Current_KitheTable[12]) - strtotime(date('Y-m-d H:i:s')) <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kitm=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable[14]) - strtotime(date('Y-m-d H:i:s')) <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kizt=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable[16]) - strtotime(date('Y-m-d H:i:s')) <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kizm=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable[18]) - strtotime(date('Y-m-d H:i:s')) <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kizm6=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable[20]) - strtotime(date('Y-m-d H:i:s')) <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kigg=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable[22]) - strtotime(date('Y-m-d H:i:s')) <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kilm=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable[24]) - strtotime(date('Y-m-d H:i:s')) <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kisx=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable[26]) - strtotime(date('Y-m-d H:i:s')) <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kibb=0 where id=\'' . $kitheId . '\'');
		}
		if (strtotime($Current_KitheTable[28]) - strtotime(date('Y-m-d H:i:s')) <= 0)
		{
			$mydata2_db->exec('Update ka_kithe Set kiws=0 where id=\'' . $kitheId . '\'');
		}
	}
}
function randStr($len = 12)
{
	$chars = '0123456789';
	mt_srand((double) microtime() * 1000000 * getmypid());
	$password = '';
	while (strlen($password) < $len)
	{
		$password .= substr($chars, mt_rand() % strlen($chars), 1);
	}
	return $password;
}
function ka_config($i)
{
	global $mydata2_db;
	$ka_config1 = $mydata2_db->query('Select id,webname,weburl,tm,tmdx,tmps,zm,zmdx,ggpz,sanimal,affice,fenb,haffice2,a1,a2,a3,a10,opwww From config')->fetch();
	return $ka_config1[$i];
}
function ka_bl($i, $b)
{
	$i = intval($i);
	global $mydata2_db;
	$ka_config5 = $mydata2_db->query('Select * From ka_bl where id=\'' . $i . '\'')->fetch();
	return $ka_config5[$b];
}
function ka_bl_row($i)
{
	$i = intval($i);
	global $mydata2_db;
	$ka_config5 = $mydata2_db->query('Select * From ka_bl where id=\'' . $i . '\'')->fetch();
	return $ka_config5;
}
function ka_guands($i, $b)
{
	global $mydata2_db;
	$params = array(':username' => $_SESSION['kauser']);
	$stmt = $mydata2_db->prepare('Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username=:username order by id');
	$stmt->execute($params);
	$drop_guands = array();
	$y = 0;
	while ($image = $stmt->fetch())
	{
		$y++;
		array_push($drop_guands, $image);
	}
	return $drop_guands[$i][$b];
}
function ka_memds($i, $b)
{
	global $mydata2_db;
	$result = $mydata2_db->query('Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username=\'gd\' order by id');
	$drop_guands = array();
	$y = 0;
	while ($image = $result->fetch())
	{
		$y++;
		array_push($drop_guands, $image);
	}
	return $drop_guands[$i][$b];
}
function ka_memds_row($i)
{
	global $mydata2_db;
	$result = $mydata2_db->query('Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username=\'gd\' order by id');
	$drop_guands = array();
	$y = 0;
	while ($image = $result->fetch())
	{
		$y++;
		array_push($drop_guands, $image);
	}
	return $drop_guands[$i];
}
function ka_guanuser($i)
{
	global $mydata2_db;
	$params = array(':kauser' => $_SESSION['kauser']);
	$stmt = $mydata2_db->prepare('select * from ka_guan where kauser=:kauser order by id desc');
	$stmt->execute($params);
	$ka_guanuser1 = $stmt->fetch();
	return $ka_guanuser1[$i];
}
function ka_guansds($i, $b)
{
	$guanss = ka_guanuser('guan');
	global $mydata2_db;
	$params = array(':username' => $guanss);
	$stmt = $mydata2_db->prepare('Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username=:username order by id');
	$stmt->execute($params);
	$drop_guansds = array();
	$y = 0;
	while ($image = $stmt->fetch())
	{
		$y++;
		array_push($drop_guansds, $image);
	}
	return $drop_guansds[$i][$b];
}
function ka_zongds($i, $b)
{
	$guanss = ka_guanuser('zong');
	global $mydata2_db;
	$params = array(':username' => $guanss);
	$stmt = $mydata2_db->prepare('Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username=:username order by id');
	$stmt->execute($params);
	$drop_zongds = array();
	$y = 0;
	while ($image = $stmt->fetch())
	{
		$y++;
		array_push($drop_zongds, $image);
	}
	return $drop_zongds[$i][$b];
}
function ka_memuser($i)
{
	global $mydata2_db;
	$params = array(':kauser' => $_SESSION['username']);
	$stmt = $mydata2_db->prepare('select * from ka_mem where kauser=:kauser order by id desc');
	$stmt->execute($params);
	$ka_guanuser1 = $stmt->fetch();
	if ($_SESSION['username'])
	{
		return $ka_guanuser1[$i];
	}
	else
	{
		return 0;
	}
}
function Get_sx_Color($rrr)
{
	global $mydata2_db;
	$params = array(':m_number' => '%' . $rrr . '%');
	$stmt = $mydata2_db->prepare('Select id,m_number,sx From ka_sxnumber where m_number LIKE :m_number and id<=12 Order By id LIMIT 1');
	$stmt->execute($params);
	$ka_Color1 = $stmt->fetch();
	return $ka_Color1['sx'];
}
function Get_bs_Color($i)
{
	global $mydata2_db;
	$i = intval($i);
	$ka_configg = $mydata2_db->query('Select id,color From ka_color where id=\'' . $i . '\' Order By id')->fetch();
	return $ka_configg['color'];
}
function ka_Color_s($i)
{
	global $mydata2_db;
	$i = intval($i);
	$ka_configg = @($mydata2_db->query('Select id,color From ka_color where id=\'' . $i . '\' Order By id')->fetch());
	if ($ka_configg['color'] == 'r')
	{
		$bscolor = '红波';
	}
	if ($ka_configg['color'] == 'b')
	{
		$bscolor = '蓝波';
	}
	if ($ka_configg['color'] == 'g')
	{
		$bscolor = '绿波';
	}
	return $bscolor;
}
function Get_sx2_Color($rrr)
{
	global $mydata2_db;
	$params = array(':sx' => $rrr);
	$stmt = $mydata2_db->prepare('Select id,m_number,sx From ka_sxnumber where sx=:sx and id<=12 Order By ID LIMIT 1');
	$stmt->execute($params);
	$ka1_Color1 = $stmt->fetch();
	return $ka1_Color1['m_number'];
}?>