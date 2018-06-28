<?php header('Content-Type:text/html;charset=utf-8');
include_once '../../../include/config.php';
include_once '../../../database/mysql.config.php';
require 'curl_http.php';
require 'include/getapi.php';
$List = getfile();
$apiflag = $List->apiflag;
$qihao = $List->qihao;
$kaipan = $List->kaipan;
$fengpan = $List->fengpan;
$hm1 = $List->hm1;
$hm2 = $List->hm2;
$hm3 = $List->hm3;
$pl3_List = pl3_getfile();
$pl3_apiflag = $pl3_List->apiflag;
$pl3_qihao = $pl3_List->qihao;
$pl3_kaipan = $pl3_List->kaipan;
$pl3_fengpan = $pl3_List->fengpan;
$pl3_hm1 = $pl3_List->hm1;
$pl3_hm2 = $pl3_List->hm2;
$pl3_hm3 = $pl3_List->hm3;
if ($apiflag == 'ok')
{
	try
	{
		$params = array(':qihao' => $qihao);
		$sql = 'select * from lottery_k_3d where qihao=:qihao';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$result = $stmt->fetch();
		$cou = $stmt->rowCount();
		if ($cou == 1)
		{
			if ($result['ok'] == 0)
			{
				$params = array(':hm1' => $hm1, ':hm2' => $hm2, ':hm3' => $hm3, ':qihao' => $qihao);
				$sql = 'update lottery_k_3d set hm1=:hm1,hm2=:hm2,hm3=:hm3 where qihao=:qihao';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
			}
		}
		else
		{
			$params = array(':qihao' => $qihao, ':kaipan' => $kaipan, ':fengpan' => $fengpan, ':hm1' => $hm1, ':hm2' => $hm2, ':hm3' => $hm3);
			$sql = 'insert into lottery_k_3d set qihao=:qihao,kaipan=:kaipan,fengpan=:fengpan,hm1=:hm1,hm2=:hm2,hm3=:hm3';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
		$nowtime = strtotime($fengpan);
		$nowmd = date('md', $nowtime);
		if ('1231' == $nowmd)
		{
			$newqihao = (date('Y', $nowtime) + 1) . '001';
		}
		else
		{
			$newqihao = $qihao + 1;
		}
		$params = array(':qihao' => $newqihao);
		$sql = 'select count(*) from lottery_k_3d where qihao=:qihao';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$cou = $stmt->fetchColumn();
		if ($cou == 0)
		{
			$newkaipan = date('Y-m-d H:i:s', strtotime($kaipan) + (1 * 24 * 3600));
			$newfengpan = date('Y-m-d H:i:s', strtotime($fengpan) + (1 * 24 * 3600));
			$params = array(':qihao' => $newqihao, ':kaipan' => $newkaipan, ':fengpan' => $newfengpan);
			$sql = 'insert into lottery_k_3d set qihao=:qihao,kaipan=:kaipan,fengpan=:fengpan,hm1=0,hm2=0,hm3=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
	}
	catch (Exception $ex)
	{
		$qihao = 'Fail';
	}
}
if ($pl3_apiflag == 'ok')
{
	try
	{
		$params = array(':qihao' => $pl3_qihao);
		$sql = 'select * from lottery_k_pl3 where qihao=:qihao';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$result = $stmt->fetch();
		$cou = $stmt->rowCount();
		if ($cou == 1)
		{
			if ($result['ok'] == 0)
			{
				$params = array(':hm1' => $pl3_hm1, ':hm2' => $pl3_hm2, ':hm3' => $pl3_hm3, ':qihao' => $pl3_qihao);
				$sql = 'update lottery_k_pl3 set hm1=:hm1,hm2=:hm2,hm3=:hm3 where qihao=:qihao';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
			}
		}
		else
		{
			$params = array(':qihao' => $pl3_qihao, ':kaipan' => $pl3_kaipan, ':fengpan' => $pl3_fengpan, ':hm1' => $pl3_hm1, ':hm2' => $pl3_hm2, ':hm3' => $pl3_hm3);
			$sql = 'insert into lottery_k_pl3 set qihao=:qihao,kaipan=:kaipan,fengpan=:fengpan,hm1=:hm1,hm2=:hm2,hm3=:hm3';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
		$nowtime = strtotime($pl3_fengpan);
		$nowmd = date('md', $nowtime);
		if ('1231' == $nowmd)
		{
			$pl3_newqihao = (date('y', $nowtime) + 1) . '001';
		}
		else
		{
			$pl3_newqihao = $pl3_qihao + 1;
		}
		$params = array(':qihao' => $pl3_newqihao);
		$sql = 'select count(*) from lottery_k_pl3 where qihao=:qihao';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$cou = $stmt->fetchColumn();
		if ($cou == 0)
		{
			$pl3_newkaipan = date('Y-m-d H:i:s', strtotime($pl3_kaipan) + (1 * 24 * 3600));
			$pl3_newfengpan = date('Y-m-d H:i:s', strtotime($pl3_fengpan) + (1 * 24 * 3600));
			$params = array(':qihao' => $pl3_newqihao, ':kaipan' => $pl3_newkaipan, ':fengpan' => $pl3_newfengpan);
			$sql = 'insert into lottery_k_pl3 set qihao=:qihao,kaipan=:kaipan,fengpan=:fengpan,hm1=0,hm2=0,hm3=0';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
	}
	catch (Exception $ex)
	{
		$pl3_qihao = 'Fail';
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
  var limit="300"  
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
        福彩3D(<?=$qihao;?>期:<?=$hm1;?>,<?=$hm2;?>,<?=$hm3;?>,新增<?=$newqihao;?>期): 
        排列三(<?=$pl3_qihao;?>期:<?=$pl3_hm1;?>,<?=$pl3_hm2;?>,<?=$pl3_hm3;?>,新增<?=$pl3_newqihao;?>期) 
        <span id="timeinfo"></span> 
        </td> 
    </tr> 
  </table> 
  <iframe src="3d_auto.php?qihao=<?=$qihao;?>" frameborder="0" scrolling="no" height="0" width="0"></iframe> 
  <iframe src="pl3_auto.php?qihao=<?=$pl3_qihao;?>" frameborder="0" scrolling="no" height="0" width="0"></iframe> 
  </body> 
  </html><?php function getFile()
{
	global $arrcur;
	$curl = new Curl_HTTP_Client();
	$url = 'http://' . $arrcur[1] . '/3d.php?_t=' . time();
	$fileString = $curl->fetch_url($url);
	$fileString = json_decode($fileString);
	return $fileString;
}
function pl3_getFile()
{
	global $arrcur;
	$curl = new Curl_HTTP_Client();
	$url = 'http://' . $arrcur[1] . '/pl3.php?_t=' . time();
	$fileString = $curl->fetch_url($url);
	$fileString = json_decode($fileString);
	return $fileString;
}?>