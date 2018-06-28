<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");

$m = 0;
$xiansho = "";
$atype='sfk3';
$type='三分快3';

$params = array(':atype'=>$atype);
$sql = 'select mid from lottery_data where atype=:atype and bet_ok=0 group by mid order by mid asc';
$stmta = $mydata1_db->prepare($sql);
$stmta->execute($params);
while($rsq = $stmta->fetch()){
    $qi = $rsq['mid'];
    $params = array(':qihao'=>$qi);
    $sql = 'select * from lottery_k3 where qihao=:qihao and ok=1 limit 0,1';
    $st = $mydata1_db->prepare($sql);
    $st->execute($params);
    $myrow = $st->fetch();
    if($myrow){
        $plsql = "select id,class1,class2,class3,odds from lottery_k3_odds where class1='$atype' order by ID asc";
        $plresult = $mydata1_db->query($plsql);
        $plrr = $plresult->fetchAll();
        $odds = array();
        foreach ($plrr as $item){
            $odds[$item['class2']][$item['class3']]=$item['odds'];
        }
        $balls = explode(',',$myrow['balls']);
        $sum   = array_sum($balls);
        $bigOrSmall = $sum >9?'大':'小';
        $par  = array(':qihao'=>$qi,':atype'=>$atype);
        $sqlMain='select * from lottery_data where atype=:atype and mid=:qihao and bet_ok=0 order by ID asc';
        $stmtMain = $mydata1_db->prepare($sqlMain);
        $stmtMain -> execute($par);
        while ($row = $stmtMain->fetch()) {
            $wins = ($row['money'] * $row['odds']) - $row['money'];
            switch ($row['btype']){
                case '三军、大小':
                    if($row['content'] == $bigOrSmall || in_array($row['content'],$balls)){
                        win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
                    }else{
                        no_win_update($row['money'], $row['id']);
                    }

                    break;

                case '围骰、全骰':
                    if($myrow['balls']==$row['content']){
                        win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
                    }else{
                        no_win_update($row['money'], $row['id']);
                    }
                    break;
                case '点数':
                    $pointBalls = explode(',',$row['content']);
                    $pointSum = array_sum($pointBalls);
                    if($pointSum == $sum){
                        win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
                    }else{
                        no_win_update($row['money'], $row['id']);
                    }
                    break;
                case '长牌':
                case '短牌':
                    $pointBalls = explode(',',$row['content']);
                    if(array_diff($pointBalls,$balls)){
                        win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
                    }else{
                        no_win_update($row['money'], $row['id']);
                    }
                    break;

                default:
                    no_win_update($row['money'], $row['id']);
                    break;
            }
            $creationTime = date('Y-m-d H:i:s');
            $id = $row['id'];
            $params = array(':creationTime' => $creationTime, ':id' => $id);
            $sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'SFK3\',\'RECKON\',lottery_data.uid,lottery_data.win+lottery_data.money,k_user.money-(lottery_data.win+lottery_data.money),k_user.money,:creationTime FROM k_user,lottery_data  WHERE k_user.username=lottery_data.username  AND lottery_data.bet_ok=1 AND lottery_data.id=:id';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);

            $m +=1;
        }

        $xiansho .= "［第".$qi."期］：已经全部结算！！<br>";
    }
}

function win_update($win, $id, $money, $username){
    global $mydata1_db;
    $params = array(':win' => $win, ':id' => $id);
    $msql = 'update lottery_data set win=:win,bet_ok=1 where id=:id';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('中奖修改失败' . $id);
    $params = array(':money' => $money, ':username' => $username);
    $msql = 'update k_user set money=money+:money where username=:username';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('会员加奖失败' . $id);
}


function no_win_update($win, $id){
    global $mydata1_db;
    $params = array(':win' => $win, ':id' => $id);
    $msql = 'update lottery_data set win=-:win,bet_ok=1 where id=:id';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('注单未中奖修改失败' . $id);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$type?>结算</title>
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

    <? $limit= rand(10,30);?>
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

            <font color="#FF0000"><?=$type?> 共结算<?=$m?>个注单</font><br />

            <?=$xiansho?>
        </td>
    </tr>
</table>
</body>
</html>
