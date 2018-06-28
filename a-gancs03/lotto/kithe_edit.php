<?php 
if (!defined('PHPYOU_VER')){
	exit('非法进入');
}

if ($_GET['act'] == '添加'){
	if (empty($_POST['nn'])){
		echo "<script>alert('期数不能为空!');history.back();</script>";
		exit();
	}
	if (empty($_POST['nd'])){
		echo "<script>alert('开奖时间不能为了空!');history.back();</script>";
		exit();
	}
	$n1 = $_POST['n1'];
	$n1 = (int) $n1;
	if ($n1 < 10){
		$n1 = '0' . $n1;
	}
	$x1 = Get_sx_Color($n1);
	$n2 = $_POST['n2'];
	$n2 = (int) $n2;
	if ($n2 < 10)
	{
		$n2 = '0' . $n2;
	}
	$x2 = Get_sx_Color($n2);
	$n3 = $_POST['n3'];
	$n3 = (int) $n3;
	if ($n3 < 10)
	{
		$n3 = '0' . $n3;
	}
	$x3 = Get_sx_Color($n3);
	$n4 = $_POST['n4'];
	$n4 = (int) $n4;
	if ($n4 < 10)
	{
		$n4 = '0' . $n4;
	}
	$x4 = Get_sx_Color($n4);
	$n5 = $_POST['n5'];
	$n5 = (int) $n5;
	if ($n5 < 10)
	{
		$n5 = '0' . $n5;
	}
	$x5 = Get_sx_Color($n5);
	$n6 = $_POST['n6'];
	$n6 = (int) $n6;
	if ($n6 < 10)
	{
		$n6 = '0' . $n6;
	}
	$x6 = Get_sx_Color($n6);
	$na = $_POST['na'];
	$na = (int) $na;
	if ($na < 10)
	{
		$na = '0' . $na;
	}
	$sx = Get_sx_Color($na);
	$params = array(':nn' => $_POST['nn'], ':nd' => $_POST['nd'], ':na' => $na, ':sx' => $sx, ':n1' => $n1, ':n2' => $n2, ':n3' => $n3, ':n4' => $n4, ':n5' => $n5, ':n6' => $n6, ':x1' => $x1, ':x2' => $x2, ':x3' => $x3, ':x4' => $x4, ':x5' => $x5, ':x6' => $x6, ':id' => $_GET['id']);
	$sql = 'update ka_kithe set nn=:nn,nd=:nd,na=:na,sx=:sx,n1=:n1,n2=:n2,n3=:n3,n4=:n4,n5=:n5,n6=:n6,x1=:x1,x2=:x2,x3=:x3,x4=:x4,x5=:x5,x6=:x6 where id=:id';
	$stmt = $mydata2_db->prepare($sql);
	$stmt->execute($params);
	echo "<script>alert('盘口修改成功!');window.location.href='index.php?action=kithe_edit&id=".$_GET['id']."';</script>";
	exit();
}
$params = array(':id' => $_GET['id']);
$result = $mydata2_db->prepare('select * from ka_kithe where id=:id order by id desc LIMIT 1');
$result->execute($params);
$row = $result->fetch();
$id = $row['id'];
$nn = $row['nn'];
$nd = $row['nd'];
$zfbdate = $row['zfbdate'];
$zfbdate1 = $row['zfbdate1'];
$kitm1 = $row['kitm1'];
$kizt1 = $row['kizt1'];
$kizm1 = $row['kizm1'];
$kizm61 = $row['kizm61'];
$kigg1 = $row['kigg1'];
$kilm1 = $row['kilm1'];
$kisx1 = $row['kisx1'];
$kibb1 = $row['kibb1'];
$kiws1 = $row['kiws1'];
$nana = $row['na'];
?>


  <link rel="stylesheet" href="images/xp.css" type="text/css"> 
  <script language="javascript" type="text/javascript" src="js_admin.js"></script> 
   

  <style type="text/css"> 
  <!-- 
  .style1 { 
	  color: #666666;
	  font-weight: bold;
  } 
  .style2 {color: #ffffff} 
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

     		  if(document.all.nn.value=='') 
     		  { document.all.nn.focus();alert("期数请务必输入!!");return false;} 

		  if(document.all.nd.value=='') 
     		  { document.all.nd.focus();alert("开奖时间请务必输入!!");return false;} 


     	  if(document.all.zfbdate.value=='') 
     		  { document.all.zfbdate.focus();alert("总封盘时间请务必输入!!");return false;} 

	  if(!confirm("是否确定修改盘口?")){ 
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

  if (rtype=='SP' && (eval(goldvalue) > 49)) {gold.focus();alert("对不起,请输入49以内的球号!!");return false;} 
  if (rtype=='SP' && (eval(goldvalue) < 1)) {gold.focus();alert("对不起,请输入大于等于1的球号!!");return false;} 
  } 
  </SCRIPT> 
  <table width="100%" border="0" cellspacing="0" cellpadding="5"> 
    <tr class="tbtitle"> 
      <td width="29%"><?php require_once '1top.php';?></td> 
      <td width="34%">&nbsp;</td> 
      <td width="37%">&nbsp;</td> 
    </tr> 
    <tr > 
      <td height="5" colspan="3"></td> 
    </tr> 
  </table> 
  <table width="99%"  border="1" cellpadding="2" cellspacing="2" bordercolor="#ECE9D8"> 
   <form name=testFrm onSubmit="return SubChk()" method="post" action="index.php?action=kithe_edit&act=添加&id=<?=$id;?>"> <tr> 
      <td width="11%" height="30" align="right" bordercolor="#CCCCCC">期数：</td> 
      <td width="29%" bordercolor="#CCCCCC"><input name="nn" type="text" class="input1"  id="nn" value="<?=$nn;?>" size="8" /> 
          <span class="STYLE2">*</span></td> 
      <td width="15%" height="30" align="right" bordercolor="#CCCCCC">开奖时间：</td> 
      <td width="45%" bordercolor="#CCCCCC"><input name="nd" type="text" class="input1"  id="nd" value="<?=$nd;?>" size="35" /> 
          <span class="STYLE2">*</span> </td> 
    </tr> 
    <tr> 
      <td height="30" align="right" bordercolor="#CCCCCC">开奖球号：</td> 
      <td height="30" colspan="3" bordercolor="#CCCCCC"><table border="1" cellpadding="3" cellspacing="1" bordercolor="f1f1f1"> 
        <tr class="tbtitle"> 
          <td width="50" height="25" align="center" class="STYLE2">平1</td> 
          <td width="50" height="25" align="center" class="STYLE2">平2</td> 
          <td width="50" height="25" align="center" class="STYLE2">平3</td> 
          <td width="50" height="25" align="center" class="STYLE2">平4</td> 
          <td width="50" height="25" align="center" class="STYLE2">平5</td> 
          <td width="50" height="25" align="center" class="STYLE2">平6</td> 
          <td width="50" height="25" align="center" class="STYLE2">特码</td> 
        </tr> 
        <tr> 
          <td height="25" align="center"><input 

							  onblur="return CountGold(this,'blur','SP');" 

					      onkeyup="return CountGold(this,'keyup');" 

							  name="n1" type="text" class="input1"  id="n1" value="<?=$row['n1'];?>" size="8" /></td> 
          <td height="25" align="center"><input name="n2" 
							  onblur="return CountGold(this,'blur','SP');" 

					      onkeyup="return CountGold(this,'keyup');" 

							   type="text" class="input1"  id="n2" value="<?=$row['n2'];?>" size="8" /></td> 
          <td height="25" align="center"><input 
							  onblur="return CountGold(this,'blur','SP');" 

					      onkeyup="return CountGold(this,'keyup');" 
							   name="n3" type="text" class="input1"  id="n3" value="<?=$row['n3'];?>" size="8" /></td> 
          <td height="25" align="center"><input 
							  onblur="return CountGold(this,'blur','SP');" 

					      onkeyup="return CountGold(this,'keyup');" 
							   name="n4" type="text" class="input1"  id="n4" value="<?=$row['n4'];?>" size="8" /></td> 
          <td height="25" align="center"><input 

							  onblur="return CountGold(this,'blur','SP');" 

					      onkeyup="return CountGold(this,'keyup');" 

						   name="n5" type="text" class="input1"  id="n5" value="<?=$row['n5'];?>" size="8" /></td> 
          <td height="25" align="center"><input 
							  onblur="return CountGold(this,'blur','SP');" 

					      onkeyup="return CountGold(this,'keyup');"  name="n6" type="text" class="input1"  id="n6" value="<?=$row['n6'];?>" size="8" /></td> 
          <td height="25" align="center"><input 
							  onblur="return CountGold(this,'blur','SP');" 

					      onkeyup="return CountGold(this,'keyup');" 
						  name="na" type="text" class="input1"  id="na" value="<?=$row['na'];?>" size="8" /></td> 
        </tr> 
      </table></td> 
    </tr> 
    <tr> 
      <td height="30" bordercolor="#CCCCCC">&nbsp;</td> 
      <td colspan="3" bordercolor="#CCCCCC"><br /> 
          <table width="100" border="0" cellspacing="0" cellpadding="0"> 
            <tr> 
              <td height="6"></td> 
            </tr> 
          </table> 
        <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="保存盘口" /> 
          <br /> 
          <table width="100" border="0" cellspacing="0" cellpadding="0"> 
            <tr> 
              <td height="10"></td> 
            </tr> 
        </table></td> 
    </tr> </form> 
  </table> 
  </div> 
