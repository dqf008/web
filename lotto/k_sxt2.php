<?php 
if (!defined('PHPYOU')){
	exit('非法进入');
}

$ids = $_GET['ids'];
if ($ids == ''){
	$ids = '二肖连中';
}

if ($ids == '二肖连中'){
	$xc = 48;
	$XF = 23;
}

if ($ids == '三肖连中'){
	$xc = 49;
	$XF = 23;
}

if ($ids == '四肖连中'){
	$xc = 50;
	$XF = 23;
}

if ($ids == '五肖连中'){
	$xc = 51;
	$XF = 23;
}

if ($ids == '二肖连不中'){
	$xc = 52;
	$XF = 23;
}

if ($ids == '三肖连不中'){
	$xc = 53;
	$XF = 23;
}

if ($ids == '四肖连不中'){
	$xc = 54;
	$XF = 23;
}
?>
<link href="imgs/main_n1.css" rel="stylesheet" type="text/css"> 

<SCRIPT type="text/javascript" src="imgs/activeX_Embed.js"></SCRIPT><?php if (($Current_KitheTable[29] == 0) || ($Current_KitheTable[$XF] == 0))
{?> <script language="javascript"> 
Make_FlashPlay('imgs/T0.swf','T','780','500');
</script><?php exit();
}
$params = array(':class2' => $ids);
$stmt = $mydata2_db->prepare('Select class3,rate from ka_bl where class2=:class2 order by ID');
$stmt->execute($params);
$drop_table = array();
$y = 0;
while ($image = $stmt->fetch())
{
$y++;
array_push($drop_table, $image);
}?>



<SCRIPT language=JAVASCRIPT> 
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT> 





<SCRIPT language=JAVASCRIPT> 
<!-- 
var count_win=false;
//window.setTimeout("self.location='quickinput2.php'", 178000);
function CheckKey(){ 
  if(event.keyCode == 13) return true;
  if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("下注金额仅能输入数字!!");return false;} 
} 

function ChkSubmit(){ 

  if (eval(document.all.allgold.innerHTML)<=0 ) 
  { 
	  alert("请输入下注金额!!");
	  return false;
  } 
	  document.lt_form.submit();
	 document.all.allgold.innerHTML=0;
	  document.lt_form.num1.checked=false;
	  document.lt_form.num2.checked=false;
	  document.lt_form.num3.checked=false;
	  document.lt_form.num4.checked=false;
	  document.lt_form.num5.checked=false;
	  document.lt_form.num6.checked=false;
	  document.lt_form.num7.checked=false;
	  document.lt_form.num8.checked=false;
	  document.lt_form.num9.checked=false;
	  document.lt_form.num10.checked=false;
	  document.lt_form.num11.checked=false;
	  document.lt_form.num12.checked=false;
	  document.lt_form.Num_1.value='';
} 

function CountGold(gold,type,rtype,bb,ffb){ 
var total_gold = document.getElementById("total_gold");
switch(type) { 
		case "focus": 
			  goldvalue = gold.value;
			  if (goldvalue=='') goldvalue=0;
			  document.all.allgold.innerHTML = eval(document.all.allgold.innerHTML+"-"+goldvalue);
			  total_gold.value = document.all.allgold.innerHTML;
			  break;
		case "blur": 
	if (goldvalue!='') 
			  {goldvalue = gold.value;

			  if (goldvalue=='') goldvalue=0;


//if (rtype=='SP') { 
//var ffbb=ffb-1;
//var str1="xr_"+ffbb;
//var str2="xrr_"+ffb;

//var t_big2 = new Number(document.all[str2].value);
//var t_big1 = new Number(document.all[str1].value);
//if (rtype=='SP' && (eval(eval(goldvalue)+eval(t_big1)) >eval(t_big2) )) {gold.focus();alert("修改数据!!");return false;} 
//} 

	  if ( (eval(goldvalue) < <?=ka_memuser("xy")?>) && (goldvalue!='')) {gold.focus(); alert("下注金额不可小于最低限度:<?=ka_memuser("xy")?>!!"); return false;}
		
	
		if (rtype=='SP' && (eval(goldvalue) > <?=ka_memds($xc,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds($xc,2)?>!!"); return false;}
		
		
		if (rtype=='dx' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds(8,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds(37,3)?>!!"); return false;}
		
		if (rtype=='dx' && (eval(goldvalue) > <?=ka_memds(8,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds(8,2)?>!!"); return false;}
		
		
		if (rtype=='ds' && (eval(eval(bb)+eval(goldvalue)) > <?=ka_memds(9,3)?>)) {gold.focus(); alert("对不起,止号本期下注金额最高限制 : <?=ka_memds(9,3)?>!!"); return false;}
		if (rtype=='ds' && (eval(goldvalue) > <?=ka_memds(9,2)?>)) {gold.focus(); alert("对不起,下注金额已超过单注限额 : <?=ka_memds(9,2)?>!!"); return false;}
		

		
		
		total_gold.value = document.all.allgold.innerHTML;
	  	if (eval(document.all.allgold.innerHTML) > <?=ka_memuser("ts")?>)   {gold.focus(); alert("下注金额不可大于可用信用额度!!");    return false;}
		
		} 
			break;
		case "keyup": 
			  goldvalue = gold.value;
			  if (goldvalue=='') goldvalue=0;
		document.all.allgold.innerHTML = eval(total_gold.value+"\+"+ goldvalue);
			  break;
} 
//alert(goldvalue);
} 
//--> 
</SCRIPT> 


<style type="text/css"> 
<!-- 
body { 
  margin-left: 10px;
  margin-top: 10px;
} 
.STYLE1 {color: #FFFFFF} 
.STYLE4 {color: #333333;font-weight: bold;} 
--> 
</style> 
<noscript> 
<iframe scr=″*.htm″></iframe> 
</noscript> 

<TABLE  border="0" cellpadding="2" cellspacing="1" bordercolordark="#f9f9f9" bgcolor="#CCCCCC"width=780 > 
<TBODY> 
<TR class="tbtitle"> 
  <TD ><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td height=25><SPAN id=Lottery_Type_Name>当前期数: </SPAN>【第<?=$Current_Kithe_Num;?>期】 <span id=allgold style="display:none">0</span></TD> 
  <TD align=right colSpan=3> 

<div align="right"><?php if ($ids == '二肖连中')
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=二肖连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:ff0000;'>二肖连中</span></button>&nbsp;<?php }
else
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=二肖连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:000000;'>二肖连中</span></button>&nbsp;<?php }
if ($ids == '三肖连中')
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=三肖连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:ff0000;'>三肖连中</span></button>&nbsp;<?php }
else
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=三肖连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:000000;'>三肖连中</span></button>&nbsp;<?php }
if ($ids == '四肖连中')
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=四肖连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:ff0000;'>四肖连中</span></button>&nbsp;<?php }
else
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=四肖连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:000000;'>四肖连中</span></button>&nbsp;<?php }
if ($ids == '五肖连中')
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=五肖连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:ff0000;'>五肖连中</span></button>&nbsp;<?php }
else
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=五肖连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:000000;'>五肖连中</span></button>&nbsp;<?php }?>  <br><hr style="height:1px;" /><?php if ($ids == '二肖连不中')
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=二肖连不中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:ff0000;'>二肖连不中</span></button>&nbsp;<?php }
else
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=二肖连不中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:000000;'>二肖连不中</span></button>&nbsp;<?php }
if ($ids == '三肖连不中')
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=三肖连不中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:ff0000;'>三肖连不中</span></button>&nbsp;<?php }
else
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=三肖连不中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:000000;'>三肖连不中</span></button>&nbsp;<?php }
if ($ids == '四肖连不中')
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=四肖连不中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:ff0000;'>四肖连不中</span></button>&nbsp;<?php }
else
{?> <button onClick="javascript:location.href='index.php?action=k_sxt2&ids=四肖连不中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:20" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:000000;'>四肖连不中</span></button>&nbsp;<?php }?>
		 </div> 
  </TD></TR> 
<TR vAlign=bottom class="tbtitle"> 
  <TD width="25%" height=17><B class=font_B><?=$ids;?></B></TD> 
  <TD align=middle width="25%">开奖时间：<?=date("Y-m-d H:i:s",strtotime($Current_KitheTable['nd']));?></TD> 
  <TD align=middle width="35%">距离封盘时间： 

	<span id="span_dt_dt"></span> 
	<SCRIPT language=javascript> 
	function show_student163_time(){ 
	window.setTimeout("show_student163_time()", 1000);
	BirthDay=new Date("<?=date("m-d-Y H:i:s",strtotime($Current_KitheTable[12]));?>");
	today=new Date();
	timeold=(BirthDay.getTime()-today.getTime());
	sectimeold=timeold/1000 
	secondsold=Math.floor(sectimeold);
	msPerDay=24*60*60*1000 
	e_daysold=timeold/msPerDay 
	daysold=Math.floor(e_daysold);
	e_hrsold=(e_daysold-daysold)*24;
	hrsold=Math.floor(e_hrsold);
	e_minsold=(e_hrsold-hrsold)*60;
	minsold=Math.floor((e_hrsold-hrsold)*60);
	seconds=Math.floor((e_minsold-minsold)*60);
	if(daysold<0) 
	{ 
	daysold=0;
	hrsold=0;
	minsold=0;
	seconds=0;
	} 
	if (daysold>0){ 
	span_dt_dt.innerHTML=daysold+"天"+hrsold+":"+minsold+":"+seconds ;
	}else if(hrsold>0){ 
	span_dt_dt.innerHTML=hrsold+":"+minsold+":"+seconds ;
	}else if(minsold>0){ 
	span_dt_dt.innerHTML=minsold+":"+seconds ;
	}else{ 
	span_dt_dt.innerHTML=seconds+"秒" ;

	} 
	if (daysold<=0 && hrsold<=0  && minsold<=0 && seconds<=0) 
	window.setTimeout("self.location='index.php?action=kq'", 1);
	} 
	show_student163_time();
	</SCRIPT> 
  </TD> 
  <TD align=right width="25%"><SPAN class=Font_B 
	id=Update_Time></SPAN></TD></TR></TBODY></TABLE></td> 
</tr> 
	</table> 

<form target="leftFrame" name="lt_form"  method="post" action="index.php?action=k_sxt2save&class2=<?=$ids;?>"> 
<TABLE cellSpacing=1 cellPadding=0 width=780 border=0 class="Ball_List" > 

   <tr class="tbtitle"> 
	<td width="41" class=td_caption_1 height="28" align="center" nowrap="nowrap"><span class="STYLE54 STYLE1 STYLE1"> 肖</span></td> 
	<td width="50" class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1 STYLE1">赔率</span></td> 
	<td width="55" class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1 STYLE1">勾选</span></td> 
	<td height="28" class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE1">号码</span></td> 
	 <td width="41" class=td_caption_1 height="28" align="center" nowrap="nowrap"><span class="STYLE54 STYLE1 STYLE1">肖</span></td> 
	<td width="50" class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1 STYLE1">赔率</span></td> 
	<td width="55" class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE54 STYLE1 STYLE1">勾选</span></td> 
	<td height="28" class=td_caption_1 align="center" nowrap="nowrap" ><span class="STYLE1">号码</span></td> 
  </tr><?php 
for ($I = 0;$I <= 5;$I = $I + 1){?> 	  
<tr class="Ball_tr_H"> 
	<td width="41" height="35" align="center"  class="Jut_caption_1"><span class="STYLE4"><?=$drop_table[$I][0];?></span></td> 
	<td width="50" height="25" align="center" valign="middle" class="ball_ff"><b><span id=bl<?=$I;?>> 0 </span><span> </span></b></td> 
	<td width="55" height="25" align="center" bgcolor="#FFFFFF"><input type="checkbox" name="num<?=$I + 1;?>" value="<?=$drop_table[$I][0];?>" id="num<?=$I + 1;?>"> 
</td> 
	<td height="25" bgcolor="f1f1f1"  ><table align=left><tr>
<?php 
$params = array(':sx' => $drop_table[$I][0]);
$stmt = $mydata2_db->prepare('Select m_number from ka_sxnumber where sx=:sx order by id');
$stmt->execute($params);
$image = $stmt->fetch();
$xxm = explode(',', $image['m_number']);
$ssc = count($xxm);

for ($j = 0;$j < $ssc;$j = $j + 1)
{?>       						  
<td align=middle   height="32" width="32" class="ball_<?=Get_bs_Color(intval($xxm[$j]))?>"><img src="images/num<?=$xxm[$j]?>.gif" /></td>
<?php }?> 	  </tr></table>  	  </td> 




  <td width="41" height="35" align="center"  class="Jut_caption_1"><span class="STYLE4"><?=$drop_table[$I + 6][0];?></span></td> 
	<td width="50" height="25" align="center" valign="middle" class="ball_ff"><b><span id=bl<?=$I + 6;?>> 0 </span><span> </span></b></td> 
	<td width="55" height="25" align="center" bgcolor="#FFFFFF"><input type="checkbox" name="num<?=$I + 7;?>" value="<?=$drop_table[$I + 6][0];?>" id="num<?=$I + 7;?>"></td> 
	<td height="25" bgcolor="f1f1f1"  ><table align=left><tr><?php $params = array(':sx' => $drop_table[$I + 6][0]);
$stmt = $mydata2_db->prepare('Select m_number from ka_sxnumber where sx=:sx order by id');
$stmt->execute($params);
$image = $stmt->fetch();
$xxm = explode(',', $image['m_number']);
$ssc = count($xxm);

for ($j = 0;$j < $ssc;$j = $j + 1)
{?>       						  
<td align=middle   height="32" width="32" class="ball_<?=Get_bs_Color(intval($xxm[$j]))?>"><img src="images/num<?=$xxm[$j]?>.gif" /></td>
<?php }?> 	  </tr></table>  	  </td> 



  </tr><?php }?> 	     	  <tr> 
	<td height="35" colspan="8" align="center"  bgcolor="#FFFFFF"><table border="0" align="center" cellpadding="0" cellspacing="0"> 
	  <tr> 
		<td align="center">下注金额：</td> 
		<td width="44" align="left"> 
			<input  onkeypress="return CheckKey();" 
					  onblur="return CountGold(this,'blur','SP');" 
					  onkeyup="return CountGold(this,'keyup');" 
					  onfocus="CountGold(this,'focus');this.value='';"     style="HEIGHT: 18px" class="input1" name="Num_1" type="text" id="Num_1" size="6"></td> 
	  <td width="188" align="left">&nbsp;&nbsp;&nbsp;<input name="btnSubmit"  onclick="return ChkSubmit();" type="button"  class=but_c1 onMouseOver="this.className='but_c1M'"  onMouseOut="this.className='but_c1'" id="btnSubmit" value="提交" /> 
		&nbsp;&nbsp;<input type="reset"   class=but_c1 onMouseOver="this.className='but_c1M'"  onMouseOut="this.className='but_c1'" name="Submit3" value="重设" /></td> 
	  </tr> 
	</table></td> 
  </tr><INPUT type=hidden value=0 name=gold_all> 
</table> 
</form> 
<INPUT  type="hidden" value=0 name=total_gold id="total_gold"> 






<script> 
function MM_findObj(n, d) { //v4.01 
var p,i,x;if(!d) d=document;if((p=n.indexOf("?"))>0&&parent.frames.length) { 
  d=parent.frames[n.substring(p+1)].document;n=n.substring(0,p);} 
if(!(x=d[n])&&d.all) x=d.all[n];for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
if(!x && d.getElementById) x=d.getElementById(n);return x;
} 

function MM_changeProp(objName,x,theProp,theValue) { //v6.0 
var obj = MM_findObj(objName);
if (obj && (theProp.indexOf("style.")==-1 || obj.style)){ 
  if (theValue == true || theValue == false) 
	eval("obj."+theProp+"="+theValue);
  else eval("obj."+theProp+"='"+theValue+"'");
} 
} 

function MM_validateForm() { //v4.0 
var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
for (i=0;i<(args.length-2);i+=3) { test=args[i+2];val=MM_findObj(args[i]);
  if (val) { nm=val.name;if ((val=val.value)!="") { 
	if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
	  if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.';
	} else if (test!='R') { num = parseFloat(val);
	  if (isNaN(val)) errors+='- '+nm+' must contain a number.';
	  if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
		min=test.substring(8,p);max=test.substring(p+1);
		if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.';
  } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.';} 
} if (errors) alert('The following error(s) occurred:'+errors);
document.MM_returnValue = (errors == '');
} 

function makeRequest(url) { 
       url1 = url; 
     url = encodeURI(url);
  http_request = false;

  if (window.XMLHttpRequest) { 

	  http_request = new XMLHttpRequest();

	  if (http_request.overrideMimeType){ 

		  http_request.overrideMimeType('text/xml');

	  } 

  } else if (window.ActiveXObject) { 

	  try{ 

		  http_request = new ActiveXObject("Msxml2.XMLHTTP");

	  } catch (e) { 

		  try { 

			  http_request = new ActiveXObject("Microsoft.XMLHTTP");

		  } catch (e) { 

		  } 

	  } 

   } 
   if (!http_request) { 

	  alert("Your browser nonsupport operates at present, please use IE 5.0 above editions!");

	  return false;

   } 


//method init,no init();
http_request.onreadystatechange = init;

http_request.open('GET', url, true);

//Forbid IE to buffer memory 
http_request.setRequestHeader("If-Modified-Since","0");

//send count 
http_request.send(null);

//Updated every two seconds a page 
setTimeout("makeRequest('"+url1+"')",<?=$ftime;?>);

} 


function init() { 
  if (http_request.readyState == 4) { 

	  if (http_request.status == 0 || http_request.status == 200) { 

		  var result = http_request.responseText;


		  if(result==""){ 

			  result = "Access failure ";

		  } 

		 var arrResult = result.split("###");
		 for(var i=0;i<12;i++) 
{ 
		 arrTmp = arrResult[i].split("@@@");



num1 = arrTmp[0];//字段num1的值 
num2 = arrTmp[1];//字段num2的值 
num3 = arrTmp[2];//字段num1的值 
num4 = arrTmp[3];//字段num2的值 
num5 = arrTmp[4];//字段num2的值 
num6 = arrTmp[5];//字段num2的值 


//if (i<49){ 
//document.all["xr_"+i].value = num4;
//var sb=i+1 
//document.all["xrr_"+sb].value = num5;
//} 

var sbbn=i+1 
if (num6==1){ 
MM_changeProp('num_'+sbbn,'','disabled','1','INPUT/text')} 


var bl;
bl="bl"+i;
if (num6==1){ 
document.all[bl].innerHTML= "停";
}else{<?php $bb = 'A';
switch ($bb)
{
case 'A':?> 	  if (num2!=num3){ 
  document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+num2+"</b></font></span>";
  }else{ 
  document.all[bl].innerHTML= num2;
  }<?php break;
case 'B':?>
if (num2!=num3){ 
  document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$bsxp * 100;?>")/100+"</b></font></span>";
  }else{ 
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$bsxp * 100;?>")/100;}<?php break;
case 'C':?> if (num2!=num3){ 
  document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$csxp * 100;?>")/100+"</b></font></span>";
  }else{ 
document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$csxp * 100;?>")/100;}<?php break;
case 'D':?>
if (num2!=num3){ 
  document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+eval(Math.round(num2*100)+"-<?=$dsxp * 100;?>")/100+"</b></font></span>";
  }else{ 

document.all[bl].innerHTML= eval(Math.round(num2*100)+"-<?=$dsxp * 100;?>")/100;}<?php break;
default:?> if (num2!=num3){ 
  document.all[bl].innerHTML= "<SPAN STYLE='background-color:ffff00;WIDTH: 100%;height:25px;vertical-align:middle;' ><span style='display:inline-block;height:100%;vertical-align:middle;'></span><font color=ff0000><b>"+num2+"</b></font></span>";
  }else{ 
  document.all[bl].innerHTML= num2;
  }<?php break;
}?>
} 


} 



	  } else {//http_request.status != 200 

			  alert("Request failed! ");

	  } 

  } 

} 



function sendCommand(commandName,pageURL,strPara) 
{ 
  //功能：向pageURL页面发送数据，参数为strPara 
  //并回传服务器返回的数据 
 var oBao;
  if(window.ActiveXObject){
	//支持-通过ActiveXObject的一个新实例来创建XMLHttpRequest对象
	oBao = new ActiveXObject("Microsoft.XMLHTTP");
  }else if(window.XMLHttpRequest){//不支持
	oBao = new XMLHttpRequest();
  }
  //特殊字符：+,%,&,=,?等的传输解决办法.字符串先用escape编码的.
  var url = pageURL+"?commandName="+commandName+"&"+strPara;
  url = encodeURI(url);
  oBao.open("GET",url,false);
  oBao.send();
  //服务器端处理返回的是经过escape编码的字符串. 
  var strResult = unescape(oBao.responseText);
  return strResult;
} 


</script> 

<SCRIPT language=javascript> 
makeRequest('index.php?action=server&class1=生肖连&class2=<?=$ids;?>') 
</script>
<?php 
function ka_kk1($i){
	return 0;
	global $mydata2_db;
	global $Current_Kithe_Num;
	global $ids;
	$params = array(':kithe' => $Current_Kithe_Num, ':username' => $_SESSION['kauser'], ':class1' => '生肖连', ':class2' => $ids, ':class3' => $i);
	$stmt = $mydata2_db->prepare('select sum(sum_m) as sum_mm from ka_tan where kithe=:kithe and username=:username and class1=:class1 and class2=:class2 and class3=:class3 order by id desc');
	$stmt->execute($params);
	return $stmt->fetchColumn();
}
?>