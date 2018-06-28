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
include_once '../../member/function.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
if ($_POST['action'] == 'pass'){
	$oldpass = trim($_POST['oldpass']);
	$newpass = trim($_POST['newpass']);
	if ($oldpass == ''){
		message('请输入您的原登录密码');
	}
	
	if ((strlen($newpass) < 6) || (20 < strlen($newpass))){
		message('新登录密码只能是6-20位');
	}
	
	if (user::update_pwd($_SESSION['uid'], $oldpass, $newpass, 'password')){
		$_SESSION['password'] = $newpass;
		message('登陆密码修改成功', 'userinfo.php');
	}else{
		message('登陆密码修改失败，请检查您的输入', 'userinfo.php');
	}
}

if ($_POST['action'] == 'moneypass'){
	$oldmoneypass = trim($_POST['oldmoneypass']);
	$newmoneypass = trim($_POST['newmoneypass']);
	if ($oldmoneypass == ''){
		message('请输入您的原取款密码');
	}
	
	if (strlen($newmoneypass) != 6){
		message('请选择6位新取款密码');
	}
	
	if (user::update_pwd($_SESSION['uid'], $oldmoneypass, $newmoneypass, 'qk_pwd')){
		message('取款密码修改成功', 'userinfo.php');
	}else{
		message('取款密码修改失败，请检查您的输入', 'userinfo.php');
	}
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
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
  <style type="text/css"> 
  #collapsibles div{ 
	  padding: 0 0 5px 0;
  } 
  </style> 
  <script language="javascript"> 
  	 $(function(){
  	  	reflivemoney_one();
  	  });

  	  function reflivemoney_one(){
  	  	  $("span[id^=live_money_span_]").html('<img src="../../Box/skins/icons/loading.gif" />');
		  $.getJSON("../../cj/live/live_money_db.php?callback=?",function (data) { 
		  	if(data.info=='ok'){
		  		$("#agin_money").html(data.AGIN);
		  		$("#ag_money").html(data.AG);
		  		$("#bb_money").html(data.BBIN);
		  		$("#og_money").html(data.OG);
		  		$("#mg_money").html(data.MG);
		  		$("#maya_money").html(data.MAYA);
		  		$("#shaba_money").html(data.SHABA);
		  		$("#pt_money").html(data.PT);
		  		$("#kg_money").html(data.KG);
		  		$("#mw_money").html(data.MW);
		  		$("#cq9_money").html(data.CQ9);
		  		$("#mg2_money").html(data.MG2);

		  	}else{
		  		$("span[id$=_money]").html(data.msg);
		  	}
		  	
		  });
  	  }
	  function reflivemoney(zztype) {
		  $("#"+zztype.toLowerCase()+"_money").html('<img src="../../Box/skins/icons/loading.gif" />');
		  $.getJSON("../../cj/live/live_money.php?callback=?&type="+zztype,function (data) { 
			  $("#"+zztype.toLowerCase()+"_money").html(data.msg);
		  });
	  } 

	 
 	  function reflivemoney_MAYA() {
		  $("#maya_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_MAYA.php?callback=?",function (data) { 
			  $("#maya_money").html(data.msg);
		  });
	  } 

	  function reflivemoney_MW() {
		  $("#mw_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_MW.php?callback=?",function (data) { 
			  $("#mw_money").html(data.msg);
		  });
	  }
	  function reflivemoney_KG() {
		  $("#kg_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("../../cj/live/live_money_KG.php?callback=?",function (data) { 
			  $("#kg_money").html(data.msg);
		  });
	  }
	  function reflivemoney_CQ9() {
		  $("#cq9_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_CQ9.php?callback=?",function (data) { 
			  $("#cq9_money").html(data.msg);
		  });
	  }
	  function reflivemoney_MG2() {
		  $("#mg2_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_MG2.php?callback=?",function (data) { 
			  $("#mg2_money").html(data.msg);
		  });
	  }
 
  </script>
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 645px;"> 
  <!--头部开始--> 
  <header id="header"> 
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
	  <span>我的账户</span> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 

  <!--功能列表--> 
  <div data-role="content" style="padding:0px;margin-top:-8px" class="ui-content" role="main"> 
	  <div id="collapsibles" data-role="collapsible-set" data-theme="a" data-content-theme="a" class="ui-collapsible-set ui-group-theme-a ui-corner-all"> 
		  <div data-role="collapsible" data-collapsed-icon="arrow-d" data-expanded-icon="arrow-u" class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">基本资料</h4> 
			  <ul data-role="listview" style="margin-top:0.5px;" class="ui-listview"> 
				  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
					  <label>账户信息</label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>会员账户：<?=$userinfo['username'];?> <span class="blue">(<?=$userinfo['is_daili']==1 ? '代理' : '会员';?>)</span></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>注册时间：<?=$userinfo['reg_date'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>上次登录时间：<?=$userinfo['login_time'];?></label> 
				  </li> 
				  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit"> 
					  <label>账户额度</label> 
				  </li> 

				  <li class="ui-li-static ui-body-inherit"> 
					  <label>体育/彩票余额：<?=$userinfo['money'];?></label> 
				  </li>
				  <li class="ui-li-static ui-body-inherit ui-first-child"> 
			  <label>AG国际厅余额： 
				  <span id="agin_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney('AGIN')">刷新</a> 
			  </label> 
		  </li> 
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>AG极速厅余额： 
				  <span id="ag_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney('AG')">刷新</a> 
			  </label> 
		  </li> 
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>BB波音厅余额： 
				  <span id="bb_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney('BBIN')">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>OG东方厅余额： 
				  <span id="og_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney('OG')">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>玛雅娱乐厅余额： 
				  <span id="maya_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_MAYA()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>PT电子游戏余额： 
				  <span id="pt_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney('PT')">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>MW电子游戏余额： 
				  <span id="mw_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_MW()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>AV女优余额： 
				  <span id="kg_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_KG()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>CQ9电子余额： 
				  <span id="cq9_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_CQ9()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>新MG电子余额： 
				  <span id="mg2_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_MG2()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>沙巴体育余额： 
				  <span id="shaba_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney('SHABA')">刷新</a> 
			  </label> 
		  </li>
				  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit"> 
					  <label>财务信息</label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>收款人姓名：<?=$userinfo['pay_name'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>收款银行：
						  <?php if ($userinfo['pay_num'] == ''){?> 							  
						  <span onclick="window.location.href='./setcard.php'" style="color:blue">点击设置您的银行资料</span>
						  <?php }else{?> 							  
						  <span><?=$userinfo['pay_card'];?></span>
						  <?php }?> 						  
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>银行账号：
					  <?php if ($userinfo['pay_num'] == ''){?> 							  
					  <span onclick="window.location.href='./setcard.php'" style="color:blue">点击设置您的银行资料</span>
					  <?php }else{?> 							  
					  <span><?=cutNum($userinfo['pay_num']);?></span>
					  <?php }?> 						  
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>开户行地址：
					  <?php if ($userinfo['pay_num'] == ''){?> 							  
					  <span onclick="window.location.href='./setcard.php'" style="color:blue">点击设置您的银行资料</span>
					  <?php }else{?> 							  
					  <span><?=$userinfo['pay_address'];?></span>
					  <?php }?> 						  
					  </label> 
				  </li> 
				  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit"> 
					  <label>联系方式</label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>联系电话：<?=cutTitle($userinfo['mobile']);?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit ui-last-child"> 
					  <label>邮箱地址：<?=cutTitle($userinfo['email']);?></label> 
				  </li> 
			  </ul> 
		  </div> 
		  <div data-role="collapsible" data-collapsed-icon="arrow-d" data-expanded-icon="arrow-u" class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content ui-collapsible-collapsed ui-last-child"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">更改密码</h4> 
			  <form action="userinfo.php" onsubmit="return submitForm(1);" method="post" name="lt_form1" data-role="none" data-ajax="false"> 
				  <input type="hidden" name="action" value="pass"> 
				  <ul data-role="listview" style="margin-top:0.5px;" class="ui-listview"> 
					  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
						  <label>登录密码</label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>原登录密码：<input name="oldpass" type="password" id="oldpass" maxlength="20" data-role="none" /></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>新登录密码：<input name="newpass" type="password" id="newpass" maxlength="20" data-role="none" placeholder="请输入6-20位新密码"/></label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit ui-last-child"> 
						  <label>确认新密码：<input name="newpass2" type="password" id="newpass2" maxlength="20" data-role="none" placeholder="重复输入一次新密码"></label> 
					  </li> 
				  </ul> 
				  <div style="clear:both;text-align:center;"> 
					  <button name="btnSubmit" class="ui-btn ui-btn-inline">提交</button> 
				  </div> 
			  </form> 
			  <form action="userinfo.php" onsubmit="return submitForm(2);" method="post" name="lt_form2" data-role="none" data-ajax="false"> 
				  <input type="hidden" name="action" value="moneypass"> 
				  <ul data-role="listview" style="margin-top:0.5px;" class="ui-listview"> 
					  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
						  <label>取款密码</label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit"> 
						  <label>原取款密码： 
						  <input name="oldmoneypass" type="password" id="oldmoneypass" maxlength="6" data-role="none"> 
						  </label> 
					  </li> 
					  <li class="ui-li-static ui-body-inherit ui-last-child"> 
						  <label>新取款密码： 
						  <input name="newmoneypass" type="password" id="newmoneypass" maxlength="6" data-role="none" placeholder="请输入6位新密码" /> 
						  </label> 
					  </li> 
				  </ul> 
				  <div style="clear:both;text-align:center;"> 
					  <button name="btnSubmit" class="ui-btn ui-btn-inline">提交</button> 
				  </div> 
			  </form> 
		  </div> 
	  </div> 
  </div> 
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once 'myinfo.php';?>	  
  <script type="text/javascript"> 
	  function submitForm(i){ 
		  if(i==1){ 
		  if(!checkSubmitLogin()){ 
		  return false;
		  } 
		  } else { 
		  if(!checkSubmitMoney()){ 
		  return false;
		  } 
		  } 

		  return true;
	  } 
	  //修改登录密码 
	  function checkSubmitLogin(){ 
		  if($("#oldpass").val().length<=0){ 
			  alert('请输入您的原登录密码');
			  $("#oldpass").focus();
			  return false;
		  } 
		  if($("#newpass").val().length<6 || $("#newpass").val().length>20){ 
			  alert("新登录密码只能是6-20位");
			  $("#newpass").focus();
			  return false;
		  } 
		  if($("#newpass").val()!=$("#newpass2").val()){ 
			  alert("两次密码输入不一致");
			  $("#newpass2").focus();
			  return false;
		  } 

		  return true;
	  } 
	  //修改取款密码 
	  function checkSubmitMoney(){ 
		  if($("#oldmoneypass").val().length<=0){ 
			  alert("请输入您的原取款密码");
			  $("#oldmoneypass").focus();
			  return false;
		  } 
		  if(!isNum($('#newmoneypass').val())){ 
			  alert('请输入6位数字取款密码！');
			  $("#newmoneypass").focus();
			  return false;
		  } 

		  return true;
	  } 
	  function isNum(N){ 
		  var Ns=/^[0-9]{6}$/;
		  if(!Ns.test(N)){ 
		  return false;
		  }else{ 
		  return true;
		  } 
	  } 
  </script> 
</body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"> 
<span class="ui-icon-loading"></span><h1>loading</h1> 
</div> 
</html>