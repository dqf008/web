<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('glygl');
if(isset($_GET['save'])){
	$path = '../../cache/pwd.php';
	$pwd = file_get_contents($path);
	$pwd || $pwd = '123456';
	$old_pwd = $_GET['old_pwd'];
	$new_pwd = $_GET['new_pwd'];
	if($pwd != $old_pwd) die('1');
	file_put_contents('../../cache/pwd.php', $new_pwd);
	die('0');
}
?>

<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>用户列表</TITLE> 
<!-- 引入样式 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/element-ui@2.4.1/lib/theme-chalk/index.css">
<!-- 先引入 Vue -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.min.js"></script>
<!-- 引入组件库 -->
<script src="https://cdn.jsdelivr.net/npm/element-ui@2.4.1/lib/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
<script type="text/javascript" src="/skin/layer/layer.js"></script>
<style type="text/css"> 
<style> 
body { 
SCROLLBAR-FACE-COLOR: rgb(255,204,0);
SCROLLBAR-3DLIGHT-COLOR: rgb(255,207,116);
SCROLLBAR-DARKSHADOW-COLOR: rgb(255,227,163);
SCROLLBAR-BASE-COLOR: rgb(255,217,93) 
} 
.STYLE2 {font-size: 12px} 

* { font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;}
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
.t-title{background:url(/super/images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
#main {
	font-weight: bold;
	font-size: 24px
}
#main input {
		border: 1px solid #CCC;
		height: 30px;
		font-weight: bold;
		font-size: 16px;
		padding-left: 10px;
		width: 300px
	}
}
</STYLE> 
</HEAD> 

<body> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
	<tr> 
		<td height="24" nowrap background="../images/06.gif" colspan="2">
			<font >&nbsp;<span class="STYLE2">管理员管理：系统管理员管理</span></font>
		</td> 
	</tr> 
	<tr> 
		<td height="24" align="center" nowrap bgcolor="#FFFFFF"><A href="adduser.php" >新增用户</A></td> 
		<td height="24" align="center" nowrap bgcolor="#FFFFFF"><a id="setPwd" href="javascript:void(0);">二级密码设置</a></td>
	</tr> 
</table> 
<div style="display:none" id="edit">	
	<div style="padding:10px 70px;" id="main">
		<p style="color:red">提示：此密码用于查看用户联系方式使用，<br>初始密码为123456</p>
		<p><span style="font-size">原密码：</span><input id="old_pwd" type="password"></p>
		<p><span style="font-size">新密码：</span><input id="new_pwd" type="password"></p>
	</div>
</div>
<br> 
<script>
$(function(){
	$("#setPwd").click(function(){
		layer.open({
			type: 1,
			title: "二级密码设置",
			area: ["600px","380px"],
			shadeClose: true,
			content: $('#edit'),
			btn: ['确认修改', '取消'],
			yes: function (index, layero){
				$.get('?save=true&old_pwd='+$('#old_pwd').val()+'&new_pwd='+$('#new_pwd').val(),function(res){
					if(res == 1){
						alert('密码错误！！！');
						$('#old_pwd').val('');
						$('#new_pwd').val('');
					}else{
						alert('修改成功');
						$('#old_pwd').val('');
						$('#new_pwd').val('');
						layer.close(index)
					}
				});
			}
		});
	});
});
</script>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"> 
   
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;">
	<tr style="font-weight:bold !important; background-color:#CCC;text-align:center;">
	  <td width="176" height="20" align="center">IP限制/登陆名/地区限制</td> 
	  <td width="56">用户名</td> 
	  <td width="357">权限描述</td> 
	  <td width="126">在线状态</td> 
	  <td width="206">登陆IP</td> 
	  <td width="186">操作</td> 
	</tr>
<?php 
include_once '../../class/admin.php';
$sql = 'select * from mydata3_db.sys_admin order by uid desc';
$query = $mydata1_db->query($sql);
while ($rows = $query->fetch())
{
?>
         <tr onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;"> 
			<td height="20" align="center"  >
			<?=$rows["ip"] ? $rows["ip"] : '<span style="color:#999999">无限制</span>'?>
			<br />
			<a href="login_ip.php?username=<?=$rows["login_name"]?>"><?=$rows["login_name"]?></a>
			<br />
			<?=$rows["address"] ? $rows["address"] : '<span style="color:#999999">无限制</span>'?>
			</td>
	        <td align="center"><?=$rows["about"]?></td>
			<td>
<?php
	$temp_i=0;
	foreach($quanxian as $t){
		$temp_i++;
		if(strpos($rows["quanxian"],$t['en'])) echo $t["cn"].",";
        if($temp_i%5==0) echo "<br />";
	}
	 
?> 
            </td> 
			<td align="center">
			<?=$rows['is_login']==1 ? '<span style="color:#FF00FF">在线</span>' : '<span style="color:#999999">离线</span>';?>
			<br />
			<span style="color:#999999"><?=$rows['www'];?></span></td> 
			<td  align="center"><?=$rows['login_ip'];?><br /><?=$rows['login_address'];?></td> 
			<td align="center"><A href="user_edit.php?id=<?=$rows['uid'];?>">编辑</a> |  
			  <A onClick="javascript:return confirm('确定踢线');" href="userdel.php?id=<?=$rows['uid'];?>&login_name=<?=$rows['login_name'];?>">踢线</a> |  
			  <A href="set_pwd.php?id=<?=$rows['uid'];?>">设置密码</a> |  
			  <A href="GoogleAuthenticator.php?id=<?=$rows['uid'];?>">验证器管理</a> |  
			  <A onClick="javascript:return confirm('确定删除');" href="userdel.php?id=<?=$rows['uid'];?>&action=del">删除</a></td> 
		</tr>
<?php }?>     
	</table> 
  </td> 
</tr> 
</table> 
</body> 
</html>