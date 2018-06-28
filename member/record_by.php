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

$liveList = array();
$liveList['AGIN'] = array('AG国际厅', 'aginbetdetail');
$liveList['AGQ'] = array('AG极速厅', 'agbetdetail');
$liveList['HUNTER'] = array('AG捕鱼王', 'hunterbetdetail');
$liveList['SABAH'] = array('沙巴体育', 'shababetdetail');
$liveList['BBIN'] = array('BBIN旗舰厅', 'bbbetdetail');
$liveList['OG'] = array('OG东方厅', 'ogbetdetail');
$liveList['ABA'] = array('壹号现场厅', 'ababetdetail');
$liveList['XTD'] = array('新天地娱乐厅', 'xtdbetdetail');
$liveList['HG'] = array('HG电子真人', 'hgbetdetail');
$liveList['MG'] = array('MG电子真人', 'mgbetdetail');
$liveList['PT'] = array('PT电子真人', 'ptbetdetail');
$liveList['XIN'] = array('XIN电子游艺', 'xinbetdetail');
$liveList['NYX'] = array('NYX电子游艺', 'nyxbetdetail');
$liveList['TTG'] = array('TTG电子游艺', 'ttgbetdetail');
$liveList['ENDO'] = array('ENDO电子游艺', 'endobetdetail');

$atype=$_GET["atype"];
$atype=isset($liveList[$atype])?$atype:key($liveList);
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
  <title>捕鱼王Ⅱ</title> 
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
                      <td height="25" colspan="9" align="center" bgcolor="#3C3C3C" style="color:#FFF">
                        <span style="color:#FF0">【温馨提醒】</span>捕鱼王Ⅱ注单需要同步后才能显示，请您耐心等待。
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
						  &nbsp;&nbsp;<input type="submit" name="query" class="submit_73" value="查询" /> 
					  </td> 
				  </tr> 
				  </form> 
				  <tr> 
					  <th align="center">结算时间(美东/北京)</th> 
					  <th align="center">订单号/项目编号</th> 
					  <th align="center">场景时间(美东)</th> 
					  <th align="center">类型/场景号</th> 
					  <th align="center">房间号/倍率</th> 
                      <th align="center">子弹值/捕鱼值</th> 
					  <th align="center">派彩</th> 
				  </tr>
				  <?php
				  	$params = array(':uid' => $uid, ':begin_time' => date("Y-m-d H:i:s",strtotime($begin_time)-1*12*3600), ':end_time' => date("Y-m-d H:i:s",strtotime($end_time)-1*12*3600));
					$sql = 'select id from `hunterbetdetail` where uid=:uid and creationTime>=:begin_time and creationTime<=:end_time order by id desc';
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
					if ($id)
					{
					$id = rtrim($id, ',');
					$sql	=	"select * from `hunterbetdetail` where id in($id) order by creationTime desc";
					$query = $mydata1_db->query($sql);
					$i = 1;
					$sum_pc = 0;
					while ($rows = $query->fetch())
					{
                        $status = sprintf("%.2f",$rows["transferAmount"]);
						if ($rows['transferAmount'] < 0)
						{
							$status = '<span style=\'color:#00CC00;\'>'.$status.'</span>';
						}
						else if ($rows['transferAmount'] > 0)
						{
							$status = '<span style=\'color:#FF0000;\'>'.$status.'</span>';
						}
						$sum_pc += $rows["transferAmount"];
						?>
						<tr bgcolor="<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>" align="center" onMouseOver="this.style.backgroundColor='#FFFFCC'" onMouseOut="this.style.backgroundColor='<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>'" >
						<td align="center"><?=date("Y-m-d H:i:s",strtotime($rows["creationTime"]))?><br><?=date("Y-m-d H:i:s",strtotime($rows["creationTime"])+1*12*3600)?></td>
						<td align="center"><?=$rows["tradeNo"]?><br /><?=$rows["cID"]?></td>
						<td align="center"><?=date("Y-m-d H:i:s",strtotime($rows["SceneStartTime"]))?><br><?=date("Y-m-d H:i:s",strtotime($rows["SceneEndTime"]))?></td>
						<td align="center"><?=$rows["ctype"]?><br /><?=$rows["sceneId"]?></td>
                        <td align="center"><?=$rows["Roomid"]?><br /><?=intval($rows["Roombet"])?>倍场</td>
						<td align="center"><?=$rows["Cost"]==0&&$rows["Earn"]==0?'-':$rows["Cost"].'<br />'.$rows["Earn"]?></td>
						<td align="center"><?=$status?></td>
					</tr>
					<?php
							$i++;
						}
					}
					?>
					<tr>
						<th colspan="8" align="center">
							<div class="Pagination">
								本页派彩总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_pc)?></font> RMB
								<?=$page->get_htmlPage("record_by.php?cn_begin=".$cn_begin."&s_begin_h=".$s_begin_h."&s_begin_i=".$s_begin_i."&cn_end=".$cn_end."&s_end_h=".$s_end_h."&s_end_i=".$s_end_i."&atype=".$atype);?>
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