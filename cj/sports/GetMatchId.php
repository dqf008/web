<?php
include_once __DIR__ . '/../../class/Db.class.php';

$db = new DB();
$startTime = date('Y-m-d 00:00:00', strtotime('-1 day'));
$rows = $db->query('SELECT `ball_sort`, `match_id` FROM `k_bet` WHERE `status`=0 AND `lose_ok`=1 AND `bet_time`>=\''.$startTime.'\'');
$db->CloseConnection();

$return = [
    'basketball' => [],
    'football' => [],
];

foreach ($rows as $row) {
    if (isType($row['ball_sort'], '篮球')) {
        !in_array($row['match_id'], $return['basketball'])&&$return['basketball'][] = $row['match_id'];
    }else if(isType($row['ball_sort'], '足球')){
        !in_array($row['match_id'], $return['football'])&&$return['football'][] = $row['match_id'];
    }
}

function isType($s, $t) {
    return $s != str_replace($t, '', $s);
}

echo json_encode($return, JSON_UNESCAPED_UNICODE);