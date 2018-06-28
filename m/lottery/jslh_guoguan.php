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
$odds = include(IN_LOT.'include/odds/jslh.php');
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
				  极速六合 - 正码
			  </h1> 
		  </div> 
<?php include realpath('_jslh.php'); ?>
	  </section> 
  <script type="text/javascript">
    $(document).ready(function(){
        $("#lt_form > div > input").on("keyup", function(){
            var v = $(this).val(), n = v.replace(/[^\d]/g, "");
            v!=n && $(this).val(n);
        }),
        $("#lt_form > div > a").on("click", function(){
            if($(this).index()>0){
                var e = $("#lt_form > div > input"), s = 0, c = 0, m = [], d = [{
                    Id: 0,
                    BetContext: [],
                    Lines: e.data("odds"),
                    BetType: 1,
                    Money: e.val(),
                    IsTeMa: false,
                    IsForNumber: false
                }];
                pankouflag ? (
                    parseFloat(d[0].Money)>0 ? (
                        d[0].BetContext = $("#myform input:checked").map(function(){
                            var t = $(this);
                            return m.push(t.parents("ul").data("class")+"["+t.data("type")+"] @ "+t.data("odds")), {
                                BetContext: t.parents("ul").data("class")+"-"+t.data("type")+"@"+t.data("odds"),
                                Id: t.siblings("label").data("id"),
                                Lines: t.data("odds"),
                            }
                        }).get(),
                        d[0].BetContext.length>1&&d[0].BetContext.length<=8 ? confirm(d[0].BetContext.length+" 串 1 @ "+e.data("odds")+" x ￥"+d[0].Money+"，确定下注吗？\n\n过关明细如下：\n\n"+m.join("\n")) && (d[0].Id = d[0].BetContext[0].Id, window.post({action: "bet", betParameters: d, lotteryId: "jslh"}, function(r){
                                r.result==1 ? (alert("投注成功！"), $("#lt_form > div > a:first").trigger("click")) : alert("投注失败！赔率可能发生变化！")
                            }
                        )) : alert("只能选择2-8个号码")
                    ) : alert("请输入下注金额！")
                ) : alert("已经封盘，请稍后进行投注！")
            }else{
                pankouflag && ($("label[data-id]").siblings("input").removeAttr("checked"),
                $("#lt_form > div > span:first, #lt_form > div > span:last").html("0"),
                $("#lt_form > div > input").removeAttr("value"))
            }
        }),
        $("#myform input").on("change", function(){
            var a = $("#lt_form > div > span:first"), b = $("#lt_form > div > span:last"), v = 0, o = 1;
            $("#myform input:checked").size()>8&&($(this).removeAttr("checked"),
            alert("只能选择2-8个号码")),
            $("#myform input:checked").each(function(){
                v++,
                o*= parseFloat($(this).data("odds"))
            }),
            o = (Math.round(o*100)/100).toFixed(2),
            a.html(v),
            b.html(v==0?"0":o),
            $("#lt_form > div > input").data("odds", v==0?"0":o)
        }),
        window.reload = function(){
            window.post({action: "info", type: "lines", lotteryId: "jslh", lotteryPan: "guoguan", panType: "15"}, function(d){
                $.each(d.Obj.Lines, function(k, v){
                    k = k.substring(1),
                    $("label[data-id="+k+"] > span").html(v).parent().siblings("input").data("odds", v).attr("disabled", false)
                })
            })
        },
        window.disabled = function(){
            $("label[data-id] > span").html("--").parent().siblings("input").attr("disabled", true).removeAttr("checked"),
            $("#lt_form > div > span:first, #lt_form > div > span:last").html("0"),
            $("#lt_form > div > input").removeAttr("value")
        }
    });
  </script>
	  <!--赛事列表--> 
      <!--赛事列表-->
      <section class="mContent" style="padding-left:0px;padding-right:0px;padding-top:5px;">
          <div id="myform" data-role="collapsibleset" data-theme="a" data-content-theme="a" class="ui-collapsible-set ui-group-theme-a ui-corner-all">
            <?php for($id1=15;$id1<=20;$id1++){ ?>
              <div data-role="collapsible" class="ui-collapsible ui-collapsible-inset ui-corner-all ui-collapsible-themed-content ui-collapsible-collapsed ui-first-child">
                  <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed"><?php echo $odds[$id1][0][1]; ?></h4>
                  <ul data-role="listview" data-inset="false" class="ui-listview" data-class="<?php echo $odds[$id1][0][1]; ?>">
                      <li class="ui-li-static ui-body-inherit ui-first-child">
                          <input type="radio" value="1" id="zm_<?php echo $id1; ?>0" name="zm_<?php echo $id1; ?>11" data-role="none" data-type="单">
                          &nbsp;&nbsp;
                          <label style="display:inline !important;" for="zm_<?php echo $id1; ?>0" data-id="<?php echo show_id($id1, 1); ?>">单 (赔率:<span>--</span>)</label>
                      </li>
                      <li class="ui-li-static ui-body-inherit">
                          <input type="radio" value="2" id="zm_<?php echo $id1; ?>1" name="zm_<?php echo $id1; ?>11" data-role="none" data-type="双">
                          &nbsp;&nbsp;
                          <label style="display:inline !important;" for="zm_<?php echo $id1; ?>1" data-id="<?php echo show_id($id1, 2); ?>">双 (赔率:<span>--</span>)</label>
                      </li>
                      <li class="ui-li-static ui-body-inherit">
                          <input type="radio" value="3" id="zm_<?php echo $id1; ?>2" name="zm_<?php echo $id1; ?>12" data-role="none" data-type="大">
                          &nbsp;&nbsp;
                          <label style="display:inline !important;" for="zm_<?php echo $id1; ?>2" data-id="<?php echo show_id($id1, 3); ?>">大 (赔率:<span>--</span>)</label>
                      </li>
                      <li class="ui-li-static ui-body-inherit">
                          <input type="radio" value="4" id="zm_<?php echo $id1; ?>3" name="zm_<?php echo $id1; ?>12" data-role="none" data-type="小">
                          &nbsp;&nbsp;
                          <label style="display:inline !important;" for="zm_<?php echo $id1; ?>3" data-id="<?php echo show_id($id1, 4); ?>">小 (赔率:<span>--</span>)</label>
                      </li>
                      <li class="ui-li-static ui-body-inherit">
                          <input type="radio" value="5" id="zm_<?php echo $id1; ?>4" name="zm_<?php echo $id1; ?>13" data-role="none" data-type="红波">
                          &nbsp;&nbsp;
                          <label style="display:inline !important;" for="zm_<?php echo $id1; ?>4" data-id="<?php echo show_id($id1, 5); ?>"><font style="color:red;">红波</font> (赔率:<span>--</span>)</label>
                      </li>
                      <li class="ui-li-static ui-body-inherit">
                          <input type="radio" value="6" id="zm_<?php echo $id1; ?>5" name="zm_<?php echo $id1; ?>13" data-role="none" data-type="绿波">
                          &nbsp;&nbsp;
                          <label style="display:inline !important;" for="zm_<?php echo $id1; ?>5" data-id="<?php echo show_id($id1, 6); ?>"><font style="color:green;">绿波</font> (赔率:<span>--</span>)</label>
                      </li>
                      <li class="ui-li-static ui-body-inherit ui-last-child">
                          <input type="radio" value="7" id="zm_<?php echo $id1; ?>6" name="zm_<?php echo $id1; ?>13" data-role="none" data-type="蓝波">
                          &nbsp;&nbsp;
                          <label style="display:inline !important;" for="zm_<?php echo $id1; ?>6" data-id="<?php echo show_id($id1, 7); ?>"><font style="color:blue;">蓝波</font> (赔率:<span>--</span>)</label>
                      </li>
                  </ul>
              </div>
              <?php } ?>
          </div>
          <div id="form_order"></div>
          <form name="lt_form" id="lt_form" method="post" action="#" data-role="none" data-ajax="false">
              <div style="clear:both;margin:10px 0;">
                  下注金额：<input type="text" maxlength="7" size="7" style="width:80px;" data-role="none">
              </div>
              <div style="clear:both;margin:10px 0;"><span style="color:red">0</span> 串 <span style="color:red">1</span> @ <span style="color:red">0</span></div>
              <div style="clear:both;text-align:center;">
                  <a href="javascript:;" class="ui-btn ui-btn-inline">取消下注</a>
                  <a href="javascript:;" class="ui-btn ui-btn-inline">确认下注</a>
              </div>
          </form>
      </section>
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