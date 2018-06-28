<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('xtgl');
if($_SERVER['REQUEST_METHOD']=='POST'){
    $rootPath = str_replace('\\', '/', dirname(dirname(dirname(__FILE__))));
    $maxSize = 2*1024*1024; //文件最大尺寸，单位Byte
    $allowFiles = array('.gif', '.png', '.jpg', '.jpeg', '.bmp'); //允许的文件格式
    $savePath = '/static/uploads/'.date('Ymd/'); //文件保存路径

    echo '<script type="text/javascript">';
    if(empty($_FILES)){
        echo 'alert("请选择需要上传的文件")';
    }else{
        foreach($_FILES as $key=>$val){
            $val['ext'] = strrpos($val['name'], '.');
            if($val['ext']!==false){
                $val['ext'] = substr($val['name'], -1*(strlen($val['name'])-$val['ext']));
                $val['save'] = $savePath.time().$val['ext'];
            }
            switch (true) {
                case !isset($val['name'])||empty($val['name']):
                    echo 'alert("表单错误")';
                    break;

                case !in_array($val['ext'], $allowFiles):
                    echo 'alert("文件类型不正确")';
                    break;

                case $val['size']>$maxSize:
                    echo 'alert("文件超过上传限制")';
                    break;

                case !file_exists($rootPath.$savePath)&&!mkdir($rootPath.$savePath):
                    echo 'alert("创建文件夹失败")';
                    break;

                case !move_uploaded_file($val['tmp_name'], $rootPath.$val['save']):
                    echo 'alert("文件保存失败")';
                    break;

                default:
                    echo 'window.parent.onMessage&&window.parent.onMessage("'.$val['save'].'")';
                    break;
            }
        }
    }
    echo ';window.history.back()</script>';
    exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Welcome</title>
    <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" />
    <script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
    <script type="text/javascript">
        $(document.body).ready(function(){
            $("form").on("submit", function(){
                var e = $(this), f = e.find("input[type=file]").val(), l = !f?0:f.length, a = l>4?f.substring(l-4, l):'';
                if(!f){
                    alert("请选择图片");
                    return false;
                }else if(a!='.png'&&a!='.jpg'&&a!='.gif'&&a!='.bmp'){
                    alert("只能选择png、jpg、gif或bmp图片文件");
                    return false;
                }else{
                    return true;
                }
            })
        });
    </script>
</head>
<body style="border:none">
<div id="pageMain">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td valign="top">
                <form action="images.php" method="POST" enctype="multipart/form-data">
                    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                        <tr>
                            <td align="left" bgcolor="#FFFFFF" class="top-bar-color"><input type="file" name="images"></td>
                        </tr>
                        <tr>
                            <td align="left" bgcolor="#FFFFFF"><input type="submit" class="submit80" value="上传" /></td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</div>
</body>
</html>