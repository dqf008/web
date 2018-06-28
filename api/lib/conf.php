<?php

class Conf
{
    private static $webId;
    private static $cjUrl;

    public function __construct()
    {

//        self::$webId = $site_id;
//        self::$cjUrl = $cj_url;
    }

    public static function WEB_ID()
    {
        require __DIR__ . '/../../cj/include/config.php';
        return $site_id;
    }

    public static function CJ_URL()
    {
        require __DIR__ . '/../../cj/include/config.php';
        return $cj_url;
    }

    public static function DB_CONF()
    {
        require __DIR__ . '/../../database/mysql.user.php';
        $conf['username'] = $db_user_utf8;
        $conf['passwd'] = $db_pwd_utf8;
        return $conf;
    }
}