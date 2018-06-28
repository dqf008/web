<?php 
session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/logintu.php';
include_once '../common/function.php';
include_once '../class/user.php';
$randStr = md5(uniqid(rand(), true));
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
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="shortcut icon" href="images/favicon.ico"> 
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all"> 
	<link rel="stylesheet" href="css/style_index.css" type="text/css" media="all"> 
	<!--js判断横屏竖屏自动刷新--> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script>$(document).bind("mobileinit", function() {$.mobile.ajaxEnabled=false;});</script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<script type="text/javascript" src="js/top.js"></script> 
	<style>
	.register li {
		/*border-bottom: 1px solid #CCC;*/
	}
	.register li label{
		border: none;
		
		}
	.register {
		background-color: #FFF;   
		 border: 1px solid #f3f3f3;
    border-radius: 5px;
    padding:0 20px;
	}
	.register label {
		color: #90581b;
	}
	.zcyzm div.ui-input-text{
		display: inline-block;
		width: 180px;
	}
	.register .ts{
		color:red;
		text-align: center;
		margin-top: 1px;
	}
	.ui-page-theme-a{
		background-color:transparent
	}
	</style>
</head> 
<body> 
  <div id="wrap"> 
	  <!--头部开始--> 
	  <header id="header"> 
		  <a href="/m/index.php" data-ajax="false" class="ico ico_home"></a> 
		  <span>注册</span> 
	  </header> 
	  <div class="mrg_header"></div> 
	  <div class="login_ico"> 
			  <img src="../static/images/mobile_logo.png" style="margin:30px auto 20px auto"> 
	  </div> 
	  <!--头部结束--> 
	  <!--内容开始--> 
	  <div id="main" class="cl"> 
		  <div class="register w"> 
			  <form id="registerForm" style="" name="registerForm" method="post" action="/reg.php" data-ajax="false"> 
			  <input name="key" value="add" type="hidden"> 
			       <input name="jsr" value="<?=$_COOKIE['tum']?>" type="hidden">
			  	  <div class="ui-field-contain zcname">
				    <label for="zcname">会员账号：</label>
				    <input type="text" name="zcname" id="zcname" placeholder="5-15位英文或数字" maxlength="15">
				    <div class="ts" v='zcname'></div>
				  </div>

				  <div class="ui-field-contain zcpwd1">
				    <label for="zcpwd1">账号密码：</label>
				    <input type="password" name="zcpwd1" id="zcpwd1" placeholder="6-20位英文或数字" maxlength="20">
				    <div class="ts" v='zcpwd1'></div>
				  </div>

				  <div class="ui-field-contain zcpwd2">
				    <label for="zcpwd2">确认密码：</label>
				    <input type="password" name="zcpwd2" id="zcpwd2" placeholder="请再次输入密码" maxlength="20">
				    <div class="ts" v='zcpwd2'></div>
				  </div>

				  <div class="ui-field-contain zcturename">
				    <label for="zcturename">真实姓名：</label>
				    <input type="text" name="zcturename" id="zcturename" placeholder="请填写您的真实姓名" maxlength="10">
				    <div class="ts" v='zcturename'></div>
				    <div style="color:red;text-align:center;">真实姓名必须与您的银行账户姓名相同，否则不能出款</div>
				  </div>

				  <?php if ($web_site['show_tel'] == "1"):?>
				  	<div class="ui-field-contain zctel">
					    <label for="zctel">手机号码：</label>
					    <input type="text" name="zctel" id="zctel" placeholder="请填写您的手机" maxlength="11">
					    <div class="ts" v='zctel'></div>
					  </div>
				  <?php else:?>
				  	<input type="hidden" name="zctel" value="保密">
				  <?php endif;?>

				  <?php if ($web_site['show_qq'] == "1"):?>
				  	<div class="ui-field-contain zcemail">
					    <label for="zcemail">QQ/email：</label>
					    <input type="text" name="zcemail" id="zcemail" placeholder="请填写QQ或email">
					    <div class="ts" v='zcemail'></div>
					  </div>
				  <?php else:?>
					  	<input type="hidden" name="zcemail" value="<?=$randStr?>">
				  <?php endif;?>

				  <?php if ($web_site['show_weixin'] == "1"):?>
				  	<div class="ui-field-contain zcweixin">
					    <label for="zcweixin">微信号：</label>
					    <input type="text" name="zcweixin" id="zcweixin" placeholder="请填写微信号" >
					    <div class="ts" v='zcweixin'></div>
					  </div>
				  <?php else:?>
					  	<input type="hidden" name="zcweixin" value="<?=$randStr?>">
				  <?php endif;?>

				  <?php if ($web_site['show_question'] == "1"):?>
					 <div class="ui-field-contain answer">
					  	<label for="ask">密码问题：</label>
					  	<select name="ask" id="ask"> 
						  <option value="您的车牌号码是多少？" selected="selected">您的车牌号码是多少？</option> 
						  <option value="您初中同桌的名字？">您初中同桌的名字？</option> 
						  <option value="您就读的第一所学校的名称？">您就读的第一所学校的名称？</option> 
						  <option value="您第一次亲吻的对象是谁？">您第一次亲吻的对象是谁？</option> 
						  <option value="少年时代心目中的英雄是谁？">少年时代心目中的英雄是谁？</option> 
						  <option value="您最喜欢的休闲运动是什么？">您最喜欢的休闲运动是什么？</option> 
						  <option value="您最喜欢哪支运动队？">您最喜欢哪支运动队？</option> 
						  <option value="您最喜欢的运动员是谁？">您最喜欢的运动员是谁？</option> 
						  <option value="您的第一辆车是什么牌子？">您的第一辆车是什么牌子？</option> 
					    </select>
						 <label for="answer">密码答案：</label>
						 <input type="text" id="answer" name="answer" placeholder="用于找回密码">
						 <div class="ts" v='answer'></div>
					  </div>
					  <?php else:?>
					  	<input type="hidden" name="ask" value="您的车牌号码是多少？">
              			<input type="hidden" name="answer" value="<?=$randStr?>">
					  <?php endif;?>

					  <div class="ui-field-contain qk_pwd">
					  	<label for="qk_pwd">取款密码：</label>
					  	<input type="password" id="qk_pwd" name="qk_pwd" placeholder="只能为6位数字,提款需用,务必记住" maxlength="6">
					  	<div class="ts" v='qk_pwd'></div>
					  </div>

					<div class="ui-field-contain zcyzm">
					  	<label for="zcyzm">验证码：</label>
					  	<input type="text" id="zcyzm" name="zcyzm" placeholder="请输入验证码" maxlength="4">
							<img id="vPic" style="height:33px;margin:2px 5px;width:60px;" onclick="javascript:getKey();"/> 
							<div class="ts" v='zcyzm'></div>
					  </div>
				  <div class="submit"> 
					<input type="button" onclick="sbu_check();" value="立即注册"> 
				  </div> 
			  </form> 
		  </div> 
	  </div> 
	  <!--内容结束--> 
	  <!--底部开始--><?php include_once 'bottom.php';?>        <!--底部结束--> 
  </div> 
  <script type="text/javascript"> 
  		$(function(){
  			getKey();
  			$("input").blur(function(){
  				var name = $(this).attr('name');
  				var val = trimStr($(this).val());
  				var ts = $('.'+name+' .ts');
  				$(this).val(val);
  				switch(name){
  					case 'zcname':
  						checkzcname();
  						break;
  					case 'zcpwd1':
  						if(val.length<6 || val.length>20)
					  		ts.html('密码必须在6-20位之间，且不能含有空格');
					  	else
					  		ts.html('');
		  				break;
		  			case 'zcpwd2':
		  				if(val != $('#zcpwd1').val())
		  					ts.html('两次输入的密码不一样，请重新输入');
		  				else
		  					ts.html('');
		  				break;
		  			case 'zcturename':
		  				if(!isChinese(val))
		  					ts.html('真实姓名只能中文')
		  				else 
		  					ts.html('');
		  				break;
		  			case 'zctel':
		  				if(! /^\d{6,13}$/.test(val))
		  					ts.html('请输入纯数字正确的电话号码');
		  				else
		  					ts.html('');
		  				break;
		  			case 'zcemail':
		  				if(! /^[1-9][0-9]{4,}$|[\w!#$%&'*+/=?^_`{|}~-]+(?:\.[\w!#$%&'*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?/.test(val))
		  					ts.html('请输入正确的邮箱或QQ号码');
		  				else
		  					ts.html('');
		  				break;
		  			case 'zcweixin':
		  				break;
		  			case 'answer':
		  				break;
		  			case 'qk_pwd':
		  				if(! /^\d{6}$/.test(val))
		  					ts.html('请输入6位数字取款密码！');
		  				else
		  					ts.html('');
		  				break;
		  			case 'zcyzm':
		  				if(val.length !== 4)
		  					ts.html('验证码格式错误');
		  				else
		  					ts.html('');
		  				break;
		  		}
  			});
  		});

	  function sbu_check(){
	  		var inputList = $('.ui-field-contain input');
	  		for(i=0;i<inputList.length;i++){
	  			var input = inputList[i];
	  			if($(input).val() == ''){
	  				$(input).focus();
	  				return;
	  			}
	  		}
	  		var tsList = $('.ui-field-contain .ts');
	  		for(i=0;i<tsList.length;i++){
	  			var ts = tsList[i];
	  			if($(ts).text() != ''){
	  				var id = $(ts).attr('v');
	  				$('#'+id).focus();
	  				return;
	  			}
	  		}
	  		$("#registerForm").submit();
	  } 
	  function trimStr(str){ 
		  return str.replace(/\s|\u00a0/g, '');
	  } 
	  function checkzcname() { 
	  	var val = $.trim($('#zcname').val());
		  if(val.length<5 || val.length>15){ 
		  		$('.zcname .ts').html('用户名必须在5-15位之间，且不能含有空格');
		  		return false;
		  } 
		  if(!/[a-zA-Z0-9]{5,15}/.test(val)){ 
			 $('.zcname .ts').html('用户名必须英文和数字组成。');
			 return false;
		  } 

		  $.get("/check_username.php", {username:val}, function(data){ 
			  if($.trim(data)=="n"){ 
				$('.zcname .ts').html('抱歉，用户已经被占用！');
				return false;
			  } else{
			  	$('.zcname .ts').html('');
		  		return true;
			  }
		  });
	  } 


	  function isChinese(val){ 
		  var reg=/^([\u4E00-\u9FA5]|[\uFE30-\uFFA0])+$/gi;
		  if(reg.test(val)){ 
			  return true;
		  }else{ 
			  return false;
		  } 
	  } 
	  function isMobile(val){ 
		  if(/^\d{6,13}$/.test(val)){ 
			  return true;
		  }else{ 
			  return false;
		  } 
	  } 
	  function isEmail(val){ 
		  var search_str = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
		  if(!search_str.test(val)){ 
			  return false;
		  }else{ 
			  return true;
		  } 
	  } 
	  function isNum(N){ 
		  var Ns=/^[0-9]{6}$/;
		  if(!Ns.test(N)){ 
			  return false;
		  }else{ 
			  return true;
		  } 
	  } 
	
	  $("#password").change(function(){ 
		  $("#hid_password").val($("#password").val());
	  });
	  $("#passwd").change(function(){ 
		  $("#hid_passwd").val($("#passwd").val());
	  });
	  (function(){ 
		  $("#password").val($("#hid_password").val());
		  $("#passwd").val($("#hid_passwd").val());
	  })();
  </script> 
</body> 
</html>