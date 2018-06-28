<?php 
header('Content-Type:text/html;charset=utf-8');
include_once ("../include/function.php");

$lottery_time_bf = (time() + (1 * 12 * 3600)) - (1 * 24 * 3600);
$l_date_bf = date('Y-m-d', $lottery_time_bf);
$lottery_time = time() + (1 * 12 * 3600);
$l_date = date('Y-m-d', $lottery_time);
$params = array(':l_date' => $l_date);
$sql = 'select count(qihao) from lottery_k_kl8 where left(kaipan,10)=:l_date';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$cou = $stmt->fetchColumn();

$client = new rpcclient($cj_url);
$kl8 = $client->k_kl8($site_id);
$kl8 = a_decode64($kl8);//解压
if(is_array($kl8) and $kl8){
  $kl8_ktime = $kl8['ktime'];
  $fixno = $kl8['kno'];
  $daynum = floor(($lottery_time - strtotime($kl8_ktime . ' 00:00:00')) / 3600 / 24);
  $lastno = (($daynum - 1) * 179) + $fixno-1;
  if ($cou == 0){
  	$sql = 'select * from lottery_t_kl8 order by id asc';
  	$result = $mydata1_db->query($sql);
  	while ($row = $result->fetch()){
      
  		$qihao = $row['qihao'] + $lastno;
  		$kaipan = str_replace('2010-06-01', $l_date, $row['kaipan']);
  		$fengpan = str_replace('2010-06-01', $l_date, $row['fengpan']);
  		$addtime = date('Y-m-d H:i:s', $lottery_time);
  		$paramsSub = array(':qihao' => $qihao, ':kaipan' => $kaipan, ':fengpan' => $fengpan, ':addtime' => $addtime);
  		$sqlSub = 'insert into lottery_k_kl8 set qihao=:qihao,kaipan=:kaipan,fengpan=:fengpan,addtime=:addtime';
  		$stmtSub = $mydata1_db->prepare($sqlSub);
  		$stmtSub->execute($paramsSub);
  	}
  }
}else{
  print_r($kl8);
  exit;
}
?> 
<html> 
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
  <table width="100%"border="0" cellpadding="0" cellspacing="0"> 
    <tr>  
      <td align="left"> 
        <input type=button name=button value="刷新" onClick="window.location.reload()"> 
        北京快乐8(<?=$l_date;?>:盘口添加成功!): 
        <span id="timeinfo"></span> 
        </td> 
    </tr> 
  </table> 
  </body> 
  </html>