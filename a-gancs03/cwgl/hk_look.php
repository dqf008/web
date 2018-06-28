<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('jkkk');
if ($_GET['action'])
{
	$status = $_POST['hf_status'];
	$id = $_POST['hf_id'];
	$zsjr = 0;
	$num = 0;
	if ($_POST['is_zsjr'] == 1)
	{
		$zsjr = ($_POST['hf_money'] / 100) * $_POST['rate'];
	}
	$msg = '失败';
	if ($status == '1')
	{
		$params = array(':zsjr' => $zsjr, ':zsjr2' => $zsjr, ':zsjr3' => $zsjr, ':id' => $id);
		$sql = 'update k_user,huikuan set k_user.money=k_user.money+huikuan.money+:zsjr,huikuan.status=1,zsjr=:zsjr2,huikuan.balance=k_user.money+huikuan.money+:zsjr3 where k_user.uid=huikuan.uid and huikuan.id=:id and huikuan.`status`=0';
		$msg = '成功';
		$num = 2;
	}else{
		$params = array(':id' => $id);
		$sql = 'update huikuan set `status`=2,balance=assets where id=:id and `status`=0';
		$num = 1;
		if(isset($_POST['hf_reason'])&&!empty($_POST['hf_reason'])){
			$stmt = $mydata1_db->prepare('SELECT `uid`, `lsh`, `money` FROM `huikuan` WHERE `id`=:id');
			$stmt->execute($params);
			if($stmt->rowCount()>0){
				$rows = $stmt->fetch();
				$stmt = $mydata1_db->prepare('INSERT INTO `k_user_msg` (`msg_from`, `uid`, `msg_title`, `msg_info`, `msg_time`, `islook`) VALUES (:msg_from, :uid, :msg_title, :msg_info, NOW(), 0)');
				$stmt->execute(array(
					':msg_from' => $web_site['reg_msg_from'],
					':uid' => $rows['uid'],
					':msg_title' => '汇款请求未通过提醒',
					':msg_info' => '您提交的汇款单在 '.date('Y-m-d H:i:s').'(美东时间) 核查未通过。<br />汇款单号：'.$rows['lsh'].'<br />失败原因：'.$_POST['hf_reason'].'<br />给您造成不便敬请谅解，如有疑问，请及时与我们的在线客服联系，祝您游戏愉快！',
				));
			}
		}
	}
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1 == $num)
	{
		if ($status == '1')
		{
			$creationTime = date('Y-m-d H:i:s');
			$params = array(':zsjr' => $zsjr, ':zsjr2' => $zsjr, ':creationTime' => $creationTime, ':id' => $id);
			$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)
			SELECT k_user.uid,k_user.username,\'HUIKUAN\',\'IN\',huikuan.lsh,huikuan.money+:zsjr,k_user.money-(huikuan.money+:zsjr2),k_user.money,:creationTime FROM k_user,huikuan WHERE k_user.uid=huikuan.uid AND huikuan.status=1 AND huikuan.id=:id';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
		}
		include_once '../../class/admin.php';
		admin::insert_log($_SESSION['adminid'], '审核了编号为' . $id . '的汇款单,' . $msg);
		message('操作成功', 'huikuan.php?status=0');
	}else{
		message('操作失败');
	}
}
$id = $_GET['id'];
$params = array(':id' => $id);
$sql = 'select hk.*,u.username from `huikuan` hk,`k_user` u where hk.uid=u.uid and hk.id=:id';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rs = $stmt->fetch();
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>用户组编辑页面</TITLE> 

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
<?php if(!empty($_GET['isAlert'])){ ?>
	table tr td {height:23px;line-height:23px;}
<?php } ?>
</STYLE> 
</HEAD> 
<script type="text/javascript"> 
function check($v){ 
  document.getElementById("hf_status").value = $v;
  if($v==2){
    $v = prompt("通知会员失败原因，如不需要站内通知请保留为空", "");
    document.getElementById("hf_reason").value = $v==null?"":$v;
  }
  document.getElementById("form1").submit();
} 
</script> 
<body> 
<form name="form1" id="form1" method="post" action="hk_look.php?action=true"> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td style="line-height:17px;height:17px;" height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2">汇款管理：查看用户汇款信息</span></font></td> 
</tr> 
</table> 

<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
  
<tr> 
  <td height="24" valign="top" nowrap bgcolor="#FFFFFF"> 
   <input name="hf_status" type="hidden" id="hf_status">
<input name="hf_reason" type="hidden" id="hf_reason">  
<input name="hf_id" type="hidden" id="hf_id" value="<?=$id?>">
<input name="hf_money" type="hidden" id="hf_money" value="<?=$rs['money']?>">

<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" > 
		  <tr align="center"> 
			<td align="right">汇款流水号：</td> 
			<td align="left"><?=$rs['lsh']?></td> 
		</tr> 
		  <tr align="center"> 
			<td width="22%" align="right">汇款用户：</td> 
			<td width="78%" align="left"><?=$rs['username']?></td> 
		</tr> 
		  <tr align="center"> 
			<td align="right">汇款前余额：</td> 
			<td align="left"><span style="color:#999999;"><?=sprintf('%.2f',$rs['assets'])?></span></td> 
		</tr> 
		  <tr align="center"> 
			<td align="right">汇款金额：</td> 
			<td align="left"><?=sprintf('%.2f',$rs['money'])?></td> 
		</tr> 
		  <tr align="center"> 
			<td align="right">汇款后余额：</td> 
			<td align="left"><span style="color:#999999;"><?=sprintf('%.2f',$rs['balance'])?></span></td> 
		</tr> 
		  <tr align="center"> 
			<td align="right">汇款日期：</td> 
			<td align="left"><?=$rs['date']?></td> 
		</tr> 
		  <tr align="center"> 
			<td align="right">汇款银行：</td> 
			<td align="left"><?=$rs['bank']?></td> 
		</tr> 
		  <tr align="center"> 
			<td align="right">汇款方式：</td> 
			<td align="left"><?=$rs['manner']?></td> 
		</tr> 
		  <tr align="center"> 
			<td align="right">汇款地点：</td> 
			<td align="left"><?=$rs['address']?></td> 
		</tr> 
		  <tr align="center"> 
			<td align="right">提交时间：</td> 
			<td align="left"><?=$rs['adddate']?></td> 
		</tr> 
		  <tr align="center"> 
			<td align="right">当前状态：</td> 
			<td align="left">
			<?php 
			if ($rs['status'] == 1){
				echo "汇款成功";
			}else if ($rs['status'] == 2){
				echo "汇款失败";
			}else{
				echo "审核中";
			}
			?> 
			</td> 
		</tr> 
		  <tr align="center"> 
			<td align="right">赠送手续费：</td> 
			<td align="left">
			<?php if (0 < $rs['status']){ echo $rs['zsjr']; ?> 元<?php }else{?>             
			<select name="rate" id="rate"> 
			  <option value="0.0"<?=$web_site['default_hkzs']==0   ? 'selected' : '' ?>>0.0%</option> 
			  <option value="0.1"<?=$web_site['default_hkzs']==0.1 ? 'selected' : '' ?>>0.1%</option> 
			  <option value="0.2"<?=$web_site['default_hkzs']==0.2 ? 'selected' : '' ?>>0.2%</option> 
			  <option value="0.3"<?=$web_site['default_hkzs']==0.3 ? 'selected' : '' ?>>0.3%</option> 
			  <option value="0.4"<?=$web_site['default_hkzs']==0.4 ? 'selected' : '' ?>>0.4%</option> 
			  <option value="0.5"<?=$web_site['default_hkzs']==0.5 ? 'selected' : '' ?>>0.5%</option> 
			  <option value="0.6"<?=$web_site['default_hkzs']==0.6 ? 'selected' : '' ?>>0.6%</option> 
			  <option value="0.7"<?=$web_site['default_hkzs']==0.7 ? 'selected' : '' ?>>0.7%</option> 
			  <option value="0.8"<?=$web_site['default_hkzs']==0.8 ? 'selected' : '' ?>>0.8%</option> 
			  <option value="0.9"<?=$web_site['default_hkzs']==0.9 ? 'selected' : '' ?>>0.9%</option> 
			  <option value="1.0"<?=$web_site['default_hkzs']==1   ? 'selected' : '' ?>>1.0%</option> 
			  <option value="1.1"<?=$web_site['default_hkzs']==1.1 ? 'selected' : '' ?>>1.1%</option> 
			  <option value="1.2"<?=$web_site['default_hkzs']==1.2 ? 'selected' : '' ?>>1.2%</option> 
			  <option value="1.3"<?=$web_site['default_hkzs']==1.3 ? 'selected' : '' ?>>1.3%</option> 
			  <option value="1.4"<?=$web_site['default_hkzs']==1.4 ? 'selected' : '' ?>>1.4%</option> 
			  <option value="1.5"<?=$web_site['default_hkzs']==1.5 ? 'selected' : '' ?>>1.5%</option> 
			  <option value="1.6"<?=$web_site['default_hkzs']==1.6 ? 'selected' : '' ?>>1.6%</option> 
			  <option value="1.7"<?=$web_site['default_hkzs']==1.7 ? 'selected' : '' ?>>1.7%</option> 
			  <option value="1.8"<?=$web_site['default_hkzs']==1.8 ? 'selected' : '' ?>>1.8%</option> 
			  <option value="1.9"<?=$web_site['default_hkzs']==1.9 ? 'selected' : '' ?>>1.9%</option> 
			  <option value="2.0"<?=$web_site['default_hkzs']==  2 ? 'selected' : '' ?>>2.0%</option> 
			  <option value="2.1"<?=$web_site['default_hkzs']==2.1 ? 'selected' : '' ?>>2.1%</option> 
			  <option value="2.2"<?=$web_site['default_hkzs']==2.2 ? 'selected' : '' ?>>2.2%</option> 
			  <option value="2.3"<?=$web_site['default_hkzs']==2.3 ? 'selected' : '' ?>>2.3%</option> 
			  <option value="2.4"<?=$web_site['default_hkzs']==2.4 ? 'selected' : '' ?>>2.4%</option> 
			  <option value="2.5"<?=$web_site['default_hkzs']==2.5 ? 'selected' : '' ?>>2.5%</option> 
			  <option value="2.6"<?=$web_site['default_hkzs']==2.6 ? 'selected' : '' ?>>2.6%</option> 
			  <option value="2.7"<?=$web_site['default_hkzs']==2.7 ? 'selected' : '' ?>>2.7%</option> 
			  <option value="2.8"<?=$web_site['default_hkzs']==2.8 ? 'selected' : '' ?>>2.8%</option> 
			  <option value="2.9"<?=$web_site['default_hkzs']==2.9 ? 'selected' : '' ?>>2.9%</option> 
			  <option value="3.0"<?=$web_site['default_hkzs']==  3 ? 'selected' : '' ?>>3.0%</option> 
			  <option value="5.0"<?=$web_site['default_hkzs']==  5 ? 'selected' : '' ?>>5.0%</option> 
		  </select> 
			<label> 
			  <input name="is_zsjr" type="checkbox" id="is_zsjr" value="1" checked="checked"> 
			勾选则赠送，不勾则不赠送。同城同行汇款不赠送</label><?php }?> 			    </td> 
		</tr> 
		
			<?php if(empty($_GET['isAlert'])){ ?>
		  <tr align="center"> 
			<td colspan="2" align="right">&nbsp;</td> 
		</tr> 
		  <tr align="center"> 
			<td colspan="2" align="center">
			<?php 
			if ($rs['status'] == 0){
			?> 	                  
			   <input type="button" name="Submit2" value="充值成功" onClick="check('1');"> 
			   　     
			   <input type="button" name="Submit3" value="充值失败" onClick="check('2');">　
			<?php }?>
			<input type="button" name="Submit" value="返回" onClick="javascript:window.history.go(-1);">
			
			</td> 
		</tr>   
			<?php } ?>
  </table> 
  </td> 
</tr> 
</table> 
</form> 
</body> 
</html>