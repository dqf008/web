<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/database/mysql.config.php';
$res = $mydata1_db->query('select conf from pay_conf where status=1 and conf<>""');
$list = $res->fetchAll();
foreach ($list as $k => $v) {
    foreach ($list as $data) eval($data[0]);
}