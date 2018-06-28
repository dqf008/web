<?php
!defined('IN_LOT')&&die('Access Denied');
$balls = array(
    '0' => array(10, 20, 30, 40),
    '1' => array(1, 11, 21, 31, 41),
    '2' => array(2, 12, 22, 32, 42),
    '3' => array(3, 13, 23, 33, 43),
    '4' => array(4, 14, 24, 34, 44),
    '5' => array(5, 15, 25, 35, 45),
    '6' => array(6, 16, 26, 36, 46),
    '7' => array(7, 17, 27, 37, 47),
    '8' => array(8, 18, 28, 38, 48),
    '9' => array(9, 19, 29, 39, 49),
);
?>
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
                            <div class="fr nav-button" id="sub-tabs"></div>
                            <span>今天输赢<b id="win-lose">0.00</b></span>
                            <span>期数<b class="box" id="current-issue">0期</b></span>
                            <span>距离封盘<b class="box timer close-timer" id="close-timer" data-timer="13">00:00</b></span>
                            <span>距离开奖<b class="box timer" id="award-timer">00:00</b></span>
                        </div>
                        <div id="parlay-ctn" class="mt10">
                            <div class="ban-bo padded-icon">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>二尾连</th>
                                            <th>三尾连</th>
                                            <th>四尾连</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><label><input type="radio" name="state" data-pan="32" data-min="2" />中</label></td>
                                            <td><label><input type="radio" name="state" data-pan="33" data-min="3" />中</label></td>
                                            <td><label><input type="radio" name="state" data-pan="34" data-min="4" />中</label></td>
                                        </tr>
                                        <tr>
                                            <td><label><input type="radio" name="state" data-pan="35" data-min="2" />不中</label></td>
                                            <td><label><input type="radio" name="state" data-pan="36" data-min="3" />不中</label></td>
                                            <td><label><input type="radio" name="state" data-pan="37" data-min="4" />不中</label></td>
                                        </tr>
                                    </tbody>
                                </table>
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
for($i=1;$i<=10;$i++){
    $a = $LOT['odds'][32][1][$i];
    if(fmod($i, 2)==1){
?>                                            <tr>
<?php } ?>                                                <td class="table-odd"><?php echo $a; ?>尾</td>
                                                <td class="odds-text"><span data-id="" data-oid="" data-key="" data-i="<?php echo $i; ?>">-</span></td>
                                                <td><input type="checkbox" data-id="" data-oid="" data-key="" data-odds="" data-i="<?php echo $i; ?>" /></td>
                                                <td>
                                                    <div class="clearfix"><?php foreach($balls[$a] as $k){ ?><span class="fl icon s-<?php echo $LOT['color'][$k]; ?>"><?php echo substr('00'.$k, -2); ?></span><?php } ?></div>
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
            <input type="hidden" value="<?php echo $LOT['six']['type']; ?>" id="h-nav-top"/>
            <input type="hidden" value="<?php echo $LOT['six']['pan']; ?>" id="h-nav-sub"/>
            <script>
                require(['six/lianwei'], function (App) {
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
