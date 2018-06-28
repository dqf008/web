<?php
define('IN_AGENT', dirname(__FILE__).'/');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
include IN_AGENT.'functions.php';

check_quanxian('dlgl');
$page = array('limit' => 10);
$page['cur'] = isset($_GET['page'])?$_GET['page']:'1';
switch (true) {
	case !isset($_GET['action']):
	case !in_array($_GET['action'], ['change_agent', 'change_group', 'agent_checkout']):
		message('来源无效');
		break;

	case $_GET['action']=='change_group':
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
	<script type="text/javascript">
		$(document).ready(function(){
			$(".data-list").on({
				mouseenter: function () {
					$(this).css("backgroundColor", "#ebebeb");
				},
				mouseleave: function () {
					$(this).css("backgroundColor", "#fff");
				}
			});
			$(".select-group").on("click", function(){
				var e = $(this);
				window.parent.onMessage&&window.parent.onMessage(e.data("id"), e.data("name"));
			})
		});
	</script>
</head>
<body style="border:none">
	<div id="pageMain">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td valign="top">
					<table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
						<tr style="background-color:#3C4D82;color:#FFF">
							<td height="22" align="center">代理组名字</td>
							<td height="22" align="center">操作</td>
						</tr>
<?php
		$sql = [
			'SELECT COUNT(*) AS `count` FROM `agent_config` WHERE `uid`=0 AND `tid`=0',
			'SELECT `id`, `username` FROM `agent_config` WHERE `uid`=0 AND `tid`=0 ORDER BY `id` DESC LIMIT :index, :limit',
		];
		$params = [];
		$page['url'] = '?action='.$_GET['action'];
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
			while ($rows = $stmt->fetch()) {
?>						<tr style="background-color:#FFFFFF;line-height:20px;" class="data-list">
							<td align="center"><?php echo $rows['username']; ?></td>
							<td align="center"><a href="javascript:;" class="select-group" data-id="<?php echo $rows['id']; ?>" data-name="<?php echo $rows['username']; ?>">选择该代理组</a></td>
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
?>						<tr style="background-color:#FFF">
							<td colspan="2" align="center" valign="middle">
								<div class="Pagination">
									<a href="<?php echo $page['cur']>1?$page['url'].'1':'javascript:;'; ?>" class="tips">首页</a>
									<a href="<?php echo $page['cur']>1?$page['url'].($page['cur']-1):'javascript:;'; ?>" class="tips">上一页</a>
<?php if($page['range'][0]>1){ ?>									<span class="dot">……</span>
<?php }for($p=$page['range'][0];$p<=$page['range'][1];$p++){ ?>									<a href="<?php echo $page['cur']!=$p?$page['url'].$p:'javascript:;" class="current'; ?>"><?php echo $p; ?></a>
<?php }if($page['range'][1]<$page['all']){ ?>									<span class="dot">……</span>
<?php } ?>									<a href="<?php echo $page['cur']<$page['all']?$page['url'].($page['cur']+1):'javascript:;'; ?>" class="tips">下一页</a>
									<a href="<?php echo $page['cur']<$page['all']?$page['url'].$page['all']:'javascript:;'; ?>" class="tips">末页</a>
								</div>
							</td>
						</tr>
<?php }else{ ?>						<tr style="background-color:#FFF">
							<td colspan="3" align="center" valign="middle">无相关记录</td>
						</tr>
<?php } ?>					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
<?php
		break;

	default:
		$_GET['username'] = isset($_GET['username'])?$_GET['username']:'';
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
	<script type="text/javascript">
		$(document).ready(function(){
			$(".data-list").on({
				mouseenter: function () {
					$(this).css("backgroundColor", "#ebebeb");
				},
				mouseleave: function () {
					$(this).css("backgroundColor", "#fff");
				}
			});
			$(".select-agent").on("click", function(){
				var e = $(this);
				window.parent.onMessage&&window.parent.onMessage(e.data("uid"), e.data("username"));
			})
		});
	</script>
</head>
<body style="border:none">
	<div id="pageMain">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td valign="top">
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
						<tr>
							<td align="left" bgcolor="#FFFFFF" style="color:#000">
								<form action="select.php" method="get">
									<input type="hidden" name="action" value="<?php echo $_GET['action']; ?>">
									<label>代理账号或真实名字：</label>
									<input name="username" type="text" value="<?php echo $_GET['username']; ?>" size="15" />
									<input type="submit" value="搜索" />
								</form>
							</td>
						</tr>
					</table>
					<table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
						<tr style="background-color:#3C4D82;color:#FFF">
							<td height="22" align="center">代理账号</td>
							<td height="22" align="center">真实名字</td>
							<td height="22" align="center">操作</td>
						</tr>
<?php
		$sql = [
			'SELECT COUNT(*) AS `count` FROM `k_user` WHERE `is_daili`=1 AND `is_stop`=0 AND `is_delete`=0',
			'SELECT `uid`, `username`, `pay_name` FROM `k_user` WHERE `is_daili`=1 AND `is_stop`=0 AND `is_delete`=0 ORDER BY `uid` DESC LIMIT :index, :limit',
		];
		$params = [];
		$page['url'] = '?action='.$_GET['action'];
		if(!empty($_GET['username'])){
			$sql = str_replace(' WHERE ', ' WHERE (`username` LIKE :username1 OR `pay_name` LIKE :username2) AND ', $sql);
			$params[':username1'] = $params[':username2'] = '%'.$_GET['username'].'%';
			$page['url'].= '&amp;username='.urlencode($_GET['username']);
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
			while ($rows = $stmt->fetch()) {
?>						<tr style="background-color:#FFFFFF;line-height:20px;" class="data-list">
							<td align="center"><?php echo $rows['username']; ?></td>
							<td align="center"><?php echo $rows['pay_name']; ?></td>
							<td align="center"><a href="javascript:;" class="select-agent" data-uid="<?php echo $rows['uid']; ?>" data-username="<?php echo $rows['username']; ?>">选择该代理</a></td>
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
?>						<tr style="background-color:#FFF">
							<td colspan="3" align="center" valign="middle">
								<div class="Pagination">
									<a href="<?php echo $page['cur']>1?$page['url'].'1':'javascript:;'; ?>" class="tips">首页</a>
									<a href="<?php echo $page['cur']>1?$page['url'].($page['cur']-1):'javascript:;'; ?>" class="tips">上一页</a>
<?php if($page['range'][0]>1){ ?>									<span class="dot">……</span>
<?php }for($p=$page['range'][0];$p<=$page['range'][1];$p++){ ?>									<a href="<?php echo $page['cur']!=$p?$page['url'].$p:'javascript:;" class="current'; ?>"><?php echo $p; ?></a>
<?php }if($page['range'][1]<$page['all']){ ?>									<span class="dot">……</span>
<?php } ?>									<a href="<?php echo $page['cur']<$page['all']?$page['url'].($page['cur']+1):'javascript:;'; ?>" class="tips">下一页</a>
									<a href="<?php echo $page['cur']<$page['all']?$page['url'].$page['all']:'javascript:;'; ?>" class="tips">末页</a>
								</div>
							</td>
						</tr>
<?php }else{ ?>						<tr style="background-color:#FFF">
							<td colspan="3" align="center" valign="middle">无相关记录</td>
						</tr>
<?php } ?>					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
<?php
		break;
	case $_GET['action']=='agent_checkout':
		$hash256 = session_name().$_SESSION['login_name'];
		$isSingle = isset($_GET['single'])&&$_GET['single']=='true';
		if(isset($_GET['key'])&&isset($_GET['tid'])&&isset($_GET['stime'])&&isset($_GET['etime'])&&hash('sha256', $_GET['tid'].$_GET['stime'].$_GET['etime'].$hash256)==$_GET['key']){
			$groups = get_agent_groups();
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
	<script type="text/javascript">
		$(document).ready(function(){
		    var tips = $(".checkout-tips td");
            function setData($name, $string){
                return window.sessionStorage.setItem("__CHECKOUT_"+$name, window.JSON.stringify($string));
            }
            function getData($name){
                return window.JSON.parse(window.sessionStorage.getItem("__CHECKOUT_"+$name));
            }
			$(".start-checkout").on("click", function(){
				var e = $(this), loading = $(".loading div"), tipsTimer = setInterval(function(){
					var n = tips.data("n");
					n++;
					switch(n){
						case 1:
						tips.html(tips.data("msg")+" .");
						break;
						case 2:
						tips.html(tips.data("msg")+" ..");
						break;
						case 3:
						tips.html(tips.data("msg")+" ...");
						break;
						default:
						n = 0;
						tips.html(tips.data("msg"));
						break;
					}
					tips.data("n", n);
				}, 1000), status = $(".checkout-status span");
				tips.data("msg", "正在进行，请不要关闭窗口").html("正在进行，请不要关闭窗口");
				e.prop("disabled", true);
				status.html("接收数据");
				function getAjax($action, $data, $success){
					$.ajax({
						url: 'checkout.php',
						data: $.extend({
							action: $action,
							tid: "<?php echo $_GET['tid']; ?>",
							stime: "<?php echo $_GET['stime']; ?>",
							etime: "<?php echo $_GET['etime']; ?>",
							key: "<?php echo $_GET['key']; ?>"
						}, !$success?{}:$data),
						type: "POST",
						dataType: "json",
						success: !$success?(!$data?function(){}:$data):$success
					});
				}
				function checkout(){
					var list = getData("list"), count = getData("count"), user = list.pop();
					getAjax("checkout", {uid: user.uid, utid: user.tid, ukey: user.key}, function(data){
						if(data){
							if(data.status==1){
								count[1]++;
								if(data.money>0){
									tips.parent().after("<tr style=\"background-color:#fff\" class=\"data-list\"><td height=\"22\" align=\"center\">"+user.username+"</td><td height=\"22\" align=\"center\">"+user.fullname+"</td><td height=\"22\" align=\"center\">"+data.money+"</td></tr>");
									count[2]+= parseFloat(data.money);
								}
                                setData("list", list);
                                setData("count", count);
								if(tips.parent().siblings(".data-list").size()>50){
									tips.parent().siblings(".data-list:last").remove()
								}
								if(count[0]-count[1]>0){
									status.html("已结算 "+count[1]+" 位，剩余 "+(count[0]-count[1])+" 位，请不要关闭窗口");
									loading.css("width", (count[1]/count[0]*100)+"%");
									checkout()
								}else{
									clearInterval(tipsTimer);
									loading.closest("tr").hide();
									status.html("完成！共 "+count[1]+" 位代理，累计结算佣金 "+count[2].toFixed(2));
								}
							}else{
								clearInterval(tipsTimer);
								status.html(data.msg);
							}
						}else{
							clearInterval(tipsTimer);
							status.html("发生未知错误");
						}
					});
				}
<?php if($isSingle){ ?>                tips.parent().hide();
                loading.closest("tr").show();
                checkout();
<?php }else{ ?>				getAjax("get", function(data){
                    if(data){
                        if(data.count){
                            setData("list", data.list);
                            setData("count", [data.count, 0, 0]);
                            tips.parent().hide();
                            loading.closest("tr").show();
                            checkout();
                        }else{
                            clearInterval(tipsTimer);
                            tips.html(data.msg);
                            status.html(data.msg);
                        }
                    }else{
                        clearInterval(tipsTimer);
                        tips.html("已结算完成或无相关代理");
                        status.html("已结算完成或无相关代理");
                    }
                });
<?php } ?>			});
<?php if($isSingle){ ?>            !function(list){
                tips.html("共 "+list.length+" 位代理，等待结算");
            }(getData("list"));
<?php } ?>		});
	</script>
</head>
<body style="border:none">
	<div id="pageMain">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td valign="top">
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
						<tr>
							<td align="left" bgcolor="#FFFFFF" style="color:#000">
								<label>代理组：<?php echo $_GET['tid']>0?$groups[$_GET['tid']]['rows_name']:'全部代理组'; ?></label>
								<label>结算编号：CHECKOUT<?php echo date('Ymd', $_GET['stime']).date('Ymd', $_GET['etime']); ?></label>
								<button class="start-checkout">开始结算</button>
							</td>
						</tr>
						<tr>
							<td align="left" bgcolor="#FFFFFF" style="color:#000">
								<label class="checkout-status">结算状态：<span>等待开始</span></label>
							</td>
						</tr>
						<tr style="display:none" class="loading">
							<td align="right" style="background-color:#fff;height:3px;padding:0"><div style="background-color:#fc9c34;height:3px;width:0;line-height:3px;float:left"></div></td>
						</tr>
					</table>
					<table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
						<tr style="background-color:#3C4D82;color:#FFF">
							<td height="22" align="center" colspan="3"><?php echo date('Y-m-d 至 ', $_GET['stime']).date('Y-m-d', $_GET['etime']); ?> 结算记录（仅最后50条）</td>
						</tr>
						<tr style="background-color:#aee0f7">
							<td height="22" align="center">代理账号</td>
							<td height="22" align="center">真实名字</td>
							<td height="22" align="center">结算佣金</td>
						</tr>
						<tr style="background-color:#FFF" class="checkout-tips">
							<td colspan="3" align="center" valign="middle" data-n="0">等待结算</td>
						</tr>
					</table>
					<table width="100%" border="0" cellpadding="5" cellspacing="0" class="font12" style="margin-top:5px;line-height:20px;">
						<tr>
							<td>
								<p>1、结算过程请不要关闭小窗口；</p>
								<p>2、意外关闭或无响应请重新结算，已结算将自动跳过（需要相同结算编号）；</p>
								<p style="color:red">3、最终佣金为负数系统将不进行结算，请手工结算</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
<?php
		}else{
			message('数据有误，请刷新页面重试');
		}
		break;
}
