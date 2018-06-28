<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cwgl');
$orderId = (int) $_GET['id'];
if(!empty($_GET['act']) && $_GET['act'] == 'order'){
	$params = array(':m_id' => intval($_GET['id']));
	$id = (int) $_GET['id'];
	$sql = 'select k_money.*,k_user.username,k_user.why,k_user.pay_name,agUserName,agqUserName,bbinUserName,ogUserName,mayaUserName,shabaUserName,mgUserName,ptUserName,ipmUserName,mwUserName,kgUserName,cq9UserName,mg2UserName,vrUserName,bgUserName,sbUserName from k_money left join k_user on k_money.uid=k_user.uid where  k_money.m_id=' . $id;
	$res = $mydata1_db->query($sql)->fetch(PDO::FETCH_ASSOC);
	if($res){
		$res['assets'] = sprintf("%.2f",$res["assets"]);
		$res['m_value'] = sprintf("%.2f",abs($res["m_value"]));
		$res['balance'] = sprintf("%.2f",$res["balance"]);
	}
	die(json_encode($res));
}
?> 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>用户提现处理</title> 
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize@0.4.0/modern-normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/element-ui@2.2.2/lib/theme-chalk/index.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <style>
        body {
		    padding: 8px;
		    font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
		}
		*[v-cloak] {
		    display: none !important
		}
		.el-form-item--mini.el-form-item {
			margin-bottom: 5px;
		}
		.row {height: 40px;line-height: 40px;border:1px solid #ebeef5;
			box-sizing: content-box;
			font-size: 13px;
			color: #606266;
		}
		.row + .row {
			border-top:0;
		}
		.row div{float:left;}
		.row .tit {
			text-align: right;
			width: 65px;
			background-color: #fafafa;
			padding:0 10px;
			border-right: 1px solid #ebeef5;
			border-left: 1px solid #ebeef5;
		}
		.row .tit:first-child {
			border-left: 0;
		}
		.row .cont {
			padding: 0 20px 0 10px;
			min-width: 80px;
		}
		.el-table div.cell{
			text-align: center;
			padding:0;
		}
		.el-table--border th:first-child .cell{
			padding:0;
		}
	</style>
</head> 
<body> 
<div id="app" v-cloak>
	<div class="info">
		<div class="row">
			<div class="tit">用户名</div>
			<div class="cont">
				<a type="text" v-text="order.username"></a>
				<el-popover ref="zhenren" placement="right" width="300" trigger="hover" >
					<div>AG国际厅 => {{ order.agUserName }}</div>
					<div>AG极速厅 => {{ order.agqUserName }}</div>
					<div>BB波音厅 => {{ order.bbinUserName }}</div>
					<div>OG东方厅 => {{ order.ogUserName }}</div>
					<div>PT电子 => {{ order.ptUserName }}</div>
					<div>MG电子 => {{ order.mgUserName }}</div>
					<div>MW电子 => {{ order.mwUserName }}</div>
					<div>玛雅娱乐厅 => {{ order.mayaUserName }}</div>
					<div>沙巴体育 => {{ order.shabaUserName }}</div>
					<div>IPM体育 => {{ order.ipmUserName }}</div>
					<div>AV女优 => {{ order.kgUserName }}</div>
					<div>CQ9电子 => {{ order.cq9UserName }}</div>
					<div>新MG电子 => {{ order.mg2UserName }}</div>
					<div>VR彩票 => {{ order.vrUserName }}</div>
					<div>BG视讯 => {{ order.bgUserName }}</div>
					<div>申博视讯 => {{ order.sbUserName }}</div>
				</el-popover>
				<button type="button" v-popover:zhenren><i class="fa fa-eye" aria-hidden="true"></i>真人帐号</button>
			</div>
			<div class="tit">用户备注</div>
			<div class="cont" v-text="order.why"></div>
		</div>		
		<div class="row">
			<div class="tit">开户行</div>
			<div class="cont" v-text="order.pay_card"></div>
			<div class="tit">银行卡号</div>
			<div class="cont" v-text="order.pay_name"></div>
			<div class="tit">开户姓名</div>
			<div class="cont" v-text="order.pay_name"></div>
			<div class="tit">开户地址</div>
			<div class="cont" v-text="order.pay_address"></div>
		</div>
		<div class="row">
			<div class="tit">订单号</div>
			<div class="cont" v-text="order.m_order"></div>
			<div class="tit">申请时间</div>
			<div class="cont" v-text="order.m_make_time"></div>
		</div>
		<div class="row">
			<div class="tit">取款前余额</div>
			<div class="cont" v-text="order.assets"></div>
			<div class="tit">取款金额</div>
			<div class="cont" v-text="order.m_value"></div>
			<div class="tit">取款后余额</div>
			<div class="cont" v-text="order.balance"></div>
		</div>
	</div>
	<el-form label-width="100px" size="mini">
		<el-form-item label="操作" >
			<el-radio v-model="form.status" label="1">已支付</el-radio>
			<el-radio v-model="form.status" label="0">未支付</el-radio>
		</el-form-item>
		<el-form-item label="手续费" >
			<el-input v-model="form.fee" style="width:150px;"><template slot="append">元</template></el-input>
		</el-form-item>
		<el-form-item label="操作" ><el-button>提交</el-button></el-form-item>
	</el-form>
	<el-table border size="mini" :data="damaData">
		<el-table-column prop="date" label="序号"></el-table-column>
		<el-table-column prop="starttime" label="开始时间"></el-table-column>
		<el-table-column prop="endtime" label="截止时间"></el-table-column>
		<el-table-column label="入款">
			<el-table-column prop="chmoney" label="存汇款"></el-table-column>
			<el-table-column prop="cjmoney" label="彩金"></el-table-column>
			<el-table-column prop="fsmoney" label="返水"></el-table-column>
			<el-table-column prop="othermoney" label="其它"></el-table-column>
		</el-table-column>
		<el-table-column prop="date" label="打码量">
			<el-table-column prop="tkty" label="体育"></el-table-column>
			<el-table-column prop="tkcp" label="彩票"></el-table-column>
			<el-table-column prop="tklh" label="六合彩"></el-table-column>
			<el-table-column prop="tkag" label="AG"></el-table-column>
			<el-table-column prop="tkagq" label="AGQ"></el-table-column>
			<el-table-column prop="tkbb" label="BBIN"></el-table-column>
			<el-table-column prop="tkhg" label="HG"></el-table-column>
			<el-table-column prop="tkog" label="OG"></el-table-column>
			<el-table-column prop="tkmg" label="MG"></el-table-column>
			<el-table-column prop="tkmw" label="MW"></el-table-column>
			<el-table-column prop="tkpt" label="PT"></el-table-column>
			<el-table-column prop="tkmaya" label="MAYA"></el-table-column>
			<el-table-column prop="tkkg" label="AV"></el-table-column>
			<el-table-column prop="tkcq9" label="CQ9"></el-table-column>
			<el-table-column prop="tkmg2" label="新MG"></el-table-column>
			<el-table-column prop="tkvr" label="VR"></el-table-column>
			<el-table-column prop="tkbg" label="BG"></el-table-column>
			<el-table-column prop="tksb" label="SB"></el-table-column>
		</el-table-column>
		<el-table-column prop="date" label="当次审核">
			<el-table-column label="打码量"></el-table-column>
			<el-table-column label="入款"></el-table-column>
			<el-table-column label="打码量÷入款"></el-table-column>
			<el-table-column label="达标"></el-table-column>
		</el-table-column>
		<el-table-column prop="date" label="累计审核">
			<el-table-column label="打码量"></el-table-column>
			<el-table-column label="入款"></el-table-column>
			<el-table-column label="打码量÷入款"></el-table-column>
			<el-table-column label="达标"></el-table-column>
			<el-table-column label="需扣款"></el-table-column>
		</el-table-column>
		<el-table-column label="需几倍打码量"></el-table-column>
	</el-table>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/element-ui@2.2.2/lib/index.min.js"></script>
<script>
var orderId = '<?=$orderId?>';
var vm = new Vue({
	data: {
		order:{},
		form:{status:'1',fee:'0'},
		damaData:[]
	},
	created: function() {
		var _self = this;
		$.getJSON('?act=order&id='+orderId, function(res){
			_self.order = res;
		});
		$.getJSON('api.php?mid='+orderId, function(res){
			console.log(res);
			_self.damaData = res;
		});
	}
}).$mount('#app');
</script>
</body>
</html>
<?php exit;?>
<script language="JavaScript" src="../../js/jquery.js"></script> 
<script language="javascript">    
function chang(){ 
  var type  	  =  	  $("input[name='status']:checked").val();
  if(type == 1){ 
	  $("#d_txt").html('请填写本次汇款的实际手续费');
	  $("#d_text").html("<input name=\"sxf\" type=\"text\" id=\"sxf\" size=\"20\" maxlength=\"20\">&nbsp;元");
  }else if(type == 0){ 
	  $("#d_txt").html('请填写未支付原因');
	  $("#d_text").html("<textarea name=\"about\" id=\"about\" cols=\"45\" rows=\"5\"><?=$rows['about']?></textarea>");
  }else{ 
	  $("#d_txt").html('&nbsp;');
	  $("#d_text").html('&nbsp;');
  } 
} 

function check(){ 
  var type  	  =  	  $("input[name='status']:checked").val();
  if(type == 1){ 
	  if($("#sxf").val().length < 1){ 
		  alert('请您填写本次汇款的实际手续费');
		  $("#sxf").focus();
		  return false;
	  }else{ 
		  var sxf = $("#sxf").val()*1;
		  if(sxf>2000 || sxf<0){ 
			  alert('请输入正确的手续费');
			  $("#sxf").select();
			  return false;
		  } 
	  } 
  }else{ 
	  if($("#about").val().length < 4){ 
		  alert('请填写未支付原因');
		  $("#about").focus();
		  return false;
	  } 
  } 
  return true;
} 
</script> 
</HEAD> 

<body>
<?php 
	if ($_GET['action'] == 'save'){
	$m_id = intval($_GET['m_id']);
	$msg = '';
	$num = 0;
	if ($_POST['status'] == NULL){
		message('操作无效');
	}
	
	if ($_POST['status'] == 1){
		$sxf = trim($_POST['sxf']);
		$params = array(':sxf' => $sxf, ':m_id' => $m_id);
		$sql = 'update k_money set `status`=1,update_time=now(),sxf=:sxf where `status`=2 and m_id=:m_id';
		$msg = '审核了编号为' . $m_id . '的提款单,已支付';
		$num = 1;
	}else if ($_POST['status'] == 0){
		if (strpos($_POST['m_order'], '代理额度')){
			$params = array(':about' => $_POST['about'], ':m_id' => $m_id);
			$sql = 'update k_money set `status`=0,update_time=now(),about=:about where `status`=2 and m_id=:m_id';
			$num = 1;
		}else{
			$params = array(':about' => $_POST['about'], ':m_id' => $m_id);
			$sql = 'update k_money,k_user set k_money.status=0,k_money.update_time=now(),k_money.about=:about,k_user.money=k_user.money-k_money.m_value,k_money.balance=k_user.money-k_money.m_value where k_user.uid=k_money.uid and k_money.status=2 and k_money.m_id=:m_id';
			$num = 2;
			$msg = '审核了编号为' . $m_id . '的提款单,未支付,原因' . $_POST['about'];
		}
	}else{
		message('操作无效');
	}
	$bool = true;
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	$creationTime = date('Y-m-d H:i:s');
	$params = array(':creationTime' => $creationTime, ':m_id' => $m_id);
	$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)
	SELECT k_user.uid,k_user.username,"TIKUAN","CANCEL_OUT",k_money.m_order,-k_money.m_value,k_user.money+k_money.m_value,k_user.money,:creationTime FROM k_user,k_money WHERE k_user.uid=k_money.uid AND k_money.status=0  AND k_money.m_id=:m_id';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	if ($_POST['status'] == 0){
		if (strpos($_POST['m_order'], '代理额度')){
			$params = array(':uid' => $_POST['uid'], ':month' => date('Y-m', time()) . '%');
			$sql = 'delete from k_user_daili_result where uid=:uid and `type`=2 and month like(:month)';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$q2 = $stmt->rowCount();
			if ($q2 != 1){
				$bool = false;
			}
		}
	}
	
	if (($q1 == $num) && $bool){
		if (($num == 2) && ($_POST['about'] != '')){
			include_once '../../class/user.php';
			user::msg_add($_POST['uid'], $web_site['reg_msg_from'], '审核了编号为' . $m_id . '的提款单,未支付', $_POST['about']);
		}
		include_once '../../class/admin.php';
		admin::insert_log($_SESSION['adminid'], $msg);
		message('操作成功', 'tixian.php?status=2');
	}else{
		message('操作失败');
	}
}
?> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;账单详细查看</font></td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"> 
<br>
<?php 
$params = array(':m_id' => intval($_GET['id']));
$sql = 'select k_money.*,k_user.username,k_user.why,k_user.pay_name,agUserName,agqUserName,bbinUserName,ogUserName,mayaUserName,shabaUserName,mgUserName,ptUserName,ipmUserName,mwUserName,kgUserName,cq9UserName,mg2UserName,vrUserName,bgUserName,sbUserName from k_money left join k_user on k_money.uid=k_user.uid  where  k_money.m_id=:m_id';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetch();
?> 
<form action="<?=$_SERVER['PHP_SELF']?>?action=save&m_id=<?=$rows['m_id']?>" method="post" name="form1" id="form1" onSubmit="return check();"> 
<table width="90%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" align="center"> 
<tr> 
  <td bgcolor="#F0FFFF">用户名</td> 
  <td><a href="../hygl/user_show.php?id=<?=$rows['uid']?>"><?=$rows['username']?><input name="uid" type="hidden" id="uid" value="<?=$rows['uid']?>"> 
  </a></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">用户备注</td> 
  <td><?=$rows['why']?></td> 
</tr>
<tr> 
  <td bgcolor="#F0FFFF">真人用户名</td> 
  <td style="line-height:24px;" class="zr">
<span>AG国际厅 => <?=$rows['agUserName']?></span>
<span>AG极速厅 => <?=$rows['agqUserName']?></span>
<span>BB波音厅 => <?=$rows['bbinUserName']?></span>
<span>OG东方厅 => <?=$rows['ogUserName']?></span>
<span>PT电子 => <?=$rows['ptUserName']?></span>
<span>MG电子 => <?=$rows['mgUserName']?></span>
<span>MW电子 => <?=$rows['mwUserName']?></span>
<span>玛雅娱乐厅 => <?=$rows['mayaUserName']?></span>
<span>沙巴体育 => <?=$rows['shabaUserName']?></span>
<span>IPM体育 => <?=$rows['ipmUserName']?></span>
<span>AV女优 => <?=$rows['kgUserName']?></span>
<span>CQ9电子 => <?=$rows['cq9UserName']?></span>
<span>新MG电子 => <?=$rows['mg2UserName']?></span>
<span>VR彩票 => <?=$rows['vrUserName']?></span>
<span>BG视讯 => <?=$rows['bgUserName']?></span>
<span>申博视讯 => <?=$rows['sbUserName']?></span>
  </td> 
</tr>
<tr> 
  <td bgcolor="#F0FFFF">订单号</td> 
  <td><?=$rows['m_order']?><input name="m_order" type="hidden" id="m_order" value="<?=$rows['m_order']?>"></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">开户行</td> 
  <td><?=$rows['pay_card']?></td> 
</tr> 
<tr> 
  <td width="172" bgcolor="#F0FFFF">卡号</td> 
  <td width="473"><?=$rows['pay_num']?></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">开户姓名</td> 
  <td><?=$rows['pay_name']?></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">开户地址</td> 
  <td><?=$rows['pay_address']?></td> 
</tr> 
<tr>
    <td bgcolor="#F0FFFF">取款前余额</td>
    <td><span style="color:#999999;"><?=sprintf("%.2f",$rows["assets"])?></span></td>
  </tr>
  <tr>
    <td bgcolor="#F0FFFF">金额</td>
    <td><?=sprintf("%.2f",abs($rows["m_value"]))?></td>
  </tr>
  <tr>
    <td bgcolor="#F0FFFF">取款后余额</td>
    <td><span style="color:#999999;"><?=sprintf("%.2f",$rows["balance"])?></span></td>
  </tr>
<tr> 
  <td bgcolor="#F0FFFF">申请时间</td> 
  <td><?=$rows['m_make_time']?></td> 
</tr>
<?php if ($rows['status'] == 2){?>   
<tr> 
  <td bgcolor="#F0FFFF">操作</td> 
  <td> 
	<input name="status" type="radio" id="status" onClick="chang()" value="1" checked><span style="color:#009900">已支付</span> 
	&nbsp;
	<input type="radio" name="status" id="status" onClick="chang()" value="0"><span style="color:#FF0000">未支付</span></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF"><div id="d_txt">请填写本次汇款的实际手续费</div></td> 
  <td><div id="d_text"><input name="sxf" type="text" id="sxf" size="20" maxlength="20" value="0"> 
  &nbsp;元</div></td> 
</tr>
<?php 
}

if ($rows['status'] == 2){
?>  
<tr> 
  <td bgcolor="#F0FFFF">操作</td> 
  <td><input type="submit" value="提交"/></td> 
</tr>
<?php }else{?>   
<tr> 
  <td bgcolor="#F0FFFF">状态</td> 
  <td>
<?php
if ($rows['status'] == 1){
	echo '<span style="color:#006600;">成功</span>';
}else{
	echo '<span style="color:#FF0000;">失败</span>';
}
?> 
</td> 
</tr> 
  <tr> 
  <td bgcolor="#F0FFFF">处理时间</td> 
  <td><?=$rows['update_time']?></td> 
</tr> 
<tr> 
  <td bgcolor="#F0FFFF">原因</td> 
  <td><?=$rows['about']?></td> 
</tr>
<?php }?> 
</table> 
</form> 
</td> 
</tr> 
</table>
<?php include_once 'tkdama.php'; ?>
</body> 
</html>