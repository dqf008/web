<?php 
header('Content-Type:text/html;charset=utf-8');
include_once ("../include/function.php");

$lottery_time = time() + (1 * 12 * 3600);
$l_time = date('Y-m-d H:i:s', $lottery_time);
$isOk = 0;

//获取最近一期的期号
$params = array(':ok'=>1,':k_date'=>$l_time);
$sql = 'select * from lottery_k_3d where kaipan<:k_date and ok=:ok and hm1 is not null order by kaipan desc limit 0,1';
$stmt = $mydata1_db->prepare($sql);
$stmt -> execute($params);
$rs = $stmt->fetch();
$old_kaipan = $rs['kaipan'];
$old_fengpan = $rs['fengpan'];
$old_qihao = $rs['qihao'];
if($old_qihao>0){
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

  $nowmd = date('md',strtotime($new_k_date));
  if($nowmd=='1231') {//年末
    $new_qihao = (date('Y',strtotime($new_k_date))+1).'001'; 
  } 
  //echo $new_qihao."--".$new_k_date."--".$new_f_date;exit;
  //开设新盘口
  $params = array(':qihao'=>$new_qihao);
  $sql = 'select count(*) from lottery_k_3d where qihao=:qihao';
  $stmt = $mydata1_db->prepare($sql);
  $stmt->execute($params);
  $sum = $stmt->fetchColumn();
  if($sum==0){
      $params = array(':qihao' => $new_qihao, ':kaipan' => $new_k_date, ':fengpan' => $new_f_date);
      $sql = 'insert into lottery_k_3d set qihao=:qihao,kaipan=:kaipan,fengpan=:fengpan,hm1=0,hm2=0,hm3=0';
      $stmt = $mydata1_db->prepare($sql);
      $stmt->execute($params); 
      $isOk = 1;
  }
}

?> 
<html> 
  <head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title>福彩3D盘口开放</title> 
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
        福彩3D开盘<br>
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