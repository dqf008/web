<?php
/* 真人电子数据统计 */
/* 后期考虑为平台进行分类 */
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
    $params[':stime'] = $time;
    $params[':etime'] = $time+86399;

    $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count` FROM `daily_report` WHERE `id`>:id AND `uid`=:uid AND `report_date` BETWEEN :stime AND :etime');
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $count = $rows['count'];

    $bet_amount = 0;
    $net_amount = 0;
    $valid_amount = 0;
    $rows_num = 0;
    while ($count>0) {
        $stmt = $mydata1_db->prepare('SELECT `id`, `bet_amount`, `net_amount`, `valid_amount`, `rows_num` FROM `daily_report` WHERE `id`>:id AND `uid`=:uid AND `report_date` BETWEEN :stime AND :etime ORDER BY `id` ASC LIMIT 5000');
        $stmt->execute($params);
        while ($rows = $stmt->fetch()) {
            $params[':id'] = $rows['id'];
            $rows_num+= $rows['rows_num'];
            $bet_amount+= $rows['bet_amount'];
            $net_amount+= $rows['net_amount'];
            $valid_amount+= $rows['valid_amount'];
        }
        $count-= 5000;
    }
    if($bet_amount>0||$net_amount>0||$valid_amount>0){
        $return[$time] = [
            'zrdz' => [
                'name' => '真人电子',
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
