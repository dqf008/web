<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '../../cache/group_' . @($_SESSION['gid']) . '.php';
$cp_zd = @($pk_db['彩票最低']);
$cp_zg = @($pk_db['彩票最高']);
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
if (intval($web_site['ssc']) == 1){
	message('重庆时时彩系统维护，暂停下注！');
	exit();
}
?> 
<!DOCTYPE html> 
<html class="ui-mobile ui-mobile-viewport ui-overlay-a"> 
<head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title><?=$web_site['web_title'];?></title> 
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> 
  <meta content="yes" name="apple-mobile-web-app-capable"> 
  <meta content="black" name="apple-mobile-web-app-status-bar-style"> 
  <meta content="telephone=no" name="format-detection"> 
  <meta name="viewport" content="width=device-width"> 
  <link rel="shortcut icon" href="../images/favicon.ico"> 
  <link rel="stylesheet" href="../css/style.css"> 
  <link rel="stylesheet" href="../js/jquery.mobile-1.4.5.min.css"> 
  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"> 
  </script> 
  <script type="text/javascript" src="../js/jquery.mobile-1.4.5.min.js"> 
  </script> 
  <!--js判断横屏竖屏自动刷新--> 
  <script type="text/javascript" src="../js/top.js"> 
  </script> 
  <style type="text/css"> 
	  .bian_td_odds {  
		  color: red;
	  }  
	  .ui-block-a, .ui-block-b, .ui-block-c { 
		  border: 1px solid black;
		  height: 35px;
		  font-weight: bold;
	  }  
	  .ui-grid-b{  
		  padding-right: 6px;
		  text-align: center;
	  } 
	  .caipiao-bgc-a {  
		  padding-top:6px;
		  background-color: #FCF8E9;
	  }  
	  .caipiao-bgc-a1 {  
		  padding-top: 2px;
		  background-color:#FCF8E9;
	  }  
	  .caipiao-bgc-b {  
		  padding-top: 6px;
		  background-color: #EEEEEE;
	  }  
	  .caipiao-bgc-c {  
		  padding-top: 2px;
		  background-color: #EEEEEE;
	  }  
	  .caipiao-bgc-abc{  
		  padding-top: 6px;
		  background-color: lightgray;
	  }  
	  .caipiao-circle-a { 
		  width: 30px;
		  height: 30px;
		  background-color: #ffc1c1;
		  border-radius: 20px;
	  }  
	  .caipiao-circle-b {  
		  height: 30px;
		  line-height: 30px;
		  display: block;
		  color: #000;
		  text-align: center;
		  font-size: 18px;
	  }  
	  .caipiao-info {  
		  border-width:1px;
		  border-color: lightgray;
		  border-style: solid;
		  padding: 5px;
	  } 
  </style> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 659px;"> 
  <input id="uid" name="uid" value="<?=$uid;?>" type="hidden"/> 
  <!--头部开始--> 
  <header id="header">
	  <?php if ($uid != 0){?> <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a><?php }?> 		  
	  <span>彩票游戏</span> 
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"> 
	  </a> 
  </header> 
  <div class="mrg_header"> 
  </div> 
  <!--头部结束--> 
  <div style="display: none;" id="popupPanel-placeholder"> 
	  <!-- placeholder for popupPanel --> 
  </div> 
  <!--功能列表--> 
  <section class="sliderWrap clearfix"> 
	  <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit"> 
		  <h1 class="ui-title" role="heading" aria-level="1"> 
			  重庆时时彩 
		  </h1> 
	  </div> 
	  <div class="caipiao-info"> 
		  <div> 
			  第 
			  <span id="numbers" style="color:#f60;font-weight:bold;"> 
				  00000000-000 
			  </span> 
			  期开奖结果： 
			  <span id="autoinfo"  style="color:#f60;"> 
				  0 0 0 0 0  
			  </span> 
		  </div> 
		  <div style="font-size:12pt;"> 
			  第 
			  <span id="open_qihao" style="color:#f60;font-weight:bold;"> 
				  00000000-000 
			  </span> 
			  期<span id="endhtml">距离封盘</span>： 
			  <span id="endtime" style="color:#f60;font-weight:bold;"> 
				  00:00:00 
			  </span> 
		  </div> 
	  </div> 
  </section> 
  <section class="mContent clearfix" style="padding:0px;"> 
      <div data-role="cotent"> 
          <ul data-role="listview" class="ui-listview"> 
              <li class="ui-li-static ui-body-inherit ui-first-child" id="lot_quick" style="text-align:center"> 
                <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
                    <legend class="ui-hidden-accessible">Horizontal controlgroup, radio:</legend>
                    <input type="radio" name="radio-choice-h-8" id="radio-choice-h-8a" value="general" checked="checked">
                    <label for="radio-choice-h-8a">常规下注</label>
                    <input type="radio" name="radio-choice-h-8" id="radio-choice-h-8b" value="quick">
                    <label for="radio-choice-h-8b">快捷下注</label>
                </fieldset>
              </li>
              <li class="ui-li-static ui-body-inherit" style="display:none;padding:0"> 
                <div style="width:100%;background-color:#fff;top:36px;z-index:2">
                    <div style="margin:.7em 1em;text-align:center">
                      <label><input type="text" placeholder="下注金额" /></label> 
                      <div>
                        <a href="javascript:;" class="ui-btn ui-btn-inline ui-shadow ui-corner-all" data-rel="dialog">取消下注</a>
                        <a href="javascript:;" class="ui-btn ui-btn-inline ui-shadow ui-corner-all" data-rel="dialog" style="margin-right:0">确认下注</a>
                      </div>
                    </div>
                </div>
              </li>
          </ul> 
      </div> 
  </section> 
  <script type="text/javascript">
    $(document).ready(function(){
        var bet_mode, quick_input = $("#lot_quick").siblings();
        $("#lot_quick").find("input").on("click", function(){
            bet_mode = $(this).val();
            if(bet_mode=="quick"){
                quick_input.show().height(quick_input.height());
                $(".ui-block-c").filter(".caipiao-bgc-abc").find("span").html("选择");
                $("section").last().find("div").last().hide();
                $.cookie("m_lot_quick", "true", {expires: 7, path: "/"});
            }else{
                quick_input.hide();
                $(".ui-block-c").filter(".caipiao-bgc-abc").find("span").html("金额");
                $(".bian_td_inp").find("span").remove();
                $("section").last().find("div").last().show();
                $.cookie("m_lot_quick", "false", {expires: -1, path: "/"});
            }
            $("form").trigger("reset");
        });
        quick_input.find("input").on("keyup", function(){
            var v = $(this).val(), n = v.replace(/[^\d]/g, "");
            v!=n && $(this).val(n);
        })
        quick_input.find("div > a").on("click", function(){
            if($(this).index()>0){
                var v = $(this).parents("div").find("input").val();
                $(".quick_selected").find("input").val(v.replace(/[^\d]/g, "")),
                sub_bet();
            }else{
                $("form").trigger("reset");
            }
        })
        $(".caipiao-bgc-a, .caipiao-bgc-b, .caipiao-bgc-c, .caipiao-bgc-a1").on("click", function(){
            var e = $(this), i, v = quick_input.find("input").val();
            bet_mode=="quick" && (!e.hasClass("ui-block-c") && (e = e.nextAll(".ui-block-c").first()), i = e.find("input"), i.length>0 && (e.hasClass("quick_selected") ? (i.val(""), i.siblings().html(""), e.prevAll().andSelf().slice(-3).css("background-color", "").removeClass("quick_selected")) : (i.val(v), i.siblings().html("√"), e.prevAll().andSelf().slice(-3).css("background-color", "#cddc39").addClass("quick_selected"))))
        });
        $("form").on("reset", function(){
            $(".quick_selected").css("background-color", "").removeClass("quick_selected").find(".bian_td_inp > span").html("");
        })
        $(document).scroll(function(){quickTop()});
        $(window).resize(function(){quickTop()});
        function quickTop(){
            var offsetTop = quick_input.offset().top, scrollTop = $(document).scrollTop(), e = quick_input.children("div");
            return !quick_input.is(":hidden") && e.css({"position": (offsetTop-scrollTop>36 ? "static" : "fixed"), "box-shadow": (offsetTop-scrollTop>36 ? "none" : "0 0 8px rgba(0, 0, 0, 0.5), 0 0 256px rgba(255, 255, 255, .3)")});
        }
        $.cookie("m_lot_quick")=="true" && $("#lot_quick").find("input").last().prev().trigger("click");
        setInterval(function(){
            var hasInput = $(".bian_td_inp").find("input").length>0;
            if(bet_mode=="quick"){
                hasInput && $(".bian_td_inp").find("span").length<=0 && ($(".bian_td_inp").append("<span></span>").find("input").hide());
                pankouflag==false && $(".quick_selected").length>0 && $("form").trigger("reset");
            }else{
                hasInput && ($(".bian_td_inp").find("input").show().siblings().remove());
            }
        }, 250);
    });
    (function($) {
        $.cookie = function(key, value, options) {

            // key and at least value given, set cookie...
            if (arguments.length > 1 && (!/Object/.test(Object.prototype.toString.call(value)) || value === null || value === undefined)) {
                options = $.extend({}, options);

                if (value === null || value === undefined) {
                    options.expires = -1;
                }

                if (typeof options.expires === 'number') {
                    var days = options.expires, t = options.expires = new Date();
                    t.setDate(t.getDate() + days);
                }

                value = String(value);

                return (document.cookie = [
                    encodeURIComponent(key), '=', options.raw ? value : encodeURIComponent(value),
                    options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                    options.path    ? '; path=' + options.path : '',
                    options.domain  ? '; domain=' + options.domain : '',
                    options.secure  ? '; secure' : ''
                ].join(''));
            }

            // key and possibly options given, get cookie...
            options = value || {};
            var decode = options.raw ? function(s) { return s; } : decodeURIComponent;

            var pairs = document.cookie.split('; ');
            for (var i = 0, pair; pair = pairs[i] && pairs[i].split('='); i++) {
                if (decode(pair[0]) === key) return decode(pair[1] || ''); // IE saves cookies with empty string as "c; ", e.g. without "=" as opposed to EOMB, thus pair[1] may be undefined
            }
            return null;
        };
    })(jQuery);
  </script>
  <!--盘口列表--> 
  <form id="cqsscOrder" name="cqsscOrder"  action="cqsscOrder.php?type=2" method="post"> 
  <section class="mContent clearfix" style="padding:0px;"> 
	  <div data-role="collapsibleset" data-theme="b" data-content-theme="a" 
	  data-iconpos="right" data-inset="false" class="ui-collapsible-set ui-group-theme-b"> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  第一球(万位) 
			  </h4> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-abc"> 
					  <span> 
						  选项 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-abc"> 
					  <span> 
						  赔率 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-abc"> 
					  <span> 
						  金额 
					  </span> 
				  </div> 
			  </div> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  0 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h1"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t1"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  1 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h2"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t2"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  2 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h3"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t3"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  3 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h4"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t4"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  4 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h5"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t5"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  5 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h6"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t6"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  6 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h7"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t7"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  7 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h8"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t8"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  8 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h9"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t9"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  9 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h10"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t10"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  大 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h11"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t11"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  小 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h12"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t12"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  单 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h13"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t13"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  双 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_1_h14"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_1_t14"> 
						  -- 
					  </span> 
				  </div> 
			  </div> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  第二球(千位) 
			  </h4> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-abc"> 
					  <span> 
						  选项 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-abc"> 
					  <span> 
						  赔率 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-abc"> 
					  <span> 
						  金额 
					  </span> 
				  </div> 
			  </div> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  0 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h1"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t1"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  1 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h2"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t2"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  2 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h3"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t3"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  3 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h4"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t4"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  4 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h5"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t5"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  5 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h6"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t6"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  6 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h7"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t7"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  7 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h8"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t8"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  8 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h9"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t9"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  9 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h10"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t10"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  大 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h11"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t11"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  小 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h12"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t12"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  单 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h13"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t13"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  双 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_2_h14"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_2_t14"> 
						  -- 
					  </span> 
				  </div> 
			  </div> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  第三球(百位) 
			  </h4> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-abc"> 
					  <span> 
						  选项 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-abc"> 
					  <span> 
						  赔率 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-abc"> 
					  <span> 
						  金额 
					  </span> 
				  </div> 
			  </div> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  0 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h1"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t1"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  1 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h2"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t2"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  2 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h3"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t3"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  3 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h4"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t4"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  4 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h5"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t5"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  5 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h6"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t6"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  6 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h7"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t7"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  7 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h8"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t8"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  8 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h9"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t9"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  9 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h10"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t10"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  大 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h11"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t11"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  小 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h12"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t12"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  单 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h13"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t13"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  双 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_3_h14"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_3_t14"> 
						  -- 
					  </span> 
				  </div> 
			  </div> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  第四球(十位) 
			  </h4> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-abc"> 
					  <span> 
						  选项 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-abc"> 
					  <span> 
						  赔率 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-abc"> 
					  <span> 
						  金额 
					  </span> 
				  </div> 
			  </div> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  0 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h1"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t1"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  1 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h2"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t2"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  2 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h3"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t3"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  3 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h4"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t4"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  4 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h5"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t5"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  5 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h6"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t6"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  6 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h7"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t7"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  7 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h8"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t8"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  8 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h9"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t9"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  9 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h10"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t10"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  大 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h11"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t11"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  小 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h12"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t12"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  单 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h13"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t13"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  双 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_4_h14"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_4_t14"> 
						  -- 
					  </span> 
				  </div> 
			  </div> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  第五球(个位) 
			  </h4> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-abc"> 
					  <span> 
						  选项 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-abc"> 
					  <span> 
						  赔率 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-abc"> 
					  <span> 
						  金额 
					  </span> 
				  </div> 
			  </div> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  0 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h1"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t1"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  1 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h2"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t2"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  2 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h3"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t3"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  3 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h4"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t4"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  4 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h5"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t5"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  5 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h6"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t6"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  6 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h7"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t7"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  7 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h8"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t8"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  8 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h9"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t9"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
					  <div class="caipiao-circle-a"> 
						  <span class="caipiao-circle-b"> 
							  9 
						  </span> 
					  </div> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h10"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t10"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  大 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h11"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t11"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  小 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h12"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t12"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  单 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h13"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t13"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  双 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_5_h14"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_5_t14"> 
						  -- 
					  </span> 
				  </div> 
			  </div> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  总和/龙虎和 
			  </h4> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-abc"> 
					  <span> 
						  选项 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-abc"> 
					  <span> 
						  赔率 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-abc"> 
					  <span> 
						  金额 
					  </span> 
				  </div> 
			  </div> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  总和大 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_6_h1"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_6_t1"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  总和小 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_6_h2"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_6_t2"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  总和单 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_6_h3"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_6_t3"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  总和双 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_6_h4"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_6_t4"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  龙 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_6_h5"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_6_t5"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  虎 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_6_h6"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_6_t6"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  和 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_6_h7"> 
						  9 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_6_t7"> 
						  -- 
					  </span> 
				  </div> 
			  </div> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  前三球 
			  </h4> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-abc"> 
					  <span> 
						  选项 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-abc"> 
					  <span> 
						  赔率 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-abc"> 
					  <span> 
						  金额 
					  </span> 
				  </div> 
			  </div> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  豹子 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_7_h1"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_7_t1"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  顺子 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_7_h2"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_7_t2"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  对子 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_7_h3"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_7_t3"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  半顺 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_7_h4"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_7_t4"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  杂六 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_7_h5"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_7_t5"> 
						  -- 
					  </span> 
				  </div> 
			  </div> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  中三球 
			  </h4> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-abc"> 
					  <span> 
						  选项 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-abc"> 
					  <span> 
						  赔率 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-abc"> 
					  <span> 
						  金额 
					  </span> 
				  </div> 
			  </div> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  豹子 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_8_h1"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_8_t1"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  顺子 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_8_h2"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_8_t2"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  对子 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_8_h3"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_8_t3"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  半顺 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_8_h4"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_8_t4"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  杂六 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_8_h5"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_8_t5"> 
						  -- 
					  </span> 
				  </div> 
			  </div> 
		  </div> 
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed ui-last-child"> 
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
				  后三球 
			  </h4> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-abc"> 
					  <span> 
						  选项 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-abc"> 
					  <span> 
						  赔率 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-abc"> 
					  <span> 
						  金额 
					  </span> 
				  </div> 
			  </div> 
			  <div class="ui-grid-b"> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  豹子 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_9_h1"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_9_t1"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  顺子 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_9_h2"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_9_t2"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  对子 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_9_h3"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_9_t3"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  半顺 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_9_h4"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_9_t4"> 
						  -- 
					  </span> 
				  </div> 
				  <div class="ui-block-a caipiao-bgc-a"> 
					  <span> 
						  杂六 
					  </span> 
				  </div> 
				  <div class="ui-block-b caipiao-bgc-b"> 
					  <span class="bian_td_odds" id="ball_9_h5"> 
						  - 
					  </span> 
				  </div> 
				  <div class="ui-block-c caipiao-bgc-c"> 
					  <span class="bian_td_inp" id="ball_9_t5"> 
						  -- 
					  </span> 
				  </div> 
			  </div> 
		  </div> 
	  </div> 
	  <div style="clear:both;padding-bottom:5px;text-align:center;"> 
		  <p>☆最低金额:<font color="#FF0000"><?=$cp_zd;?></font>&nbsp;&nbsp;☆单注限额:<font color="#FF0000"><?=$cp_zg;?></font></p> 
	  </div> 
	  <div style="clear:both;text-align:center;"> 
		  <a class="ui-btn ui-btn-inline" href="javascript:del_bet();"/> 
			  取消下注 
		  </a> 
		  <a class="ui-btn ui-btn-inline" href="javascript:sub_bet();"> 
			  确认下注 
		  </a> 
	  </div> 
  </section> 
  </form> 
  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束--> 
  <!--我的资料--><?php include_once '../member/myinfo.php';?>	  
  <script type="text/javascript" src="../js/cqssc.js"></script> 
  <script type="text/javascript"> 
	  $(function() { 
		  loadinfo();
	  });
  </script> 
</body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"> 
  <span class="ui-icon-loading"> 
  </span> 
  <h1> 
	  loading 
  </h1> 
</div> 
</html>