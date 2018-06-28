<?php
/* 香港六合彩数据统计 */
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
    $params[':stime'] = date('Y-m-d 12:00:00', $time);
    $params[':etime'] = date('Y-m-d 11:59:59', $time+86400);

    $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count` FROM `mydata2_db`.`ka_tan` WHERE `id`>:id AND `username`=:username AND `adddate` BETWEEN :stime AND :etime AND `checked`=1');
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $count = $rows['count'];

    $bet_amount = 0;
    $net_amount = 0;
    $valid_amount = 0;
    $rows_num = $count;
    while ($count>0) {
        $stmt = $mydata1_db->prepare('SELECT `id`, `sum_m`, `rate`, `bm` FROM `mydata2_db`.`ka_tan` WHERE `id`>:id AND `username`=:username AND `adddate` BETWEEN :stime AND :etime AND `checked`=1 ORDER BY `id` ASC LIMIT 5000');
        $stmt->execute($params);
        while ($rows = $stmt->fetch()) {
            $params[':id'] = $rows['id'];
            $bet_amount+= $rows['sum_m']*100;
            if($rows['bm']!=2){
                $net_amount+= (($rows['bm']==1?$rows['sum_m']*$rows['rate']:0)-$rows['sum_m'])*100;
                $valid_amount+= $rows['sum_m']*100;
            }
        }
        $count-= 5000;
    }
    if($bet_amount>0||$net_amount>0||$valid_amount>0){
        $return[$time] = [
            'lhc' => [
                'name' => '六合彩',
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
