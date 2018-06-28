<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '_pankouinfo.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
$class1 = '连码';
$class2 = $_POST['class2'];
$odds = $_POST['odds'];
$betlist = $_POST['betlist'];
$money = $_POST['money'];
if ($class2 == ''){
	echo '<script type="text/javascript">alert("该页面禁止刷新！");window.location.href="/m/lotto/index.php";</script>';
	exit();
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
	  .xiazhu .biaodan li{
		  width: 20%;
		  height: 28px;
		  border-bottom:1px solid #DDD;
		  text-align:center;
		  float:left;
	  }
	  .xiazhu .biaodan1 li{
		  width: 25%;
		  height: 28px;
		  border-bottom:1px solid #DDD;
		  text-align: center;
		  line-height: 28px;
		  float:left;
	  }
  </style>
</head>
  <body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 659px;">
	  <!--头部开始-->
	  <header id="header">
	  <?php if ($uid != 0){?> 			  
	  	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a>
	  <?php }?> 			  
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
	  <section class="sliderWrap clearfix" style="margin-top:1px;">
		  <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit">
			  <h1 class="ui-title" role="heading" aria-level="1">
				  六合彩
			  </h1>
		  </div>
	  </section>
	  <section class="mContent" style="padding-left:0px;padding-right:0px;padding-top:5px;">
		  <div data-role="tabs" id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
			  <div id="three" class="ui-body-d ui-content" style="padding:0px;">
				  <div style="clear:both;padding-bottom:5px;border-bottom-width:1px;border-color:#DDD;border-style:solid;text-align:center;">
					  <b>
						  <p>
							  <font color="#990000"><?=$class1;?> - <?=$class2;?></font>注单内容
						  </p>
					  </b>
				  </div>
				  <div style="clear:both;padding-bottom:5px;border-bottom-width:1px;border-color:#DDD;border-style:solid;text-align:center;">
					  <p>
						  ☆最小金额:
						  <font color="#FF0000"><?=$cp_zd;?></font>
						  &nbsp;&nbsp;☆单注限额:
						  <font color="#FF0000"><?=$cp_zg;?></font>
					  </p>
				  </div>
				  <div class="xiazhu" style="clear:both;" data-role="none">
					  <ul class="biaodan1 ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all"
					  data-role="none" role="tablist">
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:40%;"
						  data-role="none">
							  选号
						  </li>
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:40%;"
						  data-role="none">
							  赔率
						  </li>
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:20%;"
						  data-role="none">
							  金额
						  </li>
					  </ul>
					  <ul class="biaodan1" data-role="none">
					  <?php 
					   $betlist = $_POST['betlist'];
						$betlistArray = explode('|', $betlist);
						if (0 < $money){
							for ($i = 0;$i < count($betlistArray);$i++){
					  ?> 							  
					  	  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:40%;" data-role="none">
							  <p><?=$betlistArray[$i];?></p>
						  </li>
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:40%;"
						  data-role="none">
							  <p id="odd_<?=$i;?>" style="color:#FF0000;"><?=$odds;?></p>
						  </li>
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:20%;"
						  data-role="none">
								  <p id="money_<?=$i;?>"><?=$money;?></p>
						  </li>
					  <?php }
					  }?>
 				      </ul>
				  </div>
			  </div>
			
			  <div style="clear:both;padding-top:10px;padding-left:10px;">
				  <span>
					  <font style="font-size:10pt;">共：<span style="color:red;"><?=count($betlistArray);?></span>组注单，总金额：<span style="color:red;"><?=count($betlistArray) * $money;?></span></font>
				  <span>
				  </span></span>
			  </div>
			
			  <form name="form" id="form" action="lianma_katan.php" method="POST">
				  <input type="hidden" name="class1" id="class1" value="<?=$class1;?>">
				  <input type="hidden" name="class2" id="class2" value="<?=$class2;?>">
				  <input type="hidden" name="money" id="money" value="<?=$money;?>">
				  <input type="hidden" name="betlist" id="betlist" value="<?=$betlist;?>">
				  <div style="clear:both;padding-top:10px;padding-left:10px;">
					  <div style="clear:both;text-align:center;">
						  <a href="javascript:goBack();" class="ui-btn ui-btn-inline">
							  取消下注
						  </a>
						  <a href="javascript:formSubmit();" class="ui-btn ui-btn-inline">
							  确认下注
						  </a>
					  </div>
				  </div>
			  </form>
			  <div style="clear:both;padding-top:10px;padding-left:10px;">
				  <span>
					  <font style="color:red;font-size:10pt;">注：该页面禁止刷新</font>
				  <span>
				  </span></span>
			  </div>
		  </div>
	  </section>
	  <!--底部开始--><?php include_once '../bottom.php';?>		  <!--底部结束-->
	  <!--我的资料--><?php include_once '../member/myinfo.php';?>		
	  <script type="text/javascript" src="../js/script.js"></script>
	  <script type="text/javascript">
		
		  function goBack() { //取消下注
			  window.location.href = "index.php";
		  }
		  function formSubmit() { //提交表单
			   document.form.submit();
		  }
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