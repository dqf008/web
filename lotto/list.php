<?php 
if (!defined('PHPYOU_VER'))
{
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
  width: 319px;
  height: 30px;
  line-height: 30px;
  font-weight: bold;
  float: left;
  padding: 0 0 0 4px;
} 
--> 
</style> 
</head> 

<SCRIPT language=JAVASCRIPT> 
if(self == top) {location = '/';}  
if(window.location.host!=top.location.host){top.location=window.location;}  
</SCRIPT> 




<body  oncontextmenu="return false"   onselect="document.selection.empty()" oncopy="document.selection.empty()"> 
<noscript> 
<iframe scr=″*.htm″></iframe> 
</noscript> 

<div id="right_1"> 
<!--gonggao--> 
<!--gonggao end of--> 
<!--shuaxin--> 
<div id="index02_title"> 
   
  <div class="bg"><?=$_GET['kithe'];?>期下注状况</div> 
  <div id="ladong_1"></div> 
</div> 
<!--shuaxin end of--> 
<!--shuzi--> 
<div id="shuzi"> 


</div> 
<!--shuzi end of--> 
</div> 
<!--right_2--> 


<table border="0" cellpadding="0" cellspacing="1" class="t_list" width="780"> 
<tr> 
  <td width="30" class="t_list_caption" align="center" nowrap="nowrap">序号</td> 
<td  class="t_list_caption" height="28" align="center">下注单号</td> 
<td class="t_list_caption" align="center" nowrap="nowrap" >下注时间</td> 
<td height="28" class="t_list_caption" align="center" nowrap="nowrap" >内容</td> 
<td align="center" class="t_list_caption" nowrap="nowrap" >赔率</td> 
<td width="60" class="t_list_caption" align="center" nowrap="nowrap" >金额</td> 
<td width="60" class="t_list_caption" align="center" nowrap="nowrap">佣金</td> 
<td width="60" class="t_list_caption" align="center" nowrap="nowrap">会员收付</td> 
</tr>
<?php 
$z_re = 0;
$z_sum = 0;
$z_dagu = 0;
$z_guan = 0;
$z_zong = 0;
$z_dai = 0;
$re = 0;
$z_user = 0;
$z_userds = 0;
$z_daids = 0;
$params = array(':username' => $_SESSION['username'], ':kithe' => $_GET['kithe']);
$stmt = $mydata2_db->prepare('select * from ka_tan where username=:username and kithe=:kithe order by id desc');
$stmt->execute($params);
$ii = 0;
while ($rs = $stmt->fetch())
{
$ii++;
$z_re++;
$z_sum += $rs['sum_m'];
?>	
<tr  <? if($ii%2==1){ ?>class="t_list_tr_0"<? }else{ ?>class="t_list_tr_1"<? } ?> <? if ($rs['bm']!=1){?>onMouseOut="this.style.backgroundColor=''" onMouseOver="this.style.backgroundColor='#fac906'"<? }?> <? if ($rs['bm']==1){?>style="BACKGROUND-COLOR:#ffff99"<? }?>>
			 
			 
			  <td height="23" align="center" nowrap="nowrap" ><?=$ii;?></td> 
			  <td align="center" ><?=$rs['num'];?></td> 
			  <td align="center" ><?=$rs['adddate'];?></td> 
			  <td align="center" nowrap="nowrap"  ><?php if ($rs['class1'] == '过关')
{
	$show1 = explode(',', $rs['class2']);
	$show2 = explode(',', $rs['class3']);
	$z = count($show1);
	$k = 0;
	
	for ($j = 0;$j < (count($show1) - 1);$j = $j + 1)
	{
	?>                        
	<span  style="COLOR: ff0000"><?=$show1[$j];?> &nbsp;<?=$show2[$k];?></span> @ &nbsp;<span style="COLOR: ff6600"><b><?=$show2[$k + 1];?></b></span><br>
	<?php 
	$k = k + 2;
	}
}
else
{?> 							
						  <font color=ff0000><?=$rs['class2'];?>:</font><font color=ff6600><?=$rs['class3'];?></font>
						  <?php }?> 				  </td> 
			   <td align="center" nowrap="nowrap"  ><font color=ff6600><b><?=$rs['rate']?></b></font></td>
                <td align="center" nowrap="nowrap" ><b><font color=ff0000><?=$rs['sum_m']?></font></b></td>
                <td align="center" nowrap="nowrap" ><? if ($rs['bm']==2){echo 0;}else{echo $rs['sum_m']*abs($rs['user_ds'])/100;$z_userds+=$rs['sum_m']*abs($rs['user_ds'])/100;}?> </td>
                <td align="center" nowrap="nowrap" ><? if ($rs['bm']==2){echo 0;}elseif($rs['bm']==1){echo $rs['sum_m']*$rs['rate']+$rs['sum_m']*abs($rs['user_ds'])/100-$rs['sum_m'];$z_user+=$rs['sum_m']*$rs['rate']+$rs['sum_m']*abs($rs['user_ds'])/100-$rs['sum_m'];}else{echo -$rs['sum_m']+$rs['sum_m']*abs($rs['user_ds'])/100;$z_user+=-$rs['sum_m']+$rs['sum_m']*abs($rs['user_ds'])/100;}?></td>
			</tr>
<?php }?> 			     
			<tr class="t_list_tr_sum" height="23"> 
			  <td align="center" nowrap="nowrap" colspan="2"><span class="STYLE4">小计</span></td> 
			  <td align="center" nowrap="nowrap" colspan="3"><span class="STYLE4">当前页共&nbsp;<?=$z_re;?>&nbsp;笔</span></td> 
			  <td align="center" nowrap="nowrap" ><span class="STYLE4"><?=$z_sum;?></span></td> 
			  <td align="center" nowrap="nowrap"><span class="STYLE4"><?=$z_userds;?></span></td> 
			  <td align="center" nowrap="nowrap"><span class="STYLE4"><?=number_format($z_user, 2);?></span></td> 
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