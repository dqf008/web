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
$list = [
    'sanquanzhong' => 56,
    'sanzhonger' => 57,
    'erquanzhong' => 58,
    'erzhongte' => 59,
    'techuan' => 60,
    'sizhongyi' => 61,
];
$type = isset($_GET['t'])&&in_array($_GET['t'], array_keys($list))?$_GET['t']:'sanquanzhong';
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
			  <h1 class="ui-title" role="heading" aria-level="1" data-class="<?php echo $odds[$list[$type]][0][0]; ?>"> 
				  极速六合 - <?php echo $odds[$list[$type]][0][0]; ?>
			  </h1> 
		  </div> 
<?php include realpath('_jslh.php'); ?>
	  </section> 
  <script type="text/javascript">
    $(document).ready(function(){
        var limit = <?php echo $odds[$list[$type]][0][4]; ?>, max = 10, dm = 0;
        limit>max&&(max = limit),
        $("#lt_form > div > input").on("keyup", function(){
            var v = $(this).val(), n = v.replace(/[^\d]/g, "");
            v!=n && $(this).val(n);
        }),
        $("#lt_form > div > a").on("click", function(){
            if($(this).index()>0){
                var s = parseFloat($("#lt_form > div > input").val()), m = [], d, a = $("[data-id]:checked"), b = $("input[name=pabc]:checked").val(), l = $("[data-odds]").data("odds").split("/"), t1, t2;
                pankouflag ? (
                    s>0 ? (
                        d = b=="1"?a.map(function(){
                            var t = $(this);
                            return {
                                BetContext: t.siblings().text(),
                                Id: t.data("id"),
                                Lines: "undefined"==typeof l[1]?l[0]:l[1],
                                SubLines: "undefined"==typeof l[1]?undefined:l[0],
                            }
                        }).get().perm(limit):(b=="2"?$(a.filter(":not(:disabled)").map(function(){
                            var t = $(this);
                            return {
                                BetContext: t.siblings().text(),
                                Id: t.data("id"),
                                Lines: "undefined"==typeof l[1]?l[0]:l[1],
                                SubLines: "undefined"==typeof l[1]?undefined:l[0],
                            }
                        }).get().perm(limit>2?limit-2:1)).map(function(i, d){
                            a.filter(":disabled").each(function(){
                                var t = $(this);
                                d.unshift({
                                    BetContext: t.siblings().text(),
                                    Id: t.data("id"),
                                    Lines: "undefined"==typeof l[1]?l[0]:l[1],
                                    SubLines: "undefined"==typeof l[1]?undefined:l[0],
                                });
                            });
                            return [d]
                        }).get():(a = $("[data-role=fieldcontain]").eq(b-1).find("select"),
                        t1 = a.eq(0).find("option:selected").val().split(","),
                        t2 = a.eq(1).find("option:selected").val().split(","),
                        $(t1).map(function(i, d1){
                            $(t2).map(function(i, d2){
                                d1==d2&&t2.splice(i, 1);
                            })
                        }),
                        $(t1).map(function(i, d1){
                            d1 = $("[data-num="+d1+"]");
                            return $(t2).map(function(i, d2){
                                return d2 = $("[data-num="+d2+"]"), d1.data("id")==d2.data("id")?undefined:[[{
                                    BetContext: d1.siblings().text(),
                                    Id: d1.data("id"),
                                    Lines: "undefined"==typeof l[1]?l[0]:l[1],
                                    SubLines: "undefined"==typeof l[1]?undefined:l[0],
                                },
                                {
                                    BetContext: d2.siblings().text(),
                                    Id: d2.data("id"),
                                    Lines: "undefined"==typeof l[1]?l[0]:l[1],
                                    SubLines: "undefined"==typeof l[1]?undefined:l[0],
                                }]]
                            }).get()
                        }).get())),
                        d = $(d).map(function(i, d){
                            var t = [], l = [];
                            for(i=0;i<d.length;i++)t.push(d[i].BetContext), l.push(d[i].Lines);
                            return l = l.min(), m.push($("[data-class]").data("class")+"["+t.join(",")+"] @ "+l+" x ￥"+s), {
                                Id: d[0].Id,
                                BetContext: d,
                                Lines: l,
                                BetType: 1,
                                Money: s,
                                IsTeMa: false,
                                IsForNumber: false
                            }
                        }).get(),
                        ((b=="1"||b=="2")&&a.size()>=limit&&a.size()<=max)||d.length>0 ? confirm("共 ￥"+(s*d.length)+" / "+d.length+" 笔，确定下注吗？\n\n下注明细如下：\n\n"+m.join("\n")) && window.post({action: "bet", betParameters: d, lotteryId: "jslh"}, function(r){
                                r.result==1 ? (alert("投注成功！"), $("#lt_form > div > a:first").trigger("click")) : alert("投注失败！赔率可能发生变化！")
                            }
                        ) : alert(b=="1"||b=="2"?"只能选择"+(limit>=max?max:limit+"-"+max)+"个号码":"请选择对碰号码")
                    ) : alert("请输入下注金额！")
                ) : alert("已经封盘，请稍后进行投注！")
            }else{
                $("input[name=pabc]:checked").trigger("change"),
                $("#lt_form > div > input").removeAttr("value")
            }
        }),
        $("[data-id]").on("change", function(){
            var t = $(this), a = $("input[name=pabc]:checked").val(), v = $("[data-role=fieldcontain]").eq(1).find("input");
            (a=="1"||a=="2")&&pankouflag&&t.is(":checked")&&($("[data-id]:checked").size()>max||(a=="2"&&dm>0&&(t.prop("disabled", true), v.eq(1).val(v.eq(0).val()), v.eq(0).val(t.siblings().text()), dm--), false))&&(t.prop("checked", false), alert("只能选择"+(limit>=max?max:limit+"-"+max)+"个号码"))
        }),
        $("input[name=pabc]").on("change", function(){
            var t = $("[data-role=fieldcontain]").not(":first");
            t.find("input").removeAttr("value"),
            t.find("select").find("option:first").prop("selected", true),
            t.find("select").siblings().html("请选择"),
            t.hide(),
            $("[data-id]").prop("checked", false).prop("disabled", false).siblings().removeClass("ui-btn-active ui-checkbox-on").parent().removeClass("ui-state-disabled");
            switch($(this).val()){
                case "2":
                dm = limit>2?2:1,
                t.eq(0).show();
                break;
                case "3":
                $("[data-id]").prop("disabled", true).parent().addClass("ui-state-disabled");
                t.eq(1).show();
                break;
                case "4":
                $("[data-id]").prop("disabled", true).parent().addClass("ui-state-disabled");
                t.eq(2).show();
                break;
                case "5":
                $("[data-id]").prop("disabled", true).parent().addClass("ui-state-disabled");
                t.eq(3).show();
                break;
            }
        }),
        $("select").on("change", function(){
            var t = $(this), s = t.parents("[data-role=fieldcontain]").find("select").not(this).val();
            t.val()!=""&&s!==""&&t.val()==s&&(t.find("option:first").prop("selected", true), t.siblings().html("请选择"), alert("不能选择相同的号码"))
        }),
        window.reload = function(){
            window.post({action: "info", type: "lines", lotteryId: "jslh", lotteryPan: "lianma", panType: "<?php echo $list[$type]; ?>"}, function(d){
                var v = d.Obj.Lines["j<?php echo show_id($list[$type], 0); ?>"];
                $("[data-odds]").data("odds", v).html(d.Obj.Lines["tips"]+"赔率：<span style=\"color:red\">"+v+"</span>"),
                $("[data-role=fieldcontain]").find("input, select").prop("disabled", false).parent().removeClass("ui-state-disabled"),
                $("input[name=pabc]:checked").trigger("change")
            })
        },
        window.disabled = function(){
            $("[data-odds]").data("odds", 0).html("即时赔率：--"),
            $("#lt_form > div > input").removeAttr("value"),
            $("input[name=pabc]:checked").trigger("change"),
            $("[data-role=fieldcontain]").find("input, select").prop("disabled", true).parent().addClass("ui-state-disabled"),
            $("[data-id]").prop("disabled", true).parent().addClass("ui-state-disabled")
        },
        Array.prototype.perm=function(a){var b,c,d=this,e=new Array(a),f=function(a,b,c){var d,e=[],g=[];for("undefined"==typeof c&&(c=0),"undefined"==typeof b&&(b=0);c<a[b].length;c++)if(g="undefined"==typeof a[b+1]?[]:f(a,b+1,c),g.length>0)for(d=0;d<g.length;d++)g[d].unshift(a[b][c]),e.push(g[d]);else e.push([a[b][c]]);return e};for(b=0;a>b;b++)for(e[b]=new Array(d.length-a+1),c=0;c<e[b].length;c++)e[b][c]=d[b+c];return d.length>=a?f(e):!1},
        Array.prototype.min=function(){var c,a=this[0],b=this.length;for(c=1;b>c;c++)this[c]<a&&(a=this[c]);return a}
    });
  </script>
    <section class="mContent" style="padding-left:0px;padding-right:0px;padding-top:5px;">
      <form name="lt_form" id="lt_form" method="post"
          action="#"
          data-role="none" data-ajax="false">
          <fieldset data-role="controlgroup" data-type="horizontal" class="ui-controlgroup ui-controlgroup-horizontal ui-corner-all">
              <div class="ui-controlgroup-controls" id="normal_num">
              <?php 
                foreach($odds[$list[$type]][1] as $id=>$val){
                    $id = show_id($list[$type], $id);
              ?>
                  <div class="ui-checkbox">
                      <label for="num_<?php echo $id; ?>" class="ui-btn ui-corner-all ui-btn-inherit ui-checkbox-off"><?php echo substr('00'.$val, -2); ?></label>
                      <input id="num_<?php echo $id; ?>" type="checkbox" name="num_<?php echo $id; ?>" data-id="<?php echo $id; ?>" data-num="<?php echo $val; ?>">
                  </div>
              <?php }?>                 
              </div>
          </fieldset>
          <div style="clear: both;margin: 10px 0" data-odds="0">即时赔率：--</div>
          <div data-role="fieldcontain" id="a2" data-type="horizontal" class="ui-field-contain">
              <div class="ui-radio">
                  <label for="pabc1" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-on">正常</label>
                  <input id="pabc1" name="pabc" type="radio" value="1" checked="true">
              </div>
              <div class="ui-radio">
                  <label for="pabc2" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-off">胆拖</label>
                  <input id="pabc2" name="pabc" type="radio" value="2">
              </div>
              <?php if($list[$type]>=58&&$list[$type]<=60){ ?>
              <div class="ui-radio">
                  <label for="pabc3" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-off">生肖对碰</label>
                  <input id="pabc3" name="pabc" type="radio" value="3">
              </div>
              <div class="ui-radio">
                  <label for="pabc4" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-off">尾数对碰</label>
                  <input id="pabc4" name="pabc" type="radio" value="4">
              </div>
              <div class="ui-radio">
                  <label for="pabc5" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-off">肖串尾</label>
                  <input id="pabc5" name="pabc" type="radio" value="5">
              </div>
              <?php } ?>
          </div>
          <div data-role="fieldcontain" style="display:none" class="ui-field-contain">
              <label for="dm1">胆1</label>
              <div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset">
                  <input type="text" readonly="true">
              </div>
              <label for="dm2" class="dm2class">胆2</label>
              <div class="dm2class ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset">
                  <input type="text" readonly="true">
              </div>
          </div>
          <?php if($list[$type]>=58&&$list[$type]<=60){ ?>
          <div data-role="fieldcontain" style="display:none" class="ui-field-contain">                 
              <label for="pan1">第1肖：</label>
              <div class="ui-select">
                  <select name="pan1" id="pan1">
                      <option value="">请选择</option>
                      <?php foreach($LOT['animal'] as $key=>$val){ ?>
                      <option value="<?php echo implode(',', $val); ?>"><?php echo $key; ?></option>
                      <?php } ?>
                  </select>
              </div>
              <label for="pan2"  class="pan2class">第2肖：</label>
              <div class="pan2class ui-select">
                  <select name="pan2" id="pan2">
                      <option value="">请选择</option>
                      <?php foreach($LOT['animal'] as $key=>$val){ ?>
                      <option value="<?php echo implode(',', $val); ?>"><?php echo $key; ?></option>
                      <?php } ?>
                  </select>
              </div>
          </div>
          <div data-role="fieldcontain" style="display:none" class="ui-field-contain">
              <label for="pan3">尾数1：</label>
              <div class="ui-select">
                  <select name="pan3" id="pan3">
                      <option value="">请选择</option>
                      <option value="10,20,30,40">0尾</option>
                      <option value="1,11,21,31,41">1尾</option>
                      <option value="2,12,22,32,42">2尾</option>
                      <option value="3,13,23,33,43">3尾</option>
                      <option value="4,14,24,34,44">4尾</option>
                      <option value="5,15,25,35,45">5尾</option>
                      <option value="6,16,26,36,46">6尾</option>
                      <option value="7,17,27,37,47">7尾</option>
                      <option value="8,18,28,38,48">8尾</option>
                      <option value="9,19,29,39,49">9尾</option>
                  </select>
              </div>
              <label for="pan4" class="pan4class">尾数2：</label>
              <div class="pan4class ui-select">
                  <select name="pan4" id="pan4">
                      <option value="">请选择</option>
                      <option value="10,20,30,40">0尾</option>
                      <option value="1,11,21,31,41">1尾</option>
                      <option value="2,12,22,32,42">2尾</option>
                      <option value="3,13,23,33,43">3尾</option>
                      <option value="4,14,24,34,44">4尾</option>
                      <option value="5,15,25,35,45">5尾</option>
                      <option value="6,16,26,36,46">6尾</option>
                      <option value="7,17,27,37,47">7尾</option>
                      <option value="8,18,28,38,48">8尾</option>
                      <option value="9,19,29,39,49">9尾</option>
                  </select>
              </div>
          </div>
          <div data-role="fieldcontain" style="display:none" class="ui-field-contain">
              <label for="pan5">生肖：</label>
              <div class="ui-select">
                  <select name="pan5" id="pan5">
                      <option value="">请选择</option>
                      <?php foreach($LOT['animal'] as $key=>$val){ ?>
                      <option value="<?php echo implode(',', $val); ?>"><?php echo $key; ?></option>
                      <?php } ?>
                  </select>
              </div>
              <label for="pan6" class="pan4class">尾数：</label>
              <div class="pan4class ui-select">
                  <select name="pan6" id="pan6">
                      <option value="">请选择</option>
                      <option value="10,20,30,40">0尾</option>
                      <option value="1,11,21,31,41">1尾</option>
                      <option value="2,12,22,32,42">2尾</option>
                      <option value="3,13,23,33,43">3尾</option>
                      <option value="4,14,24,34,44">4尾</option>
                      <option value="5,15,25,35,45">5尾</option>
                      <option value="6,16,26,36,46">6尾</option>
                      <option value="7,17,27,37,47">7尾</option>
                      <option value="8,18,28,38,48">8尾</option>
                      <option value="9,19,29,39,49">9尾</option>
                  </select>
              </div>
          </div>
          <?php } ?>
          <div style="clear: both;margin: 10px 0;text-align:center">
              下注金额：
              <input type="text" maxlength="7" size="7" style="width: 80px;" data-role="none">
          </div>
          <div style="clear: both;text-align: center;">
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