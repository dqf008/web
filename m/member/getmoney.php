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
if ($userinfo['pay_card'] == ''){
	message('请先绑定银行账号信息', 'setcard.php');
	exit();
}

$tk_num = 0;
if(file_exists('../../cache/group_'.$userinfo['gid'].'.php')){
	include_once '../../cache/group_'.$userinfo['gid'].'.php';
	$tk_num = (int)$pk_db['提款次数'];
}

if ($_POST['action'] == 'tikuan'){
	if($tk_num !==  0){
		if(time()<strtotime(date('Y-m-d 12:00:00'))){
			$date = date('Y-m-d 12:00:00',strtotime('-1 day'));
		}else{
			$date = date('Y-m-d 12:00:00');
		}
		$date = date('Y-m-d');
		$sql = 'select count(1) from k_money where uid='.$userinfo['uid'].' and `type`=2 and m_make_time>="'.$date .'" and status=1 ';
		$query = $mydata1_db->query($sql); 
		$now_tk = $query->fetch()[0];
		if($now_tk >= $tk_num){
			message('今日提款次数已经用完，请明日再申请提款');
			exit();
		}
	}
	if (time() - intval($_SESSION['last_get_money']) <= 30){
		message('为了方便及时给您出款，30秒之内请勿多次提交提款请求');
		exit();
	}
	
	if (md5($_POST['qk_pwd']) != $userinfo['qk_pwd']){
		message('提款密码错误，请重新输入');
		exit();
	}
	
	$pay_value = (int)$_POST['pay_value'];
	if (($pay_value < 0) || ($userinfo['money'] < $pay_value)){
		message('提款金额错误，请重新输入');
		exit();
	}
	
	if ($pay_value < $web_site['qk_limit']){
		message('提款金额不能低于[' . $web_site['qk_limit'] . ']元');
		exit();
	}
	
	$currtime = time() + (1 * 12 * 3600);
	$c_time = date('Y-m-d H:i', $currtime);
	$qk_time_begin = date('Y-m-d', $currtime) . ' ' . $web_site['qk_time_begin'];
	$qk_time_end = date('Y-m-d', $currtime) . ' ' . $web_site['qk_time_end'];
	if ((strtotime($c_time) < strtotime($qk_time_begin)) || (strtotime($qk_time_end) < strtotime($c_time))){
		message('很抱歉，不在提款时间段，暂时不能提款');
		exit();
	}
	$params = array(':uid' => $uid);
	$sql = 'select count(1) as num from k_money where type =2 and status=2 and uid=:uid and m_make_time>=date_add(now(),interval  -1 day)';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rows = $stmt->fetch();
	if (0 < $rows['num']){
		echo "<script>alert('您有未处理的提款订单，请联系客服处理，再继续提交！');window.location.href='getmoney.php'</script>";
		exit();
	}
	
	$params = array(':pay_value' => $pay_value, ':uid' => $uid, ':cur_money' => $pay_value);
	$sql = 'update k_user set money=money-:pay_value where uid=:uid and money>=:cur_money';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1 <= 0){
		message('系统扣款失败，提款无法正常进行');
		exit();
	}
	$_SESSION['last_get_money'] = time();
	$pay_value = -$pay_value;
	$order = $_SESSION['username'] . '_' . date('YmdHis');
	$params = array(':uid' => $uid, ':m_value' => $pay_value, ':m_order' => $order, ':pay_card' => $userinfo['pay_card'], ':pay_num' => $userinfo['pay_num'], ':pay_address' => $userinfo['pay_address'], ':pay_name' => $userinfo['pay_name'], ':assets' => $userinfo['money'], ':balance' => $userinfo['money'] + $pay_value);
	$sql = 'insert into k_money (uid,m_value,status,m_order,pay_card,pay_num,pay_address,pay_name,about,assets,balance,type) values (:uid,:m_value,2,:m_order,:pay_card,:pay_num,:pay_address,:pay_name,\'\',:assets,:balance,2)';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$m_id = $mydata1_db->lastInsertId();
	$creationTime = date('Y-m-d H:i:s');
	$params = array(':creationTime' => $creationTime, ':m_id' => $m_id);
	$stmt = $mydata1_db->prepare('INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) 
	SELECT k_user.uid,k_user.username,\'TIKUAN\',\'OUT\',k_money.m_order,k_money.m_value,k_user.money-k_money.m_value,k_user.money,:creationTime FROM k_user,k_money WHERE k_user.uid=k_money.uid AND k_money.status=2 AND k_money.m_id=:m_id');
	$stmt->execute($params);
	message('提款申请已经提交，等待财务人员为您出款', 'orders.php?p_type=t');
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
  <style type="text/css"> 
  .tDiv li{ 
	  padding-top: 10px;
  } 
  </style> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 640px;"> 
  <!--头部开始--> 
  <header id="header"> 
	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
		  <span>线上提款</span> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 

  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <form action="getmoney.php" onSubmit="return submitForm();" method="post" name="lt_form" data-role="none" data-ajax="false"> 
		  <input type="hidden" name="action" value="tikuan"> 
		  <div data-role="cotent"> 
			  <ul data-role="listview" class="ui-listview"> 
				  <li class="ui-li-static ui-body-inherit ui-first-child"> 
					  <label>用户账号：<?=$userinfo['username'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit ui-first-child"> 
					  <label>可用提款额度：<?=$userinfo['money'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>收款人姓名：<?=$userinfo['pay_name'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>收款银行：<?=$userinfo['pay_card'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>收款账号：<?=cutNum($userinfo['pay_num']);?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <label>收款银行地址：<?=$userinfo['pay_address'];?></label> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit"> 
					  <span>取款金额：<input type="text" name="pay_value" id="pay_value" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"  maxlength="10" data-role="none"></span> 
				  </li> 
				  <li class="ui-li-static ui-body-inherit ui-last-child"> 
					  <span>取款密码：<input type="password" name="qk_pwd" id="qk_pwd" maxlength="6" data-role="none"></span> 
				  </li> 
			  </ul> 
			  <div style="clear:both;text-align:center;"> 
				  <button name="btnSubmit" class="ui-btn ui-btn-inline">申请提款</button> 
			  </div> 
			  <div style="padding-left:10px;"> 
				  <span style="color:red;">友情提示：</span><br> 
				  <span style="color:red;">请认真填写以上提款单</span><br> 
				  <span style="color:blue;">允许出款时间为<?=$web_site['qk_time_begin'];?> 到<?=$web_site['qk_time_end'];?></span><br> 
				  <span style="color:blue;">最低取款金额<?=$web_site['qk_limit'];?>元</span> 
			  </div> 
		  </div> 
	  </form> 
  </section> 
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once 'myinfo.php';?>	
  <script type="text/javascript"> 
	  //数字验证 过滤非法字符 
	  function submitForm(){ 
		  if($("#pay_value").val()==""){ 
			  alert("请输入您的取款金额");
			  $("#pay_value").focus();
			  return false;
		  } 
		  if($("#pay_value").val()<<?=$web_site['qk_limit'];?>){ 
			  alert("每次最低提款金额为<?=$web_site['qk_limit'];?>元");
			  $("#pay_value").focus();
			  return false;
		  } 
		  if($("#pay_value").val()><?=$userinfo['money'];?>){ 
			  alert("提款金额大于目前余额，请重新输入");
			  $("#pay_value").focus();
			  return false;
		  } 
		  if($("#qk_pwd").val()==""){ 
			  alert("请输入您的取款密码");
			  $("#qk_pwd").focus();
			  return false;
		  } 

		  return true;
	  } 
  </script> 
</body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>