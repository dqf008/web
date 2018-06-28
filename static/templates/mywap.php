<?php isset($C_Patch) or exit('Access Denied'); ?>
        <style type="text/css">
            .welcome {color:#24da44;line-height:40px;font-size:14px;text-align:center;border:1px solid #1b1b1b;background-color:#333}
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                setInterval(function(){
                    $(".welcome").toggleClass("color-yellow");
                }, 250);
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
        <div class="container" style="width:1040px">
            <div class="activity-box">
                <div class="clearfix">
                    <div class="welcome">欢迎使用<?php echo $web_site['web_name']; ?>手机版</div>
                    <div style="width:1040px;height:583px;background:url('static/images/mobile1.png') center no-repeat">
                        <!-- <div style="width:395px;height:359px;background:url('static/images/mobile4.png') center no-repeat;float:right"></div> -->
                    </div>
                    <div style="width:1040px;height:514px;background:url('static/images/mobile2.png') no-repeat"></div>
                    <div style="width:1040px;height:420px;background:url('static/images/mobile3.png') no-repeat"></div>
                </div>
            </div>
        </div>