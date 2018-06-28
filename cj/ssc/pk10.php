<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");

$url = "爱博官网";
$title = "北京赛车PK10";
$jilu="";
$m = 0;
$client = new rpcclient($cj_url);
$arr = $client->bjpk10(10,$site_id);
$arr = a_decode64($arr);//解压
/* 两面长龙数据 开始 */
$lot_changlong = array(
	'两面长龙' => array(),
	'time' => 0,
	'lastest' => 0,
);
$cache_file = '../../cache/lot_pk10.php';
file_exists($cache_file)&&$lot_changlong = include($cache_file);
/* 两面长龙数据 结束 */
if(is_array($arr) and $arr){
	foreach(array_reverse($arr,true) as $key=>$v){
		$qishu = $key;
		$qishunum 	= substr($qishu,-2);
		$num = $v['number'];
		$datetime = $v['dateline'];
		
		$tempNum=explode(",",$num);
		$num1		= $tempNum[0];
		$num2		= $tempNum[1];
		$num3		= $tempNum[2];
		$num4		= $tempNum[3];
		$num5		= $tempNum[4];
		$num6		= $tempNum[5];
		$num7		= $tempNum[6];
		$num8		= $tempNum[7];
		$num9		= $tempNum[8];
		$num10		= $tempNum[9];
		
		if(strlen($qishu)>0 && is_numeric($num1)  && is_numeric($num2) && is_numeric($num3) && is_numeric($num4) && is_numeric($num5) && is_numeric($num6) && is_numeric($num7) && is_numeric($num8) && is_numeric($num9) && is_numeric($num10)){
			$params = array(':qishu' => $qishu, ':datetime' => $datetime, ':ball_1' => $num1, ':ball_2' => $num2, ':ball_3' => $num3, ':ball_4' => $num4, ':ball_5' => $num5, ':ball_6' => $num6, ':ball_7' => $num7, ':ball_8' => $num8, ':ball_9' => $num9, ':ball_10' => $num10,':ok'=>1);
				$sql = "insert into c_auto_4(qishu,datetime,ball_1,ball_2,ball_3,ball_4,ball_5,ball_6,ball_7,ball_8,ball_9,ball_10,ok) values (:qishu,:datetime,:ball_1,:ball_2,:ball_3,:ball_4,:ball_5,:ball_6,:ball_7,:ball_8,:ball_9,:ball_10,:ok) ON DUPLICATE KEY UPDATE datetime=values(datetime),ball_1=values(ball_1),ball_2=values(ball_2),ball_3=values(ball_3),ball_4=values(ball_4),ball_5=values(ball_5),ball_6=values(ball_6),ball_7=values(ball_7),ball_8=values(ball_8),ball_9=values(ball_9),ball_10=values(ball_10),ok=values(ok)";
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$m=$m+1;
			/* 两面长龙数据 开始 */
			if($lot_changlong['lastest']<$qishu){
				// $lot_changlong = array(
				// 	'两面长龙' => array(),
				// 	'冠亚' => array(),
				// 	'lastest' => 0,
				// );
				$lot_t = array();
				$lot_t['和'] = $tempNum[0]+$tempNum[1];
				$lot_t['大小'] = $lot_t['和']==11?'和':($lot_t['和']>11?'大':'小');
				$lot_t['单双'] = $lot_t['和']==11?'和':(fmod($lot_t['和'], 2)==0?'双':'单');
				foreach(array('和', '大小', '单双') as $i){
					zoushi('冠亚', $i, $lot_t[$i], $lot_changlong['time']+7200<time());
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
				$lot_changlong['time'] = time();
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
		$jilu .= '第'.$qishu.'期：'.$num."<br>";	
	}
}else{
	print_r($arr);
}
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
<title><?=$title.' '.$url?></title>
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

<? $limit= rand(6,15);?>
var limit="<?=$limit?>"
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
	   采集网址：<?=$url?><br />
       <font color="#FF0000"><?=$title?> 共采集到<?=$m?>期</font> 
	   <?
		$xianshi = explode("<br>",$jilu);
		foreach(array_reverse($xianshi,true) as $v){
			echo $v."<br>";
		}
	 
	 ?>
      </td>
  </tr>
</table>
</body>
</html>
