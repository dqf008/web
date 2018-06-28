<link rel="stylesheet" href="images/ball.css">
<div class="lhc-info">
  <div style="font-size:12pt;">第<span style="color:#f00"><?php echo $Lastest_KitheTable['nn']; ?></span>期开奖结果：</div>
  <div class="mark_six" style="line-height:27px">
  	<div class="ball_<?php echo $Lastest_KitheTable['n1']; ?>"><?php echo $Lastest_KitheTable['n1']; ?></div>
  	<div class="ball_<?php echo $Lastest_KitheTable['n2']; ?>"><?php echo $Lastest_KitheTable['n2']; ?></div>
  	<div class="ball_<?php echo $Lastest_KitheTable['n3']; ?>"><?php echo $Lastest_KitheTable['n3']; ?></div>
  	<div class="ball_<?php echo $Lastest_KitheTable['n4']; ?>"><?php echo $Lastest_KitheTable['n4']; ?></div>
  	<div class="ball_<?php echo $Lastest_KitheTable['n5']; ?>"><?php echo $Lastest_KitheTable['n5']; ?></div>
  	<div class="ball_<?php echo $Lastest_KitheTable['n6']; ?>"><?php echo $Lastest_KitheTable['n6']; ?></div>
  	<div class="ball_00">+</div>
  	<div class="ball_<?php echo $Lastest_KitheTable['na']; ?>"><?php echo $Lastest_KitheTable['na']; ?></div>
  </div>
  <div class="clearfix"></div>
  <div class="mark_six" style="line-height:27px">
  	<div class="ball_50"><?php echo $Lastest_KitheTable['x1']; ?></div>
  	<div class="ball_50"><?php echo $Lastest_KitheTable['x2']; ?></div>
  	<div class="ball_50"><?php echo $Lastest_KitheTable['x3']; ?></div>
  	<div class="ball_50"><?php echo $Lastest_KitheTable['x4']; ?></div>
  	<div class="ball_50"><?php echo $Lastest_KitheTable['x5']; ?></div>
  	<div class="ball_50"><?php echo $Lastest_KitheTable['x6']; ?></div>
  	<div class="ball_00">+</div>
  	<div class="ball_50"><?php echo $Lastest_KitheTable['sx']; ?></div>
  </div>
  <div class="clearfix"></div>
  <div style="font-size:12pt;">
	  <?php if ($nodata == 1){$get_lastest = 0;?> 		  
	  <p>当前期不存在，请联系客服...</p>
	  <?php }else if((strtotime($Current_KitheTable['zfbdate'])-time()-43200<=0)||($Current_KitheTable['zfb']==0)){?>
	  <p>当前期数：第<span style="color:#f00"><?=$Current_Kithe_Num;?></span>期</p>
	  <p>开奖时间：<?=$Current_KitheTable['nd'];?></p>
	  <p>封盘时间：<?=$Current_KitheTable['zfbdate'];?></p>
	  <p><span style="color:red;">封盘中...</span>
	  <script type="text/javascript"></script>
	  <?php $get_lastest = 1;}else{$get_lastest = $Lastest_KitheTable['nn']<$Current_Kithe_Num-1; ?>
	  <p>当前期数：第<span style="color:#f00"><?=$Current_Kithe_Num;?></span>期</p>
	  <p>开奖时间：<?=$Current_KitheTable['nd'];?></p>
	  <p>封盘时间：<?=$Current_KitheTable['zfbdate'];?></p>
	  <p>距离封盘：<span id="span_dt_dt">--</span>
	  <span onclick="javascript:window.location.reload();" style="cursor:pointer;float:right;color:blue;">刷新</span>
	  </p>
	  <script type="text/javascript">
		  var BirthDay = new Date();
		  BirthDay.setSeconds(<?php echo strtotime($Current_KitheTable['zfbdate'])-time()-43200;?>);
		  function show_student163_time(){
			  today=new Date();
			  timeold=(BirthDay.getTime()-today.getTime());
			  sectimeold=timeold/1000
			  secondsold=Math.floor(sectimeold);
			  msPerDay=24*60*60*1000
			  e_daysold=timeold/msPerDay
			  daysold=Math.floor(e_daysold);
			  e_hrsold=(e_daysold-daysold)*24;
			  hrsold=Math.floor(e_hrsold);
			  e_minsold=(e_hrsold-hrsold)*60;
			  minsold=Math.floor((e_hrsold-hrsold)*60);
			  seconds=Math.floor((e_minsold-minsold)*60);
			  if(daysold<0)
			  {
				  daysold=0;
				  hrsold=0;
				  minsold=0;
				  seconds=0;
			  }
			  var s_hrsold = "0"+hrsold.toString();
			  var s_minsold = "0"+minsold.toString();
			  var s_seconds = "0"+seconds.toString();
			  s_hrsold = s_hrsold.substr(s_hrsold.length-2, 2);
			  s_minsold = s_minsold.substr(s_minsold.length-2, 2);
			  s_seconds = s_seconds.substr(s_seconds.length-2, 2);
			  if (daysold>0){
				  span_dt_dt.innerHTML=daysold+"天 "+s_hrsold+":"+s_minsold+":"+s_seconds ;
			  }else if(hrsold>0){
				  span_dt_dt.innerHTML=s_hrsold+":"+s_minsold+":"+s_seconds ;
			  }else if(minsold>0){
				  span_dt_dt.innerHTML=s_minsold+":"+s_seconds ;
			  }else{
				  span_dt_dt.innerHTML=s_seconds+"秒" ;
			  }
			  if (daysold<=0 && hrsold<=0  && minsold<=0 && seconds<=0)
				  window.location.reload();
			
			  window.setTimeout("show_student163_time()", 1000);
		  }
		  show_student163_time();
		  </script>
		  <?php }?> 	  
	</div>
  <span id="allgold" style="display:none">0</span>
</div>
<?php if($get_lastest){ ?><script type="text/javascript">
	function get_lastest(){
		$.ajax({
   			url: "ajax.php",
   			type: "GET",
   			dataType: "jsonp",
   			jsonp: "callback",
   			success: function(data){
   				$.each(data, function(key, val){
   					if(key=="nn"){
   						$(".lhc-info div:eq(0)").find("span").html(val);
   					}else if(key=="na"){
   						$(".mark_six:eq(0)").find("div:last").html(val);
   					}else if(key.substr(0, 1)=="n"){
   						$(".mark_six:eq(0)").find("div").eq(parseInt(key.substr(1, 1))-1).html(val).removeClass().addClass("ball_"+val);
   					}else if(key=="sx"){
   						$(".mark_six:eq(1)").find("div:last").html(val);
   					}else if(key.substr(0, 1)=="x"){
   						$(".mark_six:eq(1)").find("div").eq(parseInt(key.substr(1, 1))-1).html(val);
   					}
   				});
   				setTimeout("get_lastest()", 5000);
   			}
		});
	}
	get_lastest();
</script><?php } ?>