<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cwgl');
$sum = $sumzz = $true = $false = $cl = 0;
$time_type = 'CN';
if (isset($_GET['time_type'])){
	$time_type = $_GET['time_type'];
}

if (!empty($_GET['act']) && $_GET['act'] == 'ok'){
	$time = strtotime(date('Y-m-d'));
	$time = strftime('%Y-%m-%d', $time - (6 * 24 * 3600)) . ' 00:00:00';
	$params = array(':zz_time' => $time);
	$sql = 'Delete From `ag_zhenren_zz` Where zz_time<:zz_time';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	message('删除成功！');
}

if (!empty($_GET['act']) && $_GET['act'] == 'update'){
	$dotype = $_GET['dotype'];
	$id = $_GET['id'];
	$params = array();
	if ($dotype == 1){
		$params['result'] = '人工处理：已加款';
	}else if ($dotype == 2){
		$params['result'] = '人工处理：不加款';
	}
	
	$params['id'] = trim($id);
	$sql = 'update `ag_zhenren_zz` set result=:result Where ok=0 and id=:id';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	if ($dotype == 1){
		message('标记成功！', 'set_money.php?uid=' . $_GET['uid'] . '&type=add&about=' . $_GET['about'] . '&money=' . $_GET['money'] . '&money_type=6');
	}else if ($dotype == 2){
		message('标记成功！');
	}
}
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>转账记录</TITLE> 
<script language="javascript"> 
function go(value){ 
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
  <td height="24" nowrap background="../images/06.gif"><font ><span class="STYLE2">转账查询：查看所有的用户转账记录</span></font></td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="100%"> 
	<tr> 
	  <form name="form1" method="GET" action="zhuanzhang.php?ok=" > 
	  <td width="110" align="center">
	  	<select name="live_type" id="live_type"> 
			<option value="" <?=$_GET['live_type']==''? 'selected' : '' ?>>全部平台</option> 
			<option value="AGIN" <?=$_GET['live_type']=='AGIN' ? 'selected' : '' ?>>AG国际</option>
			<option value="AG" <?=$_GET['live_type']=='AG' ? 'selected' : '' ?>>AG极速</option>
			<option value="BBIN2" <?=$_GET['live_type']=='BBIN2' ? 'selected' : '' ?>>新BBIN</option>
			<option value="MAYA" <?=$_GET['live_type']=='MAYA' ? 'selected' : '' ?>>玛雅</option>
			<option value="OG2" <?=$_GET['live_type']=='OG2' ? 'selected' : '' ?>>OG视讯</option>
			<option value="BGLIVE" <?=$_GET['live_type']=='BGLIVE' ? 'selected' : '' ?>>BG视讯</option>
			<option value="SB" <?=$_GET['live_type']=='SB' ? 'selected' : '' ?>>申博视讯</option>
			<option value="DG" <?=$_GET['live_type']=='DG' ? 'selected' : '' ?>>DG视讯</option>
			<option value="MG2" <?=$_GET['live_type']=='MG2' ? 'selected' : '' ?>>新MG电子</option>
			<option value="PT2" <?=$_GET['live_type']=='PT2' ? 'selected' : '' ?>>新PT电子</option>
			<option value="MW" <?=$_GET['live_type']=='MW' ? 'selected' : '' ?>>MW电子</option>
			<option value="KG" <?=$_GET['live_type']=='KG' ? 'selected' : '' ?>>AV女忧</option>
			<option value="CQ9" <?=$_GET['live_type']=='CQ9' ? 'selected' : '' ?>>CQ9电子</option>
			<option value="SHABA" <?=$_GET['live_type']=='SHABA' ? 'selected' : '' ?>>沙巴体育</option>
			<option value="VR" <?=$_GET['live_type']=='VR' ? 'selected' : '' ?>>VR彩票</option>
			<option value="KY" <?=$_GET['live_type']=='KY' ? 'selected' : '' ?>>开元棋牌</option>
			<option value="BBIN" <?=$_GET['live_type']=='BBIN' ? 'selected' : '' ?>>BBIN</option>
			<option value="MG" <?=$_GET['live_type']=='MG' ? 'selected' : '' ?>>MG电子</option>
		</select>
		</td> 
	  <td width="110" align="center"><select name="ok" id="ok"> 
		  <option value="0" <?=$_GET["ok"]=='0' ? 'selected' : ''?>>转账中</option>
          <option value="1" <?=$_GET["ok"]=='1' ? 'selected' : ''?>>转账成功</option>
          <option value="2" <?=$_GET["ok"]=='2' ? 'selected' : ''?>>转账失败</option>
          <option value="" <?=$_GET["ok"]=='' ? 'selected' : ''?>>全部转账</option> 
		</select></td> 
	  <td width="110" align="center"><label> 
		<select name="time_type" id="time_type"> 
		  <option value="CN" <?=$time_type=='CN' ? 'selected' : ''?>>中国时间</option>
          <option value="EN" <?=$time_type=='EN' ? 'selected' : ''?>>美东时间</option> 
		</select> 
	  </label></td> 
	  <td align="left" width="470">日期： 
		<input name="zz_time" type="text" id="zz_time" value="<?=$_GET['zz_time']?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" /> 
		&nbsp;&nbsp;会员名称： 
		<input name="username" type="text" id="username" value="<?=$_GET['username']?>" size="15" maxlength="20"/>          &nbsp;&nbsp;
		<input name="find" type="submit" id="find" value="查找"/></td> 
		</form> 
		<form name="form2" method="GET" action="zhuanzhang.php?ok=" onSubmit="return(confirm('您确定要删除7天前所有转账记录？'))"> 
		<td align="left"> 
		  <input name="act" type="hidden" id="act" value="ok"/> 
		  <input name="del" type="submit" id="del" value="删除7天前转账记录"/></td> 
		</form> 
	  </tr> 
  </table></td> 
</tr> 
</table> 
<br> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"> 
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" > 
	<tr bgcolor="efe" class="t-title" align="center"> 
	  <td width="12%"><strong>用户名</strong></td> 
	  <td width="12%"><strong>真人用户名</strong></td> 
	  <td width="20%"><strong>转账类型</strong></td> 
	  <td width="12%"><strong>转账金额</strong></td> 
	  <td width="16%"><strong>转账时间</strong></td> 
	  <td width="10%"><strong>状态</strong></td> 
	  <td width="18%"><strong>处理结果</strong></td> 
	  </tr>
	  <?php
	  	include_once '../../include/newpage.php';
		$params = array();
		$sql = 'select id from ag_zhenren_zz where 1=1';
		if (isset($_GET['live_type'])){
			if ($_GET['live_type'] != ''){
				$params[':live_type'] = $_GET['live_type'];
				$sql .= ' and live_type=:live_type';
			}
		}
		
		if (isset($_GET['ok'])){
			if ($_GET['ok'] != ''){
				$params[':ok'] = $_GET['ok'];
				$sql .= ' and ok=:ok';
			}
		}
		
		if ($_GET['username']){
			$params[':username'] = $_GET['username'];
			$sql .= ' and username =:username';
		}
		
		if ($_GET['zz_time']){
			if ($time_type == 'CN'){
				$stime = date('Y-m-d H:i:s', strtotime($_GET['zz_time']) - 43200);
				$etime = date('Y-m-d H:i:s', strtotime($stime) + 86399);
			}else{
				$stime = $_GET['zz_time'] . ' 00:00:00';
				$etime = $_GET['zz_time'] . ' 23:59:59';
			}
			$params[':stime'] = $stime;
			$params[':etime'] = $etime;
			$sql .= ' and zz_time>=:stime and zz_time<=:etime';
		}
		
		$sql .= ' order by id desc';
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
		
		if ($id){
		$id = rtrim($id, ',');
		$sql = 'select * from ag_zhenren_zz where id in (' . $id . ') order by id desc';
		$query = $mydata1_db->query($sql);
		$inmoney = 0;
		$outmoney = 0;
		while ($rows = $query->fetch()){
			if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'AGIN'){
				$zz_type = '彩票 → AG国际厅';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'AGIN'){
				$zz_type = 'AG国际厅 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'AG'){
				$zz_type = '彩票 → AG极速厅';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'AG'){
				$zz_type = 'AG极速厅 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'BBIN'){
				$zz_type = '彩票 → BB波音厅';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'BBIN'){
				$zz_type = 'BB波音厅 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'OG'){
				$zz_type = '彩票 → OG东方厅';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'OG'){
				$zz_type = 'OG东方厅 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'MAYA'){
				$zz_type = '彩票 → 玛雅娱乐厅';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'MAYA'){
				$zz_type = '玛雅娱乐厅 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'SHABA'){
				$zz_type = '彩票 → 沙巴体育';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'SHABA'){
				$zz_type = '沙巴体育 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'PT'){
				$zz_type = '彩票 → PT电子游戏';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'PT'){
				$zz_type = 'PT电子游戏 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'MW'){
				$zz_type = '彩票 → MW电子游戏';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'MW'){
				$zz_type = 'MW电子游戏 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'KG'){
				$zz_type = '彩票 → AV女优游戏';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'KG'){
				$zz_type = 'AV女优游戏 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'CQ9'){
				$zz_type = '彩票 → CQ9电子游戏';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'CQ9'){
				$zz_type = 'CQ9电子游戏 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'MG2'){
				$zz_type = '彩票 → 新MG电子游戏';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'MG2'){
				$zz_type = '新MG电子游戏 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'VR'){
				$zz_type = '彩票 → VR彩票';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'VR'){
				$zz_type = 'VR彩票 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'BGLIVE'){
				$zz_type = '彩票 → BG视讯';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'BGLIVE'){
				$zz_type = 'BG视讯 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'SB'){
				$zz_type = '彩票 → 申博视讯';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'SB'){
				$zz_type = '申博视讯 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'PT2'){
				$zz_type = '彩票 → 新PT电子';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'PT2'){
				$zz_type = '新PT电子 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'OG2'){
				$zz_type = '彩票 → 新OG东方厅';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'OG2'){
				$zz_type = '新OG东方厅 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'DG'){
				$zz_type = '彩票 → DG视讯';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'DG'){
				$zz_type = 'DG视讯 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'KY'){
				$zz_type = '彩票 → 开元棋牌';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'KY'){
				$zz_type = '开元棋牌 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'MG'){
				$zz_type = '彩票 → MG电子';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'MG'){
				$zz_type = 'MG电子 → 彩票';
			}else if ($rows['zz_type'] == 'IN' and $rows['live_type'] == 'BBIN2'){
				$zz_type = '彩票 → 新BB波音厅';
			}else if ($rows['zz_type'] == 'OUT' and $rows['live_type'] == 'BBIN2'){
				$zz_type = '新BB波音厅 → 彩票';
			}

			if ($rows['ok'] == 0){
				$zz_ok = '处理中';
			}else{
				$zz_ok = '已处理';
			}
?>       
	<tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#ffffff'" > 
	  <td height="35" align="center"><?=$rows['username']?></td> 
	  <td><?=$rows['zr_username']?></td> 
	  <td><?=$zz_type?></td> 
	  <td><span style="color:#999999;"><?=double_format($rows['moneyA'])?></span><br><?=double_format($rows['zz_money'])?><br><span style="color:#999999;"><?=double_format($rows['moneyB'])?></span></td> 
	  <td><?=$time_type=='CN' ? date('Y-m-d H:i:s',strtotime($rows["zz_time"])+12*3600) : date('Y-m-d H:i:s',strtotime($rows["zz_time"]))?></td> 
	  <td><?=$zz_ok?></td> 
	  <td>
	  <?php 
	  	if ($rows['ok'] == '1'){
	   		echo "<span style='color:#009900;'>".$rows['result']."</span>";
			if ($rows['zz_type'] == 'IN'){
				$inmoney += abs($rows['zz_money']);
			}else if ($rows['zz_type'] == 'OUT'){
				$outmoney += abs($rows['zz_money']);
			}
		}else if ($rows['ok'] == '2'){
			echo "<span style='color:#FF0000;'>".$rows['result']."</span>";
		}else{
			echo $rows['result'];
			if (!(1 <= strpos('|' . $rows['result'], '人工处理'))){
	  ?> 
	  <a title="只是标记而已" href="zhuanzhang.php?act=update&id=<?=$rows['id']?>&dotype=1&uid=<?=$rows['uid']?>&about=(转账中)<?=$zz_type ?>&money=<?=double_format($rows['zz_money']) ?>">【加款】</a>
	  <a  title="只是标记而已"  href="zhuanzhang.php?act=update&id=<?=$rows['id']?>&dotype=2">【不加款】</a>
	  <?php 
	  		}
		}
	  ?> 
	</td> 
	  </tr>
<?php 
	  }
}
?>     </table></td> 
</tr> 
<tr> 
  <td style="line-height:24px;"><div>本页转账成功：[转入]<span style="color:#006600"><?=double_format($inmoney)?></span>，[转出]<span style="color:#ff0000;"><?=double_format($outmoney)?></span></div>
	<div><?=$page->get_htmlPage($_SERVER["REQUEST_URI"]);?></div></td>
</tr> 
</table> 
</body> 
</html>