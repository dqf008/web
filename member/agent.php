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
if (!user::is_daili($uid))
{
	message('你还不是代理，请先申请', 'agent_reg.php');
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
  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;"><?php include_once 'mainmenu.php';?>	  <tr> 
		  <td colspan="2" align="center" valign="middle"><?php include_once 'agentmenu.php';?>			  <div class="content"> 
				  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
					  <tr> 
						  <td height="30" align="center" bgcolor="#FAFAFA" class="hong"><strong>请使用以下推广网址进行推广</strong></td> 
                      </tr> 
					  <tr> 
						  <td height="30" align="left" class="lan"><strong>代理推广网址：http://<?=$conf_www;?>/?f=<?=$_SESSION['username'];?></strong></td> 
					  </tr> 
					  <tr> 
						  <td align="left">备注说明：</td> 
					  </tr> 
					  <tr> 
						  <td align="left">1、代理申请成功后，请使用以上推广网址进行推广；</td> 
					  </tr> 
					  <tr> 
						  <td align="left">2、通过推广网址注册来的会员将会成为您的下线会员。</td> 
					  </tr> 
				  </table> 
			  </div> 
		  </td> 
	  </tr> 
  </table> 
  </body> 
  </html>