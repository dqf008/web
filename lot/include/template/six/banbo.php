<?php
!defined('IN_LOT') && die('Access Denied');
$color = array(
    '红单' => array('red', array(1, 7, 13, 19, 23, 29, 35, 45)),
    '红双' => array('red', array(2, 8, 12, 18, 24, 30, 34, 40, 46)),
    '红大' => array('red', array(29, 30, 34, 35, 40, 45, 46)),
    '红小' => array('red', array(1, 2, 7, 8, 12, 13, 18, 19, 23, 24)),
    '绿单' => array('green', array(5, 11, 17, 21, 27, 33, 39, 43)),
    '绿双' => array('green', array(6, 16, 22, 28, 32, 38, 44)),
    '绿大' => array('green', array(27, 28, 32, 33, 38, 39, 43, 44)),
    '绿小' => array('green', array(5, 6, 11, 16, 17, 21, 22)),
    '蓝单' => array('blue', array(3, 9, 15, 25, 31, 37, 41, 47)),
    '蓝双' => array('blue', array(4, 10, 14, 20, 26, 36, 42, 48)),
    '蓝大' => array('blue', array(25, 26, 31, 36, 37, 41, 42, 47, 48)),
    '蓝小' => array('blue', array(3, 4, 9, 10, 14, 15, 20)),
    '红合单' => array('red', array(1, 7, 12, 18, 23, 29, 30, 34, 45)),
    '红合双' => array('red', array(2, 8, 13, 19, 24, 35, 40, 46)),
    '绿合单' => array('green', array(5, 16, 21, 27, 32, 38, 43)),
    '绿合双' => array('green', array(6, 11, 17, 22, 28, 33, 39, 44)),
    '蓝合单' => array('blue', array(3, 9, 10, 14, 25, 36, 41, 47)),
    '蓝合双' => array('blue', array(4, 15, 20, 26, 31, 37, 42, 48)),
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
        <?php include(IN_LOT . 'include/template/six/nav.php'); ?>                </div>
    <div class="play-bd clearfix">
        <div class="main-bd">
            <div class="clearfix top-bar">
                <span>今天输赢<b id="win-lose">0.00</b></span>
                <span>期数<b class="box" id="current-issue">0期</b></span>
                <span>距离封盘<b class="box timer close-timer" id="close-timer" data-timer="13">00:00</b></span>
                <span>距离开奖<b class="box timer" id="award-timer">00:00</b></span>
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
                            $a = $LOT['odds'][21][1][$i];
                            $c = $color[$a];
                            $k = show_id(21, $i);
                            if (fmod($i, 2) == 1) {
                                ?>                                        <tr>
                            <?php } ?>
                            <td class="table-odd"><?php echo $a; ?></td>
                            <td class="odds-text"><span data-id="<?php echo $k; ?>">-</span></td>
                            <td><input type="text" class="input" data-id="<?php echo $k; ?>" data-odds="0"/></td>
                            <td>
                                <div class="clearfix"><?php foreach ($c[1] as $ball) { ?><span
                                        class="fl icon s-<?php echo $c[0]; ?>"><?php echo substr('00' . $ball, -2); ?></span><?php } ?>
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
<input type="hidden" value="<?php echo $LOT['six']['type']; ?>" id="h-nav-top"/>
<input type="hidden" value="<?php echo $LOT['six']['pan']; ?>" id="h-nav-sub"/>
<script>
    require(['six/index'], function (App) {
        new App({lotteryId: "<?php echo $LOT['action'];?>"});
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
