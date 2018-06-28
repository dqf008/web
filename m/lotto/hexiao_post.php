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
include_once '_pankouinfo.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
$class1 = '生肖';
$money = 0;
$class2 = $_GET['class2'];
$result = $_POST['betValue'];
$money = $_POST['num_1'];
$pl = $_POST['min_bl'];
$result = substr($result, 1);
if (!preg_match('/^[1-9]\\d*$/', $money)){
	echo '<script type="text/javascript">alert("请输入合法的金额！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}
?> 
<!DOCTYPE html> 
  <!-- saved from url=(0069)http://yh77796.com/m/liuhecai/hexiao_ck.php?class2=%E4%B8%83%E8%82%96 --> 
  <html class="ui-mobile ui-mobile-viewport ui-overlay-a"><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8"><!--<base href="http://yh77796.com/m/liuhecai/hexiao_ck.php?class2=%E4%B8%83%E8%82%96">--><base href="."> 
           
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> 
  <meta content="yes" name="apple-mobile-web-app-capable"> 
  <meta content="black" name="apple-mobile-web-app-status-bar-style"> 
  <meta content="telephone=no" name="format-detection"> 
  <meta name="viewport" content="width=device-width"> 
  <link rel="shortcut icon" href="http://yh77796.com/m/images/favicon.ico"> 
  <link rel="stylesheet" href="../css/style.css"> 
  <link rel="stylesheet" href="../js/jquery.mobile-1.4.5.min.css"> 
  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script> 
  <script type="text/javascript" src="../js/jquery.mobile-1.4.5.min.js"></script> 
  <!--js判断横屏竖屏自动刷新--> 
  <script type="text/javascript" src="../js/top.js"></script>    
        <title><?=$web_site['web_title'];?></title> 
      </head> 
      <body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-url="/m/liuhecai/hexiao_ck.php?class2=七肖" tabindex="0" style="min-height: 577px;"> 
	  <!--头部开始--> 
	  <header id="header">
	  <?php if ($uid != 0){?> 			  
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a>
	  <?php }?> 	          
	  <span>六合彩</span> 
	  <a  href="javascript:window.location.href='../index.php'"  class="ico ico_home ico_home_r ui-link"></a> 
	  </header> 
	  <div class="mrg_header"></div> 
	  <div style="display: none;" id="popupPanel-placeholder"></div> 
	  <!--头部结束--> 


          <section class="sliderWrap clearfix"> 
              <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit"> 
                  <h1 class="ui-title" role="heading" aria-level="1"><?=$class2;?></h1> 
              </div> 
          </section> 
          <section class="mContent" style="padding-left:0px;padding-right:0px;padding-top:5px;"> 
              <div data-role="tabs" id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all"> 
                  <form name="lt_form" id="lt_form" method="post" action="hexiao_kantan.php" data-role="none" data-ajax="false"> 
                  <ul data-role="listview" class="ui-listview ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist"> 
                      <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
                          <span><font color="#990000">确认注单</font></span> 
                      </li> 
                      <li class="ui-li-static ui-body-inherit"> 
                          <span>内容：<font color="#FF0000"><?=$result;?></font></span> 
                      </li> 
                      <li class="ui-li-static ui-body-inherit"> 
                          <span>赔率：<?=$class2;?>@<?=$pl;?></span> 
                      </li> 
                      <li class="ui-li-static ui-body-inherit"> 
                          <span>下注金额：<?=$money;?></span> 
                      </li> 
                      <li class="ui-li-static ui-body-inherit ui-last-child"> 
                          <span>可蠃金额：<?=$money * $pl;?></span> 
                      </li> 
                      <input type="hidden" name="class1" value="<?=$class1;?>"> 
                      <input type="hidden" name="class2" value="<?=$class2;?>"> 
                      <input type="hidden" name="gold" value="<?=$money;?>"> 
                      <input type="hidden" name="number" value="<?=$result;?>"> 
                  </ul> 
                  <div style="clear:both;padding-top:10px;padding-left:10px;"> 
                      <div style="clear:both;text-align:center;"> 
                          <a href="#" onClick="back();"  class="ui-btn ui-btn-inline">放弃</a> 
                          <a href="javascript:void(0);" onClick="submitForm();return false;" class="ui-btn ui-btn-inline">确定</a> 
                      </div> 
                  </div> 
                  </form> 
              </div> 
          </section> 
	       <!--底部--> 
		  <!--底部开始--><?php include_once '../bottom.php';?>		  <!--底部结束--> 
		  <!--我的资料--><?php include_once '../member/myinfo.php';?>
         <script type="text/javascript"> 

			  function back(){ 
				  window.history.back(-1);
			  } 

          
              function submitForm(){ 
                  document.getElementById("lt_form").submit();
              } 
          </script> 
  </body> 
  <div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div></html>