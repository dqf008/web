<?php
!defined('IN_LOT') && die('Access Denied');
$color = [
    '红单'  => ['red', [1, 7, 13, 19, 23, 29, 35, 45]],
    '红双'  => ['red', [2, 8, 12, 18, 24, 30, 34, 40, 46]],
    '红大'  => ['red', [29, 30, 34, 35, 40, 45, 46]],
    '红小'  => ['red', [1, 2, 7, 8, 12, 13, 18, 19, 23, 24]],
    '绿单'  => ['green', [5, 11, 17, 21, 27, 33, 39, 43]],
    '绿双'  => ['green', [6, 16, 22, 28, 32, 38, 44]],
    '绿大'  => ['green', [27, 28, 32, 33, 38, 39, 43, 44]],
    '绿小'  => ['green', [5, 6, 11, 16, 17, 21, 22]],
    '蓝单'  => ['blue', [3, 9, 15, 25, 31, 37, 41, 47]],
    '蓝双'  => ['blue', [4, 10, 14, 20, 26, 36, 42, 48]],
    '蓝大'  => ['blue', [25, 26, 31, 36, 37, 41, 42, 47, 48]],
    '蓝小'  => ['blue', [3, 4, 9, 10, 14, 15, 20]],
    '红合单' => ['red', [1, 7, 12, 18, 23, 29, 30, 34, 45]],
    '红合双' => ['red', [2, 8, 13, 19, 24, 35, 40, 46]],
    '绿合单' => ['green', [5, 16, 21, 27, 32, 38, 43]],
    '绿合双' => ['green', [6, 11, 17, 22, 28, 33, 39, 44]],
    '蓝合单' => ['blue', [3, 9, 10, 14, 25, 36, 41, 47]],
    '蓝合双' => ['blue', [4, 15, 20, 26, 31, 37, 42, 48]],
];
?>
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
        <?php include(IN_LOT . 'include/template/marksix/nav.php'); ?>                </div>
    <div class="play-bd clearfix">
        <div class="main-bd">
            <div class="clearfix top-bar">
                <div class="fr nav-button" id="sub-tabs"></div>
                <span>距离封盘<b class="box ib timer close-timer" id="close-timer" data-timer="">&nbsp;</b></span>
            </div>
            <div id="parlay-ctn" class="mt10">
                <div class="ban-bo">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>号码</th>
                            <th>赔率</th>
                            <th>金额</th>
                            <th>球号</th>
                            <th>号码</th>
                            <th>赔率</th>
                            <th>金额</th>
                            <th>球号</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($i = 1; $i <= 18; $i++) {
                            $a = $LOT['odds'][23][1][$i];
                            $c = $color[$a];
                            $k = show_id(23, $i);
                            if (fmod($i, 2) == 1) {
                                ?>                                        <tr>
                            <?php } ?>
                            <td class="table-odd"><?php echo $a; ?></td>
                            <td class="odds-text"><span data-id="<?php echo $k; ?>">-</span></td>
                            <td><input type="text" class="input" data-id="<?php echo $k; ?>" data-odds="0"/></td>
                            <td>
                                <div class="clearfix"><span
                                            class="fl icon b-<?php echo $c[0]; ?>"><?php echo implode('</span><span class="fl icon b-' . $c[0] . '">', $c[1]); ?></span>
                                </div>
                            </td>
                            <?php if (fmod($i, 2) == 0) { ?>                                        </tr>
                            <?php }
                        } ?>                                    </tbody>
                    </table>
                </div>
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
    require(['marksix/index'], function (App) {
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
