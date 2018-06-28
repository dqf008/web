<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('xtgl');
$id = isset($_GET['id'])?intval($_GET['id']):0;
$pre = 'mirror-';
$code = 'promotions';
if (!empty($_GET['action']) && $_GET['action'] == 'save'){
	$_POST['content1'] = preg_replace('#\s*<p>\s*(<br>)*\s*</p>#is', '', $_POST['content1']);
    $_POST['content2'] = preg_replace('/src="https?:\/\/'.str_replace('.', '\\.', $_SERVER['HTTP_HOST']).'(\/[^"]+)"/', 'src="$1"', $_POST['content2']);
    if ($id>0){
        $params = array(':title' => clear_html_code($_POST['title']), ':content' => serialize(array($_POST['content1'], $_POST['content2'], intval($_POST['content3']))), ':id' => $id, ':code'=>$pre.$code);
        $sql = 'update webinfo set title=:title,content=:content where id=:id and code=:code';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        message('活动修改成功!');
    }else{
        $params = array(':title' => clear_html_code($_POST['title']), ':content' => serialize(array($_POST['content1'], $_POST['content2'], intval($_POST['content3']))));
        $sql = 'INSERT INTO `webinfo` (`code`, `title`, `content`) VALUES ("'.$pre.$code.'", :title, :content)';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        message('活动添加成功!');
    }
}
$rows = array('content'=>array(), 'title'=>'');
if ($id>0){
    $params = array(':id' => $id, ':code'=>$pre.$code);
    $sql = 'select * from webinfo where id=:id and code=:code';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $rows['content'] = unserialize($rows['content']);
	$info['intro'] = stripcslashes($rows['content'][0]);
	$info['content'] = stripcslashes($rows['content'][1]);
	$info['sort'] = (int)$rows['content'][2];
	$info['title'] = $rows['title'];
}
?> 
<html>  
<head>  
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" />  
<title>添加优惠活动</title>  
<link rel="stylesheet" href="../Images/CssAdmin.css"> 
    <link rel="stylesheet" type="text/css" href="../wangEditor/dist/css/wangEditor.min.css">
    <script type="text/javascript" src="../wangEditor/dist/js/lib/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../wangEditor/dist/js/wangEditor.js"></script>
    <script type="text/javascript">
        $(document.body).ready(function(){
            var editor1 = new wangEditor('content1');
            editor1.config.menus = ["source", "|", "bold", "underline", "italic", "strikethrough", "eraser", "forecolor", "bgcolor", "|", "quote", "fontfamily", "fontsize", "head", "unorderlist", "orderlist", "alignleft", "aligncenter", "alignright", "|", "link", "unlink", "table", "emotion", "|", "img", "video", "|", "undo", "redo", "fullscreen"];
            editor1.config.emotions = {
                'default': {
                    title: '微博表情',
                    data: '../wangEditor/emotions.js'
                }
            };
            editor1.config.uploadImgUrl = '../wangEditor/upload.php';
            editor1.create();
            var editor2 = new wangEditor('content2');
            editor2.config.menus = ["source", "|", "bold", "underline", "italic", "strikethrough", "eraser", "forecolor", "bgcolor", "|", "quote", "fontfamily", "fontsize", "head", "unorderlist", "orderlist", "alignleft", "aligncenter", "alignright", "|", "link", "unlink", "table", "emotion", "|", "img", "video", "|", "undo", "redo", "fullscreen"];
            editor2.config.emotions = {
                'default': {
                    title: '微博表情',
                    data: '../wangEditor/emotions.js'
                }
            };
            editor2.config.uploadImgUrl = '../wangEditor/upload.php';
            editor2.create();
        });
    </script>
<style type="text/css">  
body { margin: 0px;} 
</style>  
</head>  

<body>  
<form action="yhhd_add.php?action=save&id=<?php echo $id; ?>" method="post" name="editForm1" id="editForm1" >  
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">  
<tr>  
  <td height="24" nowrap background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle">&nbsp;添加优惠活动</td>  
</tr>  
<tr>  
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">  
<tr>  
  <td height="24" nowrap bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" id=editProduct idth="100%">  
    <tr>  
      <td height="30" align="right" width="100">  <img src="../images/07.gif" width="12" height="12"> 活动名称：</td>  
      <td><input name="title" type="text" class="textfield" id="title"  value="<?=$info['title']; ?>" size="40" >&nbsp;*</td>  
    </tr>  
	<tr>  
	  <td height="30" align="right">  活动排序：</td>  
	  <td><input name="content3" type="text" class="textfield" id="content3"  value="<?=$info['sort']?>" size="40" >&nbsp;数值越大越靠前</td>  
	</tr>  
    <tr>  
      <td height="20" align="right" >  活动简介：</td>  
      <td> </td>  
    </tr>  
    <tr>  
      <td colspan="2"><textarea id="content1" name="content1" style="width:980px;height:240px;"><?=$info['intro']?></textarea></td>  
    </tr>  
    <tr> 
      <td colspan="2" height="10"></td>  
    </tr>  
    <tr>  
      <td height="20" align="right" >  活动详情：</td>  
      <td></td>  
    </tr>  
	<tr>  
	  <td colspan="2"><textarea id="content2" name="content2" style="width:980px;min-height:600px;"><?=$info['content']?></textarea></td>  
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