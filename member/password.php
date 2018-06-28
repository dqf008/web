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
unset($_SESSION['modifyPwdTip']);
if ($_GET['action'] == 'pass')
{
	$oldpass = trim($_POST['oldpass']);
	$newpass = trim($_POST['newpass']);
	if ($oldpass == '')
	{
		message('请输入您的原登录密码');
	}
	if ((strlen($newpass) < 6) || (20 < strlen($newpass)))
	{
		message('新登录密码只能是6-20位');
	}
	if (user::update_pwd($_SESSION['uid'], $oldpass, $newpass, 'password'))
	{
		message('登陆密码修改成功', 'password.php');
	}
	else
	{
		message('登陆密码修改失败，请检查您的输入', 'password.php');
	}
}
if ($_GET['action'] == 'moneypass')
{
	$oldmoneypass = trim($_POST['oldmoneypass']);
	$newmoneypass1 = trim($_POST['newmoneypass1']);
	$newmoneypass2 = trim($_POST['newmoneypass2']);
	$newmoneypass3 = trim($_POST['newmoneypass3']);
	$newmoneypass4 = trim($_POST['newmoneypass4']);
	$newmoneypass5 = trim($_POST['newmoneypass5']);
	$newmoneypass6 = trim($_POST['newmoneypass6']);
	$newmoneypass = $newmoneypass1 . $newmoneypass2 . $newmoneypass3 . $newmoneypass4 . $newmoneypass5 . $newmoneypass6;
	if ($oldmoneypass == '')
	{
		message('请输入您的原取款密码');
	}
	if (strlen($newmoneypass) != 6)
	{
		message('请选择6位新取款密码');
	}
	if (user::update_pwd($_SESSION['uid'], $oldmoneypass, $newmoneypass, 'qk_pwd'))
	{
		message('取款密码修改成功', 'password.php');
	}
	else
	{
		message('取款密码修改失败，请检查您的输入', 'password.php');
	}
}?> <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
      <script type="text/javascript" src="../skin/js/jquery-1.7.2.min.js"></script> 
	  <script type="text/javascript" src="images/member.js"></script> 
	  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
  </head> 
  <body> 
  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;">
	  <?php include_once 'mainmenu.php';?>	  
	  <tr> 
		  <td colspan="2" align="center" valign="middle"><?php include_once 'usermenu.php';?>			  <div class="content"> 
				  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
					  <form action="?action=pass" method="post" name="form1" onsubmit="return check_submit_login();"  > 
					  <tr> 
						  <th colspan="3" align="left">修改登录密码</th> 
					  </tr> 
					  <tr> 
						  <td width="150" align="right">原登录密码：</td> 
						  <td width="280" align="left" class="hong"><input name="oldpass" type="password" class="input_150" id="oldpass" maxlength="20"/></td> 
						  <td align="left" class="hong" id="oldpass_txt">&nbsp;</td> 
					  </tr> 
					  <tr> 
						  <td align="right">新登录密码：</td> 
						  <td align="left" class="hong"><input name="newpass" type="password" class="input_150" id="newpass" maxlength="20"/></td> 
						  <td align="left" class="hong" id="newpass_txt">* <span class="lan">请输入6-20位新密码</span></td> 
					  </tr> 
					  <tr> 
						  <td align="right">确认新登录密码：</td> 
						  <td align="left" class="hong"><input name="newpass2" type="password" class="input_150" id="newpass2" maxlength="20"/></td> 
						  <td align="left" class="hong" id="newpass2_txt">* <span class="lan">重复输入一次新密码</span></td> 
					  </tr> 
					  <tr> 
						  <td align="left">&nbsp;</td> 
						  <td align="left"><input name="submit" type="submit" id="submit" class="submit_108" value="确认修改"/> </td> 
						  <td align="left">&nbsp;</td> 
					  </tr> 
					  </form> 
					  <tr> 
						  <th colspan="3" align="left">修改取款密码</th> 
					  </tr> 
					  <form action="?action=moneypass" method="post" name="form1" onsubmit="return check_submit_money();"  > 
					  <tr> 
						  <td align="right">原取款密码：</td> 
						  <td align="left" class="hong"><input name="oldmoneypass" type="password" class="input_150" id="oldmoneypass" maxlength="6"/></td> 
						  <td align="left" class="hong" id="oldmoneypass_txt">&nbsp;</td> 
					  </tr> 
					  <tr> 
						  <td align="right">新取款密码：</td> 
						  <td align="left" class="hong"> 
							  <select name="newmoneypass1" id="newmoneypass1"> 
								  <option value="">--</option> 
								  <option value="0">0</option> 
								  <option value="1">1</option> 
								  <option value="2">2</option> 
								  <option value="3">3</option> 
								  <option value="4">4</option> 
								  <option value="5">5</option> 
								  <option value="6">6</option> 
								  <option value="7">7</option> 
								  <option value="8">8</option> 
								  <option value="9">9</option> 
							  </select> 
							  <select name="newmoneypass2" id="newmoneypass2"> 
								  <option value="">--</option> 
								  <option value="0">0</option> 
								  <option value="1">1</option> 
								  <option value="2">2</option> 
								  <option value="3">3</option> 
								  <option value="4">4</option> 
								  <option value="5">5</option> 
								  <option value="6">6</option> 
								  <option value="7">7</option> 
								  <option value="8">8</option> 
								  <option value="9">9</option> 
							  </select> 
							  <select name="newmoneypass3" id="newmoneypass3"> 
								  <option value="">--</option> 
								  <option value="0">0</option> 
								  <option value="1">1</option> 
								  <option value="2">2</option> 
								  <option value="3">3</option> 
								  <option value="4">4</option> 
								  <option value="5">5</option> 
								  <option value="6">6</option> 
								  <option value="7">7</option> 
								  <option value="8">8</option> 
								  <option value="9">9</option> 
							  </select> 
							  <select name="newmoneypass4" id="newmoneypass4"> 
								  <option value="">--</option> 
								  <option value="0">0</option> 
								  <option value="1">1</option> 
								  <option value="2">2</option> 
								  <option value="3">3</option> 
								  <option value="4">4</option> 
								  <option value="5">5</option> 
								  <option value="6">6</option> 
								  <option value="7">7</option> 
								  <option value="8">8</option> 
								  <option value="9">9</option> 
							  </select> 
							  <select name="newmoneypass5" id="newmoneypass5"> 
								  <option value="">--</option> 
								  <option value="0">0</option> 
								  <option value="1">1</option> 
								  <option value="2">2</option> 
								  <option value="3">3</option> 
								  <option value="4">4</option> 
								  <option value="5">5</option> 
								  <option value="6">6</option> 
								  <option value="7">7</option> 
								  <option value="8">8</option> 
								  <option value="9">9</option> 
							  </select> 
							  <select name="newmoneypass6" id="newmoneypass6"> 
								  <option value="">--</option> 
								  <option value="0">0</option> 
								  <option value="1">1</option> 
								  <option value="2">2</option> 
								  <option value="3">3</option> 
								  <option value="4">4</option> 
								  <option value="5">5</option> 
								  <option value="6">6</option> 
								  <option value="7">7</option> 
								  <option value="8">8</option> 
								  <option value="9">9</option> 
							  </select></td> 
						  <td align="left" class="hong" id="newmoneypass_txt">* <span class="lan">请输入6位新密码</span></td> 
					  </tr> 
					  <tr> 
						  <td align="right">&nbsp;</td> 
						  <td align="left"><input name="submit" type="submit" id="submit" class="submit_108" value="确认修改"/></td> 
						  <td align="left" class="hong">&nbsp;</td> 
					  </tr> 
					  </form> 
				  </table> 
			  </div> 
		  </td> 
	  </tr> 
  </table> 
  </body> 
  </html>