<?php 
if (!defined('PHPYOU_VER')){
	exit('非法进入');
}

if ($_GET['act'] == '添加'){
	if ($_POST['tv6'] == '是'){
		$stat = 0;
	}else{
		$stat = 1;
	}
	$params = array(':id' => intval($_GET['id']));
	$result = $mydata2_db->prepare('select * from ka_mem where id=:id  order by id');
	$result->execute($params);
	$row = $result->fetch();
	$params = array(':tmb' => $_POST['tmb'], ':stat' => $stat, ':xy' => $_POST['xy'], ':id' => intval($_GET['id']));
	$sql = 'update  ka_mem set tmb=:tmb,stat=:stat,xy=:xy where id=:id order by id desc';
	$stmt = $mydata2_db->prepare($sql);
	$stmt->execute($params);
	echo "<script>alert('会员修改成功!');window.location.href='index.php?action=mem_edit&id=".$_GET['id']."';</script>";
	exit();
}

$params = array(':id' => intval($_GET['id']));
$result2 = $mydata2_db->prepare('select *  from ka_mem where  id=:id order by id');
$result2->execute($params);
$row2 = $result2->fetch();
if ($row2 != ''){
	$params = array(':id' => $row2['danid']);
	$result = $mydata2_db->prepare('select id,kauser,sf,cs,tmb   from ka_guan where  id=:id and lx=3');
	$result->execute($params);
	$row = $result->fetch();
	if ($row != ''){
		$params = array(':danid' => $row['id']);
		$result1 = $mydata2_db->prepare('Select SUM(cs) As sum_m  From ka_mem Where   danid=:danid order by id desc');
		$result1->execute($params);
		$rsw = $result1->fetchColumn();
		if ($rsw != ''){
			$mumu = $rsw;
		}else{
			$mumu = 0;
		}
		$params = array(':kithe' => $Current_Kithe_Num, ':username' => $row['kauser']);
		$result1 = $mydata2_db->prepare('Select SUM(sum_m) As sum_m   From ka_tan Where kithe=:kithe and   username=:username order by id desc');
		$result1->execute($params);
		$rsw = $result1->fetchColumn();
		if ($rsw != ''){
			$mkmk = $rsw;
		}else{
			$mkmk = 0;
		}
		$tmb = $row['tmb'];
		$danid = $row['id'];
		$maxnum = ($row['cs'] - $mumu - $mkmk) + $row2['cs'];
		$istar = 0;
		$iend = $row['sf'];
	}else{
		$maxnum = 2000000000;
		$istar = 0;
		$iend = 100;
		$tmb = 0;
	}
}
?>


<link rel="stylesheet" href="images/xp.css" type="text/css"> 
<script language="javascript" type="text/javascript" src="js_admin.js"></script> 
 

<style type="text/css"> 
<!-- 
.style1 { 
  color: #666666;
  font-weight: bold;
} 
.style2 {color: #FF0000} 
.STYLE3 {  	  color: #FFFFFF;
  font-weight: bold;
} 
--> 
</style> 
<div align="center"> 
<link rel="stylesheet" href="xp.css" type="text/css"> 
<script language="javascript" type="text/javascript" src="js_admin.js"></script> 
 
<script language="JavaScript" type="text/JavaScript"> 
function SelectAllPub() { 
  for (var i=0;i<document.form1.flag.length;i++) { 
	  var e=document.form1.flag[i];
	  e.checked=!e.checked;
  } 
} 
function SelectAllAdm() { 
  for (var i=0;i<document.form1.flag.length;i++) { 
	  var e=document.form1.flag[i];
	  e.checked=!e.checked;
  } 
} 
</script> 
<SCRIPT> 
function LoadBody(){ 

} 
function SubChk() 
{ 



	  if(document.all.xm.value=='') 
		  { document.all.xm.focus();alert("姓名请务必输入!!");return false;} 



		  if(document.all.xy.value=='') 
		  { document.all.xy.focus();alert("请输入最低限额!!");return false;} 


	  if(document.all.cs.value=='' ) 
	  { document.all.maxcredit.focus();alert("总信用额度请务必输入!!");return false;} 

  if(!confirm("是否确定写入会员?")){ 
		  return false;
	  } 
} 

function roundBy(num,num2) { 
  return(Math.floor((num)*num2)/num2);
} 
function show_count(w,s) { 
  //alert(w+' - '+s);
  var org_str=document.all.ag_count.innerHTML 
  if (s!=''){ 
	  switch(w){ 
		  //case 0:document.all.ag_count.innerHTML = s+org_str.substr(1,4);break;
		  case 1:document.all.ag_count.innerHTML = org_str.substr(0,0)+s+org_str.substr(1,7);break;
		  case 2:document.all.ag_count.innerHTML = org_str.substr(0,1)+s+org_str.substr(2,7);break;
		  case 3:document.all.ag_count.innerHTML = org_str.substr(0,2)+s+org_str.substr(3,7);break;
		  case 4:document.all.ag_count.innerHTML = org_str.substr(0,3)+s+org_str.substr(4,7);break;
		  case 5:document.all.ag_count.innerHTML = org_str.substr(0,4)+s+org_str.substr(5,7);break;
		  case 6:document.all.ag_count.innerHTML = org_str.substr(0,5)+s+org_str.substr(6,7);break;
		  case 7:document.all.ag_count.innerHTML = org_str.substr(0,6)+s+org_str.substr(7,7);break;} 
  } 
} 
function changelocation(locationid,result) 
{ 
var onecount;
subcat = new Array();

  document.testFrm.zc.length = 1;
	  var locationid=locationid;
  var i;
	  var k 
	 for (j=10;j.toFixed(3)<=(result-locationid).toFixed(3);j=j+10) 
 { 
		  document.testFrm.zc.options[document.testFrm.zc.length] = new Option((j).toFixed(0)+"%");
  } 

} 
function changep(pid) 
{ 
  var pp=pid.split(",");
  document.testFrm.pagentid.value = pp[0];
  document.testFrm.kyx.value = pp[2];
  t=parseInt(pp[1]);
  document.testFrm.zc.length = 1;
  for (j=10;j.toFixed(3)<=(t).toFixed(3);j=j+10) 
 { 
		  document.testFrm.zc.options[document.testFrm.zc.length] = new Option((j).toFixed(0)+"%");
  } 
  document.testFrm.fei_max.length = 1;
  for (j=10;j.toFixed(3)<=(t).toFixed(3);j=j+10) 
 { 
		  document.testFrm.fei_max.options[document.testFrm.fei_max.length] = new Option((j).toFixed(0)+"%");
  } 
} 

function changep1(pid) 
{ 
var pp=pid.split(",");

  document.testFrm.winloss.value = pp[0];
  document.testFrm.bank.value = pp[1];
document.all.ag_count.innerHTML =pp[1];
} 



function CountGold(gold,type,rtype){ 

goldvalue = gold.value;

if (goldvalue=='') goldvalue=0;

if (rtype=='SP' && (eval(goldvalue) ><?=$maxnum;?>)) {gold.focus();alert("对不起,上级总信用额度最高可使用 :<?=$maxnum;?>!!");return false;} 
} 

function CountGold1(gold,type,rtype,bb,nmnm){ 

goldvalue = gold.value;


if (goldvalue=='') goldvalue=0;

if (rtype=='SP' && (eval(goldvalue) > eval(bb))) {gold.focus();alert("对不起,止项最高不能超过上级限额: "+eval(bb)+"!!");
return false;
} 


if (rtype=='XP' && (eval(goldvalue) > eval(bb))) {gold.focus();alert("对不起,止项最高不能超过上级限额: "+eval(bb)+"!!");
return false;
} 

if (rtype=='MP' && (eval(goldvalue) > eval(bb))) {gold.focus();alert("对不起,止项最高不能超过上级限额: "+eval(bb)+"!!");
return false;
} 

for(i=1;i<28 ;i++) 
  { 
  if (nmnm==i){ 
var str1="mm"+i;
var str2="mmm"+i;
var t_big2 = new Number(document.all[str2].value);
if (rtype=='MP' && (eval(goldvalue) > eval(t_big2))) {gold.focus();alert("对不起,单注限额不能大于单项限额: "+eval(t_big2)+"!!");
return false;} 

var t_big = new Number(document.all[str1].value);
if (rtype=='XP' && (eval(goldvalue) < eval(t_big))) {gold.focus();alert("对不起,单项限额不能低于单注限额: "+eval(t_big)+"!!");
return false;
} 
} 
} 
} 

</SCRIPT> 
<table width="100%" border="0" cellspacing="0" cellpadding="5"> 
<tr class="tbtitle"> 
  <td width="29%"><span class="STYLE3">修改会员</span></td> 
  <td width="34%">&nbsp;</td> 
  <td width="37%">&nbsp;</td> 
</tr> 
<tr > 
  <td height="5" colspan="3"></td> 
</tr> 
</table> 
<table width="99%"  border="1" cellpadding="2" cellspacing="1" bordercolor="f1f1f1"> 
<form name=testFrm onSubmit="return SubChk()" method="post" action="index.php?action=mem_edit&act=添加&id=<?=$_GET['id'];?>"> <tr> 
  <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">上级：</td> 
  <td bordercolor="#CCCCCC"><font color="ff6600"><?=$row2['guan'];?>(股)---<?=$row2['zong'];?>(总)---<?=$row2['dan'];?>(代) 
	<input name="danid" type="hidden" value="<?=$row2['danid'];?>" /> 
  </font></td> 
  <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">会员盘口：</td> 
  <td bordercolor="#CCCCCC"><select name="abcd" id="abcd" disabled="disabled"> 
	<option value="A"<?php if ($row2['abcd'] == 'A'){?>  selected="selected"<?php }?> >A盘</option> 
	<option value="B"<?php if ($row2['abcd'] == 'B'){?>  selected="selected"<?php }?> >B盘</option> 
	<option value="C"<?php if ($row2['abcd'] == 'C'){?>  selected="selected"<?php }?> >C盘</option> 
	<option value="D"<?php if ($row2['abcd'] == 'D'){?>  selected="selected"<?php }?> >D盘</option> 
  </select>&nbsp;&nbsp;&nbsp;</td> 
</tr> 
<tr> 
  <td width="11%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">账号：</td> 
  <td width="32%" bordercolor="#CCCCCC"><font color="ff6600"><?=$row2['kauser'];?></font></td> 
  <td width="8%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">姓名：</td> 
  <td width="49%" bordercolor="#CCCCCC"><?=$row2['xm'];?>&nbsp;&nbsp;<span class="STYLE2">*</span> 下注余额：<font color="ff6600"><?=$row2['ts'];?></font></td> 
</tr> 
<tr> 
  <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">最低限额：</td> 
  <td bordercolor="#CCCCCC"><span class="STYLE2"> 
	<input name="xy" type="text" class="input1"  id="xy" value="<?=$row2['xy'];?>" size="8" /> 
	*(下注最低限额)</span></td> 
  <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">状态：</td> 
  <td bordercolor="#CCCCCC">
  <input type="hidden" name="tv6" value="<?php if ($row2['stat'] == 0){?> 是<?php }else{?> 否<?php }?> " /> 
	  <img src="images/<?php if ($row2['stat'] == 0){?>icon_21x21_selectboxon.gif<?php }else{?>icon_21x21_selectboxoff.gif<?php }?>" name="tv6_b" align="absmiddle" class="cursor" id="tv6_b" onclick="javascript:ra_select('tv6')" />(开启/禁止)<span class="STYLE2">* </span>
  </td> 
</tr> 
<tr> 
  <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">自否允许特B：</td> 
  <td height="30" bordercolor="#CCCCCC">
  <select name="tmb" id="tmb">
  <?php if ($tmb != 1){?>         
  <option value="0"<?php if ($row2['tmb'] == '0'){?> selected="selected"<?php }?> >允许</option><?php }?>         
  <option value="1"<?php if ($row2['tmb'] == '1'){?> selected="selected"<?php }?> >不允许</option> 
  </select> 
  </td> 
  <td height="30" bordercolor="#CCCCCC">&nbsp;</td> 
  <td height="30" bordercolor="#CCCCCC">&nbsp;</td> 
</tr> 
<tr> 
  <td height="30" bordercolor="#CCCCCC" bgcolor="#FDF4CA">&nbsp;</td> 
  <td colspan="3" bordercolor="#CCCCCC"> 
	  <table width="100" border="0" cellspacing="0" cellpadding="0"> 
		<tr> 
		  <td height="10"></td> 
		</tr> 
	  </table> 
	<input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="保存会员" /> 
	  <br /> 
	  <table width="100" border="0" cellspacing="0" cellpadding="0"> 
		<tr> 
		  <td height="10"></td> 
		</tr> 
	</table></td> 
</tr> 
</form> 
</table> 
</div> 
