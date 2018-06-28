<?php include_once '../../../include/config.php';
include_once '../../../database/mysql.config.php';
$qi = intval($_REQUEST['qihao']);
$lotteryType =isset($_REQUEST['lottery_type'])? $_REQUEST['lottery_type']:'pcdd';
$betName =array('pcdd'=>'PCDD');
$uid = intval($_REQUEST['uid']);?><html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <title></title>
    <link href="/style/agents/control_down.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
$paramsMain = array(':qishu' => $qi);
$sqlMain = 'select * from lottery_k_pcdd where qihao=:qishu and ok=0 limit 0,1';
$stmtMain = $mydata1_db->prepare($sqlMain);
$stmtMain->execute($paramsMain);
$mycou = $stmtMain->rowCount();
$myrow = $stmtMain->fetch();
if ($mycou == 0){
    exit('当前期数开奖号码未录入！');
}
$params = array(':mid' => $qi,':atype'=>$lotteryType);
$mysql = 'select * from lottery_data where mid=:mid and atype=:atype';
$stmt = $mydata1_db->prepare($mysql);
$stmt->execute($params);
while ($row = $stmt->fetch()){
    $hm1 = $myrow['hm1'];
    $hm2 = $myrow['hm2'];
    $hm3 = $myrow['hm3'];
    $sum = $hm1 + $hm2 + $hm3;
    $wins = ($row['money'] * $row['odds']) - $row['money'];
    if ($row['btype'] == '和值'){
        if ($sum == $row['content']){
            win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'],$row['ctype'].'注单未中奖修改失败' . $row['id'],$row['ctype'].'会员加奖失败' . $row['username']);
        }else{
            no_win_update($row['money'], $row['id'],$row['ctype'].'注单未中奖修改失败' . $row['id']);
        }
    }
    if ($row['btype'] == '两面'){
        $isWin = false;
        switch ($row['content']){
            case '大':
                if($sum>=14){
                    $isWin=true;
                }
                break;
            case '小':
                if($sum<14){
                    $isWin=true;
                }
                break;
            case '单':
                if(fmod($sum,2)!=0){
                    $isWin = true;
                }
                break;
            case '双':
                if(fmod($sum,2)==0){
                    $isWin = true;
                }
                break;
            case '极大':
                if($sum >=22){
                    $isWin = true;
                }
                break;
            case '极小':
                if($sum <=5){
                    $isWin = true;
                }
                break;
            case '大单':
                if($sum >=15 && fmod($sum,2)==1){
                    $isWin=true;
                }
                break;
            case '小单':
                if($sum <=13 && fmod($sum,2)==1){
                    $isWin = true;
                }
                break;
            case '大双':
                if($sum >=14 && fmod($sum,2)==0){
                    $isWin = true;
                }
                break;
            case '小双':
                if($sum <=12 && fmod($sum,2)==0){
                    $isWin = true;
                }
                break;
            default:
                break;
        }
        if ($isWin){
            win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'],$row['ctype'].'注单未中奖修改失败' . $row['id'],$row['ctype'].'会员加奖失败' . $row['username']);
        }else{
            no_win_update($row['money'], $row['id'],$row['ctype'].'注单未中奖修改失败' . $row['id']);
        }
    }

    if ($row['btype'] == '色波/豹子/包三'){
        if(($row['content']=='豹子' && ($hm1==$hm2) && ($hm2 ==$hm3))){
            win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'],$row['ctype'].'注单未中奖修改失败' . $row['id'],$row['ctype'].'会员加奖失败' . $row['username']);
        }elseif ($row['content']=='红波' && in_array($sum,array(3,6,9,12,15,18,21,24))){
            win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'],$row['ctype'].'注单未中奖修改失败' . $row['id'],$row['ctype'].'会员加奖失败' . $row['username']);
        }elseif ($row['content']=='绿波' && in_array($sum,array(1,4,7,10,16,19,22,25))){
            win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'],$row['ctype'].'注单未中奖修改失败' . $row['id'],$row['ctype'].'会员加奖失败' . $row['username']);
        }elseif ($row['content']=='蓝波' && in_array($sum,array(2,5,8,11,17,20,23,26))){
            win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username'],$row['ctype'].'注单未中奖修改失败' . $row['id'],$row['ctype'].'会员加奖失败' . $row['username']);
        }else{
            no_win_update($row['money'], $row['id'],$row['ctype'].'注单未中奖修改失败' . $row['id']);
        }
    }
    $creationTime = date('Y-m-d H:i:s');
    $id = $row['id'];
    $params = array(':creationTime' => $creationTime, ':id' => $id);
    $sql = "\r\n\t\t" . "INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,'$betName[$lotteryType]','RECKON',lottery_data.uid,lottery_data.win+lottery_data.money,k_user.money-(lottery_data.win+lottery_data.money),k_user.money,:creationTime FROM k_user,lottery_data  WHERE k_user.username=lottery_data.username  AND lottery_data.bet_ok=1 AND lottery_data.id=:id";
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
}
$params = array(':qihao' => $qi);
$msql = 'update lottery_k_pcdd set ok=1 where qihao=:qihao';
$stmt = $mydata1_db->prepare($msql);
$stmt->execute($params) || exit('修改期数状态失败');
if ($_GET['t'] == 1){
    echo '<script>window.location.href="../../cpgl/lottery_auto_pcdd.php?lottery_type=pcdd";</script>';

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