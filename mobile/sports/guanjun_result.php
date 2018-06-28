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
$date = date('Y-m-d', time());
if ($_GET['ymd']){
	$date = $_GET['ymd'];
}
$sporttime = 121;
$sportpage = 'result_bet_match';
$sporttab = 'ds_tab';
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
  <link rel="shortcut icon" href="images/favicon.ico"> 
  <link rel="stylesheet" href="css/style.css" type="text/css" media="all"> 
  <link rel="stylesheet" href="js/jquery.mobile-1.4.5.min.css"> 
  <link rel="stylesheet" href="css/style_index.css" type="text/css" media="all"> 
  <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
  <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script> 
  <!--js判断横屏竖屏自动刷新--> 
  <script type="text/javascript" src="js/top.js"></script> 
  <script language="javascript" src="js/guanjun_result.js"></script> 

  <style type="text/css"> 
	  body { 
		  font-size: 14px;
		  font-family: "微软雅黑";
		  margin: 0;
		  padding: 0;
		  border: 5px solid #CCCCCA;
		  background-color: #CCCCCA;
		  overflow-x: hidden;
		  _width: 97%;
	  } 

	  td, th { 
		  display: table-cell;
		  vertical-align: middle;
	  } 
	
	  #datashow table{ 
			  width:100%;
			  border: #63432E solid 1px;
			  background-color: #FFF;
			  text-shadow: none;
	  } 

	  .box th { 
		  color: #000;
		  background-color: #F6F2CF;
		  line-height: 20px;
		  font-weight: 100;
		  border: #63432E solid 1px;
	  } 

	  .box .line { 
		  line-height: 16px;
	  } 

	  .box .zhong { 
		  text-align: center;
	  } 
	
	  .box td { 
		  background-color: #FFF;
		  border: #63432E solid 1px;
	  } 
	
	  .red { 
		  color: #F00;
	  } 
  </style> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active mobile" data-role="page" tabindex="0" style="min-height: 659px;"  onload="loaded('<?=$date;?>',0);"> 

  <input type="hidden" name="uid" id="uid" value="<?=$userinfo['uid'];?>" /> 

  <!--头部开始--> 
  <header id="header"> 
  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
  <span>皇冠体育</span> 
  <a href="javascript:window.location.href='../'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束-->
  
  <?php include_once 'common/show_bet.php';?>	  
  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <div data-role="cotent"> 
		  <ul data-role="listview" class="ui-listview">
			  <?php include_once 'sports_head.php';?>				  
			  <li class="ui-li-static ui-body-inherit"> 
				  <div style="float:left;"> 
					  冠军 -> 结果 
				   </div> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <div class="selectTime">
					  <?php $ymd = $_GET['ymd'];?>
					  <label class="time">选择日期查看： 
					  <select name="time" id="time" data-role="none" onChange="for_choose_time();">
					  <?php for ($i = 0;$i < 7;$i++){?> 										  
					  <option value="<?=date('Y-m-d',time()-($i * 86400));?>"<?=$ymd == date('Y-m-d', time() - ($i * 86400)) ? 'selected="selected"' : '';?>> <?=date('Y-m-d', time() - ($i * 86400));?></option>
					  <?php }?> 									  
					  </select> 
					  </label> 
				  </div> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit" id="loading"> 
				  <div style="width:190px;margin:0px auto;"> 
					  <img src="/skin/sports/loading.gif" border="0" /><br /> 
					  赛事数据正在加载中...... 
				  </div> 
			  </li> 
			
			  <li class="ui-li-static ui-body-inherit" id="nomatch" style="display:none;"> 
				  <div style="width:190px;margin:0px auto;"> 
					  暂无赛事 
				  </div> 
			  </li> 
			
			  <li class="ui-li-static ui-body-inherit" id="matchpage" style="display:none;"> 
				  <div style="float:right;"> 
					  <select name="lsm" id="lsm" data-role="none" onChange="for_choose_lsm();" style="width:150px;height:20px;"> 
						  <option value="" selected="">选择联赛</option> 
					  </select> 
				  </div> 
				  <div style="float:left;" id="page_a"> 
				  </div> 
			  </li> 
			
			  <div id="datashow" style="background-color: #FFF;"> 
				
			  </div> 
		  </ul> 
	  </div> 
  </section> 
  <!--底部开始--><?php include_once 'bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once 'myinfo.php';?>
  </body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>