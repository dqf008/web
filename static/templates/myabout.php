<?php
isset($C_Patch) or exit('Access Denied');
$about_list = array(
    'us' => array('公司简介', 'ABOUT US'),
    'contact' => array('联系我们', 'CONTACT'),
    'help' => array('常见问题', 'HELP'),
    'deposit' => array('存款帮助', 'DEPOSIT'),
    'withdraw' => array('取款帮助', 'WITHDRAW'),
    'partner' => array('加盟代理', 'PARTNER'),
);
$about_code = isset($_GET['i'])&&isset($about_list[$_GET['i']])?$_GET['i']:'us';
$about_rows = get_webinfo_bycode('about-'.$about_code);
?>
        <style type="text/css">
            .right-text {color:#C0C0C0}
            .right-text table{margin-top:10px;width:100%;border:1px solid #7c7777;border-width:1px 0 0 1px;}
            .right-text table td{border:1px solid #7c7777;border-width:0 1px 1px 0;padding:3px 0;text-align:center}
        </style>
        <div class="banner-public about-us">
            <div class="news">
                <div class="container news-box">
                    <div class="title clearfix">
                        <div class="fl news-title"><img src="static/ogmember/images/news_icon.png" /></div>
                        <span>最新公告 / News</span>
                    </div>
                    <div class="news-list">
                        <div class="bd">
                            <div id="memberLatestAnnouncement" style="margin-top:10px;cursor:pointer;"><marquee notice scrollamount="5" scrolldelay="150" direction="left" id="msgNews" onMouseOver="this.stop();" onMouseOut="this.start();" style="cursor:pointer"><?php echo get_last_message(); ?></marquee></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="fl">
                <div class="inside-main clearfix">
                    <div class="left-nav">
                        <div class="left-title"><img src="static/ogmember/images/about_title.png"></div>
                        <ul class="left-navList">
<?php $last_title = array_keys($top_menu);$last_title = array_pop($last_title);$last_menu = array_pop($top_menu);foreach($top_menu as $_title=>$_link){ ?>                            <li<?php echo strpos($_SERVER['REQUEST_URI'], $_link[1])?' class="active"':''; ?>>
                                <div></div>
                                <a href="javascript:;" onclick="<?php echo $_link[0]; ?>"><?php echo $_title; ?><i class="triangle"></i></a>
                            </li>
<?php } ?>                            <li class="last <?php echo strpos($_SERVER['REQUEST_URI'], $last_menu[1])?'active':''; ?>">
                                <div></div>
                                <a href="javascript:;" onclick="<?php echo $last_menu[0]; ?>"><?php echo $last_title; ?><i class="triangle"></i></a>
                            </li>
                        </ul>
                        <img class="po-img" src="static/ogmember/images/discount.jpg" />
                    </div>
                </div>
            </div>
            <div class="fr">
                <div class="right-content">
                    <div class="right-content-wdt">
                        <h3 class="right-content-title"><?php echo $about_list[$about_code][0]; ?><span>/ <?php echo $about_list[$about_code][1]; ?></span></h3>
                        <div class="right-text">
                            <div><?php echo stripcslashes($about_rows['content']); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
