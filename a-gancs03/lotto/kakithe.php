<?php 
if (!defined('PHPYOU_VER')){
	exit('非法进入');
}

if ($_POST['sdel'] != ''){
	$del_num = count($_POST['sdel']);
	$i = 0;
	for (;$i < $del_num;$i++)
	{
		$params = array(':id' => intval($sdel[$i]));
		$stmt = $mydata2_db->prepare('Delete from ka_kithe where id=:id');
		$stmt->execute($params);
	}
	echo "<script type='text/javascript'>alert('删除成功！');history.back();</script>";
}

if ($_GET['sdel'] != ''){
	$dell = $_GET['sdel'];
	$params = array(':id' => intval($dell));
	$stmt = $mydata2_db->prepare('Delete from ka_kithe where id=:id');
	$stmt->execute($params);
	echo "<script type='text/javascript'>alert('删除成功！');history.back();</script>";
}

if ($_GET['daction'] == 'store'){
	$store_kithe = $_GET['kithe'];
	if (time() - intval($_SESSION['last_backup' . $store_kithe]) <= 120){
		echo "<script type='text/javascript'>alert('为了防止归档错误，120秒之内不允许重复操作');history.back();</script>";
		exit();
	}
	$_SESSION['last_backup' . $store_kithe] = time();
	$params = array(':nn' => intval($store_kithe));
	$stmt = $mydata2_db->prepare('select score from ka_kithe where nn=:nn');
	$stmt->execute($params);
	$score = $stmt->fetchColumn();
	if ($score == 1){
		$params = array(':kithe' => intval($store_kithe));
		$stmt = $mydata2_db->prepare('select count(*) from ka_tan where kithe=:kithe');
		$stmt->execute($params);
		$recordNum = $stmt->fetchColumn();
		$params = array(':kithe' => intval($store_kithe));
		$stmt = $mydata2_db->prepare('insert into ka_tan_bak select * from ka_tan where kithe=:kithe');
		$stmt->execute($params);
		$updateNum = $stmt->rowCount();
		if ($recordNum == $updateNum){
			$params = array(':kithe' => intval($store_kithe));
			$stmt = $mydata2_db->prepare('Delete from ka_tan where kithe=:kithe');
			$stmt->execute($params);
			$params = array(':nn' => intval($store_kithe));
			$stmt = $mydata2_db->prepare('update ka_kithe set score = 2 where nn=:nn');
			$stmt->execute($params);
			unset($_SESSION['last_backup' . $store_kithe]);
			echo "<script type='text/javascript'>alert('归档成功！处理".$updateNum."条！');history.back();</script>";
		}else{
			$params = array(':kithe' => intval($store_kithe));
			$stmt = $mydata2_db->prepare('Delete from ka_tan_bak where kithe=:kithe');
			$stmt->execute($params);
			unset($_SESSION['last_backup' . $store_kithe]);
			echo "<script type='text/javascript'>alert('归档失败,请相关管理人员！');history.back();</script>";
		}
	}else{
		echo  "<script type='text/javascript'>alert('该期还没结算，不能归档！');history.back();</script>";
	}
}

if ($_GET['daction'] == 'restore'){
	$store_kithe = $_GET['kithe'];
	if (time() - intval($_SESSION['last_restore' . $store_kithe]) <= 120)
	{
		echo "<script type='text/javascript'>alert('为了防止恢复错误，120秒之内不允许重复操作');history.back();</script>";
		exit();
	}
	$_SESSION['last_restore' . $store_kithe] = time();
	$params = array(':nn' => intval($store_kithe));
	$stmt = $mydata2_db->prepare('select score from ka_kithe where nn=:nn');
	$stmt->execute($params);
	$score = $stmt->fetchColumn();
	if ($score == 2){
		$params = array(':kithe' => intval($store_kithe));
		$stmt = $mydata2_db->prepare('select count(*) from ka_tan_bak where kithe=:kithe');
		$stmt->execute($params);
		$recordNum = $stmt->fetchColumn();
		$params = array(':kithe' => intval($store_kithe));
		$stmt = $mydata2_db->prepare('insert into ka_tan select * from ka_tan_bak where kithe=:kithe');
		$stmt->execute($params);
		$updateNum = $stmt->rowCount();
		if ($recordNum == $updateNum){
			$params = array(':kithe' => intval($store_kithe));
			$stmt = $mydata2_db->prepare('Delete from ka_tan_bak where kithe=:kithe');
			$stmt->execute($params);
			$params = array(':nn' => intval($store_kithe));
			$stmt = $mydata2_db->prepare('update ka_kithe set score = 1 where nn=:nn');
			$stmt->execute($params);
			unset($_SESSION['last_restore' . $store_kithe]);
			echo "<script type='text/javascript'>alert('恢复成功！处理".$updateNum."条！');history.back();</script>";
		}else{
			$params = array(':kithe' => intval($store_kithe));
			$stmt = $mydata2_db->prepare('Delete from ka_tan where kithe=:kithe');
			$stmt->execute($params);
			unset($_SESSION['last_restore' . $store_kithe]);
			echo "<script type='text/javascript'>alert('恢复失败,请相关管理人员！');history.back();</script>";
	    }
	}else{
		echo "<script type='text/javascript'>alert('该期没有被归档，不能恢复！');history.back();</script>";
	}
}

if ($_GET['t0'] == '是'){
	$params = array(':id' => intval($_GET['newsid']));
	$sql = 'update ka_kithe set lx=1 where id=:id';
	$stmt = $mydata2_db->prepare($sql);
	$stmt->execute($params);
	echo "<script>alert('修改第[<".$_GET['name'].">]期为显示，让会员代理可以查看数据！!');history.back();</script>";
	exit();
}

if ($_GET['t0'] == '否')
{
	$params = array(':id' => intval($_GET['newsid']));
	$sql = 'update ka_kithe set lx=0 where id=:id';
	$stmt = $mydata2_db->prepare($sql);
	$stmt->execute($params);
	echo "<script>alert('修改第[<".$_GET['name'].">]期为隐藏，让会员代理查看不到数据!');history.back();</script>";
	exit();
}

if ($_GET['id'] != ''){
	$id = $_GET['id'];
}else{
	$id = 0;
}
?>
<link rel="stylesheet" href="images/xp.css" type="text/css"> 
<script language="javascript" type="text/javascript" src="js_admin.js"></script> 
 

<SCRIPT language=JAVASCRIPT> 
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT> 
<style>    
.caozuo_a{ 
  color:#000!important;
  padding:2px;
  border: #cccccc solid 1px;
  background: #EEE;
}  

.caozuo_a img{ 
  border: none;
} 

.caozuo_a:hover{ 
  color:blue;
  border: #F00 solid 2px;
}  
.content_td{ 
  background-color:#FFF!important;
} 
</style> 
<div align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="5"> 
<tr class="tbtitle"> 
  <td width="23%"><?php require_once '1top.php';?></td> 
  <td width="29%"><table> 
	<form  action="index.php?action=kakithe&amp;id=0" method="post" name="regstep1" id="regstep1"> 
	  <tr> 
		<td colspan="2" align="center" nowrap="nowrap"><p align="right"><font color="#FFFFFF">期数：</font></p></td> 
		<td align="center" colspan="6"><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
			<tr> 
			  <td><input name="key" type="text" class="input1" id="key" size="20" /></td> 
			  <td width="80" align="center"><input type="submit" value="搜索" name="B1"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22"></td> 
			  <td>&nbsp;</td> 
			</tr> 
		</table></td> 
	  </tr> 
	</form> 
	</table><td width="20%">&nbsp;</td><td width="1%"></td> 
  <td width="27%"><div align="right"> 
	<button onclick="javascript:location.href='index.php?action=kakithe&amp;id=0'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22"><img src="images/add.gif" width="16" height="16" align="absmiddle" /><font <?=$id == 0 ? 'color="#ff0000"':'color="#000000"';?>>所有期数</font></button>&nbsp;<button onclick="javascript:location.href='index.php?action=kakithe&amp;id=2'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22"><img src="images/add.gif" width="16" height="16" align="absmiddle" /><font <?=$id == 2 ? 'color="#ff0000"':'color="#000000"';?>>显示</font></button>&nbsp;<button onclick="javascript:location.href='index.php?action=kakithe&amp;id=1'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22"><img src="images/add.gif" width="16" height="16" align="absmiddle" /><font <?=$id == 1 ? 'color="#ff0000"':'color="#000000"';?>>隐藏</font></button>&nbsp;</div></td> 
</tr> 
<tr > 
  <td height="5" colspan="3"></td> 
  </tr> 
</table> 

<table width="99%" height="83" border="1" align="center" cellpadding="5" cellspacing="1"  bordercolor="f1f1f1" bgcolor="ffffff"> 
	 <tr> 
	   <td colspan="15" align="center" bgcolor="#FDF4CA">六合彩</td> 
	 </tr> 
	<form name="form1" method="post" action="index.php?action=kakithe"> 
	<tr > 
	  <td width="50" height="28" rowspan="2" bordercolor="cccccc" bgcolor="#FDF4CA"><div align="center"> 
		<input type="checkbox" name="sele" value="checkbox" onclick="javascript:checksel(this.form);" /> 
	  </div></td> 
	  <td width="60" rowspan="2" bordercolor="cccccc" bgcolor="#FDF4CA"><div align="center">期数</div></td> 
	  <td width="135" rowspan="2" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">开奖时间</td> 
	  <td colspan="7" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">开奖球号</td> 
	  <td width="95" rowspan="2" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">生肖</td> 
	  <td width="80" rowspan="2" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">是否开奖 </td> 
	  <td width="50" rowspan="2" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">状态</td> 
	  <td width="150" rowspan="2" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"><div align="center">操作</div></td> 
	  <td width="80" rowspan="2" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"><div align="center">注单数据</div></td> 
	</tr> 
	<tr > 
	  <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">平1</td> 
	  <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">平2</td> 
	  <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">平3</td> 
	  <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">平4</td> 
	  <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">平5</td> 
	  <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">平6</td> 
	  <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">特码</td> 
	</tr>
<?php 
$xc = $_POST['xc'];
$key = $_POST['key'];
if ($xc == '')
{
$xc = $_GET['xc'];
}
if ($key == '')
{
$xc = $_GET['key'];
}
$params = array();
$vvv = ' where na<>0 ';
$vvvv = '&id=' . $id . '';
if ($key != '')
{
$params[':nn'] = '%' . $key . '%';
$vvv .= ' and nn LIKE :nn  ';
$vvvv .= '&key=' . $key . '';
}
if ($id == 1)
{
$vvv .= ' and lx=0  ';
}
if ($id == 2)
{
$vvv .= ' and lx=1  ';
}
$result = $mydata2_db->prepare('select count(*) from ka_kithe  ' . $vvv . '  order by id desc');
$result->execute($params);
$num = $result->fetchColumn();
if (!$num){
	echo "<tr align=center><td colspan=14>暂无数据</td></tr>";
}
$curpage = intval($page);
$perpage = 10;
$pagesa = @(ceil($num / $perpage));
if ($curpage){
	$start_limit = ($curpage - 1) * $perpage;
}else{
	$start_limit = 0;
	$curpage = 1;
}
$start_limit = intval($start_limit);
$perpage = intval($perpage);
$multipage = cpmulti($num, $perpage, $curpage, '?action=kakithe' . $vvvv . '');
$result = $mydata2_db->prepare('select * from ka_kithe  ' . $vvv . '  order by id desc limit ' . $start_limit . ', ' . $perpage);
$result->execute($params);
while ($image = $result->fetch()){
?>
     <tr class="content_td"> 
	  <td height="25" bordercolor="cccccc" bgcolor="#FFFFFF">
	  <div align="center"> 
		<input name="sdel[]" type="checkbox" id="sdel[]" value="<?=$image['id'];?>" <?=$image['score'] == 1 ? 'disabled="disabled"' : ''?>/> 
	  </div>
	  </td> 
	  <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$image['nn'];?></td> 
	  <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$image['nd'];?></td> 
	  <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><img src="images/num<?=$image['n1'];?>.gif" /></td> 
	  <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><img src="images/num<?=$image['n2'];?>.gif" /></td> 
	  <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><img src="images/num<?=$image['n3'];?>.gif" /></td> 
	  <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><img src="images/num<?=$image['n4'];?>.gif" /></td> 
	  <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><img src="images/num<?=$image['n5'];?>.gif" /></td> 
	  <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><img src="images/num<?=$image['n6'];?>.gif" /></td> 
	  <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><img src="images/num<?=$image['na'];?>.gif" /></td> 
	  <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?=$image['x1'].$image['x2'].$image['x3'].$image['x4'].$image['x5'].$image['x6'];?>+<?=$image['sx'];?></td> 
	  <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><?php if ($image['na'] != 0){ echo '已开奖'; }else{ echo '<font color=ff0000>未开奖</font>';}?></td> 
	  <td height="25" align="center" bordercolor="cccccc" bgcolor="#FFFFFF">
	  <?php if ($image['n1'] != 0){?>
	  <a href="index.php?action=kakithe&amp;newsid=<?=$image['id'];?>&amp;t0=<?=$image['lx']== 1 ? '否' : '是' ?>&amp;id=<?=$image['id'];?>&amp;ids=<?=$ids;?>&amp;page=<?=$curpage;?>&amp;name=<?=$image['nn'];?>&amp;key=<?=$_POST['key'];?>">
	  <img src="images/<?php if ($image['lx'] == 1){?>icon_21x21_selectboxon.gif<?php }else{?>icon_21x21_selectboxoff.gif<?php }?>" name="test_b<?=$image['id'];?>" width="21" height="21" border="0" id="test_b<?=$image['id'];?>"  value="<?php if ($image['lx'] == 1){?> True<?php }else{?> False<?php }?> "></a>
	  <?php }else{?>             
	  	<font color="ff0000">未开奖</font>
	  <?php }?>         
	  </td> 
	  <td nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF" height="30"> 
		  <div align="center" style="padding-top:5px;">
		  <?php if ($image['score'] == 0){?> 				  
		  	  <a class="caozuo_a" href="javascript:jiesuan(<?=$image['nn'];?>);"> 
				  <img src="images/banner.gif" width="16" height="16" align="absmiddle" />结算 
			  </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <a class="caozuo_a" href="javascript:xiugai(<?=$image['id'];?>);"> 
				  <img src="images/icon_21x21_edit01.gif" align="absmiddle" />修改 
			  </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <a class="caozuo_a" href="javascript:shanchu(<?=$curpage;?>,<?=$image['id'];?>,<?=$image['id'];?>);"> 
				  <img src="images/icon_21x21_del.gif" align="absmiddle" />删除 
			  </a>
		  <?php }else if ($image['score'] == 1){?>   
			  <a class="caozuo_a" href="javascript:congsuan(<?=$image['nn'];?>);"> 
				  <img src="images/banner.gif" width="16" height="16" align="absmiddle" />重算 
			  </a>
		  <?php }else{?> --<?php }?>            
		  </div> 
		   
		
	  </td> 
	  <td nowrap="nowrap" bordercolor="cccccc" bgcolor="#FFFFFF">
	  <div align="center" style="padding-top:5px;">
	  <?php if ($image['score'] == 1){?> 			  
	  	  <a class="caozuo_a" href="javascript:guidang(<?=$image['nn'];?>);"> 
			  <img src="images/banner.gif" width="16" height="16" align="absmiddle" />归档 
		  </a>&nbsp;
	  <?php }else if ($image['score'] == 2){?> 			  
	  	  <a class="caozuo_a" href="javascript:huifu(<?=$image['nn'];?>);"> 
			  <img src="images/icon_21x21_edit01.gif" width="16" height="16" align="absmiddle" />恢复 
		  </a>&nbsp;
	  <?php }else{?> --<?php }?> 			  
	  </div> 
	  </td> 
	</tr>
	<?php }?>       
	<tr> 
	  <td height="25" colspan="15" bordercolor="cccccc" bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" bordercolordark="#FFFFFF" bordercolor="888888"> 
		  <tr> 
			<td width="180" height="26" nowrap="nowrap"><div align="left"> 
				<input type="hidden" name="idtxt" /> 
				<input name="id" type="hidden" id="id" value="<%=id%>" />
				<?php if ($_POST['username'] != ''){?>                   
				<input name="username" type="hidden" id="username" value="<?=$_POST['username'];?>" /> 
				<input name="xc" type="hidden" id="xc" value="<?=$_POST['xc'];?>" />
				<?php }?>                   
				<button onclick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:95;height:22"><img src="images/icon_21x21_del.gif" align="absmiddle" />删除选定期数</button>&nbsp;<button onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22"><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button> 
			</div></td> 
			<td height="26"><div align="center"><?=$multipage;?>&nbsp;</div></td> 
			<td height="26" width="60">
			<div align="center"> 
				<select name="page" onchange="location.href='index.php?action=kakithe&amp;id=<?=$id?><? if ($_POST['username']<>"") {?>&amp;username=<?=$username?>&amp;xc=<?=$xc?><? }?>&amp;page='+this.options[selectedIndex].value">
                    <? for($i =1; $i <= $pagesa; $i++) {?>
                    <option value="<?=$i?>" <? if ($curpage==$i){ ?>selected<? }?>>第<?=$i?>页</option>
                    <? }?>
                  </select>
			</div>
			</td> 
		  </tr> 
		</table> 
	  </td> 
	</tr>
  </form> 
</table>  

<table width="98%" border="0" cellspacing="0" cellpadding="0"> 
<tr> 
  <td width="70"><div align="left"> </div></td> 
  <td><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> 提示：如果修改某一期的任何一个球号后请再重新结算该期！状态如果打上了勾前台会员代理才可以查看该期的数据否则无法查看!</div></td> 
</tr> 
</table> 
</div> 
<script> 

var isdo = 0;
//结算 
function jiesuan(kithe){ 
  if(confirm('点击[确定]进入结算并耐心等待成功的提示！')){ 
	  isdo ++;
	  if(isdo==1){ 
		  window.location.href='index.php?action=kawin&kithe='+kithe;
	  }else{ 
		  alert('操作执行中，请稍后...');
	  } 
  } 
} 

//修改 
function xiugai(id){ 
  location.href='index.php?action=kithe_edit&id='+id;
} 

//删除 
function shanchu(page,id,sdel){ 
  if(confirm('点击[确定]，将删除该开奖记录')){ 
	  location.href='index.php?action=kakithe&act=删除&page='+page+'&id='+id+'&sdel='+sdel;
  } 
} 

//重算 
function congsuan(kithe){ 
  if(confirm('点击[确定]进入重算并耐心等待成功的提示！')){ 
	  isdo ++;
	  if(isdo==1){ 
		  location.href='index.php?action=chongsuan&kithe='+kithe;
	  }else{ 
		  alert('操作执行中，请稍后...');
	  } 
  } 
} 

//归档 
function guidang(kithe){ 
  if(confirm('点击[确定]进入归档并耐心等待成功的提示！')){ 
	  isdo ++;
	  if(isdo==1){ 
		  location.href='index.php?action=kakithe&daction=store&kithe='+kithe;
	  }else{ 
		  alert('操作执行中，请稍后...');
	  } 
  } 
} 

//恢复 
function huifu(kithe){ 
  if(confirm('点击[确定]进入恢复并耐心等待成功的提示！')){ 
	  isdo ++;
	  if(isdo==1){ 
		  location.href='index.php?action=kakithe&daction=restore&kithe='+kithe;
	  }else{ 
		  alert('操作执行中，请稍后...');
	  } 
  } 
} 

</script>
<?php 
function cpmulti($num, $perpage, $curpage, $mpurl){
	$multipage = '';
	$mpurl .= '&';
	if ($perpage < $num){
		$page = 10;
		$offset = 5;
		$pages = @(ceil($num / $perpage));
		if ($pages < $page)
		{
			$from = 1;
			$to = $pages;
		}else{
			$from = $curpage - $offset;
			$to = ($curpage + $page) - $offset - 1;
			if ($from < 1)
			{
				$to = ($curpage + 1) - $from;
				$from = 1;
				if ((($to - $from) < $page) && (($to - $from) < $pages))
				{
					$to = $page;
				}
			}else if ($pages < $to){
				$from = ($curpage - $pages) + $to;
				$to = $pages;
				if ((($to - $from) < $page) && (($to - $from) < $pages))
				{
					$from = ($pages - $page) + 1;
				}
			}
		}
		$multipage = (0 <= $curpage ? '<a href="' . $mpurl . 'page=1" class="p_redirect"><img src="images/prev_top.gif" border="0" align="absmiddle"></a>&nbsp;' : '');
		$multipage .= ($curpage <= 1 ? '<a href="' . $mpurl . 'page=1" class="p_redirect"><img src="images/prev.gif"  border="0" align="absmiddle"></a>&nbsp;' : '') . (1 < $curpage ? '<a href="' . $mpurl . 'page=' . ($curpage - 1) . '" class="p_redirect"><img src="images/prev.gif"  border="0" align="absmiddle"></a>&nbsp;' : '');
		$multipage .= ($curpage < $pages ? '<a href="' . $mpurl . 'page=' . ($curpage + 1) . '" class="p_redirect"><img src="images/next.gif" align="absmiddle" border="0" ></a>&nbsp;' : '') . ($to == $curpage ? '<a href="' . $mpurl . 'page=' . $pages . '" class="p_redirect"><img src="images/next.gif" align="absmiddle" border="0" ></a>&nbsp;' : '');
		$multipage .= (0 <= $curpage ? '<a href="' . $mpurl . 'page=' . $to . '" class="p_redirect"><img border="0" src="images/prev_end.gif" align="absmiddle"></a>' : '');
		$multipage = ($multipage ? '总计:' . $num . '期&nbsp;&nbsp;共' . $to . '页&nbsp;&nbsp;当前:<font color=ff0000>' . $curpage . '页</font>  &nbsp;&nbsp;' . $multipage . '&nbsp;' : '');
	}
	return $multipage;
}
?>