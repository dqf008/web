<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '_pankouinfo.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
$class1 = '过关';
$params = array(':class1' => $class1);
$stmt = $mydata1_db->prepare('select class2,class3,rate from mydata2_db.ka_bl where  class1=:class1 order by id');
$stmt->execute($params);
$plArray = array();
$betnumber = 0;
while ($row = $stmt->fetch())
{
	$betnumber++;
	$plArray[$betnumber]['rate'] = $row['rate'];
	$plArray[$betnumber]['class2'] = $row['class2'];
	$plArray[$betnumber]['class3'] = $row['class3'];
}
?> 
<!DOCTYPE html>
<html class="ui-mobile">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
  <title><?=$web_site['web_title'];?>	  </title>
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
</head>
<body class="mWrap ui-mobile-viewport ui-overlay-a">
  <div data-role="page" data-url="/m/lotto/guoguan.php" tabindex="0" class="ui-page ui-page-theme-a ui-page-active">
	  <input type="hidden" name="uid" id="uid" value="<?=$uid;?>">
	  <!--头部开始-->
	  <header id="header">
	  <?php if ($uid != 0){?> 			  
	  	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a>
	  <?php }?> 			  
	  	  <span>彩票游戏</span>
		  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a>
	  </header>
	  <div class="mrg_header"></div>
	  <!--头部结束-->
	
	  <section class="sliderWrap clearfix">
		  <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit">
		  <h1 class="ui-title" role="heading" aria-level="1">六合彩 - <?=$class1;?></h1>
		  </div><?php include_once '_pankouinfoshow.php';?>
	  </section>
	  <!--赛事列表-->
	  <section class="mContent" style="padding-left:0px;padding-right:0px;padding-top:5px;">
		  <div id="myform" data-role="collapsibleset" data-theme="a" data-content-theme="a" class="ui-collapsible-set ui-group-theme-a ui-corner-all">
			  <div data-role="collapsible" class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content ui-collapsible-collapsed ui-first-child">
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">
					  正码1
				  </h4>
				  <ul data-role="listview" data-inset="false" class="ui-listview">
					  <li class="ui-li-static ui-body-inherit ui-first-child">
						  <input type="radio" value="1" id="zhengma_0" name="zhengma_11" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_0">单(赔率:<?=$plArray[1]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="2" id="zhengma_1" name="zhengma_11" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_1">双(赔率:<?=$plArray[2]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="3" id="zhengma_2" name="zhengma_12" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_2">大(赔率:<?=$plArray[3]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="4" id="zhengma_3" name="zhengma_12" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_3">小(赔率:<?=$plArray[4]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="5" id="zhengma_4" name="zhengma_13" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_4"><font style="color:red;">红波</font>(赔率:<?=$plArray[5]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="6" id="zhengma_5" name="zhengma_13" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_5"><font style="color:green;">绿波</font>(赔率:<?=$plArray[6]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit ui-last-child">
						  <input type="radio" value="7" id="zhengma_6" name="zhengma_13" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_6"><font style="color:blue;">蓝波</font>(赔率:<?=$plArray[7]['rate'];?>)</label>
					  </li>
				  </ul>
			  </div>
			  <div data-role="collapsible" class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content ui-collapsible-collapsed">
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">
					  正码2
				  </h4>
				  <ul data-role="listview" data-inset="false" class="ui-listview">
					  <li class="ui-li-static ui-body-inherit ui-first-child">
						  <input type="radio" value="8" id="zhengma_7" name="zhengma_21" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_7">单(赔率:<?=$plArray[8]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="9" id="zhengma_8" name="zhengma_21" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_8">双(赔率:<?=$plArray[9]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="10" id="zhengma_9" name="zhengma_22" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_9">大(赔率:<?=$plArray[10]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="11" id="zhengma_10" name="zhengma_22" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_10">小(赔率:<?=$plArray[11]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="12" id="zhengma_11" name="zhengma_23" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_11"><font style="color:red;">红波</font>(赔率:<?=$plArray[12]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="13" id="zhengma_12" name="zhengma_23" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_12"><font style="color:green;">绿波</font>(赔率:<?=$plArray[13]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit ui-last-child">
						  <input type="radio" value="14" id="zhengma_13" name="zhengma_23" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_13"><font style="color:blue;">蓝波</font>(赔率:<?=$plArray[14]['rate'];?>)</label>
					  </li>
				  </ul>
			  </div>
			  <div data-role="collapsible" class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content ui-collapsible-collapsed">
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">
					  正码3
				  </h4>
				  <ul data-role="listview" data-inset="false" class="ui-listview">
					  <li class="ui-li-static ui-body-inherit ui-first-child">
						  <input type="radio" value="15" id="zhengma_14" name="zhengma_31" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_14">单(赔率:<?=$plArray[15]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="16" id="zhengma_15" name="zhengma_31" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_15">双(赔率:<?=$plArray[16]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="17" id="zhengma_16" name="zhengma_32" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_16">大(赔率:<?=$plArray[17]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="18" id="zhengma_17" name="zhengma_32" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_17">小(赔率:<?=$plArray[18]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="19" id="zhengma_18" name="zhengma_33" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_18"><font style="color:red;">红波</font>(赔率:<?=$plArray[19]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="20" id="zhengma_19" name="zhengma_33" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_19"><font style="color:green;">绿波</font>(赔率:<?=$plArray[20]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit ui-last-child">
						  <input type="radio" value="21" id="zhengma_20" name="zhengma_33" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_20"><font style="color:blue;">蓝波</font>(赔率:<?=$plArray[21]['rate'];?>)</label>
					  </li>
				  </ul>
			  </div>
			  <div data-role="collapsible" class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content ui-collapsible-collapsed">
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">
					  正码4
				  </h4>
				  <ul data-role="listview" data-inset="false" class="ui-listview">
					  <li class="ui-li-static ui-body-inherit ui-first-child">
						  <input type="radio" value="22" id="zhengma_21" name="zhengma_41" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_21">单(赔率:<?=$plArray[22]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="23" id="zhengma_22" name="zhengma_41" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_22">双(赔率:<?=$plArray[23]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="24" id="zhengma_23" name="zhengma_42" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_23">大(赔率:<?=$plArray[24]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="25" id="zhengma_24" name="zhengma_42" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_24">小(赔率:<?=$plArray[25]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="26" id="zhengma_25" name="zhengma_43" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_25"><font style="color:red;">红波</font>(赔率:<?=$plArray[26]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="27" id="zhengma_26" name="zhengma_43" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_26"><font style="color:green;">绿波</font>(赔率:<?=$plArray[27]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit ui-last-child">
						  <input type="radio" value="28" id="zhengma_27" name="zhengma_43" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_27"><font style="color:blue;">蓝波</font>(赔率:<?=$plArray[28]['rate'];?>)</label>
					  </li>
				  </ul>
			  </div>
			  <div data-role="collapsible" class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content ui-collapsible-collapsed">
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">
					  正码5
				  </h4>
				  <ul data-role="listview" data-inset="false" class="ui-listview">
					  <li class="ui-li-static ui-body-inherit ui-first-child">
						  <input type="radio" value="29" id="zhengma_28" name="zhengma_51" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_28">单(赔率:<?=$plArray[29]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="30" id="zhengma_29" name="zhengma_51" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_29">双(赔率:<?=$plArray[30]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="31" id="zhengma_30" name="zhengma_52" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_30">大(赔率:<?=$plArray[31]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="32" id="zhengma_31" name="zhengma_52" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_31">小(赔率:<?=$plArray[32]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="33" id="zhengma_32" name="zhengma_53" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_32"><font style="color:red;">红波</font>(赔率:<?=$plArray[33]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="34" id="zhengma_33" name="zhengma_53" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_33"><font style="color:green;">绿波</font>(赔率:<?=$plArray[34]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit ui-last-child">
						  <input type="radio" value="35" id="zhengma_34" name="zhengma_53" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_34"><font style="color:blue;">蓝波</font>(赔率:<?=$plArray[35]['rate'];?>)</label>
					  </li>
				  </ul>
			  </div>
			  <div data-role="collapsible" class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content ui-collapsible-collapsed ui-last-child">
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">
					  正码6
				  </h4>
				  <ul data-role="listview" data-inset="false" class="ui-listview">
					  <li class="ui-li-static ui-body-inherit ui-first-child">
						  <input type="radio" value="36" class3="单" id="zhengma_35" name="zhengma_61" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_35">单(赔率:<?=$plArray[36]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="37" class3="双" id="zhengma_36" name="zhengma_61" data-role="none">&nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_36">双(赔率:<?=$plArray[37]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="38" id="zhengma_37" name="zhengma_62" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_37">大(赔率:<?=$plArray[38]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="39" id="zhengma_38" name="zhengma_62" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_38">小(赔率:<?=$plArray[39]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="40" id="zhengma_39" name="zhengma_63" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_39"><font style="color:red;">红波</font>(赔率:<?=$plArray[40]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit">
						  <input type="radio" value="41" id="zhengma_40" name="zhengma_63" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_40"><font style="color:green;">绿波</font>(赔率:<?=$plArray[41]['rate'];?>)</label>
					  </li>
					  <li class="ui-li-static ui-body-inherit ui-last-child">
						  <input type="radio" value="42" id="zhengma_41" name="zhengma_63" data-role="none">
						  &nbsp;&nbsp;
						  <label style="display:inline !important;" for="zhengma_41"><font style="color:blue;">蓝波</font>(赔率:<?=$plArray[42]['rate'];?>)</label>
					  </li>
				  </ul>
			  </div>
		  </div>
		  <div id="form_order"></div>
		  <form name="lt_form" id="lt_form" method="post" action="guoguan_post.php" data-role="none" data-ajax="false">
			  <div style="clear:both;margin:10px 0;">
				  下注金额：<input type="text" name="num_1" id="num_1" onKeyUp="digitOnly(this);" maxlength="7" size="7" style="width:80px;" data-role="none">
			  </div>
			  <div style="clear:both;margin:10px 0;">
				  最低限额: <font color="#FF0000"><?=$cp_zd;?>元</font>
			  </div>
			  <div style="clear:both;margin:10px 0;">
				  最高限额: <font color="#FF0000"><?=$cp_zg;?>元</font>
			  </div>
			  <div style="clear:both;text-align:center;">
				  <a href="javascript:resetForm();" class="ui-btn ui-btn-inline">重设</a>
				  <input type="hidden" name="class1" id="class1" value="<?=$class1;?>">
				  <input type="hidden" name="class2" id="class2" value="<?=$class2;?>">
				  <input type="hidden" name="betlist" id="betlist" value="">
				  <button name="btnSubmit" onClick="return submitForm();" class="ui-btn ui-btn-inline">提交</button>
			  </div>
		  </form>
	  </section>

	  <!--底部开始--><?php include_once '../bottom.php';?>		  <!--底部结束-->
	  <!--我的资料--><?php include_once '../member/myinfo.php';?>	
	  <script type="text/javascript" src="../js/script.js"></script>
	  <script type="text/javascript">
		  //规范输入金额
		  $('#myform').find("input:text").attr("onkeyup","digitOnly(this)");
		
		  //提交前确认
		  function submitForm(){
			  //登录后才能下注
			  var myuid = $("#uid").val();
			  if(myuid<=0 || myuid==''){
				  alert("请先登录，再下注");
				  return false;
			  }
			  //判断金额
			  var betlist = "";
			  var allmoney = 0;
			  var mix =<?=$cp_zd;?>;
			  var max =<?=$cp_zg;?>;
			  if($("#num_1").val()!=null && $("#num_1").val()!=''){
				  var money = parseInt($("#num_1").val());
				  //判断最小下注金额
				  if (money < mix) {
					  c = false;
					  alert("最低下注金额："+mix+"￥");
					  $("#num_1").focus();
					  return false;
				  }
				  if (money > max) {
					  d = false;
					  alert("最高下注金额："+max+"￥");
					  $("#num_1").focus();
					  return false;
				  }
				  allmoney = allmoney + money;
			  }
			  if(allmoney<=0){
				  alert("请输入金额！");
				  return false;
			  }else if(allmoney><?=$userinfo['money']<=0 ? 0 : $userinfo['money'];?>){
				  alert("下注总金额:"+allmoney+"￥,大于可用额度：<?=$userinfo['money']<=0 ? 0 : $userinfo['money'];?>￥");
				  return false;
			  }else{
				  //获取注单信息
				  var betlist = "";
				  for(var i =1;i<=6;i++){
					  for(var j =1;j<=3;j++){
						  var myselect = $('#myform input:radio[name="zhengma_'+i+""+j+'"]:checked ').val();
						  if(myselect!=null && myselect!='' ){
							  betlist = betlist + myselect + ",";
						  }
					  }
				  }
				  if(betlist==''){
					  alert("请选择下注信息");
					  return false;
				  }
				  $("#betlist").val(betlist);
				  document.lt_form.submit();
			  }
			  return false;
		  }
	  </script>
  </div>
  <div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div>
</body>
</html>