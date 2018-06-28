<?php include_once '../../../include/config.php';
include_once '../../../database/mysql.config.php';
$qi = intval($_REQUEST['qishu']);
$uid = intval($_REQUEST['uid']);?><html> 
  <head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title></title> 
  <link href="/style/agents/control_down.css" rel="stylesheet" type="text/css"> 
  </head> 
  <body><?php $params = array(':qishu' => $qi);
$mysql = 'select * from lottery_k_qxc where qishu=:qishu';
$stmt = $mydata1_db->prepare($mysql);
$stmt->execute($params);
$mycou = $stmt->rowCount();
$myrow = $stmt->fetch();
if ($mycou == 0){
	exit('当前期数开奖号码未录入！');
}
$paramsMain = array(':qishu' => $qi);
$sqlMain = 'select * from lottery_data where atype=\'qxc\' and mid=:qishu and bet_ok=0 order by ID asc';
$stmtMain = $mydata1_db->prepare($sqlMain);
$stmtMain->execute($paramsMain);
$myrow['hm'] = unserialize($myrow['value']);
if(!is_array($myrow['hm'])){
    $myrow['hm'] = array();
    $myrow['hm'][] = '-';
    $myrow['hm'][] = '-';
    $myrow['hm'][] = '-';
    $myrow['hm'][] = '-';
    $myrow['hm'][] = '-';
    $myrow['hm'][] = '-';
    $myrow['hm'][] = '-';
}
// $myrow['all'] = $myrow['hm'];
// array_splice($myrow['hm'], 4);
while ($row = $stmtMain->fetch()){
	$row['ctype'] = explode('/', $row['ctype']);
	if(count($row['ctype'])>1){
		$row['count'] = $row['ctype'][0];
		$row['money2'] = $row['ctype'][1];
	}else{
		$row['count'] = 0;
		$row['money2'] = 0;
	}
	$wins = 0;
	switch($row['btype']){
		case '定位':
			$row['content'] = explode(',', $row['content']);
            foreach($row['content'] as $key=>$val){
                if($val=='*'){
                    unset($row['content'][$key]);
                    continue;
                }else{
                    $row['content'][$key] = str_split($val);
                }
            }
            if($row['dtype']=='一定位'){
            	foreach($row['content'] as $key=>$val){
            		in_array($myrow['hm'][$key], $val)&&$wins+= 1;
            	}
            }else if(count($row['content'])==str_replace(array('二定位', '三定位', '四定位'), array(2, 3, 4), $row['dtype'])){
                foreach($row['content'] as $key=>$val){
                    if(in_array($myrow['hm'][$key], $val)){
                    	$wins = 1;
                    }else{
                    	$wins = 0;
                    	break;
                    }
                }
            }
		break;
		case '字现':
            $row['content'] = str_split($row['content']);
			$row['content2'] = array();
			$show = 0;
            foreach($row['content'] as $val){
                $row['content2']['j'.$val] = $val;
            }
			for($i=0;$i<4;$i++){
                $j = $myrow['hm'][$i];
                if(isset($row['content2']['j'.$j])){
                    $show+= 1;
                    unset($row['content2']['j'.$j]);
                }
			}
			$show==str_replace(array('二字现', '三字现'), array(2, 3), $row['dtype'])&&$wins = 1;
		break;
	}
    if($wins>0){
    	$wins*= $row['money2']*$row['odds'];
    	win_update($wins-$row['money'], $row['id'], $wins, $row['username'], $row['ctype'].'注单中奖修改失败' . $row['id'], $row['ctype'].'会员加奖失败' . $row['username']);
    }else{
    	no_win_update($row['money'], $row['id'], $row['ctype'].'注单未中奖修改失败' . $row['id']);
    }
	$creationTime = date('Y-m-d H:i:s');
	$id = $row['id'];
	$params = array(':creationTime' => $creationTime, ':id' => $id);
	$sql = "\r\n\t\t" . 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'QXC\',\'RECKON\',lottery_data.uid,lottery_data.win+lottery_data.money,k_user.money-(lottery_data.win+lottery_data.money),k_user.money,:creationTime FROM k_user,lottery_data  WHERE k_user.username=lottery_data.username  AND lottery_data.bet_ok=1 AND lottery_data.id=:id';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute($params);
}
$params = array(':qishu' => $qi);
$msql = 'update lottery_k_qxc set status=1 where qishu=:qishu';
$stmt = $mydata1_db->prepare($msql);
$stmt->execute($params) || exit('修改期數狀態失敗');
if ($_GET['t'] == 1){
	echo '<script>window.location.href="../../cpgl/lottery_auto_qxc.php";</script>';
}
?> </body> 
  </html>
<?php
function win_update($win, $id, $money, $username, $msg_data, $msg_user){
	global $mydata1_db;
	$params = array(':win' => $win, ':id' => $id);
	$msql = 'update lottery_data set win=:win,bet_ok=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit($msg_data);
	$params = array(':money' => $money, ':username' => $username);
	$msql = 'update k_user set money=money+:money where username=:username';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit($msg_user);
}
function no_win_update($win, $id, $msg_data){
	global $mydata1_db;
	$params = array(':win' => $win, ':id' => $id);
	$msql = 'update lottery_data set win=-:win,bet_ok=1 where id=:id';
	$stmt = $mydata1_db->prepare($msql);
	$stmt->execute($params) || exit($msg_data);
}