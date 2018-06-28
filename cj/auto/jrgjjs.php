<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once 'get_point.php';
include_once '../../class/bet.php';
session_start();
$url = "爱博官网";
$title = "棒球结算 => 全场";

$m = 0;
$match_id = '';
$arr = array();
session_start();
if (intval(date('H')) < 6){
	if ($_SESSION['jrgjjs'] == '0'){
		$bdate = date('m-d', time());
		$_SESSION['jrgjjs'] = '-1';
	}else{
		$bdate = date('m-d', time() - (24 * 3600));
		$_SESSION['jrgjjs'] = '0';
	}
}else{
	$bdate = date('m-d', time());
}

try
{
	$params = array(':match_date' => $bdate);
	$sql = 'select x_result,match_id from mydata4_db.t_guanjun where match_date=:match_date and x_result is not null';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	while ($row = $stmt->fetch()){
		$arr[$row['match_id']]['jg'] = $row['x_result'];
		$match_id .= floatval($row['match_id']) . ',';
	}

	if ($match_id){
		include_once 'function.php';
		$match_id = rtrim($match_id, ',');
		$sql = 'select bid,bet_info,match_id from k_bet where match_id in(' . $match_id . ') and `status`=0';
		$query = $mydata1_db->query($sql);
		while ($row = $query->fetch()){
			$sql = '';
			$bool = 0;
			$jg = explode('<br>', $arr[$row['match_id']]['jg']);
			
			for ($i = 0;$i < count($jg);$i++){
				if (strrpos($row['bet_info'], $jg[$i]) === 0){
					$bool = 1;
					break;
				}
			}
			$params = array(':bid' => $row['bid']);
			if ($bool){
				$sql = 'update k_user,k_bet set k_user.money=k_user.money+k_bet.bet_win,k_bet.win=k_bet.bet_win,k_bet.status=1,k_bet.update_time=now() where k_user.uid=k_bet.uid and k_bet.bid=:bid';
				$msg = '审核了编号为' . $row['bid'] . '的注单,设为赢';
			}else{
				$sql = 'update k_user,k_bet set k_user.money=k_user.money,status=2,update_time=now() where k_user.uid=k_bet.uid and k_bet.bid=:bid';
				$msg = '审核了编号为' . $row['bid'] . '的注单,设为输';
			}
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			if ($stmt->rowCount()){
				$creationTime = date('Y-m-d H:i:s');
				$bid = $row['bid'];
				$params = array(':creationTime' => $creationTime, ':bid' => $bid);
				$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)  SELECT k_user.uid,k_user.username,\'SportsDS\',\'RECKON\',k_bet.number,k_bet.win,k_user.money-k_bet.win,k_user.money,:creationTime  FROM k_user,k_bet  WHERE k_user.uid=k_bet.uid  AND k_bet.bid=:bid';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				$client_ip = get_client_ip();
				$params = array(':log_info' => $msg, ':log_ip' => $client_ip);
				$sql = 'insert into mydata3_db.sys_log(uid,log_info,log_ip) values(\'1\',:log_info,:log_ip)';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				$m++;
			}
		}
	}
}catch (Exception $ex){
	$m = 'Fail';
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title.' '.$url?></title>
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

<? $limit= rand(120,180);?>
var limit="<?=$limit?>"
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
	   采集网址：<?=$url?><br />
       <font color="#FF0000">接收<?=$m;?>条金融冠军结算！</font> <br />
      </td>
  </tr>
</table>
</body>
</html>
