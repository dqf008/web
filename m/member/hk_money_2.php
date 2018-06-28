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
include_once '../../cache/bank2.php';
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
		echo "<script>alert('您有未处理的订单，请联系客服处理，再继续提交！');window.location.href='setmoney.php'</script>";
		exit();
	}
	$params = array(':uid' => $uid);
	$sql = 'select money from k_user where uid=:uid limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rows = $stmt->fetch();
	$assets = sprintf('%.2f', $rows['money']);
	$paymoney = $_POST['paymoney'];
	$money = sprintf('%.2f', floatval($_POST['paymoney']));
	if (!isset($_POST['IntoBank'])){
		echo "<script>alert('您没有选择汇款的支付方式！');window.location.href='setmoney.php'</script>";
		exit();
	}
	$infoBank = explode(':', $_POST['IntoBank']);
	if (count($infoBank) != 2){
		echo "<script>alert('您没有选择正确的支付方式！');window.location.href='setmoney.php'</script>";
		exit();
	}
	$bank = $infoBank[0];
	$payname = htmlEncode($_POST['payname']);
	if ($money < $web_site['ck_limit']){
		message('转账金额最低为：' . $web_site['ck_limit'] . '元');
		exit();
	}
	$manner = '支付方式: ' . htmlEncode($bank) . '<br/>支付账号： ' . htmlEncode($infoBank[1]) . '<br/>会员支付昵称:' . $payname;
	$params = array(':money' => $money, ':bank' => $bank, ':date' => date('YmdHis'), ':manner' => $manner, ':address' => '', ':uid' => $uid, ':lsh' => $_SESSION['username'] . '_' . date('YmdHis'), ':assets' => $assets, ':balance' => $assets);
	$sql = 'Insert Into `huikuan` (money,bank,date,manner,address,adddate,status,uid,lsh,assets,balance) values (:money,:bank,:date,:manner,:address,now(),0,:uid,:lsh,:assets,:balance)';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1 == 1){
		$msg = '恭喜您，充值信息提交成功。\\n我们将尽快审核，谢谢您对' . $web_site['reg_msg_from'] . '的支持。';
		echo "<script>alert('".$msg."');window.location.href='setmoney.php'</script>";
		exit();
	}else{
	 	echo "<script>alert('对不起，由于网络堵塞原因。\r\n您提交的汇款信息失败，请您重新提交。');window.location.href='setmoney.php'</script>";
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
					  <label>一、请用支付账号或者微信账号进行转账汇款</label> 
				  </li>
				  <?php foreach ($bank[$_SESSION['gid']] as $k => $arr){?> 					  
				  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
					  <label>微信或者支付宝</label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>账号名称：<span class="lan"><?=$arr['card_bankName'];?></span></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>支付账号：<span class="lan"><?=$arr['card_ID'];?></span></label> 
				  </li>
				  <li class="ui-li-static ui-body-inherit"> 
					  <label><img src="../../newindex/<?=$arr['card_img'];?>" style="max-width:100%" /></label> 
				  </li>
				  <?php }?> 					  
				  <div style="padding-left:10px;" class="helpful_hints"> 
					  <span style="color:red;">温馨提示：</span><br> 
					  <span style="color:black;">一、在金额转出之后请务必填写该页下方的汇款信息表格，以便财务系统能够及时的为您确认并添加金额到您的会员帐户中。</span> 
					  <br> 
					  <span style="color:black;">二、本公司<span style="color:blue;">最低存款金额为<?=$web_site['ck_limit'];?>元</span>，公司财务系统将对银行存款的会员按实际存款金额实行返利派送。 
					  <br> 
					  <span style="color:black;">三、支付方式为公司的支付宝账号或者微信账号.</span> 
					  <br/> 
					  <span style="color:black;">四、充值成功后请及时与客服联系加款.</span> 
					  <br/> 
					  <span style="color:black;">五、用户昵称请填写自己的支付宝昵称或者微信昵称,方便客服审核.</span> 
					  <br/> 
				  </div> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>二、填写汇款单</label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>用户账号：<span style="margin-left: 5px;"><?=$_SESSION['username'];?></span></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>存款方式：
					  <select id="IntoBank" name="IntoBank" data-role="none" style="margin-left: 5px;"> 
						  <option selected="selected" value="">请选择</option>
						  <?php 
						  foreach ($bank[$_SESSION['gid']] as $k => $arr){
						  ?>                        	  
						  <option value="<?=$arr['card_bankName'];?>:<?=$arr['card_ID'];?>"><?=$arr['card_bankName'];?>:<?=$arr['card_ID'];?></option>
						  <?php }?>                     
					  </select>
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>存款金额： 
						  <input name="paymoney" type="text" class="input_150" data-role="none" id="v_amount" onKeyUp="clearNoNum(this);" size="15" maxlength="10"> 
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>支付宝/微信昵称： 
						  <input name="payname" id="v_Name" data-role="none" onFocus="javascript:this.select();" size="15" maxlength="15" type="text"> 
					  </label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <button name="btnSubmit" class="ui-btn ui-btn-inline" data-role="none" data-ajax="false" value="提交信息" onClick="return SubInfo();">提交信息</button> 
				  </li> 
				  </ul> 
			  </div> 
		  </form> 
  </section> 
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once 'myinfo.php';?>	
  <script type="text/javascript"> 
  function Trim(str)  {  return str.replace(/(^\s*)|(\s*$)/g, "");} 
  var _$ = function(id){ 
	  return document.getElementById(id);
  } 

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
   
  function SubInfo(){ 
	  //对存款金额进行校验 
	  var hk = _$('v_amount').value;
	  if(hk==''){ 
		  alert('请输入转账金额');
		  _$('v_amount').focus();
		  return false;
	  }else{ 
		  hk = hk*1;
		  if(hk<<?=$web_site['ck_limit'];?>){ 
			  alert('转账金额最低为:'+<?=$web_site['ck_limit'];?> + '元');
			  _$('v_amount').select();
			  return false;
		  } 
	  } 

	  //对存款方式进行校验 
	  var depositWay = $("#IntoBank").val();
	  if (Trim(depositWay) == '' || depositWay == null) { 
		  alert("请选择存款方式!");
		  return false;
	  } 

	  //对用户微信账号或者支付宝账号的昵称校验 
	  if(Trim(_$('v_Name').value)=='' || _$('v_Name').value == null){ 
		  alert('请输入微信昵称');
		  _$('v_Name').value='';
		  _$('v_Name').focus();
		  return false;
	  } 
	  _$('form1').submit();
  } 
  //是否是中文 
  function isChinese(str){ 
	  return /[\u4E00-\u9FA0]/.test(str);
  } 
	  </script> 
</body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>