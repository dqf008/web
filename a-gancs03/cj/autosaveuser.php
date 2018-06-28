<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
$today = date('Y-m-d H:i:s');
$today_day = date('Y-m-d');
$q1 = 0;
try{
	if (strpos($today, ' 23:59:0') || strpos($today, ' 23:59:1') || strpos($today, ' 23:59:2') || strpos($today, ' 23:59:3') || strpos($today, ' 23:59:4') || strpos($today, ' 23:59:5')){
		$params = array(':addtime' => $today_day . '%');
		$sql = 'select count(id) from mydata3_db.save_user where `addtime` like (:addtime) limit 1';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$rs_count = $stmt->fetchColumn();
		if (0 < $rs_count){

		}else{
			$user = array();
			$uid = '';
			$i = 0;
			$userwhere = '';
			$params = array();
			$sql = 'select uid,username,money from k_user where is_stop=0 and is_delete=0 and money>0';
			$query = $mydata1_db->query($sql);
			$arr_count = $query->rowCount();
			$q1 = $arr_count;
			while ($rs = $query->fetch()){
				$user[$rs['uid']]['money'] = $rs['money'];
				$user[$rs['uid']]['username'] = $rs['username'];
				$uid .= intval($rs['uid']) . ',';
				$i++;
				$params[':username_' . $i] = $rs['username'];
				if ($i == 1){
					$userwhere .= ' and (username=:username_' . $i;
				}else{
					$userwhere .= ' or username=:username_' . $i;
				}

				if ($i == $arr_count){
					$userwhere .= ')';
				}
				$arruser[$rs['username']] = $rs['uid'];
			}
			$uid = rtrim($uid, ',');

			if ($uid){
				$bid_gid = array();
				$sql = 'select uid,number from k_bet where `status`=0 and uid in (' . $uid . ')';
				$query = $mydata1_db->query($sql);
				while ($rs = $query->fetch()){
					$bid_gid[$rs['uid']] .= $rs['number'] . ',';
				}

				$sql = 'select uid,gid from k_bet_cg_group where `status` in (0,2) and uid in (' . $uid . ')';
				$query = $mydata1_db->query($sql);
				while ($rs = $query->fetch()){
					$bid_gid[$rs['uid']] .= $rs['gid'] . ',';
				}

				foreach ($user as $uid => $arr){
					$bid_gid[$uid] = rtrim($bid_gid[$uid], ',') . '#';
				}

				$sql = 'select username,num from ka_tan where `checked`=0 ' . $userwhere;
				$stmt = $mydata2_db->prepare($sql);
				$stmt->execute($params);
				while ($rs = $stmt->fetch()){
					$current_uid = $arruser[$rs['username']];
					$bid_gid[$current_uid] .= $rs['num'] . ',';
				}

				foreach ($user as $uid => $arr){
					$bid_gid[$uid] = rtrim($bid_gid[$uid], ',') . '#';
				}

				$sql = 'select uid,id from c_bet where `js`=0 and uid in (' . $uid . ')';
				$query = $mydata1_db->query($sql);
				while ($rs = $query->fetch()){
					$bid_gid[$rs['uid']] .= $rs['id'] . ',';
				}

				foreach ($user as $uid => $arr){
					$bid_gid[$uid] = rtrim($bid_gid[$uid], ',') . '#';
				}

				$sql = 'select uid,id from c_bet_3 where `js`=0 and uid in (' . $uid . ')';
				$query = $mydata1_db->query($sql);
				while ($rs = $query->fetch()){
					$bid_gid[$rs['uid']] .= $rs['id'] . ',';
				}

				foreach ($user as $uid => $arr){
					$bid_gid[$uid] = rtrim($bid_gid[$uid], ',') . '#';
				}

				$sql = 'select username,uid as number from lottery_data where `bet_ok`=0 ' . $userwhere;
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				while ($rs = $stmt->fetch()){
					$current_uid = $arruser[$rs['username']];
					$bid_gid[$current_uid] .= $rs['number'] . ',';
				}

				foreach ($user as $uid => $arr){
					$params = array(':uid' => $uid, ':username' => $arr['username'], ':money' => $arr['money'], ':bid_gid' => rtrim($bid_gid[$uid], ','), ':addtime' => $today);
					$sql = 'insert into mydata3_db.save_user(uid,username,money,bid_gid,addtime) values (:uid,:username,:money,:bid_gid,:addtime)';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
				}
			}
		}
		$sql = 'delete from mydata3_db.save_user where id in (select id from (select max(id) as id,count(*) as count from mydata3_db.save_user where DATEDIFF(now(),addtime)<=1 group by uid,date_format(addtime,\'%Y-%m-%d\') having count>1) as temp)';
		$mydata1_db->query($sql);
	}
}catch (Exception $ex){
	$q1 = 'Fail';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<!-- 

<? $limit= rand(120,180);?>
var limit="<?=$limit?>"
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
    <td align="left" style="padding-left:10px; padding-top:10px; line-height:22px;">
      <input type=button name=button value="刷新" onClick="window.location.reload()">
	   <span id="timeinfo"></span><br />
	  	<font color="#FF0000"><?=$q1?> 条</font>
      </td>
  </tr>
</table>
</body>
</html>
