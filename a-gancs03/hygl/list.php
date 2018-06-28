<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('hygl');
include_once '../../include/newPage.php';
include_once '../../class/user.php';
$xinxi = false;
if(!empty($_SESSION['pass'])) $xinxi = true;

if(!empty($_GET['save'])){
    $pwd = file_get_contents('../../cache/pwd.php');
    $pwd || $pwd = '123456';
    if($_GET['pwd'] == $pwd){
        $_SESSION['pass'] = true;
        $xinxi = true;
        die('0');
    }else{
        die('1');
    }
}
$params = array();
$sql = 'select distinct u.uid,ul.is_login as ul_type from k_user u left join k_group g on u.gid=g.id left join k_user_login ul on u.uid=ul.uid where u.is_delete=0 ';
if (isset($_GET['likevalue'])) {
    switch ($_GET['selecttype']) {
        case 'username':
        case 'pay_name':
        case 'reg_ip':
        case 'login_ip':
        case 'name':
        case 'reg_address':
        case 'mobile':
            $selecttype = $_GET['selecttype'];
            break;
        default:
            $selecttype = 'username';
            break;
    }
    $params[':likevalue'] = '%' . $_GET['likevalue'] . '%';
    if ($selecttype == 'name') {
        $sql .= ' and g.name like :likevalue';
    } else {
        $sql .= ' and u.' . $selecttype . ' like :likevalue';
    }
}else{
	$_GET['selecttype'] = 'username';
}

if (isset($_GET['uids']) && !empty($_GET['uids'])) {
	$uids = $_GET['uids'];
    $sql .= "  and u.uid in({$uids})";
}


if (isset($_GET['is_login'])) {
    $params[':is_login'] = $_GET['is_login'];
    $sql .= '  and ul.is_login=:is_login';
}

if (isset($_GET['is_stop'])) {
    $params[':is_stop'] = $_GET['is_stop'];
    $sql .= '  and u.is_stop=:is_stop';
}

if (isset($_GET['is_daili'])) {
    $params[':is_daili'] = intval($_GET['is_daili']);
    $sql .= '  and u.is_daili=:is_daili';
}

if (isset($_GET['top_uid'])) {
    $params[':top_uid'] = $_GET['top_uid'];
    $sql .= '  and u.top_uid=:top_uid';
}

if (isset($_GET['money'])) {
    $sql .= ' and u.money<0';
}

if (isset($_GET['month'])) {
    $params[':reg_date'] = $_GET['month'] . '%';
    $sql .= ' and u.reg_date like(:reg_date)';
}

$order = 'u.uid';
if(!empty($_GET['order'])){
	switch ($_GET['order']) {
    case 'money':
    case 'ul_type desc,uid':
        $order = $_GET['order'];
        break;
	}
}


$desc = ' order by ' . $order . ' desc';

$stmt = $mydata1_db->prepare($sql . $desc);
$stmt->execute($params);
$sum = $stmt->rowCount();
$thisPage = empty($_GET['page'])?'1':$_GET['page'];

$page = new newPage();
$thisPage = $page->check_Page($thisPage, $sum, 20, 40);
$uid = '';
$i = 1;
$start = (($thisPage - 1) * 20) + 1;
$end = $thisPage * 20;
while ($row = $stmt->fetch()) {
    if (($start <= $i) && ($i <= $end)) {
        $uid .= intval($row['uid']) . ',';
    }

    if ($end < $i) {
        break;
    }
    $i++;
}
?>
<html>
<head>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8"/>
    <title>用户列表</title>
    <style type="text/css">
        .STYLE2 {
            font-size: 12px
        }

        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }

        td {
            font: 13px/120% "宋体";
            padding: 3px;
        }

        a {

            color: #F37605;

            text-decoration: none;

        }

        .t-title {
            background: url(../images/06.gif);
            height: 24px;
        }

        .t-tilte td {
            font-weight: 800;
        }

        .STYLE4 {
            color: #FF0000;
            font-size: 12px;
        }
        .color2 {
            color: #225d9c;
        }
        .color3 {
            color: red;
        }
    </style>
</head>
<script>
    function ckall() {
        for (var i = 0; i < document.form2.elements.length; i++) {
            var e = document.form2.elements[i];
            if (e.name != 'checkall') e.checked = document.form2.checkall.checked;
        }
    }

    function check() {
        var len = document.form2.elements.length;
        var num = false;
        for (var i = 0; i < len; i++) {
            var e = document.form2.elements[i];
            if (e.checked && e.name == 'uid[]') {
                num = true;
                break;
            }
        }
        if (num) {
            var action = document.getElementById("s_action").value;
            if (action == "0") {
                alert("请您选择要执行的相关操作！");
                return false;
            } else {
                if (action == "2") document.form2.action = "stopuser.php?go=0&page=<?=$thisPage?>";
                if (action == "1") document.form2.action = "stopuser.php?go=1&page=<?=$thisPage?>";
                if (action == "3") document.form2.action = "stopuser.php?go=3&page=<?=$thisPage?>";
                if (action == "8") document.form2.action = "stopuser.php?go=8&page=<?=$thisPage?>";
                if (action == "9") document.form2.action = "stopuser.php?go=9&page=<?=$thisPage?>";
                if (action == "5") document.form2.action = "set_pwd.php";
                if (action == "4") {
                    if (confirm('确认取消该会员代理资格？取消后此代理的所有下级会员都不再属于该代理！')) {
                        document.form2.action = "stopuser.php?go=4&page=<?=$thisPage?>";
                    } else {
                        return false;
                    }
                }
                if (action == "6") {
                    if (confirm('确认删除该会员吗？删除后不可恢复，请谨慎操作！')) {
                        document.form2.action = "stopuser.php?go=6&page=<?=$thisPage?>";
                    } else {
                        return false;
                    }
                }
                if (action == "7") {
                    var daili = prompt("输入代理账号", "");
                    if (daili != "" && daili != null) {
                        document.form2.action = "stopuser.php?go=7&page=<?=$thisPage?>&daili=" + daili;
                    } else {
                        if (daili == "") {
                            alert("未输入代理账号！");
                        }
                        return false;
                    }
                }
            }
        } else {
            alert("您未选中任何复选框");
            return false;
        }
    }
</script>
<script type="text/javascript" src="/skin/js/jquery-1.7.2.min.js"></script>

<script language="javascript">
    function live_money(uid, username) {
        document.getElementById('light').style.display = 'block';
        document.getElementById('fade').style.display = 'block';
        $("#tit_name").html(username + "平台余额查询");
        $("#zzuid").val('');
        $("#zzuid").val(uid);
        reflivemoney_one(uid);
    }

    function reflivemoney_one(uid) {
        $("td[id$=_money]").html('<img src="/Box/skins/icons/loading.gif" />');
        $.getJSON("/cj/live/live_money_db.php?callback=?&uid=" + uid, function (data) {
            if (data.info == 'ok') {
                $('[code=AGIN]').find('.money').html(data.AGIN);
                $('[code=AGIN]').find('.name').html(data.agName);

                $('[code=AG]').find('.money').html(data.AG);
                $('[code=AG]').find('.name').html(data.agqName);

                $('[code=BBIN]').find('.money').html(data.BBIN);
                $('[code=BBIN]').find('.name').html(data.bbinName);

                $('[code=MAYA]').find('.money').html(data.MAYA);
                $('[code=MAYA]').find('.name').html(data.mayaName);

                $('[code=SHABA]').find('.money').html(data.SHABA);
                $('[code=SHABA]').find('.name').html(data.shabaName);

                $('[code=MW]').find('.money').html(data.MW);
                $('[code=MW]').find('.name').html(data.mwName);

                $('[code=KG]').find('.money').html(data.KG);
                $('[code=KG]').find('.name').html(data.kgName);

                $('[code=CQ9]').find('.money').html(data.CQ9);
                $('[code=CQ9]').find('.name').html(data.cq9Name);

                $('[code=MG2]').find('.money').html(data.MG2);
                $('[code=MG2]').find('.name').html(data.mg2Name);

                $('[code=VR]').find('.money').html(data.VR);
                $('[code=VR]').find('.name').html(data.vrName);

                $('[code=BG]').find('.money').html(data.BGLIVE);
                $('[code=BG]').find('.name').html(data.bgName);

                $('[code=SB]').find('.money').html(data.SB);
                $('[code=SB]').find('.name').html(data.sbName);

                $('[code=PT2]').find('.money').html(data.PT2);
                $('[code=PT2]').find('.name').html(data.pt2Name);

                $('[code=OG2]').find('.money').html(data.OG2);
                $('[code=OG2]').find('.name').html(data.og2Name);

                $('[code=DG]').find('.money').html(data.DG);
                $('[code=DG]').find('.name').html(data.dgName);

                $('[code=OG]').find('.money').html(data.OG);
                $('[code=OG]').find('.name').html(data.ogName);

                $('[code=PT]').find('.money').html(data.PT);
                $('[code=PT]').find('.name').html(data.ptName);
                
                $('[code=MG]').find('.money').html(data.MG);
                $('[code=MG]').find('.name').html(data.mgName);

                $('[code=KY]').find('.money').html(data.KY);
                $('[code=KY]').find('.name').html(data.kyName);

                $('[code=BBIN2]').find('.money').html(data.BBIN2);
                $('[code=BBIN2]').find('.name').html(data.bbin2Name);
            } else {
                $("td[id$=_money]").html(data.msg);
            }
        });
    }

    $(function(){
        $('[code] .btn').click(function(){
            var uid = $("#zzuid").val();
            if (!uid) alert('该会员不存在!!');
            var obj = $(this).parent().parent();
            var money = obj.find('.money');
            var code = $(obj).attr('code');
            var name = $(obj).find('.name');
            money.html('<img src="/Box/skins/icons/loading.gif" />');
            var url = "/cj/live/live_money.php?callback=?&type=" + code;
            switch(code){
                case 'MAYA': url = '/cj/live/live_money_MAYA.php?callback=?';break;
                case 'MW': url = '/cj/live/live_money_MW.php?callback=?';break;
                case 'KG': url = '/cj/live/live_money_KG.php?callback=?';break;
                case 'CQ9': url = '/cj/live/live_money_CQ9.php?callback=?';break;
                case 'MG2': url = '/cj/live/live_money_MG2.php?callback=?';break;
                case 'VR': url = '/cj/live/live_money_VR.php?callback=?';break;
                case 'BG': url = '/cj/live/live_money_BG.php?callback=?';break;
                case 'SB': url = '/cj/live/live_money_SB.php?callback=?';break;
                case 'PT2': url = '/cj/live/live_money_PT.php?callback=?';break;
                case 'OG2': url = '/cj/live/live_money_og.php?callback=?';break;
                case 'DG': url = '/cj/live/live_money_dg.php?callback=?';break;
                case 'KY': url = '/cj/live/live_money_ky.php?callback=?';break;
                case 'BBIN2': url = '/cj/live/live_money_bbin.php?callback=?';break;
            }
            url = url + '&uid=' + uid;
            $.getJSON(url, function (data) {
                money.html(data.msg);
                name.html(data.name);
            });
        });

        $('[code] .in').click(function(){
            var uid = $("#zzuid").val();
            if (!uid) alert('该会员不存在!!');
            var obj = $(this).parent().parent();
            var code = $(obj).attr('code');
            var name = $(obj).find('.name');
            var moneyObj = $(obj).find('.money2');
            var money = moneyObj.val();
            var btn = $(obj).find('.in');
            var type = $(obj).find('select').val();
            if(money == ''){alert('请输入转账金额');moneyObj.focus();return false;}
            btn.html("处理中").attr('disabled', true);
            $.getJSON("/cj/live/live_ht_giro.php?callback=?&uid=" + uid + "&moneyType=" + type + "&zrtype=" + code + "&zrmoney=" + money + "&typeGiro=IN", function (data) {
                if (data.info == 'ok') {
                    alert('转入成功!!');
                    moneyObj.val('');
                    obj.find('.btn').trigger('click');
                } else {
                    alert(data.info);
                }
                btn.html("转入").attr('disabled', false);
            });
        });

        $('[code] .out').click(function(){
            var uid = $("#zzuid").val();
            if (!uid) alert('该会员不存在!!');
            var obj = $(this).parent().parent();
            var code = $(obj).attr('code');
            var name = $(obj).find('.name');
            var moneyObj = $(obj).find('.money2');
            var money = moneyObj.val();
            var btn = $(obj).find('.out');
            var type = $(obj).find('select').val();
            if(money == ''){alert('请输入转账金额');moneyObj.focus();return false;}
            btn.html("处理中").attr('disabled', true);
            $.getJSON("/cj/live/live_ht_giro.php?callback=?&uid=" + uid + "&moneyType=" + type + "&zrtype=" + code + "&zrmoney=" + money + "&typeGiro=OUT", function (data) {
                if (data.info == 'ok') {
                    alert('转出成功!!');
                    moneyObj.val('');
                    obj.find('.btn').trigger('click');
                } else {
                    alert(data.info);
                }
                btn.html("转出").attr('disabled', false);
            });
        });
    });

    //数字验证 过滤非法字符
    function clearNoNum(obj) {
        obj.value = obj.value.replace(/[^\d.]/g, "");//先把非数字的都替换掉，除了数字和.
        obj.value = obj.value.replace(/^\./g, "");//必须保证第一个为数字而不是.
        obj.value = obj.value.replace(/\.{2,}/g, ".");//保证只有出现一个.而没有多个.
        obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");//保证.只出现一次，而不能出现两次以上
        if (obj.value != '') {
            var re = /^\d+\.{0,1}\d{0,2}$/;
            if (!re.test(obj.value)) {
                obj.value = obj.value.substring(0, obj.value.length - 1);
                return false;
            }
        }
    }

    function closeZ() {
        document.getElementById('light').style.display = 'none';
        document.getElementById('fade').style.display = 'none';
        $("#tit_name").html("平台余额查询");

    }
</script>


<body>
<style>
    .black_overlay {
        display: none;
        position: fixed;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index: 1001;
        -moz-opacity: 0.4;
        opacity: .40;
        filter: alpha(opacity=40);
    }

    .white_content {
        display: none;
        position: fixed;
        top: 0%;
        left: 5%;
        width: 680px;
        height: 535px;
        border: 8px solid #400000;
        background-color: white;
        z-index: 1002;
        overflow: auto;
    }
    .white_content .btn{
       cursor: pointer;
       color: #F37605;
    }
    .white_content .money{
        color:#FF0000;
        margin-right: 5px;
    }
    .white_content select{
        margin-right: 5px;
    }
    .white_content .money2{
        width: 87px;
    }
    .white_content td{
        background-color: #FFF;
        text-align: center;
    }
    .font12 td {
        height: 22px;
        line-height: 22px;
        padding: 1px;
    }
</style>


<div id="light" class="white_content">
    <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tr>
            <td height="24" style="line-height:24px;background-color:#008080; font-weight:bold;" nowrap>&nbsp;<span
                        id='tit_name' style="color:#fff;">平台余额查询</span>

                <span style="float:right;"><a href="javascript:void(0)" onClick="closeZ()"><font color="#fff">关闭</font></a>&nbsp;</span>
            </td>
        </tr>
        <tr>
            <td valign="top" style="padding: 0px;">
                <input type="hidden" name="zzuid" id="zzuid">
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" id="tabl" class="font12"
                       bgcolor="#999999">
                    <tr>
                        <td colspan="6" style="color:#FF0000;">
                            注意:转入->1.补单:不会扣该会员额度；2.帐户:会扣除该会员额度；请慎用!!
                        </td>
                    </tr>
                    <tr>
                        <td width="150" rowspan="2">平台账号</td>
                        <td width="80" rowspan="2">平台类型</td>
                        <td width="110" rowspan="2">当前金额</td>
                        <td colspan="3" style="height:14px;line-height:14px;">额度转帐</td>
                    </tr>
                    <tr>
                        <td style="height:14px;line-height:14px;">转帐金额</td>
                        <td style="height:14px;line-height:14px;">转入</td>
                        <td style="height:14px;line-height:14px;">转出</td>
                    </tr>
                    <?php
                        $zrlist = [
                            'AGIN'=>'AG国际厅',
                            'AG'=>'AG极速厅',
                            'BBIN2'=>'新BB波音厅',
                            'MAYA'=>'玛雅娱乐',
                            'SHABA'=>'沙巴体育',
                            'MW'=>'MW电子',
                            'KG'=>'AV女优',
                            'CQ9'=>'CQ9电子',
                            'MG2'=>'新MG电子',
                            'VR'=>'VR彩票',
                            'BG'=>'BG视讯',
                            'SB'=>'申博视讯',
                            'PT2'=>'新PT电子',
                            'OG2'=>'新OG东方厅',
                            'DG'=>'DG视讯',
                            'KY'=>'开元棋牌',
                            'OG'=>'OG东方厅',
                            'PT'=>'PT电子',
                            'MG'=>'MG电子',
                            'BBIN'=>'BB波音厅',
                        ];
                    ?>
                    <?php foreach($zrlist as $k=>$v):?>
                    <tr code="<?=$k?>">
                        <td class="name"></td><td id="AGIN_type"><?=$v?></td>
                        <td><span class="money"></span><span class="btn">刷新</span></td>
                        <td>金额:<input class="money2" onkeyup="clearNoNum(this)"></td>
                        <td><select><option value="bd" selected="selected">补单</option><option value="ty">帐户</option></select><button type="button" class="in">转入</button></td>
                        <td><button type="button" class="out">转出</button></td>
                    </tr>
                <?php endforeach;?>
                </table>
            </td>
        </tr>
    </table>
</div>
<div id="fade" class="black_overlay">
</div>

<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
    <tr>
        <td height="24" nowrap background="../images/06.gif"><font>&nbsp;<span class="STYLE2">用户管理：查看用户的信息</span></font>
        </td>
    </tr>
    <tr>
        <td height="24" align="center" nowrap bgcolor="#fff">
            <table width="455">
                <form name="form1" method="GET" action="list.php">
                    <tr>
                        <td>内容：
                            <input type="text" name="likevalue" value="<?=empty($_GET['likevalue'])?'':$_GET['likevalue']?>"/>
                            &nbsp;&nbsp;类型：
                            <select name="selecttype" id="selecttype">
                                <option value="username" <?php if ($_GET["selecttype"] == 'username') { ?> selected <?php } ?> >
                                    用户名
                                </option>
                                <option value="pay_name" <?php if ($_GET["selecttype"] == 'pay_name') { ?> selected <?php } ?> >
                                    真实姓名
                                </option>
                                <option value="reg_ip" <?php if ($_GET["selecttype"] == 'reg_ip') { ?> selected <?php } ?>>
                                    注册IP
                                </option>
                                <option value="login_ip" <?php if ($_GET["selecttype"] == 'login_ip') { ?> selected <?php } ?>>
                                    登录ip
                                </option>
                                <option value="name" <?php if ($_GET["selecttype"] == 'name') { ?> selected <?php } ?>>
                                    会员组
                                </option>
                                <option value="reg_address" <?php if ($_GET["selecttype"] == 'reg_address') { ?> selected <?php } ?>>
                                    省份
                                </option>
                                <option value="mobile" <?php if ($_GET["selecttype"] == 'mobile') { ?> selected <?php } ?>>
                                    手机号码
                                </option>
                            </select>
                            &nbsp;
                            <input type="submit" value="查找"/>
                        </td>
                    </tr>
                </form>
            </table>
        </td>
    </tr>
</table>
<form name="form2" method="post" action="" onSubmit="return check();" style="margin:0 0 0 0;">
    <table width="100%">
        <tr>
            <td width="104" align="center"><a href="?is_login=1">在线会员</a></td>
            <td width="104" align="center"><a href="?money=1&is_stop=0">异常会员</a></td>
            <td width="104" align="center"><a href="?is_stop=1">停用会员</a></td>
            <td width="104" align="center"><a href="?1=1">全部会员</a></td>
            <td width="104" align="center"><a href="?is_daili=1">代理</a></td>
            <td width="104" align="center"><a href="?is_daili=0">普通会员</a></td>
            <td width="104" align="center"><a href="mobile.php">危险手机号码</a></td>
            <td width="365" align="right"><span class="STYLE4">相关操作：</span>
                <select name="s_action" id="s_action">
                    <option value="0" selected="selected">选择确认</option>
                    <option value="2">启用会员</option>
                    <option value="1">停用会员</option>
                    <option value="5">修改密码</option>
                    <option value="3">踢线</option>
                    <option value="4" style="color:#FF0000;">取消代理</option>
                    <!--option value="6" style="color:#0000ff;">删除会员</option-->
                    <option value="7">转移代理</option>
                    <option value="8" style="color:#008040;">允许额度转换</option>
                    <option value="9" style="color:#FF9E3E;">不允许额度转换</option>
                </select>
                <input type="submit" name="Submit2" value="执行"/></td>
        </tr>
    </table>
    <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tr>
            <td height="24" nowrap bgcolor="#fff">

                <table width="100%" border="1" bgcolor="#fff" bordercolor="#96B697" cellspacing="0" cellpadding="0"
                       style="border-collapse: collapse;color: #225d9c;" id=editProduct idth="100%">
                    <tr style="background-color: #EFE" class="t-title" align="center">
                        <td width="4%"><strong>ID</strong></td>
                        <td width="8%" height="20"><strong>用户名/姓名</strong></td>
                        <td width="6%"><strong>登录/注册域名</strong></td>
                        <td width="8%"><strong>注册方式/时间</strong></td>
                        <td width="7%"><strong><a href="list.php?order=money">余额</a>/加扣款</strong></td>
                        <td width="7%"><strong>额度转换</strong></td>
                        <td width="8%"><strong>注册/登陆IP</strong></td>
                        <td width="7%"><strong>代理/上级</strong></td>
                        <td width="8%"><strong>电话/邮箱/微信</strong></td>
                        <td width="7%"><strong>核查/会员组</strong></td>
                        <td width="4%"><strong>总充值数</strong></td>
                        <td width="4%"><strong>总汇款数</strong></td>
                        <td width="4%"><strong>总提款数</strong></td>
                        <td width="4%"><strong>人工汇总</strong></td>
                        <td width="4%"><strong><a href="list.php?order=ul_type desc,uid">状态</a></strong></td>
                        <td width="3%"><input name="checkall" type="checkbox" id="checkall" onClick="return ckall();"/>
                        </td>
                    </tr>
                    <?php
                    if ($uid) {
                        $uid = rtrim($uid, ',');
                        $sql = 'select u.uid,u.username,u.reg_host,u.money,u.weixin,u.reg_ip,u.reg_mode,u.login_ip,u.is_daili,u.top_uid,u.is_stop,g.name,u.pay_name,u.mobile,u.email,u.reg_date,u.is_stop,is_login as ul_type,ul.type,ul.www,u.agents,u.iszhuan from k_user u left join k_group g on u.gid=g.id left join k_user_login ul on u.uid=ul.uid where u.uid in (' . $uid . ')' . $desc;
                        $query = $mydata1_db->query($sql);
                        while ($rows = $query->fetch()) {
                            $uid = $rows['uid'];
                            $sql = " select count(*) as cz_count from k_money WHERE  uid ={$uid} and type=1 and status=1";
                            $cz_query_count = $mydata1_db->query($sql);
                            $cz_count = $cz_query_count->fetchColumn();

                            $sql = " select count(*) as cz_count from k_money WHERE   uid ={$uid} and type=2 and status=1";
                            $tx_query_count = $mydata1_db->query($sql);
                            $tx_count = $tx_query_count->fetchColumn();

                            $sql = " select count(*) as hk_count from huikuan WHERE   uid ={$uid} and status=1";
                            $tx_query_count = $mydata1_db->query($sql);
                            $hk_count = $tx_query_count->fetchColumn();

                            $sql = " select count(*) as cz_count from k_money WHERE   uid ={$uid} and type=3 and status=1";
                            $rg_query_count = $mydata1_db->query($sql);
                            $rg_count = $rg_query_count->fetchColumn();


                            $over = '#EBEBEB';
                            $out = '#ffffff';
                            $color = '#fff';
                            if ($rows['is_stop'] == 1) {
                                $color = $over = $out = '#EBEBEB';
                            }
                            if ($rows['money'] < 0) {
                                $color = $over = $out = '#FF9999';
                            } ?>
                            <tr align="center" onMouseOver="this.style.backgroundColor='<?= $over ?>'" onMouseOut="this.style.backgroundColor='<?= $out ?>'"
                                style="background-color:<?= $color ?>">
                                <td><a href="user_show.php?id=<?= $rows['uid'] ?>"><?= $rows['uid'] ?></a></td>
                                <td>
                                    <a href="user_show.php?id=<?= $rows['uid'] ?>"><?= $rows['username'] ?></a> <br> <a class="color2" href="list.php?likevalue=<?= urlencode($rows['pay_name']) ?>&selecttype=pay_name"><?= $rows['pay_name'] ?></a>
                                    
                                </td>
                                <td>
                                    <span style="color:#949494"><?= $rows['www']?></span><br><?=$rows['reg_host']?>
                                </td>
                                <td>
                                    <?=$rows['reg_mode']=='0'?'电脑注册':'手机注册'?><br/><?=date('y-m-d H:i',strtotime($rows['reg_date']))?>
                                </td>
                                <td style="line-height:20px;">
                                    <a href="../cwgl/hccw.php?username=<?= $rows['username'] ?>"><?= sprintf('%.2f', $rows['money']) ?>&nbsp;财务</a><br>
                                    <a class="color2" href="../cwgl/man_money.php?username=<?= $rows['username'] ?>">加款扣款</a>
                                </td>
                                <td>
                                    <?= $rows["iszhuan"] == 1 ? "<span style='color:#006600;'>允许</span>" : "<span style='color:#FF0000;'>不允许</span>" ?><br>
                                    <span id="tz_money_<?= $rows["uid"] ?>">
                                    <a href="javascript:void(0);" onClick="live_money('<?= $rows["uid"] ?>','<?= $rows['username'] ?>')">平台余额</a>
                                </td>
                                <td>
                                    <a href="login_ip.php?ip=<?= $rows['reg_ip'] ?>"><?= $rows['reg_ip'] ?></a><br/><a class="color2" href="login_ip.php?ip=<?= $rows['login_ip'] ?>"><?= $rows['login_ip'] ?></a>
                                </td>
                                <td>
                                    <?php if ($rows['is_daili'] == 1): ?>
                                        <a title="单击查看改代理的所有会员" href="list.php?top_uid=<?= $rows['uid'] ?>">是</a>
                                    <?php else: ?>
                                        否 
                                    <?php endif; ?>
                                    <br/>
                                    <?php if (0 < $rows['top_uid']): ?>
                                        <a href="list.php?top_uid=<?= $rows['top_uid'] ?>"><?= user::getusername($rows['top_uid']) ?></a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (strpos($_SESSION['quanxian'], 'hylx')): ?>
                                        <?php if ($xinxi): ?>
                                        <a href="list.php?likevalue=<?= $rows['mobile'] ?>&selecttype=mobile"><?= $rows['mobile'] ?></a>
                                        <br/>
                                        <?=$rows['email']?>
                                        <br/>
                                        <?=$rows['weixin']?>
                                        <?php else: ?>
                                            <button type="button" class="inputPwd">输入二级密码</button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        您无权查看
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="../bbgl/report_day.php?username=<?= $rows['username'] ?>">核查会员</a><br/><?= $rows['name'] ?>
                                </td>
                                <td>
                                    <?php if($cz_count > 0): ?>
                                        <a class="color3" href="money_record_list.php?type=cz&uid=<?=$rows['uid']?>"><?=$cz_count?></a>
                                    <?php else: ?>
                                       0
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($hk_count > 0): ?>
                                            <a class="color3" href="money_record_list.php?type=hk&uid=<?=$rows['uid']?>"><?=$hk_count?></a>
                                    <?php else: ?>
                                            0
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($tx_count > 0): ?>
                                            <a class="color3" href="money_record_list.php?type=tx&uid=<?=$rows['uid']?>"><?=$tx_count?></a>
                                    <?php else: ?>
                                            0
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($rg_count > 0): ?>
                                            <a class="color3" href="money_record_list.php?type=rg&uid=<?=$rows['uid']?>"><?=$rg_count?></a>
                                    <?php else: ?>
                                            0
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center">
                                    <?php
                                    if ($rows["ul_type"] > 0) {
                                        $txt = $rows['type'] == 0 ? '电脑' : '手机';
                                        echo '<span style="color:#FF00FF;">' . $txt . '</span>';
                                    } else {
                                        echo '<span style="color:#999999;">离线</span>';
                                    }
                                    ?><br/><?= $rows["is_stop"] == 1 ? "<span style='color: #FF0000;'>停用</span>" : "<span style='color:#006600;'>正常</span>" ?>
                                </td>
                                <td><input name="uid[]" type="checkbox" id="uid[]" value="<?= $rows['uid'] ?>"/></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>     </table>
            </td>
        </tr>
        <tr>
            <td>
                <div style="float:left;"><?= $page->get_htmlPage($_SERVER["REQUEST_URI"]); ?></div>
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript" src="/skin/layer/layer.js"></script>
<script type="text/javascript">
$(function(){
    $('.inputPwd').click(function(){
        layer.open({
            type: 1,
            id: 'inputPwd',
            title: "二级密码确认",
            area: ["400px","150px"],
            shadeClose: true,
            content: '<div style="padding:10px;text-align:center"><input style="border: 1px solid #CCC;height: 30px;font-weight: bold;font-size: 16px;padding-left: 10px;width: 300px" type="password" id="pwd" ></div>',
            btn: ['确认', '取消'],
            success: function(layero, index){
                  $('#pwd').focus();
                  $(document).on('keydown', function(e){  //document为当前元素，限制范围，如果不限制的话会一直有事件
                      if(e.keyCode == 13){
                          $('.layui-layer-btn0').trigger("click");
                      }
                  })
              },
            yes: function (index, layero){
                $.get('list.php?save=true&pwd='+$('#pwd').val(), function(res){
                    if(res == 1){
                        alert('密码错误！！！');
                        $('#pwd').val('');
                        $('#pwd').focus();
                    }else{
                        alert('认证成功');
                        layer.close(index);
                         location.reload();
                    }
                });
            }
        });
    });
})
</script>
</body>
</html>