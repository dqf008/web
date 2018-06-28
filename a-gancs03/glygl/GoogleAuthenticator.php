<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/GoogleAuthenticator.class.php';
if(isset($_GET['id'])){
	check_quanxian('glygl');
	$uid = intval($_GET['id']);
	$superuser = true;
}else{
	$uid = intval($_SESSION['adminid']);
	$superuser = false;
}
$params = array(':uid' => $uid);
$sql = 'select uid,login_name,cpsid,cpservice from mydata3_db.sys_admin where uid=:uid limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetch();
$ga = new PHPGangsta_GoogleAuthenticator();
if (@($_GET['action']) == 'save'){
	if(isset($rows['cpservice'])&&!empty($rows['cpservice'])){
		if($_SESSION['a-gan'] == '1'){
			$params = array(':uid' => $uid);
			$sql = 'update mydata3_db.sys_admin set cpservice=NULL, cpsid=0 where uid=:uid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			message('解绑成功', $superuser?'?id='.$uid:'?');
		}else{
			if($rows['cpsid']==$_POST['password']){
				message('该安全码最近已被使用，请重新输入。');
			}else if(($superuser&&$_POST['password']=='unbind')||$ga->verifyCode($rows['cpservice'], $_POST['password'], 1)){
				$params = array(':uid' => $uid);
				$sql = 'update mydata3_db.sys_admin set cpservice=NULL, cpsid=0 where uid=:uid';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				include_once '../../class/admin.php';
				admin::insert_log($_SESSION['adminid'], ($_POST['password']=='unbind'?'强行':'').'解绑了管理员[' . $rows['login_name'] . ']的 Google 身份验证器');
				message('解绑成功', $superuser?'?id='.$uid:'?');
			}else{
				message('解绑失败，请重新输入安全码。', $superuser?'?id='.$uid:'?');
			}
		}
	}else{
		$secret = $_SESSION['secret_'.$uid];
		if($ga->verifyCode($secret, $_POST['password'], 1)){
			$params = array(':cpservice' => $secret, ':cpsid' => $_POST['password'], ':uid' => $uid);
			$sql = 'update mydata3_db.sys_admin set cpservice=:cpservice, cpsid=:cpsid where uid=:uid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			include_once '../../class/admin.php';
			admin::insert_log($_SESSION['adminid'], '为管理员[' . $rows['login_name'] . ']绑定了 Google 身份验证器');
			unset($_SESSION['secret_'.$uid]);
			message('绑定成功', $superuser?'?id='.$uid:'?');
		}else{
			message('验证失败，请重新输入安全码。', $superuser?'?id='.$uid:'?');
		}
	}
}
?>
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>Google 身份验证器</TITLE> 
<link rel="stylesheet" href="Images/CssAdmin.css"/> 
<style type="text/css"> 
<STYLE> 
BODY { 
SCROLLBAR-FACE-COLOR: rgb(255,204,0);
SCROLLBAR-3DLIGHT-COLOR: rgb(255,207,116);
SCROLLBAR-DARKSHADOW-COLOR: rgb(255,227,163);
SCROLLBAR-BASE-COLOR: rgb(255,217,93) 
} 
.STYLE1 {font-size: 10px} 
.STYLE2 {font-size: 12px} 
body {  	  margin: 0px;} 
td{font:13px/120% "宋体";padding:3px;} 
a{color:#FFA93E;} 
.t-title{background:url(/super/images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
</STYLE> 
</HEAD> 

<body>
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" > 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2">管理员管理：Google 身份验证器</span></font></td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><form action="<?=$_SERVER['PHP_SELF'];?>?action=save<?php if($superuser){ ?>&amp;id=<?=$rows['uid'];}?>" method="post" name="form1"> 
	<p>&nbsp;</p> 
	<table width="661" border="1" align="center" bordercolor="#333333"  style="border-collapse:collapse;color:#000;"> 
<tr> 
  <td bgcolor="#F0FFFF">管理员</td> 
  <td><?=$rows['login_name'];?></td> 
</tr> 
<?php if(isset($rows['cpservice'])&&!empty($rows['cpservice'])){?>
<tr> 
  <td width="172" bgcolor="#F0FFFF">验证器</td> 
  <td width="473" style="color:red">已绑定</td> 
</tr> 
<tr> 
  <td width="172" bgcolor="#F0FFFF">安全码</td> 
  <td width="473"><input id="password" type="text" name="password" value=""/><?php if($superuser){ ?> <span style="color:red">强行解绑请输入unbind</span><?php } ?></td> 
</tr> 
  <tr> 
  <td bgcolor="#F0FFFF">操作</td> 
  <td><input name="unbind" type="submit" id="unbind" value="解绑"/></td> 
</tr> 
<?php
}else{
	if(!isset($_SESSION['secret_'.$uid])){
		$secret = $ga->createSecret();
		$_SESSION['secret_'.$uid] = $secret;
	}else{
		$secret = $_SESSION['secret_'.$uid];
	}
?>
<tr> 
  <td bgcolor="#F0FFFF">二维码</td> 
  <td><img src="qrcode.php?s=<?php echo urlencode('otpauth://totp/'.urlencode($web_site['web_name'].'-'.$rows['login_name']).'?secret='.$secret); ?>" width="200" /><br /><a href="qrcode.php?s=<?php echo urlencode('otpauth://totp/'.urlencode($web_site['web_name'].'-'.$rows['login_name']).'?secret='.$secret); ?>" target="_blank">（新窗口打开二维码）</a></td> 
</tr> 
<tr> 
  <td width="172" bgcolor="#F0FFFF">密钥</td> 
  <td width="473"><?php echo $secret; ?></td> 
</tr> 
<tr> 
  <td width="172" bgcolor="#F0FFFF">安全码</td> 
  <td width="473"><input id="password" type="text" name="password" value=""/></td> 
</tr> 
  <tr> 
  <td bgcolor="#F0FFFF">操作</td> 
  <td><input name="bind" type="submit" id="bind" value="绑定"/></td> 
</tr> 
<?php } ?>
  <tr> 
  <td bgcolor="#F0FFFF">使用提示</td> 
  <td>请在<a href="https://itunes.apple.com/cn/app/google-authenticator/id388497605?mt=8" target="_blank">App Store（iOS）</a>、<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&amp;hl=zh_CN" target="_blank">Google Play（Android）</a>或者<a href="http://soft.shouji.com.cn/down/22099.html" target="_blank">其他应用商店</a>搜索<span style="color:red">Google Authenticator</span>安装并扫描二维码，如果不能扫描二维码请手动输入密钥，类型选择<span style="color:red">基于时间</span>。<br />您也可以使用<a href="https://www.google.com/chrome/browser/desktop/index.html" target="_blank">Google Chrome浏览器</a>的<a href="https://chrome.google.com/webstore/detail/authenticator/bhghoamapcdpbohphigoooaddinpkbai?hl=zh-CN" target="_blank">身份验证器</a>扩展代替手机APP程序。</td> 
</tr> 
</table> 
</form></td> 
</tr> 
</table> 
</body> 
</html>