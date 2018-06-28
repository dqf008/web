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
include_once '_pankouinfo.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
$class1 = $_POST['class1'];
$class2 = $_POST['class2'];
$money = $_POST['money'];
$params = array(':class1' => $class1, ':class2' => $class2);
$stmt = $mydata1_db->prepare('select class3,rate from mydata2_db.ka_bl where  class1=:class1 and class2=:class2 order by id');
$stmt->execute($params);
$plArray = array();
$betnumber = 0;
while ($row = $stmt->fetch()){
	$betnumber++;
	$plArray[$betnumber]['rate'] = $row['rate'];
	$plArray[$betnumber]['class3'] = $row['class3'];
}
if ($betnumber == 0){
	echo '<script type="text/javascript">alert("该页面禁止刷新！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}
$betlist = $_POST['betlist'];
$newbetlist = substr($betlist, 0, strlen($betlist) - 1);
$words = explode(',', $newbetlist);
$arr_getrank = array();
getRank($words, getM($class2));
$betResults = array();
$allMoney = 0;

for ($i = 0;$i < count($arr_getrank);$i++){
	global $allMoney;
	$res = $arr_getrank[$i];
	$rs = explode(',', $res);
	$allMoney += $money;
	$lowRate = getLowRate($rs);
	$betResult = new BetResult();
	$betResult->class3 = $res;
	$betResult->money = $money;
	$betResult->rate = $lowRate;
	$betResults[] = $betResult;
}
?> 
<!DOCTYPE html> 
  <html class="ui-mobile ui-mobile-viewport ui-overlay-a"> 
  <head> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
	  <title><?=$web_site['web_title'];?></title> 
	  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> 
	  <meta content="yes" name="apple-mobile-web-app-capable"> 
	  <meta content="black" name="apple-mobile-web-app-status-bar-style"> 
	  <meta content="telephone=no" name="format-detection"> 
	  <meta name="viewport" content="width=device-width"> 
	  <link rel="shortcut icon" href="../images/favicon.ico"> 
	  <link rel="stylesheet" href="../css/style.css"> 
	  <link rel="stylesheet" href="../js/jquery.mobile-1.4.5.min.css"> 
	  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script> 
	  <script type="text/javascript" src="../js/jquery.mobile-1.4.5.min.js"></script> 
	  <!--js判断横屏竖屏自动刷新--> 
	  <script type="text/javascript" src="../js/top.js"></script> 
	  <style type="text/css"> 
		  ul, ol, li{  
			  list-style-type:none;
		  }  
		  .xiazhu ul {  
			  padding-top: 5px;
		  }  
		  .xiazhu .biaodan li{  
			  width: 20%;
			  height: 28px;
			  border-bottom:1px solid #DDD;
			  text-align:center;
			  float:left;
		  }  
		  .xiazhu .biaodan1 li{  
			  width: 25%;
			  height: 45px;
			  border-bottom:1px solid #DDD;
			  text-align: center;
			  float:left;
		  } 
	  </style> 
  </head> 
	  <body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 659px;"> 
		  <!--头部开始--> 
		  <header id="header">
			  <?php if ($uid != 0){?> 			  
				<a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a>
			  <?php }?> 			  
			  <span>彩票游戏</span> 
			  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"> 
			  </a> 
		  </header> 
		  <div class="mrg_header"> 
		  </div> 
		  <!--头部结束--> 
		  <div style="display: none;" id="popupPanel-placeholder"> 
			  <!-- placeholder for popupPanel --> 
		  </div> 
		  <section class="sliderWrap clearfix" style="margin-top:1px;"> 
			  <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit"> 
				  <h1 class="ui-title" role="heading" aria-level="1"> 
					  六合彩 
				  </h1> 
			  </div> 
		  </section> 
		  <form name="form" id="form" action="quanbuzhong_katan.php" method="POST"> 
		  <section class="mContent" style="padding-left:0px;padding-right:0px;padding-top:5px;"> 
			  <div data-role="tabs" id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all"> 
				  <input type="hidden" name="class1" value="<?=$class1;?>"> 
				  <input type="hidden" name="class2" value="<?=$class2;?>"> 
				  <div id="three" class="ui-body-d ui-content" style="padding:0px;"> 
					  <div style="clear:both;padding-bottom:5px;border-bottom-width:1px;border-color:#DDD;border-style:solid;text-align:center;"> 
						  <b> 
							  <p> 
								  <font color="#990000"><?=$class1;?> - <?=$class2;?></font> 
								  注单内容 
							  </p> 
						  </b> 
					  </div> 
					  <div style="clear:both;padding-bottom:5px;border-bottom-width:1px;border-color:#DDD;border-style:solid;text-align:center;"> 
						  <p> 
							  ☆最小金额: 
							  <font color="#FF0000"><?=$cp_zd;?></font> 
							  &nbsp;&nbsp;☆单注限额: 
							  <font color="#FF0000"><?=$cp_zg;?></font> 
						  </p> 
					  </div> 
					  <div class="xiazhu" style="clear:both;" data-role="none"> 
						  <ul class="biaodan1 ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" 
						  data-role="none" role="tablist"> 
							  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:55%;" 
							  data-role="none"> 
								  选号 
							  </li> 
							  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:20%;" 
							  data-role="none"> 
								  赔率 
							  </li> 
							  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:25%;" 
							  data-role="none"> 
								  下注金额 
							  </li> 
						  </ul> 
						  <ul class="biaodan1" data-role="none">
						  <?php 
							for ($i = 0;$i < count($betResults);$i++){
								$obj = $betResults[$i];
								$obj = (array)$obj;
						  ?>							  
						      <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:55%;"  data-role="none"> 
								  <p><?=$obj['class3'];?><input type="hidden" name="class3_<?=$i;?>" value="<?=$obj['class3'];?>" /> </p> 
							  </li> 
							  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:20%;" data-role="none"> 
								  <p id="odd_<?=$i?>" style="color:#FF0000;"><?=$obj['rate'];?></p> 
							  </li> 
							  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:25%;text-align:center;" data-role="none">
							  <?=$obj['money'];?><input type="hidden" name="money_<?=$i;?>" value="<?=$obj['money'];?>" /> 
							  </li>
							  
						  <?php }?> 						  
						  </ul> 
					  </div> 
					  <div style="text-align: center;font-weight: bold;"> 
						  <p> 共<?=count($betResults);?>组选号，总金额：<?=$allMoney;?></p> 
					  </div> 
				  </div> 
				
				  <input type="hidden" name="count" id="count" value="<?=count($betResults);?>"> 
				  <input type="hidden" name="money" id="money" value="<?=$money;?>"> 
				  <input type="hidden" name="betlist" id="betlist" value="<?=$newbetlist;?>"> 
				  <div style="clear:both;padding-top:10px;padding-left:10px;"> 
					  <div style="clear:both;text-align:center;"> 
						  <a href="javascript:goBack();" class="ui-btn ui-btn-inline"> 
							  取消下注 
						  </a> 
						  <a href="javascript:formSubmit();" class="ui-btn ui-btn-inline"> 
							  确认下注 
						  </a> 
					  </div> 
				  </div> 
			  </div> 
		  </section> 
		  </form> 
		  <!--底部开始--><?php include_once '../bottom.php';?>		  <!--底部结束--> 
		  <!--我的资料--><?php include_once '../member/myinfo.php';?>		
		  <script type="text/javascript" src="../js/script.js"></script> 
		  <script type="text/javascript"> 
			
			  function goBack() { //取消下注 
				  window.history.back();
			  } 
			  function formSubmit() { //提交表单 
				   document.form.submit();
			  } 
		  </script> 
	  </body> 
	  <div class="ui-loader ui-corner-all ui-body-a ui-loader-default"> 
		  <span class="ui-icon-loading"> 
		  </span> 
		  <h1> 
			  loading 
		  </h1> 
	  </div> 
  </html><?php class BetResult
{
	public $money;
	public $class3;
	public $rate;
}
function getM($class2)
{
	$m = 0;
	if ('五不中' == $class2)
	{
		$m = 5;
	}
	else if ('六不中' == $class2)
	{
		$m = 6;
	}
	else if ('七不中' == $class2)
	{
		$m = 7;
	}
	else if ('八不中' == $class2)
	{
		$m = 8;
	}
	else if ('九不中' == $class2)
	{
		$m = 9;
	}
	else if ('十不中' == $class2)
	{
		$m = 10;
	}
	else if ('十一不中' == $class2)
	{
		$m = 11;
	}
	else if ('十二不中' == $class2)
	{
		$m = 12;
	}
	else
	{?> 参数错误<?php exit();
	}
	return $m;
}
function getRank($arr, $len = 0, $str = '')
{
	global $arr_getrank;
	$arr_len = count($arr);
	if ($len == 0)
	{
		$arr_getrank[] = $str;
	}
	else
	{
		$i = 0;
		for (;$i < $arr_len;$i++)
		{
			$tmp = array_shift($arr);
			if (($str != '0') && empty($str))
			{
				getRank($arr, $len - 1, $tmp);
			}
			else
			{
				getRank($arr, $len - 1, $str . ',' . $tmp);
			}
		}
	}
}
function getLowRate($rs)
{
	global $plArray;
	$lowRate = 100000;
	$i = 0;
	for (;$i < count($rs);
	$i++)
	{
		$crate = 0;
		$j = 1;
		for (;$j <= count($plArray);
		$j++)
		{
			if ($plArray[$j]['class3'] == $rs[$i])
			{
				$crate = $plArray[$j]['rate'];
			}
		}
		if ($crate < $lowRate)
		{
			$lowRate = $crate;
		}
	}
	return $lowRate;
}?>