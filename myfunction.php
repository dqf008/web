<?php 
function get_webinfo_bycode($code){
	global $mydata1_db;
	$params = array(':code' => $code);
	$sql = 'select * from webinfo where code=:code limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$row = $stmt->fetch();
	return $row;
}

function get_last_message($is_ty=false, $line='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'){
	global $mydata1_db;
	$msg = array();
	$k_notice = $is_ty?'k_notice_ty':'k_notice';
	$sql = 'select msg from '.$k_notice.' where end_time>now() and is_show=1 and web_ID is null order by `sort` desc,nid desc limit 0,5';
	$query = $mydata1_db->query($sql);
	while ($rs = $query->fetch())
	{
		$msg[] = $rs['msg'];
	}
    $line&&$msg = implode($line, $msg);
	return $msg;
}

function get_mobile_message(){
	global $mydata1_db;
	$msg = array();
	$sql = 'select msg from k_notice where end_time>now() and is_show=1 and web_ID is null order by `sort` desc,nid desc limit 0,5';
	$query = $mydata1_db->query($sql);
	while ($rs = $query->fetch())
	{
		$msg[] = $rs['msg'];
	}
	return $msg;
}

function get_images($code){
	global $mydata1_db;
	$stmt = $mydata1_db->prepare('SELECT * FROM `webinfo` WHERE `code`=:code LIMIT 1');
	$stmt->execute(array(':code' => $code));
	if($stmt->rowCount()>0){
		$rows = $stmt->fetch();
		if(isset($rows['content'])&&!empty($rows['content'])&&($return = unserialize($rows['content']))!==false){
			return $return;
		}else{
			return array();
		}
	}else{
		return array();
	}
}