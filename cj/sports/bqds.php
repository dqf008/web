<?php
header('Content-Type:text/html; charset=utf-8');
include_once __DIR__ . '/../include/function.php';
include_once __DIR__ . '/../../class/Db.class.php';
$url = "爱博官网";
$title = "棒球今日 => 全部盘口";
$jilu="";
$m = 0;


$reTime = 3*60;//采集3*60秒内更新的数据

$client = new rpcclient($cj_url);
$arr = $client->bqds($site_id,$reTime);

$arr = a_decode64($arr);//解压
$db = new DB(DB::DB4);
if(is_array($arr) and $arr){
	$count = sizeof($arr);
	foreach ($arr as $row) {
		$exist_row = $db->row('select id from baseball_match where Match_ID=:Match_ID',['Match_ID' => $row['Match_ID']]);
		$params = array();
		$sql = '';
		$commonsql = '';
		$row_i = 0;
		foreach ($row as $key => $value){
			if (($key != 'ID') && ($key != 'Match_JS') && ($key != 'newBqdsCount')){
				//判断是否为空 而非0
				if((string)$value != 'nnnn'){
					$params[$key] = $value;
					if ($row_i == 0){
						$commonsql .= $key . ' = :' . $key;
					}else{
						$commonsql .= ',' . $key . ' = :' . $key;
					}
					$row_i++;
				}
			}
		}

		if ($exist_row){
			$params['Match_ID2'] = $params['Match_ID'];
			$sql = 'update baseball_match set ' . $commonsql . ' where Match_ID=:Match_ID2 and Match_JS!=1';
		}else{
			$sql = 'insert into baseball_match set ' . $commonsql;
		}
		$db->query($sql,$params);
	}
	$db->CloseConnection();
}else if(!$arr){
	print_r('<br>本次无注单采集');
}else{
	print_r('<br>'.$arr);
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
	   	<font color="#FF0000"><?=$title?> 本次无注单采集</font> 
	   <? }else{ ?>
       <font color="#FF0000"><?=$title?> 共采集到 <?=$count?> 条注单</font> 
       <? } ?>
	   
      </td>
  </tr>
</table>
</body>
</html>
