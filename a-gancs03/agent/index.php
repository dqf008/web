<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('dlgl');
$agent_id = isset($_GET['id'])?intval($_GET['id']):0;

$stmt = $mydata1_db->query('SELECT * FROM `agent_config` WHERE `uid`=0 ORDER BY `id` ASC');
$agent_groups = [0 => []];
$groups_rows = [];
while($rows = $stmt->fetch()){
	!isset($agent_groups[$rows['tid']])&&$agent_groups[$rows['tid']] = [];
	if($rows['tid']==0){
		$agent_groups[0][] = $rows['id'];
	}else{
		$agent_groups[$rows['tid']][$rows['id']] = $rows['default'];
	}
	$groups_rows[$rows['id']] = $rows;
}

if(isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'default':
			$mydata1_db->query('UPDATE `agent_config` SET `default`=0 WHERE `uid`=0 AND `tid`=0');
			if($agent_id>0&&isset($groups_rows[$agent_id])){
				$stmt = $mydata1_db->prepare('UPDATE `agent_config` SET `default`=1 WHERE `uid`=0 AND `tid`=0 AND `id`=:id');
				$stmt->execute([':id' => $agent_id]);
				admin::insert_log($_SESSION['adminid'], '设置默认代理组为['.$groups_rows[$agent_id]['username'].']');
			}else{
				admin::insert_log($_SESSION['adminid'], '取消默认代理组');
			}
			message('设置成功！');
			break;

		case 'delete':
			if($agent_id>0&&isset($agent_groups[$agent_id])){
				asort($agent_groups[$agent_id]);
				$last_id = array_keys($agent_groups[$agent_id]);
				$last_id = array_pop($last_id);
				admin::insert_log($_SESSION['adminid'], '删除了['.$groups_rows[$agent_id]['username'].']的最后一层代理组['.$groups_rows[$last_id]['username'].']');
				$mydata1_db->query('DELETE FROM `agent_config` WHERE `id`='.$last_id.' AND `tid`='.$agent_id);
			}
			message('删除成功！');
			break;

		case 'delete_all':
			if($agent_id>0&&isset($groups_rows[$agent_id])){
				$stmt = $mydata1_db->query('SELECT COUNT(*) AS `count` FROM `agent_config` WHERE `uid`>0 AND `tid`='.$agent_id);
				$count = $stmt->fetch();
				if($count['count']>0){
					message('请先转移或取消所有代理！');
				}else{
					$mydata1_db->query('DELETE FROM `agent_config` WHERE `uid`=0 AND (`tid`='.$agent_id.' OR `id`='.$agent_id.')');
					admin::insert_log($_SESSION['adminid'], '删除了['.$groups_rows[$agent_id]['username'].']代理组');
					message('删除成功！');
				}
			}else{
				message('ID无效！');
			}
			break;

		case 'check':
			$mydata1_db->query('DELETE FROM `agent_config` WHERE `id` IN (SELECT * FROM (SELECT `c`.`id` FROM `agent_config` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`c`.`uid` WHERE `c`.`uid`>0 AND `c`.`tid`>0 AND (`u`.`uid` IS NULL OR `u`.`is_daili`=0 OR `u`.`is_stop`=1 OR `u`.`is_delete`=1)) AS `ids`)');
			admin::insert_log($_SESSION['adminid'], '核算了代理组数量');
			message('核算数量成功！');
			break;

		default:
			message('操作无效！');
			break;
	}
	exit;
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
<body>
	<div id="pageMain">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td valign="top">
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
						<tr>
							<td align="center" bgcolor="#3C4D82" style="color:#FFF"><strong>代理组管理</strong></td>
						</tr>
						<tr>
							<td align="center" bgcolor="#FFFFFF" style="color:#000"><a href="add.php" class="sub_com">添加顶层代理组</a> - <a href="?action=check" class="sub_com">核算代理组数量</a></td>
						</tr>
					</table>
					<table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
						<tr style="background-color:#3C4D82;color:#FFF">
							<td height="22" align="center"><strong>代理组</strong></td>
							<td height="22" align="center"><strong>下层代理组</strong></td>
							<td height="22" align="center"><strong>代理数量</strong></td>
							<td height="22" align="center"><strong>操作</strong></td>
						</tr>
<?php
foreach($agent_groups[0] as $id){
	$rows = $groups_rows[$id];
	$stmt = $mydata1_db->query('SELECT COUNT(*) AS `count` FROM `agent_config` WHERE `uid`>0 AND `tid`='.$id);
	$count = $stmt->fetch();
	$agent_path = [];
	if(isset($agent_groups[$id])){
		asort($agent_groups[$id]);
		foreach(array_keys($agent_groups[$id]) as $index=>$key){
			$agent_path[] = '「第'.($index+1).'层」<a href="add.php?id='.$key.'">'.$groups_rows[$key]['username'].'</a>';
		}
	}
?>							<tr style="background-color:#FFFFFF;line-height:20px;" class="data-list">
								<td align="center"><?php if($rows['default']==1){ ?>「默认」<?php }echo '<a href="add.php?id='.$rows['id'].'">'.$rows['username'].'</a>'; ?></td>
								<td align="center"><?php echo empty($agent_path)?'「无」':implode('<br />', $agent_path); ?></td>
                                <td align="center"><a href="user.php?tid=<?php echo $rows['id']; ?>"><?php echo $count['count']; ?></a></td>
								<td align="center"><?php if($rows['tid']==0){if($rows['default']==1){ ?><a href="?id=0&amp;action=default" onclick="return confirm('确定要取消默认代理组码？取消后将导致部分代理数据不正确！');">取消默认代理组</a><?php }else{ ?><a href="?id=<?=$rows["id"]?>&amp;action=default" onclick="return confirm('确定要设置为默认代理组码？');">设置为默认代理组</a><?php }} ?>&nbsp;<a href="add.php?id=<?=$rows["id"]?>&amp;add=true">添加下层代理组</a>&nbsp;<a onclick="return confirm('您确定要删除最后一层代理组吗？');" href="?id=<?=$rows["id"]?>&amp;action=delete">删除最后一层代理组</a>&nbsp;<a onclick="return confirm('您确定要删除代理组吗？需要先转移或取消所有代理后才能删除！');" href="?id=<?=$rows["id"]?>&amp;action=delete_all">删除代理组</a></td>
							</tr>
<?php } ?>						</table>
					</form>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>