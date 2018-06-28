<?php

class user
{
    static public function login($username, $passwrod)
    {
        try {
            $C_Patch = $_SERVER['DOCUMENT_ROOT'];
            include_once $C_Patch . '/common/commonfun.php';
            $client_ip = get_client_ip();
            global $mydata1_db;
            $params = array(':username' => $username, ':password' => md5($passwrod));
            $stmt = $mydata1_db->prepare('select uid,is_daili,gid,is_delete,is_stop,reg_date,password,username from k_user where username=:username and password=:password limit 1');
            $stmt->execute($params);
            $t = $stmt->fetch();
            $t_uid = $t['uid'];
            $t_is_daili = $t['is_daili'];
            $t_gid = $t['gid'];
            $t_is_delete = $t['is_delete'];
            $t_is_stop = $t['is_stop'];
            $t_reg_date = $t['reg_date'];
            $t_password = $t['password'];
            $t_username = $t['username'];
            if (($t_password == md5($passwrod)) && ($t_username == $username)) {
                if ($t_is_delete == 1) {
                    echo 3;
                    exit();
                }

                if ($t_is_stop == 1) {
                    echo 3;
                    exit();
                }
                $t_uid = intval($t_uid);
                include 'cache/conf.php';
                $params = array(':login_ip' => $client_ip, ':username' => $username);
                $stmt = $mydata1_db->prepare('update k_user set login_time=now(),login_ip=:login_ip,lognum=lognum+1 where username=:username');
                $stmt->execute($params);
                $time = time();
                $date = date('YmdHis');
                $rs = $mydata1_db->query('select `uid` from `k_user_login` where uid=\'' . $t_uid . '\' limit 1');
                $login_id = $time . '_' . $t_uid . '_' . $username;

                $type = self::isMobile();
                if ($row = $rs->fetch()) {
                    $params = array(':login_id' => $login_id, ':login_time' => $time, ':www' => $_SERVER['HTTP_HOST'], ':uid' => $t_uid, ':type' => $type);
                    $stmt = $mydata1_db->prepare('update `k_user_login` set `login_id`=:login_id,`login_time`=:login_time,`is_login`=1,www=:www,`type`=:type WHERE `uid`=:uid');
                    $stmt->execute($params);
                } else {
                    $params = array(':login_id' => $login_id, ':uid' => $t_uid, ':login_time' => $time, ':www' => $_SERVER['HTTP_HOST']);
                    $stmt = $mydata1_db->prepare('insert into `k_user_login` (`login_id`,`uid`,`login_time`,`is_login`,www,`type`) VALUES (:login_id,:uid,:login_time,1,:www,:type)');
                    $stmt->execute($params);
                }
                include_once $C_Patch . '/ip.php';
                global $mydata1_db;
                $ip_address = iconv('GB2312', 'UTF-8', convertip($client_ip));
                $params_ip = array(':uid' => $t_uid, ':username' => $username, ':ip' => $client_ip, ':ip_address' => $ip_address, ':www' => $_SERVER['HTTP_HOST']);
                $stmt_ip = $mydata1_db->prepare('insert into mydata3_db.history_login (`uid`,`username`,`ip`,`ip_address`,`login_time`,`www`) VALUES (:uid,:username,:ip,:ip_address,now(),:www)');
                $stmt_ip->execute($params_ip);
                $_SESSION['uid'] = $t_uid;
                $_SESSION['is_daili'] = $t_is_daili;
                $_SESSION['gid'] = $t_gid;
                $_SESSION['username'] = $username;
                $_SESSION['denlu'] = 'one';
                $_SESSION['user_login_id'] = $time . '_' . $t_uid . '_' . $username;
                $_SESSION['password'] = $passwrod;
                $_SESSION['modifyPwdTip'] = 'undo';
                $sql_c = 'select modify_pwd_c from web_config limit 1';
                $stmt_c = $mydata1_db->prepare($sql_c);
                $stmt_c->execute(NULL);
                $cycle = $stmt_c->fetchColumn();
                $_SESSION['modify_pwd_c'] = $cycle;
                $params_t = array(':modify_pwd_c' => $cycle, ':username' => $username);
                $sql_t = 'select if( TIMESTAMPDIFF(DAY,modify_pwd_t,now())>=:modify_pwd_c,"doit","undo") from k_user where username=:username limit 1';
                $stmt_t = $mydata1_db->prepare($sql_t);
                $stmt_t->execute($params_t);
                $temp_t = $stmt_t->fetchColumn();
                if (!$temp_t) {
                    $_SESSION['modifyPwdTip'] = 'undo';
                } else {
                    $_SESSION['modifyPwdTip'] = $temp_t;
                }
                return $t_uid;
            } else {
                return false;
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }


    static public function getinfo($uid)
    {
        $uid = intval($uid);
        if ($uid < 1) {
            return 0;
        } else {
            global $mydata1_db;
            $query = $mydata1_db->query('select * from k_user where uid=\'' . $uid . '\' limit 1');
            $t = $query->fetch();
            return $t;
        }
    }

    static public function getusername($uid)
    {
        $uid = intval($uid);
        if ($uid < 1) {
            return false;
        } else {
            global $mydata1_db;
            $query = $mydata1_db->query('select username from k_user where uid=\'' . $uid . '\' limit 1');
            return $query->fetchColumn();
        }
    }

    static public function update_pwd($uid, $oldpwd, $newpwd, $type = 'password')
    {
        global $mydata1_db;
        if ($type == 'qk_pwd') {
            $params = array(':new_qk_pwd' => md5($newpwd), ':birthday' => $newpwd, ':uid' => $uid, ':old_qk_pwd' => md5($oldpwd));
            $sql = 'update k_user set qk_pwd=:new_qk_pwd,birthday=:birthday where uid=:uid and qk_pwd=:old_qk_pwd';
        } else {
            $params = array(':new_pwd' => md5($newpwd), ':sex' => $newpwd, ':uid' => $uid, ':old_pwd' => md5($oldpwd));
            $sql = 'update k_user set password=:new_pwd,sex=:sex,modify_pwd_t=now() where uid=:uid and password=:old_pwd';
        }
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $q1 = $stmt->rowCount();
        if ($q1 == 1) {
            return true;
        } else {
            return false;
        }
    }

    static public function update_paycard($uid, $pay_card, $pay_num, $pay_address, $pay_name, $username)
    {
        global $mydata1_db;
        $params = array(':pay_card' => $pay_card, ':pay_num' => $pay_num, ':pay_address' => $pay_address, ':uid' => $uid);
        $sql = 'update k_user set pay_card=:pay_card,pay_num=:pay_num,pay_address=:pay_address where uid=:uid';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $q1 = $stmt->rowCount();
        $params = array(':uid' => $uid, ':username' => $username, ':pay_card' => $pay_card, ':pay_num' => $pay_num, ':pay_address' => $pay_address, ':pay_name' => $pay_name);
        $sql1 = 'insert into history_bank (uid,username,pay_card,pay_num,pay_address,pay_name) values (:uid,:username,:pay_card,:pay_num,:pay_address,:pay_name)';
        $stmt = $mydata1_db->prepare($sql1);
        $stmt->execute($params);
        $q2 = $stmt->rowCount();
        if (($q1 == 1) && ($q2 == 1)) {
            return true;
        } else {
            return false;
        }
    }

    static public function msg_add($uid, $from, $title, $info)
    {
        global $mydata1_db;
        $params = array(':uid' => $uid, ':msg_from' => $from, ':msg_title' => $title, ':msg_info' => $info);
        $sql = 'insert into k_user_msg(uid,msg_from,msg_title,msg_info) values (:uid,:msg_from,:msg_title,:msg_info)';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $q1 = $stmt->rowCount();
        if ($q1 == 1) {
            return true;
        } else {
            return false;
        }
    }

    static public function is_daili($uid)
    {
        $uid = intval($uid);
        global $mydata1_db;
        $query = $mydata1_db->query('select is_daili from k_user where uid=\'' . $uid . '\' and is_daili=1 limit 1');
        $is_daili = $query->fetchColumn();
        if ($is_daili == 1) {
            setcookie('is_daili', $uid, time() + (8 * 3600));
            return true;
        } else {
            setcookie('is_daili', '', time() - 3600, '/');
            return false;
        }
    }

    /*移动端判断*/
    static function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return 1;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? 1 : 0;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return 1;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return 1;
            }
        }
        return 0;
    }
}