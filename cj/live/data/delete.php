<?php
header("Content-type:text/html; Charset=utf-8");
include_once $_SERVER['DOCUMENT_ROOT']."/database/mysql.config.php";
$table = array(
  'agbetdetail',
  'aginbetdetail',
  'xinbetdetail',
  'bbbetdetail',
  'ogbetdetail',
  'shababetdetail',
  'mgbetdetail',
  'ptbetdetail',
  'hunterbetdetail',
  'agtransferdetail',
  'agintransferdetail',
  'bbtransferdetail',
  'ogtransferdetail',
  'shabatransferdetail',
  'mgtransferdetail',
  'pttransferdetail',
  'huntertransferdetail',
  'bbin2betdetail',
  'bgbetdetail',
  'bglivebetdetail',
  'cq9betdetail',
  'dgbetdetail',
  'kgbetdetail',
  'kybetdetail',
  'mg2betdetail',
  'og2betdetail',
  'pt2betdetail',
  'mwbetdetail',
  'sbbetdetail',
  'vrbetdetail',
  'yoplaybetdetail',
  );
$html = '';

$hours = date('H');
if($hours == '17'){//数据清除不必时时执行，改凌晨5点执行
  foreach($table as $value){
    $date = date('Y-m-d',strtotime("-60 day"))." 23:59:59";
    $params = array(':updateTime'=>$date);
    $sql = 'delete from '.$value.' where updateTime<:updateTime';
    $stmt = $mydata1_db->prepare($sql);
    $stmt -> execute($params);
    $html .= "表 [".$value."] 数据清除完成!!<br>";
  }
}

//OPTIMIZE TABLE
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>删除60天的平台记录</title>
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
</style>
</head>
<script>
<!--

var limit="86400"
if (document.images){
  var parselimit=limit
}
function beginrefresh(){
if (!document.images)
  return
if (parselimit==1)
  self.location.reload()
else{
  parselimit-=1
  curmin=Math.floor(parselimit)
  if (curmin!=0)
    curtime=curmin+"秒后获取数据！"
  else
    curtime=cursec+"秒后获取数据！"

    timeinfo.innerText=curtime
    setTimeout("beginrefresh()",1000)
  }
}

window.onload=beginrefresh

</script>
<script language="javascript" src="/js/noerror.js"></script>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" style="padding-left:10px; padding-top:10px; line-height:22px;">
      <input type=button name=button value="刷新" onClick="window.location.reload()">
     <span id="timeinfo"></span><br />
     删除60天前的平台记录<br>
       <font color="#FF0000"><?=$html?></font> 
    
      </td>
  </tr>
</table>

</body>
</html>