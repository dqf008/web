<?php 
include_once ("../../../database/mysql.config.php");
$res = $mydata1_db->query('select content from webinfo where code="pay_conf"')->fetch();
eval($res['content']);