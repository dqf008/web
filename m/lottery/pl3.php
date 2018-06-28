<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '../../include/lottery.inc.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
if (intval($web_site['pl3']) == 1){
	message('体彩排列3系统维护，暂停下注！');
	exit();
}
$params = array(':kaipan' => $l_time, ':fengpan' => $l_time);
$stmt = $mydata1_db->prepare('select * from lottery_k_pl3 where kaipan<:kaipan and fengpan>:fengpan');
$stmt->execute($params);
$trow = $stmt->fetch();
$tcou = $stmt->rowCount();
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
		  .xuanhao ul {  
			  width: 33%;
			  padding-top:5px;
			  float:left;
		  }  
		  .xuanhao ul li{  
			  background-color: #f8f8f8;
			  line-height:24px;
		  }  
		  .xuanhao .baiwei li{  
			  border-left:1px solid #DDD;
			  border-right:1px solid #DDD;
			  border-bottom:1px solid #DDD;
			  text-align: center;
		  }  
		  .xuanhao .shiwei li{  
			  border-bottom:1px solid #DDD;
			  text-align: center;
		  }  
		  .xuanhao .gewei li{  
			  border-left:1px solid #DDD;
			  border-right:1px solid #DDD;
			  border-bottom:1px solid #DDD;
			  text-align: center;
		  } 
		  .xuanhao .hezhi li{  
			  border-left:1px solid #DDD;
			  border-right:1px solid #DDD;
			  border-bottom:1px solid #DDD;
			  text-align: center;
		  }  
		  .daxiao ul {  
			  width: 25%;
			  padding-top: 5px;
			  float:left;
		  }  
		  .daxiao ul li{  
			  background-color: #f8f8f8;
			  line-height: 24px;
		  }  
		  .daxiao .baiwei li{ 
			  border-left:1px solid #DDD;
			  border-right:1px solid #DDD;
			  border-bottom:1px solid #DDD;
			  text-align: center;
		  }  
		  .daxiao .shiwei li{  
			  border-bottom:1px solid #DDD;
			  border-right:1px solid #DDD;
			  text-align: center;
		  }  
		  .daxiao .gewei li{  
			  border-bottom:1px solid #DDD;
			  text-align: center;
		  }  
		  .daxiao .hezhi li{  
			  border-left:1px solid #DDD;
			  border-right:1px solid #DDD;
			  border-bottom:1px solid #DDD;
			  text-align: center;
		  }  
		  .caipiao-info {  
			  border-width: 1px;
			  border-color: lightgray;
			  border-style: solid;
			  padding: 5px;
		  } 
	  </style> 
  </head> 
  <body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 659px;"> 
	  <input id="uid" value="<?=$uid;?>" type="hidden"/> 
	  <input id="stype" value="1" type="hidden"/> 
	  <!--头部开始--> 
	  <header id="header">
		  <?php if ($uid != 0){?><a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a><?php }?> 			  
		  <span>彩票游戏</span> 
		  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"> 
		  </a> 
	  </header> 
	  <div class="mrg_header"> 
	  </div> 
	  <!--头部结束--> 
	  <div style="display: none;" id="popupPanel-placeholder"> 
		  <!-- placeholder for popupPanel --> 
	  </div> 
	  <section class="sliderWrap clearfix"> 
		  <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit"> 
			  <h1 class="ui-title" role="heading" aria-level="1"> 
				  体彩排列3 
			  </h1> 
		  </div> 
		  <div class="caipiao-info">
		  	  <?php if (0 < $tcou){?> <div style="font-size:12pt;">第<span style="color:#f60;"><?=$trow['qihao'];?></span>期</div> 
			  <div style="font-size:12pt;">北京时间：<?=$trow['fengpan'];?></div> 
			  <div style="font-size:12pt;">美东时间：<?=mdtime($trow['fengpan']);?></div> 
			  <div style="font-size:12pt;">                    
				  <span id="endtime" style="color:#f60;font-weight:bold;"><?=strtotime(mdtime($trow['fengpan']))-time();?></span> 
			  </div>
			  <?php }else{?> 				 
			  <div style="font-size:12pt;">期数未开盘</div>
			  <?php }?> 			  
			  </div> 
	  </section> 
	  <!--赛事列表--> 
	  <section class="mContent clearfix" style="padding:0px;margin-top:-9px;"> 
		  <div data-role="tabs" id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all"> 
			  <div data-role="navbar" class="ui-navbar" role="navigation"> 
				  <ul class="ui-grid-b ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" 
				  role="tablist"> 
					  <li class="ui-block-a ui-state-default ui-corner-top ui-tabs-active ui-state-active" 
					  role="tab" tabindex="0" aria-controls="one" aria-labelledby="ui-id-1" aria-selected="true"> 
						  <a href="#one" data-ajax="false" class="ui-btn-active ui-link ui-btn ui-tabs-anchor" 
						  role="presentation" tabindex="-1" id="ui-id-1"> 
							  选号 
						  </a> 
					  </li> 
					  <li class="ui-block-b ui-state-default ui-corner-top" role="tab" tabindex="-1" 
					  aria-controls="two" aria-labelledby="ui-id-2" aria-selected="false"> 
						  <a href="#two" data-ajax="false" class="ui-link ui-btn ui-tabs-anchor" 
						  role="presentation" tabindex="-1" id="ui-id-2"> 
							  和值 
						  </a> 
					  </li> 
					  <li class="ui-block-c ui-state-default ui-corner-top" role="tab" tabindex="-1" 
					  aria-controls="three" aria-labelledby="ui-id-3" aria-selected="false"> 
						  <a href="#three" data-ajax="false" class="ui-link ui-btn ui-tabs-anchor" 
						  role="presentation" tabindex="-1" id="ui-id-3"> 
							  大小 
						  </a> 
					  </li> 
				  </ul> 
			  </div> 
			  <!-- one div start --> 
			  <div id="one" class="ui-body-d ui-content ui-tabs-panel ui-widget-content ui-corner-bottom" 
			  style="padding:0px;" aria-labelledby="ui-id-1" role="tabpanel" aria-expanded="true" 
			  aria-hidden="false"> 
				  <fieldset data-role="controlgroup" data-type="horizontal" style="margin-bottom:0px;" 
				  class="ui-controlgroup ui-controlgroup-horizontal ui-corner-all"> 
					  <div class="ui-controlgroup-controls "> 
						  <div class="ui-radio ui-mini"> 
							  <label for="radio-choice-h-2a" class="ui-btn ui-corner-all ui-btn-inherit ui-radio-on ui-btn-active ui-first-child"> 
								  直选 
							  </label> 
							  <input name="radio-choice-h-2" id="radio-choice-h-2a" value="on" checked="checked" 
							  type="radio" data-mini="true" onClick="setSelect(1);"> 
						  </div> 
						  <div class="ui-radio ui-mini"> 
							  <label for="radio-choice-h-2b" class="ui-btn ui-corner-all ui-btn-inherit ui-radio-off"> 
								  组一 
							  </label> 
							  <input name="radio-choice-h-2" id="radio-choice-h-2b" value="off" type="radio" 
							  data-mini="true" onClick="setSelect(2);"> 
						  </div> 
						  <div class="ui-radio ui-mini"> 
							  <label for="radio-choice-h-2c" class="ui-btn ui-corner-all ui-btn-inherit ui-radio-off"> 
								  组二 
							  </label> 
							  <input name="radio-choice-h-2" id="radio-choice-h-2c" value="other" type="radio" 
							  data-mini="true" onClick="setSelect(3);"> 
						  </div> 
						  <div class="ui-radio ui-mini"> 
							  <label for="radio-choice-h-2d" class="ui-btn ui-corner-all ui-btn-inherit ui-radio-off"> 
								  组三 
							  </label> 
							  <input name="radio-choice-h-2" id="radio-choice-h-2d" value="other" type="radio" 
							  data-mini="true" onClick="setSelect(4);"> 
						  </div> 
						  <div class="ui-radio ui-mini"> 
							  <label for="radio-choice-h-2e" class="ui-btn ui-corner-all ui-btn-inherit ui-radio-off"> 
								  组六 
							  </label> 
							  <input name="radio-choice-h-2" id="radio-choice-h-2e" value="other" type="radio" 
							  data-mini="true" onClick="setSelect(5);"> 
						  </div> 
						  <div class="ui-radio ui-mini"> 
							  <label for="radio-choice-h-2f" class="ui-btn ui-corner-all ui-btn-inherit ui-radio-off ui-last-child"> 
								  跨度 
							  </label> 
							  <input name="radio-choice-h-2" id="radio-choice-h-2f" value="other" type="radio" 
							  data-mini="true" onClick="setSelect(6);"> 
						  </div> 
					  </div> 
				  </fieldset> 
				  <div class="xuanhao" style="clear:both;" data-role="none"> 
					  <ul class="baiwei" data-role="none"> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;" 
						  data-role="none"> 
							  百位 
						  </li> 
						  <li id="0" data-role="none" onClick="check_bet(this.id);"> 
							  0 
						  </li> 
						  <li id="1" data-role="none" onClick="check_bet(this.id);"> 
							  1 
						  </li> 
						  <li id="2" data-role="none" onClick="check_bet(this.id);"> 
							  2 
						  </li> 
						  <li id="3" data-role="none" onClick="check_bet(this.id);"> 
							  3 
						  </li> 
						  <li id="4" data-role="none" onClick="check_bet(this.id);"> 
							  4 
						  </li> 
						  <li id="5" data-role="none" onClick="check_bet(this.id);"> 
							  5 
						  </li> 
						  <li id="6" data-role="none" onClick="check_bet(this.id);"> 
							  6 
						  </li> 
						  <li id="7" data-role="none" onClick="check_bet(this.id);"> 
							  7 
						  </li> 
						  <li id="8" data-role="none" onClick="check_bet(this.id);"> 
							  8 
						  </li> 
						  <li id="9" data-role="none" onClick="check_bet(this.id);"> 
							  9 
						  </li> 
					  </ul> 
					  <ul class="shiwei" data-role="none"> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;" 
						  data-role="none"> 
							  十位 
						  </li> 
						  <li id="10" data-role="none" onClick="check_bet(this.id);"> 
							  0 
						  </li> 
						  <li id="11" data-role="none" onClick="check_bet(this.id);"> 
							  1 
						  </li> 
						  <li id="12" data-role="none" onClick="check_bet(this.id);"> 
							  2 
						  </li> 
						  <li id="13" data-role="none" onClick="check_bet(this.id);"> 
							  3 
						  </li> 
						  <li id="14" data-role="none" onClick="check_bet(this.id);"> 
							  4 
						  </li> 
						  <li id="15" data-role="none" onClick="check_bet(this.id);"> 
							  5 
						  </li> 
						  <li id="16" data-role="none" onClick="check_bet(this.id);"> 
							  6 
						  </li> 
						  <li id="17" data-role="none" onClick="check_bet(this.id);"> 
							  7 
						  </li> 
						  <li id="18" data-role="none" onClick="check_bet(this.id);"> 
							  8 
						  </li> 
						  <li id="19" data-role="none" onClick="check_bet(this.id);"> 
							  9 
						  </li> 
					  </ul> 
					  <ul class="gewei" data-role="none"> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;" 
						  data-role="none"> 
							  个位 
						  </li> 
						  <li id="20" data-role="none" onClick="check_bet(this.id);"> 
							  0 
						  </li> 
						  <li id="21" data-role="none" onClick="check_bet(this.id);"> 
							  1 
						  </li> 
						  <li id="22" data-role="none" onClick="check_bet(this.id);"> 
							  2 
						  </li> 
						  <li id="23" data-role="none" onClick="check_bet(this.id);"> 
							  3 
						  </li> 
						  <li id="24" data-role="none" onClick="check_bet(this.id);"> 
							  4 
						  </li> 
						  <li id="25" data-role="none" onClick="check_bet(this.id);"> 
							  5 
						  </li> 
						  <li id="26" data-role="none" onClick="check_bet(this.id);"> 
							  6 
						  </li> 
						  <li id="27" data-role="none" onClick="check_bet(this.id);"> 
							  7 
						  </li> 
						  <li id="28" data-role="none" onClick="check_bet(this.id);"> 
							  8 
						  </li> 
						  <li id="29" data-role="none" onClick="check_bet(this.id);"> 
							  9 
						  </li> 
					  </ul> 
				  </div> 
				  <div style="clear:both;text-align:center;"> 
					  <button class="ui-btn ui-btn-inline" onClick="add_bet()"> 
						  确认注单 
					  </button> 
				  </div> 
			  </div> 
			  <!-- one div end --> 
			  <!-- two div start --> 
			  <div id="two" class="ui-body-d ui-content ui-tabs-panel ui-widget-content ui-corner-bottom" 
			  style="padding: 0px;display: none;" aria-labelledby="ui-id-2" role="tabpanel" 
			  aria-expanded="false" aria-hidden="true"> 
				  <div class="xuanhao" style="clear:both;" data-role="none"> 
					  <ul class="hezhi" data-role="none"> 
						  <li data-role="none" onClick="sub_addhzbet(0);"> 
							  0 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(1);"> 
							  1 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(2);"> 
							  2 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(3);"> 
							  3 
						  </li> 
						  <li onClick="sub_addhzbet('0,1,2,3');"> 
							  X40.00 
						  </li> 
					  </ul> 
					  <ul class="hezhi" data-role="none"> 
						  <li data-role="none" onClick="sub_addhzbet(4);"> 
							  4 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(5);"> 
							  5 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(6);"> 
							  6 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(7);"> 
							  7 
						  </li> 
						  <li onClick="sub_addhzbet('4,5,6,7');"> 
							  X8.00 
						  </li> 
					  </ul> 
					  <ul class="hezhi" data-role="none"> 
						  <li data-role="none" onClick="sub_addhzbet(8);"> 
							  8 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(9);"> 
							  9 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(10);"> 
							  10 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(11);"> 
							  11 
						  </li> 
						  <li onClick="sub_addhzbet('8,9,10,11');"> 
							  X3.50 
						  </li> 
					  </ul> 
					  <ul class="hezhi" data-role="none"> 
						  <li data-role="none" onClick="sub_addhzbet(12);"> 
							  12 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(13);"> 
							  13 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(14);"> 
							  14 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(15);"> 
							  15 
						  </li> 
						  <li onClick="sub_addhzbet('12,13,14,15');"> 
							  X2.80 
						  </li> 
					  </ul> 
					  <ul class="hezhi" data-role="none"> 
						  <li data-role="none" onClick="sub_addhzbet(16);"> 
							  16 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(17);"> 
							  17 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(18);"> 
							  18 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(19);"> 
							  19 
						  </li> 
						  <li onClick="sub_addhzbet('16,17,18,19');"> 
							  X3.50 
						  </li> 
					  </ul> 
					  <ul class="hezhi" data-role="none"> 
						  <li data-role="none" onClick="sub_addhzbet(20);"> 
							  20 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(21);"> 
							  21 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(22);"> 
							  22 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(23);"> 
							  23 
						  </li> 
						  <li onClick="sub_addhzbet('20,21,22,23');"> 
							  X8.00 
						  </li> 
					  </ul> 
					  <ul class="hezhi" data-role="none"> 
						  <li data-role="none" onClick="sub_addhzbet(24);"> 
							  24 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(25);"> 
							  25 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(26);"> 
							  26 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet(27);"> 
							  27 
						  </li> 
						  <li onClick="sub_addhzbet('24,25,26,27');"> 
							  X40.00 
						  </li> 
					  </ul> 
				  </div> 
			  </div> 
			  <!-- two div end --> 
			  <!-- three div start --> 
			  <div id="three" class="ui-body-d ui-content ui-tabs-panel ui-widget-content ui-corner-bottom" 
			  style="padding: 0px;display: none;" aria-labelledby="ui-id-3" role="tabpanel" 
			  aria-expanded="false" aria-hidden="true"> 
				  <div class="daxiao" style="clear:both;" data-role="none"> 
					  <ul class="baiwei" data-role="none"> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;" 
						  data-role="none"> 
							  百位 
						  </li> 
						  <li data-role="none" onClick="sub_adddxbet('百位','DAN')"> 
							  单 
						  </li> 
						  <li data-role="none" onClick="sub_adddxbet('百位','SHUANG')"> 
							  双 
						  </li> 
						  <li data-role="none" onClick="sub_adddxbet('百位','DA')"> 
							  大 
						  </li> 
						  <li data-role="none" onClick="sub_adddxbet('百位','XIAO')"> 
							  小 
						  </li> 
					  </ul> 
					  <ul class="shiwei" data-role="none"> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;" 
						  data-role="none"> 
							  十位 
						  </li> 
						  <li data-role="none" onClick="sub_adddxbet('十位','DAN')"> 
							  单 
						  </li> 
						  <li data-role="none" onClick="sub_adddxbet('十位','SHUANG')"> 
							  双 
						  </li> 
						  <li data-role="none" onClick="sub_adddxbet('十位','DA')"> 
							  大 
						  </li> 
						  <li data-role="none" onClick="sub_adddxbet('十位','XIAO')"> 
							  小 
						  </li> 
					  </ul> 
					  <ul class="gewei" data-role="none"> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;" 
						  data-role="none"> 
							  个位 
						  </li> 
						  <li data-role="none" onClick="sub_adddxbet('个位','DAN')"> 
							  单 
						  </li> 
						  <li data-role="none" onClick="sub_adddxbet('个位','SHUANG')"> 
							  双 
						  </li> 
						  <li data-role="none" onClick="sub_adddxbet('个位','DA')"> 
							  大 
						  </li> 
						  <li data-role="none" onClick="sub_adddxbet('个位','XIAO')"> 
							  小 
						  </li> 
					  </ul> 
					  <ul class="hezhi" data-role="none"> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;" 
						  data-role="none"> 
							  和值 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet('DAN')"> 
							  单 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet('SHUANG')"> 
							  双 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet('DA')"> 
							  大 
						  </li> 
						  <li data-role="none" onClick="sub_addhzbet('XIAO')"> 
							  小 
						  </li> 
					  </ul> 
				  </div> 
			  </div> 
			  <!-- three div end --> 
			  <div style="clear:both;padding-top:10px;padding-left:10px;" id="sbbut"> 
				  <span> 
					  <font style="color:red;font-size:10pt;"> 
						  注：点击下注 
					  </font> 
					  <span> 
					  </span> 
				  </span> 
			  </div> 
		  </div> 
	  </section> 
	  <div style="display: none;" id="xiazhu-placeholder"><!-- placeholder for xiazhu --></div> 
	
	  <!--底部开始--><?php include_once '../bottom.php';?>		  <!--底部结束--> 
	  <!--我的资料--><?php include_once '../member/myinfo.php';?>		
	  <script type="text/javascript"> 
		  //显示距离封盘的动态时间 
		  var CID = "endtime";
		  <?php if (0 < $tcou){?> 			  
		  if(window.CID != null){ 
			  var iTime = document.getElementById(CID).innerHTML;
			  var Account;
			  RemainTime();
		  }
		  <?php }?> 			  
		  function RemainTime(){ 
			  var iDay,iHour,iMinute,iSecond;
			  var sDay="",sHour="",sMinute="",sSecond="",sTime="";

			  if(iTime >= 0){ 
				  iDay = parseInt(iTime/24/3600);
				  if(iDay > 0 && iDay < 10){ 
					  sDay = "0" +iDay + "天";
				  } 
				  if(iDay > 10){ 
					  sDay = iDay + "天";
				  } 
				  iHour = parseInt((iTime/3600)%24);
				  if(iHour > 0 && iHour < 10){ 
					  sHour = "0" + iHour + "小时";
				  } 
				  if(iHour > 10){ 
					  sHour = iHour + "小时";
				  } 
				  iMinute = parseInt((iTime/60)%60);
				  if(iMinute > 0 && iMinute < 10){ 
					  sMinute = "0" + iMinute + "分钟";
				  } 
				  if(iMinute > 10){ 
					  sMinute = iMinute + "分钟";
				  } 
				  iSecond = parseInt(iTime%60);
				  if(iSecond >= 0 && iSecond <10 ){ 
					  sSecond = "0" +iSecond + "秒";
				  } 
				  if(iSecond >= 10){ 
					  sSecond = iSecond + "秒";
				  } 
				  if((sDay=="")&&(sHour=="")){ 
					  sTime = "距离封盘：" + sMinute+sSecond + "";
				  }else{ 
					  sTime = "距离封盘：" + sDay+sHour+sMinute+sSecond;
				  } 
				  if(iTime==0){ 
					  clearTimeout(Account);
					  sTime = "本期已经封盘，即将开始下一期";
				  } 
				  if(iTime==-5){ 
					  clearTimeout(Account);
					  sTime = "开始下一期";
				  }else{ 
					  Account = setTimeout("RemainTime()",1000);
				  } 
				  iTime = iTime-1;
			  }else{ 
				  sTime = "开始下一期";
				  alert("本期投注已结束，点击开始下一期投注!");
				  window.location.reload();
			  } 
			  document.getElementById(CID).innerHTML = sTime;
		  } 
		
	  </script> 
	
	  <script type="text/javascript"> 
		  $(document).ready(function() { 
			  setSelect(1);
		  });
		  var xh = new Array();// 选号对应标签ID数组 
		

		  var bwsum = 0;
		  var bwnum = '';
		  var swsum = 0;
		  var swnum = '';
		  var gwsum = 0;
		  var gwnum = '';
		  var classname = '';// 玩法 
		  function check_bet(sb) { //选号检测 
			  if (isLogin() == false) { 
				  alert("登录后才能进行此操作");
				  return;
			  } 

			  var stype = getType();

			  // 选号规则 
			  if (stype == 4) { 
				  if (eval("xh[" + sb + "]") == false) { 
					  if (sb <= 9) { 
						  if (eval(xh[sb * 1 + 20 * 1]) == true) { 
							  return false;
						  } 
						  $("#" + sb).attr("style", "background-color:#5CACEE");
						  $("#" + (sb * 1 + 10 * 1)).attr("style", "background-color:#5CACEE");
						  $("#" + (sb * 1 + 20 * 1)).removeAttr("style");
						  eval("xh[" + sb + "]=true");
						  $("#" + (sb * 1 + 20 * 1)).attr("style", "text-decoration: line-through;");
						
					  } else { 
						  if (eval(xh[sb * 1 - 20 * 1]) == true) { 
							  return false;
						  } 
						  $("#" + sb).attr("style", "background-color:#5CACEE");
						  $("#" + (sb * 1 - 10 * 1)).removeAttr("style");
						  $("#" + (sb * 1 - 20 * 1)).removeAttr("style");
						  eval("xh[" + sb + "]=true");
						  $("#" + (sb * 1 - 10 * 1)).attr("style", "text-decoration: line-through;");
						  $("#" + (sb * 1 - 20 * 1)).attr("style", "text-decoration: line-through;");
						
					  } 
				  } else { 
					  if (sb <= 9) { 
						  $("#" + sb).removeAttr("style");
						  $("#" + (sb * 1 + 10 * 1)).removeAttr("style");
						  $("#" + (sb * 1 + 20 * 1)).removeAttr("style");
						  eval("xh[" + sb + "]=false");
						  $("#" + (sb * 1 + 10 * 1)).attr("style", "text-decoration: line-through;");
						
					  } else { 
						  $("#" + sb).removeAttr("style");
						  $("#" + (sb * 1 - 10 * 1)).removeAttr("style");
						  $("#" + (sb * 1 - 20 * 1)).removeAttr("style");
						  eval("xh[" + sb + "]=false");
						  $("#" + (sb * 1 - 10 * 1)).attr("style", "text-decoration: line-through;");
					  } 
				  } 
			  } else if (stype == 5) { 
				  if (eval("xh[" + sb + "]") == false) { 
					  if (sb <= 9) { 
						  if (eval(xh[sb * 1 + 10 * 1]) == true || eval(xh[sb * 1 + 20 * 1]) == true) { 
							  return false;
						  } 
						  $("#" + sb).attr("style", "background-color:#5CACEE");
						  $("#" + (sb * 1 + 10 * 1)).removeAttr("style");
						  $("#" + (sb * 1 + 20 * 1)).removeAttr("style");
						  $("#" + (sb * 1 + 10 * 1)).attr("style", "text-decoration: line-through;");
						  $("#" + (sb * 1 + 20 * 1)).attr("style", "text-decoration: line-through;");
						  eval("xh[" + sb + "]=true");
					  } else if (sb > 9 && sb <= 19) { 
						  if (eval(xh[sb - 10]) == true || eval(xh[sb * 1 + 10 * 1]) == true) { 
							  return false;
						  } 
						  $("#" + sb).attr("style", "background-color:#5CACEE");
						  $("#" + (sb * 1 - 10 * 1)).removeAttr("style");
						  $("#" + (sb * 1 + 10 * 1)).removeAttr("style");
						  eval("xh[" + sb + "]=true");
						  $("#" + (sb * 1 - 10 * 1)).attr("style", "text-decoration: line-through;");
						  $("#" + (sb * 1 + 10 * 1)).attr("style", "text-decoration: line-through;");
					  } else { 
						  if (eval(xh[sb - 10]) == true || eval(xh[sb - 20]) == true) { 
							  return false;
						  } 
						  $("#" + sb).attr("style", "background-color:#5CACEE");
						  $("#" + (sb * 1 - 10 * 1)).removeAttr("style");
						  $("#" + (sb * 1 - 20 * 1)).removeAttr("style");
						  eval("xh[" + sb + "]=true");
						  $("#" + (sb * 1 - 10 * 1)).attr("style", "text-decoration: line-through;");
						  $("#" + (sb * 1 - 20 * 1)).attr("style", "text-decoration: line-through;");
					  } 
				  } else { 
					  if (sb <= 9) { 
						  $("#" + sb).removeAttr("style");
						  $("#" + (sb * 1 + 10 * 1)).removeAttr("style");
						  $("#" + (sb * 1 + 20 * 1)).removeAttr("style");
						  eval("xh[" + sb + "]=false");
					  } else if (sb > 9 && sb <= 19) { 
						  $("#" + sb).removeAttr("style");
						  $("#" + (sb * 1 - 10 * 1)).removeAttr("style");
						  $("#" + (sb * 1 + 10 * 1)).removeAttr("style");
						  eval("xh[" + sb + "]=false");
					  } else { 
						  $("#" + sb).removeAttr("style");
						  $("#" + (sb * 1 - 10 * 1)).removeAttr("style");
						  $("#" + (sb * 1 - 20 * 1)).removeAttr("style");
						  eval("xh[" + sb + "]=false");
					  } 
				  } 
			  } else { 
				  if (eval("xh[" + sb + "]") == false) { 
					  $("#" + sb).attr("style", "background-color:#5CACEE");
					  eval("xh[" + sb + "]=true");
				  } else { 
					  $("#" + sb).removeAttr("style");
					  eval("xh[" + sb + "]=false");
				  } 
			  } 

			  bwsum = 0;
			  bwnum = '';
			  swsum = 0;
			  swnum = '';
			  gwsum = 0;
			  gwnum = '';
			  classname = '';
			  for (i = 0;i < 30;i++) { 
				  if (i <= 9) { 
					  if (eval("xh[" + i + "]") == true) { 
						  bwsum += 1;
						  bwnum = bwnum + i + ",";
					  } 

					  $("#bwnums").html("百位：" + bwnum);
				  } 
				  if (i > 9 && i <= 19) { 
					  if (eval("xh[" + i + "]") == true) { 
						  swsum += 1;
						  swnum = swnum + (i - 10) + ",";
					  } 

					  if (stype == 4) { 
						  $("#swnums").html("十位：" + bwnum);
					  } else { 
						  $("#swnums").html("十位：" + swnum);
					  } 
				  } 
				  if (i > 19) { 
					  if (eval("xh[" + i + "]") == true) { 
						  gwsum += 1;
						  gwnum = gwnum + (i - 20) + ",";
					  } 

					  $("#gwnums").html("个位：" + gwnum);
				  } 
			  } 

			  if (stype == 1) { 
				  if (bwnum != "" && swnum != "" && gwnum != "") { 
					  classname = "3D";
				  } else if (bwnum != "" && swnum == "" && gwnum == "") { 
					  classname = "1D 百位";
				  } else if (bwnum == "" && swnum != "" && gwnum == "") { 
					  classname = "1D 十位";
				  } else if (bwnum == "" && swnum == "" && gwnum != "") { 
					  classname = "1D 个位";
				  } else if (bwnum != "" && swnum != "" && gwnum == "") { 
					  classname = "2D 百位 十位";
				  } else if (bwnum != "" && swnum == "" && gwnum != "") { 
					  classname = "2D 百位 个位";
				  } else if (bwnum == "" && swnum != "" && gwnum != "") { 
					  classname = "2D 十位 个位";
				  } 
			  } 
			  if (stype == 2) { 
				  classname = "组一";
			  } 
			  if (stype == 3) { 
				  classname = "组二";
			  } 
			  if (stype == 4) { 
				  classname = "组三";
			  } 
			  if (stype == 5) { 
				  classname = "组六";
			  } 

			  $("#classnames").html(classname);
		  } 
		  function add_bet() { //确认注单-选号 
			  var stype = getType();

			  if (stype == 1 || stype == 2) { 
				  if (bwsum == 0 && swsum == 0 && gwsum == 0) { 
					  return;
				  } 
			  } 
			  if (stype == 3) { 
				  if (bwnum == "" || swnum == "") { 
					  return;
				  } 
			  } 
			  if (stype == 4) { 
				  if (bwnum == "" || gwnum == "") { 
					  return;
				  } 
			  } 
			  if (stype == 5) { 
				  if (bwnum == "" || swnum == "" || gwnum == "") { 
					  return;
				  } 
			  } 
			
			  showMsg();
		  } 
		  function del_bet() { //取消注单 
			  for (i = 0;i < 30;i++) { 
				  xh[i] = false;
				  $("#" + i).removeAttr("style");
			  } 

			  bwsum = 0;
			  bwnum = '';
			  swsum = 0;
			  swnum = '';
			  gwsum = 0;
			  gwnum = '';
			  classname = '';

			  closeMsg();
		  } 
		  function sub_addbet() { //确认下注 
			  if (isLogin() == false) { 
				  alert("登录后才能进行此操作");
				  return;
			  } 

			  var stype = getType();
			  var bwhm = $("#bwnums").html();
			  var swhm = $("#swnums").html();
			  var gwhm = $("#gwnums").html();
			  bwhm = bwhm.replace("百位：", "");
			  swhm = swhm.replace("十位：", "");
			  gwhm = gwhm.replace("个位：", "");
			

			  var url = '';
			  if (stype == 1) { 
				  url = "pl3_ck.php?stype=1&bw=" + bwhm + "&sw=" + swhm + "&gw=" + gwhm;
			  } 
			  if (stype == 2) { 
				  url = "pl3_ck.php?stype=2&sw=" + swhm;
			  } 
			  if (stype == 3) { 
				  url = "pl3_ck.php?stype=3&bw=" + bwhm + "&sw=" + swhm;
			  } 
			  if (stype == 4) { 
				  url = "pl3_ck.php?stype=4&bw=" + bwhm + "&sw=" + swhm + "&gw=" + gwhm;
			  } 
			  if (stype == 5) { 
				  url = "pl3_ck.php?stype=5&bw=" + bwhm + "&sw=" + swhm + "&gw=" + gwhm;
			  } 
			  if (url != '') { 
				  window.location.href = url;
				  $('#radio-choice-h-2a').click();
			  } 
			
		  } 
		  function sub_addkdbet(id) { //确认下注-跨度 
			  if (isLogin() == false) { 
				  alert("登录后才能进行此操作");
				  return;
			  } 

			  var url = '';
			  url = "pl3_ck.php?stype=6&content=" + id;
			  window.location.href = url;
			  $('#radio-choice-h-2a').click();
		  } 
		  function sub_addhzbet(id) { //确认下注-和值 
			  if (isLogin() == false) { 
				  alert("登录后才能进行此操作");
				  return;
			  } 

			  var url = '';
			  url = "pl3_ck.php?stype=7&content=" + id;
			  window.location.href = url;
			  $('#radio-choice-h-2a').click();
		  } 
		  function sub_adddxbet(class3, id) { //确认下注-大小单双 
			  if (isLogin() == false) { 
				  alert("登录后才能进行此操作");
				  return;
			  } 

			  var url = '';
			  url = "pl3_ck.php?stype=8&class3=" + class3 + "&content=" + id;
			  window.location.href = url;
			  $('#radio-choice-h-2a').click();
		  } 
		  function showMsg() { 

			  $("#xiazhu").popup("open");
		  } 
		  function closeMsg() { 

			  $("#xiazhu").popup("close");
		  } 
		  function isLogin() { 
			  var uid = $("#uid").val();
			  if (uid == 0 || uid==null ) { 
				  return false;
			  } 

			  return true;
		  } 
		  function getType() { 

			  return $("#stype").val();
		  } 
		  function setSelect(num) { //初始化选号 
			  bwsum = 0;
			  bwnum = '';
			  swsum = 0;
			  swnum = '';
			  gwsum = 0;
			  gwnum = '';
			  classname = '';
			
			  for (i = 0;i < 30;i++) { 
				  xh[i] = false;
				  $("#" + i).removeAttr("style");
			  } 

			  switch (num) { 
				  case 1: 
					  $("#stype").val(1);
					  for (i = 0;i < 30;i++) { 
						  $("#" + i).attr("onclick", "check_bet(this.id);");
					  } 
					  break;
				  case 2: 
					  $("#stype").val(2);
					  for (i = 0;i < 30;i++) { 
						  if (i > 9 && i < 20) { 
							  $("#" + i).attr("onclick", "check_bet(this.id);");
						  } else { 
							  $("#" + i).removeAttr("onclick");
							  $("#" + i).attr("style", "text-decoration: line-through;");
						  } 
					  } 
					  break;
				  case 3: 
					  $("#stype").val(3);
					  for (i = 0;i < 30;i++) { 
						  if (i >= 0 && i < 20) { 
							  $("#" + i).attr("onclick", "check_bet(this.id);");
						  } else { 
							  $("#" + i).removeAttr("onclick");
							  $("#" + i).attr("style", "text-decoration: line-through;");
						  } 
					  } 
					  break;
				  case 4: 
					  $("#stype").val(4);
					  for (i = 0;i < 30;i++) { 
						  if ((i >= 0 && i < 10) || (i > 19 && i < 30)) { 
							  $("#" + i).attr("onclick", "check_bet(this.id);");
						  } else { 
							  $("#" + i).removeAttr("onclick");
							  $("#" + i).attr("style", "text-decoration: line-through;");
						  } 
					  } 
					  break;
				  case 5: 
					  $("#stype").val(5);
					  for (i = 0;i < 30;i++) { 
						  $("#" + i).attr("onclick", "check_bet(this.id);");
					  } 
					  break;
				  case 6: 
					  $("#stype").val(6);
					  for (i = 0;i < 30;i++) { 
						  if (i >= 0 && i < 10) { 
							  $("#" + i).attr("onclick", "sub_addkdbet(this.id);");
						  } else { 
							  $("#" + i).removeAttr("onclick");
							  $("#" + i).attr("style", "text-decoration: line-through;");
						  } 
					  } 
					  break;
			  } 
		  } 
	  </script> 
	
	  <!--确认下注----> 
	  <div class="ui-screen-hidden ui-popup-screen ui-overlay-inherit" id="xiazhu-screen"> 
	  </div> 
	  <div class="ui-popup-container ui-popup-hidden ui-popup-truncate" id="xiazhu-popup"> 
		  <div data-role="popup" id="xiazhu" class="ui-popup ui-body-inherit ui-overlay-shadow ui-corner-all"> 
			  <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right"> 
				  Close 
			  </a> 
			  <div style="margin:5px 2px 5px 2px;padding:1px 1px 1px 1px;"> 
				  <div style="clear:both;padding-bottom:5px;border-bottom-width:1px;border-color:#DDD;border-style:solid;"> 
					  <b> 
						  <p id="classnames" style="clear:both;text-align:center;"> 
							  玩法 
						  </p> 
					  </b> 
				  </div> 
				  <div style="clear:both;margin-top:5px;padding-bottom:5px;border-bottom-width:1px;border-color:#DDD;border-style:solid;"> 
					  <p> 
						  注单内容： 
					  </p> 
					  <p id="bwnums"> 
						  百位： 
					  </p> 
					  <p id="swnums"> 
						  十位： 
					  </p> 
					  <p id="gwnums"> 
						  个位： 
					  </p> 
					  <button class="ui-btn ui-btn-inline" onClick="del_bet()"> 
						  取消下注 
					  </button> 
					  <button class="ui-btn ui-btn-inline" onClick="sub_addbet()"> 
						  确认下注 
					  </button> 
				  </div> 
			  </div> 
		  </div> 
	  </div> 
  </body> 
  <div class="ui-loader ui-corner-all ui-body-a ui-loader-default"> 
	  <span class="ui-icon-loading"> 
	  </span> 
	  <h1> 
		  loading 
	  </h1> 
  </div> 
</html>