<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('jyqk');
include_once 'common.php';
$date = date('m-d');
if ($_GET['date']){
	$date = $_GET['date'];
}
$page_date = $date;
$sql = 'SELECT Match_ID, Match_Date, Match_Time, x_title, Match_Name FROM mydata4_db.t_guanjun';
isset($_GET['match_type']) ? $match_type = intval($_GET['match_type']) : $match_type = 1;
$sqlwhere = ' where match_type=1 and match_coverdate>now()';
$params = array();
if (isset($_GET['date'])){
	$params[':Match_Date'] = $page_date;
	$sqlwhere = ' where match_type=1 and match_date=:Match_Date';
}
$sql .= $sqlwhere;
$match_name = getmatch_name('t_guanjun', $sqlwhere, $params, 1);
if (isset($_GET['match_name'])){
	$params[':x_title'] = urldecode($_GET['match_name']);
	$sql .= '  and x_title=:x_title';
}
$sql .= ' order by Match_CoverDate';
$arr = array();
$arr_m = array();
$mid = '';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
while ($rows = $stmt->fetch()){
	$arr[$rows['Match_ID']]['Match_ID'] = $rows['Match_ID'];
	$arr[$rows['Match_ID']]['Match_Date'] = $rows['Match_Date'];
	$arr[$rows['Match_ID']]['Match_Time'] = $rows['Match_Time'];
	$arr[$rows['Match_ID']]['Match_Name'] = $rows['Match_Name'];
	$arr[$rows['Match_ID']]['x_title'] = $rows['x_title'];
	$arr_m[$rows['Match_ID']] = 0;
	$mid .= floatval($rows['Match_ID']) . ',';
}

if ($mid){
	$mid = rtrim($mid, ',');
	$sql = 'select match_id,bet_money,point_column from `k_bet` where match_type<2 and match_id in(' . $mid . ') and `status`!=3';
	$query = $mydata1_db->query($sql);
	while ($rows = $query->fetch()){
		if (strrpos($rows['point_column'], 'match_gj') === 0)
		{
			$arr[$rows['match_id']]['match_gj']['num'] = $arr[$rows['match_id']]['match_gj']['num'] + 1;
			$arr[$rows['match_id']]['match_gj']['money'] = $arr[$rows['match_id']]['match_gj']['money'] + $rows['bet_money'];
			$arr_m[$rows['match_id']] += $rows['bet_money'];
		}
	}
}
arsort($arr_m);
?> 
<html> 
<head> 
<title>注单审核</title> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
<link rel="stylesheet" href="../images/control_main.css" type="text/css"> 
<script language="javascript"> 
function gopage(url){ 
  location.href=url;
} 
function re_load(){ 
  location.reload();
} 
</script> 
</head> 
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" > 
<table width="576" height="0" cellpadding="0" cellspacing="0"> 
<tr style="width:150px;"> 
  <td width="119">类型： 
	<select id="select" name="table" onChange="gopage(this.value);" class="za_select">
          <option value="ft_danshi.php?match_type=<?=$match_type?>" >足球</option>
          <option value="bk_danshi.php?match_type=<?=$match_type?>">篮球</option>
          <option value="tennis_danshi.php?match_type=<?=$match_type?>">网球</option>
          <option value="volleyball_danshi.php?match_type=<?=$match_type?>">排球</option>
          <option value="baseball_danshi.php?match_type=<?=$match_type?>" >棒球</option>
          <option value="guanjun.php?match_type=<?=$match_type?>" selected>冠军</option>
          <option value="jinrong.php?match_type=<?=$match_type?>" >金融</option>
          <option value="chuanguan.php?date=<?=date("m-d")?>" >串关</option>
      </select></td>
    <td width="455">美东时间：
        <?php if($match_type==1){?>
        <select id="DropDownList1" onChange="javascript:gopage(this.value)" name="DropDownList1">
          <option value="<?=$_SERVER['PHP_SELF']?>?match_type=1">==选择时间==</option>
          <? for ($i=0;$i<=6;$i++){
	   $s=strtotime("-$i day");
	   $date=date("m-d",$s);
	    ?>
          <option value="<?=$_SERVER['PHP_SELF']?>?match_type=1&date=<?=$date?>" <?=@$page_date==$date ? "selected" : "" ?>>
            <?=$date?>
          </option>
          <?}?>
        </select>
      <?php }else if($match_type==0){?>
        <select id="DropDownList1" onChange="javascript:gopage(this.value)" name="DropDownList1">
          <option value="<?=$_SERVER['PHP_SELF']?>?match_type=0">==选择时间==</option>
          <? for ($i=1;$i<=7;$i++){
	   $s=strtotime("+$i day");
	   $date=date("m-d",$s);
	    ?>
          <option value="<?=$_SERVER['PHP_SELF']?>?match_type=0&date=<?=$date?>" <?=@$page_date==$date ? "selected" : "" ?>>
            <?=$date?>
          </option>
          <?}?>
        </select>
        <?}?>
      &nbsp;&nbsp;<a href="javascript:re_load();">刷新</a>
  </td> 
</tr> 
</table> 
<table width="745" border="0" cellpadding="0" cellspacing="1"  bgcolor="006255" class="m_tab" id="glist_table"> 
  <tr class="m_title_ft"> 
  <td width="60" height="24"><strong>时间</strong></td> 
	  <td nowrap="nowrap" width="300"><strong>联盟</strong></td> 
	  <td width="300"><strong>队伍</strong></td> 
	  <td width="80"><strong>赔率</strong></td> 
  </tr>
  <?php
foreach($arr_m as $k=>$v){
	$rows	=	$arr[$k];
	$color	=	getColor($v);
?>
    <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='<?=$color?>'">
        <td align="center"><?=$rows["Match_Date"]?><br><?=$rows["Match_Time"]?></td>
        <td><?=$rows["Match_ID"]?><br /><?=$rows["x_title"]?></td>
        <td align="left" valign="middle"><?=$rows["Match_Name"]?></td>
        <td align="right"><a href="look_ds.php?match_id=<?=$rows["Match_ID"]?>&column_like=match_gj" <?=getAC($arr[$rows["Match_ID"]]["match_gj"]['num'])?> ><?=getString($arr[$rows["Match_ID"]]["match_gj"]['num'])?>/<?=getString($arr[$rows["Match_ID"]]["match_gj"]['money'])?></a></td>
    </tr>
<? }?>
</table> 
</body> 
</html>