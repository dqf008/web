<?php 
class bet_cg{
	static public function js($gid){
		global $mydata1_db;
		$params = array(':gid' => $gid);
		$sql = 'select count(*) as nums from k_bet_cg where gid=:gid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$cg_count = $stmt->fetchColumn();
		$params = array(':gid' => $gid);
		$sql = 'select g.gid from k_bet_cg_group g where ' . $cg_count . '=(select count(b.gid) from k_bet_cg b where `status` in(1,2,3,4,5,8) and b.gid=g.gid) and ' . $cg_count . '>(select count(b.gid) from k_bet_cg b where `status` in(3,8) and b.gid=g.gid) and g.gid=:gid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$params = array(':gid' => $gid);
		if (0 < $stmt->rowCount()){
			$sql = 'update k_user,k_bet_cg_group set  k_user.money=k_user.money+k_bet_cg_group.win, k_bet_cg_group.status=1, k_bet_cg_group.update_time=now(), k_bet_cg_group.fs=0  where k_user.uid=k_bet_cg_group.uid  and k_bet_cg_group.gid=:gid  and k_bet_cg_group.status!=1';
		}else{
			$sql = 'select g.bet_money from k_bet_cg_group g  where ' . $cg_count . '=(select count(b.gid) from k_bet_cg b where b.status in(3,8) and b.gid=g.gid) and g.gid=:gid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			if (0 < $stmt->rowCount()){
				$sql = 'update k_user,k_bet_cg_group set k_user.money=k_user.money+k_bet_cg_group.bet_money,k_bet_cg_group.status=3,k_bet_cg_group.win=k_bet_cg_group.bet_money,k_bet_cg_group.update_time=now() where k_user.uid=k_bet_cg_group.uid and k_bet_cg_group.gid=:gid and k_bet_cg_group.status!=3';
			}
		}
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q1 = $stmt->rowCount();
		if ($q1){
			$creationTime = date('Y-m-d H:i:s');
			$params = array(':creationTime' => $creationTime, ':gid' => $gid);
			$sql = 'INSERT INTO k_money_log  (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)  SELECT k_user.uid,k_user.username,\'SportsCG\',\'RECKON\',k_bet_cg_group.gid,k_bet_cg_group.win,k_user.money-k_bet_cg_group.win,k_user.money,:creationTime  FROM k_user,k_bet_cg_group WHERE k_user.uid=k_bet_cg_group.uid AND k_bet_cg_group.gid=:gid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			return true;
		}else{
			return false;
		}
	}
}

?>