<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('xtgl');

$links = include('../../cj/include/mobile.links.php');
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
    if(isset($_POST['gameList'])&&is_array($_POST['gameList'])){
        $mobile_config['hotGame'] = $_POST['gameList'];
    } else {
        $mobile_config['hotGame'] = $links['hot'];
    }
    $stmt = $mydata1_db->prepare('UPDATE `webinfo` SET `content`=? WHERE `code`=?');
    $stmt->execute([serialize($mobile_config), 'mobile-config']);
    admin::insert_log($_SESSION['adminid'], '修改了手机版首页链接排序');
    message('保存成功');
    exit;
}else if(isset($_GET['action'])&&$_GET['action']=='reset'){
    $mobile_config['hotGame'] = $links['hot'];
    $stmt = $mydata1_db->prepare('UPDATE `webinfo` SET `content`=? WHERE `code`=?');
    $stmt->execute([serialize($mobile_config), 'mobile-config']);
    admin::insert_log($_SESSION['adminid'], '恢复手机版首页链接为默认排序');
    message('已恢复为默认排序');
    exit;
}
if (! array_key_exists('hotGame', $mobile_config)) {
    $mobile_config['hotGame'] = $links['hot'];
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
    <script type="text/javascript">
        $(document.body).ready(function(){
            $("input[data-action]").on("click", function () {
                var t = $(this), l = $("select[name='gameList[]']"), k, n, s;
                switch (t.data('action')){
                    case 'add':
                        k = t.data("key");
                        n = t.data("name");
                        if (l.find("[value='" + k + "']").size() > 0) {
                            alert("「" +n + "」已经设置为热门游戏！");
                            l.find("[value='" + k + "']").prop("selected", true);
                        } else {
                            l.append('<option value="' + k + '">' + n + '</option>');
                        }
                        t.prop("disabled", true);
                        break;
                    case 'up':
                        t = l.find("option:selected");
                        t.each(function () {
                            k = $(this);
                            n = k.prev('option').not(":selected");
                            if (n.size() > 0) {
                                k.insertBefore(n);
                            }
                        });
                        break;
                    case 'down':
                        t = $(l.find("option").get().reverse());
                        s = t.filter(":selected").size();
                        t.filter(":selected").each(function (i) {
                            k = $(this);
                            n = k.next('option').not(":selected");
                            if (n.size() > 0) {
                                k.insertAfter(n);
                            }
                        });
                        break;
                    case 'remove':
                        l = l.find("option:selected");
                        n = l.size();
                        if (n > 0) {
                            l.each(function () {
                                t = $(this);
                                k = $(this).val();
                                $("input[data-key='" + k + "']").prop("disabled", false);
                                t.remove();
                            });
                            alert(n == 1 ? "已移除所选游戏" : "已移除 " + n + " 个游戏");
                        } else {
                            alert("请选择需要移除的游戏");
                        }
                        break;
                    case 'reset':
                        if (confirm('确定要恢复为默认排序？')) {
                            window.location.href = '?action=reset';
                        }
                        break;
                    case 'submit':
                        l = l.find("option");
                        if (l.size() > 0) {
                            l.prop("selected", true);
                            return true;
                        } else {
                            alert("至少需要添加一个");
                            return false;
                        }
                        break;
                }
            });
        });
    </script>
</head>
<body>
<div id="pageMain">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td valign="top">
                <form action="order.php" method="POST">
                    <input type="hidden" name="action" value="save" />
                    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                        <tr>
                            <td align="center" bgcolor="#3C4D82" style="color:#FFF" colspan="4"><strong>首页链接排序</strong></td>
                        </tr>
<?php
$names = [];
foreach($links['manage'] as $key => $name){
    $count = count($links[$key]);
    $i = 0;
    foreach ($links[$key] as $k => $v){
        $k = $key.'.'.$k;
        $end = $i + 1 == $count;
        $names[$k] = $name.'：'.$v['name'];
        $fmod = fmod($i, 3);
        if ($fmod == 0) {
            ?>                        <tr>
<?php
        }
        if ($i == 0) {
            ?>                            <td align="right" bgcolor="#F0FFFF" width="150" rowspan="<?php echo ceil($count/3); ?>"><?php echo $name; ?>：</td>
<?php
        }
        ?>                            <td align="left" bgcolor="#FFFFFF" class="set-logo" colspan="<?php echo $end ? 3 - $fmod : 1; ?>">
                                <span><?php echo $v['name']; ?></span>
                                <input type="button" value="加入到热门游戏" data-key="<?php echo $k; ?>" data-name="<?php echo $name.'：'.$v['name']; ?>" data-action="add" <?php echo in_array($k, $mobile_config['hotGame']) ? ' disabled="true"' : ''; ?> />
                            </td>
<?php
        if ($fmod + 1 == 3 || $end) {
            ?>                        </tr>
<?php }$i++;}} ?>                        <tr>
                            <td align="right" bgcolor="#FFFFFF" rowspan="2">热门游戏排序：</td>
                            <td align="left" bgcolor="#FFFFFF" colspan="3">
                                <select name="gameList[]" size="10" multiple="multiple" style="width:100%">
<?php foreach ($mobile_config['hotGame'] as $key) { ?>                                    <option value="<?php echo $key; ?>"><?php echo $names[$key]; ?></option>
<?php } ?>                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" bgcolor="#FFFFFF" colspan="3">
                                <input type="button" value="上移" data-action="up">
                                <input type="button" value="下移" data-action="down">
                                <input type="button" value="从热门游戏移除" data-action="remove">
                                <input type="button" value="恢复默认排序" data-action="reset">
                                <span>按住 Ctrl 或 Command 多选</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
                            <td align="left" bgcolor="#FFFFFF" colspan="3"><input type="submit" data-action="submit" class="submit80" value="保存" /></td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</div>
</body>
</html>