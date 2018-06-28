<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('sgjzd');
$type = $_GET['type'];
?> 
<HTML> 
<HEAD> 
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" /> 
<TITLE>单式注单列表</TITLE> 
<script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 

<script language="javascript"> 

	function winopen(bid,status){ 
	  window.open("set_score.php?bid="+bid+"&status="+status,"list","width=440,height=180,left=50,top=100,scrollbars=no");
	} 
	
	function windowopen(url){ 
	  window.open(url,"wx","width=600,height=500,left=50,top=100,scrollbars=no");
	} 
	
	function go(value){ 
	  if(value != "") location.href=value;
	  else return false;
	} 
	
	function check(){ 
	  if($("#tf_id").val().length > 5){ 
		  $("#status").val("8,0,1,2,3,4,5,6,7");
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
a{ 
  color:#F37605;
  text-decoration: none;
} 
.t-title{background:url(../images/06.gif);height:24px;} 
.t-tilte td{font-weight:800;} 
</STYLE> 
</HEAD> 

<body> 
<script language="JavaScript" src="../../js/calendar.js"></script> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
  <tr>
	<?php 
	$pagesize = 20;
	if ($_GET['PageNum']){
		$pagesize = $_GET['PageNum'];
	}
	?>     
    <td height="24" nowrap background="../images/06.gif"><font >&nbsp;<span class="STYLE2">注单管理：查看所有注单情况（所有时间以美国东部标准为准）</span></font></td> 
  </tr> 
  <tr> 
    <td height="24" align="center" nowrap bgcolor="#FFFFFF"> 
	<table width="100%"> 
	<form name="form1" method="get" action="<?=$_SERVER['REQUEST_URI']?>" onSubmit="return check();"> 
	<tr align="center"> 
	  <td width="58" align="center"> 
		  <select onChange="self.form1.submit()" name="type" id="type"> 
			   <option value="">全部</option> 
			   <option value="足球" <?= $type=='足球' ? 'selected="selected"' : ''?>>足球</option>
			   <option value="篮球" <?= $type=='篮球' ? 'selected="selected"' : ''?>>篮球</option>
			   <option value="网球" <?= $type=='网球' ? 'selected="selected"' : ''?>>网球</option>
			   <option value="排球" <?= $type=='排球' ? 'selected="selected"' : ''?>>排球</option>
			   <option value="棒球" <?= $type=='棒球' ? 'selected="selected"' : ''?>>棒球</option>
			   <option value="冠军" <?= $type=='冠军' ? 'selected="selected"' : ''?>>冠军</option>
		  </select> 
	  </td> 
	  <td width="90" align="center"> 
		  <select name="PageNum" onChange="self.form1.submit()"> 
			  <option value="">每页20条</option> 
			  <option value="50"<?php if ($pagesize == 50){?> selected<?php }?>  >50条</option> 
			  <option value="100"<?php if ($pagesize == 100){?> selected<?php }?>  >100条</option> 
		      <option value="200"<?php if ($pagesize == 200){?> selected<?php }?>  >200条</option> 
			  <option value="250"<?php if ($pagesize == 250){?> selected<?php }?>  >250条</option> 
			  <option value="500"<?php if ($pagesize == 500){?> selected<?php }?>  >500条</option> 
			  <option value="1000"<?php if ($pagesize == 1000){?> selected<?php }?>  >1000条</option>
		  </select>  
	  </td> 
	  <td width="100" align="center"> 
		  <select name="status" id="status" onChange="self.form1.submit()"> 
			<option value="0" style="color:#FF9900;" <?=$_GET['status']=='0' ? 'selected' : ''?>>未结算注单</option>
            <option value="1,4,5" style="color:#FF0000;" <?=$_GET['status']=='1,4,5' ? 'selected' : ''?>>已赢注单</option>
            <option value="2" style="color:#009900;" <?=$_GET['status']=='2' ? 'selected' : ''?>>已输注单</option>
            <option value="3,6,7,8" style="color:#0000FF;" <?=$_GET['status']=='3,6,7,8' ? 'selected' : ''?>>和局或取消</option>
            <option value="8,0,1,2,3,4,5,6,7" <?=$_GET['status']=='8,0,1,2,3,4,5,6,7' ? 'selected' : ''?>>全部注单</option>
		  </select> 
	  </td> 
	  <td width="90" align="center"> 
	  <label> 
		  <select name="order" id="order" onChange="self.form1.submit()"> 
			<option value="bid" <?=$_GET['order']=='bid' ? 'selected' : ''?>>默认排序</option>
            <option value="bet_money" <?=$_GET['order']=='bet_money' ? 'selected' : ''?>>交易金额</option>
            <option value="win" <?=$_GET['order']=='win' ? 'selected' : ''?>>已赢金额</option> 
		  </select> 
	  </label> 
	  </td> 
	  <td width="729" align="left"> 
		  &nbsp;会员： 
		  <input name="username" type="text" id="username" value="<?=$_GET['username']?>" size="15">
          &nbsp;&nbsp;日期：
          <input name="bet_time" type="text" id="bet_time" value="<?=$_GET['bet_time']?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />            					          &nbsp;&nbsp;&nbsp;注单号：
          <input name="tf_id" type="text" id="tf_id" value="<?=@$_GET['tf_id']?>" size="22">
          &nbsp;
          <input type="submit" name="Submit" value="搜索">
	  </td> 
	</tr> 
	</form> 
  </table> 
  </td> 
</tr> 
</table> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"> 
  
<tr> 
  <td height="24" nowrap bgcolor="#FFFFFF"><table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" > 
	<tr  class="t-title" align="center" > 
	  <td width="56"><strong>编号</strong></td> 
	  <td width="136"><strong>联赛名</strong></td> 
	  <td width="176"><strong>编号/主客队</strong></td> 
	  <td width="246"><strong>投注详细信息</strong></td> 
	  <td width="56"><strong>下注</strong></td> 
	  <td width="56"><strong>结果</strong></td> 
	  <td width="56"><strong>可赢</strong></td> 
	  <td width="106"><strong>投注/开赛时间</strong></td> 
	  <td width="96"><strong>投注账号</strong></td> 
	  <td><strong>操作</strong></td> 
	</tr>
	<?php 
	include_once '../../include/newPage.php';
	$uid = '';
	if ($_GET['username']){
		$params = array(':username' => $_GET['username']);
		$sql = 'select uid from k_user where username=:username limit 1';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		if ($rows = $stmt->fetch()){
			$uid = intval($rows['uid']);
		}else{
			$uid = '0';
		}
	}
	
	$sql = 'select bid from k_bet where lose_ok=1 ';
	$params = array();
	if ($type){
		$params[':type'] = $type . '%';
		$sql .= ' and ball_sort like(:type)';
	}
	
	if ($_GET['uid']){
		$uid = intval($_GET['uid']);
	}
	
	if ($uid != ''){
		$params[':uid'] = $uid;
		$sql .= ' and uid=:uid';
	}
	
	if (isset($_GET['match_id'])){
		$params[':match_id'] = $_GET['match_id'];
		$sql .= ' and match_id=:match_id';
	}
	
	if (isset($_GET['match_name'])){
		$params[':match_name'] = urldecode($_GET['match_name']);
		$sql .= ' and match_name=:match_name';
	}
	
	if (isset($_GET['ball_sort'])){
		$params[':ball_sort'] = urldecode($_GET['ball_sort']);
		$sql .= ' and ball_sort=:ball_sort';
	}
	
	if (isset($_GET['point_column'])){
		$params[':point_column'] = strtolower($_GET['point_column']);
		$sql .= ' and point_column=:point_column';
	}
	
	if (isset($_GET['column_like'])){
		$params[':column_like'] = '%' . strtolower($_GET['column_like']) . '%';
		$sql .= ' and point_column like(:column_like)';
	}
	
	if (isset($_GET['match_type'])){
		$params[':match_type'] = intval($_GET['match_type']);
		$sql .= ' and match_type=:match_type';
	}
	
	if (isset($_GET['www'])){
		$params[':www'] = $_GET['www'];
		$sql .= ' and www=:www';
	}
	
	if (isset($_GET['s_time'])){
		$params[':s_time'] = $_GET['s_time'];
		$sql .= ' and bet_time>=:s_time';
	}
	
	if (isset($_GET['e_time'])){
		$params[':e_time'] = $_GET['e_time'];
		$sql .= ' and bet_time<=:e_time';
	}
	
	if (isset($_GET['status'])){
		switch ($_GET['status']){
			case '0': 
			case '1,4,5': 
			case '2': 
			case '3,6,7,8': 
			case '8,0,1,2,3,4,5,6,7': 
				$status = $_GET['status'];
				break;
			default: 
				$status = '0';
				break;
		}
		$sql .= ' and `status` in (' . $status . ')';
	}
	
	if ($_GET['tf_id']){
		$params[':number'] = $_GET['tf_id'];
		$sql .= ' and number=:number';
	}
	
	if ($_GET['bet_time']){
		$params[':bet_time'] = $_GET['bet_time'] . '%';
		$sql .= ' and bet_time like(:bet_time)';
	}
	
	$order = 'bid';
	if ($_GET['order']){
		switch ($_GET['order']){
			case 'bid': 
			case 'bet_money': 
			case 'win': 
				$order = $_GET['order'];
				break;
			default: 
				$order = 'bid';
				break;
		}
	}
	
	$sql .= ' order by ' . $order . ' desc ';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$sum = $stmt->rowCount();
	$thisPage = 1;
	if ($_GET['page']){
		$thisPage = $_GET['page'];
	}
	
	$page = new newPage();
	$thisPage = $page->check_Page($thisPage, $sum, $pagesize, 40);
	$bid = '';
	$i = 1;
	$start = (($thisPage - 1) * $pagesize) + 1;
	$end = $thisPage * $pagesize;
	while ($row = $stmt->fetch()){
		if (($start <= $i) && ($i <= $end)){
			$bid .= intval($row['bid']) . ',';
		}
		
		if ($end < $i){
			break;
		}
		
		$i++;
	}
	
	
	if ($bid){
		$bid = rtrim($bid, ',');
		$sql = 'select b.*,u.username from k_bet b,k_user u where b.uid=u.uid and bid in('.$bid.') order by '.$order.' desc';
		$query = $mydata1_db->query($sql);
		$bet_money = $win = 0;
		
		while ($rows = $query->fetch()){
			$bet_money += $rows['bet_money'];
			$win += $rows['win'];
			$color = '#FFFFFF';
			$over = '#EBEBEB';
			$out = '#ffffff';
			if(($rows["balance"]*1)<0 || round($rows["assets"]-$rows["bet_money"],2) != round($rows["balance"],2)){ //投注后用户余额不能为负数，投注后金额要=投注前金额-投注金额
		  		$over = $out = $color = "#FBA09B";
		  	}elseif($rows["match_type"]==1 && strtotime($rows["bet_time"])>=strtotime($rows["match_endtime"])){ //不是滚球，抽注时间不能>=开赛时间
		  		$over = $out = $color = "#FBA09B";
		  	}elseif(double_format($rows["bet_money"]*($rows["ben_add"]+$rows["bet_point"])) !== double_format($rows["bet_win"])){
		  		$over = $out = $color = "#FBA09B";
		  	}
?> 	          
			<tr align="center" onMouseOver="this.style.backgroundColor='<?=$over?>'" onMouseOut="this.style.backgroundColor='<?=$out?>'" style="background-color:<?=$color?>;">
	          <td  align="center" ><a href="edit.php?bid=<?=$rows["bid"]?>" title="编辑注单"><?=$rows["bid"]?></a></td>
              <td>
			  	<a href="sgjds.php?match_name=<?=urlencode($rows["match_name"])?>"><?=$rows["match_name"]?></a>
				<br />
				<a href="sgjds.php?www=<?=$rows['www']?>" style="color:#999999;"><?=$rows['www']?></a>
				<?php
				  if($rows["status"] == 3){
					echo '<br/><span style="color:#999999;">'.$rows["sys_about"].'</span>';
				  }
				?>
			  </td>
			  <td>
			  	<a href="check_zd.php?action=1&id=<?=$rows["number"]?>"><?=$rows["number"]?></a><br/>
             	<a href="sgjds.php?match_id=<?=$rows["match_id"]?>"><?=$rows["match_id"]?></a>
			    <br/>
				<?php
				if(strpos($rows["master_guest"],'VS.')){
					echo str_replace("VS.","<br/>",$rows["master_guest"]);
				}else{
					echo str_replace("VS","<br/>",$rows["master_guest"]);
				}
				?>
			  </td> 
			  <td>
			  	<a href="sgjds.php?ball_sort=<?=urlencode($rows["ball_sort"])?>">
				 	<font color="<? if ($rows["ball_sort"]=="足球滚球"){echo "#0066FF";}else{echo "#336600";}?>"><b><?=$rows["ball_sort"]?></b></font>
				</a>
				<br/>
				<?=$rows["match_time"]?>
			 	<font style="color:#FF0033">
			  	<?php if($rows["point_column"]==="match_jr" || $rows["point_column"]==="match_gj"){ echo $rows["bet_info"];}else{ echo str_replace("-","<br>",$rows["bet_info"]);}?>
			    </font>
			  	<? 
				if($rows["status"]!=0 && $rows["status"]!=3 && $rows["status"]!=8 && $rows["status"]!=6 && $rows["status"]!=7){
					if($rows["MB_Inball"]!=''){
				?>
						[<?=$rows["MB_Inball"]?>:<?=$rows["TG_Inball"]?>]
				<?
					} 
				}
				?>
			  </td> 
			  <td><?=$rows["bet_money"]?></td>
	          <td><?=$rows["win"]?></td>
              <td><?=$rows["bet_win"]?></td>
              <td><?=date("m-d H:i:s",strtotime($rows["bet_time"]))?><br/>
              	<?//获取开赛时间
					$table = '';
					if(strpos($rows["ball_sort"], '足球') !== false){
						$table = 'bet_match';
					}else if(strpos($rows["ball_sort"], '篮球') !== false){
						$table = 'lq_match';
					}else if(strpos($rows["ball_sort"], '网球') !== false){
						$table = 'tennis_match';
					}else if(strpos($rows["ball_sort"], '羽毛球') !== false){
						$table = 'badminton_match';
					}else if(strpos($rows["ball_sort"], '排球') !== false){
						$table = 'volleyball_match';
					}else if(strpos($rows["ball_sort"], '棒球') !== false){
						$table = 'baseball_match';
					}else if(strpos($rows["ball_sort"], '斯诺克') !== false){
						$table = 'snooker_match';
					}else if(strpos($rows["ball_sort"], '其他') !== false){
						$table = 'other_match';
					}else if(strpos($rows["ball_sort"], '冠军') !== false){
						$table = 't_guanjun';
					}

					if($table!=''){
						$tsql = 'select Match_MatchTime from mydata4_db.'.$table.' where match_id = '.$rows["match_id"];
						$stmt = $mydata1_db->query($tsql);
						$rw = $stmt->fetch();

						if(strpos($rw['Match_MatchTime'],'a') !== false){
							echo str_replace('a',':00',$rw['Match_MatchTime']);
						}else if(strpos($rw['Match_MatchTime'],'p') !== false){
							$m_time = str_replace('p',':00',$rw['Match_MatchTime']);
							$m1 = explode(' ',$m_time);
							$m2 = explode(':',$m1[1]);
							$m = $m2[0] + 12;

							echo $m1[0].' '.$m.':'.$m2[1].':'.$m2[2];
						}else{
							echo $rw['Match_MatchTime'];
						}
					}
					
				?>
              </td>
              <td><span style="color:#999999;"><?=$rows["assets"]?></span><br /><a href="sgjds.php?uid=<?=$rows["uid"]?>"><?=$rows["username"]?></a><br /><span style="color:#999999;"><?=$rows["balance"]?></span></td>
			<td align="center" class="make">
			<?php if ($rows["status"]==0){
			  	 if($rows["point_column"]==="match_jr" || $rows["point_column"]==="match_gj"){?>
				 	<a href="javascript:windowopen('jrgjjs.php?match_id=<?=$rows["match_id"]?>&bid=<?=$rows["bid"]?>')">结算</a>
			  <?php
			  	 }else{
			  ?>
			  <!--<a href="set_bet.php?bid=<?=$rows["bid"]?>&amp;status=2">输</a> -->
			 <a href="javascript:winopen(<?=$rows["bid"]?>,2);">输</a> <a onClick="javascript:winopen(<?=$rows["bid"]?>,1);" href="#">赢</a> <a onClick="javascript:winopen(<?=$rows["bid"]?>,8);" href="#">和</a> 
			   <? if($rows["ben_add"]==1){?>
			  <br/>
			<!--  <a href="set_bet.php?bid=<?=$rows["bid"]?>&amp;status=5">输一半</a>-->
			 <a href="javascript:winopen(<?=$rows["bid"]?>,5)">输一半</a>
		      <br/>
			  <a href="javascript:winopen(<?=$rows["bid"]?>,4)">赢一半</a> 
			  <? }
			  	}
			  ?>
			  <br/>
			  <a href="javascript:windowopen('set_bets3.php?bid=<?=$rows["bid"]?>&new=1')">无效</A>
			  <? }else if($rows["status"]==3){?>
              注单无效	
			   <? }else if($rows["status"]==4){?>
              赢一半
			   <? }else if($rows["status"]==5){?>
              输一半
			    <? }else if($rows["status"]==6){?>
              进球无效
			    <? }else if($rows["status"]==7){?>
              红卡取消
			  <? }else if($rows["status"]==1){?>
			  赢
			  <? }else if($rows["status"]==2){?>
			  输
			  <? }else if($rows["status"]==8){?>
			  和局
			  <? } ?>
			  <? if($rows["status"]!=0){?>
			 <br/>
			  <a onClick="return confirm('确定重新审核？')" href="javascript:windowopen('qx_bet.php?bid=<?=$rows["bid"]?>&amp;status=<?=$rows["status"]?>')">重新审核</a>
			  <? }?>
			</td> 
	    </tr> 
		<?
       }
	}
      ?>
	 </table> 
    </td> 
  </tr> 
  <tr> 
	<td > 
    	该页统计:总注金:<?=$bet_money?>，结果:<?=$win?>，盈亏：<span style="color:<?=$bet_money-$win>0 ? '#FF0000' : '#009900'?>;"><?=$bet_money-$win?></span> 
    </td> 
  </tr> 
  <tr><td><?=$page->get_htmlPage($_SERVER["REQUEST_URI"]);?></td></tr> 
</table> 
</body> 
</html>