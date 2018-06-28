<?php 
header('Content-Type:text/html;charset=utf-8');
include_once ("../include/function.php");

//获取最近一期的信息
$sql = 'SELECT `qishu`, `status`, `kaijiang` FROM `lottery_k_qxc` ORDER BY `kaijiang` DESC LIMIT 1';
$query = $mydata1_db->query($sql);
if($query->rowCount()>0){
    $rows = $query->fetch();
    if($rows['status']==1){
        unset($rows['status']);
        $lottery_time = time()+43200;
        $date_time = strtotime(date('Y-m-d 00:00:00', $lottery_time));
        /* 最后一条已经开奖 */
        $data_w = date('w', $date_time);
        $data_y = date('Y', $date_time);
        if($lottery_time-$date_time>73800){
            $day_list = array(2, 1, 3, 2, 1, 2, 1);
        }else{
            $day_list = array(0, 1, 0, 2, 1, 0, 1);
        }
        $date_time+= $day_list[$data_w]*86400;
        $rows['kaipan'] = $rows['kaijiang'];
        $rows['fengpan'] = $date_time+73740;
        $rows['kaijiang'] = $date_time+73800;
        if($data_y!=substr($rows['qishu'], 0, 4)){
            $rows['qishu'] = $data_y.'001';
        }else{
            $rows['qishu']++;
        }
        $params = array();
        foreach($rows as $key=>$val){
            !is_numeric($key)&&$params[':'.$key] = $val;
        }
        $sql = 'INSERT INTO `lottery_k_qxc` (`qishu`, `kaipan`, `fengpan`, `kaijiang`, `value`, `status`) VALUES (:qishu, :kaipan, :fengpan, :kaijiang, NULL, 0)';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params); 
    }
}

?> 
<html> 
  <head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title>七星彩自动开盘</title> 
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
        七星彩自动开盘<br>当前期号：<?php echo $rows['qishu']; ?><br />
        <span id="timeinfo"></span> 
        </td> 
    </tr> 
  </table> 
  </body> 
  </html>