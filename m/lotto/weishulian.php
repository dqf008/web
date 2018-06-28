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
$id = $_GET['ids'];
$tma_rate = array();
$class1 = '尾数连';
$class2 = $id;
$stmt_tm = caipiaorate($class1, $class2);
$betnumber = 0;
while ($rows = $stmt_tm->fetch()){
	$betnumber++;
	$plArray[$betnumber]['class3'] = $rows['class3'];
	$plArray[$betnumber]['rate'] = $rows['rate'];
}
?>
<!DOCTYPE html>
<html class="ui-mobile ui-mobile-viewport ui-overlay-a">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title><?=$web_site['web_title'];?>	  </title>
<meta name="viewport"
  content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
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
  padding-top: 8px;
  background-color: #EEEEEE;
}
.lhc-bgc-abc {
  padding-top: 6px;
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
  data-role="page" tabindex="0" style="min-height: 736px;">
  <input type="hidden" name="uid" id="uid" value="<?=$uid;?>">
  <!--头部开始-->
  <header id="header">
  <?php if ($uid != 0){?> 			  
  	<a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link"  aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a>
  <?php }?> 	          
  <span>彩票游戏</span> 
  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a>
  </header>
  <div class="mrg_header"></div>
  <!--头部结束-->
  <div style="display: none;" id="popupPanel-placeholder"></div>
  <section class="sliderWrap clearfix">
	  <div data-role="header" style="overflow: hidden;" role="banner"
		  class="ui-header ui-bar-inherit">
		  <h1 class="ui-title" role="heading" aria-level="1">六合彩 - <?=$class2;?></h1>
	  </div><?php include_once '_pankouinfoshow.php';?>		  
  </section>
  <!--赛事列表-->
  <section class="mContent clearfix" style="padding: 0 1px 0 2px;">
	  <form name="lt_form" id="lt_form" method="post"
		  action="weishulian_post.php" data-role="none" data-ajax="false">
		  <div class="ui-grid-b">
			  <div class="ui-block-a lhc-bgc-abc">
				  <span>尾数</span>
			  </div>
			  <div class="ui-block-b lhc-bgc-abc">
				  <span>赔率</span>
			  </div>
			  <div class="ui-block-c lhc-bgc-abc">
				  <span>号码</span>
			  </div>
			  <?php  for ($i = 1;$i <= 10;$i++){?>
			  <div class=" ui-checkbox">
				  <input name="num<?=$i;?>" id="num<?=$i;?>" value="<?=$i;?>"
					  type="checkbox" style="display: none">
			  </div>
			  <div class="ui-block-a lhc-bgc-a" style="padding-left: 12%;">
				  <div class="lhc-circle-a">
					  <span class="lhc-circle-b"><?=$plArray[$i]['class3'];?></span>
				  </div>
			  </div>
			
			  <div class="ui-block-b lhc-bgc-b">
				  <span id="pfix0" style="color: red;"><?=$plArray[$i]['rate'];?></span>
			  </div>
			  <div class="ui-block-b lhc-bgc-c" id="font_<?=$i;?>" data-num="<?=$i;?>">
				  <label style="font-size: 12px;"><?=getnumberbyclass3($plArray[$i]['class3']);?></label>
			  </div>
			 <?php }?>
		  </div>
		  <div style="clear: both;margin: 10px 0px;">
			  下注金额：<input type="text" name="money" id="money"
				  onkeyup="digitOnly(this);" maxlength="7" size="7"
				  style="width: 80px;" data-role="none">
		  </div>
		  <div style="clear: both;text-align: center;">
			  <a href="javascript:resetForm();" class="ui-btn ui-btn-inline">重设</a>
			  <button name="btnSubmit" onClick="return submitForm();"
				  class="ui-btn ui-btn-inline">提交</button>
		  </div>
		  <input type="hidden" name="class1" id="class1" value="<?=$class1;?>" />
		  <input type="hidden" name="class2" id="class2" value="<?=$class2;?>" />
		  <input type="hidden" name="betlist" id="betlist" value="" />
	  </form>
	  <span id="totalgold" style="display: none">0</span>
  </section>
  <!--底部-->
  <div style="height: 50px;"></div>
  <!--底部开始--><?php include_once '../bottom.php';?>		  <!--底部结束-->
  <!--我的资料--><?php include_once '../member/myinfo.php';?>		  
  <script type="text/javascript" src="../js/script.js"></script>
  <script type="text/javascript">
	
        $(document).ready(function(){
            $("input[type='checkbox']:checked").each(function(){
                var id = $(this).attr("id");
                var fontId = id.replace('num','');
                $('#font_' + fontId).prevAll().andSelf().slice(-3).css("background-color", "#cddc39");
            });
            $(".lhc-bgc-a, .lhc-bgc-b, .lhc-bgc-c").on("click", function(){
                var e = $(this), v;
                !e.hasClass("ui-block-c") && (e = e.nextAll(".lhc-bgc-c").first()),
                v = $("#num" + e.data("num")),
                e = e.prevAll().andSelf().slice(-3),
                v.attr("checked") ? (v.attr("checked", false), e.css("background-color", "")) : (v.attr("checked", true), e.css("background-color", "#cddc39"))
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
          }
          function resetForm(){
              $("#num_1").val("");
              $("#bl1").html(0);
              $("input[type='checkbox']").attr("checked", false);
              $(".lhc-bgc-a, .lhc-bgc-b, .lhc-bgc-c").css("background-color", "");
          }
		  var type_min  = 2;
		  var type_nums = 8;
		  switch('<?=$class2;?>'){
			  case '二尾连中':
				  type_min  = 2;
				  type_nums = 8;
			  break;
			  case '三尾连中':
				  type_min  = 3;
				  type_nums = 8;
			  break;
			  case '四尾连中':
				  type_min  = 4;
				  type_nums = 8;
			  break;
			  case '二尾连不中':
				  type_min  = 2;
				  type_nums = 8;
			  break;
			  case '三尾连不中':
				  type_min  = 3;
				  type_nums = 8;
			  break;
			  case '四尾连不中':
				  type_min  = 4;
				  type_nums = 8;
			  break;
		  }
		  function submitForm(){
			  var betlist = "";
			  var checkCount = 0;
			  for(var i=1;i<=10;i++){
				  obj_check = "#num" + i;
				  if($(obj_check).attr("checked")){
					  checkCount++;
					  if(i != 10){
							  betlist = betlist + i +","
					  }else{
							  betlist = betlist + "0,"
					  }
				  }
			  }
			  if(checkCount > type_nums || checkCount < type_min){
				  alert("请选择"+type_min+"-"+type_nums+"个尾数");
				  return false;
			  }
			  var money = $("#money").val();
			  if(!money) {
				  alert("请输入下注金额");
				  return false;
			  }
			  //检查下注金额是否合法
			  if(!isNum(money)){
					  alert("下注金额不合法");
					  $("#money").val("");
				  return false;
			  }
			  
			  $("#betlist").val(betlist);
			  document.lt_form.submit();
		  }
		  function isNum(s)
		  {
			  if (s!=null && s!="")
			  {
				  return !isNaN(s);
			  }
			  return false;
		  }
	  </script>
</html>
<?php 
function caipiaorate($class1, $class2){
	global $mydata1_db;
	$params = array(':class1' => $class1, ':class2' => $class2);
	$stmt = $mydata1_db->prepare('select class3,rate from mydata2_db.ka_bl where class1=:class1 and class2=:class2 order by id asc');
	$stmt->execute($params);
	return $stmt;
}

function getNumberByClass3($class3){
	switch ($class3){
		case 1: return '01,11,21,31,41';
		case 2: return '02,12,22,32,42';
		case 3: return '03,13,23,33,43';
		case 4: return '04,14,24,34,44';
		case 5: return '05,15,25,35,45';
		case 6: return '06,16,26,36,46';
		case 7: return '07,17,27,37,47';
		case 8: return '08,18,28,38,48';
		case 9: return '09,19,29,39,49';
		case 0: return '10,20,30,40';
		default: return '';
	}
}
?>