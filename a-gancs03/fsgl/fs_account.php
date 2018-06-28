<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('fsgl');
$time = $_GET['time'];
$time = ($time == '' ? 'EN' : $time);
$bdate = $_GET['bdate'];
$bdate = ($bdate == '' ? date('Y-m-d', time()) : $bdate);
$bhour = $_GET['bhour'];
$bhour = ($bhour == '' ? '00' : $bhour);
$bsecond = $_GET['bsecond'];
$bsecond = ($bsecond == '' ? '00' : $bsecond);
$edate = $_GET['edate'];
$edate = ($edate == '' ? date('Y-m-d', time()) : $edate);
$ehour = $_GET['ehour'];
$ehour = ($ehour == '' ? '23' : $ehour);
$esecond = $_GET['esecond'];
$esecond = ($esecond == '' ? '59' : $esecond);
$btime = $bdate . ' ' . $bhour . ':' . $bsecond . ':00';
$etime = $edate . ' ' . $ehour . ':' . $esecond . ':59';
$fs_order = trim($_GET['fs_order']);
$fs_cz = $_GET['fs_cz'];
$fs_fs = $_GET['fs_fs'];
$username = trim($_GET['username']);
if (intval($_GET['del']) == 1)
{
	$id = intval($_GET['id']);
	if (0 < $id)
	{
		$sql = 'select * from fs_account where id=\'' . $id . '\'';
		$query = $mydata1_db->query($sql);
		$row = $query->fetch();
		$uid = intval($row['uid']);
		$fs_money = -$row['fs_money'];
		$username = $row['username'];
		$fs_cz_name = $row['fs_cz'];
		switch ($fs_cz_name)
		{
			case '体育': $fs_cz = 'ty';
			break;
			case '彩票': $fs_cz = 'cp';
			break;
			case 'AG国际厅': $fs_cz = 'zr';
			break;
			case 'BB波音厅': $fs_cz = 'zr';
			break;
			case 'OG东方厅': $fs_cz = 'zr';
			break;
			case 'HG名人厅': $fs_cz = 'zr';
			break;
			case '玛雅娱乐厅': $fs_cz = 'zr';
			break;
			case 'AG电子游戏': $fs_cz = 'dz';
			break;
			case 'MG电子游戏': $fs_cz = 'dz';
			break;
			case 'PT电子游戏': $fs_cz = 'dz';
			break;
			case 'WM电子游戏': $fs_cz = 'dz';
			break;
			case 'AG捕鱼王': $fs_cz = 'dz';
			break;
			case 'AG街机': $fs_cz = 'dz';
			break;
			case '沙巴体育': $fs_cz = 'ty';
			break;
			case 'AV女优': $fs_cz = 'dz';
			break;
		}
		$m_order = $username . '_' . $fs_cz . '_cx_' . $id;
		$sql = 'select money from k_user where uid=\'' . $uid . '\'';
		$query = $mydata1_db->query($sql);
		$row = $query->fetch();
		if ($row == NULL)
		{
			message('该用户已被删除！', 'fs_account.php');
		}
		$assets = $row['money'];
		$balance = $assets + $fs_money;
		$params = array(':uid' => $uid, ':fs_money' => $fs_money, ':m_order' => $m_order, ':about' => '撤销' . $fs_cz_name . '自动返水[管理员结算]', ':assets' => $assets, ':balance' => $balance);
		$sql = 'insert into k_money (uid,m_value,m_order,status,about,type,sxf,assets,balance)';
		$sql .= ' value(:uid,:fs_money,:m_order,\'2\',:about,\'5\',\'0\',:assets,:balance)';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$m_id = $mydata1_db->lastInsertId();
		$sql = 'delete from fs_account where id=\'' . $id . '\'';
		$mydata1_db->query($sql);
		$params = array(':m_id' => $m_id);
		$sql = 'update k_money,k_user set k_money.status=1,k_money.update_time=now(),k_user.money=k_user.money+k_money.m_value,k_money.balance=k_user.money+k_money.m_value where k_money.uid=k_user.uid and k_money.m_id=:m_id and k_money.`status`=2';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':creationTime' => $creationTime, ':m_id' => $m_id);
		$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'FANSHUI\',\'CANCEL_IN\',k_money.m_order,k_money.m_value,k_user.money-k_money.m_value,k_user.money,:creationTime FROM k_user,k_money WHERE k_user.uid=k_money.uid AND k_money.status=1 AND k_money.m_id=:m_id';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		message('返水撤销成功！', 'fs_account.php');
	}
}
if (intval($_GET['batdel']) == 1)
{
	$cx_fs_order = trim($_POST['cx_fs_order']);
	if ($cx_fs_order == '')
	{
		message('请输入要撤销的返水批次号');
	}
	$params = array(':fs_order' => $cx_fs_order);
	$sql = 'select * from fs_account where fs_order=:fs_order';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	while ($row = $stmt->fetch())
	{
		$id = intval($row['id']);
		$uid = intval($row['uid']);
		$fs_money = -$row['fs_money'];
		$username = $row['username'];
		$fs_cz_name = $row['fs_cz'];
		switch ($fs_cz_name)
		{
			case '体育': $fs_cz = 'ty';
			break;
			case '彩票': $fs_cz = 'cp';
			break;
			case 'AG国际厅': $fs_cz = 'zr';
			break;
			case 'BB波音厅': $fs_cz = 'zr';
			break;
			case 'OG东方厅': $fs_cz = 'zr';
			break;
			case 'HG名人厅': $fs_cz = 'zr';
			break;
			case '玛雅娱乐厅': $fs_cz = 'zr';
			break;
			case 'AG电子游戏': $fs_cz = 'dz';
			break;
			case 'MG电子游戏': $fs_cz = 'dz';
			break;
			case 'PT电子游戏': $fs_cz = 'dz';
			break;
			case 'MW电子游戏': $fs_cz = 'dz';
			break;
			case 'AG捕鱼王': $fs_cz = 'dz';
			break;
			case 'AG街机': $fs_cz = 'dz';
			break;
			case '沙巴体育': $fs_cz = 'ty';
			break;
			case 'AV女优': $fs_cz = 'dz';
			break;
		}
		$m_order = $username . '_' . $fs_cz . '_cx_' . $id;
		$user_sql = 'select money from k_user where uid=\'' . $uid . '\'';
		$user_query = $mydata1_db->query($user_sql);
		$user_row = $user_query->fetch();
		if ($user_row == NULL)
		{
			continue;
		}
		$assets = $user_row['money'];
		$balance = $assets + $fs_money;
		$params = array(':uid' => $uid, ':fs_money' => $fs_money, ':m_order' => $m_order, ':about' => '撤销' . $fs_cz_name . '自动返水[管理员结算]', ':assets' => $assets, ':balance' => $balance);
		$sql = 'insert into k_money (uid,m_value,m_order,status,about,type,sxf,assets,balance)';
		$sql .= ' value(:uid,:fs_money,:m_order,\'2\',:about,\'5\',\'0\',:assets,:balance)';
		$stmt_money = $mydata1_db->prepare($sql);
		$stmt_money->execute($params);
		$m_id = $mydata1_db->lastInsertId();
		$sql = 'delete from fs_account where id=\'' . $id . '\'';
		$mydata1_db->query($sql);
		$params = array(':m_id' => $m_id);
		$sql = 'update k_money,k_user set k_money.status=1,k_money.update_time=now(),k_user.money=k_user.money+k_money.m_value,k_money.balance=k_user.money+k_money.m_value where k_money.uid=k_user.uid and k_money.m_id=:m_id and k_money.`status`=2';
		$stmt_money_user = $mydata1_db->prepare($sql);
		$stmt_money_user->execute($params);
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':creationTime' => $creationTime, ':m_id' => $m_id);
		$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'FANSHUI\',\'CANCEL_IN\',k_money.m_order,k_money.m_value,k_user.money-k_money.m_value,k_user.money,:creationTime FROM k_user,k_money WHERE k_user.uid=k_money.uid AND k_money.status=1 AND k_money.m_id=:m_id';
		$stmt_money_log = $mydata1_db->prepare($sql);
		$stmt_money_log->execute($params);
	}
	message('返水批量撤销成功！', 'fs_account.php');
}
?> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
	  <title>Welcome</title> 
	  <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" /> 
	  <script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
	  <script language="JavaScript" src="/js/calendar.js"></script> 
	  <script type="text/javascript"> 
		  function del_fs(username) { 
			  return confirm('您确认要撤销：'+username+' 的返水吗?') ? true : false;
		  } 
		
		  function batdel_fs() { 
			  var cx_fs_order = $.trim($("#cx_fs_order").val());
			  if (cx_fs_order == "") { 
				  alert("请输入要撤销的返水批次号");
				  $("#cx_fs_order").select();
				  return false;
			  } 
			  return confirm('您确认要撤销批次号为：'+cx_fs_order+' 的所有返水吗?') ? true : false;
			  return false;
		  } 
	  </script> 
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
					for($i=0;$i<24;$i++){
						$list=$i<10?"0".$i:$i;
					?>
					<option value="<?=$list?>" <?=$bhour==$list?"selected":""?>><?=$list?></option>
					<?php } ?>
				</select>&nbsp;时
				<select name="bsecond" id="bsecond">
					<?php
					for($i=0;$i<60;$i++){
						$list=$i<10?"0".$i:$i;
					?>
					<option value="<?=$list?>" <?=$bsecond==$list?"selected":""?>><?=$list?></option>
					<?php } ?>
				</select>&nbsp;分
				&nbsp;结束日期
				<input name="edate" type="text" id="edate" value="<?=$edate?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />
				<select name="ehour" id="ehour">
					<?php
					for($i=0;$i<24;$i++){
						$list=$i<10?"0".$i:$i;
					?>
					<option value="<?=$list?>" <?=$ehour==$list?"selected":""?>><?=$list?></option>
					<?php } ?>
				</select>&nbsp;时
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
				  &nbsp;返水批次号 
				  <input name="fs_order" id="fs_order" type="text" maxlength="20" size="20" value="<?=$fs_order?>" /> 
				  &nbsp;返水彩种 
				  <select id="fs_cz" name="fs_cz"> 
					  <option value="">全部</option> 
					  <option value="体育" <?=$fs_cz=='体育' ? 'selected' : '' ?>>皇冠体育</option> 
					  <option value="沙巴体育" <?=$fs_cz=='沙巴体育' ? 'selected' : '' ?>>沙巴体育</option>
					  <option value="彩票" <?=$fs_cz=='彩票' ? 'selected' : '' ?>>彩票</option> 
					  <option value="AG国际厅" <?=$fs_cz=='AG国际厅' ? 'selected' : '' ?>>AG国际厅</option>
					  <option value="AG极速厅" <?=$fs_cz=='AG极速厅' ? 'selected' : '' ?>>AG极速厅</option>
					  <option value="BB波音厅" <?=$fs_cz=='BB波音厅' ? 'selected' : '' ?>>BB波音厅</option>
					  <option value="OG东方厅" <?=$fs_cz=='OG东方厅' ? 'selected' : '' ?>>OG东方厅</option>
					  <option value="HG名人厅" <?=$fs_cz=='HG名人厅' ? 'selected' : '' ?>>HG名人厅</option>
					  <option value="玛雅娱乐厅" <?=$fs_cz=='玛雅娱乐厅' ? 'selected' : '' ?>>玛雅娱乐厅</option>
					  <option value="AG电子游戏" <?=$fs_cz=='AG电子游戏' ? 'selected' : '' ?>>AG电子游戏</option>
					  <option value="AG捕鱼王" <?=$fs_cz=='AG捕鱼王' ? 'selected' : '' ?>>AG捕鱼王</option>
					  <option value="AG街机" <?=$fs_cz=='AG街机' ? 'selected' : '' ?>>AG街机</option>
					  <option value="MW电子游戏" <?=$fs_cz=='MW电子游戏' ? 'selected' : '' ?>>MW电子游戏</option>
					  <option value="MG电子游戏" <?=$fs_cz=='MG电子游戏' ? 'selected' : '' ?>>MG电子游戏</option>
					  <option value="PT电子游戏" <?=$fs_cz=='PT电子游戏' ? 'selected' : '' ?>>PT电子游戏</option> 
					  <option value="AV女优" <?=$fs_cz=='AV女优' ? 'selected' : '' ?>>AV女优</option> 
				  </select> 
				  &nbsp;返水方式 
				  <select id="fs_fs" name="fs_fs"> 
					  <option value="">全部</option> 
					  <option value="1"<?=$fs_fs==1 ? 'selected' : '' ?>>按有效投注</option> 
					  <option value="2"<?=$fs_fs==2 ? 'selected' : '' ?>>按实际输赢</option> 
				  </select> 
				  &nbsp;会员名称 
				  <input name="username" type="text" id="username" value="<?=$username?>" size="15" maxlength="20"/> 
				  &nbsp;<input name="find" type="submit" id="find" value="查询"/> 
			  </td> 
		  </tr> 
		  </form> 
	  </table> 
	  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;line-height:20px;" bgcolor="#798EB9"> 
		  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
			  <td>会员账号</td> 
			  <td>返水周期</td> 
			  <td>返水方式<br><font color="#FF9900">返水彩种</font></td> 
			  <td>返水批次号<br><font color="#FF9900">返水时间</font></td> 
			  <td>实际返水<br><font color="#FF9900">撤销返水</font></td> 
			  <td>等级</td> 
			  <td>比例</td> 
			  <td>笔数</td> 
			  <td>下注金额</td> 
			  <td>有效投注</td> 
			  <td>网站盈利</td> 
		  </tr>
<?php 
$color = '#FFFFFF';
$over = '#EBEBEB';
$out = '#ffffff';
if ($time == 'CN')
{
	$q_btime = date('Y-m-d H:i:s', strtotime($btime) - (12 * 3600));
	$q_etime = date('Y-m-d H:i:s', strtotime($etime) - (12 * 3600));
}else{
	$q_btime = $btime;
	$q_etime = $etime;
}
$params = array();
$sqlwhere = '';
if ($fs_order != '')
{
	$params[':fs_order'] = $fs_order;
	$sqlwhere .= ' and fs_order=:fs_order';
}
if ($fs_cz != '')
{
	$params[':fs_cz'] = $fs_cz;
	$sqlwhere .= ' and fs_cz=:fs_cz';
}
if ($fs_fs != '')
{
	$params[':fs_fs'] = $fs_fs;
	$sqlwhere .= ' and fs_fs=:fs_fs';
}
if ($username != '')
{
	$params[':username'] = $username;
	$sqlwhere .= ' and username=:username';
}
$params[':q_btime'] = $q_btime;
$params[':q_etime'] = $q_etime;
$sql = 'select * from fs_account where fs_uptime>=:q_btime and fs_uptime<=:q_etime ' . $sqlwhere . ' order by fs_uptime desc,id desc';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$sum_bet_num = 0;
$sum_bet_money = 0;
$sum_yx_money = 0;
$sum_yingli = 0;
$sum_fs_money = 0;
while ($row = $stmt->fetch())
{
	$sum_bet_num += $row['bet_num'];
	$sum_bet_money += $row['bet_money'];
	$sum_yx_money += $row['yx_money'];
	$sum_yingli += $row['yingli'];
	$sum_fs_money += $row['fs_money'];
?>		  
			<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over?>'" onMouseOut="this.style.backgroundColor='<?=$out?>'" style="background-color:<?=$color?>;"> 
			  <td><?=$row['username']?></td> 
			  <td><?=$row['fs_btime']?><br/><font color="#FF9900"><?=$row['fs_etime']?></font></td> 
			  <td><?=$row['fs_fs']==1 ? '按有效投注' : '按实际输赢' ?><br><font color="#FF9900"><?=$row['fs_cz']?></font></td> 
			  <td><?=$row['fs_order']?><br><font color="#FF9900"><?=strtotime('y-m-d H:i:s',$row['fs_uptime'])?></font></td> 
			  <td><?=$row['fs_money']?><br><a href="?del=1&id=<?=$row['id']?>" onClick="return del_fs('<?=$row['username']?>');" style="color:#ff0000;">撤销</a></td> 
			  <td><?=$row['fs_name']?></td> 
			  <td><?=$row['fs_rate']?>%</td> 
			  <td><?=$row['bet_num']?></td> 
			  <td><?=$row['bet_money']?></td> 
			  <td><?=$row['yx_money']?></td> 
			  <td><?=$row['yingli']?></td> 
          </tr>
<?php }?> 		  
		  <tr align="center" style="background:#ffffff;color:#ff0000;"> 
			  <td>合计</td> 
			  <td></td> 
			  <td></td> 
			  <td></td> 
			  <td><?=$sum_fs_money?></td> 
			  <td></td> 
			  <td></td> 
			  <td><?=$sum_bet_num?></td> 
			  <td><?=$sum_bet_money?></td> 
			  <td><?=$sum_yx_money?></td> 
			  <td><?=$sum_yingli?></td> 
          </tr> 
	  </table> 
	  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="font12" style="border:1px solid #798EB9;margin-top:5px;"> 
		  <form name="form2" method="post" action="?batdel=1"> 
		  <tr bgcolor="#FFFFFF"> 
			  <td align="left"> 
				  &nbsp;<strong>按批次撤销返水</strong> 
				  &nbsp;返水批次号 
				  <input name="cx_fs_order" type="text" id="cx_fs_order" size="20" maxlength="20"/> 
				  &nbsp;<input name="chexiao" type="submit" id="chexiao" value="撤销" onClick="return batdel_fs();"/> 
			  </td> 
		  </tr> 
		  </form> 
	  </table> 
  </div> 
  </div> 
  </body> 
  </html>