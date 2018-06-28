<?php 
if (!defined('PHPYOU')){
	exit('非法进入');
}

if (strpos($_SESSION['flag'], '08')){

}else{
	echo "<center>你没有该权限功能!</center>";
	exit();
}

if ($_GET['t1'] == '是'){
	$params = array(':id' => $_GET['newsid']);
	$sql = 'update ka_mem set stat=0 where id=:id';
	$stmt = $mydata2_db->prepare($sql);
	$stmt->execute($params);
	echo "<script>alert('修改用户[<".$_GET['name'].">]为启动！!');history.back();</script>"; 
	exit;
}

if ($_GET['t1'] == '否'){
	$params = array(':id' => $_GET['newsid']);
	$sql = 'update ka_mem set stat=1 where id=:id';
	$stmt = $mydata2_db->prepare($sql);
	$stmt->execute($params);
	echo "<script>alert('修改用户[<".$_GET['name'].">]为禁止!');history.back();</script>"; 
	exit;
}

if ($_GET['id'] != ''){
	$id = $_GET['id'];
}else{
	$id = 0;
}

if ($_GET['ids'] != ''){
	$ids = $_GET['ids'];
}else{
	$ids = 0;
}

if ($ids == 0){
	if ($_POST['ids'] != 0){
		$ids = $_POST['ids'];
	}else{
		$ids = 0;
	}
}

if ($_GET['ids1'] != ''){
	$ids1 = $_GET['ids1'];
}else{
	$ids1 = 0;
}

if ($ids1 == 0){
	if ($_POST['ids1'] != 0){
		$ids1 = $_POST['ids1'];
	}else{
		$ids1 = 0;
	}
}

if ($_GET['ids2'] != ''){
	$ids2 = $_GET['ids2'];
}else{
	$ids2 = 0;
}

if ($ids2 == 0){
	if ($_POST['ids2'] != 0){
		$ids2 = $_POST['ids2'];
	}else{
		$ids2 = 0;
	}
}
?>
<link rel="stylesheet" href="images/xp.css" type="text/css"> 
<script language="javascript" type="text/javascript" src="js_admin.js"></script> 
 

<SCRIPT language=JAVASCRIPT> 
if(self == top) {location = '/';}  
if(window.location.host!=top.location.host){top.location=window.location;}  
</SCRIPT> 

<style type="text/css"> 
<!-- 
.STYLE1 {color: #FFFFFF} 
--> 
</style> 
<table width="100%" border="0" cellspacing="0" cellpadding="5"> 
<tr class="tbtitle"> 
  <form action="index.php?action=kamem" method="post" name="form3" id="form3"> 
	<td width="35%"><font color="ffffff">股东 
	  <SELECT name=ids class=zaselect_ste id="ids" onchange=self.form3.submit()> 
		 <option value="0"<?php if ($ids == 0){?> selected="selected"<?php }?> >全部</option>
		 <?php 
		 $result = $mydata2_db->query('select * from ka_guan where lx=1  order by id desc');
		 while ($image = $result->fetch()){
		 ?>  
		 <option value="<?=$image['id'];?>"<?php if ($ids == $image['id']){?> selected="selected"<?php }?> ><?=$image['kauser'];?></option>
		 <?php }?> 				
		
	  </SELECT>
	  --总代
	  <SELECT name=ids1 class=zaselect_ste id="ids1" onchange=self.form3.submit()> 
		   
		   <option value="0"<?php if ($ids1 == 0){?> selected="selected"<?php }?> >全部</option>
		   <?php 
		    $result = $mydata2_db->query('select * from ka_guan where lx=2  order by id desc');
			while ($image = $result->fetch()){
		   ?> 
			<option value="<?=$image['id'];?>"<?php if ($ids1 == $image['id']){?> selected="selected"<?php }?> ><?=$image['kauser'];?></option>
		   <?php }?> 				
		
		  </SELECT>
		  --代理
		  <SELECT name=ids2 class=zaselect_ste id="ids2" onchange=self.form3.submit()> 
		   <option value="0"<?php if ($ids2 == 0){?> selected="selected"<?php }?> >全部</option>
		   <?php 
		    $result = $mydata2_db->query('select * from ka_guan where lx=3  order by id desc');
			while ($image = $result->fetch())
			{
		   ?>  
			<option value="<?=$image['id'];?>"<?php if ($ids2 == $image['id']){?> selected="selected"<?php }?> ><?=$image['kauser'];?></option>
			<?php }?> 				
		
		  </SELECT> 
	</font>
	</td> 
  </form> 
  <td width="26%"><table> 
	<form  action="index.php?action=kamem&amp;id=0" method="post" name="regstep1" id="regstep1"> 
	  <tr> 
		<td colspan="2" align="center" nowrap="nowrap"><p align="right" class="STYLE1">会员账号：</p></td> 
		<td align="center" colspan="6"><table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
			<tr> 
			  <td><input name="key" type="text" class="input1" id="key" size="10" /></td> 
			  <td width="80" align="center"><input type="submit" value="搜索" name="B1"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ></td> 
			  <td>&nbsp;</td> 
			</tr> 
		</table></td> 
	  </tr> 
	</form> 
  </table></td> 
  <td width="39%"><div align="right"> 
	<button type="button" onclick="javascript:location.href='index.php?action=kamem&amp;id=0'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ><img src="images/add.gif" width="16" height="16" align="absmiddle" /><font <?php if ($id == 0){?> color=ff0000<?php }else{?> color=000000<?php }?>>所有会员</font></button>&nbsp;
	<button type="button" onclick="javascript:location.href='index.php?action=kamem&amp;id=2'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ><img src="images/add.gif" width="16" height="16" align="absmiddle" /><font<?php if ($id == 2){?> color=ff0000<?php }else{?> color=000000<?php }?>>开启</font></button>&nbsp;
	<button type="button" onclick="javascript:location.href='index.php?action=kamem&amp;id=1'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ><img src="images/add.gif" width="16" height="16" align="absmiddle" /><font<?php if ($id == 1){?> color=ff0000<?php }else{?> color=000000<?php }?>>禁止</font></button> 
  </div></td> 
</tr> 
<tr > 
  <td height="5" colspan="3"></td> 
</tr> 
</table><table border="1" align="center" cellspacing="1" height="84" cellpadding="5" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%"> 
		   <form name="form1" method="post" action="index.php?action=kamem"> <tr>  
		  <td width="50" height="28" bordercolor="cccccc" bgcolor="#FDF4CA">  
			<div align="center">序号</div></td> 
		  <td bordercolor="cccccc" bgcolor="#FDF4CA">  
			<div align="center">账号</div>            </td> 
		  <td width="50" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">姓名</td> 
		  <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">信用额度/余额</td> 
		  <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">代理</td> 
		  <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">总代</td> 
		  <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">股东</td> 
		  <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">代%</td> 
		  <td align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">总%</td> 
		  <td width="30" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">股%</td> 
		  <td width="40" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">公司%</td> 
		  <td width="40" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">类型</td> 
		  <td width="30" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">状况</td> 
		  <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">注册时间</td> 
		  <td width="50" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">登录次数</td> 
		  <td nowrap bordercolor="cccccc" bgcolor="#FDF4CA">  
			<div align="center">操作</div>            </td> 
		</tr>
<?php 
$xc = $_POST['xc'];
$key = $_POST['key'];
if ($xc == ''){
	$xc = $_GET['xc'];
}

if ($key == ''){
	$xc = $_GET['key'];
}

$params = array();
$vvv = ' where 3=3 ';
$vvvv = '&id=' . $id . '';

if ($key != ''){
	$params[':kauser'] = '%' . $key . '%';
	$vvv .= ' and kauser LIKE :kauser  ';
	$vvvv .= '&key=' . $key . '';
}

if ($id == 1){
	$vvv .= ' and stat=1  ';
}

if ($id == 2){
	$vvv .= ' and stat=0  ';
}

if ($ids != 0){
	$params[':guanid'] = $ids;
	$vvv .= ' and guanid=:guanid  ';
	$vvvv .= '&ids=' . $ids . '';
}

if ($ids1 != 0){
	$params[':zongid'] = $ids1;
	$vvv .= ' and zongid=:zongid  ';
	$vvvv .= '&ids1=' . $ids1 . '';
}

if ($ids2 != 0){
	$params[':danid'] = $ids2;
	$vvv .= ' and danid=:danid  ';
	$vvvv .= '&ids2=' . $ids2 . '';
}

$result = $stmt = $mydata2_db->prepare('select count(*) from ka_mem  ' . $vvv . '  order by id desc');
$stmt->execute($params);
$num = $stmt->fetchColumn();
if (!$num){ echo "<tr align=center><td colspan=16>暂无数据</td></tr>"; }
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
$multipage = cpmulti($num, $perpage, $curpage, '?action=kamem' . $vvvv . '');
$jj = 0;
$result = $mydata2_db->prepare('select * from ka_mem  ' . $vvv . '  order by id desc limit ' . $start_limit . ', ' . $perpage);
$result->execute($params);
while ($image = $result->fetch()){
	$jj += 1;
?>
		<tr>  
		  <td height="25" bordercolor="cccccc">  
			<div align="center"><?=$jj;?></div></td> 
		  <td height="25" align="center" bordercolor="cccccc"><?=$image['kauser'];?></td> 
		  <td height="25" align="center" bordercolor="cccccc"><?=$image['xm'];?></td> 
		  <td height="25" align="center" bordercolor="cccccc"><?=$image['cs'];?>/<font color=ff0000><?=$image['ts'];?></font></td> 
		  <td align="center" bordercolor="cccccc"> 
	  		<button type="button" class=headtd4  onmouseover="this.className='headtd3';window.status='会员管理';return true;" onMouseOut="this.className='headtd4';window.status='会员管理';return true;"  onClick="javascript:location.href='index.php?action=kamem&ids2=<?=$image['danid'];?>'"><?=$image['dan'];?></button>  			  
		  </td> 
		  <td align="center" bordercolor="cccccc"> 
		  <button type="button" class=headtd4  onmouseover="this.className='headtd3';window.status='会员管理';return true;" onMouseOut="this.className='headtd4';window.status='会员管理';return true;"  onClick="javascript:location.href='index.php?action=kamem&ids1=<?=$image['zongid'];?>'"><?=$image['zong'];?></button>  			    
		  </td> 
		  <td height="25" align="center" bordercolor="cccccc"> 
		  <button type="button" class=headtd4  onmouseover="this.className='headtd3';window.status='会员管理';return true;" onMouseOut="this.className='headtd4';window.status='会员管理';return true;"  onClick="javascript:location.href='index.php?action=kamem&ids=<?=$image['guanid'];?>'"><?=$image['guan'];?></button>  			    
		  </td> 
		  <td align="center" bordercolor="cccccc"><?=$image['dan_zc'] * 10;?>%</td> 
		  <td height="25" align="center" bordercolor="cccccc"><?=$image['zong_zc'] * 10;?>%</td> 
		  <td height="25" align="center" bordercolor="cccccc"><?=$image['guan_zc'] * 10;?>%</td> 
		  <td align="center" bordercolor="cccccc"><?=$image['dagu_zc'] * 10;?>%</td> 
		  <td align="center" bordercolor="cccccc"><?=$image['abcd'];?>盘&nbsp;</td> 
		  <td height="25" align="center" bordercolor="cccccc"> 
		  <a href="index.php?action=kamem&newsid=<?=$image['id']?>&amp;t1=<? if($image['stat']==0){ ?>否<? }else{?>是<? }?>&amp;id=<?=$image['id']?>&amp;ids=<?=$ids?>&amp;page=<?=$curpage?>&amp;name=<?=$image['kauser']?>&amp;key=<?=$_POST['key']?>"><img src="images/<? if ($image['stat']==0){ ?>icon_21x21_selectboxon.gif<? }else{ ?>icon_21x21_selectboxoff.gif<? }?>" name="test_b<?=$image['id']?>" width="21" height="21" border="0" id="test_b<?=$image['id']?>"  value="<? if($image['stat']==0){ ?>True<? }else{?>False<? }?>" ></a>
		  </td> 
		  <td height="25" align="center" bordercolor="cccccc"><?=$image['adddate'];?></td> 
		  <td height="25" align="center" bordercolor="cccccc"><?=$image['look'];?></td> 
		  <td nowrap bordercolor="cccccc">  
			<div align="center"> 
		   <button type="button" onClick="javascript:location.href='index.php?action=mem_edit&id=<?=$image['id'];?>'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ><img src="images/icon_21x21_edit01.gif" align="absmiddle">修改</button> 
</div>            </td> 
		</tr>
		<?php }?>       
   <tr> 
		  <td height="25" colspan="16" bordercolor="cccccc"><table width="98%" border="0" align="center" cellpadding="1" cellspacing="0" bordercolordark="#FFFFFF" bordercolor="888888"> 
			<tr> 
			  <td height="26"><div align="left"> 
				  <input type="hidden" name="idtxt" /> 
				  <input name="id" type="hidden" id="id" value="<?=$image['id'];?>" /><?php if ($_POST['username'] != '')
{?>                     <input name="username" type="hidden" id="username" value="<?=$_POST['username'];?>" /> 
				  <input name="xc" type="hidden" id="xc" value="<?=$_POST['xc'];?>" /><?php }?>                   &nbsp;
				<button type="button" onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button> 
			  </div></td> 
			  <td height="26" ><div align="center"><?=$multipage;?>&nbsp;</div></td> 
			  <td height="26" width="60"><div align="center"> 
				  <select name="page" onchange="location.href='index.php?action=kamem&amp;id=<?=$id?><? if ($_POST['username']<>"") {?>&amp;username=<?=$username?>&amp;xc=<?=$xc?><? }?>&amp;page='+this.options[selectedIndex].value">
                      <? for($i =1; $i <= $pagesa; $i++) {?>
                      <option value="<?=$i?>" <? if ($curpage==$i){ ?>selected<? }?>>第<?=$i?> 页</option>
                      <? }?>
                  </select> 
			  </div></td> 
			</tr> 
		  </table></td> 
		  </tr>   
		  </form>
		  </table>
<?php 
function cpmulti($num, $perpage, $curpage, $mpurl){
	$multipage = '';
	$mpurl .= '&';
	if ($perpage < $num){
		$page = 10;
		$offset = 5;
		$pages = @(ceil($num / $perpage));
		if ($pages < $page){
			$from = 1;
			$to = $pages;
		}else{
			$from = $curpage - $offset;
			$to = ($curpage + $page) - $offset - 1;
			if ($from < 1){
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
		$multipage = ($multipage ? '总计:' . $num . '个&nbsp;&nbsp;共' . $to . '页&nbsp;&nbsp;当前:<font color=ff0000>' . $curpage . '页</font>  &nbsp;&nbsp;' . $multipage . '&nbsp;' : '');
	}
	return $multipage;
}
?>