<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cpgl');
check_quanxian('cpkj');
$id = $_REQUEST['id'];
$uid = $_REQUEST['uid'];
$langx = $_SESSION['langx'];
$stype = $_REQUEST['stype'];
$loginname = $_SESSION['loginname'];
$lv = $_REQUEST['lv'];
$xtype = $_REQUEST['xtype'];
$username = $_REQUEST['username'];
$riqi = date('Y-m-d', time());
$qi = $_REQUEST['qi'];
$ok = $_REQUEST['ok'];
if ($qi == ''){
	$qi = $riqi;
}
$id = $_REQUEST['id'];
$qihao = $_REQUEST['qihao'];
$kaipan = $_REQUEST['kaipan'];
$fengpan = $_REQUEST['fengpan'];
$hm1 = $_REQUEST['hm1'];
$hm2 = $_REQUEST['hm2'];
$hm3 = $_REQUEST['hm3'];
$hm4 = $_REQUEST['hm4'];
$hm5 = $_REQUEST['hm5'];
$hm6 = $_REQUEST['hm6'];
$hm7 = $_REQUEST['hm7'];
$hm8 = $_REQUEST['hm8'];
$hm9 = $_REQUEST['hm9'];
$hm10 = $_REQUEST['hm10'];
$hm11 = $_REQUEST['hm11'];
$hm12 = $_REQUEST['hm12'];
$hm13 = $_REQUEST['hm13'];
$hm14 = $_REQUEST['hm14'];
$hm15 = $_REQUEST['hm15'];
$hm16 = $_REQUEST['hm16'];
$hm17 = $_REQUEST['hm17'];
$hm18 = $_REQUEST['hm18'];
$hm19 = $_REQUEST['hm19'];
$hm20 = $_REQUEST['hm20'];
$tm = $_REQUEST['tm'];
if ($_REQUEST['save'] == 'add'){
	$params = array(':qihao' => $qihao, ':kaipan' => $kaipan, ':fengpan' => $fengpan, ':addtime' => date('Y-m-d H:i:s', time() + (12 * 3600)));
	$mysql = 'insert into lottery_k_kl8 set qihao=:qihao,kaipan=:kaipan,fengpan=:fengpan,addtime=:addtime';
	$stmt = $mydata1_db->prepare($mysql);
	$stmt->execute($params) || exit('第' . $qihao . '期添加失败');
	echo "<script>alert('添加成功！');</script>";
}
if ($_POST['update']){
	$params = array(':qihao' => $qihao, ':kaipan' => $kaipan, ':fengpan' => $fengpan, ':hm1' => $hm1, ':hm2' => $hm2, ':hm3' => $hm3, ':hm4' => $hm4, ':hm5' => $hm5, ':hm6' => $hm6, ':hm7' => $hm7, ':hm8' => $hm8, ':hm9' => $hm9, ':hm10' => $hm10, ':hm11' => $hm11, ':hm12' => $hm12, ':hm13' => $hm13, ':hm14' => $hm14, ':hm15' => $hm15, ':hm16' => $hm16, ':hm17' => $hm17, ':hm18' => $hm18, ':hm19' => $hm19, ':hm20' => $hm20, ':id' => $id);
	$mysql = 'update lottery_k_kl8 set qihao=:qihao,kaipan=:kaipan,fengpan=:fengpan,hm1=:hm1,hm2=:hm2,hm3=:hm3,hm4=:hm4,hm5=:hm5,hm6=:hm6,hm7=:hm7,hm8=:hm8,hm9=:hm9,hm10=:hm10,hm11=:hm11,hm12=:hm12,hm13=:hm13,hm14=:hm14,hm15=:hm15,hm16=:hm16,hm17=:hm17,hm18=:hm18,hm19=:hm19,hm20=:hm20 where id=:id';
	$stmt = $mydata1_db->prepare($mysql);
	$stmt->execute($params) || exit('北京快乐8第' . $qihao . '期修改失败');
	echo "<script>alert('保存成功！');</script>";
}
if ($_POST['delete']){
	$params = array(':id' => $id);
	$mysql = 'delete from lottery_k_kl8 where id=:id';
	$stmt = $mydata1_db->prepare($mysql);
	$stmt->execute($params);
	echo "<script>alert('删除成功！');</script>";
}

if ($_POST['jsreset']){
	$qihao = $_POST['qihao'];
	$atype = 'kl8';
	echo "<script>window.location.href='js_reset.php?action=jsreset&t=1&atype=<?=$atype;?>&qihao=<?=$qihao;?>';</script>";
}

$params = array();
$qihao = trim($_REQUEST['qihao']);
if ($qihao != ''){
	$params[':qihao'] = $qihao;
	$sqlwhere = ' where qihao=:qihao ';
}else{
	$sqlwhere = '';
}
$sql = 'select * from lottery_k_kl8 ' . $sqlwhere . ' order by id desc';
$result = $mydata1_db->prepare($sql);
$result->execute($params);
$cou = $result->rowCount();
$page = $_REQUEST['page'];
if (($page == '') || ($page < 0)){
	$page = 0;
}
$page_size = 50;
$page_count = ceil($cou / $page_size);
if (($page_count - 1) < $page){
	$page = $page_count - 1;
}
$offset = floatval($page * $page_size);
if ($offset < 0){
	$offset = 0;
}
$mysql = $sql . '  limit ' . $offset . ',' . $page_size . ';';
$result = $mydata1_db->prepare($mysql);
$result->execute($params);
?> 
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<style type="text/css">
BODY {
SCROLLBAR-FACE-COLOR: rgb(255,204,0);
SCROLLBAR-3DLIGHT-COLOR: rgb(255,207,116);
SCROLLBAR-DARKSHADOW-COLOR: rgb(255,227,163);
SCROLLBAR-BASE-COLOR: rgb(255,217,93)
}
.STYLE2 {font-size: 12px}
body {
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
}
td{font:13px/120% "宋体";padding:3px;}
a{
  color:#F37605;
  text-decoration: none;
}
.m_title{background:url(../images/06.gif);height:24px;}
.m_title td{font-weight:800;}
</STYLE>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" >
	  <tr>
		<td colspan="4" align="center" bgcolor="#FFFFFF"><a href="lottery_auto_3d.php">福彩3D</a> - <a href="lottery_auto_pl3.php">体彩排列3</a> - <a href="lottery_auto_ssl.php">上海时时乐</a> - <a href="lottery_auto_kl8.php">北京快乐8</a> - <a href="lottery_auto_qxc.php">七星彩</a> - <a href="lottery_auto_pcdd.php?lottert_type=pcdd">PC蛋蛋</a></td>
	  </tr>
	  <tr class="m_title">
		<td colspan="4" align="center">北京快乐8期数添加</td>
	  </tr>
	  <tr class="m_title">
		<td align="center">北京快乐8期号</td>
		<td align="center">开盘时间</td>
		<td align="center">封盘时间</td>
		<td align="center">操作</td>
	  </tr>
	  <tr><form name="AddSubmit" method="post" action="?save=add">
		<td align="center" bgcolor="#FFFFFF"><input name="qihao" type="text" id="qihao" maxlength=7 size="15"></td>
		<td align="center" bgcolor="#FFFFFF"><input name="kaipan" type="text" id="kaipan" size="15"></td>
		<td align="center" bgcolor="#FFFFFF"><input name="fengpan" type="text" id="fengpan" size="15"></td>
		<td align="center" bgcolor="#FFFFFF"><input class=za_button name="add" type="Submit" id="add" value="立即添加"></td>
	  </form></tr>
  </table>
<br>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9" style="margin-top:5px;">
   <form name="form1" method="get" action="">
	<tr>
	  <td align="center" bgcolor="#FFFFFF">
		  彩票期号
		  <input name="qihao" type="text" id="qihao" value="<?=$qihao;?>" size="22" maxlength="20"/>
		  &nbsp;<input type="submit" name="Submit" value="搜索"></td>
	  </tr>
	</form>
  </table>
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" >
<tr class="m_title">
  <td colspan="25" align="center">北京快乐8开奖管理【<a href="lottery_time_kl8.php"><font color="#FF0000">点击进入北京快乐8开盘时间管理</font></a>】</td>
</tr>
<tr class="m_title">
  <td align="center">期号</td>
  <td align="center">开盘时间</td>
  <td align="center">封盘时间</td>
  <td align="center">1</td>
  <td align="center">2</td>
  <td align="center">3</td>
  <td align="center">4</td>
  <td align="center">5</td>
  <td align="center">6</td>
  <td align="center">7</td>
  <td align="center">8</td>
  <td align="center">9</td>
  <td align="center">10</td>
  <td align="center">11</td>
  <td align="center">12</td>
  <td align="center">13</td>
  <td align="center">14</td>
  <td align="center">15</td>
  <td align="center">16</td>
  <td align="center">17</td>
  <td align="center">18</td>
  <td align="center">19</td>
  <td align="center">20</td>
  <td align="center">操作</td>
  <td align="center">开奖</td>
</tr>
<?php 
if ($cou == 0){

}else{
	while ($row = $result->fetch())
	{
?>   
<tr><form name="FrmSubmit" method="post" action="?">
  <td align="center" bgcolor="#FFFFFF"><input name="qihao" type="text" id="qihao" value="<?=$row['qihao'];?>" maxlength=6 size="6" readonly="readonly"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="kaipan" type="text" id="kaipan" value="<?=$row['kaipan'];?>" size="15"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="fengpan" type="text" id="fengpan" value="<?=$row['fengpan'];?>" size="15"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm1" type="text" id="hm1" value="<?=$row['hm1'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm2" type="text" id="hm2" value="<?=$row['hm2'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm3" type="text" id="hm3" value="<?=$row['hm3'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm4" type="text" id="hm4" value="<?=$row['hm4'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm5" type="text" id="hm5" value="<?=$row['hm5'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm6" type="text" id="hm6" value="<?=$row['hm6'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm7" type="text" id="hm7" value="<?=$row['hm7'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm8" type="text" id="hm8" value="<?=$row['hm8'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm9" type="text" id="hm9" value="<?=$row['hm9'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm10" type="text" id="hm10" value="<?=$row['hm10'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm11" type="text" id="hm11" value="<?=$row['hm11'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm12" type="text" id="hm12" value="<?=$row['hm12'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm13" type="text" id="hm13" value="<?=$row['hm13'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm14" type="text" id="hm14" value="<?=$row['hm14'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm15" type="text" id="hm15" value="<?=$row['hm15'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm16" type="text" id="hm16" value="<?=$row['hm16'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm17" type="text" id="hm17" value="<?=$row['hm17'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm18" type="text" id="hm18" value="<?=$row['hm18'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm19" type="text" id="hm19" value="<?=$row['hm19'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm20" type="text" id="hm20" value="<?=$row['hm20'];?>" maxlength=2 size="2" style="width:20px;"></td>
  <td align="center" bgcolor="#FFFFFF"><input class=za_button name="update" type="Submit" id="update" value="保存">
  <input class=za_button name="delete" type="Submit" id="delete" value="删除" onClick="return confirm('是否确定删除该记录？');">
  <input name="id" type="hidden" id="id" value="<?=$row['id'];?>">
  <input class=za_button name="jsreset" type="Submit" id="jsreset" value="重算" onClick="return confirm('是否重算，期号：<?=$row['qihao'];?>？');">
  </td>
  <td align="center" bgcolor="#FFFFFF">
<?php if ($row['ok'] == 0){?>
 <a href="../cj/lottery/kl8_auto.php?qi=<?=$row['qihao'];?>&t=1" onClick="return confirm('请确认您已经核对完开奖结果并已经保存？\r\n如未保存请先保存开奖结果，以免结算出错！\r\n如已经保存请点击确定进行结算。');">				<font color="#FF0000">点击开奖</font></a>
<?php }else{?> 
	<font color="#0000FF">已开奖</font><?php }?> </td>
</form>
</tr>
<?php }?>   
<tr>
  <td colspan="25" align="center" bgcolor="#FFFFFF">共计<?=$page_count;?>页 - 当前第<?=$page + 1;?>页
  <?php if (1 < ($page + 1)){?> 	    
  <a style="font-weight: normal;color:#000;" href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=<?=$stype;?>&ok=<?=$ok;?>&page=<?=$page - 1;?>">上一页</a>
  <?php }else{?>上一页<?php }?>|<?php if (($page + 1) < $page_count){?> 	    
  <a style="font-weight: normal;color:#000;" href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=<?=$stype;?>&ok=<?=$ok;?>&page=<?=$page + 1;?>">下一页</a>
  <?php }else{?>下一页<?php }?> 	    
  </td>
</tr>
<?php }?> 
</table>
</body>
</html>
