<?php header('Content-Type:text/html;charset=utf-8');
include_once '../../../include/config.php';
include_once '../../../database/mysql.config.php';
require 'curl_http.php';
require 'include/getapi.php';
$List = getfile();
$apiflag = $List->apiflag;
$qihao = $List->qihao;
$addtime = $List->addtime;
$hm1 = $List->hm1;
$hm2 = $List->hm2;
$hm3 = $List->hm3;
if ($apiflag == 'ok')
{
	try
	{
		$params = array(':qihao' => $qihao);
		$sql = 'select count(*) from lottery_k_ssl where qihao=:qihao';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$cou = $stmt->fetchColumn();
		if ($cou == 0)
		{
			$params = array(':qihao' => $qihao, ':hm1' => $hm1, ':hm2' => $hm2, ':hm3' => $hm3, ':addtime' => $addtime);
			$mysql = 'insert into lottery_k_ssl set qihao=:qihao,hm1=:hm1,hm2=:hm2,hm3=:hm3,addtime=:addtime';
			$stmt = $mydata1_db->prepare($mysql);
			$stmt->execute($params);
		}
	}
	catch (Exception $ex)
	{
		$qihao = 'Fail';
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
        上海时时乐(<?=$qihao;?>期:<?=$hm1 ;?>,<?=$hm2 ;?>,<?=$hm3;?>): 
        <span id="timeinfo"></span> 
        </td> 
    </tr> 
  </table> 
  <iframe src="ssl_auto.php?qi=<?=$qihao;?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>   
  </body> 
  </html><?php function getFile()
{
	global $arrcur;
	$curl = new Curl_HTTP_Client();
	$url = 'http://' . $arrcur[1] . '/ssl.php?_t=' . time();
	$fileString = $curl->fetch_url($url);
	$fileString = json_decode($fileString);
	return $fileString;
}?>