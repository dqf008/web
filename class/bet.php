<?php 
class bet{
	static public function set($bid, $status, $mb_inball = NULL, $tg_inball = NULL){
		$sql = '';
		$msg = '';
		$params = array(':MB_Inball' => $mb_inball, ':TG_Inball' => $tg_inball, ':bid' => $bid);
		switch ($status){
			case '1': $sql = 'update k_user,k_bet set k_user.money=k_user.money+k_bet.bet_win,k_bet.win=k_bet.bet_win,k_bet.status=1,k_bet.update_time=now(),k_bet.MB_Inball=:MB_Inball,k_bet.TG_Inball=:TG_Inball,fs=0 where k_user.uid=k_bet.uid and k_bet.bid=:bid and k_bet.status=0';
			$msg = '审核了编号为' . $bid . '的注单,设为赢';
			break;
			case '2': $sql = 'update k_user,k_bet set k_user.money=k_user.money,status=2,update_time=now(),k_bet.MB_Inball=:MB_Inball,k_bet.TG_Inball=:TG_Inball,fs=0 where k_user.uid=k_bet.uid and k_bet.bid=:bid and k_bet.status=0';
			$msg = '审核了编号为' . $bid . '的注单,设为输';
			break;
			case '3': $sql = 'update k_user,k_bet set k_user.money=k_user.money+k_bet.bet_money,k_bet.win=k_bet.bet_money,k_bet.status=3,k_bet.update_time=now(),k_bet.sys_about=\'批量无效\',k_bet.MB_Inball=:MB_Inball,k_bet.TG_Inball=:TG_Inball where k_user.uid=k_bet.uid and k_bet.bid=:bid and k_bet.status=0';
			$msg = '审核了编号为' . $bid . '的注单,设为取消';
			break;
			case '4': $sql = 'update k_user,k_bet set k_user.money=k_user.money+k_bet.bet_money+((k_bet.bet_money/2)*k_bet.bet_point),k_bet.win=k_bet.bet_money+((k_bet.bet_money/2)*k_bet.bet_point),k_bet.status=4,k_bet.update_time=now(),k_bet.MB_Inball=:MB_Inball,k_bet.TG_Inball=:TG_Inball,fs=0 where k_user.uid=k_bet.uid and k_bet.bid=:bid and k_bet.status=0';
			$msg = '审核了编号为' . $bid . '的注单,设为赢一半';
			break;
			case '5': $sql = 'update k_user,k_bet set k_user.money=k_user.money+(k_bet.bet_money/2),k_bet.win=k_bet.bet_money/2,k_bet.status=5,k_bet.update_time=now(),k_bet.MB_Inball=:MB_Inball,k_bet.TG_Inball=:TG_Inball,fs=0 where k_user.uid=k_bet.uid and k_bet.bid=:bid and k_bet.status=0';
			$msg = '审核了编号为' . $bid . '的注单,设为输一半';
			break;
			case '8': $sql = 'update k_user,k_bet set k_user.money=k_user.money+k_bet.bet_money,k_bet.win=k_bet.bet_money,k_bet.status=8,k_bet.update_time=now(),k_bet.MB_Inball=:MB_Inball,k_bet.TG_Inball=:TG_Inball where k_user.uid=k_bet.uid and k_bet.bid=:bid and k_bet.status=0';
			$msg = '审核了编号为' . $bid . '的注单,设为和';
			break;
			default: break;
		}
		global $mydata1_db;
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q1 = $stmt->rowCount();
		if ($q1){
			if ($status == '3'){
				$transferType = 'CANCEL_BET';
			}else{
				$transferType = 'RECKON';
			}
			$creationTime = date('Y-m-d H:i:s');
			$params = array(':transferType' => $transferType, ':creationTime' => $creationTime, ':bid' => $bid);
			$stmt = $mydata1_db->prepare('INSERT INTO k_money_log  (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)  SELECT k_user.uid,k_user.username,\'SportsDS\',:transferType,k_bet.number,k_bet.win+k_bet.fs,k_user.money-(k_bet.win+k_bet.fs),k_user.money,:creationTime  FROM k_user,k_bet WHERE k_user.uid=k_bet.uid AND k_bet.bid=:bid');
			$stmt->execute($params);
			$C_Patch = $_SERVER['DOCUMENT_ROOT'];
			include_once $C_Patch . '/common/commonfun.php';
			$params = array(':uid' => $_SESSION['adminid'], ':log_info' => $msg, ':log_ip' => get_client_ip());
			$stmt = $mydata1_db->prepare('insert into mydata3_db.sys_log(uid,log_info,log_ip) values(:uid,:log_info,:log_ip)');
			$stmt->execute($params);
			return true;
		}else{
			return false;
		}
	}

	static public function set_cg($bid, $status, $mb_inball = NULL, $tg_inball = NULL){
		global $mydata1_db;
		$params = array(':bid' => $bid);
		$sql = 'select gid,ben_add,bet_point from k_bet_cg where bid=:bid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$rows = $stmt->fetch();
		$ben_add = $rows['ben_add'];
		$bet_point = $rows['bet_point'];
		$gid = $rows['gid'];
		$q1 = $q2 = true;
		switch ($status){
			case 1: $params = array(':mb_inball' => $mb_inball, ':tg_inball' => $tg_inball, ':bid' => $bid);
			$sql = 'update k_bet_cg set status=1,mb_inball=:mb_inball,tg_inball=:tg_inball where bid=:bid and status=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q1 = $stmt->rowCount();
			if ($q1 == 1){
				$log_msg = '把串关单式注单编号为' . $bid . '设为赢';
				$show_msg = '单式编号' . $bid . '审核完成';
			}else{
				$show_msg = '串关单式编号' . $bid . '审核出错';
				break;
			}
			$params = array(':gid' => $gid);
			$sql = 'select win,bet_money from k_bet_cg_group where gid=:gid and `status`=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$rows = $stmt->fetch();
			$win = $rows['win'];
			$bet_money = $rows['bet_money'];
			$point = $ben_add + $bet_point;
			if ($win == 0){
				$win = $bet_money * $point;
			}else{
				$win = $win * $point;
			}
			$params = array(':win' => $win, ':gid' => $gid);
			$sql = 'update k_bet_cg_group set win=:win where gid=:gid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q2 = $stmt->rowCount();
			if ($q2 != 1){
				$show_msg .= '串关组中加钱出现错误';
			}
			break;
			case 2: $params = array(':mb_inball' => $mb_inball, ':tg_inball' => $tg_inball, ':bid' => $bid);
			$sql = 'update k_bet_cg set status=2,mb_inball=:mb_inball,tg_inball=:tg_inball where bid=:bid and status=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q1 = $stmt->rowCount();
			if ($q1 == 1){
				$log_msg = '把串关单式注单编号为' . $bid . '设为输';
				$show_msg = '单式编号' . $bid . '审核完成';
			}else{
				$msg = '串关单式编号' . $bid . '审核出错';
				break;
			}
			$params = array(':gid' => $gid);
			$sql = 'update k_bet_cg_group set win=0,status=2 where gid=:gid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q2 = $stmt->rowCount();
			break;
			case 3: $params = array(':mb_inball' => $mb_inball, ':tg_inball' => $tg_inball, ':bid' => $bid);
			$sql = 'update k_bet_cg set status=3,mb_inball=:mb_inball,tg_inball=:tg_inball where bid=:bid and status=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q1 = $stmt->rowCount();
			if ($q1 == 1){
				$log_msg = '把注单编号为' . $bid . '的串关单式设为无效';
				$show_msg = '设为无效操作完成';
			}else{
				$show_msg = '串关单式编号' . $bid . '审核出错';
				break;
			}
			$params = array(':gid' => $gid);
			$sql = 'update k_bet_cg_group set cg_count=cg_count-1 where gid=:gid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q2 = $stmt->rowCount();
			if ($q2 != 1){
				$show_msg .= '减1过程中出现错误';
			}
			break;
			case 4: $params = array(':mb_inball' => $mb_inball, ':tg_inball' => $tg_inball, ':bid' => $bid);
			$sql = 'update k_bet_cg set status=4,mb_inball=:mb_inball,tg_inball=:tg_inball where bid=:bid and status=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q1 = $stmt->rowCount();
			if ($q1 == 1){
				$log_msg = '把注单编号为' . $bid . '的串关单式设为赢一半';
				$show_msg = '设为赢一半操作完成';
			}else{
				$show_msg = '串关单式编号' . $bid . '审核出错';
				break;
			}
			$params = array(':gid' => $gid);
			$sql = 'select win,bet_money from k_bet_cg_group where gid=:gid and `status`=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$rows = $stmt->fetch();
			$win = $rows['win'];
			$bet_money = $rows['bet_money'];
			$point = 1 + ($bet_point / 2);
			if ($win == 0){
				$win = $bet_money * $point;
			}else{
				$win = $win * $point;
			}
			$params = array(':win' => $win, ':gid' => $gid);
			$sql = 'update k_bet_cg_group set win=:win where gid=:gid and `status`=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q2 = $stmt->rowCount();
			if ($q2 != 1){
				$show_msg .= '加钱过程中出现错误，该组串关已结算';
			}
			break;
			case 5: $params = array(':mb_inball' => $mb_inball, ':tg_inball' => $tg_inball, ':bid' => $bid);
			$sql = 'update k_bet_cg set status=5,mb_inball=:mb_inball,tg_inball=:tg_inball where bid=:bid and status=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q1 = $stmt->rowCount();
			if ($q1 == 1){
				$log_msg = '把注单编号为' . $bid . '的串关单式设为输一半';
				$show_msg = '设为输一半操作完成';
			}else{
				$msg = '串关单式编号' . $bid . '审核出错';
				break;
			}
			$params = array(':gid' => $gid);
			$sql = 'select win,bet_money from k_bet_cg_group where gid=:gid and `status`=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$rows = $stmt->fetch();
			$win = $rows['win'];
			$bet_money = $rows['bet_money'];
			$point = 0.5;
			if ($win == 0){
				$win = $bet_money * $point;
			}else{
				$win = $win * $point;
			}
			$params = array(':win' => $win, ':gid' => $gid);
			$sql = 'update k_bet_cg_group set win=:win where gid=:gid and `status`=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q2 = $stmt->rowCount();
			if ($q2 != 1){
				$show_msg .= '加钱过程中出现错误，该组串关已结算';
			}
			break;
			case 8: $params = array(':mb_inball' => $mb_inball, ':tg_inball' => $tg_inball, ':bid' => $bid);
			$sql = 'update k_bet_cg set status=8,mb_inball=:mb_inball,tg_inball=:tg_inball where bid=:bid and status=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q1 = $stmt->rowCount();
			if ($q1 == 1){
				$log_msg = '把注单编号为' . $bid . '的串关单式设为平手';
				$show_msg = '设为平手操作完成';
			}else{
				$show_msg = '串关单式编号' . $bid . '审核出错';
				break;
			}
			break;
			default: break;
		}

		if ($q1 == 1){
			if (isset($log_msg)){
				$C_Patch = $_SERVER['DOCUMENT_ROOT'];
				include_once $C_Patch . '/common/commonfun.php';
				$params = array(':uid' => $_SESSION['adminid'], ':log_info' => $log_msg, ':log_ip' => get_client_ip());
				$stmt = $mydata1_db->prepare('insert into mydata3_db.sys_log(uid,log_info,log_ip) values(:uid,:log_info,:log_ip)');
				$stmt->execute($params);
			}
			return true;
		}else{
			return false;
		}
	}


	static public function qx_bet($bid, $status){
		global $mydata1_db;
		$money = 0;
		$params = array(':money' => $money, ':bid' => $bid);
		$sql = 'update k_bet,k_user set k_user.money=k_user.money-k_bet.win-:money where k_user.uid=k_bet.uid and k_bet.bid=:bid and k_bet.status>0';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q1 = $stmt->rowCount();
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':money' => $money, ':money2' => $money, ':creationTime' => $creationTime, ':bid' => $bid);
		$stmt = $mydata1_db->prepare('INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'SportsDS\',\'RECALC\',k_bet.number,-k_bet.win-:money,k_user.money+(k_bet.win+:money2),k_user.money,:creationTime FROM k_user,k_bet WHERE k_user.uid=k_bet.uid AND k_bet.bid=:bid');
		$stmt->execute($params);
		$params = array(':bid' => $bid);
		$sql = 'update k_bet set status=0,win=0,update_time=null,fs=0 where k_bet.bid=:bid and k_bet.status>0';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q2 = $stmt->rowCount();
		if ((0 <= $q1) && ($q2 == 1)){
			return true;
		}else{
			return false;
		}
	}


	static public function qx_cgbet($bid){
		global $mydata1_db;
		$params = array(':bid' => $bid);
		$sql = 'select cg.status,cgg.gid,cgg.status as status_cgg,cg.bet_point,cg.match_id,cg.ben_add,cgg.win,cgg.uid,cgg.bet_money,cgg.fs from k_bet_cg cg,k_bet_cg_group cgg where cg.status>0 and cg.gid=cgg.gid and cg.bid=:bid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$t = $stmt->fetch();
		$status_cgg = $t['status_cgg'];
		$status = $t['status'];
		$gid = $t['gid'];
		$win = $t['win'];
		$uid = $t['uid'];
		$ben_add = $t['ben_add'];
		$bet_point = $t['bet_point'];
		$ts_money = $t['fs'];
		$mid = $t['match_id'];
		$b1 = $b3 = $b4 = $b6 = false;
		if ($status_cgg == 1){
			$b1 = true;
			$params = array(':gid' => $gid, ':bid' => $bid);
			$sql = 'select count(gid) as s from k_bet_cg where gid=:gid and status=2 and bid!=:bid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$t = $stmt->fetch();
			$params = array(':ts_money' => $ts_money, ':gid' => $gid);
			if (0 < $t['s']){
				$sql = 'update k_user,k_bet_cg_group set k_user.money=k_user.money-k_bet_cg_group.win-:ts_money,k_bet_cg_group.status=2 where k_user.uid=k_bet_cg_group.uid and k_bet_cg_group.gid=:gid';
			}else{
				$sql = 'update k_user,k_bet_cg_group set k_user.money=k_user.money-k_bet_cg_group.win-:ts_money,k_bet_cg_group.status=0 where k_user.uid=k_bet_cg_group.uid and k_bet_cg_group.gid=:gid';
			}
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q1 = $stmt->rowCount();
			$creationTime = date('Y-m-d H:i:s');
			$params = array(':ts_money' => $ts_money, ':ts_money2' => $ts_money, ':creationTime' => $creationTime, ':gid' => $gid);
			$stmt = $mydata1_db->prepare('INSERT INTO k_money_log  (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)  SELECT k_user.uid,k_user.username,\'SportsCG\',\'RECALC\',k_bet_cg_group.gid,-k_bet_cg_group.win-:ts_money,k_user.money+(k_bet_cg_group.win+:ts_money2),k_user.money,:creationTime  FROM k_user,k_bet_cg_group WHERE k_user.uid=k_bet_cg_group.uid AND k_bet_cg_group.gid=:gid');
			$stmt->execute($params);
		}else if ($status_cgg == 3){
			$b1 = true;
			$creationTime = date('Y-m-d H:i:s');
			$params = array(':creationTime' => $creationTime, ':gid' => $gid);
			$stmt = $mydata1_db->prepare('INSERT INTO k_money_log  (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)  SELECT k_user.uid,k_user.username,\'SportsCG\',\'RECALC\',k_bet_cg_group.gid,-k_bet_cg_group.win,k_user.money,k_user.money-k_bet_cg_group.win,:creationTime  FROM k_user,k_bet_cg_group WHERE k_user.uid=k_bet_cg_group.uid AND k_bet_cg_group.gid=:gid');
			$stmt->execute($params);
			$params = array(':gid' => $gid);
			$sql = 'update k_user,k_bet_cg_group set  k_user.money=k_user.money-k_bet_cg_group.win, k_bet_cg_group.status=0, k_bet_cg_group.win=0  where k_user.uid=k_bet_cg_group.uid and k_bet_cg_group.gid=:gid';
			$win = 0;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q1 = $stmt->rowCount();
		}

		$params = array(':bid' => $bid);
		$sql = 'update k_bet_cg set status=0 where bid=:bid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q3 = $stmt->rowCount();
		$params = array(':gid' => $gid);
		$sql = 'update k_bet_cg_group set update_time=null,fs=0 where gid=:gid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		if ($status == 2){
			$params = array(':gid' => $gid);
			$sql = 'update k_bet_cg_group g set g.status=0 where g.cg_count=(select count(b.gid) from k_bet_cg b where b.gid=g.gid and b.status!=2) and g.gid=:gid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$params = array(':gid' => $gid, ':bid' => $bid);
			$sql = 'select status,gid,ben_add,bet_point from k_bet_cg where gid=:gid and status not in(0,3,6,7,8) and  bid!=:bid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($infos = $stmt->fetch()){
				$benadd = $infos['ben_add'];
				$betpoint = $infos['bet_point'];
				$gid = $infos['gid'];
				$paramsSub = array(':gid' => $gid);
				$sqlSub = 'select win,bet_money from k_bet_cg_group where gid=:gid and status=0';
				$stmtSub = $mydata1_db->prepare($sqlSub);
				$stmtSub->execute($paramsSub);
				$tx = $stmtSub->fetch();
				$txwin = $tx['win'];
				$betmoney = $tx['bet_money'];
				$points = $benadd + $betpoint;
				if ($infos['status'] == 1){
					if ($txwin == 0){
						$txwin = $betmoney * $points;
					}else{
						$txwin = $txwin * $points;
					}
					$paramsSub = array(':win' => $txwin, ':gid' => $gid);
					$sqlSub = 'update k_bet_cg_group set win=:win where gid=:gid and status=0';
					$stmtSub = $mydata1_db->prepare($sqlSub);
					$stmtSub->execute($paramsSub);
				}

				if ($infos['status'] == 2){
					$paramsSub = array(':gid' => $gid);
					$sqlSub = 'update k_bet_cg_group set win=0,status=2 where gid=:gid';
					$stmtSub = $mydata1_db->prepare($sqlSub);
					$stmtSub->execute($paramsSub);
				}

				if ($infos['status'] == 4){
					$points = 1 + ($betpoint / 2);
					if ($txwin == 0){
						$txwin = $betmoney * $points;
					}else{
						$txwin = $txwin * $points;
					}
					$paramsSub = array(':win' => $txwin, ':gid' => $gid);
					$sqlSub = 'update k_bet_cg_group set win=:win where gid=:gid and status=0';
					$stmtSub = $mydata1_db->prepare($sqlSub);
					$stmtSub->execute($paramsSub);
				}

				if ($infos['status'] == 5){
					$points = 0.5;
					if ($txwin == 0){
						$txwin = $betmoney * $points;
					}else{
						$txwin = $txwin * $points;
					}
					$paramsSub = array(':win' => $txwin, ':gid' => $gid);
					$sqlSub = 'update k_bet_cg_group set win=:win where gid=:gid and status=0';
					$stmtSub = $mydata1_db->prepare($sqlSub);
					$stmtSub->execute($paramsSub);
				}
			}
		}else{
			if ($status == 1){
				$win = $win / ($ben_add + $bet_point);
			}

			if ($status == 3){
				$b4 = true;
				$win = $win;
				$params = array(':gid' => $gid);
				$sql = 'update k_bet_cg_group set cg_count=cg_count+1 where gid=:gid';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				$q4 = $stmt->rowCount();
			}

			if ($status == 4){
				$win = ($win * 2) / (1 + $ben_add + $bet_point);
			}

			if ($status == 5){
				$win = 2 * $win;
			}

			if ($status == 6){
				$b6 = true;
				$params = array(':bid' => $bid);
				$sql = 'update k_bet_cg set status=0 where bid=:bid';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				$q6_1 = $stmt->rowCount();
				$params = array(':gid' => $gid);
				$sql = 'update k_bet_cg_group set status=0 where gid=:gid';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				$q6_2 = $stmt->rowCount();
				$win = 0;
			}

			$params = array(':win' => $win, ':gid' => $gid);
			$sql = 'update k_bet_cg_group set win=:win where gid=:gid';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$params = array(':gid' => $gid, ':gid2' => $gid);
			$sql = 'update k_bet_cg_group set win=0 where gid=:gid and (select count(bid) from k_bet_cg where gid=:gid2 and status>0)=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$params = array(':gid' => $gid, ':gid2' => $gid, ':bid' => $bid);
			$sql = 'update k_bet_cg_group set win=0 where gid=:gid and (select count(bid) from k_bet_cg where gid=:gid2 and bid!=:bid and status in(0,3,8))=(k_bet_cg_group.cg_count-1)';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}

		if($q3>0){
			while(1){

				if($b1){
					if($q1>0){ 
						$b3 = true;
					}else{ 
						$b3=false;
						break;
					}
				}

				if($b4){
					if($q4>0) 
						$b3 = true;
					else{
						$b3		= false;
						break;
					}
				}

				if($b6){
					if($q6_1>0 && $q6_2>0) 
						$b3 = true;
					else{
						$b3		= false;
						break;
					}
				}

				$b3 = true;
				break;
			}
		}

		if($b3){
			return true;
		}else{
			return false;
		}
	}
}
?>