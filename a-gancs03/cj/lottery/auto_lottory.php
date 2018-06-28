<?php header('Content-Type:text/html;charset=utf-8');
include_once '../../../include/Lunar.php';
include_once '../../../database/mysql.config.php';
include_once '../../../cache/website.php';
include_once '../../../include/pub_library.php';
include_once '../../../common/commonfun.php';
require 'curl_http.php';
require 'include/getapi.php';
date_default_timezone_set('PRC');
$nowtime = time();
$jn0501 = strtotime(date('Y') . '-05-01 00:00:00');
$jn1101 = strtotime(date('Y') . '-11-01 00:00:00');
$lunar = new Lunar();
$arrZYCY = $lunar->convertLunarToSolar(date('Y'), '01', '01');
$strZYCY = $arrZYCY[0] . '-' . $arrZYCY[1] . '-' . $arrZYCY[2] . ' 00:00:00';
$timeZYCY = strtotime($strZYCY);
$timeZYCE = strtotime($strZYCY) + (1 * 24 * 3600);
$timeCJQST = strtotime($strZYCY) - (7 * 24 * 3600);
$timeCJHST = strtotime($strZYCY) + (8 * 24 * 3600);
$numtostr = array('猴', '羊', '马', '蛇', '龙', '兔', '虎', '牛', '鼠', '猪', '狗', '鸡');
$strtonum = array('猴' => 0, '羊' => 1, '马' => 2, '蛇' => 3, '龙' => 4, '兔' => 5, '虎' => 6, '牛' => 7, '鼠' => 8, '猪' => 9, '狗' => 10, '鸡' => 11);
if (($timeZYCY <= $nowtime) && ($nowtime <= $timeZYCE))
{
	$Zodiac = $lunar->getYearZodiac(date('Y'));
	$params = array(':sanimal' => $strtonum[$Zodiac]);
	$sql = 'update config set sanimal = :sanimal';
	$stmt = $mydata2_db->prepare($sql);
	$stmt->execute($params);
}
$sql = 'select sanimal from config;';
$stmt = $mydata2_db->prepare($sql);
$stmt->execute();
$nowZodiac = $stmt->fetchColumn();
$strZodiac = $numtostr[$nowZodiac];
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
switch ($nowZodiac)
{
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
if (($timeCJQST <= $nowtime) && ($nowtime <= $timeCJHST))
{
	global $arrcur;
	$needSave = false;
	$curl = new Curl_HTTP_Client();
	$url = 'http://' . $arrcur[1] . '/lottory_auto.php?_t=' . time();
	$fileString = $curl->fetch_url($url);
	$arrData = json_decode($fileString);
	$mapData = array();
	foreach ($arrData as $val)
	{
		$mapData[$val->ltype] = $val;
	}
	unset($val);
	if ((strtotime($mapData['cjks']->ldatetime) <= $nowtime) && ($nowtime <= strtotime($mapData['cjjs']->ldatetime)))
	{
		if (($web_site['pk10'] == 0) || ($web_site['kl8'] == 0))
		{
			$needSave = true;
		}
		$web_site['pk10'] = 1;
		$web_site['kl8'] = 1;
		if (($web_site['pk10_ktime'] != $mapData['pk10']->ldatetime) || ($web_site['pk10_knum'] != $mapData['pk10']->qishu) || ($web_site['kl8_ktime'] != $mapData['kl8']->ldatetime) || ($web_site['kl8_knum'] != $mapData['kl8']->qishu))
		{
			$web_site['pk10_ktime'] = $mapData['pk10']->ldatetime;
			$web_site['pk10_knum'] = $mapData['pk10']->qishu;
			$web_site['kl8_ktime'] = $mapData['kl8']->ldatetime;
			$web_site['kl8_knum'] = $mapData['kl8']->qishu;
			$needSave = true;
		}
		$params = array(':fengpan' => $mapData['fc3d']->ldatetime, ':qihao' => $mapData['fc3d']->qishu);
		$sql = 'update lottery_k_3d set fengpan = :fengpan where qihao = :qihao';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$params = array(':fengpan' => $mapData['pl3']->ldatetime, ':qihao' => $mapData['pl3']->qishu);
		$sql = 'update lottery_k_pl3 set fengpan = :fengpan where qihao = :qihao';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
	}
	else
	{
		if (($web_site['pk10'] == 1) || ($web_site['kl8'] == 1))
		{
			$needSave = true;
		}
		$web_site['pk10'] = 0;
		$web_site['kl8'] = 0;
	}
	if ($needSave == true)
	{
		write_website($web_site);
	}
}?> <html> 
  <head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title></title> 
  <style type="text/css"> 
  <!-- 
  body,td,th { 
      font-size: 12px;
  } 
  body { 
      margin-left: 0px;
      margin-top: 0px;
      margin-right: 0px;
      margin-bottom: 0px;
  } 
  --> 
  </style></head> 
  <body> 
  <script> 
  window.parent.is_open = 1;
  </script> 
  <script>  
  <!--  
  var limit="60"  
  if (document.images){  
	  var parselimit=limit 
  }  
  function beginrefresh(){  
  if (!document.images)  
	  return  
  if (parselimit==1)  
	  window.location.reload()  
  else{  
	  parselimit-=1   	
	  curmin=Math.floor(parselimit)  
	  if (curmin!=0)  
		  curtime=curmin+"秒后自动获取!"  
	  else  
		  curtime=cursec+"秒后自动获取!"  
		  timeinfo.innerText=curtime  
		  setTimeout("beginrefresh()",1000) 
	  }  
  }  
  window.onload=beginrefresh 
  </script> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0"> 
    <tr>  
      <td align="left"> 
		  <input type=button name=button value="刷新" onClick="window.location.reload()"> 
		  当前生肖:<?=$numtostr[$nowZodiac];?><br/> 
		  PK10:<?=$mapData['pk10'];?><br/> 
		  快乐8:<?=$mapData['kl8'];?><br/> 
		  3D:<?=$mapData['fc3d'];?><br/> 
		  排列3:<?=$mapData['pl3'];?><br/> 
        <span id="timeinfo"></span> 
        </td> 
    </tr> 
  </table> 
  </body> 
  </html><?php function write_website($arr)
{
	include_once '../../../class/admin.php';
	admin::insert_log('', '自动更新盘口:修改了系统参数配置');
	$str = '<?php ' . "\r\n";
	$str .= 'unset($web_site);' . "\r\n";
	$str .= '$web_site' . "\t\t\t" . '=' . "\t" . 'array();' . "\r\n";
	$str .= '$web_site[\'close\']' . "\t" . '=' . "\t" . intval($arr['close']) . ';' . "\r\n";
	$str .= '$web_site[\'web_name\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($arr['web_name']) . '\';' . "\r\n";
	$str .= '$web_site[\'why\']' . "\t" . '=' . "\t" . '\'' . encoding_html($arr['why']) . '\';' . "\r\n";
	$str .= '$web_site[\'reg_msg_from\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($arr['reg_msg_from']) . '\';' . "\r\n";
	$str .= '$web_site[\'reg_msg_title\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($arr['reg_msg_title']) . '\';' . "\r\n";
	$str .= '$web_site[\'reg_msg_msg\']' . "\t" . '=' . "\t" . '\'' . encoding_html($arr['reg_msg_msg']) . '\';' . "\r\n";
	$str .= '$web_site[\'ck_limit\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($arr['ck_limit']) . '\';' . "\r\n";
	$str .= '$web_site[\'qk_limit\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($arr['qk_limit']) . '\';' . "\r\n";
	$str .= '$web_site[\'qk_time_begin\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($arr['qk_time_begin']) . '\';' . "\r\n";
	$str .= '$web_site[\'qk_time_end\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($arr['qk_time_end']) . '\';' . "\r\n";
	$str .= '$web_site[\'ssc\']' . "\t" . '=' . "\t" . intval($arr['ssc']) . ';' . "\r\n";
	$str .= '$web_site[\'klsf\']' . "\t" . '=' . "\t" . intval($arr['klsf']) . ';' . "\r\n";
	$str .= '$web_site[\'pk10\']' . "\t" . '=' . "\t" . intval($arr['pk10']) . ';' . "\r\n";
	$str .= '$web_site[\'kl8\']' . "\t" . '=' . "\t" . intval($arr['kl8']) . ';' . "\r\n";
	$str .= '$web_site[\'ssl\']' . "\t" . '=' . "\t" . intval($arr['ssl']) . ';' . "\r\n";
	$str .= '$web_site[\'d3\']' . "\t" . '=' . "\t" . intval($arr['d3']) . ';' . "\r\n";
	$str .= '$web_site[\'pl3\']' . "\t" . '=' . "\t" . intval($arr['pl3']) . ';' . "\r\n";
	$str .= '$web_site[\'web_title\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($arr['web_title']) . '\';' . "\r\n";
	$str .= '$web_site[\'zh_low\']' . "\t" . '=' . "\t" . '\'' . intval($arr['zh_low']) . '\';' . "\r\n";
	$str .= '$web_site[\'zh_high\']' . "\t" . '=' . "\t" . '\'' . intval($arr['zh_high']) . '\';' . "\r\n";
	$str .= '$web_site[\'pk10_ktime\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($arr['pk10_ktime']) . '\';' . "\r\n";
	$str .= '$web_site[\'pk10_knum\']' . "\t" . '=' . "\t" . '\'' . intval($arr['pk10_knum']) . '\';' . "\r\n";
	$str .= '$web_site[\'kl8_ktime\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($arr['kl8_ktime']) . '\';' . "\r\n";
	$str .= '$web_site[\'kl8_knum\']' . "\t" . '=' . "\t" . '\'' . intval($arr['kl8_knum']) . '\';' . "\r\n";
	$str .= '$web_site[\'zrwh_zhou1\']' . "\t" . '=' . "\t" . '\'' . intval($arr['zrwh_zhou1']) . '\';' . "\r\n";
	$str .= '$web_site[\'zrwh_zhou2\']' . "\t" . '=' . "\t" . '\'' . intval($arr['zrwh_zhou2']) . '\';' . "\r\n";
	$str .= '$web_site[\'zrwh_zhou3\']' . "\t" . '=' . "\t" . '\'' . intval($arr['zrwh_zhou3']) . '\';' . "\r\n";
	$str .= '$web_site[\'zrwh_zhou4\']' . "\t" . '=' . "\t" . '\'' . intval($arr['zrwh_zhou4']) . '\';' . "\r\n";
	$str .= '$web_site[\'zrwh_zhou5\']' . "\t" . '=' . "\t" . '\'' . intval($arr['zrwh_zhou5']) . '\';' . "\r\n";
	$str .= '$web_site[\'zrwh_zhou6\']' . "\t" . '=' . "\t" . '\'' . intval($arr['zrwh_zhou6']) . '\';' . "\r\n";
	$str .= '$web_site[\'zrwh_zhou7\']' . "\t" . '=' . "\t" . '\'' . intval($arr['zrwh_zhou7']) . '\';' . "\r\n";
	$str .= '$web_site[\'zrwh_begin\']' . "\t" . '=' . "\t" . '\'' . clear_html_code($arr['zrwh_begin']) . '\';' . "\r\n";
	$str .= '$web_site[\'zrwh_end\']' . "\t\t" . '=' . "\t" . '\'' . clear_html_code($arr['zrwh_end']) . '\';' . "\r\n";
	$str .= '$web_site[\'wxalipay\']' . "\t\t" . '=' . "\t" . intval($arr['wxalipay']) . ';' . "\r\n";
	$str .= '$web_site[\'show_tel\']' . "\t\t" . '=' . "\t" . intval($arr['show_tel']) . ';' . "\r\n";
	$str .= '$web_site[\'show_qq\']' . "\t\t" . '=' . "\t" . intval($arr['show_qq']) . ';' . "\r\n";
	$str .= '$web_site[\'show_question\']' . "\t" . '=' . "\t" . intval($arr['show_question']) . ';' . "\r\n";
	$str .= '$web_site[\'allow_samename\']' . "\t" . '=' . "\t" . intval($arr['allow_samename']) . ';' . "\r\n";
	$str .= '$web_site[\'default_hkzs\']' . "\t" . '=' . "\t" . floatval($arr['default_hkzs']) . ';' . "\r\n";
	if (@!chmod('../../../cache', 511))
	{
		message('缓存文件写入失败！请先设 /cache 文件权限为：0777');
	}
	if (!write_file('../../../cache/website.php', $str . '?>'))
	{
		message('缓存文件写入失败！请先设/website.php文件权限为：0777');
	}
}?>