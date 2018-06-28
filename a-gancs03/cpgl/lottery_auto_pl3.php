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
$tm = $_REQUEST['tm'];
if ($_REQUEST['save'] == 'add'){
	$params = array(':qihao' => $qihao, ':kaipan' => $kaipan, ':fengpan' => $fengpan);
	$mysql = 'insert into lottery_k_pl3 set qihao=:qihao,kaipan=:kaipan,fengpan=:fengpan';
	$stmt = $mydata1_db->prepare($mysql);
	$stmt->execute($params) || exit('第' . $qihao . '期添加失败');
	echo "<script>alert('添加成功！');</script>";
}

if ($_POST['update']){
	$params = array(':qihao' => $qihao, ':kaipan' => $kaipan, ':fengpan' => $fengpan, ':hm1' => $hm1, ':hm2' => $hm2, ':hm3' => $hm3, ':id' => $id);
	$mysql = 'update lottery_k_pl3 set qihao=:qihao,kaipan=:kaipan,fengpan=:fengpan,hm1=:hm1,hm2=:hm2,hm3=:hm3 where id=:id';
	$stmt = $mydata1_db->prepare($mysql);
	$stmt->execute($params) || exit('第' . $qihao . '期修改失败');
	echo "<script>alert('保存成功！');</script>";
}

if ($_POST['delete']){
	$params = array(':id' => $id);
	$mysql = 'delete from lottery_k_pl3 where id=:id';
	$stmt = $mydata1_db->prepare($mysql);
	$stmt->execute($params);
	echo "<script>alert('删除成功！');</script>";
}

if ($_POST['jsreset']){
	$qihao = $_POST['qihao'];
	$atype = 'pl3';
	echo "<script>window.location.href='js_reset.php?action=jsreset&t=1&atype=".$atype."&qihao=".$qihao."';</script>";
}

$params = array();
$qihao = trim($_REQUEST['qihao']);
if ($qihao != ''){
	$params[':qihao'] = $qihao;
	$sqlwhere = ' where qihao=:qihao ';
}else{
	$sqlwhere = '';
}
$sql = 'select * from lottery_k_pl3 ' . $sqlwhere . ' order by id desc';
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
		<td colspan="4" align="center">体彩排列3期数添加</td>
	  </tr>
	  <tr class="m_title">
		<td align="center">排列3期号</td>
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
  <td colspan="8" align="center">体彩排列3开奖管理</td>
</tr>
<tr class="m_title">
  <td align="center">排列3期号</td>
  <td align="center">开盘时间</td>
  <td align="center">封盘时间</td>
  <td align="center">百位</td>
  <td align="center">十位</td>
  <td align="center">个位</td>
  <td align="center">操作</td>
  <td align="center">开奖</td>
</tr>
<?php 
if ($cou == 0){

}else{
	while ($row = $result->fetch()){
?>   
<tr>
<form name="FrmSubmit" method="post" action="?">
  <td align="center" bgcolor="#FFFFFF"><input name="qihao" type="text" id="qihao" value="<?=$row['qihao'];?>" maxlength=7 size="7" readonly="readonly"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="kaipan" type="text" id="kaipan" value="<?=$row['kaipan'];?>" size="15"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="fengpan" type="text" id="fengpan" value="<?=$row['fengpan'];?>" size="15"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm1" type="text" id="hm1" value="<?=$row['hm1'];?>" maxlength=1 size="2"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm2" type="text" id="hm2" value="<?=$row['hm2'];?>" maxlength=1 size="2"></td>
  <td align="center" bgcolor="#FFFFFF"><input name="hm3" type="text" id="hm3" value="<?=$row['hm3'];?>" maxlength=1 size="2"></td>
  <td align="center" bgcolor="#FFFFFF"><input class=za_button name="update" type="Submit" id="update" value="保存">
  <input class=za_button name="delete" type="Submit" id="delete" value="删除" onClick="return confirm('是否确定删除该记录？');">
  <input name="id" type="hidden" id="id" value="<?=$row['id'];?>">
  <input class=za_button name="jsreset" type="Submit" id="jsreset" value="重算" onClick="return confirm('是否重算，期号：<?=$row['qihao'];?>？');">
  </td>
  <td align="center" bgcolor="#FFFFFF">
  <?php if ($row['ok'] == 0){?> 
  <a href="../cj/lottery/pl3_auto.php?qihao=<?=$row['qihao'];?>&t=1" onClick="return confirm('请确认您已经核对完开奖结果并已经保存？\r\n如未保存请先保存开奖结果，以免结算出错！\r\n如已经保存请点击确定进行结算。');"><font color="#FF0000">点击开奖</font></a>
  <?php }else{?> 
  <font color="#0000FF">已开奖</font>
  <?php }?> 
  </td>
</form>
</tr>
<?php }?>   
<tr>
  <td colspan="8" align="center" bgcolor="#FFFFFF">
  共计<?=$page_count;?>页 - 当前第<?=$page + 1;?>页
  <?php if (1 < ($page + 1)){?> 	    
  <a style="font-weight: normal;color:#000;" href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=<?=$stype;?>&ok=<?=$ok;?>&langx=<?=$langx;?>&lv=<?=$lv;?>&page=<?=$page - 1;?>">上一页</a>
  <?php }else{?>上一页<?php }?>|<?php if (($page + 1) < $page_count){?><a style="font-weight: normal;color:#000;" href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=<?=$stype;?>&ok=<?=$ok;?>&page=<?=$page + 1;?>">下一页</a><?php }else{?>下一页<?php }?> 	    
  </td>
</tr>
<?php }?> 
</table>
</body>
</html>
