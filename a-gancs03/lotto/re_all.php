<?php 
if (!defined('PHPYOU')){
	exit('非法进入');
}
$stime = $_POST['txt8'] . ' 00:00:00';
$etime = $_POST['txt9'] . ' 23:59:59';
if (($_GET['kithe'] != '') || ($_POST['kithe'] != '')){
	if ($_GET['kithe'] != ''){
		$kithe = $_GET['kithe'];
	}else{
		$kithe = $_POST['kithe'];
	}
}
?>
<link rel="stylesheet" href="images/xp.css" type="text/css"> 
<script language="javascript" type="text/javascript" src="js_admin.js"></script>  
<style type="text/css"> 
<!-- 
.style1 { 
  color: #666666;
  font-weight: bold;
} 
.style2 {color: #FF0000} 
.STYLE3 { font-weight: bold;} 
.STYLE4 {color: #0000FF} 
.STYLE5 {color: #FFFFFF;
  font-weight: bold;
} 
.STYLE6 {color: #FFFFFF} 
--> 
</style> 
<div align="center"> 

<script language="JavaScript" type="text/JavaScript"> 
function SelectAllPub() { 
  for (var i=0;i<document.form1.flag.length;i++) { 
	  var e=document.form1.flag[i];
	  e.checked=!e.checked;
  } 
} 
function SelectAllAdm() { 
  for (var i=0;i<document.form1.flag.length;i++) { 
	  var e=document.form1.flag[i];
	  e.checked=!e.checked;
  } 
} 
</script> 



<table width="100%" border="0" cellspacing="0" cellpadding="5"> 
<tr class="tbtitle"> 
  <td width="7%"><span class="STYLE5">报表查询</span></td> 
  <td width="1%">&nbsp;</td> 
  <td width="92%"><table border="0" align="center" cellspacing="0" cellpadding="1" bordercolor="888888" bordercolordark="#FFFFFF" width="98%"> 
	<tr> 
	  <td width="61%"><span class="STYLE6">&nbsp;&nbsp;&nbsp;当前报表--&gt;&gt;<?php if ($kithe != ''){?>查第<?=$kithe;?>期<?php }else{?>日期区间：<?=$_POST['txt8'];?>-----<?=$_POST['txt9'];}?> &nbsp;&nbsp;&nbsp;&nbsp;投注品种：<?php if ($_POST['class2'] != ''){echo $_POST['class2'];}else{?>全部<?php }?></span> </td> 
	  <td width="39%"><div align="right"> 
		<button type="button" onclick="javascript:location.href='index.php?action=re_pb'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:100;height:22" ><img src="images/cal_date_picker.gif" width="15" height="12" align="absmiddle" />返回报表</button> 
		<button type="button" onclick="javascript:window.print();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ><img src="images/asp.gif" width="16" height="12" align="absmiddle" />打印</button> 
	  </div></td> 
	</tr> 
  </table></td> 
</tr> 
<tr > 
  <td height="5" colspan="3"></td> 
</tr> 
</table> 
<table id="tb"  border="1" align="center" cellspacing="1" cellpadding="1" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%"> 
<tr > 
  <td width="4%" rowspan="2" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA" >序号</td> 
  <td rowspan="2" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">股东</td> 
  <td rowspan="2" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">注数</td> 
  <td rowspan="2" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">下注金额</td> 
  <td height="28" colspan="2" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">会&nbsp;&nbsp;员</td> 
  <td colspan="3" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">股&nbsp;&nbsp;&nbsp;&nbsp;东</td> 
  <td rowspan="2" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" ><span class="STYLE4">股东上交</span></td> 
  <td rowspan="2" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="style2">公司收付</td> 
</tr> 
<tr > 
  <td height="28" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">会员佣金</td> 
  <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="style2">会员收付</td> 
  <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">股东佣金</td> 
  <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">股东成数</td> 
  <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="style2">股东收付</td> 
  </tr>
<?php 
$z_re = 0;
$z_sum = 0;
$z_dagu = 0;
$z_guan = 0;
$z_zong = 0;
$z_dai = 0;
$z_userds = 0;
$z_guands = 0;
$z_zongds = 0;
$z_daids = 0;
$z_usersf = 0;
$z_guansf = 0;
$z_zongsf = 0;
$z_daisf = 0;
$zz_sf = 0;
$params = array();
$vvv = 'where 1=1';
if ($kithe != ''){
	$params[':kithe'] = $kithe;
	$vvv .= ' and kithe=:kithe ';
}else if (($_POST['txt8'] != '') && ($_POST['txt9'] != '')){
	$stime = $_POST['txt8'] . ' 00:00:00';
	$etime = $_POST['txt9'] . ' 23:59:59';
	$params[':stime'] = $stime;
	$params[':etime'] = $etime;
	$vvv .= ' and adddate>=:stime and adddate<=:etime ';
}else{
	$params[':kithe'] = $kithe;
	$vvv .= ' and Kithe=:kithe ';
}

if ($_POST['class2'] != ''){
	$params[':class2'] = $_POST['class2'];
	$vvv .= ' and class2=:class2 ';
}

$result = $mydata2_db->prepare('select distinct(guan)   from   ka_tan ' . $vvv . '  order by guan desc');
$result->execute($params);
$ii = 0;
while ($rs = $result->fetch()){
	$params[':guan'] = $rs['guan'];
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re,sum(sum_m*dagu_zc/10) as dagu_zc,sum(sum_m*guan_zc/10) as guan_zc,sum(sum_m*zong_zc/10) as zong_zc,sum(sum_m*dai_zc/10) as dai_zc from ka_tan ' . $vvv . ' and guan=:guan');
	$result1->execute($params);
	$Rs5 = $result1->fetch();
	
	$result2 = $mydata2_db->prepare('Select sum(sum_m*dai_zc/10-sum_m*rate*dai_zc/10+sum_m*(dai_ds-user_ds)/100*(10-dai_zc)/10-sum_m*user_ds/100*(dai_zc)/10) as daisf,sum(sum_m*zong_zc/10-sum_m*rate*zong_zc/10+sum_m*(zong_ds-dai_ds)/100*(10-zong_zc-dai_zc)/10-sum_m*dai_ds/100*(zong_zc)/10) as zongsf,sum(sum_m*guan_zc/10-sum_m*rate*guan_zc/10+sum_m*(guan_ds-zong_ds)/100*(10-guan_zc-zong_zc-dai_zc)/10-sum_m*zong_ds/100*(guan_zc)/10) as guansf,sum(sum_m*rate-sum_m+sum_m*Abs(user_ds)/100) as sum_m,sum(sum_m*dagu_zc/10) as dagu_zc,sum(sum_m*guan_zc/10) as guan_zc,sum(sum_m*zong_zc/10) as zong_zc,sum(sum_m*dai_zc/10) as dai_zc,sum(sum_m*Abs(user_ds)/100) as user_ds,sum(sum_m*Abs(guan_ds-zong_ds)/100*(10-guan_zc-zong_zc-dai_zc)/10) as guan_ds,sum(sum_m*Abs(zong_ds-dai_ds)/100*(10-zong_zc-dai_zc)/10) as zong_ds,sum(sum_m*Abs(dai_ds-user_ds)/100*(10-dai_zc)/10) as dai_ds from ka_tan   ' . $vvv . ' and bm=1 and guan=:guan');
	$result2->execute($params);
	$Rs6 = $result2->fetch();
	
	$result3 = $mydata2_db->prepare('Select sum(sum_m*Abs(dai_ds-user_ds)/100*(10-dai_zc)/10+sum_m*dai_zc/10-sum_m*(dai_zc)/10*user_ds/100) as daisf,sum(sum_m*Abs(zong_ds-dai_ds)/100*(10-zong_zc-dai_zc)/10+sum_m*zong_zc/10-sum_m*(zong_zc)/10*dai_ds/100) as zongsf,sum(sum_m*Abs(guan_ds-zong_ds)/100*(10-guan_zc-zong_zc-dai_zc)/10+sum_m*guan_zc/10-sum_m*guan_zc/10*zong_ds/100) as guansf,sum(sum_m*Abs(user_ds)/100-sum_m) as sum_m,sum(sum_m*dagu_zc/10) as dagu_zc,sum(sum_m*guan_zc/10) as guan_zc,sum(sum_m*zong_zc/10) as zong_zc,sum(sum_m*dai_zc/10) as dai_zc,sum(sum_m*Abs(user_ds)/100) as user_ds,sum(sum_m*Abs(guan_ds-zong_ds)/100*(10-guan_zc-zong_zc-dai_zc)/10) as guan_ds,sum(sum_m*Abs(zong_ds-dai_ds)/100*(10-zong_zc-dai_zc)/10) as zong_ds,sum(sum_m*Abs(dai_ds-user_ds)/100*(10-dai_zc)/10) as dai_ds from ka_tan   ' . $vvv . ' and bm=0 and guan=:guan');
	$result3->execute($params);
	$Rs7 = $result3->fetch();
	
	$ii++;
	$re = $Rs5['re'];
	$sum_m = $Rs5['sum_m'];
	$dagu_zc = $Rs5['dagu_zc'];
	$guan_zc = $Rs5['guan_zc'];
	$zong_zc = $Rs5['zong_zc'];
	$dai_zc = $Rs5['dai_zc'];
	$z_usersf += $Rs6['sum_m'] + $Rs7['sum_m'];
	$z_guansf += $Rs6['guansf'] + $Rs7['guansf'];
	$z_zongsf += $Rs6['zongsf'] + $Rs7['zongsf'];
	$z_daisf += $Rs6['daisf'] + $Rs7['daisf'];
	$z_re += $Rs5['re'];
	$z_sum += $Rs5['sum_m'];
	$z_dagu += $Rs5['dagu_zc'];
	$z_guan += $Rs5['guan_zc'];
	$z_zong += $Rs5['zong_zc'];
	$z_dai += $Rs5['dai_zc'];
	$z_userds += $Rs6['user_ds'] + $Rs7['user_ds'];
	$z_guands += $Rs6['guan_ds'] + $Rs7['guan_ds'];
	$z_zongds += $Rs6['zong_ds'] + $Rs7['zong_ds'];
	$z_daids += $Rs6['dai_ds'] + $Rs7['dai_ds'];
	$usersf = $Rs6['sum_m'] + $Rs7['sum_m'];
	$guansf = $Rs6['guansf'] + $Rs7['guansf'];
	$zongsf = $Rs6['zongsf'] + $Rs7['zongsf'];
	$daisf = $Rs6['daisf'] + $Rs7['daisf'];
	$zz_sf += -$usersf - $guansf - $zongsf - $daisf;
	
	$paramsSub = array(':kauser' => $rs['guan']);
	$result2 = $mydata2_db->prepare('select * from ka_guan where  kauser=:kauser order by id');
	$result2->execute($paramsSub);
	$row11 = $result2->fetch();
	if ($row11 != ''){
		$xm = '<font color=ff6600> (' . $row11['xm'] . ')</font>';
	}
?>   
<tr> 
  <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=$ii?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['guan']?>
        <?=$xm?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$Rs5['re']?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><button onclick="javascript:location.href='index.php?action=re_guan&amp;kithe=<?=$kithe?>&amp;username=<?=$rs['guan']?>&amp;txt9=<?=$_POST['txt9']?>&amp;txt8=<?=$_POST['txt8']?>&amp;class2=<?=$_POST['class2']?>'"  class="headtd4" style="width:80;height:22" ;><font color="0000ff">
      <?=$Rs5['sum_m']?>
    </font></button></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=number_format(($Rs6['user_ds']+$Rs7['user_ds']), 2)?></td>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc" class="style2" style="color:<? if (($Rs6['sum_m']+$Rs7['sum_m'])>0) echo 'black'; else echo 'red'; ?>;"><?=number_format(($Rs6['sum_m']+$Rs7['sum_m']), 2)?></td>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=number_format(($Rs6['guan_ds']+$Rs7['guan_ds']), 2)?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" class="style2" style="color:<? if (($Rs6['guansf']+$Rs7['guansf']-$Rs6['guan_ds']-$Rs7['guan_ds'])>0) echo 'black'; else echo 'red'; ?>;"><?=number_format(($Rs6['guansf']+$Rs7['guansf']-$Rs6['guan_ds']-$Rs7['guan_ds']), 2)?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" class="style2" style="color:<? if (($Rs6['guansf']+$Rs7['guansf'])>0) echo 'black'; else echo 'red'; ?>;"><?=number_format(($Rs6['guansf']+$Rs7['guansf']), 2)?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><span class="STYLE4" style="color:<? if ((0-$usersf-$guansf-$zongsf-$daisf)>0) echo 'black'; else echo 'red'; ?>;">   <?=number_format((0-$usersf-$guansf-$zongsf-$daisf), 2)?>   </span> </td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" class="style2" style="color:<? if ((0-$usersf-$guansf-$zongsf-$daisf)>0) echo 'black'; else echo 'red'; ?>;"><?=number_format((0-$usersf-$guansf-$zongsf-$daisf), 2)?></td>
</tr>
<?php }?>   
<tr > 
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA" class="STYLE3">总计</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA" class="STYLE3"><?=$z_re?> </td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA" class="STYLE3"><?=$z_sum?></span></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA" class="STYLE3"><span class="STYLE3">  <?=number_format($z_userds, 2)?>    </span></td>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA" class="STYLE3" style="color:<? if ($z_usersf>0) echo 'black'; else echo 'red'; ?>;"><?=number_format($z_usersf, 2)?></td>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA" class="STYLE3"><span class="STYLE3">   <?=number_format($z_guands, 2)?>    </span></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA" class="STYLE3"><span style="color:<? if ($z_guansf>0) echo 'black'; else echo 'red'; ?>;">  <?=number_format($z_guansf-$z_guands, 2)?>   </span></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA" class="STYLE3"><span style="color:<? if ($z_guansf>0) echo 'black'; else echo 'red'; ?>;">  <?=number_format($z_guansf, 2)?>   </span></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA" class="STYLE3" style="color:<? if ($zz_sf>0) echo 'black'; else echo 'red'; ?>;"><?=number_format($zz_sf, 2)?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA" class="STYLE3" style="color:<? if ($zz_sf>0) echo 'black'; else echo 'red'; ?>;"><?=number_format($zz_sf, 2)?></td>
</tr> 
</table> 
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center"> 
<tr> 
  <td><div align="left"> </div></td> 
  <td height="35"><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> 操作提示：<font color="ff0000">收付金额</font>已经算佣金进去了！</div></td> 
</tr> 
</table> 
</div> 
