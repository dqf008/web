<?php !defined('IN_LOT') && die('Access Denied'); ?>
<style type="text/css">.aside .odds-amount {
        border-color: #c61e2f;
        background: #c61e2f
    }</style>
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
        <?php include(IN_LOT . 'include/template/six/nav.php'); ?>                </div>
    <div class="play-bd clearfix">
        <div class="main-bd">
            <div class="clearfix top-bar">
                <div class="fr nav-button" id="sub-tabs">
                    <?php for ($i = 48; $i <= 55; $i++) { ?>                                <a
                            id="sub-nav-<?php echo $i; ?>"
                            href="?i=<?php echo $LOT['action']; ?>&amp;t=quanbuzhong&amp;p=<?php echo $i; ?>"
                            class="button"><?php echo $LOT['odds'][$i][0][0]; ?></a>
                    <?php } ?>                            </div>
                <span>期数<b class="box" id="current-issue">0期</b></span>
                <span>距离封盘<b class="box timer close-timer" id="close-timer" data-timer="13">00:00</b></span>
                <span>距离开奖<b class="box timer" id="award-timer">00:00</b></span>
            </div>
            <div id="parlay-ctn" class="mt10">
                <div class="j-content">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>号码</th>
                            <th>赔率</th>
                            <th>勾选</th>
                            <th>号码</th>
                            <th>赔率</th>
                            <th>勾选</th>
                            <th>号码</th>
                            <th>赔率</th>
                            <th>勾选</th>
                            <th>号码</th>
                            <th>赔率</th>
                            <th>勾选</th>
                            <th>号码</th>
                            <th>赔率</th>
                            <th>勾选</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($i = 1; $i <= 49; $i++) {
                            $a = $LOT['odds'][$LOT['six']['pan']][1][$i];
                            $k = show_id($LOT['six']['pan'], $i);
                            if (fmod($i, 5) == 1) {
                                ?>                                        <tr>
                            <?php } ?>
                            <td class="table-odd"><i
                                        class="icon s-<?php echo $LOT['color'][$a]; ?>"><?php echo substr('00' . $a, -2); ?></i>
                            </td>
                            <td class="odds-text"><span data-id="<?php echo $k; ?>" data-oid="<?php echo $k; ?>"
                                                        data-key="<?php echo $k; ?>">-</span></td>
                            <td><input type="checkbox" data-id="<?php echo $k; ?>" data-oid="<?php echo $k; ?>"
                                       data-key="<?php echo $k; ?>" data-odds="0"/></td>
                            <?php if (fmod($i, 5) == 0) { ?>                                        </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
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
                <div class="odds-amount box">
                    <span>今天输赢</span>
                    <b id="win-lose">--</b>
                </div>
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
    require(['six/buzhong'], function (App) {
        new App({
            lotteryId: "<?php echo $LOT['action']; ?>",
            limit: <?php echo $LOT['odds'][$LOT['six']['pan']][0][4]; ?>});
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
