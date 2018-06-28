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

if(!isset($liveList)||!is_array($liveList)){
	$_LIVE = include(dirname(dirname(__FILE__)).'/cj/include/live.php');
	$liveList = array();
	foreach($_LIVE as $key=>$val){
		$val[2]=='zr_rate'&&$liveList[$key] = array($val[1], $val[0]);
	}
	$liveList[23] = array('VR彩票', 'vrbetdetail');
	$liveList[31] = array('AG体育', 'sbtabetdetail');
	$liveTitle = '真人娱乐';
}

$atype=$_GET["atype"];
$atype=isset($liveList[$atype])?$atype:key($liveList);
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
  <title><?php echo $liveTitle; ?></title> 
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
                        <span style="color:#FF0">【温馨提醒】</span><?php echo $liveTitle; ?>注单需要同步后才能显示，请您耐心等待。
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
						  &nbsp;&nbsp;<select name="atype" id="atype">
<?php foreach($liveList as $key=>$val){ ?>								<option value="<?php echo $key; ?>" <?php echo $atype==$key?"selected":""; ?>><?php echo $val[0]; ?></option>
<?php } ?>							</select>
						  &nbsp;&nbsp;<input type="submit" name="query" class="submit_73" value="查询" /> 
					  </td> 
				  </tr> 
				  </form> 
				  <tr> 
					  <th align="center">投注时间(美东/北京)</th> 
					  <th align="center">订单号/局号</th> 
					  <th align="center">玩法详细信息</th> 
					  <th align="center">下注金额</th> 
					  <th align="center">派彩</th> 
                      <th align="center">有效投注</th> 
					  <th align="center">状态</th> 
				  </tr>
				  <?php
				  	$params = array(':uid' => $uid, ':begin_time' => date("Y-m-d H:i:s",strtotime($begin_time)-1*12*3600), ':end_time' => date("Y-m-d H:i:s",strtotime($end_time)-1*12*3600));
					$sql = 'select id from `'.$liveList[$atype][1].'` where uid=:uid and betTime>=:begin_time and betTime<=:end_time order by id desc';
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
					$sql	=	"select * from `".$liveList[$atype][1]."` where id in($id) order by betTime desc";
					$query = $mydata1_db->query($sql);
					$i = 1;
                    $sum_tz = 0;
					$sum_yx = 0;
					$sum_pc = 0;
					while ($rows = $query->fetch())
					{
                        $paicai = 0;
                        if($atype=='ABA'){
                            $status = $rows['result'];
                            empty($status)&&$status = $rows['flag']=='1'?'已结算':'未知';
                        }else{
                            $status = $rows['flag'];
                        }
						if ($rows['netAmount'] == 0)
						{
							$paicai = $rows["betAmount"];
							// $status = '和局';
						}
						else if ($rows['netAmount'] < 0)
						{
							$paicai = 0;
							$status = '<span style=\'color:#00CC00;\'>'.$status.'</span>';
						}
						else
						{
							$paicai = $rows["betAmount"]+$rows['netAmount'];
							$status = '<span style=\'color:#FF0000;\'>'.$status.'</span>';
						}
						$sum_tz += $rows['betAmount'];
                        $sum_yx += $rows["validBetAmount"];
						$sum_pc += $paicai;
						?>
						<tr bgcolor="<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>" align="center" onMouseOver="this.style.backgroundColor='#FFFFCC'" onMouseOut="this.style.backgroundColor='<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>'" >
						<td align="center"><?=date("Y-m-d H:i:s",strtotime($rows["betTime"]))?><br><?=date("Y-m-d H:i:s",strtotime($rows["betTime"])+1*12*3600)?></td>
						<td align="center"><?=$rows["billNo"]?><br /><?=empty($rows["gameCode"])?'未知局号':$rows["gameCode"]?></td>
						<td align="center"><?=$rows["gameType"]?><?=empty($rows["playType"])||$rows["playType"]=='null'?'':'【<span style=\'color:#FF0000;\'>'.$rows["playType"].'</span>】'?></td>
						<td align="center"><?=sprintf("%.2f",$rows["betAmount"])?></td>
                        <td align="center"><?=sprintf("%.2f",$paicai)?></td>
						<td align="center"><?=sprintf("%.2f",$rows["validBetAmount"])?></td>
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
								本页下注总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_tz)?></font> RMB&nbsp;&nbsp;派彩总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_pc)?></font> RMB&nbsp;&nbsp;有效投注总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_yx)?></font> RMB
								<?=$page->get_htmlPage($_SERVER['SCRIPT_NAME']."?cn_begin=".$cn_begin."&s_begin_h=".$s_begin_h."&s_begin_i=".$s_begin_i."&cn_end=".$cn_end."&s_end_h=".$s_end_h."&s_end_i=".$s_end_i."&atype=".$atype);?>
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