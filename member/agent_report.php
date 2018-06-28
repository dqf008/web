<?php
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../include/newpage.php';
include_once '../class/user.php';
include_once '../common/function.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
$username = $_SESSION['username'];
renovate($uid, $loginid);
if (!user::is_daili($uid)) {
    message('你还不是代理，请先申请', 'agent_reg.php');
}
$lastmonth = getlastmonth(date('Y-m-d', time()));
$cn_begin = $_GET['cn_begin'];
$s_begin_h = $_GET['s_begin_h'];
$s_begin_i = $_GET['s_begin_i'];
$cn_begin = ($cn_begin == '' ? $lastmonth[0] : $cn_begin);
$s_begin_h = ($s_begin_h == '' ? '00' : $s_begin_h);
$s_begin_i = ($s_begin_i == '' ? '00' : $s_begin_i);
$cn_end = $_GET['cn_end'];
$s_end_h = $_GET['s_end_h'];
$s_end_i = $_GET['s_end_i'];
$cn_end = ($cn_end == '' ? $lastmonth[1] : $cn_end);
$s_end_h = ($s_end_h == '' ? '23' : $s_end_h);
$s_end_i = ($s_end_i == '' ? '59' : $s_end_i);
$begin_time = $cn_begin . ' ' . $s_begin_h . ':' . $s_begin_i . ':00';
$end_time = $cn_end . ' ' . $s_end_h . ':' . $s_end_i . ':59';
$cn_begin_time = date('Y-m-d H:i:s', strtotime($begin_time) + (12 * 3600));
$cn_end_time = date('Y-m-d H:i:s', strtotime($end_time) + (12 * 3600));
$rate_ty = $_GET['rate_ty'];
$rate_ty = ($rate_ty == '' ? '20' : $rate_ty);
$rate_lh = $_GET['rate_lh'];
$rate_lh = ($rate_lh == '' ? '10' : $rate_lh);
$rate_js = $_GET['rate_js'];
$rate_js = ($rate_js == '' ? '20' : $rate_js);
$rate_ss = $_GET['rate_ss'];
$rate_ss = ($rate_ss == '' ? '20' : $rate_ss);
$rate_pt = $_GET['rate_pt'];
$rate_pt = ($rate_pt == '' ? '20' : $rate_pt);
$rate_zr = $_GET['rate_zr'];
$rate_zr = ($rate_zr == '' ? '10' : $rate_zr);
$selectuser = trim($_GET['selectuser']);
$selectuid = 0;
$params = array(':selectuser' => $selectuser);
$sql = 'select uid as selectuid from k_user where username = :selectuser';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
if ($row = $stmt->fetch()){
    $selectuid = $row['selectuid'];
}
$selectwhere = '';
if ($selectuid != 0){
    $selectwhere = ' and u.uid = ' . $selectuid . ' ';
}
?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>代理报表</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
        <link type="text/css" rel="stylesheet" href="images/member.css"/>
        <script type="text/javascript" src="images/member.js"></script>
        <!--[if IE 6]>
        <script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]-->
        <script type="text/javascript" src="../js/calendar.js"></script>
    </head>
    <body>
    <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;">
        <?php include_once 'mainmenu.php'; ?>
        <tr>
            <td colspan="2" align="center" valign="middle">
                <?php include_once 'agentmenu.php'; ?>
                <div class="content">
                    <table width="98%" border="0" cellspacing="0" cellpadding="5">
                        <form id="form1" name="form1" action="?query=true" method="get">
                            <tr>
                                <td height="25" align="center" bgcolor="#D6D6D6">
                                    开始日期
                                    <input name="cn_begin" type="text" id="cn_begin" size="10" readonly="readonly"
                                           value="<?= $cn_begin; ?>" onclick="new Calendar(2008,2020).show(this);"/>
                                    <select name="s_begin_h" id="s_begin_h">
                                        <?php
                                        for ($bh_i = 0; $bh_i < 24; $bh_i++) {
                                            $b_h_value = ($bh_i < 10 ? '0' . $bh_i : $bh_i);
                                            ?>
                                            <option value="<?= $b_h_value; ?>" <?= $s_begin_h == $b_h_value ? 'selected' : ''; ?>><?= $b_h_value; ?></option>
                                        <?php } ?>
                                    </select>
                                    时
                                    <select name="s_begin_i" id="s_begin_i">
                                        <?php
                                        for ($bh_j = 0; $bh_j < 60; $bh_j++) {
                                            $b_i_value = ($bh_j < 10 ? '0' . $bh_j : $bh_j);
                                            ?>
                                            <option value="<?= $b_i_value; ?>"<?= $s_begin_i == $b_i_value ? 'selected' : ''; ?>><?= $b_i_value; ?></option>
                                        <?php } ?>
                                    </select>
                                    分
                                    &nbsp;&nbsp;结束日期
                                    <input name="cn_end" type="text" id="cn_end" size="10" readonly="readonly"
                                           value="<?= $cn_end; ?>" onclick="new Calendar(2008,2020).show(this);"/>
                                    <select name="s_end_h" id="s_end_h">
                                        <?php
                                        for ($eh_i = 0; $eh_i < 24; $eh_i++) {
                                            $e_h_value = ($eh_i < 10 ? '0' . $eh_i : $eh_i)
                                            ?>
                                            <option value="<?= $e_h_value; ?>"<?= $s_end_h == $e_h_value ? 'selected' : ''; ?>><?= $e_h_value; ?></option>
                                        <?php } ?>
                                    </select>
                                    时
                                    <select name="s_end_i" id="s_end_i">
                                        <?php
                                        for ($eh_j = 0; $eh_j < 60; $eh_j++) {
                                            $e_i_value = ($eh_j < 10 ? '0' . $eh_j : $eh_j);
                                            ?>
                                            <option value="<?= $e_i_value; ?>"<?= $s_end_i == $e_i_value ? 'selected' : ''; ?>><?= $e_i_value; ?></option>
                                        <?php } ?>
                                    </select>
                                    分
                                    &nbsp;&nbsp;下线会员
                                    <input name="selectuser" type="text" id="selectuser" size="10"
                                           value="<?= $selectuser; ?>" title="不填，表示所有下线会员"/>
                                    &nbsp;&nbsp;<input type="submit" name="query" class="submit_73" value="计算"/>
                                </td>
                            </tr>
                            <tr>
                                <td height="25" align="center" bgcolor="#D6D6D6">
                                    体育比例
                                    <input name="rate_ty" type="text" id="rate_ty" value="<?= $rate_ty; ?>" size="2"
                                           maxlength="3"/>&nbsp;%
                                    &nbsp;&nbsp;六合彩比例
                                    <input name="rate_lh" type="text" id="rate_lh" value="<?= $rate_lh; ?>" size="2"
                                           maxlength="3"/>&nbsp;%
                                    &nbsp;&nbsp;极速彩比例
                                    <input name="rate_js" type="text" id="rate_js" value="<?= $rate_js; ?>" size="2"
                                           maxlength="3"/>&nbsp;%
                                    &nbsp;&nbsp;时时彩比例
                                    <input name="rate_ss" type="text" id="rate_ss" value="<?= $rate_ss; ?>" size="2"
                                           maxlength="3"/>&nbsp;%
                                    &nbsp;&nbsp;普通彩比例
                                    <input name="rate_pt" type="text" id="rate_pt" value="<?= $rate_pt; ?>" size="2"
                                           maxlength="3"/>&nbsp;%
                                    &nbsp;&nbsp;真人比例
                                    <input name="rate_zr" type="text" id="rate_zr" value="<?= $rate_zr; ?>" size="2"
                                           maxlength="3"/>&nbsp;%
                                </td>
                            </tr>
                        </form>
                        <tr>
                            <td align="center">
                                <table width="100%" border="0" cellpadding="5" cellspacing="0"
                                       style="line-height:20px;">
                                    <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;">
                                        <td colspan="10"><?= $begin_time; ?> 至<?= $end_time; ?> 下线会员财务报表</td>
                                    </tr>
                                    <tr align="center" style="background:#3C4D82;color:#ffffff;">
                                        <td colspan="4" class="borderright">常规存取款</td>
                                        <td colspan="3" class="borderright">红利派送</td>
                                        <td rowspan="2" class="borderright">其他情况</td>
                                        <td colspan="2">手续费(银行转账费用)</td>
                                    </tr>
                                    <tr align="center" style="background:#3C4D82;color:#ffffff;">
                                        <td class="borderright">存款</td>
                                        <td class="borderright">汇款</td>
                                        <td class="borderright">人工汇款</td>
                                        <td class="borderright">提款</td>
                                        <td class="borderright">汇款赠送</td>
                                        <td class="borderright">彩金派送</td>
                                        <td class="borderright">反水派送</td>
                                        <td class="borderright">第三方(1%)</td>
                                        <td>提款手续费</td>
                                    </tr><?php $color = '#FFFFFF';
                                    $over = '#EBEBEB';
                                    $out = '#ffffff';
                                    $params = array(':uid' => $uid, ':begin_time' => $begin_time, ':end_time' => $end_time, ':uid2' => $uid, ':begin_time2' => $begin_time, ':end_time2' => $end_time);
                                    $sql = 'select sum(t1_value) as t1_value,sum(t2_value) as t2_value,sum(t3_value) as t3_value,sum(t4_value) as t4_value,sum(t5_value) as t5_value,sum(t6_value) as t6_value,sum(t1_sxf) as t1_sxf,sum(t2_sxf) as t2_sxf,sum(h_value) as h_value,sum(h_zsjr) as h_zsjr from (';
                                    $sql .= 'select sum(if(m.type=1,m.m_value,0)) as t1_value,sum(if(m.type=2,m.m_value,0)) as t2_value,sum(if(m.type=3,m.m_value,0)) as t3_value,sum(if(m.type=4,m.m_value,0)) as t4_value,sum(if(m.type=5,m.m_value,0)) as t5_value,sum(if(m.type=6,m.m_value,0)) as t6_value,sum(if(m.type=1,m.sxf,0)) as t1_sxf,sum(if(m.type=2,m.sxf,0)) as t2_sxf,0 as h_value, 0 as h_zsjr from k_money m left outer join k_user u on m.uid=u.uid where m.status=1 and u.top_uid=:uid and m.m_make_time>=:begin_time and m.m_make_time<=:end_time' . $selectwhere;
                                    $sql .= ' union all ';
                                    $sql .= 'select 0 as t1_value,0 as t2_value,0 as t3_value,0 as t4_value,0 as t5_value,0 as t6_value,0 as t1_sxf,0 as t2_sxf,sum(ifnull(h.money,0)) as h_value,sum(ifnull(h.zsjr,0)) as h_zsjr from huikuan h left outer join k_user u on h.uid=u.uid where h.status=1 and u.top_uid=:uid2 and h.adddate>=:begin_time2 and h.adddate<=:end_time2' . $selectwhere;
                                    $sql .= ')temp';
                                    $stmt = $mydata1_db->prepare($sql);
                                    $stmt->execute($params);
                                    while ($row = $stmt->fetch()) {
                                        $feiyong = $row['h_zsjr'] + $row['t4_value'] + $row['t5_value'] + $row['t1_sxf'] + $row['t2_sxf']; ?>
                                        <tr align="center" onMouseOver="this.style.backgroundColor='<?= $over; ?>'"
                                            onMouseOut="this.style.backgroundColor='<?= $out; ?>'"
                                            style="background-color:<?= $color; ?>;">
                                            <td class="borderright"> <?= sprintf('%.2f', $row['t1_value']); ?></td>
                                            <td class="borderright"> <?= sprintf('%.2f', $row['h_value']); ?></td>
                                            <td class="borderright"> <?= sprintf('%.2f', $row['t3_value']); ?></td>
                                            <td class="borderright"> <?= sprintf('%.2f', abs($row['t2_value'])); ?></td>
                                            <td class="borderright"> <?= sprintf('%.2f', $row['h_zsjr']); ?></td>
                                            <td class="borderright"> <?= sprintf('%.2f', $row['t4_value']); ?></td>
                                            <td class="borderright"> <?= sprintf('%.2f', $row['t5_value']); ?></td>
                                            <td class="borderright"> <?= sprintf('%.2f', $row['t6_value']); ?></td>
                                            <td class="borderright"> <?= sprintf('%.2f', $row['t1_sxf']); ?></td>
                                            <td> <?= sprintf('%.2f', $row['t2_sxf']); ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <?php
                        $_LIVE = include('../cj/include/live.php');
                        ?>
                        <tr>
                            <td align="center">
                                <div style="overflow-x:auto;width:905px">
                                    <table width="100%" border="0" cellpadding="5" cellspacing="0"
                                           style="line-height:20px;">
                                        <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;">
                                            <td colspan="<?php echo count($_LIVE) * 3; ?>"><?= $begin_time; ?>
                                                至<?= $end_time; ?> 下线会员真人下注报表
                                            </td>
                                        </tr>
                                        <tr align="center" style="background:#3C4D82;color:#ffffff;">
                                            <?php foreach ($_LIVE as $val) { ?>
                                                <td colspan="3" class="borderright"><?php echo $val[1]; ?></td>
                                            <?php } ?>
                                        </tr>
                                        <tr align="center" style="background:#3C4D82;color:#ffffff;">
                                            <?php
                                            for ($i = 0; $i < count($_LIVE); $i++) { ?>
                                                <td class="borderright">下注</td>
                                                <td class="borderright">派彩</td>
                                                <td class="borderright">差额</td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        $color = '#FFFFFF';
                                        $over = '#EBEBEB';
                                        $out = '#ffffff';
                                        $_LIVE_SUM = array(0, 0);
                                        $sql = 'SELECT ';
                                        foreach ($_LIVE as $key => $v) {
                                            $sql .= 'SUM(IF(p.platform_id=' . $key . ', bet_amount, 0)) AS `bet_' . $key . '`, ';
                                            $sql .= 'SUM(IF(p.platform_id=' . $key . ', net_amount, 0)) AS `net_' . $key . '`, ';
                                        }
                                        $sql .= 'u.top_uid FROM daily_report p LEFT OUTER JOIN k_user u ON u.uid=p.uid WHERE u.top_uid=:uid AND p.report_date>=:q_btime AND p.report_date<:q_etime ' . $selectwhere;
                                        $params = array(':uid' => $uid, ':q_btime' => strtotime($begin_time), ':q_etime' => strtotime($end_time));
                                        $stmt = $mydata1_db->prepare($sql);
                                        $stmt->execute($params);
                                        while ($row = $stmt->fetch()) {
                                            ?>
                                            <tr align="center" onMouseOver="this.style.backgroundColor='<?= $over; ?>'"
                                                onMouseOut="this.style.backgroundColor='<?= $out; ?>'"
                                                style="background-color:<?= $color; ?>;">
                                                <?php
                                                foreach ($_LIVE as $key => $value) {
                                                    $_LIVE_SUM[0] += $row['bet_' . $key] / 100;
                                                    $_LIVE_SUM[1] += -1 * ($row['net_' . $key] / 100);
                                                    ?>
                                                    <td class="borderright"><?= sprintf('%.2f', $row['bet_' . $key] / 100); ?></td>
                                                    <td class="borderright"><?= sprintf('%.2f', ($row['bet_' . $key] + $row['net_' . $key]) / 100); ?></td>
                                                    <td class="borderright"
                                                        style="color:<?= $row['net_' . $key] < 0 ? '#ff0000' : '#009900'; ?>"><?= sprintf('%.2f', (-1 * $row['net_' . $key]) / 100); ?></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <table width="100%" border="0" cellpadding="5" cellspacing="0"
                                       style="line-height:20px;">
                                    <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;">
                                        <td colspan="17"><?= $begin_time; ?> 至 <?= $end_time; ?> 下线会员投注报表</td>
                                    </tr>
                                    <tr align="center" style="background:#3C4D82;color:#ffffff;">
                                        <td colspan="2" class="borderright">体育</td>
                                        <td colspan="2" class="borderright">六合彩</td>
                                        <td colspan="2" class="borderright">极速彩</td>
                                        <td colspan="2" class="borderright">时时彩</td>
                                        <td colspan="2" class="borderright">普通彩</td>
                                        <td colspan="2" class="borderright">真人娱乐</td>
                                        <td colspan="2" class="borderright">合计</td>
                                        <td colspan="3" class="borderright">代理佣金</td>
                                    </tr>
                                    <tr align="center" style="background:#3C4D82;color:#ffffff;">
                                        <td class="borderright">下注</td>
                                        <td class="borderright">盈亏</td>
                                        <td class="borderright">下注</td>
                                        <td class="borderright">盈亏</td>
                                        <td class="borderright">下注</td>
                                        <td class="borderright">盈亏</td>
                                        <td class="borderright">下注</td>
                                        <td class="borderright">盈亏</td>
                                        <td class="borderright">下注</td>
                                        <td class="borderright">盈亏</td>
                                        <td class="borderright">下注</td>
                                        <td class="borderright">盈亏</td>
                                        <td class="borderright">下注</td>
                                        <td class="borderright">盈亏</td>
                                        <td class="borderright">理论</td>
                                        <td class="borderright">扣除</td>
                                        <td class="borderright">实际</td>
                                    </tr>
                                    <?php
                                    $params = array(':uid' => $uid, ':begin_time' => $begin_time, ':end_time' => $end_time, ':uid2' => $uid, ':begin_time2' => $begin_time, ':end_time2' => $end_time, ':uid3' => $uid, ':cn_begin_time3' => $cn_begin_time, ':cn_end_time3' => $cn_end_time, ':uid4' => $uid, ':begin_time4' => $begin_time, ':end_time4' => $end_time, ':uid5' => $uid, ':begin_time5' => $begin_time, ':end_time5' => $end_time, ':uid6' => $uid, ':begin_time6' => $begin_time, ':end_time6' => $end_time, ':uid7' => $uid, ':begin_time7' => strtotime($begin_time), ':end_time7' => strtotime($end_time));

                                    $sql = 'select sum(ty_num) as ty_num,sum(ty_bet_money) as ty_bet_money,sum(ty_yingkui) as ty_yingkui,sum(lh_num) as lh_num,sum(lh_bet_money) as lh_bet_money,sum(lh_yingkui) as lh_yingkui,sum(js_num) as js_num,sum(js_bet_money) as js_bet_money,sum(js_yingkui) as js_yingkui,sum(ss_num) as ss_num,sum(ss_bet_money) as ss_bet_money,sum(ss_yingkui) as ss_yingkui,sum(pt_num) as pt_num,sum(pt_bet_money) as pt_bet_money,sum(pt_yingkui) as pt_yingkui from (';
                                    $sql_cz = 'select if(status<>0,1,0) as ty_num,if(status<>0,bet_money,0) as ty_bet_money,if(status<>0,bet_money-win-fs,0) as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,0 as ss_num,0 as ss_bet_money,0 as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from k_bet k left outer join k_user u on k.uid=u.uid where lose_ok=1 and status in (0,1,2,3,4,5,6,7,8) and u.top_uid=:uid and k.bet_time>=:begin_time and k.bet_time<=:end_time ' . $selectwhere;
                                    $sql_cz .= ' union all ';
                                    $sql_cz .= 'select if(status<>0 and status<>2,1,0) as ty_num,if(status<>0 and status<>2,bet_money,0) as ty_bet_money,if(status<>0 and status<>2,bet_money-win-fs,0) as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,0 as ss_num,0 as ss_bet_money,0 as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from k_bet_cg_group k left outer join k_user u on k.uid=u.uid where k.gid>0 and status in (0,1,2,3,4) and u.top_uid=:uid2 and k.bet_time>=:begin_time2 and k.bet_time<=:end_time2 ' . $selectwhere;
                                    $sql_cz .= ' union all ';
                                    $sql_cz .= 'select 0 as ty_num,0 as ty_bet_money,0 as ty_yingkui,if(checked=1,1,0) as lh_num,if(checked=1,sum_m,0) as lh_bet_money,if(checked=1,(case bm when 1 then sum_m-sum_m*rate-sum_m*user_ds/100 when 2 then 0 else sum_m-sum_m*user_ds/100 end),0) as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,0 as ss_num,0 as ss_bet_money,0 as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from mydata2_db.ka_tan k left outer join k_user u on k.username=u.username where u.top_uid=:uid3 and adddate>=:cn_begin_time3 and adddate<=:cn_end_time3 ' . $selectwhere;
                                    $sql_cz .= ' union all ';
                                    $sql_cz .= 'select 0 as ty_num,0 as ty_bet_money,0 as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,if(k.status=1,1,0) as js_num,if(k.status=1,k.money/100,0) as js_bet_money,if(k.status=1,(case when k.win<0 then k.money/100 else (k.money-k.win)/100 end),0) as js_yingkui,0 as ss_num,0 as ss_bet_money,0 as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from c_bet_data k left outer join k_user u on k.uid=u.uid where k.money>0 and u.top_uid=:uid7 and k.addtime BETWEEN :begin_time7 and :end_time7 and k.status between 0 and 1' . $selectwhere;
                                    $sql_cz .= ' union all ';
                                    $sql_cz .= 'select 0 as ty_num,0 as ty_bet_money,0 as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,if(js=1,1,0) as ss_num,if(js=1,k.money,0) as ss_bet_money,if(js=1,(case when k.win<0 then k.money when k.win=0 then 0 else k.money-k.win end),0) as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from c_bet k left outer join k_user u on k.username=u.username where k.money>0 and k.type=\'重庆时时彩\' and u.top_uid=:uid4 and k.addtime>=:begin_time4 and k.addtime<=:end_time4 ' . $selectwhere;
                                    $sql_cz .= ' union all ';
                                    $sql_cz .= 'select 0 as ty_num,0 as ty_bet_money,0 as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,if(js=1,1,0) as ss_num,if(js=1,k.money,0) as ss_bet_money,if(js=1,(case when k.win<0 then k.money when k.win=0 then 0 else k.money-k.win end),0) as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from c_bet_3 k left outer join k_user u on k.username=u.username where k.money>0 and u.top_uid=:uid5 and k.addtime>=:begin_time5 and k.addtime<=:end_time5 ' . $selectwhere;
                                    $sql_cz .= ' union all ';
                                    $sql_cz .= 'select 0 as ty_num,0 as ty_bet_money,0 as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,0 as ss_num,0 as ss_bet_money,0 as ss_yingkui,if(k.bet_ok=1,1,0) as pt_num,if(k.bet_ok=1,k.money,0) as pt_bet_money,if(k.bet_ok=1,(-1*k.win),0) as pt_yingkui from lottery_data k left outer join k_user u on k.username=u.username where k.money>0 and u.top_uid=:uid6 and k.bet_time>=:begin_time6 and k.bet_time<=:end_time6 ' . $selectwhere;
                                    $sql .= $sql_cz;
                                    $sql .= ') temp';
                                    $stmt = $mydata1_db->prepare($sql);
                                    $stmt->execute($params);
                                    $zr_yongjin = ($_LIVE_SUM[1] * $rate_zr) / 100;
                                    while ($row = $stmt->fetch()) {
                                        $bet_money = $row['ty_bet_money'] + $row['lh_bet_money'] + $row['js_bet_money'] + $row['ss_bet_money'] + $row['pt_bet_money'] + $_LIVE_SUM[0];
                                        $yingkui = $row['ty_yingkui'] + $row['lh_yingkui'] + $row['js_yingkui'] + $row['ss_yingkui'] + $row['pt_yingkui'] + $_LIVE_SUM[1];
                                        $llyongjin = ((($row['ty_yingkui'] * $rate_ty) / 100) + (($row['lh_yingkui'] * $rate_lh) / 100) + (($row['js_yingkui'] * $rate_js) / 100) + (($row['ss_yingkui'] * $rate_ss) / 100) + (($row['pt_yingkui'] * $rate_pt) / 100) + $zr_yongjin);
                                        $yongjin = $llyongjin - $feiyong;
                                        $yongjin = ($yongjin < 0 ? 0 : $yongjin);
                                        ?>
                                        <tr align="center" onMouseOver="this.style.backgroundColor='<?= $over; ?>'" onMouseOut="this.style.backgroundColor='<?= $out; ?>'" style="background-color:<?= $color; ?>;">
                                           <td class="borderright"> <?= sprintf('%.2f', $row['ty_bet_money']); ?></td>
                                            <td class="borderright" style="color: <?= $row['ty_yingkui'] > 0 ? '#ff0000' : '#009900'; ?>"> <?= sprintf('%.2f', $row['ty_yingkui']); ?></td>

                                            <td class="borderright"> <?= sprintf('%.2f', $row['lh_bet_money']); ?></td>
                                            <td class="borderright" style="color:<?= $row['lh_yingkui'] > 0 ? '#ff0000' : '#009900'; ?>"> <?= sprintf('%.2f', $row['lh_yingkui']); ?></td>
                                             
                                            <td class="borderright"> <?= sprintf('%.2f', $row['js_bet_money']); ?></td>
                                            <td class="borderright" style="color:<?= $row['js_yingkui'] > 0 ? '#ff0000' : '#009900'; ?>"> <?= sprintf('%.2f', $row['js_yingkui']); ?></td>
                                            

                                            <td class="borderright"> <?= sprintf('%.2f', $row['ss_bet_money']); ?></td>
                                            <td class="borderright" style="color:<?= $row['ss_yingkui'] > 0 ? '#ff0000' : '#009900'; ?>"> <?= sprintf('%.2f', $row['ss_yingkui']); ?></td>
                                           
                                            <td class="borderright"> <?= sprintf('%.2f', $row['pt_bet_money']); ?></td>
                                            <td class="borderright" style="color:<?= $row['pt_yingkui'] > 0 ? '#ff0000' : '#009900'; ?>"> <?= sprintf('%.2f', $row['pt_yingkui']); ?></td>
                                            
                                            <td class="borderright"><?= sprintf('%.2f', $_LIVE_SUM[0]); ?></td>
                                            <td class="borderright" style="color:<?= $_LIVE_SUM[1] > 0 ? '#ff0000' : '#009900'; ?>"> <?= sprintf('%.2f', $_LIVE_SUM[1]); ?></td>
                                            
                                            <td class="borderright"> <?= sprintf('%.2f', $bet_money); ?></td>
                                            <td class="borderright" style="color:<?= $yingkui > 0 ? '#ff0000' : '#009900'; ?>"> <?= sprintf('%.2f', $yingkui); ?></td>
                                            
                                            <td style="color:<?= $llyongjin > 0 ? '#ff0000' : '#009900'; ?>"> <?= sprintf('%.2f', $llyongjin); ?></td>
                                            <td style="color:<?= $feiyong > 0 ? '#009900' : '#ff0000'; ?>"> <?= sprintf('%.2f', $feiyong); ?></td>
                                            <td style="color:<?= $yongjin > 0 ? '#ff0000' : '#009900'; ?>"> <?= sprintf('%.2f', $yongjin); ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">计算说明：</td>
                        </tr>
                        <tr>
                            <td align="left">
                                1、代理佣金=体育盈亏×体育比例+六合彩盈亏×六合彩比例+极速彩盈亏×极速彩比例+时时彩盈亏×时时彩比例+普通彩盈亏×普通彩比例+(下注-派彩)×真人比例-红利派送-手续费
                            </td>
                        </tr>
                        <tr>
                            <td align="left">2、如果按照①的公式计算结果小于0，则代理佣金为0</td>
                        </tr>
                        <tr>
                            <td align="left">3、佣金比例可自行调整</td>
                        </tr>
                        <tr>
                            <td align="left">4、如有特殊代理合作方式，可依据以上相关统计数据自行计算佣金</td>
                        </tr>
                        <tr>
                            <td align="left">5、合作双方如有其它约定，不在本报表中体现</td>
                        </tr>
                        <tr>
                            <td align="left" style="color:#f00">6、真人下注非实时结果，需要等待系统生成报表后才能查询！</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    </body>
    </html>
<?php
function getlastmonth($date)
{
    $firstday = date('Y-m-01', strtotime($date . ' -1 month'));
    $lastday = date('Y-m-d', strtotime($firstday . ' +1 month -1 day'));
    return array($firstday, $lastday);
}
?>