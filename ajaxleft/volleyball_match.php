<?php 
session_start();
header('Content-type: text/html;charset=utf-8');
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../class/volleyball_match.php';
include_once '../common/function.php';
include_once '../common/logintu.php';
$uid = $_SESSION['uid'];
sessionBet($uid);
islogin_match($uid);
$rows = volleyball_match::getmatch_info(intval($_POST['match_id']), $_POST['point_column']);
$touzhuxiang = $_POST['touzhuxiang'];
if(sizeof(explode('- (',$rows["match_master"]))==1){
  $touzhuxiang = str_replace('让分','让局',$touzhuxiang);
 
}
$temp_array = explode('-', $touzhuxiang);
if ($temp_array[0] == '让分'){
	$touzhuxiang = preg_replace('{[0-9\\.\\/]{1,}-}', $rows['match_rgg'] . '-', $touzhuxiang);
}

if ($temp_array[0] == '总分:大 / 小'){
  $touzhuxiang = preg_replace('{[0-9.]{1,}}', $rows['match_dxgg'], $touzhuxiang);
}



$titleName = $temp_array[0];
if ($temp_array[1] == '大 / 小' || $temp_array[2] == '大 / 小'){
  $titleName .= ' - 大 / 小';
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
<input type="hidden" name="orderkey[]" value="<?=$orderkey?>"/>
<input type="hidden" name="ball_sort[]" value="<?=$_POST["ball_sort"]?>" />
<input type="hidden" name="point_column[]" value="<?=$_POST["point_column"]?>" />
<input type="hidden" name="match_id[]" value="<?=$_POST["match_id"]?>" />
<input type="hidden" name="match_name[]" value="<?=$rows["match_name"]?>"  />
<input type="hidden" name="match_showtype[]" value="<?=$rows["match_showtype"]?>"  />
<input type="hidden" name="match_rgg[]" value="<?=$rows["match_rgg"]?>"  />
<input type="hidden" name="match_dxgg[]" value="<?=$rows["match_dxgg"]?>"  />
<input type="hidden" name="match_nowscore[]" value="<?=$rows["Match_NowScore"]?>"  />
<input type="hidden" name="match_type[]" value="<?=$rows["match_type"]?>"  />
<input type="hidden" name="touzhuxiang[]" value="<?=$temp_array[0]?>"  />
<input type="hidden" name="master_guest[]"  value="<?=$rows["match_master"]?>VS.<?=$rows["match_guest"]?>"/>
<input type="hidden" name="bet_info[]"  value="<?=$touzhuxiang?>@<?=$rows[$_POST["point_column"]]?>"/> 
<input type="hidden" name="bet_point[]" value="<?=double_format($rows[$_POST["point_column"]])?>" />
<input type="hidden" name="match_time[]"  value="<?=$rows["match_time"]?>"/>
<input type="hidden" name="ben_add[]"  value="<?=$_POST["ben_add"]?>"/>
<input type="hidden" name="match_endtime[]"  value="<?=$rows["Match_CoverDate"]?>"/>

<?
 if(intval($_POST['touzhutype'])==0){
?>
<ul class="ord_betArea_wordTop">
      <!-- 2016-12-14 足球多type所有细单改位罝显示  -->
        <li class="BlueWord">
        <?
          $ttt = "";
          $rb = "";
          $v_name = "";
          $master = $rows["match_master"];
          $guest = $rows["match_guest"];
          $tname = array("局数","分数","第一局","第二局","第三局","第四局","第五局","第六局","第七局");
          foreach($tname as $value){
            if(strpos($_POST["ball_sort"],$value)!== false || strpos($master,$value)!== false){
              $master = str_replace(' - ('.$value.')','',$master);
              $guest = str_replace(' - ('.$value.')','',$guest);
              if($value == "上半" || $value == "下半"){
                $value .= "场"; 
              }
              $ttt = " - ".$value;
              $v_name = $value;
            }
          }
          
          if(strpos($_POST["ball_sort"],"滚球")!== false){
            $rb = "(滚球)";
          }


          echo $titleName.$rb.$ttt;
        ?>
        </li>
        <li class="light_BrownWord upperWord"><?=$rows["match_name"]?></li>
        <li class="dark_BrownWord">
          <?php
          $h = "";
          $c ="";
          if($temp_array[0]=="让分"){ //让球
            if($rows["match_showtype"]=="H"){
              $h = '<tt class="RedWord fatWord">'.$rows["match_rgg"].'</tt>';
            }else{
              $c = '<tt class="RedWord fatWord">'.$rows["match_rgg"].'</tt>';
            }
           ?>  
          <?php
          }
          ?>
          <?=strip_tags($master)?><?=$h?><tt class="ord_vWordNO"> v </tt><?=strip_tags($guest)?><?=$c?><span style="display:none;" class="BlueWord">(1:0)</span>
        </li>
    </ul>
    <ul class="ord_betArea_wordBottom">
      <li class="dark_BrownWord no_margin">
       <?
        
           echo str_replace(' - ('.$v_name.')','',str_replace('U','小 ',str_replace('O','大 ',$_POST["xx"])));
         
       ?> 
       <tt style="display:none;" class="RedWord fatWord">+1</tt> @ <span id="ioradio_id" class="redFatWord"><?=double_format($rows[$_POST["point_column"]])?></span>
      </li>
    </ul>
  <div class="ord_Mask" style="display:none"></div><!--不能下注遮罩--> 
<?php
}
?>

<?php
include_once("../cache/group_".@$_SESSION["gid"].".php"); //加载权限组权限
?>
<script>
if($("#touzhutype").val() == 0){
<?php
$dz=$dz_db[$_POST["ball_sort"]][$temp_array[0]];
$dc=$dc_db[$_POST["ball_sort"]][$temp_array[0]];
if(!$dz || $dz=="") $dz=$dz_db['未定义'];
if(!$dc || $dc=="") $dc=$dc_db['未定义'];
?>
  $("#max_ds_point_span").html('<?=$dz ? $dz : '0'?>');
  $("#max_cg_point_span").html('<?=$dc ? $dc : '0'?>');
}else{
  $("#max_ds_point_span").html('<?=$dz_db['串关'] ? $dz_db['串关'] : '0'?>');
  $("#max_cg_point_span").html('<?=$dc_db['串关'] ? $dc_db['串关'] : '0'?>');
}
window.clearTimeout(time_id);
waite();
</script>