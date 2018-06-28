<?php 
if (!defined('PHPYOU_VER')){
	exit('非法进入');
}

if ($_GET['id'] != ''){
	$id = $_GET['id'];
}else{
	$id = 0;
}
?>
<html> 
<head> 
<link href="imgs/main_n1.css" rel="stylesheet" type="text/css"> 
<SCRIPT language=JAVASCRIPT> 
if(self == top) {location = '/';}  
if(window.location.host!=top.location.host){top.location=window.location;}  
</SCRIPT> 
<style type="text/css"> 
<!-- 
body { 
  margin-left: 10px;
  margin-top: 10px;
} 
.STYLE1 {color: #FFFFFF} 
#right_1 { 
  width: 780px;} 
  #index02_title { 
  width: 780px;
  height: 30px;
  border-bottom: 1px solid #000;
  color: #fff;
  background: #142F06;
} 
.bg { 
  background: url(/images/right_1.jpg) no-repeat left;
  width: 119px;
  height: 30px;
  line-height: 30px;
  font-weight: bold;
  float: left;
  padding: 0 0 0 24px;
} 
--> 
</style> 
</head> 



<body > 
<div id="right_1"> 
<!--gonggao--> 
<!--gonggao end of--> 
<!--shuaxin--> 

<!--shuaxin end of--> 
<!--shuzi--> 
<div id="shuzi"> 


</div> 
<!--shuzi end of--> 
</div> 
<!--right_2--> 
<form name="form1" method="post" action="index.php?action=kakithe"> 
<table border="0" cellpadding="0" cellspacing="1"  class="t_list" width="780"> 
	 
	
	  <tr> 
		  <td class="t_list_caption F_bold" colspan="10">香港㈥合彩</td> 
		  <td class="t_list_caption F_bold" >正码</td> 
		  <td class="t_list_caption F_bold" colspan="4">特码</td> 
		  <td class="t_list_caption F_bold">特合</td> 
		  <td class="t_list_caption F_bold" colspan="3">总数</td> 
	  </tr> 
	  <tr> 
		  <td class="t_list_caption" width="50">期号</td> 
		  <td class="t_list_caption" width="75">开奖日期</td> 
		  <td class="t_list_caption" colspan="8" width="206">开奖号码</td> 
		   <td class="t_list_caption">正码生肖</td> 
		  <td class="t_list_caption" width="35"> 
			  生肖 
		  </td> 
		  <td class="t_list_caption" width="35">单双</td> 
		  <td class="t_list_caption" width="35">大小</td> 
		  <td class="t_list_caption" width="35">尾数</td> 
		  <td class="t_list_caption" width="35">单双</td> 
		  <td class="t_list_caption" width="40">总和</td> 
		  <td class="t_list_caption" width="35">单双</td> 
		  <td class="t_list_caption" width="35">大小</td> 
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
$vvvv = '&id=' . $id . '';
if ($key != '')
{
$vvvv .= '&key=' . $key . '';
}
$sqlCount = 'select count(*) from ka_kithe where na<>0';
$sqlQuery = 'select * from ka_kithe where na<>0';
$params = array();
if ($key != '')
{
$params[':nn'] = '%' . $key . '%';
$sqlCount .= ' and nn LIKE :nn';
$sqlQuery .= ' and nn LIKE :nn';
}
if ($id == 1)
{
$params[':lx'] = 0;
$sqlCount .= ' and lx=:lx';
$sqlQuery .= ' and lx=:lx';
}
else if ($id == 2)
{
$params[':lx'] = 1;
$sqlCount .= ' and lx=:lx';
$sqlQuery .= ' and lx=:lx';
}
$sqlCount .= ' order by id desc';
$sqlQuery .= ' order by id desc';
$stmt = $mydata2_db->prepare($sqlCount);
$stmt->execute($params);
$num = $stmt->fetchColumn();
if (!$num){ echo"<tr align=center><td colspan=14>暂无数据</td></tr>"; }
$curpage = intval($page);
$perpage = 10;
$pagesa = @(ceil($num / $perpage));
if ($curpage)
{
$start_limit = ($curpage - 1) * $perpage;
}
else
{
$start_limit = 0;
$curpage = 1;
}
$multipage = cpmulti($num, $perpage, $curpage, '?action=kakithe' . $vvvv . '');
$start_limit = intval($start_limit);
$perpage = intval($perpage);
$sqlQuery .= ' limit ' . $start_limit . ', ' . $perpage;
$stmt = $mydata2_db->prepare($sqlQuery);
$stmt->execute($params);
$nn = 1;
while ($image = $stmt->fetch())
{?>         <tr class="Ball_tr_H" onMouseOut="this.style.backgroundColor=''" onMouseOver="this.style.backgroundColor='#fac906'"> 
		  <td><b><?=$image['nn'];?></b></td> 
		  <td><?=date("y-m-d",strtotime($image['nd']))?></td> 
		  <td class="No_05" width="27"><img src="images/num<?=$image['n1'];?>.gif" /> 
		  </td> 
		  <td class="No_32" width="27"><img src="images/num<?=$image['n2'];?>.gif" /> 
		  </td> 
		  <td class="No_48" width="27"><img src="images/num<?=$image['n3'];?>.gif" /> 
		  </td> 
		  <td class="No_20" width="27"><img src="images/num<?=$image['n4'];?>.gif" /> 
		  </td> 
		  <td class="No_15" width="27"><img src="images/num<?=$image['n5'];?>.gif" /> 
		  </td> 
		  <td class="No_06" width="27"><img src="images/num<?=$image['n6'];?>.gif" /> 
		  </td> 
		  <td width="17"> 
			  <b>＋</b></td> 
		  <td class="No_22" width="27"><img src="images/num<?=$image['na'];?>.gif" /> 
		  </td> 
		   <td><?=$image['x1'];?>&nbsp;<?=$image['x2'];?>&nbsp;<?=$image['x3'];?>&nbsp;<?=$image['x4'];?>&nbsp;<?=$image['x5'];?>&nbsp;<?=$image['x6'];?>            </td> 
		  <td><?=$image['sx'];?>             
		  </td> 
		  <td>
               
                 <? if ($image['na']%2==1){echo "<span >单</span>";}else{echo "<span class='Font_R'>双</span>";}?>
               
            </td>
            <td>
              <? if ($image['na']>=25){echo "<span >大</span>";}else{echo "<span class='Font_R'>小</span>";}?>
               
            </td>
            <td>
             <? if (substr($image['na'],-1,1)>=5){echo "<span >大</span>";}else{echo "<span class='Font_R'>小</span>";}?>
               
            </td>
            <td>
             <? if (($image['na']%10+intval($image['na'])/10)%2==1){echo "<span >单</span>";}else{echo "<span class='Font_R'>双</span>";}?>
              
            </td>
            <td>
               <?  $zh=($image['na']+$image['n1']+$image['n2']+$image['n3']+$image['n4']+$image['n5']+$image['n6']); echo $zh; ?>
            </td>
            <td>
                  <? if ($zh%2==1){echo "<span >单</span>";}else{echo "<span class='Font_R'>双</span>";}?>
              
            </td>
            <td>

                    <? if ($zh>=175){echo "<span >大</span>";}else{echo "<span class='Font_R'>小</span>";}?>
            </td>
		   
	  </tr>
<?php $nn++;
}?>       <tr> 
	  <td height="25" colspan="19" class="t_list_bottom" bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" > 
		  <tr> 
			<td width="180" height="26" nowrap="nowrap"><div align="left"> 
				<input type="hidden" name="idtxt" /> 
				<input name="id" type="hidden" id="id" value="<?=$id?>" />
<?php if ($_POST['username'] != ''){?>                   
				<input name="username" type="hidden" id="username" value="<?=$_POST['username'];?>" /> 
				<input name="xc" type="hidden" id="xc" value="<?=$_POST['xc'];?>" /><?php }?>                   
				<button onClick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button> 
			</div></td> 
			<td height="26"><div align="center"><?=$multipage;?>&nbsp;</div></td> 
			<td height="26" width="60"><div align="center"> 
				<select name="page" onChange="location.href='index.php?action=kakithe&amp;id=<?=$id?><? if ($_POST['username']<>"") {?>&amp;username=<?=$username?>&amp;xc=<?=$xc?><? }?>&amp;page='+this.options[selectedIndex].value">
                    <? for($i =1; $i <= $pagesa; $i++) {?>
                    <option value="<?=$i?>" <? if ($curpage==$i){ ?>selected<? }?>>第
                      <?=$i?>
                      页</option>
                    <? }?>
                  </select>
			</div></td> 
		  </tr> 
		</table>        </td> 
	</tr>   
</table> 

</form> 


</body> 
</html>
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
				if ((($to - $from) < $page) && (($to - $from) < $pages)){
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
}?>