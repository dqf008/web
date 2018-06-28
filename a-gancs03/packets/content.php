<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('hbxt');

$params = array(':code' => 'packets-content');

if(isset($_POST['action'])&&$_POST['action']=='save'){
    $params[':content'] = isset($_POST['content'])?$_POST['content']:'';
    $params[':content'] = preg_replace('/src="https?:\/\/'.str_replace('.', '\\.', $_SERVER['HTTP_HOST']).'(\/[^"]+)"/', 'src="$1"', $params[':content']);
    $stmt = $mydata1_db->prepare('UPDATE `webinfo` SET `content`=:content WHERE `code`=:code');
    $stmt->execute($params);
    message('红包活动详情保存成功!');
}

$stmt = $mydata1_db->prepare('SELECT * FROM `webinfo` WHERE `code`=:code');
$stmt->execute($params);
if($stmt->rowCount()>0){
    $rows = $stmt->fetch();
}else{
    $rows = array('content' => '');
    $params[':title'] = '红包活动详情';
    $params[':content'] = '';
    $stmt = $mydata1_db->prepare('INSERT INTO `webinfo` (`code`, `title`, `content`) VALUES (:code, :title, :content)');
    $stmt->execute($params);
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>红包系统设置</title>
    <link rel="stylesheet" href="../Images/CssAdmin.css" />
    <style type="text/css">
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
            font-size: 12px;
        }
    </style>
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
</head>
<body>
    <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tbody>
            <tr>
                <td height="24" nowrap="" background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle" />&nbsp;红包系统：活动详情</td>
            </tr>
            <tr>
                <td height="24" align="center" nowrap="" bgcolor="#FFFFFF">
                    <form name="form1" method="POST" action="content.php">
                        <input type="hidden" name="action" value="save" />
                        <table width="90%" align="center" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse:collapse;color:#225d9c">
                            <tr>
                                <td style="padding:5px"><textarea id="content" name="content" style="min-height:600px"><?php echo stripcslashes($rows['content']); ?></textarea></td>
                            </tr>
                            <tr>
                                <td align="center" height="35"><input type="submit" value="保存" /></td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>