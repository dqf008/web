<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('sjgl');
$msg = '&nbsp;';
$action = $_POST['hf_action'];
if ($action == 'ss'){
	$time = strtotime(date('Y-m-d'));
	$time = strftime('%Y-%m-%d', $time - (6 * 24 * 3600)) . ' 00:00:00';
	$params = array(':Match_CoverDate' => $time);
	$sql = 'Delete From mydata4_db.bet_match Where Match_CoverDate<:Match_CoverDate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1){
		$msg = '足球：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg = '足球：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':Match_CoverDate' => $time);
	$sql = 'Delete From mydata4_db.lq_match Where Match_CoverDate<:Match_CoverDate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1){
		$msg .= '篮球：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '篮球：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':Match_CoverDate' => $time);
	$sql = 'Delete From mydata4_db.tennis_match Where Match_CoverDate<:Match_CoverDate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1){
		$msg .= '网球：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '网球：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':Match_CoverDate' => $time);
	$sql = 'Delete From mydata4_db.volleyball_match Where Match_CoverDate<:Match_CoverDate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1){
		$msg .= '排球：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '排球：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':Match_CoverDate' => $time);
	$sql = 'Delete From mydata4_db.baseball_match Where Match_CoverDate<:Match_CoverDate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1){
		$msg .= '棒球：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '棒球：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':Match_CoverDate' => $time);
	$sql = 'select x_id from mydata4_db.t_guanjun where Match_CoverDate<:Match_CoverDate';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$xid = '';
	while ($rows = $stmt->fetch())
	{
		$xid .= intval($rows['x_id']) . ',';
	}
	if ($xid)
	{
		$xid = rtrim($xid, ',');
		$sql = 'Delete From mydata4_db.t_guanjun_team Where xid in(' . $xid . ')';
		$mydata1_db->query($sql);
		$params = array(':Match_CoverDate' => $time);
		$sql = 'Delete From mydata4_db.t_guanjun Where Match_CoverDate<:Match_CoverDate';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$q1 = $stmt->rowCount();
		if ($q1)
		{
			$msg .= '金融冠军：恭喜您，本次共删除：' . $q1 . ' 条记录！';
		}else{
			$msg .= '金融冠军：您的数据库已经优化好了，本次无记录删除！';
		}
	}else{
		$msg .= '金融冠军：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':end_time' => $time);
	$sql = 'Delete From `k_notice` Where end_time<:end_time';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1)
	{
		$msg .= '公告：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '公告：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':datetime' => $time);
	$sql = 'Delete From `c_auto_2` Where datetime<:datetime';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1)
	{
		$msg .= '重庆时时彩：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '重庆时时彩：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':datetime' => $time);
	$sql = 'Delete From `c_auto_3` Where datetime<:datetime';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1)
	{
		$msg .= '广东快乐10分：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '广东快乐10分：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':datetime' => $time);
	$sql = 'Delete From `c_auto_4` Where datetime<:datetime';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1)
	{
		$msg .= '北京赛车PK拾：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '北京赛车PK拾：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':fengpan' => $time);
	$sql = 'Delete From `lottery_k_kl8` Where fengpan<:fengpan';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1)
	{
		$msg .= '北京快乐8：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '北京快乐8：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':addtime' => $time);
	$sql = 'Delete From `lottery_k_ssl` Where addtime<:addtime';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1)
	{
		$msg .= '上海时时乐：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '上海时时乐：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':msg_time' => $time);
	$sql = 'Delete From `k_user_msg` Where msg_time<:msg_time';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1)
	{
		$msg .= '站内消息：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '站内消息：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':login_time' => $time);
	$sql = 'Delete From mydata3_db.admin_login Where login_time<:login_time';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1)
	{
		$msg .= '管理员登陆日志：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '管理员登陆日志：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':login_time' => $time);
	$sql = 'Delete From mydata3_db.history_login Where login_time<:login_time';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1)
	{
		$msg .= '会员历史登陆记录：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '会员历史登陆记录：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
	$params = array(':log_time' => $time);
	$sql = 'Delete From mydata3_db.sys_log Where log_time<:log_time';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
	$q1 = $stmt->rowCount();
	if ($q1){
		$msg .= '系统日志：恭喜您，本次共删除：' . $q1 . ' 条记录！';
	}else{
		$msg .= '系统日志：您的数据库已经优化好了，本次无记录删除！';
	}
	$msg .= '<br />';
}

if ($action == 'del'){
	$time = strtotime(date('Y-m-d'));
	$time = strftime('%Y-%m-%d', $time - (30 * 24 * 3600)) . ' 00:00:00';
	$cz = array();
	$cw = array();
	$cz = @($_POST['cz']);
	$cw = @($_POST['cw']);
	$meg = '';
	if ($cz){
		if (in_array('tyds', $cz)){
			$params = array(':match_coverdate' => $time);
			$sql = 'delete from k_bet where status <> 0 and match_coverdate <= :match_coverdate';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '体育单式：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '体育单式：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('tycg', $cz)){
			$params = array(':match_coverdate' => $time);
			$sql = 'select gid from k_bet_cg_group where status <> 0 and match_coverdate <= :match_coverdate';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$gid = '';
			while ($rows = $stmt->fetch()){
				$gid .= intval($rows['gid']) . ',';
			}
			if ($gid != ''){
				$gid = rtrim($gid, ',');
				$sql = 'delete from k_bet_cg where gid in (' . $gid . ')';
				$mydata1_db->query($sql);
				$sql = 'delete from k_bet_cg_group where gid in (' . $gid . ')';
				$result = $mydata1_db->query($sql);
				$count = $result->rowCount();
				if ($count){
					$meg .= '体育串关：恭喜您，本次共删除：' . $count . ' 条记录！';
				}else{
					$meg .= '体育串关：您的数据库已经优化好了，本次无记录删除！';
				}
			}else{
				$meg .= '体育串关：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('lhc', $cz)){
			$params = array(':adddate' => $time);
			$sql = 'delete from mydata2_db.ka_tong where adddate <= :adddate';
			$stmt = $mydata2_db->prepare($sql);
			$stmt->execute($params);
			$sql = 'delete from mydata2_db.ka_tan where checked = 1 and adddate <= :adddate';
			$stmt = $mydata2_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '香港六合彩：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '香港六合彩：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		if (in_array('cqssc', $cz)){
			$params = array(':adddate' => $time);
			$sql = 'delete from c_bet where js = 1 and addtime <= :adddate';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count)
			{
				$meg .= '重庆时时彩：恭喜您，本次共删除：' . $count . ' 条记录！';
			}
			else
			{
				$meg .= '重庆时时彩：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		if (in_array('gdklsf', $cz)){
			$params = array(':adddate' => $time);
			$sql = 'delete from c_bet_3 where type = \'广东快乐10分\' and js = 1 and addtime <= :adddate';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '广东快乐10分：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '广东快乐10分：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('bjsc', $cz))
		{
			$params = array(':adddate' => $time);
			$sql = 'delete from c_bet_3 where type = \'北京赛车PK拾\' and js = 1 and addtime <= :adddate';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '北京赛车PK拾：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '北京赛车PK拾：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('kl8', $cz))
		{
			$params = array(':bet_time' => $time);
			$sql = 'delete from lottery_data where atype = \'kl8\' and bet_ok = 1 and bet_time <= :bet_time';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '北京快乐8：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '北京快乐8：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('ssl', $cz)){
			$params = array(':bet_time' => $time);
			$sql = 'delete from lottery_data where atype = \'ssl\' and bet_ok = 1 and bet_time <= :bet_time';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '上海时时乐：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '上海时时乐：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('3d', $cz))
		{
			$params = array(':bet_time' => $time);
			$sql = 'delete from lottery_data where atype = \'3d\' and bet_ok = 1 and bet_time <= :bet_time';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '福彩3D：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '福彩3D：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('pl3', $cz)){
			$params = array(':bet_time' => $time);
			$sql = 'delete from lottery_data where atype = \'pl3\' and bet_ok = 1 and bet_time <= :bet_time';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count)
			{
				$meg .= '排列三：恭喜您，本次共删除：' . $count . ' 条记录！';
			}
			else
			{
				$meg .= '排列三：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('live', $cz)){
			$params = array(':betTime' => $time);
			$sql = 'delete from agbetdetail where betTime <= :betTime';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '真人下注记录：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '真人下注记录：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('hg_live', $cz)){
			$params = array(':BetStartDate' => $time);
			$sql = 'delete from hgbetdetail where BetStartDate <= :BetStartDate';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= 'HG真人下注记录：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= 'HG真人下注记录：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('bb_live', $cz)){
			$params = array(':WagersDate' => $time);
			$sql = 'delete from bbbetdetail where WagersDate <= :WagersDate';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= 'BBIN真人下注记录：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= 'BBIN真人下注记录：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('mg_live', $cz)){
			$params = array(':betTime' => $time);
			$sql = 'delete from mgbetdetail where betTime <= :betTime';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= 'MG真人下注记录：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= 'MG真人下注记录：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('ds_live', $cz)){
			$params = array(':endTime' => $time);
			$sql = 'delete from dsbetdetail where endTime <= :endTime';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= 'DS真人下注记录：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= 'DS真人下注记录：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
	}
	
	if ($cw){
		if (in_array('cqk', $cw)){
			$params = array(':adddate' => $time);
			$sql = 'delete from huikuan where status <> 0 and adddate <= :adddate';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			$params = array(':m_make_time' => $time);
			$sql = 'delete from k_money where status <> 2 and m_make_time <= :m_make_time';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count += $stmt->rowCount();
			if ($count){
				$meg .= '存取款：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '存取款：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('lishi', $cw)){
			$params = array(':addtime' => $time);
			$sql = 'delete from mydata3_db.save_user where addtime <= :addtime';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '会员历史余额：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '会员历史余额：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('live', $cw))
		{
			$params = array(':creationTime' => $time);
			$sql = 'delete from agaccounttransfer where creationTime <= :creationTime';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '真人额度记录：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '真人额度记录：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('fs', $cw)){
			$params = array(':fs_uptime' => $time);
			$sql = 'delete from fs_account where fs_uptime <= :fs_uptime';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '返水记录：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '返水记录：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('ed', $cw))
		{
			$params = array(':creationTime' => $time);
			$sql = 'delete from k_money_log where creationTime <= :creationTime';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '额度记录：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '额度记录：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('livezz', $cw)){
			$params = array(':zz_time' => $time);
			$sql = 'delete from ag_zhenren_zz where zz_time <= :zz_time';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= '真人转账记录：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= '真人转账记录：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('hg_live', $cw)){
			$params = array(':TransactTime' => $time);
			$sql = 'delete from hgtransferdetail where TransactTime <= :TransactTime';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= 'HG真人额度记录：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= 'HG真人额度记录：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('bb_live', $cw)){
			$params = array(':CreateTime' => $time);
			$sql = 'delete from bbtransferdetail where CreateTime <= :CreateTime';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= 'BBIN真人额度记录：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= 'BBIN真人额度记录：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
		
		if (in_array('mg_live', $cw)){
			$params = array(':creationTime' => $time);
			$sql = 'delete from mgaccounttransfer where creationTime <= :creationTime';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count){
				$meg .= 'MG真人额度记录：恭喜您，本次共删除：' . $count . ' 条记录！';
			}else{
				$meg .= 'MG真人额度记录：您的数据库已经优化好了，本次无记录删除！';
			}
			$meg .= '<br />';
		}
	}
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
  <html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
  <title>清除数据</title> 
  <link rel="stylesheet" href="../Images/CssAdmin.css"> 
  <script language="JavaScript" src="../../js/jquery.js"></script> 
  <script language="JavaScript" src="../../js/calendar.js"></script> 
  </head> 
  <body> 
  <br /><br /><br /><br /> 
  <form id="form1" name="form1" method="post" action="qcsj.php" onsubmit="return(confirm('您确定要清除一周前数据'))"> 
    <div align="center"> 
      <input type="submit" name="Submit" value="一键自动清除一周前数据" /> 
      <input name="hf_action" type="hidden" id="hf_action" value="ss" /> 
    </div> 
  </form> 
  <p align="center">一键自动清除数据，只会清除7天之前的所有采集来的数据和系统日志！</p> 
  <p align="center"><?=$msg;?></p> 
  <br /><br /> 
  <form id="form3" name="form3" method="post" action="qcsj.php" onsubmit="return checkdel();"> 
      <table width="100%" border="0"> 
          <tr> 
              <td align="right" width="10%">删除时间：</td> 
              <td width="90%">删除30天之前的数据</td> 
          </tr> 
          <tr> 
              <td align="right">删除彩种：</td> 
              <td> 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="tyds" />体育单式 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="tycg" />体育串关 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="lhc" />香港六合彩 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="cqssc" />重庆时时彩 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="gdklsf" />广东快乐10分 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="bjsc" />北京赛车PK拾 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="kl8" />北京快乐8 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="ssl" />上海时时乐 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="3d" />福彩3D 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="pl3" />排列三 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="live" />真人下注记录 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="hg_live" />HG真人下注记录 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="bb_live" />BBIN真人下注记录 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="mg_live" />MG真人下注记录 
                  <input name="cz[]" type="checkbox" checked="checked" id="cz[]" value="ds_live" />DS真人下注记录 
              </td> 
          </tr> 
          <tr> 
              <td align="right">删除财务：</td> 
              <td> 
                  <input name="cw[]" type="checkbox" checked="checked" id="cw[]" value="cqk" />存取款记录 
                  <input name="cw[]" type="checkbox" checked="checked" id="cw[]" value="lishi" />会员历史余额 
                  <input name="cw[]" type="checkbox" checked="checked" id="cw[]" value="live" />真人额度记录 
                  <input name="cw[]" type="checkbox" checked="checked" id="cw[]" value="fs" />返水记录 
                  <input name="cw[]" type="checkbox" checked="checked" id="cw[]" value="livezz" />真人转账记录 
                  <input name="cw[]" type="checkbox" checked="checked" id="cw[]" value="ed" />额度记录 
                  <input name="cw[]" type="checkbox" checked="checked" id="cw[]" value="hg_live" />HG真人额度记录 
                  <input name="cw[]" type="checkbox" checked="checked" id="cw[]" value="bb_live" />BBIN真人额度记录 
                  <input name="cw[]" type="checkbox" checked="checked" id="cw[]" value="mg_live" />MG真人额度记录 
              </td> 
          </tr> 
          <tr> 
              <td align="right"></td> 
              <td> 
                  <input name="hf_action" type="hidden" id="hf_action" value="del" /> 
                  <input name="Submit3" type="submit" id="Submit3" value="一键删除" /> 
              </td> 
          </tr> 
      </table> 
  </form> 
  <p align="center"><?=$meg;?></p> 
  </body> 
  </html>