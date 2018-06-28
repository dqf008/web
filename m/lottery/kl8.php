<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '../../include/lottery.inc.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
if (intval($web_site['kl8']) == 1){
	message('北京快乐8系统维护，暂停下注！');
	exit();
}
$params = array(':kaipan' => $l_time, ':fengpan' => $l_time);
$stmt = $mydata1_db->prepare('select * from lottery_k_kl8 where kaipan<:kaipan and fengpan>:fengpan');
$stmt->execute($params);
$trow = $stmt->fetch();
$tcou = $stmt->rowCount();
$sql = 'select id,class1,class2,class3,odds,modds,locked from lottery_odds where class1=\'kl8\' order by ID asc';
$query = $mydata1_db->query($sql);
while ($row = $query->fetch()){
	$pl = $pl . '|' . $row['odds'];
}
$plrr = explode('|', $pl);
include_once '../../cache/group_' . @($_SESSION['gid']) . '.php';
$cp_zd = @($pk_db['彩票最低']);
$cp_zg = @($pk_db['彩票最高']);
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
  ul, ol, li
  {
	  list-style-type:none;
  }
  .shuzi li
  {
	  padding: 5px;
	  float: left;
	  border-top: 1px solid #DDD;
	  border-left: 1px solid #DDD;
	  border-right: 1px solid #DDD;
	  border-bottom: 1px solid #DDD;
	  text-align: center;
  }
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
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-url="/m/lottery/kl8.php" tabindex="0" style="min-height: 659px;">
  <input id="uid" name="uid" value="<?=$uid;?>" type="hidden"/>
  <!--头部开始-->
  <header id="header">
	  <?php if ($uid != 0){?> <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true"aria-owns="popupPanel" aria-expanded="false"></a><?php }?> 		  
	  <span>彩票游戏</span>
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a>
  </header>
  <div class="mrg_header"></div>
  <!--头部结束-->


  <section class="sliderWrap clearfix">
	  <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit">
		  <h1 class="ui-title" role="heading" aria-level="1">北京快乐8</h1>
	  </div>
	  <div class="caipiao-info">
	  <?php if (0 < $tcou){?><div style="font-size:12pt;">第<span style="color:#f60;"><?=$trow['qihao'];?></span>期</div>
		  <div style="font-size:12pt;">北京时间：<?=bjssc($trow['fengpan']);?></div>
		  <div style="font-size:12pt;">美东时间：<?=mdtime($trow['fengpan']);?></div>
		  <div style="font-size:12pt;">
			  <span id="endtime" style="color:#f60;font-weight:bold;"><?=strtotime(mdtime($trow['fengpan']))-time();?></span>
		  </div>
		  <?php }else{?> 			  
		  <div style="font-size:12pt;"> 期数未开盘</div>
		  <?php }?> 		  
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
                $("span.bian_td_inp").find("span").length<=0 && ($("span.bian_td_inp").append("<span></span>").find("input").hide());
            }else{
                quick_input.hide();
                $(".ui-block-c").filter(".caipiao-bgc-abc").find("span").html("金额");
                $(".bian_td_inp").find("span").remove();
                $("section").last().find("div").last().show();
                $.cookie("m_lot_quick", "false", {expires: -1, path: "/"});
                $("span.bian_td_inp").find("input").show().siblings().remove();
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
            del_bet();
        })
        $(document).scroll(function(){quickTop()});
        $(window).resize(function(){quickTop()});
        function quickTop(){
            var offsetTop = quick_input.offset().top, scrollTop = $(document).scrollTop(), e = quick_input.children("div");
            return !quick_input.is(":hidden") && e.css({"position": (offsetTop-scrollTop>36 ? "static" : "fixed"), "box-shadow": (offsetTop-scrollTop>36 ? "none" : "0 0 8px rgba(0, 0, 0, 0.5), 0 0 256px rgba(255, 255, 255, .3)")});
        }
        $.cookie("m_lot_quick")=="true" && $("#lot_quick").find("input").last().prev().trigger("click");
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
  <form id="kl8Order" name="kl8Order"  action="kl8Order.php" method="post">
  <section class="mContent clearfix" style="padding:0px;">
	  <div data-role="collapsibleset" data-theme="b" data-content-theme="a" data-iconpos="right" data-inset="false" class="ui-collapsible-set ui-group-theme-b">
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed">
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">
					  选号
			  </h4>
			  <ul class="shuzi" data-role="none">
				  <li id="1" data-role="none">01</li>
				  <li id="2" data-role="none">02</li>
				  <li id="3" data-role="none">03</li>
				  <li id="4" data-role="none">04</li>
				  <li id="5" data-role="none">05</li>
				  <li id="6" data-role="none">06</li>
				  <li id="7" data-role="none">07</li>
				  <li id="8" data-role="none">08</li>
				  <li id="9" data-role="none">09</li>
				  <li id="10" data-role="none">10</li>
				  <li id="11" data-role="none">11</li>
				  <li id="12" data-role="none">12</li>
				  <li id="13" data-role="none">13</li>
				  <li id="14" data-role="none">14</li>
				  <li id="15" data-role="none">15</li>
				  <li id="16" data-role="none">16</li>
				  <li id="17" data-role="none">17</li>
				  <li id="18" data-role="none">18</li>
				  <li id="19" data-role="none">19</li>
				  <li id="20" data-role="none">20</li>
				  <li id="21" data-role="none">21</li>
				  <li id="22" data-role="none">22</li>
				  <li id="23" data-role="none">23</li>
				  <li id="24" data-role="none">24</li>
				  <li id="25" data-role="none">25</li>
				  <li id="26" data-role="none">26</li>
				  <li id="27" data-role="none">27</li>
				  <li id="28" data-role="none">28</li>
				  <li id="29" data-role="none">29</li>
				  <li id="30" data-role="none">30</li>
				  <li id="31" data-role="none">31</li>
				  <li id="32" data-role="none">32</li>
				  <li id="33" data-role="none">33</li>
				  <li id="34" data-role="none">34</li>
				  <li id="35" data-role="none">35</li>
				  <li id="36" data-role="none">36</li>
				  <li id="37" data-role="none">37</li>
				  <li id="38" data-role="none">38</li>
				  <li id="39" data-role="none">39</li>
				  <li id="40" data-role="none">40</li>
				  <li id="41" data-role="none">41</li>
				  <li id="42" data-role="none">42</li>
				  <li id="43" data-role="none">43</li>
				  <li id="44" data-role="none">44</li>
				  <li id="45" data-role="none">45</li>
				  <li id="46" data-role="none">46</li>
				  <li id="47" data-role="none">47</li>
				  <li id="48" data-role="none">48</li>
				  <li id="49" data-role="none">49</li>
				  <li id="50" data-role="none">50</li>
				  <li id="51" data-role="none">51</li>
				  <li id="52" data-role="none">52</li>
				  <li id="53" data-role="none">53</li>
				  <li id="54" data-role="none">54</li>
				  <li id="55" data-role="none">55</li>
				  <li id="56" data-role="none">56</li>
				  <li id="57" data-role="none">57</li>
				  <li id="58" data-role="none">58</li>
				  <li id="59" data-role="none">59</li>
				  <li id="60" data-role="none">60</li>
				  <li id="61" data-role="none">61</li>
				  <li id="62" data-role="none">62</li>
				  <li id="63" data-role="none">63</li>
				  <li id="64" data-role="none">64</li>
				  <li id="65" data-role="none">65</li>
				  <li id="66" data-role="none">66</li>
				  <li id="67" data-role="none">67</li>
				  <li id="68" data-role="none">68</li>
				  <li id="69" data-role="none">69</li>
				  <li id="70" data-role="none">70</li>
				  <li id="71" data-role="none">71</li>
				  <li id="72" data-role="none">72</li>
				  <li id="73" data-role="none">73</li>
				  <li id="74" data-role="none">74</li>
				  <li id="75" data-role="none">75</li>
				  <li id="76" data-role="none">76</li>
				  <li id="77" data-role="none">77</li>
				  <li id="78" data-role="none">78</li>
				  <li id="79" data-role="none">79</li>
				  <li id="80" data-role="none">80</li>
			  </ul>
			  <div style="clear:both;text-align:center;padding-top:10px;" class="bian_td_inp">
				  下注金额：<input id="ball_10" name="ball_10" style="width:100px;" type="text" onKeyUp="digitOnly(this)" maxlength="7" data-role="none" />
							<input id="hmnums" name="hmnums" type="hidden"  />
			  </div>
		  </div>
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed">
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">
				  和值
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
						  和值大
					  </span>
				  </div>
				  <div class="ui-block-b caipiao-bgc-b">
					  <span class="bian_td_odds" id="ball_11_h"><?=$plrr[11];?></span>
				  </div>
				  <div class="ui-block-c caipiao-bgc-c">
					  <span class="bian_td_inp" id="ball_11_t">
						  <input id="ball_11" name="ball_11" style="width:80px;" type="text" onKeyUp="digitOnly(this)" maxlength="7" data-role="none">
					  </span>
				  </div>
				  <div class="ui-block-a caipiao-bgc-a">
					  <span>
						  和值小
					  </span>
				  </div>
				  <div class="ui-block-b caipiao-bgc-b">
					  <span class="bian_td_odds" id="ball_12_h"><?=$plrr[12];?></span>
				  </div>
				  <div class="ui-block-c caipiao-bgc-c">
					  <span class="bian_td_inp" id="ball_12_t">
						  <input id="ball_12" name="ball_12" style="width:80px;" type="text" onKeyUp="digitOnly(this)" maxlength="7" data-role="none">
					  </span>
				  </div>
				  <div class="ui-block-a caipiao-bgc-a">
					  <span>
						  和值810
					  </span>
				  </div>
				  <div class="ui-block-b caipiao-bgc-b">
					  <span class="bian_td_odds" id="ball_13_h"><?=$plrr[13];?></span>
				  </div>
				  <div class="ui-block-c caipiao-bgc-c">
					  <span class="bian_td_inp" id="ball_13_t">
						  <input id="ball_13" name="ball_13" style="width:80px;" type="text" onKeyUp="digitOnly(this)" maxlength="7" data-role="none">
					  </span>
				  </div>
				  <div class="ui-block-a caipiao-bgc-a">
					  <span>
						  和值单
					  </span>
				  </div>
				  <div class="ui-block-b caipiao-bgc-b">
					  <span class="bian_td_odds" id="ball_14_h"><?=$plrr[14];?></span>
				  </div>
				  <div class="ui-block-c caipiao-bgc-c">
					  <span class="bian_td_inp" id="ball_14_t">
						  <input id="ball_14" name="ball_14" style="width:80px;" type="text" onKeyUp="digitOnly(this)" maxlength="7" data-role="none">
					  </span>
				  </div>
				  <div class="ui-block-a caipiao-bgc-a">
					  <span>
						  和值双
					  </span>
				  </div>
				  <div class="ui-block-b caipiao-bgc-b">
					  <span class="bian_td_odds" id="ball_15_h"><?=$plrr[15];?></span>
				  </div>
				  <div class="ui-block-c caipiao-bgc-c">
					  <span class="bian_td_inp" id="ball_15_t">
						  <input id="ball_15" name="ball_15" style="width:80px;" type="text" onKeyUp="digitOnly(this)" maxlength="7" data-role="none">
					  </span>
				  </div>
			  </div>
		  </div>
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed">
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">
				  上下盘
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
						  上盘
					  </span>
				  </div>
				  <div class="ui-block-b caipiao-bgc-b">
					  <span class="bian_td_odds" id="ball_16_h"><?=$plrr[16];?></span>
				  </div>
				  <div class="ui-block-c caipiao-bgc-c">
					  <span class="bian_td_inp" id="ball_16_t">
						  <input id="ball_16" name="ball_16" style="width:80px;" type="text" onKeyUp="digitOnly(this)" maxlength="7" data-role="none">
					  </span>
				  </div>
				  <div class="ui-block-a caipiao-bgc-a">
					  <span>
						  中盘
					  </span>
				  </div>
				  <div class="ui-block-b caipiao-bgc-b">
					  <span class="bian_td_odds" id="ball_17_h"><?=$plrr[17];?></span>
				  </div>
				  <div class="ui-block-c caipiao-bgc-c">
					  <span class="bian_td_inp" id="ball_17_t">
						  <input id="ball_17" name="ball_17" style="width:80px;" type="text" onKeyUp="digitOnly(this)" maxlength="7" data-role="none">
					  </span>
				  </div>
				  <div class="ui-block-a caipiao-bgc-a">
					  <span>
						  下盘
					  </span>
				  </div>
				  <div class="ui-block-b caipiao-bgc-b">
					  <span class="bian_td_odds" id="ball_18_h"><?=$plrr[18];?></span>
				  </div>
				  <div class="ui-block-c caipiao-bgc-c">
					  <span class="bian_td_inp" id="ball_18_t">
						  <input id="ball_18" name="ball_18" style="width:80px;" type="text" onKeyUp="digitOnly(this)" maxlength="7" data-role="none">
					  </span>
				  </div>
			  </div>
		  </div>
		  <div style="padding: 0 15px 10px 10px;" data-role="collapsible" class="ui-collapsible ui-collapsible-themed-content ui-collapsible-collapsed">
			  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">
				  奇偶盘
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
						  奇盘
					  </span>
				  </div>
				  <div class="ui-block-b caipiao-bgc-b">
					  <span class="bian_td_odds" id="ball_19_h"><?=$plrr[19];?></span>
				  </div>
				  <div class="ui-block-c caipiao-bgc-c">
					  <span class="bian_td_inp" id="ball_19_t">
						  <input id="ball_19" name="ball_19" style="width:80px;" type="text" onKeyUp="digitOnly(this)" maxlength="7" data-role="none">
					  </span>
				  </div>
				  <div class="ui-block-a caipiao-bgc-a">
					  <span>
						  和盘
					  </span>
				  </div>
				  <div class="ui-block-b caipiao-bgc-b">
					  <span class="bian_td_odds" id="ball_20_h"><?=$plrr[20];?></span>
				  </div>
				  <div class="ui-block-c caipiao-bgc-c">
					  <span class="bian_td_inp" id="ball_20_t">
						  <input id="ball_20" name="ball_20" style="width:80px;" type="text" onKeyUp="digitOnly(this)" maxlength="7" data-role="none">
					  </span>
				  </div>
				  <div class="ui-block-a caipiao-bgc-a">
					  <span>
						  偶盘
					  </span>
				  </div>
				  <div class="ui-block-b caipiao-bgc-b">
					  <span class="bian_td_odds" id="ball_21_h"><?=$plrr[21];?></span>
				  </div>
				  <div class="ui-block-c caipiao-bgc-c">
					  <span class="bian_td_inp" id="ball_21_t">
						  <input id="ball_21" name="ball_21" style="width:80px;" type="text" onKeyUp="digitOnly(this)" maxlength="7" data-role="none">
					  </span>
				  </div>
			  </div>
		  </div>
	  </div>
	  <div style="clear:both;padding-bottom:5px;text-align:center;">
		  <p>☆最低金额:<font color="#FF0000"><?=$cp_zd;?></font>&nbsp;&nbsp;☆单注限额:<font color="#FF0000"><?=$cp_zg;?></font></p>
	  </div>
	  <div style="clear:both;text-align:center;">
		  <input type="hidden" name="qihao" value="<?=$trow['qihao'];?>" />
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
  <script type="text/javascript" src="../js/script.js"></script>
  <script type="text/javascript">
	  //显示距离封盘的动态时间
	  var CID = "endtime";
	  <?php if (0 < $tcou){?> 		  
	  if(window.CID != null){
		  var iTime = document.getElementById(CID).innerHTML;
		  var Account;
		  RemainTime();
	  }
	  <?php }?> 		  
	  function RemainTime(){
		  var iDay,iHour,iMinute,iSecond;
		  var sDay="",sHour="",sMinute="",sSecond="",sTime="";
		  if(iTime >= 0){
			  iDay = parseInt(iTime/24/3600);
			  if(iDay > 0 && iDay < 10){
				  sDay = "0" +iDay + "天";
			  }
			  if(iDay > 10){
				  sDay = iDay + "天";
			  }
			  iHour = parseInt((iTime/3600)%24);
			  if(iHour > 0 && iHour < 10){
				  sHour = "0" + iHour + "小时";
			  }
			  if(iHour > 10){
				  sHour = iHour + "小时";
			  }
			  iMinute = parseInt((iTime/60)%60);
			  if(iMinute > 0 && iMinute < 10){
				  sMinute = "0" + iMinute + "分钟";
			  }
			  if(iMinute > 10){
				  sMinute = iMinute + "分钟";
			  }
			  iSecond = parseInt(iTime%60);
			  if(iSecond >= 0 && iSecond <10 ){
				  sSecond = "0" +iSecond + "秒";
			  }
			  if(iSecond >= 10){
				  sSecond = iSecond + "秒";
			  }
			  if((sDay=="")&&(sHour=="")){
				  sTime = "距离封盘：" + sMinute+sSecond + "";
			  }else{
				  sTime = "距离封盘：" + sDay+sHour+sMinute+sSecond;
			  }
			  if(iTime==0){
				  clearTimeout(Account);
				  sTime = "本期已经封盘，即将开始下一期";
			  }
			  if(iTime==-5){
				  clearTimeout(Account);
				  sTime = "开始下一期";
			  }else{
				  Account = setTimeout("RemainTime()",1000);
			  }
			  iTime = iTime-1;
		  }else{
			  sTime = "开始下一期";
			  alert("本期投注已结束，点击开始下一期投注!");
			  window.location.reload();
		  }
		  document.getElementById(CID).innerHTML = sTime;
	  }
  </script>
  <script type="text/javascript">
	
	  //取消下注
	  function del_bet(){
		  $(".bian_td_inp").find("input:text").val("");
		  $(".bian_td_inp").find("input:hidden").val("");
		  for(i=1;i<81;i++){
			  num[i]=false;
			  $("#"+i).removeAttr("style");
		  }
	  }
	
	  //80个号码事件
	  var num = new Array();
	  for(i=1;i<81;i++){
		  num[i]=false;
		  $("#"+i).removeAttr("style");
		  $("#"+i).attr("onclick","check_bet(this.id);");
	  }
	  var hmsum     = 0;
	  var hmnum     = '';
	  var classname = '';
	  //选号检测
	  function check_bet(sb){
		  if(isLogin()==false){
			  alert("登录后才能进行此操作");
			  return;
		  }
		  if(eval("num["+sb+"]")==false){
			  var ddsum = 0;
			  for(i=1;i<81;i++){
				  if(eval("num[" + i + "]")==true){
					  ddsum += 1;
				  }
			  }
			  if(ddsum>4){
				  alert("最多选5个号码!");
				  return ;
			  }else{
				  $("#"+sb).attr("style","background-color:#5CACEE");
				  eval("num["+sb+"]=true");
			  }
		  }else{
			  $("#"+sb).removeAttr("style");
			  eval("num["+sb+"]=false");
		  }
		  hmsum = 0;
		  hmnum = '';
		  for(i=1;i<81;i++){
			  if(eval("num[" + i + "]") == true){
				  hmsum += 1;
				  hmnum = hmnum + i +",";
			  }
		  }
		  $("#hmnums").val(hmnum);
		
		  classname = '';
		  oddsname  = '';
		  if(hmsum==1){
			  classname = "选一";
			  oddsname = "中一@<?=$plrr[1];?>";
		  }else if(hmsum==2){
			  classname = "选二";
			  oddsname = "中二@<?=$plrr[2];?>";
		  }else if(hmsum==3){
			  classname = "选三";
			  oddsname = "中二@<?=$plrr[3];?>,中三@<?=$plrr[4];?>";
		  }else if(hmsum==4){
			  classname = "选四";
			  oddsname = "中二@<?=$plrr[5];?>,中三@<?=$plrr[6];?>,中四@<?=$plrr[7];?>";
		  }else if(hmsum==5){
			  classname = "选五";
			  oddsname = "中三@<?=$plrr[8];?>,中四@<?=$plrr[9];?>,中五@<?=$plrr[10];?>";
		  }else{
			  classname = "";
		  }
	  }
	
	  function sub_bet(){
		  if(isLogin()==false){
			  alert("登录后才能进行此操作");
			  return;
		  }
		  //获取选号金额，及号码
		  var xuanhao = '';
		  var xuanhaomoney = 0;
		  if ($("#ball_10").val() != "" && $("#ball_10").val() != null) {
			  xuanhaomoney = parseInt($("#ball_10").val());
		  }
		  xuanhao = $("#hmnums").val();
		  if(xuanhao=='' && xuanhaomoney!=0){
			  alert("选号有金额，未选择号码！");
			  return;
		  }
		  if(xuanhao!='' && xuanhaomoney==0){
			  alert("有选号，但尚未输入金额！");
			  return;
		  }
		
		  $.post("../../Lottery/Include/Lottery_PK.php", function(data) {
			  var mix = 10;cou = m = 0, txt = '', c=true;
			  if(data.cp_zd>=0){
				  mix = data.cp_zd;
			  }
			  var max = 1000000, d=true;
			  if(data.cp_zg>=0){
				  max = data.cp_zg;
			  }
			
			  if(xuanhao!='' && xuanhaomoney>0){
				  //判断最小下注金额
				  if (xuanhaomoney < mix) {
					  c = false;
					  alert("最低下注金额："+mix+"￥");return false;
				  }
				  if (xuanhaomoney > max) {
					  d = false;
					  alert("最高下注金额："+max+"￥");return false;
				  }
				  m = m + xuanhaomoney;
				  //获取投注项，赔率
				  txt = txt + classname + '[' + xuanhao +'] ' + oddsname + ' x ￥' + xuanhaomoney + '';
				  cou++;
			  }
			
			  for (var i = 11;i <= 21;i++){
				  if ($("#ball_" + i).val() != "" && $("#ball_" + i).val() != null) {
					  //判断最小下注金额
					  if (parseInt($("#ball_" + i).val()) < mix) {
						  c = false;
						  alert("最低下注金额："+mix+"￥");return false;
					  }
					  if (parseInt($("#ball_" + i).val()) > max) {
						  d = false;
						  alert("最高下注金额："+max+"￥");return false;
					  }
					  m = m + parseInt($("#ball_" + i).val());
					  //获取投注项，赔率
					  var odds = $("#ball_"+ i +"_h").html();
					  var q = did(i);
					  var w = wan(i);
					  txt = txt + q + '[' + w +'] @ ' + odds + ' x ￥' + parseInt($("#ball_" + i).val()) + '';
					  cou++;
				  }
			  }
			  if (!c) {alert("最低下注金额："+mix+"￥");return false;}
			  if (!d) {alert("最高下注金额："+max+"￥");return false;}
			  if (cou <= 0) {alert("请输入下注金额!!!");return false;}
			  var t = "共 ￥"+m+" / "+cou+" 笔，确定下注吗？\r\n下注明细如下：\r\n";
			  txt = t + txt;
			  var ok = confirm(txt);
			  if (ok){
				  document.kl8Order.submit();
			  }
			  document.kl8Order.reset();
			  del_bet();
		  }, "json");
		
	  }
	
	  function did(i){
		  if(i>=11 && i<=15){
			  return '和值';
		  }else if(i>=16 && i<=18){
			  return '上中下';
		  }else if(i>=19 && i<=21){
			  return '奇和偶';
		  }else{
			  return '未知';
		  }
	  }
	
	  function wan(i){
		  switch (i){
			  case 11:return '大';
			  case 12:return '小';
			  case 13:return '810';
			  case 14:return '单';
			  case 15:return '双';
			  case 16:return '上';
			  case 17:return '中';
			  case 18:return '下';
			  case 19:return '奇';
			  case 20:return '和';
			  case 21:return '偶';
			  default: '未知';
		  }
	  }
	
	  //是否登录
	  function isLogin(){
		  var uid = $("#uid").val();
		  if(uid<=0){
			  return false;
		  }
		  return true;
	  }
  </script>
</body>
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div>
</html>