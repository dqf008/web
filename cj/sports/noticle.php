<?php
header('Content-Type:text/html; charset=utf-8');
include_once __DIR__ . '/../include/function.php';
include_once __DIR__ . '/../../class/Db.class.php';

$url = "爱博官网";
$title = "系统公告";
$msg = '本次无系统公告采集';
$jilu="";
$m = 0;

$time1 = time();
$reTime = 10*60;//采集3*60秒内更新的数据

$client = new rpcclient($cj_url);
$arr = $client->noticle($site_id,$reTime);

$arr = a_decode64($arr);//解压
$db = new DB();
if(is_array($arr) and $arr){
	$count = sizeof($arr);
	foreach ($arr as $row) {
		$exist_row = $db->row('select nid from k_notice_ty where nid=:nid',['nid' => $row['nid']]);
		$params = array();
		$sql = '';
		$commonsql = '';
		$row_i = 0;
		foreach ($row as $key => $value){
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

		if ($exist_row){
			$params['nid1'] = $params[':nid'];
			$sql = 'update mydata1_db.k_notice_ty set ' . $commonsql . ' where nid=:nid1';
		}else{
			$sql = 'insert into mydata1_db.k_notice_ty set ' . $commonsql;
		}
		$db->query($sql,$params);
	}
	$db->CloseConnection();
}else if(!$arr){
	
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
	   	<font color="#FF0000"><?=$title?> <?=$msg?></font> 
	   <? }else{ ?>
       <font color="#FF0000"><?=$title?> 共采集到 <?=$count?> 条系统公告</font> 
       <? } ?>
      </td>
  </tr>
</table>
</body>
</html>
