<?php 
session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../class/user.php';
include_once '../common/function.php';
include_once 'function.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($_SESSION['uid']);
if ($userinfo['pay_card'] == '')
{
	message('请先绑定银行账号信息', 'set_card.php');
	exit();
}
$tk_num = 0;
if(file_exists('../cache/group_'.$userinfo['gid'].'.php')){
	include_once '../cache/group_'.$userinfo['gid'].'.php';
	$tk_num = (int)$pk_db['提款次数'];
}
if (@($_GET['action']) == 'tikuan')
{
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
	if (time() - intval($_SESSION['last_get_money']) <= 30)
	{
		message('为了方便及时给您出款，30秒之内请勿多次提交提款请求');
		exit();
	}
	if (md5($_POST['qk_pwd']) != $userinfo['qk_pwd'])
	{
		message('提款密码错误，请重新输入');
		exit();
	}
	$pay_value = (int)$_POST['pay_value'];
	if (($pay_value < 0) || ($userinfo['money'] < $pay_value))
	{
		message('提款金额错误，请重新输入');
		exit();
	}
	if ($pay_value < $web_site['qk_limit'])
	{
		message('提款金额不能低于[' . $web_site['qk_limit'] . ']元');
		exit();
	}
	$currtime = time() + (1 * 12 * 3600);
	$c_time = date('Y-m-d H:i', $currtime);
	$qk_time_begin = date('Y-m-d', $currtime) . ' ' . $web_site['qk_time_begin'];
	$qk_time_end = date('Y-m-d', $currtime) . ' ' . $web_site['qk_time_end'];
	if ((strtotime($c_time) < strtotime($qk_time_begin)) || (strtotime($qk_time_end) < strtotime($c_time)))
	{
		message('很抱歉，不在提款时间段，暂时不能提款');
		exit();
	}
	$params = array(':uid' => $uid);
	$sql = 'select count(1) as num from k_money where type =2 and status=2 and uid=:uid and m_make_time>=date_add(now(),interval  -1 day)';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rows = $stmt->fetch();
	if (0 < $rows['num'])
	{
	 
		echo "<script>alert('您有未处理的提款订单，请联系客服处理，再继续提交！');window.location.href='get_money.php'</script>";
	    exit();
	}
	$params = array(':pay_value' => $pay_value, ':uid' => $uid, ':cur_money' => $pay_value);
	$sql = 'update k_user set money=money-:pay_value where uid=:uid and money>=:cur_money';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1 <= 0)
	{
		message('系统扣款失败，提款无法正常进行');
		exit();
	}
	$_SESSION['last_get_money'] = time();
	$pay_value = -$pay_value;
	$order = $_SESSION['username'] . '_' . date('YmdHis');
	$params = array(':uid' => $uid, ':m_value' => $pay_value, ':m_order' => $order, ':pay_card' => $userinfo['pay_card'], ':pay_num' => $userinfo['pay_num'], ':pay_address' => $userinfo['pay_address'], ':pay_name' => $userinfo['pay_name'], ':assets' => $userinfo['money'], ':balance' => $userinfo['money'] + $pay_value);
	
	$sql = 'insert into k_money(uid,m_value,status,m_order,pay_card,pay_num,pay_address,pay_name,about,assets,balance,type) values(:uid,:m_value,2,:m_order,:pay_card,:pay_num,:pay_address,:pay_name,\'\',:assets,:balance,2)';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$m_id = $mydata1_db->lastInsertId();
	$creationTime = date('Y-m-d H:i:s');
	$params = array(':creationTime' => $creationTime, ':m_id' => $m_id);
	$stmt = $mydata1_db->prepare('INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)
	SELECT k_user.uid,k_user.username,\'TIKUAN\',\'OUT\',k_money.m_order,k_money.m_value,k_user.money-k_money.m_value,k_user.money,:creationTime FROM k_user,k_money WHERE k_user.uid=k_money.uid AND k_money.status=2 AND k_money.m_id=:m_id');
	$stmt->execute($params);
	message('提款申请已经提交，等待财务人员为您出款', 'data_t_money.php');
}?> <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <title>会员中心</title> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
	  <script type="text/javascript" src="images/member.js"></script> 
	  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
      <script type="text/javascript" src="../skin/js/jquery-1.7.2.min.js"></script> 
	  <script> 
		  function check_submit(){ 
			  if($("#pay_value").val()==""){ 
				  alert("请输入您的取款金额");
				  $("#pay_value").focus();
				  return false;
			  } 
			  if($("#pay_value").val()<<?=$web_site['qk_limit']?> ){ 
				  alert("每次最低提款金额为<?=$web_site['qk_limit']?> 元");
				  $("#pay_value").focus();
				  return false;
			  } 
			  if($("#qk_pwd").val()==""){ 
				  alert("请输入您的取款密码");
				  $("#qk_pwd").focus();
				  return false;
			  } 
              $('#SubTran').val('提款提交中');
			  $("#SubTran").attr('disabled','disabled');
		  } 
	  </script> 
  </head> 
  <body> 
 <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;">
	<?php 
	include_once("mainmenu.php");
	?>
	<tr>
		<td colspan="2" align="center" valign="middle">
			<?php  include("moneymenu.php"); ?>
			<div class="content">
				  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
					  <tr> 
						  <td height="30" colspan="6" align="center" bgcolor="#FAFAFA" class="hong">
						  <strong>请认真填写以下提款单</strong> <span class="lan">允许出款时间为<?=$web_site['qk_time_begin']?> 到 <?=$web_site['qk_time_end']?> </span>
						  </td> 
					  </tr> 
					  <tr> 
						  <td colspan="6" align="left" bgcolor="#FFFFFF" style="line-height:22px;"> 
							  <table width="100%" border="0" cellspacing="0" cellpadding="5"> 
							   <form onSubmit="return check_submit()" action="?action=tikuan" method="post" name="form1"> 
								<tr>
									<td width="150" align="right" bgcolor="#FAFAFA">用户账号：</td>
									<td align="left"><?=$userinfo["username"]?></td>
								</tr>
								<tr>
									<td align="right" bgcolor="#FAFAFA">可用提款额度：</td>
									<td align="left"><?=sprintf("%.2f",$userinfo["money"])?></td>
								</tr>
								<tr>
									<td align="right" bgcolor="#FAFAFA">收款人姓名：</td>
									<td align="left"><?=$userinfo["pay_name"]?></td>
								</tr>
								<tr>
									<td align="right" bgcolor="#FAFAFA">收款银行：</td>
									<td align="left"><?=$userinfo["pay_card"]?></td>
								</tr>
								<tr>
									<td align="right" bgcolor="#FAFAFA">收款账号：</td>
									<td align="left"><?=cutNum($userinfo["pay_num"])?></td>
								</tr>
								<tr>
									<td align="right" bgcolor="#FAFAFA">收款银行地址：</td>
									<td align="left"><?=cutNum($userinfo["pay_address"])?></td>
								</tr>
								<tr>
									<td align="right" bgcolor="#FAFAFA">取款金额：</td>
									<td align="left"><input name="pay_value" type="text" class="input_150" id="pay_value" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="10"/>
										&nbsp;&nbsp;<span class="lan">最低取款金额<?=$web_site['qk_limit']?>元</span></td>
								</tr>
								<tr>
									<td align="right" bgcolor="#FAFAFA">取款密码：</td>
									<td align="left"><input name="qk_pwd" type="password" class="input_150" id="qk_pwd" onkeyup="if(isNaN(value))execCommand('undo')" maxlength="6" /></td>
								</tr>
								<tr>
									<td align="right" bgcolor="#FAFAFA">&nbsp;</td>
									<td align="left"><input name="SubTran" type="submit" class="submit_108" id="SubTran" value="申请提款" /></td>
								</tr>
							   </form> 
							  </table> 
						  </td> 
					  </tr> 
				  </table> 
			  </div> 
		  </td> 
	  </tr> 
  </table> 
  </body> 
  </html>