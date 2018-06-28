<?php
isset($C_Patch) or exit('Access Denied');
if(1){
?>
        <style type="text/css">
            .loading div {font-size:14px;text-align:center;background:url(Box/GrayCool/images/jbox-content-loading.gif) no-repeat center 119px;padding:100px 0;line-height:18px;height:38px;width:100%}
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                setInterval(function(){
                    mainheight = $("#mainFrame").contents().find("body").height();
                    if(parseInt(mainheight)<500){
                        mainheight = 500;
                    }
                    $("#mainFrame").height(mainheight);
                    if(parseInt(mainheight)>0){
                        $(".game").css("height", "auto");
                        $(".activity-box").css("border", "none");
                        $(".loading").hide();
                    }
                }, 500);
            });
        </script>
        <div class="banner-public lottery-game">
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
        <div class="container" style="width:1000px">
            <div class="activity-box">
                <div class="clearfix">
                    <div class="loading">
                        <div>游戏正在加载，请您稍后...</div>
                    </div>
                    <div class="game" style="height:0px;overflow:hidden">
                        <iframe class="autoSize" frameborder="0" scrolling="no" allowtransparency="true" src="lot/?i=marksix" width="1000" height="0" id="mainFrame" name="mainFrame"></iframe>
                    </div>
                </div>
            </div>
        </div>
<?php }else{ ?>
        <style type="text/css">
            .loading div {font-size:14px;text-align:center;background:url(Box/GrayCool/images/jbox-content-loading.gif) no-repeat center 119px;padding:100px 0;line-height:18px;height:38px;width:100%}
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                setInterval(function(){
                    mainheight = $("#mainFrame").contents().find("body").height();
                    leftheight = $("#leftFrame").contents().find("body").height()+1;
                    $("#mainFrame").height(mainheight+20);
                    $("#leftFrame").height(leftheight);
                    if(parseInt(mainheight)>0&&parseInt(leftheight)>0){
                        $(".game").css("height", "auto");
                        $(".loading").hide();
                    }
                }, 500);
            });
        </script>
        <div class="banner-public lottery-game">
            <div class="news">
                <div class="container news-box">
                    <div class="title clearfix">
                        <div class="fl news-title"><img src="static/ogmember/images/news_icon.png" /></div>
                        <span>最新公告 / News</span>
                    </div>
                    <div class="news-list">
                        <div class="bd">
                            <div id="memberLatestAnnouncement" style="margin-top:10px;cursor:pointer;"><marquee scrollamount="5" scrolldelay="150" direction="left" id="msgNews" onMouseOver="this.stop();" onMouseOut="this.start();" style="cursor:pointer"><?php echo get_last_message(); ?></marquee></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style="width:1015px">
            <div class="activity-box">
                <div class="clearfix">
                    <div class="loading">
                        <div>游戏正在加载，请您稍后...</div>
                    </div>
                    <div class="game" style="height:0px;overflow:hidden;background-color:#fff">
                        <div style="width:180px;float:left;overflow-x:hidden;padding:10px 0 10px 20px">
                            <iframe class="autoSize" frameborder="0" scrolling="no" allowtransparency="true" src="lotto/left.php" width="180" height="650" id="leftFrame" name="leftFrame"></iframe>
                        </div>
                        <div style="width:812px;float:right;overflow-x:hidden">
                            <iframe class="autoSize" frameborder="0" scrolling="no" allowtransparency="true" src="lotto/index.php?action=<?php echo $aa; ?>" width="812" height="650" id="mainFrame" name="mainFrame"></iframe>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
<?php } ?>