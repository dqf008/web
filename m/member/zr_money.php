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
include_once '../../cj/live/live_giro.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
if (!$userinfo){
	message('用户不存在！');
	exit();
}
$username = $userinfo['username'];

$userinfo = user::getinfo($uid);

if ($_POST['save'] == 'ok'){
	if($userinfo['iszhuan']==1){
		$liveType = $_POST['liveType'];
		$liveMoney = $_POST['liveMoney'];
		$zz_money = abs(intval($_POST['zz_money']));
		if ($zz_money < $web_site['zh_low']){
			message('转账金额最低为：' . $web_site['zh_low'] . '元，请重新输入');
			exit();
		}else if ($web_site['zh_high'] < $zz_money){
			message('转账金额最高为：' . $web_site['zh_high'] . '元，请重新输入');
			exit();
		}

		//转帐
		if($liveType == 'MAYA'){
			$json = giro_MAYA($uid,$liveType,$liveMoney,$zz_money);
		}elseif($liveType == 'MW'){
			$json = giro_MW($uid,$liveType,$liveMoney,$zz_money);
		}elseif($liveType == 'KG'){
			$json = giro_KG($uid,$liveType,$liveMoney,$zz_money);
		}elseif($liveType == 'CQ9'){
			$json = giro_CQ9($uid,$liveType,$liveMoney,$zz_money);
		}elseif($liveType == 'MG2'){
			$json = giro_MG2($uid,$liveType,$liveMoney,$zz_money);
		}elseif($liveType == 'VR'){
			$json = giro_VR($uid,$liveType,$liveMoney,$zz_money);
		}elseif($liveType == 'BGLIVE'){
			$json = giro_BG($uid,$liveType,$liveMoney,$zz_money);
		}elseif($liveType == 'SB'){
			$json = giro_SB($uid,$liveType,$liveMoney,$zz_money);
		}elseif($liveType == 'DG'){
			$json = giro_DG($uid,$liveType,$liveMoney,$zz_money);
		}elseif($liveType == 'OG2'){
			$json = giro_OG2($uid,$liveType,$liveMoney,$zz_money);
		}elseif($liveType == 'PT2'){
			$json = giro_PT2($uid,$liveType,$liveMoney,$zz_money);
		}elseif($liveType == 'KY'){
			$json = giro_KY($uid,$liveType,$liveMoney,$zz_money);
		}elseif($liveType == 'BBIN2'){
			$json = giro_BBIN2($uid,$liveType,$liveMoney,$zz_money);
		}else{
			$json = giro($uid,$liveType,$liveMoney,$zz_money);
			
		}

		if($json == 'ok'){
			message('转帐成功!!', 'zr_data_money.php');
			exit();
		}else{
			message($json);
			exit();
		}
	}else{
		message('您已被禁止转帐!!请联系客服!!');
	}
}
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
  <script language="javascript"> 
  	 $(function(){
  	  	reflivemoney_one();
  	  });

  	  function reflivemoney_one(){
  	  	  $("span[id^=live_money_span_]").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_db.php?callback=?",function (data) { 
		  	if(data.info=='ok'){
		  		$("#agin_money").html(data.AGIN);
		  		$("#ag_money").html(data.AG);
		  		$("#bb_money").html(data.BBIN);
		  		$("#maya_money").html(data.MAYA);
		  		$("#shaba_money").html(data.SHABA);
		  		$("#kg_money").html(data.KG);
		  		$("#mw_money").html(data.MW);
		  		$("#cq9_money").html(data.CQ9);
		  		$("#mg2_money").html(data.MG2);
		  		$("#vr_money").html(data.VR);
		  		$("#bg_money").html(data.BGLIVE);
		  		$("#sb_money").html(data.SB);
		  		$("#og2_money").html(data.OG2);
		  		$("#dg_money").html(data.DG);
		  		$("#pt2_money").html(data.PT2);
		  		$("#bbin2_money").html(data.BBIN2);
		  		$("#ky_money").html(data.KY);
		  	}else{
		  		$("span[id$=_money]").html(data.msg);
		  	}
		  	
		  });
  	  }
	  function reflivemoney(zztype) {
		  $("#"+zztype.toLowerCase()+"_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money.php?callback=?&type="+zztype,function (data) { 
			  $("#"+zztype.toLowerCase()+"_money").html(data.msg);
		  });
	  } 
	  
 	  function reflivemoney_MAYA() {
		  $("#maya_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_MAYA.php?callback=?",function (data) { 
			  $("#maya_money").html(data.msg);
		  });
	  } 

	  function reflivemoney_MW() {
		  $("#mw_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_MW.php?callback=?",function (data) { 
			  $("#mw_money").html(data.msg);
		  });
	  }
	  function reflivemoney_KG() {
		  $("#kg_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("../../cj/live/live_money_KG.php?callback=?",function (data) { 
			  $("#kg_money").html(data.msg);
		  });
	  }
	  function reflivemoney_CQ9() {
		  $("#cq9_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_CQ9.php?callback=?",function (data) { 
			  $("#cq9_money").html(data.msg);
		  });
	  }
	   function reflivemoney_MG2() {
		  $("#mg2_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_MG2.php?callback=?",function (data) { 
			  $("#mg2_money").html(data.msg);
		  });
	  }
	  function reflivemoney_VR() {
		  $("#vr_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_VR.php?callback=?",function (data) { 
			  $("#vr_money").html(data.msg);
		  });
	  }
	  function reflivemoney_SB() {
		  $("#sb_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_SB.php?callback=?",function (data) { 
			  $("#sb_money").html(data.msg);
		  });
	  }
	  function reflivemoney_BG() {
		  $("#bg_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_BG.php?callback=?",function (data) { 
			  $("#bg_money").html(data.msg);
		  });
	  }
	  function reflivemoney_DG() {
		  $("#dg_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_DG.php?callback=?",function (data) { 
			  $("#dg_money").html(data.msg);
		  });
	  }
	  function reflivemoney_OG() {
		  $("#og2_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_OG.php?callback=?",function (data) { 
			  $("#og2_money").html(data.msg);
		  });
	  }
	  function reflivemoney_PT() {
		  $("#pt2_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_PT.php?callback=?",function (data) { 
			  $("#pt2_money").html(data.msg);
		  });
	  }
	  function reflivemoney_BBIN() {
		  $("#bbin2_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_BBIN.php?callback=?",function (data) { 
			  $("#bbin2_money").html(data.msg);
		  });
	  }
	  function reflivemoney_KY() {
		  $("#ky_money").html('<img src="/Box/skins/icons/loading.gif" />');
		  $.getJSON("/cj/live/live_money_KY.php?callback=?",function (data) { 
			  $("#ky_money").html(data.msg);
		  });
	  }
  </script>
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-url="/m/member/zr_money.php" tabindex="0" style="min-height: 640px;"> 
  <!--头部开始--> 
  <header id="header"> 
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
		  <span>额度转换</span> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 

  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <form action="zr_money.php" method="post" name="lt_form" data-role="none" data-ajax="false"> 
		  <input type="hidden" name="save" value="ok"> 
		  <div data-role="cotent" style="margin:0px auto;width:99%;"> 
			  <ul data-role="listview" class="ui-listview"> 
				  <li class="ui-li-static ui-body-inherit ui-first-child"> 
					  <label>用户账号：<?=$userinfo['username'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>体育/彩票余额：<?=$userinfo['money'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>转帐真人选择：</label>
					  <table width="100%" border="0" style=" line-height:30px;">
					  <tr>
					    <td width="34"><input type="radio" name="liveType" value="AGIN" checked="checked" style="margin-top:-15px"></td>
					    <td colspan="5">AG国际厅<font color='red'>（包含XIN电子、BG电子、AG街机）</font></td>
					  </tr>
					  <tr>
					    <td width="34"><input type="radio" name="liveType" value="AG" style="margin-top:-15px;"></td>
					    <td>AG极速厅</td>
					    <td width="34"><input type="radio" name="liveType" value="BBIN2" style="margin-top:-15px;"></td>
					    <td>新BB波音厅</td>
					  	<td width="34"><input type="radio" name="liveType" value="MAYA"  style="margin-top:-15px;"></td>
					    <td>玛雅娱乐厅</td>					    
					  </tr>
					  <tr>
					  	<td><input type="radio" name="liveType" value="OG2"  style="margin-top:-15px;"></td>
					  	<td>新OG东方厅</td>
					  	<td><input type="radio" name="liveType" value="BGLIVE"  style="margin-top:-15px;"></td>
					  	<td>BG视讯(捕鱼)</td>
					  	<td><input type="radio" name="liveType" value="SB"  style="margin-top:-15px;"></td>
					  	<td>申博视讯</td>					    
					  </tr>
					  <tr>
					  	<td><input type="radio" name="liveType" value="MG2" style="margin-top:-15px;"></td>
					  	<td>新MG电子</td>
					    <td><input type="radio" name="liveType" value="PT2"  style="margin-top:-15px;"></td>
					    <td>新PT电子</td>
					  	<td><input type="radio" name="liveType" value="MW" style="margin-top:-15px;"></td>
					  	<td>MW电子</td>					  	
					  </tr>
					   <tr>
					    <td><input type="radio" name="liveType" value="KG" style="margin-top:-15px;"></td>
					    <td>AV女优</td>
					  	<td><input type="radio" name="liveType" value="CQ9" style="margin-top:-15px;"></td>
					    <td>CQ9电子</td>
					  	<td><input type="radio" name="liveType" value="SHABA" style="margin-top:-15px;"></td>
					  	<td>沙巴体育</td>
					  </tr> 
					  <tr>
					  	<td><input type="radio" name="liveType" value="VR" style="margin-top:-15px;"></td>
					  	<td>VR彩票</td>
					  	<td><input type="radio" name="liveType" value="DG" style="margin-top:-15px;"></td>
					  	<td>DG视讯</td>
					  	<td width="34"><input type="radio" name="liveType" value="BBIN" style="margin-top:-15px;"></td>
					    <td>BB波音厅</td>
					  </tr>
					</table> 
				  </li>
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>转帐类型：</label>
					  <table width="100%" border="0" style=" line-height:30px;">
					  <tr>
					    <td width="34"><input type="radio" name="liveMoney" value="IN" checked="checked" style="margin-top:-15px;"></td>
					    <td>转入</td>
					    <td width="34"><input type="radio" name="liveMoney" value="OUT" style="margin-top:-15px;"></td>
					    <td>转出</td>
					    <td width="34"></td>
					    <td >&nbsp;</td>
					  </tr>					  
					</table> 
				  </li>
				  
				  <li class="ui-li-static ui-body-inherit"> 
				  <label>转账金额：<input type="text" id="zz_money" name="zz_money" onBlur="clearNoNum(this);" onKeyUp="clearNoNum(this);" maxlength="10" data-role="none"></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit ui-last-child"> 
				  <label style="margin-left:80px;"><button id="btnSubmit" name="btnSubmit" onClick="return submitForm();" class="ui-btn ui-btn-inline">提交</button></label> 
				  </li> 
			  </ul> 
		  </div> 
	  </form> 

  <div data-role="cotent" style="margin:15px auto 0px auto;width:99%;"> 
	  <ul data-role="listview" class="ui-listview"> 
		  <li class="ui-li-static ui-body-inherit ui-first-child"> 
			  <label>AG国际厅余额： 
				  <span id="agin_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney('AGIN')">刷新</a> 
			  </label> 
		  </li> 
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>AG极速厅余额： 
				  <span id="ag_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney('AG')">刷新</a> 
			  </label> 
		  </li> 
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>新BB波音厅余额： 
				  <span id="bbin2_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_BBIN()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>玛雅娱乐厅余额： 
				  <span id="maya_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_MAYA()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>新OG东方厅余额： 
				  <span id="og2_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_OG()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>BG视讯余额： 
				  <span id="bg_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_BG()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>申博视讯余额： 
				  <span id="sb_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_SB()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>新MG电子余额： 
				  <span id="mg2_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_MG2()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>新PT电子余额： 
				  <span id="pt2_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_PT()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>MW电子游戏余额： 
				  <span id="mw_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_MW()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>AV女优余额： 
				  <span id="kg_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_KG()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>CQ9电子余额： 
				  <span id="cq9_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_CQ9()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>沙巴体育余额： 
				  <span id="shaba_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney('SHABA')">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>VR彩票余额： 
				  <span id="vr_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_VR()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>DG视讯余额： 
				  <span id="dg_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney_DG()">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>BB波音厅余额： 
				  <span id="bb_money">0.00</span> 
				  <a href="javascript:void(0);" onClick="reflivemoney('BBIN')">刷新</a> 
			  </label> 
		  </li>
		  <li class="ui-li-static ui-body-inherit ui-last-child"> 
			  <label>转换记录：<a href="javascript:window.location.href='zr_data_money.php';" style="color:blue" class="ui-link">点击查询</a></label> 
		  </li> 
	  </ul> 
  </div> 
  </section> 
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once 'myinfo.php';?>		
  <script type="text/javascript"> 
  //数字验证 过滤非法字符 
  function clearNoNum(obj){ 
	  obj.value = obj.value.replace(/[^\d.]/g,"");//先把非数字的都替换掉，除了数字和. 
	  obj.value = obj.value.replace(/^\./g,"");//必须保证第一个为数字而不是. 
	  obj.value = obj.value.replace(/\.{2,}/g,".");//保证只有出现一个.而没有多个. 
	  obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");//保证.只出现一次，而不能出现两次以上 
	  if(obj.value != ''){ 
		  var re=/^\d+\.{0,1}\d{0,2}$/;
		  if(!re.test(obj.value)) { 
			  obj.value = obj.value.substring(0,obj.value.length-1);
			  return false;
		  } 
	  } 
  } 
  //提交表单 
  function submitForm(){ 
	  var hk = $("#zz_money").val();
	  if(hk==""){ 
		  alert('请输入转账金额');
		  $("#zz_money").focus();
		  return false;
	  }else{ 
		  hk = hk*1;
		  if(hk<<?=$web_site['zh_low'];?>){ 
			  alert('转账金额最低为：<?=$web_site['zh_low'];?>元');
			  $("#zz_money").select();
			  return false;
		  }else if(hk><?=$web_site['zh_high'];?>){ 
			  alert('转账金额最高为：<?=$web_site['zh_high'];?>');
			  $("#zz_money").select();
			  return false;
		  } 
	  } 

	  $("#btnSubmit").html("转账处理中");
	  $("#btnSubmit").attr("disabled","disabled");
	  document.lt_form.submit();
  } 
  </script> 
</body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>