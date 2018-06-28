<?php include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../include/newpage.php';
include_once '../class/user.php';
include_once '../common/function.php';
include_once 'function.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
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

$m_type=$_GET["m_type"];
$m_type=$m_type==""?"3,4,5,6":$m_type;
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
  <title>其他加/减款记录</title> 
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
			include_once("moneymenu.php");
			?>
			<div class="content">
				<table width="98%" border="0" cellspacing="0" cellpadding="5">
					<form id="form1" name="form1" action="?query=true" method="get">
					<tr>
						<td height="25" colspan="7" align="center" bgcolor="#3C3C3C" style="color:#FFF">
							<?php 
							include_once("moneysubmenu.php");
							?>
						</td>
					</tr>
					<tr>
						<td height="25" colspan="7" align="center" bgcolor="#D6D6D6">
							类型
							<select name="m_type" id="m_type">
								<option value="" <?=$m_type=="3,4,5,6"?"selected":""?>>全部</option>
								<option value="3" <?=$m_type=="3"?"selected":""?>>人工汇款</option>
								<option value="4" <?=$m_type=="4"?"selected":""?>>彩金派送</option>
								<option value="5" <?=$m_type=="5"?"selected":""?>>反水派送</option>
								<option value="6" <?=$m_type=="6"?"selected":""?>>其他情况</option>
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
						<th align="center">流水号</th>
						<th align="center">金额(+/-)</th>
						<th align="center">类型</th>
						<th align="center">备注说明</th>
						<th align="center">状态</th>
					</tr>
					<?php 
					$params = array(':uid' => $uid, ':begin_time' => $begin_time, ':end_time' => $end_time);
					$sql = 'select m_id from `k_money` where `uid`=:uid and type in(' . $m_type . ') and `m_make_time`>=:begin_time and `m_make_time`<=:end_time order by `m_id` desc';
					$stmt = $mydata1_db->prepare($sql);
					$stmt->execute($params);
					$sum = $stmt->rowCount();
					$thisPage = 1;
					if (@($_GET['page']))
					{
						$thisPage = $_GET['page'];
					}
					$page = new newPage();
					$perpage = 20;
					$thisPage = $page->check_Page($thisPage, $sum, $perpage);
					$id = '';
					$i = 1;
					$start = (($thisPage - 1) * $perpage) + 1;
					$end = $thisPage * $perpage;
					while ($row = $stmt->fetch())
					{
						if (($start <= $i) && ($i <= $end))
						{
							$id .= intval($row['m_id']) . ',';
						}
						if ($end < $i)
						{
							break;
						}
						$i++;
					}
					if ($id){
						$id = rtrim($id, ',');
						$sql	=	"select * from `k_money` where m_id in($id) order by m_id desc";
						$query = $mydata1_db->query($sql);
						$i = 1;
						$addmoney = 0;
						$submoney = 0;
						while ($rows = $query->fetch())
						{
					?> 					  
						
					<tr bgcolor="<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>" align="center" onMouseOver="this.style.backgroundColor='#FFFFCC'" onMouseOut="this.style.backgroundColor='<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>'" >
						<td align="center"><?=date("Y-m-d H:i:s",strtotime($rows["m_make_time"]))?></td>
						<td align="center"><?=date("Y-m-d H:i:s",strtotime($rows["m_make_time"])+12*3600)?></td>
						<td align="center"><?=$rows["m_order"]?></td>
						<td align="center"><?=sprintf("%.2f",$rows["m_value"])?></td>
						<td align="center"><?=mtypeName($rows["type"])?></td>
						<td align="center"><?=$rows["about"]?></td>
						<td align="center">
							<?php
							if($rows["status"]==1){
								if($rows["m_value"]>0){
									$addmoney += abs($rows["m_value"]);
								}else{
									$submoney += abs($rows["m_value"]);
								}
								echo '<span style="color:#FF0000;">成功</span>';
							}else if($rows["status"]==0){
								echo '<span style="color:#000000;">失败</span>';
							}else{
								echo '<span style="color:#0000FF;">系统审核中</span>';
							}
							?>
						</td>
					</tr>
					<?php
							$i++;
						}
					}
					?>
					<tr>
						<th colspan="7" align="center">
							<div class="Pagination">
								本页加款成功总金额：<font color="#ff0000"><?=sprintf("%.2f",$addmoney)?></font> RMB&nbsp;&nbsp;减款成功总金额：<font color="#ff0000"><?=sprintf("%.2f",$submoney)?></font> RMB&nbsp;&nbsp;
								<?=$page->get_htmlPage("data_o_money.php?cn_begin=".$cn_begin."&s_begin_h=".$s_begin_h."&s_begin_i=".$s_begin_i."&cn_end=".$cn_end."&s_end_h=".$s_end_h."&s_end_i=".$s_end_i."&m_type=".$m_type);?>
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
