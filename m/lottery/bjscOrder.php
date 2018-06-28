<?php 
session_start();
$sub = 5;
if(empty($_SESSION['subtime'])){
	$_SESSION['subtime'] = time();
}else{
	$s = time()-$_SESSION['subtime'];
	if($s<$sub){
		die('<script type="text/javascript">alert("'.$sub.'秒内禁止重复提交，返回下注页面！");window.location.href="/m/lottery/bjsc.php";</script>');
	}else{
		$_SESSION['subtime'] = time();
	}
}
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/login_check.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '../../Lottery/include/ball_name.php';
include_once '../../Lottery/include/order_info.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
if (intval($web_site['pk10']) == 1){
	message('系统维护，暂停下注！');
	exit();
}
$datas = array_filter($_POST);
$names = array_keys($datas);
if (count($datas) <= 0){
	echo '<script type="text/javascript">alert("该页面为提交注单页面无法刷新，返回下注页面！");window.location.href="/m/lottery/bjsc.php";</script>';
	exit();
}

if ($_REQUEST['type'] == 4){
	$qishu = lottery_qishu_4($_REQUEST['type']);
	if ($qishu == -1){
		echo '<script type="text/javascript">alert("已经封盘，禁止下注！");</script>';
		exit();
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
	$allmoney = 0;
	
	for ($i = 0;$i < count($datas);$i++){
		$datas['' . $names[$i] . ''] = abs($datas['' . $names[$i] . '']);
		if ($datas['' . $names[$i] . ''] == 0){
			echo '<script type="text/javascript">alert("投注金额非法！");window.location.href="/m/lottery/cqssc.php";</script>';
			exit();
		}else if ($datas['' . $names[$i] . ''] < $cp_zd){
			echo '<script type="text/javascript">alert("最低下注金额：'.$cp_zd.'￥！");window.location.href="/m/lottery/cqssc.php";</script>';
			exit();
		}else if ($cp_zg < $datas['' . $names[$i] . '']){
			echo '<script type="text/javascript">alert("最高下注金额：'.$cp_zg.'￥！");window.location.href="/m/lottery/cqssc.php";</script>';
			exit();
		}
		$allmoney += $datas['' . $names[$i] . ''];
	}
	$edu = user_money($username, $allmoney);
	if ($edu == -1){
		echo '<script type="text/javascript">alert("您的账户额度不足进行本次投注，请充值后在进行投注！","投注失败");window.location.href="/m/index.php";</script>';
		exit();
	}
	$tmpMoney = $allmoney;
	$orderList = array();
	
	for ($i = 0;$i < count($datas);$i++){
		$qiu = explode('_', $names[$i]);
		$qiuhao = $ball_name['qiu_' . $qiu[1]];
		if ($qiu[1] == 1){
			$wanfa = $ball_name_gyh['ball_' . $qiu[2] . ''];
		}else if ((2 <= $qiu[1]) && ($qiu[1] <= 11)){
			$wanfa = $ball_name['ball_' . $qiu[2] . ''];
		}else if ($qiu[1] == 12){
			$wanfa = $ball_name_1V10['ball_' . $qiu[2] . ''];
		}else if ($qiu[1] == 13){
			$wanfa = $ball_name_2V9['ball_' . $qiu[2] . ''];
		}else if ($qiu[1] == 14){
			$wanfa = $ball_name_3V8['ball_' . $qiu[2] . ''];
		}else if ($qiu[1] == 15){
			$wanfa = $ball_name_4V7['ball_' . $qiu[2] . ''];
		}else{
			$wanfa = $ball_name_5V6['ball_' . $qiu[2] . ''];
		}
		$money = $datas['' . $names[$i] . ''];
		$odds = lottery_odds($_REQUEST['type'], 'ball_' . $qiu[1], $qiu[2]);
		$params = array(':did' => date('YmdHis', time()) . rand(1000, 9999), ':uid' => $uid, ':username' => $username, ':addtime' => date('Y-m-d H:i:s', time()), ':type' => '北京赛车PK拾', ':qishu' => $qishu, ':mingxi_1' => $qiuhao, ':mingxi_2' => $wanfa, ':odds' => $odds, ':money' => $money, ':win' => $money * $odds, ':bet_date' => date('Y-m-d', time()));
		$stmt = $mydata1_db->prepare('insert into c_bet_3(did,uid,username,addtime,type,qishu,mingxi_1,mingxi_2,odds,money,win,bet_date) values(:did,:uid,:username,:addtime,:type,:qishu,:mingxi_1,:mingxi_2,:odds,:money,:win,:bet_date)');
		$stmt->execute($params);
		$id = $mydata1_db->lastInsertId();
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':transferOrder' => 'm_' . $id, ':transferAmount' => $money, ':tmpMoney' => $tmpMoney, ':tmpMoney2' => $tmpMoney, ':transferAmount2' => $money, ':creationTime' => $creationTime, ':uid' => $uid);
		$stmt = $mydata1_db->prepare('INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)SELECT uid,userName,\'BJPK10\',\'BET\',:transferOrder,-:transferAmount,money+:tmpMoney,money+:tmpMoney2-:transferAmount2,:creationTime FROM k_user WHERE uid=:uid');
		$stmt->execute($params);
		$tmpMoney -= $money;
		$orderList[$i]['mingxi_1'] = $qiuhao;
		$orderList[$i]['mingxi_2'] = $wanfa;
		$orderList[$i]['odds'] = $odds;
		$orderList[$i]['money'] = $money;
		$orderList[$i]['win'] = $money * $odds;
	}
}
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
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" 
	  aria-owns="popupPanel" aria-expanded="false"> 
	  </a> 
	  <span> 
		  彩票游戏 
	  </span> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"> 
	  </a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 

  <!--功能列表--> 
  <section class="sliderWrap clearfix"> 
	  <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit"> 
		  <h1 class="ui-title" role="heading" aria-level="1"> 
			  北京赛车PK10 
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
						  <span id="zdnum"><?=count($datas);?></span> 
					  </font> 
				  </p> 
			  </div> 
			  <div class="xiazhu" style="line-height: 28px;clear:both;" data-role="none"> 
				  <ul class="biaodan1 ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" 
				  data-role="none" role="tablist"> 
					  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:60%;" 
					  data-role="none"> 
						  下注信息 
					  </li> 
					  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:15%;" 
					  data-role="none"> 
						  赔率 
					  </li> 
					  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:25%;" 
					  data-role="none"> 
						  下注金额 
					  </li> 
				  </ul> 
				  <ul class="biaodan1" data-role="none">
				  <?php for ($i = 0;$i < count($orderList);$i++){?> 						  
				      <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:60%;"  data-role="none"> 
						  <p><?=$orderList[$i]['mingxi_1'] ;?>【<span style="color:red;"><?=$orderList[$i]['mingxi_2'] ;?></span>】 							  </p> 
					  </li> 
					  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:15%;" 
					  data-role="none"> 
						  <p id="odd_1" style="color:#FF0000;"><?=$orderList[$i]['odds'];?>							  </p> 
					  </li> 
					  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:25%;" 
					  data-role="none"><?=$orderList[$i]['money'];?>						  
					  </li>
				  <?php }?> 					  
				  </ul> 
			  </div> 
		  </div> 
		  <div style="clear:both;padding-top:10px;padding-left:10px;"> 
			  <div style="clear:both;text-align:center;"> 
				  <a href="javascript:window.location.href='bjsc.php';" class="ui-btn ui-btn-inline"> 
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
  <script type="text/javascript" src="../js/bjsc.js"></script> 
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