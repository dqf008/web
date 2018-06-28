<?php 

header('Location: /mobile/');die();
session_start();
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html> 
  <head> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
	  <title><?=$web_site['web_title'];?></title> 
	  <!--[if lt IE 9]> 
		  <script src="js/html5.js" type="text/javascript"></script> 
		  <script src="js/css3-mediaqueries.js" type="text/javascript"></script> 
	  <![endif]--> 
	  <meta name="viewport" content="width=device-width, initial-scale=1"> 

	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script>$(document).bind("mobileinit", function() {$.mobile.ajaxEnabled=false;});</script>

	  <script type="text/javascript" src="js/jquery.SuperSlide.2.1.1.js"></script>
	  <link rel="shortcut icon" href="images/favicon.ico"> 
	  <link rel="stylesheet" href="css/style.css" type="text/css" media="all"> 
	  <link rel="stylesheet" href="css/style_index.css" type="text/css" media="all"> 
	  <link rel="stylesheet" href="css/style_xtgg.css" type="text/css" media="all">
      <!--js判断横屏竖屏自动刷新-->
	  <script type="text/javascript" src="js/top.js?v=1"></script> 
	  <script type="text/javascript" src="js/marquee.js"></script>
	<script type="text/javascript" src="/skin/layer/mobile/layer.js"></script>



	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.0/css/swiper.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.0/js/swiper.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
      <style>
      .layui-m-layercont{padding:10px;}
      .ui-overlay-a, .ui-page-theme-a, .ui-page-theme-a .ui-panel-wrapper {text-shadow:none !important;}
      .nav a {color:#FFF !important;}
      .slideTxtBox a{color:#333 !important;}
      </style>
  </head>
  <body>
	  <!--头部开始-->
	  <header id="header"> 
		  <a href="/m/index.php" class="ico ico_home"></a> 
		  <span><?=$web_site['web_name'];?></span> 
		  <a href="/mobile/" style="left:auto;right:10px;position:absolute;color:#fff;font-size:16px;font-weight:bold">进入新版</a>
	  </header> 
	  <!--头部结束--> 
	  <!--banner开始--> 
	  <div class="banner mrg_header"> 
		  <div id="slideBannerBox" class="slideBannerBox"> 
			  <div class="hd"> 
				<ul>
				<?php foreach($slides as $key=>$val):?>
					<li <?=$key==0?'class="on"':''?>></li>
				<?php endforeach; ?>
				</ul> 
			  </div> 
			  <div class="bd"> 
				  <div class="tempWrap" style="overflow:hidden;position:relative;width:100%"> 
					<ul style="width:100%;position: relative;overflow: hidden;padding: 0px;margin: 0px;"> 
						<?php foreach($slides as $key=>$val): ?>						  
						<li style="float: left;width: 100%;"><img src="<?=$val['img']?>"></li> 
						<?php endforeach; ?>					  
					</ul> 
				  </div> 
			  </div> 
		  </div>
	  </div>
	  <div id="xtgg"> 
		<img src="images/ggtp.png" style="float:left;margin-left: 10px;margin-top: 2px;"></img> 
		<div id="scrlContainer"><div id="scrlContent" ><?=get_last_message()?></div></div>
		<div id="notice_box" style="display:none;">
			<div class="swiper-container">
				<div class="swiper-wrapper" style="height:250px;width:100px;"></div>
				<div class="swiper-pagination"></div>
			</div>
		</div>
	  </div> 
	  <div class="clear"></div> 
	  <div id="main" class="cl"> 
		  <div class="content w">
			<?php if ($uid == ''):?>
			<div class="ctop_nav"> 
			  <ul> 
				  <li class="nav"><a href="login.php">会员登录</a></li> 
				  <li class="nav"><a href="register.php">立即注册</a></li> 
				  <li class="nav"><a href="javascript:void(0);" onclick="menu_url(62)">在线客服</a></li> 
			  </ul> 
			</div>
			<?php else:?>
			<div class="ctop ctop_info"> 
			  <label class="ico ico_user"><?=$username;?></label> 
			  <label class="ico ico_balance"><span id="user_money">0.00</span></label> 
			</div> 
			<div class="c1top"> 
			  <div class="lbg"> 
				  <div class="rbg"> 
					  <ul class="cl"> 
						  <li class="li1"><a href="member/userinfo.php">我的账户</a></li> 
						  <li class="li2"><a href="member/setmoney.php">线上存款</a></li> 
						  <li class="li3"><a href="member/getmoney.php">线上取款</a></li> 
						  <li class="li4"><a href="member/zr_money.php">额度转换</a></li> 
						  <li class="li5"><a href="member/orders.php">财务记录</a></li> 
						  <li class="li6"><a href="member/records_ty.php?a_type=ds">下注记录</a></li> 
						  <li class="li7"><a href="common/result.php">开奖结果</a></li> 
						  <li class="li8"><a href="/logout.php">安全登出</a></li> 
					  </ul> 
				  </div>
			  </div>
			</div>
			<?php endif;?>     
			            
			  <div class="c2"> 
				  <div class="slideTxtBox"> 
					  <div class="bd"> 
						  <ul class="cl"> 
						  	<li onclick="submitlive('<?=$uid?>','DG&mobile=true')"><img src="//cdn.fox008.cc/Common/Mobile/img/icon/dg.png" />DG视讯</li>
						  	<li onclick="submitlive('<?=$uid?>','SB&mobile=true')"><img src="//cdn.fox008.cc/Common/Mobile/img/icon/sb.png" />申博视讯</li>
						  	<li onclick="submitlive('<?=$uid?>','BGLIVE&mobile=true')"><img src="//cdn.fox008.cc/Common/Mobile/img/icon/bg.png" />BG视讯</li>
							<li onclick="submitlive('<?=$uid?>','VR')"><img src="//cdn.fox008.cc/Common/Mobile/img/icon/vr.png" />VR彩票</li> 
							<li url="/m/game.php?g=mg2"><img src="images/game/c1imgnmg.png" alt="MG电子" />MG电子</li> 
							<li onclick="submitlive('<?=$uid?>','MG2&id=1054&mobile=true')"><img src="images/game/mg.png" alt="MG电子" />MG欧美厅</li> 
							<li url="/m/game.php?g=cq9"><img src="images/game/cq9.png" alt="CQ9电子" />CQ9电子</li> 
							<li url="/m/game.php?g=kg"><img src="images/game/av.png" alt="AV女优" />AV女优</li> 
							<li onclick="submitlive('<?=$uid?>','BBIN&gameType=1&mobile=true')"><img src="images/game/c1imgbbin.png" alt="BB波音厅" />BB波音厅</li> 
							<li onclick="submitlive('<?=$uid?>','AGIN&mobile=true')"><img src="images/game/c1imgag.png" alt="AG国际厅" />AG国际厅</li> 
							<li onclick="submitlive('<?=$uid?>','AG&mobile=true');"><img src="images/game/c1imgagmg.png" alt="AG极速厅" />AG极速厅</li> 
							<li onclick="submitlive('<?=$uid?>','OG&mobile=true');"><img src="images/game/c1imgog.png" alt=" OG东方厅" />OG东方厅</li> 
							<li url="/m/game.php?g=pt"><img src="images/game/c1imgjst_sp_pt.png" alt="PT电子" />PT电子</li> 
							<li url="/m/game.php?g=xin"><img src="images/game/c1imgjst_sp_xin.png" alt="XIN电子" />XIN电子</li> 
							<li url="/m/lotto/"><img src="images/game/c2img_lhc.png" alt="香港六合彩">香港六合彩</li> 
							<li url="/m/lottery/cqssc.php"><img src="images/game/c2img_ssc_cq.png" alt="重庆时时彩">重庆时时彩</li> 
							<li url="/m/lottery/bjsc.php"><img src="images/game/c2img_pk10.png" alt="北京PK拾">北京PK拾</li> 
							<li url="/m/lottery/xyft.php"><img src="images/game/c2img_pk10.png" alt="北京PK拾">幸运飞艇</li>
							<li url="/m/lottery/gdkls.php"><img src="images/game/c2img_klsf_gd.png" alt="广东快乐10分">广东快乐10分</li>
							<li url="/m/lottery/ssl.php"><img src="images/game/c2img_ssl.png" alt="上海时时乐">上海时时乐</li>
							<li url="/m/lottery/kl8.php"><img src="images/game/c2img_kl8.png" alt="北京快乐8">北京快乐8</li>
							<li url="/m/lottery/3d.php"><img src="images/game/c2img_3d.png" alt="福彩3D">福彩3D</li>
							<li url="/m/lottery/pl3.php"><img src="images/game/c2img_pl3.png" alt="排列三">排列三</li>
							<li url="/m/lottery/qxc.php"><img src="images/game/c2img_qxc.png" alt="七星彩">七星彩</li>
							<li url="/m/lottery/jssc.php"><img src="images/game/js_sc.png" alt="极速赛车">极速赛车</li>
							<li url="/m/lottery/jsssc.php"><img src="images/game/js_ssc.png" alt="极速时时彩">极速时时彩</li>
							<li url="/m/lottery/jslh.php"><img src="images/game/js_lh.png" alt="极速六合彩">极速六合彩</li>
							<li url="/m/sports/"><img src="images/game/c1imgjst_sp_ismart.png" alt="皇冠体育" />皇冠体育手机版</li> 
							<li onclick="submitlive('<?=$uid?>','SHABA&mobile=true');"><img src="images/game/c1imgjst_sp_iwap.png" alt="沙巴体育"/>沙巴体育</li> 
							<li onclick="submitlive('<?=$uid?>','MAYA&mobile=true');"><img src="images/game/maya.png" alt="玛雅娱乐厅" />玛雅娱乐厅</li>
							<li url="/m/game.php?g=fish"><img src="images/game/byw2.png" alt="捕鱼王Ⅱ" />捕鱼达人</li>
							<?php if($uid):?>
							<li url="/m/sign.php"><img src="images/game/c1imgjst_sp_sign.png" alt="会员签到">会员签到</li> 
							<?php else:?>
							<li onclick="alert('请先登录')"><img src="images/game/c1imgjst_sp_sign.png" alt="会员签到"> 会员签到</li> 
							<?php endif?>							  
						  </ul> 
					  </div> 
				  </div> 
			  </div> 
			  <!--.c2--> 
			  <div class="c3"> 
				  <div class="lbg"> 
					  <div class="rbg"> 
						  <ul class="cl"> 
							  <li class="li1"> 
								  <div class="lbg1"> 
									  <div class="rbg1"> 
										  <div class="bg1">
										  <?php $url = 'http://' . $_SERVER['HTTP_HOST'] . '/?machinetype=pc&' . $_SERVER['QUERY_STRING'];?>                                                
										  <a class="cl" href="javascript:void(0);" onclick='window.open("<?=$url;?>","_self");'> 
												  <div class="f fl"> 
													  <img src="images/c3img1.png" alt=""> 
												  </div> 
												  <div class="f fr"> 
													  <h3> 
														  电脑版 
													  </h3> 
													  <p><?=$_SERVER['HTTP_HOST'];?></p> 
												  </div> 
											  </a> 
										  </div> 
									  </div> 
								  </div> 
							  </li> 
							  <li class="li2"> 
								  <div class="lbg1"> 
									  <div class="rbg1"> 
										  <div class="bg1"> 
											  <a class="cl" href="javascript:void(0);" onclick="menu_url(62);return false;" target="self"> 
												  <div class="f fl"> 
													  <img src="images/c3img2.png" alt=""> 
												  </div> 
												  <div class="f fr"> 
													  <h3> 
														  在线客服 
													  </h3> 
													  <p> 
														  7x24为您服务 
													  </p> 
												  </div> 
											  </a> 
										  </div> 
									  </div> 
								  </div> 
							  </li> 
						  </ul> 
					  </div> 
				  </div> 
			  </div> 
		  </div> 
	  </div> 

	  <script>
	  $(function(){
	  	$(".slideBannerBox").slide({ 
		  mainCell: ".bd ul", 
		  effect: "left", 
		  autoPlay: true, 
		  delayTime: 1000, 
		  mouseOverStop: true 
		});
		list = $('.slideTxtBox>div>ul').children("li");
      	appendNum = 3 - list.length % 3;
      	for(var i=0;i<appendNum && appendNum !=3 ;i++){
      		$('.slideTxtBox>div>ul').append('<li style="border-right;"><img src="images/game/c2img_more.png" alt="敬请期待">敬请期待</li> ')
      	}
      	list = $('.slideTxtBox>div>ul').children("li");
      	for(var i=0;i<list.length;i++){
      		$(list[i]).attr('style','');
      		if(i%3 == 2 ) $(list[i]).attr('style','border-right:0');
      	}

      	$('.slideTxtBox>div>ul>li').click(function(){
      		var url = $(this).attr('url');
      		if(url) window.location.href=$(this).attr('url');
      	});
	  	$('#xtgg').click(function(){
	  		content = $('#scrlContent').html();
	  		arr = content.split('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
	  		$('.swiper-container .swiper-wrapper').html('');
	  		for(i=0;i<arr.length;i++){
	  			$('.swiper-container .swiper-wrapper').append($('<div class="swiper-slide">'+arr[i]+'</div>'));
	  		}
			layer.open({
				title: [
					'最新公告',
					'background-color: #614e47; color:#fff;height:40px;line-height:40px;'
				],
				content: $('#notice_box').html(),
				success: function(){
					new Swiper ('.swiper-container', {pagination: {el: '.swiper-pagination'}});
				}
			});
	  	});
	  })
	  </script>
	  <!--底部开始--><?php include_once 'bottom.php';?>        <!--底部结束-->

<?php
$sj_tc = get_webinfo_bycode('sj-tc');
$sj_tc['title'] = unserialize($sj_tc['title']);
if(isset($sj_tc['title'])&&!empty($sj_tc['title'])&&$sj_tc['title'][0]>0):?>
<div id="tc" style="display:none;"><?=stripcslashes($sj_tc['content'])?></div>
<script language="javascript">
    $(function(){
		layer.open({
			content: $('#tc').html(),
			btn: '我知道了',
			time: <?=$sj_tc['title'][0]?> 
		  });
    });
</script>
<?php endif;?>
<?php if ($uid):?>
    <script language="javascript">top_money();</script>
<?php endif;?>
  </body> 
</html>