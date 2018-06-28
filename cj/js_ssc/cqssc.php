<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");
include ("auto_class.php");
$m = 0;
$qishus = "";
$type = '重庆时时彩';
$params = array(':type'=>$type);
$sql = 'select qishu from c_bet where type=:type and js=0 group by qishu order by qishu asc';
$stmta = $mydata1_db->prepare($sql);
$stmta->execute($params);
while($rsq = $stmta->fetch()){
	$qi = $rsq['qishu'];
	$params = array(':qishu'=>$qi);
	$sql = 'select * from c_auto_2 where qishu=:qishu limit 0,1';
	$st = $mydata1_db->prepare($sql);
	$st->execute($params);
	$rs = $st->fetch();
    
	if($rs){
		$hm 		= array();
		$hm[]		= $rs['ball_1'];
		$hm[]		= $rs['ball_2'];
		$hm[]		= $rs['ball_3'];
		$hm[]		= $rs['ball_4'];
		$hm[]		= $rs['ball_5'];

		$par = array(':type'=>$type,':js'=>0,':qishu'=>$qi);
		$sql1 = 'select * from c_bet where type=:type and js=:js and qishu=:qishu order by addtime asc';
		$stm = $mydata1_db->prepare($sql1);
		$stm->execute($par);
		$sum = $stm->rowCount();

		while($rows = $stm->fetch()){
			//开始结算第一球
			if($rows['mingxi_1']=='第一球'){
				$ds = Ssc_Ds($rs['ball_1']);
				$dx = Ssc_Dx($rs['ball_1']);
				if (('ABC' . $rows['mingxi_2'] == 'ABC' . $rs['ball_1']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			//开始结算第二球
			if ($rows['mingxi_1'] == '第二球'){
				$ds = Ssc_Ds($rs['ball_2']);
				$dx = Ssc_Dx($rs['ball_2']);
				if (('ABC' . $rows['mingxi_2'] == 'ABC' . $rs['ball_2']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			//开始结算第三球
			if ($rows['mingxi_1'] == '第三球'){
				$ds = Ssc_Ds($rs['ball_3']);
				$dx = Ssc_Dx($rs['ball_3']);
				if (('ABC' . $rows['mingxi_2'] == 'ABC' . $rs['ball_3']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			//开始结算第四球
			if ($rows['mingxi_1'] == '第四球'){
				$ds = Ssc_Ds($rs['ball_4']);
				$dx = Ssc_Dx($rs['ball_4']);
				if (('ABC' . $rows['mingxi_2'] == 'ABC' . $rs['ball_4']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			//开始结算第五球
			if ($rows['mingxi_1'] == '第五球'){
				$ds = Ssc_Ds($rs['ball_5']);
				$dx = Ssc_Dx($rs['ball_5']);
				if (('ABC' . $rows['mingxi_2'] == 'ABC' . $rs['ball_5']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if (($rows['mingxi_2'] == '总和大') || ($rows['mingxi_2'] == '总和小')){
				$zonghe = Ssc_Auto($hm, 2);
				if ($rows['mingxi_2'] == $zonghe){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if (($rows['mingxi_2'] == '总和单') || ($rows['mingxi_2'] == '总和双')){
				$zonghe = Ssc_Auto($hm, 3);
				if ($rows['mingxi_2'] == $zonghe){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if (($rows['mingxi_2'] == '龙') || ($rows['mingxi_2'] == '虎') || ($rows['mingxi_2'] == '和')){
				$longhu = Ssc_Auto($hm, 4);
				if ($rows['mingxi_2'] == $longhu){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '前三'){
				$qiansan = Ssc_Auto($hm, 5);
				if ($rows['mingxi_2'] == $qiansan){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '中三'){
				$zhongsan = Ssc_Auto($hm, 6);
				if ($rows['mingxi_2'] == $zhongsan){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '后三'){
				$housan = Ssc_Auto($hm, 7);
				if ($rows['mingxi_2'] == $housan){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
				
			}

			$creationTime = date('Y-m-d H:i:s');
			$id = $rows['id'];
			$params = array(':creationTime' => $creationTime, ':id' => $id);
			$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'CQSSC\',\'RECKON\',c_bet.id,(case when c_bet.win<0 then 0 when c_bet.win=0 then c_bet.money else c_bet.win end),k_user.money-(case when c_bet.win<0 then 0 when c_bet.win=0 then c_bet.money else c_bet.win end),k_user.money,:creationTime FROM k_user,c_bet  WHERE k_user.uid=c_bet.uid  AND c_bet.js=1 AND c_bet.id=:id';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$str_ball = $rs['ball_1'] . ',' . $rs['ball_2'] . ',' . $rs['ball_3'] . ',' . $rs['ball_4'] . ',' . $rs['ball_5'];
			$params = array(':jieguo' => $str_ball, ':id' => $rows['id']);
			$msql = 'update c_bet set jieguo=:jieguo where id=:id';
			$stmt = $mydata1_db->prepare($msql);
			$stmt->execute($params) || exit('注单修改失败!!!' . $rows['id']);

			$m += 1;
		}

		$params = array(':qishu' => $qi);
		$msql = 'update c_auto_2 set ok=1 where qishu=:qishu';
		$stmt = $mydata1_db->prepare($msql);
		$stmt->execute($params) || exit('期数修改失败!!!');

		$qishus .= "［第".$qi."期］：已经全部结算！！<br>";

	}
}

function win_update($id, $money, $uid){
	global $mydata1_db;
	$params = array(':id' => $id);
	$msql = 'update c_bet set js=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('注单修改失败!!!' . $id);
	$q1 = $stmt->rowCount();
	if ($q1 == 1)
	{
		$params = array(':money' => $money, ':uid' => $uid);
		$msql = 'update k_user set money=money+:money where uid=:uid';
		$stmt = $mydata1_db->prepare($msql);
		$stmt->execute($params) || exit('会员修改失败!!!' . $id);
	}
}

function no_win_update($id){
	global $mydata1_db;
	$params = array(':id' => $id);
	$msql = 'update c_bet set win=-money,js=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('注单修改失败!!!' . $id);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$type?>结算</title>
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

<? $limit= rand(10,20);?>
var limit="5"
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
	   
       <font color="#FF0000"><?=$type?> 共结算<?=$m?>个注单</font><br />
	   
	   <?=$qishus?>
      </td>
  </tr>
</table>
</body>
</html>
