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
include_once 'function.php';
include_once '../cj/include/function.php';

$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);
$cn_begin = $_GET['cn_begin'];
$s_begin_h = $_GET['s_begin_h'];
$s_begin_i = $_GET['s_begin_i'];
$cn_begin = ($cn_begin == '' ? date('Y-m-d', time()) : $cn_begin);
$s_begin_h = ($s_begin_h == '' ? '00' : $s_begin_h);
$s_begin_i = ($s_begin_i == '' ? '00' : $s_begin_i);
$cn_end = $_GET['cn_end'];
$s_end_h = $_GET['s_end_h'];
$s_end_i = $_GET['s_end_i'];
$cn_end = ($cn_end == '' ? date('Y-m-d', time()) : $cn_end);
$s_end_h = ($s_end_h == '' ? '23' : $s_end_h);
$s_end_i = ($s_end_i == '' ? '59' : $s_end_i);
$begin_time = $cn_begin . ' ' . $s_begin_h . ':' . $s_begin_i . ':00';
$end_time = $cn_end . ' ' . $s_end_h . ':' . $s_end_i . ':59';
$live_type = $_GET['live_type'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <title>转换记录</title> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
	  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
	  <script type="text/javascript" src="images/member.js"></script> 
	  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
	  <script type="text/javascript" src="../js/calendar.js"></script> 
  </head> 
  <body> 
  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;">
  <?php include_once 'mainmenu.php';?>	  
  	<tr> 
	  <td colspan="2" align="center" valign="middle">
		  <?php include_once 'moneymenu.php';?>			  
		  <div class="content"> 
				  <table width="98%" border="0" cellspacing="0" cellpadding="5"> 
					  <form id="form1" name="form1" action="?query=true" method="get"> 
					  <tr> 
						  <td height="25" colspan="7" align="center" bgcolor="#D6D6D6"> 
							  真人公司 
							  <select name="live_type" id="live_type"> 
								  <option value="" <?=$live_type==''? 'selected' :'' ;?>>全部</option> 
								  <option value="AGIN" <?=$live_type=='AGIN' ? 'selected' : '';?>>AG国际厅</option> 
								  <option value="AG" <?=$live_type=='AG' ? 'selected' :'' ;?>>AG极速厅</option> 
                                  <option value="BBIN" <?=$live_type=='BBIN' ? 'selected' :'' ;?>>BB波音厅</option> 
                                  <option value="OG" <?=$live_type=='OG' ? 'selected' :'' ;?>>OG东方厅</option>
                                  <option value="MAYA" <?=$live_type=='MAYA' ? 'selected' :'' ;?>>玛雅娱乐厅</option>
                                  <option value="MW" <?=$live_type=='MW' ? 'selected' :'' ;?>>MW电子游戏</option>
                                  <option value="SHABA" <?=$live_type=='SHABA' ? 'selected' : '';?>>沙巴体育</option>   
                                  <option value="MG" <?=$live_type=='MG' ? 'selected' :'' ;?>>MG电子游戏</option> 
                                  <option value="KG" <?=$live_type=='KG' ? 'selected' :'' ;?>>AV女优</option> 
							  </select> 
							  &nbsp;&nbsp;开始日期
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
						  <th align="center">美东时间</th> 
						  <th align="center">北京时间</th> 
						  <th align="center">转账类型</th> 
						  <th align="center">转账流水号</th> 
						  <th align="center">转账金额</th> 
						  <th align="center">状态</th> 
						  <th align="center">处理结果</th> 
					  </tr>
<?php 
$params = array();
if ($live_type != ''){
	$params[':live_type'] = $live_type;
	$sqlwhere = ' and live_type=:live_type';
}
$params[':uid'] = $uid;
$params[':begin_time'] = $begin_time;
$params[':end_time'] = $end_time;
$sql = 'select id from `ag_zhenren_zz` where `uid`=:uid ' . $sqlwhere . ' and `zz_time`>=:begin_time and `zz_time`<=:end_time order by `id` desc';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$sum = $stmt->rowCount();
$thisPage = 1;
if ($_GET['page']){
	$thisPage = $_GET['page'];
}
$page = new newPage();
$perpage = 20;
$thisPage = $page->check_Page($thisPage, $sum, $perpage);
$id = '';
$i = 1;
$start = (($thisPage - 1) * $perpage) + 1;
$end = $thisPage * $perpage;
while ($row = $stmt->fetch()){
	if (($start <= $i) && ($i <= $end))	{
		$id .= intval($row['id']) . ',';
	}
	if ($end < $i)	{
		break;
	}
	$i++;
}

if ($id){
	$id = rtrim($id, ',');
	$sql = 'select * from `ag_zhenren_zz` where id in(' . $id . ') order by id desc';
	$query = $mydata1_db->query($sql);
	$i = 1;
	$inmoney = 0;
	$outmoney = 0;
	while ($rows = $query->fetch()){
?>
 	<tr bgcolor="<?=$i % 2==0 ? '#FFFFFF' : '#F5F5F5';?>" align="center" onMouseOver="this.style.backgroundColor='#FFFFCC'" onMouseOut="this.style.backgroundColor='<?=$i % 2==0 ? '#FFFFFF' : '#F5F5F5';?>'" > 
						<td align="center"><?=date("Y-m-d H:i:s",strtotime($rows["zz_time"])-1*12*3600)?></td>
						<td align="center"><?=date("Y-m-d H:i:s",strtotime($rows["zz_time"]))?></td>
						<td align="center">
						<?php

						$str = typeName($rows["live_type"]);
						$typeName = $str['title'];

						if($rows['zz_type']=='IN'){
							echo '体育/彩票 → '.$typeName;
						}elseif($rows['zz_type']=='OUT'){
							echo $typeName.' → 体育/彩票';
						}

						
						?>
						</td>
						<td align="center"><?=$rows["billno"]?></td>
						<td align="center"><?=sprintf("%.2f",$rows["zz_money"])?></td>
						<td align="center"><?=$rows["ok"]==0?"处理中":"已处理"?></td>
						<td align="center"><?=$rows["result"]?></td>
					  </tr>				  
<?php 
		if ($rows['ok'] == 1){
			if ($rows['zz_type'] == 'IN'){
				$inmoney += abs($rows['zz_money']);
			}else if ($rows['zz_type'] == 'OUT'){
				$outmoney += abs($rows['zz_money']);
			}
			$i++;
		}
	}
}
?>
 					  <tr> 
						  <th colspan="7" align="center"> 
							<div class="Pagination"> 
								本页转账成功：[转入]<font color="#ff0000"><?=sprintf('%.2f',$inmoney);?></font> RMB&nbsp;&nbsp;[转出]<font color="#ff0000"><?=sprintf('%.2f',$outmoney);?></font> RMB&nbsp;&nbsp;
								<?=$page->get_htmlPage("zr_data_money.php?cn_begin=".$cn_begin."&s_begin_h=".$s_begin_h."&s_begin_i=".$s_begin_i."&cn_end=".$cn_end."&s_end_h=".$s_end_h."&s_end_i=".$s_end_i."&zz_type=".$zz_type);?>
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