<?php
/* 体育单式数据统计 */
defined('IN_AGENT')||exit('Access Denied');

$return = [];

$params = [
    ':id' => 0,
    ':uid' => $uid,
    ':stime' => 0,
    ':etime' => 0,
];

foreach($time_list as $time){
    $params[':id'] = 0;
    $params[':stime'] = date('Y-m-d 00:00:00', $time);
    $params[':etime'] = date('Y-m-d 23:59:59', $time);

    $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count` FROM `k_bet` WHERE `bid`>:id AND `uid`=:uid AND `status` IN (1, 2, 4, 5, 8) AND `bet_time` BETWEEN :stime AND :etime');
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $count = $rows['count'];

    $bet_amount = 0;
    $net_amount = 0;
    $valid_amount = 0;
    $rows_num = $count;
    while ($count>0) {
        $stmt = $mydata1_db->prepare('SELECT `bid`, `bet_money`, `win`, `status` FROM `k_bet` WHERE `bid`>:id AND `uid`=:uid AND `status` IN (1, 2, 4, 5, 8) AND `bet_time` BETWEEN :stime AND :etime ORDER BY `bid` ASC LIMIT 5000');
        $stmt->execute($params);
        while ($rows = $stmt->fetch()) {
            $params[':id'] = $rows['bid'];
            $bet_amount+= $rows['bet_money']*100;
            $net_amount+= ($rows['win']-$rows['bet_money'])*100;
            $valid_amount+= $rows['status']==8?0:$rows['bet_money']*($rows['status']==4||$rows['status']==5?50:100);
        }
        $count-= 5000;
    }
    if($bet_amount>0||$net_amount>0||$valid_amount>0){
        $return[$time] = [
            'xtty' => [
                'name' => '皇冠体育',
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
