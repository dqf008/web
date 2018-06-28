<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('bbgl');
include '../../include/pager.class.php';
include 'CommonFun.php';
$username = trim($_GET['username']);
$betDate1 = $_GET['betDate1'];
$betHour1 = $_GET['betHour1'];
$betSecond1 = $_GET['betSecond1'];
$betDate1 = ($betDate1 == '' ? date('Y-m-d') : $betDate1);
$betHour1 = ($betHour1 == '' ? '00' : $betHour1);
$betSecond1 = ($betSecond1 == '' ? '00' : $betSecond1);
$betDate2 = $_GET['betDate2'];
$betHour2 = $_GET['betHour2'];
$betSecond2 = $_GET['betSecond2'];
$betDate2 = ($betDate2 == '' ? date('Y-m-d') : $betDate2);
$betHour2 = ($betHour2 == '' ? '23' : $betHour2);
$betSecond2 = ($betSecond2 == '' ? '59' : $betSecond2);
$betTime1 = $betDate1 . ' ' . $betHour1 . ':' . $betSecond1 . ':00';
$betTime2 = $betDate2 . ' ' . $betHour2 . ':' . $betSecond2 . ':59';
?> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
  <title>Welcome</title> 
  <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" /> 
  <script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
  <script language="JavaScript" src="/js/calendar.js"></script> 
</head> 
<body> 
<div id="pageMain"> 
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5"> 
	  <tr> 
		  <td valign="top"> 
			  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="font12" style="border:1px solid #798EB9;"> 
				  <form name="form1" method="get" action="<?=$_SERVER['REQUEST_URI'];?>"> 
					  <tr> 
						  <td align="left"> 
							  会员 
							  <input name="username" type="text" id="username" value="<?=$username;?>" size="12" /> 
							  &nbsp;&nbsp;查询时间 
							  <input name="betDate1" type="text" id="betDate1" value="<?=$betDate1;?>" onClick="new Calendar(2008,2020).show(this);" size="8" maxlength="10" readonly="readonly" /> 
							  <select name="betHour1" id="betHour1">
							  <?php 
								for ($i = 0;$i < 24;$i++){
								$hour = ($i < 10 ? '0' . $i : $i);
							  ?>									  
							  <option value="<?=$hour;?>"<?=$betHour1==$hour ? 'selected' : '';?>><?=$hour;?></option>
							  <?php }?> 								  
							  </select> 
							  时 
							  <select name="betSecond1" id="betSecond1">
							  <?php 
								for ($i = 0;$i < 60;$i++){
								$second = ($i < 10 ? '0' . $i : $i);
							  ?>									  
							  <option value="<?=$second;?>"<?=$betSecond1==$second ? 'selected' : '';?>><?=$second;?></option>
							  <?php }?> 								  
							  </select> 
							  分 
							  &nbsp;&nbsp;到 
							  <input name="betDate2" type="text" id="betDate2" value="<?=$betDate2;?>" onClick="new Calendar(2008,2020).show(this);" size="8" maxlength="10" readonly="readonly" /> 
							  <select name="betHour2" id="betHour2">
							  <?php 
								for ($i = 0;$i < 24;$i++){
								$hour = ($i < 10 ? '0' . $i : $i);
							  ?>									  
								<option value="<?=$hour;?>"<?=$betHour2==$hour ? 'selected' : '';?>><?=$hour;?></option>
							  <?php }?> 								  
							  </select> 
							  时 
							  <select name="betSecond2" id="betSecond2">
							  <?php 
								for ($i = 0;$i < 60;$i++)
								{
								$second = ($i < 10 ? '0' . $i : $i);
							 ?>									  
							 <option value="<?=$second;?>"<?=$betSecond2==$second ? 'selected' : '';?>><?=$second;?></option>
							 <?php }?> 								  
							 </select>
							  分 
							  &nbsp;&nbsp;<input type="submit" name="Submit" value="查询" /> 
						  </td> 
					  </tr> 
				  </form> 
			  </table> 
			  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;line-height:20px;" bgcolor="#798EB9">    
				  <tr style="background-color:#3C4D82;color:#FFF;text-align:center;"> 
					  <td>会员账号</td> 
					  <td>真人账号</td> 
					  <td>下注订单笔数</td> 
					  <td>投注额度</td> 
					  <td>有效投注额度</td> 
					  <td>会员派彩</td> 
					  <td>玩家小费</td> 
					  <td>红包</td> 
					  <td>赌王报名</td> 
					  <td>赌王奖金</td> 
				  </tr>
<?php 
$where = '';
$where2 = '';
$params = array();
if ($username != ''){
	$params_u[':username'] = $username;
	$sql_u = 'select agUserName from k_user k where k.username=:username';
	$stmt_u = $mydata1_db->prepare($sql_u);
	$stmt_u->execute($params_u);
	$playerName = $stmt_u->fetchColumn();
	if ($playerName != ''){
		$params[':playerName'] = $playerName;
		$where .= ' and A.playerName=:playerName';
		$params[':playerName2'] = $playerName;
		$where2 .= ' and B.playerName=:playerName2';
	}else{
		$where .= ' and 1=2';
		$where2 .= ' and 1=2';
	}
}
$params[':betTime1'] = $betTime1;
$params[':betTime2'] = $betTime2;
$params[':betTime12'] = $betTime1;
$params[':betTime22'] = $betTime2;
$sql = 'SELECT Z.username,Y.playerName,sum(Y.orderNum) AS orderNum,sum(Y.netAmount) AS netAmount,sum(Y.betAmount) AS betAmount,sum(Y.validBetAmount) AS validBetAmount,sum(Y.donatefee) AS donatefee,sum(Y.red_pocket) AS red_pocket,sum(Y.comp_enroll) AS comp_enroll,sum(Y.comp_prize) AS comp_prize FROM(SELECT A.playerName,count(A.id) AS orderNum,sum(A.netAmount) AS netAmount,sum(A.betAmount) AS betAmount,sum(A.validBetAmount) AS validBetAmount,0 AS donatefee,0 AS red_pocket,0 AS comp_enroll,0 AS comp_prize FROM aginbetdetail A WHERE A.betTime >= :betTime1 AND A.betTime <= :betTime2 ' . $where. ' GROUP BY A.uid UNION ALL SELECT B.playername,0 AS orderNum,0 AS netAmount,0 AS betAmount,0 AS validBetAmount,sum(IF(B.transferType=\'DONATEFEE\',B.transferAmount,0)) AS donatefee,sum(IF(B.transferType=\'RED_POCKET\',B.transferAmount,0)) AS red_pocket,sum(IF(B.transferType=\'COMP_ENROLL\' OR B.transferType=\'COMP_REFUND\',B.transferAmount,0)) AS comp_enroll,sum(IF(B.transferType=\'COMP_PRIZE\',B.transferAmount,0)) AS comp_prize FROM agintransferdetail B WHERE B.creationTime >= :betTime12 AND B.creationTime <= :betTime22 ' . $where2 . ' GROUP BY B.playerName) Y LEFT OUTER JOIN k_user Z ON Y.playerName = Z.agUserName GROUP BY Z.username,Y.playerName';

$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$color = '#FFFFFF';
$over = '#EBEBEB';
$out = '#ffffff';
$sum_orderNum = 0;
$sum_betAmount = 0;
$sum_validBetAmount = 0;
$sum_netAmount = 0;
$sum_donatefee = 0;
$sum_red_pocket = 0;
$sum_JackpotSettlement = 0;
$sum_comp_enroll = 0;
$sum_comp_prize = 0;
while ($rows = $stmt->fetch()){
	$sum_orderNum += $rows['orderNum'];
	$sum_betAmount += $rows['betAmount'];
	$sum_validBetAmount += $rows['validBetAmount'];
	$sum_netAmount += $rows['netAmount'];
	$sum_donatefee += $rows['donatefee'];
	$sum_red_pocket += $rows['red_pocket'];
	$sum_comp_enroll += $rows['comp_enroll'];
	$sum_comp_prize += $rows['comp_prize'];
?>					  
					<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;line-height:20px;height:25px;"> 
					  <td><?=$rows['username'];?></td> 
					  <td><?=$rows['playerName'];?></td> 
					  <td><?=$rows['orderNum'];?></td> 
					  <td><?=sprintf('%.2f',$rows['betAmount']);?></td> 
					  <td><?=sprintf('%.2f',$rows['validBetAmount']);?></td> 
					  <td style="color:<?=$rows['netAmount'] < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$rows['netAmount']);?></td> 
					  <td style="color:<?=$rows['donatefee'] < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$rows['donatefee']);?></td> 
					  <td style="color:<?=$rows['red_pocket'] < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$rows['red_pocket']);?></td> 						  
					  <td style="color:<?=$rows['sum_comp_enroll'] < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$rows['sum_comp_enroll']);?></td> 
					  <td style="color:<?=$rows['sum_comp_prize'] < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$rows['sum_comp_prize']);?></td></td> 
				  </tr>
<?php }?> 					  
				  <tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;line-height:20px;height:25px;font-weight:bold;"> 
					  <td colspan="2">合计</td> 
					  <td><?=$sum_orderNum;?></td> 
					  <td><?=sprintf('%.2f',$sum_betAmount);?></td> 
					  <td><?=sprintf('%.2f',$sum_validBetAmount);?></td> 
					  <td style="color:<?=$sum_netAmount < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$sum_netAmount);?></td> 
					  <td style="color:<?=$sum_donatefee < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$sum_donatefee);?></td> 
					  <td style="color:<?=$sum_red_pocket < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$sum_red_pocket);?></td> 
					  <td style="color:<?=$sum_comp_enroll < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$sum_comp_enroll);?></td> 
					  <td style="color:<?=$sum_comp_prize < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$sum_comp_prize);?></td> 
				  </tr> 
			  </table> 
		  </td> 
	  </tr> 
  </table> 
</div> 
</body> 
</html>