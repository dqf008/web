<?php
isset($C_Patch) or exit('Access Denied');
$ipm = $uid?'cj/live/index.php?type=IPM':'http://sports.agin7223.com';
?>
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
        <div class="clearfix sports-banner" style="min-height:initial">
            <div class="container" style="width:1020px">
                <div class="activity-box">
                    <div class="clearfix">
                        <div style="background:url(Box/GrayCool/images/jbox-content-loading.gif) no-repeat center center">
                            <iframe width="1020" height="900" class="autoSize" frameborder="0" scrolling="no" allowtransparency="true" src="<?php echo $ipm; ?>" id="mainFrame" name="mainFrame"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>