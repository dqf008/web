<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('xtgl');

$_GET['type'] = isset($_GET['type'])&&$_GET['type']=='hide'?'hide':'show';
$_GET['id'] = isset($_GET['id'])?intval($_GET['id']):0;
$_GET['action'] = isset($_GET['action'])?$_GET['action']:'default';

$params = [$_GET['type']=='hide'?'promotions-hide-m':'promotions-mobile'];
if(!empty($_GET['action'])&&$_GET['id']>0){
    $params[] = $_GET['id'];
    $stmt = $mydata1_db->prepare('SELECT * FROM `webinfo` WHERE `code`=? AND `id`=?');
    switch (false){
        case $stmt->execute($params):
        case $rows = $stmt->fetch():
            message('活动不存在，请刷新页面重试！');
            break;

        case !($_GET['action']=='delete'):
            $mydata1_db->prepare('DELETE FROM `webinfo` WHERE `id`=?')->execute([$_GET['id']]);
            admin::insert_log($_SESSION['adminid'], '删除了手机优惠活动['.$rows['title'].']');
            message('优惠活动删除成功！');
            break;

        case !($_GET['action']=='hide'):
            $mydata1_db->prepare('UPDATE `webinfo` SET `code`=? WHERE `id`=?')->execute(['promotions-hide-m', $_GET['id']]);
            admin::insert_log($_SESSION['adminid'], '隐藏了手机优惠活动['.$rows['title'].']');
            message('优惠活动隐藏成功！');
            break;

        case !($_GET['action']=='show'):
            $mydata1_db->prepare('UPDATE `webinfo` SET `code`=? WHERE `id`=?')->execute(['promotions-mobile', $_GET['id']]);
            admin::insert_log($_SESSION['adminid'], '显示了手机优惠活动['.$rows['title'].']');
            message('优惠活动显示成功！');
            break;
    }
    exit;
}else{
    $hotSort = [];
    $hotList = [];
    $stmt = $mydata1_db->prepare('SELECT * FROM `webinfo` WHERE `code`=?');
    $stmt->execute($params);
    while($rows = $stmt->fetch()){
        $rows['content'] = unserialize($rows['content']);
        $hotList[$rows['id']] = $rows;
        $sortKey = intval($rows['content'][2]);
        !isset($hotSort[$sortKey])&&$hotSort[$sortKey] = [];
        $hotSort[$sortKey][] = $rows['id'];
    }
    krsort($hotSort);

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
    <script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".data-list").on({
                mouseenter: function () {
                    $(this).css("backgroundColor", "#ebebeb");
                },
                mouseleave: function () {
                    $(this).css("backgroundColor", "#fff");
                }
            });
            $(".select-group").on("click", function(){
                var e = $(this);
                window.parent.onMessage&&window.parent.onMessage(e.data("id"), e.data("name"));
            })
        });
    </script>
</head>
<body>
<div id="pageMain">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td valign="top">
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                    <tr>
                        <td align="center" bgcolor="#3C4D82" style="color:#FFF"><strong>手机优惠活动</strong></td>
                    </tr>
                    <tr>
                        <td align="center" bgcolor="#FFFFFF" style="color:#000"><a href="?type=show" class="<?php echo $_GET['type']!='hide'?'sub_curr':'sub_com'; ?>">已显示活动</a> - <a href="?type=hide" class="<?php echo $_GET['type']=='hide'?'sub_curr':'sub_com'; ?>">已隐藏活动</a> - <a href="activity_add.php" class="sub_com">添加优惠活动</a></td>
                    </tr>
                </table>
                <table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                    <tr style="background-color:#3C4D82;color:#FFF">
                        <td height="22" align="center"><strong>排序</strong></td>
                        <td height="22" align="center"><strong>活动名称</strong></td>
                        <td height="22" align="center"><strong>操作</strong></td>
                    </tr>
                    <?php
                    foreach($hotSort as $key){
                    rsort($key);
                    foreach($key as $rs){
                        $rs = $hotList[$rs];
                        ?>							<tr style="background-color:#FFFFFF;line-height:20px;" class="data-list">
                            <td align="center"><?php echo $rs['content'][2]; ?></td>
                            <td align="center"><a href="activity_add.php?id=<?php echo $rs['id']; ?>&amp;action=edit&amp;type=<?php echo $_GET['type']; ?>"><?php echo $rs['title']; ?></a></td>
                            <td align="center">
                                <a href="?id=<?php echo $rs['id']; ?>&amp;action=<?php echo $_GET['type']=='hide'?'show&amp;type=hide':'hide&amp;type=show'; ?>" onclick="return confirm('确定要<?php echo $_GET['type']=='hide'?'显示':'隐藏'; ?>该优惠活动吗？');"><?php echo $_GET['type']=='hide'?'显示':'隐藏'; ?></a>
                                <a href="activity_add.php?id=<?php echo $rs['id']; ?>&amp;action=edit">编辑</a>
                                <a href="?id=<?php echo $rs['id']; ?>&amp;action=delete&amp;type=<?php echo $_GET['type']; ?>" onclick="return confirm('确定要删除该优惠活动吗？删除后将不能恢复！');">删除</a>
                            </td>
                        </tr>
                    <?php }} ?>						</table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>