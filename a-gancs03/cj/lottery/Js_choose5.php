<?php header('Content-Type:text/html;charset=utf-8');
include_once '../../../include/config.php';
include_once '../../../database/mysql.config.php';
include 'Auto_Choose5.php';
$lotteryType = $_REQUEST['lottery_type'];
$lotteryName         = [
    'gdchoose5' => '广东11选5',
    'sdchoose5' => '山东11选5',
    'fjchoose5' => '福建11选5',
    'bjchoose5' => '北京11选5',
    'ahchoose5' => '安徽11选5',

];
$betNames = array('gdchoose5'=>'GDSYXW','sdchoose5'=>'SDSYXW','fjchoose5'=>'FJSYXW','bjchoose5'=>'BJSYXW','ahchoose5'=>'AHSYXW');
$qi = floatval($_REQUEST['qi']);
$params = array(':qishu' => $qi);
$sql = "select * from c_auto_choose5 where qishu=:qishu and `name`='$lotteryType' order by id desc limit 1";
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rs = $stmt->fetch();
$hm = array();
$hm[] = $rs['ball_1'];
$hm[] = $rs['ball_2'];
$hm[] = $rs['ball_3'];
$hm[] = $rs['ball_4'];
$hm[] = $rs['ball_5'];
if (($rs['ball_1'] === '') || ($rs['ball_2'] === '') || ($rs['ball_3'] === '') || ($rs['ball_4'] === '') || ($rs['ball_5'] === ''))
{
    exit('获取开奖结果失败，停止结算！');
}
$paramsMain = array(':qishu' => $qi);
$sqlMain = "select * from c_bet_choose5 where type='$lotteryName[$lotteryType]' and js=0 and qishu=:qishu order by addtime asc";
$stmtMain = $mydata1_db->prepare($sqlMain);
$stmtMain->execute($paramsMain);
while ($rows = $stmtMain->fetch())
{
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

    if (($rows['mingxi_2'] == '总和单') || ($rows['mingxi_2'] == '总和双')) {
        $zonghe = Klsf_Auto($hm, 3);
        if ($rows['mingxi_2'] == $zonghe) {
            win_update($rows['id'], $rows['win'], $rows['uid']);
        } else {
            no_win_update($rows['id']);
        }
    }
    $creationTime = date('Y-m-d H:i:s');
    $id = $rows['id'];

    $params = array(':creationTime' => $creationTime, ':id' => $id);
    $sql = "\r\n\t\t" . "INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime) SELECT k_user.uid,k_user.username,'$betNames[$lotteryType]','RECKON',c_bet_choose5.id,(case when c_bet_choose5.win<0 then 0 when c_bet_choose5.win=0 then c_bet_choose5.money else c_bet_choose5.win end),k_user.money-(case when c_bet_choose5.win<0 then 0 when c_bet_choose5.win=0 then c_bet_choose5.money else c_bet_choose5.win end),k_user.money,:creationTime FROM k_user,c_bet_choose5  WHERE k_user.uid=c_bet_choose5.uid  AND c_bet_choose5.js=1 AND c_bet_choose5.id=:id";
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $params = array(':jieguo' => $rs['ball_1'] . ',' . $rs['ball_2'] . ',' . $rs['ball_3'] . ',' . $rs['ball_4'] . ',' . $rs['ball_5'] , ':id' => $rows['id']);
    $msql = 'update c_bet_choose5 set jieguo=:jieguo where id=:id';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('注单修改失败!!!' . $rows['id']);
}
$params = array(':qishu' => $qi);
$msql = 'update c_auto_choose5 set ok=1 where qishu=:qishu';
$stmt = $mydata1_db->prepare($msql);
$stmt->execute($params) || exit('期数修改失败!!!');
if ($_GET['t'] == 1)
{?> <script>window.location.href='../../Lottery/auto_choose5.php?lottery_type=<?php echo $lotteryType ?>';</script><?php }
function win_update($id, $money, $uid)
{
    global $mydata1_db;
    $params = array(':id' => $id);
    $msql = 'update c_bet_choose5 set js=1 where id=:id';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('注单修改失败!!!' . $id);
    $q1 = $stmt->rowCount();
    if ($q1 == 1)
    {
        $params = array(':money' => $money, ':uid' => $uid);
        $msql = 'update k_user set money=money+:money where uid=:uid';
        $stmt = $mydata1_db->prepare($msql);
        $stmt->execute($params) || exit('会员修改失败!!!' . $id);
    }
}
function he_update($id, $money, $uid)
{
    global $mydata1_db;
    $params = array(':id' => $id);
    $msql = 'update c_bet_choose5 set win=0,js=1 where id=:id';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('注单修改失败!!!' . $id);
    $q1 = $stmt->rowCount();
    if ($q1 == 1)
    {
        $params = array(':money' => $money, ':uid' => $uid);
        $msql = 'update k_user set money=money+:money where uid=:uid';
        $stmt = $mydata1_db->prepare($msql);
        $stmt->execute($params) || exit('会员修改失败!!!' . $id);
    }
}
function no_win_update($id)
{
    global $mydata1_db;
    $params = array(':id' => $id);
    $msql = 'update c_bet_choose5 set win=-money,js=1 where id=:id';
    $stmt = $mydata1_db->prepare($msql);
    $stmt->execute($params) || exit('注单修改失败!!!' . $id);
}?>