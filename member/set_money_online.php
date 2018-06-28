<?php session_start();
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
$userinfo = user::getinfo($_SESSION['uid']);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <title>会员中心</title> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
	  <script type="text/javascript" src="images/member.js"></script> 
	  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
	  <style> 
	     .content-div{ 
	         margin-left: 10px;
	         margin-top: 10px;
	         border-bottom: 1px #CCC dashed;
	         padding: 5px;
	     } 
	  </style> 
  </head> 
  <body> 
  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;"><?php include_once 'mainmenu.php';?>	  <tr> 
		  <td colspan="2" align="center" valign="middle"><?php include_once 'moneymenu.php';?>			  <div class="content" style="height: 340px;text-align: left;" > 
				  <div class="content-div"> 
					  <span class="hong">在线支付</span> <span class="lan">=&gt;网上银行在线支付，立即到账；推荐您在入款时使用</span> 
				  </div> 
				  <div class="content-div"> 
					  <span class="hong">提示：</span> <span class="lan">为了款项能够及时添加成功，请您务必在付款成功页面，点击“返回到商户页面”等待30秒在关闭网页，否则将无法完成额度自动加入动作。</span> 
				  </div><?php $ggid = $userinfo['gid'];
foreach ($arr_online_config as $k => $v)
{
	if (!$pay_online_type[$ggid])
	{
		continue;
	}
	if (!in_array($k, $pay_online_type[$ggid]))
	{
		continue;
	}?>       					  <div class="content-div" style="float: left;"  > 
            					  <form action="<?=$v['input_url'];?>" method="post" name="form1" id="form1"> 
        							  <input name="uid" type="hidden" value="<?=$_SESSION['uid'];?>" /> 
        							  <input name="username" type="hidden" value="<?=$_SESSION['username'];?>" /> 
        							  <input name="pay_online" type="hidden" value="<?=$k;?>" /> 
        							  <input name="hosturl" type="hidden" value="http://<?=$_SERVER['HTTP_HOST'];?>/" /> 
        							  <input name="Submit" type="submit" class="submit_108" value="<?=$v['online_name'];?>" /> 
        						  </form> 
						  </div><?php }?> 			  </div> 
		  </td> 
	  </tr> 
  </table> 
  </body> 
  </html>