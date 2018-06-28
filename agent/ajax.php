<?php
header('Content-Type: application/json');
include(dirname(__FILE__).'/include/common.php');

$output = [
	'errorMsg' => 'Access denied',
	'errorCode' => 2,
];

$action = isset($_POST['action'])&&!empty($_POST['action'])?$_POST['action']:'default';

switch ($action) {
	case 'login':
		// $cookiePath = dirname($_SERVER['REQUEST_URI']);
		$output['isForzen'] = false;
		$randCode = isset($_SESSION['randcode'])?$_SESSION['randcode']:null;
		$failCount = isset($_COOKIE['failCount'])?intval($_COOKIE['failCount']):0;
		$checkCode = function($check=true){
			$return = $check;
			if(!$check||$GLOBALS['failCount']>=3){
				unset($_SESSION['randcode']);
				$return = !empty($GLOBALS['randCode'])&&isset($_POST['checkCode'])&&$GLOBALS['randCode']==strtolower($_POST['checkCode']);
			}
			return $return;
		};
		include IN_AGENT.'../common/function.php';
		switch (false) {
			case $checkCode():
				$output['errorMsg'] = '请输入正确的验证码';
				break;
			case isset($_POST['MemberName']):
			case isset($_POST['Pwd']):
			case $stmt = $mydata1_db->prepare('SELECT `uid`, `username`, `password`, `is_daili` FROM `k_user` WHERE `username`=:username AND `is_delete`=0 AND `is_stop`=0 LIMIT 1'):
			case $stmt->execute([':username' => htmlEncode($_POST['MemberName'])]):
			case $stmt->rowCount()>0:
			case $rows = $stmt->fetch():
				$output['errorMsg'] = '用户名或密码错误';
				$failCount++;
				if($failCount>=3){
					$output['errorCode'] = 6;
				}
				setcookie('failCount', $failCount, 0, '/');
				break;
			case $rows['is_stop']==0:
				$output['errorMsg'] = '账户异常无法登陆';
				$output['isForzen'] = true;
				break;
			default:
				$valid_login = $rows['password']==md5($_POST['Pwd']);
				$is_daili = $rows['is_daili']==1;
				$output['errorMsg'] = '用户名或密码错误';
				$stmt = $mydata1_db->prepare('SELECT `id`, `uid`, `default` FROM `agent_config` WHERE `uid`=:uid');
				$stmt->execute([':uid' => $rows['uid']]);
				if($stmt->rowCount()>0){
					$rows = $stmt->fetch();
					$rows['default']++;
					if($rows['default']>=3){
						$output['errorCode'] = 6;
						if($rows['default']>3&&!$checkCode(false)){
							$valid_login = false;
							$output['errorMsg'] = '请输入正确的验证码';
						}
					}
					if($is_daili&&$valid_login){
						$mydata1_db->query('UPDATE `agent_config` SET `default`=0 WHERE `id`='.$rows['id']);
					}else if($rows['default']<=3){
						$mydata1_db->query('UPDATE `agent_config` SET `default`=`default`+1 WHERE `id`='.$rows['id']);
					}
				}else if(!$valid_login){
					$stmt = $mydata1_db->prepare('INSERT INTO `agent_config` (`uid`, `tid`, `username`, `default`, `value`) VALUES (:uid, 0, :username, 1, NULL)');
					$stmt->execute([
						':uid' => $rows['uid'],
						':username' => $rows['username'],
					]);
				}
				if($valid_login){
					include IN_AGENT.'../class/user.php';
					user::login(htmlEncode($_POST['MemberName']), htmlEncode($_POST['Pwd']));
					$output['errorMsg'] = '登录成功';
					$output['errorCode'] = 0;
					setcookie('failCount', 0, 0, '/');
				}else{
					$failCount++;
					setcookie('failCount', $failCount, 0, '/');
					if($failCount>=3){
						$output['errorCode'] = 6;
					}
				}
				break;
		}
		break;

	case 'apply':
		if($AGENT['user']['login']){
			if($AGENT['user']['agent']){
				$output['errorMsg'] = '您已经成为代理';
			}else{
				$stmt = $mydata1_db->prepare('SELECT `value` FROM `agent_config` WHERE `uid`=:uid');
				$stmt->execute([':uid' => $AGENT['user']['uid']]);
				$invite = false;
				if($rows = $stmt->fetch()){
					$rows = unserialize($rows['value']);
					$invite = isset($rows['invite'])&&$rows['invite']>time();
				}
				if($invite){
					$stmt = $mydata1_db->prepare('INSERT INTO `k_user_daili` SET `uid`=:uid, `r_name`=:r_name, `mobile`=:mobile, `about`=:about, `status`=1');
					$stmt->execute([
						':uid' => $AGENT['user']['uid'],
						':r_name' => $AGENT['user']['pay_name'],
						':mobile' => $AGENT['user']['mobile'],
						':about' => '受 '.$rows['top_username'].'['.$rows['top_uid'].'] 邀请加入代理',
					]);
					$stmt = $mydata1_db->prepare('UPDATE `k_user` SET `is_daili`=1 WHERE `uid`=:uid');
					$stmt->execute([':uid' => $AGENT['user']['uid']]);
					$output['errorCode'] = 0;
					$output['errorMsg'] = '您已经成功加入代理';
				}else{
					include IN_AGENT.'../common/function.php';
					$stmt = $mydata1_db->prepare('SELECT `d_id` FROM `k_user_daili` WHERE `uid`=:uid AND `add_time` BETWEEN :stime AND :etime');
					$stmt->execute([
						':uid' => $AGENT['user']['uid'],
						':stime' => date('Y-m-d 00:00:00'),
						':etime' => date('Y-m-d 23:59:59'),
					]);
					if($stmt->fetch()){
						$output['errorMsg'] = '您今天已经提交过申请';
					// }else if(empty($AGENT['user']['pay_name'])){
					// 	$output['errorMsg'] = '请您登录会员中心设置真实名字';
					// }else if(empty($AGENT['user']['mobile'])){
					// 	$output['errorMsg'] = '请您登录会员中心设置联系电话';
					}else if(isset($_POST['msg'])&&($_POST['msg'] = htmlEncode($_POST['msg']))!=''){
						$stmt = $mydata1_db->prepare('INSERT INTO `k_user_daili` SET `uid`=:uid, `r_name`=:r_name, `mobile`=:mobile, `about`=:about');
						$stmt->execute([
							':uid' => $AGENT['user']['uid'],
							':r_name' => $AGENT['user']['pay_name'],
							':mobile' => $AGENT['user']['mobile'],
							':about' => $_POST['msg'],
						]);
						$output['errorMsg'] = '申请成功！请等待客服联系与确认';
					}else{
						$output['errorCode'] = 1;
					}
				}
			}
		}
		break;

	case 'invite':
		if($AGENT['user']['login']&&$AGENT['user']['agent']&&$AGENT['user']['invite']){
			$output['errorMsg'] = '会员状态不符合邀请规则';
			if(isset($_POST['uid'])&&!empty($_POST['uid'])){
				$stmt = $mydata1_db->prepare('SELECT `u`.`username`, `u`.`uid`, `c`.`id`, `c`.`value` FROM `k_user` AS `u` LEFT JOIN `agent_config` AS `c` ON `u`.`uid`=`c`.`uid` WHERE `u`.`uid`=:uid AND `u`.`top_uid`=:top_uid AND `u`.`is_daili`=0 AND `u`.`is_delete`=0 AND `u`.`is_stop`=0');
				$stmt->execute([
					':uid' => $_POST['uid'],
					':top_uid' => $AGENT['user']['uid'],
				]);
				if($rows = $stmt->fetch()){
					include IN_AGENT.'../class/user.php';
					$days7 = strtotime(date('Y-m-d 23:59:59').' +7 days');
					if(empty($rows['id'])){
						$stmt = $mydata1_db->prepare('INSERT INTO `agent_config` SET `uid`=:uid, `username`=:username, `value`=:value, `tid`=0');
						$stmt->execute([
							':uid' => $rows['uid'],
							':username' => $rows['username'],
							':value' => serialize([
								'invite' => $days7,
								'top_uid' => $AGENT['user']['uid'],
								'top_username' => $AGENT['user']['username'],
							]),
						]);
						$output['errorCode'] = 0;
						$output['errorMsg'] = '邀请成功';
						user::msg_add($rows['uid'], $AGENT['user']['username'], '诚邀您成为代理', '您好，'.$AGENT['user']['username'].' 诚邀您成为代理，如果您接受邀请，请在 '.date('Y-m-d H:i:s', $days7).' (美东) 之前，前往代理中心确认加入');
					}else{
						$rows['value'] = unserialize($rows['value']);
						if($rows['value']['invite']>time()){
							$output['errorMsg'] = '您已经邀请该会员，请7天后重试';
						}else{
							$rows['value']['invite'] = $days7;
							$stmt = $mydata1_db->prepare('UPDATE `agent_config` SET `value`=:value WHERE `id`=:id');
							$stmt->execute([
								':id' => $rows['id'],
								':value' => serialize($rows['value']),
							]);
							$output['errorCode'] = 0;
							$output['errorMsg'] = '邀请成功';
							user::msg_add($rows['uid'], $AGENT['user']['username'], '诚邀您成为代理', '您好，'.$AGENT['user']['username'].' 诚邀您成为代理，如果您接受邀请，请在 '.date('Y-m-d H:i:s', $days7).' (美东) 之前，前往代理中心确认加入');
						}
					}
				}
			}
		}
		break;

	case 'getstatistics':
		if($AGENT['user']['login']&&$AGENT['user']['agent']){
			$output = ['errorCode' => 0];
			$details = get_agent_details($AGENT['user']['uid'], $AGENT['user']['tid'], $AGENT['user']['team']);
			foreach($details as $key=>$val){
				$skey = substr($key, 0, 2);
				($skey=='m_'||$skey=='t_')&&$val = sprintf('%.2f', $val/100);
				$output[$key] = $val;
			}
			$output['errorMsg'] = $AGENT['user']['url'];
		}
		break;

	case 'getagentskey':
		if($AGENT['user']['team']&&$AGENT['user']['login']&&$AGENT['user']['agent']){
			if(isset($_POST['agentId'])&&!empty($_POST['agentId'])){
				$agent_ids = explode(',', $_POST['agentId']);
				$count = count($agent_ids);
				$child_ids = array_pop($agent_ids);
				foreach($agent_ids as $key=>$val){
					$val = intval($val);
					if($val>0){
						$agent_ids[$key] = $val;
					}else{
						break 2;
					}
				}
				$agent_ids = array_unique($agent_ids);
				$child_ids = explode('|', $child_ids);
				foreach($child_ids as $key=>$val){
					$val = intval($val);
					if($val>0){
						$child_ids[$key] = $val;
					}else{
						break 2;
					}
				}
				$child_ids = array_unique($child_ids);
				$check_str = $agent_ids;
				$check_str[]= implode('|', $child_ids);
				$group = $AGENT['groups'][$AGENT['user']['tid']];
				if($_POST['agentId']==implode(',', $check_str)&&$count<=count($group['child_groups'])){
					if(check_child_agent($AGENT['user']['uid'], $agent_ids, $child_ids)){
						$output['errorCode'] = 0;
						$output['errorMsg'] = get_agent_key($_POST['agentId']);
					}else{
						$output['errorMsg'] = '代理 ID 无效';
					}
				}
			}else{
				$output['errorCode'] = 0;
				$output['errorMsg'] = '';
			}
		}
		break;

	case 'getmyagent':
		if($AGENT['user']['login']&&$AGENT['user']['agent']&&$AGENT['user']['team']){
			$output = [
				'list' => [],
				'pageCount' => 0,
				'rowCount' => 0,
				'maxCount' => 10,
				'currentPage' => 1,
				'agents' => false,
			];
			$group = $AGENT['groups'][$AGENT['user']['tid']];
			$agent_count = count($group['child_groups']);
			$child_count = 1;
			if(isset($_POST['agentId'])&&!empty($_POST['agentId'])){
				$_POST['agentId'] = explode(',', $_POST['agentId']);
				foreach($_POST['agentId'] as $key=>$val){
					$val = intval($val);
					if($val>0){
						$_POST['agentId'][$key] = $val;
					}else{
						unset($_POST['agentId'][$key]);
					}
				}
				$_POST['agentId'] = array_unique($_POST['agentId']);
				$child_count+= count($_POST['agentId']);
				if($child_count<=$agent_count){
					if(check_child_agent($AGENT['user']['uid'], $_POST['agentId'])){
						$AGENT['user']['team'] = $agent_count>$child_count;
						$last_id = array_pop($_POST['agentId']);
						$params = [':uid' => $last_id];
					}else{
						break;
					}
				}else{
					break;
				}
			}else{
				$params = [':uid' => $AGENT['user']['uid']];
				$AGENT['user']['team'] = $agent_count>1;
			}
			$sql = [
				'SELECT COUNT(*) AS `count` FROM `k_user` WHERE `top_uid`=:uid AND `is_daili`=1',
				'SELECT `uid`, `username`, `pay_name` FROM `k_user` WHERE `top_uid`=:uid AND `is_daili`=1 ORDER BY `uid` DESC LIMIT :index, :limit',
			];
			if(isset($_POST['memberName'])&&!empty($_POST['memberName'])){
				$sql = str_replace(' WHERE ', ' WHERE (`username` LIKE :username1 OR `pay_name` LIKE :username2) AND ', $sql);
				$params[':username1'] = $params[':username2'] = '%'.$_POST['memberName'].'%';
			}
			$stmt = $mydata1_db->prepare($sql[0]);
			$stmt->execute($params);
			$count = $stmt->fetch();
			$output['rowCount'] = $count['count'];
			$output['pageCount'] = ceil($count['count']/$output['maxCount']);
			if(isset($_POST['page'])&&!empty($_POST['page'])){
				$_POST['page'] = intval($_POST['page']);
				if($_POST['page']>0&&$_POST['page']<=$output['pageCount']){
					$output['currentPage'] = $_POST['page'];
				}
			}
			$params[':index'] = $output['maxCount']*($output['currentPage']-1);
			$params[':limit'] = $output['maxCount'];
			$stmt = $mydata1_db->prepare($sql[1]);
			$stmt->execute($params);
			while ($rows = $stmt->fetch()) {
				$rows['reg_date'] = strtotime($rows['reg_date']);
				$rows['login_time'] = strtotime($rows['login_time']);
				$output['list'][] = [
					'uid' => $rows['uid'],
					'username' => $rows['username'],
					'fullName' => $rows['pay_name'],
					'level' => $child_count,
				];
			}
			$output['agents'] = $AGENT['user']['team'];
		}
		break;

	case 'getmymember':
		if($AGENT['user']['login']&&$AGENT['user']['agent']){
			$output = [
				'list' => [],
				'pageCount' => 0,
				'rowCount' => 0,
				'maxCount' => 15,
				'currentPage' => 1,
				'agents' => false,
			];
			$group = $AGENT['groups'][$AGENT['user']['tid']];
			$child_count = 0;
			$sql = [
				'SELECT COUNT(*) AS `count` FROM `k_user` AS `u` WHERE `u`.`top_uid`=:uid',
				'SELECT DISTINCT(`u`.`uid`), `u`.`username`, `u`.`pay_name`, `u`.`reg_date`, `u`.`login_time`, `u`.`money`, `u`.`is_stop`, `u`.`is_daili`, `l`.`is_login` FROM `k_user` AS `u` LEFT OUTER JOIN `k_user_login` AS `l` ON `u`.`uid`=`l`.`uid` WHERE `u`.`top_uid`=:uid ORDER BY `u`.`uid` DESC LIMIT :index, :limit',
			];
			if($AGENT['user']['team']&&isset($_POST['agentId'])&&!empty($_POST['agentId'])){
				if(isset($_POST['agentKey'])&&!empty($_POST['agentKey'])&&check_agent_key($_POST['agentId'], $_POST['agentKey'])){
					$_POST['agentId'] = explode(',', $_POST['agentId']);
					$child_count = count($_POST['agentId']);
					$AGENT['user']['team'] = count($group['child_groups'])>$child_count;
					$_POST['agentId'] = array_pop($_POST['agentId']);
					$_POST['agentId'] = explode('|', $_POST['agentId']);
					if(count($_POST['agentId'])>1){
						unset($params[':uid']);
						$sql = str_replace('=:uid', ' IN ('.implode(', ', $_POST['agentId']).')', $sql);
					}else{
						$params[':uid'] = $_POST['agentId'][0];
					}
				}else{
					break;
				}
			}
			if(isset($_POST['memberName'])&&!empty($_POST['memberName'])){
				$sql = str_replace(' WHERE ', ' WHERE (`u`.`username` LIKE :username1 OR `u`.`pay_name` LIKE :username2) AND ', $sql);
				$params[':username1'] = $params[':username2'] = '%'.$_POST['memberName'].'%';
			}
			if(isset($_POST['type'])&&!empty($_POST['type'])&&$_POST['type']=='agent'){
				if($AGENT['user']['team']){
					$sql = str_replace(' WHERE ', ' WHERE `u`.`is_daili`=1 AND ', $sql);
				}else{
					break;
				}
			}
			$stmt = $mydata1_db->prepare($sql[0]);
			$stmt->execute($params);
			$count = $stmt->fetch();
			$output['rowCount'] = $count['count'];
			$output['pageCount'] = ceil($count['count']/$output['maxCount']);
			if(isset($_POST['page'])&&!empty($_POST['page'])){
				$_POST['page'] = intval($_POST['page']);
				if($_POST['page']>0&&$_POST['page']<=$output['pageCount']){
					$output['currentPage'] = $_POST['page'];
				}
			}
			$params[':index'] = $output['maxCount']*($output['currentPage']-1);
			$params[':limit'] = $output['maxCount'];
			$stmt = $mydata1_db->prepare($sql[1]);
			$stmt->execute($params);
			while ($rows = $stmt->fetch()) {
				$rows['reg_date'] = strtotime($rows['reg_date']);
				$rows['login_time'] = strtotime($rows['login_time']);
				$output['list'][] = [
					'uid' => $rows['uid'],
					'username' => $rows['username'],
					'fullName' => $rows['pay_name'],
					'regTime' => date('Y-m-d H:i:s', $rows['reg_date']).'<br />'.date('Y-m-d H:i:s', $rows['reg_date']+43200),
					'loginTime' => date('Y-m-d H:i:s', $rows['login_time']).'<br />'.date('Y-m-d H:i:s', $rows['login_time']+43200),
					'money' => sprintf('%.2f', $rows['money']),
					'online' => $rows['is_login']==1,
					'available' => $rows['is_stop']!=1,
					'agent' => $AGENT['user']['team']&&$rows['is_daili']==1,
					'level' => $child_count+1,
				];
			}
			$output['agents'] = $AGENT['user']['team'];
			$output['invite'] = $child_count<=0&&$AGENT['user']['invite'];
		}
		break;

	case 'getmembermoney':
		if($AGENT['user']['login']&&$AGENT['user']['agent']){
			include IN_AGENT.'../member/function.php';
			$output = [
				'list' => [],
				'pageCount' => 0,
				'rowCount' => 0,
				'maxCount' => 15,
				'currentPage' => 1,
				'agents' => false,
			];
			$types = ['汇款记录', '存款记录', '提款记录', '人工汇款', '彩金派送', '返水派送', '其它情况'];
			$days = [7, 30, 180];
			isset($_POST['type'])||$_POST['type'] = 0;
			isset($_POST['days'])||$_POST['days'] = $days[0];
			in_array($_POST['days'], $days)||$_POST['days'] = $days[0];
			$date = strtotime(date('Y-m-d'));
			$params = [
				':uid' => $AGENT['user']['uid'],
				':stime' => date('Y-m-d 00:00:00', $date-($_POST['days']*86400)),
				':etime' => date('Y-m-d 23:59:59', $date),
			];
			switch ($_POST['type']) {
				case '2':
					$sql = [
						'SELECT COUNT(*) AS `count` FROM `huikuan` AS `m` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`m`.`uid` WHERE `u`.`top_uid`=:uid AND `m`.`adddate` BETWEEN :stime AND :etime',
						'SELECT `m`.`lsh` AS `m_order`, `m`.`date`, `m`.`bank`, `m`.`manner`, `m`.`zsjr`, `m`.`adddate` AS `m_make_time`, `m`.`money` AS `m_value`, 0 AS `sxf`, 0 AS `type`, `m`.`status`, `u`.`username` FROM `huikuan` AS `m` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`m`.`uid` WHERE `u`.`top_uid`=:uid AND `m`.`adddate` BETWEEN :stime AND :etime ORDER BY `m`.`id` DESC LIMIT :index, :limit',
					];
					break;

				case '4':
					$sql = [
						'SELECT COUNT(*) AS `count` FROM `k_money` AS `m` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`m`.`uid` WHERE `u`.`top_uid`=:uid AND `m`.`type` BETWEEN 3 AND 6 AND `m`.`m_make_time` BETWEEN :stime AND :etime',
						'SELECT `m`.`m_order`, `m`.`m_make_time`, `m`.`m_value`, `m`.`sxf`, `m`.`type`, `m`.`status`, `m`.`pay_num`, `m`.`about`, `u`.`username` FROM `k_money` AS `m` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`m`.`uid` WHERE `u`.`top_uid`=:uid AND `m`.`type` BETWEEN 3 AND 6 AND `m`.`m_make_time` BETWEEN :stime AND :etime ORDER BY `m`.`m_id` DESC LIMIT :index, :limit',
					];
					break;

				default:
					$params[':type'] = $_POST['type']>1?($_POST['type']>3?$_POST['type']-2:2):1;
					$sql = [
						'SELECT COUNT(*) AS `count` FROM `k_money` AS `m` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`m`.`uid` WHERE `u`.`top_uid`=:uid AND `m`.`type`=:type AND `m`.`m_make_time` BETWEEN :stime AND :etime',
						'SELECT `m`.`m_order`, `m`.`m_make_time`, `m`.`m_value`, `m`.`sxf`, `m`.`type`, `m`.`status`, `m`.`pay_num`, `m`.`about`, `u`.`username` FROM `k_money` AS `m` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`m`.`uid` WHERE `u`.`top_uid`=:uid AND `m`.`type`=:type AND `m`.`m_make_time` BETWEEN :stime AND :etime ORDER BY `m`.`m_id` DESC LIMIT :index, :limit',
					];
					break;
			}
			if(isset($_POST['memberName'])&&!empty($_POST['memberName'])){
				$sql = str_replace(' WHERE ', ' WHERE (`u`.`username` LIKE :username1 OR `u`.`pay_name` LIKE :username2) AND ', $sql);
				$sql1 = $sql[0];
				$sql2 = $sql[1];
				$params[':username1'] = $params[':username2'] = '%'.$_POST['memberName'].'%';
			}
			if(isset($_POST['agentId'])&&!empty($_POST['agentId'])){
				if(isset($_POST['agentKey'])&&!empty($_POST['agentKey'])&&check_agent_key($_POST['agentId'], $_POST['agentKey'])){
					$_POST['agentId'] = explode(',', $_POST['agentId']);
					$_POST['agentId'] = array_pop($_POST['agentId']);
					$_POST['agentId'] = explode('|', $_POST['agentId']);
					$count = count($_POST['agentId']);
					if($count>1){
						unset($params[':uid']);
						$sql = str_replace('=:uid', ' IN ('.implode(', ', $_POST['agentId']).')', $sql);
					}else{
						$params[':uid'] = $_POST['agentId'][0];
					}
				}else{
					break;
				}
			}
			$stmt = $mydata1_db->prepare($sql[0]);
			$stmt->execute($params);
			$count = $stmt->fetch();
			$output['rowCount'] = $count['count'];
			$output['pageCount'] = ceil($count['count']/$output['maxCount']);
			if(isset($_POST['page'])&&!empty($_POST['page'])){
				$_POST['page'] = intval($_POST['page']);
				if($_POST['page']>0&&$_POST['page']<=$output['pageCount']){
					$output['currentPage'] = $_POST['page'];
				}
			}
			$params[':index'] = $output['maxCount']*($output['currentPage']-1);
			$params[':limit'] = $output['maxCount'];
			$stmt = $mydata1_db->prepare($sql[1]);
			$stmt->execute($params);
			while ($rows = $stmt->fetch()) {
				$rows['m_make_time'] = strtotime($rows['m_make_time']);
				$rows['output'] = [
					'username' => $rows['username'],
					'orderId' => $rows['m_order'],
					'orderTime' => date('Y-m-d H:i:s', $rows['m_make_time']).'<br />'.date('Y-m-d H:i:s', $rows['m_make_time']+43200),
					'money' => sprintf('%.2f', $rows['m_value']),
					'type' => $types[$rows['type']],
				];
				if($rows['type']==0){
					$rows['date'] = strtotime($rows['date']);
					$rows['output']['bankTime'] = date('Y-m-d H:i:s', $rows['date']-43200).'<br />'.date('Y-m-d H:i:s', $rows['date']);
					$rows['output']['bank'] = $rows['bank'];
					$rows['output']['bankType'] = $rows['manner'];
					$rows['output']['bankFee'] = sprintf('%.2f', $rows['zsjr']);
					$rows['output']['status'] = $rows['status']==1?1:($rows['status']==2?0:2);
					$rows['output']['statusText'] = $rows['status']==1?'已完成':($rows['status']==2?'订单失败':'订单审核中');
				}else{
					$rows['output']['status'] = $rows['status'];
					$rows['output']['statusText'] = $rows['status']==1?'已完成':($rows['status']==0?'订单失败':'订单审核中');
					$rows['sxf']==0||$rows['output']['fee'] = sprintf('%.2f', $rows['sxf']);
					$rows['type']<3||empty($rows['about'])||$rows['output']['about'] = $rows['about'];
					if($rows['type']==2){
						$rows['output']['money'] = sprintf('%.2f', abs($rows['m_value']));
						$rows['output']['bankCard'] = cutNum($rows['pay_num']);
					}
				}
				$output['list'][] = $rows['output'];
			}
		}
		break;

	case 'getmemberrecords':
		if($AGENT['user']['login']&&$AGENT['user']['agent']){
			$output = [
				'list' => [],
				'pageCount' => 0,
				'rowCount' => 0,
				'maxCount' => 15,
				'currentPage' => 1,
				'agents' => false,
			];
			$days = [7, 30, 180];
			isset($_POST['type'])||$_POST['type'] = 0;
			isset($_POST['days'])||$_POST['days'] = $days[0];
			in_array($_POST['days'], $days)||$_POST['days'] = $days[0];
			$etime = strtotime(date('Y-m-d 23:59:59'));
			$stime = $etime-($_POST['days']*86400)-86399;
			$params = [':uid' => $AGENT['user']['uid']];
			if(isset($_POST['type'])&&!empty($_POST['type'])){
				$_POST['gameType'] = explode('_', $_POST['type']);
				if(isset($_POST['gameType'][1])){
					$_POST['gameType'] = $_POST['gameType'][0];
					$_POST['type'] = substr($_POST['type'], strlen($_POST['gameType'])+1);
				}else{
					break;
				}
			}else{
				break;
			}
			switch ($_POST['gameType']) {
				case 'live':
					$live = include(IN_AGENT.'../cj/include/live.php');
					if(array_key_exists($_POST['type'], $live)){
						$output['maxCount'] = 20;
						$sql = [
							'SELECT COUNT(*) AS `count` FROM `daily_report` AS `d` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`d`.`uid` WHERE `u`.`top_uid`=:uid AND `d`.`platform_id`=:pid AND `d`.`report_date` BETWEEN :stime AND :etime',
							'SELECT `u`.`username`, `d`.`id`, `d`.`platform_id`, `d`.`report_date`, `d`.`rows_num`, `d`.`bet_amount`, `d`.`net_amount`, `d`.`valid_amount` FROM `daily_report` AS `d` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`d`.`uid` WHERE `u`.`top_uid`=:uid AND `d`.`platform_id`=:pid AND `d`.`report_date` BETWEEN :stime AND :etime ORDER BY `d`.`report_date` DESC, `d`.`id` DESC LIMIT :index, :limit',
						];
						$params[':pid'] = $_POST['type'];
						$params[':stime'] = $stime;
						$params[':etime'] = $etime;
						$parse_rows_data = function($rows){
							return [
								'username' => $rows['username'],
								'id' => date('Ymd_', $rows['report_date']).$rows['id'],
								'createTime' => date('Y-m-d', $rows['report_date']),
								'rowCount' => $rows['rows_num'],
								'betAmount' => sprintf('%.2f', $rows['bet_amount']/100),
								'netAmount' => sprintf('%.2f', $rows['net_amount']/100),
								'validAmount' => sprintf('%.2f', $rows['valid_amount']/100),
								'status' => '<span class="text-success">完成</span>',
							];
						};
					}else{
						break 2;
					}
					break;

				case 'sports':
					$params[':stime'] = date('Y-m-d H:i:s', $stime+43200);
					$params[':etime'] = date('Y-m-d H:i:s', $etime+43200);
					if($_POST['type']=='cg'){
						$sql = [
							'SELECT COUNT(*) AS `count` FROM `k_bet_cg_group` AS `k` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`k`.`uid` WHERE `u`.`top_uid`=:uid AND `k`.`status` BETWEEN 0 AND 4 AND `k`.`bet_time` BETWEEN :stime AND :etime',
							'SELECT `u`.`uid`, `u`.`username`, `k`.`gid`, `k`.`bet_time`, `k`.`cg_count`, `k`.`bet_money`, `k`.`bet_win`, `k`.`win`, `k`.`fs`, `k`.`status` FROM `k_bet_cg_group` AS `k` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`k`.`uid` WHERE `u`.`top_uid`=:uid AND `k`.`status` BETWEEN 0 AND 4 AND `k`.`bet_time` BETWEEN :stime AND :etime ORDER BY `k`.`gid` DESC LIMIT :index, :limit'
						];
						$parse_rows_data = function($rows){
							$rows['remark'] = [];
							$query = $GLOBALS['mydata1_db']->prepare('SELECT `bid`, `bet_info`, `match_name`, `master_guest`, `bet_time`, `MB_Inball`, `TG_Inball`, `status` FROM `k_bet_cg` WHERE `gid`=:gid ORDER BY `bid` DESC');
							$query->execute([':gid' => $rows['gid']]);
							$rows['ok_count'] = 0;
							while ($rs = $query->fetch()) {
								// 统计已结算单式
								!in_array($rs['status'], [0, 3])&&$rows['ok_count']++;
								$temp = explode('-', $rs['bet_info']);
								$remark = $temp[0].' '.$rs['match_name'];
								if(strpos($rs['bet_info'], ' - ')){
									// 篮球上半之内的,这里换成正则表达替换
									$temp[2] = $temp[2].preg_replace('[\[(.*)\]]', '',$temp[3]);
								}
								if(isset($temp[3])){
									$temp[2] = preg_replace('[\[(.*)\]]', '', $temp[2].$temp[3]);
									unset($temp[3]);
								}
								// 如果是波胆
								if(strpos($temp[0], '胆')){
									$bodan_score = explode('@', $temp[1], 2);
									$rs['score'] = $bodan_score[0];
									$temp[1] = '波胆@'.$bodan_score[1];
								}
								// 正则匹配
								$rs['team'] = explode(strpos($rs['master_guest'], 'VS.')?'VS.':'VS', $rs['master_guest']);
								preg_match('[\((.*)\)]', end($temp), $matches);
								$matches&&count($matches)>0&&$remark.= ' '.$rs['bet_time'].$matches[0];
								$remark.= '<br />';
								if(strpos($temp[1], '让')>0) { //让球
									if(strpos($temp[1], '主')===false) { //客让
										$remark.= $rs['team'][1];
										$remark.= ' '.str_replace(['主让', '客让'], ['', ''], $temp[1]).' ';
										$remark.= $rs['team'][0].'(主)';
									}else{ //主让
										$remark.= $rs['team'][0];
										$remark.= ' '.str_replace(['主让', '客让'], ['', ''],$temp[1]).' ';
										$remark.= $rs['team'][1];
									}
									$temp[1] = '';
								}else{
									$remark.= $rs['team'][0];
									$remark.= isset($rs['score'])?$rs['score']:' VS ';
									$remark.= $rs['team'][1];
								}
								$remark.= '<br />';
								if(strpos($temp[1], '@')){
									$remark.= str_replace('@', ' @ ', $temp[1]);
								}else{
									$arraynew = [$rs['team'][0], ' / ', $rs['team'][1], '和局', ' @ '];
									$arrayold = ['主', '/', '客', '和', '@'];
									$temp[1]!=''&&$remark.= $temp[1].' ';//半全场替换显示
									$remark.= str_replace($arrayold, $arraynew, preg_replace('[\((.*)\)]', '', end($temp)));
								}
								if($rs['status']==3||$rs['MB_Inball']<0){
									$remark.= ' [取消]';
								}else if($rs['status']>0){
									$remark.= ' ['.$rs['MB_Inball'].':'.$rs['TG_Inball'].']';
								}
								$rows['remark'][] = $remark;
							}
							$validAmount = 0;
							$netAmount = 0;
							if($rows['cg_count']==$rows['ok_count']){
								if(in_array($rows['status'], [1, 3])){
									$netAmount = $rows['win']-$rows['bet_money'];
									$validAmount = $rows['status']==1?$rows['bet_money']:0;
									$rows['status'] = '<span class="text-success">已结算</span>';
								}else{
									$rows['status'] = '<span class="text-info">可结算</span>';
								}
							}else{
								$rows['status'] = '等待单式';
							}
							$rows['bet_time'] = strtotime($rows['bet_time']);
							return [
								'username' => $rows['username'],
								'id' => 'Multiple_'.$rows['gid'],
								'betMode' => '体育串关 '.$rows['cg_count'].'串1',
								'remark' => implode('<hr />', $rows['remark']),
								'betAmount' => sprintf('%.2f', $rows['bet_money']),
								'winAmount' => sprintf('%.2f', $rows['bet_win']),
								'netAmount' => sprintf('%.2f', $netAmount),
								'validAmount' => sprintf('%.2f', $validAmount),
								'rewardAmount' => sprintf('%.2f', $rows['fs']),
								'betTime' => date('Y-m-d H:i:s', $rows['bet_time']-43200).'<br />'.date('Y-m-d H:i:s', $rows['bet_time']),
								'status' => $rows['status'],
							];
						};
					}else{
						$sql = [
							'SELECT COUNT(*) AS `count` FROM `k_bet` AS `k` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`k`.`uid` WHERE `u`.`top_uid`=:uid AND `k`.`status` BETWEEN 0 AND 8 AND `k`.`bet_time` BETWEEN :stime AND :etime',
							'SELECT `u`.`username`, `k`.`bid`, `k`.`bet_time`, `k`.`number`, `k`.`ball_sort`, `k`.`bet_info`, `k`.`match_name`, `k`.`match_type`, `k`.`match_time`, `k`.`match_nowscore`, `k`.`match_showtype`, `k`.`master_guest`, `k`.`status`, `k`.`point_column`, `k`.`TG_Inball`, `k`.`MB_Inball`, `k`.`match_id`, `k`.`lose_ok`, `k`.`bet_money`, `k`.`bet_win`, `k`.`win`, `k`.`fs` FROM `k_bet` AS `k` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`k`.`uid` WHERE `u`.`top_uid`=:uid AND `k`.`status` BETWEEN 0 AND 8 AND `k`.`bet_time` BETWEEN :stime AND :etime ORDER BY `k`.`bid` DESC LIMIT :index, :limit',
						];
						$parse_rows_data = function($rows){
							$rows['match_showtype'] = strtolower($rows['match_showtype']);
							$temp = explode('-', $rows['bet_info']);
							if(isset($temp[3])){
								$temp[2] = preg_replace('[\[(.*)\]]', '', $temp[2].$temp[3]);
								unset($temp[3]);
							}
							// 如果是波胆
							if(strpos($temp[0], '胆')){
								$bodan_score = explode('@', $temp[1], 2);
								$rows['score'] = $bodan_score[0];
								$temp[1] = '波胆@'.$bodan_score[1];
							}
							$is_other = in_array($rows['ball_sort'], ['冠军', '金融']);
							$rows['remark'] = $rows['match_name'];
							if($rows['match_type']==2){
								$rows['remark'].= ' '.$rows['match_time'];
								if(strpos($rows['ball_sort'], '滚球')==false){
									if($rows['match_nowscore']==''){
										$rows['remark'].= ' (0:0)';
									}else if($rows['match_showtype']=='h'){
										$rows['remark'].= ' ('.$rows['match_nowscore'].')';
									}else{
										$rows['remark'].= ' ('.strrev($rows['match_nowscore']).')';
									}
								}
							}
							$rows['remark'].= '<br />';
							$rows['team'] = explode(strpos($rows['master_guest'],'VS.')?'VS.':'VS', $rows['master_guest']);
							if(strpos($temp[1], '让')>0){
								if($rows['match_showtype']=='c'){
									$rows['remark'].= $rows['team'][1];
									$rows['remark'].= ' '.str_replace(['主让', '客让'], ['', ''], $temp[1]).' ';
									$rows['remark'].= $rows['team'][0].'(主)';
								}else{ //主让
									$rows['remark'].= $rows['team'][0];
									$rows['remark'].= ' '.str_replace(['主让', '客让'], ['', ''], $temp[1]).' ';
									$rows['remark'].= $rows['team'][1];
								}
								$temp[1] = '';
							}else{
								$rows['remark'].= $rows['team'][0];
								if(isset($rows['score'])){
									$rows['remark'].= ' '.$rows['score'].' ';
								}else if($rows['team'][1]!=''){
									$rows['remark'].= ' VS ';
								}
								$rows['remark'].= $rows['team'][1];
							}
							$rows['remark'].= '<br />';
							//半全场替换显示
							if($is_other){
								$rows['remark'].= str_replace('@', ' @ ', $rows['bet_info']);
							}else{
								$arraynew = [$rows['team'][0], $rows['team'][1], '和局', ' / ', '局'];
								$arrayold = ['主', '客', '和', '/', '局局'];
								$ss = str_replace($arrayold, $arraynew, preg_replace('[\((.*)\)]', '', end($temp)));
								$ss = explode('@', $ss);
								if($ss[0]=='独赢'){
									$rows['remark'].= $temp[1].' ';
								}else if(strpos($ss[0], '独赢')){
									$rows['remark'].= $temp[1].'-';
								}
								$rows['remark'].= str_replace(' ', '', $ss[0]);
								if($rows['match_nowscore']!=''){
									if($rows['match_showtype']=='h'||(!strrpos($temp[0], '球'))){
										$rows['remark'].= ' ('.$rows['match_nowscore'].')';
									}else{
										$rows['remark'].= ' ('.strrev($rows['match_nowscore']).')';
									}
								}
								$rows['remark'].= ' @ '.$ss[1];
							}
							if(!in_array($rows['status'], [0, 3, 7, 6])){
								if($rows['match_showtype']=='c'&&strpos('&match_ao,match_ho,match_bho,match_bao&', $rows['point_column'])>0){
									$rows['remark'].= ' ['.$rows['TG_Inball'].':'.$rows['MB_Inball'].']';
								}else if($is_other){
									if(!isset($match_result[$rows['match_id']])){
										$match_result[$rows['match_id']] = '';
										$query = $GLOBALS['mydata1_db']->query('SELECT `x_result` FROM `mydata4_db`.`t_guanjun` WHERE `match_id`='.$rows['match_id']);
										if($query->rowCount()>0){
											$rs = $query->fetch();
											$match_result[$rows['match_id']] = str_replace('<br>', ' ', $rs['x_result']);
										}
									}
									if($match_result[$rows['match_id']]!=''){
										$rows['remark'].= ' ['.$match_result[$rows['match_id']].']';
									}
								}else{
									$rows['remark'].= ' ['.$rows['MB_Inball'].':'.$rows['TG_Inball'].']';
								}
							}
							if($rows['ball_sort']=='足球滚球'||$rows['ball_sort']=='足球上半场滚球'||$rows['ball_sort']=='篮球滚球'){
								if($rows['lose_ok']==0){
									$rows['remark'].= ' <span class="text-info">[确认中]</span>';
								}else if($rows['status']==0){
									$rows['remark'].= ' <span class="text-success">[已确认]</span>';
								}
							}
							$status = [
								'未结算',
								'<span class="text-success">赢</span>',
								'<span class="text-danger">输</span>',
								'<span class="text-warning">注单无效</span>',
								'<span class="text-success">赢一半</span>',
								'<span class="text-danger">输一半</span>',
								'<span class="text-info">进球无效</span>',
								'<span class="text-info">红卡取消</span>',
								'<span class="text-info">和局</span>',
							];
							if(in_array($rows['status'], [1, 2])){
								$validAmount = $rows['bet_money'];
								$netAmount = $rows['win']-$rows['bet_money'];
							}else if(in_array($rows['status'], [4, 5])){
								$validAmount = $rows['bet_money']/2;
								$netAmount = $rows['win']-$rows['bet_money'];
							}else{
								$validAmount = 0;
								$netAmount = 0;
							}
							$rows['bet_time'] = strtotime($rows['bet_time']);
							return [
								'username' => $rows['username'],
								'id' => $rows['match_id'].'_'.$rows['bid'],
								'betMode' => $rows['ball_sort'].($is_other?'':' '.$temp[0]),
								'remark' => $rows['remark'],
								'betAmount' => sprintf('%.2f', $rows['bet_money']),
								'winAmount' => sprintf('%.2f', $rows['bet_win']),
								'netAmount' => sprintf('%.2f', $netAmount),
								'validAmount' => sprintf('%.2f', $validAmount),
								'rewardAmount' => sprintf('%.2f', $rows['fs']),
								'betTime' => date('Y-m-d H:i:s', $rows['bet_time']-43200).'<br />'.date('Y-m-d H:i:s', $rows['bet_time']),
								'status' => $status[$rows['status']],
							];
						};
					}
					break;

				default:
					switch ($_POST['type']) {
						case 'jssc':
						case 'jsssc':
						case 'jslh':
                        case 'ffk3':
                        case 'sfk3':
                        case 'wfk3':
							$sql = [
								'SELECT COUNT(*) AS `count` FROM `c_bet_data` AS `c` LEFT JOIN `k_user` AS `u` ON `c`.`uid`=`u`.`uid` WHERE `u`.`top_uid`=:uid AND `c`.`type`=:type AND `c`.`addtime` BETWEEN :stime AND :etime AND `c`.`status` BETWEEN 0 AND 1',
								'SELECT `c`.*, `u`.`username` FROM `c_bet_data` AS `c` LEFT JOIN `k_user` AS `u` ON `c`.`uid`=`u`.`uid` WHERE `u`.`top_uid`=:uid AND `c`.`type`=:type AND `c`.`addtime` BETWEEN :stime AND :etime AND `status` BETWEEN 0 AND 1 ORDER BY `c`.`id` DESC LIMIT :index, :limit',
							];
							$params[':type'] = strtoupper($_POST['type']);
							$params[':stime'] = $stime;
							$params[':etime'] = $etime;
							$parse_rows_data = function($rows){
								$rows['value'] = unserialize($rows['value']);
								$betAmount = $rows['money']/100;
								if($rows['status']==1){
									$validAmount = $betAmount;
									if($rows['money']==$rows['win']){
										$status = '<span class="text-info">和局</span>';
										$validAmount = 0;
										$netAmount = 0;
									}else if($rows['win']>$rows['money']){
										$status = '<span class="text-success">赢</span>';
										$netAmount = $rows['win']-$rows['money'];
									}else{
										$netAmount = $rows['win'];
										$status = '<span class="text-danger">输</span>';
									}
								}else{
									$validAmount = 0;
									$netAmount = 0;
									$status = '未结算';
								}
                                if($rows['value']['class'][1]=='3THTX' && in_array($_POST['type'],array('ffk3','sfk3','wfk3'))){
                                    $rows['value']['class'][1] ='3同号通选';
                                }
                                if($rows['value']['class'][1]=='3LHTX' && in_array($_POST['type'],array('ffk3','sfk3','wfk3'))){
                                    $rows['value']['class'][1] ='3连号通选';
                                }
								return [
									'username' => $rows['username'],
									'id' => $rows['value']['qishu'].'_'.$rows['id'],
									'expect' => '第 '.$rows['value']['qishu'].' 期',
									'remark' => $rows['value']['class'][0].'【'.$rows['value']['class'][1].'】',
									'odds' => $rows['value']['odds'],
									'betAmount' => sprintf('%.2f', $betAmount),
									'netAmount' => sprintf('%.2f', $netAmount/100),
									'validAmount' => sprintf('%.2f', $validAmount),
									'betTime' => date('Y-m-d H:i:s', $rows['addtime']).'<br />'.date('Y-m-d H:i:s', $rows['addtime']+43200),
									'status' => $status,
								];
							};
							break;

						case 'shssl':
						case 'pl3':
						case '3d':
						case 'kl8':
						case 'qxc':
                        case 'pcdd':
                        case 'fjk3':
                        case 'jsk3':
                        case 'ahk3':
                        case 'gxk3':
                        case 'shk3':
                        case 'hbk3':
                        case 'hebk3':
                        case 'jlk3':
                        case 'gsk3':
                        case 'bjk3':
                        case 'gzk3':
                        case 'nmgk3':
                        case 'jxk3':
							$sql = [
								'SELECT COUNT(*) AS `count` FROM `lottery_data` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`username`=`c`.`username` WHERE `u`.`top_uid`=:uid AND `c`.`atype`=:type AND `c`.`bet_time` BETWEEN :stime AND :etime',
								'SELECT `u`.`username`, `c`.`id`, `c`.`mid`, `c`.`content`, `c`.`money`, `c`.`odds`, `c`.`win`, `c`.`bet_time`, `c`.`btype`, `c`.`ctype`, `c`.`dtype`, `c`.`bet_ok` FROM `lottery_data` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`username`=`c`.`username` WHERE `u`.`top_uid`=:uid AND `c`.`atype`=:type AND `c`.`bet_time` BETWEEN :stime AND :etime ORDER BY `c`.`id` LIMIT :index, :limit',
							];
							$params[':type'] = $_POST['type']=='shssl'?'ssl':$_POST['type'];
							$params[':stime'] = date('Y-m-d H:i:s', $stime);
							$params[':etime'] = date('Y-m-d H:i:s', $etime);
							$parse_rows_data = function($rows){
								$rows['bet_time'] = strtotime($rows['bet_time']);
								$betAmount = $rows['money'];
								if($rows['bet_ok']==1){
									$validAmount = $betAmount;
									$netAmount = $rows['win'];
									if($_POST['type']=='qxc'){
										if($rows['money']+$rows['win']>=0){
											$status = '<span class="text-danger">输</span>';
										}else{
											$status = '<span class="text-success">赢</span>';
										}
									}else{
										if($rows['win']==0){
											$status = '<span class="text-info">和局</span>';
											$validAmount = 0;
										}else if($rows['win']>0){
											$status = '<span class="text-success">赢</span>';
										}else{
											$status = '<span class="text-danger">输</span>';
										}
									}
								}else{
									$validAmount = 0;
									$netAmount = 0;
									$status = '未结算';
								}
								$rows['content'] = rtrim($rows['content'], ',');
								if($_POST['type']=='kl8' || $_POST['type']=='pcdd') {
                                    $remark = $rows['btype'] . '【' . $rows['content'] . '】';
                                }else if(in_array($_POST['type'],array('fjk3','jsk3','ahk3','gxk3','shk3','hbk3','hebk3','jlk3','gsk3','bjk3','gzk3','nmgk3','jxk3'))){
                                    if($rows['content']=='3THTX'){
                                        $rows['content'] ='3同号通选';
                                    }
                                    if($rows['content']=='3LHTX'){
                                        $rows['content'] ='3连号通选';
                                    }
								    $remark = $rows['btype'] . '【' . $rows['content'] . '】';
								}else if($_POST['type']=='qxc'){
									$remark = $rows['dtype'];
									if($rows['btype']=='定位'){
										$rows['ctype'] = explode('/', $rows['ctype']);
										$rows['content'].= '<br />共'.$rows['ctype'][0].'注，'.sprintf('%.2f', $rows['ctype'][1]).'/注';
									}
									$remark.= '<br />'.$rows['content'];
								}else{
									$remark = $rows['btype'].' / '.$rows['ctype'].' / '.$rows['dtype'].' / '.$rows['content'];
								}
								return [
									'username' => $rows['username'],
									'id' => $rows['mid'].'_'.$rows['id'],
									'expect' => '第 '.$rows['mid'].' 期',
									'remark' => $remark,
									'odds' => $rows['odds'],
									'betAmount' => sprintf('%.2f', $betAmount),
									'netAmount' => sprintf('%.2f', $netAmount),
									'validAmount' => sprintf('%.2f', $validAmount),
									'betTime' => date('Y-m-d H:i:s', $rows['bet_time']).'<br />'.date('Y-m-d H:i:s', $rows['bet_time']+43200),
									'status' => $status,
								];
							};
							break;

						case 'marksix':
							$sql = [
								'SELECT COUNT(*) AS `count` FROM `mydata2_db`.`ka_tan` AS `c` LEFT JOIN `mydata1_db`.`k_user` AS `u` ON `u`.`username`=`c`.`username` WHERE `u`.`top_uid`=:uid AND `c`.`adddate` BETWEEN :stime AND :etime',
								'SELECT `u`.`username`, `c`.`id`, `c`.`adddate`, `c`.`num`, `c`.`kithe`, `c`.`sum_m`, `c`.`rate`, `c`.`checked`, `c`.`bm`, `c`.`user_ds`, `c`.`class1`, `c`.`class2`, `c`.`class3` FROM `mydata2_db`.`ka_tan` AS `c` LEFT JOIN `mydata1_db`.`k_user` AS `u` ON `u`.`username`=`c`.`username` WHERE `u`.`top_uid`=:uid AND `c`.`adddate` BETWEEN :stime AND :etime ORDER BY `c`.`id` DESC LIMIT :index, :limit',
							];
							$params[':stime'] = date('Y-m-d H:i:s', $stime+43200);
							$params[':etime'] = date('Y-m-d H:i:s', $etime+43200);
							$parse_rows_data = function($rows){
								$validAmount = 0;
								if($rows['checked']==1){
									$validAmount = $rows['sum_m'];
									if($rows['bm']==2){
										$win_money = 0;
										$validAmount = 0;
										$reward = 0;
										$status = '<span class="text-info">和局</span>';
									}else if($rows['bm']==1){
										$win_money = $rows['sum_m']*($rows['rate']-1);
										$reward = ($rows['sum_m']*$rows['user_ds'])/100;
										$status = '<span class="text-success">赢</span>';
									}else{
										$win_money = -1*$rows['sum_m'];
										$reward = ($rows['sum_m']*$rows['user_ds'])/100;
										$status = '<span class="text-danger">输</span>';
									}
								}else{
									$win_money = 0;
									$reward = 0;
									$status = '未结算';
								}
								$remark = $rows['class1'];
								if($rows['class1']=='过关'){
									$rows['class2'] = explode(',', $rows['class2']);
									$rows['class3'] = explode(',', $rows['class3']);
									$rows['class4'] = [];
									foreach($rows['class2'] as $key=>$val){
										$key*= 2;
										!isset($rows['class3'][$key])&&$rows['class3'][$key] = '未知';
										!isset($rows['class3'][$key+1])&&$rows['class3'][$key+1] = '未知';
										if($val!=''){
											$rows['class4'][] = $val.' '.$rows['class3'][$key].' @ '.$rows['class3'][$key+1];
										}
									}
									$remark.= ' '.count($rows['class4']).'串1<br />'.implode('<br />', $rows['class4']);
								}else{
									$remark.= ' / '.$rows['class2'].' / '.$rows['class3'];
								}
								$rows['adddate'] = strtotime($rows['adddate']);
								return [
									'username' => $rows['username'],
									'id' => $rows['kithe'].'_'.$rows['id'],
									'expect' => '第 '.$rows['kithe'].' 期',
									'remark' => $remark,
									'odds' => $rows['rate'],
									'betAmount' => sprintf('%.2f', $rows['sum_m']),
									'netAmount' => sprintf('%.2f', $win_money),
									'validAmount' => sprintf('%.2f', $validAmount),
									'rewardAmount' => sprintf('%.2f', $reward),
									'betTime' => date('Y-m-d H:i:s', $rows['adddate']-43200).'<br />'.date('Y-m-d H:i:s', $rows['adddate']+43200),
									'status' => $status,
								];
							};
							break;

						default:
							$table_name = 'c_bet_3';
							switch ($_POST['type']) {
								case 'cqssc':
									$table_name = 'c_bet';
									$params[':type'] = '重庆时时彩';
									break;
                                case 'xjssc':
                                    $table_name ='c_bet';
                                    $params[':type'] ='新疆时时彩';
                                    break;
                                case 'tjssc':
                                    $table_name ='c_bet';
                                    $params[':type'] ='新疆时时彩';
                                    break;
								case 'xyft':
									$params[':type'] = '幸运飞艇';
									break;
								case 'gdkl10':
									$params[':type'] = '广东快乐10分';
									break;
                                case 'cqkl10':
                                    $params[':type'] = '重庆快乐10分';
                                    break;
                                case 'tjkl10':
                                    $params[':type'] = '天津快乐10分';
                                    break;
                                case 'hnkl10':
                                    $params[':type'] = '湖南快乐10分';
                                    break;
                                case 'sxkl10':
                                    $params[':type'] = '山西快乐10分';
                                    break;
                                case 'ynkl10':
                                    $params[':type'] = '云南快乐10分';
                                    break;
                                case 'gdchoose5':
                                    $params[':type'] = 'GDSYXW';
                                    $table_name = 'c_bet_choose5';
                                    break;
                                case 'sdchoose5':
                                    $params[':type'] ='SDSYXW';
                                    $table_name = 'c_bet_choose5';
                                    break;
                                case 'fjchoose5':
                                    $params[':type'] ='FJSYXW';
                                    $table_name = 'c_bet_choose5';
                                    break;
                                case 'bjchoose5':
                                    $params[':type'] ='BJSYXW';
                                    $table_name = 'c_bet_choose5';
                                    break;
                                case 'ahchoose5':
                                    $params[':type'] ='AHSYXW';
                                    $table_name = 'c_bet_choose5';
                                    break;
								default:
									$params[':type'] = '北京赛车PK拾';
									break;
							}
                            $sql              = [
                                "SELECT COUNT(*) AS `count` FROM `{$table_name}` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`c`.`uid` WHERE `u`.`top_uid`=:uid AND `c`.`type`=:type AND `c`.`addtime` BETWEEN :stime AND :etime",
                                "SELECT `u`.`username`, `c`.`id`, `c`.`addtime`, `c`.`qishu`, `c`.`mingxi_1`, `c`.`mingxi_2`, `c`.`odds`, `c`.`money`, `c`.`win`, `c`.`js` FROM `{$table_name}` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`c`.`uid` WHERE `u`.`top_uid`=:uid AND `c`.`type`=:type AND `c`.`addtime` BETWEEN :stime AND :etime ORDER BY `c`.`id` DESC LIMIT :index, :limit",
                            ];
                            $params[':stime'] = date('Y-m-d H:i:s', $stime);
                            $params[':etime'] = date('Y-m-d H:i:s', $etime);
                            $parse_rows_data  = function ($rows) {
                                $rows['addtime'] = strtotime($rows['addtime']);
                                $betAmount       = $rows['money'];
                                if ($rows['js'] == 1) {
                                    $validAmount = $betAmount;
                                    $netAmount   = $rows['win'];
                                    if ($rows['win'] == 0) {
                                        $status      = '<span class="text-info">和局</span>';
                                        $validAmount = 0;
                                    } else if ($rows['win'] > 0) {
                                        $netAmount -= $betAmount;
                                        $status    = '<span class="text-success">赢</span>';
                                    } else {
                                        $status = '<span class="text-danger">输</span>';
                                    }
                                } else {
                                    $validAmount = 0;
                                    $netAmount   = 0;
                                    $status      = '未结算';
                                }

                                return [
                                    'username'    => $rows['username'],
                                    'id'          => $rows['qishu'] . '_' . $rows['id'],
                                    'expect'      => '第 ' . $rows['qishu'] . ' 期',
                                    'remark'      => $rows['mingxi_1'] . '【' . $rows['mingxi_2'] . '】',
                                    'odds'        => $rows['odds'],
                                    'betAmount'   => sprintf('%.2f', $betAmount),
                                    'netAmount'   => sprintf('%.2f', $netAmount),
                                    'validAmount' => sprintf('%.2f', $validAmount),
                                    'betTime'     => date('Y-m-d H:i:s', $rows['addtime']) . '<br />' . date('Y-m-d H:i:s', $rows['addtime'] + 43200),
                                    'status'      => $status,
                                ];
                            };

							break;
					}
					break;
			}
			if(isset($_POST['memberName'])&&!empty($_POST['memberName'])){
				$sql = str_replace(' WHERE ', ' WHERE (`u`.`username` LIKE :username1 OR `u`.`pay_name` LIKE :username2) AND ', $sql);
				$sql1 = $sql[0];
				$sql2 = $sql[1];
				$params[':username1'] = $params[':username2'] = '%'.$_POST['memberName'].'%';
			}
			if(isset($_POST['agentId'])&&!empty($_POST['agentId'])){
				if(isset($_POST['agentKey'])&&!empty($_POST['agentKey'])&&check_agent_key($_POST['agentId'], $_POST['agentKey'])){
					$_POST['agentId'] = explode(',', $_POST['agentId']);
					$_POST['agentId'] = array_pop($_POST['agentId']);
					$_POST['agentId'] = explode('|', $_POST['agentId']);
					$count = count($_POST['agentId']);
					if($count>1){
						unset($params[':uid']);
						$sql = str_replace('=:uid', ' IN ('.implode(', ', $_POST['agentId']).')', $sql);
					}else{
						$params[':uid'] = $_POST['agentId'][0];
					}
				}else{
					break;
				}
			}
			$stmt = $mydata1_db->prepare($sql[0]);
			$stmt->execute($params);
			$count = $stmt->fetch();
			$output['rowCount'] = $count['count'];
			$output['pageCount'] = ceil($count['count']/$output['maxCount']);
			if(isset($_POST['page'])&&!empty($_POST['page'])){
				$_POST['page'] = intval($_POST['page']);
				if($_POST['page']>0&&$_POST['page']<=$output['pageCount']){
					$output['currentPage'] = $_POST['page'];
				}
			}
			$params[':index'] = $output['maxCount']*($output['currentPage']-1);
			$params[':limit'] = $output['maxCount'];
			$stmt = $mydata1_db->prepare($sql[1]);
			$stmt->execute($params);
			while ($rows = $stmt->fetch()) {
				$output['list'][] = $parse_rows_data($rows);
			}
		}
		break;

	case 'getreports':
		if($AGENT['user']['login']&&$AGENT['user']['agent']){
			$output = [
				'list' => [],
				'pageCount' => 0,
				'rowCount' => 0,
				'maxCount' => 15,
				'currentPage' => 1,
				'agents' => false,
				'formula' => '代理佣金 = 0',
				'total' => [
					'bet' => 0,
					'net' => 0,
					'valid' => 0,
					'count' => 0,
					'money' => 0,
				],
			];
			$days = [7, 30, 180];
			isset($_POST['days'])||$_POST['days'] = $days[0];
			in_array($_POST['days'], $days)||$_POST['days'] = $days[0];
			$date = strtotime(date('Y-m-d 23:59:59'))-86400;
			$params = [
				':uid' => $AGENT['user']['uid'],
				':stime' => $date-($_POST['days']*86400)-86399,
				':etime' => $date,
			];
			$group = $AGENT['groups'][$AGENT['user']['tid']];
			$child_count = 0;
			$sql = [
				'SELECT COUNT(*) AS `count` FROM `agent_cache` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`c`.`uid` WHERE `u`.`uid`=:uid AND `u`.`is_daili`=1 AND `c`.`cache_date` BETWEEN :stime AND :etime',
				'SELECT `c`.*, `u`.`username` FROM `agent_cache` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`c`.`uid` WHERE `u`.`uid`=:uid AND `u`.`is_daili`=1 AND `c`.`cache_date` BETWEEN :stime AND :etime ORDER BY `c`.`cache_date` DESC LIMIT :index, :limit',
			];
			if($AGENT['user']['team']&&isset($_POST['agentId'])&&!empty($_POST['agentId'])){
				if(isset($_POST['agentKey'])&&!empty($_POST['agentKey'])&&check_agent_key($_POST['agentId'], $_POST['agentKey'])){
					$_POST['agentId'] = explode(',', $_POST['agentId']);
					$child_count = count($_POST['agentId']);
					$AGENT['user']['team'] = count($group['child_groups'])>$child_count;
					$_POST['agentId'] = array_pop($_POST['agentId']);
					$_POST['agentId'] = explode('|', $_POST['agentId']);
					if(count($_POST['agentId'])>1){
						unset($params[':uid']);
						$sql = str_replace('=:uid', ' IN ('.implode(', ', $_POST['agentId']).')', $sql);
					}else{
						$params[':uid'] = $_POST['agentId'][0];
					}
				}else{
					break;
				}
			}
			if(isset($_POST['memberName'])&&!empty($_POST['memberName'])){
				$sql = str_replace(' WHERE ', ' WHERE (`u`.`username` LIKE :username1 OR `u`.`pay_name` LIKE :username2) AND ', $sql);
				$params[':username1'] = $params[':username2'] = '%'.$_POST['memberName'].'%';
			}
			$agent_config = get_agent_config($group);
			if($child_count>0){
				$child_config = get_child_agent_config($agent_config, $AGENT['groups'], $group['child_groups']);
				$agent_config = $child_config[$child_count];
			}
			$stmt = $mydata1_db->prepare($sql[0]);
			$stmt->execute($params);
			$count = $stmt->fetch();
			$output['rowCount'] = $count['count'];
			$output['pageCount'] = ceil($count['count']/$output['maxCount']);
			if(isset($_POST['page'])&&!empty($_POST['page'])){
				$_POST['page'] = intval($_POST['page']);
				if($_POST['page']>0&&$_POST['page']<=$output['pageCount']){
					$output['currentPage'] = $_POST['page'];
				}
			}
			$params[':index'] = $output['maxCount']*($output['currentPage']-1);
			$params[':limit'] = $output['maxCount'];
			$stmt = $mydata1_db->prepare($sql[1]);
			$stmt->execute($params);
			while ($rows = $stmt->fetch()) {
				$rows['value'] = unserialize($rows['value']);
				$rows['data'] = [];
				$betAmount = 0;
				$netAmount = 0;
				$validAmount = 0;
				$rowCount = 0;
				$money = get_agent_amount($agent_config, $rows['value']);
				foreach($rows['value'] as $key=>$val){
					foreach($val['data'] as $k=>$v){
						switch ($k) {
							case 'bet_amount':
								$betAmount+= $v;
								break;

							case 'net_amount':
								$netAmount+= $v;
								break;

							case 'valid_amount':
								$validAmount+= $v;
								break;

							case 'rows_num':
								$rowCount+= $v;
								break;
						}
						$k!='rows_num'&&$val['data'][$k] = sprintf('%.2f', $v/100);
					}
					$rows['data'][] = $val;
				}
				$output['list'][] = [
					'uid' => $rows['uid'],
					'username' => $rows['username'],
					'reportTime' => date('Y-m-d', $rows['cache_date']),
					'betAmount' => sprintf('%.2f', $betAmount/100),
					'netAmount' => sprintf('%.2f', $netAmount/100),
					'validAmount' => sprintf('%.2f', $validAmount/100),
					'rowCount' => $rowCount,
					'money' => sprintf('%.2f', $money/100),
					'data' => $rows['data'],
				];
				$output['total']['bet']+= $betAmount;
				$output['total']['net']+= $netAmount;
				$output['total']['valid']+= $validAmount;
				$output['total']['count']+= $rowCount;
				$output['total']['money']+= $money;
			}
			$output['total']['bet'] = sprintf('%.2f', $output['total']['bet']/100);
			$output['total']['net'] = sprintf('%.2f', $output['total']['net']/100);
			$output['total']['valid'] = sprintf('%.2f', $output['total']['valid']/100);
			$output['total']['money'] = sprintf('%.2f', $output['total']['money']/100);
			$output['agents'] = $AGENT['user']['team'];
			$output['formula'] = get_formula($agent_config);
		}
		break;

    case 'GetContent':
        $output = [
            'errorCode' => 0,
            'errorMsg' => [],
        ];

        $output['errorMsg']['JoinUs'] = [];
        if(isset($AGENT['config']['ServiceRule'])){
            foreach($AGENT['config']['ServiceRule'] as $k=>$v){
                $output['errorMsg']['JoinUs'][] = [substr('00'.($k+1), -2), $v];
            }
        }
        $rows = get_webinfo_bycode('agent-mservicerule');
        $output['errorMsg']['ServiceRule'] = isset($rows['content'])?$rows['content']:'';
        $output['errorMsg']['GameCount'] = !isset($AGENT['config']['GameCount'])||empty($AGENT['config']['GameCount'])?'0':$AGENT['config']['GameCount'];
        $output['errorMsg']['AgentCount'] = !isset($AGENT['config']['AgentCount'])||empty($AGENT['config']['AgentCount'])?'0':$AGENT['config']['AgentCount'];
        $output['errorMsg']['AvgCheckout'] = !isset($AGENT['config']['AvgCheckout'])||empty($AGENT['config']['AvgCheckout'])?'0.00':sprintf('%.2f', $AGENT['config']['AvgCheckout']);
        $output['errorMsg']['NewMember'] = !isset($AGENT['config']['NewMember'])||empty($AGENT['config']['NewMember'])?'0':$AGENT['config']['NewMember'];
        break;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);