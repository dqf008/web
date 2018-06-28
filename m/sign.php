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
// $msg = get_last_message();

?><!DOCTYPE html> 
<html class="ui-mobile ui-mobile-viewport ui-overlay-a"> 
<head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title><?=$web_site['web_title'];?></title> 
  <!--[if lt IE 9]> 
      <script src="js/html5.js" type="text/javascript"> 
      </script> 
      <script src="js/css3-mediaqueries.js" type="text/javascript"> 
      </script> 
  <![endif]--> 
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> 
  <meta content="yes" name="apple-mobile-web-app-capable"> 
  <meta content="black" name="apple-mobile-web-app-status-bar-style"> 
  <meta content="telephone=no" name="format-detection"> 
  <meta name="viewport" content="width=device-width"> 
  <link rel="shortcut icon" href="images/favicon.ico"> 
  <link rel="stylesheet" href="css/style.css" type="text/css" media="all"> 
  <link rel="stylesheet" href="js/jquery.mobile-1.4.5.min.css"> 
  <link rel="stylesheet" href="css/style_index.css" type="text/css" media="all"> 
  <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
  <script>$(document).bind("mobileinit", function() {$.mobile.ajaxEnabled=false;});</script>
  <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script> 
  <!--js判断横屏竖屏自动刷新--> 
  <script type="text/javascript" src="js/top.js"></script> 
</head> 
<body class="mWrap ui-page ui-page-theme-a ui-page-active" data-role="page" data-url="member/orders.php" tabindex="0" style="min-height: 659px;"> 
  <!--头部开始--> 
  <header id="header"> 
      <a href="#popupPanel" data-rel="popup" class="ico ico_menu ui-link" aria-haspopup="true" aria-owns="popupPanel" aria-expanded="false"></a> 
          <span>会员签到</span> 
      <a href="javascript:window.location.href='index.php'" class="ico ico_home ico_home_r ui-link"></a> 
  </header> 
  <div class="mrg_header"></div> 
  <!--头部结束--> 
  <script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            url: "../static/sign/sign.php?type=sign&callback=?",
            type: "GET",
            dataType: "json",
            success: function(data){
                $(".sign-loading").addClass("sign-"+data["status"]);
                $(".sign-message").html(data["message"]);
                if(data["status"]=="success"){
                    $("ul.ui-listview").empty();
                    AddLi("<img src=\"images/i.gif\"> 签到成功！");
                    if(data["data"][0]>0){
                        AddLi("本次签到奖励: "+data["data"][0]+" <span style=\"color:red\">彩金</span>");
                    }else{
                        AddLi("本次签到奖励: 手气不佳");
                    }
                    if(data["data"][4]>0){
                        AddLi("连续签到天数: "+data["data"][3]+" <span style=\"color:red\">天</span>");
                        AddLi("下次签到奖励: "+data["data"][4]+" <span style=\"color:red\">彩金</span>");
                    }
                    AddLi("累计签到天数: "+data["data"][1]+" <span style=\"color:red\">天</span>");
                    AddLi("累计签到奖励: "+data["data"][2]+" <span style=\"color:red\">彩金</span>");
                }else{
                    $("ul.ui-listview li label").html("<img src=\"images/i.gif\"><br />"+data["message"]);
                }
            }
        });
    });
    function AddLi(html){
        $("ul.ui-listview").append("<li class=\"ui-li-static ui-body-inherit ui-first-child\"><label>"+html+"</label></li>");
    }
  </script>
  <!--功能列表--> 
  <section class="mContent clearfix" style="padding:0px;"> 
      <div data-role="cotent"> 
          <ul data-role="listview" class="ui-listview"> 
              <li class="ui-li-static ui-body-inherit ui-first-child" style="line-height:25px;text-align:center;padding:50px 0"><label><img src="../Box/skins/icons/loading.gif"><br />正在为您签到，请稍后...</label></li> 
          </ul> 
      </div>
  </section> 
  <!--底部开始--><?php include_once 'bottom.php';?>    <!--底部结束--> 
  <!--我的资料--><?php include_once 'member/myinfo.php';?>
  </body> 
<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div> 
</html>