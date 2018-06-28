<?php

include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('bbgl');
if (intval($_GET['action']) != 1){
    if (!isset($_GET['s_time']) || ($_GET['s_time'] == '')){
        $_GET['s_time'] = date('Y-m-d', time());
    }
}
$gameTypes= array(
    '体育单式'=>'体育单式',
    '体育串关'=>'体育串关',
    '六合彩'=>'六合彩',
    'JSLH'=>'极速六合',
    '北京赛车PK拾'=>'北京赛车PK拾',
    '幸运飞艇'=>'幸运飞艇',
    'kl8'=>'北京快乐8',
    'pcdd'=>'PC蛋蛋',
    'ssl'=>'上海时时乐',
    '3d'=>'福彩3D',
    'pl3'=>'排列三',
    'qxc'=>'七星彩',
    'JSSC'=>'极速时时彩',
    '重庆时时彩'=>'重庆时时彩',
    '天津时时彩'=>'天津时时彩',
    '新疆时时彩'=>'新疆时时彩',
    '广东快乐10分'=>'广东快乐10分',
    '重庆快乐10分'=>'重庆快乐10分',
    '天津快乐10分'=>'天津快乐10分',
    '湖南快乐10分'=>'湖南快乐10分',
    '山西快乐10分'=>'山西快乐10分',
    '云南快乐10分'=>'云南快乐10分',
    'GDSYXW'=>'广东11选5',
    'SDSYXW'=>'山东11选5',
    'FJSYXW'=>'福建11选5',
    'BJSYXW'=>'北京11选5',
    'AHSYXW'=>'安徽11选5',
    'jsk3'=>'江苏快3',
    'fjk3'=>'福建快3',
    'gxk3'=>'广西快3',
    'ahk3'=>'安徽快3',
    'shk3'=>'上海快3',
    'hbk3'=>'湖北快3',
    'hebk3'=>'河北快3',
    'jlk3'=>'吉林快3',
    'gzk3'=>'贵州快3',
    'bjk3'=>'北京快3',
    'gsk3'=>'甘肃快3',
    'nmgk3'=>'内蒙古快3',
    'jxk3'=>'江西快3',
    'FFK3'=>'分分快3',
    'SFK3'=>'超级快3',
    'WFK3'=>'好运快3',
);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Welcome</title>
    <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" />
</head>
<script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script>
<script language="JavaScript" src="/js/calendar.js"></script>
<body>
<div id="pageMain">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td valign="top">
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                    <form name="form1" method="get" action="allorder.php">
                        <tr>
                            <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;
                                <select name="caizhong" id="caizhong">
                                    <option value="" <?=$_GET['caizhong']=='' ? 'selected' : ''?>>全部</option>
                                    <?php foreach ($gameTypes as $key=>$value){ ?>
                                        <option value=<?php echo $key; ?> <?=$_GET['caizhong']==$value ? 'selected' : ''?>><?php echo $value ?></option>
                                    <?php }?>
                                </select>
                                &nbsp;&nbsp;会员：<input name="username" type="text" id="username" value="<?=$_GET['username']?>" size="15">
                                &nbsp;&nbsp;日期：
                                <input name="s_time" type="text" id="s_time" value="<?=$_GET['s_time']?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />
                                ~
                                <input name="e_time" type="text" id="e_time" value="<?=$_GET['e_time']?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />&nbsp;&nbsp;
                                <input name="action" id="action" type="hidden" value="1">
                                <input type="submit" name="Submit" value="搜索"></td>
                        </tr>
                    </form>
                </table>
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
                    <tr style="background-color:#3C4D82;color:#FFF">
                        <td align="center" rowspan="2"><strong>账号</strong></td>
                        <td align="center" rowspan="2"><strong>彩种</strong></td>
                        <td align="center" colspan="4"><strong>已结算</strong></td>
                        <td height="25" align="center" colspan="3"><strong>未结算</strong></td>
                        <td align="center" colspan="2"><strong>合计(已结算+未结算)</strong></td>
                    </tr>
                    <tr style="background-color:#3C4D82;color:#FFF">
                        <td align="center"><strong>注单数</strong></td>
                        <td align="center"><strong>下注</strong></td>
                        <td align="center"><strong>结果</strong></td>
                        <td align="center"><strong>盈亏</strong></td>
                        <td align="center"><strong>注单数</strong></td>
                        <td align="center"><strong>下注</strong></td>
                        <td height="25" align="center"><strong>可赢</strong></td>
                        <td align="center"><strong>注单数</strong></td>
                        <td align="center"><strong>下注</strong></td>
                    </tr>
                    <?php
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != '')){
                        $_GET['e_time'] = $_GET['e_time'] . ' 23:59:59';
                    }
                    $params = array();
                    $sql = 'select ';
                    $sql .= '    b.username, ';
                    $sql .= '    b.caizhong, ';
                    $sql .= '    b.detailurl, ';
                    $sql .= '    sum(if(b.status=\'ok\',b.cou,0)) as ok_cou, ';
                    $sql .= '    sum(if(b.status=\'ok\',b.bet_money,0)) as ok_bet_money, ';
                    $sql .= '    sum(if(b.status=\'ok\',b.win,0)) as ok_win, ';
                    $sql .= '    sum(if(b.status=\'ok\',b.bet_win,0)) as ok_bet_win, ';
                    $sql .= '    sum(if(b.status=\'no\',b.cou,0)) as no_cou, ';
                    $sql .= '    sum(if(b.status=\'no\',b.bet_money,0)) as no_bet_money, ';
                    $sql .= '    sum(if(b.status=\'no\',b.win,0)) as no_win, ';
                    $sql .= '    sum(if(b.status=\'no\',b.bet_win,0)) as no_bet_win ';
                    $sql .= 'from ( ';
                    $sql .= '    select ';
                    $sql .= '        a.username, ';
                    $sql .= '        \'体育单式\' as caizhong, ';
                    $sql .= '        \'../zdgl/list.php?status=0\' as detailurl, ';
                    $sql .= '        \'ok\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.bet_money) as bet_money, ';
                    $sql .= '        sum(b.win+b.fs) as win, ';
                    $sql .= '        sum(b.bet_win+b.fs) as bet_win ';
                    $sql .= '    from k_bet b, k_user a ';
                    $sql .= '    where b.uid=a.uid ';
                    $sql .= '    and b.lose_ok=1 ';
                    $sql .= '    and b.status in (1,2,3,4,5,6,7,8) ';
                    if (isset($_GET['username']) && ($_GET['username'] != '')){
                        $params[':username'] = $_GET['username'];
                        $sql .= ' and a.username=:username ';
                    }

                    if (isset($_GET['s_time']) && ($_GET['s_time'] != '')){
                        $params[':s_time'] = $_GET['s_time'];
                        $sql .= ' and b.bet_time>=:s_time ';
                    }

                    if (isset($_GET['e_time']) && ($_GET['e_time'] != '')){
                        $params[':e_time'] = $_GET['e_time'];
                        $sql .= ' and b.bet_time<=:e_time ';
                    }

                    $sql .= '    group by b.uid ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        a.username, ';
                    $sql .= '        \'体育单式\' as caizhong, ';
                    $sql .= '        \'../zdgl/list.php?status=0\' as detailurl, ';
                    $sql .= '        \'no\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.bet_money) as bet_money, ';
                    $sql .= '        sum(b.win+b.fs) as win, ';
                    $sql .= '        sum(b.bet_win+b.fs) as bet_win ';
                    $sql .= '    from k_bet b, k_user a ';
                    $sql .= '    where b.uid=a.uid ';
                    $sql .= '    and b.lose_ok=1 ';
                    $sql .= '    and b.status=0 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username2'] = $_GET['username'];
                        $sql .= ' and a.username=:username2 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time2'] = $_GET['s_time'];
                        $sql .= ' and b.bet_time>=:s_time2 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time2'] = $_GET['e_time'];
                        $sql .= ' and b.bet_time<=:e_time2 ';
                    }
                    $sql .= '    group by b.uid ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        a.username, ';
                    $sql .= '        \'体育串关\' as caizhong, ';
                    $sql .= '        \'../zdgl/cg_result.php?status=0\' as detailurl, ';
                    $sql .= '        \'ok\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.bet_money) as bet_money, ';
                    $sql .= '        sum(b.win+b.fs) as win, ';
                    $sql .= '        sum(b.bet_win+b.fs) as bet_win ';
                    $sql .= '    from k_bet_cg_group b, k_user a ';
                    $sql .= '    where b.uid=a.uid ';
                    $sql .= '    and b.gid>0 ';
                    $sql .= '    and b.status in (1,3,4) ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username3'] = $_GET['username'];
                        $sql .= ' and a.username=:username3 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time3'] = $_GET['s_time'];
                        $sql .= ' and b.bet_time>=:s_time3 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time3'] = $_GET['e_time'];
                        $sql .= ' and b.bet_time<=:e_time3 ';
                    }
                    $sql .= '    group by b.uid ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        a.username, ';
                    $sql .= '        \'体育串关\' as caizhong, ';
                    $sql .= '        \'../zdgl/cg_result.php?status=0\' as detailurl, ';
                    $sql .= '        \'no\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.bet_money) as bet_money, ';
                    $sql .= '        sum(b.win+b.fs) as win, ';
                    $sql .= '        sum(b.bet_win+b.fs) as bet_win ';
                    $sql .= '    from k_bet_cg_group b, k_user a ';
                    $sql .= '    where b.uid=a.uid ';
                    $sql .= '    and b.gid>0 ';
                    $sql .= '    and b.status in(0,2) ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username4'] = $_GET['username'];
                        $sql .= ' and a.username=:username4 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time4'] = $_GET['s_time'];
                        $sql .= ' and b.bet_time>=:s_time4 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time4'] = $_GET['e_time'];
                        $sql .= ' and b.bet_time<=:e_time4 ';
                    }
                    $sql .= '    group by b.uid ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        b.username, ';
                    $sql .= '        b.atype as caizhong, ';
                    $sql .= '        \'../cpgl/jszd.php\' as detailurl, ';
                    $sql .= '        \'ok\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.money) as bet_money, ';
                    $sql .= '        sum(b.win+b.money) as win, ';
                    $sql .= '        sum(b.money*b.odds) as bet_win ';
                    $sql .= '    from lottery_data b ';
                    $sql .= '    where b.bet_ok=1 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username5'] = $_GET['username'];
                        $sql .= ' and b.username=:username5 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time5'] = $_GET['s_time'];
                        $sql .= ' and b.bet_time>=:s_time5 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time5'] = $_GET['e_time'];
                        $sql .= ' and b.bet_time<=:e_time5 ';
                    }
                    $sql .= '    group by b.username,b.atype ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        b.username, ';
                    $sql .= '        b.atype as caizhong, ';
                    $sql .= '        \'../cpgl/jszd.php\' as detailurl, ';
                    $sql .= '        \'no\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.money) as bet_money, ';
                    $sql .= '        0 as win, ';
                    $sql .= '        sum(b.win) as bet_win ';
                    $sql .= '    from lottery_data b ';
                    $sql .= '    where b.bet_ok=0 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username6'] = $_GET['username'];
                        $sql .= ' and b.username=:username6 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time6'] = $_GET['s_time'];
                        $sql .= ' and b.bet_time>=:s_time6 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time6'] = $_GET['e_time'];
                        $sql .= ' and b.bet_time<=:e_time6 ';
                    }
                    $sql .= '    group by b.username,b.atype ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        b.username, ';
                    $sql .= '        b.type as caizhong, ';
                    $sql .= '        \'../Lottery/Order.php?js=0\' as detailurl, ';
                    $sql .= '        \'ok\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.money) as bet_money, ';
                    $sql .= '        sum(case when b.win<0 then 0 when b.win=0 then b.money else b.win end) as win, ';
                    $sql .= '        sum(b.money*b.odds) as bet_win ';
                    $sql .= '    from c_bet b ';
                    $sql .= '    where b.js=1 ';
                    $sql .= '    and b.money>0 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username7'] = $_GET['username'];
                        $sql .= ' and b.username=:username7 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time7'] = $_GET['s_time'];
                        $sql .= ' and b.addtime>=:s_time7 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time7'] = $_GET['e_time'];
                        $sql .= ' and b.addtime<=:e_time7 ';
                    }
                    $sql .= '    group by b.username,b.type ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        b.username, ';
                    $sql .= '        b.type as caizhong, ';
                    $sql .= '        \'../Lottery/Order.php?js=0\' as detailurl, ';
                    $sql .= '        \'no\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.money) as bet_money, ';
                    $sql .= '        0 as win, ';
                    $sql .= '        sum(b.win) as bet_win ';
                    $sql .= '    from c_bet b ';
                    $sql .= '    where b.js=0 ';
                    $sql .= '    and b.money>0 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username8'] = $_GET['username'];
                        $sql .= ' and b.username=:username8 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time8'] = $_GET['s_time'];
                        $sql .= ' and b.addtime>=:s_time8 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time8'] = $_GET['e_time'];
                        $sql .= ' and b.addtime<=:e_time8 ';
                    }

                    $sql .= '    group by b.username,b.type ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        b.username, ';
                    $sql .= '        b.type as caizhong, ';
                    $sql .= '        \'../Lottery/Order3.php?js=0\' as detailurl, ';
                    $sql .= '        \'ok\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.money) as bet_money, ';
                    $sql .= '        sum(case when b.win<0 then 0 when b.win=0 then b.money else b.win end) as win, ';
                    $sql .= '        sum(b.money*b.odds) as bet_win ';
                    $sql .= '    from c_bet_3 b ';
                    $sql .= '    where b.js=1 ';
                    $sql .= '    and b.money>0 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username9'] = $_GET['username'];
                        $sql .= ' and b.username=:username9 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time9'] = $_GET['s_time'];
                        $sql .= ' and b.addtime>=:s_time9 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time9'] = $_GET['e_time'];
                        $sql .= ' and b.addtime<=:e_time9 ';
                    }
                    $sql .= '    group by b.username,b.type ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        b.username, ';
                    $sql .= '        b.type as caizhong, ';
                    $sql .= '        \'../Lottery/Order3.php?js=0\' as detailurl, ';
                    $sql .= '        \'no\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.money) as bet_money, ';
                    $sql .= '        0 as win, ';
                    $sql .= '        sum(b.win) as bet_win ';
                    $sql .= '    from c_bet_3 b ';
                    $sql .= '    where b.js=0 ';
                    $sql .= '    and b.money>0 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username10'] = $_GET['username'];
                        $sql .= ' and b.username=:username10 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time10'] = $_GET['s_time'];
                        $sql .= ' and b.addtime>=:s_time10 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time10'] = $_GET['e_time'];
                        $sql .= ' and b.addtime<=:e_time10 ';
                    }
                    $sql .= '    group by b.username,b.type ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        b.username, ';
                    $sql .= '        b.type as caizhong, ';
                    $sql .= '        \'../Lottery/Order.php?js=0\' as detailurl, ';
                    $sql .= '        \'ok\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.money) as bet_money, ';
                    $sql .= '        sum(case when b.win<0 then 0 when b.win=0 then b.money else b.win end) as win, ';
                    $sql .= '        sum(b.money*b.odds) as bet_win ';
                    $sql .= '    from c_bet_choose5 b ';
                    $sql .= '    where b.js=1 ';
                    $sql .= '    and b.money>0 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username15'] = $_GET['username'];
                        $sql .= ' and b.username=:username15 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time15'] = $_GET['s_time'];
                        $sql .= ' and b.addtime>=:s_time15 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time15'] = $_GET['e_time'];
                        $sql .= ' and b.addtime<=:e_time15 ';
                    }
                    $sql .= '    group by b.username,b.type ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        b.username, ';
                    $sql .= '        b.type as caizhong, ';
                    $sql .= '        \'../Lottery/Order.php?js=0\' as detailurl, ';
                    $sql .= '        \'no\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.money) as bet_money, ';
                    $sql .= '        0 as win, ';
                    $sql .= '        sum(b.win) as bet_win ';
                    $sql .= '    from c_bet_choose5 b ';
                    $sql .= '    where b.js=0 ';
                    $sql .= '    and b.money>0 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username16'] = $_GET['username'];
                        $sql .= ' and b.username=:username16 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time16'] = $_GET['s_time'];
                        $sql .= ' and b.addtime>=:s_time16 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time16'] = $_GET['e_time'];
                        $sql .= ' and b.addtime<=:e_time16 ';
                    }
                    $sql .= '    group by b.username,b.type ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        b.username, ';
                    $sql .= '        \'六合彩\' as caizhong, ';
                    $sql .= '        \'../lotto/index.php\' as detailurl, ';
                    $sql .= '        \'ok\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.sum_m) as bet_money, ';
                    $sql .= '        sum(case b.bm when 1 then b.sum_m*b.rate+b.sum_m*b.user_ds/100 when 2 then b.sum_m else b.sum_m*b.user_ds/100 end) as win, ';
                    $sql .= '        sum(b.sum_m*b.rate+b.sum_m*b.user_ds/100) as bet_win ';
                    $sql .= '    from mydata2_db.ka_tan b ';
                    $sql .= '    where b.checked=1 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username11'] = $_GET['username'];
                        $sql .= ' and b.username=:username11 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':cn_s_time11'] = date('Y-m-d H:i:s', strtotime($_GET['s_time']) + (12 * 3600));
                        $sql .= ' and b.adddate>=:cn_s_time11 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':cn_e_time11'] = date('Y-m-d H:i:s', strtotime($_GET['e_time']) + (12 * 3600));
                        $sql .= ' and b.adddate<=:cn_e_time11 ';
                    }
                    $sql .= '    group by b.username ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        b.username, ';
                    $sql .= '        \'六合彩\' as caizhong, ';
                    $sql .= '        \'../lotto/index.php\' as detailurl, ';
                    $sql .= '        \'no\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.sum_m) as bet_money, ';
                    $sql .= '        0 as win, ';
                    $sql .= '        sum(b.sum_m*b.rate+b.sum_m*b.user_ds/100) as bet_win ';
                    $sql .= '    from mydata2_db.ka_tan b ';
                    $sql .= '    where b.checked=0 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username12'] = $_GET['username'];
                        $sql .= ' and b.username=:username12 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':cn_s_time12'] = date('Y-m-d H:i:s', strtotime($_GET['s_time']) + (12 * 3600));
                        $sql .= ' and b.adddate>=:cn_s_time12 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':cn_e_time12'] = date('Y-m-d H:i:s', strtotime($_GET['e_time']) + (12 * 3600));
                        $sql .= ' and b.adddate<=:cn_e_time12 ';
                    }
                    $sql .= '    group by b.username ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        u.username, ';
                    $sql .= '        b.type as caizhong, ';
                    $sql .= '        \'../Lottery/Order3.php?js=0\' as detailurl, ';
                    $sql .= '        \'ok\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.money/100) as bet_money, ';
                    $sql .= '        sum(case when b.win<0 then 0 else b.win/100 end) as win, ';
                    $sql .= '        sum(0) as bet_win ';
                    $sql .= '    from c_bet_data b left join k_user u on u.uid=b.uid';
                    $sql .= '    where b.status=1 ';
                    $sql .= '    and b.money>0 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username13'] = $_GET['username'];
                        $sql .= ' and u.username=:username13 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time13'] = strtotime($_GET['s_time']);
                        $sql .= ' and b.addtime>=:s_time13 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time13'] = strtotime($_GET['e_time']);
                        $sql .= ' and b.addtime<=:e_time13 ';
                    }
                    $sql .= '    group by u.username,b.type ';
                    $sql .= '    union all ';
                    $sql .= '    select ';
                    $sql .= '        u.username, ';
                    $sql .= '        b.type as caizhong, ';
                    $sql .= '        \'../Lottery/Order3.php?js=0\' as detailurl, ';
                    $sql .= '        \'no\' as status, ';
                    $sql .= '        count(1) as cou, ';
                    $sql .= '        sum(b.money/100) as bet_money, ';
                    $sql .= '        sum(0) as win, ';
                    $sql .= '        sum(b.win/100) as bet_win ';
                    $sql .= '    from c_bet_data b left join k_user u on u.uid=b.uid';
                    $sql .= '    where b.status=0 ';
                    $sql .= '    and b.money>0 ';
                    if (isset($_GET['username']) && ($_GET['username'] != ''))
                    {
                        $params[':username14'] = $_GET['username'];
                        $sql .= ' and u.username=:username14 ';
                    }
                    if (isset($_GET['s_time']) && ($_GET['s_time'] != ''))
                    {
                        $params[':s_time14'] = strtotime($_GET['s_time']);
                        $sql .= ' and b.addtime>=:s_time14 ';
                    }
                    if (isset($_GET['e_time']) && ($_GET['e_time'] != ''))
                    {
                        $params[':e_time14'] = strtotime($_GET['e_time']);
                        $sql .= ' and b.addtime<=:e_time14 ';
                    }

                    $sql .= '    group by u.username,b.type ';
                    $sql .= '    ) as b ';
                    $sql .= '    where 1=1 ';
                    if (isset($_GET['caizhong']) && ($_GET['caizhong'] != ''))
                    {
                        $params[':caizhong'] = $_GET['caizhong'];
                        $sql .= ' and b.caizhong=:caizhong ';
                    }
                    $sql .= 'group by b.username,b.caizhong order by b.username,b.caizhong ';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $all_ok_sum_cou = 0;
                    $all_no_sum_cou = 0;
                    $all_ok_sum_bet_money = 0;
                    $all_no_sum_bet_money = 0;
                    $all_ok_sum_win = 0;
                    $all_ok_sum_bet_win = 0;
                    $all_no_sum_bet_win = 0;
                    $ok_sum_cou = 0;
                    $no_sum_cou = 0;
                    $ok_sum_bet_money = 0;
                    $no_sum_bet_money = 0;
                    $ok_sum_win = 0;
                    $ok_sum_bet_win = 0;
                    $no_sum_bet_win = 0;
                    $username = '';
                    while ($rows = $stmt->fetch())
                    {
                        $color = '#FFFFFF';
                        $over = '#EBEBEB';
                        $out = '#ffffff';
                        $all_ok_sum_cou += $rows['ok_cou'];
                        $all_no_sum_cou += $rows['no_cou'];
                        $all_ok_sum_bet_money += $rows['ok_bet_money'];
                        $all_no_sum_bet_money += $rows['no_bet_money'];
                        $all_ok_sum_win += $rows['ok_win'];
                        $all_ok_sum_bet_win += $rows['ok_bet_win'];
                        $all_no_sum_bet_win += $rows['no_bet_win'];
                        switch ($rows['caizhong'])
                        {
                            case '3d': $caizhong = '福彩3D';
                                break;
                            case 'pl3': $caizhong = '排列三';
                                break;
                            case 'ssl': $caizhong = '上海时时乐';
                                break;
                            case 'kl8': $caizhong = '北京快乐8';
                                break;
                            case 'qxc': $caizhong = '七星彩';
                                break;
                            case 'JSSC': $caizhong = '极速赛车';
                                break;
                            case 'JSSSC': $caizhong = '极速时时彩';
                                break;
                            case 'JSLH': $caizhong = '极速六合';
                                break;
                            case 'pcdd': $caizhong ='PC蛋蛋';
                            break;
                            case 'fjk3': $caizhong ='福建快3';
                                break;
                            case 'jsk3': $caizhong ='江苏快3';
                                break;
                            case 'gxk3': $caizhong ='广西快3';
                                break;
                            case 'ahk3': $caizhong ='安徽快3';
                                break;
                            case 'shk3': $caizhong ='上海快3';
                                break;
                            case 'hbk3': $caizhong ='湖北快3';
                                break;
                            case 'hebk3': $caizhong ='河北快3';
                                break;
                            case 'jlk3': $caizhong ='吉林快3';
                                break;
                            case 'gzk3': $caizhong ='贵州快3';
                                break;
                            case 'bjk3': $caizhong ='北京快3';
                                break;
                            case 'gsk3': $caizhong ='甘肃快3';
                                break;
                            case 'nmgk3': $caizhong ='内蒙古快3';
                                break;
                            case 'jxk3': $caizhong ='江西快3';
                                break;
                            case 'FFK3': $caizhong ='分分快3';
                                break;
                            case 'SFK3': $caizhong ='超级快3';
                                break;
                            case 'WFK3': $caizhong ='好运快3';
                                break;
                            case 'GDSYXW':$caizhong='广东11选5';
                                break;
                            case 'SDSYXW':$caizhong='山东11选5';
                                break;
                            case 'FJSYXW':$caizhong='福建11选5';
                                break;
                            case 'BJSYXW':$caizhong='北京11选5';
                                break;
                            case 'AHSYXW':$caizhong='安徽11选5';
                                break;
                            default: $caizhong = $rows['caizhong'];
                        }
                        if ($username != $rows['username'])
                        {
                            if ($username != '')
                            {
                                ?>
                                <tr align="center" style="background-color:#D9E7F4;line-height:20px;">
                                    <td height="25" align="center" valign="middle"><?=$username;?></td>
                                    <td align="center" valign="middle">合计</td>
                                    <td align="center" valign="middle"><?=$ok_sum_cou;?></td>
                                    <td align="center" valign="middle"><?=sprintf('%.2f',$ok_sum_bet_money);?></td>
                                    <td align="center" valign="middle"><?=sprintf('%.2f',$ok_sum_win);?></td>
                                    <td align="center" valign="middle"><span style="color:<?=($ok_sum_bet_money)-($ok_sum_win)>0 ? '#FF0000' : '#009900'?>;"><?=sprintf("%.2f",($ok_sum_bet_money)-($ok_sum_win))?></span></td>
                                    <td align="center" valign="middle"><?=$no_sum_cou;?></td>
                                    <td align="center" valign="middle"><?=sprintf('%.2f',$no_sum_bet_money);?></td>
                                    <td align="center" valign="middle"><?=sprintf('%.2f',$no_sum_bet_win);?></td>
                                    <td align="center" valign="middle"><?=$ok_sum_cou + $no_sum_cou;?></td>
                                    <td align="center" valign="middle"><?=sprintf('%.2f',$ok_sum_bet_money + $no_sum_bet_money);?></td>
                                </tr>
                                <?php
                            }
                            $username = $rows['username'];
                            $ok_sum_cou = $rows['ok_cou'];
                            $no_sum_cou = $rows['no_cou'];
                            $ok_sum_bet_money = $rows['ok_bet_money'];
                            $no_sum_bet_money = $rows['no_bet_money'];
                            $ok_sum_win = $rows['ok_win'];
                            $ok_sum_bet_win = $rows['ok_bet_win'];
                            $no_sum_bet_win = $rows['no_bet_win'];
                        }else{
                            $ok_sum_cou += $rows['ok_cou'];
                            $no_sum_cou += $rows['no_cou'];
                            $ok_sum_bet_money += $rows['ok_bet_money'];
                            $no_sum_bet_money += $rows['no_bet_money'];
                            $ok_sum_win += $rows['ok_win'];
                            $ok_sum_bet_win += $rows['ok_bet_win'];
                            $no_sum_bet_win += $rows['no_bet_win'];
                        }
                        ?>
                        <tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;line-height:20px;">
                            <td height="25" align="center" valign="middle"><?=$rows['username'];?></td>
                            <td align="center" valign="middle"><?=$caizhong;?></td>
                            <td align="center" valign="middle"><?=$rows['ok_cou'];?></td>
                            <td align="center" valign="middle"><?=sprintf('%.2f',$rows['ok_bet_money']);?></td>
                            <td align="center" valign="middle"><?=sprintf('%.2f',$rows['ok_win']);?></td>
                            <td align="center" valign="middle"><span style="color:<?=$rows['ok_bet_money']-$rows['ok_win']>0 ? '#FF0000' : '#009900'?>;"><?=sprintf("%.2f",$rows['ok_bet_money']-$rows['ok_win'])?></span></td>
                            <td align="center" valign="middle"><?=$rows['no_cou'];?></td>
                            <td align="center" valign="middle"><?=sprintf('%.2f',$rows['no_bet_money']);?></td>
                            <td align="center" valign="middle"><?=sprintf('%.2f',$rows['no_bet_win']);?></td>
                            <td align="center" valign="middle"><?=$rows['ok_cou'] + $rows['no_cou'];?></td>
                            <td align="center" valign="middle"><?=sprintf('%.2f',$rows['ok_bet_money'] + $rows['no_bet_money']);?></td>
                        </tr>
                    <?php }?>
                    <tr align="center" style="background-color:#D9E7F4;line-height:20px;">
                        <td height="25" align="center" valign="middle"><?=$username;?></td>
                        <td align="center" valign="middle">合计</td>
                        <td align="center" valign="middle"><?=$ok_sum_cou;?></td>
                        <td align="center" valign="middle"><?=sprintf('%.2f',$ok_sum_bet_money);?></td>
                        <td align="center" valign="middle"><?=sprintf('%.2f',$ok_sum_win);?></td>
                        <td align="center" valign="middle"><span style="color:<?=($ok_sum_bet_money)-($ok_sum_win)>0 ? '#FF0000' : '#009900'?>;"><?=sprintf("%.2f",($ok_sum_bet_money)-($ok_sum_win))?></span></td>
                        <td align="center" valign="middle"><?=$no_sum_cou;?></td>
                        <td align="center" valign="middle"><?=sprintf('%.2f',$no_sum_bet_money);?></td>
                        <td align="center" valign="middle"><?=sprintf('%.2f',$no_sum_bet_win);?></td>
                        <td align="center" valign="middle"><?=$ok_sum_cou + $no_sum_cou;?></td>
                        <td align="center" valign="middle"><?=sprintf('%.2f',$ok_sum_bet_money + $no_sum_bet_money);?></td>
                    </tr>
                    <tr align="center" style="background-color:#ffffff;line-height:20px;font-weight: bold;">
                        <td height="25" align="center" valign="middle" colspan="2">总合计</td>
                        <td align="center" valign="middle"><?=$all_ok_sum_cou;?></td>
                        <td align="center" valign="middle"><?=sprintf('%.2f',$all_ok_sum_bet_money);?></td>
                        <td align="center" valign="middle"><?=sprintf('%.2f',$all_ok_sum_win);?></td>
                        <td align="center" valign="middle"><span style="color:<?=$all_ok_sum_bet_money - $all_ok_sum_win>=0 ? '#FF0000' : '#009900';?>;"><?=sprintf('%.2f',$all_ok_sum_bet_money - $all_ok_sum_win);?></span></td>
                        <td align="center" valign="middle"><?=$all_no_sum_cou;?></td>
                        <td align="center" valign="middle"><?=sprintf('%.2f',$all_no_sum_bet_money);?></td>
                        <td align="center" valign="middle"><?=sprintf('%.2f',$all_no_sum_bet_win);?></td>
                        <td align="center" valign="middle"><?=$all_ok_sum_cou + $all_no_sum_cou;?></td>
                        <td align="center" valign="middle"><?=sprintf('%.2f',$all_ok_sum_bet_money + $all_no_sum_bet_money);?></td>
                    </tr>
                </table></td>
        </tr>
    </table>
</div>
</body>
</html>