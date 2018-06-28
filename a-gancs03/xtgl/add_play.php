<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../member/pay/moneyconfig.php';
check_quanxian('xtgl');
//
include_once('../../member/pay/cache/pay_conf.php');
include_once('play_function.php');
//保存
if($_GET['action'] == 'save'){
	$status = $_POST['status'];
	$play_id = intval($_POST['play_id']);
	$sql = "SELECT * FROM set_play_list WHERE id={$play_id}";
	$query = $mydata1_db->query($sql);
	$rows = $query->fetch();
  	$id = intval($_POST['id']);
	//print_r($rows['play_title']);

  	// 算id
	if(!$id){
		$sql = "SELECT MAX(id)+1 AS id FROM set_play ";
		$query = $mydata1_db->query($sql);
		$res = $query->fetch();
		$pid = $res['id'];

	}else{
		$pid = $id;
	}

	if($rows['play_title']){
		if($status==1){
			if($pid>13){
				add__play($rows['play_title'].'_'.$pid);
			}else{
				add__play($rows['play_title']);
			}
			
			save_play();
		}else{
			//更改
			if($pid>13){
				del_play($rows['play_title'].'_'.$pid);
			}else{
				del_play($rows['play_title']);
			}
			
			save_play();
		}

	}
	
	

	$id = intval($_POST['id']);
	$pardata = array(//':id' =>$id,
						':title' =>strip_tags($_POST['title']) ,
						':play_id' =>$_POST['play_id'] ,
						':play_account' =>$_POST['play_account'] ,
						':play_key' =>$_POST['play_key'] ,
						':site' =>$_POST['site'] ,
						':play_name' =>$_POST['play_name'] ,
						':play_number' =>$_POST['play_number'] ,
						':status' =>$_POST['status'],
						':add_time'=>time(),
						':merchant_url' => strip_tags($_POST['merchant_url']),
		 );
	//更新
	if($id){
		$pardata[":id"] = $id;
		$sql = "UPDATE `set_play` SET title=:title,play_id=:play_id,play_account=:play_account,play_key=:play_key,site=:site,play_name=:play_name,play_number=:play_number,status=:status,add_time=:add_time,merchant_url=:merchant_url WHERE id=:id";
		$stmt = $mydata1_db->prepare($sql);
		//处理写入文件

		$res= $stmt->execute($pardata);
		if($res){
			message('更新成功');
		}
		//增加
	}else{
		$sql = "INSERT INTO `set_play` (title,play_id,play_account,play_key,site,play_name,play_number,status,add_time,merchant_url) values (:title,:play_id,:play_account,:play_key,:site,:play_name,:play_number,:status,:add_time,:merchant_url)";
		$stmt = $mydata1_db->prepare($sql);
		//print_r($pardata);
		$res= $stmt->execute($pardata);
		if($res){
			message('增加成功!');
		}
	}


}

$sql = 'SELECT * FROM set_play_list';
$query = $mydata1_db->query($sql);
$play_list = array();
while($rows = $query->fetch()){
    $play_list[] = $rows;
}
if(!$id){
	$id = intval($_REQUEST['id']);
}

if($id){
	$sql = "SELECT * FROM set_play WHERE id={$id}";
	$query = $mydata1_db->query($sql);
	$rows = $query->fetch();
}
//print_r($play_list);
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>第三方设置</TITLE> 
<link rel="stylesheet" href="../Images/CssAdmin.css"> 
<style type="text/css"> 
body { 
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
  font-size: 12px;
} 
</style> 
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
</HEAD> 

<body> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<tr> 
  <td height="24" nowrap background="../images/06.gif"><img src="../images/Explain.gif" width="18" height="18" border="0" align="absmiddle">&nbsp;更改第三方</td> 
</tr> 
<tr> 
  <td height="24" align="center" nowrap bgcolor="#FFFFFF"> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
<form action="add_play.php?action=save" method="post" name="editForm1" id="editForm1" >
<input type="hidden" name="id" value="<? echo $rows['id']; ?>"> 
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" id=editProduct idth="100%"> 

  	<tr> 
	  <td height="30" align="right"> 名称：</td> 
	  <td><input name="title" type="text" class="textfield"   value="<?=$rows['title'];?>" size="40" ></td> 
	</tr> 
	<tr> 
	  <td height="30" align="right"> 选择支付方式：</td> 
	  <td><select name="play_id">
	  	<?php foreach($play_list as  $list) {

	  	?>
	  		<option value="<?=$list['id']; ?>" <?php if($list['id']==$rows['play_id']){echo "selected = 'selected'";} ?> ><?=$list['play_title']; ?></option>
	  		<? };?>
	  		
	     </select>&nbsp;*&nbsp;必选择一个</td> 
	</tr> 

	<tr> 
	  <td height="30" align="right"> 第三方支付域名：</td> 
	  <td><input name="site" type="text" class="textfield" id="service_url"  value="<?=$rows['site'];?>" size="40" >&nbsp;*&nbsp;需要添加http://或https://</td> 
	</tr> 
			<tr> 
	  <td height="30" align="right" >  第三方支付商家账号：</td> 
	  <td><input name="play_account" type="text" class="textfield" id="reg_msg_title" value="<?=$rows['play_account'];?>" size="40"></td> 
	</tr> 
			<tr> 
	  <td height="20" align="right" > 第三方支付加密KEY：(可用智付RSA私钥)</td> 
	  <td> 
	  <textarea name="play_key" cols="80" rows="4" class="textfield"><?=$rows['play_key'];?></textarea></td> 
	</tr> 
		

	<tr> 
	  <td height="30" align="right" > 微信商城请求地址：</td> 
	  <td><input name="merchant_url" type="text" class="textfield" id="reg_msg_from" value="<?=$rows['merchant_url'];?>" size="40"></td> 
	</tr>	
	<tr> 
	  <td height="30" align="right" > 第三方公司名称(仅环讯)：</td> 
	  <td><input name="play_name" type="text" class="textfield" id="reg_msg_from" value="<?=$rows['play_name'];?>" size="40"></td> 
	</tr> 

	<tr> 
	  <td height="30" align="right" > 第三方支付终端号：</td> 
	  <td><input name="play_number" type="text" class="textfield" id="reg_msg_from" value="<?=$rows['play_number'];?>" size="40"></td> 
	</tr> 
	
	<tr> 
	  <td height="30" align="right" > 状态：</td> 
	  <td><input name="status" type="radio" class="textfield" id="reg_msg_from" value="0" size="40" <?php if($rows['status']!=1){echo "checked";}?> >禁用

	  	<input name="status" type="radio" class="textfield" id="reg_msg_from" value="1" size="40" <?php if($rows['status']==1){echo "checked";}?>>启用
	  </td> 
	</tr> 
	

	
	<tr> 
	  <td height="30" align="right">&nbsp;</td> 
	  <td valign="bottom"><input name="submitSaveEdit" type="submit" class="button"  id="submitSaveEdit" value="保存" style="width: 60;" ></td> 
	</tr> 
	<tr> 
	  <td height="20" align="right">&nbsp;</td> 
	  <td valign="bottom">&nbsp;</td> 
	</tr> 
  </table></td> 
</tr> 
</form> 
</table></td> 
</tr> 
</table> 
</body> 
</html>