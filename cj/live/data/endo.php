<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
include_once ("livedata.php");

$type = 'ENDO';
$url = "爱博官网";
$title = "今日注单 => AG-ENDO电子";
$table = 'endobetdetail';
$msg = 0;

$result = livedatas($type,$table);
if(is_array($result) and $result){
  if($result['info']=='ok'){
    $msg = $result['count'];
  }
}else{
  print_r($result);
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
      <? if($msg==0){?>
      <font color="#FF0000"><?=$title?> <br>本次无注单采集</font> 
      <? }else{ ?>
      <font color="#FF0000"><?=$title?> <br>共采集到<?=$msg?>条注单</font> 
      <? } ?>
      </td>
  </tr>
</table>
</body>
</html>