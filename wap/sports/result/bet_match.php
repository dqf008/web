<?php 
session_start();
include_once '../../../include/config.php';
website_close();
website_deny();
include_once '../../../database/mysql.config.php';
include_once '../../../common/function.php';
include_once '../../../class/user.php';
include_once '../../../include/newpage.php';
include_once '../../../member/function.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
$userinfo = user::getinfo($uid);
$sporttime = 121;
$sportpage = 'ft_danshi';
$sporttab = 'ds_tab';
$date = date('Y-m-d', time());
if ($_GET['ymd']){
	$date = $_GET['ymd'];
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
  <script type="text/javascript" src="/m/js/top.js"></script> 
  <script type="text/javascript" src="../sports/js/sports.js"></script> 
  <style> 
	  .mContent table{ 
		  width:100%;
		  border: #63432E solid 1px;
		  background-color: #FFF;
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
	  } 
	  .liansai{ 
		  text-align:left!important;
		  background-color: #F6F2CF;
		  color: #000;
	  } 
	  .liansai a{ 
		  padding-left:5px;
		  color: #000;
	  } 
	  .odds { 
		   
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
		  text-shadow: 0 1px 0 #eee;
	  } 
	  .result_title li{ 
		  float: left;
		  background: #fff;
		  text-align: center;
		  margin-left: 5px;
		  margin-top: 3px;
	  } 
	  .result_title li a:hover,.result_title li.i{ 
		  background: #024467;
		  font-weight: bold;
		  color: #FFF;
		  padding: 0 10px;
		  line-height: 20px;
	  } 
	  .box{ 
			  font-family: "微软雅黑";
			  font-size: 14px;
			  font: 14px/1.5 "Microsoft Yahei";
	  } 
  </style> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active mobile" data-role="page" tabindex="0" style="min-height: 659px;"> 

  <input type="hidden" name="uid" id="uid" value="<?=$userinfo['uid'];?>" /> 
  <input type="hidden" name="touzhutype" id="touzhutype" value="0" /> 
  <input type="hidden" name="league" id="league" value="" /> 
  <input type="hidden" name="aaaaa" id="aaaaa" value="" /> 

  <!--头部开始--> 
  <header id="header"> 
  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
  <span>皇冠体育</span> 
  <a href="javascript:window.location.href='../../'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--><?php include_once '../common/show_bet.php';?>	  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <div data-role="cotent"> 
		  <ul data-role="listview" class="ui-listview"><?php include_once '../sports_head.php';?>				  
			  <li class="ui-li-static ui-body-inherit"> 
				<div style="float:left;">足球 -> 足球结果</div> 
			  </li>  	
		  </ul> 
		  <div> 
		  <div class="result_title">
		<?php 
		                                                                                                                                                                                                                                              
		?>
			  </div> 
		  </div> 
		  <table border="0" cellspacing="1" cellpadding="0" class="box" bgcolor='#ACACAC'> 
			  <tr class="wzjz eachmatch"> 
				  <td width="30%">开赛时间</td> 
				  <td width="48%">主场 / 客场</td> 
				  <td width="11%">上半比分</td> 
				  <td width="11%">全场比分</td> 
			  </tr>
			  <?php 
			    $params[':match_Date'] = date('m-d', strtotime($date));
				$sql = 'select Match_MatchTime, Match_Type,match_name,match_master,match_guest,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from mydata4_db.bet_match where match_Date=:match_Date and (MB_Inball is not null or MB_Inball_HR is not NULL) and (match_js=1 or match_sbjs=1) order by Match_CoverDate,iPage,iSn,Match_ID,match_name,Match_Master ';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				$rows = $stmt->fetch();
				if (!$rows){
					echo "<tr><td height='100' colspan='4' align='center' bgcolor='#FFFFFF'>暂无任何赛果</td></tr>";
				}else{
					do{
					if ($temp_match_name != $rows['match_name']){
						$temp_match_name = $rows['match_name'];
			  ?>				  
			  <tr class="wzjz eachmatch"> 
				  <td colspan="4"  class='liansai'><strong><?=$rows['match_name'];?></strong></td> 
			  </tr>
		<?php continue;
			}?> 				  
			  <tr> 
				  <td class='zhong line' align="center"><?=$rows['Match_MatchTime'];?></td> 
				  <td class='line'><?=$rows['match_master'];?><br /><font color="#990000"><?=$rows['match_guest'];?></font></td> 
				  <td class='zhong line red' align="center"><?=$rows['MB_Inball'] < 0 ? '赛事无效' : $rows['MB_Inball_HR']?><br /><?=$rows['TG_Inball'] < 0 ? '赛事无效' : $rows['TG_Inball_HR'];?></td> 
				  <td class='zhong line red' align="center"><?=$rows['MB_Inball'] < 0 ? '赛事无效' : $rows['MB_Inball'];?><br /><?=$rows['TG_Inball'] < 0 ? '赛事无效' : $rows['TG_Inball'];?>	</td> 
			  </tr>
	<?php }
while ($rows = $stmt->fetch());}?> 			  
		</table> 
	  </div> 
  </section> 
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once '../myinfo.php';?></body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>