<?php 
header('content-Type: text/html;charset=utf-8');
if (!defined('PHPYOU')){
	exit('非法进入');
}
$class1 = $_GET['class1'];
$class2 = $_GET['class2'];
//echo $class1."-".$class2;exit;
if (($class1 == '正1-6') || ($class1 == '正码1-6') || ($class1 == '过关') || ($class1 == '连码') || ($class1 == '半波') || ($class1 == '尾数') || ($class1 == '单双大小') || ($class1 == '一字') || ($class1 == '二字') || ($class1 == '三字') || ($class1 == '一字过关') || ($class1 == '跨度') || ($class1 == '组选三') || ($class1 == '组选六')){
	if ($class1 == '正1-6'){
		$params = array(':class1' => $class1);
		$stmt = $mydata2_db->prepare('select * from ka_bl where class1=:class1 order by class2,id');
		$stmt->execute($params);
	}else if ($class1 == '正码1-6'){
		$params = array();
		$stmt = $mydata2_db->prepare('select * from ka_bl where class1=\'正1-6\' order by class2,id');
		$stmt->execute($params);
	}else if ($class1 == '单双大小'){
		$params = array();
		$stmt = $mydata2_db->prepare('select * from ka_bl where   (class3=\'单\' or class3=\'双\' or class3=\'大\' or class3=\'小\' or  class3=\'合单\' or class3=\'合双\' or class3=\'红波\' or class3=\'绿波\' or class3=\'蓝波\' or class3=\'总单\' or class3=\'总双\' or class3=\'总大\' or class3=\'总小\') and (class2=\'正1特\' or class2=\'正2特\' or class2=\'正3特\' or class2=\'正4特\' or class2=\'正5特\'  or class2=\'正6特\' or class2=\'特A\' or class2=\'正A\')  order by class2,id');
		$stmt->execute($params);
	}else if ($class1 == '尾数'){
		$params = array();
		$stmt = $mydata2_db->prepare('select * from ka_bl where class1=\'头数\' or class1=\'尾数\'  order by id');
		$stmt->execute($params);
	}else if (($class1 == '一字') || ($class1 == '二字') || ($class1 == '三字') || ($class1 == '一字过关') || ($class1 == '跨度') || ($class1 == '组选三') || ($class1 == '组选六')){
		$params = array(':class1' => $class1, ':class2' => $class2);
		$stmt = $mydata2_db->prepare('select * from 3dka_bl where class1=:class1 and class2=:class2 order by id');
		$stmt = $stmt->execute($params);
	}else{
		$params = array(':class1' => $class1);
		$stmt = $mydata2_db->prepare('select * from ka_bl where   class1=:class1  order by id');
		$stmt->execute($params);
	}
}else if (($class1 == '生肖') && ($class2 == '一肖')){
	$params = array(':class1' => $class1, ':class2' => $class2);
	$stmt = $mydata2_db->prepare('select * from ka_bl where  (class1=:class1 and class2=:class2) or (class1=\'正特尾数\' and class2=\'正特尾数\') order by id');
	$stmt->execute($params);
}else if (($class1 == '正肖') && ($class2 == '正肖')){
	$params = array(':class1' => $class1, ':class2' => $class2);
	$stmt = $mydata2_db->prepare('select * from ka_bl where  (class1=:class1 and class2=:class2) or (class1=\'七色波\' and class2=\'七色波\') order by id desc');
	$stmt->execute($params);
}else{
	$params = array(':class1' => $class1, ':class2' => $class2);
	$stmt = $mydata2_db->prepare('select * from ka_bl where  class1=:class1 and class2=:class2 order by id');
	$stmt->execute($params);
}

while ($image = $stmt->fetch()){
	if ($class1 == '连码')
	{
		$params = array(':Kithe' => $Current_Kithe_Num, ':class1' => $image['class1'], ':class2' => $image['class2'], ':username' => $_SESSION['username']);
		$stmtSub = $mydata2_db->prepare('Select SUM(sum_m) As sum_m from ka_tan where Kithe=:Kitheand and class1=:class1 and class2=:class2 and username=:username');
		$stmtSub->execute($params);
		$rs5 = $stmtSub->fetch();
	}else{
		$params = array(':Kithe' => $Current_Kithe_Num, ':class1' => $image['class1'], ':class2' => $image['class2'], ':class3' => $image['class3']);
		$stmtSub = $mydata2_db->prepare('Select SUM(sum_m) As sum_m from ka_tan where Kithe=:Kithe and class1=:class1 and class2=:class2 and class3=:class3');
		$stmtSub->execute($params);
		$rs5 = $stmtSub->fetch();
	}
	if ($rs5['sum_m'] == ''){
		$sum_m = 0;
	}else{
		$sum_m = $rs5['sum_m'];
	}
	$rate = $image['rate'];
	$blbl .= $image['class3'] . '@@@' . $rate . '@@@' . $image['blrate'] . '@@@' . $sum_m . '@@@' . $image['xr'] . '@@@' . $image['locked'] . '###';
}
echo $blbl;
$ddf = date('Y-m-d H:i:s', time() - 20);
$params = array(':class1' => $class1, ':adddate' => $ddf);
$stmt = $mydata2_db->prepare('update ka_bl set blrate=rate where class1=:class1 and blrate<>rate and adddate<:adddate');
$stmt->execute($params);
?>