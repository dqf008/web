<?php isset($C_Patch) or exit('Access Denied'); ?>
       
        <div class="banner-public person">
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
        <div class="clearfix sports-banner" style="min-height:initial;background:url('/static/ogmember/images/live_banner.jpg');background-color: #181818;background-repeat: no-repeat;">
            <div class="container person-block">
                <div class="live" style="width:1000px;margin:0 auto">
                    <style>.loading {font-size:14px;text-align:center;background:url(/Box/GrayCool/images/jbox-content-loading.gif) no-repeat center 119px;padding:100px 0;line-height:18px;height:38px;width:100%}</style>
        <script src="https://cdn.jsdelivr.net/npm/pym.js@1.3.2/dist/pym-loader.v1.min.js"></script>
        <div data-pym-src="/live/"><div class="loading">游戏正在加载，请您稍后...</div></div>
                </div>
            </div>
        </div>