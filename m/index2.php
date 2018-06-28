<?php 
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
$slides = get_images('slides-mobile');
$system_notice = get_mobile_message();
if(empty($slides)){
    $slides = array(
        array('img' => '../newindex/mobile/b_1.jpg'),
        array('img' => '../newindex/mobile/b_2.jpg'),
        array('img' => '../newindex/mobile/b_3.jpg'),
    );
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?=$web_site['web_title'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="./mui/css/mui.min.css">
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script> 
	  <link rel="shortcut icon" href="images/favicon.ico"> 
	  <link rel="stylesheet" href="css/style.css" type="text/css" media="all"> 
	  <link rel="stylesheet" href="css/style_index.css" type="text/css" media="all"> 
      <!--js判断横屏竖屏自动刷新-->
	  <script type="text/javascript" src="js/top.js?v=1"></script> 
	  <script type="text/javascript" src="/skin/layer/mobile/layer.js"></script>
		<style type="text/css">
			#list {
				/*避免导航边框和列表背景边框重叠，看起来像两条边框似得；*/
				margin-top: -1px;
			}
			.mui-content {
                margin-top:35px;
			}
            .mui-slider-indicator .mui-active.mui-indicator{
                background: #BF0202;
                box-shadow:0 0 1px 1px rgba(191,2,2,.7)
            }
            .notice ul.mui-list-unstyled {
                padding:5px 0;
                overflow: hidden;
                height:30px;
            }
            .notice a{
                /*color: #fff;*/
                font-size: 12px;
                height: 22px;
                display: inline;
                white-space: nowrap;
                margin-right: 40px;
            }
            .layui-m-layercont{
                padding:20px 30px;
            }
            .notice .mui-btn {
                padding: 1px 5px;
                margin: 5px 10px 0 0;
                color: #e56365;
                border-color: #e56365;
            }
            .notice {
                padding: 0 10px;
                height:28px;
            }
            .ctop_nav {
                height:60px;
            }
            .ctop_nav li{
                height:45px;
            }
            .ctop_info {
                height:35px;
            }
            .c3 ul li .bg1{
                height:76px;
            }
            .c2 .slideTxtBox .bd li { width:33.33%}
            .c3 ul li{width:49.99%}
		</style>
	</head>

	<body>
		<header id="header"> 
		  <a href="/m/index.php" class="ico ico_home"></a> 
		  <span><?=$web_site['web_name'];?></span> 
	  </header> 
		<div class="mui-content">
        <div class="mui-row">
            <div class="mui-slider banner">
                <div class="mui-slider-group">
                    <?php foreach($slides as $key=>$val): ?>	
                    <div class="mui-slider-item"><img src="<?=$val['img']?>" /></div>		
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <style>
            
        </style>
        <div class="mui-row notice">
                <button type="button" class="mui-pull-left mui-btn mui-btn-danger mui-btn-outlined">最新公告</button>
                <ul class="mui-list-unstyled"><li><p>
                    <?php foreach($system_notice as $k=>$v): ?>
                        <a data-idx="<?=$k?>"><?=$v?></a>
                    <?php endforeach; ?>
                </p></li></ul>
                <div class="mui-slider" style="display:none;">
                    <div class="mui-slider-group">
                        <?php foreach($system_notice as $v): ?><div class="mui-slider-item"><?=$v?></div><?php endforeach; ?>
                    </div>
                </div>
        </div>
	  <div id="main" class="cl"> 
		  <div class="content w">
		  <?php if(empty($uid)): ?>
                 <div class="ctop_nav"> 
				  <ul> 
					  <li class="nav"> 
						  <a href="login.php"> 
							  会员登录 
						  </a> 
					  </li> 
					  <li class="nav"> 
						  <a href="register.php"> 
							  立即注册 
						  </a> 
					  </li> 
					  <li class="nav"> 
						  <a href="javascript:void(0);" onClick="menu_url(62);return false;"> 
							  在线客服 
						  </a> 
					  </li> 
				  </ul> 
			  </div>
			  <?php else: ?>
			  <div class="ctop ctop_info"> 
				  <label class="ico ico_user"><?=$username;?></label> 
				  <label class="ico ico_balance"><span id="user_money">0.00</span></label> 
			  </div> 
			  <div class="c1top"> 
				  <div class="lbg"> 
					  <div class="rbg"> 
						  <ul class="cl"> 
							  <li class="li1"> 
								  <a href="member/userinfo.php">我的账户</a> 
							  </li> 
							  <li class="li2"> 
								  <a href="member/setmoney.php">线上存款</a> 
							  </li> 
							  <li class="li3"> 
								  <a href="member/getmoney.php">线上取款</a> 
							  </li> 
							  <li class="li4"> 
								  <a href="member/zr_money.php">额度转换</a> 
							  </li> 
							  <li class="li5"> 
								  <a href="member/orders.php">财务记录</a> 
							  </li> 
							  <li class="li6"> 
								  <a href="member/records_ty.php?a_type=ds">下注记录</a> 
							  </li> 
							  <li class="li7"> 
								  <a href="common/result.php">开奖结果</a> 
							  </li> 
							  <li class="li8"> 
								  <a href="../logout.php">安全登出</a> 
							  </li> 
						  </ul> 
					  </div>
				  </div>
			  </div>
			  <?php endif; ?>
			  <div class="c2 "> 
				  <div class="slideTxtBox"> 
					  <div class="bd"> 
						  <ul class="mui-row"> 
						  		<li > 
								  <a href="/cq9?m=true" title="CQ9电子"> 
									  <img src="images/game/cq9.png" alt="CQ9电子" /> 
									  CQ9电子 
								  </a> 
							  </li> 
			
							   <li > 
								  <a href="javascript:void(0);" onClick="window.open('/kg?m=true')"   title="AV女优"> 
									  <img src="images/game/av.png" alt="AV女优" /> 
									  AV女优 
								  </a> 
							  </li> 
							  <li> 
								  <a href="javascript:void(0);" onClick="submitlive('<?=$uid?>','BBIN&amp;gameType=1');"  title="BB波音厅"> 
									  <img src="images/game/c1imgbbin.png" alt="BB波音厅" /> 
									  BB波音厅 
								  </a> 
							  </li> 
							  <li> 
								  <a href="javascript:void(0);" onClick="submitlive('<?=$uid?>','AGIN&amp;mobile=true');"  title="AG国际厅"> 
									  <img src="images/game/c1imgag.png" alt="AG国际厅" /> 
									  AG国际厅 
								  </a> 
							  </li> 
							  <li style="border-right;">
								  <a href="javascript:void(0);" onClick="submitlive('<?=$uid?>','AGIN&amp;mobile=true');"  title="AG极速厅"> 
									  <img src="images/game/c1imgagmg.png" alt="AG极速厅" /> 
									  AG极速厅 
								  </a> 
							  </li> 
							  <li> 
								  <a href="javascript:void(0);" onClick="submitlive('<?=$uid?>','OG&amp;mobile=true');"  title="OG东方厅"> 
									  <img src="images/game/c1imgog.png" alt=" OG东方厅" /> 
									  OG东方厅 
								  </a> 
							  </li> 
							  <li> 
								  <a href="javascript:;" onclick="window.open('../egame/egame.php?m=true&amp;p=MG', '_blank')"  title="MG电子"> 
									  <img src="images/game/c1imgnmg.png" alt="MG电子" /> 
									  MG电子 
								  </a> 
							  </li> 
							  <li> 
								  <a href="javascript:;" onclick="window.open('../egame/egame.php?m=true&amp;p=PT', '_blank')"  title="PT电子"> 
									  <img src="images/game/c1imgjst_sp_pt.png" alt="PT电子" /> 
									  PT电子 
								  </a> 
							  </li> 
							  <li style="border-right:">
								  <a href="javascript:;" onclick="window.open('../egame/egame.php?m=true&amp;p=XIN', '_blank')"  title="XIN电子"> 
									  <img src="images/game/c1imgjst_sp_xin.png" alt="XIN电子" /> 
									  XIN电子 
								  </a> 
							  </li> 
							  <li> 
								  <a href="lotto/index.php" title="香港六合彩"> 
									  <img src="images/game/c2img_lhc.png" alt="香港六合彩"> 
								  </a> 
								  香港六合彩 
							  </li> 
							  <li> 
								  <a href="lottery/cqssc.php" title="重庆时时彩"> 
									  <img src="images/game/c2img_ssc_cq.png" alt="重庆时时彩"> 
								  </a> 
								  重庆时时彩 
							  </li> 
							  <li style="border-right:">
								  <a href="lottery/bjsc.php" title="北京PK拾"> 
									  <img src="images/game/c2img_pk10.png" alt="北京PK拾"> 
								  </a> 
								  北京PK拾 
							  </li> 
							  <li style="border-right:">
								  <a href="lottery/xyft.php" title="北京PK拾"> 
									  <img src="images/game/c2img_pk10.png" alt="北京PK拾"> 
								  </a> 
								  幸运飞艇 
							  </li>
							  <li> 
								  <a href="lottery/gdkls.php" title="广东快乐10分"> 
									  <img src="images/game/c2img_klsf_gd.png" alt="广东快乐10分"> 
								  </a> 
								  广东快乐10分 
							  </li> 
							  <li> 
								  <a href="lottery/ssl.php" title="上海时时乐"> 
									  <img src="images/game/c2img_ssl.png" alt="上海时时乐"> 
								  </a> 
								  上海时时乐 
							  </li> 
							  <li style="border-right:">
								  <a href="lottery/kl8.php" title="北京快乐8"> 
									  <img src="images/game/c2img_kl8.png" alt="北京快乐8"> 
								  </a> 
								  北京快乐8 
							  </li>
							  <li> 
								  <a href="lottery/3d.php" title="福彩3D"> 
									  <img src="images/game/c2img_3d.png" alt="福彩3D"> 
								  </a> 
								  福彩3D 
							  </li> 
							  <li> 
								  <a href="lottery/pl3.php" title="排列三"> 
									  <img src="images/game/c2img_pl3.png" alt="排列三"> 
								  </a> 
								  排列三 
							  </li> 
							  <li style="border-right:">
								  <a href="lottery/qxc.php"   title="七星彩"> 
									  <img src="images/game/c2img_qxc.png" alt="七星彩" /> 
									  七星彩 
								  </a> 
							  </li> 
								<li style="border-right:">
								  <a href="lottery/jssc.php"   title="极速赛车"> 
									  <img src="images/game/js_sc.png" alt="极速赛车" /> 
									  极速赛车 
								  </a> 
							  </li> 
							  <li style="border-right:">
								  <a href="lottery/jsssc.php"   title="极速时时彩"> 
									  <img src="images/game/js_ssc.png" alt="极速时时彩" /> 
									  极速时时彩 
								  </a> 
							  </li> 
							  <li style="border-right:">
								  <a href="lottery/jslh.php"   title="极速六合彩"> 
									  <img src="images/game/js_lh.png" alt="极速六合彩" /> 
									  极速六合
								  </a> 
							  </li> 
							  <li> 
								  <a href="sports/index.php"   title="皇冠体育手机版"> 
									  <img src="images/game/c1imgjst_sp_ismart.png" alt="皇冠体育" /> 
									  皇冠体育手机版 
								  </a> 
							  </li> 
							  <li> 
								  <a href="javascript:void(0);" onClick="submitlive('<?=$uid?>','SHABA&amp;mobile=true');"  title="沙巴体育"> 
									  <img src="images/game/c1imgjst_sp_iwap.png" alt="沙巴体育"  /> 
									  沙巴体育
								  </a> 
							  </li> 
							  <li> 
								  <a href="javascript:void(0);" onClick="submitlive('<?=$uid?>','MAYA&amp;mobile=true');"  title="玛雅娱乐厅"> 
									  <img src="images/game/maya.png" alt="玛雅娱乐厅" style="width:auto;" /> 
									  玛雅娱乐厅
								  </a> 
							  </li>
							   <li > 
								  <a href="javascript:void(0);" onClick="submitlive('<?=$uid?>','AGIN&amp;mobile=true&gameType=6');"   title="捕鱼王Ⅱ"> 
									  <img src="images/game/byw2.png" alt="捕鱼王Ⅱ" /> 
									  AG捕鱼王Ⅱ 
								  </a> 
							  </li> 
							  <!--li> 
								  <a href="http://wpa.qq.com/msgrd?v=3&uin=87505777&site=qq&menu=yes"  title="87505777" target="_blank"> 
									  <img src="images/game/c1imgjst_sp_qq.png" alt="87505777"  /> 
									  87505777
								  </a> 
							  </li--> 
							  <li style="border-right:">
								  <a href="<?php if($uid){ ?>sign.php<?php }else{ ?>javascript:;" onclick="alert('请先登录')<?php } ?>" title="会员签到"> 
									  <img src="images/game/c1imgjst_sp_sign.png" alt="会员签到"> 
									  会员签到
								  </a> 
							  </li> 
							  
						  </ul> 
					  </div> 
				  </div> 
			  </div> 
			  <!--.c2--> 
			  <div class="c3"> 
				  <div class="lbg"> 
					  <div class="rbg"> 
						  <ul class="cl"> 
							  <li class="li1" style="float:left;padding-right:0;"> 
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
							  <li class="li2" style="float:right;"> 
								  <div class="lbg1"> 
									  <div class="rbg1"> 
										  <div class="bg1"> 
											  <a class="cl" href="javascript:void(0);" onClick="menu_url(62);return false;" target="self"> 
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
	  <?php include_once 'bottom.php';?>
		</div>
		<script src="./mui/js/mui.min.js"></script>
		
		<script>
		$(function(){
            list = $('.slideTxtBox>div>ul').children("li");
            appendNum = 3 - list.length % 3;
            for(var i=0;i<appendNum && appendNum !=3 ;i++){
                $('.slideTxtBox>div>ul').append('<li style="border-right;"><a href="javascript:thankyou();" title="敬请期待"><img src="images/game/c2img_more.png" alt="敬请期待"></a>敬请期待</li> ')
            }
            
            list = $('.slideTxtBox>div>ul').children("li");
            for(var i=0;i<list.length;i++){
                $(list[i]).attr('style','');
                //$(list[i]).addClass('mui-col-sm-4 mui-col-xs-4');
                if(i%3 == 2 ) $(list[i]).attr('style','border-right:0');
            }
			mui.init();
			 ini_slider('.banner', true, true);
			 $('.notice').click(function(){
		  		content = '<div class="mui-slider" id="slider" style="height:200px;text-align:left;"><div class="mui-slider-group">' + $('.notice .mui-slider-group').html() + '</div></div>';
				mui.alert(content, '最新公告','',null);
				ini_slider("#slider", false, true)
		  	});
          })
            
            function ini_slider(name, loop, indicator){
                slider = $(name);
                slider_group = $(name +' .mui-slider-group');
                if(indicator){
                    item_arr = slider_group.children('.mui-slider-item');
                    slider_indicator = $('<div class="mui-slider-indicator"></div>');
                    for(i=0;i<item_arr.length;i++) {
                        if(i === 0) slider_indicator.append('<div class="mui-indicator mui-active"></div>');
                        else slider_indicator.append('<div class="mui-indicator"></div>');
                    }
                    slider.append(slider_indicator);
                }
                if(loop){
                    slider_group.addClass('mui-slider-loop');
                    item = $('<div class="mui-slider-item mui-slider-item-duplicate"></div>');
                    last_html = slider_group.find('.mui-slider-item:last').html();
                    first_html = slider_group.find('.mui-slider-item:first').html();
                    slider_group.prepend(item.clone().html(last_html));
                    slider_group.append(item.clone().html(first_html));
                }
                if(loop){
                    mui(name).slider({interval:5000});
                }else{
                    mui(name).slider({});
                }
            }
		</script>
		<?php if ($uid){?> <script language="javascript">top_money();</script><?php }?>
	</body>
</html>