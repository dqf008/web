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
$lotteryType = $_GET['lottery_type'];
$lotteryNames = array('gdkl10'=>'广东快乐10分','cqkl10'=>'重庆快乐10分','tjkl10'=>'天津快乐10分','hnkl10'=>'湖南快乐10分','sxkl10'=>'山西快乐10分','ynkl10'=>'云南快乐10分','ffkl10'=>'分分快乐10分','sfkl10'=>'三分快乐10分');
$table='c_auto_klsf';
if($lotteryType=='gdkl10'){
    $table ='c_auto_3';
}
if (($_GET['action'] == 'add') && ($id == 0)){
	$qishu = $_POST['qishu'];
	$datetime = $_POST['datetime'];
	$ball_1 = $_POST['ball_1'];
	$ball_2 = $_POST['ball_2'];
	$ball_3 = $_POST['ball_3'];
	$ball_4 = $_POST['ball_4'];
	$ball_5 = $_POST['ball_5'];
	$ball_6 = $_POST['ball_6'];
	$ball_7 = $_POST['ball_7'];
	$ball_8 = $_POST['ball_8'];
    $params = [':qishu' => $qishu, ':datetime' => $datetime, ':ball_1' => $ball_1, ':ball_2' => $ball_2, ':ball_3' => $ball_3, ':ball_4' => $ball_4, ':ball_5' => $ball_5, ':ball_6' => $ball_6, ':ball_7' => $ball_7, ':ball_8' => $ball_8];
    if($lotteryType=='gdkl10'){
        $sql    = "insert into $table (qishu,datetime,ball_1,ball_2,ball_3,ball_4,ball_5,ball_6,ball_7,ball_8) values (:qishu,:datetime,:ball_1,:ball_2,:ball_3,:ball_4,:ball_5,:ball_6,:ball_7,:ball_8)";
    }else {
        $params[':name'] = $lotteryType;
        $sql    = "insert into $table (qishu,name,datetime,ball_1,ball_2,ball_3,ball_4,ball_5,ball_6,ball_7,ball_8) values (:qishu,:name,:datetime,:ball_1,:ball_2,:ball_3,:ball_4,:ball_5,:ball_6,:ball_7,:ball_8)";
    }
    $stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	message('添加成功');
}else if (($_GET['action'] == 'edit') && (0 < $id)){
	$qishu = $_POST['qishu'];
	$datetime = $_POST['datetime'];
	$ball_1 = $_POST['ball_1'];
	$ball_2 = $_POST['ball_2'];
	$ball_3 = $_POST['ball_3'];
	$ball_4 = $_POST['ball_4'];
	$ball_5 = $_POST['ball_5'];
	$ball_6 = $_POST['ball_6'];
	$ball_7 = $_POST['ball_7'];
	$ball_8 = $_POST['ball_8'];
	$params = array(':qishu' => $qishu, ':datetime' => $datetime, ':ball_1' => $ball_1, ':ball_2' => $ball_2, ':ball_3' => $ball_3, ':ball_4' => $ball_4, ':ball_5' => $ball_5, ':ball_6' => $ball_6, ':ball_7' => $ball_7, ':ball_8' => $ball_8, ':id' => $id);
    $sql = "update $table set qishu=:qishu,datetime=:datetime,ball_1=:ball_1,ball_2=:ball_2,ball_3=:ball_3,ball_4=:ball_4,ball_5=:ball_5,ball_6=:ball_6,ball_7=:ball_7,ball_8=:ball_8 where id=:id";
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	message('更新成功');
}else if (($_GET['action'] == 'delete') && (0 < $id)){
	$params = array(':id' => $id);

	$sql = "delete from $table where id=:id";
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	message('删除成功');
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
  if($("#ball_6").val()==""){ 
	  alert("请选择第六球开奖号码");
	  $("#ball_6").focus();
	  return false;
  } 
  if($("#ball_7").val()==""){ 
	  alert("请选择第七球开奖号码");
	  $("#ball_7").focus();
	  return false;
  } 
  if($("#ball_8").val()==""){ 
	  alert("请选择第八球开奖号码");
	  $("#ball_8").focus();
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
	<form name="form1" onSubmit="return check_submit();" method="post" action="?lottery_type=<?php echo $lotteryType?>&id=<?=$id;?>&action=<?=$id>0 ? 'edit' : 'add'?>&page=<?=$_REQUEST['page'];?>&orderno=<?=$orderno;?>">
	<?php 
	if ((0 < $id) && !isset($_GET['action'])){
		$sql = "select * from $table where id = $id limit 1";
		$query = $mydata1_db->query($sql);
		$rs = $query->fetch();
	}
	?>     
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;" bgcolor="#798EB9"> 
<tr> 
  <td  align="left" bgcolor="#F0FFFF">彩票类别：</td> 
  <td  align="left" bgcolor="#FFFFFF"><?php echo $lotteryNames[$lotteryType]?>【<a href="Uptime_3.php?lottery_type=<?php echo $lotteryType ?>" style="color:#ff0000;">点击进入盘口管理</a>】</td>
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
	  <option value="1" <?=$rs['ball_1']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_1']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_1']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_1']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_1']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_1']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_1']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_1']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_1']==9 ? 'selected' : ''?>>9</option>
        <option value="10" <?=$rs['ball_1']==10 ? 'selected' : ''?>>10</option>
        <option value="11" <?=$rs['ball_1']==11 ? 'selected' : ''?>>11</option>
        <option value="12" <?=$rs['ball_1']==12 ? 'selected' : ''?>>12</option>
        <option value="13" <?=$rs['ball_1']==13 ? 'selected' : ''?>>13</option>
        <option value="14" <?=$rs['ball_1']==14 ? 'selected' : ''?>>14</option>
        <option value="15" <?=$rs['ball_1']==15 ? 'selected' : ''?>>15</option>
        <option value="16" <?=$rs['ball_1']==16 ? 'selected' : ''?>>16</option>
        <option value="17" <?=$rs['ball_1']==17 ? 'selected' : ''?>>17</option>
        <option value="18" <?=$rs['ball_1']==18 ? 'selected' : ''?>>18</option>
        <option value="19" <?=$rs['ball_1']==19 ? 'selected' : ''?>>19</option>
        <option value="20" <?=$rs['ball_1']==20 ? 'selected' : ''?>>20</option>
        <option value="" <?=trim($rs['ball_1'])=='' ? 'selected' : ''?>>第一球</option>
      </select>
      <select name="ball_2" id="ball_2">
        <option value="1" <?=$rs['ball_2']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_2']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_2']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_2']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_2']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_2']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_2']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_2']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_2']==9 ? 'selected' : ''?>>9</option>
        <option value="10" <?=$rs['ball_2']==10 ? 'selected' : ''?>>10</option>
        <option value="11" <?=$rs['ball_2']==11 ? 'selected' : ''?>>11</option>
        <option value="12" <?=$rs['ball_2']==12 ? 'selected' : ''?>>12</option>
        <option value="13" <?=$rs['ball_2']==13 ? 'selected' : ''?>>13</option>
        <option value="14" <?=$rs['ball_2']==14 ? 'selected' : ''?>>14</option>
        <option value="15" <?=$rs['ball_2']==15 ? 'selected' : ''?>>15</option>
        <option value="16" <?=$rs['ball_2']==16 ? 'selected' : ''?>>16</option>
        <option value="17" <?=$rs['ball_2']==17 ? 'selected' : ''?>>17</option>
        <option value="18" <?=$rs['ball_2']==18 ? 'selected' : ''?>>18</option>
        <option value="19" <?=$rs['ball_2']==19 ? 'selected' : ''?>>19</option>
        <option value="20" <?=$rs['ball_2']==20 ? 'selected' : ''?>>20</option>
        <option value="" <?=trim($rs['ball_2'])=='' ? 'selected' : ''?>>第二球</option>
      </select>
      <select name="ball_3" id="ball_3">
        <option value="1" <?=$rs['ball_3']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_3']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_3']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_3']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_3']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_3']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_3']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_3']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_3']==9 ? 'selected' : ''?>>9</option>
        <option value="10" <?=$rs['ball_3']==10 ? 'selected' : ''?>>10</option>
        <option value="11" <?=$rs['ball_3']==11 ? 'selected' : ''?>>11</option>
        <option value="12" <?=$rs['ball_3']==12 ? 'selected' : ''?>>12</option>
        <option value="13" <?=$rs['ball_3']==13 ? 'selected' : ''?>>13</option>
        <option value="14" <?=$rs['ball_3']==14 ? 'selected' : ''?>>14</option>
        <option value="15" <?=$rs['ball_3']==15 ? 'selected' : ''?>>15</option>
        <option value="16" <?=$rs['ball_3']==16 ? 'selected' : ''?>>16</option>
        <option value="17" <?=$rs['ball_3']==17 ? 'selected' : ''?>>17</option>
        <option value="18" <?=$rs['ball_3']==18 ? 'selected' : ''?>>18</option>
        <option value="19" <?=$rs['ball_3']==19 ? 'selected' : ''?>>19</option>
        <option value="20" <?=$rs['ball_3']==20 ? 'selected' : ''?>>20</option>
        <option value="" <?=trim($rs['ball_3'])=='' ? 'selected' : ''?>>第三球</option>
      </select>
      <select name="ball_4" id="ball_4">
        <option value="1" <?=$rs['ball_4']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_4']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_4']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_4']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_4']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_4']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_4']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_4']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_4']==9 ? 'selected' : ''?>>9</option>
        <option value="10" <?=$rs['ball_4']==10 ? 'selected' : ''?>>10</option>
        <option value="11" <?=$rs['ball_4']==11 ? 'selected' : ''?>>11</option>
        <option value="12" <?=$rs['ball_4']==12 ? 'selected' : ''?>>12</option>
        <option value="13" <?=$rs['ball_4']==13 ? 'selected' : ''?>>13</option>
        <option value="14" <?=$rs['ball_4']==14 ? 'selected' : ''?>>14</option>
        <option value="15" <?=$rs['ball_4']==15 ? 'selected' : ''?>>15</option>
        <option value="16" <?=$rs['ball_4']==16 ? 'selected' : ''?>>16</option>
        <option value="17" <?=$rs['ball_4']==17 ? 'selected' : ''?>>17</option>
        <option value="18" <?=$rs['ball_4']==18 ? 'selected' : ''?>>18</option>
        <option value="19" <?=$rs['ball_4']==19 ? 'selected' : ''?>>19</option>
        <option value="20" <?=$rs['ball_4']==20 ? 'selected' : ''?>>20</option>
        <option value="" <?=trim($rs['ball_4'])=='' ? 'selected' : ''?>>第四球</option>
      </select>
      <select name="ball_5" id="ball_5">
        <option value="1" <?=$rs['ball_5']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_5']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_5']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_5']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_5']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_5']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_5']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_5']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_5']==9 ? 'selected' : ''?>>9</option>
        <option value="10" <?=$rs['ball_5']==10 ? 'selected' : ''?>>10</option>
        <option value="11" <?=$rs['ball_5']==11 ? 'selected' : ''?>>11</option>
        <option value="12" <?=$rs['ball_5']==12 ? 'selected' : ''?>>12</option>
        <option value="13" <?=$rs['ball_5']==13 ? 'selected' : ''?>>13</option>
        <option value="14" <?=$rs['ball_5']==14 ? 'selected' : ''?>>14</option>
        <option value="15" <?=$rs['ball_5']==15 ? 'selected' : ''?>>15</option>
        <option value="16" <?=$rs['ball_5']==16 ? 'selected' : ''?>>16</option>
        <option value="17" <?=$rs['ball_5']==17 ? 'selected' : ''?>>17</option>
        <option value="18" <?=$rs['ball_5']==18 ? 'selected' : ''?>>18</option>
        <option value="19" <?=$rs['ball_5']==19 ? 'selected' : ''?>>19</option>
        <option value="20" <?=$rs['ball_5']==20 ? 'selected' : ''?>>20</option>
        <option value="" <?=trim($rs['ball_5'])=='' ? 'selected' : ''?>>第五球</option>
      </select>
      <select name="ball_6" id="ball_6">
        <option value="1" <?=$rs['ball_6']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_6']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_6']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_6']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_6']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_6']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_6']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_6']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_6']==9 ? 'selected' : ''?>>9</option>
        <option value="10" <?=$rs['ball_6']==10 ? 'selected' : ''?>>10</option>
        <option value="11" <?=$rs['ball_6']==11 ? 'selected' : ''?>>11</option>
        <option value="12" <?=$rs['ball_6']==12 ? 'selected' : ''?>>12</option>
        <option value="13" <?=$rs['ball_6']==13 ? 'selected' : ''?>>13</option>
        <option value="14" <?=$rs['ball_6']==14 ? 'selected' : ''?>>14</option>
        <option value="15" <?=$rs['ball_6']==15 ? 'selected' : ''?>>15</option>
        <option value="16" <?=$rs['ball_6']==16 ? 'selected' : ''?>>16</option>
        <option value="17" <?=$rs['ball_6']==17 ? 'selected' : ''?>>17</option>
        <option value="18" <?=$rs['ball_6']==18 ? 'selected' : ''?>>18</option>
        <option value="19" <?=$rs['ball_6']==19 ? 'selected' : ''?>>19</option>
        <option value="20" <?=$rs['ball_6']==20 ? 'selected' : ''?>>20</option>
        <option value="" <?=trim($rs['ball_6'])=='' ? 'selected' : ''?>>第六球</option>
      </select>
      <select name="ball_7" id="ball_7">
        <option value="1" <?=$rs['ball_7']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_7']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_7']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_7']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_7']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_7']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_7']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_7']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_7']==9 ? 'selected' : ''?>>9</option>
        <option value="10" <?=$rs['ball_7']==10 ? 'selected' : ''?>>10</option>
        <option value="11" <?=$rs['ball_7']==11 ? 'selected' : ''?>>11</option>
        <option value="12" <?=$rs['ball_7']==12 ? 'selected' : ''?>>12</option>
        <option value="13" <?=$rs['ball_7']==13 ? 'selected' : ''?>>13</option>
        <option value="14" <?=$rs['ball_7']==14 ? 'selected' : ''?>>14</option>
        <option value="15" <?=$rs['ball_7']==15 ? 'selected' : ''?>>15</option>
        <option value="16" <?=$rs['ball_7']==16 ? 'selected' : ''?>>16</option>
        <option value="17" <?=$rs['ball_7']==17 ? 'selected' : ''?>>17</option>
        <option value="18" <?=$rs['ball_7']==18 ? 'selected' : ''?>>18</option>
        <option value="19" <?=$rs['ball_7']==19 ? 'selected' : ''?>>19</option>
        <option value="20" <?=$rs['ball_7']==20 ? 'selected' : ''?>>20</option>
        <option value="" <?=trim($rs['ball_7'])=='' ? 'selected' : ''?>>第七球</option>
      </select>
      <select name="ball_8" id="ball_8">
        <option value="1" <?=$rs['ball_8']==1 ? 'selected' : ''?>>1</option>
        <option value="2" <?=$rs['ball_8']==2 ? 'selected' : ''?>>2</option>
        <option value="3" <?=$rs['ball_8']==3 ? 'selected' : ''?>>3</option>
        <option value="4" <?=$rs['ball_8']==4 ? 'selected' : ''?>>4</option>
        <option value="5" <?=$rs['ball_8']==5 ? 'selected' : ''?>>5</option>
        <option value="6" <?=$rs['ball_8']==6 ? 'selected' : ''?>>6</option>
        <option value="7" <?=$rs['ball_8']==7 ? 'selected' : ''?>>7</option>
        <option value="8" <?=$rs['ball_8']==8 ? 'selected' : ''?>>8</option>
        <option value="9" <?=$rs['ball_8']==9 ? 'selected' : ''?>>9</option>
        <option value="10" <?=$rs['ball_8']==10 ? 'selected' : ''?>>10</option>
        <option value="11" <?=$rs['ball_8']==11 ? 'selected' : ''?>>11</option>
        <option value="12" <?=$rs['ball_8']==12 ? 'selected' : ''?>>12</option>
        <option value="13" <?=$rs['ball_8']==13 ? 'selected' : ''?>>13</option>
        <option value="14" <?=$rs['ball_8']==14 ? 'selected' : ''?>>14</option>
        <option value="15" <?=$rs['ball_8']==15 ? 'selected' : ''?>>15</option>
        <option value="16" <?=$rs['ball_8']==16 ? 'selected' : ''?>>16</option>
        <option value="17" <?=$rs['ball_8']==17 ? 'selected' : ''?>>17</option>
        <option value="18" <?=$rs['ball_8']==18 ? 'selected' : ''?>>18</option>
        <option value="19" <?=$rs['ball_8']==19 ? 'selected' : ''?>>19</option>
        <option value="20" <?=$rs['ball_8']==20 ? 'selected' : ''?>>20</option>
        <option value="" <?=trim($rs['ball_8'])=='' ? 'selected' : ''?>>第八球</option>
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
			<td align="center"><strong>第五球</strong></td> 
			<td align="center"><strong>第六球</strong></td> 
			<td align="center"><strong>第七球</strong></td> 
	  <td height="25" align="center"><strong>第八球</strong></td> 
	  <td align="center"><strong>总和</strong></td> 
	  <td align="center"><strong>龙虎</strong></td> 
	  <td align="center">结算</td> 
	  <td align="center"><strong>操作</strong></td> 
	</tr>
<?php 
$params = array();
if($lotteryType=='gdkl10'){
    if ($orderno != '') {
        $params[':qishu'] = $orderno;
        $sqlwhere         .= ' where qishu=:qishu';
    }
}else {
    $sqlwhere = " where name ='$lotteryType'";
    if ($orderno != '') {
        $params[':qishu'] = $orderno;
        $sqlwhere         .= ' and qishu=:qishu';
    }
}
$sql = 'select id from ' .$table. $sqlwhere . ' order by qishu desc';
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
	$sql = "select * from $table where id in($id) order by qishu desc";
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
		$hm[] = $rows['ball_6'];
		$hm[] = $rows['ball_7'];
		$hm[] = $rows['ball_8'];
		if ($rows['ok'] == 1)
		{
			$ok = '<a href="../cj/lottery/js_3.php?lottery_type='.$lotteryType.'&qi=' . $rows['qishu'] . '&t=1"><font color="#FF0000">已结算</font></a>';
		}
		else
		{
			$ok = '<a href="../cj/lottery/js_3.php?lottery_type='.$lotteryType.'&qi=' . $rows['qishu'] . '&t=1" onClick="return confirm(\'结算后将无法更改结算结果。\\n\\n请核对开奖结果，以免结算出错！\\n\\n如已经核对正确请点击确定进行结算。\');"><font color="#0000FF">未结算</font></a>';
		}
?>       
	<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;line-height:20px;"> 
	  <td height="25" align="center" valign="middle"><?php echo $lotteryNames[$lotteryType]?></td>
	  <td align="center" valign="middle"><?=$rows['qishu'];?></td> 
	  <td align="center" valign="middle"><?=$rows['datetime'];?></td> 
	  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_4/<?=BuLing($rows['ball_1']);?>.png"></td> 
	  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_4/<?=BuLing($rows['ball_2']);?>.png"></td> 
	  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_4/<?=BuLing($rows['ball_3']);?>.png"></td> 
	  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_4/<?=BuLing($rows['ball_4']);?>.png"></td> 
	  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_4/<?=BuLing($rows['ball_5']);?>.png"></td> 
	  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_4/<?=BuLing($rows['ball_6']);?>.png"></td> 
	  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_4/<?=BuLing($rows['ball_7']);?>.png"></td> 
	  <td align="center" valign="middle"><img src="/Lottery/Images/Ball_4/<?=BuLing($rows['ball_8']);?>.png"></td> 
	  <td><?=Klsf_Auto($hm, 1);?>/<?=Klsf_Auto($hm, 2);?>/<?=Klsf_Auto($hm, 3);?>/<?=Klsf_Auto($hm, 4);?></td> 
	  <td><?=Klsf_Auto($hm, 5);?></td> 
	  <td><?=$ok;?></td> 
	  <td> 
		  <a href="?lottery_type=<?php echo $lotteryType ?>&id=<?=$rows['id'];?>&page=<?=$_REQUEST['page'];?>&orderno=<?=$orderno;?>">编辑</a>&nbsp;
		  <a href="javascript:void();" onClick="if(confirm('是否确定删除该记录？')){window.location.href='Auto_3.php?lottery_type=<?php echo $lotteryType?>&action=delete&id=<?=$rows['id'];?>'}">删除</a>&nbsp;
		  <a href="javascript:void();" onClick="if(confirm('是否重算，期数为：<?=$rows['qishu'];?>？')){window.location.href='js_reset.php?action=js_reset&t=1&atype=<?php echo $lotteryType?>&qi=<?=$rows['qishu'];?>'}">重算</a>&nbsp;
	  </td> 
	  </tr>
	  <?php }
}?> 	  <tr style="background-color:#FFFFFF;"> 
	  <td colspan="15" align="center" valign="middle"><?=$pageStr;?></td> 
	  </tr> 
  </table></td> 
  </tr> 
</table> 
</div> 
</body> 
</html>