<?php
require_once __DIR__ . '/mysql.user.php';
$driver_options = array(
	PDO::ATTR_PERSISTENT => php_sapi_name() != 'cli',
	PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8",
	PDO::ATTR_EMULATE_PREPARES => false,
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
unset($mydata1_db);
unset($mydata2_db);
unset($mydata5_db);
$mydata1_db = new PDO('mysql:host=127.0.0.1;dbname=mydata1_db;charset=utf8', $db_user_utf8, $db_pwd_utf8, $driver_options);
$mydata2_db = new PDO('mysql:host=127.0.0.1;dbname=mydata2_db;charset=utf8', $db_user_utf8, $db_pwd_utf8, $driver_options);
$mydata5_db = new PDO('mysql:host=127.0.0.1;dbname=mydata5_db;charset=utf8', $db_user_utf8, $db_pwd_utf8, $driver_options);