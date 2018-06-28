<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cpgl');
$type = $_GET['type'];
$type == '' ? $se1 = '#FF0' : $se1 = '#FFF';
$type == '幸运飞艇' ? $se4 = '#FF0' : $se4 = '#FFF';
include '../../include/pager.class.php';
$id = 0;
$qishu = 0;
$lotteryType  = isset($_GET['lottery_type']) ? $_GET['lottery_type'] : 'xyft';
$lotteryNames = array('xyft' => '幸运飞艇', 'jsft' => '极速飞艇');

if (0 < $_GET['id']){
	$id = intval($_GET['id']);
}

if (($_GET['action'] == 'cancel') && (0 < $id)){
	check_quanxian('cpcd');
	cancel_order($id,$lotteryNames,$lotteryType);
	message('操作成功');
}

if (0 < $_GET['qishu']){
	$qishu = $_GET['qishu'];
}

if (($_GET['action'] == 'cancel_qishu') && (0 < $qishu)){
	check_quanxian('cpcd');
	$params = array(':qishu' => $qishu);
	$sql = "select * from c_bet_3 where type='$lotteryType' and qishu=:qishu";
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$countflag = 0;
	while ($rows = $stmt->fetch()){
		$id = $rows['id'];
		cancel_order($id,$lotteryNames,$lotteryType);
		$countflag++;
	}
	message('操作成功:' . $countflag . '条注单被撤销！');
}
?> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>Welcome</title> 
<link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" /> 
</head> 
<script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
<script language="javascript"> 
function go(value){ 
  if(value != "") location.href=value;
  else return false;
} 

function check(){ 
  if($("#tf_id").val().length > 5){ 
	  $("#status").val("0,1");
  } 
  return true;
} 
</script> 
<script language="JavaScript" src="/js/calendar.js"></script> 
<body> 
<div id="pageMain"> 
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5"> 
  <tr> 
	<td valign="top">
	<?php include_once 'Menu_Order.php';?>     
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9"> 
   <form name="form1" method="get" action="<?=$_SERVER['REQUEST_URI'];?>" onSubmit="return check();">
	<tr> 
	  <td align="center" bgcolor="#FFFFFF">
          <select name="lottery_type" id="lottery_type" style="display: none">
              <option value="<?php echo $lotteryType ?>"
                      style="color:#FF0000;" <?= $_GET['lottery_type'] ? 'selected' : '' ?>>
                  彩票类型
              </option>
          </select>
	  	  <select name="js" id="js"> 
		 	<option value="0" style="color:#FF9900;" <?=$_GET['js']=='0' ? 'selected' : ''?>>未结算注单</option>
            <option value="1" style="color:#FF0000;" <?=$_GET['js']=='1' ? 'selected' : ''?>>已结算注单</option>
            <option value="0,1" <?=$_GET['js']=='0,1' ? 'selected' : ''?>>全部注单</option>
          </select>&nbsp;&nbsp;
           期号：<input name="qishu" type="text" id="qishu" value="<?=$_GET['qishu']?>" style="width:100px">&nbsp;&nbsp;
          会员：<input name="username" type="text" id="username" value="<?=$_GET['username']?>" size="15">
          &nbsp;&nbsp;
		  日期：
          <input name="s_time" type="text" id="s_time" value="<?=$_GET['s_time']?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />
            ~
          <input name="e_time" type="text" id="e_time" value="<?=$_GET['e_time']?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />&nbsp;&nbsp;注单号：
          <input name="tf_id" type="text" id="tf_id" value="<?=@$_GET['tf_id']?>" size="22">
          &nbsp;&nbsp;
          <input type="submit" name="Submit" value="搜索"> 
	  </td> 
    </tr>    
	</form> 
  </table> 
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9"> 
	<tr> 
	  <td align="center" bgcolor="#FFFFFF"> 
		期号：<input name="cancel_qishu" id="cancel_qishu" type="text" size="15"> 
		  <input type="button" name="Submit" value="撤销当期注单" onClick="cancle_qishu_check(<?php echo '"' . $_GET['lottery_type'] . '"' ?>);"></td>
	  </tr>  
	  <script> 
		  function cancle_qishu_check(lotteryType)
		  { 
			  var qishu = parseInt($('#cancel_qishu').val());
			  if(qishu == null || qishu =="") 
			  { 
				  alert("请输入要撤销的期号！");
				  return false;
			  } 
			  if(isNaN(qishu)) 
			  { 
				  alert("请输入正确的期号！");
				  return false;
			  } 
		  if(confirm('您确定要撤销【'+qishu+'】期注单？撤销后金额将重算并退回！')) 
				  location.href='Order8.php?lottery_type=' + lotteryType + '&action=cancel_qishu&qishu='+qishu+'&page=<?=$_REQUEST['page'];?>';
		  } 
	  </script> 
  </table> 
	  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;" bgcolor="#798EB9">    
		  <tr style="background-color:#3C4D82;color:#FFF"> 
			<td align="center"><strong>订单号</strong></td> 
			<td align="center"><strong>开奖结果</strong></td> 
			<td align="center"><strong>彩票期号</strong></td> 
			<td align="center"><strong>投注玩法</strong></td> 
			<td align="center"><strong>投注内容</strong></td> 
			<td align="center"><strong>投注金额</strong></td> 
			<td align="center"><strong>赔率</strong></td> 
	  <td height="25" align="center"><strong>输赢结果</strong></td> 
	  <td align="center"><strong>投注时间(北京/美东)</strong></td> 
	  <td align="center"><strong>投注账号</strong></td> 
	  <td height="25" align="center"><strong>状态</strong></td> 
	  <td height="25" align="center"><strong>操作</strong></td> 
	  </tr>
<?php 
$uid = '';
if ($_GET['username']){
	$params = array(':username' => $_GET['username']);
	$sql = 'select uid from k_user where username=:username limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$uid = $stmt->fetchColumn();
}

$params = array();
$sql = "select id from c_bet_3 where money>0 and type='$lotteryNames[$lotteryType]' ";
if ($type){
	$params[':type'] = $type;
	$sql .= ' and type=:type';
}

if ($uid){
	$params[':uid'] = $uid;
	$sql .= ' and uid=:uid';
}

if (trim($_GET['qishu'])){
	$params[':qishu'] = trim($_GET['qishu']);
	$sql .= ' and qishu=:qishu';
}

if ($_GET['s_time']){
	$params[':s_time'] = $_GET['s_time'] . ' 00:00:00';
	$sql .= ' and addtime>=:s_time';
}

if ($_GET['e_time']){
	$params[':e_time'] = $_GET['e_time'] . ' 23:59:59';
	$sql .= ' and addtime<=:e_time';
}

if ($_GET['js'] != '0,1'){
	$params[':js'] = $_GET['js'];
	$sql .= ' and `js`=:js';
}

if ($_GET['tf_id']){
	$params[':tf_id'] = $_GET['tf_id'];
	$sql .= ' and id=:tf_id';
}
$sql .= ' order by id desc ';
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
$bid = '';
$i = 1;
$start = (($thisPage - 1) * $pagenum) + 1;
$end = $thisPage * $pagenum;
while ($row = $stmt->fetch()){
	if (($start <= $i) && ($i <= $end)){
		$bid .= intval($row['id']) . ',';
	}
	
	if ($end < $i){
		break;
	}
	$i++;
}

if ($bid){
	$bid = rtrim($bid, ',');
	$sql = 'select * from c_bet_3 where id in(' . $bid . ') order by id desc';
	$query = $mydata1_db->query($sql);
	$paicai = 0;
	$sum_tz = 0;
	$sum_pc = 0;
	while ($rows = $query->fetch()){
		$color = '#FFFFFF';
		$over = '#EBEBEB';
		$out = '#ffffff';
		if ($rows['js'] == 0)
		{
			$paicai = 0;
		}else if ($rows['win'] == 0){
			$paicai = $rows['money'];
		}else if ($rows['win'] < 0){
			$paicai = 0;
		}else{
			$paicai = $rows['win'];
		}
		$sum_tz += $rows['money'];
		$sum_pc += $paicai;
?>      
	<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over;?>'" onMouseOut="this.style.backgroundColor='<?=$out;?>'" style="background-color:<?=$color;?>;line-height:20px;"> 
	  <td height="25" align="center" valign="middle"><?=$rows['id'];?></td> 
	  <td align="center" valign="middle"><?=$rows['jieguo'];?></td> 
	  <td align="center" valign="middle"><?=$rows['qishu'];?></td> 
	  <td align="center" valign="middle"><?=$rows['mingxi_1'];?></td> 
	  <td align="center" valign="middle"><?=$rows['mingxi_2'];?></td> 
	  <td align="center" valign="middle"><?=sprintf('%.2f',$rows['money']);?></td> 
	  <td align="center" valign="middle"><?=sprintf('%.2f',$rows['odds']);?></td> 
	  <td align="center" valign="middle"><?=sprintf('%.2f',$paicai);?></td> 
	  <td><?=date('Y-m-d H:i:s',strtotime($rows['addtime'])+1*12*3600).'<br>'.$rows['addtime'];?></td> 
	  <td><?=$rows['username'];?></td> 
	  <td>
	  <?php 
	  if ($rows['js'] == 0){
	  	echo '<font color="#0000FF">未结算</font>';
	  }
	  
	  if ($rows['js'] == 1){
	  	echo '<font color="#FF0000">已结算</font>';
	  }
	  ?> 
	  </td> 
	  <td><a href="javascript:void(0);" onClick="if(confirm('您确定要撤销该注单？撤销后金额将重算并退回！'))location.href='?action=cancel&id=<?=$rows['id'];?>&page=<?=$_REQUEST['page'];?>';">撤销</a></td> 
	  </tr><?php }
}?> 	  <tr style="background-color:#FFFFFF;"> 
	  <td colspan="12" align="center" valign="middle">本页投注总金额：<?=sprintf('%.2f',$sum_tz);?>元&nbsp;&nbsp;派彩总金额：<?=sprintf('%.2f',$sum_pc);?>元&nbsp;&nbsp;赢利总金额：<?=sprintf('%.2f',$sum_tz -$sum_pc);?>元</td> 
  </tr> 
  <tr style="background-color:#FFFFFF;"> 
	  <td colspan="12" align="center" valign="middle"><?=$pageStr;?></td> 
	  </tr> 
  </table></td> 
  </tr> 
</table> 
</div> 
</body> 
</html>
<?php 
function cancel_order($id,$lotteryName, $lotteryType){
	global $mydata1_db;
	$params = array(':id' => $id);
	$sql = "select * from c_bet_3 where type='$lotteryName[$lotteryType]' and id=:id";
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rs = $stmt->fetch();

	if ($rs){
		$qishu = $rs['qishu'];
		$kuid = $rs['uid'];
		$kusername = $rs['username'];
		$money = $rs['money'];
		$win = $rs['win'];
		$js = $rs['js'];
		$remoney = $money;
		if (($js == 1) && (0 < $win))
		{
			$remoney = $remoney - $win;
		}
		$params = array(':id' => $id);
		$sql = "delete from c_bet_3 where type='$lotteryName[$lotteryType]' and id=:id";
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$params = array(':money' => $remoney, ':uid' => $kuid);
		$sql = 'update k_user set money=money+:money where uid=:uid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':uid' => $kuid, ':userName' => $kusername, ':transferOrder' => $id, ':transferAmount' => $remoney, ':transferAmount2' => $remoney, ':creationTime' => $creationTime, ':quid' => $kuid);
		$sql = "INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)
		SELECT :uid,:userName,'XYFT','CANCEL_BET',:transferOrder,:transferAmount,money-:transferAmount2,money,:creationTime FROM k_user WHERE uid=:quid";
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		include_once '../../class/admin.php';
		$message = '撤销[' . $kusername . ']'.$lotteryName[$lotteryType].'期号[' . $qishu . ']注单[' . $id . '],[注单金额:' . $money . ',可赢金额:' . $win . ',结算状态:' . $js . '],退回金额:' . $remoney;
		admin::insert_log($_SESSION['adminid'], $message);
	}
}
?>