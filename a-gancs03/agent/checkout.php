<?php
define('IN_AGENT', dirname(__FILE__).'/');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
include IN_AGENT.'functions.php';

check_quanxian('dlgl');
$hash256 = session_name().$_SESSION['login_name'];
$output = ['status' => 0, 'msg' => 'Access Denied'];

switch (true) {
	case !isset($_POST['action']):
	case !in_array($_POST['action'], ['get', 'checkout']):
	case !isset($_POST['tid']):
	case !isset($_POST['stime']):
	case !isset($_POST['etime']):
	case !isset($_POST['key']):
	case hash('sha256', $_POST['tid'].$_POST['stime'].$_POST['etime'].$hash256)!=$_POST['key']:
		$output['msg'] = '数据有误，请刷新页面重试';
		break;

	case $_POST['action']=='get':
		$output['status'] = 1;
		$output['msg'] = '未找到符合条件的代理账户';
		$stmt = $mydata1_db->query('SELECT `u`.`uid`, `u`.`username`, `u`.`pay_name`, `a`.`tid` FROM `k_user` AS `u` LEFT JOIN `agent_config` AS `a` ON `u`.`uid`=`a`.`uid` WHERE `u`.`is_daili`=1 AND `u`.`is_delete`=0 AND `u`.`is_stop`=0 AND `a`.`tid`'.($_POST['tid']>0?'='.$_POST['tid']:'>0').' ORDER BY `u`.`uid` ASC');
		$output['count'] = $stmt->rowCount();
		$output['list'] = [];
		if($output['count']>0){
			$output['msg'] = '获取成功';
			while ($rows = $stmt->fetch()) {
				$output['list'][] = [
					'uid' => $rows['uid'],
					'username' => $rows['username'],
					'fullname' => $rows['pay_name'],
					'tid' => $rows['tid'],
					'key' => hash('sha256', $rows['uid'].$rows['tid'].$_POST['key']),
				];
			}
			admin::insert_log($_SESSION['adminid'], '结算代理佣金，编号：CHECKOUT'.date('Ymd', $_POST['stime']).date('Ymd', $_POST['etime']));
		}
		break;

	case $_POST['action']=='checkout':
		if(isset($_POST['uid'])&&isset($_POST['utid'])&&isset($_POST['ukey'])&&hash('sha256', $_POST['uid'].$_POST['utid'].$_POST['key'])==$_POST['ukey']){
			$output['status'] = 1;
			$output['money'] = 0;
			$output['msg'] = '已结算';
			$stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count` FROM `agent_checkout` WHERE `uid`=:uid AND `starttime`=:stime AND `endtime`=:etime AND `status`=1');
			$stmt->execute([
				':uid' => $_POST['uid'],
				':stime' => $_POST['stime'],
				':etime' => $_POST['etime'],
			]);
			$count = $stmt->fetch();
			if($count['count']<=0){
				$output['msg'] = '结算成功';
				$groups = get_agent_groups();
				if(array_key_exists($_POST['utid'], $groups)){
					$agent_config = [get_agent_config($groups[$_POST['utid']])];
					if(array_key_exists('child_groups', $groups[$_POST['utid']])){
						$agent_config = get_child_agent_config($agent_config[0], $groups, $groups[$_POST['utid']]['child_groups']);
						$agent_details = get_agent_details($_POST['uid'], $agent_config, $_POST['stime'], $_POST['etime'], true);
					}else{
						$agent_details = get_agent_details($_POST['uid'], $agent_config, $_POST['stime'], $_POST['etime']);
					}
					foreach($agent_config as $key=>$val){
						$agent_config[$key] = get_formula($val);
					}
					$stmt = $mydata1_db->prepare('SELECT `money`, `username` FROM `k_user` WHERE `uid`=:uid');
					$stmt->execute([':uid' => $_POST['uid']]);
					$user = $stmt->fetch();
					$cid = 'CHECKOUT'.substr('0000000000'.$_POST['uid'], -10).date('Ymd', $_POST['stime']).date('Ymd', $_POST['etime']).rand(1000, 9999);
					$stmt = $mydata1_db->prepare('INSERT INTO `agent_checkout` (`uid`, `addtime`, `starttime`, `endtime`, `value`, `status`) VALUES (:uid, :addtime, :starttime, :endtime, :value, 1)');
					$stmt->execute([
						':uid' => $_POST['uid'],
						':addtime' => time(),
						':starttime' => $_POST['stime'],
						':endtime' => $_POST['etime'],
						':value' => serialize([
							'username' => $user['username'],
							'id' => $cid,
							'no' => 'CHECKOUT'.date('Ymd', $_POST['stime']).date('Ymd', $_POST['etime']),
							'pay_amount' => $agent_details['pay_amount'],
							'team_amount' => $agent_details['team_amount'],
							'formula' => $agent_config,
						]),
					]);
					$output['money'] = ($agent_details['pay_amount']+$agent_details['team_amount'])/100;
					if($output['money']>0){
						include IN_AGENT.'../../class/money.php';
						money::chongzhi($_POST['uid'], $cid, $output['money'], $user['money'], 1, date('Y-m-d 至 ', $_POST['stime']).date('Y-m-d', $_POST['etime']).' 佣金结算', 6);
					}
					$output['money'] = sprintf('%.2f', $output['money']);
				}
			}
		}else{
			$output['msg'] = '数据有误，请刷新页面重试';
		}
		break;

	default:
		$output['msg'] = '来源无效';
		break;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
