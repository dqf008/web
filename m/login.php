<?php 
session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/logintu.php';
include_once '../common/function.php';
include_once '../class/user.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html> 
  <head> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
	  <title><?=$web_site['web_title'];?></title> 
	  <!--[if lt IE 9]> 
		  <script src="js/html5.js" type="text/javascript"> 
		  </script> 
		  <script src="js/css3-mediaqueries.js" type="text/javascript"> 
		  </script> 
	  <![endif]--> 
	  <meta name="viewport" content="width=device-width, initial-scale=1"> 
	  <script type="text/javascript" src="js/jquery-1.9.1.min.js"> 
	  </script> 
	  <script type="text/javascript" src="js/jquery.SuperSlide.2.1.1.js"> 
	  </script> 
	  <link rel="shortcut icon" href="images/favicon.ico"> 
	  <link rel="stylesheet" href="css/style.css" type="text/css" media="all"> 
	  <link rel="stylesheet" href="css/style_index.css" type="text/css" media="all"> 
	  <!--js判断横屏竖屏自动刷新--> 
	  <script type="text/javascript" src="js/top.js"></script> 
  </head> 
  <body> 
	  <!--头部开始--> 
	  <header id="header"> 
		  <a href="/m/index.php" class="ico ico_home"></a> 
		  <span><?=$web_site['web_name'];?></span> 
	  </header> 
	  <!--头部结束--> 
	  <!--内容开始--> 
	  <div id="main" class="cl mrg_header"> 
		  <div class="login_ico"> 
			  <img src="../static/images/mobile_logo.png" style="margin:30px auto 20px auto"> 
		  </div> 
		  <div class="register w login"> 
			  <ul> 
				  <li class="cl first"> 
					  <div class="fl f"> 
						  <label>账&nbsp;&nbsp;&nbsp;号：</label> 
					  </div> 
					  <div class="fr f"> 
						  <input type="text" placeholder="请输入您的账号" value="" id="username" name="username" maxlength="16" tabindex="1"> 
					  </div> 
				  </li> 
				  <li class="cl"> 
					  <div class="fl f"> 
						  <label>密&nbsp;&nbsp;&nbsp;码：</label> 
					  </div> 
					  <div class="fr f"> 
						  <input type="password" placeholder="请输入您的密码" value="" id="password" name="password" maxlength="20" tabindex="2"> 
					  </div> 
				  </li> 
				  <li class="cl"> 
					  <div class="fl f"> 
						  <label>验证码：</label> 
					  </div> 
					  <div class="fr f" style="position: relative;"> 
						  <input name="rmNum" placeholder="请输入验证码" id="rmNum" size="4" maxlength="4" title="( 点选此处产生新验证码 )" tabindex="3" type="text" /> 
						  <img id="vPic" border="1" style="float: right;position: absolute;right:40px;top:5px;width:25%;" onclick="javascript:getKey();"/> 
					  </div> 
				  </li> 
			  </ul> 
			  <div class="submit cl"> 
				  <div class="f fl"> 
					  <div class="lbg"> 
						  <div class="rbg"> 
							  <input type="submit" name="submit1" onclick="javascript:window.location.href='register.php'" value="注册"> 
						  </div> 
					  </div> 
				  </div> 
				  <div class="f fr"> 
					  <div class="lbg"> 
						  <div class="rbg"> 
							  <script type="text/javascript"> 
								  getKey();
							  </script> 
							  <input type="submit" name="submit2" onclick="loginSubmit();" value="登录"> 
						  </div> 
					  </div> 
				  </div> 
			  </div> 
		  </div> 
		  <div class="kefu"> 
			  <a class="a1" href="javascript:void(0);" onclick="Go_forget_pwd();">忘记密码？</a> 
			  <a class="a2" href="javascript:void(0);" onclick="menu_url(62);return false;">联系在线客服</a> 
		  </div> 
	  </div> 
	  <!--内容结束--> 
	  <!--底部开始--><?php include_once 'bottom.php';?>        <!--底部结束--> 
  </body> 
</html>