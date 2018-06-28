<?php
if (!defined('PHPYOU')){
	exit('非法进入');
}
include_once '../ajaxleft/postkey.php';
$number1 = $_POST['number1'];
$number2 = $_POST['number2'];
$number3 = $_POST['number3'];
$rate_id = $_POST['rate_id'];
$orderinfo = $number1 . $number2 . $number3 . $rate_id;
$orderkey = StrToHex($orderinfo, $postkey);
$postorderkey = $_POST['orderkey'];
if ($orderkey != $postorderkey){
	echo "<script Language=Javascript>alert('注单错误.请返回重新下注！');parent.leftFrame.location.href='index.php?action=k_lm';window.location.href='index.php?action=left';</script>";
	exit();
}
$number3 = $_POST['number3'];
$number2 = $_POST['number2'];
$number3 = $number2 . '--' . $number3;
$XF = 21;
?>
<HTML>
<HEAD>
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
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></HEAD>
<SCRIPT language=JAVASCRIPT>
  if(self == top) {location = '/';}
  if(window.location.host!=top.location.host){top.location=window.location;}
  window.setTimeout("self.location='index.php?action=left'", 60000);
</SCRIPT>
<noscript>
<iframe scr=�?.htm�?</iframe>
</noscript>
<table height="3" cellspacing="0" cellpadding="0" border="0" width="180">
  <tbody>
	  <tr>
		  <td></td>
	  </tr>
  </tbody>
</table>
<?php if (($Current_KitheTable[29] == 0) || ($Current_KitheTable[$XF] == 0)){
	  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=cb4619><font color=ffff00>封盘中....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"离开\" name=\"btnCancel\" /></font></td>          </tr>      </table>"; 
  	  exit;
}?> 
<TABLE class=Tab_backdrop cellSpacing=0 cellPadding=0 width=180 border=0>
  <tr>
	  <td valign="top" class="Left_Place">
		  <TABLE class=t_list cellSpacing=1 cellPadding=0 width=180 border=0>
			  <tr>
				  <td height="28" colspan="3" align="center" bordercolor="#cccccc" bgcolor="#142F06" style="LINE-HEIGHT: 23px"><span class="STYLE3">下注成功</span></td>
			  </tr>
			  <tr>
				  <td height="22" align="center"class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">内容</span></td>
				  <td align="center" class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">赔率</span></td>
				  <td align="center" class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">金额</span></td>
			  </tr>
<?php 
$rate_id = $_POST['rate_id'];
$ka_bl_row = ka_bl_row($rate_id);
$gold = $_POST['gold'];
switch ($ka_bl_row['class2']){
case '三全中': $checkcount = 3;
$R = 14;
$ratess2 = 0;
break;
case '二全中': $checkcount = 2;
$R = 13;
$ratess2 = 0;
break;
case '三中二': $checkcount = 3;
$ratess2 = ka_bl('618', 'rate');
$l_type = '中二';
$R = 15;
break;
case '二中特': $checkcount = 2;
$ratess2 = ka_bl('614', 'rate');
$l_type = '中特';
$R = 16;
break;
case '特串': $checkcount = 2;
$R = 17;
$ratess2 = 0;
break;
case '四中一': $checkcount = 4;
$R = 45;
$ratess2 = 0;
break;
default:
	echo "<script>alert('非法进入!');window.location.href='index.php?action=left';</script>";
	exit();
}
$sum_sum = $_POST['gold'] * $_POST['icradio1'];
if (ka_memuser('ts') < $sum_sum){
	echo "<script Language=Javascript>alert('对不起，下注总额不能大于可用信用额');parent.leftFrame.location.href='index.php?action=k_lm';window.location.href='index.php?action=left';</script>";
	exit();
}
$number1 = $_POST['number1'];
$mu = explode('/', $number1);
$ioradio1 = 1;
$t == 3;
$t = 2;
for (;$t < (count($mu) - 1);
$t = $t + 1)
{
$rate5 = $ka_bl_row['rate'];
$Y = 1;
$num = randStr();
$text = date('Y-m-d H:i:s');
$class11 = '连码';
$class22 = $ka_bl_row['class2'];
$class33 = $mu[$t];
$sum_m = $_POST['gold'];
$ka_memds_row = ka_memds_row($R);
$user_ds = $ka_memds_row[1];
$dai_ds = 0;
$zong_ds = 0;
$guan_ds = 0;
$dai_zc = 0;
$zong_zc = 0;
$guan_zc = 0;
$dagu_zc = 0;
$dai = 'daili';
$zong = 'zong';
$guan = 'guan';
$danid = 3;
$zongid = 2;
$guanid = 1;
$abcd = 'A';
$memid = ka_memuser('id');
$class33 = trim($class33, ',');
$array_class33 = explode(',', $class33);
if ($checkcount != count($array_class33)){
	echo "<script Language=Javascript>alert('注单错误.请返回重新下注！');parent.leftFrame.location.href='index.php?action=k_lm';window.location.href='index.php?action=left';</script>";
	exit();
}

for ($ii = 0;$ii < count($array_class33);$ii++){
	$array_class33[$ii] = trim($array_class33[$ii]);
	if (is_numeric($array_class33[$ii]))
	{
		$array_class33[$ii] = $array_class33[$ii] * 1;
	}
	if ((49 < $array_class33[$ii]) || ($array_class33[$ii] < 1)){
		echo "<script Language=Javascript>alert('注单错误.请返回重新下注！');parent.leftFrame.location.href='index.php?action=k_lm';window.location.href='index.php?action=left';</script>";
		exit();
	}
}
$check_class33 = array_unique($array_class33);
if (count($array_class33) != count($check_class33)){
	echo "<script Language=Javascript>alert('注单错误.请返回重新下注！');parent.leftFrame.location.href='index.php?action=k_lm';window.location.href='index.php?action=left';</script>";
	exit();
}
$params = array(':Kithe' => $Current_Kithe_Num, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33, ':username' => $_SESSION['username']);
$stmt = $mydata2_db->prepare('Select SUM(sum_m) As sum_m from ka_tan where Kithe=:Kithe and class1=:class1 and class2=:class2 and class3=:class3 and username=:username');
$stmt->execute($params);
$rs5_sum_m = $stmt->fetchColumn();
if ($ka_memds_row[3] < ($rs5_sum_m + $sum_m)){
	echo "<script Language=Javascript>alert('对不起，超过单项限额.请反回重新下注！');parent.leftFrame.location.href='index.php?action=k_lm';window.location.href='index.php?action=left';</script>";
	exit();
}

if ($_SESSION['username'] && (0 < $sum_m)){
	$params = array(':uid' => $_SESSION['uid'], ':money' => $sum_m, ':money2' => $sum_m);
	$stmt = $mydata1_db->prepare('update k_user set money=money-:money where uid=:uid and money>=:money2');
	$stmt->execute($params);
	$q0 = $stmt->rowCount();
	if ($q0 == 1){
		$params = array(':num' => $num, ':username' => $_SESSION['username'], ':kithe' => $Current_Kithe_Num, ':adddate' => $text, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33, ':rate' => $rate5, ':sum_m' => $sum_m, ':user_ds' => $user_ds, ':dai_ds' => $dai_ds, ':zong_ds' => $zong_ds, ':guan_ds' => $guan_ds, ':dai_zc' => $dai_zc, ':zong_zc' => $zong_zc, ':guan_zc' => $guan_zc, ':dagu_zc' => $dagu_zc, ':bm' => 0, ':dai' => $dai, ':zong' => $zong, ':guan' => $guan, ':memid' => $memid, ':danid' => $danid, ':zongid' => $zongid, ':guanid' => $guanid, ':abcd' => $abcd, ':lx' => 0, ':rate2' => $ratess2);
		$stmt = $mydata2_db->prepare('INSERT INTO ka_tan set  num=:num, username=:username, kithe=:kithe, adddate=:adddate, class1=:class1, class2=:class2, class3=:class3, rate=:rate, sum_m=:sum_m, user_ds=:user_ds, dai_ds=:dai_ds, zong_ds=:zong_ds, guan_ds=:guan_ds, dai_zc=:dai_zc, zong_zc=:zong_zc, guan_zc=:guan_zc, dagu_zc=:dagu_zc, bm=:bm, dai=:dai, zong=:zong, guan=:guan, memid=:memid, danid=:danid, zongid=:zongid, guanid=:guanid, abcd=:abcd, lx=:lx, rate2=:rate2');
		$stmt->execute($params);
		$params = array(':num' => $num, ':sum_m' => $sum_m, ':sum_m2' => $sum_m, ':creationTime' => date('Y-m-d H:i:s', time() - (12 * 3600)), ':username' => $_SESSION['username']);
		$stmt = $mydata1_db->prepare('INSERT INTO k_money_log  (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT uid,username,\'SIX\',\'BET\',:num,-:sum_m,money+:sum_m2,money,:creationTime FROM k_user WHERE username=:username');
		$stmt->execute($params);
	}else{
		echo "<script Language=Javascript>alert('下注失败!');parent.leftFrame.location.href='index.php?action=k_lm';window.location.href='index.php?action=left';</script>";
		exit();
	}
}else{
	exit();
}
?>                         
				  <tr>
                    <td height="22" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><font color="#FF0000"><?=$class22?>：<font color=ff6600><?=$mu[$t]?></font></font></td>
                    <td align="center" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><?=$rate5?></td>
                    <td align="center" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><?=$sum_m?></td>
                  </tr>
<?php }
if ($q0 == 1){
$params = array(':num' => $num, ':username' => $_SESSION['username'], ':kithe' => $Current_Kithe_Num, ':adddate' => $text, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33, ':rate' => $rate5, ':sum_m' => $sum_m, ':user_ds' => $user_ds, ':dai_ds' => $dai_ds, ':zong_ds' => $zong_ds, ':guan_ds' => $guan_ds, ':dai_zc' => $dai_zc, ':zong_zc' => $zong_zc, ':guan_zc' => $guan_zc, ':dagu_zc' => $dagu_zc, ':bm' => 0, ':dai' => $dai, ':zong' => $zong, ':guan' => $guan, ':memid' => $memid, ':danid' => $danid, ':zongid' => $zongid, ':guanid' => $guanid, ':abcd' => $abcd, ':lx' => 0, ':rate2' => $ratess2);
$stmt = $mydata2_db->prepare('INSERT INTO ka_tong set   num=:num,  username=:username,  kithe=:kithe,  adddate=:adddate,  class1=:class1,  class2=:class2,  class3=:class3,  rate=:rate,  sum_m=:sum_m,  user_ds=:user_ds,  dai_ds=:dai_ds,  zong_ds=:zong_ds,  guan_ds=:guan_ds,  dai_zc=:dai_zc,  zong_zc=:zong_zc,  guan_zc=:guan_zc,  dagu_zc=:dagu_zc,  bm=:bm,  dai=:dai,  zong=:zong,  guan=:guan,  memid=:memid,  danid=:danid,  zongid=:zongid,  guanid=:guanid,  abcd=:abcd,  lx=:lx,  rate2=:rate2');
$stmt->execute($params);
}
?>
			  <tr>
				  <td height="22" colspan="3" align="center" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="离开" name="btnCancel" />
				  &nbsp;&nbsp;
				  &nbsp;&nbsp;<input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="下注成功" name="btnCancel" /></td>
			  </tr>
		  </table>
	  </td>
  </tr>
  <tr>
	  <td height="30" align="center">&nbsp;</td>
  </tr>
</table>
</BODY>
</HTML>
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
	while ($image = $stmt->fetch())
	{
		$y++;
		array_push($drop_guands, $image);
	}
	return $drop_guands[$i][$b] == '' ? 0 : $drop_guands[$i][$b];
}

?>