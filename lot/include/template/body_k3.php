<?php !defined('IN_LOT') && die('Access Denied'); ?>

<script type="text/html" id="tpl-prev-data">
    {{#prevdata}}
    <!-- <span>{{.}}</span> -->
    <i class="icon ball ball">{{.}}</i>
    {{/prevdata}}
</script>
<script type="text/javascript" src="../../../js/jquery.js"></script>
<style>
    .group_wrap {
        width: 100%;
        height: 34px;
        background-color: rgb(240, 237, 231);
    }

    .group_btn {
        font-size: 14px;
        width: 50px;
        height: 26px;
        display: inline-block;
        margin: 3px 0 0 3px;
        text-align: center;
        line-height: 28px;
    }

    .group_btn:hover {
        cursor: pointer;
        background-color: #a69b91;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }

    .group_active {
        background-color: #a69b91;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }
</style>
<div class="group_wrap"></div>
<script>
    // var nav_str = 'jsk3#fjk3#gxk3#ahk3#shk3#hbk3#hebk3#ffk3#sfk3#jlk3#hnk3#gzk3#bjk3#qhk3#gsk3#nmgk3#jxk3';
    var nav_str = 'jsk3#fjk3#gxk3#ahk3#shk3#hbk3#hebk3#jlk3#gzk3#bjk3#gsk3#nmgk3#jxk3#ffk3#sfk3#wfk3';
    var nav_arr;
    var html = '';
    var trans_arr = [];
    trans_arr['jsk3'] = ['江苏快3', '/lot/?i=k3&lottery_type=jsk3'];
    trans_arr['ahk3'] = ['安徽快3', '/lot/?i=k3&lottery_type=ahk3'];
    trans_arr['gxk3'] = ['广西快3', '/lot/?i=k3&lottery_type=gxk3'];
    trans_arr['shk3'] = ['上海快3', '/lot/?i=k3&lottery_type=shk3'];
    trans_arr['hbk3'] = ['湖北快3', '/lot/?i=k3&lottery_type=hbk3'];
    trans_arr['hebk3'] = ['河北快3', '/lot/?i=k3&lottery_type=hebk3'];
    trans_arr['fjk3'] = ['福建快3', '/lot/?i=k3&lottery_type=fjk3'];
    trans_arr['jxk3'] = ['江西快3', '/lot/?i=k3&lottery_type=jxk3'];
    trans_arr['nmgk3'] = ['内蒙快3', '/lot/?i=k3&lottery_type=nmgk3'];
    trans_arr['gsk3'] = ['甘肃快3', '/lot/?i=k3&lottery_type=gsk3'];
    trans_arr['bjk3'] = ['北京快3', '/lot/?i=k3&lottery_type=bjk3'];
    trans_arr['qhk3'] = ['青海快3', '/lot/?i=k3&lottery_type=qhk3'];
    trans_arr['hnk3'] = ['河南快3', '/lot/?i=k3&lottery_type=hnk3'];
    trans_arr['jlk3'] = ['吉林快3', '/lot/?i=k3&lottery_type=jlk3'];
    trans_arr['gzk3'] = ['贵州快3', '/lot/?i=k3&lottery_type=gzk3'];
    trans_arr['ffk3'] = ['分分快3', '/lot/?i=k3&lottery_type=ffk3'];
    trans_arr['sfk3'] = ['超级快3', '/lot/?i=k3&lottery_type=sfk3'];
    trans_arr['wfk3'] = ['好运快3', '/lot/?i=k3&lottery_type=wfk3'];

    if (nav_str.indexOf('#')) {
        nav_arr = nav_str.split('#');
    } else {
        nav_arr = [nav_str];
    }
    for (var i in nav_arr) {
        html += "<span class='group_btn' id='nav_" + nav_arr[i] + "' onclick='window.location.href=\"" + trans_arr[nav_arr[i]][1] + "\";'>" + trans_arr[nav_arr[i]][0] + "</span>";

    }

    var activeTab = <?php echo "'" . $LOT['lottery_type'] . "'" ?>;
    if (!activeTab) {
        activeTab = 'jsk3';
    }
    $('.group_wrap').append(html);

    $('#nav_' + activeTab).addClass('group_active');
</script>
<style>
    #gameBet {
        background: #eee;
        border-top: none;
    }

    .gameBet_balls {
        width: 99%;
        border-radius: 5px;
        background: #fff;
        float: left;
        padding-bottom: 20px;
    }

    .gameBet_openlists {
        width: 245px;
        border-radius: 5px;
        background: #fff;
        float: right;
    }

    .gameBet_left {
        width: 99%;
        /*padding: 10px;*/
        height: auto;
        overflow: hidden;
        float: left;
    }

    .gameBet_right {
        width: 245px;
        float: right;
        height: auto;
        overflow: hidden;
        border-left: 1px solid #ddd;
        min-height: 500px;
    }

    .play_select_prompt {
        width: 96%;
        margin: 0px auto;
        height: auto;
        overflow: hidden;
        line-height: 30px;
        text-align: center;
    }

    .iconfont {
        font-family: "iconfont" !important;
        font-size: 16px;
        font-style: normal;
        -webkit-font-smoothing: antialiased;
        -webkit-text-stroke-width: 0.2px;
        -moz-osx-font-smoothing: grayscale;
    }

    .c_org {
        color: #f69101;
    }

    .g_Number_Section {
        width: 666px;
        height: auto;
        min-height: 50px;
        margin: 0px auto;
        overflow: hidden;
        background: url(../../../lot/static/styles/images/betBg.png) repeat;
        border-radius: 6px;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .g_Number_Section .gn_main {
        width: 100%;
        height: auto;
        overflow: hidden;
    }

    .g_Number_Section .gn_main .gn_main_cont {
        width: 100%;
        height: auto;
        overflow: hidden;
    }

    .gn_main_cont {
        width: 100%;
        height: auto;
        overflow: hidden;
    }

    .g_Panel_Section {
        width: 666px;
        margin: 0px auto;
        height: auto;
        overflow: hidden;
        text-align: center;
    }

    .g_Panel_Section .choice_cound {
        font-size: 16px;
        padding: 10px 0px;
    }

    .g_Panel_Section .choice_cound i {
        color: #ff9726;
        font-weight: bold;
        padding: 0 5px;
    }

    .g_Panel_Section .choice_comfire {
        width: 100%;
        height: 40px;
        text-align: center;
        margin: 5px auto 15px auto;
    }

    .g_Panel_Section .choice_comfire a.choice_comfire_btn {
        width: 160px;
        background: #d21e1e;
        color: #fff;
        display: block;
        margin: 0px auto;
        border-radius: 3px;
        height: 40px;
        line-height: 40px;
        font-size: 18px;
    }

    .g_Panel_Section .choice_comfire a.choice_comfire_btn:hover {
        background: #D64747
    }

    .g_Order_Section {
        width: 666px;
        height: 170px;
        overflow-x: hidden;
        overflow-y: auto;
        margin: 10px auto;
        border: 1px solid #ddd;
        padding: 5px;
    }

    .g_Order_Section table {
        width: 100%;
        height: auto;
        overflow: hidden;
    }

    .g_Order_Section table td {
        width: auto;
        height: 25px;
        line-height: 25px;
        overflow: hidden;
        font-size: 12px;
        background: #f4f4f4;
        padding: 1px 5px;
        border-radius: 2px;
        color: #666;
        cursor: pointer;
        border-bottom: 2px solid #fff;
    }

    .g_Order_Section table tr:hover td {
        background: #fffba6
    }

    .g_Order_Section table td .order_type {
        width: auto;
        min-width: 120px;
        text-indent: 10px;
        float: left;
    }

    .g_Order_Section table td .order_infos {
        width: 70px;
        text-align: left;
        text-indent: 10px;
    }

    .g_Order_Section table td .order_price {
        width: 130px;
        text-align: left;
        text-indent: 0px;
        overflow: hidden;
        float: left;
    }

    .g_Order_Section table td .order_zhushu {
        width: 80px;
        text-align: left;
        text-indent: 0px;
        overflow: hidden;
        float: left;
    }

    .g_Order_Section table td .c_3 {
        width: 170px;
        text-align: left;
        text-indent: 0px;
        overflow: hidden;
        float: left;
    }

    .g_Order_Section table td .each_price {
        width: 70px;
        height: 25px; /*padding:4px 5px;*/
        border: 1px solid #ddd;
        margin: 0px 3px;
    }

    .g_Order_Section table td .hide_this {
        display: none;
    }

    .g_Order_Section table td .l_cancel {
        cursor: pointer;
    }

    .g_Chase_Section {
        width: 666px;
        margin: 0px auto;
        height: 30px;
        line-height: 30px;
        text-align: center;
        padding-bottom: 15px;
    }

    .sub_betting_number {
        width: 320px;
        height: auto;
        overflow: hidden;
        margin: 25px auto 0;
    }

    .sub_betting_number .sub_orders {
        width: 158px;
        height: 38px;
        line-height: 38px;
        text-align: center;
        font-size: 18px;
        background: #d21e1e;
        color: #fff;
        overflow: hidden;
        display: inline-block;
        margin: 0px auto;
        clear: both;
        border-radius: 3px;
    }

    .sub_betting_number .login_ts {
        width: 158px;
        padding: 0px 0px;
        text-align: center;
        margin: 10px auto;
        height: 30px;
        line-height: 30px;
        display: block;
        border: 1px solid #ffbe7a;
        background: #fffced;
    }

    .sub_betting_number .sub_orders:hover {
        background: #D64747;
    }

    .gn_main_list .li_ball {
        width: 100%;
        height: auto;
        padding: 10px 0px;
    }

    .gn_main_list .li_ball .ball_cont {
        width: 110%;
        height: auto;
        overflow: hidden;
    }

    .gn_main_list .li_ball .ball_cont li {
        float: left;
        margin: 14px 12px 10px 11px;
        display: inline;
        color: #000;
        width: 60px;
        min-height: 52px;
        text-align: center;
    }

    .gn_main_list .li_ball .ball_cont li .ball_number {
        background: url(../../../lot/static/styles/images/tz_numb_bg.jpg) no-repeat center;
        color: #000;
        font-size: 20px;
        font-family: "微软雅黑";
        height: 52px;
        width: 52px;
        line-height: 52px;
        cursor: pointer;
        text-align: center;
        display: block;
        margin: 0px auto;
    }

    .gn_main_list .li_ball .ball_cont li .ball_number:hover,
    .gn_main_list .li_ball .ball_cont li .ball_number.Checked,
    .gn_main_list .li_ball .ball_cont li .ball_number.curr {
        background: url(../../../lot/static/styles/images/tz_numb_bg2.jpg) no-repeat center #D21E1F;
        color: #fff;
    }

    .gn_main_list .li_ball .ball_cont li .ball_number#slhtx_btn:hover,
    .gn_main_list .li_ball .ball_cont li .ball_number#slhtx_btn.curr {
        background: #D21E1F !important;
        color: #fff;
    }
    .gn_main_list .li_ball .ball_cont li .ball_number#sthtx_btn:hover,
    .gn_main_list .li_ball .ball_cont li .ball_number#sthtx_btn.curr {
        background: #D21E1F !important;
        color: #fff;
    }
    .gn_main_list .li_ball .ball_cont li .ball_aid {
        width: 100%;
        text-align: left;
        text-indent: 10px;
    }

    .ball_list_ul {
        width: 100%;
        margin: auto;
        display: flex;
        -weikit-display: flex;
        -moz-display: flex;
        align-items: flex-start;
        flex-wrap: wrap;
        -webkit-flex-wrap: wrap;
        padding: 0;
        margin: 0;
        text-align: center;
        list-style: none;
    }

    .ball_list_ul .ball_item {
        width: auto;
        float: left;
        height: auto;
    }

    .ball_list_ul .ball_item a {
        border: 1px solid #ddd;
        width: 100%;
        height: 43px;
        padding: 5px 0px;
        margin: 2px 5px;
        background: #fff;
        color: #333;
        border: 1px solid #ddd;
        box-shadow: 2px 2px 2px #ddd;
        border-radius: 5px;
        float: left;
        text-align: center;
    }

    .ball_list_ul .ball_item a b {
        display: block;
        width: 100%;
        height: 22px;
        line-height: 22px;
        font-size: 16px;
        color: #666;
    }

    .ball_list_ul .ball_item a p {
        display: block;
        padding: 0px 2px;
        word-break: break-all;
        text-overflow: ellipsis;
        height: 16px;
        line-height: 16px;
        font-size: 10px;
        overflow: hidden;
        color: #999;
    }

    .ball_list_ul .ball_item a.curr {
        background: #e43939;
        color: #fff;
    }

    .ball_list_ul .ball_item a.curr b {
        color: #fff;
    }

    .ball_list_ul .ball_item a.curr p {
        color: #fff;
    }
    .right_infsoBlock{ width:100%; height:auto; overflow:hidden; }
    .right_infsoBlock .title{ width:100%; padding:0px 4%; height:46px; line-height:46px; overflow:hidden; border-bottom:1px solid #ddd; }
    .right_infsoBlock .title .fl{ font-size:12px;color:#fff;padding:0 6px;margin-top:10px; background:#455467;border-radius: 3px;display:inline-block;height:26px;line-height:26px; }
    .right_infsoBlock .title .icofont{ background:url(../images/jbei.jpg) no-repeat center; width:25px; height:35px; float:left; }
    .right_infsoBlock .block_container{ width:100%; height:auto;}
    .right_infsoBlock .block_container table{ width:100%; height:auto; overflow:hidden; }
    .right_infsoBlock .block_container table th{ padding:0px; border-bottom:1px solid #ddd; height:30px; line-height:30px; font-weight:normal; overflow:hidden; color:#333; background:#f2f4f7;text-align:center; }
    .right_infsoBlock .block_container table td{ text-align:center; height:24px; line-height:24px; padding:2px 0px; font-size:12px; overflow:hidden; border-bottom:1px dashed #ebebeb;border-right:1px dashed #ebebeb;  }
    .right_infsoBlock .block_container td em{ width:auto; padding:2px 3px; margin:0px 2px; border-radius:3px; }
    .right_infsoBlock .block_container td em.da{ background:#666ef5; color:#fff; }
    .right_infsoBlock .block_container td em.xiao{ background:#c5b900; color:#fff; }
    .right_infsoBlock .block_container td em.dan{ background:#d24f7e; color:#fff; }
    .right_infsoBlock .block_container td em.shuang{ background:#89c85f; color:#fff; }
    .right_infsoBlock .block_container tr:hover td{ background:#f5f5f5; }
    /*.fl{ float:left; }*/
    /*.fr{ float:right; }*/
</style>
<div class="summary" id="summary">
    <i class="icon sound-on fr" title="声音开关"></i>
    <div class="summary-prev fr" id="pre-result">
        <span class="fl mr6"><b id="prev-issue">0</b>期结果</span>
        <div class="prev-list fl">
                        <span id="prev-bs">
                            <script type="text/html" id="tpl-prev-balls">
                                {{#balls}}
                                <i class="icon ball ball">{{.}}</i>
                                {{/balls}}
                            </script>
                        </span>
            <div class="prev-data" id="prev-data" style="display: block"></div>
        </div>
    </div>
    <span class="button-secondary-group">
                    <button class="button button-left button-current" data-mode="quick">快捷</button>
<!--                    <button class="button button-right button-blank" data-mode="normal">一般</button>-->
                </span>
    <span class="notify"><span id="marquee" width="370" height="48" style="display:none"></span></span>
</div>
<div id="play" class="play">
    <div class="play-hd clearfix">
        <?php if ($LOT['more']) { ?>                    <span class="fr hide">
                        <a class="j-live" target="_blank" title="开奖直播" href="http://www.1392c.com/">开奖直播</a>&nbsp;
                        <a class="j-count" target="_blank" title="数据统计" href="http://www.1392c.com/">数据统计</a>
                    </span>
        <?php } ?> <span class="fl">玩法：</span>
        <ul class="play-category fl" id="play-tab">
            <li data-target="#j-num" data-np="0" lottery_code="HZ" data-hits="yes"><a href="javascript:;">和值</a></li>
            <li data-target="#j-501" data-np="1" lottery_code="3THTX" data-hits="yes"><a href="javascript:;">三同号通选</a></li>
            <li data-target="#j-502" data-np="2" lottery_code="3THDX" data-hits="yes"><a href="javascript:;">三同号单选</a></li>
            <li data-target="#j-401" data-np="3" lottery_code="3BTH" data-hits="yes"><a href="javascript:;">三不同号</a></li>
            <li data-target="#j-402" data-np="4" lottery_code="3LHDX" data-hits="yes"><a href="javascript:;">三连号单选</a></li>
            <li data-target="#j-403" data-np="5" lottery_code="3LHTX" data-hits="yes"><a href="javascript:;">三连号通选</a></li>
            <li data-target="#j-301" data-np="6" lottery_code="2THFX" data-hits="yes"><a href="javascript:;">二同号复选</a></li>
            <li data-target="#j-302" data-np="7" lottery_code="2THDX" data-hits="yes"><a href="javascript:;">二同号单选</a></li>
            <li data-target="#j-201" data-np="8" lottery_code="2BTH" data-hits="yes"><a href="javascript:;">二不同号</a></li>
        </ul>
    </div>
    <div class="play-bd clearfix">
        <div class="main-bd" id="parlay-ctn"<?php if (!$LOT['more']) { ?> style="width:100%"<?php } ?>>
            <div class="clearfix top-bar">
                <span class="need-auth">今天输赢<b id="win-lose">0.00</b></span>
                <span>当前采种<b class="box" id="current-lottery"><?php if (isset($LOT['lottery_name'])) {
                            echo $LOT['lottery_name'];
                        } else {
                            echo "江苏快3";
                        } ?></b></span>
                <span style="display: none" id="current-lottery-type"><?php if (isset($LOT['lottery_type'])) {
                        echo $LOT['lottery_type'];
                    } else {
                        echo "jsk3";
                    } ?></span>
                <span>期数<b class="box" id="current-issue">0期</b></span>
                <span>距离封盘<b class="box timer" id="close-timer">00:00</b></span>
                <span>距离开奖<b class="box timer" id="award-timer">00:00</b></span>
            </div>
            <div class="mt10">
                <div id="j-num">
                <div id="gameBet" class="cl">
                    <div class="gameBet_balls">
                        <div class="gameBet_left l">
                            <!--玩法详细说明区域-->
                            <div class="play_select_prompt">
                                <i class="iconfont c_org"></i>
                                <span class="data-odds" data-id="">投注说明：至少选择1个和值投注，选号与开奖的三个号码相加的数值一致即中奖。奖金1.90-180倍</span>
                            </div>
                            <!--玩法详细说明区域-->

                            <!--玩法详细说明区域-->
                            <div class="g_Number_Section" id="Game_CheckBall">
                                <!--选号主区域-->
                                <div class="gn_main">
                                    <div class="gn_main_cont">

                                    </div>
                                </div>
                                <!--选号主区域-->
                            </div>
                            <!--玩法详细说明区域-->

                            <!--选号统计 开始-->
                            <div class="g_Panel_Section">
                                <div class="choice_cound" style="display:none">您选择了<i id="choice_zhu">0</i>注</div>
                                <div class="choice_comfire">
                                    <a href="javascript:void(0)" class="choice_comfire_btn" id="choice_comfire_btn">添加到投注列表</a>
                                </div>
                                <!--选号统计 结束-->

                                <!--玩法选号列表-->
                                <div class="g_Order_Section">
                                    <table id="order_table" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <!--玩法选号列表-->

                                <!--选号统计-->
                                <div class="g_Chase_Section">
                                    <div class="chase_Program">

                                    </div>
                                </div>
                                <!--选号统计-->

                                <!--玩法按钮-->
                                <div class="sub_betting_number">
                                    <a href="javascript:void(0)" class="sub_orders" id="f_submit_order">立即投注</a>
                                    <a href="javascript:void(0)" class="sub_orders empty_orders">清空单号</a>
<!--                                    <a href="javascript:void(0)" class="sub_orders" data-action="parlay">立即投注</a>-->
<!--                                    <a href="javascript:void(0)" class="sub_orders empty_orders">清空单号</a>-->

<!--                                    <button class="button parlay bet-button" data-action="test-aa">立即投注</button>-->
<!--                                    <button class="button button-secondary bet-button" data-action="reset" type="reset">清空单号</button>-->
                                </div>
                                <!--玩法按钮-->

                            </div>
                            <!--选号区域左侧-->
                        </div>
                    </div>
                </div>
                </div>

            </div>
            <?php if ($LOT['more']){ ?>
<!--            <div class="mt10" id="trends"></div>-->
            <script id="tpl-hit-miss" type="text/html"></script>
        </div>
        <div class="aside">
            <div class="amount  need-auth">
                <div class="available-amount box">
                    <span>可用金额</span>
                    <b id="j-balance">0.00</b>
                </div>
                <div class="betting-amount box">
                    <span>即时下注</span>
                    <b id="j-orders">0.00</b>
                </div>
            </div>

            <?php } ?>
        </div>
    </div>
</div>
<?php include (IN_LOT . 'include/template/k3.php'); ?>
<script>require(['k3-index'], function (Lottery) {
        var lotteryType = $("#current-lottery-type").text();
        if (!lotteryType) {
            lotteryType = 'jsk3';
        }
        new Lottery({lotteryId: lotteryType, timerTpl: '{{minutes}}:{{seconds}}'})
    });</script>

<div id="j-confirm-tpl" class="hide ">
    <div class="confirm-parlay">
        <h3>共计：{{currency}}<em>{{total}}</em>/<em>{{sum}}</em>注，您确定要下注吗？</h3>
        <ul class="{{col}}">
            {{#items}}
            <li><span>{{category}}【{{name}}】</span>@{{odds}} X {{amount}}</li>
            {{/items}}
        </ul>
    </div>
</div>
<script type="text/javascript" src="../../../lot/static/scripts/k3.js"></script>
