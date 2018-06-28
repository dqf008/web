<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('xxgl');
include_once '../../include/newpage.php';
$nid = 0;
if (0 < $_GET['nid']){
	$nid = $_GET['nid'];
}

if (($_GET['action'] == 'add') && ($nid == 0)){
	$msg = encoding_html($_POST['msg']);
	$end_time = clear_html_code($_POST['end_time']);
	$is_show = intval($_POST['is_show']);
	$sort = intval($_POST['sort']);
	$params = array(':msg' => $msg, ':end_time' => $end_time, ':is_show' => $is_show, ':sort' => $sort, ':mtype' => '网站公告');
	$sql = 'insert into k_notice(msg,end_time,is_show,`sort`,`mtype`) values (:msg,:end_time,:is_show,:sort,:mtype)';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
}else if (($_GET['action'] == 'edit') && (0 < $nid)){
	$msg = encoding_html($_POST['msg']);
	$end_time = clear_html_code($_POST['end_time']);
	$is_show = intval($_POST['is_show']);
	$sort = intval($_POST['sort']);
	$params = array(':msg' => $msg, ':end_time' => $end_time, ':is_show' => $is_show, ':sort' => $sort, ':nid' => intval($nid));
	$sql = 'update k_notice set msg=:msg,end_time=:end_time,is_show=:is_show,`sort`=:sort where nid=:nid';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
}else if (($_GET['action'] == 'del') && (0 < $nid)){
	$params = array(':nid' => intval($nid));
	$sql = 'delete from k_notice where nid=:nid';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
}

$sql = 'update k_notice set is_class = 1 where is_class = 9';
$stmt = $mydata1_db->exec($sql);
?> 
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>公告管理</TITLE> 
<script language="javascript" src="/js/jquery.js"></script> 
<script language="javascript"> 
function check_submit(){ 
  if($("#msg").val()==""){ 
	  alert("请填写公告内容");
	  $("#msg").focus();
	  return false;
  } 
  if($("#end_time").val()==""){ 
	  alert("请填写有效时间");
	  $("#end_time").focus();
	  return false;
  } 
  if($("#sort").val()==""){ 
	  alert("请填写排序值");
	  $("#sort").focus();
	  return false;
  } 
  return true;
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
a{color:#FFA93E;text-decoration: none;} 
.t-title{background:url(/super/images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
.STYLE3 {color: #339900} 
.STYLE4 {color: #FF0000} 
</STYLE> 
</HEAD> 

<body> 
<table width="100%" align="center"  id=editProduct   idth="100%" > 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2">公告管理：管理网站公告信息</span></font></td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"> 
  <form name="form1" onSubmit="return check_submit();" method="post" action="add.php?nid=<?=$nid?>&action=<?=$nid>0 ? 'edit' : 'add'?>">
<?php 
if ((0 < $nid) && !isset($_GET['action'])){
	$params = array(':nid' => intval($nid));
	$sql = 'select * from k_notice where nid=:nid limit 1';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rs = $stmt->fetch();
}
?>     
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" > 
<tr> 
  <td  align="left">公告内容：</td> 
  <td colspan="5"  align="left"><textarea  id="msg" name="msg" rows="4" cols="100"><?=$rs['msg']?></textarea></td> 
</tr> 
<tr> 
 <td width="10%" align="left">有效时间：</td>
    <td width="20%" align="left"><input name="end_time" id="end_time" type="text" value="<?=isset($rs['end_time']) ? $rs['end_time'] : date("Y-m-d H:i:s",strtotime("+1 week"))?>" size="20" maxlength="19"/></td>
    <td width="10%" align="left">是否显示：</td>
    <td width="20%" align="left"><input name="is_show" type="radio" value="1" <?=$rs['is_show']==1 ? 'checked' : ''?><?=!isset($rs['is_show']) ? 'checked' : ''?>>
      <span class="STYLE3">显示</span>&nbsp;&nbsp;
      <input type="radio" name="is_show" value="0" <?=(isset($rs['is_show']) && $rs['is_show']==0) ? 'checked' : ''?>>
      <span class="STYLE4">不显示</span></td>
    <td width="10%" align="left">排序值：</td>
    <td width="30%" align="left"><input name="sort" type="text" id="sort" value="<?=isset($rs['sort']) ? $rs['sort'] : '1'?>" size="4" maxlength="3" style="text-align:center;">
      &nbsp;越大越靠前</td>
</tr> 
<tr> 
  <td align="center">&nbsp;</td> 
  <td colspan="5" align="left"><input name="submit" type="submit" value="发布"/></td> 
</tr> 
</table>   
  </form> 
</td> 
</tr> 
</table> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"><tr><td ><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"><table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" >    
		  <tr style="background-color: #EFE"> 
			<td width="86" align="center"><strong>发布时间</strong></td> 
	  <td width="86" height="20" align="center"><strong>有效时间</strong></td> 
	  <td width="839" align="center"><strong>内容</strong></td> 
	  <td width="46" align="center"><strong>状态</strong></td> 
	  <td width="46" align="center"><strong>编辑</strong></td> 
	  <td width="46" align="center"><strong>删除</strong></td> 
	</tr>
<?php 
$sql = 'select nid from k_notice order by `sort` desc,nid desc';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute();
$sum = $stmt->rowCount();
$thisPage = 1;
if ($_GET['page']){
	$thisPage = $_GET['page'];
}
$page = new newPage();
$thisPage = $page->check_Page($thisPage, $sum, 20, 40);
$nid = '';
$i = 1;
$start = (($thisPage - 1) * 20) + 1;
$end = $thisPage * 20;
while ($row = $stmt->fetch()){
	if (($start <= $i) && ($i <= $end)){
		$nid .= intval($row['nid']) . ',';
	}
	
	if ($end < $i){
		break;
	}
	$i++;
}
if ($nid){
$nid = rtrim($nid, ',');
$sql = 'select * from k_notice where nid in(' . $nid . ') order by `sort` desc,nid desc';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute();
$time = time();
while ($rows = $stmt->fetch()){
	$endtime = strtotime($rows['end_time']);
?>      
	<tr onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;"> 
	  <td align="center" valign="middle"><?=date("m-d H:i",strtotime($rows["add_time"]))?></td>
        <td height="20" align="center" valign="middle"><?=date("m-d H:i",strtotime($rows["end_time"]))?></td>
        <td><?=$rows["msg"]?></td>
        <td align="center"><?=$rows['is_show']==0 ? '<span class="STYLE4">不显示</span>' : $time>$endtime ? '<span class="STYLE4">不显示</span>' : '<span class="STYLE3">显示</span>'?></td>
        <td align="center"><a href="add.php?nid=<?=$rows["nid"]?>">编辑</a></td>
        <td align="center"><a href="add.php?nid=<?=$rows["nid"]?>&action=del" onClick="return confirm('您确定要删除这条公告吗？');">删除</a></td>
	</tr>
<?php }
}?>     </table></td> 
</tr> 
<tr> 
  <td ><?=$page->get_htmlPage($_SERVER["REQUEST_URI"]);?></td> 
</tr> 
</table></td></tr> 
</table> 
</body> 
</html> 
   