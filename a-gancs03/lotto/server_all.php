<?php 
if (!defined('PHPYOU')){
	exit('非法进入');
}

if ($_GET['kithe'] != ''){
	$kithe = $_GET['kithe'];
}else{
	$kithe = $Current_Kithe_Num;
}

$z_re = 0;
$z_sum = 0;
$z_suma = 0;
$z_sumb = 0;
$z_ds = 0;
$z_xx = 0;
$z_pz = 0;
$result = $mydata2_db->query('select distinct(class2),class1   from   ka_bl where class2<>\'特花\' order by id ');
$ii = 0;
while ($rs = $result->fetch()){
	$params = array(':Kithe' => $kithe, ':class1' => $rs['class1'], ':class2' => $rs['class2']);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe=:Kithe and lx=0 and  class1=:class1 and class2=:class2');
	$result1->execute($params);
	$Rs5 = $result1->fetch();
	$sum_tm[$ii] = $rs['class2'];
	$sum_re[$ii] = $Rs5['re'];
	if ($Rs5['sum_m'] != ''){
		$sum_m[$ii] = $Rs5['sum_m'];
	}else{
		$sum_m[$ii] = 0;
	}
	$z_re += $Rs5['re'];
	$z_sum += $Rs5['sum_m'];
	$ii++;
}
$params = array(':Kithe' => $kithe);
$result2 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re,sum(0-sum_m*guan_ds/100*dagu_zc/10) as sum_ds,sum(0-sum_m*rate*dagu_zc/10) as sum_m3 from ka_tan   where Kithe=:Kithe and lx=0 and  class1=\'过关\' ');
$result2->execute($params);
$Rs6 = $result2->fetch();
$sum_tm[$ii] = '过关';
$sum_re[$ii] = $Rs6['re'];
if ($Rs6['sum_m'] != ''){
	$sum_m[$ii] = $Rs6['sum_m'];
}else{
	$sum_m[$ii] = 0;
}
$z_re += $Rs6['re'];
$z_sum += $Rs6['sum_m'];
$ii++;
$b = 0;
$fg = 0;
$i = 0;
$i = 0;

for ($i = 0;;$i < $ii;$i++){
	$blbl .= $sum_tm[$i] . '@@@' . $sum_re[$i] . '注@@@' . $sum_m[$i] . '###';
}
$blbl .= '0@@@<font color=ff6600>' . $z_re . '注</font>@@@<font color=ff6600>' . $z_sum . '</font>###';
echo $blbl;
?>