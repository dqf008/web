<?php isset($C_Patch) or exit('Access Denied'); ?>
<?
    //早盘星期数 日期
    $date_str = "";
    $w = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
    for($i=1;$i<=14;$i++){//两周 
        $strtime   = strtotime("+".$i." day");
        $date_str .= "'".date("Y-m-d",$strtime);
        $date_str .= "-".$w[date("w",$strtime)]."',";
    }
    $date_str = rtrim($date_str,',');
    //综合过关
    $date_str1 = "";
    for($i=0;$i<14;$i++){//两周 
        $strtime   = strtotime("+".$i." day");
        $date_str1 .= "'".date("Y-m-d",$strtime);
        $date_str1 .= "-".$w[date("w",$strtime)]."',";
    }

    $date_str1 = rtrim($date_str1,',');
?>
        <style type="text/css">
            .loading div {font-size:14px;text-align:center;background:url(Box/GrayCool/images/jbox-content-loading.gif) no-repeat center 119px;padding:100px 0;line-height:18px;height:38px;width:100%}
            
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                //设置默认打开栏目
                top.t_type = 'today';
                top.w_type = 'FT';
                top.select = 'wtype_FT_r';
                top.gunqiu = '';

                //记录点击后的ID
                top.lastidName = '';
                //记录点击后串关的ID;
                top.lastParlayID = new Array();

                top.uid = '';
                top._session={"FTi0":"全场","FTi1":"上半","BKi0":"全场","BKi8":"上半","BKi9":"下半","BKi3":"第1节","BKi4":"第2节","BKi5":"第3节","BKi6":"第4节","BSi0":"全场","FSi0":"全场","OPi0":"全场","TNi0":"全场","TNi1":"第一盘","TNi2":"第二盘","TNi3":"第三盘","TNi4":"第四盘","TNi5":"第五盘","TNi6":"让局","TNi7":"主队局数","TNi8":"客队局数","VBi0":"全场","VBi1":"局数","VBi2":"分数","VBi3":"第一局","VBi4":"第二局","VBi5":"第三局","VBi6":"第四局","VBi7":"第五局","VBi8":"第六局","VBi9":"第七局","BMi0":"全场","BMi1":"分数","BMi2":"第一局","BMi3":"第二局","BMi4":"第三局","BMi5":"第四局","BMi6":"第五局","BMi7":"第六局","BMi8":"第七局","TTi0":"全场"};
                top.str_BK_MS=["","上半场","下半场","第一节","第二节","第三节","第四节"];
                /*conf_top._session_sk_rf(35)*/
                top._session_sk_rf={"01":" - 第1局","02":" - 第2局","03":" - 第3局","04":" - 第4局","05":" - 第5局","06":" - 第6局","07":" - 第7局","08":" - 第8局","09":" - 第9局","10":" - 第10局","11":" - 第11局","12":" - 第12局","13":" - 第13局","14":" - 第14局","15":" - 第15局","16":" - 第16局","17":" - 第17局","18":" - 第18局","19":" - 第19局","20":" - 第20局","21":" - 第21局","22":" - 第22局","23":" - 第23局","24":" - 第24局","25":" - 第25局","26":" - 第26局","27":" - 第27局","28":" - 第28局","29":" - 第29局","30":" - 第30局","31":" - 第31局","32":" - 第32局","33":" - 第33局","34":" - 第34局","35":" - 第35局"};

                /*conf_top._best_sk(35)*/
                top._best_sk={"1":"一盘制","2":"两盘制","3":"三盘两胜","4":"四盘制","5":"五盘三胜","6":"六盘制","7":"七盘四胜","8":"八盘制","9":"九盘五胜","10":"十盘制","11":"十一盘六胜","12":"十二盘制","13":"十三盘制","14":"十四盘制","15":"十五盘制","16":" 十六盘制","17":"十七盘九胜","18":"十八盘制","19":"十九盘十胜","20":"二十盘制","21":"二十一盘制","22":"二十二盘制","23":"二十三盘制","24":"二十四盘制","25":"二十五盘十三胜","26":"二十六盘制","27":"二十七盘制","28":"二十八盘制","29":"二十九盘制","30":"三十盘制","31":"三十一盘制","32":"三十二盘制","33":"三十三盘十七胜","34":"三十四盘制","35":"三十五盘十八胜"};


                top.DateAry  = new Array(<?=$date_str?>);
                top.DateAry_zh  = new Array(<?=$date_str1?>);

                top._date={"m1":"01月","m2":"02月","m3":"03月","m4":"04月","m5":"05月","m6":"06月","m7":"07月","m8":"08月","m9":"09月","m10":"10月","m11":"11月","m12":"12月","Mon":"星期一","Tue":"星期二","Wed":"星期三","Thu":"星期四","Fri":"星期五","Sat":"星期六","Sun":"星期日"};


                top.gtypeAry = new Array("FT","BK","TN","VB","BS","OP","TT","BM","SK");
                var myLove = top.gtypeAry;
                for(var i=0;i<myLove.length;i++){
                    myLove[myLove[i]] = new Array();
                }
                top.myLove = myLove;
                
                var numsss = new Array("today","early","parlay","live");
                numsss["today"] = new Array(0,0,0,0,0,0,0,0,0);//今日赛事统计
                numsss["early"] = new Array(0,0,0,0,0,0,0,0,0);//早盘赛事统计
                numsss["parlay"] = new Array(0,0,0,0,0,0,0,0,0);//过关赛事统计
                numsss["live"] = new Array(0,0,0,0,0,0,0,0,0);//滚球赛事统计
                top.hgNum = numsss;
                top.unsettled = new Array();//未结算注单
                top.settled = new Array();//今日结算注单

                setInterval(function(){
                    var mainBody = $("#mainFrame").contents().find("body");
                    var leftBody = $("#leftFrame").contents().find("body");
                    var mainHeight = mainBody.height();
                    var leftHeight = leftBody.height();
                    if(parseInt(mainHeight)>0){
                        $("#mainFrame").height(mainHeight);
                        
                        $("#leftFrame").height($(window).height());
                        leftBody.css('color','#503F32');
                        $(".game").css("height", "auto");
                        $(".loading").hide();
                    }
	                var paddingTop = parseInt($(".game").find("div").eq(0).css("padding-top"));
	                mainHeight = parseInt($(".game").find("div").eq(1).height());
	                leftHeight = parseInt($(".game").find("div").eq(0).height());
	                if(paddingTop>0&&paddingTop>mainHeight){
	                    $("html, body").animate({scrollTop: $(".game").offset().top}, "fast");
	                    $(".game").find("div").eq(0).stop().animate({paddingTop: 0}, "fast");
	                }else if(paddingTop+leftHeight>mainHeight){
	                    $(".game").find("div").eq(0).stop().animate({paddingTop: mainHeight-leftHeight}, "fast");
	                }
                }, 500);
                $(window).scroll(function(){paddingTop()});
                $(window).resize(function(){paddingTop()});
	            function paddingTop(){
	                var offsetTop = $(".game").offset().top, scrollTop = $(window).scrollTop(), d = $(".game").find("div");
	                return (offsetTop<scrollTop ? offsetTop = scrollTop-offsetTop : offsetTop = 0), (d.eq(1).height()<offsetTop+d.eq(0).height() ? offsetTop = d.eq(1).height()-d.eq(0).height() : void(0)), (offsetTop<0 ? offsetTop = 0 : void(0)), d.eq(0).stop().animate({paddingTop: offsetTop}, "fast");
	            }
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
                            <div id="memberLatestAnnouncement" style="margin-top:10px;cursor:pointer;"><marquee notice scrollamount="5" scrolldelay="150" direction="left" id="msgNews" onMouseOver="this.stop();" onMouseOut="this.start();" style="cursor:pointer"><?php echo get_last_message(true); ?></marquee></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix sports-banner" style="background-position:top center">
            <div class="container" style="width:1022px">
                <div class="activity-box">
                    <div class="clearfix">
                        <div class="loading">
                            <div>游戏正在加载，请您稍后...</div>
                        </div>
                        <div class="game" style="height:0px;overflow:hidden;background-color:#261D18">
                            <div style="width:215px;float:left;overflow-x:hidden;">
                                <iframe class="autoSize" frameborder="0" scrolling="no" allowtransparency="true" src="left.php" width="215" height="850" id="leftFrame" name="leftFrame"></iframe>
                            </div>
                            <div style="width:807px;float:right;overflow-x:hidden">
                                <iframe class="autoSize" frameborder="0" scrolling="no" allowtransparency="true" src="show/ft_danshi.html" width="807" height="850" id="mainFrame" name="mainFrame"></iframe>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>