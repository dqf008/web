<?php 
session_start();
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/logintu.php';
include_once '../common/function.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
if (intval($web_site['ssc']) == 1)
{
	message('重庆时时彩系统维护，暂停下注！');
	exit();
}
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
  <title>WelCome</title> 
      <script type="text/javascript" src="/js/jquery.js?_=171"></script>   
      <script type="text/javascript" src="/box/jquery.jBox-2.3.min.js"></script> 
	  <script type="text/javascript" src="/box/jquery.jBox-zh-CN.js"></script> 
      <script type="text/javascript" src="js/cq_ssc.js"></script> 
      <script language="javascript" src="/js/mouse.js"></script> 
      <link type="text/css" rel="stylesheet" href="../box/Green/jbox.css"/> 
      <link type="text/css" rel="stylesheet" href="css/ssc.css"/> 
  </head> 
  <body> 
  <div class="lottery_main"> 
  <div class="ssc_right"> 
    <div id="auto_list"></div> 
  </div> 
  <div class="ssc_left"> 
      <div class="flash"> 
        <div class="f_left"> 
   <span id='cqc_sound' off='0' class="laba" laba_c><img src='images/on.png' title='关闭/打开声音'/></span> 
          <div class="time minute"> 
            <span><img src='images/time/0.png'></span><span><img src='images/time/0.png'></span> 
          </div> 
          <div class="colon"> 
            <img src='images/time/10.png'> 
          </div> 
          <div class="time second"> 
            <span><img src='images/time/0.png'></span><span><img src='images/time/0.png'></span> 
          </div> 
          <div class="qh">第 <span id="open_qihao">00000000-000</span> 期 </div> 
        </div> 
        <div class="f_right"> 
          <div class="top">重庆时时彩倒计时<span id="downtime" style="color: #F9E101;">00:00:00</span><span>第 <font id='numbers' class="red number">00000000-000</font> 期</span><!--<span><a href="ssc_list.php" class="lista">开奖结果</a></span>--></div> 
          <div class="kick "><img src='images/ssc_opennum/x.gif'></div> 
          <div class="kick thousand"><img src='images/ssc_opennum/x.gif'></div> 
          <div class="kick hundred"><img src='images/ssc_opennum/x.gif'></div> 
          <div class="kick ten"><img src='images/ssc_opennum/x.gif'></div> 
          <div class="kick individual"><img src='images/ssc_opennum/x.gif'></div> 
          <div class="fot" id="autoinfo">开奖数据获取中...</div> 
        </div> 
      </div> 
      <div class="touzhu"> 
  <form name="orders" action="order/order.php?type=2&class=1" method="post" target="OrderFrame"> 
        	  <ul id="menu_hm"> 
            	  <li class="current" onclick="hm_odds(1)">第一球<span>(万位)</span></li> 
              <li class="current_n" onclick="hm_odds(2)">第二球<span>(千位)</span></li> 
              <li class="current_n" onclick="hm_odds(3)">第三球<span>(百位)</span></li> 
              <li class="current_n" onclick="hm_odds(4)">第四球<span>(十位)</span></li> 
              <li class="current_n" onclick="hm_odds(5)">第五球<span>(个位)</span></li> 
		  </ul> 
  <table class="bian" border="0" cellpadding="0" cellspacing="1"> 
              <tr class="bian_tr_title"> 
                  <td>号</td> 
                  <td>赔率</td> 
                  <td width="70">金额</td> 
                  <td>号</td> 
                  <td>赔率</td> 
                  <td width="70">金额</td> 
                  <td>号</td> 
                  <td>赔率</td> 
                  <td width="70">金额</td> 
                  <td>号</td> 
                  <td>赔率</td> 
                  <td width="70">金额</td> 
                <td>号</td> 
                <td>赔率</td> 
                <td width="70">金额</td> 
              </tr> 
              <tr class="bian_tr_txt"> 
                  <td class="bian_td_qiu"><img src="images/ball_2/0.png" /></td> 
                  <td class="bian_td_odds" id="ball_1_h1" width="40"></td> 
                  <td class="bian_td_inp" id="ball_1_t1"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_2/1.png" /></td> 
                  <td class="bian_td_odds" id="ball_1_h2" width="40"></td> 
                  <td class="bian_td_inp" id="ball_1_t2"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_2/2.png" /></td> 
                  <td class="bian_td_odds" id="ball_1_h3" width="40"></td> 
                  <td class="bian_td_inp" id="ball_1_t3"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_2/3.png" /></td> 
                  <td class="bian_td_odds" id="ball_1_h4" width="40"></td> 
                  <td class="bian_td_inp" id="ball_1_t4"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_2/4.png" /></td> 
                  <td class="bian_td_odds" id="ball_1_h5" width="40"></td> 
                  <td class="bian_td_inp" id="ball_1_t5"></td> 
              </tr> 
              <tr class="bian_tr_txt"> 
                  <td class="bian_td_qiu"><img src="images/ball_2/5.png" /></td> 
                  <td class="bian_td_odds" id="ball_1_h6" width="40"></td> 
                  <td class="bian_td_inp" id="ball_1_t6"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_2/6.png" /></td> 
                  <td class="bian_td_odds" id="ball_1_h7" width="40"></td> 
                  <td class="bian_td_inp" id="ball_1_t7"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_2/7.png" /></td> 
                  <td class="bian_td_odds" id="ball_1_h8" width="40"></td> 
                  <td class="bian_td_inp" id="ball_1_t8"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_2/8.png" /></td> 
                  <td class="bian_td_odds" id="ball_1_h9" width="40"></td> 
                  <td class="bian_td_inp" id="ball_1_t9"></td> 
                <td class="bian_td_qiu"><img src="images/ball_2/9.png" /></td> 
                <td class="bian_td_odds" id="ball_1_h10" width="40"></td> 
                <td class="bian_td_inp" id="ball_1_t10"></td> 
              </tr> 
              <tr class="bian_tr_txt"> 
                <td class="bian_td_qiu">大</td> 
                <td class="bian_td_odds" id="ball_1_h11"></td> 
                <td class="bian_td_inp" id="ball_1_t11"></td> 
                <td class="bian_td_qiu">小</td> 
                <td class="bian_td_odds" id="ball_1_h12"></td> 
                <td class="bian_td_inp" id="ball_1_t12"></td> 
                <td class="bian_td_qiu">单</td> 
                <td class="bian_td_odds" id="ball_1_h13"></td> 
                <td class="bian_td_inp" id="ball_1_t13"></td> 
                <td class="bian_td_qiu">双</td> 
                <td class="bian_td_odds" id="ball_1_h14"></td> 
                <td class="bian_td_inp" id="ball_1_t14"></td> 
                <td colspan="3">&nbsp;</td> 
              </tr> 
        </table> 
       	    <ul id="menu_zh" style="margin-top:20px;"> 
            	  <li class="current">总和/龙虎和</li> 
		  </ul> 
        	  <table class="bian" border="0" cellpadding="0" cellspacing="1"> 
              <tr class="bian_tr_title"> 
                <td>选项</td> 
                  <td>赔率</td> 
                  <td width="70">金额</td> 
                <td>选项</td> 
                  <td>赔率</td> 
                  <td width="70">金额</td> 
                <td>选项</td> 
                  <td>赔率</td> 
                  <td width="70">金额</td> 
                <td>选项</td> 
                  <td>赔率</td> 
                <td width="70">金额</td> 
              </tr> 
              <tr class="bian_tr_txt"> 
                      <td width="50" class="bian_td_qiu">总和大</td> 
                      <td class="bian_td_odds" id="ball_6_h1"></td> 
                      <td width="70" class="bian_td_inp" id="ball_6_t1"></td> 
                      <td width="50" class="bian_td_qiu">总和小</td> 
                      <td class="bian_td_odds" id="ball_6_h2"></td> 
                      <td width="70" class="bian_td_inp" id="ball_6_t2"></td> 
                      <td width="50" class="bian_td_qiu">总和单</td> 
                      <td class="bian_td_odds" id="ball_6_h3"></td> 
                      <td width="70" class="bian_td_inp" id="ball_6_t3"></td> 
                      <td width="50" class="bian_td_qiu">总和双</td> 
                      <td class="bian_td_odds" id="ball_6_h4"></td> 
                      <td width="70" class="bian_td_inp" id="ball_6_t4"></td> 
                </tr> 
                <tr class="bian_tr_txt"> 
                      <td width="50" class="bian_td_qiu">龙</td> 
                      <td class="bian_td_odds" id="ball_6_h5"></td> 
                      <td width="70" class="bian_td_inp" id="ball_6_t5"></td> 
                      <td width="50" class="bian_td_qiu">虎</td> 
                      <td class="bian_td_odds" id="ball_6_h6"></td> 
                      <td width="70" class="bian_td_inp" id="ball_6_t6"></td> 
                      <td width="50" class="bian_td_qiu">和</td> 
                      <td class="bian_td_odds" id="ball_6_h7"></td> 
                      <td width="70" class="bian_td_inp" id="ball_6_t7"></td> 
                      <td colspan="3">&nbsp;</td> 
                </tr> 
             </table> 
       	    <ul id="menu_s" style="margin-top:20px;"> 
            	  <li class="current" onclick="s_odds(7)">前三球</li> 
              <li class="current_n" onclick="s_odds(8)">中三球</li> 
              <li class="current_n" onclick="s_odds(9)">后三球</li> 
		  </ul> 
        	  <table class="bian" border="0" cellpadding="0" cellspacing="1"> 
              <tr class="bian_tr_title"> 
                  <td>选项</td> 
                  <td>赔率</td> 
                  <td width="70">金额</td> 
                  <td>选项</td> 
                  <td>赔率</td> 
                  <td width="70">金额</td> 
                  <td>选项</td> 
                  <td>赔率</td> 
                  <td width="70">金额</td> 
                  <td>选项</td> 
                  <td>赔率</td> 
                  <td width="70">金额</td> 
                <td>选项</td> 
                <td>赔率</td> 
                <td width="70">金额</td> 
              </tr> 
              <tr class="bian_tr_txt"> 
                  <td class="bian_td_qiu">豹子</td> 
                  <td class="bian_td_odds" id="ball_7_h1" width="40"></td> 
                  <td class="bian_td_inp" id="ball_7_t1"></td> 
                  <td class="bian_td_qiu">顺子</td> 
                  <td class="bian_td_odds" id="ball_7_h2" width="40"></td> 
                  <td class="bian_td_inp" id="ball_7_t2"></td> 
                  <td class="bian_td_qiu">对子</td> 
                  <td class="bian_td_odds" id="ball_7_h3" width="40"></td> 
                  <td class="bian_td_inp" id="ball_7_t3"></td> 
                  <td class="bian_td_qiu">半顺</td> 
                  <td class="bian_td_odds" id="ball_7_h4" width="40"></td> 
                  <td class="bian_td_inp" id="ball_7_t4"></td> 
                  <td class="bian_td_qiu">杂六</td> 
                  <td class="bian_td_odds" id="ball_7_h5" width="40"></td> 
                  <td class="bian_td_inp" id="ball_7_t5"></td> 
              </tr> 
        </table> 
        <div class="button_body"><a onclick="reset()" class="button again" title="重填"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="button submit" onclick="order();" title="下注"></a></div> 
        </form> 
      </div> 
      <div class="lottery_clear"></div> 
  </div> 
  </div> 
  <div id="endtime"></div> 
  <script type="text/javascript">loadinfo()</script> 
  <IFRAME id="OrderFrame" name="OrderFrame" border=0 marginWidth=0 frameSpacing=0 src="" frameBorder=0 noResize width=0 scrolling=AUTO height=0 vspale="0" style="display:none"></IFRAME> 
  <div style="display:none" id="look"></div> 
  <div style='width:1px;height:1px;overflow:hidden;'> 
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"  
             codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0"  
             width="1" height="1" id="swfcontent" align="middle"> 
        <param name="allowScriptAccess" value="sameDomain" /> 
        <param name="movie" value="play.swf" /> 
        <param name="quality" value="high" /> 
        <param name="bgcolor" value="#ffffff" /> 
        <embed src="play.swf" quality="high" bgcolor="#ffffff" width="550"  
               height="400" name="swfcontent" align="middle" allowScriptAccess="sameDomain"  
               type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" /> 
      </object> 
    </div> 
  </body> 
  </html>