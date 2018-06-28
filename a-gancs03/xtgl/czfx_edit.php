<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
$query = $mydata1_db->query('SELECT `value` FROM `k_money_fs` WHERE `uid`=0');
if($query->rowCount()>0){
    $czfx = $query->fetch();
    $czfx = unserialize($czfx['value']);
}else{
    $czfx = array();
    $mydata1_db->query('INSERT INTO `k_money_fs` (`uid`, `value`) VALUES (0, \''.serialize($czfx).'\')');
}
check_quanxian('xtgl');
$id = intval($_GET['id']);
$sql = 'select name from `k_group` where id=' . $id . ' limit 1';
$query = $mydata1_db->query($sql);
$rs = $query->fetch();
if(isset($_GET['action'])&&$_GET['action']=='save'){
	$czfx[$id] = array();
	$_POST['enabled']=='1'&&$czfx[$id]['enabled'] = true;
	$czfx[$id]['limit'] = intval($_POST['limit']*100);
	$czfx[$id]['proportion'] = intval($_POST['proportion']*100);
	$_POST['allowed']=='1'&&$czfx[$id]['allowed'] = true;
	$_POST['message']=='1'&&$czfx[$id]['message'] = true;
	$mydata1_db->query('UPDATE `k_money_fs` SET `value`=\''.serialize($czfx).'\' WHERE `uid`=0');
	message('保存成功', 'czfx_edit.php?id='.$id);
}
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>充值返现</TITLE> 
<link rel="stylesheet" href="Images/CssAdmin.css"> 

<style type="text/css"> 
<STYLE> 
BODY { 
SCROLLBAR-FACE-COLOR: rgb(255,204,0);
SCROLLBAR-3DLIGHT-COLOR: rgb(255,207,116);
SCROLLBAR-DARKSHADOW-COLOR: rgb(255,227,163);
SCROLLBAR-BASE-COLOR: rgb(255,217,93) 
} 
.STYLE2 {font-size: 12px} 
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
</STYLE> 
</HEAD> 
<body> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2">充值返现：设置会员组充值返现</span></font></td> 
</tr> 
<tr> 
  <td height="24" align="left" nowrap bgcolor="#FFFFFF">&nbsp;&nbsp;<a href="czfx.php">&lt;&lt;返回会员组</a></td> 
</tr> 
<tr> 
  <td height="24" align="left" nowrap bgcolor="#FFFFFF">
<form action="czfx_edit.php?action=save&id=<?php echo $id; ?>" method="post" name="editForm1" id="editForm1" > 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" id=editProduct idth="100%"> 
	<tr> 
	  <td height="30" align="right">  会员组：</td> 
	  <td><?php echo $rs['name']; ?>&nbsp;</td> 
	</tr> 
	<tr> 
	  <td height="30" align="right">  返现：</td> 
	  <td><input type="radio" name="enabled" value="1"<?php echo isset($czfx[$id]['enabled'])?' checked="true"':''; ?>>启用&nbsp;&nbsp;<input type="radio" name="enabled" value="0"<?php echo isset($czfx[$id]['enabled'])?'':' checked="true"'; ?>>关闭&nbsp;</td> 
	</tr> 
	<tr> 
	  <td height="30" align="right" >  返现起步：</td> 
	  <td><input name="limit" type="text" class="textfield" maxlength="10" id="limit" value="<?php echo sprintf('%1.2f', $czfx[$id]['limit']/100); ?>" size="10"> 单位：元</td> 
	</tr> 
	<tr> 
	  <td height="30" align="right" >  返现比例：</td> 
	  <td><input name="proportion" type="text" class="textfield" maxlength="10" id="proportion" value="<?php echo sprintf('%1.2f', $czfx[$id]['proportion']/100); ?>" size="10"> 单位：百分比</td> 
	</tr> 
	<tr> 
	  <td height="30" align="right" >  充值累积：</td> 
	  <td><input type="radio" name="allowed" value="1"<?php echo isset($czfx[$id]['allowed'])?' checked="true"':''; ?>>允许&nbsp;&nbsp;<input type="radio" name="allowed" value="0"<?php echo isset($czfx[$id]['allowed'])?'':' checked="true"'; ?>>禁止&nbsp;</td> 
	</tr> 
	<tr> 
	  <td height="30" align="right" ></td> 
	  <td>单笔充值未达到起步金额则进行累积，多次充值后超过起步金额则对已累积金额进行返现</td> 
	</tr> 
	<tr> 
	  <td height="30" align="right" >  返现提醒：</td> 
	  <td><input type="radio" name="message" value="1"<?php echo isset($czfx[$id]['message'])?' checked="true"':''; ?>>启用&nbsp;&nbsp;<input type="radio" name="message" value="0"<?php echo isset($czfx[$id]['message'])?'':' checked="true"'; ?>>关闭&nbsp;</td> 
	</tr> 
	<tr> 
	  <td height="30" align="right">&nbsp;</td> 
	  <td valign="bottom"><input name="submitSaveEdit" type="submit" class="button"  id="submitSaveEdit" value="保存" style="width: 60;" ></td> 
	</tr> 
	<tr> 
	  <td height="20" align="right">&nbsp;</td> 
	  <td valign="bottom">&nbsp;</td> 
	</tr> 
  </table>
  </td> 
</tr> 
</table>
</form>
  </td> 
</tr> 
</table>
</body> 
</html>