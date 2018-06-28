<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('hygl');
$ask = trim($_POST['ask']);
$why = trim($_POST['why']);
$answer = trim($_POST['answer']);
$mobile = trim($_POST['mobile']);
$email = trim($_POST['email']);
$weixin = trim($_POST['weixin']);
$pay_card = trim($_POST['pay_card']);
$pay_address = trim($_POST['pay_address']);
$pay_num = trim($_POST['pay_num']);
$hf_pay_num = trim($_POST['hf_pay_num']);
$username = trim($_POST['hf_username']);
$gid = trim($_POST['gid']);
$uid = intval(trim($_POST['uid']));
$pass = trim($_POST['pass']);
$pass1 = trim($_POST['pass1']);
$params = array(':ask' => $ask, ':answer' => $answer, ':pay_card' => $pay_card, ':pay_address' => $pay_address, ':pay_num' => $pay_num, ':gid' => $gid, ':why' => $why, ':uid' => $uid);
$sql = 'update k_user set ask=:ask,answer=:answer,pay_card=:pay_card,pay_address=:pay_address,pay_num=:pay_num,gid=:gid,why=:why';
if (($mobile != '') && strpos($_SESSION['quanxian'], 'hylx')){
	$params[':mobile'] = $mobile;
	$sql .= ',mobile=:mobile';
}

if (($email != '') && strpos($_SESSION['quanxian'], 'hylx')){
	$params[':email'] = $email;
	$sql .= ',email=:email';
}
if (($weixin != '') && strpos($_SESSION['quanxian'], 'hylx')){
	$params[':weixin'] = $weixin;
	$sql .= ',weixin=:weixin';
}

if (($pass != '') && strpos($_SESSION['quanxian'], 'hymm')){
	$params[':password'] = md5($pass);
	$params[':sex'] = $pass;
	$sql .= ',password=:password,sex=:sex';
}

if (($pass1 != '') && strpos($_SESSION['quanxian'], 'hymm')){
	$params[':qk_pwd'] = md5($pass1);
	$params[':birthday'] = $pass1;
	$sql .= ',qk_pwd=:qk_pwd,birthday=:birthday';
}
if($_SESSION['a-gan'] == 1 && trim($_POST['pay_name']) != ''){
	$params[':pay_name'] = $_POST['pay_name'];
	$sql .= ',pay_name=:pay_name';
}

$sql .= ' where uid=:uid';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$q1 = $stmt->rowCount();
if ($q1 == 1 ){
	if($_SESSION['a-gan']==1) message('资料已经修改成功!');
	include_once '../../class/admin.php';
	admin::insert_log($_SESSION['adminid'], '管理员：' . $_SESSION['login_name'] . '，修改了会员：' . $_POST['hf_username'] . ' 的资料');
	if ($pay_num != $hf_pay_num){
		$sql = 'select pay_name from k_user where uid=\'' . $uid . '\'';
		$result = $mydata1_db->query($sql);
		$pay_name = $result->fetchColumn();
		$params = array(':uid' => $uid, ':username' => $username, ':pay_card' => $pay_card, ':pay_num' => $pay_num, ':pay_address' => $pay_address, ':pay_name' => $pay_name);
		$sql = 'insert into history_bank (uid,username,pay_card,pay_num,pay_address,pay_name) values (:uid,:username,:pay_card,:pay_num,:pay_address,:pay_name)';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
	}
	message('资料已经修改成功!');
}else{
	message('对不起，资料修改失败!');
}
?>