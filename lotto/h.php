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
--> 
</style></head> 
<body  oncontextmenu="return false"   onselect="document.selection.empty()" oncopy="document.selection.empty()" > 
 <style type="text/css"> 
.jl_11 { 
	background: #82D27A;
	height: 24px;
	line-height: 24px;
	color: #FFFF66;
} 
</style> 


<noscript> 
<iframe scr=″*.htm″></iframe> 
</noscript> 

  <table border="0" cellpadding="0" cellspacing="1" class="t_list" width="780"> 
	  <tr> 
		  <td class="t_list_caption" width="120">注单码/时间</td> 
		  <td class="t_list_caption" width="110">下注类型</td> 
		  <td class="t_list_caption">注单明细</td> 
		  <td class="t_list_caption" width="90">下注金额</td> 
		  <td class="t_list_caption" width="100">可赢金额</td> 
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
$params = array(':username' => $_SESSION['username'], ':kithe' => $Current_Kithe_Num);
$stmt = $mydata2_db->prepare('select * from ka_tan where username=:username and kithe=:kithe order by id desc');
$stmt->execute($params);
$ii = 0;
if (0 < $stmt->rowCount()){
while ($rs = $stmt->fetch()){
	$ii++;
	$z_re++;
	$z_sum += $rs['sum_m'];
?>         
	  <tr <? if($ii%2==1){ ?>class="t_list_tr_0"<? }else{ ?>class="t_list_tr_1"<? } ?> onMouseOut="this.style.backgroundColor=''" onMouseOver="this.style.backgroundColor='#fac906'">
            <td width="120"><?=$rs['num']?><br><?=$rs['adddate']?></td>
            <td width="100"><?=$rs['class1']?></td>
            <td width="220"><font color=ff0000><?=$rs['kithe']?>期</font>/
			<? if ($rs['class1']=="过关"){
				
				$show1=explode(",",$rs['class2']);
				$show2=explode(",",$rs['class3']);
				$z=count($show1);
				
			$k=0;
			for ($j=0; $j<count($show1)-1; $j=$j+1){
			
			?>
                        <span 
      style="COLOR: ff0000"><?=$show1[$j]?> &nbsp;<?=$show2[$k]?></span> @ &nbsp;<span 
      style="COLOR: ff6600"><b><?=$show2[$k+1]?></b></span><br>
                        <?
						
						$k=k+2;
						
						 }
						}else{?>
							
							<font color=ff0000><?=$rs['class2']?>:</font><font color=ff6600><?=$rs['class3']?></font>
							
							<? }?>/       
            <font color=ff6600><b><?=$rs['rate']?></b></font>
            </td>
            <td width="90"><?=$rs['sum_m']?></td>
            <td width="120"><font color=ff0000><?=$rs['sum_m']*$rs['rate']+$rs['sum_m']*$rs['user_ds']/100-$rs['sum_m']?></font></td>
        </tr>             
<?

$z_userds+=$rs['sum_m'];
$z_user+=$rs['sum_m']*$rs['rate']+$rs['sum_m']*$rs['user_ds']/100-$rs['sum_m'];
}
}else{
?>            
              <tr class="t_list_bottom">
            <td colspan="17"><span class='Font_R'>无记录!!!</span></td>
             </tr>
<?
}
?>                  
        <tr class="t_list_tr_sum">
            <td colspan="2">小计</td>
            <td>当前页共<?=$ii ?>&nbsp;笔</td>
            <td class='f_right'><?=$z_userds ?>&nbsp;</td>
<td class='f_right'><?=$z_user ?>&nbsp;</td>

        </tr>
       
    </table><br>
</body> 
</html> 
