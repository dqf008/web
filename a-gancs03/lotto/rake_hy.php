<?php 
if (!defined('PHPYOU_VER')){
	exit('非法进入');
}

if ($_GET['save'] == 'save'){
	$mydata2_db->query('update ka_bl set rate=mrate,blrate=mrate');
	echo "<script>alert('赔率默认还原成功!');window.location.href='index.php?action=rake_hy';</script>";
}
?>
<link rel="stylesheet" href="images/xp.css" type="text/css"> 
<script language="javascript" type="text/javascript" src="js_admin.js"></script> 
 

<SCRIPT language=JAVASCRIPT> 
if(self == top) {location = '/';}  
if(window.location.host!=top.location.host){top.location=window.location;}  



</SCRIPT> 

<table width="100%" border="0" cellspacing="0" cellpadding="5"> 
<tr class="tbtitle"> 
  <td width="100%"><?php require_once 'retop.php';?></td> 
</tr> 
<tr > 
  <td height="5" colspan="2"></td> 
</tr> 
</table> 
<table width="99%" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="f1f1f1" class="about"> 
 
<tr> 
  <td bordercolor="cccccc" bgcolor="#FDF4CA">还原赔率</td> 
</tr> 
<tr> 
  <td height="50" align="center" bordercolor="cccccc"><button onclick="javascript:if(confirm('您确定要还原吗？本操作将无法恢复！')){location.href='index.php?action=rake_hy&amp;save=save'}"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:200;height:22" ><img src="images/address.gif" width="16" height="16" align="absmiddle" />&nbsp;&nbsp;<font color="ff0000">还原默认赔率</font></button></td> 
</tr> 
</table> 
<div align="center"> 
<table width="98%" border="0" cellspacing="0" cellpadding="0"> 
  <tr> 
	<td width="70"><div align="left"> </div></td> 
	<td height="35"><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> 提示：请小心还原,一但还原本操作将无法恢复.</div></td> 
  </tr> 
</table> 
<br> 
<br> 
</div> 
