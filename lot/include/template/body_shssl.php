<?php !defined('IN_LOT')&&die('Access Denied'); ?>
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
    var nav_str = 'shssl#pl3#3d';
    var nav_arr;
    var html = '';
    var trans_arr = [];
    trans_arr['shssl'] = ['上海时时乐', '/lot/?i=shssl'];
    trans_arr['pl3'] = ['排列三', '/lot/?i=pl3'];
    trans_arr['3d'] = ['福彩3D', '/lot/?i=3d'];

    if (nav_str.indexOf('#')) {
        nav_arr = nav_str.split('#');
    } else {
        nav_arr = [nav_str];
    }
    for (var i in nav_arr) {
        html += "<span class='group_btn' id='nav_" + nav_arr[i] + "' onclick='window.location.href=\"" + trans_arr[nav_arr[i]][1] + "\";'>" + trans_arr[nav_arr[i]][0] + "</span>";

    }
    $('.group_wrap').append(html);
    $('#nav_shssl').addClass('group_active');
</script>
            <div class="summary" id="summary">
                <i class="icon sound-on fr" title="声音开关"></i>
                <div class="summary-prev fr" id="pre-result">
                    <span class="fl mr6"><b id="prev-issue">0</b>期结果</span>
                    <div class="prev-list fl">
                        <span id="prev-bs">
                            <script type="text/html" id="tpl-prev-balls">
                                {{#balls}}
                                <i class="icon ball ball-{{.}}">{{.}}</i>
                                {{/balls}}
                            </script>
                        </span>
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
<?php if($LOT['more']){ ?>                    <span class="fr hide">
                        <a class="j-live" target="_blank" title="开奖直播" href="http://www.1392c.com/">开奖直播</a>&nbsp;
                        <a class="j-count" target="_blank" title="数据统计" href="http://www.1392c.com/">数据统计</a>
                    </span>
<?php } ?>                    <span class="fl">玩法：</span>
                    <ul class="play-category fl" id="play-tab">
                        <li data-target="#j-num" data-np="0" data-hits="yes"><a href="javascript:;">直选</a></li>
                        <li data-target="#j-all" data-np="0" data-hits="yes"><a href="javascript:;">整合</a></li>
                    </ul>
                </div>
                <div class="play-bd clearfix">
                    <div class="main-bd" id="parlay-ctn"<?php if(!$LOT['more']){ ?> style="width:100%"<?php } ?>>
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
                            <span>期数<b class="box" id="current-issue">0期</b></span>
                            <span>距离封盘<b class="box timer" id="close-timer">00:00</b></span>
                            <span>距离开奖<b class="box timer" id="award-timer">00:00</b></span>
                        </div>
                        <div class="mt10">
                            <div id="j-num">
                                <table class="table nested-table">
                                    <tbody>
                                        <tr>
<?php for($i=3;$i>0;$i--){ ?>                                            <td class="p0">
                                                <table class="j-betting">
                                                    <thead><tr><th colspan="3"><?php echo $LOT['odds'][$i][0][2]; ?>位</th></tr></thead>
                                                    <tbody>
<?php for($k=1;$k<=10;$k++){ ?>                                                        <tr data-id="<?php echo show_id($i, $k); ?>" data-odds="">
                                                            <td class="table-odd"><i class="icon ball"><?php echo $LOT['odds'][$i][1][$k]; ?></i></td>
                                                            <td><span class="odds-text"></span></td>
                                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                                        </tr>
<?php }for($k=1;$k<=4;$k++){ ?>                                                        <tr data-id="<?php echo show_id($i+3, $k); ?>" data-odds="">
                                                            <td class="table-odd"><?php echo $LOT['odds'][$i+3][1][$k]; ?></td>
                                                            <td><span class="odds-text"></span></td>
                                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                                        </tr>
<?php } ?>                                                    </tbody>
                                                </table>
                                            </td>
<?php } ?>                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="j-all" class="hide">
                                <table class="table nested-table mb10">
                                    <thead><tr><th colspan="5">跨度</th></tr></thead>
                                    <tbody>
                                        <tr>
<?php for($i=1;$i<=5;$i++){ ?>                                            <td class="p0">
                                                <table class="j-betting">
                                                    <thead><tr><th colspan="3" class="hide">跨度</th></tr></thead>
                                                    <tbody>
<?php for($k=0;$k<2;$k++){ ?>                                                        <tr data-id="<?php echo show_id(9, $i+($k*5)); ?>" data-odds="">
                                                            <td class="table-odd"><?php echo $LOT['odds'][9][1][$i+($k*5)]; ?></td>
                                                            <td><span class="odds-text"></span></td>
                                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                                        </tr>
<?php } ?>                                                    </tbody>
                                                </table>
                                            </td>
<?php } ?>                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table nested-table mb10">
                                    <thead><tr><th colspan="4">和值</th></tr></thead>
                                    <tbody>
                                        <tr>
<?php for($i=1;$i<=4;$i++){ ?>                                            <td class="p0">
                                                <table class="j-betting">
                                                    <thead><tr><th colspan="3" class="hide">和值</th></tr></thead>
                                                    <tbody>
<?php for($k=0;$k<8;$k++){ ?>                                                        <tr data-id="<?php echo show_id(8, $i+($k*4)); ?>" data-odds="">
                                                            <td class="table-odd"><?php echo $LOT['odds'][8][1][$i+($k*4)]; ?></td>
                                                            <td><span class="odds-text"></span></td>
                                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                                        </tr>
<?php } ?>                                                    </tbody>
                                                </table>
                                            </td>
<?php } ?>                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table nested-table">
                                    <thead><tr><th>区域</th></tr></thead>
                                    <tbody>
                                        <tr>
                                            <td class="p0">
                                                <table class="j-betting">
                                                    <thead><tr><th colspan="3" class="hide">区域</th></tr></thead>
                                                    <tbody>
<?php for($i=1;$i<=7;$i++){ ?>                                                        <tr data-id="<?php echo show_id(7, $i); ?>" data-odds="">
                                                            <td class="table-odd" style="width:150px"><?php echo $LOT['odds'][7][1][$i]; ?></td>
                                                            <td><span class="odds-text"></span></td>
                                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                                        </tr>
<?php } ?>                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
                            <form class="form normal-form hide tac" action="">
                                <button class="button parlay bet-button" data-action="parlay">下注</button>
                                <button class="button button-secondary bet-button" data-action="reset" type="reset">重置</button>
                            </form>
                        </div>
<?php if($LOT['more']){ ?>                        <div class="mt10 hide" id="trends"></div>
                        <script id="tpl-hit-miss" type="text/html"></script>
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
                                            {{#item}}
                                            {{.}}<br />
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
                        <div class="amount  need-auth">
                            <div class="available-amount box">
                                <span>可用金额</span>
                                <b id="j-balance">0.00</b>
                            </div>
                            <div class="betting-amount box">
                                <span>即时下注</span>
                                <!-- <a href="javascript:void(0)" data-href="/home/notCount" class="odfi" title="即时注单"><b id="j-orders">0.00</b></a> -->
                                <b id="j-orders">0.00</b>
                            </div>
                        </div>
                        <div class="aside-top">
                            <table class="table" id="changelong">
                                <thead><tr><th colspan="2">两面长龙排行</th></tr></thead>
                                <tbody></tbody>
                            </table>
                        </div>
<?php } ?>                    </div>
                </div>
            </div>
            <script>require(['3d-index'], function(Lottery){new Lottery({lotteryId: 'shssl', timerTpl: '{{minutes}}:{{seconds}}'})});</script>
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
