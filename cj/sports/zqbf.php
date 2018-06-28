<?php
header('Content-Type:text/html; charset=utf-8');
include_once __DIR__ . '/../include/function.php';
include_once __DIR__ . '/../../class/Db.class.php';
$url = "爱博官网";
$title = "足球 => 比分接收";
$jilu="";
$m = 0;
$count = 0;
$day = date('m-d');
$fast = date('m-d',strtotime("-1 day"));
$sql = 'select Match_ID from bet_match where  Match_CoverDate<now() and (Match_Date=\''.$day.'\' or Match_Date=\''.$fast.'\') and  (MB_Inball< MB_Inball_HR or TG_Inball< TG_Inball_HR or MB_Inball is null or TG_Inball_HR is null)';

$db = new DB(DB::DB4);
$dt = $db->column($sql);
if($dt){
	$client = new rpcclient($cj_url);
	$arr = $client->zqbf($site_id,$dt);

	$arr = a_decode64($arr);//解压
	
	if(is_array($arr) and $arr){
		foreach ($arr as $row) {

			$params = array();
			$commonsql='';
			if((string)$row['MB_Inball_HR'] != 'nnnn'){
				$params['MB_Inball_HR'] = $row['MB_Inball_HR'];
				$commonsql .= ',MB_Inball_HR = :MB_Inball_HR';

				$params['TG_Inball_HR'] = $row['TG_Inball_HR'];
				$commonsql .= ',TG_Inball_HR = :TG_Inball_HR';

				$params['Match_ID'] = $row['Match_ID'];

				if((string)$row['MB_Inball'] != 'nnnn'){
					$params['MB_Inball'] = $row['MB_Inball'];
					$commonsql .= ',MB_Inball = :MB_Inball';

					$params['TG_Inball'] = $row['TG_Inball'];
					$commonsql .= ',TG_Inball = :TG_Inball';
				}

				$sql = 'update bet_Match set Match_LstTime = now() ' . $commonsql . ' where Match_ID=:Match_ID';
				$db->query($sql,$params);
				$count++;
			}
		}
	}else if(!$arr){
		print_r('<br>本次无赛果采集');
	}else{
		print_r('<br>'.$arr);
	}
}	
$db->CloseConnection();
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

<? $limit= rand(20,30);?>
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
       <? if($count==0){?>
	   	<font color="#FF0000"><?=$title?> 本次无赛果采集</font> 
	   <? }else{ ?>
       <font color="#FF0000"><?=$title?> 共采集到 <?=$count?> 条赛果</font> 
       <? } ?>
      </td>
  </tr>
</table>
</body>
</html>
