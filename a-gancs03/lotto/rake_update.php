<?php 
require_once dirname(__FILE__) . '/conjunction.php';
$text = date('Y-m-d H:i:s');
$commandName = $_GET['commandName'];
$class1 = $_GET['class1'];
$ids = $_GET['ids'];
$class3 = $_GET['class3'];
$qtqt = $_GET['qtqt'];
$lxlx = $_GET['lxlx'];
if ($commandName == 'MODIFYRATE'){
	if ($lxlx == 1){
		if (($class1 == '特码') || ($class1 == '正码')){
			$params = array(':adddate' => $text, ':rate' => $qtqt, ':class1' => $class1, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=round(rate+:rate,2)  where class1=:class1  and   class3=:class3');
			$stmt->execute($params);
		}else if ($class1 == '正特'){
			if ($ids == '正1特'){
				$class22 = '正码1';
			}
			
			if ($ids == '正2特'){
				$class22 = '正码2';
			}
			
			if ($ids == '正3特'){
				$class22 = '正码3';
			}
			
			if ($ids == '正4特'){
				$class22 = '正码4';
			}
			
			if ($ids == '正5特'){
				$class22 = '正码5';
			}
			
			if ($ids == '正6特'){
				$class22 = '正码6';
			}
			
			if (($class3 == '单') || ($class3 == '双') || ($class3 == '大') || ($class3 == '小') || ($class3 == '红波') || ($class3 == '蓝波') || ($class3 == '绿波')){
				$params = array(':adddate' => $text, ':rate' => $qtqt, ':class2' => $class22, ':class3' => $class3);
				$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=round(rate+:rate,2)  where class1=\'过关\' and class2=:class2  and   class3=:class3');
				$stmt->execute($params);
				$params = array(':adddate' => $text, ':rate' => $qtqt, ':class1' => $class1, ':class2' => $ids, ':class3' => $class3);
				$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=round(rate+:rate,2)  where class1=:class1 and class2=:class2  and   class3=:class3');
				$stmt->execute($params);
			}else{
				$params = array(':adddate' => $text, ':rate' => $qtqt, ':class1' => $class1, ':class2' => $ids, ':class3' => $class3);
				$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=round(rate+:rate,2)  where class1=:class1 and class2=:class2  and   class3=:class3');
				$stmt->execute($params);
			}
		}else{
			$params = array(':adddate' => $text, ':rate' => $qtqt, ':class1' => $class1, ':class2' => $ids, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=round(rate+:rate,2)  where class1=:class1 and class2=:class2  and   class3=:class3');
			$stmt->execute($params);
		}
	}else if (($class1 == '特码') || ($class1 == '正码')){
		$params = array(':adddate' => $text, ':rate' => $qtqt, ':class1' => $class1, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=round(rate-:rate,2) where class1=:class1  and   class3=:class3');
		$stmt->execute($params);
	}else if ($class1 == '正特'){
		if ($ids == '正1特'){
			$class22 = '正码1';
		}
		
		if ($ids == '正2特'){
			$class22 = '正码2';
		}
		
		if ($ids == '正3特'){
			$class22 = '正码3';
		}
		if ($ids == '正4特')
		{
			$class22 = '正码4';
		}
		if ($ids == '正5特')
		{
			$class22 = '正码5';
		}
		if ($ids == '正6特')
		{
			$class22 = '正码6';
		}
		if (($class3 == '单') || ($class3 == '双') || ($class3 == '大') || ($class3 == '小') || ($class3 == '红波') || ($class3 == '蓝波') || ($class3 == '绿波'))
		{
			$params = array(':adddate' => $text, ':rate' => $qtqt, ':class2' => $class22, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=round(rate-:rate,2) where class1=\'过关\' and class2=:class2  and   class3=:class3');
			$stmt->execute($params);
			$params = array(':adddate' => $text, ':rate' => $qtqt, ':class1' => $class1, ':class2' => $ids, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=round(rate-:rate,2) where class1=:class1 and class2=:class2  and   class3=:class3');
			$stmt->execute($params);
		}
		else
		{
			$params = array(':adddate' => $text, ':rate' => $qtqt, ':class1' => $class1, ':class2' => $ids, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=round(rate-:rate,2) where class1=:class1 and class2=:class2  and   class3=:class3');
			$stmt->execute($params);
		}
	}
	else
	{
		$params = array(':adddate' => $text, ':rate' => $qtqt, ':class1' => $class1, ':class2' => $ids, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_bl set adddate=:adddate,rate=round(rate-:rate,2) where class1=:class1 and class2=:class2 and   class3=:class3');
		$stmt->execute($params);
	}
	$params = array(':class1' => $class1, ':class2' => $ids, ':class3' => $class3);
	$result3 = $mydata2_db->prepare('select * from ka_bl where  class1=:class1 and class2=:class2 and class3=:class3 order by id');
	$result3->execute($params);
	$image = $result3->fetch();
	$rate = $image['rate'];
 	echo $rate;
	exit();
}

if ($commandName == 'LOCK'){
	$lock = $_GET['lock'];
	if ($lock == 'true')
	{
		$lock1 = 1;
	}else{
		$lock1 = 0;
	}
	$params = array(':locked' => $lock1, ':class1' => $class1, ':class2' => $ids, ':class3' => $class3);
	$stmt = $mydata2_db->prepare('update ka_bl set locked=:locked where class1=:class1 and class2=:class2 and   class3=:class3');
	$stmt->execute($params);
 	echo $lock1;
	exit();
}
?>
