<?php
/* 普通彩票数据统计 */
defined('IN_AGENT')||exit('Access Denied');

$return = [];

$params = [
    ':id' => 0,
    ':username' => $username,
    ':stime' => 0,
    ':etime' => 0,
];

foreach($time_list as $time){
    $params[':id'] = 0;
    $params[':stime'] = date('Y-m-d 00:00:00', $time);
    $params[':etime'] = date('Y-m-d 23:59:59', $time);

    $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count` FROM `lottery_data` WHERE `id`>:id AND `username`=:username AND `bet_time` BETWEEN :stime AND :etime AND `bet_ok`=1');
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $count = $rows['count'];

    $bet_amount = 0;
    $net_amount = 0;
    $valid_amount = 0;
    $rows_num = $count;
    while ($count>0) {
        $stmt = $mydata1_db->prepare('SELECT `id`, `money`, `win` FROM `lottery_data` WHERE `id`>:id AND `username`=:username AND `bet_time` BETWEEN :stime AND :etime AND `bet_ok`=1 ORDER BY `id` ASC LIMIT 5000');
        $stmt->execute($params);
        while ($rows = $stmt->fetch()) {
            $params[':id'] = $rows['id'];
            $bet_amount+= $rows['money']*100;
            $net_amount+= $rows['win']*100;
            $valid_amount+= $rows['win']==0?0:$rows['money']*100;
        }
        $count-= 5000;
    }
    if($bet_amount>0||$net_amount>0||$valid_amount>0){
        $return[$time] = [
            'ptcp' => [
                'name' => '普通彩票',
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
