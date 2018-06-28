<?php 
class zcnuv
{
	private $_SMDay = array(1 => 31, 2 => 28, 3 => 31, 4 => 30, 5 => 31, 6 => 30, 7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31);
	private $_LStart = 1950;
	private $_LMDay = array( 
		array(47, 29, 30, 30, 29, 30, 30, 29, 29, 30, 29, 30, 29), 
		array(36, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30), 
		array(6, 29, 30, 29, 30, 59, 29, 30, 30, 29, 30, 29, 30, 29), 
		array(44, 29, 30, 29, 29, 30, 30, 29, 30, 30, 29, 30, 29), 
		array(33, 30, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30), 
		array(23, 29, 30, 59, 29, 29, 30, 29, 30, 29, 30, 30, 30, 29), 
		array(42, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30), 
		array(30, 30, 29, 30, 29, 30, 29, 29, 59, 30, 29, 30, 29, 30), 
		array(48, 30, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30), 
		array(38, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29), 
		array(27, 30, 29, 30, 29, 30, 59, 30, 29, 30, 29, 30, 29, 30), 
		array(45, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30), 
		array(35, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29), 
		array(24, 30, 29, 30, 58, 30, 29, 30, 29, 30, 30, 30, 29, 29), 
		array(43, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 30), 
		array(32, 29, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29), 
		array(20, 30, 30, 59, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30), 
		array(39, 30, 30, 29, 30, 30, 29, 29, 30, 29, 30, 29, 30), 
		array(29, 29, 30, 29, 30, 30, 29, 59, 30, 29, 30, 29, 30, 30), 
		array(47, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29), 
		array(36, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30), 
		array(26, 29, 30, 29, 29, 59, 30, 29, 30, 30, 30, 29, 30, 30), 
		array(45, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30), 
		array(33, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30), 
		array(22, 30, 30, 29, 59, 29, 30, 29, 29, 30, 30, 29, 30, 30), 
		array(41, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30), 
		array(30, 30, 30, 29, 30, 29, 30, 29, 59, 29, 30, 29, 30, 30), 
		array(48, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 29), 
		array(37, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 29), 
		array(27, 30, 29, 29, 30, 29, 60, 29, 30, 30, 29, 30, 29, 30), 
		array(46, 30, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30), 
		array(35, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30), 
		array(24, 30, 29, 30, 58, 30, 29, 29, 30, 29, 30, 30, 30, 29), 
		array(43, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30), 
		array(32, 30, 29, 30, 30, 29, 29, 30, 29, 29, 59, 30, 30, 30), 
		array(50, 29, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30), 
		array(39, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 29, 29), 
		array(28, 30, 29, 30, 29, 30, 59, 30, 30, 29, 30, 29, 29, 30), 
		array(47, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29), 
		array(36, 30, 29, 29, 30, 29, 30, 29, 30, 29, 30, 30, 30), 
		array(26, 29, 30, 29, 29, 59, 29, 30, 29, 30, 30, 30, 30, 30), 
		array(45, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30), 
		array(34, 29, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30), 
		array(22, 29, 30, 59, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30), 
		array(40, 30, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30), 
		array(30, 29, 30, 30, 29, 30, 29, 30, 59, 29, 30, 29, 30, 30), 
		array(49, 29, 30, 29, 30, 30, 29, 30, 29, 30, 30, 29, 29), 
		array(37, 30, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29), 
		array(27, 30, 29, 29, 30, 58, 30, 30, 29, 30, 30, 29, 30, 29), 
		array(46, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29), 
		array(35, 30, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 29), 
		array(23, 30, 30, 29, 59, 30, 29, 29, 30, 29, 30, 29, 30, 30), 
		array(42, 30, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29), 
		array(31, 30, 30, 29, 30, 30, 29, 30, 29, 29, 30, 29, 30), 
		array(21, 29, 59, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 30), 
		array(39, 29, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29), 
		array(28, 30, 29, 30, 29, 30, 29, 59, 30, 30, 29, 30, 30, 30), 
		array(48, 29, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29, 30), 
		array(37, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30), 
		array(25, 30, 30, 29, 29, 59, 29, 30, 29, 30, 29, 30, 30, 30), 
		array(44, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30), 
		array(33, 30, 29, 30, 30, 29, 30, 29, 29, 30, 29, 30, 29), 
		array(22, 30, 29, 30, 59, 30, 29, 30, 29, 30, 29, 30, 29, 30), 
		array(40, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30), 
		array(30, 29, 30, 29, 30, 29, 30, 29, 30, 59, 30, 29, 30, 30), 
		array(49, 29, 30, 29, 29, 30, 29, 30, 30, 30, 29, 30, 29), 
		array(38, 30, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30), 
		array(27, 29, 30, 29, 30, 29, 59, 29, 30, 29, 30, 30, 30, 29), 
		array(46, 29, 30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30), 
		array(35, 30, 29, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30), 
		array(24, 29, 30, 30, 59, 30, 29, 29, 30, 29, 30, 29, 30, 30), 
		array(42, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29), 
		array(31, 30, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30), 
		array(21, 29, 59, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30, 30), 
		array(40, 29, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29), 
		array(28, 30, 29, 30, 29, 29, 59, 30, 29, 30, 30, 30, 29, 30), 
		array(47, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 30, 29), 
		array(36, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29), 
		array(25, 30, 30, 30, 29, 59, 29, 30, 29, 29, 30, 30, 29, 30), 
		array(43, 30, 30, 29, 30, 29, 30, 29, 30, 29, 29, 30, 30), 
		array(33, 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29), 
		array(22, 29, 30, 59, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30), 
		array(41, 30, 29, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30), 
		array(30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 59, 30, 30), 
		array(49, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 29, 30), 
		array(38, 30, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30), 
		array(27, 30, 30, 29, 30, 29, 59, 29, 29, 30, 29, 30, 30, 29), 
		array(45, 30, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30), 
		array(34, 30, 30, 29, 30, 29, 30, 29, 30, 29, 29, 30, 29), 
		array(23, 30, 30, 29, 30, 59, 30, 29, 30, 29, 30, 29, 29, 30), 
		array(42, 30, 29, 30, 30, 29, 30, 29, 30, 30, 29, 30, 29), 
		array(31, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30), 
		array(21, 29, 59, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 30), 
		array(40, 29, 30, 29, 29, 30, 29, 29, 30, 30, 29, 30, 30), 
		array(29, 30, 29, 30, 29, 29, 30, 58, 30, 29, 30, 30, 30, 29), 
		array(47, 30, 29, 30, 29, 29, 30, 29, 29, 30, 29, 30, 30), 
		array(36, 30, 29, 30, 29, 30, 29, 30, 29, 29, 30, 29, 30), 
		array(25, 30, 29, 30, 30, 59, 29, 30, 29, 29, 30, 29, 30, 29), 
		array(44, 29, 30, 30, 29, 30, 30, 29, 30, 29, 29, 30, 29), 
		array(32, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29), 
		array(22, 29, 30, 59, 29, 30, 29, 30, 30, 29, 30, 30, 29, 29) 
	);
	
	private function IsLeapYear($AYear)
	{
		return ($AYear % 4 == 0) && (($AYear % 100 != 0) || ($AYear % 400 == 0));
	}
	private function GetSMon($year, $month)
	{
		if ($this->IsLeapYear($year) && ($month == 2))
		{
			return 29;
		}
		else
		{
			return $this->_SMDay[$month];
		}
	}
	private function LYearName($year)
	{
		$Name = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
		$i = 0;
		for (;$i < 4;$i++)
		{
			$k = 0;
			for (;$k < 10;$k++)
			{
				if ($year[$i] == $k)
				{
					$tmp .= $Name[$k];
				}
			}
		}
		return $tmp;
	}
	private function LMonName($month)
	{
		if ((1 <= $month) && ($month <= 12))
		{
			$Name = array(1 => '正', 0 => '二', 1 => '三', 2 => '四', 3 => '五', 4 => '六', 5 => '七', 6 => '八', 7 => '九', 8 => '十', 9 => '十一', 10 => '十二');
			return $Name[$month];
		}
		return $month;
	}
	private function LDayName($day)
	{
		if ((1 <= $day) && ($day <= 30))
		{
			$Name = array(1 => '初一', 0 => '初二', 1 => '初三', 2 => '初四', 3 => '初五', 4 => '初六', 5 => '初七', 6 => '初八', 7 => '初九', 8 => '初十', 9 => '十一', 10 => '十二', 11 => '十三', 12 => '十四', 13 => '十五', 14 => '十六', 15 => '十七', 16 => '十八', 17 => '十九', 18 => '二十', 19 => '廿一', 20 => '廿二', 21 => '廿三', 22 => '廿四', 23 => '廿五', 24 => '廿六', 25 => '廿七', 26 => '廿八', 27 => '廿九', 28 => '三十');
			return $Name[$day];
		}
		return $day;
	}
	public function S2L($date)
	{
		list($year, $month, $day) = explode('-', $date);
		if (($year <= 1951) || ($month <= 0) || ($day <= 0) || (2051 <= $year))
		{
			return false;
		}
		$date1 = strtotime($year . '-01-01');
		$date2 = strtotime($year . '-' . $month . '-' . $day);
		$days = round(($date2 - $date1) / 3600 / 24);
		$days += 1;
		$Larray = $this->_LMDay[$year - $this->_LStart];
		if ($days <= $Larray[0])
		{
			$Lyear = $year - 1;
			$days = $Larray[0] - $days;
			$Larray = $this->_LMDay[$Lyear - $this->_LStart];
			if ($days < $Larray[12])
			{
				$Lmonth = 12;
				$Lday = $Larray[12] - $days;
			}else{
				$Lmonth = 11;
				$days = $days - $Larray[12];
				$Lday = $Larray[11] - $days;
			}
		}else{
			$Lyear = $year;
			$days = $days - $Larray[0];
			$i = 1;
			for (;$i <= 12;$i++)
			{
				if ($Larray[$i] < $days)
				{
					$days = $days - $Larray[$i];
				}else{
					if (30 < $days)
					{
						$days = $days - $Larray[13];
						$Ltype = 1;
					}
					$Lmonth = $i;
					$Lday = $days;
					break;
				}
			}
		}
		return mktime(0, 0, 0, $Lmonth, $Lday, $Lyear);
	}
	
	public function L2S($date, $type = 0)
	{
		list($year, $month, $day) = split('-', $date);
		if (($year <= 1951) || ($month <= 0) || ($day <= 0) || (2051 <= $year))
		{
			return false;
		}
		$Larray = $this->_LMDay[$year - $this->_LStart];
		if (($type == 1) && (count($Larray) <= 12))
		{
			return false;
		}
		if ((30 < $Larray[$month]) && ($type == 1) && (13 <= count($Larray)))
		{
			$day = $Larray[13] + $day;
		}
		$days = $day;
		$i = 0;
		for (;$i <= $month - 1;$i++)
		{
			$days += $Larray[$i];
		}
		if ((366 < $days) || (($this->GetSMon($month, 2) != 29) && (365 < $days)))
		{
			$Syear = $year + 1;
			if ($this->GetSMon($month, 2) != 29)
			{
				$days -= 366;
			}else{
				$days -= 365;
			}
			
			if ($this->_SMDay[1] < $days)
			{
				$Smonth = 2;
				$Sday = $days - $this->_SMDay[1];
			}else{
				$Smonth = 1;
				$Sday = $days;
			}
		}else{
			$Syear = $year;
			$i = 1;
			for (;$i <= 12;$i++)
			{
				if ($this->GetSMon($Syear, $i) < $days)
				{
					$days -= $this->GetSMon($Syear, $i);
				}else{
					$Smonth = $i;
					$Sday = $days;
					break;
				}
			}
		}
		return mktime(0, 0, 0, $Smonth, $Sday, $Syear);
	}
}
function Ssc_Auto($num, $type)
{
	$zh = $num[0] + $num[1] + $num[2] + $num[3] + $num[4];
	if ($type == 1)
	{
		return $zh;
	}
	if ($type == 2)
	{
		if (23 <= $zh)
		{
			return '大';
		}
		if ($zh <= 23)
		{
			return '小';
		}
	}
	if ($type == 3)
	{
		if ($zh % 2 == 0)
		{
			return '双';
		}else{
			return '单';
		}
	}
	if ($type == 4)
	{
		if ($num[4] < $num[0])
		{
			return '龙';
		}
		if ($num[0] < $num[4])
		{
			return '虎';
		}
		if ($num[0] == $num[4])
		{
			return '和';
		}
	}
	if ($type == 5)
	{
		$a = $num[0] . $num[1] . $num[2];
		$hm = array();
		$hm[] = $num[0];
		$hm[] = $num[1];
		$hm[] = $num[2];
		sort($hm);
		$match = '/.09|0.9/';
		if (($num[0] == $num[1]) && ($num[0] == $num[2]) && ($num[1] == $num[2]))
		{
			return '豹子';
		}else if (($num[0] == $num[1]) || ($num[0] == $num[2]) || ($num[1] == $num[2])){
			return '对子';
		}else if (($a == '019') || ($a == '091') || ($a == '098') || ($a == '089') || ($a == '109') || ($a == '190') || ($a == '901') || ($a == '910') || ($a == '809') || ($a == '890') || sorts($hm, 3)){
			return '顺子';
		}else if (preg_match($match, $a) || sorts($hm, 2)){
			return '半顺';
		}else{
			return '杂六';
		}
	}
	
	if ($type == 6){
		$a = $num[1] . $num[2] . $num[3];
		$hm = array();
		$hm[] = $num[1];
		$hm[] = $num[2];
		$hm[] = $num[3];
		sort($hm);
		$match = '/.09|0.9/';
		if (($num[1] == $num[2]) && ($num[1] == $num[3]) && ($num[2] == $num[3]))
		{
			return '豹子';
		}else if (($num[1] == $num[2]) || ($num[1] == $num[3]) || ($num[2] == $num[3])){
			return '对子';
		}else if (($a == '019') || ($a == '091') || ($a == '098') || ($a == '089') || ($a == '109') || ($a == '190') || ($a == '901') || ($a == '910') || ($a == '809') || ($a == '890') || sorts($hm, 3)){
			return '顺子';
		}else if (preg_match($match, $a) || sorts($hm, 2)){
			return '半顺';
		}else{
			return '杂六';
		}
	}
	
	if ($type == 7){
		$a = $num[2] . $num[3] . $num[4];
		$hm = array();
		$hm[] = $num[2];
		$hm[] = $num[3];
		$hm[] = $num[4];
		sort($hm);
		$match = '/.09|0.9/';
		if (($num[2] == $num[3]) && ($num[2] == $num[4]) && ($num[3] == $num[4]))
		{
			return '豹子';
		}else if (($num[2] == $num[3]) || ($num[2] == $num[4]) || ($num[3] == $num[4])){
			return '对子';
		}else if (($a == '019') || ($a == '091') || ($a == '098') || ($a == '089') || ($a == '109') || ($a == '190') || ($a == '901') || ($a == '910') || ($a == '809') || ($a == '890') || sorts($hm, 3)){
			return '顺子';
		}else if (preg_match($match, $a) || sorts($hm, 2)){
			return '半顺';
		}else{
			return '杂六';
		}
	}
}
function sorts($a, $p)
{
	$i = 0;
	foreach ($a as $k => $v)
	{
		if (in_array((($v + 10) - 1) % 10, $a) || in_array(($v + 1) % 10, $a)){
			$i++;
		}
	}
	if ($p <= $i)
	{
		$a = true;
	}else{
		$a = false;
	}
	return $a;
}
function BuLing($num)
{
	if ($num < 10)
	{
		return '0' . $num;
	}else{
		return $num;
	}
}
function Klsf_Auto($num, $type)
{
	$zh = $num[0] + $num[1] + $num[2] + $num[3] + $num[4] + $num[5] + $num[6] + $num[7];
	if ($type == 1)
	{
		return $zh;
	}
	if ($type == 2)
	{
		if (85 <= $zh)
		{
			return '大';
		}
		if ($zh <= 83)
		{
			return '小';
		}
		if ($zh == 84)
		{
			return '和';
		}
	}
	if ($type == 3)
	{
		if ($zh % 2 == 0)
		{
			return '双';
		}else{
			return '单';
		}
	}
	if ($type == 4)
	{
		if (5 <= $zh % 10)
		{
			return '尾大';
		}else{
			return '尾小';
		}
	}
	if ($type == 5)
	{
		if ($num[7] < $num[0])
		{
			return '龙';
		}
		if ($num[0] < $num[7])
		{
			return '虎';
		}
	}
}
function Klsf_Ds($ball)
{
	if ($ball % 2 == 0)
	{
		return '双';
	}else{
		return '单';
	}
}
function Klsf_Dx($ball)
{
	if (11 <= $ball)
	{
		return '大';
	}
	else
	{
		return '小';
	}
}
function Klsf_Wdx($ball)
{
	if (5 <= $ball % 10)
	{
		return '尾大';
	}
	else
	{
		return '尾小';
	}
}
function Klsf_Hdx($ball)
{
	if ((($ball % 10) + floor($ball / 10)) % 2 == 0)
	{
		return '合双';
	}
	else
	{
		return '合单';
	}
}
function Klsf_Zfb($ball)
{
	if ($ball <= 7)
	{
		return '中';
	}
	else if ((8 <= $ball) && ($ball <= 14))
	{
		return '发';
	}
	else
	{
		return '白';
	}
}
function Klsf_Dnxb($ball)
{
	if ($ball % 4 == 1)
	{
		return '东';
	}
	else if ($ball % 4 == 2)
	{
		return '南';
	}
	else if ($ball % 4 == 3)
	{
		return '西';
	}
	else
	{
		return '北';
	}
}
function Bjsc_Auto($num, $type)
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
}
function Xyft_Auto($num, $type)
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
}

?>