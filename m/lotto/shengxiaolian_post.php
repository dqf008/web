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
$class1 = '生肖连';
$money = 0;
$rightRate = 0;
$class2 = $_GET['class2'];
$result = $_POST['betValue'];
$money = $_POST['num_1'];
if (!preg_match('/^[1-9]\\d*$/', $money)){
	echo '<script type="text/javascript">alert("请输入合法的金额！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}
$number2 = substr($result, 1);
$n = 0;
$bet_arry = explode(',', $number2);
$n = count($bet_arry);
$number1 = $number2;
switch ($_GET['class2']){
	case '二肖连中': $bmmm = 0;
	$cmmm = 0;
	$dmmm = 0;
	$R = 48;
	$XF = 23;
	$rate_id = 1401;
	if (($n < 2) || (8 < $n)){
		echo "<script>alert('对不起，请选择二-八个生肖!');window.location.href='index.php?action=left';</script>";
		exit();
	}
	$zs = ($n * ($n - 1)) / 2;
	$mu = explode(',', $number1);
	$mama = $mu[0] . ',' . $mu[1];
	for ($f = 0;$f <= count($mu) - 2;$f = $f + 1){
		
		for ($t = 2;$t <= count($mu) - 1;$t = $t + 1){
			if (($f != $t) && ($f < $t)){
				$mama = $mama . '/' . $mu[$f] . ',' . $mu[$t];
			}
		}
	}
	break;
	case '三肖连中': $bmmm = 0;
	$cmmm = 0;
	$dmmm = 0;
	$R = 49;
	$XF = 23;
	$rate_id = 1413;
	if (($n < 3) || (8 < $n)){
		echo "<script>alert('对不起，请选择三-八个生肖!');window.location.href='index.php?action=left';</script>";
		exit();
	}
	$zs = ($n * ($n - 1) * ($n - 2)) / 6;
	$mu = explode(',', $number1);
	$mama = $mu[0] . ',' . $mu[1] . ',' . $mu[2];
	
	for ($h = 0;$h <= count($mu) - 3;$h = $h + 1){
		for ($f = 1;$f <= count($mu) - 2;$f = $f + 1){
			for ($t = 3;$t <= count($mu) - 1;$t = $t + 1){
				if (($h != $f) && ($h < $f) && ($f != $t) && ($f < $t)){
					$mama = $mama . '/' . $mu[$h] . ',' . $mu[$f] . ',' . $mu[$t];
				}
			}
		}
	}
	break;
	case '四肖连中': $bmmm = 0;
	$cmmm = 0;
	$dmmm = 0;
	$R = 50;
	$XF = 23;
	$rate_id = 1425;
	if (($n < 4) || (8 < $n)){
		echo "<script>alert('对不起，请选择四-八个生肖!');window.location.href='index.php?action=left';</script>";
		exit();
	}
	$zs = ($n * ($n - 1) * ($n - 2) * ($n - 3)) / 24;
	$mu = explode(',', $number1);
	$mama = $mu[0] . ',' . $mu[1] . ',' . $mu[2] . ',' . $mu[3];
	
	for ($h = 0;$h <= count($mu) - 4;$h = $h + 1){
		for ($f = 1;$f <= count($mu) - 3;$f = $f + 1){
			for ($t = 2;$t <= count($mu) - 2;$t = $t + 1){
				for ($s = 4;$s <= count($mu) - 1;$s = $s + 1){
					if (($h != $f) && ($h < $f) && ($f != $t) && ($f < $t) && ($t != $s) && ($t < $s)){
						$mama = $mama . '/' . $mu[$h] . ',' . $mu[$f] . ',' . $mu[$t] . ',' . $mu[$s];
					}
				}
			}
		}
	}
	break;
	case '五肖连中': $bmmm = 0;
	$cmmm = 0;
	$dmmm = 0;
	$R = 51;
	$XF = 23;
	$rate_id = 1473;
	if (($n < 5) || (8 < $n)){
		echo "<script>alert('对不起，请选择五-八个生肖!');window.location.href='index.php?action=left';</script>";
		exit();
	}
	$zs = ($n * ($n - 1) * ($n - 2) * ($n - 3) * ($n - 4)) / 120;
	$mu = explode(',', $number1);
	$mama = $mu[0] . ',' . $mu[1] . ',' . $mu[2] . ',' . $mu[3] . ',' . $mu[4];
	
	for ($h = 0;$h <= count($mu) - 5;$h = $h + 1){
		for ($f = 1;$f <= count($mu) - 4;$f = $f + 1){
			for ($t = 2;$t <= count($mu) - 3;$t = $t + 1){
				for ($s = 3;$s <= count($mu) - 2;$s = $s + 1){
					for ($u = 5;$u <= count($mu) - 1;$u = $u + 1){
						if (($h != $f) && ($h < $f) && ($f != $t) && ($f < $t) && ($t != $s) && ($t < $s) && ($s != $u) && ($s < $u)){
							$mama = $mama . '/' . $mu[$h] . ',' . $mu[$f] . ',' . $mu[$t] . ',' . $mu[$s] . ',' . $mu[$u];
						}
					}
				}
			}
		}
	}
	break;
	case '二肖连不中': $bmmm = 0;
	$cmmm = 0;
	$dmmm = 0;
	$R = 52;
	$XF = 23;
	$rate_id = 1437;
	if (($n < 2) || (8 < $n)){
		echo "<script>alert('对不起，请选择二-八个生肖!');window.location.href='index.php?action=left';</script>";
		exit();
	}
	$zs = ($n * ($n - 1)) / 2;
	$mu = explode(',', $number1);
	$mama = $mu[0] . ',' . $mu[1];
	
	for ($f = 0;$f <= count($mu) - 2;$f = $f + 1){
		
		for ($t = 2;$t <= count($mu) - 1;$t = $t + 1){
			if (($f != $t) && ($f < $t)){
				$mama = $mama . '/' . $mu[$f] . ',' . $mu[$t];
			}
		}
	}
	break;
	case '三肖连不中': $bmmm = 0;
	$cmmm = 0;
	$dmmm = 0;
	$R = 53;
	$XF = 23;
	$rate_id = 1449;
	if (($n < 3) || (8 < $n)){
		echo "<script>alert('对不起，请选择三-八个生肖!');window.location.href='index.php?action=left';</script>";
		exit();
	}
	$zs = ($n * ($n - 1) * ($n - 2)) / 6;
	$mu = explode(',', $number1);
	$mama = $mu[0] . ',' . $mu[1] . ',' . $mu[2];
	for ($h = 0;$h <= count($mu) - 3;$h = $h + 1){
		for ($f = 1;$f <= count($mu) - 2;$f = $f + 1){
			for ($t = 3;$t <= count($mu) - 1;$t = $t + 1){
				if (($h != $f) && ($h < $f) && ($f != $t) && ($f < $t)){
					$mama = $mama . '/' . $mu[$h] . ',' . $mu[$f] . ',' . $mu[$t];
				}
			}
		}
	}
	break;
	case '四肖连不中': $bmmm = 0;
	$cmmm = 0;
	$dmmm = 0;
	$R = 50;
	$XF = 23;
	$rate_id = 1461;
	if (($n < 4) || (8 < $n)){
		echo "<script>alert('对不起，请选择四-八个生肖!');window.location.href='index.php?action=left';</script>";
		exit();
	}
	$zs = ($n * ($n - 1) * ($n - 2) * ($n - 3)) / 24;
	$mu = explode(',', $number1);
	$mama = $mu[0] . ',' . $mu[1] . ',' . $mu[2] . ',' . $mu[3];
	
	for ($h = 0;$h <= count($mu) - 4;$h = $h + 1){
		for ($f = 1;$f <= count($mu) - 3;$f = $f + 1){
			for ($t = 2;$t <= count($mu) - 2;$t = $t + 1){
				for ($s = 4;$s <= count($mu) - 1;$s = $s + 1){
					if (($h != $f) && ($h < $f) && ($f != $t) && ($f < $t) && ($t != $s) && ($t < $s)){
						$mama = $mama . '/' . $mu[$h] . ',' . $mu[$f] . ',' . $mu[$t] . ',' . $mu[$s];
					}
				}
			}
		}
	}
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
		  height: 28px;
		  border-bottom:1px solid #DDD;
		  text-align: center;
		  line-height: 28px;
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
			  <h1 class="ui-title" role="heading" aria-level="1">六合彩</h1> 
		  </div> 
	  </section> 
	  <form name="form" id="form" action="./shengxiaolian_kantan.php" method="POST"> 
	  <section class="mContent" style="padding-left:0px;padding-right:0px;padding-top:5px;"> 
		  <div data-role="tabs" id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all"> 
			  <input type="hidden" name="class1" value="<?=$class1;?>"> 
			  <input type="hidden" name="class2" value="<?=$class2;?>"> 
			  <div id="three" class="ui-body-d ui-content" style="padding:0px;"> 
				  <div style="clear:both;padding-bottom:5px;border-bottom-width:1px;border-color:#DDD;border-style:solid;text-align:center;"> 
					  <b> 
						  <p> 
							  <font color="#990000"><?=$class1;?> - <?=$class2;?></font>注单内容 
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
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:50%;" 
						  data-role="none"> 
							  选号 
						  </li> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:20%;" 
						  data-role="none"> 
							  赔率 
						  </li> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:30%;" 
						  data-role="none"> 
							  下注金额 
						  </li> 
					  </ul> 
					  <ul class="biaodan1" data-role="none">
					  <?php 
					  	$betlistArray = explode('/', $mama);
						for ($i = 0;$i < count($betlistArray);$i++){
							$rightRate = getrightrate($betlistArray[$i]);
						?>							  
						<li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:50%;" 
						  data-role="none"> 
							  <p><?=$betlistArray[$i];?></p> 
						  </li> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:20%;" 
						  data-role="none"> 
							  <p style="color:#FF0000;"><?=$rightRate;?></p> 
						  </li> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:30%;text-align:center;" data-role="none">
						  <?=$money;?>							  
						  </li>
						  <?php }?> 						  
					</ul> 
				  </div> 
			  </div> 
			 <input type="hidden" name="gold" value="<?=$money;?>"> 
			 <input type="hidden" name="zushu" value="<?=$zs;?>"> 
			 <input type="hidden" name="number1" value="<?=$mama;?>"> 
			 <input type="hidden" name="number2" value="<?=$number2;?>"> 
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
			
			  <div style="clear:both;padding-top:10px;padding-left:10px;"> 
				  <span> 
					  <font style="color:red;font-size:10pt;">注：该页面禁止刷新</font> 
				  <span> 
				  </span></span> 
			  </div> 
		  </div> 
	  </section> 
	  </form> 
	  <!--底部开始--><?php include_once '../bottom.php';?>		  <!--底部结束--> 
	  <!--我的资料--><?php include_once '../member/myinfo.php';?>		
	  <script type="text/javascript" src="../js/script.js"></script> 
	  <script type="text/javascript"> 
		  function goBack() { //取消下注 
			  window.history.back(-1);
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
</html>
<?php 
function queryPeilv($class1, $class2, $class3){
	global $mydata1_db;
	$params = array(':class1' => $class1, ':class2' => $class2, ':class3' => $class3);
	$stmt = $mydata1_db->prepare('select rate from mydata2_db.ka_bl where  class1=:class1 and class2=:class2 and class3=:class3 order by id limit 1');
	$stmt->execute($params);
	$row = $stmt->fetch();
	return $row;
}

function getRightRate($result){
	global $class1;
	global $class2;
	$bet_palv = array();
	if (isset($result)){
		$bet_array = explode(',', $result);
		for ($i = 0;$i < count($bet_array);$i++){
			$row = querypeilv($class1, $class2, $bet_array[$i]);
			if (!isset($row)){
				echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
				exit();
			}
			array_push($bet_palv, $row['rate']);
		}
		sort($bet_palv);
		return $bet_palv[0];
	}
	return '';
}
?>