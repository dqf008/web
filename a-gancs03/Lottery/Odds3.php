<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cpgl');
check_quanxian('cppl');
$type = $_REQUEST['type'];
$save = $_REQUEST['save'];
if ($type == ''){
	$type = 1;
}
$lotteryType = $_GET['lottery_type'];
$lotteryNames = array('gdkl10'=>'广东快乐10分','cqkl10'=>'重庆快乐10分','tjkl10'=>'天津快乐10分','hnkl10'=>'湖南快乐10分','sxkl10'=>'山西快乐10分','ynkl10'=>'云南快乐10分','ffkl10'=>'分分快乐10分','sfkl10'=>'三分快乐10分');
$type == '1' ? $se1 = '#FF0' : $se1 = '#FFF';
$type == '2' ? $se2 = '#FF0' : $se2 = '#FFF';
$type == '3' ? $se3 = '#FF0' : $se3 = '#FFF';
$type == '4' ? $se4 = '#FF0' : $se4 = '#FFF';
$type == '5' ? $se5 = '#FF0' : $se5 = '#FFF';
$type == '6' ? $se6 = '#FF0' : $se6 = '#FFF';
$type == '7' ? $se7 = '#FF0' : $se7 = '#FFF';
$type == '8' ? $se8 = '#FF0' : $se8 = '#FFF';
$type == '9' ? $se9 = '#FF0' : $se9 = '#FFF';
$table ='c_odds_klsf';
if($lotteryType =='gdkl10'){
    $table ='c_odds_3';
}
if ($save == 'ok'){
	if ($type < 9){
        $params = [':h1' => $_REQUEST['Num_1'], ':h2' => $_REQUEST['Num_2'], ':h3' => $_REQUEST['Num_3'], ':h4' => $_REQUEST['Num_4'], ':h5' => $_REQUEST['Num_5'], ':h6' => $_REQUEST['Num_6'], ':h7' => $_REQUEST['Num_7'], ':h8' => $_REQUEST['Num_8'], ':h9' => $_REQUEST['Num_9'], ':h10' => $_REQUEST['Num_10'], ':h11' => $_REQUEST['Num_11'], ':h12' => $_REQUEST['Num_12'], ':h13' => $_REQUEST['Num_13'], ':h14' => $_REQUEST['Num_14'], ':h15' => $_REQUEST['Num_15'], ':h16' => $_REQUEST['Num_16'], ':h17' => $_REQUEST['Num_17'], ':h18' => $_REQUEST['Num_18'], ':h19' => $_REQUEST['Num_19'], ':h20' => $_REQUEST['Num_20'], ':h21' => $_REQUEST['Num_21'], ':h22' => $_REQUEST['Num_22'], ':h23' => $_REQUEST['Num_23'], ':h24' => $_REQUEST['Num_24'], ':h25' => $_REQUEST['Num_25'], ':h26' => $_REQUEST['Num_26'], ':h27' => $_REQUEST['Num_27'], ':h28' => $_REQUEST['Num_28'], ':h29' => $_REQUEST['Num_29'], ':h30' => $_REQUEST['Num_30'], ':h31' => $_REQUEST['Num_31'], ':h32' => $_REQUEST['Num_32'], ':h33' => $_REQUEST['Num_33'], ':h34' => $_REQUEST['Num_34'], ':h35' => $_REQUEST['Num_35'], ':type' => 'ball_' . $type];
        if($lotteryType=='gdkl10'){
            $sql    = 'update c_odds_3 set h1=:h1,h2=:h2,h3=:h3,h4=:h4,h5=:h5,h6=:h6,h7=:h7,h8=:h8,h9=:h9,h10=:h10,h11=:h11,h12=:h12,h13=:h13,h14=:h14,h15=:h15,h16=:h16,h17=:h17,h18=:h18,h19=:h19,h20=:h20,h21=:h21,h22=:h22,h23=:h23,h24=:h24,h25=:h25,h26=:h26,h27=:h27,h28=:h28,h29=:h29,h30=:h30,h31=:h31,h32=:h32,h33=:h33,h34=:h34,h35=:h35 where type=:type';
        }else {
            $params[':name'] = $lotteryType;
            $sql    = 'update c_odds_klsf set h1=:h1,h2=:h2,h3=:h3,h4=:h4,h5=:h5,h6=:h6,h7=:h7,h8=:h8,h9=:h9,h10=:h10,h11=:h11,h12=:h12,h13=:h13,h14=:h14,h15=:h15,h16=:h16,h17=:h17,h18=:h18,h19=:h19,h20=:h20,h21=:h21,h22=:h22,h23=:h23,h24=:h24,h25=:h25,h26=:h26,h27=:h27,h28=:h28,h29=:h29,h30=:h30,h31=:h31,h32=:h32,h33=:h33,h34=:h34,h35=:h35 where type=:type and `name`=:name';
        }
        $stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		echo "<script>alert(\"赔率修改完毕！\");window.open('odds3.php?type=".$type." &lottery_name=".$lotteryType."','mainFrame');</script>";
		exit();
	}
	
	if ($type == 9){
		$params = array(':h1' => $_REQUEST['Num_1'], ':h2' => $_REQUEST['Num_2'], ':h3' => $_REQUEST['Num_3'], ':h4' => $_REQUEST['Num_4'], ':h5' => $_REQUEST['Num_5'], ':h6' => $_REQUEST['Num_6'], ':h7' => $_REQUEST['Num_7'], ':h8' => $_REQUEST['Num_8'], ':type' => 'ball_' . $type);
		if($lotteryType =='gdkl10') {
            $sql = 'update c_odds_3 set h1=:h1,h2=:h2,h3=:h3,h4=:h4,h5=:h5,h6=:h6,h7=:h7,h8=:h8 where type=:type';
        }else{
		    $params[':name'] = $lotteryType;
            $sql = 'update c_odds_klsf set h1=:h1,h2=:h2,h3=:h3,h4=:h4,h5=:h5,h6=:h6,h7=:h7,h8=:h8 where type=:type and `name`=:name';
        }
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		echo "<script>alert(\"赔率修改完毕！\");window.open('odds3.php?type=".$type." &lottery_name=".$lotteryType."','mainFrame');</script>";
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
  $.post("get_odds_3.php", {type :<?=$type;?>,lottery_type:<?php echo '"'.$lotteryType.'"'?>}, function(data)
	  { 
		  for(var key in data.oddslist){ 
		  odds = data.oddslist[key];
		  $("#Num_"+key).val(odds);
		  } 
	  }, "json");
} 
function UpdateRate(num ,i){ 
  $.post("updaterate_3.php", {type :<?=$type;?>,num : num ,i : i,lottery_type:<?php echo '"'.$lotteryType.'"'?>}, function(data)
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
	<td valign="top">
	<?php include_once 'Menu_Odds.php';?>   
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9"> 
	<tr> 
	  <td align="center" bgcolor="#3C4D82" style="color:#FFF"> 
	  <a href="?lottery_type=<?php echo $lotteryType?>&type=1" style="color:<?=$se1;?>;font-weight:bold;">第一球</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?lottery_type=<?php echo $lotteryType?>&type=2" style="color:<?=$se2;?>;font-weight:bold;">第二球</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?lottery_type=<?php echo $lotteryType?>&type=3" style="color:<?=$se3;?>;font-weight:bold;">第三球</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?lottery_type=<?php echo $lotteryType?>&type=4" style="color:<?=$se4;?>;font-weight:bold;">第四球</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?lottery_type=<?php echo $lotteryType?>&type=5" style="color:<?=$se5;?>;font-weight:bold;">第五球</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?lottery_type=<?php echo $lotteryType?>&type=6" style="color:<?=$se6;?>;font-weight:bold;">第六球</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?lottery_type=<?php echo $lotteryType?>&type=7" style="color:<?=$se7;?>;font-weight:bold;">第七球</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?lottery_type=<?php echo $lotteryType?>&type=8" style="color:<?=$se8;?>;font-weight:bold;">第八球</a>&nbsp;&nbsp;-&nbsp;&nbsp;
	  <a href="?lottery_type=<?php echo $lotteryType?>&type=9" style="color:<?=$se9;?>;font-weight:bold;">总和 龙虎</a></td>
	  </tr>    
  </table>
  <?php if ($type < 9){?>                     
  <table border="0"align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9"> 
  <form name="form1" method="post" action="?lottery_type=<?echo $lotteryType;?>&type=<?=$type;?>&save=ok">
	  <tr style="background-color:#3C4D82;color:#FFF"> 
		<td width="50" height="22" align="center"><strong>号码</strong></td> 
		<td align="center"><strong>当前赔率</strong></td> 
		<td width="50" align="center"><strong>号码</strong></td> 
		<td align="center"><strong>当前赔率</strong></td> 
		<td width="50" align="center"><strong>号码</strong></td> 
		<td align="center"><strong>当前赔率</strong></td> 
		<td width="50" align="center"><strong>号码</strong></td> 
		<td align="center"><strong>当前赔率</strong></td> 
		<td width="50" align="center"><strong>号码</strong></td> 
		<td align="center"><strong>当前赔率</strong></td> 
	  </tr> 
	  <tr> 
		<td height="28" align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/01.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('1','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_1" id="Num_1" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('1','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/02.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('2','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_2" id="Num_2" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('2','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/03.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('3','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_3" id="Num_3" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('3','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/04.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('4','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_4" id="Num_4" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('4','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/05.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('5','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_5" id="Num_5" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('5','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
	  </tr> 
	  <tr> 
		<td height="28" align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/06.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('6','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_6" id="Num_6" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('6','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/07.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('7','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_7" id="Num_7" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('7','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/08.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('8','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_8" id="Num_8" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('8','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/09.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('9','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_9" id="Num_9" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('9','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/10.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('10','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_10" id="Num_10" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('10','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
	  </tr> 
	  <tr> 
		<td height="28" align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/11.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('11','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_11" id="Num_11" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('11','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/12.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('12','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_12" id="Num_12" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('12','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/13.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('13','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_13" id="Num_13" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('13','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/14.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('14','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_14" id="Num_14" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('14','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/15.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('15','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_15" id="Num_15" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('15','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
	  </tr> 
	  <tr> 
		<td height="28" align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/16.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('16','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_16" id="Num_16" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('16','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/17.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('17','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_17" id="Num_17" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('17','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/18.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('18','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_18" id="Num_18" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('18','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/19.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('19','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_19" id="Num_19" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('19','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF"><img src="/lottery/images/ball_4/20.png" /></td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('20','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_20" id="Num_20" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('20','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
	  </tr> 
	  <tr> 
		<td height="28" align="center"bgcolor="#FFFFFF">大</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('21','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_21" id="Num_21" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('21','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">小</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('22','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_22" id="Num_22" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('22','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">单</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('23','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_23" id="Num_23" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('23','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">双</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('24','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_24" id="Num_24" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('24','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">尾大</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('25','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_25" id="Num_25" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('25','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
	  </tr> 
	  <tr> 
		<td height="28" align="center"bgcolor="#FFFFFF">尾小</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('26','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_26" id="Num_26" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('26','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">合单</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('27','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_27" id="Num_27" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('27','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">合双</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('28','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_28" id="Num_28" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('28','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">东</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('29','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_29" id="Num_29" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('29','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">南</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('30','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_30" id="Num_30" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('30','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
	  </tr> 
	  <tr> 
		<td height="28" align="center"bgcolor="#FFFFFF">西</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('31','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_31" id="Num_31" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('31','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">北</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('32','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_32" id="Num_32" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('32','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">中</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('33','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_33" id="Num_33" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('33','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">发</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('34','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_34" id="Num_34" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('34','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">白</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('35','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_35" id="Num_35" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('35','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
	  </tr> 
	  <tr> 
		<td height="28" colspan="10" align="center"bgcolor="#FFFFFF"><input type="submit"  class="submit80" name="Submit" value="确认修改" /></td> 
	  </tr></form> 
</table>
<?php }else if ($type == 9){?> 
<table border="0"align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9"> 
  <form name="form1" method="post" action="?lottery_type=<?=$lotteryType;?>&type=<?=$type;?>&save=ok">
	  <tr style="background-color:#3C4D82;color:#FFF"> 
		<td width="50" height="22" align="center"><strong>号码</strong></td> 
		<td align="center"><strong>当前赔率</strong></td> 
		<td width="50" align="center"><strong>号码</strong></td> 
		<td align="center"><strong>当前赔率</strong></td> 
		<td width="50" align="center"><strong>号码</strong></td> 
		<td align="center"><strong>当前赔率</strong></td> 
		<td width="50" align="center"><strong>号码</strong></td> 
		<td align="center"><strong>当前赔率</strong></td> 
	  </tr> 
	  <tr> 
		<td height="28" align="center"bgcolor="#FFFFFF">总和大</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('1','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_1" id="Num_1" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('1','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">总和小</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('2','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_2" id="Num_2" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('2','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">总和单</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('3','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_3" id="Num_3" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('3','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">总和双</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('4','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_4" id="Num_4" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('4','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
	  </tr> 
	  <tr> 
		<td height="28" align="center"bgcolor="#FFFFFF">总和尾大</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('5','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_5" id="Num_5" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('5','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">总和尾小</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('6','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_6" id="Num_6" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('6','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">龙</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('7','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_7" id="Num_7" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('7','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
		<td align="center"bgcolor="#FFFFFF">虎</td> 
		<td align="center"bgcolor="#FFFFFF"><table border="0" cellspacing="0" cellpadding="3"> 
		  <tr> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('8','0');"><img src="../Images/bvbv_02.gif" width="19" height="17" /></a></td> 
			<td align="center"><input class="input1" maxlength="6" size="4" value="0" name="Num_8" id="Num_8" /></td> 
			<td align="center"><a style="cursor:hand" onClick="UpdateRate('8','1');"><img src="../Images/bvbv_01.gif" width="19" height="17" /></a></td> 
		  </tr> 
		</table></td> 
	  </tr> 
	  <tr> 
		<td height="28" colspan="8" align="center"bgcolor="#FFFFFF"><input type="submit"  class="submit80" name="Submit" value="确认修改" /></td> 
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