<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cpgl');
check_quanxian('cppl');
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
$odds = $_REQUEST['odds'];
if ($_POST['update']){
	$params = array(':odds' => $odds, ':id' => $id);
	$mysql = 'update lottery_odds set odds=:odds where id=:id';
	$stmt = $mydata1_db->prepare($mysql);
	$stmt->execute($params);
	echo "<script>alert('更新成功！');</script>";
}
$lottery = array(
    '3d' => '福彩3D',
    'pl3' => '体彩排列3',
    'ssl' => '上海时时乐',
    'kl8' => '北京快乐8',
    'qxc' => '七星彩',
//    'ffqxc' => '分分七星彩',
//    'wfqxc' => '五分七星彩',
    'pcdd' => 'PC蛋蛋',
//    'ffpcdd' => '分分PC蛋蛋'
);
(empty($stype)||!isset($lottery[$stype]))&&$stype = key($lottery);
$sql = 'select * from lottery_odds where class1=:class1 order by id asc';
$result = $mydata1_db->prepare($sql);
$result->execute(array(':class1' => $stype));
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
		<td colspan="4" align="center" bgcolor="#FFFFFF"><?php foreach($lottery as $key=>$val){ ?><a href="lottery_odds_kl8.php?stype=<?php echo $key; ?>"><?php echo $val; ?></a>-<?php } ?></td>
</tr> 
<tr class="m_title"> 
  <td colspan="4" align="center"><?php echo $lottery[$stype]; ?> 赔率管理</td> 
</tr> 
<tr class="m_title"> 
  <td align="center">玩法分类</td> 
  <td align="center">玩法内容</td>
  <td align="center">当前赔率</td> 
  <td align="center">操作</td> 
</tr>
<?php 
if ($cou == 0){

}else{
	while ($row = $result->fetch())
	{
?>
 <tr><form name="FrmSubmit" method="post" action="?stype=<?=$stype;?>">  
  <td align="center" bgcolor="#FFFFFF"><?=$row['class2'];?></td> 
  <td align="center" bgcolor="#FFFFFF"><?=$row['class3'];?></td> 
  <td align="center" bgcolor="#FFFFFF"><input name="odds" type="text" id="odds" value="<?=$row['odds'];?>" size="10"></td> 
  <td align="center" bgcolor="#FFFFFF"><input class=za_button name="update" type="Submit" id="update" value="更新"><input name="id" type="hidden" id="id" value="<?=$row['id'];?>"></td> 
</form></tr>
<?php }
}?> 
</table> 
</body> 
</html> 
