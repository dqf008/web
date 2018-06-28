<?php 
session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../class/user.php';
include_once 'function.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($_SESSION['uid']);
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
  <title>会员中心</title> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
  <script type="text/javascript" src="images/member.js"></script> 
  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
  <script type="text/javascript" src="../skin/js/jquery-1.7.2.min.js"></script> 
  
</head> 
<body> 
  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;">
	<?php 
	include_once("mainmenu.php");
	?>
	<tr>
		<td colspan="2" align="center" valign="middle">
			<?php 
			include_once("usermenu.php");
			?>
			<div class="content">
				<table width="98%" border="0" cellspacing="0" cellpadding="5">
					<tr>
						<th colspan="2" align="left">账户基本资料</th>
					</tr>
					<tr>
						<td width="180" align="right">会员账户：</td>
						<td align="left" class="hong"><?=$userinfo["username"]?> <span class="lan">(<?=$userinfo["is_daili"]==1?"代理":"会员"?>)</span></td>
					</tr>
					<tr>
						<td align="right">注册时间：</td>
						<td align="left" class="hong"><?=$userinfo["reg_date"]?></td>
					</tr>
					<tr>
						<td align="right">上次登录时间：</td>
						<td align="left" class="hong"><?=$userinfo["login_time"]?></td>
					</tr>
					<tr>
						<td align="right">体育/彩票额度：</td>
						<td align="left" class="hong"><?=sprintf("%.2f",$userinfo["money"])?> RMB</td>
					</tr> 	
					 <tr>
						<td align="right">真人/电子额度：</td>
						<td align="left" class="hong"><a href="javascript:void(0);" onclick="Go('zr_money.php');return false" style="color:#00F">点击查看</a></td>
					</tr> 
					  <tr> 
						  <th colspan="2" align="left">财务信息</th> 
					  </tr> 
					  <tr>
						<td align="right">收款人姓名：</td>
						<td align="left" class="hong"><?=$userinfo["pay_name"]?></td>
					</tr>
					<tr>
						<td align="right">收款银行：</td>
						<td align="left" class="hong">
							<?php
							if($userinfo["pay_card"]=="")
							{
							?>
							<a href="javascript:void(0);" onclick="Go('set_card.php');return false" style="color:#00F">点击设置您的银行资料</a>
							<?php
							}
							else
							{
								echo $userinfo["pay_card"];
							}
							?>
						</td>
					</tr>
					<tr>
						<td align="right">银行账号：</td>
						<td align="left" class="hong">
							<?php
							if($userinfo["pay_card"]=="")
							{
							?>
							<a href="javascript:void(0);" onclick="Go('set_card.php');return false" style="color:#00F">点击设置您的银行资料</a>
							<?php
							}
							else
							{
								echo cutNum($userinfo["pay_num"]);
							}
							?>
						</td>
					</tr>
					<tr>
						<td align="right">开户行地址：</td>
						<td align="left" class="hong">
							<?php
							if($userinfo["pay_card"]=="")
							{
							?>
							<a href="javascript:void(0);" onclick="Go('set_card.php');return false" style="color:#00F">点击设置您的银行资料</a>
							<?php
							}
							else
							{
								echo $userinfo["pay_address"];
							}
							?>
						</td>
					</tr>
					<tr>
						<th colspan="2" align="left">联系方式</th>
					</tr>
					<tr>
						<td align="right">联系电话：</td>
						<td align="left" class="hong"><?=cutTitle($userinfo["mobile"],8)?></td>
					</tr>
					<tr>
						<td align="right">邮箱地址：</td>
						<td align="left" class="hong"><?=cutTitle($userinfo["email"])?></td>
					</tr>
				  </table> 
			  </div> 
		  </td> 
	  </tr> 
  </table> 
</body> 
</html>