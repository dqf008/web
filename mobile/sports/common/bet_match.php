<?php 
$C_Patch = $_SERVER['DOCUMENT_ROOT'];
session_start();
header('Content-type: text/html;charset=utf-8');
include_once '../../../include/config.php';
website_close();
website_deny();
include_once '../../../database/mysql.config.php';
include_once '../../../common/login_check.php';
include_once '../../../common/function.php';
include_once '../../../common/logintu.php';
include_once '../class/bet_match.php';
$uid = $_SESSION['uid'];
sessionBet($uid);
islogin_match($uid);
$rows = bet_match::getmatch_info(intval($_POST['match_id']), $_POST['point_column'], $_POST['ball_sort']);

$touzhuxiang = $_POST['touzhuxiang'];
if ($rows['match_type'] == 2){
	$is_lose = 1;
}else{
	$is_lose = 0;
}



$temp_array = explode('-', $touzhuxiang);
if (($temp_array[0] == '让球') || ($temp_array[0] == '上半场让球')){
	$touzhuxiang = $temp_array[0] . '-' . preg_replace('{[0-9.\\/]{1,}}', $rows['match_rgg'], $temp_array[1]) . '-' . $temp_array[2];
}

if (($temp_array[0] == '大小') || ($temp_array[0] == '上半场大小')){
	$uo = (($_POST['point_column'] == 'Match_Bdpl') || ($_POST['point_column'] == 'Match_DxDpl') || ($_POST['point_column'] == 'Match_BHo') ? 'O' : 'U');
	$touzhuxiang = preg_replace('{[U0-9O.\\/]{2,}}', $uo . $rows['match_dxgg'], $touzhuxiang);
}

$tzx = $touzhuxiang;
$temp_array = explode('-', $touzhuxiang);
if (2 < count($temp_array)){
	$touzhuxiang = $temp_array[0] . $temp_array[1] . '</p><p style="text-align:center">' . $temp_array[2];
}

include_once 'postkey.php';
$ball_sort = $_POST['ball_sort'];
$column = $_POST['point_column'];
$match_name = $rows['match_name'];
$master_guest = strip_tags($rows['match_master']) . 'VS.' . strip_tags($rows['match_guest']);
$match_id = $_POST['match_id'];
$tid = $_POST['tid'];
if ($_POST['is_lose'] == 1){
	$bet_info = $tzx . '(' . $rows['Match_NowScore'] . ')@' . double_format($rows[$_POST['point_column']]);
}else{
	$bet_info = $tzx . '@' . double_format($rows[$_POST['point_column']]);
}
$touzhuxiang = $temp_array[0];
$match_showtype = $rows['match_showtype'];
$match_rgg = $rows['match_rgg'];
$match_dxgg = $rows['match_dxgg'];
$match_nowscore = $rows['Match_NowScore'];
$bet_point = double_format($rows[$_POST['point_column']]);
$match_type = $rows['match_type'];
$ben_add = $_POST['ben_add'];
$match_time = $rows['match_time'];
$match_endtime = $rows['Match_CoverDate'];
$Match_HRedCard = $rows['Match_HRedCard'];
$Match_GRedCard = $rows['Match_GRedCard'];
$orderinfo = $ball_sort . $column . $match_name . $master_guest . $match_id . $tid . $bet_info . $touzhuxiang;
$orderinfo .= $match_showtype . $match_rgg . $match_dxgg . $match_nowscore . $bet_point . $match_type;
$orderinfo .= $ben_add . $match_time . $match_endtime . $Match_HRedCard . $Match_GRedCard . $is_lose;
$orderkey = StrToHex($orderinfo, $postkey);
?>
<div class="match_msg"> 
  <input type="hidden" name="orderkey[]" value="<?=$orderkey;?>"/> 
  <input type="hidden" name="ball_sort[]" value="<?=$_POST['ball_sort'];?>" /> 
  <input type="hidden" name="point_column[]" value="<?=$_POST['point_column'];?>" /> 
  <input type="hidden" name="match_id[]" value="<?=$_POST['match_id'];?>" /> 
  <input type="hidden" name="match_name[]" value="<?=$rows['match_name'];?>"  /> 
  <input type="hidden" name="match_showtype[]" value="<?=$rows['match_showtype'];?>"  /> 
  <input type="hidden" name="match_rgg[]" value="<?=$rows['match_rgg'];?>"  /> 
  <input type="hidden" name="match_dxgg[]" value="<?=$rows['match_dxgg'];?>"  /> 
  <input type="hidden" name="match_nowscore[]" value="<?=$rows['Match_NowScore'];?>"  /> 
  <input type="hidden" name="match_type[]" value="<?=$rows['match_type'];?>"  /> 
  <input type="hidden" name="touzhuxiang[]" value="<?=$temp_array[0];?>"  /> 
  <input type="hidden" name="master_guest[]"  value="<?=strip_tags($rows['match_master']);?>VS.<?=strip_tags($rows['match_guest']);?>"/> 
  <input type="hidden" name="bet_info[]"  value="<?=$tzx;?><? if ($_POST['is_lose'] == 1){ echo '('.$rows['Match_NowScore'].')';} echo '@'.double_format($rows[$_POST['point_column']]);?>"/>  
  <input type="hidden" name="bet_point[]" value="<?=double_format($rows[$_POST['point_column']]);?>" />  
  <input type="hidden" name="ben_add[]"  value="<?=$_POST['ben_add'];?>"/> 
  <input type="hidden" name="match_time[]" value="<?=$rows['match_time'];?>"  /> 
  <input type="hidden" name="match_endtime[]"  value="<?=$rows['Match_CoverDate'];?>"/> 
  <input type="hidden" name="Match_HRedCard[]"  value="<?=$rows['Match_HRedCard'];?>"/> 
  <input type="hidden" name="Match_GRedCard[]"  value="<?=$rows['Match_GRedCard'];?>"/> 
  <input type="hidden" name="is_lose"  value="<?=$_POST['is_lose'];?>"/>
  <?php 
  if (intval($_POST['touzhutype']) == 1){ 
  		echo '<div class="match_sort">'.$_POST['ball_sort'].'</div>';
		echo '<div class="match_info">'.strip_tags($rows['match_master']).'<span class="match_vs"> VS. </span><span class="match_guest">'.strip_tags($rows['match_guest']).'</span><br />';
		echo '<span class="match_master1">'.$_POST['xx'].'</span>&nbsp;@&nbsp;';
	  	echo '<span style="color:#D90000;">'.double_format($rows[$_POST['point_column']]).'</span>&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<img src="images/x.gif" alt="取消赛事" width="8" height="8" border="0" onclick="javascript:del_bet(this)" style="cursor:pointer;" />'; 
		echo '</div>';
  }else{
  		echo '<div class="match_sort">'.$_POST['ball_sort'].'</div>';
		echo '<div class="match_name">'.$rows['match_name'].'&nbsp;'.$rows['match_type']>0 ? $rows['match_time'] : $rows['match_date'].'</div>';
		echo '<div class="match_master">'.strip_tags($rows['match_master']).'<span class="match_vs"> VS. </span><span class="match_guest">'.strip_tags($rows['match_guest']).'</span></div>';
		
		if (($temp_array[0] == '让球') || ($temp_array[0] == '上半场让球')){
			echo '<div class="match_info">盘口：'.$rows['match_showtype'] == 'H' ? '主让' : '客让'.'('.$rows['match_rgg'].')</div>';
	    }else if ((($temp_array[0] == '波胆') || ($temp_array[0] == '上半波胆')) && ($_POST['xx'] != $temp_array[1])){
			echo '<div class="match_info">盘口：'.$temp_array[1].'</div>';
		}
  ?> 
  	  <div class="match_info"> 
	  <span class="match_master1"><?=$_POST['xx'];?></span>&nbsp;@&nbsp;
	  <span style="color:#D90000;"><?=double_format($rows[$_POST['point_column']]);?></span>&nbsp;&nbsp;&nbsp;&nbsp;
	  <img src="images/x.gif" alt="取消赛事" width="8" height="8" border="0" onclick="javascript:del_bet(this)" style="cursor:pointer;" /> 
	  </div> 
  </div>
<?php 
  }
  
include_once '../../../cache/group_' . @($_SESSION['gid']) . '.php';
$dz = $dz_db[$_POST['ball_sort']][$temp_array[0]];
$dc = $dc_db[$_POST['ball_sort']][$temp_array[0]];
if (!$dz || ($dz == '')){
	$dz = $dz_db['未定义'];
}

if (!$dc || ($dc == '')){
	$dc = $dc_db['未定义'];
}
$ty_zd = @($pk_db['体育最低']);
if (0 < $ty_zd){
	$ty_zd = $ty_zd;
}else{
	$ty_zd = 10;
}
?> 
<script> 
  $("#min_ty").html('<?=$ty_zd;?>');
  if($("#touzhutype").val() == 0){ 
	  $("#max_ds_point_span").html('<?=$dz ? $dz : '0';?>');
	  $("#max_cg_point_span").html('<?=$dc ? $dc : '0';?>');
  }else{ 
	  $("#max_ds_point_span").html('<?=$dz_db['串关'] ? $dz_db['串关'] : '0' ;?>');
	  $("#max_cg_point_span").html('<?=$dc_db['串关'] ? $dc_db['串关'] : '0' ;?>');
  } 
  //window.clearTimeout(time_id);
  //waite();
  </script>