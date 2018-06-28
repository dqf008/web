<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cpgl');
check_quanxian('cpkj');
include '../../include/pager.class.php';
include 'auto_class.php';
$id = 0;
if (0 < $_GET['id']){
	$id = intval($_GET['id']);
}

if ($_REQUEST['page'] == ''){
	$_REQUEST['page'] = 1;
}

if (($_GET['action'] == 'add') && ($id == 0)){
    $qishu = $_POST['qishu'];
    $datetime = $_POST['datetime'];
    $ball_1 = $_POST['ball_1'];
    $ball_2 = $_POST['ball_2'];
    $ball_3 = $_POST['ball_3'];
    $ball_4 = $_POST['ball_4'];
    $ball_5 = $_POST['ball_5'];
    $params = array(':qishu' => $qishu, ':datetime' => $datetime, ':ball_1' => $ball_1, ':ball_2' => $ball_2, ':ball_3' => $ball_3, ':ball_4' => $ball_4, ':ball_5' => $ball_5);
    $sql = 'insert into c_auto_sfssc(qishu,datetime,ball_1,ball_2,ball_3,ball_4,ball_5' . "\r\n\t" . ') values (:qishu,:datetime,:ball_1,:ball_2,:ball_3,:ball_4,:ball_5)';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    echo "<script>alert('添加成功');</script>";
}else if (($_GET['action'] == 'edit') && (0 < $id)){
    $qishu = $_POST['qishu'];
    $datetime = $_POST['datetime'];
    $ball_1 = $_POST['ball_1'];
    $ball_2 = $_POST['ball_2'];
    $ball_3 = $_POST['ball_3'];
    $ball_4 = $_POST['ball_4'];
    $ball_5 = $_POST['ball_5'];
    $params = array(':qishu' => $qishu, ':datetime' => $datetime, ':ball_1' => $ball_1, ':ball_2' => $ball_2, ':ball_3' => $ball_3, ':ball_4' => $ball_4, ':ball_5' => $ball_5, ':id' => $id);
    $sql = 'update c_auto_sfssc set qishu=:qishu,datetime=:datetime,ball_1=:ball_1,ball_2=:ball_2,ball_3=:ball_3,ball_4=:ball_4,ball_5=:ball_5 where id=:id';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    echo "<script>alert('更新成功');</script>";
}else if (($_GET['action'] == 'delete') && (0 < $id)){
    $params = array(':id' => $id);
    $sql = 'delete from c_auto_sfssc where id=:id';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    echo "<script>alert('删除成功');</script>";
}
$orderno = trim($_GET['orderno']);
?> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>Welcome</title> 
<link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" /> 
<script language="javascript" src="/js/jquery.js"></script> 
<script language="javascript"> 
function check_submit(){ 
  if($("#qishu").val()==""){ 
	  alert("请填写开奖期数");
	  $("#qishu").focus();
	  return false;
  } 
  if($("#datetime").val()==""){ 
	  alert("请填写开奖时间");
	  $("#datetime").focus();
	  return false;
  } 
  if($("#ball_1").val()==""){ 
	  alert("请选择第一球开奖号码");
	  $("#ball_1").focus();
	  return false;
  } 
  if($("#ball_2").val()==""){ 
	  alert("请选择第二球开奖号码");
	  $("#ball_2").focus();
	  return false;
  } 
  if($("#ball_3").val()==""){ 
	  alert("请选择第三球开奖号码");
	  $("#ball_3").focus();
	  return false;
  } 
  if($("#ball_4").val()==""){ 
	  alert("请选择第四球开奖号码");
	  $("#ball_4").focus();
	  return false;
  } 
  if($("#ball_5").val()==""){ 
	  alert("请选择第五球开奖号码");
	  $("#ball_5").focus();
	  return false;
  } 
  return true;
} 
</script> 
</head> 
<body> 
<div id="pageMain"> 
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5"> 
  <tr> 
	<td valign="top">
	<?php include_once 'Menu_Auto.php';?>       
	<form name="form1" onSubmit="return check_submit();" method="post" action="?id=<?=$id;?>&action=<?=$id>0 ? 'edit' : 'add'?>&page=<?=$_REQUEST['page'];?>&orderno=<?=$orderno;?>">
	<?php 
	if ((0 < $id) && !isset($_GET['action'])){
		$sql = 'select * from c_auto_sfssc where id=\'' . $id . '\' limit 1';
		$query = $mydata1_db->query($sql);
		$rs = $query->fetch();
		
	}
	?> 
		<table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;" bgcolor="#798EB9"> 
		<tr> 
		  <td  align="left" bgcolor="#F0FFFF">彩票类别：</td> 
		  <td  align="left" bgcolor="#FFFFFF">三分时时彩【<a href="Uptime_sfssc.php" style="color:#ff0000;">点击进入盘口管理</a>】</td>
		</tr> 
		<tr> 
		  <td width="60"  align="left" bgcolor="#F0FFFF">开奖期号：</td> 
		  <td  align="left" bgcolor="#FFFFFF"><input name="qishu" type="text" id="qishu" value="<?=$rs['qishu'];?>" size="20" maxlength="11"/></td> 
		</tr> 
		<tr> 
		  <td align="left" bgcolor="#F0FFFF">开奖时间：</td> 
		  <td align="left" bgcolor="#FFFFFF"><input name="datetime" type="text" id="datetime" value="<?=$rs['datetime'];?>" size="20" maxlength="19"/></td> 
		  </tr> 
		<tr> 
		  <td align="left" bgcolor="#F0FFFF">开奖号码：</td> 
		  <td align="left" bgcolor="#FFFFFF"><select name="ball_1" id="ball_1"> 
			  <option value="0" <?=$rs['ball_1']==0 ? 'selected' : ''?>>0</option>
        <option value="1" <?=$rs['ball_1']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_1']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_1']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_1']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_1']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_1']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_1']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_1']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_1']==9 ? 'selected' : ''?>>9</option>
        <option value="" <?=trim($rs['ball_1'])=='' ? 'selected' : ''?>>第一球</option>
      </select>
      <select name="ball_2" id="ball_2">
        <option value="0" <?=$rs['ball_2']==0 ? 'selected' : ''?>>0</option>
        <option value="1" <?=$rs['ball_2']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_2']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_2']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_2']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_2']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_2']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_2']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_2']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_2']==9 ? 'selected' : ''?>>9</option>
        <option value="" <?=trim($rs['ball_2'])=='' ? 'selected' : ''?>>第二球</option>
      </select>
      <select name="ball_3" id="ball_3">
        <option value="0" <?=$rs['ball_3']==0 ? 'selected' : ''?>>0</option>
        <option value="1" <?=$rs['ball_3']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_3']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_3']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_3']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_3']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_3']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_3']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_3']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_3']==9 ? 'selected' : ''?>>9</option>
        <option value="" <?=trim($rs['ball_3'])=='' ? 'selected' : ''?>>第三球</option>
      </select>
      <select name="ball_4" id="ball_4">
        <option value="0" <?=$rs['ball_4']==0 ? 'selected' : ''?>>0</option>
        <option value="1" <?=$rs['ball_4']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_4']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_4']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_4']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_4']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_4']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_4']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_4']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_4']==9 ? 'selected' : ''?>>9</option>
        <option value="" <?=trim($rs['ball_4'])=='' ? 'selected' : ''?>>第四球</option>
      </select>
      <select name="ball_5" id="ball_5">
        <option value="0" <?=$rs['ball_5']==0 ? 'selected' : ''?>>0</option>
        <option value="1" <?=$rs['ball_5']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_5']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_5']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_5']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_5']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_5']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_5']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_5']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_5']==9 ? 'selected' : ''?>>9</option>
        <option value="" <?=trim($rs['ball_5'])=='' ? 'selected' : ''?>>第五球</option> 
			</select></td> 
		</tr> 
		<tr> 
		  <td align="center" bgcolor="#FFFFFF">&nbsp;</td> 
		  <td align="left" bgcolor="#FFFFFF"><input name="submit" type="submit" class="submit80" value="确认发布"/></td> 
		</tr> 
		</table>   
		  </form> 
		  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9" style="margin-top:5px;"> 
		   <form name="form1" method="get" action=""> 
			<tr> 
			  <td align="center" bgcolor="#FFFFFF"> 
				  彩票期号 
				  <input name="orderno" type="text" id="orderno" value="<?=$orderno;?>" size="22" maxlength="20"/> 
				  &nbsp;<input type="submit" name="Submit" value="搜索"></td> 
			  </tr>    
			</form> 
		  </table> 
		  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;" bgcolor="#798EB9">    
		  <tr style="background-color:#3C4D82;color:#FFF"> 
			<td align="center"><strong>彩票类别</strong></td> 
			<td align="center"><strong>彩票期号</strong></td> 
			<td align="center"><strong>开奖时间</strong></td> 
			<td align="center"><strong>第一球</strong></td> 
			<td align="center"><strong>第二球</strong></td> 
			<td align="center"><strong>第三球</strong></td> 
			<td align="center"><strong>第四球</strong></td> 
		    <td height="25" align="center"><strong>第五球</strong></td> 
		    <td align="center"><strong>总和</strong></td> 
		    <td align="center"><strong>龙虎</strong></td> 
		    <td height="25" align="center"><strong>前三/中三/后三</strong></td> 
		    <td align="center">结算</td> 
		    <td align="center"><strong>操作</strong></td> 
		 </tr>
				
		<?php 
		$params = array();
		if ($orderno != ''){
			$params[':qishu'] = $orderno;
			$sqlwhere = ' where qishu=:qishu';
		}else{
			$sqlwhere = '';
		}
		$sql = 'select id from c_auto_sfssc ' . $sqlwhere . ' order by qishu desc';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$sum = $stmt->rowCount();
		$thisPage = 1;
		$pagenum = 50;
		if ($_GET['page']){
			$thisPage = $_GET['page'];
		}
		$CurrentPage = (isset($_GET['page']) ? $_GET['page'] : 1);
		$myPage = new pager($sum, intval($CurrentPage), $pagenum);
		$pageStr = $myPage->GetPagerContent();
		$id = '';
		$i = 1;
		$start = (($CurrentPage - 1) * $pagenum) + 1;
		$end = $CurrentPage * $pagenum;
		while ($row = $stmt->fetch()){
			if (($start <= $i) && ($i <= $end)){
				$id .= intval($row['id']) . ',';
			}
			if ($end < $i){
				break;
			}
			$i++;
		}
		if ($id){
		$id = rtrim($id, ',');
		$sql = 'select * from c_auto_sfssc where id in(' . $id . ') order by qishu desc';
		$query = $mydata1_db->query($sql);
		$time = time();
		while ($rows = $query->fetch()){
			$color = '#FFFFFF';
			$over = '#EBEBEB';
			$out = '#ffffff';
			$hm = array();
			$hm[] = $rows['ball_1'];
			$hm[] = $rows['ball_2'];
			$hm[] = $rows['ball_3'];
			$hm[] = $rows['ball_4'];
			$hm[] = $rows['ball_5'];
			if ($rows['ok'] == 1){
				$ok = '<a href="../cj/lottery/js_sfssc.php?qi=' . $rows['qishu'] . '&t=1"><font color="#FF0000">已结算</font></a>';
			}else{
				$ok = '<a href="../cj/lottery/js_sfssc.php?qi=' . $rows['qishu'] . '&t=1" onClick="return confirm(\'结算后将无法更改结算结果。\\n\\n请核对开奖结果，以免结算出错！\\n\\n如已经核对正确请点击确定进行结算。\');"><font color="#0000FF">未结算</font></a>';
			}?>       
			<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;line-height:20px;"> 
			  <td height="25" align="center" valign="middle">三分时时彩</td>
			  <td align="center" valign="middle"><?=$rows['qishu'];?></td> 
			  <td align="center" valign="middle"><?=$rows['datetime'];?></td> 
			  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_2/<?=$rows['ball_1'];?>.png"></td> 
			  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_2/<?=$rows['ball_2'];?>.png"></td> 
			  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_2/<?=$rows['ball_3'];?>.png"></td> 
			  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_2/<?=$rows['ball_4'];?>.png"></td> 
			  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_2/<?=$rows['ball_5'];?>.png"></td> 
			  <td><?=Ssc_Auto($hm, 1);?>/<?=Ssc_Auto($hm, 2);?>/<?=Ssc_Auto($hm, 3);?></td> 
			  <td><?=Ssc_Auto($hm, 4);?></td> 
			  <td><?=Ssc_Auto($hm, 5);?>/<?=Ssc_Auto($hm, 6);?>/<?=Ssc_Auto($hm, 7);?></td> 
			  <td><?=$ok;?></td> 
			  <td> 
				  <a href="?id=<?=$rows['id'];?>&page=<?=$_REQUEST['page'];?>&orderno=<?=$orderno;?>">编辑</a>&nbsp;
				  <a href="javascript:void();" onClick="if(confirm('是否确定删除该记录？')){window.location.href='auto_sfssc.php?action=delete&id=<?=$rows['id'];?>'}">删除</a>&nbsp;
				  <a href="javascript:void();" onClick="if(confirm('是否重算，期数为：<?=$rows['qishu'];?>？')){window.location.href='js_reset.php?action=js_reset&t=1&atype=sfssc&qi=<?=$rows['qishu'];?>'}">重算</a>&nbsp;
			  </td> 
			  </tr>
			  <?php }
		}?> 	  <tr style="background-color:#FFFFFF;"> 
			  <td colspan="13" align="center" valign="middle"><?=$pageStr;?></td> 
			  </tr> 
		  </table>    
	</td> 
  </tr> 
</table> 
</div> 
</body> 
</html>