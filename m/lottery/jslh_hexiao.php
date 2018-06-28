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
    'er' => 38,
    'san' => 39,
    'si' => 40,
    'wu' => 41,
    'liu' => 42,
    'qi' => 43,
    'ba' => 44,
    'jiu' => 45,
    'shi' => 46,
    'shiyi' => 47,
];
$type = isset($_GET['t'])&&in_array($_GET['t'], array_keys($list))?$_GET['t']:'er';
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
          .caipiao-selected{  
              background-color: #cddc39;
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
			  <h1 class="ui-title" role="heading" aria-level="1" data-class="<?php echo $odds[$list[$type]][0][0]; ?>"> 
				  极速六合 - <?php echo $odds[$list[$type]][0][0]; ?>
			  </h1> 
		  </div> 
<?php include realpath('_jslh.php'); ?>
	  </section> 
  <script type="text/javascript">
    $(document).ready(function(){
        var limit = <?php echo $odds[$list[$type]][0][4]; ?>, max = 8;
        limit>max&&(max = limit),
        $("#lt_form > div > input").on("keyup", function(){
            var v = $(this).val(), n = v.replace(/[^\d]/g, "");
            v!=n && $(this).val(n);
        }),
        $("#lt_form > div > a").on("click", function(){
            if($(this).index()>0){
                var s = parseFloat($("#lt_form > div > input").val()), m = [], d, a = $(".caipiao-selected[data-id] > span");
                pankouflag ? (
                    s>0 ? (
                        d = $(a.map(function(){
                            var t = $(this), e = t.parent();
                            return {
                                BetContext: e.prev().children("div").text(),
                                Id: e.data("id"),
                                Lines: t.data("odds")
                            }
                        }).get().perm(limit)).map(function(i, d){
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
                        a.size()>=limit&&a.size()<=max ? confirm("共 ￥"+(s*d.length)+" / "+d.length+" 笔，确定下注吗？\n\n下注明细如下：\n\n"+m.join("\n")) && window.post({action: "bet", betParameters: d, lotteryId: "jslh"}, function(r){
                                r.result==1 ? (alert("投注成功！"), $("#lt_form > div > a:first").trigger("click")) : alert("投注失败！赔率可能发生变化！")
                            }
                        ) : alert("只能选择"+(limit>=max?max:limit+"-"+max)+"个号码")
                    ) : alert("请输入下注金额！")
                ) : alert("已经封盘，请稍后进行投注！")
            }else{
                $("[data-id]").removeClass("caipiao-selected"),
                $("#lt_form > div > input").removeAttr("value")
            }
        }),
        $("[data-id]").on("click", function(){
            var t = $(this).data("id");
            pankouflag && (!$(this).hasClass("caipiao-selected")&&$(".caipiao-selected[data-id]").size()>=max*3 ? alert("只能选择"+(limit>=max?max:limit+"-"+max)+"个号码") : $("[data-id="+t+"]").toggleClass("caipiao-selected"))
        }),
        window.reload = function(){
            window.post({action: "info", type: "lines", lotteryId: "jslh", lotteryPan: "hexiao", panType: "<?php echo $list[$type]; ?>"}, function(d){
                $.each(d.Obj.Lines, function(k, v){
                    k = k.substring(1),
                    $("[data-id="+k+"] > span").data("odds", v).html(v)
                })
            })
        },
        window.disabled = function(){
            $("[data-id]").removeClass("caipiao-selected").find("span").html("--"),
            $("#lt_form > div > input").removeAttr("value")
        },
        Array.prototype.perm=function(a){var b,c,d=this,e=new Array(a),f=function(a,b,c){var d,e=[],g=[];for("undefined"==typeof c&&(c=0),"undefined"==typeof b&&(b=0);c<a[b].length;c++)if(g="undefined"==typeof a[b+1]?[]:f(a,b+1,c),g.length>0)for(d=0;d<g.length;d++)g[d].unshift(a[b][c]),e.push(g[d]);else e.push([a[b][c]]);return e};for(b=0;a>b;b++)for(e[b]=new Array(d.length-a+1),c=0;c<e[b].length;c++)e[b][c]=d[b+c];return d.length>=a?f(e):!1},
        Array.prototype.min=function(){var c,a=this[0],b=this.length;for(c=1;b>c;c++)this[c]<a&&(a=this[c]);return a}
    });
  </script>
  <section class="mContent clearfix" style="padding: 0 1px 0 2px;">
      <form name="lt_form" id="lt_form" method="post"
          action="#"
          data-role="none" data-ajax="false">
          <div class="ui-grid-b">
              <div class="ui-block-a caipiao-bgc-abc">
                  <span>生肖</span>
              </div>
              <div class="ui-block-b caipiao-bgc-abc">
                  <span>赔率</span>
              </div>
              <div class="ui-block-c caipiao-bgc-abc">
                  <span>号码</span>
              </div>
              <?php 
                foreach($odds[$list[$type]][1] as $id=>$val){
                    $id = show_id($list[$type], $id);
                    foreach($LOT['animal'][$val] as $key=>$a){
                        if($a==49){
                            unset($LOT['animal'][$val][$key]);
                        }else{
                            $LOT['animal'][$val][$key] = substr('00'.$a, -2);
                        }
                    }
              ?>                 
              <div class="ui-block-a caipiao-bgc-a" data-id="<?php echo $id; ?>">
                  <div><?php echo $val; ?></div>
              </div>
              <div class="ui-block-b caipiao-bgc-b" data-id="<?php echo $id; ?>">
                  <span style="color: red;">--</span>
              </div>
              <div class="ui-block-c caipiao-bgc-c" data-id="<?php echo $id; ?>">
                  <label style="font-size: 12px;"><?php echo implode(',', $LOT['animal'][$val]); ?></label>
              </div>
              <?php }?>                 
           </div>
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