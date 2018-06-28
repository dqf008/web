<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
include_once '../../include/newPage.php';
// check_quanxian("hbxt");

if(isset($_POST['action'])&&isset($_POST['id'])&&!empty($_POST['id'])){
    $success = 0;
    $failed = count($_POST['id']);
    foreach($_POST['id'] as $id){
        $stmt = $mydata1_db->prepare('SELECT * FROM `packets_list` WHERE `id`=?');
        $stmt->execute(array(intval($id)));
        if($stmt->rowCount()>0){
            $rows = $stmt->fetch();
            switch ($_POST['action']) {
                case 'reckon':
                    if($rows['status']==0){
                        $success+= 1;
                        s_reckon($rows['id'], $rows['uid'], $rows['addtime'], $rows['money']);
                    }
                    break;
                case 'delete':
                    if($rows['status']==2){
                        $success+= 1;
                        s_delete($rows['id'], $rows['money']);
                    }
                    break;
                case 'cancel':
                    if($rows['status']==0){
                        $success+= 1;
                        s_cancel($rows['id'], $rows['uid'], $rows['addtime']);
                    }else if($rows['status']==1){
                        $success+= 1;
                        s_cancel($rows['id'], $rows['uid'], $rows['addtime'], $rows['money']);
                    }
                    break;
                case 'recalc':
                    if($rows['status']==0){
                        $success+= 1;
                        s_recalc($rows['id'], $rows['uid'], $rows['addtime']);
                    }else if($rows['status']==1){
                        $success+= 1;
                        s_recalc($rows['id'], $rows['uid'], $rows['addtime'], $rows['money']);
                    }
                    break;
            }
        }
    }
    message('操作完成！成功 '.$success.' 条，失败 '.($failed-$success).' 条');
}
if(isset($_GET['action'])&&isset($_GET['id'])&&!empty($_GET['id'])){
    $stmt = $mydata1_db->prepare('SELECT * FROM `packets_list` WHERE `id`=?');
    $stmt->execute(array($_GET['id']));
    if($stmt->rowCount()>0){
        $rows = $stmt->fetch();
        $msg = '操作失败！';
        switch ($_GET['action']) {
            case 'reckon':
                if($rows['status']==0){
                    $msg = '派彩成功！';
                    s_reckon($rows['id'], $rows['uid'], $rows['addtime'], $rows['money']);
                }
                break;
            case 'delete':
                if($rows['status']==2){
                    $msg = '删除成功！';
                    s_delete($rows['id'], $rows['money']);
                }
                break;
            case 'cancel':
                if($rows['status']==0){
                    $msg = '标记无效成功！';
                    s_cancel($rows['id'], $rows['uid'], $rows['addtime']);
                }else if($rows['status']==1){
                    $msg = '撤销并标记无效成功！';
                    s_cancel($rows['id'], $rows['uid'], $rows['addtime'], $rows['money']);
                }
                break;
            case 'recalc':
                if($rows['status']==0){
                    $msg = '退回次数成功！';
                    s_recalc($rows['id'], $rows['uid'], $rows['addtime']);
                }else if($rows['status']==1){
                    $msg = '撤销并退回次数成功！';
                    s_recalc($rows['id'], $rows['uid'], $rows['addtime'], $rows['money']);
                }
                break;
        }
        message($msg);
    }else{
        message('记录不存在！');
    }
}

$username = isset($_GET['username'])?$_GET['username']:'';
$s_type = isset($_GET['s_type'])?$_GET['s_type']:0;
$thisPage = isset($_GET['page'])?$_GET['page']:'1';

function s_reckon($id, $uid, $time, $money){
    global $mydata1_db;
    $idx = $uid.'_'.$time;
    $last_money = update_money($uid, $money/100, $time);
    admin::insert_log($_SESSION['adminid'], '对红包记录['.$idx.']进行派送['.sprintf('%.2f', $money/100).']');
    return $mydata1_db->query('UPDATE `packets_list` SET `status`=1 WHERE `status`=0 AND `id`='.$id);
}
function s_delete($id, $money){
    global $mydata1_db;
    admin::insert_log($_SESSION['adminid'], '删除了一条虚拟红包记录，金额为：'.sprintf('%.2f', $money/100));
    return $mydata1_db->query('DELETE FROM `packets_list` WHERE `status`=2 AND `id`='.$id);
}
function s_cancel($id, $uid, $time, $money=-1){
    global $mydata1_db;
    $idx = $uid.'_'.$time;
    $return = false;
    if($money<0){
        admin::insert_log($_SESSION['adminid'], '将红包记录['.$idx.']标记为无效');
        $return = $mydata1_db->query('UPDATE `packets_list` SET `status`=4 WHERE `status`=0 AND `id`='.$id);
    }else{
        $last_money = update_money($uid, -1*$money/100, $time, true);
        admin::insert_log($_SESSION['adminid'], '撤销红包记录['.$idx.']派送结果['.sprintf('%.2f', $money/100).']并标记为无效');
        $return = $mydata1_db->query('UPDATE `packets_list` SET `status`=4 WHERE `status`=1 AND `id`='.$id);
    }
    return $return;
}
function s_recalc($id, $uid, $time, $money=-1){
    global $mydata1_db;
    $idx = $uid.'_'.$time;
    if($money<0){
        admin::insert_log($_SESSION['adminid'], '退回红包记录['.$idx.']次数');
        $mydata1_db->query('UPDATE `packets_list` SET `status`=3 WHERE `status`=0 AND `id`='.$id);
    }else{
        $last_money = update_money($uid, -1*$money/100, $time, true);
        admin::insert_log($_SESSION['adminid'], '撤销红包记录['.$idx.']派送结果['.sprintf('%.2f', $money/100).']并退回红包次数');
        $mydata1_db->query('UPDATE `packets_list` SET `status`=3 WHERE `status`=1 AND `id`='.$id);
    }
    $query = $mydata1_db->query('SELECT `count` FROM `packets_config` WHERE `uid`='.$uid);
    if($query->rowCount()>0){
        $rows = $query->fetch();
        $mydata1_db->query('UPDATE `packets_config` SET `count`=`count`+1 WHERE `uid`='.$uid);
        return addLogs($uid, array(
            'type' => array('admin'),
            'sum' => 0,
            'start' => time(),
            'end' => time(),
            'rule' => array(5, $_SESSION['login_name']),
            'count' => $rows['count']+1,
        ));
    }else{
        return false;
    }
}

function update_money($uid, $money, $time=0, $cancel=false){
    global $mydata1_db;
    $return = -1;
    $params = array(':uid' => $uid);
    $sql = 'SELECT `uid`, `username`, `money` FROM `k_user` WHERE `uid`=:uid LIMIT 1';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    if($stmt->rowCount()>0){
        $user = $stmt->fetch();
        $params[':money'] = $money;
        $sql = 'UPDATE `k_user` SET `money`=`money`+:money WHERE `uid`=:uid';
        $stmt = $mydata1_db->prepare($sql);
        if($stmt->execute($params)){
            $return = $user['money'];
            $now = time();
            $packets_id = ($cancel?'PCANCEL_':'PACKETS_').substr('0000000000'.$user['uid'], -10).date('YmdHis', $time>0?$time:$now);
            $stmt = $mydata1_db->prepare('INSERT INTO `k_money_log` (`uid`, `userName`, `gameType`, `transferType`, `transferOrder`, `transferAmount`, `previousAmount`, `currentAmount`, `creationTime`) VALUES (:uid, :userName, :gameType, :transferType, :transferOrder, :transferAmount, :previousAmount, :currentAmount, :creationTime)');
            $stmt->execute(array(
                ':uid' => $user['uid'],
                ':userName' => $user['username'],
                ':gameType' => 'ADMINACCOUNT',
                ':transferType' => $cancel?'OUT':'IN',
                ':transferOrder' => $packets_id,
                ':transferAmount' => $money,
                ':previousAmount' => $user['money'],
                ':currentAmount' => $user['money']+$money,
                ':creationTime' => date('Y-m-d H:i:s', $now),
            ));
            $stmt = $mydata1_db->prepare('INSERT INTO `k_money` (`uid`, `m_value`, `m_order`, `status`, `m_make_time`, `about`, `type`, `assets`, `balance`) VALUES (:uid, :m_value, :m_order, 1, :m_make_time, :about, :type, :assets, :balance)');
            $stmt->execute(array(
                ':uid' => $user['uid'],
                ':m_value' => $money,
                ':m_order' => $packets_id,
                ':m_make_time' => date('Y-m-d H:i:s', $now),
                ':about' => $cancel?'撤销红包派送':'红包派送',
                // ':type' => $cancel?6:4,
                ':type' => 4,
                ':assets' => $user['money'],
                ':balance' => $user['money']+$money,
            ));
        }
    }
    return $return;
}
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
        function onSubmit(){
            switch(true){
                case $("input:checkbox").not(":first").filter(":checked").size()<=0:
                    alert("请选择需要操作的注单！");
                    return false;
                case $("#action option:selected").val()=="0":
                    alert('请选择相关操作！');
                    return false;
                case $("#action option:selected").val()=="reckon":
                    return confirm("确定进行派彩？");
                case $("#action option:selected").val()=="recalc":
                    return confirm("已派彩将进行撤销，并退回红包次数，是否继续？");
                case $("#action option:selected").val()=="cancel":
                    return confirm("已派彩将进行撤销，并扣除红包次数，是否继续？");
                case $("#action option:selected").val()=="delete":
                    return confirm("仅虚拟记录可以删除，是否继续？");
            }
        }
    </script>
</head>
<body>
    <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tbody>
            <tr>
                <td height="24" nowrap="" background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle" />&nbsp;红包系统：红包注单管理</td>
            </tr>
            <tr>
                <td height="24" align="center" nowrap="" bgcolor="#FFFFFF">
                    <form name="form1" method="GET" action="record.php">
                        <table width="455">
                            <tr>
                                <td>
                                    <span>用户名：</span>
                                    <input type="text" name="username" value="<?php echo $username; ?>" />
                                    <input type="submit" value="查找"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
    <form name="form2" method="post" action="record.php" onsubmit="return onSubmit()">
        <table width="100%">
            <tr>
                <td width="104" align="center"><a href="record.php?s_type=0">全部红包</a></td>
                <td width="104" align="center"><a href="record.php?s_type=1&amp;username=<?php echo $username; ?>">未派彩</a></td>
                <td width="104" align="center"><a href="record.php?s_type=2&amp;username=<?php echo $username; ?>">已派彩</a></td>
                <td width="104" align="center"><a href="record.php?s_type=3&amp;username=<?php echo $username; ?>">虚拟记录</a></td>
                <td width="104" align="center"><a href="record.php?s_type=4&amp;username=<?php echo $username; ?>">已撤销</a></td>
                <td width="104" align="center"><a href="record.php?s_type=5&amp;username=<?php echo $username; ?>">标记无效</a></td>
                <td width="104" align="center"><a href="record_add.php">添加虚拟记录</a></td>
                <td width="365" align="right">
                    <span style="color:red">相关操作：</span>
                    <select name="action" id="action">
                        <option value="0" selected="true">请选择</option>
                        <option value="reckon">批量派彩</option>
                        <option value="recalc">撤销记录</option>
                        <option value="cancel">标记无效</option>
                        <option value="delete">删除记录</option>
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
                            <td height="25"><strong>编号</strong></td>
                            <td><strong>登录名</strong></td>
                            <td><strong>红包金额</strong></td>
                            <td><strong>领取时间</strong></td>
                            <td><strong>状态</strong></td>
                            <td><strong>操作</strong></td>
                            <td><input type="checkbox" onclick="$('input:checkbox').attr('checked', $(this).is(':checked'))" /></td>
                        </tr>
<?php
$status = array(
    0 => '<span style="color:red">未派彩</span>',
    1 => '已派彩',
    2 => '<span style="color:#4caf50">虚拟记录</span>',
    3 => '<span style="color:#2196F3">已撤销</span>',
    4 => '<span style="color:#9c27b0">标记无效</span>'
);
$params = array();
$sql = array();
if($username!=''){
    $params[':username'] = '%'.$username.'%';
    $sql[] = '`username` LIKE :username';
}
if($s_type>0&&$s_type<=5){
    $params[':status'] = $s_type-1;
    $sql[] = '`status`=:status';
}
!empty($sql)&&$sql = ' WHERE '.implode(' AND ', $sql);
$stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `sum` FROM `packets_list`'.$sql);
$stmt->execute($params);
$rows = $stmt->fetch();
$page = new newPage();
$thisPage = $page->check_Page($thisPage, $rows['sum'], 20, 40);
$params[':index'] = ($thisPage-1)*20;
$stmt = $mydata1_db->prepare('SELECT * FROM `packets_list`'.$sql.' ORDER BY `id` DESC LIMIT :index, 20');
$stmt->execute($params);
while ($rows = $stmt->fetch()) {
?>                        <tr align="center" onmouseover="this.style.backgroundColor='#EBEBEB'" onmouseout="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF">
                            <td height="25"><?php echo $rows['uid'].'_'.$rows['addtime']; ?></td>
                            <td><?php if($rows['status']==2){echo $rows['username'];}else{ ?><a href="../hygl/user_show.php?id=<?php echo $rows['uid']; ?>"><?php echo $rows['username']; ?></a><?php } ?></td>
                            <td><?php echo sprintf('%.2f', $rows['money']/100); ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $rows['addtime']); ?></td>
                            <td><?php echo isset($status[$rows['status']])?$status[$rows['status']]:'未知'; ?></td>
                            <td>
<?php if($rows['status']==0){ ?>                                <a href="record.php?action=reckon&amp;id=<?php echo $rows['id']; ?>" onclick="return confirm('确定进行派彩？')">派彩</a>
<?php }if(in_array($rows['status'], array(0, 1))){ ?>                                <a href="record.php?action=recalc&amp;id=<?php echo $rows['id']; ?>" onclick="return confirm('已派彩将进行撤销，并退回红包次数，是否继续？')">撤销</a>
                                <a href="record.php?action=cancel&amp;id=<?php echo $rows['id']; ?>" onclick="return confirm('已派彩将进行撤销，并扣除红包次数，是否继续？')">标记无效</a>
<?php }if($rows['status']==2){ ?>                                <a href="record.php?action=delete&amp;id=<?php echo $rows['id']; ?>" onclick="return confirm('是否继续删除本条虚拟记录？')">删除</a>
<?php }if(!in_array($rows['status'], array(0, 1, 2))){ ?>                                <a href="javascript:;">无可用操作</a>
<?php } ?>                            </td>
                            <td><input type="checkbox" name="id[]" value="<?php echo $rows['id']; ?>" /></td>
                        </tr>
<?php } ?>                    </table>
                </td>
            </tr>
            <tr><td><div style="float:left;"><?php echo $page->get_htmlPage(preg_replace('/&?page\=[^&]*/', '', $_SERVER['REQUEST_URI'])); ?></div></td></tr> 
        </table>
    </form>
</body>
</html>