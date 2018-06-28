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
                            <div class="clearfix" id="j-number-ctn">
<?php for($i=0;$i<5;$i++){ ?>                                <table class="table fl wp-20">
                                    <thead>
                                        <tr>
                                            <th>号码</th>
                                            <th>赔率</th>
                                            <th>金额</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
for($j=0;$j<10;$j++){
    $k = $i+($j*5)+1;
    if($k<50){
        $c = substr('00'.$k, -2);
        $s = show_id($LOT['six']['pan'], $k);
?>                                        <tr class="el el<?php echo $c; ?>" data-id="<?php echo $s; ?>" data-odds="">
                                            <td class="table-odd"><i class="icon s-<?php echo $LOT['color'][$k]; ?>"><?php echo $c; ?></i></td>
                                            <td class="odds-text"><span data-id="<?php echo $s; ?>"></span></td>
                                            <td><input type="text" class="input" data-id="<?php echo $s; ?>" data-odds=""/></td>
                                        </tr>
<?php }} ?>                                    </tbody>
                                </table>
<?php } ?>                            </div>
                            <div class="clearfix">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>类型</th>
                                            <th>赔率</th>
                                            <th>金额</th>
                                            <th>类型</th>
                                            <th>赔率</th>
                                            <th>金额</th>
                                            <th>类型</th>
                                            <th>赔率</th>
                                            <th>金额</th>
                                            <th>类型</th>
                                            <th>赔率</th>
                                            <th>金额</th>
                                            <th>类型</th>
                                            <th>赔率</th>
                                            <th>金额</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$_list = array(
    50, 63, 54, 56, 59,
    51, 64, 55, 57, 60,
    52, 65, 61, 58, 0,
    53, 66, 62, 0, 0,
);
foreach($_list as $k=>$i){
    if(fmod($k, 5)==0){
?>                                        <tr>
<?php }if($i>0){ ?>                                            <td class="table-odd"><?php echo $LOT['odds'][1][1][$i]; ?></td>
                                            <td class="odds-text"><span data-id="<?php echo show_id($LOT['six']['pan'], $i); ?>"></span></td>
                                            <td><input type="text" class="input" data-id="<?php echo show_id($LOT['six']['pan'], $i); ?>" data-odds=""/></td>
<?php }if(fmod($k, 5)==4){ ?>                                        </tr>
<?php }} ?>                                    </tbody>
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
                        <div class="hkc-quick-bet" id="hkc-quick-ctn">
                            <div class="need-auth">
                                <form class="form quick-form" action="">
                                    <label>
                                        <span class="vam">金额</span>
                                        <input type="text" class="input" id="hkc-quick-amount"/>
                                    </label>
                                    <div class="mt10">
                                        <button class="button button-secondary bet-button mr10" data-action="reset" type="reset">重置</button>
                                        <button class="button parlay bet-button " data-action="parlay">下注</button>
                                    </div>
                                </form>
                            </div>
                            <table class="table table-noborder">
                                <tr>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="红大"/>
                                            <span class="red">红大</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="红单"/>
                                            <span class="red">红单</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="红合单"/>
                                            <span class="red">红合单</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="红合双"/>
                                            <span class="red">红合双</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="红双"/>
                                            <span class="red">红双</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="红小"/>
                                            <span class="red">红小</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="绿大"/>
                                            <span class="green">绿大</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="绿单"/>
                                            <span class="green">绿单</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="绿合单"/>
                                            <span class="green">绿合单</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="绿合双"/>
                                            <span class="green">绿合双</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="绿双"/>
                                            <span class="green">绿双</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="绿小"/>
                                            <span class="green">绿小</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="蓝大"/>
                                            <span class="blue">蓝大</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="蓝单"/>
                                            <span class="blue">蓝单</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="蓝合单"/>
                                            <span class="blue">蓝合单</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="蓝合双"/>
                                            <span class="blue">蓝合双</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="蓝双"/>
                                            <span class="blue">蓝双</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="radio" name="s" class="j-hkc-qb" value="蓝小"/>
                                            <span class="blue">蓝小</span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                            <table class="table" id="tb-dxds">
                                <tr>
                                    <td><span class="red j-hkc-sx" data-key="dan">单</span></td>
                                    <td><span class="red j-hkc-sx" data-key="shuang">双</span></td>
                                    <td><span class="red j-hkc-sx" data-key="da">大</span></td>
                                    <td><span class="red j-hkc-sx" data-key="xiao">小</span></td>
                                </tr>
                            </table>
                            <table class="table" id="tb-sx">
                                <tr>
                                    <td><span data-key="鼠" class="j-hkc-sx" data-sx="true">鼠</span></td>
                                    <td><span data-key="牛" class="j-hkc-sx" data-sx="true">牛</span></td>
                                    <td><span data-key="虎" class="j-hkc-sx" data-sx="true">虎</span></td>
                                    <td><span data-key="兔" class="j-hkc-sx" data-sx="true">兔</span></td>
                                </tr>
                                <tr>
                                    <td><span data-key="龙" class="j-hkc-sx" data-sx="true">龙</span></td>
                                    <td><span data-key="蛇" class="j-hkc-sx" data-sx="true">蛇</span></td>
                                    <td><span data-key="马" class="j-hkc-sx" data-sx="true">马</span></td>
                                    <td><span data-key="羊" class="j-hkc-sx" data-sx="true">羊</span></td>
                                </tr>
                                <tr>
                                    <td><span data-key="猴" class="j-hkc-sx" data-sx="true">猴</span></td>
                                    <td><span data-key="鸡" class="j-hkc-sx" data-sx="true">鸡</span></td>
                                    <td><span data-key="狗" class="j-hkc-sx" data-sx="true">狗</span></td>
                                    <td><span data-key="猪" class="j-hkc-sx" data-sx="true">猪</span></td>
                                </tr>
                            </table>
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
                require(['six/tema'], function (App) {
                    new App({
                        lotteryId: "<?php echo $LOT['action']; ?>",
                        IsTeMa:1,
                        quick: {
                            sx: <?php echo json_encode($LOT['animal'], JSON_UNESCAPED_UNICODE); ?>,
                            banbo: {"红单":[1,7,13,19,23,29,35,45],"蓝双":[4,10,14,20,26,36,42,48],"红双":[2,8,12,18,24,30,34,40,46],"蓝大":[25,26,31,36,37,41,42,47,48],"红大":[29,30,34,35,40,45,46],"蓝小":[3,4,9,10,14,15,20],"红小":[1,2,7,8,12,13,18,19,23,24],"红合单":[1,7,12,18,23,29,30,34,45],"绿单":[5,11,17,21,27,33,39,43,49],"红合双":[2,8,13,19,24,35,40,46],"绿双":[6,16,22,28,32,38,44],"绿合单":[5,16,21,27,32,38,43,49],"绿大":[27,28,32,33,38,39,43,44,49],"绿合双":[6,11,17,22,28,33,39,44],"绿小":[5,6,11,16,17,21,22],"蓝合单":[3,9,10,14,25,36,41,47],"蓝单":[3,9,15,25,31,37,41,47],"蓝合双":[4,15,20,26,31,37,42,48]}
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
