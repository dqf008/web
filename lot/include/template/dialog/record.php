<?php
!defined('IN_LOT')&&die('Access Denied');
$LOT['l'] = isset($_GET['lotteryId'])?$_GET['lotteryId']:'default';
$LOT['l'] = isset($LOT['game'][$LOT['l']])?$LOT['l']:key($LOT['game']);
$l = $LOT['l'];
$k3LotteryName = ['jsk3', 'ynk3', 'fjk3', 'gxk3', 'jxk3', 'shk3', 'hebk3', 'hbk3', 'ahk3', 'jlk3', 'hnk3', 'gzk3', 'bjk3', 'qhk3', 'gsk3', 'nmgk3'];
if (in_array($LOT['l'], $k3LotteryName)) {
    $LOT['lottery_type'] = $LOT['l'];
    $l='k3';
}
$choose5LotteryName = ['gdchoose5', 'sdchoose5', 'fjchoose5', 'bjchoose5', 'ahchoose5', 'yfchoose5', 'sfchoose5'];
if (in_array($LOT['l'], $choose5LotteryName)) {
    $LOT['lottery_type'] = $LOT['l'];
    $l='choose5';
}
$LOT['sql'] = array();
if($LOT['user']['login']){
    $LOT['sql']['pk10'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `c_bet_3` WHERE `uid`=:uid AND `type`=:type AND `js`=0',
        array(
            ':type' => '北京赛车PK拾',
            ':uid' => $LOT['user']['uid'],
        ),
    );
    $LOT['sql']['xyft'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `c_bet_3` WHERE `uid`=:uid AND `type`=:type AND `js`=0',
        array(
            ':type' => '幸运飞艇',
            ':uid' => $LOT['user']['uid'],
        ),
    );
    $LOT['sql']['cqssc'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `c_bet` WHERE `uid`=:uid AND `type`=:type AND `js`=0',
        array(
            ':type' => '重庆时时彩',
            ':uid' => $LOT['user']['uid'],
        ),
    );
    $LOT['sql']['gdkl10'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `c_bet_3` WHERE `uid`=:uid AND `type`=:type AND `js`=0',
        array(
            ':type' => '广东快乐10分',
            ':uid' => $LOT['user']['uid'],
        ),
    );
    $LOT['sql']['shssl'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_ok`=0',
        array(
            ':type' => 'ssl',
            ':username' => $LOT['user']['username'],
        ),
    );
    $LOT['sql']['pl3'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_ok`=0',
        array(
            ':type' => 'pl3',
            ':username' => $LOT['user']['username'],
        ),
    );
    $LOT['sql']['3d'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_ok`=0',
        array(
            ':type' => '3d',
            ':username' => $LOT['user']['username'],
        ),
    );
    $LOT['sql']['kl8'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_ok`=0',
        array(
            ':type' => 'kl8',
            ':username' => $LOT['user']['username'],
        ),
    );
    $LOT['sql']['qxc'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_ok`=0',
        array(
            ':type' => 'qxc',
            ':username' => $LOT['user']['username'],
        ),
    );
    $LOT['sql']['marksix'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`sum_m`) AS `sum` FROM `mydata2_db`.`ka_tan` WHERE `username`=:username AND `checked`=0',
        array(
            ':username' => $LOT['user']['username'],
        ),
    );
    $LOT['sql']['jssc'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`money`/100) AS `sum` FROM `c_bet_data` WHERE `uid`=:uid AND `type`=:type AND `status`=0',
        array(
            ':type' => 'JSSC',
            ':uid' => $LOT['user']['uid'],
        ),
    );
    $LOT['sql']['jsssc'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`money`/100) AS `sum` FROM `c_bet_data` WHERE `uid`=:uid AND `type`=:type AND `status`=0',
        array(
            ':type' => 'JSSSC',
            ':uid' => $LOT['user']['uid'],
        ),
    );
    $LOT['sql']['jslh'] = array(
        'SELECT COUNT(*) AS `count`, SUM(`money`/100) AS `sum` FROM `c_bet_data` WHERE `uid`=:uid AND `type`=:type AND `status`=0',
        array(
            ':type' => 'JSLH',
            ':uid' => $LOT['user']['uid'],
        ),
    );
}
?>

        <div class="tab tab-dialog">
			<?php include(IN_LOT.'include/template/dialog/record_'.$l.'.php'); ?>
        </div>


        <script>require(['dialog-index'], function (Account) {new Account();})</script>
