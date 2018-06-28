<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");

$m = 0;
$xiansho = "";
$atype='pcdd';
$type='PC蛋蛋';

$params = array(':atype'=>$atype);
$sql = 'select * from lottery_data where atype=:atype and bet_ok=0 group by mid order by mid asc';
$stmta = $mydata1_db->prepare($sql);
$stmta->execute($params);
while($row = $stmta->fetch()){
	$qi = $row['mid'];
	$params = array(':qishu'=>$qi,':name'=>$atype);
	$sql = 'select * from lottery_k_pcdd where qihao=:qishu and ok=1 limit 0,1';
	$st = $mydata1_db->prepare($sql);
	$st->execute($params);
	$myrow = $st->fetch();
	if($myrow){
		$hm1 = $myrow['hm1'];
		$hm2 = $myrow['hm2'];
		$hm3 = $myrow['hm3'];
        $sum = $hm1 + $hm2 + $hm3;
        $wins = ($row['money'] * $row['odds']) - $row['money'];
        if ($row['btype'] == '和值'){
            if ($sum == $row['content']){
                win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
            }else{
                no_win_update($row['money'], $row['id']);
            }
        }
        if ($row['btype'] == '两面'){
            $isWin = false;
            switch ($row['content']){
                case '大':
                    if($sum>=14){
                        $isWin=true;
                    }
                    break;
                case '小':
                    if($sum<14){
                        $isWin=true;
                    }
                    break;
                case '单':
                    if(fmod($sum,2)!=0){
                        $isWin = true;
                    }
                    break;
                case '双':
                    if(fmod($sum,2)==0){
                        $isWin = true;
                    }
                    break;
                case '极大':
                    if($sum >=22){
                        $isWin = true;
                    }
                    break;
                case '极小':
                    if($sum <=5){
                        $isWin = true;
                    }
                    break;
                case '大单':
                    if($sum >=15 && fmod($sum,2)==1){
                        $isWin=true;
                    }
                    break;
                case '小单':
                    if($sum <=13 && fmod($sum,2)==1){
                        $isWin = true;
                    }
                    break;
                case '大双':
                    if($sum >=14 && fmod($sum,2)==0){
                        $isWin = true;
                    }
                    break;
                case '小双':
                    if($sum <=12 && fmod($sum,2)==0){
                        $isWin = true;
                    }
                    break;
                default:
                    break;
            }
            if ($isWin){
                win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
            }else{
                no_win_update($row['money'], $row['id']);
            }
        }

        if ($row['btype'] == '色波/豹子/包三'){
            if(($row['content']=='豹子' && ($hm1==$hm2) && ($hm2 ==$hm3))){
                win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
            }elseif ($row['content']=='红波' && in_array($sum,array(3,6,9,12,15,18,21,24))){
                win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
            }else{
                no_win_update($row['money'], $row['id']);
            }
        }

        $creationTime = date('Y-m-d H:i:s');
        $id = $row['id'];
        $params = array(':creationTime' => $creationTime, ':id' => $id);
        $sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'PCDD\',\'RECKON\',lottery_data.uid,lottery_data.win+lottery_data.money,k_user.money-(lottery_data.win+lottery_data.money),k_user.money,:creationTime FROM k_user,lottery_data  WHERE k_user.username=lottery_data.username  AND lottery_data.bet_ok=1 AND lottery_data.id=:id';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);

        $m +=1;

		$xiansho .= "［第".$qi."期］：已经全部结算！！<br>";
	}
}

function buling($num){
	if ($num < 10){
		$nums = '0' . $num;
	}else{
		$nums = $num;
	}
	return $nums;
}


function win_update($win, $id, $money, $username){
	global $mydata1_db;
	$params = array(':win' => $win, ':id' => $id);
	$msql = 'update lottery_data set win=:win,bet_ok=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('中奖修改失败' . $id);
	$params = array(':money' => $money, ':username' => $username);
	$msql = 'update k_user set money=money+:money where username=:username';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('会员加奖失败' . $id);
}

function he_update($id, $money, $username){
	global $mydata1_db;
	$params = array(':id' => $id);
	$msql = 'update lottery_data set win=0,bet_ok=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('中奖修改失败' . $id);
	$params = array(':money' => $money, ':username' => $username);
	$msql = 'update k_user set money=money+:money where username=:username';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('会员加奖失败' . $id);
}

function no_win_update($win, $id){
	global $mydata1_db;
	$params = array(':win' => $win, ':id' => $id);
	$msql = 'update lottery_data set win=-:win,bet_ok=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit('注单未中奖修改失败' . $id);
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
