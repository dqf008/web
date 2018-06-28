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
$type = 1;
if(isset($_GET["type"]) && $_GET['type']){
    $type = $_GET['type'];
}
$type_ids = array(
    '1' => 'aginbetdetail', //AG国际
    '2' => 'agbetdetail',   //AG极速
    '3' => 'bbbetdetail',   //BB波音
    '4' => 'ogbetdetail',   //OG东方
    //'5' => 'hgbetdetail',   //HG名人
    //'6' => 'ababetdetail',  //ABA壹号
    '7' => 'mayabetdetail', //玛雅娱乐
    '8' => 'mgbetdetail',//MG真人电游
    '9' => 'ptbetdetail',//PT真人电游
    '10' => 'mg2betdetail',
    '11' => 'vrbetdetail',
    '12' => 'bglivebetdetail',
    '13' => 'sbbetdetail',
    '14' => 'og2betdetail',
    '15' => 'dgbetdetail',
    '16' => 'bbin2betdetail',
);
$type2_ids = array(
    '1' => 'agintransferdetail', //AG国际
    '2' => 'agtransferdetail',   //AG极速
    '3' => 'bbtransferdetail',   //BB波音
    '4' => 'ogtransferdetail',   //OG东方
    //'5' => 'hgtransferdetail',   //HG名人
    //'6' => 'ababetdetail',  //ABA壹号
    '7' => 'mayatransferdetail', //玛雅娱乐
    '8' => 'mgtransferdetail',//MG真人电游
    '9' => 'pttransferdetail',//PT真人电游
);
$type_names = array(
    '1' => 'agUserName', //AG国际
    '2' => 'agUserName',   //AG极速
    '3' => 'bbinUserName',   //BB波音
    '4' => 'ogUserName',   //OG东方
    //'5' => 'hgUserName',   //HG名人
    //'6' => 'ababetdetail',  //ABA壹号
    '7' => 'mayaUserName', //玛雅娱乐
    '8' => 'mgUserName',//MG真人电游
    '9' => 'ptUserName',//PT真人电游
    '10' => 'mg2UserName',
    '11' => 'vrUserName',
    '12' => 'bgUserName',
    '13' => 'sbUserName',
    '14' => 'og2UserName',
    '15' => 'dgUserName',
    '16' => 'bbin2UserName',

);
$table = $type_ids[$type];
$table2 = $type2_ids[$type];
$name = $type_names[$type];
?> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
  <title>Welcome</title> 
  <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" /> 
  <script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
  <script language="JavaScript" src="/js/calendar.js"></script>
    <style>
        .sel_btn{
            height: 21px;
            line-height: 21px;
            padding: 0 11px;
            background: #02bafa;
            border: 1px #26bbdb solid;
            border-radius: 3px;
            color: #fff;
            display: inline-block;
            text-decoration: none;
            font-size: 12px;
            outline: none;
        }
        .ch_cls{
            background:#ff0000 !important;
        }
        .old {
        	background:#ccc ;
        	border-color:#ccc ;
        }
        a:hover{color:white;}
    </style>
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
                              <a href="MemberReport.php?type=1" class="sel_btn <?php if($type == 1){ echo 'ch_cls';}?>">AG国际厅</a>
                              &nbsp;<a href="MemberReport.php?type=2" class="sel_btn <?php if($type == 2){ echo 'ch_cls';}?>">AG极速厅</a>
                              &nbsp;<a href="MemberReport.php?type=16" class="sel_btn <?php if($type == 16){ echo 'ch_cls';}?>">新BB波音厅</a>
                              &nbsp;<a href="MemberReport.php?type=14" class="sel_btn <?php if($type == 14){ echo 'ch_cls';}?>">新OG东方厅</a>
                              &nbsp;<a href="MemberReport.php?type=7" class="sel_btn <?php if($type == 7){ echo 'ch_cls';}?>">玛雅娱乐厅</a>
                              &nbsp;<a href="MemberReport.php?type=11" class="sel_btn <?php if($type == 11){ echo 'ch_cls';}?>">VR彩票</a>
                              &nbsp;<a href="MemberReport.php?type=12" class="sel_btn <?php if($type == 12){ echo 'ch_cls';}?>">BG视讯</a>
                              &nbsp;<a href="MemberReport.php?type=13" class="sel_btn <?php if($type == 13){ echo 'ch_cls';}?>">申博视讯</a>
                              &nbsp;<a href="MemberReport.php?type=15" class="sel_btn <?php if($type == 15){ echo 'ch_cls';}?>">DG视讯</a>
                              &nbsp;<a href="MemberReport.php?type=10" class="sel_btn old <?php if($type == 10){ echo 'ch_cls';}?>">MG欧美厅</a>
                              &nbsp;<a href="MemberReport.php?type=9" class="sel_btn old <?php if($type == 9){ echo 'ch_cls';}?>">PT真人电游</a>
                              &nbsp;<a href="MemberReport.php?type=4" class="sel_btn old <?php if($type == 4){ echo 'ch_cls';}?>">OG东方厅</a>
                              &nbsp;<a href="MemberReport.php?type=3" class="sel_btn old <?php if($type == 3){ echo 'ch_cls';}?>">BB波音厅</a>
                              <input type="hidden" name="type" value="<?php echo $type;?>">
                          </td>
                      </tr>
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
					  <!--td>赌王报名</td> 
					  <td>赌王奖金</td--> 
				  </tr>
<?php 
$where = '';
$where2 = '';
$params = array();
if ($username != ''){
	$params_u[':username'] = $username;
	$sql_u = 'select '.$name.' from k_user k where k.username=:username';
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

if( in_array($type, [7,11,14,15,16]) ){

	unset($params[':betTime12']);
	unset($params[':betTime22']);
	unset($params[':playerName2']);
	$sql = 'SELECT A.username,A.playerName,count(A.id) AS orderNum,sum(A.netAmount) AS netAmount,sum(A.betAmount) AS betAmount,sum(A.validBetAmount) AS validBetAmount FROM '.$table.' A  WHERE   A.betTime >= :betTime1 AND A.betTime <= :betTime2 ' . $where. ' GROUP BY A.uid ';
}elseif($type == 10 || $type == 12 || $type == 13 ){
	unset($params[':betTime12']);
	unset($params[':betTime22']);
	unset($params[':playerName2']);
	switch ($type) {
		case 10: $platformtype = 'LIVE'; break;
		case 12: $platformtype = 'BGLIVE'; break;
		case 13: $platformtype = 'SB'; break;
	}
	$sql = 'SELECT A.username,A.playerName,count(A.id) AS orderNum,sum(A.netAmount) AS netAmount,sum(A.betAmount) AS betAmount,sum(A.validBetAmount) AS validBetAmount FROM '.$table.' A  WHERE   A.betTime >= :betTime1 AND A.betTime <= :betTime2 and platformtype="'.$platformtype.'" ' . $where. ' GROUP BY A.uid ';
}else{
	$sql = 'SELECT Y.username,Y.playerName,sum(Y.orderNum) AS orderNum,sum(Y.netAmount) AS netAmount,sum(Y.betAmount) AS betAmount,sum(Y.validBetAmount) AS validBetAmount,sum(Y.donatefee) AS donatefee,sum(Y.red_pocket) AS red_pocket,sum(Y.comp_enroll) AS comp_enroll,sum(Y.comp_prize) AS comp_prize FROM(SELECT A.playerName,count(A.id) AS orderNum,sum(A.netAmount) AS netAmount,sum(A.betAmount) AS betAmount,sum(A.validBetAmount) AS validBetAmount,0 AS donatefee,0 AS red_pocket,0 AS comp_enroll,0 AS comp_prize,username FROM '.$table.' A WHERE A.betTime >= :betTime1 AND A.betTime <= :betTime2 ' . $where. ' GROUP BY A.uid UNION ALL SELECT B.playername,0 AS orderNum,0 AS netAmount,0 AS betAmount,0 AS validBetAmount,sum(IF(B.transferType=\'DONATEFEE\',B.transferAmount,0)) AS donatefee,sum(IF(B.transferType=\'RED_POCKET\',B.transferAmount,0)) AS red_pocket,sum(IF(B.transferType=\'COMP_ENROLL\' OR B.transferType=\'COMP_REFUND\',B.transferAmount,0)) AS comp_enroll,sum(IF(B.transferType=\'COMP_PRIZE\',B.transferAmount,0)) AS comp_prize,username FROM '.$table2.' B WHERE B.creationTime >= :betTime12 AND B.creationTime <= :betTime22 ' . $where2 . ' GROUP BY B.playerName) Y GROUP BY Y.playerName';
}

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
					  <!--td style="color:<?=$rows['sum_comp_enroll'] < 0 ? '#0000ff' : ''?>"><?=sprintf('%.2f',$rows['sum_comp_enroll']);?></td> 
					  <td style="color:<?=$rows['sum_comp_prize'] < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$rows['sum_comp_prize']);?></td></td--> 
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
					  <!--td style="color:<?=$sum_comp_enroll < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$sum_comp_enroll);?></td> 
					  <td style="color:<?=$sum_comp_prize < 0 ? '#0000ff' : '';?>"><?=sprintf('%.2f',$sum_comp_prize);?></td--> 
				  </tr> 
			  </table> 
		  </td> 
	  </tr> 
  </table> 
</div> 
</body> 
</html>