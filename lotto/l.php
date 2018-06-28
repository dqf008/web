<?php 
include '../include/lottery.inc.php';
if (!defined('PHPYOU_VER')){
	exit('非法进入');
}
?> 
<html> 
<head> 
<link href="imgs/main_n1.css" rel="stylesheet" type="text/css"> 
<style type="text/css"> 
<!-- 
body { 
  margin-left: 10px;
  margin-top: 10px;
} 
.STYLE1 {color: #FFFFFF} 
#right_1 { 
  width: 780px;} 
  #index02_title { 
  width: 780px;
  height: 30px;
  border-bottom: 1px solid #000;
  color: #fff;
  background: #142F06;
} 
.bg { 
  background: url(/images/right_1.jpg) no-repeat left;
  width: 119px;
  height: 30px;
  line-height: 30px;
  font-weight: bold;
  float: left;
  padding: 0 0 0 24px;
} 
--> 
</style> 

<SCRIPT language=JAVASCRIPT> 
if(self == top) {location = '/';}  
if(window.location.host!=top.location.host){top.location=window.location;}  
</SCRIPT> 

</head> 
<body> 
<noscript> 
<iframe scr=″*.htm″></iframe> 
</noscript> 

<div align="center"> 
<div id="right_1"> 
<!--gonggao--> 
<!--gonggao end of--> 
<!--shuaxin--> 

<!--shuaxin end of--> 
<!--shuzi--> 
<div id="shuzi"> 


</div> 
<!--shuzi end of--> 
</div> 
<!--right_2--> 


<table  width="780" border="0" cellspacing="0" cellpadding="0" align="left"> 

   
<tr>  
  <td> 
		<table width="780"   border="0" cellpadding="0" cellspacing="1" class="t_list"> 
		  <form target="leftFrame" name="lt_form"  method="post" action="n1.asp?class2=<%=ids%>">  

			<tr> 
			  <td width="30"  class="t_list_caption" height="25" align="center" nowrap="nowrap"><span class="STYLE5">序号</span></td> 
			<td width="20%"  class="t_list_caption" align="center" nowrap="nowrap" ><span class="STYLE5">日期</span></td> 
			<td width="20%"  class="t_list_caption" align="center" nowrap="nowrap" ><span class="STYLE5">期数</span></td> 
			 
			<td width="20%"  class="t_list_caption" align="center" nowrap="nowrap" ><span class="STYLE5">金额</span></td> 
			<td width="20%"  class="t_list_caption" align="center" nowrap="nowrap">退水</td> 
			<td width="20%"  class="t_list_caption" align="center" nowrap="nowrap"><span class="STYLE5">结果</span></td> 
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
$d = array('日', '一', '二', '三', '四', '五', '六');
$result = $mydata2_db->query('Select nd,nn from ka_kithe where  na<>0 and score=1 order by nn desc');
$ii = 0;
while ($rs = $result->fetch())
{
$ii++;
$params = array(':username' => $_SESSION['username'], ':kithe' => $rs['nn']);
$stmt = $mydata2_db->prepare('Select sum(sum_m) as sum_m, count(*) as re, sum(sum_m*dagu_zc/10) as dagu_zc, sum(sum_m*guan_zc/10) as guan_zc, sum(sum_m*zong_zc/10) as zong_zc, sum(sum_m*dai_zc/10) as dai_zc from ka_tan where username=:username and kithe=:kithe');
$stmt->execute($params);
$Rs5 = $stmt->fetch();
$params = array(':username' => $_SESSION['username'], ':kithe' => $rs['nn']);
$stmt = $mydata2_db->prepare('Select sum(sum_m*dai_zc/10-sum_m*rate*dai_zc/10+sum_m*(dai_ds-user_ds)/100*(10-dai_zc)/10-sum_m*user_ds/100*(dai_zc)/10) as daisf, sum(sum_m*zong_zc/10-sum_m*rate*zong_zc/10+sum_m*(zong_ds-dai_ds)/100*(10-zong_zc-dai_zc)/10-sum_m*dai_ds/100*(zong_zc)/10) as zongsf, sum(sum_m*guan_zc/10-sum_m*rate*guan_zc/10+sum_m*(guan_ds-zong_ds)/100*(10-guan_zc-zong_zc-dai_zc)/10-sum_m*zong_ds/100*(guan_zc)/10) as guansf, sum(sum_m*rate-sum_m+sum_m*Abs(user_ds)/100) as sum_m, sum(sum_m*dagu_zc/10) as dagu_zc, sum(sum_m*guan_zc/10) as guan_zc, sum(sum_m*zong_zc/10) as zong_zc, sum(sum_m*dai_zc/10) as dai_zc, sum(sum_m*Abs(user_ds)/100) as user_ds, sum(sum_m*Abs(guan_ds-zong_ds)/100*(10-guan_zc-zong_zc-dai_zc)/10) as guan_ds, sum(sum_m*Abs(zong_ds-dai_ds)/100*(10-zong_zc-dai_zc)/10) as zong_ds, sum(sum_m*Abs(dai_ds-user_ds)/100*(10-dai_zc)/10) as dai_ds from ka_tan where username=:username and kithe=:kithe and bm=1');
$stmt->execute($params);
$Rs6 = $stmt->fetch();
$params = array(':username' => $_SESSION['username'], ':kithe' => $rs['nn']);
$stmt = $mydata2_db->prepare('Select sum(sum_m*Abs(dai_ds-user_ds)/100*(10-dai_zc)/10+sum_m*dai_zc/10-sum_m*(dai_zc)/10*user_ds/100) as daisf, sum(sum_m*Abs(zong_ds-dai_ds)/100*(10-zong_zc-dai_zc)/10+sum_m*zong_zc/10-sum_m*(zong_zc)/10*dai_ds/100) as zongsf, sum(sum_m*Abs(guan_ds-zong_ds)/100*(10-guan_zc-zong_zc-dai_zc)/10+sum_m*guan_zc/10-sum_m*guan_zc/10*zong_ds/100) as guansf, sum(sum_m*Abs(user_ds)/100-sum_m) as sum_m, sum(sum_m*dagu_zc/10) as dagu_zc, sum(sum_m*guan_zc/10) as guan_zc, sum(sum_m*zong_zc/10) as zong_zc, sum(sum_m*dai_zc/10) as dai_zc, sum(sum_m*Abs(user_ds)/100) as user_ds, sum(sum_m*Abs(guan_ds-zong_ds)/100*(10-guan_zc-zong_zc-dai_zc)/10) as guan_ds, sum(sum_m*Abs(zong_ds-dai_ds)/100*(10-zong_zc-dai_zc)/10) as zong_ds, sum(sum_m*Abs(dai_ds-user_ds)/100*(10-dai_zc)/10) as dai_ds from ka_tan where username=:username and kithe=:kithe and bm=0');
$stmt->execute($params);
$Rs7 = $stmt->fetch();
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
$zz_sf += -$usersf - $daisf;
$zong_sf += -$usersf - $zongsf - $daisf;
$dai_sf += -$usersf - $daisf;
if (0 < $Rs5['sum_m'])
{
	$ci++;
?>              
	   
			<tr <? if($ci%2==1){ ?>class="t_list_tr_0"<? }else{ ?>class="t_list_tr_1"<? } ?> onMouseOut="this.style.backgroundColor=''" onMouseOver="this.style.backgroundColor='#fac906'">
                <td height="25" align="center" nowrap="nowrap" ><?=$ci?></td>
                <td align="center" nowrap ><A 
                        href="index.php?action=list&kithe=<?=$rs['nn']?>">
                <b>
                <?=substr($rs['nd'],0,10)?>
                
                     <?
    
  echo  "星期".$d[date("w",strtotime($rs['nd']))];  
?>
                </b></A></td>
                <td align="center" ><font color=ff0000><?=$rs['nn']?>期</font></td>
              
                <td align="center" nowrap="nowrap" ><b><font color=ff0000><A 
                        href="index.php?action=list&kithe=<?=$rs['nn']?>"><?=$Rs5['sum_m']?></A></font></b></td>
                <td align="center" nowrap="nowrap" ><?=$Rs6['user_ds']+$Rs7['user_ds']?></td>
                <td align="center" nowrap="nowrap" ><b><font color="#FF0000"><?=number_format($Rs6['sum_m']+$Rs7['sum_m'],2)?></font></b></td>
              </tr>
                 
              <? }
               }?>
              <tr class="t_list_tr_sum">
                <td colspan="3" align="center" nowrap="nowrap" ><span class="STYLE4">小计</span></td>
               
                <td align="center" nowrap="nowrap" ><span class="STYLE4">
                <?=$z_sum?>
                </span></td>
                <td align="center" nowrap="nowrap"><span class="STYLE4">
                <?=$z_userds?>
                </span></td>
                <td align="center" nowrap="nowrap"><span class="STYLE4">
                <?=$z_usersf?>
                </span></td>
              </tr>
            </form>
      </table>
    
      <div align="center"><br>
        <br>
      </div>    </td>
  </tr>
</table>
</body>
</html>