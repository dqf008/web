<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '_pankouinfo.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$userinfo = user::getinfo($uid);
$class1 = '半波';
$class2 = '半波';
$params = array(':class1' => $class1, ':class2' => $class2);
$stmt = $mydata1_db->prepare('select class3,rate from mydata2_db.ka_bl where  class1=:class1 and class2=:class2 order by id');
$stmt->execute($params);
$plArray = array();
$betnumber = 0;
while ($row = $stmt->fetch()){
	$betnumber++;
	$plArray[$betnumber]['rate'] = $row['rate'];
	$plArray[$betnumber]['class3'] = $row['class3'];
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
	  .ui-block-a,.ui-block-b,.ui-block-c
	  {
		  border: 1px solid black;
		  height: 35px;
		  font-weight: bold;
	  }
	  .lhc-bgc-a
	  {
		  padding-top: 2px;
		  background-color: #FCF8E9;
	  }
	  .lhc-bgc-a1
	  {
		  padding-top: 6px;
		  background-color: #FCF8E9;
	  }
	  .lhc-bgc-b
	  {
		  padding-top: 6px;
		  background-color: #EEEEEE;
	  }
	  .lhc-bgc-c
	  {
		  padding-top: 2px;
		  background-color: #EEEEEE;
	  }
	  .lhc-bgc-abc
	  {
		  padding-top: 6px;
		  background-color: lightgray;
	  }
	  .lhc-circle-a
	  {
		  width: 30px;
		  height: 30px;
		  background-color: #ffc1c1;
		  border-radius: 20px;
	  }
	  .lhc-circle-b
	  {
		  height: 30px;
		  line-height: 30px;
		  display: block;
		  color: #000;
		  text-align: center;
		  font-size: 18px;
	  }
	  .lhc-info
	  {
		  border-width: 1px;
		  border-color: lightgray;
		  border-style: solid;
		  padding: 5px;
	  }
	  #lt_form{
		  text-align: center;
	  }
  </style>
</head>
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 736px;">
  <input type="hidden" name="uid" id="uid" value="<?=$uid;?>">
  <!--头部开始-->
  <header id="header">
  <?php if ($uid != 0){?> 		  
  	  <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a>
  <?php }?>
	  <span>彩票游戏</span>
	  <a href="javascript:window.location.href='../index.php'" class="ico ico_home ico_home_r ui-link"></a>
  </header>
  <div class="mrg_header"></div>
  <!--头部结束-->


  <section class="sliderWrap clearfix">
	  <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit">
	  <h1 class="ui-title" role="heading" aria-level="1">六合彩 - <?=$class2;?></h1>
	  </div><?php include_once '_pankouinfoshow.php';?>	  </section>
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
                $(".ui-block-c").filter(".lhc-bgc-abc").find("span").html("选择");
                $("section").last().find("div").last().hide();
                $.cookie("m_lot_quick", "true", {expires: 7, path: "/"});
                $(".lhc-bgc-c").find("span").length<=0 && ($(".lhc-bgc-c").append("<span></span>").find("input[type=text]").hide());
            }else{
                quick_input.hide();
                $(".ui-block-c").filter(".lhc-bgc-abc").find("span").html("金额");
                $("section").last().find("div").last().show();
                $.cookie("m_lot_quick", "false", {expires: -1, path: "/"});
                $(".lhc-bgc-c").find("input[type=text]").show().siblings("span").remove();
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
                $(".quick_selected").find("input[type=text]").val(v.replace(/[^\d]/g, "")),
                submitForm();
            }else{
                $("form").trigger("reset");
            }
        })
        $(".lhc-bgc-a, .lhc-bgc-b, .lhc-bgc-c, .lhc-bgc-a1").on("click", function(){
            var e = $(this), i, v = quick_input.find("input").val();
            bet_mode=="quick" && (!e.hasClass("ui-block-c") && (e = e.nextAll(".ui-block-c").first()), i = e.find("input[type=text]"), i.length>0 && (e.hasClass("quick_selected") ? (i.val(""), i.siblings("span").html(""), e.prevAll().andSelf().slice(-3).css("background-color", "").removeClass("quick_selected")) : (i.val(v), i.siblings("span").html("√"), e.prevAll().andSelf().slice(-3).css("background-color", "#cddc39").addClass("quick_selected"))))
        });
        $("form").on("reset", function(){
            $(".quick_selected").css("background-color", "").removeClass("quick_selected").filter(".lhc-bgc-c").children("span").html("");
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
  <section class="mContent clearfix" style="padding:0 1px 0 2px;">
	  <form name="lt_form" id="lt_form" method="post" action="_post.php" data-role="none" data-ajax="false">
	  <div style="clear:both;" data-role="none">
		  <div class="ui-grid-b">
			  <div class="ui-block-a lhc-bgc-abc"><span>选项</span></div>
			  <div class="ui-block-b lhc-bgc-abc"><span>赔率</span></div>
			  <div class="ui-block-c lhc-bgc-abc"><span>金额</span></div>
			  <?php 
				for ($i = 1;$i <= $betnumber;$i++){
					$colorfornum = '';
					if ($plArray[$i]['class3'] == '红波')
					{
						$colorfornum = 'style="color:red;"';
					}
					else if ($plArray[$i]['class3'] == '绿波')
					{
						$colorfornum = 'style="color:green;"';
					}
					else if ($plArray[$i]['class3'] == '蓝波')
					{
						$colorfornum = 'style="color:blue;"';
					}
					else
					{
						$colorfornum = '';
					}
			  ?>
			  <div class="ui-block-a lhc-bgc-a1">
				  <span<?=$colorfornum;?>><?=$plArray[$i]['class3'];?></span>
			  </div>
			  <div class="ui-block-b lhc-bgc-b">
				  <span id="bl<?=$i;?>" style="color:red;"><?=$plArray[$i]['rate'];?></span>
			  </div>
			  <div class="ui-block-c lhc-bgc-c">
				  <input type="text" name="num_<?=$i;?>" id="num_<?=$i;?>" maxlength="7" style="width:80%;" data-role="none">
				  <input type="hidden" name="vnum_<?=$i;?>" id="vnum_<?=$i;?>" value="<?=$plArray[$i]['rate'];?>">
			  </div><?php }?> 			  </div>
	  </div>
	  <div style="clear:both;text-align:center;">
		  <a href="javascript:document.lt_form.reset();" class="ui-btn ui-btn-inline">重设</a>
		  <input type="hidden" name="class1" id="class1" value="<?=$class1;?>">
		  <input type="hidden" name="class2" id="class2" value="<?=$class2;?>">
		  <input type="hidden" name="betlist" id="betlist" value="">
		  <button name="btnSubmit" onClick="return submitForm();" class="ui-btn ui-btn-inline">提交</button>
	  </div>
	  </form>
  </section>

  <!--底部开始--><?php include_once '../bottom.php';?>	  <!--底部结束-->
  <!--我的资料--><?php include_once '../member/myinfo.php';?>	
  <script type="text/javascript" src="../js/script.js"></script>
  <script type="text/javascript">
	  //规范输入金额
	  $('#lt_form').find("input:text").attr("onkeyup","digitOnly(this)");
	
	  //提交前确认
	  function submitForm(){
		  //登录后才能下注
		  var myuid = $("#uid").val();
		  if(myuid<=0 || myuid==''){
			  alert("请先登录，再下注");
			  return false;
		  }
		  //判断金额
		  var betlist = "";
		  var allmoney = 0;
		  var mix =<?=$cp_zd;?>;
		  var max =<?=$cp_zg;?>;
		  for(var i=1;i<=58;i++){
			  if($("#num_"+i).val()!=null && $("#num_"+i).val()!=''){
				  var money = parseInt($("#num_"+i).val());
				  //判断最小下注金额
				  if (money < mix) {
					  c = false;
					  alert("最低下注金额："+mix+"￥");
					  $("#num_"+i).focus();
					  return false;
				  }
				  if (money > max) {
					  d = false;
					  alert("最高下注金额："+max+"￥");
					  $("#num_"+i).focus();
					  return false;
				  }
				  allmoney = allmoney + money;
				  betlist = betlist + i + ",";
			  }
		  }
		  if(allmoney<=0){
			  alert("请输入金额！");
			  return false;
		  }else if(allmoney><?=$userinfo['money']<=0 ? 0 : $userinfo['money'];?>){
			  alert("下注总金额:"+allmoney+"￥,大于可用额度：<?=$userinfo['money']<=0 ? 0 : $userinfo['money'];?>￥");
			  return false;
		  }else{
			  $("#betlist").val(betlist);
			  document.lt_form.submit();
		  }
	  }
  </script>
</body>
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default">
<span class="ui-icon-loading"></span><h1>loading</h1>
</div>
</html>