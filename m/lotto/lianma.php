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
$class1 = '连码';
$params = array(':class1' => $class1);
$stmt = $mydata1_db->prepare('select class2,class3,rate from mydata2_db.ka_bl where  class1=:class1 order by id');
$stmt->execute($params);
$plArray = array();
$betnumber = 0;
while ($row = $stmt->fetch()){
	$betnumber++;
	$plArray[$betnumber]['rate'] = $row['rate'];
	$plArray[$betnumber]['class2'] = $row['class2'];
	$plArray[$betnumber]['class3'] = $row['class3'];
}
$sxArray = array();
$stmt = $mydata1_db->prepare('Select id,m_number,sx From mydata2_db.ka_sxnumber where id>=1 and id<=12 Order By ID');
$stmt->execute();
while ($row = $stmt->fetch())
{
	$sxArray[$row['id']]['sx'] = $row['sx'];
	$sxArray[$row['id']]['m_number'] = $row['m_number'];
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
  <div data-role="page" data-url="/m/lotto/lianma.php" tabindex="0" class="ui-page ui-page-theme-a ui-page-active">
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
		  <div data-role="fieldcontain" class="ui-field-contain">
			  <label for="rrtype">请选择玩法：</label>
			  <div class="ui-select">
				  <input type="hidden" name="rtype" id="rtype" value="1">
				  <select name="rrtype" id="rrtype" onChange="select_types(this)">
					  <option value="">请选择</option>
					  <option value="2">三全中(赔率:<?=$plArray[5]['rate'];?>)</option>
					  <option value="1">三中二(赔率:中二<?=$plArray[6]['rate'];?>,中三<?=$plArray[7]['rate'];?>)</option>
					  <option value="3">二全中(赔率:<?=$plArray[1]['rate'];?>)</option>
					  <option value="4">二中特(赔率:中特<?=$plArray[2]['rate'];?>,中二<?=$plArray[3]['rate'];?>)</option>
					  <option value="5">特串(赔率:<?=$plArray[4]['rate'];?>)</option>
					  <option value="6">四中一(赔率:<?=$plArray[8]['rate'];?>)</option>
				  </select>
			  </div>
		  </div>
		  <fieldset data-role="controlgroup" data-type="horizontal" class="ui-controlgroup ui-controlgroup-horizontal ui-corner-all">
			  <div class="ui-controlgroup-controls " id="normal_num">
			  <?php 
		for($i = 1;$i <= 49;$i++){
			$haoma = $i;
			if ($i < 10){
				$haoma = '0' . $i;
			}
		?> 					  
			  <div class="ui-checkbox">
					  <label for="num_<?=$i;?>" class="ui-btn ui-corner-all ui-btn-inherit ui-checkbox-off"><?=$haoma;?></label>
					  <input name="num_[]" flag="num_" id="num_<?=$i;?>" type="checkbox" value="<?=$i;?>" onClick="if($('#rrtype').val() != ''){SubChkBox(this,<?=$i;?>)}else{$(this).attr('checked',false);alert('请先选择玩法！');return false;}">
				  </div>
		<?php }?>
			  </div>
		  </fieldset>
		  <div data-role="fieldcontain" id="a2" style="DISPLAY:none;" data-type="horizontal" class="ui-field-contain">
			  <div class="ui-radio">
				  <label for="pabc1" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-on">正常</label>
				  <input id="pabc1" name="pabc" type="radio" onClick="select_types1(1);" value="1" checked="">
			  </div>
			  <div class="ui-radio">
				  <label for="pabc2" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-off">胆拖</label>
				  <input id="pabc2" name="pabc" type="radio" onClick="select_types1(2);" value="2">
			  </div>
			  <div class="ui-radio">
				  <label for="pabc3" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-off">生肖对碰</label>
				  <input id="pabc3" name="pabc" type="radio" onClick="select_types1(3);" value="3">
			  </div>
			  <div class="ui-radio">
				  <label for="pabc4" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-off">尾数对碰</label>
				  <input id="pabc4" name="pabc" type="radio" onClick="select_types1(4);" value="4">
			  </div>
			  <div class="ui-radio">
				  <label for="pabc5" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-off">肖串尾</label>
				  <input id="pabc5" name="pabc" type="radio" onClick="select_types1(5);" value="5">
			  </div>
		  </div>
		
		  <div data-role="fieldcontain" id="div_dt" style="DISPLAY:none;" class="ui-field-contain">
			  <label for="dm1">胆1</label>
			  <div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset">
				  <input type="text" name="dm1" id="dm1" size="4" onKeyUp="digitOnly(this);">
			  </div>
			  <label for="dm2" class="dm2class">胆2</label>
			  <div class="dm2class ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset">
				  <input type="text" name="dm2" id="dm2" size="4" onKeyUp="digitOnly(this);">
			  </div>
		  </div>
		  <div data-role="fieldcontain" id="a3" style="DISPLAY:none;" class="ui-field-contain">  				
			  <label for="pan1">第1肖：</label>
			  <div class="ui-select">
				  <select name="pan1" id="pan1" onChange="r_pan1($(this).val());">
					  <option value="">请选择</option>
					  <option value="<?=$sxArray[1]['m_number'];?>"><?=$sxArray[1]['sx'];?></option>
					  <option value="<?=$sxArray[7]['m_number'];?>"><?=$sxArray[7]['sx'];?></option>
					  <option value="<?=$sxArray[2]['m_number'];?>"><?=$sxArray[2]['sx'];?></option>
					  <option value="<?=$sxArray[8]['m_number'];?>"><?=$sxArray[8]['sx'];?></option>
					  <option value="<?=$sxArray[3]['m_number'];?>"><?=$sxArray[3]['sx'];?></option>
					  <option value="<?=$sxArray[9]['m_number'];?>"><?=$sxArray[9]['sx'];?></option>
					  <option value="<?=$sxArray[4]['m_number'];?>"><?=$sxArray[4]['sx'];?></option>
					  <option value="<?=$sxArray[10]['m_number'];?>"><?=$sxArray[10]['sx'];?></option>
					  <option value="<?=$sxArray[5]['m_number'];?>"><?=$sxArray[5]['sx'];?></option>
					  <option value="<?=$sxArray[11]['m_number'];?>"><?=$sxArray[11]['sx'];?></option>
					  <option value="<?=$sxArray[6]['m_number'];?>"><?=$sxArray[6]['sx'];?></option>
					  <option value="<?=$sxArray[12]['m_number'];?>"><?=$sxArray[12]['sx'];?></option>
				  </select>
			  </div>
			  <label for="pan2"  class="pan2class">第2肖：</label>
			  <div class="pan2class ui-select">
				  <select name="pan2" id="pan2" onChange="r_pan2($(this).val());">
					  <option value="">请选择</option>
					  <option value="<?=$sxArray[1]['m_number'];?>"><?=$sxArray[1]['sx'];?></option>
					  <option value="<?=$sxArray[7]['m_number'];?>"><?=$sxArray[7]['sx'];?></option>
					  <option value="<?=$sxArray[2]['m_number'];?>"><?=$sxArray[2]['sx'];?></option>
					  <option value="<?=$sxArray[8]['m_number'];?>"><?=$sxArray[8]['sx'];?></option>
					  <option value="<?=$sxArray[3]['m_number'];?>"><?=$sxArray[3]['sx'];?></option>
					  <option value="<?=$sxArray[9]['m_number'];?>"><?=$sxArray[9]['sx'];?></option>
					  <option value="<?=$sxArray[4]['m_number'];?>"><?=$sxArray[4]['sx'];?></option>
					  <option value="<?=$sxArray[10]['m_number'];?>"><?=$sxArray[10]['sx'];?></option>
					  <option value="<?=$sxArray[5]['m_number'];?>"><?=$sxArray[5]['sx'];?></option>
					  <option value="<?=$sxArray[11]['m_number'];?>"><?=$sxArray[11]['sx'];?></option>
					  <option value="<?=$sxArray[6]['m_number'];?>"><?=$sxArray[6]['sx'];?></option>
					  <option value="<?=$sxArray[12]['m_number'];?>"><?=$sxArray[12]['sx'];?></option>
				  </select>
			  </div>
		  </div>
		  <div data-role="fieldcontain" id="a4" style="DISPLAY:none;" class="ui-field-contain">
			  <label for="pan3">尾数1：</label>
			  <div class="ui-select">
				  <select name="pan3" id="pan3" onChange="r_pan3($(this).val());">
					  <option value="">请选择</option>
					  <option value="10,20,30,40">0尾</option>
					  <option value="1,11,21,31,41">1尾</option>
					  <option value="2,12,22,32,42">2尾</option>
					  <option value="3,13,23,33,43">3尾</option>
					  <option value="4,14,24,34,44">4尾</option>
					  <option value="5,15,25,35,45">5尾</option>
					  <option value="6,16,26,36,46">6尾</option>
					  <option value="7,17,27,37,47">7尾</option>
					  <option value="8,18,28,38,48">8尾</option>
					  <option value="9,19,29,39,49">9尾</option>
				  </select>
			  </div>
			  <label for="pan4" class="pan4class">尾数2：</label>
			  <div class="pan4class ui-select">
				  <select name="pan4" id="pan4" onChange="r_pan4($(this).val());">
					  <option value="">请选择</option>
					  <option value="10,20,30,40">0尾</option>
					  <option value="1,11,21,31,41">1尾</option>
					  <option value="2,12,22,32,42">2尾</option>
					  <option value="3,13,23,33,43">3尾</option>
					  <option value="4,14,24,34,44">4尾</option>
					  <option value="5,15,25,35,45">5尾</option>
					  <option value="6,16,26,36,46">6尾</option>
					  <option value="7,17,27,37,47">7尾</option>
					  <option value="8,18,28,38,48">8尾</option>
					  <option value="9,19,29,39,49">9尾</option>
				  </select>
			  </div>
		  </div>
		  <form name="lt_form" id="lt_form" method="post" action="lianma_post.php" data-role="none" data-ajax="false">
			  <div style="clear:both;margin:10px 0;">
			  下注金额：
			  <input type="text" name="money" id="money" onKeyUp="digitOnly(this);" maxlength="7" size="7" style="width:80px;" data-role="none">
			  </div>
			  <div style="clear:both;margin:10px 0;">
			  最低限额: <font color="#FF0000"><?=$cp_zd;?>元</font>
			  </div>
			  <div style="clear:both;margin:10px 0;">
			  最高限额: <font color="#FF0000"><?=$cp_zg;?>元</font>
			  </div>
			  <div style="clear:both;padding-top:10px;padding-left:10px;">
				  <span>
					  <font style="color:red;font-size:10pt;">注：点击对应的数字选中，选中后再次点击取消选中</font>
				  <span>
				  </span></span>
			  </div>
			  <div style="clear:both;text-align:center;">
				  <a href="javascript:resetForm();" class="ui-btn ui-btn-inline">重设</a>
				  <input type="hidden" name="class2" id="class2">
				  <input type="hidden" name="odds" id="odds">
				  <input type="hidden" name="betlist" id="betlist">
				  <button name="btnSubmit" onClick="return SubChk();" class="ui-btn ui-btn-inline">投注</button>
			  </div>
		  </form>
	  </section>
	  <!--底部开始--><?php include_once '../bottom.php';?>		  <!--底部结束-->
	  <!--我的资料--><?php include_once '../member/myinfo.php';?>	
	  <script type="text/javascript" src="../js/script.js"></script>
	  <script type="text/javascript">
		  function resetForm(){
			  $("#class2").val('');
			  $("#odds").val('');
			  $("#betlist").val('');
			  $("#rrtype").val('');
			  $("#rrtype").selectmenu('refresh');
			  select_types("#rrtype");
		  }
		  var type_nums = 10;//预设为 3中2
		  var type_min = 3;
		  var cb_num = 1;
		  var mess1 =  '最少选择';
		  var mess11 = '个数字';
		  var mess2 =  '最多选择10个数字';
		  var mess = mess2;
		  function select_types(obj) {
			  cb_num=1;
			  $("#div_dt").css("display" , "none");
			  var pabc_chk = -1;
			  type = $(obj).val();
			  if(type != ''){
				  $("#rtype").val(1);
				  type = parseInt(type);
				  for(i=1;i<50;i++) {
					  MM_changeProp('num_'+i,'','disabled','0','INPUT/CHECKBOX')
					  MM_changeProp('num_'+i,'','checked','0','INPUT/CHECKBOX');
				  }
				  if (type == 1 || type == 2 || type == 6) {
					  type_nums = 10;
					  type_min = 3;
					  if(type == 6){
						  type_min = 4;
					  }
					  $("#a2").css("display" , "");
					  $("#pan1").val('');
					  $("#pan2").val('');
					  $("#pan3").val('');
					  $("#pan4").val('');
					  $("#pan1").attr('disabled', true);
					  $("#pan2").attr('disabled', true);
					  $("#pan3").attr('disabled', true);
					  $("#pan4").attr('disabled', true);
					  $("#a3").css("display" , "none");
					  $("#a4").css("display" , "none");
					
					  MM_changeProp('pabc2','','disabled','0','INPUT/RADIO')
					  MM_changeProp('pabc3','','disabled','disabled','INPUT/RADIO')
					  MM_changeProp('pabc4','','disabled','disabled','INPUT/RADIO')
					  MM_changeProp('pabc5','','disabled','disabled','INPUT/RADIO')
					
				  } else {
					  $("#rtype").val(2);
					  type_nums = 10;
					  type_min = 2;
					  $("#a2").css("display" , "");
					  $("#a3").css("display" , "none");
					  $("#a4").css("display" , "none");
					  MM_changeProp('pabc3','','disabled','0','INPUT/RADIO')
					  MM_changeProp('pabc4','','disabled','0','INPUT/RADIO')
					  MM_changeProp('pabc5','','disabled','0','INPUT/RADIO')
					  $("#pan1").val('');
					  $("#pan2").val('');
					  $("#pan3").val('');
					  $("#pan4").val('');
					  $("#pan1").attr('disabled', true);
					  $("#pan2").attr('disabled', true);
					  $("#pan3").attr('disabled', true);
					  $("#pan4").attr('disabled', true);
					
				  }
				  pabc_chk = 1;
			  }else{
				  $("#a2").css("display" , "none");
				  $("#a3").css("display" , "none");
				  $("#a4").css("display" , "none");
				  for(i=1;i<50;i++) {
					  MM_changeProp('num_'+i,'','disabled','disabled','INPUT/CHECKBOX')
					  MM_changeProp('num_'+i,'','checked','0','INPUT/CHECKBOX');
				  }
			  }
			  for(i=1;i<6;i++) {
				  if (i==pabc_chk) {
					  MM_changeProp('pabc'+i,'','checked','1','INPUT/RADIO')
				  }else{
					  MM_changeProp('pabc'+i,'','checked','0','INPUT/RADIO')
				  }
			  }
			  for(i=1;i<5;i++){
				  var my_pan = $("#pan"+i);
				  my_pan[0].selectedIndex = 0;
				  my_pan.selectmenu('refresh');
			  }
			  $("input[flag=num_]").checkboxradio('refresh');
			  $("input[name=pabc]").checkboxradio('refresh');
			
			  switch (type){
				  case 2:
					  $('#class2').val('三全中');
					  $('#odds').val('<?=$plArray[5]['rate'];?>');
					  break;
				  case 1:
					  $('#class2').val('三中二');
					  $('#odds').val('中二<?=$plArray[6]['rate'];?>,中三<?=$plArray[7]['rate'];?>');
					  break;
				  case 3:
					  $('#class2').val('二全中');
					  $('#odds').val('<?=$plArray[1]['rate'];?>');
					  break;
				  case 4:
					  $('#class2').val('二中特');
					  $('#odds').val('中特<?=$plArray[2]['rate'];?>,中二<?=$plArray[3]['rate'];?>');
					  break;
				  case 5:
					  $('#class2').val('特串');
					  $('#odds').val('<?=$plArray[4]['rate'];?>');
					  break;
				  case 6:
					  $('#class2').val('四中一');
					  $('#odds').val('<?=$plArray[8]['rate'];?>');
					  break;
				  default :
					  break;
			  }
			  $('#betlist').val('');
		  }
		  function select_types1(type) {
			  cb_num=1;
			  s2="dm1";
			  document.all[s2].value ="" ;
			  s3="dm2";
			  document.all[s3].value ="";
			  for(i=1;i<5;i++){
				  var my_pan = $("#pan"+i);
				  my_pan[0].selectedIndex = 0;
				  my_pan.selectmenu('refresh');
			  }
			  if (type == 1 || type == 2) {
				  $("#a3").css("display" , "none");
				  $("#a4").css("display" , "none");
				  for(i=1;i<50;i++) {
					  MM_changeProp('num_'+i,'','disabled','0','INPUT/CHECKBOX')
					  MM_changeProp('num_'+i,'','checked','0','INPUT/CHECKBOX');
				  }
				  $("#pan1").attr('disabled', true);
				  $("#pan2").attr('disabled', true);
				  $("#pan3").attr('disabled', true);
				  $("#pan4").attr('disabled', true);
				
			  }
			  $('#dm1').val('');
			  $('#dm2').val('');
			  $("#div_dt").css("display" , (type == 2)?"":"none");
			  var rrtype = $("#rrtype").val();
			  if(type == 2 && (rrtype==3 || rrtype==4 || rrtype==5)){
				  $('.dm2class').css("display","none");
			  }
			  if (type == 3 ) {
				  $("#a3").css("display" , "");
				  $("#a4").css("display" , "none");
				  $(".pan2class").css("display" , "");
				  $(".pan4class").css("display" , "");
				  for(i=1;i<50;i++) {
					  MM_changeProp('num_'+i,'','disabled','disabled','INPUT/CHECKBOX')
					  MM_changeProp('num_'+i,'','checked','0','INPUT/CHECKBOX');
				  }
				  $("#pan1").attr('disabled', false);
				  $("#pan2").attr('disabled', false);
				  $("#pan3").attr('disabled', true);
				  $("#pan4").attr('disabled', true);
				
			  }
			  if (type == 4 ) {
				  $("#a3").css("display" , "none");
				  $("#a4").css("display" , "");
				  $(".pan2class").css("display" , "");
				  $(".pan4class").css("display" , "");
				  for(i=1;i<50;i++) {
					  MM_changeProp('num_'+i,'','disabled','disabled','INPUT/CHECKBOX')
					  MM_changeProp('num_'+i,'','checked','0','INPUT/CHECKBOX');
				  }
				  $("#pan1").attr('disabled', true);
				  $("#pan2").attr('disabled', true);
				  $("#pan3").attr('disabled', false);
				  $("#pan4").attr('disabled', false);
			  }
			  if (type == 5 ) {
				  $("#a3").css("display" , "");
				  $("#a4").css("display" , "");
				  $(".pan2class").css("display" , "none");
				  $(".pan4class").css("display" , "none");
				  for(i=1;i<50;i++) {
					  MM_changeProp('num_'+i,'','disabled','disabled','INPUT/CHECKBOX')
					  MM_changeProp('num_'+i,'','checked','0','INPUT/CHECKBOX');
				  }
				  $("#pan1").attr('disabled', false);
				  $("#pan2").attr('disabled', true);
				  $("#pan3").attr('disabled', false);
				  $("#pan4").attr('disabled', true);
				
			  }
			  $("input[flag=num_]").checkboxradio('refresh');
		  }
		  function r_pan1(zizi) {
			  var str1="pan1";
			  var str2="pan2";
			  if($("#"+str2).val() == zizi){
				  $("#"+str1).val('');
				  alert("对不起!请重新选择两个不一样的！");
				  $("#"+str1).focus();
				  return false;
			  }
		  }
		  function r_pan2(zizi){
			  var str1="pan2";
			  var str2="pan1";
			  if($("#"+str2).val() == zizi){
				  $("#"+str1).val('');
				  alert("对不起!请重新选择两个不一样的！");
				  $("#"+str1).focus();
				  return false;
			  }
		  }
		  function r_pan3(zizi){
			  var str1="pan3";
			  var str2="pan4";
			  if($("#"+str2).val() == zizi){
				  $("#"+str1).val('');
				  alert("对不起!请重新选择两个不一样的！");
				  $("#"+str1).focus();
				  return false;
			  }
		  }
		  function r_pan4(zizi){
			  var str1="pan4";
			  var str2="pan3";
			  if($("#"+str2).val() == zizi){
				  $("#"+str1).val('');
				  alert("对不起!请重新选择两个不一样的！");
				  $("#"+str1).focus();
				  return false;
			  }
		  }
		  //提交注单
		  function SubChk() {
			  //post注单
			  var betlist = "";
			  //登录后才能下注
			  var myuid = $("#uid").val();
			  if(myuid<=0 || myuid==''){
				  alert("请先登录，再下注");
				  return false;
			  }
			  //class2
			  var rrtype = $("#rrtype").val();
			  if (rrtype == "") {
				  alert('请先选择玩法');
				  return false;
			  }
			  //查看正常模式，是否选择
			  var intArray = new Array();　//创建一个数组
			  var checkCount = 0;
			  for(var i=1;i<50;i++) {
				  if ($("#num_"+i).is(':checked')==true && $("#num_"+i).is(':disabled')==false) {
					  checkCount ++;
					  intArray.push(i);
				  }
			  }
			  //数组排序、升序
			  intArray.sort(function (x, y) { return (x - y);});
			  //胆码1
			  var dm1 = true;
			  if ($("#dm1").val() ==""){
				  dm1 = false;
			  }
			  //胆码2
			  var dm2 = true;
			  if ($("#dm2").val() ==""){
				  dm2 = false;
			  }
			  //生肖1
			  var shengxiao1 = true;
			  if ($("#pan1").val() ==""){
				  shengxiao1 = false;
			  }
			  //生肖2
			  var shengxiao2 = true;
			  if ($("#pan2").val() ==""){
				  shengxiao2 = false;
			  }
			  //尾数1
			  var weishu1 = true;
			  if ($("#pan3").val() ==""){
				  weishu1 = false;
			  }
			  //尾数2
			  var weishu2 = true;
			  if ($("#pan4").val() ==""){
				  weishu2 = false;
			  }  				
			  //注单数
			  var betnumber = 0;
			  //类型
			  var pabctype = $('input[name=pabc]:checked').val();
			  if (pabctype == 1) {
				  if (checkCount==0){
					  alert('请选择号码');
					  return false;
				  }else if(checkCount<type_min){
					  alert('最少选择'+type_min+"个号码");
					  return false;
				  }else if(checkCount>type_nums){
					  alert('最多选择'+type_nums+"个号码");
					  return false;
				  }else{
					  var m = checkCount;
					  var n = 1;
					  if(rrtype==1 || rrtype==2){
						  n = 3;
					  }else if(rrtype==3 || rrtype==4 || rrtype==5){
						  n = 2;
					  }else if(rrtype==6){
						  n = 4;
					  }else{
						  alert("类型有误");
						  return false;
					  }
					  //正常选择，的注单数
					  betnumber=GetNumForCmn(m,n);
					  betlist = ClearFirstLastCharacter(GetCmn(intArray, type_min, 1, 0, ""));
				  }
			  }else if (pabctype == 2) {
				  var dmArray = new Array();
				  if(rrtype==1 || rrtype==2 || rrtype==6){
					  if (dm1==false || dm2==false || $("#dm1").val()<1 || $("#dm1").val()>49 || $("#dm2").val()<1 || $("#dm2").val()>49){
						  alert('请输入胆码');
						  return false;
					  }else{
						  dmArray.push($("#dm1").val());
						  dmArray.push($("#dm2").val());
					  }
				  }else if(rrtype==3 || rrtype==4 || rrtype==5 || $("#dm1").val()<1 || $("#dm1").val()>49){
					  if (dm1==false){
						  alert('请输入胆码');
						  return false;
					  }else{
						  dmArray.push($("#dm1").val());
					  }
				  }else{
					  alert("类型有误");
					  return false;
				  }
				  if ($("#rrtype").val()!=6 && checkCount<1){
					  alert('请选择至少1个号码');
					  return false;
				  }else if($("#rrtype").val()==6 && checkCount<2){
					  alert('请选择至少2个号码');
					  return false;
				  }
				  //构建注单
				  if($("#rrtype").val()!=6){
					  for(var i = 0;i<intArray.length;i++){
						  dmArray.push(intArray[i]);
						  //数组排序、升序
						  dmArray.sort(function (x, y) { return (x - y);});
						  var tempdmstr = "";
						  for(var j =0;j<dmArray.length;j++){
							  tempdmstr = tempdmstr + dmArray[j] +",";
						  }
						  betlist = betlist + ClearFirstLastCharacter(tempdmstr)+"|";
						  removeByValue(dmArray,intArray[i]);
					  }
					  betlist = ClearFirstLastCharacter(betlist);
				  }else{
					  var tempbetlist = ClearFirstLastCharacter(GetCmn(intArray, 2, 1, 0, ""));
					  var tempbetArray = tempbetlist.split("|");
					  for(var i = 0;i<tempbetArray.length;i++){
						  var tempbetArraySub = tempbetArray[i].split(",");
						  dmArray.push(tempbetArraySub[0]);
						  dmArray.push(tempbetArraySub[1]);
						  //数组排序、升序
						  dmArray.sort(function (x, y) { return (x - y);});
						  var tempdmstr = "";
						  for(var j =0;j<dmArray.length;j++){
							  tempdmstr = tempdmstr + dmArray[j] +",";
						  }
						  betlist = betlist + ClearFirstLastCharacter(tempdmstr)+"|";
						  removeByValue(dmArray,tempbetArraySub[0]);
						  removeByValue(dmArray,tempbetArraySub[1]);
					  }
					  betlist = ClearFirstLastCharacter(betlist);
				  }
			  }else if (pabctype == 3) {
				  if (shengxiao1==false || shengxiao2==false){
					  alert('请选择生肖');
					  return false;
				  }else{
					  var sx1 = $("#pan1").val();
					  var sx2 = $("#pan2").val();
					  var sx1Array = sx1.split(",");
					  var sx2Array = sx2.split(",");
					  for(var i=0;i<sx1Array.length;i++){
						  for(var j=0;j<sx2Array.length;j++){
							  if(sx1Array[i]<sx2Array[j]){
								  betlist = betlist + sx1Array[i]*1 + "," + sx2Array[j]*1 + "|";
							  }else{
								  betlist = betlist + sx2Array[j]*1 + "," + sx1Array[i]*1 + "|";
							  }
						  }
					  }
					  betlist = ClearFirstLastCharacter(betlist);
				  }
			  }else if (pabctype == 4) {
				  if (weishu1==false || weishu2==false){
					  alert('请选择尾数');
					  return false;
				  }else{
					  var ws1 = $("#pan3").val();
					  var ws2 = $("#pan4").val();
					  var ws1Array = ws1.split(",");
					  var ws2Array = ws2.split(",");
					  for(var i=0;i<ws1Array.length;i++){
						  for(var j=0;j<ws2Array.length;j++){
							  if(ws1Array[i]<ws2Array[j]){
								  betlist = betlist + ws1Array[i] + "," + ws2Array[j] + "|";
							  }else{
								  betlist = betlist + ws2Array[j] + "," + ws1Array[i] + "|";
							  }
						  }
					  }
					  betlist = ClearFirstLastCharacter(betlist);
				  }
			  }else if (pabctype == 5) {
				  if (shengxiao1==false || weishu1==false){
					  alert('请选择生肖、尾数');
					  return false;
				  }else{
					  var sx1 = $("#pan1").val();
					  var ws1 = $("#pan3").val();
					  var sx1Array = sx1.split(",");
					  var ws1Array = ws1.split(",");
					  for(var i=0;i<sx1Array.length;i++){
						  for(var j=0;j<ws1Array.length;j++){
							  if(sx1Array[i]<ws1Array[j]){
								  betlist = betlist + sx1Array[i]*1 + "," + ws1Array[j] + "|";
							  }else if(sx1Array[i]>ws1Array[j]){
								  betlist = betlist + ws1Array[j] + "," + sx1Array[i]*1 + "|";
							  }else{
								  continue;
							  }
						  }
					  }
					  betlist = ClearFirstLastCharacter(betlist);
				  }
			  }else{
				  alert('无效玩法');
				  return false;
			  }
			
			  $("#betlist").val(betlist);
			  //金额
			  var gold_val = $("#money").val();
			  var mix =<?=$cp_zd;?>;
			  var max =<?=$cp_zg;?>;
			  if(gold_val == ''){
				  $("#money").focus();
				  alert("请输入下注金额!!");
				  return false;
			  }
			  if (gold_val < mix) {
				  $("#money").focus();
				  alert("注金额不可小於最低下注金额:"+mix);
				  return false;
			  }
			  if (gold_val > max) {
				  $("#money").focus();
				  alert("注金额不可小於最高下注金额:"+max);
				  return false;
			  }
			  if(gold_val*betnumber><?=$userinfo['money']<=0 ? 0 : $userinfo['money'];?>){
				  alert("下注总金额:"+(gold_val*betnumber)+"￥,大于可用额度：<?=$userinfo['money']<=0 ? 0 : $userinfo['money'];?>￥");
				  return false;
			  }
			
			  document.lt_form.submit();
		  }
		
		  //组合数
		  function GetNumForCmn(m,n){
			  if(m<n)
				  return 1;
			  var fenzi = 1;
			  var fenmu =1;
			  var count = n ;
			  while(count>0){
				  fenzi = fenzi * m;
				  m--;
				  count--;
			  }
			  var count = n ;
			  while(count>0){
				  fenmu = fenmu * n;
				  n --;
				  count--;
			  }
			  return fenzi/fenmu;
		  }
		
		  //获取组合 Cmn
		  function GetCmn(intArray, the_n, into_step, startpoint, head) {
			  var thestr = "";
			  if (into_step < the_n) {
				  for (var r = startpoint;r < intArray.length;r++) {
					  if (head.length <= 0) {
						  thestr = thestr + GetCmn(intArray, the_n, into_step + 1, r + 1, intArray[r]);
					  }
					  else {
						  thestr = thestr + GetCmn(intArray, the_n, into_step + 1, r + 1, head + "," + intArray[r]);
					  }
				  }
			  }
			  else {
				  for (var r = startpoint;r < intArray.length;r++) {
					  var str = head + "," + intArray[r];
					  thestr = thestr + str + "|";
				  }
			  }
			  return thestr;
		  }
		
		  //去除首位分隔符或者比如：   【,】  【_】   【|】   【;】
		  function ClearFirstLastCharacter(mystr){
			  var start = 0;
			  for (var i = 0;i < mystr.length;i++) {
				  if (mystr[i] == ',' || mystr[i] == '_' || mystr[i] == '|' || mystr[i] == ';') {
					  start++;
				  } else {
					  break;
				  }
			  }
			  var end = mystr.length;
			  for (var i = mystr.length-1;i >=0;i--) {
				  if (mystr[i] == ',' || mystr[i] == '_' || mystr[i] == '|' || mystr[i] == ';') {
					  end--;
				  } else {
					  break;
				  }
			  }
			  return mystr.substring(start, end);
		  }
		
		  //删除数组特定值的元素
		  function removeByValue(arr, val) {
			  for(var i=0;i<arr.length;i++) {
				  if(arr[i] == val) {
					  arr.splice(i, 1);
					  break;
				  }
			  }
		  }
		  function SubChkBox(obj,bmbm) {
			
			  if(obj.checked == false){
				  cb_num--;
			  }
			  if(obj.checked == true){
				  if ( cb_num > type_nums ){
					  alert(mess);
					  cb_num--;
					  obj.checked = false;
				  }
				  cb_num++;
			  }
			  var str1="pabc";
			  var str2="rtype";
			  var str3="dm1";
			  var str4="dm2";
			  if($('input[name='+str1+']:checked').val() ==2){
				  if($("#"+str2).val() == 1){
					  if ($("#"+str3).val() == ""){
						  MM_changeProp('num_'+bmbm,'','disabled','disabled','INPUT/CHECKBOX')
						  $("#"+str3).val(bmbm);
						  MM_changeProp('dm1','','disabled','0','INPUT/text')
					  }else{
						  if ($("#"+str4).val() == ""){
							  MM_changeProp('num_'+bmbm,'','disabled','disabled','INPUT/CHECKBOX')
							  MM_changeProp('dm2','','disabled','0','INPUT/text')
							  $("#"+str4).val(bmbm);
						  }
					  }
				  }else{
					  if ($("#"+str3).val() == ""){
						  MM_changeProp('num_'+bmbm,'','disabled','disabled','INPUT/CHECKBOX')
						  MM_changeProp('dm1','','disabled','0','INPUT/text')
						  $("#"+str3).val(bmbm);
					  }
				  }
			  }
		  }
		  function MM_findObj(n, d) { //v4.01
			  var p,i,x;
			  if(!d) d=document;
			  if((p=n.indexOf("?"))>0&&parent.frames.length) {
				  d=parent.frames[n.substring(p+1)].document;n=n.substring(0,p);
			  }
			  if(!(x=d[n])&&d.all) x=d.all[n];
			  for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
			  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
			  if(!x && d.getElementById) x=d.getElementById(n);return x;
		  }
		  function MM_changeProp(objName,x,theProp,theValue) { //v6.0
			  var obj = MM_findObj(objName);
			  if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
				  if (theValue == true || theValue == false)
				  eval("obj."+theProp+"="+theValue);
				  else eval("obj."+theProp+"='"+theValue+"'");
			  }
		  }
	  </SCRIPT>
  </div>
  <div class="ui-loader ui-corner-all ui-body-a ui-loader-default">
	  <span class="ui-icon-loading"></span>
	  <h1>loading</h1>
  </div>
</body>
</html>