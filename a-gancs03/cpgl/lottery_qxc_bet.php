<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('cpgl');

$page = array('limit' => 50);
$status = isset($_GET['status'])?$_GET['status']:'1';
!in_array($status, array('1', '2', '3', '4'))&&$status = '1';
$username = isset($_GET['username'])?$_GET['username']:'';
$s_time = isset($_GET['s_time'])?$_GET['s_time']:date('Y-m-d', time()-604800);
$e_time = isset($_GET['e_time'])?$_GET['e_time']:date('Y-m-d');
$page['cur'] = isset($_GET['page'])?$_GET['page']:'1';

$action = isset($_POST['action']) ? $_POST['action'] : 'default';

if(in_array($action, array('cancel', 'save'))){
    $_return = array();
    switch($action){
        case 'cancel':
            if(!strpos($_SESSION['quanxian'], 'cpcd')){
                $_return['status'] = 'failed';
                $_return['msg'] = '您没有权限操作该功能！';
            }else{
                $_return['status'] = cancel_order(isset($_POST['id'])?intval($_POST['id']):0)?'success':'failed';
            }
            break;
    }
    exit(json_encode($_return));
}

function cancel_order($id){
    global $mydata1_db;
    $params = array(':type' => 'QXC', ':id' => $id);
    $stmt = $mydata1_db->prepare('SELECT `c_bet_data`.*, `k_user`.`money` AS `last_money`, `k_user`.`username` AS `username` FROM `c_bet_data` LEFT JOIN `k_user` ON `k_user`.`uid`=`c_bet_data`.`uid` WHERE `type`=:type AND `id`=:id');
    $stmt->execute($params);
    if($stmt->rowCount()>0){
        $rows = $stmt->fetch();
        if($rows['status']==2){
            return false;
        }else{
            $rows['remoney'] = $rows['money'];
            $rows['status']==1&&$rows['win']>0&&$rows['remoney']-= $rows['win'];
            /* 和局已退本金，不处理 */
            $rows['win']==0&&$rows['remoney'] = 0;
            $rows['remoney']/= 100;
            $stmt = $mydata1_db->prepare('UPDATE `c_bet_data` SET `status`=2, `win`=0 WHERE `type`=:type AND `id`=:id');
            $stmt->execute($params);
            $stmt = $mydata1_db->prepare('UPDATE `k_user` SET `money`=`money`+:money WHERE `uid`=:uid');
            $stmt->execute(array(
                ':money' => $rows['remoney'],
                ':uid' => $rows['uid'],
            ));
            $stmt = $mydata1_db->prepare('INSERT INTO `k_money_log` (`uid`, `userName`, `gameType`, `transferType`, `transferOrder`, `transferAmount`, `previousAmount`, `currentAmount`, `creationTime`) VALUES (:uid, :userName, :gameType, :transferType, :transferOrder, :transferAmount, :previousAmount, :currentAmount, :creationTime)');
            $stmt->execute(array(
                ':uid' => $rows['uid'],
                ':userName' => $rows['username'],
                ':gameType' => 'QXC',
                ':transferType' => 'CANCEL_BET',
                ':transferOrder' => 'QXC_'.$rows['id'],
                ':transferAmount' => $rows['remoney'],
                ':previousAmount' => $rows['last_money'],
                ':currentAmount' => $rows['last_money']+$rows['remoney'],
                ':creationTime' => date('Y-m-d H:i:s'),
            ));
            $status = array('未结算', '已结算', '已撤销');
            admin::insert_log($_SESSION['adminid'], '撤销['.$rows['username'].']七星彩期号['.$rows['qishu'].']注单['.$rows['id'].'],[注单金额:'.number_format($rows['money']/100, 2, '.', '').',可赢金额:'.number_format($rows['win']/100, 2, '.', '').',结算状态:' . $status[$rows['status']] . '],退回金额:'.number_format($rows['remoney'], 2, '.', ''));
            return true;
        }
    }else{
        return false;
    }
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
    <script type="text/javascript" charset="utf-8" src="/js/calendar.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("a[data-id]").on("click", function(){
                var t = $(this);
                if(t.data("status")=="2"){
                    alert("该注单已被撤销！");
                }else if(confirm('您确定要撤销该注单？撤销后金额将重算并退回（余额可能为负数）！')){
                    $.post("<?php echo basename(__FILE__); ?>", {action: "cancel", id: t.data("id")}, function(data){
                        if(data["status"]=="success"){
                            alert("撤销成功！");
                            t.data("status", "2").parent().prev().html("已撤销");
                        }else if(typeof(data["msg"])!="undefined"){
                            alert(data["msg"]);
                        }else{
                            alert("撤销失败！");
                        }
                    }, "json");
                }
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
                            <td align="center" bgcolor="#3C4D82" style="color:#FFF"><a id="ssc01" href="lottery_qxc_bet.php" class="menu_curr">即时注单</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a id="ssc02" href="lottery_qxc_data.php" class="menu_com">开奖设置</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a id="ssc03" href="lottery_qxc_odds.php" class="menu_com">赔率设置</a></td>
                        </tr>
                        <tr>
                            <td align="center" bgcolor="#FFFFFF" style="color:#000">
                                <form action="<?php echo basename(__FILE__); ?>" method="get">
                                    <label>注单状态：</label>
                                    <select name="status"> 
                                        <option value="1" style="color:#FF9900;"<?php echo $status=='1'?' selected="true"':'';?>>未结算</option>
                                        <option value="2" style="color:#FF0000;"<?php echo $status=='2'?' selected="true"':'';?>>已结算</option>
                                        <option value="3"<?php echo $status=='3'?' selected="true"':'';?>>已撤销</option>
                                        <option value="4"<?php echo $status=='4'?' selected="true"':'';?>>全部</option>
                                    </select>
                                    <label>会员：</label>
                                    <input name="username" type="text" value="<?php echo $username; ?>" size="15" />
                                    <label>日期：</label>
                                    <input name="s_time" type="text" value="<?php echo $s_time; ?>" onclick="new Calendar(<?php echo date('Y')-5; ?>, <?php echo date('Y'); ?>).show(this);" size="10" maxlength="10" readonly="readonly" />&nbsp;~&nbsp;<input name="e_time" type="text" value="<?php echo $e_time; ?>" onclick="new Calendar(<?php echo date('Y')-5; ?>, <?php echo date('Y'); ?>).show(this);" size="10" maxlength="10" readonly="readonly" />
                                    <input type="submit" value="搜索" />
                                </form>
                            </td>
                        </tr>
                    </table>
                    <table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                        <tr style="background-color:#3C4D82;color:#FFF">
                            <td height="22" align="center"><strong>注单号</strong></td>
                            <td height="22" align="center"><strong>会员</strong></td>
                            <td height="22" align="center"><strong>期号</strong></td>
                            <td height="22" align="center"><strong>盘位</strong></td>
                            <td height="22" align="center"><strong>内容</strong></td>
                            <td height="22" align="center"><strong>注单数/金额</strong></td>
                            <td height="22" align="center"><strong>总金额</strong></td>
                            <td height="22" align="center"><strong>赔率</strong></td>
                            <td height="22" align="center"><strong>派彩金额</strong></td>
                            <td height="22" align="center"><strong>返水比例</strong></td>
                            <td height="22" align="center"><strong>投注时间(北京/美东)</strong></td>
                            <td height="22" align="center"><strong>开奖结果</strong></td>
                            <td height="22" align="center"><strong>状态</strong></td>
                            <td height="22" align="center"><strong>操作</strong></td>
                        </tr>
<?php
$page['url'].= '?status='.urlencode($status).'&amp;';
$sum = array('bet' => 0, 'user' => 0, 'web' => 0);
// 配置SQL语句
$params = array(':type' => 'QXC');
$where = array('`type`=:type');
if(in_array($status, array('1', '2', '3'))){
    $where[] = '`status`=:status';
    $params[':status'] = $status-1;
}
if(!empty($username)){
    $where[] = '`uid`=(SELECT `uid` FROM `k_user` WHERE `username`=:username)';
    $params[':username'] = $username;
    $page['url'].= 'username='.urlencode($username).'&amp;';
}
$stime = strtotime($s_time);
$etime = strtotime($e_time);
if($stime>0&&$etime>0){
    $where[] = '`addtime` BETWEEN :stime AND :etime';
    $params[':stime'] = $stime;
    $params[':etime'] = $etime+86399;
    $page['url'].= 's_time='.urlencode($s_time).'&amp;';
    $page['url'].= 'e_time='.urlencode($e_time).'&amp;';
}else{
    if($stime>0){
        $where[] = '`addtime`>=:stime';
        $params[':stime'] = $stime;
        $page['url'].= 's_time='.urlencode($s_time).'&amp;';
    }
    if($etime>0){
        $where[] = '`addtime`<=:etime';
        $params[':etime'] = $etime+86399;
        $page['url'].= 'e_time='.urlencode($e_time).'&amp;';
    }
}
$where = implode(' AND ', $where);

// 计算分页
$stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `COUNT` FROM `c_bet_data` WHERE '.$where);
$stmt->execute($params);
$page['count'] = $stmt->fetch();
$page['count'] = $page['count']['COUNT'];
$page['all'] = ceil($page['count']/$page['limit']);
$page['all']<1&&$page['all'] = 1;
if(is_numeric($page['cur'])&&$page['cur']>0){
    $page['cur']>$page['all']&&$page['cur'] = $page['all'];
}else{
    $page['cur'] = '1';
}

$params[':start'] = ($page['cur']-1)*$page['limit'];
$params[':limit'] = $page['limit'];
$status = array('<font color="#0000FF">未结算</font>', '<font color="#FF0000">已结算</font>', '已撤销');
$stmt = $mydata1_db->prepare('SELECT * FROM `c_bet_data` WHERE '.$where.' ORDER BY `id` DESC LIMIT :start, :limit');
$stmt->execute($params);
while($rows = $stmt->fetch()){
    $rows['value'] = unserialize($rows['value']);
    $sum['bet']+= $rows['money'];
    if($rows['status']==1){
        $sum['web']+= $rows['win']>0?$rows['money']-$rows['win']:$rows['money'];
    }else{
        $rows['win'] = 0;
    }
    $rows['win']>0&&$sum['user']+= $rows['win'];
?>                        <tr onmouseover="this.style.backgroundColor='#EBEBEB'" onmouseout="this.style.backgroundColor='#ffffff'" style="background-color:#FFFFFF;line-height:20px;">
                            <td align="center"><?php echo $rows['id']; ?></td>
                            <td align="center"><?php echo $rows['value']['username']; ?></td>
                            <td align="center"><?php echo $rows['qishu']; ?></td>
                            <td align="center"><?php echo $rows['value']['part']; ?></td>
                            <td align="center"><?php echo $rows['value']['type'].'<br />'.$rows['value']['content']; ?></td>
                            <td align="center"><?php echo $rows['value']['count'].'注<br />'.number_format($rows['value']['money']/100, 2, '.', ''); ?></td>
                            <td align="center"><?php echo number_format($rows['money']/100, 2, '.', ''); ?></td>
                            <td align="center"><?php echo $rows['value']['odds']; ?></td>
                            <td align="center"><?php echo number_format($rows['win']/100, 2, '.', ''); ?></td>
                            <td align="center"><?php echo $rows['value']['rate']; ?>%</td>
                            <td align="center"><?php echo date('Y-m-d H:i:s', $rows['addtime']+43200).'<br />'.date('Y-m-d H:i:s', $rows['addtime']); ?></td>
                            <td align="center"><?php echo $rows['value']['result']; ?></td>
                            <td align="center"><?php echo $status[$rows['status']]; ?></td>
                            <td align="center"><a href="javascript:;" data-id="<?php echo $rows['id']; ?>" data-status="<?php echo $rows['status']; ?>">撤销</a></td>
                        </tr>
<?php
}
$page['url'].= 'page=';
$page['range'] = array(1, $page['all']);
if($page['all']>5){
    $page['range'][1] = 5;
    if($page['cur']>3){
        $page['range'] = array($page['cur']-2, $page['cur']+2);
    }
    if($page['range'][1]>$page['all']){
        $page['range'] = array($page['all']-4, $page['all']);
    }
}
?>                        <tr style="background-color:#FFF">
                            <td colspan="14" align="center" valign="middle">本页投注总金额：<?php echo number_format($sum['bet']/100, 2, '.', ''); ?>元，派彩总金额：<?php echo number_format($sum['user']/100, 2, '.', ''); ?>元，赢利总金额：<?php echo number_format($sum['web']/100, 2, '.', ''); ?>元</td>
                        </tr>
                        <tr style="background-color:#FFF">
                            <td colspan="14" align="center" valign="middle">
                                <div class="Pagination">
                                    <a href="<?php echo $page['cur']>1?$page['url'].'1':'javascript:;'; ?>" class="tips">首页</a>
                                    <a href="<?php echo $page['cur']>1?$page['url'].($page['cur']-1):'javascript:;'; ?>" class="tips">上一页</a>
<?php if($page['range'][0]>1){ ?>                                    <span class="dot">……</span>
<?php }for($p=$page['range'][0];$p<=$page['range'][1];$p++){ ?>                                    <a href="<?php echo $page['cur']!=$p?$page['url'].$p:'javascript:;" class="current'; ?>"><?php echo $p; ?></a>
<?php }if($page['range'][1]<$page['all']){ ?>                                    <span class="dot">……</span>
<?php } ?>                                    <a href="<?php echo $page['cur']<$page['all']?$page['url'].($page['cur']+1):'javascript:;'; ?>" class="tips">下一页</a>
                                    <a href="<?php echo $page['cur']<$page['all']?$page['url'].$page['all']:'javascript:;'; ?>" class="tips">末页</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>