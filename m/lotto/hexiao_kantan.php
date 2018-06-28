<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/login_check.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '_pankouinfo.php';
if ((strtotime($Current_KitheTable['zfbdate']) - strtotime(date('Y-m-d H:i:s')) <= 0) || ($Current_KitheTable['zfb'] == 0) || ($nodata == 1)){
	echo '<script type="text/javascript">alert("已封盘");window.location.href="/m/lotto/index.php";</script>';
	exit();
}
include_once 'common.php';
checkSum();

$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$class1 = $_POST['class1'];
$class2 = $_POST['class2'];
$number = $_POST['number'];
$money = $_POST['gold'];
$allclass1 = array('特码', '正码', '正特', '正1-6', '生肖', '正特尾数', '半波');
$allclass2 = array('一肖', '二肖', '三肖', '四肖', '五肖', '六肖', '七肖', '八肖', '九肖', '十肖', '十一肖');
if (!in_array($class1, $allclass1)){
	echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}else if ($class1 == '生肖'){
	if (!in_array($class2, $allclass2)){
		echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
		exit();
	}
}

if (!preg_match('/^[1-9]\\d*$/', $money)){
	echo '<script type="text/javascript">alert("请输入合法的金额！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}

$zodiac = array('鼠', '虎', '龙', '马', '猴', '狗', '牛', '兔', '蛇', '羊', '鸡', '猪');
$tempclass = '六肖';
$shuzulenth = 2;
getclasslength($class2);
if (count(explode(',', $number)) != $shuzulenth){
	echo '<script type="text/javascript">alert("非法下注");window.location.href="/m/lotto/index.php";</script>';
	exit();
}

if (isset($number)){
	$bet_array = explode(',', $number);
	
	for ($i = 0;$i < count($bet_array);$i++){
		if (!illegeelement($bet_array[$i])){
			echo '<script type="text/javascript">alert("非法下注");window.location.href="/m/lotto/index.php";</script>';
			exit();
		}
	}
	
	if (isrepeat($bet_array)){
		echo '<script type="text/javascript">alert("非法下注");window.location.href="/m/lotto/index.php";</script>';
		exit();
	}
}

$peilv_array = array();
$stmt = querypeilv($class1, $class2);
while ($rows = $stmt->fetch()){
	$peilv_array[$rows['class3']] = $rows['rate'];
}
$bet_array = array();
$bet_palv = array();
if (isset($number)){
	$bet_array = explode(',', $number);
	
	for ($i = 0;$i < count($bet_array);$i++){
		if (!array_key_exists($bet_array[$i], $peilv_array)){
			echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
			exit();
		}
		array_push($bet_palv, $peilv_array[$bet_array[$i]]);
	}
}
sort($bet_palv);
$allmoney = 0;
$user_ds = 0;
if (0 < $money){
	if ($money < $cp_zd){
		echo '<script type="text/javascript">alert("最小下注金额为：'.$cp_zd.'");window.location.href="/m/lotto/index.php";</script>';
		exit();
	}
	
	if ($cp_zg < $money){
		echo '<script type="text/javascript">alert("最高下注金额为：'.$cp_zg.'");window.location.href="/m/lotto/index.php";</script>';
		exit();
	}
}
$allmoney = $money;
$params = array(':class2' => $tempclass);
$stmt = $mydata1_db->prepare('Select ds,yg,xx,xxx,ygb,ygc,ygd from mydata2_db.ka_quota where username=\'gd\' and ds=:class2 limit 1');
$stmt->execute($params);if ($row = $stmt->fetch())
{
	$user_ds = $row['yg'];
}
$memid = 0;
$params = array(':kauser' => $_SESSION['username']);
$stmt = $mydata2_db->prepare('select id from ka_mem where kauser=:kauser order by id desc');
$stmt->execute($params);
$row = $stmt->fetch();
if ($_SESSION['username']){
	$memid = $row['id'];
}
$userinfo = user::getinfo($uid);
if ($userinfo['money'] < $allmoney){
	echo '<script type="text/javascript">alert("对不起，下注总额不能大于可用信用额");window.location.href="/m/lotto/index.php";</script>';
	exit();
}else{
	$params = array(':money' => $allmoney, ':username' => $_SESSION['username']);
	$sql = 'update k_user set money=money-:money where username=:username limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$previousAmount = $userinfo['money'];
	$currentAmount = $previousAmount - $allmoney;
	$num = randStr();
	$adddate = date('Y-m-d H:i:s', time() + (12 * 3600));
	$params = array(':num' => $num, ':username' => $_SESSION['username'], ':kithe' => $Current_Kithe_Num, ':adddate' => $adddate, ':class1' => $class1, ':class2' => $class2, ':class3' => $number, ':rate' => $bet_palv[0], ':sum_m' => $money, ':user_ds' => $user_ds, ':dai_ds' => 0, ':zong_ds' => 0, ':guan_ds' => 0, ':dai_zc' => 0, ':zong_zc' => 0, ':guan_zc' => 0, ':dagu_zc' => 0, ':bm' => 0, ':dai' => 'daili', ':zong' => 'zong', ':guan' => 'guan', ':memid' => $memid, ':danid' => 3, ':zongid' => 2, ':guanid' => 1, ':abcd' => 'A', ':lx' => 0);
	$stmt = $mydata2_db->prepare('INSERT INTO ka_tan set  num=:num, username=:username, kithe=:kithe, adddate=:adddate, class1=:class1, class2=:class2, class3=:class3, rate=:rate, sum_m=:sum_m, user_ds=:user_ds, dai_ds=:dai_ds, zong_ds=:zong_ds, guan_ds=:guan_ds, dai_zc=:dai_zc, zong_zc=:zong_zc, guan_zc=:guan_zc, dagu_zc=:dagu_zc, bm=:bm, dai=:dai, zong=:zong, guan=:guan, memid=:memid, danid=:danid, zongid=:zongid, guanid=:guanid, abcd=:abcd, lx=:lx');
	$stmt->execute($params);
	$params = array(':uid' => $userinfo['uid'], ':userName' => $userinfo['username'], ':transferOrder' => 'm_' . $num, ':transferAmount' => $money, ':previousAmount' => $previousAmount, ':currentAmount' => $currentAmount, ':creationTime' => date('Y-m-d H:i:s', time()));
	$stmt = $mydata1_db->prepare('insert into k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) values(:uid,:userName,\'SIX\',\'BET\',:transferOrder,-:transferAmount,:previousAmount,:currentAmount,:creationTime)');
	$stmt->execute($params);
	$previousAmount = $currentAmount;
}
echo '<script type="text/javascript">alert("下注成功");window.location.href="/m/lotto/index.php";</script>';
exit();
function isRepeat($array)
{
	if (isset($array))
	{
		if (count($array) == count(array_unique($array)))
		{
			return false;
		}
	}
	return true;
}
function illegeElement($str)
{
	global $zodiac;
	if (in_array($str, $zodiac))
	{
		return true;
	}
	return false;
}
function getClassLength($class2)
{
	global $shuzulenth;
	global $tempclass;
	switch ($class2)
	{
		case '二肖': $shuzulenth = 2;
		$tempclass = $class2;
		break;
		case '三肖': $shuzulenth = 3;
		$tempclass = $class2;
		break;
		case '四肖': $shuzulenth = 4;
		$tempclass = $class2;
		break;
		case '五肖': $shuzulenth = 5;
		$tempclass = $class2;
		break;
		case '六肖': $shuzulenth = 6;
		$tempclass = $class2;
		break;
		case '七肖': $shuzulenth = 7;
		break;
		case '八肖': $shuzulenth = 8;
		break;
		case '九肖': $shuzulenth = 9;
		break;
		case '十肖': $shuzulenth = 10;
		break;
		case '十一肖': $shuzulenth = 11;
	}
}
function queryPeilv($class1, $class2)
{
	global $mydata1_db;
	$params = array(':class1' => $class1, ':class2' => $class2);
	$stmt = $mydata1_db->prepare('select class3,rate from mydata2_db.ka_bl where  class1=:class1 and class2=:class2 order by id');
	$stmt->execute($params);
	return $stmt;
}?>