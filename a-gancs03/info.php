<?php
include_once __DIR__.'/../include/config.php';
include_once __DIR__.'/../database/mysql.config.php';
include_once __DIR__.'/common/login_check.php';

if ($_GET['act'] == 'info') {
    $cache_file = '../cache/'.md5('admin_info').'.php';
    $time = time() - filemtime($cache_file);
    if($time<60){
        $data = file_get_contents($cache_file);
    }else{
        $data['bet_count'] = 0;
        $data['jr_bet_count'] = 0;
        $ymd = date('Y-m-d');
        $time = strtotime(date('Y-m-d'));
        $date = date('Y-m-d');
        $query = $mydata1_db->query('select count(1) from k_user');
        $data['hyzs'] = $query->fetchColumn();

        $stmt = $mydata1_db->query('select count(1) from k_user where `reg_date`>="' . $date . '"');
        $data['jrhy'] = $stmt->fetchColumn();

        $query = $mydata1_db->query('select count(*) from k_bet union select count(*) from k_bet_cg_group union select count(*) from lottery_data union select count(*) from c_bet union select count(*) from c_bet_3');
        foreach ($query as $v) {
            $data['bet_count'] += $v[0];
        }
        $sql = 'select count(*) as s from k_bet where `bet_time`>="' . $date . '" union all 
    select count(*) as s from k_bet_cg_group where `bet_time`>="' . $date . '" union all
    select count(*) as s from lottery_data where `bet_time`>="' . $date . '" union all
    select count(*) as s from c_bet where `addtime`>="' . $date . '" union all 
    select count(*) as s from c_bet_3 where `addtime`>="' . $date . '"';
        $query = $mydata1_db->query($sql);
        foreach ($query as $v) {
            $data['jr_bet_count'] += $v[0];
        }
        $query = $mydata1_db->query('select group_concat(uid) from k_user where `reg_date`>="' . $date . '"');
        $data['new_member_uids'] = $query->fetch()[0];

        $data['tixian_today'] = 0;
        $data['cunkuan_today'] = 0;
        $sql = 'select m_value,type from k_money where `status`=1 and (`type`=1 or `type`=2) and `m_make_time`>"' . $date . '"';
        $query = $mydata1_db->query($sql);
        while ($rows = $query->fetch()) {
            if ($rows['type'] == 2) {
                $data['tixian_today']++;
            }
            if ($rows['type'] == 1) {
                $data['cunkuan_today']++;
            }
        }

        $sql = 'select count(*) as s from huikuan where status=1 and `adddate`>="' . $date . '"';
        $data['huikuan_today'] = $mydata1_db->query($sql)->fetchColumn();

        $sql = 'select count(distinct(uid)) as cz_count from huikuan where `status`=1 and `adddate`>="' . $date . '"';
        $data['hk_count'] = $mydata1_db->query($sql)->fetchColumn();

        $sql = ' select group_concat(uid) from huikuan where `status`=1 and `adddate`>="' . $date . '"';
        $data['today_hk_member_uids'] = $mydata1_db->query($sql)->fetch()[0];


        $sql = 'select count(distinct(uid)) as cz_count from k_money where `status`=1 and `type` = 1 and m_make_time>="' . $date . '"';
        $data['cz_count'] = $mydata1_db->query($sql)->fetchColumn();;

        $sql = 'select group_concat(uid) from k_money where `status`=1 and `type` = 1 and m_make_time>="' . $date . '"';
        $data['today_cz_member_uids'] = $mydata1_db->query($sql)->fetch()[0];

        $sql = 'select group_concat(uid) from k_money where `status`=1 and `type` = 2 and m_make_time>="' . $date . '"';
        $data['today_tx_member_uids'] = $mydata1_db->query($sql)->fetch()[0];


        $sql = 'select count(distinct(uid)) as tx_count from k_money where `status`=1 and `type` = 2 and m_make_time>="' . $date . '"';
        $cz_query_count = $mydata1_db->query($sql);
        $tx_count = $cz_query_count->fetchColumn();
        $data['tx_count'] = $tx_count;

        $sql = 'select uid from k_money where `status`=1 and `type`=1 group by uid having min(m_make_time)>="' . $date . '" union  select uid from huikuan where `status`=1 group by uid having min(`adddate`)>="' . $date . '"';

        $new_cz_member_count = 0;
        $uid_str = '';
        $arr = [];
        foreach ($mydata1_db->query($sql) as $row) {
            $arr[] = $row['uid'];
        }
        $arr = array_unique($arr);
        $new_cz_member_count = count($arr);
        $data['new_cz_member_count'] = $new_cz_member_count;
        $uid_str = implode(',', $arr);
        $data['uid_str'] = $uid_str;
        $data = json_encode($data);
        file_put_contents($cache_file, $data);
    }
    die($data);
}
?>
<HTML>
<HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8"/>
    <TITLE>系统信息查看</TITLE>
    <meta http-equiv="Cache-Control" content="max-age=8640000"/>
    <link rel="stylesheet" href="Images/CssAdmin.css">
    <link rel="stylesheet" href="css/BreakingNews.css">
    <link rel="stylesheet" href="css/reveal.css">
    <style type="text/css">
        .demo {
            width: 900px;
            margin: 0 auto;
        }

        .demo2 {
            margin-top: 5px;
        }

        body {
            margin: 0 0 0 0;
        }

        .STYLE3 {
            color: #FF3300;
        }
    </STYLE>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/jquery.reveal.js"></script>
    <script src="js/BreakingNews.js"></script>
    <script>
        $(function () {
            $.getJSON('http://182.16.12.116/notice.php',function(res){
                if(res.status==0){
                    for(var i in res.data){
                        var li = res.data[i];
                        var num = Number(i)+1;
                        var $li = $("<li><a onclick='title_click($(this));'data-date='"+li.addtime+"' data-title='"+li.title+"' data-content='"+li.content+"' data-reveal-id='myModal' data-animation='none'>"+num+"."+li.title+"&nbsp;&nbsp;"+li.addtime+"</a></li>");
                        $('#abc').append($li);
                    }                    
                    $('#breakingnews2').BreakingNews({
                        title: '系统通知',
                        titlebgcolor: '#099',
                        linkhovercolor: '#099',
                        border: '1px solid #099',
                        timer: 4000,
                        effect: 'slide'
                    });
                    $('#notice').show();
                }else{
                    $('#notice').hide();
                }
            });
        });
    </script>
</HEAD>
<body id="app">
<table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr id="notice" style="display:none">
        <div class="demo demo2">
            <div class="BreakingNewsController easing" id="breakingnews2">
                <div class="bn-title" style="background-color: #099">系统通知</div>
                <ul id="abc"></ul>
                <div class="bn-arrows"><span class="bn-arrows-left"></span><span class="bn-arrows-right"></span>
                </div>
            </div>
        </div>
        <br/>
    </tr>
    <tr>
        <td height="24" nowrap background="images/06.gif">
            <font>
                <img src="Images/Explain.gif" width="18" height="18" border="0" align="absmiddle">&nbsp;系统运行信息查看
            </font>
        </td>
    </tr>
</table>

<table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr>
        <td height="24" nowrap>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="17%" height="24" align="right">会员总数量：</td>
                    <td width="83%" id="hyzs">0 个</td>
                </tr>
                <tr>
                    <td height="24" align="right">今日新增会员数量：</td>
                    <td style="color:#0000FF;">
                        <a id="jrhy">0 个</a>
                    </td>
                </tr>
                <tr>
                    <td height="24" align="right">今日新增充值会员数量：</td>
                    <td style="color:#0000FF;">
                        <a id="new_cz_member_count">0 个</a>
                    </td>
                </tr>
                <tr>
                    <td height="24" align="right">注单总数量：</td>
                    <td style="color:#0000FF;" id="bet_count">0</td>
                </tr>
                <tr>
                    <td height="24" align="right">今日新增注单数量：</td>
                    <td style="color:#0000FF;" id="jr_bet_count">0</td>
                </tr>
                <tr>
                    <td height="24" align="right">今日提现笔数：</td>
                    <td id="tixian_today">0 笔</td>
                </tr>
                <tr>
                    <td height="24" align="right">今日提现会员数量：</td>
                    <td style="color:#0000FF;">
                        <a id="tx_count">0 个</a>
                    </td>
                </tr>
                <tr>
                    <td height="24" align="right">今日存款笔数：</td>
                    <td id="cunkuan_today">0 笔</td>
                </tr>
                <tr>
                    <td height="24" align="right">今日存款会员数量：</td>
                    <td style="color:#0000FF;">
                        <a id="cz_count">0 个</a>
                    </td>
                </tr>
                <tr>
                    <td height="24" align="right">今日汇款笔数：</td>
                    <td id="huikuan_today">0 笔</td>
                </tr>
                <tr>
                    <td height="24" align="right">今日汇款会员数量：</td>
                    <td><a id="hk_count">0 个</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="left">
                        <iframe src="zdfx.php" name="zdfxFrame" id="zdfxFrame" title="zdfxFrame" frameborder=0
                                width="49%" scrolling=no height=300></iframe>&nbsp;
                        <iframe src="login_user.php" name="luFrame" id="luFrame" title="luFrame" frameborder=0
                                width="49%" scrolling=no height=300></iframe>
                    </td>
                </tr>
                <tr>
                    <td height="24" colspan="2" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td height="24" align="right">操作：</td>
                    <td><a style="color:#FF0000" href="?  ">刷新监控</a></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div id="myModal" class="reveal-modal">
    <h3 align='center' style="margin-top=5px;color: #ff0000;"></h3>
    <p></p>
    <span style=""></span>
    <a class="close-reveal-modal">&#215;</a>
</div>
<script>
    function title_click(obj) {
        $(".reveal-modal h3").text(obj.attr('data-title'));
        $(".reveal-modal p").text(obj.attr('data-content'));
        $(".reveal-modal span").text(obj.attr('data-date'));
    }

    $(function () {
        $.getJSON("?act=info", function (res) {
                $('#hyzs').html(res.hyzs + ' 个');
                $('#jrhy').html(res.jrhy + ' 个');
                $('#jrhy').attr('href', 'hygl/list.php?uids=' + res.new_member_uids);
                $('#new_cz_member_count').html(res.new_cz_member_count + ' 个');
                $('#new_cz_member_count').attr('href', 'hygl/list.php?uids=' + res.uid_str);
                $('#bet_count').html(res.bet_count);
                $('#jr_bet_count').html(res.jr_bet_count);
                $('#tixian_today').html(res.tixian_today + ' 笔');
                $('#cunkuan_today').html(res.cunkuan_today + ' 笔');
                $('#huikuan_today').html(res.huikuan_today + ' 笔');

                $('#tx_count').html(res.tx_count + ' 个');
                $('#tx_count').attr('href', 'hygl/list.php?uids=' + res.today_tx_member_uids);
                $('#cz_count').html(res.cz_count + ' 个');
                $('#cz_count').attr('href', 'hygl/list.php?uids=' + res.today_cz_member_uids);
                $('#hk_count').html(res.hk_count + ' 个');
                $('#hk_count').attr('href', 'hygl/list.php?uids=' + res.today_hk_member_uids);
            }
        );
    });

</script>
</body>
</html>