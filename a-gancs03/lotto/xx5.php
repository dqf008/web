<?php 
if (!defined('PHPYOU')){
	exit('非法进入');
}

if (($_GET['kithe'] != '') || ($_POST['kithe'] != '')){
	if ($_GET['kithe'] != ''){
		$kithe = $_GET['kithe'];
	}else{
		$kithe = $_POST['kithe'];
	}
}
$username = $_GET['username'];
$txt8 = ($_POST['txt8'] == '' ? $_GET['txt8'] : $_POST['txt8']);
$txt9 = ($_POST['txt9'] == '' ? $_GET['txt9'] : $_POST['txt9']);
$class = ($_POST['class'] == '' ? $_GET['class'] : $_POST['class']);
$key = ($_POST['key'] == '' ? $_GET['key'] : $_POST['key']);
$class2 = ($_POST['class2'] == '' ? $_GET['class2'] : $_POST['class2']);
$username = ($_POST['username'] == '' ? $_GET['username'] : $_POST['username']);
$xc = ($_POST['xc'] == '' ? $_GET['xc'] : $_POST['xc']);
?>
<link rel="stylesheet" href="images/xp.css" type="text/css"> 
<SCRIPT language=JAVASCRIPT> 
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT> 
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script language="JavaScript" src="/js/calendar.js"></script> 
<style type="text/css"> 
<!-- 
.STYLE3 {color: #FF3300} 
.STYLE4 {color: #FFFFFF} 
--> 
</style> 
<body  > 
<noscript> 
<iframe scr=″*.htm″></iframe> 
</noscript> 

<div align="center"> 
<link rel="stylesheet" href="xp.css" type="text/css"> 


<table width="100%" border="0" cellspacing="0" cellpadding="5"> 
<tr class="tbtitle"> 
  <td width="26%"><strong><font color="#FFFFFF"><?php if (($username != '') && ($kithe != '')){?> [<?=$username;?>]会员注单[<?=$kithe;?>期]查询列表<?php }else{?> 注单查询表表<?php }?> </font></strong></td> 
  <td width="58%"><table border="0" align="center" cellspacing="0" cellpadding="1" bordercolor="888888" bordercolordark="#FFFFFF" width="100%"> 
	<tr> 
	  <td>&nbsp;
	  <span class="STYLE4">
	  当前报表-->>
	  <?php if ($kithe != ''){?>
	  查第<?=$kithe;?>期
	  <?php }else{?>
	  日期区间：<?=$txt8?> ----- <?=$txt9?> 
	  <? }?>
	  &nbsp;&nbsp;&nbsp;&nbsp;
	  投注品种：
	  <?php 
	  if ($class2 != ''){
	  	echo $class2;
	  }else{
	   echo "全部";
	  }
	  ?>
	  查询种类：
	  <?php 
		if ($class != ''){
			echo "(";
			if ($class == '1'){
				echo "会员账号";
			}
			
			if ($class == '2'){
				echo "下注单号";
			}
			
			if ($class == '3'){
				echo "下注盘类";
			}
			echo ":".$key.")";
		}else{
			echo"全部";
		}
	   ?>
	  </span> 
	  </td> 
	</tr> 
  </table></td> 
  <td width="16%"><div align="right"> 
	<button type="button" onClick="javascript:history.back();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:<%=z1color%>;'>返回上一页</span></button>&nbsp;
	<button type="button" onClick="javascript:window.print();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ><img src="images/asp.gif" width="16" height="16" align="absmiddle" />打印</button> 
  </div></td> 
</tr> 
<tr > 
  <td height="5" colspan="3"></td> 
</tr> 
</table> 
<table border="1" align="center" cellspacing="1" height="87" cellpadding="5" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%"> 

  <tr> 
	<td width="50" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">序号</td> 
	<TD width="60" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">会员</TD> 
	<TD width="50" align="center" bordercolor="cccccc" bgcolor="#FDF4CA">下单时间 </TD> 
	<TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">期数</TD> 
	<TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">下注金额</TD> 
	<TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">赔率</TD> 
	<TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">退佣%</TD> 
	<TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">类型1</TD> 
	<TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">类型2</TD> 
	<TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">球号</TD> 
  </tr>
<?php 
$z_re = 0;
$z_sum = 0;
$z_dagu = 0;
$z_guan = 0;
$z_zong = 0;
$z_dai = 0;
$re = 0;

$params = array();
$vvv = 'where 1=1';
if ($kithe != ''){
	$params[':kithe'] = $kithe;
	$vvv .= ' and kithe=:kithe ';
	$vvvv .= '&kithe=' . $kithe . '';
}else if (($txt8 != '') && $txt9){
	$stime = $txt8 . ' 00:00:00';
	$etime = $txt9 . ' 23:59:59';
	$params[':stime'] = $stime;
	$params[':etime'] = $etime;
	$vvv .= ' and adddate>=:stime and adddate<=:etime ';
	$vvvv .= '&txt8=' . $txt8 . '';
	$vvvv .= '&txt9=' . $txt9 . '';
}else{
	$params[':kithe'] = $kithe;
	$vvv .= ' and Kithe=:kithe ';
	$vvvv .= '&kithe=' . $kithe . '';
}

if ($username != ''){
	$params[':username'] = $username;
	$vvv .= ' and username=:username ';
	$vvvv .= '&username=' . $username . '';
}

if ($class != ''){
	$vvvv .= '&class=' . $class . '';
	$vvvv .= '&key=' . $key . '';
	if ($key != ''){
		if ($class == '1'){
			$params[':username'] = $key;
			$vvv .= ' and username=:username ';
		}
		
		if ($class == '2'){
			$params[':num'] = $key;
			$vvv .= ' and num=:num ';
		}
		
		if ($class == '3'){
			$params[':abcd'] = $key;
			$vvv .= ' and abcd=:abcd ';
		}
	}
}

if ($class2 != ''){
	$params[':class2'] = $class2;
	$vvv .= ' and class2=:class2 ';
	$vvvv .= '&class2=' . $class2 . '';
}
$result = $mydata2_db->prepare('select count(*) from ka_tan  ' . $vvv . '  order by id desc');
$result->execute($params);
$num = $result->fetchColumn();
if (!$num){ echo"<tr align=center><td colspan=16>暂无数据</td></tr>"; }
$curpage = intval($page);
$perpage = 50;
$pagesa = @(ceil($num / $perpage));

if ($curpage){
	$start_limit = ($curpage - 1) * $perpage;
}else{
	$start_limit = 0;
	$curpage = 1;
}
$start_limit = intval($start_limit);
$perpage = intval($perpage);
$multipage = cpmulti($num, $perpage, $curpage, '?action=xx5' . $vvvv . '');
$result = $mydata2_db->prepare('select id,kithe,username,adddate,sum_m,rate,user_ds,class1,class2,class3,abcd  from   ka_tan ' . $vvv . '  order by sum_m desc, id desc limit ' . $start_limit . ', ' . $perpage);
$result->execute($params);
while ($rs = $result->fetch()){
$ii++;
$z_re++;
$z_sum += $rs['sum_m'];
$params = array(':kauser' => $rs['username']);
$result2 = $mydata2_db->prepare('select * from ka_mem where  kauser=:kauser order by id');
$result2->execute($params);
$row11 = $result2->fetch();
if ($row11 != ''){
	$xm = '<font color=ff6600> (' . $row11['xm'] . ')</font>';
}
?>   <tr >
      <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=$ii?></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['username']?>
          <?=$xm?>
        .
        <?=$rs['abcd']?></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['adddate']?></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><font color=ff6600>
        <?=$rs['kithe']?>
        期</font></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['sum_m']?></td>
      <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['rate']?></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['user_ds']?></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['class1']?></td>
      <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['class2']?></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['class3']?></td>
    </tr>
<?php }?>    
	<tr>
      <td height="25" colspan="11" bordercolor="cccccc"><table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" bordercolordark="#FFFFFF" bordercolor="888888">
        <tr>
          <td height="26"><div align="left">
            <input type="hidden" name="idtxt" />
            <input name="id" type="hidden" id="id" value="<?=$image['id']?>" />
            <? if ($_POST['username']<>"") {?>
            <input name="username" type="hidden" id="username" value="<?=$_POST['username']?>" />
            <input name="xc" type="hidden" id="xc" value="<?=$_POST['xc']?>" />
            <? }?>
            
            <button type="button" onClick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button>
          </div></td>
          <td height="26" ><div align="center"> <?=$multipage;?>&nbsp;</div></td>
          <td height="26" width="60"><div align="center">
            <select name="page" onChange="location.href='index.php?action=xx5<?=$vvvv?>&page='+this.options[selectedIndex].value">
              <? for($i =1; $i <= $pagesa; $i++) {?>
              <option value="<?=$i?>" <? if ($curpage==$i){ ?>selected<? }?>>第<?=$i?>页</option>
              <? }?>
            </select>
          </div></td>
        </tr>
      </table></td>
    </tr>
</table> 
<br> 
<table border="1" align="center" cellspacing="0" cellpadding="2" bordercolor="f1f1f1" bordercolordark="#FFFFFF" width="99%"> 
<tr> 
  <form name=form55 action="index.php?action=xx5" method=post> 
	<td><table width="100" border="0" cellspacing="1" cellpadding="1"> 
	  <tr> 
		<td nowrap>查询种类：</td> 
		<td nowrap><select name="class" id="class"> 
		  <option  value="" selected>-全部-</option> 
		  <option value="1">会员账号</option> 
		  <option value="2">下注单号</option> 
		  <option value="3">下注盘类</option> 
		</select> 
			  <input name="key"  class="input1" type="text" id="key" size="8"></td> 
		<td nowrap>投注品种：</td> 
		<td nowrap><select name="class2" id="class2"> 
		 <option value="" selected="selected">-----全部-----</option> 
		   <option value="特A">特码：特A</option> 
		  <option value="特B">特码：特B</option> 
		  <option value="正A">正码：正A</option> 
		  <option value="正B">正码：正B</option> 
		  <option value="正1特">正特：正1特</option> 
		  <option value="正2特">正特：正2特</option> 
		  <option value="正3特">正特：正3特</option> 
		  <option value="正4特" >正特：正4特</option> 
		  <option value="正5特" >正特：正5特</option> 
		  <option value="正6特" >正特：正6特</option> 
					 <option value="过关" >过关</option> 
		  <option value="三全中" >连码：三全中</option> 
		  <option value="三中二" >连码：三中二</option> 
		  <option value="二全中" >连码：二全中</option> 
		  <option value="二中特"  >连码：二中特</option> 
		  <option value="特串" >连码：特串</option> 
		  <option value="特肖" >生肖：特肖</option> 
		  <option value="四肖"  >生肖：四肖</option> 
		  <option value="五肖" >生肖：五肖</option> 
		  <option value="六肖"  >生肖：六肖</option> 
		  <option value="二肖" >生肖：二肖</option> 
		  <option value="三肖" >生肖：三肖</option> 
		  <option value="一肖" >生肖：一肖</option> 
		  <option value="半波" >半波</option> 
		  <option value="半半波" >半半波</option> 
		  <option value="头数">头数</option> 
		  <option value="尾数">尾数</option> 
		  <option value="正特尾数">正特尾数</option> 
		  <option value="正肖" >正肖</option> 
		  <option value="七色波" >七色波</option> 
		  <option value="五行">五行</option> 
		</select> 
			  <input name="ac2" type="hidden" id="ac" value="A" /></td> 
		<td nowrap>日期区间：</td> 
		<td><table cellspacing="0" cellpadding="0" border="0"> 
		  <tbody> 
			<tr>
			<td><input name="txt8" type="text" class="input1" value="<?=date("Y-m-d")?>" onClick="new Calendar(2008,2020).show(this);" size="12"></td>
			<td align="middle" width="20">~</td>
			<td><input name="txt9" type="text" class="input1" value="<?=date("Y-m-d")?>" onClick="new Calendar(2008,2020).show(this);" size="12"></td>
			<td align="right" width="200"></td>
		  </tr>
		  </tbody> 
		</table></td> 
		<td nowrap>选择期数：</td> 
		<td>
		<select name="kithe" id="kithe"> 
		  <option value="" selected="selected">按时间来查</option>
		  <?php 
		  $result = $mydata2_db->query('select * from ka_kithe order by nn desc');
		  while ($image = $result->fetch()){
		  	 echo "<OPTION value=".$image['nn'].">第".$image['nn']."期</OPTION>";
		  }
		  ?> 
		</select>
		</td> 
		<td><INPUT  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type=submit value=查询 name=SUBMIT></td> 
	  </tr> 
	</table></td> 
  </FORM> 
</tr> 
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