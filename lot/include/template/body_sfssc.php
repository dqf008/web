<?php !defined('IN_LOT') && die('Access Denied'); ?>
<script type="text/html" id="tpl-prev-data">
    {{#prevdata}}
    <span>{{.}}</span>
    {{/prevdata}}
</script>
<style>
    .group_wrap {
        width: 100%;
        height: 34px;
        background-color: rgb(240, 237, 231);
    }

    .group_btn {
        font-size: 15px;
        width: 100px;
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
    var nav_str = 'cqssc#tjssc#xjssc#jsssc#sfssc';
    var nav_arr;
    var html = '';
    var trans_arr = [];
    trans_arr['cqssc'] = ['重庆时时彩', '/lot/?i=cqssc'];
    trans_arr['tjssc'] = ['天津时时彩', '/lot/?i=tjssc'];
    trans_arr['xjssc'] = ['新疆时时彩', '/lot/?i=xjssc'];
    trans_arr['jsssc'] = ['极速时时彩', '/lot/?i=jsssc'];
    trans_arr['sfssc'] = ['三分时时彩', '/lot/?i=sfssc'];

    if (nav_str.indexOf('#')) {
        nav_arr = nav_str.split('#');
    } else {
        nav_arr = [nav_str];
    }
    for (var i in nav_arr) {
        html += "<span class='group_btn' id='nav_" + nav_arr[i] + "' onclick='window.location.href=\"" + trans_arr[nav_arr[i]][1] + "\";'>" + trans_arr[nav_arr[i]][0] + "</span>";

    }

    $('.group_wrap').append(html);
    $('#nav_sfssc').addClass('group_active');
</script>
<div class="summary" id="summary">
    <i class="icon sound-on fr" title="声音开关"></i>
    <div class="summary-prev fr" id="pre-result">
        <span class="fl mr6"><b id="prev-issue">0</b>期结果</span>
        <div class="prev-list fl">
            <span id="prev-bs"></span>
            <div class="prev-data" id="prev-data"></div>
        </div>
    </div>
    <span class="button-secondary-group">
                    <button class="button button-left button-current" data-mode="quick">快捷</button>
                    <button class="button button-right button-blank" data-mode="normal">一般</button>
                </span>
    <span class="notify"><span id="marquee" width="370" height="48" style="display:none"></span></span>
</div>
<div id="play" class="play">
    <div class="play-hd clearfix">
        <?php if ($LOT['more']) { ?>                    <span class="fr hide" data-id="shishicai">
                        <a class="j-live" target="_blank" title="开奖直播" href="http://www.1392c.com/">开奖直播</a>&nbsp;
                        <a class="j-count" target="_blank" title="数据统计" href="http://www.1392c.com/">数据统计</a>
                    </span>
        <?php } ?> <span class="fl">玩法：</span>
        <ul class="play-category fl" id="play-tab">
            <li data-target="#j-all" data-np="1">
                <a href="javascript:;">整合</a>
            </li>
            <li data-target="#j-sd" data-np="0" data-hits="yes">
                <a href="javascript:;">两面盘</a>
            </li>
        </ul>
    </div>
    <div class="play-bd clearfix">
        <div class="main-bd" id="parlay-ctn"<?php if (!$LOT['more']) { ?> style="width:100%"<?php } ?>>
            <div class="clearfix top-bar">
                <div class="fr">
                    <form class="form normal-form need-auth hide tac" action="">
                        <button class="button parlay bet-button" data-action="parlay">下注</button>
                        <button class="button button-secondary bet-button" data-action="reset" type="reset">重置</button>
                    </form>
                </div>
                <div class="fr removable">
                    <form class="form quick-form need-auth" action="">
                        <label>金额：<input type="text" class="input fb sync-bet"/></label>
                        <button class="button parlay bet-button" data-action="parlay">下注</button>
                        <button class="button button-secondary bet-button" data-action="reset" type="reset">重置</button>
                    </form>
                </div>
                <span class="need-auth">今天输赢<b id="win-lose">0.00</b></span>
                <span>当前采种<b class="box" id="current-lottery">三分时时彩</b></span>
                <span>期数<b class="box" id="current-issue">0期</b></span>
                <span>距离封盘<b class="box timer" id="close-timer">00:00</b></span>
                <span>距离开奖<b class="box timer" id="award-timer">00:00</b></span>
            </div>
            <div class="mt10">
                <div id="j-all">
                    <table class="table nested-table sm-table mb10">
                        <tr>
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <td class="p0" width="20%">
                                    <table class=" j-betting">
                                        <thead>
                                        <tr>
                                            <th colspan="3"><?php echo $LOT['odds'][$i][0]; ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php for ($j = 1; $j <= 14; $j++) { ?>
                                            <tr data-id="<?php echo show_id($i, $j); ?>" data-odds="">
                                                <td class="table-odd"><?php echo $j > 10 ? $LOT['odds'][$i][1][$j] : '<i class="icon ball">' . $LOT['odds'][$i][1][$j] . '</i>'; ?></td>
                                                <td><span class="odds-text"></span></td>
                                                <td class="j-odds"><input type="text" class="input fb"/></td>
                                            </tr>
                                        <?php } ?>                                                </tbody>
                                    </table>
                                </td>
                            <?php } ?>                                    </tr>
                    </table>
                    <table class="table nested-table sm-table">
                        <tr>
                            <?php for ($i = 7; $i <= 9; $i++) { ?>
                                <td class="p0" width="20%">
                                    <table class=" j-betting">
                                        <thead>
                                        <tr>
                                            <th colspan="3"><?php echo $LOT['odds'][$i][0]; ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php for ($j = 1; $j <= 5; $j++) { ?>
                                            <tr data-id="<?php echo show_id($i, $j); ?>" data-odds="">
                                                <td class="table-odd"><?php echo $LOT['odds'][$i][1][$j]; ?></td>
                                                <td><span class="odds-text"></span></td>
                                                <td class="j-odds"><input type="text" class="input fb"/></td>
                                            </tr>
                                        <?php } ?>                                                </tbody>
                                    </table>
                                </td>
                            <?php } ?>
                            <td class="p0" width="20%">
                                <table class=" j-betting">
                                    <thead>
                                    <tr>
                                        <th colspan="3">总和</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php for ($j = 1; $j <= 4; $j++) { ?>
                                        <tr data-id="<?php echo show_id(6, $j); ?>" data-odds="">
                                            <td class="table-odd"><?php echo $LOT['odds'][6][1][$j]; ?></td>
                                            <td><span class="odds-text"></span></td>
                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="table-odd">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="j-odds">&nbsp;</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="p0" width="20%">
                                <table class=" j-betting">
                                    <thead>
                                    <tr>
                                        <th colspan="3">龙虎斗</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php for ($j = 5; $j <= 7; $j++) { ?>
                                        <tr data-id="<?php echo show_id(6, $j); ?>" data-odds="">
                                            <td class="table-odd"><?php echo $LOT['odds'][6][1][$j]; ?></td>
                                            <td><span class="odds-text"></span></td>
                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="table-odd">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="j-odds">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="table-odd">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="j-odds">&nbsp;</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="j-sd" class="hide">
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <table class="table nested-table sm-table mb10">
                            <thead>
                            <tr>
                                <th colspan="4"><?php echo $LOT['odds'][$i][0]; ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php for ($j = 11; $j <= 14; $j++) { ?>
                                    <td class="p0">
                                        <table class="j-betting">
                                            <thead class="hide">
                                            <tr>
                                                <th colspan="4"><?php echo $LOT['odds'][$i][0]; ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr data-id="<?php echo show_id($i, $j); ?>" data-odds="">
                                                <td class="table-odd"><?php echo $LOT['odds'][$i][1][$j]; ?></td>
                                                <td><span class="odds-text"></span></td>
                                                <td class="j-odds"><input type="text" class="input fb"/></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                <?php } ?>                                        </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                    <table class="table nested-table sm-table mb10">
                        <thead>
                        <tr>
                            <th colspan="4">总和</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php for ($j = 1; $j <= 4; $j++) { ?>
                                <td class="p0">
                                    <table class="j-betting">
                                        <thead class="hide">
                                        <tr>
                                            <th colspan="4">总和</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr data-id="<?php echo show_id(6, $j); ?>" data-odds="">
                                            <td class="table-odd"><?php echo $LOT['odds'][6][1][$j]; ?></td>
                                            <td><span class="odds-text"></span></td>
                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            <?php } ?>                                        </tr>
                        </tbody>
                    </table>
                </div>
                <script type="text/html" id="tpl-prev-balls">
                    {{#balls}}
                    <i class="icon ball ball-{{.}}">{{.}}</i>
                    {{/balls}}
                </script>
            </div>
            <div class="selected-ball clearfix need-auth">
                <div class="fr">
                    <form class="form quick-form need-auth" action="">
                        <label>金额：<input type="text" class="input fb sync-bet"/></label>
                        <button class="button parlay bet-button" data-action="parlay">下注</button>
                        <button class="button button-secondary bet-button" data-action="reset" type="reset">重置</button>
                    </form>
                </div>
                <b id="j-selected-count">已选中<span class="j-selected-count">0</span>注</b>
                <form class="form normal-form need-auth hide tac" action="">
                    <button class="button parlay bet-button" data-action="parlay">下注</button>
                    <button class="button button-secondary bet-button" data-action="reset" type="reset">重置</button>
                </form>
            </div>
            <?php if ($LOT['more']){ ?>
            <div id="trends" class="play-tab tab mt10 hide" data-widget="tab"></div>
            <script id="tpl-trends" type="text/html">
                <table class="table nested-table secondary-table">
                    <thead>
                    <tr>
                        <td colspan="10" class="tab-hd">
                            {{#hd}}
                            <a href="javascript:;" class="tab-item active">{{.}}</a>
                            {{/hd}}
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    {{#bd}}
                    <tr class="tab-bd">
                        <td colspan="10" class="p0">
                            <table>
                                <tr>
                                    {{#number}}
                                    <td>{{.}}</td>
                                    {{/number}}
                                </tr>
                                <tr>
                                    {{#item}}
                                    <td>{{.}}</td>
                                    {{/item}}
                                </tr>
                            </table>
                        </td>
                    </tr>
                    {{/bd}}
                    </tbody>
                </table>
            </script>
            <div id="luzhu" class="play-tab tab mt10 hide" data-widget="tab"></div>
            <script id="tpl-luzhu" type="text/html">
                <table class="table secondary-table">
                    <thead>
                    <tr>
                        <td colspan="30" class="tab-hd">
                            {{#hd}}
                            <a href="javascript:;;" class="tab-item">{{.}}</a>
                            {{/hd}}
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    {{#bd}}
                    <tr class="tab-bd">
                        {{#items}}
                        <td>
                            {{#item}}{{.}}<br/>
                            {{/item}}
                        </td>
                        {{/items}}
                    </tr>
                    {{/bd}}
                    </tbody>
                </table>
            </script>
        </div>
        <div class="aside">
            <div class="amount need-auth">
                <div class="available-amount box">
                    <span>可用金额</span>
                    <b id="j-balance">0.00</b>
                </div>
                <div class="betting-amount box">
                    <span>即时下注</span>
                    <!-- <a href="javascript:;" data-href="" class="odfi" title="即时注单"><b id="j-orders">0.00</b></a> -->
                    <b id="j-orders">0.00</b>
                </div>
            </div>
            <div class="aside-top">
                <table class="table" id="changelong">
                    <thead>
                    <tr>
                        <th colspan="2">两面长龙排行</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <?php } ?>                    </div>
    </div>
</div>
<script>require(['ssc-index'], function (Lottery) {
        new Lottery({lotteryId: 'sfssc'})
    });</script>
<div id="j-confirm-tpl" class="hide">
    <div class="confirm-parlay">
        <h3>共计：{{currency}}<em>{{total}}</em>/<em>{{sum}}</em>注，您确定要下注吗？</h3>
        <ul class="{{col}}">
            {{#items}}
            <li><span>{{category}}【{{name}}】</span>@{{odds}} X {{amount}}</li>
            {{/items}}
        </ul>
    </div>
</div>
