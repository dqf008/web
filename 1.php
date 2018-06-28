<?php
if($_SERVER['HTTP_HOST'] != '127.0.0.1') die();
ini_set('display_errors',1);
include 'cj/live/live_giro.php';
$list = $mydata1_db->query('select uid from k_user where mg2money>=1 and is_stop=0 and iszhuan=1')->fetchAll(PDO::FETCH_ASSOC);
foreach($list as $li){
	$res = giro($li['uid'], 'MG2', 'OUT', 0, true);
	if($res != 'ok'){
		//if($res == '获取新MG电子余额失败!!!') sleep(1);
		//else
			echo $li['uid'].':'.$res;
	}
}