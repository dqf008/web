<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
include $_SERVER['DOCUMENT_ROOT'] . '/class/Db.class.php';
check_quanxian('xtgl');

if(!empty($_GET['action']) && $_GET['id'] > 0 ){
    $id = (int)$_GET['id'];
    $db = new DB();
    $info = $db->row('SELECT * FROM `webinfo` WHERE `code` like "promotions%" AND `id`=:id',['id'=>$id]);
    switch (false){
        case !empty($info):
            message('活动不存在，请刷新页面重试！');
            break;

        case !($_GET['action']=='delete'):
            $db->query('DELETE FROM `webinfo` WHERE `id`=:id',['id'=>$id]);
            admin::insert_log($_SESSION['adminid'], '删除了优惠活动['.$info['title'].']');
            message('优惠活动删除成功！');
            break;

        case !($_GET['action']=='hide'):
            $db->query('UPDATE `webinfo` SET `code`="promotions-hide" WHERE `id`=:id',['id'=>$id]);
            admin::insert_log($_SESSION['adminid'], '隐藏了优惠活动['.$info['title'].']');
            message('优惠活动隐藏成功！');
            break;

        case !($_GET['action']=='show'):
            $db->query('UPDATE `webinfo` SET `code`="promotions" WHERE `id`=:id',['id'=>$id]);
            admin::insert_log($_SESSION['adminid'], '显示了优惠活动['.$info['title'].']');
            message('优惠活动显示成功！');
            break;
    }
    exit;
}
$hotTypePath = $_SERVER['DOCUMENT_ROOT'].'/cache/hotType.php';
if(!empty($_GET['act'])){
    $hotTypes = json_decode(file_get_contents($hotTypePath), true);
    $type = trim($_POST['type']);
    $sort = (int)$_POST['sort'];
    if($_GET['act'] == 'add'){
        $exist = false;
        foreach($hotTypes as $k=>$v){
            if($v['title'] == $type) $exist = true;
        }
        $exist || $hotTypes[] = ['title'=>$type,'sort'=>$sort];
    }else if($_GET['act'] == 'del'){
        foreach($hotTypes as $k=>$v){
            if($v['title'] == $type){
                unset($hotTypes[$k]);
                break;
            }
        }
        $db = new DB();
        $list = $db->query('select id,content from webinfo where code like "promotions%"');
        foreach($list as $row){
            $info = unserialize($row['content']);
            if($info[3] == $type){
                $info[3] = '';
                $row['content'] = serialize($info);
                $db->query('update webinfo set content=:content where id=:id',$row);
            }
        }
    }else if($_GET['act'] == 'change'){
        $new = trim($_POST['newtype']);
        foreach($hotTypes as $k=>$v){
            if($v['title'] == $type){
                $hotTypes[$k]['title'] = $new;
                $hotTypes[$k]['sort'] = $sort;
                break;
            }
        }
        $db = new DB();
        $list = $db->query('select id,content from webinfo where code like "promotions%"');
        foreach($list as $row){
            $info = unserialize($row['content']);
            if($info[3] == $type){
                $info[3] = $new;
                $row['content'] = serialize($info);
                $db->query('update webinfo set content=:content where id=:id',$row);
            }
        }
    }else if($_GET['act'] == 'menu'){
        $path = $_SERVER['DOCUMENT_ROOT'].'/cache/hottype';
        if(file_exists($path)){
            unlink($path);
        }else{
            file_put_contents($path,'');
        }
        die();
    }
    foreach($hotTypes as $k=>$v) $hotTypes[$k]['sort'] = (int)$v['sort'];
    usort($hotTypes, function($a, $b){
        $a = (int)$a['sort'];
        $b = (int)$b['sort'];
        if ($a == $b) return 0;
        return ($a > $b) ? -1 : 1;
    });

    file_put_contents($hotTypePath, json_encode($hotTypes));
    die();
}
$hotList = [];
$code = $_GET['type']=='hide'?'promotions-hide':'promotions';
$db = new DB();
$list = $db->query('SELECT * FROM `webinfo` WHERE `code`=:code',['code'=>$code]);
foreach ($list as $rows) {
    $info = unserialize($rows['content']);
    $rows['sort'] = $info[2];
    $rows['type'] = $info[3];
    $hotList[] = $rows;
}
usort($hotList, function($a, $b){
    $a = (int)$a['sort'];
    $b = (int)$b['sort'];
    if ($a == $b) return 0;
    return ($a > $b) ? -1 : 1;
});
if(file_exists($hotTypePath)){
    $hotTypes = json_decode(file_get_contents($hotTypePath), true);
}else{
    $hotTypes = [
        ["title"=>"真人活动"],
        ['title'=>'电子活动'],
        ['title'=>'彩票活动'],
        ['title'=>'历史活动']
    ];
    file_put_contents($hotTypePath, json_encode($hotTypes));
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
        .hotType > div {display: inline-block;border: 1px solid #000; padding: 0px 10px;padding-right: 20px;position: relative;}
        .hotType .close {display: inline-block;position: absolute;right: 5px;}
        .hotTypeChange:hover, .hotType .type:hover, .hotType .close:hover{color:red;cursor: pointer;}
    </style>
    <script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/skin/layer/layer.js"></script>
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
                        <td align="center" bgcolor="#3C4D82" style="color:#FFF">
                        <strong>优惠活动分类</strong>&nbsp;
                        [<span class="hotTypeChange"><?=file_exists($_SERVER['DOCUMENT_ROOT'].'/cache/hottype')?'显示':'隐藏'?></span>]
                        </td>
                    </tr>
                    <tr>
                        <td class="hotType" align="center" bgcolor="#FFF" style="color:#000">
                            <?php foreach($hotTypes as $type):?>
                                <div><span sort="<?=$type['sort']?>" class="type"><?=$type['title']?></span><span class="close">x</span></div>
                            <?php endforeach;?>
                            <button type="button" style="float:right" class="addtype">添加</button>
                        </td>
                    </tr>
                </table>
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                    <tr>
                        <td align="center" bgcolor="#3C4D82" style="color:#FFF"><strong>优惠活动</strong></td>
                    </tr>
                    <tr>
                        <td align="center" bgcolor="#FFFFFF" style="color:#000">
                        <a href="?type=show" class="<?=$_GET['type']!='hide'?'sub_curr':'sub_com'?>">已显示活动</a> - 
                        <a href="?type=hide" class="<?=$_GET['type']=='hide'?'sub_curr':'sub_com'?>">已隐藏活动</a> - 
                        <a href="yhhd_add.php" class="sub_com">添加优惠活动</a></td>
                    </tr>
                </table>
                <table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                    <tr style="background-color:#3C4D82;color:#FFF">
                        <td height="22" align="center"><strong>排序</strong></td>
                        <td height="22" align="center"><strong>活动名称</strong></td>
                        <td height="22" align="center"><strong>活动类别</strong></td>
                        <td height="22" align="center"><strong>操作</strong></td>
                    </tr>
                    <?php foreach($hotList as $info):?>							
                        <tr style="background-color:#FFFFFF;line-height:20px;" class="data-list">
                            <td align="center"><?=$info['sort']?></td>
                            <td align="center"><a href="yhhd_add.php?id=<?=$info['id']?>&action=edit"><?=$info['title']?></a></td>
                            <td align="center"><?=$info['type']?></td>
                            <td align="center">
                                <?php if($_GET['type']=='hide'):?>
                                <a href="?id=<?=$info['id']?>&action=show" onclick="return confirm('确定要显示该优惠活动吗？');">显示</a>
                                <?php else:?>
                                <a href="?id=<?=$info['id']?>&action=hide" onclick="return confirm('确定要隐藏该优惠活动吗？');">隐藏</a>
                                <?php endif;?>
                                <a href="yhhd_add.php?id=<?=$info['id']?>&action=edit">编辑</a>
                                <a href="?id=<?=$info['id']?>&action=delete" onclick="return confirm('确定要删除该优惠活动吗？删除后将不能恢复！');">删除</a>
                            </td>
                        </tr>
                    <?php endforeach;?>						
                </table>
            </td>
        </tr>
    </table>
</div>
<style>
.layui-layer-content {padding:10px;}
.layui-layer-content input {border: 1px solid #CCC;height: 30px;font-weight: bold;font-size: 16px;padding-left: 10px;width: 280px}
</style>
<script>
function operation(id){
    var type = '<?=$_GET['type']?>';
}
$('.hotTypeChange').click(function(){
    $.get('?act=menu',function(){
        alert('修改成功')
        location.reload();
    })
})
$('.hotType .close').click(function(){
    var type = $(this).prev().html();
    if(confirm('确定要删除['+type+']分类？')){
        $.post('?act=del',{type:type},function(){
            alert('删除成功')
            location.reload();
        })
    }
})
$('.hotType .type').click(function(){
    var type = $(this).html();
    var sort = $(this).attr('sort')
    layer.open({
        type: 1,
        id: 'addtype',
        title: "修改优惠活动分类",
        area: ["400px","200px"],
        shadeClose: true,
        content: '<table><tr><td>分类名字:</td><td><input id="type" ></td></tr><tr><td>排序:</td><td><input id="sort" ></td></tr></table>',
        btn: ['确认', '取消'],
        success: function(layero, index){
              $('#type').focus().val(type);
              $('#sort').val(sort)
          },
        yes: function (index, layero){
            $.post('?act=change',{type:type,sort:$('#sort').val(),newtype:$('#type').val()}, function(res){
                alert('保存成功')
                location.reload();
            });
        }
    });
});
$('.addtype').click(function(){
    layer.open({
        type: 1,
        id: 'addtype',
        title: "添加优惠活动分类",
        area: ["400px","200px"],
        shadeClose: true,
        content: '<table><tr><td>分类名字:</td><td><input id="type" ></td></tr><tr><td>排序:</td><td><input id="sort" ></td></tr></table>',
        btn: ['确认', '取消'],
        success: function(layero, index){
              $('#type').focus();
          },
        yes: function (index, layero){
            $.post('?act=add',{type:$('#type').val(),sort:$('#sort').val()}, function(res){
                alert('保存成功')
                location.reload();
            });
        }
    });
});
</script>
</body>
</html>