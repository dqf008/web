<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");

$m = 0;
$xiansho = "";
$atype='qhk3';
$type='青海快3';

$params = array(':atype'=>$atype);
$sql = 'select mid from lottery_data where atype=:atype and bet_ok=0 group by mid order by mid asc';
$stmta = $mydata1_db->prepare($sql);
$stmta->execute($params);

while($rsq = $stmta->fetch()){
    $qi = $rsq['mid'];
    $params = array(':qihao'=>$qi,':name'=>$atype);
    $sql = 'select * from lottery_k3 where qihao=:qihao and name=:name and ok=1 limit 0,1';
    $st = $mydata1_db->prepare($sql);
    $st->execute($params);
    $myrow = $st->fetch();
    if($myrow){
        $plsql = "select id,class1,class2,class3,odds from lottery_odds where class1='$atype' order by ID asc";
        $plresult = $mydata1_db->query($plsql);
        $plrr = $plresult->fetchAll();
        $odds = array();
        foreach ($plrr as $item){
            $odds[$item['class2']][$item['class3']]=$item['odds'];
        }
        $balls = explode(',',$myrow['balls']);
        asort($balls);
        $sum   = array_sum($balls);
        $bigOrSmall = $sum >10?'大':'小';
        $singOrDouble = singleOrDouble($sum);
        $range  = getRange($sum,$singOrDouble);
        $par  = array(':qihao'=>$qi,':atype'=>$atype);
        $sqlMain='select * from lottery_data where atype=:atype and mid=:qihao and bet_ok=0 order by ID asc';
        $stmtMain = $mydata1_db->prepare($sqlMain);
        $stmtMain -> execute($par);
        $i=0;
        while ($row = $stmtMain->fetch()) {
            $wins = ($row['money'] * $row['odds']) - $row['money'];
            switch ($row['btype']){
                case '和值':
                    if($row['content'] == $bigOrSmall  ||$row['content'] ==$singOrDouble || $row['content']==$sum || $row['content']==$range){
                        win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
                    }else{
                        no_win_update($row['money'], $row['id']);
                    }
                    break;
                case '三同号':
                    if($row['ctype']=='三同号通选' && count(array_unique($balls))==1){
                        win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
                    }elseif ($row['ctype']=='三同号单选' && threeSameJudge($balls,$row['content'])){
                        win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
                    }else{
                        no_win_update($row['money'],$row['id']);
                    }
                    break;
                case '三不同号':
                    if($row['ctype']=='三连号通选' && isThreeEvenNumber($balls)){
                        win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
                    }elseif ($row['ctype']=='三连号单选' && isThreeEvenNumber($balls,$row['content'])){
                        win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
                    }elseif($row['ctype']=='三不同号' && isThreeDiff($balls,$row['content'])){
                        win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
                    }else{
                        no_win_update($row['money'], $row['id']);
                    }
                    break;
                case '二不同号':
                    if(twoDiff($balls,$row['content'])){
                        win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
                    }else{
                        no_win_update($row['money'], $row['id']);
                    }
                    break;
                case '二同号':
                    if($row['ctype']=='二同号复选' && twoDiff($balls,$row['content'])){
                        win_update($wins, $row['id'], $row['money'] * $row['odds'], $row['username']);
                    }else if($row['ctype']=='二同号单选' && twoSampleChoose($balls,$row['content'])){
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
            $sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'QHK3\',\'RECKON\',lottery_data.uid,lottery_data.win+lottery_data.money,k_user.money-(lottery_data.win+lottery_data.money),k_user.money,:creationTime FROM k_user,lottery_data  WHERE k_user.username=lottery_data.username  AND lottery_data.bet_ok=1 AND lottery_data.id=:id';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);

            $m +=1;
        }
        $xiansho .= "［第".$qi."期］：已经全部结算！！<br>";
    }
}
function twoSampleChoose($balls,$content){
    //content为字符串
    $betBalls[0]=$content[0];
    $betBalls[1]= $content[1];
    $betBalls[1] = $content[2];
    asort($betBalls);
    if($balls == $betBalls){
        return true;
    }
    return false;
}
function twoDiff($balls,$content){
    $balls=implode('',$balls);
    if(strpos($balls,$content)!==false){
        return true;
    }
    return false;
}
function isThreeDiff($balls,$content){
    $balls=implode('',$balls);
    if($balls==$content){
        return true;
    }
    return false;
}
function isThreeEvenNumber($balls,$content =''){
    $balls=implode('',$balls);
    if(empty($content) && in_array($balls,array('123','234','345','456'))){
        return true;
    }
    if($balls == $content){
        return true;
    }
    return false;
}
function threeSameJudge($balls,$content){
    $balls=implode('',$balls);
    if($balls==$content){
        return true;
    }
    return false;
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

function singleOrDouble($sum){

    if ($sum % 2 == 0){
        return '双';
    }else{
        return '单';
    }
}
function getRange($sum,$singOrDouble){
    if($sum >9){
        if($singOrDouble=='单'){
            return '大单';
        }else{
            return '大双';
        }
    }else{
        if($singOrDouble=='单'){
            return '小单';
        }else{
            return '小双';
        }
    }
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
