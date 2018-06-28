<?php session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/function.php';
include_once '../myfunction.php';
include_once '../class/user.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
if (($_GET['f'] != '') && ($_SESSION['username'] == '')){
	$f = $_GET['f'];
	//echo "<script>window.location.href='/m/register.php?f=".$f."';</script>";
	//exit();
}
$slides = get_images('slides-mobile');
if(empty($slides)){
    $slides = array(
        array('img' => '/newindex/mobile/b_1.jpg'),
        array('img' => '/newindex/mobile/b_2.jpg'),
        array('img' => '/newindex/mobile/b_3.jpg'),
    );
}
$cdn_url = '//cdn.fox008.cc';
?><!DOCTYPE html>
<html id="ng-app" ng-app="mobileApp" meidon-time="2018/02/21 01:06:15"  moment-lang="zh-CN">
	<head> 
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
		<title><?=$web_site['web_title'];?></title> 
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script>$(document).bind("mobileinit", function() {$.mobile.ajaxEnabled=false;});</script>
	
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/muiv3@3.3.0/dist/css/mui.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@4.1.6/dist/css/swiper.min.css">
		<script src="https://cdn.jsdelivr.net/npm/swiper@4.1.6/dist/js/swiper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/muiv3@3.3.0/dist/js/mui.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery.marquee@1.5.0/jquery.marquee.min.js" type="text/javascript"></script>
		<style>
			.member {
				    padding: 55px 0 10px;
    text-align: center;
			}
			aside .member img.profile {
				margin-bottom: 10px;
				width: 85px;
				height: 85px;
			}
			.mui-off-canvas-left, .mui-off-canvas-right { width: 175px; }
			#nav .closed{
				color: #fff;
				background: #ea1340;
				position: absolute;
				top: 7px;
				right: 7px;
				width: 28px;
				height: 28px;
				padding: 0;
				font-size: 18px;
				border: none;
				border-radius: 50%;
			}
			#nav .account {
			    list-style: none;
			    margin: 0;
			    padding: 0;
			}
			#nav .account li {
			    color: #0c172b;
			    background: #ffc900;
			}
			#nav .account li {
			    position: relative;
			    width: 90%;
			    height: 24px;
			    margin: 5px auto;
			    font-size: 15px;
			    line-height: 24px;
			    text-align: center;
			    border-radius: 20px;
			}
			#nav .account li a{
    color: inherit;

			}
			#nav .account li a.update {
    position: absolute;
    right: 10px;
}.sidebar {
    margin: 0;
    padding: 0;
    list-style: none;
}.sidebar li {
    margin: 0;
    line-height: 38px;
    background-repeat: no-repeat;
    background-position: 25px center;
}.sidebar li {
    color: #fff;
    border-bottom: 1px solid #50095b;
}.sidebar li a {
    color: inherit;
    text-decoration: none;
}.sidebar li i {
    width: 24px;
    margin: 0 5px 0 15px;
    font-size: 20px;
    text-align: center;
    vertical-align: middle;
}
#news {
    position: relative;
    height: 34px;
    padding: 0 10px;
    font-size: 12px;
    font-family: MingLiU;
    line-height: 34px;
    overflow: hidden;
}
#news i {
    position: absolute;
    z-index: 10;
    padding-right: 10px;
    font-size: 20px;
    line-height: 34px;
    vertical-align: middle;
}
#news, #news i {
    /*color: #fff;*/
    background: #efeff4;
}

#news #marquee {
    display: inline-block;
    width: 100%;
    overflow: hidden;
    vertical-align: middle;
}
li.mui-table-view-cell img.icon{
	width: 60px;
	height: 60px;
	margin:0 auto;
	display: block;
}
.mui-bar a i{
	display: inline-block;
	font-size: 24px;
    position: relative;
    z-index: 20;
        top: 3px;
    width: 24px;
    height: 24px;
    padding-top: 0;
    padding-bottom: 0;
}
.mui-bar a i~span{
	    font-size: 11px;
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
}
		</style>
  </head>
  <body>
		<!--侧滑菜单容器-->
		<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-draggable">
			<!--菜单部分-->
			<aside id="nav" class="mui-off-canvas-right">
				<div id="offCanvasSideScroll" class="mui-scroll-wrapper">
					<div class="mui-scroll">
						<button class="closed" type="button">X</button>
						<div class="member">
							<img class="profile" src="<?=$cdn_url?>/Common/Mobile/img/profile.png">
							<ul class="account">
			                    <li>
			                        <span class="account" title="okoklpp888">okoklpp888</span>
			                    </li>
			                    <li>
			                        <span title="$ 18.00" class="ng-binding">$ 18</span>
			                        <a class="update" ng-click="updateBalance()" title="更新">
			                            <i class="fa fa-refresh"></i>
			                        </a>
			                        
			                        <div id="callBackAllWallet"></div>
			                    </li>
			                </ul>
						</div>
						<ul class="sidebar">
				            <li>
				                <i class="fa fa-home" aria-hidden="true"></i>
				                <a href="/">回首页</a>
				            </li>
            
                    <li>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <a id="change-password-btn" href="/Account/ChangePassword" class="login-btn ">修改密碼</a>
                    </li>
                    <li>
                        <i class="fa fa-key" aria-hidden="true"></i>
                        <a href="/Account/ChangeMoneyPassword">
                            修改取款密码
                        </a>
                    </li>
                <li>
                    <i class="fa fa-power-off" aria-hidden="true"></i>
                    <a href="/Account/SignOut" ng-click="signOut()" ng-bind="isProcessing ? '处理中...' : '登出'">登出</a>
                </li>
            <li>
                <i class="fa fa-whatsapp" aria-hidden="true"></i>
                <a href="javascript:void(0)" ng-click="lineChatClick()">在线客服</a>
            </li>
            <li ng-if="ContactInfo.HttpMobilePromotion!==undefined && ContactInfo.HttpMobilePromotion!==''">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                <a ng-href="{{ContactInfo.HttpMobilePromotion}}" target="_blank">优惠办理大厅</a>
            </li>
                <li>
                    <i class="fa fa-history" aria-hidden="true"></i>
                    <a href="/BetRecord">投注记录</a>
                </li>
            <li>
                <i class="fa fa-desktop" aria-hidden="true"></i>
                <a href="javascript:void(0)" ng-click="ChangeToDesktop()">回电脑版</a>
            </li>
        </ul>

					</div>
				</div>
			</aside>
			<div class="mui-inner-wrap">
				<header class="mui-bar mui-bar-nav">
					<a id="offCanvasBtn" href="#nav" class="mui-icon mui-action-menu mui-icon-bars mui-pull-right"></a>
					<h1 class="mui-title"><?=$web_site['web_title'];?></h1>
				</header>

				<nav class="mui-bar mui-bar-tab">
					<a class="mui-tab-item" href="#tabbar">
						<i class="fa fa-home" aria-hidden="true"></i>
						<span class="mui-tab-label">首页</span>
					</a>
					<a class="mui-tab-item" href="#tabbar-with-chat">
						<i class="fa fa-usd" aria-hidden="true"></i>
						<span class="mui-tab-label">消息</span>
					</a>
					<a class="mui-tab-item" href="#tabbar-with-contact">
						<span class="mui-icon mui-icon-contact"></span>
						<span class="mui-tab-label">通讯录</span>
					</a>
					<a class="mui-tab-item mui-active" href="#tabbar-with-map">
						<span class="mui-icon mui-icon-gear"></span>
						<span class="mui-tab-label">设置</span>
					</a>
				</nav>
				<div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper">
					<div class="mui-scroll">


						<div class="mui-slider">
						  <div class="mui-slider-group">
						  	<?php foreach($slides as $key=>$val): ?>						  
							<div  class="mui-slider-item"><img src="<?=$val['img']?>"></div> 
							<?php endforeach; ?>
						  </div>
						  <div class="mui-slider-indicator">
						  	<?php foreach($slides as $key=>$val): ?>						  
							<div class="mui-indicator <?=$key==0?'mui-active':''?>"></div>
							<?php endforeach; ?>
						</div>
						</div>
						<div id="news">
							<i class="fa fa-volume-up"></i>
							<span id="marquee">234234</span>
						</div>
						<div style="padding: 10px 10px;">
							<div id="segmentedControl" class="mui-segmented-control">
								<a class="mui-control-item mui-active" href="#item1">
								电子游戏
						</a>
								<a class="mui-control-item" href="#item2">
							真人视讯
						</a>
								<a class="mui-control-item" href="#item3">
							体育投注
						</a>
						<a class="mui-control-item" href="#item4">
							彩票游戏
						</a>
							</div>
						</div>
						<div id="item1" class="mui-control-content mui-active">
							<ul class="mui-table-view mui-grid-view mui-grid-9">
						
							<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/mg.png">
		                    <div class="mui-media-body">MG电子</div></a></li>

		                    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/cq9.png">
		                    <div class="mui-media-body">CQ9电子</div></a></li>

		                    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/av.png">
		                    <div class="mui-media-body">AV女优</div></a></li>

		                    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/c1imgjst_sp_pt.png">
		                    <div class="mui-media-body">PT电子</div></a></li>

		                    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/c1imgjst_sp_xin.png">
		                    <div class="mui-media-body">XIN电子</div></a></li>
					
							<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/byw2.png">
		                    <div class="mui-media-body">捕鱼达人</div></a></li>

						</ul>
						</div>
						<div id="item2" class="mui-control-content">
							<ul class="mui-table-view mui-grid-view mui-grid-9">
							<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/mg_live.png">
		                    <div class="mui-media-body">MG欧美厅</div></a></li>

		                    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/c1imgbbin.png">
		                    <div class="mui-media-body">BB波音厅</div></a></li>

		                    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/c1imgag.png">
		                    <div class="mui-media-body">AG国际厅</div></a></li>

		                    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/c1imgagmg.png">
		                    <div class="mui-media-body">AG极速厅</div></a></li>

		                    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/c1imgog.png">
		                    <div class="mui-media-body">OG东方厅</div></a></li>

		                    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/maya.png">
		                    <div class="mui-media-body">玛雅娱乐厅</div></a></li>
		                    
						</ul>
						</div>
						<div id="item3" class="mui-control-content">
							<ul class="mui-table-view mui-grid-view mui-grid-9">
							<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/c1imgjst_sp_ismart.png">
		                    <div class="mui-media-body">皇冠体育</div></a></li>

		                    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/c1imgbbin.png">
		                    <div class="mui-media-body">BBIN体育</div></a></li>

		                    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
		                    <img class="icon" src="<?=$cdn_url?>/Common/Mobile/img/icon/c1imgjst_sp_iwap.png">
		                    <div class="mui-media-body">沙巴体育</div></a></li>
						</ul>
						</div>
						<div id="item4" class="mui-control-content">
						</div>
						
					</div>
				</div>
				<div class="mui-off-canvas-backdrop"></div>
			</div>
		</div>

      <script type="text/javascript">
      	mui.init({swipeBack: false,});
      	 //侧滑容器父节点
			var offCanvasWrapper = mui('#offCanvasWrapper');
			$('.closed').click(function(){
				offCanvasWrapper.offCanvas().close()
			});
			 //主界面和侧滑菜单界面均支持区域滚动；
			mui('#offCanvasSideScroll').scroll();
			mui('#offCanvasContentScroll').scroll();
			 //实现ios平台的侧滑关闭页面；
			if (mui.os.plus && mui.os.ios) {
				offCanvasWrapper[0].addEventListener('shown', function(e) { //菜单显示完成事件
					plus.webview.currentWebview().setStyle({
						'popGesture': 'none'
					});
				});
				offCanvasWrapper[0].addEventListener('hidden', function(e) { //菜单关闭完成事件
					plus.webview.currentWebview().setStyle({
						'popGesture': 'close'
					});
				});
			}

			$("#marquee").marquee({  
           yScroll: "left",  
           showSpeed: 850,        // 初始下拉速度         ,   
           scrollSpeed: 12,       // 滚动速度         ,   
           pauseSpeed: 500,      // 滚动完到下一条的间隔时间         ,   
           pauseOnHover: true,    // 鼠标滑向文字时是否停止滚动         ,   
           loop: -1 ,             // 设置循环滚动次数 （-1为无限循环）         ,   
           fxEasingShow: "swing" , // 缓冲效果         ,   
           fxEasingScroll: "linear",  // 缓冲效果         ,   
           cssShowing: "marquee-showing"  //定义class   
  
         }); 
      </script>
  </body> 
</html>