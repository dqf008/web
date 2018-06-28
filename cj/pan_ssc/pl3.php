<?php 
header('Content-Type:text/html;charset=utf-8');
include_once ("../include/function.php");

$lottery_time = time() + (1 * 12 * 3600);
$l_time = date('Y-m-d H:i:s', $lottery_time);
$isOk = 0;

$client = new rpcclient($cj_url);
$pl3 = $client->k_pl3($site_id);
$pl3 = a_decode64($pl3);//解压

if(is_array($pl3) and $pl3){
  $old_kaipan = $pl3['ktime'];
  $old_fengpan = $pl3['ftime'];
  $old_qihao = $pl3['kno'];
  //计算相差的天数
  $day=floor(($lottery_time-strtotime($old_kaipan))/86400);
  if($day==0){
    $new_qihao = $old_qihao + 1;
    $new_k_date = date('Y-m-d H:i:s',strtotime('+1day',strtotime($old_kaipan)));
    $new_f_date = date('Y-m-d H:i:s',strtotime('+1day',strtotime($old_fengpan)));
  }else{
    $new_qihao = $old_qihao + $day;
    $new_k_date = date('Y-m-d H:i:s',strtotime('+'.$day.'day',strtotime($old_kaipan)));
    $new_f_date = date('Y-m-d H:i:s',strtotime('+'.$day.'day',strtotime($old_fengpan)));
  }
  
  //echo $new_qihao."--".$new_k_date."--".$new_f_date;exit;
  //开设新盘口
  $params = array(':qihao'=>$new_qihao);
  $sql = 'select count(*) from lottery_k_pl3 where qihao=:qihao';
  $stmt = $mydata1_db->prepare($sql);
  $stmt->execute($params);
  $sum = $stmt->fetchColumn();
  if($sum==0){
      $params = array(':qihao' => $new_qihao, ':kaipan' => $new_k_date, ':fengpan' => $new_f_date);
      $sql = 'insert into lottery_k_pl3 set qihao=:qihao,kaipan=:kaipan,fengpan=:fengpan,hm1=0,hm2=0,hm3=0';
      $stmt = $mydata1_db->prepare($sql);
      $stmt->execute($params); 
      $isOk = 1;
  }
}else{
  print_r($pl3);
  exit;
}
?> 
<html> 
  <head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title>排列三盘口开放</title> 
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
        排列3开盘<br>
        <?php
          if($isOk==1){
            echo '('.date('Y-m-d',$lottery_time).':盘口添加成功!)'; 
          }
        ?>
        <span id="timeinfo"></span> 
        </td> 
    </tr> 
  </table> 
  </body> 
  </html>