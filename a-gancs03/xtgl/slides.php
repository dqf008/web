<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('xtgl');

$rootPath = str_replace('\\', '/', dirname(dirname(dirname(__FILE__))));
$type = array('mobile' => '手机', 'web' => '电脑');
!(isset($_GET['type'])&&in_array($_GET['type'], array_keys($type)))&&$_GET['type'] = 'web';
$type_name = $type[$_GET['type']];
$params = array(':code' => 'slides-'.$_GET['type']);
$stmt = $mydata1_db->prepare('SELECT * FROM `webinfo` WHERE `code`=:code');
$stmt->execute($params);
if($stmt->rowCount()>0){
    $rows = $stmt->fetch();
    $slides = unserialize($rows['content']);
}else{
    $slides = array();
    $params[':title'] = $type_name.'图片轮播';
    $params[':content'] = 'a:0:{}';
    $stmt = $mydata1_db->prepare('INSERT INTO `webinfo` (`code`, `title`, `content`) VALUES (:code, :title, :content)');
    $stmt->execute($params);
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $maxSize = 2*1024*1024; //文件最大尺寸，单位Byte
    $allowFiles = array('.gif', '.png', '.jpg', '.jpeg', '.bmp'); //允许的文件格式
    $savePath = '/static/uploads/'.date('Ymd/'); //文件保存路径

    echo '<script type="text/javascript">parent.';
    if(empty($_FILES)){
        echo 'onMessage("请选择需要上传的文件")';
    }else{
        foreach($_FILES as $key=>$val){
            $val['ext'] = strrpos($val['name'], '.');
            if($val['ext']!==false){
                $val['ext'] = substr($val['name'], -1*(strlen($val['name'])-$val['ext']));
                $val['save'] = $savePath.time().$val['ext'];
            }
            switch (true) {
                case !isset($val['name'])||empty($val['name']):
                    echo 'onMessage("表单错误")';
                    break;

                case !in_array($val['ext'], $allowFiles):
                    echo 'onMessage("文件类型不正确")';
                    break;

                case $val['size']>$maxSize:
                    echo 'onMessage("文件超过上传限制")';
                    break;

                case !file_exists($rootPath.$savePath)&&!mkdir($rootPath.$savePath):
                    echo 'onMessage("创建文件夹失败")';
                    break;

                case !move_uploaded_file($val['tmp_name'], $rootPath.$val['save']):
                    echo 'onMessage("文件保存失败")';
                    break;

                default:
                    $slides[] = array('img' => $val['save']);
                    unset($params[':title']);
                    $params[':content'] = serialize($slides);
                    $stmt = $mydata1_db->prepare('UPDATE `webinfo` SET `content`=:content WHERE `code`=:code');
                    $stmt->execute($params);
                    admin::insert_log($_SESSION['adminid'], '上传了一张'.$type_name.'轮播图，<a href="'.$val['save'].'" target="_blank">查看图片</a>');
                    echo 'onSuccess("'.$val['save'].'")';
                    break;
            }
        }
    }
    echo '</script>';
    exit;
}

if(isset($_GET['action'])&&in_array($_GET['action'], array('delete', 'up', 'down'))){
    !isset($_GET['key'])&&$_GET['key'] = -1;
    $key = (int)$_GET['key'];
    if(in_array($_GET['key'], array_keys($slides))){
        switch ($_GET['action']) {
            case 'delete':
                admin::insert_log($_SESSION['adminid'], '删除了一张'.$type_name.'轮播图');
                $msg = '删除成功！';
                //if(isset($slides[$key])||isset($slides[$key]['img'])){
                    is_file($rootPath.$slides[$key]['img'])&&unlink($rootPath.$slides[$key]['img']);
                    unset($slides[$key]);
                //}
                break;
            default:
                $msg = '移动失败！';
                if($_GET['action']=='up'&&$_GET['key']>0){

                    $temp1 = $slides[$_GET['key']-1];
                    $slides[$_GET['key']-1] = $slides[$_GET['key']];
                    $slides[$_GET['key']] = $temp1;
                    $msg = '上移成功！';
                }else if($_GET['action']=='down'&&$_GET['key']<count($slides)-1){
                    $temp1 = $slides[$_GET['key']+1];
                    $slides[$_GET['key']+1] = $slides[$_GET['key']];
                    $slides[$_GET['key']] = $temp1;
                    $msg = '下移成功！';
                }
                break;

        }
        unset($params[':title']);
        $slides = array_values($slides);
        $params[':content'] = serialize($slides);
        $stmt = $mydata1_db->prepare('UPDATE `webinfo` SET `content`=:content WHERE `code`=:code');
        $stmt->execute($params);
    }else{
        $msg = '操作失败！';
    }
    message($msg);
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>轮播图片</title>
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
    <script type="text/javascript" src="/js/jquery.js"></script> 
    <script type="text/javascript">
        function onSubmit(e){
            var r = false, f = $(e).children("input[type=file]").val(), i = -1;
            if(f==""){
                alert("请选择文件！");
            }else{
                i = f.lastIndexOf(".");
                if(i<0){
                    alert("文件格式不正确！");
                }else{
                    f = f.substring(i);
                    if(f!=".jpg"&&f!=".jpeg"&&f!=".gif"&&f!=".png"&&f!=".bmp"){
                        alert("仅支持jpg、gif、png或bmp文件！");
                    }else{
                        r = true;
                    }
                }
            }
            if(r){
                $("#upload").hide().siblings("#uploading").show();
            }else{
                $(e).children("input[type=file]").val("");
            }
            return r;
        }
        function onSuccess(i){
            window.location.reload();
        }
        function onMessage(m){
            alert(m);
            $("#uploading").hide().siblings("#upload").show();
        }
    </script>
</head>
<body>
    <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tbody>
            <tr>
                <td height="24" nowrap="" background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle" />&nbsp;<?php echo $type_name; ?>图片轮播</td>
            </tr>
            <tr>
                <td height="24" align="center" nowrap="" bgcolor="#FFFFFF">
                    <table width="90%" align="center" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse:collapse;color:#225d9c">
<?php foreach($slides as $key=>$val){ ?>                        <tr>
                            <td style="padding:5px" align="center"><img src="<?php echo $val['img']; ?>" style="max-width:100%" /></td>
                            <td style="padding:5px" bgcolor="#F0FFFF" align="center" width="70">
                                <input type="button" value="上移" onclick="window.location.href='?type=<?php echo $_GET['type']; ?>&amp;action=up&amp;key=<?=$key?>'" /><br />
                                <input type="button" value="删除" style="margin:5px" onclick="if(confirm('确定删除该图片？')){window.location.href='?type=<?php echo $_GET['type']; ?>&amp;action=delete&amp;key=<?=$key?>'}" /><br />
                                <input type="button" value="下移" onclick="window.location.href='?type=<?php echo $_GET['type']; ?>&amp;action=down&amp;key=<?=$key?>'" />
                            </td>
                        </tr>
<?php } ?>                        <tr id="upload">
                            <td align="center" style="padding:5px" colspan="2">
                                <form action="slides.php?type=<?php echo $_GET['type']; ?>" method="post" enctype="multipart/form-data" style="margin:0" onsubmit="return onSubmit(this)" target="update_back">
                                    <input type="file" name="slidesUpload" /> 
                                    <input type="submit" value="添加" />
                                    <span style="color:red">* 图片需要比例相同</span>
                                </form>
                                <iframe src="about:blank" name="update_back" style="display:none"></iframe>
                            </td>
                        </tr>
                        <tr id="uploading" style="display:none">
                            <td align="center" style="padding:5px" colspan="2"><span style="background:url(/m/js/images/ajax-loader.gif) left center no-repeat;padding:5px 0 5px 18px;line-height:20px">正在上传，请稍后...</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>