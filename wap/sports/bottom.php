 <!--底部--> 
  <div style="height:50px;"></div> 
  <center>
  <?php if (($uid == 0) || ($uid == NULL) || ($uid == '')){?>
   	  <a href="javascript:window.location.href='../#/login';" class="ui-link">登录</a><em>|</em> 
	  <a href="javascript:window.location.href='../#/reg';" class="ui-link">注册</a><em>|</em>
  <?php }?>
   	  <a href="javascript:window.scrollTo(0,0);" class="ui-link">返回顶部</a> 
  </center> 
  <div class="pad_footer copyright">Copyright &copy; <?=$web_site['web_name'];?> Reserved</div> 

  <div id="footer"> 
	  <footer class="footer"> 
		  <ul> 
			  <li> 
				  <a href="javascript:void(0);" onclick="javascript:window.location.href='<?=!$uid ? '../#/login' : '../#/ucenter/index';?>'" class="ico_u">我的账户</a> 
			  </li> 
			  <li> 
				  <a href="javascript:void(0);" onclick="javascript:window.location.href='<?=!$uid ? '../#/login' : '../#/bank/money?type=deposit';?>'" class="ico_money">线上存款</a> 
			  </li> 
			  <li> 
				  <a href="javascript:void(0);" onclick="javascript:window.location.href='<?=!$uid ? '../#/login' : '../#/bank/money?type=withdraw';?>'" class="ico_money">线上取款</a> 
			  </li> 
			  <li style="border-right:none;"> 
				  <a href="javascript:void(0);" onclick="menu_url(62);return false;" class="ico_kf">在线客服</a> 
			  </li> 
		  </ul> 
	  </footer> 
  </div>