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
?> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
	  <title>Welcome</title> 
	  <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" /> 
	  <script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
	  <script language="JavaScript" src="/js/calendar.js"></script> 
  </head> 
  <body> 
  <div id="pageMain"> 
	  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="font12" style="border:1px solid #798EB9;"> 
		  <form name="form1" method="get" action=""> 
		  <tr bgcolor="#FFFFFF"> 
          <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;
             <select name="caizhong" id="caizhong"> 
			  <option value="ALL" <?=$_GET['caizhong']=='ALL' ? 'selected' : ''?>>全部</option>
              <option value="LIVE" <?=$_GET['caizhong']=='LIVE' ? 'selected' : ''?>>真人娱乐</option>
              <option value="GAME" <?=$_GET['caizhong']=='GAME' ? 'selected' : ''?>>彩票体育</option>
            </select> 
            &nbsp;&nbsp;会员：<input name="username" type="text" id="username" value="<?=$_GET['username']?>" size="15">
            &nbsp;&nbsp;日期：
            <input name="s_time" type="text" id="s_time" value="<?=$_GET['s_time']?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />
            ~
            <input name="e_time" type="text" id="e_time" value="<?=$_GET['e_time']?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />&nbsp;&nbsp;
            <input name="action" id="action" type="hidden" value="1">
                  &nbsp;<input name="find" type="submit" id="find" value="汇总"/> 
			  </td> 
		  </tr> 
		  </form> 
	  </table>
<?php 
if(in_array($_GET['caizhong'], array('ALL', 'LIVE'))){
?>	  
	<table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;line-height:20px;" bgcolor="#798EB9"> 
		  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
			  <td colspan="6">真人娱乐下注汇总</td> 
		  </tr>
            <tr align="center" style="background-color:#aee0f7;"> 
              <td>真人娱乐</td> 
              <td>注单数</td> 
              <td>下注金额</td> 
              <td>派彩金额</td> 
              <td>有效投注额</td> 
              <td>盈亏</td> 
          </tr>
<?php
$params = array();
$params[':s_time'] = isset($_GET['s_time'])&&!empty($_GET['s_time'])?strtotime($_GET['s_time']):time();
$params[':e_time'] = isset($_GET['e_time'])&&!empty($_GET['e_time'])?strtotime($_GET['e_time']):time();
$params[':pid'] = -1;
$SUM = array(
	'bet_amount' => 0,
	'net_amount' => 0,
	'valid_amount' => 0,
	'rows_num' => 0,
);
foreach($_LIVE as $key=>$val){
	$params[':pid'] = $key;
	$sql = 'SELECT SUM(`r`.`bet_amount`) AS `bet_amount`, SUM(`r`.`net_amount`) AS `net_amount`, SUM(`r`.`valid_amount`) AS `valid_amount`, SUM(`r`.`rows_num`) AS `rows_num` FROM `daily_report` AS `r` WHERE `r`.`platform_id`=:pid AND `r`.`report_date` BETWEEN :s_time AND :e_time';
	if(isset($_GET['username'])&&!empty($_GET['username'])){
		$params[':username'] = $_GET['username'];
		$sql = str_replace('WHERE', 'LEFT OUTER JOIN `k_user` AS `u` ON `u`.`uid`=`r`.`uid` WHERE `u`.`username`=:username AND', $sql);
	}
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetch();
	$SUM['bet_amount']+= $rows['bet_amount'];
	$SUM['net_amount']+= $rows['net_amount'];
	$SUM['valid_amount']+= $rows['valid_amount'];
	$SUM['rows_num']+= $rows['rows_num'];
?>
            <tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#ffffff'" style="background-color:#ffffff;"> 
                 <td><?php echo $val[1]; ?> <a href="zrorder.php?caizhong=<?php echo $key; ?>&amp;username=<?php echo $_GET['username']; ?>&amp;s_time=<?php echo $_GET['s_time']; ?>&amp;e_time=<?php echo $_GET['e_time']; ?>&amp;action=1">(详情)</a></td> 
                 <td><?php echo sprintf("%.0f", $rows['rows_num']); ?></td> 
                 <td><?php echo sprintf("%.2f", $rows['bet_amount']/100); ?></td> 
                 <td><?php echo sprintf("%.2f", ($rows['bet_amount']+$rows['net_amount'])/100); ?></td> 
                 <td><?php echo sprintf("%.2f", $rows['valid_amount']/100); ?></td> 
                 <td><span style="color:<?php echo $rows['net_amount']<0 ? '#FF0000' : '#009900';?>;"><?php echo sprintf('%.2f', -1*$rows['net_amount']/100); ?></span></td> 
            </tr>
<?php } ?>
            <tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#ffffff'" style="background-color:#ffffff;"> 
                 <td>真人娱乐下注合计 <a href="zrorder.php?caizhong=ALL&amp;username=<?php echo $_GET['username']; ?>&amp;s_time=<?php echo $_GET['s_time']; ?>&amp;e_time=<?php echo $_GET['e_time']; ?>&amp;action=1">(详情)</a></td> 
                 <td><?php echo sprintf("%.0f", $SUM['rows_num']); ?></td> 
                 <td><?php echo sprintf("%.2f", $SUM['bet_amount']/100); ?></td> 
                 <td><?php echo sprintf("%.2f", ($SUM['bet_amount']+$SUM['net_amount'])/100); ?></td> 
                 <td><?php echo sprintf("%.2f", $SUM['valid_amount']/100); ?></td> 
                 <td><span style="color:<?php echo $SUM['net_amount']<0 ? '#FF0000' : '#009900';?>;"><?php echo sprintf('%.2f', -1*$SUM['net_amount']/100); ?></span></td> 
            </tr>
	</table><?php
}
if(in_array($_GET['caizhong'], array('ALL', 'GAME'))){
?>	  
	<table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;line-height:20px;" bgcolor="#798EB9"> 
		  <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
			  <td colspan="10">彩票体育下注汇总</td> 
		  </tr>
            <tr align="center" style="background-color:#aee0f7;"> 
              <td rowspan="2">彩种</td> 
              <td colspan="4">已结算</td> 
              <td colspan="3">未结算</td> 
              <td colspan="2">合计(已结算+未结算)</td> 
          </tr>
            <tr align="center" style="background-color:#aee0f7;"> 
              <td>注单数</td> 
              <td>下注</td> 
              <td>结果</td> 
              <td>盈亏</td> 
              <td>注单数</td> 
              <td>下注</td> 
              <td>可赢</td> 
              <td>注单数</td> 
              <td>下注</td> 
          </tr>
<?php
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
	'广东快乐10分' => array(
		'广东快乐10分',
		'SELECT SUM(IF(`b`.`js`=0, 0, 1)) AS `ok_rows_num`, SUM(IF(`b`.`js`=0, 0, `b`.`money`)) AS `ok_bet_money`, SUM(IF(`b`.`js`=0, 0, CASE WHEN `b`.`win`<0 THEN 0 WHEN `b`.`win`=0 THEN `b`.`money` ELSE `b`.`win` END)) AS `ok_win`, SUM(IF(`b`.`js`=0, 1, 0)) AS `no_rows_num`, SUM(IF(`b`.`js`=0, `b`.`money`, 0)) AS `no_bet_money`, SUM(IF(`b`.`js`=0, `b`.`money`*`b`.`odds`, 0)) AS `no_win` FROM `c_bet_3` AS `b` WHERE `b`.`type`=\'广东快乐10分\' AND `b`.`money`>0 AND `b`.`addtime` BETWEEN :s_time AND :e_time',
		'WHERE `b`.`username`=:username AND',
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
$s_time = isset($_GET['s_time'])&&!empty($_GET['s_time'])?$_GET['s_time'].' 00:00:00':date('Y-m-d 00:00:00');
$e_time = isset($_GET['e_time'])&&!empty($_GET['e_time'])?$_GET['e_time'].' 23:59:59':date('Y-m-d 23:59:59');
$params = array();
$SUM = array(
	'ok_rows_num' => 0,
	'ok_bet_money' => 0,
	'ok_win' => 0,
	'no_rows_num' => 0,
	'no_bet_money' => 0,
	'no_win' => 0,
);
foreach($_GAME as $key=>$val){
    $params[':s_time'] = $s_time;
    $params[':e_time'] = $e_time;
	if($key=='六合彩'){
		$params[':s_time'] = date('Y-m-d H:i:s', strtotime($s_time)+(12*3600));
		$params[':e_time'] = date('Y-m-d H:i:s', strtotime($e_time)+(12*3600));
	}else if(in_array($key, ['JSSC', 'JSSSC', 'JSLH'])){
        $params[':s_time'] = strtotime($s_time);
        $params[':e_time'] = strtotime($e_time);
    }
	if(isset($_GET['username'])&&!empty($_GET['username'])){
		$params[':username'] = $_GET['username'];
		$val[1] = str_replace('WHERE', $val[2], $val[1]);
	}
    $stmt = $mydata1_db->prepare($val[1]);
    $stmt->execute($params);
    $rows = $stmt->fetch();// var_dump($rows);
	$SUM['ok_rows_num']+= $rows['ok_rows_num'];
	$SUM['ok_bet_money']+= $rows['ok_bet_money'];
	$SUM['ok_win']+= $rows['ok_win'];
	$SUM['no_rows_num']+= $rows['no_rows_num'];
	$SUM['no_bet_money']+= $rows['no_bet_money'];
	$SUM['no_win']+= $rows['no_win'];
?>
            <tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#ffffff'" style="background-color:#ffffff;"> 
                 <td><a href="allorder.php?caizhong=<?php echo $key; ?>&amp;username=<?php echo $_GET['username']; ?>&amp;s_time=<?php echo $_GET['s_time']; ?>&amp;e_time=<?php echo $_GET['e_time']; ?>&amp;action=1"><?php echo $val[0]; ?> (详情)</a></td> 
                 <td><?php echo sprintf("%.0f", $rows['ok_rows_num']); ?></td> 
                 <td><?php echo sprintf("%.2f", $rows['ok_bet_money']); ?></td> 
                 <td><?php echo sprintf("%.2f", $rows['ok_win']); ?></td> 
                 <td><span style="color:<?php echo $rows['ok_bet_money']-$rows['ok_win']>0?'#FF0000':'#009900'; ?>;"><?php echo sprintf("%.2f",$rows['ok_bet_money']-$rows['ok_win']); ?></span></td> 
                 <td><?php echo sprintf("%.0f", $rows['no_rows_num']); ?></td> 
                 <td><?php echo sprintf("%.2f", $rows['no_bet_money']); ?></td> 
                 <td><?php echo sprintf("%.2f", $rows['no_win']); ?></td> 
                 <td><?php echo sprintf("%.0f", $rows['ok_rows_num']+$rows['no_rows_num']); ?></td> 
                 <td><?php echo sprintf("%.2f", $rows['ok_bet_money']+$rows['no_bet_money']); ?></td> 
            </tr>
<?php } ?>
            <tr align="center" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#ffffff'" style="background-color:#ffffff;"> 
                 <td>彩票体育下注合计 <a href="allorder.php?username=<?php echo $_GET['username']; ?>&amp;s_time=<?php echo $_GET['s_time']; ?>&amp;e_time=<?php echo $_GET['e_time']; ?>&amp;action=1">(详情)</a></td> 
                 <td><?php echo sprintf("%.0f", $SUM['ok_rows_num']); ?></td> 
                 <td><?php echo sprintf("%.2f", $SUM['ok_bet_money']); ?></td> 
                 <td><?php echo sprintf("%.2f", $SUM['ok_win']); ?></td> 
                 <td><span style="color:<?php echo $SUM['ok_bet_money']-$SUM['ok_win']>0?'#FF0000':'#009900'; ?>;"><?php echo sprintf("%.2f",$SUM['ok_bet_money']-$SUM['ok_win']); ?></span></td> 
                 <td><?php echo sprintf("%.0f", $SUM['no_rows_num']); ?></td> 
                 <td><?php echo sprintf("%.2f", $SUM['no_bet_money']); ?></td> 
                 <td><?php echo sprintf("%.2f", $SUM['no_win']); ?></td> 
                 <td><?php echo sprintf("%.0f", $SUM['ok_rows_num']+$SUM['no_rows_num']); ?></td> 
                 <td><?php echo sprintf("%.2f", $SUM['ok_bet_money']+$SUM['no_bet_money']); ?></td> 
            </tr>
	</table><?php } ?>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="font12" style="margin-top:5px;line-height:20px;"> 
	  <tr> 
		  <td> 
			  <p>温馨提醒：</p> 
			  <p style="color:#f00">1、真人下注非实时结果，需要等待系统生成报表后才能查询！</p> 
			  <p>2、报表时间为美东时间，请注意时间差。</p> 
		  </td> 
	  </tr> 
  </table> 

	</div> 
  </div> 
  </body> 
  </html>