<?php 
if (!defined('PHPYOU')){
	exit('非法进入');
}

if ($_GET['class2'] == ''){
	echo "<script>alert('非法进入!');parent.leftFrame.location.href='index.php?action=k_tm';window.location.href='index.php?action=left';</script>";
	exit();
}
$params = array(':kithe' => $Current_Kithe_Num, ':username' => ka_memuser('kauser'), ':class1' => '过关');
$stmt = $mydata2_db->prepare('select sum(sum_m) as sum_mm from ka_tan where kithe=:kithe and username=:username and class1=:class1 order by id desc');
$stmt->execute($params);
$sum_mm = $stmt->fetchColumn();
$drop_sort = $_GET['class2'];
$XF = 19;
$R = 12;
$urlurl = 'index.php?action=k_gg&ids=过关';
?>
<LINK rel=stylesheet type=text/css href="imgs/left.css"> 
<link href="../css/bcss.css" rel="stylesheet" type="text/css" /><LINK 
rel=stylesheet type=text/css href="imgs/ball1x.css"><LINK 
rel=stylesheet type=text/css href="imgs/loto_lb.css"> 
<style type="text/css"> 
<!-- 
body,td,th { 
  font-size: 9pt;
} 
.STYLE3 {color: #FFFFFF} 
.STYLE4 {color: #000} 
.STYLE2 {} 
--> 
</style></HEAD> 
<SCRIPT language=JAVASCRIPT> 
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT> 

<SCRIPT language=javascript> 
window.setTimeout("self.location='index.php?action=left'", 30000);
</SCRIPT> 
<SCRIPT language=JAVASCRIPT> 
if(self == top){location = '/';} 

function ChkSubmit(){ 
  //设定『确定』键为反白 


	  document.all.btnSubmit.disabled = true;

document.form1.submit();
  } 
</SCRIPT> 

<noscript> 
<iframe scr=″*.htm″></iframe> 
</noscript> 
<table height="3" cellspacing="0" cellpadding="0" border="0" width="180"> 
	  <tbody><tr> 
		<td></td> 
	  </tr> 
	</tbody></table>
	<?php if (($Current_KitheTable[29] == 0) || ($Current_KitheTable[$XF] == 0)){?> 
	<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          
	<tr>            
	<td height=28 align=center bgcolor=cb4619>
	<font color=ffff00>封盘中....<input class=button_a onClick="self.location='index.php?action=left'" type="button" value="离开" name="btnCancel11" /></font>
	</td>          
	</tr>      
	</table>
	<?php exit();
}?>


<TABLE class=Tab_backdrop cellSpacing=0 cellPadding=0 width=180 border=0> 
<tr> 
  <td valign="top" class="Left_Place"> 
			  <TABLE class=t_list cellSpacing=1 cellPadding=0 width=180 border=0>
<?php 
$sum_m = $_POST['gold'];
$gold = $_POST['gold'];
if (ka_memuser('ts') < $sum_m){
	echo "<script Language=Javascript>alert('对不起，下注总额不能大于可用信用额');parent.leftFrame.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
	exit();
}
$z = 0;
$rate2 = 1;
$class11 = '过关';

for ($t = 1;$t <= 18;$t = $t + 1){
	if ($_POST['rate_id' . $t] != ''){
		$rate_id = $_POST['rate_id' . $t];
		$rate2 = $rate2 * ka_bl($rate_id, 'rate');
		$class22 .= ka_bl($rate_id, 'class2') . ',';
		$class33 .= ka_bl($rate_id, 'class3') . ',' . ka_bl($rate_id, 'rate') . ',';
		$orderinfo .= $rate_id;
	}
}
include_once '../ajaxleft/postkey.php';
$orderkey = StrToHex($orderinfo, $postkey);
$postorderkey = $_POST['orderkey'];
if ($orderkey != $postorderkey){
	echo "<script Language=Javascript>alert('注单错误.请返回重新下注!');parent.leftFrame.location.href='index.php?action=k_gg';window.location.href='index.php?action=left';</script>";
	exit();
}

$rate5 = floor($rate2 * 100) / 100;
switch (ka_memuser('abcd')){
case 'A': $Y = 1;
break;
case 'B': $Y = 4;
break;
case 'C': $Y = 5;
break;
case 'D': $Y = 6;
break;
default: $Y = 1;
break;
}
$params = array(':Kithe' => $Current_Kithe_Num, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33, ':username' => $_SESSION['username']);
$stmt = $mydata2_db->prepare('Select SUM(sum_m) As sum_m from ka_tan where Kithe=:Kithe and class1=:class1 and class2=:class2 and class3=:class3 and username=:username');
$stmt->execute($params);
$rs5_sum_m = $stmt->fetchColumn();
if (ka_memds($R, 3) < ($rs5_sum_m + $sum_m)){
	echo "<script Language=Javascript>alert('对不起，超过单项限额.请反回重新下注!');parent.leftFrame.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
	exit();
}
$num = randStr();
$text = date('Y-m-d H:i:s');
$sum_m = $sum_m;
$user_ds = ka_memds($R, 1);
$dai_ds = ka_memdaids($R, $Y);
$zong_ds = ka_memzongds($R, $Y);
$guan_ds = ka_memguands($R, $Y);
$dai_zc = ka_memuser('dan_zc');
$zong_zc = ka_memuser('zong_zc');
$guan_zc = ka_memuser('guan_zc');
$dagu_zc = ka_memuser('dagu_zc');
$dai = ka_memuser('dan');
$zong = ka_memuser('zong');
$guan = ka_memuser('guan');
$danid = ka_memuser('danid');
$zongid = ka_memuser('zongid');
$guanid = ka_memuser('guanid');
$memid = ka_memuser('id');
$abcd = ka_memuser('abcd');
$array_class22 = explode(',', $class22);

for ($ii = 0;$ii < count($array_class22);$ii++){
	$array_class22[$ii] = trim($array_class22[$ii]);
	if (is_numeric($array_class22[$ii])){
		$array_class22[$ii] = $array_class22[$ii] * 1;
	}
}
$check_class22 = array_unique($array_class22);
if (count($array_class22) != count($check_class22)){
	echo "<script Language=Javascript>alert('同一正码只能选择一个.请返回重新下注!');parent.leftFrame.location.href='index.php?action=k_gg';window.location.href='index.php?action=left';</script>";
	exit();
}

if ($_SESSION['username'] && (0 < $sum_m)){
	$params = array(':uid' => $_SESSION['uid'], ':money' => $sum_m, ':money2' => $sum_m);
	$stmt = $mydata1_db->prepare('update k_user set money=money-:money where uid=:uid and money>=:money2');
	$stmt->execute($params);
	$q0 = $stmt->rowCount();
	if ($q0 == 1){
		$params = array(':num' => $num, ':username' => $_SESSION['username'], ':kithe' => $Current_Kithe_Num, ':adddate' => $text, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33, ':rate' => $rate5, ':sum_m' => $sum_m, ':user_ds' => $user_ds, ':dai_ds' => $dai_ds, ':zong_ds' => $zong_ds, ':guan_ds' => $guan_ds, ':dai_zc' => $dai_zc, ':zong_zc' => $zong_zc, ':guan_zc' => $guan_zc, ':dagu_zc' => $dagu_zc, ':bm' => 0, ':dai' => $dai, ':zong' => $zong, ':guan' => $guan, ':memid' => $memid, ':danid' => $danid, ':zongid' => $zongid, ':guanid' => $guanid, ':abcd' => $abcd, ':lx' => 0);
		$stmt = $mydata2_db->prepare('INSERT INTO ka_tan set num=:num,username=:username,kithe=:kithe,adddate=:adddate,class1=:class1,class2=:class2,class3=:class3,rate=:rate,sum_m=:sum_m,user_ds=:user_ds,dai_ds=:dai_ds,zong_ds=:zong_ds,guan_ds=:guan_ds,dai_zc=:dai_zc,zong_zc=:zong_zc,guan_zc=:guan_zc,dagu_zc=:dagu_zc,bm=:bm,dai=:dai,zong=:zong,guan=:guan,memid=:memid,danid=:danid,zongid=:zongid,guanid=:guanid,abcd=:abcd,lx=:lx');
		$stmt->execute($params);
		$params = array(':num' => $num, ':sum_m' => $sum_m, ':sum_m2' => $sum_m, ':creationTime' => date('Y-m-d H:i:s', time() - (12 * 3600)), ':username' => $_SESSION['username']);
		$stmt = $mydata1_db->prepare('INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)SELECT uid,username,\'SIX\',\'BET\',:num,-:sum_m,money+:sum_m2,money,:creationTime FROM k_user WHERE username=:username');
		$stmt->execute($params);
	}else{
		echo "<script Language=Javascript>alert('下注失败!');parent.leftFrame.location.href='index.php?action=k_gg';window.location.href='index.php?action=left';</script>";
		exit();
	}
}else{
	exit();
}
?>                    
		  <tr> 
			<td height="22" colspan="2" align="center" nowrap  bgcolor="#142F06" style="LINE-HEIGHT: 23px"><span class="STYLE3">下注成功</span></td> 
		  </tr> 
		  <tr> 
			<td height="22" colspan="2" nowrap bgcolor="#ffffff" style="LINE-HEIGHT: 23px">
<?php 
for ($t = 1;$t <= 18;$t = $t + 1){
if ($_POST['rate_id' . $t] != ''){
	$rate_id = $_POST['rate_id' . $t];?>
	<FONT color=#cc0000><FONT color=#cc0000><?=ka_bl($rate_id,"class2")?>&nbsp;<?=ka_bl($rate_id,"class3")?></FONT> @ <FONT
color=#ff0000><B><?=ka_bl($rate_id,"rate")?></B></FONT></FONT>&nbsp;&nbsp;&nbsp;&nbsp;


		  <br><?php }
}?>
		   </td> 
		  </tr> 
		  <tr> 
			<td width="37%" height="22" align="right" nowrap  class=t_td_caption_1 style="LINE-HEIGHT: 23px"><span class="STYLE4">当前总赔：</span></td> 
			<td width="63%" align="left" class=t_td_text style="LINE-HEIGHT: 23px"><font color=ff0000><strong><?=$rate5;?></strong></font></td> 
		  </tr> 
		  <tr> 
			<td height="22" align="right" nowrap  class=t_td_caption_1 style="LINE-HEIGHT: 23px"><span class="STYLE4">下注金额： </span></td> 
			<td align="left"  class=t_td_text style="LINE-HEIGHT: 23px"><?=$sum_m;?></td> 
		  </tr> 
		  <tr> 
			<td height="22" align="right" nowrap  class=t_td_caption_1 style="LINE-HEIGHT: 23px"><span class="STYLE4">订单号码：</span></td> 
			<td align="left"  class=t_td_text style="LINE-HEIGHT: 23px"><?=$num;?></td> 
		  </tr> 
		  <tr> 
			<td height="22" colspan="2" align="center" nowrap   class=t_td_text style="LINE-HEIGHT: 23px"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="离开" name="btnCancel" /> 
&nbsp;&nbsp;
&nbsp;&nbsp;<input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="下注成功" name="btnCancel" /> 
</td> 
			</tr> 
	  </table> 
<tr> 
		<td align="center"> 
	</table> 
</BODY></HTML>
<?php 
function ka_memdaids($i, $b){
	$dai = ka_memuser('dan');
	global $mydata2_db;
	$params = array(':username' => $dai);
	$stmt = $mydata2_db->prepare('Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username=:username order by id');
	$stmt->execute($params);
	$drop_guands = array();
	$y = 0;
	while ($image = $stmt->fetch()){
		$y++;
		array_push($drop_guands, $image);
	}
	return $drop_guands[$i][$b] == '' ? 0 : $drop_guands[$i][$b];
}

function ka_memzongds($i, $b){
	$zong = ka_memuser('zong');
	global $mydata2_db;
	$params = array(':username' => $zong);
	$stmt = $mydata2_db->prepare('Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username=:username order by id');
	$stmt->execute($params);
	$drop_guands = array();
	$y = 0;
	while ($image = $stmt->fetch()){
		$y++;
		array_push($drop_guands, $image);
	}
	return $drop_guands[$i][$b] == '' ? 0 : $drop_guands[$i][$b];
}

function ka_memguands($i, $b){
	$guan = ka_memuser('guan');
	global $mydata2_db;
	$params = array(':username' => $guan);
	$stmt = $mydata2_db->prepare('Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username=:username order by id');
	$stmt->execute($params);
	$drop_guands = array();
	$y = 0;
	while ($image = $stmt->fetch()){
		$y++;
		array_push($drop_guands, $image);
	}
	return $drop_guands[$i][$b] == '' ? 0 : $drop_guands[$i][$b];
}
?>