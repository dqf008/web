<?php session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/logintu.php';
include_once '../common/function.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <title>Lottery</title> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
	  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <style type="text/css"> 
		   
		   body{ 
			  margin:0px;
			  padding:0px;
			  font-family: "宋体", Arial;
			  color:#383838;
			  background:#fff;
			  position: relative;
			  font-size:12px;
			  overflow-x: hidden;
		  } 
		  html { 
			  overflow-x: hidden;
		  } 
		  h1,h2,h3,h4,h5{ 
			  padding:0;
			  margin:0;
			  font-size:25px;
			  color:#900;
		  } 
		   
		  div,form,ul,ol,li,dl,dt,dd,p,span,img 
		   { 
			  margin: 0;
			  padding: 0;
			  border:0;
		  } 
		   
		  li,dl{ 
			  list-style-type:none;
		  } 
		   
		  a{text-decoration:none;color:#174B73;} 
		  a:hover{ text-decoration:underline;color:#900;} 
		   
		  .clear {clear: both;} 
		  .line10{height:10px;} 
		  .line5{height:5px;overflow:hidden;} 
		  .main{margin:0 auto;padding:5px;width:200px;background-color:#FFF;} 
		  .menulink_1{height:30px;margin:5px auto 0 auto;line-height:30px;padding:0 10px;background-image:url(../skin/ssc/div_left_16.gif);color:#FFF;cursor: pointer;} 
		  .menulink_2{height:30px;margin:5px auto 0 auto;background-image:url(../skin/ssc/div_left_10.gif);line-height:30px;padding:0 10px;cursor: pointer;color:#FFF;} 
		  .betlink_1{height:25px;margin:0 auto;background-color:#E5E5E5;line-height:25px;padding:0 10px;border-bottom:1px #000000 solid;cursor: pointer;} 
		  .betlink_2{height:25px;margin:0 auto;background-color:#FFFFFF;line-height:25px;padding:0 10px;border-bottom:1px #000000 solid;cursor: pointer;} 
	  </style> 
	  <script language="JavaScript"> 
		  window.onerror=function(){return true;} 
		  if(self==top){ 
			  top.location='/';
		  } 

		  function urlOnclick(url){ 
			  parent.open(url,"index");
		  } 
		
		  function urlblank(url){ 
			  window.open(url,"_blank");
		  } 
	  </script> 
	  <script type="text/javascript" src="../skin/js2/jquery.js"></script> 
	  <script type="text/javascript" src="../skin/js2/global.js"></script> 
	  <script type="text/javascript" src="../skin/js2/DD_belatedPNG.js"></script>  
	  <script type="text/javascript">if(isLessIE6)DD_belatedPNG.fix('*');</script> 
	  <script> 
		  function changeMove(obj,type,k) 
		  { 
			  if(type) 
			  { 
				  $(obj).addClass(k+"_1");
			  } 
			  else 
			  { 
				  if ($("#"+k+"_01_bet").css("display")=="none") 
					  $(obj).removeClass(k+"_1");
			  } 
		  } 
	  </script> 
	  <script type="text/javascript" language="javascript" src="../js/left.js"></script> 
	  <script type="text/javascript" language="javascript" src="../js/left_mouse.js"></script> 
	  <script language="javascript"> 
		  function ResumeError() { 
			  return true;
		  } 
		  window.onerror = ResumeError;
	  </script> 
  </head> 
  <body><?php if ($uid)
{?> <div id="userinfo" style="display:none;"></div><?php }?> <div class="main"> 
	  <div id="ds_01_bet"> 
		  <div class="menulink_2" id="en0" onclick="ShowHidden(0);">重庆时时彩</div> 
		  <div id="Label0" style="display:none"> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlOnclick('../ssc.php')">开始投注</div> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlblank('ssc_list.php')">开奖结果</div> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlblank('../sm/ssc.php')">游戏规则</div> 
		  </div> 
		  <div class="menulink_1" id="en1" onclick="ShowHidden(1)">广东快乐十分</div> 
		  <div id="Label1" style="display:none"> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlOnclick('../ssc.php?t=2')">开始投注</div> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlblank('klsf_list.php')">开奖结果</div> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlblank('../sm/klsf.php')">游戏规则</div> 
		  </div> 
		  <div class="menulink_1" id="en2" onclick="ShowHidden(2)">北京赛车PK拾</div> 
		  <div id="Label2" style="display:none"> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlOnclick('../ssc.php?t=3')">开始投注</div> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlblank('bjsc_list.php')">开奖结果</div> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlblank('../sm/bjsc.php')">游戏规则</div> 
		  </div> 
		  <div class="menulink_1" id="en3" onclick="ShowHidden(3)">北京快乐8</div> 
		  <div id="Label3" style="display:none"> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlOnclick('../ssc.php?t=4')">开始投注</div> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlblank('../kl8_list.php')">开奖结果</div> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlblank('../sm/kl8.php')">游戏规则</div> 
		  </div> 
		  <div class="menulink_1" id="en4" onclick="ShowHidden(4)">上海时时乐</div> 
		  <div id="Label4" style="display:none"> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlOnclick('../ssc.php?t=5')">开始投注</div> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlblank('../sm/ssl.php')">游戏规则</div> 
		  </div> 
		  <div class="menulink_1" id="en5" onclick="ShowHidden(5)">福彩3D</div> 
		  <div id="Label5" style="display:none"> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlOnclick('../ssc.php?t=6')">开始投注</div> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlblank('../sm/3d.php')">游戏规则</div> 
		  </div> 
		  <div class="menulink_1" id="en6" onclick="ShowHidden(6)">排列三</div> 
		  <div id="Label6" style="display:none"> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlOnclick('../ssc.php?t=7')">开始投注</div> 
			  <div class="betlink_1" onmouseover="this.className='betlink_2'" onmouseout="this.className='betlink_1'" onclick="urlblank('../sm/pl3.php')">游戏规则</div> 
		  </div> 
	  </div> 
  </div><?php $type = intval($_GET['t']);
if ($type < 1)
{
	$type = 1;
}
$type = $type - 1;?><script> 
	  ShowHidden(<?=$type;?>);
  </script> 
  </body> 
  </html>