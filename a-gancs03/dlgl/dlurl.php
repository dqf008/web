<?php
include_once("../common/login_check.php");
check_quanxian("xxgl");
include_once ("../../database/mysql.config.php");
include_once("../../include/newpage.php");

$id	=	0;
if($_GET['id'] > 0){
	$id	=	$_GET['id'];
}

$url	=	$_POST["url"];
$murl = '';
if($url){
	$murl = $url;
	if(!filter_var($url, FILTER_VALIDATE_IP)){//判断是否为IP地址
		$arr = explode('.',$url); //用 . 号截取url分割
		if(sizeof($arr)>2){//有前缀域名
			$ms = "";
			for($i=1;$i<sizeof($arr);$i++){
				$ms .= $arr[$i].".";
			}
			$murl = rtrim($ms,".");
		}
	}
}

if($_GET["action"]=="add" && $id==0){ 
	$dl_username		=	$_POST["dl_username"];
	
	$isok	=	$_POST["isok"];
	$params =   array(':dl_username'=>$dl_username);
	$sql    = 'select uid from k_user where username=:dl_username and is_daili=1';
	$stmt   =  $mydata1_db->prepare($sql);
	$stmt   ->  execute($params);
	$tcou   = $stmt->rowCount();
	if($tcou){
		$params =   array(':url'=>$murl);
		$sql	=	'select url from dlurl where url like \'%:murl\' limit 1';
		$stmt   =  $mydata1_db->prepare($sql);
		$stmt   ->  execute($params);
		$rs		=	$stmt->fetch();

		if(!$rs['url']){
			$params = array(':dl_username'=>$dl_username,':url'=>$url,':isok'=>$isok);
			$sql    = 'insert into dlurl(dl_username,url,isok) values (:dl_username,:url,:isok)';
			$stmt   = $mydata1_db->prepare($sql);
			$stmt   -> execute($params);
		}else{
			echo "<script>alert('该域名已经被设置！');</script>";
		}
	}else{
		echo "<script>alert('该代理不存在！');</script>";
	}
	//echo $sql;exit;
	
}elseif($_GET["action"]=="edit" && $id>0){
	$dl_username		=	$_POST["dl_username"];
	$isok	=	$_POST["isok"];
	$params =   array(':dl_username'=>$dl_username);
	$sql    = 'select uid from k_user where username=:dl_username and is_daili=1';
	$stmt   =  $mydata1_db->prepare($sql);
	$stmt   ->  execute($params);
	$tcou   = $stmt->rowCount();
	if($tcou){
		$params =   array(':url'=>'%'.$murl,':id'=>$id);
		$sql	=	'select url from dlurl where url like :url and id<>:id limit 1';
		$stmt   =  $mydata1_db->prepare($sql);
		$stmt   ->  execute($params);
		$rs		=	$stmt->fetch();
		if(!$rs['url']){
			$params = array(':dl_username'=>$dl_username,':url'=>trim($url),':isok'=>$isok,':id'=>$id);
			$sql	= 'update dlurl set dl_username=:dl_username,url=:url,isok=:isok where id=:id';
			$stmt   = $mydata1_db->prepare($sql);
			$stmt   -> execute($params);
		}else{
			echo "<script>alert('该域名已经被设置！');</script>";
		}
	}else{
		echo "<script>alert('该代理不存在！');</script>";
	}
} elseif ($_GET["action"] == "del" && $id > 0) {
	$params =   array(':id'=>$id);
    $sql	=	'delete from dlurl where id=:id';
	$stmt   = $mydata1_db->prepare($sql);
	$stmt   -> execute($params);
}
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
<TITLE>代理域名管理</TITLE>
<script language="javascript" src="/js/jquery.js"></script>
<script language="javascript">
function check_submit(){
	if($("#dl_username").val()==""){
		alert("请填写代理账号");
		$("#dl_username").focus();
		return false;
	}
	if($("#url").val()==""){
		alert("请填写独立域名");
		$("#end_time").focus();
		return false;
	}
	return true;
}
</script>
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
a{color:#FFA93E;text-decoration: none;}
.t-title{background:url(/super/images/06.gif);height:24px;}
.t-tilte td{font-weight:800;}
.STYLE3 {color: #339900}
.STYLE4 {color: #FF0000}
</STYLE>
</HEAD>

<body>
<table width="100%" align="center"  id=editProduct   idth="100%" >
  <tr>
    <td height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2">代理独立域名管理：</span></font></td>
  </tr>
  <tr>
    <td height="24" align="center" nowrap bgcolor="#FFFFFF">
    <form name="form1" onSubmit="return check_submit();" method="post" action="dlurl.php?id=<?=$id?>&action=<?=$id>0 ? 'edit' : 'add'?>">
<?php
if($id>0 && !isset($_GET['action'])){
	$sql	=	"select * from dlurl where id=$id limit 1";
	$query	=	$mydata1_db->query($sql);
	$rs		=	$query->fetch();
}
?>
    <table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse; color: #225d9c;" id=editProduct   idth="100%" >
  <tr>
    <td align="right">代理账号：</td>
    <td colspan="4"  align="left"><input name="dl_username" id="dl_username" type="text"  size="13" value="<?=@$rs['dl_username']?>"/>&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;该代理必须真实存在，否则无效</td>
  </tr>
  <tr>
    <td width="100" align="right">代理域名：</td>
    <td  align="left"><input name="url" id="url" type="text" value="<?=@$rs['url']?>"  size="25" />&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;1、如：“xxxxx.com”包括该域名下面的所有二级域名;&nbsp;&nbsp;2、多个域名,请单独设置;&nbsp;&nbsp;3、域名不能重复</td>
  </tr>
  <tr>
    <td width="100" align="right">是否启用：</td>
    <td  align="left"><input name="isok" type="radio" value="1" <?=$rs['isok']==1 ? 'checked' : ''?><?=!isset($rs['isok']) ? 'checked' : ''?>>
      <span class="STYLE3">启用</span>&nbsp;&nbsp;
      <input type="radio" name="isok" value="0" <?=(isset($rs['isok']) && $rs['isok']==0) ? 'checked' : ''?>>
      <span class="STYLE4">不启用</span>
	</td>
	
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="4" align="left"><input name="submit" type="submit" value="设置"/></td>
  </tr>
</table>  
    </form>
</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"><tr><td ><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td height="24" nowrap bgcolor="#FFFFFF"><table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse; color: #225d9c;" id=editProduct   idth="100%" >   
            <tr style="background-color: #EFE">
              <td width="100" align="center"><strong>代理帐号</strong></td>
        <td width="300" height="20" align="center"><strong>代理独立域名</strong></td>
		<td width="86" height="20" align="center"><strong>状态</strong></td>
        <td width="46" align="center"><strong>编辑</strong></td>
        <td width="46" align="center"><strong>删除</strong></td>
		<td></td>
      </tr>
<?php

	$sql	=	"select * from dlurl order by id desc";
	$query	=	$mydata1_db->query($sql);
	$time	=	time();
	while($rows = $query->fetch()){
		$endtime	=	strtotime($rows['end_time']);
?>
      <tr onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;">
        <td align="center" valign="middle"><?=$rows["dl_username"]?></td>
        <td height="20" align="center" valign="middle"><?=$rows["url"]?></td>
        <td align="center"><?=$rows['isok']==0 ? '<span class="STYLE4">不启用</span>' : '<span class="STYLE3">启用</span>'?></td>
        <td align="center"><a href="dlurl.php?id=<?=$rows["Id"]?>">编辑</a></td>
        <td align="center"><a href="dlurl.php?id=<?=$rows["Id"]?>&action=del" onClick="return confirm('您确定要删除这条代理设置吗？');">删除</a></td>
		<td></td>
      </tr>
<?php
	}
?>
    </table></td>
  </tr>
  
</table></td></tr>
</table>
</body>
</html>
 