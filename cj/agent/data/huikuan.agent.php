<?php
/* 在线汇款、手续费数据统计 */
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

    $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count` FROM `huikuan` WHERE `id`>:id AND `uid`=:uid AND `adddate` BETWEEN :stime AND :etime AND `status`=1');
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $count = $rows['count'];

    $bet_amount = 0;
    $fee_amount = 0;
    $rows_num = $count;
    while ($count>0) {
        $stmt = $mydata1_db->prepare('SELECT `id`, `money`, `zsjr` FROM `huikuan` WHERE `id`>:id AND `uid`=:uid AND `adddate` BETWEEN :stime AND :etime AND `status`=1 ORDER BY `id` ASC LIMIT 5000');
        $stmt->execute($params);
        while ($rows = $stmt->fetch()) {
            $params[':id'] = $rows['id'];
            $bet_amount+= $rows['money']*100;
            $fee_amount+= $rows['zsjr']*100;
        }
        $count-= 5000;
    }
    if($bet_amount>0||$fee_amount>0){
        $return[$time] = [
            'hyck' => [
                'name' => '有效存款',
                'data' => [
                    'bet_amount' => $bet_amount,
                    'net_amount' => 0,
                    'valid_amount' => 0,
                    'rows_num' => $rows_num,
                ]
            ],
            'sxf' => [
                'name' => '手续费',
                'data' => [
                    'bet_amount' => $fee_amount,
                    'net_amount' => 0,
                    'valid_amount' => 0,
                    'rows_num' => $rows_num,
                ]
            ]
        ];
    }
}

return $return;
