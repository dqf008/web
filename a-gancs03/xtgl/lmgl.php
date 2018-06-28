<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('xtgl');
$id = intval($_GET['id']);
if ($id <= 0){
	$id = 1;
}

if (@($_GET['action']) == 'save'){
    // $params = array(':title' => clear_html_code($_POST['title']), ':code' => clear_html_code($_POST['code']), ':content' => $_POST['content'], ':id' => $_POST['autoid']);
    // $sql = 'update webinfo set title=:title,code=:code,content=:content where id=:id';
    $_POST['content'] = preg_replace('/src="https?:\/\/'.str_replace('.', '\\.', $_SERVER['HTTP_HOST']).'(\/[^"]+)"/', 'src="$1"', $_POST['content']);
	$params = array(':content' => $_POST['content'], ':id' => $_POST['autoid']);
	$sql = 'update webinfo set content=:content where id=:id';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
    message('栏目修改成功!');
}
$params = array(':id' => $id);
$sql = 'select * from webinfo where id=:id';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetch();
?> 
<HTML>  
<HEAD>  
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" />  
<TITLE>网站栏目设置</TITLE>  
<link rel="stylesheet" href="../Images/CssAdmin.css"> 
    <link rel="stylesheet" type="text/css" href="../wangEditor/dist/css/wangEditor.min.css">
    <script type="text/javascript" src="../wangEditor/dist/js/lib/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../wangEditor/dist/js/wangEditor.js"></script>
    <script type="text/javascript">
        $(document.body).ready(function(){
            var editor = new wangEditor('content');
            editor.config.menus = ["source", "|", "bold", "underline", "italic", "strikethrough", "eraser", "forecolor", "bgcolor", "|", "quote", "fontfamily", "fontsize", "head", "unorderlist", "orderlist", "alignleft", "aligncenter", "alignright", "|", "link", "unlink", "table", "emotion", "|", "img", "video", "|", "undo", "redo", "fullscreen"];
            editor.config.emotions = {
                'default': {
                    title: '微博表情',
                    data: '../wangEditor/emotions.js'
                }
            };
            editor.config.uploadImgUrl = '../wangEditor/upload.php';
            editor.create();
        });
    </script>
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
<form action="lmgl.php?action=save" method="post" name="editForm1" id="editForm1" >  
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">  
<tr>  
  <td height="24" nowrap background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle">&nbsp;栏目管理：修改栏目的相关信息</td>  
</tr>  
<tr>  
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">  
<tr>  
  <td height="24" nowrap bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" id=editProduct idth="100%">  
	<tr> 
	  <td colspan="2" style="font-size: 12px;">
<?php 
$sql = 'select * from webinfo where code like \'about-%\' order by id asc';
$query = $mydata1_db->query($sql);
while ($rs = $query->fetch())
{
?>             
	<a href="?id=<?php echo $rs['id']; ?>"><?php echo $rs['title']; ?></a> |
<?php }?>         
	 </td>  
	</tr>  
	<tr> 
	  <td colspan="2" height="10"></td>  
	</tr>  
	<tr>  
	  <td height="30" align="right" width="100">  <img src="../images/07.gif" width="12" height="12"> 栏目名称：</td>  
	  <td><!-- <input name="title" type="text" class="textfield" id="title"  value="<?php echo $rows['title']; ?>" size="40" >&nbsp;* --><?php echo $rows['title']; ?></td>  
	</tr>  
	<!-- <tr>  
      <td height="30" align="right">  <img src="../images/07.gif" width="12" height="12"> 链接代码：</td>  
      <td><input name="code" type="text" class="textfield" id="code"  value="<?php echo $rows['code']; ?>" size="40" >&nbsp;*</td>  
    </tr>  -->
			<tr>  
	  <td height="20" align="right" >  详细内容：</td>  
	  <td> </td>  
	</tr>  
			<tr>  
	  <td colspan="2"> 
        <textarea id="content" name="content" style="width:800px;min-height:600px;"><?php echo stripcslashes($rows['content']); ?></textarea></td>  
	</tr>  
	<tr>  
	  <td height="30" align="right"><input id="autoid" name="autoid" type="hidden" value="<?=$id;?>" /></td>  
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