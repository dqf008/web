<?php 
if (!defined('PHPYOU')){
	exit('非法进入');
}

if ($_GET['ids'] != ''){
	$ids = $_GET['ids'];
}else{
	$ids = '二尾连中';
}

$class2 = $ids;
if ($_GET['act'] == '修改'){
	for ($tt = 1;$tt <= 10;$tt++){
		if (empty($_POST['lm' . $tt])){
			echo "<script>alert('赔率不能为空:".$_POST['Num_'.$tt]."/".$tt."!');window.history.go(-1);</script>"; 
        	exit;
		}
	}
	
	for ($tt = 1;$tt <= 10;$tt++){
		$num = $_POST['lm' . $tt];
		$num1 = $num + ka_config(3);
		$num2 = $num - ka_config(3);
		$num3 = $num + ka_config(4);
		$num4 = $num - ka_config(4);
		$num5 = $num + ka_config(5);
		$num6 = $num - ka_config(5);
		$class3 = $_POST['class3_' . $tt];
		$class2 = $_POST['class2_' . $tt];
		$text = date('Y-m-d H:i:s');
		$params = array(':adddate' => $text, ':rate' => $num, ':class2' => $class2, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_bl  set adddate=:adddate,rate=:rate where class1=\'尾数连\' and class2=:class2 and  class3=:class3');
		$stmt->execute($params);
	}
	
	echo "<script>alert('修改成功!');window.location.href='index.php?action=rake_wsl&ids=".$ids."';</script>";
	exit();
}
$params = array(':class2' => $class2);
$result = $mydata2_db->prepare('Select rate,class3,class2,locked,class1 from ka_bl where (class1=\'尾数连\' and class2=:class2)  Order By ID');
$result->execute($params);
$ShowTable = array();
$y = 0;
while ($Image = $result->fetch()){
	$y++;
	array_push($ShowTable, $Image);
}
$drop_count = $y - 1;
?>
<link rel="stylesheet" href="images/xp.css" type="text/css"> 


<script> 

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
		 for(var i=0;i<12;i++){  	      
			arrTmp = arrResult[i].split("@@@");
			num1 = arrTmp[0];//字段num1的值 
			num2 = arrTmp[1];//字段num2的值 
			num3 = arrTmp[2];//字段num1的值 
			num4 = arrTmp[3];//字段num2的值 
			var bl,lm;
			bl="bl"+i;
			lm="lm"+(i+1);
			document.all[lm].value=parseFloat(num2).toFixed(2);
			document.all[bl].innerHTML=parseFloat(num2).toFixed(2);
			
			var gold;
			gold="gold"+i;
			
			document.all[gold].innerHTML= "<font color=ff6600>"+num4+"</font>";
		 } 
		
		
		  
	  } else {//http_request.status != 200 
		  
			  alert("Request failed! ");
	  
	  } 
  
  } 

} 


function UpdateRate(commandName,inputID,cellID,strPara) 
{ 
  //功能：将strPara参数串发送给rake_update页面，并将返回结果回传 
  //传入参数：  	  inputID,cellID:要显示返回数据的页面控件名 
  //  		  strPara，包含发送给rake_update页面的参数 
  //class1:类别1 
  //ids:(即class2)标记特码为特A或特B；qtqt:调整幅度；lxlx调整方向，1为加，否则为减 
  //class3:调整的类别 
  switch(commandName) 
  { 
	  case "MODIFYRATE":  	  //更新赔率 
		  { 
			  var strResult = sendCommand(commandName,"rake_update.php",strPara);
			
			  if (strResult!="") 
			  { 
				  makeRequest('index.php?action=server&class1=尾数连&class2=<?=$ids;?>') 
				  document.all[inputID].value=parseFloat(strResult).toFixed(2);
				
			  } 
			  break;
		  } 
	  case "LOCK":  		  //关闭项目 
		  { 


			  var strResult=sendCommand(commandName,"rake_update.php",strPara);
			

			  if (strResult!="") 
			
			  { 
				  if(strResult=='1')  					
					  document.all[inputID].checked=true;
				  else 
					  document.all[inputID].checked=false;
			  }else{ 
			
			
				  document.all[inputID].checked=!document.all[inputID].checked;
			  } 
			  break;
		  } 
	  default:  	  //其它情况 
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


function adv_format(value,num) //四舍五入 
{ 
var a_str = formatnumber(value,num);
var a_int = parseFloat(a_str);
if (value.toString().length>a_str.length) 
{ 
var b_str = value.toString().substring(a_str.length,a_str.length+1) 
var b_int = parseFloat(b_str);
if (b_int<5) 
{ 
return a_str 
} 
else 
{ 
var bonus_str,bonus_int;
if (num==0) 
{ 
bonus_int = 1;
} 
else 
{ 
bonus_str = "0." 
for (var i=1;i<num;i++) 
bonus_str+="0";
bonus_str+="1";
bonus_int = parseFloat(bonus_str);
} 
a_str = formatnumber(a_int + bonus_int, num) 
} 
} 
return a_str 
} 

function formatnumber(value,num) //直接去尾 
{ 
var a,b,c,i 

a = value.toString();
b = a.indexOf('.');
c = a.length;
if (num==0) 
{ 
if (b!=-1) 
a = a.substring(0,b);
} 
else 
{ 
if (b==-1) 
{ 
a = a + ".";
for (i=1;i<=num-1;i++) 
a = a + "0";
} 
else 
{ 
a = a.substring(0,b+num+1);
for (i=c;i<=b+num-1;i++) 
a = a + "0";
} 
} 
return a 
} 

var ball_color = Array(0,0,1,1,2,2,0,0,1,1,2,0,0,1,1,2,2,0,0,1,2,2,0,0,1,1,2,2,0,0,1,2,2,0,0,1,1,2,2,0,1,1,2,2,0,0,1,1,2);
var bcolor = Array('red','blue','green');

function sel_col_ball(color) 
{ 
  var c;
  var str1 
  var zmzm 
  var zmn=0.5 
  var zmnn=0.1 
  switch(color) { 
	  case 'blue': 
		  c = 1;
		  break;
	  case 'red': 
		  c = 0;
		  break;
	  case 'green': 
		  c = 2;
		  break;
	  case 'alal': 
		  c = 4;
		  break;
	  case 'all': 
		  c = 5;
		  break;
	  default: 
		  return;
		  break;
  } 



  if (c==4 ){ 
	
	
	  var m=0 
  for(i=0;i<12 ;i++) 
  { 
			
	  m++ 
	

	
		  str1="lm"+m;
		  var t_big = new Number(document.all[str1].value);
t_big*=10000;
t_big+=10000*zmnn;
t_big/=10000;
document.all[str1].value=adv_format(t_big,2);

	
		
		
	
} 


  }else{ 

  var m=0 
  for(i=0;i<10 ;i++) 
  { 
			
	  m++ 
	

	
		  str1="lm"+m;
		  var t_big = new Number(document.all[str1].value);
t_big*=10000;
t_big+=10000*zmnn;
t_big/=10000;
document.all[str1].value=adv_format(t_big,2);

	
		
		
	
} 
	
	
	
	
  } 
} 


function sel_col_ball1(color,sj) 
{ 
  var c;
  var str1 
  var zmzm 
  var zmn=0.5 
  var zmnn=0.1 
  switch(color) { 
	  case 'blue': 
		  c = 1;
		  break;
	  case 'red': 
		  c = 0;
		  break;
	  case 'green': 
		  c = 2;
		  break;
	  case 'alal': 
		  c = 4;
		  break;
	  case 'all': 
		  c = 5;
		  break;
	  default: 
		  return;
		  break;
  } 



  if (c==4 ){var m=0 
  for(i=0;i<10 ;i++) 
  { 
			
	  m++ 
	

	
		  str1="lm"+m;
		  var t_big = new Number(document.all[str1].value);
t_big*=10000;
t_big-=10000*zmnn;
t_big/=10000;
document.all[str1].value=adv_format(t_big,2);

	
		
		
	
} 




	
	
	  //// document.all.t_double.value=eval(document.all.t_double.value+"-"+zmnn);
	   ///document.all.t_big.value=eval(document.all.t_big.value+"-"+zmnn);
	   ///document.all.t_small.value=eval(document.all.t_small.value+"-"+zmnn);
	  /// document.all.h_signle.value=eval(document.all.h_signle.value+"-"+zmnn);
	  //document.all.h_double.value=eval(document.all.h_double.value+"-"+zmnn);


  }else{ 

  var m=0 
  for(i=0;i<10 ;i++) 
  { 
			
	  m++ 
	

		  if (ball_color[i] == c) 
	  { 
		
		  str1="lm"+m;
	  zmzm=document.all[str1].value;
		  zmzm=eval(zmzm+"-"+sj);
		
		   document.all[str1].value =zmzm ;
		
		
	  } 
} 
	
	
	
	
  } 
} 



function j_soj(a,b,c) 
{ 






if (c==1 ){ 



var t_big = new Number(document.all[a].value);
t_big*=100;
t_big+=100*b;
t_big/=100;
document.all[a].value=adv_format(t_big,2);



  }else{ 

var t_big = new Number(document.all[a].value);
//t_big*=100;
t_big-=b;
//t_big/=100;
document.all[a].value=adv_format(t_big,2);


  } 


} 




function j_dx(b,c,sj) 
{ 

var zmn=0.5;


switch(b) { 
	  case '1': 
		
		  s=25;
		  e=50;
		  break;
	  case '2': 
	
	
	  s=1;
	  e=25;
		  break;
	
		
		
	  case '20': 
		  d = 20;
		  break;
	  default: 
		  return;
		  break;
  } 


if (c==1 ){ 


  for(i=s;i<e ;i++) 
  {  			
	
	
		
		  str1="Num_"+i;
	  zmzm=document.all[str1].value;
		  zmzm=eval(zmzm+"+"+sj);
		
		   document.all[str1].value =zmzm ;
		
		
	
} 





  }else{ 

for(i=s;i<e ;i++) 
  {  			
	
	
		
		  str1="Num_"+i;
	  zmzm=document.all[str1].value;
		  zmzm=eval(zmzm+"-"+sj);
		
		   document.all[str1].value =zmzm ;
	
	
} 


  } 


} 


function j_ds(b,c,sj) 
{ 

var zmn=0.5;


switch(b) { 
	  case '1': 
		
		
		  var e=1;
		  break;
	  case '2': 
	
		
	  e=0;
	
		  break;
	
		
		
	  case '20': 
		  d = 20;
		  break;
	  default: 
		  return;
		  break;
  } 
  m=0 

if (c==1 ){ 


for(i=0;i<49 ;i++) 
  { 
  m++ 
  if ((i+1) % 2 == e) 
  {  			
	
	
		
		  str1="Num_"+m;
	  zmzm=document.all[str1].value;
		  zmzm=eval(zmzm+"+"+sj);
		
		   document.all[str1].value =zmzm ;
		
		
	
} 

} 



  }else{ 
  m=0 

for(i=0;i<49 ;i++) 
  {m++ 
  if ((i+1) % 2 == e) 
  {  			
	
	
		
		  str1="Num_"+m;
	  zmzm=document.all[str1].value;
		  zmzm=eval(zmzm+"-"+sj);
		
		   document.all[str1].value =zmzm ;
		
		
	
} 

} 


  } 


} 


function j_dsx(b,c,sj) 
{ 

var zmn=0.5;


switch(b) { 
	  case '1': 
		  s=25;
		  f=50;
		  e=1;
		  break;
	  case '2': 
	
	  s=25;
	  f=50;
	
	  e=0;
		  break;
		
  case '3': 
		  s=1;
		  f=25;
		  e=1;
		  break;
	  case '4': 
	
	  s=1;
	  f=25;
	
	  e=0;
		  break;
	
	
		
		
	  case '20': 
		  d = 20;
		  break;
	  default: 
		  return;
		  break;
  } 


if (c==1 ){ 


for(i=s;i<f ;i++) 
  { 

  if ((i+1) % 2 == e) 
  {  			
	
	
		
		  str1="Num_"+i;
	  zmzm=document.all[str1].value;
		  zmzm=eval(zmzm+"+"+sj);
		
		   document.all[str1].value =zmzm ;
		
		
	
} 

} 



  }else{ 

m=0 
for(i=s;i<f ;i++) 
  { 

  if ((i+1) % 2 == e) 
  {  			
	
	
		
		  str1="Num_"+i;
	  zmzm=document.all[str1].value;
		  zmzm=eval(zmzm+"-"+sj);
		
		   document.all[str1].value =zmzm ;
		
		
	
} 

} 


  } 


} 








</SCRIPT> 
<style type="text/css"> 
<!-- 
.STYLE3 {color: #FF0000} 
.style2 {color: #0000FF} 
--> 
</style> 

<noscript> 
<iframe scr=″*.htm″></iframe> 
</noscript> 

<div align="center"> 
<link rel="stylesheet" href="xp.css" type="text/css"> 
<table width="100%" border="0" cellspacing="0" cellpadding="5"> 
<tr class="tbtitle" > 
 <td width="100%" colspan="2"><?php require_once 'retop.php';?></td> 
</tr> 
<tr > 
 <td height="5" colspan="2"></td> 
</tr> 
<tr > 
 <td><font color="#FF0000"> <strong><?=$ids;?>                   </strong></font></td> 
		  <td><div align="right"> 
		  <button type="button" onClick="javascript:location.href='index.php?action=rake_wsl&ids=二尾连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:<?=$z1color;?>;'>二尾连中</span></button>&nbsp;
		  <button type="button" onClick="javascript:location.href='index.php?action=rake_wsl&ids=三尾连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:<?=$z1color;?>;'>三尾连中</span></button>&nbsp;
		  <button type="button" onClick="javascript:location.href='index.php?action=rake_wsl&ids=四尾连中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:<?=$z2color;?>;'>四尾连中</span></button> 
		  <button type="button" onClick="javascript:location.href='index.php?action=rake_wsl&ids=二尾连不中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:<?=$z2color;?>;'>二尾连不中</span></button> 
		  <button type="button" onClick="javascript:location.href='index.php?action=rake_wsl&ids=三尾连不中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:<?=$z2color;?>;'>三尾连不中</span></button> 
		  <button type="button" onClick="javascript:location.href='index.php?action=rake_wsl&ids=四尾连不中';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:<?=$z2color;?>;'>四尾连不中</span></button> 
		</div></td>    
</tr> 
</table> 

<table border="1" align="center" cellspacing="1" cellpadding="2" bordercolor="f1f1f1" bordercolordark="#FFFFFF" width="99%">
   <form name="form1" method="post" action="index.php?action=rake_wsl&act=修改&ids=<?=$ids?>"> <TBODY>
	  <TR align=center>
		<TD height=26 colSpan=2 bordercolor="cccccc" bgcolor="#FDF4CA" >类型</TD>
		<TD width="22%" bordercolor="cccccc" bgcolor="#FDF4CA" >
		赔率/封号</TD>
		<TD width="22%" bordercolor="cccccc" bgcolor="#FDF4CA" >当前赔率</TD>
		<TD width="26%" bordercolor="cccccc" bgcolor="#FDF4CA" >下注金额</TD>
	  </TR>
	 <?
	 for ($I=0; $I<count($ShowTable); $I=$I+1)
{?> 
	  <TR>
		<TD width="15%" align="center" bordercolor="cccccc"><?=$ShowTable[$I][2]?></TD>
		<TD width="15%" align="center" bordercolor="cccccc"><?=$ShowTable[$I][1]?></TD>
		<TD align="center" bordercolor="cccccc"><table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><INPUT  style="HEIGHT: 18px"  class="input1" size=10 value='<?=$ShowTable[$I][0]?>' name=lm<?=$I+1?>>
				<input  name="class3_<?=$I+1?>" value="<?=$ShowTable[$I][1]?>" type="hidden" >
				<input name="class2_<?=$I+1?>" value="<?=$ShowTable[$I][2]?>" type="hidden" ></td>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','lm<?=$I+1?>','bl<?=$I?>','class1=<?=$ShowTable[$I][4]?>&ids=<?=$ShowTable[$I][2]?>&sqq=sqq&lxlx=1&qtqt=0.01&class3=<?=$ShowTable[$I][1]?>');"><img src="images/bvbv_01.gif"   width="19" height="17" border="0"></a></td>
				</tr>
				<tr>
				  <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','lm<?=$I+1?>','bl<?=$I?>','class1=<?=$ShowTable[$I][4]?>&ids=<?=$ShowTable[$I][2]?>&sqq=sqq&lxlx=0&qtqt=0.01&class3=<?=$ShowTable[$I][1]?>');"><img src="images/bvbv_02.gif" width="19" height="17" border="0"  ></a></td>
				</tr>
			</table></td>
			<td><input name="checkbox" type=checkbox id=lock<?=$I?> style="zoom:95%" title="关闭该项" onClick="UpdateRate('LOCK','lock<?=$I?>','','class1=<?=$ShowTable[$I][4]?>&ids=<?=$ShowTable[$I][2]?>&sqq=sqq&class3=<?=$ShowTable[$I][1]?>&lock='+this.checked);" value="TRUE"  <? if ($ShowTable[$I][3]==1){echo "checked";}?>></td>
		  </tr>
		</table></TD>
		<TD align="center" bordercolor="cccccc"><span id=bl<?=$I?>><?=$ShowTable[$I][0]?></span></TD>
		<TD align="center" bordercolor="cccccc" ><span id=gold<?=$I?>>0</span></TD>
	  </TR>
	 
	  <? }?>
	  <TR>
		<TD colspan="5" align="center" bordercolor="cccccc"><table width="98" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="88" align="center"><input name="button2"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type=button onClick="javascript:sel_col_ball('alal')" value=赔率增加></td>
			<td width="88" align="center"><INPUT name="button3"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type=button onClick="javascript:sel_col_ball1('alal')" value=赔率减少></td>
			<td width="88" align="center"><input type="submit"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" name="Submit2" value="提交" /></td>
			<td width="88" align="center"><input type="reset"    class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" name="Submit3" value="重置" /></td>
			<td>&nbsp;</td>
		  </tr>
		</table></TD>
	  </TR>
	</TBODY> </form> 
</TABLE> 
	
	<SCRIPT language=javascript> 
makeRequest('index.php?action=server&class1=尾数连&class2=<?=$ids;?>')</script> 
