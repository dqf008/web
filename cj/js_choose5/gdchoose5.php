<?php
header('Content-Type:text/html; charset=utf-8');
include_once ("../include/function.php");
include ("Auto_ClassChoose5.php");

$m = 0;
$xiansho = "";
$title ='广东11选5';
$type ='GDSYXW';
$name ='gdchoose5';
$params =  array(':type'=>$type);
$sqlq		= "select qishu from c_bet_choose5 where  type=:type and js=0 group by qishu order by qishu asc";
$stmta = $mydata1_db->prepare($sqlq);
$stmta->execute($params);
while($rsqs = $stmta->fetch()){
    $qi = $rsqs['qishu'];
    $para = array(':qishu'=>$qi,':name'=>$name);
    $sqlw = 'select * from c_auto_choose5 where qishu=:qishu and name=:name limit 0,1';
    $st = $mydata1_db->prepare($sqlw);
    $st -> execute($para);
    $rs = $st->fetch();
    if($rs){
        $hm 		= array();
        $hm[]		= $rs['ball_1'];
        $hm[]		= $rs['ball_2'];
        $hm[]		= $rs['ball_3'];
        $hm[]		= $rs['ball_4'];
        $hm[]		= $rs['ball_5'];
        //根据期数读取未结算的注单
        $pra = array(':type'=>$type,':qishu'=>$qi);
        $sql1 = 'select * from c_bet_choose5 where type=:type and js=0 and qishu=:qishu order by addtime asc';
        $stm = $mydata1_db->prepare($sql1);
        $stm->execute($pra);

        while($rows = $stm->fetch()){
            if ($rows['mingxi_1'] == '正码一'){
                $ds = Klsf_Ds($rs['ball_1']);
                $dx = Klsf_Dx($rs['ball_1']);
                if (($rows['mingxi_2'] == $rs['ball_1']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }

            if ($rows['mingxi_1'] == '正码二'){
                $ds = Klsf_Ds($rs['ball_2']);
                $dx = Klsf_Dx($rs['ball_2']);
                if (($rows['mingxi_2'] == $rs['ball_2']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }

            if ($rows['mingxi_1'] == '正码三'){
                $ds = Klsf_Ds($rs['ball_3']);
                $dx = Klsf_Dx($rs['ball_3']);
                if (($rows['mingxi_2'] == $rs['ball_3']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx))
                {
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }
                else
                {
                    no_win_update($rows['id']);
                }
            }

            if ($rows['mingxi_1'] == '正码四'){
                $ds = Klsf_Ds($rs['ball_4']);
                $dx = Klsf_Dx($rs['ball_4']);
                if (($rows['mingxi_2'] == $rs['ball_4']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }

            if ($rows['mingxi_1'] == '正码五'){
                $ds = Klsf_Ds($rs['ball_5']);
                $dx = Klsf_Dx($rs['ball_5']);
                if (($rows['mingxi_2'] == $rs['ball_5']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx)){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }


            if ($rows['mingxi_1'] == '全五中一'){
                $ds = Klsf_Ds($rs['ball_6']);
                $dx = Klsf_Dx($rs['ball_6']);
                if (($rows['mingxi_2'] == $rs['ball_6']) || ($rows['mingxi_2'] == $ds) || ($rows['mingxi_2'] == $dx) || ($rows['mingxi_2'] == $wdx) || ($rows['mingxi_2'] == $hds) || ($rows['mingxi_2'] == $zfb) || ($rows['mingxi_2'] == $dnxb)){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }

            if ($rows['mingxi_1'] == '正码一VS正码二'){
                $lh = Klsf_Lh($rs['ball_1'],$rs['ball_2']);
                if ($rows['mingxi_2'] == $lh){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }

            if ($rows['mingxi_1'] == '正码一VS正码三'){
                $lh = Klsf_Lh($rs['ball_1'],$rs['ball_3']);
                if ($rows['mingxi_2'] == $lh){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }
            if ($rows['mingxi_1'] == '正码一VS正码四'){
                $lh = Klsf_Lh($rs['ball_1'],$rs['ball_4']);
                if ($rows['mingxi_2'] == $lh){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }
            if ($rows['mingxi_1'] == '正码一VS正码五'){
                $lh = Klsf_Lh($rs['ball_1'],$rs['ball_5']);
                if ($rows['mingxi_2'] == $lh){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }
            if ($rows['mingxi_1'] == '正码二VS正码三'){
                $lh = Klsf_Lh($rs['ball_2'],$rs['ball_3']);
                if ($rows['mingxi_2'] == $lh){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }
            if ($rows['mingxi_1'] == '正码二VS正码四'){
                $lh = Klsf_Lh($rs['ball_2'],$rs['ball_4']);
                if ($rows['mingxi_2'] == $lh){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }
            if ($rows['mingxi_1'] == '正码二VS正码五'){
                $lh = Klsf_Lh($rs['ball_2'],$rs['ball_5']);
                if ($rows['mingxi_2'] == $lh){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }
            if ($rows['mingxi_1'] == '正码三VS正码四'){
                $lh = Klsf_Lh($rs['ball_3'],$rs['ball_4']);
                if ($rows['mingxi_2'] == $lh){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }
            if ($rows['mingxi_1'] == '正码三VS正码五'){
                $lh = Klsf_Lh($rs['ball_3'],$rs['ball_5']);
                if ($rows['mingxi_2'] == $lh){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }
            if ($rows['mingxi_1'] == '正码四VS正码五'){
                $lh = Klsf_Lh($rs['ball_4'],$rs['ball_5']);
                if ($rows['mingxi_2'] == $lh){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }
            if (($rows['mingxi_2'] == '总和大') || ($rows['mingxi_2'] == '总和小')){
                $zonghe = Klsf_Auto($hm, 2);
                if ($rows['mingxi_2'] == $zonghe){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else if ($zonghe == '总和和'){
                    he_update($rows['id'], $rows['money'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }

            if (($rows['mingxi_2'] == '总和单') || ($rows['mingxi_2'] == '总和双')){
                $zonghe = Klsf_Auto($hm, 3);
                if ($rows['mingxi_2'] == $zonghe){
                    win_update($rows['id'], $rows['win'], $rows['uid']);
                }else{
                    no_win_update($rows['id']);
                }
            }


            $creationTime = date('Y-m-d H:i:s');
            $id = $rows['id'];
            $params = array(':creationTime' => $creationTime, ':id' => $id);
            $sql = 'INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,\'YFSYXW\',\'RECKON\',c_bet_choose5.id,(case when c_bet_choose5.win<0 then 0 when c_bet_choose5.win=0 then c_bet_choose5.money else c_bet_choose5.win end),k_user.money-(case when c_bet_choose5.win<0 then 0 when c_bet_choose5.win=0 then c_bet_choose5.money else c_bet_choose5.win end),k_user.money,:creationTime FROM k_user,c_bet_choose5  WHERE k_user.uid=c_bet_choose5.uid  AND c_bet_choose5.js=1 AND c_bet_choose5.id=:id';
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
            $str_ball = $rs['ball_1'] . ',' . $rs['ball_2'] . ',' . $rs['ball_3'] . ',' . $rs['ball_4'] . ',' . $rs['ball_5'];
            $params = array(':jieguo' => $str_ball, ':id' => $rows['id']);
            $msql = 'update c_bet_choose5 set jieguo=:jieguo where id=:id';
            $stmt = $mydata1_db->prepare($msql);
            $stmt->execute($params) || exit('注单修改失败!!!' . $rows['id']);

            $m += 1;
        }

        $param = array(':qishu'=>$qi);
        $msql='update c_auto_choose5 set ok=1 where qishu=:qishu';
        $stmt1 = $mydata1_db->prepare($msql);
        $stmt1->execute($param)|| exit("期数修改失败!!!");
        $xiansho .= "［第".$qi."期］：已经全部结算！！<br>";
    }
}

function win_update($id, $money, $uid){
    global $mydata1_db;
    $params = array(':id' => $id);
    $msql = 'update c_bet_choose5 set js=1 where id=:id';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('注单修改失败!!!' . $id);
    $q1 = $stmt->rowCount();
    if ($q1 == 1){
        $params = array(':money' => $money, ':uid' => $uid);
        $msql = 'update k_user set money=money+:money where uid=:uid';
        $stmt = $mydata1_db->prepare($msql);
        $stmt->execute($params) || exit('会员修改失败!!!' . $id);
    }
}

function he_update($id, $money, $uid){
    global $mydata1_db;
    $params = array(':id' => $id);
    $msql = 'update c_bet_choose5 set win=0,js=1 where id=:id';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('注单修改失败!!!' . $id);
    $q1 = $stmt->rowCount();
    if ($q1 == 1){
        $params = array(':money' => $money, ':uid' => $uid);
        $msql = 'update k_user set money=money+:money where uid=:uid';
        $stmt = $mydata1_db->prepare($msql);
        $stmt->execute($params) || exit('会员修改失败!!!' . $id);
    }
}

function no_win_update($id){
    global $mydata1_db;
    $params = array(':id' => $id);
    $msql = 'update c_bet_choose5 set win=-money,js=1 where id=:id';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('注单修改失败!!!' . $id);
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

    <? $limit= rand(3,10);?>
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

            <font color="#FF0000"><?=$title?> 共结算<?=$m?>个注单</font><br />

            <?=$xiansho?>
        </td>
    </tr>
</table>
</body>
</html>
