<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('bbgl');
include '../../include/pager.class.php';
include 'CommonFun.php';
$username = trim($_GET['username']);
$gameCode = trim($_GET['gameCode']);
$billNo = trim($_GET['billNo']);
$gameType = $_GET['gameType'];
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
    '1' => 'xinbetdetail', //AG-Xin
    '2' => 'mgbetdetail',   //MG真人-电游
    '3' => 'ptbetdetail',   //PT真人-电游
    '4' => 'bbbetdetail',   //BBIN真人-电游
    '6' => 'yoplaybetdetail',
    '7' => 'mwbetdetail',
    '8' => 'bgbetdetail',
    '9' => 'kgbetdetail',
    '10' => 'cq9betdetail',
    '11' => 'mg2betdetail',
    '12' => 'bglivebetdetail',
    '13' => 'sbbetdetail',
    '14' => 'pt2betdetail',
    '15' => 'kybetdetail',
);

$table = $type_ids[$type];

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
        	background:#ccc;
        	border-color:#ccc;
        }
        a:hover{
            color:white;
        }
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
                              <a href="BetRecord.php?type=1" class="sel_btn <?php if($type == 1){ echo 'ch_cls';}?>">AG-XIN</a>
                              &nbsp;<a href="BetRecord.php?type=8" class="sel_btn <?php if($type == 8){ echo 'ch_cls';}?>">AG-BG</a>
                              &nbsp;<a href="BetRecord.php?type=6" class="sel_btn <?php if($type == 6){ echo 'ch_cls';}?>">AG-街机</a>
                              &nbsp;<a href="BetRecord.php?type=11" class="sel_btn <?php if($type == 11){ echo 'ch_cls';}?>">新MG电子</a>
                              &nbsp;<a href="BetRecord.php?type=14" class="sel_btn <?php if($type == 14){ echo 'ch_cls';}?>">新PT电子</a>
                              &nbsp;<a href="BetRecord.php?type=7" class="sel_btn <?php if($type == 7){ echo 'ch_cls';}?>">MW电子</a>
                              &nbsp;<a href="BetRecord.php?type=9" class="sel_btn <?php if($type == 9){ echo 'ch_cls';}?>">AV女优</a>
                              &nbsp;<a href="BetRecord.php?type=10" class="sel_btn <?php if($type == 10){ echo 'ch_cls';}?>">CQ9电子</a>
                              &nbsp;<a href="BetRecord.php?type=12" class="sel_btn <?php if($type == 12){ echo 'ch_cls';}?>">BG捕鱼</a>
                              &nbsp;<a href="BetRecord.php?type=13" class="sel_btn <?php if($type == 13){ echo 'ch_cls';}?>">申博电子(RT,LAX)</a>
                              &nbsp;<a href="BetRecord.php?type=15" class="sel_btn <?php if($type == 15){ echo 'ch_cls';}?>">开元棋牌</a>		
							&nbsp;<a href="BetRecordHunter.php?type=5" class="sel_btn">AG捕鱼</a>
                              &nbsp;<a href="BetRecord.php?type=2" class="sel_btn old <?php if($type == 2){ echo 'ch_cls';}?>">MG电子</a>
                              &nbsp;<a href="BetRecord.php?type=3" class="sel_btn old <?php if($type == 3){ echo 'ch_cls';}?>">PT电子</a>
                              <input type="hidden" name="type" value="<?php echo $type;?>">
                          </td>
                      </tr>
					  <tr>
						  <td align="left"> 
							  会员 
							  <input name="username" type="text" id="username" value="<?=$username;?>" size="12" /> 
							  &nbsp;&nbsp;局号 
							  <input name="gameCode" type="text" id="gameCode" value="<?=$gameCode;?>" size="14" /> 
							  &nbsp;&nbsp;订单号 
							  <input name="billNo" type="text" id="billNo" value="<?=$billNo;?>" size="14" /> 
							  &nbsp;&nbsp;游戏类型 
							  <select name="gameType" id="gameType">
                                  <option value="">1.全部</option>
							  </select> 
						  </td> 
					  </tr> 
					  <tr> 
						  <td align="left"> 
							  下注时间 
							  <input name="betDate1" type="text" id="betDate1" value="<?=$betDate1;?>" onClick="new Calendar(2008,2020).show(this);" size="8" maxlength="10" readonly="readonly" /> 
							  <select name="betHour1" id="betHour1">
							  <?php 
								for ($i = 0;$i < 24;$i++){
									$hour = ($i < 10 ? '0' . $i : $i);
							  ?>									  
							  <option value="<?=$hour;?>"<?=$betHour1==$hour ? 'selected' : '';?>><?=$hour;?></option>
							 <?php }?> 								  </select> 
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
								for ($i = 0;$i < 60;$i++){
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
					  <td>会员账号 /<br>真人账号</td> 
					  <td>订单号 /<br>局号</td> 
					  <td>桌号</td> 
					  <td>游戏类型</td> 
					  <td>下注玩法</td> 
					  <td>平台类型</td> 
					  <td>订单状态</td>
					  <td>下注前额度</td> 
					  <td>下注额度</td> 
					  <td>派彩额度</td> 
					  <td>有效投注额度</td> 
					  <td>设备类型</td> 
					  <td>下注时间 /<br>下注IP</td> 
				  </tr>
<?php 
$where = '';
$params = array();
if ($username != ''){
	$params[':username'] = $username;
	$where .= ' and B.username=:username';
}

if ($gameCode != ''){
	$params[':gameCode'] = $gameCode;
	$where .= ' and A.gameCode=:gameCode';
}
if ($billNo != ''){
	$params[':billNo'] = $billNo;
	$where .= ' and A.billNo=:billNo';
}
if ($gameType != ''){
	$params[':gameType'] = $gameType;
	$where .= ' and A.gameType=:gameType';
}
$params[':betTime1'] = $betTime1;
$params[':betTime2'] = $betTime2;
if($type == 11){
	$sql = 'select A.id from '.$table.' A left outer join k_user B on A.uid=B.uid where A.betTime>=:betTime1 and A.betTime<=:betTime2 and platformtype="GAME" ' . $where . ' order by A.betTime desc';
}else if($type == 12){
	$sql = 'select A.id from '.$table.' A left outer join k_user B on A.uid=B.uid where A.betTime>=:betTime1 and A.betTime<=:betTime2 and platformtype="BGFISH" ' . $where . ' order by A.betTime desc';
}else if($type == 13){
	$sql = 'select A.id from '.$table.' A left outer join k_user B on A.uid=B.uid where A.betTime>=:betTime1 and A.betTime<=:betTime2 and platformtype<>"SB" ' . $where . ' order by A.betTime desc';
}else{
	$sql = 'select A.id from '.$table.' A left outer join k_user B on A.uid=B.uid where A.betTime>=:betTime1 and A.betTime<=:betTime2 ' . $where . ' order by A.betTime desc';
}


$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$sum = $stmt->rowCount();
$thisPage = 1;
$pagenum = 50;
if ($_GET['page']){
	$thisPage = $_GET['page'];
}
$CurrentPage = (isset($_GET['page']) ? $_GET['page'] : 1);
$myPage = new pager($sum, intval($CurrentPage), $pagenum);
$pageStr = $myPage->GetPagerContent();
$id = '';
$i = 1;
$start = (($thisPage - 1) * $pagenum) + 1;
$end = $thisPage * $pagenum;
while ($row = $stmt->fetch()){
	if (($start <= $i) && ($i <= $end)){
		$id .= intval($row['id']) . ',';
	}
	if ($end < $i){
		break;
	}
	$i++;
}

if ($id){
$id = rtrim($id, ',');
$sql = 'select A.*,B.username from '.$table.' A left outer join k_user B on A.uid=B.uid where A.id in(' . $id . ') order by A.betTime desc';
$query = $mydata1_db->query($sql);
$sum_betAmount = 0;
$sum_validBetAmount = 0;
$sum_netAmount = 0;
$sum_JackpotSettlement = 0;
while ($rows = $query->fetch())
{
	$color = '#FFFFFF';
	$over = '#EBEBEB';
	$out = '#ffffff';
	$sum_betAmount += $rows['betAmount'];
	$sum_validBetAmount += $rows['validBetAmount'];
	$sum_netAmount += $rows['netAmount'];
?>					  
	<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;line-height:20px;height:25px;"> 
					  <td><?=$rows['username'];?>/<br><?=$rows['playerName'];?></td> 
					  <td><?=$rows['billNo'];?>/ <br><?=$rows['gameCode'];?></td> 
					  <td><?=$rows['tableCode'];?></td> 
					  <td><?=$rows['gameType'];?></td> 
					  <td><?=$rows['playType'];?></td> 
					  <td><?=$rows['platformType'];?></td> 
					  <td><?=$rows['flag'];?></td>
					  <td><?=sprintf('%.2f',$rows['beforeCredit']);?></td> 
					  <td><?=sprintf('%.2f',$rows['betAmount']);?></td> 
					  <td><?=sprintf('%.2f',$rows['netAmount']);?></td> 
					  <td><?=sprintf('%.2f',$rows['validBetAmount']);?></td> 
					  <td><?=$rows['deviceType']?></td> 
					  <td><?=$rows['betTime'];?>/<br><?=$rows['loginIP'];?></td> 
				  </tr>
<?php }
}?> 					  <tr style="background-color:#FFFFFF;"> 
					  <td colspan="13" align="center">本页投注额度：<?=sprintf('%.2f',$sum_betAmount);?>元&nbsp;&nbsp;派彩额度：<?=sprintf('%.2f',$sum_netAmount);?>元&nbsp;&nbsp;有效投注额度：<?=sprintf('%.2f',$sum_validBetAmount);?>元</td> 
				  </tr> 
				  <tr style="background-color:#FFFFFF;"> 
					  <td colspan="13" align="center"><?=$pageStr;?></td> 
				  </tr> 
			  </table> 
		  </td> 
	  </tr> 
  </table> 
</div> 
</body> 
</html>