<?php
class bet_ds {
	static public function dx_add($uid, $ball_sort, $point_column, $match_name, $master_guest, $match_id, $bet_info, $bet_money, $bet_point, $ben_add, $bet_win, $match_time, $match_endtime, $lose_ok, $match_showtype, $match_rgg, $match_dxgg, $match_nowscore, $match_type, $balance, $assets, $Match_HRedCard, $Match_GRedCard, $ksTime) {
		global $mydata1_db;
		include '../../../cache/conf.php';
		$params = array(':bet_money' => $bet_money, ':bet_money2' => $bet_money, ':uid' => $uid, ':balance' => $balance);
		$sql = 'update k_user set money=money-:bet_money where money>=:bet_money2 and uid=:uid and :balance>=0';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q3 = $stmt->rowCount();
		if ($q3 < 1){
			return false;
		}
		$params = array(':uid' => $uid, ':ball_sort' => $ball_sort, ':point_column' => $point_column, ':match_name' => $match_name, ':master_guest' => $master_guest, ':match_id' => $match_id, ':bet_info' => $bet_info, ':bet_money' => $bet_money, ':bet_point' => $bet_point, ':ben_add' => $ben_add, ':bet_win' => $bet_win, ':match_time' => $match_time, ':match_endtime' => $match_endtime, ':lose_ok' => $lose_ok, ':match_showtype' => $match_showtype, ':match_rgg' => $match_rgg, ':match_dxgg' => $match_dxgg, ':match_nowscore' => $match_nowscore, ':match_type' => $match_type, ':balance' => $balance, ':assets' => $assets, ':Match_HRedCard' => $Match_HRedCard, ':Match_GRedCard' => $Match_GRedCard, ':www' => $conf_www, ':match_coverdate' => $ksTime);
		$sql = 'insert into k_bet(uid,ball_sort,point_column,match_name,master_guest,match_id,bet_info,bet_money,bet_point,ben_add,bet_win,match_time,bet_time,match_endtime,lose_ok,match_showtype,match_rgg,match_dxgg,match_nowscore,match_type,balance,assets,Match_HRedCard,Match_GRedCard,www,match_coverdate)values (:uid,:ball_sort,:point_column,:match_name,:master_guest,:match_id,:bet_info,:bet_money,:bet_point,:ben_add,:bet_win,:match_time,now(),:match_endtime,:lose_ok,:match_showtype,:match_rgg,:match_dxgg,:match_nowscore,:match_type,:balance,:assets,:Match_HRedCard,:Match_GRedCard,:www,:match_coverdate)';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q1 = $stmt->rowCount();
		$id = $mydata1_db->lastInsertId();
		
		$datereg = date('YmdHis') . $id;
		$params = array(':number' => $datereg, ':bid' => $id);
		$sql = 'update `k_bet` set `number`=:number where bid=:bid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q2 = $stmt->rowCount();
		
		$userName = $_SESSION['username'];
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':uid' => $uid, ':userName' => $userName, ':transferOrder' => 'm_' . $datereg, ':transferAmount' => $bet_money, ':previousAmount' => $assets, ':currentAmount' => $balance, ':creationTime' => $creationTime);
		$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)VALUE (:uid,:userName,\'SportsDS\',\'BET\',:transferOrder,-:transferAmount,:previousAmount,:currentAmount,:creationTime)';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		
		$width = str_leng($ball_sort . '=' . $match_name . '=' . $master_guest . '=' . $bet_info . $bet_money);
		$height = 26;
		$im = imagecreate($width, $height);
		$bkg = imagecolorallocate($im, 255, 255, 255);
		$font = imagecolorallocate($im, 150, 182, 151);
		$sort_c = imagecolorallocate($im, 0, 0, 0);
		$name_c = imagecolorallocate($im, 243, 118, 5);
		$guest_c = imagecolorallocate($im, 34, 93, 156);
		$info_c = imagecolorallocate($im, 51, 102, 0);
		$money_c = imagecolorallocate($im, 255, 0, 0);
		$fnt = '../../../ttf/simhei.ttf';
		imagettftext($im, 10, 0, 7, 18, $sort_c, $fnt, $ball_sort);
		imagettftext($im, 10, 0, str_leng($ball_sort . '=='), 18, $name_c, $fnt, $match_name);
		imagettftext($im, 10, 0, str_leng($ball_sort . $match_name . '==='), 18, $guest_c, $fnt, $master_guest);
		imagettftext($im, 10, 0, str_leng($ball_sort . $match_name . $master_guest . '===='), 18, $info_c, $fnt, $bet_info);
		imagettftext($im, 10, 0, str_leng($ball_sort . $match_name . $master_guest . $bet_info . '==='), 18, $money_c, $fnt, $bet_money);
		imagerectangle($im, 0, 0, $width - 1, $height - 1, $font);
		if (!is_dir('../../../other/' . substr($datereg, 0, 8))) 
		{
			mkdir('../../../other/' . substr($datereg, 0, 8));
		}
		$q4 = imagejpeg($im, '../../../other/' . substr($datereg, 0, 8) . '/' . $datereg . '.jpg');
		imagedestroy($im);
		if (($q1 == 1) && ($q2 == 1) && ($q3 == 1) && $q4){
			return true;
		}else{
			return false;
		}
	}
}
?>