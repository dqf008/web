<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('xtgl');
    header("Content-Type:text/html;charset=utf-8");
    //error_reporting( E_ERROR | E_WARNING );
    //date_default_timezone_set("Asia/chongqing");
    include "Uploader.class.php";

    $base64 = isset($_POST["base64"]) ? true:false;

    //上传配置
    $config = array(
        "savePath" => "upload/" ,             //存储文件夹
        "maxSize" => 1000 ,                   //允许的文件最大尺寸，单位KB
        "allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" )  //允许的文件格式
    );
    //上传文件目录
    $Path = str_replace('\\', '/', dirname(dirname(dirname(__FILE__))))."/static/uploads/";
    //背景保存在临时目录中
    $config[ "savePath" ] = $Path;
    $up = new Uploader("upfile", $config, $base64);
    $callback=$_GET['callback'];

    $info = $up->getFileInfo();
    $info['url'] = substr($info['url'], strlen($Path));
    /**
     * 返回数据
     */
    if($callback) {
        echo '<script>'.$callback.'('.json_encode($info).')</script>';
    } else {
        echo json_encode($info);
    }
?>