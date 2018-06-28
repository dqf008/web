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
$sql = 'SELECT Match_ID, Match_Date, Match_Time, Match_Master, Match_Guest,Match_MasterID, Match_GuestID,Match_Name FROM mydata4_db.Bet_Match';
isset($_GET['match_type']) ? $match_type = intval($_GET['match_type']) : $match_type = 1;
$params = array();
if ($match_type == 1){
	$params[':Match_Date'] = date('m-d');
	$sqlwhere = ' WHERE  Match_Date=:Match_Date and Match_CoverDate>now() and Match_BqMM>0';
}else if ($match_type == 0){
	$params[':Match_Date'] = date('m-d');
	$sqlwhere = ' WHERE  Match_Date<>:Match_Date and Match_CoverDate>now() and Match_BqMM>0 ';
	if (isset($_GET['date'])){
		$params[':Match_Date'] = $page_date;
		$sqlwhere = ' WHERE  Match_Date=:Match_Date and Match_CoverDate>now() and Match_BqMM>0 ';
	}
}
$sql .= $sqlwhere;
$match_name = getmatch_name('bet_match', $sqlwhere, $params);
if (isset($_GET['match_name'])){
	$params[':match_name'] = urldecode($_GET['match_name']);
	$sql .= '  and match_name=:match_name';
}
$sql .= ' order by Match_CoverDate,ipage,isn';
$arr = array();
$arr_m = array();
$mid = '';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
while ($rows = $stmt->fetch()){
	$arr[$rows['Match_ID']]['Match_ID'] = $rows['Match_ID'];
	$arr[$rows['Match_ID']]['Match_Date'] = $rows['Match_Date'];
	$arr[$rows['Match_ID']]['Match_Time'] = $rows['Match_Time'];
	$arr[$rows['Match_ID']]['Match_Master'] = $rows['Match_Master'];
	$arr[$rows['Match_ID']]['Match_Guest'] = $rows['Match_Guest'];
	$arr[$rows['Match_ID']]['Match_Name'] = $rows['Match_Name'];
	$arr[$rows['Match_ID']]['Match_MasterID'] = $rows['Match_MasterID'];
	$arr[$rows['Match_ID']]['Match_GuestID'] = $rows['Match_GuestID'];
	$arr_m[$rows['Match_ID']] = 0;
	$mid .= floatval($rows['Match_ID']) . ',';
}

if ($mid){
	$mid = rtrim($mid, ',');
	$sql = 'select match_id,point_column,bet_money from `k_bet` where match_type<2 and match_id in(' . $mid . ') and `status`!=3';
	$query = $mydata1_db->query($sql);
	while ($rows = $query->fetch()){
		if (strrpos($rows['point_column'], 'match_bq') === 0){
			$arr[$rows['match_id']]['match_bq']['num'] = $arr[$rows['match_id']]['match_bq']['num'] + 1;
			$arr[$rows['match_id']]['match_bq']['money'] = $arr[$rows['match_id']]['match_bq']['money'] + $rows['bet_money'];
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
<table width="1048" height="0" cellpadding="0" cellspacing="0"> 
  <tr style="width:150px;"> 
	<td width="119">类型：
	<select id="select" name="table" onChange="gopage(this.value);" class="za_select">    <option value="<?=$_SERVER['PHP_SELF']?>?match_type=<?=$match_type?>"  >足球</option>
        <option value="bk_danshi.php?match_type=<?=$match_type?>">篮球</option>
		<option value="tennis_danshi.php?match_type=<?=$match_type?>">网球</option>
		<option value="volleyball_danshi.php?match_type=<?=$match_type?>">排球</option>
		<option value="baseball_danshi.php?match_type=<?=$match_type?>">棒球</option>
		<option value="guanjun.php?match_type=<?=$match_type?>" >冠军</option>
		<option value="jinrong.php?match_type=<?=$match_type?>" >金融</option>
		<option value="chuanguan.php?date=<?=date("m-d")?>" >串关</option>
      </select></td>
		<td width="230">美东时间：<?php if($match_type==1){?>
	      <select id="DropDownList1" onChange="javascript:gopage(this.value)" name="DropDownList1">
			<option value="<?=$_SERVER['PHP_SELF']?>?match_type=1">==选择时间==</option>
		  <? for ($i=0;$i<=6;$i++){
		   $s=strtotime("-$i day");
		   $date=date("m-d",$s);
			?>
			<option value="<?=$_SERVER['PHP_SELF']?>?match_type=1&date=<?=$date?>" <?=@$page_date==$date ? "selected" : "" ?>><?=$date?></option>
	  <? }?>
		  </select><?php }else if($match_type==0){?>
	
	     <select id="DropDownList1" onChange="javascript:gopage(this.value)" name="DropDownList1">
	    <option value="<?=$_SERVER['PHP_SELF']?>?match_type=0">==选择时间==</option>
      <? for ($i=1;$i<=7;$i++){
	   $s=strtotime("+$i day");
	   $date=date("m-d",$s);
	    ?>
        <option value="<?=$_SERVER['PHP_SELF']?>?match_type=0&date=<?=$date?>" <?=@$page_date==$date ? "selected" : "" ?>><?=$date?></option>
  <? }?>
      </select>
	<? }?>&nbsp;&nbsp;<a href="javascript:re_load();">刷新</a></td>
		<td width="262" align="left">&nbsp;&nbsp;选择联盟&nbsp;
     <select id="set_account" name="match_name" onChange="gopage(this.value);" class="za_select">
     <option value="<?=$_SERVER['PHP_SELF']?>?match_type=<?=$match_type?>&amp;date=<?=$page_date?>">==选择联盟==</option>
	 <?php
	 foreach ($match_name as $k=>$v){?>
  	    <option <? if(urldecode(@$_GET["match_name"])==$v){?> selected="selected" <? }?> value="<?=$_SERVER['PHP_SELF']?>?match_name=<?=urlencode(@$v)?>&amp;match_type=<?=$match_type?>&amp;date=<?=$page_date?>"><?=$v?></option>
  	   <?php }?>
     </select>
	 </td> 
	  <td width="435">
	  <a href="ft_danshi.php?match_type=<?=$match_type;?>">单式</a>&nbsp;&nbsp;
	  <?php if ($match_type == 1){?><a href="ft_gunqiu.php">滚球</a> <?php }?> &nbsp;&nbsp;
	  <a  href="ft_shangbanchang.php?match_type=<?=$match_type;?>">上半场</a>&nbsp;&nbsp;
	  <a href="ft_shangbanbodan.php?match_type=<?=$match_type;?>">上半波胆</a>&nbsp;&nbsp;
	  <span id="pg_txt">
		  <a href="ft_bodan.php?match_type=<?=$match_type;?>">波胆</a>&nbsp;&nbsp;
		  <a href="ft_ruqiushu.php?match_type=<?=$match_type;?>">入球数</a>&nbsp;&nbsp;
		  <a href="ft_banquanchang.php?match_type=<?=$match_type;?>">半全场</a>
		  <?php if ($match_type == 1){?> &nbsp;&nbsp;<a  href="ft_yks.php">已开赛</a><?php }?> 
	  </span> 
	</td> 
  </tr> 
</table> 
<table width="526" border="0" cellpadding="0" cellspacing="1"  bgcolor="006255" class="m_tab" id="glist_table"> 
  <tr class="m_title_ft"> 
  <td width="60" height="24"><strong>时间</strong></td> 
	  <td nowrap="nowrap" width="160"><strong>联盟</strong></td> 
	  <td width="60"><strong>场次</strong></td> 
	  <td width="160"><strong>队伍</strong></td> 
	  <td width="80"><strong>半全场</strong></td> 
  </tr>
  <?php
foreach($arr_m as $k=>$v){
	$rows	=	$arr[$k];
	$color	=	getColor($v);
?>
    <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='<?=$color?>'">
        <td align="center"><?=$rows["Match_Date"]?><br><?=$rows["Match_Time"]?><br><? if(@$rows["Match_IsLose"]==1){?>  <span style="color:#FF0000">滚球</span><? } ?></td>
        <td><?=$rows["Match_ID"]?><br /><?=$rows["Match_Name"]?></td>
        <td><?=$rows["Match_MasterID"]?><br><?=$rows["Match_GuestID"]?></td>
        <td align="left"><?=$rows["Match_Master"]?><br><?=$rows["Match_Guest"]?></td>
        <td align="right"><a href="look_ds.php?match_id=<?=$rows["Match_ID"]?>&column_like=Match_Bq" <?=getAC($arr[$rows["Match_ID"]]["match_bq"]['num'])?> ><?=getString($arr[$rows["Match_ID"]]["match_bq"]['num'])?>/<?=getString($arr[$rows["Match_ID"]]["match_bq"]['money'])?></a></td>
    </tr>
<? }?>
</table> 
</body> 
</html>