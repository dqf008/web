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
                                        <th width="9%">项目</th>
                                        <th width="13%">单</th>
                                        <th width="13%">双</th>
                                        <th width="13%">大</th>
                                        <th width="13%">小</th>
                                        <th width="13%">红波</th>
                                        <th width="13%">绿波</th>
                                        <th width="13%">蓝波</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php for($i=17;$i<=22;$i++){ ?>                                    <tr>
                                        <td class="table-odd"><?php echo $LOT['odds'][$i][0][1]; ?></td>
<?php for($k=1;$k<=7;$k++){$id = show_id($i, $k);$key = 'j'.substr('0000'.$id, -4); ?>                                        <td>
                                            <label><em class="j-odds vam" data-id="<?php echo $id; ?>" data-oid="<?php echo $id; ?>" data-key="<?php echo $key; ?>">0</em></label>
                                        </td>
<?php } ?>                                    </tr>
<?php } ?>                                </tbody>
                            </table>
                        </div>
                        <div class="selected-ball clearfix need-auth">
                            <div class="fr">
                                <form class="form quick-form need-auth" action="">
                                    <label>金额：<input type="text" class="input fb sync-bet"/></label>
                                    <button class="button parlay bet-button" data-action="parlay">下注</button>
                                    <button class="button button-secondary bet-button" data-action="reset" type="reset">重置</button>
                                </form>
                            </div>
                            <b id="j-selected-count"><span class="j-selected-count">0</span>串<span class="j-selected-count">1</span>@<span class="j-selected-count">0</span></b>
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
                require(['marksix/guoguan'], function (App) {
                    new App({lotteryId: "marksix"});
                })
            </script>
            <div id="j-confirm-tpl" class="hide">
                <div class="confirm-parlay">
                    <h3><em>{{items.length}} 串 1 @ {{items.0.lines}} X {{items.0.amount}}</em>，您确定要下注吗？</h3>
                    <ul class="{{col}}">
                        {{#items}}
                        <li><span>{{category}}【{{name}}】</span>@{{odds}}</li>
                        {{/items}}
                    </ul>
                </div>
            </div>
