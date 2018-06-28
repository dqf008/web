<?php
isset($C_Patch) or exit('Access Denied');
$slides = get_images('slides-web');
if(empty($slides)){
    $slides = array(
        array('img' => 'static/slides/001.png'),
        array('img' => 'static/slides/002.png'),
        array('img' => 'static/slides/003.png'),
    );
}
?>
        <div class="new-banner">
            <a href="javascript:;" class="next"></a>
            <a href="javascript:;" class="prev"></a>
            <div class="hd">
                <ul class="clearfix circle-list">
<?php foreach($slides as $key=>$val){ ?>                    <li></li>
<?php } ?>                </ul>
            </div>
            <div class="bd">
                <ul>
<?php foreach($slides as $key=>$val){ ?>                    <li class="slides"><a style="background: url(<?php echo $val['img']; ?>) no-repeat center center;"></a></li>
<?php } ?>                </ul>
            </div>
            <div class="news">
                <div class="container news-box">
                    <div class="title clearfix">
                        <div class="fl news-title">
                            <img src="static/ogmember/images/news_icon.png" >
                        </div>
                        <span>最新公告 / News</span>
                    </div>
                    <div class="news-list">
                        <div class="bd">
                            <div style="margin-top:10px;cursor:pointer;">
                            <marquee notice scrollamount="5" scrolldelay="150" direction="left" id="msgNews" onMouseOver="this.stop();" onMouseOut="this.start();" style="cursor:pointer"><?=get_last_message()?></marquee>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container new-home-txt">
            <div class="title">
                <img src="static/ogmember/images/new_home_title.jpg"/>
                <p class="cn"><?php echo $web_site['web_name']; ?>汇集了世界上最顶级的电子、视讯、足球、彩票平台；玩法多样，种类繁多；让广大玩家玩得更尽兴，更舒畅；更有首存彩金，各种游戏优惠等你来体验</p>
            </div>
            <ul class="list">
                <li>
                    <a href="javascript:;" onclick="menu_url(73)">
                        <div class="circle"><img src="static/ogmember/images/circle_content_1.png"/></div>
                        <div class="txt">
                            <p class="cn">真人视讯</p>
                            <p class="en">LIVE CASINO</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" onclick="menu_url(85)">
                        <div class="circle"><img src="static/ogmember/images/circle_content_2.png"/></div>
                        <div class="txt">
                            <p class="cn">电子游艺</p>
                            <p class="en">SLOTS</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" onclick="menu_url(4)">
                        <div class="circle"><img src="static/ogmember/images/circle_content_3.png"/></div>
                        <div class="txt">
                            <p class="cn">彩票游戏</p>
                            <p class="en">LOTTERY</p>
                        </div>
                    </a>
                </li>
                <li class="last">
                    <a href="javascript:;" onclick="menu_url(67)">
                        <div class="circle"><img src="static/ogmember/images/circle_content_4.png"/></div>
                        <div class="txt">
                            <p class="cn">优惠活动</p>
                            <p class="en">PROMOTIONS</p>
                        </div>
                    </a>
                </li>
            </ul>
            <img class="btm-img" src="static/ogmember/images/new_btm.jpg" />
        </div>
        <div class="home-tab">
            <div class="container">
                <div class="num-content clearfix">
                    <div class="top-num clearfix">
                        <div class="item">
                            <p class="en">MG超级奖池</p>
                            <p class="num">--</p>
                            <div class="line"></div>
                        </div>
                        <div class="item">
                            <p class="en">AG超级奖池</p>
                            <p class="num">--</p>
                            <div class="line"></div>
                        </div>
                        <div class="item last">
                            <p class="en">BBIN超级奖池</p>
                            <p class="num">--</p>
                            <div class="line"></div>
                        </div>
                    </div>
                    <div class="btm-list clearfix">
                        <div class="left-title"><img width="250px" src="static/ogmember/images/left-title.png" /></div>
                        <div class="right-list">
                            <div class="bd">
                                <ul style="overflow:hidden; height: 80px">
                                    <li>
                                        <span class="address">四川</span>
                                        <span class="name">geng***1515 </span>
                                        <span class="type">狂欢节</span>
                                        <span class="num">45000元</span>
                                    </li>
                                    <li>
                                        <span class="address">北京</span>
                                        <span class="name">ro***41854</span>
                                        <span class="type">古怪猴子</span>
                                        <span class="num">32000元</span>
                                    </li>
                                    <li>
                                        <span class="address">湖南</span>
                                        <span class="name">ow***23</span>
                                        <span class="type">高速公路之王</span>
                                        <span class="num">46000元</span>
                                    </li>
                                    <li>
                                        <span class="address">沈阳</span>
                                        <span class="name">bi***45</span>
                                        <span class="type">摆脱</span>
                                        <span class="num">78000元</span>
                                    </li>
                                    <li>
                                        <span class="address">四川</span>
                                        <span class="name">geng***1515 </span>
                                        <span class="type">狂欢节</span>
                                        <span class="num">45000元</span>
                                    </li>
                                    <li>
                                        <span class="address">北京</span>
                                        <span class="name">ro***41854</span>
                                        <span class="type">古怪猴子</span>
                                        <span class="num">32000元</span>
                                    </li>
                                    <li>
                                        <span class="address">湖南</span>
                                        <span class="name">ow***23</span>
                                        <span class="type">高速公路之王</span>
                                        <span class="num">46000元</span>
                                    </li>
                                    <li>
                                        <span class="address">沈阳</span>
                                        <span class="name">bi***45</span>
                                        <span class="type">摆脱</span>
                                        <span class="num">78000元</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="right-list last">
                            <div class="bd">
                                <ul style="overflow:hidden; height: 80px">
                                    <li>
                                        <span class="address">江西</span>
                                        <span class="name">wen**ie</span>
                                        <span class="type">绿巨人</span>
                                        <span class="num">15000元</span>
                                    </li>
                                    <li>
                                        <span class="address">云南</span>
                                        <span class="name">ti***988</span>
                                        <span class="type">钻石列车</span>
                                        <span class="num">28600元</span>
                                    </li>
                                    <li>
                                        <span class="address">河南</span>
                                        <span class="name">345****113</span>
                                        <span class="type">狂欢节</span>
                                        <span class="num">64223元</span>
                                    </li>
                                    <li>
                                        <span class="address">沈阳</span>
                                        <span class="name">lhfmn***88 </span>
                                        <span class="type">摆脱</span>
                                        <span class="num">41200元</span>
                                    </li>
                                    <li>
                                        <span class="address">江西</span>
                                        <span class="name">wen**ie</span>
                                        <span class="type">绿巨人</span>
                                        <span class="num">15000元</span>
                                    </li>
                                    <li>
                                        <span class="address">云南</span>
                                        <span class="name">ti***988</span>
                                        <span class="type">钻石列车</span>
                                        <span class="num">28600元</span>
                                    </li>
                                    <li>
                                        <span class="address">河南</span>
                                        <span class="name">345****113</span>
                                        <span class="type">狂欢节</span>
                                        <span class="num">64223元</span>
                                    </li>
                                    <li>
                                        <span class="address">沈阳</span>
                                        <span class="name">lhfmn***88 </span>
                                        <span class="type">摆脱</span>
                                        <span class="num">41200元</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="cirle-list clearfix">
                    <ul>
                        <li>
                            <a href="javascript:;">开户</a>
                        </li>
                        <li>
                            <a href="javascript:;">存款</a>
                        </li>
                        <li>
                            <a href="javascript:;">游戏</a>
                        </li>
                        <li>
                            <a href="javascript:;">取款</a>
                        </li>
                        <li>
                            <a href="javascript:;">帮助</a>
                        </li>
                        <li class="last">
                            <a href="javascript:;">代理</a>
                        </li>
                    </ul>
                </div> -->
                <div style="height:50px"></div>
                <div class="tab-wrap">
                    <div class="hd">
                        <ul>
                            <li>
                                <a href="javascript:;">
                                   <div class="img-wrap"><img src="static/ogmember/images/menu_slots_1.png" ></div>
                                   <div class="txt">
                                       <p class="cn">MG电子</p>
                                       <p class="en">MICROGAMING</p>
                                   </div>
                                   <img class="menu-hot" src="static/ogmember/images/menu_hot.gif"/>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                   <div class="img-wrap"><img src="static/ogmember/images/menu_slots_2.png" ></div>
                                   <div class="txt">
                                       <p class="cn">PT电子</p>
                                       <p class="en">PLAYTECH</p>
                                   </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                   <div class="img-wrap"><img src="static/ogmember/images/menu_slots_3.png" ></div>
                                   <div class="txt">
                                       <p class="cn">BBIN电子</p>
                                       <p class="en">BBINGAMING</p>
                                   </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                   <div class="img-wrap"><img src="static/ogmember/images/menu_slots_6.png" height="46"></div>
                                   <div class="txt">
                                       <p class="cn">XIN电子</p>
                                       <p class="en">XINGAMIGNG</p>
                                   </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                   <div class="img-wrap"><img src="static/ogmember/images/menu_slots_7.png" width="76" style="padding-top:12px"></div>
                                   <div class="txt">
                                       <p class="cn">NYX电子</p>
                                       <p class="en">NYXGAMING</p>
                                   </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="bd clearfix" id="homeGame">
                        <div class="items">
                            <ul>
                                <li>
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=MG'">
                                        <img class="img" src="static/ogmember/images/game/mg1.jpg" alt="">
                                        <img class="hot-game" src="static/ogmember/images/hot_game.png" alt="">
                                        <div class="txt">
                                            <p class="title">冰球突破</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=MG'">
                                        <img class="img" src="static/ogmember/images/game/mg2.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">狂欢节</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="n3">
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=MG'">
                                        <img class="img" src="static/ogmember/images/game/mg3.jpg" alt="">
                                        <img class="hot-game" src="static/ogmember/images/hot_game.png" alt="">
                                        <div class="txt">
                                            <p class="title">宝石之轮</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=MG'">
                                        <img class="img" src="static/ogmember/images/game/mg4.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">海滨嘉年华</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=MG'">
                                        <img class="img" src="static/ogmember/images/game/mg5.jpg" alt="">
                                        <img class="hot-game" src="static/ogmember/images/hot_game.png" alt="">
                                        <div class="txt">
                                            <p class="title">不朽的浪漫</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="n3">
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=MG'">
                                        <img class="img" src="static/ogmember/images/game/mg6.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">淑女派对</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <img class="items-img" src="static/ogmember/images/tab-img-2.jpg" style="right: -134px;" alt="">
                        </div>
                        <div class="items">
                            <ul>
                                <li>
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=PT'">
                                        <img class="img" src="static/ogmember/images/game/pt1.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">复仇者联盟</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=PT'">
                                        <img class="img" src="static/ogmember/images/game/pt2.jpg" alt="">
                                        <img class="hot-game" src="static/ogmember/images/hot_game.png" alt="">
                                        <div class="txt">
                                            <p class="title">神奇四侠50线</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="n3">
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=PT'">
                                        <img class="img" src="static/ogmember/images/game/pt3.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">刀锋战士</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=PT'">
                                        <img class="img" src="static/ogmember/images/game/pt4.jpg" alt="">
                                        <img class="hot-game" src="static/ogmember/images/hot_game.png" alt="">
                                        <div class="txt">
                                            <p class="title">恶灵骑士</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=PT'">
                                        <img class="img" src="static/ogmember/images/game/pt5.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">钢铁侠</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="n3">
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=PT'">
                                        <img class="img" src="static/ogmember/images/game/pt6.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">雷神</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <img class="items-img" src="static/ogmember/images/tab-img-1.jpg" style="right: -134px;" alt="">
                        </div>
                        <div class="items">
                            <ul>
                                <li>
                                    <a href="javascript:;" onclick="<?php if($uid){ ?>menu_url(80)<?php }else{ ?>alert('请登陆后操作！')<?php } ?>">
                                        <img class="img" src="static/ogmember/images/game/bbin1.jpg" alt="">
                                        <img class="hot-game" src="static/ogmember/images/hot_game.png" alt="">
                                        <div class="txt">
                                            <p class="title">连环夺宝</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="<?php if($uid){ ?>menu_url(80)<?php }else{ ?>alert('请登陆后操作！')<?php } ?>">
                                        <img class="img" src="static/ogmember/images/game/bbin2.jpg" alt="">
                                        <img class="hot-game" src="static/ogmember/images/hot_game.png" alt="">
                                        <div class="txt">
                                            <p class="title">糖果派对</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="n3">
                                    <a href="javascript:;" onclick="<?php if($uid){ ?>menu_url(80)<?php }else{ ?>alert('请登陆后操作！')<?php } ?>">
                                        <img class="img" src="static/ogmember/images/game/bbin3.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">怒火凌空</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="<?php if($uid){ ?>menu_url(80)<?php }else{ ?>alert('请登陆后操作！')<?php } ?>">
                                        <img class="img" src="static/ogmember/images/game/bbin4.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">惑星战记</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="<?php if($uid){ ?>menu_url(80)<?php }else{ ?>alert('请登陆后操作！')<?php } ?>">
                                        <img class="img" src="static/ogmember/images/game/bbin5.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">明星97</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="n3">
                                    <a href="javascript:;" onclick="<?php if($uid){ ?>menu_url(80)<?php }else{ ?>alert('请登陆后操作！')<?php } ?>">
                                        <img class="img" src="static/ogmember/images/game/bbin6.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">三国</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <img class="items-img" src="static/ogmember/images/tab-img-3.jpg" style="right: -138px;" alt="">
                        </div>
                        <div class="items">
                            <ul>
                                <li>
                                    <a href="javascript:;" onclick="menu_url(85)">
                                        <img class="img" src="static/ogmember/images/game/ag1.jpg" alt="">
                                        <img class="hot-game" src="static/ogmember/images/hot_game.png" alt="">
                                        <div class="txt">
                                            <p class="title">灵猴献瑞</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="menu_url(85)">
                                        <img class="img" src="static/ogmember/images/game/ag2.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">冰河世界</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="n3">
                                    <a href="javascript:;" onclick="menu_url(85)">
                                        <img class="img" src="static/ogmember/images/game/ag3.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">齐天大圣</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="menu_url(85)">
                                        <img class="img" src="static/ogmember/images/game/ag4.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">海盗王</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="menu_url(85)">
                                        <img class="img" src="static/ogmember/images/game/ag5.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">水果拉霸</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="n3">
                                    <a href="javascript:;" onclick="menu_url(85)">
                                        <img class="img" src="static/ogmember/images/game/ag6.jpg" alt="">
                                        <img class="hot-game" src="static/ogmember/images/hot_game.png" alt="">
                                        <div class="txt">
                                            <p class="title">性感女仆</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <img class="items-img" src="static/ogmember/images/tab-img-4.jpg" style="right: -134px;" alt="">
                        </div>
                        <div class="items">
                            <ul>
                                <li>
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=NYX'">
                                        <img class="img" src="static/ogmember/images/game/og1.jpg" alt="">
                                        <img class="hot-game" src="static/ogmember/images/hot_game.png" alt="">
                                        <div class="txt">
                                            <p class="title">PINK LADY</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=NYX'">
                                        <img class="img" src="static/ogmember/images/game/og2.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">SEXY XXX</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="n3">
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=NYX'">
                                        <img class="img" src="static/ogmember/images/game/og3.jpg" alt="">
                                        <img class="hot-game" src="static/ogmember/images/hot_game.png" alt="">
                                        <div class="txt">
                                            <p class="title">金瓶梅</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=NYX'">
                                        <img class="img" src="static/ogmember/images/game/og4.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">一路向西</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=NYX'">
                                        <img class="img" src="static/ogmember/images/game/og5.jpg" alt="">
                                        <img class="hot-game" src="static/ogmember/images/hot_game.png" alt="">
                                        <div class="txt">
                                            <p class="title">肉蒲团</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="n3">
                                    <a href="javascript:;" onclick="window.location.href='mygame.php?p=NYX'">
                                        <img class="img" src="static/ogmember/images/game/og6.jpg" alt="">
                                        <div class="txt">
                                            <p class="title">CHRISTMAS GIRL</p>
                                            <p class="star">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <img class="items-img" src="static/ogmember/images/tab-img-5.jpg" style="right: -134px;" alt="">
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="more-wrap">
                        <a href="javascript:;" onclick="menu_url(85)">更多游戏</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="home-mobile">
            <div class="container">
                <div class="left-txt">
                    <div class="top-txt">
                        <h3 class="title">随时随地 想玩就玩</h3>
                        <p class="en">Mobile Betting Introduction</p>
                    </div>
                    <p class="cn">全新模式，新颖设计更耐玩，汇集诸多精彩一一呈现；各国博彩精英、世界顶级博彩服务团队打造，享受随时随地、足不出户的博彩“游戏人生”!</p>
                    <a href="javascript:;" onclick="menu_url(71)" class="btn">查看详情</a>
                </div>
                <div class="right-img">
                    <img class="big-img" src="static/ogmember/images/mobile-img.jpg" >
                    <img class="weima" src="static/ogmember/images/weima2.png" width="75"/>
                </div>
            </div>
        </div>
        <div class="home-about">
            <div class="container">
                <div class="top-wrap">
                    <h3 class="title"><span>关于我们</span> / About us</h3>
                    <p class="cn"><?php echo $web_site['web_name']; ?>在线持牌经营博彩投注多年，是目前世界最大的网络博彩集团之一！持有菲律宾政府卡格扬经济特区 First Cagayan leisure and Resort Corporation颁发的体育博彩与线上赌场执照。网站所提供的所有产品和服务由菲律宾政府卡格扬经济特区First Cagayan leisure and Resort Corporation所授权和监管。选择我们，您将拥有可靠的资金保障和优势服务。我们对“小赌怡情，健康博彩”的宗旨非常重视。我们希望客户在投注时获得的快乐，但也希望博彩不会影响到玩家的财政状况和生活。我们不允许未满18岁的青少年参与投注和领奖。如果您未满18岁，请马上退出本站。</p>
                    <img src="static/ogmember/images/about-img.jpg"/>
                </div>
                <div class="btm-wrap">
                    <div class="circle-txt">
                        <ul>
                            <li>
                                <p class="num"><span>3</span>秒</p>
                                <p class="txt">存款到账</p>
                            </li>
                            <li>
                                <p class="num"><span>5</span>秒</p>
                                <p class="txt">取款到账</p>
                            </li>
                            <li>
                                <p class="num"><span>20</span>家</p>
                                <p class="txt">合作银行</p>
                            </li>
                            <li>
                                <p class="num"><span>6</span>家</p>
                                <p class="txt">游戏平台</p>
                            </li>
                        </ul>
                    </div>
                    <div class="data-txt">
                        <h4 class="title">网站最新数据</h4>
                        <ul>
                            <li>
                                活跃用户数
                                <div class="line">
                                    <span style="width: 65%;" class="num-bie">--</span>
                                </div>
                            </li>
                            <li>
                                累计注单量
                                <div class="line">
                                    <span style="width: 75%;" class="num-ren">--</span>
                                </div>
                            </li>
                            <li>
                                累计存提款
                                <div class="line">
                                    <span style="width: 85%;" class="num-dan">--</span>
                                </div>
                            </li>
                            <li>
                                累计派彩量
                                <div class="line">
                                    <span style="width: 95%;" class="num-money">--</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script src="static/ogmember/js/jquery.SuperSlide.2.1.1.source.js" charset="utf-8"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                jQuery(".new-banner").slide({
                    mainCell: ".bd ul",
                    titCell: '.circle-list li',
                    autoPlay: true,
                    mouseOverStop: true
                });
                jQuery(".news-list").slide({
                    mainCell: ".bd ul",
                    autoPlay: true,
                    effect: "leftMarquee",
                    interTime: 50,
                    trigger: "click"
                });
                jQuery(".tab-wrap").slide({
                    trigger: "click"
                });


                function formatNumber(num){
                    var decimalPart = "";
                    num = num.toString();
                    if(num.indexOf(".")!=-1){
                        decimalPart = "."+num.split(".")[1];
                        num = parseInt(num.split(".")[0]);
                    }
                    var array = num.toString().split("");
                    var index = -3;
                    while(array.length+index>0){
                        // 从单词的最后每隔三个数字添加逗号
                        array.splice(index, 0, ",");
                        index -= 4;
                    }
                    return array.join("")+decimalPart;
                }

                //数字效果 6-26
                var baseNum = [[3234567890, 2731231230, 2137894560], [6534000, 9313153, 479813, 24212310]];
                setInterval(function(){
                    var randomNum = new Date().getTime();
                    $(".top-num .num").each(function(){
                        var htmlNum = baseNum[0][$(this).parent().index()]+randomNum;
                        htmlNum-= 1472000000000;
                        htmlNum = htmlNum.toString();
                        htmlNum = formatNumber(htmlNum.replace(/^(\d+)(\d{2})\d{1}$/, "$1.$2"));
                        $(this).html("¥ "+htmlNum);
                    });
                    $(".data-txt li").each(function(){
                        var htmlNum = baseNum[1][$(this).index()]+randomNum;
                        switch($(this).index()){
                            case 0:
                                htmlNum-= 1474300000000;
                                htmlNum = htmlNum.toString();
                                htmlNum = formatNumber(htmlNum.replace(/^(\d+)\d{3}$/, "$1"))+" 人";
                            break;
                            case 1:
                                htmlNum-= 1474300000000;
                                htmlNum = htmlNum.toString();
                                htmlNum = formatNumber(htmlNum.replace(/^(\d+)\d{2}$/, "$1"))+" 单";
                            break;
                            case 2:
                                htmlNum-= 1474300000000;
                                htmlNum = htmlNum.toString();
                                htmlNum = formatNumber(htmlNum.replace(/^(\d+)\d{2}$/, "$1"))+" 次";
                            break;
                            case 3:
                                htmlNum-= 1473800000000;
                                htmlNum = htmlNum.toString();
                                htmlNum = formatNumber(htmlNum.replace(/^(\d+)(\d{2})\d{1}$/, "$1.$2"))+" 元";
                            break;
                        }
                        $(this).find("span").html(htmlNum);
                    });
                }, 631);
                //滚动效果 6-26
                jQuery(".right-list").slide({
                    mainCell:".bd ul",
                    autoPlay:true,
                    effect:"topMarquee",
                    vis:4,
                    interTime:50,
                    trigger:"click"
                });
            });
        </script>
        
<?php include $_SERVER['DOCUMENT_ROOT']."/extend/maintc.php";?>