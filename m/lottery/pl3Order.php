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
include_once '../../include/lottery.inc.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
if (intval($web_site['pl3']) == 1){
	message('体彩排列3系统维护，暂停下注！');
	exit();
}
$params = array(':kaipan' => $l_time, ':fengpan' => $l_time);
$stmt = $mydata1_db->prepare('select * from lottery_k_pl3 where kaipan<:kaipan and fengpan>:fengpan');
$stmt->execute($params);
$trow = $stmt->fetch();
$tcou = $stmt->rowCount();
if ($tcou <= 0){
	echo '<script type="text/javascript">alert("已经封盘，禁止下注！");window.location.href="/m/lottery/pl3.php";</script>';
	exit();
}
$stype = $_POST['stype'];
$btype = $_POST['btype'];
$ctype = $_POST['ctype'];
$dtype = $_POST['dtype'];
$zhnum = $_POST['zhnum'];
include_once '../../ajaxleft/postkey.php';
$orderinfo = $trow['qihao'].$zhnum.'pl3'.$btype.$ctype.$dtype.$stype.'y';
$content = $_POST['content_0'];
if($_POST['key_0']!=StrToHex($orderinfo.$content, $postkey)) {
	echo "<script language=javascript>alert('投注信息被篡改，投注失败！');window.location.href='/m/lottery/pl3.php';</script>";
	exit;
}
include_once '../../cache/group_' . @($_SESSION['gid']) . '.php';
$cp_zd = @($pk_db['彩票最低']);
$cp_zg = @($pk_db['彩票最高']);
if (0 < $cp_zd){
	$cp_zd = $cp_zd;
}else{
	$cp_zd = $lowbet;
}

if (0 < $cp_zg){
	$cp_zg = $cp_zg;
}else{
	$cp_zg = 1000000;
}
$allmoney = 0;
$orderList = array();
if (($btype == '跨度') || ($btype == '和值') || ($btype == '单双大小')){
	if (0 < $cp_zd){
		if (abs($_POST['money_0']) < $cp_zd){
			echo "<script language=javascript>alert('最低下注金额为".$cp_zd."RMB！');window.location.href='/m/lottery/pl3.php';</script>";
			exit();
		}
	}else if (abs($_POST['money_0']) < $lowbet){
		echo "<script language=javascript>alert('最低下注金额为".$lowbet."RMB！');window.location.href='/m/lottery/pl3.php';</script>";
		exit();
	}
	
	if (0 < $cp_zg){
		if ($cp_zg < abs($_POST['money_0'])){
			echo "<script language=javascript>alert('最高下注金额为".$cp_zg."RMB！');window.location.href='/m/lottery/pl3.php';</script>";
			exit();
		}
	}
	$params = array(':class2' => $btype, ':class3' => $ctype);
	$sql = 'select id,class1,class2,class3,odds,modds,locked from lottery_odds where class1=\'pl3\' and class2=:class2 and class3=:class3 order by ID asc';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	if ($row = $stmt->fetch()){
		$odds = $row['odds'];
	}else{
		echo "<script language=javascript>alert('非法投注！');window.location.href='/m/lottery/pl3.php';</script>";
		exit();
	}
	
	$allmoney = abs($_POST['money_0']);
	if ($allmoney == 0){
		echo "<script language=javascript>alert('非法投注金额！');window.location.href='/m/lottery/pl3.php';</script>";
		exit();
	}
	$orderList[0]['btype'] = $btype;
	$orderList[0]['ctype'] = $ctype;
	$orderList[0]['dtype'] = $dtype;
	$orderList[0]['content'] = $content;
	$orderList[0]['money'] = $allmoney;
	$orderList[0]['odds'] = $odds;
}else{
	$oddsshow = array();
	if ($btype == '组二'){
		$params = array(':class2' => $btype);
		$psql = 'select id,class1,class2,class3,odds,modds,locked from lottery_odds where class1=\'pl3\' and class2=:class2 order by ID asc';
		$stmt = $mydata1_db->prepare($psql);
		$stmt->execute($params);
		if ($stmt->rowCount() != 2){
			echo "<script language=javascript>alert('非法投注！');window.location.href='/m/lottery/pl3.php';</script>";
			exit();
		}
		$prow = $stmt->fetch();
		$oddsshow[0] = $prow['odds'];
		$prow = $stmt->fetch();
		$oddsshow[1] = $prow['odds'];
	}else{
		$params = array(':class2' => $btype, ':class3' => $ctype);
		$sql = 'select id,class1,class2,class3,odds,modds,locked from lottery_odds where class1=\'pl3\' and class2=:class2 and class3=:class3 order by ID asc';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		if ($row = $stmt->fetch()){
			$oddsshow[0] = $row['odds'];
		}else{
			echo "<script language=javascript>alert('非法投注！');window.location.href='/m/lottery/pl3.php';</script>";
			exit();
		}
	}
	
	for ($i = 0;$i < $zhnum;$i++){
		$content = $_POST['content_' . $i . ''];
		$money = abs($_POST['money_' . $i . '']);
		if($_POST['key_'.$i]!=StrToHex($orderinfo.$content, $postkey)) {
			echo "<script language=javascript>alert('投注信息被篡改，投注失败！');window.location.href='/m/lottery/pl3.php';</script>";
			exit;
		}
		if (0 < $cp_zd){
			if ($money < $cp_zd){
				echo "<script language=javascript>alert('最低下注金额为".$cp_zd."RMB！');window.location.href='/m/lottery/pl3.php';</script>";
				exit();
			}
		}else if ($money < $lowbet){
			echo "<script language=javascript>alert('最低下注金额为".$lowbet."RMB！');window.location.href='/m/lottery/pl3.php';</script>";
			exit();
		}
		
		if (0 < $cp_zg){
			if ($cp_zg < $money){
				echo "<script language=javascript>alert('最高下注金额为".$cp_zg."RMB！');window.location.href='/m/lottery/pl3.php';</script>";
				exit();
			}
		}
		$allmoney = $allmoney + $money;
		if ($money == 0){
			echo "<script language=javascript>alert('非法投注金额！');window.location.href='/m/lottery/pl3.php';</script>";
			exit();
		}
		$myodds = $oddsshow[0];
		if ($btype == '组二'){
			$z2hm1 = substr($content, 0, 1);
			$z2hm2 = substr($content, 1, 1);
			if ($z2hm1 == $z2hm2){
				$myodds = $oddsshow[1];
			}
		}
		
		if ($btype == '单选'){
			if ($ctype == '一位'){
			}else if ($ctype == '二位'){
				$dtype1 = substr($content, 0, 1);
				$dtype2 = substr($content, 1, 1);
				if ($dtype1 == $dtype2){
					echo "<script language=javascript>alert('非法投注！');window.location.href='/m/lottery/pl3.php';</script>";
					exit();
				}
			}else if ($ctype == '三位'){
				$dtype1 = substr($content, 0, 1);
				$dtype2 = substr($content, 1, 1);
				$dtype3 = substr($content, 2, 1);
				if (($dtype1 == $dtype2) || ($dtype1 == $dtype3) || ($dtype3 == $dtype2)){
					echo "<script language=javascript>alert('非法投注！');window.location.href='/m/lottery/pl3.php';</script>";
					exit();
				}
			}else{
				echo "<script language=javascript>alert('非法投注！');window.location.href='/m/lottery/pl3.php';</script>";
				exit();
			}
		}else if ($btype == '组一'){
		}else if ($btype == '组二'){
		}else if ($btype == '组三'){
			$dtype1 = substr($content, 0, 1);
			$dtype2 = substr($content, 1, 1);
			$dtype3 = substr($content, 2, 1);
			if (($dtype1 != $dtype2) || ($dtype1 == $dtype3)){
				echo "<script language=javascript>alert('非法投注！');window.location.href='/m/lottery/pl3.php';</script>";
				exit();
			}
		}else if ($btype == '组六'){
			$dtype1 = substr($content, 0, 1);
			$dtype2 = substr($content, 1, 1);
			$dtype3 = substr($content, 2, 1);
			if (($dtype1 == $dtype2) || ($dtype1 == $dtype3) || ($dtype2 == $dtype3)){
				echo "<script language=javascript>alert('非法投注！');window.location.href='/m/lottery/pl3.php';</script>";
				exit();
			}
		}else{
			echo "<script language=javascript>alert('非法投注！');window.location.href='/m/lottery/pl3.php';</script>";
			exit();
		}
		$orderList[$i]['btype'] = $btype;
		$orderList[$i]['ctype'] = $ctype;
		$orderList[$i]['dtype'] = $dtype;
		$orderList[$i]['content'] = $content;
		$orderList[$i]['money'] = $money;
		$orderList[$i]['odds'] = $myodds;
	}
}
$userinfo = user::getinfo($uid);
if ($allmoney <= $userinfo['money']){
	$params = array(':money' => $allmoney, ':uid' => $userinfo['uid']);
	$msql = 'update k_user set money=money-:money where uid=:uid';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params);
}else{
	echo "<script language=javascript>alert('余额不足，请先充值，后下注');window.location.href='/m/lottery/pl3.php';</script>";
	exit();
}

$preMoney = $userinfo['money'];

for ($i = 0;$i < count($orderList);$i++){
	$orderNo = date('YmdHis', $lottery_time) . rand(1000, 9999);
	$betMoney = abs($_POST['money_1']);
	$params = array(':mid' => $trow['qihao'], ':uid' => $orderNo, ':atype' => 'pl3', ':btype' => $orderList[$i]['btype'], ':ctype' => $orderList[$i]['ctype'], ':dtype' => $orderList[$i]['dtype'], ':content' => $orderList[$i]['content'], ':money' => $orderList[$i]['money'], ':odds' => $orderList[$i]['odds'], ':win' => $orderList[$i]['money'] * $orderList[$i]['odds'], ':username' => $userinfo['username'], ':agent' => $userinfo['agents'], ':bet_date' => date('Y-m-d', time()), ':bet_time' => date('Y-m-d H:i:s', time()));
	$stmt = $mydata1_db->prepare('insert into lottery_data set mid=:mid, uid=:uid, atype=:atype, btype=:btype, ctype=:ctype, dtype=:dtype, content=:content, money=:money, odds=:odds, win=:win, username=:username, agent=:agent, bet_date=:bet_date, bet_time=:bet_time');
	$stmt->execute($params);
	$userName = $userinfo['username'];
	$creationTime = date('Y-m-d H:i:s');
	$params = array(':uid' => $uid, ':userName' => $userName, ':transferOrder' => 'm_' . $orderNo, ':transferAmount' => $orderList[$i]['money'], ':previousAmount' => $preMoney, ':currentAmount' => $preMoney - $orderList[$i]['money'], ':creationTime' => $creationTime);
	$stmt = $mydata1_db->prepare('INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE (:uid,:userName,\'TCPL3\',\'BET\',:transferOrder,-:transferAmount,:previousAmount,:currentAmount,:creationTime)');
	$stmt->execute($params);
	$preMoney = $preMoney - $orderList[$i]['money'];
}

echo '<script type="text/javascript">alert("下注成功，请到下注记录中查询本注单！");window.location.href="/m/lottery/pl3.php";</script>';
exit();
?>