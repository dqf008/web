<?php !defined('IN_LOT') && die('Access Denied'); ?>
<script type="text/javascript" src="../../../js/jquery.js"></script>
<style type="text/css">
    .qxc {
        width: 450px;
        float: left
    }

    .qxc div {
        line-height: 30px
    }

    .qxc i {
        cursor: pointer
    }

    .qxc .red-ball {
        background-position: -214px -190px;
        color: #fff
    }

    .qxc-info {
        width: 350px;
        float: right
    }

    .qxc-info select {
        width: 100%;
        height: 120px
    }

    .qxc-info .input {
        width: 80px
    }

    .aside .odds-amount {
        border-color: #c61e2f;
        background: #c61e2f
    }

    .summary-hkc .prev-list {
        line-height: 31px
    }
</style>
<style>
    .group_wrap {
        width: 100%;
        height: 34px;
        background-color: rgb(240, 237, 231);
    }

    .group_btn {
        font-size: 15px;
        width: 100px;
        height: 26px;
        display: inline-block;
        margin: 3px 0 0 5px;
        text-align: center;
        line-height: 28px;
    }

    .group_btn:hover {
        cursor: pointer;
        background-color: #a69b91;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }

    .group_active {
        background-color: #a69b91;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }
</style>
<div class="group_wrap"></div>
<script>
    var nav_str = 'qxc#ffqxc#wfqxc';
    var nav_arr;
    var html = '';
    var trans_arr = [];
    trans_arr['qxc'] = ['七星彩', '/lot/?i=qxc'];
    trans_arr['ffqxc'] = ['分分七星彩', '/lot/?i=ffqxc'];
    trans_arr['wfqxc'] = ['五分七星彩', '/lot/?i=wfqxc'];

    if (nav_str.indexOf('#')) {
        nav_arr = nav_str.split('#');
    } else {
        nav_arr = [nav_str];
    }
    for (var i in nav_arr) {
        html += "<span class='group_btn' id='nav_" + nav_arr[i] + "' onclick='window.location.href=\"" + trans_arr[nav_arr[i]][1] + "\";'>" + trans_arr[nav_arr[i]][0] + "</span>";

    }
    var activeTab = <?php echo "'".$LOT['lottery_type']."'" ?>;
    if(!activeTab){
        activeTab='ffqxc';
    }
    $('.group_wrap').append(html);

    $('#nav_'+activeTab).addClass('group_active');
</script>

<div class="summary summary-hkc" id="summary">
    <i class="icon sound-on fr" title="声音开关"></i>
    <div class="summary-prev fr" id="pre-result">
        <span class="fl mr6"><b id="prev-issue">0</b>期结果</span>
        <div class="prev-list fl">
                        <span id="prev-bs">
                            <script type="text/html" id="tpl-prev-balls">
                                {{#balls}}
                                <i class="icon ball ball-{{.}}">{{.}}</i>
                                {{/balls}}
                            </script>
                        </span>
            <div class="prev-data" id="prev-data"></div>
        </div>
    </div>
    <span class="notify"><span id="marquee" width="370" height="31" style="display: none"></span></span>
</div>
<div id="play" class="play">
    <div class="play-hd clearfix">
        <span class="fl">玩法：</span>
        <ul class="play-category fl" id="play-tab">
            <li data-target="#j-dw2" data-odds="102"><a href="javascript:;">二定玩法</a></li>
            <li data-target="#j-dw3" data-odds="103"><a href="javascript:;">三定玩法</a></li>
            <li data-target="#j-dw4" data-odds="104"><a href="javascript:;">四定玩法</a></li>
            <li data-target="#j-dw1"><a href="javascript:;">一定位</a></li>
            <li data-target="#j-zx2" data-odds="201"><a href="javascript:;">二字现</a></li>
            <li data-target="#j-zx3" data-odds="202"><a href="javascript:;">三字现</a></li>
        </ul>
    </div>
    <div class="play-bd clearfix">
        <div class="main-bd" id="parlay-ctn">
            <div class="clearfix top-bar">
                <span class="need-auth">上期输赢<b id="win-lose">0.00</b></span>
                <span>期数<b class="box" id="current-issue">0期</b></span>
                <span>当前采种<b class="box" id="current-lottery"><?php if(isset($LOT['lottery_name'])){echo $LOT['lottery_name'];}else{
                            echo "分分七星彩";
                        } ?></b></span>
                <span style="display: none" id="current-lottery-type"><?php if(isset($LOT['lottery_type'])){echo $LOT['lottery_type'];}else{
                        echo "ffqxc"; }?></span>
                <span>距离封盘<b class="box timer" id="close-timer">0天00:00:00</b></span>
                <span>距离开奖<b class="box timer" id="award-timer">0天00:00:00</b></span>
            </div>
            <div class="mt10">
                <div id="j-dw2" class="clearfix" data-odds="102">
                    <div class="qxc">
                        <div>
                            <label>仟位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div>
                            <label>佰位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div>
                            <label>拾位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div>
                            <label>个位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div class="selected-ball" style="padding-left:40px">
                            <button class="button" data-action="add">添加号码</button>
                            <button class="button button-secondary" data-action="delete">删除选中</button>
                        </div>
                    </div>
                    <div class="qxc-info">
                        <div><select multiple="multiple"></select></div>
                        <div class="selected-ball clearfix">
                            <div class="fr">
                                <form class="form need-auth" action="">
                                    <label>每注金额：<input type="text" class="input fb sync-bet"/></label>
                                    <button class="button parlay bet-button" data-action="parlay">下注</button>
                                    <button class="button button-secondary bet-button" data-action="reset" type="reset">
                                        重置
                                    </button>
                                </form>
                            </div>
                            <b id="j-selected-count">共<span class="j-selected-count">0</span>注</b>
                        </div>
                    </div>
                </div>
                <div id="j-dw3" class="hide clearfix" data-odds="103">
                    <div class="qxc">
                        <div>
                            <label>仟位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div>
                            <label>佰位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div>
                            <label>拾位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div>
                            <label>个位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div class="selected-ball" style="padding-left:40px">
                            <button class="button" data-action="add">添加号码</button>
                            <button class="button button-secondary" data-action="delete">删除选中</button>
                        </div>
                    </div>
                    <div class="qxc-info">
                        <div><select multiple="multiple"></select></div>
                        <div class="selected-ball clearfix">
                            <div class="fr">
                                <form class="form need-auth" action="">
                                    <label>每注金额：<input type="text" class="input fb sync-bet"/></label>
                                    <button class="button parlay bet-button" data-action="parlay">下注</button>
                                    <button class="button button-secondary bet-button" data-action="reset" type="reset">
                                        重置
                                    </button>
                                </form>
                            </div>
                            <b id="j-selected-count">共<span class="j-selected-count">0</span>注</b>
                        </div>
                    </div>
                </div>
                <div id="j-dw4" class="hide clearfix" data-odds="104">
                    <div class="qxc">
                        <div>
                            <label>仟位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div>
                            <label>佰位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div>
                            <label>拾位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div>
                            <label>个位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div class="selected-ball" style="padding-left:40px">
                            <button class="button" data-action="add">添加号码</button>
                            <button class="button button-secondary" data-action="delete">删除选中</button>
                        </div>
                    </div>
                    <div class="qxc-info">
                        <div><select multiple="multiple"></select></div>
                        <div class="selected-ball clearfix">
                            <div class="fr">
                                <form class="form need-auth" action="">
                                    <label>每注金额：<input type="text" class="input fb sync-bet"/></label>
                                    <button class="button parlay bet-button" data-action="parlay">下注</button>
                                    <button class="button button-secondary bet-button" data-action="reset" type="reset">
                                        重置
                                    </button>
                                </form>
                            </div>
                            <b id="j-selected-count">共<span class="j-selected-count">0</span>注</b>
                        </div>
                    </div>
                </div>
                <div id="j-dw1" class="hide clearfix" data-odds="101">
                    <div class="qxc">
                        <div>
                            <label>仟位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div>
                            <label>佰位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div>
                            <label>拾位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div>
                            <label>个位：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                            <a href="javascript:;" data-action="all">全</a>
                            <a href="javascript:;" data-action="big">大</a>
                            <a href="javascript:;" data-action="small">小</a>
                            <a href="javascript:;" data-action="odd">奇</a>
                            <a href="javascript:;" data-action="even">偶</a>
                            <a href="javascript:;" data-action="clear">清</a>
                        </div>
                        <div class="selected-ball" style="padding-left:40px">
                            <button class="button" data-action="add">添加号码</button>
                            <button class="button button-secondary" data-action="delete">删除选中</button>
                        </div>
                    </div>
                    <div class="qxc-info">
                        <div><select multiple="multiple"></select></div>
                        <div class="selected-ball clearfix">
                            <div class="fr">
                                <form class="form need-auth" action="">
                                    <label>每注金额：<input type="text" class="input fb sync-bet"/></label>
                                    <button class="button parlay bet-button" data-action="parlay">下注</button>
                                    <button class="button button-secondary bet-button" data-action="reset" type="reset">
                                        重置
                                    </button>
                                </form>
                            </div>
                            <b id="j-selected-count">共<span class="j-selected-count">0</span>注</b>
                        </div>
                    </div>
                </div>
                <div id="j-zx2" class="hide clearfix" data-odds="201">
                    <div class="qxc">
                        <div>
                            <label>字现：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                        </div>
                        <div class="selected-ball" style="padding-left:40px">
                            <button class="button" data-action="add">添加号码</button>
                            <button class="button button-secondary" data-action="delete">删除选中</button>
                        </div>
                    </div>
                    <div class="qxc-info">
                        <div><select multiple="multiple"></select></div>
                        <div class="selected-ball clearfix">
                            <div class="fr">
                                <form class="form need-auth" action="">
                                    <label>每注金额：<input type="text" class="input fb sync-bet"/></label>
                                    <button class="button parlay bet-button" data-action="parlay">下注</button>
                                    <button class="button button-secondary bet-button" data-action="reset" type="reset">
                                        重置
                                    </button>
                                </form>
                            </div>
                            <b id="j-selected-count">共<span class="j-selected-count">0</span>注</b>
                        </div>
                    </div>
                </div>
                <div id="j-zx3" class="hide clearfix" data-odds="202">
                    <div class="qxc">
                        <div>
                            <label>字现：</label>
                            <i class="icon ball">0</i>
                            <i class="icon ball">1</i>
                            <i class="icon ball">2</i>
                            <i class="icon ball">3</i>
                            <i class="icon ball">4</i>
                            <i class="icon ball">5</i>
                            <i class="icon ball">6</i>
                            <i class="icon ball">7</i>
                            <i class="icon ball">8</i>
                            <i class="icon ball">9</i>
                        </div>
                        <div class="selected-ball" style="padding-left:40px">
                            <button class="button" data-action="add">添加号码</button>
                            <button class="button button-secondary" data-action="delete">删除选中</button>
                        </div>
                    </div>
                    <div class="qxc-info">
                        <div><select multiple="multiple"></select></div>
                        <div class="selected-ball clearfix">
                            <div class="fr">
                                <form class="form need-auth" action="">
                                    <label>每注金额：<input type="text" class="input fb sync-bet"/></label>
                                    <button class="button parlay bet-button" data-action="parlay">下注</button>
                                    <button class="button button-secondary bet-button" data-action="reset" type="reset">
                                        重置
                                    </button>
                                </form>
                            </div>
                            <b id="j-selected-count">共<span class="j-selected-count">0</span>注</b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt10 hide" id="trends"></div>
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
                    <span>本期下注</span>
                    <b id="j-orders">0.00</b>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="j-confirm-tpl" class="hide">
    <div class="confirm-parlay">
        <h3>您确定要下注吗？</h3>
        <ul>
            <li>{{title}}@{{lines}}</li>
            <li>共{{sum}}注，每注{{amount}}，合计<em class="lm-total">{{total}}</em></li>
        </ul>
    </div>
</div>
<script>require(['qxc-index'], function (Lottery) {
        var lotteryType = $("#current-lottery-type").text();
        if(!lotteryType){
            lotteryType='ffqxc';
        }
        new Lottery({lotteryId: lotteryType});
    });</script>
