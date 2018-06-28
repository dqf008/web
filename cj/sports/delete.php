<?php
header("Content-type:text/html; Charset=utf-8");
include_once __DIR__ . '/../../class/Db.class.php';

$table = array('k_bet','k_bet_cg','k_bet_cg_group');
$html = '';
$db = new DB();
foreach($table as $value){
  $date = date('Y-m-d',strtotime("-30 day"))." 23:59:59";
  $params = array('updateTime'=>$date);
  $sql = 'delete from '.$value.' where bet_time<:updateTime';
  $db->query($sql,$params);
  $html .= "表 [".$value."] 数据清除完成!!<br>";
}
$db->CloseConnection();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>删除30天的体育注单记录</title>
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
     删除30天前的体育注单记录<br>
       <font color="#FF0000"><?=$html?></font> 
    
      </td>
  </tr>
</table>

</body>
</html>

</script>