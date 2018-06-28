<?php
session_start();
$_DIR = dirname(__FILE__).'/';
include($_DIR.'../include/config.php');
include($_DIR.'../database/mysql.config.php');
include($_DIR.'./config.php');
include($_DIR.'./include/functions.php');
(!isset($_GET['p'])||!in_array($_GET['p'], array('XIN', 'MG', 'PT', 'BYW_2','KG', 'BG', 'CQ9', 'MG2','MW')))&&$_GET['p'] = 'XIN';
$is_egame = in_array($_GET['p'], array('XIN', 'MG', 'PT', 'BG'));
$is_login = isset($_SESSION['uid']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <style type="text/css">
        body {margin:0}
        *{box-sizing:border-box;
        -moz-box-sizing:border-box; /* Firefox */
        -webkit-box-sizing:border-box;}
        a {text-decoration:none}
        .game {width:100%;max-width:1152px;min-width:900px;}
        .game .ag_byw2 img {width:100%}
        .game .menu {width:100%;height:50px;background-color:#2b2a2a;overflow:hidden;margin: 0 auto; padding: 0px 30px;}
        .game .menu ul {width:100%;height:50px;margin:0;margin-left:-2px;padding:0;list-style:none;}
        .game .menu ul li {float:left;height:50px;border-left:solid 1px #202020;width:10%;line-height: 50px;}
        .game .menu ul li a {display:block;height:50px;border-left:solid 1px #3d3d3d;text-align:center;line-height:50px;color:#ACACB2;font-size:16px;font-weight:bold;padding-left:15px;}
        .game .menu ul li a span {
            float:left;padding-left: 5px;
        }
        .game .menu ul li a:hover, .game .menu ul li a.current {color:#DC3834;background-color:#212121}
        .list .loading {background:url(images/loading.gif) no-repeat center;height:200px;width:100%}
        .list .contents {overflow:hidden}
        .tips {border-top:solid 1px #3d3d3d;background:url(images/background.png);width:100%;text-align:center;height:200px}
        .tips a {color:#ACACB2;line-height:200px;font-size:25px}
        .tips a:hover {color:#DC3834;text-decoration:underline}

        .slick-prev{
            z-index: 999;
        }
        .slick-slide img {
            height: 40px;
            width: 60px;
            margin-top: 5px;
            float: left;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.min.css" rel="stylesheet">
    <script type="text/javascript" src="javascript/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript">
        var tryGame = function(gameType){
            var tryURI = "/cj/live/index.php?type=AGIN&try=true";
            if(typeof(gameType)!="undefined"){
                tryURI = tryURI+"&gameType="+gameType;
            }
            parent.f_com.bm(tryURI, 'CASINO', {toolbar:'no',location:'no',directories:'no',menubar:'no',resizable:'no',top:'2',width:'1200',height:'760'});
            return false;
        },
        liveClick = function(liveType, isBlank){
            <?php if($is_login): ?>
            if(isBlank){
                window.open('/cj/live/index.php?type='+liveType, '_blank');
            }else{
                parent.f_com.bm('/cj/live/index.php?type='+liveType, 'CASINO', {toolbar:'no',location:'no',directories:'no',menubar:'no',resizable:'no',top:'2',width:'1200',height:'760'});
            }
            <?php else: ?>
            alert('请您先登录网站再进行游戏！');
            <?php endif; ?>          
            return false;
        };
        setFrameHieght = function(height){
            if(height&&parseInt(height)>0){
                $("#egameFrame").height(height);
                $(".contents").removeAttr("style");
                $(".loading").hide();
            }
            parent.setFrameHieght($("body").height());
        };
        $(function(){
            $('.menu ul').slick({
                infinite: true,
                slidesToShow: 7,
                slidesToScroll: 1,
                //autoplay: true,
                autoplaySpeed: 2000,
            });
            setFrameHieght();
            <?php if($is_egame): ?>
            $("#egameFrame").attr("src", "egame.php?<?=http_build_query($_GET)?>&w="+$("body").width());
            <?php endif; ?>
        });
    </script>
</head>
<body>
    <div class="game">
        <div class="menu">
            <ul>
                <li><a href="?p=XIN" class="<?=$_GET['p']=='XIN'?'current':''?>"><img src="/game/images/ag.png"><span>XIN电子</span></a></li>
                <li><a href="?p=PT" class="<?=$_GET['p']=='PT'?'current':''?>"><img src="/game/images/pt.png"><span>PT电子</span></a></li>
                <li><a href="?p=MG2" class="<?=$_GET['p']=='MG2'?'current':''?>"><img src="/game/images/mg.png"><span>新MG电子</span></a></li>
                <li><a href="?p=CQ9" class="<?=$_GET['p']=='CQ9'?'current':''?>"><img src="/game/images/cq9.png"><span>CQ9电子</span></a></li>
                <li><a href="?p=MW"  class="<?=$_GET['p']=='MW'?'current':''?>"><img src="/game/images/mw.png"><span>MW电子</span></a></li>
                <li><a href="javascript:;" onclick="liveClick('BBIN&gameType=5', true)"><img src="/game/images/bb.png"><span>BB电子</span></a></li>
                <li><a href="javascript:;" onclick="liveClick('AGIN&gameType=YP800', true)"><img src="/game/images/ag.png"><span>AG街机</span></a></li>
                <li><a href="?p=BYW_2" class="<?=$_GET['p']=='BYW_2'?'current':''?>"><img src="/game/images/fish.png"><span>捕鱼王Ⅱ</span></a></li>
                <li><a href="?p=BG" class="<?=$_GET['p']=='BG'?'current':''?>"><img src="/game/images/ag.png"><span>BG电子</span></a></li>
                <li><a href="?p=KG" class="<?=$_GET['p']=='KG'?'current':''?>"><img src="/game/images/av.png"><span>AV女优</span></a></li>
                <li><a href="?p=MG" class="<?=$_GET['p']=='MG'?'current':''?>"><img src="/game/images/mg.png"><span>MG电子</span></a></li>
            </ul>
        </div>
        <?php if($is_egame): 
				if( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ): ?>
					<div class="tips">
						<a href="egame.php?<?php echo http_build_query($_GET); ?>" target="_blank">点击这里进入游戏</a>
					</div>
				<?php else:?>
				<div class="list">
					<div class="loading"></div>
					<div class="contents" style="height:0">
						<iframe name="egameFrame" id="egameFrame" src="about:blank" width="100%" height="0" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" allowtransparency="true"></iframe>
					</div>
				</div>
		<?php 	endif;
		elseif($_GET['p']=='BYW_2'): ?>
        <div class="ag_byw2">
            <?php if($is_login):?>
                <a href="javascript:;" onclick="liveClick('AGIN&gameType=6')"><img src="images/byw_2.gif" onload="setFrameHieght()" /></a>
            <?php else: ?>
                <a href="javascript:;" onclick="alert('您未登录网站，现在将带您进入试玩版。');tryGame(6);"><img src="images/byw_2.gif" onload="setFrameHieght()" /></a>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <iframe width="100%" src="/game/?g=<?=$_GET['p']?>" name="egameFrame" id="egameFrame" frameborder="0" style="height: 950px;" marginheight="0" marginwidth="0"  allowtransparency="true"></iframe>
        <?php endif; ?>
</div>
</body>
</html>