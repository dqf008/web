<?php
$_DIR = realpath('../../lot/');
$_DIR = str_replace('\\', '/', $_DIR);
substr($_DIR, -1)!='/'&&$_DIR.='/';
define('IN_LOT', $_DIR);
include(IN_LOT.'include/class/lunar.class.php');
function getRanking($qishu=0, $check=false){
	if($check){
		// 统计历史数据
		$return = [0, []];
		for($i=1;$i<=53;$i++){
			$return[1][$i] = 0;
		}
		for($i=2;$i<=7;$i++){
			$return[$i] = $return[1];
		}
		if($qishu>0){
			$sql = 'SELECT `value` FROM `c_auto_data` WHERE `type`=:type AND `qishu`<:qishu AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT 960';
			$params = [':type' => 'JSLH', ':qishu' => $qishu];
		}else{
			$sql = 'SELECT `value` FROM `c_auto_data` WHERE `type`=:type AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT 960';
			$params = [':type' => 'JSLH'];
		}
		$stmt = $GLOBALS['mydata1_db']->prepare($sql);
		$stmt->execute($params);
		while ($rows = $stmt->fetch()) {
			$rows = unserialize($rows['value']);
			foreach($rows['opencode'] as $key=>$val){
				// 2018-01-14: 增加数据校验
				$val = trim($val);
				if($key>=0&&$key<7&&!empty($val)&&$val>0&&$val<=49){
					$key++;
					$return[$key][$val]++;
					$return[$key][$val>25?50:51]++; //大小
					$return[$key][fmod($val, 2)==0?53:52]++; //单双
				}
			}
			$return[0]++;
		}
		if($return[0]>0){
			for($i=1;$i<=7;$i++){
				$key = $return[$i][50]+$return[$i][51];
				$return[$i][50] = round($return[$i][50]/$key*10000);
				$return[$i][51] = round($return[$i][51]/$key*10000);
				$key = $return[$i][52]+$return[$i][53];
				$return[$i][52] = round($return[$i][52]/$key*10000);
				$return[$i][53] = round($return[$i][53]/$key*10000);
				for($key=1;$key<=49;$key++){
					$return[$i][$key] = round($return[$i][$key]/$return[0]*10000);
				}
				// 2018-01-14: 增加数据校验
				unset($return[$i][0]);
				$return[$i] = array_slice($return[$i], 0, 53, true);
			}
		}
		unset($return[0]);
	}else{
		$return = [1 => []];
		for($i=1;$i<=49;$i++){
			$return[1][$i] = 204;
		}
		for($i=50;$i<=53;$i++){
			$return[1][$i] = 5000;
		}
		for($i=2;$i<=7;$i++){
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
			unset($val[50], $val[51], $val[52], $val[53]);
			$temp[$key] = min($val);
		}
		asort($temp);
		foreach($temp as $key=>$val){
			$val = $tempNum[$key];
			foreach($return as $k){
				unset($val[$k]);
			}
			$temp1 = $temp2 = $temp3 = $val;
			foreach($temp1 as $k=>$v){
				if($k<=49&&$v>rand(200, 208)){
					unset($temp1[$k]);
				}
			}
			if(abs($val[50]-$val[51])>=rand(384, 404)){
				if($val[51]-$val[50]>204){
					$temp0 = range(1, 25);
				}else{
					$temp0 = range(26, 49);
				}
				foreach($temp0 as $k){
					unset($temp2[$k]);
				}
			}
			if(abs($val[52]-$val[53])>=rand(384, 404)){
				if($val[52]-$val[53]>204){
					$temp0 = range(1, 49, 2);
				}else{
					$temp0 = range(2, 48, 2);
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
			unset($val[50], $val[51], $val[52], $val[53]);
			$return[$key-1] = array_rand($val);
		}
		ksort($return);
	}else{
		foreach($tempNum as $val){
			unset($val[50], $val[51], $val[52], $val[53]);
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
	$stmt->execute([':type' => 'JSLH', ':qishu' => $qishu]);
	if($stmt->rowCount()>0){
		$return = [];
		foreach($tempArray as $key=>$val){
			$tempArray[$key] = [
				'opencode' => $val,
				'color' => getColor($val),
				'animal' => getAnimal($val, $qishu),
			];
			$tempArray[$key]['temp'] = getInfo($tempArray[$key]);
			$tempArray[$key]['info'] = [array_sum($val)];
			$tempArray[$key]['info'][] = fmod($tempArray[$key]['info'][0], 2)==1?'单':'双';
			$tempArray[$key]['info'][] = $tempArray[$key]['info'][0]>174?'大':'小';
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
			$rows['odds'] = 'j'.implode('/', $rows['rate']);
			!isset($betArray[$rows['key']]['odds'][$rows['odds']])&&$betArray[$rows['key']]['odds'][$rows['odds']] = 0;
			$betArray[$rows['key']]['odds'][$rows['odds']]+= $rows['money'];
		}
		// 计算各个结果的占比
		foreach($betArray as $bet){
			foreach($bet['odds'] as $odds=>$money){
				$odds = substr($odds, 1);
				$odds = explode('/', $odds);
				foreach($tempArray as $key=>$val){
					$temp = getBet($val, $bet['class'], $money, $odds);
					$return[$key][0]+= $money;
					$return[$key][1]-= $money;
					$temp[0]>0&&$return[$key][1]+= $temp[0];
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
function getColor($return){
	$color = array(
		1 => 'red',
		2 => 'red',
		3 => 'blue',
		4 => 'blue',
		5 => 'green',
		6 => 'green',
		7 => 'red',
		8 => 'red',
		9 => 'blue',
		10 => 'blue',
		11 => 'green',
		12 => 'red',
		13 => 'red',
		14 => 'blue',
		15 => 'blue',
		16 => 'green',
		17 => 'green',
		18 => 'red',
		19 => 'red',
		20 => 'blue',
		21 => 'green',
		22 => 'green',
		23 => 'red',
		24 => 'red',
		25 => 'blue',
		26 => 'blue',
		27 => 'green',
		28 => 'green',
		29 => 'red',
		30 => 'red',
		31 => 'blue',
		32 => 'green',
		33 => 'green',
		34 => 'red',
		35 => 'red',
		36 => 'blue',
		37 => 'blue',
		38 => 'green',
		39 => 'green',
		40 => 'red',
		41 => 'blue',
		42 => 'blue',
		43 => 'green',
		44 => 'green',
		45 => 'red',
		46 => 'red',
		47 => 'blue',
		48 => 'blue',
		49 => 'green',
	);
	foreach($return as $key=>$val){
		$return[$key] = $color[$val];
	}
	return $return;
}
function getAnimal($return, $qishu){
	$animal = $temp = array();
	$temp[0] = array(
		'鼠',
		'牛',
		'虎',
		'兔',
		'龙',
		'蛇',
		'马',
		'羊',
		'猴',
		'鸡',
		'狗',
		'猪',
	);
	$temp[1] = array(
		array(1, 13, 25, 37, 49),
		array(2, 14, 26, 38),
		array(3, 15, 27, 39),
		array(4, 16, 28, 40),
		array(5, 17, 29, 41),
		array(6, 18, 30, 42),
		array(7, 19, 31, 43),
		array(8, 20, 32, 44),
		array(9, 21, 33, 45),
		array(10, 22, 34, 46),
		array(11, 23, 35, 47),
		array(12, 24, 36, 48),
	);
	/* 加载农历年份 */
	$lunar = new Lunar();
	$date = $lunar->convertSolarToLunar(date('Y', $qishu), date('m', $qishu), date('d', $qishu));
	foreach($temp[0] as $key=>$val){
		$key = fmod($date[0]-$key+8, 12);
		foreach($temp[1][$key] as $i){
			$animal[$i] = $val;
		}
	}
	foreach($return as $key=>$val){
		$return[$key] = $animal[$val];
	}
	return $return;
}
function getInfo($tempArray){
	$return = [];
	foreach($tempArray['opencode'] as $key=>$val){
		!isset($return[$key])&&$return[$key] = [];
		if($val==49){
			$return[$key][0] = '和'; //大小
			$return[$key][1] = '和'; //单双
			$return[$key][2] = '和'; //大小单双
			$return[$key][3] = '和'; //合数单双
			$return[$key][4] = '和'; //合数大小
			$return[$key][5] = '和'; //尾数大小
		}else{
			$return[$key][0] = $val>24?'大':'小'; //大小
			$return[$key][1] = fmod($val, 2)==1?'单':'双'; //单双
			$return[$key][2] = $return[$key][0].$return[$key][1]; //大小单双
			$temp = floor($val/10)+fmod($val, 10);
			$return[$key][3] = fmod($temp, 2)==1?'合单':'合双'; //合数单双
			$return[$key][4] = $temp>6?'合大':'合小'; //合数大小
			$return[$key][5] = fmod($val, 10)>4?'尾大':'尾小'; //尾数大小
		}
		$return[$key][6] = in_array($tempArray['animal'][$key], ['狗', '猪', '鸡', '羊', '马', '牛'])?'家禽':'野兽'; //家禽野兽
	}
	return $return;
}
function getBet($temp, $class, $money, $odds){
	$color = [
		'red' => '红',
		'green' => '绿',
		'blue' => '蓝',
	];
	$okey = 0;
	$return = [-1*$money, $odds[$okey]];
	switch ($class[0]) {
		case '特码':
		case '正码1':
		case '正码2':
		case '正码3':
		case '正码4':
		case '正码5':
		case '正码6':
		case '正1特':
		case '正2特':
		case '正3特':
		case '正4特':
		case '正5特':
		case '正6特':
			switch ($class[0]) {
				case '正码1':
				case '正1特':
					$key = 0;
					break;
				case '正码2':
				case '正2特':
					$key = 1;
					break;
				case '正码3':
				case '正3特':
					$key = 2;
					break;
				case '正码4':
				case '正4特':
					$key = 3;
					break;
				case '正码5':
				case '正5特':
					$key = 4;
					break;
				case '正码6':
				case '正6特':
					$key = 5;
					break;
				default:
					$key = 6;
					break;
			}
			switch ($class[1]) {
				case '大':
				case '小':
					$temp = $temp['temp'][$key][0];
					break;
				case '单':
				case '双':
					$temp = $temp['temp'][$key][1];
					break;
				case '大单':
				case '大双':
				case '小单':
				case '小双':
					$temp = $temp['temp'][$key][2];
					break;
				case '合单':
				case '合双':
					$temp = $temp['temp'][$key][3];
					break;
				case '合大':
				case '合小':
					$temp = $temp['temp'][$key][4];
					break;
				case '尾大':
				case '尾小':
					$temp = $temp['temp'][$key][5];
					break;
				case '家禽':
				case '野兽':
					$temp = $temp['temp'][$key][6];
					break;
				case '红波':
				case '绿波':
				case '蓝波':
					$temp = $color[$temp['color'][$key]].'波';
					break;
				default:
					$temp = $temp['opencode'][$key];
					break;
			}
			break;
		case '正码':
			switch ($class[1]) {
				case '总单':
				case '总双':
					$temp = '总'.$temp['info'][1];
					break;
				case '总大':
				case '总小':
					$temp = '总'.$temp['info'][2];
					break;
				default:
					unset($temp['opencode'][6]);
					$temp = in_array($class[1], $temp['opencode']);
					$temp = $temp?$class[1]:-1;
					break;
			}
			break;
		case '过关':
			$list = explode(',', $class[1]);
			$valid = 1;
			foreach($list as $class){
				$class = explode('@', $class);
				$class = explode('-', $class[0]);
				switch ($class[0]) {
					case '正码1':
						$key = 0;
						break;
					case '正码2':
						$key = 1;
						break;
					case '正码3':
						$key = 2;
						break;
					case '正码4':
						$key = 3;
						break;
					case '正码5':
						$key = 4;
						break;
					case '正码6':
						$key = 5;
						break;
					default:
						$temp = -1;
						break 3;
				}
				switch ($class[1]) {
					case '大':
					case '小':
						$class[1]==$temp['temp'][$key][0]&&$valid++;
						break;
					case '单':
					case '双':
						$class[1]==$temp['temp'][$key][1]&&$valid++;
						break;
					case '红波':
					case '绿波':
					case '蓝波':
						$class[1]==$color[$temp['color'][$key]].'波'&&$valid++;
						break;
					default:
						$temp = -1;
						break 3;
				}
			}
			$class[1] = count($list)+1;
			$temp = $valid;
			break;
		case '半波':
			if($temp['opencode'][6]==49){
				$temp = '和';
			}else{
				switch ($class[1]) {
					case '红大':
					case '绿大':
					case '蓝大':
					case '红小':
					case '绿小':
					case '蓝小':
						$key = 0;
						break;
					case '红单':
					case '绿单':
					case '蓝单':
					case '红双':
					case '绿双':
					case '蓝双':
						$key = 1;
						break;
					default:
						$key = 3;
						break;
				}
				$temp = $color[$temp['color'][6]].$temp['temp'][6][$key];
			}
			break;
		case '一肖':
			$temp = in_array($class[1], $temp['animal'])?1:-1;
			$class[1] = 1;
			break;
		case '尾数':
			foreach($temp['opencode'] as $ball){
				if(substr($ball, -1)==$class[1]){
					$temp = $class[1];
					break 2;
				}
			}
			$temp = -1;
			$class[1] = 1;
			break;
		case '特肖':
			$temp = $temp['animal'][6];
			break;
		case '二肖连中':
		case '三肖连中':
		case '四肖连中':
		case '五肖连中':
			$list = explode(',', $class[1]);
			$class[1] = 1;
			foreach($list as $val){
				in_array($val, $temp['animal'])&&$class[1]++;
			}
			$temp = count($list)+1;
			break;
		case '二肖连不中':
		case '三肖连不中':
		case '四肖连不中':
			$list = explode(',', $class[1]);
			$class[1] = count($list)+1;
			foreach($list as $val){
				!in_array($val, $temp['animal'])&&$class[1]--;
			}
			$temp = 1;
			break;
		case '二尾连中':
		case '三尾连中':
		case '四尾连中':
			$list = explode(',', $class[1]);
			$class[1] = 1;
			foreach($temp['opencode'] as $key=>$val){
				$temp['opencode'][$key] = substr($val, -1);
			}
			foreach($list as $val){
				in_array($val, $temp['opencode'])&&$class[1]++;
			}
			$temp = count($list)+1;
			break;
		case '二尾连不中':
		case '三尾连不中':
		case '四尾连不中':
			$list = explode(',', $class[1]);
			$class[1] = count($list)+1;
			foreach($temp['opencode'] as $key=>$val){
				$temp['opencode'][$key] = substr($val, -1);
			}
			foreach($list as $val){
				!in_array($val, $temp['opencode'])&&$class[1]--;
			}
			$temp = 1;
			break;
		case '二肖':
		case '三肖':
		case '四肖':
		case '五肖':
		case '六肖':
		case '七肖':
		case '八肖':
		case '九肖':
		case '十肖':
		case '十一肖':
			if($temp['opencode'][6]==49){
				$temp = '和';
			}else{
				$list = explode(',', $class[1]);
				$class[1] = 1;
				$temp = in_array($temp['animal'][6], $list)?1:-1;
			}
			break;
		case '五不中':
		case '六不中':
		case '七不中':
		case '八不中':
		case '九不中':
		case '十不中':
		case '十一不中':
		case '十二不中':
			$list = explode(',', $class[1]);
			$class[1] = count($list)+1;
			foreach($list as $val){
				!in_array($val, $temp['opencode'])&&$class[1]--;
			}
			$temp = 1;
			break;
		case '三全中':
		case '二全中':
			$list = explode(',', $class[1]);
			$class[1] = 1;
			unset($temp['opencode'][6]);
			foreach($list as $val){
				in_array($val, $temp['opencode'])&&$class[1]++;
			}
			$temp = count($list)+1;
			break;
		case '三中二':
			$list = explode(',', $class[1]);
			$class[1] = 1;
			unset($temp['opencode'][6]);
			foreach($list as $val){
				in_array($val, $temp['opencode'])&&$class[1]++;
			}
			if(count($list)+1==$class[1]){
				$class[1] = 1;
			}else if(count($list)==$class[1]){
				$class[1] = 1;
				$okey = 1;
			}else{
				$class[1] = -1;
			}
			$temp = 1;
			break;
		case '二中特':
			$list = explode(',', $class[1]);
			$class[1] = -1;
			if(in_array($temp['opencode'][6], $list)){
				unset($temp['opencode'][6]);
				foreach($list as $val){
					if(in_array($val, $temp['opencode'])){
						$class[1] = 1;
						break;
					}
				}
			}else{
				unset($temp['opencode'][6]);
				$class[1] = 1;
				foreach($list as $val){
					in_array($val, $temp['opencode'])&&$class[1]++;
				}
				if(count($list)+1==$class[1]){
					$class[1] = 1;
					$okey = 1;
				}else{
					$class[1] = -1;
				}
			}
			$temp = 1;
			break;
		case '特串':
			$list = explode(',', $class[1]);
			$class[1] = -1;
			if(in_array($temp['opencode'][6], $list)){
				unset($temp['opencode'][6]);
				foreach($list as $val){
					if(in_array($val, $temp['opencode'])){
						$class[1] = 1;
						break;
					}
				}
			}
			$temp = 1;
			break;
		case '四中一':
			$list = explode(',', $class[1]);
			$class[1] = 1;
			unset($temp['opencode'][6]);
			foreach($list as $val){
				in_array($val, $temp['opencode'])&&$class[1]++;
			}
			$temp = $class[1]>1?$class[1]:-1;
			break;
		default:
			$temp = -1;
			$class[1] = 1;
			break;
	}
	$temp = strval($temp);
	if(strval($class[1])==$temp){
		$return[0] = $money*$odds[$okey];
	}else if($temp=='和'){
		$return[0] = $money;
	}
	$return[1] = $odds[$okey];
	return $return;
}