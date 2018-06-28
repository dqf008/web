<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");
//echo date('Y-m-d H:i:s',time()+12*3600);
$start = strtotime(date('Y-m-d 21:25:00'))+12*3600;
$end = strtotime(date('Y-m-d 21:40:00'))+12*3600;
$time = time()+12*3600;
if($time>$end || $time<$start){
	//echo '当前时间'.date('Y-m-d H:i:s',$time).'未到开奖时间暂停采集';
	//exit;
}
$url = "爱博官网";
$title = "六合彩";
$jilu="";
$m = 0;
$client = new rpcclient($cj_url);	
$arr = $client->marksix(100,$site_id);
$arr = a_decode64($arr);//解压
foreach($arr as $k=>$v){
	$info = unserialize($v['value']);
	$number = $info['number'];
	$animal = $info['animal'];
	if($number[6]==0) continue;
	$m ++;
	$res = $mydata2_db->query("select id from ka_kithe where nn=$k and score=0");
	$res = $res->fetch();
	if($res["id"]){
		$sql = sprintf("update ka_kithe set n1=%d,n2=%d,n3=%d,n4=%d,n5=%d,n6=%d,na=%d,x1='%s',x2='%s',x3='%s',x4='%s',x5='%s',x6='%s',sx='%s' where id=%d",$number[0],$number[1],$number[2],$number[3],$number[4],$number[5],$number[6],$animal[0],$animal[1],$animal[2],$animal[3],$animal[4],$animal[5],$animal[6],$res["id"]);
		$mydata2_db->exec($sql);
	}
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