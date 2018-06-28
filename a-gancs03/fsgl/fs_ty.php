<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('fsgl');
$time = $_GET['time'];
$time = ($time == '' ? 'EN' : $time);
$bdate = $_GET['bdate'];
$bdate = ($bdate == '' ? date('Y-m-d', time() - (24 * 3600)) : $bdate);
$bhour = $_GET['bhour'];
$bhour = ($bhour == '' ? '00' : $bhour);
$bsecond = $_GET['bsecond'];
$bsecond = ($bsecond == '' ? '00' : $bsecond);
$edate = $_GET['edate'];
$edate = ($edate == '' ? date('Y-m-d', time() - (24 * 3600)) : $edate);
$ehour = $_GET['ehour'];
$ehour = ($ehour == '' ? '23' : $ehour);
$esecond = $_GET['esecond'];
$esecond = ($esecond == '' ? '59' : $esecond);
$btime = $bdate . ' ' . $bhour . ':' . $bsecond . ':00';
$etime = $edate . ' ' . $ehour . ':' . $esecond . ':59';
$username = $_GET['username'];
$group = $_GET['group'];
$agent = $_GET['agent'];
$fsfs = intval($_GET['fsfs']);
$fsfs = ($fsfs == 0 ? 1 : $fsfs);
$addfs = intval($_GET['addfs']);
if ($addfs == 1){
	$fs_num = intval($_POST['fs_num']);
	$fs_btime = $_POST['fs_btime'];
	$fs_etime = $_POST['fs_etime'];
	$fs_fs = intval($_POST['fs_fs']);
	$fs_order = 'TY' . date('ymdHis') . rand(10, 99);
	if ($fs_num == 0){
		message('没有记录，无需返水！', 'fs_ty.php');
	}
	
	for ($i = 0;$i < $fs_num;$i++){
		$uid = intval($_POST['uid_' . $i]);
		$username = $_POST['username_' . $i];
		$num = intval($_POST['num_' . $i]);
		$bet_money = floatval($_POST['bet_money_' . $i]);
		$yx_bet_money = floatval($_POST['yx_bet_money_' . $i]);
		$yingli = floatval($_POST['yingli_' . $i]);
		$fs_name = $_POST['fs_name_' . $i];
		$fs_rate = floatval($_POST['fs_rate_' . $i]);
		$fs = floatval($_POST['fs_' . $i]);
		if (0 < $fs){
			$params = array(':uid' => $uid, ':username' => $username, ':fs_btime' => $fs_btime, ':fs_etime' => $fs_etime, ':fs_fs' => $fs_fs, ':num' => $num, ':bet_money' => $bet_money, ':yx_bet_money' => $yx_bet_money, ':yingli' => $yingli, ':fs_name' => $fs_name, ':fs_rate' => $fs_rate, ':fs' => $fs, ':fs_order' => $fs_order);
			$sql = 'insert into fs_account (uid,username,fs_btime,fs_etime,fs_fs,fs_cz,bet_num,bet_money,yx_money,yingli,fs_name,fs_rate,fs_money,fs_order)';
			$sql .= ' value(:uid,:username,:fs_btime,:fs_etime,:fs_fs,\'体育\',:num,:bet_money,:yx_bet_money,:yingli,:fs_name,:fs_rate,:fs,:fs_order)';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$fs_id = $mydata1_db->lastInsertId();
			$sql = 'select money from k_user where uid=\'' . $uid . '\'';
			$query = $mydata1_db->query($sql);
			$row = $query->fetch();
			if ($row == NULL){
				continue;
				goto label270;
			}
			label270: $assets = $row['money'];
			$balance = $assets + $fs;
			$m_order = $username . '_tyfs_' . $fs_id;
			$params = array(':uid' => $uid, ':fs' => $fs, ':m_order' => $m_order, ':assets' => $assets, ':balance' => $balance);
			$sql = 'insert into k_money (uid,m_value,m_order,status,about,type,sxf,assets,balance)';
			$sql .= ' value(:uid,:fs,:m_order,\'2\',\'体育自动返水[管理员结算]\',\'5\',\'0\',:assets,:balance)';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$m_id = $mydata1_db->lastInsertId();
			$params = array(':m_id' => $m_id);
			$sql = 'update k_money,k_user set k_money.status=1,k_money.update_time=now(),k_user.money=k_user.money+k_money.m_value,k_money.balance=k_user.money+k_money.m_value where k_money.uid=k_user.uid and k_money.m_id=:m_id and k_money.`status`=2';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$creationTime = date('Y-m-d H:i:s');
			$params = array(':creationTime' => $creationTime, ':m_id' => $m_id);
			$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'FANSHUI\',\'IN\',k_money.m_order,k_money.m_value,k_user.money-k_money.m_value,k_user.money,:creationTime FROM k_user,k_money WHERE k_user.uid=k_money.uid AND k_money.status=1 AND k_money.m_id=:m_id';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			goto label321;
		}
		label321: 
	}
	message('返水成功！返水批次号是：' . $fs_order, 'fs_ty.php');
}

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
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="font12" style="border:1px solid #798EB9;">
	  <form name="form1" method="get" action="">
	  <tr bgcolor="#FFFFFF">
		  <td align="left">
			  <select name="time" id="time" disabled="disabled">
				  <option value="CN" <?=$time=='CN' ? 'selected' : ''?>>中国时间</option>
				<option value="EN" <?=$time=='EN' ? 'selected' : ''?>>美东时间</option>
			  </select>
			  &nbsp;开始日期
			  <input name="bdate" type="text" id="bdate" value="<?=$bdate?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />
			  <select name="bhour" id="bhour">
			  <?php 
				for ($i = 0;$i < 24;$i++){
					$list=$i<10?"0".$i:$i;
			  ?>					  
			  <option value="<?=$list?>" <?=$bhour==$list?"selected":""?>><?=$list?></option>
			  <?php }?> 				  
			  </select>
			  &nbsp;时
			  <select name="bsecond" id="bsecond">
			  <?php 
				for ($i = 0;$i < 60;$i++){
					$list=$i<10?"0".$i:$i;
			  ?>					  
			  <option value="<?=$list?>" <?=$bsecond==$list?"selected":""?>><?=$list?></option>
			  <?php }?> 				  
			  </select>
			  &nbsp;分
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
			  &nbsp;时
			  <select name="esecond" id="esecond">
			  <?php
				for($i=0;$i<60;$i++){
					$list=$i<10?"0".$i:$i;
			  ?>
				<option value="<?=$list?>" <?=$esecond==$list?"selected":""?>><?=$list?></option>
			  <?php } ?>
			  </select>&nbsp;分
		  </td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		  <td align="left">
			  &nbsp;返水彩种
			  <input name="fscz" type="checkbox" checked="checked" value="ty" disabled="disabled" />体育
			  <input name="fsfs" type="radio" <?=$fsfs==1?"checked":""?> value="1" />按有效投注
			  <input name="fsfs" type="radio" <?=$fsfs==2?"checked":""?> value="2" />按实际输赢
			  &nbsp;会员名称
			  <input name="username" type="text" id="username" value="<?=$username?>" size="15" maxlength="20"/>
			  <input type="hidden" name="ok" id="ok" value="1" />
		  </td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		  <td align="left">
			  &nbsp;其它设定
			  <select name="group" id="group">
			  <option value="" <?=$group==''?"selected":""?>>全部会员组</option>
			  <?php 
			  $stmt = $mydata1_db->query('SELECT `id`, `name` FROM `k_group` ORDER BY `id` ASC');
			  $group_list = array();
				while($rows = $stmt->fetch()){
					$group_list[$rows['id']] = $rows['name'];
			  ?>
			  <option value="<?=$rows['id']?>" <?=$group==$rows['id']?"selected":""?>><?=$rows['name']?></option>
			  <?php }?>
			  </select>
			  <select name="agent" id="agent">
			  <option value="" <?=$agent==''?"selected":""?>>全部代理</option>
			  <?php 
			  $stmt = $mydata1_db->query('SELECT `uid`, `username` FROM `k_user` WHERE `is_daili`=1 AND `is_stop`=0 AND `is_delete`=0 ORDER BY `uid` ASC');
			  $agent_list = array();
				while($rows = $stmt->fetch()){
					$agent_list[$rows['uid']] = $rows['username'];
			  ?>
			  <option value="<?=$rows['uid']?>" <?=$agent==$rows['uid']?"selected":""?>><?=$rows['username']?></option>
			  <?php }?>
			  </select>
			  &nbsp;<input name="find" type="submit" id="find" value="计算返水"/>
		  </td>
	  </tr>
	  </form>
  </table>
  <?php if (intval($_GET['ok']) == 1){?> 	  
  <script type="text/javascript">
	  function add_fs() {
		  return confirm('点击确定返水金额将直接返到用户账户！\n\n如已返水请勿重复返水！\n\n是否确定要执行返水？') ? true : false;
	  }
  </script>
  <form name="form2" method="post" action="?addfs=1" onSubmit="return add_fs();">
  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;line-height:20px;" bgcolor="#798EB9">
	  <tr align="center" style="background:#3C4D82;color:#ffffff;">
		  <td>会员账号</td>
		  <td>会员组</td>
		  <td>上级代理</td>
		  <td>笔数</td>
		  <td>下注金额</td>
		  <td>有效投注</td>
		  <td>网站盈利</td>
		  <td>返水等级</td>
		  <td>返水比例</td>
		  <td>返水金额</td>
	  </tr>
	  <?php 
		$color = '#FFFFFF';
		$over = '#EBEBEB';
		$out = '#ffffff';
		if ($time == 'CN'){
			$q_btime = date('Y-m-d H:i:s', strtotime($btime) - (12 * 3600));
			$q_etime = date('Y-m-d H:i:s', strtotime($etime) - (12 * 3600));
		}else{
			$q_btime = $btime;
			$q_etime = $etime;
		}
		$params = array();
		$sqlwhere = '';
		if ($username != ''){
			$params[':username'] = $username;
			$params[':username2'] = $username;
			$sqlwhere .= ' and u.username=:username';
			$sqlwhere2 .= ' and u.username=:username2';
		}
		if ($group != ''){
			$params[':group'] = $group;
			$params[':group2'] = $group;
			$sqlwhere .= ' and u.gid=:group';
			$sqlwhere2 .= ' and u.gid=:group2';
		}
		if ($agent != ''){
			$params[':agent'] = $agent;
			$params[':agent2'] = $agent;
			$sqlwhere .= ' and u.top_uid=:agent';
			$sqlwhere2 .= ' and u.top_uid=:agent2';
		}
		$params[':q_btime'] = $q_btime;
		$params[':q_etime'] = $q_etime;
		$params[':q_btime2'] = $q_btime;
		$params[':q_etime2'] = $q_etime;
		$sql = 'select uid,username,sum(num) as num,sum(bet_money) as bet_money,sum(yx_bet_money) as yx_bet_money,sum(bet_money-win-fs) as yingli, gid, top_uid from (';
		$sql .= 'select u.uid,username,1 as num,bet_money as bet_money,if(status=1 or status=2 or status=4 or status=5,bet_money,0) as yx_bet_money,win as win,fs as fs, u.gid, u.top_uid from k_bet k left join k_user u on k.uid=u.uid where lose_ok=1 and status in (1,2,3,4,5,6,7,8) and k.bet_time>=:q_btime and k.bet_time<=:q_etime ' . $sqlwhere;
		$sql .= ' union all ';
		$sql .= 'select u.uid,username,1 as num,bet_money as bet_money,if(status=1,bet_money,0) as yx_bet_money,win as win,fs as fs, u.gid, u.top_uid from k_bet_cg_group k left join k_user u on k.uid=u.uid where k.gid>0 and status in (1,3,4) and k.bet_time>=:q_btime2 and k.bet_time<=:q_etime2 ' . $sqlwhere2;
		$sql .= ') temp group by uid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$sum_num = 0;
		$sum_bet_money = 0;
		$sum_yx_bet_money = 0;
		$sum_yingli = 0;
		$sum_fs = 0;
		$i = 0;
		while ($row = $stmt->fetch()){
			$bet_money = sprintf('%.2f', $row['bet_money']);
			$yx_bet_money = sprintf('%.2f', $row['yx_bet_money']);
			$yingli = sprintf('%.2f', $row['yingli']);
			$sum_num += $row['num'];
			$sum_bet_money += $bet_money;
			$sum_yx_bet_money += $yx_bet_money;
			$sum_yingli += $yingli;
			if ($fsfs == 1)
			{
				$dml = $yx_bet_money;
				$fs_params = array(':dml' => $dml);
				$fs_sql = 'select * from fs_level where type=1 and dml<=:dml order by dml desc limit 1';
			}else{
				$dml = $yingli;
				$fs_params = array(':dml' => $dml);
				$fs_sql = 'select * from fs_level where type=1 and win<=:dml order by win desc limit 1';
			}
			$fs_stmt = $mydata1_db->prepare($fs_sql);
			$fs_stmt->execute($fs_params);
			$fs_sum = $fs_stmt->rowCount();
			if ($fs_sum == 1)
			{
				$fs_row = $fs_stmt->fetch();
				$fs_name = $fs_row['name'];
				$fs_rate = $fs_row['ty_rate'];
			}else{
				$fs_name = '无';
				$fs_rate = 0;
			}
			$fs = sprintf('%.2f', ($dml * $fs_rate) / 100)
?>		  
		<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over?>'" onMouseOut="this.style.backgroundColor='<?=$out?>'" style="background-color:<?=$color?>;">
		  <td><?=$row["username"]?>
			<input type="hidden" name="username_<?=$i?>" id="username_<?=$i?>" value="<?=$row["username"]?>" />
			<input type="hidden" name="uid_<?=$i?>" id="uid_<?=$i?>" value="<?=$row["uid"]?>" /></td>
		<td><?=$group_list[$row["gid"]]?></td>
		<td><?=$agent_list[$row["top_uid"]]?></td>
		<td><?=$row["num"]?><input type="hidden" name="num_<?=$i?>" id="num_<?=$i?>" value="<?=$row["num"]?>" /></td>
		<td><?=$bet_money?><input type="hidden" name="bet_money_<?=$i?>" id="bet_money_<?=$i?>" value="<?=$bet_money?>" /></td>
		<td><?=$yx_bet_money?><input type="hidden" name="yx_bet_money_<?=$i?>" id="yx_bet_money_<?=$i?>" value="<?=$yx_bet_money?>" /></td>
		<td><?=$yingli?><input type="hidden" name="yingli_<?=$i?>" id="yingli_<?=$i?>" value="<?=$yingli?>" /></td>
		<td><?=$fs_name?><input type="hidden" name="fs_name_<?=$i?>" id="fs_name_<?=$i?>" value="<?=$fs_name?>" /></td>
		<td><?=$fs_rate?>%<input type="hidden" name="fs_rate_<?=$i?>" id="fs_rate_<?=$i?>" value="<?=$fs_rate?>" /></td>
		<td><input type="text" name="fs_<?=$i?>" id="fs_<?=$i?>" value="<?=$fs?>" size="8" maxlength="10" /></td>
	  </tr>
<?php 
	$i++;
}
?> 		  
	 <tr align="center" style="background:#ffffff;color:#ff0000;">
		  <td colspan="3">合计</td>
		  <td><?=$sum_num?></td>
		  <td><?=sprintf("%.2f",$sum_bet_money)?></td>
		<td><?=sprintf("%.2f",$sum_yx_bet_money)?></td>
		<td><?=sprintf("%.2f",$sum_yingli)?></td>
		  <td colspan="3">
			  <input type="hidden" name="fs_num" id="fs_num" value="<?=$i?>" />
			  <input type="hidden" name="fs_btime" id="fs_btime" value="<?=$q_btime?>" />
			  <input type="hidden" name="fs_etime" id="fs_etime" value="<?=$q_etime?>" />
			  <input type="hidden" name="fs_fs" id="fs_fs" value="<?=$fsfs?>" />
		  </td>
	  </tr>
	  <tr align="center" style="background:#ffffff;color:#ff0000;">
		  <td colspan="11"><input name="account" type="submit" id="account" value="返水到会员账户"/></td>
	  </tr>
  </table>
  </form>
  <?php }?> 
 </div>
</div>
</body>
</html>