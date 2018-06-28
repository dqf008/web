<?php !defined('IN_LOT')&&die('Access Denied'); ?>
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
    var nav_str = 'pk10#jssc#xyft';
    var nav_arr;
    var html = '';
    var trans_arr = [];
    trans_arr['pk10'] = ['北京赛车PK拾', '/lot/?i=pk10'];
    trans_arr['jssc'] = ['极速赛车', '/lot/?i=jssc'];
    trans_arr['xyft'] = ['幸运飞艇', '/lot/?i=xyft'];
    trans_arr['jsft'] = ['极速飞艇', '/lot/?i=jsft'];

    if (nav_str.indexOf('#')) {
        nav_arr = nav_str.split('#');
    } else {
        nav_arr = [nav_str];
    }
    for (var i in nav_arr) {
        html += "<span class='group_btn' id='nav_" + nav_arr[i] + "' onclick='window.location.href=\"" + trans_arr[nav_arr[i]][1] + "\";'>" + trans_arr[nav_arr[i]][0] + "</span>";

    }
    $('.group_wrap').append(html);
    $('#nav_pk10').addClass('group_active');
</script>
            <script type="text/html" id="tpl-prev-data">
                {{#prevdata}}
                <span>{{.}}</span>
                {{/prevdata}}
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
<?php if($LOT['more']){ ?>                    <span class="fr hide">
                        <a class="j-live" target="_blank" title="开奖直播" href="http://www.1392c.com/">开奖直播</a>&nbsp;
                        <a class="j-count" target="_blank" title="数据统计" href="http://www.1392c.com/">数据统计</a>
                    </span>
<?php } ?>                    <span class="fl">玩法：</span>
                    <ul class="play-category fl" id="play-tab">
                        <li data-target="#j-n1" data-np="0" data-hits="yes"><a href="javascript:;">两面盘</a></li>
                        <li data-target="#j-n2" data-np="0" data-hits="yes"><a href="javascript:;">冠亚、龙虎组合</a></li>
                        <li data-target="#j-n3" data-np="2" data-hits="yes" data-trends="yes"><a href="javascript:;">一、二、三、四、五名</a></li>
                        <li data-target="#j-n4" data-np="3" data-hits="yes" data-trends="yes"><a href="javascript:;">六、七、八、九、十名
                        </a></li>
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
                            <div id="j-n1">
                                <table class="table nested-table sm-table mb10">
                                    <thead><tr><th colspan="4"><?php echo $LOT['odds'][1][0]; ?></th></tr></thead>
                                    <tbody>
                                        <tr>
<?php for($i=18;$i<=21;$i++){ ?>                                            <td class="p0">
                                                <table class="j-betting">
                                                    <thead class="hide"><tr><th colspan="4"><?php echo $LOT['odds'][1][0]; ?></th></tr></thead>
                                                    <tbody>
                                                        <tr data-id="<?php echo show_id(1, $i); ?>" data-odds="">
                                                            <td class="table-odd"><?php echo $LOT['odds'][1][1][$i]; ?></td>
                                                            <td><span class="odds-text"></span></td>
                                                            <td class="j-odds"><input type="text" class="input fb"/></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
<?php } ?>                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table nested-table sm-table mb10">
                                    <tr>
<?php for($i=2;$i<=11;$i++){if($i==7){ ?>                                    </tr>
                                    <tr>
<?php } ?>                                        <td class="p0">
                                            <table class=" j-betting">
                                                <thead><tr><th colspan="3"><?php echo $LOT['odds'][$i][0]; ?></th></tr></thead>
                                                <tbody>
                                                    <tr data-id="<?php echo show_id($i, 11); ?>" data-odds="">
                                                        <td class="table-odd">大</td>
                                                        <td><span class="odds-text"></span></td>
                                                        <td class="j-odds"><input type="text" class="input fb"/></td>
                                                    </tr>
                                                    <tr data-id="<?php echo show_id($i, 12); ?>" data-odds="">
                                                        <td class="table-odd">小</td>
                                                        <td><span class="odds-text"></span></td>
                                                        <td class="j-odds"><input type="text" class="input fb"/></td>
                                                    </tr>
                                                    <tr data-id="<?php echo show_id($i, 13); ?>" data-odds="">
                                                        <td class="table-odd">单</td>
                                                        <td><span class="odds-text"></span></td>
                                                        <td class="j-odds"><input type="text" class="input fb"/></td>
                                                    </tr>
                                                    <tr data-id="<?php echo show_id($i, 14); ?>" data-odds="">
                                                        <td class="table-odd">双</td>
                                                        <td><span class="odds-text"></span></td>
                                                        <td class="j-odds"><input type="text" class="input fb"/></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
<?php } ?>                                    </tr>
                                </table>
                                <table class="table nested-table sm-table">
                                    <tr>
<?php
$temp_title = array(
    12 => '冠军 vs 第十',
    13 => '亚军 vs 第九',
    14 => '第三 vs 第八',
    15 => '第四 vs 第七',
    16 => '第五 vs 第六',
);
for($i=12;$i<=16;$i++){
?>                                        <td class="p0" width="20%">
                                            <table class=" j-betting">
                                                <thead><tr><th colspan="3"><?php echo $temp_title[$i]; ?></th></tr></thead>
                                                <tbody>
                                                    <tr data-id="<?php echo $i; ?>01" data-odds="">
                                                        <td class="table-odd">龙</td>
                                                        <td><span class="odds-text"></span></td>
                                                        <td class="j-odds"><input type="text" class="input fb"/></td>
                                                    </tr>
                                                    <tr data-id="<?php echo $i; ?>02" data-odds="">
                                                        <td class="table-odd">虎</td>
                                                        <td><span class="odds-text"></span></td>
                                                        <td class="j-odds"><input type="text" class="input fb"/></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
<?php } ?>                                    </tr>
                                </table>
                            </div>
                            <div id="j-n2" class="hide">
                                <table class="table nested-table mb10">
                                    <thead><tr><th colspan="4"><?php echo $LOT['odds'][1][0]; ?></th></tr></thead>
                                    <tbody>
                                        <tr>
<?php for($i=1;$i<=4;$i++){ ?>                                            <td class="p0">
                                                <table class="j-betting">
                                                    <thead class="hide"><tr><th colspan="3"><?php echo $LOT['odds'][1][0]; ?></th></tr></thead>
                                                    <tbody>
<?php for($j=0;$j<6;$j++){$key = 4*$j+$i;if($key>=18&&$key<=20){ ?>                                                        <tr>
                                                            <td class="table-odd">&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td class="j-odds">&nbsp;</td>
                                                        </tr>
<?php }else{$key>=21&&$key-= 3; ?>                                                        <tr data-id="<?php echo show_id(1, $key); ?>" data-odds="">
                                                            <td class="table-odd"><?php echo $LOT['odds'][1][1][$key]; ?></td>
                                                            <td><span class="odds-text"></span></td>
                                                            <td class="j-odds"><input type="text" class="input fb" /></td>
                                                        </tr>
<?php }} ?>                                                    </tbody>
                                                </table>
                                            </td>
<?php } ?>                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table nested-table sm-table">
                                    <tr>
<?php
$temp_title = array(
    12 => '冠军 vs 第十名',
    13 => '亚军 vs 第九名',
    14 => '第三名 vs 第八名',
    15 => '第四名 vs 第七名',
    16 => '第五名 vs 第六名',
);
for($i=12;$i<=16;$i++){
?>                                        <td class="p0" width="20%">
                                            <table class=" j-betting">
                                                <thead><tr><th colspan="3"><?php echo $temp_title[$i]; ?></th></tr></thead>
                                                <tbody>
                                                    <tr data-id="<?php echo $i; ?>01" data-odds="">
                                                        <td class="table-odd">龙</td>
                                                        <td><span class="odds-text"></span></td>
                                                        <td class="j-odds"><input type="text" class="input fb"/></td>
                                                    </tr>
                                                    <tr data-id="<?php echo $i; ?>02" data-odds="">
                                                        <td class="table-odd">虎</td>
                                                        <td><span class="odds-text"></span></td>
                                                        <td class="j-odds"><input type="text" class="input fb"/></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
<?php } ?>                                    </tr>
                                </table>
                            </div>
                            <div id="j-n3" class="hide">
                                <table class="table nested-table sm-table hide-icon-text">
                                    <tr>
<?php for($i=2;$i<=6;$i++){ ?>                                        <td class="p0">
                                            <table class=" j-betting">
                                                <thead><tr><th colspan="3"><?php echo $LOT['odds'][$i][0]; ?></th></tr></thead>
                                                <tbody>
<?php foreach($LOT['odds'][$i][1] as $key=>$val){ ?>                                                    <tr data-id="<?php echo show_id($i, $key); ?>" data-odds="">
                                                        <td class="table-odd"><?php if(is_numeric($val)){ ?><i class="icon bj<?php echo $val; ?>"><?php echo $val; ?></i><?php }else{ echo $val;} ?></td>
                                                        <td><span class="odds-text"></span></td>
                                                        <td class="j-odds"><input type="text" class="input fb"/></td>
                                                    </tr>
<?php } ?>                                                </tbody>
                                            </table>
                                        </td>
<?php } ?>                                    </tr>
                                </table>
                            </div>
                            <div id="j-n4" class="hide">
                                <table class="table nested-table sm-table hide-icon-text">
                                    <tr>
<?php for($i=7;$i<=11;$i++){ ?>                                        <td class="p0">
                                            <table class=" j-betting">
                                                <thead><tr><th colspan="3"><?php echo $LOT['odds'][$i][0]; ?></th></tr></thead>
                                                <tbody>
<?php foreach($LOT['odds'][$i][1] as $key=>$val){ ?>                                                    <tr data-id="<?php echo show_id($i, $key); ?>" data-odds="">
                                                        <td class="table-odd"><?php if(is_numeric($val)){ ?><i class="icon bj<?php echo $val; ?>"><?php echo $val; ?></i><?php }else{ echo $val;} ?></td>
                                                        <td><span class="odds-text"></span></td>
                                                        <td class="j-odds"><input type="text" class="input fb"/></td>
                                                    </tr>
<?php } ?>                                                </tbody>
                                            </table>
                                        </td>
<?php } ?>                                    </tr>
                                </table>
                            </div>
                            <script type="text/html" id="tpl-prev-balls">
                                <span class="hide-icon-text">
                                    {{#balls}}
                                    <i class="icon bj{{.}}">{{.}}</i>
                                    {{/balls}}
                                </span>
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
                            <form class="form normal-form hide tac" action="">
                                <button class="button parlay bet-button" data-action="parlay">下注</button>
                                <button class="button button-secondary bet-button" data-action="reset" type="reset">重置</button>
                            </form>
                        </div>
<?php if($LOT['more']){ ?>                        <div class="mt10 hide" id="trends"></div>
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
                                            <a href="javascript:;" class="tab-item">{{.}}</a>
                                            {{/hd}}
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{#bd}}
                                    <tr class="tab-bd">
                                        {{#items}}
                                        <td>{{#item}}{{.}}<br />{{/item}}</td>
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
                                <!-- <a href="javascript:;" data-href="/home/notCount" class="odfi" title="即时注单"><b id="j-orders">0.00</b></a> -->
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
            <script>require(['lot-index'], function(Lottery){new Lottery({lotteryId: "pk10"})});</script>
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
