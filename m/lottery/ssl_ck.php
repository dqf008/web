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
include_once '../../include/lottery.inc.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
if (intval($web_site['ssl']) == 1){
	message('上海时时乐系统维护，暂停下注！');
	exit();
}
$params = array(':kaipan' => '2010-06-01 ' . $ssc_time, ':fengpan' => '2010-06-01 ' . $ssc_time);
$stmt = $mydata1_db->prepare('select * from lottery_t_ssl where kaipan<:kaipan and fengpan>:fengpan');
$stmt->execute($params);
$trow = $stmt->fetch();
$tcou = $stmt->rowCount();
if ($tcou <= 0){
	echo '<script type="text/javascript">alert("已经封盘，禁止下注！");window.location.href="/m/lottery/ssl.php";</script>';
	exit();
}
$stype = $_GET['stype'];
$class3 = $_GET['class3'];
$content = $_GET['content'];
$bw = trim($_GET['bw']);
$sw = trim($_GET['sw']);
$gw = trim($_GET['gw']);
$btype = '';
$ctype = '';
$dtype = '';
$odds = 0;
if ($stype == 1){
	$btype = '单选';
	if (($bw != '') && ($sw != '') && ($gw != '')){
		$wtypename = '3D';
		$ctype = '三位';
		$dtype = '百十个';
	}else if (($bw != '') && ($sw == '') && ($gw == '')){
		$wtypename = '1D 百位';
		$ctype = '一位';
		$dtype = '百';
	}else if (($bw == '') && ($sw != '') && ($gw == '')){
		$wtypename = '1D 十位';
		$ctype = '一位';
		$dtype = '十';
	}else if (($bw == '') && ($sw == '') && ($gw != '')){
		$wtypename = '1D 个位';
		$ctype = '一位';
		$dtype = '个';
	}else if (($bw != '') && ($sw != '') && ($gw == '')){
		$wtypename = '2D 百位 十位';
		$ctype = '二位';
		$dtype = '百十';
	}else if (($bw != '') && ($sw == '') && ($gw != '')){
		$wtypename = '2D 百位 个位';
		$ctype = '二位';
		$dtype = '百个';
	}else if (($bw == '') && ($sw != '') && ($gw != '')){
		$wtypename = '2D 十位 个位';
		$ctype = '二位';
		$dtype = '十个';
	}
}else if ($stype == 2){
	$btype = '组一';
	$ctype = '号码';
	$dtype = '单选';
	$wtypename = '组一';
}else if ($stype == 3){
	$btype = '组二';
	$ctype = '号码';
	$dtype = '单选';
	$wtypename = '组二';
}else if ($stype == 4){
	$btype = '组三';
	$ctype = '号码';
	$dtype = '单选';
	$wtypename = '组三';
}else if ($stype == 5){
	$btype = '组六';
	$ctype = '号码';
	$dtype = '单选';
	$wtypename = '组六';
}else if ($stype == 6){
	$btype = '跨度';
	$dtype = '单选';
	if (($content < 0) && (9 < $content)){
		echo '<script type="text/javascript">alert("非法投注！");window.location.href="/m/lottery/ssl.php";</script>';
		exit();
	}
	$ctype = $content;
}else if ($stype == 7){
	$btype = '和值';
	switch ($content){
		case 'DA': $content = '大';
		break;
		case 'XIAO': $content = '小';
		break;
		case 'DAN': $content = '单';
		break;
		case 'SHUANG': $content = '双';
		break;
		default: $content = $content;
	}
	if (($content == '0,1,2,3') || ($content == '4,5,6,7') || ($content == '8,9,10,11') || ($content == '12,13,14,15') || ($content == '16,17,18,19') || ($content == '20,21,22,23') || ($content == '24,25,26,27')){
		$ctype = $content;
		$dtype = '区域';
	}else if ((0 <= $content) && ($content <= 27)){
		$ctype = $content;
		$dtype = '单选';
	}else{
		echo '<script type="text/javascript">alert("非法投注！");window.location.href="/m/lottery/ssl.php";</script>';
		exit();
	}
}else if ($stype == 8){
	$btype = '单双大小';
	$ctype = '一位';
	$dtype = $class3;
	if (($dtype == '百位') || (($dtype == '十位') | ($dtype == '个位'))){
		switch ($content){
			case 'DA': $content = '大';
			break;
			case 'XIAO': $content = '小';
			break;
			case 'DAN': $content = '单';
			break;
			case 'SHUANG': $content = '双';
			break;
			default:
			echo '<script type="text/javascript">alert("非法投注！");window.location.href="/m/lottery/ssl.php";</script>';
			exit();
		}
	}else{
		echo '<script type="text/javascript">alert("非法投注！");window.location.href="/m/lottery/ssl.php";</script>';
		exit();
	}
}
$oddsshow = array();
if ($stype == 3){
	$params = array(':class2' => $btype);
	$psql = 'select id,class1,class2,class3,odds,modds,locked from lottery_odds where class1=\'ssl\' and class2=:class2 order by ID asc';
	$stmt = $mydata1_db->prepare($psql);
	$stmt->execute($params);
	$prow = $stmt->fetch();
	$oddsshow[0] = $prow['odds'];
	$prow = $stmt->fetch();
	$oddsshow[1] = $prow['odds'];
}else{
	$params = array(':class2' => $btype, ':class3' => $ctype);
	$psql = 'select * from lottery_odds where class1=\'ssl\' and class2=:class2 and class3=:class3';
	$stmt = $mydata1_db->prepare($psql);
	$stmt->execute($params);
	$prow = $stmt->fetch();
	$oddsshow[0] = $prow['odds'];
}

if ($wtypename == '3D'){
	$brr = explode(',', $bw);
	$srr = explode(',', $sw);
	$grr = explode(',', $gw);
	
	for ($i = 0;$i < (count($brr) - 1);$i++){
		
		for ($is = 0;$is < (count($srr) - 1);$is++){
			
			for ($ig = 0;$ig < (count($grr) - 1);$ig++){
				$zh = $zh . $brr[$i] . $srr[$is] . $grr[$ig] . '|';
			}
		}
	}
	$zhrr = explode('|', $zh);
	$zhnum = count($zhrr) - 1;
}else if ($wtypename == '1D 百位'){
	$zhrr = explode(',', $bw);
	$zhnum = count($zhrr) - 1;
}else if ($wtypename == '1D 十位'){
	$zhrr = explode(',', $sw);
	$zhnum = count($zhrr) - 1;
}else if ($wtypename == '1D 个位'){
	$zhrr = explode(',', $gw);
	$zhnum = count($zhrr) - 1;
}else if ($wtypename == '2D 百位 十位'){
	$brr = explode(',', $bw);
	$srr = explode(',', $sw);
	
	for ($i = 0;$i < (count($brr) - 1);$i++){
		
		for ($is = 0;$is < (count($srr) - 1);$is++){
			$zh = $zh . $brr[$i] . $srr[$is] . '|';
		}
	}
	$zhrr = explode('|', $zh);
	$zhnum = count($zhrr) - 1;
}else if ($wtypename == '2D 百位 个位'){
	$brr = explode(',', $bw);
	$grr = explode(',', $gw);
	
	for ($i = 0;$i < (count($brr) - 1);$i++)
	{
		
		for ($ig = 0;$ig < (count($grr) - 1);$ig++){
			$zh = $zh . $brr[$i] . $grr[$ig] . '|';
		}
	}
	$zhrr = explode('|', $zh);
	$zhnum = count($zhrr) - 1;
}else if ($wtypename == '2D 十位 个位'){
	$srr = explode(',', $sw);
	$grr = explode(',', $gw);
	
	for ($i = 0;$i < (count($srr) - 1);$i++){
		
		for ($ig = 0;$ig < (count($grr) - 1);$ig++){
			$zh = $zh . $srr[$i] . $grr[$ig] . '|';
		}
	}
	$zhrr = explode('|', $zh);
	$zhnum = count($zhrr) - 1;
}else if ($wtypename == '组一'){
	$zhrr = explode(',', $sw);
	$zhnum = count($zhrr) - 1;
}else if ($wtypename == '组二'){
	$brr = explode(',', $bw);
	$srr = explode(',', $sw);
	$ii = 0;
	
	for ($i = 0;$i < (count($brr) - 1);$i++){
		for ($is = 0;$is < (count($srr) - 1);$is++){
			if ($brr[$i] <= $srr[$is]){
				$zh = $zh . $brr[$i] . $srr[$is] . '|';
			}
		}
	}
	$zhrr = explode('|', $zh);
	$zhnum = count($zhrr) - 1;
}else if ($wtypename == '组三'){
	$brr = explode(',', $bw);
	$srr = explode(',', $sw);
	$grr = explode(',', $gw);
	
	for ($i = 0;$i < (count($brr) - 1);$i++){
		
		for ($ig = 0;$ig < (count($grr) - 1);$ig++){
			$zh = $zh . $brr[$i] . $srr[$i] . $grr[$ig] . '|';
		}
	}
	$zhrr = explode('|', $zh);
	$zhnum = count($zhrr) - 1;
}else if ($wtypename == '组六'){
	$allnum = $bw . $sw . $gw;
	$allrr = explode(',', $allnum);
	
	for ($i = 0;$i < (count($allrr) - 1);$i++){
		
		for ($is = $i + 1;$is < (count($allrr) - 1);$is++)
		{
			
			for ($ig = $is + 1;$ig < (count($allrr) - 1);$ig++)
			{
				$zh = $zh . $allrr[$i] . $allrr[$is] . $allrr[$ig] . '|';
			}
		}
	}
	$zhrr = explode('|', $zh);
	$zhnum = count($zhrr) - 1;
}else{
	$zhrr[0] = $content;
	$zhnum = 1;
}
include_once '../../cache/group_' . @($_SESSION['gid']) . '.php';
$cp_zd = @($pk_db['彩票最低']);
$cp_zg = @($pk_db['彩票最高']);
if (0 < $cp_zd){
	$cp_zd = $cp_zd;
}else{
	$cp_zd = $lowbet;
}
if (0 < $cp_zg){
	$cp_zg = $cp_zg;
}else{
	$cp_zg = 1000000;
}
include_once '../../ajaxleft/postkey.php';
$orderinfo = $trow['qihao'].$zhnum.'ssl'.$btype.$ctype.$dtype.$stype.'y';
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
			  float:left;
		  } 
	  </style> 
  </head> 
  <body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 659px;"> 
	  <!--头部开始--> 
	  <header id="header">
		  <?php if ($uid != 0){?><a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a><?php }?> 			  
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
				  上海时时乐 
			  </h1> 
		  </div> 
	  </section> 
	  <form name="form" id="form" action="sslOrder.php" method="POST"> 
	  <section class="mContent" style="padding-left:0px;padding-right:0px;padding-top:5px;"> 
		  <div data-role="tabs" id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all"> 
			  <input type="hidden" name="stype" value="<?=$stype;?>"> 
			  <input type="hidden" name="btype" value="<?=$btype;?>"> 
			  <input type="hidden" name="ctype" value="<?=$ctype;?>"> 
			  <input type="hidden" name="dtype" value="<?=$dtype;?>"> 
			  <input type="hidden" name="zhnum" value="<?=$zhnum;?>"> 
			  <div id="three" class="ui-body-d ui-content" style="padding:0px;"> 
				  <div style="clear:both;padding-bottom:5px;border-bottom-width:1px;border-color:#DDD;border-style:solid;text-align:center;"> 
					  <b> 
						  <p> 
							  <font color="#990000"><?=$btype;?> - <?=$ctype;?> - <?=$dtype;?></font> 注单内容 
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
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:30%;" 
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
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:25%;" 
						  data-role="none"> 
							  可贏金额 
						  </li> 
					  </ul> 
					  <ul class="biaodan1" data-role="none">
					  <?php for($i = 0;$i < $zhnum;$i++){?> 							  
					  	  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:30%;" data-role="none"> 
							  <p><?=$zhrr[$i];?></p> 
						  </li> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:20%;" data-role="none">
						  <?php 
						    $myodds = $oddsshow[0];
							if ($stype == 3){
								$z2hm1 = substr($zhrr[$i], 0, 1);
								$z2hm2 = substr($zhrr[$i], 1, 1);
								if ($z2hm1 == $z2hm2){
									$myodds = $oddsshow[1];
								}
							}
							?> 								  
							<p id="odd_<?=$i;?>" style="color:#FF0000;"><?=$myodds;?></p> 
						  </li> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:25%;text-align:center;" 
						  data-role="none"> 
							  <input type="hidden" name="key_<?=$i;?>" value="<?php echo StrToHex($orderinfo.$zhrr[$i], $postkey);?>">
							  <input type="hidden" name="content_<?=$i;?>" value="<?=$zhrr[$i];?>" />
							  <input id="money_<?=$i;?>" maxlength="12" size="12" onBlur="win(<?=$i;?>)" onKeyUp="digitOnly(this)" value="<?=$cp_zd;?>" name="money_<?=$i;?>" data-role="none" style="width:80%;text-align:center;"/> 
						  </li> 
						  <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;width:25%;" 
						  data-role="none"> 
							  <p id="win_<?=$i;?>"><?=$cp_zd * $myodds;?></p> 
						  </li>
						<?php }?> 						  
					</ul> 
				  </div> 
			  </div> 
			  <div style="clear:both;padding-top:10px;padding-left:10px;"> 
				  <div style="clear:both;text-align:center;"> 
					  <a href="javascript:goBack();" class="ui-btn ui-btn-inline"> 
						  取消下注 
					  </a> 
					  <a href="javascript:formReset();" class="ui-btn ui-btn-inline"> 
						  重设金额 
					  </a> 
					  <a href="javascript:formSubmit();" class="ui-btn ui-btn-inline"> 
						  确认下注 
					  </a> 
				  </div> 
			  </div> 
		  </div> 
	  </section> 
	  <!--底部开始--><?php include_once '../bottom.php';?>		  <!--底部结束--> 
	  <!--我的资料--><?php include_once '../member/myinfo.php';?>		
	  <script type="text/javascript" src="../js/script.js"></script> 
	  <script type="text/javascript"> 
		  function changeTwoDecimal(x) { 
			  var f_x = parseFloat(x);

			  if (isNaN(f_x)) { 
				  alert('function:changeTwoDecimal->parameter error');
				  return false;
			  } 

			  var f_x = Math.round(x * 100) / 100;

			  return f_x;
		  } 
		  function win(id) { //计算可赢金额 
			  var je = $("#money_" + id).val();
			  je = parseInt(je.replace(/\b(0+)/gi, ""));
			  var pl = $("#odd_" + id).html();
			  if (isNaN(je)) { 
				  $("#money_" + id).val(0);
				  $("#win_" + id).html(0);
			  } else { 
				  $("#win_" + id).html(changeTwoDecimal(je * pl ));
			  } 
		  } 
		
		  function goBack() { //取消下注 
			  window.location.href = "ssl.php";
		  } 
		  function formReset() { //重置表单 
			  for (i = 0;i <<?=$zhnum;?>;i++) { 
				  $("#money_" + i).val(0);
				  $("#win_" + i).html(0);
			  } 
		  } 
		  function formSubmit() { //提交表单 
			  var ts = "";
			  var je = 0;
			
			  for(var i=1;i<=<?=count($betlist);?>;i++){ 
				  je = $("#money_"+i).val();
				  if (je <<?=$cp_zd;?> || je == '') { 
					  alert('最低下注金额为<?=$cp_zd;?>￥');
					  $("#money_"+i).focus();
					  return ;
				  } else if (je ><?=$cp_zg;?>) { 
					  alert('下注金额超过最大限额<?=$cp_zg;?>￥！');
					  $("#money_"+i).focus();
					  return ;
				  } 
			  } 
			  if (confirm("确认提交下注？")) document.form.submit();
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