 <!--底部--> 
  <div style="height:50px;"></div> 
  <center>
  <?php if (($uid == 0) || ($uid == NULL) || ($uid == '')){?>
   	  <a href="javascript:window.location.href='/m/login.php';" class="ui-link">登录</a><em>|</em> 
	  <a href="javascript:window.location.href='/m/register.php';" class="ui-link">注册</a><em>|</em>
  <?php }?>
   	  <a href="javascript:window.scrollTo(0,0);" class="ui-link">返回顶部</a> 
  </center> 
  <div class="pad_footer copyright">Copyright ©<?=$web_site['web_name'];?> Reserved</div> 

  <div id="footer"> 
	  <footer class="footer"> 
		  <ul> 
			  <li> 
				  <a href="javascript:void(0);" onclick="javascript:window.location.href='<?=!$uid ? '/m/login.php' : '/m/member/userinfo.php';?>'" class="ico_u">我的账户</a> 
			  </li> 
			  <li> 
				  <a href="javascript:void(0);" onclick="javascript:window.location.href='<?=!$uid ? '/m/login.php' : '/m/member/setmoney.php';?>'" class="ico_money">线上存款</a> 
			  </li> 
			  <li> 
				  <a href="javascript:void(0);" onclick="javascript:window.location.href='<?=!$uid ? '/m/login.php' : '/m/member/getmoney.php';?>'" class="ico_money">线上取款</a> 
			  </li> 
			  <li style="border-right:none;"> 
				  <a href="javascript:void(0);" onclick="menu_url(62);return false;" class="ico_kf">在线客服</a> 
			  </li> 
		  </ul> 
	  </footer> 
  </div>