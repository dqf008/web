<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cwgl');
include_once '../../cache/tkcache.php';
if($tkcache['tkswitch'] !== 1) die();
$mid = (int)$_GET['mid'];
$order = $mydata1_db->query('select * from k_money where m_id='.$mid)->fetch(PDO::FETCH_ASSOC);
//if(empty($order) || $order['type'] != '2' || $order['status'] != '2') die();
$user = $mydata1_db->query('select * from k_user where uid='.$order['uid'])->fetch(PDO::FETCH_ASSOC);

$m_id = $order['m_id'];
$username = $user['username'];
$ag_zr_username = $user['agUserName'];
$agq_zr_username = $user['agqUserName'];
$bb_zr_username = $user['bbinUserName'];
$mg_zr_username = $user['mgUserName'];
$hg_zr_username = $user['hgUserName'];
$og_zr_username = $user['ogUserName'];
$pt_zr_username = $user['ptUserName'];
$maya_zr_username = $user['mayaUserName'];
$shaba_zr_username = $user['shabaUserName'];
$ipm_zr_username = $user['ipmUserName'];
$mw_zr_username = $user['mwUserName'];
$kg_zr_username = $user['kgUserName'];
$cq9_zr_username = $user['cq9UserName'];
$mg2_zr_username = $user['mg2UserName'];
$vr_zr_username = $user['vrUserName'];
$bg_zr_username = $user['bgUserName'];
$sb_zr_username = $user['sbUserName'];
$uid = $user['uid'];
$username = $user['username'];
$m_make_time = $order['m_make_time'];
$m_value = abs($order['m_value']);

//最新提款之前有无未处理的提款
$params = array(':uid' => $uid, ':m_make_time' => $m_make_time, ':m_id' => $m_id);
$sql = 'select min(left(m_make_time,10)) as min_tk_time from k_money where uid=:uid and type=2 and status=2 and m_make_time<=:m_make_time and m_id<>:m_id';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//获取日期 如:1970-01-01
$min_tk_time = $row['min_tk_time'];
if ($min_tk_time != NULL){
	echo  "<script>alert('该用户在此之前还有【提款提交】未处理，请先处理！');window.location.href='tixian.php?username=".$username."&bdate".$min_tk_time."=&status=2'</script>";
	exit();
}

	//最新提款之前有无未处理的汇款
	$params = array(':uid' => $uid, ':m_make_time' => $m_make_time);
	$sql = 'select min(left(adddate,10)) as min_hk_time from huikuan where status=0 and uid=:uid and adddate<=:m_make_time';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$row = $stmt->fetch();
	$min_hk_time = $row['min_hk_time'];
	if ($min_hk_time != NULL){
		echo "<script>alert('该用户在此之前还有【汇款提交】未处理，请先处理！');window.location.href='huikuan.php?username=".$username ."&bdate".$min_hk_time."=&status=0'</script>";
		exit();
	}

	//上次提款成功的时间
	$params = array(':uid' => $uid, ':m_make_time' => $m_make_time);
	$sql = 'select m_make_time from k_money where type=2 and status=1 and uid=:uid and  m_make_time<:m_make_time order by m_make_time desc limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$row = $stmt->fetch();
	$last_tk_time = $row['m_make_time'];
	$last_tk_time_flag = 1;

	if (($last_tk_time == NULL) || ($last_tk_time == '')){ //如过没有那么就是30天前日期
		$last_tk_time = date('Y-m-d', strtotime('-30 day')) . ' 00:00:00';
		$last_tk_time_flag = 0;
	}

	//北京时间
	$cn_q_btime = date('Y-m-d H:i:s', strtotime($last_tk_time)+12*60*60);
	$cn_q_etime = date('Y-m-d H:i:s', strtotime($m_make_time)+12*60*60);

	//当前时间段的汇款存款记录
	$params = array(':uid' => $uid, ':last_tk_time' => $last_tk_time, ':m_make_time' => $m_make_time, ':uid2' => $uid, ':last_tk_time2' => $last_tk_time, ':m_make_time2' => $m_make_time);
	$sql = ' select thetime,sum(money) as money,sum(cjmoney) as cjmoney from ( select m_make_time as thetime,m_value as money,0 as cjmoney  from k_money  where status=1  and (type=1 or type=3)  and uid=:uid  and m_make_time>:last_tk_time  and  m_make_time<:m_make_time group by thetime union all select adddate  as thetime,money as money,ifnull(zsjr,0) as cjmoney from huikuan  where status=1  and uid=:uid2  and adddate>:last_tk_time2 and adddate<:m_make_time2 group by thetime) t group by thetime order by t.thetime desc';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$ch_num = $stmt->rowCount();
	$mySumArray = array();
	$endtime = $m_make_time;
	$r = 0;
	$mainsql = '';
	$mainsql2 = '';
	while ($row = $stmt->fetch()){
		$starttime = $row['thetime'];
		//美东时间段
		$mainsql = $mainsql . 'select \'' . $endtime . '\' as endtime,\'' . $starttime . '\' as starttime union ';
		//北京时间段 比如六合彩
		$mainsql2 = $mainsql2 . 'select \'' . date('Y-m-d H:i:s', strtotime($endtime)+12*60*60) . '\' as endtime,\'' . date('Y-m-d H:i:s', strtotime($starttime)+12*60*60) . '\' as starttime union ';


		$mySumArray[$r]['starttime'] = $starttime;
		$mySumArray[$r]['endtime'] = $endtime;


		$mySumArray[$r]['chmoney'] = $row['money'];
		$mySumArray[$r]['cjmoney'] = $row['cjmoney'];

		$endtime = $starttime;
		$mySumArray[$r]['tknumber'] = ($_GET['tknumber_' . $r] <= 0 ? $tkcache['tknumber'] : $_GET['tknumber_' . $r]);
		$r++;
	}


	$starttime = $last_tk_time;
	//美东时间段
	$mainsql = $mainsql . 'select \'' . $endtime . '\' as endtime,\'' . $starttime . '\' as starttime  ) t left join  ';
	//北京时间段 比如六合彩
	$mainsql2 = $mainsql2 . 'select \'' . date('Y-m-d H:i:s', strtotime($endtime)+12*60*60) . '\' as endtime,\'' . date('Y-m-d H:i:s', strtotime($starttime)+12*60*60) . '\' as starttime  ) t left join  ';

	$mySumArray[$r]['starttime'] = $starttime;
	$mySumArray[$r]['endtime'] = $endtime;

	$mySumArray[$r]['chmoney'] = 0;
	$endtime = $starttime;
	$mySumArray[$r]['tknumber'] = ($_GET['tknumber_' . $r] <= 0 ? $tkcache['tknumber'] : $_GET['tknumber_' . $r]);
	$r++;
	$ch_num = $ch_num + 1;
	$endsql = 'group by t.starttime,t.endtime order by t.endtime desc';
	if (($last_tk_time_flag == 0) && ($ch_num == 1)){
		$resultMessage = '<span style="color:red;font-weight:900;">?</span><br/>此次【取款】之前没有任何【取款】、【存汇款】记录!<br/>请核实：数据是否被清除！';
		$special_need_money = $m_value;
	}else{

		if ($tkcache['tkty'] == 1){
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':uid'] = $uid;
			$startsql = 'select starttime,endtime,sum(bet_money) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' k_bet k on k.bet_time>= t.starttime and k.bet_time< t.endtime and k.lose_ok=1 and k.status in (1,2,4,5)  and k.bet_time>=:q_btime  and k.bet_time<=:q_etime and k.uid=:uid ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkty'] = $row['validmoney'];
				$r++;
			}
			$startsql = 'select starttime,endtime,sum(bet_money) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' k_bet_cg_group k on k.bet_time>= t.starttime and k.bet_time< t.endtime and k.gid>0  and k.status=1 and k.bet_time>=:q_btime  and k.bet_time<=:q_etime and k.uid=:uid ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkty'] = $mySumArray[$r]['tkty'] + $row['validmoney'];
				$r++;
			}
			
			//沙巴体育
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $shaba_zr_username;
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' shababetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkty'] = $mySumArray[$r]['tkty'] + $row['validmoney'];
				$r++;
			}

			//IPM体育
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $ipm_zr_username;
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' ipmbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkty'] = $mySumArray[$r]['tkty'] + $row['validmoney'];
				$r++;
			}
		}


		if ($tkcache['tkcp'] == 1)
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':username'] = $username;
			$startsql = 'select starttime,endtime,sum(money) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' c_bet k on k.addtime>= t.starttime and k.addtime< t.endtime and k.money>0 and k.js=1 and k.win<>0 and k.addtime>=:q_btime and k.addtime<=:q_etime and k.username=:username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkcp'] = $row['validmoney'];
				$r++;
			}

			$startsql = 'select starttime,endtime,sum(money) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' c_bet_3 k on k.addtime>= t.starttime and k.addtime< t.endtime and k.money>0 and k.js=1 and k.win<>0 and k.addtime>=:q_btime  and k.addtime<=:q_etime and k.username=:username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch()){
				$mySumArray[$r]['tkcp'] = $mySumArray[$r]['tkcp'] + $row['validmoney'];
				$r++;
			}

			$startsql = 'select starttime,endtime,sum(money) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' lottery_data k on k.bet_time>= t.starttime and k.bet_time< t.endtime and k.money>0 and k.bet_ok=1 and k.win<>0 and k.bet_time>=:q_btime  and k.bet_time<=:q_etime and k.username=:username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkcp'] = $mySumArray[$r]['tkcp'] + $row['validmoney'];
				$r++;
			}
			$startsql = 'select starttime,endtime,sum(money/100) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' c_bet_data k on FROM_UNIXTIME(k.addtime, "%Y-%m-%d %H:%i:%S")>= t.starttime and FROM_UNIXTIME(k.addtime, "%Y-%m-%d %H:%i:%S")< t.endtime and k.money>0 and k.status=1 and k.win<>0 and FROM_UNIXTIME(k.addtime, "%Y-%m-%d %H:%i:%S")>=:q_btime  and FROM_UNIXTIME(k.addtime, "%Y-%m-%d %H:%i:%S")<=:q_etime and k.uid=:uid ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			unset($params[':username']);
			$params[':uid'] = $uid;
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkcp'] = $mySumArray[$r]['tkcp'] + $row['validmoney'];
				$r++;
			}
		}


		$params = array();
		$params[':q_btime'] = $cn_q_btime;
		$params[':q_etime'] = $cn_q_etime;
		$params[':username'] = $username;
		if ($tkcache['tklh'] == 1)
		{
			$startsql = 'select starttime,endtime,sum(sum_m) as validmoney from ( ';
			$sql = $startsql . $mainsql2 . ' mydata2_db.ka_tan k on k.adddate>= t.starttime and k.adddate< t.endtime and checked=1 and bm<>2 and k.adddate>=:q_btime and k.adddate<=:q_etime and k.username=:username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tklh'] = $row['validmoney'];
				$r++;
			}
		}

		if (($tkcache['tkag'] == 1) && ($ag_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $ag_zr_username;
			$tkag_sum = 0;
			$r = 0;
			//agin
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' aginbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkag'] +=  $row['validmoney'];
				$r++;
			}

			//xin
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' xinbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkag'] +=  $row['validmoney'];
				$r++;
			}

			//yoplay
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' yoplaybetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkag'] +=  $row['validmoney'];
				$r++;
			}
			//bg
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' bgbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkag'] +=  $row['validmoney'];
				$r++;
			}

		}
		if (($tkcache['tkagq'] == 1) && ($agq_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $agq_zr_username;
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' agbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkagq'] = $row['validmoney'];
				$r++;
			}
		}
		if (($tkcache['tkhg'] == 1) && ($hg_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $hg_zr_username;
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' hgbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkhg'] = $row['validmoney'];
				$r++;
			}
		}
		if (($tkcache['tkvr'] == 1) && ($vr_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $vr_zr_username;
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' vrbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkvr'] = $row['validmoney'];
				$r++;
			}
		}
		if (($tkcache['tkbg'] == 1) && ($bg_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $bg_zr_username;
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' bglivebetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkbg'] = $row['validmoney'];
				$r++;
			}
		}
		if (($tkcache['tkbb'] == 1) && ($bb_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $bb_zr_username;
			
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' bbbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkbb'] = $row['validmoney'];
				$r++;
			}
		}
		if (($tkcache['tkmg'] == 1) && ($mg_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $mg_zr_username;
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' mgbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkmg'] = $row['validmoney'];
				$r++;
			}
		}

		if (($tkcache['tkmg2'] == 1) && ($mg2_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $mg2_zr_username;
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' mg2betdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkmg2'] = $row['validmoney'];
				$r++;
			}
		}

		if (($tkcache['tkmw'] == 1) && ($mw_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $mw_zr_username;
			
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' mwbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkmw'] = $row['validmoney'];
				$r++;
			}
		}
		if (($tkcache['tkkg'] == 1) && ($kg_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $kg_zr_username;
			
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' kgbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkkg'] = $row['validmoney'];
				$r++;
			}
		}
		if (($tkcache['tksb'] == 1) && ($sb_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $sb_zr_username;
			
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' sbbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tksb'] = $row['validmoney'];
				$r++;
			}
		}
		if (($tkcache['tkcq9'] == 1) && ($cq9_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $cq9_zr_username;
			
			$startsql = 'select starttime,endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' cq9betdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkcq9'] = $row['validmoney'];
				$r++;
			}
		}
		if (($tkcache['tkog'] == 1) && ($og_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $og_zr_username;
			$startsql = 'select t.starttime,t.endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' ogbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkog'] = $row['validmoney'];
				$r++;
			}
		}

		if (($tkcache['tkpt'] == 1) && ($pt_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $pt_zr_username;
			$startsql = 'select t.starttime,t.endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' ptbetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkpt'] = $row['validmoney'];
				$r++;
			}
		}

		if (($tkcache['tkmaya'] == 1) && ($maya_zr_username != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $maya_zr_username;
			$startsql = 'select t.starttime,t.endtime,sum(validBetAmount) as validmoney from ( ';
			$sql = $startsql . $mainsql . ' mayabetdetail k on k.betTime>= t.starttime and k.betTime< t.endtime  and k.betTime>=:q_btime   and k.betTime<=:q_etime and k.playerName=:zr_username ' . $endsql;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$r = 0;
			while ($row = $stmt->fetch())
			{
				$mySumArray[$r]['tkmaya'] = $row['validmoney'];
				$r++;
			}
		}

		$params = array();
		$params[':q_btime'] = $last_tk_time;
		$params[':q_etime'] = $m_make_time;
		$params[':uid'] = $uid;
		$startsql = 'select t.starttime,t.endtime,sum(if(k.type=4,m_value,0)) as cjmoney,sum(if(k.type=5,m_value,0)) as fsmoney,sum(if(k.type=6,m_value,0)) as othermoney from ( ';
		$sql = $startsql . $mainsql . ' k_money k on k.m_make_time>= t.starttime and k.m_make_time< t.endtime and k.status=1  and k.type in(4,5,6)  and k.m_make_time>=:q_btime  and k.m_make_time<=:q_etime and k.uid=:uid ' . $endsql;
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$r = 0;
		while ($row = $stmt->fetch())
		{
			$mySumArray[$r]['cjmoney'] = $mySumArray[$r]['cjmoney'] + $row['cjmoney'];
			$mySumArray[$r]['fsmoney'] = $row['fsmoney'];
			$mySumArray[$r]['othermoney'] = $row['othermoney'];
			$r++;
		}
		die(json_encode($mySumArray));
?> 	
  <script> 
   //数字验证 过滤非法字符 
          function clearNoNum(obj){ 
	          obj.value = obj.value.replace(/[^\d.]/g,"");//先把非数字的都替换掉，除了数字和. 
	          obj.value = obj.value.replace(/^\./g,"");//必须保证第一个为数字而不是. 
	          obj.value = obj.value.replace(/\.{2,}/g,".");//保证只有出现一个.而没有多个. 
	          obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");//保证.只出现一次，而不能出现两次以上 
	          if(obj.value != ''){ 
				  var re=/^\d+\.{0,1}\d{0,2}$/;
				  if(!re.test(obj.value))    
				  {    
					  obj.value = obj.value.substring(0,obj.value.length-1);
					  return false;
				  }  
	          } 
          } 
  </script> 
  <form action="tixian_show.php" method="get"> 
  <input name="id" value="<?=intval($_GET['id']);?>" type="hidden"> 
  <input name="dotype" value="1" type="hidden"> 
  <table width="98%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" align="center"> 
	  <thead style="background-color:#5E6FA4;color:#000;text-align:center;height:20px;"> 
		  <tr> 
			  <td rowspan="2">序号</td> 
			  <td rowspan="2">开始时间<br/>(美东时间)</td> 
			  <td rowspan="2">截止时间<br/>(不包含这一秒)</td><?php if ($tkcache['tkrkflag'] == 1)
	{?> 			  <td colspan="4">入款</td><?php }
 if ($tkcache['tkdmflag'] == 1)
	{?> 			  <td colspan="18">打码量</td><?php }?> 			  <td colspan="4">当次审核</td> 
			  <td colspan="5">累计审核</td> 
			  <td rowspan="2">需要<br/>几倍打码量</td> 
		  </tr> 
		  <tr><?php if ($tkcache['tkrkflag'] == 1)
	{?> 			  <td>存汇款</td> 
			  <td>彩金</td> 
			  <td>返水</td> 
			  <td>其它加减款</td><?php }
 if ($tkcache['tkdmflag'] == 1)
	{?> 			  <td>体育</td> 
			  <td>彩票</td> 
			  <td>六合彩</td> 
			  <td>AG</td> 
			  <td>AGQ</td> 
			  <td>BBIN</td>
			  <td>HG</td>
			  <td>OG</td>
			  <td>MG</td>
			  <td>MW</td>
			  <td>PT</td>
			  <td>MAYA</td> 
			  <td>AV</td>
			  <td>CQ9</td>
			  <td>新MG</td>
			  <td>VR</td>
			  <td>BG</td>
			  <td>SB</td>
			  <?php }?> 			  
			  <td>打码量</td> 
			  <td>入款</td> 
			  <td>打码量÷入款</td> 
			  <td>达标</td> 
			  <td>打码量</td> 
			  <td>入款</td> 
			  <td>打码量÷入款</td> 
			  <td>达标</td> 
			  <td>打码不足需扣款</td> 
		  </tr> 
	  </thead>
<?php 
	$all_dama = 0;
	$need_money = 0;
	$all_money = 0;
	$r = $ch_num - 1;
	for (;0 <= $r;$r--) {
		$row_dama = $mySumArray[$r]['tkty'] + $mySumArray[$r]['tkcp'] + $mySumArray[$r]['tklh'] + $mySumArray[$r]['tkag'] + $mySumArray[$r]['tkhg'] + $mySumArray[$r]['tkbb'] + $mySumArray[$r]['tkmg'] + $mySumArray[$r]['tkagq'] + $mySumArray[$r]['tkog'] + $mySumArray[$r]['tkpt'] + $mySumArray[$r]['tkmw'] + $mySumArray[$r]['tkmaya'] + $mySumArray[$r]['tkkg']  + $mySumArray[$r]['tkcq9'] + $mySumArray[$r]['tkmg2'] + $mySumArray[$r]['tkvr'] + $mySumArray[$r]['tkbg'] + $mySumArray[$r]['tksb'];
		$row_money = $mySumArray[$r]['chmoney'] + $mySumArray[$r]['cjmoney'] + $mySumArray[$r]['fsmoney'] + $mySumArray[$r]['othermoney'];
		$all_dama = $all_dama + $row_dama;
		$all_money = $all_money + $row_money;
		if(date('Y-m-d', strtotime('-30 day')) . ' 00:00:00' != $mySumArray[$r]['starttime']){

?>	  
		<tr align="center" onmouseover="this.style.backgroundColor='#EBEBEB'" onmouseout="this.style.backgroundColor='#ffffff'" style="background-color: rgb(255, 255, 255);"> 
		  <td><?=$ch_num -$r;?></td> 
		  <td><?=$mySumArray[$r]['starttime'];?></td> 
		  <td><?=$mySumArray[$r]['endtime'];?></td>
		  <?php if ($tkcache['tkrkflag'] == 1){?> 		  
		  <td> <?=sprintf('%.2f',$mySumArray[$r]['chmoney']);?></td> 
		  <td> <?=sprintf('%.2f',$mySumArray[$r]['cjmoney']);?></td> 
		  <td> <?=sprintf('%.2f',$mySumArray[$r]['fsmoney']);?></td> 
		  <td> <?=sprintf('%.2f',$mySumArray[$r]['othermoney']);?></td>
		  <?php 
		}
		if ($tkcache['tkdmflag'] == 1):?> 		  
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkty']);?></td> 
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkcp']);?></td> 
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tklh']);?></td> 
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkag']);?></td> 
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkagq']);?></td> 
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkbb']);?></td> 
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkhg']);?></td> 
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkog']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkmg']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkmw']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkpt']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkmaya']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkkg']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkcq9']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkmg2']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkvr']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkbg']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tksb']);?></td>
		 <?php endif;?> 		  
		  <td> <?=sprintf('%.2f',$row_dama);?></td> 
		  <td> <?=sprintf('%.2f',$row_money);?></td> 
		  <td> <?=sprintf('%.2f',$row_money==0 ? $mySumArray[$r]['tknumber'] : $row_dama .'/'. $row_money);?></td> 
		  <td>
		  <?php if ($row_money * $mySumArray[$r]['tknumber'] <= $row_dama and $row_dama!=0){?> 
		  	<span style="color:green;font-weight:900;">√</span>  <br/>
		  <?php }else{?> 
		  	<span style="color:red;font-weight:900;">×</span>  <br/>
		  <?php }?> 		  
		  </td> 
		  <td> <?=sprintf('%.2f',$all_dama);?></td> 
		  <td> <?=sprintf('%.2f',$all_money);?></td> 
		  <td> <?=sprintf('%.2f',$all_money==0 ? $mySumArray[$r]['tknumber'] : $all_dama .'/'. $all_money);?></td> 
		  <td>
		  <?php if ($all_money * $mySumArray[$r]['tknumber'] <= $all_dama and $all_dama!=0):
		  			$resultMessage = '<span style="color:green;font-weight:900;">√</span>';?> 
		  	<span style="color:green;font-weight:900;">√</span>
		<?php else:
			if($all_dama>0) $need_money = $m_value * (1 - ($all_dama / ($all_money * $mySumArray[$r]['tknumber'])));
			$resultMessage = '<span style="color:red;font-weight:900;">×</span>'; ?>
			<span style="color:red;font-weight:900;">×</span>
		<?php endif;?> 		  
		</td> 
		<td>
		<?php 
		if ($all_money * $mySumArray[$r]['tknumber'] <= $all_dama){
			$all_dama = $all_money = $need_money = 0;
		}else {
			echo sprintf('%.2f',$need_money) . '↓';
		}?> 		  
		</td>

		<?php if (0 < $mySumArray[$r]['cjmoney']):?> 		  
			<td style="background-color:#F00;" title="有彩金，是否修改打码倍数？">
			<input name="tknumber_<?=$r?>" value="<?=sprintf('%.2f',$mySumArray[$r]['tknumber'])?>" size="5" align="center" style="text-align:center;" onkeyup="clearNoNum(this);"  title="有彩金，是否修改打码倍数？"/>
			</td>
		<?php else:?> 		  
			<td><input name="tknumber_<?=$r;?>" value=" <?=sprintf('%.2f',$mySumArray[$r]['tknumber']);?>" size="5" align="center" style="text-align:center;" onkeyup="clearNoNum(this);"/></td>
		<?php endif;?> 	  
		</tr>
	<?php 
		}
	}


	?> </table> 
  <table width="98%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" align="center"> 
	  <thead style="background-color:#5E6FA4;color:#000;text-align:center;height:20px;"> 
		  <tr> 
			  <td>上一次提款时间</td> 
			  <td>第一次存汇款时间</td> 
			  <td>本次提款时间</td> 
			  <td>本次提款金额</td> 
			  <td style="background-color:green;">出款参考</td> 
			  <td style="background-color:red;">累计->打码不足需扣款</td> 
			  <td style="background-color:yellow;">实际可出款数</td> 
			  <td>操作</td> 
		  </tr> 
	  </thead> 
	  <tr style="color:#000;text-align:center;height:20px;"> 
		  <td><?=$last_tk_time;?></td> 
		  <td><?=$mySumArray[$ch_num - 2]['starttime'];?></td> 
		  <td><?=$m_make_time;?></td> 
		  <td> <?=sprintf('%.2f',$m_value);?></td> 
		  <td><?=$resultMessage;?></td> 
		  <td> <?=sprintf('%.2f',$need_money);?></td> 
		  <td> <?=sprintf('%.2f',$m_value - $need_money - $special_need_money);?></td> 
		  <td><input type="submit" value="重新审核" style="cursor:pointer;"></td> 
	  </tr> 
  </table> 
  </form> 
  <p style="font-size:13p;">&nbsp;&nbsp;<a href="tkrule.html" target="_blank" style="font-size: 13px;">查看规则</a></p><?php }?>