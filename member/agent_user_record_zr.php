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
$cn_begin=$cn_begin==""?date("Y-m-d",time() - (6 * 24 * 3600)):$cn_begin;

$cn_end=$_GET["cn_end"];
$cn_end=$cn_end==""?date("Y-m-d",time()):$cn_end;

$begin_time=$cn_begin." 00:00:00";
$end_time=$cn_end." 23:59:59";

$atype=$_GET["atype"];
$selectuser = trim($_GET['selectuser']);
$_LIVE = include('../cj/include/live.php');
$liveList = array('全部平台');
foreach($_LIVE as $val){
	$liveList[] = $val[1];
}
$atype=preg_match('/^\d+$/', $atype)&&isset($liveList[$atype])?$atype:0;
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
  <title>真人报表</title> 
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
                      <td height="25" colspan="9" align="center" bgcolor="#3C3C3C" style="color:#FFF"><?php include_once 'agent_user_recordsubmenu.php';?>                        </td> 
                  </tr> 
                  <tr> 
                      <td height="25" colspan="7" align="center" bgcolor="#3C3C3C" style="color:#FFF">
                        <span style="color:#FF0">【温馨提醒】</span>平台报表需要等待系统生成后才能显示，请您耐心等待。
                      </td> 
                  </tr>
				  <tr> 
				 	 <td height="25" colspan="7" align="center" bgcolor="#D6D6D6"> 
					  开始日期
						<input name="cn_begin" type="text" id="cn_begin" size="10" readonly="readonly" value="<?=$cn_begin?>" onclick="new Calendar(2008,2020).show(this);"/>
						&nbsp;&nbsp;结束日期
						<input name="cn_end" type="text" id="cn_end" size="10" readonly="readonly" value="<?=$cn_end?>" onclick="new Calendar(2008,2020).show(this);"/>
						&nbsp;&nbsp;<select name="atype" id="atype">
<?php foreach($liveList as $key=>$val){ ?>							<option value="<?php echo $key; ?>" <?=$atype==$key?"selected":""?>><?php echo $val; ?></option>
<?php } ?>						</select>
                        &nbsp;&nbsp;下线会员 
                        <input name="selectuser" type="text" id="selectuser" size="10"  value="<?=$selectuser;?>" title="不填，表示所有下线会员"/> 
						&nbsp;&nbsp;<input type="submit" name="query" class="submit_73" value="查询" />
					</td>
				</tr>
				</form> 
			    <tr> 
				  <th align="center">会员名</th> 
				  <th align="center">下注时间(美东)</th> 
				  <th align="center">游戏平台</th> 
				  <th align="center">注单数量</th> 
				  <th align="center">下注金额</th> 
                  <th align="center">有效投注</th> 
				  <th align="center">派彩金额</th> 
			    </tr>
				  <?php
				  	$params = array(':uid' => $uid, ':begin_time' => strtotime($begin_time), ':end_time' => strtotime($end_time));
                    $sql = 'select d.id from `daily_report` d left join `k_user` u on u.uid=d.uid where u.top_uid=:uid and d.report_date>=:begin_time and d.report_date<=:end_time';
                    if($atype>0){
                        $params[':platform_id'] = intval($atype-1);
                        $sql.= ' and d.platform_id=:platform_id';
                    }
                    if(!empty($selectuser)){
                        $params[':username'] = $selectuser;
                        $sql.= ' and u.username=:username';
                    }
					$stmt = $mydata1_db->prepare($sql.' order by d.report_date desc, d.id desc');
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
					$sql	=	"select d.*,u.username from `daily_report` d left join `k_user` u on u.uid=d.uid where d.id in($id) order by d.report_date desc, d.id desc";
					$query = $mydata1_db->query($sql);
					$i = 1;
                    $sum_tz = 0;
                    $sum_yx = 0;
					$sum_pc = 0;
					while ($rows = $query->fetch())
					{
                        $rows['platform_id']++;
                        $rows["net_amount"] = $rows["net_amount"]+$rows["bet_amount"];
                        $status = sprintf("%.2f", $rows["net_amount"]/100);
						if ($rows['net_amount'] < $rows["bet_amount"])
						{
							$status = '<span style=\'color:#00CC00;\'>'.$status.'</span>';
						}
						else if ($rows['net_amount'] > $rows["bet_amount"])
						{
							$status = '<span style=\'color:#FF0000;\'>'.$status.'</span>';
						}
                        $sum_tz += $rows["bet_amount"];
                        $sum_yx += $rows["valid_amount"];
						$sum_pc += $rows["net_amount"];
						?>
						<tr bgcolor="<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>" align="center" onMouseOver="this.style.backgroundColor='#FFFFCC'" onMouseOut="this.style.backgroundColor='<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>'" >
                        <td align="center"><?php echo $rows['username']; ?></td>
                        <td align="center"><?php echo date('Y-m-d', $rows['report_date']); ?><br />00:00:00～23:59:59</td>
                        <td align="center"><?php echo $liveList[$rows['platform_id']]; ?></td>
                        <td align="center"><?php echo $rows['rows_num']; ?></td>
                        <td align="center"><?php echo sprintf("%.2f", $rows["bet_amount"]/100); ?></td>
                        <td align="center"><?php echo sprintf("%.2f", $rows["valid_amount"]/100); ?></td>
                        <td align="center"><?php echo $status; ?></td>
					</tr>
					<?php
							$i++;
						}
					}
					?>
					<tr>
						<th colspan="7" align="center">
							<div class="Pagination">
								本页下注总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_tz/100)?></font> RMB&nbsp;&nbsp;有效总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_yx/100)?></font> RMB&nbsp;&nbsp;派彩总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_pc/100)?></font> RMB
								<?=$page->get_htmlPage("agent_user_record_zr.php?cn_begin=".$cn_begin."&cn_end=".$cn_end."&atype=".$atype."&selectuser=".$selectuser);?>
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