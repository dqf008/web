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
                            <div class="fr nav-button" id="sub-tabs">
<?php for($i=40;$i<=49;$i++){ ?>                                <a id="sub-nav-<?php echo $i; ?>" href="?i=marksix&amp;t=hexiao&amp;p=<?php echo $i; ?>" class="button"><?php echo $LOT['odds'][$i][0][1]; ?></a>
<?php } ?>                            </div>
                            <span>距离封盘<b class="box ib timer close-timer" id="close-timer" data-timer="">&nbsp;</b></span>
                        </div>
                        <div id="parlay-ctn" class="mt10">
                            <div class="ban-bo padded-icon">
                                <div class="j-content">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>号码</th>
                                                <th>赔率</th>
                                                <th>勾选</th>
                                                <th>球号</th>
                                                <th>号码</th>
                                                <th>赔率</th>
                                                <th>勾选</th>
                                                <th>球号</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
for($i=1;$i<=12;$i++){
    $a = $LOT['odds'][$LOT['marksix']['pan']][1][$i];
    $k = show_id($LOT['marksix']['pan'], $i);
    if(fmod($i, 2)==1){
?>                                            <tr>
<?php } ?>                                                <td class="table-odd"><?php echo $a; ?></td>
                                                <td class="odds-text"><span data-id="<?php echo $k; ?>" data-oid="<?php echo $k; ?>" data-key="<?php echo $k; ?>">-</span></td>
                                                <td><input type="checkbox" data-id="<?php echo $k; ?>" data-oid="<?php echo $k; ?>" data-key="<?php echo $k; ?>" data-odds="0" /></td>
                                                <td>
                                                    <div class="clearfix"><?php foreach($LOT['animal'][$a] as $k){ ?><span class="fl icon b-<?php echo $LOT['color'][$k]; ?>"><?php echo $k; ?></span><?php } ?></div>
                                                </td>
<?php if(fmod($i, 2)==0){ ?>                                            </tr>
<?php }} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div>
                                <form class="form normal-form mt10 tac need-auth" id="parlay-form">
                                    <label>金额：<input type="text" class="input fb"/></label>
                                    <button class="button parlay bet-button" data-action="parlay">下注</button>
                                    <button class="button button-secondary bet-button " data-action="reset" type="reset">重置</button>
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
                require(['marksix/hexiao'], function (App) {
                    new App({lotteryId: "marksix", limit: <?php echo $LOT['odds'][$LOT['marksix']['pan']][0][5]; ?>});
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
