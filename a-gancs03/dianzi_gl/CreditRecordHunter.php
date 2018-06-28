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
if(isset($_GET["type"]) && $_GET['type']){
    $type = $_GET['type'];
}
$table = 'huntertransferdetail';
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
							  <a href="CreditRecord.php?type=1" class="sel_btn">AG(XIN,BG,街机)</a>
                              &nbsp;<a href="CreditRecord.php?type=8" class="sel_btn">新MG电子</a>
                              &nbsp;<a href="CreditRecord.php?type=14" class="sel_btn">新PT电子</a>
                              &nbsp;<a href="CreditRecord.php?type=3" class="sel_btn">MW电子</a>
                              &nbsp;<a href="CreditRecord.php?type=4" class="sel_btn">AV女优</a>
                              &nbsp;<a href="CreditRecord.php?type=7" class="sel_btn">CQ9电子</a>
                              &nbsp;<a href="CreditRecord.php?type=12" class="sel_btn">BG捕鱼</a>
                              &nbsp;<a href="CreditRecord.php?type=13" class="sel_btn">申博电子(RT,LAX)</a>
                              &nbsp;<a href="CreditRecord.php?type=15" class="sel_btn">开元棋牌</a>
                              &nbsp;<a href="CreditRecordHunter.php" class="sel_btn ch_cls">AG捕鱼</a>
                              &nbsp;<a href="CreditRecord.php?type=6" class="sel_btn old">MG电子</a>
                              &nbsp;<a href="CreditRecord.php?type=5" class="sel_btn old">PT电子</a>
                              <input type="hidden" name="type" value="<?php echo $type;?>">
                          </td>
                      </tr>
				  	  <tr> 
						  <td align="left"> 
							  <span style="color:#FF0000;font-weight:700;font-size:14px;">郑重声明：该部分转帐是"AG国际厅"与"AG捕鱼王"之间的转换，和"体育/彩票"无关；特此声明，请无混淆!!</span>
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
								  <option value="">1.全部</option> 
								  <option value="IN" <?=$transferType=="IN" ? 'selected' : '';?>>2.AG国际厅 -> AG捕鱼王</option> 
								  <option value="OUT" <?=$transferType=="OUT" ? 'selected' : '';?>>3.AG捕鱼王 -> AG国际厅</option> 
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
	if($transferType=='IN'){
		$where .= ' and A.transferAmount>0';
	}elseif($transferType=='OUT'){
		$where .= ' and A.transferAmount<=0';
	}
}

$params[':betTime1'] = $betTime1;
$params[':betTime2'] = $betTime2;
$sql = 'select A.id from '.$table.' A left outer join k_user B on A.uid=B.uid where A.creationTime>=:betTime1 and A.creationTime<=:betTime2 ' . $where . ' order by A.id desc';
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
					  <td>
					  <?
					  	if($rows['transferAmount']>0){
					  		echo "AG国际厅 -> AG捕鱼王";
					  	}else{
					  		echo "AG捕鱼王 -> AG国际厅";
					  	}
					  ?>
					  </td> 
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