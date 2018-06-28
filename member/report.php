<?php
ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);
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
$cn_begin=$cn_begin==""?date("Y-m-d",time()-6*24*3600):$cn_begin;
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

$cn_begin_time = date('Y-m-d H:i:s', strtotime($begin_time) + (12 * 3600));
$cn_end_time = date('Y-m-d H:i:s', strtotime($end_time) + (12 * 3600));

?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
  <title>统计报表</title> 
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
			<div class="nav">
				<ul>
					<li class='current'><a href="javascript:void(0);" onclick="Go('report.php');return false">统计报表</a></li>
				</ul>
			</div>
			<div class="content">
				<table width="98%" border="0" cellspacing="0" cellpadding="5"> 
				<form id="form1" name="form1" action="?query=true" method="get">
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
						  &nbsp;&nbsp;<input type="submit" name="query" class="submit_73" value="查询" /> 
					  </td> 
				  </tr> 
				  </form> 
				  <tr> 
					  <td align="center"> 
						  <table width="100%" border="0" cellpadding="5" cellspacing="0" style="line-height:20px;"> 
							  <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;"> 
								  <td colspan="10"><?=$begin_time?> 至 <?=$end_time?> 财务报表</td> 
							  </tr> 
							  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
								  <td colspan="4" class="borderright">常规存取款</td> 
								  <td colspan="3" class="borderright">红利派送</td> 
								  <td rowspan="2" class="borderright">其他情况</td> 
								  <td colspan="2">手续费(银行转账费用)</td> 
							  </tr> 
							  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
								  <td class="borderright">存款</td> 
								  <td class="borderright">汇款</td> 
								  <td class="borderright">人工汇款</td> 
								  <td class="borderright">提款</td> 
								  <td class="borderright">汇款赠送</td> 
								  <td class="borderright">彩金派送</td> 
								  <td class="borderright">反水派送</td> 
								  <td class="borderright">第三方(1%)</td> 
								  <td>提款手续费</td> 
							  </tr>
							  <?php
							    $color = '#FFFFFF';
								$over = '#EBEBEB';
								$out = '#ffffff';
								$params = array(':uid' => $uid, ':begin_time' => $begin_time, ':end_time' => $end_time, ':uid2' => $uid, ':begin_time2' => $begin_time, ':end_time2' => $end_time);
								$sql = 'select sum(t1_value) as t1_value,sum(t2_value) as t2_value,sum(t3_value) as t3_value,sum(t4_value) as t4_value,sum(t5_value) as t5_value,sum(t6_value) as t6_value,sum(t1_sxf) as t1_sxf,sum(t2_sxf) as t2_sxf,sum(h_value) as h_value,sum(h_zsjr) as h_zsjr from (';
								$sql .= 'select sum(if(m.type=1,m.m_value,0)) as t1_value,sum(if(m.type=2,m.m_value,0)) as t2_value,sum(if(m.type=3,m.m_value,0)) as t3_value,sum(if(m.type=4,m.m_value,0)) as t4_value,sum(if(m.type=5,m.m_value,0)) as t5_value,sum(if(m.type=6,m.m_value,0)) as t6_value,sum(if(m.type=1,m.sxf,0)) as t1_sxf,sum(if(m.type=2,m.sxf,0)) as t2_sxf,0 as h_value, 0 as h_zsjr from k_money m where status=1 and uid=:uid and m.m_make_time>=:begin_time and m.m_make_time<=:end_time';
								$sql .= ' union all ';
								$sql .= 'select 0 as t1_value,0 as t2_value,0 as t3_value,0 as t4_value,0 as t5_value,0 as t6_value,0 as t1_sxf,0 as t2_sxf,sum(ifnull(h.money,0)) as h_value,sum(ifnull(h.zsjr,0)) as h_zsjr from huikuan h where status=1 and uid=:uid2 and h.adddate>=:begin_time2 and h.adddate<=:end_time2';
								$sql .= ')temp';
								$stmt = $mydata1_db->prepare($sql);
								$stmt->execute($params);
								while ($row = $stmt->fetch())
								{
							?> 								  
							<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over?>'" onMouseOut="this.style.backgroundColor='<?=$out?>'" style="background-color:<?=$color?>;">
								<td class="borderright"><?=sprintf("%.2f",$row["t1_value"])?></td>
								<td class="borderright"><?=sprintf("%.2f",$row["h_value"])?></td>
								<td class="borderright"><?=sprintf("%.2f",$row["t3_value"])?></td>
								<td class="borderright"><?=sprintf("%.2f",abs($row["t2_value"]))?></td>
								<td class="borderright"><?=sprintf("%.2f",$row["h_zsjr"])?></td>
								<td class="borderright"><?=sprintf("%.2f",$row["t4_value"])?></td>
								<td class="borderright"><?=sprintf("%.2f",$row["t5_value"])?></td>
								<td class="borderright"><?=sprintf("%.2f",$row["t6_value"])?></td>
								<td class="borderright"><?=sprintf("%.2f",$row["t1_sxf"])?></td>
								<td class="borderright"><?=sprintf("%.2f",$row["t2_sxf"])?></td>
							</tr>
							<?php }?> 							  
						</table> 
					  </td> 
				  </tr> 
				  <tr> 
					  <td align="center"> 
					  		<?php
					  			$zrlist = [
									'AGIN'=>['name'=>'AG国际厅'],
									'AG'=>['name'=>'AG极速厅'],
									'BBIN'=>['name'=>'BB波音厅'],
									'OG2'=>['name'=>'新OG东方厅'],
									'MAYA'=>['name'=>'玛雅娱乐厅'],
									'SHABA'=>['name'=>'沙巴体育'],
									'PT2'=>['name'=>'新PT电子'],
									'MW'=>['name'=>'MW游戏'],
									'KG'=>['name'=>'AV女优'],
									'CQ9'=>['name'=>'CQ9电子'],
									'MG2'=>['name'=>'新MG电子'],
									'VR'=>['name'=>'VR彩票'],
									'BGLIVE'=>['name'=>'BG视讯'],
									'SB'=>['name'=>'申博视讯'],
									'DG'=>['name'=>'DG视讯'],
									'KY'=>['name'=>'开元棋牌'],
								];
					  		?>
						  <table width="100%" border="0" cellpadding="5" cellspacing="0" style="line-height:20px;"> 
							  <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;"> 
								  <td colspan="<?=count($zrlist)*2?>"><?=$begin_time?>  至<?=$end_time?> 真人转账报表</td> 
							  </tr> 
							  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
							  	<?php foreach($zrlist as $k=>$v):?>
							  		<td colspan="2" class="borderright"><?=$v['name']?></td>
							  	<?php endforeach;?>
							  </tr> 
							  <!--2015-06-27 HB BBIN --> 
							  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
							  		<?php foreach($zrlist as $k=>$v):?>
								  		<td class="borderright">转入</td> 
								  		<td class="borderright">转出</td> 
								  	<?php endforeach;?>
							  </tr> 
							  
							  <?php 
							    $params = array(':uid' => $uid, ':begin_time' => $begin_time, ':end_time' => $end_time);
							    $sql = '';
							    foreach($zrlist as $k=>$v){
							    	$sql .= 'sum(if(zz_type="IN" and live_type="'.$k.'",zz_money,0)) as '.$k.'_in,sum(if(zz_type="OUT" and live_type="'.$k.'",zz_money,0)) as '.$k.'_out,';
							    }
								$sql = 'select '.rtrim($sql,',').' from ag_zhenren_zz where uid=:uid and ok=1 and zz_time>=:begin_time and zz_time<=:end_time';
								$stmt = $mydata1_db->prepare($sql);
								$stmt->execute($params);
								while ($row = $stmt->fetch()){
							  ?>
							  <tr align="center" onMouseOver="this.style.backgroundColor='<?=$over?> '" onMouseOut="this.style.backgroundColor='<?=$out?> '" style="background-color:<?=$color?> ;"> 
							  	<?php foreach($zrlist as $k=>$v):?>
							  		<td class="borderright"><?=sprintf("%.2f",$row[$k.'_in'])?></td> 
								  	<td class="borderright"><?=sprintf("%.2f",$row[$k.'_out'])?></td> 
							  	<?php endforeach;?>
							  </tr>
							  <?php }?> 							  
						 </table> 
					  </td> 
				  </tr> 
				  <tr> 
					  <td align="center"> 
						  <table width="100%" border="0" cellpadding="5" cellspacing="0" style="line-height:20px;"> 
							  <tr align="center" style="background:#3C4D82;color:#ffffff;font-weight:bold;"> 
								  <td colspan="9"><?=$begin_time?> 至 <?=$end_time?>  投注报表</td> 
							  </tr> 
							  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
								  <td rowspan="2" class="borderright">彩种</td> 
								  <td colspan="6" class="borderright">已结算</td> 
								  <td colspan="2">未结算</td> 
							  </tr> 
							  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
								  <td class="borderright">笔数</td> 
								  <td class="borderright">下注金额</td> 
								  <td class="borderright">有效投注</td> 
								  <td class="borderright">派彩</td> 
								  <td class="borderright">反水</td> 
								  <td class="borderright">盈亏</td> 
								  <td class="borderright">笔数</td> 
								  <td>下注金额</td> 
							  </tr>
							  <?php 
							    $params = array(':uid' => $uid, ':begin_time' => $begin_time, ':end_time' => $end_time, ':uid2' => $uid, ':begin_time2' => $begin_time, ':end_time2' => $end_time, ':username3' => $username, ':cn_begin_time3' => $cn_begin_time, ':cn_end_time3' => $cn_end_time, ':uid4' => $uid, ':begin_time4' => $begin_time, ':end_time4' => $end_time, ':uid5' => $uid, ':begin_time5' => $begin_time, ':end_time5' => $end_time, ':username6' => $username, ':begin_time6' => $begin_time, ':end_time6' => $end_time, ':uid7' => $uid, ':begin_time7' => strtotime($begin_time), ':end_time7' => strtotime($end_time), ':uid8' => $uid, ':begin_time8' => $begin_time, ':end_time8' => $end_time);
								
								$sql = 'select cz,sum(y_num) as y_num,sum(y_bet_money) as y_bet_money,sum(yx_bet_money) as yx_bet_money,sum(y_win) as y_win,sum(y_fs) as y_fs,sum(w_num) as w_num,sum(w_bet_money) as w_bet_money from (';
								$sql .= 'select 1 as xuhao,\'tyds\' as cz,if(status<>0,1,0) as y_num,if(status<>0,bet_money,0) as y_bet_money,if(status=1 or status=2 or status=4 or status=5,bet_money,0) as yx_bet_money,if(status<>0,win,0) as y_win,if(status<>0,fs,0) as y_fs,if(status=0,1,0) as w_num,if(status=0,bet_money,0) as w_bet_money from k_bet k where uid=:uid and lose_ok=1 and status in (0,1,2,3,4,5,6,7,8) and k.bet_time>=:begin_time and k.bet_time<=:end_time ';
								$sql .= ' union all ';
								$sql .= 'select 2 as xuhao,\'tycg\' as cz,if(status<>0 and status<>2,1,0) as y_num,if(status<>0 and status<>2,bet_money,0) as y_bet_money,if(status=1,bet_money,0) as yx_bet_money,if(status<>0 and status<>2,win,0) as y_win,if(status<>0 and status<>2,fs,0) as y_fs,if(status=0 or status=2,1,0) as w_num,if(status=0 or status=2,bet_money,0) as w_bet_money from k_bet_cg_group k where uid=:uid2 and k.gid>0 and status in (0,1,2,3,4) and k.bet_time>=:begin_time2 and k.bet_time<=:end_time2 ';
								$sql .= ' union all ';
								$sql .= 'select 3 as xuhao,\'lhc\' as cz,if(checked=1,1,0) as y_num,if(checked=1,sum_m,0) as y_bet_money,if(checked=1 and bm<>2,sum_m,0) as yx_bet_money,if(checked=1,(case bm when 1 then sum_m*rate when 2 then sum_m else 0 end),0) as y_win,if(checked=1,(case bm when 2 then 0 else sum_m*user_ds/100 end),0) as y_fs,if(checked=0,1,0) as w_num,if(checked=0,sum_m,0) as w_bet_money from mydata2_db.ka_tan where username=:username3 and adddate>=:cn_begin_time3 and adddate<=:cn_end_time3 ';
								$sql .= ' union all ';
								$sql .= 'select 4 as xuhao,type as cz,if(js=1,1,0) as y_num,if(js=1,money,0) as y_bet_money,if(js=1 and win<>0,money,0) as yx_bet_money,if(js=1,(case when win<0 then 0 when win=0 then money else win end),0) as y_win,0 as y_fs,if(js=0,1,0) as w_num,if(js=0,money,0) as w_bet_money from c_bet where uid=:uid4 and money>0 and addtime>=:begin_time4 and addtime<=:end_time4 ';
								$sql .= ' union all ';
								$sql .= 'select 5 as xuhao,type as cz,if(js=1,1,0) as y_num,if(js=1,money,0) as y_bet_money,if(js=1 and win<>0,money,0) as yx_bet_money,if(js=1,(case when win<0 then 0 when win=0 then money else win end),0) as y_win,0 as y_fs,if(js=0,1,0) as w_num,if(js=0,money,0) as w_bet_money from c_bet_3 where uid=:uid5 and money>0 and addtime>=:begin_time5 and addtime<=:end_time5 ';
								$sql .= ' union all ';
								$sql .= 'select 6 as xuhao,atype as cz,if(bet_ok=1,1,0) as y_num,if(bet_ok=1,money,0) as y_bet_money,if(bet_ok=1 and win<>0,money,0) as yx_bet_money,if(bet_ok=1,win+money,0) as y_win,0 as y_fs,if(bet_ok=0,1,0) as w_num,if(bet_ok=0,money,0) as w_bet_money from lottery_data where username=:username6 and money>0 and bet_time>=:begin_time6 and bet_time<=:end_time6 ';
								$sql .= ' union all ';
								$sql .= 'select 7 as xuhao,type as cz,if(status=1,1,0) as y_num,if(status=1,money/100,0) as y_bet_money,if(status=1 and win<>money,money/100,0) as yx_bet_money,if(status=1,(case when win<0 then 0 when win=0 then money else win/100 end),0) as y_win,0 as y_fs,if(status=0,1,0) as w_num,if(status=0,money/100,0) as w_bet_money from c_bet_data where uid=:uid7 and money>0 and addtime between :begin_time7 and :end_time7 and status between 0 and 1';
                                $sql .= ' union all ';
                                $sql .= 'select 8 as xuhao,type as cz,if(js=1,1,0) as y_num,if(js=1,money,0) as y_bet_money,if(js=1 and win<>0,money,0) as yx_bet_money,if(js=1,(case when win<0 then 0 when win=0 then money else win end),0) as y_win,0 as y_fs,if(js=0,1,0) as w_num,if(js=0,money,0) as w_bet_money from c_bet_choose5 where uid=:uid8 and money>0  and addtime>=:begin_time8 and addtime<=:end_time8 ';
                                $sql .= ') temp group by cz order by xuhao';
								$stmt = $mydata1_db->prepare($sql);
								$stmt->execute($params);
								$sum_y_num = 0;
								$sum_y_bet_money = 0;
								$sum_yx_bet_money = 0;
								$sum_y_win = 0;
								$sum_y_fs = 0;
								$sum_y_yingkui = 0;
								$sum_w_num = 0;
								$sum_w_bet_money = 0;
								while ($row = $stmt->fetch())
								{
								$y_yingkui = sprintf('%.2f', ($row['y_win'] + $row['y_fs']) - $row['y_bet_money']);
								$sum_y_num += $row['y_num'];
								$sum_y_bet_money += $row['y_bet_money'];
								$sum_yx_bet_money += $row['yx_bet_money'];
								$sum_y_win += $row['y_win'];
								$sum_y_fs += $row['y_fs'];
								$sum_y_yingkui += $y_yingkui;
								$sum_w_num += $row['w_num'];
								$sum_w_bet_money += $row['w_bet_money'];
								switch ($row['cz'])
								{
									case 'tyds': $czname = '体育单式';
									break;
									case 'tycg': $czname = '体育串关';
									break;
									case 'lhc': $czname = '香港六合彩';
									break;
									case 'kl8': $czname = '北京快乐8';
									break;
									case 'ssl': $czname = '上海时时乐';
									break;
									case '3d': $czname = '福彩3D';
									break;
									case 'pl3': $czname = '排列三';
									break;
									case 'qxc': $czname = '七星彩';
									break;
									case 'JSSC': $czname = '极速赛车';
									break;
									case 'JSSSC': $czname = '极速时时彩';
									break;
									case 'JSLH': $czname = '极速六合';
									break;
                                    case 'pcdd': $czname ='PC蛋蛋';
                                        break;
                                    case 'fjk3': $czname ='福建快3';
                                        break;
                                    case 'jsk3': $czname ='江苏快3';
                                        break;
                                    case 'gxk3': $czname ='广西快3';
                                        break;
                                    case 'ahk3': $czname ='安徽快3';
                                        break;
                                    case 'shk3': $czname ='上海快3';
                                        break;
                                    case 'hbk3': $czname ='湖北快3';
                                        break;
                                    case 'hebk3': $czname ='河北快3';
                                        break;
                                    case 'jlk3': $czname ='吉林快3';
                                        break;
                                    case 'gzk3': $czname ='贵州快3';
                                        break;
                                    case 'bjk3': $czname ='北京快3';
                                        break;
                                    case 'gsk3': $czname ='甘肃快3';
                                        break;
                                    case 'nmgk3': $czname ='内蒙古快3';
                                        break;
                                    case 'jxk3': $czname ='江西快3';
                                        break;
                                    case 'FFK3': $czname = '分分快3';
                                        break;
                                    case 'SFK3': $czname = '超级快3';
                                        break;
                                    case 'WFK3': $czname = '好运快3';
                                        break;
                                    case 'GDSYXW':$czname='广东11选5';
                                        break;
                                    case 'SDSYXW':$czname='山东11选5';
                                        break;
                                    case 'FJSYXW':$czname='福建11选5';
                                        break;
                                    case 'BJSYXW':$czname='北京11选5';
                                        break;
                                    case 'AHSYXW':$czname='安徽11选5';
                                        break;
									default: $czname = $row['cz'];
									break;
								}
							?> 								  
							<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over?>'" onMouseOut="this.style.backgroundColor='<?=$out?>'" style="background-color:<?=$color?>;">
									<td class="borderright"><?=$czname?></td>
									<td class="borderright"><?=$row["y_num"]?></td>
									<td class="borderright"><?=sprintf("%.2f",$row["y_bet_money"])?></td>
									<td class="borderright"><?=sprintf("%.2f",$row["yx_bet_money"])?></td>
									<td class="borderright"><?=sprintf("%.2f",$row["y_win"])?></td>
									<td class="borderright"><?=sprintf("%.2f",$row["y_fs"])?></td>
									<td class="borderright" style="color:<?=$y_yingkui>=0?'#ff0000':'#009900'?>"><?=$y_yingkui?></td>
									<td class="borderright"><?=$row["w_num"]?></td>
									<td><?=sprintf("%.2f",$row["w_bet_money"])?></td>
								</tr>
								<?php } ?>
								<tr align="center" style="background:#ffffff;color:#ff0000;">
									<td class="borderright">合计</td>
									<td class="borderright"><?=$sum_y_num?></td>
									<td class="borderright"><?=sprintf("%.2f",$sum_y_bet_money)?></td>
									<td class="borderright"><?=sprintf("%.2f",$sum_yx_bet_money)?></td>
									<td class="borderright"><?=sprintf("%.2f",$sum_y_win)?></td>
									<td class="borderright"><?=sprintf("%.2f",$sum_y_fs)?></td>
									<td class="borderright" style="color:<?=$sum_y_yingkui>=0?'#ff0000':'#009900'?>"><?=sprintf("%.2f",$sum_y_yingkui)?></td>
									<td class="borderright"><?=$sum_w_num?></td>
									<td><?=sprintf("%.2f",$sum_w_bet_money)?></td>
								</tr>
								<tr>
                                	<td colspan="8">注：仅统计输单返水，赢单返水计入派彩</td>
                                </tr>
							</table>
						</td>
					</tr>
				</table>
			</div> 
	  </td> 
  </tr> 
</table> 
</body> 
</html>