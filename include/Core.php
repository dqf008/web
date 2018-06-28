<?php
class Core
{
    public static function autoload($class)
    {
        $path = __DIR__ . '/../class/' . $class . '.class.php';
        if (file_exists($path)) require_once $path;
    }
}