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
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
if ($_GET['into'] == 'true'){
	$params = array(':uid' => $uid);
	$sql = 'select count(1) as num from huikuan where status=0 and  uid=:uid and adddate>=date_add(now(),interval  -1 day)';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rows = $stmt->fetch();
	if (0 < $rows['num']){
		echo "<script>alert('您有未处理的订单，请联系客服处理，再继续提交！');window.location.href='hk_money.php'</script>";
		exit();
	}
	$params = array(':uid' => $uid);
	$sql = 'select money from k_user where uid=:uid limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rows = $stmt->fetch();
	$assets = sprintf('%.2f', $rows['money']);
	$money = sprintf('%.2f', floatval($_POST['v_amount']));
	$bank = str_replace('***', '<br/>', htmlEncode($_POST['IntoBank']));
	$date = htmlEncode($_POST['cn_date']);
	$date1 = $date . ' ' . $_POST['s_h'] . ':' . $_POST['s_i'] . ':' . $_POST['s_s'];
	$manner = htmlEncode($_POST['InType']);
	$address = htmlEncode($_POST['v_site']);
	if ($money < $web_site['ck_limit']){
		message('转账金额最低为：' . $web_site['ck_limit'] . '元');
		exit();
	}
	
	if ($manner == '网银转账'){
		$manner .= '<br />持卡人姓名：' . htmlEncode($_POST['v_Name']);
	}
	
	if ($manner == '0'){
		$manner = htmlEncode($_POST['IntoType']);
	}
	$params = array(':money' => $money, ':bank' => $bank, ':date' => $date1, ':manner' => $manner, ':address' => $address, ':uid' => $uid, ':lsh' => $_SESSION['username'] . '_' . date('YmdHis'), ':assets' => $assets, ':balance' => $assets);
	$sql = 'Insert Into `huikuan`  (money,bank,date,manner,address,adddate,status,uid,lsh,assets,balance) values  (:money,:bank,:date,:manner,:address,now(),0,:uid,:lsh,:assets,:balance)';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1 == 1){
		message('恭喜您，汇款信息提交成功。\\n我们将尽快审核，谢谢您对' . $web_site['reg_msg_from'] . '的支持。', 'orders.php?p_type=h');
	}else{
		message('对不起，由于网络堵塞原因。\\n您提交的汇款信息失败，请您重新提交。');
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
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-url="/m/member/hk_money.php" tabindex="0" style="min-height: 659px;"> 
  <!--头部开始--> 
  <header id="header"> 
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
		  <span>汇款提交</span> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 


  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <form id="form1" name="form1" action="?into=true" method="post" data-role="none" data-ajax="false"> 
		  <div data-role="cotent"> 
			  <ul data-role="listview" class="ui-listview"> 
				  <li class="ui-li-static ui-body-inherit ui-first-child"> 
					  <label>一、请选择以下公司账号进行转账汇款</label> 
				  </li>
				  <?php 
				    include_once '../../cache/bank.php';
					$banknum = 0;
					foreach ($bank[$_SESSION['gid']] as $k => $arr){
						$banknum++;
				  ?>					  
				  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
					  <label><?=$arr['card_bankName'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>卡号：<span class="lan"><?=$arr['card_ID'];?></span></label> 
				  </li> 
				
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>开户名：<span class="lan"><?=$arr['card_userName'];?></span></label> 
				  </li> 
				
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>开户行所在城市：<span class="lan"><?=$arr['card_address'];?></span></label> 
				  </li>
				  <?php }?> 					  
				  <div style="padding-left:10px;" class="helpful_hints"> 
					  <span style="color:red;">温馨提示：</span><br> 
					  <span style="color:black;">一、在金额转出之后请务必填写该页下方的汇款信息表格，以便财务系统能够及时的为您确认并添加金额到您的会员帐户中。</span> 
					  <br> 
					  <span style="color:black;">二、本公司<span style="color:blue;">最低存款金额为<?=$web_site['ck_limit'];?>元</span>，公司财务系统将对银行存款的会员按实际存款金额实行返利派送。 
					  <br> 
					  <span style="color:black;">三、跨行转帐请您使用跨行快汇。</span> 
				  </div> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>二、填写汇款单</label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>用户账号：<?=$_SESSION['username'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>存款金额： 
						  <input name="v_amount" type="text" class="input_150" data-role="none" id="v_amount" onKeyUp="clearNoNum(this);" size="15" maxlength="10"> 
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>汇款银行： 
						  <select id="IntoBank" name="IntoBank" data-role="none"> 
							  <option value="" selected="selected">==请选择汇款银行==</option>
							  <?php foreach ($bank[$_SESSION['gid']] as $k => $arr){?> 						  
							  <option value="<?=$arr['card_bankName'] ;?>***<?=$arr['card_ID'];?>"><?=$arr['card_bankName'];?></option>
							  <?php }?> 							  
						  </select> 
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>汇款日期： 
						  <select name="cn_date" id="cn_date" data-role="none">
						  <?php 
							for ($bh_d = 0;$bh_d < 60;$bh_d++){
								$b_d_value = date('Y-m-d', strtotime('-' . $bh_d . ' day'));
						  ?>								  
						    <option value="<?=$b_d_value;?>" <?=$cn_date==$b_d_value ? 'selected' : '' ;?>><?=$b_d_value;?></option>
						  <?php }?> 							  
						  </select> 
						  
						  <select name="s_h" id="s_h" data-role="none">
						  <?php 
							for ($bh_i = 0;$bh_i < 24;$bh_i++){
								$b_h_value = ($bh_i < 10 ? '0' . $bh_i : $bh_i);
						  ?>								  
						  	<option value="<?=$b_h_value;?>" <?=$s_h==$b_h_value ? 'selected' : '';?>><?=$b_h_value;?></option>
						  <?php }?> 							  
						  </select> 
						  
						  <select name="s_i" id="s_i" data-role="none">
						  <?php 
							for ($bh_j = 0;$bh_j < 60;$bh_j++){
								$b_i_value = ($bh_j < 10 ? '0' . $bh_j : $bh_j);
						  ?>								 
						  	<option value="<?=$b_i_value;?>" <?=$s_i==$b_i_value ? 'selected' : '';?>><?=$b_i_value;?></option>
						  <?php }?> 
						  							  
						  </select> 
						  <select name="s_s" id="s_s" data-role="none">
						  <?php 
							for ($bh_j = 0;$bh_j < 60;$bh_j++){
								$b_s_value = ($bh_j < 10 ? '0' . $bh_j : $bh_j);
						  ?>								  
						  	<option value="<?=$b_s_value;?>" <?=$s_s==$b_s_value ? 'selected' : '';?>><?=$b_s_value;?></option>
						  <?php }?> 							  
						  </select> 
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>汇款方式： 
						  <select id="InType" name="InType" onChange="showType();"  data-role="none" style="margin-bottom:5px;"> 
							  <option value="">==请选择方式==</option> 
							  <option value="银行柜台">银行柜台</option> 
							  <option value="ATM现金">ATM现金</option> 
							  <option value="ATM卡转">ATM卡转</option> 
							  <option value="网银转账">网银转账</option> 
							  <option value="支付宝转账">支付宝转账</option> 
							  <option value="微信转账">微信转账</option> 
							  <option value="0">其它[手动输入]</option> 
						  </select> 
						  <input id="v_type" name="v_type" type="text" size="10" value="请输入" onFocus="javascript:$('#v_type').select();" class="font-hhblack" maxlength="20" style="border:1px solid #CCCCCC;height:18px;line-height:20px;font-size:12px;display:none;"  data-role="none" /> 
						  <input type="hidden" id="IntoType" name="IntoType" value=""  data-role="none" /> 
					  </label> 
				  </li> 
				  <li id="tr_v" style="display:none;" class="ui-li-static ui-body-inherit"> 
					  <label>汇款人名： 
						  <input name="v_Name" type="text" class="input_250" id="v_Name" data-role="none" size="20" maxlength="50"  onfocus="javascript:this.select();"/> 
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <div style="position:relative;padding-bottom:5px;height:30px;"> 
						  <span style=" font-family:'微软雅黑'!important;font-size:16px!important;">汇款地点：</span> 
						  <div style="position:absolute;top:0px;left:80px;"> 
							  <input name="v_site" type="text" class="input_250" id="v_site" data-role="none" size="20" maxlength="50"/> 
							  <br> 
							  <span>注：微信 支付宝转账请在此填写姓名</span> 
						  </div> 
						  <div></div> 
					  </div> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit ui-last-child"> 
					  <button name="btnSubmit" class="ui-btn ui-btn-inline" data-role="none" data-ajax="false" value="提交信息" onClick="return SubInfo();">提交信息</button> 
				  </li> 
				  </ul> 
			  </div> 
		  </form> 
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
			  if(!re.test(obj.value)) 
			  { 
				  obj.value = obj.value.substring(0,obj.value.length-1);
				  return false;
			  } 
		  } 
	  } 

	  function showType(){ 
		  if($('#InType').val()=='0'){ 
			  //$('#v_type').style.display='';
			  //$('#tr_v').style.display='none';
			  $('#v_type').css("display","");
			  $('#tr_v').css("display","none");
		  }else if($('#InType').val()=='网银转账'){ 
			  //$('#tr_v').style.display='';
			  //$('#v_type').style.display='none';
			  $('#tr_v').css("display","");
			  $('#v_type').css("display","none");
			  $("#IntoType").val($("#InType").val());
		  }else{ 
			  //$('#v_type').style.display='none';
			  $('#v_type').css("display","none");
			  $("#IntoType").val($("#InType").val());
			  //$('#tr_v').style.display='none';
			  $('#tr_v').css("display","none");
		  } 
	  } 

	  function SubInfo(){ 
		  var hk = $('#v_amount').val();
		  if(hk==''){ 
			  alert('请输入转账金额');
			  $('#v_amount').focus();
			  return false;
		  }else{ 
			  hk = hk*1;
			  if(hk<<?=$web_site['ck_limit'];?>){ 
				  alert('转账金额最低为：<?=$web_site['ck_limit'];?>元');
				  $('#v_amount').select();
				  return false;
			  } 
		  } 
		  if($('#IntoBank').val()==''){ 
			  alert('为了更快确认您的转账，请选择汇款银行');
			  $('#IntoBank').focus();
			  return false;
		  } 
		  if($('#cn_date').val()==''){ 
			  alert('请选择汇款日期');
			  $('#cn_date').focus();
			  return false;
		  } 

		  if($('#InType').val()==''){ 
			  alert('为了更快确认您的转账，请选择汇款方式');
			  $('#InType').focus();
			  return false;
		  } 
		  if($('#InType').val()=='0'){ 
			  if($('#v_type').val()!=''&& $('#v_type').val()!='请输入其它汇款方式'){ 
				  $("#IntoType").val($("#v_type").val());
			  }else{ 
				  alert('请输入其它汇款方式');
				  $('#v_type').focus();
				  return false;
			  } 
		  } 
		  if($('#InType').val()=='网银转账'){ 
			  if($('#v_Name').val()!=''&& $('#v_Name').val()!='请输入持卡人姓名' && $('#v_Name').val().length>1 && $('#v_Name').val().length<20){ 
				  var tName =$('#v_Name').val();
				  var yy = tName.length;
				  for(var xx=0;xx<yy;xx++){ 
					  var zz = tName.substring(xx,xx+1);
					  if(zz!='·'){ 
						  if(!isChinese(zz)){ 
							  alert('请输入中文持卡人姓名，如有其他疑问，请联系在线客服');
							  $('#v_Name').focus();
							  return false;
						  } 
					  } 
				  } 
			  }else{ 
				  alert('为了更快确认您的转账，网银转账请输入持卡人姓名');
				  $('#v_Name').focus();
				  return false;
			  } 
		  } 
		  if($('#v_site').val()=='' || $('#v_site').val()== null){ 
			  alert('请填写汇款地点');
			  $('#v_site').focus();
			  return false;
		  } 
		  if($('#v_site').val().length>50){ 
			  alert('汇款地点不要超过50个中文字符');
			  $('#v_site').focus();
			  return false;
		  } 
		  $('#form1').submit();
	  } 
	  //是否是中文 
	  function isChinese(str){ 
		  return /[\u4E00-\u9FA0]/.test(str);
	  } 
	  </script> 
</body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>