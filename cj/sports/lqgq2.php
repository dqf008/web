<?php
$useRPC = true;
header('Content-Type:text/html; charset=utf-8');
$C_Patch =$_SERVER['DOCUMENT_ROOT'];
include_once __DIR__ . '/../include/function.php';
include_once __DIR__ . '/../../class/Db.class.php';

$url = "爱博官网";
$title = "篮球 => 滚球写入缓存";
$msg = '本次无篮球滚球数据采集';
$jilu="";
$m = 0;

$client = new rpcclient($cj_url);
$arr = $client->lqgq1($site_id);
$arr = a_decode64($arr);//解压
$db = new DB(DB::DB4);
if(is_array($arr) and $arr){
	$mid_str = $arr['mid_str'];
	if ($mid_str){
		if (!write_file($C_Patch . '/cache/lqgq.php', '<?php ' . stripcslashes($mid_str) . '?>')){
			$msg = '缓存文件写入失败！请先设/cache/lqgq.php文件权限为：0777';
		}else{
			$msg = '篮球滚球数据缓存生成成功！';
		}
	}else{
		$msg = '本次无篮球滚球数据采集';
	}
	$db->query('update gunqiu set mid_str=:mid_str,lasttime=DATE_ADD(now(),INTERVAL 10 SECOND) WHERE id=2',['mid_str' => $mid_str]);
	$db->CloseConnection();
}else if(!$arr){
	$msg = '本次无篮球滚球数据采集';
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

<? $limit= $useRPC?rand(60,60):rand(3,6);?>
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
       <font color="#FF0000"><?=$msg?></font> 
	   
      </td>
  </tr>
</table>
</body>
</html>
