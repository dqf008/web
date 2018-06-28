<?php (empty($_SERVER['HTTP_HOST']) || $_SERVER['HTTP_HOST']=='127.0.0.1') or die('Access Denied'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>足球结算</title>
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
<table width="400" height="450"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
	<td width="200" height="90" valign="top"> 
      <iframe width="200" height=90 src='./auto/zqauto.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="200" height="90" valign="top"> 
      <iframe width="200" height=90 src='./auto/zqsbauto.php' frameborder=0 scrolling="no"></iframe> 
    </td>
  </tr>
  <tr>
    <td width="200" height="90" valign="top">
	  <iframe width="200" height=90 src='./auto/lqauto.php' frameborder=0 scrolling="no"></iframe> 
    </td>
	<td width="200" height="90" valign="top"> 
      <iframe width="200" height=90 src='./auto/bqauto.php' frameborder=0 scrolling="no"></iframe> 
    </td>
  </tr>
  <tr>
    <td width="200" height="90" valign="top"> 
      <iframe width="200" height=90 src='./auto/pqauto.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="200" height="90" valign="top">
	  <iframe width="200" height=90 src='./auto/wqauto.php' frameborder=0 scrolling="no"></iframe> 
    </td>
  </tr>
  <tr> 
	<td width="200" height="90" valign="top"> 
      <iframe width="200" height=90 src='./auto/jrgjjs.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td height="90" valign="top">
	  <iframe width="200" height=140 src='./auto/onlineupdate.php' frameborder=0 scrolling="no"></iframe>
    </td>
  </tr>
  <tr> 
  <td width="200" height="90" valign="top"> 
      <iframe width="200" height=90 src='./auto/autosaveuser.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td height="90" valign="top">
    <iframe width="200" height=140 src='./auto/autodata.php' frameborder=0 scrolling="no"></iframe>
    </td>
  </tr>
</table>
</body>
</html>