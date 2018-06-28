<?php (empty($_SERVER['HTTP_HOST']) || $_SERVER['HTTP_HOST']=='127.0.0.1') or die('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>体育接水(爱博官网)</title>
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
  	<td  height="150" valign="top"> 
      <iframe width=100% height="150" src='./sports/zqds.php' frameborder=0 ></iframe> 
    </td>
  	<td valign="top"> 
      <iframe width=100% height="150" src='./sports/zqgqsj.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height="150" src='./sports/zqgq2.php' frameborder=0 ></iframe> 
    </td>
  	<td valign="top"> 
      <iframe width=100% height="150" src='./sports/zqzcds.php' frameborder=0 ></iframe> 
    </td>
  	<td valign="top"> 
      <iframe width=100% height="150" src='./sports/wqds.php' frameborder=0 ></iframe> 
    </td>
  	<td valign="top"> 
      <iframe width=100% height="150" src='./sports/pqds.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height="150" src='./sports/noticle.php' frameborder=0 ></iframe> 
    </td>
  </tr>
  <tr> 
    <td  height="150" valign="top"> 
      <iframe width=100% height="150" src='./sports/lqds.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height="150" src='./sports/lqgqsj.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height="150" src='./sports/lqgq2.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height="150" src='./sports/lqzcds.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height="150" src='./sports/bqds.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
      <iframe width=100% height="150" src='./sports/gjjs.php' frameborder=0 ></iframe> 
    </td>
    <td valign="top"> 
    </td>

  </tr>
  <tr> 
    <td valign="top"> 
      <iframe width=100% height="150" src='./sports/zqbf.php' frameborder=0 ></iframe> 
    </td>
    <td  height="150" valign="top"> 
      <iframe width=100% height="150" src='./sports/lqbf.php' frameborder=0 ></iframe> 
    </td>
    <td  height="150" valign="top"> 
      <iframe width=100% height="150" src='./sports/wqbf.php' frameborder=0 ></iframe> 
    </td>
    <td  height="150" valign="top"> 
      <iframe width=100% height="150" src='./sports/bqbf.php' frameborder=0 ></iframe> 
    </td>
    <td  height="150" valign="top"> 
      <iframe width=100% height="150" src='./sports/pqbf.php' frameborder=0 ></iframe> 
    </td>
  </tr>
</table>
</body>
</html>
