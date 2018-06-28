<?php
defined('API') or die('Access Denied');
function autoload($class){
    $path = __DIR__ . '/../class/live/' . $class . '.class.php';
    if (file_exists($path)) require_once $path;
    else die('{}');
}
spl_autoload_register('autoload');