<?php
define('IN_AGENT', dirname(__FILE__).'/');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
include IN_AGENT.'functions.php';

check_quanxian('dlgl');
empty($_POST)&&$_POST = $_GET;
if(!isset($_POST['uid'])||empty($_POST['uid'])||!is_array($_POST['uid'])){
	message('请选择需要进行操作的代理！');
}else{
	$_POST['action'] = isset($_POST['action'])?$_POST['action']:'default';
	switch ($_POST['action']) {
		case 'cancel_agent':
			$num = count($_POST['uid']);
			if(isset($_POST['message'])&&$_POST['message']=='clear'){
				$stmt = $mydata1_db->prepare('UPDATE `k_user` SET `top_uid`=0 WHERE `is_daili`=1 AND `top_uid` IN (?'.str_repeat(', ?', $num-1).')');
				$stmt->execute($_POST['uid']);
				$msg = '批量取消了'.$num.'位会员的代理与下层代理关系['.implode(',', $_POST['uid']).']';
			}else{
				$msg = '批量取消了'.$num.'位会员的代理['.implode(',', $_POST['uid']).']';
			}
			$stmt = $mydata1_db->prepare('UPDATE `k_user` SET `is_daili`=0 WHERE `is_daili`=1 AND `uid` IN (?'.str_repeat(', ?', $num-1).')');
			$stmt->execute($_POST['uid']);
			admin::insert_log($_SESSION['adminid'], $msg);
			message('批量取消代理权限成功！');
			break;

		case 'cancel_top':
			$num = count($_POST['uid']);
			$stmt = $mydata1_db->prepare('UPDATE `k_user` SET `top_uid`=0 WHERE `is_daili`=1 AND `uid` IN (?'.str_repeat(', ?', $num-1).')');
			$stmt->execute($_POST['uid']);
			admin::insert_log($_SESSION['adminid'], '批量取消了'.$num.'位代理与上层代理关系['.implode(',', $_POST['uid']).']');
			message('批量取消代理关系成功！');
			break;

		case 'change_agent':
			$_POST['message'] = isset($_POST['message'])?intval($_POST['message']):0;
			if($_POST['message']>0){
				$num = count($_POST['uid']);
				$msg = '批量切换了'.$num.'位代理的上层代理为 '.$_POST['message'].' ['.implode(',', $_POST['uid']).']';
				$_POST['uid'][] = $_POST['uid'][0];
				$_POST['uid'][] = $_POST['message'];
				$_POST['uid'][0] = $_POST['message'];
				$stmt = $mydata1_db->prepare('UPDATE `k_user` SET `top_uid`=? WHERE `is_daili`=1 AND `uid` IN (?'.str_repeat(', ?', $num-1).') AND `uid`<>?');
				$stmt->execute($_POST['uid']);
				admin::insert_log($_SESSION['adminid'], $msg);
				message('批量切换上层代理成功！');
			}else{
				message('请选择目标代理！');
			}
			break;

		case 'change_group':
			$_POST['message'] = isset($_POST['message'])?intval($_POST['message']):0;
			if($_POST['message']>0){
				$num = count($_POST['uid']);
				$msg = '批量切换了'.$num.'位代理的代理组为 '.$_POST['message'].' ['.implode(',', $_POST['uid']).']';
				$ids = [];
				$params = [];
				$count = 0;
				$stmt = $mydata1_db->prepare('SELECT `u`.`uid`, `u`.`top_uid`, `u`.`username`, `c`.`id` FROM `k_user` AS `u` LEFT JOIN `agent_config` AS `c` ON `u`.`uid`=`c`.`uid` WHERE `u`.`is_daili`=1 AND `u`.`uid` IN (?'.str_repeat(', ?', $num-1).')');
				$stmt->execute($_POST['uid']);
				while ($rows = $stmt->fetch()) {
					if($rows['id']>0){
						$ids[] = $rows['id'];
					}else{
						$count++;
						$params[] = $rows['uid'];
						$params[] = $_POST['message'];
						$params[] = $rows['username'];
						$params[] = 'a:0:{}';
					}
				}
				if(!empty($ids)){
					$stmt = $mydata1_db->prepare('UPDATE `agent_config` SET `tid`=? WHERE `id` IN (?'.str_repeat(', ?', count($ids)-1).')');
					$ids[] = $ids[0];
					$ids[0] = $_POST['message'];
					$stmt->execute($ids);
				}
				if($count>0){
					$stmt = $mydata1_db->prepare('INSERT INTO `agent_config` (`uid`, `tid`, `username`, `value`) VALUES (?, ?, ?, ?)'.str_repeat(', (?, ?, ?, ?)', $count-1));
					$stmt->execute($params);
				}
				admin::insert_log($_SESSION['adminid'], $msg);
				message('批量切换代理组成功！');
			}else{
				message('请选择目标代理组！');
			}
			break;

		case 'cancel_checkout':
			include IN_AGENT.'../../class/money.php';
			$stmt = $mydata1_db->prepare('SELECT `c`.*, `u`.`money` FROM `agent_checkout` AS `c` LEFT JOIN `k_user` AS `u` ON `c`.`uid`=`u`.`uid` WHERE `c`.`status`=1 AND `c`.`id` IN (?'.str_repeat(', ?', count($_POST['uid'])-1).')');
			$stmt->execute($_POST['uid']);
			$ids = [];
			while ($rows = $stmt->fetch()) {
				$rows['value'] = unserialize($rows['value']);
				$ids[] = $rows['id'];
				$rows['value']['money'] = $rows['value']['pay_amount'];
				$rows['value']['money']+= $rows['value']['team_amount'];
				if($rows['value']['money']>0){
					$cid = 'CANCEL'.substr($rows['value']['id'], -30);
					money::tixian($rows['uid'], $rows['value']['money']/100, $rows['money'], '', '', '', '', $cid, 1, '撤销结算单['.$rows['value']['id'].']', 6);
				}
			}
			if(!empty($ids)){
				$stmt = $mydata1_db->prepare('UPDATE `agent_checkout` SET `status`=0 WHERE `status`=1 AND `id` IN (?'.str_repeat(', ?', count($ids)-1).')');
				$stmt->execute($ids);
			}
			admin::insert_log($_SESSION['adminid'], '撤销了代理结算单['.implode(',', $_POST['uid']).']');
			message('撤销成功！');
			break;

		default:
			message('来源无效');
			break;
	}
}
