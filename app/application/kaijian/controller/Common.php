<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/6/6
 * Time: 18:36
 */

namespace app\kaijian\controller;

use think\Controller;
use think\Request;
header("Content-type: text/html; charset=utf-8");
class Common extends Controller{
    public $time     = 0;
    public $datezone = "";
    public $timezone = "";
    public function _initialize(Request $request = null) {
        if(date_default_timezone_get() == "Etc/GMT+4"){
            $this->timezone = date("Y-m-d H:i:s",time()+43200);
            $this->datezone = date("Y-m-d",time()+43200);
            $this->time     = time()+43200;
        }else{
            $this->timezone = date("Y-m-d H:i:s",time());
            $this->datezone = date("Y-m-d",time());
            $this->time     = time();
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            $url = parse_url($_SERVER['HTTP_REFERER']);
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Allow-Origin: '.$url['scheme'].'://'.$url['host']);
            header('Access-Control-Expose-Headers: Set-Cookie');
        }
    }
}