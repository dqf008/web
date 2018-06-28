<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
// check_quanxian("hbxt");

$stmt = $mydata1_db->query('SELECT * FROM `packets_config` WHERE `uid`=0');
if($stmt->rowCount()>0){
    $rows = $stmt->fetch();
    !($packets = unserialize($rows['value']))&&$packets = array();
}else{
    $packets = array();
    $mydata1_db->query('INSERT INTO `packets_config` (`uid`, `value`) VALUES (0, \'a:0:{}\')');
}
!isset($packets['group'])&&$packets['group'] = array(0 => array());

$group = array();
$query = $mydata1_db->query('SELECT `id`, `name` FROM `k_group`');
while($rows = $query->fetch()){
    $group[$rows['id']] = $rows['name'];
    // !isset($packets['group'][$rows['id']])&&$packets['group'][$rows['id']] = $packets['group'][0];
}
$gid = isset($_GET['gid'])&&in_array($_GET['gid'], array_keys($group))?$_GET['gid']:0;
!isset($packets['group'][$gid])&&$packets['group'][$gid] = $packets['group'][0];
$config = $packets['group'][$gid];

$type = array(
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

if(isset($_POST['action'])&&$_POST['action']=='save'){
    $config['data'] = array();
    if(isset($_POST['data'])&&isset($_POST['data']['type'])&&isset($_POST['data']['option1'])&&isset($_POST['data']['option2'])&&isset($_POST['data']['option3'])&&isset($_POST['data']['s_date'])&&isset($_POST['data']['s_hour'])&&isset($_POST['data']['s_minute'])&&isset($_POST['data']['s_second'])&&isset($_POST['data']['e_date'])&&isset($_POST['data']['e_hour'])&&isset($_POST['data']['e_minute'])&&isset($_POST['data']['e_second'])){
        foreach($_POST['data']['s_hour'] as $key=>$val){
            if($key>0){
                $start = '';
                isset($_POST['data']['s_date'][$key])&&$start.= $_POST['data']['s_date'][$key];
                $start.= ' '.$val;
                isset($_POST['data']['s_minute'][$key])&&$start.= ':'.$_POST['data']['s_minute'][$key];
                isset($_POST['data']['s_second'][$key])&&$start.= ':'.$_POST['data']['s_second'][$key];
                $start = strtotime($start);
                $end = '';
                isset($_POST['data']['e_date'][$key])&&$end.= $_POST['data']['e_date'][$key];
                isset($_POST['data']['e_hour'][$key])&&$end.= ' '.$_POST['data']['e_hour'][$key];
                isset($_POST['data']['e_minute'][$key])&&$end.= ':'.$_POST['data']['e_minute'][$key];
                isset($_POST['data']['e_second'][$key])&&$end.= ':'.$_POST['data']['e_second'][$key];
                $end = strtotime($end);
                $_POST['data']['option1'][$key] = isset($_POST['data']['option1'][$key])&&$_POST['data']['option1'][$key]==1?1:0;
                (!isset($_POST['data']['option2'][$key])||!preg_match('/^[1-9]\d*(\.\d+)?$|^0\.\d+$/', $_POST['data']['option2'][$key]))&&$_POST['data']['option2'][$key] = 0;
                (!isset($_POST['data']['option3'][$key])||!preg_match('/^[1-9]\d*$/', $_POST['data']['option3'][$key]))&&$_POST['data']['option3'][$key] = 0;
                if(isset($_POST['data']['type'][$key])&&!empty($_POST['data']['type'][$key])){
                    $_POST['data']['type'][$key] = explode(',', $_POST['data']['type'][$key]);
                }else{
                    $_POST['data']['type'][$key] = array();
                }
                $config['data'][] = array(
                    'start' => $start,
                    'end' => $end,
                    'option' => array($_POST['data']['option1'][$key], intval($_POST['data']['option2'][$key]*100), intval($_POST['data']['option3'][$key])),
                    'type' => $_POST['data']['type'][$key],
                );
            }
        }
    }
    $config['rule'] = array();
    if(isset($_POST['rule'])&&isset($_POST['rule']['option1'])&&isset($_POST['rule']['option2'])&&isset($_POST['rule']['option3'])&&isset($_POST['rule']['option4'])){
        foreach($_POST['rule']['option1'] as $key=>$val){
            if($key>0){
                !preg_match('/^[1-9]\d*(\.\d+)?$|^0\.\d+$/', $val)&&$val = 0;
                (!isset($_POST['rule']['option2'][$key])||!preg_match('/^[1-9]\d*(\.\d+)?$|^0\.\d+$/', $_POST['rule']['option2'][$key]))&&$_POST['rule']['option2'][$key] = 0;
                (!isset($_POST['rule']['option3'][$key])||!preg_match('/^[1-9]\d*$/', $_POST['rule']['option3'][$key]))&&$_POST['rule']['option3'][$key] = 0;
                $config['rule'][] = array(intval($val*100), intval($_POST['rule']['option2'][$key]*100), intval($_POST['rule']['option3'][$key]), $_POST['rule']['option4'][$key]);
            }
        }
    }
    if($gid>0){
        $config['disable'] = isset($_POST['disable'])&&$_POST['disable']==1?1:0;
        $config['default'] = array(0, 0);
        $config['default'][0] = isset($_POST['default1'])&&$_POST['default1']==1?1:0;
        $config['default'][1] = isset($_POST['default2'])&&$_POST['default2']==1?1:0;
    }
    $temp1 = array();
    $group[0] = 'default';
    foreach($group as $k=>$v){
        isset($packets['group'][$k])&&$temp1[$k] = $packets['group'][$k];
    }
    $temp1[$gid] = $config;
    $packets['group'] = $temp1;
    $stmt = $mydata1_db->prepare('UPDATE `packets_config` SET `value`=? WHERE `uid`=0');
    $stmt->execute(array(serialize($packets)));
    admin::insert_log($_SESSION['adminid'], '修改了'.($gid>0?'会员组['.$group[$gid].']':'默认').'红包条件与规则');
    message('保存成功！', $_SERVER['HTTP_REFERER']);
}

if($gid>0&&isset($_GET['reset'])){
    $temp1 = array();
    $group[0] = 'default';
    foreach($group as $k=>$v){
        $k!=$gid&&isset($packets['group'][$k])&&$temp1[$k] = $packets['group'][$k];
    }
    $packets['group'] = $temp1;
    $stmt = $mydata1_db->prepare('UPDATE `packets_config` SET `value`=? WHERE `uid`=0');
    $stmt->execute(array(serialize($packets)));
    admin::insert_log($_SESSION['adminid'], '重置了会员组['.$group[$gid].']红包条件与规则');
    message('重置成功！', $_SERVER['HTTP_REFERER']);
}

!isset($config['default'])&&$config['default'] = array(0, 0);
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
    <form action="group.php?gid=<?php echo $gid; ?>" method="POST">
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
            <tbody>
                <tr>
                    <td height="24" nowrap="" background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle" />&nbsp;红包条件与规则：<?php echo $gid>0?'会员组['.$group[$gid].']':'默认'; ?></td>
                </tr>
                <tr>
                    <td height="24" align="center" nowrap="" bgcolor="#FFFFFF">
                        <input type="hidden" name="action" value="save" />
                        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
                            <tbody>
                                <tr>
                                    <td height="24" nowrap="" bgcolor="#FFFFFF">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="editProduct" idth="100%">
                                            <tbody>
                                                <tr>
                                                    <td height="30" align="right">&nbsp;</td>
                                                    <td><select onchange="window.location.href='?gid='+$(this).children('option:selected').val()"><option value="0">默认条件与规则</option><?php foreach($group as $key=>$val){ ?><option value="<?php echo $key.($key==$gid?'" selected="true':''); ?>">会员组[<?php echo $val; ?>]</option><?php } ?></select><?php if($gid>0){ ?>&nbsp;<a href="?gid=<?php echo $gid; ?>&amp;reset=true" onclick="return confirm('重置后将丢失自定义设置的条件与规则，是否继续？')">重置该会员组独立设置</a><?php } ?></td>
                                                </tr>
<?php if($gid>0){ ?>                                               <tr>
                                                    <td height="30" align="right">会员组领取权限：</td>
                                                    <td><input type="radio" name="disable" value="0" <?php echo !isset($config['disable'])||$config['disable']!=1?' checked="true"':''; ?>/>启用&nbsp;&nbsp;<input type="radio" name="disable" value="1" <?php echo isset($config['disable'])&&$config['disable']==1?' checked="true"':''; ?>/>关闭</td>
                                                </tr>
                                                <tr>
                                                    <td height="30" align="right">继承默认条件：</td>
                                                    <td><input type="radio" name="default1" value="0" <?php echo !isset($config['default'][0])||$config['default'][0]!=1?' checked="true"':''; ?>/>启用&nbsp;&nbsp;<input type="radio" name="default1" value="1" <?php echo isset($config['default'][0])&&$config['default'][0]==1?' checked="true"':''; ?>/>关闭</td>
                                                </tr>
<?php } ?>                                               <tr>
                                                    <td height="25" align="right">次数增加条件：</td>
                                                    <td><a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_01.gif) no-repeat left center;" onclick="$('#addLimit').clone(true).show().appendTo('#limitList')">添加</a></td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right">&nbsp;</td>
                                                    <td>
                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="limitList">
                                                            <tr id="addLimit" style="display:none">
                                                                <td align="left" style="line-height:23px;padding-bottom:3px">
                                                                    <input type="hidden" name="data[type][]" />
                                                                    <select onchange="$(this).prev('input').val($(this).children('option:selected').map(function(){return $(this).val()}).get().join(','))" multiple="true" size="5"><?php foreach($type as $key=>$val){ ?><option value="<?php echo $key; ?>"><?php echo $val; ?></option><?php } ?></select>按住 Ctrl 可多选<br />
                                                                    <select name="data[option1][]"><option value="0">大于等于</option><option value="1">每满</option></select>
                                                                    <input type="text" class="textfield" size="8" name="data[option2][]" value="0.00" />
                                                                    <span>元，增加</span>
                                                                    <input type="text" class="textfield" size="8" name="data[option3][]" value="0" />
                                                                    <span>次</span><br />
                                                                    <span>统计开始时间：</span>
                                                                    <input type="text" class="textfield" value="<?php echo date('Y-m-d', $packets['opentime']); ?>" onclick="new Calendar(<?php echo date('Y')-1; ?>, <?php echo date('Y')+5; ?>).show(this);" size="10" maxlength="10" name="data[s_date][]" readonly="readonly"/>
                                                                    <select name="data[s_hour][]"><?php for($i=0;$i<24;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('H', $packets['opentime'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="data[s_minute][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('i', $packets['opentime'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="data[s_second][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('s', $packets['opentime'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select><br />
                                                                    <span>统计结束时间：</span>
                                                                    <input type="text" class="textfield" value="<?php echo date('Y-m-d', $packets['closetime']-86400); ?>" onclick="new Calendar(<?php echo date('Y')-1; ?>, <?php echo date('Y')+5; ?>).show(this);" size="10" maxlength="10" name="data[e_date][]" readonly="readonly"/>
                                                                    <select name="data[e_hour][]"><?php for($i=0;$i<24;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('H', $packets['closetime'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="data[e_minute][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('i', $packets['closetime'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="data[e_second][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('s', $packets['closetime'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_02.gif) no-repeat left center;" onclick="$(this).parent().remove()">删除</a>
                                                                </td>
                                                            </tr>
<?php
if(!isset($config['data'])){
    $config['data'] = array();
    isset($packets['group'][0])&&isset($packets['group'][0]['data'])&&$config['data'] = $packets['group'][0]['data'];
}
foreach($config['data'] as $val){
    !isset($val['option'])&&$val['option'] = array(0, 0, 0);
?>                                                           <tr>
                                                                <td align="left" style="line-height:23px;padding-bottom:3px">
                                                                    <input type="hidden" name="data[type][]" value="<?php echo implode(',', $val['type']); ?>" />
                                                                    <select onchange="$(this).prev('input').val($(this).children('option:selected').map(function(){return $(this).val()}).get().join(','))" multiple="true" size="5"><?php foreach($type as $k=>$v){ ?><option value="<?php echo $k.(in_array($k, $val['type'])?'" selected="true':''); ?>"><?php echo $v; ?></option><?php } ?></select>按住 Ctrl 可多选<br />
                                                                    <select name="data[option1][]"><option value="0"<?php echo !isset($val['option'][0])||$val['option'][0]!=1?'" selected="true"':''; ?>>大于等于</option><option value="1"<?php echo isset($val['option'][0])&&$val['option'][0]==1?'" selected="true"':''; ?>>每满</option></select>
                                                                    <input type="text" class="textfield" size="8" name="data[option2][]" value="<?php echo sprintf('%.2f', $val['option'][1]/100); ?>" />
                                                                    <span>元，增加</span>
                                                                    <input type="text" class="textfield" size="8" name="data[option3][]" value="<?php echo $val['option'][2]; ?>" />
                                                                    <span>次</span><br />
                                                                    <span>统计开始时间：</span>
                                                                    <input type="text" class="textfield" value="<?php echo date('Y-m-d', $val['start']); ?>" onclick="new Calendar(<?php echo date('Y')-1; ?>, <?php echo date('Y')+5; ?>).show(this);" size="10" maxlength="10" name="data[s_date][]" readonly="readonly"/>
                                                                    <select name="data[s_hour][]"><?php for($i=0;$i<24;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('H', $val['start'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="data[s_minute][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('i', $val['start'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="data[s_second][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('s', $val['start'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select><br />
                                                                    <span>统计结束时间：</span>
                                                                    <input type="text" class="textfield" value="<?php echo date('Y-m-d', $val['end']); ?>" onclick="new Calendar(<?php echo date('Y')-1; ?>, <?php echo date('Y')+5; ?>).show(this);" size="10" maxlength="10" name="data[e_date][]" readonly="readonly"/>
                                                                    <select name="data[e_hour][]"><?php for($i=0;$i<24;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('H', $val['end'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="data[e_minute][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('i', $val['end'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="data[e_second][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('s', $val['end'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_02.gif) no-repeat left center;" onclick="$(this).parent().remove()">删除</a>
                                                                </td>
                                                            </tr>
<?php } ?>                                                       </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right" style="color:red">次数提示1：</td>
                                                    <td style="color:red">“统计开始时间”可以大于“总开始时间”，但是只有“次数有效期”为“总结束时间内有效”才会统计数据。</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right" style="color:red">次数提示2：</td>
                                                    <td style="color:red">条件可多次成立，如果满足多个条件，则按照设定多次添加次数。</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right" style="color:red">次数提示3：</td>
                                                    <td style="color:red">所有时间以 EST（美东时间） 为准</td>
                                                </tr>
<?php if($gid>0){ ?>                                               <tr>
                                                    <td height="30" align="right">继承默认规则：</td>
                                                    <td><input type="radio" name="default2" value="0" <?php echo !isset($config['default'][1])||$config['default'][1]!=1?' checked="true"':''; ?>/>启用&nbsp;&nbsp;<input type="radio" name="default2" value="1" <?php echo isset($config['default'][1])&&$config['default'][1]==1?' checked="true"':''; ?>/>关闭</td>
                                                </tr>
<?php } ?>                                               <tr>
                                                <tr>
                                                    <td height="25" align="right">红包奖励规则：</td>
                                                    <td><a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_01.gif) no-repeat left center;" onclick="$('#addRule').clone(true).show().appendTo('#ruleList')">添加</a>&nbsp;提示：概率基数越大出现概率越高</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right">&nbsp;</td>
                                                    <td>
                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="ruleList">
                                                            <tr id="addRule" style="display:none">
                                                                <td align="left" style="line-height:25px">
                                                                    <span>最小奖励：</span>
                                                                    <input type="text" class="textfield" size="7" name="rule[option1][]" value="0.00" />
                                                                    <span>最大奖励：</span>
                                                                    <input type="text" class="textfield" size="7" name="rule[option2][]" value="0.00" />
                                                                    <span>概率基数：</span>
                                                                    <input type="text" class="textfield" size="7" name="rule[option3][]" value="0" />
                                                                    <span>提示信息：</span>
                                                                    <input type="text" class="textfield" size="12" name="rule[option4][]" value="" />
                                                                    <a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_02.gif) no-repeat left center;" onclick="$(this).parent().remove()">删除</a>
                                                                </td>
                                                            </tr>
<?php
if(!isset($config['rule'])){
    $config['rule'] = array();
    isset($packets['group'][0])&&isset($packets['group'][0]['rule'])&&$config['rule'] = $packets['group'][0]['rule'];
}
foreach($config['rule'] as $val){
?>                                                           <tr>
                                                                <td align="left" style="line-height:23px;padding-bottom:3px">
                                                                    <span>最小奖励：</span>
                                                                    <input type="text" class="textfield" size="7" name="rule[option1][]" value="<?php echo sprintf('%.2f', $val[0]/100); ?>" />
                                                                    <span>最大奖励：</span>
                                                                    <input type="text" class="textfield" size="7" name="rule[option2][]" value="<?php echo sprintf('%.2f', $val[1]/100); ?>" />
                                                                    <span>概率基数：</span>
                                                                    <input type="text" class="textfield" size="7" name="rule[option3][]" value="<?php echo $val[2]; ?>" />
                                                                    <span>提示信息：</span>
                                                                    <input type="text" class="textfield" size="12" name="rule[option4][]" value="<?php echo $val[3]; ?>" />
                                                                    <a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_02.gif) no-repeat left center;" onclick="$(this).parent().remove()">删除</a>
                                                                </td>
                                                            </tr>
<?php } ?>                                                       </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right" style="color:red">奖励提示1：</td>
                                                    <td style="color:red">如果不设置奖励规则，则表示100%不会中奖，页面提示“谢谢参与”</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right" style="color:red">奖励提示2：</td>
                                                    <td style="color:red">“最小奖励”与“最大奖励”相同则表示为固定奖励</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right" style="color:red">奖励提示3：</td>
                                                    <td style="color:red">每条规则的概率为：“概率基数” ÷ 所有“概率基数”之和</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right">&nbsp;</td>
                                                    <td><input type="submit" class="button" value="保存" style="width: 60;" /></td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right">&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>  
</body>
</html>