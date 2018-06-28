<?php include_once '../../database/mysql.config.php';
unset($webdb);
$webdb = array();
$webdb['datesite_login'] = 'http://www.hg1088.com';
$webdb['user'] = '';
$webdb['pawd'] = '';
$webdb['uid'] = '1';
$sql = 'select cookie,hg_action from mydata3_db.sys_admin';
$query = $mydata1_db->query($sql);
$rows = $query->fetch();
$webdb['cookie'] = $rows['cookie'];
$webdb['datesite'] = $rows['hg_action'];?>