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
if (!empty($userinfo['pay_card'])&&!empty($userinfo['pay_num'])&&!empty($userinfo['pay_address'])){
	message('您已经设置过银行信息，如需帮助请联系在线客服。');
}
if ($_GET['action'] == 'save')
{
	$pay_card = htmlEncode($_POST['pay_card']);
	$pay_num = htmlEncode($_POST['pay_num']);
	$pay_address = htmlEncode($_POST['pay_address']);
	$vlcodes = $_POST['vlcodes'];
	if ($vlcodes != $_SESSION['randcode'])
	{
		message('验证码错误，请重新输入');
	}
	$_SESSION['randcode'] = rand(10000, 99999);
	if ($pay_card == '')
	{
		message('请输入您的收款银行');
	}
	if ($pay_num == '')
	{
		message('请输入您正确的银行账号');
	}
	if ($pay_address == '')
	{
		message('请输入您的开户行地址');
	}
	if (user::update_paycard($_SESSION['uid'], $pay_card, $pay_num, $pay_address, $userinfo['pay_name'], $_SESSION['username']))
	{
		message('恭喜你，银行绑定成功', 'get_money.php');
		exit();
	}
	else
	{
		message('设置出错，请重新设置你的银行卡信息', 'set_card.php');
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
  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;"><?php include_once 'mainmenu.php';?>	  <tr> 
		  <td colspan="2" align="center" valign="middle"> 
			  <div class="nav"> 
				  <ul> 
					  <li class="current"><a href="javascript:void(0);" onclick="Go('set_card.php');return false">绑定银行账号</a></li> 
				  </ul> 
			  </div> 
			  <div class="content"> 
				  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
					  <form action="?action=save" method="post" name="form1" onsubmit="return check_submit_pay();"> 
					  <tr> 
						  <td align="right">会员账号：</td> 
						  <td align="left" class="hong"><?=$_SESSION['username'];?></td> 
					  </tr> 
					  <tr> 
						  <td align="right">收款人姓名：</td> 
						  <td align="left" class="hong"><?=$userinfo['pay_name'];?></td> 
					  </tr> 
					  <tr> 
						  <td align="right">收款银行：</td> 
						  <td align="left" class="hong"><input name="pay_card" type="text" class="input_250" id="pay_card"/> 
							  &nbsp;&nbsp;* <span class="lan">例如：工商银行</span></td> 
					  </tr> 
					  <tr> 
						  <td align="right">银行账号：</td> 
						  <td align="left" class="hong"><input name="pay_num" type="text" class="input_250" id="pay_num"/> 
							  &nbsp;&nbsp;* <span class="lan">请输入您的银行账号</span></td> 
					  </tr> 
					  <tr> 
						  <td align="right">开户行地址：</td> 
						  <td align="left" class="hong"><input name="pay_address" type="text" class="input_250" id="pay_address"/> 
							  &nbsp;&nbsp;* <span class="lan">请输入省份及城市，如 "辽宁省沈阳市"</span></td> 
					  </tr> 
					  <tr> 
						  <td align="right">验证码：</td> 
						  <td align="left" class="hong"><input name="vlcodes" type="text" class="input_80" id="vlcodes"maxlength="4"/> 
							  <img src="../yzm.php" alt="点击更换" name="checkNum_img" id="checkNum_img" style="cursor:pointer;position:relative;top:1px;" onclick="next_checkNum_img()" /> 
							  &nbsp;&nbsp;* <span class="lan">请输入验证码</span></td> 
					  </tr> 
					  <tr> 
						  <td align="right">&nbsp;</td> 
						  <td align="left"><input name="submit" type="submit" id="submit" class="submit_108" value="确认修改"/> </td> 
					  </tr> 
					  </form> 
					  <tr> 
						  <td colspan="2" align="left" class="lan">注意事项：</td> 
					  </tr> 
					  <tr> 
						  <td colspan="2" align="left">1、银行账户持有人姓名必须与注册时输入的姓名一致，否则无法申请提款。</td> 
					  </tr> 
					  <tr> 
						  <td colspan="2" align="left">2、每位客户只可以使用一张银行卡进行提款，如需要更换银行卡请与客服人员联系；否则提款将被拒绝。</td> 
					  </tr> 
					  <tr> 
						  <td colspan="2" align="left">3、为保障客户资金安全，<?=$web_site['reg_msg_from'];?>有可能需要用户提供电话单，银行对账单或其它资料验证，以确保客户资金不会被冒领。</td> 
					  </tr> 
				  </table> 
			  </div> 
		  </td> 
	  </tr> 
  </table> 
  </body> 
  </html>