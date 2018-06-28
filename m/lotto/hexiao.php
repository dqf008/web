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
$class1 = '生肖';
$class2 = $_GET['ids'];
if (!isset($class2)){
	$class2 = '二肖';
}
$initarry = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$xiabiao = arraysort($initarry);
$peilv_array = array();
$stmt_tm = caipiaorate($class1, $class2);
$betnumber = 0;
while ($rows = $stmt_tm->fetch()){
	$peilv_array[$betnumber]['class3'] = $rows['class3'];
	$peilv_array[$betnumber]['rate'] = $rows['rate'];
	$betnumber++;
}

$mysql = "select * from ka_sxnumber limit 12";
$stmt = $mydata2_db->query($mysql);
$zodiac_num_array = array();
while($rs = $stmt->fetch()){
	$zodiac_num_array[] = $rs['m_number'];
}
?>
<!DOCTYPE html>
<html class="ui-mobile ui-mobile-viewport ui-overlay-a">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<base href=".">
<meta name="viewport"  content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
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
<script type="text/javascript" src="../js/script.js"></script>
		  <title><?=$web_site['web_title'];?></title>
	  <style type="text/css">
.ui-block-a, .ui-block-b, .ui-block-c {
  border: 1px solid black;
  height: 35px;
  font-weight: bold;
}
.lhc-bgc-a {
  padding-top: 2px;
  background-color: #FCF8E9;
}
.lhc-bgc-b {
  padding-top: 6px;
  background-color: #EEEEEE;
}
.lhc-bgc-c {
  padding-top: 6px;
  background-color: #EEEEEE;
}
.lhc-bgc-abc {
  padding-top: 8px;
  background-color: lightgray;
}
.lhc-circle-a {
  width: 30px;
  height: 30px;
  background-color: #ffc1c1;
  border-radius: 20px;
}
.lhc-circle-b {
  height: 30px;
  line-height: 30px;
  display: block;
  color: #000;
  text-align: center;
  font-size: 18px;
}
.lhc-info {
  border-width: 1px;
  border-color: lightgray;
  border-style: solid;
  padding: 5px;
}
#lt_form {
  text-align: center;
}
</style>
</head>
<body class="mWrap ui-page ui-page-theme-a ui-page-active"
  data-role="page" data-url="/m/liuhecai/hexiao.php?ids=三肖" tabindex="0"
  style="min-height: 736px;">
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
  <div style="display: none;" id="popupPanel-placeholder"></div>
  <!--头部结束-->
  <!-- 六合彩倒计时 -->
  <section class="sliderWrap clearfix">
	  <div data-role="header" style="overflow: hidden;" role="banner"
		  class="ui-header ui-bar-inherit">
		  <h1 class="ui-title" role="heading" aria-level="1">六合彩 - <?=$class2;?></h1>
	  </div><?php include_once '_pankouinfoshow.php';?>		  
  </section>
  <!--生肖列表-->
  <section class="mContent clearfix" style="padding: 0 1px 0 2px;">
	  <form name="lt_form" id="lt_form" method="post"
		  action="hexiao_post.php?class2=<?=$class2;?>"
		  data-role="none" data-ajax="false">
		  <input type="hidden" name="r_init" id="rinit" value="0">
		  <input type="hidden" name="min_bl" id="minbl" value="3.70">
		  <input type="hidden" name="betValue" id="betValue" value="">
		  <div class="ui-grid-b">
			  <div class="ui-block-a lhc-bgc-abc">
				  <span>生肖</span>
			  </div>
			  <div class="ui-block-b lhc-bgc-abc">
				  <span>赔率</span>
			  </div>
			  <div class="ui-block-c lhc-bgc-abc">
				  <span>号码</span>
			  </div>
			  <?php 
			    $length = count($peilv_array);
				for ($i = 0;$i < $length;$i++){
			  ?>                 
			  <div class=" ui-checkbox">
				  <input name="num<?=$xiabiao[$i];?>" id="num<?=$xiabiao[$i];?>" value="<?=$peilv_array[$xiabiao[$i]]['class3'];?>" onClick="pfix();" type="checkbox" style="display: none">
			  </div>
			  <div class="ui-block-a lhc-bgc-a" style="padding-left: 12%;">
				  <div class="lhc-circle-a">
					  <span class="lhc-circle-b"><?=$peilv_array[$xiabiao[$i]]['class3'];?></span>
				  </div>
			  </div>
			  <div class="ui-block-b lhc-bgc-b">
				  <span id="pfix<?=$xiabiao[$i];?>" style="color: red;"><?=$peilv_array[$xiabiao[$i]]['rate'];?></span>
			  </div>
			  <div class="ui-block-c lhc-bgc-c" data-num="<?=$xiabiao[$i];?>" id="font_<?=$xiabiao[$i];?>">
				  <label style="font-size: 12px;"><?=$zodiac_num_array[$xiabiao[$i]];?></label>
			  </div>
			  <?php }?> 				
		   </div>
		  <div style="clear: both;margin: 10px 0;">
			  赔率：<font color="0000ff"><b><span id="bl1">0</span></b></font> 下注金额：
			  <input type="text" name="num_1" id="num_1" onkeyup="digitOnly(this);countGold(this,'keyup');" onfocus="this.value='';" onBlur="countGold(this,'blur','SP','');"  maxlength="7" size="7" style="width: 80px;" data-role="none">
		  </div>
		  <div style="clear: both;text-align: center;">
			  <a href="javascript:resetForm();" class="ui-btn ui-btn-inline">重设</a>
			  <button name="btnSubmit" onClick="return submitForm();"
				  class="ui-btn ui-btn-inline">提交</button>
		  </div>
	  </form>
	  <span id="totalgold" style="display: none">0</span>
  </section>
  <!--底部-->
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束-->
  <!--我的资料--><?php include_once '../member/myinfo.php';?>	  
  <script type="text/javascript">
		$(document).ready(function(){
			$("input[type='checkbox']:checked").each(function(){
				var id = $(this).attr("id");
				var fontId = id.replace('num','');
				$('#font_' + fontId).prevAll().andSelf().slice(-3).css("background-color", "#cddc39");
				pfix();
			});
			$(".lhc-bgc-a, .lhc-bgc-b, .lhc-bgc-c").on("click", function(){
			  	var e = $(this), v;
			  	!e.hasClass("ui-block-c") && (e = e.nextAll(".lhc-bgc-c").first()),
			  	v = $("#num" + e.data("num")),
			  	e = e.prevAll().andSelf().slice(-3),
			  	v.attr("checked") ? (v.attr("checked", false), e.css("background-color", "")) : (v.attr("checked", true), e.css("background-color", "#cddc39")),
			  	pfix()
			});
		});

		  function setCheckbox(num,obj){
			  obj_check = "#num" + num;
			  if($(obj_check).attr("checked")){
				  $(obj_check).attr("checked",false);
				  $(obj).attr("style","");
			  }else{
				  $(obj_check).attr("checked",true);
				  $(obj).attr("style","color:#fff;");
			  }
			  pfix();
		  }
		  function resetForm(){
			  $("#num_1").val("");
			  $("#bl1").html(0);
			  $("input[type='checkbox']").attr("checked", false);
			  $(".lhc-bgc-a, .lhc-bgc-b, .lhc-bgc-c").css("background-color", "");
		  }
		  var $ids = '<?=$class2;?>';
		  var type_nums = 6;
		  switch($ids){
			  case '二肖':
				  type_nums = 2;
			  break;
			  case '三肖':
				  type_nums = 3;
			  break;
			  case '四肖':
				  type_nums = 4;
			  break;
			  case '五肖':
				  type_nums = 5;
			  break;
			  case '六肖':
				  type_nums = 6;
			  break;
			  case '七肖':
				  type_nums = 7;
			  break;
			  case '八肖':
				  type_nums = 8;
			  break;
			  case '九肖':
				  type_nums = 9;
			  break;
			  case '十肖':
				  type_nums = 10;
			  break;
			  case '十一肖':
				  type_nums = 11;
			  break;
		  }
		  function submitForm(){
			  var uid = $("#uid").val();
			  if(uid == "" || uid == null){
				  alert("登录后才能进行此操作");
				  return false;
			  }
			  var checkCount = 0;
			  for(var i=0;i<=11;i++){
				  obj_check = "#num" + i;
				  if($(obj_check).attr("checked")){
					  checkCount++;
				  }
			  }
			  if(checkCount != type_nums){
				  alert("请选择"+type_nums+"个生肖");
				  return false;
			  }
			  if($("#num_1").val() == "" || $("#num_1").val() == null) {
				  alert("请输入下注金额");
				  return false;
			  }
			  var result='';
			  $("input[type='checkbox']:checked").each(function(){
					  result =  result + "," + $(this).val();
			  })
			  $("#betValue").val(result);
			  document.getElementById("lt_form").submit();
		  }
		  function countGold(gold,type,rtype,bb,ffb){
			  var goldvalue = gold.value;
			  switch(type){
				  case "blur":
					  if((eval(goldvalue) < 0) && (goldvalue!='')){
						  gold.focus();
						  alert("下注金额不可小于最低限度：0");
						  return false;
					  }
					  if(rtype=='SP' && (eval(goldvalue) > 40000)){
						  gold.focus();
						  alert("对不起,下注金额已超过单注限额：40000");
						  return false;
					  }
				  break;
			  }
		  }
		  var _peilv;
		  function pfix(){
			  if(!_peilv){
				  _peilv = parseFloat($("#rinit").val());
			  }
			  var peilv = _peilv;
			  var count = 0;
			  for(var i=0;i<=<?=$length;?>;i++){
				  obj_check = "#num" + i;
				  if($(obj_check).attr("checked")){
					  obj_pfix = "#pfix" + i;
					  peilv += ","+parseFloat($(obj_pfix).html());
					  count++;
				  }
			  }
			  if(count==0){
				  $("#bl1").html(0);
				  return false;
			  }
			  var ii = peilv.split(",");
			  ii.sort(sortNumber);
			  if (parseInt(ii[0]) != 0) {
				  $("#bl1").html(ii[0]);
				  $("#minbl").val(ii[0]);
			  } else {
				  $("#bl1").html(ii[1]);
				  $("#minbl").val(ii[1]);
			  }
		  }
		  function sortNumber(a,b){
			  return a - b;
		  }
	  </script>
<?php 
function caipiaorate($class1, $class2){
	global $mydata1_db;
	$params = array(':class1' => $class1, ':class2' => $class2);
	$stmt = $mydata1_db->prepare('select class3,rate from mydata2_db.ka_bl where class1=:class1 and class2=:class2 order by id asc');
	$stmt->execute($params);
	return $stmt;
}
function arraysort($array){
	$newarray = array();
	
	for ($i = 0;$i < 6;$i++){
		$newarray[2 * $i] = $array[$i];
	}
	
	for ($j = 0;$j < 6;$j++){
		$newarray[(2 * $j) + 1] = $array[$j + 6];
	}
	return $newarray;
}
?>