<?php 
if (!defined('PHPYOU')){
	exit('非法进入');
}
if ($_GET['class2'] == ''){
	echo "<script>alert('非法进入!');parent.leftFrame.location.href='index.php?action=k_tm';window.location.href='index.php?action=left';</script>";
	exit();
}
$params = array(':Kithe' => $Current_Kithe_Num, ':username' => $_SESSION['kauser'], ':class1' => '生肖', ':class2' => $_GET['class2']);
$stmt = $mydata2_db->prepare('select sum(sum_m) as sum_mm from ka_tan where Kithe=:Kithe and username=:username and class1=:class1 and class2=:class2');
$stmt->execute($params);
$sum_mm = $stmt->fetchColumn();
$drop_sort = $_GET['class2'];
$zodiacNum = 0;
switch ($_GET['class2'])
{
	case '二肖': $zodiacNum = 2;
	$bmmm = 0;
	$cmmm = 0;
	$dmmm = 0;
	$R = 19;
	$XF = 23;
	$rate_id = 901;
	$urlurl = 'index.php?action=k_sx6&ids=二肖';
	break;
	case '三肖': $zodiacNum = 3;
	$bmmm = 0;
	$cmmm = 0;
	$dmmm = 0;
	$R = 20;
	$XF = 23;
	$rate_id = 913;
	$urlurl = 'index.php?action=k_sx6&ids=三肖';
	break;
	case '四肖': $zodiacNum = 4;
	$bmmm = 0;
	$cmmm = 0;
	$dmmm = 0;
	$R = 21;
	$XF = 23;
	$rate_id = 925;
	$urlurl = 'index.php?action=k_sx6&ids=四肖';
	break;
	case '五肖': $zodiacNum = 5;
	$urlurl = 'index.php?action=k_sx6&ids=五肖';
	$bmmm = 0;
	$cmmm = 0;
	$dmmm = 0;
	$R = 23;
	$XF = 23;
	$rate_id = 937;
	break;
	case '六肖': $zodiacNum = 6;
	$R = 26;
	$bmmm = $bsx6;
	$cmmm = $csx6;
	$dmmm = $dsx6;
	$XF = 23;
	$rate_id = 949;
	$urlurl = 'index.php?action=k_sx6&ids=六肖';
	break;
	case '七肖': $zodiacNum = 7;
	$R = 27;
	$bmmm = $bsx6;
	$cmmm = $csx6;
	$dmmm = $dsx6;
	$XF = 23;
	$rate_id = 961;
	$urlurl = 'index.php?action=k_sx6&ids=七肖';
	break;
	case '八肖': $zodiacNum = 8;
	$R = 28;
	$bmmm = $bsx6;
	$cmmm = $csx6;
	$dmmm = $dsx6;
	$XF = 23;
	$rate_id = 973;
	$urlurl = 'index.php?action=k_sx6&ids=八肖';
	break;
	case '九肖': $zodiacNum = 9;
	$R = 29;
	$bmmm = $bsx6;
	$cmmm = $csx6;
	$dmmm = $dsx6;
	$XF = 23;
	$rate_id = 985;
	$urlurl = 'index.php?action=k_sx6&ids=九肖';
	break;
	case '十肖': $zodiacNum = 10;
	$R = 31;
	$bmmm = $bsx6;
	$cmmm = $csx6;
	$dmmm = $dsx6;
	$XF = 23;
	$rate_id = 997;
	$urlurl = 'index.php?action=k_sx6&ids=十肖';
	break;
	case '十一肖': $zodiacNum = 11;
	$R = 31;
	$bmmm = $bsx6;
	$cmmm = $csx6;
	$dmmm = $dsx6;
	$XF = 23;
	$rate_id = 1009;
	$urlurl = 'index.php?action=k_sx6&ids=十一肖';
	break;
	default:
		echo "<script>alert('非法进入!');window.location.href='index.php?action=left';</script>";
		exit();
}?>
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
      <tbody> 
      <tr> 
      <td></td> 
      </tr> 
      </tbody> 
  </table>
<?php if (($Current_KitheTable[29] == 0) || ($Current_KitheTable[$XF] == 0)){
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=cb4619><font color=ffff00>封盘中....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"离开\" name=\"btnCancel11\" /></font></td>          </tr>      </table>"; 
  exit;
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
$rate1 = 1;
$number1 = $_POST['number1'];
$number1 = rtrim($number1, ',');
$pieces = explode(',', $number1);
$judgeCount = array();
foreach ($pieces as $k)
{
	$judgeCount[$k] = $k;
}
if ((count($judgeCount) != $zodiacNum) || (count($pieces) != $zodiacNum)){
	echo "<script Language=Javascript>alert('注单错误.请返回重新下注!');parent.leftFrame.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
	exit();
}
$array = explode(',', $aa);
$rate555 = $array[0];

for ($i = 1;$i < count($pieces);$i++){
	if ($rate555 < $array[$i])
	{
		$rate555 = $array[$i];
	}
}
$ka_bl_row = ka_bl_row($rate_id);
$rate5 = $ka_bl_row['rate'] - $mdrop;
$Y = 1;
$num = randStr();
$text = date('Y-m-d H:i:s');
$class11 = $ka_bl_row['class1'];
$class22 = $ka_bl_row['class2'];
$class33 = $number1;
$sum_m = $sum_m;
$user_ds = ka_memds($R, 1);
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
$memid = ka_memuser('id');
$params = array(':Kithe' => $Current_Kithe_Num, ':class1' => $class11, ':class2' => $class22, ':username' => $_SESSION['username']);
$stmt = $mydata2_db->prepare('Select SUM(sum_m) As sum_m from ka_tan where Kithe=:Kithe and class1=:class1 and class2=:class2 and username=:username');
$stmt->execute($params);
$rs5_sum_m = $stmt->fetchColumn();
if (ka_memds($R, 3) < ($rs5_sum_m + $sum_m)){
	echo "<script Language=Javascript>alert('对不起，超过单项限额.请反回重新下注!');parent.leftFrame.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
	exit();
}

if ($_SESSION['username'] && (0 < $sum_m)){
	$params = array(':uid' => $_SESSION['uid'], ':money' => $sum_m, ':money2' => $sum_m);
	$stmt = $mydata1_db->prepare('update k_user set money=money-:money where uid=:uid and money>=:money2');
	$stmt->execute($params);
	$q0 = $stmt->rowCount();
	if ($q0 == 1){
		$params = array(':num' => $num, ':username' => $_SESSION['username'], ':kithe' => $Current_Kithe_Num, ':adddate' => $text, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33, ':rate' => $rate5, ':sum_m' => $sum_m, ':user_ds' => $user_ds, ':dai_ds' => $dai_ds, ':zong_ds' => $zong_ds, ':guan_ds' => $guan_ds, ':dai_zc' => $dai_zc, ':zong_zc' => $zong_zc, ':guan_zc' => $guan_zc, ':dagu_zc' => $dagu_zc, ':bm' => 0, ':dai' => $dai, ':zong' => $zong, ':guan' => $guan, ':memid' => $memid, ':danid' => $danid, ':zongid' => $zongid, ':guanid' => $guanid, ':abcd' => 'A', ':lx' => 0);
		$stmt = $mydata2_db->prepare('INSERT INTO ka_tan set num=:num,username=:username,kithe=:kithe,adddate=:adddate,class1=:class1,class2=:class2,class3=:class3,rate=:rate,sum_m=:sum_m,user_ds=:user_ds,dai_ds=:dai_ds,zong_ds=:zong_ds,guan_ds=:guan_ds,dai_zc=:dai_zc,zong_zc=:zong_zc,guan_zc=:guan_zc,dagu_zc=:dagu_zc,bm=:bm,dai=:dai,zong=:zong,guan=:guan,memid=:memid,danid=:danid,zongid=:zongid,guanid=:guanid,abcd=:abcd,lx=:lx');
		$stmt->execute($params);
		$params = array(':num' => $num, ':sum_m' => $sum_m, ':sum_m2' => $sum_m, ':creationTime' => date('Y-m-d H:i:s', time() - (12 * 3600)), ':username' => $_SESSION['username']);
		$stmt = $mydata1_db->prepare('INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)SELECT uid,username,\'SIX\',\'BET\',:num,-:sum_m,money+:sum_m2,money,:creationTime FROM k_user WHERE username=:username');
		$stmt->execute($params);
	}else{
		echo "<script Language=Javascript>alert('下注失败!');parent.leftFrame.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
		exit();
	}
}else{
	exit();
}
include 'ds.php';
?>
                    <tr> 
                      <td height="22" colspan="2" align="center" bgcolor="#142F06" style="LINE-HEIGHT: 23px"><span class="STYLE3">下注成功</span></td> 
                    </tr> 
                    <tr> 
                      <td height="22" colspan="2" bgcolor="#FFFFFF" style="LINE-HEIGHT: 23px"><font color="#FF0000"><?=$class22;?>：<font color="ff6600"><?=$number1;?></font></font></td> 
                    </tr> 
                    <tr> 
                      <td width="36%" height="22" align="right" class=t_td_caption_1 style="LINE-HEIGHT: 23px"><span class="STYLE4">当前赔率：</span></td> 
                      <td width="64%" align="left" class=t_td_text style="LINE-HEIGHT: 23px"><?=$rate5;?></td> 
                    </tr> 
                    <tr> 
                      <td height="22" align="right" class=t_td_caption_1 style="LINE-HEIGHT: 23px"><span class="STYLE4">下注金额：</span></td> 
                      <td align="left" class=t_td_text style="LINE-HEIGHT: 23px"><?=$sum_m;?></td> 
                    </tr> 
                    <tr> 
                      <td height="22" align="right" class=t_td_caption_1 style="LINE-HEIGHT: 23px"><span class="STYLE4">订单号码：</span></td> 
                      <td align="left" class=t_td_text style="LINE-HEIGHT: 23px"><?=$num;?></td> 
                    </tr> 
                    <tr> 
                      <td height="22" colspan="2" align="center" class=t_td_text style="LINE-HEIGHT: 23px"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="离开" name="btnCancel" /> 
  &nbsp;&nbsp;
  &nbsp;&nbsp;<input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="下注成功" name="btnCancel" /></td> 
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