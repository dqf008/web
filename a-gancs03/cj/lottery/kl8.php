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
$hm4 = $List->hm4;
$hm5 = $List->hm5;
$hm6 = $List->hm6;
$hm7 = $List->hm7;
$hm8 = $List->hm8;
$hm9 = $List->hm9;
$hm10 = $List->hm10;
$hm11 = $List->hm11;
$hm12 = $List->hm12;
$hm13 = $List->hm13;
$hm14 = $List->hm14;
$hm15 = $List->hm15;
$hm16 = $List->hm16;
$hm17 = $List->hm17;
$hm18 = $List->hm18;
$hm19 = $List->hm19;
$hm20 = $List->hm20;
if ($apiflag == 'ok')
{
	try
	{
		$params = array(':qihao' => $qihao);
		$sql = 'select count(*) from lottery_k_kl8 where qihao=:qihao and ok=0';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$cou = $stmt->fetchColumn();
		if ($cou == 1)
		{
			$params = array(':hm1' => $hm1, ':hm2' => $hm2, ':hm3' => $hm3, ':hm4' => $hm4, ':hm5' => $hm5, ':hm6' => $hm6, ':hm7' => $hm7, ':hm8' => $hm8, ':hm9' => $hm9, ':hm10' => $hm10, ':hm11' => $hm11, ':hm12' => $hm12, ':hm13' => $hm13, ':hm14' => $hm14, ':hm15' => $hm15, ':hm16' => $hm16, ':hm17' => $hm17, ':hm18' => $hm18, ':hm19' => $hm19, ':hm20' => $hm20, ':addtime' => $addtime, ':qihao' => $qihao);
			$mysql = 'update lottery_k_kl8 set hm1=:hm1,hm2=:hm2,hm3=:hm3,hm4=:hm4,hm5=:hm5,hm6=:hm6,hm7=:hm7,hm8=:hm8,hm9=:hm9,hm10=:hm10,hm11=:hm11,hm12=:hm12,hm13=:hm13,hm14=:hm14,hm15=:hm15,hm16=:hm16,hm17=:hm17,hm18=:hm18,hm19=:hm19,hm20=:hm20,addtime=:addtime where qihao=:qihao';
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
  <table width="100%"border="0" cellpadding="0" cellspacing="0"> 
    <tr>  
      <td align="left"> 
        <input type=button name=button value="刷新" onClick="window.location.reload()"> 
        北京快乐8(<?=$qihao;?>期:<?=$hm1 ;?>,<?=$hm2 ;?>,<?=$hm3 ;?>,<?=$hm4 ;?>,<?=$hm5 ;?>,<?=$hm6 ;?>,<?=$hm7 ;?>,<?=$hm8 ;?>,<?=$hm9 ;?>,<?=$hm10 ;?>,<?=$hm11 ;?>,<?=$hm12 ;?>,<?=$hm13 ;?>,<?=$hm14 ;?>,<?=$hm15 ;?>,<?=$hm16 ;?>,<?=$hm17 ;?>,<?=$hm18 ;?>,<?=$hm19 ;?>,<?=$hm20;?>): 
        <span id="timeinfo"></span> 
        </td> 
    </tr> 
  </table> 
  <iframe src="kl8_auto.php?qi=<?=$qihao;?>" frameborder="0" scrolling="no" height="0" width="0"></iframe> 
  </body> 
  </html><?php function getFile()
{
	global $arrcur;
	$curl = new Curl_HTTP_Client();
	$url = 'http://' . $arrcur[1] . '/kl8.php?_t=' . time();
	$fileString = $curl->fetch_url($url);
	$fileString = json_decode($fileString);
	return $fileString;
}?>