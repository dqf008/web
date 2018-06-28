<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('cpgl');
$id = 0;
$qishu = 0;
if (0 < $_GET['id']){
	$id = intval($_GET['id']);
}

if (($_GET['action'] == 'cancel') && (0 < $id)){
	$caizhong = '福彩3D';
	$gameType = 'FC3D';
	switch (trim($_GET['atype']))
	{
		case '3d': $caizhong = '福彩3D';
		$gameType = 'FC3D';
		break;
		case 'pl3': $caizhong = '体彩排列3';
		$gameType = 'TCPL3';
		break;
		case 'ssl': $caizhong = '上海时时乐';
		$gameType = 'SHSSL';
		break;
        case 'kl8': $caizhong = '北京快乐8';
        $gameType = 'BJKL8';
        break;
		case 'qxc': $caizhong = '七星彩';
		$gameType = 'QXC';
		break;
//        case 'ffqxc': $caizhong = '分分七星彩';
//            $gameType = 'FFQXC';
//            break;
//        case 'wfqxc': $caizhong = '五分七星彩';
//            $gameType = 'WFQXC';
//            break;
        case 'pcdd': $caizhong = 'PC蛋蛋';
            $gameType = 'PCDD';
//            break;
//        case 'ffpcdd': $caizhong = 'PC蛋蛋';
//            $gameType = 'FFPCDD';
	}
	check_quanxian('cpcd');
	cancel_order($id, $caizhong, $gameType);
	message('操作成功');
}

if (0 < $_GET['qishu']){
	$qishu = $_GET['qishu'];
}

if (($_GET['action'] == 'cancel_qishu') && (0 < $qishu)){
	$caizhong = '福彩3D';
	$gameType = 'FC3D';
	if (trim($_GET['atype']) == ''){
		message('操作失败');
	}
	
	switch (trim($_GET['atype'])){
		case '3d': $caizhong = '福彩3D';
		$gameType = 'FC3D';
		break;
		case 'pl3': $caizhong = '体彩排列3';
		$gameType = 'TCPL3';
		break;
		case 'ssl': $caizhong = '上海时时乐';
		$gameType = 'SHSSL';
		break;
		case 'kl8': $caizhong = '北京快乐8';
		$gameType = 'BJKL8';
        break;
        case 'qxc': $caizhong = '七星彩';
        $gameType = 'QXC';
            break;
//        case 'ffqxc': $caizhong = '分分七星彩';
//            $gameType = 'FFQXC';
//            break;
//        case 'wfqxc': $caizhong = '五分七星彩';
//            $gameType = 'WFQXC';
//            break;
        case 'pcdd': $caizhong = 'PC蛋蛋';
            $gameType = 'PCDD';
//            break;
//        case 'ffpcdd': $caizhong = '分分PC蛋蛋';
//            $gameType = 'FFPCDD';
	}
	
	check_quanxian('cpcd');
	$params = array(':atype' => trim($_GET['atype']), ':qishu' => $qishu);
	$sql = 'select * from lottery_data where atype=:atype and mid=:qishu';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$countflag = 0;
	while ($rows = $stmt->fetch()){
		$id = $rows['id'];
		cancel_order($id, $caizhong, $gameType);
		$countflag++;
	}
	message('操作成功:' . $countflag . '条注单被撤销！');
}

$id = $_REQUEST['id'];
$uid = $_REQUEST['uid'];
$langx = $_SESSION['langx'];
$stype = $_REQUEST['stype'];
$loginname = $_SESSION['loginname'];
$lv = $_REQUEST['lv'];
$xtype = $_REQUEST['xtype'];
$username = $_REQUEST['username'];
$ok = $_REQUEST['ok'];
$params = array();
if ($username == ''){
	$soname = '1=1';
}else{
	$params[':username'] = $username;
	$soname = 'username=:username';
}

if ($ok == ''){
	$sook = '1=1';
}else if ($ok == 'Y'){
	$sook = 'bet_ok=1';
}else if ($ok == 'N'){
	$sook = 'bet_ok=0';
}

$s_time = $_REQUEST['s_time'];
$e_time = $_REQUEST['e_time'];
$qihao = $_REQUEST['qihao'];
$zhudanhao = $_REQUEST['zhudanhao'];
if (isset($s_time) && ($s_time != '')){
	$params[':s_time'] = $s_time;
	$sook .= ' and bet_date>=:s_time';
}

if (isset($e_time) && ($e_time != '')){
	$params[':e_time'] = $e_time;
	$sook .= ' and bet_date<=:e_time';
}

if (isset($qihao) && ($qihao != '')){
	$params[':qihao'] = trim($qihao);
	$sook .= ' and mid=:qihao';
}

if (isset($zhudanhao) && ($zhudanhao != '')){
	$params[':zhudanhao'] = trim($zhudanhao);
	$sook .= ' and uid=:zhudanhao';
}

switch ($stype){
	case '3d': $atypename = '3d';
	$typename = '福彩3D';
	break;
	case 'pl3': $atypename = 'pl3';
	$typename = '体彩排列3';
	break;
	case 'ssl': $atypename = 'ssl';
	$typename = '上海时时乐';
	break;
    case 'kl8': $atypename = 'kl8';
    $typename = '北京快乐8';
    break;
	case 'qxc': $atypename = 'qxc';
	$typename = '七星彩';
	break;
//    case 'ffqxc':
//        $atypename = 'ffqxc';
//        $typename = '分分七星彩';
//        break;
//    case 'wfqxc':
//        $atypename = 'wfqxc';
//        $typename = '五分七星彩';
//        break;
    case 'pcdd':
        $atypename = 'pcdd';
        $typename = 'PC蛋蛋';
        break;
//    case 'ffpcdd':
//        $atypename = 'ffpcdd';
//        $typename = '分分PC蛋蛋';
//        break;
	default: $atypename = 'all';
	$typename = '全部彩票';
}

if ($stype == ''){
	$sql = 'select * from lottery_data where 1=1 and ' . $soname . ' and ' . $sook . ' order by id desc';
}else{
	$params[':atype'] = $atypename;
	$sql = 'select * from lottery_data where 1=1 and ' . $soname . ' and ' . $sook . ' and atype=:atype order by id desc';
}

$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$cou = $stmt->rowCount();
$page = $_REQUEST['page'];
if (($page == '') || ($page < 0)){
	$page = 0;
}

$page_size = 50;
$page_count = ceil($cou / $page_size);
if (($page_count - 1) < $page){
	$page = $page_count - 1;
}

$offset = floatval($page * $page_size);
if ($offset < 0){
	$offset = 0;
}
$mysql = $sql . '  limit ' . $offset . ',' . $page_size . ';';
$stmt = $mydata1_db->prepare($mysql);
$stmt->execute($params);
?> 
<html> 
<head> 
<title></title> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
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
.m_title{background:url(../images/06.gif);height:24px;} 
.m_title td{font-weight:800;} 
</STYLE> 
<script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
<script language="JavaScript" src="/js/calendar.js"></script> 
</head> 
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF"> 
<table width="100%" border="1" bgcolor="#FFFFFF" bordercolor="#96B697" cellspacing="0" cellpadding="0" style="border-collapse: collapse;color: #225d9c;" > 
	  <tr> 
		<td colspan="11" align="center" bgcolor="#FFFFFF"> 
		  <a href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=&ok=<?=$ok;?>&qihao=<?=$qihao;?>&zhudanhao=<?=$zhudanhao;?>">全部</a> -  
		  <a href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=3d&ok=<?=$ok;?>&qihao=<?=$qihao;?>&zhudanhao=<?=$zhudanhao;?>">福彩3D</a> -  
		  <a href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=pl3&ok=<?=$ok;?>&qihao=<?=$qihao;?>&zhudanhao=<?=$zhudanhao;?>">体彩排列3</a> -  
		  <a href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=ssl&ok=<?=$ok;?>&qihao=<?=$qihao;?>&zhudanhao=<?=$zhudanhao;?>">上海时时乐</a> -  
          <a href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=kl8&ok=<?=$ok;?>&qihao=<?=$qihao;?>&zhudanhao=<?=$zhudanhao;?>">北京快乐8</a> -  
          <a href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=qxc&ok=<?=$ok;?>&qihao=<?=$qihao;?>&zhudanhao=<?=$zhudanhao;?>">七星彩</a> -
          <a href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=pcdd&ok=<?=$ok;?>&qihao=<?=$qihao;?>&zhudanhao=<?=$zhudanhao;?>">PC蛋蛋</a> -
        </td>
	  </tr> 
	  <tr><FORM id="myFORM" ACTION="" METHOD=POST name="myFORM" > 
		<td colspan="11" align="center" bgcolor="#FFFFFF"> 
		  会员帐号：<input type=TEXT name="username" size=10 value="<?=$username;?>" maxlength=11 class="za_text"> 
		  期号：<input type=TEXT name="qihao" size=16 value="<?=$qihao;?>" maxlength=16 class="za_text"> 
		  注单号：<input type=TEXT name="zhudanhao" size=20 value="<?=$zhudanhao;?>" maxlength=20 class="za_text"> 
		  注单日期：<input name="s_time" type="text" id="s_time" value="<?=$s_time;?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" /> 
		  ~ 
		  <input name="e_time" type="text" id="e_time" value="<?=$e_time;?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" /> 
		  <select name='ok'> 
			<option value=""<?php if ($ok == ''){?> selected<?php }?> >全部</option>  		
				  <option value="Y"<?php if ($ok == 'Y'){?> selected<?php }?> >已开奖</option> 
				  <option value="N"<?php if ($ok == 'N'){?> selected<?php }?> >未开奖</option>  
			</select> 
			<input type=SUBMIT name="SUBMIT" value="确认" class="za_button"></td></FORM> 
	  </tr> 
	  <tr> 
		  <td colspan="11"> 
			  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9"> 
				<tr> 
				  <td align="center" bgcolor="#FFFFFF"> 
					  彩种:
					  <?php if ($_GET['stype'] != ''){?>
					  <span><?=$typename;?></span>
					  <input name="cancel_atype" id="cancel_atype" value="<?=$stype;?>" type="hidden" size="15">
					  <?php }else{?>                                 
					  <select name="cancel_atype" id="cancel_atype">  	
						  <option value="3d" >福彩3D</option> 
						  <option value="pl3" >体彩排列3</option>  
						  <option value="ssl" >上海时时乐</option> 
                          <option value="kl8" >北京快乐8</option>  
						  <option value="qxc" >七星彩</option>
						  <option value="pcdd" >PC蛋蛋</option>
					  </select>
					  <?php }?>                       
					  期号：
					  <input name="cancel_qishu" id="cancel_qishu" type="text" size="15"> 
					  <input type="button" name="Submit" value="撤销当期注单" onClick="cancle_qishu_check();"></td> 
				  </tr>  
				  <script> 
					  function cancle_qishu_check() 
					  { 
						  var atype = $('#cancel_atype').val();
						  var qishu = parseInt($('#cancel_qishu').val());
						  if(qishu == null || qishu =="") 
						  { 
							  alert("请输入要撤销的期号！");
							  return false;
						  } 

						  if(isNaN(qishu)) 
						  { 
							  alert("请输入正确的期号！");
							  return false;
						  } 
						  if(confirm('您确定要撤销【'+qishu+'】期注单？撤销后金额将重算并退回！')) 
							  location.href='jszd.php?action=cancel_qishu&atype='+atype+'&qishu='+qishu;
					  } 
				  </script> 
			  </table> 
		  </td> 
	  </tr> 
	  <tr class="m_title"> 
		<td align="center">彩票种类</td> 
		<td align="center">投注时间(北京/美东)</td> 
		<td align="center">注单号</td> 
		<td align="center">期数</td> 
		<td align="center">玩法</td> 
		<td align="center"><font color="#0000FF">投注 @ 赔率</font></td> 
		<td align="center">投注金额</td> 
		<td align="center">可赢金额</td> 
		<td align="center">输赢结果</td> 
		<td align="center">下注会员</td> 
		<td align="center">操作</td> 
		</tr>
<?php 
if ($cou == 0){

}else{
	$tod_num = 0;
	$tod_bet = 0;
	$tod_win = 0;
	while ($row = $stmt->fetch())
	{
		switch ($row['atype'])
		{
			case '3d': $caizhong = '福彩3D';
			break;
			case 'pl3': $caizhong = '体彩排列3';
			break;
			case 'ssl': $caizhong = '上海时时乐';
            break;
            case 'kl8': $caizhong = '北京快乐8';
			break;
			case 'qxc': $caizhong = '七星彩';
			break;
//            case 'ffqxc': $caizhong = '分分七星彩';
//                break;
//            case 'wfqxc': $caizhong = '五分七星彩';
//                break;
            case 'pcdd': $caizhong = 'PC蛋蛋';
//            break;
//            case 'ffpcdd': $caizhong = '分分PC蛋蛋';
	}
?>
       <tr> 
	   	<td align="center" bgcolor="#FFFFFF"><?=$caizhong?></td>
          <td align="center" bgcolor="#FFFFFF"><?=date('Y-m-d H:i:s',strtotime($row['bet_time'])+1*12*3600).'<br>'.$row['bet_time'];?></td>
          <td align="center" bgcolor="#FFFFFF"><?=$row['uid']?></td>
          <td align="center" bgcolor="#FFFFFF">第 <?=$row['mid']?> 期</td>
          <td align="center" bgcolor="#FFFFFF"><?=$row['btype']?></td>
          <td align="center" bgcolor="#FFFFFF"><?=$row['dtype']?><b><font color="#0000FF"><?=$row['content']?></font> @ <font color="#990000"><?=$row['odds']?></font></b></td>
          <td align="center" bgcolor="#FFFFFF"><font color="#0000FF"><?=$row['money']?></font></td>
          <td align="center" bgcolor="#FFFFFF"><?=$row['money']*$row['odds']-$row['money']?></td>
          <td align="center" bgcolor="#FFFFFF"><? if($row['bet_ok']==1){?><font color="#FF0000"><?=$row['win']?></font><? }else{?><font color="#0000FF">未开奖</font><? }?></td>
          <td align="center" bgcolor="#FFFFFF"><?=$row['username']?></td>
		<td align="center"><a href="javascript:void(0);" onClick="if(confirm('您确定要撤销该注单？撤销后金额将重算并退回！'))location.href='?action=cancel&id=<?=$row['id'];?>&atype=<?=$row['atype'];?>';">撤销</a></td> 
		</tr>
<?php 
	$tod_num = $tod_num + 1;
}
?>         
		<tr> 
		<td colspan="11" align="center" bgcolor="#FFFFFF">
		共计<?=$page_count;?>页 - 当前第<?=$page + 1;?>页
		<?php if (1 < ($page + 1)){?> 		    
		<a style="font-weight: normal;color:#000;" href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=<?=$stype;?>&ok=<?=$ok;?>&page=<?=$page - 1;?>">上一页</a>
		<?php }else{?>上一页<?php }?>|<?php if (($page + 1) < $page_count){?> 		    
		<a style="font-weight: normal;color:#000;" href="?qi=<?=$qi;?>&username=<?=$username;?>&stype=<?=$stype;?>&ok=<?=$ok;?>&page=<?=$page + 1;?>">下一页</a>
		<?php }else{?>下一页<?php }?> 		   
		</td> 
		</tr>
<?php }?>     
</table> 
</body> 
</html>
<?php 
function cancel_order($id, $caizhong, $gameType){
	global $mydata1_db;
	$params = array(':id' => $id);
	$sql = 'select * from lottery_data where id=:id';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$rs = $stmt->fetch();
	if ($rs){
		$qishu = $rs['mid'];
		$cp_uid = $rs['uid'];
		$kusername = $rs['username'];
		$money = $rs['money'];
		$win = $rs['win'];
		$bet_ok = $rs['bet_ok'];
		$remoney = $money;
		if (($bet_ok == 1) && (0 < $win)){
			$remoney = -$win;
		}
		$params = array(':username' => $kusername);
		$sql = 'select uid from k_user where username=:username limit 1';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$kuid = $stmt->fetchColumn();
		$params = array(':id' => $id);
		$sql = 'delete from lottery_data where id=:id';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$params = array(':money' => $remoney, ':uid' => $kuid);
		$sql = 'update k_user set money=money+:money where uid=:uid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':uid' => $kuid, ':userName' => $kusername, ':gameType' => $gameType, ':transferOrder' => $cp_uid, ':transferAmount' => $remoney, ':transferAmount2' => $remoney, ':creationTime' => $creationTime, ':quid' => $kuid);
		$sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT :uid,:userName,:gameType,\'CANCEL_BET\',:transferOrder,:transferAmount,money-:transferAmount2,money,:creationTime FROM k_user WHERE uid=:quid';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		include_once '../../class/admin.php';
		$message = '撤销[' . $kusername . ']' . $caizhong . '期号[' . $qishu . ']注单[' . $cp_uid . '],[注单金额:' . $money . ',可赢金额:' . $win . ',结算状态:' . $bet_ok . '],退回金额:' . $remoney;
		admin::insert_log($_SESSION['adminid'], $message);
	}
}
?>