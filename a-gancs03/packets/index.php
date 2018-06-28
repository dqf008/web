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
!isset($packets['opentime'])&&$packets['opentime'] = strtotime(date('Y-m-d'));
!isset($packets['closetime'])&&$packets['closetime'] = strtotime(date('Y-m-d 23:59:59'));
!isset($packets['domain'])&&$packets['domain'] = array();
!isset($packets['limit'])&&$packets['limit'] = array(array(
    'start' => 0,
    'end' => 86399,
    'user' => 0,
    'money' => 0,
));

if(isset($_POST['action'])&&$_POST['action']=='save'){
    $packets['open'] = isset($_POST['open'])&&$_POST['open']==1?1:0; //系统总开关
    $packets['position'] = isset($_POST['position'])&&in_array($_POST['position'], array(1, 2, 3, 4))?intval($_POST['position']):0; //红包图标位置
    $packets['valid'] = isset($_POST['valid'])&&$_POST['valid']==1?1:0; //次数有效期
    $packets['auto'] = isset($_POST['auto'])&&$_POST['auto']==1?1:0; //派彩方式
    /* 总开始时间 */
    $opentime = '';
    isset($_POST['opendate'])&&$opentime.= $_POST['opendate'].' ';
    isset($_POST['openhour'])&&$opentime.= $_POST['openhour'];
    isset($_POST['openminute'])&&$opentime.= ':'.$_POST['openminute'];
    isset($_POST['opensecond'])&&$opentime.= ':'.$_POST['opensecond'];
    $opentime = strtotime($opentime);
    $opentime&&$packets['opentime'] = $opentime;
    /* 总结束时间 */
    $closetime = '';
    isset($_POST['closedate'])&&$closetime.= $_POST['closedate'].' ';
    isset($_POST['closehour'])&&$closetime.= $_POST['closehour'];
    isset($_POST['closeminute'])&&$closetime.= ':'.$_POST['closeminute'];
    isset($_POST['closesecond'])&&$closetime.= ':'.$_POST['closesecond'];
    $closetime = strtotime($closetime);
    $closetime&&$packets['closetime'] = $closetime;
    /* 红包雨时间段 */
    $packets['limit'] = array();
    if(isset($_POST['limit'])&&isset($_POST['limit']['s_hour'])&&isset($_POST['limit']['s_minute'])&&isset($_POST['limit']['s_second'])&&isset($_POST['limit']['e_hour'])&&isset($_POST['limit']['e_minute'])&&isset($_POST['limit']['e_second'])&&isset($_POST['limit']['user'])&&isset($_POST['limit']['money'])){
        foreach($_POST['limit']['s_hour'] as $key=>$val){
            if($key>0){
                $start = '1970-01-01 '.$val;
                isset($_POST['limit']['s_minute'][$key])&&$start.= ':'.$_POST['limit']['s_minute'][$key];
                isset($_POST['limit']['s_second'][$key])&&$start.= ':'.$_POST['limit']['s_second'][$key];
                $start = strtotime($start);
                $end = '1970-01-01 ';
                isset($_POST['limit']['e_hour'][$key])&&$end.= $_POST['limit']['e_hour'][$key];
                isset($_POST['limit']['e_minute'][$key])&&$end.= ':'.$_POST['limit']['e_minute'][$key];
                isset($_POST['limit']['e_second'][$key])&&$end.= ':'.$_POST['limit']['e_second'][$key];
                $end = strtotime($end);
                (!isset($_POST['limit']['user'][$key])||!preg_match('/^[1-9]\d*$/', $_POST['limit']['user'][$key]))&&$_POST['limit']['user'][$key] = 0;
                (!isset($_POST['limit']['money'][$key])||!preg_match('/^[1-9]\d*(\.\d+)?$|^0\.\d+$/', $_POST['limit']['money'][$key]))&&$_POST['limit']['money'][$key] = 0;
                $packets['limit'][] = array(
                    'start' => $start-14400,
                    'end' => $end-14400,
                    'user' => intval($_POST['limit']['user'][$key]),
                    'money' => intval($_POST['limit']['money'][$key]*100),
                );
            }
        }
    }
    /* 域名列表 */
    $packets['domain'] = array();
    if(isset($_POST['domain'])&&!empty($_POST['domain'])){
        $_POST['domain'] = str_replace(array("\r\n", "\n\r", "\r"), "\n", $_POST['domain']);
        $_POST['domain'] = explode("\n", $_POST['domain']);
        foreach($_POST['domain'] as $val){
            $val = trim($val);
            $val!=''&&$packets['domain'][] = $val;
        }
    }
    $packets['allow_mobile'] = isset($_POST['allow_mobile'])&&$_POST['allow_mobile']==1?1:0; //允许无手机号
    $packets['allow_bank'] = isset($_POST['allow_bank'])&&$_POST['allow_bank']==1?1:0; //允许无银行卡信息
    $packets['allow_daili'] = isset($_POST['allow_daili'])&&$_POST['allow_daili']==1?1:0; //允许代理账号领取
    $packets['showtime'] = isset($_POST['showtime'])&&$_POST['showtime']==1?1:0; //公示名单时间
    $packets['showorder'] = isset($_POST['showorder'])&&$_POST['showorder']==1?1:0; //公示名单排序
    $packets['web_domain'] = isset($_POST['web_domain'])?$_POST['web_domain']:''; //公示名单排序
    $packets['service_url'] = isset($_POST['service_url'])?$_POST['service_url']:''; //公示名单排序
    $stmt = $mydata1_db->prepare('UPDATE `packets_config` SET `value`=? WHERE `uid`=0');
    $stmt->execute(array(serialize($packets)));
    file_put_contents('../../cache/packets.php', '<?php'.PHP_EOL.'return unserialize(\''.serialize($packets['domain']).'\');');
    admin::insert_log($_SESSION['adminid'], '修改了红包系统设置');
    message('保存成功！', $_SERVER['HTTP_REFERER']);
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
    <form action="index.php" method="POST">
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
            <tbody>
                <tr>
                    <td height="24" nowrap="" background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle" />&nbsp;红包系统：全局设定</td>
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
                                                    <td height="30" align="right">红包系统：</td>
                                                    <td><input type="radio" name="open" value="1" <?php echo isset($packets['open'])&&$packets['open']==1?' checked="true"':''; ?>/>启用&nbsp;&nbsp;<input type="radio" name="open" value="0" <?php echo !isset($packets['open'])||$packets['open']!=1?' checked="true"':''; ?>/>关闭</td>
                                                </tr>
                                                <tr>
                                                    <td height="30" align="right">红包图标显示位置：</td>
                                                    <td>
                                                        <select name="position">
                                                            <option value="0"<?php echo !isset($packets['position'])?' selected="true"':''; ?>>不显示图标</option>
                                                            <option value="1"<?php echo isset($packets['position'])&&$packets['position']==1?' selected="true"':''; ?>>左上角↖</option>
                                                            <option value="2"<?php echo isset($packets['position'])&&$packets['position']==2?' selected="true"':''; ?>>右上角↗</option>
                                                            <option value="3"<?php echo isset($packets['position'])&&$packets['position']==3?' selected="true"':''; ?>>左下角↙</option>
                                                            <option value="4"<?php echo isset($packets['position'])&&$packets['position']==4?' selected="true"':''; ?>>右下角↘</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="30" align="right">总开始时间：</td>
                                                    <td>
                                                        <input type="text" class="textfield" value="<?php echo date('Y-m-d', $packets['opentime']); ?>" onclick="new Calendar(<?php echo date('Y')-1; ?>, <?php echo date('Y')+5; ?>).show(this);" size="10" maxlength="10" name="opendate" readonly="readonly"/>
                                                        <select name="openhour"><?php for($i=0;$i<24;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('H', $packets['opentime'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                        <select name="openminute"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('i', $packets['opentime'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                        <select name="opensecond"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('s', $packets['opentime'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="30" align="right">总结束时间：</td>
                                                    <td>
                                                        <input type="text" class="textfield" value="<?php echo date('Y-m-d', $packets['closetime']); ?>" onclick="new Calendar(<?php echo date('Y')-1; ?>, <?php echo date('Y')+5; ?>).show(this);" size="10" maxlength="10" name="closedate" readonly="readonly"/>
                                                        <select name="closehour"><?php for($i=0;$i<24;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('H', $packets['closetime'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                        <select name="closeminute"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('i', $packets['closetime'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                        <select name="closesecond"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('s', $packets['closetime'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="30" align="right">次数有效期：</td>
                                                    <td><input type="radio" name="valid" value="0" <?php echo !isset($packets['valid'])||$packets['valid']!=1?' checked="true"':''; ?>/>当天有效&nbsp;&nbsp;<input type="radio" name="valid" value="1" <?php echo isset($packets['valid'])&&$packets['valid']==1?' checked="true"':''; ?>/>总结束时间内有效</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right" style="color:red">次数提示：</td>
                                                    <td style="color:red">“当天有效”只统计“昨日”数据，“总结束时间内有效”可按设定时间统计数据</td>
                                                </tr>
                                                <tr>
                                                    <td height="30" align="right">派彩方式：</td>
                                                    <td><input type="radio" name="auto" value="0" <?php echo !isset($packets['auto'])||$packets['auto']!=1?' checked="true"':''; ?>/>自动派彩&nbsp;&nbsp;<input type="radio" name="auto" value="1" <?php echo isset($packets['auto'])&&$packets['auto']==1?' checked="true"':''; ?>/>手工派彩</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right">红包雨时间段：</td>
                                                    <td><a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_01.gif) no-repeat left center;" onclick="$('#addLimit').clone(true).show().appendTo('#limitList')">添加</a>&nbsp;彩池额度设置为0则表示无限制，单位：元，人数限制设置为0则不限制</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right">&nbsp;</td>
                                                    <td>
                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="limitList">
                                                            <tr id="addLimit" style="display:none">
                                                                <td height="50" align="left">
                                                                    <span>开始：</span>
                                                                    <select name="limit[s_hour][]"><?php for($i=0;$i<24;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="limit[s_minute][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="limit[s_second][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <span>红包数量：</span>
                                                                    <input type="text" class="textfield" size="8" name="limit[user][]" value="0" /><br />
                                                                    <span>结束：</span>
                                                                    <select name="limit[e_hour][]"><?php for($i=0;$i<24;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="limit[e_minute][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="limit[e_second][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <span>红包彩池：</span>
                                                                    <input type="text" class="textfield" size="8" name="limit[money][]" value="0.00" />
                                                                    <a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_02.gif) no-repeat left center;" onclick="$(this).parent().remove()">删除</a>
                                                                </td>
                                                            </tr>
<?php
foreach($packets['limit'] as $val){
    $val['start']+= 14400;
    $val['end']+= 14400;
    $val['money'] = sprintf('%.2f', $val['money']/100);
?>                                                           <tr>
                                                                <td height="50" align="left">
                                                                    <span>开始：</span>
                                                                    <select name="limit[s_hour][]"><?php for($i=0;$i<24;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('H', $val['start'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="limit[s_minute][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('i', $val['start'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="limit[s_second][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('s', $val['start'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <span>红包数量：</span>
                                                                    <input type="text" class="textfield" size="8" name="limit[user][]" value="<?php echo $val['user']; ?>" /><br />
                                                                    <span>结束：</span>
                                                                    <select name="limit[e_hour][]"><?php for($i=0;$i<24;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('H', $val['end'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="limit[e_minute][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('i', $val['end'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <select name="limit[e_second][]"><?php for($i=0;$i<60;$i++){$i<10&&$i='0'.$i; ?><option value="<?php echo $i.($i==date('s', $val['end'])?'" selected="true':''); ?>"><?php echo $i; ?></option><?php } ?></select>
                                                                    <span>红包彩池：</span>
                                                                    <input type="text" class="textfield" size="8" name="limit[money][]" value="<?php echo $val['money']; ?>" />
                                                                    <a href="javascript:;" style="padding:5px 0 5px 20px;background:url(../images/bvbv_02.gif) no-repeat left center;" onclick="$(this).parent().remove()">删除</a>
                                                                </td>
                                                            </tr>
<?php } ?>                                                       </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right" style="color:red">时间段提示1：</td>
                                                    <td style="color:red">至少需要添加一个时间段，否则提示活动已结束，如需全天请设置00:00:00至23:59:59</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right" style="color:red">时间段提示2：</td>
                                                    <td style="color:red">“红包数量”和“红包彩池”可以同时设置，其中一个先归零则本时段结束</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right">活动域名：</td>
                                                    <td><textarea name="domain" cols="40" class="textfield" rows="5"><?php echo implode('&#13;&#10;', $packets['domain']); ?></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right" style="color:red">域名提示：</td>
                                                    <td style="color:red">一行一个域名，支持通配符：*，例如“hb.*”则表示hb开头的二级域名均为活动域名。</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right">网站主域名：</td>
                                                    <td><input name="web_domain" type="text" class="textfield" value="<?php echo isset($packets['web_domain'])?htmlspecialchars($packets['web_domain']):''; ?>" size="50" /></td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right">活动客服链接：</td>
                                                    <td><input name="service_url" type="text" class="textfield" value="<?php echo isset($packets['service_url'])?htmlspecialchars($packets['service_url']):''; ?>" size="80" /></td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right">其它限制：</td>
                                                    <td><input name="allow_mobile" type="checkbox" value="1"<?php echo isset($packets['allow_mobile'])&&$packets['allow_mobile']==1?' checked="true"':''; ?>/>允许无手机号码&nbsp;<input name="allow_bank" type="checkbox" value="1"<?php echo isset($packets['allow_bank'])&&$packets['allow_bank']==1?' checked="true"':''; ?>/>允许无银行卡资料&nbsp;<input name="allow_daili" type="checkbox" value="1"<?php echo isset($packets['allow_daili'])&&$packets['allow_daili']==1?' checked="true"':''; ?>/>允许代理账号领取</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right">公示名单时间：</td>
                                                    <td><input type="radio" name="showtime" value="0" <?php echo !isset($packets['showtime'])||$packets['showtime']!=1?' checked="true"':''; ?>/>活动总开始时间&nbsp;&nbsp;<input type="radio" name="showtime" value="1" <?php echo isset($packets['showtime'])&&$packets['showtime']==1?' checked="true"':''; ?>/>最近24小时</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right">公示名单排序：</td>
                                                    <td><input type="radio" name="showorder" value="0" <?php echo !isset($packets['showorder'])||$packets['showorder']!=1?' checked="true"':''; ?>/>按时间由近到远&nbsp;&nbsp;<input type="radio" name="showorder" value="1" <?php echo isset($packets['showorder'])&&$packets['showorder']==1?' checked="true"':''; ?>/>按金额由大到小</td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="right" style="color:red">时间说明：</td>
                                                    <td style="color:red">所有时间以 EST（美东时间） 为准</td>
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