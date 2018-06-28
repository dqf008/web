<?php include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('jyqk');
include_once 'common.php';
$date = date('m-d');
if ($_GET['date'])
{
	$date = $_GET['date'];
}
$page_date = $date;
$sql = 'SELECT Match_ID, Match_Date, Match_Time, Match_Master, Match_Guest, Match_Name, Match_IsLose, Match_MasterID, Match_GuestID, Match_Hr_ShowType, Match_Bmdy, Match_Bgdy, Match_Bhdy, Match_Bdpl, Match_Bxpl, Match_BRpk, Match_Bdxpk, Match_BHo, Match_BAo' . "\r\n" . 'FROM mydata4_db.Bet_Match';
isset($_GET['match_type']) ? $match_type = intval($_GET['match_type']) : $match_type = 1;
$params = array();
if ($match_type == 1)
{
	$params[':Match_Date'] = $date;
	$sqlwhere = ' where Match_Type=1 and Match_Date=:Match_Date and (Match_BHo+Match_BAo<>0 or Match_Bdpl+Match_Bxpl<>0) and Match_IsShowb=1';
}
else if ($match_type == 0)
{
	$params[':Match_CoverDate'] = date('Y-m-d H:i:s');
	$params[':Match_Date'] = date('m-d');
	$sqlwhere = ' where Match_CoverDate >:Match_CoverDate and match_date!=:Match_Date and (Match_BHo+Match_BAo<>0 or Match_Bdpl+Match_Bxpl<>0) and Match_IsShowb=1';
	if (isset($_GET['date']))
	{
		$params[':Match_CoverDate'] = date('Y-m-d H:i:s');
		$params[':Match_Date'] = $page_date;
		$sqlwhere = ' where Match_CoverDate >:Match_CoverDate and match_date=:Match_Date and (Match_BHo+Match_BAo<>0 or Match_Bdpl+Match_Bxpl<>0) and Match_IsShowb=1';
	}
}
$sql .= $sqlwhere;
$match_name = getmatch_name('bet_match', $sqlwhere, $params);
if (isset($_GET['match_name']))
{
	$params[':match_name'] = urldecode($_GET['match_name']);
	$sql .= '  and match_name=:match_name';
}
$sql .= ' order by Match_CoverDate,ipage,isn';
$arr = array();
$arr_m = array();
$mid = '';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
while ($rows = $stmt->fetch())
{
	$arr[$rows['Match_ID']]['Match_ID'] = $rows['Match_ID'];
	$arr[$rows['Match_ID']]['Match_Date'] = $rows['Match_Date'];
	$arr[$rows['Match_ID']]['Match_Time'] = $rows['Match_Time'];
	$arr[$rows['Match_ID']]['Match_Master'] = $rows['Match_Master'];
	$arr[$rows['Match_ID']]['Match_Guest'] = $rows['Match_Guest'];
	$arr[$rows['Match_ID']]['Match_Name'] = $rows['Match_Name'];
	$arr[$rows['Match_ID']]['Match_IsLose'] = $rows['Match_IsLose'];
	$arr[$rows['Match_ID']]['Match_MasterID'] = $rows['Match_MasterID'];
	$arr[$rows['Match_ID']]['Match_GuestID'] = $rows['Match_GuestID'];
	$arr[$rows['Match_ID']]['Match_Hr_ShowType'] = $rows['Match_Hr_ShowType'];
	$arr[$rows['Match_ID']]['Match_Bmdy'] = $rows['Match_Bmdy'];
	$arr[$rows['Match_ID']]['Match_Bgdy'] = $rows['Match_Bgdy'];
	$arr[$rows['Match_ID']]['Match_Bhdy'] = $rows['Match_Bhdy'];
	$arr[$rows['Match_ID']]['Match_Bdpl'] = $rows['Match_Bdpl'];
	$arr[$rows['Match_ID']]['Match_Bxpl'] = $rows['Match_Bxpl'];
	$arr[$rows['Match_ID']]['Match_BRpk'] = $rows['Match_BRpk'];
	$arr[$rows['Match_ID']]['Match_Bdxpk'] = $rows['Match_Bdxpk'];
	$arr[$rows['Match_ID']]['Match_BHo'] = $rows['Match_BHo'];
	$arr[$rows['Match_ID']]['Match_BAo'] = $rows['Match_BAo'];
	$arr_m[$rows['Match_ID']] = 0;
	$mid .= floatval($rows['Match_ID']) . ',';
}
if ($mid)
{
	$mid = rtrim($mid, ',');
	$sql = 'select match_id,point_column,bet_money from `k_bet` where match_type<2 and match_id in(' . $mid . ') and `status`!=3';
	$query = $mydata1_db->query($sql);
	while ($rows = $query->fetch())
	{
		$arr[$rows['match_id']][$rows['point_column']]['num'] = $arr[$rows['match_id']][$rows['point_column']]['num'] + 1;
		$arr[$rows['match_id']][$rows['point_column']]['money'] = $arr[$rows['match_id']][$rows['point_column']]['money'] + $rows['bet_money'];
		$arr_m[$rows['match_id']] += $rows['bet_money'];
	}
}
arsort($arr_m);?><html> 
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
	      <select id="select" name="table" onChange="gopage(this.value);" class="za_select">    <option value="ft_danshi.php?match_type=<?=$match_type?>"  >足球</option>
			<option value="bk_danshi.php?match_type=<?=$match_type?>">篮球</option>
			<option value="tennis_danshi.php">网球</option>
			<option value="volleyball_danshi.php">排球</option>
			<option value="baseball_danshi.php?match_type=<?=$match_type?>">棒球</option>
			<option value="guanjun.php" >冠軍</option>
			<option value="jinrong.php" >金融</option>
			<option value="chuanguan.php?date=<?=date("m-d")?>" >串关</option>
		  </select>
		  </td> 
		  <td width="230">
		  美东时间：<?php if($match_type==1){?>
	      <select id="DropDownList1" onChange="javascript:gopage(this.value)" name="DropDownList1">
	    <option value="<?=$_SERVER['PHP_SELF']?>?match_type=1">==选择时间==</option>
      <? for ($i=0;$i<=6;$i++){
	   $s=strtotime("-$i day");
	   $date=date("m-d",$s);
	    ?>
        <option value="<?=$_SERVER['PHP_SELF']?>?match_type=1&date=<?=$date?>" <?=@$page_date==$date ? "selected" : "" ?>><?=$date?></option>
  <?}?>
      </select><?php }else if($match_type==0){?>
	
	     <select id="DropDownList1" onChange="javascript:gopage(this.value)" name="DropDownList1">
	    <option value="<?=$_SERVER['PHP_SELF']?>?match_type=0">==选择时间==</option>
      <? for ($i=1;$i<=7;$i++){
	   $s=strtotime("+$i day");
	   $date=date("m-d",$s);
	    ?>
        <option value="<?=$_SERVER['PHP_SELF']?>?match_type=0&date=<?=$date?>" <?=@$page_date==$date ? "selected" : "" ?>><?=$date?></option>
  <?}?>
      </select>
	<?}?>&nbsp;&nbsp;<a href="javascript:re_load();">刷新</a></td>
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
    <table width="888" border="0" cellpadding="0" cellspacing="1"  bgcolor="006255" class="m_tab" id="glist_table"> 
      <tr class="m_title_ft"> 
      <td width="60" height="24"><strong>時間</strong></td> 
          <td nowrap="nowrap" width="160"><strong>聯盟</strong></td> 
          <td width="50"><strong>場次</strong></td> 
          <td width="170"><strong>隊伍</strong></td> 
          <td width="160"><strong>讓球 / 注單</strong></td> 
          <td width="160"><strong>大小盤 / 注單</strong></td> 
          <td width="120"><strong>獨贏</strong></td> 
      </tr>
	  <?php
foreach($arr_m as $k=>$v){
	$rows	=	$arr[$k];
	$color	=	getColor($v);
?>
    <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='<?=$color?>'">
        <td align="center"><?=$rows["Match_Date"]?><br />
      <?=$rows["Match_Time"]?><br />
      <? if(@$rows["Match_IsLose"]==1){?>  <span style="color:#FF0000">滾球</span><? } ?></td>
        <td><?=$rows["Match_ID"]?><br /><?=$rows["Match_Name"]?></td>
        <td><?=$rows["Match_MasterID"]?><br><?=$rows["Match_GuestID"]?></td>
        <td align="left"><?=$rows["Match_Master"]?>-[上半]<br><?=$rows["Match_Guest"]?>-[上半]
      <div style=" color:#009933">和局</div></td>
        <td><table cellspacing="0" cellpadding="0" width="100%" border="0">
          <tbody>
            <tr align="right"> 
              <td width="50%"><? if($rows["Match_Hr_ShowType"]=="H"){?>  <font color="#0033FF"><?=$rows["Match_BRpk"]?> </font> <?}?>
               <? if($rows["Match_BHo"]>0) echo double_format($rows["Match_BHo"]);?></font>              </td>
              <td width="50%"><a href="look_ds.php?match_id=<?=$rows["Match_ID"]?>&point_column=Match_BHo" <?=getAC($arr[$rows["Match_ID"]]["match_bho"]['num'])?> ><?=getString($arr[$rows["Match_ID"]]["match_bho"]['num'])?>/<?=getString($arr[$rows["Match_ID"]]["match_bho"]['money'])?></a></td>
            </tr>
            <tr align="right">
              <td><? if($rows["Match_Hr_ShowType"]=="C"){?>  <font color="#0033FF"><?=$rows["Match_BRpk"]?> </font> <?}?>
              <? if($rows["Match_BAo"]>0) echo double_format($rows["Match_BAo"]);?>            </td>
              <td><a href="look_ds.php?match_id=<?=$rows["Match_ID"]?>&point_column=match_bao" <?=getAC($arr[$rows["Match_ID"]]["match_bao"]['num'])?> ><?=getString($arr[$rows["Match_ID"]]["match_bao"]['num'])?>/<?=getString($arr[$rows["Match_ID"]]["match_bao"]['money'])?></a></td>
            </tr>
            <tr>
              <td colspan="2"> </td>
            </tr>
          </tbody>
        </table></td>
        <td><table cellspacing="0" cellpadding="0" width="100%" border="0">
          <tbody>
            <tr align="right">
              <td width="50%"><? if ($rows["Match_Bdxpk"]>0){?>   <font color="#0033FF"><?="O".$rows["Match_Bdxpk"]?> </font><?}?>
              <? if($rows["Match_Bdpl"]>0) echo double_format($rows["Match_Bdpl"]);?>             </td>
              <td width="50%"><a href="look_ds.php?match_id=<?=$rows["Match_ID"]?>&point_column=Match_Bdpl" <?=getAC($arr[$rows["Match_ID"]]["match_bdpl"]['num'])?> ><?=getString($arr[$rows["Match_ID"]]["match_bdpl"]['num'])?>/<?=getString($arr[$rows["Match_ID"]]["match_bdpl"]['money'])?></a> </td>
            </tr>
            <tr align="right">
              <td>  <? if ($rows["Match_Bdxpk"]>0){?>   <font color="#0033FF"><?="U".$rows["Match_Bdxpk"]?> </font><?}?>  <? if($rows["Match_Bxpl"]>0) echo double_format($rows["Match_Bxpl"]);?>    <br />              </td>
              <td><a href="look_ds.php?match_id=<?=$rows["Match_ID"]?>&point_column=Match_Bxpl" <?=getAC($arr[$rows["Match_ID"]]["match_bxpl"]['num'])?> ><?=getString($arr[$rows["Match_ID"]]["match_bxpl"]['num'])?>/<?=getString($arr[$rows["Match_ID"]]["match_bxpl"]['money'])?></a> </td>
            </tr>
            <tr>
              <td colspan="3"> </td>
            </tr>
          </tbody>
        </table></td>
        <td><table cellspacing="0" cellpadding="0" width="100%" border="0">
          <tbody>
            <tr align="right">
              <td align="right" width="33%"> 
                <? if($rows["Match_Bmdy"]>0) echo double_format($rows["Match_Bmdy"]);?>
             <br /></td>
              <td width="67%"><a href="look_ds.php?match_id=<?=$rows["Match_ID"]?>&point_column=Match_Bmdy" <?=getAC($arr[$rows["Match_ID"]]["match_bmdy"]['num'])?> ><?=getString($arr[$rows["Match_ID"]]["match_bmdy"]['num'])?>/<?=getString($arr[$rows["Match_ID"]]["match_bmdy"]['money'])?></a></td>
            </tr>
            <tr align="right">
              <td align="right"><? if($rows["Match_Bgdy"]>0) echo double_format($rows["Match_Bgdy"]);?>               <br /></td>
              <td><a href="look_ds.php?match_id=<?=$rows["Match_ID"]?>&point_column=Match_Bgdy" <?=getAC($arr[$rows["Match_ID"]]["match_bgdy"]['num'])?> ><?=getString($arr[$rows["Match_ID"]]["match_bgdy"]['num'])?>/<?=getString($arr[$rows["Match_ID"]]["match_bgdy"]['money'])?></a></td>
            </tr>
            <tr align="right">
              <td align="right"> <? if($rows["Match_Bhdy"]>0) echo double_format($rows["Match_Bhdy"]);?><br /></td>
              <td><a href="look_ds.php?match_id=<?=$rows["Match_ID"]?>&point_column=Match_Bhdy" <?=getAC($arr[$rows["Match_ID"]]["match_bhdy"]['num'])?> ><?=getString($arr[$rows["Match_ID"]]["match_bhdy"]['num'])?>/<?=getString($arr[$rows["Match_ID"]]["match_bhdy"]['money'])?></a> </td>
            </tr>
          </tbody>
        </table></td>
    </tr>
<? }?>
  </table>
</body>
</html>