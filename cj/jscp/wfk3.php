<?php
ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");
include_once ("../include/wfk3.func.php");

$config_file = '../../cache/wfk3.conf.php';
$config = [
	'mode' => 'r',
	'level' => 100,
	'ratio' => ['5000', '10000', '0'],
	'check' => false,
];
file_exists($config_file)&&$config = include($config_file);

/* 两面长龙数据 结束 */
$qishu = time()+43200-300;
$qishu = $qishu-fmod($qishu-14400, 300);
$params = array(':type' => 'WFK3', ':qishu' => $qishu);
$stmt = $mydata1_db->prepare('SELECT `id` FROM `c_auto_data` WHERE `type`=:type AND `qishu`=:qishu');
$stmt->execute($params);
if($stmt->rowCount()<=0){
	$check = isset($config['check'])&&$config['check'];
	$tempRanking = getRanking(0, $check);
	if($config['mode']=='s'||(isset($config['ratio'][2])&&$config['ratio'][2]!=0)){
		$keys = $tempArray = [[], []];
		for($i=0;$i<$config['level'];$i++){
			// 随机计算结果
			$tempArray[0][$i] = getNumber($tempRanking, $check);
		}
		$tempArray[1] = checkBet($qishu, $tempArray[0]);
		if(empty($tempArray[1])){
			$i = array_rand($tempArray[0]);
		}else{
			if($config['mode']=='s'){
				$config['ratio'] = rand($config['ratio'][0], $config['ratio'][1]);
				foreach($tempArray[1] as $key=>$val){
					if($val[2]>=$config['ratio']){
						$keys[0][$key] = $val[2]; // 大于设定值
					}else{
						$keys[1][$key] = $val[2]; // 取最大值
					}
				}
			}else{
				$config['ratio'] = $config['ratio'][2];
				$data = [0, 0, 0];
				$data_file = '../../cache/wfk3.data.php';
				file_exists($data_file)&&$data = include($data_file);
				foreach($tempArray[1] as $key=>$val){
					if(round(-10000*($data[1]+$val[1])/($data[0]+$val[0]))>=$config['ratio']){
						$keys[0][$key] = $val[2]; // 取最小值
					}else{
						$keys[1][$key] = $val[2]; // 取最大值
					}
				}
			}
			if(!empty($keys[0])){
				asort($keys[0]); // 从小到大排序
				$keys[0] = array_keys($keys[0]);
				$i = array_shift($keys[0]); // 取出第一个键名
			}else{
				arsort($keys[1]); // 从大到小排序
				$keys[1] = array_keys($keys[1]);
				$i = array_shift($keys[1]); // 取出第一个键名
			}
		}
		$tempNum = $tempArray[0][$i];
	}else{
		$tempNum = getNumber($tempRanking, $check);
	}
    asort($tempNum);
	$params[':opentime'] = $qishu+300;
	$params[':value'] = array(
		'qishu' => date('Ymd', $qishu).substr('000'.(floor(fmod($qishu-14400, 86400)/300)+1), -3),
		'opencode' => $tempNum,
		'info' => array(),
	);
	$params[':value']['info'][] = array_sum($tempNum);
	$params[':value']['info'][] = fmod($params[':value']['info'][0], 2)==0?'双':'单';
	$params[':value']['info'][] = $params[':value']['info'][0]>10?'大':'小';
	$params[':value'] = serialize($params[':value']);
	$stmt = $mydata1_db->prepare('INSERT INTO `c_auto_data` (`type`, `qishu`, `opentime`, `value`, `status`) VALUES (:type, :qishu, :opentime, :value, 0)');
    $stmt->execute($params);
}
// else {
// 	// 2018-05-11 预设开奖
// 	$rows = $stmt->fetch();
// 	if ($rows['status'] == 3) {
// 		$mydata1_db->query('UPDATE `c_auto_data` SET `status`=0 WHERE `id`='.$rows['id']);
// 	}
// }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>好运快3</title>
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
<!-- 

var limit="<?php echo rand(3, 5); ?>"
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
	<td align="left" style="padding-left:10px; padding-top:10px; line-height:22px;">
	  <input type=button name=button value="刷新" onClick="window.location.reload()">
	   <span id="timeinfo"></span><br />
	   <?php echo date('Ymd', $qishu).substr('0000'.(floor(fmod($qishu-14400, 86400)/300)+1), -3); ?> 已开奖
<!--	   --><?php //echo date('Ymd', $qishu).substr('0000'.(floor(fmod($qishu-14400, 86400)/75)+1), -4); ?><!-- 已开奖-->
	  </td>
  </tr>
</table>
</body>
</html>
