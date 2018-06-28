<?php 
class money{
	static public function chongzhi($uid, $order, $money, $assets, $status = 2, $about = '', $m_type){
		global $mydata1_db;
		$params = array(':uid' => $uid, ':m_value' => $money, ':status' => $status, ':m_order' => $order, ':about' => $about, ':assets' => $assets, ':balance' => $assets + $money, ':type' => $m_type);
		$sql_money = 'insert into k_money(uid,m_value,status,m_order,about,assets,balance,type) values (:uid,:m_value,:status,:m_order,:about,:assets,:balance,:type)';
		$stmt = $mydata1_db->prepare($sql_money);
		$stmt->execute($params);
		$params = array(':money' => $money, ':uid' => $uid);
		$sql_user = 'update k_user set money=money+:money where uid=:uid';
		$stmt = $mydata1_db->prepare($sql_user);
		$stmt->execute($params);
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':transferOrder' => $order, ':transferAmount' => $money, ':transferAmount2' => $money, ':creationTime' => $creationTime, ':uid' => $uid);
		$stmt = $mydata1_db->prepare('INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)SELECT uid,username,\'ADMINACCOUNT\',\'IN\',:transferOrder,:transferAmount,money-:transferAmount2,money,:creationTime  FROM k_user WHERE uid=:uid');
		$stmt->execute($params);
		return true;
	}

	static public function tixian($uid, $money, $assets, $pay_card, $pay_num, $pay_address, $pay_name, $order = 0, $status = 2, $about = '', $m_type){
		global $mydata1_db;
		$params = array(':money' => $money, ':uid' => $uid);
		$sql_user = 'update k_user set money=money-:money where uid=:uid';
		$stmt = $mydata1_db->prepare($sql_user);
		$stmt->execute($params);
		$money = -$money;
		if ($order == '0'){
			$order = date('YmdHis') . '_' . $_SESSION['username'];
		}
		$params = array(':uid' => $uid, ':m_value' => $money, ':status' => $status, ':m_order' => $order, ':pay_card' => $pay_card, ':pay_num' => $pay_num, ':pay_address' => $pay_address, ':pay_name' => $pay_name, ':about' => $about, ':assets' => $assets, ':balance' => $assets + $money, ':type' => $m_type);
		$sql_money = 'insert into k_money(uid,m_value,status,m_order,pay_card,pay_num,pay_address,pay_name,about,assets,balance,type) values (:uid,:m_value,:status,:m_order,:pay_card,:pay_num,:pay_address,:pay_name,:about,:assets,:balance,:type)';
		$stmt = $mydata1_db->prepare($sql_money);
		$stmt->execute($params);
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':transferOrder' => $order, ':transferAmount' => $money, ':transferAmount2' => $money, ':creationTime' => $creationTime, ':uid' => $uid);
		$stmt = $mydata1_db->prepare('INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)SELECT uid,username,\'ADMINACCOUNT\',\'OUT\',:transferOrder,:transferAmount,money-:transferAmount2,money,:creationTime  FROM k_user WHERE uid=:uid');
		$stmt->execute($params);
		return true;
	}
}
?>