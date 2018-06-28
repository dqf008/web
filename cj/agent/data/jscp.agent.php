<?php
/* 极速彩票数据统计 */
defined('IN_AGENT')||exit('Access Denied');

$return = [];

$params = [
    ':id' => 0,
    ':uid' => $uid,
    ':stime' => 0,
    ':etime' => 0,
    ':jssc' => 'JSSC',
    ':jsssc' => 'JSSSC',
    ':jslh' => 'JSLH',
];

foreach($time_list as $time){
    $params[':id'] = 0;
    $params[':stime'] = $time;
    $params[':etime'] = $time+86399;

    $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count` FROM `c_bet_data` WHERE `id`>:id AND `uid`=:uid AND `addtime` BETWEEN :stime AND :etime AND `status`=1 AND (`type`=:jssc OR `type`=:jsssc OR `type`=:jslh)');
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $count = $rows['count'];

    $bet_amount = 0;
    $net_amount = 0;
    $valid_amount = 0;
    $rows_num = $count;
    while ($count>0) {
        $stmt = $mydata1_db->prepare('SELECT `id`, `money`, `win` FROM `c_bet_data` WHERE `id`>:id AND `uid`=:uid AND `addtime` BETWEEN :stime AND :etime AND `status`=1 AND (`type`=:jssc OR `type`=:jsssc OR `type`=:jslh) ORDER BY `id` ASC LIMIT 5000');
        $stmt->execute($params);
        while ($rows = $stmt->fetch()) {
            $params[':id'] = $rows['id'];
            $bet_amount+= $rows['money'];
            $net_amount+= $rows['win']>0?$rows['win']-$rows['money']:$rows['win']; // 和局=0，赢+无本金派彩金额，输-本金
            $valid_amount+= $rows['win']==$rows['money']?0:$rows['money'];
        }
        $count-= 5000;
    }
    if($bet_amount>0||$net_amount>0||$valid_amount>0){
        $return[$time] = [
            'jscp' => [
                'name' => '极速彩票',
                'data' => [
                    'bet_amount' => $bet_amount,
                    'net_amount' => $net_amount,
                    'valid_amount' => $valid_amount,
                    'rows_num' => $rows_num,
                ]
            ]
        ];
    }
}

return $return;
