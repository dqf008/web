<?php 
if (!defined('PHPYOU')){
	exit('非法进入');
}
$params = array(':kithe' => $Current_Kithe_Num, ':username' => $_SESSION['kauser'], ':class1' => '过关');
$stmt = $mydata2_db->prepare('select sum(sum_m) as sum_mm from ka_tan where kithe=:kithe and username=:username and class1=:class1 order by id desc');
$stmt->execute($params);
$sum_mm = $stmt->fetchColumn();
$ggpz = ka_config(8);
$XF = 19;
$R = 12;
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
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';}
if(window.location.host!=top.location.host){top.location=window.location;}
window.setTimeout("self.location='index.php?action=left'", 60000);
</SCRIPT>
<SCRIPT language=javascript>var count_win=false;
function CheckKey(){
if(event.keyCode == 13) return true;
if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("下注金额仅能输入数字!!");return false;}
}
function SubChk(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert("请输入下注金额!!");
return false;
}
var zmnh;
var zmnh1;
zmnh1=Math.round(document.all.gold.value * document.all.ioradio.value /1000);
zmnh=<?=$ggpz;?>;
zmnh2=Math.round(zmnh/zmnh1 );
if (Math.round(document.all.gold.value * document.all.ioradio.value /1000)><?=$ggpz;?>){
document.all.gold.focus();
alert('你最多只可以下:'+Math.round(zmnh/(document.all.ioradio.value/1000))+'!!!');
return false;}
if(isNaN(document.all.gold.value) == true){
document.all.gold.focus();
alert("下注金额仅能输入数字!!");
return false;
}
if(eval(document.all.gold.value) < <?=ka_memuser("xy")?>){
document.all.gold.focus();
alert("下注金额不可小于最低下注金额:<?=ka_memuser("xy")?>!!");
return false;
}
if(eval(document.all.gold.value) > <?=ka_memds($R,3)?>){
document.all.gold.focus();
alert("对不起,本期有下注金额最高限制 : <?=ka_memds($R,3)?>  !!");
return false;
}
if(eval(document.all.gold.value) > <?=ka_memds($R,2)?>){
document.all.gold.focus();
alert("下注金额不可大于单注限额:<?=ka_memds($R,2)?>!!");
return false;
}
if((<?=$sum_mm?>+eval(document.all.gold.value)) > <?=ka_memds($R,3)?>){
document.all.gold.focus();
alert("本期累计下注共: <?=$sum_mm?>\n下注金额已超过单期限额!!");
return false;
}
if(eval(document.all.gold.value) > <?=ka_memuser("ts")?>){
document.all.gold.focus();
alert("下注金额不可大于信用额度:<?=ka_memuser("ts")?>!!");
return false;
}
//if(!confirm("可蠃金额:"+Math.round(document.all.gold.value * document.all.ioradio.value / 1000 - document.all.gold.value)+"是否确定下注?")){return false;}
document.all.btnCancel.disabled = true;
document.all.btnSubmit.disabled = true;
document.LAYOUTFORM.submit();
}
function CountWinGold(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert('未输入下注金额!!!');
}else{
document.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value /1000 - document.all.gold.value);
var zmnh;
var zmnh1;
zmnh1=Math.round(document.all.gold.value * document.all.ioradio.value /1000);
zmnh=<?=$ggpz;?>;
zmnh2=Math.round(zmnh/zmnh1 );
if (Math.round(document.all.gold.value * document.all.ioradio.value /1000)><?=$ggpz;?>){document.all.gold.focus();
alert('你最多只可以下:'+Math.round(zmnh/(document.all.ioradio.value/1000))+'!!!');}
count_win=true;
}
}
function CountWinGold1(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert('未输入下注金额!!!');
}else{
document.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value) - document.all.gold.value;
count_win=true;
}
}
</SCRIPT>
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>
<table height="3" cellspacing="0" cellpadding="0" border="0" width="180">
	  <tbody><tr>
		<td></td>
	  </tr>
	</tbody></table><?php if (($Current_KitheTable[29] == 0) || ($Current_KitheTable[$XF] == 0))
{?> <table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=cb4619><font color=ffff00>封盘中....<input class=button_a onClick="self.location='index.php?action=left'" type="button" value="离开" name="btnCancel11" /></font></td>          </tr>      </table><?php exit();
}?>
									
  <form action="index.php?action=k_tangg&class2=过关" method="post"  onSubmit="return false" name="LAYOUTFORM" id="LAYOUTFORM" >  									
<TABLE class=Tab_backdrop cellSpacing=0 cellPadding=0 width=180 border=0>
<tr>
  <td valign="top" class="Left_Place">
	  <TABLE class=t_list cellSpacing=1 cellPadding=0 width=180 border=0>
		<tr>
		  <td height="25" colspan="2" align="center" bgcolor="#142F06"><span class="STYLE3">确认下注</span></td>
		</tr>

	  <tr>
		<td width="35%" height="25" colspan="2"  style="LINE-HEIGHT: 22px" align="center" bgcolor="#FFFFFF">
<?php 
$z = 0;
$rate2 = 1;

for ($t = 1;$t <= 18;$t = $t + 1){
if ($_POST['game'.$t] != ''){
	$z = $z + 1;
	$rate_id = $_POST['game' . $t] + 619;
	$rate2 = $rate2 * ka_bl($rate_id, 'rate');
	$orderinfo .= $rate_id;
?>             
	<FONT color=#cc0000><FONT color=#cc0000><?=ka_bl($rate_id,"class2")?>&nbsp;<?=ka_bl($rate_id,"class3")?></FONT> @ <FONT
color=#ff0000><B><?=ka_bl($rate_id,"rate")?></B></FONT></FONT>&nbsp;&nbsp;&nbsp;&nbsp;
            <INPUT  type=hidden value="<?=$rate_id?>" name=rate_id<?=$t?>>
		  <br>
<?php }
}?> </td>
	  </tr><?php include_once '../ajaxleft/postkey.php';
$orderkey = StrToHex($orderinfo, $postkey);?>        <tr>
		<td height="25" colspan="2"  bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><span class="STYLE4"> 模式&nbsp;:&nbsp;</span>
			<select name="select">
			  <option >单注</option>
			</select>
		  <select name="select">
			  <option value="<?=$z;?>"><?=$z;?>串1</option>
			</select>
		  @<?=floor($rate2 * 100) / 100;?></td>
	  </tr>
	  <tr>
		<td height="25" colspan="2"  bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;下注金额:
		  <INPUT class="input1" onKeyPress="return CheckKey()" id=gold
onkeyup="return CountWinGold()" maxLength=8 size=8
name=gold></td>
	  </tr>
	  <tr>
		<td height="25" colspan="2"  bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;可蠃金额: <FONT id=pc color=#ff0000>0</FONT></td>
	  </tr>
	  <TR>
		<TD height="25" colspan="2"  bgcolor="#ffffff">&nbsp;单注限额:<?=ka_memds($R, 2);?></TD>
	  </TR>
	  <TR>
		<TD height="25" colspan="2"  bgcolor="#ffffff">&nbsp;单号限额:<?=ka_memds($R, 3);?></TD>
	  </TR>
	  <tr>
		<td height="30" colspan="2"  align="center" bgcolor="#ffffff" style="LINE-HEIGHT: 23px">
			<input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left';" type="button" value="放弃" name="btnCancel" />
		  &nbsp;&nbsp;
		  <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type="submit" value="确定" onclick=SubChk(); name="btnSubmit" />
		</td>
	  </tr>
	  <INPUT type=hidden
value=SP11 name=concede>
  </table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td height="3"></td>
		</tr>
	</table></td>
</tr>
</table>
	  <INPUT type=hidden value='<?=$rate2 * 1000;?>' name=ioradio>
	  <input type="hidden" value="<?=$orderkey;?>" name="orderkey" />
	</FORM>
</BODY></HTML>
