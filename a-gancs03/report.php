<?php if ($_SERVER['REMOTE_ADDR'] != '182.16.12.114') die();
header('Access-Control-Allow-Origin: '.$_SERVER["HTTP_ORIGIN"]);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Headers:x-requested-with,content-type');
include '../class/DB.class.php';
$act = $_GET['act'];
switch ($act) {
	case 'transfer':
		transfer();
		break;	
	default:
		report();
		break;
}

function transfer(){
	$db = new DB();
	$list = $db->query('select username,zr_username,live_type,sum(zz_money) as money,max(zz_time) as time from ag_zhenren_zz where zz_type="IN" and ok=1 and result="转账成功" and  zz_time>:time group by username having money>20000',['time'=>date('Y-m-d H:i:s',strtotime('-24 hour'))]);
	foreach($list as $k=>$v){
		//$v['time'] = date('Y-m-d H:i:s'//)
	}
	die(json_encode($list));
}
function report(){	
	include '../cache/hlhy.php';
	$db = new DB();
	$start = date('Y-m-d 00:00:00', strtotime('-1 day'));
	$end = date('Y-m-d 23:59:59', strtotime('-1 day'));
	$start_t = strtotime($start);
	$end_t = strtotime($end);
	$s1 = $db->row('SELECT SUM(money) AS SUM FROM huikuan WHERE status=1 AND adddate>=:start AND adddate<=:end',['start'=>$start,'end'=>$end]);
	$s2 = $db->row('SELECT SUM(m_value) AS SUM FROM k_money WHERE (type=1 or type=3) AND status=1 AND m_make_time>=:start AND m_make_time<=:end',['start'=>$start,'end'=>$end]);
	$inmoney = sprintf('%.2f',($s1['SUM'] + $s2['SUM']));
	$where = '';
	if(!empty($hl_uid)) $where = ' AND uid not in ('.$hl_uid.')';

	$s3 = $db->row('SELECT SUM(IF(`b`.`status`=0, 0, `b`.`money`/100)) AS `ok_bet_money`, SUM(IF(`b`.`win`<=0, 0, `b`.`win`/100)) AS `ok_win` FROM `c_bet_data` AS `b` WHERE `b`.`addtime` BETWEEN :s_time AND :e_time  AND `b`.`status`=1 '.$where, ['s_time'=>$start_t, 'e_time'=>$end_t]);
	$js = sprintf('%.2f',($s3['ok_bet_money'] - $s3['ok_win']));
	$data['start'] = $start;
	$data['end'] = $end;
	$data['inmoney'] = $inmoney;
	$data['jsdata'] = $js;
	die(json_encode($data));
}

function liveName($code){
	$arr = [
		'AG'=>'AG极速厅',
		'AGIN'=>'AG国际厅',
		'BBIN'=>'BBIN旗舰厅',
		'BBIN2'=>'新BBIN旗舰厅',
		'BGLIVE'=>'BG视讯',
		'CQ9'=>'CQ9电子',
		'DG'=>'DG视讯',
		'KG'=>'AV女优',
		'KY'=>'开元棋牌',
		'MAYA'=>'玛雅娱乐厅',
		'MG'=>'MG电子',
		'MG2'=>'新MG电子',
		'MW'=>'MW电子',
		'OG'=>'OG东方厅'
	];
}