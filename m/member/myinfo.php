<div data-role="popup" id="popupPanel" data-corners="true" data-theme="b" data-shadow="true" class="ui-popup ui-body-b ui-overlay-shadow ui-corner-all" style="position: fixed;top:20px;left:20px;"> 
  <div style="margin:5px 2px 5px 2px;padding:1px 1px 1px 1px;"> 
	  <ul data-role="listview" class="ui-listview"> 
		  <li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-inherit ui-first-child"> 
			  我的资料 
			  <a href="javascript:closeMenu();" style="float:right;" class="ui-link">关闭</a> 
		  </li> 
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>账号：<?=$username;?></label> 
		  </li> 
		  <li class="ui-li-static ui-body-inherit"> 
			  <label>余额：<span id="user_money">0.00</span></label> 
		  </li> 
		  <li> 
			  <a href="javascript:window.location.href='/m/member/hk_money.php'" class="ui-btn ui-btn-icon-right ui-icon-carat-r"> 
			  汇款提交 
			  </a> 
		  </li> 
		  <li> 
			  <a href="javascript:window.location.href='/m/member/zr_money.php'" class="ui-btn ui-btn-icon-right ui-icon-carat-r"> 
			  额度转换 
			  </a> 
		  </li> 
		  <li> 
			  <a href="javascript:window.location.href='/m/member/zr_data_money.php'" class="ui-btn ui-btn-icon-right ui-icon-carat-r"> 
			  转换记录 
			  </a> 
		  </li> 
		  <li> 
			  <a href="javascript:window.location.href='/m/member/records_ty.php?a_type=ds'" class="ui-btn ui-btn-icon-right ui-icon-carat-r"> 
			  下注记录 
			  </a> 
		  </li> 
		  <li> 
			  <a href="javascript:window.location.href='/m/member/orders.php'" class="ui-btn ui-btn-icon-right ui-icon-carat-r"> 
			  财务记录 
			  </a> 
		  </li> 
		  <li class="ui-last-child"> 
			  <a href="javascript:window.location.href='/logout.php'" class="ui-btn ui-btn-icon-right ui-icon-carat-r"> 
			  安全退出 
			  </a> 
		  </li> 
	  </ul> 
  </div> 
</div>
<?php if ($uid){?> 
<script language="javascript"> 
  top_money();
  function showMenu(){ 
 	$("#popupPanel").popup("open");
  } 
  function closeMenu(){ 
  	$("#popupPanel").popup("close");
  } 
</script>
<?php }?>