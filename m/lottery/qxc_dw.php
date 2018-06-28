<?php 
include_once './_qxc.php';
$qxc_type = array(
    '1' => '一定位',
    '2' => '二定玩法',
    '3' => '三定玩法',
    '4' => '四定玩法',
);
$type = isset($_GET['i'])&&in_array($_GET['i'], array_keys($qxc_type))?$_GET['i']:'1';
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
          ul, ol, li{  
              list-style-type:none;
          }  
          .qxc ul {  
              width: 25%;
              padding-top: 5px;
              float:left;
          }  
          .qxc ul li{  
              background-color: #f8f8f8;
              line-height: 24px;
          }  
          .qxc .qianwei li{ 
              border-left:1px solid #DDD;
              border-right:1px solid #DDD;
              border-bottom:1px solid #DDD;
              text-align: center;
          }  
          .qxc .baiwei li{  
              border-bottom:1px solid #DDD;
              border-right:1px solid #DDD;
              text-align: center;
          }  
          .qxc .shiwei li{  
              border-bottom:1px solid #DDD;
              text-align: center;
          }  
          .qxc .gewei li{  
              border-left:1px solid #DDD;
              border-right:1px solid #DDD;
              border-bottom:1px solid #DDD;
              text-align: center;
          }  
          .qxc .disabled li{  
              text-decoration: line-through;
          }  
          .qxc li.selected{  
              background-color: #5CACEE;
          }  
          .caipiao-info {  
              border-width: 1px;
              border-color: lightgray;
              border-style: solid;
              padding: 5px;
          } 
      </style> 
  </head> 
  <body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" tabindex="0" style="min-height: 659px;"> 
      <input id="uid" value="<?=$uid;?>" type="hidden"/> 
      <input id="stype" value="1" type="hidden"/> 
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
      <section class="sliderWrap clearfix"> 
          <div data-role="header" style="overflow:hidden;" role="banner" class="ui-header ui-bar-inherit"> 
              <h1 class="ui-title" role="heading" aria-level="1">七星彩 - <?php echo $qxc_type[$type]; ?></h1> 
          </div> 
          <div class="caipiao-info">
          <?php if (0 < $tcou){?>                 
              <div style="font-size:12pt;">第<span style="color:#f60;"><?=$trow['qishu'];?></span>期</div> 
              <div style="font-size:12pt;">北京时间：<?php echo date('Y-m-d H:i:s', $trow['fengpan']);?></div> 
              <div style="font-size:12pt;">美东时间：<?php echo date('Y-m-d H:i:s', $trow['fengpan']-43200);?></div> 
              <div style="font-size:12pt;">
                  <span id="endtime" style="color:#f60;font-weight:bold;"><?php echo $trow['fengpan']-time()-43200;?></span> 
              </div>
              <div style="color:#f60;font-weight:bold;font-size:12pt;">玩法赔率：<?php echo $odds[$bet_type['dw'.$type]]; ?></div>
          <?php }else{?>                  
              <div style="font-size:12pt;">期数未开盘</div>
          <?php }?>               
          </div> 
      </section> 
      <!--赛事列表--> 
      <section class="mContent clearfix" style="padding:0px;margin-top:-9px;"> 
          <div data-role="tabs" id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all"> 
              <!-- <div id="three" class="ui-body-d ui-content ui-tabs-panel ui-widget-content ui-corner-bottom" style="padding: 0px;" aria-labelledby="ui-id-3" role="tabpanel" aria-expanded="true" aria-hidden="false">  -->
                  <div class="qxc" style="clear:both;" data-role="none"> 
                      <ul data-selected="0" class="qianwei" data-role="none"> 
                          <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;" data-role="none">
                            <select data-role="none">
                              <option>仟位</option>
                              <option>全</option>
                              <option>大</option>
                              <option>小</option>
                              <option>奇</option>
                              <option>偶</option>
                              <option>清</option>
                            </select>
                          </li> 
                          <?php for($i=0;$i<=9;$i++){ ?><li onclick="qxc_dw(this)"><?php echo $i; ?></li><?php } ?>
                      </ul> 
                      <ul data-selected="0" class="baiwei" data-role="none"> 
                          <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;" data-role="none">
                            <select data-role="none">
                              <option>佰位</option>
                              <option>全</option>
                              <option>大</option>
                              <option>小</option>
                              <option>奇</option>
                              <option>偶</option>
                              <option>清</option>
                            </select>
                          </li> 
                          <?php for($i=0;$i<=9;$i++){ ?><li onclick="qxc_dw(this)"><?php echo $i; ?></li><?php } ?>
                      </ul> 
                      <ul data-selected="0" class="shiwei" data-role="none"> 
                          <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;" data-role="none">
                            <select data-role="none">
                              <option>拾位</option>
                              <option>全</option>
                              <option>大</option>
                              <option>小</option>
                              <option>奇</option>
                              <option>偶</option>
                              <option>清</option>
                            </select>
                          </li> 
                          <?php for($i=0;$i<=9;$i++){ ?><li onclick="qxc_dw(this)"><?php echo $i; ?></li><?php } ?>
                      </ul> 
                      <ul data-selected="0" class="gewei" data-role="none"> 
                          <li style="border-top:1px solid #DDD;font-weight: bold;background-color:#EDEDED;" data-role="none">
                            <select data-role="none">
                              <option selected="selected">个位</option>
                              <option>全</option>
                              <option>大</option>
                              <option>小</option>
                              <option>奇</option>
                              <option>偶</option>
                              <option>清</option>
                            </select>
                          </li> 
                          <?php for($i=0;$i<=9;$i++){ ?><li onclick="qxc_dw(this)"><?php echo $i; ?></li><?php } ?>
                      </ul> 
                  </div> 
                  <div style="clear:both;text-align:center;"> 
                      <button class="ui-btn ui-btn-inline" onClick="qxc_add()">添加</button> 
                  </div> 
              <!-- </div> -->
          </div> 
      </section>
      <form action="qxc_post.php" method="post" id="qxc_post" data-role="none" data-ajax="false">
      <section class="mContent clearfix qxc_post" style="padding:0px;display:none"> 
          <div data-role="cotent"> 
              <ul data-role="listview" class="ui-listview"></ul> 
          </div>
          <?php if($uid){ ?>
          <div style="clear:both;text-align:center;padding-top:10px;" class="bian_td_inp">
              合计<span>0</span>注，每注金额：<input id="money" name="money" style="width:100px;" type="text" onkeyup="digitOnly(this)" maxlength="7" data-role="none" value="<?=$cp_zd;?>">
          </div>
          <div style="clear:both;padding-bottom:5px;text-align:center;">
              <p>☆最低金额:<font color="#FF0000"><?=$cp_zd;?></font>&nbsp;&nbsp;☆单注限额:<font color="#FF0000"><?=$cp_zg;?></font></p>
          </div>
          <div style="clear:both;text-align:center;"> 
              <button class="ui-btn ui-btn-inline">确认下注</button> 
          </div> 
          <?php } ?>
      </section> 
        <input type="hidden" name="type" value="dw<?php echo $type; ?>" />
      </form>
      <div style="display: none;" id="xiazhu-placeholder"><!-- placeholder for xiazhu --></div> 
    
      <!--底部开始--><?php include_once '../bottom.php';?>        <!--底部结束--> 
      <!--我的资料--><?php include_once '../member/myinfo.php';?>       
      <script type="text/javascript"> 
          //显示距离封盘的动态时间 
          var CID = "endtime", qxc_type = <?php echo $type; ?>;
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
                      sTime = "已封盘";
                  } 
                  if(iTime==-5){ 
                      clearTimeout(Account);
                      sTime = "已封盘";
                  }else{ 
                      Account = setTimeout("RemainTime()",1000);
                  } 
                  iTime = iTime-1;
              }else{ 
                  sTime = "已封盘";
              } 
              document.getElementById(CID).innerHTML = sTime;
          } 
            function digitOnly($this) {
                var n = $($this);
                var r = /^\+?[1-9][0-9]*$/;
                if(!r.test(n.val())){
                    n.val("");
                }
            }
            function qxc_dw(e){
                var p = $(e).parent(),
                r = !p.hasClass("disabled") && (
                    $(e).toggleClass("selected"),
                    (p.find("li.selected").size()>0) ? p.addClass("selected") : p.removeClass("selected")
                ),
                u = (qxc_type==2||qxc_type==3)&&(p = $(".qxc ul"), p.filter(".selected").size()>=qxc_type ? p.not(".selected").addClass("disabled").find("select").attr("disabled", true) : p.removeClass("disabled").find("select").attr("disabled", false));
            }
            function qxc_add(){
                var s, r;
                return r = $(".qxc ul").map(function(){
                    return [$(this).find("li.selected").map(function(){
                        return $(this).text()
                    }).get()]
                }).get(),
                s = qxc_check(r),
                (s[0]>0) ? (
                    $(".qxc_post").show(),
                    $(r).each(function(k, d){r[k] = d.length>0 ? d.join("") : "*"}),
                    $(".qxc ul").removeClass("disabled selected").find("li").removeClass("selected").find("select").attr("disabled", false),
                    $(".qxc_post ul.ui-listview").append("<li class=\"ui-li-static ui-body-inherit ui-first-child\" data-count=\""+s[0]+"\" ><label><span>"+r.join(",")+"</span><br />共"+s[0]+"注，<a href=\"javascript:;\">删除</a></label></li>"),
                    r = $(".qxc_post .bian_td_inp span"),
                    r.text(parseInt(r.text())+s[0])
                ) : alert(s[1]);
            }
            function qxc_check(r){
                var s = [];
                switch($("#qxc_post input[name=type]").val()){
                    case "dw1":
                    return [(r.length>3 ? r[0].length+r[1].length+r[2].length+r[3].length : 0), "至少选择一个号码"];
                    break;
                    case "dw2":
                    return r.length>=4 && ((r[0].length>0 && s.push(r[0].length)), (r[1].length>0 && s.push(r[1].length)), (r[2].length>0 && s.push(r[2].length)), (r[3].length>0 && s.push(r[3].length)), s.length>2) ? [0, "最多选择两个位置"] : [(s.length==2?s[0]*s[1]:0), "至少选择两个位置"];
                    break;
                    case "dw3":
                    return r.length>=4 && ((r[0].length>0 && s.push(r[0].length)), (r[1].length>0 && s.push(r[1].length)), (r[2].length>0 && s.push(r[2].length)), (r[3].length>0 && s.push(r[3].length)), s.length>3) ? [0, "最多选择三个位置"] : [(s.length==3?s[0]*s[1]*s[2]:0), "至少选择三个位置"];
                    break;
                    case "dw4":
                    return [(r.length>3 ? r[0].length*r[1].length*r[2].length*r[3].length : 0), "至少选择四个位置"];
                    break;
                    case "zx2":
                    return r.length>=1 && (r[0].length>2) ? [0, "最多选择两个号码"] : [(r[0].length<2?0:1), "至少选择两个号码"];
                    break;
                    case "zx3":
                    return r.length>=1 && (r[0].length>3) ? [0, "最多选择三个号码"] : [(r[0].length<3?0:1), "至少选择三个号码"];
                    break;
                }
            }
            (function(){
                $(".qxc_post ul").on("click", "li a", function(){
                    var r, c;
                    return r = $(this).parents("li"), c = parseInt(r.data("count")), r.remove(), r = $(".qxc_post .bian_td_inp span"), c = parseInt(r.text())-c, r.text(c), c<=0 && $(".qxc_post").hide();
                })
                $(".qxc_post button").on("click", function(){
                    var r = parseInt($(".qxc_post .bian_td_inp span").text()), c = $("#money").val(), f;
                    return (c=="" ? (alert("请输入金额"), !1) : !0) && confirm("合计金额"+(r*parseInt(c))+"，是否继续？") && (r = $(".qxc_post ul li"),
                    r.size()>0 ? (
                        r.map(function(){
                            return f = $("#qxc_post"),
                            f.append("<input name=\"value[]\" value=\""+$(this).find("span").text()+"\" type=\"hidden\" />");
                        }),
                        f.append("<input name=\"money\" value=\""+c+"\" type=\"hidden\" />"),
                        f.submit()
                    ) : alert("请添加一个玩法"));
                })
                $(".qxc select").on("change", function(){
                    var e = $(this), i = e.parents("ul").find("li").not(":first-child"), r = false;
                    i.map(function(){
                        return $(this).hasClass("selected") && qxc_dw(this);
                    });
                    switch(e.find(":selected").index()){
                        case 1:
                        r = i;
                        break;
                        case 2:
                        r = i.filter(":gt(4)");
                        break;
                        case 3:
                        r = i.filter(":lt(5)");
                        break;
                        case 4:
                        r = i.filter(":odd");
                        break;
                        case 5:
                        r = i.filter(":even");
                        break;
                    }
                    return r && r.map(function(){
                        return !$(this).hasClass("selected") && qxc_dw(this);
                    }),
                    e.find("option").eq(0).attr("selected", true);
                })
            })(0);
      </script> 
  </body> 
</html>