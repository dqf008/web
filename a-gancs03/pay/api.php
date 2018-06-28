<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once 'common.php';
$act = $_GET['act'];
switch ($act) {
    case 'list':
        $data = getList();
        returnJson(200, $data);
        break;
    case 'changeChannel':
        $pay = $_GET['pay'];
        $status = $_GET['status'];
        $channel = $_GET['channel'];
        if (changeChannel($pay, $channel, $status)) {
            returnJson(200);
        } else {
            returnJson(201);
        }
        break;
    case 'changePay':
        $pay = $_GET['pay'];
        changePay($pay);
        returnJson(200);
        break;
}

function returnJson($code, $data = '')
{
    $data = json_encode(['code' => $code, 'data' => $data]);
    die($data);
}

function traverseDir($dir)
{
    $dirList = [];
    if ($dir_handle = @opendir($dir)) {
        while ($filename = readdir($dir_handle)) {
            if ($filename != "." && $filename != "..") {
                $subFile = $dir . DIRECTORY_SEPARATOR . $filename; //要将源目录及子文件相连
                if (is_dir($subFile)) { //若子文件是个目录
                    $dirList[] = $filename;
                }
            }
        }
        closedir($dir_handle);
    }
    return $dirList;
}

function getList()
{
    $list = glob("*pay");
    $tmp = [];
    foreach ($list as $pay) {
        $conf = getDefaultConf($pay);
        $user_conf = getUserConf($pay);
        $info['code'] = $conf['pay_info']['code'];
        $info['path'] = $pay . '/';
        if (empty($user_conf)) {
            $info['status'] = 2;
            $info['list'] = [];
        } else {
            $info['status'] = $user_conf['status'];
            $info['list'] = $conf['pay_list'];
            foreach ($info['list'] as $k => $v) {
                $info['list'][$k]['open'] = in_array($v['code'], $user_conf['open']) ? 1 : 0;
            }
        }
        $info['name'] = $conf['pay_info']['name'];
        $tmp[$info['status']][] = $info;
    }
    $payList = [];
    if (count($tmp[1]) > 0) $payList = $tmp[1];
    if (count($tmp[0]) > 0) $payList = array_merge($payList, $tmp[0]);
    if (count($tmp[2]) > 0) $payList = array_merge($payList, $tmp[2]);
    return $payList;
}

function changeChannel($pay, $channel, $status)
{
    global $mydata1_db, $NAME_ENUM;
    $user_conf = getUserConf($pay);
    $conf = getDefaultConf($pay);
    $name = $NAME_ENUM[$channel];
    $params = array(':pay' => $conf['pay_info']['name'], ':channel' => $name);
    if ($status == 0) {
        $stmt = $mydata1_db->prepare("update pay_conf_info set `status`=1 where `pay`=:pay and `channel`=:channel");
        $stmt->execute($params);
        $user_conf['open'][] = $channel;
    } else {
        $stmt = $mydata1_db->prepare("update pay_conf_info set `status`=0 where `pay`=:pay and `channel`=:channel");
        $stmt->execute($params);
        foreach ($user_conf['open'] as $k => $v) {
            if ($v == $channel) unset($user_conf['open'][$k]);
        }
    }
    saveUserConf($pay, $user_conf);
    return true;
}

function changePay($pay)
{
    global $mydata1_db;
    $user_conf = getUserConf($pay);
    $conf = getDefaultConf($pay);
    if ($user_conf['status'] == 0) {
        $mydata1_db->exec('update pay_conf set `status`=1 where `name`="' . $conf['pay_info']['name'] . '"');
        $user_conf['status'] = 1;
        saveUserConf($pay, $user_conf);
    } else {
        $mydata1_db->exec('update pay_conf set `status`=0 where `name`="' . $conf['pay_info']['name'] . '"');
        $user_conf['status'] = 0;
        saveUserConf($pay, $user_conf);
    }
}
