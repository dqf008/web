<?php 
header('Content-Type:text/html;charset=utf-8');
include_once __DIR__ . '/../../class/Db.class.php';
$time = strtotime(date('Y-m-d'));
$time = strftime('%Y-%m-%d', $time - (7 * 24 * 3600)) . ' 00:00:00';
try{
	$db = new DB(DB::DB4);
	$params = array('Match_CoverDate' => $time);
	$q1 = $db->query('Delete From bet_match Where Match_CoverDate<:Match_CoverDate',$params);
	$q1 += $db->query('Delete From lq_match Where Match_CoverDate<:Match_CoverDate',$params);
	$q1 += $db->query('Delete From tennis_match Where Match_CoverDate<:Match_CoverDate',$params);
	$q1 += $db->query('Delete From volleyball_match Where Match_CoverDate<:Match_CoverDate',$params);
	$q1 += $db->query('Delete From baseball_match Where Match_CoverDate<:Match_CoverDate',$params);
	$xid = $db->single('select group_concat(x_id) from t_guanjun where Match_CoverDate<:Match_CoverDate',$params);	
	if ($xid){
		$db->query('Delete From t_guanjun_team Where xid in(' . $xid . ')');
		$q1 += $db->query('Delete From t_guanjun Where Match_CoverDate<:Match_CoverDate',$params);
	}
	$db->CloseConnection();

	$db = new DB();
	$q1 += $db->query('Delete From `k_notice` Where end_time<:end_time',['end_time' => $time]);
	$q1 += $db->query('Delete From `c_auto_2` Where datetime<:datetime',['datetime' => $time]);
	$q1 += $db->query('Delete From `c_auto_3` Where datetime<:datetime',['datetime' => $time]);
	$q1 += $db->query('Delete From `c_auto_4` Where datetime<:datetime',['datetime' => $time]);
	$q1 += $db->query('Delete From `lottery_k_kl8` Where fengpan<:fengpan',['fengpan' => $time]);
	$q1 += $db->query('Delete From `lottery_k_ssl` Where addtime<:addtime',['addtime' => $time]);
	$q1 += $db->query('Delete From `k_user_msg` Where msg_time<:msg_time',['msg_time' => $time]);
	$db->CloseConnection();

	$db = new DB(DB::DB3);
	$q1 += $db->query('Delete From admin_login Where login_time<:login_time',['login_time' => $time]);
	$q1 += $db->query('Delete From history_login Where login_time<:login_time',['login_time' => $time]);
	$q1 += $db->query('Delete From sys_log Where log_time<:log_time',['log_time' => $time]);
	$db->CloseConnection();
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
var limit="3600"
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