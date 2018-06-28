<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('xtgl');
$id = intval($_GET['id']);
if ($id <= 0){
	$id = 1;
}

if (@($_GET['action']) == 'del'){
    // $params = array(':title' => clear_html_code($_POST['title']), ':code' => clear_html_code($_POST['code']), ':content' => $_POST['content'], ':id' => $_POST['autoid']);
    // $sql = 'update webinfo set title=:title,code=:code,content=:content where id=:id';
	$params = array(':id' => $_GET['id']);
	$sql = 'DELETE FROM `set_play` WHERE  `id`=:id ';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
    message('删除第三方成功!');
}
$hotSort = array();
$hotList = array();
$sql = 'select * from set_play  order by id desc';
$sql ='SELECT a.*,b.play_title FROM set_play AS a LEFT JOIN set_play_list AS b ON  b.id=a.play_id ORDER BY id DESC';
$query = $mydata1_db->query($sql);
while($rows = $query->fetch()){
    $hotList[] = $rows;
    
}

?>
 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>支付设置</TITLE> 
<link rel="stylesheet" href="Images/CssAdmin.css"> 
<script language="javascript" src="../Script/Admin.js"></script> 
<style type="text/css"> 
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
.t-title{background:url(/super/images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
</STYLE> 
</HEAD> 
<script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
<script language="JavaScript" src="/js/calendar.js"></script> 
<script language='javascript' src='../js/layer/layer.js'></script> 
<script> 
function betDetailUrl(url) { 
  layer.open({ 
    type : 2, 
    shadeClose : true, 
    fix:true, 
    skin: 'layui-layer-lan', 
    title : "配置在线支付", 
    content: url, 
    area : ['800px' , '500px'], 
    shift : 0, 
    scrollbar: false 
  });
} 
</script> 

<body> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 

  <td height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2">支付设置管理</span></font></td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF">
    <input type="button" onclick="betDetailUrl('add_play.php')" value="1: 添加第三方接口">
    &nbsp; <input type="button" onclick="betDetailUrl('set_pay.php?id=')" value="2: 配置在线支付"> </td> 
  
</tr> 
</table> 
<br> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
  
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"> 
   
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" >       <tr style="background-color:#CCCCCC;" align="center"> 
      <td height="20" align="center" width="100"><strong>当前排序</strong></td> 
      <td align="center"><strong>名称</strong></td> 
      <td align="center"><strong>第三方</strong></td> 
      <td align="center"><strong>域名</strong></td> 
      <td align="center"><strong>状态</strong></td> 
      <td align="center" width="200"><strong>操作</strong></td> 
    </tr><?php
foreach($hotList as $key){
    
    $rs = $key;
?>   
         <tr onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;"> 
            <td height="20" align="center"><A href="add_play.php?id=<?php echo $rs['id']; ?>"><?php echo $rs['id']; ?></a></td> 
            <td height="20" align="center"><A href="add_play.php?id=<?php echo $rs['id']; ?>"><?php echo $rs['title']; ?></a></td> 
          <td height="20" align="center"><A href="add_play.php?id=<?php echo $rs['id']; ?>"><?php echo $rs['play_title']; ?></a></td> 
<td height="20" align="center"><A href="add_play.php?id=<?php echo $rs['id']; ?>"><?php echo $rs['site']; ?></a></td> 
<td height="20" align="center"><?php if($rs['status']==1){echo "正常";}else{echo "禁用";} ; ?></td>  
            <td align="center"> 

              <A onClick="javascript:return confirm('确定删除');" href="play.php?action=del&id=<?php echo $rs['id']; ?>&amp;action=del">删除</a></td> 
        </tr>
<?php }?>    </table> 
  </td> 
</tr> 
</table> 
</body> 
</html>