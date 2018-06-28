<?php function logintu($uid)
{
	$uid = intval($uid);
	if (0 < $uid)
	{
		global $mydata1_db;
		$mydata1_db->exec('update k_user set logout_time=now() where uid=\'' . $uid . '\'');
		$mydata1_db->exec('update `k_user_login` set `is_login`=0 WHERE `uid`=\'' . $uid . '\' and `is_login`>0');
		$time = time() - 3600;
		$params = array(':login_time' => $time);
		$stmt = $mydata1_db->prepare('update `k_user_login` set `is_login`=0 WHERE login_time<:login_time and `is_login`>0');
		$stmt->execute($params);
	}
	return true;
}
function renovate($uid, $loginid)
{
	if ($uid && $loginid)
	{
		global $mydata1_db;
		$params = array(':uid' => $uid, ':login_id' => $loginid);
		$stmt = $mydata1_db->prepare('select id from `k_user_login` where `uid`=:uid and `login_id`=:login_id and `is_login`=0 limit 1');
		$stmt->execute($params);
		$query_uid = $stmt->fetchColumn();
		if (0 < $query_uid)
		{
			$params = array(':uid' => $uid);
			$stmt = $mydata1_db->prepare('update `k_user_login` set `is_login`=0 where `uid`=:uid');
			$stmt->execute($params);
			session_destroy();?><script>top.location.href='/'</script><?php exit();
		}
	}
	return true;
}
function sessionNum($uid, $type, $cal = '')
{
	if (!$_SESSION['sessionIf'])
	{
		$_SESSION['sessionIf'] = 1;
		$_SESSION['sessionTime'] = time();
		$_SESSION['3ssessionIf'] = 1;
		$_SESSION['3ssessionTime'] = time();
	}
	$time3 = time() - $_SESSION['3ssessionTime'];
	if ('60' <= $time3)
	{
		$_SESSION['3ssessionIf'] = '0';
		$_SESSION['3ssessionTime'] = time();
	}
	if ($_SESSION['3ssessionIf'] <= '50')
	{
		$_SESSION['3ssessionIf'] = $_SESSION['3ssessionIf'] + 1;
	}
	else
	{
		global $mydata1_db;
		$params = array(':uid' => $uid);
		$stmt = $mydata1_db->prepare('update `k_user` set `is_stop`=1 where uid=:uid');
		$stmt->execute($params);
		@(session_destroy());
	}
	$time = time() - $_SESSION['sessionTime'];
	if ('30' <= $time)
	{
		$_SESSION['sessionIf'] = '0';
		$_SESSION['sessionTime'] = time();
	}
	if ($_SESSION['sessionIf'] <= 25)
	{
		$_SESSION['sessionIf'] = $_SESSION['sessionIf'] + 1;
	}
	else
	{
		$_SESSION['sessionTime'] = time();
		if ($type == 3)
		{?> <div id="location"  style='line-height:40px;text-align:center;color:#666;border-bottom:1px solid #999;'>对不起,您点击页面太快,请在60秒后进行操作</div><script>check();</script><?php }
		else if ($type == 4)
		{
			$json['zq'] = 0;
			$json['zq_ds'] = 0;
			$json['zq_gq'] = 0;
			$json['zq_sbc'] = 0;
			$json['zq_sbbd'] = 0;
			$json['zq_bd'] = 0;
			$json['zq_rqs'] = 0;
			$json['zq_bqc'] = 0;
			$json['zq_jg'] = 0;
			$json['zqzc'] = 0;
			$json['zqzc_ds'] = 0;
			$json['zqzc_sbc'] = 0;
			$json['zqzc_sbbd'] = 0;
			$json['zqzc_bd'] = 0;
			$json['zqzc_rqs'] = 0;
			$json['zqzc_bqc'] = 0;
			$json['lm'] = 0;
			$json['lm_ds'] = 0;
			$json['lm_dj'] = 0;
			$json['lm_gq'] = 0;
			$json['lm_jg'] = 0;
			$json['lmzc'] = 0;
			$json['lmzc_ds'] = 0;
			$json['lmzc_dj'] = 0;
			$json['wq'] = 0;
			$json['wq_ds'] = 0;
			$json['wq_bd'] = 0;
			$json['wq_jg'] = 0;
			$json['pq'] = 0;
			$json['pq_ds'] = 0;
			$json['pq_bd'] = 0;
			$json['pq_jg'] = 0;
			$json['bq'] = 0;
			$json['bq_ds'] = 0;
			$json['bq_zdf'] = 0;
			$json['bq_jg'] = 0;
			$json['bqzc'] = 0;
			$json['bqzc_ds'] = 0;
			$json['bqzc_zdf'] = 0;
			$json['gj'] = 0;
			$json['gj_gj'] = 0;
			$json['gj_gjjg'] = 0;
			$json['gj_jg'] = 0;
			$json['jr'] = 0;
			$json['jr_jr'] = 0;
			$json['jr_jrjg'] = 0;
			$json['jr_jg'] = 0;
			$json['tz_money'] = '0 RMB';
			$json['user_money'] = '0 RMB';
			$json['user_num'] = 0;
 echo $cal ;?>(<?=json_encode($json) ;?>);<?php }
		else
		{
			$json['fy']['p_page'] = 'error2';
 echo $type ;?>(<?=json_encode($json) ;?>);<?php }
		exit();
	}
	return true;
}
function sessionBet($uid)
{
	if (!$_SESSION['bets'])
	{
		$_SESSION['bets'] = 0;
		$_SESSION['betTime'] = time();
	}
	$time3 = time() - $_SESSION['betTime'];
	if ('15' <= $time3)
	{
		$_SESSION['bets'] = '0';
		$_SESSION['betTime'] = time();
	}
	if (@($_SESSION['betif']) != '')
	{
		if ('30' <= $time3)
		{
			$_SESSION['bets'] = '0';
			$_SESSION['betTime'] = time();
			$_SESSION['betif'] = '';
		}
	}
	if ($_SESSION['bets'] < 10)
	{
		$_SESSION['bets'] = $_SESSION['bets'] + 1;
	}
	else
	{
		$_SESSION['betTime'] = time();
		$_SESSION['betif'] = rand(100000, 999999);?><div class="pollbox" id ="idcs"> 
			        <p style="text-align:center"></p> 
				    <p style=" text-align:center"></p> 
				    <p style="font-size:12px;"><font style="color:red;text-align:center;">）：您点击次数太快了..<br />为了保证网站数据安全..<br />请您稍等<span id='miao'>30</span>秒后再操作..</font></p></div> 

	  <script language="javascript"> 

		  var i = 31;

		  var timeouts;

		  clearTimeout(timeouts);

		  checkidcs();

		  function checkidcs(){ 

			  i = i-1;

			  document.getElementById('miao').innerHTML  	  = '';

			  document.getElementById('miao').innerHTML  	  =i;

			  if(i == 0){ 

			  clearTimeout(timeouts);

				  document.getElementById('bet_moneydiv').style.display='none';

				  document.getElementById('idcs').style.display='none';

				  document.getElementById('maxmsg_div').style.display='none';

			  }else{ 

				  timeouts=setTimeout("checkidcs()",1000);

			  } 
		  } 

  </script><?php exit();
	}
	return true;
}
function investSZ($uid = '')
{
	if (!$_SESSION['investValue'])
	{
		$_SESSION['investValue'] = 0;
		$_SESSION['investTime'] = time();
	}
	$time = time() - $_SESSION['investTime'];
	if ('5' <= $time)
	{
		$_SESSION['investValue'] = '0';
		$_SESSION['investTime'] = time();
	}
	if ($_SESSION['investValue'] <= 2)
	{
		$_SESSION['investValue'] = $_SESSION['investValue'] + 1;
		return $_SESSION['investValue'];
	}
	else
	{
		$_SESSION['investTime'] = time();
		return $_SESSION['investValue'];
	}
}
function islogin_match($uid)
{
	if ($uid)
	{
		return true;
	}
	else
	{
		session_destroy();?><script>window.location.href='left.php';</script><?php exit();
	}
}?>