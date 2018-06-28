<?php 
session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../class/user.php';
include_once '../common/function.php';
include_once 'pay/moneyconfig.php';
include_once '../cache/website.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($_SESSION['uid']);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <title>会员中心</title> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
	  <script type="text/javascript" src="images/member.js"></script> 
	  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
  </head> 
  <body> 
  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;"><?php include_once 'mainmenu.php';?>	  <tr> 
		  <td colspan="2" align="center" valign="middle"><?php include_once 'moneymenu.php';?>			  <div class="content"> 
				  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
					  <tr> 
						  <td height="30" colspan="2" align="left" bgcolor="#FAFAFA"><span class="hong">在线扫码、网银在线充值</span> <span class="lan">=&gt;支持微信或支付宝直接扫码；网上银行在线支付，立即到账，推荐您优先使用</span></td> 
					  </tr> 
					  <tr> 
					  <td align="left">
					  	<!-- <input type="button" class="submit_108" value="在线充值" onclick="Go('set_money_online.php');return false" /> -->
					  	<?php $ggid = $userinfo['gid'];
foreach ($arr_online_config as $k => $v)
{
	if (!$pay_online_type[$ggid])
	{
		continue;
	}
	if (!in_array($k, $pay_online_type[$ggid]))
	{
		continue;
	}?><div class="content-div" style="float:left;padding-right:5px"><form action="<?=$v['input_url'];?>" method="post" name="form1" id="form1"><input name="uid" type="hidden" value="<?=$_SESSION['uid'];?>" /><input name="username" type="hidden" value="<?=$_SESSION['username'];?>" /><input name="pay_online" type="hidden" value="<?=$k;?>" /><input name="hosturl" type="hidden" value="http://<?=$_SERVER['HTTP_HOST'];?>/" /><input name="Submit" type="submit" class="submit_108" value="<?=$v['online_name'];?>" /></form></div><?php }?>
					  </td> 
					  </tr> 
					  <tr> 
						  <td height="30" colspan="2" align="left"><span class="hong">提示：</span><span class="lan">1.为了款项能够及时添加成功，请您务必在付款成功页面，点击“返回到商户页面”等待30秒在关闭网页，否则将无法完成额度自动加入动作。</span></td> 
					  </tr> 
					  <tr> 
						  <td height="30" colspan="2" align="left"><span class="hong" style="color:#fff">提示：</span><span class="lan">2.建议您在存款金额小数点后增加两位数字（例如：存款10000元，填入10000.15元），如遇到额度未自动加入，将提高您的处理速度。</span></td> 
					  </tr> 
					  <tr> 
						  <td height="30" align="left" bgcolor="#FAFAFA"><span class="hong">银行转账汇款（即公司入款）</span> <span class="lan">=&gt;支持网银转账、ATM转账、银行柜台汇款、支付宝或微信转入公司银行卡</span></td> 
					  </tr> 
					  <tr> 
						  <td align="left"><input name="Submit" type="button" class="submit_108" onclick="Go('hk_money.php');return false" value="汇款提交" /></td> 
					  </tr><?php if ($web_site['wxalipay'] == 1)
{?>                     <tr> 
						  <td height="30" align="left" bgcolor="#FAFAFA"><span class="hong">支付宝或微信转账</span> <span class="lan">=&gt;支持支付宝或微信直接转账到公司支付宝或微信账号</span></td> 
					  </tr> 
					  <tr> 
						  <td align="left"><input name="Submit" type="button" class="submit_108" onclick="Go('hk_money2.php');return false" value="转账提交" /></td> 
					  </tr><?php }?> 				  </table> 
			  </div> 
		  </td> 
	  </tr> 
  </table> 
  </body> 
  </html>