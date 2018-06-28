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
include_once '../../member/function.php';
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
  <style type="text/css"> 
  #content li{ 
	  padding: 0 0 5px 0;
  } 
  </style> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-theme="a" tabindex="0" style="min-height: 640px;"> 
  <!--头部开始--> 
  <header id="header"> 
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
		  <span>开奖结果</span> 
	  <a href="/m/index.php" data-ajax="false" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 


  <!--赛事列表--> 
  <div data-role="content" id="content" class="ui-content" role="main"> 
	  <ul data-role="listview" data-theme="a" data-inset="false" class="ui-listview ui-group-theme-a"> 
		  <li class="ui-first-child"><a href="/m/lotto/result_lh.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">香港六合彩</a></li> 
      <li><a href="/m/lottery/result_jslh.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">极速六合</a></li> 
		  <li><a href="/m/lottery/result_ssc.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">重庆时时彩</a></li> 
      <li><a href="/m/lottery/result_jsssc.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">极速时时彩</a></li> 
		  <li><a href="/m/lottery/result_bjsc.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">北京赛车PK拾</a></li> 
      <li><a href="/m/lottery/result_jssc.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">极速赛车</a></li> 
      <li><a href="/m/lottery/result_xyft.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">幸运飞艇</a></li>
      <li><a href="/m/lottery/result_gdkls.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">广东快乐十分</a></li> 
		  <li><a href="/m/lottery/result_kl8.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">北京快乐8</a></li> 
		  <li><a href="/m/lottery/result_ssl.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">上海时时乐</a></li> 
		  <li><a href="/m/lottery/result_3d.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">福彩3D</a></li> 
		  <li><a href="/m/lottery/result_pl3.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">排列3</a></li> 
		  <li class="ui-last-child"><a href="/m/lottery/result_qxc.php" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-carat-r">七星彩</a></li> 
	  </ul> 
  </div> 

  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once '../member/myinfo.php';?></body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>