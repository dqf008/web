<?php
require_once '../database/mysql.config.php';
if(empty($_POST)){
    exit('error');
}
get_auth_http($_POST);

global $mydata5_db;
$result = true;
if(isset($_POST['action']) && $_POST['action'] == 'mod') {
    $sql = " UPDATE aibo_close_game SET title=:title ,updatetime=:updatetime, status=:status, starttime=:starttime, endtime=:endtime WHERE id=:id  ";
    $startime = isset($_POST['starttime']) ? $_POST['startime'] : 0;
    $endtime = isset($_POST['endtime']) ? $_POST['endtime'] : 0;
    $stms = $mydata5_db->prepare($sql);
    file_put_contents('1.txt',$_POST);
    $result = $stms->execute(array(
        ':title' => $_POST['title'],
        ':updatetime' => $_POST['updatetime'],
        ':status' => $_POST['status'],
        ':starttime' => $startime,
        ':endtime' => $endtime,
        ':id' => $_POST['id'],
    ));
}elseif(isset($_POST['action']) && $_POST['action'] == 'select'){
     $sql = " SELECT * FROM aibo_close_game ";
     $game_list = array();
    foreach($mydata5_db->query($sql) as $k => $v){
        $game_list[$k]=$v;
    }
    if($game_list){
        $result = true;
        echo json_encode($game_list);
    }

    file_put_contents('game_list.txt',json_encode($game_list));

}

if($result){
    return;
}else{
    return 'error';
}


/**
 * 请求认证
 *
 * @param $post_data
 *
 * @param string $key 加密key
 */
function get_auth_http($post_data,$key = 'eaaaa2ce1b267d658550cabc81092'){
    if($post_data){
        $md5_str = $post_data['key'];
        ksort($post_data);
        unset($post_data['key']);
        $key_str  = '';
        foreach($post_data as $v){
            $key_str .= $v;
        }
        if($md5_str !== md5($key_str.$key)){
            die('auth fail!');
        }
    }
}

/**
 *
 * 获取IP请求地址
 *
 * @return string
 */
function get_client_ip(){
    $IP = '';
    if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $IP = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $IP = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $IP = getenv('REMOTE_ADDR');
     } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $IP = $_SERVER['REMOTE_ADDR'];
     }
     return $IP ? $IP : "unknow";
 }