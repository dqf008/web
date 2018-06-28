<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cwgl');
$time = $_GET['time'];

$time = ($time == '' ? 'EN' : $time);
$status = $_GET['status'];
$order = $_GET['order'];
switch ($order){
	case 'm_value': case 'sxf': case 'm_id': break;
	default: $order = 'm_id';
	break;
}

$bdate = $_GET['bdate'];
$bdate = ($bdate == '' ? date('Y-m-d') : $bdate);
$bhour = $_GET['bhour'];
$bhour = ($bhour == '' ? '00' : $bhour);
$bsecond = $_GET['bsecond'];
$bsecond = ($bsecond == '' ? '00' : $bsecond);
$edate = $_GET['edate'];
$edate = ($edate == '' ? date('Y-m-d') : $edate);
$ehour = $_GET['ehour'];
$ehour = ($ehour == '' ? '23' : $ehour);
$esecond = $_GET['esecond'];
$esecond = ($esecond == '' ? '59' : $esecond);
$username = $_GET['username'];
$btime = $bdate . ' ' . $bhour . ':' . $bsecond . ':00';
$etime = $edate . ' ' . $ehour . ':' . $esecond . ':59';
$kgroup = array();
$sql = 'select id,name from k_group ';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute();
$kgnum = 0;
if(empty($_GET['find'])){
	$_GET['start_m'] = $_COOKIE['tx_s'];
	$_GET['end_m'] = $_COOKIE['tx_e'];
}
$start_m = (int)$_GET['start_m'];
$end_m = (int)$_GET['end_m'];

setcookie('tx_s',$_GET['start_m']);
setcookie('tx_e',$_GET['end_m']);


while ($row = $stmt->fetch()){
	$kgroup[$kgnum]['id'] = $row['id'];
	$kgroup[$kgnum]['name'] = $row['name'];
	$kgnum++;
}
$groupid = $_GET['groupid'];
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>用户提现申请</TITLE> 
<script language="javascript"> 
function go(value) { 
	location.href=value;
} 
</script> 
<style type="text/css"> 
body { 
  margin: 0px;
} 
td{font:13px/120% "宋体";padding:3px;} 
a{ 
  color:#F37605;
  text-decoration: none;
} 
.t-title{background:url(../images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
</STYLE> 
</HEAD> 

<body> 
<script language="JavaScript" src="../../js/calendar.js"></script> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><font ><span class="STYLE2">提现管理：查看所有的用户提款记录</span></font></td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="100%" cellspacing="0" cellpadding="0" border="0"> 
   <form name="form1" method="GET" action="tixian.php" > 
	<tr> 
	  <td align="left">
	  <select name="order" id="order"> 
	  	<option value="m_id" <?=$order=='m_id' ? 'selected' : ''?>>默认排序</option>
        <option value="m_value" <?=$order=='m_value' ? 'selected' : ''?>>提款金额</option>
        <option value="sxf" <?=$order=='sxf' ? 'selected' : ''?>>手续费</option> 
	  </select> 
	  &nbsp;
	  <select name="status" id="status"> 
		  <option value="2" <?=$status=='2' ? 'selected' : ''?> style="color:#FF9900;">未处理</option>
          <option value="0" <?=$status=='0' ? 'selected' : ''?> style="color:#FF0000;">提款失败</option>
          <option value="1" <?=$status=='1' ? 'selected' : ''?> style="color:#006600;">提款成功</option>
          <option value="3" <?=$status=='3' ? 'selected' : ''?>>全部提款</option>
	  </select> 
	  &nbsp;
	  <select name="time" id="time"> 
		  <option value="CN" <?=$time=='CN' ? 'selected' : ''?>>中国时间</option>
          <option value="EN" <?=$time=='EN' ? 'selected' : ''?>>美东时间</option>
	  </select> 
	  &nbsp;会员名称 
	  <input name="username" type="text" id="username" value="<?=$_GET['username']?>" size="15" maxlength="20"/> 
	  &nbsp;编号 
	  <input name="m_id" type="text" id="m_id" value="<?=$_GET['m_id']?>" size="15" maxlength="20"/> 
	  &nbsp;会员组 
	  <select name="groupid" id="groupid"> 
		  <option value="" <?=$groupid=="" ? 'selected' :' '?>>全部</option>
		  <?php 	  
			for ($i = 0;$i < $kgnum;$i++){
		  ?> 			  
		  <option value="<?=$kgroup[$i]['id']?>" <?=$groupid==$kgroup[$i]['id'] ? "selected" : "" ?>><?=$kgroup[$i]['name']?></option>
		  <?php 
		  }
		  ?> 		  
	  </select> 
	  </tr> 
	  <tr> 
	  <td align="left">开始日期 
		<input name="bdate" type="text" id="bdate" value="<?=$bdate?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" /> 
		<select name="bhour" id="bhour">
		<?php 
		for ($i = 0;$i < 24;$i++){
			$list=$i<10?"0".$i:$i;
		?>			  
		<option value="<?=$list?>" <?=$bhour==$list?"selected":""?>><?=$list?></option>
		<?php 
		}
		?> 		  
		</select> 
	  	时 
	  	<select name="bsecond" id="bsecond">
		<?php 
		for ($i = 0;$i < 60;$i++){
			$list=$i<10?"0".$i:$i;
		?>			  
		<option value="<?=$list?>"<?=$bsecond==$list ? "selected" : "" ?>><?=$list?></option>
		<?php 
		}
		?> 		  
		</select> 
	  	分 
	  	&nbsp;结束日期 
		<input name="edate" type="text" id="edate" value="<?=$edate?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" /> 
		<select name="ehour" id="ehour">
		<?php 
		for ($i = 0;$i < 24;$i++){
			$list=$i<10?"0".$i:$i;
		?>			  
		<option value="<?=$list?>" <?=$ehour==$list?"selected":""?>><?=$list?></option>
		<?php }?> 		  
		</select> 
	  	时 
	  	<select name="esecond" id="esecond">
		<?php 
		for ($i = 0;$i < 60;$i++){
			$list=$i<10?"0".$i:$i;
		?>			  
		<option value="<?=$list?>" <?=$esecond==$list?"selected":""?>><?=$list?></option>
		<?php }?> 		  
		</select> 
	  	分
        选择金额范围：<input type="text" name="start_m" value="<?php echo $_GET['start_m'];?>" size="8">-<input type="text" name="end_m" value="<?php echo $_GET['end_m'];?>" size="8">
	  	&nbsp;<input name="find" type="submit" id="find" value="查找"/> 
	  </td> 
	  </tr> 
	  <tr><td>
		<div id="date_quick"></div>
	  	<script type="text/javascript" src="/skin/js/jquery-1.7.2.min.js"></script>
	  	<script type="text/javascript">
	  		$(function(){
		  		var time = <?=time()?>;
	  			$("#date_quick").html('快速日期选择：<button value="0">今日</button><button value="1">昨日</button><button value="2">一周</button><button value="3">本月</button><button value="4">上月</button><button value="5">六个月</button><button value="6">一年</button>');
	  			$("#date_quick button").css('margin-right','10px');
	  			$("#date_quick button").click(function(){
	  				switch($(this).val()){
	  					case "0":
	  						$('#bdate').val('<?=date('Y-m-d')?>');
	  						$('#edate').val('<?=date('Y-m-d')?>');
	  						break;
	  					case "1":
	  						$('#bdate').val('<?=date('Y-m-d',strtotime('-1 day'))?>');
	  						$('#edate').val('<?=date('Y-m-d',strtotime('-1 day'))?>');
	  						break;
	  					case "2":
	  						$('#bdate').val('<?=date('Y-m-d',strtotime('-6 day'))?>');
	  						$('#edate').val('<?=date('Y-m-d')?>');
	  						break;
	  					case "3":
	  						$('#bdate').val('<?=date('Y-m-01')?>');
	  						$('#edate').val('<?=date('Y-m-t')?>');
	  						break;
	  					case "4":
	  						$('#bdate').val('<?=date("Y-m-01",strtotime("last month"))?>');
	  						$('#edate').val('<?=date("Y-m-t",strtotime("last month"))?>');
	  						break;
	  					case "5":
	  						$('#bdate').val('<?=date("Y-m-01",strtotime("-5 month"))?>');
	  						$('#edate').val('<?=date("Y-m-t")?>');
	  						break;
	  					case "6":
	  						$('#bdate').val('<?=date("Y-m-01",strtotime("-11 month"))?>');
	  						$('#edate').val('<?=date("Y-m-t")?>');
	  						break;
	  					default:return;
	  				}
	  			});
	  		});
	  	</script>
	  </td></tr>
  </form> 
  </table>
  </td> 
</tr> 
</table> 
<br> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"> 
   
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" > 
	<tr bgcolor="efe" class="t-title" align="center"> 
	  <td width="5%" ><strong>编号</strong></td>
	  <td width="15%" ><strong>订单号/申请时间/分组</strong></td>
	  <td width="8%"><strong>提款金额</strong></td>
	  <td width="6%"><strong>手续费</strong></td>
	  <td width="6%"><strong>查看财务</strong></td>
	  <td width="15%" ><strong>开户行/卡号</strong></td> 
	  <td width="19%" ><strong>开户人/开户地址</strong></td> 
	  <td width="8%" ><strong>额度记录</strong></td>
        <td width="15%" ><strong>出款说明</strong></td>
	  <td width="6%" ><strong>操作</strong></td> 
	  </tr>
	  <?php 
	  	include_once '../../include/newpage.php';
		$params = array();
		$sqlwhere = '';
		if ($status != 3){
			$params[':status'] = $status;
			$sqlwhere .= ' and status=:status';
		}
		
		if ($username != ''){
			$params[':username'] = $username;
			$sqlwhere .= ' and uid=(select uid from k_user where username=:username)';
		}
		
		if ($groupid != ''){
			$params[':gid'] = $groupid;
			$sqlwhere .= ' and uid in (select uid from k_user where gid=:gid) ';
		}
		
		if ($time == 'CN'){
			$q_btime = date('Y-m-d H:i:s', strtotime($btime) + (12 * 3600));
			$q_etime = date('Y-m-d H:i:s', strtotime($etime) + (12 * 3600));
		}else{
			$q_btime = $btime;
			$q_etime = $etime;
		}
		
		if($start_m>0){
			$sqlwhere .= " and abs(m_value) >= {$start_m} ";
		}
		
		if($end_m>0){
			$sqlwhere .= " and abs(m_value) <= {$end_m} ";
		}


		$params[':q_btime'] = $q_btime;
		$params[':q_etime'] = $q_etime;
		
		if ($_GET['m_id'] != ''){
			$params = array();
			$params[':m_id'] = trim($_GET['m_id']);
			$sqlwhere = ' and m_id=:m_id';
			$sql = 'select m_id from k_money where `type`=2 ' . $sqlwhere . ' order by ' . $order . ' desc';
		}else{
			$sql = 'select m_id from k_money where `type`=2 ' . $sqlwhere . ' and `m_make_time`>=:q_btime and `m_make_time`<=:q_etime order by ' . $order . ' desc';
		}
        //echo $sql;die;
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$sum = $stmt->rowCount();
		$thisPage = 1;
		if ($_GET['page']){
			$thisPage = $_GET['page'];
		}
		
		$page = new newPage();
		$thisPage = $page->check_Page($thisPage, $sum, 20, 40);
		$mid = '';
		$i = 1;
		$start = (($thisPage - 1) * 20) + 1;
		$end = $thisPage * 20;
		while ($row = $stmt->fetch()){
			if (($start <= $i) && ($i <= $end)){
				$mid .= intval($row['m_id']) . ',';
			}
			
			if ($end < $i){
				break;
			}
			$i++;
		}
		$c_sum = $m_sum = $t_sum = $f_sum = $sxf_sum = 0;
		if ($mid){
		$mid = rtrim($mid, ',');
		$arr = array();
		$sql = 'select k_money.*,k_user.username,k_user.pay_name,k_group.name from k_money left outer join k_user on k_money.uid=k_user.uid left join k_group on k_user.gid = k_group.id  where m_id in ('.$mid.') order by '.$order.' desc';
		$query = $mydata1_db->query($sql);
		while ($rows = $query->fetch()){
			$money = abs($rows['m_value']);
			$m_sum += $money;
			$sxf_sum += $rows['sxf']
?>      
	<tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#ffffff'"> 
	  <td height="20" align="center"  ><?=$rows['m_id']?></td> 
	  <td><?=$rows['pay_name'];?><br><a href="tixian_show.php?id=<?=$rows["m_id"]?>"><?=$rows["m_order"]?></a><br/><?=$time=='CN' ? get_bj_time($rows["m_make_time"]) : $rows["m_make_time"]?><br/><?=$rows['name'];?></td>
	  <td><span style="color:#999999;"><?=sprintf("%.2f",$rows["assets"])?></span><br /><?=sprintf("%.2f",$money)?><br /><span style="color:#999999;"><?=sprintf("%.2f",$rows["balance"])?></span></td> 
	  <td><?=sprintf("%.2f",$rows["sxf"])?></td> 
	  <td><a href="hccw.php?username=<?=$rows['username']?>">查看财务</a></td> 
	  <td><?=$rows['pay_card']?><br/><?=$rows['pay_num']?></td> 
	  <td><?=$rows['pay_name']?><br/><?=$rows['pay_address']?></td>
      <td><a href="money_log.php?username=<?=$rows['username']?>">额度记录</a></td>
        <td><?=$rows['about']?></td>
	  <td>
	  <?php 
	  if ($rows['status'] == 0){
		$f_sum += $money
	  ?>
	  <span style="color:#FF0000;">提款失败</span>
	  <?php
	  }else if ($rows['status'] == 1){
		$t_sum += $money
	  ?>
	  <span style="color:#006600;">提款成功</span>
	  <?php 
	  }else{
		$c_sum += $money?><a href="tixian_show.php?id=<?=$rows['m_id']?>">结算</a>
	  <?php }?> 
	    </td> 
	  </tr>
	  <?php 
	  }
}
?>     
</table>
</td> 
</tr> 
<tr> 
  <td style="line-height:24px;"><div>总金额：<span style="color:#0000FF"><?=sprintf("%.2f",$m_sum)?></span>，成功：<span style="color:#006600"><?=sprintf("%.2f",$t_sum)?></span>，手续费：<span style="color:#FF00FF"><?=sprintf("%.2f",$sxf_sum)?></span>，失败：<span style="color:#FF0000"><?=sprintf("%.2f",$f_sum)?></span>，审核：<span style="color:#FF9900"><?=sprintf("%.2f",$c_sum)?></span>&nbsp;&nbsp;&nbsp;&nbsp;</div>
	<div><?=$page->get_htmlPage($_SERVER["REQUEST_URI"]);?></div></td>
</tr> 
</table>
<?php 
if ($username){
?> 
<br />
<?=$username?>历史银行卡信息：<br /> 
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" >       
<tr style="background-color: #EFE" class="t-title"  align="center"> 
  <td width="15%"><strong>开户人</strong></td> 
  <td width="15%"><strong>开户行</strong></td> 
  <td width="20%"><strong>银行卡号</strong></td> 
  <td width="35%"><strong>开户地址</strong></td> 
  <td width="15%"><strong>添加日期</strong></td> 
</tr>
<?php 
$params = array(':username' => trim($_GET['username']));
$sql = 'SELECT pay_name,pay_card,pay_num,pay_address,addtime FROM history_bank where username=:username order by uid asc,id desc';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
while ($row = $stmt->fetch()){
?>   
<tr onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;"> 
  <td height="30" align="center"><?=$row['pay_name']?></td> 
  <td align="center"><?=$row['pay_card']?></td> 
  <td align="center"><?=$row['pay_num']?></td> 
  <td align="center"><?=$row['pay_address']?></td> 
  <td align="center"><?=$row['addtime']?></td> 
</tr>
<?php
	}
}
?> 
</table> 
</body> 
</html>
<?php 
function getstatus($status){
	$return = '';
	switch ($status)
	{
		case 0: $return = '失败';
		break;
		case 1: $return = '成功';
		break;
		case 2: $return = '待处理';
		break;
		default: break;
	}
	return $return;
}
?>