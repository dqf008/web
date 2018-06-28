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
$userinfo = user::getinfo($uid);
$class1 = $_POST['class1'];
$class2 = $_POST['class2'];
$money = $_POST['money'];
$betlist = $_POST['betlist'];
if ($class1 != '连码'){
	echo '<script type="text/javascript">alert("该页面禁止刷新！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}
$params = array(':class1' => $class1);
$stmt = $mydata1_db->prepare('select class2,class3,rate from mydata2_db.ka_bl where  class1=:class1 order by id');
$stmt->execute($params);
$plArray = array();
$betnumber = 0;
while ($row = $stmt->fetch()){
	$betnumber++;
	$plArray[$betnumber]['rate'] = $row['rate'];
	$plArray[$betnumber]['class2'] = $row['class2'];
	$plArray[$betnumber]['class3'] = $row['class3'];
}
if ($betnumber == 0){
	echo '<script type="text/javascript">alert("该页面禁止刷新！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}
$orderList = array();
$user_ds = 0;
$betlistArray = explode('|', $betlist);
$allmoney = 0;
$class3 = '';
$neednumber = 0;
$rate1 = 0;
$rate2 = 0;
if (!preg_match('/^[1-9]\\d*$/', $money)){
	echo '<script type="text/javascript">alert("请输入合法的金额！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}

if (0 < $money){
	if ($money < $cp_zd){
		echo '<script type="text/javascript">alert("最小下注金额为：'.$cp_zd.'");window.location.href="/m/lotto/index.php";</script>';
		exit();
	}
	
	if ($cp_zg < $money){
		echo '<script type="text/javascript">alert("最高下注金额为：'.$cp_zg.'");window.location.href="/m/lotto/index.php";</script>';
		exit();
	}
	switch ($class2){
		case '三全中': $neednumber = 3;
		$rate1 = $plArray[5]['rate'];
		break;
		case '三中二': $neednumber = 3;
		$rate1 = $plArray[7]['rate'];
		$rate2 = $plArray[6]['rate'];
		break;
		case '二全中': $neednumber = 2;
		$rate1 = $plArray[1]['rate'];
		break;
		case '二中特': $neednumber = 2;
		$rate1 = $plArray[3]['rate'];
		$rate2 = $plArray[2]['rate'];
		break;
		case '特串': $neednumber = 2;
		$rate1 = $plArray[4]['rate'];
		break;
		case '四中一': $neednumber = 4;
		$rate1 = $plArray[8]['rate'];
		break;
		default:
			echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
			exit();
	}
	$zhengshu = array();
	
	for ($i = 1;$i <= 49;$i++){
		array_push($zhengshu, '#' . $i . '');
	}
	
	for ($i = 0;$i < count($betlistArray);$i++){
		$checkArray = array();
		$tempArray = explode(',', $betlistArray[$i]);
		if (count($tempArray) != $neednumber){
			echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
			exit();
		}
		
		for ($j = 0;$j < $neednumber;$j++){
			if (!in_array('#' . $tempArray[$j], $zhengshu)){
				echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
				exit();
			}else{
				$checkArray[$tempArray[$j]] = $checkArray[$tempArray[$j]] + 0 + 1;
				if (1 < $checkArray[$tempArray[$j]]){
					echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
					exit();
				}
			}
		}
		$orderList[$i]['money'] = $money;
		$orderList[$i]['class3'] = $betlistArray[$i];
		$orderList[$i]['rate1'] = $rate1;
		$orderList[$i]['rate2'] = $rate2;
		$allmoney = $allmoney + $money;
	}
	
	if ($allmoney <= 0){
		echo '<script type="text/javascript">alert("请下注");window.location.href="/m/lotto/index.php";</script>';
		exit();
	}
}else{
	echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
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
	$len = count($orderList);
	
	for ($i = 0;$i < $len;$i++){
		$currentAmount = $previousAmount - $orderList[$i]['money'];
		$num = randStr();
		$adddate = date('Y-m-d H:i:s', time() + (12 * 3600));
		$params = array(':num' => $num, ':username' => $_SESSION['username'], ':kithe' => $Current_Kithe_Num, ':adddate' => $adddate, ':class1' => $class1, ':class2' => $class2, ':class3' => $orderList[$i]['class3'], ':rate' => $orderList[$i]['rate1'], ':sum_m' => $orderList[$i]['money'], ':user_ds' => $user_ds, ':dai_ds' => 0, ':zong_ds' => 0, ':guan_ds' => 0, ':dai_zc' => 0, ':zong_zc' => 0, ':guan_zc' => 0, ':dagu_zc' => 0, ':bm' => 0, ':dai' => 'daili', ':zong' => 'zong', ':guan' => 'guan', ':memid' => $memid, ':danid' => 3, ':zongid' => 2, ':guanid' => 1, ':rate2' => $orderList[$i]['rate2'], ':abcd' => 'A', ':lx' => 0);
		$stmt = $mydata2_db->prepare('INSERT INTO ka_tan set  num=:num, username=:username, kithe=:kithe, adddate=:adddate, class1=:class1, class2=:class2, class3=:class3, rate=:rate, sum_m=:sum_m, user_ds=:user_ds, dai_ds=:dai_ds, zong_ds=:zong_ds, guan_ds=:guan_ds, dai_zc=:dai_zc, zong_zc=:zong_zc, guan_zc=:guan_zc, dagu_zc=:dagu_zc, bm=:bm, dai=:dai, zong=:zong, guan=:guan, memid=:memid, danid=:danid, zongid=:zongid, guanid=:guanid, rate2=:rate2, abcd=:abcd, lx=:lx');
		$stmt->execute($params);
		$params = array(':uid' => $userinfo['uid'], ':userName' => $userinfo['username'], ':transferOrder' => 'm_' . $num, ':transferAmount' => $orderList[$i]['money'], ':previousAmount' => $previousAmount, ':currentAmount' => $currentAmount, ':creationTime' => date('Y-m-d H:i:s', time()));
		$stmt = $mydata1_db->prepare('insert into k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) values(:uid,:userName,\'SIX\',\'BET\',:transferOrder,-:transferAmount,:previousAmount,:currentAmount,:creationTime)');
		$stmt->execute($params);
		$previousAmount = $currentAmount;
	}
	echo '<script type="text/javascript">alert("下注成功");window.location.href="/m/lotto/index.php";</script>';
	exit();
}
?>