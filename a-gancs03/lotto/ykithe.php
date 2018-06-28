<?php if (!defined('PHPYOU_VER'))
{
	exit('非法进入');
}
if ($_GET['act'] == '添加')
{
	if (empty($_POST['nn']))
	{?> <script>alert('期数不能为空!');history.back();</script><?php exit();
	}
	if (empty($_POST['nd']))
	{?> <script>alert('开奖时间不能为了空!');history.back();</script><?php exit();
	}
	if (empty($_POST['zfbdate']))
	{?> <script>alert('总封盘时间不能为了空!');history.back();</script><?php exit();
	}
	if (empty($_POST['zfbdate1']))
	{?> <script>alert('自动开盘时间不能为了空!');history.back();</script><?php exit();
	}
	if ($_GET['id'] == '')
	{
		$params = array(':nn' => $_POST['nn'], ':best' => $_POST['best'], ':nd' => $_POST['nd'], ':kitm' => $_POST['kitm'], ':kizt' => $_POST['kizt'], ':kizm' => $_POST['kizm'], ':kizm6' => $_POST['kizm6'], ':kigg' => $_POST['kigg'], ':kilm' => $_POST['kilm'], ':kisx' => $_POST['kisx'], ':kibb' => $_POST['kibb'], ':kiws' => $_POST['kiws'], ':zfbdate' => $_POST['zfbdate'], ':kitm1' => $_POST['kitm1'], ':kizt1' => $_POST['kizt1'], ':kizm1' => $_POST['kizm1'], ':kizm61' => $_POST['kizm61'], ':kigg1' => $_POST['kigg1'], ':kilm1' => $_POST['kilm1'], ':kisx1' => $_POST['kisx1'], ':kibb1' => $_POST['kibb1'], ':kiws1' => $_POST['kiws1'], ':zfbdate1' => $_POST['zfbdate1']);
		$sql = 'insert into ya_kithe(zfb,nn,best,nd,kitm,kizt,kizm,kizm6,kigg,kilm,kisx,kibb,kiws,zfbdate,kitm1,kizt1,kizm1,kizm61,kigg1,kilm1,kisx1,kibb1,kiws1,zfbdate1 ) values(0,:nn,:best,:nd,:kitm,:kizt,:kizm,:kizm6,:kigg,:kilm,:kisx,:kibb,:kiws,:zfbdate,:kitm1,:kizt1,:kizm1,:kizm61,:kigg1,:kilm1,:kisx1,:kibb1,:kiws1,:zfbdate1)';
	}
	else
	{
		$params = array(':nn' => $_POST['nn'], ':best' => $_POST['best'], ':nd' => $_POST['nd'], ':kitm' => $_POST['kitm'], ':kizt' => $_POST['kizt'], ':kizm' => $_POST['kizm'], ':kizm6' => $_POST['kizm6'], ':kigg' => $_POST['kigg'], ':kilm' => $_POST['kilm'], ':kisx' => $_POST['kisx'], ':kibb' => $_POST['kibb'], ':kiws' => $_POST['kiws'], ':zfbdate' => $_POST['zfbdate'], ':kitm1' => $_POST['kitm1'], ':kizt1' => $_POST['kizt1'], ':kizm1' => $_POST['kizm1'], ':kizm61' => $_POST['kizm61'], ':kigg1' => $_POST['kigg1'], ':kilm1' => $_POST['kilm1'], ':kisx1' => $_POST['kisx1'], ':kibb1' => $_POST['kibb1'], ':kiws1' => $_POST['kiws1'], ':zfbdate1' => $_POST['zfbdate1'], ':id' => $_GET['id']);
		$sql = 'update ya_kithe set zfb=0,nn=:nn,best=:best,nd=:nd,kitm=:kitm,kizt=:kizt,kizm=:kizm,kizm6=:kizm6,kigg=:kigg,kilm=:kilm,kisx=:kisx,kibb=:kibb,kiws=:kiws,zfbdate=:zfbdate,kitm1=:kitm1,kizt1=:kizt1,kizm1=:kizm1,kizm61=:kizm61,kigg1=:kigg1,kilm1=:kilm1,kisx1=:kisx1,kibb1=:kibb1,kiws1=:kiws1,zfbdate1=:zfbdate1 where id=:id';
	}
	$stmt = $mydata2_db->prepare($sql);
	$stmt->execute($params);?><script>alert('盘口修改成功!');window.location.href='index.php?action=ykithe&id=<?=$_GET['id'] ;?>';</script><?php exit();
}
 $nana = 1;
if ($_GET['id'] != '')
{
	$params = array(':id' => $_GET['id']);
	$result = $mydata2_db->prepare('select * from ya_kithe where id=:id order by id desc');
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
}
else
{
	$id = '';
	$nn = '';
	$nd = '';
	$zfbdate = '';
	$zfbdate1 = '';
	$kitm1 = '';
	$kizt1 = '';
	$kizm1 = '';
	$kizm61 = '';
	$kigg1 = '';
	$kilm1 = '';
	$kisx1 = '';
	$kibb1 = '';
	$kiws1 = '';
}?>

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
  </style><script language="JavaScript" type="text/JavaScript"> 
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
  } 
  </SCRIPT> 
  <table border="0" align="center" cellspacing="0" cellpadding="5" bordercolor="888888" bordercolordark="#FFFFFF" width="100%"> 
    <tr> 
      <td class="tbtitle"><table width="100%" border="0" cellspacing="0" cellpadding="0"> 
        <tr> 
          <td height="25"><?php require_once '1top.php';?></td> 

        </tr> 
      </table></td> 
    </tr> 
    <tr> 
      <td><div align="left"> 
        <table width="100%"  border="1" cellpadding="2" cellspacing="2" bordercolor="#ECE9D8"> 
          <form action="index.php?action=ykithe&amp;act=添加&amp;id=<?=$id;?>" method="post" name="testFrm" id="testFrm" onsubmit="return SubChk()"> 
            <tr> 
              <td width="11%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">预设期数：</td> 
              <td width="31%" bordercolor="#CCCCCC"><input<?php if ($row['zfb'] == 1)
{?>   readonly="readonly"<?php }?>    name="nn" type="text" class="input1"  id="nn" value="<?=$nn;?>" size="8" /> 
                    <span class="STYLE2">*（正在开盘时不能修改！）</span></td> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">开奖时间：</td> 
              <td bordercolor="#CCCCCC"><input name="nd" type="text" class="input1"  id="nd" value="<?=$nd;?>" size="35" /> 
                  <span class="STYLE2">*</span> </td> 
            </tr> 
            <tr> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">自动开盘时间：</td> 
              <td bordercolor="#CCCCCC"><input name="zfbdate1" type="text" class="input1"  id="zfbdate1" value="<?=$zfbdate1;?>" size="35" /></td> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">总自动封盘时间：</td> 
              <td bordercolor="#CCCCCC"><input name="zfbdate" type="text" class="input1"  id="zfbdate" value="<?=$zfbdate;?>" size="35" /> 
                    <span class="STYLE2">*</span> </td> 
            </tr> 
            <tr> 
              <td align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">充许自动开盘：</td> 
              <td height="30" valign="middle" bordercolor="#CCCCCC"><input name="best" type="radio" value="1"<?php if ($row['best'] == 1)
{?>  checked="checked"<?php }?>  /> 
                是 <input name="best" type="radio" value="0"<?php if ($row['best'] == 0)
{?>  checked="checked"<?php }?>  /> 
                否</td> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">总封盘：</td> 
              <td bordercolor="#CCCCCC"><input name="zfb" type="radio" value="0" checked="checked" /> 
                封盘              </td> 
            </tr> 
            <tr> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">特码：</td> 
              <td bordercolor="#CCCCCC"><input name="kitm" type="radio" value="0"<?php if ($row['kitm'] == 0)
{?>  checked="checked"<?php }?>  /><?php if ($row['kitm'] == 0)
{?>               <font color="ff6600">封</font><?php }
else
{?>               封<?php }?>                   <input name="kitm" type="radio" value="1"<?php if ($row['kitm'] == 1)
{?>  checked="checked"<?php }?>  /><?php if ($row['kitm'] == 1)
{?>               <font color="ff6600">开</font><?php }
else
{?>               开<?php }?> </td> 
              <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">特码自动封盘时间：</td> 
              <td bordercolor="#CCCCCC"><input name="kitm1" type="text" class="input1"  id="kitm1" value="<?=$kitm1;?>" size="35" /></td> 
            </tr> 
            <tr> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正特：</td> 
              <td bordercolor="#CCCCCC"><input name="kizt" type="radio" value="0"<?php if ($row['kizt'] == 0)
{?>  checked="checked"<?php }?>  /><?php if ($row['kizt'] == 0)
{?>               <font color="ff6600">封</font><?php }
else
{?>               封<?php }?>                   <input name="kizt" type="radio" value="1"<?php if ($row['kizt'] == 1)
{?>  checked="checked"<?php }?>  /><?php if ($row['kizt'] == 1)
{?>               <font color="ff6600">开</font><?php }
else
{?>               开<?php }?> </td><input name="kizt1" type="hidden" class="input1"  id="kizt1" value="<?=$kizt1;?>" size="35" /> 
              <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正特自动封盘时间：</td> 
              <td bordercolor="#CCCCCC"><input name="kizt1" type="text" class="input1"  id="kizt1" value="<?=$kizt1;?>" size="35" /></td> --> 
              <td rowspan="8" height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正码自动封盘时间：</td> 
              <td rowspan="8" bordercolor="#CCCCCC"><input name="kizm1" type="text" class="input1"  id="kizm1" value="<?=$kizm1;?>" size="35" onchange="javascript: document.getElementById('kizt1').value=this.value;document.getElementById('kizm61').value=this.value;document.getElementById('kigg1').value=this.value;document.getElementById('kilm1').value=this.value;document.getElementById('kisx1').value=this.value;document.getElementById('kibb1').value=this.value;document.getElementById('kiws1').value=this.value;" /></td> 
            </tr> 
            <tr> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正码：</td> 
              <td bordercolor="#CCCCCC"><input name="kizm" type="radio" value="0"<?php if ($row['kizm'] == 0)
{?>  checked="checked"<?php }?>  /><?php if ($row['kizm'] == 0)
{?>               <font color="ff6600">封</font><?php }
else
{?>               封<?php }?>                   <input name="kizm" type="radio" value="1"<?php if ($row['kizm'] == 1)
{?>  checked="checked"<?php }?>  /><?php if ($row['kizm'] == 1)
{?>               <font color="ff6600">开</font><?php }
else
{?>               开<?php }?> </td> 
              <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正码自动封盘时间：</td> 
              <td bordercolor="#CCCCCC"><input name="kizm1" type="text" class="input1"  id="kizm1" value="<?=$kizm1;?>" size="35" /></td> --> 
            </tr> 
            <tr> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">五行：</td> 
              <td bordercolor="#CCCCCC"><input name="kizm6" type="radio" value="0"<?php if ($row['kizm6'] == 0)
{?>  checked="checked"<?php }?>  /><?php if ($row['kizm6'] == 0)
{?>               <font color="ff6600">封</font><?php }
else
{?>               封<?php }?>                   <input name="kizm6" type="radio" value="1"<?php if ($row['kizm6'] == 1)
{?>  checked="checked"<?php }?>  /><?php if ($row['kizm6'] == 1)
{?>               <font color="ff6600">开</font><?php }
else
{?>               开<?php }?> </td><input name="kizm61" type="hidden" class="input1"  id="kizm61" value="<?=$kizm61;?>" size="35" /> 
              <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">五行自动封盘时间：</td> 
              <td bordercolor="#CCCCCC"><input name="kizm61" type="text" class="input1"  id="kizm61" value="<?=$kizm61;?>" size="35" /></td> --> 
            </tr> 
            <tr> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">过关：</td> 
              <td bordercolor="#CCCCCC"><input name="kigg" type="radio" value="0"<?php if ($row['kigg'] == 0)
{?>  checked="checked"<?php }?>  /><?php if ($row['kigg'] == 0)
{?>               <font color="ff6600">封</font><?php }
else
{?>               封<?php }?>                   <input name="kigg" type="radio" value="1"<?php if ($row['kigg'] == 1)
{?>  checked="checked"<?php }?>  /><?php if ($row['kigg'] == 1)
{?>               <font color="ff6600">开</font><?php }
else
{?>               开<?php }?> </td><input name="kigg1" type="hidden" class="input1"  id="kigg1" value="<?=$kigg1;?>" size="35" /> 
              <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">过关自动封盘时间：</td> 
              <td bordercolor="#CCCCCC"><input name="kigg1" type="text" class="input1"  id="kigg1" value="<?=$kigg1;?>" size="35" /></td> --> 
            </tr> 
            <tr> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">连码：</td> 
              <td bordercolor="#CCCCCC"><input name="kilm" type="radio" value="0"<?php if ($row['kilm'] == 0)
{?>  checked="checked"<?php }?>  /><?php if ($row['kilm'] == 0)
{?>               <font color="ff6600">封</font><?php }
else
{?>               封<?php }?>                   <input name="kilm" type="radio" value="1"<?php if ($row['kilm'] == 1)
{?>  checked="checked"<?php }?>  /><?php if ($row['kilm'] == 1)
{?>               <font color="ff6600">开</font><?php }
else
{?>               开<?php }?> </td><input name="kilm1" type="hidden" class="input1"  id="kilm1" value="<?=$kilm1;?>" size="35" /> 
              <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">连码自动封盘时间：</td> 
              <td bordercolor="#CCCCCC"><input name="kilm1" type="text" class="input1"  id="kilm1" value="<?=$kilm1;?>" size="35" /></td> --> 
            </tr> 
            <tr> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">生肖/正特尾：</td> 
              <td bordercolor="#CCCCCC"><input name="kisx" type="radio" value="0"<?php if ($row['kisx'] == 0)
{?>  checked="checked"<?php }?>  /><?php if ($row['kisx'] == 0)
{?>               <font color="ff6600">封</font><?php }
else
{?>               封<?php }?>                   <input name="kisx" type="radio" value="1"<?php if ($row['kisx'] == 1)
{?>  checked="checked"<?php }?>  /><?php if ($row['kisx'] == 1)
{?>               <font color="ff6600">开</font><?php }
else
{?>               开<?php }?> </td><input name="kisx1" type="hidden" class="input1"  id="kisx1" value="<?=$kisx1;?>" size="35" /> 
              <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">生肖自动封盘时间：</td> 
              <td bordercolor="#CCCCCC"><input name="kisx1" type="text" class="input1"  id="kisx1" value="<?=$kisx1;?>" size="35" /></td> --> 
            </tr> 
            <tr> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">半波/半半波/正肖七色波：</td> 
              <td bordercolor="#CCCCCC"><input name="kibb" type="radio" value="0"<?php if ($row['kibb'] == 0)
{?>  checked="checked"<?php }?>  /><?php if ($row['kibb'] == 0)
{?>               <font color="ff6600">封</font><?php }
else
{?>               封<?php }?>                   <input name="kibb" type="radio" value="1"<?php if ($row['kibb'] == 1)
{?>  checked="checked"<?php }?>  /><?php if ($row['kibb'] == 1)
{?>               <font color="ff6600">开</font><?php }
else
{?>               开<?php }?> </td><input name="kibb1" type="hidden" class="input1"  id="kibb1" value="<?=$kibb1;?>" size="35" /> 
              <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">半波自动封盘时间：</td> 
              <td bordercolor="#CCCCCC"><input name="kibb1" type="text" class="input1"  id="kibb1" value="<?=$kibb1;?>" size="35" /></td> --> 
            </tr> 
            <tr> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">头尾数：</td> 
              <td bordercolor="#CCCCCC"><input name="kiws" type="radio" value="0"<?php if ($row['kiws'] == 0)
{?>  checked="checked"<?php }?>  /><?php if ($row['kiws'] == 0)
{?>               <font color="ff6600">封</font><?php }
else
{?>               封<?php }?>                   <input name="kiws" type="radio" value="1"<?php if ($row['kiws'] == 1)
{?>  checked="checked"<?php }?>  /><?php if ($row['kiws'] == 1)
{?>               <font color="ff6600">开</font><?php }
else
{?>               开<?php }?> </td><input name="kiws1" type="hidden" class="input1"  id="kiws1" value="<?=$kiws1;?>" size="35" /> 
              <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">尾数自动封盘时间：</td> 
              <td bordercolor="#CCCCCC"><input name="kiws1" type="text" class="input1"  id="kiws1" value="<?=$kiws1;?>" size="35" /></td> --> 
            </tr> 
            <!-- <tr> 
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">&nbsp;</td> 
              <td bordercolor="#CCCCCC">&nbsp;</td> 
              <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">全部自动封盘时间：</td> 
              <td bordercolor="#CCCCCC"><input name="quanbu" type="text" class="input1"  id="quanbu" value="" size="35" onchange="javascript: if (this.value) {document.getElementById('kizt1').value=this.value;document.getElementById('kizm61').value=this.value;document.getElementById('kigg1').value=this.value;document.getElementById('kilm1').value=this.value;document.getElementById('kisx1').value=this.value;document.getElementById('kibb1').value=this.value;document.getElementById('kiws1').value=this.value;document.getElementById('kizm1').value=this.value;document.getElementById('kitm1').value=this.value;}" /></td> 
            </tr> --> 
            <tr> 
              <td height="30" bordercolor="#CCCCCC" bgcolor="#FDF4CA">&nbsp;</td> 
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
            </tr> 
          </form> 
        </table> 
        <table width="100%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#ECE9D8"> 
          <tr> 
            <td height="25" align="center" valign="middle" bordercolor="cccccc" bgcolor="#FDF4CA">预设开奖期数</td> 
            <td align="center" valign="middle" bordercolor="cccccc" bgcolor="#FDF4CA">开奖时间</td> 
            <td align="center" valign="middle" bordercolor="cccccc" bgcolor="#FDF4CA">自动开盘时间</td> 
            <td align="center" valign="middle" bordercolor="cccccc" bgcolor="#FDF4CA">自动封盘时间</td> 
            <td align="center" valign="middle" bordercolor="cccccc" bgcolor="#FDF4CA">操作</td> 
          </tr><?php $resultf = $mydata2_db->query('select * from ya_kithe order by nn');
while ($imagef = $resultf->fetch())
{?> 	      <tr> 
            <td height="25" align="center" valign="middle" bordercolor="cccccc"><?=$imagef['nn'];?></td> 
            <td align="center" valign="middle" bordercolor="cccccc"><?=$imagef['nd'];?></td> 
            <td align="center" valign="middle" bordercolor="cccccc"><?=$imagef['zfbdate1'];?></td> 
            <td align="center" valign="middle" bordercolor="cccccc"><?=$imagef['zfbdate'];?></td> 
            <td align="center" valign="middle" bordercolor="cccccc"><button onclick="javascript:location.href='index.php?action=ykithe&amp;id=<?=$imagef['id'];?>'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:50;height:22"><img src="images/icon_21x21_edit01.gif" align="absmiddle" />设置</button> 
		    &nbsp;<button onclick="javascript:location.href='index.php?action=kithe&yid=<?=$imagef['id'];?>&act=del'" class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:50;height:22"><img src="images/icon_21x21_del.gif" align="absmiddle" />删除</button></td> 
          </tr><?php }?>       </table> 
      </div></td> 
    </tr> 
  </table> 
  <br /> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr> 
      <td><div align="left"> </div></td> 
      <td><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> 操作提示：自动封盘时间必须大于当前系统时间。</div></td> 
    </tr> 
  </table> 
