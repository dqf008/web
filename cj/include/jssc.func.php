<?php
function getRanking($qishu=0, $check=false){
	if($check){
		// 统计历史数据
		$return = [0, []];
		for($i=1;$i<=14;$i++){
			$return[1][$i] = 0;
		}
		for($i=2;$i<=10;$i++){
			$return[$i] = $return[1];
		}
		if($qishu>0){
			$sql = 'SELECT `value` FROM `c_auto_data` WHERE `type`=:type AND `qishu`<:qishu AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT 1152';
			$params = [':type' => 'JSSC', ':qishu' => $qishu];
		}else{
			$sql = 'SELECT `value` FROM `c_auto_data` WHERE `type`=:type AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT 1152';
			$params = [':type' => 'JSSC'];
		}
		$stmt = $GLOBALS['mydata1_db']->prepare($sql);
		$stmt->execute($params);
		while ($rows = $stmt->fetch()) {
			$rows = unserialize($rows['value']);
			foreach($rows['opencode'] as $key=>$val){
				// 2018-01-14: 增加数据校验
				$val = trim($val);
				if($key>=0&&$key<10&&!empty($val)&&$val>0&&$val<=10){
					$key++;
					$return[$key][$val]++;
					$return[$key][$val>5?11:12]++; //大小
					$return[$key][fmod($val, 2)==0?14:13]++; //单双
				}
			}
			$return[0]++;
		}
		if($return[0]>0){
			for($i=1;$i<=10;$i++){
				$key = $return[$i][11]+$return[$i][12];
				$return[$i][11] = round($return[$i][11]/$key*10000);
				$return[$i][12] = round($return[$i][12]/$key*10000);
				$key = $return[$i][13]+$return[$i][14];
				$return[$i][13] = round($return[$i][13]/$key*10000);
				$return[$i][14] = round($return[$i][14]/$key*10000);
				for($key=1;$key<=10;$key++){
					$return[$i][$key] = round($return[$i][$key]/$return[0]*10000);
					// $return[$i][$key]+= $return[$i][$key>5?11:12];
					// $return[$i][$key]+= $return[$i][fmod($key, 2)==0?14:13];
				}
				// unset($return[$i][11], $return[$i][12], $return[$i][13], $return[$i][14]);
				// asort($return[$i]);
				// 2018-01-14: 增加数据校验
				unset($return[$i][0]);
				$return[$i] = array_slice($return[$i], 0, 14, true);
			}
		}
		unset($return[0]);
	}else{
		$return = [1 => []];
		for($i=1;$i<=10;$i++){
			$return[1][$i] = 1000;
		}
		for($i=11;$i<=14;$i++){
			$return[1][$i] = 5000;
		}
		for($i=2;$i<=10;$i++){
			$return[$i] = $return[1];
		}
	}
	return $return;
}
function getNumber($tempNum, $check=false){
	$return = [];
	if($check){
		// 根据历史结果获取开奖号码
		$temp = [];
		foreach($tempNum as $key=>$val){
			unset($val[11], $val[12], $val[13], $val[14]);
			$temp[$key] = min($val);
		}
		asort($temp);
		foreach($temp as $key=>$val){
			$val = $tempNum[$key];
			foreach($return as $k){
				unset($val[$k]);
			}
			if(count($val)>5){
				$temp1 = $temp2 = $temp3 = $val;
				foreach($temp1 as $k=>$v){
					if($k<=10&&$v>rand(1000, 1005)){
						unset($temp1[$k]);
					}
				}
				if(abs($val[11]-$val[12])>=rand(180, 200)){
					if($val[11]>$val[12]){
						$temp0 = [6, 7, 8, 9, 10];
					}else{
						$temp0 = [1, 2, 3, 4, 5];
					}
					foreach($temp0 as $k){
						unset($temp2[$k]);
					}
				}
				if(abs($val[13]-$val[14])>=rand(180, 200)){
					if($val[13]>$val[14]){
						$temp0 = [1, 3, 5 ,7 ,9];
					}else{
						$temp0 = [2, 4, 6, 8, 10];
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
			}
			unset($val[11], $val[12], $val[13], $val[14]);
			$return[$key-1] = array_rand($val);
		}
		ksort($return);
	}else{
		foreach($tempNum as $val){
			unset($val[11], $val[12], $val[13], $val[14]);
			foreach($return as $key){
				unset($val[$key]);
			}
			$return[] = array_rand($val);
		}
	}
	return $return;
}
function checkBet($qishu, $tempArray){
	// 计算盈亏比例
	$stmt = $GLOBALS['mydata1_db']->prepare('SELECT `money`, `win`, `value` FROM `c_bet_data` WHERE `type`=:type AND `qishu`=:qishu AND `status`=0 ORDER BY `id` ASC');
	$stmt->execute([':type' => 'JSSC', ':qishu' => $qishu]);
	if($stmt->rowCount()>0){
		$return = [];
		foreach($tempArray as $key=>$val){
			$tempArray[$key] = ['opencode' => $val, 'info' => []];
			$tempArray[$key]['info'][] = $val[0]+$val[1];
			$tempArray[$key]['info'][] = '冠亚'.(fmod($tempArray[$key]['info'][0], 2)==0?'双':'单');
			$tempArray[$key]['info'][] = '冠亚'.($tempArray[$key]['info'][0]==11?'和':($tempArray[$key]['info'][0]>11?'大':'小'));
			$tempArray[$key]['info'][] = $val[0]>$val[9]?'龙':'虎';
			$tempArray[$key]['info'][] = $val[1]>$val[8]?'龙':'虎';
			$tempArray[$key]['info'][] = $val[2]>$val[7]?'龙':'虎';
			$tempArray[$key]['info'][] = $val[3]>$val[6]?'龙':'虎';
			$tempArray[$key]['info'][] = $val[4]>$val[5]?'龙':'虎';
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
					switch ($bet['class'][1]) {
						case '冠亚大':
						case '冠亚小':
						case '冠亚单':
						case '冠亚双':
							if($tempInfo[0]==11){
								// $return[$key][0]-= $money;
								$return[$key][1]+= $money;
							}else if(in_array($bet['class'][1], [$tempInfo[1], $tempInfo[2]])){
								$return[$key][1]+= $money*$odds;
							}
							break;
						default:
							switch ($bet['class'][0]) {
								case '冠、亚军和':
									$temp = $tempInfo[0];
									break;
								case '1V10 龙虎':
									$temp = $tempInfo[3];
									break;
								case '2V9 龙虎':
									$temp = $tempInfo[4];
									break;
								case '3V8 龙虎':
									$temp = $tempInfo[5];
									break;
								case '4V7 龙虎':
									$temp = $tempInfo[6];
									break;
								case '5V6 龙虎':
									$temp = $tempInfo[7];
									break;
								case '冠军':
									$temp = $tempNum[0];
									break;
								case '亚军':
									$temp = $tempNum[1];
									break;
								case '第三名':
									$temp = $tempNum[2];
									break;
								case '第四名':
									$temp = $tempNum[3];
									break;
								case '第五名':
									$temp = $tempNum[4];
									break;
								case '第六名':
									$temp = $tempNum[5];
									break;
								case '第七名':
									$temp = $tempNum[6];
									break;
								case '第八名':
									$temp = $tempNum[7];
									break;
								case '第九名':
									$temp = $tempNum[8];
									break;
								case '第十名':
									$temp = $tempNum[9];
									break;
							}
							if(in_array($bet['class'][1], ['大', '小'])){
								$temp = $temp>5?'大':'小';
							}
							if(in_array($bet['class'][1], ['单', '双'])){
								$temp = fmod($temp, 2)==0?'双':'单';
							}
							if($bet['class'][1]==$temp){
								$return[$key][1]+= $money*$odds;
							}
							break;
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
// var_dump(getNumber());
// var_dump(getRanking());
function getBet($qishu){
	// 实验性代码
	$return = [
		1 => [
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 0,
			11 => 0,
		],
		2 => [
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 0,
			11 => 0,
		],
		3 => [
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 0,
			11 => 0,
		],
		4 => [
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 0,
			11 => 0,
		],
		5 => [
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 0,
			11 => 0,
		],
		6 => [
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 0,
			11 => 0,
		],
		7 => [
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 0,
			11 => 0,
		],
		8 => [
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 0,
			11 => 0,
		],
		9 => [
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 0,
			11 => 0,
		],
		10 => [
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
			7 => 0,
			8 => 0,
			9 => 0,
			10 => 0,
			11 => 0,
		],
	];
	$stmt = $GLOBALS['mydata1_db']->prepare('SELECT `money`, `win`, `value` FROM `c_bet_data` WHERE `type`=:type AND `qishu`=:qishu AND `status`=0 ORDER BY `id` ASC');
	$stmt->execute([':type' => 'JSSC', ':qishu' => $qishu]);
	while ($rows = $stmt->fetch()) {
		$rows['value'] = unserialize($rows['value']);
		$rows = array_merge($rows['value'], ['money' => $rows['money']/100, 'win' => $rows['win']/100]);
		$continue = true;
		switch ($rows['class'][0]) {
			case '冠、亚军和':
				# 冠亚组合暂时不做，难度较高
				$continue = false;
				break;
			case '冠军':
			case '1V10 龙虎':
				$index = 1;
				break;
			case '亚军':
			case '2V9 龙虎':
				$index = 2;
				break;
			case '第三名':
			case '3V8 龙虎':
				$index = 3;
				break;
			case '第四名':
			case '4V7 龙虎':
				$index = 4;
				break;
			case '第五名':
			case '5V6 龙虎':
				$index = 5;
				break;
			case '第六名':
				$index = 6;
				break;
			case '第七名':
				$index = 7;
				break;
			case '第八名':
				$index = 8;
				break;
			case '第九名':
				$index = 9;
				break;
			case '第十名':
				$index = 10;
				break;
		}
		if($continue){
			switch ($rows['class'][1]) {
				case '龙':
					$tempNum = [
						10 => 9,
						9 => 8,
						8 => 7,
						7 => 6,
						6 => 5,
						5 => 4,
						4 => 3,
						3 => 2,
						2 => 1,
					];
					break;
				case '虎':
					$tempNum = [
						1 => 9,
						2 => 8,
						3 => 7,
						4 => 6,
						5 => 5,
						6 => 4,
						7 => 3,
						8 => 2,
						9 => 1,
					];
					break;
				case '大':
					$tempNum = [
						6 => 1,
						7 => 1,
						8 => 1,
						9 => 1,
						10 => 1,
					];
					break;
				case '小':
					$tempNum = [
						1 => 1,
						2 => 1,
						3 => 1,
						4 => 1,
						5 => 1,
					];
					break;
				case '单':
					$tempNum = [
						1 => 1,
						3 => 1,
						5 => 1,
						7 => 1,
						9 => 1,
					];
					break;
				case '双':
					$tempNum = [
						2 => 1,
						4 => 1,
						6 => 1,
						8 => 1,
						10 => 1,
					];
					break;
				default:
					$tempNum = [$rows['class'][1] => 1];
					break;
			}
			foreach($tempNum as $key=>$val){
				$val*= $rows['win'];
				$return[$index][$key]+= $val;
				$return[$index][11]+= $val;
			}
		}
	}
	foreach($return as $key=>$val){
		for($i=1;$i<=10;$i++){
			if($val[11]>0){
				$return[$key][$i] = round($val[$i]/$val[11]*10000);
			}else{
				$return[$key][$i] = 1000;
			}
		}
		unset($return[$key][11]);
	}
	return $return;
}
function getCheckout(){
	$stmt = $GLOBALS['mydata1_db']->prepare('SELECT SUM(`money`) AS `bet_money`, SUM(IF(`win`>0, `money`-`win`, `money`)) AS `win_money` FROM `c_bet_data` WHERE `type`=:type AND `status`=1 AND `addtime`>=:time');
	$stmt->execute([':type' => 'JSSC', ':time' => time()-43200]);
	$rows = $stmt->fetch();
	return $rows['bet_money']>0 ? sprintf('%.2f', $rows['win_money']/$rows['bet_money']*100) : 0;
}
// var_dump(checkBet(1512320925, getNumber()));
// var_dump(getBet(1512320925));
// echo getCheckout();