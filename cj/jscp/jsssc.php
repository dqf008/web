<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");
include_once ("../include/jsssc.func.php");

$config_file = '../../cache/jsssc.conf.php';
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
$cache_file = '../../cache/lot_jsssc.php';
file_exists($cache_file)&&$lot_changlong = include($cache_file);
/* 两面长龙数据 结束 */
$qishu = time()+43200-75;
$qishu = $qishu-fmod($qishu-14400, 75);
$params = array(':type' => 'JSSSC', ':qishu' => $qishu);
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
				$data_file = '../../cache/jsssc.data.php';
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
	// var_dump($tempNum);exit;
	$params[':opentime'] = $qishu+75;
	$params[':value'] = array(
		'qishu' => date('Ymd', $qishu).substr('0000'.(floor(fmod($qishu-14400, 86400)/75)+1), -4),
		'opencode' => $tempNum,
		'info' => array(),
	);
	$params[':value']['info'][] = array_sum($tempNum);
	$params[':value']['info'][] = fmod($params[':value']['info'][0], 2)==0?'双':'单';
	$params[':value']['info'][] = $params[':value']['info'][0]>22?'大':'小';
	$params[':value']['info'][] = $tempNum[0]==$tempNum[4]?'和':($tempNum[0]>$tempNum[4]?'龙':'虎');
	$params[':value']['info'][] = SSC([$tempNum[0], $tempNum[1], $tempNum[2]]);
	$params[':value']['info'][] = SSC([$tempNum[1], $tempNum[2], $tempNum[3]]);
	$params[':value']['info'][] = SSC([$tempNum[2], $tempNum[3], $tempNum[4]]);
	$params[':value'] = serialize($params[':value']);
	$stmt = $mydata1_db->prepare('INSERT INTO `c_auto_data` (`type`, `qishu`, `opentime`, `value`, `status`) VALUES (:type, :qishu, :opentime, :value, 0)');
	/* 两面长龙数据 开始 */
	if($stmt->execute($params)&&$lot_changlong['lastest']<$qishu){
		$lot_t = array('总和' => 0);
		$lot_t['line'] = $lot_changlong['date']!=date('Ymd', $qishu);
		/* 1~5球 */
		$key = array('第一球', '第二球', '第三球', '第四球', '第五球');
		foreach($tempNum as $k=>$n){
			$lot_t['总和']+= $n;
			$lot_t['大小'] = $n>=5?'大':'小';
			$lot_t['单双'] = fmod($n, 2)==0?'双':'单';
			$k = $key[$k];
			foreach(array('大' => '大小', '小' => '大小', '单' => '单双', '双' => '单双') as $i=>$j){
				changlong($k, $i, $lot_t[$j]);
			}
			!isset($lot_changlong[$k])&&$lot_changlong[$k] = array();
			(!isset($lot_changlong[$k]['号码'])||$lot_t['line'])&&$lot_changlong[$k]['号码'] = array();
			if(!isset($lot_changlong[$k]['号码'])){
				$lot_changlong[$k]['号码'][$n] = 1;
			}else{
				$lot_changlong[$k]['号码'][$n]++;
			}
			zoushi($k, '和', $n, $lot_t['line']);
			foreach(array('大小', '单双') as $i){
				zoushi($k, $i, $lot_t[$i], $lot_t['line']);
			}
		}
		/* 总和 */
		$lot_t['总和大小'] = $lot_t['总和']>22?'大':'小';
		$lot_t['总和单双'] = fmod($lot_t['总和'], 2)==0?'双':'单';
		foreach(array('大' => '大小', '小' => '大小', '单' => '单双', '双' => '单双') as $i=>$j){
			changlong('总和'.$j, $i, $lot_t['总和'.$j]);
		}
		foreach(array('大小', '单双') as $i){
			zoushi('总和', $i, $lot_t['总和'.$i], $lot_t['line']);
		}
		/* 龙虎斗 */
		$lot_t['龙虎斗'] = $tempNum[0]==$tempNum[4]?'和':($tempNum[0]>$tempNum[4]?'龙':'虎');
		// foreach(array('龙', '虎', '和') as $i){
		// 	if($i==$lot_t['龙虎斗']){
		// 		if(isset($lot_changlong['两面长龙']['龙虎斗-'.$i])){
		// 			$lot_changlong['两面长龙']['龙虎斗-'.$i]++;
		// 		}else{
		// 			$lot_changlong['两面长龙']['龙虎斗-'.$i] = 1;
		// 		}
		// 	}else{
		// 		if(isset($lot_changlong['两面长龙']['龙虎斗-'.$i])){
		// 			unset($lot_changlong['两面长龙']['龙虎斗-'.$i]);
		// 		}
		// 	}
		// }
		zoushi('龙虎斗', '龙虎斗', $lot_t['龙虎斗'], $lot_t['line']);
		arsort($lot_changlong['两面长龙']);
		$lot_changlong['date'] = date('Ymd', $qishu);
		$lot_changlong['lastest'] = $qishu;
		$lot_changlong['output'] = array();
		$lot_changlong['output']['ChangLong'] = array();
		$lot_changlong['output']['LuZhu'] = array();
		$lot_changlong['output']['ZongchuYilou'] = array();
		$lot_changlong['output']['ZongchuYilou']['miss'] = array();
		$lot_changlong['output']['ZongchuYilou']['hit'] = array();
		foreach(array('第一球', '第二球', '第三球', '第四球', '第五球') as $key=>$val){
			$key++;
			$lot_changlong['output']['LuZhu'][] = array(
				'c' => implode(',', $lot_changlong[$val]['和']),
				'n' => $val,
				'p' => $key,
			);
		}
		foreach(array('大小', '单双') as $val){
			$lot_changlong['output']['LuZhu'][] = array(
				'c' => implode(',', $lot_changlong['总和'][$val]),
				'n' => '总和'.$val,
				'p' => 0,
			);
		}
		$lot_changlong['output']['LuZhu'][] = array(
			'c' => implode(',', $lot_changlong['龙虎斗']['龙虎斗']),
			'n' => '龙虎斗',
			'p' => 0,
		);
		foreach(array('第一球', '第二球', '第三球', '第四球', '第五球') as $key=>$val){
			$key++;
			$lot_changlong['output']['LuZhu'][] = array(
				'c' => implode(',', $lot_changlong[$val]['大小']),
				'n' => '大小',
				'p' => $key,
			);
			$lot_changlong['output']['LuZhu'][] = array(
				'c' => implode(',', $lot_changlong[$val]['单双']),
				'n' => '单双',
				'p' => $key,
			);
			$key = 'n'.$key;
			$lot_changlong['output']['ZongchuYilou']['hit'][$key] = array();
			for($i=0;$i<10;$i++){
				$lot_changlong['output']['ZongchuYilou']['hit'][$key][] = isset($lot_changlong[$val]['号码'][$i])?$lot_changlong[$val]['号码'][$i]:0;
			}
		}
		foreach($lot_changlong['两面长龙'] as $key=>$val){
			$val>1&&$lot_changlong['output']['ChangLong'][] = array($key, $val);
		}
		if(empty($lot_changlong['output']['ChangLong'])){
			foreach($lot_changlong['两面长龙'] as $key=>$val){
				$lot_changlong['output']['ChangLong'][] = array($key, $val);
			}
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
<title>极速时时彩</title>
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
