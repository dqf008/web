<?php (empty($_SERVER['HTTP_HOST']) || $_SERVER['HTTP_HOST']=='127.0.0.1') or die('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>真人转帐采集(爱博官网)</title>
<style type="text/css">
*{margin:0;padding:0;}
</style>
<script src="./js/jquery.js"></script>
<script> 
function refresh(){
	$('iframe').each(function(){
		var value = $(this).attr('src');
		var index = value.indexOf('?');
		if(index>0){
			value = value.substring(0,index)
		}
		$(this).attr('src',value+'?'+Math.random())
	});
	setTimeout('refresh()',30000);
}
setTimeout('refresh()',30000);
</script>
</head>

<body>
<table width="100%"   border="2" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td   valign="top"> 
      <iframe width=100% height=200 src='./live/data/z_ag.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height=200 src='./live/data/z_agin.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height=200 src='./live/data/z_hunter.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height=200 src='./live/data/z_bbin.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height=200 src='./live/data/z_og.php' frameborder=0 ></iframe> 
    </td>
  </tr>
  <tr> 
    <td valign="top"> 
      <iframe width=100% height=200 src='./live/data/z_pt.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height=200 src='./live/data/z_shaba.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height=200 src='./live/data/maya.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height=200 src='./live/data/delete.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height=200 src='./sports/delete.php' frameborder=0 ></iframe> 
    </td>
  </tr>
</table>
</body>
</html>
