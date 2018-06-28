<?php
session_start();
empty($_SESSION['adminid']) and die('Access Denied');
include_once 'common.php';
$act = $_GET['act'];
switch ($act) {
    case 'list':
        $data = getList();
        returnJson(200, $data);
        break;
    case 'change':
        $pay = $_GET['code'];
        $status = $_GET['status'] == 'true';

        $list = glob("*_pay");
        if(!in_array($pay,$list)) returnJson(201);
        changePay($pay, $status);
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
    global $NAME_ENUM;
    $list = glob("*_pay");
    $openList = [];
    $closeList = [];
    foreach ($list as $pay) {

        $info = json_decode(file_get_contents($pay . '/conf.json'), true);
        $template = file_get_contents($pay . '/template.php');
        preg_match_all('{{s_(.*?)}}', $template, $res);
        $conf = file_get_contents($pay . '/conf.php');
        $conf = json_decode(str_replace("<?php return;?>","",$conf), true);
        $channelList = [];
        unset($res[1][0]);
        foreach($res[1] as $v){
            if(! in_array($v, $conf['closeList']) || count($conf['closeList'])==0){
               $info['list'][] = $NAME_ENUM[$v];
            }
        }
        if(file_exists($pay . '/open')){
            $info['status'] = true;
            $openList[] = $info;
        }else{
            $info['status'] = false;
            $info['list'] = [];
            $closeList[] = $info;
        }
    }
    $payList = array_merge($openList,$closeList);
    return $payList;
}

function changePay($pay, $status)
{
    $db = new Db();
    $s = $status?'1':'0';
    $db->query('update pay_conf set status=:status where code=:code',['status'=>$s, 'code'=>$pay]);
    if($status){
        file_put_contents($pay . '/open','');
    }else{
        unlink($pay . '/open');
    }
}
