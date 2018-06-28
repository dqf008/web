<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");

$m = 0;
$xiansho = "";
$atype='qxc';
$type='七星彩';

$params = array(':atype'=>$atype);
$sql = 'SELECT `mid` FROM `lottery_data` WHERE `atype`=:atype AND `bet_ok`=0 GROUP BY `mid` ORDER BY `mid` ASC';
$stmta = $mydata1_db->prepare($sql);
$stmta->execute($params);
while($row = $stmta->fetch()){
	$openinfo = array();
	$params = array(':qishu'=>$row['mid']);
	$sql = 'SELECT `value` FROM `lottery_k_qxc` WHERE `qishu`=:qishu AND `status`=1 LIMIT 1';
	$stmtb = $mydata1_db->prepare($sql);
	$stmtb->execute($params);
	if($stmtb->rowCount()>0){
		$info = $stmtb->fetch();
		$openinfo = unserialize($info['value']);
		$xiansho .= "［第".$row['mid']."期］：已经全部结算！！<br>";
		$params[':atype'] = $atype;
	}
	if(!empty($openinfo)){
		$sql = 'SELECT * FROM `lottery_data` WHERE `atype`=:atype AND `mid`=:qishu AND `bet_ok`=0';
		$stmtc = $mydata1_db->prepare($sql);
		$stmtc->execute($params);
		while($row = $stmtc->fetch()){
			$row['ctype'] = explode('/', $row['ctype']);
			if(count($row['ctype'])>1){
				$row['count'] = $row['ctype'][0];
				$row['money2'] = $row['ctype'][1];
			}else{
				$row['count'] = 0;
				$row['money2'] = 0;
			}
			$wins = 0;
			switch($row['btype']){
				case '定位':
					$row['content'] = explode(',', $row['content']);
		            foreach($row['content'] as $key=>$val){
		                if($val=='*'){
		                    unset($row['content'][$key]);
		                    continue;
		                }else{
		                    $row['content'][$key] = str_split($val);
		                }
		            }
		            if($row['dtype']=='一定位'){
		            	foreach($row['content'] as $key=>$val){
		            		in_array($openinfo[$key], $val)&&$wins+= 1;
		            	}
		            }else if(count($row['content'])==str_replace(array('二定位', '三定位', '四定位'), array(2, 3, 4), $row['dtype'])){
		                foreach($row['content'] as $key=>$val){
		                    if(in_array($openinfo[$key], $val)){
		                    	$wins = 1;
		                    }else{
		                    	$wins = 0;
		                    	break;
		                    }
		                }
		            }
				break;
				case '字现':
		            $row['content'] = str_split($row['content']);
					$row['content2'] = array();
					$show = 0;
		            foreach($row['content'] as $val){
		                $row['content2']['j'.$val] = $val;
		            }
					for($i=0;$i<4;$i++){
		                $j = $openinfo[$i];
		                if(isset($row['content2']['j'.$j])){
		                    $show+= 1;
		                    unset($row['content2']['j'.$j]);
		                }
					}
					$show==str_replace(array('二字现', '三字现'), array(2, 3), $row['dtype'])&&$wins = 1;
				break;
			}
		    if($wins>0){
		    	$wins*= $row['money2']*$row['odds'];
		    	win_update($wins-$row['money'], $row['id'], $wins, $row['username'], $row['ctype'].'注单中奖修改失败' . $row['id'], $row['ctype'].'会员加奖失败' . $row['username']);
		    }else{
		    	no_win_update($row['money'], $row['id'], $row['ctype'].'注单未中奖修改失败' . $row['id']);
		    }
			$creationTime = date('Y-m-d H:i:s');
			$id = $row['id'];
			$params = array(':creationTime' => $creationTime, ':id' => $id);
			$sql = "\r\n\t\t" . 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'QXC\',\'RECKON\',lottery_data.uid,lottery_data.win+lottery_data.money,k_user.money-(lottery_data.win+lottery_data.money),k_user.money,:creationTime FROM k_user,lottery_data  WHERE k_user.username=lottery_data.username  AND lottery_data.bet_ok=1 AND lottery_data.id=:id';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$m++;
		}
	}
}

function win_update($win, $id, $money, $username, $msg_data, $msg_user){
	global $mydata1_db;
	$params = array(':win' => $win, ':id' => $id);
	$msql = 'update lottery_data set win=:win,bet_ok=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit($msg_data);
	$params = array(':money' => $money, ':username' => $username);
	$msql = 'update k_user set money=money+:money where username=:username';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit($msg_user);
}
function no_win_update($win, $id, $msg_data){
	global $mydata1_db;
	$params = array(':win' => $win, ':id' => $id);
	$msql = 'update lottery_data set win=-:win,bet_ok=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit($msg_data);
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
