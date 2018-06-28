<?php
if(!defined('PHPYOU')) {
	exit('非法进入');
}

$class1=$_GET['class1'];
$class2=$_GET['class2'];
$blbl = $class1."--".$class2;

if ($class1=="正1-6" or $class1=="过关" or $class1=="连码" or $class1=="半波" or $class1=="半半波" or $class1=="头数" or $class1=="尾数" or $class1=="正特尾数" or $class1=="七色波" or $class1=="正肖"){
	$params = array(':class1' => $class1);
	$sql = 'select * from ka_bl where  class1=:class1';
	if ($class1 == '正特尾数'){
		$sql .= ' or (class1=\'生肖\' and class2=\'一肖\')';
	}
	
	if ($class1 == '连码'){
		$sql .= '  order by id';
	}else{
		$sql .= '  order by class2,id';
	}
	$result = $mydata2_db->prepare($sql);
	$result->execute($params);
}else{
	if ($class1 == '头尾数')
	{
		$sql_ts = 'Select * from (Select * from ka_bl where class1=\'头数\'   Order By ID) as a';
		$sql_ws = 'Select * from (Select * from ka_bl where class1=\'尾数\'   Order By ID) as b';
		$sql = 'Select c.* from (' . $sql_ts . ' union all ' . $sql_ws . ') as c';
		$result = $mydata2_db->query($sql);
	}else if ($class1 == '生肖'){
		$params = array(':class2' => $class2);
		$result = $mydata2_db->prepare('Select * from ka_bl where (class1=\'生肖\' and class2=:class2) Order By ID');
		$result->execute($params);
	}else if ($class1 == '生肖连'){
		$params = array(':class2' => $class2);
		$result = $mydata2_db->prepare('Select * from ka_bl where (class1=\'生肖连\' and class2=:class2) Order By ID');
		$result->execute($params);
	}else if ($class1 == '正色波'){
		$result = $mydata2_db->query('Select rate,class3,class2,locked,class1 from ka_bl where class1=\'七色波\' or class1=\'正肖\'   Order By ID Desc');
	}else{
		$params = array(':class1' => $class1, ':class2' => $class2);
		$result = $mydata2_db->prepare('select * from ka_bl where  class1=:class1 and class2=:class2 order by id');
	}
	$result->execute($params);
}


while ($image = $result->fetch()){
	if (($class1 == '生肖') || ($class1 == '生肖连')){
		$params = array(':kithe' => $Current_Kithe_Num, ':class1' => $image['class1'], ':class2' => $image['class2'], ':class3' => $image['class3']);
		$result1 = $mydata2_db->prepare('Select SUM(sum_m) As sum_m from ka_tan where kithe=:kithe and  class1=:class1 and  class2=:class2 and class3=:class3 ');
		$result1->execute($params);
		$rs5_sum_m = $result1->fetchColumn();
	}else{
		$params = array(':kithe' => $Current_Kithe_Num, ':class1' => $image['class1'], ':class2' => $image['class2'], ':class3' => $image['class3']);
		$result2 = $mydata2_db->prepare('Select SUM(sum_m) As sum_m from ka_tan where kithe=:kithe and  class1=:class1 and  class2=:class2 and class3=:class3 ');
		$result2->execute($params);
		$rs5_sum_m = $result2->fetchColumn();
	}
	
	if ($rs5_sum_m == ''){
		$sum_m = 0;
	}else{
		$sum_m = $rs5_sum_m;
	}
	
	$rate = $image['rate'];
	if ($image['rate'] != $image['blrate']){
		$blbl .= $image['class3'] . '@@@' . $rate . '@@@' . $image['rate'] . '@@@' . $sum_m . '###';
	}else{
		$blbl .= $image['class3'] . '@@@' . $rate . '@@@' . $image['rate'] . '@@@' . $sum_m . '###';
	}
}
print_r($blbl);
$ddf = date('Y-m-d H:i:s', time() - 20);
if ($class1 == '头尾数'){
	$params = array(':adddate' => $ddf);
	$stmt = $mydata2_db->prepare('update ka_bl set blrate=rate where class1=\'头数\' and blrate<>rate and adddate<:adddate');
	$stmt->execute($params);
	$params = array(':adddate' => $ddf);
	$stmt = $mydata2_db->prepare('update ka_bl set blrate=rate where class1=\'尾数\' and blrate<>rate and adddate<:adddate');
	$stmt->execute($params);
}else{
	$params = array(':class1' => $class1, ':adddate' => $ddf);
	$stmt = $mydata2_db->prepare('update ka_bl set blrate=rate where class1=:class1 and blrate<>rate and adddate<:adddate');
	$stmt->execute($params);
}
?>