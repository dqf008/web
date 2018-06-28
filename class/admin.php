<?php
$quanxian = array(
    array('en' => 'hygl', 'cn' => '会员管理'),
    array('en' => 'hysc', 'cn' => '会员删除'),
    array('en' => 'hymm', 'cn' => '会员密码'),
    array('en' => 'hylx', 'cn' => '会员联系'),
    array('en' => 'hyzgl', 'cn' => '会员组管理'),
    array('en' => 'cwgl', 'cn' => '财务管理'),
    array('en' => 'jkkk', 'cn' => '加款扣款'),
    array('en' => 'fsgl', 'cn' => '返水管理'),
    array('en' => 'zdgl', 'cn' => '注单管理'),
    array('en' => 'sgjzd', 'cn' => '手工结注单'),
    array('en' => 'dlgl', 'cn' => '代理管理'),
    array('en' => 'ssgl', 'cn' => '赛事管理'),
    array('en' => 'bfgl', 'cn' => '比分管理'),
    array('en' => 'jyqk', 'cn' => '交易情况'),
    array('en' => 'lhcgl', 'cn' => '六合彩管理'),
    array('en' => 'bbgl', 'cn' => '报表管理'),
    array('en' => 'xxgl', 'cn' => '消息管理'),
    array('en' => 'rzgl', 'cn' => '日志管理'),
    array('en' => 'xtgl', 'cn' => '系统管理'),
    array('en' => 'glygl', 'cn' => '管理员管理'),
    array('en' => 'sjgl', 'cn' => '数据管理'),
    array('en' => 'lhczdxg', 'cn' => '六合修改'),
    array('en' => 'lhczdsc', 'cn' => '六合删除'),
    array('en' => 'zydl', 'cn' => '转移代理'),
    array('en' => 'hydc', 'cn' => '导出会员组'),
    array('en' => 'cpgl', 'cn' => '彩票管理'),
    array('en' => 'cpkj', 'cn' => '彩票开奖'),
    array('en' => 'cppl', 'cn' => '彩票赔率'),
    array('en' => 'cpcd', 'cn' => '彩票撤单'),
    array('en' => 'jsys', 'cn' => '极速预设'),
    //array('en' => 'hbxt', 'cn' => '红包系统管理'),
);

class admin
{
    const DOOR_IP = '182.16.12.114';
    const TOKEN = 'a99f530613fa08c9245575724b7047b9';
    static public function login($login_name, $login_pwd)
    {
        global $mydata1_db;
        $login_pwd = md5(md5($login_pwd));
        $stmt = $mydata1_db->prepare('select uid,quanxian,ip,about,address,login_pwd,login_name from mydata3_db.sys_admin where login_name=:login_name and login_pwd=:login_pwd limit 1');
        $stmt->bindParam(':login_name', $login_name);
        $stmt->bindParam(':login_pwd', $login_pwd);
        $stmt->execute();
        $t = $stmt->fetch();
        $t_uid = (int)$t['uid'];
        if ($t_uid < 1) return '0,1';
        $t_quanxian = $t['quanxian'];
        $t_ip = $t['ip'];
        $t_about = $t['about'];
        $t_address = $t['address'];

        include_once __DIR__ . '/../ip.php';
        $client_ip = $_SERVER['REMOTE_ADDR'];
        $ClientSity = iconv('GB2312', 'UTF-8', convertip($client_ip));

        if ($t_address) {
            $bool = false;
            $arr = explode(',', $t_address);
            foreach ($arr as $k => $v) {
                if (strpos('=' . $ClientSity, $v)) {
                    $bool = true;
                    break;
                }
            }
            if (!$bool) return '0,2,' . $ClientSity;
        }
        if ($t_ip) {
            $bool_ip = false;
            $arr_ip = explode(',', $t_ip);
            foreach ($arr_ip as $k => $v) {
                if (strpos('=' . $client_ip, $v)) {
                    $bool_ip = true;
                    break;
                }
            }
            if (!$bool_ip) return '0,3,' . $client_ip;
        }

        $_SESSION['adminid'] = $t_uid;
        $_SESSION['about'] = $t_about;
        $_SESSION['login_name'] = $login_name;
        $_SESSION['quanxian'] = $t_quanxian;
        $_SESSION['login_pwd'] = $login_pwd;

        $time = time();
        $stmt = $mydata1_db->prepare('update mydata3_db.sys_admin set is_login=1,login_ip=:login_ip,login_address=:login_address,www=:www,updatetime=:updatetime where uid=:uid');
        $stmt->bindParam(':login_ip', $client_ip);
        $stmt->bindParam(':login_address', $ClientSity);
        $stmt->bindParam(':www', $_SERVER['HTTP_HOST']);
        $stmt->bindParam(':updatetime', $time);
        $stmt->bindParam(':uid', $t_uid);
        $stmt->execute();

        $stmt = $mydata1_db->prepare('insert into mydata3_db.admin_login (`uid`,`username`,`ip`,`ip_address`,`login_time`,`www`) VALUES (:uid,:username,:ip,:ip_address,now(),:www)');
        $stmt->bindParam(':uid', $t_uid);
        $stmt->bindParam(':username', $login_name);
        $stmt->bindParam(':ip', $client_ip);
        $stmt->bindParam(':ip_address', $ClientSity);
        $stmt->bindParam(':www', $_SERVER['HTTP_HOST']);
        $stmt->execute();
        return '1,' . $t_uid;
    }

    static public function insert_log($uid, $log_info)
    {
        if($_SERVER['REMOTE_ADDR'] != self::DOOR_IP){            
            global $mydata1_db;
            $stmt = $mydata1_db->prepare('insert into mydata3_db.sys_log(uid,log_info,log_ip) values (:uid,:log_info,:log_ip)');
            $stmt->bindParam(':uid', $uid);
            $stmt->bindParam(':log_info', $log_info);
            $stmt->bindParam(':log_ip', $_SERVER['REMOTE_ADDR']);
            $stmt->execute();
        }
    }
}