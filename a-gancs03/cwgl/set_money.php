<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('jkkk');
if ($_GET['action'] == 'save'){
	include_once '../../class/money.php';
	$uid = intval($_POST['uid']);
	$uname = $_POST['username'];
	$money = sprintf('%.2f', floatval($_POST['m_value']));
	$money_type = intval($_POST['money_type']);
	$about = $_POST['about'];
	$order = $uname . '_' . $web_site['reg_msg_from'] . '_' . date('YmdHis');
	if ($money <= 0){
		message('请输入大于0的金额');
		exit();
	}
	
	if ($money_type == 0){
		message('请选择类型');
		exit();
	}
	
	$params = array(':uid' => $uid);
	$sql = 'select money from k_user where uid=:uid limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$assets = $stmt->fetchColumn();
	if ($_POST['type'] == 'add'){
		if (money::chongzhi($uid, $order, $money, $assets, 1, $about . '[管理员结算]', $money_type)){
			include_once '../../class/admin.php';
			admin::insert_log($_SESSION['adminid'], '对用户ID' . $uid . '的账户金额增加了' . $money . ',理由' . $about);
			message('加钱成功', 'man_money.php?username=' . $uname);
		}else{
			message('加钱失败');
		}
	}else if (money::tixian($uid, $money, $assets, $web_site['reg_msg_from'], '888888', '美国', $web_site['reg_msg_from'], $order, 1, $about . '[管理员结算]', $money_type)){
		include_once '../../class/admin.php';
		admin::insert_log($_SESSION['adminid'], '对用户ID' . $uid . '的账户金额扣除了' . $money . ',理由' . $about);
		message('扣钱成功', 'man_money.php?username=' . $uname);
	}else{
		message('扣钱失败');
	}
}

$params = array(':uid' => intval($_GET['uid']));
$sql = 'select username,money from k_user where uid=:uid limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetch();
$t_username = $rows['username'];
$t_money = $rows['money'];

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>用户手工结算金额</title> 
<style type="text/css"> 
<!-- 
.STYLE3 {color: #FF0000} 
--> 
</style> 
</head> 
<style type="text/css"> 
<STYLE> 
BODY { 
SCROLLBAR-FACE-COLOR: rgb(255,204,0);
SCROLLBAR-3DLIGHT-COLOR: rgb(255,207,116);
SCROLLBAR-DARKSHADOW-COLOR: rgb(255,227,163);
SCROLLBAR-BASE-COLOR: rgb(255,217,93) 
} 
body { 
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
} 
td{font:13px/120% "宋体";padding:3px;} 
a{ 

  color:#F37605;

  text-decoration: none;

} 
.t-title{background:url(../images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
.STYLE5 {color: #999999} 
</style> 
<body> 
<table align="center"  width="100%" > 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;用户余额手工结算</font></td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"> 
  <form name="form1"  method="post" action="<?=$_SERVER['PHP_SELF']?>?action=save"> 
 
  <table width="116%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" > 
<tr> 
  <td width="16%" height="45" align="right">用户名：</td>
  <td width="84%" align="left">
  <font color="Red"><?=$t_username?></font>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;余额：    <font color="Red"><?=$t_money?></font>
  <input  type="hidden" name="uid" value="<?=$_GET['uid']?>"/> 
  <input name="username" type="hidden" id="username" value="<?=$t_username?>" /></td> 
</tr> 
<tr> 
  <td height="49" align="right">加/减款：</td> 
  <td align="left"> 
  <input name="type" type="radio" value="add" <?=$_GET['type']=='add' ? 'checked="checked"' : ''?>/><span style="color:#009900">加钱</span>&nbsp;&nbsp;&nbsp;&nbsp; 
  <input type="radio" name="type" value="min" <?=$_GET['type']=='min' ? 'checked="checked"' : ''?>/><span style="color:#FF0000">扣钱</span>
  </td> 
</tr> 
  <tr> 
	  <td height="47" align="right">类型：</td> 
	  <td align="left"> 
		  <select name="money_type" id="money_type"> 
		  <option value="0">==请选择类型==</option> 
		  <option value="3">人工汇款</option> 
		  <option value="4">彩金派送</option> 
		  <option value="5">反水派送</option> 
		  <option value="6" <?=$_GET['money_type']==6 ? 'selected="selected"' : '' ?>>其他情况</option> 
		  </select> 
		  <span style="color:red">备注：如果您有开启【提款-打码量-自动审核】，在碰到【在线充值-掉单情况】，请选择【人工汇款】类型</span> 
	  </td> 
  </tr> 
<tr> 
   <td height="47" align="right">金额：</td> 
   <td align="left"><input name="m_value" type="text" size="10" maxlength="10"  value="<?=$_GET['money']?>"/>      
	 <span class="STYLE3">*</span><span class="STYLE5">必须为数字</span></td> 
</tr> 
  <tr> 
   <td height="44" align="right">理由：</td> 
   <td align="left"> <input name="about" type="text" size="40" maxlength="100" value="<?=$_GET['about']?>"/>  
	 &nbsp;为了方便财务对账，请填写说明！</td> 
</tr> 
<tr> 
  <td colspan="2" align="center">&nbsp;</td> 
  </tr> 
<tr> 
  <td align="center">&nbsp;</td> 
  <td align="left"><input name="submit" type="submit" style="width:100px;"  onclick="return confirm('确定提交?');" value="确定"/></td> 
</tr> 
</table>   
</form> 
</td> 
</tr> 
</table> 
</body> 
</html>