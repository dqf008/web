<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('jkkk');

$group = array();
$sql = 'select id,name from k_group order by id asc';
$query = $mydata1_db->query($sql);
while ($rows = $query->fetch()){
	$group[$rows['id']] = $rows['name'];
}

if(!empty($_GET['act']) && $_GET['act']=='list'){
	include '../../cache/bank2.php';
	foreach($bank as $k=>$v){
		$g['name'] = $group[$k];
		$g['banklist'] = $v;
		$data[$k] = $g;
	}
	echo json_encode($data);
	exit;
}

//获取扩展名
function fileext($filename)
{
	return substr(strrchr($filename, '.'), 1);
}
if ($_GET['act'] == 'add'){
	$bankName = trim($_POST['card_bankName']);
	$ID = trim($_POST['card_ID']);
	$card_name = trim($_POST['card_name']);
	$card_img = trim($_POST['card_img']);
	  $lj = '../static/uploads/'.date('Ymd').'/';
	  $destination_folder = dirname(__FILE__).'/../'.$lj;     //上传文件路径
	  $uptypes = array (
			'image/jpg',
			'image/png',
			'image/jpeg',
			'image/pjpeg',
			'image/gif',
			'image/bmp',
			'image/x-png'
	  );
	  if(is_uploaded_file($_FILES['imagesUrl']['tmp_name'])) {
	  	$upfile = $_FILES['imagesUrl'];
		$name = time().'.'.'jpg';//fileext($upfile['name']);    //文件名
        $type = $upfile['type']; //文件类型
        $size = $upfile['size']; //文件大小
        $tmp_name = $upfile['tmp_name'];  //临时文件
        $error = $upfile['error']; //出错原因
		if (!in_array($type, $uptypes)) {        //判断文件的类型
            message('请上传图片文件！');
            exit ();
        }
		if (!file_exists($destination_folder)) {
            mkdir($destination_folder);
        }
		$uploadfile1 = $destination_folder.$name;
		$card_img = $lj.$name;
		move_uploaded_file($tmp_name, $uploadfile1);
	  }else{
	  	message('请上传图片文件！');
	  }
	$groupid = trim($_POST['card_group']);
	include_once '../../cache/bank2.php';
	$str = '<?php ' . "\r\n";
	$str .= 'unset($bank);' . "\r\n";
	$str .= '$bank = array();' . "\r\n";
	foreach ($bank as $gid => $arr){
		$i = 0;
		foreach ($arr as $k => $card){
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_bankName\']=\'' . $card['card_bankName'] . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_ID\']=\'' . $card['card_ID'] . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_name\']=\'' . $card['card_name'] . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_img\']=\'' . $card['card_img'] . '\';' . "\r\n";
			$i++;
		}
		
		if ($gid == $groupid){
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_bankName\']=\'' . $bankName . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_ID\']=\'' . $ID . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_name\']=\'' . $card_name . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_img\']=\'' . $card_img . '\';' . "\r\n";
		}
	}
	if (!isset($bank[$groupid]))
	{
		$str .= '$bank[' . $groupid . '][0][\'card_bankName\']=\'' . $bankName . '\';' . "\r\n";
		$str .= '$bank[' . $groupid . '][0][\'card_ID\']=\'' . $ID . '\';' . "\r\n";
		$str .= '$bank[' . $groupid . '][0][\'card_name\']=\'' . $card_name . '\';' . "\r\n";
		$str .= '$bank[' . $groupid . '][0][\'card_img\']=\'' . $card_img . '\';' . "\r\n";
	}
	if (@!chmod('../../cache', 511))
	{
		message('缓存文件写入失败！请先设 /cache 文件权限为：0777');
	}
	if (!write_file('../../cache/bank2.php', $str . '?>'))
	{
		message('缓存文件写入失败！请先设/cache/bank2.php文件权限为：0777');
	}
	include_once '../../class/admin.php';
	admin::insert_log($_SESSION['adminid'], '添加入款银行账号：' . $ID);
	message('缓存文件写入成功！');
}else if ($_GET['act'] == 'del'){
	$gid = trim($_GET['gid']);
	$id = trim($_GET['id']);
	include_once '../../cache/bank2.php';
	$card_ID = $bank[$gid][$id]['card_ID'];
	unset($bank[$gid][$id]);
	$str = '<?php ' . "\r\n";
	$str .= 'unset($bank);' . "\r\n";
	$str .= '$bank = array();' . "\r\n";
	foreach ($bank as $gid => $arr){
		$i = 0;
		foreach ($arr as $k => $card){
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_bankName\']=\'' . $card['card_bankName'] . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_ID\']=\'' . $card['card_ID'] . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_name\']=\'' . $card['card_name'] . '\';' . "\r\n";
			$str .= '$bank[' . $gid . '][' . $i . '][\'card_img\']=\'' . $card['card_img'] . '\';' . "\r\n";
			$i++;
		}
	}
	
	if (@!chmod('../../cache', 511)){
		message('缓存文件写入失败！请先设 /cache 文件权限为：0777');
	}
	
	if (!write_file('../../cache/bank2.php', $str . '?>')){
		message('缓存文件写入失败！请先设/cache/bank2.php文件权限为：0777');
	}
	include_once '../../class/admin.php';
	admin::insert_log($_SESSION['adminid'], '删除入款银行账号：' . $card_ID);
	message('缓存文件写入成功！');
}else if($_GET['act'] == 'sort'){
	$input = file_get_contents("php://input");
	$_POST = json_decode($input, true);
	$gid2 = $_POST['gid'];
	$list = $_POST['list'];
	include_once '../../cache/bank2.php';
	if(count(array_diff($bank[$gid2],$list))>0 ) die('error');
	$str = '<?php ' . "\r\n";
	$str .= 'unset($bank);' . "\r\n";
	$str .= '$bank = array();' . "\r\n";
	foreach ($bank as $gid => $arr){
		$i = 0;
		if($gid == $gid2){
			foreach ($list as $k => $card){
				$str .= '$bank[' . $gid . '][' . $i . '][\'card_bankName\']=\'' . $card['card_bankName'] . '\';' . "\r\n";
				$str .= '$bank[' . $gid . '][' . $i . '][\'card_ID\']=\'' . $card['card_ID'] . '\';' . "\r\n";
				$str .= '$bank[' . $gid . '][' . $i . '][\'card_name\']=\'' . $card['card_name'] . '\';' . "\r\n";
				$str .= '$bank[' . $gid . '][' . $i . '][\'card_img\']=\'' . $card['card_img'] . '\';' . "\r\n";
				$i++;
			}
		}else{
			foreach ($arr as $k => $card){
				$str .= '$bank[' . $gid . '][' . $i . '][\'card_bankName\']=\'' . $card['card_bankName'] . '\';' . "\r\n";
				$str .= '$bank[' . $gid . '][' . $i . '][\'card_ID\']=\'' . $card['card_ID'] . '\';' . "\r\n";
				$str .= '$bank[' . $gid . '][' . $i . '][\'card_name\']=\'' . $card['card_name'] . '\';' . "\r\n";
				$str .= '$bank[' . $gid . '][' . $i . '][\'card_img\']=\'' . $card['card_img'] . '\';' . "\r\n";
				$i++;
			}
		}
	}
	
	if (@!chmod('../../cache', 511)){
		die('error');
	}
	
	if (!write_file('../../cache/bank2.php', $str . '?>')){
		die('error');
	}
	die('success');
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html ng-app="adminApp" xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>微信、支付宝</title> 
<style type="text/css"> 
body {   margin: 0px; } 
td{font:13px/120% "宋体";padding:3px;} 
a{ 
  color:#F37605;
  text-decoration: none;
} 
.t-title{background:url(../images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
[ng-click]{
	cursor: pointer;
}
</style> 
<script language="JavaScript" src="../../js/jquery.js"></script> 
<script language="javascript"> 
function check(){ 
  if($("#card_bankName").val().length < 1){ 
	  $("#card_bankName").focus();
	  return false;
  } 
  if($("#card_ID").val().length < 1){ 
	  $("#card_ID").focus();
	  return false;
  } 
  if($("#card_name").val().length < 1){ 
	  $("#card_name").focus();
	  return false;
  } 
  // if($("#card_img").val().length < 1){ 
	 //  $("#card_img").focus();
	 //  return false;
  // } 
  if($("#card_group").val().length < 1){ 
	  return false;
  } 
  return true;
} 
</script> 
</head> 
<body ng-controller="qrcodeController"> 
<table  width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" >       
	<tr style="background-color: #EFE" class="t-title"  align="center"> 
	  <td width="15%" height="20"><strong>支付名称</strong></td> 
	  <td width="15%" ><strong>账号</strong></td> 
	  <td width="15%" ><strong>昵称</strong></td> 
	  <td width="15%" ><strong>二维码文件图</strong></td> 
	  <td width="5%"><strong>操作</strong></td> 
	</tr>
</table>
<table ng-repeat="(gid,g) in groupList"   width="100%" border="1"  bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;">
	<tr><td colspan="5" style="background-color:#ddd"><strong ng-bind="g.name"></strong><button ng-hide="true" type="button" style="float:right;" ng-click="saveSort(gid)">保存排序</button></td></tr>
	<tr ng-repeat="(id,bank) in g.banklist" ng-drop="true" ng-drag="true" ng-drag-data="bank" ng-drop-success="dropComplete($index,$data,gid)" align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="background-color:#FFFFFF;">
		<td width="15%" ng-bind="bank.card_bankName"></td>
		<td width="15%" ng-bind="bank.card_ID"></td>
		<td width="15%" ng-bind="bank.card_name"></td>
		<td width="15%"><a ng-click="open_qrcode(bank.card_img)">点击查看</a></td>
		<td width="5%"><a ng-hide="isSort" ng-href="{{'?act=del&gid='+gid+'&id='+id}}" onclick="return confirm('您确定要删除吗?')">删除</a></td>
	</tr>
</table> 
<br /> 
<form action="?act=add" method="post" name="from1" id="from1" onsubmit="return check();" enctype="multipart/form-data"> 
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" id=editProduct   idth="100%" > 
		  <tr align="center"> 
			<td colspan="4" align="left" bgcolor="#D9D9D9">支付信息设置</td> 
		  </tr> 
		  <tr align="center"> 
			<td width="18%" align="right">支付名称：</td> 
			<td width="82%" colspan="3" align="left"><label> 
			<input name="card_bankName" type="text" id="card_bankName"  style=" width:250px;"/> 
			</label></td> 
		</tr> 
		  <tr align="center"> 
			<td align="right">入款账号： </td> 
			<td colspan="3" align="left"><input name="card_ID" type="text" id="card_ID" style=" width:250px;"/></td> 
		  </tr> 
		  <tr align="center"> 
			<td align="right">昵称： </td> 
			<td colspan="3" align="left"><input name="card_name" type="text" id="card_name" style=" width:250px;"/></td> 
		  </tr> 
		  <tr align="center"> 
			<td align="right">二维码： </td> 
			<td colspan="3" align="left"> 
			  <input name="imagesUrl" type="file" style=" width:250px;"/> 
			  <span style="color:red;">注意：只允许上传png、jpg、gif、bmp图片文件（大小规格：200*200）</span> 
		  </td> 
		  </tr> 
		  <tr align="center"> 
			<td align="right">所属会员组：</td> 
			<td colspan="3" align="left">
			<select name="card_group" id="card_group">
			<?php
			foreach($group as $k=>$v){
			?>
				<option value="<?=$k?>" <?=$k==$_GET['gid'] ? 'selected' : ''?>><?=$v?></option>
			<?php
			}
			?>
			</select>
			</td> 
  </tr> 
		  <tr align="center"> 
			<td colspan="4" align="center">&nbsp;<span style="color:blue;">注意：【扫一扫充值】的订单，统一存放在【汇款管理】那边；</span></td> 
  </tr> 
		  <tr align="center"> 
			<td align="right">&nbsp;</td> 
			<td colspan="3" align="left"> 
			  <input name="submit" type="submit" value="保存" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="cksz.php"><input name="reset" type="button" value="返回" /></a></td> 
  </tr> 
</table> 
</form> 
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/angular@1.6.9/angular.min.js"></script>
<!--script type="text/javascript" src="https://cdn.jsdelivr.net/npm/ng-draggable@1.0.0/ngDraggable.min.js"></script-->
<script type="text/javascript">
var app = angular.module('adminApp',[]);
app.controller('qrcodeController',['$scope', '$http','$window', function(n,s,w){
	n.groupList = [];
	n.isSort = false;
	n.init = function(){
		s.get('?act=list&_=<?=time()?>').then(function(d){
			n.groupList = d.data;
		});
	}
	n.open_qrcode = function(url){
		window.open('/newindex/'+url)
	}
	n.dropComplete = function(index, obj, gid){
		if(obj == null) return;
		n.isSort = true;
		var list = n.groupList[gid].banklist;
	    var idx = list.indexOf(obj);   
	    list.splice(idx,1);
    	list.splice(index,0,obj); 
	    n.groupList[gid].banklist = list;
	};
	n.saveSort = function(gid){
		console.log(n.groupList[gid])
	    s.post('?act=sort',{'gid':gid,'list':n.groupList[gid].banklist}).then(function(s){
	    	if(s.data == 'success'){
	    		alert('缓存文件写入成功！');
	    	}else{
	    		alert('缓存文件写入失败！');
	    	}
	    	w.location.reload();
	    });
	}
	n.init();
}]);
</script>
</body> 
</html>