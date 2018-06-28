<?php 
include_once '../../cache/tkcache.php';
//以下时间均为美东时间
if (($tkcache['tkswitch'] == 1) && ($rows['type'] == 2) && ($rows['status'] == 2)){
	$m_id = $rows['m_id'];
	$username = $rows['username'];
	$ag_name = $rows['agUserName'];
	$agq_name = $rows['agqUserName'];
	$bb2_name = $rows['bbin2UserName'];
	$maya_name = $rows['mayaUserName'];
	$shaba_name = $rows['shabaUserName'];
	$mw_name = $rows['mwUserName'];
	$kg_name = $rows['kgUserName'];
	$cq9_name = $rows['cq9UserName'];
	$mg2_name = $rows['mg2UserName'];
	$vr_name = $rows['vrUserName'];
	$bg_name = $rows['bgUserName'];
	$sb_name = $rows['sbUserName'];
	$pt2_name = $rows['pt2UserName'];
	$og2_name = $rows['og2UserName'];
	$dg_name = $rows['dgUserName'];
	$ky_name = $rows['kyUserName'];

	$bb_name = $rows['bbinUserName'];
	$mg_name = $rows['mgUserName'];
	$og_name = $rows['ogUserName'];
	$pt_name = $rows['ptUserName'];

	$uid = $rows['uid'];
	$username = $rows['username'];
	$m_make_time = $rows['m_make_time'];
	$m_value = abs($rows['m_value']);

	//最新提款之前有无未处理的提款
	$params = array(':uid' => $uid, ':m_make_time' => $m_make_time, ':m_id' => $m_id);
	$sql = 'select min(left(m_make_time,10)) as min_tk_time from k_money where type=2 and status=2 and uid=:uid and  m_make_time<=:m_make_time and m_id<>:m_id';
	//print_r($params);exit;
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$row = $stmt->fetch();
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

	$startArr = [];
	$endArr = [];
	$startArr2 = [];
	$endArr2 = [];

	while ($row = $stmt->fetch()){
		$starttime = $row['thetime'];
		//美东时间段
		$mainsql = $mainsql . 'select \'' . $endtime . '\' as endtime,\'' . $starttime . '\' as starttime union ';
		//北京时间段 比如六合彩
		$mainsql2 = $mainsql2 . 'select \'' . date('Y-m-d H:i:s', strtotime($endtime)+12*60*60) . '\' as endtime,\'' . date('Y-m-d H:i:s', strtotime($starttime)+12*60*60) . '\' as starttime union ';

		$startArr[] = $starttime;
		$endArr[] = $endtime;
		$startArr2[] = date('Y-m-d H:i:s', strtotime($starttime)+12*60*60);
		$endArr2[] = date('Y-m-d H:i:s', strtotime($endtime)+12*60*60);

		$mySumArray[$r]['starttime'] = $starttime;
		$mySumArray[$r]['endtime'] = $endtime;


		$mySumArray[$r]['chmoney'] = $row['money'];
		$mySumArray[$r]['cjmoney'] = $row['cjmoney'];

		$endtime = $starttime;
		$mySumArray[$r]['tknumber'] = ($_GET['tknumber_' . $r] <= 0 ? $tkcache['tknumber'] : $_GET['tknumber_' . $r]);
		$r++;
	}
	
	
	
	//

	$starttime = $last_tk_time;
	//美东时间段
	$mainsql = $mainsql . 'select \'' . $endtime . '\' as endtime,\'' . $starttime . '\' as starttime  ) t left join  ';
	//北京时间段 比如六合彩
	$mainsql2 = $mainsql2 . 'select \'' . date('Y-m-d H:i:s', strtotime($endtime)+12*60*60) . '\' as endtime,\'' . date('Y-m-d H:i:s', strtotime($starttime)+12*60*60) . '\' as starttime  ) t left join  ';

	$mySumArray[$r]['starttime'] = $starttime;
	$mySumArray[$r]['endtime'] = $endtime;

	$startArr[] = $starttime;
	$endArr[] = $endtime;
	$startArr2[] = date('Y-m-d H:i:s', strtotime($starttime)+12*60*60);
	$endArr2[] = date('Y-m-d H:i:s', strtotime($endtime)+12*60*60);
	
	$damaSql = initStr($startArr, $endArr);
	$damaSql2 = initStr($startArr2, $endArr2);
	
	
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
			$where = 'lose_ok=1 and status in (1,2,4,5)  and bet_time>=:q_btime and bet_time<=:q_etime and uid=:uid';
			$sql = damaSql(['table'=>'k_bet','money'=>'bet_money','time'=>'bet_time','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkty'] = $row['validmoney'];
			}

			$where = 'gid>0 and status=1 and bet_time>=:q_btime and bet_time<=:q_etime and uid=:uid';
			$sql = damaSql(['table'=>'k_bet_cg_group','money'=>'bet_money','time'=>'bet_time','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkty'] += $row['validmoney'];
			}
		
			if($ag_name != ''){
				$params = array();
				$params[':q_btime'] = $last_tk_time;
				$params[':q_etime'] = $m_make_time;
				$params[':zr_username'] = $ag_name;
				$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
				$sql = damaSql(['table'=>'sbtabetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$r = array_search($row['starttime'], $startArr);
					$mySumArray[$r]['tkty'] += $row['validmoney'];
				}
			}

			if($shaba_name != ''){
				//沙巴体育
				$params = array();
				$params[':q_btime'] = $last_tk_time;
				$params[':q_etime'] = $m_make_time;
				$params[':zr_username'] = $shaba_name;
				$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
				$sql = damaSql(['table'=>'shababetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$r = array_search($row['starttime'], $startArr);
					$mySumArray[$r]['tkty'] += $row['validmoney'];
				}
			}
		}


		if ($tkcache['tkcp'] == 1)
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':username'] = $username;
			$where = 'money>0 and js=1 and win<>0 and addtime>=:q_btime and addtime<=:q_etime and username=:username';
			$sql = damaSql(['table'=>'c_bet','money'=>'money','time'=>'addtime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkcp'] = $row['validmoney'];
			}
			
			$where = 'money>0 and js=1 and win<>0 and addtime>=:q_btime and addtime<=:q_etime and username=:username';
			$sql = damaSql(['table'=>'c_bet_3','money'=>'money','time'=>'addtime','where'=>$where],$damaSql);			
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkcp'] += $row['validmoney'];
			}
			
			$where = 'money>0 and bet_ok=1 and win<>0 and bet_time>=:q_btime  and bet_time<=:q_etime and username=:username';
			$sql = damaSql(['table'=>'lottery_data','money'=>'money','time'=>'bet_time','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkcp'] += $row['validmoney'];
				
			}
			
			$where = 'money>0 and status=1 and win<>0 and FROM_UNIXTIME(addtime, "%Y-%m-%d %H:%i:%S")>=:q_btime and FROM_UNIXTIME(addtime, "%Y-%m-%d %H:%i:%S")<=:q_etime and uid=:uid ';
			$sql = damaSql(['table'=>'c_bet_data','money'=>'money/100','time'=>'FROM_UNIXTIME(addtime, "%Y-%m-%d %H:%i:%S")','where'=>$where],$damaSql);
			
			$stmt = $mydata1_db->prepare($sql);
			unset($params[':username']);
			$params[':uid'] = $uid;
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkcp'] += $row['validmoney'];
			}
			
		}


		
		if ($tkcache['tklh'] == 1)
		{
			$params = array();
			$params[':q_btime'] = $cn_q_btime;
			$params[':q_etime'] = $cn_q_etime;
			$params[':username'] = $username;

			$where = 'checked=1 and bm<>2 and adddate>=:q_btime and adddate<=:q_etime and username=:username';
			$sql = damaSql(['table'=>'mydata2_db.ka_tan','money'=>'sum_m','time'=>'adddate','where'=>$where],$damaSql2);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$row['starttime'] = date('Y-m-d H:i:s',strtotime($row['starttime'])- 12*3600);
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tklh'] = $row['validmoney'];
			}
			
		}

		if (($tkcache['tkag'] == 1) && ($ag_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $ag_name;
			$tkag_sum = 0;
			//agin
			
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'aginbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkag'] = $row['validmoney'];
			}
			

			//xin
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'xinbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkag'] = $row['validmoney'];
			}

			
			//yoplay
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'yoplaybetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkag'] = $row['validmoney'];
			}
			
			//bg
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'bgbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkag'] = $row['validmoney'];
			}
		}
		if (($tkcache['tkagq'] == 1) && ($agq_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $agq_name;

			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'agbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkagq'] = $row['validmoney'];
			}			
		}
		if (($tkcache['tkvr'] == 1) && ($vr_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $vr_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'vrbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkvr'] = $row['validmoney'];
			}			
		}
		if (($tkcache['tkbg'] == 1) && ($bg_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $bg_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'bglivebetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkbg'] = $row['validmoney'];
			}			
		}
		if (($tkcache['tkdg'] == 1) && ($dg_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $dg_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'dgbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkdg'] = $row['validmoney'];
			}
		}
		if (($tkcache['tkky'] == 1) && ($ky_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $ky_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'kybetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkky'] = $row['validmoney'];
			}
		}
		if (($tkcache['tkbbin2'] == 1) && ($bb2_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $bb2_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'bbin2betdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkbbin2'] = $row['validmoney'];
			}
		}

		if (($tkcache['tkmg2'] == 1) && ($mg2_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $mg2_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'mg2betdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkmg2'] = $row['validmoney'];
			}
		}

		if (($tkcache['tkpt2'] == 1) && ($pt2_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $pt2_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'pt2betdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkpt2'] = $row['validmoney'];
			}
		}

		if (($tkcache['tkog2'] == 1) && ($og2_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $og2_name;

			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'og2betdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkog2'] = $row['validmoney'];
			}
		}

		if (($tkcache['tkmw'] == 1) && ($mw_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $mw_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'mwbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkmw'] = $row['validmoney'];
			}
		}
		if (($tkcache['tkkg'] == 1) && ($kg_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $kg_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'kgbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkkg'] = $row['validmoney'];
			}
		}
		
		if (($tkcache['tksb'] == 1) && ($sb_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $sb_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'sbbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tksb'] = $row['validmoney'];
			}
		}
		if (($tkcache['tkcq9'] == 1) && ($cq9_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $cq9_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'cq9betdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkcq9'] = $row['validmoney'];
			}
		}

		if (($tkcache['tkmaya'] == 1) && ($maya_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $maya_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'mayabetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkmaya'] = $row['validmoney'];
			}		
		}

		if (($tkcache['tkbb'] == 1) && ($bb_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $bb_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'bbbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkbb'] = $row['validmoney'];
			}
		}
		if (false && ($tkcache['tkog'] == 1) && ($og_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $og_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'ogbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkog'] = $row['validmoney'];
			}
		}

		if (($tkcache['tkmg'] == 1) && ($mg_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $mg_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'mgbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkmg'] = $row['validmoney'];
			}
		}
		if (false && ($tkcache['tkpt'] == 1) && ($pt_name != ''))
		{
			$params = array();
			$params[':q_btime'] = $last_tk_time;
			$params[':q_etime'] = $m_make_time;
			$params[':zr_username'] = $pt_name;
			$where = 'betTime>=:q_btime and betTime<=:q_etime and flag="已结算" and playerName=:zr_username';
			$sql = damaSql(['table'=>'ptbetdetail','money'=>'validBetAmount','time'=>'betTime','where'=>$where],$damaSql);
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$r = array_search($row['starttime'], $startArr);
				$mySumArray[$r]['tkpt'] = $row['validmoney'];
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
	}
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
	{?> 			  <td colspan="20">打码量</td><?php }?> 			  <td colspan="4">当次审核</td> 
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
			  <td>新BBIN</td>
			  <td>新PT</td>
			  <td>新OG</td>
			  <td>MW</td>
			  <td>MAYA</td> 
			  <td>AV</td>
			  <td>CQ9</td>
			  <td>新MG</td>
			  <td>VR</td>
			  <td>BG</td>
			  <td>SB</td>
			  <td>DG</td>
			  <td>开元</td>
			  <td>BBIN</td>
			  <td>MG</td>
			  <!--td>OG</td>
			  <td>PT</td-->
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
	for (;0 <= $r;$r--){
		$row_dama = $mySumArray[$r]['tkty'] + $mySumArray[$r]['tkcp'] + $mySumArray[$r]['tklh'] + $mySumArray[$r]['tkag'] + $mySumArray[$r]['tkbb'] + $mySumArray[$r]['tkagq'] + $mySumArray[$r]['tkmw'] + $mySumArray[$r]['tkmaya'] + $mySumArray[$r]['tkkg']  + $mySumArray[$r]['tkcq9'] + $mySumArray[$r]['tkmg2'] + $mySumArray[$r]['tkvr'] + $mySumArray[$r]['tkbg'] + $mySumArray[$r]['tksb'] + $mySumArray[$r]['tkpt2'] + $mySumArray[$r]['tkog2'] + $mySumArray[$r]['tkdg'] + $mySumArray[$r]['tkky'] + $mySumArray[$r]['tkbbin2'] + $mySumArray[$r]['tkmg'] + $mySumArray[$r]['tkog'];
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
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkbbin2']);?></td> 
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkpt2']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkog2']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkmw']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkmaya']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkkg']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkcq9']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkmg2']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkvr']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkbg']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tksb']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkdg']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkky']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkbb']);?></td> 
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkmg']);?></td>
			<!--td> <?=sprintf('%.2f',$mySumArray[$r]['tkog']);?></td>
			<td> <?=sprintf('%.2f',$mySumArray[$r]['tkpt']);?></td-->
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
  <p style="font-size:13p;">&nbsp;&nbsp;<a href="tkrule.html" target="_blank" style="font-size: 13px;">查看规则</a></p><?php }



function damaSql($data, $sql){
    $sql = str_replace("[table]",$data['table'], $sql);
    $sql = str_replace("[money]",$data['money'], $sql);
    $sql = str_replace("[where]",$data['where'], $sql);
    $sql = str_replace("[time]",$data['time'], $sql);
    return $sql;
}

function initStr($arrStart, $arrEnd){
	sort($arrStart);
	sort($arrEnd);
    $endStr = $startStr = $intervalStr = '';
    for($i=0;$i<count($arrEnd);$i++){
        $intervalStr .= "UNIX_TIMESTAMP('{$arrEnd[$i]}'),"; 
        $startStr .= "'{$arrStart[$i]}',";
        $endStr .= "'{$arrEnd[$i]}',";
    }
    $intervalStr = "INTERVAL(UNIX_TIMESTAMP([time]),0,".rtrim($intervalStr, ',').")" ; 
    $startStr = "elt({$intervalStr},".rtrim($startStr, ',').")";
    $endStr = "elt({$intervalStr},".rtrim($endStr, ',').")";
    $sql = "select {$startStr} as starttime,{$endStr} as endtime, sum([money]) as validmoney from [table] where [where]";
    $end = " group by {$endStr} order by endtime desc";
    return $sql.$end;
}

  ?>