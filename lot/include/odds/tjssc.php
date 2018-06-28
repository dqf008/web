
<?php
!defined('IN_LOT')&&die('Access Denied');

$return = array();
$return[1] = array(
    '第一球',
    array(
        1 => '0',
        2 => '1',
        3 => '2',
        4 => '3',
        5 => '4',
        6 => '5',
        7 => '6',
        8 => '7',
        9 => '8',
        10 => '9',
        11 => '大',
        12 => '小',
        13 => '单',
        14 => '双',
    ),
);
$return[2] = $return[3] = $return[4] = $return[5] = $return[1];
$return[2][0] = '第二球';
$return[3][0] = '第三球';
$return[4][0] = '第四球';
$return[5][0] = '第五球';
$return[6] = array(
    '总和、龙虎和',
    array(
        1 => '总和大',
        2 => '总和小',
        3 => '总和单',
        4 => '总和双',
        5 => '龙',
        6 => '虎',
        7 => '和',
    ),
);
$return[7] = array(
    '前三',
    array(
        1 => '豹子',
        2 => '顺子',
        3 => '对子',
        4 => '半顺',
        5 => '杂六',
    ),
);
$return[8] = $return[9] = $return[7];
$return[8][0] = '中三';
$return[9][0] = '后三';
return $return;