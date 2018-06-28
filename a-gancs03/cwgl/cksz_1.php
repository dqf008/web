<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('jkkk');
$group = array();
$sql = 'select id,name from k_group order by id asc';
$query = $mydata1_db->query($sql);
while ($rows = $query->fetch()){
	$group[$rows['id']] = $rows['name'];
}

if ($_GET['act'] == 'add'){
	$bankName = trim($_POST['card_bankName']);
	$ID = trim($_POST['card_ID']);
	$userName = trim($_POST['card_userName']);
	$address = trim($_POST['card_address']);
	$groupid = trim($_POST['card_group']);
	include_once '../../cache/bank.php';
	$str = '<?php ' . "\r\n";
	$str .= 'unset($bank);' . "\r\n";
	$str .= '$bank = array();' . "\r\n";
	foreach ($bank as $gid => $arr)
	{
		$i = 0;
		foreach ($arr as $k => $card)
		{
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_bankName\']=\'' . $card['card_bankName'] . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_ID\']=\'' . $card['card_ID'] . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_userName\']=\'' . $card['card_userName'] . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_address\']=\'' . $card['card_address'] . '\';' . "\r\n";
			$i++;
		}
		if ($gid == $groupid)
		{
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_bankName\']=\'' . $bankName . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_ID\']=\'' . $ID . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_userName\']=\'' . $userName . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_address\']=\'' . $address . '\';' . "\r\n";
		}
	}
	if (!isset($bank[$groupid]))
	{
		$str .= '$bank[' . $groupid . '][0][\'card_bankName\']=\'' . $bankName . '\';' . "\r\n";
		$str .= '$bank[' . $groupid . '][0][\'card_ID\']=\'' . $ID . '\';' . "\r\n";
		$str .= '$bank[' . $groupid . '][0][\'card_userName\']=\'' . $userName . '\';' . "\r\n";
		$str .= '$bank[' . $groupid . '][0][\'card_address\']=\'' . $address . '\';' . "\r\n";
	}
	if (@!chmod('../../cache', 511))
	{
		message('缓存文件写入失败！请先设 /cache 文件权限为：0777');
	}
	if (!write_file('../../cache/bank.php', $str . '?>'))
	{
		message('缓存文件写入失败！请先设/cache/bank.php文件权限为：0777');
	}
	include_once '../../class/admin.php';
	admin::insert_log($_SESSION['adminid'], '添加入款银行账号：' . $ID);
	message('缓存文件写入成功！');
}else if ($_GET['act'] == 'del'){
	$gid = trim($_GET['gid']);
	$id = trim($_GET['id']);
	include_once '../../cache/bank.php';
	$card_ID = $bank[$gid][$id]['card_ID'];
	unset($bank[$gid][$id]);
	$str = '<?php ' . "\r\n";
	$str .= 'unset($bank);' . "\r\n";
	$str .= '$bank = array();' . "\r\n";
	foreach ($bank as $gid => $arr)
	{
		$i = 0;
		foreach ($arr as $k => $card)
		{
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_bankName\']=\'' . $card['card_bankName'] . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_ID\']=\'' . $card['card_ID'] . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_userName\']=\'' . $card['card_userName'] . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_address\']=\'' . $card['card_address'] . '\';' . "\r\n";
			$i++;
		}
	}
	if (@!chmod('../../cache', 511))
	{
		message('缓存文件写入失败！请先设 /cache 文件权限为：0777');
	}
	if (!write_file('../../cache/bank.php', $str . '?>'))
	{
		message('缓存文件写入失败！请先设/cache/bank.php文件权限为：0777');
	}
	include_once '../../class/admin.php';
	admin::insert_log($_SESSION['adminid'], '删除入款银行账号：' . $card_ID);
	message('缓存文件写入成功！');
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>银行帐号设置</title> 
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
<script language="JavaScript" src="../../js/jquery.js"></script> 
<script language="javascript"> 
function check(){ 
  if($("#card_bankName").val().length < 1){ 
	  $("#card_bankName").focus();
	  return false;
  } 
  if($("#card_ID").val().length < 1){ 
	  $("#card_ID").focus();
	  return false;
  } 
  if($("#card_userName").val().length < 1){ 
	  $("#card_userName").focus();
	  return false;
  } 
  if($("#card_address").val().length < 1){ 
	  $("#card_address").focus();
	  return false;
  } 
  if($("#card_group").val().length < 1){ 
	  return false;
  } 
  return true;
} 
</script> 
</head> 
<body> 
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" >       <tr style="background-color: #EFE" class="t-title"  align="center"> 
	  <td width="15%" height="20"><strong>银行名称</strong></td> 
	  <td width="41%" ><strong>银行卡号</strong></td> 
	  <td width="15%" ><strong>开户名</strong></td> 
	  <td width="24%" ><strong>开户地址</strong></td> 
	  <td width="5%"><strong>操作</strong></td> 
	</tr>
<?php 
include_once '../../cache/bank.php';
foreach ($bank as $gid => $arr){
?>   
<tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;"> 
  <td colspan="5" align="left" bgcolor="#D9D9D9"><strong><?=$group[$gid]?></strong></td> 
</tr>
<?php foreach ($arr as $k => $card){?>   
<tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;"> 
  <td><?=$card['card_bankName']?></td> 
  <td><?=$card['card_ID']?></td> 
  <td><?=$card['card_userName']?></td> 
  <td><?=$card['card_address']?></td> 
  <td><a href="?act=del&gid=<?=$gid?>&id=<?=$k?>" onclick="return confirm('您确定要删除吗?')">删除</a></td> 
</tr>
<?php
	}
}
?> 
</table> 
<br /> 
<form action="?act=add" method="post" name="from1" id="from1" onsubmit="return check();"> 
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" > 
		  <tr align="center"> 
			<td colspan="4" align="left" bgcolor="#D9D9D9">银行卡信息设置</td> 
  </tr> 
		  <tr align="center"> 
			<td width="18%" align="right">银行名称：</td> 
			<td width="82%" colspan="3" align="left"><label> 
			<input name="card_bankName" type="text" id="card_bankName"  style=" width:250px;" value="<?=$temp['card_bankName']?>"/> 
			</label></td> 
		</tr> 
		  <tr align="center"> 
			<td align="right">银行卡号： </td> 
			<td colspan="3" align="left"><input name="card_ID" type="text" id="card_ID" style=" width:250px;" value="<?=$temp['card_ID']?>"/></td> 
  </tr> 
		  <tr align="center"> 
			<td align="right">开户名称：</td> 
			<td colspan="3" align="left"><input name="card_userName" type="text" id="card_userName" style=" width:250px;" value="<?=$temp['card_userName']?>"/></td> 
  </tr> 
		  <tr align="center"> 
			<td align="right">开户地址：</td> 
			<td colspan="3" align="left"><input name="card_address" type="text" id="card_address" style=" width:250px;" value="<?=$temp['card_address']?>"/></td> 
  </tr> 
		  <tr align="center"> 
			<td align="right">所属会员组：</td> 
			<td colspan="3" align="left">
			<select name="card_group" id="card_group">
			<?php
			foreach($group as $k=>$v){
			?>
				<option value="<?=$k?>" <?=$k==$_GET['gid'] ? 'selected' : ''?>><?=$v?></option>
			<?php
			}
			?>
			</select>
			</td> 
  </tr> 
		  <tr align="center"> 
			<td colspan="4" align="right">&nbsp;</td> 
  </tr> 
		  <tr align="center"> 
			<td align="right">&nbsp;</td> 
			<td colspan="3" align="left"> 
			  <input name="submit" type="submit" value="保存" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="cksz.php"><input name="reset" type="button" value="返回" /></a></td> 
  </tr> 
</table> 
</form> 
</body> 
</html>