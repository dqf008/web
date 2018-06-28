<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cpgl');
$id    = 0;
$qishu = 0;
if (0 < $_GET['id']) {
    $id = intval($_GET['id']);
}

if (($_GET['action'] == 'cancel') && (0 < $id)) {
    $caizhong = '江苏快3';
    $gameType = 'jsk3';
    switch (trim($_GET['atype'])) {
        case 'jsk3':
            $caizhong = '江苏快3';
            $gameType = 'jsk3';
            break;
        case 'ahk3':
            $caizhong = '安徽快3';
            $gameType = 'ahk3';
            break;
        case 'gxk3':
            $caizhong = '广西快3';
            $gameType = 'gxk3';
            break;
        case 'shk3':
            $caizhong = '上海快3';
            $gameType = 'shk3';
            break;
        case 'hbk3':
            $caizhong = '湖北快3';
            $gameType = 'hbk3';
            break;
        case 'hebk3':
            $caizhong = '河北快3';
            $gameType = 'hebk3';
            break;
        case 'fjk3':
            $caizhong = '福建快3';
            $gameType = 'fjk3';
            break;
//        case 'ffk3':
//            $caizhong = '分分快3';
//            $gameType = 'ffk3';
//            break;
//        case 'sfk3':
//            $caizhong = '三分快3';
//            $gameType = 'sfk3';
//            break;
        case 'bjk3':
            $caizhong = '北京快3';
            $gameType = 'bjk3';
            break;
        case 'jxk3':
            $caizhong = '江西快3';
            $gameType = 'jxk3';
            break;
        case 'jlk3':
            $caizhong = '吉林快3';
            $gameType = 'jlk3';
            break;
        case 'hnk3':
            $caizhong = '河南快3';
            $gameType = 'hnk3';
            break;
        case 'gsk3':
            $caizhong = '甘肃快3';
            $gameType = 'gsk3';
            break;
        case 'qhk3':
            $caizhong = '青海快3';
            $gameType = 'qhk3';
            break;
        case 'gzk3':
            $caizhong = '贵州快3';
            $gameType = 'gzk3';
            break;
        case 'nmgk3':
            $caizhong = '内蒙古快3';
            $gameType = 'nmgk3';

    }
    check_quanxian('cpcd');
    cancel_order($id, $caizhong, $gameType);
    message('操作成功');
}

if (0 < $_GET['qishu']) {
    $qishu = $_GET['qishu'];
}

if (($_GET['action'] == 'cancel_qishu') && (0 < $qishu)) {
    $caizhong = '江苏快3';
    $gameType = 'jsk3';
    if (trim($_GET['atype']) == '') {
        message('操作失败');
    }

    switch (trim($_GET['atype'])) {
        case 'jsk3':
            $caizhong = '江苏快3';
            $gameType = 'jsk3';
            break;
        case 'ahk3':
            $caizhong = '安徽快3';
            $gameType = 'ahk3';
            break;
        case 'gxk3':
            $caizhong = '广西快3';
            $gameType = 'gxk3';
            break;
        case 'shk3':
            $caizhong = '上海快3';
            $gameType = 'shk3';
            break;
        case 'hbk3':
            $caizhong = '湖北快3';
            $gameType = 'hbk3';
            break;
        case 'hebk3':
            $caizhong = '河北快3';
            $gameType = 'hebk3';
            break;
        case 'fjk3':
            $caizhong = '福建快3';
            $gameType = 'fjk3';
            break;
//        case 'ffk3':
//            $caizhong = '分分快3';
//            $gameType = 'ffk3';
//            break;
//        case 'sfk3':
//            $caizhong = '三分快3';
//            $gameType = 'sfk3';
//            break;
        case 'bjk3':
            $caizhong = '北京快3';
            $gameType = 'bjk3';
            break;
        case 'jxk3':
            $caizhong = '江西快3';
            $gameType = 'jxk3';
            break;
        case 'jlk3':
            $caizhong = '吉林快3';
            $gameType = 'jlk3';
            break;
        case 'hnk3':
            $caizhong = '河南快3';
            $gameType = 'hnk3';
            break;
        case 'gsk3':
            $caizhong = '甘肃快3';
            $gameType = 'gsk3';
            break;
        case 'qhk3':
            $caizhong = '青海快3';
            $gameType = 'qhk3';
            break;
        case 'gzk3':
            $caizhong = '贵州快3';
            $gameType = 'gzk3';
            break;
        case 'nmgk3':
            $caizhong = '内蒙古快3';
            $gameType = 'nmgk3';
    }

    check_quanxian('cpcd');
    $params = [':atype' => trim($_GET['atype']), ':qishu' => $qishu];
    $sql    = 'select * from lottery_k3_data where atype=:atype and mid=:qishu';
    $stmt   = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $countflag = 0;
    while ($rows = $stmt->fetch()) {
        $id = $rows['id'];
        cancel_order($id, $caizhong, $gameType);
        $countflag++;
    }
    message('操作成功:' . $countflag . '条注单被撤销！');
}

$id        = $_REQUEST['id'];
$uid       = $_REQUEST['uid'];
$langx     = $_SESSION['langx'];
$stype     = isset($_REQUEST['stype'])?$_REQUEST['stype']:'jsk3';
$loginname = $_SESSION['loginname'];
$lv        = $_REQUEST['lv'];
$xtype     = $_REQUEST['xtype'];
$username  = $_REQUEST['username'];
$ok        = $_REQUEST['ok'];
$params    = [];
if ($username == '') {
    $soname = '1=1';
} else {
    $params[':username'] = $username;
    $soname              = 'username=:username';
}

if ($ok == '') {
    $sook = '1=1';
} else if ($ok == 'Y') {
    $sook = 'bet_ok=1';
} else if ($ok == 'N') {
    $sook = 'bet_ok=0';
}

$s_time    = $_REQUEST['s_time'];
$e_time    = $_REQUEST['e_time'];
$qihao     = $_REQUEST['qihao'];
$zhudanhao = $_REQUEST['zhudanhao'];
if (isset($s_time) && ($s_time != '')) {
    $params[':s_time'] = $s_time;
    $sook              .= ' and bet_date>=:s_time';
}

if (isset($e_time) && ($e_time != '')) {
    $params[':e_time'] = $e_time;
    $sook              .= ' and bet_date<=:e_time';
}

if (isset($qihao) && ($qihao != '')) {
    $params[':qihao'] = trim($qihao);
    $sook             .= ' and mid=:qihao';
}

if (isset($zhudanhao) && ($zhudanhao != '')) {
    $params[':zhudanhao'] = trim($zhudanhao);
    $sook                 .= ' and uid=:zhudanhao';
}
switch ($stype) {
    case 'jsk3':
        $typename  = '江苏快3';
        $atypename = 'jsk3';
        break;
    case 'ahk3':
        $typename  = '安徽快3';
        $atypename = 'ahk3';
        break;
    case 'gxk3':
        $typename  = '广西快3';
        $atypename = 'gxk3';
        break;
    case 'shk3':
        $typename  = '上海快3';
        $atypename = 'shk3';
        break;
    case 'hbk3':
        $typename  = '湖北快3';
        $atypename = 'hbk3';
        break;
    case 'hebk3':
        $typename  = '河北快3';
        $atypename = 'hebk3';
        break;
    case 'fjk3':
        $typename  = '福建快3';
        $atypename = 'fjk3';
        break;
//    case 'ffk3':
//        $typename  = '分分快3';
//        $atypename = 'ffk3';
//        break;
//    case 'sfk3':
//        $typename  = '三分快3';
//        $atypename = 'sfk3';
//        break;
    case 'bjk3':
        $typename = '北京快3';
        $atypename = 'bjk3';
        break;
    case 'jxk3':
        $typename = '江西快3';
        $atypename = 'jxk3';
        break;
    case 'jlk3':
        $typename = '吉林快3';
        $atypename = 'jlk3';
        break;
    case 'hnk3':
        $typename = '河南快3';
        $atypename = 'hnk3';
        break;
    case 'gsk3':
        $typename = '甘肃快3';
        $atypename = 'gsk3';
        break;
    case 'qhk3':
        $typename = '青海快3';
        $atypename = 'qhk3';
        break;
    case 'gzk3':
        $typename = '贵州快3';
        $atypename = 'gzk3';
        break;
    case 'nmgk3':
        $typename = '内蒙古快3';
        $atypename = 'nmgk3';
        break;
    default:
        $typename  = '江苏快3';
        $atypename = 'jsk3';
}
if ($stype == '') {
    $sql = 'select * from lottery_data where 1=1 and ' . $soname . ' and ' . $sook . ' order by id desc';
} else {
    $params[':atype'] = $atypename;
    $sql              = 'select * from lottery_data where 1=1 and ' . $soname . ' and ' . $sook . ' and atype=:atype order by id desc';
}
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$cou  = $stmt->rowCount();
$page = $_REQUEST['page'];
if (($page == '') || ($page < 0)) {
    $page = 0;
}

$page_size  = 50;
$page_count = ceil($cou / $page_size);
if (($page_count - 1) < $page) {
    $page = $page_count - 1;
}

$offset = floatval($page * $page_size);
if ($offset < 0) {
    $offset = 0;
}
$mysql = $sql . '  limit ' . $offset . ',' . $page_size . ';';
//var_dump($sql,$params);die();
$stmt  = $mydata1_db->prepare($mysql);
$stmt->execute($params);
?>
    <html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <style type="text/css">
            <STYLE >
            BODY {
                SCROLLBAR-FACE-COLOR: rgb(255, 204, 0);
                SCROLLBAR-3DLIGHT-COLOR: rgb(255, 207, 116);
                SCROLLBAR-DARKSHADOW-COLOR: rgb(255, 227, 163);
                SCROLLBAR-BASE-COLOR: rgb(255, 217, 93)
            }

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

            .m_title {
                background: url(../images/06.gif);
                height: 24px;
            }

            .m_title td {
                font-weight: 800;
            }
        </STYLE>
        <script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
        <script language="JavaScript" src="/js/calendar.js"></script>
    </head>
    <body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
    <table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0"
           style="border-collapse: collapse;color: #225d9c;">
        <tr>
            <td colspan="11" align="center" bgcolor="#FFFFFF">
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=jsk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">江苏快3</a>
                -
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=ahk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">安徽快3</a>
                -
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=gxk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">广西快3</a>
                -
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=shk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">上海快3</a>
                -
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=hbk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">湖北快3</a>
                -
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=hebk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">河北快3</a>
                -
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=fjk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">福建快3</a>
<!--                --->
<!--                <a href="?qi=--><?//= $qi; ?><!--&username=--><?//= $username; ?><!--&stype=hnk3&ok=--><?//= $ok; ?><!--&qihao=--><?//= $qihao; ?><!--&zhudanhao=--><?//= $zhudanhao; ?><!--">河南快3</a>-->
                -
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=bjk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">北京快3</a>
                -
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=gzk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">贵州快3</a>
                -
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=gsk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">甘肃快3</a>
                -
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=jlk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">吉林快3</a>
                -
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=nmgk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">内蒙古快3</a>
                -
                <a href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=jxk3&ok=<?= $ok; ?>&qihao=<?= $qihao; ?>&zhudanhao=<?= $zhudanhao; ?>">江西快3</a>
<!--                --->
<!--                <a href="?qi=--><?//= $qi; ?><!--&username=--><?//= $username; ?><!--&stype=qhk3&ok=--><?//= $ok; ?><!--&qihao=--><?//= $qihao; ?><!--&zhudanhao=--><?//= $zhudanhao; ?><!--">青海快3</a>-->
<!--                --->
<!--                <a href="?qi=--><?//= $qi; ?><!--&username=--><?//= $username; ?><!--&stype=sfk3&ok=--><?//= $ok; ?><!--&qihao=--><?//= $qihao; ?><!--&zhudanhao=--><?//= $zhudanhao; ?><!--">分分快3</a>-->
<!--                --->
<!--                <a href="?qi=--><?//= $qi; ?><!--&username=--><?//= $username; ?><!--&stype=sfk3&ok=--><?//= $ok; ?><!--&qihao=--><?//= $qihao; ?><!--&zhudanhao=--><?//= $zhudanhao; ?><!--">三分快3</a>-->
            </td>
        </tr>
        <tr>
            <FORM id="myFORM" ACTION="" METHOD=POST name="myFORM">
                <td colspan="11" align="center" bgcolor="#FFFFFF">
                    会员帐号：<input type=TEXT name="username" size=10 value="<?= $username; ?>" maxlength=11
                                class="za_text">
                    期号：<input type=TEXT name="qihao" size=16 value="<?= $qihao; ?>" maxlength=16 class="za_text">
                    注单号：<input type=TEXT name="zhudanhao" size=20 value="<?= $zhudanhao; ?>" maxlength=20
                               class="za_text">
                    注单日期：<input name="s_time" type="text" id="s_time" value="<?= $s_time; ?>"
                                onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10"
                                readonly="readonly"/>
                    ~
                    <input name="e_time" type="text" id="e_time" value="<?= $e_time; ?>"
                           onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly"/>
                    <select name='ok'>
                        <option value=""<?php if ($ok == '') { ?> selected<?php } ?> >全部</option>
                        <option value="Y"<?php if ($ok == 'Y') { ?> selected<?php } ?> >已开奖</option>
                        <option value="N"<?php if ($ok == 'N') { ?> selected<?php } ?> >未开奖</option>
                    </select>
                    <input type=SUBMIT name="SUBMIT" value="确认" class="za_button"></td>
            </FORM>
        </tr>
        <tr>
            <td colspan="11">
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12"
                       bgcolor="#798EB9">
                    <tr>
                        <td align="center" bgcolor="#FFFFFF">
                            彩种:
                            <?php if ($_GET['stype'] != '') { ?>
                                <span><?= $typename; ?></span>
                                <input name="cancel_atype" id="cancel_atype" value="<?= $stype; ?>" type="hidden"
                                       size="15">
                            <?php } else { ?>
                                <select name="cancel_atype" id="cancel_atype">
                                    <option value="jsk3">江苏快3</option>
                                    <option value="ahk3">安徽快3</option>
                                    <option value="gxk3">广西快3</option>
                                    <option value="shk3">上海快3</option>
                                    <option value="hbk3">湖北快3</option>
                                    <option value="hebk3">河北快3</option>
                                    <option value="fjk3">福建快3</option>
<!--                                    <option value="ffk3">河南快3</option>-->
                                    <option value="sfk3">北京快3</option>
                                    <option value="sfk3">贵州快3</option>
                                    <option value="sfk3">甘肃快3</option>
                                    <option value="sfk3">吉林快3</option>
                                    <option value="sfk3">内蒙古快3</option>
                                    <option value="sfk3">江西快3</option>
<!--                                    <option value="sfk3">青海快3</option>-->
<!--                                    <option value="sfk3">分分快3</option>-->
<!--                                    <option value="sfk3">三分快3</option>-->
                                </select>
                            <?php } ?>
                            期号：
                            <input name="cancel_qishu" id="cancel_qishu" type="text" size="15">
                            <input type="button" name="Submit" value="撤销当期注单" onClick="cancle_qishu_check();"></td>
                    </tr>
                    <script>
                        function cancle_qishu_check() {
                            var atype = $('#cancel_atype').val();
                            var qishu = parseInt($('#cancel_qishu').val());
                            if (qishu == null || qishu == "") {
                                alert("请输入要撤销的期号！");
                                return false;
                            }

                            if (isNaN(qishu)) {
                                alert("请输入正确的期号！");
                                return false;
                            }
                            if (confirm('您确定要撤销【' + qishu + '】期注单？撤销后金额将重算并退回！'))
                                location.href = 'jszd.php?action=cancel_qishu&atype=' + atype + '&qishu=' + qishu;
                        }
                    </script>
                </table>
            </td>
        </tr>
        <tr class="m_title">
            <td align="center">彩票种类</td>
            <td align="center">投注时间(北京/美东)</td>
            <td align="center">注单号</td>
            <td align="center">期数</td>
            <td align="center">玩法</td>
            <td align="center"><font color="#0000FF">投注 @ 赔率</font></td>
            <td align="center">投注金额</td>
            <td align="center">可赢金额</td>
            <td align="center">输赢结果</td>
            <td align="center">下注会员</td>
            <td align="center">操作</td>
        </tr>
        <?php
        if ($cou == 0) {

        } else {
            $tod_num = 0;
            $tod_bet = 0;
            $tod_win = 0;
            while ($row = $stmt->fetch()) {
                switch ($row['atype']) {
                    case 'jsk3':
                        $caizhong = '江苏快3';
                        $gameType = 'jsk3';
                        break;
                    case 'ahk3':
                        $caizhong = '安徽快3';
                        $gameType = 'ahk3';
                        break;
                    case 'gxk3':
                        $caizhong = '广西快3';
                        $gameType = 'gxk3';
                        break;
                    case 'shk3':
                        $caizhong = '上海快3';
                        $gameType = 'shk3';
                        break;
                    case 'hbk3':
                        $caizhong = '湖北快3';
                        $gameType = 'hbk3';
                        break;
                    case 'hebk3':
                        $caizhong = '河北快3';
                        $gameType = 'hebk3';
                        break;
                    case 'fjk3':
                        $caizhong = '福建快3';
                        $gameType = 'fjk3';
                        break;
//                    case 'ffk3':
//                        $caizhong = '分分快3';
//                        $gameType = 'ffk3';
//                        break;
//                    case 'sfk3':
//                        $caizhong = '三分快3';
//                        $gameType = 'sfk3';
//                        break;
                    case 'bjk3':
                        $caizhong = '北京快3';
                        $gameType = 'bjk3';
                        break;
                    case 'jxk3':
                        $caizhong = '江西快3';
                        $gameType = 'jxk3';
                        break;
                    case 'jlk3':
                        $caizhong = '吉林快3';
                        $gameType = 'jlk3';
                        break;
                    case 'hnk3':
                        $caizhong = '河南快3';
                        $gameType = 'hnk3';
                        break;
                    case 'gsk3':
                        $caizhong = '甘肃快3';
                        $gameType = 'gsk3';
                        break;
                    case 'qhk3':
                        $caizhong = '青海快3';
                        $gameType = 'qhk3';
                        break;
                    case 'gzk3':
                        $caizhong = '贵州快3';
                        $gameType = 'gzk3';
                        break;
                    case 'nmgk3':
                        $caizhong = '内蒙古快3';
                        $gameType = 'nmgk3';

                }
                ?>
                <tr>
                    <td align="center" bgcolor="#FFFFFF"><?= $caizhong ?></td>
                    <td align="center"
                        bgcolor="#FFFFFF"><?= date('Y-m-d H:i:s', strtotime($row['bet_time']) + 1 * 12 * 3600) . '<br>' . $row['bet_time']; ?></td>
                    <td align="center" bgcolor="#FFFFFF"><?= $row['uid'] ?></td>
                    <td align="center" bgcolor="#FFFFFF">第 <?= $row['mid'] ?> 期</td>
                    <td align="center" bgcolor="#FFFFFF"><?= $row['btype'] ?></td>
                    <td align="center" bgcolor="#FFFFFF"><?= $row['dtype'] ?><b><font
                                    color="#0000FF"><?= $row['content'] ?></font> @ <font
                                    color="#990000"><?= $row['odds'] ?></font></b></td>
                    <td align="center" bgcolor="#FFFFFF"><font color="#0000FF"><?= $row['money'] ?></font></td>
                    <td align="center" bgcolor="#FFFFFF"><?= $row['money'] * $row['odds'] - $row['money'] ?></td>
                    <td align="center" bgcolor="#FFFFFF"><? if ($row['bet_ok'] == 1) { ?><font
                                color="#FF0000"><?= $row['win'] ?></font><? } else { ?><font
                                color="#0000FF">未开奖</font><? } ?></td>
                    <td align="center" bgcolor="#FFFFFF"><?= $row['username'] ?></td>
                    <td align="center"><a href="javascript:void(0);"
                                          onClick="if(confirm('您确定要撤销该注单？撤销后金额将重算并退回！'))location.href='?action=cancel&id=<?= $row['id']; ?>&atype=<?= $row['atype']; ?>';">撤销</a>
                    </td>
                </tr>
                <?php
                $tod_num = $tod_num + 1;
            }
            ?>
            <tr>
                <td colspan="11" align="center" bgcolor="#FFFFFF">
                    共计<?= $page_count; ?>页 - 当前第<?= $page + 1; ?>页
                    <?php if (1 < ($page + 1)) { ?>
                        <a style="font-weight: normal;color:#000;"
                           href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=<?= $stype; ?>&ok=<?= $ok; ?>&page=<?= $page - 1; ?>">上一页</a>
                    <?php } else { ?>上一页<?php } ?>|<?php if (($page + 1) < $page_count) { ?>
                        <a style="font-weight: normal;color:#000;"
                           href="?qi=<?= $qi; ?>&username=<?= $username; ?>&stype=<?= $stype; ?>&ok=<?= $ok; ?>&page=<?= $page + 1; ?>">下一页</a>
                    <?php } else { ?>下一页<?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    </body>
    </html>
<?php
function cancel_order($id, $caizhong, $gameType)
{
    global $mydata1_db;
    $params = [':id' => $id];
    $sql    = 'select * from lottery_data where id=:id';
    $stmt   = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $rs = $stmt->fetch();
    if ($rs) {
        $qishu     = $rs['mid'];
        $cp_uid    = $rs['uid'];
        $kusername = $rs['username'];
        $money     = $rs['money'];
        $win       = $rs['win'];
        $bet_ok    = $rs['bet_ok'];
        $remoney   = $money;
        if (($bet_ok == 1) && (0 < $win)) {
            $remoney = -$win;
        }
        $params = [':username' => $kusername];
        $sql    = 'select uid from k_user where username=:username limit 1';
        $stmt   = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $kuid   = $stmt->fetchColumn();
        $params = [':id' => $id];
        $sql    = 'delete from lottery_data where id=:id';
        $stmt   = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $params = [':money' => $remoney, ':uid' => $kuid];
        $sql    = 'update k_user set money=money+:money where uid=:uid';
        $stmt   = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $creationTime = date('Y-m-d H:i:s');
        $params       = [':uid' => $kuid, ':userName' => $kusername, ':gameType' => $gameType, ':transferOrder' => $cp_uid, ':transferAmount' => $remoney, ':transferAmount2' => $remoney, ':creationTime' => $creationTime, ':quid' => $kuid];
        $sql          = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT :uid,:userName,:gameType,\'CANCEL_BET\',:transferOrder,:transferAmount,money-:transferAmount2,money,:creationTime FROM k_user WHERE uid=:quid';
        $stmt         = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        include_once '../../class/admin.php';
        $message = '撤销[' . $kusername . ']' . $caizhong . '期号[' . $qishu . ']注单[' . $cp_uid . '],[注单金额:' . $money . ',可赢金额:' . $win . ',结算状态:' . $bet_ok . '],退回金额:' . $remoney;
        admin::insert_log($_SESSION['adminid'], $message);
    }
}

?>