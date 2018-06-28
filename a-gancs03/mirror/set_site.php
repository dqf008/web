<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../member/pay/moneyconfig.php';
check_quanxian('xtgl');
if (@($_GET['action']) == 'save'){
	if (count($_POST) < 1){
		message('网站设置失败!');
	}
	$modify_pwd_c = intval(clear_html_code($_POST['modify_pwd_c']));
	if ($modify_pwd_c == 0){
		$modify_pwd_c = 15;
	}
	include_once '../../class/admin.php';
	admin::insert_log($_SESSION['adminid'], '修改了系统参数配置');
	$str = '<?php ' . "\r\n";
	$str .= '$web_site[\'web_name\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['web_name']) . '\';' . "\r\n";
	$str .= '$web_site[\'reg_msg_from\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['reg_msg_from']) . '\';' . "\r\n";
	$str .= '$web_site[\'reg_msg_title\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['reg_msg_title']) . '\';' . "\r\n";
	$str .= '$web_site[\'reg_msg_msg\']' . "\t" . '=' . "\t" . '\'' . encoding_html($_POST['reg_msg_msg']) . '\';' . "\r\n";
	$str .= '$web_site[\'web_title\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['web_title']) . '\';' . "\r\n";
	$str .= '$web_site[\'service_url\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($_POST['service_url']) . '\';' . "\r\n";
	if (@!chmod('../../cache', 511))
	{
		message('缓存文件写入失败！请先设 /cache 文件权限为：0777');
	}
	if (!write_file('../../cache/website_mirror.php', $str . '?>'))
	{
		message('缓存文件写入失败！请先设/website_mirror.php文件权限为：0777');
	}
	
	message('网站设置成功!');
}
include_once '../../cache/website_mirror.php';
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>网站信息设置</TITLE> 
<link rel="stylesheet" href="../Images/CssAdmin.css"> 
<style type="text/css"> 
body { 
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
  font-size: 12px;
} 
</style> 
<script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
<script language="JavaScript" src="/js/calendar.js"></script> 
<script language='javascript' src='../js/layer/layer.js'></script> 
<script> 
function betDetailUrl(url) { 
  layer.open({ 
	  type : 2, 
	  shadeClose : true, 
	  fix:true, 
	  skin: 'layui-layer-lan', 
	  title : "配置在线支付", 
	  content: url, 
	  area : ['800px' , '500px'], 
	  shift : 0, 
	  scrollbar: false 
  });
} 
</script> 
</HEAD> 

<body> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle">&nbsp;系统管理：添加，修改站点的相关信息</td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<form action="set_site.php?action=save" method="post" name="editForm1" id="editForm1" > 
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" id=editProduct idth="100%"> 
	<tr> 
	  <td height="30" align="right">  <img src="../images/07.gif" width="12" height="12"> 网站标题：</td> 
	  <td><input name="web_title" type="text" class="textfield" id="web_title"  value="<?=$web_site['web_title'];?>" size="100" >&nbsp;*</td> 
	</tr> 
	<tr> 
	  <td height="30" align="right">  <img src="../images/07.gif" width="12" height="12"> 网站名称：</td> 
	  <td><input name="web_name" type="text" class="textfield" id="web_name"  value="<?=$web_site['web_name'];?>" size="40" >&nbsp;*</td> 
	</tr> 
			<tr> 
	  <td height="30" align="right" >  注册消息标题：</td> 
	  <td><input name="reg_msg_title" type="text" class="textfield" id="reg_msg_title" value="<?=$web_site['reg_msg_title'];?>" size="40"></td> 
	</tr> 
			<tr> 
	  <td height="20" align="right" >  注册消息内容：</td> 
	  <td> 
	  <textarea name="reg_msg_msg" cols="80" rows="4" class="textfield"><?=$web_site['reg_msg_msg'];?></textarea></td> 
	</tr> 
			<tr> 
	  <td height="30" align="right" >  注册消息发送者：</td> 
	  <td><input name="reg_msg_from" type="text" class="textfield" id="reg_msg_from" value="<?=$web_site['reg_msg_from'];?>" size="40"></td> 
	</tr> 
	<tr> 
	  <td height="30" align="right" >  客服链接：</td> 
	  <td><input name="service_url" type="text" class="textfield" id="service_url" value="<?=$web_site['service_url'];?>" size="40"></td> 
	</tr>
	<tr> 
	  <td height="30" align="right">&nbsp;</td> 
	  <td valign="bottom"><input name="submitSaveEdit" type="submit" class="button"  id="submitSaveEdit" value="保存" style="width: 60;" ></td> 
	</tr> 
	<tr> 
	  <td height="20" align="right">&nbsp;</td> 
	  <td valign="bottom">&nbsp;</td> 
	</tr> 
  </table></td> 
</tr> 
</form> 
</table></td> 
</tr> 
</table> 
</body> 
</html>