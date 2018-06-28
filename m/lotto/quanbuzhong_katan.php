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
$betlist = $_POST['betlist'];
$count = $_POST['count'];
$returnURL = '/m/lotto/quanbuzhong.php?ids=' . $class2;
$allclass1 = array('全不中');
if (!in_array($class1, $allclass1)){
	echo '<script type="text/javascript">alert("非法下注！");window.location.href="'.$returnURL.'";</script>';
	exit();
}

$params = array(':class1' => $class1, ':class2' => $class2);
$stmt = $mydata1_db->prepare('select class3,rate from mydata2_db.ka_bl where  class1=:class1 and class2=:class2 order by id');
$stmt->execute($params);
$plArray = array();
$betnumber = 0;
while ($row = $stmt->fetch()){
	$betnumber++;
	$plArray[$betnumber]['rate'] = $row['rate'];
	$plArray[$betnumber]['class3'] = $row['class3'];
}
if ($betnumber == 0){
	echo '<script type="text/javascript">alert("非法下注！");window.location.href="'.$returnURL.'";</script>';
	exit();
}
$orderList = array();
$allmoney = 0;
$user_ds = 0;
$betlistArray = explode(',', $betlist);

for ($i = 0;$i < $count;$i++){
	$money = $_POST['money_' . $i];
	$class3 = $_POST['class3_' . $i];
	
	if (!checkClass3($class1, $class2, $class3, $money)){
		echo '<script type="text/javascript">alert("非法下注！");window.location.href="'.$returnURL.'";</script>';
		exit();
	}
	
	if (0 < $money){
		if ($money < $cp_zd){
			echo '<script type="text/javascript">alert("最小下注金额为：<?=$cp_zd ;?>");window.location.href="'.$returnURL.'";</script>';
			exit();
		}
		
		if ($cp_zg < $money){
			echo '<script type="text/javascript">alert("最高下注金额为：'.$cp_zg.'");window.location.href="'.$returnURL.'";</script>';
			exit();
		}
		$allmoney = $allmoney + $money;
		$orderList[$i]['money'] = $money;
		$orderList[$i]['class3'] = $class3;
		$rs = explode(',', $class3);
		$orderList[$i]['rate'] = getLowRate($rs);
	}
}
$userinfo = user::getinfo($uid);
if ($userinfo['money'] < $allmoney){
	echo '<script type="text/javascript">alert("对不起，下注总额不能大于可用信用额");window.location.href="'.$returnURL.'";</script>';
	exit();
}

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
if ($_SESSION['username']){
	$memid = $row['id'];
}
$params = array(':money' => $allmoney, ':username' => $_SESSION['username']);
$sql = 'update k_user set money=money-:money where username=:username limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$previousAmount = $userinfo['money'];
$len = count($orderList);

for ($i = 0;$i < $len;$i++){
	$currentAmount = $previousAmount - $orderList[$i]['money'];
	$num = randStr();
	$adddate = date('Y-m-d H:i:s', time() + (12 * 3600));
	$params = array(':num' => $num, ':username' => $_SESSION['username'], ':kithe' => $Current_Kithe_Num, ':adddate' => $adddate, ':class1' => $class1, ':class2' => $class2, ':class3' => $orderList[$i]['class3'], ':rate' => $orderList[$i]['rate'], ':sum_m' => $orderList[$i]['money'], ':user_ds' => $user_ds, ':dai_ds' => 0, ':zong_ds' => 0, ':guan_ds' => 0, ':dai_zc' => 0, ':zong_zc' => 0, ':guan_zc' => 0, ':dagu_zc' => 0, ':bm' => 0, ':dai' => 'daili', ':zong' => 'zong', ':guan' => 'guan', ':memid' => $memid, ':danid' => 3, ':zongid' => 2, ':guanid' => 1, ':abcd' => 'A', ':lx' => 0);
	$stmt = $mydata2_db->prepare('INSERT INTO ka_tan set  num=:num, username=:username, kithe=:kithe, adddate=:adddate, class1=:class1, class2=:class2, class3=:class3, rate=:rate, sum_m=:sum_m, user_ds=:user_ds, dai_ds=:dai_ds, zong_ds=:zong_ds, guan_ds=:guan_ds, dai_zc=:dai_zc, zong_zc=:zong_zc, guan_zc=:guan_zc, dagu_zc=:dagu_zc, bm=:bm, dai=:dai, zong=:zong, guan=:guan, memid=:memid, danid=:danid, zongid=:zongid, guanid=:guanid, abcd=:abcd, lx=:lx');
	$stmt->execute($params);
	$params = array(':uid' => $userinfo['uid'], ':userName' => $userinfo['username'], ':transferOrder' => 'm_' . $num, ':transferAmount' => $orderList[$i]['money'], ':previousAmount' => $previousAmount, ':currentAmount' => $currentAmount, ':creationTime' => date('Y-m-d H:i:s', time()));
	$stmt = $mydata1_db->prepare('insert into k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) values(:uid,:userName,\'SIX\',\'BET\',:transferOrder,-:transferAmount,:previousAmount,:currentAmount,:creationTime)');
	$stmt->execute($params);
	$previousAmount = $currentAmount;
}
echo '<script type="text/javascript">alert("下注成功");window.location.href="/m/lotto/index.php";</script>';
exit();

function checkClass3($class1, $class2, $class3, $money){
	if ($class1 != '全不中'){
		return false;
	}
	
	$allclass2 = array('五不中', '六不中', '七不中', '八不中', '九不中', '十不中', '十一不中', '十二不中');
	if (!in_array($class2, $allclass2)){
		return false;
	}
	
	$a = explode(',', $class3);
	$len1 = count($a);
	$b = array_unique($a);
	$len2 = count($b);
	
	if ($len1 != $len2){
		return false;
	}
	
	if (count($a) != getM($class2)){
		return false;
	}
	$a2 = explode(',', $class3);
	
	for ($i = 0;$i < count($a2);$i++){
		$c = intval($a2[$i], 10);
		if ('#' . $c != '#' . $a2[$i]){
			return false;
		}
		
		if (($c < 1) || (49 < $c)){
			return false;
		}
	}
	
	if (!preg_match('/^[1-9]\\d*$/', $money)){
		return false;
	}
	return true;
}

function getM($class2){
	$m = 0;
	if ('五不中' == $class2){
		$m = 5;
	}else if ('六不中' == $class2){
		$m = 6;
	}else if ('七不中' == $class2){
		$m = 7;
	}else if ('八不中' == $class2){
		$m = 8;
	}else if ('九不中' == $class2){
		$m = 9;
	}else if ('十不中' == $class2){
		$m = 10;
	}else if ('十一不中' == $class2){
		$m = 11;
	}else if ('十二不中' == $class2){
		$m = 12;
	}else{
		echo '参数错误';
		exit();
	}
	return $m;
}

function getLowRate($rs){
	global $plArray;
	$lowRate = 100000;
	
	for ($i = 0;$i < count($rs);$i++){
		$crate = 0;
		
		for ($j = 1;$j <= count($plArray);$j++){
			if ($plArray[$j]['class3'] == $rs[$i]){
				$crate = $plArray[$j]['rate'];
			}
		}
		
		if ($crate < $lowRate){
			$lowRate = $crate;
		}
	}
	return $lowRate;
}

?>