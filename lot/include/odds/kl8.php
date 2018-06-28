<?php
!defined('IN_LOT')&&die('Access Denied');
/* 北京快乐8投注信息 */
$return = array();
$return[1] = array(
    array('选一', '中一'),
    range(0, 80),
);
unset($return[1][1][0]);
$return[2] = array(
    array('和值'),
    array(
        1 => '大',
        2 => '小',
        3 => '810',
        4 => '单',
        5 => '双',
    ),
);
$return[3] = array(
    array('上中下'),
    array(
        1 => '上',
        2 => '中',
        3 => '下',
    ),
);
$return[4] = array(
    array('奇和偶'),
    array(
        1 => '奇',
        2 => '和',
        3 => '偶',
    ),
);
return $return;