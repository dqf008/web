<?php
// select a.bet_info, a.match_time, b.Match_Time, a.match_nowscore, b.Match_NowScore, a.lose_ok, a.bet_time, now() from mydata1_db.k_bet a left join mydata4_db.bet_match b on a.match_id=b.Match_ID where `bet_time`>=DATE_SUB(now(), INTERVAL 180 SECOND) order by a.bid desc

include_once '../../include/config.php';
include_once '../../database/mysql.config.php';

$now_time = time();
$msg = date('Y-m-d H:i:s', $now_time).'<br />';
$msgs = [];
/* 调出超过5分钟未确认数据 */
$stmt = $mydata1_db->query('SELECT `bid`, `uid`, `master_guest`, `bet_info`, `bet_money` FROM `mydata1_db`.`k_bet` WHERE `lose_ok`=0 AND `bet_time`<=DATE_SUB(now(), INTERVAL 300 SECOND)');
$match = array();
while ($rows = $stmt->fetch()) {
    $bool = cancelbet(3, $rows['bid'], $rows['uid'], $rows['master_guest'].'_注单已取消', $rows['master_guest'].'<br />'.$rows['bet_info'].'<br /><font style="color:#F00"/>该注单确认超时现已被取消，已返还本金。</font>', '确认超时');
    if($bool){
        $filename = '../../cache/logList/'.date('Y-m-d', $now_time).'.txt';
        $somecontent = '['.date('Y-m-d H:i:s', $now_time).']	系统审核了编号为'.$rows['bid'].'的滚球注单确认超时	投注金额['.$rows['bet_money'].']'.PHP_EOL;
        $handle = fopen($filename, 'a');
        if(fwrite($handle, $somecontent)===false){
            exit();
        }
        fclose($handle);
        $msgs[] = '<font color="#0000FF">审核了编号为'.$rows['bid'].'的滚球注单确认超时</font>';
    }
}
$msg.= empty($msgs)?'<p>本次无滚球注单判断</p>':implode('<br />', $msgs);
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="refresh" content="3">
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>滚球注单自动取消 v2</title>
    </head>
    <style type="text/css">
        body,div{ margin:0;padding:0}
    </style>
    <script>
        window.parent.is_open = 1;
    </script>
    <body >
    <div align="center">
        <div align="center" style="width:500px;height:200px;border:1px solid #CCC;font-size:13px;">
            <div align="left" style="padding:5px;background-color:#CCC">滚球注单自动取消 v2</div>
            <div style="padding-top:50px;"><?=$msg;?></div>

        </div></div>
    </body>
    </html>
<?php
function cancelBet($status, $bid, $uid, $msg_title, $msg_info, $why = ''){
    global $mydata1_db;
    global $web_site;
    $params = array(':status' => $status, ':sys_about' => $why, ':bid' => $bid);
    $sql = 'update k_bet,k_user set k_bet.lose_ok=1,k_bet.status=:status,k_user.money=k_user.money+k_bet.bet_money,k_bet.win=k_bet.bet_money,k_bet.update_time=now(),k_bet.match_endtime=now(),k_bet.sys_about=:sys_about where k_user.uid=k_bet.uid and k_bet.bid=:bid and k_bet.status=0';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $q1 = $stmt->rowCount();
    if ($q1 == 2)
    {
        $creationTime = date('Y-m-d H:i:s');
        $params = array(':creationTime' => $creationTime, ':bid' => $bid);
        $sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) 
		SELECT k_user.uid,k_user.username,\'SportsDS\',\'CANCEL_BET\',k_bet.number,k_bet.win,k_user.money-k_bet.win,k_user.money,:creationTime FROM k_user,k_bet WHERE k_user.uid=k_bet.uid AND k_bet.bid=:bid';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        include_once '../../class/user.php';
        user::msg_add($uid, $web_site['reg_msg_from'], $msg_title, $msg_info);
        return true;
    }
}
function setOK($bid)
{
    global $mydata1_db;
    $params = array(':bid' => $bid);
    $sql = 'update k_bet set lose_ok=1,match_endtime=now() where bid=:bid and lose_ok=0';
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $q1 = $stmt->rowCount();
    if ($q1 == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}