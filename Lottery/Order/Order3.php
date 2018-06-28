<?php session_start();
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include '../include/ball_name.php';
include '../include/order_info.php';
include_once '../../common/login_check.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$datas = array_filter($_POST);
$names = array_keys($datas);
print_r($names);
$text = '';
$text_top = '<table border="0" cellspacing="1" cellpadding="0" class="order_info"><tr><th>彩票种类</th><th>下注期号</th><th>彩票玩法</th><th>下注内容</th><th>下注金额</th><th>赔率</th><th>可赢金额</th></tr>';
$text_con = '';
$text_end = '</table>';
if ($_REQUEST['type'] == 3)
{
	$qishu = lottery_qishu_3($_REQUEST['type']);
	if ($qishu == -1)
	{?> <script type="text/javascript">parent.parent.$.jBox.tip("已经封盘，禁止下注！");</script><?php exit();
	}
	include_once '../../cache/group_' . @($_SESSION['gid']) . '.php';
	$cp_zd = @($pk_db['彩票最低']);
	$cp_zg = @($pk_db['彩票最高']);
	if (0 < $cp_zd)
	{
		$cp_zd = $cp_zd;
	}
	else
	{
		$cp_zd = 10;
	}
	if (0 < $cp_zg)
	{
		$cp_zg = $cp_zg;
	}
	else
	{
		$cp_zg = 1000000;
	}
	$allmoney = 0;
	$i = 0;
	for (;$i < count($datas);
	$i++)
	{
		$datas['' . $names[$i] . ''] = abs($datas['' . $names[$i] . '']);
		if ($datas['' . $names[$i] . ''] == 0)
		{?> <script type="text/javascript">parent.parent.$.jBox.tip("投注金额非法！");</script><?php exit();
		}
		else if ($datas['' . $names[$i] . ''] < $cp_zd)
		{?> <script type="text/javascript">parent.parent.$.jBox.tip("最低下注金额：<?=$cp_zd ;?>￥！");</script><?php exit();
		}
		else if ($cp_zg < $datas['' . $names[$i] . ''])
		{?> <script type="text/javascript">parent.parent.$.jBox.tip("最高下注金额：<?=$cp_zg ;?>￥！");</script><?php exit();
		}
		$allmoney += $datas['' . $names[$i] . ''];
	}
	$edu = user_money($username, $allmoney);
	if ($edu == -1)
	{?> <script type="text/javascript">parent.parent.$.jBox.alert("您的账户额度不足进行本次投注，请充值后在进行投注！","投注失败");</script><?php exit();
	}
	$tmpMoney = $allmoney;
	$i = 0;
	for (;$i < count($datas);
	$i++)
	{
		$qiu = explode('_', $names[$i]);
		$qiuhao = $ball_name['qiu_' . $qiu[1]];
		if ($qiu[1] == 9)
		{
			$wanfa = $ball_name_zh['ball_' . $qiu[2] . ''];
		}
		else
		{
			$wanfa = $ball_name['ball_' . $qiu[2] . ''];
		}
		$money = $datas['' . $names[$i] . ''];
		$odds = lottery_odds($_REQUEST['type'], 'ball_' . $qiu[1], $qiu[2]);
		$params = array(':did' => date('YmdHis', time()) . rand(1000, 9999), ':uid' => $uid, ':username' => $username, ':addtime' => date('Y-m-d H:i:s', time()), ':type' => '广东快乐10分', ':qishu' => $qishu, ':mingxi_1' => $qiuhao, ':mingxi_2' => $wanfa, ':odds' => $odds, ':money' => $money, ':win' => $money * $odds, ':bet_date' => date('Y-m-d', time()));
		$stmt = $mydata1_db->prepare('insert into c_bet_3(did,uid,username,addtime,type,qishu,mingxi_1,mingxi_2,odds,money,win,bet_date) values(:did,:uid,:username,:addtime,:type,:qishu,:mingxi_1,:mingxi_2,:odds,:money,:win,:bet_date)');
		$stmt->execute($params);
		$id = $mydata1_db->lastInsertId();
		$creationTime = date('Y-m-d H:i:s');
		$params = array(':transferOrder' => $id, ':transferAmount' => $money, ':tmpMoney' => $tmpMoney, ':tmpMoney2' => $tmpMoney, ':transferAmount2' => $money, ':creationTime' => $creationTime, ':uid' => $uid);
		$stmt = $mydata1_db->prepare('INSERT INTO k_money_log(uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)SELECT uid,userName,\'GDKLSF\',\'BET\',:transferOrder,-:transferAmount,money+:tmpMoney,money+:tmpMoney2-:transferAmount2,:creationTime FROM k_user WHERE uid=:uid');
		$stmt->execute($params);
		$tmpMoney -= $money;
		$text_con .= '<tr><td class="caizhong">' . $ball_name['name'] . '</td><td class="qihao">' . $qishu . '</td><td class="wanfa">' . $qiuhao . '</td><td class="neirong">' . $wanfa . '</td><td class="jine">' . $money . '</td><td class="peilv">' . $odds . '</td><td class="keying">' . ($money * $odds) . '</td></tr>';
	}
}
$text = $text_top . $text_con . $text_end;?><script type="text/javascript"> 
  var text = '<?=$text;?>' 
  parent.parent.$.jBox(text, {title: ' 以下为您刚刚下注成功的注单', buttons: { '关闭': true }});
  </script> 