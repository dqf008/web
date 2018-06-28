<?php
!defined('IN_LOT') && die('Access Denied');
$lotteryTypes = array('gdchoose5'=>'GDSYXW','sdchoose5'=>'SDSYXW','fjchoose5'=>'FJSYXW','bjchoose5'=>'BJSYXW','ahchoose5'=>'ANSYXW');
$params = [':uid' => $LOT['user']['uid'], ':type' => $lotteryTypes[$LOT['lottery_type']]];
$sql    = 'SELECT * FROM `c_bet_choose5` WHERE `uid`=:uid AND `type`=:type';
$stmt   = $mydata1_db->prepare($sql);
$stmt->execute($params);
$rows         = $stmt->fetchAll();
$lotteryNames = [
    'gdchoose5' => '广东11选5',
    'sdchoose5' => '山东11选5',
    'fjchoose5' => '福建11选5',
    'bjchoose5' => '北京11选5',
    'ahchoose5' => '安徽11选5',
];
?>
<div class="tab tab-dialog">
    <h2 style="text-align:center;color:#6f4d28;font-weight:bold"><?php echo $lotteryNames[$LOT['lottery_type']] ?></h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>投注时间(美东/北京)</th>
            <th>下注单号</th>
            <th>下注期号</th>
            <th>投注信息</th>
            <th>下注金额</th>
            <th>可赢</th>
            <th>状态</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $v) { ?>
            <tr>
                <td>
                    <?php
                    echo $v['addtime'] . '<br/>' . date('Y-m-d H:i:s', strtotime($v['addtime']) + 12 * 3600);
                    ?>
                </td>
                <td><?= $v['id'] ?></td>
                <td><?= $v['qishu'] ?></td>
                <td><?= $v['mingxi_1'] ?>【<span style="color:red;"><?= $v['mingxi_2'] ?></span>】</td>
                <td><?= sprintf('%.2f', $v['money']) ?></td>
                <td><?= sprintf('%.2f', $v['odds'] * $v['money']) ?></td>
                <td>未结算</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>