<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once 'get_point.php';
include_once '../../class/bet.php';
session_start();
$url = "爱博官网";
$title = "足球结算 => 上半场";
if (intval(date('H')) < 4){
	if ($_SESSION['zqsbauto'] == '0'){
		$list_date = date('Y-m-d', time());
		$bdate = date('m-d', time());
		$date = date('Y-m-d', time());
		$mDate = date('m-d', time());
		$_SESSION['zqsbauto'] = '-1';
	}else{
		$list_date = date('Y-m-d', time() - (24 * 3600));
		$bdate = date('m-d', time() - (24 * 3600));
		$date = date('Y-m-d', time() - (24 * 3600));
		$mDate = date('m-d', time() - (24 * 3600));
		$_SESSION['zqsbauto'] = '0';
	}
}else{
	$list_date = date('Y-m-d', time());
	$bdate = date('m-d', time());
	$date = date('Y-m-d', time());
	$mDate = date('m-d', time());
}

try
{
	$params = array(':Match_Date' => $mDate);
	$sql = 'select MB_Inball_HR,TG_Inball_HR,Match_Master,match_name,Match_Guest,Match_ID from mydata4_db.bet_match where `Match_Date` =:Match_Date and  MB_Inball_HR is not null and match_sbjs!=\'1\' order by ID';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	while ($rows = $stmt->fetch()){
		$mids[$rows['Match_ID']] = floatval($rows['Match_ID']);
		$MB_Inball_HR = $rows['MB_Inball_HR'];
		$TG_Inball_HR = $rows['TG_Inball_HR'];
		$MB_Inball = $rows['MB_Inball'];
		$TG_Inball = $rows['TG_Inball'];
		$paramsSub = array(':MB_Inball' => $MB_Inball_HR, ':TG_Inball' => $TG_Inball_HR, ':match_id' => $rows['Match_ID']);
		$sqlSub = 'update k_bet set MB_Inball=:MB_Inball,TG_Inball=:TG_Inball where lose_ok=1 and (ball_sort like(\'%上半场%\') or bet_info like(\'%上半场%\')) and status=0 and match_id=:match_id';
		$stmtSub = $mydata1_db->prepare($sqlSub);
		$stmtSub->execute($paramsSub);
		$paramsSub = array(':MB_Inball' => $MB_Inball_HR, ':TG_Inball' => $TG_Inball_HR, ':match_id' => $rows['Match_ID']);
		$sqlSub = 'update k_bet_cg set mb_inball=:MB_Inball,tg_inball=:TG_Inball where status=0 and match_id=:match_id and (ball_sort like(\'%上半场%\') or bet_info like(\'%上半场%\'))';
		$stmtSub = $mydata1_db->prepare($sqlSub);
		$stmtSub->execute($paramsSub);
	}
	$mid = @(implode(',', $mids));
	$m = count($mids);
	$bool = true;
	if (0 < count($mids)){
		$sql = 'select k_bet.*,k_user.username from k_bet left join k_user on k_bet.uid=k_user.uid where k_bet.lose_ok=1 and (ball_sort like(\'%上半场%\') or bet_info like(\'%上半场%\')) and status=0 and match_id in(' . $mid . ') and k_bet.check=0 order by  k_bet.bid  desc ';
		$result = $mydata1_db->query($sql);
		while ($rows = $result->fetch()){
			$all_bet_money += $rows['bet_money'];
			$column = $rows['point_column'];
			$t = make_point(strtolower($column), '', '', $rows['MB_Inball'], $rows['TG_Inball'], $rows['match_type'], $rows['match_showtype'], $rows['match_rgg'], $rows['match_dxgg'], $rows['match_nowscore']);
			$bid = intval($rows['bid']);
			$status = intval($t['status']);
			$mb_inball = $rows['MB_Inball'];
			$tg_inball = $rows['TG_Inball'];
			$bool = bet::set($bid, $status, $mb_inball, $tg_inball);
			if (!$bool){
				break;
			}
			$bids[$rows['bid']] = intval($rows['bid']);
		}
		$sql = 'select k_bet_cg.*,k_user.username from k_bet_cg left join k_user on k_bet_cg.uid=k_user.uid where status=0 and match_id in(' . $mid . ') and(ball_sort like(\'%上半场%\') or bet_info like(\'%上半场%\')) and k_bet_cg.check=0 order by k_bet_cg.bid desc';
		$result_cg = $mydata1_db->query($sql);
		while ($rows = $result_cg->fetch()){
			$all_bet_money += $rows['bet_money'];
			$column = $rows['point_column'];
			$t = make_point(strtolower($column), '', '', $rows['MB_Inball'], $rows['TG_Inball'], $rows['match_type'], $rows['match_showtype'], $rows['match_rgg'], $rows['match_dxgg'], $rows['match_nowscore']);
			$bid = intval($rows['bid']);
			$status = intval($t['status']);
			$mb_inball = $rows['MB_Inball'];
			$tg_inball = $rows['TG_Inball'];
			$bool = bet::set_cg($bid, $status, $mb_inball, $tg_inball);
			if (!$bool){
				break;
			}
			$cg_bids[$rows['bid']] = intval($rows['bid']);
		}

		if (0 < count($bids)){
			$mydata1_db->query('update k_bet set `check`=1 where bid in(' . implode(',', $bids) . ')');
		}

		if (0 < count($cg_bids)){
			$mydata1_db->query('update k_bet_cg set `check`=1 where bid in(' . implode(',', $cg_bids) . ')');
		}

		if ($bool){
			$mydata1_db->query('update mydata4_db.bet_match set match_sbjs=\'1\' where match_id in(' . $mid . ')');
			include_once '../../class/admin.php';
			admin::insert_log($_SESSION['adminid'], '批量审核了足球赛事' . $mid . '注单');
			$m = count($mids);
		}
	}
}catch (Exception $ex){
	$m = 'Fail';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title.' '.$url?></title>
<style type="text/css">
<!--
body,td,th {
    font-size: 12px;
}
body {
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
}
-->
</style></head>
<body>

<script> 
<!-- 

<? $limit= rand(120,180);?>
var limit="<?=$limit?>"
if (document.images){ 
	var parselimit=limit
} 
function beginrefresh(){ 
if (!document.images) 
	return 
if (parselimit==1) 
	window.location.reload() 
else{ 
	parselimit-=1 
	curmin=Math.floor(parselimit) 
	if (curmin!=0) 
		curtime=curmin+"秒后自动获取!" 
	else 
		curtime=cursec+"秒后自动获取!" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 
window.onload=beginrefresh
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left" style="padding-left:10px; padding-top:10px; line-height:22px;">
	   <input type=button name=button value="刷新" onClick="window.location.reload()">
	   <span id="timeinfo"></span><br />
	   采集网址：<?=$url?><br />
       <font color="#FF0000">接收<?=$m;?>条足球上半结算！</font> <br />
      </td>
  </tr>
</table>
</body>
</html>
