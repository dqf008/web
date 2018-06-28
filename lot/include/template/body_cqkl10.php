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
    // var nav_str = 'gdkl10#tjkl10#hnkl10#sxkl10#ynkl10#ffkl10#sfkl10';
    var nav_str = 'gdkl10#cqkl10#tjkl10#hnkl10#sxkl10#ynkl10';
    var nav_arr;
    var html = '';
    var trans_arr = [];
    trans_arr['gdkl10'] = ['广东快乐10分', '/lot/?i=kl10&lottery_type=gdkl10'];
    trans_arr['cqkl10'] = ['重庆快乐10分', '/lot/?i=kl10&lottery_type=cqkl10'];
    trans_arr['tjkl10'] = ['天津快乐10分', '/lot/?i=kl10&lottery_type=tjkl10'];
    trans_arr['hnkl10'] = ['湖南快乐10分', '/lot/?i=kl10&lottery_type=hnkl10'];
    trans_arr['sxkl10'] = ['山西快乐10分', '/lot/?i=kl10&lottery_type=sxkl10'];
    trans_arr['ynkl10'] = ['云南快乐10分', '/lot/?i=kl10&lottery_type=ynkl10'];
    trans_arr['ffkl10'] = ['分分快乐10分', '/lot/?i=kl10&lottery_type=ffkl10'];
    trans_arr['sfkl10'] = ['三分快乐10分', '/lot/?i=kl10&lottery_type=sfkl10'];

    if (nav_str.indexOf('#')) {
        nav_arr = nav_str.split('#');
    } else {
        nav_arr = [nav_str];
    }
    for (var i in nav_arr) {
        html += "<span class='group_btn' id='nav_" + nav_arr[i] + "' onclick='window.location.href=\"" + trans_arr[nav_arr[i]][1] + "\";'>" + trans_arr[nav_arr[i]][0] + "</span>";

    }

    $('.group_wrap').append(html);
    $('#nav_cqkl10').addClass('group_active');
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
        <?php if ($LOT['more']) { ?>                    <span class="fr hide">
                        <a class="j-live" target="_blank" title="开奖直播" href="http://www.1392c.com/">开奖直播</a>&nbsp;
                        <a class="j-count" target="_blank" title="数据统计" href="http://www.1392c.com/">数据统计</a>
                    </span>
        <?php } ?> <span class="fl">玩法：</span>
        <ul class="play-category fl" id="play-tab">
            <li data-target="#j-sd" data-np="0" data-hits="yes"><a href="javascript:;">两面盘</a></li>
            <li data-target="#j-n1" data-np="1"><a href="javascript:;">第一球</a></li>
            <li data-target="#j-n2" data-np="2"><a href="javascript:;">第二球</a></li>
            <li data-target="#j-n3" data-np="3"><a href="javascript:;">第三球</a></li>
            <li data-target="#j-n4" data-np="4"><a href="javascript:;">第四球</a></li>
            <li data-target="#j-n5" data-np="5"><a href="javascript:;">第五球</a></li>
            <li data-target="#j-n6" data-np="6"><a href="javascript:;">第六球</a></li>
            <li data-target="#j-n7" data-np="7"><a href="javascript:;">第七球</a></li>
            <li data-target="#j-n8" data-np="8"><a href="javascript:;">第八球</a></li>
            <li data-target="#j-lh" data-np="0" data-hits="yes"><a href="javascript:;">总和</a></li>
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
                <span>期数<b class="box" id="current-issue">0期</b></span>
                <span>距离封盘<b class="box timer" id="close-timer">00:00</b></span>
                <span>距离开奖<b class="box timer" id="award-timer">00:00</b></span>
            </div>
            <div class="mt10">
                <div id="j-sd">
                    <table class="table nested-table">
                        <thead>
                        <tr>
                            <th colspan="7">总和</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php for ($i = 0; $i < 3; $i++) {
                                $k = ($i * 2) + 1; ?>
                                <td class="p0">
                                    <table class="j-betting">
                                        <thead class="hide">
                                        <tr>
                                            <th colspan="7">总和</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr data-id="<?php echo show_id(9, $k); ?>" data-odds="">
                                            <td class="table-odd"><?php echo $LOT['odds'][9][1][$k]; ?></td>
                                            <td><span class="odds-text"></span></td>
                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                        </tr>
                                        <tr data-id="<?php echo show_id(9, $k + 1); ?>" data-odds="">
                                            <td class="table-odd"><?php echo $LOT['odds'][9][1][$k + 1]; ?></td>
                                            <td><span class="odds-text"></span></td>
                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            <?php } ?>                                        </tr>
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <?php for ($i = 1; $i <= 8; $i++) { ?>
                            <table class="table fl wp-25 j-betting">
                                <thead>
                                <tr>
                                    <th colspan="3"><?php echo $LOT['odds'][$i][0]; ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php for ($j = 21; $j <= 28; $j++) { ?>
                                    <tr data-id="<?php echo show_id($i, $j); ?>" data-odds="">
                                        <td class="table-odd"><?php echo $LOT['odds'][$i][1][$j]; ?></td>
                                        <td><span class="odds-text"></span></td>
                                        <td class="j-odds"><input type="text" class="input fb"/></td>
                                    </tr>
                                <?php } ?>                                        </tbody>
                            </table>
                        <?php } ?>                                </div>
                </div>
                <?php for ($i = 1; $i <= 8; $i++) { ?>
                    <div id="j-n<?php echo $i; ?>" class="hide">
                        <input type="hidden" value="<?php echo $LOT['odds'][$i][0]; ?>" class="h-category"/>
                        <table class="table nested-table">
                            <tr>
                                <?php for ($j = 1; $j <= 4; $j++) { ?>
                                    <td class="p0">
                                        <table class="j-betting">
                                            <thead>
                                            <tr>
                                                <th>号</th>
                                                <th>赔率</th>
                                                <th class="j-odds">金额</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php for ($k = 0; $k < 9; $k++) {
                                                $l = $j + ($k * 4);
                                                if ($l < 36) { ?>
                                                    <tr data-id="<?php echo show_id($i, $l); ?>" data-odds="">
                                                        <td class="table-odd"><?php if ($k < 5) { ?><i
                                                                class="icon ball ball-<?php echo $LOT['odds'][$i][1][$l]; ?>"><?php echo $LOT['odds'][$i][1][$l]; ?></i><?php } else {
                                                                echo $LOT['odds'][$i][1][$l];
                                                            } ?></td>
                                                        <td><span class="odds-text"></span></td>
                                                        <td class="j-odds"><input type="text" class="input fb"/></td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td class="table-odd">&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td class="j-odds">&nbsp;</td>
                                                    </tr>
                                                <?php }
                                            } ?>                                                </tbody>
                                        </table>
                                    </td>
                                <?php } ?>                                    </tr>
                        </table>
                    </div>
                <?php } ?>
                <div id="j-lh" class="hide">
                    <input type="hidden" value="总和" class="h-category"/>
                    <table class="table nested-table">
                        <tr>
                            <?php for ($i = 0; $i < 3; $i++) {
                                $k = ($i * 2) + 1; ?>
                                <td class="p0">
                                    <table class="j-betting">
                                        <thead>
                                        <tr>
                                            <th>号</th>
                                            <th>赔率</th>
                                            <th class="j-odds">金额</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr data-id="<?php echo show_id(9, $k); ?>" data-odds="">
                                            <td class="table-odd"><?php echo $LOT['odds'][9][1][$k]; ?></td>
                                            <td><span class="odds-text"></span></td>
                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                        </tr>
                                        <tr data-id="<?php echo show_id(9, $k + 1); ?>" data-odds="">
                                            <td class="table-odd"><?php echo $LOT['odds'][9][1][$k + 1]; ?></td>
                                            <td><span class="odds-text"></span></td>
                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            <?php } ?>                                    </tr>
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
            <?php if ($LOT['more']){ ?>
            <div class="mt10 hide" id="trends"></div>
            <script id="tpl-hit-miss" type="text/html">
                <table class="table sm-ball-table">
                    <tr>
                        <td class="table-odd td-hd">今天</td>
                        <td><i class="icon sm-ball">1</i></td>
                        <td><i class="icon sm-ball">2</i></td>
                        <td><i class="icon sm-ball">3</i></td>
                        <td><i class="icon sm-ball">4</i></td>
                        <td><i class="icon sm-ball">5</i></td>
                        <td><i class="icon sm-ball">6</i></td>
                        <td><i class="icon sm-ball">7</i></td>
                        <td><i class="icon sm-ball">8</i></td>
                        <td><i class="icon sm-ball">9</i></td>
                        <td><i class="icon sm-ball">10</i></td>
                        <td><i class="icon sm-ball">11</i></td>
                        <td><i class="icon sm-ball">12</i></td>
                        <td><i class="icon sm-ball">13</i></td>
                        <td><i class="icon sm-ball">14</i></td>
                        <td><i class="icon sm-ball">15</i></td>
                        <td><i class="icon sm-ball">16</i></td>
                        <td><i class="icon sm-ball">17</i></td>
                        <td><i class="icon sm-ball">18</i></td>
                        <td><i class="icon sm-red-ball">19</i></td>
                        <td><i class="icon sm-red-ball">20</i></td>
                    </tr>
                    <tr>
                        <td class="table-odd td-hd ball-hit">出球率</td>
                        {{#hit}}
                        <td>{{.}}</td>
                        {{/hit}}
                    </tr>
                    <tr>
                        <td class="table-odd td-hd ball-miss">无出期数</td>
                        {{#miss}}
                        <td>{{.}}</td>
                        {{/miss}}
                    </tr>
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
                            {{#item}}
                            {{.}}<br/>
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
<script>require(['lot-index'], function (Lottery) {
        new Lottery({lotteryId: 'cqkl10'})
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
