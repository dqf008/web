<?php 
$lottery_time = time() + (1 * 12 * 3600);
$l_time = date('Y-m-d H:i:s', $lottery_time);
$lottery_ssc_time = time() + (1 * 12 * 3600);
$ssc_time = date('H:i:s', $lottery_ssc_time);
$ssc_date = date('Ymd', $lottery_ssc_time);
$lowbet = 10;

function mdtime($md_time){
	$meidong_time = strtotime($md_time) - (1 * 12 * 3600);
	$md_times = date('Y-m-d H:i:s', $meidong_time);
	return $md_times;
}

function mdssc($md_ssc){
	$meidong_ssc = strtotime($md_ssc) - (1 * 12 * 3600);
	$md_sscs = date('Y-m-d', time() + (1 * 12 * 3600)) . ' ' . date('H:i:s', $meidong_ssc);
	return $md_sscs;
}

function bjssc($bj_ssc){
	$beijing_ssc = strtotime($bj_ssc);
	$bj_sscs = date('Y-m-d', time() + (1 * 12 * 3600)) . ' ' . date('H:i:s', $beijing_ssc);
	return $bj_sscs;
}

function tobjtime($md_time){
	$beijing_time = strtotime($md_time) + (1 * 12 * 3600);
	$rttime = date('Y-m-d H:i:s', $beijing_time);
	return $rttime;
}

function chkBetOdds($atype, $btype, $ctype, $odds){
	global $mydata1_db;
	$params = array(':class1' => $atype, ':class2' => $btype, ':class3' => $ctype);
	$chksql = 'select odds from lottery_odds where class1=:class1 and class2=:class2 and class3=:class3';
	$stmt = $mydata1_db->prepare($chksql);
	$stmt->execute($params);
	$chkrow = $stmt->fetch();
	$chkcou = $stmt->rowCount();
	if (($chkcou == 1) && ($chkrow['odds'] == $odds))
	{
		return true;
	}else{
		return false;
	}
}