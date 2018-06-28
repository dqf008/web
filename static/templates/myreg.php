<?php
isset($C_Patch) or exit('Access Denied');
$about_rows = get_webinfo_bycode('about-signup');
?>
        <style type="text/css">
            .right-text p {color:#C0C0C0}
            .right-text i {color:#FF9900;font-weight:bold}
        </style>
        <script type="text/javascript">
            $(document).ready(function() {
                setInterval(function(){
                    mainheight = $("#regFrame").contents().find("body").height()+30;
                    $("#regFrame").height(mainheight);
                }, 500);
            });
        </script>
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
<?php 
$ss = array_keys($top_menu);
$last_title = array_pop($ss);
$last_menu = array_pop($top_menu);
foreach($top_menu as $_title=>$_link){ 
?>                            
    <li<?php echo strpos($_SERVER['REQUEST_URI'], $_link[1])?' class="active"':''; ?>>
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
                        <h3 class="right-content-title">免费开户<span>/ SIGN UP</span><span style="color:#1b1b1b">REGISTER</span></h3>
                        <div class="right-text">
                            <div style="width:680px;margin:0 auto"><?php echo stripcslashes($about_rows['content']); ?></div>
                            <div style="width:730px;margin:0 auto;padding-top:30px">
                                <iframe name="regFrame" id="regFrame" width="730" height="650" scrolling="no" frameborder="0" src="zhuces.php" allowtransparency="true"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>