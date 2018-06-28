<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>足球结算</title>
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
		//	timeinfo.innerText=curtime 
			setTimeout("beginrefresh()",1500) 
	} 
} 
window.onload=beginrefresh 
//--> 
</script>
<table width="400" height="450"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
	<td width="200" height="90" valign="top"> 
      <iframe width="200" height=90 src='zqauto.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="200" height="90" valign="top"> 
      <iframe width="200" height=90 src='zqsbauto.php' frameborder=0 scrolling="no"></iframe> 
    </td>
  </tr>
  <tr>
    <td width="200" height="90" valign="top">
	  <iframe width="200" height=90 src='lqauto.php' frameborder=0 scrolling="no"></iframe> 
    </td>
	<td width="200" height="90" valign="top"> 
      <iframe width="200" height=90 src='bqauto.php' frameborder=0 scrolling="no"></iframe> 
    </td>
  </tr>
  <tr>
    <td width="200" height="90" valign="top"> 
      <iframe width="200" height=90 src='pqauto.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td width="200" height="90" valign="top">
	  <iframe width="200" height=90 src='wqauto.php' frameborder=0 scrolling="no"></iframe> 
    </td>
  </tr>
  <tr> 
	<td width="200" height="90" valign="top"> 
      <iframe width="200" height=90 src='jrgjjs.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td height="90" valign="top">
	  <iframe width="200" height=140 src='onlineupdate.php' frameborder=0 scrolling="no"></iframe>
    </td>
  </tr>
  <tr> 
  <td width="200" height="90" valign="top"> 
      <iframe width="200" height=90 src='autosaveuser.php' frameborder=0 scrolling="no"></iframe> 
    </td>
    <td height="90" valign="top">
    <iframe width="200" height=140 src='autodata.php' frameborder=0 scrolling="no"></iframe>
    </td>
  </tr>
</table>
</body>
</html>