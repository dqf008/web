<?php
define('IN_AGENT', dirname(__FILE__).'/');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
include IN_AGENT.'functions.php';

check_quanxian('dlgl');

$agent_id = isset($_GET['id'])?intval($_GET['id']):0;
$page = array('limit' => 5);
$page['cur'] = isset($_GET['page'])?$_GET['page']:'1';
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
			if(window.parent.onMessage){
				var s = window.parent.onMessage();
				s&&$("body > div > table td:first").append('<table width="100%" border="0" cellpadding="5" cellspacing="0" class="font12" style="margin-top:5px;line-height:20px;"><tr><td><p>'+s.replace(/<br[^>]*>/g, "</p><p>")+'</p></td></tr></table>');
			}
		});
	</script>
</head>
<body style="border:none">
	<div id="pageMain">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td valign="top">
					<table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
<?php
$sql = [
	'SELECT COUNT(*) AS `count` FROM `agent_cache` WHERE `uid`=:uid AND `cache_date` BETWEEN :stime AND :etime',
	'SELECT * FROM `agent_cache` WHERE `uid`=:uid AND `cache_date` BETWEEN :stime AND :etime ORDER BY `id` DESC LIMIT :index, :limit',
];
$params = [
	':uid' => $agent_id,
	':stime' => $_GET['stime'],
	':etime' => $_GET['etime'],
];
$page['url'] = '?id='.$agent_id.'&amp;stime='.$_GET['stime'].'&amp;etime='.$_GET['etime'];
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
		$rows['value'] = unserialize($rows['value']);
?>						<tr style="background-color:#3C4D82;color:#FFF">
							<td height="22" align="center" colspan="5"><?php echo date('Y-m-d', $rows['cache_date']); ?> 统计数据</td>
						</tr>
						<tr style="background-color:#aee0f7;">
							<td height="22" align="center">类型</td>
							<td height="22" align="center">注单数量</td>
							<td height="22" align="center">注单金额</td>
							<td height="22" align="center">派彩金额</td>
							<td height="22" align="center">有效投注额</td>
						</tr>
<?php foreach($rows['value'] as $val){ ?>						<tr style="background-color:#FFFFFF;line-height:20px;" class="data-list">
							<td align="center"><?php echo $val['name']; ?></td>
							<td align="center"><?php echo $val['data']['rows_num']; ?></td>
							<td align="center"><?php echo sprintf('%.2f', $val['data']['bet_amount']/100); ?></td>
							<td align="center"><span style="color:<?php echo $val['data']['net_amount']>=0?'#009900':'#ff0000'; ?>;"><?php echo sprintf('%.2f', $val['data']['net_amount']/100); ?></span></td>
							<td align="center"><?php echo sprintf('%.2f', $val['data']['valid_amount']/100); ?></td>
						</tr>
<?php
		}
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
							<td colspan="5" align="center" valign="middle">
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
							<td colspan="5" align="center" valign="middle">无相关记录</td>
						</tr>
<?php } ?>					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>