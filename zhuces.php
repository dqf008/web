<?php 
session_start();
include_once 'include/config.php';
website_close();
website_deny();
$randStr = md5(uniqid(rand(), true));
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
  <title><?=$web_site['reg_msg_from'];?></title> 
  <link href="static/images/zhuces.css" rel="stylesheet" type="text/css" /> 
  </head> 
  <script language="javascript" src="js/xhr.js"></script> 
  <script language="javascript" src="js/zhuce.js?_=<?=time()?>"></script> 
  <body> 
    <div id="zhuce_top"> 
      <form id="form1" name="form1" method="post" action="reg.php" onsubmit="return formsubmit(this);"> 
      <div class="divborder marginb20"> 
          <div class="divlegend">登陆资料</div> 
          <div class="zhuce_00"> 
              <div class="zhuce_01"><font color="red">*</font> 会员账号：</div> 
              <div class="zhuce_02"><input name="zcname" class="width_00" type="text" pd="yes" maxlength="15" onfocus="inputFocus(this,0)" id="zcusername" onblur="inputBlur(this,0)" /></div> 
              <span class="zhuce_05" id="nameid">您在网站的登录帐户，5-15个英文或数字组成</span> 
          </div> 
          <div class="zhuce_00"> 
              <div class="zhuce_01"><font color="red">*</font> 会员密码：</div> 
              <div class="zhuce_02"><input name="zcpwd1" class="width_00" id="pwd1" type="password" maxlength="20" pd="yes" onfocus="inputFocus(this,1)" onblur="inputBlur(this,1),pwStrength(this.value,0);"  onkeyup="pwStrength(this.value,0);" /></div> 
              <span class="zhuce_05">由6-20位任意字符组成</span> 
          </div> 
          <div class="zhuce_00"> 
              <div class="zhuce_01">密码强度：</div> 
              <div class="zhuce_02"> 
                  <table width="200px" height="20" border="0" cellpadding="1" cellspacing="1" bordercolor="#abadb3" bgcolor="#abadb3" style='font-size:12px'>  
                      <tr align="center" bgcolor="#542E01"> 
                          <td width="33%" id="strength_L0">弱</td> 
                          <td width="33%" id="strength_M0">中</td> 
                          <td width="33%" id="strength_H0">强</td> 
                      </tr> 
                  </table> 
              </div> 
          </div> 
          <div class="zhuce_00"> 
              <div class="zhuce_01"><font color="red">*</font> 确认密码：</div> 
              <div class="zhuce_02"><input name="zcpwd2" class="width_00" type="password" pd="yes" maxlength="20" onfocus="inputFocus(this,2)" onblur="inputBlur(this,2)" /></div> 
              <span class="zhuce_05">由6-20位任意字符组成</span> 
          </div> 
          <div class="clear"></div> 
      </div> 
      <div class="clear"></div> 
      <div class="divborder"> 
          <div class="divlegend">个人资料</div> 
          <div class="zhuce_00"> 
              <div class="zhuce_01"><font color="red">*</font> 真实姓名：</div> 
              <div class="zhuce_02"><input name="zcturename" class="width_00" type="text" pd="yes" onfocus="inputFocus(this,3)" onblur="inputBlur(this,3)" /></div> 
              <span class="zhuce_05">名字必须与您用于提款及存款的银行户口所用名字相同</span> 
          </div>
          
          <?php if ($web_site['show_tel'] == "1"):?>
            <div class="zhuce_00"> 
              <div class="zhuce_01"><font color="red">*</font> 联系电话：</div> 
              <div class="zhuce_02"><input name="zctel" class="width_00" type="text" pd="yes" maxlength="11" onfocus="inputFocus(this,4)" onblur="inputBlur(this,4)"/></div> 
              <span class="zhuce_05">请填写您的固定电话或手机</span> 
          </div>
          <?php else:?>
            <input type="hidden" name="zctel" value="保密">
            <span style="display:none;"></span>
          <?php endif;?>

          <?php if ($web_site['show_qq'] == "1"):?>
            <div class="zhuce_00"> 
              <div class="zhuce_01"><font color="red">*</font> QQ或E-mail：</div> 
              <div class="zhuce_02"><input name="zcemail" class="width_00" type="text" pd="yes" onfocus="inputFocus(this,5)" onblur="inputBlur(this,5)" /></div> 
              <span class="zhuce_05">为便于以后我们和您取得联系，请用正确的邮箱或QQ</span> 
            </div>
          <?php else:?>
            <input name="zcemail" type="hidden" value="<?=$randStr?>" />
            <span style="display:none;"></span>
          <?php endif;?>

          <?php if ($web_site['show_weixin'] == "1"):?>
            <div class="zhuce_00"> 
              <div class="zhuce_01"><font color="red">*</font> 微信号：</div> 
              <div class="zhuce_02"><input name="zcweixin" class="width_00" type="text" pd="yes" onfocus="inputFocus(this,6)" onblur="inputBlur(this,6)" /></div> 
              <span class="zhuce_05">为便于以后我们和您取得联系，请用正确的微信号</span> 
          </div>
          <?php else:?>
            <input name="zcweixin" type="hidden" value="<?=$randStr?>" />
            <span style="display:none;"></span>
          <?php endif;?>
          
          <?php if ($web_site['zc_dl']!="1"||!intval($_COOKIE['f'])):?>
            <input name="jsr" value="<?=$_COOKIE['tum']?>" type="hidden"/>
            <span style="display:none;"></span>
          <?php else:?>
            <div class="zhuce_00"> 
              <div class="zhuce_01">介绍人：</div> 
              <div class="zhuce_02"><input name="jsr" class="width_00" type="text" pd="yes" value="<?=$_COOKIE['tum'];?>" readonly="readonly" /></div> 
              <span class="zhuce_05">可不填，如果您是本站会员介绍过来，请填写该会员账号</span> 
          </div>
          <?php endif;?>

          <?php if ($web_site['show_question'] == "1"):?>
          <div class="zhuce_00"> 
              <div class="zhuce_01"><font color="red">*</font> 密码问题：</div> 
              <div class="zhuce_02"> 
                  <select name="ask" id="ask" pd="yes"> 
                      <option value="您的车牌号码是多少？" selected="selected">您的车牌号码是多少？</option> 
                      <option value="您初中同桌的名字？">您初中同桌的名字？</option> 
                      <option value="您就读的第一所学校的名称？">您就读的第一所学校的名称？</option> 
                      <option value="您第一次亲吻的对象是谁？">您第一次亲吻的对象是谁？</option> 
                      <option value="少年时代心目中的英雄是谁？">少年时代心目中的英雄是谁？</option> 
                      <option value="您最喜欢的休闲运动是什么？">您最喜欢的休闲运动是什么？</option> 
                      <option value="您最喜欢哪支运动队？">您最喜欢哪支运动队？</option> 
                      <option value="您最喜欢的运动员是谁？">您最喜欢的运动员是谁？</option> 
                      <option value="您的第一辆车是什么牌子？">您的第一辆车是什么牌子？</option> 
                  </select> 
              </div> 
              <font class="zhuce_05">请选择密码问题</font>
          </div> 
          <div class="zhuce_00"> 
              <div class="zhuce_01"><font color="red">*</font> 密码答案：</div> 
              <div class="zhuce_02"><input name="answer" class="width_00" type="text" pd="yes" maxlength="20" onfocus="inputFocus(this,8)" onblur="inputBlur(this,8)" /></div> 
              <span class="zhuce_05">用于找回密码</span> 
          </div> 
          <?php else:?>
              <input type="hidden" name="ask" value="您的车牌号码是多少？">
              <input type="hidden" name="answer" value="<?=$randStr?>">
              <span style="display:none;"></span>
          <?php endif;?>


          <div class="zhuce_00"> 
              <div class="zhuce_01"><font color="red">*</font> 取款密码：</div> 
              <div class="zhuce_02"><input name="qk_pwd" class="width_00" type="text" pd="yes" onfocus="inputFocus(this,9)" onblur="inputBlur(this,9)" onkeyup="if(isNaN(value))execCommand('undo')" maxlength="6" /></div> 
              <span class="zhuce_05">提款认证必须，请务必记住</span> 
          </div> 

          <div class="zhuce_00"> 
              <div class="zhuce_01"><font color="red">*</font> 验证码：</div> 
              <div class="zhuce_02"> 
                  <table width="180" border="0" cellspacing="0" cellpadding="0"> 
                      <tr> 
                          <td width="70"><input class="yanzh" name="zcyzm" type="text" pd="yes" maxlength="4" onfocus="inputFocus(this,10);change_zc_yzm('zc_img');" onblur="inputBlur(this,10)" /></td> 
                          <td><img src="yzm.php" alt="点击刷新" name="zc_img" id="zc_img" style="cursor:pointer;" onclick="change_zc_yzm('zc_img')" /></td> 
                      </tr> 
                  </table> 
              </div> 
              <span class="zhuce_05">请填写验证码</span> 
          </div> 
          <div class="clear"></div> 
      </div> 
      <div class="clear"></div> 
      <div class="tiao_00"> 
          <input name="zccheck" type="checkbox" pd="yes" id="ischeck" checked="checked" value="1" /> 
          我已经年满18岁，且在此网站所有活动并没有抵触本人所在国家所管辖的法律 
      </div> 
      <div class="tiao_01"> 
          <input class="ju" type="submit" value="提交" /> 
          <input name="按钮" type="button" value="重填" onclick="javacript:location.reload();" /> 
      </div> 
      </form> 
  </div> 
  <script type="text/javascript" language="javascript" src="/js/left_mouse.js"></script> 
  </body> 
  </html>