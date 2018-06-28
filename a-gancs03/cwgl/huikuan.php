<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cwgl');
$time = $_GET['time'];
$time = ($time == '' ? 'CN' : $time);
$status = $_GET['status'];
$order = $_GET['order'];
switch ($order){
	case 'id': case 'money': case 'zsjr': break;
	default: $order = 'id';
	break;
}
$bdate = $_GET['bdate'];
$bdate = ($bdate == '' ? date('Y-m-d', time() + (12 * 3600)) : $bdate);
$bhour = $_GET['bhour'];
$bhour = ($bhour == '' ? '00' : $bhour);
$bsecond = $_GET['bsecond'];
$bsecond = ($bsecond == '' ? '00' : $bsecond);
$edate = $_GET['edate'];
$edate = ($edate == '' ? date('Y-m-d', time() + (12 * 3600)) : $edate);
$ehour = $_GET['ehour'];
$ehour = ($ehour == '' ? '23' : $ehour);
$esecond = $_GET['esecond'];
$esecond = ($esecond == '' ? '59' : $esecond);
$username = $_GET['username'];
$btime = $bdate . ' ' . $bhour . ':' . $bsecond . ':00';
$etime = $edate . ' ' . $ehour . ':' . $esecond . ':59';
$bank = $_GET['bank'];
if(empty($_GET['find'])){
	$_GET['start_m'] = $_COOKIE['hk_s'];
	$_GET['end_m'] = $_COOKIE['hk_e'];
}
$start_m = (int)$_GET['start_m'];
$end_m = (int)$_GET['end_m'];

setcookie('hk_s',$_GET['start_m']);
setcookie('hk_e',$_GET['end_m']);

?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>用户汇款申请</TITLE> 
<script language="javascript"> 
function go(value) 
{ 
location.href=value;
} 
</script> 
<style type="text/css"> 
<STYLE> 
BODY { 
SCROLLBAR-FACE-COLOR: rgb(255,204,0);
SCROLLBAR-3DLIGHT-COLOR: rgb(255,207,116);
SCROLLBAR-DARKSHADOW-COLOR: rgb(255,227,163);
SCROLLBAR-BASE-COLOR: rgb(255,217,93) 
} 
.STYLE2 {font-size: 12px} 
body { 
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
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
  <td height="24" nowrap background="../images/06.gif"><font ><span class="STYLE2">汇款管理：查看所有的用户汇款信息</span></font></td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="100%" cellspacing="0" cellpadding="0" border="0"> 
   <form name="form1" method="GET" action="huikuan.php" > 
	<tr> 
	  <td align="left">
	  <select name="order" id="order"> 
	    <option value="id" <?=$order=='id' ? 'selected' : ''?>>默认排序</option>
        <option value="money" <?=$order=='money' ? 'selected' : ''?>>汇款金额</option>
        <option value="zsjr" <?=$order=='zsjr' ? 'selected' : ''?>>赠送金额</option> 
	  </select> 
	  &nbsp;
	  <select name="status" id="status"> 
		<option value="0" <?=$status=='0' ? 'selected' : ''?> style="color:#FF9900;">未处理</option>
        <option value="2" <?=$status=='2' ? 'selected' : ''?> style="color:#FF0000;">汇款失败</option>
        <option value="1" <?=$status=='1' ? 'selected' : ''?> style="color:#006600;">汇款成功</option>
        <option value="3" <?=$status=='3' ? 'selected' : ''?>>全部汇款</option> 
	  </select> 
	  &nbsp;
	  <select name="time" id="time"> 
		  <option value="CN" <?=$time=='CN' ? 'selected' : ''?>>中国时间</option>
          <option value="EN" <?=$time=='EN' ? 'selected' : ''?>>美东时间</option>
	  </select> 
	  &nbsp;会员名称 
	  <input name="username" type="text" id="username" value="<?=$_GET['username']?>" size="15" maxlength="20"/> 
	  &nbsp;编号 
	  <input name="id" type="text" id="id" value="<?=$_GET['id']?>" size="15" maxlength="20"/></td> 
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
		<?php }?> 		  
		</select> 
	    时 
	    <select name="bsecond" id="bsecond">
	    <?php 
		for ($i = 0;$i < 60;$i++){
			$list=$i<10?"0".$i:$i;
	   ?>			  
	   <option value="<?=$list?>" <?=$bsecond==$list?"selected":""?>><?=$list?></option>
	   <?php }?> 		  
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
	  分   选择金额范围：<input type="text" name="start_m" value="<?php echo $_GET['start_m'];?>" size="8">-<input type="text" name="end_m" value="<?php echo $_GET['end_m'];?>" size="8">
          &nbsp;<input name="find" type="submit" id="find" value="查找"/>
	  </td> 
	  </tr> 
	  <tr>
		<td>
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
	  	</td>
	  </tr>
  </form> 
  </table></td> 
</tr> 
</table> 
<br> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"> 
   
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" > 
	<tr bgcolor="efe" class="t-title" align="center"> 
	  <td width="5%" height="24" ><strong>编号</strong></td> 
	  <td width="20%" ><strong>真实姓名：订单号/提交时间/分组</strong></td>
	  <td width="10%"><strong>充值金额</strong></td> 
	  <td width="10%"><strong>赠送金额</strong></td> 
	  <td width="10%"><strong>查看财务</strong></td> 
	  <td width="10%" ><strong>汇款银行</strong></td> 
	  <td width="27%" ><strong>汇款方式/汇款地址</strong></td> 
	  <td width="8%" ><strong>操作</strong></td> 
	  </tr>
	<?php 
	include_once '../../include/newpage.php';
	$params = array();
	$sqlwhere = '';
	if ($status != 3){
		$params[':status'] = $status;

		$sqlwhere .= ' and status=:status ';
	}
	
	if ($username != ''){
		$params[':username'] = $username;
		$sqlwhere .= ' and uid=(select uid from k_user where username=:username)';
	}
	
	if ($bank != ''){
		$params[':bank'] = $bank;
		$sqlwhere .= ' and bank=:bank';
	}
	
	if ($time == 'CN'){
		$q_btime = date('Y-m-d H:i:s', strtotime($btime) - (12 * 3600));
		$q_etime = date('Y-m-d H:i:s', strtotime($etime) - (12 * 3600));
	}else{
		$q_btime = $btime;
		$q_etime = $etime;
	}
	$params[':q_btime'] = $q_btime;
	$params[':q_etime'] = $q_etime;

    /*if($start_m != '' && $end_m > 0 ){
        //$params[':start_m'] = $start_m;
        //$params[':end_m']  = $end_m;
        //print_r($params);die;
        $sqlwhere .= " and money > {$start_m} and money < {$end_m} ";
    }*/
	if($start_m>0){
		$sqlwhere .= " and money >= {$start_m} ";
	}
	
	if($end_m>0){
		$sqlwhere .= " and money <= {$end_m} ";
	}
	
	
	if ($_GET['id'] != ''){
		$params = array();
		$params[':id'] = trim($_GET['id']);
		$sqlwhere = ' and id=:id';
		$sql = 'select id from huikuan where money>0 ' . $sqlwhere . ' order by ' . $order . ' desc';
	}else{
		$sql = 'select id from huikuan where money>0 ' . $sqlwhere . ' and `adddate`>=:q_btime and `adddate`<=:q_etime order by ' . $order . ' desc';
	}
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$sum = $stmt->rowCount();
	$thisPage = 1;
	if ($_GET['page']){
		$thisPage = $_GET['page'];
	}
	$page = new newPage();
	$thisPage = $page->check_Page($thisPage, $sum, 20, 40);
	$id = '';
	$i = 1;
	$start = (($thisPage - 1) * 20) + 1;
	$end = $thisPage * 20;
	while ($row = $stmt->fetch()){
		if (($start <= $i) && ($i <= $end)){
			$id .= intval($row['id']) . ',';
		}
		
		if ($end < $i){
			break;
		}
		$i++;
	}
	$m_sum = $t_sum = $f_sum = $c_sum = $zs_sum = 0;
	if ($id){
	$id = rtrim($id, ',');
	$arr = array();
	$sql = 'select huikuan.*,k_user.username,k_user.pay_name,k_group.name from huikuan left outer join k_user on huikuan.uid=k_user.uid left join k_group on k_user.gid = k_group.id where huikuan.id in (' . $id . ') order by ' . $order . ' desc';
	$query = $mydata1_db->query($sql);
	while ($rows = $query->fetch()){
		$m_sum += $rows['money'];
		$zs_sum += $rows['zsjr'];
?>       
	<tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#ffffff'" > 
	  <td  height="35" align="center" ><?=$rows['id']?></td> 
	  <td>
		  <?=$rows['pay_name'];?><br/>
		  <a href="hk_look.php?id=<?=$rows["id"]?>"><?=$rows["lsh"]?></a><br/>
		  <?=$time=='CN' ? get_bj_time($rows["adddate"]) : $rows["adddate"]?><br/>
		  <?= $rows['name'];?>
	  </td>
	  <td><span style="color:#999999;"><?=sprintf("%.2f",$rows["assets"])?></span><br /><?=sprintf("%.2f",$rows["money"])?><br /><span style="color:#999999;"><?=sprintf("%.2f",$rows["balance"])?></span></td> 
	  <td><?=sprintf("%.2f",$rows["zsjr"])?></td>
	  <td><a href="hccw.php?username=<?=$rows['username']?>">查看财务</a></td> 
	  <td><a href="<?=$_SERVER['REQUEST_URI']?>&page=&bank=<?=$rows['bank']?>"><?=$rows['bank']?></a></td> 
	  <td><?=$rows['manner']?><br/><?=$rows['address']?></td> 
	  <td>
	<?php 
	  if ($rows['status'] == 1){
		$t_sum += $rows['money'];
	?>
		<span style="color:#006600;">汇款成功</span>
	<?php 
	  }else if ($rows['status'] == 2){
		$f_sum += $rows['money'];
	?>
	<span style="color:#FF0000;">汇款失败</span>
	<?php 
	}else{
		$c_sum += $rows['money'];
	?>
	<span style="color:#FF9900;">审核中</span>
	<?php }?> 
	<br />
	<?php
    $times = time()-strtotime($rows['adddate']);
	if ($rows['status'] && $times<3600){
	?> 
	<a href="hk_rq.php?id=<?=$rows['id']?>&status=<?=$rows['status']?>" onClick="return confirm('您真的要重新结算吗？');">重新结算</a>
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
  <td style="line-height:24px;"><div>总金额：<span style="color:#0000FF"><?=sprintf("%.2f",$m_sum)?></span>，成功：<span style="color:#006600"><?=sprintf("%.2f",$t_sum)?></span>，赠送金额：<span style="color:#FF00FF"><?=sprintf("%.2f",$zs_sum)?></span>，失败：<span style="color:#FF0000"><?=sprintf("%.2f",$f_sum)?></span>，审核：<span style="color:#FF9900"><?=sprintf("%.2f",$c_sum)?></span></div>
	<div><?=$page->get_htmlPage($_SERVER["REQUEST_URI"]);?></div></td> 
</tr> 
</table> 
</body> 
</html>