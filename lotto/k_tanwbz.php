<?php
if(!defined('PHPYOU')) {
	exit('非法进入');
}
include_once '../ajaxleft/postkey.php';
$number1 = $_POST['number1'];
$rate_id = $_POST['rate_id'];
$orderinfo = $number1 . $rate_id;
$orderkey = StrToHex($orderinfo, $postkey);
$postorderkey = $_POST['orderkey'];
if ($orderkey != $postorderkey){
	echo "<script Language=Javascript>alert('注单错误.请返回重新下注!');parent.leftFrame.location.href='index.php?action=k_gg';window.location.href='index.php?action=left';</script>";
	exit();
}
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
</style><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></HEAD>
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';}
if(window.location.host!=top.location.host){top.location=window.location;}
window.setTimeout("self.location='index.php?action=left'", 60000);
</SCRIPT>
<noscript>
<iframe scr=??.htm??</iframe>
</noscript>
<table height="3" cellspacing="0" cellpadding="0" border="0" width="180">
	  <tbody><tr>
		<td></td>
	  </tr>
	</tbody></table>
	
<?
if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=6fba2c><font color=ffff00>封盘中....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"离开\" name=\"btnCancel\" /></font></td>          </tr>      </table>"; 
  exit;
}


?>
<TABLE class=Tab_backdrop cellSpacing=0 cellPadding=0 width=180 border=0>
  <tr>
	<td valign="top" class="Left_Place"><TABLE class=t_list cellSpacing=1 cellPadding=0 width=180 border=0>
	  <tr>
          <td height="28" colspan="3" align="center" bordercolor="#cccccc" bgcolor="#142F06" style="LINE-HEIGHT: 23px"><span class="STYLE3">下注成功</span></td>
          </tr>
        <tr>
          <td height="22" align="center"class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">内容</span></td>
          <td align="center" class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">赔率</span></td>
          <td align="center" class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">下注金额</span></td>
        </tr>
<?php $rate_id = $_POST['rate_id'];
$gold = $_POST['gold'];
switch ($_POST['rtype']){

case "五不中":
$R=37;
$ratess2=0;
$urlurl="index.php?action=k_wbz&ids=五不中";
break;


case "六不中":
$R=38;
$ratess2=0;
$urlurl="index.php?action=k_wbz&ids=六不中";
break;

case "七不中":
$R=39;
$ratess2=0;
$urlurl="index.php?action=k_wbz&ids=七不中";
break;
case "八不中":
$R=40;
$ratess2=0;
$urlurl="index.php?action=k_wbz&ids=八不中";
break;
case "九不中":
$R=41;
$ratess2=0;
$urlurl="index.php?action=k_wbz&ids=九不中";
break;
case "十不中":
$R=42;
$ratess2=0;
$urlurl="index.php?action=k_wbz&ids=十不中";
break;
case "十一不中":
$R=43;
$ratess2=0;
$urlurl="index.php?action=k_wbz&ids=十一不中";
break;
case "十二不中":
$R=44;
$ratess2=0;
$urlurl="index.php?action=k_wbz&ids=十二不中";
break;


}



$sum_sum=$_POST['gold']*$_POST['icradio1'];

if ($sum_sum>ka_memuser("ts")){
echo "<script Language=Javascript>alert('对不起，下注总额不能大于可用信用额');parent.parent.leftFrame.location.href='index.php?action=k_wbz';window.location.href='index.php?action=left';</script>";
exit;
}


$number1 = $_POST['number1'];
$mu = explode('/', $number1);
$ioradio1 = 1;
$t == 3;
$t = 2;
for (;$t < (count($mu) - 1);
$t = $t + 1)
{
switch (ka_memuser('abcd'))
{
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
$num = randStr();
$text = date('Y-m-d H:i:s');
$class11="全不中";
$class22 = ka_bl($rate_id, 'class2');
$class33 = $mu[$t];
$sum_m = $_POST['gold'];
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
$rnum = explode(',', $class33);
switch ($_POST['rtype']){

case "五不中":
$r1=ka_bl($rnum[0]+1100,"rate");
$r2=ka_bl($rnum[1]+1100,"rate");
$r3=ka_bl($rnum[2]+1100,"rate");
$r4=ka_bl($rnum[3]+1100,"rate");
$r5=ka_bl($rnum[4]+1100,"rate");

$rate5=$r1;
if ($r2<$rate5){
$rate5=$r2;
}
if ($r3<$rate5){
$rate5=$r3;
}
if ($r4<$rate5){
$rate5=$r4;
}
if ($r5<$rate5){
$rate5=$r5;
}
break;


case "六不中":
$r1=ka_bl($rnum[0]+1150,"rate");
$r2=ka_bl($rnum[1]+1150,"rate");
$r3=ka_bl($rnum[2]+1150,"rate");
$r4=ka_bl($rnum[3]+1150,"rate");
$r5=ka_bl($rnum[4]+1150,"rate");
$r6=ka_bl($rnum[5]+1150,"rate");

$rate5=$r1;
if ($r2<$rate5){
$rate5=$r2;
}
if ($r3<$rate5){
$rate5=$r3;
}
if ($r4<$rate5){
$rate5=$r4;
}
if ($r5<$rate5){
$rate5=$r5;
}
if ($r6<$rate5){
$rate5=$r6;
}
break;

case "七不中":
$r1=ka_bl($rnum[0]+1200,"rate");
$r2=ka_bl($rnum[1]+1200,"rate");
$r3=ka_bl($rnum[2]+1200,"rate");
$r4=ka_bl($rnum[3]+1200,"rate");
$r5=ka_bl($rnum[4]+1200,"rate");
$r6=ka_bl($rnum[5]+1200,"rate");
$r7=ka_bl($rnum[6]+1200,"rate");

$rate5=$r1;
if ($r2<$rate5){
$rate5=$r2;
}
if ($r3<$rate5){
$rate5=$r3;
}
if ($r4<$rate5){
$rate5=$r4;
}
if ($r5<$rate5){
$rate5=$r5;
}
if ($r6<$rate5){
$rate5=$r6;
}
if ($r7<$rate5){
$rate5=$r7;
}
break;

case "八不中":
$r1=ka_bl($rnum[0]+1250,"rate");
$r2=ka_bl($rnum[1]+1250,"rate");
$r3=ka_bl($rnum[2]+1250,"rate");
$r4=ka_bl($rnum[3]+1250,"rate");
$r5=ka_bl($rnum[4]+1250,"rate");
$r6=ka_bl($rnum[5]+1250,"rate");
$r7=ka_bl($rnum[6]+1250,"rate");
$r8=ka_bl($rnum[7]+1250,"rate");

$rate5=$r1;
if ($r2<$rate5){
$rate5=$r2;
}
if ($r3<$rate5){
$rate5=$r3;
}
if ($r4<$rate5){
$rate5=$r4;
}
if ($r5<$rate5){
$rate5=$r5;
}
if ($r6<$rate5){
$rate5=$r6;
}
if ($r7<$rate5){
$rate5=$r7;
}
if ($r8<$rate5){
$rate5=$r8;
}

break;

case "九不中":
$r1=ka_bl($rnum[0]+1500,"rate");
$r2=ka_bl($rnum[1]+1500,"rate");
$r3=ka_bl($rnum[2]+1500,"rate");
$r4=ka_bl($rnum[3]+1500,"rate");
$r5=ka_bl($rnum[4]+1500,"rate");
$r6=ka_bl($rnum[5]+1500,"rate");
$r7=ka_bl($rnum[6]+1500,"rate");
$r8=ka_bl($rnum[7]+1500,"rate");
$r9=ka_bl($rnum[8]+1500,"rate");

$rate5=$r1;
if ($r2<$rate5){
$rate5=$r2;
}
if ($r3<$rate5){
$rate5=$r3;
}
if ($r4<$rate5){
$rate5=$r4;
}
if ($r5<$rate5){
$rate5=$r5;
}
if ($r6<$rate5){
$rate5=$r6;
}
if ($r7<$rate5){
$rate5=$r7;
}
if ($r8<$rate5){
$rate5=$r8;
}
if ($r9<$rate5){
$rate5=$r9;
}

break;


case "十不中":
$r1=ka_bl($rnum[0]+1550,"rate");
$r2=ka_bl($rnum[1]+1550,"rate");
$r3=ka_bl($rnum[2]+1550,"rate");
$r4=ka_bl($rnum[3]+1550,"rate");
$r5=ka_bl($rnum[4]+1550,"rate");
$r6=ka_bl($rnum[5]+1550,"rate");
$r7=ka_bl($rnum[6]+1550,"rate");
$r8=ka_bl($rnum[7]+1550,"rate");
$r9=ka_bl($rnum[8]+1550,"rate");
$r10=ka_bl($rnum[9]+1550,"rate");

$rate5=$r1;
if ($r2<$rate5){
$rate5=$r2;
}
if ($r3<$rate5){
$rate5=$r3;
}
if ($r4<$rate5){
$rate5=$r4;
}
if ($r5<$rate5){
$rate5=$r5;
}
if ($r6<$rate5){
$rate5=$r6;
}
if ($r7<$rate5){
$rate5=$r7;
}
if ($r8<$rate5){
$rate5=$r8;
}
if ($r9<$rate5){
$rate5=$r9;
}
if ($r10<$rate5){
$rate5=$r10;
}

break;

case "十一不中":
$r1=ka_bl($rnum[0]+1600,"rate");
$r2=ka_bl($rnum[1]+1600,"rate");
$r3=ka_bl($rnum[2]+1600,"rate");
$r4=ka_bl($rnum[3]+1600,"rate");
$r5=ka_bl($rnum[4]+1600,"rate");
$r6=ka_bl($rnum[5]+1600,"rate");
$r7=ka_bl($rnum[6]+1600,"rate");
$r8=ka_bl($rnum[7]+1600,"rate");
$r9=ka_bl($rnum[8]+1600,"rate");
$r10=ka_bl($rnum[9]+1600,"rate");
$r11=ka_bl($rnum[10]+1600,"rate");

$rate5=$r1;
if ($r2<$rate5){
$rate5=$r2;
}
if ($r3<$rate5){
$rate5=$r3;
}
if ($r4<$rate5){
$rate5=$r4;
}
if ($r5<$rate5){
$rate5=$r5;
}
if ($r6<$rate5){
$rate5=$r6;
}
if ($r7<$rate5){
$rate5=$r7;
}
if ($r8<$rate5){
$rate5=$r8;
}
if ($r9<$rate5){
$rate5=$r9;
}
if ($r10<$rate5){
$rate5=$r10;
}
if ($r11<$rate5){
$rate5=$r11;
}

break;



case "十二不中":
$r1=ka_bl($rnum[0]+1650,"rate");
$r2=ka_bl($rnum[1]+1650,"rate");
$r3=ka_bl($rnum[2]+1650,"rate");
$r4=ka_bl($rnum[3]+1650,"rate");
$r5=ka_bl($rnum[4]+1650,"rate");
$r6=ka_bl($rnum[5]+1650,"rate");
$r7=ka_bl($rnum[6]+1650,"rate");
$r8=ka_bl($rnum[7]+1650,"rate");
$r9=ka_bl($rnum[8]+1650,"rate");
$r10=ka_bl($rnum[9]+1650,"rate");
$r11=ka_bl($rnum[10]+1650,"rate");
$r12=ka_bl($rnum[11]+1650,"rate");

$rate5=$r1;
if ($r2<$rate5){
$rate5=$r2;
}
if ($r3<$rate5){
$rate5=$r3;
}
if ($r4<$rate5){
$rate5=$r4;
}
if ($r5<$rate5){
$rate5=$r5;
}
if ($r6<$rate5){
$rate5=$r6;
}
if ($r7<$rate5){
$rate5=$r7;
}
if ($r8<$rate5){
$rate5=$r8;
}
if ($r9<$rate5){
$rate5=$r9;
}
if ($r10<$rate5){
$rate5=$r10;
}
if ($r11<$rate5){
$rate5=$r11;
}
if ($r12<$rate5){
$rate5=$r12;
}

break;



}


switch (ka_memuser("abcd")){							  
	case "B":
$rate5=$rate5-$bzx;
	break;
	case "C":
$rate5=$rate5-$czx;
	break;
	case "D":
$rate5=$rate5-$dzx;
break;
	default:
	$Y=1;
break;
}

$danid=ka_memuser("danid");
$zongid=ka_memuser("zongid");
$guanid=ka_memuser("guanid");
$memid=ka_memuser("id");
$abcd=ka_memuser("abcd");

$array_class33 = explode(',', $class33);

for ($ii = 0;$ii < count($array_class33);$ii++){
	$array_class33[$ii] = trim($array_class33[$ii]);
	if (is_numeric($array_class33[$ii]))
	{
		$array_class33[$ii] = $array_class33[$ii] * 1;
	}
	if ((49 < $array_class33[$ii]) || ($array_class33[$ii] < 1)){
		echo "<script Language=Javascript>alert('注单错误.请返回重新下注!');parent.parent.leftFrame.location.href='index.php?action=k_wbz';window.location.href='index.php?action=left';</script>";
		exit;
	}
}
$check_class33 = array_unique($array_class33);
if (count($array_class33) != count($check_class33)){
	echo "<script Language=Javascript>alert('注单错误.请返回重新下注!');parent.parent.leftFrame.location.href='index.php?action=k_wbz';window.location.href='index.php?action=left';</script>";
	exit;
}
if ($_SESSION['username'] && (0 < $sum_m))
{
	$params = array(':uid' => $_SESSION['uid'], ':money' => $sum_m, ':money2' => $sum_m);
	$stmt = $mydata1_db->prepare('update k_user set money=money-:money where uid=:uid and money>=:money2');
	$stmt->execute($params);
	$q0 = $stmt->rowCount();
	if ($q0 == 1)
	{
		$params = array(':num' => $num, ':username' => $_SESSION['username'], ':kithe' => $Current_Kithe_Num, ':adddate' => $text, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33, ':rate' => $rate5, ':sum_m' => $sum_m, ':user_ds' => $user_ds, ':dai_ds' => $dai_ds, ':zong_ds' => $zong_ds, ':guan_ds' => $guan_ds, ':dai_zc' => $dai_zc, ':zong_zc' => $zong_zc, ':guan_zc' => $guan_zc, ':dagu_zc' => $dagu_zc, ':bm' => 0, ':dai' => $dai, ':zong' => $zong, ':guan' => $guan, ':memid' => $memid, ':danid' => $danid, ':zongid' => $zongid, ':guanid' => $guanid, ':abcd' => $abcd, ':lx' => 0, ':rate2' => $ratess2);
		$stmt = $mydata2_db->prepare('INSERT INTO ka_tan set num=:num,username=:username,kithe=:kithe,adddate=:adddate,class1=:class1,class2=:class2,class3=:class3,rate=:rate,sum_m=:sum_m,user_ds=:user_ds,dai_ds=:dai_ds,zong_ds=:zong_ds,guan_ds=:guan_ds,dai_zc=:dai_zc,zong_zc=:zong_zc,guan_zc=:guan_zc,dagu_zc=:dagu_zc,bm=:bm,dai=:dai,zong=:zong,guan=:guan,memid=:memid,danid=:danid,zongid=:zongid,guanid=:guanid,abcd=:abcd,lx=:lx,rate2=:rate2');
		$stmt->execute($params);
		$params = array(':num' => $num, ':sum_m' => $sum_m, ':sum_m2' => $sum_m, ':creationTime' => date('Y-m-d H:i:s', time() - (12 * 3600)), ':username' => $_SESSION['username']);
		$stmt = $mydata1_db->prepare('INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)SELECT uid,username,\'SIX\',\'BET\',:num,-:sum_m,money+:sum_m2,money,:creationTime FROM k_user WHERE username=:username');
		$stmt->execute($params);
	}else{
		echo "<script Language=Javascript>alert('下注失败！');parent.leftFrame.location.href='index.php?action=k_wbz';window.location.href='index.php?action=left';</script>";
		exit();
	}
}
else
{
	exit();
}?>             <tr>
				 <td height="22" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><font color="#FF0000"><?=$class22?>：<font color=ff6600><?=$mu[$t]?></font></font></td>
                    <td align="center" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><?=$rate5?></td>
                    <td align="center" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><?=$sum_m?></td>
				</tr>
<?php }?>
                <tr>
				  <td height="22" colspan="3" align="center" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="离开" name="btnCancel" />
					&nbsp;&nbsp;
					</td>
				</tr>
			</table></td>
</tr>
	  <tr>
		<td height="30" align="center">&nbsp;</td>
	  </tr>
  </table></td>
</tr>
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
	while ($image = $stmt->fetch())
	{
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