<?php session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../common/function.php';
include_once '../class/user.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($_SESSION['uid']);
if (user::is_daili($uid))
{
	message('你已经是代理，不需要重复代理，请退出后重新登陆');
}
if ($_GET['action'] == 'save')
{
	$bdate = date('Y-m-d') . ' 00:00:00';
	$edate = date('Y-m-d') . ' 23:59:59';
	$params = array(':uid' => $uid, ':bdate' => $bdate, ':edate' => $edate);
	$sql = 'select d_id from k_user_daili where uid=:uid and add_time>=:bdate and add_time<=:edate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	if ($stmt->fetch())
	{
		message('代理每天只能申请一次，您今天已经提交申请了，请等待客服人员联系和确认');
	}
	$r_name = $userinfo['pay_name'];
	$mobile = htmlEncode($_POST['mobile']);
	$email = htmlEncode($_POST['email']);
	$about = htmlEncode($_POST['about']);
	$params = array(':uid' => $uid, ':r_name' => $r_name, ':about' => $about);
	$sqlset = '';
	if ($mobile)
	{
		$params[':mobile'] = $mobile;
		$sqlset .= ',mobile=:mobile';
	}
	if ($email)
	{
		$params[':email'] = $email;
		$sqlset .= ',email=:email';
	}
	$sql = 'insert into k_user_daili set uid=:uid,r_name=:r_name,about=:about ' . $sqlset;
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1 == 1)
	{
		message('你的申请已经提交，请等待客服人员联系和确认');
	}
	else
	{
		message('代理申请提交失败，请稍后重试');
	}
}
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
      <script type="text/javascript" src="../skin/js/jquery-1.7.2.min.js"></script> 
	  <script type="text/javascript" src="images/member.js"></script> 
	  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
	  <script language="javascript"> 
		  function check_form(){ 
			  if($("#about").val().length<=20){ 
				  alert("请填写合适的申请理由，至少要输入20个字！");
				  $("#about").select();
				  return false;
			  } 

			  if(!$("#fuhe").is(':checked')){ 
				  alert("请确认您已年满18岁！");
				  $("#fuhe").select();
				  return false;
			  } 
		  } 
	  </script> 
  </head> 
  <body> 
  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;"><?php include_once 'mainmenu.php';?>	  <tr> 
		  <td colspan="2" align="center" valign="middle"> 
			  <div class="nav"> 
				  <ul> 
					  <li class="current"><a href="javascript:void(0);" onclick="Go('agent_reg.php');return false">申请代理</a></li> 
					  <!--li><a href="javascript:void(0);" onclick="parent.window.location.href='../myabout.php?i=partner'">代理介绍</a></li--> 
				  </ul> 
			  </div> 
			  <div class="content"> 
				  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
					  <form action="?action=save" method="post" name="form1" onsubmit="return check_form();"> 
					  <tr> 
						  <td width="150" align="right">会员账号：</td> 
						  <td align="left" class="hong"><?=$userinfo['username'];?></td> 
					  </tr> 
					  <tr> 
						  <td align="right">真实姓名：</td> 
						  <td align="left" class="hong"><?=$userinfo['pay_name'];?></td> 
					  </tr> 
					  <tr> 
						  <td align="right">联系电话：</td> 
						  <td align="left" class="hong"><input name="mobile" type="text" class="input_250" id="mobile" maxlength="20"/> 
							  &nbsp;&nbsp;<span class="lan">请填写联系电话，方便代理客服人员与您详谈代理方式</span></td> 
					  </tr> 
					  <tr> 
						  <td align="right">电子邮箱：</td> 
						  <td align="left" class="hong"><input name="email" type="text" class="input_250" id="email" maxlength="40"/> 
							  &nbsp;&nbsp;<span class="lan">请填写您常用的电子邮箱</span></td> 
					  </tr> 
					  <tr> 
						  <td align="right">申请理由：</td> 
						  <td align="left" class="hong"><textarea style="width:500px;height:100px;" name="about" type="text" id="about"></textarea> 
							  &nbsp;&nbsp;* <span class="lan">请尽量说明您的优势</span></td> 
					  </tr> 
					  <tr> 
						  <td align="right">&nbsp;</td> 
						  <td align="left"><input value="1" type="checkbox" name="fuhe" id="fuhe" checked="checked" />我已经年满18岁，且在此网站所有活动并没有抵触本人所在国家所管辖的法律</td> 
					  </tr> 
					  <tr> 
						  <td align="right">&nbsp;</td> 
						  <td align="left"><input name="submit" type="submit" id="submit" class="submit_108" value="提交申请"/></td> 
					  </tr> 
					  </form> 
				  </table> 
			  </div> 
		  </td> 
	  </tr> 
  </table> 
  </body> 
  </html>