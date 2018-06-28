<?php
defined('IN_AGENT')||exit('Access denied');
include IN_AGENT.'../../agent/include/functions.php';

function get_agent_details($uid=[], $config=[], $stime=0, $etime=0, $team=false, $index=0, $child=false){
	$return = [
		'bet_amount' => 0,
		'net_amount' => 0,
		'valid_amount' => 0,
		'pay_amount' => 0,
		'team_amount' => 0,
	];
	if(!empty($uid)){
		$params = [
			':stime' => $stime,
			':etime' => $etime,
		];
		is_array($uid)||$uid = [$uid];
		$ids = implode(', ', $uid);
		if(count($uid)>1){
			$sql = 'SELECT `cache_date`, `value` FROM `agent_cache` WHERE `cache_date` BETWEEN :stime AND :etime AND `uid` IN ('.$ids.')';
			$user_sql = 'SELECT `uid` FROM `k_user` WHERE `is_daili`=1 AND `top_uid` IN ('.$ids.')';
		}else{
			$params[':uid'] = $ids;
			$sql = 'SELECT `cache_date`, `value` FROM `agent_cache` WHERE `uid`=:uid AND `cache_date` BETWEEN :stime AND :etime';
			$user_sql = 'SELECT `uid` FROM `k_user` WHERE `is_daili`=1 AND `top_uid`='.$ids;
		}
		if($team){
			$uid = [];
			$stmt = $GLOBALS['mydata1_db']->query($user_sql);
			while ($rows = $stmt->fetch()) {
				$uid[] = $rows['uid'];
			}
			$return = get_agent_details($uid, $config, $stime, $etime, $index+2<count($config), $index+1);
		}
		$stmt = $GLOBALS['mydata1_db']->prepare($sql);
		$stmt->execute($params);
		while ($rows = $stmt->fetch()) {
			$rows['value'] = unserialize($rows['value']);
			if($index==0||$child){
				$return['pay_amount']+= get_agent_amount($config[$index], $rows['value']);
				foreach($rows['value'] as $data){
					foreach($data['data'] as $k=>$v){
						if(in_array($k, ['bet_amount', 'net_amount', 'valid_amount', 'rows_num'])){
							$return[$k]+= $v;
						}
					}
				}
			}else{
				$return['team_amount']+= get_agent_amount($config[$index], $rows['value']);
			}
		}
	}
	return $return;
}
