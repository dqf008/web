<?php
header('Content-Type: text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';

$rootPath = str_replace('\\', '/', dirname(dirname(dirname(__FILE__))));
$maxSize = 2*1024*1024; //文件最大尺寸，单位Byte
$allowFiles = array('.gif', '.png', '.jpg', '.jpeg', '.bmp'); //允许的文件格式
$savePath = '/static/uploads/'.date('Ymd/'); //文件保存路径

if(empty($_FILES)){
    echo 'error|请选择需要上传的文件';
}else{
    foreach($_FILES as $key=>$val){
        $val['ext'] = strrpos($val['name'], '.');
        if($val['ext']!==false){
            $val['ext'] = substr($val['name'], -1*(strlen($val['name'])-$val['ext']));
            $val['save'] = $savePath.time().$val['ext'];
        }
        switch (true) {
            case !isset($val['name'])||empty($val['name']):
                echo 'error|表单错误';
                break;

            case !in_array($val['ext'], $allowFiles):
                echo 'error|文件类型不正确';
                break;

            case $val['size']>$maxSize:
                echo 'error|文件超过上传限制';
                break;

            case !file_exists($rootPath.$savePath)&&!mkdir($rootPath.$savePath):
                echo 'error|创建文件夹失败';
                break;

            case !move_uploaded_file($val['tmp_name'], $rootPath.$val['save']):
                echo 'error|文件保存失败';
                break;

            default:
                echo $val['save'];
                break;
        }
    }
}