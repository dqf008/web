<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");

$url = "爱博官网";
$title = "七星彩";
$jilu="";
$m = 0;

$client = new rpcclient($cj_url);	
$arr = $client->qxc(10,$site_id);
$arr = a_decode64($arr);//解压
if(is_array($arr) and $arr){
	ksort($arr);
	foreach($arr as $qishu=>$val){
		$params[':qishu'] = $qishu;
		$params[':kaijiang'] = strtotime(date('Y-m-d 20:30:00', $val['opentime']));
		$params[':value'] = $val['value'];
		$sql = 'INSERT INTO `lottery_k_qxc` (`qishu`, `kaijiang`, `value`, `status`) values (:qishu, :kaijiang, :value, 1) ON DUPLICATE KEY UPDATE `kaijiang`=values(`kaijiang`),`value`=values(`value`),`status`=values(`status`)';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$m=$m+1;
		
		$jilu .= '第'.$qishu.'期：'.implode(',', unserialize($val['value']))."<br>";	
	}
}else{
	print_r($arr);
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

<? $limit= rand(6,15);?>
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
       <font color="#FF0000"><?=$title?> 共采集到<?=$m?>期</font> 
	   <?
		$xianshi = explode("<br>",$jilu);
		foreach(array_reverse($xianshi,true) as $v){
			echo $v."<br>";
		}
	 
	 ?>
      </td>
  </tr>
</table>
</body>
</html>
