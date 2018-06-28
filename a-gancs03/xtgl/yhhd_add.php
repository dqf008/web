<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('xtgl');

$isShow = true;
$type = '';
$_GET['id'] = isset($_GET['id'])?intval($_GET['id']):0;
$_GET['action'] = isset($_GET['action'])?intval($_GET['action']):'default';
if($_GET['id']>0){
    $stmt = $mydata1_db->prepare('SELECT * FROM `webinfo` WHERE (`code`=? OR `code`=?) AND `id`=?');
    $stmt->execute(['promotions-hide','promotions', $_GET['id']]);
    if($rows = $stmt->fetch()){
        $rows['content'] = unserialize($rows['content']);
        $isShow = $rows['code']=='promotions';
        $rows['add'] = false;
        $type = $rows['content'][3];
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
    $_POST['content1'] = isset($_POST['content1'])&&!empty($_POST['content1'])?preg_replace('/src="https?:\/\/'.str_replace('.', '\\.', $_SERVER['HTTP_HOST']).'(\/[^"]+)"/', 'src="$1"', $_POST['content1']):'';
    $_POST['content2'] = isset($_POST['content2'])&&!empty($_POST['content2'])?preg_replace('/src="https?:\/\/'.str_replace('.', '\\.', $_SERVER['HTTP_HOST']).'(\/[^"]+)"/', 'src="$1"', $_POST['content2']):'';
    $_POST['title'] = isset($_POST['title'])?$_POST['title']:'';
    $params = [
            !isset($_POST['show'])||$_POST['show']=='false'?'promotions-hide':'promotions',
            $_POST['title'],
            serialize([
                $_POST['content1'],
                $_POST['content2'],
                isset($_POST['order'])?intval($_POST['order']):0,
                isset($_POST['type'])?trim($_POST['type']):''
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
    admin::insert_log($_SESSION['adminid'], ($rows['add']?'添加':'编辑').'优惠活动['.$_POST['title'].']');
    message(($rows['add']?'添加':'编辑').'优惠活动成功！');
    exit;
}
$hotTypePath = $_SERVER['DOCUMENT_ROOT'].'/cache/hotType.php';
if(file_exists($hotTypePath)){
    $hotTypes = json_decode(file_get_contents($hotTypePath), true);
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
</head>
<body>
<div id="pageMain">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td valign="top">
                <form action="yhhd_add.php?id=<?php echo $_GET['id']; ?>&amp;action=save" method="POST">
                    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                        <tr>
                            <td align="center" bgcolor="#3C4D82" style="color:#FFF" colspan="2"><strong><?php echo $rows['add']?'添加':'编辑'; ?>优惠活动</strong></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="100">活动名称：</td>
                            <td align="left" bgcolor="#FFFFFF"><input name="title" type="text" value="<?php echo $rows['title']; ?>" size="25" /></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">活动状态：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="radio" name="show" value="true" <?=$isShow?'checked="true"':''?>/>显示&nbsp;&nbsp;<input type="radio" name="show" value="false" <?=!$isShow?'checked="true"':''?>/>隐藏</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="150">活动排序：</td>
                            <td align="left" bgcolor="#FFFFFF"><input name="order" type="text" value="<?php echo stripcslashes($rows['content'][2]); ?>" size="10" /> * 数值越大越靠前</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="150">活动类别：</td>
                            <td align="left" bgcolor="#FFFFFF">
                                <select name="type">
                                    <option value="">无</option>
                                    <?php foreach($hotTypes as $v):?>
                                    <option value="<?=$v['title']?>" <?=$type==$v['title']?"selected='selected'":""?> ><?=$v['title']?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">活动简介：</td>
                            <td align="left" bgcolor="#FFFFFF"><textarea id="content1" name="content1" style="width:980px;height:240px;"><?php echo stripcslashes($rows['content'][0]); ?></textarea></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">活动详情：</td>
                            <td align="left" bgcolor="#FFFFFF"><textarea id="content2" name="content2" style="width:100%;min-height:600px;"><?php echo stripcslashes($rows['content'][1]); ?></textarea></td>
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