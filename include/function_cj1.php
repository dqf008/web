<?php 
function zqgq_cj(){
	include_once __DIR__ . '/pub_library.php';
	global $mydata1_db;
	$gq_sql = 'select mid_str,lasttime from mydata4_db.gunqiu where id=1';
	$gq_query = $mydata1_db->query($gq_sql);
	if ($gq_row = $gq_query->fetch()){
		if (!write_file(__DIR__ . '/../cache/zqgq.php', '<?php ' . stripcslashes($gq_row['mid_str']) . '?>')){
			return false;
		}else if (3 < (time() - strtotime($gq_row['lasttime']))){
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}

function lqgq_cj()
{
	include_once __DIR__ . '/pub_library.php';
	global $mydata1_db;
	$gq_sql = 'select mid_str,lasttime from mydata4_db.gunqiu where id=2';
	$gq_query = $mydata1_db->query($gq_sql);
	if ($gq_row = $gq_query->fetch()){
		if (!write_file(__DIR__ . '/../cache/lqgq.php', '<?php ' . stripcslashes($gq_row['mid_str']) . '?>')){
			return false;
		}else if (3 < (time() - strtotime($gq_row['lasttime']))){
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}
?>