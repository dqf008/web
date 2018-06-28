<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('dlgl');

$_GET['type'] = isset($_GET['type'])&&in_array($_GET['type'], ['servicerule', 'mservicerule'])?$_GET['type']:'aboutus';
$file = realpath('../../cache/').'/agent.conf.php';
$config = [];
file_exists($file)&&$config = include($file);
if(!empty($_POST)&&isset($_POST['action'])&&$_POST['action']=='save'){
    $names = [
        'aboutus' => '关于我们',
        'servicerule' => '电脑端佣金条款',
        'mservicerule' => '手机端佣金条款',
    ];
    $_POST['content'] = isset($_POST['content'])&&!empty($_POST['content'])?preg_replace('/src="https?:\/\/'.str_replace('.', '\\.', $_SERVER['HTTP_HOST']).'(\/[^"]+)"/', 'src="$1"', $_POST['content']):'';
    $stmt = $mydata1_db->prepare('UPDATE `webinfo` SET `content`=? WHERE `code`=?');
    $stmt->execute([$_POST['content'], 'agent-'.$_GET['type']]);
    admin::insert_log($_SESSION['adminid'], '修改了代理页面['.$names[$_GET['type']].']信息');
    message('保存成功！');
    exit;
}
$stmt = $mydata1_db->prepare('SELECT `content` FROM `webinfo` WHERE `code`=?');
$stmt->execute(['agent-'.$_GET['type']]);
if(!($rows = $stmt->fetch())){
    $rows = ['content' => ''];
    $stmt = $mydata1_db->prepare('INSERT INTO `webinfo` (`code`) VALUES (?)');
    $stmt->execute(['agent-'.$_GET['type']]);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Welcome</title>
    <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" />
    <style type="text/css">
        .menu_curr {color:#FF0;font-weight:bold}
        .menu_com {color:#FFF;font-weight:bold}
    </style>
    <link rel="stylesheet" type="text/css" href="../wangEditor/dist/css/wangEditor.min.css">
    <script type="text/javascript" src="../wangEditor/dist/js/lib/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../wangEditor/dist/js/wangEditor.js"></script>
    <script type="text/javascript">
        $(document.body).ready(function(){
            var editor1 = new wangEditor('content');
            editor1.config.menus = ["source", "|", "bold", "underline", "italic", "strikethrough", "eraser", "forecolor", "bgcolor", "|", "quote", "fontfamily", "fontsize", "head", "unorderlist", "orderlist", "alignleft", "aligncenter", "alignright", "|", "link", "unlink", "table", "emotion", "|", "img", "video", "|", "undo", "redo", "fullscreen"];
            editor1.config.emotions = {
                'default': {
                    title: '微博表情',
                    data: '../wangEditor/emotions.js'
                }
            };
            editor1.config.uploadImgUrl = '../wangEditor/upload.php';
            editor1.create();
        });
    </script>
</head>
<body>
<div id="pageMain">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td valign="top">
                <form action="content.php?type=<?php echo $_GET['type']; ?>" method="POST">
                    <input type="hidden" name="action" value="save" />
                    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                        <tr>
                            <td align="center" bgcolor="#3C4D82" style="color:#fff"><a href="?type=aboutus" class="<?php echo $_GET['type']=='aboutus'?'menu_curr':'menu_com'; ?>">关于我们</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=servicerule" class="<?php echo $_GET['type']=='servicerule'?'menu_curr':'menu_com'; ?>">电脑端佣金条款</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="?type=mservicerule" class="<?php echo $_GET['type']=='mservicerule'?'menu_curr':'menu_com'; ?>">手机端佣金条款</a></td>
                        </tr>
                        <tr>
                            <td align="center" bgcolor="#F0FFFF"><textarea id="content" name="content" style="width:100%;min-height:600px;"><?php echo stripcslashes($rows['content']); ?></textarea></td>
                        </tr>
                        <tr>
                            <td align="center" bgcolor="#FFFFFF"><input type="submit" class="submit80" value="保存" /></td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</div>
</body>
</html>