<?php
$include_file = 'sports';
include_once dirname(__FILE__).'/xp.php';
exit;
include_once 'include/config.php';
website_close();
website_deny();
include_once 'database/mysql.config.php';
include_once 'common/logintu.php';
include_once 'common/function.php';
include_once 'myfunction.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
      <title></title> 
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
      <script type="text/javascript" src="skin/js/jquery-1.7.2.min.js?_=171"></script> 
      <script type="text/javascript" src="skin/js/common.js?_=171"></script> 
      <script type="text/javascript" src="skin/js/upup.js?_=171"></script> 
      <script type="text/javascript" src="skin/js/float.js?_=171"></script> 
      <script type="text/javascript" src="skin/js/swfobject.js?_=171"></script> 
      <script type="text/javascript" src="skin/js/jquery.cookie.js?_=171"></script> 
      <script type="text/javascript" src="skin/js/jingcheng.js?_=171"></script> 
      <script type="text/javascript" src="skin/js/top.js?_=171"></script>   
      <script type="text/javascript" src="box/jquery.jBox-2.3.min.js"></script> 
      <script type="text/javascript" src="box/jquery.jBox-zh-CN.js"></script> 
      <link type="text/css" rel="stylesheet" href="box/Green/jbox.css"/> 
      <link href="skin/css/standard.css?_=171" rel="stylesheet" type="text/css" /> 
      <script type="text/javascript" src="skin/js/tab.js?_=171"></script> 
      <script type="text/javascript"> 
          if (self == top) { location = '/';}  
          if (window.location.host != top.location.host) { top.location = window.location;}  
      </script> 
      <style type="text/css"> 
          html 
          { 
              margin: 0;
              padding: 0;
          } 
          body 
          { 
              padding: 0;
              margin: 0px auto;
              font-family: 新細明體,Arial, Helvetica, sans-serif;
              font-size: 12px;
              background: url(../newindex/bg_game.jpg) center top #1B110D repeat-x;
          } 
          #mainBody_bg 
          { 
              width: 1000px;
              height: auto;
              margin: 0px auto;
          } 
          #mainBody 
          { 
              width: 1000px;
              height: auto;
              margin: 0px auto;
          } 
          #login_bg 
          { 
              float: left;
              width: 254px;
              height: 83px;
              margin: 17px 0px 0px 0px;
              _margin: 17px 0px 0px 1px;
              padding: 8px 0px 0px 80px;
              background: url(../newindex/login.jpg) left top no-repeat;
          } 
          #top_login 
          { 
              float: right;
              width: 235px;
              height: 78px;
              color: #000000;
              margin: 17px 17px 0px 0px;
              _margin: 17px 8px 0px 0px;
              padding: 13px 0px 0px 99px;
              background: url(../newindex/login2.jpg) left top no-repeat;
          } 
           
          #joinUs 
          { 
              float: left;
              width: 324px;
              height: 120px;
              cursor: pointer;
              background: url(../newindex/join.jpg) left bottom no-repeat;
          } 
          #joinUs a 
          { 
              float: left;
              width: 324px;
              height: 120px;
              cursor: pointer;
              background: url(../newindex/join.jpg) left top no-repeat;
          } 
          #welcome 
          { 
              float: left;
              width: 324px;
              height: 120px;
              background: url(../newindex/welcome.jpg) left bottom no-repeat;
          } 
          #welcome div 
          { 
              float: left;
              width: 324px;
              height: 120px;
              background: url(../newindex/welcome.jpg) left top no-repeat;
          } 
          .first_prize 
          { 
              float: left;
              width: 246px;
              height: 120px;
              margin: 0 31px;
              background: url(../newindex/prize.gif) left top no-repeat;
          } 
          #event 
          { 
              float: left;
              width: 324px;
              height: 120px;
              background: url(../newindex/event.jpg) left bottom no-repeat;
          } 
          #event a 
          { 
              float: left;
              width: 324px;
              height: 120px;
              background: url(../newindex/event.jpg) left top no-repeat;
          } 
          .first_news 
          { 
              width: 960px;
              height: 44px;
              color: #FFFFFF;
              margin: 0 auto;
              background: url(../newindex/news.jpg) left top no-repeat;
          } 
           
      </style> 
      <script type="text/javascript" src="newindex/starball.js"></script> 
      <link href="newindex/starball.css" rel="stylesheet" type="text/css"> 
      <!--[if IE 6]> 
      <style type="text/css"> 
          html { overflow-x: hidden;} 
          body { padding-right: 1em;} 
      </style> 
      <script type="text/javascript" src="skin/js/jquery.ifixpng.js?_=171"></script> 
      <script type="text/javascript"> 
          $(function(){ 
              $('img[src$=".png?_=171"],img[src$=".png"],.blk_29 .LeftBotton, .blk_29 .RightBotton').ifixpng();
          });
          //修正ie6 bug 
          try { 
              document.execCommand("BackgroundImageCache", false, true);
          } catch(err) {} 
      </script> 
      <![endif]--> 
  </head> 
  <body> 
  <div id="mainBody_bg"> 
      <div id="mainBody"> 
          <div id="page-header"><?php include_once 'myhead.php';?>            <div id="header_ad"> 
                  <div class="first_news"> 
                      <marquee scrollamount="3" scrolldelay="150" direction="left" id="msgNews" onmouseover="this.stop();" onmouseout="this.start();" onclick="HotNewsHistory();" style="cursor: pointer;" height="44" width="800"><?=$msg;?></marquee> 
                  </div> 
              </div> 
          </div> 
          <div class="clear"></div> 
          <div style="width:1000px;margin:0px auto;"> 
			  <div style="width:242px;float:left;"> 
				  <iframe name="leftFrame" id="leftFrame" src="left.php" width="242" height="600" frameborder="0" marginheight="0" marginwidth="0" scrolling="auto"></iframe> 
			  </div> 
			  <div style="width:750px;float:right;"> 
				  <iframe name="mainFrame" id="mainFrame" src="show/ft_danshi.html" width="750" height="600" frameborder="0" marginheight="0" marginwidth="0" scrolling="auto"></iframe> 
			  </div> 
			  <div class="clear"></div> 
          </div><?php include_once 'mybottom.php';?>    </div>          
  </div> 
  </body> 
  </html><?php if ($uid)
{?> <script language="javascript">top_money();</script><?php }?>