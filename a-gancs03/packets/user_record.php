<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian("hbxt");

$end = strtotime(date('Y-m-d'))-1;
$uid = isset($_GET['uid'])?intval($_GET['uid']):0;
$user = array();
$stmt = $mydata1_db->prepare('SELECT `uid`, `username`, `money` FROM `k_user` WHERE `uid`=:uid AND `is_delete`=0 LIMIT 1');
$stmt->execute(array(':uid' => $uid));
$stmt->rowCount()>0&&$user = $stmt->fetch();
empty($user)&&message('用户信息不存在！', $_SERVER['HTTP_REFERER']);

$query = $mydata1_db->query('SELECT * FROM `packets_config` WHERE `uid`='.$user['uid']);
if($query->rowCount()>0){
    $rs = $query->fetch();
    // $rs['value'] = unserialize($rs['value']);
}else{
    $rs = array('stop' => 0, 'count' => 0, 'money' => 0, 'value' => array());
    $mydata1_db->query('INSERT INTO `packets_config` (`uid`, `value`) VALUES ('.$user['uid'].', \'a:0:{}\')');
}

if(isset($_POST['action'])&&$_POST['action']=='save'){
    $_POST['count'] = isset($_POST['count'])?intval($_POST['count']):0;
    $stmt = $mydata1_db->prepare('UPDATE `packets_config` SET `count`=:count WHERE `uid`=:uid');
    $stmt->execute(array(':uid' => $user['uid'], ':count' => $_POST['count']));
    addLogs($user['uid'], array(
        'type' => array('admin'),
        'sum' => 0,
        'start' => time(),
        'end' => time(),
        'rule' => array(4, $_SESSION['login_name'], $_POST['count']-$rs['count']),
        'count' => $_POST['count'],
    ));
    admin::insert_log($_SESSION['adminid'], '修改会员['.$user['username'].']剩余红包次数为：'.$_POST['count']);
    message('操作成功！', $_SERVER['HTTP_REFERER']);
}

$s_value = isset($_GET['s_value'])?$_GET['s_value']:'';
$s_type = isset($_GET['s_type'])?$_GET['s_type']:'';
$s_stop = isset($_GET['s_stop'])?$_GET['s_stop']:'0';
$thisPage = isset($_GET['page'])?$_GET['page']:'1';

function addLogs($uid, $value){
    global $mydata1_db;
    $stmt = $mydata1_db->prepare('INSERT INTO `packets_logs` (`uid`, `addtime`, `value`) VALUES (:uid, :addtime, :value)');
    return $stmt->execute(array(
        ':uid' => $uid,
        ':addtime' => time(),
        ':value' => serialize($value),
    ));
}
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
        function updateUser(obj){
            $(obj).hide().siblings("span").show();
            $.ajax({
                url: "../../packets/ajax.php",
                dataType: "json",
                cache: false,
                type: "POST",
                data: {
                    action: "check",
                    username: "<?php echo $user['username']; ?>"
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
                        $(obj).siblings("span").hide().siblings("input").val(data['score']);
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
                <td height="24" nowrap="" background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle" />&nbsp;红包系统：会员信息管理</td>
            </tr>
            <tr>
                <td height="24" align="center" nowrap="" bgcolor="#FFFFFF">
                    <form name="form1" method="POST" action="user_record.php?uid=<?php echo $user['uid']; ?>">
                        <input type="hidden" name="action" value="save" />
                        <table width="90%" align="center" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse:collapse;color:#225d9c">
                            <tr>
                                <td bgcolor="#F0FFFF" height="30" width="25%" style="text-align:right;padding-right:5px">登录名</td>
                                <td style="padding-left:5px"><?php echo $user['username']; ?></td>
                            </tr>
                            <tr>
                                <td bgcolor="#F0FFFF" height="30" width="25%" style="text-align:right;padding-right:5px">当前余额</td>
                                <td style="padding-left:5px"><?php echo sprintf('%.2f', $user['money']); ?></td>
                            </tr>
                            <tr>
                                <td bgcolor="#F0FFFF" height="30" width="25%" style="text-align:right;padding-right:5px">累积领取红包</td>
                                <td style="padding-left:5px"><?php echo sprintf('%.2f', $rs['money']/100); ?></td>
                            </tr>
                            <tr>
                                <td bgcolor="#F0FFFF" height="30" width="25%" style="text-align:right;padding-right:5px">剩余次数</td>
                                <td style="padding-left:5px">
                                    <input type="text" name="count" value="<?php echo $rs['count']; ?>" />
                                    <span><img src="../../Box/skins/icons/loading.gif" style="display:none" /></span>
                                    <a href="javascript:;" onclick="updateUser(this)" style="<?php echo $rs['last']==null||$end>$rs['last']?'color:red':'display:none'; ?>">* 请先点击这里更新次数，再进行修改</a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center" height="35"><input type="submit" value="确认提交" />&nbsp;<input type="button" value="取 消" onclick="history.go(-1)" /></td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
    <div style="height:5px"></div>
    <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tr>
            <td height="24" nowrap bgcolor="#FFFFFF">
                <table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse:collapse;color:#225d9c">
                    <tr style="background-color:#EFE" align="center">
                        <td height="25"><strong>编号</strong></td>
                        <td><strong>统计类型</strong></td>
                        <td><strong>创建时间</strong></td>
                        <td><strong>统计开始时间</strong></td>
                        <td><strong>统计结束时间</strong></td>
                        <td><strong>统计合计</strong></td>
                        <td><strong>备注</strong></td>
                        <td><strong>剩余次数</strong></td>
                    </tr>
<?php
$type = array(
    'admin' => '管理员操作',
    'system' => '系统创建',
    'm_1' => '在线充值 (成功订单)',
    'm_3' => '人工汇款 (成功订单)',
    'h_0' => '在线汇款 (成功订单)',
    't_0' => '体育单式 (有效下注)',
    't_1' => '体育串关 (有效下注)',
    'c_0' => '重庆时时彩 (有效下注)',
    'c_1' => '广东快乐10分 (有效下注)',
    'c_2' => '北京赛车PK拾 (有效下注)',
    'c_3' => '北京快乐8 (有效下注)',
    'c_4' => '上海时时乐 (有效下注)',
    'c_5' => '福彩3D (有效下注)',
    'c_6' => '排列三 (有效下注)',
    'c_8' => '七星彩 (有效下注)',
    'c_7' => '六合彩 (有效下注)',
);
$_LIVE = include('../../cj/include/live.php');
foreach($_LIVE as $key=>$val){
    $type['l_'.$key] = $val[1].' (有效下注)';
}
$stmt = $mydata1_db->query('SELECT * FROM `packets_logs` WHERE `uid`='.$user['uid'].' ORDER BY `id` DESC LIMIT 100');
while($rows = $stmt->fetch()){
    $rows['value'] = unserialize($rows['value']);
    foreach($rows['value']['type'] as $i=>$k){
        isset($type[$k])&&$rows['value']['type'][$i] = $type[$k];
    }
    switch ($rows['value']['rule'][0]) {
        case '0':
            $count = $rows['value']['sum']>=$rows['value']['rule'][1]?$rows['value']['rule'][2]:0;
            $rule = '大于等于 '.sprintf('%.2f', $rows['value']['rule'][1]/100).' 增加 '.$rows['value']['rule'][2].' 次，合计 '.$count.' 次';
            break;
        case '1':
            $count = $rows['value']['rule'][1]>0?floor($rows['value']['sum']/$rows['value']['rule'][1])*$rows['value']['rule'][2]:0;
            $rule = '每满 '.sprintf('%.2f', $rows['value']['rule'][1]/100).' 增加 '.$rows['value']['rule'][2].' 次，合计 '.$count.' 次';
            break;
        case '2':
            $rule = '清理过期次数，合计 '.abs($rows['value']['rule'][1]).' 次';
            break;
        case '3':
            $rule = '领取红包，扣除 1 次，金额：'.sprintf('%.2f', $rows['value']['rule'][1]/100);
            break;
        case '4':
            if($rows['value']['rule'][2]>=0){
                $rule = '管理员 '.$rows['value']['rule'][1].' 增加会员 '.$rows['value']['rule'][2].' 次';
            }else{
                $rule = '管理员 '.$rows['value']['rule'][1].' 扣除会员 '.(-1*$rows['value']['rule'][2]).' 次';
            }
            break;
        case '5':
            $rule = '管理员 '.$rows['value']['rule'][1].' 撤销记录退回 1 次';
            break;
        default:
            $rule = '未知规则';
            break;
    }
?>                    <tr align="center" onmouseover="this.style.backgroundColor='#EBEBEB'" onmouseout="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF">
                        <td><?php echo $rows['uid'].'_'.$rows['addtime']; ?></td>
                        <td style="padding:5px 0"><?php echo implode('<br />', $rows['value']['type']); ?></td>
                        <td><?php echo date('Y-m-d H:i:s', $rows['addtime']); ?></td>
                        <td><?php echo date('Y-m-d H:i:s', $rows['value']['start']); ?></td>
                        <td><?php echo date('Y-m-d H:i:s', $rows['value']['end']); ?></td>
                        <td><?php echo sprintf('%.2f', $rows['value']['sum']/100); ?></td>
                        <td><?php echo $rule; ?></td>
                        <td><?php echo $rows['value']['count']; ?></td>
                    </tr>
<?php } ?>                </table>
            </td>
        </tr>
    </table>
</body>
</html>