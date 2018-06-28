<?php function Ssc_Auto($num, $type)
{
	$zh = $num[0] + $num[1];
	if ($type == 1)
	{
		return $zh;
	}
	if ($type == 2)
	{
		if (11 < $zh)
		{
			return '大';
		}elseif($zh==11){
			return '和';	
		}
		else
		{
			return '小';
		}
	}
	if ($type == 3)
	{
		if ($zh % 2 == 0)
		{
			return '双';
		}
		else
		{
			return '单';
		}
	}
	if ($type == 4)
	{
		if ($num[9] < $num[0])
		{
			return '龙';
		}
		else
		{
			return '虎';
		}
	}
	if ($type == 5)
	{
		if ($num[8] < $num[1])
		{
			return '龙';
		}
		else
		{
			return '虎';
		}
	}
	if ($type == 6)
	{
		if ($num[7] < $num[2])
		{
			return '龙';
		}
		else
		{
			return '虎';
		}
	}
	if ($type == 7)
	{
		if ($num[6] < $num[3])
		{
			return '龙';
		}
		else
		{
			return '虎';
		}
	}
	if ($type == 8)
	{
		if ($num[5] < $num[4])
		{
			return '龙';
		}
		else
		{
			return '虎';
		}
	}
}?>