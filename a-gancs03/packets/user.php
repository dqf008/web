<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
include_once '../../include/newPage.php';
check_quanxian("hbxt");

if(isset($_POST['action'])&&$_POST['action']=='save'&&isset($_POST['uid'])&&!empty($_POST['uid'])){
    $s_action = isset($_POST['s_action'])&&$_POST['s_action']=='1'?0:1;
    $ids = array();
    foreach($_POST['uid'] as $uid){
        $uid = intval($uid);
        if($uid>0){
            $stmt = $mydata1_db->prepare('SELECT `id` FROM `packets_config` WHERE `uid`=?');
            $stmt->execute(array($uid));
            if($stmt->rowCount()>0){
                $rows = $stmt->fetch();
                $ids[] = $rows['id'];
            }else{
                $mydata1_db->query('INSERT INTO `packets_config` (`uid`, `value`, `stop`) VALUES ('.$uid.', \'a:0:{}\', '.$s_action.')');
            }
        }
    }
    !empty($ids)&&$mydata1_db->query('UPDATE `packets_config` SET `stop`='.$s_action.' WHERE `id` IN ('.implode(', ', $ids).')');
    admin::insert_log($_SESSION['adminid'], '对会员['.implode(',', $_POST['uid']).']进行'.($s_action==1?'禁止':'允许').'领取红包');
    message('保存成功！', $_SERVER['HTTP_REFERER']);
}

$group = array();
$query = $mydata1_db->query('SELECT `id`, `name` FROM `k_group`');
while($rows = $query->fetch()){
    $group[$rows['id']] = $rows['name'];
    !isset($packets['group'][$rows['id']])&&$packets['group'][$rows['id']] = $packets['group'][0];
}
$gid = isset($_GET['gid'])&&in_array($_GET['gid'], array_keys($group))?$_GET['gid']:0;

$s_value = isset($_GET['s_value'])?$_GET['s_value']:'';
$s_type = isset($_GET['s_type'])?$_GET['s_type']:'';
$s_stop = isset($_GET['s_stop'])?$_GET['s_stop']:'0';
$thisPage = isset($_GET['page'])?$_GET['page']:'1';
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
    <script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="/js/calendar.js"></script>
    <script type="text/javascript">
        function updateUser(username, obj){
            $(obj).hide().siblings("span").html("<img src=\"../../Box/skins/icons/loading.gif\" />");
            $.ajax({
                url: "../../packets/ajax.php",
                dataType: "json",
                cache: false,
                type: "POST",
                data: {
                    action: "check",
                    username: username
                },
                success: function(data) {
                    $(obj).siblings("span").html('--');
                    switch (data['status']) {
                    case 99:
                        alert("活动开始后才能更新次数");
                        break;
                    case 98:
                        alert("更新失败：帐号不存在");
                        break;
                    case 97:
                        alert("更新失败：账号被停用或禁止领取");
                        break;
                    case 95:
                    case 94:
                        alert("更新失败：账号未满足条件");
                        break;
                    case 96:
                        data['score'] = 0;
                    case 0:
                        $(obj).siblings("span").html(data['score']);
                        // alert("更新成功：剩余"+data['score']+"次");
                        break;
                    default:
                        alert("网络错误，请稍后再试");
                        break;
                    }
                }
            });
        }
    </script>
</head>
<body>
    <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tbody>
            <tr>
                <td height="24" nowrap="" background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle" />&nbsp;红包系统：会员管理</td>
            </tr>
            <tr>
                <td height="24" align="center" nowrap="" bgcolor="#FFFFFF">
                    <form name="form1" method="GET" action="user.php">
                        <table width="455">
                            <tr>
                                <td>
                                    <span>内容：</span>
                                    <input type="text" name="s_value" value="<?php echo $s_value; ?>" />
                                    <span>类型：</span>
                                    <select name="s_type">
                                        <option value="login"<?php echo $s_type=='login'?' selected="true"':''; ?>>用户名</option>
                                        <option value="name"<?php echo $s_type=='name'?' selected="true"':''; ?>>真实姓名</option>
                                        <option value="agent"<?php echo $s_type=='agent'?' selected="true"':''; ?>>上级代理</option>
                                    </select>
                                    <input type="submit" value="查找"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
    <form name="form2" method="post" action="user.php" onsubmit="if($('input:checkbox').not(':first').filter(':checked').size()<=0){alert('请选择需要操作的会员账号！');return false}else if($('#s_action option:selected').val()=='0'){alert('请选择相关操作！');return false}else{return true}">
        <input type="hidden" name="action" value="save" />
        <table width="100%">
            <tr>
                <td width="104" align="center"><a href="user.php?s_stop=0">全部会员</a></td>
                <td width="104" align="center"><a href="user.php?s_stop=1&amp;gid=<?php echo $gid; ?>&amp;s_value=<?php echo $s_value; ?>&amp;s_type=<?php echo $s_type; ?>">禁领会员</a></td>
                <td width="104" align="center"><a href="user.php?s_stop=2&amp;gid=<?php echo $gid; ?>&amp;s_value=<?php echo $s_value; ?>&amp;s_type=<?php echo $s_type; ?>">正常会员</a></td>
                <td width="104" align="center"><select onchange="window.location.href='user.php?s_stop=<?php echo $s_stop; ?>&amp;s_value=<?php echo $s_value; ?>&amp;s_type=<?php echo $s_type; ?>&amp;gid='+$(this).children('option:selected').val()"><option value="0">全部会员组</option><?php foreach($group as $key=>$val){ ?><option value="<?php echo $key.($key==$gid?'" selected="true':''); ?>"><?php echo $val; ?></option><?php } ?></select></td>
                <td width="365" align="right">
                    <span style="color:red">相关操作：</span>
                    <select name="s_action" id="s_action">
                        <option value="0" selected="true">请选择</option>
                        <option value="1">允许领取</option>
                        <option value="2">禁止领取</option>
                    </select>
                    <input type="submit" value="执行" />
                </td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
            <tr>
                <td height="24" nowrap bgcolor="#FFFFFF">
                    <table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse:collapse;color:#225d9c">
                        <tr style="background-color:#EFE" align="center">
                            <td height="25"><strong>ID</strong></td>
                            <td><strong>登录名</strong></td>
                            <td><strong>真实姓名</strong></td>
                            <td><strong>当前余额</strong></td>
                            <td><strong>累积领取</strong></td>
                            <td><strong>剩余次数</strong></td>
                            <td><strong>账号类型</strong></td>
                            <td><strong>上级代理</strong></td>
                            <td><strong>会员组</strong></td>
                            <td><strong>状态</strong></td>
                            <td><strong>操作</strong></td>
                            <td><input type="checkbox" onclick="$('input:checkbox').attr('checked', $(this).is(':checked'))" /></td>
                        </tr>
<?php
$sql = '';
$params = array();
$agent = array();
$end = strtotime(date('Y-m-d'))-1;
if($s_stop=='1'){
    $sql.= ' AND (`u`.`is_stop`=1 OR `c`.`stop`=1)';
}else if($s_stop=='2'){
    $sql.= ' AND `u`.`is_stop`<>1 AND (`c`.`stop` IS NULL OR `c`.`stop`<>1)';
}
if($gid>0){
    $params[':gid'] = $gid;
    $sql.= ' AND `u`.`gid`=:gid';
}
if($s_value!=''){
    switch ($s_type) {
        case 'login':
            $params[':username'] = '%'.$s_value.'%';
            $sql.= ' AND `u`.`username` LIKE :username';
            break;
        case 'name':
            $params[':pay_name'] = '%'.$s_value.'%';
            $sql.= ' AND `u`.`pay_name` LIKE :pay_name';
            break;
        case 'agent':
            $stmt = $mydata1_db->prepare('SELECT `uid`, `username` FROM `k_user` WHERE `username`=? AND `is_delete`=0');
            $stmt->execute(array($s_value));
            if($stmt->rowCount()>0){
                $rows = $stmt->fetch();
                $agent[$rows['uid']] = $rows['username'];
                $sql.= ' AND `u`.`top_uid`='.$rows['uid'];
            }else{
                $sql.= ' AND 1=0';
            }
            break;
    }
}
$stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `sum` FROM `k_user` AS `u` LEFT JOIN `packets_config` AS `c` ON `u`.`uid`=`c`.`uid` WHERE `is_delete`=0'.$sql);
$stmt->execute($params);
$rows = $stmt->fetch();
$page = new newPage();
$thisPage = $page->check_Page($thisPage, $rows['sum'], 20, 40);
$params[':index'] = ($thisPage-1)*20;
$stmt = $mydata1_db->prepare('SELECT `u`.`uid`, `u`.`username`, `u`.`money`, `u`.`pay_name`, `u`.`is_daili`, `u`.`top_uid`, `u`.`gid`, `u`.`is_stop`, `c`.`money` AS `c_money`, `c`.`count`, `c`.`last`, `c`.`stop` FROM `k_user` AS `u` LEFT JOIN `packets_config` AS `c` ON `u`.`uid`=`c`.`uid` WHERE `u`.`is_delete`=0'.$sql.' ORDER BY `uid` DESC LIMIT :index, 20');
$stmt->execute($params);
while ($rows = $stmt->fetch()) {
    $over = '#EBEBEB';
    $out = '#ffffff';
    $color = '#FFFFFF';
    $rows['status'] = '正常';
    if($rows['is_stop']==1){
        $color = $over = $out = '#EBEBEB';
        $rows['status'] = '<span style="color:red">会员停用</span>';
    }else if($rows['stop']==1){
        $color = $over = $out = '#EBEBEB';
        $rows['status'] = '<span style="color:red">禁止领取</span>';
    }
    if($rows['money']<0){
        $color = $over = $out = '#FF9999';
        $rows['status'] = '余额异常';
    }
    $rows['top_uid'] = intval($rows['top_uid']);
    if($rows['top_uid']>0&&!isset($agent[$rows['top_uid']])){
        $agent[$rows['top_uid']] = false;
        $query = $mydata1_db->query('SELECT `username` FROM `k_user` WHERE `is_delete`=0 AND `uid`='.$rows['top_uid']);
        if($query->rowCount()>0){
            $rs = $query->fetch();
            $agent[$rows['top_uid']] = $rs['username'];
        }
    }
?>                        <tr align="center" onmouseover="this.style.backgroundColor='<?php echo $over; ?>'" onmouseout="this.style.backgroundColor='<?php echo $out; ?>'" style="background-color:<?php echo $color; ?>">
                            <td height="25"><?php echo $rows['uid']; ?></td>
                            <td><a href="../hygl/user_show.php?id=<?php echo $rows['uid']; ?>"><?php echo $rows['username']; ?></a></td>
                            <td><?php echo $rows['pay_name']; ?></td>
                            <td><?php echo sprintf('%.2f', $rows['money']); ?></td>
                            <td><?php echo sprintf('%.2f', $rows['c_money']/100); ?></td>
                            <td>
                                <span><?php echo $rows['count']==null?0:$rows['count']; ?></span>
                                <a href="javascript:;" onclick="updateUser('<?php echo $rows['username']; ?>', this)"<?php echo $rows['last']==null||$end>$rows['last']?'':' style="display:none"'; ?>>(更新)</a>
                            </td>
                            <td><?php if($rows['is_daili']==1){ ?><a href="user.php?s_value=<?php echo urlencode($rows['username']); ?>&amp;s_type=agent" style="color:red">代理账号</a><?php }else{ ?>普通会员<?php } ?></td>
                            <td><?php if(!isset($agent[$rows['top_uid']])){ ?>--<?php }else if(!$agent[$rows['top_uid']]){ ?>代理不存在<?php }else{ ?><a href="user.php?s_value=<?php echo urlencode($agent[$rows['top_uid']]); ?>&amp;s_type=agent"><?php echo $agent[$rows['top_uid']]; ?></a><?php } ?></td>
                            <td><?php echo isset($group[$rows['gid']])?'<a href="user.php?s_stop='.$s_stop.'&amp;gid='.$rows['gid'].'">'.$group[$rows['gid']].'</a>':'--'; ?></td>
                            <td><?php echo $rows['status']; ?></td>
                            <td>
                                <a href="record.php?username=<?php echo $rows['username']; ?>">领取记录</a>
                                <a href="user_record.php?uid=<?php echo $rows['uid']; ?>">次数记录</a>
                            </td>
                            <td><input type="checkbox" name="uid[]" value="<?php echo $rows['uid']; ?>" /></td>
                        </tr>
<?php } ?>                    </table>
                </td>
            </tr>
            <tr><td><div style="float:left;"><?php echo $page->get_htmlPage(preg_replace('/&?page\=[^&]*/', '', $_SERVER['REQUEST_URI'])); ?></div></td></tr> 
        </table>
    </form>
</body>
</html>