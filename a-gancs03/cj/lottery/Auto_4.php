<?php header('Content-Type:text/html;charset=utf-8');
include_once '../../../include/config.php';
include_once '../../../database/mysql.config.php';
require 'curl_http.php';
require 'include/getapi.php';
$List = getfile();
$apiflag = $List->apiflag;
$qishu = $List->qishu;
$datetime = $List->datetime;
$ball_1 = $List->ball_1;
$ball_2 = $List->ball_2;
$ball_3 = $List->ball_3;
$ball_4 = $List->ball_4;
$ball_5 = $List->ball_5;
$ball_6 = $List->ball_6;
$ball_7 = $List->ball_7;
$ball_8 = $List->ball_8;
$ball_9 = $List->ball_9;
$ball_10 = $List->ball_10;
$okflag = 0;
if ($apiflag == 'ok')
{
	try
	{
		$params = array(':qishu' => $qishu);
		$sql = 'select count(*) from c_auto_4 where qishu=:qishu order by id asc limit 0,1';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$sum = $stmt->fetchColumn();
		if ($sum == 0)
		{
			$params = array(':qishu' => $qishu, ':datetime' => $datetime, ':ball_1' => $ball_1, ':ball_2' => $ball_2, ':ball_3' => $ball_3, ':ball_4' => $ball_4, ':ball_5' => $ball_5, ':ball_6' => $ball_6, ':ball_7' => $ball_7, ':ball_8' => $ball_8, ':ball_9' => $ball_9, ':ball_10' => $ball_10);
			$sql = 'insert into c_auto_4(qishu,datetime,ball_1,ball_2,ball_3,ball_4,ball_5,ball_6,ball_7,ball_8,ball_9,ball_10 ) values (:qishu,:datetime,:ball_1,:ball_2,:ball_3,:ball_4,:ball_5,:ball_6,:ball_7,:ball_8,:ball_9,:ball_10)';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$okflag = 1;
		}
	}
	catch (Exception $ex)
	{
		$qishu = 'Fail';
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
  var limit="10"  
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
        北京赛车PK拾(<?=$qishu;?>期<?=$ball_1 ;?>,<?=$ball_2 ;?>,<?=$ball_3 ;?>,<?=$ball_4 ;?>,<?=$ball_5 ;?>,<?=$ball_6 ;?>,<?=$ball_7 ;?>,<?=$ball_8 ;?>,<?=$ball_9 ;?>,<?=$ball_10;?>): 
        <span id="timeinfo"></span> 
        </td> 
    </tr> 
  </table><?php if ($okflag == 1)
{?> <iframe src="js_4.php?qi=<?=$qishu;?>" frameborder="0" scrolling="no" height="0" width="0"></iframe><?php }?> </body> 
  </html><?php function getFile()
{
	global $arrcur;
	$curl = new Curl_HTTP_Client();
	$url = 'http://' . $arrcur[1] . '/pk10.php?_t=' . time();
	$fileString = $curl->fetch_url($url);
	$fileString = json_decode($fileString);
	return $fileString;
}?>