<?php
!defined('IN_LOT')&&die('Access Denied');
/* 北京赛车PK10投注信息 */
$return = array();
$return[1] = array(
    '定位',
    array(
        1 => '一定位',
        2 => '二定位',
        3 => '三定位',
        4 => '四定位',
    ),
);
$return[2] = array(
    '字现',
    array(
        1 => '二字现',
        2 => '三字现',
    ),
);
return $return;