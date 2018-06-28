<?php 
if (!defined('PHPYOU')){
	exit('非法进入');
}
if ($_GET['class2'] == ''){
	echo "<script>alert('非法进入!');parent.leftFrame.location.href='index.php?action=k_tm';window.location.href='index.php?action=left';</script>";
	exit();
}
switch ($_GET['class2']){
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
	$numm = 10;
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
}
?> 
<LINK rel=stylesheet type=text/css href="imgs/left.css"> 
<link href="../css/bcss.css" rel="stylesheet" type="text/css" />
<LINK rel=stylesheet type=text/css href="imgs/ball1x.css">
<LINK rel=stylesheet type=text/css href="imgs/loto_lb.css"> 
  <style type="text/css"> 
  .STYLE3{ color:#fff} 
  </style> 
  </HEAD> 
  <SCRIPT language=JAVASCRIPT> 
      if(self == top) {location = '/';}  
      if(window.location.host!=top.location.host){top.location=window.location;}  
  </SCRIPT> 

  <SCRIPT language=javascript> 
      window.setTimeout("self.location='index.php?action=left'", 90000);
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
              <td></td> 
          </tr> 
      </tbody> 
  </table>
  <?
if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=cb4619><font color=ffff00>封盘中....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"离开\" name=\"btnCancel\" /></font></td>          </tr>      </table>"; 
  exit;
}


?>								     
  <TABLE border=0 cellSpacing=0 cellPadding=0 width=180 class="Tab_backdrop"> 
      <TBODY> 
          <TR> 
              <TD class=Left_Place height=400 vAlign=top align=left> 
                  <TABLE> 
                      <TBODY> 
                          <TR> 
                              <TD height=2></TD> 
                          </TR> 
                      </TBODY> 
                  </TABLE>    										     
                  <TABLE class=t_list cellSpacing=1 cellPadding=0 width=180 border=0> 
                  <form action="index.php?action=k_tansave&class2=<?=$_GET['class2'];?>" method="post" name="form1" id="form1" > 
                  <tr class="left_acc_out_top"> 
                      <td height="30" align="center"> 
                          <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1"> 
                              <tr> 
                                  <td height="25" colspan="4" align="center"  bgcolor="#142F06" style="LINE-HEIGHT: 23px"><span class="STYLE3">确认注单</span></td> 
                              </tr> 
                              <tr> 
                                  <td height="22" align="center"  class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">内容</span></td> 
                                  <td align="center"  class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">赔率</span></td> 
                                  <td align="center"  class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">金额</span></td> 
                              </tr>
<?php 
$sum_sum = 0;
$j = 0;

for ($r = 1;$r <= $numm;$r++){
	if ($r <= 9){
		$p = $r;
	}else{
		$p = $r;
	}
?>
<input name="Num_<?=$r?>" type="hidden" value="<?=$_POST['t'.$p]?>" />
<?php if ($_POST['t' . $p] != '')
	{
		$sum_sum = $sum_sum + $_POST['t' . $p];
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
				$rate_id = 780;
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
		if (($ka_bl_row['class1'] == '特码') && ($r <= 49))
		{
			$params = array(':Kithe' => $Current_Kithe_Num, ':class1' => $ka_bl_row['class1'], ':class2' => $ka_bl_row['class2'], ':class3' => $ka_bl_row['class3']);
			$stmt = $mydata2_db->prepare('Select SUM(sum_m) As sum_m55 from ka_tan where Kithe=:Kithe and class1=:class1 and class2=:class2 and class3=:class3');
			$stmt->execute($params);
			$sum_m55 = $stmt->fetchColumn();
			if ($sum_m55 == '')
			{
				$sum_m55 = 0;
			}
			if (($ka_bl_row['xr'] < ($sum_m55 + $_POST['Num_' . $r])) || ($ka_bl_row['locked'] == 1))
			{
				echo "<script Language=Javascript>alert('对不起，[".$ka_bl_row['class3']."号]暂停下注.请反回重新选择!');parent.leftFrame.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
				exit();
			}
		}
		if ($ka_bl_row['locked'] == 1)
		{
			echo "<script Language=Javascript>alert('对不起，[".$ka_bl_row['class3']."号]暂停下注.请反回重新选择!');parent.leftFrame.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
			exit();
		}
		$j++;
		?>                                
		<tr <?php if ($j % 2 == 1){?> class=left_acc_inner<?php }else{?> class=left_acc_inner2<?php }?>  > 
           <td height="22" class=left_acc_inner_con style="LINE-HEIGHT: 23px"><font color="#FF0000"><?=ka_bl($rate_id,"class2")?>：<font color=ff6600><?=ka_bl($rate_id,"class3")?></font></font></td>
           <td align="center"  class=left_acc_inner_con style="LINE-HEIGHT: 23px">
<?php 
		switch ($ka_bl_row['class1']){
			case '特码': switch ($ka_bl_row['class3']){
				case '单': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				break;
				case '双': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				break;
				case '家禽': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				break;
				case '野兽': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				break;
				case '大': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				break;
				case '小': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				break;
				case '合单': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				break;
				case '合双': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				break;
				case '红波': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				break;
				case '绿波': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				break;
				case '蓝波': $bmmm = $btmdx;
				$cmmm = $ctmdx;
				$dmmm = $dtmdx;
				break;
				default: $bmmm = $btm;
				$cmmm = $ctm;
				$dmmm = $dtm;
				break;
			}
			break;
			case '正码': switch ($ka_bl_row['class3'])
			{
				case '总单': $bmmm = $bzmdx;
				$cmmm = $czmdx;
				$dmmm = $dzmdx;
				break;
				case '总双': $bmmm = $bzmdx;
				$cmmm = $czmdx;
				$dmmm = $dzmdx;
				break;
				case '总大': $bmmm = $bzmdx;
				$cmmm = $czmdx;
				$dmmm = $dzmdx;
				break;
				case '总小': $bmmm = $bzmdx;
				$cmmm = $czmdx;
				$dmmm = $dzmdx;
				break;
				default: $bmmm = $bzm;
				$cmmm = $czm;
				$dmmm = $dzm;
				break;
			}
			break;
			case '五行': $bmmm = $bzm6;
			$cmmm = $czm6;
			$dmmm = $dzm6;
			break;
			case '生肖': switch ($ka_bl_row['class2'])
			{
				case '特肖': $bmmm = $bsx;
				$cmmm = $csx;
				$dmmm = $dsx;
				break;
				case '四肖': $bmmm = 0;
				$cmmm = 0;
				$dmmm = 0;
				break;
				case '五肖': $bmmm = 0;
				$cmmm = 0;
				$dmmm = 0;
				break;
				case '六肖': $bmmm = $bsx6;
				$cmmm = $csx6;
				$dmmm = $dsx6;
				break;
				case '一肖': $bmmm = $bsxp;
				$cmmm = $csxp;
				$dmmm = $dsxp;
				break;
				default: $bmmm = $bsxp;
				$cmmm = $csxp;
				$dmmm = $dsxp;
				break;
			}
			break;
			case '正特尾数': $bmmm = 0;
			$cmmm = 0;
			$dmmm = 0;
			break;
			case '半波': $bmmm = $bbb;
			$cmmm = $cbb;
			$dmmm = $dbb;
			break;
			case '半半波': $bmmm = $bbb;
			$cmmm = $cbb;
			$dmmm = $dbb;
			break;
			case '正肖': $bmmm = $bbb;
			$cmmm = $cbb;
			$dmmm = $dbb;
			break;
			case '七色波': $bmmm = $bbb;
			$cmmm = $cbb;
			$dmmm = $dbb;
			break;
			case '正特': switch ($ka_bl_row['class3'])
			{
				case '单': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '双': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '大': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '小': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '合单': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '合双': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '红波': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '绿波': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '蓝波': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				default: $bmmm = $bzt;
				$cmmm = $czt;
				$dmmm = $dzt;
				break;
			}
			break;
			case '正1-6': switch ($ka_bl_row['class3'])
			{
				case '单': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '双': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '大': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '小': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '合单': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '合双': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '红波': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '绿波': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '蓝波': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '合大': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '合小': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '合单': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '合双': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '尾大': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				case '尾小': $bmmm = $bztdx;
				$cmmm = $cztdx;
				$dmmm = $dztdx;
				break;
				default: $bmmm = $bzt;
				$cmmm = $czt;
				$dmmm = $dzt;
				break;
			}
			break;
			case '尾数': $bmmm = 0;
			$cmmm = 0;
			$dmmm = 0;
			break;
			default: $bmmm = 0;
			$cmmm = 0;
			$dmmm = 0;
			break;
		}
 		echo $ka_bl_row['rate'];
		$rate5 = $ka_bl_row['rate'];
		?>           
                                  </td> 
                                  <td align="center"  class=left_acc_inner_con style="LINE-HEIGHT: 23px"><?=$_POST['t'.$p]?></td>
                              </tr>
					<?php }
}
if ($sum_sum>ka_memuser("ts")){
echo "<script Language=Javascript>alert('对不起，下注总额不能大于可用信用额');parent.parent.leftFrame.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
exit;
}
?>                                  <tr> 
                                      <td height="28" colspan="4" align="center" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left';" type="button" value="放弃" name="btnCancel" /> 
                                      &nbsp;&nbsp;
                                          <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type="submit" value="确定" onClick="return ChkSubmit();" name="btnSubmit" /> 
                                      </td> 
                                  </tr> 
                              </table> 
                          </td> 
                      </tr> 
                  </form> 
                  </table> 
              </TD> 
          </TR> 
      </tbody> 
  </table> 
  </BODY> 
  </HTML> 
