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
if (intval($web_site['pk10']) == 1)
{
	message('北京赛车PK拾系统维护，暂停下注！');
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
      <script type="text/javascript" src="js/bj_pk10.js"></script> 
      <script language="javascript" src="/js/mouse.js"></script> 
      <link type="text/css" rel="stylesheet" href="../box/Green/jbox.css"/> 
      <link type="text/css" rel="stylesheet" href="css/bjsc.css"/> 
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
          <div class="top">北京赛车PK拾倒计时<span id="downtime" style="color: #F9E101;">00:00:00</span><span>第 <font id='numbers' class="red number">00000000-000</font> 期</span></div> 
          <div class="kick "><img src='images/Ball_5/x1.png'></div> 
          <div class="kick er"><img src='images/Ball_5/x2.png'></div> 
          <div class="kick san"><img src='images/Ball_5/x3.png'></div> 
          <div class="kick si"><img src='images/Ball_5/x4.png'></div> 
          <div class="kick wu"><img src='images/Ball_5/x5.png'></div> 
          <div class="kick liu"><img src='images/Ball_5/x6.png'></div> 
          <div class="kick qi"><img src='images/Ball_5/x7.png'></div> 
          <div class="kick ba"><img src='images/Ball_5/x8.png'></div> 
          <div class="kick jiu"><img src='images/Ball_5/x9.png'></div> 
          <div class="kick shi"><img src='images/Ball_5/x10.png'></div> 
          <div class="fot" id="autoinfo">开奖数据获取中...</div> 
        </div> 
      </div> 
      <div class="touzhu"> 
  <form name="orders" action="order/order4.php?type=4&class=1" method="post" target="OrderFrame"> 
      <table class="bian" border="0" cellpadding="0" cellspacing="1"> 
          <tr class="bian_tr_bg"><td colSpan="12">冠、亚军和（冠军车号+亚军车号）</td></tr> 
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
              <td class="bian_td_qiu">3</td> 
              <td class="bian_td_odds" id="ball_1_h1"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t1"></td> 
              <td class="bian_td_qiu">4</td> 
              <td class="bian_td_odds" id="ball_1_h2"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t2"></td> 
              <td class="bian_td_qiu">5</td> 
              <td class="bian_td_odds" id="ball_1_h3"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t3"></td> 
              <td class="bian_td_qiu">6</td> 
              <td class="bian_td_odds" id="ball_1_h4"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t4"></td> 
          </tr> 
          <tr class="bian_tr_txt"> 
              <td class="bian_td_qiu">7</td> 
              <td class="bian_td_odds" id="ball_1_h5"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t5"></td> 
              <td class="bian_td_qiu">8</td> 
              <td class="bian_td_odds" id="ball_1_h6"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t6"></td> 
              <td class="bian_td_qiu">9</td> 
              <td class="bian_td_odds" id="ball_1_h7"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t7"></td> 
              <td class="bian_td_qiu">10</td> 
              <td class="bian_td_odds" id="ball_1_h8"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t8"></td> 
          </tr> 
          <tr class="bian_tr_txt"> 
              <td class="bian_td_qiu">11</td> 
              <td class="bian_td_odds" id="ball_1_h9"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t9"></td> 
              <td class="bian_td_qiu">12</td> 
              <td class="bian_td_odds" id="ball_1_h10"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t10"></td> 
              <td class="bian_td_qiu">13</td> 
              <td class="bian_td_odds" id="ball_1_h11"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t11"></td> 
              <td class="bian_td_qiu">14</td> 
              <td class="bian_td_odds" id="ball_1_h12"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t12"></td> 
          </tr> 
          <tr class="bian_tr_txt"> 
              <td class="bian_td_qiu">15</td> 
              <td class="bian_td_odds" id="ball_1_h13"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t13"></td> 
              <td class="bian_td_qiu">16</td> 
              <td class="bian_td_odds" id="ball_1_h14"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t14"></td> 
              <td class="bian_td_qiu">17</td> 
              <td class="bian_td_odds" id="ball_1_h15"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t15"></td> 
              <td class="bian_td_qiu">18</td> 
              <td class="bian_td_odds" id="ball_1_h16"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t16"></td> 
          </tr> 
          <tr class="bian_tr_txt"> 
              <td class="bian_td_qiu">19</td> 
              <td class="bian_td_odds" id="ball_1_h17"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t17"></td> 
              <td class="bian_td_qiu"></td> 
              <td class="bian_td_odds"></td> 
              <td width="70" class="bian_td_inp"></td> 
              <td class="bian_td_qiu"></td> 
              <td class="bian_td_odds"></td> 
              <td width="70" class="bian_td_inp"></td> 
              <td class="bian_td_qiu"></td> 
              <td class="bian_td_odds"></td> 
              <td width="70" class="bian_td_inp"></td> 
          </tr> 
          <tr class="bian_tr_txt"> 
              <td class="bian_td_qiu">冠亚大</td> 
              <td class="bian_td_odds" id="ball_1_h18"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t18"></td> 
              <td class="bian_td_qiu">冠亚小</td> 
              <td class="bian_td_odds" id="ball_1_h19"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t19"></td> 
              <td class="bian_td_qiu">冠亚单</td> 
              <td class="bian_td_odds" id="ball_1_h20"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t20"></td> 
              <td class="bian_td_qiu">冠亚双</td> 
              <td class="bian_td_odds" id="ball_1_h21"></td> 
              <td width="70" class="bian_td_inp" id="ball_1_t21"></td> 
          </tr> 
      </table> 
        	  <ul id="menu_hm" style="margin-top: 20px;"> 
            	  <li class="current" onclick="hm_odds(2)">冠军<span></span></li> 
              <li class="current_n" onclick="hm_odds(3)">亚军<span></span></li> 
              <li class="current_n" onclick="hm_odds(4)">第三名<span></span></li> 
              <li class="current_n" onclick="hm_odds(5)">第四名<span></span></li> 
              <li class="current_n" onclick="hm_odds(6)">第五名<span></span></li> 
              <li class="current_n" onclick="hm_odds(7)">第六名<span></span></li> 
              <li class="current_n" onclick="hm_odds(8)">第七名<span></span></li> 
              <li class="current_n" onclick="hm_odds(9)">第八名<span></span></li> 
              <li class="current_n" onclick="hm_odds(10)">第九名<span></span></li> 
              <li class="current_n" onclick="hm_odds(11)">第十名<span></span></li> 
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
                  <td class="bian_td_qiu"><img src="images/ball_5/1.png" /></td> 
                  <td class="bian_td_odds" id="ball_2_h1" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t1"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_5/2.png" /></td> 
                  <td class="bian_td_odds" id="ball_2_h2" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t2"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_5/3.png" /></td> 
                  <td class="bian_td_odds" id="ball_2_h3" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t3"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_5/4.png" /></td> 
                  <td class="bian_td_odds" id="ball_2_h4" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t4"></td> 
              </tr> 
              <tr class="bian_tr_txt"> 
                  <td class="bian_td_qiu"><img src="images/ball_5/5.png" /></td> 
                  <td class="bian_td_odds" id="ball_2_h5" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t5"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_5/6.png" /></td> 
                  <td class="bian_td_odds" id="ball_2_h6" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t6"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_5/7.png" /></td> 
                  <td class="bian_td_odds" id="ball_2_h7" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t7"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_5/8.png" /></td> 
                  <td class="bian_td_odds" id="ball_2_h8" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t8"></td> 
              </tr> 
              <tr class="bian_tr_txt"> 
                  <td class="bian_td_qiu"><img src="images/ball_5/9.png" /></td> 
                  <td class="bian_td_odds" id="ball_2_h9" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t9"></td> 
                  <td class="bian_td_qiu"><img src="images/ball_5/10.png" /></td> 
                  <td class="bian_td_odds" id="ball_2_h10" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t10"></td> 
                  <td class="bian_td_qiu"></td> 
                  <td class="bian_td_odds" width="40"></td> 
                  <td class="bian_td_inp"></td> 
                  <td class="bian_td_qiu"></td> 
                  <td class="bian_td_odds" width="40"></td> 
                  <td class="bian_td_inp"></td> 
              </tr> 
              <tr class="bian_tr_txt"> 
                  <td class="bian_td_qiu">大</td> 
                  <td class="bian_td_odds" id="ball_2_h11" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t11"></td> 
                  <td class="bian_td_qiu">小</td> 
                  <td class="bian_td_odds" id="ball_2_h12" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t12"></td> 
                  <td class="bian_td_qiu">单</td> 
                  <td class="bian_td_odds" id="ball_2_h13" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t13"></td> 
                  <td class="bian_td_qiu">双</td> 
                  <td class="bian_td_odds" id="ball_2_h14" width="40"></td> 
                  <td class="bian_td_inp" id="ball_2_t14"></td> 
              </tr> 
        </table> 
        	  <table class="bian" border="0" cellpadding="0" cellspacing="1" style="margin-top: 20px;"> 
              <tr class="bian_tr_bg"> 
                <td colSpan="3">1V10 龙虎</td> 
                <td colSpan="3">2V9 龙虎</td> 
                <td colSpan="3">3V8 龙虎</td> 
                <td colSpan="3">4V7 龙虎</td> 
                <td colSpan="3">5V6 龙虎</td> 
              </tr> 
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
                  <td class="bian_td_qiu">龙</td> 
                  <td class="bian_td_odds" id="ball_12_h1"></td> 
                  <td width="70" class="bian_td_inp" id="ball_12_t1"></td> 
                  <td class="bian_td_qiu">龙</td> 
                  <td class="bian_td_odds" id="ball_13_h1"></td> 
                  <td width="70" class="bian_td_inp" id="ball_13_t1"></td> 
                  <td class="bian_td_qiu">龙</td> 
                  <td class="bian_td_odds" id="ball_14_h1"></td> 
                  <td width="70" class="bian_td_inp" id="ball_14_t1"></td> 
                  <td class="bian_td_qiu">龙</td> 
                  <td class="bian_td_odds" id="ball_15_h1"></td> 
                  <td width="70" class="bian_td_inp" id="ball_15_t1"></td> 
                  <td class="bian_td_qiu">龙</td> 
                  <td class="bian_td_odds" id="ball_16_h1"></td> 
                  <td width="70" class="bian_td_inp" id="ball_16_t1"></td> 
                </tr> 
                <tr class="bian_tr_txt"> 
                      <td class="bian_td_qiu">虎</td> 
                      <td class="bian_td_odds" id="ball_12_h2"></td> 
                      <td width="70" class="bian_td_inp" id="ball_12_t2"></td> 
                      <td class="bian_td_qiu">虎</td> 
                      <td class="bian_td_odds" id="ball_13_h2"></td> 
                      <td width="70" class="bian_td_inp" id="ball_13_t2"></td> 
                      <td class="bian_td_qiu">虎</td> 
                      <td class="bian_td_odds" id="ball_14_h2"></td> 
                      <td width="70" class="bian_td_inp" id="ball_14_t2"></td> 
                      <td class="bian_td_qiu">虎</td> 
                      <td class="bian_td_odds" id="ball_15_h2"></td> 
                      <td width="70" class="bian_td_inp" id="ball_15_t2"></td> 
                      <td class="bian_td_qiu">虎</td> 
                      <td class="bian_td_odds" id="ball_16_h2"></td> 
                      <td width="70" class="bian_td_inp" id="ball_16_t2"></td> 
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