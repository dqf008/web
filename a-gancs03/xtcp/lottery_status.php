<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
include_once '../../cj/include/jslh.func.php';
check_quanxian('cpgl');
check_quanxian('cpkj');

$types = [
	'jssc' => '极速赛车',
	'jsssc' => '极速时时彩',
	'jslh' => '极速六合',
	'ffk3' => '分分快3',
	'sfk3' => '超级快3',
	'wfk3' => '好运快3',
];
if(isset($_GET['type'])&&array_key_exists($_GET['type'], $types)){
	$data = [0, 0, 0];
	$data_file = '../../cache/'.$_GET['type'].'.data.php';
	if(isset($_GET['reload'])&&$_GET['reload']=='true'){
		file_put_contents($data_file, '<?php'.PHP_EOL.'return unserialize(\''.serialize($data).'\');');
		admin::insert_log($_SESSION['adminid'], '重置了'.$types[$_GET['type']].'的杀率统计数据');
		message('重置成功！');
		exit;
	}else{
		file_exists($data_file)&&$data = include($data_file);
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
		.selected {background-color:#aee0f7} 
	</style>
	<script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("input[type=button]").on("click", function(e){
				if($(this).index()==1){
					if(confirm("确定要重置统计数据？")){
						window.location.href = '?type=<?php echo $_GET['type']; ?>&reload=true';
					}
				}else{
					window.location.reload();
				}
			})
		});
	</script>
</head>
<body style="border:0">
	<div id="pageMain">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td valign="top">
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
						<tr>
							<td align="center" bgcolor="#3C4D82" style="color:#FFF" colspan="2">整体杀率统计数据</td>
						</tr>
						<tr>
							<td align="right" bgcolor="#F0FFFF" width="100">彩票类别：</td>
							<td align="left" bgcolor="#FFFFFF"><?php echo $types[$_GET['type']]; ?></td>
						</tr>
						<tr>
							<td align="right" bgcolor="#F0FFFF" width="100">开始期号：</td>
							<td align="left" bgcolor="#FFFFFF"><?php echo isset($data[3])?$data[3]:'未统计'; ?></td>
						</tr>
						<tr>
							<td align="right" bgcolor="#F0FFFF" width="100">累计下注：</td>
							<td align="left" bgcolor="#FFFFFF"><?php echo sprintf('%.2f', $data[0]); ?></td>
						</tr>
						<tr>
							<td align="right" bgcolor="#F0FFFF" width="100">累计派彩：</td>
							<td align="left" bgcolor="#FFFFFF"><?php echo sprintf('%.2f', $data[1]); ?></td>
						</tr>
						<tr>
							<td align="right" bgcolor="#F0FFFF" width="100">当前杀率：</td>
							<td align="left" bgcolor="#FFFFFF"><?php echo sprintf('%.2f', $data[2]/-100); ?> % (正比盈利负比亏损)</td>
						</tr>
						<tr>
							<td align="right" bgcolor="#F0FFFF" width="100">提示：</td>
							<td align="left" bgcolor="#FFFFFF" style="color:red">累计金额越大，当前杀率将越接近设定值（不含预设开奖）；<br />如果当前杀率远小于设定杀率，请尝试重置统计数据；<br />撤销注单、重算整期或调整杀率后，建议重置统计数据</td>
						</tr>
						<tr>
							<td align="right" bgcolor="#FFFFFF" width="100">&nbsp;</td>
							<td align="left" bgcolor="#FFFFFF">
								<input type="button" class="submit80" value="刷新" />
								<input type="button" class="submit80" value="重置" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
<?php }else{message('来源无效');} ?>