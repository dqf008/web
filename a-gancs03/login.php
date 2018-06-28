<?php 
session_start();
include_once '../include/config.php';
include_once '../database/mysql.config.php';
include_once "denglu.php";
$username = @($_POST['LoginName']);
$password = @($_POST['LoginPassword']);
$yzm = @($_POST['CheckCode']);
if ($yzm != $_SESSION['randcode']){
	message('验证码错误');
}

$params = array(':login_name' => $username);
$sql = 'select uid,cpsid,cpservice from mydata3_db.sys_admin where login_name=:login_name limit 1';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
if($stmt->rowCount()>0){
	$rows = $stmt->fetch();
	if(isset($rows['cpservice'])&&!empty($rows['cpservice'])){
		$onecode = @($_POST['onecode']);
		$onecode = trim($onecode);

		if (($onecode == '') || (strlen($onecode) < 6)){
			message('请输入6位安全码');
		}
		if ($onecode == $rows['cpsid']){
			message('该安全码最近已被使用，请重新输入。');
		}
		include_once './common/GoogleAuthenticator.class.php';
		$ga = new PHPGangsta_GoogleAuthenticator();
		if($ga->verifyCode($rows['cpservice'], $onecode, 1)){
			$sql = 'update mydata3_db.sys_admin set cpsid=:cpsid where uid=:uid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute(array(
				':cpsid' => $onecode,
				':uid' => $rows['uid'],
			));
		}else{
			message('安全码不正确！如果您遇到问题请联系客服！');
		}
	}
}else{
	message('用户名或密码错误');
}

$_SESSION['inputscode'] = 'y9hp';
$_SESSION['slocation'] = 'E4E5';

include_once '../class/admin.php';
$arr = array();
$temp = admin::login($username, $password);
$arr = explode(',', $temp);

if (0 < $arr[0]){
	admin::insert_log($arr[1], $_SERVER['REMOTE_ADDR'] . '登陆成功');
	$_SESSION['superadmin'] = $username;
	$_SESSION['flag'] = ',01,02,03,04,05,06,07,08,09,10,11,12,13';
	$_SESSION['adminstats'] = '1';
	header('Content-Type: text/html;charset=utf-8');?><script>location.href='main.html';</script><?php exit();
}else if ($arr[1] == 1){
	message('用户名或密码错误');
}else if ($arr[1] == 2){
	message('登陆地址错误，您当前的登陆地址为：' . $arr[2]);
}else if ($arr[1] == 3){
	message('登陆IP错误，您当前的登陆IP为：' . $arr[2]);
}else{
	message('验证失败');
}


function message($value, $url = '')
{
	header('Content-type: text/html;charset=utf-8');
	$js = '<script type="text/javascript" language="javascript">' . "\r\n";
	$js .= 'alert("' . $value . '");' . "\r\n";
	if ($url)
	{
		$js .= 'window.location.href="' . $url . '";' . "\r\n";
	}
	else
	{
		$js .= 'window.history.go(-1);' . "\r\n";
	}
	$js .= '</script>' . "\r\n";
 	echo $js;
	exit();
}
?>