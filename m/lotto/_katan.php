<?php 
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/login_check.php';
include_once '../../common/logintu.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '_pankouinfo.php';
if ((strtotime($Current_KitheTable['zfbdate']) - strtotime(date('Y-m-d H:i:s')) <= 0) || ($Current_KitheTable['zfb'] == 0) || ($nodata == 1)){
	echo '<script type="text/javascript">alert("已封盘");window.location.href="/m/lotto/index.php";</script>';
	exit();
}

include_once 'common.php';
checkSum();

$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$class1 = $_POST['class1'];
$class2 = $_POST['class2'];
//echo  $class1.'--'.$class2;exit;
$betlist = $_POST['betlist'];
$allclass1 = array('特码', '正码', '正特', '正1-6', '生肖', '正特尾数', '半波');
if (!in_array($class1, $allclass1)){
	echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}else if ($class1 == '生肖'){
	if (($class2 != '一肖') && ($class2 != '特肖')){
		echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
		exit();
	}
}
$params = array(':class1' => $class1, ':class2' => $class2);
$stmt = $mydata1_db->prepare('select class3,rate from mydata2_db.ka_bl where  class1=:class1 and class2=:class2 order by id');
$stmt->execute($params);
$plArray = array();
$betnumber = 0;
while ($row = $stmt->fetch())
{
	$betnumber++;
	$plArray[$betnumber]['rate'] = $row['rate'];
	$plArray[$betnumber]['class3'] = $row['class3'];
}
if ($betnumber == 0){
	echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}
$dsclassArray = '';
switch ($class2)
{
	case '特A': $dsclassArray = '16630,16632,16633,16634,16640,16654,16663,16664,16665';
	break;
	case '特B': $dsclassArray = '16631,16632,16633,16634,16640,16654,16663,16664,16665';
	break;
	case '正A': $dsclassArray = '16636,16638,16639';
	break;
	case '正B': $dsclassArray = '16637,16638,16639';
	break;
	case '正1特': case '正2特': case '正3特': case '正4特': case '正5特': case '正6特': $dsclassArray = '16632,16633,16634,16635,16640';
	break;
	case '正码1': case '正码2': case '正码3': case '正码4': case '正码5': case '正码6': $dsclassArray = '16677';
	break;
	case '半波': $dsclassArray = '16641';
	break;
	case '正特尾数': $dsclassArray = '16660';
	break;
	case '一肖': $dsclassArray = '16652';
	break;
	case '特肖': $dsclassArray = '16648';
	break;
	default:
		echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
		exit();
}
$user_ds_array = array();
$sql = 'Select ds,yg from mydata2_db.ka_quota where username=\'gd\' and id in (' . $dsclassArray . ')';
$query = $mydata1_db->query($sql);
while ($rows = $query->fetch()){
	$user_ds_array[trim($rows['ds'])] = $rows['yg'];
}
$orderList = array();
$allmoney = 0;
$betlistArray = explode(',', $betlist);
$betlistArrayLength = count($betlistArray);
if ($betlistArrayLength <= 0){
	echo '<script type="text/javascript">alert("请下注！");window.location.href="/m/lotto/index.php";</script>';
	exit();
}


for ($i = 0;$i < ($betlistArrayLength - 1);$i++){
	$btn = (int) $betlistArray[$i];
	$money = $_POST['money_' . $btn];
	if (!preg_match('/^[1-9]\\d*$/', $money)){
		echo '<script type="text/javascript">alert("请输入合法的金额！");window.location.href="/m/lotto/index.php";</script>';
		exit();
	}
	
	if (0 < $money){
		if ($money < $cp_zd){
			echo '<script type="text/javascript">alert("最小下注金额为：'.$cp_zd.'");window.location.href="/m/lotto/index.php";</script>';
			exit();
		}
		if ($cp_zg < $money){
			echo '<script type="text/javascript">alert("最高下注金额为：'.$cp_zg.'");window.location.href="/m/lotto/index.php";</script>';
			exit();
		}
		$allmoney = $allmoney + $money;
		if ((1 <= $btn) && ($btn <= $betnumber)){
			$orderList[$i]['money'] = $money;
			$orderList[$i]['class3'] = $plArray[$btn]['class3'];
			$orderList[$i]['rate'] = $plArray[$btn]['rate'];
			$user_class = '';
			switch ($class1){
				case '特码': switch ($orderList[$i]['class3']){
					case '单': $user_class = '单双';
					break;
					case '双': $user_class = '单双';
					break;
					case '大': $user_class = '大小';
					break;
					case '小': $user_class = '大小';
					break;
					case '合单': $user_class = '合数单双';
					break;
					case '合双': $user_class = '合数单双';
					break;
					case '红波': $user_class = '色波';
					break;
					case '绿波': $user_class = '色波';
					break;
					case '蓝波': $user_class = '色波';
					break;
					case '家禽': $user_class = '家禽野兽';
					break;
					case '野兽': $user_class = '家禽野兽';
					break;
					case '尾大': $user_class = '尾大尾小';
					break;
					case '尾小': $user_class = '尾大尾小';
					break;
					case '大单': $user_class = '大单小单';
					break;
					case '小单': $user_class = '大单小单';
					break;
					case '大双': $user_class = '大双小双';
					break;
					case '小双': $user_class = '大双小双';
					break;
					default: if ($class2 == '特A'){
						$user_class = '特A';
					}else{
						$user_class = '特B';
					}
					break;
				}
				break;
				case '正码': switch ($orderList[$i]['class3']){
					case '总单': $user_class = '总和单双';
					break;
					case '总双': $user_class = '总和单双';
					break;
					case '总大': $user_class = '总和大小';
					break;
					case '总小': $user_class = '总和大小';
					break;
					default: if ($class2 == '正A'){
						$user_class = '正A';
					}else{
						$user_class = '正B';
					}
					break;
				}
				break;
				case '正特': switch ($orderList[$i]['class3']){
					case '单': $user_class = '单双';
					break;
					case '双': $user_class = '单双';
					break;
					case '大': $user_class = '大小';
					break;
					case '小': $user_class = '大小';
					break;
					case '合单': $user_class = '合数单双';
					break;
					case '合双': $user_class = '合数单双';
					break;
					case '红波': $user_class = '色波';
					break;
					case '绿波': $user_class = '色波';
					break;
					case '蓝波': $user_class = '色波';
					break;
					default: $user_class = '正特';
					break;
				}
				break;
				case '正1-6': $user_class = '正1-6';
				break;
				case '半波': $user_class = '半波';
				break;
				case '正特尾数': $user_class = '正特尾数';
				break;
				case '生肖': switch ($class2){
					case '一肖': $user_class = '一肖';
					break;
					case '特肖': $user_class = '特肖';
					break;
					default: $user_class = '一肖';
					break;
				}
				break;
				default:
					echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
					exit();
			}
			$orderList[$i]['user_ds'] = $user_ds_array[$user_class];
		}else{
			echo '<script type="text/javascript">alert("非法下注！");window.location.href="/m/lotto/index.php";</script>';
			exit();
		}
	}else{
		echo '<script type="text/javascript">alert("请输入合法的金额！");window.location.href="/m/lotto/index.php";</script>';
		exit();
	}
}
$memid = 0;
$params = array(':kauser' => $_SESSION['username']);
$stmt = $mydata2_db->prepare('select id from ka_mem where kauser=:kauser order by id desc');
$stmt->execute($params);
$row = $stmt->fetch();
if ($_SESSION['username'])
{
	$memid = $row['id'];
}
$userinfo = user::getinfo($uid);
if ($userinfo['money'] < $allmoney){
	echo '<script type="text/javascript">alert("对不起，下注总额不能大于可用信用额");window.location.href="/m/lotto/index.php";</script>';
	exit();
}else{
	$params = array(':money' => $allmoney, ':username' => $_SESSION['username']);
	$sql = 'update k_user set money=money-:money where username=:username limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$previousAmount = $userinfo['money'];
	$len = count($orderList);
	
	for ($i = 0;$i < $len;$i++)
	{
		$currentAmount = $previousAmount - $orderList[$i]['money'];
		$num = randStr();
		$adddate = date('Y-m-d H:i:s', time() + (12 * 3600));
		$params = array(':num' => $num, ':username' => $_SESSION['username'], ':kithe' => $Current_Kithe_Num, ':adddate' => $adddate, ':class1' => $class1, ':class2' => $class2, ':class3' => $orderList[$i]['class3'], ':rate' => $orderList[$i]['rate'], ':sum_m' => $orderList[$i]['money'], ':user_ds' => $orderList[$i]['user_ds'], ':dai_ds' => 0, ':zong_ds' => 0, ':guan_ds' => 0, ':dai_zc' => 0, ':zong_zc' => 0, ':guan_zc' => 0, ':dagu_zc' => 0, ':bm' => 0, ':dai' => 'daili', ':zong' => 'zong', ':guan' => 'guan', ':memid' => $memid, ':danid' => 3, ':zongid' => 2, ':guanid' => 1, ':abcd' => 'A', ':lx' => 0);
		$stmt = $mydata2_db->prepare('INSERT INTO ka_tan set num=:num,username=:username,kithe=:kithe,adddate=:adddate,class1=:class1,class2=:class2,class3=:class3,rate=:rate,sum_m=:sum_m,user_ds=:user_ds,dai_ds=:dai_ds,zong_ds=:zong_ds,guan_ds=:guan_ds,dai_zc=:dai_zc,zong_zc=:zong_zc,guan_zc=:guan_zc,dagu_zc=:dagu_zc,bm=:bm,dai=:dai,zong=:zong,guan=:guan,memid=:memid,danid=:danid,zongid=:zongid,guanid=:guanid,abcd=:abcd,lx=:lx');
		$stmt->execute($params);
		$params = array(':uid' => $userinfo['uid'], ':userName' => $userinfo['username'], ':transferOrder' => 'm_' . $num, ':transferAmount' => $orderList[$i]['money'], ':previousAmount' => $previousAmount, ':currentAmount' => $currentAmount, ':creationTime' => date('Y-m-d H:i:s', time()));
		$stmt = $mydata1_db->prepare('insert into k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) values(:uid,:userName,\'SIX\',\'BET\',:transferOrder,-:transferAmount,:previousAmount,:currentAmount,:creationTime)');
		$stmt->execute($params);
		$previousAmount = $currentAmount;
	}
	echo '<script type="text/javascript">alert("下注成功");window.location.href="/m/lotto/index.php";</script>';
	exit();
}?>