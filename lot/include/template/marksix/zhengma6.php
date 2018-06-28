<?php !defined('IN_LOT')&&die('Access Denied'); ?>
<?php include(IN_LOT.'include/template/marksix/groupWrap.php'); ?>
            <div class="summary summary-hkc" id="summary">
                <i class="icon sound-on fr" title="声音开关"></i>
                <div class="summary-prev fr" id="pre-result">
                    <span class="fl mr6"><b id="prev-issue">0</b>期结果</span>
                    <span class="summary-prev-hkc" id="prev-bs"></span>
                </div>
                <span class="notify"><span id="marquee" width="370" height="31" style="display: none"></span></span>
            </div>
            <div id="play" class="play hkc">
                <div class="play-hd clearfix">
                    <span class="fr hide">
                        <a target="_blank" title="开奖直播" href="http://www.6hbd.me/marksix/shipin">开奖直播</a>&nbsp;
                        <a target="_blank" title="数据统计" href="http://www.6hbd.me">数据统计</a>
                    </span>
                    <span class="fl">玩法：</span>
<?php include(IN_LOT.'include/template/marksix/nav.php'); ?>                </div>
                <div class="play-bd clearfix">
                    <div class="main-bd">
                        <div class="clearfix top-bar">
                            <div class="fr nav-button" id="sub-tabs"></div>
                            <span>距离封盘<b class="box ib timer close-timer" id="close-timer" data-timer="">&nbsp;</b></span>
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
<?php foreach($LOT['odds'][11][1] as $i=>$val){ ?>                                    <tr>
                                        <td class="table-odd"><?php echo $val; ?></td>
<?php for($k=0;$k<6;$k++){ ?>                                        <td class="odds-text" data-id="<?php echo show_id(11+$k, $i); ?>">0</td>
                                        <td><input type="text" class="input" data-id="<?php echo show_id(11+$k, $i); ?>" data-odds="0"></td>
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
            <input type="hidden" value="<?php echo $LOT['marksix']['type']; ?>" id="h-nav-top"/>
            <input type="hidden" value="<?php echo $LOT['marksix']['pan']; ?>" id="h-nav-sub"/>
            <script>
                require(['marksix/zhengma'], function (App) {
                    new App({lotteryId: "marksix"});
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
