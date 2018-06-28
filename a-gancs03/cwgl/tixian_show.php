<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cwgl');
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>用户提现处理</TITLE> 
<link rel="stylesheet" href="Images/CssAdmin.css"> 
<style type="text/css"> 
.STYLE1 {font-size: 10px} 
.STYLE2 {font-size: 12px} 
body {  	  margin: 0px;} 
td{font:13px/120% "宋体";padding:3px;} 
a{color:#FFA93E;} 
.t-title{background:url(../images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
.zr span{
	margin: 0 5px;
	display:inline-block;
}
</style> 
<script language="JavaScript" src="../../js/jquery.js"></script> 
<script language="javascript">    
function chang(){ 
  var type  	  =  	  $("input[name='status']:checked").val();
  if(type == 1){ 
	  $("#d_txt").html('请填写本次汇款的实际手续费');
	  $("#d_text").html("<input name=\"sxf\" type=\"text\" id=\"sxf\" size=\"20\" maxlength=\"20\">&nbsp;元");
  }else if(type == 0){ 
	  $("#d_txt").html('请填写未支付原因');
	  $("#d_text").html("<textarea name=\"about\" id=\"about\" cols=\"45\" rows=\"5\"><?=$rows['about']?></textarea>");
  }else{ 
	  $("#d_txt").html('&nbsp;');
	  $("#d_text").html('&nbsp;');
  } 
} 

function check(){ 
  var type  	  =  	  $("input[name='status']:checked").val();
  if(type == 1){ 
	  if($("#sxf").val().length < 1){ 
		  alert('请您填写本次汇款的实际手续费');
		  $("#sxf").focus();
		  return false;
	  }else{ 
		  var sxf = $("#sxf").val()*1;
		  if(sxf>2000 || sxf<0){ 
			  alert('请输入正确的手续费');
			  $("#sxf").select();
			  return false;
		  } 
	  } 
  }else{ 
	  if($("#about").val().length < 4){ 
		  alert('请填写未支付原因');
		  $("#about").focus();
		  return false;
	  } 
  } 
  return true;
} 
</script> 
</HEAD> 

<body>
<?php 
	if ($_GET['action'] == 'save'){
	$m_id = intval($_GET['m_id']);
	$msg = '';
	$num = 0;
	if ($_POST['status'] == NULL){
		message('操作无效');
	}
	
	if ($_POST['status'] == 1){
		$sxf = trim($_POST['sxf']);
		$params = array(':sxf' => $sxf, ':m_id' => $m_id);
		$sql = 'update k_money set `status`=1,update_time=now(),sxf=:sxf where `status`=2 and m_id=:m_id';
		$msg = '审核了编号为' . $m_id . '的提款单,已支付';
		$num = 1;
	}else if ($_POST['status'] == 0){
		if (strpos($_POST['m_order'], '代理额度')){
			$params = array(':about' => $_POST['about'], ':m_id' => $m_id);
			$sql = 'update k_money set `status`=0,update_time=now(),about=:about where `status`=2 and m_id=:m_id';
			$num = 1;
		}else{
			$params = array(':about' => $_POST['about'], ':m_id' => $m_id);
			$sql = 'update k_money,k_user set k_money.status=0,k_money.update_time=now(),k_money.about=:about,k_user.money=k_user.money-k_money.m_value,k_money.balance=k_user.money-k_money.m_value where k_user.uid=k_money.uid and k_money.status=2 and k_money.m_id=:m_id';
			$num = 2;
			$msg = '审核了编号为' . $m_id . '的提款单,未支付,原因' . $_POST['about'];
		}
	}else{
		message('操作无效');
	}
	$bool = true;
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	$creationTime = date('Y-m-d H:i:s');
	$params = array(':creationTime' => $creationTime, ':m_id' => $m_id);
	$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)
	SELECT k_user.uid,k_user.username,\'TIKUAN\',\'CANCEL_OUT\',k_money.m_order,-k_money.m_value,k_user.money+k_money.m_value,k_user.money,:creationTime FROM k_user,k_money WHERE k_user.uid=k_money.uid AND k_money.status=0  AND k_money.m_id=:m_id';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	if ($_POST['status'] == 0){
		if (strpos($_POST['m_order'], '代理额度')){
			$params = array(':uid' => $_POST['uid'], ':month' => date('Y-m', time()) . '%');
			$sql = 'delete from k_user_daili_result where uid=:uid and `type`=2 and month like(:month)';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q2 = $stmt->rowCount();
			if ($q2 != 1){
				$bool = false;
			}
		}
	}
	
	if (($q1 == $num) && $bool){
		if (($num == 2) && ($_POST['about'] != '')){
			include_once '../../class/user.php';
			user::msg_add($_POST['uid'], $web_site['reg_msg_from'], '审核了编号为' . $m_id . '的提款单,未支付', $_POST['about']);
		}
		include_once '../../class/admin.php';
		admin::insert_log($_SESSION['adminid'], $msg);
		message('操作成功', 'tixian.php?status=2');
	}else{
		message('操作失败');
	}
}
?> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;账单详细查看</font></td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"> 
<br>
<?php 
$params = array(':m_id' => intval($_GET['id']));
$sql = 'select k_money.*,k_user.username,k_user.why,k_user.pay_name,agUserName,agqUserName,bbinUserName,mayaUserName,shabaUserName,mwUserName,kgUserName,cq9UserName,mg2UserName,vrUserName,bgUserName,sbUserName,pt2UserName,og2UserName,dgUserName,kyUserName,bbin2UserName,mgUserName,ogUserName,ptUserName from k_money left join k_user on k_money.uid=k_user.uid  where  k_money.m_id=:m_id';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetch();
?> 
<form action="<?=$_SERVER['PHP_SELF']?>?action=save&m_id=<?=$rows['m_id']?>" method="post" name="form1" id="form1" onSubmit="return check();"> 
<table width="90%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" align="center"> 
<tr> 
  <td bgcolor="#F0FFFF">用户名</td> 
  <td><a href="../hygl/user_show.php?id=<?=$rows['uid']?>"><?=$rows['username']?><input name="uid" type="hidden" id="uid" value="<?=$rows['uid']?>"> 
  </a></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">用户备注</td> 
  <td><?=$rows['why']?></td> 
</tr>
<tr> 
  <td bgcolor="#F0FFFF">真人用户名</td> 
  <td style="line-height:24px;" class="zr">
	  <span>AG国际厅 => <?=$rows['agUserName']?></span>
	  <span>AG极速厅 => <?=$rows['agqUserName']?></span>
	  <span>新BB波音厅 => <?=$rows['bbin2UserName']?></span>
	  <span>新PT电子 => <?=$rows['pt2UserName']?></span>
	  <span>新OG东方厅 => <?=$rows['og2UserName']?></span>
	  <span>MW电子 => <?=$rows['mwUserName']?></span>
	  <span>玛雅娱乐厅 => <?=$rows['mayaUserName']?></span>
	  <span>沙巴体育 => <?=$rows['shabaUserName']?></span>
	  <span>AV女优 => <?=$rows['kgUserName']?></span>
	  <span>CQ9电子 => <?=$rows['cq9UserName']?></span>
	  <span>新MG电子 => <?=$rows['mg2UserName']?></span>
	  <span>VR彩票 => <?=$rows['vrUserName']?></span>
	  <span>BG视讯 => <?=$rows['bgUserName']?></span>
	  <span>申博视讯 => <?=$rows['sbUserName']?></span>
	  <span>DG视讯 => <?=$rows['dgUserName']?></span>
	  <span>开元棋牌 => <?=$rows['kyUserName']?></span>
	  <!--span>OG东方厅 => <?=$rows['ogUserName']?></span>
	  <span>PT电子 => <?=$rows['ptUserName']?></span-->
	  <span>BB波音厅 => <?=$rows['bbinUserName']?></span>
	  <span>MG电子 => <?=$rows['mgUserName']?></span>
  </td> 
</tr>
<tr> 
  <td bgcolor="#F0FFFF">订单号</td> 
  <td><?=$rows['m_order']?><input name="m_order" type="hidden" id="m_order" value="<?=$rows['m_order']?>"></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">开户行</td> 
  <td><?=$rows['pay_card']?></td> 
</tr> 
<tr> 
  <td width="172" bgcolor="#F0FFFF">卡号</td> 
  <td width="473"><?=$rows['pay_num']?></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">开户姓名</td> 
  <td><?=$rows['pay_name']?></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">开户地址</td> 
  <td><?=$rows['pay_address']?></td> 
</tr> 
<tr>
    <td bgcolor="#F0FFFF">取款前余额</td>
    <td><span style="color:#999999;"><?=sprintf("%.2f",$rows["assets"])?></span></td>
  </tr>
  <tr>
    <td bgcolor="#F0FFFF">金额</td>
    <td><?=sprintf("%.2f",abs($rows["m_value"]))?></td>
  </tr>
  <tr>
    <td bgcolor="#F0FFFF">取款后余额</td>
    <td><span style="color:#999999;"><?=sprintf("%.2f",$rows["balance"])?></span></td>
  </tr>
<tr> 
  <td bgcolor="#F0FFFF">申请时间</td> 
  <td><?=$rows['m_make_time']?></td> 
</tr>
<?php if ($rows['status'] == 2){?>   
<tr> 
  <td bgcolor="#F0FFFF">操作</td> 
  <td> 
	<input name="status" type="radio" id="status" onClick="chang()" value="1" checked><span style="color:#009900">已支付</span> 
	&nbsp;
	<input type="radio" name="status" id="status" onClick="chang()" value="0"><span style="color:#FF0000">未支付</span></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF"><div id="d_txt">请填写本次汇款的实际手续费</div></td> 
  <td><div id="d_text"><input name="sxf" type="text" id="sxf" size="20" maxlength="20" value="0"> 
  &nbsp;元</div></td> 
</tr>
<?php 
}

if ($rows['status'] == 2){
?>  
<tr> 
  <td bgcolor="#F0FFFF">操作</td> 
  <td><input type="submit" value="提交"/></td> 
</tr>
<?php }else{?>   
<tr> 
  <td bgcolor="#F0FFFF">状态</td> 
  <td>
<?php
if ($rows['status'] == 1){
	echo '<span style="color:#006600;">成功</span>';
}else{
	echo '<span style="color:#FF0000;">失败</span>';
}
?> 
</td> 
</tr> 
  <tr> 
  <td bgcolor="#F0FFFF">处理时间</td> 
  <td><?=$rows['update_time']?></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">原因</td> 
  <td><?=$rows['about']?></td> 
</tr>
<?php }?> 
</table> 
</form> 
</td> 
</tr> 
</table>
<?php include_once 'tkdama.php'; ?>
</body> 
</html>