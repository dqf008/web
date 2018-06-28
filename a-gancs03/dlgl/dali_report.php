<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('dlgl');
$lastmonth = getlastmonth(date('Y-m-d', time()));
$time = $_GET['time'];
$time = ($time == '' ? 'EN' : $time);
$bdate = $_GET['bdate'];
$bdate = ($bdate == '' ? $lastmonth[0] : $bdate);
$bhour = $_GET['bhour'];
$bhour = ($bhour == '' ? '00' : $bhour);
$bsecond = $_GET['bsecond'];
$bsecond = ($bsecond == '' ? '00' : $bsecond);
$edate = $_GET['edate'];
$edate = ($edate == '' ? $lastmonth[1] : $edate);
$ehour = $_GET['ehour'];
$ehour = ($ehour == '' ? '23' : $ehour);
$esecond = $_GET['esecond'];
$esecond = ($esecond == '' ? '59' : $esecond);
$btime = $bdate . ' ' . $bhour . ':' . $bsecond . ':00';
$etime = $edate . ' ' . $ehour . ':' . $esecond . ':59';
$username = $_GET['username'];
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
?>
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <title>Welcome</title>
        <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all"/>
        <script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
        <script language="JavaScript" src="/js/calendar.js"></script>
    </head>
    <body>
    <div id="pageMain">
        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="font12"
               style="border:1px solid #798EB9;">
            <form name="form1" method="get" action="">
                <tr bgcolor="#FFFFFF">
                    <td align="left">
                        <select name="time" id="time" disabled="disabled">
                            <option value="CN" <?= $time == 'CN' ? 'selected' : '' ?>>中国时间</option>
                            <option value="EN" <?= $time == 'EN' ? 'selected' : '' ?>>美东时间</option>
                        </select>

                        &nbsp;开始日期
                        <input name="bdate" type="text" id="bdate" value="<?= $bdate ?>"
                               onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10"
                               readonly="readonly"/>
                        <select name="bhour" id="bhour">
                            <?php
                            for ($i = 0; $i < 24; $i++) {
                                $list = $i < 10 ? "0" . $i : $i;
                                ?>
                                <option value="<?= $list ?>" <?= $bhour == $list ? "selected" : "" ?>><?= $list ?></option>
                            <?php } ?>
                        </select>&nbsp;时
                        <select name="bsecond" id="bsecond">
                            <?php
                            for ($i = 0; $i < 60; $i++) {
                                $list = $i < 10 ? "0" . $i : $i;
                                ?>
                                <option value="<?= $list ?>" <?= $bsecond == $list ? "selected" : "" ?>><?= $list ?></option>
                            <?php } ?>
                        </select>&nbsp;分
                        &nbsp;结束日期
                        <input name="edate" type="text" id="edate" value="<?= $edate ?>"
                               onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10"
                               readonly="readonly"/>
                        <select name="ehour" id="ehour">
                            <?php
                            for ($i = 0; $i < 24; $i++) {
                                $list = $i < 10 ? "0" . $i : $i;
                                ?>
                                <option value="<?= $list ?>" <?= $ehour == $list ? "selected" : "" ?>><?= $list ?></option>
                            <?php } ?>
                        </select>&nbsp;时
                        <select name="esecond" id="esecond">
                            <?php
                            for ($i = 0; $i < 60; $i++) {
                                $list = $i < 10 ? "0" . $i : $i;
                                ?>
                                <option value="<?= $list ?>" <?= $esecond == $list ? "selected" : "" ?>><?= $list ?></option>
                            <?php } ?>
                        </select>&nbsp;分
                        &nbsp;代理账号
                        <input name="username" type="text" id="username" value="<?= $username; ?>" size="15"
                               maxlength="20"/>
                        <input name="doquery" type="hidden" id="doquery" value="1"/>
                        &nbsp;<input name="find" type="submit" id="find" value="计算"/>
                        <span style="color:red;font-size:11px;">备注:代理账号,不填,表示所有代理</span>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td align="left">
                        &nbsp;体育比例
                        <input name="rate_ty" type="text" id="rate_ty" value="<?= $rate_ty; ?>" size="2" maxlength="3"/>&nbsp;%
                        &nbsp;六合彩比例
                        <input name="rate_lh" type="text" id="rate_lh" value="<?= $rate_lh; ?>" size="2" maxlength="3"/>&nbsp;%
                        &nbsp;极速彩比例
                        <input name="rate_js" type="text" id="rate_js" value="<?= $rate_js; ?>" size="2" maxlength="3"/>&nbsp;%
                        &nbsp;时时彩比例
                        <input name="rate_ss" type="text" id="rate_ss" value="<?= $rate_ss; ?>" size="2" maxlength="3"/>&nbsp;%
                        &nbsp;普通彩比例
                        <input name="rate_pt" type="text" id="rate_pt" value="<?= $rate_pt; ?>" size="2" maxlength="3"/>&nbsp;%
                        &nbsp;真人比例
                        <input name="rate_zr" type="text" id="rate_zr" value="<?= $rate_zr; ?>" size="2" maxlength="3"/>&nbsp;%
                    </td>
                </tr>
            </form>
        </table>
        <?php
        $color = '#FFFFFF';
        $over = '#EBEBEB';
        $out = '#ffffff';
        if ($time == 'CN') {
            $q_btime = date('Y-m-d H:i:s', strtotime($btime) - (12 * 3600));
            $q_etime = date('Y-m-d H:i:s', strtotime($etime) - (12 * 3600));
        } else {
            $q_btime = $btime;
            $q_etime = $etime;
        }
        $cn_q_btime = date('Y-m-d H:i:s', strtotime($btime) + (12 * 3600));
        $cn_q_etime = date('Y-m-d H:i:s', strtotime($etime) + (12 * 3600));
        $sqlwhere = '';
        if ($_GET['doquery'] != 1) {
            $sqlwhere = ' and 1=2';
        }
        if ($username != '') {
            $params = array(':username' => $username);
            $sql = 'select u.uid,u.username from k_user u left outer join k_user tu on u.top_uid=tu.uid where u.top_uid>0 and tu.username=:username and tu.is_daili=1';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $uids = '';
            $usernames = '';
            while ($row = $stmt->fetch()) {
                $uids .= intval($row['uid']) . ',';
                $usernames .= '\'' . $row['username'] . '\',';
            }
            $uids = rtrim($uids, ',');
            $usernames = rtrim($usernames, ',');
            if ($usernames != '') {
                $sqlwhere = ' and u.uid in (' . $uids . ')';
            } else {
                $sqlwhere = ' and 1=2';
            }
        }
        $params = array(':q_btime' => $q_btime, ':q_etime' => $q_etime, ':q_btime2' => $q_btime, ':q_etime2' => $q_etime, ':q_btime3' => $q_btime, ':q_etime3' => $q_etime);
        $sql = 'select tm.*,u.username,(select count(1) from k_user where top_uid=tm.top_uid) as top_num,(select sum(money) from k_user where top_uid=tm.top_uid) as money from (';
        $sql .= 'select top_uid,sum(t1_value) as t1_value,sum(t2_value) as t2_value,sum(t3_value) as t3_value,sum(t4_value) as t4_value,sum(t5_value) as t5_value,sum(t6_value) as t6_value,sum(t1_sxf) as t1_sxf,sum(t2_sxf) as t2_sxf,sum(h_value) as h_value,sum(h_zsjr) as h_zsjr,sum(ag_inmoney) as ag_inmoney,sum(ag_outmoney) as ag_outmoney,sum(agq_inmoney) as agq_inmoney,sum(agq_outmoney) as agq_outmoney,sum(bb_inmoney) as bb_inmoney,sum(bb_outmoney) as bb_outmoney,sum(mg_inmoney) as mg_inmoney,sum(mg_outmoney) as mg_outmoney,sum(og_inmoney) as og_inmoney,sum(og_outmoney) as og_outmoney,sum(maya_inmoney) as maya_inmoney,sum(maya_outmoney) as maya_outmoney,sum(mw_inmoney) as mw_inmoney,sum(mw_outmoney) as mw_outmoney,sum(shaba_inmoney) as shaba_inmoney,sum(shaba_outmoney) as shaba_outmoney,sum(ipm_inmoney) as ipm_inmoney,sum(ipm_outmoney) as ipm_outmoney,sum(kg_inmoney) as kg_inmoney,sum(kg_outmoney) as kg_outmoney,sum(hg_inmoney) as hg_inmoney,sum(pt_outmoney) as pt_outmoney from (';
        $sql .= 'select u.top_uid,sum(if(m.type=1,m.m_value,0)) as t1_value,sum(if(m.type=2,m.m_value,0)) as t2_value,sum(if(m.type=3,m.m_value,0)) as t3_value,sum(if(m.type=4,m.m_value,0)) as t4_value,sum(if(m.type=5,m.m_value,0)) as t5_value,sum(if(m.type=6,m.m_value,0)) as t6_value,sum(if(m.type=1,m.sxf,0)) as t1_sxf,sum(if(m.type=2,m.sxf,0)) as t2_sxf,0 as h_value, 0 as h_zsjr,0 as ag_inmoney,0 as ag_outmoney,0 as agq_inmoney,0 as agq_outmoney,0 as bb_inmoney,0 as bb_outmoney,0 as mg_inmoney,0 as mg_outmoney,0 as mw_inmoney,0 as mw_outmoney,0 as og_inmoney,0 as og_outmoney,0 as maya_inmoney,0 as maya_outmoney,0 as shaba_inmoney,0 as shaba_outmoney,0 as ipm_inmoney,0 as ipm_outmoney,0 as kg_inmoney,0 as kg_outmoney,0 as hg_inmoney,0 as hg_outmoney,0 as pt_inmoney,0 as pt_outmoney from k_money m left outer join k_user u on m.uid=u.uid where m.status=1 and u.top_uid>0 and m.m_make_time>=:q_btime and m.m_make_time<=:q_etime ' . $sqlwhere . ' group by u.top_uid';
        $sql .= ' union all ';
        $sql .= 'select u.top_uid,0 as t1_value,0 as t2_value,0 as t3_value,0 as t4_value,0 as t5_value,0 as t6_value,0 as t1_sxf,0 as t2_sxf,sum(ifnull(h.money,0)) as h_value,sum(ifnull(h.zsjr,0)) as h_zsjr,0 as ag_inmoney,0 as ag_outmoney,0 as agq_inmoney,0 as agq_outmoney,0 as bb_inmoney,0 as bb_outmoney,0 as mg_inmoney,0 as mg_outmoney,0 as mw_inmoney,0 as mw_outmoney,0 as og_inmoney,0 as og_outmoney,0 as maya_inmoney,0 as maya_outmoney,0 as shaba_inmoney,0 as shaba_outmoney,0 as ipm_inmoney,0 as ipm_outmoney,0 as kg_inmoney,0 as kg_outmoney,0 as hg_inmoney,0 as hg_outmoney,0 as pt_inmoney,0 as pt_outmoney from huikuan h left outer join k_user u on h.uid=u.uid where h.status=1 and u.top_uid>0 and h.adddate>=:q_btime2 and h.adddate<=:q_etime2 ' . $sqlwhere . ' group by u.top_uid';
        $sql .= ' union all ';
        $sql .= 'select u.top_uid,0 as t1_value,0 as t2_value,0 as t3_value,0 as t4_value,0 as t5_value,0 as t6_value,0 as t1_sxf,0 as t2_sxf,0 as h_value,0 as h_zsjr,
	   sum(if(z.zz_type=\'IN\' and z.live_type=\'AGIN\',z.zz_money,0)) as ag_inmoney,
	   sum(if(z.zz_type=\'OUT\'  and z.live_type=\'AGIN\',z.zz_money,0)) as ag_outmoney,
	   sum(if(z.zz_type=\'IN\' and z.live_type=\'AG\',z.zz_money,0)) as agq_inmoney,
	   sum(if(z.zz_type=\'OUT\' and z.live_type=\'AG\',z.zz_money,0)) as agq_outmoney,
	   sum(if(z.zz_type=\'IN\' and z.live_type=\'BBIN\',z.zz_money,0)) as bb_inmoney,
	   sum(if(z.zz_type=\'OUT\' and z.live_type=\'BBIN\',z.zz_money,0)) as bb_outmoney,
	   sum(if(z.zz_type=\'IN\' and z.live_type=\'OG\',z.zz_money,0)) as og_inmoney,
	   sum(if(z.zz_type=\'OUT\' and z.live_type=\'OG\',z.zz_money,0)) as og_outmoney ,
	   sum(if(z.zz_type=\'IN\' and z.live_type=\'HG\',z.zz_money,0)) as hg_inmoney,
	   sum(if(z.zz_type=\'OUT\' and z.live_type=\'HG\',z.zz_money,0)) as hg_outmoney ,
	   sum(if(z.zz_type=\'IN\' and z.live_type=\'MAYA\',z.zz_money,0)) as maya_inmoney,
	   sum(if(z.zz_type=\'OUT\' and z.live_type=\'MAYA\',z.zz_money,0)) as maya_outmoney,
	   sum(if(z.zz_type=\'IN\' and z.live_type=\'KG\',z.zz_money,0)) as kg_inmoney,
	   sum(if(z.zz_type=\'OUT\' and z.live_type=\'KG\',z.zz_money,0)) as kg_outmoney,
	   sum(if(z.zz_type=\'IN\' and z.live_type=\'MG\',z.zz_money,0)) as mg_inmoney,
	   sum(if(z.zz_type=\'OUT\' and z.live_type=\'MG\',z.zz_money,0)) as mg_outmoney,
	   sum(if(z.zz_type=\'IN\' and z.live_type=\'PT\',z.zz_money,0)) as pt_inmoney,
	   sum(if(z.zz_type=\'OUT\' and z.live_type=\'PT\',z.zz_money,0)) as pt_outmoney, 
	   sum(if(z.zz_type=\'IN\' and z.live_type=\'MW\',z.zz_money,0)) as mw_inmoney,
	   sum(if(z.zz_type=\'OUT\' and z.live_type=\'MW\',z.zz_money,0)) as mw_outmoney, 
	   sum(if(z.zz_type=\'IN\' and z.live_type=\'SHABA\',z.zz_money,0)) as shaba_inmoney,
	   sum(if(z.zz_type=\'OUT\' and z.live_type=\'SHABA\',z.zz_money,0)) as shaba_outmoney, 
	   sum(if(z.zz_type=\'IN\' and z.live_type=\'IPM\',z.zz_money,0)) as ipm_inmoney,
	   sum(if(z.zz_type=\'OUT\' and z.live_type=\'IPM\',z.zz_money,0)) as ipm_outmoney
	 from ag_zhenren_zz z left outer join k_user u on z.uid=u.uid where u.top_uid>0 and z.ok=1 and z.zz_time>=:q_btime3 and z.zz_time<=:q_etime3 ' . $sqlwhere . ' group by u.top_uid';
        $sql .= ')temp group by top_uid';
        $sql .= ')tm left outer join k_user u on tm.top_uid=u.uid and u.is_daili=1';

        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        ?>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12"
               style="margin-top:5px;line-height:20px;" bgcolor="#798EB9">
            <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;">
                <td colspan="13"><?= $btime; ?>至<?= $etime; ?>代理财务报表</td>
            </tr>
            <tr align="center" style="background:#3C4D82;color:#ffffff;">
                <td rowspan="2">代理账号</td>
                <td rowspan="2">下线会员</td>
                <td rowspan="2">下线余额</td>
                <td colspan="4">常规存取款</td>
                <td colspan="3">红利派送</td>
                <td rowspan="2">其他情况</td>
                <td colspan="2">手续费(银行转账费用)</td>
            </tr>
            <tr align="center" style="background:#3C4D82;color:#ffffff;">
                <td>存款</td>
                <td>汇款</td>
                <td>人工汇款</td>
                <td>提款</td>
                <td>汇款赠送</td>
                <td>彩金派送</td>
                <td>反水派送</td>
                <td>第三方(1%)</td>
                <td>提款手续费</td>
            </tr>
            <?php
            $sum_t1_value = 0;
            $sum_t2_value = 0;
            $sum_t3_value = 0;
            $sum_t4_value = 0;
            $sum_t5_value = 0;
            $sum_t6_value = 0;
            $sum_t1_sxf = 0;
            $sum_t2_sxf = 0;
            $sum_h_value = 0;
            $sum_h_zsjr = 0;
            $sum_top_num = 0;
            $sum_ag_inmoney = 0;
            $sum_ag_outmoney = 0;
            $sum_agq_inmoney = 0;
            $sum_agq_outmoney = 0;
            $sum_bb_inmoney = 0;
            $sum_bb_outmoney = 0;
            $sum_mg_inmoney = 0;
            $sum_mg_outmoney = 0;
            $sum_og_inmoney = 0;
            $sum_og_outmoney = 0;
            $sum_hg_inmoney = 0;
            $sum_hg_outmoney = 0;
            $sum_pt_inmoney = 0;
            $sum_pt_outmoney = 0;
            $sum_mw_inmoney = 0;
            $sum_mw_outmoney = 0;
            $sum_maya_inmoney = 0;
            $sum_maya_outmoney = 0;
            $sum_shaba_inmoney = 0;
            $sum_shaba_outmoney = 0;
            $sum_ipm_inmoney = 0;
            $sum_ipm_outmoney = 0;
            $sum_kg_inmoney = 0;
            $sum_kg_outmoney = 0;
            $arr_money = array();
            $arr_live = array();
            foreach ($rows as $number => $row) {
                $arr_money[$row['top_uid']] = $row['h_zsjr'] + $row['t4_value'] + $row['t5_value'] + $row['t1_sxf'] + $row['t2_sxf'];
                $arr_live[$row['top_uid']] = (($row['ag_inmoney'] - $row['ag_outmoney'] + $row['agq_inmoney'] - $row['agq_outmoney'] + $row['bb_inmoney'] - $row['bb_outmoney'] + $row['mg_inmoney'] - $row['mg_outmoney'] + $row['og_inmoney'] - $row['og_outmoney'] + $row['mw_inmoney'] - $row['mw_outmoney'] + $row['maya_inmoney'] - $row['maya_outmoney'] + $row['shaba_inmoney'] - $row['shaba_outmoney'] + $row['ipm_inmoney'] - $row['ipm_outmoney'] + $row['kg_inmoney'] - $row['kg_outmoney'] + $row['pt_inmoney'] - $row['pt_outmoney'] + $row['hg_inmoney'] - $row['hg_outmoney']) * $rate_zr) / 100;
                $sum_t1_value += $row['t1_value'];
                $sum_t2_value += abs($row['t2_value']);
                $sum_t3_value += $row['t3_value'];
                $sum_t4_value += $row['t4_value'];
                $sum_t5_value += $row['t5_value'];
                $sum_t6_value += $row['t6_value'];
                $sum_t1_sxf += $row['t1_sxf'];
                $sum_t2_sxf += $row['t2_sxf'];
                $sum_h_value += $row['h_value'];
                $sum_h_zsjr += $row['h_zsjr'];
                $sum_money += $row['money'];
                $sum_top_num += $row['top_num'];
                $sum_ag_inmoney += $row['ag_inmoney'];
                $sum_ag_outmoney += $row['ag_outmoney'];
                $sum_agq_inmoney += $row['agq_inmoney'];
                $sum_agq_outmoney += $row['agq_outmoney'];
                $sum_bb_inmoney += $row['bb_inmoney'];
                $sum_bb_outmoney += $row['bb_outmoney'];
                $sum_mg_inmoney += $row['mg_inmoney'];
                $sum_mg_outmoney += $row['mg_outmoney'];
                $sum_pt_inmoney += $row['pt_inmoney'];
                $sum_pt_outmoney += $row['pt_outmoney'];
                $sum_mw_inmoney += $row['mw_inmoney'];
                $sum_mw_outmoney += $row['mw_outmoney'];
                $sum_og_inmoney += $row['og_inmoney'];
                $sum_og_outmoney += $row['og_outmoney'];
                $sum_hg_inmoney += $row['hg_inmoney'];
                $sum_hg_outmoney += $row['hg_outmoney'];
                $sum_maya_inmoney += $row['maya_inmoney'];
                $sum_maya_outmoney += $row['maya_outmoney'];
                $sum_shaba_inmoney += $row['shaba_inmoney'];
                $sum_shaba_outmoney += $row['shaba_outmoney'];
                $sum_ipm_inmoney += $row['ipm_inmoney'];
                $sum_ipm_outmoney += $row['ipm_outmoney'];
                $sum_kg_inmoney += $row['kg_inmoney'];
                $sum_kg_outmoney += $row['kg_outmoney'];
                empty($row['username']) && $row['username'] = '<s>已删除</s>';
                ?>
                <tr align="center" onMouseOver="this.style.backgroundColor='<?= $over; ?>'"
                    onMouseOut="this.style.backgroundColor='<?= $out; ?>'" style="background-color:<?= $color; ?>;">
                    <td><?= $row['username']; ?></td>
                    <td><a href="../hygl/list.php?top_uid=<?= $row['top_uid']; ?>"><?= $row['top_num']; ?></a></td>
                    <td><?= sprintf('%.2f', $row['money']); ?></td>
                    <td><?= sprintf('%.2f', $row['t1_value']); ?></td>
                    <td><?= sprintf('%.2f', $row['h_value']); ?></td>
                    <td><?= sprintf('%.2f', $row['t3_value']); ?></td>
                    <td><?= sprintf('%.2f', abs($row['t2_value'])); ?></td>
                    <td><?= sprintf('%.2f', $row['h_zsjr']); ?></td>
                    <td><?= sprintf('%.2f', $row['t4_value']); ?></td>
                    <td><?= sprintf('%.2f', $row['t5_value']); ?></td>
                    <td><?= sprintf('%.2f', $row['t6_value']); ?></td>
                    <td><?= sprintf('%.2f', $row['t1_sxf']); ?></td>
                    <td><?= sprintf('%.2f', $row['t2_sxf']); ?></td>
                </tr>
            <?php } ?>
            <tr align="center" style="background:#ffffff;color:#ff0000;">
                <td>合计</td>
                <td><?= $sum_top_num; ?></td>
                <td><?= sprintf('%.2f', $sum_money); ?></td>
                <td><?= sprintf('%.2f', $sum_t1_value); ?></td>
                <td><?= sprintf('%.2f', $sum_h_value); ?></td>
                <td><?= sprintf('%.2f', $sum_t3_value); ?></td>
                <td><?= sprintf('%.2f', $sum_t2_value); ?></td>
                <td><?= sprintf('%.2f', $sum_h_zsjr); ?></td>
                <td><?= sprintf('%.2f', $sum_t4_value); ?></td>
                <td><?= sprintf('%.2f', $sum_t5_value); ?></td>
                <td><?= sprintf('%.2f', $sum_t6_value); ?></td>
                <td><?= sprintf('%.2f', $sum_t1_sxf); ?></td>
                <td><?= sprintf('%.2f', $sum_t2_sxf); ?></td>
            </tr>
        </table>
        <?php
        $_LIVE = include('../../cj/include/live.php');
        $_LIVE_SUM = array();
        $_USER_SUM = array();
        $sql = 'SELECT tm.*,u.username FROM (';
        $sql .= 'SELECT ';
        foreach($_LIVE as $key=>$value){
            $_LIVE_SUM[$key] = array(0, 0);
            $sql .= 'SUM(IF(p.platform_id=' . $key . ', bet_amount, 0)) AS `bet_' . $key . '`, ';
            $sql .= 'SUM(IF(p.platform_id=' . $key . ', net_amount, 0)) AS `net_' . $key . '`, ';
        }
        $sql .= 'u.top_uid as uid FROM daily_report p LEFT OUTER JOIN k_user u on u.uid=p.uid WHERE u.top_uid>0 AND p.report_date>=:q_btime AND p.report_date<:q_etime ' . $sqlwhere . ' group by u.top_uid';
        $sql .= ') tm LEFT OUTER JOIN k_user u on u.uid=tm.uid WHERE u.is_daili=1';
        $params = array(':q_btime' => strtotime($q_btime), ':q_etime' => strtotime($q_etime));
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        ?>
        <div style="overflow-x:auto;">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12"
                   style="margin-top:5px;line-height:20px;" bgcolor="#798EB9">
                <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;">
                    <td colspan="<?php echo count($_LIVE) * 3 + 2; ?>"><?= $btime; ?>至<?= $etime; ?>代理真人下注报表</td>
                </tr>
                <tr align="center" style="background:#3C4D82;color:#ffffff;">
                    <td rowspan="2">代理账号</td>
                    <?php foreach ($_LIVE as $val) { ?>
                        <td colspan="3" class="borderright"><?php echo $val[1]; ?></td>
                    <?php } ?>      </tr>
                <tr align="center" style="background:#3C4D82;color:#ffffff;">
                    <?php for ($key = 0; $key < count($_LIVE); $key++) { ?>
                        <td>下注</td>
                        <td>派彩</td>
                        <td>差额</td>
                    <?php } ?>
                </tr>
                <?php
                foreach ($rows as $number => $row) {
                    $_USER_SUM[$row['uid']] = array(0, 0);
                    empty($row['username']) && $row['username'] = '<s>已删除</s>';
                    ?>
                    <tr align="center" onMouseOver="this.style.backgroundColor='<?= $over; ?>'"
                        onMouseOut="this.style.backgroundColor='<?= $out; ?>'" style="background-color:<?= $color; ?>;">
                        <td><?= $row['username']; ?></td>
                        <?php
                        foreach ($_LIVE as $key => $value) {
                            $_LIVE_SUM[$key][0] += $row['bet_' . $key] / 100;
                            $_LIVE_SUM[$key][1] += ($row['bet_' . $key] + $row['net_' . $key]) / 100;
                            $_USER_SUM[$row['uid']][0] += $row['bet_' . $key] / 100;
                            $_USER_SUM[$row['uid']][1] += ($row['bet_' . $key] + $row['net_' . $key]) / 100;
                            ?>
                            <td><?= sprintf('%.2f', $row['bet_' . $key] / 100); ?></td>
                            <td><?= sprintf('%.2f', ($row['bet_' . $key] + $row['net_' . $key]) / 100); ?></td>
                            <td style="color:<?= $row['net_' . $key] < 0 ? '#ff0000' : '#009900'; ?>"><?= sprintf('%.2f', (-1 * $row['net_' . $key]) / 100); ?></td>

                        <?php } ?>
                    </tr>
                    <?php
                }
                ?>
                <tr align="center" style="background:#ffffff;color:#ff0000;">
                    <td>合计</td>
                    <?php
                    foreach ($_LIVE as $key => $value) { ?>
                        <td><?= sprintf('%.2f', $_LIVE_SUM[$key][0]); ?></td>
                        <td><?= sprintf('%.2f', $_LIVE_SUM[$key][1]); ?></td>
                        <td style="color:<?= $_LIVE_SUM[$key][0] - $_LIVE_SUM[$key][1] >= 0 ? '#ff0000' : '#009900'; ?>"><?= sprintf('%.2f', $_LIVE_SUM[$key][0] - $_LIVE_SUM[$key][1]); ?></td>
                    <?php } ?>
                </tr>
            </table>
        </div>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12"
               style="margin-top:5px;line-height:20px;" bgcolor="#798EB9">
            <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;">
                <td colspan="19"><?= $btime; ?>至<?= $etime; ?>代理投注报表 <span style="color:#00ffff;">[只统计已结算的注单]</span>
                </td>
            </tr>
            <tr align="center" style="background:#3C4D82;color:#ffffff;">
                <td rowspan="2">代理账号</td>
                <td colspan="2">体育</td>
                <td colspan="2">六合彩</td>
                <td colspan="2">极速彩</td>
                <td colspan="2">时时彩</td>
                <td colspan="2">普通彩票</td>
                <td colspan="3">真人娱乐</td>
                <td colspan="2">合计</td>
                <td colspan="3">佣金</td>
            </tr>
            <tr align="center" style="background:#3C4D82;color:#ffffff;">
                <td>下注</td>
                <td>盈亏</td>
                <td>下注</td>
                <td>盈亏</td>
                <td>下注</td>
                <td>盈亏</td>
                <td>下注</td>
                <td>盈亏</td>
                <td>下注</td>
                <td>盈亏</td>
                <td>下注</td>
                <td>派彩</td>
                <td>盈亏</td>
                <td>下注</td>
                <td>盈亏</td>
                <td>理论</td>
                <td>扣除</td>
                <td>实际</td>
            </tr>
            <?php
            $params = array(':q_btime' => $q_btime, ':q_etime' => $q_etime, ':cn_q_btime' => $cn_q_btime, ':cn_q_etime' => $cn_q_etime, ':q_btime2' => $q_btime, ':q_etime2' => $q_etime, ':q_btime4' => $q_btime, ':q_etime4' => $q_etime, ':q_btime5' => $q_btime, ':q_etime5' => $q_etime, ':q_btime6' => $q_btime, ':q_etime6' => $q_etime, ':q_btime7' => strtotime($q_btime), ':q_etime7' => strtotime($q_etime));
            $sql = 'select u.username,tm.top_uid,sum(ty_num) as ty_num,sum(ty_bet_money) as ty_bet_money,sum(ty_yingkui) as ty_yingkui,sum(lh_num) as lh_num,sum(lh_bet_money) as lh_bet_money,sum(lh_yingkui) as lh_yingkui,sum(js_num) as js_num,sum(js_bet_money) as js_bet_money,sum(js_yingkui) as js_yingkui,sum(ss_num) as ss_num,sum(ss_bet_money) as ss_bet_money,sum(ss_yingkui) as ss_yingkui,sum(pt_num) as pt_num,sum(pt_bet_money) as pt_bet_money,sum(pt_yingkui) as pt_yingkui from (';

            $sql .= 'select u.top_uid,sum(ty_num) as ty_num,sum(ty_bet_money) as ty_bet_money,sum(ty_yingkui) as ty_yingkui,sum(lh_num) as lh_num,sum(lh_bet_money) as lh_bet_money,sum(lh_yingkui) as lh_yingkui,sum(js_num) as js_num,sum(js_bet_money) as js_bet_money,sum(js_yingkui) as js_yingkui,sum(ss_num) as ss_num,sum(ss_bet_money) as ss_bet_money,sum(ss_yingkui) as ss_yingkui,sum(pt_num) as pt_num,sum(pt_bet_money) as pt_bet_money,sum(pt_yingkui) as pt_yingkui from (';


            $sql_cz = 'select u.uid,if(status<>0,1,0) as ty_num,if(status<>0,bet_money,0) as ty_bet_money,if(status<>0,bet_money-win-fs,0) as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,0 as ss_num,0 as ss_bet_money,0 as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from k_bet k left outer join k_user u on k.uid=u.uid where lose_ok=1 and status in (0,1,2,3,4,5,6,7,8) and u.top_uid>0 and k.bet_time>=:q_btime and k.bet_time<=:q_etime ' . $sqlwhere;

            $sql_cz .= ' union all ';

            $sql_cz .= 'select u.uid,if(status<>0 and status<>2,1,0) as ty_num,if(status<>0 and status<>2,bet_money,0) as ty_bet_money,if(status<>0 and status<>2,bet_money-win-fs,0) as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,0 as ss_num,0 as ss_bet_money,0 as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from k_bet_cg_group k left outer join k_user u on k.uid=u.uid where k.gid>0 and status in (0,1,2,3,4) and u.top_uid>0 and k.bet_time>=:q_btime2 and k.bet_time<=:q_etime2 ' . $sqlwhere;

            $sql_cz .= ' union all ';

            $sql_cz .= 'select u.uid,0 as ty_num,0 as ty_bet_money,0 as ty_yingkui,if(checked=1,1,0) as lh_num,if(checked=1,sum_m,0) as lh_bet_money,if(checked=1,(case bm when 1 then sum_m-sum_m*rate-sum_m*user_ds/100 when 2 then 0 else sum_m-sum_m*user_ds/100 end),0) as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,0 as ss_num,0 as ss_bet_money,0 as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from mydata2_db.ka_tan k left outer join k_user u on k.username=u.username where u.top_uid>0 and adddate>=:cn_q_btime and adddate<=:cn_q_etime ' . $sqlwhere;

            $sql_cz .= ' union all ';

            $sql_cz .= 'select u.uid,0 as ty_num,0 as ty_bet_money,0 as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,if(js=1,1,0) as ss_num,if(js=1,k.money,0) as ss_bet_money,if(js=1,(case when k.win<0 then k.money when k.win=0 then 0 else k.money-k.win end),0) as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from c_bet k left outer join k_user u on k.username=u.username where k.money>0 and k.type=\'重庆时时彩\' and u.top_uid>0 and k.addtime>=:q_btime4 and k.addtime<=:q_etime4 ' . $sqlwhere;

            $sql_cz .= ' union all ';

            $sql_cz .= 'select u.uid,0 as ty_num,0 as ty_bet_money,0 as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,if(js=1,1,0) as ss_num,if(js=1,k.money,0) as ss_bet_money,if(js=1,(case when k.win<0 then k.money when k.win=0 then 0 else k.money-k.win end),0) as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from c_bet_3 k left outer join k_user u on k.username=u.username where k.money>0 and u.top_uid>0 and k.addtime>=:q_btime5 and k.addtime<=:q_etime5 ' . $sqlwhere;

            $sql_cz .= ' union all ';

            $sql_cz .= 'select u.uid,0 as ty_num,0 as ty_bet_money,0 as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,0 as ss_num,0 as ss_bet_money,0 as ss_yingkui,if(k.bet_ok=1,1,0) as pt_num,if(k.bet_ok=1,k.money,0) as pt_bet_money,if(k.bet_ok=1,(-1*k.win),0) as pt_yingkui from lottery_data k left outer join k_user u on k.username=u.username where k.money>0 and u.top_uid>0 and k.bet_time>=:q_btime6 and k.bet_time<=:q_etime6 ' . $sqlwhere;

            $sql_cz .= ' union all ';

            $sql_cz .= 'select u.uid,0 as ty_num,0 as ty_bet_money,0 as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,if(k.status=1,1,0) as js_num,if(k.status=1,k.money/100,0) as js_bet_money,if(k.status=1,(case when k.win<0 then k.money/100 else (k.money-k.win)/100 end),0) as js_yingkui,0 as ss_num,0 as ss_bet_money,0 as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from c_bet_data k left outer join k_user u on k.uid=u.uid where k.money>0 and u.top_uid>0 and k.addtime BETWEEN :q_btime7 and :q_etime7 and k.status between 0 and 1 ' . $sqlwhere;

            $sql .= $sql_cz;
            $sql .= ') temp left outer join k_user u on temp.uid=u.uid group by u.top_uid';
            $money_users = implode(',', array_keys($arr_live));
            $where = '';
            if ($money_users) {
                $where = 'where uid in (' . $money_users . ')';
            } else {
                $where = 'where 1=2';
            }

            $sql .= ' union all ';
            $sql .= 'select uid as top_uid,0 as ty_num,0 as ty_bet_money,0 as ty_yingkui,0 as lh_num,0 as lh_bet_money,0 as lh_yingkui,0 as js_num,0 as js_bet_money,0 as js_yingkui,0 as ss_num,0 as ss_bet_money,0 as ss_yingkui,0 as pt_num,0 as pt_bet_money,0 as pt_yingkui from k_user ' . $where;

            $sql .= ')tm left outer join k_user u on tm.top_uid=u.uid and u.is_daili=1 group by tm.top_uid';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $sum_ty_num = 0;
            $sum_ty_bet_money = 0;
            $sum_ty_yingkui = 0;
            $sum_lh_num = 0;
            $sum_lh_bet_money = 0;
            $sum_lh_yingkui = 0;
            $sum_ss_num = 0;
            $sum_ss_bet_money = 0;
            $sum_ss_yingkui = 0;
            $sum_js_num = 0;
            $sum_js_bet_money = 0;
            $sum_js_yingkui = 0;
            $sum_pt_num = 0;
            $sum_pt_bet_money = 0;
            $sum_pt_yingkui = 0;
            $sum_zr_bet_money = 0;
            $sum_zr_net_money = 0;
            $sum_zr_yingkui = 0;
            $sum_bet_money = 0;
            $sum_yingkui = 0;
            $sum_llyongjin = 0;
            $sum_kouchu = 0;
            $sum_yongjin = 0;
            while ($row = $stmt->fetch()) {
                $sum_ty_num += $row['ty_num'];
                $sum_ty_bet_money += $row['ty_bet_money'];
                $sum_ty_yingkui += $row['ty_yingkui'];
                $sum_lh_num += $row['lh_num'];
                $sum_lh_bet_money += $row['lh_bet_money'];
                $sum_lh_yingkui += $row['lh_yingkui'];
                $sum_ss_num += $row['ss_num'];
                $sum_ss_bet_money += $row['ss_bet_money'];
                $sum_ss_yingkui += $row['ss_yingkui'];
                $sum_js_num += $row['js_num'];
                $sum_js_bet_money += $row['js_bet_money'];
                $sum_js_yingkui += $row['js_yingkui'];
                $sum_pt_num += $row['pt_num'];
                $sum_pt_bet_money += $row['pt_bet_money'];
                $sum_pt_yingkui += $row['pt_yingkui'];
                $sum_bet_money += $row['ty_bet_money'] + $row['lh_bet_money'] + $row['js_bet_money'] + $row['ss_bet_money'] + $row['pt_bet_money'];
                !isset($_USER_SUM[$row['top_uid']]) && $_USER_SUM[$row['top_uid']] = array(0, 0);
                $zr_bet_money = $_USER_SUM[$row['top_uid']][0];
                $zr_net_money = $_USER_SUM[$row['top_uid']][1];
                $zr_yingkui = $zr_bet_money - $zr_net_money;
                $sum_zr_bet_money += $zr_bet_money;
                $sum_zr_net_money += $zr_net_money;
                $sum_zr_yingkui += $zr_yingkui;
                $yingkui = $row['ty_yingkui'] + $row['lh_yingkui'] + $row['js_yingkui'] + $row['ss_yingkui'] + $row['pt_yingkui'] + $zr_yingkui;
                $sum_yingkui += $yingkui;
                $llyongjin = ((($row['ty_yingkui'] * $rate_ty) / 100) + (($row['lh_yingkui'] * $rate_lh) / 100) + (($row['js_yingkui'] * $rate_js) / 100) + (($row['ss_yingkui'] * $rate_ss) / 100) + (($row['pt_yingkui'] * $rate_pt) / 100) + (($zr_yingkui * $rate_zr) / 100));
                $yongjin = ($llyongjin - $arr_money[$row['top_uid']]);
                $yongjin = ($yongjin < 0 ? 0 : $yongjin);
                $sum_llyongjin += $llyongjin;
                $sum_yongjin += $yongjin;
                $sum_kouchu += $arr_money[$row['top_uid']];
                empty($row['username']) && $row['username'] = '<s>已删除</s>';
                ?>
                <tr align="center" onMouseOver="this.style.backgroundColor='<?= $over; ?>'"
                    onMouseOut="this.style.backgroundColor='<?= $out; ?>'" style="background-color:<?= $color; ?>;">
                    <td><?= $row['username']; ?></td>
                    <td><?= sprintf('%.2f', $row['ty_bet_money']); ?></td>
                    <td style="color:<?= $row['ty_yingkui'] >= 0 ? '#ff0000' : '#009900'; ?>"><?= sprintf('%.2f', $row['ty_yingkui']); ?></td>
                    <td><?= sprintf('%.2f', $row['lh_bet_money']); ?></td>
                    <td style="color:<?= $row['lh_yingkui'] >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $row['lh_yingkui']); ?></td>
                    <td><?= sprintf('%.2f', $row['js_bet_money']); ?></td>
                    <td style="color:<?= $row['js_yingkui'] >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $row['js_yingkui']); ?></td>
                    <td><?= sprintf('%.2f', $row['ss_bet_money']); ?></td>
                    <td style="color:<?= $row['ss_yingkui'] >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $row['ss_yingkui']); ?></td>
                    <td><?= sprintf('%.2f', $row['pt_bet_money']); ?></td>
                    <td style="color:<?= $row['pt_yingkui'] >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $row['pt_yingkui']); ?></td>
                    <td><?= sprintf('%.2f', $zr_bet_money); ?></td>
                    <td><?= sprintf('%.2f', $zr_net_money); ?></td>
                    <td style="color:<?= $zr_yingkui >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $zr_yingkui); ?></td>
                    <td><?= sprintf('%.2f', $row['ty_bet_money'] + $row['lh_bet_money'] + $row['ss_bet_money'] + $row['pt_bet_money'] + $zr_bet_money); ?></td>
                    <td style="color:<?= $yingkui >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $yingkui); ?></td>
                    <td style="color:<?= $llyongjin >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $llyongjin); ?></td>
                    <td style="color:<?= $arr_money[$row['top_uid']] >= 0 ? '#009900' : '#ff0000' ?>"><?= sprintf('%.2f', $arr_money[$row['top_uid']]); ?></td>
                    <td style="color:<?= $yongjin >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $yongjin); ?></td>
                </tr>
            <?php } ?>
            <tr align="center" style="background:#ffffff;color:#ff0000;">
                <td>合计</td>
                <td><?= sprintf('%.2f', $sum_ty_bet_money); ?></td>
                <td style="color:<?= $sum_ty_yingkui >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $sum_ty_yingkui); ?></td>
                <td><?= sprintf('%.2f', $sum_lh_bet_money); ?></td>
                <td style="color:<?= $sum_lh_yingkui >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $sum_lh_yingkui); ?></td>
                <td><?= sprintf('%.2f', $sum_js_bet_money); ?></td>
                <td style="color:<?= $sum_js_yingkui >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $sum_js_yingkui); ?></td>
                <td><?= sprintf('%.2f', $sum_ss_bet_money); ?></td>
                <td style="color:<?= $sum_ss_yingkui >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $sum_ss_yingkui); ?></td>
                <td><?= sprintf('%.2f', $sum_pt_bet_money); ?></td>
                <td style="color:<?= $sum_pt_yingkui >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $sum_pt_yingkui); ?></td>
                <td><?= sprintf('%.2f', $sum_zr_bet_money); ?></td>
                <td><?= sprintf('%.2f', $sum_zr_net_money); ?></td>
                <td style="color:<?= $sum_zr_yingkui >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $sum_zr_yingkui); ?></td>
                <td><?= sprintf('%.2f', $sum_bet_money); ?></td>
                <td style="color:<?= $sum_yingkui >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $sum_yingkui); ?></td>
                <td style="color:<?= $sum_llyongjin >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $sum_llyongjin); ?></td>
                <td style="color:<?= $sum_kouchu >= 0 ? '#009900' : '#ff0000' ?>"><?= sprintf('%.2f', $sum_kouchu); ?></td>
                <td style="color:<?= $sum_yongjin >= 0 ? '#ff0000' : '#009900' ?>"><?= sprintf('%.2f', $sum_yongjin); ?></td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="font12"
               style="margin-top:5px;line-height:20px;">
            <tr>
                <td>
                    <p>计算说明：</p>
                    <p>1、代理佣金=体育盈亏×体育比例+六合彩盈亏×六合彩比例+极速彩盈亏×极速彩比例+时时彩盈亏×时时彩比例+普通彩盈亏×普通彩比例+(下注-派彩)×真人比例-红利派送-手续费</p>
                    <p>2、如果按照①的公式计算结果小于0，则代理佣金为0</p>
                    <p>3、佣金比例可自行调整</p>
                    <p>4、如有特殊代理合作方式，可依据以上相关统计数据自行计算佣金</p>
                    <p>5、合作双方如有其它约定，不在本报表中体现</p>
                    <p style="color:#f00">6、真人下注非实时结果，需要等待系统生成报表后才能查询！</p>
                </td>
            </tr>
        </table>
    </div>
    </div>
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