<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
$time = strtotime(date('Y-m-d'));
$time = strftime('%Y-%m-%d', $time - (7 * 24 * 3600)) . ' 00:00:00';
try{
	$params = array(':Match_CoverDate' => $time);
	$sql = 'Delete From mydata4_db.bet_match Where Match_CoverDate<:Match_CoverDate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	$params = array(':Match_CoverDate' => $time);
	$sql = 'Delete From mydata4_db.lq_match Where Match_CoverDate<:Match_CoverDate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':Match_CoverDate' => $time);
	$sql = 'Delete From mydata4_db.tennis_match Where Match_CoverDate<:Match_CoverDate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':Match_CoverDate' => $time);
	$sql = 'Delete From mydata4_db.volleyball_match Where Match_CoverDate<:Match_CoverDate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':Match_CoverDate' => $time);
	$sql = 'Delete From mydata4_db.baseball_match Where Match_CoverDate<:Match_CoverDate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':Match_CoverDate' => $time);
	$sql = 'select x_id from mydata4_db.t_guanjun where Match_CoverDate<:Match_CoverDate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$xid = '';
	while ($rows = $stmt->fetch()){
		$xid .= intval($rows['x_id']) . ',';
	}

	if ($xid){
		$xid = rtrim($xid, ',');
		$sql = 'Delete From mydata4_db.t_guanjun_team Where xid in(' . $xid . ')';
		$mydata1_db->query($sql);
		$params = array(':Match_CoverDate' => $time);
		$sql = 'Delete From mydata4_db.t_guanjun Where Match_CoverDate<:Match_CoverDate';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q1 += $stmt->rowCount();
	}

	$params = array(':end_time' => $time);
	$sql = 'Delete From `k_notice` Where end_time<:end_time';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':datetime' => $time);
	$sql = 'Delete From `c_auto_2` Where datetime<:datetime';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':datetime' => $time);
	$sql = 'Delete From `c_auto_3` Where datetime<:datetime';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':datetime' => $time);
	$sql = 'Delete From `c_auto_4` Where datetime<:datetime';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':fengpan' => $time);
	$sql = 'Delete From `lottery_k_kl8` Where fengpan<:fengpan';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':addtime' => $time);
	$sql = 'Delete From `lottery_k_ssl` Where addtime<:addtime';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':msg_time' => $time);
	$sql = 'Delete From `k_user_msg` Where msg_time<:msg_time';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':login_time' => $time);
	$sql = 'Delete From mydata3_db.admin_login Where login_time<:login_time';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':login_time' => $time);
	$sql = 'Delete From mydata3_db.history_login Where login_time<:login_time';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
	$params = array(':log_time' => $time);
	$sql = 'Delete From mydata3_db.sys_log Where log_time<:log_time and uis is null';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 += $stmt->rowCount();
}catch (Exception $ex){
	$q1 = 'Fail';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>清除7天前的赛事</title>
<style type="text/css">
<!--
body,td,th {
    font-size: 12px;
}
body {
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
}
-->
</style></head>
<body>

<script> 
<!-- 


var limit=3600
if (document.images){ 
	var parselimit=limit
} 
function beginrefresh(){ 
if (!document.images) 
	return 
if (parselimit==1) 
	window.location.reload() 
else{ 
	parselimit-=1 
	curmin=Math.floor(parselimit) 
	if (curmin!=0) 
		curtime=curmin+"秒后自动获取!" 
	else 
		curtime=cursec+"秒后自动获取!" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 
window.onload=beginrefresh
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" style="padding-left:10px; padding-top:10px; line-height:22px;">
      <input type=button name=button value="刷新" onClick="window.location.reload()">
	   <span id="timeinfo"></span><br />
	   清除7天前的赛事及开奖结果<br>
	  	<font color="#FF0000">共清理 <?=$q1?> 条</font>
      </td>
  </tr>
</table>
</body>
</html>