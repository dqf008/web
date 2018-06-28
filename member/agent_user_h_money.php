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
renovate($uid, $loginid);
if (!user::is_daili($uid))
{
	message('你还不是代理，请先申请', 'agent_reg.php');
}
$cn_begin=$_GET["cn_begin"];
$s_begin_h=$_GET["s_begin_h"];
$s_begin_i=$_GET["s_begin_i"];
$cn_begin=$cn_begin==""?date("Y-m-d",time() - (6 * 24 * 3600)):$cn_begin;
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
$selectuser = trim($_GET['selectuser']);
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
  <title>汇款记录</title> 
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
			include_once("agentmenu.php");
			?>
			<div class="content">
				<table width="98%" border="0" cellspacing="0" cellpadding="5">
					<form id="form1" name="form1" action="?query=true" method="get">
					<tr>
						<td height="25" colspan="9" align="center" bgcolor="#3C3C3C" style="color:#FFF">
							<?php 
							include_once("agent_user_moneysubmenu.php");
							?>
						</td>
					</tr>
					<tr>
						<td height="25" colspan="9" align="center" bgcolor="#D6D6D6">
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
							&nbsp;&nbsp;下线会员 
                            <input name="selectuser" type="text" id="selectuser" size="10"  value="<?=$selectuser;?>" title="不填，表示所有下线会员"/> 
							&nbsp;&nbsp;
							<input type="submit" name="query" class="submit_73" value="查询" />
						</td>
					</tr>
					</form>
				    <tr> 
					  <th align="center">会员名</th> 
					  <th align="center">提交时间(美东时间)</th> 
					  <th align="center">实际汇款时间(北京时间)</th> 
					  <th align="center">汇款流水号</th> 
					  <th align="center">汇款金额</th> 
					  <th align="center">汇款赠送</th> 
					  <th align="center">汇款银行</th> 
					  <th align="center">汇款方式</th> 
					  <th align="center">汇款状态</th> 
				    </tr>
					  <?php 
					    $params = array(':uid' => $uid, ':begin_time' => $begin_time, ':end_time' => $end_time);
						$sql = 'select h.id from `huikuan` h left join k_user u on u.uid=h.uid where u.`top_uid`=:uid and h.`adddate`>=:begin_time and h.`adddate`<=:end_time';
						if(!empty($selectuser)){
							$params[':username'] = $selectuser;
							$sql.= ' and u.username=:username';
						}
						$sql.= ' order by h.`id` desc';
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
								$id .= intval($row['id']) . ',';
							}
							if ($end < $i)
							{
								break;
							}
							$i++;
						}
						if ($id){
							$id = rtrim($id, ',');
							$sql	=	"select h.*,u.username from `huikuan` as h left join k_user u on u.uid=h.uid where h.id in($id) order by h.id desc";
							$query = $mydata1_db->query($sql);
							$i = 1;
							$sum_money = 0;
							$sum_zsjr = 0;
							while ($rows = $query->fetch()){
						?>
						<tr bgcolor="<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>" align="center" onMouseOver="this.style.backgroundColor='#FFFFCC'" onMouseOut="this.style.backgroundColor='<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>'" >
						<td align="center"><?=$rows["username"]?></td>
						<td align="center"><?=date("Y-m-d H:i:s",strtotime($rows["adddate"]))?></td>
						<td align="center"><?=date("Y-m-d H:i:s",strtotime($rows["date"]))?></td>
						<td align="center"><?=$rows["lsh"]?></td>
						<td align="center"><?=sprintf("%.2f",$rows["money"])?></td>
						<td align="center"><?=sprintf("%.2f",$rows["zsjr"])?></td>
						<td align="center"><?=$rows["bank"]?></td>
						<td align="center"><?=$rows["manner"]?></td>
						<td align="center">
							<?php
							if($rows["status"]==1){
								$sum_money += $rows["money"];
								$sum_zsjr += $rows["zsjr"];
								echo '<span style="color:#FF0000;">成功</span>';
							}else if($rows["status"]==2){
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
						<th colspan="9" align="center">
							<div class="Pagination">
								本页汇款成功总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_money)?></font> RMB&nbsp;&nbsp;赠送总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_zsjr)?></font> RMB
								<?=$page->get_htmlPage("agent_user_h_money.php?cn_begin=".$cn_begin."&s_begin_h=".$s_begin_h."&s_begin_i=".$s_begin_i."&cn_end=".$cn_end."&s_end_h=".$s_end_h."&s_end_i=".$s_end_i."&selectuser=".$selectuser);?>
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
