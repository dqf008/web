<?php 
session_start();
header('Content-Type:text/html;charset=utf-8');
include_once 'include/config.php';
website_close();
website_deny();
include_once 'database/mysql.config.php';
include_once 'class/user.php';
include_once 'common/function.php';
include_once 'common/commonfun.php';
$yangzhengma = htmlEncode(strtolower($_POST['zcyzm']));
if ($yangzhengma != $_SESSION['randcode']){
	message('您输入的验证码有误!');
}
$_SESSION['randcode'] = rand(10000, 99999);
$username = htmlEncode($_POST['zcname']);
$params = array(':username' => $username);
$sql = 'select username from k_user where username=:username limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$exist_user = $stmt->fetchColumn();
if ($exist_user){
	message('用户名已经存在!');
}
$ask = htmlEncode($_POST['ask']);
$answer = htmlEncode($_POST['answer']);
$sex = htmlEncode($_POST['zcpwd1']);
$birthday = htmlEncode($_POST['qk_pwd']);

if ($web_site['show_tel'] == 1){
	$mobile = htmlEncode($_POST['zctel']);
}else{
	$mobile = '保密';
}

if ($web_site['show_qq'] == 1){
	$email = htmlEncode($_POST['zcemail']);
}else{
	$email = '';
}

//weiwxin
if ($web_site['show_weixin'] == 1){
    $weixin = htmlEncode($_POST['zcweixin']);
}else{
    $weixin = '';
}

$jsr = htmlEncode($_POST['jsr']);
$is_stop = 0;
$pay_name = htmlEncode($_POST['zcturename']);
$gid = 1;
$logintime = date('Y-m-d H:i:s');
$password = md5($sex);
$qkpwd = md5($birthday);
if (!$username || !$password || !$qkpwd || !$ask || !$answer || !$birthday || !$mobile || !$pay_name){
	message('请填写完整表单!');
}
if ($web_site['allow_samename'] != 1){
	$params = array(':pay_name' => $pay_name);
	$sql = 'select username from k_user where pay_name=:pay_name limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$exist_user = $stmt->fetchColumn();
	if ($exist_user)
	{
		message('该真实姓名已经注册过，请勿重复注册!');
	}
}

if (!preg_match('/^[0-9a-zA-Z]{5,15}$/', $username)){
	message('您在网站的登录帐户，5-15个英文或数字组成');
}

if (!preg_match('/^\\d{6}$/', $birthday)){
	message('请输入6位数字取款密码');
}

$fid = 0;
if($jsr){
	$stmt = $mydata1_db->prepare('select uid from k_user where username=:jsr and is_daili=1 limit 1');
	$stmt->execute(array(':jsr' => $jsr));
	$fid = (int)$stmt->fetch()[0];
}
if($fid==0){
	$host = htmlEncode($_SERVER["HTTP_HOST"]);
	$host = str_replace("www.","",$host);
	$res = $mydata1_db->query('select uid from k_user where is_daili=1 and username=(select dl_username from dlurl where url="'.$host.'" and isok=1 limit 1)');
	$fid = (int)$res->fetch()[0];
}
if($fid!=0){
	$top_uid = $fid;
	setcookie('f', $fid);
}else{
	$top_uid= 0;
}
$isMobile = isMobile()?1:0;
$reg_host = htmlEncode($_SERVER["HTTP_HOST"]);
include_once 'ip.php';
$client_ip = get_client_ip();
if ($web_site['allow_ip'] != 1){
	$params = array(':reg_ip' => $client_ip);
	$sql = 'select username from k_user where reg_ip=:reg_ip limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$exist_user = $stmt->fetchColumn();
	if ($exist_user)
	{
		message('该IP已经注册过，请勿重复注册!');
	}
}
$address = iconv('GB2312', 'UTF-8', convertip($client_ip));
$params = array(':username' => $username, ':password' => $password, ':qk_pwd' => $qkpwd, ':ask' => $ask, ':answer' => $answer, ':sex' => $sex, ':birthday' => $birthday, ':mobile' => $mobile, ':email' => $email, ':client_ip' => $client_ip, ':client_ip2' => $client_ip, ':login_time' => $logintime, ':pay_name' => $pay_name, ':top_uid' => $top_uid, ':agents' => $jsr, ':is_stop' => $is_stop, ':gid' => $gid, ':reg_address' => $address, ':modify_pwd_t' => $logintime,':weixin' =>$weixin, ':reg_mode' => $isMobile, ':reg_host'=>$reg_host);
$sql = 'insert into k_user(username,password,qk_pwd,ask,answer,sex,birthday,mobile,email,reg_ip,login_ip,login_time,pay_name,top_uid,agents,is_stop,gid,lognum,reg_address,modify_pwd_t,weixin,reg_mode,reg_host) values (:username,:password,:qk_pwd,:ask,:answer,:sex,:birthday,:mobile,:email,:client_ip,:client_ip2,:login_time,:pay_name,:top_uid,:agents,:is_stop,:gid,1,:reg_address,:modify_pwd_t,:weixin,:reg_mode,:reg_host)';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$q1 = $stmt->rowCount();
$id = $mydata1_db->lastInsertId();
$time = time();
$params = array(':login_id' => $time . '_' . $id . '_' . $username, ':uid' => $id, ':login_time' => $time, ':www' => $conf_www);
$sql = 'insert into `k_user_login` (`login_id`,`uid`,`login_time`,`is_login`,www) VALUES (:login_id,:uid,:login_time,1,:www)';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$params = array(':uid' => $id, ':username' => $username, ':ip' => $client_ip, ':ip_address' => $address, ':www' => $conf_www);
$sql = 'insert into mydata3_db.history_login (`uid`,`username`,`ip`,`ip_address`,`login_time`,`www`) VALUES (:uid,:username,:ip,:ip_address,now(),:www)';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
if ($q1 == 1){
	$_SESSION['uid'] = $id;
	$_SESSION['username'] = $username;
	$_SESSION['gid'] = $gid;
	$_SESSION['denlu'] = 'one';
	$_SESSION['user_login_id'] = $time . '_' . $id . '_' . $username;
	$_SESSION['password'] = $sex;
	user::msg_add($_SESSION['uid'], $web_site['reg_msg_from'], $web_site['reg_msg_title'], $web_site['reg_msg_msg']);
	//发送邮件
	//require __DIR__ . '/class/email/163.php';
	echo "<script>alert(\"注册成功!\");window.open('/','_top');</script>";
	exit();
}else{
	message('由于网络堵塞，本次注册失败。\\n请您稍候再试，或联系在线客服。');
}
function isMobile(){
	if (isset($_SERVER['HTTP_X_WAP_PROFILE']))	{
		return true;
	}
	if (isset($_SERVER['HTTP_VIA']))
	{
		return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
	}
	if (isset($_SERVER['HTTP_USER_AGENT']))
	{
		$clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
		if (preg_match('/(' . implode('|', $clientkeywords) . ')/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
		{
			return true;
		}
	}
	if (isset($_SERVER['HTTP_ACCEPT']))
	{
		if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && ((strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false) || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
		{
			return true;
		}
	}
	return false;
}
?>