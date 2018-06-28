<?php
/* 在线存款、人工汇款、红利派送、手续费数据统计 */
defined('IN_AGENT') || exit('Access Denied');

$return = [];

$params = [
    ':id' => 0,
    ':uid' => $uid,
    ':stime' => 0,
    ':etime' => 0,
];

foreach ($time_list as $time) {
    $params[':id'] = 0;
    $params[':stime'] = date('Y-m-d 00:00:00', $time);
    $params[':etime'] = date('Y-m-d 23:59:59', $time);

    $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count` FROM `k_money` WHERE `m_id`>:id AND `uid`=:uid AND `m_make_time` BETWEEN :stime AND :etime AND `status`=1 AND `type` BETWEEN 1 AND 5');
    $stmt->execute($params);
    $rows = $stmt->fetch();
    $count = $rows['count'];

    $bet_amount = 0;
    $qk_amount = 0;
    $reward_amount = 0;
    $fee_amount = 0;
    $rows_num = 0;
    $qk_rows_num = 0;
    $reward_rows_num = 0;
    while ($count > 0) {
        $stmt = $mydata1_db->prepare('SELECT `m_id`, `m_value`, `type`, `sxf` FROM `k_money` WHERE `m_id`>:id AND `uid`=:uid AND `m_make_time` BETWEEN :stime AND :etime AND `status`=1 AND `type` BETWEEN 1 AND 5 ORDER BY `m_id` ASC LIMIT 5000');
        $stmt->execute($params);
        while ($rows = $stmt->fetch()) {
            $params[':id'] = $rows['m_id'];
            if (in_array($rows['type'], [1, 3])) {
                $bet_amount += $rows['m_value'] * 100;
                $fee_amount += $rows['sxf'] * 100;
                $rows_num++;
            } else {
                if ($rows['type'] == 2) {
                    $qk_amount += $rows['m_value'] * -100;
                    $qk_rows_num++;
                } else {
                    $reward_amount += $rows['m_value'] * 100;
                    $reward_rows_num++;
                }
            }
        }
        $count -= 5000;
    }
    if ($bet_amount > 0 || $qk_amount > 0 || $reward_amount > 0 || $fee_amount > 0) {
        $return[$time] = [
            'hyck' => [
                'name' => '有效存款',
                'data' => [
                    'bet_amount' => $bet_amount,
                    'net_amount' => 0,
                    'valid_amount' => 0,
                    'rows_num' => $rows_num,
                ],
            ],
            'hyqk' => [
                'name' => '会员提款',
                'data' => [
                    'bet_amount' => $qk_amount,
                    'net_amount' => 0,
                    'valid_amount' => 0,
                    'rows_num' => $qk_rows_num,
                ],
            ],
            'hyhl' => [
                'name' => '红利派送',
                'data' => [
                    'bet_amount' => $reward_amount,
                    'net_amount' => 0,
                    'valid_amount' => 0,
                    'rows_num' => $reward_rows_num,
                ],
            ],
            'sxf' => [
                'name' => '手续费',
                'data' => [
                    'bet_amount' => $fee_amount,
                    'net_amount' => 0,
                    'valid_amount' => 0,
                    'rows_num' => $rows_num,
                ],
            ],
        ];
    }
}

return $return;
