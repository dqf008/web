<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('bbgl');
include '../../include/pager.class.php';
include 'CommonFun.php';
$username = trim($_GET['username']);
$tradeNo = trim($_GET['tradeNo']);
$transferType = $_GET['transferType'];
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
    '1' => 'agintransferdetail', //AG国际
    '2' => 'agtransferdetail',   //AG极速
    '3' => 'bbtransferdetail',   //BB波音
    '4' => 'ogtransferdetail',   //OG东方
    //'5' => 'hgtransferdetail',   //HG名人
    '7' => 'ag_zhenren_zz', //玛雅娱乐
    '8' => 'mgtransferdetail',//MG真人电游
    '9' => 'pttransferdetail',//PT真人电游
    '10' => 'ag_zhenren_zz',
    '11' => 'ag_zhenren_zz',
    '12' => 'ag_zhenren_zz',
    '13' => 'ag_zhenren_zz',
    '14' => 'ag_zhenren_zz',
    '15' => 'ag_zhenren_zz',
    '16' => 'ag_zhenren_zz',
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
        .old {
        	background:#ccc ;
        	border-color:#ccc;
        }
        .ch_cls{
            background:#ff0000 !important;
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
                              &nbsp;<a href="CreditRecord.php?type=2" class="sel_btn <?php if($type == 2){ echo 'ch_cls';}?>">AG极速厅</a>
                              &nbsp;<a href="CreditRecord.php?type=16" class="sel_btn <?php if($type == 16){ echo 'ch_cls';}?>">新BB波音厅</a>
                              &nbsp;<a href="CreditRecord.php?type=14" class="sel_btn <?php if($type == 14){ echo 'ch_cls';}?>">新OG东方厅</a>
                              &nbsp;<a href="CreditRecord.php?type=7" class="sel_btn <?php if($type == 7){ echo 'ch_cls';}?>">玛雅娱乐厅</a>
                              &nbsp;<a href="CreditRecord.php?type=11" class="sel_btn <?php if($type == 11){ echo 'ch_cls';}?>">VR彩票</a>
                              &nbsp;<a href="CreditRecord.php?type=12" class="sel_btn <?php if($type == 12){ echo 'ch_cls';}?>">BG视讯</a>
                              &nbsp;<a href="CreditRecord.php?type=13" class="sel_btn <?php if($type == 13){ echo 'ch_cls';}?>">申博视讯</a>
                              &nbsp;<a href="CreditRecord.php?type=15" class="sel_btn <?php if($type == 15){ echo 'ch_cls';}?>">DG视讯</a>
                              &nbsp;<a href="CreditRecord.php?type=10" class="sel_btn old <?php if($type == 10){ echo 'ch_cls';}?>">MG欧美厅</a>
                              &nbsp;<a href="CreditRecord.php?type=9" class="sel_btn old <?php if($type == 9){ echo 'ch_cls';}?>">PT真人电游</a>
                              &nbsp;<a href="CreditRecord.php?type=4" class="sel_btn old <?php if($type == 4){ echo 'ch_cls';}?>">OG东方厅</a>
                              &nbsp;<a href="CreditRecord.php?type=3" class="sel_btn old <?php if($type == 3){ echo 'ch_cls';}?>">BB波音厅</a>
                              <input type="hidden" name="type" value="<?php echo $type;?>">
                          </td>
                      </tr>
					  <tr> 
						  <td align="left"> 
							  会员 
							  <input name="username" type="text" id="username" value="<?=$username;?>" size="12" /> 
							  &nbsp;&nbsp;交易单号 
							  <input name="tradeNo" type="text" id="tradeNo" value="<?=$tradeNo;?>" size="16" /> 
							  &nbsp;&nbsp;交易类型 
							  <select name="transferType" id="transferType">
                                  <?php if($type <= 5){ ?>
								  <option value="">1.全部</option> 
								  <option value="IN" <?=$transferType=="IN" ? 'selected' : '';?>>2.转入额度</option> 
								  <option value="OUT" <?=$transferType=="OUT" ? 'selected' : '';?>>3.转出额度</option> 
								  <option value="DONATEFEE" <?=$transferType=="DONATEFEE" ? 'selected' : '';?>>4.玩家小费</option> 
								  <option value="RED_POCKET" <?=$transferType=="RED_POCKET" ? 'selected' : '';?>>5.红包</option> 
								  <option value="COMP_ENROLL" <?=$transferType=="RED_POCKET" ? 'selected' : '';?>>6.赌王报名</option> 
								  <option value="COMP_PRIZE" <?=$transferType=="RED_POCKET" ? 'selected' : '';?>>7.赌王奖金</option> 
								  <option value="COMP_REFUND" <?=$transferType=="RED_POCKET" ? 'selected' : '';?>>8.赌王退款</option>
                                  <?php }else{ ?>
                                      <option value="">1.全部</option>
                                      <option value="IN" <?=$transferType=="IN" ? 'selected' : '';?>>2.转入额度</option>
                                      <option value="OUT" <?=$transferType=="OUT" ? 'selected' : '';?>>3.转出额度</option>
                                  <?php }?>
							  </select> 
						  </td> 
					  </tr> 
					  <tr> 
						  <td align="left"> 
							  交易时间 
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
					  <td>会员账号 /<br>真人账号</td> 
					  <td>交易单号 /<br>转账编号</td> 
					  <td>交易时间</td> 
					  <td>交易类别</td> 
					  <td>交易前余额</td> 
					  <td>交易额度</td> 
					  <td>交易后额度</td> 
					  <td>平台类型</td> 
				  </tr>
<?php 
$where = '';
$params = array();
if ($username != ''){
	$params[':username'] = $username;
	$where .= ' and B.username=:username';
}

if ($tradeNo != ''){
	$params[':tradeNo'] = $tradeNo;
	$where .= ' and A.tradeNo=:tradeNo';
}

if ($transferType != ''){
	$params[':transferType'] = $transferType;
	$where .= ' and A.transferType=:transferType';
}

$params[':betTime1'] = $betTime1;
$params[':betTime2'] = $betTime2;

if($type==7 || $type==10 || $type==11) {

	
}

switch($type){
	case 7: $sql = 'select A.id from ag_zhenren_zz A left outer join k_user B on A.uid=B.uid where A.live_type="MAYA" and ok=1 and A.zz_time>=:betTime1 and A.zz_time<=:betTime2 ' . $where . ' order by A.id desc';break;
	case 10: $sql = 'select A.id from ag_zhenren_zz A left outer join k_user B on A.uid=B.uid where A.live_type="MG2" and ok=1 and A.zz_time>=:betTime1 and A.zz_time<=:betTime2 ' . $where . ' order by A.id desc';break;
	case 11: $sql = 'select A.id from ag_zhenren_zz A left outer join k_user B on A.uid=B.uid where A.live_type="VR" and ok=1 and A.zz_time>=:betTime1 and A.zz_time<=:betTime2 ' . $where . ' order by A.id desc';break;
	case 12: $sql = 'select A.id from ag_zhenren_zz A left outer join k_user B on A.uid=B.uid where A.live_type="BGLIVE" and ok=1 and A.zz_time>=:betTime1 and A.zz_time<=:betTime2 ' . $where . ' order by A.id desc';break;
	case 13: $sql = 'select A.id from ag_zhenren_zz A left outer join k_user B on A.uid=B.uid where A.live_type="SB" and ok=1 and A.zz_time>=:betTime1 and A.zz_time<=:betTime2 ' . $where . ' order by A.id desc';break;
	case 14: $sql = 'select A.id from ag_zhenren_zz A left outer join k_user B on A.uid=B.uid where A.live_type="OG2" and ok=1 and A.zz_time>=:betTime1 and A.zz_time<=:betTime2 ' . $where . ' order by A.id desc';break;
	case 15: $sql = 'select A.id from ag_zhenren_zz A left outer join k_user B on A.uid=B.uid where A.live_type="DG" and ok=1 and A.zz_time>=:betTime1 and A.zz_time<=:betTime2 ' . $where . ' order by A.id desc';break;
	case 16: $sql = 'select A.id from ag_zhenren_zz A left outer join k_user B on A.uid=B.uid where A.live_type="BBIN2" and ok=1 and A.zz_time>=:betTime1 and A.zz_time<=:betTime2 ' . $where . ' order by A.id desc';break;
	default: $sql = 'select A.id from '.$table.' A left outer join k_user B on A.uid=B.uid where A.creationTime>=:betTime1 and A.creationTime<=:betTime2 ' . $where . ' order by A.id desc';
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
$sql = 'select A.*,B.username from '.$table.' A left outer join k_user B on A.uid=B.uid where A.id in(' . $id . ') order by A.id desc';
if(in_array($type, [7, 10, 11, 12, 13, 14, 15, 16])){
	$sql = 'select A.id,A.uid,A.zz_type as transferType,A.billno as  tradeNo,A.zz_money as transferAmount,A.moneyA as previousAmount,A.moneyB as currentAmount, A.zz_time as creationTime,A.live_type as platformType, A.zr_username as playerName,B.username from '.$table.' A left outer join k_user B on A.uid=B.uid where A.id in(' . $id . ') order by A.id desc';
}
$query = $mydata1_db->query($sql);
while ($rows = $query->fetch()){
	$color = '#FFFFFF';
	$over = '#EBEBEB';
	$out = '#ffffff';
?>					  
				  <tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;line-height:20px;height:25px;"> 
					  <td><?=$rows['username'];?>/<br><?=$rows['playerName'];?></td> 
					  <td><?=$rows['tradeNo'];?>/<br><?=$rows['transferId'];?></td> 
					  <td><?=$rows['creationTime'];?></td> 
					  <td><?=getTransferType($rows['transferType']);?></td> 
					  <td><?=sprintf('%.2f',$rows['previousAmount']);?></td> 
					  <td><?=sprintf('%.2f',$rows['transferAmount']);?></td> 
					  <td><?=sprintf('%.2f',$rows['currentAmount']);?></td> 
					  <td><?=$rows['platformType'];?></td> 
				  </tr>
<?php }
}?> 					  <tr style="background-color:#FFFFFF;"> 
					  <td colspan="12" align="center"><?=$pageStr;?></td> 
				  </tr> 
			  </table> 
		  </td> 
	  </tr> 
  </table> 
</div> 
</body> 
</html>