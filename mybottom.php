 <div id="page-footer" style="position: relative;"> 
      <div id="bblogo"></div> 
      <div id="bankLogo"> 
          <img src="newindex/D1.png" height="44" width="179"> 
          <img src="newindex/D28.png" height="44" width="179"> 
      </div> 
      <div id="footer-article"> 
          <!-- 廳主自改 --> 
          <a href="/sm/sports.php" target="_blank">游戏规则</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="javascript:void(0);" onclick="javascript:menu_url(61);return false">关于我们</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="javascript:void(0);" onclick="javascript:menu_url(74);return false">联络我们</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="javascript:void(0);" onclick="javascript:menu_url(63);return false">合作伙伴</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="javascript:void(0);" onclick="javascript:menu_url(64);return false">存款帮助</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="javascript:void(0);" onclick="javascript:menu_url(65);return false">取款帮助</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="javascript:void(0);" onclick="javascript:menu_url(66);return false">常见问题</a> 
      </div> 
      <div id="copy_ifo"> 
          <p>Copyright ©<?=$web_site['web_name'];?>&nbsp;Reserved</p> 
      </div> 
      <div class="clear"></div> 
  </div> 
  <div id="TplFloatPic_0" style="position:absolute;cursor:pointer;display:none;width:Arraypx;height:Arraypx;" picfloat="right"> 
      <a href="javascript:void(0);" onclick="javascript:menu_url(62);return false"><img src="newindex/136411521085.png" alt=""/></a>     
      <div style="position:absolute;bottom:0;left:0;"><img src="newindex/136411552984.png" alt=""/></div> 
  </div> 
  <div id="TplFloatPic_1" style="position:absolute;cursor:pointer;display:none;width:Arraypx;height:Arraypx;" picfloat="left"> 
      <a href="javascript:void(0);" onclick="javascript:menu_url(70);return false"><img src="newindex/136411569331.png" alt=""/></a>     
      <div style="position:absolute;bottom:0;left:0;"><img src="newindex/136411580249.png" alt=""/></div> 
  </div> 
  <script type="text/javascript"> 
      var left_top = 150, right_top = 150, float_list = [];
      $(window).load(function() { 
          // 廳主自改 - 浮動圖 
          float_list['0'] = $('#TplFloatPic_0');
          float_list['1'] = $('#TplFloatPic_1');
               
          for (var i in float_list) { 
              var self = float_list[i], picfloat = (self.attr('picfloat') == 'right') ? 1 : 0;
               
              self.show().Float({'floatRight' : picfloat, 'topSide' : ((picfloat == 1) ? right_top : left_top)});
               
              // ie6 png bug 
              if (navigator.userAgent.toLowerCase().indexOf('msie 6') != -1) { 
                  $.each(self.find('img'), function(){ 
                      $(this).css({'width':$(this).width(),'height' : $(this).height()});
                  });
              } 
               
              if (picfloat) { 
                  right_top = right_top + 10 + (self.height() || 250);
              } else { 
                  left_top = left_top + 10 + (self.height() || 250);
              } 
               
              self.hover(function() { 
                  $(this).find('a > img:first').css('display', 'none');
                  $(this).find('a > img:last').css('display', 'block');
              }, function() { 
                  $(this).find('a > img:last').css('display', 'none');
                  $(this).find('a > img:first').css('display', 'block');
              }).find('div').click(function() { 
                  event.cancelBubble = true;
                  $(this).parent('div').hide();
              });
          } 
      });
       
      //按鈕特效 
      $('#logo a, #event a, #joinUs a, #welcome div').hover( 
          function(){ 
              $(this).stop().animate({'opacity': 0}, 650);
          }, function(){ 
              $(this).stop().animate({'opacity': 1}, 650);
          } 
      );
       
      $("li.LS-ball, li.LS-live, li.LS-game, li.LS-lottery").subTabs();
       
      //表單效果 
      $("#LoginForm label").InputLabels();
  </script><?php include_once 'myfootcomm.php';?>