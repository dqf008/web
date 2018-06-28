<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('xtgl');

$type = 'show';
$_GET['id'] = isset($_GET['id'])?intval($_GET['id']):0;
$_GET['action'] = isset($_GET['action'])?intval($_GET['action']):'default';
if($_GET['id']>0){
    $stmt = $mydata1_db->prepare('SELECT * FROM `webinfo` WHERE (`code`=? OR `code`=?) AND `id`=?');
    $stmt->execute(['promotions-hide-m','promotions-mobile', $_GET['id']]);
    if($rows = $stmt->fetch()){
        $rows['content'] = unserialize($rows['content']);
        $type = $rows['code']=='promotions-hide-m'?'hide':'show';
        $rows['add'] = false;
    }else{
        message('活动不存在，请刷新页面重试！');
        exit;
    }
}else{
    $rows = [
            'id' => 0,
            'content' => [],
            'title' => '',
            'add' => true,
    ];
}
if($_GET['action']=='save'&&!empty($_POST)){
    $_POST['content'] = isset($_POST['content'])&&!empty($_POST['content'])?preg_replace('/src="https?:\/\/'.str_replace('.', '\\.', $_SERVER['HTTP_HOST']).'(\/[^"]+)"/', 'src="$1"', $_POST['content']):'';
    $_POST['title'] = isset($_POST['title'])?$_POST['title']:'';
    $params = [
            !isset($_POST['show'])||$_POST['show']=='false'?'promotions-hide-m':'promotions-mobile',
            $_POST['title'],
            serialize([
                isset($_POST['image'])?$_POST['image']:'',
                $_POST['content'],
                isset($_POST['order'])?intval($_POST['order']):0,
            ]),
    ];
    if($rows['add']){
        $sql = 'INSERT INTO `webinfo` (`code`, `title`, `content`) VALUES (?, ?, ?)';
    }else{
        $sql = 'UPDATE `webinfo` SET `code`=?, `title`=?, `content`=? WHERE `id`=?';
        $params[] = $_GET['id'];
    }
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    admin::insert_log($_SESSION['adminid'], ($rows['add']?'添加':'编辑').'手机优惠活动['.$_POST['title'].']');
    message(($rows['add']?'添加':'编辑').'手机优惠活动成功！');
    exit;
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
        .sub_curr {color:#f00;font-weight:bold}
        .sub_com {color:#333;font-weight:bold}
    </style>
    <link rel="stylesheet" type="text/css" href="../wangEditor/dist/css/wangEditor.min.css">
    <script type="text/javascript" src="../wangEditor/dist/js/lib/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../wangEditor/dist/js/wangEditor.js"></script>
    <script type="text/javascript" charset="utf-8" src="../js/layer/layer.js"></script>
    <script type="text/javascript">
        $(document.body).ready(function(){
            var openUpload = function(){
                return layer.open({
                    type: 2,
                    shadeClose: true,
                    fix: true,
                    skin: 'layui-layer-lan',
                    title: "图片上传",
                    content: "images.php",
                    area: ['400px', '120px'],
                    shift: 0,
                    scrollbar: false
                });
            };
            window.onMessage = function(){};
            $(".set-image input[type=button]").on("click", function () {
                var e = $(this), i = openUpload();
                window.onMessage = function(image){
                    e.siblings("span.img").html('<input type="hidden" name="image" value="'+image+'"><img src="'+image+'" style="max-height:100px">');
                    layer.close(i)
                };
            });
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
                <form action="activity_add.php?id=<?php echo $_GET['id']; ?>&amp;action=save" method="POST">
                    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                        <tr>
                            <td align="center" bgcolor="#3C4D82" style="color:#FFF" colspan="2"><strong><?php echo $rows['add']?'添加':'编辑'; ?>手机优惠活动</strong></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="100">活动名称：</td>
                            <td align="left" bgcolor="#FFFFFF"><input name="title" type="text" value="<?php echo $rows['title']; ?>" size="25" /></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">活动状态：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="radio" name="show" value="true"<?php echo $type!='hide'?' checked="true"':''; ?>/>显示&nbsp;&nbsp;<input type="radio" name="show" value="false"<?php echo $type=='hide'?' checked="true"':''; ?>/>隐藏</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="150">活动排序：</td>
                            <td align="left" bgcolor="#FFFFFF"><input name="order" type="text" value="<?php echo stripcslashes($rows['content'][2]); ?>" size="10" /> * 数值越大越靠前</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">活动顶图：</td>
                            <td align="left" bgcolor="#FFFFFF" class="set-image"><span class="img"><?php echo !isset($rows['content'][0])||empty($rows['content'][0])?'未设置':'<input type="hidden" name="image" value="'.$rows['content'][0].'"><img src="'.$rows['content'][0].'" style="max-height:100px">'; ?></span><br /><input type="button" value="设置新图片">&nbsp;<span style="color:red">* 所有活动顶图的比例应当相同</span></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">活动详情：</td>
                            <td align="left" bgcolor="#FFFFFF"><textarea id="content" name="content" style="width:100%;min-height:600px;"><?php echo stripcslashes($rows['content'][1]); ?></textarea></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="submit" class="submit80" value="保存" /></td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</div>
</body>
</html>