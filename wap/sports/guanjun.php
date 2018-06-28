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
$sportpage = 'guanjun';
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
  <script type="text/javascript" src="js/sports.js"></script> 
  <script type="text/javascript" src="js/guanjun.js"></script> 
  <script type="text/javascript" src="js/bet_guanjun_match.js"></script> 
  <style> 
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

	  .mContent table{ 
		  width:100%;
		  border: #63432E solid 1px;
		  background-color: #FFF;
		  text-shadow: none;
	  } 
	  .mContent th{ 
		  border: #63432E solid 1px;
	  } 
	  .mContent td{ 
		  border: #63432E solid 1px;
	  } 
	  .mContent .wzjz,.mContent .wzjz td { 
		  text-align:center;
		  vertical-align:middle;
		  height:25px;
	  } 
	
	  .box .liansai_g { 
		  text-align: left;
		  background: #F6F2CF;
	  } 
	
	  .box th { 
		  color: #000;
		  background-color: #C6A770;
		  line-height: 20px;
		  font-weight: 100;
	  } 
	
	  .box .liansai_g a { 
		  margin-left: 5px;
		  display: inline;
		  color: #000;
	  } 
	
	  .box .liansai_g span { 
		  float: right;
		  margin-right: 5px;
	  } 
	
	  .box .saishi_g { 
		  background-color: #e9e9e9;
		  line-height: 22px;
		  text-align: center;
		  font-weight: bold;
	  } 

	  .box .xiangmu_g { 
		  padding-left: 5px;
		  height:25px;
		  vertical-align:middle;
	  } 
	  .box td { 
		  background-color: #FFF;
	  } 
	
	  .xiangmu_g a { 
		  color: #F00;
		  font-weight: bold;
		  text-decoration: none;
		  float:right;
		  margin-right: 5px;
	  } 
	
	  .liansai a{ 
		  padding-left:5px;
		  color: #000;
	  } 
	  .odds { 
		  float:right;
		  padding-right:5px;
	  } 
	  .odds a{ 
		  color: #F00;
	  } 
	  .pankou{ 
		  float:left;
		  padding-left:5px;
	  } 
	  .eachmatch{ 
		  background-color: #e9e9e9;
		  color: #333;
	  } 
  </style> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active mobile" data-role="page" tabindex="0" style="min-height: 659px;"  onload="loaded(document.getElementById('league').value,0);"> 

  <input type="hidden" name="uid" id="uid" value="<?=$userinfo['uid'];?>" /> 
  <input type="hidden" name="touzhutype" id="touzhutype" value="0" /> 
  <input type="hidden" name="league" id="league" value="" /> 
  <input type="hidden" name="aaaaa" id="aaaaa" value="" /> 

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
					  足球 -> 冠军 
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
			
			  <div id="showsaishi" style="background-color: #FFF;"> 
				  <table border="0" cellspacing="1" cellpadding="0" bgcolor="#ACACAC" class="box"> 
					  <tbody> 
						  <tr class="liansai"> 
							  <td colspan="5"> 
								  <a href="javascript:void(0)" title="选择 >> 美國職業大聯盟" onClick="javascript:choose_lsm('美國職業大聯盟');">美國職業大聯盟</a> 
							  </td> 
						  </tr> 
						  <tr class="wzjz eachmatch"> 
							  <td colspan="2" width="20%">07-13<br>10:30p<br><font color="red">滾球</font></td> 
							  <td width="35%"><span>主队</span><br><span>波特蘭木材</span></td> 
							  <td width="35%"><span>客队</span><br><span>蒙特利爾衝擊</span></td> 
							  <td width="10%"><span>和局</span></td></tr><tr class="wzjz"> 
							  <td rowspan="3" class="wzjz">全场</td> 
							  <td class="wzjz"><span>独赢</span></td> 
							  <td> 
								  <span class="odds"> 
									  <a href="javascript:void(0)" title="波特蘭木材" onClick="javascript:setbet('足球单式','独赢-波特蘭木材-独赢','2348892','Match_BzM','0','0','波特蘭木材');" style="">1.85</a> 
								  </span> 
							  </td> 
							  <td> 
								  <span class="odds"> 
									  <a href="javascript:void(0)" title="蒙特利爾衝擊" onClick="javascript:setbet('足球单式','独赢-蒙特利爾衝擊-独赢','2348892','Match_BzG','0','0','蒙特利爾衝擊');" style="">4.30</a> 
								  </span> 
							  </td> 
							  <td> 
								  <span class="odds"> 
									  <a href="javascript:void(0)" title="和局" onClick="javascript:setbet('足球单式','独赢-和局','2348892','Match_BzH','0','0','和局');" style="">3.60</a> 
								  </span> 
							  </td> 
						  </tr> 
						  <tr class="wzjz"> 
							  <td class="wzjz"><span>让球</span></td> 
							  <td> 
								  <span class="pankou">0.5</span> 
								  <span class="odds"> 
									  <a href="javascript:void(0)" title="波特蘭木材" onClick="javascript:setbet('足球单式','让球-主让0.5-波特蘭木材','2348892','Match_Ho','1','0','波特蘭木材');" style="">0.86</a> 
								  </span> 
							  </td> 
							  <td> 
								  <span class="pankou"></span> 
								  <span class="odds"> 
									  <a href="javascript:void(0)" title="蒙特利爾衝擊" onClick="javascript:setbet('足球单式','让球-主让0.5-蒙特利爾衝擊','2348892','Match_Ao','1','0','蒙特利爾衝擊');" style="">1.06</a> 
								  </span> 
							  </td> 
							  <td> 
								  <span></span> 
							  </td> 
						  </tr> 
					  </tbody></table> 
			  </div> 
		  </ul> 
	  </div> 
  </section> 
  <!--底部开始--><?php include_once 'bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once 'myinfo.php';?></body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>