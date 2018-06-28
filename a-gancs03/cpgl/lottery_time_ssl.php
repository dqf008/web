<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('ssgl');
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
if ($_POST['update']){
	$params = array(':qihao' => $qihao, ':kaipan' => '2010-06-01 '.$kaipan, ':fengpan' => '2010-06-01 '.$fengpan, ':id' => $id);
	$mysql = 'update lottery_t_ssl set qihao=:qihao,kaipan=:kaipan,fengpan=:fengpan where id=:id';
	$stmt = $mydata1_db->prepare($mysql);
	$stmt->execute($params) || exit('第' . $qihao . '期修改失败');
	echo "<script>alert('第".$qihao."期修改成功');</script>";
}
$sql = 'select * from lottery_t_ssl order by id asc';
$result = $mydata1_db->query($sql);
$cou = $result->rowCount();
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
		<td colspan="4" align="center" bgcolor="#FFFFFF"><a href="lottery_auto_3d.php">福彩3D</a> - <a href="lottery_auto_pl3.php">体彩排列3</a> - <a href="lottery_auto_ssl.php">上海时时乐</a> - <a href="lottery_auto_kl8.php">北京快乐8</a></td> 
</tr> 
<tr class="m_title"> 
  <td colspan="4" align="center">上海时时乐开盘时间管理【<a href="lottery_auto_ssl.php"><font color="#FF0000">点击进入上海时时乐开奖管理</font></a>】</td> 
</tr> 
<tr class="m_title"> 
  <td align="center">上海时时乐期号</td> 
  <td align="center">开盘时间</td> 
  <td align="center">封盘时间</td> 
  <td align="center">操作</td> 
</tr>
<?php 
if ($cou == 0){
}else{
	while ($row = $result->fetch())
	{
    $row['kaipan'] = date('H:i:s', strtotime($row['kaipan']));
    $row['fengpan'] = date('H:i:s', strtotime($row['fengpan']));
?>   
<tr><form name="FrmSubmit" method="post" action="">  
  <td align="center" bgcolor="#FFFFFF"><input name="qihao" type="text" id="qihao" value="<?=$row['qihao'];?>" maxlength=15 size="15" readonly="readonly"></td> 
  <td align="center" bgcolor="#FFFFFF"><input name="kaipan" type="text" id="kaipan" value="<?=$row['kaipan'];?>" maxlength=19 size="15"></td> 
  <td align="center" bgcolor="#FFFFFF"><input name="fengpan" type="text" id="fengpan" value="<?=$row['fengpan'];?>" maxlength=19 size="15"></td> 
  <td align="center" bgcolor="#FFFFFF"><input class=za_button name="update" type="Submit" id="update" value="更新"><input name="id" type="hidden" id="id" value="<?=$row['id'];?>"></td> 
</form></tr>
<?php }
}?> 
</table> 
</body> 
</html> 
