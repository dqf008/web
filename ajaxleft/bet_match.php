<?php 
session_start();
header('Content-type: text/html;charset=utf-8');
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../class/bet_match.php';
include_once '../common/function.php';
include_once '../common/logintu.php';

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



$ttt = "";
$rb = "";
$v_name = "";
$master = $rows["match_master"];
$guest = $rows["match_guest"];
$tname = array("上半","下半","上半场","下半场","第1节","第2节","第3节","第4节","第一盘","第二盘","第三盘","第四盘","第五盘","让局","第一局","第二局","第三局","第四局","第五局","第六局","第七局");
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

$titleName = $rb.$touzhuxiang.$ttt;

 if(intval($_POST['touzhutype'])==1){
?>
<div class="ord_betAreaP" id="TR1">
  <span class="ord_betCloseBTN" name="delteam1" value="" onclick="javascript:del_bet(this)"></span>
  <input type="hidden" name="m_g[]"  value="<?=strip_tags($rows["match_master"])?>vs<?=strip_tags($rows["match_guest"])?>"/>
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
  <input type="hidden" name="master_guest[]"  value="<?=strip_tags($rows["match_master"])?>VS.<?=strip_tags($rows["match_guest"])?>"/>
  <input type="hidden" name="bet_info[]"  value="<?=$tzx?><? if($_POST["is_lose"]==1) echo "(".$rows['Match_NowScore'].")"; ?>@<?=double_format($rows[$_POST["point_column"]])?>"/> 
  <input type="hidden" name="bet_point[]" value="<?=double_format($rows[$_POST["point_column"]])?>" /> 
  <input type="hidden" name="ben_add[]"  value="<?=$_POST["ben_add"]?>"/>
  <input type="hidden" name="match_time[]" value="<?=$rows["match_time"]?>"  />
  <input type="hidden" name="match_endtime[]"  value="<?=$rows["Match_CoverDate"]?>"/>
  <input type="hidden" name="Match_HRedCard[]"  value="<?=$rows["Match_HRedCard"]?>"/>
  <input type="hidden" name="Match_GRedCard[]"  value="<?=$rows["Match_GRedCard"]?>"/>
  <input type="hidden" name="is_lose"  value="<?=$_POST["is_lose"]?>"/>       
  <ul class="ord_betArea_wordTop">
    <li class="BlueWordS">
      <div class="ord_remind"><span id="order_time1" class="ord_remind_txt">赛事时间: <?=date('m-d H:i:s',strtotime($rows["Match_CoverDate"]))?></span></div><?=$titleName?></li>
      <li class="light_BrownWord upperWord"><?=$rows["match_name"]?></li>
      <li class="dark_BrownWord">
        <?php
          $h = "";
          $c ="";
          if($temp_array[0]=="让球" || $temp_array[0]=="上半场让球"){ //让球
            if($rows["match_showtype"]=="H"){
              $h = '<tt class="RedWord fatWord">'.$rows["match_rgg"].'</tt>';
            }else{
              $c = '<tt class="RedWord fatWord">'.$rows["match_rgg"].'</tt>';
            }
           ?>  
          <?php
          }
          ?>
          <?=strip_tags($master)?><?=$h?><tt class="ord_vWordNO"> v </tt><?=strip_tags($guest)?><?=$c?>
          <? if($rb != ""){?> <span  class="BlueWord">(<?=$rows["Match_NowScore"]?>)</span><?}?>
      </li>
  </ul>
  <ul class="ord_betArea_wordBottom">
    <li class="dark_BrownWord no_margin">
      <?
        if($temp_array[0]=="波胆" || $temp_array[0]=="上半波胆"){ //波胆
          if(strpos($temp_array[1],'UP') !== false){
              echo "其他比分";
          }else{
              echo str_replace(':',' - ',$temp_array[1]);
          }
        }elseif($temp_array[0]=="半全场"){
          echo str_replace('客',$guest,str_replace('主',$master,$temp_array[1]));
        }else{
          if($temp_array[0]=="入球数" || $temp_array[0]=="上半入球数"){
            echo str_replace('UP','或以上',$_POST["xx"]);
          }else{
            
            echo str_replace(' - ('.$v_name.')','',str_replace('U','小 ',str_replace('O','大 ',$_POST["xx"])));
          }
        }
       
       ?> 
       <tt style="display:none;" class="RedWord fatWord">+1</tt> @ <span id="ioradio_id" class="redFatWord"><?=double_format($rows[$_POST["point_column"]])?></span>
    </li>
  </ul>
  <div id="TR1_Mask" class="ord_Mask" style="display:none;"><span class="ord_betCloseBTN" name="delteam1" value="" onclick="javascript:del_bet(this);"></span></div><!--不能下注遮罩-->
</div>
<?
 }else{
?>
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
<input type="hidden" name="master_guest[]"  value="<?=strip_tags($rows["match_master"])?>VS.<?=strip_tags($rows["match_guest"])?>"/>
<input type="hidden" name="bet_info[]"  value="<?=$tzx?><? if($_POST["is_lose"]==1) echo "(".$rows['Match_NowScore'].")"; ?>@<?=double_format($rows[$_POST["point_column"]])?>"/> 
<input type="hidden" name="bet_point[]" value="<?=double_format($rows[$_POST["point_column"]])?>" /> 
<input type="hidden" name="ben_add[]"  value="<?=$_POST["ben_add"]?>"/>
<input type="hidden" name="match_time[]" value="<?=$rows["match_time"]?>"  />
<input type="hidden" name="match_endtime[]"  value="<?=$rows["Match_CoverDate"]?>"/>
<input type="hidden" name="Match_HRedCard[]"  value="<?=$rows["Match_HRedCard"]?>"/>
<input type="hidden" name="Match_GRedCard[]"  value="<?=$rows["Match_GRedCard"]?>"/>
<input type="hidden" name="is_lose"  value="<?=$_POST["is_lose"]?>"/>
<ul class="ord_betArea_wordTop">
      <!-- 2016-12-14 足球多type所有细单改位罝显示  -->
        <li class="BlueWord"><?=$titleName?></li>
        <li class="light_BrownWord upperWord"><?=$rows["match_name"]?></li>
        <li class="dark_BrownWord">
          <?php
          $h = "";
          $c ="";
          if($temp_array[0]=="让球" || $temp_array[0]=="上半场让球"){ //让球
            if($rows["match_showtype"]=="H"){
              $h = '<tt class="RedWord fatWord">'.$rows["match_rgg"].'</tt>';
            }else{
              $c = '<tt class="RedWord fatWord">'.$rows["match_rgg"].'</tt>';
            }
           ?>  
          <?php
          }
          ?>
          <?=strip_tags($master)?><?=$h?><tt class="ord_vWordNO"> v </tt><?=strip_tags($guest)?><?=$c?>
          <? if($rb != ""){?> <span  class="BlueWord">(<?=$rows["Match_NowScore"]?>)</span><?}?>
        </li>
    </ul>
    <ul class="ord_betArea_wordBottom">
      <li class="dark_BrownWord no_margin">
       <?
        if($temp_array[0]=="波胆" || $temp_array[0]=="上半波胆"){ //波胆
          if(strpos($temp_array[1],'UP') !== false){
              echo "其他比分";
          }else{
              echo str_replace(':',' - ',$temp_array[1]);
          }
        }elseif($temp_array[0]=="半全场"){
          echo str_replace('客',$guest,str_replace('主',$master,$temp_array[1]));
        }else{
          if($temp_array[0]=="入球数" || $temp_array[0]=="上半入球数"){
            echo str_replace('UP','或以上',$_POST["xx"]);
          }else{
            
            echo str_replace(' - ('.$v_name.')','',str_replace('U','小 ',str_replace('O','大 ',$_POST["xx"])));
          }
        }
       
       ?> 
       <tt style="display:none;" class="RedWord fatWord">+1</tt> @ <span id="ioradio_id" class="redFatWord"><?=double_format($rows[$_POST["point_column"]])?></span>
      </li>
    </ul>
  <div class="ord_Mask" style="display:none"></div><!--不能下注遮罩-->

<?
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
  $("#max_ds_point_span").html('<?=$dz ? number_format($dz) : '0'?>');
  $("#max_cg_point_span").html('<?=$dc ? number_format($dc) : '0'?>');
}else{
  $("#max_ds_point_span").html('<?=$dz_db['串关'] ? number_format($dz_db['串关']) : '0'?>');
  $("#max_cg_point_span").html('<?=$dc_db['串关'] ? number_format($dc_db['串关']) : '0'?>');
}
window.clearTimeout(time_id);
waite();
</script>