<?php 
$text = date('Y-m-d H:i:s');
$class11 = ka_bl($rate_id, 'class1');
$class22 = ka_bl($rate_id, 'class2');
if (($class22 == '二肖') || ($class22 == '三肖') || ($class22 == '五肖') || ($class22 == '六肖') || ($class22 == '四肖')){
	$class33 = ka_bl($rate_id, 'class3');
}
switch (ka_bl($rate_id, 'class1')){
	case '特码': switch (ka_bl($rate_id, 'class3')){
		case '单': $ztm1 = ka_config(4);
		break;
		case '家禽': $ztm1 = ka_config(4);
		break;
		case '野兽': $ztm1 = ka_config(4);
		break;
		case '双': $ztm1 = ka_config(4);
		break;
		case '合单': $ztm1 = ka_config(4);
		break;
		case '合双': $ztm1 = ka_config(4);
		break;
		case '大': $ztm1 = ka_config(4);
		break;
		case '小': $ztm1 = ka_config(4);
		break;
		case '红波': $ztm1 = ka_config(5);
		break;
		case '蓝波': $ztm1 = ka_config(5);
		break;
		case '绿波': $ztm1 = ka_config(5);
		break;
		default: $ztm1 = ka_config(3);
		break;
	}
	$params = array(':drop_sort' => $drop_sort);
	$stmt = $mydata2_db->prepare('Select drop_sort,drop_value,drop_unit,low_drop from ka_drop where drop_sort=:drop_sort order by id');
	$stmt->execute($params);
	$image = $stmt->fetch();
	@($drop = intval((ka_bl($rate_id, 'gold') + $sum_m) / $image['drop_value']) * $image['drop_unit']);
	@($num1 = (ka_bl($rate_id, 'gold') + $sum_m) % $image['drop_value']);
	$zpm1 = $image['low_drop'];
	$zpm2 = $image['low_drop'] + $ztm1;
	$low_drop = $image['low_drop'];
	if (ka_bl($rate_id, 'class2') == '特B'){
		$low_drop = $image['low_drop'] + $zmt1;
	}
	$params = array(':gold' => $num1, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33);
	$stmt = $mydata2_db->prepare('update ka_bl set gold=:gold where class1=:class1 and class2=:class2 and class3=:class3');
	$stmt->execute($params);
	if ($low_drop < (ka_bl($rate_id, 'rate') - $drop)){
		$params = array(':adddate' => $text, ':drop' => $drop, ':class1' => $class11, ':class3' => $class33);
		$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=rate-:drop where class1=:class1 and class2 in (\'特A\',\'特B\') and class3=:class3');
		$stmt->execute($params);
	}else{
		$params = array(':adddate' => $text, ':rate' => $zpm1, ':class1' => $class11, ':class3' => $class33);
		$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=:rate where class1=:class1 and class2=\'特A\' and class3=:class3');
		$stmt->execute($params);
		$params = array(':adddate' => $text, ':rate' => $zpm2, ':class1' => $class11, ':class3' => $class33);
		$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=:rate where class1=:class1 and class2=\'特B\' and class3=:class3');
		$stmt->execute($params);
	}
	break;
	case '正码': switch (ka_bl($rate_id, 'class3')){
		case '总单': $ztm1 = ka_config(7);
		break;
		case '总双': $ztm1 = ka_config(7);
		break;
		case '总大': $ztm1 = ka_config(7);
		break;
		case '总小': $ztm1 = ka_config(7);
		break;
		default: $ztm1 = ka_config(6);
		break;
	}
	$params = array(':drop_sort' => $drop_sort);
	$stmt = $mydata2_db->prepare('Select drop_sort,drop_value,drop_unit,low_drop from ka_drop where drop_sort=:drop_sort order by id');
	$stmt->execute($params);
	$image = $stmt->fetch();
	@($drop = intval((ka_bl($rate_id, 'gold') + $sum_m) / $image['drop_value']) * $image['drop_unit']);
	@($num1 = (ka_bl($rate_id, 'gold') + $sum_m) % $image['drop_value']);
	$zpm1 = $image['low_drop'];
	$zpm2 = $image['low_drop'] + $ztm1;
	$low_drop = $image['low_drop'];
	if (ka_bl($rate_id, 'class2') == '正B'){
		$low_drop = $image['low_drop'] + $zmt1;
	}
	$params = array(':gold' => $num1, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33);
	$stmt = $mydata2_db->prepare('update ka_bl set gold=:gold where class1=:class1 and class2=:class2 and class3=:class3');
	$stmt->execute($params);
	if ($low_drop < (ka_bl($rate_id, 'rate') - $drop)){
		$params = array(':adddate' => $text, ':drop' => $drop, ':class1' => $class11, ':class3' => $class33);
		$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=rate-:drop where class1=:class1 and class2 in (\'正A\',\'正B\') and class3=:class3');
		$stmt->execute($params);
	}else{
		$params = array(':adddate' => $text, ':rate' => $zpm1, ':class1' => $class11, ':class3' => $class33);
		$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=:rate where class1=:class1 and class2=\'正A\' and class3=:class3');
		$stmt->execute($params);
		$params = array(':adddate' => $text, ':rate' => $zpm2, ':class1' => $class11, ':class3' => $class33);
		$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=:rate where class1=:class1 and class2=\'正B\' and class3=:class3');
		$stmt->execute($params);
	}
	break;
	default: $params = array(':drop_sort' => $drop_sort);
	$stmt = $mydata2_db->prepare('Select drop_sort,drop_value,drop_unit,low_drop from ka_drop where drop_sort=:drop_sort order by id');
	$stmt->execute($params);
	$image = $stmt->fetch();
	@($drop = intval((ka_bl($rate_id, 'gold') + $sum_m) / $image['drop_value']) * $image['drop_unit']);
	@($num1 = (ka_bl($rate_id, 'gold') + $sum_m) % $image['drop_value']);
	$zpm1 = $image['low_drop'];
	$zpm2 = $image['low_drop'];
	$low_drop = $image['low_drop'];
	$params = array(':gold' => $num1, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33);
	$stmt = $mydata2_db->prepare('update ka_bl set gold=:gold where class1=:class1 and class2=:class2 and class3=:class3');
	$stmt->execute($params);
	if ($low_drop < (ka_bl($rate_id, 'rate') - $drop)){
		$params = array(':adddate' => $text, ':drop' => $drop, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33);
		$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=rate-:drop where class1=:class1 and class2=:class2 and class3=:class3');
		$stmt->execute($params);
	}else{
		$params = array(':adddate' => $text, ':rate' => $zpm1, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33);
		$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=:rate where class1=:class1 and class2=:class2 and class3=:class3');
		$stmt->execute($params);
	}
	break;
}
?>