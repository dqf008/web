<!---下注确认---->
<script type="text/javascript">
<!-- 定义初始化，time_id和waite()手机端不会用到
var time_id;
function waite(){};
//-->
</script>
<link href="/m/sports/style/in-play.css" rel="stylesheet" type="text/css">
<link href="/m/sports/style/body_tw.css" rel="stylesheet" type="text/css">
<div id="div_bet" style="animation-name: Alpha;display:none;" class="modal">
  <div id="div_bet_order" style="animation-name: Zoom;" class="betslip">
	  <div class="betslip_header">
		  <div id="order_close" name="order_close" class="ord_close" onclick="javascript:colse_betorder();"> </div>
		  <div class="ord_head">
			  <div class="ord_title">交易单</div>
			  <div class="ord_credit">目前余额: <span id="order_credit" name="order_credit"><?=$userinfo['money'];?></span></div>
		  </div>
		  <div id="order_reload_btn" name="order_reload_btn" class="ord_refresh">
			  <div id="order_reload_sec" name="order_reload_sec" class="ord_sec">21</div>
		  </div>
	  </div>
	  <div class="ord_main" id="touzhudiv">
<?php 
for ($i = 0;$i < count($cg_for_message);$i++){
$temp_team = explode('VS.', $cg_for_message[$i]['master_guest']);
$temp_bet_info = explode('-', $cg_for_message[$i]['bet_info']);
$temp_bet_info2 = explode('@', $temp_bet_info[1]);
?>
	<div class="match_msg"> 
		<input type="hidden" name="orderkey[]" value="<?=$cg_for_message[$i]['orderkey'] ;?>"> 
		<input type="hidden" name="ball_sort[]" value="<?=$cg_for_message[$i]['ball_sort'] ;?>"> 
		<input type="hidden" name="point_column[]" value="<?=$cg_for_message[$i]['point_column'] ;?>"> 
		<input type="hidden" name="match_id[]" value="<?=$cg_for_message[$i]['match_id'] ;?>"> 
		<input type="hidden" name="match_name[]" value="<?=$cg_for_message[$i]['match_name'] ;?>"> 
		<input type="hidden" name="match_showtype[]" value="<?=$cg_for_message[$i]['match_showtype'] ;?>"> 
		<input type="hidden" name="match_rgg[]" value="<?=$cg_for_message[$i]['match_rgg'] ;?>"> 
		<input type="hidden" name="match_dxgg[]" value="<?=$cg_for_message[$i]['match_dxgg'] ;?>"> 
		<input type="hidden" name="match_nowscore[]" value="<?=$cg_for_message[$i]['match_nowscore'] ;?>"> 
		<input type="hidden" name="match_type[]" value="<?=$cg_for_message[$i]['match_type'] ;?>"> 
		<input type="hidden" name="touzhuxiang[]" value="<?=$cg_for_message[$i]['touzhuxiang'] ;?>"> 
		<input type="hidden" name="master_guest[]" value="<?=$cg_for_message[$i]['master_guest'] ;?>"> 
		<input type="hidden" name="bet_info[]" value="<?=$cg_for_message[$i]['bet_info'] ;?>">  
		<input type="hidden" name="bet_point[]" value="<?=$cg_for_message[$i]['bet_point'] ;?>">  
		<input type="hidden" name="ben_add[]" value="<?=$cg_for_message[$i]['ben_add'] ;?>"> 
		<input type="hidden" name="match_time[]" value="<?=$cg_for_message[$i]['match_time'] ;?>"> 
		<input type="hidden" name="match_endtime[]" value="<?=$cg_for_message[$i]['match_endtime'] ;?>"> 
		<input type="hidden" name="Match_HRedCard[]" value="<?=$cg_for_message[$i]['Match_HRedCard'] ;?>"> 
		<input type="hidden" name="Match_GRedCard[]" value="<?=$cg_for_message[$i]['Match_GRedCard'] ;?>"> 
		<input type="hidden" name="is_lose" value="<?=$cg_for_message[$i]['is_lose'] ;?>"> 
		<div class="match_sort"><?=$cg_for_message[$i]['ball_sort'] ;?></div> 
		<div class="match_info">
			<?=$temp_team[0];?>
			<span class="match_vs"> VS. </span><span class="match_guest"><?=$temp_team[1] ;?></span><br> 
			<span class="match_master1"><?=$temp_bet_info2[0] ;?></span>&nbsp;@&nbsp;
			<span style="color:#D90000;"><?=$cg_for_message[$i]['bet_point'] ;?></span>&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="images/x.gif" alt="取消赛事" width="8" height="8" border="0" onclick="javascript:del_bet(this)" style="cursor:pointer;"> 
		</div> 
	</div>
<?php }?> 		  
</div>
<div class="bet_data">
	<div>
	  <div class="bet_inp">
		  <input type="number" pattern="[0-9]*" placeholder="投注额" name="bet_money" id="bet_money" onkeyup="may_win();">
	  </div>
	  <div class="ord_payout">可赢金额:<br>
		  <div id="win_span" name="win_span" class="ord_win_gold">0</div>
	  </div>
   </div>
   <div class="ord_limit">
	  最低限额: <span id="min_ty"><?=$ty_zd ? $ty_zd : 0;?></span> <br>
	  单注限额: <span id="max_ds_point_span"><?=$dz_db['串关'] ? $dz_db['串关'] : 0;?></span> <br>
	  单场最高: <span id="max_cg_point_span"><?=$dc_db['串关'] ? $dc_db['串关'] : 0;?></span>
   </div>
   <div class="betterOdds">
	  <label style="display: block;color: rgb(255, 0, 0);text-shadow: none;">自动接受最新赔率 </label>
	  <label>
		  <span id="istz" style="display: none;color: rgb(255, 0, 0);text-shadow: none;">
			  是否确定交易？
		  </span>
	  </label>
   </div>
</div>
 <div id="order_bet" name="order_bet" class="placebet_but" onclick="javascript:check_bet();">确定交易</div>
</div>
</div>