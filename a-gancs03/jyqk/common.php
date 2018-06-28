<?php 
function getmatch_name($table, $sqlwhere, $params, $type = 0){
	global $mydata1_db;
	if ($type == 0)
	{
		$sql = 'select match_name from mydata4_db.' . $table . ' ' . $sqlwhere . ' group by match_name';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		while ($rs = $stmt->fetch())
		{
			$arr[] = $rs['match_name'];
		}
		return $arr;
	}
	else
	{
		$sql = 'select x_title as match_name from mydata4_db.' . $table . ' ' . $sqlwhere . ' group by x_title';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		while ($rs = $stmt->fetch())
		{
			$arr[] = $rs['match_name'];
		}
		return $arr;
	}
}

function getString($s){
	return $s ? $s : '0';
}

function getColor($money){
	if (100000 <= $money)
	{
		return '#FE98A7';
	}else if (10000 <= $money){
		return '#FFCAD2';
	}else if (1000 <= $money){
		return '#FFDFE7';
	}else if (10 <= $money){
		return '#FFF0F2';
	}else{
		return '#FFFFFF';
	}
}

function getAC($num)
{
	return 0 < $num ? 'style="color:#FF0000;"' : '';
}
?>