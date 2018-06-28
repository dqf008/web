<?php
header('Content-Type:text/html; charset=utf-8');
include_once __DIR__ . '/../include/function.php';
include_once __DIR__ . '/../../class/Db.class.php';
$url = "爱博官网";
$title = "足球早盘 => 全部盘口";
$jilu="";
$m = 0;

$time1 = time();

$reTime = 10*60;//采集10*60秒内更新的数据
$client = new rpcclient($cj_url);
$arr = $client->zqzcds($site_id,$reTime);

$arr = a_decode64($arr);//解压
$db = new DB(DB::DB4);

if(is_array($arr) and $arr){
	$count = sizeof($arr);
	foreach ($arr as $row) {
		$exist_row = $db->row('select id,match_js,match_sbjs from bet_match where Match_ID=:Match_ID',['Match_ID' => $row['Match_ID']]);
		$params = array();
		$sql = '';
		$commonsql = '';

		foreach ($row as $key => $value){
			if (($key != 'ID') && ($key != 'MB_Inball') && ($key != 'TG_Inball') && ($key != 'MB_Inball_HR') && ($key != 'TG_Inball_HR') && ($key != 'Match_JS') && ($key != 'Match_SBJS') && ($key != 'newZqdsCount') && ($key != 'Match_LstTime')){
				//判断是否为空 而非0
				if((string)$value != 'nnnn'){
					$params[$key] = $value;
					$commonsql .= ',' . $key . ' = :' . $key;
				}
			}
		}

		if ($exist_row){
			if (($exist_row['match_js'] != '1') && ($exist_row['match_sbjs'] != '1')){
				
				if((string)$row['MB_Inball'] != 'nnnn'){
					$params['MB_Inball'] = $row['MB_Inball'];
					$commonsql .= ',MB_Inball = :MB_Inball';

					$params['TG_Inball'] = $row['TG_Inball'];
					$commonsql .= ',TG_Inball = :TG_Inball';
				}

				if((string)$row['MB_Inball_HR'] != 'nnnn'){
					$params['MB_Inball_HR'] = $row['MB_Inball_HR'];
					$commonsql .= ',MB_Inball_HR = :MB_Inball_HR';

					$params['TG_Inball_HR'] = $row['TG_Inball_HR'];
					$commonsql .= ',TG_Inball_HR = :TG_Inball_HR';
				}

				$params['Match_ID2'] = $params['Match_ID'];
				$sql = 'update bet_Match set Match_LstTime = now()' . $commonsql . ' where Match_ID=:Match_ID2';
			}else if ($exist_row['match_js'] != '1'){
				if((string)$row['MB_Inball'] != 'nnnn'){
					$params['MB_Inball'] = $row['MB_Inball'];
					$commonsql .= ',MB_Inball = :MB_Inball';
				}

				if((string)$row['TG_Inball'] != 'nnnn'){
					$params['TG_Inball'] = $row['TG_Inball'];
					$commonsql .= ',TG_Inball = :TG_Inball';
				}
				
				$params['Match_ID2'] = $params['Match_ID'];
				$sql = 'update bet_Match set Match_LstTime = now()' . $commonsql . ' where Match_ID=:Match_ID2';
			}else{
				$sql = '';
			}
		}else{
			if((string)$row['MB_Inball'] != 'nnnn'){
				$params['MB_Inball'] = $row['MB_Inball'];
				$commonsql .= ',MB_Inball = :MB_Inball';

				$params['TG_Inball'] = $row['TG_Inball'];
				$commonsql .= ',TG_Inball = :TG_Inball';

			}

			if((string)$row['MB_Inball_HR'] != 'nnnn'){
				$params['MB_Inball_HR'] = $row['MB_Inball_HR'];
				$commonsql .= ',MB_Inball_HR = :MB_Inball_HR';

				$params['TG_Inball_HR'] = $row['TG_Inball_HR'];
				$commonsql .= ',TG_Inball_HR = :TG_Inball_HR';

			}
			
			$sql = 'insert into bet_Match set Match_LstTime = now()' . $commonsql;
		}

		if ($sql){
			$db->query($sql,$params);
			$msg++;
		}
	}
	$db->CloseConnection();
}else if(!$arr){
	print_r('<br>本次无注单采集');
}else{
	print_r('<br>'.$arr);
}

$time2 = time();

$uptime =  '本次执行时间为'.($time2-$time1).'秒';
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

var limit="600"
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
	   <font color="#FF0000"><?=$uptime?> <br></font>
       <? if($count==0){?>
	   	<font color="#FF0000"><?=$title?> 本次无注单采集</font> 
	   <? }else{ ?>
       <font color="#FF0000"><?=$title?> 共采集到 <?=$count?> 条注单</font> 
       <? } ?>
      </td>
  </tr>
</table>
</body>
</html>
