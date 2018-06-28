<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('xtgl');

$mobile_config = [];
$stmt = $mydata1_db->prepare('SELECT `content` FROM `webinfo` WHERE `code`=?');
$stmt->execute(['mobile-config']);
if($rows = $stmt->fetchColumn()){
    $mobile_config = unserialize($rows);
}else{
    $stmt = $mydata1_db->prepare('INSERT INTO `webinfo` (`code`, `title`, `content`) VALUES (?, ?, ?)');
    $stmt->execute(['mobile-config', '手机版设置', 'a:0:{}']);
}

if(!empty($_POST)&&$_POST['action']=='save'){
    $keys = ['logo', 'tips', 'icon', 'template', 'custom', 'color'];
    foreach($keys as $key){
        if(isset($_POST[$key])&&!empty($_POST[$key])){
            if($key=='tips'||$key=='custom'){
                $mobile_config[$key] = $_POST[$key]=='true';
            }else if($key=='template'){
                if(in_array($_POST[$key], ['magic', 'red', 'yellow', 'green', 'gray'])){
                    $mobile_config[$key] = $_POST[$key];
                }else{
                    $mobile_config[$key] = 'blue';
                }
            }else{
                $mobile_config[$key] = $_POST[$key];
            }
        }else if($key=='custom'){
            $mobile_config[$key] = '';
        }
    }
    $stmt = $mydata1_db->prepare('UPDATE `webinfo` SET `content`=? WHERE `code`=?');
    $stmt->execute([serialize($mobile_config), 'mobile-config']);
    admin::insert_log($_SESSION['adminid'], '修改了手机版设置信息');
    message('保存成功');
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
        .selected {background-color:#aee0f7}
    </style>
    <script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
    <script src="colpick/colpick.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8" src="../js/layer/layer.js"></script>
    <link rel="stylesheet" href="colpick/colpick.css" type="text/css"/>
    <script type="text/javascript">
        $(document.body).ready(function(){
            var color = $(".top-bar-color"), openUpload = function(){
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
            color.find("button").colpick({
                submitText: '确定',
                onSubmit: function(value){
                    value = '#'+$.colpick.hsbToHex(value);
                    // color.find("div").css("backgroundColor", value);
                    color.find("button").colpickHide();
                    color.find("input[type=hidden]").val(value);
                }
            });
            $(".set-logo, .set-icon").on("click", "input[type=button]", function () {
                var e = $(this), i = openUpload();
                window.onMessage = function(image){
                    e.siblings("span.img").html('<input type="hidden" name="'+e.data("name")+'" value="'+image+'"><img src="'+image+'" style="max-height:45px">');
                    layer.close(i)
                };
            })
        });
    </script>
</head>
<body>
<div id="pageMain">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td valign="top">
                <form action="setting.php" method="POST">
                    <input type="hidden" name="action" value="save" />
                    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                        <tr>
                            <td align="center" bgcolor="#3C4D82" style="color:#FFF" colspan="2"><strong>手机版设置</strong></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="150">手机版LOGO：</td>
                            <td align="left" bgcolor="#FFFFFF" class="set-logo"><span class="img"><?php echo !isset($mobile_config['logo'])||empty($mobile_config['logo'])?'未设置':'<input type="hidden" name="logo" value="'.$mobile_config['logo'].'"><img src="'.$mobile_config['logo'].'" style="max-height:45px">'; ?></span><br /><input type="button" value="设置新图片" data-name="logo"></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">iOS添加到主屏幕提示：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="radio" name="tips" value="false"<?php echo !isset($mobile_config['tips'])||empty($mobile_config['tips'])||!$mobile_config['tips']?' checked="true"':''; ?>/>关闭&nbsp;&nbsp;<input type="radio" name="tips" value="true"<?php echo isset($mobile_config['tips'])&&!empty($mobile_config['tips'])&&$mobile_config['tips']?' checked="true"':''; ?>/>开启</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">iOS主屏幕图标：</td>
                            <td align="left" bgcolor="#FFFFFF" class="set-icon"><span class="img"><?php echo !isset($mobile_config['icon'])||empty($mobile_config['icon'])?'未设置':'<input type="hidden" name="icon" value="'.$mobile_config['icon'].'"><img src="'.$mobile_config['icon'].'" style="max-height:45px">'; ?></span><br /><input type="button" value="设置新图片" data-name="icon">&nbsp;<span style="color:red">* 图片尺寸为正方形并且不小于114px × 114px，</span></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">手机版模板：</td>
                            <td align="left" bgcolor="#FFFFFF">
                                <select name="template">
                                    <option value="blue">蓝色模板</option>
                                    <option value="red"<?php echo isset($mobile_config['template'])&&$mobile_config['template']=='red'?' selected="true"':''; ?>>红色模板</option>
                                    <option value="yellow"<?php echo isset($mobile_config['template'])&&$mobile_config['template']=='yellow'?' selected="true"':''; ?>>黄色模板</option>
                                    <option value="green"<?php echo isset($mobile_config['template'])&&$mobile_config['template']=='green'?' selected="true"':''; ?>>绿色模板</option>
                                    <option value="gray"<?php echo isset($mobile_config['template'])&&$mobile_config['template']=='gray'?' selected="true"':''; ?>>灰色模板</option>
                                    <option value="magic"<?php echo isset($mobile_config['template'])&&$mobile_config['template']=='magic'?' selected="true"':''; ?>>魔幻主题</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">自定义顶栏颜色：</td>
                            <td align="left" bgcolor="#FFFFFF" class="top-bar-color"><input type="hidden" name="color" value="<?php echo isset($mobile_config['color'])?$mobile_config['color']:''; ?>"><input type="checkbox" name="custom" value="true"<?php echo isset($mobile_config['custom'])&&$mobile_config['custom']?' checked="true"':''; ?>> 开启自定义颜色 <button value="<?php echo isset($mobile_config['color'])?$mobile_config['color']:''; ?>">打开颜色选择器</button></td>
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