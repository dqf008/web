<?php
/**
 * 连接数据库并返回连接句柄
 */

require_once __DIR__ . '/conf.php';

class DB extends PDO
{
    const MYDATA1_DB = 'mysql:host=127.0.0.1;dbname=mydata1_db';
    const MYDATA2_DB = 'mysql:host=127.0.0.1;dbname=mydata2_db';
    const MYDATA3_DB = 'mysql:host=127.0.0.1;dbname=mydata3_db';
    const MYDATA4_DB = 'mysql:host=127.0.0.1;dbname=mydata4_db';
    const MYDATA5_DB = 'mysql:host=127.0.0.1;dbname=mydata5_db';

    private static $_conn;
    private static $_options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8", PDO::ATTR_EMULATE_PREPARES => false);

    private static function _init($dsn)
    {
        $conf = Conf::DB_CONF();
        self::$_conn = new self($dsn, $conf['username'], $conf['passwd'], self::$_options);
    }

    /**
     * @param string $dsn
     * @return PDO
     */
    public static function CONN($dsn = DB::MYDATA1_DB)
    {
        if (!isset(self::$_conn)) {
            self::_init($dsn);
        }
        return self::$_conn;
    }
}