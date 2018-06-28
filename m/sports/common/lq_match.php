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
include_once '../class/lq_match.php';
$uid = $_SESSION['uid'];
sessionBet($uid);
islogin_match($uid);
$rows = lq_match::getmatch_info(intval($_POST['match_id']), $_POST['point_column'], $_POST['ball_sort']);
$touzhuxiang = $_POST['touzhuxiang'];
if ($rows['match_type'] == 2){
	$is_lose = 1;
}else{
	$is_lose = 0;
}

$temp_array = explode('-', $touzhuxiang);
if ($temp_array[0] == '让球'){
	$touzhuxiang = preg_replace('{[0-9\\.\\/]{1,}-}', $rows['match_rgg'] . '-', $touzhuxiang);
}

if ($temp_array[0] == '大小'){
	$touzhuxiang = preg_replace('{[0-9.]{1,}}', $rows['match_dxgg'], $touzhuxiang);
}
include_once 'postkey.php';
$ball_sort = $_POST['ball_sort'];
$column = $_POST['point_column'];
$match_name = $rows['match_name'];
$master_guest = $rows['match_master'] . 'VS.' . $rows['match_guest'];
$match_id = $_POST['match_id'];
$tid = $_POST['tid'];
$bet_info = $touzhuxiang . '@' . $rows[$_POST['point_column']];
$touzhuxiang1 = $temp_array[0];
$match_showtype = $rows['match_showtype'];
$match_rgg = $rows['match_rgg'];
$match_dxgg = $rows['match_dxgg'];
$match_nowscore = $rows['Match_NowScore'];
$bet_point = double_format($rows[$_POST['point_column']]);
$match_type = $rows['match_type'];
$ben_add = $_POST['ben_add'];
$match_time = $rows['match_time'];
$match_endtime = $rows['Match_CoverDate'];
$Match_HRedCard = '';
$Match_GRedCard = '';
$orderinfo = $ball_sort . $column . $match_name . $master_guest . $match_id . $tid . $bet_info . $touzhuxiang1;
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
<input type="hidden" name="master_guest[]"  value="<?=$rows['match_master'];?>VS.<?=$rows['match_guest'];?>"/> 
<input type="hidden" name="bet_info[]"  value="<?=$touzhuxiang;?>@<?=$rows[$_POST['point_column']];?>"/>  
<input type="hidden" name="bet_point[]" value="<?=double_format($rows[$_POST['point_column']]);?>" /> 
<input type="hidden" name="match_time[]"  value="<?=$rows['match_time'];?>"/> 
<input type="hidden" name="ben_add[]"  value="<?=$_POST['ben_add'];?>"/> 
<input type="hidden" name="match_endtime[]"  value="<?=$rows['Match_CoverDate'];?>"/> 
<input type="hidden" name="is_lose"  value="<?=$is_lose;?>"/> 
<div class="match_sort"><?=$_POST['ball_sort'];?></div>
<?php 
if (intval($_POST['touzhutype']) == 0){
echo '<div class="match_name">';
echo $rows['match_name'];
echo '&nbsp;';
echo 0 < $rows['match_type'] ? $rows['match_time'] : $rows['match_date'];
echo '</div>';
}
echo '<div class="match_master">';
echo $rows['match_master'];
echo '<span class="match_vs"> VS. </span><span class="match_guest">';
echo $rows['match_guest'];
echo '</span></div>';


if ($temp_array[0] == '让球'){
echo '<div class="match_info">盘口：';
echo $rows['match_showtype'] == 'H' ? '主让' : '客让';
echo '(';
echo $rows['match_rgg'];
echo ')</div>';
}
?> 
  <div class="match_info"> 
  <span class="match_master1"><?=$_POST['xx'];?></span>&nbsp;@&nbsp;
  <span style="color:#D90000;"><?=double_format($rows[$_POST['point_column']]);?></span>&nbsp;&nbsp;&nbsp;&nbsp;
  <img src="../images/x.gif" alt="取消赛事" width="8" height="8" border="0" onclick="javascript:del_bet(this)" style="cursor:pointer;" /> 
  </div> 
</div>
<?php include_once '../../../cache/group_' . @($_SESSION['gid']) . '.php';?>
<script> 
if($("#touzhutype").val() == 0){
<?php 
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
$("#min_ty").html('<?=$ty_zd;?>');
  $("#max_ds_point_span").html('<?=$dz ? $dz : 0;?>');
  $("#max_cg_point_span").html('<?=$dc ? $dc : 0;?>');
}else{ 
  $("#max_ds_point_span").html('<?=$dz_db['串关'] ? $dz_db['串关'] : 0;?>');
  $("#max_cg_point_span").html('<?=$dc_db['串关'] ? $dc_db['串关'] : 0;?>');
} 
// window.clearTimeout(time_id);
// waite();
</script>