<?php
define('IN_AGENT', dirname(__FILE__).'/');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
include IN_AGENT.'functions.php';

check_quanxian('dlgl');
$page = array('limit' => 50, 'url' => '?');
$page['cur'] = isset($_GET['page'])?$_GET['page']:'1';
$hash256 = session_name().$_SESSION['login_name'];
$_GET['username'] = isset($_GET['username'])?$_GET['username']:'';
$_GET['no'] = isset($_GET['no'])?$_GET['no']:'';
$_GET['stime'] = isset($_GET['stime'])?strtotime($_GET['stime']):0;
$_GET['etime'] = isset($_GET['etime'])?strtotime($_GET['etime']):0;
$_GET['stime']<=0&&$_GET['stime'] = time()-518400;
$_GET['etime']<=0&&$_GET['etime'] = time();
if($_GET['stime']>$_GET['etime']){
	$_GET['stime'] = [$_GET['stime'], $_GET['etime']];
	$_GET['etime'] = $_GET['stime'][0];
	$_GET['stime'] = $_GET['stime'][1];
}
$_GET['stime'] = date('Y-m-d', $_GET['stime']);
$_GET['etime'] = date('Y-m-d', $_GET['etime']);
$stime = strtotime($_GET['stime'].' 00:00:00');
$etime = strtotime($_GET['etime'].' 23:59:59');
$_GET['tid'] = isset($_GET['tid'])&&array_key_exists($_GET['tid'], $groups)?$_GET['tid']:0;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Welcome</title>
	<link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" />
	<style type="text/css">
		.menu_curr {color:#FF0;font-weight:bold} 
		.menu_com {color:#FFF;font-weight:bold} 
		.sub_curr {color:#f00;font-weight:bold} 
		.sub_com {color:#333;font-weight:bold} 
	</style>
	<script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
	<script type="text/javascript" charset="utf-8" src="/js/calendar.js"></script>
	<script type="text/javascript" charset="utf-8" src="../js/layer/layer.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var checkbox = $("input[type=checkbox]").not(":disabled");
			checkbox.prop("checked", false).parent().on("click", function(event){
				var t = $(this), e = t.find("[type=checkbox]");
				$(event.target).prop("tagName")==t.prop("tagName")&&e.prop("checked", !e.is(":checked"));
				if(!e.prop("name")){
					checkbox.prop("checked", e.is(":checked"));
					if(e.is(":checked")){
						checkbox.not(":first").closest("tr").data("color", "#d2d2d2").css("backgroundColor", "#d2d2d2");
					}else{
						checkbox.not(":first").closest("tr").removeData("color").css("backgroundColor", "#fff");
					}
				}else{
					if(e.is(":checked")){
						t.parent().data("color", "#d2d2d2")
					}else{
						t.parent().removeData("color")
					}
					if(checkbox.not(":first").filter(":checked").size()>=checkbox.size()-1){
						checkbox.eq(0).prop("checked", true)
					}else{
						checkbox.eq(0).prop("checked", false)
					}
				}
			}).not(":first").siblings().on("click", function(event){
				var t = $(this);
				$(event.target).prop("tagName")==t.prop("tagName")&&t.parent().find("td:first").trigger("click");
			});
			$(".data-list").on({
				mouseenter: function () {
					$(this).css("backgroundColor", "#ebebeb");
				},
				mouseleave: function () {
					var e = $(this);
					e.css("backgroundColor", e.data("color")?e.data("color"):"#fff");
				}
			});
			$("a.cancel-checkout").on("click", function(){
				return confirm("确定要撤销本条结算单？\n提示：撤销后不能恢复但是可以重新结算；撤销后会员余额可能为负数");
			});
			$(".quick-select").on("click", function(){
				var e = $(this), st = $("input[name=stime]"), et = $("input[name=etime]");
				console.log(e.index());
				switch(e.text()){
					case "今日":
					st.val("<?php $today = date('Y-m-d');echo $today; ?>");
					et.val(st.val());
					break;
					case "昨日":
					st.val("<?php echo date('Y-m-d', time()-86400); ?>");
					et.val(st.val());
					break;
					case "本周":
					st.val("<?php $monday = strtotime('-'.date('w').' days')+86400;echo date('Y-m-d', $monday); ?>");
					et.val("<?php echo date('Y-m-d', $monday+518400); ?>");
					break;
					case "上周":
					st.val("<?php echo date('Y-m-d', $monday-604800); ?>");
					et.val("<?php echo date('Y-m-d', $monday-86400); ?>");
					break;
					case "本月":
					st.val("<?php $month = date('Y-m-01');echo $month; ?>");
					et.val("<?php echo date('Y-m-d', strtotime($month.' +1 month')-86400); ?>");
					break;
					case "上月":
					st.val("<?php echo date('Y-m-d', strtotime($month.' -1 month')); ?>");
					et.val("<?php echo date('Y-m-d', strtotime($month)-86400); ?>");
					break;
					case "半年":
					st.val("<?php echo date('Y-m-d', strtotime('-6 months +1 day')); ?>");
					et.val("<?php echo $today; ?>");
					break;
					case "一年":
					st.val("<?php echo date('Y-m-d', strtotime('-1 year +1 day')); ?>");
					et.val("<?php echo $today; ?>");
					break;
				}
				return false;
			});
			$("button.cancel-checkout").on("click", function(){
				var n = checkbox.not(":first").filter(":checked").size();
				if(n>0){
					if(confirm("确定要撤销已选择的 "+n+" 条结算单？\n提示：撤销后不能恢复但是可以重新结算；撤销后会员余额可能为负数")){
						$("input[name=action]").val("cancel_checkout").parent().trigger("submit");
					}
				}else{
					alert("请选择需要撤销的结算单");
				}
			});
		});
	</script>
</head>
<body>
	<div id="pageMain">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td valign="top">
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
						<tr>
							<td align="center" bgcolor="#3C4D82" style="color:#FFF"><strong>佣金结算列表</strong></td>
						</tr>
						<tr>
							<td align="left" bgcolor="#FFFFFF" style="color:#000">
								<form action="list.php" method="get">
									<label>代理账号或真实名字：</label>
									<input name="username" type="text" value="<?php echo $_GET['username']; ?>" size="15" />
									<label>结算日期：</label>
									<input name="stime" type="text" value="<?php echo $_GET['stime']; ?>" onclick="new Calendar(<?php echo (date('Y')-5).', '.date('Y'); ?>).show(this);" size="10" maxlength="10" readonly="readonly" />&nbsp;~&nbsp;<input name="etime" type="text" value="<?php echo $_GET['etime']; ?>" onclick="new Calendar(<?php echo (date('Y')-5).', '.date('Y'); ?>).show(this);" size="10" maxlength="10" readonly="readonly" />
									<label>结算编号：</label>
									<input name="no" type="text" value="<?php echo $_GET['no']; ?>" size="15" />
									<input type="submit" value="搜索" />
									<label>* 输入结算编号后将不再按照“结算日期”显示</label>
								</form>
							</td>
						</tr>
						<tr>
							<td align="left" bgcolor="#FFFFFF" style="color:#000">
								<label>批量操作：</label>
								<button class="cancel-checkout">撤销结算</button>
								<label>快速选择日期：</label>
								<button class="quick-select">今日</button>
								<button class="quick-select">昨日</button>
								<button class="quick-select">本周</button>
								<button class="quick-select">上周</button>
								<button class="quick-select">本月</button>
								<button class="quick-select">上月</button>
								<button class="quick-select">半年</button>
								<button class="quick-select">一年</button>
							</td>
						</tr>
					</table>
					<form action="action.php" method="post">
						<input type="hidden" name="action">
						<input type="hidden" name="message">
						<table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
							<tr style="background-color:#3C4D82;color:#FFF">
								<td height="22" align="center"><input type="checkbox"></td>
								<td height="22" align="center"><strong>代理账号/真实名字</strong></td>
								<td height="22" align="center"><strong>流水号码/结算编号</strong></td>
								<td height="22" align="center"><strong>结算时间 (美东)</strong></td>
								<td height="22" align="center"><strong>统计时间 (美东)</strong></td>
								<td height="22" align="center"><strong>直属佣金</strong></td>
								<td height="22" align="center"><strong>团队佣金</strong></td>
								<td height="22" align="center"><strong>合计佣金</strong></td>
								<td height="22" align="center"><strong>状态/操作</strong></td>
							</tr>
<?php
$params = [];
if(!empty($_GET['no'])){
	$sql = [
		'SELECT COUNT(*) AS `count` FROM `agent_checkout` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`c`.`uid` WHERE `c`.`starttime`=:stime AND `c`.`endtime`=:etime',
		'SELECT `c`.*, `u`.`pay_name` FROM `agent_checkout` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`c`.`uid` WHERE `c`.`starttime`=:stime AND `c`.`endtime`=:etime ORDER BY `c`.`id` DESC LIMIT :index, :limit',
	];
	$params[':stime'] = 0;
	$params[':etime'] = 0;
	if(preg_match('/^CHECKOUT(\d{4})(\d{2})(\d{2})(\d{4})(\d{2})(\d{2})$/', $_GET['no'], $matches)){
		$params[':stime'] = strtotime($matches[1].'-'.$matches[2].'-'.$matches[3].' 00:00:00');
		$params[':etime'] = strtotime($matches[4].'-'.$matches[5].'-'.$matches[6].' 23:59:59');
	}
}else{
	$sql = [
		'SELECT COUNT(*) AS `count` FROM `agent_checkout` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`c`.`uid` WHERE `c`.`addtime` BETWEEN :stime AND :etime',
		'SELECT `c`.*, `u`.`pay_name` FROM `agent_checkout` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`c`.`uid` WHERE `c`.`addtime` BETWEEN :stime AND :etime ORDER BY `c`.`id` DESC LIMIT :index, :limit',
	];
	$params[':stime'] = $stime;
	$params[':etime'] = $etime;
}
$page['url'].= 'stime='.$_GET['stime'].'&amp;etime='.$_GET['etime'].'&amp;no='.$_GET['no'];
if(!empty($_GET['username'])){
	$sql = str_replace(' WHERE ', ' WHERE (`u`.`username` LIKE :username1 OR `u`.`pay_name` LIKE :username2) AND ', $sql);
	$params[':username1'] = $params[':username2'] = '%'.$_GET['username'].'%';
	$page['url'].= '&amp;username='.rawurlencode($_GET['username']);
}
$stmt = $mydata1_db->prepare($sql[0]);
$stmt->execute($params);
$count = $stmt->fetch();
$page['count'] = $count['count'];
if($page['count']>0){
	$page['all'] = ceil($page['count']/$page['limit']);
	$page['all']<1&&$page['all'] = 1;
	if(is_numeric($page['cur'])&&$page['cur']>0){
		$page['cur']>$page['all']&&$page['cur'] = $page['all'];
	}else{
		$page['cur'] = '1';
	}
	$params[':index'] = ($page['cur']-1)*$page['limit'];
	$params[':limit'] = $page['limit'];
	$stmt = $mydata1_db->prepare($sql[1]);
	$stmt->execute($params);
	$total = [
		'pay_amount' => 0,
		'team_amount' => 0,
		'total_amount' => 0,
	];
	while ($rows = $stmt->fetch()) {
		$rows['value'] = unserialize($rows['value']);
		$rows['value']['total_amount'] = $rows['value']['pay_amount']+$rows['value']['team_amount'];
		$total['pay_amount']+= $rows['value']['pay_amount'];
		$total['team_amount']+= $rows['value']['team_amount'];
		$total['total_amount']+= $rows['value']['total_amount'];
?>							<tr style="background-color:#FFFFFF;line-height:20px;" class="data-list">
								<td align="center"><input type="checkbox"<?php echo $rows['status']==1?' name="uid[]" value="'.$rows['id'].'"':' disabled="true"'; ?>></td>
								<td align="center"><a href="../hygl/user_show.php?id=<?php echo $rows['uid']; ?>"><?php echo $rows['value']['username']; ?></a><br /><a href="../hygl/list.php?likevalue=<?php echo rawurlencode($rows['pay_name']); ?>&selecttype=pay_name"><?php echo $rows['pay_name']; ?></a></td>
								<td align="center"><?php echo $rows['value']['id']; ?><br /><a href="?stime=<?php echo $_GET['stime']; ?>&amp;etime=<?php echo $_GET['etime']; ?>&amp;no=<?php echo $rows['value']['no']; ?>"><?php echo $rows['value']['no']; ?></a></td>
								<td align="center"><?php echo date('Y-m-d H:i:s', $rows['addtime']); ?></td>
								<td align="center"><?php echo date('Y-m-d H:i:s', $rows['starttime']).'<br />'.date('Y-m-d H:i:s', $rows['endtime']); ?></td>
								<td align="center"><span style="color:<?php echo $rows['value']['pay_amount']<0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $rows['value']['pay_amount']/100); ?></span></td>
								<td align="center"><span style="color:<?php echo $rows['value']['team_amount']<0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $rows['value']['team_amount']/100); ?></span></td>
								<td align="center"><span style="color:<?php echo $rows['value']['total_amount']<0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $rows['value']['total_amount']/100); ?></span></td>
								<td align="center"><?php echo $rows['status']==1?'已结算<br /><a href="action.php?action=cancel_checkout&amp;uid[]='.$rows['id'].'" class="cancel-checkout">撤销本单</a>':'<span style="color:#0000FF">已撤销</span>'; ?></td>
							</tr>
<?php
	}
	$page['url'].= '&amp;page=';
	$page['range'] = array(1, $page['all']);
	if($page['all']>5){
		$page['range'][1] = 5;
		if($page['cur']>3){
			$page['range'] = array($page['cur']-2, $page['cur']+2);
		}
		if($page['range'][1]>$page['all']){
			$page['range'] = array($page['all']-4, $page['all']);
		}
	}
?>							<tr align="center" style="background-color:#ffffff;line-height:25px;font-weight: bold;"> 
								<td colspan="5">本页合计</td> 
								<td align="center"><span style="color:<?php echo $total['pay_amount']<0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $total['pay_amount']/100); ?></span></td>
								<td align="center"><span style="color:<?php echo $total['team_amount']<0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $total['team_amount']/100); ?></span></td>
								<td align="center"><span style="color:<?php echo $total['total_amount']<0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $total['total_amount']/100); ?></span></td>
								<td>--</td> 
							</tr>
							<tr style="background-color:#FFF">
								<td colspan="9" align="center" valign="middle">
									<div class="Pagination">
										<a href="<?php echo $page['cur']>1?$page['url'].'1':'javascript:;'; ?>" class="tips">首页</a>
										<a href="<?php echo $page['cur']>1?$page['url'].($page['cur']-1):'javascript:;'; ?>" class="tips">上一页</a>
<?php if($page['range'][0]>1){ ?>										<span class="dot">……</span>
<?php }for($p=$page['range'][0];$p<=$page['range'][1];$p++){ ?>										<a href="<?php echo $page['cur']!=$p?$page['url'].$p:'javascript:;" class="current'; ?>"><?php echo $p; ?></a>
<?php }if($page['range'][1]<$page['all']){ ?>										<span class="dot">……</span>
<?php } ?>										<a href="<?php echo $page['cur']<$page['all']?$page['url'].($page['cur']+1):'javascript:;'; ?>" class="tips">下一页</a>
										<a href="<?php echo $page['cur']<$page['all']?$page['url'].$page['all']:'javascript:;'; ?>" class="tips">末页</a>
									</div>
								</td>
							</tr>
<?php }else{ ?>						<tr style="background-color:#FFF">
							<td colspan="12" align="center" valign="middle">无相关记录</td>
						</tr>
<?php } ?>						</table>
					</form>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>