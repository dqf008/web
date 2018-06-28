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
include_once '../../include/newpage.php';
include_once '../../include/lottery.inc.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
?>
<!DOCTYPE html> 
<html class="ui-mobile ui-mobile-viewport ui-overlay-a"> 
<head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title><?=$web_site['web_title'];?></title> 
  <!--[if lt IE 9]> 
	  <script src="js/html5.js" type="text/javascript"> 
	  </script> 
	  <script src="js/css3-mediaqueries.js" type="text/javascript"> 
	  </script> 
  <![endif]--> 
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
  <style> 
  #haoma div{font-size:14px;line-height:25px;height:25px;float:left;font-family: "Microsoft Yahei", "微软雅黑"}
  #haoma .ball_1, .ball_2{ 
	  text-align:center;
      width:25px;
      font-weight:bold;
      margin: 0 1px;
  } 
  .ball_1{ 
      color:#000;
      background:url(../images/blue1.png) no-repeat;
  }
  .ball_2{ 
	  color:#000;
	  background:url(../images/blue2.png) no-repeat;
  } 
  </style> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-theme="a"  tabindex="0" style="min-height: 892px;"> 
  <!--头部开始--> 
  <header id="header"> 
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
	  <span>开奖结果</span> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 



  <section class="sliderWrap clearfix"> 
	  <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit"> 
		  <h1 class="ui-title" role="heading" aria-level="1">七星彩</h1> 
	  </div> 
  </section> 

  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <div data-role="cotent"> 
		  <form action="result_ssl.php" method="get" name="lt_form" data-role="none" data-ajax="false"> 
		  <ul data-role="listview" class="ui-listview">
		  <?php 
		  	$sqlk = 'select * from lottery_k_qxc where status=1 order by kaijiang desc limit 10';
			$resultk = $mydata1_db->query($sqlk);
			while ($rowk = $resultk->fetch()){
				$hmhz = unserialize($rowk['value']);
			?> 					  
			<li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
					  <label>开奖期数：<?=$rowk['qishu'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>开奖时间：<?=date('Y-m-d H:i:s', $rowk['kaijiang']);?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label id="haoma">
                          <div class="ball">号码：</div> 
						  <div class="ball_2"><?=$hmhz[0];?></div> 
						  <div class="ball_2"><?=$hmhz[1];?></div> 
                          <div class="ball_2"><?=$hmhz[2];?></div> 
                          <div class="ball_2"><?=$hmhz[3];?></div> 
                          <div class="ball_1"><?=$hmhz[4];?></div> 
                          <div class="ball_1"><?=$hmhz[5];?></div> 
						  <div class="ball_1"><?=$hmhz[6];?></div> 
					  </label> 
				  </li> 
				  <?php } ?>
			</ul> 
	  </div> 
  </section> 
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once '../member/myinfo.php';?></body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>