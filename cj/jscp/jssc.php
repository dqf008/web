<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");
include_once ("../include/jssc.func.php");

$config_file = '../../cache/jssc.conf.php';
$config = [
	'mode' => 'r',
	'level' => 100,
	'ratio' => ['5000', '10000', '0'],
	'check' => false,
];
file_exists($config_file)&&$config = include($config_file);

/* 两面长龙数据 开始 */
$lot_changlong = array(
	'两面长龙' => array(),
	'date' => 0,
	'lastest' => 0,
);
$cache_file = '../../cache/lot_jssc.php';
file_exists($cache_file)&&$lot_changlong = include($cache_file);
/* 两面长龙数据 结束 */
$qishu = time()+43200-75;
$qishu = $qishu-fmod($qishu-14400, 75);
$params = array(':type' => 'JSSC', ':qishu' => $qishu);
$stmt = $mydata1_db->prepare('SELECT `id`, `status` FROM `c_auto_data` WHERE `type`=:type AND `qishu`=:qishu');
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
				$data_file = '../../cache/jssc.data.php';
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
	$params[':opentime'] = $qishu+75;
	$params[':value'] = array(
		'qishu' => date('Ymd', $qishu).substr('0000'.(floor(fmod($qishu-14400, 86400)/75)+1), -4),
		'opencode' => $tempNum,
		'info' => array(),
	);
	$params[':value']['info'][] = $tempNum[0]+$tempNum[1];
	$params[':value']['info'][] = $params[':value']['info'][0]==11?'和':(fmod($params[':value']['info'][0], 2)==0?'双':'单');
	$params[':value']['info'][] = $params[':value']['info'][0]==11?'和':($params[':value']['info'][0]>11?'大':'小');
	for($i=0;$i<5;$i++){
		$params[':value']['info'][] = $tempNum[$i]>$tempNum[9-$i]?'龙':'虎';
	}
	$params[':value'] = serialize($params[':value']);
	$stmt = $mydata1_db->prepare('INSERT INTO `c_auto_data` (`type`, `qishu`, `opentime`, `value`, `status`) VALUES (:type, :qishu, :opentime, :value, 0)');
	/* 两面长龙数据 开始 */
	if($stmt->execute($params)&&$lot_changlong['lastest']<$qishu){
		// $lot_changlong = array(
		//  '两面长龙' => array(),
		//  '冠亚' => array(),
		//  'lastest' => 0,
		// );
		$lot_t = array();
		$lot_t['和'] = $tempNum[0]+$tempNum[1];
		$lot_t['大小'] = $lot_t['和']==11?'和':($lot_t['和']>11?'大':'小');
		$lot_t['单双'] = $lot_t['和']==11?'和':(fmod($lot_t['和'], 2)==0?'双':'单');
		foreach(array('和', '大小', '单双') as $i){
			zoushi('冠亚', $i, $lot_t[$i], $lot_changlong['date']!=date('Ymd', $qishu));
		}
		foreach(array('大' => '大小', '小' => '大小', '单' => '单双', '双' => '单双', '和' => '单双') as $i=>$j){
			changlong('冠亚和', $i, $lot_t[$j]);
		}
		$key = array('冠军', '亚军', '第三名', '第四名', '第五名', '第六名', '第七名', '第八名', '第九名', '第十名');
		foreach($tempNum as $k=>$n){
			$lot_t['大小'] = $n>5?'大':'小';
			$lot_t['单双'] = fmod($n, 2)==0?'双':'单';
			foreach(array('大' => '大小', '小' => '大小', '单' => '单双', '双' => '单双') as $i=>$j){
				changlong($key[$k], $i, $lot_t[$j]);
			}
		}
		foreach(array('冠军vs第十', '亚军vs第九', '第三vs第八', '第四vs第七', '第五vs第六') as $k=>$n){
			$lot_t['龙虎'] = $tempNum[$k]>$tempNum[9-$k]?'龙':'虎';
			changlong($n, '龙', $lot_t['龙虎']);
			changlong($n, '虎', $lot_t['龙虎']);
		}
		arsort($lot_changlong['两面长龙']);
		$lot_changlong['date'] = date('Ymd', $qishu);
		$lot_changlong['lastest'] = $qishu;
		/* 缓存输出结果 */
		$lot_changlong['output'] = array();
		$lot_changlong['output']['ChangLong'] = array();
		$lot_changlong['output']['LuZhu'] = array();
		foreach($lot_changlong['冠亚'] as $key=>$val){
			$lot_changlong['output']['LuZhu'][] = array(
				'c' => implode(',', $val),
				'n' => '冠亚和'.str_replace('和', '', $key),
				'p' => 0,
			);
		}
		foreach($lot_changlong['两面长龙'] as $key=>$val){
			$val>1&&$lot_changlong['output']['ChangLong'][] = array($key, $val);
		}
		file_put_contents($cache_file, '<?php'.PHP_EOL.'return unserialize(\''.serialize($lot_changlong).'\');');
	}
	/* 两面长龙数据 结束 */
}
// else {
// 	// 2018-05-11 预设开奖
// 	$rows = $stmt->fetch();
// 	if ($rows['status'] == 3) {
// 		$mydata1_db->query('UPDATE `c_auto_data` SET `status`=0 WHERE `id`='.$rows['id']);
// 	}
// }

function changlong($k, $i, $j){
	$lot_changlong =&$GLOBALS['lot_changlong']['两面长龙'];
	if($i==$j){
		if(isset($lot_changlong[$k.'-'.$i])){
			$lot_changlong[$k.'-'.$i]++;
		}else{
			$lot_changlong[$k.'-'.$i] = 1;
		}
	}else{
		if(isset($lot_changlong[$k.'-'.$i])){
			unset($lot_changlong[$k.'-'.$i]);
		}
	}
}
function zoushi($k, $i, $n, $line=false, $max=30){
	$lot_changlong =&$GLOBALS['lot_changlong'];
	!isset($lot_changlong[$k])&&$lot_changlong[$k] = array();
	if(!isset($lot_changlong[$k][$i])||empty($lot_changlong[$k][$i])){
		$lot_changlong[$k][$i] = array($n.':1');
	}else{
		$line&&array_unshift($lot_changlong[$k][$i], '*:1');
		$lot_temp = explode(':', $lot_changlong[$k][$i][0]);
		if($lot_temp[0]==$n){
			$lot_temp[1]++;
			$lot_changlong[$k][$i][0] = $lot_temp[0].':'.$lot_temp[1];
		}else{
			array_unshift($lot_changlong[$k][$i], $n.':1');
			count($lot_changlong[$k][$i])>$max&&array_splice($lot_changlong[$k][$i], $max);
		}
	}
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>极速赛车</title>
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
	   <?php echo date('Ymd', $qishu).substr('0000'.(floor(fmod($qishu-14400, 86400)/75)+1), -4); ?> 已开奖
	  </td>
  </tr>
</table>
</body>
</html>
