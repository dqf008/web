<?php 
session_start();
header('Content-type: text/json;charset=utf-8');
include_once 'include/config.php';
website_close();
website_deny();
$uid = $_SESSION['uid'];
$callback = $_GET['callback'];
include_once 'database/mysql.config.php';
include_once 'common/logintu.php';
$md = date('m-d');
sessionNum($uid, 4, $callback);

$ft = $ft_ds = $ft_rb = $ft_bd = $ft_rqs = $ft_bqc = $ft_zhgg = 0;//足球
$bk = $bk_ds = $bk_rb = $bk_zhgg = 0;//篮球
$tn = $tn_ds = $tn_rb = $tn_bd = $tn_zhgg = 0;//网球
$bs = $bs_ds = $bs_rb = $bs_zhgg = 0;//棒球
$vb = $vb_ds = $vb_rb = $vb_bd = $vb_zhgg = 0;//排球
$op = $op_ds = $op_rb = $op_zhgg = 0;//其他
$bm = $bm_ds = $bm_rb = $bm_bd = $bm_zhgg = 0;//羽毛球
$tt = $tt_ds = $tt_rb = $tt_bd = $tt_zhgg = 0;//乒乓球
$sk = $sk_ds = $sk_rb = $sk_bd = $sk_zhgg = 0;//台球

//早盘
$ftz = $ftz_ds = $ftz_bd = $ftz_rqs = $ftz_bqc = $ftz_zhgg = 0;//足球
$bkz = $bkz_ds = $bkz_zhgg = 0;//篮球
$tnz = $tnz_ds = $tnz_bd = $tnz_zhgg = 0;//网球
$bsz = $bsz_ds = $bsz_zhgg = 0;//棒球
$vbz = $vbz_ds = $vbz_bd = $vbz_zhgg = 0;//排球
$opz = $opz_ds = $opz_rb = $opz_zhgg = 0;//其他
$bmz = $bmz_ds = $bmz_bd = $bmz_zhgg = 0;//羽毛球
$ttz = $ttz_ds = $ttz_bd = $ttz_zhgg = 0;//乒乓球
$skz = $skz_ds = $skz_bd = $skz_zhgg = 0;//台球

$tz_money = $user_num = $user_money = 0;


$params = array(':Match_Date' => $md);
$sql = 'SELECT count(*) as s FROM mydata4_db.Bet_Match  WHERE Match_Type=1 AND Match_CoverDate>now() AND Match_Date=:Match_Date and Match_HalfId is not null';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$ft_ds = $stmt->fetchColumn();
include_once 'cache/zqgq.php';
if (20 < (time() - $lasttime)){
	$ft_rb = 0;
}else{
	$ft_rb = count($zqgq);
}

//综合过关
$sql = 'SELECT count(*) as s FROM mydata4_db.Bet_Match  WHERE Match_CoverDate>now() AND Match_Date>=:Match_Date and Match_HalfId is not null';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$ft_zhgg = $stmt->fetchColumn();

$sql = 'SELECT count(*) as s FROM mydata4_db.Bet_Match where Match_Type=1 and Match_IsShowbd=1 and  Match_CoverDate>now() and Match_Bd21>0';
$query = $mydata1_db->query($sql);
$ft_bd = $query->fetchColumn();

$sql = 'SELECT count(*) as s FROM mydata4_db.Bet_Match where Match_Type=1 and Match_IsShowt=1 and Match_Total01Pl>0 AND Match_CoverDate>now()';
$query = $mydata1_db->query($sql);
$ft_rqs = $query->fetchColumn();

$params = array(':Match_Date' => $md);
$sql = 'SELECT count(*) as s FROM mydata4_db.Bet_Match where Match_CoverDate>now() and Match_BqMM>0 and Match_Date=:Match_Date';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$ft_bqc = $stmt->fetchColumn();

$ft = $ft_ds +  $ft_bd + $ft_rqs + $ft_bqc ;

$sql = 'SELECT count(*) as s FROM mydata4_db.Bet_Match WHERE Match_Type=0 AND Match_CoverDate>now()';
$query = $mydata1_db->query($sql);
$ftz_ds = $query->fetchColumn();

$sql = 'SELECT count(*) as s FROM mydata4_db.Bet_Match where Match_Type=0 and Match_IsShowbd=1 and   Match_CoverDate>now() and Match_Bd21>0';
$query = $mydata1_db->query($sql);
$ftz_bd = $query->fetchColumn();

$sql = 'SELECT count(*) as s FROM mydata4_db.Bet_Match where Match_Type=0 and Match_IsShowt=1 AND Match_CoverDate>now() and Match_Total01Pl>0';
$query = $mydata1_db->query($sql);
$ftz_rqs = $query->fetchColumn();

$params = array(':Match_Date' => $md);
$sql = 'SELECT count(*) as s FROM mydata4_db.Bet_Match WHERE Match_Date<>:Match_Date and Match_CoverDate>now() and Match_BqMM>0';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$ftz_bqc = $stmt->fetchColumn();

$ftz = $ftz_ds + $ftz_bd + $ftz_rqs + $ftz_bqc;



$params = array(':Match_Date' => $md);
$sql = 'SELECT count(*) as s FROM mydata4_db.lq_match WHERE Match_CoverDate>now() AND Match_Date=:Match_Date';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$bk_ds = $stmt->fetchColumn();

//综合过关
$sql = 'SELECT count(*) as s FROM mydata4_db.lq_match WHERE Match_CoverDate>now() AND Match_Date>=:Match_Date';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$bk_zhgg = $stmt->fetchColumn();

$params = array(':match_Date' => $md);
$sql = 'SELECT id FROM mydata4_db.lq_match WHERE MB_Inball_OK is not null and  match_Date=:match_Date and match_js=1 and Match_Guest not like \'% - (%\' group by match_master';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$lm_jg = $stmt->rowCount();
include_once 'cache/lqgq.php';
if (20 < (time() - $lasttime)){
	$bk_rb = 0;
}else{
	$bk_rb = count($lqgq);
}

$bk = $bk_ds;

$params = array(':Match_Date' => $md);
$sql = 'SELECT count(*) as s FROM mydata4_db.lq_match WHERE Match_CoverDate>now() AND Match_Date<>:Match_Date';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$bkz_ds = $stmt->fetchColumn();

$bkz = $bkz_ds;



$params = array(':Match_Date' => $md);
$sql = 'SELECT count(*) as s FROM mydata4_db.tennis_match WHERE Match_Type=1 AND Match_CoverDate>now() AND Match_Date=:Match_Date';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$tn_ds = $stmt->fetchColumn();

$sql = 'SELECT count(*) as s FROM mydata4_db.tennis_match where Match_Type=10 and Match_CoverDate>now() and Match_Bd21>0';
$query = $mydata1_db->query($sql);
$tn_bd = $query->fetchColumn();

$tn = $tn_ds + $tn_bd;

$params = array(':Match_Date' => $md);
$sql = 'SELECT count(*) as s FROM mydata4_db.badminton_match WHERE Match_Type=1 AND Match_CoverDate>now() AND Match_Date=:Match_Date';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$bm_ds = $stmt->fetchColumn();

$sql = 'SELECT count(*) as s FROM mydata4_db.badminton_match where Match_Type=10 and Match_CoverDate>now() and Match_Bd21>0';
$query = $mydata1_db->query($sql);
$bm_bd = $query->fetchColumn();

$bm = $bm_ds + $bm_bd;


$params = array(':Match_Date' => $md);
$sql = 'SELECT count(*) as s FROM  mydata4_db.volleyball_match WHERE Match_Type=1 AND Match_CoverDate>now() AND Match_Date=:Match_Date';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$vb_ds = $stmt->fetchColumn();

$sql = 'SELECT count(*) as s FROM mydata4_db.volleyball_match where Match_Type=10 and Match_CoverDate>now()';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$vb_bd = $stmt->fetchColumn();

/*include_once 'cache/pqgq.php';
if (20 < (time() - $lasttime)){
	$vb_rb = 0;
}else{
	$vb_rb = count($pqgq);
}*/

$vb = $vb_ds + $vb_bd ;



$params = array(':Match_Date' => $md);
$sql = 'SELECT count(*) as s FROM mydata4_db.baseball_match WHERE Match_Type=1 AND Match_CoverDate>now() AND Match_Date=:Match_Date';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$bs_ds = $stmt->fetchColumn();

$bs = $bs_ds;

$params = array(':Match_Date' => $md);
$sql = 'SELECT count(*) as s FROM mydata4_db.snooker_match  WHERE Match_Type=1 AND Match_CoverDate>now() AND Match_Date=:Match_Date ';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$sk_ds = $stmt->fetchColumn();
$sk = $sk_ds;

$params = array(':Match_Date' => $md);
$sql = 'SELECT count(*) as s FROM mydata4_db.other_match  WHERE Match_Type=1 AND Match_CoverDate>now() AND Match_Date=:Match_Date ';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$op_ds = $stmt->fetchColumn();
$op = $op_ds;

//未结算注单数
$uid = $_SESSION['uid'];
$wjs = 0;
if(isset($uid)){
	$params = array(':uid' => $uid);
	$sql = 'select bid from k_bet where status=0 and uid=:uid  order by bid desc ';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$wjs1 = $stmt->rowCount();

	$params = array(':uid' => $uid);
	$sql = 'select gid from k_bet_cg_group where status=0 and uid=:uid  order by gid desc ';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$wjs2 = $stmt->rowCount();

	$wjs = $wjs1 + $wjs2;
}


if ($uid && (0 < $uid)){
	$params = array(':uid' => $uid);
	$sql = 'SELECT sum(bet_money) as s FROM `k_bet` where uid=:uid and status=0';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$tz_money = $stmt->fetchColumn();
	$params = array(':uid' => $uid);
	$sql = 'select sum(bet_money) as s from k_bet_cg_group where uid=:uid and status=0';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$tz_money += $stmt->fetchColumn();
	$params = array(':uid' => $uid);
	$sql = 'select count(*) as s from k_user_msg where uid=:uid and islook=0';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$user_num = $stmt->fetchColumn();
	$params = array(':uid' => $uid);
	$sql = 'select money as s from k_user where uid=:uid limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$user_money = sprintf('%.2f', $stmt->fetchColumn());
}

$json['ft'] = $ft;
$json['ftz'] = $ftz;
$json['ft_rb'] = $ft_rb;
$json['ft_zhgg'] = $ft_zhgg;

$json['bk'] = $bk;
$json['bkz'] = $bkz;
$json['bk_rb'] = $bk_rb;
$json['bk_zhgg'] = $bk_zhgg;

$json['tn'] = $tn;
$json['tnz'] = $tnz;
$json['tn_rb'] = $tn_rb;
$json['tn_zhgg'] = $tn_zhgg;

$json['vb'] = $vb;
$json['vbz'] = $vbz;
$json['vb_rb'] = $vb_rb;
$json['vb_zhgg'] = $vb_zhgg;

$json['bs'] = $bs;
$json['bsz'] = $bsz;
$json['bs_rb'] = $bs_rb;
$json['bs_zhgg'] = $bs_zhgg;

$json['op'] = $op;
$json['opz'] = $opz;
$json['op_rb'] = $op_rb;
$json['op_zhgg'] = $op_zhgg;

$json['tt'] = $tt;
$json['ttz'] = $ttz;
$json['tt_rb'] = $tt_rb;
$json['tt_zhgg'] = $tt_zhgg;

$json['bm'] = $bm;
$json['bmz'] = $bmz;
$json['bm_rb'] = $bm_rb;
$json['bm_zhgg'] = $bm_zhgg;

$json['sk'] = $sk;
$json['skz'] = $skz;
$json['sk_rb'] = $sk_rb;
$json['sk_zhgg'] = $sk_zhgg;

$json['wjs'] = $wjs;
 
$json['tz_money'] = $tz_money . ' RMB';
$json['user_money'] = $user_money . ' RMB';
$json['user_num'] = $user_num;
$json['uid'] = $uid;
echo $callback.'('.json_encode($json).')';
exit();
?>