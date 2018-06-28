<?php
isset($C_Patch) or exit('Access Denied');
$top_menu = array(
    '公司简介' => array('window.location.href=\'myabout.php?i=us\'', 'i=us'),
    '免费开户' => array('menu_url(70)', 'myreg'),
    '优惠活动' => array('menu_url(67)', 'myhot'),
    '手机投注' => array('menu_url(71)', 'mywap'),
    '联系我们' => array('window.location.href=\'myabout.php?i=contact\'', 'i=contact'),
    '在线客服' => array('openOnlineService()', 'online'),
    '历史公告' => array('window.open(\'result/noticle.php\',\'HotNewsHistory\', \'height=600,width=800,top=0, left=0,scrollbars=yes,resizable=yes\')', 'noticle'),
    '常见问题' => array('window.location.href=\'myabout.php?i=help\'', 'i=help'),
    '存款帮助' => array('window.location.href=\'myabout.php?i=deposit\'', 'i=deposit'),
    '取款帮助' => array('window.location.href=\'myabout.php?i=withdraw\'', 'i=withdraw'),
    '玩法规则' => array('window.open(\'sm/sports.php\',\'LotteryBox\', \'height=600,width=800,top=0, left=0,scrollbars=yes,resizable=yes\')', 'sports'),
    '加盟代理' => array('window.location.href=\'myabout.php?i=partner\'', 'i=partner'),
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html ng-app="portalApp" meidon-time="<?=date('Y/m/d H:i:s')?>" moment-lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="generator" content="" />
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <title><?php echo $web_site['web_name']; ?></title>
        <!-- jQuery -->
        <script type="text/javascript" src="skin/js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="static/js/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="static/ogmember/css/jquery-ui-1.9.1.custom.min.css" />
        <link rel="stylesheet" type="text/css" href="static/ogmember/css/style.css" />
        <link type="text/css" rel="stylesheet" href="Box/Green/jbox.css"/>
        <link type="text/css" rel="stylesheet" href="static/mobile-tips/mobile-tips.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <script type="text/javascript" src="/public/layer/layer.js"></script>
        <!-- Scripts -->
        <script type="text/javascript">if(self==top){location='/';}if(window.location.host!=top.location.host){top.location=window.location;}</script>
        <script type="text/javascript" src="skin/js/common.js"></script>
        <script type="text/javascript" src="skin/js/upup.js"></script>
        <script type="text/javascript" src="skin/js/float.js"></script>
        <script type="text/javascript" src="skin/js/swfobject.js"></script>
        <script type="text/javascript" src="skin/js/jquery.cookie.js"></script>
        <script type="text/javascript" src="skin/js/jingcheng.js"></script>
        <script type="text/javascript" src="skin/js/top.js?v=1"></script>
        <script type="text/javascript" src="Box/jquery.jBox-2.3.min.js"></script>
        <script type="text/javascript" src="Box/jquery.jBox-zh-CN.js"></script>
        <script type="text/javascript" src="static/js/ie-tips.js"></script>


        <style type="text/css">
        .new-menu>li:hover, .selected{
            background:none;
        }
            [ng-click]{ cursor: pointer; }
            .slides{display:none}
            #homeGame .items{display:none}
            .Popcontent { color: #1c1c1c;font-size: 15px;line-height: 20px;}
            ul.menu_main > li {
            display: block;
            float: left;
            position: relative;
        }
        .new-menu li a {padding:0;}
        .submenu {
            margin-top: -20px;
            left: 0;
            max-height: 0;
            position: absolute;
            top: 100%;
            z-index: 0;
            padding-left:0 !important;
            width:100% !important;
            -webkit-perspective: 400px;
            -moz-perspective: 400px;
            -ms-perspective: 400px;
            -o-perspective: 400px;
            perspective: 400px;
        }
        .submenu li {
            opacity: 0;
            width:100% !important;
            border-top:1px solid #edc968;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.8);
            color: #d4b979;
            cursor: pointer;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
            height:40px !important;
            line-height:40px !important;
            -webkit-transform: rotateY(90deg);
            -moz-transform: rotateY(90deg);
            -ms-transform: rotateY(90deg);
            -o-transform: rotateY(90deg);
            transform: rotateY(90deg);

            -webkit-transition: opacity .4s, -webkit-transform .5s;
            -moz-transition: opacity .4s, -moz-transform .5s;
            -ms-transition: opacity .4s, -ms-transform .5s;
            -o-transition: opacity .4s, -o-transform .5s;
            transition: opacity .4s, transform .5s;
        }
        ul.menu_main > li:hover .submenu, ul.menu_main > li:focus .submenu {
            display:block;
            max-height: 2000px;
            z-index: 999;
        }
        ul.menu_main > li:hover .submenu li, ul.menu_main > li:focus .submenu li {
            opacity: 1;
            -webkit-transform: none;
            -moz-transform: none;
            -ms-transform: none;
            -o-transform: none;
            transform: none;
        }

        ul.menu_main > li:hover .submenu li:nth-child(1) {
            -webkit-transition-delay: 0s;
            -moz-transition-delay: 0s;
            -ms-transition-delay: 0s;
            -o-transition-delay: 0s;
            transition-delay: 0s;
        }
        ul.menu_main > li:hover .submenu li:nth-child(2) {
            -webkit-transition-delay: 50ms;
            -moz-transition-delay: 50ms;
            -ms-transition-delay: 50ms;
            -o-transition-delay: 50ms;
            transition-delay: 50ms;
        }
        ul.menu_main > li:hover .submenu li:nth-child(3) {
            -webkit-transition-delay: 100ms;
            -moz-transition-delay: 100ms;
            -ms-transition-delay: 100ms;
            -o-transition-delay: 100ms;
            transition-delay: 100ms;
        }
        ul.menu_main > li:hover .submenu li:nth-child(4) {
            -webkit-transition-delay: 150ms;
            -moz-transition-delay: 150ms;
            -ms-transition-delay: 150ms;
            -o-transition-delay: 150ms;
            transition-delay: 150ms;
        }
        ul.menu_main > li:hover .submenu li:nth-child(5) {
            -webkit-transition-delay: 200ms;
            -moz-transition-delay: 200ms;
            -ms-transition-delay: 200ms;
            -o-transition-delay: 200ms;
            transition-delay: 200ms;
        }
        ul.menu_main > li:hover .submenu li:nth-child(6) {
            -webkit-transition-delay: 250ms;
            -moz-transition-delay: 250ms;
            -ms-transition-delay: 250ms;
            -o-transition-delay: 250ms;
            transition-delay: 250ms;
        }
        ul.menu_main > li:hover .submenu li:nth-child(7) {
            -webkit-transition-delay: 300ms;
            -moz-transition-delay: 300ms;
            -ms-transition-delay: 300ms;
            -o-transition-delay: 300ms;
            transition-delay: 300ms;
        }
        ul.menu_main > li:hover .submenu li:nth-child(8) {
            -webkit-transition-delay: 350ms;
            -moz-transition-delay: 350ms;
            -ms-transition-delay: 350ms;
            -o-transition-delay: 350ms;
            transition-delay: 350ms;
        }
        ul.menu_main > li:hover .submenu li:nth-child(9) {
            -webkit-transition-delay: 400ms;
            -moz-transition-delay: 400ms;
            -ms-transition-delay: 400ms;
            -o-transition-delay: 400ms;
            transition-delay: 400ms;
        }
        ul.menu_main > li:hover .submenu li:nth-child(10) {
            -webkit-transition-delay: 450ms;
            -moz-transition-delay: 450ms;
            -ms-transition-delay: 450ms;
            -o-transition-delay: 450ms;
            transition-delay: 450ms;
        }
        ul.menu_main > li:hover .submenu li:nth-child(11) {
            -webkit-transition-delay: 500ms;
            -moz-transition-delay: 500ms;
            -ms-transition-delay: 500ms;
            -o-transition-delay: 500ms;
            transition-delay: 500ms;
        }
        ul.menu_main > li:hover .submenu li:nth-child(12) {
            -webkit-transition-delay: 550ms;
            -moz-transition-delay: 550ms;
            -ms-transition-delay: 550ms;
            -o-transition-delay: 550ms;
            transition-delay: 550ms;
        }

        .highlight
        {
            color:red;
            font-weight:bold;
            animation:myfirst 1s;
            animation-iteration-count: infinite;
        }

        .highlight2
        {
            color:yellow;
            font-weight:bold;
            animation:myfirst2 1s;
            animation-iteration-count: infinite;
        }

        @keyframes myfirst
        {
            0%   {color: red;}
            50%  {color: yellow;}
            100% {color: red;}
        }
        @keyframes myfirst2
        {
            0%   {color: yellow;}
            50%  {color: red;}
            100% {color: yellow;}
        }
        </style>
    </head>
    <body ng-controller="LayoutCtrl">
        <div id="iealert" style="display:none;">
            <div class="iealertMain">
                <a href="http://browsehappy.com/" target="_blank">您所使用的浏览器不能被网站很好的支持，为了您能获得更好的浏览体验推荐您升级浏览器访问本网站。</a>
                <div id="iealertX" style="cursor: pointer; position:absolute;top: 0px;right: 5px">×</div>
            </div>
            <div style="width:100%;height:25px;">&nbsp;&nbsp;</div>
        </div>
        <div class="new-header">
            <div class="head-top clearfix">
                <div class="container top">
                    <div class="fl clearfix choose-lang new-choose-lang">
                        <ul class="fl clearfix">
                            <li><a href="javascript:;"></a></li>
                            <li><a class="choose-lang-2" href="javascript:;"></a></li>
                            <li><a class="choose-lang-3" href="javascript:;"></a></li>
                        </ul>
<?php if($uid):?><p class="fl" style="margin:0 0 0 5px">欢迎您，<a href="javascript:;" onClick="tourl(301)"><?=$_SESSION['username']?></a>！</p><?php endif; ?>                        <p class="fl" ng-bind="meiDonNow | dateTime"></p>
                    </div>
                    <ul class="fr clearfix top-menu">
                        <li><a class="first-link" href="/agent/"  target="_blank" style="color:#42a5f5;">代理加盟</a></li>
                        <li><a class="color-yellow" href="javascript:;" onClick="window.location.href='myabout.php?i=help'">常见问题</a></li>
<?php if($uid): ?>                        
    <li><a class="color-yellow" href="javascript:;" onClick="menu_url(13);return false">下注记录</a></li>
    <li><a style="color: #24da44;" href="javascript:;" onClick="menu_url(14);return false">历史报表</a></li>
<?php else: ?>
    <li><a style="color: #24da44;" href="javascript:;" onClick="window.location.href='myabout.php?i=partner'">加盟代理</a></li>
<?php endif; ?>                        
    <li><a href="javascript:;">请按Ctrl+D键收藏</a></li>
                    </ul>
                </div>
            </div>
            <div class="head-menu">
                <div class="container clearfix">
                    <div class="fl">
                        <a href="javascript:;" onClick="menu_url(1)"><img class="logo" src="static/ogmember/images/logo_new.png" height="73" width="297" /></a>
                    </div>
                    <ul class="menu_main new-menu fl" ng-controller="LobbiesCtrl">
                        <li class="active" style="border: none;width: 97px">
                            <a href="javascript:;" onClick="menu_url(1)">
                                <p class="cn">网站首页</p>
                                <p class="en">HOME</p>
                            </a>
                        </li>
                        <li class="sub-lottery" style="width: 97px" ng-controller="LobbiesCtrl">
                            <a href="javascript:;" ng-click="toKy()">
                                <p class="cn" style="color: rgb(254, 209, 57);">棋牌游戏</p>
                                <p class="en" style="color: rgb(254, 209, 57);">CLASS</p>
                                <span class="menu-hot"><img src="static/ogmember/images/menu_hot.gif"></span>
                            </a>
                            <ul class="submenu" style="left:-50%;">
                                <li><a ng-click="toKy(830)">抢庄牛牛</a></li>
                                <li><a ng-click="toKy(220)">炸金花</a></li>
                                <li><a ng-click="toKy(230)">极速炸金花</a></li>
                                <li><a ng-click="toKy(620)">德州扑克</a></li>
                                <li><a ng-click="toKy(870)">通比牛牛</a></li>
                                <li><a ng-click="toKy(610)">斗地主</a></li>
                                <li><a ng-click="toKy(630)">十三水</a></li>
                            </ul>
                            <ul class="submenu" style="left:50%;">
                                <li><a ng-click="toKy(720)">二八杠</a></li>
                                <li><a ng-click="toKy(730)">抢庄牌九</a></li>
                                <li><a ng-click="toKy(860)">三公</a></li>
                                <li><a ng-click="toKy(600)">21点</a></li>
                                <li><a ng-click="toKy(900)">押庄龙虎</a></li>
                                <li><a ng-click="toKy(380)">幸运五张</a></li>
                                <li><a ng-click="toKy(880)">欢乐红包</a></li>
                            </ul>
                        </li>
                        <li class="sub-game" style="width: 97px">
                            <a class="red" href="javascript:;" onClick="menu_url(85)">
                                <p class="cn" style="color: rgb(254, 209, 57);">电子游艺</p>
                                <p class="en" style="color: rgb(254, 209, 57);">SLOTS</p>
                                <span class="menu-hot"><img src="static/ogmember/images/menu_hot.gif"></span>
                            </a>
                            <ul class="submenu">
                                <li class="highlight2" ng-click="toFish()">捕鱼达人</li>
                                <li class="highlight" ng-click="toKg()">AV女优</li>
                                <li ng-click="toMg()">新MG电子</li>
                                <li ng-click="toCq9()">CQ9电子</li>
                                <li ng-click="toMw()">MW电子</li>
                                <li ng-click="toYoplay()">AG街机</li>
                                <li ng-click="toXin()">XIN电子</li>
                                <li ng-click="toPt()">PT电子</li>
                                <li ng-click="toBg()">BG电子</li>
                                <li ng-click="toBb()">BBIN电子</li>
                            </ul>
                            <ul class="submenu">
                                <li class="highlight2" ng-click="toFish()">捕鱼达人</li>
                                <li class="highlight" ng-click="toKg()">AV女优</li>
                                <li ng-click="toMg()">新MG电子</li>
                                <li ng-click="toCq9()">CQ9电子</li>
                                <li ng-click="toMw()">MW电子</li>
                                <li ng-click="toYoplay()">AG街机</li>
                                <li ng-click="toXin()">XIN电子</li>
                                <li ng-click="toPt()">PT电子</li>
                                <li ng-click="toBg()">BG电子</li>
                                <li ng-click="toBb()">BBIN电子</li>
                            </ul>
                        </li>
                        <li class="sub-live" style="width: 97px">
                            <a href="javascript:;" onClick="menu_url(73)">
                                <p class="cn">真人视讯</p>
                                <p class="en">LIVE CASINO</p>
                                <span class="menu-green"><img src="static/ogmember/images/menu_hot.gif"></span>
                            </a>
                            <ul class="submenu">
                                <li class="highlight" ng-click="toLive('AGIN')">AG国际厅</li>
                                <li class="highlight2" ng-click="toLive('AG')">AG极速厅</li>
                                <li ng-click="toLive('BG')">BG视讯</li>
                                <li ng-click="toLive('SB')">申博梦幻厅</li>
                                <li ng-click="toLive('MAYA')">玛雅娱乐厅</li>
                                <li ng-click="toLive('BBIN2&gameType=LIVE')">BBIN旗舰厅</li>
                                <li ng-click="toLive('OG2')">OG东方厅</li>
                                <li ng-click="toLive('DG')">DG视讯</li>
                            </ul>
                        </li>
                        <li class="sub-sports" style="width: 97px">
                            <a href="javascript:;" onClick="menu_url(2)">
                                <p class="cn">体育赛事</p>
                                <p class="en">SPORTS</p>
                            </a>
                            <ul class="submenu">
                                <li class="highlight" onClick="menu_url(2)">皇冠体育</li>
                                <li ng-click="toLive('SHABA')">SB体育</li>
                                <li ng-click="toLive('BBIN2&gameType=sport')">BB体育</li>
                                <li ng-click="toLive('AGIN&gameType=SBTA')">AG体育</li>
                            </ul>
                        </li>
                        <li class="sub-lottery" style="width: 97px">
                            <a href="javascript:;" onClick="menu_url(68)">
                                <p class="cn">彩票游戏</p>
                                <p class="en">LOTTERY</p>
                            </a>
                            <ul class="submenu">
                                <li class="highlight" onclick="menu_url(3)">六合彩</li>
                                <li class="highlight2" onclick="menu_url(4)">重庆时时彩</li>
                                <li onclick="tourl(209)">极速赛车</li>
                                <li onclick="tourl(210)">极速时时彩</li>
                                <li onclick="tourl(211)">极速六合彩</li>
                                <li ng-click="toLotteryVr()">VR彩票</li>
                                <li ng-click="toLive('BBIN2&gameType=lottery')">BB彩票</li>
                                <li onclick="menu_url(19)">北京赛车</li>
                                <li onclick="menu_url(102)">幸运飞艇</li>
                                <li onclick="menu_url(18)">广东10分</li>
                            </ul>
                        </li>
                        <li style="width: 97px">
                            <a class="red" href="javascript:;" onClick="menu_url(67)">
                                <p class="cn" style="color: rgb(254, 209, 57);">优惠活动</p>
                                <p class="en" style="color: rgb(254, 209, 57);">PROMOTIONS</p>
                                <span class="menu-hot"><img src="static/ogmember/images/menu_hot.gif"></span>
                            </a>
                        </li>
                         
                        <li class="last" style="width: 97px">
                            <a href="javascript:;" onClick="openOnlineService()">
                                <p class="cn">在线客服</p>
                                <p class="en">SERVICE</p>
                            </a>
                        </li>
                        <!-- <li class="active-line" style="left: 10px;"></li> -->
                    </ul>
                </div>
            </div>
            <div class="head-login">
                <div class="container" style="position: relative;">
<?php if($uid){ ?>                    <div class="login-on">
                        <span class="wb" style="color:#fff">体育/彩票余额：<a href="javascript:;" id="user_money">0.00</a>，<a href="app/#/member/finance/transfer" target="_blank">查看真人余额</a></span>
                        <a class="btn btn-yellow" href="javascript:;" onClick="menu_url(17)">退出账户</a>
                        <span class="wb1"><a href="app/#/member/index" target="_blank">会员中心</a>|<?php if($_SESSION["is_daili"]){ ?><a href="agent/jump.php?go=http%3A%2F%2F9014.cc" target="_blank">代理中心</a><?php }else{ ?><a href="agent/jump.php?go=http%3A%2F%2F9014.cc" target="_blank">申请代理</a><?php } ?>|<a href="app/#/member/finance/deposit" target="_blank">线上存款</a>|<a href="app/#/member/finance/withdraw" target="_blank">线上取款</a>|<a href="app/#/member/finance/transfer" target="_blank">额度转换</a>|<a href="app/#/member/notice" target="_blank">未读讯息（<span id="user_num">0</span>）</a></span>
                    </div>
<?php }else{ ?>                    <div class="left-txt">
                        <img src="static/ogmember/images/login_arrow.jpg">
                        用户登录 / login
                    </div>
                    <form class="login-wrap" name="LoginForm" id="LoginForm" action="#" method="POST" onSubmit="return aLeftForm1Sub();" autocomplete="off">
                        <input type="hidden" name="uid2" value="guest" />
                        <input type="hidden" name="SS" value="" />
                        <input type="hidden" name="SR" value="" />
                        <input type="hidden" name="TS" value="" />
                        <div class="form-group" style="position:relative">
                            <img src="static/ogmember/images/login_user.jpg">
                            <input class="form-control" name="username" tabindex="1" type="text" id="username" maxlength="15" placeholder="帐号" title="请填写 4-15 位大小写英数字" maxlength="15" pattern="[a-zA-Z0-9]{4,15}" required="true" />
                           
                        </div>
                        <div class="form-group">
                            <img src="static/ogmember/images/login_password.jpg">
                            <input class="form-control" name="passwd" tabindex="2" type="password" id="passwd" placeholder="密码" maxlength="20" title="请填写 6-12 位字符" pattern=".{6,20}" required="true" />
                            <input class="form-control" type="text" value="密码" style="display:none" />
                        </div>
                        <div class="form-group" style="height:22px;">
                            <input class="form-control" name="rmNum" tabindex="3" type="text" id="rmNum" maxlength="4" placeholder="验证码" title="请填写 4-15 位大小写英数字" pattern="\d{4}" required="true" onFocus="getKey();" />
                            <img onClick="$('#rmNum').focus();" class="yzmimg" id="vPic" style="margin-left:-30px;cursor:pointer;background-color:#1279e2;width:50px;height:20px" />
                        </div>
                        <input class="btn btn-red" value="立即登录" type="submit" style="cursor:pointer"/>
                        <a class="btn btn-yellow" href="javascript:;" onClick="menu_url(70)">免费开户</a>
                        <a href="javascript:;" ng-click="pwdforget()" class="link">忘记密码<img src="static/ogmember/images/red_arrow.jpg" /></a>
                    </form>

<?php } ?>                    <img src="static/ogmember/images/head-address.png" class="head-address" style="top: 42px;">
                </div>
            </div>
        </div>
        <script src="static/ogmember/js/code.js" charset="utf-8"></script>
        <script type="text/javascript">
            // $("li.LS-ball, li.LS-live, li.LS-game, li.LS-lottery, li.LS-ag").subTabs();
            // toggleColor(".textGlitterl", ["#fff", "#f00"], 600);
            // 导航下拉
            // $(function(){
            //     $('#menu').find('li').mouseover(function(){
            //         $(this).addClass('hover');
            //         $(this).find('.nav-drop').show();
            //     });
            //     $('#menu').find('li').mouseout(function(){
            //         $(this).removeClass('hover');
            //         $(this).find('.nav-drop').hide();
            //     });
            // });
            // $(window).scroll(function () {
            //     if ($('.top-notice').length != 0) {//检测顶部是否有维护信息
            //         if ($(window).scrollTop() > 30) {
            //             $('.header').addClass("fxd");
            //         }else{
            //             $('.header').removeClass("fxd");
            //         }
            //     }else{
            //         if ($(window).scrollTop() != 0) {
            //             $('.header').addClass("fxd");
            //         }else{
            //             $('.header').removeClass("fxd");
            //         }
            //     }
            // });
            function getKey() {
                $("#vPic").attr("src",'yzm.php?_='+Math.random()+(new Date).getTime());
                $("#vPic").show();
                $("#vPic").css("display","inline");
                $("input[name='rmNum']").val("");
            }
            var tryGame = function(gameType){
                var truURI = "cj/live/index.php?type=AGIN&try=true";
                if(typeof(gameType)!="undefined"){
                    truURI = truURI+"&gameType="+gameType;
                }
                f_com.bm(truURI, 'CASINO', {toolbar:'no',location:'no',directories:'no',menubar:'no',resizable:'no',top:'2',width:'1200',height:'760'});
                return false;
            };
<?php if($uid): ?>            
    function top_money(){
                $.getJSON("/top_money_data.php?callback=?", function(json){
                    if(json.status==1){
                        if(json.user_num>parseInt($("#user_num").html())){
                            PopMessage(json.user_num);
                        }
                        $("#tz_money").html(json.tz_money);
                        $("#user_money").html(json.user_money);
                        $("#user_num").html(json.user_num);
                    }else{
                        window.location.reload();
                    }
                });
            }
            $(document).ready(function(){
                top_money();
                //setInterval("top_money()",5000);
            });
            var liveClick = function(liveType, isBlank){
                //window.open('/lunch/?type='+liveType, '_blank');
                if(isBlank){
                    window.open('cj/live/index.php?type='+liveType, '_blank');
                }else{
                    f_com.bm('cj/live/index.php?type='+liveType, 'CASINO', {toolbar:'no',location:'no',directories:'no',menubar:'no',resizable:'no',top:'2',width:'1200',height:'760'});
                }
                return false;
            }; 
<?php else: ?>            var liveClick = function(){
                if(confirm('您还没有登陆游戏，是否进入AG试玩厅？')){
                    tryGame();
                }
                return false;
            }; 
<?php endif; ?>        
</script>