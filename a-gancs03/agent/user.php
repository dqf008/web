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
$agent_id = [];
$agent_count = 0;
if(isset($_GET['key'])&&!empty($_GET['key'])&&isset($_GET['id'])&&!empty($_GET['id'])&&$_GET['key']==hash('sha256', $_GET['id'].$hash256)){
	$agent_id = explode(',', $_GET['id']);
	$agent_count = count($agent_id);
	$page['url'].= 'id='.$_GET['id'].'&amp;key='.$_GET['key'].'&amp;';
}else{
	$_GET['id'] = '';
	$_GET['key'] = '';
}
$groups = get_agent_groups();
$agent_config = [];
$super_tid = 0;
$_GET['username'] = isset($_GET['username'])?$_GET['username']:'';
$_GET['stime'] = isset($_GET['stime'])?strtotime($_GET['stime']):0;
$_GET['etime'] = isset($_GET['etime'])?strtotime($_GET['etime']):0;
$_GET['stime']<=0&&$_GET['stime'] = time()-604800;
$_GET['etime']<=0&&$_GET['etime'] = time()-86400;
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
$agent_list = [];
$stmt = $mydata1_db->query('SELECT `uid`, `username` FROM `k_user` WHERE `is_daili`=1');
while ($rows = $stmt->fetch()) {
	$agent_list[$rows['uid']] = $rows['username'];
}
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
			$(".layer-details").on("click", function(){
				var e = $(this), s = e.data("formula");
				layer.open({
					type: 2,
					shadeClose: true,
					fix: true,
					skin: 'layui-layer-lan',
					title: "直属会员统计数据",
					content: e.attr("href"),
					area: ['800px', '500px'],
					shift: 0,
					scrollbar: false
				});
				window.onMessage = function(){
					return s?decodeURIComponent(s.replace(/\+/g, "%20")):'';
				}
				return false;
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
			$(".change-group").on("click", function(){
				var n = checkbox.not(":first").filter(":checked").size();
				window.onMessage = function(tid, name){
					if(confirm("确定要切换已选择的 "+n+" 位代理的代理组为 "+name+"？\n提示：切换后将不能恢复原来代理组")){
						$("input[name=message]").val(tid);
						$("input[name=action]").val("change_group").parent().trigger("submit");
					}
				};
				if(n>0){
					layer.open({
						type: 2,
						shadeClose: true,
						fix: true,
						skin: 'layui-layer-lan',
						title: "请选择目标代理组",
						content: 'select.php?action=change_group',
						area: ['600px', '300px'],
						shift: 0,
						scrollbar: false
					});
				}else{
					alert("请选择需要进行操作的代理");
				}
			});
			$(".change-agent").on("click", function(){
				var n = checkbox.not(":first").filter(":checked").size();
				window.onMessage = function(uid, username){
					if(confirm("确定要切换已选择的 "+n+" 位代理的上层代理为 "+username+"？\n提示：切换后将不能恢复原来上下层代理关系")){
						$("input[name=message]").val(uid);
						$("input[name=action]").val("change_agent").parent().trigger("submit");
					}
				};
				if(n>0){
					layer.open({
						type: 2,
						shadeClose: true,
						fix: true,
						skin: 'layui-layer-lan',
						title: "请选择目标代理",
						content: 'select.php?action=change_agent',
						area: ['600px', '300px'],
						shift: 0,
						scrollbar: false
					});
				}else{
					alert("请选择需要进行操作的代理");
				}
			});
			$(".cancel-agent").on("click", function(){
				var n = checkbox.not(":first").filter(":checked").size();
				if(n>0){
					if(confirm("确定要取消已选择的 "+n+" 位会员的代理？")){
						if(confirm("是否同时取消下层代理关系？\n提示：取消后将不能恢复下层代理关系")){
							$("input[name=message]").val("clear");
						}
						$("input[name=action]").val("cancel_agent").parent().trigger("submit");
					}
				}else{
					alert("请选择需要进行操作的代理");
				}
			});
			$(".cancel-top").on("click", function(){
				var n = checkbox.not(":first").filter(":checked").size();
				if(n>0){
					if(confirm("确定要取消已选择的 "+n+" 位代理与上层代理关系？\n提示：取消后将不能恢复代理关系")){
						$("input[name=action]").val("cancel_top").parent().trigger("submit");
					}
				}else{
					alert("请选择需要进行操作的代理");
				}
			});
			$(".agent-checkout-all").on("click", function(){
				if(confirm("已选日期：<?php echo $_GET['stime'].' 至 '.$_GET['etime']; ?>\n已选代理组：<?php echo $_GET['tid']>0?$groups[$_GET['tid']]['rows_name']:'全部代理组'; ?>\n请您核对日期、代理组与代理报表\n确认无误后开始进行结算")){
                    window.sessionStorage.removeItem("__CHECKOUT_list");
                    window.sessionStorage.removeItem("__CHECKOUT_count");
					layer.open({
						type: 2,
						shadeClose: true,
						fix: true,
						skin: 'layui-layer-lan',
						title: "结算全部代理佣金",
						content: 'select.php?action=agent_checkout&amp;tid=<?php echo $_GET['tid']; ?>&amp;stime=<?php echo $stime; ?>&amp;etime=<?php echo $etime; ?>&amp;key=<?php $ckKey = hash('sha256', $_GET['tid'].$stime.$etime.$hash256);echo $ckKey; ?>',
						area: ['800px', '500px'],
						shift: 0,
						scrollbar: false
					});
				}
			});
			$(".agent-checkout").on("click", function(){
                var e = checkbox.not(":first").filter(":checked"), n = e.size();
                function setData($name, $string){
                    return window.sessionStorage.setItem("__CHECKOUT_"+$name, window.JSON.stringify($string));
                }
                if(n>0){
                    if(confirm("已选日期：<?php echo $_GET['stime'].' 至 '.$_GET['etime']; ?>\n已选代理：共 "+n+" 位\n请您核对日期、已选代理与代理报表\n确认无误后开始进行结算")){
                        setData("list", e.map(function () {
                            var t = $(this);
                            return {
                                uid: t.val(),
                                username: t.data("username"),
                                fullname: t.data("fullname"),
                                tid: t.data("tid"),
                                key: t.data("key")
                            };
                        }).get());
                        setData("count", [n, 0, 0]);
                        layer.open({
                            type: 2,
                            shadeClose: true,
                            fix: true,
                            skin: 'layui-layer-lan',
                            title: "结算代理佣金",
                            content: 'select.php?action=agent_checkout&amp;tid=<?php echo $_GET['tid']; ?>&amp;stime=<?php echo $stime; ?>&amp;etime=<?php echo $etime; ?>&amp;key=<?php echo $ckKey; ?>&amp;single=true',
                            area: ['800px', '500px'],
                            shift: 0,
                            scrollbar: false
                        });
                    }
                }else{
                    alert("请选择需要进行操作的代理");
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
							<td align="center" bgcolor="#3C4D82" style="color:#FFF"><strong>代理报表</strong></td>
						</tr>
						<tr>
							<td align="left" bgcolor="#FFFFFF" style="color:#000">
								<form action="user.php" method="get">
									<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
									<input type="hidden" name="key" value="<?php echo $_GET['key']; ?>">
									<label>代理账号或真实名字：</label>
									<input name="username" type="text" value="<?php echo $_GET['username']; ?>" size="15" />
									<label>日期：</label>
									<input name="stime" type="text" value="<?php echo $_GET['stime']; ?>" onclick="new Calendar(<?php echo (date('Y')-5).', '.date('Y'); ?>).show(this);" size="10" maxlength="10" readonly="readonly" />&nbsp;~&nbsp;<input name="etime" type="text" value="<?php echo $_GET['etime']; ?>" onclick="new Calendar(<?php echo (date('Y')-5).', '.date('Y'); ?>).show(this);" size="10" maxlength="10" readonly="readonly" />
<?php if($agent_count<=0){ ?>									<label>代理组：</label>
									<select name="tid">
										<option value="0">全部代理组</option>
<?php foreach($groups as $id=>$rows){if($rows['rows_tid']==0){ ?>										<option value="<?php echo $id; ?>"<?php echo $_GET['tid']==$id?' selected="true"':''; ?>><?php echo $rows['rows_name']; ?></option>
<?php }}} ?>									</select>
									<input type="submit" value="搜索" />
									<label<?php echo $agent_count>0?'':' style="display:none"'; ?>><a href="?stime=<?php echo $_GET['stime']; ?>&amp;etime=<?php echo $_GET['etime']; ?>">当前显示为团队代理，点击这里显示全部代理</a></label>
								</form>
							</td>
						</tr>
						<tr>
							<td align="left" bgcolor="#FFFFFF" style="color:#000">
								<label>批量操作：</label>
								<button class="cancel-agent">取消代理</button>
								<button class="cancel-top">取消上层代理</button>
								<button class="change-agent">切换上层代理</button>
<?php if($agent_count<=0){ ?>								<button class="change-group">切换代理组</button>
                                <button class="agent-checkout">佣金结算</button>
<?php } ?>								<label>快速选择日期：</label>
								<button class="quick-select">今日</button>
								<button class="quick-select">昨日</button>
								<button class="quick-select">本周</button>
								<button class="quick-select">上周</button>
								<button class="quick-select">本月</button>
								<button class="quick-select">上月</button>
								<button class="quick-select">半年</button>
								<button class="quick-select">一年</button>
<?php if($agent_count<=0){ ?>								<label>快捷功能：</label>
								<button class="agent-checkout-all">结算全部代理佣金</button>
<?php } ?>							</td>
						</tr>
					</table>
					<form action="action.php" method="post">
						<input type="hidden" name="action">
						<input type="hidden" name="message">
						<table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
							<tr style="background-color:#3C4D82;color:#FFF">
								<td height="22" align="center"><input type="checkbox"></td>
								<td height="22" align="center"><strong>代理账号</strong></td>
								<td height="22" align="center"><strong>真实名字</strong></td>
								<td height="22" align="center"><strong>上层代理</strong></td>
								<td height="22" align="center"><strong>代理组</strong></td>
								<td height="22" align="center"><strong>注单数量 *</strong></td>
								<td height="22" align="center"><strong>注单金额 *</strong></td>
								<td height="22" align="center"><strong>派彩金额 *</strong></td>
								<td height="22" align="center"><strong>有效投注额 *</strong></td>
								<td height="22" align="center"><strong>直属佣金 *</strong></td>
								<td height="22" align="center"><strong>团队佣金</strong></td>
								<td height="22" align="center"><strong>操作</strong></td>
							</tr>
<?php
$sql = [
	'SELECT COUNT(*) AS `count` FROM `k_user` AS `u` LEFT JOIN `agent_config` AS `c` ON `u`.`uid`=`c`.`uid` WHERE `u`.`is_daili`=1 AND `u`.`is_stop`=0 AND `u`.`is_delete`=0',
	'SELECT `u`.`uid`, `c`.`tid`, `u`.`username`, `u`.`pay_name`, `u`.`top_uid` FROM `k_user` AS `u` LEFT JOIN `agent_config` AS `c` ON `u`.`uid`=`c`.`uid` WHERE `u`.`is_daili`=1 AND `u`.`is_stop`=0 AND `u`.`is_delete`=0 ORDER BY `u`.`uid` DESC LIMIT :index, :limit',
];
$params = [];
$page['url'].= 'stime='.$_GET['stime'].'&amp;etime='.$_GET['etime'];
if($_GET['tid']>0){
	$sql = str_replace(' WHERE ', ' WHERE `c`.`tid`=:tid AND ', $sql);
	$params[':tid'] = $_GET['tid'];
	$page['url'].= '&amp;tid='.rawurlencode($_GET['tid']);
}
if(!empty($_GET['username'])){
	$sql = str_replace(' WHERE ', ' WHERE (`u`.`username` LIKE :username1 OR `u`.`pay_name` LIKE :username2) AND ', $sql);
	$params[':username1'] = $params[':username2'] = '%'.$_GET['username'].'%';
	$page['url'].= '&amp;username='.rawurlencode($_GET['username']);
}
if(!empty($agent_id)){
	$sql = str_replace(' WHERE ', ' WHERE `u`.`top_uid`=:uid AND ', $sql);
	$params[':uid'] = $agent_id[$agent_count-1];
	$stmt = $mydata1_db->prepare('SELECT `u`.`uid`, `c`.`tid`, `u`.`username`, `u`.`pay_name`, `u`.`top_uid` FROM `k_user` AS `u` LEFT JOIN `agent_config` AS `c` ON `u`.`uid`=`c`.`uid` WHERE `u`.`uid` IN (?'.str_repeat(', ?', $agent_count-1).') AND `u`.`is_daili`=1 AND `u`.`is_stop`=0 AND `u`.`is_delete`=0 ORDER BY `u`.`uid`');
	$stmt->execute($agent_id);
	$top_agent = [];
	$top_uid = [];
	while ($rows = $stmt->fetch()) {
		$top_agent[$rows['uid']] = $rows;
	}
	foreach($agent_id as $key=>$uid){
		$rows = $top_agent[$uid];
		$formula = '';
		$rows['bet_amount'] = 0;
		$rows['net_amount'] = 0;
		$rows['valid_amount'] = 0;
		$rows['rows_num'] = 0;
		$rows['pay_amount'] = 0;
		$rows['team_amount'] = 0;
		$super_tid>0&&$rows['tid'] = $super_tid;
		$key<=0&&$super_tid = $rows['tid'];
		$team = false;
		if(!empty($rows['tid'])&&isset($groups[$rows['tid']])){
			$team = isset($groups[$rows['tid']]['child_groups']);
			if(!isset($agent_config[$rows['tid']])){
				$agent_config[$rows['tid']] = [get_agent_config($groups[$rows['tid']])];
				$team&&$agent_config[$rows['tid']] = get_child_agent_config($agent_config[$rows['tid']][0], $groups, $groups[$rows['tid']]['child_groups']);
			}
			$data = get_agent_details($rows['uid'], $agent_config[$rows['tid']], $stime, $etime, $team, $key, true);
			$formula = get_formula($agent_config[$rows['tid']][$key]);
			foreach($data as $k=>$v){
				$rows[$k]+= $v;
			}
		}
		$top_uid[] = $rows['uid'];
		$rows['agent_id'] = implode(',', $top_uid);
		$rows['key'] = hash('sha256', $rows['agent_id'].$hash256);
?>							<tr style="background-color:#FFFFFF;line-height:20px;" class="data-list">
								<td align="center"><input type="checkbox" disabled="true"></td>
								<td align="center">「<?php echo $key<=0?'顶层':'第'.$key.'层'; ?>」<a href="../hygl/user_show.php?id=<?php echo $rows['uid']; ?>"><?php echo $rows['username']; ?></a></td>
								<td align="center"><a href="../hygl/list.php?likevalue=<?php echo rawurlencode($rows['pay_name']); ?>&selecttype=pay_name"><?php echo $rows['pay_name']; ?></a></td>
								<td align="center"><?php if(isset($agent_list[$rows['top_uid']])){ ?><a href="../hygl/user_show.php?id=<?php echo $rows['top_uid']; ?>"><?php echo $agent_list[$rows['top_uid']]; ?></a><?php }else{echo '--';} ?></td>
								<td align="center"><?php if(isset($groups[$rows['tid']])){ ?><a href="add.php?id=<?php echo $rows['tid']; ?>"><?php echo $groups[$rows['tid']]['rows_name']; ?></a><?php }else{echo '暂无分组';} ?></td>
								<td align="center"><?php echo $rows['rows_num']; ?></td>
								<td align="center"><?php echo sprintf('%.2f', $rows['bet_amount']/100); ?></td>
								<td align="center"><span style="color:<?php echo $rows['net_amount']>=0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $rows['net_amount']/100); ?></span></td>
								<td align="center"><?php echo sprintf('%.2f', $rows['valid_amount']/100); ?></td>
								<td align="center"><span style="color:<?php echo $rows['pay_amount']<0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $rows['pay_amount']/100); ?></span></td>
								<td align="center"><span style="color:<?php echo $rows['team_amount']<0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $rows['team_amount']/100); ?></span></td>
								<td align="center"><a href="details.php?id=<?php echo $rows['uid']; ?>&amp;stime=<?php echo $stime; ?>&amp;etime=<?php echo $etime; ?>" class="layer-details" data-formula="<?php echo rawurlencode($formula); ?>">查看统计数据</a><?php if($key+1<$agent_count){ ?>&nbsp;<a href="?stime=<?php echo $_GET['stime']; ?>&amp;etime=<?php echo $_GET['etime']; ?>&amp;id=<?php echo $rows['agent_id']; ?>&amp;key=<?php echo $rows['key']; ?>">返回该层代理</a><?php } ?></td>
							</tr>
<?php } ?>							<tr style="background-color:#aee0f7;">
								<td align="center" colspan="12">以下为「<?php echo '第'.$agent_count.'层'; ?>」代理</td>
							</tr>
<?php
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
		'bet_amount' => 0,
		'net_amount' => 0,
		'valid_amount' => 0,
		'rows_num' => 0,
		'pay_amount' => 0,
		'team_amount' => 0,
	];
	while ($rows = $stmt->fetch()) {
		$rows['bet_amount'] = 0;
		$rows['net_amount'] = 0;
		$rows['valid_amount'] = 0;
		$rows['rows_num'] = 0;
		$rows['pay_amount'] = 0;
		$rows['team_amount'] = 0;
		$child_tid = $rows['tid'];
		$super_tid>0&&$rows['tid'] = $super_tid;
		$team = false;
		$formula = '';
		if(!empty($rows['tid'])&&isset($groups[$rows['tid']])){
			$team = isset($groups[$rows['tid']]['child_groups'])&&$agent_count<count($groups[$rows['tid']]['child_groups']);
			if(!isset($agent_config[$rows['tid']])){
				$agent_config[$rows['tid']] = [get_agent_config($groups[$rows['tid']])];
				$team&&$agent_config[$rows['tid']] = get_child_agent_config($agent_config[$rows['tid']][0], $groups, $groups[$rows['tid']]['child_groups']);
			}
			$data = get_agent_details($rows['uid'], $agent_config[$rows['tid']], $stime, $etime, $team, $agent_count, $agent_count>0);
			$formula = get_formula($agent_config[$rows['tid']][$agent_count]);
			if(isset($groups[$rows['tid']]['child_groups'][$agent_count-1])){
                $child_tid = $groups[$rows['tid']]['child_groups'][$agent_count-1];
            }
			foreach($data as $k=>$v){
				$rows[$k]+= $v;
				$total[$k]+= $v;
			}
		}
		$rows['agent_id'] = $agent_id;
		$rows['agent_id'][] = $rows['uid'];
		$rows['agent_id'] = implode(',', $rows['agent_id']);
		$rows['key'] = hash('sha256', $rows['agent_id'].$hash256);
		$rows['ukey'] = $agent_count<=0?hash('sha256', $rows['uid'].$rows['tid'].$ckKey):'';
?>							<tr style="background-color:#FFFFFF;line-height:20px;" class="data-list">
								<td align="center"><input type="checkbox" name="uid[]" value="<?php echo $rows['uid']; ?>" data-key="<?php echo $rows['ukey']; ?>" data-tid="<?php echo $rows['tid']; ?>" data-fullname="<?php echo $rows['pay_name']; ?>" data-username="<?php echo $rows['username']; ?>"></td>
								<td align="center"><a href="../hygl/user_show.php?id=<?php echo $rows['uid']; ?>"><?php echo $rows['username']; ?></a></td>
								<td align="center"><a href="../hygl/list.php?likevalue=<?php echo rawurlencode($rows['pay_name']); ?>&selecttype=pay_name"><?php echo $rows['pay_name']; ?></a></td>
								<td align="center"><?php if(isset($agent_list[$rows['top_uid']])){ ?><a href="../hygl/user_show.php?id=<?php echo $rows['top_uid']; ?>"><?php echo $agent_list[$rows['top_uid']]; ?></a><?php }else{echo '--';} ?></td>
								<td align="center"><?php if(isset($groups[$child_tid])){ ?><a href="add.php?id=<?php echo $child_tid; ?>"><?php echo $groups[$child_tid]['rows_name']; ?></a><?php }else{echo '暂无分组';} ?></td>
								<td align="center"><?php echo $rows['rows_num']; ?></td>
								<td align="center"><?php echo sprintf('%.2f', $rows['bet_amount']/100); ?></td>
								<td align="center"><span style="color:<?php echo $rows['net_amount']>=0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $rows['net_amount']/100); ?></span></td>
								<td align="center"><?php echo sprintf('%.2f', $rows['valid_amount']/100); ?></td>
								<td align="center"><span style="color:<?php echo $rows['pay_amount']<0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $rows['pay_amount']/100); ?></span></td>
								<td align="center"><span style="color:<?php echo $rows['team_amount']<0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $rows['team_amount']/100); ?></span></td>
								<td align="center"><a href="details.php?id=<?php echo $rows['uid']; ?>&amp;stime=<?php echo $stime; ?>&amp;etime=<?php echo $etime; ?>" class="layer-details" data-formula="<?php echo rawurlencode($formula); ?>">查看统计数据</a><?php if($team){ ?>&nbsp;<a href="?stime=<?php echo $_GET['stime']; ?>&amp;etime=<?php echo $_GET['etime']; ?>&amp;id=<?php echo $rows['agent_id']; ?>&amp;key=<?php echo $rows['key']; ?>">团队佣金详情</a><?php } ?></td>
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
								<td align="center"><?php echo $total['rows_num']; ?></td>
								<td align="center"><?php echo sprintf('%.2f', $total['bet_amount']/100); ?></td>
								<td align="center"><span style="color:<?php echo $total['net_amount']>=0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $total['net_amount']/100); ?></span></td>
								<td align="center"><?php echo sprintf('%.2f', $total['valid_amount']/100); ?></td>
								<td align="center"><span style="color:<?php echo $total['pay_amount']<0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $total['pay_amount']/100); ?></span></td>
								<td align="center"><span style="color:<?php echo $total['team_amount']<0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $total['team_amount']/100); ?></span></td>
								<td>--</td> 
							</tr>
							<tr style="background-color:#FFF">
								<td colspan="12" align="center" valign="middle">
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
					<table width="100%" border="0" cellpadding="5" cellspacing="0" class="font12" style="margin-top:5px;line-height:20px;">
						<tr>
							<td>
								<p>* 仅有效直属会员数据。</p>
								<p style="color:#f00">1、代理报表非实时结果，需要等待系统生成报表后才能查询！</p>
								<p style="color:#f00">2、数据统计时间、报表时间均为美东时间。</p>
								<p>3、上层“团队佣金” = 下层“直属佣金”+下层“团队佣金”。</p>
								<p>4、允许循环代理关系，例如：A是B的下层代理，同时B是A的下层代理。</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>