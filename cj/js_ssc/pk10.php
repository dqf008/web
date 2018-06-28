<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");
include ("Auto_Class4.php");
$m = 0;
$xiansho = "";
$type ='北京赛车PK拾';

$params =  array(':type'=>$type);
$sqlq		= "select qishu from c_bet_3 where  type=:type and js=0 group by qishu order by qishu asc";
$stmta = $mydata1_db->prepare($sqlq);
$stmta->execute($params);
while ($rsq = $stmta->fetch()) {
	$qi = $rsq['qishu'];
	$para = array(':qishu'=>$qi);
	$sqlw = 'select * from c_auto_4 where qishu=:qishu limit 0,1';
	$st = $mydata1_db->prepare($sqlw);
	$st -> execute($para);
	$rs = $st->fetch();

	if($rs){

		$hm = array();
		$hm[] = $rs['ball_1'];
		$hm[] = $rs['ball_2'];
		$hm[] = $rs['ball_3'];
		$hm[] = $rs['ball_4'];
		$hm[] = $rs['ball_5'];
		$hm[] = $rs['ball_6'];
		$hm[] = $rs['ball_7'];
		$hm[] = $rs['ball_8'];
		$hm[] = $rs['ball_9'];
		$hm[] = $rs['ball_10'];

		//根据期数读取未结算的注单
		$pra = array(':type'=>$type,':qishu'=>$qi);
		$sql1 = 'select * from c_bet_3 where type=:type and js=0 and qishu=:qishu order by addtime asc';

		$stm = $mydata1_db->prepare($sql1);
		$stm->execute($pra);

		while($rows = $stm->fetch()){
			if ($rows['mingxi_1'] == '冠军'){
				$ds = Bjsc_Ds($rs['ball_1']);
				$dx = Bjsc_Dx($rs['ball_1']);
				if (($rows['mingxi_2'] == $rs['ball_1']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '亚军'){
				$ds = Bjsc_Ds($rs['ball_2']);
				$dx = Bjsc_Dx($rs['ball_2']);
				if (($rows['mingxi_2'] == $rs['ball_2']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '第三名'){
				$ds = Bjsc_Ds($rs['ball_3']);
				$dx = Bjsc_Dx($rs['ball_3']);
				if (($rows['mingxi_2'] == $rs['ball_3']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '第四名'){
				$ds = Bjsc_Ds($rs['ball_4']);
				$dx = Bjsc_Dx($rs['ball_4']);
				if (($rows['mingxi_2'] == $rs['ball_4']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '第五名'){
				$ds = Bjsc_Ds($rs['ball_5']);
				$dx = Bjsc_Dx($rs['ball_5']);
				if (($rows['mingxi_2'] == $rs['ball_5']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '第六名'){
				$ds = Bjsc_Ds($rs['ball_6']);
				$dx = Bjsc_Dx($rs['ball_6']);
				if (($rows['mingxi_2'] == $rs['ball_6']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '第七名'){
				$ds = Bjsc_Ds($rs['ball_7']);
				$dx = Bjsc_Dx($rs['ball_7']);
				if (($rows['mingxi_2'] == $rs['ball_7']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '第八名'){
				$ds = Bjsc_Ds($rs['ball_8']);
				$dx = Bjsc_Dx($rs['ball_8']);
				if (($rows['mingxi_2'] == $rs['ball_8']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '第九名'){
				$ds = Bjsc_Ds($rs['ball_9']);
				$dx = Bjsc_Dx($rs['ball_9']);
				if (($rows['mingxi_2'] == $rs['ball_9']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '第十名'){
				$ds = Bjsc_Ds($rs['ball_10']);
				$dx = Bjsc_Dx($rs['ball_10']);
				if (($rows['mingxi_2'] == $rs['ball_10']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if (($rows['mingxi_1'] == '冠、亚军和') && (3 <= $rows['mingxi_2']) && ($rows['mingxi_2'] <= 19)){
				$zonghe = Bjsc_Auto($hm, 1);
                if ($rows['mingxi_2'] == $zonghe){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if (($rows['mingxi_2'] == '冠亚大') || ($rows['mingxi_2'] == '冠亚小')){
				$zonghe = Bjsc_Auto($hm, 2);
				if ($rows['mingxi_2'] == $zonghe){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}elseif($zonghe=='冠亚和'){
                    he_win_update($rows['id'], $rows['money'], $rows['uid']);
                }else{
					no_win_update($rows['id']);
				}
			}

			if (($rows['mingxi_2'] == '冠亚双') || ($rows['mingxi_2'] == '冠亚单')){
				$zonghe = Bjsc_Auto($hm, 3);
				if ($rows['mingxi_2'] == $zonghe){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}elseif($zonghe=='冠亚和'){
                    he_win_update($rows['id'], $rows['money'], $rows['uid']);
                }else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '1V10 龙虎'){
				$longhu = Bjsc_Auto($hm, 4);
				if ($rows['mingxi_2'] == $longhu){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '2V9 龙虎'){
				$longhu = Bjsc_Auto($hm, 5);
				if ($rows['mingxi_2'] == $longhu){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '3V8 龙虎'){
				$longhu = Bjsc_Auto($hm, 6);
				if ($rows['mingxi_2'] == $longhu){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '4V7 龙虎'){
				$longhu = Bjsc_Auto($hm, 7);
				if ($rows['mingxi_2'] == $longhu){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}

			if ($rows['mingxi_1'] == '5V6 龙虎'){
				$longhu = Bjsc_Auto($hm, 8);
				if ($rows['mingxi_2'] == $longhu){
					win_update($rows['id'], $rows['win'], $rows['uid']);
				}else{
					no_win_update($rows['id']);
				}
			}
			$creationTime = date('Y-m-d H:i:s');
			$id = $rows['id'];
			$params = array(':creationTime' => $creationTime, ':id' => $id);
			$sql =  'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'BJPK10\',\'RECKON\',c_bet_3.id,(case when c_bet_3.win<0 then 0 when c_bet_3.win=0 then c_bet_3.money else c_bet_3.win end),k_user.money-(case when c_bet_3.win<0 then 0 when c_bet_3.win=0 then c_bet_3.money else c_bet_3.win end),k_user.money,:creationTime FROM k_user,c_bet_3  WHERE k_user.uid=c_bet_3.uid  AND c_bet_3.js=1 AND c_bet_3.id=:id';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$str_ball = $rs['ball_1'] . ',' . $rs['ball_2'] . ',' . $rs['ball_3'] . ',' . $rs['ball_4'] . ',' . $rs['ball_5'] . ',' . $rs['ball_6'] . ',' . $rs['ball_7'] . ',' . $rs['ball_8'] . ',' . $rs['ball_9'] . ',' . $rs['ball_10'];
			$params = array(':jieguo' => $str_ball, ':id' => $rows['id']);
			$msql = 'update c_bet_3 set jieguo=:jieguo where id=:id';
			$stmt = $mydata1_db->prepare($msql);
			$stmt->execute($params) || exit('注单修改失败!!!' . $rows['id']);
			$m += 1;
		}

		$param = array(':qishu'=>$qi);
		$msql='update c_auto_4 set ok=1 where qishu=:qishu';
		$stmt1 = $mydata1_db->prepare($msql);
		$stmt1 -> execute($param) || exit("期数修改失败!!!");
		$xiansho .= "［第".$qi."期］：已经全部结算！！<br>";
	}
}

//赢
function win_update($id, $money, $uid){
	global $mydata1_db;
	$params = array(':id' => $id);
	$msql = 'update c_bet_3 set js=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('注单修改失败!!!' . $id);
	$q1 = $stmt->rowCount();
	if ($q1 == 1){
		$params = array(':money' => $money, ':uid' => $uid);
		$msql = 'update k_user set money=money+:money where uid=:uid';
		$stmt = $mydata1_db->prepare($msql);
		$stmt->execute($params) || exit('会员修改失败!!!' . $id);
	}
}

//输
function no_win_update($id){
	global $mydata1_db;
	$params = array(':id' => $id);
	$msql = 'update c_bet_3 set win=-money,js=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('注单修改失败!!!' . $id);
}

//和
function he_win_update($id, $money, $uid){
    global $mydata1_db;
    $params = array(':id' => $id);
    $msql = 'update c_bet_3 set win='.$money.',js=1 where id=:id';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('注单修改失败!!!' . $id);
    $q1 = $stmt->rowCount();
    if ($q1 == 1){
        $params = array(':money' => $money, ':uid' => $uid);
        $msql = 'update k_user set money=money+:money where uid=:uid';
        $stmt = $mydata1_db->prepare($msql);
        $stmt->execute($params) || exit('会员修改失败!!!' . $id);
    }
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

<? $limit= rand(10,30);?>
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
	   
       <font color="#FF0000"><?=$type?> 共结算<?=$m?>个注单</font><br />
	   
	   <?=$xiansho?>
      </td>
  </tr>
</table>
</body>
</html>
