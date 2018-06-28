<?php 
function cutTitle($title, $length = 3){
	$tmpstr = '';
	mb_internal_encoding('UTF-8');
	if (mb_strlen($title) <= $length)
	{
		return $title;
	}
	else
	{
		$tmpstr = mb_substr($title, 0, $length);
		while ($length <= mb_strlen($title))
		{
			$tmpstr .= '*';
			$length++;
		}
		return $tmpstr;
	}
}

function cutNum($title, $s = 4, $e = 4){
	mb_internal_encoding('UTF-8');
	$tmpstr = mb_substr($title, 0, $s);
	
	for ($i = 0;$i < (mb_strlen($title) - $s - $e);$i++)
	{
		$tmpstr .= '*';
	}
	return $tmpstr . mb_substr($title, mb_strlen($title) - $e);
}

function mtypeName($m_type){
	$mtypename = '';
	switch ($m_type)
	{
		case 3: $mtypename = '人工汇款';
		break;
		case 4: $mtypename = '彩金派送';
		break;
		case 5: $mtypename = '反水派送';
		break;
		case 6: $mtypename = '其他情况';
		break;
		default: $mtypename = '';
		break;
	}
	return $mtypename;
}

function zzTypeName($zz_type){
	$zz_typename = '';
	switch ($zz_type){
		case 'd': $zz_typename = '体育/彩票 → AG真人';
		break;
		case 'w': $zz_typename = 'AG真人 → 体育/彩票';
		break;
		case '5': $zz_typename = '体育/彩票 → HG真人';
		break;
		case '7': $zz_typename = 'HG真人 → 体育/彩票';
		break;
		case '9': $zz_typename = '体育/彩票 → BBIN真人';
		break;
		case '11': $zz_typename = 'BBIN真人 → 体育/彩票';
		break;
		case '13': $zz_typename = '体育/彩票 → MG真人';
		break;
		case '15': $zz_typename = 'MG真人 → 体育/彩票';
		break;
		case '17': $zz_typename = '体育/彩票 → DS真人';
		break;
		case '19': $zz_typename = 'DS真人 → 体育/彩票';
		break;
		default: $zz_typename = '';
		break;
	}
	return $zz_typename;
}
?>