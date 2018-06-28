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
$number = $_POST['number1'];
$money = $_POST['gold'];
$zushu = $_POST['zushu'];
$allclass1 = array('特码', '正码', '正特', '正1-6', '生肖', '正特尾数', '半波', '生肖连');
$allclass2 = array('二肖连中', '三肖连中', '四肖连中', '五肖连中', '二肖连不中', '三肖连不中', '四肖连不中');
if (!in_array($class1, $allclass1)){
	echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}else if ($class1 == '生肖连'){
	if (!in_array($class2, $allclass2)){
		echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
		exit();
	}
}
$shuzulenth = 2;
getclasslength($class2);
if (!preg_match('/^[1-9]\\d*$/', $money)){
	echo '<script type="text/javascript">alert("请输入合法的金额！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}
$zodiac = array('鼠', '虎', '龙', '马', '猴', '狗', '牛', '兔', '蛇', '羊', '鸡', '猪');
if (intval($zushu) != count(explode('/', $number))){//这边判断出错
	echo '<script type="text/javascript">alert("非法下注!");window.location.href="/m/lotto/index.php";</script>';
	exit();
}

if (isset($number)){
	$zuhe_array = explode('/', $number);
	if (isrepeat($zuhe_array)){
		echo '<script type="text/javascript">alert("非法下注!");window.location.href="/m/lotto/index.php";</script>';
		exit();
	}else{
		for ($i = 0;$i < count($zuhe_array);$i++){
			$element_array = explode(',', $zuhe_array[$i]);
			if (isrepeat($element_array)){
				echo '<script type="text/javascript">alert("非法下注!");window.location.href="/m/lotto/index.php";</script>';
				exit();
			}
			if (count($element_array) != $shuzulenth){
				echo '<script type="text/javascript">alert("非法下注!");window.location.href="/m/lotto/index.php";</script>';
				exit();
			}
		}
	}
	
	for ($m = 0;$m < count($zuhe_array);$m++){
		$element_array = explode(',', $zuhe_array[$m]);
		
		for ($n = 0;$n < count($element_array);$n++){
			if (!illegeelement($element_array[$n])){
				echo '<script type="text/javascript">alert("非法下注!");window.location.href="/m/lotto/index.php";</script>';
				exit();
			}
		}
	}
}

$peilv_array = array();
$stmt = querypeilv($class1, $class2);
while ($rows = $stmt->fetch()){
	$peilv_array[$rows['class3']] = $rows['rate'];
}
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
$allmoney = $money * $zushu;
$params = array(':class2' => $class2);
$stmt = $mydata1_db->prepare('Select ds,yg,xx,xxx,ygb,ygc,ygd from mydata2_db.ka_quota where username=\'gd\' and ds=:class2 limit 1');
$stmt->execute($params);
if ($row = $stmt->fetch()){
	$user_ds = $row['yg'];
}
$memid = 0;
$params = array(':kauser' => $_SESSION['username']);
$stmt = $mydata2_db->prepare('select id from ka_mem where kauser=:kauser order by id desc');
$stmt->execute($params);
$row = $stmt->fetch();
if ($_SESSION['username'])
{
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
	$bet_array = array();
	if (isset($number)){
		$bet_array = explode('/', $number);
		$bet_array_length = count($bet_array);
		for ($i = 0;$i < $bet_array_length;$i++){
			$num = randStr();
			$adddate = date('Y-m-d H:i:s', time() + (12 * 3600));
			$current_rate = getrightrate($bet_array[$i]);
			$params = array(':num' => $num, ':username' => $_SESSION['username'], ':kithe' => $Current_Kithe_Num, ':adddate' => $adddate, ':class1' => $class1, ':class2' => $class2, ':class3' =>$bet_array[$i], ':rate' => $current_rate, ':sum_m' => $money, ':user_ds' => $user_ds, ':dai_ds' => 0, ':zong_ds' => 0, ':guan_ds' => 0, ':dai_zc' => 0, ':zong_zc' => 0, ':guan_zc' => 0, ':dagu_zc' => 0, ':bm' => 0, ':dai' => 'daili', ':zong' => 'zong', ':guan' => 'guan', ':memid' => $memid, ':danid' => 3, ':zongid' => 2, ':guanid' => 1, ':abcd' => 'A', ':lx' => 0);
			
			$stmt = $mydata2_db->prepare('INSERT INTO ka_tan set num=:num,username=:username,kithe=:kithe,adddate=:adddate,class1=:class1,class2=:class2,class3=:class3,rate=:rate,sum_m=:sum_m,user_ds=:user_ds,dai_ds=:dai_ds,zong_ds=:zong_ds,guan_ds=:guan_ds,dai_zc=:dai_zc,zong_zc=:zong_zc,guan_zc=:guan_zc,dagu_zc=:dagu_zc,bm=:bm,dai=:dai,zong=:zong,guan=:guan,memid=:memid,danid=:danid,zongid=:zongid,guanid=:guanid,abcd=:abcd,lx=:lx');
			
			$stmt->execute($params);
		}
	}
	$params = array(':uid' => $userinfo['uid'], ':userName' => $userinfo['username'], ':transferOrder' => 'm_' . $num, ':transferAmount' => $allmoney, ':previousAmount' => $previousAmount, ':currentAmount' => $currentAmount, ':creationTime' => date('Y-m-d H:i:s', time()));
	$stmt = $mydata1_db->prepare('insert into k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) values(:uid,:userName,\'SIX\',\'BET\',:transferOrder,-:transferAmount,:previousAmount,:currentAmount,:creationTime)');
	$stmt->execute($params);
}
echo '<script type="text/javascript">alert("下注成功");window.location.href="/m/lotto/index.php";</script>';
exit();

function getClassLength($str){
	global $shuzulenth;
	switch ($str)
	{
		case '二肖连中': $shuzulenth = 2;
		break;
		case '三肖连中': $shuzulenth = 3;
		break;
		case '四肖连中': $shuzulenth = 4;
		break;
		case '五肖连中': $shuzulenth = 5;
		break;
		case '二肖连不中': $shuzulenth = 2;
		break;
		case '三肖连不中': $shuzulenth = 3;
		break;
		case '四肖连不中': $shuzulenth = 4;
	}
}

function isRepeat($array){
	if (isset($array))
	{
		if (count($array) == count(array_unique($array)))
		{
			return false;
		}
	}
	return true;
}

function illegeElement($str){
	global $zodiac;
	if (in_array($str, $zodiac))
	{
		return true;
	}
	return false;
}

function queryPeilv($class1, $class2){
	global $mydata1_db;
	$params = array(':class1' => $class1, ':class2' => $class2);
	$stmt = $mydata1_db->prepare('select class3,rate from mydata2_db.ka_bl where  class1=:class1 and class2=:class2');
	$stmt->execute($params);
	return $stmt;
}

function getRightRate($result){
	global $zodiac;
	global $peilv_array;
	$bet_palv = array();
	if (isset($result)){
		$bet_array = explode(',', $result);
		
		for ($i = 0;$i < count($bet_array);$i++){
			$bet_temp = $bet_array[$i];
			if (!in_array($bet_temp, $zodiac)){
				echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
				exit();
			}
			array_push($bet_palv, $peilv_array[$bet_array[$i]]);
		}
		sort($bet_palv);
		return $bet_palv[0];
	}
	return '';
}
?>