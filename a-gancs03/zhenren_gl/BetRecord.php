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

$platformtype = trim($_GET['platformtype']);

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
        	border-color:#ccc ;
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
                                     <a href="BetRecord.php?type=1" class="sel_btn <?php if($type == 1){ echo 'ch_cls';}?>">AG国际厅</a>
                              &nbsp;<a href="BetRecord.php?type=2" class="sel_btn <?php if($type == 2){ echo 'ch_cls';}?>">AG极速厅</a>
                              &nbsp;<a href="BetRecord.php?type=16" class="sel_btn <?php if($type == 16){ echo 'ch_cls';}?>">新BB波音厅</a>
                              &nbsp;<a href="BetRecord.php?type=14" class="sel_btn <?php if($type == 14){ echo 'ch_cls';}?>">新OG东方厅</a>
                              &nbsp;<a href="BetRecord.php?type=7" class="sel_btn <?php if($type == 7){ echo 'ch_cls';}?>">玛雅娱乐厅</a>
                              &nbsp;<a href="BetRecord.php?type=11" class="sel_btn <?php if($type == 11){ echo 'ch_cls';}?>">VR彩票</a>
                              &nbsp;<a href="BetRecord.php?type=12" class="sel_btn <?php if($type == 12){ echo 'ch_cls';}?>">BG视讯</a>
                              &nbsp;<a href="BetRecord.php?type=13" class="sel_btn <?php if($type == 13){ echo 'ch_cls';}?>">申博视讯</a>
                              &nbsp;<a href="BetRecord.php?type=15" class="sel_btn <?php if($type == 15){ echo 'ch_cls';}?>">DG视讯</a>
                              &nbsp;<a href="BetRecord.php?type=10" class="sel_btn old <?php if($type == 10){ echo 'ch_cls';}?>">MG欧美厅</a>
                              &nbsp;<a href="BetRecord.php?type=9" class="sel_btn old <?php if($type == 9){ echo 'ch_cls';}?>">PT真人电游</a>
                              &nbsp;<a href="BetRecord.php?type=4" class="sel_btn old <?php if($type == 4){ echo 'ch_cls';}?>">OG东方厅</a>
                              &nbsp;<a href="BetRecord.php?type=3" class="sel_btn old <?php if($type == 3){ echo 'ch_cls';}?>">BB波音厅</a>
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
                                  <?php if($type == 1 || $type == 2): ?>
                                      <option value="百家乐" <?=$gameType=="百家乐" ? 'selected' : '';?>>1.百家乐</option>
                                      <option value="包桌百家乐" <?=$gameType=="包桌百家乐" ? 'selected' : '';?>>2.包桌百家乐</option>
                                      <option value="连环百家乐" <?=$gameType=="连环百家乐" ? 'selected' : '';?>>3.连环百家乐</option>
                                      <option value="龙虎" <?=$gameType=="龙虎" ? 'selected' : '';?>>4.龙虎</option>
                                      <option value="骰宝" <?=$gameType=="骰宝" ? 'selected' : '';?>>5.骰宝</option>
                                      <option value="轮盘" <?=$gameType=="轮盘" ? 'selected' : '';?>>6.轮盘</option>
                                      <option value="番摊" <?=$gameType=="番摊" ? 'selected' : '';?>>7.番摊</option>
                                      <option value="竞咪百家乐" <?=$gameType=="竞咪百家乐" ? 'selected' : '';?>>8.竞咪百家乐</option>
                                      <option value="终极德州扑克" <?=$gameType=="终极德州扑克" ? 'selected' : '';?>>9.终极德州扑克</option>
                                  <?php elseif($type == 4):?>
                                      <option value="百家乐" <?=$gameType=='百家乐' ? 'selected' : '';?>>1.百家乐</option>
                                      <option value="龙虎" <?=$gameType=='龙虎' ? 'selected' : '';?>>2.龙虎</option>
                                      <option value="骰宝" <?=$gameType=='骰宝' ? 'selected' : '';?>>3.骰宝</option>
                                      <option value="轮盘" <?=$gameType=='轮盘' ? 'selected' : '';?>>4.轮盘</option>
                                      <option value="番摊" <?=$gameType=='番摊' ? 'selected' : '';?>>5.番摊</option>
                                      <option value="德州扑克" <?=$gameType=='德州扑克' ? 'selected' : '';?>>6.德州扑克</option>
                                  <?php elseif($type == 5):?>
                                      <option value="百家乐" <?=$gameType=='百家乐' ? 'selected' : '';?>>1.百家乐</option>
                                      <option value="龙虎" <?=$gameType=='龙虎' ? 'selected' : '';?>>2.龙虎</option>
                                      <option value="骰宝" <?=$gameType=='骰宝' ? 'selected' : '';?>>3.骰宝</option>
                                      <option value="轮盘" <?=$gameType=='轮盘' ? 'selected' : '';?>>4.轮盘</option>
                                      <option value="番摊" <?=$gameType=='番摊' ? 'selected' : '';?>>5.番摊</option>
                                      <option value="德州扑克" <?=$gameType=='德州扑克' ? 'selected' : '';?>>6.德州扑克</option>
                                  <?php endif;?>
							  </select> 
							  <?php if($type == 16):?>
							  &nbsp;&nbsp;平台类型
							   <select name="platformtype" id="platformtype">
                                    <option value="">1.全部</option>
                                    <option value="LIVE" <?=$platformtype=='LIVE'?'selected':''?>>2.真人</option>
                                    <option value="GAME" <?=$platformtype=='GAME'?'selected':''?>>3.电子</option>
                                    <option value="LOTTERY" <?=$platformtype=='LOTTERY'?'selected':''?>>4.彩票</option>
                                    <option value="SPORT" <?=$platformtype=='SPORT'?'selected':''?>>5.体育</option>
                               </select>
							  <?php endif;?>
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
					  <?php if($type!='11'):?><td>桌号</td><?php endif;?>
					  <td>游戏类型</td>
					  <td>下注玩法</td> 
					  <?php if($type!='11'):?><td>平台类型</td><?php endif;?>
					  <td>订单状态</td>
					  <?php if($type!='11'):?><td>下注前额度</td><?php endif;?>
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
switch ($type) {
	case 10:
		$sql = 'select A.id from '.$table.' A left outer join k_user B on A.uid=B.uid where A.betTime>=:betTime1 and A.betTime<=:betTime2 ' . $where . ' and platformtype="LIVE" order by A.betTime desc';
		break;
	case 12:
		$sql = 'select A.id from '.$table.' A left outer join k_user B on A.uid=B.uid where A.betTime>=:betTime1 and A.betTime<=:betTime2 ' . $where . ' and platformtype="BGLIVE" order by A.betTime desc';
		break;
	case 13:
		$sql = 'select A.id from '.$table.' A left outer join k_user B on A.uid=B.uid where A.betTime>=:betTime1 and A.betTime<=:betTime2 ' . $where . ' and platformtype="SB" order by A.betTime desc';
		break;
	case 16:
		if($platformtype != ''){
			$params[':platformtype'] = $platformtype;
			$where .= ' and A.platformtype=:platformtype';
		}
		$sql = 'select A.id from '.$table.' A left outer join k_user B on A.uid=B.uid where A.betTime>=:betTime1 and A.betTime<=:betTime2 ' . $where . ' order by A.betTime desc';
		break;
	default:
		$sql = 'select A.id from '.$table.' A left outer join k_user B on A.uid=B.uid where A.betTime>=:betTime1 and A.betTime<=:betTime2 ' . $where . ' order by A.betTime desc';
		break;
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
while ($rows = $query->fetch(PDO::FETCH_ASSOC))
{
	$color = '#FFFFFF';
	$over = '#EBEBEB';
	$out = '#ffffff';
	if($rows['flag']!='撤单'){
		$sum_betAmount += $rows['betAmount'];
		$sum_validBetAmount += $rows['validBetAmount'];
		$sum_netAmount += $rows['netAmount'];
	}
?>					  
	<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;line-height:20px;height:25px;"> 
	  <td><?=$rows['username'];?>/<br><?=$rows['playerName'];?></td> 
	  <td><?=$rows['billNo'];?>/ <br><?=$rows['gameCode'];?></td> 
	  <?php if($type!='11'):?><td><?=$rows['tableCode'];?></td><?php endif;?>
	  <td><?=$rows['gameType'];?></td> 
	  <td><?=$rows['playType'];?></td> 
	  <?php if($type!='11'):?><td><?=$rows['platformType'];?></td><?php endif;?>
	  <td><?=$rows['flag'];?></td>
	  <?php if($type!='11'):?><td><?=empty($rows['beforeCredit'])?'--':sprintf('%.2f',$rows['beforeCredit'])?></td><?php endif;?>
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