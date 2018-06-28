<?php
// select a.bet_info, a.match_time, b.Match_Time, a.match_nowscore, b.Match_NowScore, a.lose_ok, a.bet_time, now() from mydata1_db.k_bet a left join mydata4_db.bet_match b on a.match_id=b.Match_ID where `bet_time`>=DATE_SUB(now(), INTERVAL 180 SECOND) order by a.bid desc

include_once '../../include/config.php';
include_once '../../database/mysql.config.php';

$now_time = time();
/* 调出下注时间为90秒内的下注记录 */
$stmt = $mydata1_db->query('SELECT `ball_sort`, `match_nowscore`, `point_column`, `match_time`, `match_id`, `bid`, `uid`, `master_guest`, `bet_time`, `bet_info`, `bet_point`, `Match_GRedCard`, `Match_HRedCard`, `bet_money` FROM `mydata1_db`.`k_bet` WHERE `lose_ok`=0 AND `bet_time`>=DATE_SUB(now(), INTERVAL 90 SECOND)');
$match = array();
while ($rows = $stmt->fetch()) {
	if($rows['ball_sort']=='篮球滚球'){
	    array_key_exists($rows['match_id'], $match)||$match[$rows['match_id']] = array();
	    $rows['bet_time'] = strtotime($rows['bet_time']);
	    $match[$rows['match_id']][] = $rows;
	    $rows['bet_point'] = floatval($rows['bet_point']);
    }
}

$msg = date('Y-m-d H:i:s') . '<p />';
if(empty($match)){
    $msg .= '本次无篮球滚球注单判断';
}else{
    /* 使用速度较快的有效缓存数据进行水位判断 */
    $keys = [
        'Match_BzM', // 独赢
        'Match_BzG',
        'Match_Ao', // 让球
        'Match_Ho',
        'Match_DxDpl', // 总分大小
        'Match_DxXpl',
        'Match_DsDpl', // 总分单双
        'Match_DsSpl',
        'Match_DFzDpl', // 主队得分：大小
        'Match_DFzXpl',
        'Match_DFkDpl', // 客队得分：大小
        'Match_DFkXpl',
    ];
    include_once '../../cache/lqgq.php';
    if($lasttime>=$now_time){
        foreach($lqgq as $val){
            if(array_key_exists($val['Match_ID'], $match)){
                foreach($keys as $key){
                    $k = strtolower($key);
                    $val[$k] = floatval($val[$key]);
                }
                $val['Match_CoverDate'] = strtotime($val['Match_CoverDate']);
                foreach($match[$val['Match_ID']] as $key=>$rows){
                    $msg_t = '';
                    $bool = false;
                    if($val[$rows['point_column']]!=$rows['bet_point']){
                        $msg_t = '篮球滚球注单水位变化无效';
                        $bool = cancelbet(3, $rows['bid'], $rows['uid'], $rows['master_guest'].'_注单已取消', $rows['master_guest'].'<br />'.$rows['bet_info'].'<br />水位变化：'.$rows['bet_point'].' =&gt; '.($val[$rows['point_column']]>0?$val[$rows['point_column']]:'盘口关闭').'<br /><font style="color:#F00"/>因水位变化无效，该注单取消，已返还本金。</font>', '水位变化无效');
                    }else if($val['Match_CoverDate']-$rows['bet_time']>=30){
                        $msg_t = '篮球滚球注单有效';
                        $bool = setok($rows['bid']);
                    }
                    if($bool){
                        $filename = '../../cache/logList/'.date('Y-m-d', $now_time).'.txt';
                        $somecontent = '['.date('Y-m-d H:i:s', $now_time).']	系统C审核了编号为'.$rows['bid'].'的'.$msg_t.'	投注金额['.$rows['bet_money'].']'.PHP_EOL;
                        $handle = fopen($filename, 'a');
                        if(fwrite($handle, $somecontent)===false){
                            exit();
                        }
                        fclose($handle);
                        $msg.= '<font color="#0000FF">审核了编号为'.$rows['bid'].'的'.$msg_t.'</font><br />';
                    }
                    unset($match[$val['Match_ID']][$key]);
                }
                if(empty($match[$val['Match_ID']])){
                    unset($match[$val['Match_ID']]);
                }
            }
        }
    }

    /* 缓存可能存在无数据情况，使用数据库数据进行判断 */
    $keys = [
        'match_bzm', // 独赢
        'match_bzg',
        'match_ao', // 让球
        'match_ho',
        'match_dxdpl', // 总分大小
        'match_dxxpl',
        'match_dsdpl', // 总分单双
        'match_dsspl',
        'match_dfzdpl', // 主队得分：大小
        'match_dfzxpl',
        'match_dfkdpl', // 客队得分：大小
        'match_dfkxpl',
    ];
    if(!empty($match)){
        $params = array_keys($match);
        $stmt = $mydata1_db->prepare('SELECT `Match_BzM` AS `match_bzm`, `Match_BzG` AS `match_bzg`, `Match_Ao` AS `match_ao`, `Match_Ho` AS `match_ho`, `Match_Dxdpl` AS `match_dxdpl`, `Match_Dxxpl` AS `match_dxxpl`, `Match_Dsdpl` AS `match_dsdpl`, `Match_Dsspl` AS `match_dsspl`, `Match_DFzDpl` AS `match_dfzdpl`, `Match_DFzXpl` AS `match_dfzxpl`, `Match_DFkDpl` AS `match_dfkdpl`, `Match_DFkXpl` AS `match_dfkxpl`, `Match_LstTime` FROM `mydata4_db`.`lq_match` WHERE `Match_Type`=2 AND `Match_ID` IN (?'.str_repeat(', ?', count($params)-1).')');
        $stmt->execute($params);
        while ($val = $stmt->fetch()) {
            foreach($keys as $key){
                $val[$key] = floatval($val[$key]);
            }
            $val['Match_LstTime'] = strtotime($val['Match_LstTime']);
            foreach($match[$val['Match_ID']] as $rows){
                $msg_t = '';
                $bool = false;
                if($val[$rows['point_column']]!=$rows['bet_point']){
                    $msg_t = '篮球滚球注单水位变化无效';
                    $bool = cancelbet(3, $rows['bid'], $rows['uid'], $rows['master_guest'].'_注单已取消', $rows['master_guest'].'<br />'.$rows['bet_info'].'<br />水位变化：'.$rows['bet_point'].' =&gt; '.($val[$rows['point_column']]>0?$val[$rows['point_column']]:'盘口关闭').'<br /><font style="color:#F00"/>因水位变化无效，该注单取消，已返还本金。</font>', '水位变化无效');
                }else if($val['Match_LstTime']-$rows['bet_time']>=30){
                    $msg_t = '篮球滚球注单有效';
                    $bool = setok($rows['bid']);
                }
                if($bool){
                    $filename = '../../cache/logList/'.date('Y-m-d', $now_time).'.txt';
                    $somecontent = '['.date('Y-m-d H:i:s', $now_time).']	系统M审核了编号为'.$rows['bid'].'的'.$msg_t.'	投注金额['.$rows['bet_money'].']'.PHP_EOL;
                    $handle = fopen($filename, 'a');
                    if(fwrite($handle, $somecontent)===false){
                        exit();
                    }
                    fclose($handle);
                    $msg.= '<font color="#0000FF">审核了编号为'.$rows['bid'].'的'.$msg_t.'</font><br />';
                }
            }
        }
    }
}
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="refresh" content="3">
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>篮球滚球自动审核 v2</title>
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
            <div align="left" style="padding:5px;background-color:#CCC">篮球滚球自动审核 v2</div>
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