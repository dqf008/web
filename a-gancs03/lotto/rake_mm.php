<?php 
if (!defined('PHPYOU')){
	exit('非法进入');
}

if ($_GET['ids'] != ''){
	$ids = $_GET['ids'];
}else{
	$ids = '特A';
}

if ($ids == '特A'){
	$z2color = '494949';
	$z1color = 'ff0000';
}else{
	$z1color = '494949';
	$z2color = 'ff0000';
}

if ($_GET['save'] == 'save')
{
	if (empty($_POST['bl'])){
		echo "<script>alert('赔率不能为空!');window.history.go(-1);</script>"; 
  		exit;
	}
	
	for ($tt = 1;$tt <= 49;$tt++){
		$num = $_POST['bl'] + ka_config(3);
		$num1 = $_POST['bl'] - ka_config(3);
		if ($_POST['dx'] == '全部'){
			if ($_GET['ids'] == '特A'){
				$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
				$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
				$stmt->execute($params);
				$params = array(':mrate' => $num, ':class3' => $tt);
				$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特B\' and  class3=:class3');
				$stmt->execute($params);
			}else{
				$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
				$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
				$stmt->execute($params);
				$params = array(':mrate' => $num1, ':class3' => $tt);
				$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特A\' and  class3=:class3');
				$stmt->execute($params);
			}
		}
		
		if ($_POST['dx'] == '单'){
			if ($tt % 2 == 1){
				if ($_GET['ids'] == '特A'){
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特B\' and  class3=:class3');
					$stmt->execute($params);
				}else{
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num1, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特A\' and  class3=:class3');
					$stmt->execute($params);
				}
			}
		}
		
		if ($_POST['dx'] == '双'){
			if ($tt % 2 == 0)
			{
				if ($_GET['ids'] == '特A')
				{
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特B\' and  class3=:class3');
					$stmt->execute($params);
				}else{
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num1, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特A\' and  class3=:class3');
					$stmt->execute($params);
				}
			}
		}
		
		if ($_POST['dx'] == '大'){
			if (25 <= $tt){
				if ($_GET['ids'] == '特A'){
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特B\' and  class3=:class3');
					$stmt->execute($params);
				}else{
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num1, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特A\' and  class3=:class3');
					$stmt->execute($params);
				}
			}
		}
		
		if ($_POST['dx'] == '小'){
			if ($tt <= 24){
				if ($_GET['ids'] == '特A'){
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特B\' and  class3=:class3');
					$stmt->execute($params);
				}else{
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num1, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特A\' and  class3=:class3');
					$stmt->execute($params);
				}
			}
		}
		
		if ($_POST['dx'] == '红波'){
			if (Get_bs_Color($tt) == 'r'){
				if ($_GET['ids'] == '特A'){
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特B\' and  class3=:class3');
					$stmt->execute($params);
				}else{
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num1, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特A\' and  class3=:class3');
					$stmt->execute($params);
				}
			}
		}
		
		if ($_POST['dx'] == '蓝波'){
			if (Get_bs_Color($tt) == 'b'){
				if ($_GET['ids'] == '特A'){
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特B\' and  class3=:class3');
					$stmt->execute($params);
				}else{
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num1, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特A\' and  class3=:class3');
					$stmt->execute($params);
				}
			}
		}
		
		if ($_POST['dx'] == '绿波'){
			if (Get_bs_Color($tt) == 'g'){
				if ($_GET['ids'] == '特A'){
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特B\' and  class3=:class3');
					$stmt->execute($params);
				}else{
					$params = array(':mrate' => $_POST['bl'], ':class2' => $ids, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=:class2 and  class3=:class3');
					$stmt->execute($params);
					$params = array(':mrate' => $num1, ':class3' => $tt);
					$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特A\' and  class3=:class3');
					$stmt->execute($params);
				}
			}
		}
	}
}

if ($_GET['act'] == '修改'){
	
	for ($tt = 1;$tt <= 66;$tt++){
		if (empty($_POST['Num_' . $tt])){
			echo "<script>alert('赔率不能为空:".$_POST['Num_'.$tt]."/".$tt."!');window.history.go(-1);</script>"; 
  			exit;
		}
	}
	
	for ($tt = 1;$tt <= 66;$tt++){
		$ids = $_GET['ids'];
		$num = $_POST['Num_' . $tt];
		$num1 = $num + ka_config(3);
		$num2 = $num - ka_config(3);
		$num3 = $num + ka_config(4);
		$num4 = $num - ka_config(4);
		$num5 = $num + ka_config(5);
		$num6 = $num - ka_config(5);
		$class3 = $_POST['class3_' . $tt];
		$params = array(':mrate' => $num, ':class2' => $ids, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_bl  set mrate=:mrate where class2=:class2 and  class3=:class3');
		$stmt->execute($params);
		if ($_GET['ids'] == '特A'){
			if ($tt <= 49){
				$params = array(':mrate' => $num1, ':class3' => $_POST['class3_' . $tt]);
				$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特B\' and  class3=:class3');
				$stmt->execute($params);
			}else if ($tt <= 55){
				$params = array(':mrate' => $num3, ':class3' => $_POST['class3_' . $tt]);
				$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特A\' and  class3=:class3');
				$stmt->execute($params);
			}else{
				$params = array(':mrate' => $num5, ':class3' => $_POST['class3_' . $tt]);
				$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特A\' and  class3=:class3');
				$stmt->execute($params);
			}
		}else if ($tt <= 49){
			$params = array(':mrate' => $num2, ':class3' => $_POST['class3_' . $tt]);
			$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特A\' and  class3=:class3');
			$stmt->execute($params);
		}else if ($tt <= 55){
			$params = array(':mrate' => $num4, ':class3' => $_POST['class3_' . $tt]);
			$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特B\' and  class3=:class3');
			$stmt->execute($params);
		}else{
			$params = array(':mrate' => $num6, ':class3' => $_POST['class3_' . $tt]);
			$stmt = $mydata2_db->prepare('update ka_bl set mrate=:mrate where class2=\'特B\' and  class3=:class3');
			$stmt->execute($params);
		}
	}
	
	echo "<script>alert('修改成功!');window.location.href='index.php?action=rake_mm&ids=".$ids."';</script>";
	exit();
}

if ($_GET['savew'] == 'savew'){
	if (empty($_POST['mf'])){
		echo "<script>alert('请选择项目!');window.history.go(-1);</script>"; 
  		exit;
	}
	
	if (empty($_POST['money'])){
		echo "<script>alert('请输入数值!');window.history.go(-1);</script>"; 
  		exit;
	}
	$mv = $_POST['mv'];
	$money = $_POST['money'];
	$vvv = $_POST['mf'];
	$ss = count($vvv);
	$i = 0;
	for (;$i <= $ss - 1;$i++)
	{
		$string .= $vvv[$i] . ',';
	}
	$pc = explode(',', $string);
	$ss1 = count($pc);
	$i = 0;
	for (;$i <= $ss1 - 2;$i++)
	{
		$string1 .= intval($pc[$i]) . ',';
	}
	$pc = explode(',', $string1);
	$ss2 = count($pc);
	$i = 0;
	for (;$i <= $ss2 - 1;$i++)
	{
		if ($i == 0)
		{
			$guolv = $pc[$i];
		}
		else
		{
			$uuu = $pc[$i];
			$pc1 = explode(',', $guolv);
			$ss3 = count($pc1);
			$ff = 0;
			$f = 0;
			for (;$f <= $ss3;$f++)
			{
				if ($uuu == $pc1[$f])
				{
					$ff = 1;
				}
			}
			if ($ff == 0)
			{
				$guolv .= ',' . $uuu;
			}
		}
	}
	$pc4 = explode(',', $guolv);
	$ss4 = count($pc4);
	$f = 0;
	for (;$f < $ss4;$f++)
	{
		if ($mv == 0)
		{
			$params = array(':rate' => $money, ':class3' => $pc4[$f]);
			$stmt = $mydata2_db->prepare('update ka_bl set mrate=rate-:rate where class1=\'特码\'  and   class3=:class3');
			$stmt->execute($params);
		}
		else
		{
			$params = array(':rate' => $money, ':class3' => $pc4[$f]);
			$stmt = $mydata2_db->prepare('update ka_bl set mrate=rate+:rate where class1=\'特码\'  and   class3=:class3');
			$stmt->execute($params);
		}
	}
}
$params = array(':class2' => $ids);
$result = $mydata2_db->prepare('Select mrate,class3,locked from ka_bl where class2=:class2 Order By ID  LIMIT 66');
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
<SCRIPT language=JAVASCRIPT> 
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT> 

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
		 for(var i=0;i<60;i++) { 
			arrTmp = arrResult[i].split("@@@");
			num1 = arrTmp[0];//字段num1的值 
			num2 = parseFloat(arrTmp[1]).toFixed(2);//字段num2的值 
			num3 = arrTmp[2];//字段num1的值 
			num4 = arrTmp[3];//字段num2的值 
			var bl;
			bl="bl"+i;
			document.all[bl].innerHTML= num2;
			
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
				  makeRequest('index.php?action=server&class1=特码&class2=<?=$ids;?>') 
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

function sel_col_ball(color,sj) 
{ 
  var c;
  var str1 
  var zmzm 
  var zmn=0.5 
  var zmnn=0.01 
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



	   document.all.t_signle.value=adv_format(eval(document.all.t_signle.value+"+"+sj),2);
	   document.all.t_double.value=adv_format(eval(document.all.t_double.value+"+"+sj),2);
	   document.all.t_big.value=adv_format(eval(document.all.t_big.value+"+"+sj),2);
	   document.all.t_small.value=adv_format(eval(document.all.t_small.value+"+"+sj),2);
	   document.all.h_signle.value=adv_format(eval(document.all.h_signle.value+"+"+sj),2);
	   document.all.h_double.value=adv_format(eval(document.all.h_double.value+"+"+sj),2);


  }else{ 

  var m=0 
  for(i=0;i<49 ;i++) 
  { 

	  m++ 


		  if (ball_color[i] == c) 
	  { 

		  str1="Num_"+m;
	  zmzm=document.all[str1].value;
		  zmzm=eval(zmzm+"+"+sj);

		   document.all[str1].value =zmzm ;


	  } 
} 




  } 
} 


function sel_col_ball1(color,sj) 
{ 
  var c;
  var str1 
  var zmzm 
  var zmn=0.5 
  var zmnn=0.01 
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

var s = new Number(document.all.h_double.value);
s*=100;
s-=1;
s/=100;
document.all.h_double.value=adv_format(s,2);

var t_signle = new Number(document.all.t_signle.value);
t_signle*=100;
t_signle-=1;
t_signle/=100;
document.all.t_signle.value=adv_format(t_signle,2);

var t_double = new Number(document.all.t_double.value);
t_double*=100;
t_double-=1;
t_double/=100;
document.all.t_double.value=adv_format(t_double,2);

var h_signle = new Number(document.all.h_signle.value);
h_signle*=100;
h_signle-=1;
h_signle/=100;
document.all.h_signle.value=adv_format(h_signle,2);
var t_small = new Number(document.all.t_small.value);
t_small*=100;
t_small-=1;
t_small/=100;
document.all.t_small.value=adv_format(t_small,2);

var t_big = new Number(document.all.t_big.value);
t_big*=100;
t_big-=1;
t_big/=100;
document.all.t_big.value=adv_format(t_big,2);






	  //// document.all.t_double.value=eval(document.all.t_double.value+"-"+zmnn);
	   ///document.all.t_big.value=eval(document.all.t_big.value+"-"+zmnn);
	   ///document.all.t_small.value=eval(document.all.t_small.value+"-"+zmnn);
	  /// document.all.h_signle.value=eval(document.all.h_signle.value+"-"+zmnn);
	  //document.all.h_double.value=eval(document.all.h_double.value+"-"+zmnn);


  }else{ 

  var m=0 
  for(i=0;i<49 ;i++) 
  { 

	  m++ 


		  if (ball_color[i] == c) 
	  { 

		  str1="Num_"+m;
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
.STYLE1 {color: #FF0000} 
.STYLE2 {color: #0000FF} 
.STYLE3 {color: #00FF00} 
.STYLE4 {color: #FFFFFF} 
--> 
</style> 
<noscript> 
<iframe scr=″*.htm″></iframe> 
</noscript> 
<body> 


<div align="center"> 
<link rel="stylesheet" href="xp.css" type="text/css"> 
<table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr class="tbtitle">
            <td width="100%"><? require_once 'retop.php';?></td>
          </tr>
          <tr >
            <td height="5" colspan="2"></td>
          </tr>
</table><table   border="1" align="center" cellspacing="1" cellpadding="1" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">
              <form name="form1" method="post" action="index.php?action=rake_mm&act=修改&ids=<?=$ids?>"><tr >
              <td height="28" colspan="10" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FE773D"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="57%"><font color="#FFFFFF"> <strong>
                    <?=$ids?>
                    赔率设置</strong></font></td>
                  <td width="14%" align="right"><span class="STYLE4">选择项目</span></td>
                  <td width="29%"><? require_once 'mmtop.php';?></td>
                </tr>
              </table></td>
            </tr>
            <tr >
              <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 赔率</td>
              <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 赔率</td>
              <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 赔率</td>
              <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 赔率</td>
              <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 赔率</td>
              </tr>
           <? for ($I=1; $I<=10; $I=$I+1)
{

?>
            <tr>
              <td height="35" align="center" bordercolor="cccccc" class="ball_<?=Get_bs_Color(intval($I))?>">
			  <img src="images/num<?=$I?>.gif" /></td>
              <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I-1][0]?>" name="Num_<?=$I?>" />
              <input name="class3_<?=$I?>" value="<?=$ShowTable[$I-1][1]?>" type="hidden" ></td>
              <td height="25" align="center" bordercolor="cccccc" class="ball_<?=Get_bs_Color(intval($I+10))?>">
			  <img src="images/num<?=$I+10?>.gif" /></td>
              <td height="25" align="center" bordercolor="cccccc"><input      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+10-1][0]?>" name="Num_<?=$I+10?>" />
              <input name="class3_<?=$I+10?>" value="<?=$ShowTable[$I+10-1][1]?>" type="hidden" ></td>
              <td height="25" align="center" bordercolor="cccccc" class="ball_<?=Get_bs_Color(intval($I+20))?>">
			 <img src="images/num<?=$I+20?>.gif" /></td>
              <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+20-1][0]?>" name="Num_<?=$I+20?>" />
              <input name="class3_<?=$I+20?>" value="<?=$ShowTable[$I+20-1][1]?>" type="hidden" ></td>
              <td height="25" align="center" bordercolor="cccccc" class="ball_<?=Get_bs_Color(intval($I+30))?>">
			 <img src="images/num<?=$I+30?>.gif" /></td>
              <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+30-1][0]?>" name="Num_<?=$I+30?>" />

              <input name="class3_<?=$I+30?>" value="<?=$ShowTable[$I+30-1][1]?>" type="hidden" ></td>
              <? if ($I!=10) {?>
              <td height="25" align="center" bordercolor="cccccc" class="ball_<?=Get_bs_Color(intval($I+40))?>">
			 <img src="images/num<?=$I+40?>.gif" /></td>
              <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+40-1][0]?>" name="Num_<?=$I+40?>" />
              <input name="class3_<?=$I+40?>" value="<?=$ShowTable[$I+40-1][1]?>" type="hidden" ></td>
              <? }else{?> <td height="25" align="center" bordercolor="cccccc">&nbsp;</td>
           
              <td align="center" bordercolor="cccccc">&nbsp;</td><? }?>
            </tr>
            <? }?>
            
			   <? for ($I=1; $I<=2; $I=$I+1)
{

?><tr>
			   
            <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[$I+48][1]?></td>
              <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+48][0]?>" name="Num_<?=$I+49?>" />
                <input name="class3_<?=$I+49?>" value="<?=$ShowTable[$I+48][1]?>" type="hidden" ></td>
              <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[$I+50][1]?></td>
              <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+50][0]?>" name="Num_<?=$I+51?>" />
                <input name="class3_<?=$I+51?>" value="<?=$ShowTable[$I+50][1]?>" type="hidden" ></td>
              <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[$I+52][1]?></td>
              <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+52][0]?>" name="Num_<?=$I+53?>" />
                <input name="class3_<?=$I+53?>" value="<?=$ShowTable[$I+52][1]?>" type="hidden" ></td>
              <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[$I+54][1]?></td>
              <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+54][0]?>" name="Num_<?=$I+55?>" />
                <input name="class3_<?=$I+55?>" value="<?=$ShowTable[$I+54][1]?>" type="hidden" ></td>
              <? if ($I==1) {?>
			  <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[$I+56][1]?></td>
              <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+56][0]?>" name="Num_<?=$I+57?>" />
                <input name="class3_<?=$I+57?>" value="<?=$ShowTable[$I+56][1]?>" type="hidden" ></td>
              <? }else{?>
              <td colspan="2" align="center" bordercolor="cccccc"><table border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="88" align="center"><input type="submit"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" name="Submit2" value="提交" /></td>
                  <td width="88" align="center"><input type="reset"    class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" name="Submit3" value="重置" /></td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
              <? }?>
            </tr>
			<? }?>
			   <tr>
			     <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[58][1]?></td>
			     <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[58][0]?>" name="Num_<?=59?>" />
			       <input name="class3_<?=59?>" value="<?=$ShowTable[58][1]?>" type="hidden" ></td>
			     <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[59][1]?></td>
			     <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[59][0]?>" name="Num_<?=60?>" />
			       <input name="class3_<?=60?>" value="<?=$ShowTable[59][1]?>" type="hidden" ></td>
			     <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[60][1]?></td>
			     <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[60][0]?>" name="Num_<?=61?>" />
			       <input name="class3_<?=61?>" value="<?=$ShowTable[60][1]?>" type="hidden" ></td>
			     <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[61][1]?></td>
			     <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[61][0]?>" name="Num_<?=62?>" />
			       <input name="class3_<?=62?>" value="<?=$ShowTable[61][1]?>" type="hidden" ></td>
			     <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[62][1]?></td>
			     <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[62][0]?>" name="Num_<?=63?>" />
			       <input name="class3_<?=63?>" value="<?=$ShowTable[62][1]?>" type="hidden" ></td>
		        </tr>
				<tr>
				 <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[63][1]?></td>
			     <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[63][0]?>" name="Num_<?=64?>" />
			       <input name="class3_<?=64?>" value="<?=$ShowTable[63][1]?>" type="hidden" ></td>
				 <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[64][1]?></td>
			     <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[64][0]?>" name="Num_<?=65?>" />
			       <input name="class3_<?=65?>" value="<?=$ShowTable[64][1]?>" type="hidden" ></td>
				 <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[65][1]?></td>
			     <td height="25" align="center" bordercolor="cccccc"><input 
      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[65][0]?>" name="Num_<?=66?>" />
			       <input name="class3_<?=66?>" value="<?=$ShowTable[65][1]?>" type="hidden" ></td>
				</tr>
			</form>
	    
          </table>

	<table   border="1" align="center" cellspacing="1" cellpadding="2" bordercolordark="#FFFFFF" bordercolor="f1f1f1">
          <form action="index.php?action=rake_mm&savew=savew&ids=<?=$ids?>" name="form21" method="post" >
            <tr align="middle">
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(1)?>">
              鼠 </td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(7)?>">
              牛 </td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(2)?>">
              虎 </td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(8)?>">
              兔 </td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(3)?>">
              龙 </td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(9)?>">
              蛇 </td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(4)?>">
              马 </td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(10)?>">
              羊 </td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(5)?>">
              猴 </td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(11)?>">
              鸡 </td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(6)?>">
              狗 </td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(12)?>">
              猪 </td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">&nbsp;</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">&nbsp;</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">&nbsp;</td>
            </tr>
            <tr align="middle">
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(13)?>">
              <span class="STYLE1">红单</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(14)?>">
              <span class="STYLE1">红双</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(15)?>">
              <span class="STYLE1">红大</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(16)?>">
              <span class="STYLE1">红小</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(21)?>">
              <span class="STYLE2">蓝单</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(22)?>">
              <span class="STYLE2">蓝双</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(23)?>">
              <span class="STYLE2">蓝大</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(24)?>">
              <span class="STYLE2">蓝小</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(17)?>,49">
              <span class="STYLE4 STYLE3">绿单</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(18)?>">
              <span class="STYLE4 STYLE3">绿双</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(19)?>,49">
              <span class="STYLE4 STYLE3">绿大</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(20)?>">
              <span class="STYLE4 STYLE3">绿小</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(16)?>,<?=show_xxsx222(15)?>">
              <span class="STYLE1">红波</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(24)?>,<?=show_xxsx222(23)?>">
              <span class="STYLE2">蓝波</span></td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="<?=show_xxsx222(20)?>,<?=show_xxsx222(19)?>,49">
              <span class="STYLE4 STYLE3">绿波</span></td>
            </tr>
            <tr align="middle">
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="1,3,5,7,9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41,43,45,47,49">
              单号</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="2,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34,36,38,40,42,44,46,48">
              双号</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49">
              大号</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24">
              小号</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="1,3,5,7,9,10,12,14,16,18,21,23,25,27,29,30,32,34,36,38,41,43,45,47,49">
              合单</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="2,4,6,8,11,13,15,17,19,20,22,24,26,28,31,33,35,37,39,40,42,44,46,48">
              合双</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">&nbsp;</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="1,2,3,4,5,6,7,8,9">
              0头</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="10,11,12,13,14,15,16,17,18,19">
              1头</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="20,21,22,23,24,25,26,27,28,29">
              2头</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="30,31,32,33,34,35,36,37,38,39">
              3头</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="40,41,42,43,44,45,46,47,48,49">
              4头</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">&nbsp;</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">&nbsp;</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">&nbsp;</td>
            </tr>
            <tr align="middle">
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="10,20,30,40">
              0尾</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="1,11,21,31,41">
              1尾</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="2,12,22,32,42">
              2尾</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="3,13,23,33,43">
              3尾</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="4,14,24,34,44">
              4尾</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="5,15,25,35,45">
              5尾</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="6,16,26,36,46">
              6尾</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="7,17,27,37,47">
              7尾</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="8,18,28,38,48">
              8尾</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><input name="mf[]" type="checkbox" id="mf[]" value="9,19,29,39,49">
              9尾</td>
              <td align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">&nbsp;</td>
              <td colspan="4" align="left" nowrap bordercolor="cccccc" bgcolor="#FDF4CA"><table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>减</td>
                    <td><input name="mv" type="radio" value="0" checked></td>
                    <td><INPUT name=money class="input1" value="0.5" size=4></td>
                    <td><input type="radio" name="mv" value="1"></td>
                    <td>加</td>
                    <td>&nbsp;
                        <INPUT name="button2" class="button_c" type=submit value=送出></td>
                    <td>&nbsp;
                        <INPUT type=reset class="button_c"  value="取消" name="reset"></td>
                  </tr>
              </table></td>
            </tr>
          </form>
</table>
	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <form action="index.php?action=rake_mm&save=save&ids=<?=$ids?>" name="form21" method="post" ><tr>
    <td height="25" align="center"><span class="STYLE1">统一修改：</span>
      <input type="radio" name="dx" value="单">
      单 
        <input type="radio" name="dx" value="双">
        双
        <input type="radio" name="dx" value="大">
        大
        <input type="radio" name="dx" value="小">
        小
        <input type="radio" name="dx" value="红波">
        红波 
        <input type="radio" name="dx" value="绿波">
        绿波
        <input type="radio" name="dx" value="蓝波">
        蓝波
<input name="dx" type="radio" value="全部" checked>
全部 <span class="STYLE1">赔率</span>
<input name="bl"  class="input1" id="bl" 
      style="HEIGHT: 18px" value="0" size="6" /> 
<input type="submit"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" name="Submit22" value="统一修改" /></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  </form>
</table>
<?php 
function show_xxsx222($i){
	global $mydata2_db;
	$params = array(':id' => $i);
	$result4 = $mydata2_db->prepare('Select id,m_number From ka_sxnumber where id=:id Order By id');
	$result4->execute($params);
	$ka_configg4 = $result4->fetch();
	return $ka_configg4['m_number'];
}
?>