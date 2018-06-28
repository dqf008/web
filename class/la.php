<?php 
class la{
	static public function ip_la()	{
		global $mydata1_db;
		$C_Patch = $_SERVER['DOCUMENT_ROOT'];
		include_once $C_Patch . '/common/commonfun.php';
		$ip = get_client_ip();
		$params = array(':ip' => $ip, ':today' => date('Y-m-d') . '%');
		$sql = 'select id from mydata3_db.ip_la where ip=:ip and today like(:today) limit 1';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$r_id = $stmt->fetchColumn();
		if (0 < $r_id)		{
			$params = array(':id' => $r_id);
			$sql = 'update mydata3_db.ip_la set his=his+1 where id=:id';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}else{
			include_once '../ip.php';
			$ClientSity = iconv('GB2312', 'UTF-8', convertip($ip, '../'));
			$browser = $_SERVER['HTTP_USER_AGENT'];
			if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0'))
			{
				$browser = 'Internet Explorer 8.0';
			}
			else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0'))
			{
				$browser = 'Internet Explorer 7.0';
			}
			else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0'))
			{
				$browser = 'Internet Explorer 6.0';
			}
			else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/3'))
			{
				$browser = 'Firefox 3';
			}
			else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/2'))
			{
				$browser = 'Firefox 2';
			}
			else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
			{
				$browser = 'Google Chrome';
			}
			else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari'))
			{
				$browser = 'Safari';
			}
			else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
			{
				$browser = 'Opera';
			}
			else if (strpos($_SERVER['HTTP_USER_AGENT'], 'TheWorld'))
			{
				$browser = 'TheWorld';
			}
			include '../cache/conf.php';
			$params = array(':ip' => $ip, ':ip_address' => $ClientSity, ':website' => $conf_www, ':browser' => $browser);
			$sql = 'insert into mydata3_db.ip_la (ip,ip_address,website,today,browser) VALUES (:ip,:ip_address,:website,now(),:browser)';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
	}
}
?>