<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '../../cache/group_' . @($_SESSION['gid']) . '.php';
include_once '_pankouinfo.php';

if(isset($_GET['xp']) && $_GET['xp']){
    $xp = $_GET['xp'];
    include_once($xp);
}


$cp_zd = @($pk_db['彩票最低']);
$cp_zg = @($pk_db['彩票最高']);
if (0 < $cp_zd)
{
	$cp_zd = $cp_zd;
}
else
{
	$cp_zd = $lowbet;
}
if (0 < $cp_zg)
{
	$cp_zg = $cp_zg;
}
else
{
	$cp_zg = 1000000;
}
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
		  #collapsibles div{ 
			  padding: 0 15px 5px 10px;
		  } 
		  #collapsibles ul{ 
			  padding: 0 0 0 10px;
		  } 
	  .ui-block-a, .ui-block-b, .ui-block-c {
		  border: 1px solid black;
		  height: 35px;
		  font-weight: bold;
	  }
	  .lhc-bgc-a {
		  padding-top: 2px;
		  background-color: #FCF8E9;
	  }
	  .lhc-bgc-a1 {
		  padding-top: 6px;
		  background-color: #FCF8E9;
	  }
	  .lhc-bgc-b {
		  padding-top: 6px;
		  background-color: #EEEEEE;
	  }
	  .lhc-bgc-c {
		  padding-top: 2px;
		  background-color: #EEEEEE;
	  }
	  .lhc-bgc-abc {
		  padding-top: 6px;
		  background-color: lightgray;
	  }
	  .lhc-circle-a {
		  width: 30px;
		  height: 30px;
		  background-color: #ffc1c1;
		  border-radius: 20px;
	  }
	  .lhc-circle-b {
		  height: 30px;
		  line-height: 30px;
		  display: block;
		  color: #000;
		  text-align: center;
		  font-size: 18px;
	  }
	  .lhc-info {
		  border-width: 1px;
		  border-color: lightgray;
		  border-style: solid;
		  padding: 5px;
	  }
	  #lt_form {
		  text-align: center;
	  }
  </style>
  </head> 
  <body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 659px;"> 
	  <!--头部开始--> 
	  <header id="header"><?php if ($uid != 0){?> 		 
	  	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a><?php }?>
	  	  <span>彩票游戏</span> 
		  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
	  </header> 
	  <div class="mrg_header"></div> 
	  <!--头部结束--> 
  <section class="sliderWrap clearfix">
	  <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit">
	  <h1 class="ui-title" role="heading" aria-level="1">六合彩</h1>
	  </div><?php include_once '_pankouinfoshow.php';?></section>
	  <!--赛事列表--> 
	  <section class="mContent clearfix" style="padding:0px;"> 
		  <div data-role="collapsibleset" data-theme="a" data-content-theme="a" 
			  data-iconpos="right" data-inset="false" class="ui-collapsible-set ui-group-theme-a"> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-a"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  特码 
				  </h4> 
				  <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-a "> 
					  <li class="ui-first-child"> 
						  <a href="javascript:window.location.href='tema.php?ids=特A';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">特码A</a></li> 
					  <li class="ui-last-child"> 
						  <a href="javascript:window.location.href='tema.php?ids=特B';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">特码B</a> 
					  </li> 
				  </ul>  	
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  正码 
				  </h4> 
				  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
					  <li class="ui-first-child"> 
						  <a href="javascript:window.location.href='zhengma.php?ids=正A';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正码A</a> 
					  </li> 
					  <li class="ui-last-child"> 
						  <a href="javascript:window.location.href='zhengma.php?ids=正B';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正码B</a> 
					  </li> 
				  </ul> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  正码特 
				  </h4> 
				  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
					  <li class="ui-first-child"> 
						  <a href="javascript:window.location.href='zhengmate.php?ids=正1特';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正1特</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='zhengmate.php?ids=正2特';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正2特</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='zhengmate.php?ids=正3特';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正3特</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='zhengmate.php?ids=正4特';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正4特</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='zhengmate.php?ids=正5特';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正5特</a> 
					  </li> 
					  <li class="ui-last-child"> 
						  <a href="javascript:window.location.href='zhengmate.php?ids=正6特';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正6特</a> 
					  </li> 
				  </ul> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  正码1-6 
				  </h4> 
				  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
					  <li class="ui-first-child"> 
						  <a href="javascript:window.location.href='zhengma1to6.php?ids=正码1';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正码1</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='zhengma1to6.php?ids=正码2';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正码2</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='zhengma1to6.php?ids=正码3';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正码3</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='zhengma1to6.php?ids=正码4';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正码4</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='zhengma1to6.php?ids=正码5';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正码5</a> 
					  </li> 
					  <li class="ui-last-child"> 
						  <a href="javascript:window.location.href='zhengma1to6.php?ids=正码6';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">正码6</a> 
					  </li> 
				  </ul> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  过关 
				  </h4> 
				  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
					  <li class="ui-first-child ui-last-child"> 
						  <a href="javascript:window.location.href='guoguan.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">过关</a> 
					  </li> 
				  </ul> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  连码 
				  </h4> 
				  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
					  <li class="ui-first-child ui-last-child"> 
						  <a href="javascript:window.location.href='lianma.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">连码</a> 
					  </li> 
				  </ul> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  半波 
				  </h4> 
				  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
					  <li class="ui-first-child ui-last-child"> 
						  <a href="javascript:window.location.href='banbo.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">半波</a> 
					  </li> 
				  </ul> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"   class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  一肖/尾数 
				  </h4> 
				  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
					  <li class="ui-first-child"> 
						  <a href="javascript:window.location.href='yixiaoweishu.php?ids=一肖';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">一肖</a> 
					  </li> 
					  <li class="ui-last-child"> 
						  <a href="javascript:window.location.href='yixiaoweishu.php?ids=正特尾数';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">尾数</a> 
					  </li> 
				  </ul> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  特码生肖 
				  </h4> 
				  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
					  <li class="ui-first-child ui-last-child"> 
						  <a href="javascript:window.location.href='temashengxiao.php';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">特码生肖</a> 
					  </li> 
				  </ul> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  合肖 
				  </h4> 
				  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
					  <li class="ui-first-child"> 
						  <a href="javascript:window.location.href='hexiao.php?ids=二肖';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">二肖</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='hexiao.php?ids=三肖';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">三肖</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='hexiao.php?ids=四肖';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">四肖</a> 
						  </li> 
					  <li> 
						  <a href="javascript:window.location.href='hexiao.php?ids=五肖';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">五肖</a> 
						  </li> 
					  <li> 
						  <a href="javascript:window.location.href='hexiao.php?ids=六肖';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">六肖</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='hexiao.php?ids=七肖';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">七肖</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='hexiao.php?ids=八肖';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">八肖</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='hexiao.php?ids=九肖';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">九肖</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='hexiao.php?ids=十肖';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">十肖</a> 
					  </li> 
					  <li class="ui-last-child"> 
						  <a href="javascript:window.location.href='hexiao.php?ids=十一肖';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">十一肖</a> 
					  </li> 
				  </ul> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"   class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  生肖连 
				  </h4> 
				  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
					  <li class="ui-first-child"> 
						  <a href="javascript:window.location.href='shengxiaolian.php?ids=二肖连中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">二肖连中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='shengxiaolian.php?ids=三肖连中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">三肖连中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='shengxiaolian.php?ids=四肖连中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">四肖连中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='shengxiaolian.php?ids=五肖连中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">五肖连中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='shengxiaolian.php?ids=二肖连不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">二肖连不中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='shengxiaolian.php?ids=三肖连不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">三肖连不中</a> 
					  </li> 
					  <li class="ui-last-child"> 
						  <a href="javascript:window.location.href='shengxiaolian.php?ids=四肖连不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">四肖连不中</a> 
					  </li> 
				  </ul> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  尾数连 
				  </h4> 
				  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
					  <li class="ui-first-child"> 
						  <a href="javascript:window.location.href='weishulian.php?ids=二尾连中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">二尾连中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='weishulian.php?ids=三尾连中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">三尾连中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='weishulian.php?ids=四尾连中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">四尾连中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='weishulian.php?ids=二尾连不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">二尾连不中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='weishulian.php?ids=三尾连不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">三尾连不中</a> 
					  </li> 
					  <li class="ui-last-child"> 
						  <a href="javascript:window.location.href='weishulian.php?ids=四尾连不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">四尾连不中</a> 
					  </li> 
				  </ul> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b"  class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  全不中 
				  </h4> 
				  <ul data-role="listview" data-theme="c" data-inset="false" class="ui-listview ui-group-theme-c"> 
					  <li class="ui-first-child"> 
						  <a href="javascript:window.location.href='quanbuzhong.php?ids=五不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">五不中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='quanbuzhong.php?ids=六不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">六不中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='quanbuzhong.php?ids=七不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">七不中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='quanbuzhong.php?ids=八不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">八不中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='quanbuzhong.php?ids=九不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">九不中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='quanbuzhong.php?ids=十不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">十不中</a> 
					  </li> 
					  <li> 
						  <a href="javascript:window.location.href='quanbuzhong.php?ids=十一不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">十一不中</a> 
					  </li> 
					  <li class="ui-last-child"> 
						  <a href="javascript:window.location.href='quanbuzhong.php?ids=十二不中';" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r">十二不中</a> 
					  </li> 
				  </ul> 
			  </div> 
		  </div> 
	  </section> 

	  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
	  <!--我的资料--><?php include_once '../member/myinfo.php';?>
	  </html>