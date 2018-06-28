<?php
header('Content-Type: application/json; charset=UTF-8');
include_once 'include/config.php';
include_once 'database/mysql.config.php';
include_once 'member/function.php';

$_argv = array();
$return = array('status' => '98', 'msg' => '缺少参数', 'uid' => 0, 'type' => 0, 'url' => '', 'data' => array());
if(isset($_SERVER['PATH_INFO'])&&!empty($_SERVER['PATH_INFO'])){
    $_SERVER['PATH_INFO'] = explode('/', $_SERVER['PATH_INFO']);
    foreach($_SERVER['PATH_INFO'] as $val){
        $val!=''&&$_argv[] = $val;
    }
}
if(count($_argv)>=2){
    $return['status'] = '97';
    $return['msg'] = '用户名或密码错误';
    $params = array();
    $user = array();
    $params[':username'] = $_argv[0];
    $stmt = $mydata1_db->prepare('SELECT `uid`, `username`, `is_daili`, `is_stop`, `password`, `pay_name` FROM `k_user` WHERE `username`=:username AND `is_delete`=0');
    $stmt->execute($params);
    if($stmt->rowCount()>0){
        $user = $stmt->fetch();
        if(($user['is_daili']==1||($user['is_daili']==0&&$user['is_stop']==0))&&md5($user['password'].'ABPT')==$_argv[1]){
            $return['status'] = '00';
            $return['msg'] = '';
            $return['uid'] = $user['uid'];
            $return['type'] = $user['is_daili']?1:2;
            $return['url'] = $user['is_daili']?'http://'.$conf_www.'/?f='.$user['username']:'';
        }
    }
    if($return['status']=='00'&&isset($_argv[2])){
        switch (strtolower($_argv[2])) {
            /* 注册代理 */
            case 'reg':
                $return['data']['status'] = '98';
                $return['data']['msg'] = '请求不正确';
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    if($user['is_daili']==1){
                        $return['data']['status'] = '02';
                        $return['data']['msg'] = '已通过申请';
                    }else{
                        $_POST['mobile'] = isset($_POST['mobile'])&&is_string($_POST['mobile'])?$_POST['mobile']:'';
                        $_POST['email'] = isset($_POST['email'])&&is_string($_POST['email'])?$_POST['email']:'';
                        $_POST['about'] = isset($_POST['about'])&&is_string($_POST['about'])?$_POST['about']:'';
                        $stmt = $mydata1_db->prepare('SELECT `d_id` FROM `k_user_daili` WHERE `uid`=:uid AND `add_time` BETWEEN :bdate AND :edate');
                        $stmt->execute(array(
                            'uid' => $user['uid'],
                            'bdate' => date('Y-m-d').' 00:00:00',
                            'edate' => date('Y-m-d').' 23:59:59',
                        ));
                        switch (true) {
                            case $stmt->rowCount()>0:
                                $return['data']['status'] = '01';
                                $return['data']['msg'] = '今日已申请';
                                break;

                            case $_POST['mobile']!=''&&!preg_match('/^[1-9]\d{10}$/', $_POST['mobile']):
                                $return['data']['status'] = '03';
                                $return['data']['msg'] = '手机号不符合规则';
                                break;

                            case $_POST['email']!=''&&!preg_match('/^[\w!#$%&\'*+\/=?^_`{|}~-]+(?:\.[\w!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?$/', $_POST['email']):
                                $return['data']['status'] = '04';
                                $return['data']['msg'] = '电子邮箱不符合规则';
                                break;

                            case strlen($_POST['about'])<20:
                                $return['data']['status'] = '05';
                                $return['data']['msg'] = '申请理由必须大于20个字符';
                                break;

                            default:
                                $return['data']['status'] = '00';
                                $return['data']['msg'] = '';
                                $stmt = $mydata1_db->prepare('INSERT INTO `k_user_daili` (`uid`, `r_name`, `mobile`, `email`, `about`, `add_time`) VALUES (:uid, :r_name, :mobile, :email, :about, :add_time)');
                                if(!$stmt->execute(array(
                                    ':uid' => $user['uid'],
                                    ':r_name' => $user['pay_name'],
                                    ':mobile' => $_POST['mobile'],
                                    ':email' => $_POST['email'],
                                    ':about' => $_POST['about'],
                                    ':add_time' => date('Y-m-d H:i:s'),
                                ))){
                                    $return['data']['status'] = '99';
                                    $return['data']['msg'] = '未知错误';
                                }
                                break;
                        }
                    }
                }
                break;

            /* 下线会员列表 */
            case 'list':
                if($user['is_daili']==1){
                    $return['data']['status'] = '00';
                    $return['data']['msg'] = '';
                    $return['data']['count'] = 0;
                    $return['data']['list'] = array();
                    $sql = 'SELECT `u`.`uid`, `u`.`username`, `u`.`pay_name`, `u`.`reg_date`, `u`.`login_time`, `u`.`money`, `l`.`is_login`, `u`.`is_stop` FROM `k_user` AS `u` LEFT JOIN `k_user_login` AS `l` ON `l`.`uid`=`u`.`uid` WHERE `u`.`top_uid`=:uid';
                    $params = array(':uid' => $user['uid']);
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        if(isset($_POST['username'])&&is_string($_POST['username'])&&!empty($_POST['username'])){
                            $sql.= ' AND `u`.`username` LIKE :username';
                            $params[':username'] = '%'.$_POST['username'].'%';
                        }
                        if(isset($_POST['realname'])&&is_string($_POST['realname'])&&!empty($_POST['realname'])){
                            $sql.= ' AND `u`.`pay_name` LIKE :realname';
                            $params[':realname'] = '%'.$_POST['realname'].'%';
                        }
                    }
                    $stmt = $mydata1_db->prepare($sql.' ORDER BY `u`.`uid` DESC');
                    $stmt->execute($params);
                    $return['data']['count'] = $stmt->rowCount();
                    if($return['data']['count']>0){
                        (!isset($_argv[3])||!preg_match('/^[1-9]\d*$/', $_argv[3]))&&$_argv[3] = 1;
                        (!isset($_argv[4])||!preg_match('/^[1-9]\d*$/', $_argv[4]))&&$_argv[4] = 20;
                        $_argv[3] = ($_argv[3]-1)*$_argv[4];
                        $i = 1;
                        while ($rows = $stmt->fetch()) {
                            if($i>$_argv[3]){
                                $return['data']['list'][] = array(
                                    'uid' => $rows['uid'],
                                    'username' => $rows['username'],
                                    'realname' => $rows['pay_name'],
                                    'regtime' => strtotime($rows['reg_date']),
                                    'logintime' => strtotime($rows['login_time']),
                                    'money' => round($rows['money']*100),
                                    'online' => $rows['is_login']==1?1:0,
                                    'status' => $rows['is_stop']==0?1:0,
                                );
                                $_argv[4]--;
                            }
                            if($_argv[4]<=0){
                                break;
                            }else{
                                $i++;
                            }
                        }
                    }
                }else{
                    $return['data']['status'] = '98';
                    $return['data']['msg'] = '非代理账号';
                }
                break;

            /* 存款记录 */
            case 'deposit':
                if($user['is_daili']==1){
                    $return['data']['status'] = '00';
                    $return['data']['msg'] = '';
                    (!isset($_argv[3])||!preg_match('/^[1-9]\d{7}$/', $_argv[3]))&&$_argv[3] = date('Ymd', time()-518400);
                    $return['data']['start'] = intval($_argv[3]);
                    $_argv[3] = substr($_argv[3], 0, 4).'-'.substr($_argv[3], 4, 2).'-'.substr($_argv[3], 6, 2);
                    (!isset($_argv[4])||!preg_match('/^[1-9]\d{7}$/', $_argv[4]))&&$_argv[4] = date('Ymd', strtotime($_argv[3])+518400);
                    $return['data']['end'] = intval($_argv[4]);
                    $_argv[4] = substr($_argv[4], 0, 4).'-'.substr($_argv[4], 4, 2).'-'.substr($_argv[4], 6, 2);
                    $sql = 'SELECT `u`.`uid`, `u`.`username`, `m`.`m_make_time`, `m`.`m_order`, `m`.`m_value`, `m`.`sxf`, `m`.`status` FROM `k_money` AS `m` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`m`.`uid` WHERE `u`.`top_uid`=:uid AND `m`.`type`=1 AND `m`.`m_make_time` BETWEEN :bdate AND :edate';
                    $params = array(
                        ':uid' => $user['uid'],
                        ':bdate' => $_argv[3].' 00:00:00',
                        ':edate' => $_argv[4].' 23:59:59',
                    );
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        if(isset($_POST['username'])&&is_string($_POST['username'])&&!empty($_POST['username'])){
                            $sql.= ' AND `u`.`username`=:username';
                            $params[':username'] = $_POST['username'];
                        }
                    }
                    $stmt = $mydata1_db->prepare($sql.' ORDER BY `m`.`m_id` DESC');
                    $stmt->execute($params);
                    $return['data']['count'] = $stmt->rowCount();
                    $return['data']['list'] = array();
                    if($return['data']['count']>0){
                        (!isset($_argv[5])||!preg_match('/^[1-9]\d*$/', $_argv[5]))&&$_argv[5] = 1;
                        (!isset($_argv[6])||!preg_match('/^[1-9]\d*$/', $_argv[6]))&&$_argv[6] = 20;
                        $_argv[5] = ($_argv[5]-1)*$_argv[6];
                        $i = 1;
                        while ($rows = $stmt->fetch()) {
                            if($i>$_argv[5]){
                                $return['data']['list'][] = array(
                                    'uid' => $rows['uid'],
                                    'username' => $rows['username'],
                                    'createtime' => strtotime($rows['m_make_time']),
                                    'orderid' => $rows['m_order'],
                                    'money' => round($rows['m_value']*100),
                                    'fee' => round($rows['sxf']*100),
                                    'status' => $rows['status']==1?1:0,
                                );
                                $_argv[6]--;
                            }
                            if($_argv[6]<=0){
                                break;
                            }
                            $i++;
                        }
                    }
                }else{
                    $return['data']['status'] = '98';
                    $return['data']['msg'] = '非代理账号';
                }
                break;

            /* 汇款记录 */
            case 'transfer':
                if($user['is_daili']==1){
                    $return['data']['status'] = '00';
                    $return['data']['msg'] = '';
                    (!isset($_argv[3])||!preg_match('/^[1-9]\d{7}$/', $_argv[3]))&&$_argv[3] = date('Ymd', time()-518400);
                    $return['data']['start'] = intval($_argv[3]);
                    $_argv[3] = substr($_argv[3], 0, 4).'-'.substr($_argv[3], 4, 2).'-'.substr($_argv[3], 6, 2);
                    (!isset($_argv[4])||!preg_match('/^[1-9]\d{7}$/', $_argv[4]))&&$_argv[4] = date('Ymd', strtotime($_argv[3])+518400);
                    $return['data']['end'] = intval($_argv[4]);
                    $_argv[4] = substr($_argv[4], 0, 4).'-'.substr($_argv[4], 4, 2).'-'.substr($_argv[4], 6, 2);
                    $sql = 'SELECT `u`.`uid`, `u`.`username`, `h`.`adddate`, `h`.`date`, `h`.`lsh`, `h`.`money`, `h`.`zsjr`, `h`.`status` FROM `huikuan` AS `h` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`h`.`uid` WHERE `u`.`top_uid`=:uid AND `h`.`adddate` BETWEEN :bdate AND :edate';
                    $params = array(
                        ':uid' => $user['uid'],
                        ':bdate' => $_argv[3].' 00:00:00',
                        ':edate' => $_argv[4].' 23:59:59',
                    );
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        if(isset($_POST['username'])&&is_string($_POST['username'])&&!empty($_POST['username'])){
                            $sql.= ' AND `u`.`username`=:username';
                            $params[':username'] = $_POST['username'];
                        }
                    }
                    $stmt = $mydata1_db->prepare($sql.' ORDER BY `h`.`id` DESC');
                    $stmt->execute($params);
                    $return['data']['count'] = $stmt->rowCount();
                    $return['data']['list'] = array();
                    if($return['data']['count']>0){
                        (!isset($_argv[5])||!preg_match('/^[1-9]\d*$/', $_argv[5]))&&$_argv[5] = 1;
                        (!isset($_argv[6])||!preg_match('/^[1-9]\d*$/', $_argv[6]))&&$_argv[6] = 20;
                        $_argv[5] = ($_argv[5]-1)*$_argv[6];
                        $i = 1;
                        while ($rows = $stmt->fetch()) {
                            if($i>$_argv[5]){
                                $return['data']['list'][] = array(
                                    'uid' => $rows['uid'],
                                    'username' => $rows['username'],
                                    'createtime' => strtotime($rows['adddate']),
                                    'realtime' => strtotime($rows['date']),
                                    'orderid' => $rows['lsh'],
                                    'money' => round($rows['money']*100),
                                    'fee' => round($rows['zsjr']*100),
                                    'status' => in_array($rows['status'], array(1, 2))?$rows['status']:0,
                                );
                                $_argv[6]--;
                            }
                            if($_argv[6]<=0){
                                break;
                            }
                            $i++;
                        }
                    }
                }else{
                    $return['data']['status'] = '98';
                    $return['data']['msg'] = '非代理账号';
                }
                break;

            /* 取款记录 */
            case 'withdraw':
                if($user['is_daili']==1){
                    $return['data']['status'] = '00';
                    $return['data']['msg'] = '';
                    (!isset($_argv[3])||!preg_match('/^[1-9]\d{7}$/', $_argv[3]))&&$_argv[3] = date('Ymd', time()-518400);
                    $return['data']['start'] = intval($_argv[3]);
                    $_argv[3] = substr($_argv[3], 0, 4).'-'.substr($_argv[3], 4, 2).'-'.substr($_argv[3], 6, 2);
                    (!isset($_argv[4])||!preg_match('/^[1-9]\d{7}$/', $_argv[4]))&&$_argv[4] = date('Ymd', strtotime($_argv[3])+518400);
                    $return['data']['end'] = intval($_argv[4]);
                    $_argv[4] = substr($_argv[4], 0, 4).'-'.substr($_argv[4], 4, 2).'-'.substr($_argv[4], 6, 2);
                    $sql = 'SELECT `u`.`uid`, `u`.`username`, `m`.`m_make_time`, `m`.`m_order`, `m`.`pay_num`, `m`.`m_value`, `m`.`sxf`, `m`.`status` FROM `k_money` AS `m` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`m`.`uid` WHERE `u`.`top_uid`=:uid AND `m`.`type`=2 AND `m`.`m_make_time` BETWEEN :bdate AND :edate';
                    $params = array(
                        ':uid' => $user['uid'],
                        ':bdate' => $_argv[3].' 00:00:00',
                        ':edate' => $_argv[4].' 23:59:59',
                    );
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        if(isset($_POST['username'])&&is_string($_POST['username'])&&!empty($_POST['username'])){
                            $sql.= ' AND `u`.`username`=:username';
                            $params[':username'] = $_POST['username'];
                        }
                    }
                    $stmt = $mydata1_db->prepare($sql.' ORDER BY `m`.`m_id` DESC');
                    $stmt->execute($params);
                    $return['data']['count'] = $stmt->rowCount();
                    $return['data']['list'] = array();
                    if($return['data']['count']>0){
                        (!isset($_argv[5])||!preg_match('/^[1-9]\d*$/', $_argv[5]))&&$_argv[5] = 1;
                        (!isset($_argv[6])||!preg_match('/^[1-9]\d*$/', $_argv[6]))&&$_argv[6] = 20;
                        $_argv[5] = ($_argv[5]-1)*$_argv[6];
                        $i = 1;
                        $status = array(0 => 2, 1 => 1);
                        while ($rows = $stmt->fetch()) {
                            if($i>$_argv[5]){
                                $return['data']['list'][] = array(
                                    'uid' => $rows['uid'],
                                    'username' => $rows['username'],
                                    'createtime' => strtotime($rows['m_make_time']),
                                    'orderid' => $rows['m_order'],
                                    'card' => cutNum($rows['pay_num']),
                                    'money' => abs(round($rows['m_value']*100)),
                                    'fee' => abs(round($rows['sxf']*100)),
                                    'status' => in_array($rows['status'], array(0, 1))?$status[$rows['status']]:0,
                                );
                                $_argv[6]--;
                            }
                            if($_argv[6]<=0){
                                break;
                            }
                            $i++;
                        }
                    }
                }else{
                    $return['data']['status'] = '98';
                    $return['data']['msg'] = '非代理账号';
                }
                break;

            /* 其它加减钱款记录 */
            case 'money':
                if($user['is_daili']==1){
                    $return['data']['status'] = '00';
                    $return['data']['msg'] = '';
                    $sql = 'SELECT `u`.`uid`, `m`.`type`, `u`.`username`, `m`.`m_make_time`, `m`.`m_order`, `m`.`about`, `m`.`m_value`, `m`.`status` FROM `k_money` AS `m` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`m`.`uid` WHERE `u`.`top_uid`=:uid AND `m`.`type`';
                    (!isset($_argv[3])||!in_array($_argv[3], array(0, 1, 2, 3, 4)))&&$_argv[3] = 0;
                    $_argv[3] = intval($_argv[3]);
                    switch ($_argv[3]) {
                        case 1:
                        case 2:
                        case 3:
                        case 4:
                            $return['data']['type'] = $_argv[3];
                            $sql.= '='.($_argv[3]+2);
                            break;

                        default:
                            $return['data']['type'] = 0;
                            $sql.= ' IN (3, 4, 5, 6)';
                            break;
                    }
                    (!isset($_argv[4])||!preg_match('/^[1-9]\d{7}$/', $_argv[4]))&&$_argv[4] = date('Ymd', time()-518400);
                    $return['data']['start'] = intval($_argv[4]);
                    $_argv[4] = substr($_argv[4], 0, 4).'-'.substr($_argv[4], 4, 2).'-'.substr($_argv[4], 6, 2);
                    (!isset($_argv[5])||!preg_match('/^[1-9]\d{7}$/', $_argv[5]))&&$_argv[5] = date('Ymd', strtotime($_argv[4])+518400);
                    $return['data']['end'] = intval($_argv[5]);
                    $_argv[5] = substr($_argv[5], 0, 4).'-'.substr($_argv[5], 4, 2).'-'.substr($_argv[5], 6, 2);
                    $sql.= ' AND `m`.`m_make_time` BETWEEN :bdate AND :edate';
                    $params = array(
                        ':uid' => $user['uid'],
                        ':bdate' => $_argv[4].' 00:00:00',
                        ':edate' => $_argv[5].' 23:59:59',
                    );
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        if(isset($_POST['username'])&&is_string($_POST['username'])&&!empty($_POST['username'])){
                            $sql.= ' AND `u`.`username`=:username';
                            $params[':username'] = $_POST['username'];
                        }
                    }
                    $stmt = $mydata1_db->prepare($sql.' ORDER BY `m`.`m_id` DESC');
                    $stmt->execute($params);
                    $return['data']['count'] = $stmt->rowCount();
                    $return['data']['list'] = array();
                    if($return['data']['count']>0){
                        (!isset($_argv[6])||!preg_match('/^[1-9]\d*$/', $_argv[6]))&&$_argv[6] = 1;
                        (!isset($_argv[7])||!preg_match('/^[1-9]\d*$/', $_argv[7]))&&$_argv[7] = 20;
                        $_argv[6] = ($_argv[6]-1)*$_argv[7];
                        $i = 1;
                        $status = array(0 => 2, 1 => 1);
                        while ($rows = $stmt->fetch()) {
                            if($i>$_argv[6]){
                                $return['data']['list'][] = array(
                                    'uid' => $rows['uid'],
                                    'type' => $rows['type']-2,
                                    'username' => $rows['username'],
                                    'createtime' => strtotime($rows['m_make_time']),
                                    'orderid' => $rows['m_order'],
                                    'money' => round($rows['m_value']*100),
                                    'remark' => $rows['about'],
                                    'status' => in_array($rows['status'], array(0, 1))?$status[$rows['status']]:0,
                                );
                                $_argv[7]--;
                            }
                            if($_argv[7]<=0){
                                break;
                            }
                            $i++;
                        }
                    }
                }else{
                    $return['data']['status'] = '98';
                    $return['data']['msg'] = '非代理账号';
                }
                break;

            /* 体育赛事 */
            case 'sports':
                if($user['is_daili']==1){
                    $return['data']['status'] = '00';
                    $return['data']['msg'] = '';
                    $return['data']['type'] = 0;
                    (!isset($_argv[3])||!in_array($_argv[3], array(1, 2)))&&$_argv[3] = 1;
                    $_argv[3] = intval($_argv[3]);
                    (!isset($_argv[4])||!preg_match('/^[1-9]\d{7}$/', $_argv[4]))&&$_argv[4] = date('Ymd', time()-518400);
                    $return['data']['start'] = intval($_argv[4]);
                    $_argv[4] = substr($_argv[4], 0, 4).'-'.substr($_argv[4], 4, 2).'-'.substr($_argv[4], 6, 2);
                    (!isset($_argv[5])||!preg_match('/^[1-9]\d{7}$/', $_argv[5]))&&$_argv[5] = date('Ymd', strtotime($_argv[4])+518400);
                    $return['data']['end'] = intval($_argv[5]);
                    $_argv[5] = substr($_argv[5], 0, 4).'-'.substr($_argv[5], 4, 2).'-'.substr($_argv[5], 6, 2);
                    $params = array(
                        ':uid' => $user['uid'],
                        ':bdate' => $_argv[4].' 00:00:00',
                        ':edate' => $_argv[5].' 23:59:59',
                    );
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        if(isset($_POST['username'])&&is_string($_POST['username'])&&!empty($_POST['username'])){
                            $params[':username'] = $_POST['username'];
                        }
                    }
                    $return['data']['count'] = 0;
                    $return['data']['list'] = array();
                    (!isset($_argv[6])||!preg_match('/^[1-9]\d*$/', $_argv[6]))&&$_argv[6] = 1;
                    (!isset($_argv[7])||!preg_match('/^[1-9]\d*$/', $_argv[7]))&&$_argv[7] = 20;
                    $_argv[6] = ($_argv[6]-1)*$_argv[7];
                    switch ($_argv[3]) {
                        case 2:
                            $return['data']['type'] = 2;
                            $sql = 'SELECT `u`.`uid`, `u`.`username`, `k`.`gid`, `k`.`bet_time`, `k`.`cg_count`, `k`.`bet_money`, `k`.`bet_win`, `k`.`win`, `k`.`fs`, `k`.`status` FROM `k_bet_cg_group` AS `k` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`k`.`uid` WHERE `u`.`top_uid`=:uid AND `k`.`status` BETWEEN 0 AND 4 AND `k`.`bet_time` BETWEEN :bdate AND :edate';
                            isset($params[':username'])&&$sql.= ' AND `u`.`username`=:username';
                            $sql.= ' ORDER BY `k`.`gid` DESC';
                            $stmt = $mydata1_db->prepare($sql);
                            $stmt->execute($params);
                            $return['data']['count'] = $stmt->rowCount();
                            if($return['data']['count']>0){
                                $i = 1;
                                while ($rows = $stmt->fetch()) {
                                    if($i>$_argv[6]){
                                        $rows['remark'] = array();
                                        $query = $mydata1_db->prepare('SELECT `bid`, `bet_info`, `match_name`, `master_guest`, `bet_time`, `MB_Inball`, `TG_Inball`, `status` FROM `k_bet_cg` WHERE `gid`=:gid ORDER BY `bid` DESC');
                                        $query->execute(array(':gid' => $rows['gid']));
                                        $rows['ok_count'] = 0;
                                        while ($rs = $query->fetch()) {
                                            // 统计已结算单式
                                            !in_array($rs['status'], array(0, 3))&&$rows['ok_count']++;
                                            $temp = explode('-', $rs['bet_info']);
                                            $remark = $temp[0].' '.$rs['match_name'];
                                            if(strpos($rs['bet_info'], ' - ')){
                                                // 篮球上半之内的,这里换成正则表达替换
                                                $temp[2] = $temp[2].preg_replace('[\[(.*)\]]', '',$temp[3]);
                                            }
                                            if(isset($temp[3])){
                                                $temp[2] = preg_replace('[\[(.*)\]]', '', $temp[2].$temp[3]);
                                                unset($temp[3]);
                                            }
                                            // 如果是波胆
                                            if(strpos($temp[0], '胆')){
                                                $bodan_score = explode('@', $temp[1], 2);
                                                $rs['score'] = $bodan_score[0];
                                                $temp[1] = '波胆@'.$bodan_score[1];
                                            }
                                            // 正则匹配
                                            $m_count=count($m);
                                            $rs['team'] = explode(strpos($rs['master_guest'], 'VS.')?'VS.':'VS', $rs['master_guest']);
                                            preg_match('[\((.*)\)]', end($temp), $matches);
                                            $matches&&count($matches)>0&&$remark.= ' '.$rs['bet_time'].$matches[0];
                                            $remark.= PHP_EOL;
                                            if(strpos($temp[1], '让')>0) { //让球
                                                if(strpos($temp[1], '主')===false) { //客让
                                                    $remark.= $rs['team'][1];
                                                    $remark.= ' '.str_replace(array('主让', '客让'), array('', ''), $temp[1]).' ';
                                                    $remark.= $rs['team'][0].'(主)';
                                                }else{ //主让
                                                    $remark.= $rs['team'][0];
                                                    $remark.= ' '.str_replace(array('主让', '客让'),array('', ''),$temp[1]).' ';
                                                    $remark.= $rs['team'][1];
                                                }
                                                $temp[1] = '';
                                            }else{
                                                $remark.= $rs['team'][0];
                                                $remark.= isset($rs['score'])?$rs['score']:' VS ';
                                                $remark.= $rs['team'][1];
                                            }
                                            $remark.= PHP_EOL;
                                            if(strpos($temp[1], '@')){
                                                $remark.= str_replace('@', ' @ ', $temp[1]);
                                            }else{
                                                $arraynew = array($rs['team'][0], ' / ', $rs['team'][1], '和局', ' @ ');
                                                $arrayold = array('主', '/', '客', '和', '@');
                                                $temp[1]!=''&&$remark.= $temp[1].' ';//半全场替换显示
                                                $remark.= str_replace($arrayold, $arraynew, preg_replace('[\((.*)\)]', '', end($temp)));
                                            }
                                            if($rs['status']==3||$rs['MB_Inball']<0){
                                                $remark.= ' [取消]';
                                            }else if($rs['status']>0){
                                                $remark.= ' ['.$rs['MB_Inball'].':'.$rs['TG_Inball'].']';
                                            }
                                            $rows['remark'][] = $remark;
                                        }
                                        if($rows['cg_count']==$rows['ok_count']){
                                            if(in_array($rows['status'], array(1, 3))){
                                                $rows['status'] = '已结算';
                                            }else{
                                                $rows['status'] = '可结算';
                                            }
                                        }else{
                                            $rows['status'] = '等待单式';
                                        }
                                        $return['data']['list'][] = array(
                                            'uid' => $rows['uid'],
                                            'username' => $rows['username'],
                                            'orderid' => strval($rows['gid']),
                                            'createtime' => strtotime($rows['bet_time']),
                                            'mode' => $rows['cg_count'].'串1',
                                            'remark' => $rows['remark'],
                                            'money' => round($rows['bet_money']*100),
                                            'win' => round($rows['bet_win']*100),
                                            'win_money' => round($rows['win']*100),
                                            'reward' => round($rows['fs']*100),
                                            'status' => $rows['status'],
                                        );
                                        $_argv[7]--;
                                    }
                                    if($_argv[7]<=0){
                                        break;
                                    }
                                    $i++;
                                }
                            }
                            break;

                        default:
                            $return['data']['type'] = 1;
                            $sql = 'SELECT `u`.`uid`, `u`.`username`, `k`.`bet_time`, `k`.`number`, `k`.`ball_sort`, `k`.`bet_info`, `k`.`match_name`, `k`.`match_type`, `k`.`match_time`, `k`.`match_nowscore`, `k`.`match_showtype`, `k`.`master_guest`, `k`.`status`, `k`.`point_column`, `k`.`TG_Inball`, `k`.`MB_Inball`, `k`.`match_id`, `k`.`lose_ok`, `k`.`bet_money`, `k`.`bet_win`, `k`.`win`, `k`.`fs` FROM `k_bet` AS `k` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`k`.`uid` WHERE `u`.`top_uid`=:uid AND `k`.`status` BETWEEN 0 AND 8 AND `k`.`bet_time` BETWEEN :bdate AND :edate';
                            isset($params[':username'])&&$sql.= ' AND `u`.`username`=:username';
                            $sql.= ' ORDER BY `k`.`bid` DESC';
                            $stmt = $mydata1_db->prepare($sql);
                            $stmt->execute($params);
                            $return['data']['count'] = $stmt->rowCount();
                            if($return['data']['count']>0){
                                $i = 1;
                                $match_result = array();
                                $status = array('未结算', '赢', '输', '非正常投注', '赢一半', '输一半', '进球无效', '红卡取消', '和局');
                                while ($rows = $stmt->fetch()) {
                                    if($i>$_argv[6]){
                                        $rows['match_showtype'] = strtolower($rows['match_showtype']);
                                        $temp = explode('-', $rows['bet_info']);
                                        if(isset($temp[3])){
                                            $temp[2] = preg_replace('[\[(.*)\]]', '', $temp[2].$temp[3]);
                                            unset($temp[3]);
                                        }
                                        // 如果是波胆
                                        if(strpos($temp[0], '胆')){
                                            $bodan_score = explode('@', $temp[1], 2);
                                            $rows['score'] = $bodan_score[0];
                                            $temp[1] = '波胆@'.$bodan_score[1];
                                        }
                                        $is_other = in_array($rows['ball_sort'], array('冠军', '金融'));
                                        $rows['remark'] = $rows['match_name'];
                                        if($rows['match_type']==2){
                                            $rows['remark'].= ' '.$rows['match_time'];
                                            if(strpos($rows['ball_sort'], '滚球')==false){
                                                if($rows['match_nowscore']==''){
                                                    $rows['remark'].= ' (0:0)';
                                                }else if($rows['match_showtype']=='h'){
                                                    $rows['remark'].= ' ('.$rows['match_nowscore'].')';
                                                }else{
                                                    $rows['remark'].= ' ('.strrev($rows['match_nowscore']).')';
                                                }
                                            }
                                        }
                                        $rows['remark'].= PHP_EOL;
                                        $rows['team'] = explode(strpos($rows['master_guest'],'VS.')?'VS.':'VS', $rows['master_guest']);
                                        if(strpos($temp[1], '让')>0){
                                            if($rows['match_showtype']=='c'){
                                                $rows['remark'].= $rows['team'][1];
                                                $rows['remark'].= ' '.str_replace(array('主让', '客让'), array('', ''), $temp[1]).' ';
                                                $rows['remark'].= $rows['team'][0].'(主)';
                                            }else{ //主让
                                                $rows['remark'].= $rows['team'][0];
                                                $rows['remark'].= ' '.str_replace(array('主让', '客让'), array('', ''), $temp[1]).' ';
                                                $rows['remark'].= $rows['team'][1];
                                            }
                                            $temp[1] = '';
                                        }else{
                                            $rows['remark'].= $rows['team'][0];
                                            if(isset($rows['score'])){
                                                $rows['remark'].= ' '.$rows['score'].' ';
                                            }else if($rows['team'][1]!=''){
                                                $rows['remark'].= ' VS ';
                                            }
                                            $rows['remark'].= $rows['team'][1];
                                        }
                                        $rows['remark'].= PHP_EOL;
                                        //半全场替换显示
                                        if($is_other){
                                            $rows['remark'].= str_replace('@', ' @ ', $rows['bet_info']);
                                        }else{
                                            $arraynew = array($rows['team'][0], $rows['team'][1], '和局', ' / ', '局');
                                            $arrayold = array('主', '客', '和', '/', '局局');
                                            $ss = str_replace($arrayold, $arraynew, preg_replace('[\((.*)\)]', '', end($temp)));
                                            $ss = explode('@', $ss);
                                            if($ss[0]=='独赢'){
                                                $rows['remark'].= $temp[1].' ';
                                            }else if(strpos($ss[0], '独赢')){
                                                $rows['remark'].= $temp[1].'-';
                                            }
                                            $rows['remark'].= str_replace(' ', '', $ss[0]);
                                            if($rows['match_nowscore']!=''){
                                                if($rows['match_showtype']=='h'||(!strrpos($tz_type, '球'))){
                                                    $rows['remark'].= ' ('.$rows['match_nowscore'].')';
                                                }else{
                                                    $rows['remark'].= ' ('.strrev($rows['match_nowscore']).')';
                                                }
                                            }
                                            $rows['remark'].= ' @ '.$ss[1];
                                        }
                                        if(!in_array($rows['status'], array(0, 3, 7, 6))){
                                            if($rows['match_showtype']=='c'&&strpos('&match_ao,match_ho,match_bho,match_bao&', $rows['point_column'])>0){
                                                $rows['remark'].= ' ['.$rows['TG_Inball'].':'.$rows['MB_Inball'].']';
                                            }else if($is_other){
                                                if(!isset($match_result[$rows['match_id']])){
                                                    $match_result[$rows['match_id']] = '';
                                                    $query = $mydata1_db->query('SELECT `x_result` FROM `mydata4_db`.`t_guanjun` WHERE `match_id`='.$rows['match_id']);
                                                    if($query->rowCount()>0){
                                                        $rs = $query->fetch();
                                                        $match_result[$rows['match_id']] = str_replace('<br>', ' ', $rs['x_result']);
                                                    }
                                                }
                                                if($match_result[$rows['match_id']]!=''){
                                                    $rows['remark'].= ' ['.$match_result[$rows['match_id']].']';
                                                }
                                            }else{
                                                $rows['remark'].= ' ['.$rows['MB_Inball'].':'.$rows['TG_Inball'].']';
                                            }
                                        }
                                        if($rows['ball_sort']=='足球滚球'){
                                            if($rows['lose_ok']==0){
                                                $rows['remark'].= ' [确认中]';
                                            }else if($rows['status']==0){
                                                $rows['remark'].= ' [已确认]';
                                            }
                                        }
                                        $return['data']['list'][] = array(
                                            'uid' => $rows['uid'],
                                            'username' => $rows['username'],
                                            'createtime' => strtotime($rows['bet_time']),
                                            'orderid' => strval($rows['number']),
                                            'mode' => $rows['ball_sort'].($is_other?'':' '.$temp[0]),
                                            'remark' => $rows['remark'],
                                            'money' => round($rows['bet_money']*100),
                                            'win' => round($rows['bet_win']*100),
                                            'win_money' => round($rows['win']*100),
                                            'reward' => round($rows['fs']*100),
                                            'status' => $status[$rows['status']],
                                        );
                                        $_argv[7]--;
                                    }
                                    if($_argv[7]<=0){
                                        break;
                                    }
                                    $i++;
                                }
                            }
                            break;
                    }
                }else{
                    $return['data']['status'] = '98';
                    $return['data']['msg'] = '非代理账号';
                }
                break;
            case 'lottery':
                if($user['is_daili']==1){
                    $return['data']['status'] = '00';
                    $return['data']['msg'] = '';
                    (!isset($_argv[3])||!in_array($_argv[3], array(1, 2, 3, 4, 5, 6, 7, 8, 9)))&&$_argv[3] = 1;
                    $_argv[3] = intval($_argv[3]);
                    $return['data']['type'] = $_argv[3];
                    (!isset($_argv[4])||!preg_match('/^[1-9]\d{7}$/', $_argv[4]))&&$_argv[4] = date('Ymd', time()-518400);
                    $return['data']['start'] = intval($_argv[4]);
                    $_argv[4] = substr($_argv[4], 0, 4).'-'.substr($_argv[4], 4, 2).'-'.substr($_argv[4], 6, 2);
                    (!isset($_argv[5])||!preg_match('/^[1-9]\d{7}$/', $_argv[5]))&&$_argv[5] = date('Ymd', strtotime($_argv[4])+518400);
                    $return['data']['end'] = intval($_argv[5]);
                    $_argv[5] = substr($_argv[5], 0, 4).'-'.substr($_argv[5], 4, 2).'-'.substr($_argv[5], 6, 2);
                    $params = array(
                        ':uid' => $user['uid'],
                        ':bdate' => $_argv[4].' 00:00:00',
                        ':edate' => $_argv[5].' 23:59:59',
                    );
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        if(isset($_POST['username'])&&is_string($_POST['username'])&&!empty($_POST['username'])){
                            $params[':username'] = $_POST['username'];
                        }
                    }
                    $return['data']['count'] = 0;
                    $return['data']['list'] = array();
                    (!isset($_argv[6])||!preg_match('/^[1-9]\d*$/', $_argv[6]))&&$_argv[6] = 1;
                    (!isset($_argv[7])||!preg_match('/^[1-9]\d*$/', $_argv[7]))&&$_argv[7] = 20;
                    $_argv[6] = ($_argv[6]-1)*$_argv[7];
                    if(in_array($_argv[3], array(4, 5, 6, 7, 8))){
                        $type = array(
                            4 => 'kl8',
                            5 => 'ssl',
                            6 => '3d',
                            7 => 'pl3',
                            8 => 'qxc',
                        );
                        $params[':type'] = $type[$_argv[3]];
                        $sql = 'SELECT `u`.`uid`, `u`.`username`, `c`.`uid` AS `id`, `c`.`mid`, `c`.`content`, `c`.`money`, `c`.`odds`, `c`.`win`, `c`.`bet_time`, `c`.`btype`, `c`.`ctype`, `c`.`dtype`, `c`.`bet_ok` FROM `lottery_data` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`username`=`c`.`username` WHERE `u`.`top_uid`=:uid AND `c`.`atype`=:type AND `c`.`bet_time` BETWEEN :bdate AND :edate';
                        isset($params[':username'])&&$sql.= ' AND `u`.`username`=:username';
                        $sql.= ' ORDER BY `c`.`id` DESC';
                        $stmt = $mydata1_db->prepare($sql);
                        $stmt->execute($params);
                        $return['data']['count'] = $stmt->rowCount();
                        if($return['data']['count']>0){
                            $i = 1;
                            while ($rows = $stmt->fetch()) {
                                if($i>$_argv[6]){
                                    if($rows['bet_ok']==1){
                                        if($params[':type']=='qxc'){
                                            $rows['win'] = $rows['money']+$rows['win'];
                                            if($rows['win']==0){
                                                $win_money = 0;
                                                $status = '输';
                                            }else{
                                                $win_money = $rows['win'];
                                                $status = '赢';
                                            }
                                        }else{
                                            if($rows['win']==0){
                                                $win_money = $rows['money'];
                                                $status = '和局';
                                            }else if($rows['win']<0){
                                                $win_money = 0;
                                                $status = '输';
                                            }else{
                                                $win_money = $rows['win'];
                                                $status = '赢';
                                            }
                                        }
                                    }else{
                                        $win_money = 0;
                                        $status = '未结算';
                                    }
                                    if($params[':type']=='kl8'){
                                        $remark = $rows['btype'];
                                    }else if($params[':type']=='qxc'){
                                        $remark = $rows['dtype'];
                                        if($rows['btype']=='定位'){
                                            $rows['ctype'] = explode('/', $rows['ctype']);
                                            $rows['content'].= PHP_EOL.'共'.$rows['ctype'][0].'注，'.sprintf('%.2f', $rows['ctype'][1]).'/注';
                                        }
                                    }else{
                                        $remark = $rows['btype'].' - '.$rows['ctype'].' - '.$rows['dtype'];
                                    }
                                    $remark.= PHP_EOL.rtrim($rows['content'], ',');
                                    $return['data']['list'][] = array(
                                        'uid' => $rows['uid'],
                                        'username' => $rows['username'],
                                        'createtime' => strtotime($rows['bet_time']),
                                        'orderid' => strval($rows['id']),
                                        'order_num' => intval($rows['mid']),
                                        'remark' => $remark,
                                        'money' => round($rows['money']*100),
                                        'odds' => $rows['odds'],
                                        'win' => round($win_money*100),
                                        'status' => $status,
                                    );
                                    $_argv[7]--;
                                }
                                if($_argv[7]<=0){
                                    break;
                                }
                                $i++;
                            }
                        }
                    }else if($_argv[3]==9){
                        $params = array(
                            ':uid' => $user['uid'],
                            ':bdate' => $_argv[4].' 12:00:00',
                            ':edate' => date('Y-m-d H:i:s', strtotime($_argv[5].' 23:59:59')+43200),
                        );
                        $sql = 'SELECT `u`.`uid`, `u`.`username`, `c`.`adddate`, `c`.`num`, `c`.`kithe`, `c`.`sum_m`, `c`.`rate`, `c`.`checked`, `c`.`bm`, `c`.`user_ds`, `c`.`class1`, `c`.`class2`, `c`.`class3` FROM `mydata2_db`.`ka_tan` AS `c` LEFT JOIN `mydata1_db`.`k_user` AS `u` ON `u`.`username`=`c`.`username` WHERE `u`.`top_uid`=:uid AND `c`.`adddate` BETWEEN :bdate AND :edate';
                        isset($params[':username'])&&$sql.= ' AND `u`.`username`=:username';
                        $sql.= ' ORDER BY `c`.`id` DESC';
                        $stmt = $mydata1_db->prepare($sql);
                        $stmt->execute($params);
                        $return['data']['count'] = $stmt->rowCount();
                        if($return['data']['count']>0){
                            $i = 1;
                            while ($rows = $stmt->fetch()) {
                                if($i>$_argv[6]){
                                    if($rows['checked']==1){
                                        if ($rows['bm'] == 2){
                                            $win_money = $rows['sum_m'];
                                            $reward = 0;
                                            $status = '和局';
                                        }else if($rows['bm']==1){
                                            $win_money = $rows['sum_m']*$rows['rate'];
                                            $reward = ($rows['sum_m']*$rows['user_ds'])/100;
                                            $status = '赢';
                                        }else{
                                            $win_money = 0;
                                            $reward = ($rows['sum_m']*$rows['user_ds'])/100;
                                            $status = '输';
                                        }
                                    }else{
                                        $win_money = 0;
                                        $reward = 0;
                                        $status = '未结算';
                                    }
                                    $remark = $rows['class1'];
                                    if($rows['class1']=='过关'){
                                        $rows['class2'] = explode(',', $rows['class2']);
                                        $rows['class3'] = explode(',', $rows['class3']);
                                        foreach($rows['class2'] as $key=>$val){
                                            $key*= 2;
                                            !isset($rows['class3'][$key])&&$rows['class3'][$key] = 'Unknown';
                                            !isset($rows['class3'][$key+1])&&$rows['class3'][$key+1] = 'Unknown';
                                            $val!=''&&$remark.= PHP_EOL.$val.' '.$rows['class3'][$key].' @ '.$rows['class3'][$key+1];
                                        }
                                    }else{
                                        $remark.= PHP_EOL.$rows['class2'].':'.$rows['class3'];
                                    }
                                    $return['data']['list'][] = array(
                                        'uid' => $rows['uid'],
                                        'username' => $rows['username'],
                                        'createtime' => strtotime($rows['adddate'])-43200,
                                        'orderid' => $rows['num'],
                                        'order_num' => intval($rows['kithe']),
                                        'remark' => $remark,
                                        'money' => round($rows['sum_m']*100),
                                        'odds' => $rows['rate'],
                                        'win' => round($win_money*100),
                                        'reward' => round($reward*100),
                                        'status' => $status,
                                    );
                                    $_argv[7]--;
                                }
                                if($_argv[7]<=0){
                                    break;
                                }
                                $i++;
                            }
                        }
                    }else{
                        switch ($_argv[3]) {
                            case 1:
                                $table = 'c_bet';
                                $params[':type'] = '重庆时时彩';
                                break;

                            case 2:
                                $table = 'c_bet_3';
                                $params[':type'] = '广东快乐10分';
                                break;

                            case 3:
                                $table = 'c_bet_3';
                                $params[':type'] = '北京赛车PK拾';
                                break;
                        }
                        $sql = "SELECT `u`.`uid`, `u`.`username`, `c`.`id`, `c`.`addtime`, `c`.`qishu`, `c`.`mingxi_1`, `c`.`mingxi_2`, `c`.`odds`, `c`.`money`, `c`.`win`, `c`.`js` FROM `$table` AS `c` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`c`.`uid` WHERE `u`.`top_uid`=:uid AND `c`.`type`=:type AND `c`.`addtime` BETWEEN :bdate AND :edate";
                        isset($params[':username'])&&$sql.= ' AND `u`.`username`=:username';
                        $sql.= ' ORDER BY `c`.`id` DESC';
                        $stmt = $mydata1_db->prepare($sql);
                        $stmt->execute($params);
                        $return['data']['count'] = $stmt->rowCount();
                        if($return['data']['count']>0){
                            $i = 1;
                            while ($rows = $stmt->fetch()) {
                                if($i>$_argv[6]){
                                    if($rows['js']==1){
                                        if($rows['win']==0){
                                            $win_money = $rows['money'];
                                            $status = '和局';
                                        }else if($rows['win']<0){
                                            $win_money = 0;
                                            $status = '输';
                                        }else{
                                            $win_money = $rows['win'];
                                            $status = '赢';
                                        }
                                    }else{
                                        $win_money = 0;
                                        $status = '未结算';
                                    }
                                    $return['data']['list'][] = array(
                                        'uid' => $rows['uid'],
                                        'username' => $rows['username'],
                                        'createtime' => strtotime($rows['addtime']),
                                        'orderid' => strval($rows['id']),
                                        'order_num' => $rows['qishu'],
                                        'remark' => $rows['mingxi_1'].'【'.$rows['mingxi_2'].'】',
                                        'money' => round($rows['money']*100),
                                        'odds' => $rows['odds'],
                                        'win' => round($win_money*100),
                                        'status' => $status,
                                    );
                                    $_argv[7]--;
                                }
                                if($_argv[7]<=0){
                                    break;
                                }
                                $i++;
                            }
                        }
                    }
                }else{
                    $return['data']['status'] = '98';
                    $return['data']['msg'] = '非代理账号';
                }
                break;
            // case 'marksix':
            //     if($user['is_daili']==1){
            //         $return['data']['status'] = '00';
            //         $return['data']['msg'] = '';
            //         (!isset($_argv[3])||!preg_match('/^[1-9]\d{7}$/', $_argv[3]))&&$_argv[3] = date('Ymd', time()-518400);
            //         $return['data']['start'] = intval($_argv[3]);
            //         $_argv[3] = substr($_argv[3], 0, 4).'-'.substr($_argv[3], 4, 2).'-'.substr($_argv[3], 6, 2);
            //         (!isset($_argv[4])||!preg_match('/^[1-9]\d{7}$/', $_argv[4]))&&$_argv[4] = date('Ymd', strtotime($_argv[3])+518400);
            //         $return['data']['end'] = intval($_argv[4]);
            //         $_argv[4] = substr($_argv[4], 0, 4).'-'.substr($_argv[4], 4, 2).'-'.substr($_argv[4], 6, 2);
            //         $params = array(
            //             ':uid' => $user['uid'],
            //             ':bdate' => $_argv[3].' 12:00:00',
            //             ':edate' => date('Y-m-d H:i:s', strtotime($_argv[4].' 23:59:59')+43200),
            //         );
            //         if($_SERVER['REQUEST_METHOD']=='POST'){
            //             if(isset($_POST['username'])&&is_string($_POST['username'])&&!empty($_POST['username'])){
            //                 $params[':username'] = $_POST['username'];
            //             }
            //         }
            //         $return['data']['count'] = 0;
            //         $return['data']['list'] = array();
            //         (!isset($_argv[5])||!preg_match('/^[1-9]\d*$/', $_argv[5]))&&$_argv[5] = 1;
            //         (!isset($_argv[6])||!preg_match('/^[1-9]\d*$/', $_argv[6]))&&$_argv[6] = 20;
            //         $_argv[5] = ($_argv[5]-1)*$_argv[6];
            //         $sql = 'SELECT `u`.`uid`, `u`.`username`, `c`.`adddate`, `c`.`num`, `c`.`kithe`, `c`.`sum_m`, `c`.`rate`, `c`.`checked`, `c`.`bm`, `c`.`user_ds`, `c`.`class1`, `c`.`class2`, `c`.`class3` FROM `mydata2_db`.`ka_tan` AS `c` LEFT JOIN `mydata1_db`.`k_user` AS `u` ON `u`.`username`=`c`.`username` WHERE `u`.`top_uid`=:uid AND `c`.`adddate` BETWEEN :bdate AND :edate';
            //         isset($params[':username'])&&$sql.= ' AND `u`.`username`=:username';
            //         $sql.= ' ORDER BY `c`.`id` DESC';
            //         $stmt = $mydata1_db->prepare($sql);
            //         $stmt->execute($params);
            //         $return['data']['count'] = $stmt->rowCount();
            //         if($return['data']['count']>0){
            //             $i = 1;
            //             while ($rows = $stmt->fetch()) {
            //                 if($i>$_argv[5]){
            //                     if($rows['checked']==1){
            //                         if ($rows['bm'] == 2){
            //                             $win_money = $rows['sum_m'];
            //                             $reward = 0;
            //                             $status = '和局';
            //                         }else if($rows['bm']==1){
            //                             $win_money = $rows['sum_m']*$rows['rate'];
            //                             $reward = ($rows['sum_m']*$rows['user_ds'])/100;
            //                             $status = '赢';
            //                         }else{
            //                             $win_money = 0;
            //                             $reward = ($rows['sum_m']*$rows['user_ds'])/100;
            //                             $status = '输';
            //                         }
            //                     }else{
            //                         $win_money = 0;
            //                         $reward = 0;
            //                         $status = '未结算';
            //                     }
            //                     $remark = $rows['class1'];
            //                     if($rows['class1']=='过关'){
            //                         $rows['class2'] = explode(',', $rows['class2']);
            //                         $rows['class3'] = explode(',', $rows['class3']);
            //                         foreach($rows['class2'] as $key=>$val){
            //                             $key*= 2;
            //                             !isset($rows['class3'][$key])&&$rows['class3'][$key] = 'Unknown';
            //                             !isset($rows['class3'][$key+1])&&$rows['class3'][$key+1] = 'Unknown';
            //                             $val!=''&&$remark.= PHP_EOL.$val.' '.$rows['class3'][$key].' @ '.$rows['class3'][$key+1];
            //                         }
            //                     }else{
            //                         $remark.= PHP_EOL.$rows['class2'].':'.$rows['class3'];
            //                     }
            //                     $return['data']['list'][] = array(
            //                         'uid' => $rows['uid'],
            //                         'username' => $rows['username'],
            //                         'createtime' => strtotime($rows['adddate'])-43200,
            //                         'orderid' => $rows['num'],
            //                         'order_num' => intval($rows['kithe']),
            //                         'remark' => $remark,
            //                         'money' => round($rows['sum_m']*100),
            //                         'odds' => $rows['rate'],
            //                         'win' => round($win_money*100),
            //                         'reward' => round($reward*100),
            //                         'status' => $status,
            //                     );
            //                     $_argv[6]--;
            //                 }
            //                 if($_argv[6]<=0){
            //                     break;
            //                 }
            //                 $i++;
            //             }
            //         }
            //     }else{
            //         $return['data']['status'] = '98';
            //         $return['data']['msg'] = '非代理账号';
            //     }
            //     break;
            case 'casino':
                if($user['is_daili']==1){
                    $_LIVE = include('cj/include/live.php');
                    $_LIVE[] = true;
                    $return['data']['status'] = '00';
                    $return['data']['msg'] = '';
                    (!isset($_argv[3])||!in_array($_argv[3], array_keys($_LIVE)))&&$_argv[3] = 0;
                    $_argv[3] = intval($_argv[3]);
                    $return['data']['type'] = $_argv[3];
                    (!isset($_argv[4])||!preg_match('/^[1-9]\d{7}$/', $_argv[4]))&&$_argv[4] = date('Ymd', time()-518400);
                    $return['data']['start'] = intval($_argv[4]);
                    $_argv[4] = substr($_argv[4], 0, 4).'-'.substr($_argv[4], 4, 2).'-'.substr($_argv[4], 6, 2);
                    (!isset($_argv[5])||!preg_match('/^[1-9]\d{7}$/', $_argv[5]))&&$_argv[5] = date('Ymd', strtotime($_argv[4])+518400);
                    $return['data']['end'] = intval($_argv[5]);
                    $_argv[5] = substr($_argv[5], 0, 4).'-'.substr($_argv[5], 4, 2).'-'.substr($_argv[5], 6, 2);
                    $params = array(
                        ':uid' => $user['uid'],
                        ':bdate' => strtotime($_argv[4]),
                        ':edate' => strtotime($_argv[5]),
                    );
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        if(isset($_POST['username'])&&is_string($_POST['username'])&&!empty($_POST['username'])){
                            $params[':username'] = $_POST['username'];
                        }
                    }
                    $return['data']['count'] = 0;
                    $return['data']['list'] = array();
                    (!isset($_argv[6])||!preg_match('/^[1-9]\d*$/', $_argv[6]))&&$_argv[6] = 1;
                    (!isset($_argv[7])||!preg_match('/^[1-9]\d*$/', $_argv[7]))&&$_argv[7] = 20;
                    $_argv[6] = ($_argv[6]-1)*$_argv[7];
                    $sql = 'SELECT `u`.`uid`, `u`.`username`, `d`.`platform_id`, `d`.`report_date`, `d`.`rows_num`, `d`.`bet_amount`, `d`.`net_amount`, `d`.`valid_amount` FROM `daily_report` AS `d` LEFT JOIN `k_user` AS `u` ON `u`.`uid`=`d`.`uid` WHERE `u`.`top_uid`=:uid AND `d`.`report_date` BETWEEN :bdate AND :edate';
                    isset($params[':username'])&&$sql.= ' AND `u`.`username`=:username';
                    if($_argv[3]>0){
                        $sql.= ' AND `d`.`platform_id`=:pid';
                        $params[':pid'] = $_argv[3]-1;
                    }
                    $sql.= ' ORDER BY `d`.`report_date` DESC, `d`.`id` DESC';
                    $stmt = $mydata1_db->prepare($sql);
                    $stmt->execute($params);
                    $return['data']['count'] = $stmt->rowCount();
                    if($return['data']['count']>0){
                        $i = 1;
                        while ($rows = $stmt->fetch()) {
                            if($i>$_argv[6]){
                                $return['data']['list'][] = array(
                                    'uid' => $rows['uid'],
                                    'type' => $rows['platform_id']+1,
                                    'username' => $rows['username'],
                                    'createtime' => $rows['report_date'],
                                    'count' => $rows['rows_num'],
                                    'money' => $rows['bet_amount'],
                                    'win' => $rows['net_amount']+$rows['bet_amount'],
                                    'valid_money' => $rows['valid_amount'],
                                );
                                $_argv[7]--;
                            }
                            if($_argv[7]<=0){
                                break;
                            }
                            $i++;
                        }
                    }
                }else{
                    $return['data']['status'] = '98';
                    $return['data']['msg'] = '非代理账号';
                }
                break;
            case 'summary':
                if($user['is_daili']==1){
                    $return['data']['status'] = '00';
                    $return['data']['msg'] = '';
                    (!isset($_argv[3])||!preg_match('/^[1-9]\d{9}$/', $_argv[3]))&&$_argv[3] = time()-518400;
                    $return['data']['start'] = intval($_argv[3]);
                    (!isset($_argv[4])||!preg_match('/^[1-9]\d{9}$/', $_argv[4]))&&$_argv[4] = $_argv[3]+518400;
                    $return['data']['end'] = intval($_argv[4]);
                    $_argv[3] = date('Y-m-d H:i:s', $_argv[3]);
                    $_argv[4] = date('Y-m-d H:i:s', $_argv[4]);
                    $return['data']['count'] = 0;
                    $return['data']['list'] = array();
                    $sql = 'SELECT `uid`, `username` FROM `k_user` WHERE `top_uid`=:uid';
                    $params = array(':uid' => $user['uid']);
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        if(isset($_POST['username'])&&is_string($_POST['username'])&&!empty($_POST['username'])){
                            $sql.= ' AND `username`=:username';
                            $params[':username'] = $_POST['username'];
                        }
                    }
                    $stmt = $mydata1_db->prepare($sql.' ORDER BY `uid` DESC');
                    $stmt->execute($params);
                    $return['data']['count'] = $stmt->rowCount();
                    if($return['data']['count']>0){
                        $ids = array();
                        (!isset($_argv[5])||!preg_match('/^[1-9]\d*$/', $_argv[5]))&&$_argv[5] = 1;
                        (!isset($_argv[6])||!preg_match('/^[1-9]\d*$/', $_argv[6]))&&$_argv[6] = 20;
                        $_argv[5] = ($_argv[5]-1)*$_argv[6];
                        $i = 1;
                        while ($rows = $stmt->fetch()) {
                            if($i>$_argv[5]){
                                $ids[$rows['uid']] = array(
                                    'uid' => $rows['uid'],
                                    'username' => $rows['username'],
                                    'transfer' => 0,
                                    'deposit' => 0,
                                    'money' => 0,
                                    'withdraw' => 0,
                                    'reward' => 0,
                                    'other_reward' => 0,
                                    'other_add' => 0,
                                    'other_less' => 0,
                                );
                                $_argv[6]--;
                            }
                            if($_argv[6]<=0){
                                break;
                            }else{
                                $i++;
                            }
                        }
                        if(!empty($ids)){
                            if(count($ids)>1){
                                $usql = '`uid` IN ('.implode(', ', array_keys($ids)).')';
                            }else{
                                $usql = '`uid`='.key($ids);
                            }
                            $sql = 'SELECT `uid`, SUM(`transfer`) AS `transfer`, SUM(`deposit`) AS `deposit`, SUM(`money`) AS `money`, SUM(`withdraw`) AS `withdraw`, SUM(`reward`) AS `reward`, SUM(`other_reward`) AS `other_reward`, SUM(`other_add`) AS `other_add`, SUM(`other_less`) AS `other_less` FROM (';
                            $sql.= "SELECT `uid`, 0 AS `transfer`, SUM(IF(`type`=1, `m_value`, 0)) AS `deposit`, SUM(IF(`type`=3, `m_value`, 0)) AS `money`, SUM(IF(`type`=2, -1*`m_value`, 0)) AS `withdraw`, SUM(IF(`type`=5, `m_value`, 0)) AS `reward`, SUM(IF(`type`=4, `m_value`, 0)) AS `other_reward`, SUM(IF(`type`=6 AND `m_value`>0, `m_value`, 0)) AS `other_add`, SUM(IF(`type`=6 AND `m_value`<0, -1*`m_value`, 0)) AS `other_less` FROM `k_money` WHERE $usql AND `status`=1 AND `m_make_time` BETWEEN :c_time_s AND :c_time_e GROUP BY `uid` UNION ALL ";
                            $sql.= "SELECT `uid`, SUM(`money`) AS `transfer`, 0 AS `deposit`, 0 AS `money`, 0 AS `withdraw`, 0 AS `reward`, 0 AS `other_reward`, 0 AS `other_add`, 0 AS `other_less` FROM `huikuan` WHERE $usql AND `status`=1 AND `adddate` BETWEEN :h_time_s AND :h_time_e GROUP BY `uid`) AS `temp` GROUP BY `uid`";
                            $stmt = $mydata1_db->prepare($sql);
                            $stmt->execute(array(
                                ':c_time_s' => $_argv[3],
                                ':c_time_e' => $_argv[4],
                                ':h_time_s' => $_argv[3],
                                ':h_time_e' => $_argv[4],
                            ));
                            while($rows = $stmt->fetch()){
                                $ids[$rows['uid']]['transfer'] = $rows['transfer']*100;
                                $ids[$rows['uid']]['deposit'] = $rows['deposit']*100;
                                $ids[$rows['uid']]['money'] = $rows['money']*100;
                                $ids[$rows['uid']]['withdraw'] = $rows['withdraw']*100;
                                $ids[$rows['uid']]['reward'] = $rows['reward']*100;
                                $ids[$rows['uid']]['other_reward'] = $rows['other_reward']*100;
                                $ids[$rows['uid']]['other_add'] = $rows['other_add']*100;
                                $ids[$rows['uid']]['other_less'] = $rows['other_less']*100;
                            }
                            $return['data']['list'] = array_values($ids);
                        }
                    }
                }else{
                    $return['data']['status'] = '98';
                    $return['data']['msg'] = '非代理账号';
                }
                break;
        }
    }
}
echo json_encode($return, JSON_UNESCAPED_UNICODE);
