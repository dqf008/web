<?php
session_start();
$_DIR = dirname(dirname(__FILE__));
$_DIR = str_replace('\\', '/', $_DIR);
substr($_DIR, -1) != '/' && $_DIR .= '/';
define('IN_AGENT', $_DIR);
$AGENT = [
    'user' => [
        'login' => false,
    ],
    'groups' => [],
    'config' => [],
];

include(IN_AGENT.'../include/config.php');
website_close();
website_deny();
include(IN_AGENT.'../database/mysql.config.php');
include(IN_AGENT.'include/functions.php');
include(IN_AGENT.'../myfunction.php');
file_exists(IN_AGENT.'../cache/agent.conf.php') && $AGENT['config'] = include(IN_AGENT.'../cache/agent.conf.php');

/* 加载用户信息 */
if (isset($_SESSION['uid']) && isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $params = [':uid' => $_SESSION['uid']];
    $stmt = $mydata1_db->prepare('SELECT `u`.`uid`, `u`.`username`, `u`.`mobile`, `u`.`login_time`, `u`.`pay_name`, `u`.`pay_num`, `u`.`is_daili` AS `agent`, `c`.`id`, `c`.`tid` FROM `k_user` AS `u` LEFT JOIN `agent_config` AS `c` ON `u`.`uid`=`c`.`uid` WHERE `u`.`uid`=:uid AND `u`.`is_stop`=0 AND `u`.`is_delete`=0 LIMIT 1');
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        $rows = $stmt->fetch();
        $AGENT['user']['login'] = true;
        $AGENT['user']['uid'] = $rows['uid'];
        $AGENT['user']['tid'] = $rows['tid'];
        $AGENT['user']['username'] = $rows['username'];
        $AGENT['user']['agent'] = $rows['agent'] == 1;
        $AGENT['user']['mobile'] = $rows['mobile'];
        $AGENT['user']['pay_name'] = $rows['pay_name'];
        $AGENT['user']['pay_num'] = $rows['pay_num'];
        $AGENT['user']['login_time'] = $rows['login_time'];
        $AGENT['user']['team'] = false;
        $AGENT['user']['invite'] = false;
        if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
            $AGENT['user']['url'] = 'https://'.$_SERVER['HTTP_HOST'];
            $_SERVER['SERVER_PORT'] != '443' && $AGENT['user']['url'] .= ':'.$_SERVER['SERVER_PORT'];
        } else {
            $AGENT['user']['url'] = 'http://'.$_SERVER['HTTP_HOST'];
            $_SERVER['SERVER_PORT'] != '80' && $AGENT['user']['url'] .= ':'.$_SERVER['SERVER_PORT'];
        }
        $AGENT['user']['url'] .= '/?f='.$rows['username'];
        $AGENT['groups'] = get_agent_groups(true);
        if (isset($AGENT['groups']['default']) && empty($rows['tid'])) {
            $AGENT['user']['tid'] = $rows['tid'] = $AGENT['groups']['default']['rows_id'];
            $params = [];
            if (empty($rows['id'])) {
                $sql = 'INSERT INTO `agent_config` (`uid`, `tid`, `username`, `value`) VALUES (?, ?, ?, ?)';
                $params[] = $AGENT['user']['uid'];
                $params[] = $AGENT['user']['tid'];
                $params[] = $AGENT['user']['username'];
                $params[] = 'a:0:{}';
            } else {
                $sql = 'UPDATE `agent_config` SET `tid`=? WHERE `id`=?';
                $params[] = $AGENT['user']['tid'];
                $params[] = $rows['id'];
            }
            $stmt = $mydata1_db->prepare($sql);
            $stmt->execute($params);
        }
        unset($AGENT['groups']['default']);
        if (! empty($rows['tid'])) {
            $AGENT['user']['team'] = isset($AGENT['groups'][$AGENT['user']['tid']]['child_groups']);
            $AGENT['user']['invite'] = $AGENT['groups'][$AGENT['user']['tid']]['add_dl'] == 1;
        }
    }
}

function get_agent_details($uid = 0, $tid = 0, $team = false)
{
    $return = [
        'total' => 0,
        '7days' => 0,
        '30days' => 0,
        'm_yesterday' => 0,
        'm_7days' => 0,
        'm_30days' => 0,
        'w_yesterday' => 0,
        'w_7days' => 0,
        'w_30days' => 0,
        'c_yesterday' => 0,
        'c_7days' => 0,
        'c_30days' => 0,
        'q_yesterday' => 0,
        'q_7days' => 0,
        'q_30days' => 0,
        // 't_yesterday' => 0,
        // 't_7days' => 0,
        // 't_30days' => 0,
    ];
    $date = strtotime(date('Y-m-d 23:59:59'));
    $user = [];
    $agent = [];
    $stmt = $GLOBALS['mydata1_db']->prepare('SELECT `uid`, `username`, `reg_date`, `is_daili` FROM `k_user` WHERE `top_uid`=:uid');
    $stmt->execute([':uid' => $uid]);
    while ($rows = $stmt->fetch()) {
        $user[$rows['uid']] = $rows['username'];
        $rows['is_daili'] == 1 && $agent[] = $rows['uid'];
        $rows['reg_date'] = strtotime($rows['reg_date']);
        $return['total']++;
        $date < $rows['reg_date'] + 604801 && $return['7days']++;
        $date < $rows['reg_date'] + 2592001 && $return['30days']++;
    }
    $groups = $GLOBALS['AGENT']['groups'];
    if ($tid > 0 && isset($groups[$tid])) {
        $agent_config = get_agent_config($groups[$tid]);
        if (! empty($agent_config)) {
            $agent_amount = get_child_agent_details($uid, $agent_config, $date);
            $return['m_yesterday'] += $agent_amount['yesterday'];
            $return['m_7days'] += $agent_amount['7days'];
            $return['m_30days'] += $agent_amount['30days'];
            $return['w_yesterday'] += $agent_amount['w_yesterday'];
            $return['w_7days'] += $agent_amount['w_7days'];
            $return['w_30days'] += $agent_amount['w_30days'];
            $return['c_yesterday'] += $agent_amount['c_yesterday'];
            $return['c_7days'] += $agent_amount['c_7days'];
            $return['c_30days'] += $agent_amount['c_30days'];
            $return['q_yesterday'] += $agent_amount['q_yesterday'];
            $return['q_7days'] += $agent_amount['q_7days'];
            $return['q_30days'] += $agent_amount['q_30days'];
        }
        if ($team && ! empty($agent) && isset($groups[$tid]['child_groups']) && ! empty($groups[$tid]['child_groups'])) {
            $child_groups = get_child_agent_config($agent_config, $groups, $groups[$tid]['child_groups']);
            $child_agent = get_child_agent_details($agent, $child_groups, $date, true);
            $return['t_yesterday'] = $child_agent['yesterday'];
            $return['t_7days'] = $child_agent['7days'];
            $return['t_30days'] = $child_agent['30days'];
        }
    }

    return $return;
}

function get_child_agent_details($uid = [], $config = [], $date = 0, $team = false, $index = 1)
{
    $return = [
        'yesterday' => 0,
        '7days' => 0,
        '30days' => 0,
        'w_yesterday' => 0,
        'w_7days' => 0,
        'w_30days' => 0,
        'c_yesterday' => 0,
        'c_7days' => 0,
        'c_30days' => 0,
        'q_yesterday' => 0,
        'q_7days' => 0,
        'q_30days' => 0,
    ];
    if (! empty($uid)) {
        $params = [
            ':stime' => $date - 2678399,
            ':etime' => $date - 86400,
        ];
        is_array($uid) || $uid = [$uid];
        $ids = implode(', ', $uid);
        if (count($uid) > 1) {
            $sql = 'SELECT `cache_date`, `value` FROM `agent_cache` WHERE `cache_date` BETWEEN :stime AND :etime AND `uid` IN ('.$ids.')';
            $user_sql = 'SELECT `uid` FROM `k_user` WHERE `is_daili`=1 AND `top_uid` IN ('.$ids.')';
        } else {
            $params[':uid'] = $ids;
            $sql = 'SELECT `cache_date`, `value` FROM `agent_cache` WHERE `uid`=:uid AND `cache_date` BETWEEN :stime AND :etime';
            $user_sql = 'SELECT `uid` FROM `k_user` WHERE `is_daili`=1 AND `top_uid`='.$ids;
        }
        if ($team) {
            if ($index + 1 < count($config)) {
                $uid = [];
                $stmt = $GLOBALS['mydata1_db']->query($user_sql);
                while ($rows = $stmt->fetch()) {
                    $uid[] = $rows['uid'];
                }
                $return = get_child_agent_details($uid, $config, $date, true, $index + 1);
            }
            $config = $config[$index];
        }
        $stmt = $GLOBALS['mydata1_db']->prepare($sql);
        $stmt->execute($params);
        while ($rows = $stmt->fetch()) {
            $rows['value'] = unserialize($rows['value']);
            $agent_amount = get_agent_amount($config, $rows['value']);
            $net_amount = 0;
            $ck_amount = 0;
            $qk_amount = 0;
            foreach ($rows['value'] as $key => $item) {
                $net_amount += $item['data']['net_amount'];
                if ($key == 'hyck') {
                    $ck_amount += $item['data']['bet_amount'];
                }
                if ($key == 'hyqk') {
                    $qk_amount += $item['data']['bet_amount'];
                }
            }
            if ($date <= $rows['cache_date'] + 172799) {
                $return['yesterday'] += $agent_amount;
                $return['w_yesterday'] += $net_amount;
                $return['c_yesterday'] += $ck_amount;
                $return['q_yesterday'] += $qk_amount;
            }
            if ($date <= $rows['cache_date'] + 691199) {
                $return['7days'] += $agent_amount;
                $return['w_7days'] += $net_amount;
                $return['c_7days'] += $ck_amount;
                $return['q_7days'] += $qk_amount;
            }
            $return['30days'] += $agent_amount;
            $return['w_30days'] += $net_amount;
            $return['c_30days'] += $ck_amount;
            $return['q_30days'] += $qk_amount;
        }
    }

    return $return;
}

function check_child_agent($top_uid = 0, $uids = [], $child_ids = [])
{
    $params = [];
    $count = 0;
    $sql = [];
    if (! empty($uids)) {
        foreach ($uids as $uid) {
            $params[] = $top_uid;
            $params[] = $uid;
            $top_uid = $uid;
            $count++;
            $sql[] = '(`top_uid`=? AND `uid`=?)';
        }
    }
    if (! empty($child_ids)) {
        $params[] = $top_uid;
        $params = array_merge($params, $child_ids);
        $child_ids = count($child_ids);
        $count += $child_ids;
        $sql[] = '(`top_uid`=? AND `uid` IN (?'.str_repeat(', ?', $child_ids - 1).'))';
    }
    if ($count > 0) {
        // $stmt = $GLOBALS['mydata1_db']->prepare('SELECT COUNT(*) AS `count` FROM `k_user` WHERE `is_daili`=1 AND ('.implode(' OR ', array_fill(0, $count, '(`top_uid`=? AND `uid`=?)')).')');
        // $stmt = $GLOBALS['mydata1_db']->prepare('SELECT COUNT(*) AS `count` FROM `k_user` WHERE `is_daili`=1 AND ((`top_uid`=? AND `uid`=?)'.str_repeat(' OR (`top_uid`=? AND `uid`=?)', $count-1).')');
        $stmt = $GLOBALS['mydata1_db']->prepare('SELECT COUNT(*) AS `count` FROM `k_user` WHERE `is_daili`=1 AND ('.implode(' OR ',
                $sql).')');
        $stmt->execute($params);
        $rows = $stmt->fetch();

        return $rows['count'] == $count;
    } else {
        return false;
    }
}

function get_agent_key($data)
{
    $_SESSION['AGENT_KEY'] = hash('sha256',
        session_name().$GLOBALS['AGENT']['user']['username'].uniqid().time().'agent20180321');
    $sha256 = hash('sha256', $data.$_SESSION['AGENT_KEY']);
    $sha512 = hash_hmac('sha512', $sha256, $_SESSION['AGENT_KEY']);

    return $sha512;
}

function check_agent_key($data, $key)
{
    $return = false;
    if (isset($_SESSION['AGENT_KEY'])) {
        $sha256 = hash('sha256', $data.$_SESSION['AGENT_KEY']);
        $sha512 = hash_hmac('sha512', $sha256, $_SESSION['AGENT_KEY']);
        $return = $key == $sha512;
    }

    return $return;
}
