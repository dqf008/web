<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('xtgl');
$code = $_GET['code'];
$list = ['us'=>'公司简介', 'contact'=>'联系我们','help'=>'常见问题','deposit'=>'存款帮助','withdraw'=>'取款帮助','partner'=>'加盟代理','signup'=>'免费开户'];
if(!array_key_exists($code, $list)) $code = 'us';

if (!empty($_GET['action']) && $_GET['action'] == 'save') {
	$code = $_POST['code'];
	if(!array_key_exists($code, $list)) message('栏目错误!');
	$sql = 'select * from webinfo where code="mirror-about-'.$code.'" limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rows = $stmt->fetch();
	if($rows){
		$params = array(':content' => $_POST['content'], ':code' => 'mirror-about-'.$code);
		$sql = 'update webinfo set content=:content where code=:code';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
	}else{
		$params = array(':content' => $_POST['content'], ':code' => 'mirror-about-'.$code, ':title'=>$list[$code]);
		$sql = 'INSERT INTO `webinfo` (`code`, `title`, `content`) VALUES (:code, :title, :content)';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
	}
    message('栏目修改成功!');
}
$params = array(':code' => 'mirror-about-'.$code);
$sql = 'select * from webinfo where code=:code limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetch();
?> 
<HTML>  
<HEAD>  
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" />  
<TITLE>网站栏目设置</TITLE>  
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
  margin: 0px;
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
		<a href="?code=us">公司简介</a> | <a href="?code=contact">联系我们</a> | <a href="?code=help">常见问题</a> | <a href="?code=deposit">存款帮助</a> | <a href="?code=withdraw">取款帮助</a> | <a href="?code=partner">加盟代理</a> | <a href="?code=signup">免费开户 </a>
	 </td>  
	</tr>  
	<tr> 
	  <td colspan="2" height="10"></td>  
	</tr>  
	<tr>  
	  <td height="30" align="right" width="100">  <img src="../images/07.gif" width="12" height="12"> 栏目名称：</td>  
	  <td><?=$list[$code]?></td>  
	</tr>  
	<tr>  
	  <td height="20" align="right" >  详细内容：</td>  
	  <td> </td>  
	</tr>  
	<tr>  
	  <td colspan="2"> 
        <textarea id="content" name="content" style="width:800px;min-height:600px;"><?php echo stripcslashes($rows['content']); ?></textarea></td>  
	</tr>  
	<tr>  
	  <td height="30" align="right">
		<input id="code" name="code" type="hidden" value="<?=$code;?>" />
	  </td>  
	  <td valign="bottom"><input name="submitSaveEdit" type="submit" class="button"  id="submitSaveEdit" value="保存" style="width: 60px;" ></td>  
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