<?php 
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../include/newpage.php';
include_once '../class/user.php';
include_once '../common/function.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);

$cn_begin=$_GET["cn_begin"];
$s_begin_h=$_GET["s_begin_h"];
$s_begin_i=$_GET["s_begin_i"];
$cn_begin=$cn_begin==""?date("Y-m-d",time()):$cn_begin;
$s_begin_h=$s_begin_h==""?"00":$s_begin_h;
$s_begin_i=$s_begin_i==""?"00":$s_begin_i;

$cn_end=$_GET["cn_end"];
$s_end_h=$_GET["s_end_h"];
$s_end_i=$_GET["s_end_i"];
$cn_end=$cn_end==""?date("Y-m-d",time()):$cn_end;
$s_end_h=$s_end_h==""?"23":$s_end_h;
$s_end_i=$s_end_i==""?"59":$s_end_i;

$begin_time=$cn_begin." ".$s_begin_h.":".$s_begin_i.":00";
$end_time=$cn_end." ".$s_end_h.":".$s_end_i.":59";

$atype=$_GET["atype"];
$atype=$atype==""?"1":$atype;
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
  <title>体育赛事</title> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
  <link type="text/css" rel="stylesheet" href="images/member.css"/> 
  <script type="text/javascript" src="images/member.js"></script> 
  <!--[if IE 6]><script type="text/javascript" src="images/DD_belatedPNG.js"></script><![endif]--> 
  <script type="text/javascript" src="../js/calendar.js"></script> 
</head> 
<body> 
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;">
	<?php 
	include_once("mainmenu.php");
	?>
	<tr>
		<td colspan="2" align="center" valign="middle">
			<?php 
			include_once("recordmenu.php");
			?>
			<div class="content">			  
			<table width="98%" border="0" cellspacing="0" cellpadding="5"> 
				  <form id="form1" name="form1" action="?query=true" method="get"> 
				  <tr> 
				 	 <td height="25" colspan="8" align="center" bgcolor="#D6D6D6"> 
					  开始日期
						<input name="cn_begin" type="text" id="cn_begin" size="10" readonly="readonly" value="<?=$cn_begin?>" onclick="new Calendar(2008,2020).show(this);"/>
						<select name="s_begin_h" id="s_begin_h">
							<?php
							for($bh_i=0;$bh_i<24;$bh_i++){
								$b_h_value=$bh_i<10?"0".$bh_i:$bh_i;
							?>
							<option value="<?=$b_h_value?>" <?=$s_begin_h==$b_h_value?"selected":""?>><?=$b_h_value?></option>
							<?php } ?>
						</select>
						时
						<select name="s_begin_i" id="s_begin_i">
							<?php
							for($bh_j=0;$bh_j<60;$bh_j++){
								$b_i_value=$bh_j<10?"0".$bh_j:$bh_j;
							?>
							<option value="<?=$b_i_value?>" <?=$s_begin_i==$b_i_value?"selected":""?>><?=$b_i_value?></option>
							<?php } ?>
						</select>
						分
						&nbsp;&nbsp;结束日期
						<input name="cn_end" type="text" id="cn_end" size="10" readonly="readonly" value="<?=$cn_end?>" onclick="new Calendar(2008,2020).show(this);"/>
						<select name="s_end_h" id="s_end_h">
							<?php
							for($eh_i=0;$eh_i<24;$eh_i++){
								$e_h_value=$eh_i<10?"0".$eh_i:$eh_i;
							?>
							<option value="<?=$e_h_value?>" <?=$s_end_h==$e_h_value?"selected":""?>><?=$e_h_value?></option>
							<?php } ?>
						</select>
						时
						<select name="s_end_i" id="s_end_i">
							<?php
							for($eh_j=0;$eh_j<60;$eh_j++){
								$e_i_value=$eh_j<10?"0".$eh_j:$eh_j;
							?>
							<option value="<?=$e_i_value?>" <?=$s_end_i==$e_i_value?"selected":""?>><?=$e_i_value?></option>
							<?php } ?>
						</select>
						分
						&nbsp;&nbsp;<select name="atype" id="atype">
							<option value="1" <?=$atype==1?"selected":""?>>体育单式</option>
							<option value="2" <?=$atype==2?"selected":""?>>体育串关</option>
						</select>
						&nbsp;&nbsp;<input type="submit" name="query" class="submit_73" value="查询" />
					</td>
				</tr>
				</form> 
			    <tr> 
				  <th align="center">投注时间(美东/北京)</th> 
				  <th align="center">注单号/模式</th> 
				  <th align="center">投注详细信息</th> 
				  <th align="center">下注金额</th> 
				  <th align="center">可赢</th> 
				  <th align="center">派彩</th> 
				  <th align="center">反水</th> 
				  <th align="center">状态</th> 
			    </tr>
				<?php 
				if ($atype == 1){
				$params = array(':uid' => $uid, ':begin_time' => $begin_time, ':end_time' => $end_time);
				$sql = 'select bid from k_bet where status in (0,1,2,3,4,5,6,7,8) and uid=:uid and bet_time>=:begin_time and bet_time<=:end_time order by bid desc';
				$stmt = $mydata1_db->prepare($sql);
				$stmt->execute($params);
				$sum = $stmt->rowCount();
				$thisPage = 1;
				if (@($_GET['page']))
				{
					$thisPage = $_GET['page'];
				}
				$page = new newPage();
				$perpage = 20;
				$thisPage = $page->check_Page($thisPage, $sum, $perpage);
				$id = '';
				$i = 1;
				$start = (($thisPage - 1) * $perpage) + 1;
				$end = $thisPage * $perpage;
				while ($row = $stmt->fetch())
				{
					if (($start <= $i) && ($i <= $end))
					{
						$id .= intval($row['bid']) . ',';
					}
					if ($end < $i)
					{
						break;
					}
					$i++;
				}
				if ($id)
				{
					$id = rtrim($id, ',');
					$sql	=	"select * from k_bet where bid in($id) order by bid desc";
					$query = $mydata1_db->query($sql);
					$i = 1;
					$sum_tz = 0;
					$sum_pc = 0;
					$sum_fs = 0;
					while ($rows = $query->fetch())
					{
						$sum_tz += $rows['bet_money'];
						$sum_pc += $rows['win'];
						$sum_fs += $rows['fs'];
			   ?> 					  
			   <tr bgcolor="<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>" align="center" onMouseOver="this.style.backgroundColor='#FFFFCC'" onMouseOut="this.style.backgroundColor='<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>'" >
						<td align="center"><?=date("Y-m-d H:i:s",strtotime($rows["bet_time"])-1*12*3600)?><br><?=date("Y-m-d H:i:s",strtotime($rows["bet_time"]))?></td>
						<td align="center"><?=$rows["number"]?>
							<br><?=$rows["ball_sort"]?>
							<?php
							$rows["bet_info"] = preg_replace('[ - \((.*)\)]', '',$rows["bet_info"]);
							$m=explode('-',$rows["bet_info"]);
							if($rows["ball_sort"]=="冠军" || $rows["ball_sort"]=="金融");
							else echo $tz_type=$m[0];
							if($m[1] == '大 / 小'){
								echo ' - '.$m[1];
							}
							if(count($m)>3){
								$m[2]=preg_replace('[\[(.*)\]]','',$m[2].$m[3]);
								unset($m[3]);
							}
							//如果是波胆
							if(mb_strpos($m[0],"胆")){
								$bodan_score=explode("@",$m[1],2);
								$score=$bodan_score[0];
								$m[1]="波胆@".$bodan_score[1];
							}
							?></td>
						<td align="center"><span style="color:#005481"><b><?=$rows["match_name"]?></b></span>
							<?
							//正则匹配
							$m_count=count($m);
							preg_match('[\((.*)\)]',$m[$m_count-1],$matches);
							if(strpos($rows["master_guest"],'VS.')){
								$team=explode('VS.',$rows["master_guest"]);
							}else{
								$team=explode('VS',$rows["master_guest"]);
							}
							
							if($rows["match_type"]==2){
								echo $rows['match_time'];
								if($rows['match_nowscore']=="" && strpos($rows["ball_sort"],"滚球")==false)
									echo '(0:0)';
								else if(strtolower($rows["match_showtype"])=="h" && strpos($rows["ball_sort"],"滚球")==false)
									echo "(".$rows['match_nowscore'].")";
								else if(strpos($rows["ball_sort"],"滚球")==false)
									echo "(".strrevScore($rows['match_nowscore']).")";
							}
							?>
							<br />
							<? if(mb_strpos($m[1],"让")>0) { //让球?>
							<? if(strtolower($rows["match_showtype"])=="c") { //客让?>
							<?=$team[1]?>
							<?=str_replace(array("主让","客让"),array("",""),$m[1])?>
							<?=$team[0]?>(主)
							<? }else{ //主让?>
							<?=$team[0]?>
							<?=str_replace(array("主让","客让"),array("",""),$m[1])?>
							<?=$team[1]?>
							<? }?>
							<?
							$m[1]="";
							}else{ ?>
							<?=$team[0]?>
							<? if(isset($score)) { ?>
							<?=$score?>
							<? }else{?>
							<? if($team[1]!=""){ ?>VS.<? } } ?><font style="color:#890209"><?=$team[1]?></font>
							<? } ?>
							<br />
							<?
							//半全场替换显示
							$arraynew=array($team[0],$team[1],"和局"," / ","局");
							$arrayold=array("主","客","和","/","局局");
							
							if($rows["ball_sort"]=="冠军" || $rows["ball_sort"]=="金融"){
								$ss=explode("@",$rows["bet_info"]);
								echo "<font color=\"red\">".$ss[0]."</font> @ <font color=\"red\">".$ss[1]."</font>";
							}else{

								$ss=str_replace($arrayold,$arraynew,preg_replace('[\((.*)\)]', '',$m[$m_count-1]));
								$ss=explode("@",$ss);
								if($ss[0]=="独赢") echo $m[1]."&nbsp;";
								elseif(strpos($ss[0],"独赢")) echo $m[1]."-";

								if(strpos($rows["bet_info"],"大小") || strpos($rows["bet_info"],"大 / 小")){
									echo str_replace('U','小',str_replace('O','大',$ss[0]));
									
								}else{
									echo str_replace(" ",'',$ss[0]);	
								} 

								if(($rows["ball_sort"] == "足球滚球" || $rows["ball_sort"] == "足球上半场滚球")){
								
									if($rows['match_nowscore']=="");
									else if(strtolower($rows["match_showtype"])=="h" || (!strrpos($tz_type,"球"))) echo "(".$rows['match_nowscore'].")";
									else echo "(".strrevScore($rows['match_nowscore']).")";
								}
								echo " @ <font color=\"red\">".$ss[1]."</font>";
							}
							?>
							<? 
							if(($rows["status"]!=0) && ($rows["status"]!=3) && ($rows["status"]!=7) && ($rows["status"]!=6))
							if((strtolower($rows["match_showtype"])=="c") && (strpos('&match_ao,match_ho,match_bho,match_bao&',$rows["point_column"])>0)){
							?>
							[<?=$rows["TG_Inball"]?>:<?=$rows["MB_Inball"]?>]	
							<?php
							}elseif($rows["ball_sort"] == "冠军" || $rows["ball_sort"] == "金融"){	
								$sql="select x_result from t_guanjun where match_id=".$rows["match_id"];
								$query=$db->query($sql);
								if($rs=mysql_fetch_array($query)){
									$rs['x_result']=str_replace("<br>","&nbsp;",$rs['x_result']);
									echo '['.$rs['x_result'].']';
								}
							}else{
							?>
							[<?=$rows["MB_Inball"]?>:<?=$rows["TG_Inball"]?>]
							<? }?>	
							<? if($rows["lose_ok"]==0 && ($rows["ball_sort"] == "足球滚球" || $rows["ball_sort"] == "篮球滚球" || $rows["ball_sort"] == "足球上半场滚球")){ ?>
							[确认中]
							<? }else if($rows["status"]==0 && ($rows["ball_sort"] == "足球滚球" || $rows["ball_sort"] == "篮球滚球" || $rows["ball_sort"] == "足球上半场滚球")){?>
							[已确认]
							<? } ?></td>
						<td align="center"><?=sprintf("%.2f",$rows["bet_money"])?></td>
						<td align="center"><?=sprintf("%.2f",$rows["bet_win"])?></td>
						<td align="center"><?=sprintf("%.2f",$rows["win"])?></td>
						<td align="center"><?=sprintf("%.2f",$rows["fs"])?></td>
						<td align="center"><?php
							if($rows["status"]==0){
								echo '未结算';
							}elseif($rows["status"]==1){
								echo '<span style="color:#FF0000;">赢</span>';
							}elseif($rows["status"]==2){
								echo '<span style="color:#00CC00;">输</span>';
							}elseif($rows["status"]==8){
								echo '和局';
							}elseif($rows["status"]==3){
								echo '非正常投注';
							}elseif($rows["status"]==4){
								echo '<span style="color:#FF0000;">赢一半</span>';
							}elseif($rows["status"]==5){
								echo '<span style="color:#00CC00;">输一半</span>';
							}elseif($rows["status"]==6){
								echo '进球无效';
							}elseif($rows["status"]==7){
								echo '红卡取消';
							}
							?></td>
					</tr>
					<?php
								$i++;
							}
						  }
						}else{
							$params = array(':uid' => $uid, ':begin_time' => $begin_time, ':end_time' => $end_time);
							$sql = 'select gid from k_bet_cg_group where status in (0,1,2,3,4) and uid=:uid and bet_time>=:begin_time and bet_time<=:end_time order by gid desc';
							$stmt = $mydata1_db->prepare($sql);
							$stmt->execute($params);
							$sum = $stmt->rowCount();
							$thisPage = 1;
							if (@($_GET['page']))
							{
								$thisPage = $_GET['page'];
							}
							$page = new newPage();
							$perpage = 20;
							$thisPage = $page->check_Page($thisPage, $sum, $perpage);
							$id = '';
							$i = 1;
							$start = (($thisPage - 1) * $perpage) + 1;
							$end = $thisPage * $perpage;
							while ($row = $stmt->fetch())
							{
								if (($start <= $i) && ($i <= $end))
								{
									$id .= intval($row['gid']) . ',';
								}
								if ($end < $i)
								{
									break;
								}
								$i++;
							}
							if ($id)
							{
								$id = rtrim($id, ',');
								$sql	=	"select * from k_bet_cg_group where gid in($id) order by gid desc";
								$query = $mydata1_db->query($sql);
								$arr_b_cg = array();
								while ($rows = $query->fetch())
								{
									$arr_b_cg[$rows['gid']]['bet_time'] = $rows['bet_time'];
									$arr_b_cg[$rows['gid']]['cg_count'] = $rows['cg_count'];
									$arr_b_cg[$rows['gid']]['bet_money'] = $rows['bet_money'];
									$arr_b_cg[$rows['gid']]['bet_win'] = $rows['bet_win'];
									$arr_b_cg[$rows['gid']]['win'] = $rows['win'];
									$arr_b_cg[$rows['gid']]['fs'] = $rows['fs'];
									$arr_b_cg[$rows['gid']]['status'] = $rows['status'];
									$gid .= intval($rows['gid']) . ',';
								}
								$gid = rtrim($gid, ',');
								if ($gid != '')
								{
									$arr_cg = array();
									$sql	=	"select gid,bid,bet_info,match_name,master_guest,bet_time,MB_Inball,TG_Inball,status from k_bet_cg where gid in ($gid) order by bid desc";
									$query = $mydata1_db->query($sql);
									while ($rows_cg = $query->fetch())
									{
										$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['bet_info'] = $rows_cg['bet_info'];
										$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['match_name'] = $rows_cg['match_name'];
										$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['master_guest'] = $rows_cg['master_guest'];
										$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['bet_time'] = $rows_cg['bet_time'];
										$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['MB_Inball'] = $rows_cg['MB_Inball'];
										$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['TG_Inball'] = $rows_cg['TG_Inball'];
										$arr_cg[$rows_cg['gid']][$rows_cg['bid']]['status'] = $rows_cg['status'];
									}
								}
							}
							}
							if ($arr_b_cg)
							{
							$sum_tz = 0;
							$sum_pc = 0;
							$sum_fs = 0;
							foreach ($arr_b_cg as $gid => $rows)
							{
								$i = 1;
								$sum_tz += $rows['bet_money'];
								$sum_pc += $rows['win'];
								$sum_fs += $rows['fs'];
						?> 					  
						<tr bgcolor="<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>" align="center" onMouseOver="this.style.backgroundColor='#FFFFCC'" onMouseOut="this.style.backgroundColor='<?=$i%2==0?'#FFFFFF':'#F5F5F5'?>'" >
						<td align="center"><?=date("Y-m-d H:i:s",strtotime($rows["bet_time"]))?><br><?=date("Y-m-d H:i:s",strtotime($rows["bet_time"])+12*3600)?></td>
						<td align="center"><?=$gid?><br/><?=$rows["cg_count"]?>串1</td>
						<td align="center"><?php
							$x		=	0;
							$nums	=	count($arr_cg[$gid]);
							$ok_num	=	0;
							foreach($arr_cg[$gid] as $k=>$myrows){
								//统计已结算单式
								if($myrows["status"]!=0 && $myrows["status"]!=3){
									$ok_num++;
								}
								
								$m=explode('-',$myrows["bet_info"]);
								echo $m[0];
								if(mb_strpos($myrows["bet_info"]," - ")){
									//篮球上半之内的,这里换成正则表达替换
									$m[2]=$m[2].preg_replace('[\[(.*)\]]', '',$m[3]);
								}
								$m[2]=@preg_replace('[\[(.*)\]]','',$m[2].$m[3]);
								unset($m[3]);
								//如果是波胆
								if(mb_strpos($m[0],"胆")){
									$bodan_score=explode("@",$m[1],2);
									$score=$bodan_score[0];
									$m[1]="波胆@".$bodan_score[1];
								}
								?>
								<span style="color:#005481"><b><?=$myrows["match_name"]?></b></span><br />
								<?
								//正则匹配
								$m_count=count($m);
								preg_match('[\((.*)\)]', $m[$m_count-1], $matches);
								if(strpos($myrows["master_guest"],'VS.')) $team=explode('VS.',$myrows["master_guest"]);
								else $team=explode('VS',$myrows["master_guest"]);
							?>
							<? if(count(@$matches)>0) echo @$myrows['bet_time'].@$matches[0]."<br/>"; ?>
							<? if(mb_strpos($m[1],"让")>0) { //让球?>
							<? if(mb_strpos($m[1],"主")===false) { //客让?>
							<?=$team[1]?>
							<?=str_replace(array("主让","客让"),array("",""),$m[1])?>
							<?=$team[0]?>(主)
							<? }else{ //主让?>
							<?=$team[0]?>
							<?=str_replace(array("主让","客让"),array("",""),$m[1])?> <?=$team[1]?>
							<? }?>
							<?
							$m[1]="";
							}else{ ?>
							<?=$team[0]?>
							<? if(isset($score)) { ?>
							<?=$score?> <? }else{?>VS.<? }?><?=$team[1]?>
							<? } ?>
							<br />
							<?
							if($m_count==3){
								if(strpos($m[1],'@')){
									$ss = explode('@',$m[1]);
									echo "<font color=\"red\">".$ss[0]."</font> @ <font color=\"red\">".$ss[1]."</font>";
								}else{
									echo $m[1].' ';//半全场替换显示
									$arraynew=array($team[0]," / ",$team[1],"和局");
									$arrayold=array("主","/","客","和");
									$ss = str_replace($arrayold,$arraynew,preg_replace('[\((.*)\)]', '',$m[$m_count-1]));
									$ss = explode('@',$ss);
									echo "<font color=\"red\">".$ss[0]."</font> @ <font color=\"red\">".$ss[1]."</font>";
								}
							}
							?>
							<? if($myrows["status"]==3 || $myrows["MB_Inball"]<0){?>
							[取消]
							<? }else if($myrows["status"]>0){?>
							[<?=$myrows["MB_Inball"]?>:<?=$myrows["TG_Inball"]?>]
							<?
							}
								echo "</div>";
								if($x<$nums-1){
							?>
							<hr style="height:1px; width:99%; color:#555555" />
							<?
								}
							$x++;
							}
							?></td>
						<td align="center"><?=sprintf("%.2f",$rows["bet_money"])?></td>
						<td align="center"><?=sprintf("%.2f",$rows["bet_win"])?></td>
						<td align="center"><?=sprintf("%.2f",$rows["win"])?></td>
						<td align="center"><?=sprintf("%.2f",$rows["fs"])?></td>
						<td align="center"><?php
							if(($rows["status"]==1 || $rows["status"]==3) && $ok_num==$rows["cg_count"]){
								echo "<span style='color:#FF0000;'>已结算</span>";
							}else if($ok_num==$rows["cg_count"]){
								echo "<span style='color:#00cc00;'>可结算</span>";
							}else{
								echo "等待单式";
							}
							?></td>
					</tr>
					<?php
							$i++;
						}
					}
					?>
					<tr>
						<th colspan="8" align="center">
							<div class="Pagination">
								本页下注总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_tz)?></font> RMB&nbsp;&nbsp;派彩总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_pc)?></font> RMB&nbsp;&nbsp;反水总金额：<font color="#ff0000"><?=sprintf("%.2f",$sum_fs)?></font> RMB
								<?=$page->get_htmlPage("record_ty.php?cn_begin=".$cn_begin."&s_begin_h=".$s_begin_h."&s_begin_i=".$s_begin_i."&cn_end=".$cn_end."&s_end_h=".$s_end_h."&s_end_i=".$s_end_i."&atype=".$atype);?>
							</div>
					  </th> 
				  </tr> 
			  </table> 
		  </div> 
	  </td> 
  </tr> 
</table> 
</body> 
</html>