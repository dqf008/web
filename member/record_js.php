<?php 
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../include/newpage.php';
include_once '../class/user.php';
include_once '../common/function.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
$username = $_SESSION['username'];
renovate($uid, $loginid);

$cn_begin=$_GET["cn_begin"];
$s_begin_h=$_GET["s_begin_h"];
$s_begin_i=$_GET["s_begin_i"];
$cn_begin=$cn_begin==""?date("Y-m-d",time()):$cn_begin;
$s_begin_h=$s_begin_h==""?"00":$s_begin_h;
$s_begin_i=$s_begin_i==""?"00":$s_begin_i;

$cn_end=$_GET["cn_end"];
$s_end_h=$_GET["s_end_h"];
$s_end_i=$_GET["s_end_i"];
$cn_end=$cn_end==""?date("Y-m-d",time()):$cn_end;
$s_end_h=$s_end_h==""?"23":$s_end_h;
$s_end_i=$s_end_i==""?"59":$s_end_i;

$begin_time=$cn_begin." ".$s_begin_h.":".$s_begin_i.":00";
$end_time=$cn_end." ".$s_end_h.":".$s_end_i.":59";

$atype=$_GET["atype"];
$atype=$atype==""?"1":$atype;
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
  <title>高频时时彩</title> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
  <script type="text/javascript" src="images/member.js"></script> 
  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
  <script type="text/javascript" src="../js/calendar.js"></script> 
</head> 
<body> 
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;">
	<?php 
	include_once("mainmenu.php");
	?>
	<tr>
		<td colspan="2" align="center" valign="middle">
			<?php 
			include_once("recordmenu.php");
			?>
			<div class="content">
			  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
				  <form id="form1" name="form1" action="?query=true" method="get">
                      <tr>
                          <td height="25" colspan="9" align="left" bgcolor="#3C3C3C" style="color:#FFF"><a href="javascript:;" onclick="Go('record_ss.php?atype=1');return false" style="color:<?=$atype=="1"?'#FF0':'#FFF'?>">重庆时时彩</a> - <a href="javascript:;" onclick="Go('record_ss.php?atype=tjssc');return false" style="color:<?=$atype=="tjssc"?'#FF0':'#FFF'?>">天津时时彩</a>&nbsp;-&nbsp;<a href="javascript:;" onclick="Go('record_ss.php?atype=xjssc');return false" style="color:<?=$atype=="xjssc"?'#FF0':'#FFF'?>">新疆时时彩</a>&nbsp;-&nbsp;<a href="javascript:;" onclick="Go('record_ss.php?atype=2');return false" style="color:<?=$atype=="2"?'#FF0':'#FFF'?>">广东快乐十分</a>&nbsp;-&nbsp;<a href="javascript:;" onclick="Go('record_ss.php?atype=cqkl10');return false" style="color:<?=$atype=="cqkl10"?'#FF0':'#FFF'?>">重庆快乐十分</a>&nbsp;-&nbsp;<a href="javascript:;" onclick="Go('record_ss.php?atype=tjkl10');return false" style="color:<?=$atype=="tjkl10"?'#FF0':'#FFF'?>">天津快乐十分</a>&nbsp;-&nbsp;<a href="javascript:;" onclick="Go('record_ss.php?atype=hnkl10');return false" style="color:<?=$atype=="hnkl10"?'#FF0':'#FFF'?>">湖南快乐十分</a>&nbsp;-&nbsp;<a href="javascript:;" onclick="Go('record_ss.php?atype=sxkl10');return false" style="color:<?=$atype=="sxkl10"?'#FF0':'#FFF'?>">山西快乐十分</a>&nbsp;-&nbsp;<a href="javascript:;" onclick="Go('record_ss.php?atype=ynkl10');return false" style="color:<?=$atype=="ynkl10"?'#FF0':'#FFF'?>">云南快乐十分</a>&nbsp;-&nbsp;<a href="javascript:;" onclick="Go('record_ss.php?atype=3');return false" style="color:<?=$atype=="3"?'#FF0':'#FFF'?>">北京赛车PK拾</a>&nbsp;-&nbsp;<a href="javascript:;" onclick="Go('record_ss.php?atype=4');return false" style="color:<?=$atype=="4"?'#FF0':'#FFF'?>">幸运飞艇</a>
                          </td>
                      </tr>
                      <tr>
                          <td height="25" colspan="9" align="left" bgcolor="#3C3C3C" style="color:#FFF">
                              <a href="javascript:;" onclick="Go('record_js.php?atype=5');return false" style="color:<?=$atype=="5"?'#FF0':'#FFF'?>">极速赛车</a>&nbsp;-&nbsp;<a href="javascript:;" onclick="Go('record_js.php?atype=6');return false" style="color:<?=$atype=="6"?'#FF0':'#FFF'?>">极速时时彩</a>&nbsp;-&nbsp;<a href="javascript:;" onclick="Go('record_js.php?atype=7');return false" style="color:<?=$atype=="7"?'#FF0':'#FFF'?>">极速六合</a> -
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=gdchoose5');return false" style="color:<?=$atype=="gdchoose5"?'#FF0':'#FFF'?>">广东11选5</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=sdchoose5');return false" style="color:<?=$atype=="sdchoose5"?'#FF0':'#FFF'?>">山东11选5</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=fjchoose5');return false" style="color:<?=$atype=="fjchoose5"?'#FF0':'#FFF'?>">福建11选5</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=bjchoose5');return false" style="color:<?=$atype=="bjchoose5"?'#FF0':'#FFF'?>">北京11选5</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=ahchoose5');return false" style="color:<?=$atype=="ahchoose5"?'#FF0':'#FFF'?>">安徽11选5</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=jsk3');return false" style="color:<?=$atype=="jsk3"?'#FF0':'#FFF'?>">江苏快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=fjk3');return false" style="color:<?=$atype=="fjk3"?'#FF0':'#FFF'?>">福建快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=ahk3');return false" style="color:<?=$atype=="ahk3"?'#FF0':'#FFF'?>">安徽快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=gxk3');return false" style="color:<?=$atype=="gxk3"?'#FF0':'#FFF'?>">广西快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=shk3');return false" style="color:<?=$atype=="shk3"?'#FF0':'#FFF'?>">上海快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=hbk3');return false" style="color:<?=$atype=="hbk3"?'#FF0':'#FFF'?>">湖北快3</a>&nbsp;

                          </td>
                      </tr>
                      <tr>
                          <td height="25" colspan="9" align="left" bgcolor="#3C3C3C" style="color:#FFF">
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=hebk3');return false" style="color:<?=$atype=="hebk3"?'#FF0':'#FFF'?>">河北快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=jlk3');return false" style="color:<?=$atype=="jlk3"?'#FF0':'#FFF'?>">吉林快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=gzk3');return false" style="color:<?=$atype=="gzk3"?'#FF0':'#FFF'?>">贵州快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=bjk3');return false" style="color:<?=$atype=="bjk3"?'#FF0':'#FFF'?>">北京快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=gsk3');return false" style="color:<?=$atype=="gsk3"?'#FF0':'#FFF'?>">甘肃快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=nmgk3');return false" style="color:<?=$atype=="nmgk3"?'#FF0':'#FFF'?>">内蒙古快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_ss.php?atype=jxk3');return false" style="color:<?=$atype=="jxk3"?'#FF0':'#FFF'?>">江西快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_js.php?atype=ffk3');return false" style="color:<?=$atype=="ffk3"?'#FF0':'#FFF'?>">分分快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_js.php?atype=sfk3');return false" style="color:<?=$atype=="sfk3"?'#FF0':'#FFF'?>">超级快3</a>&nbsp;-
                              <a href="javascript:;" onclick="Go('record_js.php?atype=wfk3');return false" style="color:<?=$atype=="wfk3"?'#FF0':'#FFF'?>">好运快3</a>

                          </td>
                      </tr>
				  <tr> 
					  <td height="25" colspan="8" align="center" bgcolor="#D6D6D6"> 
						  开始日期 
						  <input name="cn_begin" type="text" id="cn_begin" size="10" readonly="readonly" value="<?=$cn_begin?>" onclick="new Calendar(2008,2020).show(this);"/>
							<select name="s_begin_h" id="s_begin_h">
								<?php
								for($bh_i=0;$bh_i<24;$bh_i++){
									$b_h_value=$bh_i<10?"0".$bh_i:$bh_i;
								?>
								<option value="<?=$b_h_value?>" <?=$s_begin_h==$b_h_value?"selected":""?>><?=$b_h_value?></option>
								<?php } ?>
							</select>
							时
							<select name="s_begin_i" id="s_begin_i">
								<?php
								for($bh_j=0;$bh_j<60;$bh_j++){
									$b_i_value=$bh_j<10?"0".$bh_j:$bh_j;
								?>
								<option value="<?=$b_i_value?>" <?=$s_begin_i==$b_i_value?"selected":""?>><?=$b_i_value?></option>
								<?php } ?>
							</select>
							分
							&nbsp;&nbsp;结束日期
							<input name="cn_end" type="text" id="cn_end" size="10" readonly="readonly" value="<?=$cn_end?>" onclick="new Calendar(2008,2020).show(this);"/>
							<select name="s_end_h" id="s_end_h">
								<?php
								for($eh_i=0;$eh_i<24;$eh_i++){
									$e_h_value=$eh_i<10?"0".$eh_i:$eh_i;
								?>
								<option value="<?=$e_h_value?>" <?=$s_end_h==$e_h_value?"selected":""?>><?=$e_h_value?></option>
								<?php } ?>
							</select>
							时
							<select name="s_end_i" id="s_end_i">
								<?php
								for($eh_j=0;$eh_j<60;$eh_j++){
									$e_i_value=$eh_j<10?"0".$eh_j:$eh_j;
								?>
								<option value="<?=$e_i_value?>" <?=$s_end_i==$e_i_value?"selected":""?>><?=$e_i_value?></option>
								<?php } ?>
							</select>
							分			
						  &nbsp;&nbsp;<input type="hidden" name="atype" value="<?php echo $atype; ?>"><input type="submit" name="query" class="submit_73" value="查询" /> 
					  </td> 
				  </tr> 
				  </form> 
				  <tr> 
					  <th align="center">投注时间(美东/北京)</th> 
					  <th align="center">注单号/期数</th> 
					  <th align="center">投注详细信息</th> 
					  <th align="center">下注金额</th> 
					  <th align="center">可赢</th> 
					  <th align="center">派彩</th> 
					  <th align="center">状态</th> 
				  </tr>
				  <?php 
				$atypename = 'JSSC';
				  switch ($atype){
					case 6: 
						$atypename = 'JSSSC';
						break;
					case 7: 
						$atypename = 'JSLH';
						break;
                      case 'ffk3':
                          $atypename ='FFK3';
                          break;
                      case 'sfk3':
                          $atypename ='SFK3';
                          break;
                      case 'wfk3':
                          $atypename ='WFK3';
                          break;
					}
					$params = array(':type' => $atypename, ':uid' => $uid, ':begin_time' => strtotime($begin_time), ':end_time' => strtotime($end_time));
					$sql = 'SELECT COUNT(*) AS `count` FROM `c_bet_data` WHERE `type`=:type AND `uid`=:uid AND `addtime` BETWEEN :begin_time AND :end_time AND `status` BETWEEN 0 AND 1';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$sum = $stmt->fetch();
					$sum = $sum['count'];
					$thisPage = 1;
					if (@($_GET['page']))
					{
					$thisPage = $_GET['page'];
					}
					$page = new newPage();
					$perpage = 20;
					$thisPage = $page->check_Page($thisPage, $sum, $perpage);
					$start = (($thisPage - 1) * $perpage) + 1;
					$end = $thisPage * $perpage;
					if ($sum>0)
					{
					$sql	=	'SELECT * FROM `c_bet_data` WHERE `type`=:type AND `uid`=:uid AND `addtime` BETWEEN :begin_time AND :end_time AND `status` BETWEEN 0 AND 1 ORDER BY `id` DESC LIMIT :index, :limit';
					$params[':index'] = ($thisPage-1)*$perpage;
					$params[':limit'] = $perpage;
					$query = $mydata1_db->prepare($sql);
					$query->execute($params);
					$i = 1;
					$paicai = 0;
					$status = '';
					$sum_tz = 0;
					$sum_pc = 0;
					$contentText=array('3THTX'=>'三同号通选','3LHTX'=>'三连号通选');
					while ($rows = $query->fetch())
					{
						$rows['value'] = unserialize($rows['value']);
						$rows['money']/= 100;
						$rows['win']/= 100;
						if ($rows['status'] == 1)
						{
							if ($rows['win'] == $rows['money'])
							{
								$paicai = $rows['money'];
								$status = '和局';
							}
							else if ($rows['win'] < 0)
							{
								$paicai = 0;
								$status = '<span style=\'color:#00CC00;\'>输</span>';
							}
							else
							{
								$paicai = $rows['win'];
								$status = '<span style=\'color:#FF0000;\'>赢</span>';
							}
						}
						else
						{
							$paicai = 0;
							$status = '未结算';
						}
						$sum_tz += $rows['money'];
						$sum_pc += $paicai;
					?>
					<tr bgcolor="<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>" align="center" onMouseOver="this.style.backgroundColor='#FFFFCC'" onMouseOut="this.style.backgroundColor='<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>'" >
						<td align="center"><?=date("Y-m-d H:i:s",$rows["addtime"])?><br><?=date("Y-m-d H:i:s",$rows["addtime"]+43200)?></td>
						<td align="center"><?=$rows["id"]?><br />第 <?=$rows['value']["qishu"]?> 期</td>
                        <?php if(in_array($atypename,array('FFK3','SFK3','WFK3'))){?>
                            <td align="center"><?=$rows['value']["class"][0]?>【<font color="#FF0000"><?=isset($contentText[$rows['value']['class'][1]])? $contentText[$rows['value']['class'][1]]:$rows['value']['class'][1];?></font>】</td>
                        <?php } else{ ?>
						    <td align="center"><?=$rows['value']["class"][0]?><br /><font color="#FF0000"><?=$rows['value']['class'][1];?></font> @ <font color="#ff6600"><?php echo $rows['value']["odds"]; ?></font></td>
						<?php }?>
                        <td align="center"><?=sprintf("%.2f",$rows["money"])?></td>
						<td align="center"><?=sprintf("%.2f",$rows["money"]*$rows['value']["odds"])?></td>
						<td align="center"><?=sprintf("%.2f",$paicai)?></td>
						<td align="center"><?=$status?></td>
					</tr>
					<?php 
						$i++;
						}
					}
					?> 					  
					<tr> 
					<tr>
						<th colspan="8" align="center">
							<div class="Pagination">
								本页下注总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_tz)?></font> RMB&nbsp;&nbsp;派彩总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_pc)?></font> RMB
								<?=$page->get_htmlPage("record_js.php?cn_begin=".$cn_begin."&s_begin_h=".$s_begin_h."&s_begin_i=".$s_begin_i."&cn_end=".$cn_end."&s_end_h=".$s_end_h."&s_end_i=".$s_end_i."&atype=".$atype);?>
							</div>
						</th>
					</tr>
			  </table> 
		  </div> 
	  </td> 
  </tr> 
</table> 
</body> 
</html>