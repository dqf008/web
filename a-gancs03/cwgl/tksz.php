<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('jkkk');
if ($_GET['act'] == 'save'){
	$tkswitch = (0 < count($_POST['tkswitch']) ? 1 : 0);
	$tknumber = trim($_POST['tknumber']);
	$tkrkflag = (0 < count($_POST['tkrkflag']) ? 1 : 0);
	$tkdmflag = (0 < count($_POST['tkdmflag']) ? 1 : 0);
	$tkty = (0 < count($_POST['tkty']) ? 1 : 0);
	$tkcp = (0 < count($_POST['tkcp']) ? 1 : 0);
	$tklh = (0 < count($_POST['tklh']) ? 1 : 0);
	$tkag = (0 < count($_POST['tkag']) ? 1 : 0);
	$tkagq = (0 < count($_POST['tkagq']) ? 1 : 0);
	$tkmaya = (0 < count($_POST['tkmaya']) ? 1 : 0);
	$tkmw = (0 < count($_POST['tkmw']) ? 1 : 0);
	$tkkg = (0 < count($_POST['tkkg']) ? 1 : 0);
	$tkcq9 = (0 < count($_POST['tkcq9']) ? 1 : 0);
	$tkmg2 = (0 < count($_POST['tkmg2']) ? 1 : 0);
	$tkvr = (0 < count($_POST['tkvr']) ? 1 : 0);
	$tkbg = (0 < count($_POST['tkbg']) ? 1 : 0);
	$tksb = (0 < count($_POST['tksb']) ? 1 : 0);
	$tkpt2 = (0 < count($_POST['tkpt2']) ? 1 : 0);
	$tkog2 = (0 < count($_POST['tkog2']) ? 1 : 0);
	$tkdg = (0 < count($_POST['tkdg']) ? 1 : 0);
	$tkky = (0 < count($_POST['tkky']) ? 1 : 0);
	$tkbbin2 = (0 < count($_POST['tkbbin2']) ? 1 : 0);
	$tkog = (0 < count($_POST['tkog']) ? 1 : 0);
	$tkpt = (0 < count($_POST['tkpt']) ? 1 : 0);
	$tkmg = (0 < count($_POST['tkmg']) ? 1 : 0);
	$tkbb = (0 < count($_POST['tkbb']) ? 1 : 0);
	$tkog = (0 < count($_POST['tkog']) ? 1 : 0);
	$tkpt = (0 < count($_POST['tkpt']) ? 1 : 0);
	$tkmg = (0 < count($_POST['tkmg']) ? 1 : 0);
	include_once '../../cache/tkcache.php';
	$str = '<?php ' . "\r\n";
	$str .= 'unset($tkcache);' . "\r\n";
	$str .= '$tkcache = array();' . "\r\n";
	$str .= '$tkcache[\'tkswitch\']=' . $tkswitch . ';' . "\r\n";
	$str .= '$tkcache[\'tknumber\']=' . $tknumber . ';' . "\r\n";
	$str .= '$tkcache[\'tkrkflag\']=' . $tkrkflag . ';' . "\r\n";
	$str .= '$tkcache[\'tkdmflag\']=' . $tkdmflag . ';' . "\r\n";
	$str .= '$tkcache[\'tkty\']=' . $tkty . ';' . "\r\n";
	$str .= '$tkcache[\'tkcp\']=' . $tkcp . ';' . "\r\n";
	$str .= '$tkcache[\'tklh\']=' . $tklh . ';' . "\r\n";
	$str .= '$tkcache[\'tkag\']=' . $tkag . ';' . "\r\n";
	$str .= '$tkcache[\'tkagq\']=' . $tkagq . ';' . "\r\n";
	$str .= '$tkcache[\'tkmaya\']=' . $tkmaya . ';' . "\r\n";
	$str .= '$tkcache[\'tkmw\']=' . $tkmw . ';' . "\r\n";
	$str .= '$tkcache[\'tkkg\']=' . $tkkg . ';' . "\r\n";
	$str .= '$tkcache[\'tkcq9\']=' . $tkcq9 . ';' . "\r\n";
	$str .= '$tkcache[\'tkmg2\']=' . $tkmg2 . ';' . "\r\n";
	$str .= '$tkcache[\'tkvr\']=' . $tkvr . ';' . "\r\n";
	$str .= '$tkcache[\'tkbg\']=' . $tkbg . ';' . "\r\n";
	$str .= '$tkcache[\'tksb\']=' . $tksb . ';' . "\r\n";
	$str .= '$tkcache[\'tkpt2\']=' . $tkpt2 . ';' . "\r\n";
	$str .= '$tkcache[\'tkog2\']=' . $tkog2 . ';' . "\r\n";
	$str .= '$tkcache[\'tkdg\']=' . $tkdg . ';' . "\r\n";
	$str .= '$tkcache[\'tkky\']=' . $tkky . ';' . "\r\n";
	$str .= '$tkcache[\'tkbbin2\']=' . $tkbbin2 . ';' . "\r\n";
	$str .= '$tkcache[\'tkmg\']=' . $tkmg . ';' . "\r\n";
	$str .= '$tkcache[\'tkog\']=' . $tkog . ';' . "\r\n";
	$str .= '$tkcache[\'tkpt\']=' . $tkpt . ';' . "\r\n";
	$str .= '$tkcache[\'tkbb\']=' . $tkbb . ';' . "\r\n";
	if (@!chmod('../../cache', 511)){
		message('缓存文件写入失败！请先设 /cache 文件权限为：0777');
	}
	
	if (!write_file('../../cache/tkcache.php', $str . '?>')){
		message('缓存文件写入失败！请先设/cache/tkcache.php文件权限为：0777');
	}
	include_once '../../class/admin.php';
	admin::insert_log($_SESSION['adminid'], '修改提款-打码配置：' . $ID);
	message('缓存文件写入成功！');
}
include_once '../../cache/tkcache.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<title>提款打码设置</title> 
<style type="text/css"> 
body { 
  margin: 0px;
} 
td{font:13px/120% "宋体";padding:3px;} 
a{ 

  color:#F37605;

  text-decoration: none;

} 
.t-title{background:url(../images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
</STYLE> 
<script language="JavaScript" src="../../js/jquery.js"></script> 
<script language="javascript"> 
//数字验证 过滤非法字符 
	  function clearNoNum(obj){ 
		  obj.value = obj.value.replace(/[^\d.]/g,"");//先把非数字的都替换掉，除了数字和. 
		  obj.value = obj.value.replace(/^\./g,"");//必须保证第一个为数字而不是. 
		  obj.value = obj.value.replace(/\.{2,}/g,".");//保证只有出现一个.而没有多个. 
		  obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");//保证.只出现一次，而不能出现两次以上 
		  if(obj.value != ''){ 
			  var re=/^\d+\.{0,1}\d{0,2}$/;
			  if(!re.test(obj.value))    
			  {    
				  obj.value = obj.value.substring(0,obj.value.length-1);
				  return false;
			  }  
		  } 
	  } 
</script> 
</head> 
<body> 
<span>&nbsp;提款-打码量设置</span> 
<form action="tksz.php?act=save" method="post"> 
  <table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #000;" id=editProduct   idth="100%" >  
	  <tr style="background-color: #5E6FA4" align="center"> 
		  <td height="40" width="150"><strong>自动审核-开关</strong></td> 
		  <td width="150"><strong>需要几倍打码量</strong></td> 
		  <td><strong>打码量包含的游戏类型</strong></td> 
		  <td><strong>显示详细</strong></td> 
		  <td><strong>操作</strong></td> 
	  </tr> 
	  <tr align="center"> 
		  <td align="center"> 
			  <input name="tkswitch" type="checkbox" <?=$tkcache['tkswitch']==1 ? 'checked="checked"' : ''?> value="<?=$tkcache['tkswitch']?>"> 
		  </td> 
		  <td  align="center"> 
			  <input name="tknumber" type="text" value="<?=$tkcache['tknumber']?>" size="5" align="center" style="text-align:center;" onkeyup="clearNoNum(this);"/> 
		  </td> 
		  <td  align="center" style="line-height:22px;"> 
			  <input name="tkty" type="checkbox"<?=$tkcache['tkty']==1 ? 'checked="checked"' : '' ?> >体育 
			  <input name="tkcp" type="checkbox"<?=$tkcache['tkcp']==1 ? 'checked="checked"' : '' ?> >彩票 
			  <input name="tklh" type="checkbox"<?=$tkcache['tklh']==1 ? 'checked="checked"' : '' ?> >香港六合彩<br/> 
			  <input name="tkag" type="checkbox"<?=$tkcache['tkag']==1 ? 'checked="checked"' : '' ?> >AG国际厅 
			  <input name="tkagq" type="checkbox"<?=$tkcache['tkagq']==1 ? 'checked="checked"' : '' ?> >AG极速厅 
			  <input name="tkbbin2" type="checkbox"<?=$tkcache['tkbbin2']==1 ? 'checked="checked"' : '' ?> >新BB波音厅 
			  <input name="tkmaya" type="checkbox"<?=$tkcache['tkmaya']==1 ? 'checked="checked"' : '' ?> >玛雅娱乐厅 
			  <input name="tkmw" type="checkbox"<?=$tkcache['tkmw']==1 ? 'checked="checked"' : '' ?> >MW电子 
			  <input name="tkkg" type="checkbox"<?=$tkcache['tkkg']==1 ? 'checked="checked"' : '' ?> >AV女优 
			  <input name="tkcq9" type="checkbox"<?=$tkcache['tkcq9']==1 ? 'checked="checked"' : '' ?> >CQ9电子
			  <input name="tkmg2" type="checkbox"<?=$tkcache['tkmg2']==1 ? 'checked="checked"' : '' ?> >新MG电子
			  <input name="tkvr" type="checkbox"<?=$tkcache['tkvr']==1 ? 'checked="checked"' : '' ?> >VR彩票
			  <input name="tkbg" type="checkbox"<?=$tkcache['tkbg']==1 ? 'checked="checked"' : '' ?> >BG视讯
			  <input name="tksb" type="checkbox"<?=$tkcache['tksb']==1 ? 'checked="checked"' : '' ?> >申博视讯
			  <input name="tkpt2" type="checkbox"<?=$tkcache['tkpt2']==1 ? 'checked="checked"' : '' ?> >新PT电子
			  <input name="tkog2" type="checkbox"<?=$tkcache['tkog2']==1 ? 'checked="checked"' : '' ?> >新OG东方厅
			  <input name="tkdg" type="checkbox"<?=$tkcache['tkdg']==1 ? 'checked="checked"' : '' ?> >DG视讯
			  <input name="tkky" type="checkbox"<?=$tkcache['tkky']==1 ? 'checked="checked"' : '' ?> >开元棋牌
			  <input name="tkmg" type="checkbox"<?=$tkcache['tkmg']==1 ? 'checked="checked"' : '' ?> >MG电子
			  <input name="tkpt" type="checkbox"<?=$tkcache['tkpt']==1 ? 'checked="checked"' : '' ?> >PT电子
			  <input name="tkog" type="checkbox"<?=$tkcache['tkog']==1 ? 'checked="checked"' : '' ?> >OG东方厅 
			  <input name="tkbb" type="checkbox"<?=$tkcache['tkbb']==1 ? 'checked="checked"' : '' ?> >BB波音厅 
		  </td> 
		  <td  align="center" style="line-height:22px;"> 
			  <input name="tkrkflag" type="checkbox"<?=$tkcache['tkrkflag']==1 ? 'checked="checked"' : '' ?> >入款详细显示<br/> 
			  <input name="tkdmflag" type="checkbox"<?=$tkcache['tkdmflag']==1 ? 'checked="checked"' : '' ?> >打码详细显示 
		  </td> 
		  <td  align="center"> 
			  <input type="submit" value="保存"/> 
		  </td> 
	  </tr> 
  </table> 
</form>
<?php include_once 'tkrule.html';?>
</body> 
</html>