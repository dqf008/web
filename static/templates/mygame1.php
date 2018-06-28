<?php
isset($C_Patch) or exit('Access Denied');
$platform = 'XIN';
isset($_GET['p'])&&in_array($_GET['p'], array('MG', 'PT', 'BG','KG'))&&$platform = $_GET['p'];
?>
        <script type="text/javascript">
            function setFrameHieght(height){
                if(parseInt(height)>0){
                    $("#mainFrame").height(height);
                    $(".game").css("height", "auto");
                    $(".loading").hide();
                }
            }
        </script>
        <style type="text/css">
            .loading div {font-size:14px;text-align:center;background:url(Box/GrayCool/images/jbox-content-loading.gif) no-repeat center 119px;padding:100px 0;line-height:18px;height:38px;width:100%}
        </style>
        <div class="banner-public electron-game">
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
        <div class="clearfix sports-banner" style="min-height:initial;background:url(static/ogmember/images/slots_banner.jpg) center top no-repeat">
	        <div class="container" style="width:1152px">
	            <div class="activity-box" style="background-color:initial">
	                <div class="clearfix" style="border:1px solid #1b1b1b;overflow:hidden">
	                    <div class="loading">
	                        <div>游戏正在加载，请您稍后...</div>
	                    </div>
	                    <div class="game" style="height:0px">
	                        <iframe name="mainFrame" id="mainFrame" src="egame/index.php?p=<?php echo $platform; ?>" width="1150" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" allowtransparency="true"></iframe>
	                        <div class="clear"></div>
	                    </div>
	                </div>
	            </div>
	        </div>
        </div>