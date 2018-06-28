<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
// check_quanxian("hbxt");

if(isset($_POST['action'])&&$_POST['action']=='save'){
    $username = isset($_POST['username'])?$_POST['username']:'';
    $money = isset($_POST['money'])?$_POST['money']:'';
    if(empty($username)){
        message('显示名不能为空！');
    }else if(empty($money)){
        message('中奖金额不能为空！');
    }else{
        $addtime = isset($_POST['date'])?$_POST['date']:date('Y-m-d');
        $addtime.= ' '.isset($_POST['hour'])?$_POST['hour']:date('H');
        $addtime.= ':'.isset($_POST['minute'])?$_POST['minute']:date('i');
        $addtime.= ':'.isset($_POST['second'])?$_POST['second']:date('i');
        $addtime = strtotime($addtime);
        !$addtime&&$addtime = time();
        $stmt = $mydata1_db->prepare('INSERT INTO `packets_list` (`uid`, `username`, `money`, `addtime`, `status`) VALUES (:uid, :username, :money, :addtime, :status)');
        $stmt->execute(array(
            ':uid' => 0,
            ':username' => $username,
            ':money' => $money*100,
            ':addtime' => $addtime,
            ':status' => 2,
        ));
        admin::insert_log($_SESSION['adminid'], '添加了虚假红包记录，金额为：'.sprintf('%.2f', $money));
        message('添加成功！');
    }
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
</head>
<body>
    <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tbody>
            <tr>
                <td height="24" nowrap="" background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle" />&nbsp;红包系统：添加虚拟记录</td>
            </tr>
            <tr>
                <td height="24" align="center" nowrap="" bgcolor="#FFFFFF">
                    <form name="form1" method="POST" action="record_add.php">
                        <input type="hidden" name="action" value="save" />
                        <table width="90%" align="center" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse:collapse;color:#225d9c">
                            <tr>
                                <td bgcolor="#F0FFFF" height="30" width="25%" style="text-align:right;padding-right:5px">显示名</td>
                                <td style="padding-left:5px">
                                    <input type="text" name="username" />
                                    <span style="color:red">* 无论会员名是否存在，均不会出现在“红包查询”结果内</span>
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#F0FFFF" height="30" width="25%" style="text-align:right;padding-right:5px">中奖金额</td>
                                <td style="padding-left:5px">
                                    <input type="text" name="money" />
                                    <span>单位：元</span>
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#F0FFFF" height="30" width="25%" style="text-align:right;padding-right:5px">中奖时间</td>
                                <td style="padding-left:5px">
                                    <input type="text" class="textfield" value="<?php echo date('Y-m-d'); ?>" onclick="new Calendar(<?php echo date('Y')-1; ?>, <?php echo date('Y')+5; ?>).show(this);" size="10" maxlength="10" name="date" readonly="readonly"/>
                                    <select name="hour"><?php for($i=0;$i<24;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('H')?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                    <select name="minute"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('i')?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                    <select name="second"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('s')?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                    <span>建议不要超过当前时间</span>
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
</body>
</html>