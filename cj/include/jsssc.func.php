<?php
function getRanking($qishu=0, $check=false){
	if($check){
		// 统计历史数据
		$return = [0, []];
		for($i=0;$i<=13;$i++){
			$return[1][$i] = 0;
		}
		for($i=2;$i<=5;$i++){
			$return[$i] = $return[1];
		}
		if($qishu>0){
			$sql = 'SELECT `value` FROM `c_auto_data` WHERE `type`=:type AND `qishu`<:qishu AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT 1152';
			$params = [':type' => 'JSSSC', ':qishu' => $qishu];
		}else{
			$sql = 'SELECT `value` FROM `c_auto_data` WHERE `type`=:type AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT 1152';
			$params = [':type' => 'JSSSC'];
		}
		$stmt = $GLOBALS['mydata1_db']->prepare($sql);
		$stmt->execute($params);
		while ($rows = $stmt->fetch()) {
			$rows = unserialize($rows['value']);
			foreach($rows['opencode'] as $key=>$val){
				// 2018-01-14: 增加数据校验
				$val = trim($val);
				if($key>=0&&$key<5&&$val!=''&&$val>=0&&$val<10){
					$key++;
					$return[$key][$val]++;
					$return[$key][$val>4?10:11]++; //大小
					$return[$key][fmod($val, 2)==0?13:12]++; //单双
				}
			}
			$return[0]++;
		}
		if($return[0]>0){
			for($i=1;$i<=5;$i++){
				$key = $return[$i][10]+$return[$i][11];
				$return[$i][10] = round($return[$i][10]/$key*10000);
				$return[$i][11] = round($return[$i][11]/$key*10000);
				$key = $return[$i][12]+$return[$i][13];
				$return[$i][12] = round($return[$i][12]/$key*10000);
				$return[$i][13] = round($return[$i][13]/$key*10000);
				for($key=0;$key<10;$key++){
					$return[$i][$key] = round($return[$i][$key]/$return[0]*10000);
					// $return[$i][$key]+= $return[$i][$key>5?11:11];
					// $return[$i][$key]+= $return[$i][fmod($key, 2)==0?13:12];
				}
				// unset($return[$i][6], $return[$i][11], $return[$i][12], $return[$i][13]);
				// asort($return[$i]);
				// 2018-01-14: 增加数据校验
				$return[$i] = array_slice($return[$i], 0, 14, true);
			}
		}
		unset($return[0]);
	}else{
		$return = [1 => []];
		for($i=0;$i<=9;$i++){
			$return[1][$i] = 1000;
		}
		for($i=10;$i<=13;$i++){
			$return[1][$i] = 5000;
		}
		for($i=2;$i<=5;$i++){
			$return[$i] = $return[1];
		}
	}
	return $return;
}
function getNumber($tempNum, $check=false){
	$return = [];
	if($check){
		// 根据历史结果获取开奖号码
		foreach($tempNum as $val){
			$temp1 = $temp2 = $temp3 = $val;
			foreach($temp1 as $k=>$v){
				if($k<10&&$v>rand(1000, 1005)){
					unset($temp1[$k]);
				}
			}
			if(abs($val[10]-$val[11])>=rand(180, 200)){
				if($val[10]>$val[11]){
					$temp0 = [5, 6, 7, 8, 9];
				}else{
					$temp0 = [0, 1, 2, 3, 4];
				}
				foreach($temp0 as $k){
					unset($temp2[$k]);
				}
			}
			if(abs($val[12]-$val[13])>=rand(180, 200)){
				if($val[12]>$val[13]){
					$temp0 = [1, 3, 5 ,7 ,9];
				}else{
					$temp0 = [0, 2, 4, 6, 8];
				}
				foreach($temp0 as $k){
					unset($temp3[$k]);
				}
			}
			$temp0 = array_intersect_key($temp1, $temp2, $temp3);
			if(count($temp0)>=5){
				$val = $temp0;
			}else{
				$temp0 = [
					array_intersect_key($temp1, $temp2),
					array_intersect_key($temp1, $temp3),
					array_intersect_key($temp2, $temp3),
				];
				$temp0 = $temp0[0]+$temp0[1]+$temp0[2];
				if(count($temp0)>=5){
					$val = $temp0;
				}else{
					// 2018-01-14: 部分情况下$temp1、$temp2、$temp3的合集不符合要求
					$temp0 = $temp1+$temp2+$temp3;
					count($temp0)>=5&&$val = $temp0;
				}
			}
			unset($val[10], $val[11], $val[12], $val[13]);
			$return[] = array_rand($val);
		}
	}else{
		foreach($tempNum as $val){
			unset($val[10], $val[11], $val[12], $val[13]);
			$return[] = array_rand($val);
		}
	}
	return $return;
}
function checkBet($qishu, $tempArray){
	// 计算盈亏比例
	$stmt = $GLOBALS['mydata1_db']->prepare('SELECT `money`, `win`, `value` FROM `c_bet_data` WHERE `type`=:type AND `qishu`=:qishu AND `status`=0 ORDER BY `id` ASC');
	$stmt->execute([':type' => 'JSSSC', ':qishu' => $qishu]);
	if($stmt->rowCount()>0){
		$return = [];
		foreach($tempArray as $key=>$val){
			$tempArray[$key] = ['opencode' => $val, 'info' => []];
			$tempArray[$key]['info'][] = array_sum($val);
			$tempArray[$key]['info'][] = fmod($tempArray[$key]['info'][0], 2)==0?'双':'单';
			$tempArray[$key]['info'][] = $tempArray[$key]['info'][0]>22?'大':'小';
			$tempArray[$key]['info'][] = $val[0]==$val[4]?'和':($val[0]>$val[4]?'龙':'虎');
			$tempArray[$key]['info'][] = SSC([$val[0], $val[1], $val[2]]);
			$tempArray[$key]['info'][] = SSC([$val[1], $val[2], $val[3]]);
			$tempArray[$key]['info'][] = SSC([$val[2], $val[3], $val[4]]);
			$return[$key] = [0, 0, 0];
		}
		$betArray = [];
		// 统计所有类型记录
		while ($rows = $stmt->fetch()) {
			$rows['value'] = unserialize($rows['value']);
			$rows = array_merge($rows['value'], ['money' => $rows['money']/100, 'win' => $rows['win']/100]);
			$rows['key'] = $rows['class'][0].'/'.$rows['class'][1];
			!isset($betArray[$rows['key']])&&$betArray[$rows['key']] = [
				'class' => $rows['class'],
				'odds' => [],
			];
			$rows['odds'] = 'j'.$rows['odds'];
			!isset($betArray[$rows['key']]['odds'][$rows['odds']])&&$betArray[$rows['key']]['odds'][$rows['odds']] = 0;
			$betArray[$rows['key']]['odds'][$rows['odds']]+= $rows['money'];
		}
		// 计算各个结果的占比
		foreach($betArray as $bet){
			foreach($bet['odds'] as $odds=>$money){
				$odds = substr($odds, 1);
				foreach($tempArray as $key=>$val){
					$tempNum = $val['opencode'];
					$tempInfo = $val['info'];
					$return[$key][0]+= $money;
					$return[$key][1]-= $money;
					switch ($bet['class'][0]) {
						case '第一球':
							$temp = $tempNum[0];
							break;
						case '第二球':
							$temp = $tempNum[1];
							break;
						case '第三球':
							$temp = $tempNum[2];
							break;
						case '第四球':
							$temp = $tempNum[3];
							break;
						case '第五球':
							$temp = $tempNum[4];
							break;
						case '前三':
							$temp = $tempInfo[4];
							break;
						case '中三':
							$temp = $tempInfo[5];
							break;
						case '后三':
							$temp = $tempInfo[6];
							break;
						case '总和、龙虎和':
							if(in_array($bet['class'][1], ['总和单', '总和双'])){
								$temp = '总和'.$tempInfo[1];
							}else if(in_array($bet['class'][1], ['总和大', '总和小'])){
								$temp = '总和'.$tempInfo[2];
							}else{
								$temp = $tempInfo[3];
							}
							break;
					}
					if(in_array($bet['class'][1], ['大', '小'])){
						$temp = $temp>=5?'大':'小';
					}
					if(in_array($bet['class'][1], ['单', '双'])){
						$temp = fmod($temp, 2)==0?'双':'单';
					}
					if($bet['class'][1]==$temp){
						$return[$key][1]+= $money*$odds;
					}
				}
			}
		}
		foreach($return as $key=>$val){
			$return[$key][2] = $val[0]>0 ? -1*round($val[1]/$val[0]*10000) : 0;
		}
		return $return;
	}else{
		return [];
	}
}
function SSC($num){
	$a = 0;
	$b = count(array_unique($num));
	foreach($num as $v){
		if(in_array(fmod(($v+10)-1, 10), $num)||in_array(fmod($v+1, 10), $num)){
			$a++;
		}
	}
	if($b==1){
		return '豹子';
	}else if($b==2){
		return '对子';
	}else if($a==3){
		return '顺子';
	}else if($a==2){
		return '半顺';
	}else{
		return '杂六';
	}
}
