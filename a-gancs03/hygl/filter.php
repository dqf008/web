<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('hygl');
include_once '../../include/newPage.php';
include_once '../../class/user.php';

$group_list = array();
$query = $mydata1_db->query('SELECT `id`, `name` FROM `k_group`');
if($query->rowCount()>0){
	while ($rows = $query->fetch()) {
		$group_list[$rows['id']] = $rows['name'];
	}
}

if(isset($_POST['action'])&&in_array($_POST['action'], array('move'))){
	if(in_array($_POST['gid'], array_keys($group_list))){
		$ids = array();
		if(isset($_POST['uid'])&&is_array($_POST['uid']))foreach($_POST['uid'] as $uid){
			preg_match('/^[1-9]\d*$/', $uid)&&$ids[] = $uid;
		}
		if(!empty($ids)){
			include_once '../../class/admin.php';
			$mydata1_db->query('UPDATE `k_user` SET `gid`='.$_POST['gid'].' WHERE `uid` IN ('.implode(', ', $ids).')');
			admin::insert_log($_SESSION["adminid"], '对 '.count($ids).' 个筛选会员进行了会员组迁移');
			message('迁移完成！');
		}else{
			message('Access Denied');
		}
	}else{
		message('请选择需要迁入的会员组！');
	}
}
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>用户筛选</TITLE> 
<link rel="stylesheet" href="Images/CssAdmin.css"> 
<script type="text/javascript" src="../../skin/js/jquery-1.7.2.min.js"></script> 
<style type="text/css"> 
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
.STYLE4 { 
  color: #FF0000;
  font-size: 12px;
} 
</STYLE> 
</HEAD> 
<script type="text/javascript"> 
var is_submit = false;
function ckall(){ 
	$(":checkbox[name!=checkall]").attr("checked", $(":checkbox[name=checkall]").is(":checked"));
} 

function check(){ 
	if($(":checked[name!=checkall]").size()>0){ 
		if(confirm("确定要迁移选定会员吗？")){ 
			return true;
		}else{ 
			return false;
		} 
	}else{ 
		alert("您未选中任何复选框");
		return false;
	} 
} 
</script> 

<body> 
   <form name="form1" method="GET" action="filter.php" > 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2">用户筛选：按照所需条件筛选会员</span></font></td> 
</tr> 
  <tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="455"> 
    <tr> 
      <td>会员账户余额：<input type="text" name="min_umoney" value="<?=$_GET['min_umoney']?>" size="12"/> - <input type="text" name="max_umoney" value="<?=$_GET['max_umoney']?>" size="12"/></td> 
      </tr> 
  </table></td> 
</tr> 
  <tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="455"> 
    <tr> 
      <td>累计充值次数：<input type="text" name="min_mcount" value="<?=$_GET['min_mcount']?>" size="12"/> - <input type="text" name="max_mcount" value="<?=$_GET['max_mcount']?>" size="12"/></td> 
      </tr> 
  </table></td> 
</tr> 
  <tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="455"> 
    <tr> 
      <td>累计充值金额：<input type="text" name="min_money" value="<?=$_GET['min_money']?>" size="12"/> - <input type="text" name="max_money" value="<?=$_GET['max_money']?>" size="12"/></td> 
      </tr> 
  </table></td> 
</tr> 
  <tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="455"> 
    <tr> 
      <td>累计汇款次数：<input type="text" name="min_hcount" value="<?=$_GET['min_hcount']?>" size="12"/> - <input type="text" name="max_hcount" value="<?=$_GET['max_hcount']?>" size="12"/></td> 
      </tr> 
  </table></td> 
</tr> 
  <tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="455"> 
    <tr> 
      <td>累计汇款金额：<input type="text" name="min_hmoney" value="<?=$_GET['min_hmoney']?>" size="12"/> - <input type="text" name="max_hmoney" value="<?=$_GET['max_hmoney']?>" size="12"/></td> 
      </tr> 
  </table></td> 
</tr> 
  <tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="455"> 
    <tr> 
      <td>充值汇款合计：<input type="text" name="min_amoney" value="<?=$_GET['min_amoney']?>" size="12"/> - <input type="text" name="max_amoney" value="<?=$_GET['max_amoney']?>" size="12"/></td> 
      </tr> 
  </table></td> 
</tr> 
  <tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="455"> 
	<tr> 
	  <td>累计提款次数：<input type="text" name="min_tcount" value="<?=$_GET['min_tcount']?>" size="12"/> - <input type="text" name="max_tcount" value="<?=$_GET['max_tcount']?>" size="12"/></td> 
	  </tr> 
  </table></td> 
</tr> 
  <tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="455"> 
	<tr> 
	  <td>累计提款金额：<input type="text" name="min_tmoney" value="<?=$_GET['min_tmoney']?>" size="12"/> - <input type="text" name="max_tmoney" value="<?=$_GET['max_tmoney']?>" size="12"/></td> 
	  </tr> 
  </table></td> 
</tr> 
  <tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="455"> 
	<tr> 
	  <td>　过滤会员组：<select name="gid"><option value="">全部</option><?php foreach($group_list as $gid=>$name) { ?><option value="<?php echo $gid.($_GET['gid']==$gid?'" selected="selected':''); ?>"><?php echo $name; ?></option><?php } ?></select></td> 
	  </tr> 
  </table></td> 
</tr> 
  <tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"><table width="455"> 
	<tr> 
	  <td align="center"><input type="submit" name="submit" value="筛选" onclick="if(is_submit){alert('如果遇到查询缓慢，请耐心等待。');return false}else{is_submit = true}"> <span class="STYLE4">* 留空表示不限制，汇款包含【人工汇款】</span></td> 
	  </tr> 
  </table></td> 
</tr> 
</table>    </form> 
<?php if (isset($_GET['submit'])){ ?>
<form name="form2" method="post" action="filter.php" onSubmit="return check();" style="margin:0 0 0 0;"> 
<input type="hidden" name="action" value="move" />
<table width="100%"> 
	<tr> 
	  <td align="right"><span class="STYLE4">转移会员组：</span> 
 <select name="gid" id="gid">
<?php foreach($group_list as $gid=>$name) { ?>
	  <option value="<?php echo $gid; ?>"><?php echo $name; ?></option>
<?php } ?>
	</select> 
	<input type="submit" name="Submit2" value="执行"/></td> 
	</tr> 
</table> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"> 
   
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" >       
	<tr style="background-color: #EFE" class="t-title"  align="center"> 
	  <td><strong>ID</strong></td> 
	  <td height="20" ><strong>用户名/登录</strong></td> 
	  <td><strong>真实姓名/注册时间</strong></td> 
	  <td><strong>财务/余额</strong></td> 
	  <td><strong>加款扣款</strong></td>
	  <td><strong>充值次数/金额</strong></td>
	  <td><strong>汇款次数/金额</strong></td> 
	  <td><strong>合计金额</strong></td> 
	  <td><strong>提款次数/金额</strong></td> 
	  <td><strong>注册/登陆IP</strong></td> 
	  <td><strong>代理/上级</strong></td> 
	  <td><strong>电话/邮箱</strong></td> 
	  <td><strong>核查/会员组</strong></td> 
	  <td><strong>状态</strong></td> 
	  <td><input name="checkall" type="checkbox" id="checkall" onClick="return ckall();"/> 
		</td> 
	</tr>
	<?php 
		$params = array();
		$sql = 'SELECT * FROM (SELECT `u`.`uid`, `u`.`username`, `u`.`money`, `u`.`mobile`, `u`.`email`, `u`.`reg_date`, `u`.`reg_ip`, `u`.`login_ip`, `u`.`pay_name`, `u`.`is_daili`, `u`.`top_uid`, `u`.`is_stop`, `u`.`gid`, `ul`.`is_login` AS `ul_type`, `ul`.`www`, SUM(IF(`m`.`status`=1 AND `m`.`type`=1, 1, 0)) AS `m_count`, SUM(IF(`m`.`status`=1 AND `m`.`type`=1, `m`.`m_value`, 0)) AS `m_money`, SUM(IF(`h`.`status`=1, 1, 0)+IF(`m`.`status`=1 AND `m`.`type`=3, 1, 0)) AS `h_count`, SUM(IF(`h`.`status`=1, `h`.`money`, 0)+IF(`m`.`status`=1 AND `m`.`type`=3, `m`.`m_value`, 0)) AS `h_money`, SUM(IF(`m`.`status`=1 AND `m`.`type`=2, 1, 0)) AS `t_count`, SUM(IF(`m`.`status`=1 AND `m`.`type`=2, -1*`m`.`m_value`, 0)) AS `t_money`, SUM(IF(`m`.`status`=1 AND `m`.`type`=1, `m`.`m_value`, 0)+IF(`h`.`status`=1, `h`.`money`, 0)) AS `all_money` FROM `k_user` AS `u` LEFT JOIN `k_user_login` AS `ul` ON `ul`.`uid`=`u`.`uid` LEFT JOIN `huikuan` AS `h` ON `h`.`uid`=`u`.`uid` LEFT JOIN `k_money` AS `m` ON `m`.`uid`=`u`.`uid`';
		if(isset($_GET['min_umoney'])&&isset($_GET['max_umoney'])){
			if($_GET['min_umoney']!=''&&$_GET['max_umoney']!=''){
				$sql.= ' WHERE `u`.`money` BETWEEN :min_umoney AND :max_umoney';
				$params[':min_umoney'] = $_GET['min_umoney'];
				$params[':max_umoney'] = $_GET['max_umoney'];
			}else if($_GET['min_umoney']!=''){
				$sql.= ' WHERE `u`.`money`>=:min_umoney';
				$params[':min_umoney'] = $_GET['min_umoney'];
			}else if($_GET['max_umoney']!=''){
				$sql.= ' WHERE `u`.`money`<=:max_umoney';
				$params[':max_umoney'] = $_GET['max_umoney'];
			}
		}
		if(isset($_GET['gid'])&&$_GET['gid']!=''){
			$sql.= (empty($params)?' WHERE':' AND').'`u`.`gid`=:gid';
			$params[':gid'] = $_GET['gid'];
		}
		$is_and = false;
		$sql.= ' GROUP BY `u`.`uid` ORDER BY `u`.`uid` DESC) AS `temp`';
		if(isset($_GET['min_mcount'])&&isset($_GET['max_mcount'])){
			if($_GET['min_mcount']!=''&&$_GET['max_mcount']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`m_count` BETWEEN :min_mcount AND :max_mcount';
				$params[':min_mcount'] = $_GET['min_mcount'];
				$params[':max_mcount'] = $_GET['max_mcount'];
			}else if($_GET['min_mcount']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`m_count`>=:min_mcount';
				$params[':min_mcount'] = $_GET['min_mcount'];
			}else if($_GET['max_mcount']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`m_count`<=:max_mcount';
				$params[':max_mcount'] = $_GET['max_mcount'];
			}
		}
		if(isset($_GET['min_money'])&&isset($_GET['max_money'])){
			if($_GET['min_money']!=''&&$_GET['max_money']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`m_money` BETWEEN :min_money AND :max_money';
				$params[':min_money'] = $_GET['min_money'];
				$params[':max_money'] = $_GET['max_money'];
			}else if($_GET['min_money']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`m_money`>=:min_money';
				$params[':min_money'] = $_GET['min_money'];
			}else if($_GET['max_money']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`m_money`<=:max_money';
				$params[':max_money'] = $_GET['max_money'];
			}
		}
		if(isset($_GET['min_hcount'])&&isset($_GET['max_hcount'])){
			if($_GET['min_hcount']!=''&&$_GET['max_hcount']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`h_count` BETWEEN :min_hcount AND :max_hcount';
				$params[':min_hcount'] = $_GET['min_hcount'];
				$params[':max_hcount'] = $_GET['max_hcount'];
			}else if($_GET['min_hcount']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`h_count`>=:min_hcount';
				$params[':min_hcount'] = $_GET['min_hcount'];
			}else if($_GET['max_hcount']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`h_count`<=:max_hcount';
				$params[':max_hcount'] = $_GET['max_hcount'];
			}
		}
		if(isset($_GET['min_hmoney'])&&isset($_GET['max_hmoney'])){
			if($_GET['min_hmoney']!=''&&$_GET['max_hmoney']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`h_money` BETWEEN :min_hmoney AND :max_hmoney';
				$params[':min_hmoney'] = $_GET['min_hmoney'];
				$params[':max_hmoney'] = $_GET['max_hmoney'];
			}else if($_GET['min_hmoney']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`h_money`>=:min_hmoney';
				$params[':min_hmoney'] = $_GET['min_hmoney'];
			}else if($_GET['max_hmoney']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`h_money`<=:max_hmoney';
				$params[':max_hmoney'] = $_GET['max_hmoney'];
			}
		}
		if(isset($_GET['min_amoney'])&&isset($_GET['max_amoney'])){
			if($_GET['min_amoney']!=''&&$_GET['max_amoney']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`all_money` BETWEEN :min_amoney AND :max_amoney';
				$params[':min_amoney'] = $_GET['min_amoney'];
				$params[':max_amoney'] = $_GET['max_amoney'];
			}else if($_GET['min_amoney']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`all_money`>=:min_amoney';
				$params[':min_amoney'] = $_GET['min_amoney'];
			}else if($_GET['max_amoney']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`all_money`<=:max_amoney';
				$params[':max_amoney'] = $_GET['max_amoney'];
			}
		}
		if(isset($_GET['min_tcount'])&&isset($_GET['max_tcount'])){
			if($_GET['min_tcount']!=''&&$_GET['max_tcount']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`t_count` BETWEEN :min_tcount AND :max_tcount';
				$params[':min_tcount'] = $_GET['min_tcount'];
				$params[':max_tcount'] = $_GET['max_tcount'];
			}else if($_GET['min_tcount']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`t_count`>=:min_tcount';
				$params[':min_tcount'] = $_GET['min_tcount'];
			}else if($_GET['max_tcount']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`t_count`<=:max_tcount';
				$params[':max_tcount'] = $_GET['max_tcount'];
			}
		}
		if(isset($_GET['min_tmoney'])&&isset($_GET['max_tmoney'])){
			if($_GET['min_tmoney']!=''&&$_GET['max_tmoney']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`t_money` BETWEEN :min_tmoney AND :max_tmoney';
				$params[':min_tmoney'] = $_GET['min_tmoney'];
				$params[':max_tmoney'] = $_GET['max_tmoney'];
			}else if($_GET['min_tmoney']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`t_money`>=:min_tmoney';
				$params[':min_tmoney'] = $_GET['min_tmoney'];
			}else if($_GET['max_tmoney']!=''){
				if($is_and){
					$sql.= ' AND ';
				}else{
					$is_and = true;
					$sql.= ' WHERE ';
				}
				$sql.= '`t_money`<=:max_tmoney';
				$params[':max_tmoney'] = $_GET['max_tmoney'];
			}
		}
		$query = $mydata1_db->prepare($sql);
		$query->execute($params);
		$thisPage = 1;

		if ($_GET['page']){
			$thisPage = $_GET['page'];
		}
		$page = new newPage();
		$thisPage = $page->check_Page($thisPage, $query->rowCount(), 50, 40);
		$i = 1;
		$start = (($thisPage - 1) * 50) + 1;
		$end = $thisPage * 50;
		while ($rows = $query->fetch()){
			if (($start <= $i) && ($i <= $end)){
			$over = '#EBEBEB';
			$out = '#ffffff';
			$color = '#FFFFFF';
			if ($rows['is_stop'] == 1)
			{
				$color = $over = $out = '#EBEBEB';
			}
			if ($rows['money'] < 0)
			{
				$color = $over = $out = '#FF9999';
			}?> 	          
			<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over?>'" onMouseOut="this.style.backgroundColor='<?=$out?>'" style="background-color:<?=$color?>"> 
			  <td><a href="user_show.php?id=<?=$rows['uid']?>"><?=$rows['uid']?></a></td>
			  <td><a href="user_show.php?id=<?=$rows['uid']?>"><?=$rows['username']?></a><br><span style="color:#999999;"><?=$rows['www']?></span></td> 
			  
			  <td><a href="list.php?likevalue=<?=urlencode($rows['pay_name'])?>&selecttype=pay_name"><?=$rows['pay_name']?></a><br/><?=$rows['reg_date']?></td> 
			  <td><a href="../cwgl/hccw.php?username=<?=$rows['username']?>">查看财务</a><br /><?=sprintf('%.2f',$rows['money'])?></td> 
			  <td><a href="../cwgl/man_money.php?username=<?=$rows['username']?>">加款扣款</a></td>
			  <td><?php echo $rows['m_count'].'/'.sprintf('%.2f', $rows['m_money']); ?></td>
			  <td><?php echo $rows['h_count'].'/'.sprintf('%.2f', $rows['h_money']); ?></td>
			  <td><?php echo sprintf('%.2f', $rows['all_money']); ?></td>
			  <td><?php echo $rows['t_count'].'/'.sprintf('%.2f', $rows['t_money']); ?></td>
			  <td> 
				  <a href="login_ip.php?ip=<?=$rows['reg_ip']?>" ><?=$rows['reg_ip']?></a> 
				  <br/> 
				  <a href="login_ip.php?ip=<?=$rows['login_ip']?>"><?=$rows['login_ip']?></a> 
			  </td> 
			  <td>
			   <?php  if ($rows['is_daili'] == 1){ ?>
                  <a title="单击查看改代理的所有会员" href="list.php?top_uid=<?=$rows['uid']?>">是</a>
			   <?php }else{?> 否 <?php }?>                     
				<br/>
			   <?php if (0 < $rows['top_uid']){?>                     
				  <a href="list.php?top_uid=<?=$rows['top_uid']?>"><?=user::getusername($rows['top_uid'])?></a>
			   <?php }?>                 
			  </td> 
			  <td>
			   <?php if (strpos($_SESSION['quanxian'], 'hylx')){?>                     
			   <a href="list.php?likevalue=<?=$rows['mobile']?>&selecttype=mobile"><?=$rows['mobile']?></a><br />
			   <?
			   	$rows['email'];
				}else{
			   ?>                     
			    您无权查看
			   <?php }?>                 
			  </td> 
			  <td><a href="../bbgl/report_day.php?username=<?=$rows['username']?>">核查会员</a><br /><?=$group_list[$rows['gid']]?></td> 
			  <td><?=$rows["ul_type"]>0 ? "<span style=\"color:#FF00FF;\">在线</span>" : "<span style=\"color:#999999;\">离线</span>" ?><br/><?=$rows["is_stop"]==1 ? "<span style=\"color: #FF0000;\">停用</span>" : "<span style=\"color:#006600;\">正常</span>"?></td> 
			  <td><input name="uid[]" type="checkbox" id="uid[]" value="<?=$rows['uid']?>" /></td> 
		</tr>
<?php
	}
	if ($end < $i){
		break;
	}
	$i++;
}
$url = preg_replace('/\&?page\=[^\&]+/', '', $_SERVER["REQUEST_URI"]);
?>
     </table> 
  </td></tr> 
<tr><td ><div style="float:left;"><?=$page->get_htmlPage($url);?></div></td></tr> 
</table> 
</form> 
<?php
}
?>
</body> 
</html>