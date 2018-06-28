<?php 
/*
必须先引用 /class/Db.class.php
 */
class Pay {

	public function __construct(){
		class_exists('Db') or die('ERROR');
	}
	
	/* 产生订单 */
	function generate_id($prefix='', $custom='0', $len=16, $key='959923777'){
	    $_verify = array();
	    for($i=0;$i<strlen($key);$i++){
	        $_verify[] = substr($key, $i, 1);
	    }
	    $_verifyNum = 0;
	    $_return = $custom.date('YmdHis',time()+12*60*60).substr('000'.mt_rand(1, 999), -3);
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

	/**
	 * [add_order description]
	 * @param [type] $uid      [description]
	 * @param [type] $mid      [description]
	 * @param [type] $money    [description]
	 * @param [type] $pay_name [description]
	 */
	public function add_order($uid, $mid, $money, $pay_name){
		$db = new Db();
		$user = $db->row('select username from k_user where uid=:uid',['uid'=>$uid]);
		$username = $user['username'];
		$params = [
			'uid' => $uid,
			'username' => $username,
			'mid' => $mid,
			'pay_online' => $pay_name,
			'amount' => $money,
			'addtime' => date('Y-m-d H:i:s')
		];
		$res = $db->query('INSERT INTO `k_money_order` (`uid`, `username`, `mid`, `did`, `pay_online`, `amount`, `status`, `addtime`) VALUES (:uid, :username, :mid, "", :pay_online, :amount, 0, :addtime)', $params);
		return $res;
	}

	public function update_order(){

	}
}