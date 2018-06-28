<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
$query = $mydata1_db->query('SELECT `value` FROM `k_money_fs` WHERE `uid`=0');
if($query->rowCount()>0){
    $czfx = $query->fetch();
    $czfx = unserialize($czfx['value']);
}else{
    $czfx = array();
    $mydata1_db->query('INSERT INTO `k_money_fs` (`uid`, `value`) VALUES (0, \''.serialize($czfx).'\')');
}
check_quanxian('xtgl');
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>充值返现</TITLE> 
<link rel="stylesheet" href="Images/CssAdmin.css"> 
<style type="text/css"> 
<STYLE> 
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
.t-title{background:url(../images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
</STYLE> 
</HEAD> 

<body> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2">充值返现：设置会员组充值返现</span></font></td> 
</tr> 
<tr> 
  <td height="24" align="left" nowrap bgcolor="#FFFFFF">&nbsp;&nbsp;<a href="../hygl/group.php">会员组管理</a> | <a href="../hygl/group_edit.php">新增会员组</a></td> 
</tr> 
</table> 

<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
  
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"> 
   
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" >       
	<tr style="background-color: #EFE" class="t-title"  align="center"> 
	  <td width="7%"  height="20"><strong>编号</strong></td> 
	  <td width="47%" ><strong>用户组名称</strong></td> 
      <td width="13%" ><strong>返现</strong></td> 
	  <td width="13%" ><strong>比例</strong></td> 
	  <td width="20%" ><strong>操作</strong></td> 
	</tr>
	<?php 
	$sql = 'select id,name from `k_group` order by id asc';
	$query = $mydata1_db->query($sql);
	while ($rows = $query->fetch())
	{
	?>
          <tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;"> 
			<td><?php echo $rows['id']; ?></td> 
            <td><?php echo $rows['name']; ?></td> 
			<td><?php echo isset($czfx[$rows['id']])&&isset($czfx[$rows['id']]['enabled'])?'启用':'关闭'; ?></td> 
			<td><?php echo sprintf('%1.2f', isset($czfx[$rows['id']])?$czfx[$rows['id']]['proportion']/100:0); ?>%</td> 
			<td><a href="czfx_edit.php?id=<?=$rows['id']?>">返现设置</a></td> 
		</tr>
	<?php }?>     
	</table> 
  </td> 
</tr> 
</table> 
</body> 
</html>