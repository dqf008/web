<?php
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
//include_once '../common/login_check.php';
//check_quanxian('cpgl');
//check_quanxian('cpcd');
if ($_GET['action'] == 'js_reset') {
    $qishu      = trim($_REQUEST['qi']);
    $t          = trim($_REQUEST['t']);
    $atype      = trim($_REQUEST['atype']);
    $return_url = '';
    $result_num = 0;
    $params     = [':qishu' => $qishu];
    if (in_array($atype, [2, 'cqssc', 'tjssc', 'xjssc'])) {
        $lotteryInfo = [
            'cqssc' => ['url' => 'Auto_2.php', 'gameType' => 'CQSSC', 'caizhong' => '重庆时时彩', 'auto_table' => 'c_auto_2'],
            'tjssc'  => ['url' => 'Auto_tjssc.php', 'gameType' => 'TJSSC', 'caizhong' => '天津时时彩', 'auto_table' => 'c_auto_tjssc'],
            'xjssc' => ['url' => 'Auto_xjssc.php', 'gameType' => 'XJSSC', 'caizhong' => '新疆时时彩', 'auto_table' => 'c_auto_xjssc'],
        ];
        $table       = 'c_bet';
    } else if (in_array($atype, [3, 'gdkl10', 'cqkl10', 'tjkl10', 'hnkl10', 'ynkl10', 'sxkl10', 'ffkl10', 'sfkl10'])) {
        $lotteryInfo = [
            '3'      => ['url' => 'Auto_3.php?lottery_type=gdkl10', 'gameType' => 'GDKLSF', 'caizhong' => '广东快乐十分', 'auto_table' => 'c_auto_3'],
            'gdkl10' => ['url' => 'Auto_3.php?lottery_type=gdkl10', 'gameType' => 'GDKLSF', 'caizhong' => '广东快乐十分', 'auto_table' => 'c_auto_klsf'],
            'cqkl10' => ['url' => 'Auto_3.php?lottery_type=cqkl10', 'gameType' => 'CQKLSF', 'caizhong' => '重庆快乐十分', 'auto_table' => 'c_auto_klsf'],
            'tjkl10' => ['url' => 'Auto_3.php?lottery_type=tjkl10', 'gameType' => 'TJKLSF', 'caizhong' => '天津快乐十分', 'auto_table' => 'c_auto_klsf'],
            'hnkl10' => ['url' => 'Auto_3.php?lottery_type=hnkl10', 'gameType' => 'HNKLSF', 'caizhong' => '湖南快乐十分', 'auto_table' => 'c_auto_klsf'],
            'ynkl10' => ['url' => 'Auto_3.php?lottery_type=ynkl10', 'gameType' => 'YNKLSF', 'caizhong' => '云南快乐十分', 'auto_table' => 'c_auto_klsf'],
            'sxkl10' => ['url' => 'Auto_3.php?lottery_type=sxkl10', 'gameType' => 'SXKLSF', 'caizhong' => '山西快乐十分', 'auto_table' => 'c_auto_klsf'],
            'ffkl10' => ['url' => 'Auto_3.php?lottery_type=ffkl10', 'gameType' => 'FFKLSF', 'caizhong' => '分分快乐十分', 'auto_table' => 'c_auto_klsf'],
            'sfkl10' => ['url' => 'Auto_3.php?lottery_type=sfkl10', 'gameType' => 'SFKLSF', 'caizhong' => '三分快乐十分', 'auto_table' => 'c_auto_klsf'],
        ];
        $table       = 'c_bet_3';
    } else if (in_array($atype, ['gdchoose5', 'sdchoose5', 'fjchoose5', 'bjchoose5', 'ahchoose5'])) {
        $lotteryInfo = [
            'gdchoose5' => ['url' => 'Auto_choose5.php?lottery_type=gdchoose5', 'gameType' => 'GDSYXW', 'caizhong' => '广东11选5', 'auto_table' => 'c_auto_choose5'],
            'sdchoose5' => ['url' => 'Auto_choose5.php?lottery_type=sdchoose5', 'gameType' => 'SDSYXW', 'caizhong' => '山东11选5', 'auto_table' => 'c_auto_choose5'],
            'fjchoose5' => ['url' => 'Auto_choose5.php?lottery_type=fjchoose5', 'gameType' => 'FJSYXW', 'caizhong' => '福建11选5', 'auto_table' => 'c_auto_choose5'],
            'bjchoose5' => ['url' => 'Auto_choose5.php?lottery_type=bjchoose5', 'gameType' => 'BJSYXW', 'caizhong' => '北京11选5', 'auto_table' => 'c_auto_choose5'],
            'ahchoose5' => ['url' => 'Auto_choose5.php?lottery_type=ahchoose5', 'gameType' => 'AHSYXW', 'caizhong' => '安徽11选5', 'auto_table' => 'c_auto_choose5'],
        ];
        $table       = 'c_bet_choose5';
    } else if ($atype == 'bjpk10') {
        $lotteryInfo = [
            'bjpk10' => ['url' => 'Auto_4.php', 'gameType' => 'BJPK10', 'caizhong' => '北京赛车PK拾', 'auto_table' => 'c_auto_4'],
        ];
        $table       = 'c_bet_3';
    } else if (in_array($atype, ['xyft'])) {
        $lotteryInfo = [
            'xyft' => ['url' => 'Auto_8.php?lottery_type=xyft', 'gameType' => 'XYFT', 'caizhong' => '幸运飞艇', 'auto_table' => 'c_auto_8'],
        ];
        $table       = 'c_bet_3';
    } else {
        exit('彩种无效，停止重算！错误提示：' . $atype);
    }
    $autoTable       = $lotteryInfo[$atype]['auto_table'];
    $params[':type'] = $lotteryInfo[$atype]['caizhong'];
    $return_url      = $lotteryInfo[$atype]['url'];
    $gameType        = $lotteryInfo[$atype]['gameType'];
    $caizhong        = $lotteryInfo[$atype]['caizhong'];
    $sql             = "select * from $table where qishu=:qishu and js=1 and type=:type order by addtime";
    $stmt            = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    while ($rows = $stmt->fetch()) {
        $id       = $rows['id'];
        $username = $rows['username'];
        $uid      = $rows['uid'];
        $money    = $rows['money'];
        $win      = $rows['win'];
        $remoney  = 0;
        if (0 < $win) {
            $remoney = $remoney - $win;
        }
        $params_k = [':money' => $remoney, ':uid' => $uid];
        $sql_k    = 'update k_user set money=money+:money where uid=:uid';
        $stmt_k   = $mydata1_db->prepare($sql_k);
        $stmt_k->execute($params_k);
        $creationTime = date('Y-m-d H:i:s');
        $params_l     = [':gameType' => $gameType, ':id' => $id, ':remoney' => $remoney, ':remoney2' => $remoney, ':creationTime' => $creationTime, ':uid' => $uid];
        $sql_l = "INSERT INTO k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)
		SELECT k.uid,k.username,:gameType,'RECALC',:id,:remoney,k.money-:remoney2,k.money,:creationTime FROM k_user k   WHERE k.uid=:uid ";
        $stmt_l       = $mydata1_db->prepare($sql_l);
        $stmt_l->execute($params_l);
        $params_c = [':id' => $id];
        if ($atype == 2) {
            $sql_c = 'update c_bet set js=0,win=money*odds,jieguo=\'\' where id=:id';
        } else {
            $sql_c = 'update c_bet_3 set js=0,win=money*odds,jieguo=\'\' where id=:id';
        }
        $stmt_c = $mydata1_db->prepare($sql_c);
        $stmt_c->execute($params_c);
        $result_num = $result_num + 1;
    }
    $params = [':qishu' => $qishu];
    if (in_array($atype, ['cqssc', 'tjssc', 'xjssc', 'sfssc', '4', 'bjpk10','xyft'])) {
        $sql = "update $autoTable set ok=0 where qishu=:qishu";
    } else {
        $params[':name'] = $atype;
        $sql             = "update $autoTable set ok =0 where qishu=:qishu and name=:name";
    }
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    include_once '../../class/admin.php';
    $message = '重算:' . $caizhong . '，期数：' . $qishu . '，' . $result_num . '条注单重算！';
    admin::insert_log($_SESSION['adminid'], $message);
    echo "<script>alert('重算成功！重算" . $result_num . "条注单!');</script>";
    if ($_GET['t'] == 1) {
        echo "<script>window.location.href='" . $return_url . "';</script>";
    }
}
?>