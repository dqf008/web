<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('bfgl');
$mid = $_POST['mid'][0];
$table = $_GET['type'];
$php = ($_GET['php'] ? $_GET['php'] : 'wqbf_yjs');
$arr_table = array('baseball_match', 'bet_match', 'lq_match', 't_guanjun_team', 'tennis_match', 'volleyball_match');
if (!in_array($table, $arr_table)){
	message('数据[表]查询失败，交易失败', $php . '.php');
}

if ($_GET['action'] == 'save'){
	$mid = $_GET['mid'];
	$mb = $_GET['MB_Inball'];
	$tg = $_GET['TG_Inball'];
	$params = array(':MB_Inball' => $mb, ':TG_Inball' => $tg, ':Match_ID' => $mid);
	$sql = 'update mydata4_db.' . $table . ' set MB_Inball=:MB_Inball,TG_Inball=:TG_Inball where Match_ID=:Match_ID';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$params = array(':Match_ID' => $mid);
	$sql = 'select bid from k_bet where lose_ok=1 and status=0 and match_id=:Match_ID';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$bid = '';
	while ($rows = $stmt->fetch()){
		$bid .= intval($rows['bid']) . ',';
	}
	
	if ($bid != ''){
		$bid = rtrim($bid, ',');
		$params = array(':MB_Inball' => $mb, ':TG_Inball' => $tg);
		$sql = 'update k_bet set MB_Inball=:MB_Inball,TG_Inball=:TG_Inball where bid in(' . $bid . ')';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
	}
	message('本次录入完成', $php . '.php');
}
$params = array(':Match_ID' => $mid);
$sql = 'select Match_Master,Match_Guest,Match_Name,MB_Inball,TG_Inball from mydata4_db.' . $table . ' where Match_ID=:Match_ID limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetch();
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>设置比分</title> 
<script language="javascript"> 
function check_sub(){ 
  var mb=document.getElementById("MB_Inball").value;
  var tg=document.getElementById("TG_Inball").value;
  if(mb.length < 1){ 
	  alert('请填主队进球');
	  return false;
  } 
  if(tg.length < 1){ 
	  alert('请填客队进球');
	  return false;
  } 
  return true;
} 
</script> 
</head> 
<body bgcolor="#EAFFD7"> 
<form action="set_wpb_score.php" method="get" name="form1" id="form1" onsubmit="return check_sub();"> 
<table width="500"  border="1" align="center" cellpadding="4" cellspacing="0" bgcolor="#E8DCC4"> 
<tr align="center"> 
  <td colspan="2" style="background:#986032;color: #FFFFFF;font-weight: bold;">设置结算比分 
	<input name="mid" type="hidden" id="mid" value="<?=$mid?>" /> 
	<input name="type" type="hidden" id="type" value="<?=$table?>" /> 
	<input name="php" type="hidden" id="php" value="<?=$_GET['php']?>" /> 
	<input name="action" type="hidden" id="action" value="save" /></td> 
</tr> 
<tr style="background: #C0AB58;color: #9C4945;font-weight: bold;"> 
  <td colspan="2" align="center"><?=$rows['Match_Name']?></td> 
  </tr> 
<tr style="font-size:14px;text-align:center"> 
  <td width="239" align="center"><?=$rows['Match_Master']?></td> 
  <td width="239" align="center"><?=$rows['Match_Guest']?></td> 
</tr> 
<tr style="font-size:14px;text-align:center"> 
  <td align="center"><input  name="MB_Inball" type="text"  id="MB_Inball" value="<?=$rows['MB_Inball']?>" size="10" maxlength="10"/></td> 
  <td align="center"><input  name="TG_Inball" type="text" id="TG_Inball" value="<?=$rows['TG_Inball']?>" size="10" maxlength="10"/></td> 
</tr> 
<tr align="center"> 
  <td colspan="2"><input type="submit" value="提交" /> 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	 <input type="button" onclick="javascript:history.go(-1);" value="返回" /></td> 
</tr> 
</table> 
</form> 
</body> 
</html>