<?php 
function Ssc_Auto($num, $type){
	$zh = $num[0] + $num[1] + $num[2] + $num[3] + $num[4];
	if ($type == 1){ return $zh;}

	if ($type == 2){
		if (23 <= $zh){ return '总和大';}
		if ($zh <= 23){ return '总和小';}
	}

	if ($type == 3){
		if ($zh % 2 == 0){ return '总和双';}else{return '总和单';}
	}

	if ($type == 4){
		if ($num[4] < $num[0]){	return '龙';}
		if ($num[0] < $num[4]){ return '虎';}
		if ($num[0] == $num[4]){ return '和';}
	}

	if ($type == 5){
		$a = $num[0] . $num[1] . $num[2];
		$hm = array();
		$hm[] = $num[0];
		$hm[] = $num[1];
		$hm[] = $num[2];
		sort($hm);
		$match = '/.09|0.9/';
		if (($num[0] == $num[1]) && ($num[0] == $num[2]) && ($num[1] == $num[2])){
			return '豹子';
		}else if (($num[0] == $num[1]) || ($num[0] == $num[2]) || ($num[1] == $num[2])){
			return '对子';
		}else if (($a == '019') || ($a == '091') || ($a == '098') || ($a == '089') || ($a == '109') || ($a == '190') || ($a == '901') || ($a == '910') || ($a == '809') || ($a == '890') || sorts($hm, 3)){
			return '顺子';
		}else if (preg_match($match, $a) || sorts($hm, 2)){
			return '半顺';
		}else{
			return '杂六';
		}
	}

	if ($type == 6){
		$a = $num[1] . $num[2] . $num[3];
		$hm = array();
		$hm[] = $num[1];
		$hm[] = $num[2];
		$hm[] = $num[3];
		sort($hm);
		$match = '/.09|0.9/';
		if (($num[1] == $num[2]) && ($num[1] == $num[3]) && ($num[2] == $num[3])){
			return '豹子';
		}else if (($num[1] == $num[2]) || ($num[1] == $num[3]) || ($num[2] == $num[3])){
			return '对子';
		}else if (($a == '019') || ($a == '091') || ($a == '098') || ($a == '089') || ($a == '109') || ($a == '190') || ($a == '901') || ($a == '910') || ($a == '809') || ($a == '890') || sorts($hm, 3)){
			return '顺子';
		}else if (preg_match($match, $a) || sorts($hm, 2)){
			return '半顺';
		}else{
			return '杂六';
		}
	}

	if ($type == 7){
		$a = $num[2] . $num[3] . $num[4];
		$hm = array();
		$hm[] = $num[2];
		$hm[] = $num[3];
		$hm[] = $num[4];
		sort($hm);
		$match = '/.09|0.9/';
		if (($num[2] == $num[3]) && ($num[2] == $num[4]) && ($num[3] == $num[4])){
			return '豹子';
		}else if (($num[2] == $num[3]) || ($num[2] == $num[4]) || ($num[3] == $num[4])){
			return '对子';
		}else if (($a == '019') || ($a == '091') || ($a == '098') || ($a == '089') || ($a == '109') || ($a == '190') || ($a == '901') || ($a == '910') || ($a == '809') || ($a == '890') || sorts($hm, 3)){
			return '顺子';
		}else if (preg_match($match, $a) || sorts($hm, 2)){
			return '半顺';
		}else{
			return '杂六';
		}
	}
}

function Ssc_Ds($ball){
	if ($ball % 2 == 0){
		return '双';
	}else{
		return '单';
	}
}

function Ssc_Dx($ball){
	if (4 < $ball){
		return '大';
	}else{
		return '小';
	}
}

function sorts($a, $p){
	$i = 0;
	foreach ($a as $k => $v){
		if (in_array((($v + 10) - 1) % 10, $a) || in_array(($v + 1) % 10, $a)){
			$i++;
		}
	}

	if ($p <= $i){
		$a = true;
	}else{
		$a = false;
	}
	return $a;
}

?>