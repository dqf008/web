<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cpgl');
check_quanxian('cppl');
$type = $_REQUEST['type'];
$save = $_REQUEST['save'];
if ($type == '')
{
	$type = 1;
}
$lotteryType = isset($_REQUEST['lottery_type'])?$_REQUEST['lottery_type']:'xyft';
$type == '1' ? $se1 = '#FF0' : $se1 = '#FFF';
$type == '2' ? $se2 = '#FF0' : $se2 = '#FFF';
$type == '3' ? $se3 = '#FF0' : $se3 = '#FFF';
$type == '4' ? $se4 = '#FF0' : $se4 = '#FFF';
$type == '5' ? $se5 = '#FF0' : $se5 = '#FFF';
$type == '6' ? $se6 = '#FF0' : $se6 = '#FFF';
$type == '7' ? $se7 = '#FF0' : $se7 = '#FFF';
$type == '8' ? $se8 = '#FF0' : $se8 = '#FFF';
$type == '9' ? $se9 = '#FF0' : $se9 = '#FFF';
$type == '10' ? $se10 = '#FF0' : $se10 = '#FFF';
$type == '11' ? $se11 = '#FF0' : $se11 = '#FFF';
$type == '12' ? $se12 = '#FF0' : $se12 = '#FFF';
$type == '13' ? $se13 = '#FF0' : $se13 = '#FFF';
$type == '14' ? $se14 = '#FF0' : $se14 = '#FFF';
$type == '15' ? $se15 = '#FF0' : $se15 = '#FFF';
$type == '16' ? $se16 = '#FF0' : $se16 = '#FFF';
if ($save == 'ok')
{
	if ($type == 1)
	{
		$params = array(':h1' => $_REQUEST['Num_1'], ':h2' => $_REQUEST['Num_2'], ':h3' => $_REQUEST['Num_3'], ':h4' => $_REQUEST['Num_4'], ':h5' => $_REQUEST['Num_5'], ':h6' => $_REQUEST['Num_6'], ':h7' => $_REQUEST['Num_7'], ':h8' => $_REQUEST['Num_8'], ':h9' => $_REQUEST['Num_9'], ':h10' => $_REQUEST['Num_10'], ':h11' => $_REQUEST['Num_11'], ':h12' => $_REQUEST['Num_12'], ':h13' => $_REQUEST['Num_13'], ':h14' => $_REQUEST['Num_14'], ':h15' => $_REQUEST['Num_15'], ':h16' => $_REQUEST['Num_16'], ':h17' => $_REQUEST['Num_17'], ':h18' => $_REQUEST['Num_18'], ':h19' => $_REQUEST['Num_19'], ':h20' => $_REQUEST['Num_20'], ':h21' => $_REQUEST['Num_21'], ':type' => 'ball_' . $type);
		$sql = 'update c_odds_8 set h1=:h1,h2=:h2,h3=:h3,h4=:h4,h5=:h5,h6=:h6,h7=:h7,h8=:h8,h9=:h9,h10=:h10,h11=:h11,h12=:h12,h13=:h13,h14=:h14,h15=:h15,h16=:h16,h17=:h17,h18=:h18,h19=:h19,h20=:h20,h21=:h21 where type=:type';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		echo "<script>alert(\"赔率修改完毕！\");window.open('odds8.php?lottery_type=".$lotteryType."&type=".$type."','mainFrame');</script>";
		exit();
	}else if ($type < 12){
		$params = array(':h1' => $_REQUEST['Num_1'],':h2' => $_REQUEST['Num_2'], ':h3' => $_REQUEST['Num_3'], ':h4' => $_REQUEST['Num_4'], ':h5' => $_REQUEST['Num_5'], ':h6' => $_REQUEST['Num_6'], ':h7' => $_REQUEST['Num_7'], ':h8' => $_REQUEST['Num_8'], ':h9' => $_REQUEST['Num_9'], ':h10' => $_REQUEST['Num_10'], ':h11' => $_REQUEST['Num_11'], ':h12' => $_REQUEST['Num_12'], ':h13' => $_REQUEST['Num_13'], ':h14' => $_REQUEST['Num_14'], ':type' => 'ball_' . $type);
		$sql = 'update c_odds_8 set h1=:h1,h2=:h2,h3=:h3,h4=:h4,h5=:h5,h6=:h6,h7=:h7,h8=:h8,h9=:h9,h10=:h10,h11=:h11,h12=:h12,h13=:h13,h14=:h14 where type=:type';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		echo "<script>alert(\"赔率修改完毕！\");window.open('odds8.php?lottery_type=".$lotteryType."&type=".$type."','mainFrame');</script>";
		exit();
	}else if (12 <= $type){
		$params = array(':h1' => $_REQUEST['Num_1'], ':h2' => $_REQUEST['Num_2'], ':type' => 'ball_' . $type);
		$sql = 'update c_odds_8 set h1=:h1,h2=:h2 where type=:type';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		echo "<script>alert(\"赔率修改完毕！\");window.open('odds8.php?lottery_type=".$lotteryType."&type=".$type."','mainFrame');</script>";
		exit();
	}
}
?> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>Welcome</title> 
<link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" /> 
</head> 
<script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
<script type="text/javascript"> 
//读取当前期数盘口赔率与投注总额 
function loadinfo(){ 
  $.post("get_odds_8.php", {type :<?=$type;?>}, function(data)
	  { 
		  console.log(data);
	      for(var key in data.oddslist){
		  odds = data.oddslist[key];
		  $("#Num_"+key).val(odds);
		  } 
	  }, "json");
} 
function UpdateRate(num ,i){ 
  $.post("updaterate_8.php", {type :<?=$type;?>,num : num ,i : i}, function(data)
	  { 
		  odds = data.oddslist[num];
		  xodds = $("#Num_"+num).val();
		  if(odds != xodds){ 
			  $("#Num_"+num).css("color","red");
		  } 
		  $("#Num_"+num).val(odds);
	  }, "json");
} 
</script> 
<body> 
<div id="pageMain"> 
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5"> 
  <tr> 
	<td valign="top"><?php include_once 'Menu_Odds.php';?>   
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9"> 
	<tr> 
	  <td align="center" bgcolor="#3C4D82" style="color:#FFF"> 
	  <a href="?type=1" style="color:<?=$se1;?>;font-weight:bold;">冠、亚军和</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=2" style="color:<?=$se2;?>;font-weight:bold;">冠军</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=3" style="color:<?=$se3;?>;font-weight:bold;">亚军</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=4" style="color:<?=$se4;?>;font-weight:bold;">第三名</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=5" style="color:<?=$se5;?>;font-weight:bold;">第四名</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=6" style="color:<?=$se6;?>;font-weight:bold;">第五名</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=7" style="color:<?=$se7;?>;font-weight:bold;">第六名</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=8" style="color:<?=$se8;?>;font-weight:bold;">第七名</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=9" style="color:<?=$se9;?>;font-weight:bold;">第八名</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=10" style="color:<?=$se10;?>;font-weight:bold;">第九名</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=11" style="color:<?=$se11;?>;font-weight:bold;">第十名</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=12" style="color:<?=$se12;?>;font-weight:bold;">1V10</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=13" style="color:<?=$se13;?>;font-weight:bold;">2V9</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=14" style="color:<?=$se14;?>;font-weight:bold;">3V8</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=15" style="color:<?=$se15;?>;font-weight:bold;">4V7</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?type=16" style="color:<?=$se16;?>;font-weight:bold;">5V6</a></td> 
	  </tr>    
  </table>
  <?php if ($type == 1){?>         
  <table border="0"align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9"> 
		  <form name="form1" method="post" action="?lottery_type=<?php echo $lotteryType?>&type=<?=$type;?>&save=ok">
			  <tr style="background-color:#3C4D82;color:#FFF"> 
				<td width="50" height="22" align="center"><strong>选项</strong></td> 
				<td align="center"><strong>当前赔率</strong></td> 
				<td width="50" align="center"><strong>选项</strong></td> 
				<td align="center"><strong>当前赔率</strong></td> 
				<td width="50" align="center"><strong>选项</strong></td> 
				<td align="center"><strong>当前赔率</strong></td> 
				<td width="50" align="center"><strong>选项</strong></td> 
				<td align="center"><strong>当前赔率</strong></td> 
				<td width="50" align="center"><strong>选项</strong></td> 
				<td align="center"><strong>当前赔率</strong></td> 
			  </tr> 
			  <tr> 
				<td height="28" align="center"bgcolor="#FFFFFF">3</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('1','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_1" id="Num_1" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('1','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">4</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('2','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_2" id="Num_2" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('2','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">5</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('3','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_3" id="Num_3" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('3','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">6</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('4','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_4" id="Num_4" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('4','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">7</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('5','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_5" id="Num_5" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('5','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
			  </tr> 
			  <tr> 
				<td height="28" align="center"bgcolor="#FFFFFF">8</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('6','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_6" id="Num_6" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('6','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">9</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('7','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_7" id="Num_7" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('7','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">10</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('8','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_8" id="Num_8" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('8','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">11</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('9','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_9" id="Num_9" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('9','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">12</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('10','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_10" id="Num_10" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('10','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
			  </tr> 
			  <tr> 
				<td height="28" align="center"bgcolor="#FFFFFF">13</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('11','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_11" id="Num_11" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('11','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">14</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('12','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_12" id="Num_12" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('12','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">15</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('13','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_13" id="Num_13" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('13','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">16</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('14','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_14" id="Num_14" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('14','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">17</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('15','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_15" id="Num_15" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('15','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
			  </tr> 
			  <tr> 
				<td height="28" align="center"bgcolor="#FFFFFF">18</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('16','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_16" id="Num_16" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('16','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">19</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('17','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_17" id="Num_17" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('17','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF"></td> 
				<td align="center"bgcolor="#FFFFFF"></td> 
				<td align="center"bgcolor="#FFFFFF"></td> 
				<td align="center"bgcolor="#FFFFFF"></td> 
				<td align="center"bgcolor="#FFFFFF"></td> 
				<td align="center"bgcolor="#FFFFFF"></td> 
			  </tr> 
			  <tr> 
				<td align="center"bgcolor="#FFFFFF">冠亚大</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('18','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_18" id="Num_18" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('18','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">冠亚小</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('19','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_19" id="Num_19" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('19','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">冠亚单</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('20','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_20" id="Num_20" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('20','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF">冠亚双</td> 
				<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
				  <tr> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('21','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
					<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_21" id="Num_21" /></td> 
					<td align="center"><a style="cursor:hand" onClick="UpdateRate('21','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
				  </tr> 
				</table></td> 
				<td align="center"bgcolor="#FFFFFF"></td> 
				<td align="center"bgcolor="#FFFFFF"></td> 
			  </tr> 
			  <tr> 
				<td height="28" colspan="10" align="center"bgcolor="#FFFFFF"><input type="submit"  class="submit80" name="Submit" value="确认修改" /></td> 
			  </tr></form> 
	  </table>
	  <?php }else if ($type < 12){?>
                <table border="0"align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9"> 
				  <form name="form1" method="post" action="?type=<?=$type;?>&save=ok"> 
					  <tr style="background-color:#3C4D82;color:#FFF"> 
						<td width="50" height="22" align="center"><strong>选项</strong></td> 
						<td align="center"><strong>当前赔率</strong></td> 
						<td width="50" align="center"><strong>选项</strong></td> 
						<td align="center"><strong>当前赔率</strong></td> 
						<td width="50" align="center"><strong>选项</strong></td> 
						<td align="center"><strong>当前赔率</strong></td> 
						<td width="50" align="center"><strong>选项</strong></td> 
						<td align="center"><strong>当前赔率</strong></td> 
						<td width="50" align="center"><strong>选项</strong></td> 
						<td align="center"><strong>当前赔率</strong></td> 
					  </tr> 
					  <tr> 
						<td height="28" align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_2/1.png" /></td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('1','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_1" id="Num_1" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('1','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_2/2.png" /></td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('2','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_2" id="Num_2" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('2','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_2/3.png" /></td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('3','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_3" id="Num_3" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('3','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_2/4.png" /></td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('4','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_4" id="Num_4" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('4','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_2/5.png" /></td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('5','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_5" id="Num_5" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('5','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
					  </tr> 
					  <tr> 
						<td height="28" align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_2/6.png" /></td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('6','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_6" id="Num_6" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('6','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_2/7.png" /></td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('7','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_7" id="Num_7" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('7','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_2/8.png" /></td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('8','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_8" id="Num_8" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('8','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_2/9.png" /></td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('9','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_9" id="Num_9" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('9','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_2/10.png" /></td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('10','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_10" id="Num_10" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('10','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
					  </tr> 
					  <tr> 
						<td height="28" align="center"bgcolor="#FFFFFF">大</td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('11','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_11" id="Num_11" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('11','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF">小</td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('12','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_12" id="Num_12" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('12','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF">单</td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('13','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_13" id="Num_13" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('13','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF">双</td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('14','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_14" id="Num_14" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('14','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF"></td> 
						<td align="center"bgcolor="#FFFFFF"></td> 
					  </tr> 
					  <tr> 
						<td height="28" colspan="10" align="center"bgcolor="#FFFFFF"><input type="submit"  class="submit80" name="Submit" value="确认修改" /></td> 
					  </tr></form> 
			  </table>
<?php }else if (12 <= $type){?> 
			 <table border="0"align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9"> 
				  <form name="form1" method="post" action="?lottery_type=<?php echo $lotteryType?>type=<?=$type;?>&save=ok">
					  <tr style="background-color:#3C4D82;color:#FFF"> 
						<td width="50" height="22" align="center"><strong>选项</strong></td> 
						<td align="center"><strong>当前赔率</strong></td> 
						<td width="50" align="center">选项</td> 
						<td align="center">当前赔率</td> 
					  </tr> 
					  <tr> 
						<td height="28" align="center"bgcolor="#FFFFFF">龙</td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('1','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_1" id="Num_1" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('1','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
						<td align="center"bgcolor="#FFFFFF">虎</td> 
						<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
						  <tr> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('2','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
							<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_2" id="Num_2" /></td> 
							<td align="center"><a style="cursor:hand" onClick="UpdateRate('2','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
						  </tr> 
						</table></td> 
					  </tr> 
					  <tr> 
						<td height="28" colspan="4" align="center"bgcolor="#FFFFFF"><input type="submit"  class="submit80" name="Submit" value="确认修改" /></td> 
					  </tr></form> 
			  </table>
		<?php }?> 
	</td> 
  </tr> 
</table> 
</div> 
<script type="text/javascript">loadinfo();</script>  
</body> 
</html>