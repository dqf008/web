<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '../../include/newpage.php';
include_once '../../member/function.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
$userinfo = user::getinfo($uid);
$sporttime = 121;
$sportpage = 'index';
$sporttab = $_GET['sporttab'];
if (($sporttab != 'ds_tab') && ($sporttab != 'cg_tab') && ($sporttab != 'gq_tab')){
	$sporttab = 'ds_tab';
}
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
  <link rel="stylesheet" href="../css/style.css" type="text/css" media="all"> 
  <link rel="stylesheet" href="../js/jquery.mobile-1.4.5.min.css"> 
  <link rel="stylesheet" href="../css/style_index.css" type="text/css" media="all"> 
  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script> 
  <script type="text/javascript" src="../js/jquery.mobile-1.4.5.min.js"></script> 
  <!--js判断横屏竖屏自动刷新--> 
  <script type="text/javascript" src="../js/top.js"></script> 
  <script type="text/javascript" src="../sports/js/sports.js"></script> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 659px;"> 
  <!--头部开始--> 
  <header id="header"> 
  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
  <span>皇冠体育</span> 
  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 

  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <div data-role="cotent"> 
		  <ul data-role="listview" class="ui-listview"><?php include_once 'sports_head.php';?></ul> 
	  </div> 
	  <div id="ds_div" data-role="collapsibleset" data-theme="a" data-content-theme="a" 
		  data-iconpos="right" data-inset="false" class="ui-collapsible-set ui-group-theme-a" <?=$sporttab != 'ds_tab' ? 'style="display:none;"' : '';?>> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-a"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
			  足球<span class="f_right" id="s_zq">(0)</span> 
			  </h4> 
			  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
				  <li class="ui-first-child"> 
					  <a href="javascript:window.location.href='ft_danshi.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">独赢 & 让球 & 大小 & 单/双<span class="f_right" id="s_zq_ds">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='ft_shangbanchang.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">上半场<span class="f_right" id="s_zq_sbc">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='ft_gunqiu.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">足球滚球<span class="f_right" id="s_zq_gq">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='ft_bodan.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">全场波胆<span class="f_right" id="s_zq_bd">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='ft_shangbanbodan.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">上半场波胆<span class="f_right" id="s_zq_sbbd">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='ft_ruqiushu.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">独赢 & 总入球<span class="f_right" id="s_zq_rqs">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='ft_banquanchang.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">半场/全场<span class="f_right" id="s_zq_bqc">(0)</span></a> 
				  </li> 
				  <li class="ui-last-child"> 
					  <a href="javascript:window.location.href='result_bet_match.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">足球结果<span class="f_right" id="s_zq_jg">(0)</span></a> 
				  </li> 
			  </ul> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
			  足球早餐<span class="f_right" id="s_zqzc">(0)</span> 
			  </h4> 
			  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
				  <li class="ui-first-child"> 
					  <a href="javascript:window.location.href='ftz_danshi.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">独赢 & 让球 & 大小 & 单/双<span class="f_right" id="s_zqzc_ds">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='ftz_shangbanchang.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">上半场<span class="f_right" id="s_zqzc_sbc">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='ftz_bodan.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">全场波胆<span class="f_right" id="s_zqzc_bd">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='ftz_shangbanbodan.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">上半场波胆<span class="f_right" id="s_zqzc_sbbd">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='ftz_ruqiushu.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">独赢 & 总入球<span class="f_right" id="s_zqzc_rqs">(0)</span></a> 
				  </li> 
				  <li class="ui-last-child"> 
					  <a href="javascript:window.location.href='ftz_banquanchang.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">半场/全场<span class="f_right" id="s_zqzc_bqc">(0)</span></a> 
				  </li> 
			  </ul> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
			  篮球<span class="f_right" id="s_lm">(0)</span> 
			  </h4> 
			  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
				  <li class="ui-first-child"> 
					  <a href="javascript:window.location.href='bk_danshi.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">让分 & 大小 & 单/双<span class="f_right" id="s_lm_ds">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='bk_gunqiu.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">篮球滚球<span class="f_right" id="s_lm_gq">(0)</span></a> 
				  </li> 
				  <li class="ui-last-child"> 
					  <a href="javascript:window.location.href='result_lq_match.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">篮球结果<span class="f_right" id="s_lm_jg">(0)</span></a> 
				  </li> 
			  </ul> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
			  篮球早餐<span class="f_right" id="s_lmzc">(0)</span> 
			  </h4> 
			  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
				  <li class="ui-first-child ui-last-child"> 
					  <a href="javascript:window.location.href='bkz_danshi.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">让分 & 大小 & 单/双<span class="f_right" id="s_lmzc_ds">(0)</span></a> 
				  </li> 
			  </ul> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
			  网球<span class="f_right" id="s_wq">(0)</span> 
			  </h4> 
			  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
				  <li class="ui-first-child"> 
					  <a href="javascript:window.location.href='tennis_danshi.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">独赢 & 让盘 & 大小 & 单/双<span class="f_right" id="s_wq_ds">(0)</span></a> 
				  </li> 
				  <li class="ui-last-child"> 
					  <a href="javascript:window.location.href='result_tennis_match.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">网球结果<span class="f_right" id="s_wq_jg">(0)</span></a> 
				  </li> 
			  </ul> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
			  排球<span class="f_right" id="s_pq">(0)</span> 
			  </h4> 
			  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
				  <li class="ui-first-child"> 
					  <a href="javascript:window.location.href='volleyball_danshi.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">让分 & 大小 & 单/双<span class="f_right" id="s_pq_ds">(0)</span></a> 
				  </li> 
				  <li class="ui-last-child"> 
					  <a href="javascript:window.location.href='result_volleyball_match.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">排球结果<span class="f_right" id="s_pq_jg">(0)</span></a> 
				  </li> 
			  </ul> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
			  棒球<span class="f_right" id="s_bq">(0)</span> 
			  </h4> 
			  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
				  <li class="ui-first-child"> 
					  <a href="javascript:window.location.href='baseball_danshi.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">让分 & 大小 & 单/双<span class="f_right" id="s_bq_ds">(0)</span></a> 
				  </li> 
				  <li class="ui-last-child"> 
					  <a href="javascript:window.location.href='result_baseball_match.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">棒球结果<span class="f_right" id="s_bq_jg">(0)</span></a> 
				  </li> 
			  </ul> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"   class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
			  冠军<span class="f_right" id="s_gj">(0)</span> 
			  </h4> 
			  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
				  <li class="ui-first-child"> 
					  <a href="javascript:window.location.href='guanjun.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">足球冠军<span class="f_right" id="s_gj_gj">(0)</span></a> 
				  </li> 
				  <li class="ui-last-child"> 
					  <a href="javascript:window.location.href='guanjun_result.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">冠军结果<span class="f_right" id="s_gj_jg">(0)</span></a> 
				  </li> 
			  </ul> 
		  </div> 
	  </div> 
	  <div id="cg_div" data-role="collapsibleset" data-theme="a" data-content-theme="a" 
		  data-iconpos="right" data-inset="false" class="ui-collapsible-set ui-group-theme-a"<?=$sporttab!='cg_tab' ? 'style="display:none;"' : '';?>> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-a"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
			  今日赛事<span class="f_right" id="cg_f">(0)</span> 
			  </h4> 
			  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
				  <li class="ui-first-child"> 
					  <a href="javascript:window.location.href='cg_ft_danshi.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">足球单式<span class="f_right" id="cg_f_0">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='cg_ft_shangbanchang.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">足球上半场<span class="f_right" id="cg_f_1">(0)</span></a> 
				  </li> 
				  <li class="ui-last-child"> 
					  <a href="javascript:window.location.href='cg_bk_danshi.php'" class="ui-btn ui-btn-icon-right ui-icon-carat-r">篮美单式<span class="f_right" id="cg_f_2">(0)</span></a> 
				  </li> 
			  </ul> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
			  早餐赛事<span class="f_right" id="cg_f1">(0)</span> 
			  </h4> 
			  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
				  <li class="ui-first-child"> 
					  <a href="javascript:window.location.href='cg_ftz_danshi.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">足球单式<span class="f_right" id="cg_f1_0">(0)</span></a> 
				  </li> 
				  <li> 
					  <a href="javascript:window.location.href='cg_ftz_shangbanchang.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">足球上半场<span class="f_right" id="cg_f1_1">(0)</span></a> 
				  </li> 
				  <li class="ui-last-child"> 
					  <a href="javascript:window.location.href='cg_bkz_danshi.php'" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">篮美单式<span class="f_right" id="cg_f1_2">(0)</span></a> 
				  </li> 
			  </ul> 
		  </div> 
	  </div> 
	  <div id="gq_div" data-role="collapsibleset" data-theme="a" data-content-theme="a" 
		  data-iconpos="right" data-inset="false" class="ui-collapsible-set ui-group-theme-a"<?=$sporttab!='ds_tab' ? 'style="display:none;"' : '';?>> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-a"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
			  足球滚球<span class="f_right" id="s_gq_zq_gq">(0)</span> 
			  </h4> 
			  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
				  <li class="ui-first-child ui-last-child"> 
					  <a href="javascript:window.location.href='ft_gunqiu.php';"  data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">足球滚球<span class="f_right" id="s_gq_zq_gq_0">(0)</span></a> 
				  </li> 
			  </ul> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
			  篮球滚球<span class="f_right" id="s_gq_lm_gq">(0)</span> 
			  </h4> 
			  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
				  <li class="ui-first-child ui-last-child"> 
					  <a href="javascript:window.location.href='bk_gunqiu.php';"  data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">篮球滚球<span class="f_right" id="s_gq_lm_gq_0">(0)</span></a> 
				  </li> 
			  </ul> 
		  </div> 
	  </div> 
  </section> 
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once '../member/myinfo.php';?></body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>