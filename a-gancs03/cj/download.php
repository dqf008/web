<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
<title>足球接收</title> 
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
</style> 
</head> 
<body> 
<script> 
<!-- 
var limit="6:00" 
if (document.images){ 
  var parselimit=limit.split(":") 
  parselimit=parselimit[0]*60+parselimit[1]*1 
} 
function beginrefresh(){ 
  if (!document.images) 
	  return 
  if (parselimit==1) 
	  window.location.reload() 
  else{ 
	  parselimit-=1 
	  curmin=Math.floor(parselimit/60) 
	  cursec=parselimit%60 
	  if (curmin!=0) 
		  curtime=curmin+"分"+cursec+"秒后自动登陆！" 
	  else 
		  curtime=cursec+"秒后自动登陆！" 
	  //  	  timeinfo.innerText=curtime 
		  setTimeout("beginrefresh()",1500) 
  } 
} 
window.onload=beginrefresh 
//--> 
</script> 
<table width="300" height="270"  border="0" align="center" cellpadding="0" cellspacing="0"> 
<tr> 
  <td width="150" height="90" valign="top"> 
	<iframe width="150" height="90" src='zqds.php' frameborder="0" scrolling="no"></iframe> 
  </td> 
  <td width="150" height="90" valign="top"> 
	<iframe width="150" height="90" src='zqgqsj.php' frameborder="0" scrolling="no"></iframe> 
  </td> 
</tr> 
<tr> 
  <td width="150" height="90" valign="top"> 
	<iframe width="150" height="90" src='lqds.php' frameborder="0" scrolling="no"></iframe> 
  </td> 
  <td width="150" height="90" valign="top"> 
	<iframe width="150" height="90" src='lqgqsj.php' frameborder="0" scrolling="no"></iframe> 
  </td> 
</tr> 
<tr> 
  <td width="150" height="90" valign="top"> 
	<iframe width="150" height="90" src='wqds.php' frameborder="0" scrolling="no"></iframe> 
  </td> 
  <td width="150" height="90" valign="top"> 
	<iframe width="150" height="90" src='pqds.php' frameborder="0" scrolling="no"></iframe> 
  </td> 
</tr> 
<tr> 
  <td width="150" height="90" valign="top"> 
	<iframe width="150" height="90" src='bqds.php' frameborder="0" scrolling="no"></iframe> 
  </td> 
  <td width="150" height="90" valign="top"> 
	<iframe width="150" height="90" src='gjsj.php' frameborder="0" scrolling="no"></iframe> 
  </td> 
</tr> 
<tr> 
  <td width="150" height="90" valign="top"> 
	<iframe width="150" height="90" src='zqgq2.php' frameborder="0" scrolling="no"></iframe> 
  </td> 
  <td width="150" height="90" valign="top"> 
	<iframe width="150" height="90" src='lqgq2.php' frameborder="0" scrolling="no"></iframe> 
  </td> 
</tr> 
</table> 
</body> 
</html>