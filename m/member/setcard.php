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
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
if (!empty($userinfo['pay_card'])&&!empty($userinfo['pay_num'])&&!empty($userinfo['pay_address'])){
	message('您已经设置过银行信息，如需帮助请联系在线客服。');
}
if ($_POST['action'] == 'save'){
	$pay_card = htmlEncode($_POST['pay_card']);
	$pay_num = htmlEncode($_POST['pay_num']);
	$pay_address = htmlEncode($_POST['pay_address']);
	$rmNum = $_POST['rmNum'];
	if ($rmNum != $_SESSION['randcode']){
		message('验证码错误，请重新输入');
	}
	$_SESSION['randcode'] = rand(10000, 99999);
	if ($pay_card == ''){
		message('请输入您的收款银行');
	}
	
	if ($pay_num == ''){
		message('请输入您正确的银行账号');
	}
	
	if ($pay_address == ''){
		message('请输入您的开户行地址');
	}
	
	if (user::update_paycard($_SESSION['uid'], $pay_card, $pay_num, $pay_address, $userinfo['pay_name'], $_SESSION['username'])){
		message('恭喜你，银行绑定成功', 'getmoney.php');
		exit();
	}else{
		message('设置出错，请重新设置你的银行卡信息', 'setcard.php');
	}
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
  </head> 
  <body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page"  tabindex="0" style="min-height: 544px;"> 
	  <!--头部开始--> 
	  <header id="header"> 
		  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
		  <span>绑定账号</span> 
		  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
	  </header> 
	  <div class="mrg_header"></div> 
	  <!--头部结束--> 
	
	  <!--功能列表--> 
	  <section class="mContent clearfix" style="padding:0px;"> 
		  <form action="setcard.php" onSubmit="return submitForm();" method="post" name="lt_form" data-role="none" data-ajax="false"> 
		  <input type="hidden" name="action" value="save"> 
		  <div data-role="cotent"> 
			  <ul data-role="listview" class="ui-listview"> 
				  <li class="ui-li-static ui-body-inherit ui-first-child"> 
					  <label>会员账号：<?=$userinfo['username'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>收款人姓名：<?=$userinfo['pay_name'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>收款银行：<input type="text" id="pay_card" name="pay_card" data-role="none"></label> 
					  <span class="red">* 例如：工商银行</span> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>银行账号：<input type="text" id="pay_num" name="pay_num" data-role="none"></label> 
					  <span class="red">* 请输入您的银行账号</span> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>开户地址：<input type="text" id="pay_address" name="pay_address" data-role="none"></label> 
					  <span class="red">* 请输入省份及城市，如 "辽宁省沈阳市"</span> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit ui-last-child"> 
					  <label>验证码： 
						  <input type="text" name="rmNum" id="rmNum" maxlength="4" style="width:60px;" data-role="none"/>&nbsp;
						  <img  alt="点击更换" name="vPic" id="vPic" style="width: 3.6em;height: 1.6em;cursor: pointer;border:0px;" onClick="getKey();" /> 
						  <script type="text/javascript"> 
							  getKey();
						  </script> 
					  </label> 
					  <span class="red">* 请输入验证码</span> 
				  </li> 
			  </ul> 
			  <div style="clear:both;text-align:center;"> 
				  <button name="btnSubmit" class="ui-btn ui-btn-inline">提交</button> 
			  </div> 
			  <div style="color:red;padding-left:10px;"> 
				  友情提示： 
			  </div> 
			  <ul style="list-style:decimal;padding-left:10px;"> 
				  <li>1.银行账户持有人姓名必须与注册时输入的姓名一致，否则无法申请提款。</li> 
				  <li>2.每位客户只可以使用一张银行卡进行提款，如需要更换银行卡请与客服人员联系；否则提款将被拒绝。</li> 
				  <li>3.为保障客户资金安全，<?=$web_site['web_name'];?>有可能需要用户提供电话单，银行对账单或其它资料验证，以确保客户资金不会被冒领。</li> 
			  </ul> 
		  </div> 
		  </form> 
	  </section> 
	  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
	  <!--我的资料--><?php include_once 'myinfo.php';?>	
	  <script type="text/javascript"> 
		  function submitForm(){ 
			  if(!checkSubmitPay()){ 
				  return false;
			  } 
			  return true;
		  } 
		  function checkSubmitPay(){ 
			  if($("#pay_card").val().length<=0){ 
				  alert("请输入您的收款银行");
				  $("#pay_card").focus();
				  return false;
			  } 
			  if($("#pay_name").val().length<=0){ 
				  alert("请输入您的银行账号持有人姓名");
				  $("#pay_name").focus();
				  return false;
			  } 
			  if($("#pay_address").val().length<=0){ 
				  alert("请输入您的开户行地址");
				  $("#pay_address").focus();
				  return false;
			  } 
			  if($("#rmNum").val().length<=0){ 
				  alert("请输入验证码");
				  $("#rmNum").focus();
				  return false;
			  } 

			  return true;
		  } 
	  </script> 
  </body> 
  <div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
  </html>