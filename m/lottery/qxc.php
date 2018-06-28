<?php 
include_once './_qxc.php';
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
			  <h1 class="ui-title" role="heading" aria-level="1">七星彩</h1> 
		  </div> 
		  <div class="caipiao-info">
		  <?php if (0 < $tcou){?> 				  
		  	  <div style="font-size:12pt;">第<span style="color:#f60;"><?=$trow['qishu'];?></span>期</div> 
			  <div style="font-size:12pt;">北京时间：<?php echo date('Y-m-d H:i:s', $trow['fengpan']);?></div> 
			  <div style="font-size:12pt;">美东时间：<?php echo date('Y-m-d H:i:s', $trow['fengpan']-43200);?></div> 
			  <div style="font-size:12pt;">                    
				  <span id="endtime" style="color:#f60;font-weight:bold;"><?php echo $trow['fengpan']-time()-43200;?></span> 
			  </div>
		  <?php }else{?> 				  
		      <div style="font-size:12pt;">期数未开盘</div>
		  <?php }?> 			  
		  </div> 
	  </section> 
      <!--赛事列表--> 
      <section class="mContent clearfix" style="padding:0px;"> 
          <div data-role="collapsibleset" data-theme="a" data-content-theme="a" 
              data-iconpos="right" data-inset="false" class="ui-collapsible-set ui-group-theme-a"> 
              <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-a"> 
                  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">定位</h4> 
                  <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-a "> 
                      <li class="ui-first-child"> 
                          <a href="javascript:window.location.href='qxc_dw.php?i=2';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">二定玩法</a></li> 
                      <li class="ui-last-child"> 
                          <a href="javascript:window.location.href='qxc_dw.php?i=3';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">三定玩法</a> 
                      </li> 
                      <li class="ui-last-child"> 
                          <a href="javascript:window.location.href='qxc_dw.php?i=4';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">四定玩法</a> 
                      </li> 
                      <li class="ui-last-child"> 
                          <a href="javascript:window.location.href='qxc_dw.php?i=1';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">一定位</a> 
                      </li> 
                  </ul>     
              </div> 
              <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-a"> 
                  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">字现</h4> 
                  <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-a "> 
                      <li class="ui-first-child"> 
                          <a href="javascript:window.location.href='qxc_zx.php?i=2';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">二字现</a></li> 
                      <li class="ui-last-child"> 
                          <a href="javascript:window.location.href='qxc_zx.php?i=3';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">三字现</a> 
                      </li> 
                  </ul>     
              </div> 
		  </div> 
	  </section> 
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
					  sTime = "已封盘";
				  } 
				  if(iTime==-5){ 
					  clearTimeout(Account);
					  sTime = "已封盘";
				  }else{ 
					  Account = setTimeout("RemainTime()",1000);
				  } 
				  iTime = iTime-1;
			  }else{ 
				  sTime = "已封盘";
			  } 
			  document.getElementById(CID).innerHTML = sTime;
		  } 
		
	  </script> 
  </body> 
</html>