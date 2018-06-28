<?php 
if (!defined('PHPYOU')){
	exit('非法进入');
}

$result = $mydata2_db->query('select * from adad order by id');
$row = $result->fetch();
$best = $row['best'];
$zm = $row['zm'];
$zm6 = $row['zm6'];
$lm = $row['lm'];
$zlm = $row['zlm'];
$ys = $row['ys'];
$ls = $row['ls'];
$dx = $row['dx'];
$tm = $row['tm'];
$spx = $row['spx'];
$bb = $row['bb'];
$zmt = $row['zmt'];
$ws = $row['ws'];
$zm1 = $row['zm1'];
$zm61 = $row['zm61'];
$lm1 = $row['lm1'];
$zlm1 = $row['zlm1'];
$ys1 = $row['ys1'];
$ls1 = $row['ls1'];
$dx1 = $row['dx1'];
$tm1 = $row['tm1'];
$spx1 = $row['spx1'];
$bb1 = $row['bb1'];
$zmt1 = $row['zmt1'];
$ws1 = $row['ws1'];
$ps1 = $row['ps1'];
$ps = $row['ps'];
if ($_GET['save'] == 'save'){
	$sxnum1 = '01,13,25,37,49';
	$sxnum2 = '02,14,26,38';
	$sxnum3 = '03,15,27,39';
	$sxnum4 = '04,16,28,40';
	$sxnum5 = '05,17,29,41';
	$sxnum6 = '06,18,30,42';
	$sxnum7 = '07,19,31,43';
	$sxnum8 = '08,20,32,44';
	$sxnum9 = '09,21,33,45';
	$sxnum10 = '10,22,34,46';
	$sxnum11 = '11,23,35,47';
	$sxnum12 = '12,24,36,48';
	switch ($_POST['sanimal']){
		case 0: $params = array(':m_number' => $sxnum12);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=11');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum10);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=12');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum8);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=7');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum6);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=8');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum4);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=9');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum2);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=10');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum11);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=6');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum9);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=1');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum7);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=2');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum5);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=3');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum3);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=4');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum1);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=5');
		$stmt->execute($params);
		break;
		case 1: $params = array(':m_number' => $sxnum12);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=5');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum10);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=6');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum8);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=1');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum6);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=2');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum4);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=3');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum2);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=4');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum11);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=11');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum9);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=12');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum7);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=7');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum5);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=8');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum3);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=9');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum1);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=10');
		$stmt->execute($params);
		break;
		case 2: $params = array(':m_number' => $sxnum12);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=10');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum10);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=11');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum8);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=12');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum6);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=7');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum4);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=8');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum2);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=9');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum11);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=5');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum9);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=6');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum7);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=1');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum5);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=2');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum3);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=3');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum1);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=4');
		$stmt->execute($params);
		break;
		case 3: $params = array(':m_number' => $sxnum12);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=4');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum10);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=5');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum8);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=6');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum6);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=1');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum4);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=2');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum2);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=3');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum11);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=10');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum9);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=11');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum7);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=12');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum5);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=7');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum3);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=8');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum1);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=9');
		$stmt->execute($params);
		break;
		case 4: $params = array(':m_number' => $sxnum12);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=9');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum10);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=10');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum8);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=11');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum6);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=12');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum4);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=7');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum2);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=8');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum11);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=4');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum9);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=5');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum7);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=6');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum5);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=1');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum3);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=2');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum1);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=3');
		$stmt->execute($params);
		break;
		case 5: $params = array(':m_number' => $sxnum12);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=3');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum10);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=4');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum8);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=5');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum6);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=6');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum4);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=1');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum2);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=2');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum11);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=9');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum9);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=10');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum7);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=11');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum5);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=12');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum3);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=7');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum1);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=8');
		$stmt->execute($params);
		break;
		case 6: $params = array(':m_number' => $sxnum12);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=8');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum10);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=9');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum8);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=10');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum6);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=11');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum4);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=12');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum2);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=7');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum11);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=3');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum9);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=4');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum7);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=5');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum5);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=6');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum3);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=1');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum1);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=2');
		$stmt->execute($params);
		break;
		case 7: $params = array(':m_number' => $sxnum12);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=2');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum10);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=3');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum8);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=4');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum6);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=5');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum4);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=6');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum2);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=1');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum11);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=8');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum9);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=9');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum7);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=10');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum5);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=11');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum3);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=12');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum1);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=7');
		$stmt->execute($params);
		break;
		case 8: $params = array(':m_number' => $sxnum12);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=7');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum10);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=8');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum8);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=9');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum6);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=10');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum4);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=11');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum2);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=12');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum11);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=2');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum9);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=3');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum7);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=4');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum5);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=5');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum3);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=6');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum1);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=1');
		$stmt->execute($params);
		break;
		case 9: $params = array(':m_number' => $sxnum12);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=1');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum10);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=2');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum8);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=3');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum6);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=4');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum4);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=5');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum2);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=6');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum11);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=7');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum9);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=8');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum7);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=9');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum5);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=10');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum3);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=11');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum1);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=12');
		$stmt->execute($params);
		break;
		case 10: $params = array(':m_number' => $sxnum12);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=12');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum10);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=7');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum8);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=8');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum6);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=9');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum4);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=10');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum2);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=11');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum11);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=1');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum9);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=2');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum7);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=3');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum5);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=4');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum3);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=5');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum1);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=6');
		$stmt->execute($params);
		break;
		case 11: $params = array(':m_number' => $sxnum12);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=6');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum10);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=1');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum8);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=2');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum6);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=3');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum4);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=4');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum2);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=5');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum11);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=12');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum9);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=7');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum7);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=8');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum5);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=9');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum3);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=10');
		$stmt->execute($params);
		$params = array(':m_number' => $sxnum1);
		$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=11');
		$stmt->execute($params);
	}
	
	$params = array(':m_number' => $_POST['wxm1']);
	$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=25');
	$stmt->execute($params);
	
	$params = array(':m_number' => $_POST['wxm2']);
	$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=26');
	$stmt->execute($params);
	$params = array(':m_number' => $_POST['wxm3']);
	$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=27');
	$stmt->execute($params);
	$params = array(':m_number' => $_POST['wxm4']);
	$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=28');
	$stmt->execute($params);
	$params = array(':m_number' => $_POST['wxm5']);
	$stmt = $mydata2_db->prepare('update ka_sxnumber set m_number=:m_number where id=29');
	$stmt->execute($params);
	$params = array(':haffice2' => $_POST['haffice2'], ':sanimal' => $_POST['sanimal'], ':tm' => $_POST['tmzz'], ':tmdx' => $_POST['tmdx'], ':tmps' => $_POST['tmps'], ':zm' => $_POST['zmzz'], ':zmdx' => $_POST['zmdx'], ':ggpz' => $_POST['ggpz']);
	$stmt = $mydata2_db->prepare('Update config Set haffice2=:haffice2,sanimal=:sanimal,tm=:tm,tmdx=:tmdx,tmps=:tmps,zm=:zm,zmdx=:zmdx,ggpz=:ggpz where id=1');
	$stmt->execute($params);
	if($_POST['tmzz']>0){
		for ($I = 1;$I <= 49;$I = $I + 1){
			$params = array(':class3' => $I);
			$result = $mydata2_db->prepare('select * from ka_bl where  class2=\'特A\' and class3=:class3  order by id desc');
			$result->execute($params);
			$row = $result->fetch();
			if ($row != ''){
				$zu = $row['rate'];
				$zu = $zu + $_POST['tmzz'];
				$params = array(':rate' => $zu, ':rate2' => $zu, ':class3' => $I);
				$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'特B\' and class3=:class3');
				$stmt->execute($params);
			}
		}
	if($_POST['zmzz']>0){
			$params = array(':class3' => $I);
			$result = $mydata2_db->prepare('select * from ka_bl where  class2=\'正A\' and class3=:class3   order by id desc');
			$result->execute($params);
			$row = $result->fetch();
			if ($row != ''){
				$zu1 = $row['rate'];
				$zu1 = $zu1 + $_POST['zmzz'];
				$params = array(':rate' => $zu1, ':rate2' => $zu1, ':class3' => $I);
				$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'正B\' and class3=:class3');
				$stmt->execute($params);
			}
		}
	}
	if($_POST['tmdx']>0){
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'特A\' and class3=\'单\'   order by id desc');
		$row = $result->fetch();
		if ($row != ''){
			$zu = $row['rate'];
			$zu = $zu + $_POST['tmdx'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'特B\' and class3=\'单\'');
			$stmt->execute($params);
		}
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'特A\' and class3=\'双\'   order by id desc');
		$row = $result->fetch();
		if ($row != '')
		{
			$zu = $row['rate'];
			$zu = $zu + $_POST['tmdx'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'特B\' and class3=\'双\'');
			$stmt->execute($params);
		}
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'特A\' and class3=\'大\'   order by id desc');
		$row = $result->fetch();
		if ($row != '')
		{
			$zu = $row['rate'];
			$zu = $zu + $_POST['tmdx'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'特B\' and class3=\'大\'');
			$stmt->execute($params);
		}
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'特A\' and class3=\'小\'   order by id desc');
		$row = $result->fetch();
		if ($row != '')
		{
			$zu = $row['rate'];
			$zu = $zu + $_POST['tmdx'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'特B\' and class3=\'小\'');
			$stmt->execute($params);
		}
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'特A\' and class3=\'合单\'   order by id desc');
		$row = $result->fetch();
		if ($row != '')
		{
			$zu = $row['rate'];
			$zu = $zu + $_POST['tmdx'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'特B\' and class3=\'合单\'');
			$stmt->execute($params);
		}
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'特A\' and class3=\'合双\'   order by id desc');
		$row = $result->fetch();
		if ($row != '')
		{
			$zu = $row['rate'];
			$zu = $zu + $_POST['tmdx'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'特B\' and class3=\'合双\'');
			$stmt->execute($params);
		}
	}
	if($_POST['tmps']>0){
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'特A\' and class3=\'红波\'   order by id desc');
		$row = $result->fetch();
		if ($row != '')
		{
			$zu = $row['rate'];
			$zu = $zu + $_POST['tmps'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'特B\' and class3=\'红波\'');
			$stmt->execute($params);
		}
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'特A\' and class3=\'蓝波\'   order by id desc');
		$row = $result->fetch();
		if ($row != '')
		{
			$zu = $row['rate'];
			$zu = $zu + $_POST['tmps'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'特B\' and class3=\'蓝波\'');
			$stmt->execute($params);
		}
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'特A\' and class3=\'绿波\'   order by id desc');
		$row = $result->fetch();
		if ($row != '')
		{
			$zu = $row['rate'];
			$zu = $zu + $_POST['tmps'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'特B\' and class3=\'绿波\'');
			$stmt->execute($params);
		}
	}
	if($_POST['zmdx']>0){
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'正A\' and class3=\'总单\'   order by id desc');
		$row = $result->fetch();
		if ($row != '')
		{
			$zu = $row['rate'];
			$zu = $zu + $_POST['zmdx'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'正B\' and class3=\'总单\'');
			$stmt->execute($params);
		}
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'正A\' and class3=\'总双\'   order by id desc');
		$row = $result->fetch();
		if ($row != '')
		{
			$zu = $row['rate'];
			$zu = $zu + $_POST['zmdx'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'正B\' and class3=\'总双\'');
			$stmt->execute($params);
		}
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'正A\' and class3=\'总大\'   order by id desc');
		$row = $result->fetch();
		if ($row != '')
		{
			$zu = $row['rate'];
			$zu = $zu + $_POST['zmdx'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'正B\' and class3=\'总大\'');
			$stmt->execute($params);
		}
		$result = $mydata2_db->query('select * from ka_bl where  class2=\'正A\' and class3=\'总小\'   order by id desc');
		$row = $result->fetch();
		if ($row != '')
		{
			$zu = $row['rate'];
			$zu = $zu + $_POST['zmdx'];
			$params = array(':rate' => $zu, ':rate2' => $zu);
			$stmt = $mydata2_db->prepare('update ka_bl set rate=:rate,blrate=:rate2 where class2=\'正B\' and class3=\'总小\'');
			$stmt->execute($params);
		}
	}
	print('<script language=\'javascript\'>alert(\'设置成功！\');window.location.href=\'index.php?action=right\';</script>');
	exit();
}
$result = $mydata2_db->query('Select ID,drop_sort,drop_value,drop_unit,low_drop from ka_drop order by ID');
$drop_table = array();
$y = 0;
while ($image = $result->fetch()){
	$y++;
	array_push($drop_table, $image);
}
$drop_count = $y - 1;
?>


  <link rel="stylesheet" href="images/xp.css" type="text/css"> 
  <script language="javascript" type="text/javascript" src="js_admin.js"></script> 
  <style type="text/css"> 
  <!-- 
  .STYLE2 {color: #FF0000} 
  --> 
  </style> 

  <noscript> 
  <iframe scr=″*.htm″></iframe> 
  </noscript> 
  <SCRIPT language=JAVASCRIPT> 
  if(self == top) {location = '/';} 
  if(window.location.host!=top.location.host){top.location=window.location;} 
  </SCRIPT> 
  <table width="100%" border="0" cellspacing="0" cellpadding="5"> 
    <tr class="tbtitle"> 
      <td width="51%"><?php require_once '2top.php';?></td> 
    </tr> 
    <tr > 
      <td height="5"></td> 
    </tr> 
  </table>
<?php 
if (strpos($_SESSION['flag'], '10')){
}else{
	echo "<center>你没有该权限功能!</center>";
	exit();
}
?>
   <table   border="1" align="center" cellspacing="1" cellpadding="3" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%"> 
     <form name=form1 action=index.php?action=right&save=save method=post> 
	 <tr > 
        <td width="26%" height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><span class="STYLE2">项目</span></td> 
        <td width="74%" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" ><span class="STYLE2">内容</span></td> 
      </tr> 

      <tr> 
        <td height="28" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">过关设置</td> 
        <td bordercolor="cccccc">最高派彩 
          <input name="ggpz" id="s3" value="<?=ka_config(8)?>" size="6" /> 
          。</td> 
      </tr> 
      <tr>
      <td height="28" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">农历生肖设置</td>
      <td bordercolor="cccccc">请选择与当前年份相应的生肖
        <select id="sanimal" name="sanimal">
            <option value="8" <? if (ka_config(9)==8) {?>selected<? }?>>鼠</option>
            <option value="7" <? if (ka_config(9)==7) {?>selected<? }?>>牛</option>
            <option value="6" <? if (ka_config(9)==6) {?>selected<? }?>>虎</option>
            <option value="5" <? if (ka_config(9)==5) {?>selected<? }?>>兔</option>
            <option value="4" <? if (ka_config(9)==4) {?>selected<? }?>>龙</option>
            <option value="3" <? if (ka_config(9)==3) {?>selected<? }?>>蛇</option>
            <option value="2" <? if (ka_config(9)==2) {?>selected<? }?>>马</option>
            <option value="1" <? if (ka_config(9)==1) {?>selected<? }?>>羊</option>
            <option value="0" <? if (ka_config(9)==0) {?>selected<? }?>>猴</option>
            <option value="11" <? if (ka_config(9)==11) {?>selected<? }?>>鸡</option>
            <option value="10" <? if (ka_config(9)==10) {?>selected<? }?>>狗</option>
            <option value="9" <? if (ka_config(9)==9) {?>selected<? }?>>猪</option>
        </select> * 开启自动开盘此处将自动设置</td>
    </tr>
    <tr>
      <td height="28" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">B盘默认设置</td>
      <td bordercolor="cccccc">特码B 升
        <input name="tmzz" id="s8" value="<?=ka_config(3)?>" size="3" />
        &nbsp;&nbsp;&nbsp;&nbsp;特码两面B盘 升
        <input name="tmdx" id="Input2" value="<?=ka_config(4)?>" size="4" />
        &nbsp;&nbsp;&nbsp;
        特码波色B盘 升
        <input name="tmps" id="tmdx" value="<?=ka_config(5)?>" size="4" />
        。<br />
        正码B 升
        <input name="zmzz" id="zmzz" value="<?=ka_config(6)?>" size="3" />
        &nbsp;&nbsp;&nbsp;&nbsp;正码两面B盘 升
        <input name="zmdx" id="zmdx" value="<?=ka_config(7)?>" size="4" />
        &nbsp;&nbsp;&nbsp;* 设置为0将不自动调整</td>
    </tr>
    
    <tr style="display:none">
      <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">五行</td>
      <td bordercolor="cccccc">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="4%" height="25" align="center">金</td>
          <td width="96%"><input name="wxm1" type="text" id="wxm1" value="<?=Get_wx1_Color(25)?>" size="50" /></td>
        </tr>
        <tr>
          <td height="25" align="center">木</td>
          <td><input name="wxm2" type="text" id="wxm2" value="<?=Get_wx1_Color(26)?>" size="50" /></td>
        </tr>
        <tr>
          <td height="25" align="center">水</td>
          <td><input name="wxm3" type="text" id="wxm3" value="<?=Get_wx1_Color(27)?>" size="50" /></td>
        </tr>
        <tr>
          <td height="25" align="center">火</td>
          <td><input name="wxm4" type="text" id="wxm4" value="<?=Get_wx1_Color(28)?>" size="50" /></td>
        </tr>
        <tr>
          <td height="25" align="center">土</td>
          <td><input name="wxm5" type="text" id="wxm5" value="<?=Get_wx1_Color(29)?>" size="50" /></td>
        </tr>
		</table>
	   </td>
      </tr>
      <tr> 
        <td height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">&nbsp;</td> 
        <td bordercolor="cccccc">
			<button type="button" onclick="javascript:location.href='index.php?action=right'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22";><img src="images/icon_21x21_info.gif" align="absmiddle" />重填</button> 
            <button type="button" onclick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:100;height:22" ><img src="images/icon_21x21_copy.gif" align="absmiddle" />确认修改</button> 
          <button type="button" onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button></td> 
      </tr></form > 
    </table> 
  <table width="98%" height="30"  border="0" cellpadding="0" cellspacing="0"> 
    <tr> 
      <td>&nbsp;</td> 
    </tr> 
  </table>
<?php 
function Get_wx1_Color($rrr){
	global $mydata2_db;
	$params = array(':id' => $rrr);
	$result = $mydata2_db->prepare('Select id,m_number,sx From ka_sxnumber where  id=:id  Order By ID LIMIT 1');
	$result->execute($params);
	$ka_Color1 = $result->fetch();
	return $ka_Color1['m_number'];
}
?>