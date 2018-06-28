<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");

$url = "爱博官网";
$title = "北京快乐8";
$jilu="";
$m = 0;
$client = new rpcclient($cj_url);
$arr = $client->kl8(10,$site_id);
$arr = a_decode64($arr);//解压
/* 两面长龙数据 开始 */
$lot_changlong = array(
	'两面长龙' => array(),
	'time' => 0,
	'lastest' => 0,
);
$cache_file = '../../cache/lot_kl8.php';
file_exists($cache_file)&&$lot_changlong = include($cache_file);
/* 两面长龙数据 结束 */
if(is_array($arr) and $arr){
	foreach(array_reverse($arr,true) as $key=>$v){
		$qihao = $key;
		$qihaonum 	= substr($qihao,-2);
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
		$num11		= $tempNum[10];
		$num12		= $tempNum[11];
		$num13		= $tempNum[12];
		$num14		= $tempNum[13];
		$num15		= $tempNum[14];
		$num16		= $tempNum[15];
		$num17		= $tempNum[16];
		$num18		= $tempNum[17];
		$num19		= $tempNum[18];
		$num20		= $tempNum[19];
		
		if(strlen($qihao)>0 && is_numeric($num1)  && is_numeric($num2) && is_numeric($num3) && is_numeric($num4) && is_numeric($num5) && is_numeric($num6) && is_numeric($num7) && is_numeric($num8) && is_numeric($num9) && is_numeric($num10) && is_numeric($num11)  && is_numeric($num12) && is_numeric($num13) && is_numeric($num14) && is_numeric($num15) && is_numeric($num16) && is_numeric($num17) && is_numeric($num18) && is_numeric($num19) && is_numeric($num20)){

			$params = array(':qihao'=>$qihao);
			$sql = 'select count(*) from lottery_k_kl8 where qihao=:qihao order by id asc limit 0,1';
			$stmt = $mydata1_db->prepare($sql);
			$stmt -> execute($params);
			$sum = $stmt -> fetchColumn();

			if($sum==1){
				$params = array(':hm1' => $num1, ':hm2' => $num2, ':hm3' => $num3, ':hm4' => $num4, ':hm5' => $num5, ':hm6' => $num6, ':hm7' => $num7, ':hm8' => $num8, ':hm9' => $num9, ':hm10' => $num10, ':hm11' => $num11, ':hm12' => $num12, ':hm13' => $num13, ':hm14' => $num14, ':hm15' => $num15, ':hm16' => $num16, ':hm17' => $num17, ':hm18' => $num18, ':hm19' => $num19, ':hm20' => $num20, ':addtime' => $datetime, ':qihao' => $qihao,':ok'=>1);
			
				$sql = 'update  lottery_k_kl8 set addtime=:addtime, hm1=:hm1,hm2=:hm2,hm3=:hm3,hm4=:hm4,hm5=:hm5,hm6=:hm6,hm7=:hm7,hm8=:hm8, hm9=:hm9,hm10=:hm10,hm11=:hm11,hm12=:hm12,hm13=:hm13,hm14=:hm14,hm15=:hm15,hm16=:hm16,hm17=:hm17,hm18=:hm18,hm19=:hm19,hm20=:hm20,ok=:ok where qihao=:qihao';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				$m=$m+1;
				$jilu .= '第'.$qihao.'期：'.$num."<br>";
			}
			/* 两面长龙数据 开始 */
			if($lot_changlong['lastest']<$qihao){
				$lot_t = array('和值' => 0, '奇和偶' => 0, '上中下' => 0);
				$lot_t['line'] = $lot_changlong['time']+7200<time();
				foreach($tempNum as $k=>$n){
					$lot_t['和值']+= $n;
				    $n<=40&&$lot_t['上中下']++;
				    fmod($n, 2)!=0&&$lot_t['奇和偶']++;
				}
				/* 和值 */
				$lot_t['和值大小'] = $lot_t['和值']==810?'和':($lot_t['和值']>810?'大':'小');
				$lot_t['和值单双'] = fmod($lot_t['和值'], 2)==0?'双':'单';
				foreach(array('大' => '大小', '小' => '大小', '和' => '大小', '单' => '单双', '双' => '单双') as $i=>$j){
					changlong('和值'.$j, $i, $lot_t['和值'.$j]);
				}
				foreach(array('大小', '单双') as $i){
					zoushi('和值', $i, $lot_t['和值'.$i], $lot_t['line']);
				}
				/* 盘位 */
				$lot_t['上中下盘'] = $lot_t['上中下']>10?'上':($lot_t['上中下']<10?'下':'中');
				$lot_t['奇和偶盘'] = $lot_t['奇和偶']>10?'奇':($lot_t['奇和偶']<10?'偶':'和');
				foreach(array('上' => '上中下', '下' => '上中下', '中' => '上中下', '奇' => '奇和偶', '偶' => '奇和偶', '和' => '奇和偶') as $i=>$j){
					changlong($j.'盘', $i, $lot_t[$j.'盘']);
				}
				foreach(array('上中下', '奇和偶') as $i){
					zoushi('盘位', $i, $lot_t[$i.'盘'], $lot_t['line']);
				}
				arsort($lot_changlong['两面长龙']);
				$lot_changlong['time'] = time();
				$lot_changlong['lastest'] = $qihao;
				$lot_changlong['output'] = array();
				$lot_changlong['output']['ChangLong'] = array();
				$lot_changlong['output']['LuZhu'] = array();
				$lot_changlong['output']['ZongchuYilou'] = array();
				$lot_changlong['output']['ZongchuYilou']['miss'] = array();
				$lot_changlong['output']['ZongchuYilou']['hit'] = array();
		        foreach(array('大小', '单双') as $val){
		            $lot_changlong['output']['LuZhu'][] = array(
		                'c' => implode(',', $lot_changlong['和值'][$val]),
		                'n' => '和值'.$val,
		                'p' => 0,
		            );
		        }
		        foreach(array('上中下', '奇和偶') as $val){
		            $lot_changlong['output']['LuZhu'][] = array(
		                'c' => implode(',', $lot_changlong['盘位'][$val]),
		                'n' => $val.'盘',
		                'p' => 0,
		            );
		        }
				foreach($lot_changlong['两面长龙'] as $key=>$val){
					$lot_changlong['output']['ChangLong'][] = array($key, $val);
				}
				file_put_contents($cache_file, '<?php'.PHP_EOL.'return unserialize(\''.serialize($lot_changlong).'\');');
			}
			/* 两面长龙数据 结束 */
		}
		
			
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
