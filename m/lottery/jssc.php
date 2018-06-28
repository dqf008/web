<?php
$_DIR = realpath('../../lot/');
$_DIR = str_replace('\\', '/', $_DIR);
substr($_DIR, -1)!='/'&&$_DIR.='/';
define('IN_LOT', $_DIR);
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
$odds = include(IN_LOT.'include/odds/jssc.php');
function show_id($id1=0, $id2=0){
    return $id1.substr('00'.$id2, -2);
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
		  .caipiao-bgc-b {  
			  padding-top: 6px;
			  background-color:#EEEEEE;
		  }  
		  .caipiao-bgc-c {  
			  padding-top: 2px;
			  background-color: #EEEEEE;
		  }  
		  .caipiao-bgc-abc {  
			  padding-top: 6px;
			  background-color: lightgray;
		  }  
		  .caipiao-info{  
			  border-width: 1px;
			  border-color: lightgray;
			  border-style: solid;
			  padding:5px;
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
				  极速赛车 
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
    var del_bet, sub_bet;
    $(document).ready(function(){
        var bet_mode, quick_input = $("#lot_quick").siblings(), pankouflag = false;
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
        });
        quick_input.find("div > a").on("click", function(){
            if($(this).index()>0){
                var v = $(this).parents("div").find("input").val();
                $(".quick_selected").find("input").val(v.replace(/[^\d]/g, "")),
                sub_bet();
            }else{
                $("form").trigger("reset");
            }
        });
        $(".caipiao-bgc-a, .caipiao-bgc-b, .caipiao-bgc-c, .caipiao-bgc-a1").on("click", function(){
            var e = $(this), i, v = quick_input.find("input").val();
            bet_mode=="quick" && pankouflag && (!e.hasClass("ui-block-c") && (e = e.nextAll(".ui-block-c").first()), i = e.find("input"), i.length>0 && (e.hasClass("quick_selected") ? (i.val(""), i.siblings().html(""), e.prevAll().andSelf().slice(-3).css("background-color", "").removeClass("quick_selected")) : (i.val(v), i.siblings().html("√"), e.prevAll().andSelf().slice(-3).css("background-color", "#cddc39").addClass("quick_selected"))))
        });
        $("form").on("reset", function(){
            $(".quick_selected").css("background-color", "").removeClass("quick_selected").find(".bian_td_inp > span").html("");
        });
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
        $(".caipiao-bgc-c").find("input").on("keyup", function(){
            var v = $(this).val(), n = v.replace(/[^\d]/g, "");
            v!=n && $(this).val(n);
        });
        del_bet = function(){
            $("form").trigger("reset");
        };
        sub_bet = function(){
            x.submit()
        };
        var x = {
            now: 0,
            close: 0,
            open: 0,
            obj: [null, null],
            load: function(){
                var t = this;
                clearTimeout(t.obj[0]),
                t.post({action: "info", lotteryId: "jssc"}, function(d){
                    $("#numbers").html(d.Obj.PrePeriodNumber),
                    $("#autoinfo").html(d.Obj.PreResult),
                    $("#open_qihao").html(d.Obj.CurrentPeriod),
                    t.now = (new Date()).getTime(),
                    t.now>t.open&&(t.open = t.now+(parseInt(d.Obj.OpenCount)*1000),
                    t.close = t.now+(parseInt(d.Obj.CloseCount)*1000),
                    $.each(d.Obj.Lines, function(k, v){
                        k = k.substring(1),
                        $(".ui-block-b[data-id="+k+"] > span").html(v),
                        $(".ui-block-c[data-id="+k+"]").data("odds", v).find("span").html("<input style=\"width:80%\" type=\"text\" maxlength=\"7\" data-role=\"none\" />")
                    })),
                    t.obj[0] = setTimeout(function(){
                        t.load()
                    }, 10000),
                    t.count()
                });
            },
            count: function(){
                var t = this;
                clearTimeout(t.obj[1]),
                pankouflag = (t.close-t.now)/1000>=1,
                t.now = (new Date()).getTime(),
                $("#endhtml").html(pankouflag?"距离封盘":"距离开奖"),
                $("#endtime").html(t.time(pankouflag?t.close:t.open)),
                !pankouflag && ($(".ui-block-b[data-id] > span").html("--"),
                $(".ui-block-c[data-id]").data("odds", 0).find("span").html("<span>封盘</span>")),
                t.now>=t.open ? t.load() : (t.obj[1] = setTimeout(function(){
                    t.count()
                }, 250))
            },
            time: function(v){
                var t = this, i, s;
                v = Math.floor(v/1000),
                v-= Math.floor(t.now/1000),
                i = Math.floor(v/60).toString(),
                s = Math.floor(v%60).toString();
                return v>0 ? ("00"+i).substring(i.length)+":"+("00"+s).substring(s.length) : "00:00"
            },
            submit: function(){
                var t = this, s = 0, c = 0, m = [], d = [];
                pankouflag ? (
                    $(".caipiao-bgc-c[data-id]").each(function(){
                        var t = $(this), v = parseInt(t.find("input").val());
                        v>0&&(
                            d.push({
                                Id: t.data("id").toString(),
                                BetContext: t.data("type").toString(),
                                Lines: t.data("odds").toString(),
                                BetType: 1,
                                Money: v.toString(),
                                IsTeMa: false,
                                IsForNumber: false
                            }),
                            m.push(t.data("class")+"["+t.data("type")+"] @ "+t.data("odds")+" x ￥"+v)
                        )
                    }),
                    d.length>0 ? confirm("共 ￥"+s+" / "+c+" 笔，确定下注吗？\n\n下注明细如下：\n\n"+m.join("\n")) && t.post({action: "bet", betParameters: d, lotteryId: "jssc"}, function(r){
                            r.result==1 ? (alert("投注成功！"), $("form").trigger("reset")) : alert("投注失败！赔率可能发生变化！")
                        }
                    ) : alert("请输入下注金额！")
                ) : alert("已经封盘，请稍后进行投注！")
            },
            post: function(d, s){
                return $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "../../lot/ajax.php",
                    contentType: "application/json",
                    data: JSON.stringify(d),
                    success: s
                })
            }
        };
        x.load();
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
	  <form id="bjscOrder" name="bjscOrder"  action="#" method="post"> 
	  <section class="mContent clearfix" style="padding:0px;"> 
		  <div data-role="collapsibleset" data-theme="b" data-content-theme="a" 
		  data-iconpos="right" data-inset="false" class="ui-collapsible-set ui-group-theme-b"> 
          <?php 
          foreach($odds as $id1=>$val){ ?>
			  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed ui-first-child"> 
				  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"><?php echo $val[0]; ?></h4> 
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
                    <?php //$val[1] = sort($val[1]); 
                    foreach($val[1] as $id2=>$text){$id2=show_id($id1, $id2); ?>
					  <div class="ui-block-a caipiao-bgc-a"> 
						  <span><?php echo $text; ?></span>
					  </div> 
					  <div class="ui-block-b caipiao-bgc-b" data-id="<?php echo $id2; ?>"> 
						  <span class="bian_td_odds">--</span> 
					  </div> 
					  <div class="ui-block-c caipiao-bgc-c" data-id="<?php echo $id2; ?>" data-class="<?php echo $val[0]; ?>" data-type="<?php echo $text; ?>" data-odds="0"> 
						  <span class="bian_td_inp"> 
							  <input style="width:80%;" type="text" maxlength="7" data-role="none"> 
						  </span> 
					  </div> 
                      <?php } ?>
				  </div> 
			  </div> 
              <?php } ?>
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
  </body> 
  <div class="ui-loader ui-corner-all ui-body-a ui-loader-default"> 
	  <span class="ui-icon-loading"> 
	  </span> 
	  <h1> 
		  loading 
	  </h1> 
  </div> 
</html>