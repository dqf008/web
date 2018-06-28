<?php 
header('Content-type: text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('sgjzd');
$x_ic = $result = '';
$str = '结算失败';
$params = array(':match_id' => $_GET['match_id']);
$sql = 'select x_result,x_id from mydata4_db.t_guanjun where match_id=:match_id';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
while ($row = $stmt->fetch()){
	$x_id = $row['x_id'];
	$result = $row['x_result'];
}

if ($result){
	$paramsSub = array(':bid' => $_GET['bid']);
	$sqlSub = 'select bid,bet_info from k_bet where bid=:bid and `status`=0';
	$stmtSub = $mydata1_db->prepare($sqlSub);
	$stmtSub->execute($paramsSub);
	while ($row = $stmtSub->fetch())
	{
		$sql = '';
		$bool = 0;
		$jg = explode('<br>', $result);
		$i = 0;
		for (;$i < count($jg);
		$i++)
		{
			if (strrpos($row['bet_info'], $jg[$i]) === 0)
			{
				$bool = 1;
				break;
			}
		}
		$params = array(':bid' => $row['bid']);
		if ($bool)
		{
			$sql = 'update k_user,k_bet set k_user.money=k_user.money+k_bet.bet_win,k_bet.win=k_bet.bet_win,k_bet.status=1,k_bet.update_time=now() where k_user.uid=k_bet.uid and k_bet.bid=:bid';
			$msg = '审核了编号为' . $row['bid'] . '的注单,设为赢';
		}
		else
		{
			$sql = 'update k_user,k_bet set k_user.money=k_user.money,status=2,update_time=now() where k_user.uid=k_bet.uid and k_bet.bid=:bid';
			$msg = '审核了编号为' . $row['bid'] . '的注单,设为输';
		}
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		if ($stmt->rowCount())
		{
			$creationTime = date('Y-m-d H:i:s');
			$bid = $row['bid'];
			$params = array(':creationTime' => $creationTime, ':bid' => $bid);
			$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) 
			SELECT k_user.uid,k_user.username,\'SportsDS\',\'RECKON\',k_bet.number,k_bet.win,k_user.money-k_bet.win,k_user.money,:creationTime FROM k_user,k_bet WHERE k_user.uid=k_bet.uid AND k_bet.bid=:bid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$client_ip = get_client_ip();
			$params = array(':uid' => $_SESSION['adminid'], ':log_info' => $msg, ':log_ip' => $client_ip);
			$sql = 'insert into mydata3_db.sys_log(uid,log_info,log_ip) values(:uid,:log_info,:log_ip)';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$str = '结算成功！';
		}
	}
}else{
	$str = '赛事未设置结果，不能结算！\\n请设置完赛事结果，再来结算本注单！';
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>设置结算比分</title> 
<script language="javascript"> 
function refash() 
{ 
var win = top.window;
try{// 刷新. 
	  if(win.opener)  win.opener.location.reload();
}catch(ex){ 
// 防止opener被关闭时代码异常。 
} 
window.close();
} 
</script> 
</head> 
<body> 
<?php
echo "<script>alert('".$str."'),refash();</script>";
?>
</body> 
</html>