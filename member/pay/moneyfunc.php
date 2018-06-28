<?php
function insert_online_money($username, $m_order, $m_value, $m_about='该订单在线冲值操作成功'){
	global $mydata1_db;
	global $pay_online;
	global $pay_mid;
	$params = array(':username' => $username);
	$sql = 'select uid,username,money from k_user where username=:username limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rows = $stmt->fetch();
	$cou = $stmt->rowCount();
	if ($cou <= 0)
	{
		return -1;
	}
	$assets = $rows['money'];
	$uid = $rows['uid'];
	$params = array(':m_order' => $m_order);
	$sql = 'select m_id from k_money where m_order=:m_order';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$cou = $stmt->rowCount();
	if ($cou == 0)
	{
		$params = array(':uid' => $uid, ':m_value' => $m_value, ':m_order' => $m_order, ':assets' => $assets, ':balance' => $assets + $m_value, ':pay_online' => $pay_online, ':pay_mid' => $pay_mid);
		$sql = "\r\n\t\t\t" . 'insert into k_money ( uid, m_value, m_order, status, assets, balance, type,         money_type,         pay_mid) values ( :uid, :m_value, :m_order, 2, :assets, :balance, 1,         :pay_online,         :pay_mid         )';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q1 = $stmt->rowCount();
		$m_id = $mydata1_db->lastInsertId();
		$params = array(':m_id' => $m_id, ':m_about' => $m_about);
		$sql = "\r\n\t\t\t" . 'update k_money,k_user set  k_money.status=1, k_money.update_time=now(), k_user.money=k_user.money+k_money.m_value, k_money.about=:m_about, k_money.sxf=k_money.m_value/100, k_money.balance=k_user.money+k_money.m_value where k_money.uid=k_user.uid and k_money.m_id=:m_id and k_money.`status`=2';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q2 = $stmt->rowCount();
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':creationTime' => $creationTime, ':m_id' => $m_id);
		$sql = "\r\n\t\t\t" . 'INSERT INTO k_money_log ( uid, userName, gameType, transferType, transferOrder, transferAmount, previousAmount, currentAmount, creationTime) SELECT  k_user.uid, k_user.username, \'ONLINEPAY\', \'IN\', k_money.m_order, k_money.m_value, k_user.money-k_money.m_value, k_user.money, :creationTime FROM k_user,k_money WHERE k_user.uid=k_money.uid AND k_money.status=1 AND k_money.m_id=:m_id';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q3 = $stmt->rowCount();
		if ($q1 && $q2 && $q3)
		{
			return 1;
		}
		else
		{
			return -2;
		}
	}
	else
	{
		return 0;
	}
}
function check_user_login($uid, $username){
	global $mydata1_db;
	$params = array(':uid' => $uid, ':username' => $username);
	$sql = 'select uid,username,mobile,money from k_user where uid=:uid and username=:username';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$row = $stmt->fetch();
	return $row;
}
function dz_authcode($string, $operation='DECODE', $key='959923777', $expiry=0){
    $ckey_length = 4;

    $key = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length?($operation=='DECODE'?substr($string, 0, $ckey_length):substr(md5(microtime()), -$ckey_length)):'';

    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);

    $string = $operation=='DECODE'?base64_decode(substr($string, $ckey_length)):sprintf('%010d', $expiry?$expiry+time():0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for($i=0;$i<=255;$i++){
        $rndkey[$i] = ord($cryptkey[$i%$key_length]);
    }

    for($j=$i=0;$i<256;$i++){
        $j = ($j+$box[$i]+$rndkey[$i])%256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for($a=$j=$i=0;$i<$string_length;$i++){
        $a = ($a+1)%256;
        $j = ($j+$box[$a])%256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result.= chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
    }

    if($operation=='DECODE'){
        if((substr($result, 0, 10)==0||substr($result, 0, 10)-time()>0)&&substr($result, 10, 16)==substr(md5(substr($result, 26).$keyb), 0, 16)){
            return substr($result, 26);
        } else {
            return '';
        }
    }else{
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

/* 产生订单 */
function generate_id($prefix='', $custom='0', $len=32, $key='959923777'){
    (!is_string($key)||empty($key))&&$key = '959923777';
    $_verify = array();
    for($i=0;$i<strlen($key);$i++){
        $_verify[] = substr($key, $i, 1);
    }
    $_verifyNum = 0;
    $_return = $custom.date('YmdHis').substr('000'.mt_rand(1, 999), -3);
    $_strlen = $len-strlen($prefix)-1;
    if($_strlen>strlen($_return)){
        for($i=strlen($_return);$i<$_strlen;$i++){
            $_return = '0'.$_return;
        }
    }else{
        $_return = substr($_return, -1*$len);
    }
    for($i=0;$i<strlen($_return);$i++){
        $_verifyNum+= substr($_return, $i, 1)*$_verify[fmod($i, 9)];
    }
    $_verifyNum = fmod($_verifyNum, 11);
    $_return.= $_verifyNum>9?'X':$_verifyNum;
    return $prefix.$_return;
}

/* 验证订单号 */
function verify_id($prefix='', $id='', $key='959923777'){
    $return = false;
    if(preg_match('/^('.$prefix.')\d+X?$/', $id, $matches)){
        (!is_string($key)||empty($key))&&$key = '959923777';
        $_verify = array();
        for($i=0;$i<strlen($key);$i++){
            $_verify[] = substr($key, $i, 1);
        }
        $_verifyNum = 0;
        $_verifyStr = substr($id, strlen($matches[1]));
        $_verifyStr = substr($_verifyStr, 0, strlen($_verifyStr)-1);
        for($i=0;$i<strlen($_verifyStr);$i++){
            $_verifyNum+= substr($_verifyStr, $i, 1)*$_verify[fmod($i, 9)];
        }
        $_verifyNum = fmod($_verifyNum, 11);
        $_verifyNum>9&&$_verifyNum = 'X';
        $return = substr($id, -1)==$_verifyNum;
    }
    return $return;
}