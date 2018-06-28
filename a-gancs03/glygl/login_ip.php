<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('glygl');
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>登陆IP列表页面</title> 
</head> 

<style type="text/css"> 
<STYLE> 
BODY { 
SCROLLBAR-FACE-COLOR: rgb(255,204,0);
SCROLLBAR-3DLIGHT-COLOR: rgb(255,207,116);
SCROLLBAR-DARKSHADOW-COLOR: rgb(255,227,163);
SCROLLBAR-BASE-COLOR: rgb(255,217,93) 
} 
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
<script language="javascript" src="../../js/jquery.js"></script> 
<script> 
function check(){ 
  if($("#ip").val()=="" && $("#username").val()==""){ 
	  alert("登陆IP 和 会员名称 至少要填一样");
	  return false;
  } 
  return true;
} 
</script> 
<body> 
<form id="form1" name="form1" method="get" action="login_ip.php" onsubmit="return check();"> 
<table width="100%" border="0"> 
<tr> 
  <td width="17%">请您输入要查询的IP地址：</td> 
  <td width="83%"><textarea name="ip" cols="80" rows="2" id="ip"><?=$_GET['ip']);?></textarea> 
	多个IP可以用 , 隔开</td> 
</tr> 
<tr> 
  <td>请您输入要查询的管理员名称：</td> 
  <td><label> 
	<textarea name="username" cols="80" rows="2" id="username"><?=$_GET['username']);?></textarea> 
  多个会员可以用 , 隔开</label></td> 
</tr> 
<tr> 
  <td>&nbsp;</td> 
  <td><input type="submit" name="Submit" value="查询" /></td> 
</tr> 
</table> 
</form> 
<br> 
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" >       <tr style="background-color: #EFE" class="t-title"  align="center"> 
  <td width="29%"><strong>IP地址</strong></td> 
  <td width="26%"><strong>登陆时间</strong></td> 
  <td width="22%"><strong>管理员名称</strong></td> 
  <td width="23%"><strong>登陆网址</strong></td> 
</tr>
<?php 
if (isset($_GET['ip']) || isset($_GET['username'])){
$ip = '';
$un = '';
$where = '';
$params = array();
$ips = trim(trim($_GET['ip'], ','));
if ($ips){
	$arr_ip = explode(',', $ips);
	$i = 0;
	$arr_count = count($arr_ip);
	foreach ($arr_ip as $k => $v){
		$i++;
		$params[':ip_'.$i] = $v;
		if ($i == 1){
			$where .= ' and (ip=:ip_' . $i;
		}else{
			$where .= ' or ip=:ip_' . $i;
		}
		
		if ($i == $arr_count){
			$where .= ')';
		}
	}
}
$usernames = trim(trim($_GET['username'], ','));
if ($usernames){
	$arr_un = explode(',', $usernames);
	$i = 0;
	$arr_count = count($arr_un);
	foreach ($arr_un as $k => $v){
		$i++;
		$params[':username_' . $i] = $v;
		if ($i == 1){
			$where .= ' and (username=:username_' . $i;
		}else{
			$where .= ' or username=:username_' . $i;
		}
		
		if ($i == $arr_count){
			$where .= ')';
		}
	}
}
$sql = 'SELECT ip,uid,username,ip_address,login_time,www FROM mydata3_db.admin_login where 1=1 ' . $where . ' order by login_time desc limit 100';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
while ($row = $stmt->fetch())
{
?>
  <tr onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;"> 
  <td align="center"><?=$row['ip'];?><br/><?=$row['ip_address'];?></td> 
  <td align="center"><?=$row['login_time'];?></td> 
  <td align="center"><?=$row['username'];?></td> 
  <td align="center"><?=$row['www'];?></td> 
</tr>
<?php }
}?> 
</table> 
</body> 
</html>