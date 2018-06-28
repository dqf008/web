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
if (intval($web_site['kl8']) == 1){
	message('北京快乐8系统维护，暂停下注！');
	exit();
}
$qishu = trim($_POST['qihao']);
if (($qishu <= 0) || ($qishu == '')){
	echo '<script type="text/javascript">alert("请求失败，返回下注页面！");window.location.href="/m/lottery/kl8.php";</script>';
	exit();
}

$params = array(':kaipan' => $l_time, ':fengpan' => $l_time);
$tsql = 'select * from lottery_k_kl8 where kaipan<:kaipan and fengpan>:fengpan';
$stmt = $mydata1_db->prepare($tsql);
$stmt->execute($params);
$trow = $stmt->fetch();
$tcou = $stmt->rowCount();
if (($tcou == 0) || ($trow['qihao'] != $qishu)){
	echo "<script language=javascript>alert('当前期数已经关闭投注，请重新投注！');window.location.href='/m/lottery/kl8.php';</script>";
	exit();
}

$sql = 'select id,class1,class2,class3,odds,modds,locked from lottery_odds where class1=\'kl8\' order by ID asc';
$query = $mydata1_db->query($sql);
$oddsArray = array();
$oddsnumber = 1;
while ($row = $query->fetch()){
	$oddsArray[$oddsnumber]['class2'] = $row['class2'];
	$oddsArray[$oddsnumber]['class3'] = $row['class3'];
	$oddsArray[$oddsnumber]['odds'] = $row['odds'];
	$oddsnumber++;
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
$orderList = array();
$ordernum = 0;
$allmoney = 0;
$xuanhaomoney = ($_POST['ball_10'] == '' ? 0 : abs('' . $_POST['ball_10'] . ''));
$xuanhao = $_POST['hmnums'];
$real_xuanhao = '';
if ($xuanhaomoney != 0){
	if ($xuanhaomoney < $cp_zd){
		echo '<script type="text/javascript">alert("最低下注金额：'.$cp_zd.'￥！");window.location.href="/m/lottery/kl8.php";</script>';
		exit();
	}else if ($cp_zg < $xuanhaomoney){
		echo '<script type="text/javascript">alert("最高下注金额：'.$cp_zg.'￥！");window.location.href="/m/lottery/kl8.php";</script>';
		exit();
	}
	$allmoney = $allmoney + $xuanhaomoney;
	$xuanhaoArray = explode(',', $xuanhao);
	asort($xuanhaoArray);
	$tempArray = array();
	foreach ($xuanhaoArray as $k => $v){
		if ($v != ''){
			if (($v < 1) || (80 < $v)){
				echo '<script type="text/javascript">alert("非法投注！");window.location.href="/m/lottery/kl8.php";</script>';
				exit();
			}
			$tempArray[$v] = $tempArray[$v] + 1;
			if ($tempArray[$v] != 1){
				echo '<script type="text/javascript">alert("非法投注！");window.location.href="/m/lottery/kl8.php";</script>';
				exit();
			}
			$real_xuanhao = $real_xuanhao . $v . ',';
		}
	}
	$orderList[$ordernum]['content'] = rtrim($real_xuanhao, ',');
	$orderList[$ordernum]['money'] = $xuanhaomoney;
	if (count($tempArray) == 1){
		$orderList[$ordernum]['btype'] = '选一';
		$orderList[$ordernum]['ctype'] = '中一';
		$orderList[$ordernum]['odds'] = $oddsArray[1]['odds'];
	}else if (count($tempArray) == 2){
		$orderList[$ordernum]['btype'] = '选二';
		$orderList[$ordernum]['ctype'] = '中二';
		$orderList[$ordernum]['odds'] = $oddsArray[2]['odds'];
	}else if (count($tempArray) == 3){
		$orderList[$ordernum]['btype'] = '选三';
		$orderList[$ordernum]['ctype'] = '中三';
		$orderList[$ordernum]['odds'] = $oddsArray[4]['odds'];
	}else if (count($tempArray) == 4){
		$orderList[$ordernum]['btype'] = '选四';
		$orderList[$ordernum]['ctype'] = '中四';
		$orderList[$ordernum]['odds'] = $oddsArray[7]['odds'];
	}else if (count($tempArray) == 5){
		$orderList[$ordernum]['btype'] = '选五';
		$orderList[$ordernum]['ctype'] = '中五';
		$orderList[$ordernum]['odds'] = $oddsArray[10]['odds'];
	}else{
		echo '<script type="text/javascript">alert("非法投注！");window.location.href="/m/lottery/kl8.php";</script>';
		exit();
	}
	$ordernum++;
}

for ($i = 11;$i <= 21;$i++){
	$tempmoney = ($_POST['ball_' . $i] == '' ? 0 : abs('' . $_POST['ball_' . $i] . ''));
	if ($tempmoney != 0){
		if ($tempmoney < $cp_zd){
			echo '<script type="text/javascript">alert("最低下注金额：'.$cp_zd.'￥！");window.location.href="/m/lottery/kl8.php";</script>';
			exit();
		}else if ($cp_zg < $tempmoney){
			echo '<script type="text/javascript">alert("最高下注金额：'.$cp_zg.'￥！");window.location.href="/m/lottery/kl8.php";</script>';
			exit();
		}
		$allmoney = $allmoney + $tempmoney;
		$orderList[$ordernum]['btype'] = $oddsArray[$i]['class2'];
		$orderList[$ordernum]['ctype'] = $oddsArray[$i]['class3'];
		$orderList[$ordernum]['content'] = $oddsArray[$i]['class3'];
		$orderList[$ordernum]['money'] = $tempmoney;
		$orderList[$ordernum]['odds'] = $oddsArray[$i]['odds'];
		$ordernum++;
	}
}

if ($allmoney <= 0){
	echo '<script type="text/javascript">alert("非法投注！");window.location.href="/m/lottery/kl8.php";</script>';
	exit();
}

$userinfo = user::getinfo($uid);
if (0 <= $userinfo['money'] - $allmoney){
	$params = array(':money' => $allmoney, ':username' => $username);
	$sql = 'update k_user set money=money-:money where username=:username limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
}else{
	echo '<script type="text/javascript">alert("您的账户额度不足进行本次投注，请充值后在进行投注！","投注失败");window.location.href="/m/index.php";</script>';
	exit();
}
$tmpMoney = $userinfo['money'];

for ($i = 0;$i < $ordernum;$i++){
	$orderNo = date('YmdHis', $lottery_time) . rand(1000, 9999);
	$params = array(':mid' => $qishu, ':uid' => $orderNo, ':atype' => 'kl8', ':btype' => $orderList[$i]['btype'], ':ctype' => $orderList[$i]['ctype'], ':content' => $orderList[$i]['content'], ':money' => $orderList[$i]['money'], ':odds' => $orderList[$i]['odds'], ':win' => $orderList[$i]['money'] * $orderList[$i]['odds'], ':username' => $userinfo['username'], ':agent' => $userinfo['agents'], ':bet_date' => date('Y-m-d', time()), ':bet_time' => date('Y-m-d H:i:s', time()));
	$stmt = $mydata1_db->prepare('insert into lottery_data set mid=:mid, uid=:uid, atype=:atype, btype=:btype, ctype=:ctype, content=:content, money=:money, odds=:odds, win=:win, username=:username, agent=:agent, bet_date=:bet_date, bet_time=:bet_time');
	$stmt->execute($params);
	$creationTime = date('Y-m-d H:i:s');
	$params = array(':uid' => $userinfo['uid'], ':userName' => $userinfo['username'], ':transferOrder' => 'm_' . $orderNo, ':transferAmount' => $orderList[$i]['money'], ':previousAmount' => $tmpMoney, ':currentAmount' => $tmpMoney - $orderList[$i]['money'], ':creationTime' => $creationTime);
	$stmt = $mydata1_db->prepare('INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) VALUE (:uid,:userName,\'BJKL8\',\'BET\',:transferOrder,-:transferAmount,:previousAmount,:currentAmount,:creationTime)');
	$stmt->execute($params);
	$tmpMoney -= $orderList[$i]['money'];
}
$userinfo = user::getinfo($uid);
?>
<!DOCTYPE html> 
<html class="ui-mobile ui-mobile-viewport ui-overlay-a"> 
<head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title><?=$web_site['web_title'];?></title> 
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> 
  <meta content="yes" name="apple-mobile-web-app-capable"> 
  <meta content="black" name="apple-mobile-web-app-status-bar-style"> 
  <meta content="telephone=no" name="format-detection"> 
  <meta name="viewport" content="width=device-width"> 
  <link rel="shortcut icon" href="../images/favicon.ico"> 
  <link rel="stylesheet" href="../css/style.css"> 
  <link rel="stylesheet" href="../js/jquery.mobile-1.4.5.min.css"> 
  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script> 
  <script type="text/javascript" src="../js/jquery.mobile-1.4.5.min.js"></script> 
  <!--js判断横屏竖屏自动刷新--> 
  <script type="text/javascript" src="../js/top.js"></script> 
  <style type="text/css"> 
	  ul, ol, li{  
		  list-style-type:none;
	  }  
	  .xiazhu ul { 
		  padding-top: 5px;
	  }  
	  .xiazhu  	  .biaodan li{  
		  width: 20%;
		  height: 28px;
		  border-bottom:1px solid #DDD;
		  text-align:  	  center;
		  float:left;
	  } 
	  .xiazhu .biaodan1 li{ 
		  width: 25%;
		  height: 28px;
		  border-bottom:1px solid #DDD;
		  text-align: center;
		  float:left;
	  } 
  </style> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 659px;"> 
  <input id="uid" name="uid" value="<?=$uid;?>" type="hidden"/> 
  <!--头部开始--> 
  <header id="header"> 
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true"  aria-owns="popupPanel" aria-expanded="false">  </a> 
	  <span>彩票游戏</span> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"> 
	  </a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 

  <!--功能列表--> 
  <section class="sliderWrap clearfix"> 
	  <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit"> 
		  <h1 class="ui-title" role="heading" aria-level="1"> 
			  北京快乐8 
		  </h1> 
	  </div> 
  </section> 
  <section class="mContent" style="padding-left:0px;padding-right:0px;padding-top:5px;"> 
	  <div data-role="tabs" id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all"> 
		  <div id="three" class="ui-body-d ui-content" style="padding:0px;"> 
			  <div style="clear:both;padding-bottom:5px;border-bottom-width:1px;border-color:#DDD;border-style:solid;text-align:center;"> 
				  <b> 
					  <p> 
						  以下为您下注成功的注单 
					  </p> 
				  </b> 
			  </div> 
			  <div style="clear:both;padding-bottom:5px;border-bottom-width:1px;border-color:#DDD;border-style:solid;text-align:center;"> 
				  <p> 
					  期号: 
					  <font color="#FF0000"><?=$qishu;?></font> 
					  &nbsp;&nbsp;总金额: 
					  <font color="#FF0000"><?=$allmoney;?></font> 
					  &nbsp;&nbsp;总单量: 
					  <font color="#FF0000"> 
						  <span id="zdnum"><?=$ordernum;?></span> 
					  </font> 
				  </p> 
			  </div> 
			  <div class="xiazhu" style="clear:both;" data-role="none"> 
				  <ul class="biaodan1 ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" 
				  data-role="none" role="tablist"> 
					  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:50%;" 
					  data-role="none"> 
						  下注信息 
					  </li> 
					  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:10%;" 
					  data-role="none"> 
						  赔率 
					  </li> 
					  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:20%;" 
					  data-role="none"> 
						  金额 
					  </li> 
					  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:20%;" 
					  data-role="none"> 
						  可贏 
					  </li> 
				  </ul> 
				  <ul class="biaodan1" data-role="none">
				  	  <?php for ($i = 0;$i < count($orderList);$i++){?> 						  
				      <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:50%;heihgt:100%"  data-role="none"> 
						  <p><?=$orderList[$i]['btype'] ;?>【<span style="color:red;"><?=$orderList[$i]['content'] ;?></span>】</p> 
					  </li> 
					  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:10%;"  data-role="none"> 
						  <p id="odd_1" style="color:#FF0000;"><?=$orderList[$i]['odds'];?>	</p> 
					  </li> 
					  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:20%;"  data-role="none">
					  <?=$orderList[$i]['money'];?>						  
					  </li> 
					  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:20%;"  data-role="none"> 
						  <p id="win_1"><?=sprintf('%.2f',$orderList[$i]['money'] * $orderList[$i]['odds']);?> </p> 
					  </li>
					  <?php }?> 					  
				</ul> 
			  </div> 
		  </div> 
		  <div style="clear:both;padding-top:10px;padding-left:10px;"> 
			  <div style="clear:both;text-align:center;"> 
				  <a href="javascript:window.location.href='kl8.php';" class="ui-btn ui-btn-inline"> 
					  继续下注 
				  </a> 
				  <a href="javascript:window.location.href='../index.php';" class="ui-btn ui-btn-inline"> 
					  返回首页 
				  </a> 
			  </div> 
		  </div> 
	  </div> 
  </section> 
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once '../member/myinfo.php';?>	  
  <script type="text/javascript" src="../js/cqssc.js"></script> 
  <script type="text/javascript"> 
	  $(function() { 
		  loadinfo();
	  });
  </script> 
</body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"> 
  <span class="ui-icon-loading"> 
  </span> 
  <h1> 
	  loading 
  </h1> 
</div> 
</html>