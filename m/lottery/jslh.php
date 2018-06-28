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
      <script type="text/javascript">
        $(document).ready(function(){
            $("a[data-type]").on("click", function(){
                var a = $(this).data("action");
                typeof(a)=="undefined"&&(a = "comm"),
                window.location.href = "jslh_"+a+".php?t="+$(this).data("type")
            })
        });
      </script>
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
				  极速六合
			  </h1> 
		  </div> 
<?php include realpath('_jslh.php'); ?>
	  </section> 
	  <!--赛事列表--> 
	  <section class="mContent clearfix" style="padding:0px;"> 
        <div data-role="collapsibleset" data-iconpos="right" data-inset="false" class="ui-collapsible-set">
            <div style="padding: 0 15px 10px 10px;" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-b">
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-b ">
                    <li class="ui-first-child ui-last-child">
                        <a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="tema">特码</a></li>
                </ul>
            </div>
            <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b" data-content-theme="a" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-a">
                <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">正特</h4>
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-a ">
                    <li class="ui-first-child"><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="zheng1te">正1特</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="zheng2te">正2特</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="zheng3te">正3特</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="zheng4te">正4特</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="zheng5te">正5特</a></li>
                    <li class="ui-last-child"><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="zheng6te">正6特</a>
                    </li>
                </ul>   
            </div>
            <div style="padding: 0 15px 10px 10px;" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-b">
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-b ">
                    <li class="ui-first-child ui-last-child">
                        <a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="zhengma">正码</a></li>
                </ul>
            </div>
            <div style="padding: 0 15px 10px 10px;" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-b">
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-b ">
                    <li class="ui-first-child ui-last-child">
                        <a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="" data-action="zhengma6">正码1-6</a></li>
                </ul>
            </div>
            <div style="padding: 0 15px 10px 10px;" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-b">
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-b ">
                    <li class="ui-first-child ui-last-child">
                        <a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="" data-action="guoguan">过关</a></li>
                </ul>
            </div>
            <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b" data-content-theme="a" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-a">
                <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">连码</h4>
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-a ">
                    <li class="ui-first-child"><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="sanquanzhong" data-action="lianma">三全中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="sanzhonger" data-action="lianma">三中二</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="erquanzhong" data-action="lianma">二全中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="erzhongte" data-action="lianma">二中特</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="techuan" data-action="lianma">特串</a></li>
                    <li class="ui-last-child"><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="sizhongyi" data-action="lianma">四中一</a></li>
                    </li>
                </ul>   
            </div>
            <div style="padding: 0 15px 10px 10px;" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-b">
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-b ">
                    <li class="ui-first-child ui-last-child">
                        <a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="banbo">半波</a></li>
                </ul>
            </div>
            <div style="padding: 0 15px 10px 10px;" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-b">
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-b ">
                    <li class="ui-first-child ui-last-child">
                        <a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="yixiao">一肖</a></li>
                </ul>
            </div>
            <div style="padding: 0 15px 10px 10px;" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-b">
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-b ">
                    <li class="ui-first-child ui-last-child">
                        <a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="weishu">尾数</a></li>
                </ul>
            </div>
            <div style="padding: 0 15px 10px 10px;" data-theme="b" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-b">
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-b ">
                    <li class="ui-first-child ui-last-child">
                        <a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="texiao">特码生肖</a></li>
                </ul>
            </div>
            <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b" data-content-theme="a" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-a">
                <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">合肖</h4>
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-a ">
                    <li class="ui-first-child"><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="er" data-action="hexiao">二肖</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="san" data-action="hexiao">三肖</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="si" data-action="hexiao">四肖</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="wu" data-action="hexiao">五肖</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="liu" data-action="hexiao">六肖</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="qi" data-action="hexiao">七肖</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="ba" data-action="hexiao">八肖</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="jiu" data-action="hexiao">九肖</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="shi" data-action="hexiao">十肖</a></li>
                    <li class="ui-last-child"><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="shiyi" data-action="hexiao">十一肖</a></li>
                    </li>
                </ul>   
            </div>
            <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b" data-content-theme="a" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-a">
                <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">生肖连</h4>
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-a ">
                    <li class="ui-first-child"><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="erzhong" data-action="shengxiaolian">二肖连中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="sanzhong" data-action="shengxiaolian">三肖连中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="sizhong" data-action="shengxiaolian">四肖连中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="wuzhong" data-action="shengxiaolian">五肖连中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="erbuzhong" data-action="shengxiaolian">二肖连不中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="sanbuzhong" data-action="shengxiaolian">三肖连不中</a></li>
                    <li class="ui-last-child"><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="sibuzhong" data-action="shengxiaolian">四肖连不中</a></li>
                    </li>
                </ul>   
            </div>
            <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b" data-content-theme="a" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-a">
                <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">尾数连</h4>
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-a ">
                    <li class="ui-first-child"><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="erzhong" data-action="weishulian">二尾连中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="sanzhong" data-action="weishulian">三尾连中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="sizhong" data-action="weishulian">四尾连中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="erbuzhong" data-action="weishulian">二尾连不中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="sanbuzhong" data-action="weishulian">三尾连不中</a></li>
                    <li class="ui-last-child"><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="sibuzhong" data-action="weishulian">四尾连不中</a></li>
                    </li>
                </ul>   
            </div>
            <div style="padding: 0 15px 10px 10px;" data-role="collapsible" data-theme="b" data-content-theme="a" class="ui-collapsible ui-collapsible-themed-content ui-first-child ui-collapsible-collapsed ui-group-theme-a">
                <h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">全不中</h4>
                <ul data-role="listview" data-inset="false" class="ui-listview ui-group-theme-a ">
                    <li class="ui-first-child"><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="wu" data-action="buzhong">五不中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="liu" data-action="buzhong">六不中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="qi" data-action="buzhong">七不中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="ba" data-action="buzhong">八不中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="jiu" data-action="buzhong">九不中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="shi" data-action="buzhong">十不中</a></li>
                    <li><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="shiyi" data-action="buzhong">十一不中</a></li>
                    <li class="ui-last-child"><a href="javascript:;" data-role="none" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-type="shier" data-action="buzhong">十二不中</a></li>
                    </li>
                </ul>   
            </div>
          </div> 
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