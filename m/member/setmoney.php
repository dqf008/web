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
include_once '../../member/pay/moneyconfig.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
include_once '../../cache/bank2.php';
?>
<!DOCTYPE html> 
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
  <script> 
  <!--选择菜单变换对应提交的值变换--> 
  function sel1_click() 
	  { 
	  var nodeSel1=document.getElementById("online_pay");//获取select元素 
	  var index = nodeSel1.selectedIndex;// 选中项的索引 
	  var text = nodeSel1.options[index].text;// 选中项的文本 
	  var value = nodeSel1.options[index].value;// 选中项的值 
	  var payWay=document.getElementById("pay_online");
	  payWay.value=value;
	  } 
	
  <!--禁止不选择第三方-->  	
  function SubInfo(){ 
	
	  if($('#online_pay').val()==''){ 
		  alert('请选择支付方式');
		  $('#online_pay').focus();
		  return false;
	  } 
	  $('#form1').submit();
	
	  } 
  </script> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-url="/m/member/setmoney.php" tabindex="0" style="min-height: 756px;"> 
  <!--头部开始--> 
  <header id="header"> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
	  <span>线上存款</span> 
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 


  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <div data-role="cotent"> 
		  <ul data-role="listview" class="ui-listview"> 
			  <li class="ui-li-static ui-body-inherit ui-first-child"> 
				  <label>一、在线支付</label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label> 
					  <form action="mobilePay.php" method="get" name="form1" id="form1" target="_self"> 
						  <select name="Submit" id="online_pay" data-role="none" style="margin-bottom:5px;" onChange="sel1_click()"> 
							  <option value="">==请选择方式==</option>
							  <?php 
							    $ggid = $userinfo['gid'];
								$ci = 0;
								foreach ($arr_online_config as $k => $v){
									if (!$pay_online_type[$ggid]){
										continue;
									}
									
									if (!in_array($k, $pay_online_type[$ggid])){
										continue;
									}				
									
									echo '<option value="'.$k.'">'.$v['online_name'].'</option>';
									$ci++;
								}
								
								if ($ci == 0){ 
									echo '&nbsp;';
								}
								?> 							  
						   </select> 
						  <input name="uid" type="hidden" value="<?=$_SESSION['uid'];?>"/> 
						  <input name="username" type="hidden" value="<?=$_SESSION['username'];?>"/> 
						  <input name="pay_online" id="pay_online" type="hidden" value="" /> 
						  <input name="hosturl" type="hidden" value="http://<?=$_SERVER['HTTP_HOST'];?>/" /> 
						  <br/> 
						  <button name="btnSubmit" class="ui-btn ui-btn-inline" data-role="none" data-ajax="false" value="马上充值" onClick="return SubInfo();">马上充值</button> 
					  </form> 
				  </label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>二、公司入款</label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit ui-last-child"> 
				  <button name="" class="ui-btn ui-btn-inline" data-role="none" data-ajax="false" onClick="self.location.href='hk_money.php'" value="汇款提交">汇款提交</button> 
			  </li>
			  <?php if (($bank[$_SESSION['gid']] != '') && ($bank[$_SESSION['gid']] != NULL) && ($web_site['wxalipay'] == 1)){?> 				  
			  <li class="ui-li-static ui-body-inherit"> 
				  <label>三、支付宝(微信)入款</label> 
			  </li> 
			  <li class="ui-li-static ui-body-inherit ui-last-child"> 
				  <button name="" class="ui-btn ui-btn-inline" data-role="none" data-ajax="false" onClick="self.location.href='hk_money_2.php'" value="汇款提交">汇款提交</button> 
			  </li>
			  <?php }?> 			  
			  </ul> 
	  </div> 
  </section> 
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once 'myinfo.php';?>
  </body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>