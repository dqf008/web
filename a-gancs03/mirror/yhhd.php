<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('xtgl');
$id = intval($_GET['id']);
$pre = 'mirror-';
$code = 'promotions';
if ($id <= 0){
	$id = 1;
}

if (!empty($_GET['action']) && $_GET['action'] == 'del'){
	$params = array(':code' => $pre.$code, ':id' => $_GET['id']);
	$sql = 'DELETE FROM `webinfo` WHERE  `id`=:id AND `code`=:code';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
    message('活动删除成功!');
}
$hotList = array();
$sql = 'select * from webinfo where code="'.$pre.$code.'" order by id desc';
$query = $mydata1_db->query($sql);
while($rows = $query->fetch()){
    $rows['content'] = unserialize($rows['content']);
	$rows['sort'] = $rows['content'][2];
    $hotList[] = $rows;
}
usort($hotList, function($a, $b){
  $a = $a['sort'];
  $b = $b['sort'];
  if ($a == $b) return 0;
  return ($a > $b) ? -1 : 1;
});
?>
 
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<title>优惠活动列表</title> 
<style type="text/css"> 
.STYLE2 {font-size: 12px} 
body { 
  margin: 0px;
} 
td{font:13px/120% "宋体";padding:3px;} 
a{ 
  color:#F37605;
  text-decoration: none;
} 
.t-title{background:url(/super/images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
</style> 
</head> 

<body> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
	<tr> 
	  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2">优惠活动管理</span></font></td> 
	</tr> 
	<tr> 
	  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><A href="yhhd_add.php" >新增优惠活动</A></td> 
	</tr> 
</table> 
<br>  
	<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;">
		<tr style="background-color:#CCCCCC;" align="center"> 
		  <td height="20" align="center" width="100"><strong>当前排序</strong></td> 
		  <td align="center"><strong>优惠活动</strong></td> 
		  <td align="center" width="200"><strong>操作</strong></td> 
		</tr>
	<?php foreach($hotList as $rs):?>   
         <tr onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;"> 
            <td height="20" align="center"><a href="yhhd_add.php?id=<?=$rs['id']?>"><?=$rs['sort']?></a></td> 
            <td height="20" align="center"><a href="yhhd_add.php?id=<?=$rs['id']?>"><?=$rs['title']?></a></td> 
            <td align="center">
				<a href="yhhd_add.php?id=<?=$rs['id']?>">编辑</a> |  
				<a onClick="javascript:return confirm('确定删除');" href="yhhd.php?id=<?=$rs['id']?>&action=del">删除</a>
			</td> 
        </tr>
	<?php endforeach;?>    
	</table> 
</body> 
</html>