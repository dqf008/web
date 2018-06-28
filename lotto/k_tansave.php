<?php if (!defined('PHPYOU'))
{
	exit('非法进入');
}
if ($_GET['class2'] == '')
{?> <script>alert('非法进入!');parent.leftFrame.location.href='index.php?action=k_tm';window.location.href='index.php?action=left';</script><?php exit();
}
switch ($_GET['class2'])
{
	case '特A': $XF = 11;
	$mumu = 0;
	$urlurl = 'index.php?action=k_tm&ids=特A';
	$numm = 66;
	break;
	case '特B': $XF = 11;
	$mumu = 58;
	$numm = 66;
	$urlurl = 'index.php?action=k_tm&ids=特B';
	break;
	case '正A': $XF = 15;
	$mumu = 464;
	$urlurl = 'index.php?action=k_zm&ids=正A';
	$numm = 58;
	break;
	case '正B': $XF = 15;
	$mumu = 517;
	$numm = 58;
	$urlurl = 'index.php?action=k_zm&ids=正B';
	break;
	case '正1特': $XF = 13;
	$mumu = 116;
	$urlurl = 'index.php?action=k_zt&ids=正1特';
	$numm = 60;
	break;
	case '正2特': $XF = 13;
	$mumu = 174;
	$urlurl = 'index.php?action=k_zt&ids=正2特';
	$numm = 60;
	break;
	case '正3特': $XF = 13;
	$mumu = 232;
	$urlurl = 'index.php?action=k_zt&ids=正3特';
	$numm = 60;
	break;
	case '正4特': $XF = 13;
	$mumu = 290;
	$urlurl = 'index.php?action=k_zt&ids=正4特';
	$numm = 60;
	break;
	case '正5特': $XF = 13;
	$mumu = 348;
	$urlurl = 'index.php?action=k_zt&ids=正5特';
	$numm = 60;
	break;
	case '正6特': $XF = 13;
	$mumu = 406;
	$urlurl = 'index.php?action=k_zt&ids=正6特';
	$numm = 60;
	break;
	case '正1-6': $XF = 13;
	$mumu = 570;
	$urlurl = 'index.php?action=k_zm6&ids=正1-6';
	$numm = 78;
	break;
	case '五行': $XF = 17;
	$mumu = 712;
	$urlurl = 'index.php?action=k_wx&ids=五行';
	$numm = 5;
	break;
	case '半波': $XF = 25;
	$mumu = 661;
	$urlurl = 'index.php?action=k_bb&ids=半波';
	$numm = 18;
	break;
	case '半半波': $XF = 25;
	$mumu = 751;
	$urlurl = 'index.php?action=k_bbb&ids=半半波';
	$numm = 12;
	break;
	case '正肖': $XF = 25;
	$mumu = 782;
	$urlurl = 'index.php?action=k_qsb&ids=正肖';
	$numm = 12;
	break;
	case '七色波': $XF = 25;
	$mumu = 778;
	$urlurl = 'index.php?action=k_qsb&ids=正肖';
	$numm = 4;
	break;
	case '尾数': $XF = 27;
	$mumu = 689;
	$urlurl = 'index.php?action=k_ws&ids=尾数';
	$numm = 79;
	break;
	case '特肖': $XF = 23;
	$mumu = 673;
	$urlurl = 'index.php?action=k_sx&ids=特肖';
	$numm = 12;
	break;
	case '一肖': $XF = 23;
	$mumu = 699;
	$urlurl = 'index.php?action=k_sxp&ids=一肖';
	$numm = 12;
	break;
	case '正特尾数': $XF = 23;
	$mumu = 768;
	$urlurl = 'index.php?action=k_sxp&ids=一肖';
	$numm = 12;
	break;
	case '过关': $XF = 19;
	break;
	case '连码': $XF = 21;
	break;
	default: $mumu = 0;
	$numm = 58;
	$urlurl = 'index.php?action=k_tm&ids=特A';
	$XF = 11;
	break;
}?> <LINK rel=stylesheet type=text/css href="imgs/left.css"> 
  <link href="../css/bcss.css" rel="stylesheet" type="text/css" /><LINK  
  rel=stylesheet type=text/css href="imgs/ball1x.css"><LINK  
  rel=stylesheet type=text/css href="imgs/loto_lb.css"> 
  <style type="text/css"> 
  <!-- 
  body,td,th { 
	  font-size: 9pt;
  } 
  .STYLE3 {color: #FFFFFF} 
  .STYLE4 {color: #000} 
  .STYLE2 {} 
  --> 
  </style></HEAD> 
  <SCRIPT language=JAVASCRIPT> 
      if(self == top) {location = '/';}  
      if(window.location.host!=top.location.host){top.location=window.location;}  
  </SCRIPT> 
  <SCRIPT language=javascript> 
      window.setTimeout("self.location='index.php?action=left'", 30000);
  </SCRIPT> 
  <SCRIPT language=JAVASCRIPT> 
  if(self == top){location = '/';} 
  function ChkSubmit(){ 
      //设定『确定』键为反白  
      document.all.btnSubmit.disabled = true;
      document.form1.submit();
  }  
  </SCRIPT> 
  <noscript> 
      <iframe scr=″*.htm″></iframe> 
  </noscript> 
  <table height="3" cellspacing="0" cellpadding="0" border="0" width="180"> 
      <tbody> 
          <tr> 
              <td> 
              </td> 
          </tr> 
      </tbody> 
  </table><?php if (($Current_KitheTable[29] == 0) || ($Current_KitheTable[$XF] == 0))
{?> <table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=cb4619><font color=ffff00>封盘中....<input class=button_a onClick="self.location='index.php?action=left'" type="button" value="离开" name="btnCancel" /></font></td>          </tr>      </table><?php exit();
}?> <TABLE class=Tab_backdrop cellSpacing=0 cellPadding=0 width=180 border=0> 
      <tr> 
          <td valign="top" class="Left_Place"> 
              <TABLE class=t_list cellSpacing=1 cellPadding=0 width=180 border=0> 
                  <tr> 
                      <td height="28" colspan="3" align="center" bordercolor="#cccccc" bgcolor="#142F06" style="LINE-HEIGHT: 23px"><span class="STYLE3">下注成功</span></td> 
                  </tr> 
                  <tr> 
                      <td height="22" align="center"class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">内容</span></td> 
                      <td align="center" class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">赔率</span></td> 
                      <td align="center" class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">金额</span></td> 
                  </tr><?php $sum_sum = 0;
$r = 0;
for (;$r <= $numm;$r++)
{
	if ($_POST['Num_' . $r] != '')
	{
		$sum_sum = $sum_sum + $_POST['Num_' . $r];
	}
	if (ka_memuser('ts') < $sum_sum)
	{?> <script Language=Javascript>alert('对不起，下注总额不能大于可用信用额');parent.leftFrame.location.href='<?=$urlurl ;?>';window.location.href='index.php?action=left';</script><?php exit();
	}
}
$r = 0;
for (;$r <= $numm;$r++)
{
	if ($_POST['Num_' . $r] != '')
	{
		$sum_sum = $sum_sum + $_POST['Num_' . $r];
		if (($r == 59) || ($r == 60))
		{
			if ($_POST['class2'] == '特A')
			{
				$rate_id = $r + 687;
			}
			else
			{
				switch ($_GET['class2'])
				{
					case '正1特': $rate_id = $r + 975;
					break;
					case '正2特': $rate_id = $r + 1023;
					if ($r == 59)
					{
						$rate_id = $r + 986;
					}
					break;
					case '正3特': $rate_id = $r + 1024;
					if ($r == 59)
					{
						$rate_id = $r + 985;
					}
					break;
					case '正4特': $rate_id = $r + 1025;
					if ($r == 59)
					{
						$rate_id = $r + 984;
					}
					break;
					case '正5特': $rate_id = $r + 1026;
					if ($r == 59)
					{
						$rate_id = $r + 983;
					}
					break;
					case '正6特': $rate_id = $r + 1027;
					if ($r == 59)
					{
						$rate_id = $r + 982;
					}
					break;
					default: $rate_id = $r + 689;
				}
			}
		}
		else if (($_GET['class2'] == '半波') && (13 <= $r))
		{
			$rate_id = $r + 705;
		}
		else
		{
			$rate_id = $r + $mumu;
		}
		if ($r == 61)
		{
			if ($_GET['class2'] == '特A')
			{
				$rate_id = 795;
			}
			else
			{
				$rate_id = 801;
			}
		}
		else if ($r == 62)
		{
			if ($_GET['class2'] == '特A')
			{
				$rate_id = 796;
			}
			else
			{
				$rate_id = 802;
			}
		}
		else if ($r == 63)
		{
			if ($_GET['class2'] == '特A')
			{
				$rate_id = 797;
			}
			else
			{
				$rate_id = 803;
			}
		}
		else if ($r == 64)
		{
			if ($_GET['class2'] == '特A')
			{
				$rate_id = 798;
			}
			else
			{
				$rate_id = 804;
			}
		}
		else if ($r == 65)
		{
			if ($_GET['class2'] == '特A')
			{
				$rate_id = 799;
			}
			else
			{
				$rate_id = 805;
			}
		}
		else if ($r == 66)
		{
			if ($_GET['class2'] == '特A')
			{
				$rate_id = 800;
			}
			else
			{
				$rate_id = 806;
			}
		}
		if ($_GET['class2'] == '正1-6')
		{
			if ((1 <= $r) && ($r <= 7))
			{
				$rate_id = $r + $mumu;
			}
			else if ((14 <= $r) && ($r <= 20))
			{
				$rate_id = ($r - 6) + $mumu;
			}
			else if ((27 <= $r) && ($r <= 33))
			{
				$rate_id = ($r - 12) + $mumu;
			}
			else if ((40 <= $r) && ($r <= 46))
			{
				$rate_id = ($r - 18) + $mumu;
			}
			else if ((53 <= $r) && ($r <= 59))
			{
				$rate_id = ($r - 24) + $mumu;
			}
			else if ((66 <= $r) && ($r <= 72))
			{
				$rate_id = ($r - 30) + $mumu;
			}
			else if ((8 <= $r) && ($r <= 13))
			{
				$rate_id = $r + 1039;
			}
			else if ((21 <= $r) && ($r <= 26))
			{
				$rate_id = ($r - 7) + 1039;
			}
			else if ((34 <= $r) && ($r <= 39))
			{
				$rate_id = ($r - 14) + 1039;
			}
			else if ((47 <= $r) && ($r <= 52))
			{
				$rate_id = ($r - 21) + 1039;
			}
			else if ((60 <= $r) && ($r <= 65))
			{
				$rate_id = ($r - 28) + 1039;
			}
			else if ((73 <= $r) && ($r <= 78))
			{
				$rate_id = ($r - 35) + 1039;
			}
		}
		$ka_bl_row = ka_bl_row($rate_id);
		switch ($ka_bl_row['class1'])
		{
			case '特码': switch ($ka_bl_row['class3'])
			{
				case '单': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 2;
				$drop_sort = '单双';
				break;
				case '双': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 2;
				$drop_sort = '单双';
				break;
				case '家禽': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 24;
				$drop_sort = '家禽野兽';
				break;
				case '野兽': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 24;
				$drop_sort = '家禽野兽';
				break;
				case '尾大': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 33;
				$drop_sort = '尾大尾小';
				break;
				case '尾小': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 33;
				$drop_sort = '尾大尾小';
				break;
				case '大单': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 34;
				$drop_sort = '大单小单';
				break;
				case '小单': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 34;
				$drop_sort = '大单小单';
				break;
				case '大双': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 35;
				$drop_sort = '大双小双';
				break;
				case '小双': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 35;
				$drop_sort = '大双小双';
				break;
				case '大': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 3;
				$drop_sort = '大小';
				break;
				case '小': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 3;
				$drop_sort = '大小';
				break;
				case '合单': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 4;
				$drop_sort = '合数单双 ';
				break;
				case '合双': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 4;
				$drop_sort = '合数单双 ';
				break;
				case '红波': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 10;
				$drop_sort = '波色';
				break;
				case '绿波': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 10;
				$drop_sort = '波色';
				break;
				case '蓝波': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				$R = 10;
				$drop_sort = '波色';
				break;
				default: $bmmm = $btm;
				$cmmm = $ctm;
				$dmmm = $dtm;
				if ($ka_bl_row['class2'] == '特A')
				{
					$R = 0;
				}
				else
				{
					$R = 1;
				}
				$drop_sort = '特码';
				break;
			}
			break;
			case '正码': switch ($ka_bl_row['class3'])
			{
				case '总单': $R = 8;
				$drop_sort = '总数单双';
				$bmmm = $bzmdx;
				$cmmm = $czmdx;
				$dmmm = $dzmdx;
				break;
				case '总双': $R = 8;
				$drop_sort = '总数单双';
				$bmmm = $bzmdx;
				$cmmm = $czmdx;
				$dmmm = $dzmdx;
				break;
				case '总大': $R = 9;
				$drop_sort = '总数大小';
				$bmmm = $bzmdx;
				$cmmm = $czmdx;
				$dmmm = $dzmdx;
				break;
				case '总小': $R = 9;
				$drop_sort = '总数大小';
				$bmmm = $bzmdx;
				$cmmm = $czmdx;
				$dmmm = $dzmdx;
				break;
				default: if ($ka_bl_row['class2'] == '正A')
				{
					$R = 6;
				}
				else
				{
					$R = 7;
				}
				$drop_sort = '正码';
				$bmmm = $bzm;
				$cmmm = $czm;
				$dmmm = $dzm;
				break;
			}
			break;
			case '五行': $R = 25;
			$drop_sort = '五行';
			$bmmm = $bzm6;
			$cmmm = $czm6;
			$dmmm = $dzm6;
			break;
			case '生肖': switch ($ka_bl_row['class2'])
			{
				case '特肖': $bmmm = $bsx;
				$cmmm = $csx;
				$dmmm = $dsx;
				$R = 18;
				$drop_sort = '特肖';
				break;
				case '四肖': $bmmm = 0;
				$cmmm = 0;
				$dmmm = 0;
				$R = 19;
				$drop_sort = '四肖';
				break;
				case '五肖': $bmmm = 0;
				$cmmm = 0;
				$dmmm = 0;
				$R = 20;
				$drop_sort = '五肖';
				break;
				case '六肖': $bmmm = $bsx6;
				$cmmm = $csx6;
				$dmmm = $dsx6;
				$R = 21;
				$drop_sort = '六肖';
				break;
				case '一肖': $bmmm = $bsxp;
				$cmmm = $csxp;
				$dmmm = $dsxp;
				$R = 22;
				$drop_sort = '一肖';
				break;
				case '正特尾数': $bmmm = $bsxp;
				$cmmm = $csxp;
				$dmmm = $dsxp;
				$R = 30;
				$drop_sort = '正特尾数';
				break;
				default: $R = 18;
				$drop_sort = '特肖';
				$bmmm = $bsxp;
				$cmmm = $csxp;
				$dmmm = $dsxp;
				break;
			}
			break;
			case '半波': $bmmm = $bbb;
			$cmmm = $cbb;
			$dmmm = $dbb;
			$R = 11;
			$drop_sort = '半波';
			break;
			case '半半波': $bmmm = $bbb;
			$cmmm = $cbb;
			$dmmm = $dbb;
			$R = 28;
			$drop_sort = '半半波';
			case '正肖': $bmmm = $bbb;
			$cmmm = $cbb;
			$dmmm = $dbb;
			$R = 32;
			$drop_sort = '正肖';
			case '七色波': $bmmm = $bbb;
			$cmmm = $cbb;
			$dmmm = $dbb;
			$R = 31;
			$drop_sort = '七色波';
			break;
			case '正特': switch ($ka_bl_row['class3'])
			{
				case '单': $R = 2;
				$drop_sort = '单双';
				$bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '双': $R = 2;
				$drop_sort = '单双';
				$bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '大': $R = 3;
				$drop_sort = '大小';
				$bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '小': $R = 3;
				$drop_sort = '大小';
				$bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '合单': $R = 4;
				$drop_sort = '合数单双 ';
				$bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '合双': $R = 4;
				$drop_sort = '合数单双 ';
				$bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '红波': $R = 10;
				$drop_sort = '波色';
				$bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '绿波': $R = 10;
				$drop_sort = '波色';
				$bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '蓝波': $R = 10;
				$drop_sort = '波色';
				$bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				default: $R = 5;
				$drop_sort = '正特';
				$bmmm = $bzt;
				$cmmm = $czt;
				$dmmm = $dzt;
				break;
			}
			break;
			case '尾数': $R = 23;
			$drop_sort = '尾数';
			$bmmm = 0;
			$cmmm = 0;
			$dmmm = 0;
			break;
			case '正1-6': $R = 47;
			$drop_sort = '正1-6';
			$bmmm = 0;
			$cmmm = 0;
			$dmmm = 0;
			break;
			default: $R = 23;
			$drop_sort = '尾数';
			$bmmm = 0;
			$cmmm = 0;
			$dmmm = 0;
			break;
		}
		if (($ka_bl_row['class1'] == '特码') && ($r <= 49))
		{
			$params = array(':Kithe' => $Current_Kithe_Num, ':class1' => $ka_bl_row['class1'], ':class2' => $ka_bl_row['class2'], ':class3' => $ka_bl_row['class3']);
			$stmt = $mydata2_db->prepare("\r\n" . '                                        Select SUM(sum_m) As sum_m55 from ka_tan' . "\r\n" . '                                        where Kithe=:Kithe' . "\r\n" . '                                        and class1=:class1' . "\r\n" . '                                        and class2=:class2' . "\r\n" . '                                        and class3=:class3');
			$stmt->execute($params);
			$sum_m55 = $stmt->fetchColumn();
			if ($sum_m55 == '')
			{
				$sum_m55 = 0;
			}
			if (($ka_bl_row['xr'] < ($sum_m55 + $_POST['Num_' . $r])) || ($ka_bl_row['locked'] == 1))
			{?> <script Language=Javascript>alert('对不起，[<?=$ka_bl_row['class3'] ;?>号]暂停下注.请反回重新选择!');parent.leftFrame.location.href='<?=$urlurl ;?>';window.location.href='index.php?action=left';</script><?php exit();
			}
		}
		$params = array(':Kithe' => $Current_Kithe_Num, ':class1' => $ka_bl_row['class1'], ':class2' => $ka_bl_row['class2'], ':class3' => $ka_bl_row['class3'], ':username' => $_SESSION['username']);
		$stmt = $mydata2_db->prepare("\r\n" . '                                    Select SUM(sum_m) As sum_m from ka_tan' . "\r\n" . '                                    where Kithe=:Kithe' . "\r\n" . '                                    and class1=:class1' . "\r\n" . '                                    and class2=:class2' . "\r\n" . '                                    and class3=:class3' . "\r\n" . '                                    and username=:username');
		$stmt->execute($params);
		$rs5_sum_m = $stmt->fetchColumn();
		if (ka_memds($R, 3) < ($rs5_sum_m + $_POST['Num_' . $r]))
		{?> <script Language=Javascript>alert('对不起，[<?=$ka_bl_row['class3'] ;?>]超过单项限额.请反回重新下注!');parent.leftFrame.location.href='<?=$urlurl ;?>';window.location.href='index.php?action=left';</script><?php exit();
		}
		if ($ka_bl_row['locked'] == 1)
		{?> <script Language=Javascript>alert('对不起，[<?=$ka_bl_row['class3'] ;?>号]暂停下注.请反回重新选择!');parent.leftFrame.location.href='<?=$urlurl ;?>';window.location.href='index.php?action=left';</script><?php exit();
		}
		$rate5 = $ka_bl_row['rate'];
		$Y = 1;
		$num = randStr();
		$text = date('Y-m-d H:i:s');
		$class11 = $ka_bl_row['class1'];
		$class22 = $ka_bl_row['class2'];
		$class33 = $ka_bl_row['class3'];
		$sum_m = $_POST['Num_' . $r];
		$user_ds = ka_memds($R, 1);
		$dai_ds = 0;
		$zong_ds = 0;
		$guan_ds = 0;
		$dai_zc = 0;
		$zong_zc = 0;
		$guan_zc = 0;
		$dagu_zc = 0;
		$dai = 'daili';
		$zong = 'zong';
		$guan = 'guan';
		$danid = 3;
		$zongid = 2;
		$guanid = 1;
		$memid = ka_memuser('id');
		if ((0 < $sum_m) && $_SESSION['username'])
		{
			$params = array(':uid' => $_SESSION['uid'], ':money' => $sum_m, ':money2' => $sum_m);
			$stmt = $mydata1_db->prepare('update k_user set money=money-:money where uid=:uid and money>=:money2');
			$stmt->execute($params);
			$q0 = $stmt->rowCount();
			if ($q0 == 1)
			{
				$params = array(':num' => $num, ':username' => $_SESSION['username'], ':kithe' => $Current_Kithe_Num, ':adddate' => $text, ':class1' => $class11, ':class2' => $class22, ':class3' => $class33, ':rate' => $rate5, ':sum_m' => $sum_m, ':user_ds' => $user_ds, ':dai_ds' => $dai_ds, ':zong_ds' => $zong_ds, ':guan_ds' => $guan_ds, ':dai_zc' => $dai_zc, ':zong_zc' => $zong_zc, ':guan_zc' => $guan_zc, ':dagu_zc' => $dagu_zc, ':bm' => 0, ':dai' => $dai, ':zong' => $zong, ':guan' => $guan, ':memid' => $memid, ':danid' => $danid, ':zongid' => $zongid, ':guanid' => $guanid, ':abcd' => 'A', ':lx' => 0);
				$stmt = $mydata2_db->prepare('INSERT INTO ka_tan set ' . "\r\n" . '                                        num=:num,' . "\r\n" . '                                        username=:username,' . "\r\n" . '                                        kithe=:kithe,' . "\r\n" . '                                        adddate=:adddate,' . "\r\n" . '                                        class1=:class1,' . "\r\n" . '                                        class2=:class2,' . "\r\n" . '                                        class3=:class3,' . "\r\n" . '                                        rate=:rate,' . "\r\n" . '                                        sum_m=:sum_m,' . "\r\n" . '                                        user_ds=:user_ds,' . "\r\n" . '                                        dai_ds=:dai_ds,' . "\r\n" . '                                        zong_ds=:zong_ds,' . "\r\n" . '                                        guan_ds=:guan_ds,' . "\r\n" . '                                        dai_zc=:dai_zc,' . "\r\n" . '                                        zong_zc=:zong_zc,' . "\r\n" . '                                        guan_zc=:guan_zc,' . "\r\n" . '                                        dagu_zc=:dagu_zc,' . "\r\n" . '                                        bm=:bm,' . "\r\n" . '                                        dai=:dai,' . "\r\n" . '                                        zong=:zong,' . "\r\n" . '                                        guan=:guan,' . "\r\n" . '                                        memid=:memid,' . "\r\n" . '                                        danid=:danid,' . "\r\n" . '                                        zongid=:zongid,' . "\r\n" . '                                        guanid=:guanid,' . "\r\n" . '                                        abcd=:abcd,' . "\r\n" . '                                        lx=:lx');
				$stmt->execute($params);
				$params = array(':num' => $num, ':sum_m' => $sum_m, ':sum_m2' => $sum_m, ':creationTime' => date('Y-m-d H:i:s', time() - (12 * 3600)), ':username' => $_SESSION['username']);
				$stmt = $mydata1_db->prepare('INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)' . "\r\n" . '                                        SELECT uid,username,\'SIX\',\'BET\',:num,-:sum_m,money+:sum_m2,money,:creationTime FROM k_user WHERE username=:username');
				$stmt->execute($params);
			}
			else
			{?> <script Language=Javascript>alert('下注失败!');parent.leftFrame.location.href='<?=$urlurl ;?>';window.location.href='index.php?action=left';</script><?php exit();
			}
			include 'ds.php';?>                <tr> 
                      <td height="22" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><font color="#FF0000"><?=$class22;?>：<font color=ff6600><?=$class33;?></font></font></td> 
                      <td align="center" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><?=$rate5;?></td> 
                      <td align="center" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><?=$sum_m;?></td> 
                  </tr><?php }
	}
}?>                 <tr> 
                      <td height="22" colspan="3" align="center" bordercolor="#cccccc" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="离开" name="btnCancel" />&nbsp;&nbsp;<?php if (($_GET['class2'] == '特A') || ($_GET['class2'] == '特B'))
{?>                         <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=n55&class2=<?=$_GET['class2'];?>'" type="button" value="快速" name="btnCancel" /> 
                      &nbsp;&nbsp;<?php }?>                         &nbsp;&nbsp;<input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="下注成功" name="btnCancel" /> 
                      </td> 
                  </tr> 
              </table> 
          </td> 
      </tr> 
      <tr> 
          <td height="30" align="center">&nbsp;</td> 
      </tr> 
  </form> 
  </table><?php if ($urlurl != '')
{
}?> </BODY> 
  </HTML><?php function ka_memdaids($i, $b)
{
	$dai = ka_memuser('dan');
	global $mydata2_db;
	$params = array(':username' => $dai);
	$stmt = $mydata2_db->prepare('Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username=:username order by id');
	$stmt->execute($params);
	$drop_guands = array();
	$y = 0;
	while ($image = $stmt->fetch())
	{
		$y++;
		array_push($drop_guands, $image);
	}
	return $drop_guands[$i][$b] == '' ? 0 : $drop_guands[$i][$b];
}
function ka_memzongds($i, $b)
{
	$zong = ka_memuser('zong');
	global $mydata2_db;
	$params = array(':username' => $zong);
	$stmt = $mydata2_db->prepare('Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username=:username order by id');
	$stmt->execute($params);
	$drop_guands = array();
	$y = 0;
	while ($image = $stmt->fetch())
	{
		$y++;
		array_push($drop_guands, $image);
	}
	return $drop_guands[$i][$b] == '' ? 0 : $drop_guands[$i][$b];
}
function ka_memguands($i, $b)
{
	$guan = ka_memuser('guan');
	global $mydata2_db;
	$params = array(':username' => $guan);
	$stmt = $mydata2_db->prepare('Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username=:username order by id');
	$stmt->execute($params);
	$drop_guands = array();
	$y = 0;
	while ($image = $stmt->fetch())
	{
		$y++;
		array_push($drop_guands, $image);
	}
	return $drop_guands[$i][$b] == '' ? 0 : $drop_guands[$i][$b];
}?>