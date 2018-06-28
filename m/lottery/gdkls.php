<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
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
	  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script> 
	  <script type="text/javascript" src="../js/jquery.mobile-1.4.5.min.js"></script> 
	  <!--js判断横屏竖屏自动刷新--> 
	  <script type="text/javascript" src="../js/top.js"></script> 
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
  <body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page"  tabindex="0" style="min-height: 659px;"> 
	  <input id="uid" value="<?=$uid;?>" type="hidden"> 
	  <!--头部开始--> 
	  <header id="header">
		  <?php if ($uid != 0){?><a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a><?php }?> 			  
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
				  广东快乐10分 
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
			  <span id="endtime" style="color:#f60;font-weight:bold;">00:00:00</span> 
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
	  <!--赛事列表--> 
	  <form id="gdklsOrder" name="gdklsfOrder"  action="gdklsOrder.php?type=3" method="post"> 
	  <section class="mContent clearfix" style="padding:0px;"> 
		  <div data-role="collapsibleset" data-theme="b" data-content-theme="a" 
		  data-iconpos="right" data-inset="false" class="ui-collapsible-set ui-group-theme-b"> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-first-child"> 
				  <h4 class="ui-collapsible-heading"> 
					  第一球 
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
								  01 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h1"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t1"> 
							  <input id="ball_1_1" name="ball_1_1" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  02 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h2"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t2"> 
							  <input id="ball_1_2" name="ball_1_2" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  03 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h3"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t3"> 
							  <input id="ball_1_3" name="ball_1_3" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  04 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h4"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t4"> 
							  <input id="ball_1_4" name="ball_1_4" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  05 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h5"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t5"> 
							  <input id="ball_1_5" name="ball_1_5" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  06 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h6"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t6"> 
							  <input id="ball_1_6" name="ball_1_6" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  07 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h7"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t7"> 
							  <input id="ball_1_7" name="ball_1_7" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  08 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h8"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t8"> 
							  <input id="ball_1_8" name="ball_1_8" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  09 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h9"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t9"> 
							  <input id="ball_1_9" name="ball_1_9" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  10 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h10"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t10"> 
							  <input id="ball_1_10" name="ball_1_10" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  11 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h11"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t11"> 
							  <input id="ball_1_11" name="ball_1_11" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  12 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h12"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t12"> 
							  <input id="ball_1_12" name="ball_1_12" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  13 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h13"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t13"> 
							  <input id="ball_1_13" name="ball_1_13" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  14 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h14"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t14"> 
							  <input id="ball_1_14" name="ball_1_14" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  15 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h15"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t15"> 
							  <input id="ball_1_15" name="ball_1_15" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  16 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h16"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t16"> 
							  <input id="ball_1_16" name="ball_1_16" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  17 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h17"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t17"> 
							  <input id="ball_1_17" name="ball_1_17" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  18 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h18"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t18"> 
							  <input id="ball_1_18" name="ball_1_18" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  19 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h19"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t19"> 
							  <input id="ball_1_19" name="ball_1_19" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  20 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h20"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t20"> 
							  <input id="ball_1_20" name="ball_1_20" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h21"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t21"> 
							  <input id="ball_1_21" name="ball_1_21" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h22"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t22"> 
							  <input id="ball_1_22" name="ball_1_22" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h23"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t23"> 
							  <input id="ball_1_23" name="ball_1_23" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h24"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t24"> 
							  <input id="ball_1_24" name="ball_1_24" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h25"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t25"> 
							  <input id="ball_1_25" name="ball_1_25" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h26"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t26"> 
							  <input id="ball_1_26" name="ball_1_26" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h27"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t27"> 
							  <input id="ball_1_27" name="ball_1_27" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h28"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t28"> 
							  <input id="ball_1_28" name="ball_1_28" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  东 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h29"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t29"> 
							  <input id="ball_1_29" name="ball_1_29" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  南 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h30"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t30"> 
							  <input id="ball_1_30" name="ball_1_30" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  西 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h31"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t31"> 
							  <input id="ball_1_31" name="ball_1_31" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  北 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h32"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t32"> 
							  <input id="ball_1_32" name="ball_1_32" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  中 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h33"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t33"> 
							  <input id="ball_1_33" name="ball_1_33" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  发 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h34"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t34"> 
							  <input id="ball_1_34" name="ball_1_34" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  白 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_1_h35"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_1_t35"> 
							  <input id="ball_1_35" name="ball_1_35" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
				  </div> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
					  第二球 
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
								  01 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h1"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t1"> 
							  <input id="ball_2_1" name="ball_2_1" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  02 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h2"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t2"> 
							  <input id="ball_2_2" name="ball_2_2" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  03 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h3"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t3"> 
							  <input id="ball_2_3" name="ball_2_3" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  04 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h4"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t4"> 
							  <input id="ball_2_4" name="ball_2_4" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  05 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h5"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t5"> 
							  <input id="ball_2_5" name="ball_2_5" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  06 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h6"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t6"> 
							  <input id="ball_2_6" name="ball_2_6" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  07 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h7"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t7"> 
							  <input id="ball_2_7" name="ball_2_7" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  08 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h8"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t8"> 
							  <input id="ball_2_8" name="ball_2_8" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  09 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h9"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t9"> 
							  <input id="ball_2_9" name="ball_2_9" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  10 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h10"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t10"> 
							  <input id="ball_2_10" name="ball_2_10" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  11 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h11"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t11"> 
							  <input id="ball_2_11" name="ball_2_11" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  12 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h12"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t12"> 
							  <input id="ball_2_12" name="ball_2_12" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  13 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h13"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t13"> 
							  <input id="ball_2_13" name="ball_2_13" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  14 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h14"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t14"> 
							  <input id="ball_2_14" name="ball_2_14" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  15 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h15"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t15"> 
							  <input id="ball_2_15" name="ball_2_15" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  16 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h16"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t16"> 
							  <input id="ball_2_16" name="ball_2_16" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  17 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h17"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t17"> 
							  <input id="ball_2_17" name="ball_2_17" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  18 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h18"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t18"> 
							  <input id="ball_2_18" name="ball_2_18" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  19 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h19"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t19"> 
							  <input id="ball_2_19" name="ball_2_19" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  20 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h20"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t20"> 
							  <input id="ball_2_20" name="ball_2_20" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h21"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t21"> 
							  <input id="ball_2_21" name="ball_2_21" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h22"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t22"> 
							  <input id="ball_2_22" name="ball_2_22" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h23"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t23"> 
							  <input id="ball_2_23" name="ball_2_23" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h24"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t24"> 
							  <input id="ball_2_24" name="ball_2_24" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h25"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t25"> 
							  <input id="ball_2_25" name="ball_2_25" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h26"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t26"> 
							  <input id="ball_2_26" name="ball_2_26" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h27"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t27"> 
							  <input id="ball_2_27" name="ball_2_27" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h28"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t28"> 
							  <input id="ball_2_28" name="ball_2_28" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  东 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h29"> 
							  3.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t29"> 
							  <input id="ball_2_29" name="ball_2_29" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  南 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h30"> 
							  3.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t30"> 
							  <input id="ball_2_30" name="ball_2_30" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  西 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h31"> 
							  3.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t31"> 
							  <input id="ball_2_31" name="ball_2_31" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  北 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h32"> 
							  3.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t32"> 
							  <input id="ball_2_32" name="ball_2_32" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  中 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h33"> 
							  2.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t33"> 
							  <input id="ball_2_33" name="ball_2_33" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  发 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h34"> 
							  2.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t34"> 
							  <input id="ball_2_34" name="ball_2_34" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  白 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_2_h35"> 
							  2.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_2_t35"> 
							  <input id="ball_2_35" name="ball_2_35" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
				  </div> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
					  第三球 
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
								  01 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h1"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t1"> 
							  <input id="ball_3_1" name="ball_3_1" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  02 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h2"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t2"> 
							  <input id="ball_3_2" name="ball_3_2" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  03 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h3"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t3"> 
							  <input id="ball_3_3" name="ball_3_3" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  04 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h4"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t4"> 
							  <input id="ball_3_4" name="ball_3_4" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  05 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h5"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t5"> 
							  <input id="ball_3_5" name="ball_3_5" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  06 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h6"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t6"> 
							  <input id="ball_3_6" name="ball_3_6" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  07 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h7"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t7"> 
							  <input id="ball_3_7" name="ball_3_7" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  08 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h8"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t8"> 
							  <input id="ball_3_8" name="ball_3_8" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  09 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h9"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t9"> 
							  <input id="ball_3_9" name="ball_3_9" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  10 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h10"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t10"> 
							  <input id="ball_3_10" name="ball_3_10" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  11 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h11"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t11"> 
							  <input id="ball_3_11" name="ball_3_11" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  12 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h12"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t12"> 
							  <input id="ball_3_12" name="ball_3_12" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  13 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h13"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t13"> 
							  <input id="ball_3_13" name="ball_3_13" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  14 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h14"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t14"> 
							  <input id="ball_3_14" name="ball_3_14" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  15 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h15"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t15"> 
							  <input id="ball_3_15" name="ball_3_15" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  16 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h16"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t16"> 
							  <input id="ball_3_16" name="ball_3_16" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  17 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h17"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t17"> 
							  <input id="ball_3_17" name="ball_3_17" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  18 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h18"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t18"> 
							  <input id="ball_3_18" name="ball_3_18" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  19 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h19"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t19"> 
							  <input id="ball_3_19" name="ball_3_19" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  20 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h20"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t20"> 
							  <input id="ball_3_20" name="ball_3_20" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h21"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t21"> 
							  <input id="ball_3_21" name="ball_3_21" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h22"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t22"> 
							  <input id="ball_3_22" name="ball_3_22" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h23"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t23"> 
							  <input id="ball_3_23" name="ball_3_23" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h24"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t24"> 
							  <input id="ball_3_24" name="ball_3_24" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h25"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t25"> 
							  <input id="ball_3_25" name="ball_3_25" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h26"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t26"> 
							  <input id="ball_3_26" name="ball_3_26" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h27"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t27"> 
							  <input id="ball_3_27" name="ball_3_27" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h28"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t28"> 
							  <input id="ball_3_28" name="ball_3_28" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  东 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h29"> 
							  3.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t29"> 
							  <input id="ball_3_29" name="ball_3_29" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  南 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h30"> 
							  3.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t30"> 
							  <input id="ball_3_30" name="ball_3_30" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  西 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h31"> 
							  3.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t31"> 
							  <input id="ball_3_31" name="ball_3_31" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  北 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h32"> 
							  3.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t32"> 
							  <input id="ball_3_32" name="ball_3_32" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  中 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h33"> 
							  2.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t33"> 
							  <input id="ball_3_33" name="ball_3_33" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  发 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h34"> 
							  2.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t34"> 
							  <input id="ball_3_34" name="ball_3_34" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  白 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_3_h35"> 
							  2.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_3_t35"> 
							  <input id="ball_3_35" name="ball_3_35" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
				  </div> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
					  第四球 
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
								  01 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h1"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t1"> 
							  <input id="ball_4_1" name="ball_4_1" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  02 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h2"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t2"> 
							  <input id="ball_4_2" name="ball_4_2" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  03 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h3"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t3"> 
							  <input id="ball_4_3" name="ball_4_3" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  04 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h4"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t4"> 
							  <input id="ball_4_4" name="ball_4_4" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  05 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h5"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t5"> 
							  <input id="ball_4_5" name="ball_4_5" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  06 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h6"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t6"> 
							  <input id="ball_4_6" name="ball_4_6" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  07 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h7"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t7"> 
							  <input id="ball_4_7" name="ball_4_7" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  08 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h8"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t8"> 
							  <input id="ball_4_8" name="ball_4_8" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  09 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h9"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t9"> 
							  <input id="ball_4_9" name="ball_4_9" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  10 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h10"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t10"> 
							  <input id="ball_4_10" name="ball_4_10" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  11 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h11"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t11"> 
							  <input id="ball_4_11" name="ball_4_11" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  12 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h12"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t12"> 
							  <input id="ball_4_12" name="ball_4_12" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  13 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h13"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t13"> 
							  <input id="ball_4_13" name="ball_4_13" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  14 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h14"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t14"> 
							  <input id="ball_4_14" name="ball_4_14" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  15 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h15"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t15"> 
							  <input id="ball_4_15" name="ball_4_15" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  16 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h16"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t16"> 
							  <input id="ball_4_16" name="ball_4_16" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  17 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h17"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t17"> 
							  <input id="ball_4_17" name="ball_4_17" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  18 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h18"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t18"> 
							  <input id="ball_4_18" name="ball_4_18" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  19 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h19"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t19"> 
							  <input id="ball_4_19" name="ball_4_19" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  20 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h20"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t20"> 
							  <input id="ball_4_20" name="ball_4_20" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h21"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t21"> 
							  <input id="ball_4_21" name="ball_4_21" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h22"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t22"> 
							  <input id="ball_4_22" name="ball_4_22" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h23"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t23"> 
							  <input id="ball_4_23" name="ball_4_23" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h24"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t24"> 
							  <input id="ball_4_24" name="ball_4_24" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h25"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t25"> 
							  <input id="ball_4_25" name="ball_4_25" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h26"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t26"> 
							  <input id="ball_4_26" name="ball_4_26" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h27"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t27"> 
							  <input id="ball_4_27" name="ball_4_27" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h28"> 
							  1.95 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t28"> 
							  <input id="ball_4_28" name="ball_4_28" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  东 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h29"> 
							  3.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t29"> 
							  <input id="ball_4_29" name="ball_4_29" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  南 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h30"> 
							  3.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t30"> 
							  <input id="ball_4_30" name="ball_4_30" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  西 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h31"> 
							  3.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t31"> 
							  <input id="ball_4_31" name="ball_4_31" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  北 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h32"> 
							  3.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t32"> 
							  <input id="ball_4_32" name="ball_4_32" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  中 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h33"> 
							  2.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t33"> 
							  <input id="ball_4_33" name="ball_4_33" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  发 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h34"> 
							  2.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t34"> 
							  <input id="ball_4_34" name="ball_4_34" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  白 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_4_h35"> 
							  2.6 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_4_t35"> 
							  <input id="ball_4_35" name="ball_4_35" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
				  </div> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
					  第五球 
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
								  01 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h1"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t1"> 
							  <input id="ball_5_1" name="ball_5_1" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  02 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h2"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t2"> 
							  <input id="ball_5_2" name="ball_5_2" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  03 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h3"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t3"> 
							  <input id="ball_5_3" name="ball_5_3" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  04 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h4"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t4"> 
							  <input id="ball_5_4" name="ball_5_4" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  05 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h5"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t5"> 
							  <input id="ball_5_5" name="ball_5_5" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  06 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h6"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t6"> 
							  <input id="ball_5_6" name="ball_5_6" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  07 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h7"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t7"> 
							  <input id="ball_5_7" name="ball_5_7" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  08 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h8"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t8"> 
							  <input id="ball_5_8" name="ball_5_8" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  09 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h9"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t9"> 
							  <input id="ball_5_9" name="ball_5_9" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  10 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h10"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t10"> 
							  <input id="ball_5_10" name="ball_5_10" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  11 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h11"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t11"> 
							  <input id="ball_5_11" name="ball_5_11" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  12 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h12"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t12"> 
							  <input id="ball_5_12" name="ball_5_12" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  13 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h13"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t13"> 
							  <input id="ball_5_13" name="ball_5_13" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  14 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h14"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t14"> 
							  <input id="ball_5_14" name="ball_5_14" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  15 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h15"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t15"> 
							  <input id="ball_5_15" name="ball_5_15" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  16 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h16"> 
							  19 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t16"> 
							  <input id="ball_5_16" name="ball_5_16" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  17 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h17"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t17"> 
							  <input id="ball_5_17" name="ball_5_17" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  18 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h18"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t18"> 
							  <input id="ball_5_18" name="ball_5_18" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  19 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h19"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t19"> 
							  <input id="ball_5_19" name="ball_5_19" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  20 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h20"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t20"> 
							  <input id="ball_5_20" name="ball_5_20" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h21"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t21"> 
							  <input id="ball_5_21" name="ball_5_21" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h22"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t22"> 
							  <input id="ball_5_22" name="ball_5_22" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h23"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t23"> 
							  <input id="ball_5_23" name="ball_5_23" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h24"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t24"> 
							  <input id="ball_5_24" name="ball_5_24" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h25"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t25"> 
							  <input id="ball_5_25" name="ball_5_25" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h26"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t26"> 
							  <input id="ball_5_26" name="ball_5_26" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h27"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t27"> 
							  <input id="ball_5_27" name="ball_5_27" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h28"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t28"> 
							  <input id="ball_5_28" name="ball_5_28" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  东 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h29"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t29"> 
							  <input id="ball_5_29" name="ball_5_29" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  南 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h30"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t30"> 
							  <input id="ball_5_30" name="ball_5_30" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  西 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h31"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t31"> 
							  <input id="ball_5_31" name="ball_5_31" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  北 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h32"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t32"> 
							  <input id="ball_5_32" name="ball_5_32" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  中 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h33"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t33"> 
							  <input id="ball_5_33" name="ball_5_33" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  发 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h34"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t34"> 
							  <input id="ball_5_34" name="ball_5_34" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  白 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_5_h35"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_5_t35"> 
							  <input id="ball_5_35" name="ball_5_35" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
				  </div> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
					  第六球 
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
								  01 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h1"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t1"> 
							  <input id="ball_6_1" name="ball_6_1" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  02 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h2"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t2"> 
							  <input id="ball_6_2" name="ball_6_2" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  03 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h3"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t3"> 
							  <input id="ball_6_3" name="ball_6_3" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  04 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h4"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t4"> 
							  <input id="ball_6_4" name="ball_6_4" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  05 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h5"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t5"> 
							  <input id="ball_6_5" name="ball_6_5" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  06 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h6"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t6"> 
							  <input id="ball_6_6" name="ball_6_6" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  07 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h7"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t7"> 
							  <input id="ball_6_7" name="ball_6_7" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  08 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h8"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t8"> 
							  <input id="ball_6_8" name="ball_6_8" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  09 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h9"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t9"> 
							  <input id="ball_6_9" name="ball_6_9" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  10 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h10"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t10"> 
							  <input id="ball_6_10" name="ball_6_10" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  11 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h11"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t11"> 
							  <input id="ball_6_11" name="ball_6_11" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  12 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h12"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t12"> 
							  <input id="ball_6_12" name="ball_6_12" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  13 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h13"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t13"> 
							  <input id="ball_6_13" name="ball_6_13" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  14 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h14"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t14"> 
							  <input id="ball_6_14" name="ball_6_14" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  15 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h15"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t15"> 
							  <input id="ball_6_15" name="ball_6_15" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  16 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h16"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t16"> 
							  <input id="ball_6_16" name="ball_6_16" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  17 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h17"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t17"> 
							  <input id="ball_6_17" name="ball_6_17" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  18 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h18"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t18"> 
							  <input id="ball_6_18" name="ball_6_18" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  19 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h19"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t19"> 
							  <input id="ball_6_19" name="ball_6_19" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  20 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h20"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t20"> 
							  <input id="ball_6_20" name="ball_6_20" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h21"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t21"> 
							  <input id="ball_6_21" name="ball_6_21" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h22"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t22"> 
							  <input id="ball_6_22" name="ball_6_22" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h23"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t23"> 
							  <input id="ball_6_23" name="ball_6_23" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h24"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t24"> 
							  <input id="ball_6_24" name="ball_6_24" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h25"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t25"> 
							  <input id="ball_6_25" name="ball_6_25" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h26"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t26"> 
							  <input id="ball_6_26" name="ball_6_26" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h27"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t27"> 
							  <input id="ball_6_27" name="ball_6_27" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h28"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t28"> 
							  <input id="ball_6_28" name="ball_6_28" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  东 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h29"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t29"> 
							  <input id="ball_6_29" name="ball_6_29" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  南 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h30"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t30"> 
							  <input id="ball_6_30" name="ball_6_30" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  西 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h31"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t31"> 
							  <input id="ball_6_31" name="ball_6_31" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  北 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h32"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t32"> 
							  <input id="ball_6_32" name="ball_6_32" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  中 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h33"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t33"> 
							  <input id="ball_6_33" name="ball_6_33" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  发 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h34"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t34"> 
							  <input id="ball_6_34" name="ball_6_34" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  白 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_6_h35"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_6_t35"> 
							  <input id="ball_6_35" name="ball_6_35" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
				  </div> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
					  第七球 
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
								  01 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h1"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t1"> 
							  <input id="ball_7_1" name="ball_7_1" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  02 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h2"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t2"> 
							  <input id="ball_7_2" name="ball_7_2" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  03 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h3"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t3"> 
							  <input id="ball_7_3" name="ball_7_3" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  04 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h4"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t4"> 
							  <input id="ball_7_4" name="ball_7_4" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  05 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h5"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t5"> 
							  <input id="ball_7_5" name="ball_7_5" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  06 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h6"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t6"> 
							  <input id="ball_7_6" name="ball_7_6" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  07 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h7"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t7"> 
							  <input id="ball_7_7" name="ball_7_7" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  08 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h8"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t8"> 
							  <input id="ball_7_8" name="ball_7_8" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  09 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h9"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t9"> 
							  <input id="ball_7_9" name="ball_7_9" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  10 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h10"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t10"> 
							  <input id="ball_7_10" name="ball_7_10" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  11 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h11"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t11"> 
							  <input id="ball_7_11" name="ball_7_11" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  12 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h12"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t12"> 
							  <input id="ball_7_12" name="ball_7_12" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  13 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h13"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t13"> 
							  <input id="ball_7_13" name="ball_7_13" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  14 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h14"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t14"> 
							  <input id="ball_7_14" name="ball_7_14" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  15 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h15"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t15"> 
							  <input id="ball_7_15" name="ball_7_15" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  16 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h16"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t16"> 
							  <input id="ball_7_16" name="ball_7_16" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  17 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h17"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t17"> 
							  <input id="ball_7_17" name="ball_7_17" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  18 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h18"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t18"> 
							  <input id="ball_7_18" name="ball_7_18" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  19 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h19"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t19"> 
							  <input id="ball_7_19" name="ball_7_19" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  20 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h20"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t20"> 
							  <input id="ball_7_20" name="ball_7_20" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h21"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t21"> 
							  <input id="ball_7_21" name="ball_7_21" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h22"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t22"> 
							  <input id="ball_7_22" name="ball_7_22" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h23"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t23"> 
							  <input id="ball_7_23" name="ball_7_23" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h24"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t24"> 
							  <input id="ball_7_24" name="ball_7_24" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h25"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t25"> 
							  <input id="ball_7_25" name="ball_7_25" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h26"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t26"> 
							  <input id="ball_7_26" name="ball_7_26" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h27"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t27"> 
							  <input id="ball_7_27" name="ball_7_27" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h28"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t28"> 
							  <input id="ball_7_28" name="ball_7_28" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  东 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h29"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t29"> 
							  <input id="ball_7_29" name="ball_7_29" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  南 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h30"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t30"> 
							  <input id="ball_7_30" name="ball_7_30" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  西 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h31"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t31"> 
							  <input id="ball_7_31" name="ball_7_31" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  北 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h32"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t32"> 
							  <input id="ball_7_32" name="ball_7_32" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  中 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h33"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t33"> 
							  <input id="ball_7_33" name="ball_7_33" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  发 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h34"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t34"> 
							  <input id="ball_7_34" name="ball_7_34" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  白 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_7_h35"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_7_t35"> 
							  <input id="ball_7_35" name="ball_7_35" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
				  </div> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
					  第八球 
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
								  01 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h1"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t1"> 
							  <input id="ball_8_1" name="ball_8_1" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  02 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h2"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t2"> 
							  <input id="ball_8_2" name="ball_8_2" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  03 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h3"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t3"> 
							  <input id="ball_8_3" name="ball_8_3" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  04 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h4"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t4"> 
							  <input id="ball_8_4" name="ball_8_4" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  05 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h5"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t5"> 
							  <input id="ball_8_5" name="ball_8_5" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  06 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h6"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t6"> 
							  <input id="ball_8_6" name="ball_8_6" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  07 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h7"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t7"> 
							  <input id="ball_8_7" name="ball_8_7" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  08 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h8"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t8"> 
							  <input id="ball_8_8" name="ball_8_8" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  09 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h9"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t9"> 
							  <input id="ball_8_9" name="ball_8_9" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  10 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h10"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t10"> 
							  <input id="ball_8_10" name="ball_8_10" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  11 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h11"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t11"> 
							  <input id="ball_8_11" name="ball_8_11" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  12 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h12"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t12"> 
							  <input id="ball_8_12" name="ball_8_12" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  13 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h13"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t13"> 
							  <input id="ball_8_13" name="ball_8_13" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  14 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h14"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t14"> 
							  <input id="ball_8_14" name="ball_8_14" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  15 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h15"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t15"> 
							  <input id="ball_8_15" name="ball_8_15" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  16 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h16"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t16"> 
							  <input id="ball_8_16" name="ball_8_16" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  17 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h17"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t17"> 
							  <input id="ball_8_17" name="ball_8_17" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  18 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h18"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t18"> 
							  <input id="ball_8_18" name="ball_8_18" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  19 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h19"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t19"> 
							  <input id="ball_8_19" name="ball_8_19" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a1" style="padding-left: 12%;"> 
						  <div class="caipiao-circle-a"> 
							  <span class="caipiao-circle-b"> 
								  20 
							  </span> 
						  </div> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h20"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t20"> 
							  <input id="ball_8_20" name="ball_8_20" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h21"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t21"> 
							  <input id="ball_8_21" name="ball_8_21" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h22"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t22"> 
							  <input id="ball_8_22" name="ball_8_22" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h23"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t23"> 
							  <input id="ball_8_23" name="ball_8_23" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h24"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t24"> 
							  <input id="ball_8_24" name="ball_8_24" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h25"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t25"> 
							  <input id="ball_8_25" name="ball_8_25" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  尾小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h26"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t26"> 
							  <input id="ball_8_26" name="ball_8_26" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h27"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t27"> 
							  <input id="ball_8_27" name="ball_8_27" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  合双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h28"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t28"> 
							  <input id="ball_8_28" name="ball_8_28" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  东 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h29"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t29"> 
							  <input id="ball_8_29" name="ball_8_29" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  南 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h30"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t30"> 
							  <input id="ball_8_30" name="ball_8_30" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  西 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h31"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t31"> 
							  <input id="ball_8_31" name="ball_8_31" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  北 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h32"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t32"> 
							  <input id="ball_8_32" name="ball_8_32" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  中 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h33"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t33"> 
							  <input id="ball_8_33" name="ball_8_33" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  发 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h34"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t34"> 
							  <input id="ball_8_34" name="ball_8_34" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  白 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_8_h35"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_8_t35"> 
							  <input id="ball_8_35" name="ball_8_35" style="width:80%;" type="text" 
							  onkeyup="digitOnly(this)" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
				  </div> 
			  </div> 
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed ui-last-child"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"> 
					  总和 龙虎 
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
						  <span class="bian_td_odds" id="ball_9_h1"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_9_t1"> 
							  <input id="ball_9_1" name="ball_9_1" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  总和小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_9_h2"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_9_t2"> 
							  <input id="ball_9_2" name="ball_9_2" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  总和单 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_9_h3"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_9_t3"> 
							  <input id="ball_9_3" name="ball_9_3" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  总和双 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_9_h4"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_9_t4"> 
							  <input id="ball_9_4" name="ball_9_4" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  总和尾大 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_9_h5"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_9_t5"> 
							  <input id="ball_9_5" name="ball_9_5" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  总和尾小 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_9_h6"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_9_t6"> 
							  <input id="ball_9_6" name="ball_9_6" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  龙 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_9_h7"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_9_t7"> 
							  <input id="ball_9_7" name="ball_9_7" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span> 
							  虎 
						  </span> 
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b"> 
						  <span class="bian_td_odds" id="ball_9_h8"> 
							  -- 
						  </span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c"> 
						  <span class="bian_td_inp" id="ball_9_t8"> 
							  <input id="ball_9_8" name="ball_9_8" style="width:80%;" type="text" onKeyUp="digitOnly(this)" 
							  maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
				  </div> 
			  </div> 
		  </div> 
		  <div style="clear:both;text-align:center;"> 
			  <a class="ui-btn ui-btn-inline" href="javascript:del_bet();"> 
				  取消下注 
			  </a> 
			  <a class="ui-btn ui-btn-inline" href="javascript:sub_bet();"> 
				  确认下注 
			  </a> 
		  </div> 
	  </section> 
	  </form> 
	  <!--底部开始--><?php include_once '../bottom.php';?>		  <!--底部结束--> 
	  <!--我的资料--><?php include_once '../member/myinfo.php';?>		  
	  <script type="text/javascript" src="../js/script.js"></script> 
	  <script type="text/javascript" src="../js/gdkls.js"></script> 
	  <script type="text/javascript"> 
		  $(function() { 
			  loadinfo();
		  });
		  var cp_zd = 10;
		  var cp_zg = 10000;
		  var cp_code = "klsf_gd";
		  var cp_name = "广东快乐10分";
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