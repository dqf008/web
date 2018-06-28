<?php !defined('IN_LOT')&&die('Access Denied'); ?>
<?php include(IN_LOT.'include/template/six/groupWrap.php'); ?>
            <div class="summary summary-hkc summary-sfhkc" id="summary">
                <i class="icon sound-on fr" title="声音开关"></i>
                <div class="summary-prev fr" id="pre-result">
                    <span class="fl mr6"><b id="prev-issue">0</b>期结果</span>
                    <span class="summary-prev-hkc" id="prev-bs"></span>
                </div>
                <span class="notify"><span id="marquee" width="370" height="31" style="display: none"></span></span>
            </div>
            <div id="play" class="play hkc sfhkc">
                <div class="play-hd clearfix">
                    <span class="fl">玩法：</span>
<?php include(IN_LOT.'include/template/six/nav.php'); ?>                </div>
                <div class="play-bd clearfix">
                    <div class="main-bd">
                        <div class="clearfix top-bar">
                            <span>今天输赢<b id="win-lose">0.00</b></span>
                            <span>期数<b class="box" id="current-issue">0期</b></span>
                            <span>距离封盘<b class="box timer close-timer" id="close-timer" data-timer="13">00:00</b></span>
                            <span>距离开奖<b class="box timer" id="award-timer">00:00</b></span>
                        </div>
                        <div id="parlay-ctn" class="mt10">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>项目</th>
                                        <th colspan="2">正码一</th>
                                        <th colspan="2">正码二</th>
                                        <th colspan="2">正码三</th>
                                        <th colspan="2">正码四</th>
                                        <th colspan="2">正码五</th>
                                        <th colspan="2">正码六</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php foreach($LOT['odds'][9][1] as $i=>$val){ ?>                                    <tr>
                                        <td class="table-odd"><?php echo $val; ?></td>
<?php for($k=0;$k<6;$k++){ ?>                                        <td class="odds-text" data-id="<?php echo show_id(9+$k, $i); ?>">0</td>
                                        <td><input type="text" class="input" data-id="<?php echo show_id(9+$k, $i); ?>" data-odds="0"></td>
<?php } ?>                                    </tr>
<?php } ?>                                </tbody>
                            </table>
                            <div>
                                <form class="form normal-form mt10 tac need-auth" action="" id="parlay-form">
                                    <button class="button parlay bet-button" data-action="parlay">下注</button>
                                    <button class="button button-secondary bet-button" data-action="reset" type="reset">重置</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="aside">
                        <div class="amount need-auth">
                            <div class="available-amount box">
                                <span>可用金额</span>
                                <b id="j-balance">0.00</b>
                            </div>
                            <div class="betting-amount box">
                                <span>即时下注</span>
                                <b id="j-orders">0.00</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/html" id="tpl-prev-balls">
                {{#balls}}
                <i class="icon ball-style b-{{color}}">{{number}}</i>{{sx}}
                {{/balls}}
            </script>
            <script type="text/html" id="tpl-sflkhc-prev-balls">
                {{#balls}}
                <i class="icon ball-style s-{{color}}">{{number}}</i>{{sx}}
                {{/balls}}
            </script>
            <script type="text/html" id="tpl-jslh-prev-balls">
                {{#balls}}
                <i class="icon ball-style s-{{color}}">{{number}}</i>{{sx}}
                {{/balls}}
            </script>
            <input type="hidden" value="<?php echo $LOT['six']['type']; ?>" id="h-nav-top"/>
            <input type="hidden" value="<?php echo $LOT['six']['pan']; ?>" id="h-nav-sub"/>
            <script>
                require(['six/zhengma'], function (App) {
                    new App({lotteryId: "<?php echo $LOT['action']; ?>"});
                })
            </script>
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
