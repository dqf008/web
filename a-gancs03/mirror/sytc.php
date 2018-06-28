<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('xtgl');

if (@($_GET['action']) == 'save'){
    $params = array(':title' => serialize(array(intval($_POST['title'][0]), clear_html_code($_POST['title'][1]))), ':content' => $_POST['content'], ':code' => 'main-tc-m');
    $params[':content'] = preg_replace('/src="https?:\/\/'.str_replace('.', '\\.', $_SERVER['HTTP_HOST']).'(\/[^"]+)"/', 'src="$1"', $params[':content']);
    $sql = 'update webinfo set title=:title,content=:content where code=:code';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    message('弹窗修改成功!');
}
$sql = 'select * from webinfo where code=\'main-tc-m\'';
$query = $mydata1_db->query($sql);
if($query->rowCount()>0){
    $rows = $query->fetch();
    $rows['title'] = unserialize($rows['title']);
    $rows['content'] = stripcslashes($rows['content']);
}else{
    $rows = array('content'=>'', 'title'=>array(0, ''));
    $mydata1_db->query('INSERT INTO `webinfo` (`code`) VALUES (\'main-tc-m\')');
}
?> 
<HTML>  
<HEAD>  
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" />  
<TITLE>首页弹窗</TITLE>  
<link rel="stylesheet" href="../Images/CssAdmin.css"> 
    <link href="../umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript">window.UMEDITOR_UPLOAD_URL = "http://<?php echo $_SERVER['HTTP_HOST']; ?>/";</script>
    <script type="text/javascript" src="../umeditor/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="../umeditor/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="../umeditor/editor_api.js"></script>
    <script type="text/javascript" src="../umeditor/lang/zh-cn/zh-cn.js"></script>
<style type="text/css">  
body { 
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
  font-size: 12px;
} 
</style>  
</HEAD>  

<body>  
<form action="sytc.php?action=save&id=<?php echo $id; ?>" method="post" name="editForm1" id="editForm1" >  
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">  
<tr>  
  <td height="24" nowrap background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle">&nbsp;首页弹窗</td>  
</tr>  
<tr>  
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">  
<tr>  
  <td height="24" nowrap bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" id=editProduct idth="100%">  
    <tr>  
      <td height="30" align="right">  <img src="../images/07.gif" width="12" height="12"> 显示时间：</td>  
      <td><input name="title[]" type="text" class="textfield" id="title[]"  value="<?php echo $rows['title'][0]; ?>" size="20" >&nbsp;单位：秒，填写为 0 则关闭弹窗</td>  
    </tr>  
	<tr>  
	  <td height="30" align="right">  弹窗标题：</td>  
	  <td><input name="title[]" type="text" class="textfield" id="title[]"  value="<?php echo htmlspecialchars($rows['title'][1]); ?>" size="40" >&nbsp;*</td>  
	</tr>  
	<tr>  
	  <td height="20" align="right" >  弹窗详情：</td>  
	  <td> 
        <script type="text/plain" id="content" name="content" style="width:980px;height:240px;"><?php echo $rows['content']; ?></script><script type="text/javascript">(function(){var um = UM.getEditor('content')})();</script><br /><span style="color:red">* 支持文字、图片，建议宽高度不超过600x400px</span></td>  
	</tr>  
	<tr>  
	  <td height="30" align="right"></td>  
	  <td valign="bottom"><input name="submitSaveEdit" type="submit" class="button"  id="submitSaveEdit" value="保存" style="width: 60;" ></td>  
	</tr>  
	<tr>  
	  <td height="20" align="right">&nbsp;</td>  
	  <td valign="bottom">&nbsp;</td>  
	</tr>  
  </table></td>  
</tr>  
</table></td>  
</tr>  
</table>  
</form>  
</body>  
</html> 