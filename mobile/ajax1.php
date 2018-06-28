<?php
header('Content-Type: application/json');

$MOBILE = [
    'output' => [
        'status' => -1,
        'msg' => '缺少必要参数',
    ],
];

session_start();
$_DIR = dirname(__FILE__);
$_DIR = str_replace('\\', '/', $_DIR);
substr($_DIR, -1) != '/' && $_DIR .= '/';
define('IN_MOBILE', $_DIR);

$_SERVER['DOCUMENT_ROOT'] = realpath(IN_MOBILE.'../');
include IN_MOBILE.'../include/config.php';
include IN_MOBILE.'../database/mysql.config.php';
website_close();

isset($_POST['action']) || $_POST['action'] = 'error';

switch ($_POST['action']) {
    case 'init': //初始化
        $rows = [];
        if (isset($_SESSION['uid'])) {
            $stmt = $mydata1_db->prepare('SELECT `username`, `money`, `uid`, `pay_name`, `email`, `is_daili`, `reg_date`, `login_time`, `mobile`, `qk_pwd` FROM `k_user` WHERE `uid`=:uid AND `is_delete`=0 AND `is_stop`=0 LIMIT 1');
            $stmt->execute([':uid' => $_SESSION['uid']]);
            $rows = $stmt->fetch();
        }
        $MOBILE['output'] = userInfo($rows);
        break;
    case 'money': //用户余额
        $MOBILE['output'] = ['status' => 0, 'msg' => '您已经退出登录，请重新登录'];
        if (isset($_SESSION['uid'])) {
            $stmt = $mydata1_db->prepare('SELECT `money` FROM `k_user` WHERE `uid`=:uid AND `is_delete`=0 AND `is_stop`=0 LIMIT 1');
            $stmt->execute([':uid' => $_SESSION['uid']]);
            if ($rows = $stmt->fetch()) {
                $MOBILE['output'] = ['status' => 1, 'msg' => $rows['money']];
            }
        }
        break;
    case 'register': //用户注册
        $rows = [];
        include IN_MOBILE.'../common/function.php';
        switch (false) {
            case isset($_POST['type']) && ! empty($_POST['type']):
                $MOBILE['output']['msg'] = '请求失败，请刷新页面重试';
                break;
            case $_POST['type'] != 'check':
                if (isset($_POST['username']) && ! empty($_POST['username'])) {
                    $MOBILE['output']['status'] = 1;
                    $stmt = $mydata1_db->prepare('SELECT `uid` FROM `k_user` WHERE `username`=:username LIMIT 1');
                    $stmt->execute([':username' => $_POST['username']]);
                    $MOBILE['output']['msg'] = $stmt->rowCount() > 0;
                } else {
                    $MOBILE['output']['msg'] = '缺少必要参数';
                }
                break;
            case isset($_SESSION['randcode']):
            case isset($_POST['vcode']):
            case $_SESSION['randcode'] == strtolower($_POST['vcode']):
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '验证码错误，请重新输入';
                break;
            case isset($_POST['username']) && ($_POST['username'] = htmlEncode($_POST['username'])) != '':
            case preg_match('/^[A-Za-z0-9]{5,15}$/', $_POST['username']):
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '账户格式不正确';
                break;
            case $stmt = $mydata1_db->prepare('SELECT `uid` FROM `k_user` WHERE `username`=:username LIMIT 1'):
            case $stmt->execute([':username' => $_POST['username']]):
            case $stmt->rowCount() <= 0:
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '账户已存在';
                break;
            case isset($_POST['fullName']) && ($_POST['fullName'] = htmlEncode($_POST['fullName'])) != '':
            case preg_match('/^[\x{4e00}-\x{9fa5}]{2,5}$/u', $_POST['fullName']):
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '真实姓名格式不正确';
                break;
            case isset($_POST['password']) && ($_POST['password'] = htmlEncode($_POST['password'])) != '':
            case strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 20:
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '密码长度不正确';
                break;
            case isset($_POST['fundPwd']) && ($_POST['fundPwd'] = htmlEncode($_POST['fundPwd'])) != '':
            case preg_match('/\d{6}/', $_POST['fundPwd']):
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '取款密码格式不正确';
                break;
            case $web_site['show_qq'] != 1 || (isset($_POST['email']) && ($_POST['email'] = htmlEncode($_POST['email'])) != ''):
            case $web_site['show_qq'] != 1 || (preg_match('/^(([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?))|[1-9]\d{4,9}$/',
                    $_POST['email'])):
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '邮箱地址或QQ号码不正确';
                break;
            case $web_site['show_tel'] != 1 || (isset($_POST['tel']) && ($_POST['tel'] = htmlEncode($_POST['tel'])) != ''):
            case $web_site['show_tel'] != 1 || (preg_match('/^\d{6,13}$/', $_POST['tel'])):
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '手机号码不正确';
                break;
            case $web_site['show_question'] != 1 || (isset($_POST['ask']) && ($_POST['ask'] = htmlEncode($_POST['ask'])) != ''):
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '请选择或填写安全问题';
                break;
            case $web_site['show_question'] != 1 || (isset($_POST['question']) && ($_POST['question'] = htmlEncode($_POST['question'])) != ''):
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '请填写安全问题答案';
                break;
            case $web_site['show_weixin'] != 1 || (isset($_POST['wechat']) && ($_POST['wechat'] = htmlEncode($_POST['wechat'])) != ''):
            case $web_site['show_weixin'] != 1 || preg_match('/^[A-Za-z0-9]{5,15}$/', $_POST['wechat']):
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '微信账号不正确';
                break;
            default:
                unset($_SESSION['randcode']);
                include IN_MOBILE.'../ip.php';
                $continue = true;
                if ($web_site['allow_samename'] != 1) {
                    $stmt = $mydata1_db->prepare('SELECT `uid` FROM `k_user` WHERE `pay_name`=:fullName LIMIT 1');
                    $stmt->execute([':fullName' => $_POST['fullName']]);
                    $continue = ! $stmt->rowCount();
                    $MOBILE['output']['msg'] = '该真实姓名已被注册';
                }
                $client_ip = get_client_ip();
                if ($continue && $web_site['allow_ip'] != 1) {
                    $stmt = $mydata1_db->prepare('SELECT `uid` FROM `k_user` WHERE `reg_ip`=:ip LIMIT 1');
                    $stmt->execute([':ip' => $client_ip]);
                    $continue = ! $stmt->rowCount();
                    $MOBILE['output']['msg'] = '该IP地址已被注册';
                }
                if ($continue) {
                    $agent = getAgent(isset($_POST['agent']) ? htmlEncode($_POST['agent']) : '');
                    $stmt = $mydata1_db->prepare('INSERT INTO `k_user` (`username`, `password`, `qk_pwd`, `ask`, `answer`, `sex`, `birthday`, `mobile`, `email`, `reg_ip`, `login_ip`, `login_time`, `pay_name`, `top_uid`, `agents`, `is_stop`, `gid`, `lognum`, `reg_address`, `modify_pwd_t`, `weixin`) VALUES (:username, :password, :qk_pwd, :ask, :answer, :sex, :birthday, :mobile, :email, :client_ip, :client_ip2, :login_time, :pay_name, :top_uid, :agents, 0, :gid, 1, :reg_address, :modify_pwd_t, :weixin)');
                    $stmt->execute([
                        ':username' => isset($_POST['username']) ? $_POST['username'] : '',
                        ':password' => isset($_POST['password']) ? md5($_POST['password']) : '',
                        ':qk_pwd' => isset($_POST['fundPwd']) ? md5($_POST['fundPwd']) : '',
                        ':ask' => isset($_POST['ask']) ? $_POST['ask'] : '',
                        ':answer' => isset($_POST['question']) ? $_POST['question'] : '',
                        ':sex' => isset($_POST['password']) ? $_POST['password'] : '',
                        ':birthday' => isset($_POST['fundPwd']) ? $_POST['fundPwd'] : '',
                        ':mobile' => isset($_POST['tel']) ? $_POST['tel'] : '',
                        ':email' => isset($_POST['email']) ? $_POST['email'] : '',
                        ':client_ip' => $client_ip,
                        ':client_ip2' => $client_ip,
                        ':login_time' => date('Y-m-d H:i:s'),
                        ':pay_name' => isset($_POST['fullName']) ? $_POST['fullName'] : '',
                        ':top_uid' => $agent['uid'],
                        ':agents' => ! $agent['username'] ? '' : $agent['username'],
                        ':gid' => 1,
                        ':reg_address' => iconv('GB2312', 'UTF-8', convertip($client_ip)),
                        ':modify_pwd_t' => date('Y-m-d H:i:s'),
                        ':weixin' => isset($_POST['wechat']) ? $_POST['wechat'] : '',
                    ]);
                    include IN_MOBILE.'../class/user.php';
                    user::login($_POST['username'], $_POST['password']);
                    $MOBILE['output'] = ['status' => 1, 'msg' => 'success'];
                }
                break;
        }
        break;
    case 'login': //用户登录
        $rows = [];
        include IN_MOBILE.'../common/function.php';
        switch (false) {
            case isset($_SESSION['randcode']):
            case isset($_POST['vlcodes']):
            case $_SESSION['randcode'] == strtolower($_POST['vlcodes']):
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '验证码错误，请重新输入';
                break;
            case isset($_POST['username']):
            case isset($_POST['password']):
            case $stmt = $mydata1_db->prepare('SELECT `username`, `money`, `uid`, `pay_name`, `email`, `is_stop`, `is_daili`, `reg_date`, `login_time`, `mobile`, `qk_pwd` FROM `k_user` WHERE `username`=:username AND `password`=:password AND `is_delete`=0 LIMIT 1'):
            case $stmt->execute([
                ':username' => htmlEncode($_POST['username']),
                ':password' => md5($_POST['password']),
            ]):
            case $stmt->rowCount() > 0:
            case $rows = $stmt->fetch():
            case $rows['username'] == $_POST['username']:
                unset($_SESSION['randcode']);
                $MOBILE['output']['msg'] = '用户名或密码错误，请重新输入';
                break;
            case $rows['is_stop'] == 0:
                $MOBILE['output']['msg'] = '账户异常无法登陆，如有疑问请联系在线客服';
                break;
            default:
                include IN_MOBILE.'../class/user.php';
                user::login(htmlEncode($_POST['username']), htmlEncode($_POST['password']));
                $MOBILE['output'] = userInfo($rows);
                break;
        }
        break;
    case 'logout': //用户退出
        if (isset($_SESSION['uid'])) {
            include IN_MOBILE.'../common/logintu.php';
            logintu($_SESSION['uid']);
        }
        $sn = session_name();
        if (isset($_COOKIE[$sn])) {
            setcookie($sn, '', time() - 42000, '/');
        }
        session_destroy();
        $MOBILE['output'] = [
            'status' => 1,
            'msg' => '退出成功！',
        ];
        break;
    case 'config': //配置信息
        $MOBILE['output'] = [];
        include IN_MOBILE.'../myfunction.php';
        $slides = get_images('slides-mobile');
        if (empty($slides)) {
            $MOBILE['output']['slides'] = [
                '../newindex/mobile/b_1.jpg',
                '../newindex/mobile/b_2.jpg',
                '../newindex/mobile/b_3.jpg',
            ];
        } else {
            $MOBILE['output']['slides'] = [];
            foreach ($slides as $val) {
                $MOBILE['output']['slides'][] = $val['img'];
            }
        }
        $links = include(IN_MOBILE.'../cj/include/mobile.links.php');
        $mobile_config = get_webinfo_bycode('mobile-config');
        $mobile_config = unserialize($mobile_config['content']);
        is_array($mobile_config) || $mobile_config = [];
        $MOBILE['output']['notices'] = get_last_message(false, false);
        $MOBILE['output']['logoUrl'] = isset($mobile_config['logo']) && ! empty($mobile_config['logo']) ? $mobile_config['logo'] : '../static/images/mobile_logo.png';
        $MOBILE['output']['addHome'] = isset($mobile_config['icon']) && ! empty($mobile_config['icon']) && isset($mobile_config['tips']) && ! empty($mobile_config['tips']);
        $MOBILE['output']['appIconUrl'] = isset($mobile_config['icon']) && ! empty($mobile_config['icon']) ? $mobile_config['icon'] : 'images/appIcon.png';
        $MOBILE['output']['skin'] = isset($mobile_config['template']) && ! empty($mobile_config['template']) ? $mobile_config['template'] : 'blue';
        $MOBILE['output']['color'] = isset($mobile_config['custom']) && $mobile_config['custom'] && isset($mobile_config['color']) && ! empty($mobile_config['color']) ? $mobile_config['color'] : '';
        $MOBILE['output']['tabs'] = $links['tabs'];
        $MOBILE['output']['home'] = [
            'hot' => [],
            'lottery' => $links['lottery'],
            'casino' => $links['casino'],
            'slots' => $links['slots'],
            'sports' => $links['sports'],
        ];
        array_key_exists('hotGame', $mobile_config) || $mobile_config['hotGame'] = $links['hot'];
        foreach ($mobile_config['hotGame'] as $key) {
            $key = explode('.', $key);
            if (array_key_exists($key[0], $links)) {
                if (array_key_exists($key[1], $links[$key[0]])) {
                    $MOBILE['output']['home']['hot'][] = $links[$key[0]][$key[1]];
                    $MOBILE['output']['home'][$key[0]][$key[1]]['hot'] = true;
                }
            }
        }
        $MOBILE['output']['name'] = $web_site['web_name'];
        $MOBILE['output']['serviceUrl'] = $web_site['service_url'];
        $MOBILE['output']['copyright'] = 'Copyright &copy; '.date('Y').' '.$web_site['web_name'];
        $MOBILE['output']['register'] = [
            'agent' => isset($_COOKIE['tum']) ? $_COOKIE['tum'] : null,
            'tel' => $web_site['show_tel'] == 1,
            'qq' => $web_site['show_qq'] == 1,
            'question' => $web_site['show_question'] == 1,
            'wechat' => $web_site['show_weixin'] == 1,
        ];
        $mobile_tips = get_webinfo_bycode('sj-tc');
        $mobile_tips['title'] = unserialize($mobile_tips['title']);
        $MOBILE['output']['tips'] = [
            'seconds' => $mobile_tips['title'][0],
            'title' => $mobile_tips['title'][1],
            'content' => stripcslashes($mobile_tips['content']),
        ];
        break;
    case 'loginPwd': //修改登录密码
        $MOBILE['output'] = ['status' => 0, 'msg' => '旧密码错误，请重新输入'];
        include IN_MOBILE.'../class/user.php';
        switch (false) {
            case isset($_SESSION['uid']):
                $MOBILE['output']['msg'] = '您已经退出登录，请重新登录';
                break;

            case isset($_POST['oldPwd']):
            case isset($_POST['newPwd']):
                $MOBILE['output']['msg'] = '修改失败，请刷新页面重试';
                break;

            case $_POST['oldPwd'] != $_POST['newPwd']:
                $MOBILE['output']['msg'] = '新密码与旧密码不能相同';
                break;

            case strlen($_POST['newPwd']) > 5:
            case strlen($_POST['newPwd']) < 21:
                $MOBILE['output']['msg'] = '新密码只能是6-20位字符';
                break;

            case ! user::update_pwd($_SESSION['uid'], $_POST['oldPwd'], $_POST['newPwd'], 'password'):
                $_SESSION['password'] = $_POST['newPwd'];
                $MOBILE['output'] = ['status' => 1, 'msg' => 'success'];
                break;
        }
        break;
    case 'fundPwd': //修改支付密码
        $MOBILE['output'] = ['status' => 0, 'msg' => '旧密码错误，请重新输入'];
        include IN_MOBILE.'../class/user.php';
        switch (false) {
            case isset($_SESSION['uid']):
                $MOBILE['output']['msg'] = '您已经退出登录，请重新登录';
                break;

            case isset($_POST['oldPwd']):
            case isset($_POST['newPwd']):
                $MOBILE['output']['msg'] = '修改失败，请刷新页面重试';
                break;

            case $stmt = $mydata1_db->prepare('SELECT `password`, `qk_pwd` FROM `k_user` WHERE `uid`=:uid AND `is_delete`=0 AND `is_stop`=0 LIMIT 1'):
            case $stmt->execute([':uid' => $_SESSION['uid']]):
            case $rows = $stmt->fetch():
                $MOBILE['output']['msg'] = '系统繁忙，请稍候重试';
                break;

            case empty($rows['qk_pwd']) || $_POST['oldPwd'] != $_POST['newPwd']:
                $MOBILE['output']['msg'] = '新密码与旧密码不能相同';
                break;

            case preg_match('/^\d{6}$/', $_POST['newPwd']):
                $MOBILE['output']['msg'] = '新密码只能是6位数字';
                break;

            case ! empty($rows['qk_pwd']) || (md5($_POST['oldPwd']) == $rows['password'] && $_POST['oldPwd'] = '0'.$_POST['newPwd'].'0'):
                $MOBILE['output']['msg'] = '登录密码错误，请重新输入';
                break;

            case ! empty($rows['qk_pwd']) || $mydata1_db->query('UPDATE `k_user` SET `qk_pwd`=\''.md5($_POST['oldPwd']).'\' WHERE `uid`='.$_SESSION['uid']):
            case ! user::update_pwd($_SESSION['uid'], $_POST['oldPwd'], $_POST['newPwd'], 'qk_pwd'):
                $_SESSION['password'] = $_POST['newPwd'];
                $MOBILE['output'] = ['status' => 1, 'msg' => 'success'];
                break;
        }
        break;
    case 'userMsg': //未读消息数量
        $MOBILE['output'] = ['status' => 0, 'msg' => 0];
        switch (false) {
            case isset($_SESSION['uid']):
                $MOBILE['output']['msg'] = '您已经退出登录，请重新登录';
                break;

            case $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count` FROM `k_user_msg` WHERE `uid`=:uid AND `islook`=0'):
            case $stmt->execute([':uid' => $_SESSION['uid']]):
            case $rows = $stmt->fetch():
                $MOBILE['output']['msg'] = '系统繁忙，请稍候重试';
                break;

            default:
                $MOBILE['output'] = ['status' => 1, 'msg' => $rows['count']];
                break;
        }
        break;
    case 'notice': //信息中心
        $MOBILE['output'] = ['status' => 0, 'msg' => []];
        ! isset($_POST['page']) && $_POST['page'] = 1;
        ! isset($_POST['rows']) && $_POST['rows'] = 10;
        ! preg_match('/^[1-9]\d*$/', $_POST['page']) && $_POST['page'] = 1;
        (! preg_match('/^[1-9]\d*$/', $_POST['rows']) || $_POST['rows'] > 100) && $_POST['rows'] = 10;
        switch (false) {
            case isset($_POST['type']):
            case in_array($_POST['type'], ['web', 'sports', 'sms']):
                $MOBILE['output']['msg'] = '请求类型不正确';
                break;

            case isset($_SESSION['uid']):
                $MOBILE['output']['msg'] = '您已经退出登录，请重新登录';
                break;

            default:
                $MOBILE['output']['status'] = 1;
                switch ($_POST['type']) {
                    case 'web': //系统通知
                        $stmt = $mydata1_db->query('SELECT COUNT(*) AS `count` FROM `k_notice` WHERE `is_show`=1');
                        $rows = $stmt->fetch();
                        $MOBILE['output']['totalCount'] = $rows['count'];
                        if ($MOBILE['output']['totalCount'] > 0) {
                            $_POST['maxPage'] = ceil($MOBILE['output']['totalCount'] / $_POST['rows']);
                            $_POST['page'] > $_POST['maxPage'] && $_POST['page'] = $_POST['maxPage'];
                            $stmt = $mydata1_db->prepare('SELECT `nid`, `msg`, `add_time` FROM `k_notice` WHERE `is_show`=1 ORDER BY `sort` DESC, `nid` DESC LIMIT :index, :limit');
                            $stmt->execute([
                                ':index' => ($_POST['page'] - 1) * $_POST['rows'],
                                ':limit' => $_POST['rows'],
                            ]);
                            while ($rows = $stmt->fetch()) {
                                $MOBILE['output']['msg'][] = [
                                    'id' => $rows['nid'],
                                    'title' => '网站公告',
                                    'content' => $rows['msg'],
                                    'addTime' => $rows['add_time'],
                                    'read' => 1,
                                ];
                            }
                        }
                        break;

                    case 'sports': //体育公告
                        $stmt = $mydata1_db->query('SELECT COUNT(*) AS `count` FROM `k_notice_ty` WHERE `is_show`=1');
                        $rows = $stmt->fetch();
                        $MOBILE['output']['totalCount'] = $rows['count'];
                        if ($MOBILE['output']['totalCount'] > 0) {
                            $_POST['maxPage'] = ceil($MOBILE['output']['totalCount'] / $_POST['rows']);
                            $_POST['page'] > $_POST['maxPage'] && $_POST['page'] = $_POST['maxPage'];
                            $stmt = $mydata1_db->prepare('SELECT `nid`, `msg`, `add_time` FROM `k_notice_ty` WHERE `is_show`=1 ORDER BY `sort` DESC, `nid` DESC LIMIT :index, :limit');
                            $stmt->execute([
                                ':index' => ($_POST['page'] - 1) * $_POST['rows'],
                                ':limit' => $_POST['rows'],
                            ]);
                            while ($rows = $stmt->fetch()) {
                                $MOBILE['output']['msg'][] = [
                                    'id' => $rows['nid'],
                                    'title' => '体育公告',
                                    'content' => $rows['msg'],
                                    'addTime' => $rows['add_time'],
                                    'read' => 1,
                                ];
                            }
                        }
                        break;

                    case 'sms': //站内短信
                        $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count` FROM `k_user_msg` WHERE `uid`=:uid');
                        $stmt->execute([':uid' => $_SESSION['uid']]);
                        $rows = $stmt->fetch();
                        $MOBILE['output']['totalCount'] = $rows['count'];
                        if ($MOBILE['output']['totalCount'] > 0) {
                            $_POST['maxPage'] = ceil($MOBILE['output']['totalCount'] / $_POST['rows']);
                            $_POST['page'] > $_POST['maxPage'] && $_POST['page'] = $_POST['maxPage'];
                            $stmt = $mydata1_db->prepare('SELECT `msg_id`, `msg_title`, `msg_info`, `msg_time`, `islook`, `msg_from` FROM `k_user_msg` WHERE `uid`=:uid ORDER BY `msg_time` DESC, `msg_id` DESC LIMIT :index, :limit');
                            $stmt->execute([
                                ':uid' => $_SESSION['uid'],
                                ':index' => ($_POST['page'] - 1) * $_POST['rows'],
                                ':limit' => $_POST['rows'],
                            ]);
                            while ($rows = $stmt->fetch()) {
                                $MOBILE['output']['msg'][] = [
                                    'id' => $rows['msg_id'],
                                    'title' => $rows['msg_title'],
                                    'content' => $rows['msg_info'],
                                    'addTime' => $rows['msg_time'],
                                    'read' => $rows['islook'],
                                    'from' => $rows['msg_from'],
                                ];
                            }
                        }
                        break;
                }
                break;
        }
        break;
    case 'sms': //处理站内短信
        $MOBILE['output'] = ['status' => 0, 'msg' => '系统繁忙，请稍候重试'];
        switch (false) {
            case isset($_SESSION['uid']):
                $MOBILE['output']['msg'] = '您已经退出登录，请重新登录';
                break;

            case isset($_POST['type']):
            case in_array($_POST['type'], ['clear', 'delete', 'read']):
                $MOBILE['output']['msg'] = '请求类型不正确';
                break;

            default:
                ! isset($_POST['id']) && $_POST['id'] = 0;
                switch ($_POST['type']) {
                    case 'clear': //清空
                        $sql = 'DELETE FROM `k_user_msg` WHERE `uid`='.$_SESSION['uid'];
                        break;

                    case 'delete': //删除
                        $sql = 'DELETE FROM `k_user_msg` WHERE `uid`='.$_SESSION['uid'].' AND `msg_id`='.$_POST['id'];
                        break;

                    case 'read': //已读
                        $sql = 'UPDATE `k_user_msg` SET `islook`=1 WHERE `uid`='.$_SESSION['uid'].' AND `msg_id`='.$_POST['id'];
                        break;
                }
                $mydata1_db->query($sql) && $MOBILE['output']['status'] = 1;
                break;
        }
        break;
    case 'bank': //银行卡信息
        $MOBILE['output'] = ['status' => 0, 'msg' => '系统繁忙，请稍候重试'];
        switch (false) {
            case isset($_SESSION['uid']):
                $MOBILE['output']['msg'] = '您已经退出登录，请重新登录';
                break;

            case isset($_POST['type']):
            case in_array($_POST['type'], ['trans', 'config', 'get', 'save', 'withdraw', 'transfer', 'online']):
                $MOBILE['output']['msg'] = '请求类型不正确';
                break;
            case $_POST['type'] != 'trans':
                $MOBILE['output']['msg'] = '订单类型不正确';
                $types = ['deposit', 'transfer', 'withdraw', 'bank', 'activity', 'point', 'other'];
                if (isset($_POST['transType']) && in_array($_POST['transType'], $types)) {
                    include IN_MOBILE.'../member/function.php';
                    $MOBILE['output']['status'] = 1;
                    $MOBILE['output']['msg'] = [];
                    $MOBILE['output']['totalCount'] = 0;
                    $MOBILE['output']['totalMoney'] = 0;
                    (isset($_POST['lastId']) && preg_match('/^\d+$/', $_POST['lastId'])) || $_POST['lastId'] = 0;
                    (isset($_POST['rows']) && preg_match('/^[1-9]\d*$/', $_POST['rows'])) || $_POST['rows'] = 10;
                    (isset($_POST['start']) && preg_match('/^[1-9]\d{3}\-\d{2}\-\d{2}$/',
                            $_POST['start'])) || $_POST['start'] = date('Y-m-d', time() - 604800);
                    (isset($_POST['end']) && preg_match('/^[1-9]\d{3}\-\d{2}\-\d{2}$/',
                            $_POST['end'])) || $_POST['end'] = date('Y-m-d');
                    $_POST['rows'] > 100 && $_POST['rows'] = 100;
                    $params = [
                        ':uid' => $_SESSION['uid'],
                        ':qtime' => $_POST['start'].' 00:00:00',
                        ':etime' => $_POST['end'].' 23:59:59',
                    ];
                    $sql = [
                        'SELECT COUNT(*) AS `count`, SUM(`m_value`) AS `sum` FROM `k_money` WHERE `uid`=:uid AND `m_make_time` BETWEEN :qtime AND :etime AND `type`=:type',
                        'SELECT `m_id` AS `id`, `m_value` AS `money`, `m_order` AS `orderId`, `status`, `m_make_time` AS `addtime`, `about` AS `remark`, `pay_card` AS `bankName`, `pay_num` AS `cardNo`, `pay_address` AS `address`, `pay_name` AS `fullName`, `sxf` AS `fee` FROM `k_money` WHERE `uid`=:uid AND `m_make_time` BETWEEN :qtime AND :etime AND `type`=:type ORDER BY `m_id` DESC LIMIT :limit',
                        'SELECT `m_id` AS `id`, `m_value` AS `money`, `m_order` AS `orderId`, `status`, `m_make_time` AS `addtime`, `about` AS `remark`, `pay_card` AS `bankName`, `pay_num` AS `cardNo`, `pay_address` AS `address`, `pay_name` AS `fullName`, `sxf` AS `fee` FROM `k_money` WHERE `uid`=:uid AND `m_make_time` BETWEEN :qtime AND :etime AND `type`=:type AND `m_id`<:id ORDER BY `m_id` DESC LIMIT :limit',
                    ];
                    $getStatus = function ($status) {
                        $return = '失败';
                        switch ($status) {
                            case 1:
                                $return = '<font color="#FF0000">成功</font>';
                                break;
                            case 2:
                                $return = '<font color="#0000FF">审核中</font>';
                                break;
                        }

                        return $return;
                    };
                    $getMoney = function ($money, $status) {
                        return $money;
                    };
                    $needNull = [];
                    switch ($_POST['transType']) {
                        case 'deposit':
                            $params[':type'] = 1;
                            $needNull = ['fullName', 'bankName', 'cardNo', 'address', 'remark'];
                            break;
                        case 'transfer':
                            $sql = [
                                'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `huikuan` WHERE `uid`=:uid AND `adddate` BETWEEN :qtime AND :etime',
                                'SELECT `id`, `money`, `lsh` AS `orderId`, `status`, `adddate` AS `addtime`, CONCAT(`manner`, \'<br />转账时间：\', `date`) AS `remark`, `bank` AS `bankName`, NULL AS `cardNo`, `address`, NULL AS `fullName`, `zsjr` AS `fee` FROM `huikuan` WHERE `uid`=:uid AND `adddate` BETWEEN :qtime AND :etime ORDER BY `id` DESC LIMIT :limit',
                                'SELECT `id`, `money`, `lsh` AS `orderId`, `status`, `adddate` AS `addtime`, CONCAT(`manner`, \'<br />转账时间：\', `date`) AS `remark`, `bank` AS `bankName`, NULL AS `cardNo`, `address`, NULL AS `fullName`, `zsjr` AS `fee` FROM `huikuan` WHERE `uid`=:uid AND `adddate` BETWEEN :qtime AND :etime AND `id`<:id ORDER BY `id` DESC LIMIT :limit',
                            ];
                            $getStatus = function ($status) {
                                $return = '<font color="#0000FF">审核中</font>';
                                switch ($status) {
                                    case 1:
                                        $return = '<font color="#FF0000">成功</font>';
                                        break;
                                    case 2:
                                        $return = '失败';
                                        break;
                                }

                                return $return;
                            };
                            break;
                        case 'withdraw':
                            $params[':type'] = 2;
                            $getMoney = function ($money, $status) {
                                return abs($money);
                            };
                            break;
                        case 'bank':
                            $params[':type'] = 3;
                            $needNull = ['fullName', 'bankName', 'cardNo', 'address'];
                            break;
                        case 'activity':
                            $params[':type'] = 4;
                            $needNull = ['fullName', 'bankName', 'cardNo', 'address'];
                            break;
                        case 'point':
                            $params[':type'] = 5;
                            $needNull = ['fullName', 'bankName', 'cardNo', 'address'];
                            break;
                        case 'other':
                            $params[':type'] = 6;
                            $needNull = ['fullName', 'bankName', 'cardNo', 'address'];
                            break;
                    }
                    $stmt = $mydata1_db->prepare($sql[0]);
                    $stmt->execute($params);
                    $sum = $stmt->fetch();
                    if ($sum['count'] > 0) {
                        $MOBILE['output']['totalCount'] = $sum['count'];
                        $MOBILE['output']['totalMoney'] = $getMoney($sum['sum'], -1);
                        $params[':limit'] = $_POST['rows'];
                        if ($_POST['lastId'] > 0) {
                            $params[':id'] = $_POST['lastId'];
                            $MOBILE['output']['lastId'] = $_POST['lastId'];
                            $stmt = $mydata1_db->prepare($sql[2]);
                        } else {
                            $stmt = $mydata1_db->prepare($sql[1]);
                        }
                        $stmt->execute($params);
                        while ($rows = $stmt->fetch()) {
                            $rows['addtime'] = explode(' ', $rows['addtime']);
                            foreach ($needNull as $key) {
                                $rows[$key] = null;
                            }
                            $MOBILE['output']['msg'][] = [
                                'id' => $rows['id'],
                                'orderId' => $rows['orderId'],
                                'date' => $rows['addtime'][0],
                                'time' => $rows['addtime'][1],
                                'money' => $getMoney($rows['money'], $rows['status']),
                                'fee' => $rows['fee'],
                                'remark' => $rows['remark'],
                                'bankName' => $rows['bankName'],
                                'cardNo' => empty($rows['cardNo']) ? null : cutNum($rows['cardNo']),
                                'address' => $rows['address'],
                                'fullName' => $rows['fullName'],
                                'status' => $getStatus($rows['status']),
                            ];
                            $MOBILE['output']['lastId'] = $rows['id'];
                        }
                    }
                }
                break;
            case $_POST['type'] != 'online':
                if (isset($_POST['code']) && ($_POST['code'] = authCode($_POST['code'])) != '' && file_exists(IN_MOBILE.'../member/pay/moneyconfig.php')) {
                    $pay_online = 'default';
                    include IN_MOBILE.'../member/pay/moneyconfig.php';
                    if (isset($arr_online_config) && isset($arr_online_config[$_POST['code']])) {
                        if (isset($_POST['amount']) && preg_match('/^\d+(\.\d{1,2})?$/', $_POST['amount'])) {
                            $_POST['amount'] = floatval(sprintf('%.2f', floatval($_POST['amount'])));
                            $_POST['amount'] < $web_site['ck_limit'] && $_POST['amount'] = $web_site['ck_limit'];
                        } else {
                            $_POST['amount'] = $web_site['ck_limit'];
                        }
                        $MOBILE['output']['status'] = 1;
                        $MOBILE['output']['msg'] = (strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http').'://';
                        $MOBILE['output']['msg'] .= $_SERVER['HTTP_HOST'].':';
                        $MOBILE['output']['msg'] .= $_SERVER['SERVER_PORT'];
                        $MOBILE['output']['msg'] .= $_SERVER['REQUEST_URI'];
                        $MOBILE['output']['msg'] = dirname($MOBILE['output']['msg']).'/deposit.php?code=';
                        $output = [
                            'uid' => $_SESSION['uid'],
                            'username' => $_SESSION['username'],
                            'type' => $_POST['code'],
                            'amount' => $_POST['amount'],
                            'uri' => $arr_online_config[$_POST['code']]['post_url'],
                        ];
                        $MOBILE['output']['msg'] .= urlencode(authCode(serialize($output), 'ENCODE'));
                    } else {
                        $MOBILE['output']['msg'] = '支付方式不存在，请刷新页面重试';
                    }
                } else {
                    $MOBILE['output']['msg'] = '请求失败，请刷新页面重试';
                }
                break;
            default:
                $stmt = $mydata1_db->prepare('SELECT `money`, `pay_card`, `pay_num`, `pay_address`, `pay_name`, `qk_pwd`, `gid` FROM `k_user` WHERE `uid`=:uid AND `is_delete`=0 AND `is_stop`=0 LIMIT 1');
                $stmt->execute([':uid' => $_SESSION['uid']]);
                if ($rows = $stmt->fetch()) {
                    include IN_MOBILE.'../member/function.php';
                    include IN_MOBILE.'../common/function.php';
                    $allowed = time() + 43200;
                    $startTime = strtotime(date('Y-m-d ', $allowed.':00').$web_site['qk_time_begin']);
                    $endTime = strtotime(date('Y-m-d ', $allowed.':59').$web_site['qk_time_end']);
                    $allowed = $allowed >= $startTime && $allowed <= $endTime;
                    $MOBILE['output']['msg'] = '系统繁忙，请稍候重试';
                    switch ($_POST['type']) {
                        case 'config':
                        case 'get': //获取银行卡
                            $MOBILE['output']['status'] = 1;
                            $MOBILE['output']['msg'] = [];
                            if (! empty($rows['pay_num'])) {
                                $MOBILE['output']['msg'][] = [
                                    'bankName' => $rows['pay_card'],
                                    'cardNo' => cutNum($rows['pay_num']),
                                    'address' => $rows['pay_address'],
                                    'fullName' => $rows['pay_name'],
                                ];
                            }
                            if ($_POST['type'] == 'config') {
                                $MOBILE['output']['list'] = $MOBILE['output']['msg'];
                                $MOBILE['output']['msg'] = 'success';
                                $MOBILE['output']['time'] = [$web_site['qk_time_begin'], $web_site['qk_time_end']];
                                $MOBILE['output']['limit'] = $web_site['qk_limit'];
                                $MOBILE['output']['min'] = $web_site['ck_limit'];
                                $MOBILE['output']['allowed'] = $allowed;
                                $gid = $_SESSION['gid'];
                                $MOBILE['output']['deposit'] = [];
                                /*
                                if (file_exists(IN_MOBILE.'../member/pay/moneyconfig.php')) {
                                    $pay_online = 'default';
                                    include IN_MOBILE.'../member/pay/moneyconfig.php';
                                    if (isset($pay_online_type) && isset($pay_online_type[$gid])) {
                                        foreach ($pay_online_type[$gid] as $key => $val) {
                                            isset($arr_online_config[$val]) && $MOBILE['output']['deposit'][] = [
                                                'code' => authCode($val, 'ENCODE'),
                                                'name' => $arr_online_config[$val]['online_name'],
                                            ];
                                        }
                                    }
                                }
                                */
                                $MOBILE['output']['transfer'] = [];
                                /*
                                if (file_exists(IN_MOBILE.'../cache/bank.php')) {
                                    include IN_MOBILE.'../cache/bank.php';
                                    if (isset($bank) && isset($bank[$gid])) {
                                        foreach ($bank[$gid] as $key => $val) {
                                            $key = [
                                                'name' => $val['card_bankName'],
                                                'id' => $val['card_ID'],
                                                'username' => $val['card_userName'],
                                                'address' => $val['card_address'],
                                            ];
                                            $key['code'] = authCode(serialize($key), 'ENCODE');
                                            (! isset($val['state']) || $val['state'] != false) && $MOBILE['output']['transfer'][] = $key;
                                        }
                                    }
                                }
                                */
                                $MOBILE['output']['qrcode'] = [];
                                /*
                                if ($web_site['wxalipay'] == 1 && file_exists(IN_MOBILE.'../cache/bank2.php')) {
                                    include IN_MOBILE.'../cache/bank2.php';
                                    if (isset($bank) && isset($bank[$gid])) {
                                        foreach ($bank[$gid] as $key => $val) {
                                            $key = [
                                                'name' => $val['card_bankName'],
                                                'id' => $val['card_ID'],
                                                'nickName' => $val['card_name'],
                                                'img' => $val['card_img'],
                                            ];
                                            $key['code'] = authCode(serialize($key), 'ENCODE');
                                            (! isset($val['state']) || $val['state'] != false) && $MOBILE['output']['qrcode'][] = $key;
                                        }
                                    }
                                }
                                */
                            }
                            break;
                        case 'save': //保存银行卡
                            switch (true) {
                                case ! empty($rows['pay_num']):
                                    $MOBILE['output']['msg'] = '您已经添加过银行账户信息';
                                    break;

                                case empty($rows['qk_pwd']):
                                    $MOBILE['output']['msg'] = '请您先设置取款密码';
                                    break;

                                case empty($rows['pay_name']):
                                    $MOBILE['output']['msg'] = '请您先添加真实名字';
                                    break;

                                case ! isset($_POST['bankName']):
                                case ($_POST['bankName'] = htmlEncode($_POST['bankName'])) == '':
                                    $MOBILE['output']['msg'] = '请填写银行名称';
                                    break;

                                case ! isset($_POST['address']):
                                case ($_POST['address'] = htmlEncode($_POST['address'])) == '':
                                    $MOBILE['output']['msg'] = '请填写开户网点地址';
                                    break;

                                case ! isset($_POST['cardNo']):
                                case ($_POST['cardNo'] = htmlEncode($_POST['cardNo'])) == '':
                                    $MOBILE['output']['msg'] = '请填写银行卡号';
                                    break;

                                default:
                                    include IN_MOBILE.'../class/user.php';
                                    if (user::update_paycard($_SESSION['uid'], $_POST['bankName'], $_POST['cardNo'],
                                        $_POST['address'], $rows['pay_name'], $_SESSION['username'])) {
                                        $MOBILE['output']['status'] = 1;
                                        $MOBILE['output']['msg'] = [
                                            [
                                                'bankName' => $_POST['bankName'],
                                                'cardNo' => cutNum($_POST['cardNo']),
                                                'address' => $_POST['address'],
                                                'fullName' => $rows['pay_name'],
                                            ],
                                        ];
                                    }
                                    break;
                            }
                            break;
                        case 'withdraw':
                            switch (false) {
                                case ! (isset($_SESSION['last_get_money']) && $_SESSION['last_get_money'] > time()):
                                    $MOBILE['output']['msg'] = '为了方便及时给您出款，30秒之内请勿多次提交提款请求';
                                    break;
                                case isset($_POST['amount']) && ! empty($_POST['amount']):
                                case isset($_POST['password']) && ! empty($_POST['password']):
                                    $MOBILE['output']['msg'] = '请求失败，请刷新页面重试';
                                    break;
                                case preg_match('/^\d+(\.\d{1,2})?$/', $_POST['amount']):
                                case ($_POST['amount'] = floatval(sprintf('%.2f', floatval($_POST['amount'])))) > 0:
                                    $MOBILE['output']['msg'] = '请输入有效取款金额';
                                    break;
                                case $_POST['amount'] >= $web_site['qk_limit']:
                                    $MOBILE['output']['msg'] = '取款金额不能小于 '.sprintf('%.2f', $web_site['qk_limit']).' 元';
                                    break;
                                case $_POST['amount'] <= $rows['money']:
                                    $MOBILE['output']['msg'] = '账户余额不足';
                                    break;
                                case $_POST['password'] == $rows['qk_pwd']:
                                    $MOBILE['output']['msg'] = '取款密码不正确，请重新输入';
                                    break;
                                case $allowed:
                                    $MOBILE['output']['msg'] = '当前不在取款时间';
                                    break;
                                case $stmt = $mydata1_db->prepare('SELECT COUNT(1) AS `num` FROM `k_money` WHERE `type`=2 AND `status`=2 AND `uid`=:uid AND `m_make_time`>=DATE_ADD(NOW(), INTERVAL -1 DAY)'):
                                case $stmt->execute([':uid' => $_SESSION['uid']]):
                                case $check = $stmt->fetch():
                                case $check['num'] <= 0:
                                    $MOBILE['output']['msg'] = '您有未处理的取款订单，请等待完成';
                                    break;
                                default:
                                    $groupFile = IN_MOBILE.'/../cache/group_'.$rows['gid'].'.php';
                                    $maxCount = 0;
                                    if (file_exists($groupFile)) {
                                        include $groupFile;
                                        $maxCount = intval($pk_db['提款次数']);
                                        /*$startDate = strtotime(date('Y-m-d 12:00:00'));
                                        if (time() < $startDate) {
                                            $startDate = date('Y-m-d H:i:s', $startDate - 86400);
                                        } else {
                                            $startDate = date('Y-m-d H:i:s');
                                        }*/
                                        $startDate = date('Y-m-d');
                                        $stmt = $mydata1_db->prepare('SELECT COUNT(1) AS `count` FROM `k_money` WHERE `uid`=:uid AND `type`=2 AND `m_make_time`>=:startDate AND `status`=1');
                                        $stmt->execute([
                                            ':uid' => $_SESSION['uid'],
                                            ':startDate' => $startDate,
                                        ]);
                                        $count = $stmt->fetch();
                                    } else {
                                        $count = ['count' => 0];
                                    }
                                    if ($maxCount > $count['count'] || $maxCount == 0) {

                                        $stmt = $mydata1_db->prepare('UPDATE `k_user` SET `money`=`money`-:money1 WHERE `uid`=:uid AND `money`>=:money2');
                                        if ($stmt->execute([
                                            ':uid' => $_SESSION['uid'],
                                            ':money1' => $_POST['amount'],
                                            ':money2' => $_POST['amount'],
                                        ])) {
                                            $_SESSION['last_get_money'] = time() + 30;
                                            $order = $_SESSION['username'].'_'.date('YmdHis');
                                            $stmt = $mydata1_db->prepare('INSERT INTO `k_money_log` (`uid`, `userName`, `gameType`, `transferType`, `transferOrder`, `transferAmount`, `previousAmount`, `currentAmount`, `creationTime`) VALUES (:uid, :userName, :gameType, :transferType, :transferOrder, :transferAmount, :previousAmount, :currentAmount, :creationTime)');
                                            $stmt->execute([
                                                ':uid' => $_SESSION['uid'],
                                                ':userName' => $_SESSION['username'],
                                                ':gameType' => 'TIKUAN',
                                                ':transferType' => 'OUT',
                                                ':transferOrder' => $order,
                                                ':transferAmount' => -1 * $_POST['amount'],
                                                ':previousAmount' => $rows['money'],
                                                ':currentAmount' => $rows['money'] - $_POST['amount'],
                                                ':creationTime' => date('Y-m-d H:i:s'),
                                            ]);
                                            $stmt = $mydata1_db->prepare('INSERT INTO `k_money` (`uid`, `m_value`, `status`, `m_order`, `pay_card`, `pay_num`, `pay_address`, `pay_name`, `about`, `assets`, `balance`, `type`) VALUES (:uid, :m_value, 2, :m_order, :pay_card, :pay_num, :pay_address, :pay_name, \'\', :assets, :balance, 2)');
                                            $stmt->execute([
                                                ':uid' => $_SESSION['uid'],
                                                ':m_value' => -1 * $_POST['amount'],
                                                ':m_order' => $order,
                                                ':pay_card' => $rows['pay_card'],
                                                ':pay_num' => $rows['pay_num'],
                                                ':pay_address' => $rows['pay_address'],
                                                ':pay_name' => $rows['pay_name'],
                                                ':assets' => $rows['money'],
                                                ':balance' => $rows['money'] - $_POST['amount'],
                                            ]) && $MOBILE['output'] = ['status' => 1, 'msg' => 'success'];
                                        } else {
                                            $MOBILE['output']['msg'] = '余额扣除失败，请确认账户余额';
                                        }
                                    } else {
                                        $MOBILE['output']['msg'] = '今日提款次数已经用完，请明日再申请提款';
                                    }
                                    break;
                            }
                            break;
                        case 'transfer':
                            $isValid = false;
                            if (isset($_POST['qrcode'])) {
                                if (isset($_POST['username']) && ! empty($_POST['username'])) {
                                    $_POST['username'] = htmlEncode($_POST['username']);
                                    $_POST['address'] = '';
                                    $_POST['transfer'] = '会员昵称：'.$_POST['username'];
                                    $isValid = ! empty($_POST['username']);
                                }
                            } else {
                                if (isset($_POST['transfer']) && ! empty($_POST['transfer'])) {
                                    $_POST['transfer'] = htmlEncode($_POST['transfer']);
                                    $_POST['address'] = htmlEncode(isset($_POST['address']) ? $_POST['address'] : '');
                                    $_POST['username'] = htmlEncode(isset($_POST['username']) ? $_POST['username'] : '');
                                    $isValid = ! empty($_POST['transfer']);
                                    $isValid && ! empty($_POST['username']) && $_POST['transfer'] .= '<br />转账姓名：'.$_POST['username'];
                                }
                            }
                            switch (false) {
                                case $isValid:
                                case isset($_POST['code']) && ! empty($_POST['code']):
                                case $_POST['code'] = unserialize(authCode($_POST['code'])):
                                case isset($_POST['amount']) && ! empty($_POST['amount']):
                                case isset($_POST['time']) && ! empty($_POST['time']):
                                    $MOBILE['output']['msg'] = '请求失败，请刷新页面重试';
                                    break;
                                case preg_match('/^\d+(\.\d{1,2})?$/', $_POST['amount']):
                                case ($_POST['amount'] = floatval(sprintf('%.2f', floatval($_POST['amount'])))) > 0:
                                    $MOBILE['output']['msg'] = '请输入有效存款金额';
                                    break;
                                case $_POST['amount'] >= $web_site['ck_limit']:
                                    $MOBILE['output']['msg'] = '存款金额不能小于 '.sprintf('%.2f', $web_site['ck_limit']).' 元';
                                    break;
                                case preg_match('/^[1-9]\d{3}\-\d{2}\-\d{2} \d{2}:\d{2}:\d{2}$/', $_POST['time']):
                                    $MOBILE['output']['msg'] = '请选择存款时间';
                                    break;
                                case $stmt = $mydata1_db->prepare('SELECT COUNT(1) AS `num` FROM `huikuan` WHERE `status`=0 AND `uid`=:uid AND `adddate`>=DATE_ADD(NOW(), INTERVAL -1 DAY)'):
                                case $stmt->execute([':uid' => $_SESSION['uid']]):
                                case $check = $stmt->fetch():
                                case $check['num'] <= 0:
                                    $MOBILE['output']['msg'] = '您有未处理的存款订单，请等待完成';
                                    break;
                                default:
                                    $stmt = $mydata1_db->prepare('INSERT INTO `huikuan` (`money`, `bank`, `date`, `manner`, `address`, `adddate`, `status`, `uid`, `lsh`, `assets`, `balance`) VALUES (:money, :bank, :date, :manner, :address, :adddate, 0, :uid, :lsh, :assets, :balance)');
                                    $stmt->execute([
                                        ':money' => $_POST['amount'],
                                        ':bank' => $_POST['code']['name'].'<br />'.$_POST['code']['id'],
                                        ':date' => $_POST['time'],
                                        ':manner' => $_POST['transfer'],
                                        ':address' => $_POST['address'],
                                        ':adddate' => date('Y-m-d H:i:s'),
                                        ':uid' => $_SESSION['uid'],
                                        ':lsh' => $_SESSION['username'].'_'.date('YmdHis'),
                                        ':assets' => $rows['money'],
                                        ':balance' => $rows['money'] + $_POST['amount'],
                                    ]) && $MOBILE['output'] = ['status' => 1, 'msg' => 'success'];
                                    break;
                            }
                            break;
                    }
                }
                break;
        }
        break;
    case 'setFullName': //设置真实名字
        $MOBILE['output'] = ['status' => 0, 'msg' => 'success'];
        include IN_MOBILE.'../common/function.php';
        switch (false) {
            case isset($_SESSION['uid']):
                $MOBILE['output']['msg'] = '您已经退出登录，请重新登录';
                break;

            case isset($_POST['fullName']):
            case ($_POST['fullName'] = htmlEncode($_POST['fullName'])) != '':
                $MOBILE['output']['msg'] = '请输入真实姓名';
                break;

            case preg_match('/^[a-zA-Z ]{1,20}$/', $_POST['fullName']) || preg_match('/^[\x{4e00}-\x{9fa5}]{1,10}$/u',
                    $_POST['fullName']):
                $MOBILE['output']['msg'] = '真实姓名格式不正确';
                break;

            case $stmt = $mydata1_db->prepare('SELECT `pay_name` FROM `k_user` WHERE `uid`=:uid AND `is_delete`=0 AND `is_stop`=0 LIMIT 1'):
            case $stmt->execute([':uid' => $_SESSION['uid']]):
            case $rows = $stmt->fetch():
                $MOBILE['output']['msg'] = '系统繁忙，请稍候重试';
                break;

            case empty($rows['pay_name']):
                $MOBILE['output']['msg'] = '您已经添加了真实姓名';
                break;

            default:
                $stmt = $mydata1_db->prepare('UPDATE `k_user` SET `pay_name`=:pay_name WHERE `uid`=:uid');
                if ($stmt->execute([
                    ':pay_name' => $_POST['fullName'],
                    ':uid' => $_SESSION['uid'],
                ])) {
                    $MOBILE['output'] = ['status' => 1, 'msg' => 'success'];
                }
                break;
        }
        break;
    case 'transfer': //额度转换
        $MOBILE['output'] = ['status' => 0, 'msg' => '系统繁忙，请稍候重试'];
        switch (false) {
            case isset($_SESSION['uid']):
                $MOBILE['output']['msg'] = '您已经退出登录，请重新登录';
                break;

            case isset($_POST['type']):
            case in_array($_POST['type'], ['check', 'refresh', 'start']):
                $MOBILE['output']['msg'] = '请求类型不正确';
                break;

            default:
                /* $types = [
                    'MAYA' => ['mayamoney', '玛雅娱乐厅', 'giro_MAYA', '../cj/live/live_money_MAYA.php'],
                    'KY' => ['kymoney', '开元棋牌', 'giro_KY', '/cj/live/live_money_KY.php'],
                    'BBIN2' => ['bbin2money', '新BBIN旗舰厅', 'giro_BBIN2', '../cj/live/live_money_BBIN.php'],
                    'MG2' => ['mg2money', '新MG电子', 'giro_MG2', '../cj/live/live_money_MG2.php'],
                    'MW' => ['mwmoney', 'MW电子', 'giro_MW', '../cj/live/live_money_MW.php'],
                    'PT2' => ['pt2money', '新PT电子', 'giro_PT2', '../cj/live/live_money_PT.php'],
                    'OG2' => ['og2money', '新OG东方厅', 'giro_OG2', '../cj/live/live_money_OG.php'],
                    'CQ9' => ['cq9money', 'CQ9电子', 'giro_CQ9', '../cj/live/live_money_CQ9.php'],
                    'DG' => ['dgmoney', 'DG视讯', 'giro_DG', '../cj/live/live_money_DG.php'],
                    'KG' => ['kgmoney', 'AV女优', 'giro_KG', '../cj/live/live_money_KG.php'],
                    'VR' => ['vrmoney', 'VR彩票', 'giro_VR', '../cj/live/live_money_VR.php'],
                    'BGLIVE' => ['bgmoney', 'BG视讯', 'giro_BG', '../cj/live/live_money_BG.php'],
                    'SHABA' => ['shabamoney', '沙巴体育'],
                    'AG' => ['agqmoney', 'AG极速厅'],
                    'SB' => ['sbmoney', ['申博视讯（含RT电子、LAX电子）', 3], 'giro_SB', '../cj/live/live_money_SB.php'],
                    'AGIN' => ['agmoney', ['AG国际厅（含XIN电子、AG街机、BG电子）', 3]]
                ]; */
                $types = [];
                $liveTypes = include(IN_MOBILE.'../cj/include/live.transfer.php');
                foreach ($liveTypes as $key => $val) {
                    $data = [];
                    $data[] = $val['field'];
                    if (isset($val['col']) && $val['col'] > 1) {
                        if (isset($val['tips']) && ! empty($val['tips'])) {
                            $val['tips'] = implode('、', $val['tips']);
                            $val['name'] .= '、'.$val['tips'];
                        }
                        $data[] = [$val['name'], $val['col']];
                    } else {
                        $data[] = $val['name'];
                    }
                    if (isset($val['func']) && ! empty($val['func'])) {
                        $data[] = $val['func'];
                        if (isset($val['api']) && ! empty($val['api'])) {
                            $data[] = $val['api'];
                        }
                    }
                    $types[$key] = $data;
                }
                $names = [];
                foreach ($types as $key => $val) {
                    $names[$key] = $val[0];
                }
                $stmt = $mydata1_db->prepare('SELECT `iszhuan`, `money`, `'.implode('`, `',
                        $names).'` FROM `k_user` WHERE `uid`=:uid AND `is_delete`=0 AND `is_stop`=0 LIMIT 1');
                $stmt->execute([':uid' => $_SESSION['uid']]);
                if ($rows = $stmt->fetch()) {
                    switch ($_POST['type']) {
                        case 'check': //查询缓存额度
                            $MOBILE['output']['status'] = 1;
                            $MOBILE['output']['msg'] = ['allowed' => $rows['iszhuan'], 'list' => []];
                            $MOBILE['output']['msg']['list'][] = [
                                'GameClassID' => 'SYSTEM',
                                'GameClassName' => '体育/彩票',
                                'walletBalance' => 0,
                                'LoadingState' => 1,
                                'State' => 1,
                                'IsOnline' => 0,
                                'OpenState' => 1,
                                'colSpan' => 1,
                            ];
                            include IN_MOBILE.'../include/function_close_game.php';
                            foreach ($types as $id => $val) {
                                $name = $val[1];
                                is_string($name) && $name = [$name, 1];
                                $MOBILE['output']['msg']['list'][] = [
                                    'LiveMoneyUrl' => isset($val[3]) ? $val[3] : '../cj/live/live_money.php',
                                    'GameClassID' => $id,
                                    'GameClassName' => $name[0],
                                    'walletBalance' => 0,
                                    'LoadingState' => 1,
                                    'State' => money_change_game_is_close($id) ? 1 : 0,
                                    'IsOnline' => 0,
                                    'OpenState' => 1,
                                    'colSpan' => $name[1],
                                ];
                            }
                            break;
                        case 'refresh': //刷新额度记录
                            $MOBILE['output']['status'] = 1;
                            $isOpen = 1;
                            if (isset($_POST['id']) && in_array($_POST['id'], array_keys($names))) {
                                if ($rows['iszhuan'] == 1) {
                                    include IN_MOBILE.'../include/function_close_game.php';
                                    $isOpen = money_change_game_is_close($_POST['id']) ? 1 : 0;
                                } else {
                                    $isOpen = 0;
                                }
                                $rows['money'] = $isOpen ? $rows[$names[$_POST['id']]] : 0;
                            }
                            $MOBILE['output']['msg'] = [
                                'walletBalance' => sprintf('%.2f', $rows['money']),
                                'State' => $isOpen,
                                'IsOnline' => 0,
                                'OpenState' => 1,
                            ];
                            break;
                        case 'start': //开始转账
                            $names = array_keys($names);
                            $names[] = 'SYSTEM';
                            switch (false) {
                                case $rows['iszhuan'] == 1:
                                    $MOBILE['output']['msg'] = '您暂时不能进行额度转换';
                                    break;

                                case isset($_POST['out']) && in_array($_POST['out'], $names):
                                case isset($_POST['in']) && in_array($_POST['in'], $names):
                                    $MOBILE['output']['msg'] = '转账失败，请刷新页面重试';
                                    break;

                                case isset($_POST['money']) && ($_POST['money'] == 'all' || preg_match('/^[1-9]\d*$/',
                                            $_POST['money'])):
                                    $MOBILE['output']['msg'] = '请填写转账金额';
                                    break;

                                case $_POST['out'] != $_POST['in']:
                                    $MOBILE['output']['msg'] = '不能选择相同的钱包进行转账';
                                    break;

                                default:
                                    $allMoney = $_POST['money'] == 'all';
                                    $_POST['money'] = $allMoney ? $rows['money'] : abs($_POST['money']);
                                    include IN_MOBILE.'../include/function_close_game.php';
                                    if ($_POST['out'] != 'SYSTEM' && ! money_change_game_is_close($_POST['out'])) {
                                        $MOBILE['output']['msg'] = '转出钱包正在维护，请等待维护完毕';
                                    } else {
                                        if ($_POST['in'] != 'SYSTEM' && ! money_change_game_is_close($_POST['in'])) {
                                            $MOBILE['output']['msg'] = '转入钱包正在维护，请等待维护完毕';
                                        } else {
                                            if ($_POST['out'] == 'SYSTEM' && ($web_site['zh_low'] > $_POST['money'] || $_POST['money'] > $web_site['zh_high'])) {
                                                $MOBILE['output']['msg'] = '允许转账范围：<br />'.sprintf('%.2f',
                                                        $web_site['zh_low']).' ~ '.sprintf('%.2f',
                                                        $web_site['zh_high']);
                                            } else {
                                                include IN_MOBILE.'../cj/live/live_giro.php';
                                                $MOBILE['output']['msg'] = 'no';
                                                switch (true) {
                                                    case $_POST['out'] == 'SYSTEM' && $_POST['in'] != 'SYSTEM':
                                                        $fun = isset($types[$_POST['in']][2]) ? $types[$_POST['in']][2] : 'giro';
                                                        $MOBILE['output']['msg'] = $fun($_SESSION['uid'], $_POST['in'],
                                                            'IN', $_POST['money'], $allMoney);
                                                        break;

                                                    case $_POST['out'] != 'SYSTEM' && $_POST['in'] == 'SYSTEM':
                                                        $fun = isset($types[$_POST['out']][2]) ? $types[$_POST['out']][2] : 'giro';
                                                        $MOBILE['output']['msg'] = $fun($_SESSION['uid'], $_POST['out'],
                                                            'OUT', $_POST['money'], $allMoney);
                                                        break;

                                                    default:
                                                        $fun = isset($types[$_POST['out']][2]) ? $types[$_POST['out']][2] : 'giro';
                                                        $MOBILE['output']['msg'] = $fun($_SESSION['uid'], $_POST['out'],
                                                            'OUT', $_POST['money'], $allMoney);
                                                        if ($MOBILE['output']['msg'] == 'ok') {
                                                            $fun = isset($types[$_POST['in']][2]) ? $types[$_POST['in']][2] : 'giro';
                                                            $MOBILE['output']['msg'] = $fun($_SESSION['uid'],
                                                                $_POST['in'], 'IN', $_POST['money'], $allMoney);
                                                        }
                                                        break;
                                                }
                                                $MOBILE['output']['msg'] == 'ok' && $MOBILE['output'] = [
                                                    'status' => 1,
                                                    'msg' => 'success',
                                                ];
                                            }
                                        }
                                    }
                                    break;
                            }
                            break;
                    }
                }
                break;
        }
        break;
    case 'report': //投注记录
        $types = [
            'Sports' => [
                'DS' => '体育单式',
                'CG' => '体育串关',
            ],
            'Lottery' => [
                'PK10' => '北京赛车PK拾',
                'JSSC' => '极速赛车',
                'CQSSC' => '重庆时时彩',
                'TJSSC' => '天津时时彩',
                'XJSSC' => '新疆时时彩',
                'JSSSC' => '极速时时彩',
                'XYFT' => '幸运飞艇',
                'GDKL10' => '广东快乐10分',
                'CQKL10' => '重庆快乐10分',
                'TJKL10' => '天津快乐10分',
                'SXKL10' => '山西快乐10分',
                'HNKL10' => '湖南快乐10分',
                'YNGDKL10' => '云南快乐10分',
                'SHSSL' => '上海时时乐',
                'PL3' => '排列三',
                '3D' => '福彩3D',
                'KL8' => '北京快乐8',
                'PCDD' => 'PC蛋蛋',
                'QXC' => '七星彩',
                'JSLH' => '极速六合',
                'MARKSIX' => '六合彩',
                'GDSYXW' => '广东11选5',
                'SDSYXW' => '山东11选5',
                'FJSYXW' => '福建11选5',
                'BJSYXW' => '北京11选5',
                'AHSYXW' => '安徽11选5',
                'JSK3' => '江苏快3',
                'FJK3' => '福建快3',
                'GXK3' => '广西快3',
                'AHK3' => '安徽快3',
                'SHK3' => '上海快3',
                'HBK3' => '湖北快3',
                'HUBK3' => '河北快3',
                'JXK3' => '江西快3',
                'GSK3' => '甘肃快3',
                'GZK3' => '贵州快3',
                'BJK3' => '北京快3',
                'JLK3' => '吉林快3',
                'NMGK3' => '内蒙古快3',
            ],
        ];
        $MOBILE['output'] = ['status' => 0, 'msg' => '系统繁忙，请稍候重试'];
        switch (false) {
            case isset($_SESSION['uid']):
                $MOBILE['output']['msg'] = '您已经退出登录，请重新登录';
                break;

            case isset($_POST['type']):
            case in_array($_POST['type'], array_merge(['list', 'NotCount'], array_keys($types))):
                $MOBILE['output']['msg'] = '请求类型不正确';
                break;

            default:
                $MOBILE['output']['msg'] = '请求失败，请刷新页面重试';
                if ($_POST['type'] == 'list') {
                    $MOBILE['output']['status'] = 1;
                    $MOBILE['output']['msg'] = $types;
                } else {
                    if (isset($_POST['gameType'])) {
                        $_POST['gameType'] = strtoupper($_POST['gameType']);
                        (isset($_POST['lastId']) && preg_match('/^\d+$/', $_POST['lastId'])) || $_POST['lastId'] = 0;
                        (isset($_POST['rows']) && preg_match('/^[1-9]\d*$/', $_POST['rows'])) || $_POST['rows'] = 10;
                        (isset($_POST['start']) && preg_match('/^[1-9]\d{3}\-\d{2}\-\d{2}$/',
                                $_POST['start'])) || $_POST['start'] = date('Y-m-d', time() - 604800);
                        (isset($_POST['end']) && preg_match('/^[1-9]\d{3}\-\d{2}\-\d{2}$/',
                                $_POST['end'])) || $_POST['end'] = date('Y-m-d');
                        $_POST['rows'] > 100 && $_POST['rows'] = 100;
                        $status = 1;
                        switch ($_POST['type']) {
                            case 'Sports': //皇冠体育
                                $MOBILE['output']['status'] = 1;
                                $MOBILE['output']['sports'] = true;
                                $MOBILE['output']['msg'] = [];
                                $MOBILE['output']['totalCount'] = 0;
                                $MOBILE['output']['totalMoney'] = 0;
                                $params = [
                                    ':uid' => $_SESSION['uid'],
                                    ':qtime' => $_POST['start'].' 00:00:00',
                                    ':etime' => $_POST['end'].' 23:59:59',
                                ];
                                switch ($_POST['gameType']) {
                                    case 'CG':
                                        $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count`, SUM(IF(`status`=1 OR `status`=3, `win`-`bet_money`, 0)) AS `sum` FROM `k_bet_cg_group` WHERE `uid`=:uid AND `status` BETWEEN 0 AND 4 AND `bet_time` BETWEEN :qtime AND :etime');
                                        $stmt->execute($params);
                                        $sum = $stmt->fetch();
                                        if ($sum['count'] > 0) {
                                            $MOBILE['output']['totalCount'] = $sum['count'];
                                            $MOBILE['output']['totalMoney'] = $sum['sum'];
                                            $params[':limit'] = $_POST['rows'];
                                            if ($_POST['lastId'] > 0) {
                                                $sql = 'SELECT `gid`, `bet_time`, `cg_count`, `bet_money`, `bet_win`, `win`, `fs`, `status` FROM `k_bet_cg_group` WHERE `gid`<:id AND `uid`=:uid AND `status` BETWEEN 0 AND 4 AND `bet_time` BETWEEN :qtime AND :etime ORDER BY `gid` DESC LIMIT :limit';
                                                $params[':id'] = $_POST['lastId'];
                                                $MOBILE['output']['lastId'] = $_POST['lastId'];
                                            } else {
                                                $sql = 'SELECT `gid`, `bet_time`, `cg_count`, `bet_money`, `bet_win`, `win`, `fs`, `status` FROM `k_bet_cg_group` WHERE `uid`=:uid AND `status` BETWEEN 0 AND 4 AND `bet_time` BETWEEN :qtime AND :etime ORDER BY `gid` DESC LIMIT :limit';
                                            }
                                            $stmt = $mydata1_db->prepare($sql);
                                            $stmt->execute($params);
                                            while ($rows = $stmt->fetch()) {
                                                $rows['bet_time'] = explode(' ', $rows['bet_time']);
                                                $rows['remark'] = [];
                                                $query = $mydata1_db->prepare('SELECT `bid`, `bet_info`, `match_name`, `master_guest`, `bet_time`, `MB_Inball`, `TG_Inball`, `status` FROM `k_bet_cg` WHERE `gid`=:gid ORDER BY `bid` DESC');
                                                $query->execute([':gid' => $rows['gid']]);
                                                $rows['ok_count'] = 0;
                                                while ($rs = $query->fetch()) {
                                                    // 统计已结算单式
                                                    ! in_array($rs['status'], [0, 3]) && $rows['ok_count']++;
                                                    $temp = explode('-', $rs['bet_info']);
                                                    $remark = $temp[0].' '.$rs['match_name'];
                                                    if (strpos($rs['bet_info'], ' - ')) {
                                                        // 篮球上半之内的,这里换成正则表达替换
                                                        $temp[2] = $temp[2].preg_replace('[\[(.*)\]]', '', $temp[3]);
                                                    }
                                                    if (isset($temp[3])) {
                                                        $temp[2] = preg_replace('[\[(.*)\]]', '', $temp[2].$temp[3]);
                                                        unset($temp[3]);
                                                    }
                                                    // 如果是波胆
                                                    if (strpos($temp[0], '胆')) {
                                                        $bodan_score = explode('@', $temp[1], 2);
                                                        $rs['score'] = $bodan_score[0];
                                                        $temp[1] = '波胆@'.$bodan_score[1];
                                                    }
                                                    // 正则匹配
                                                    $rs['team'] = explode(strpos($rs['master_guest'],
                                                        'VS.') ? 'VS.' : 'VS', $rs['master_guest']);
                                                    preg_match('[\((.*)\)]', end($temp), $matches);
                                                    $matches && count($matches) > 0 && $remark .= ' '.$rs['bet_time'].$matches[0];
                                                    $remark .= '<br />';
                                                    if (strpos($temp[1], '让') > 0) { //让球
                                                        if (strpos($temp[1], '主') === false) { //客让
                                                            $remark .= $rs['team'][1];
                                                            $remark .= ' '.str_replace(['主让', '客让'], ['', ''],
                                                                    $temp[1]).' ';
                                                            $remark .= $rs['team'][0].'(主)';
                                                        } else { //主让
                                                            $remark .= $rs['team'][0];
                                                            $remark .= ' '.str_replace(['主让', '客让'], ['', ''],
                                                                    $temp[1]).' ';
                                                            $remark .= $rs['team'][1];
                                                        }
                                                        $temp[1] = '';
                                                    } else {
                                                        $remark .= $rs['team'][0];
                                                        $remark .= isset($rs['score']) ? $rs['score'] : ' VS ';
                                                        $remark .= $rs['team'][1];
                                                    }
                                                    $remark .= '<br />';
                                                    if (strpos($temp[1], '@')) {
                                                        $remark .= str_replace('@', ' @ ', $temp[1]);
                                                    } else {
                                                        $arraynew = [
                                                            $rs['team'][0],
                                                            ' / ',
                                                            $rs['team'][1],
                                                            '和局',
                                                            ' @ ',
                                                        ];
                                                        $arrayold = ['主', '/', '客', '和', '@'];
                                                        $temp[1] != '' && $remark .= $temp[1].' ';//半全场替换显示
                                                        $remark .= str_replace($arrayold, $arraynew,
                                                            preg_replace('[\((.*)\)]', '', end($temp)));
                                                    }
                                                    if ($rs['status'] == 3 || $rs['MB_Inball'] < 0) {
                                                        $remark .= ' [取消]';
                                                    } else {
                                                        if ($rs['status'] > 0) {
                                                            $remark .= ' ['.$rs['MB_Inball'].':'.$rs['TG_Inball'].']';
                                                        }
                                                    }
                                                    $rows['remark'][] = $remark;
                                                }
                                                if ($rows['cg_count'] == $rows['ok_count']) {
                                                    if (in_array($rows['status'], [1, 3])) {
                                                        $statusText = '已结算';
                                                    } else {
                                                        $statusText = '可结算';
                                                    }
                                                } else {
                                                    $statusText = '等待单式';
                                                }
                                                $MOBILE['output']['msg'][] = [
                                                    'id' => $rows['gid'],
                                                    'expect' => '共 '.$rows['cg_count'].' 场',
                                                    'betMode' => '体育串关 '.$rows['cg_count'].'串1',
                                                    'betContent' => implode('<hr />', $rows['remark']),
                                                    'betMoney' => $rows['bet_money'],
                                                    'winMoney' => $rows['bet_win'],
                                                    'winLoseMoney' => $rows['win'] - $rows['bet_money'],
                                                    'rewardMoney' => $rows['fs'],
                                                    'date' => $rows['bet_time'][0],
                                                    'time' => $rows['bet_time'][1],
                                                    'status' => $rows['status'],
                                                    'statusText' => $statusText,
                                                ];
                                                $MOBILE['output']['lastId'] = $rows['gid'];
                                            }
                                        }
                                        break;

                                    default:
                                        $stmt = $mydata1_db->prepare('SELECT COUNT(*) AS `count`, SUM(IF(`status`=0, 0, `win`-`bet_money`)) AS `sum` FROM `k_bet` WHERE `uid`=:uid AND `status` BETWEEN 0 AND 8 AND `bet_time` BETWEEN :qtime AND :etime');
                                        $stmt->execute($params);
                                        $sum = $stmt->fetch();
                                        if ($sum['count'] > 0) {
                                            $MOBILE['output']['totalCount'] = $sum['count'];
                                            $MOBILE['output']['totalMoney'] = $sum['sum'];
                                            $params[':limit'] = $_POST['rows'];
                                            if ($_POST['lastId'] > 0) {
                                                $sql = 'SELECT `bid`,`bet_time`, `number`, `ball_sort`, `bet_info`, `match_name`, `match_type`, `match_time`, `match_nowscore`, `match_showtype`, `master_guest`, `status`, `point_column`, `TG_Inball`, `MB_Inball`, `match_id`, `lose_ok`, `bet_money`, `bet_win`, `win`, `fs` FROM `k_bet` WHERE `bid`<:id AND `uid`=:uid AND `status` BETWEEN 0 AND 8 AND `bet_time` BETWEEN :qtime AND :etime ORDER BY `bid` DESC LIMIT :limit';
                                                $params[':id'] = $_POST['lastId'];
                                                $MOBILE['output']['lastId'] = $_POST['lastId'];
                                            } else {
                                                $sql = 'SELECT `bid`,`bet_time`, `number`, `ball_sort`, `bet_info`, `match_name`, `match_type`, `match_time`, `match_nowscore`, `match_showtype`, `master_guest`, `status`, `point_column`, `TG_Inball`, `MB_Inball`, `match_id`, `lose_ok`, `bet_money`, `bet_win`, `win`, `fs` FROM `k_bet` WHERE `uid`=:uid AND `status` BETWEEN 0 AND 8 AND `bet_time` BETWEEN :qtime AND :etime ORDER BY `bid` DESC LIMIT :limit';
                                            }
                                            $stmt = $mydata1_db->prepare($sql);
                                            $stmt->execute($params);
                                            while ($rows = $stmt->fetch()) {
                                                $rows['bet_time'] = explode(' ', $rows['bet_time']);
                                                $rows['match_showtype'] = strtolower($rows['match_showtype']);
                                                $temp = explode('-', $rows['bet_info']);
                                                if (isset($temp[3])) {
                                                    $temp[2] = preg_replace('[\[(.*)\]]', '', $temp[2].$temp[3]);
                                                    unset($temp[3]);
                                                }
                                                // 如果是波胆
                                                if (strpos($temp[0], '胆')) {
                                                    $bodan_score = explode('@', $temp[1], 2);
                                                    $rows['score'] = $bodan_score[0];
                                                    $temp[1] = '波胆@'.$bodan_score[1];
                                                }
                                                $is_other = in_array($rows['ball_sort'], ['冠军', '金融']);
                                                $rows['remark'] = $rows['match_name'];
                                                if ($rows['match_type'] == 2) {
                                                    $rows['remark'] .= ' '.$rows['match_time'];
                                                    if (strpos($rows['ball_sort'], '滚球') == false) {
                                                        if ($rows['match_nowscore'] == '') {
                                                            $rows['remark'] .= ' (0:0)';
                                                        } else {
                                                            if ($rows['match_showtype'] == 'h') {
                                                                $rows['remark'] .= ' ('.$rows['match_nowscore'].')';
                                                            } else {
                                                                $rows['remark'] .= ' ('.strrev($rows['match_nowscore']).')';
                                                            }
                                                        }
                                                    }
                                                }
                                                $rows['remark'] .= '<br />';
                                                $rows['team'] = explode(strpos($rows['master_guest'],
                                                    'VS.') ? 'VS.' : 'VS', $rows['master_guest']);
                                                if (strpos($temp[1], '让') > 0) {
                                                    if ($rows['match_showtype'] == 'c') {
                                                        $rows['remark'] .= $rows['team'][1];
                                                        $rows['remark'] .= ' '.str_replace(['主让', '客让'], ['', ''],
                                                                $temp[1]).' ';
                                                        $rows['remark'] .= $rows['team'][0].'(主)';
                                                    } else { //主让
                                                        $rows['remark'] .= $rows['team'][0];
                                                        $rows['remark'] .= ' '.str_replace(['主让', '客让'], ['', ''],
                                                                $temp[1]).' ';
                                                        $rows['remark'] .= $rows['team'][1];
                                                    }
                                                    $temp[1] = '';
                                                } else {
                                                    $rows['remark'] .= $rows['team'][0];
                                                    if (isset($rows['score'])) {
                                                        $rows['remark'] .= ' '.$rows['score'].' ';
                                                    } else {
                                                        if ($rows['team'][1] != '') {
                                                            $rows['remark'] .= ' VS ';
                                                        }
                                                    }
                                                    $rows['remark'] .= $rows['team'][1];
                                                }
                                                $rows['remark'] .= '<br />';
                                                //半全场替换显示
                                                if ($is_other) {
                                                    $rows['remark'] .= str_replace('@', ' @ ', $rows['bet_info']);
                                                } else {
                                                    $arraynew = [$rows['team'][0], $rows['team'][1], '和局', ' / ', '局'];
                                                    $arrayold = ['主', '客', '和', '/', '局局'];
                                                    $ss = str_replace($arrayold, $arraynew,
                                                        preg_replace('[\((.*)\)]', '', end($temp)));
                                                    $ss = explode('@', $ss);
                                                    if ($ss[0] == '独赢') {
                                                        $rows['remark'] .= $temp[1].' ';
                                                    } else {
                                                        if (strpos($ss[0], '独赢')) {
                                                            $rows['remark'] .= $temp[1].'-';
                                                        }
                                                    }
                                                    $rows['remark'] .= str_replace(' ', '', $ss[0]);
                                                    if ($rows['match_nowscore'] != '') {
                                                        if ($rows['match_showtype'] == 'h' || (! strrpos($temp[0],
                                                                '球'))) {
                                                            $rows['remark'] .= ' ('.$rows['match_nowscore'].')';
                                                        } else {
                                                            $rows['remark'] .= ' ('.strrev($rows['match_nowscore']).')';
                                                        }
                                                    }
                                                    $rows['remark'] .= ' @ '.$ss[1];
                                                }
                                                if (! in_array($rows['status'], [0, 3, 7, 6])) {
                                                    if ($rows['match_showtype'] == 'c' && strpos('&match_ao,match_ho,match_bho,match_bao&',
                                                            $rows['point_column']) > 0) {
                                                        $rows['remark'] .= ' ['.$rows['TG_Inball'].':'.$rows['MB_Inball'].']';
                                                    } else {
                                                        if ($is_other) {
                                                            if (! isset($match_result[$rows['match_id']])) {
                                                                $match_result[$rows['match_id']] = '';
                                                                $query = $mydata1_db->query('SELECT `x_result` FROM `mydata4_db`.`t_guanjun` WHERE `match_id`='.$rows['match_id']);
                                                                if ($query->rowCount() > 0) {
                                                                    $rs = $query->fetch();
                                                                    $match_result[$rows['match_id']] = str_replace('<br>',
                                                                        ' ', $rs['x_result']);
                                                                }
                                                            }
                                                            if ($match_result[$rows['match_id']] != '') {
                                                                $rows['remark'] .= ' ['.$match_result[$rows['match_id']].']';
                                                            }
                                                        } else {
                                                            $rows['remark'] .= ' ['.$rows['MB_Inball'].':'.$rows['TG_Inball'].']';
                                                        }
                                                    }
                                                }
                                                if ($rows['ball_sort'] == '足球滚球' || $rows['ball_sort'] == '足球上半场滚球' || $rows['ball_sort'] == '篮球滚球') {
                                                    if ($rows['lose_ok'] == 0) {
                                                        $rows['remark'] .= ' [确认中]';
                                                    } else {
                                                        if ($rows['status'] == 0) {
                                                            $rows['remark'] .= ' [已确认]';
                                                        }
                                                    }
                                                }
                                                $status = [
                                                    '未结算',
                                                    '赢',
                                                    '输',
                                                    '注单无效',
                                                    '赢一半',
                                                    '输一半',
                                                    '进球无效',
                                                    '红卡取消',
                                                    '和局',
                                                ];
                                                $MOBILE['output']['msg'][] = [
                                                    'id' => $rows['bid'],
                                                    'expect' => $rows['match_id'],
                                                    'betMode' => $rows['ball_sort'].($is_other ? '' : ' '.$temp[0]),
                                                    'betContent' => $rows['remark'],
                                                    'betMoney' => $rows['bet_money'],
                                                    'winMoney' => $rows['bet_win'],
                                                    'winLoseMoney' => $rows['win'] - $rows['bet_money'],
                                                    'rewardMoney' => $rows['fs'],
                                                    'date' => $rows['bet_time'][0],
                                                    'time' => $rows['bet_time'][1],
                                                    'status' => $rows['status'],
                                                    'statusText' => $status[$rows['status']],
                                                ];
                                                $MOBILE['output']['lastId'] = $rows['bid'];
                                            }
                                        }
                                        break;
                                }
                                break;

                            case 'NotCount': //未结算彩票
                            case 'Lottery': //系统彩票
                                $status = $_POST['type'] == 'NotCount' ? 0 : 1;
                                switch ($_POST['gameType']) {
                                    case 'CQSSC':
                                    case 'XJSSC':
                                    case 'TJSSC':
                                    case 'SFSSC':
                                    case 'GDKL10':
                                    case 'CQKL10':
                                    case 'TJKL10':
                                    case 'YNKL10':
                                    case 'HNKL10':
                                    case 'SXKL10':
                                    case 'FFKL10':
                                    case 'SFKL10':
                                    case 'PK10':
                                    case 'JSFT':
                                    case 'XYFT':
                                        $tables = $_POST['gameType'] == in_array($_POST['gameType'],
                                            ['CQSSC', 'TJSSC', 'XJSSC']) ? 'c_bet' : 'c_bet_3';
                                        $MOBILE['output']['status'] = 1;
                                        $MOBILE['output']['msg'] = [];
                                        $MOBILE['output']['totalCount'] = 0;
                                        $MOBILE['output']['totalMoney'] = 0;
                                        $params = [
                                            ':type' => $types['Lottery'][$_POST['gameType']],
                                            ':uid' => $_SESSION['uid'],
                                        ];
                                        if ($status) {
                                            $params[':qtime'] = $_POST['start'].' 00:00:00';
                                            $params[':etime'] = $_POST['end'].' 23:59:59';
                                            $sql = "SELECT COUNT(*) AS `count`, SUM(IF(`js`=1, IF(`win`>0, `win`-`money`, `win`), 0)) AS `sum` FROM `$tables` WHERE `uid`=:uid AND `type`=:type AND `addtime` BETWEEN :qtime AND :etime";
                                        } else {
                                            $sql = "SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `$tables` WHERE `uid`=:uid AND `type`=:type AND `js`=0";
                                        }
                                        $stmt = $mydata1_db->prepare($sql);
                                        $stmt->execute($params);
                                        $sum = $stmt->fetch();
                                        if ($sum['count'] > 0) {
                                            $MOBILE['output']['totalCount'] = $sum['count'];
                                            $MOBILE['output']['totalMoney'] = $sum['sum'];
                                            $params[':limit'] = $_POST['rows'];
                                            if ($_POST['lastId'] > 0) {
                                                if ($status) {
                                                    $sql = "SELECT * FROM `$tables` WHERE `id`<:id AND `uid`=:uid AND `type`=:type AND `addtime` BETWEEN :qtime AND :etime ORDER BY `id` DESC LIMIT :limit";
                                                } else {
                                                    $sql = "SELECT * FROM `$tables` WHERE `id`<:id AND `uid`=:uid AND `type`=:type AND `js`=0 ORDER BY `id` DESC LIMIT :limit";
                                                }
                                                $params[':id'] = $_POST['lastId'];
                                                $MOBILE['output']['lastId'] = $_POST['lastId'];
                                            } else {
                                                if ($status) {
                                                    $sql = "SELECT * FROM `$tables` WHERE `uid`=:uid AND `type`=:type AND `addtime` BETWEEN :qtime AND :etime ORDER BY `id` DESC LIMIT :limit";
                                                } else {
                                                    $sql = "SELECT * FROM `$tables` WHERE `uid`=:uid AND `type`=:type AND `js`=0 ORDER BY `id` DESC LIMIT :limit";
                                                }
                                            }
                                            $stmt = $mydata1_db->prepare($sql);
                                            $stmt->execute($params);
                                            while ($rows = $stmt->fetch()) {
                                                $rows['addtime'] = explode(' ', $rows['addtime']);
                                                $MOBILE['output']['msg'][] = [
                                                    'id' => $rows['id'],
                                                    'expect' => $rows['qishu'],
                                                    'date' => $rows['addtime'][0],
                                                    'time' => $rows['addtime'][1],
                                                    'betMoney' => $rows['money'],
                                                    'winLoseMoney' => $rows['win'] > 0 ? $rows['win'] - $rows['money'] : $rows['win'],
                                                    'betContent' => [$rows['mingxi_1'], $rows['mingxi_2']],
                                                    'odds' => $rows['odds'],
                                                    'status' => $rows['js'],
                                                ];
                                                $MOBILE['output']['lastId'] = $rows['id'];
                                            }
                                        }
                                        break;

                                    case 'JSSC':
                                    case 'JSSSC':
                                    case 'JSLH':
                                        $MOBILE['output']['status'] = 1;
                                        $MOBILE['output']['msg'] = [];
                                        $MOBILE['output']['totalCount'] = 0;
                                        $MOBILE['output']['totalMoney'] = 0;
                                        $params = [
                                            ':type' => $_POST['gameType'],
                                            ':uid' => $_SESSION['uid'],
                                        ];
                                        if ($status) {
                                            $params[':qtime'] = strtotime($_POST['start'].' 00:00:00');
                                            $params[':etime'] = strtotime($_POST['end'].' 23:59:59');
                                            $sql = 'SELECT COUNT(*) AS `count`, SUM(IF(`status`=1, IF(`win`>0, `win`-`money`, `win`), 0)) AS `sum` FROM `c_bet_data` WHERE `uid`=:uid AND `type`=:type AND `addtime` BETWEEN :qtime AND :etime AND `status` BETWEEN 0 AND 1';
                                        } else {
                                            $sql = 'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `c_bet_data` WHERE `uid`=:uid AND `type`=:type AND `status`=0';
                                        }
                                        $stmt = $mydata1_db->prepare($sql);
                                        $stmt->execute($params);
                                        $sum = $stmt->fetch();
                                        if ($sum['count'] > 0) {
                                            $MOBILE['output']['totalCount'] = $sum['count'];
                                            $MOBILE['output']['totalMoney'] = $sum['sum'] / 100;
                                            $params[':limit'] = $_POST['rows'];
                                            if ($_POST['lastId'] > 0) {
                                                if ($status) {
                                                    $sql = 'SELECT * FROM `c_bet_data` WHERE `id`<:id AND `uid`=:uid AND `type`=:type AND `addtime` BETWEEN :qtime AND :etime AND `status` BETWEEN 0 AND 1 ORDER BY `id` DESC LIMIT :limit';
                                                } else {
                                                    $sql = 'SELECT * FROM `c_bet_data` WHERE `id`<:id AND `uid`=:uid AND `type`=:type AND `status`=0 ORDER BY `id` DESC LIMIT :limit';
                                                }
                                                $params[':id'] = $_POST['lastId'];
                                                $MOBILE['output']['lastId'] = $_POST['lastId'];
                                            } else {
                                                if ($status) {
                                                    $sql = 'SELECT * FROM `c_bet_data` WHERE `uid`=:uid AND `type`=:type AND `addtime` BETWEEN :qtime AND :etime AND `status` BETWEEN 0 AND 1 ORDER BY `id` DESC LIMIT :limit';
                                                } else {
                                                    $sql = 'SELECT * FROM `c_bet_data` WHERE `uid`=:uid AND `type`=:type AND `status`=0 ORDER BY `id` DESC LIMIT :limit';
                                                }
                                            }
                                            $stmt = $mydata1_db->prepare($sql);
                                            $stmt->execute($params);
                                            while ($rows = $stmt->fetch()) {
                                                $rows['value'] = unserialize($rows['value']);
                                                $MOBILE['output']['msg'][] = [
                                                    'id' => $rows['id'],
                                                    'expect' => $rows['value']['qishu'],
                                                    'date' => date('Y-m-d', $rows['addtime']),
                                                    'time' => date('H:i:s', $rows['addtime']),
                                                    'betMoney' => $rows['money'] / 100,
                                                    'winLoseMoney' => ($rows['win'] > 0 ? $rows['win'] - $rows['money'] : $rows['win']) / 100,
                                                    'betContent' => $rows['value']['class'],
                                                    'odds' => $rows['value']['odds'],
                                                    'status' => $rows['status'],
                                                ];
                                                $MOBILE['output']['lastId'] = $rows['id'];
                                            }
                                        }
                                        break;

                                    case 'KL8':
                                    case 'SHSSL':
                                    case '3D':
                                    case 'PL3':
                                    case 'QXC':
                                    case 'FFQXC':
                                    case 'WFQXC':
                                        $_POST['gameType'] == 'SHSSL' && $_POST['gameType'] = 'SSL';
                                        $MOBILE['output']['status'] = 1;
                                        $MOBILE['output']['msg'] = [];
                                        $MOBILE['output']['totalCount'] = 0;
                                        $MOBILE['output']['totalMoney'] = 0;
                                        $params = [
                                            ':type' => strtolower($_POST['gameType']),
                                            ':username' => $_SESSION['username'],
                                        ];
                                        if ($status) {
                                            $params[':qtime'] = $_POST['start'].' 00:00:00';
                                            $params[':etime'] = $_POST['end'].' 23:59:59';
                                            $sql = 'SELECT COUNT(*) AS `count`, SUM(IF(`bet_ok`=1, `win`, 0)) AS `sum` FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_time` BETWEEN :qtime AND :etime';
                                        } else {
                                            $sql = 'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_ok`=0';
                                        }
                                        $stmt = $mydata1_db->prepare($sql);
                                        $stmt->execute($params);
                                        $sum = $stmt->fetch();
                                        if ($sum['count'] > 0) {
                                            $MOBILE['output']['totalCount'] = $sum['count'];
                                            $MOBILE['output']['totalMoney'] = $sum['sum'];
                                            $params[':limit'] = $_POST['rows'];
                                            if ($_POST['lastId'] > 0) {
                                                if ($status) {
                                                    $sql = 'SELECT * FROM `lottery_data` WHERE `id`<:id AND `username`=:username AND `atype`=:type AND `bet_time` BETWEEN :qtime AND :etime ORDER BY `id` DESC LIMIT :limit';
                                                } else {
                                                    $sql = 'SELECT * FROM `lottery_data` WHERE `id`<:id AND `username`=:username AND `atype`=:type AND `bet_ok`=0 ORDER BY `id` DESC LIMIT :limit';
                                                }
                                                $params[':id'] = $_POST['lastId'];
                                                $MOBILE['output']['lastId'] = $_POST['lastId'];
                                            } else {
                                                if ($status) {
                                                    $sql = 'SELECT * FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_time` BETWEEN :qtime AND :etime ORDER BY `id` DESC LIMIT :limit';
                                                } else {
                                                    $sql = 'SELECT * FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_ok`=0 ORDER BY `id` DESC LIMIT :limit';
                                                }
                                            }
                                            $stmt = $mydata1_db->prepare($sql);
                                            $stmt->execute($params);
                                            while ($rows = $stmt->fetch()) {
                                                $rows['bet_time'] = explode(' ', $rows['bet_time']);
                                                $rows['money'] = floatval($rows['money']);
                                                $rows['win'] = floatval($rows['win']);
                                                $rows['odds'] = floatval($rows['odds']);
                                                if ($rows['atype'] == 'qxc' || $rows['atype'] == 'ffqxc' || $rows['atype'] == 'wfqxc') {
                                                    if ($rows['btype'] == '定位') {
                                                        $rows['ctype'] = explode('/', $rows['ctype']);
                                                        $rows['dtype'] .= ' - '.$rows['ctype'][0].'注 - '.sprintf('%.2f',
                                                                $rows['ctype'][1]).'/注';
                                                    }
                                                    $rows['content'] = [$rows['dtype'], $rows['content']];
                                                } else {
                                                    $rows['win'] > 0 && $rows['win'] += $rows['money'];
                                                    $rows['atype'] != 'kl8' && $rows['btype'] .= ' - '.$rows['ctype'].' - '.$rows['dtype'];
                                                    $rows['content'] = [$rows['btype'], $rows['content']];
                                                }
                                                $MOBILE['output']['msg'][] = [
                                                    'id' => $rows['uid'],
                                                    'expect' => $rows['mid'],
                                                    'date' => $rows['bet_time'][0],
                                                    'time' => $rows['bet_time'][1],
                                                    'betMoney' => $rows['money'],
                                                    'winLoseMoney' => $rows['win'],
                                                    'betContent' => $rows['content'],
                                                    'odds' => $rows['odds'],
                                                    'status' => $rows['bet_ok'],
                                                ];
                                                $MOBILE['output']['lastId'] = $rows['id'];
                                            }
                                        }
                                        break;
                                    case 'GDSYXW':
                                    case 'SDSYXW':
                                    case 'FJSYXW':
                                    case 'BJSYXW':
                                    case 'AHSYXW':
                                    case 'FFSYXW':
                                    case 'SFSYXW':

                                        $MOBILE['output']['status'] = 1;
                                        $MOBILE['output']['msg'] = [];
                                        $MOBILE['output']['totalCount'] = 0;
                                        $MOBILE['output']['totalMoney'] = 0;
                                        $tables = 'c_bet_choose5';
                                        $params = [
                                            ':type' => $_POST['gameType'],
                                            ':uid' => $_SESSION['uid'],
                                        ];
                                        if ($status) {
                                            $params[':qtime'] = $_POST['start'].' 00:00:00';
                                            $params[':etime'] = $_POST['end'].' 23:59:59';
                                            $sql = "SELECT COUNT(*) AS `count`, SUM(IF(`js`=1, IF(`win`>0, `win`-`money`, `win`), 0)) AS `sum` FROM `$tables` WHERE `uid`=:uid AND `type`=:type AND `addtime` BETWEEN :qtime AND :etime";
                                        } else {
                                            $sql = "SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `$tables` WHERE `uid`=:uid AND `type`=:type AND `js`=0";
                                        }
                                        $stmt = $mydata1_db->prepare($sql);
                                        $stmt->execute($params);
                                        $sum = $stmt->fetch();
                                        if ($sum['count'] > 0) {
                                            $MOBILE['output']['totalCount'] = $sum['count'];
                                            $MOBILE['output']['totalMoney'] = $sum['sum'];
                                            $params[':limit'] = $_POST['rows'];
                                            if ($_POST['lastId'] > 0) {
                                                if ($status) {
                                                    $sql = "SELECT * FROM `$tables` WHERE `id`<:id AND `uid`=:uid AND `type`=:type AND `addtime` BETWEEN :qtime AND :etime ORDER BY `id` DESC LIMIT :limit";
                                                } else {
                                                    $sql = "SELECT * FROM `$tables` WHERE `id`<:id AND `uid`=:uid AND `type`=:type AND `js`=0 ORDER BY `id` DESC LIMIT :limit";
                                                }
                                                $params[':id'] = $_POST['lastId'];
                                                $MOBILE['output']['lastId'] = $_POST['lastId'];
                                            } else {
                                                if ($status) {
                                                    $sql = "SELECT * FROM `$tables` WHERE `uid`=:uid AND `type`=:type AND `addtime` BETWEEN :qtime AND :etime ORDER BY `id` DESC LIMIT :limit";
                                                } else {
                                                    $sql = "SELECT * FROM `$tables` WHERE `uid`=:uid AND `type`=:type AND `js`=0 ORDER BY `id` DESC LIMIT :limit";
                                                }
                                            }
                                            $stmt = $mydata1_db->prepare($sql);
                                            $stmt->execute($params);
                                            while ($rows = $stmt->fetch()) {
                                                $rows['addtime'] = explode(' ', $rows['addtime']);
                                                $MOBILE['output']['msg'][] = [
                                                    'id' => $rows['id'],
                                                    'expect' => $rows['qishu'],
                                                    'date' => $rows['addtime'][0],
                                                    'time' => $rows['addtime'][1],
                                                    'betMoney' => $rows['money'],
                                                    'winLoseMoney' => $rows['win'] > 0 ? $rows['win'] - $rows['money'] : $rows['win'],
                                                    'betContent' => [$rows['mingxi_1'], $rows['mingxi_2']],
                                                    'odds' => $rows['odds'],
                                                    'status' => $rows['js'],
                                                ];
                                                $MOBILE['output']['lastId'] = $rows['id'];
                                            }
                                        }
                                        break;

                                    case 'JSK3':
                                    case 'FJK3':
                                    case 'AHK3':
                                    case 'BJK3':
                                    case 'HBK3':
                                    case 'HEBK3':
                                    case 'HNK3':
                                    case 'NMGK3':
                                    case 'JXK3':
                                    case 'GXK3':
                                    case 'JLK3':
                                    case 'GZK3':
                                    case 'GSK3':
                                    case 'QHK3':
                                    case 'SHK3':
                                    case 'FFK3':
                                    case 'SFK3':
                                        $MOBILE['output']['status'] = 1;
                                        $MOBILE['output']['msg'] = [];
                                        $MOBILE['output']['totalCount'] = 0;
                                        $MOBILE['output']['totalMoney'] = 0;
                                        $params = [
                                            ':type' => strtolower($_POST['gameType']),
                                            ':username' => $_SESSION['username'],
                                        ];
                                        if ($status) {
                                            $params[':qtime'] = $_POST['start'].' 00:00:00';
                                            $params[':etime'] = $_POST['end'].' 23:59:59';
                                            $sql = 'SELECT COUNT(*) AS `count`, SUM(IF(`bet_ok`=1, `win`, 0)) AS `sum` FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_time` BETWEEN :qtime AND :etime';
                                        } else {
                                            $sql = 'SELECT COUNT(*) AS `count`, SUM(`money`) AS `sum` FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_ok`=0';
                                        }
                                        $stmt = $mydata1_db->prepare($sql);
                                        $stmt->execute($params);
                                        $sum = $stmt->fetch();
                                        if ($sum['count'] > 0) {
                                            $MOBILE['output']['totalCount'] = $sum['count'];
                                            $MOBILE['output']['totalMoney'] = $sum['sum'];
                                            $params[':limit'] = $_POST['rows'];
                                            if ($_POST['lastId'] > 0) {
                                                if ($status) {
                                                    $sql = 'SELECT * FROM `lottery_data` WHERE `id`<:id AND `username`=:username AND `atype`=:type AND `bet_time` BETWEEN :qtime AND :etime ORDER BY `id` DESC LIMIT :limit';
                                                } else {
                                                    $sql = 'SELECT * FROM `lottery_data` WHERE `id`<:id AND `username`=:username AND `atype`=:type AND `bet_ok`=0 ORDER BY `id` DESC LIMIT :limit';
                                                }
                                                $params[':id'] = $_POST['lastId'];
                                                $MOBILE['output']['lastId'] = $_POST['lastId'];
                                            } else {
                                                if ($status) {
                                                    $sql = 'SELECT * FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_time` BETWEEN :qtime AND :etime ORDER BY `id` DESC LIMIT :limit';
                                                } else {
                                                    $sql = 'SELECT * FROM `lottery_data` WHERE `username`=:username AND `atype`=:type AND `bet_ok`=0 ORDER BY `id` DESC LIMIT :limit';
                                                }
                                            }
                                            $stmt = $mydata1_db->prepare($sql);
                                            $stmt->execute($params);
                                            while ($rows = $stmt->fetch()) {
                                                $rows['bet_time'] = explode(' ', $rows['bet_time']);
                                                $rows['money'] = floatval($rows['money']);
                                                $rows['win'] = floatval($rows['win']);
                                                $rows['odds'] = floatval($rows['odds']);

                                                $MOBILE['output']['msg'][] = [
                                                    'id' => $rows['uid'],
                                                    'expect' => $rows['mid'],
                                                    'date' => $rows['bet_time'][0],
                                                    'time' => $rows['bet_time'][1],
                                                    'betMoney' => $rows['money'],
                                                    'winLoseMoney' => $rows['win'],
                                                    'betContent' => $rows['content'],
                                                    'odds' => $rows['odds'],
                                                    'status' => $rows['bet_ok'],
                                                ];
                                                $MOBILE['output']['lastId'] = $rows['id'];
                                            }
                                        }
                                        break;

                                    case 'MARKSIX':
                                        $MOBILE['output']['status'] = 1;
                                        $MOBILE['output']['msg'] = [];
                                        $MOBILE['output']['totalCount'] = 0;
                                        $MOBILE['output']['totalMoney'] = 0;
                                        $params = [
                                            ':username' => $_SESSION['username'],
                                        ];
                                        if ($status) {
                                            $params[':qtime'] = $_POST['start'].' 12:00:00';
                                            $params[':etime'] = date('Y-m-d H:i:s',
                                                strtotime($_POST['end'].' 23:59:59') + 43200);
                                            $sql = 'SELECT COUNT(*) AS `count`, SUM(IF(`checked`=1, CASE WHEN `bm`=1 THEN (`sum_m`*`rate`)-`sum_m` WHEN `bm`=2 THEN 0 ELSE -1*`sum_m` END, 0)) AS `sum` FROM `ka_tan` WHERE `username`=:username AND `adddate` BETWEEN :qtime AND :etime';
                                        } else {
                                            $sql = 'SELECT COUNT(*) AS `count`, SUM(`sum_m`) AS `sum` FROM `ka_tan` WHERE `username`=:username AND `checked`=0';
                                        }
                                        $stmt = $mydata2_db->prepare($sql);
                                        $stmt->execute($params);
                                        $sum = $stmt->fetch();
                                        if ($sum['count'] > 0) {
                                            $MOBILE['output']['totalCount'] = $sum['count'];
                                            $MOBILE['output']['totalMoney'] = $sum['sum'];
                                            $params[':limit'] = $_POST['rows'];
                                            if ($_POST['lastId'] > 0) {
                                                if ($status) {
                                                    $sql = 'SELECT * FROM `ka_tan` WHERE `id`<:id AND `username`=:username AND `adddate` BETWEEN :qtime AND :etime ORDER BY `id` DESC LIMIT :limit';
                                                } else {
                                                    $sql = 'SELECT * FROM `ka_tan` WHERE `id`<:id AND `username`=:username AND `checked`=0 ORDER BY `id` DESC LIMIT :limit';
                                                }
                                                $params[':id'] = $_POST['lastId'];
                                                $MOBILE['output']['lastId'] = $_POST['lastId'];
                                            } else {
                                                if ($status) {
                                                    $sql = 'SELECT * FROM `ka_tan` WHERE `username`=:username AND `adddate` BETWEEN :qtime AND :etime ORDER BY `id` DESC LIMIT :limit';
                                                } else {
                                                    $sql = 'SELECT * FROM `ka_tan` WHERE `username`=:username AND `checked`=0 ORDER BY `id` DESC LIMIT :limit';
                                                }
                                            }
                                            $stmt = $mydata2_db->prepare($sql);
                                            $stmt->execute($params);
                                            while ($rows = $stmt->fetch()) {
                                                $rows['adddate'] = date('Y-m-d H:i:s',
                                                    strtotime($rows['adddate']) - 43200);
                                                $rows['adddate'] = explode(' ', $rows['adddate']);
                                                $rows['win'] = $rows['sum_m'] * $rows['rate'];
                                                if ($rows['class1'] == '过关') {
                                                    $rows['class2'] = explode(',', $rows['class2']);
                                                    $rows['class3'] = explode(',', $rows['class3']);
                                                    $rows['class4'] = [];
                                                    foreach ($rows['class2'] as $key => $val) {
                                                        if (! empty($val)) {
                                                            $key *= 2;
                                                            $rows['class4'][] = $val.'-'.$rows['class3'][$key].'@'.$rows['class3'][$key + 1];
                                                        }
                                                    }
                                                    $rows['content'] = [$rows['class1'], implode(',', $rows['class4'])];
                                                } else {
                                                    $rows['content'] = [
                                                        $rows['class1'].' - '.$rows['class2'],
                                                        $rows['class3'],
                                                    ];
                                                }
                                                if ($rows['checked'] == 1) {
                                                    if ($rows['bm'] == 2) {
                                                        $rows['win'] = 0;
                                                    } else {
                                                        if ($rows['bm'] == 1) {
                                                            $rows['win'] -= $rows['sum_m'];
                                                        } else {
                                                            $rows['win'] = -1 * $rows['sum_m'];
                                                        }
                                                    }
                                                }
                                                $MOBILE['output']['msg'][] = [
                                                    'id' => $rows['num'],
                                                    'expect' => $rows['kithe'],
                                                    'date' => $rows['adddate'][0],
                                                    'time' => $rows['adddate'][1],
                                                    'betMoney' => $rows['sum_m'],
                                                    'winLoseMoney' => $rows['win'],
                                                    'betContent' => $rows['content'],
                                                    'odds' => $rows['rate'],
                                                    'status' => $rows['checked'],
                                                ];
                                                $MOBILE['output']['lastId'] = $rows['id'];
                                            }
                                        }
                                        break;
                                }
                                break;
                        }
                        break;
                    }
                }
                break;
        }
        break;
    case 'lottery': //彩票
        $MOBILE['output'] = ['status' => 0, 'msg' => '系统繁忙，请稍候重试'];
        switch (true) {
            case ! isset($_POST['type']):
            case ! in_array($_POST['type'], ['list', 'animal', 'history']):
                $MOBILE['output']['msg'] = '请求类型不正确';
                break;
            case $_POST['type'] == 'list': //彩票列表以及设置
                $MOBILE['output'] = [
                    'status' => 1,
                    'msg' => [
                        'pk10' => [
                            'name' => '北京赛车PK拾',
                            'open' => $web_site['pk10'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'gy' => '冠亚和',
                                'lh' => '龙虎',
                                'no1' => '冠军',
                                'no2' => '亚军',
                                'no3' => '第三名',
                                'no4' => '第四名',
                                'no5' => '第五名',
                                'no6' => '第六名',
                                'no7' => '第七名',
                                'no8' => '第八名',
                                'no9' => '第九名',
                                'no10' => '第十名',
                            ],
                            'class' => 'round-6',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'jssc' => [
                            'name' => '极速赛车',
                            'open' => $web_site['jssc'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'gy' => '冠亚和',
                                'lh' => '龙虎',
                                'no1' => '冠军',
                                'no2' => '亚军',
                                'no3' => '第三名',
                                'no4' => '第四名',
                                'no5' => '第五名',
                                'no6' => '第六名',
                                'no7' => '第七名',
                                'no8' => '第八名',
                                'no9' => '第九名',
                                'no10' => '第十名',
                            ],
                            'class' => 'round-9',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'cqssc' => [
                            'name' => '重庆时时彩',
                            'open' => $web_site['ssc'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '第一球',
                                'no2' => '第二球',
                                'no3' => '第三球',
                                'no4' => '第四球',
                                'no5' => '第五球',
                                'all' => '整合',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'xjssc' => [
                            'name' => '新疆时时彩',
                            'open' => $web_site['ssc'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '第一球',
                                'no2' => '第二球',
                                'no3' => '第三球',
                                'no4' => '第四球',
                                'no5' => '第五球',
                                'all' => '整合',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'tjssc' => [
                            'name' => '天津时时彩',
                            'open' => $web_site['ssc'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '第一球',
                                'no2' => '第二球',
                                'no3' => '第三球',
                                'no4' => '第四球',
                                'no5' => '第五球',
                                'all' => '整合',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'jsssc' => [
                            'name' => '极速时时彩',
                            'open' => $web_site['jsssc'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '第一球',
                                'no2' => '第二球',
                                'no3' => '第三球',
                                'no4' => '第四球',
                                'no5' => '第五球',
                                'all' => '整合',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'xyft' => [
                            'name' => '幸运飞艇',
                            'open' => $web_site['xyft'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'gy' => '冠亚和',
                                'lh' => '龙虎',
                                'no1' => '冠军',
                                'no2' => '亚军',
                                'no3' => '第三名',
                                'no4' => '第四名',
                                'no5' => '第五名',
                                'no6' => '第六名',
                                'no7' => '第七名',
                                'no8' => '第八名',
                                'no9' => '第九名',
                                'no10' => '第十名',
                            ],
                            'class' => 'round-9',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'gdchoose5' => [
                            'name' => '广东11选5',
                            'open' => $web_site['choose5'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '正码一',
                                'no2' => '正码二',
                                'no3' => '正码三',
                                'no4' => '正码四',
                                'no5' => '正码五',
                                'qwzy' => '全五中一',
                                'lh' => '龙虎',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 0,
                        ],
                        'sdchoose5' => [
                            'name' => '山东11选5',
                            'open' => $web_site['choose5'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '正码一',
                                'no2' => '正码二',
                                'no3' => '正码三',
                                'no4' => '正码四',
                                'no5' => '正码五',
                                'qwzy' => '全五中一',
                                'lh' => '龙虎',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 0,
                        ],
                        'fjchoose5' => [
                            'name' => '福建11选5',
                            'open' => $web_site['choose5'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '正码一',
                                'no2' => '正码二',
                                'no3' => '正码三',
                                'no4' => '正码四',
                                'no5' => '正码五',
                                'qwzy' => '全五中一',
                                'lh' => '龙虎',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 0,
                        ],
                        'bjchoose5' => [
                            'name' => '北京11选5',
                            'open' => $web_site['choose5'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '正码一',
                                'no2' => '正码二',
                                'no3' => '正码三',
                                'no4' => '正码四',
                                'no5' => '正码五',
                                'qwzy' => '全五中一',
                                'lh' => '龙虎',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 0,
                        ],
                        'ahchoose5' => [
                            'name' => '安徽11选5',
                            'open' => $web_site['choose5'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '正码一',
                                'no2' => '正码二',
                                'no3' => '正码三',
                                'no4' => '正码四',
                                'no5' => '正码五',
                                'qwzy' => '全五中一',
                                'lh' => '龙虎',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 0,
                        ],
                        'gdkl10' => [
                            'name' => '广东快乐10分',
                            'open' => $web_site['klsf'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '第一球',
                                'no2' => '第二球',
                                'no3' => '第三球',
                                'no4' => '第四球',
                                'no5' => '第五球',
                                'no6' => '第六球',
                                'no7' => '第七球',
                                'no8' => '第八球',
                                'zh' => '总和',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'cqkl10' => [
                            'name' => '重庆快乐10分',
                            'open' => $web_site['klsf'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '第一球',
                                'no2' => '第二球',
                                'no3' => '第三球',
                                'no4' => '第四球',
                                'no5' => '第五球',
                                'no6' => '第六球',
                                'no7' => '第七球',
                                'no8' => '第八球',
                                'zh' => '总和',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'hnkl10' => [
                            'name' => '湖南快乐10分',
                            'open' => $web_site['klsf'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '第一球',
                                'no2' => '第二球',
                                'no3' => '第三球',
                                'no4' => '第四球',
                                'no5' => '第五球',
                                'no6' => '第六球',
                                'no7' => '第七球',
                                'no8' => '第八球',
                                'zh' => '总和',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'sxkl10' => [
                            'name' => '山西快乐10分',
                            'open' => $web_site['klsf'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '第一球',
                                'no2' => '第二球',
                                'no3' => '第三球',
                                'no4' => '第四球',
                                'no5' => '第五球',
                                'no6' => '第六球',
                                'no7' => '第七球',
                                'no8' => '第八球',
                                'zh' => '总和',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'tjkl10' => [
                            'name' => '天津快乐10分',
                            'open' => $web_site['klsf'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '第一球',
                                'no2' => '第二球',
                                'no3' => '第三球',
                                'no4' => '第四球',
                                'no5' => '第五球',
                                'no6' => '第六球',
                                'no7' => '第七球',
                                'no8' => '第八球',
                                'zh' => '总和',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'ynkl10' => [
                            'name' => '云南快乐10分',
                            'open' => $web_site['klsf'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'no1' => '第一球',
                                'no2' => '第二球',
                                'no3' => '第三球',
                                'no4' => '第四球',
                                'no5' => '第五球',
                                'no6' => '第六球',
                                'no7' => '第七球',
                                'no8' => '第八球',
                                'zh' => '总和',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'shssl' => [
                            'name' => '上海时时乐',
                            'open' => $web_site['ssl'] != 1 ? 1 : 0,
                            'panes' => [
                                'lm' => '两面',
                                'bw' => '百位',
                                'sw' => '十位',
                                'gw' => '个位',
                                'kd' => '跨度',
                                'hz' => '和值',
                                'qy' => '区域',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'pl3' => [
                            'name' => '排列三',
                            'open' => $web_site['pl3'] != 1 ? 1 : 0,
                            'hideDate' => 1,
                            'panes' => [
                                'lm' => '两面',
                                'bw' => '百位',
                                'sw' => '十位',
                                'gw' => '个位',
                                'kd' => '跨度',
                                'hz' => '和值',
                                'qy' => '区域',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                            'isPrevious' => 1,
                        ],
                        '3d' => [
                            'name' => '福彩3D',
                            'open' => $web_site['d3'] != 1 ? 1 : 0,
                            'hideDate' => 1,
                            'panes' => [
                                'lm' => '两面',
                                'bw' => '百位',
                                'sw' => '十位',
                                'gw' => '个位',
                                'kd' => '跨度',
                                'hz' => '和值',
                                'qy' => '区域',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                            'isPrevious' => 1,
                        ],
                        'kl8' => [
                            'name' => '北京快乐8',
                            'open' => $web_site['kl8'] != 1 ? 1 : 0,
                            'panes' => [
                                'zx' => '直选',
                                'all' => '整合',
                            ],
                            'class' => 'round',
                            'subClass' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'pcdd' => [
                            'name' => 'PC蛋蛋',
                            'open' => $web_site['pcdd'] != 1 ? 1 : 0,
                            'panes' => [
                                'hz' => '和值',
                                'lm' => '两面',
                                'hh' => '波色/豹子/包三',
                            ],
                            'class' => 'round',
                            'subClass' => 'round',
                            'hasChangLong' => 1,
                            'hasLuZhu' => 1,
                        ],
                        'qxc' => [
                            'name' => '七星彩',
                            'open' => $web_site['qxc'] != 1 ? 1 : 0,
                            'panes' => [
                                'erding' => '二定位',
                                'sanding' => '三定位',
                                'siding' => '四定位',
                                'yiding' => '一定位',
                                'erzi' => '二字现',
                                'sanzi' => '三字现',
                            ],
                            'reset' => ['erding', 'sanding', 'siding', 'yiding', 'erzi', 'sanzi'],
                            'class' => 'round-2',
                            'hideDate' => 1,
                            'isSingle' => 1,
                            'isPrevious' => 1,
                        ],
                        'jslh' => [
                            'name' => '极速六合',
                            'open' => $web_site['jslh'] != 1 ? 1 : 0,
                            'panes' => [
                                'tema' => '特码',
                                'zhengte' => '正特',
                                'zhengma' => '正码',
                                'zhengma6' => '正码1-6',
                                'guoguan' => '过关',
                                'lianma' => '连码',
                                'banbo' => '半波',
                                'yixiao' => '一肖',
                                'weishu' => '尾数',
                                'texiao' => '特肖',
                                'hexiao' => '合肖',
                                'shengxiaolian' => '生肖连',
                                'weishulian' => '尾数连',
                                'quanbuzhong' => '全不中',
                            ],
                            'reset' => ['guoguan', 'lianma', 'hexiao', 'shengxiaolian', 'weishulian', 'quanbuzhong'],
                            'class' => 'round-4',
                        ],
                        'marksix' => [
                            'name' => '六合彩',
                            'open' => 1,
                            'panes' => [
                                'tema' => '特码',
                                'zhengte' => '正特',
                                'zhengma' => '正码',
                                'zhengma6' => '正码1-6',
                                'guoguan' => '过关',
                                'lianma' => '连码',
                                'banbo' => '半波',
                                'yixiao' => '一肖',
                                'weishu' => '尾数',
                                'texiao' => '特肖',
                                'hexiao' => '合肖',
                                'shengxiaolian' => '生肖连',
                                'weishulian' => '尾数连',
                                'quanbuzhong' => '全不中',
                            ],
                            'reset' => ['guoguan', 'lianma', 'hexiao', 'shengxiaolian', 'weishulian', 'quanbuzhong'],
                            'class' => 'round-4',
                            'hideDate' => 1,
                            'isPrevious' => 1,
                        ],
                        'jsk3' => [
                            'name' => '江苏快3',
                            'open' => $web_site['jsk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],
                        'gxk3' => [
                            'name' => '广西快3',
                            'open' => $web_site['gxk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],
                        'ahk3' => [
                            'name' => '安徽快3',
                            'open' => $web_site['ahk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],

                        'shk3' => [
                            'name' => '上海快3',
                            'open' => $web_site['shk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],
                        'hbk3' => [
                            'name' => '湖北快3',
                            'open' => $web_site['hbk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],
                        'hebk3' => [
                            'name' => '河北快3',
                            'open' => $web_site['hebk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],
                        'fjk3' => [
                            'name' => '福建快3',
                            'open' => $web_site['fjk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],
                        'jxk3' => [
                            'name' => '江西快3',
                            'open' => $web_site['jxk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],
                        'nmgk3' => [
                            'name' => '内蒙古快3',
                            'open' => $web_site['nmgk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],
                        'gsk3' => [
                            'name' => '甘肃快3',
                            'open' => $web_site['gsk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],
                        'bjk3' => [
                            'name' => '北京快3',
                            'open' => $web_site['bjk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],
                        'jlk3' => [
                            'name' => '吉林快3',
                            'open' => $web_site['jlk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],
                        'gzk3' => [
                            'name' => '贵州快3',
                            'open' => $web_site['gzk3'] != 1 ? 1 : 0,
                            'panes' => [
                                'bigness' => '三军大小',
                                'weitou' => '围骰、全骰',
                                'points' => '点数',
                                'longcard' => '长牌',
                                'shortcard' => '短牌',
                            ],
                            'class' => 'round',
                            'hasChangLong' => 0,
                            'hasLuZhu' => 0,
                        ],
                    ],
                ];
                break;
            case $_POST['type'] == 'animal': //生肖年
                $MOBILE['output']['status'] = 1;
                $MOBILE['output']['msg'] = [];
                include IN_MOBILE.'../lot/include/class/lunar.class.php';
                $temp = [
                    range(1, 12),
                    [
                        [1, 13, 25, 37, 49],
                        [2, 14, 26, 38],
                        [3, 15, 27, 39],
                        [4, 16, 28, 40],
                        [5, 17, 29, 41],
                        [6, 18, 30, 42],
                        [7, 19, 31, 43],
                        [8, 20, 32, 44],
                        [9, 21, 33, 45],
                        [10, 22, 34, 46],
                        [11, 23, 35, 47],
                        [12, 24, 36, 48],
                    ],
                ];
                $lunar = new Lunar();
                $time = time();
                if (isset($_POST['gameType']) && $_POST['gameType'] == 'marksix') {
                    $stmt = $mydata2_db->query('SELECT `zfbdate` FROM `ka_kithe` WHERE `na`=0 ORDER BY `nn` DESC LIMIT 1');
                    if ($rows = $stmt->fetch()) {
                        $time = strtotime($rows['zfbdate']) - 43200;
                    }
                }
                $time += 43200;
                $lunar_date = $lunar->convertSolarToLunar(date('Y', $time), date('m', $time), date('d', $time));
                foreach ($temp[0] as $key => $val) {
                    $key = fmod($lunar_date[0] - $key + 8, 12);
                    $MOBILE['output']['msg'][$val] = $temp[1][$key];
                }
                break;
            case $_POST['type'] == 'history': //开奖结果
                $_POST['gameType'] = ! isset($_POST['gameType']) ? 'default' : strtolower($_POST['gameType']);
                (isset($_POST['lastId']) && preg_match('/^\d+$/', $_POST['lastId'])) || $_POST['lastId'] = 0;
                (isset($_POST['rows']) && preg_match('/^[1-9]\d*$/', $_POST['rows'])) || $_POST['rows'] = 10;
                (isset($_POST['date']) && preg_match('/^[1-9]\d{3}\-\d{2}\-\d{2}$/',
                        $_POST['date'])) || $_POST['date'] = date('Y-m-d');
                $_POST['rows'] > 100 && $_POST['rows'] = 100;
                switch ($_POST['gameType']) {
                    case 'jssc':
                    case 'jsssc':
                    case 'jslh':
                        $MOBILE['output']['status'] = 1;
                        $MOBILE['output']['msg'] = [];
                        $MOBILE['output']['hasMore'] = false;
                        $MOBILE['output']['lastId'] = 0;
                        $params = [
                            ':type' => strtoupper($_POST['gameType']),
                            ':qtime' => strtotime($_POST['date'].' 00:00:00'),
                            ':etime' => strtotime($_POST['date'].' 23:59:59'),
                        ];
                        if ($_POST['lastId'] > 0) {
                            $params[':id'] = $_POST['lastId'];
                            $sql = [
                                'SELECT COUNT(*) AS `count` FROM `c_auto_data` WHERE `type`=:type AND `id`<:id AND `qishu` BETWEEN :qtime AND :etime AND `status` BETWEEN 0 AND 1',
                                'SELECT `id`, `type`, `opentime`, `value` FROM `c_auto_data` WHERE `type`=:type AND `id`<:id AND `qishu` BETWEEN :qtime AND :etime AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT :limit',
                            ];
                        } else {
                            $sql = [
                                'SELECT COUNT(*) AS `count` FROM `c_auto_data` WHERE `type`=:type AND `qishu` BETWEEN :qtime AND :etime AND `status` BETWEEN 0 AND 1',
                                'SELECT `id`, `type`, `opentime`, `value` FROM `c_auto_data` WHERE `type`=:type AND `qishu` BETWEEN :qtime AND :etime AND `status` BETWEEN 0 AND 1 ORDER BY `qishu` DESC LIMIT :limit',
                            ];
                        }
                        $stmt = $mydata1_db->prepare($sql[0]);
                        $stmt->execute($params);
                        $rows = $stmt->fetch();
                        $MOBILE['output']['hasMore'] = $rows['count'] > $_POST['rows'];
                        if ($rows['count'] > 0) {
                            $params[':limit'] = $_POST['rows'];
                            $stmt = $mydata1_db->prepare($sql[1]);
                            $stmt->execute($params);
                            while ($rows = $stmt->fetch()) {
                                $rows['value'] = unserialize($rows['value']);
                                $rows['value']['marksix'] = $rows['type'] == 'JSLH' ? 1 : 0;
                                if ($rows['value']['marksix']) {
                                    $rows['value']['info'] = $rows['value']['animal'];
                                    foreach ($rows['value']['opencode'] as $key => $val) {
                                        $rows['value']['opencode'][$key] = [
                                            'number' => substr('00'.$val, -2),
                                            'color' => $rows['value']['color'][$key],
                                        ];
                                    }
                                }
                                $MOBILE['output']['msg'][] = [
                                    'issue' => $rows['value']['qishu'],
                                    'opentime' => date('Y-m-d H:i:s', $rows['opentime']),
                                    'opencode' => $rows['value']['opencode'],
                                    'openinfo' => $rows['value']['info'],
                                    'marksix' => $rows['value']['marksix'],
                                ];
                                $MOBILE['output']['lastId'] = $rows['id'];
                            }
                        }
                        break;

                    case 'pk10':
                    case 'cqssc':
                    case 'xjssc':
                    case 'tjssc':
                    case 'sfssc':
                    case 'xyft':
                    case 'jsft':
                    case 'gdkl10':
                    case 'tjkl10':
                    case 'hnkl10':
                    case 'cqkl10':
                    case 'sxkl10':
                    case 'ynkl10':
                    case 'ffkl10':
                    case 'sfkl10':
                    case 'gdchoose5':
                    case 'sdchoose5':
                    case 'fjchoose5':
                    case 'bjchoose5':
                    case 'ahchoose5':
                    case 'yfchoose5':
                    case 'sfchoose5':
                        $params = [
                            ':qtime' => $_POST['date'].' 00:00:00',
                            ':etime' => $_POST['date'].' 23:59:59',
                        ];
                        switch ($_POST['gameType']) {
                            case 'pk10':
                            case 'xyft':
                            case 'jsft':
                                switch ($_POST['gameType']) {
                                    case 'jsft':
                                        $tables = 'c_auto_jsft';
                                        break;

                                    case 'xyft':
                                        $tables = 'c_auto_8';
                                        $params = [
                                            ':qtime' => $_POST['date'].' 13:00:00',
                                            ':etime' => date('Y-m-d', strtotime($_POST['date']) + 86400).' 12:59:59',
                                        ];
                                        break;

                                    default:
                                        $tables = 'c_auto_4';
                                        break;
                                }
                                $getInfo = function ($opencode) {
                                    $return = [];
                                    $return[] = $opencode[0] + $opencode[1];
                                    $return[] = $return[0] == 11 ? '和' : ($return[0] > 11 ? '大' : '小');
                                    $return[] = $return[0] == 11 ? '和' : (fmod($return[0], 2) == 0 ? '双' : '单');
                                    $return[] = $opencode[0] > $opencode[9] ? '龙' : '虎';
                                    $return[] = $opencode[1] > $opencode[8] ? '龙' : '虎';
                                    $return[] = $opencode[2] > $opencode[7] ? '龙' : '虎';
                                    $return[] = $opencode[3] > $opencode[6] ? '龙' : '虎';
                                    $return[] = $opencode[4] > $opencode[5] ? '龙' : '虎';

                                    return $return;
                                };
                                break;
                            case 'cqssc':
                            case 'xjssc':
                            case 'sfssc':
                            case 'tjssc':
                                switch ($_POST['gameType']) {
                                    case 'xjssc':
                                        $tables = 'c_auto_xjssc';
                                        break;

                                    case 'sfssc':
                                        $tables = 'c_auto_sfssc';
                                        break;

                                    case 'tjssc':
                                        $tables = 'c_auto_tjssc';
                                        break;

                                    default:
                                        $tables = 'c_auto_2';
                                        break;
                                }
                                $getInfo = function ($opencode) {
                                    $r = function ($n) {
                                        $s = function ($a, $p) {
                                            $i = 0;
                                            foreach ($a as $k => $v) {
                                                if (in_array((($v + 10) - 1) % 10, $a) || in_array(($v + 1) % 10, $a)) {
                                                    $i++;
                                                }
                                            }

                                            return $p <= $i;
                                        };
                                        sort($n);
                                        $a = implode('', $n);
                                        if ($n[0] == $n[1] && $n[0] == $n[2] && $n[1] == $n[2]) {
                                            return '豹子';
                                        } else {
                                            if ($n[0] == $n[1] || $n[0] == $n[2] || $n[1] == $n[2]) {
                                                return '对子';
                                            } else {
                                                if ($a == '019' || $a == '089' || $s($n, 3)) {
                                                    return '顺子';
                                                } else {
                                                    if (preg_match('/0\d9/', $a) || $s($n, 2)) {
                                                        return '半顺';
                                                    } else {
                                                        return '杂六';
                                                    }
                                                }
                                            }
                                        }
                                    };
                                    $return = [];
                                    $return[] = array_sum($opencode);
                                    $return[] = $return[0] > 22 ? '大' : '小';
                                    $return[] = fmod($return[0], 2) == 0 ? '双' : '单';
                                    $return[] = $opencode[0] == $opencode[4] ? '和' : ($opencode[0] > $opencode[4] ? '龙' : '虎');
                                    $return[] = $r([$opencode[0], $opencode[1], $opencode[2]]);
                                    $return[] = $r([$opencode[1], $opencode[2], $opencode[3]]);
                                    $return[] = $r([$opencode[2], $opencode[3], $opencode[4]]);

                                    return $return;
                                };
                                break;

                            case 'gdkl10':
                            case 'cqkl10':
                            case 'tjkl10':
                            case 'hnkl10':
                            case 'sxkl10':
                            case 'ynkl10':
                            case 'ffkl10':
                            case 'sfkl10':
                                if ($_POST['gameType'] == 'gdkl10') {
                                    $tables = 'c_auto_3';
                                } else {
                                    $tables = 'c_auto_klsf';
                                    $params[':name'] = $_POST['gameType'];
                                }
                                $getInfo = function ($opencode) {
                                    $return = [];
                                    $return[] = array_sum($opencode);
                                    $return[] = $return[0] == 84 ? '和' : ($return[0] > 84 ? '大' : '小');
                                    $return[] = fmod($return[0], 2) == 0 ? '双' : '单';
                                    $return[] = $opencode[0] > $opencode[7] ? '龙' : '虎';
                                    $return[] = $opencode[1] > $opencode[6] ? '龙' : '虎';
                                    $return[] = $opencode[2] > $opencode[5] ? '龙' : '虎';
                                    $return[] = $opencode[3] > $opencode[4] ? '龙' : '虎';

                                    return $return;
                                };
                                break;

                            case 'gdchoose5':
                            case 'sdchoose5':
                            case 'fjchoose5':
                            case 'bjchoose5':
                            case 'ahchoose5':
                            case 'yfchoose5':
                            case 'sfchoose5':
                                $tables = 'c_auto_choose5';
                                $params[':name'] = $_POST['gameType'];
                                $getInfo = [];
                                break;
                        }
                        $MOBILE['output']['status'] = 1;
                        $MOBILE['output']['msg'] = [];
                        $MOBILE['output']['hasMore'] = false;
                        $MOBILE['output']['lastId'] = 0;

                        if ($_POST['lastId'] > 0) {
                            $params[':id'] = $_POST['lastId'];
                            if (in_array($_POST['gameType'], [
                                'cqkl10',
                                'tjkl10',
                                'hnkl10',
                                'sxkl10',
                                'ynkl10',
                                'ffkl10',
                                'sfkl10',
                                'gdchoose5',
                                'sdchoose5',
                                'fjchoose5',
                                'ahchoose5',
                                'bjchoose5',
                                'yfchoose5',
                                'sfchoose5',
                            ])) {
                                $sql = [
                                    "SELECT COUNT(*) AS `count` FROM `$tables` WHERE `id`<:id AND `datetime` BETWEEN :qtime AND :etime and `name`=:name",
                                    "SELECT * FROM `$tables` WHERE `id`<:id AND `datetime` BETWEEN :qtime AND :etime and `name`=:name ORDER BY `qishu` DESC LIMIT :limit",
                                ];
                            } else {
                                $sql = [
                                    "SELECT COUNT(*) AS `count` FROM `$tables` WHERE `id`<:id AND `datetime` BETWEEN :qtime AND :etime",
                                    "SELECT * FROM `$tables` WHERE `id`<:id AND `datetime` BETWEEN :qtime AND :etime ORDER BY `qishu` DESC LIMIT :limit",
                                ];
                            }
                        } else {
                            if (in_array($_POST['gameType'], [
                                'cqkl10',
                                'tjkl10',
                                'hnkl10',
                                'sxkl10',
                                'ynkl10',
                                'ffkl10',
                                'sfkl10',
                                'gdchoose5',
                                'sdchoose5',
                                'fjchoose5',
                                'ahchoose5',
                                'bjchoose5',
                                'yfchoose5',
                                'sfchoose5',
                            ])) {
                                $sql = [
                                    "SELECT COUNT(*) AS `count` FROM `$tables` WHERE `datetime` BETWEEN :qtime AND :etime and `name`=:name",
                                    "SELECT * FROM `$tables` WHERE  `datetime` BETWEEN :qtime AND :etime and `name`=:name ORDER BY `qishu` DESC LIMIT :limit",
                                ];
                            } else {
                                $sql = [
                                    "SELECT COUNT(*) AS `count` FROM `$tables` WHERE `datetime` BETWEEN :qtime AND :etime",
                                    "SELECT * FROM `$tables` WHERE  `datetime` BETWEEN :qtime AND :etime ORDER BY `qishu` DESC LIMIT :limit",
                                ];
                            }
                        }
                        $stmt = $mydata1_db->prepare($sql[0]);
                        $stmt->execute($params);
                        $rows = $stmt->fetch();
                        $MOBILE['output']['hasMore'] = $rows['count'] > $_POST['rows'];
                        if ($rows['count'] > 0) {
                            $params[':limit'] = $_POST['rows'];
                            $stmt = $mydata1_db->prepare($sql[1]);
                            $stmt->execute($params);
                            while ($rows = $stmt->fetch()) {
                                $rows['opencode'] = [];
                                foreach ($rows as $key => $val) {
                                    substr($key, 0, 5) == 'ball_' && $rows['opencode'][] = $val;
                                }
                                $MOBILE['output']['msg'][] = [
                                    'issue' => $rows['qishu'],
                                    'opentime' => $rows['datetime'],
                                    'opencode' => $rows['opencode'],
                                    'openinfo' => $getInfo($rows['opencode']),
                                ];
                                $MOBILE['output']['lastId'] = $rows['id'];
                            }
                        }
                        break;

                    case 'shssl':
                        $MOBILE['output']['status'] = 1;
                        $MOBILE['output']['msg'] = [];
                        $MOBILE['output']['hasMore'] = false;
                        $MOBILE['output']['lastId'] = 0;
                        $params = [
                            ':qtime' => $_POST['date'].' 00:00:00',
                            ':etime' => $_POST['date'].' 23:59:59',
                        ];
                        if ($_POST['lastId'] > 0) {
                            $params[':id'] = $_POST['lastId'];
                            $sql = [
                                'SELECT COUNT(*) AS `count` FROM `lottery_k_ssl` WHERE `ok`=1 AND `id`<:id AND `addtime` BETWEEN :qtime AND :etime',
                                'SELECT * FROM `lottery_k_ssl` WHERE `ok`=1 AND `id`<:id AND `addtime` BETWEEN :qtime AND :etime ORDER BY `qihao` DESC LIMIT :limit',
                            ];
                        } else {
                            $sql = [
                                'SELECT COUNT(*) AS `count` FROM `lottery_k_ssl` WHERE `ok`=1 AND `addtime` BETWEEN :qtime AND :etime',
                                'SELECT * FROM `lottery_k_ssl` WHERE `ok`=1 AND `addtime` BETWEEN :qtime AND :etime ORDER BY `qihao` DESC LIMIT :limit',
                            ];
                        }
                        $stmt = $mydata1_db->prepare($sql[0]);
                        $stmt->execute($params);
                        $rows = $stmt->fetch();
                        $MOBILE['output']['hasMore'] = $rows['count'] > $_POST['rows'];
                        if ($rows['count'] > 0) {
                            $params[':limit'] = $_POST['rows'];
                            $stmt = $mydata1_db->prepare($sql[1]);
                            $stmt->execute($params);
                            while ($rows = $stmt->fetch()) {
                                $rows['opencode'] = $rows['openinfo'] = [];
                                foreach ($rows as $key => $val) {
                                    substr($key, 0, 2) == 'hm' && $rows['opencode'][] = $val;
                                }
                                $rows['openinfo'][] = array_sum($rows['opencode']);
                                $rows['openinfo'][] = $rows['openinfo'][0] > 14 ? '大' : '小';
                                $rows['openinfo'][] = fmod($rows['openinfo'][0], 2) == 0 ? '双' : '单';
                                $MOBILE['output']['msg'][] = [
                                    'issue' => $rows['qihao'],
                                    'opentime' => $rows['addtime'],
                                    'opencode' => $rows['opencode'],
                                    'openinfo' => $rows['openinfo'],
                                ];
                                $MOBILE['output']['lastId'] = $rows['id'];
                            }
                        }
                        break;

                    case 'pl3':
                    case '3d':
                        $tables = $_POST['gameType'] == 'pl3' ? 'lottery_k_pl3' : 'lottery_k_3d';
                        $MOBILE['output']['status'] = 1;
                        $MOBILE['output']['msg'] = [];
                        $MOBILE['output']['hasMore'] = false;
                        $MOBILE['output']['lastId'] = 0;
                        $params = [];
                        if ($_POST['lastId'] > 0) {
                            $params[':id'] = $_POST['lastId'];
                            $sql = [
                                "SELECT COUNT(*) AS `count` FROM `$tables` WHERE `ok`=1 AND `id`<:id",
                                "SELECT * FROM `$tables` WHERE `ok`=1 AND `id`<:id ORDER BY `qihao` DESC LIMIT :limit",
                            ];
                        } else {
                            $sql = [
                                "SELECT COUNT(*) AS `count` FROM `$tables`WHERE `ok`=1",
                                "SELECT * FROM `$tables`WHERE `ok`=1 ORDER BY `qihao` DESC LIMIT :limit",
                            ];
                        }
                        $stmt = $mydata1_db->prepare($sql[0]);
                        $stmt->execute($params);
                        $rows = $stmt->fetch();
                        $MOBILE['output']['hasMore'] = $rows['count'] > $_POST['rows'];
                        if ($rows['count'] > 0) {
                            $params[':limit'] = $_POST['rows'];
                            $stmt = $mydata1_db->prepare($sql[1]);
                            $stmt->execute($params);
                            while ($rows = $stmt->fetch()) {
                                $rows['opencode'] = $rows['openinfo'] = [];
                                foreach ($rows as $key => $val) {
                                    substr($key, 0, 2) == 'hm' && $rows['opencode'][] = $val;
                                }
                                $rows['openinfo'][] = array_sum($rows['opencode']);
                                $rows['openinfo'][] = $rows['openinfo'][0] > 14 ? '大' : '小';
                                $rows['openinfo'][] = fmod($rows['openinfo'][0], 2) == 0 ? '双' : '单';
                                $MOBILE['output']['msg'][] = [
                                    'issue' => $rows['qihao'],
                                    'opentime' => $rows['fengpan'],
                                    'opencode' => $rows['opencode'],
                                    'openinfo' => $rows['openinfo'],
                                ];
                                $MOBILE['output']['lastId'] = $rows['id'];
                            }
                        }
                        break;

                    case 'kl8':
                        $MOBILE['output']['status'] = 1;
                        $MOBILE['output']['msg'] = [];
                        $MOBILE['output']['hasMore'] = false;
                        $MOBILE['output']['lastId'] = 0;
                        $params = [
                            ':qtime' => $_POST['date'].' 00:00:00',
                            ':etime' => $_POST['date'].' 23:59:59',
                        ];
                        if ($_POST['lastId'] > 0) {
                            $params[':id'] = $_POST['lastId'];
                            $sql = [
                                'SELECT COUNT(*) AS `count` FROM `lottery_k_kl8` WHERE `ok`=1 AND `id`<:id AND `fengpan` BETWEEN :qtime AND :etime',
                                'SELECT * FROM `lottery_k_kl8` WHERE `ok`=1 AND `id`<:id AND `fengpan` BETWEEN :qtime AND :etime ORDER BY `qihao` DESC LIMIT :limit',
                            ];
                        } else {
                            $sql = [
                                'SELECT COUNT(*) AS `count` FROM `lottery_k_kl8` WHERE `ok`=1 AND `fengpan` BETWEEN :qtime AND :etime',
                                'SELECT * FROM `lottery_k_kl8` WHERE `ok`=1 AND `fengpan` BETWEEN :qtime AND :etime ORDER BY `qihao` DESC LIMIT :limit',
                            ];
                        }
                        $stmt = $mydata1_db->prepare($sql[0]);
                        $stmt->execute($params);
                        $rows = $stmt->fetch();
                        $MOBILE['output']['hasMore'] = $rows['count'] > $_POST['rows'];
                        if ($rows['count'] > 0) {
                            $params[':limit'] = $_POST['rows'];
                            $stmt = $mydata1_db->prepare($sql[1]);
                            $stmt->execute($params);
                            while ($rows = $stmt->fetch()) {
                                $rows['opencode'] = $rows['openinfo'] = [];
                                foreach ($rows as $key => $val) {
                                    substr($key, 0, 2) == 'hm' && $rows[substr($key,
                                        2) > 10 ? 'openinfo' : 'opencode'][] = substr('00'.$val, -2);
                                }
                                $MOBILE['output']['msg'][] = [
                                    'issue' => $rows['qihao'],
                                    'opentime' => $rows['fengpan'],
                                    'opencode' => $rows['opencode'],
                                    'openinfo' => $rows['openinfo'],
                                ];
                                $MOBILE['output']['lastId'] = $rows['id'];
                            }
                        }
                        break;

                    case 'pcdd':
                    case 'ffpcdd':
                        $MOBILE['output']['status'] = 1;
                        $MOBILE['output']['msg'] = [];
                        $MOBILE['output']['hasMore'] = false;
                        $MOBILE['output']['lastId'] = 0;
                        $params = [
                            ':qtime' => $_POST['date'].' 00:00:00',
                            ':etime' => $_POST['date'].' 23:59:59',
                            ':name' => $_POST['gameType'],
                        ];

                        if ($_POST['lastId'] > 0) {
                            $params[':id'] = $_POST['lastId'];
                            $sql = [
                                'SELECT COUNT(*) AS `count` FROM `lottery_k_pcdd` WHERE `ok`=1 AND `id`<:id AND name=:name AND `fengpan` BETWEEN :qtime AND :etime',
                                'SELECT * FROM `lottery_k_pcdd` WHERE `ok`=1 AND `id`<:id AND name=:name AND `fengpan` BETWEEN :qtime AND :etime ORDER BY `qihao` DESC LIMIT :limit',
                            ];
                        } else {
                            $sql = [
                                'SELECT COUNT(*) AS `count` FROM `lottery_k_pcdd` WHERE `ok`=1 AND name=:name AND `fengpan` BETWEEN :qtime AND :etime',
                                'SELECT * FROM `lottery_k_pcdd` WHERE `ok`=1 AND name=:name AND `fengpan` BETWEEN :qtime AND :etime ORDER BY `qihao` DESC LIMIT :limit',
                            ];
                        }
                        $stmt = $mydata1_db->prepare($sql[0]);
                        $stmt->execute($params);
                        $rows = $stmt->fetch();
                        $MOBILE['output']['hasMore'] = $rows['count'] > $_POST['rows'];
                        if ($rows['count'] > 0) {
                            $params[':limit'] = $_POST['rows'];
                            $stmt = $mydata1_db->prepare($sql[1]);
                            $stmt->execute($params);
                            while ($rows = $stmt->fetch()) {
                                $rows['opencode'] = $rows['openinfo'] = [];
                                foreach ($rows as $key => $val) {
                                    substr($key, 0, 2) == 'hm' && $rows[substr($key,
                                        2) > 3 ? 'openinfo' : 'opencode'][] = substr('00'.$val, -2);
                                }
                                $MOBILE['output']['msg'][] = [
                                    'issue' => $rows['qihao'],
                                    'opentime' => $rows['fengpan'],
                                    'opencode' => $rows['opencode'],
                                    'openinfo' => $rows['openinfo'],
                                ];
                                $MOBILE['output']['lastId'] = $rows['id'];
                            }
                        }
                        break;

                    case 'ffqxc':
                    case 'wfqxc':
                    case 'qxc':
                        $MOBILE['output']['status'] = 1;
                        $MOBILE['output']['msg'] = [];
                        $MOBILE['output']['hasMore'] = false;
                        $MOBILE['output']['lastId'] = 0;
                        if ($_POST['gameType'] == 'qxc') {
                            $params = [];
                            if ($_POST['lastId'] > 0) {
                                $params[':id'] = $_POST['lastId'];
                                $sql = [
                                    'SELECT COUNT(*) AS `count` FROM `lottery_k_qxc` WHERE `id`<:id AND `status`=1',
                                    'SELECT `id`, `kaijiang`, `value` FROM `lottery_k_qxc` WHERE `id`<:id AND `status`=1 ORDER BY `qishu` DESC LIMIT :limit',
                                ];
                            } else {
                                $sql = [
                                    'SELECT COUNT(*) AS `count` FROM `lottery_k_qxc` WHERE `status`=1',
                                    'SELECT `id`, `qishu`, `kaijiang`, `value` FROM `lottery_k_qxc` WHERE `status`=1 ORDER BY `qishu` DESC LIMIT :limit',
                                ];
                            }
                        } else {
                            $params = [
                                ':qtime' => $_POST['date'].' 00:00:00',
                                ':etime' => $_POST['date'].' 23:59:59',
                                ':lottery_name' => $_POST['gameType'],
                            ];
                            if ($_POST['lastId'] > 0) {
                                $params[':id'] = $_POST['lastId'];
                                $sql = [
                                    'SELECT COUNT(*) AS `count` FROM `lottery_k_qxc` WHERE `id`<:id AND `status`=1 and lottery_name=:lottery_name and `fengpan` BETWEEN :qtime AND :etime',
                                    'SELECT `id`, `kaijiang`, `value` FROM `lottery_k_qxc` WHERE `id`<:id AND `status`=1 and lottery_name=:lottery_name and `fengpan` BETWEEN :qtime AND :etime ORDER BY `qishu` DESC LIMIT :limit',
                                ];
                            } else {
                                $sql = [
                                    'SELECT COUNT(*) AS `count` FROM `lottery_k_qxc` WHERE `status`=1 and lottery_name=:lottery_name and `fengpan` BETWEEN :qtime AND :etime',
                                    'SELECT `id`, `qishu`, `kaijiang`, `value` FROM `lottery_k_qxc` WHERE `status`=1 and lottery_name=:lottery_name and `fengpan` BETWEEN :qtime AND :etime ORDER BY `qishu` DESC LIMIT :limit',
                                ];
                            }
                        }
                        $stmt = $mydata1_db->prepare($sql[0]);
                        $stmt->execute($params);
                        $rows = $stmt->fetch();
                        $MOBILE['output']['hasMore'] = $rows['count'] > $_POST['rows'];
                        if ($rows['count'] > 0) {
                            $params[':limit'] = $_POST['rows'];
                            $stmt = $mydata1_db->prepare($sql[1]);
                            $stmt->execute($params);
                            while ($rows = $stmt->fetch()) {
                                $rows['value'] = unserialize($rows['value']);
                                $MOBILE['output']['msg'][] = [
                                    'issue' => $rows['qishu'],
                                    'opentime' => date('Y-m-d H:i:s', $rows['kaijiang']),
                                    'opencode' => array_splice($rows['value'], 0, 4),
                                    'openinfo' => $rows['value'],
                                ];
                                $MOBILE['output']['lastId'] = $rows['id'];
                            }
                        }
                        break;
                    case 'marksix':
                        $color = [
                            1 => 'red',
                            2 => 'red',
                            3 => 'blue',
                            4 => 'blue',
                            5 => 'green',
                            6 => 'green',
                            7 => 'red',
                            8 => 'red',
                            9 => 'blue',
                            10 => 'blue',
                            11 => 'green',
                            12 => 'red',
                            13 => 'red',
                            14 => 'blue',
                            15 => 'blue',
                            16 => 'green',
                            17 => 'green',
                            18 => 'red',
                            19 => 'red',
                            20 => 'blue',
                            21 => 'green',
                            22 => 'green',
                            23 => 'red',
                            24 => 'red',
                            25 => 'blue',
                            26 => 'blue',
                            27 => 'green',
                            28 => 'green',
                            29 => 'red',
                            30 => 'red',
                            31 => 'blue',
                            32 => 'green',
                            33 => 'green',
                            34 => 'red',
                            35 => 'red',
                            36 => 'blue',
                            37 => 'blue',
                            38 => 'green',
                            39 => 'green',
                            40 => 'red',
                            41 => 'blue',
                            42 => 'blue',
                            43 => 'green',
                            44 => 'green',
                            45 => 'red',
                            46 => 'red',
                            47 => 'blue',
                            48 => 'blue',
                            49 => 'green',
                        ];
                        $MOBILE['output']['status'] = 1;
                        $MOBILE['output']['msg'] = [];
                        $MOBILE['output']['hasMore'] = false;
                        $MOBILE['output']['lastId'] = 0;
                        $params = [];
                        if ($_POST['lastId'] > 0) {
                            $params[':id'] = $_POST['lastId'];
                            $sql = [
                                'SELECT COUNT(*) AS `count` FROM `mydata2_db`.`ka_kithe` WHERE `id`<:id AND `na`>0',
                                'SELECT * FROM `mydata2_db`.`ka_kithe` WHERE `id`<:id AND `na`>0 ORDER BY `nn` DESC LIMIT :limit',
                            ];
                        } else {
                            $sql = [
                                'SELECT COUNT(*) AS `count` FROM `mydata2_db`.`ka_kithe` WHERE `na`>0',
                                'SELECT * FROM `mydata2_db`.`ka_kithe` WHERE `na`>0 ORDER BY `nn` DESC LIMIT :limit',
                            ];
                        }
                        $stmt = $mydata1_db->prepare($sql[0]);
                        $stmt->execute($params);
                        $rows = $stmt->fetch();
                        $MOBILE['output']['hasMore'] = $rows['count'] > $_POST['rows'];
                        if ($rows['count'] > 0) {
                            $params[':limit'] = $_POST['rows'];
                            $stmt = $mydata1_db->prepare($sql[1]);
                            $stmt->execute($params);
                            while ($rows = $stmt->fetch()) {
                                $rows['opencode'] = $rows['openinfo'] = [];
                                foreach (['n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'na'] as $key) {
                                    $rows['opencode'][] = [
                                        'number' => substr('00'.$rows[$key], -2),
                                        'color' => $color[$rows[$key]],
                                    ];
                                }
                                foreach (['x1', 'x2', 'x3', 'x4', 'x5', 'x6', 'sx'] as $key) {
                                    $rows['openinfo'][] = $rows[$key];
                                }
                                $MOBILE['output']['msg'][] = [
                                    'issue' => $rows['nn'],
                                    'opentime' => $rows['nd'],
                                    'opencode' => $rows['opencode'],
                                    'openinfo' => $rows['openinfo'],
                                    'marksix' => 1,
                                ];
                                $MOBILE['output']['lastId'] = $rows['id'];
                            }
                        }
                        break;
                    case 'hebk3':
                    case 'jsk3':
                    case 'fjk3':
                    case 'bjk3':
                    case 'gxk3':
                    case 'gsk3':
                    case 'qhk3':
                    case 'jlk3':
                    case 'gzk3':
                    case 'shk3':
                    case 'hbk3':
                    case 'hnk3':
                    case 'ahk3':
                    case 'nmgk3':
                    case 'jxk3':
                    case 'ffk3':
                    case 'sfk3':
                        $MOBILE['output']['status'] = 1;
                        $MOBILE['output']['msg'] = [];
                        $MOBILE['output']['hasMore'] = false;
                        $MOBILE['output']['lastId'] = 0;
                        $params = [
                            ':qtime' => $_POST['date'].' 00:00:00',
                            ':etime' => $_POST['date'].' 23:59:59',
                            ':name' => $_POST['gameType'],
                        ];
                        if ($_POST['lastId'] > 0) {
                            $params[':id'] = $_POST['lastId'];
                            $sql = [
                                "SELECT COUNT(*) AS `count` FROM `lottery_k3` WHERE `ok`=1 AND `id`<:id and `name`=:name and `fengpan` BETWEEN :qtime AND :etime",
                                "SELECT * FROM `lottery_k3` WHERE `ok`=1 AND `id`<:id and `name`=:name and `fengpan` BETWEEN :qtime AND :etime ORDER BY `qihao` DESC LIMIT :limit",
                            ];
                        } else {
                            $sql = [
                                "SELECT COUNT(*) AS `count` FROM `lottery_k3`WHERE `ok`=1 and `name`=:name and `fengpan` BETWEEN :qtime AND :etime",
                                "SELECT * FROM `lottery_k3`WHERE `ok`=1 and `name`=:name and `fengpan` BETWEEN :qtime AND :etime ORDER BY `qihao` DESC LIMIT :limit",
                            ];
                        }
                        $stmt = $mydata1_db->prepare($sql[0]);
                        $stmt->execute($params);
                        $rows = $stmt->fetch();
                        $MOBILE['output']['hasMore'] = $rows['count'] > $_POST['rows'];
                        if ($rows['count'] > 0) {
                            $params[':limit'] = $_POST['rows'];
                            $stmt = $mydata1_db->prepare($sql[1]);
                            $stmt->execute($params);
                            while ($rows = $stmt->fetch()) {
                                $rows['opencode'] = $rows['openinfo'] = [];
                                $opencode = explode(',', $rows['balls']);
                                $rows['openinfo'][] = array_sum($opencode);
                                $rows['openinfo'][] = $rows['openinfo'][0] > 9 ? '大' : '小';
                                $rows['openinfo'][] = fmod($rows['openinfo'][0], 2) == 0 ? '双' : '单';
                                $MOBILE['output']['msg'][] = [
                                    'issue' => $rows['qihao'],
                                    'opentime' => $rows['fengpan'],
                                    'opencode' => $opencode,
                                    'openinfo' => $rows['openinfo'],
                                ];
                                $MOBILE['output']['lastId'] = $rows['id'];
                            }
                        }
                        break;
                }
                break;
        }
        break;
    case 'activity': //优惠活动
        $MOBILE['output']['status'] = 1;
        $MOBILE['output']['msg'] = [];
        $MOBILE['output']['list'] = [];
        $hotSort = [];
        $hotList = [];
        $stmt = $mydata1_db->prepare('SELECT * FROM `webinfo` WHERE `code`=:code');
        $stmt->execute([':code' => 'promotions-mobile']);
        while ($rows = $stmt->fetch()) {
            $rows['content'] = unserialize($rows['content']);
            $hotList[$rows['id']] = [
                'title' => $rows['title'],
                'image' => stripcslashes($rows['content'][0]),
                'content' => stripcslashes($rows['content'][1]),
            ];
            $sortKey = intval($rows['content'][2]);
            ! isset($hotSort[$sortKey]) && $hotSort[$sortKey] = [];
            $hotSort[$sortKey][] = $rows['id'];
        }
        krsort($hotSort);
        foreach ($hotSort as $key) {
            rsort($key);
            foreach ($key as $val) {
//                preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', $hotList[$val]['image'], $matches);
                $MOBILE['output']['msg'][] = [
                    'id' => $val,
                    'title' => $hotList[$val]['title'],
//                    'img' => $matches[2],
                    'img' => $hotList[$val]['image'],
                    'content' => $hotList[$val]['content'],
                ];
                $MOBILE['output']['list'][] = 'j'.$val;
            }
        }
        break;
}

function userInfo($rows = [])
{
    include IN_MOBILE.'../member/function.php';
    $sn = session_name();
    $return = [
        'token' => $_COOKIE[$sn],
        'testFlag' => 0,
        'serverTime' => date('Y-m-d H:i:s'),
        'msg' => 'success',
        'userId' => 0,
        'username' => '',
        'money' => 0,
        'email' => '',
        'hasFundPwd' => 0,
        'fullName' => '',
        'agent' => 0,
        'regTime' => '',
        'loginTime' => '',
        'mobile' => '保密',
    ];
    if (is_array($rows) && ! empty($rows)) {
        $return['userId'] = $rows['uid'];
        $return['username'] = $rows['username'];
        $return['money'] = $rows['money'];
        $return['email'] = cutTitle($rows['email']);
        $return['fullName'] = $rows['pay_name'];
        $return['agent'] = $rows['is_daili'] == 1 ? 1 : 0;
        $return['regTime'] = $rows['reg_date'];
        $return['loginTime'] = $rows['login_time'];
        $return['mobile'] = cutTitle($rows['mobile'], 8);
        $return['hasFundPwd'] = ! empty($rows['qk_pwd']);
    }

    return $return;
}

function authCode($string, $operation = 'DECODE', $key = 'default', $expiry = 0)
{
    $ckey_length = 4;

    $key == 'default' && session_name() && $key = session_name();
    $key = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()),
        -$ckey_length)) : '';

    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d',
            $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = [];
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10,
                16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

function getAgent($username = '')
{
    $return = ['uid' => 0, 'username' => null];
    if (! empty($username)) {
        $stmt = $GLOBALS['mydata1_db']->prepare('SELECT `uid`, `username` FROM `k_user` WHERE `username`=:username LIMIT 1');
        $stmt->execute([':username' => $username]);
        if ($rows = $stmt->fetch()) {
            $return['uid'] = $rows['uid'];
            $return['username'] = $rows['username'];
        }
    }
    if (! $return['uid']) {
        $hostname = '.'.strtolower(trim($_SERVER['HTTP_HOST']));
        $stmt = $GLOBALS['mydata1_db']->prepare('SELECT * FROM `dlurl` WHERE `isok`=1');
        $stmt->execute();
        while ($rows = $stmt->fetch()) {
            $rows['url'] = '.'.strtolower(trim($rows['url']));
            if (substr($hostname, -1 * strlen($rows['url'])) == $rows['url']) {
                $stmt1 = $GLOBALS['mydata1_db']->prepare('SELECT `uid`, `username` FROM `k_user` WHERE `username`=:username LIMIT 1');
                $stmt1->execute([':username' => $rows['dl_username']]);
                if ($user = $stmt1->fetch()) {
                    $return['uid'] = $user['uid'];
                    $return['username'] = $user['username'];
                    break;
                }
            }
        }
    }

    return $return;
}

echo json_encode($MOBILE['output'], JSON_UNESCAPED_UNICODE);
