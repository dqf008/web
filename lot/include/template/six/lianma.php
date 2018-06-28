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
                    <?php for ($i = 56; $i <= 61; $i++) { ?>                                <a
                            id="sub-nav-<?php echo $i; ?>"
                            href="?i=<?php echo $LOT['action']; ?>&amp;t=lianma&amp;p=<?php echo $i; ?>"
                            class="button"><?php echo $LOT['odds'][$i][0][0]; ?></a>
                    <?php } ?>                            </div>
                <span>今天输赢<b id="win-lose">0.00</b></span>
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
                            <th>勾选</th>
                            <th>号码</th>
                            <th>勾选</th>
                            <th>号码</th>
                            <th>勾选</th>
                            <th>号码</th>
                            <th>勾选</th>
                            <th>号码</th>
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
                            <td><input type="checkbox" data-id="<?php echo $k; ?>" data-oid="<?php echo $k; ?>"
                                       data-key="<?php echo $k; ?>" data-odds="0" data-number="<?php echo $a; ?>"/></td>
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
                <table class="table mt10" id="j-cpd-tb">
                    <tr>
                        <td>
                            <label for="hkc-bet1" class="hkc-bet-type"><input type="radio" id="hkc-bet1" name="betType"
                                                                              value="1" data-type="1"
                                                                              data-process="default">正常</label>
                            <label for="hkc-bet2" class="hkc-bet-type"><input type="radio" id="hkc-bet2" name="betType"
                                                                              value="2" data-type="2" data-process="dt">胆拖</label>
                            <?php if ($LOT['odds'][$LOT['six']['pan']][0][4] < 3) { ?>
                                <label for="hkc-bet3" class="hkc-bet-type"><input type="radio" id="hkc-bet3"
                                                                                  name="betType" value="3" data-type="3"
                                                                                  data-process="sx">生肖对碰</label>
                                <label for="hkc-bet4" class="hkc-bet-type"><input type="radio" id="hkc-bet4"
                                                                                  name="betType" value="4" data-type="4"
                                                                                  data-process="ws">尾数对碰</label>
                                <label for="hkc-bet5" class="hkc-bet-type"><input type="radio" id="hkc-bet5"
                                                                                  name="betType" value="5" data-type="5"
                                                                                  data-process="sw">生尾对碰</label>
                                <label for="hkc-bet6" class="hkc-bet-type"><input type="radio" id="hkc-bet6"
                                                                                  name="betType" value="6" data-type="6"
                                                                                  data-process="ry">任意对碰</label>
                            <?php } ?>                                    </td>
                    </tr>
                </table>
                <table class="table nested-table " id="j-bet-tb">
                    <tr class="hide">
                        <td class="j-reset-html">&nbsp;</td>
                    </tr>
                    <tr class="hide">
                        <td>
                            <div class="fl j-reset-html"></div>
                            <label>胆1<input type="text" value="" class="input" disabled/></label>
                            <label>胆2<input type="text" value="" class="input" disabled/></label>
                        </td>
                    </tr>
                    <?php if ($LOT['odds'][$LOT['six']['pan']][0][4] < 3) { ?>
                        <tr class="hide">
                            <td class="p0">
                                <table>
                                    <tr>
                                        <td><label><input type="radio" value="鼠" name="sx0" class="vam"/>鼠</label></td>
                                        <td><label><input type="radio" value="牛" name="sx0" class="vam"/>牛</label></td>
                                        <td><label><input type="radio" value="虎" name="sx0" class="vam"/>虎</label></td>
                                        <td><label><input type="radio" value="兔" name="sx0" class="vam"/>兔</label></td>
                                        <td><label><input type="radio" value="龙" name="sx0" class="vam"/>龙</label></td>
                                        <td><label><input type="radio" value="蛇" name="sx0" class="vam"/>蛇</label></td>
                                        <td><label><input type="radio" value="马" name="sx0" class="vam"/>马</label></td>
                                        <td><label><input type="radio" value="羊" name="sx0" class="vam"/>羊</label></td>
                                        <td><label><input type="radio" value="猴" name="sx0" class="vam"/>猴</label></td>
                                        <td><label><input type="radio" value="鸡" name="sx0" class="vam"/>鸡</label></td>
                                        <td><label><input type="radio" value="狗" name="sx0" class="vam"/>狗</label></td>
                                        <td><label><input type="radio" value="猪" name="sx0" class="vam"/>猪</label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" value="鼠" name="sx1" class="vam"/>鼠</label></td>
                                        <td><label><input type="radio" value="牛" name="sx1" class="vam"/>牛</label></td>
                                        <td><label><input type="radio" value="虎" name="sx1" class="vam"/>虎</label></td>
                                        <td><label><input type="radio" value="兔" name="sx1" class="vam"/>兔</label></td>
                                        <td><label><input type="radio" value="龙" name="sx1" class="vam"/>龙</label></td>
                                        <td><label><input type="radio" value="蛇" name="sx1" class="vam"/>蛇</label></td>
                                        <td><label><input type="radio" value="马" name="sx1" class="vam"/>马</label></td>
                                        <td><label><input type="radio" value="羊" name="sx1" class="vam"/>羊</label></td>
                                        <td><label><input type="radio" value="猴" name="sx1" class="vam"/>猴</label></td>
                                        <td><label><input type="radio" value="鸡" name="sx1" class="vam"/>鸡</label></td>
                                        <td><label><input type="radio" value="狗" name="sx1" class="vam"/>狗</label></td>
                                        <td><label><input type="radio" value="猪" name="sx1" class="vam"/>猪</label></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="hide">
                            <td class="p0">
                                <table>
                                    <tr>
                                        <td><label><input type="radio" value="0" name="ws0" class="vam"/>0尾</label></td>
                                        <td><label><input type="radio" value="1" name="ws0" class="vam"/>1尾</label></td>
                                        <td><label><input type="radio" value="2" name="ws0" class="vam"/>2尾</label></td>
                                        <td><label><input type="radio" value="3" name="ws0" class="vam"/>3尾</label></td>
                                        <td><label><input type="radio" value="4" name="ws0" class="vam"/>4尾</label></td>
                                        <td><label><input type="radio" value="5" name="ws0" class="vam"/>5尾</label></td>
                                        <td><label><input type="radio" value="6" name="ws0" class="vam"/>6尾</label></td>
                                        <td><label><input type="radio" value="7" name="ws0" class="vam"/>7尾</label></td>
                                        <td><label><input type="radio" value="8" name="ws0" class="vam"/>8尾</label></td>
                                        <td><label><input type="radio" value="9" name="ws0" class="vam"/>9尾</label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="radio" value="0" name="ws1" class="vam"/>0尾</label></td>
                                        <td><label><input type="radio" value="1" name="ws1" class="vam"/>1尾</label></td>
                                        <td><label><input type="radio" value="2" name="ws1" class="vam"/>2尾</label></td>
                                        <td><label><input type="radio" value="3" name="ws1" class="vam"/>3尾</label></td>
                                        <td><label><input type="radio" value="4" name="ws1" class="vam"/>4尾</label></td>
                                        <td><label><input type="radio" value="5" name="ws1" class="vam"/>5尾</label></td>
                                        <td><label><input type="radio" value="6" name="ws1" class="vam"/>6尾</label></td>
                                        <td><label><input type="radio" value="7" name="ws1" class="vam"/>7尾</label></td>
                                        <td><label><input type="radio" value="8" name="ws1" class="vam"/>8尾</label></td>
                                        <td><label><input type="radio" value="9" name="ws1" class="vam"/>9尾</label></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="hide">
                            <td class="p0">
                                <table>
                                    <tr>
                                        <td><label><input type="radio" value="鼠" name="sw" class="vam"/>鼠</label></td>
                                        <td><label><input type="radio" value="牛" name="sw" class="vam"/>牛</label></td>
                                        <td><label><input type="radio" value="虎" name="sw" class="vam"/>虎</label></td>
                                        <td><label><input type="radio" value="兔" name="sw" class="vam"/>兔</label></td>
                                        <td><label><input type="radio" value="龙" name="sw" class="vam"/>龙</label></td>
                                        <td><label><input type="radio" value="蛇" name="sw" class="vam"/>蛇</label></td>
                                        <td><label><input type="radio" value="马" name="sw" class="vam"/>马</label></td>
                                        <td><label><input type="radio" value="羊" name="sw" class="vam"/>羊</label></td>
                                        <td><label><input type="radio" value="猴" name="sw" class="vam"/>猴</label></td>
                                        <td><label><input type="radio" value="鸡" name="sw" class="vam"/>鸡</label></td>
                                        <td><label><input type="radio" value="狗" name="sw" class="vam"/>狗</label></td>
                                        <td><label><input type="radio" value="猪" name="sw" class="vam"/>猪</label></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><label><input type="radio" value="0" name="ws" class="vam"/>0尾</label></td>
                                        <td><label><input type="radio" value="1" name="ws" class="vam"/>1尾</label></td>
                                        <td><label><input type="radio" value="2" name="ws" class="vam"/>2尾</label></td>
                                        <td><label><input type="radio" value="3" name="ws" class="vam"/>3尾</label></td>
                                        <td><label><input type="radio" value="4" name="ws" class="vam"/>4尾</label></td>
                                        <td><label><input type="radio" value="5" name="ws" class="vam"/>5尾</label></td>
                                        <td><label><input type="radio" value="6" name="ws" class="vam"/>6尾</label></td>
                                        <td><label><input type="radio" value="7" name="ws" class="vam"/>7尾</label></td>
                                        <td><label><input type="radio" value="8" name="ws" class="vam"/>8尾</label></td>
                                        <td><label><input type="radio" value="9" name="ws" class="vam"/>9尾</label></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="hide">
                            <td class="p0">
                                <table>
                                    <tr>
                                        <td><input type="text" value="" name="ws" class="input j-left-num"
                                                   data-max="49"/></td>
                                        <td><input type="text" value="" name="ws" class="input j-left-num"
                                                   data-max="49"/></td>
                                        <td><input type="text" value="" name="ws" class="input j-left-num"
                                                   data-max="49"/></td>
                                        <td><input type="text" value="" name="ws" class="input j-left-num"
                                                   data-max="49"/></td>
                                        <td><input type="text" value="" name="ws" class="input j-left-num"
                                                   data-max="49"/></td>
                                        <td>碰</td>
                                        <td><input type="text" value="" name="ws" class="input j-right-num"
                                                   data-max="49"/></td>
                                        <td><input type="text" value="" name="ws" class="input j-right-num"
                                                   data-max="49"/></td>
                                        <td><input type="text" value="" name="ws" class="input j-right-num"
                                                   data-max="49"/></td>
                                        <td><input type="text" value="" name="ws" class="input j-right-num"
                                                   data-max="49"/></td>
                                        <td><input type="text" value="" name="ws" class="input j-right-num"
                                                   data-max="49"/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>                            </table>
            </div>
        </div>
        <div class="aside">
            <div class="amount">
                <div class="odds-amount box">
                    <span>即时赔率</span>
                    <b id="j-odds">--</b>
                </div>
                <div class="available-amount box need-auth">
                    <span>可用金额</span>
                    <b id="j-balance">0.00</b>
                </div>
                <div class="betting-amount box need-auth">
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
    require(['six/lianma'], function (App) {
        new App({
            lotteryId: "<?php echo $LOT['action']; ?>",
            limit: <?php echo $LOT['odds'][$LOT['six']['pan']][0][4]; ?>,
            sx: <?php echo json_encode($LOT['animal'], JSON_UNESCAPED_UNICODE); ?>,
            ws: [[10, 20, 30, 40], [1, 11, 21, 31, 41], [2, 12, 22, 32, 42], [3, 13, 23, 33, 43], [4, 14, 24, 34, 44], [5, 15, 25, 35, 45], [6, 16, 26, 36, 46], [7, 17, 27, 37, 47], [8, 18, 28, 38, 48], [9, 19, 29, 39, 49]],
            lang: {
                tipsPeilv: '赔率', //赔率
                tipsDuiPengSX: '请选择对碰的生肖',   // 请选择对碰的生肖
                tipsDuiPengSxSame: '对碰的生肖不能相同', //对碰的生肖不能相同
                tipsDuiPengWeiShu: '请选择对碰的尾数', //请选择对碰的尾数
                tipsDuiPengWeiShuSame: '对碰的尾数不能相同', //对碰的尾数不能相同
                tipsDuiPengSxWeiShu: '请选择对碰的生肖尾数',  //请选择对碰的生肖尾数
                tipsDuiPengSxWeiShuSame: '对碰的生肖尾数不能相同',//对碰的生肖尾数不能相同
                tipsDuiPengAnyNum: '请选择对碰的任意号码', //请选择对碰的任意号码
                tipsDuiPengAnyNumSame: '对碰的号码不能相同' // 对碰的号码不能相同
            }
        });
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
<script id="tpl-confirm-group" type="text/html">
    <div class="confirm-parlay">
        {{#dan}}
        <h3>{{d}}拖{{t}}</h3>
        {{/dan}}
        {{#name}}
        <h3>{{.}}</h3>
        {{/name}}
        {{#desc}}
        <h3>{{left}}碰{{right}}</h3>
        {{/desc}}
        <h4>组合共：<em>{{group}}</em>组</h4>
        <h5>单注金额：<em>{{single}}</em></h5>
        <h5>总下注金额：<em>{{total}}</em></h5>
    </div>
</script>
<script id="tpl-cpd" type="text/html">
    <div class="clearfix">
        <em class="fl mr10 ml10">选项:{{total}} [{{items}}]</em>
        <em class="fl ">组成:{{group}}组</em>
    </div>
</script>
