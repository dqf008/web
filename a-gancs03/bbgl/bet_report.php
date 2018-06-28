<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('bbgl');
if (intval($_GET['action']) != 1){
	if (!isset($_GET['s_time']) || ($_GET['s_time'] == '')){
		$_GET['s_time'] = date('Y-m-d', strtotime('-2 days'));
	}
}
$_LIVE = include('../../cj/include/live.php');
$_GET['caizhong'] = in_array($_GET['caizhong'], array('LIVE', 'GAME'))?$_GET['caizhong']:'ALL';

if(!empty($_GET['act']) && $_GET['act'] == 'list'){
	$uid = 0;
	if(!empty($_POST['name'])){
		$stmt = $mydata1_db->prepare('select uid,username from k_user where username=:username');
		$stmt->execute([':username'=>trim($_POST['name'])]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if($res) $uid = $res['uid'];
	}
	$start = empty($_POST['date'][0])?time():strtotime($_POST['date'][0]);
	$end = empty($_POST['date'][1])?time():strtotime($_POST['date'][1]);
	$list = [];
	$params[':s_time'] = $start;
	$params[':e_time'] = $end;
	foreach($_LIVE as $key=>$val){
		$params[':pid'] = $key;
		$sql = 'SELECT SUM(`r`.`bet_amount`) AS `bet_amount`, SUM(`r`.`net_amount`) AS `net_amount`, SUM(`r`.`valid_amount`) AS `valid_amount`, SUM(`r`.`rows_num`) AS `rows_num` FROM `daily_report` AS `r` WHERE `r`.`platform_id`=:pid AND `r`.`report_date` BETWEEN :s_time AND :e_time';
		if(!empty($_POST['name'])){
			$params[':uid'] = $uid;
			$sql .= ' AND uid=:uid';
		}else{
			include '../../cache/hlhy.php';
			if($hl_uid != '') $sql .= ' AND uid not in ('.$hl_uid.') ';
		}
	    $stmt = $mydata1_db->prepare($sql);
	    $stmt->execute($params);
	    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
	    $rows['bet_amount'] = $rows['bet_amount']?sprintf('%.2f',$rows['bet_amount']/100):'0.00';
	    $rows['net_amount'] = $rows['net_amount']?sprintf('%.2f',$rows['net_amount']/100):'0.00';
	    $rows['valid_amount'] = $rows['valid_amount']?sprintf('%.2f',$rows['valid_amount']/100):'0.00';
	    $rows['payout'] = sprintf('%.2f',$rows['valid_amount'] + $rows['net_amount']);
	    $rows['net_amount'] = sprintf('%.2f',-$rows['net_amount']);
	    $rows['rows_num'] = (int)$rows['rows_num'];
	    $rows['name'] = $val[1];
	    $rows['id'] = $key;
	    $list[] = $rows;
	}
	die(json_encode($list));
}
if(!empty($_GET['act']) && $_GET['act'] == 'LotteryList'){
	$_GAME = array(
		'体育单式' => array(
			'体育单式',
			'SELECT SUM(IF(`b`.`status`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`status`=0, 0, `b`.`bet_money`)) AS `ok_bet_money`, SUM(IF(`b`.`status`=0, 0, `b`.`win`+`b`.`fs`)) AS `ok_win`, SUM(IF(`b`.`status`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`status`=0, `b`.`bet_money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`status`=0, `b`.`bet_win`+`b`.`fs`, 0)) AS `no_win` FROM `k_bet` AS `b` WHERE `b`.`lose_ok`=1 AND `b`.`status` BETWEEN 0 AND 8 AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
			'LEFT OUTER JOIN `k_user` AS `u` ON `u`.`uid`=`b`.`uid` WHERE `u`.`username`=:username AND'
		),
		'体育串关' => array(
			'体育串关',
			'SELECT SUM(IF(`b`.`status` IN (0, 2), 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`status` IN (0, 2), 0, `b`.`bet_money`)) AS `ok_bet_money`, SUM(IF(`b`.`status` IN (0, 2), 0, `b`.`win`+`b`.`fs`)) AS `ok_win`, SUM(IF(`b`.`status` IN (0, 2), 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`status` IN (0, 2), `b`.`bet_money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`status` IN (0, 2), `b`.`bet_win`+`b`.`fs`, 0)) AS `no_win` FROM `k_bet_cg_group` AS `b` WHERE `b`.`gid`>0 AND `b`.`status` BETWEEN 0 AND 4 AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
			'LEFT OUTER JOIN `k_user` AS `u` ON `u`.`uid`=`b`.`uid` WHERE `u`.`username`=:username AND'
		),
		'重庆时时彩' => array(
			'重庆时时彩',
			'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet` AS `b` WHERE `b`.`type`=\'重庆时时彩\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
			'WHERE `b`.`username`=:username AND',
		),
        '天津时时彩' => array(
            '天津时时彩',
            'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet` AS `b` WHERE `b`.`type`=\'天津时时彩\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        '新疆时时彩' => array(
            '新疆时时彩',
            'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet` AS `b` WHERE `b`.`type`=\'新疆时时彩\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
		'广东快乐10分' => array(
			'广东快乐10分',
			'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_3` AS `b` WHERE `b`.`type`=\'广东快乐10分\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
			'WHERE `b`.`username`=:username AND',
		),
        '重庆快乐10分' => array(
            '重庆快乐10分',
            'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_3` AS `b` WHERE `b`.`type`=\'重庆快乐10分\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        '天津快乐10分' => array(
            '天津快乐10分',
            'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_3` AS `b` WHERE `b`.`type`=\'天津快乐10分\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        '湖南快乐10分' => array(
            '湖南快乐10分',
            'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_3` AS `b` WHERE `b`.`type`=\'湖南快乐10分\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        '山西快乐10分' => array(
            '山西快乐10分',
            'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_3` AS `b` WHERE `b`.`type`=\'山西快乐10分\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        '云南快乐10分' => array(
            '云南快乐10分',
            'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_3` AS `b` WHERE `b`.`type`=\'云南快乐10分\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
		'GDSYXW'=>array(
            '广东11选5',
            'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_choose5` AS `b` WHERE `b`.`type`=\'GDSYXW\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'SDSYXW'=>array(
            '山东11选5',
            'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_choose5` AS `b` WHERE `b`.`type`=\'SDSYXW\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'FJSYXW'=>array(
            '福建11选5',
            'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_choose5` AS `b` WHERE `b`.`type`=\'FJSYXW\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'BJSYXW'=>array(
            '北京11选5',
            'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_choose5` AS `b` WHERE `b`.`type`=\'BJSYXW\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'AHSYXW'=>array(
            '安徽11选5',
            'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_choose5` AS `b` WHERE `b`.`type`=\'AHSYXW\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'jsk3' => array(
            '江苏快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'jsk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'fjk3' => array(
            '江苏快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'fjk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'gxk3' => array(
            '广西快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'ahk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'ahk3' => array(
            '安徽快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'ahk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'shk3' => array(
            '上海快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'shk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'hbk3' => array(
            '湖北快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'hbk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'hebk3' => array(
            '河北快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'hebk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'jlk3' => array(
            '吉林快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'jlk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'gzk3' => array(
            '贵州快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'gzk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'bjk3' => array(
            '北京快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'bjk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'gsk3' => array(
            '甘肃快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'gsk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'nmgk3' => array(
            '内蒙古快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'nmgk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'jxk3' => array(
            '江西快3',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'jxk3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
        'FFK3' => array(
            '分分快3',
            'SELECT SUM(IF(`b`.`status`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`status`=0, 0, `b`.`money`/100)) AS `ok_bet_money`, SUM(IF(`b`.`status`=0 OR `b`.`win`<=0, 0, `b`.`win`/100)) AS `ok_win`, SUM(IF(`b`.`status`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`status`=0, `b`.`money`/100, 0)) AS `no_bet_money`, SUM(IF(`b`.`status`=0, `b`.`win`/100, 0)) AS `no_win` FROM `c_bet_data` AS `b` WHERE `b`.`addtime` BETWEEN :s_time AND :e_time AND `b`.`type`=\'FFK3\' AND `b`.`status` BETWEEN 0 AND 1',
            'LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`b`.`uid` WHERE `u`.`username`=:username AND'
        ),
        'SFK3' => array(
            '超级快3',
            'SELECT SUM(IF(`b`.`status`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`status`=0, 0, `b`.`money`/100)) AS `ok_bet_money`, SUM(IF(`b`.`status`=0 OR `b`.`win`<=0, 0, `b`.`win`/100)) AS `ok_win`, SUM(IF(`b`.`status`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`status`=0, `b`.`money`/100, 0)) AS `no_bet_money`, SUM(IF(`b`.`status`=0, `b`.`win`/100, 0)) AS `no_win` FROM `c_bet_data` AS `b` WHERE `b`.`addtime` BETWEEN :s_time AND :e_time AND `b`.`type`=\'SFK3\' AND `b`.`status` BETWEEN 0 AND 1',
            'LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`b`.`uid` WHERE `u`.`username`=:username AND'
        ),
        'WFK3' => array(
            '好运快3',
            'SELECT SUM(IF(`b`.`status`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`status`=0, 0, `b`.`money`/100)) AS `ok_bet_money`, SUM(IF(`b`.`status`=0 OR `b`.`win`<=0, 0, `b`.`win`/100)) AS `ok_win`, SUM(IF(`b`.`status`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`status`=0, `b`.`money`/100, 0)) AS `no_bet_money`, SUM(IF(`b`.`status`=0, `b`.`win`/100, 0)) AS `no_win` FROM `c_bet_data` AS `b` WHERE `b`.`addtime` BETWEEN :s_time AND :e_time AND `b`.`type`=\'WFK3\' AND `b`.`status` BETWEEN 0 AND 1',
            'LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`b`.`uid` WHERE `u`.`username`=:username AND'
        ),
		'北京赛车PK拾' => array(
			'北京赛车PK拾',
			'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_3` AS `b` WHERE `b`.`type`=\'北京赛车PK拾\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
			'WHERE `b`.`username`=:username AND',
		),
		'幸运飞艇' => array(
			'幸运飞艇',
			'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_3` AS `b` WHERE `b`.`type`=\'幸运飞艇\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
			'WHERE `b`.`username`=:username AND',
		),
        'pcdd' => array(
            'PC蛋蛋',
            'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'pcdd\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
            'WHERE `b`.`username`=:username AND',
        ),
		'kl8' => array(
			'北京快乐8',
			'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'kl8\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
			'WHERE `b`.`username`=:username AND',
		),
		'ssl' => array(
			'上海时时乐',
			'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'ssl\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
			'WHERE `b`.`username`=:username AND',
		),
		'3d' => array(
			'福彩3D',
			'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'3d\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
			'WHERE `b`.`username`=:username AND',
		),
		'pl3' => array(
			'排列三',
			'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'pl3\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
			'WHERE `b`.`username`=:username AND',
		),
		'qxc' => array(
			'七星彩',
			'SELECT SUM(IF(`b`.`bet_ok`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`bet_ok`=0, 0, `b`.`win`+`b`.`money`)) AS `ok_win`, SUM(IF(`b`.`bet_ok`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`bet_ok`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `lottery_data` AS `b` WHERE `b`.`atype`=\'qxc\' AND `b`.`bet_time` BETWEEN :s_time AND :e_time',
			'WHERE `b`.`username`=:username AND',
		),
	    'JSSC' => array(
	        '极速赛车',
	        'SELECT SUM(IF(`b`.`status`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`status`=0, 0, `b`.`money`/100)) AS `ok_bet_money`, SUM(IF(`b`.`status`=0 OR `b`.`win`<=0, 0, `b`.`win`/100)) AS `ok_win`, SUM(IF(`b`.`status`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`status`=0, `b`.`money`/100, 0)) AS `no_bet_money`, SUM(IF(`b`.`status`=0, `b`.`win`/100, 0)) AS `no_win` FROM `c_bet_data` AS `b` WHERE `b`.`addtime` BETWEEN :s_time AND :e_time AND `b`.`type`=\'JSSC\' AND `b`.`status` BETWEEN 0 AND 1',
	        'LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`b`.`uid` WHERE `u`.`username`=:username AND'
	    ),
	    'JSSSC' => array(
	        '极速时时彩',
	        'SELECT SUM(IF(`b`.`status`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`status`=0, 0, `b`.`money`/100)) AS `ok_bet_money`, SUM(IF(`b`.`status`=0 OR `b`.`win`<=0, 0, `b`.`win`/100)) AS `ok_win`, SUM(IF(`b`.`status`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`status`=0, `b`.`money`/100, 0)) AS `no_bet_money`, SUM(IF(`b`.`status`=0, `b`.`win`/100, 0)) AS `no_win` FROM `c_bet_data` AS `b` WHERE `b`.`addtime` BETWEEN :s_time AND :e_time AND `b`.`type`=\'JSSSC\' AND `b`.`status` BETWEEN 0 AND 1',
	        'LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`b`.`uid` WHERE `u`.`username`=:username AND'
	    ),
		'JSLH' => array(
			'极速六合',
	        'SELECT SUM(IF(`b`.`status`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`status`=0, 0, `b`.`money`/100)) AS `ok_bet_money`, SUM(IF(`b`.`status`=0 OR `b`.`win`<=0, 0, `b`.`win`/100)) AS `ok_win`, SUM(IF(`b`.`status`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`status`=0, `b`.`money`/100, 0)) AS `no_bet_money`, SUM(IF(`b`.`status`=0, `b`.`win`/100, 0)) AS `no_win` FROM `c_bet_data` AS `b` WHERE `b`.`addtime` BETWEEN :s_time AND :e_time AND `b`.`type`=\'JSLH\' AND `b`.`status` BETWEEN 0 AND 1',
	        'LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`b`.`uid` WHERE `u`.`username`=:username AND'
		),
	    '六合彩' => array(
	        '香港六合彩',
	        'SELECT SUM(IF(`b`.`checked`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`checked`=0, 0, `b`.`sum_m`)) AS `ok_bet_money`, SUM(IF(`b`.`checked`=0, 0, CASE `b`.`bm` WHEN 1 THEN `b`.`sum_m`*`b`.`rate`+`b`.`sum_m`*`b`.`user_ds`/100 WHEN 2 THEN `b`.`sum_m` ELSE `b`.`sum_m`*`b`.`user_ds`/100 END)) AS `ok_win`, SUM(IF(`b`.`checked`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`checked`=0, `b`.`sum_m`, 0)) AS `no_bet_money`, SUM(IF(`b`.`checked`=0, `b`.`sum_m`*`b`.`rate`+`b`.`sum_m`*`b`.`user_ds`/100, 0)) AS `no_win` FROM `mydata2_db`.`ka_tan` AS `b` WHERE `b`.`adddate` BETWEEN :s_time AND :e_time',
	        'WHERE `b`.`username`=:username AND'
	    ),
	);
	//ini_set('display_errors',1);
	$list = [];
	$uid = 0;
	$username = '';
	if(!empty($_POST['name'])){
		$stmt = $mydata1_db->prepare('select uid,username from k_user where username=:username');
		$stmt->execute([':username'=>trim($_POST['name'])]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if($res){
			$uid = $res['uid'];
			$username = $res['username'];
		}
	}
	$start = empty($_POST['date'][0])?time():strtotime($_POST['date'][0]);
	$end = empty($_POST['date'][1])?time():strtotime($_POST['date'][1]);
	$s_time = date('Y-m-d 00:00:00', $start);
	$e_time = date('Y-m-d 23:59:59', $end);
	foreach($_GAME as $key=>$val){
		$params = array();
	    $params[':s_time'] = $s_time;
	    $params[':e_time'] = $e_time;
		if($key=='六合彩'){
			$params[':s_time'] = date('Y-m-d H:i:s', strtotime($s_time)+(12*3600));
			$params[':e_time'] = date('Y-m-d H:i:s', strtotime($e_time)+(12*3600));
		}else if(in_array($key, ['JSSC', 'JSSSC', 'JSLH','FFK3','SFK3','WFK3'])){
	        $params[':s_time'] = strtotime($s_time);
	        $params[':e_time'] = strtotime($e_time);
	    }
		if(!empty($_POST['name'])){
			if(in_array($key, ['kl8','ssl','3d','pl3','qxc','六合彩'])){
				$params[':username'] = $username;
				$val[1] .= ' AND `b`.`username`=:username ';
			}else{
				$params[':uid'] = $uid;
				$val[1] .= ' AND `b`.uid=:uid';
			}
		}else{
			include '../../cache/hlhy.php';
			if($hl_uid != ''){
				if(in_array($key, ['kl8','ssl','3d','pl3','qxc','六合彩'])){
					foreach ($hlhy as $k=>$v) $hlhy[$k] = '"'.$v.'"';

					$val[1] .= ' AND `b`.`username` not in ('.implode(',',$hlhy).') ';
				}else{
					$val[1] .= ' AND `b`.uid not in ('.$hl_uid.') ';
				}
			}
		}
		try{
			$stmt = $mydata1_db->prepare($val[1]);
			$stmt->execute($params);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		}catch(Exception $e){
			echo $val[1];
			print_r($params);exit;
		}
	    $rows['name'] = $val[0];
	    $rows['id'] = $key;
	    $rows['ok_rows_num'] = (int)$rows['ok_rows_num'];
	    $rows['no_rows_num'] = (int)$rows['no_rows_num'];
	    $rows['ok_bet_money'] = $rows['ok_bet_money']?sprintf('%.2f',$rows['ok_bet_money']):'0.00';
	    $rows['no_bet_money'] = $rows['no_bet_money']?sprintf('%.2f',$rows['no_bet_money']):'0.00';
	    $rows['ok_win'] = $rows['ok_win']?sprintf('%.2f',$rows['ok_win']):'0.00';
	    $rows['no_win'] = $rows['no_win']?sprintf('%.2f',$rows['no_win']):'0.00';
	    $rows['ok_result'] = sprintf('%.2f',$rows['ok_bet_money']-$rows['ok_win']);
	    $rows['sum_num'] = $rows['ok_rows_num'] + $rows['no_rows_num'];
	    $rows['sum_money'] = sprintf('%.2f',$rows['ok_bet_money'] + $rows['no_bet_money']);
	    $list[] = $rows;
	}
	die(json_encode($list));
}
?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	  <title>会员下注注单汇总</title>
	  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize@0.4.0/modern-normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/element-ui@2.2.0/lib/theme-chalk/index.min.css">
    <style>
        body {
    padding: 8px;
    font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
}

[v-cloak] {
    display: none !important
}
.el-date-editor.el-input{
	width:130px;
}
.el-table div.cell{
	text-align: center;
}
.el-table .warning-row {
    background: #009900;
  }

  .el-table .success-row {
    background: #f0f9eb;
  }
  .el-table .el-button--text{
  	padding: 0;
  }
  .header{
  	background:#3c4c6b !important;
  }
    </style>
  </head>
  <body>
  <div id="app">
	<el-form :inline="true" size="mini" class="demo-form-inline">
	  <el-form-item label="">
	    <el-select v-model="form.type">
	      <el-option label="全部" value="ALL"></el-option>
	      <el-option label="真人娱乐" value="LIVE"></el-option>
	      <el-option label="彩票体育" value="GAME"></el-option>
	    </el-select>
	  </el-form-item>
	  <el-form-item label="会员：">
	    <el-input v-model="form.name" placeholder="会员帐号" @keyup.enter.native="submit()"></el-input>
	  </el-form-item>
	<el-form-item label="日期：">
		  <el-date-picker
		  value-format="yyyy-MM-dd"
	      v-model="form.date"
	      type="daterange"
	      range-separator="至"
	      start-placeholder="开始日期"
	      end-placeholder="结束日期">
	    </el-date-picker>
    </el-form-item>
	  <el-form-item>
	    <el-button type="primary" @click="submit()" >查询</el-button>
	  </el-form-item>
	</el-form>
	<el-table v-show="form.type !='GAME'" show-summary :data="live" border style="width:100%" :cell-style="CallColor" size="mini">
		<el-table-column label="真人娱乐下注汇总"  class-name="header">
			<el-table-column label="真人娱乐" width="180">
			  <template slot-scope="scope">
				{{ scope.row.name }}
				(<el-button @click="info(scope.row.id)" type="text">详情</el-button>)
			  </template>
			</el-table-column>
			<el-table-column prop="rows_num" label="注单数" width="180"></el-table-column>
			<el-table-column prop="bet_amount" label="下注金额"></el-table-column>
			<el-table-column prop="payout" label="派彩金额"></el-table-column>
			<el-table-column prop="valid_amount" label="有效投注额"></el-table-column>
			<el-table-column prop="net_amount" label="盈亏"></el-table-column>
		</el-table-column>
	  </el-table>
		<br>
	  <el-table v-show="form.type !='LIVE'" :data="game" show-summary  border style="width:100%"  :cell-style="CallColor2" size="mini">
		<el-table-column label="彩票体育下注汇总" class-name="header">
			<el-table-column prop="name" label="彩种">
				<template slot-scope="scope">
				{{ scope.row.name }}
				(<el-button @click="info2(scope.row.id)" type="text">详情</el-button>)
			  </template>
			</el-table-column>
			 <el-table-column label="已结算">
				<el-table-column prop="ok_rows_num" label="注单数"></el-table-column>
				<el-table-column prop="ok_bet_money" label="下注"></el-table-column>
				<el-table-column prop="ok_win" label="结果"></el-table-column>
				<el-table-column prop="ok_result" label="盈亏"></el-table-column>
			 </el-table-column>
			 <el-table-column label="未结算">
				<el-table-column prop="no_rows_num" label="注单数"></el-table-column>
				<el-table-column prop="no_bet_money" label="下注"></el-table-column>
				<el-table-column prop="no_win" label="结果"></el-table-column>
			 </el-table-column>
			 <el-table-column label="合计(已结算+未结算)">
				<el-table-column prop="sum_num" label="注单数"></el-table-column>
				<el-table-column prop="sum_money" label="下注"></el-table-column>
			 </el-table-column>
		</el-table-column>
	  </el-table>
  </div>

  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="font12" style="margin-top:5px;line-height:20px;">
	  <tr>
		  <td>
			  <p>温馨提醒：</p>
			  <p style="color:#f00">1、真人下注非实时结果，需要等待系统生成报表后才能查询！</p>
			  <p>2、报表时间为美东时间，请注意时间差。</p>
		  </td>
	  </tr>
  </table>
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/element-ui@2.2.0/lib/index.min.js"></script>
	  <script type="text/javascript">
	        var vm = new Vue({
	            data: {
	            	form: {
	            		type:'ALL',
	            		name:'',
	            		date:[
	            			'<?=date('Y-m-d',strtotime('-2 day'))?>',
	            			'<?=date('Y-m-d')?>'
	            		]
	            	},
	            	live: [],
	            	game: [],
	            },
	            methods: {
	                tableRowClassName({row, rowIndex}) {
				        if (row.net_amount < 0) {
				          return 'warning-row';
				        }
				        return '';
				      },
					  CallColor({row, column, rowIndex, columnIndex}){
						  if(columnIndex == 5){
							  if(row.net_amount <= 0) return {color:'#009900'};
							  else return {color:'#FF0000'};
						  }

					  },
					  CallColor2({row, column, rowIndex, columnIndex}){
						  if(columnIndex == 4){
							  if(row.ok_result <= 0) return {color:'#009900'};
							  else return {color:'#FF0000'};
						  }

					  },
				      submit(){
				      	_self = this;
						this.live = [];
						this.game = [];
		               $.post('?act=list', this.form, function(json){
		               		json = JSON.parse(json)
			               	_self.live = json;
		               });
		               $.post('?act=LotteryList', this.form, function(json){
			               	json = JSON.parse(json);
			               	_self.game = json;
		               });
				      },
				      getSummaries(param){
				      	const { columns, data } = param;
				        const sums = [];
				        columns.forEach((column, index) => {
				          if (index === 0) {
				            sums[index] = '真人娱乐下注合计';
				            return;
				          }
				          const values = data.map(item => Number(item[column.property]));
				          if (!values.every(value => isNaN(value))) {
				            sums[index] = values.reduce((prev, curr) => {
				              const value = Number(curr);
				              if (!isNaN(value)) {
				                return prev + curr;
				              } else {
				                return prev;
				              }
				            }, 0);
				            if(index !== 1)sums[index] = sums[index].toFixed(2)
				          } else {
				            sums[index] = 'N/A';
				          }
				        });
				        return sums;
				      },
				      info(id){
				      	window.open('zrorder.php?username='+this.form.name+'&action=1&caizhong='+id+'&s_time='+this.form.date[0]+'&e_time='+this.form.date[1],'_self');
				      },
				      info2(id){
				      	window.open('allorder.php?username='+this.form.name+'&action=1&caizhong='+id+'&s_time='+this.form.date[0]+'&e_time='+this.form.date[1],'_self');
				      }
	            },
	            created: function() {
	            	this.submit();
	            }
	        }).$mount('#app');
        </script>
  </body>
  </html>