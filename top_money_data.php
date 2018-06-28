<?php
session_start();
require __DIR__ . '/class/Db.class.php';
$uid = (int)$_SESSION['uid'];
if ($uid == 0) output(['status' => 0]);
$DB = new DB();
$sql = 'select a.uid,money,is_stop,gid,is_daili from k_user a left join k_user_login b on a.uid=b.uid where b.is_login=1 and a.is_stop=0 and a.uid=:uid';
$res = $DB->row($sql, ['uid' => $uid]);
if (empty($res)) {
    $DB->query('update `k_user_login` set `is_login`=0 WHERE `uid`=:uid', ['uid' => $uid]);
    unset($_SESSION['uid']);
    unset($_SESSION['is_daili']);
    unset($_SESSION['gid']);
    unset($_SESSION['username']);
    unset($_SESSION['denlu']);
    unset($_SESSION['user_login_id']);
    unset($_SESSION['password']);
    session_destroy();
    output(['status' => 0]);
}
$_SESSION['is_daili'] = $res['is_daili'];
$_SESSION['gid'] = $res['gid'];
$return['status'] = 1;
$return['user_money'] = sprintf('%.2f', $res['money']);
$return['user_num'] = $DB->single('select count(*) as s from k_user_msg where islook=0 and uid=:uid', ['uid' => $uid]);
$intimes = time();
$login_id = $intimes . '_' . $uid . '_' . $_SESSION['username'];
$params = ['login_id' => $login_id, 'login_time' => $intimes, 'uid' => $uid];
$DB->query('update `k_user_login` set `login_id`=:login_id,`login_time`=:login_time,`is_login`=1 WHERE `uid`=:uid', $params);
$DB->CloseConnection();
output($return);
function output($return)
{
    echo isset($_GET['callback']) ? strip_tags($_GET['callback']) : 'callback';
    echo '(' . json_encode($return) . ')';
    exit;
}